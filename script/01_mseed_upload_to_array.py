#!/usr/bin/python3

from __future__ import print_function
import sys, getopt
import numpy as np
import obspy
import json
import pprint

mseed_file = sys.argv[1]
stream_mseed = obspy.read(mseed_file)



for tr in stream_mseed:
   if tr.stats.channel[-1] not in ["Z", "N", "E"]:
      stream_mseed.remove(tr)  

# merge all splited Chanel for same ID
stream_mseed.merge(method=1,fill_value='interpolate')

# print (stream_mseed.__str__(extended=True))
# print (len(stream_mseed))


datas_dict = {} #dictionary
channel_dict = {}
channels = [] #list


for i, tr in enumerate(stream_mseed):
   # file_open = open("%s_%s_%s" % ("out_file", tr.stats.station, tr.stats.channel), "w")
   #  f.write("# STATION %s\n" % (tr.stats.station))
   #  f.write("# CHANNEL %s\n" % (tr.stats.channel))
   #  f.write("# START_TIME %s\n" % (str(tr.stats.starttime)))
   #  f.write("# SAMP_FREQ %f\n" % (tr.stats.sampling_rate))
   #  f.write("# NDAT %d\n" % (tr.stats.npts))

   station_name= tr.stats.station
   channel_name= tr.stats.channel
   timestamp= np.around(np.array(tr.times("timestamp")), decimals=4)
   trace_data= np.around(np.array(tr.data), decimals=1)
   sample_rate= tr.stats.sampling_rate
   
   sample_delta= tr.stats.delta
   sample_npts= tr.stats.npts
   
   
   start_time= tr.stats.starttime
   end_time= tr.stats.endtime
   # combined_array= np.stack((timestamp, trace_data), axis=1)
   # np.savetxt(file_open, combined_array, fmt='%.3f', delimiter=',',newline='\n')
   # file_open.close()
  
   channels += [str(channel_name)]
   datas_dict[str(channel_name)] = {'sample_rate': sample_rate, 'sample_npts': sample_npts,'sample_delta': sample_delta,'start_time': str(start_time), 'end_time': str(end_time), 'sta_names': station_name, 'trace_data':trace_data.tolist()}
   
   # datas_dict["%s_%s" % ("startTime",  tr.stats.channel)] = str(start_time)
   # datas_dict["%s_%s" % ("timestamp",  tr.stats.channel)] = timestamp.tolist()
   # datas_dict["%s_%s" % ("traces",  tr.stats.channel)] = trace_data.tolist()

   # print(json.dumps({"%s_%s" % ("timestamp",  tr.stats.channel): timestamp.tolist()}))
   # print(json.dumps({"timestamp_js": timestamp.tolist()},separators=(',', ':')))
   # pprint.pprint(json.dumps({'timestamp_js': timestamp.tolist()}))
   # print (trace_data)


# print (stream_mseed.__str__(extended=True))

channel_dict["channels"] = channels
# option 2:
final_data = {**channel_dict, **datas_dict}
print(json.dumps(final_data))




sys.exit()


