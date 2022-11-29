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

#  python3 F:\laragon6\www\html\wave_picker\script\get_freq_dominan.py  MBPI.seed BHE  2022-10-15T01:49:00Z 2022-10-15T01:58:02Z
# $command = escapeshellcmd('python3 picker_with_arg.py '.$mseed_Content.' '.$ch_selectors.'  '.$input_starttime_frmt.' '.$input_endtime_frmt );

mseed_file = sys.argv[1]
ch_selectors = sys.argv[2]
# number_checked = int(sys.argv[3])
# freq_number = float(sys.argv[4])
# volt_number = float(sys.argv[5])
# const_number = float(sys.argv[6])
input_starttime_frmt = sys.argv[3]
input_endtime_frmt = sys.argv[4]

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

# Plotting
plt.plot(freqsssss, abs(fdom_Amplitude),   color='green', label="Peaks (tMax)")
plt.title('frequency-domain data \n amplitude spectrum')
plt.ylabel('amplitude')
# plt.xlim(0,0.12)

if max_x < 1 and max_x > 0:
    plt.xlim(left=0, right=(max_x*1.5))
    

io_container_bytes = io.BytesIO()
plt.savefig(io_container_bytes, format='png', transparent=True)
io_container_bytes.seek(0)
png_base64_data = base64.b64encode(io_container_bytes.read())




plt.close()




datas_dict = {} #dictionary
data_img = {} #dictionary






####################################################################
####################################################################


datas_dict["data_Streams"] = "%s_%s"  % (current_stream[0].stats.station, current_stream[0].stats.channel)
# datas_dict["data_peaks"] = max_y #ERROR Object of type complex128 is not JSON serializable
datas_dict["data_freqs_domain"] = max_x
data_img["img"] = png_base64_data.decode()
# option 2:
final_data = {**datas_dict, **data_img}
print(json.dumps(final_data))


sys.exit()


