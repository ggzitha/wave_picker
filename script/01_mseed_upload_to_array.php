<?php


    if(!empty($_FILES['file_mseed']))
    {
    // print_r($_FILES['file_mseed']);
    $mseed_Content = $_FILES['file_mseed']['tmp_name'];


    $command = escapeshellcmd('python3 01_mseed_upload_to_array.py '.$mseed_Content );
    $output = shell_exec($command);
    // print $output;
    $json = utf8_encode($output);

   

    header("Content-Type: application/json");
    echo $json;
    // echo "OK";
   
    }
?>