#!/usr/bin/python3

import sys
import json
import obspy
import numpy as np
import matplotlib
import matplotlib.pyplot as plt
from scipy.signal import argrelextrema
from obspy import UTCDateTime
import io
import base64

# Use a non-interactive backend
matplotlib.use('Agg')



# Exception classes for specific error handling
class InputError(Exception):
    pass

class FileError(Exception):
    pass

class ProcessingError(Exception):
    pass

# Utility function: count trailing zeros in a floating-point number
def num_of_zeros(n):
    s = '{:.16f}'.format(n).split('.')[1]
    return len(s) - len(s.lstrip('0')) + 1 if s.rstrip('0') else 0

# Utility function: find the closest value in a list
def closest_value_find(input_list, input_value):
    arr = np.asarray(input_list)
    return min(arr, key=lambda x: abs(x - input_value))

# Function to load and process MiniSEED file
def process_mseed(mseed_file, start_time, end_time, channel):
    try:
        stream = obspy.read(mseed_file, starttime=start_time, endtime=end_time)
        selected_stream = stream.select(channel=channel)
        if not selected_stream:
            raise FileError(f"No data for channel: {channel}")
        return selected_stream[0]
    except Exception as e:
        raise FileError(f"Error processing MiniSEED file: {e}")

# Function to perform FFT and find frequency domain information
def calculate_frequency_domain(stream):
    data = stream.data
    sampling_rate = stream.stats.sampling_rate
    delta = stream.stats.delta
    num_points = len(data)

    freq_range = 1. / (2. * delta)
    freq_values = np.linspace(0, freq_range, num_points // 2 + 1)
    amplitude = np.fft.rfft(data)

    max_amp = max(amplitude)
    max_freq = freq_values[amplitude.argmax()]

    return max_amp, max_freq, freq_values, amplitude

# Function to load parameters from JSON and find closest frequency
def load_parameters_and_find_freq(sensor_type, max_freq):
    try:
        with open('parameter_logger.json') as json_file:
            data = json.load(json_file)
            freq_list = data[sensor_type]['freq_list']
            closest_freq = closest_value_find(freq_list, max_freq)
            return closest_freq
    except Exception as e:
        raise FileError(f"Error loading JSON parameters: {e}")

# Function to plot the frequency domain and return base64 image
def plot_frequency_domain(freq_values, amplitude, max_freq, station, channel):
    plt.plot(freq_values, abs(amplitude), color='green', label="Peaks")
    plt.axvline(x=max_freq, color='blue', linestyle='dashed')
    plt.title(f'Frequency Domain {station}_{channel}')
    plt.ylabel('Amplitude')

    set_x_limits(max_freq)

    io_bytes = io.BytesIO()
    plt.savefig(io_bytes, format='png', transparent=True, dpi=100)  # Increase dpi To high quality def =100
    io_bytes.seek(0)
    plt.close()
    return base64.b64encode(io_bytes.read()).decode()

# Helper function to set x-axis limits based on frequency range
def set_x_limits(max_freq):
    limits = {
        (0, 0.02): (0.5, 1.5),
        (0.02, 0.1): (0.5, 1.5),
        (0.1, 0.5): (0.75, 1.2),
        (0.5, 2): (0.7, 1.3),
        (2, 5): (0.85, 1.15),
        (5, 7): (0.95, 1.05),
        (7, 10): (0.9, 1.15),
        (10, float('inf')): (0.9, 1.1)
    }
    for (min_val, max_val), (left_mult, right_mult) in limits.items():
        if min_val <= max_freq < max_val:
            plt.xlim(left=max_freq * left_mult, right=max_freq * right_mult)
            break

# Error response function
def error_response(error_message):
    return json.dumps({"error": error_message})

# Main function that orchestrates the process
def main():
    try:
        # Check if correct number of arguments are provided
        if len(sys.argv) != 6:
            raise InputError("Invalid number of arguments. Expected 5 arguments.")

        # Parse command-line arguments
        mseed_file = sys.argv[1]
        sensor_type = sys.argv[2]
        channel = sys.argv[3]
        start_time = UTCDateTime(sys.argv[4])
        end_time = UTCDateTime(sys.argv[5])

        # Process MiniSEED file and get stream data
        stream = process_mseed(mseed_file, start_time, end_time, channel)

        # Calculate frequency domain data
        max_amp, max_freq, freq_values, amplitude = calculate_frequency_domain(stream)

        # Get closest frequency from JSON parameters
        closest_freq = load_parameters_and_find_freq(sensor_type, max_freq)

        # Plot the frequency domain and get base64 image
        base64_img = plot_frequency_domain(freq_values, amplitude, max_freq, stream.stats.station, stream.stats.channel)

        # Prepare and return the final result as a JSON
        result = {
            "data_Streams": f"{stream.stats.station}_{stream.stats.channel}",
            "data_freqs_domain": {
                "raw": max_freq,
                "rounded": closest_freq
            },
            "img": base64_img
        }
    

        print(json.dumps(result))

    except InputError as e:
        print(json.dumps({"error": f"Input Error: {str(e)}"}))
    except FileError as e:
        print(json.dumps({"error": f"File Error: {str(e)}"}))
    except ProcessingError as e:
        print(json.dumps({"error": f"Processing Error: {str(e)}"}))
    except Exception as e:
        print(json.dumps({"error": f"Unexpected Error: {str(e)}"}))

if __name__ == "__main__":
    main()
