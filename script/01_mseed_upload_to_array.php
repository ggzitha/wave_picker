<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['Step01_MseedFile'])) {
    // Check for file upload errors
    if ($_FILES['Step01_MseedFile']['error'] !== UPLOAD_ERR_OK) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'File upload error.']);
        exit;
    }

    // Get the temporary file path
    $mseed_Content = escapeshellarg($_FILES['Step01_MseedFile']['tmp_name']);

    // Prepare the Python command
    $command = "python3 01_mseed_upload_to_array.py $mseed_Content";
    $output = shell_exec($command);

    // Fallback to Python 2 if Python 3 execution fails
    if (empty($output)) {
        $command = "python 01_mseed_upload_to_array.py $mseed_Content";
        $output = shell_exec($command);
    }

    // Ensure the output is clean
    $output = trim($output);

    // Check if the output is valid JSON
    $json = json_decode($output, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        // Output an error if the Python script's output is not valid JSON
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Invalid JSON output from Python script.']);
        exit;
    }

    // Output the result as JSON
    header('Content-Type: application/json');
    echo json_encode($json);
    // echo json_encode($json, JSON_PRETTY_PRINT);

} else {
    // Handle invalid requests
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Invalid request.']);
}

?>
