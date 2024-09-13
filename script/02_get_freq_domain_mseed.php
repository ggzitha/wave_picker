<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['Step02_MseedFile'])) {
    // Validate and decode input
    $ChannelSelected = isset($_POST['ChannelSelected']) ? json_decode($_POST['ChannelSelected'], true) : [];
    $DigitizerType = isset($_POST['DigitizerType']) ? json_decode($_POST['DigitizerType'], true) : null;
    $TimeDeltas = isset($_POST['TimeDeltas']) ? json_decode($_POST['TimeDeltas'], true) : null;

    // Validate required fields
    if (!$ChannelSelected || !$DigitizerType || !$TimeDeltas || !isset($TimeDeltas['starts'], $TimeDeltas['ends']) || $_FILES['Step02_MseedFile']['error'] !== UPLOAD_ERR_OK ) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Invalid input. Missing required parameters.']);
        exit;
    }

    $Input_Start_Time = escapeshellarg($TimeDeltas['starts']); // Example: 2024-09-01T04:07:04.500Z
    $Input_End_Time = escapeshellarg($TimeDeltas['ends']);     // Example: 2024-09-01T04:07:04.500Z
    $mseed_Content = escapeshellarg($_FILES['Step02_MseedFile']['tmp_name']); // Temporary file path

    $fetched_ch = ['channels' => $ChannelSelected];
    $fetched_rslt = [];

    // Loop through each selected channel
    foreach ($ChannelSelected as $ch_name) {
        $ch_name_escaped = escapeshellarg($ch_name);
        $DigitizerType_escaped = escapeshellarg($DigitizerType);

        // Prepare command
        $command = "python3 02_get_freq_domain_mseed.py $mseed_Content $DigitizerType_escaped $ch_name_escaped $Input_Start_Time $Input_End_Time";
        $output = shell_exec($command);

        // Fallback to another python command if first fails
        if (empty($output)) {
            $command_fallback = "python 02_get_freq_domain_mseed.py $mseed_Content $DigitizerType_escaped $ch_name_escaped $Input_Start_Time $Input_End_Time";
            $output = shell_exec($command_fallback);
        }

        // Parse the JSON result
        $json = json_decode($output, true);

        if ($json === null) {
            // Handle parsing errors or empty output
            $fetched_rslt[$ch_name] = ['error' => 'Failed to process channel: ' . $ch_name];
        } else {
            $fetched_rslt[$ch_name] = $json;
        }
    }

    // Merge and output results
    $resultss = json_encode(['data' => array_merge($fetched_ch, $fetched_rslt)]);
    // $resultss = json_encode(['data' =>array_merge($fetched_ch, $fetched_rslt)], JSON_PRETTY_PRINT);
    header("Content-Type: application/json");
    echo $resultss;
} else {
    // Handle errors
    echo json_encode(['error' => 'Invalid request or file missing']);
}

?>
