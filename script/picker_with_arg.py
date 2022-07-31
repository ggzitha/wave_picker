#!/usr/bin/python3

from __future__ import print_function
import sys, getopt
import json
import pprint
import obspy
import io
import base64

import numpy as np
import matplotlib.pyplot as plt
# from scipy import signal
# from scipy.signal import savgol_filter
from scipy.signal import argrelextrema
# from scipy.ndimage.filters import gaussian_filter1d
# from scipy.ndimage.filters import gaussian_filter
from obspy import read
from obspy import UTCDateTime
import pandas as pd



# $command = escapeshellcmd('python3 picker_with_arg.py '.$mseed_Content.' '.$ch_selectors.' '.$number_checked.' '.$freq_number.' '.$volt_number.' '.$const_number.' '.$input_starttime_frmt.' '.$input_endtime_frmt );

mseed_file = sys.argv[1]
ch_selectors = sys.argv[2]
number_checked = int(sys.argv[3])
freq_number = float(sys.argv[4])
volt_number = float(sys.argv[5])
const_number = float(sys.argv[6])
input_starttime_frmt = sys.argv[7]
input_endtime_frmt = sys.argv[8]


times = UTCDateTime(input_starttime_frmt)
endtimes = UTCDateTime(input_endtime_frmt)

# times = UTCDateTime("2022-06-20T09:15:02Z")
# endtimes = UTCDateTime("2022-06-20T09:15:35Z")

Konstanta_trilium_horizon = const_number
Channel_Selector = ch_selectors
number_checked = number_checked  # number of points to be checked before and after

stream_mseed = obspy.read(mseed_file, starttime=times, endtime=endtimes)
current_stream = stream_mseed.select(channel=Channel_Selector)


data_0 = current_stream[0].data

####################################################################
# PROSES PROSES PROSES PROSES PROSES PROSES PROSES PROSES PROSES
####################################################################
df = pd.DataFrame(data_0, columns=['data'])

df['min'] = df.iloc[argrelextrema(df.data.values, np.less_equal,
                    order=number_checked)[0]]['data']
df['max'] = df.iloc[argrelextrema(df.data.values, np.greater_equal,
                    order=number_checked)[0]]['data']

data_peaks = round((df['max'].dropna()))
data_valleys = round((df['min'].dropna()))


datas_dict = {} #dictionary
data_img = {} #dictionary


data_sensss = [] #list

for d_p, d_v in zip(data_peaks, data_valleys):
   
   Ampli_peakPeak =np.absolute(d_p)+np.absolute(d_v)
   Sensitivitys = Konstanta_trilium_horizon*Ampli_peakPeak*freq_number/volt_number
   # print (int(d_p),int(d_v), Sensitivitys)
   # datas_dict = {'data_peaks': int(d_p), 'data_valleys': int(d_v), 'data_sens': Sensitivitys}
   data_sensss += [ Sensitivitys ]
   

####################################################################
####################################################################


plt.scatter(df.index, df['max'], marker='o', linestyle='dashed', color='green', label="Peaks (tMax)")
plt.scatter(df.index, df['min'], marker='o', linestyle='dashed', color='red', label="Valleys (tMin)")
plt.plot(df.index, df['data'])
plt.legend()
plt.title("%s_%s"  % (current_stream[0].stats.station, current_stream[0].stats.channel))

io_container_bytes = io.BytesIO()
plt.savefig(io_container_bytes, format='png', transparent=True)
io_container_bytes.seek(0)
png_base64_data = base64.b64encode(io_container_bytes.read())
# print(png_base64_data)
# plt.savefig('tmp_img/data.png')
# plt.show()
plt.close()

# print(png_base64_data)

datas_dict["data_Streams"] = "%s_%s"  % (current_stream[0].stats.station, current_stream[0].stats.channel)
datas_dict["data_peaks"] = data_peaks.tolist()
datas_dict["data_valleys"] = data_valleys.tolist()
datas_dict["data_sensitivity"] = data_sensss
data_img["img"] = png_base64_data.decode()
# option 2:
final_data = {**datas_dict, **data_img}
print(json.dumps(final_data))


sys.exit()


