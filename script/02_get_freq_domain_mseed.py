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
# from scipy import signal
# from scipy.signal import savgol_filter
from scipy.signal import argrelextrema
# from scipy.ndimage.filters import gaussian_filter1d
# from scipy.ndimage.filters import gaussian_filter
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


def closest_value_find(input_list, input_value):
    arr = np.asarray(input_list)
    # round_to = [0,0.1,0.15,0.2,0.25]
    i = min(arr, key=lambda x: abs(x - input_value))
    return i
# cd script
#  python3 F:\laragon6\www\html\wave_picker\script\02_get_freq_domain_mseed.py  MBPI.seed Centaur BHE  2022-10-15T01:49:00Z 2022-10-15T01:58:02Z
# $command = escapeshellcmd('python3 picker_with_arg.py '.$mseed_Content.' '.$sensor_types.'  '.$ch_selectors.'  '.$input_starttime_frmt.' '.$input_endtime_frmt );

mseed_file = sys.argv[1]
sensor_types = sys.argv[2]
ch_selectors = sys.argv[3]
input_starttime_frmt = sys.argv[4]
input_endtime_frmt = sys.argv[5]

# fmin=.01,fmax=50 defaults === fmin=1.0, fmax=10.0
freq_input_min_to_plt = 0.01
freq_input_max_to_plt = 10.0

times = UTCDateTime(input_starttime_frmt)
endtimes = UTCDateTime(input_endtime_frmt)

# times = UTCDateTime("2022-06-20T09:15:02Z")
# endtimes = UTCDateTime("2022-06-20T09:15:35Z")

# Konstanta_trilium_horizon = const_number
Channel_Selector = ch_selectors
# number_checked = number_checked  # number of points to be checked before and after

stream_mseed = obspy.read(mseed_file, starttime=times, endtime=endtimes)
current_stream = stream_mseed.select(channel=Channel_Selector)


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



# Opening JSON file
with open('parameter_logger.json') as json_file:
    data_json = json.load(json_file)
    data_json_freqList = data_json[sensor_types]['freq_list']
    number_to_check = closest_value_find(data_json_freqList, max_x)
    
    # Print the type of data variable
    # print("Type:", type(data_json))
    
    # Print the data of dictionary
    # print("\nData_Parameter:", data_json[sensor_types])
    # print("\nData_Parameter:", number_to_check)
    # print("\Realss:", Rounded_max_x)








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
# aDict["data_freqs_domain"]["rounded"] = Rounded_max_x
aDict["data_freqs_domain"]["rounded"] = number_to_check
aDict["img"] = png_base64_data.decode()
print(json.dumps(aDict))


sys.exit()


