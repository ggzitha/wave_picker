<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['Step03_MseedFile'])) {

    // Validate and decode input parameters
    $ChannelSelected = json_decode($_POST['ChannelSelected'] ?? '[]', true);
    $TimeDeltas = json_decode($_POST['TimeDeltas'] ?? 'null', true);
    $CalibrateOpt = json_decode($_POST['CalibrateOption'] ?? 'null', true);

    // Check for missing or invalid parameters
    if (
        !$ChannelSelected || !$TimeDeltas || !$CalibrateOpt ||
        !isset($TimeDeltas['starts'], $TimeDeltas['ends']) ||
        !isset($CalibrateOpt['windowing'], $CalibrateOpt['voltage'], $CalibrateOpt['frequency'], $CalibrateOpt['constanta']) ||
        $_FILES['Step03_MseedFile']['error'] !== UPLOAD_ERR_OK
    ) {
        http_response_code(400); // Bad Request
        echo json_encode(['error' => 'Invalid input. Missing or incorrect required parameters.']);
        exit;
    }

    // Escape shell arguments
    $mseed_Content = escapeshellarg($_FILES['Step03_MseedFile']['tmp_name']);
    $Input_Start_Time = escapeshellarg($TimeDeltas['starts']);
    $Input_End_Time = escapeshellarg($TimeDeltas['ends']);
    $CalibrateWindow = escapeshellarg($CalibrateOpt['windowing']);
    $CalibrateVoltage = escapeshellarg($CalibrateOpt['voltage']);
    $CalibrateFrequency = escapeshellarg($CalibrateOpt['frequency']);
    $CalibrateConstant = escapeshellarg($CalibrateOpt['constanta']);

    $fetched_ch = ['channels' => $ChannelSelected];
    $fetched_rslt = [];
    $processes = []; // Store the processes
    $pipes = []; // Store pipes for process communication



    // Loop through each selected channel and start the Python script in parallel
    foreach ($ChannelSelected as $ch_name) {
        $ch_name_escaped = escapeshellarg($ch_name);

        // Prepare command
        $command = "python3 03_get_final_proccessed_mseed.py $mseed_Content $ch_name_escaped $CalibrateWindow $CalibrateFrequency $CalibrateVoltage $CalibrateConstant $Input_Start_Time $Input_End_Time";

        // Open process in non-blocking mode using popen
        $descriptorspec = [
            1 => ['pipe', 'w'],  // stdout
            2 => ['pipe', 'w']   // stderr
        ];
        $process = proc_open($command, $descriptorspec, $pipe);

        if (is_resource($process)) {
            $processes[$ch_name] = $process;
            $pipes[$ch_name] = $pipe;
        }
    }

    // Collect the results
    foreach ($processes as $ch_name => $process) {
        $pipe = $pipes[$ch_name];
        $output = stream_get_contents($pipe[1]);
        $error_output = stream_get_contents($pipe[2]);

        fclose($pipe[1]);
        fclose($pipe[2]);

        // Close the process
        proc_close($process);

        // Check the output and fallback to Python 2 if necessary
        if (empty($output)) {
            $command_fallback = "python 03_get_final_proccessed_mseed.py $mseed_Content $ch_name_escaped $CalibrateWindow $CalibrateFrequency $CalibrateVoltage $CalibrateConstant $Input_Start_Time $Input_End_Time";
            $output = shell_exec($command_fallback);
        }

        // Parse the JSON result
        $json = json_decode($output, true);

        if ($json === null) {
            // Handle parsing errors or empty output
            $fetched_rslt[$ch_name] = ['error' => 'Failed to process channel: ' . $ch_name . ' - ' . $error_output];
        } else {
            $fetched_rslt[$ch_name] = $json;
        }
    }


    // Merge channels and results into a final response
    $response = [
        'data' => array_merge($fetched_ch, $fetched_rslt)
    ];

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Handle invalid request or missing file
    http_response_code(400); // Bad Request
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Invalid request or file missing']);
    exit;
}
