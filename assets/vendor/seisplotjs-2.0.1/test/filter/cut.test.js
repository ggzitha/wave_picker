// @flow

import {SeismogramSegment, Seismogram} from '../../src/seismogram';
import  {moment, StartEndDuration} from '../../src/util';

test("simple seismogram cut", () => {
  let yValues = new Int32Array(100);
  let yValuesB = new Int32Array(10);
  let sampleRate = 1.0;
  let startTime = moment.utc('2019-01-01T10:00:00Z');
  let startTimeB = moment.utc(startTime).add(yValues.length, 'seconds');
  let netCode = "XX";
  let staCode = "ABCD";
  let locCode = "00";
  let chanCode = "BHZ";
  let seg = new SeismogramSegment(yValues, sampleRate, startTime);
  seg.networkCode = netCode;
  seg.stationCode = staCode;
  seg.locationCode = locCode;
  seg.channelCode = chanCode;
  let segB = seg.cloneWithNewData(yValuesB, startTimeB);
  let cutSeconds = 10;
  let cutBeginWindow = new StartEndDuration(startTime, null, cutSeconds);
  let cutSeg = seg.cut(cutBeginWindow);
  let cutSegB = segB.cut(cutBeginWindow);
  expect(cutSeg).not.toBeNull();
  expect(cutSegB).toBeNull();
  // for flow
  if ( ! cutSeg ) {throw new Error("cutSeg is null");}
  expect(seg.y.length).toEqual(yValues.length);
  expect(cutSeg.y.length).toEqual(cutSeconds+1);
  expect(cutSeg.yAtIndex(0)).toEqual(seg.yAtIndex(0));
  expect(cutSeg.sampleRate).toEqual(sampleRate);
  expect(cutSeg.startTime).toEqual(startTime);
  expect(cutSeg.netCode).toEqual(netCode);
  expect(cutSeg.staCode).toEqual(staCode);
  expect(cutSeg.locCode).toEqual(locCode);
  expect(cutSeg.chanCode).toEqual(chanCode);
  expect(cutSeg.numPoints).toEqual(cutSeconds+1);
  expect(cutSeg.timeOfSample(0).toISOString()).toEqual(startTime.toISOString());
  expect(seg.y.length).toEqual(yValues.length);

  let nearEndTime = moment.utc(seg.endTime).subtract(1, 'seconds');
  let cutEndWindow = new StartEndDuration(nearEndTime, null, cutSeconds);
  cutSeg = seg.cut(cutEndWindow);
  expect(cutSeg).not.toBeNull();
  // for flow
  if ( ! cutSeg ) {throw new Error("cutSeg is null");}
  expect(seg.y.length).toEqual(yValues.length);
  expect(cutSeg.y.length).toEqual(2);
  expect(cutSeg.startTime).toEqual(nearEndTime);
  expect(cutSeg.numPoints).toEqual(2);


  let seis = new Seismogram([seg, segB]);
  let cutSeis = seis.cut(cutBeginWindow);

  expect(cutSeis).not.toBeNull();
  // for flow
  if ( ! cutSeis ) {throw new Error("cutSeis is null");}

  expect(cutSeis.startTime).toEqual(cutBeginWindow.startTime);
  expect(cutSeis.numPoints).toEqual(cutSeconds+1);

  let shiftStart = moment.utc(startTime).add(1, 'seconds');
  let cutShiftWindow = new StartEndDuration(shiftStart, null, cutSeconds);
  let cutShiftSeis = seis.cut(cutShiftWindow);
  expect(cutShiftSeis).not.toBeNull();
  // for flow
  if ( ! cutShiftSeis ) {throw new Error("cutShiftSeis is null");}
  expect(cutShiftSeis.startTime).toEqual(cutShiftWindow.startTime);
  expect(cutShiftSeis.numPoints).toEqual(cutSeconds+1);

  shiftStart = moment.utc(seis.endTime).subtract(1, 'seconds');
  let cutSeisNearEndWindow = new StartEndDuration(shiftStart, null, cutSeconds);
  cutShiftSeis = seis.cut(cutSeisNearEndWindow);
  expect(cutShiftSeis).not.toBeNull();
  // for flow
  if ( ! cutShiftSeis ) {throw new Error("cutShiftSeis is null");}
  expect(cutShiftSeis.startTime).toEqual(cutSeisNearEndWindow.startTime);
  expect(cutShiftSeis.numPoints).toEqual(2);


  let bigStart = moment.utc(startTime).subtract(10, 'seconds');
  let cutBigWindow = new StartEndDuration(bigStart, null, seis.numPoints+1000);
  let cutBigSeis = seis.cut(cutBigWindow);
  expect(cutBigSeis).not.toBeNull();
  // for flow
  if ( ! cutBigSeis ) {throw new Error("cutShiftSeis is null");}
  expect(cutBigSeis.startTime).toEqual(seis.startTime);
  expect(cutBigSeis.numPoints).toEqual(seis.numPoints);

});
