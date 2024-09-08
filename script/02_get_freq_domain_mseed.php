<?php

if(!empty($_POST) && !empty($_FILES['thisss_mseed']))
{
    $ch_selectors = json_decode($_POST['ch_selectorsssss']);
    $sensor_types = json_decode($_POST['sensor_types']);
    $times_deltass = json_decode($_POST['times_deltas'], true);


    $input_starttime = $times_deltass['starts'];
    $input_endtime = $times_deltass['ends'];

    // $number_checked = $_POST['number_checked'];
    // $freq_number = $_POST['freq_number'];
    // $volt_number = $_POST['volt_number'];
    // $const_number = $_POST['const_number'];

    $start_dates = (new DateTime($_POST['thisss_startss_date']))->format('Y-m-d');
    $end_dates = (new DateTime($_POST['thisss_endd_date']))->format('Y-m-d');
    $input_starttime_frmt = $start_dates.'T'.$input_starttime.'Z';
    $input_endtime_frmt = $end_dates.'T'.$input_endtime.'Z';
   
   


//     print_r($_POST);
//     print_r($input_starttime);

// var_dump($_POST);
// die;


    $mseed_Content = $_FILES['thisss_mseed']['tmp_name'];



    $fetched_ch = array();
    $fetched_rslt = array();

    $fetched_ch['channels'] = $ch_selectors ;
    foreach($ch_selectors as $ch_name)
    {
   


    $output = shell_exec(escapeshellcmd('python3 02_get_freq_domain_mseed.py '.$mseed_Content.' '.$sensor_types.'  '.$ch_name.'  '.$input_starttime_frmt.' '.$input_endtime_frmt ));
    if (empty($output)) {
        // $command = escapeshellcmd('python 02_get_freq_domain_mseed.py '.$mseed_Content.' '.$sensor_types.'  '.$ch_name.'  '.$input_starttime_frmt.' '.$input_endtime_frmt );
        $output = shell_exec(escapeshellcmd('python 02_get_freq_domain_mseed.py '.$mseed_Content.' '.$sensor_types.'  '.$ch_name.'  '.$input_starttime_frmt.' '.$input_endtime_frmt ));
    }


    $json = json_decode($output);

    $fetched_rslt[$ch_name] = $json ;
    }
    
    
    $resultss = json_encode(array_merge($fetched_ch, $fetched_rslt));
    // header("Content-Type: application/json");
    // print_r ($json);
    print_r ($resultss);
    // echo json_encode($resultss);

}
else{
    echo "Error";
    // var_dump ($_POST);
}

?>