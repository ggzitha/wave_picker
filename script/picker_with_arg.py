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


"""
    ==================================================================================================
    DARI : from obspy.signal.tf_misfit import plot_tfr
    ==================================================================================================
"""
from obspy.imaging.cm import obspy_sequential, obspy_divergent
from obspy.signal import util
from matplotlib.ticker import NullFormatter


def _pcolormesh_same_dim(ax, x, y, v, **kwargs):
    # x, y, v must have the same dimension
    try:
        return ax.pcolormesh(x, y, v, shading='nearest', **kwargs)
    except TypeError:
        # matplotlib versions < 3.3
        return ax.pcolormesh(x, y, v[:-1, :-1], **kwargs)
    
def cwt(st, dt, w0, fmin, fmax, nf=100, wl='morlet'):
    npts = len(st) * 2
    tmax = (npts - 1) * dt
    t = np.linspace(0., tmax, npts)
    f = np.logspace(np.log10(fmin), np.log10(fmax), nf)

    cwt = np.zeros((npts // 2, nf), dtype=complex)

    if wl == 'morlet':

        def psi(t):
            return np.pi ** (-.25) * np.exp(1j * w0 * t) * \
                np.exp(-t ** 2 / 2.)

        def scale(f):
            return w0 / (2 * np.pi * f)
    else:
        raise ValueError('wavelet type "' + wl + '" not defined!')

    nfft = util.next_pow_2(npts) * 2
    sf = np.fft.fft(st, n=nfft)

    # Ignore underflows.
    with np.errstate(under="ignore"):
        for n, _f in enumerate(f):
            a = scale(_f)
            # time shift necessary, because wavelet is defined around t = 0
            psih = psi(-1 * (t - t[-1] / 2.) / a).conjugate() / np.abs(a) ** .5
            psihf = np.fft.fft(psih, n=nfft)
            tminin = int(t[-1] / 2. / (t[1] - t[0]))
            cwt[:, n] = np.fft.ifft(psihf * sf)[tminin:tminin + npts // 2] * \
                (t[1] - t[0])

    return cwt.T


def custom_MEE_plot_tfr(st, dt=0.01, t0=0., fmin=1., fmax=10., nf=100, w0=6, left=0.1,
             bottom=0.1, h_1=0.2, h_2=0.6, w_1=0.2, w_2=0.6, w_cb=0.01,
             d_cb=0.0, show=True, plot_args=['k', 'k'], clim=0.0,
             cmap=obspy_sequential, mode='absolute', fft_zero_pad_fac=0):
   

    npts = st.shape[-1]
    tmax = (npts - 1) * dt
    t = np.linspace(0., tmax, npts) + t0

    if fft_zero_pad_fac == 0:
        nfft = npts
    else:
        nfft = util.next_pow_2(npts) * fft_zero_pad_fac

    f_lin = np.linspace(0, 0.5 / dt, nfft // 2 + 1)

    if len(st.shape) == 1:
        _w = np.zeros((1, nf, npts), dtype=complex)
        _w[0] = cwt(st, dt, w0, fmin, fmax, nf)
        ntr = 1

        spec = np.zeros((1, nfft // 2 + 1), dtype=complex)
        spec[0] = np.fft.rfft(st, n=nfft) * dt

        st = st.reshape((1, npts))
    else:
        _w = np.zeros((st.shape[0], nf, npts), dtype=complex)
        spec = np.zeros((st.shape[0], nfft // 2 + 1), dtype=complex)

        for i in np.arange(st.shape[0]):
            _w[i] = cwt(st[i], dt, w0, fmin, fmax, nf)
            spec[i] = np.fft.rfft(st[i], n=nfft) * dt

        ntr = st.shape[0]

    if mode == 'absolute':
        _tfr = np.abs(_w)
        spec = np.abs(spec)
    elif mode == 'power':
        _tfr = np.abs(_w) ** 2
        spec = np.abs(spec) ** 2
    else:
        raise ValueError('mode "' + mode + '" not defined!')

    figs = []

    for itr in np.arange(ntr):
        fig = plt.figure()

        # plot signals
        ax_sig = fig.add_axes([left + w_1, bottom, w_2, h_1])
        ax_sig.plot(t, st[itr], plot_args[0])

        # plot TFR
        ax_tfr = fig.add_axes([left + w_1, bottom + h_1, w_2, h_2])

        x, y = np.meshgrid(
            t, np.logspace(np.log10(fmin), np.log10(fmax),
                           _tfr[itr].shape[0]))
        img_tfr = _pcolormesh_same_dim(ax_tfr, x, y, _tfr[itr], cmap=cmap)
        img_tfr.set_rasterized(True)
        ax_tfr.set_yscale("log")
        ax_tfr.set_ylim(fmin, fmax)
        ax_tfr.set_xlim(t[0], t[-1])

        # plot spectrum
        ax_spec = fig.add_axes([left, bottom + h_1, w_1, h_2])
        ax_spec.semilogy(spec[itr], f_lin, plot_args[1])

        # add colorbars
        ax_cb_tfr = fig.add_axes([left + w_1 + w_2 + d_cb + w_cb, bottom +
                                  h_1, w_cb, h_2])
        fig.colorbar(img_tfr, cax=ax_cb_tfr)

        # set limits
        ax_sig.set_ylim(st.min() * 1.1, st.max() * 1.1)
        ax_sig.set_xlim(t[0], t[-1])

        xlim = spec.max() * 1.1

        ax_spec.set_xlim(xlim, 0.)
        ax_spec.set_ylim(fmin, fmax)

        if clim == 0.:
            clim = _tfr.max()

        img_tfr.set_clim(0., clim)

        ax_sig.set_xlabel('time')
        ax_spec.set_ylabel('frequency')

        # remove axis labels
        ax_tfr.xaxis.set_major_formatter(NullFormatter())
        ax_tfr.yaxis.set_major_formatter(NullFormatter())

        figs.append(fig)

    if show:
        
        io_container_bytes_spectogrm = io.BytesIO()
        plt.savefig(io_container_bytes_spectogrm, format='png', transparent=True)
        io_container_bytes_spectogrm.seek(0)
        plt.show()
        plt.close()
        return base64.b64encode(io_container_bytes_spectogrm.read())
    else:
        if ntr == 1:
            return figs[0]
        else:
            return figs



"""
    ==================================================================================================
    DARI : from obspy.signal.tf_misfit import plot_tfr
    ==================================================================================================
"""










# $command = escapeshellcmd('python3 picker_with_arg.py '.$mseed_Content.' '.$ch_selectors.' '.$number_checked.' '.$freq_number.' '.$volt_number.' '.$const_number.' '.$input_starttime_frmt.' '.$input_endtime_frmt );

mseed_file = sys.argv[1]
ch_selectors = sys.argv[2]
number_checked = int(sys.argv[3])
freq_number = float(sys.argv[4])
volt_number = float(sys.argv[5])
const_number = float(sys.argv[6])
input_starttime_frmt = sys.argv[7]
input_endtime_frmt = sys.argv[8]

# fmin=.01,fmax=50 defaults === fmin=1.0, fmax=10.0
freq_input_min_to_plt = 0.01
freq_input_max_to_plt = 10.0

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
freq_data_0 = current_stream[0].stats.sampling_rate #sampling rate buat per gelombang
len_data_0 = current_stream[0].stats.npts #Banyaknya data di dalam signal Atau dengan ==> len(data_0) 
deltas_data_0 = current_stream[0].stats.delta #delta 1/frequensi sampling dalam signal




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
data_img_spectogrm = {} #dictionary


data_sensss = [] #list

for d_p, d_v in zip(data_peaks, data_valleys):
   
   Ampli_peakPeak =np.absolute(d_p)+np.absolute(d_v)
   Sensitivitys = Konstanta_trilium_horizon*Ampli_peakPeak*freq_number/volt_number
   # print (int(d_p),int(d_v), Sensitivitys)
   # datas_dict = {'data_peaks': int(d_p), 'data_valleys': int(d_v), 'data_sens': Sensitivitys}
   data_sensss += [ Sensitivitys ]
   

####################################################################
####################################################################

# PLOT SPECTOGRAM
png_base64_data_spectogrm = custom_MEE_plot_tfr(data_0, dt=deltas_data_0, fmin=freq_input_min_to_plt,fmax=freq_input_max_to_plt, w0=8., nf=64, fft_zero_pad_fac=4 )


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
data_img_spectogrm["img_spectogrm"] = png_base64_data_spectogrm.decode()
# option 2:
final_data = {**datas_dict, **data_img, **data_img_spectogrm}
print(json.dumps(final_data))


sys.exit()


