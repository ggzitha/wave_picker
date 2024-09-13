#!/usr/bin/python3

import sys
import json
import numpy as np
import obspy

def main():
    # Check if the correct number of arguments is provided
    if len(sys.argv) != 2:
        print("Usage: process_miniseed.py <miniseed_file>")
        sys.exit(1)

    mseed_file = sys.argv[1]

    try:
        # Read the MiniSEED file
        stream_mseed = obspy.read(mseed_file)

        # Filter out unwanted channels
        for tr in stream_mseed:
            if tr.stats.channel[-1] not in ["Z", "N", "E"]:
                stream_mseed.remove(tr)

        # Merge all split channels for the same ID
        stream_mseed.merge(method=1, fill_value='interpolate')

        # Prepare data for JSON output
        datas_dict = {}
        channel_dict = {'channels': []}

        for tr in stream_mseed:
            station_name = tr.stats.station
            channel_name = tr.stats.channel
            # timestamp = np.around(np.array(tr.times("timestamp")), decimals=4)
            # trace_data = np.around(np.array(tr.data), decimals=1)
            timestamp = tr.times("timestamp")
            trace_data = tr.data
            sample_rate = tr.stats.sampling_rate
            sample_delta = tr.stats.delta
            sample_npts = tr.stats.npts
            start_time = str(tr.stats.starttime)
            end_time = str(tr.stats.endtime)

            channel_dict['channels'].append(channel_name)
            datas_dict[channel_name] = {
                'sample_rate': sample_rate,
                'sample_npts': sample_npts,
                'sample_delta': sample_delta,
                'start_time': start_time,
                'end_time': end_time,
                'station_name': station_name,
                'trace_data': trace_data.tolist()
            }

        # Combine dictionaries and print as JSON
        final_data = {**channel_dict, **datas_dict}
        json_data = {
            "data": final_data
        }
        print(json.dumps(json_data))
        sys.exit()

    except Exception as e:
        error_responses(f"Error processing MiniSEED file: {str(e)}")
        sys.exit(1)

def error_responses(message):
    error_data = {
        "error": message
    }
    print(json.dumps(error_data))

if __name__ == "__main__":
    main()