#!/usr/bin/python3

from __future__ import print_function
import sys, getopt
import json
import pprint
import obspy
import io
import base64
import math


import numpy as np
import matplotlib.pyplot as plt
from scipy.signal import argrelextrema
from obspy import read
from obspy import UTCDateTime
import pandas as pd

def num_of_zeros(n):
  s = '{:.16f}'.format(n).split('.')[1]
  ss = len(s) - len(s.lstrip('0'))
  if ss > 0 :
      ss = ss+1
  elif len(s.rstrip('0')) > 0:
      ss = ss+1
  return ss

#  first cd script or CWD to script folder
#  python3 F:\laragon6\www\html\wave_picker\script\01_mseeds_auto_picker.py  MBPI.seed BHE  2022-10-15T01:49:00Z 2022-10-15T01:58:02Z
# $command = escapeshellcmd('python3 picker_with_arg.py '.$mseed_Content.' '.$ch_selectors.'  '.$input_starttime_frmt.' '.$input_endtime_frmt );

mseed_file = sys.argv[1]
ch_selectors = sys.argv[2]
input_starttime_frmt = sys.argv[3]
input_endtime_frmt = sys.argv[4]


times = UTCDateTime(input_starttime_frmt)
endtimes = UTCDateTime(input_endtime_frmt)


# Konstanta_trilium_horizon = const_number
Channel_Selector = ch_selectors

# stream_mseed = obspy.read(mseed_file, starttime=times, endtime=endtimes)
stream_mseed = obspy.read(mseed_file)
current_stream = stream_mseed.select(channel=Channel_Selector)

rawws = current_stream.copy()
tr_new = current_stream.copy()


rawws.merge(method=0, fill_value=None, interpolation_samples=0)
tr_new.merge(method=1, fill_value='interpolate', interpolation_samples=-1)




# current_stream.plot()

# fig = plt.figure()
# ax = fig.add_subplot(1, 1, 1)
# ax.plot(raws[0].times("matplotlib"), raws[0].data, color="green")

# ax.plot(current_stream[0].times("matplotlib"), current_stream[0].data, color="red")
# ax.xaxis_date()
# fig.autofmt_xdate()



plt.plot(rawws[0].times("matplotlib"), rawws[0].data, 'r', label='RAW', alpha=0.35)
plt.plot(tr_new[0].times("matplotlib"), tr_new[0].data, 'b', label='interpolated', alpha=0.35)
plt.legend()
plt.show()


sys.exit()







data_0 = current_stream[0].data
freq_data_0 = current_stream[0].stats.sampling_rate #sampling rate buat per gelombang
len_data_0 = current_stream[0].stats.npts #Banyaknya data di dalam signal Atau dengan ==> len(data_0) 
deltas_data_0 = current_stream[0].stats.delta #delta 1/frequensi sampling dalam signal







# Menghitung rentang frequency (untuk plot sumbu x)
Freqqss = 1. / (2. * deltas_data_0)                     
freqsssss = np.linspace(0, Freqqss, len_data_0 // 2 + 1)

# FFT untuk nilai amplitudo (sumbu y)
fdom_Amplitude = np.fft.rfft(data_0)


max_y = max(fdom_Amplitude)  # Find the maximum y value
max_x = freqsssss[fdom_Amplitude.argmax()]  # Find the x value corresponding to the maximum y value







# cari Jumlah 0 di belakang koma
numberOfZeros = num_of_zeros(max_x)


Rounded_max_x = round(max_x, numberOfZeros)
# Rounded_max_x = math.ceil(max_x*pow(10,numberOfZeros))/pow(10,numberOfZeros)



# Plotting
plt.plot(freqsssss, abs(fdom_Amplitude),   color='green', label="Peaks (tMax)")
plt.axvline(x=max_x,   color='blue', linestyle='dashed')
plt.title('frequency-domain %s_%s' % (current_stream[0].stats.station, current_stream[0].stats.channel))
plt.ylabel('amplitude')


# plt.xlim(0,0.12)
if max_x < 0.02 and max_x >= 0: 
    plt.xlim(left=(max_x*0.5), right=(max_x*1.5))
elif max_x < 0.1 and max_x >= 0.02:
    plt.xlim(left=(max_x*0.5), right=(max_x*1.5))
elif max_x < 0.5 and max_x >= 0.1:
    plt.xlim(left=(max_x*0.75), right=(max_x*1.2))
elif max_x < 2 and max_x >= 0.5:
    plt.xlim(left=(max_x*0.7), right=(max_x*1.3))
elif max_x < 5 and max_x >= 2:
    plt.xlim(left=(max_x*0.85), right=(max_x*1.15))
elif max_x < 7 and max_x >= 5:
    plt.xlim(left=(max_x*0.95), right=(max_x*1.05))
elif max_x < 10 and max_x >= 7:
    plt.xlim(left=(max_x*0.9), right=(max_x*1.15))
elif  max_x >= 10:
    plt.xlim(left=(max_x*0.9), right=(max_x*1.1))
     
    


io_container_bytes = io.BytesIO()
plt.savefig(io_container_bytes, format='png', transparent=True)
io_container_bytes.seek(0)
png_base64_data = base64.b64encode(io_container_bytes.read())




plt.close()



# Dictionary ternyata seperti Json, Hanya butuh intialisasi saja
aDict = {   "data_Streams": None,
            "data_freqs_domain": {
                "raw": None,
                "rounded": None
            },
            "img": None
            }




####################################################################
####################################################################


aDict["data_Streams"] = "%s_%s"  % (current_stream[0].stats.station, current_stream[0].stats.channel)
aDict["data_freqs_domain"]["raw"] = max_x
aDict["data_freqs_domain"]["rounded"] = Rounded_max_x
# aDict["img"] = png_base64_data.decode()
print(json.dumps(aDict))


sys.exit()


