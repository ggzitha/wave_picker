#!/usr/bin/python3

from __future__ import print_function
import sys
import json
import obspy
import io
import base64
import numpy as np
import matplotlib
import matplotlib.pyplot as plt
from scipy.signal import argrelextrema
from obspy import UTCDateTime
import pandas as pd
from matplotlib.ticker import NullFormatter

# Use a non-interactive backend
matplotlib.use('Agg')
viridisXX = matplotlib.colormaps.get_cmap('viridis')



# Custom exceptions for error handling
class InputError(Exception):
    pass

class ProcessingError(Exception):
    pass

class PlotError(Exception):
    pass

# Utility function to find the next power of two
def next_pow_2(i):
    return int(2 ** np.ceil(np.log2(i)))

# Utility function for plotting spectrogram with CWT
def _pcolormesh_same_dim(ax, x, y, v, **kwargs):
    try:
        return ax.pcolormesh(x, y, v, shading='nearest', **kwargs)
    except TypeError:
        return ax.pcolormesh(x, y, v[:-1, :-1], **kwargs)


def format_time_axis(start_time, end_time, num_ticks):
    """
    Format X-axis time labels between start_time and end_time for a given number of ticks.
    """
    time_range = end_time - start_time
    time_intervals = np.linspace(0, time_range, num_ticks)  # Generate equally spaced time intervals
    return [UTCDateTime(start_time + interval).strftime('%H:%M:%S') for interval in time_intervals]



# Continuous Wavelet Transform (CWT) function
def cwt(data_stream, dt, w0, fmin, fmax, nf=100, wl='morlet'):
    npts = len(data_stream) * 2
    tmax = (npts - 1) * dt
    t = np.linspace(0., tmax, npts)
    f = np.logspace(np.log10(fmin), np.log10(fmax), nf)
    cwt_result = np.zeros((npts // 2, nf), dtype=complex)
    def psi(t):
        return np.pi ** (-.25) * np.exp(1j * w0 * t) * np.exp(-t ** 2 / 2.)
    def scale(f):
        return w0 / (2 * np.pi * f)
    nfft = next_pow_2(npts) * 2
    sf = np.fft.fft(data_stream, n=nfft)
    for n, _f in enumerate(f):
        a = scale(_f)
        psih = psi(-1 * (t - t[-1] / 2.) / a).conjugate() / np.abs(a) ** .5
        psihf = np.fft.fft(psih, n=nfft)
        tminin = int(t[-1] / 2. / (t[1] - t[0]))
        cwt_result[:, n] = np.fft.ifft(psihf * sf)[tminin:tminin + npts // 2] * (t[1] - t[0])
    return cwt_result.T

# Main plotting function for custom TFR and return base64 image
def custom_MEE_plot_tfr(Streams, t0=0., fmin=0.01, fmax=15., nf=100, w0=8., plot_args=['k', 'k'], clim=0.0, mode='absolute', fft_zero_pad_fac=0):
   
    data_rawTFR = Streams.data
    deltas_rawTFR = Streams.stats.delta if Streams.stats.delta else 0.01
    
    npts = data_rawTFR.shape[-1]
    tmax = (npts - 1) * deltas_rawTFR
    t = np.linspace(0., tmax, npts) + t0

    #nfft refers to the number of points used for the Fast Fourier Transform (FFT)
    #npts refers to the number of data points in the signal
    nfft = npts if fft_zero_pad_fac == 0 else next_pow_2(npts) * fft_zero_pad_fac
    
    f_lin = np.linspace(0, 0.5 / deltas_rawTFR, nfft // 2 + 1)

    if len(data_rawTFR.shape) == 1:
        _w = np.zeros((1, nf, npts), dtype=complex)
        _w[0] = cwt(data_rawTFR, deltas_rawTFR, w0, fmin, fmax, nf)
        ntr = 1

        spec = np.zeros((1, nfft // 2 + 1), dtype=complex)
        spec[0] = np.fft.rfft(data_rawTFR, n=nfft) * deltas_rawTFR

        data_rawTFR = data_rawTFR.reshape((1, npts))
    else:
        _w = np.zeros((data_rawTFR.shape[0], nf, npts), dtype=complex)
        spec = np.zeros((data_rawTFR.shape[0], nfft // 2 + 1), dtype=complex)

        for i in np.arange(data_rawTFR.shape[0]):
            _w[i] = cwt(data_rawTFR[i], deltas_rawTFR, w0, fmin, fmax, nf)
            spec[i] = np.fft.rfft(data_rawTFR[i], n=nfft) * deltas_rawTFR

        ntr = data_rawTFR.shape[0]

    if mode == 'absolute':
        _tfr = np.abs(_w)
        spec = np.abs(spec)
    elif mode == 'power':
        _tfr = np.abs(_w) ** 2
        spec = np.abs(spec) ** 2

    figs = []

    for itr in np.arange(ntr):
        fig = plt.figure()

      
        # Draw Image Power Spectral TFR
        ax_tfr = fig.add_axes([0.1 + 0.2, 0.1 + 0.2, 0.6, 0.6])

        x, y = np.meshgrid( t, np.logspace(np.log10(fmin), np.log10(fmax), _tfr[itr].shape[0]))
        img_tfr = _pcolormesh_same_dim(ax_tfr, x, y, _tfr[itr], cmap=viridisXX)
        img_tfr.set_rasterized(True)
        ax_tfr.set_yscale("log")
        ax_tfr.set_ylim(fmin, fmax)
        ax_tfr.set_xlim(t[0], t[-1])
        # add colorbars
        ax_cb_tfr = fig.add_axes([0.1 + 0.2 + 0.6 + 0.0 + 0.01, 0.1 + 0.2, 0.01, 0.6])
        fig.colorbar(img_tfr, cax=ax_cb_tfr)

        xlim = spec.max() * 1.1

        if clim == 0.:
            clim = _tfr.max()

        img_tfr.set_clim(0., clim)

        # remove axis labels At Drawed Viridis
        ax_tfr.xaxis.set_major_formatter(NullFormatter())
        ax_tfr.yaxis.set_major_formatter(NullFormatter())


         # Draw Freq Domain at side
        ax_spec = fig.add_axes([0.1, 0.1 + 0.2, 0.2, 0.6])
        ax_spec.semilogy(spec[itr], f_lin, plot_args[1])
        ax_spec.set_xlim(xlim, 0.)
        ax_spec.set_ylim(fmin, fmax)
        ax_spec.set_ylabel('Frequency')
        
        
        # plot Waveform signals At The bottom's
        
        
        Bottom_Wave = fig.add_axes([0.1 + 0.2, 0.1, 0.6, 0.2])
        Bottom_Wave.plot(t, data_rawTFR[itr], plot_args[0])
        # set limits
        Bottom_Wave.set_ylim(data_rawTFR.min() * 1.1, data_rawTFR.max() * 1.1)
        Bottom_Wave.set_xlim(t[0], t[-1])
        # Add tick labels X-ticks with formatted time
        time_labels = format_time_axis(Streams.stats.starttime, Streams.stats.endtime, 8)
        Bottom_Wave.set_xticks(np.linspace(t[0], t[-1], 8), time_labels, rotation=15, fontsize=6)
        Bottom_Wave.set_xlabel("Time's")
        
        
        figs.append(fig)

    
    io_container_bytes_spectogrm = io.BytesIO()
    plt.savefig(io_container_bytes_spectogrm, format='png', transparent=True, dpi=200)  # Increase dpi To high quality def =100
    io_container_bytes_spectogrm.seek(0)
    # plt.show()
    plt.close()
    return base64.b64encode(io_container_bytes_spectogrm.read())


# Extract peaks, valleys, and sensitivity
def process_peaks_valley(Stream_0, number_checked, freq, volt, const):
    
    data_raw = Stream_0.data
    df = pd.DataFrame(data_raw, columns=['data'])
    
    df['min'] = df.iloc[argrelextrema(df.data.values, np.less_equal, order=number_checked)[0]]['data']
    df['max'] = df.iloc[argrelextrema(df.data.values, np.greater_equal, order=number_checked)[0]]['data']

    peaks = df['max'].dropna().round()
    valleys = df['min'].dropna().round()

    sensitivities = [const * (abs(p) + abs(v)) * freq / volt for p, v in zip(peaks, valleys)]
    
    # Get the formatted times for the X-axis
    time_labels = format_time_axis(Stream_0.stats.starttime, Stream_0.stats.endtime, 12)
    
    # Scatter plot for peaks and valleys
    plt.scatter(df.index, df['max'], marker='^', linestyle='dashed', color='green', alpha=0.4, label="Peaks (tMax)")
    plt.scatter(df.index, df['min'], marker='v', linestyle='dashed', color='red', alpha=0.4, label="Valleys (tMin)")
    plt.plot(df.index, df['data'])
    # Add labels and legend
    plt.title(f"{Stream_0.stats.station}_{Stream_0.stats.channel}")
    plt.xlabel("Time's")  # Label for the X-axis (time)
    plt.ylabel('Amplitude')  # Label for the Y-axis (amplitude)
    plt.legend()
    # Set custom X-ticks with formatted time
    plt.xticks(np.linspace(df.index.min(), df.index.max(), 12), time_labels, rotation=25, fontsize=6)
    # Disable scientific notation on the Y-axis and use real values
    # plt.ticklabel_format(style='plain', axis='y')  # Use plain style for Y-axis to avoid scientific notation
    io_container_bytes = io.BytesIO()
    plt.savefig(io_container_bytes, format='png', transparent=True, dpi=200)  # Increase dpi To high quality def =100
    io_container_bytes.seek(0)
    IMG_Result_base64 = base64.b64encode(io_container_bytes.read()).decode()
    plt.close()
    
    return peaks.tolist(), valleys.tolist(), sensitivities, IMG_Result_base64




# Error handling function
def error_response(error_message):
    return json.dumps({"error": error_message})

# Main function to execute the processing
def main():
    try:
        # Check if correct number of arguments are provided
        if len(sys.argv) != 9:
            raise InputError("Invalid number of arguments. Expected 8 arguments.")

        # Parse command-line arguments
        mseed_file = sys.argv[1]
        ch_selectors = sys.argv[2]
        number_checked = int(sys.argv[3])
        freq_number = float(sys.argv[4])
        volt_number = float(sys.argv[5])
        const_number = float(sys.argv[6])
        input_starttime_frmt = sys.argv[7]
        input_endtime_frmt = sys.argv[8]

        freq_input_min_to_plt = 0.01
        freq_input_max_to_plt = 10.0

        # Load the mseed file and select the channel
        times = UTCDateTime(input_starttime_frmt)
        endtimes = UTCDateTime(input_endtime_frmt)
        stream_mseed = obspy.read(mseed_file, starttime=times, endtime=endtimes)
        current_stream = stream_mseed.select(channel=ch_selectors)

        if not current_stream:
            raise ProcessingError(f"No data available for channel: {ch_selectors}")

         # Extract data from the stream
        Stream_0 = current_stream[0]
        
        # Process peaks and valleys And Img of those
        data_peaks, data_valleys, data_sensss, IMG_Result_base64 = process_peaks_valley(Stream_0, number_checked, freq_number, volt_number, const_number)
            
        # Generate spectrogram plot
        png_base64_data_spectogrm = custom_MEE_plot_tfr(Stream_0, fmin=freq_input_min_to_plt, fmax=freq_input_max_to_plt, fft_zero_pad_fac=4)


        # Construct the result dictionary
        datas_dict = {
            "data_Streams": f"{current_stream[0].stats.station}_{current_stream[0].stats.channel}",
            "data_peaks": data_peaks,
            "data_valleys": data_valleys,
            "data_sensitivity": data_sensss,
            "img": IMG_Result_base64,
            "img_spectogrm": png_base64_data_spectogrm.decode()
        }
        # Convert result to JSON string
        json_result = json.dumps(datas_dict)
        
        print(json_result)

    except InputError as e:
        print(error_response(f"Input Error: {str(e)}"))
    except ProcessingError as e:
        print(error_response(f"Processing Error: {str(e)}"))
    except PlotError as e:
        print(error_response(f"Plot Error: {str(e)}"))
    except Exception as e:
        print(error_response(f"Unexpected Error: {str(e)}"))

if __name__ == "__main__":
    main()
