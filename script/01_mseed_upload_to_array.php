<?php


    if(!empty($_FILES['file_mseed']))
    {
    // print_r($_FILES['file_mseed']);
    $mseed_Content = $_FILES['file_mseed']['tmp_name'];


    $output = shell_exec(escapeshellcmd('python3 01_mseed_upload_to_array.py '.$mseed_Content ));
    if (empty($output)) {
        $output = shell_exec(escapeshellcmd('python 01_mseed_upload_to_array.py '.$mseed_Content ));
    }

    // $command = escapeshellcmd('python -V');
    // $output = shell_exec($command);
    // print $output;
    // echo $output;

    // $json = utf8_encode($output); //Deprecated sejak lama
    $json = mb_convert_encoding($output, 'UTF-8', 'ISO-8859-1');


    header("Content-Type: application/json");
    echo $json;
    // echo "OK";
   
    }
?>