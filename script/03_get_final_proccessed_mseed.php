<?php

if(!empty($_POST) && !empty($_FILES['current_mseed_file']))
{
    $ch_selectors = json_decode($_POST['ch_selectors']);
    $input_starttime = $_POST['input_starttime'];
    $input_endtime = $_POST['input_endtime'];

    $number_checked = $_POST['number_checked'];
    $freq_number = $_POST['freq_number'];
    $volt_number = $_POST['volt_number'];
    $const_number = $_POST['const_number'];

    $current_date = (new DateTime($_POST['current_date']))->format('Y-m-d');
    $input_starttime_frmt = $current_date.'T'.$input_starttime.'Z';
    $input_endtime_frmt = $current_date.'T'.$input_endtime.'Z';
   
   
    $mseed_Content = $_FILES['current_mseed_file']['tmp_name'];




   
    $fetched_ch = array();
    $fetched_rslt = array();

    $fetched_ch['channels'] = $ch_selectors ;
    foreach($ch_selectors as $ch_name)
    {
   

   $command = escapeshellcmd('python3 03_get_final_proccessed_mseed.py '.$mseed_Content.' '.$ch_name.' '.$number_checked.' '.$freq_number.' '.$volt_number.' '.$const_number.' '.$input_starttime_frmt.' '.$input_endtime_frmt );
    $output = shell_exec($command);
    $json = json_decode($output);

    $fetched_rslt[$ch_name] = $json ;
    }
    
    
    $resultss = json_encode(array_merge($fetched_ch, $fetched_rslt));
    header("Content-Type: application/json");
    // print_r ($json);
    print_r ($resultss);
    // echo json_encode($resultss);

}
else{
    echo "Error";
    // var_dump ($_POST);
}

?>