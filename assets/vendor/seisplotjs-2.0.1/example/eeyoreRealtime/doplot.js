// @flow
//
// this global comes from the seisplotjs_seedlink standalone js
let seedlink = seisplotjs.seedlink

// this global comes from the seisplotjs_waveformplot standalone js
let d3 = seisplotjs.d3;
let moment = seisplotjs.moment;
let miniseed = seisplotjs.miniseed;
const SeismographConfig = seisplotjs.seismographconfig.SeismographConfig;
const Seismograph = seisplotjs.seismograph.Seismograph;

seisplotjs.RSVP.on('error', function(reason) {
  console.assert(false, reason);
});

let net = 'CO';
let staList = ['BIRD', 'C1SC', 'CASEE', 'CSB', 'HAW', 'HODGE', 'JSC', 'PAULI', 'SUMMV', 'TEEBA'];
d3.select('#stationChoice')
  .selectAll("option")
  .data(staList)
  .enter()
    .append("option")
    .text(function(d) {return d;});

let timerInProgress = false;
let clockOffset = 0; // should get from server somehow
let duration = 300;
let maxSteps = -1; // max num of ticks of the timer before stopping, for debugin
let timeWindow = new seisplotjs.util.StartEndDuration(null, null, duration, clockOffset);
let protocol = 'http:';
if ("https:" == document.location.protocol) {
  protocol = 'https:'
}
let wsProtocol = 'ws:';
if (protocol == 'https:') {
  wsProtocol = 'wss:';
}

//
// Note: currently rtserve.iris does not support wss, and so this will
// not work from https pages as you cannot use non-encrypted (ws)
// loaded from a https web page
//
let IRIS_HOST = "rtserve.iris.washington.edu";
let EEYORE_HOST = "eeyore.seis.sc.edu";
let EEYORE_PORT = 6383;
let host = IRIS_HOST;
let port = 80;
host=EEYORE_HOST;
port=EEYORE_PORT;
let seedlinkUrl = wsProtocol+"//"+host+(port==80?'':':'+port)+'/seedlink';
console.log("URL: "+seedlinkUrl);


d3.selectAll('.textHost').text(host);


let slConn = null;
let allSeisPlots = new Map();
let allSeismograms = new Map();
let svgParent = d3.select('div.realtime');
let margin = {top: 20, right: 20, bottom: 50, left: 60};

let paused = false;
let stopped = false;
let numSteps = 0;

let dataBuffer = [];

d3.select("button#load").on("click", function(d) {
  let selectEl = document.getElementById("stationChoice");
  let selectedIndex = selectEl.selectedIndex;
  let staCode = selectEl.options[selectedIndex].value;

  console.log("Load..."+staCode);
  allSeisPlots.clear();
  allSeismograms.clear();
  doplot(staCode);
});

doplot = function(sta) {
  if (slConn) {slConn.close(); slConn = null;}
  doDisconnect(false);
  doPause(false);
  console.log("do plot, timeWindow: "+timeWindow.startTime+" "+timeWindow.endTime);

  d3.selectAll('.textStaCode').text(sta);
  d3.selectAll('.textNetCode').text(net);

  let config = [
    'STATION '+sta+' '+net,
    'SELECT 00HH?.D',
    'STATION '+sta+' '+net,
    'SELECT 00HN?.D' ];


  console.log("before select");
  svgParent.selectAll("*").remove();

  allSeisPlots.clear();
  allSeismograms.clear();

  if (wsProtocol == 'wss:' && host == IRIS_HOST) {
    svgParent.append("h3").attr('class', 'waitingondata').text("IRIS currently does not support connections from https pages, try from a http page instead.");
  } else {
    svgParent.append("p").attr('class', 'waitingondata').text("waiting on first data");
  }

  slConn = new seedlink.SeedlinkConnection(seedlinkUrl, config, slp => {
    try {
      callbackFn(slp);
    } catch(err) {
      console.assert(false, err);
      console.error(err);
    }
  }, errorFn);
  slConn.setTimeCommand(timeWindow.startTime);
  slConn.setOnClose( closeEvent => {
    console.log(`doplot: Received webSocket close: ${closeEvent.code} ${closeEvent.reason}`);
    stopped = true;
    d3.select("button#disconnect").text("Reconnect");
  });
  slConn.connect();
};


let callbackFn = function(slPacket) {
  dataBuffer.push(slPacket);
  setTimeout(processDataBuffer, 0);
}
let processDataBuffer = function() {
  let dataBufCopy = dataBuffer;
  dataBuffer = [];
  dataBufCopy.forEach(slp => processPacket(slp));
}
let processPacket = function(slPacket) {
  let codes = slPacket.miniseed.codes();
  //console.log("seedlink: seq="+slPacket.sequence+" "+codes);
  let seismogram = miniseed.createSeismogramSegment([slPacket.miniseed]);
  if (allSeisPlots.has(codes) && allSeismograms.has(codes)) {
    const oldSeismogramData = allSeismograms.get(codes);
    const oldSeismogram = oldSeismogramData.seismogram;
    oldSeismogram.append(seismogram);
    const littleBitLarger = {'startTime': moment.utc(timeWindow.startTime).subtract(60, 'second'),
                            'endTime': moment.utc(timeWindow.endTime).add(180, 'second')};
    const newSeismogram = oldSeismogram.trim(littleBitLarger);
    if (newSeismogram) {
      oldSeismogramData.seismogram = newSeismogram;
      allSeisPlots.get(codes).calcAmpScaleDomain();
    } else {
      // trim removed all data, nothing left in window
      allSeismograms.delete(codes);
      allSeisPlots.get(codes).remove(oldSeismogramData);
      console.log(`All data removed from trace ${codes}`);
    }
//      allSeisPlots.get(codes).trim(timeWindow);
  } else {
    svgParent.selectAll("p.waitingondata").remove();
    // try to insert in alpha order by codes
    console.log(`allSeisPlots ${allSeisPlots.size} keys: ${Array.from(allSeisPlots.keys()).join(' ')}`);
    let allAfterCodes = Array.from(allSeisPlots.keys()).filter(c => c > codes);
    let afterIndex = 1+ Array.from(allSeisPlots.keys()).findIndex(c => c > codes);
    let seisDiv;
    if (allAfterCodes.length > 0) {
    console.log(`"allAfterCodes[0] ${allAfterCodes[0]}  >  ${codes}`);
      let afterSelection = svgParent.select(`div[codes="${allAfterCodes[0]}"]`).node();

      console.log(`div[codes="${allAfterCodes[0]}"]`)
      console.log(`insert index: :nth-child(${afterIndex})   codes: ${codes}`)
      seisDiv = svgParent.insert('div', `:nth-child(${afterIndex})`);
    } else {
      console.log(`afterAll size 0  ${codes}`)
      seisDiv = svgParent.append('div');
    }
    seisDiv.attr('class', codes);
//    seisDiv.append('p').text(codes);
    let plotDiv = seisDiv.append('div').attr('class', 'realtimePlot');
    plotDiv.style("position", "relative");
    plotDiv.style("width", "100%");
    plotDiv.style("height", "150px");
    let trace = new seisplotjs.seismogram.Seismogram(seismogram);
    let seisPlotConfig = new SeismographConfig();
    seisPlotConfig.fixedTimeScale = timeWindow;
    seisPlotConfig.xSublabel = codes;
    seisPlotConfig.margin = margin ;
    seisPlotConfig.wheelZoom = false ;
    if (codes.charAt(codes.length-2) === 'H' || codes.charAt(codes.length-2) === 'N') {
      // seismic H or strong motion N channels
    } else {
      seisPlotConfig.doRMean = false ;
      seisPlotConfig.doGain = false;
    }
    let seisData = seisplotjs.seismogram.SeismogramDisplayData.fromSeismogram(trace);
    let seisPlot = new Seismograph(plotDiv, seisPlotConfig, seisData);
    seisPlot.svg.classed('realtimePlot', true).classed('overlayPlot', false)
    seisPlot.draw();
    allSeisPlots.set(codes, seisPlot);
    allSeismograms.set(codes, seisData);
  }
}

d3.select("button#pause").on("click", function(d) {
  doPause( ! paused);
});

d3.select("button#disconnect").on("click", function(d) {
  doDisconnect( ! stopped);
});

let doPause = function(value) {
  paused = value;
  if (paused) {
    d3.select("button#pause").text("Play");
  } else {
    d3.select("button#pause").text("Pause");
  }
}

let doDisconnect = function(value) {
  stopped = value;
  if (stopped) {
    if (slConn) {slConn.close();}
    d3.select("button#disconnect").text("Reconnect");
  } else {
    if (slConn) {slConn.connect();}
    d3.select("button#disconnect").text("Disconnect");
  }
}

let timerInterval = (timeWindow.endTime.valueOf()-timeWindow.startTime.valueOf())/
                    (parseInt(svgParent.style("width"))-margin.left-margin.right);
                    console.log("start time with interval "+timerInterval);
while (timerInterval < 100) { timerInterval *= 2;}
let timer = d3.interval(function(elapsed) {
  if ( paused || timerInProgress) {
    return;
  }
  timerInProgress = true;
  if ( allSeisPlots.size > 1) {
    numSteps++;
    if (maxSteps > 0 && numSteps > maxSteps ) {
      console.log("quit after max steps: "+maxSteps);
      timer.stop();
      slConn.close();
    }
  }
  timeWindow = new seisplotjs.util.StartEndDuration(null, null, duration, clockOffset);
  //console.log("reset time window for "+timeWindow.startTime+" "+timeWindow.endTime );
  window.requestAnimationFrame(timestamp => {
    try {
      allSeisPlots.forEach(function(value, key) {
          value.seismographConfig.fixedTimeScale = timeWindow;
          value.calcTimeScaleDomain();
          value.draw();
          //console.log(`${key} tw: ${value.xScale.domain()}  width: ${value.width}  xScale range: ${value.xScale.range()}`);
      });
      timerInProgress = false;
    } catch(err) {
      console.assert(false, err);
    }
  });

}, timerInterval);

let errorFn = function(error) {
  console.assert(false, error);
  d3.select("p#error").text("Error: "+error);
};
