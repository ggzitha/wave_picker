<?php
ob_start();
session_start();

$self_url = $_SERVER['PHP_SELF'];

$random1 = 'secret_key1';
$random2 = 'secret_key2';

$logins_usr_PW_pairs = array(
  'inskal' => 'inskal',
  'admin' => 'admin',
  'user' => 'user',
  'mee' => 'qwertyuiop'
);

$hash = md5($random1 . $random2);

if (isset($_GET['logout'])) {
  unset($_SESSION['Logged_Datas']);
  header("Location: $self_url");
}


function display_login_form()
{
  global $self_url;
  echo <<<HTML_LOGIN

  <div id="login_container" class="viewss bg_globs">
   <div class="container h-100 d-flex justify-content-center align-items-center">
   <div class="col-md-5 col-sm-12 px-0">
    <div class="card" style="background-color: #ffffff6b !important;">
     <div class="header blue lighten-2 ">
      <div class="row d-flex justify-content-center">
       <h2 class=" white-text mt-4 mb-4 ">Log-in </h2>
      </div>
     </div>

     <div class="card-body mx-4 mt-4">
      <form action="$self_url" method='POST'>
       <div class="md-form">
        <input type="text" id="username" name="username" class="form-control">
        <label class="active" for="username">UserName</label>
       </div>

       <div class="md-form pb-3">
        <input type="password" id="password" name="password" class="form-control">
        <label class="active" for="password">Password</label>
       </div>

       <div class="text-center mb-4">
        <button class="btn btn-default btn-rounded" name="submit" value="submit" type="submit">Log-In<i class="fa-solid fa-paper-plane white-text ml-2"></i></i></button>
       </div>
       

      </form>
     </div>
    </div>
    </div>
   </div>
  </div>

  HTML_LOGIN;

  // <div class="text-center mb-4">
  //       user dan PW : <br>
  //       &nbsp;&nbsp;user::user<br>
  //       &nbsp;&nbsp;admin::admin
  //      </div>
}



?>






<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

<head>
  <meta charset="UTF-8">
  <title>The Wave</title>
  <meta name="author" content="ggzitha">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, shrink-to-fit=no">


  <link rel="stylesheet" type="text/css" href="assets/vendor/mdbootstrap_4_mee/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="assets/vendor/mdbootstrap_4_mee/css/mdb.min.css">
  <link rel="stylesheet" type="text/css" href="assets/vendor/mdbootstrap_4_mee/css/style.css">
  <link rel="stylesheet" type="text/css" href="assets/vendor/mdbootstrap_4_mee/plugins/MDB-File-Upload/css/addons/mdb-file-upload.css">
  <link rel="stylesheet" type="text/css" href="assets/vendor/fontawesomePro/css/all.min.css">
  <link rel="stylesheet" href="assets/vendor/sweetalert2-11.4.24/sweetalert2.css" />

  <link href="images/icon/favicon.png" rel="shortcut icon">


  <link rel="stylesheet" href="assets/vendor/mee_loader/loader_rocket.css">
  <link rel="stylesheet" href="assets/vendor/mee_loader/loader_bear.css">
  <link rel="stylesheet" href="assets/vendor/mee_loader/loader_wave.css">

  <link rel="stylesheet" href="assets/vendor/lightbox2/css/lightbox.css">

  <style>
    html,
    body,
    header,
    .viewss {
      height: 100vh;
    }

    .bg_globs {
      background-image: url("images/bg/bg.jpg");
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center center;
    }

    .rs-tooltip-text {
      font-weight: 400 !important;
      font-size: 25pt !important;
    }

    .rs-path,
    .rs-range {
      stroke-dasharray: 2 5;
    }

    .rs-handle-dot-inner {
      padding: 28%;
    }


    .scrollbar-light-blue::-webkit-scrollbar-track {
      background-color: #F5F5F5;
      border-radius: 10px;
    }

    .scrollbar-light-blue::-webkit-scrollbar {
      width: 12px;
      background-color: #F5F5F5;
    }

    .scrollbar-light-blue::-webkit-scrollbar-thumb {
      background-color: #82B1FF;
      border-radius: 10px;
      box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
      -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
      background-image: -webkit-linear-gradient(330deg, #f093fb 0%, #f5576c 100%);
      background-image: linear-gradient(120deg, #f093fb 0%, #f5576c 100%);
    }

    .scrollbar-light-blue {
      scrollbar-color: #82B1FF #F5F5F5;
    }


    .chromeframe {
      margin: 0.2em 0;
      background: #ccc;
      color: #000;
      padding: 0.2em 0;
    }

    #Load_01_Mseed_wrapper {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 2000;
      background: #00000099;
    }

    #Load_02_MseedParams_wrapper {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 2000;
      background: #00000099;
    }

    #Load_02_MseedParams_wrapper .mt-3.text-center {
      position: relative;
      margin-bottom: 0% !important;
      padding-bottom: 0% !important;
      margin-top: 25% !important;
    }

    #Load_03_BearPicking_wrapper {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 2000;
      background: #00000099;
    }

    #Load_00_NoChannel_wrapper {
      z-index: 2000;
      position: relative;
      width: 100%;
      height: 100%;
      background: #fff;
    }



    #input_starttime:disabled,
    .md-form>#input_starttime:disabled+label {
      opacity: 0.2;
    }

    #input_endtime:disabled,
    .md-form>#input_endtime:disabled+label {
      opacity: 0.2;
    }


    #ch_selectors:disabled,
    .md-form>#ch_selectors:disabled+label {
      opacity: 0.2;
    }

    #Windowing_ParamsValue:disabled,
    .md-form>#Windowing_ParamsValue:disabled+label {
      opacity: 0.2;
    }

    #Frequency_ParamsValue:disabled,
    .md-form>#Frequency_ParamsValue:disabled+label {
      opacity: 0.2;
    }

    #Voltage_ParamsValue:disabled,
    .md-form>#Voltage_ParamsValue:disabled+label {
      opacity: 0.2;
    }

    #Constanta_ParamsValue:disabled,
    .md-form>#Constanta_ParamsValue:disabled+label {
      opacity: 0.2;
    }

    /* Tick Dark Themess Fixxx */
    .darktheme .picker__box .picker__calendar-container .clockpicker-plate .clockpicker-tick.grey-text.disabled {
      color: #535353 !important;
    }

    .scroll-content {
      position: relative;
      overflow-y: scroll;
      height: 200px;
    }

    .img-thumbnail {
      padding: .25rem;
      background-color: #ffffff00;
      border: 0px solid #dee2e6;
      border-radius: .25rem;
      max-width: 100%;
      height: auto;
    }

    .btn.btn-rounded.purple-gradient-mee.waves-effect.waves-light.active::before {
      content: "✅";
    }

    .btn.btn-rounded.purple-gradient-mee.waves-effect.waves-light::before {
      /* content: "☑️"; */
      content: "";
    }

    .purple-gradient-mee {
      background: linear-gradient(45deg, #ff6ec447, #7873f545) !important;
      color: black;
      text-transform: capitalize;
      font-weight: 600;
    }



    .purple-gradient-mee:not([disabled]):not(.disabled):active,
    .purple-gradient-mee:not([disabled]):not(.disabled).active,
    .show>.purple-gradient-mee.dropdown-toggle {
      background: linear-gradient(0deg, #ff009773, #b1aff4a1) !important;
      color: #fff;
      font-weight: 900;
      box-shadow: rgb(243, 25, 229) 0px 1px 2px 0px, rgb(208, 55, 205) 0px 2px 6px 2px;
    }





    /* Start Button */
    .green-gradient-mee {
      background: linear-gradient(90deg, #b6ec4073, #d2b02a63) !important;
      color: black;
      text-transform: capitalize;
      font-weight: 600;
    }


    .green-gradient-mee:not([disabled]):not(.disabled):active,
    .green-gradient-mee:not([disabled]):not(.disabled).active,
    .show>.green-gradient-mee.dropdown-toggle {
      background: linear-gradient(0deg, #7eec40ad, #c5dd1d47) !important;
      color: #000;
      font-weight: 900;
      box-shadow: rgb(38, 113, 16) 0px 1px 2px 0px, rgb(14, 130, 26) 0px 2px 6px 2px;
    }

    .btn.btn-rounded.green-gradient-mee.waves-effect.waves-light.active::before {
      content: "☑️";
    }

    .btn.btn-rounded.green-gradient-mee.waves-effect.waves-light::before {
      /* content: "☑️"; */
      content: "";
    }

    /* Start Button */

    /* Quit Button */

    .grey-gradient-mee {
      background: linear-gradient(90deg, #abaea4e8, #06060663) !important;
      color: #c6b9b9;
      text-transform: capitalize;
      font-weight: 600;
    }

    .grey-gradient-mee:not([disabled]):not(.disabled):active,
    .grey-gradient-mee:not([disabled]):not(.disabled).active,
    .show>.grey-gradient-mee.dropdown-toggle {
      background: linear-gradient(0deg, #1c1c1cf5, #aaaaaa47) !important;
      color: #f00;
      font-weight: 900;
      box-shadow: rgb(85, 81, 81) 0px 1px 2px 0px, rgb(6, 6, 6) 0px 2px 6px 2px;
    }

    /* Quits Button */

    /* End Button */
    .red-gradient-mee {
      background: linear-gradient(90deg, #ec404082, #f4090963) !important;
      color: black;
      text-transform: capitalize;
      font-weight: 600;
    }


    .red-gradient-mee:not([disabled]):not(.disabled):active,
    .red-gradient-mee:not([disabled]):not(.disabled).active,
    .show>.red-gradient-mee.dropdown-toggle {
      background: linear-gradient(0deg, #d28d42e8, #ec1616ab) !important;
      color: #fff;
      font-weight: 900;
      box-shadow: rgb(208, 11, 11) 0px 1px 2px 0px, rgb(213, 56, 20) 0px 2px 6px 2px;
    }



    .btn.btn-rounded.red-gradient-mee.waves-effect.waves-light.active::before {
      content: "✅";
    }

    .btn.btn-rounded.red-gradient-mee.waves-effect.waves-light::before {
      /* content: "☑️"; */
      content: "";
    }

    /* End Button */


    .swall_borders {
      border: 2px solid red;
      --borderWidth: 3px;
      background: #1D1F20;
      position: relative;
      border-radius: 1em;

    }

    .swall_borders::after {
      content: '';
      position: absolute;
      top: calc(-1 * var(--borderWidth));
      left: calc(-1 * var(--borderWidth));
      height: calc(100% + var(--borderWidth) * 2);
      width: calc(100% + var(--borderWidth) * 2);
      background: linear-gradient(60deg, #f79533, #f37055, #ef4e7b, #a166ab, #5073b8, #1098ad, #07b39b, #6fba82);
      border-radius: calc(2 * var(--borderWidth));
      z-index: -1;
      animation: animatedgradient 3s ease alternate infinite;
      background-size: 300% 300%;
    }

    @keyframes animatedgradient {
      0% {
        background-position: 0% 50%;
      }

      50% {
        background-position: 100% 50%;
      }

      100% {
        background-position: 0% 50%;
      }
    }


    .swall_borders_timers {
      height: 0.25em;
      background: rgba(255, 0, 0, 1);
    }


    .mee_offside_footer {
      position: fixed;
      bottom: -95px;
      right: 0%;
      margin: 0px;
      padding: 5px;
      z-index: 9999999;
      line-height: 10px;
      font-size: 10px;
      min-width: 100%;
    }




    input[type=radio] {
      display: none;
    }

    input[type=radio]:not(:disabled)~label {
      cursor: pointer;
    }

    input[type=radio]:disabled~label {
      color: #bcc2bf;
      border-color: #bcc2bf;
      box-shadow: none;
      cursor: not-allowed;
    }

    input[type=radio]:hover+label {
      border: 2px solid #20df80;
      /* box-shadow: 0px 0px 10px rgba(0, 255, 128, 0.25); */
      transform: translateY(-4%);
    }

    input[type=radio]:checked+label {
      background: #20df80;
      color: white;
      box-shadow: 0px 0px 20px rgba(0, 255, 128, 0.75);
      transform: translateY(-2%);
    }

    input[type=radio]:checked+label::after {
      color: #fff;
      font-family: FontAwesome;
      border: 7px solid #20df80;
      content: "\f058";
      font-size: 35px;
      position: absolute;
      top: -21px;
      left: 50%;
      transform: translateX(-50%);
      height: 50px;
      width: 50px;
      line-height: 35px;
      text-align: center;
      border-radius: 50%;
      background: #1dc973;
      box-shadow: 0px 2px 5px -2px rgba(0, 0, 0, 0.25);
    }

    .mee_rounded {
      border-radius: 0.75rem !important;
      background: #ffffffa3;
    }



    .pulse_thiss {
      animation: pulse_thiss 1s infinite;
    }

    .pulse_thiss:hover {
      animation: none;
    }

    @-webkit-keyframes pulse_thiss {
      0% {
        -webkit-box-shadow: 0 0 0 0 rgb(204, 127, 44);
      }

      70% {
        -webkit-box-shadow: 0 0 0 10px rgb(202, 179, 98);
      }

      100% {
        -webkit-box-shadow: 0 0 0 0 rgb(213, 170, 16);
      }
    }

    @keyframes pulse_thiss {
      0% {
        -moz-box-shadow: 0 0 0 0 rgba(204, 169, 44, 0.4);
        box-shadow: 0 2px 5px 0 rgb(249, 52, 7);
      }

      70% {
        -moz-box-shadow: 0 0 0 10px rgba(204, 169, 44, 0);
        box-shadow: 0 0 0 10px rgba(215, 170, 11, 0.64);
      }

      100% {
        -moz-box-shadow: 0 0 0 0 rgba(204, 169, 44, 0);
        box-shadow: 0 0 0 0 rgba(215, 171, 15, 0.9);
      }
    }

    /* Ini Buat Time Stamp boss Ga work kampret, Kudu Hardcoded di init */
    .TimeStamp_markers_svg {
      stroke-width: 1;
      stroke: #7d7d7d;
      stroke-dasharray: 5, 4;
      /* 4 units dash, 4 units gap */
    }


    .timestamp_hovers_START {
      cursor: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' version='1.1' id='Layer_1' width='30' height='30' %3E%3Cg%3E%3Cpolygon fill='%2300FF00' points='14.76,22.5 14.76,9.5 6.239,9.5 15,1.054 23.761,9.5 15.24,9.5 15.24,22.5 '/%3E%3Cpath fill='%2329A329' d='M15,1.749L22.522,9H15.74h-1h-0.48H7.478L15,1.749 M15,0.36L5,10h9.26v12H1v1h28v-1H15.74V10H25L15,0.36 L15,0.36z'/%3E%3C/g%3E%3Cg%3E%3Cpath fill='%2339B54A' d='M4.575,28.751c0.351,0.188,0.862,0.346,1.402,0.346c0.8,0,1.267-0.369,1.267-0.903 c0-0.495-0.323-0.778-1.141-1.054c-0.989-0.306-1.6-0.754-1.6-1.501c0-0.824,0.782-1.438,1.959-1.438 c0.62,0,1.069,0.126,1.339,0.259l-0.216,0.559c-0.197-0.095-0.603-0.252-1.15-0.252c-0.827,0-1.142,0.433-1.142,0.794 c0,0.495,0.369,0.738,1.204,1.021c1.025,0.346,1.546,0.778,1.546,1.556c0,0.817-0.691,1.524-2.121,1.524 c-0.584,0-1.222-0.148-1.545-0.338L4.575,28.751z'/%3E%3Cpath fill='%2339B54A' d='M10.267,24.869H8.425v-0.582h4.484v0.582h-1.852v4.715h-0.791V24.869z'/%3E%3Cpath fill='%2339B54A' d='M13.892,27.918l-0.63,1.666h-0.809l2.059-5.297h0.943l2.067,5.297h-0.836l-0.647-1.666H13.892z M15.877,27.384l-0.593-1.524c-0.135-0.346-0.225-0.66-0.314-0.967h-0.018c-0.09,0.314-0.189,0.637-0.306,0.959l-0.594,1.532 H15.877z'/%3E%3Cpath fill='%2339B54A' d='M18.414,24.358c0.396-0.071,0.962-0.11,1.501-0.11c0.836,0,1.375,0.134,1.753,0.433 c0.306,0.235,0.477,0.597,0.477,1.006c0,0.699-0.504,1.163-1.142,1.352v0.023c0.468,0.142,0.746,0.519,0.89,1.068 c0.198,0.739,0.342,1.25,0.468,1.454h-0.81c-0.099-0.149-0.233-0.605-0.404-1.266c-0.18-0.73-0.503-1.006-1.213-1.029h-0.737v2.295 h-0.782V24.358z M19.196,26.771h0.8c0.836,0,1.366-0.4,1.366-1.006c0-0.684-0.566-0.982-1.393-0.99 c-0.378,0-0.647,0.032-0.773,0.063V26.771z'/%3E%3Cpath fill='%2339B54A' d='M24.483,24.869h-1.842v-0.582h4.484v0.582h-1.852v4.715h-0.791V24.869z'/%3E%3C/g%3E%3C/svg%3E%0A") 16 16, crosshair;
      color: #39B54A;
    }

    .TimeStamp_Start_Color {
      color: #39B54A;
      font-weight: 700;
    }

    .timestamp_hovers_END {
      cursor: url("data:image/svg+xml,%3Csvg version='1.1' id='Layer_1' width='30' height='30' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'%3E%3Cg%3E%3Cpolygon fill='%23FF1D25' points='14.76,22.5 14.76,9.5 6.239,9.5 15,1.054 23.761,9.5 15.24,9.5 15.24,22.5 '/%3E%3Cpath fill='%239C272D' d='M15,1.749L22.522,9H15.74h-1h-0.48H7.478L15,1.749 M15,0.36L5,10h9.26v12H1v1h28v-1H15.74V10H25L15,0.36 L15,0.36z'/%3E%3C/g%3E%3Cg%3E%3Cpath fill='%239C272D' d='M10.819,27.101H8.465v1.91h2.624v0.573H7.683v-5.297h3.271v0.574H8.465v1.674h2.354V27.101z'/%3E%3Cpath fill='%239C272D' d='M12.106,29.584v-5.297h0.854l1.941,2.68c0.449,0.621,0.8,1.179,1.087,1.722l0.019-0.008 c-0.072-0.708-0.09-1.352-0.09-2.177v-2.217h0.736v5.297h-0.791l-1.923-2.688c-0.423-0.59-0.827-1.194-1.133-1.769l-0.026,0.008 c0.045,0.668,0.062,1.305,0.062,2.185v2.264H12.106z'/%3E%3Cpath fill='%239C272D' d='M18.023,24.358c0.477-0.063,1.043-0.11,1.663-0.11c1.123,0,1.923,0.229,2.453,0.66 c0.54,0.433,0.854,1.045,0.854,1.901c0,0.865-0.306,1.572-0.872,2.06c-0.566,0.495-1.501,0.762-2.678,0.762 c-0.558,0-1.025-0.023-1.421-0.062V24.358z M18.806,29.042c0.198,0.031,0.485,0.039,0.791,0.039c1.672,0,2.579-0.817,2.579-2.247 c0.009-1.25-0.8-2.044-2.453-2.044c-0.404,0-0.71,0.032-0.917,0.071V29.042z'/%3E%3C/g%3E%3C/svg%3E%0A") 16 16, crosshair;
      color: #FF1D25;
    }

    .TimeStamp_End_Color {
      color: #FF1D25;
      font-weight: 700;
    }

    .Mee_Clr_Pick_Container {
      position: absolute;
      z-index: 99999999;
      top: 3.5%;
      left: 50%;
    }

    .Mee_Container_PicksOption {
      position: absolute;
      z-index: 99999998;
      top: 5.5%;
      left: 34.5%;
      scale: 55%;
    }

    .picks_button {
      background-color: #ffbb33;
    }

    .picks_button.disss {
      background-color: #b7a789;
      border: 1px solid #777474;
      opacity: 0.2;
    }


    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* Firefox */
    input[type=number] {
      -moz-appearance: textfield;
      -webkit-appearance: textfield;
      appearance: textfield;
    }



    /* // Extra small devices (portrait phones, less than 576px)
    // No media query for `xs` since this is the default in Bootstrap */

    /* // Small devices (landscape phones, 576px and up) */
    @media (min-width: 576px) {}

    /* // Medium devices (tablets, 768px and up) */
    @media (min-width: 768px) {}

    /* // Large devices (desktops, 992px and up) */
    @media (min-width: 992px) {
      .Mee_Clr_Pick_Container {
        position: absolute;
        z-index: 99999999;
        top: 10%;
        left: 57.5%;
      }

      .Mee_Container_PicksOption {
        position: absolute;
        z-index: 99999998;
        top: 13%;
        left: 54%;
        scale: 60%;
      }
    }

    /* // Extra large devices (large desktops, 1200px and up) */
    @media (min-width: 1200px) {}
  </style>


  <script src="assets/vendor/modernizr/modernizr.min.js"></script>

  <script type="text/javascript">
    var Selected_Digitizer;
    var Selected_Digitizer_Parameter = [];
    var Constanta_ParamsValue; // konstanta nilai untuk perhitungan kalibrasi

    var CurrentMseedFile; // Is mseedfile for JS processing wich trigger by #Mseed_FileUpload onchange
    var mseed_ParsedRecords; // from Function Init_MseedChannels_Name, which contain Parsed Array from mseedfile by function Init_The_MseedFile
    var SeismoBy_Channels; // from Function Init_MseedChannels_Name, which contain Mseed file sorted byChannel(mseedRecords)
    var RawChnName_Lists = []; // from Function Init_MseedChannels_Name, which contains full name of channel "IA.MBPI.00.HNN";
    var ChnCtryName_Lists = []; // from Function Init_MseedChannels_Name, which contains Channels Country "IA";
    var ChnStaName_Lists = []; // from Function Init_MseedChannels_Name, which contains names Station channel "MBPI";
    var CodedName_Lists = []; // from Function Init_MseedChannels_Name, which contains  channel Code "00";
    var ChnName_Lists = []; // from Function Init_MseedChannels_Name, which contains  name of channel "HNN";


    var SelectedChannel_Lists = []; // Channel selected List trigger by #ch_selectors onchange
    var SelectedChn_Prefix = null; // Channel selected List trigger by #ch_selectors onchange


    var CurrentSeismogram; // seis data from function Init_Selected_WaveFormSeismogram
    var CurrentSeismogram_Lists = []; // seis data Lists from function Init_Selected_WaveFormSeismogram

    var GraphSeismo; // Graphic data from function Init_Selected_WaveFormSeismogram
    var GraphSeismo_Lists = []; // Graphic data Lists from function Init_Selected_WaveFormSeismogram


    var Selector_Start_OR_End_Picks = ""; // trigger by picking Wavefrom svg, value are : |"picking_start_Time" or "picking_end_Time" |

    var isMouseIn_forSED = false;

    var xTicks;
    var LOCK_TS_STRT_Pick = false;
    var LOCK_TS_END_Pick = false;


    var ShadowRoot_markerX = []; // Element ShaddowRoot of marker, so can be processed...

    var TimeStamp_Selected_Start_TZ = ""; // DUmmy ajaaa  formatnya 03:20:00.000
    var TimeStamp_Selected_Start_MS = "";
    var TimeStamp_Selected_End_TZ = ""; // DUmmy ajaaa ini harus lebih kecil biar gak trigger function  formatnya 03:20:00.000
    var TimeStamp_Selected_End_MS = "";
  </script>

  <script type="text/javascript">
    function copyTablesToClipboard_Success() {
      Swal.fire({
        position: 'top-end',
        toast: true,
        icon: 'success',
        title: 'Table Berhasil Di-Salin',
        footer: 'Silahkan Paste di Excel',
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
      })
    }

    function OOOOPS_Login() {
      Swal.fire({
        position: 'top-end',
        toast: true,
        icon: 'error',
        title: 'Log-In Gagal, Coba Periksa Akun dan Password',
        showConfirmButton: false,
        timer: 2500,
        timerProgressBar: true,
      })
    }

    function OOOOPS_picking(title_msg, html_msg) {
      Swal.fire({
        position: 'top-end',
        toast: true,
        icon: 'error',
        title: title_msg,
        html: html_msg,
        footer: '<a href="https://github.com/ggzitha/wave_picker">What Kind Of Black Magic Is Thiss ?</a>',
        showConfirmButton: false,
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        stopKeydownPropagation: false,
        timer: 3500,
        showCloseButton: true,
        timerProgressBar: true,
        width: '35em',
        background: '#f1d8f4ff',
        didOpen: ($this) => {
          $this.addEventListener('mouseenter', Swal.stopTimer)
          $this.addEventListener('mouseleave', Swal.resumeTimer)
        },
        didClose: () => {
          $('#Btn_Erase_Time_Picks').click();
        },
        customClass: {
          popup: 'swall_borders',
          timerProgressBar: 'swall_borders_timers',
        }
      })
    }

    function UnixTimeStamp_To_Date(UNIX_timestamp) {
      // var a = new Date(UNIX_timestamp * 1000 ); //Kalau belum milisecond
      var a = new Date(UNIX_timestamp);
      var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
      var year = a.getFullYear();
      var month = months[a.getMonth()];
      var date = a.getDate();
      var hour = a.getHours();
      var min = a.getMinutes();
      var sec = a.getSeconds();
      // var time = date + ' ' + month + ' ' + year + ' ' + hour + ':' + min + ':' + sec ;
      var time = date + '-' + month + '-' + year;
      return time;
    };


    function formatUnixTimestampToUTC(unixTimestamp, format) {
      // Create a new Date object from the Unix timestamp (in milliseconds)
      const date = new Date(unixTimestamp);

      // Extract the UTC components
      const components = {
        Y: date.getUTCFullYear(),
        m: String(date.getUTCMonth() + 1).padStart(2, '0'), // Months are zero-indexed
        d: String(date.getUTCDate()).padStart(2, '0'),
        H: String(date.getUTCHours()).padStart(2, '0'),
        i: String(date.getUTCMinutes()).padStart(2, '0'),
        s: String(date.getUTCSeconds()).padStart(2, '0'),
        L: String(date.getUTCMilliseconds()).padStart(3, '0'),
      };

      // Replace the format string with the appropriate values
      const formattedDate = format.replace(/Y|m|d|H|i|s|L/g, match => components[match]);

      return formattedDate;
    }
  </script>


</head>

<body>

  <div class="INI_SEMUA_ISINYA_LOADER">
    <span class="sp_version d-none">3.1.3</span>
    <span class="timestamp_hovers_START" id="Dummy_ElementStlyle_hov_START"></span>
    <span class="timestamp_hovers_END" id="Dummy_ElementStlyle_hov_END"></span>

    <div id="Load_01_Mseed_wrapper" style="z-index:999999 !important" hidden aria-hidden="true">
      <span class="loader_rockets"></span>
      <div class="mt-3 text-center">
        <h1 class=" display-4 white-text lighten-5 animated heartBeat slow infinite">Uploading Mseed</h1>
      </div>
      <div class="d-flex justify-content-center">
        <div class="spinner-border text-info" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div>
    </div>

    <div id="Load_02_MseedParams_wrapper" style="z-index:999999 !important" hidden aria-hidden="true">
      <span class="loader_wave"></span>
      <div class="mt-3 text-center">
        <h1 class=" display-5 white-text lighten-5 animated tada slow infinite">Reading Mseed Param's</h1>
      </div>
      <div class="d-flex justify-content-center">
        <div class="spinner-border text-info" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div>
    </div>

    <div id="Load_03_BearPicking_wrapper" style="z-index:999999 !important" hidden aria-hidden="true">
      <span class="loader_bear"></span>
      <div class="mt-3 text-center">
        <h1 class=" display-4 grey-text lighten-5 animated flipInY slower infinite">Sa BEAR, Lagi Picking</h1>
      </div>

      <div class="d-flex justify-content-center">
        <div class="spinner-border text-light" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div>
    </div>

  </div>

  <?php
  if (isset($_SESSION['Logged_Datas']) && $_SESSION['Logged_Datas'] == $hash) {
  ?>

    <div class="Logged_IN_Container_NIII">
      <div id="home" class="viewss bg_globs">

        <div class="container h-100 d-flex justify-content-center align-items-center">

          <div class="butt_logout_containers" style="position: absolute; top: 0px; right: 0px; display: block;">
            <a href="?logout=true" type="button" class="btn btn-outline-danger btn-rounded waves-effect btn-sm"><i class="fas fa-power-off mr-2 fa-2x white-text"></i> Log-Out</a>
          </div>

          <div class="row smooth-scroll w-75">
            <div class="col-md-12 white-text text-center p-0 ">
              <div class="wow fadeInDown" data-wow-delay="0.3s">
                <h1 class="font-weight-bold mb-2 h1-responsive display-4"><span><img src="images/icon/favicon.png" width="75px"></span> The Wave Pickers</h1>
                <hr class="hr-light">
              </div>

              <div class="wow fadeInUp" data-wow-delay="0.5s">
                <div class="file-upload-wrapper">
                  <input type="file" id="Mseed_FileUpload" name="mseed" class="file-upload" data-max-file-size="200M" style="display:none" />
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>



      <div class="modal top fade" id="Wave_containerModal" tabindex="-1" role="dialog" aria-labelledby="Wave_containerModalTitle" aria-hidden="true" data-backdrop="static" data-mdb-backdrop="static" data-keyboard="false" data-mdb-keyboard="false">

        <div class="modal-dialog modal-dialog-centered modal-fluid modal-dialog-scrollable mt-0" role="document" style="backdrop-filter: blur(1px) !important;">

          <div class="modal-content">
            <div class="Mee_Clr_Pick_Container">
              <a class="btn-floating btn-sm picks_button disss m-0 p-0" id="Btn_Erase_Time_Picks"
                data-toggle="tooltip" data-html="true" title="<u>key=(d) </u><i> Reset ALL Start-End Time Pick's</i>"
                disabled>
                <i class="fa-light fa-eraser"></i>
              </a>
            </div>

            <div class="Mee_Container_PicksOption">
              <div class="btn-group btn-sm btn-block m-0 p-0" data-toggle="buttons" id="Start_OR_End_Selection">
                <label class="btn px-2 green-gradient-mee btn-rounded form-check-label" data-toggle="tooltip" data-html="true" title="<u>key=(s) </u><i> Init Start-Pick mode</i>">
                  <input disabled class="form-check-input" type="radio" value="picking_start_Time" name="options_WhichToPicks" id="Picks_StartTime" autocomplete="off">StrtX
                </label>
                <label class="btn px-3 grey-gradient-mee form-check-label" data-toggle="tooltip" data-html="true" title="<u>key=(q) </u><i> Quit Pick mode</i>">
                  <input disabled class="form-check-input" type="radio" value="" name="options_WhichToPicks" id="Quit_PickMode" autocomplete="off">Q
                </label>
                <label class="btn px-2 red-gradient-mee btn-rounded form-check-label" data-toggle="tooltip" data-html="true" title="<u>key=(e) </u><i> Init End-Pick mode</i>">
                  <input disabled class="form-check-input" type="radio" value="picking_end_Time" name="options_WhichToPicks" id="Picks_EndTime" autocomplete="off">EndX
                </label>
              </div>
            </div>


            <div class="modal-header blue lighten-2">
              <h5 class="modal-title" id="Wave_containerModalTitle">Waveform Picker's</h5>
              <button type="button" class="btn btn-danger btn-md" data-dismiss="modal" aria-label="Close" style="position: absolute; top: 0px; right: 0px;">
                <i class="fa-solid fa-xmark-large fa-1x"></i>
              </button>
            </div>

            <div class="modal-body m-0 p-0 py-2">
              <div class="row no-gutters">

                <div class="col-lg-7 col-12" style="min-height: 30vh;">
                  <div class="card scroll-content scrollbar-light-blue bolds" style="min-height: 100%;">
                    <div class="card-body pl-2 pr-4 pt-2 ">


                      <div class="m-0 p-0" id="Load_00_NoChannel_wrapper" style="z-index:999999 !important;position: relative;width: 100%;height: 100%;background: #fff;" aria-hidden="false">
                        <div style="top: 50%;position: relative;" class="d-flex justify-content-center">
                          <div class="mt-3 text-center justify-content-center">
                            <h1 class="display-5 grey-text lighten-5 animated jackInTheBox slower infinite">Select Param's First</h1>
                            <div role="status" class="spinner-border text-info">
                              <span class="sr-only">Loading...</span>
                            </div>
                          </div>


                        </div>
                      </div>


                      <div class=" w-100 pb-3" id="append_data_stream"></div>


                    </div>
                  </div>
                </div>

                <div class="col px-2">
                  <div class="card " style="position: sticky !important; top: 0px;">
                    <h5 class="card-header info-color white-text text-center py-2">
                      <strong>Parameter Picker</strong>
                    </h5>
                    <div class="card-body px-lg-4 pt-2">

                      <form style="color: #757575;" id="Form_PickersParameters" name="pickers_param" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>

                        <div class="row pt-2">
                          <div class="btn-group btn-sm btn-block" data-toggle="buttons" id="Digitizer_Radio_Selections">
                          </div>
                        </div>

                        <div class="md-form">
                          <select class="mdb-select validate md-form colorful-select dropdown-primary" id="ch_selectors" name="ch_selectors" multiple searchable="Cari. .." required>
                            <option value="" disabled>Pilih....</option>
                          </select>
                          <label class="mdb-main-label">Channel Stream</label>
                          <div class="invalid-feedback"> Select Stream</div>
                        </div>

                        <div class="row">


                          <div class="col">
                            <div class="md-form" id="input_starttime_container" data-toggle="helper_start_Time">
                              <input placeholder="Start time" type="text" name="input_starttime" id="input_starttime" disabled class="form-control timepicker timepicker_start_class" required>
                              <label class="active" for="input_starttime">Start Time</label>
                              <div class="invalid-feedback">Select Start Time.</div>
                            </div>
                          </div>


                          <div class="col">
                            <div class="md-form" id="input_endtime_container" data-toggle="helper_end_Time">
                              <input placeholder="End time" type="text" name="input_endtime" id="input_endtime" disabled class="form-control timepicker" required>
                              <label class="active" for="input_endtime">End Time</label>
                              <div class="invalid-feedback">Select End Time.</div>
                            </div>
                          </div>



                        </div>

                        <div class="row">
                          <div class="col">
                            <div class="md-form input-group" data-toggle="helper_windowing">
                              <div class="input-group-prepend">

                              </div>
                              <input type="number" id="Windowing_ParamsValue" name="Windowing_ParamsValue" class="form-control" step="1" min="1" required>
                              <label class="active" for="Windowing_ParamsValue">Windowing Number </label>

                            </div>
                          </div>

                          <div class="col">
                            <div class="md-form input-group">
                              <div class="input-group-prepend">

                              </div>
                              <input type="number" id="Frequency_ParamsValue" name="Frequency_ParamsValue" class="form-control" step="0.001" required>
                              <label class="active" for="Frequency_ParamsValue">Frekuensi(Hz) </label>

                            </div>
                          </div>
                          <div class="col">
                            <div class="md-form input-group">
                              <div class="input-group-prepend">

                              </div>
                              <input type="number" id="Voltage_ParamsValue" name="Voltage_ParamsValue" class="form-control" step="0.001" required>
                              <label class="active" for="Voltage_ParamsValue">Amplitudo(Volt) </label>


                            </div>
                          </div>



                        </div>


                        <div class="row">
                          <div class="col">
                            <div class="md-form input-group">
                              <div class="input-group-prepend">

                              </div>
                              <input type="number" id="Constanta_ParamsValue" name="Constanta_ParamsValue" class="form-control" step="0.000000000000000001">
                              <label class="active" for="Constanta_ParamsValue">Konstanta Perhitungan</label>

                            </div>
                          </div>
                        </div>



                        <button class="btn btn-outline-info btn-rounded btn-block z-depth-0 py-2 mt-3 waves-effect " type="submit">Proccess</button>

                      </form>
                    </div>


                  </div>

                </div>
              </div>
            </div>







            <div class="p-0 m-0 mee_offside_footer">


              <div class="row justify-content-end" id="Appended_DtOption_PopUp">
              </div>



            </div>


          </div>

          <div class="modal-footer justify-content-center p-0 grey lighten-1">
            <small class="purple-text text-muted">◭@Mee ⩤Lutcx⩥ @◮</small>
          </div>



        </div>
      </div>





      <div class="modal fade" id="Final_rslt_Modal" tabindex="-1" role="dialog" aria-labelledby="Final_rslt_ModalTitle" aria-hidden="true" data-backdrop="static" data-mdb-backdrop="static" data-keyboard="false" data-mdb-keyboard="false">


        <div class="modal-dialog modal-dialog-centered modal-fluid modal-dialog-scrollable " role="document" style="backdrop-filter: blur(1px) !important;">


          <div class="modal-content">
            <div class="modal-header green lighten-3 pb-0 pt-2">

              <div class="col-8">
                <h5 class="modal-title" id="Final_rslt_ModalTitle">Picks By Parameter Result</h5>
                <div class="row w-75 g-0 align-content-center">
                  <div class="col-lg-3 col-10 m-0 p-0" style="scale: 85%;">
                    <div class="form-check pt-1">
                      <input type="checkbox" class="form-check-input" id="Chkbox_SortValues">
                      <label class="form-check-label px-4" for="Chkbox_SortValues" autocomplete="off">Sorted <i class="fa-light fa-arrow-down-1-9"></i></label>
                    </div>
                  </div>
                  <div class="col-lg-1 col-2 m-0 p-0" style="scale: 85%;">
                    <button type="button" class="btn btn-sm waves-effect m-0" id="Btn_CopyValues" onclick="copyTablesToClipboard('TempTable_Results');"><i class="fa-solid fa-copy"></i></button>
                  </div>
                </div>
              </div>

              <div class="col-2">
                <button type="button" class="btn btn-danger btn-md" data-dismiss="modal" aria-label="Close" style="position: absolute; top: 0px; right: 0px;">
                  <i class="fa-solid fa-xmark-large fa-1x"></i>
                </button>
              </div>

            </div>
            <div class="modal-body grey lighten-2">

              <div class="row" id="AppendedResult_IMG">

              </div>

              <div class="row" id="AppendedResult_TABLE">

              </div>

              <div class="row" id="Temp_CopyTABLE">

              </div>



            </div>

          </div>
          <div class="modal-footer justify-content-center p-0 grey lighten-1">
            <small class="purple-text text-muted">◭@Mee ⩤Lutcx⩥ @◮</small>
          </div>

        </div>
      </div>




      <div class="modal fade" id="strtime_second_modal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="strtime_second_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered " role="document">
          <div class="modal-content">

            <div class="modal-header white-text" style="margin-bottom: 1rem; font-weight: 300; text-align: center; background-color: #4285f4;">
              <h4 class="modal-title " id="strtime_second_modal_titles" style="font-size:52pt;"> </h4>
            </div>
            <div class="modal-body" id="append_round_slider_seconds">

            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="endtime_second_modal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="endtime_second_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered " role="document">
          <div class="modal-content">

            <div class="modal-header white-text" style=" font-weight: 300; text-align: center; background-color: #212121;border-bottom: none;">
              <h4 class="modal-title " id="endtime_second_modal_titles" style="font-size:52pt;"> </h4>
            </div>
            <div class="modal-body" id="append_round_slider_end_seconds" style=" background-color: #212121;">

            </div>
          </div>
        </div>
      </div>


    </div>



  <?php
  }
  ?>


  <script type="text/javascript" src="assets/vendor/mdbootstrap_4_mee/js/jquery.min.js"></script>
  <script type="text/javascript" src="assets/vendor/mdbootstrap_4_mee/js/popper.min.js"></script>
  <script type="text/javascript" src="assets/vendor/mdbootstrap_4_mee/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="assets/vendor/mdbootstrap_4_mee/js/mdb.min.js"></script>
  <script type="text/javascript" src="assets/vendor/mdbootstrap_4_mee/plugins/MDB-File-Upload/js/addons/mdb-file-upload.min.js"></script>
  <script type="text/javascript" src="assets/vendor/lightbox2/js/lightbox.js"></script>
  <script type="text/javascript" src="assets/vendor/sweetalert2-11.4.24/sweetalert2.js"></script>


  <?php
  if (isset($_SESSION['Logged_Datas']) && $_SESSION['Logged_Datas'] == $hash) {
  ?>


    <!------------------------------- Seisplot V3.1.3 ----------------------------->
    <!------------------------------- Seisplot V3.1.3 ----------------------------->
    <script type="module">
      // import * as seisplotjs3 from './assets/vendor/seisplotjs-3.1.4/seisplotjs_3.1.4_standalone.js'; // Still error ,Glitching,mising when zoom
      import * as seisplotjs3 from './assets/vendor/seisplotjs-3.1.4/seisplotjs_3.1.3_standalone.js';

      import {
        utcFormat as d3utcFormat
      } from "./assets/vendor/d3/d3-time-format@4.js";
      import {
        utcSecond as d3utcSecond,
        utcMinute as d3utcMinute,
        utcHour as d3utcHour,
        utcDay as d3utcDay,
        utcMonth as d3utcMonth,
        utcYear as d3utcYear,
      } from "./assets/vendor/d3/d3-time@3.js";

      seisplotjs3.util.updateVersionText('.sp_version');

      const formatFulll = d3utcFormat("%H:%M:%S.%L");
      const formatHMS = d3utcFormat("%H:%M:%S");
      const formatDay = d3utcFormat("%m/%d");
      const formatMonth = d3utcFormat("%Y/%m");
      const formatYear = d3utcFormat("%Y");
      const formatYYYMMDD = d3utcFormat("%Y-%m-%d");


      window.Init_MseedChannels_Name = async function(Channel_ArrayBuffers) {
        try {
          // Parse the mseed file into records
          mseed_ParsedRecords = seisplotjs3.miniseed.parseDataRecords(Channel_ArrayBuffers);
          // Group the records by channel
          SeismoBy_Channels = seisplotjs3.miniseed.byChannel(mseed_ParsedRecords);

          for (const channelKey of SeismoBy_Channels.keys()) {
            RawChnName_Lists.push(channelKey);
            const [networkX, stationX, locationX, channelX] = channelKey.split('.');
            ChnCtryName_Lists.push(networkX);
            ChnStaName_Lists.push(stationX);
            CodedName_Lists.push(locationX);
            ChnName_Lists.push(channelX);
          }

          // Combine the arrays into an object
          const DataFor_MultiSelect = Object.fromEntries(ChnName_Lists.map((kyX, idX) => [kyX, RawChnName_Lists[idX]]));
          Populate_MultiSelect('#ch_selectors', DataFor_MultiSelect);

          $('#Wave_containerModal').modal('show');
          $('#Wave_containerModal').data('bs.modal').handleUpdate();

        } catch (error) {
          console.error("Error parsing mseed:", error);
          OOOOPS_picking('Errors', error);
        }
      }

      // Function to plot mseed file
      window.Init_Selected_WaveFormSeismogram = async function(Channel_Selection, RawChannel_Selection) {
        try {
          // Get the MiniSEED records for the selected channel
          const mseedDataArray = SeismoBy_Channels.get(RawChannel_Selection);
          if (!mseedDataArray || mseedDataArray.length === 0) {
            OOOOPS_picking('Errors', 'No data available for selected channel:', selectedChannel);
            return;
          }
          // Convert the MiniSEED data records to SeismogramDisplayData
          const seismogramsXXX = seisplotjs3.miniseed.seismogramPerChannel(mseedDataArray);
          if (seismogramsXXX.length === 0) {
            OOOOPS_picking('Errors', 'No valid seismograms for the selected channel.');
            return;
          }

          // Iterate through the seismograms and plot them

          for (const This_SeisData of seismogramsXXX) {
            // seismogramsXXX.forEach(This_SeisData => { // Kalau ini await sama async gak bisa

            let NetName = This_SeisData._segmentArray[0]._sourceId.networkCode;
            let StaName = This_SeisData._segmentArray[0]._sourceId.stationCode;
            let StartTimes = This_SeisData._segmentArray[0]._startTime.ts;

            CurrentSeismogram = seisplotjs3.seismogram.SeismogramDisplayData.fromSeismogram(This_SeisData);
            CurrentSeismogram_Lists.push(CurrentSeismogram);

            const seisConfig = new seisplotjs3.seismographconfig.SeismographConfig();
            // seisConfig.linkedTimeScale = new seisplotjs3.scale.LinkedTimeScale();
            seisConfig.title = `${NetName}.${StaName}_${Channel_Selection} | ${UnixTimeStamp_To_Date(StartTimes)}`;
            seisConfig.margin.top = 25;
            seisConfig.margin.right = 0;
            // seisConfig.maxWidth = 1080; //kalau di enable Gak bisa responsive
            // seisConfig.minWidth = 900; //kalau di enable Gak bisa responsive
            seisConfig.maxHeight = 600;
            seisConfig.minHeight = 250;
            // seisConfig.Zoom = true;
            seisConfig.wheelZoom = true;
            seisConfig.xGridLines = false; // show grid lines be drawn for each tick on the X axis. Defaults to false;
            seisConfig.gridLineColor = 'gainsboro'; // default gainsboro, is a color that very light grey
            // seisConfig.maxZoomPixelPerSample  = 20;
            // seisConfig.connectSegments = false;
            seisConfig.doGain = true;
            //  "raw" raw values, no centering || "zero", same as Raw, but also includes zero 
            // "minmax", centered on midpoint of min-max || "mean", centered on mean
            seisConfig.amplitudeMode = "minmax";
            seisConfig.lineColors = [
              "#27D9E6FF"
            ];
            seisConfig.lineWidth = 1;
            seisConfig.xLabelOrientation = "horizontal";
            seisConfig.xLabel = " ";
            // seisConfig.xAxisTimeZone = "UTC";
            seisConfig.xSublabel = "Time Series (UTC)";
            seisConfig.isXAxisTop = false;
            seisConfig.isRelativeTime = false;
            seisConfig.timeFormat = function(date) {
              return (
                d3utcSecond(date) < date ? formatFulll :
                d3utcMinute(date) < date ? formatHMS :
                d3utcHour(date) < date ? formatHMS :
                d3utcDay(date) < date ? formatHMS :
                d3utcMonth(date) < date ? formatDay :
                d3utcYear(date) < date ? formatMonth : formatYear
              )(date);
            };
            // Wait for the div to be ready and appended
            await waitForElement(`#Each_stream_${Channel_Selection}`);

            const SeismoContainer = document.querySelector(`#Each_stream_${Channel_Selection}`);
            const SeismoContainerSize = SeismoContainer.getBoundingClientRect();

            if (SeismoContainerSize.width > 0 && SeismoContainerSize.height > 0) {




              GraphSeismo = new seisplotjs3.seismograph.Seismograph([CurrentSeismogram], seisConfig);
              GraphSeismo_Lists.push(GraphSeismo);
              SeismoContainer.appendChild(GraphSeismo);

              // Prepare External Function, Like hover, click, etc
              // Wait for the sp-seismograph shadow DOM and SVG element to be ready
              const spSeismograph = await waitForElement(`#Each_stream_${Channel_Selection} sp-seismograph`);

              const svgElement = await waitForElementInShadowDOM(spSeismograph, 'svg');
              const canvasElement = await waitForElementInShadowDOM(spSeismograph, 'svg foreignObject canvas');
              var xAxisX = await waitForElementInShadowDOM(spSeismograph, 'svg g g.axis.axis--x');


              if (svgElement && canvasElement && xAxisX) {
                // Udah coba pakai canvasElement, tapi gak bisa, mungkin ke overlay sama SVG element, dia lebih diatas 
                // Udah coba pakai canvasElement, tapi gak bisa, mungkin ke overlay sama SVG element, dia lebih diatas 


                var canvasRect = canvasElement.getBoundingClientRect();
                var svgRect = svgElement.getBoundingClientRect();
                var DeltaSize_SvgCanvas_Rect = canvasRect.left - svgRect.left;
                // Accessing the current time window from the `<sp-seismograph>` shadow DOM
                xTicks = xAxisX.querySelectorAll('g.tick text');



                // Hover Function
                // Create and append the dashed markerX to the SVG
                const markerX = document.createElementNS("http://www.w3.org/2000/svg", "line");
                markerX.classList.add("TimeStamp_markers_svg"); // Apply the CSS class with dashed style wich is not working, but need to toggle it
                markerX.style.stroke = "#7d7d7d";
                markerX.style.strokeWidth = "1"; // its cammelCase wich the Capital become - dashed ==> stroke-width
                markerX.style.strokeDasharray = "5, 4"; //// its cammelCase wich the Capital become - dashed ==> stroke-dasharray
                markerX.setAttribute("y1", "10%"); // Start 10% from the top Mustbe hardcoded, not working with css
                markerX.setAttribute("y2", "80%"); // Extend markerX vertically 80% (leaving 10% at the bottom)
                ShadowRoot_markerX.push(markerX);
                svgElement.appendChild(markerX);

                // Track when the mouse enters the SVG
                svgElement.addEventListener('mouseenter', () => {
                  isMouseIn_forSED = true;
                });

                // Add mouse event handling for markerX
                svgElement.addEventListener('mousemove', (event) => {
                  isMouseIn_forSED = true;
                  const Xaxis_svg = event.clientX - svgRect.left;
                  if (Xaxis_svg >= DeltaSize_SvgCanvas_Rect) {
                    markerX.setAttribute("x1", Xaxis_svg);
                    markerX.setAttribute("x2", Xaxis_svg);
                  } else {
                    markerX.setAttribute("x1", null);
                    markerX.setAttribute("x2", null);
                  }

                  xAxisX = spSeismograph.shadowRoot.querySelector('svg g g.axis.axis--x');
                  xTicks = xAxisX.querySelectorAll('g.tick text');

                  Attach_TimeStamp_Events(xTicks);

                });

                svgElement.addEventListener('mouseleave', () => {
                  isMouseIn_forSED = false;
                  markerX.setAttribute("x1", null);
                  markerX.setAttribute("x2", null);
                });

                markerX.addEventListener('click', function(event) {
                  const clickEvent = new MouseEvent('click', {
                    // view: window,
                    // bubbles: true,
                    cancelable: true,
                    clientX: event.clientX, // Pass custom X position
                  });
                  canvasElement.dispatchEvent(clickEvent);
                });



                // CanvasElement Onlyyy   console.log('Canvas Element:', canvasElement);
                // CanvasElement Onlyyy   console.log('Canvas Element:', canvasElement);
                canvasElement.addEventListener('click', function(event) {
                  const clickX = event.clientX - canvasRect.left; // X position of click in pixels
                  const canvasWidth = canvasElement.clientWidth;

                  // console.log('clickX:', clickX);
                  // console.log('clientX:', event.clientX, ' | ', 'svgRect.left:', canvasRect.left);
                  // console.log('canvasWidth:', canvasWidth);
                  xAxisX = spSeismograph.shadowRoot.querySelector('svg g g.axis.axis--x');
                  xTicks = xAxisX.querySelectorAll('g.tick text');


                  const startTimeX = xTicks[0].__data__; // Date object from the first tick
                  const endTimeX = xTicks[xTicks.length - 1].__data__; // Date object from the last tick

                  const currentStartX = startTimeX.getTime();
                  const currentEndX = endTimeX.getTime();
                  const timeAtClick = currentStartX + (clickX / canvasWidth) * (currentEndX - currentStartX);

                  const UnixTimeStamps = timeAtClick;

                  // console.log('UnixTimeStamps:', UnixTimeStamps, ' | ', 'TimeXFormated:', TimeXFormated, ' | ', 'DateXFormated:', DateXFormated, ' | ', 'DateTime_utcX:', DateTime_utcX);

                  if (Selector_Start_OR_End_Picks) {
                    Picked_This_TimeeX(Selector_Start_OR_End_Picks, UnixTimeStamps);
                  }

                });

              } else {
                console.error(`SVG or Canvas element not found in shadow DOM for ${Channel_Selection}.`);
              }



            } else {
              console.error(`WaveForm Container for ${Channel_Selection} has zero width/height. Skipping seismograph rendering.`);
            }

            $('#Load_00_NoChannel_wrapper').prop("hidden", true);


            // });
          }
        } catch (error) {
          console.log('Error plotting mseed:', error);
          OOOOPS_picking('Error plotting mseed:', error);
        }
      }


      // Function Change Time For Pick
      window.Convert_To_Seisplot_Time = function(FormatAs_TZ) {
        return seisplotjs3.util.isoToDateTime(FormatAs_TZ);
      }
    </script>

    <!------------------------------- Seisplot V3.1.3 ----------------------------->
    <!------------------------------- Seisplot V2.0.1 (nomodule, buat fallback Old_Browser)----------------------------->

    <script nomodule type="text/javascript" src="assets/vendor/seisplotjs-2.0.1/seisplotjs_2.0.1_standalone.js"></script>
    <!-- <script async src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment-with-locales.min.js" crossorigin="anonymous"></script> -->

    <script nomodule type="text/javascript">

    </script>
    <!------------------------------- Seisplot V2.0.1 (nomodule, buat fallback Old_Browser)----------------------------->
    <!------------------------------- Seisplot V2.0.1 (nomodule, buat fallback Old_Browser)----------------------------->






    <script type="text/javascript">
      (function() {
        'use strict';
        window.addEventListener('load', function() {
          var forms = document.getElementsByClassName('needs-validation');
          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              }

              if ($('.needs-validation select').val() == '') {
                $('.needs-validation').find('.valid-feedback').hide();
                $('.needs-validation').find('.invalid-feedback').show();
                $('.needs-validation').find('.select-dropdown').val('').prop('placeholder', 'No Value Selected')
              } else {
                $('.needs-validation').find('.valid-feedback').show();
                $('.needs-validation').find('.invalid-feedback').hide();
              }

              form.classList.add('was-validated');
            }, false);
          });
        }, false);
      })();


      $(document).ready(function() {

        $.getJSON("/script/parameter_logger.json", function(json_dat) {
          Selected_Digitizer_Parameter = json_dat;
          Init_Digitizer_Params();
        });

        new WOW().init();

        Reset_Form_PickersParameter();



        $("#input_starttime").prop("disabled", true);
        $("#input_endtime").prop("disabled", true);

        $("#ch_selectors").prop("disabled", true);
        $("#Constanta_ParamsValue").prop("disabled", true);

        $('[data-toggle="tooltip"]').tooltip();
        $('.file-upload').file_upload();
        $('.file-upload').show();


        $('[data-toggle="helper_start_Time"]').popover({
          html: true,
          trigger: ' focus',
          placement: 'top',
          content: function() {
            return `<img src="/images/tuts/TimeStartPick.gif" alt="This How To" width="250" /><ul> </ul>`;
          }
        });

        $('[data-toggle="helper_end_Time"]').popover({
          html: true,
          trigger: ' focus',
          placement: 'top',
          content: function() {
            return `<img src="/images/tuts/TimeEndPick.gif" alt="This How To" width="250" /><ul> </ul>`;
          }
        });

        $('[data-toggle="helper_windowing"]').popover({
          html: true,
          trigger: ' focus',
          placement: 'left',
          content: function() {
            return `<img src="/images/tuts/WindowingNumb.gif" alt="This How To" width="250" /> <ul> <li class="list_helpers_jumbotron" > Makin Kecil Untuk Freq Tinggi </li> <li class="list_helpers_jumbotron" > Bagian Hijau Dan Merah Harus Ada di setiap Gelombang </li> <li class="list_helpers_jumbotron" > Tidak Boleh Bertabrakan Kedua Poin Tersebut </li></ul>`;
          }
        });


        lightbox.option({
          'resizeDuration': 200,
          'wrapAround': true
        });


        // Detect key press when mouse is inside SVG
        document.addEventListener('keydown', (event) => {
          if (isMouseIn_forSED && event.key.toLowerCase() === 's') {
            $('#Picks_StartTime').click();
          }
          if (isMouseIn_forSED && event.key.toLowerCase() === 'e') {
            $('#Picks_EndTime').click();
          }
          if (isMouseIn_forSED && event.key.toLowerCase() === 'q') {
            $('#Quit_PickMode').click();
          }

          if (isMouseIn_forSED && event.key.toLowerCase() === 'd') {
            $('#Btn_Erase_Time_Picks').click();
          }

        });



      });
    </script>



    <script type="text/javascript">
      var styling_startTIme = cssX($("#Dummy_ElementStlyle_hov_START"));
      var styling_endTIme = cssX($("#Dummy_ElementStlyle_hov_END"));


      function Init_Digitizer_Params() {
        Object.entries(Selected_Digitizer_Parameter).forEach(([Names, ArrayParams]) => {
          const itemHtmlX = `<label class="btn waves-effect waves-light purple-gradient-mee btn-rounded form-check-label">
                      <input class="form-check-input" type="radio" value="` + Names + `" name="Options_WhichDigitizer" id="Digitizer_` + Names + `" autocomplete="off"> 
                      ` + Names + `
                     </label>`;
          $("#Digitizer_Radio_Selections").append(itemHtmlX);
        });
        const DgtzrRad = document.getElementById("Digitizer_Radio_Selections");

        DgtzrRad.addEventListener("change", Digitizer_Radio_Checked)

      };


      $('#Mseed_FileUpload').on('change', function(event) {
        Reset_Form_PickersParameter();

        // Gampangan Refresh aja dah on close pop up
        // $("#ch_selectors").find('option:not(:first)').remove();
        // $("#ch_selectors").prop("disabled", true);
        // $('#ch_selectors').materialSelect({
        //   destroy: true
        // });

        CurrentMseedFile = $(this)[0].files[0];
        Init_The_MseedFile(CurrentMseedFile);

      });


      function Init_The_MseedFile(CurrentMseedFile) {
        if (CurrentMseedFile) {
          // Show the loader when starting the file loading process
          $('#Load_01_Mseed_wrapper').prop("hidden", false);

          const readerX = new FileReader();
          readerX.onload = function(e) {
            const arrayBuffersX = e.target.result;

            // Hide the loader when loading is done
            $('#Load_01_Mseed_wrapper').prop("hidden", true);

            // Trigger the next function with the array buffer
            Init_MseedChannels_Name(arrayBuffersX);
          };

          readerX.onerror = function() {
            // Hide the loader if there's an error and log it
            $('#Load_01_Mseed_wrapper').prop("hidden", true);
            OOOOPS_picking('Errors:', 'An error occurred while reading the file');
          };

          // Read the file as ArrayBuffer
          readerX.readAsArrayBuffer(CurrentMseedFile);
        } else {
          OOOOPS_picking('Errors:', 'No file selected');
        }
      }


      function Populate_MultiSelect(idElement, data) {
        var $select = $(idElement);

        // Clear existing options except the first one
        $select.find('option:not(:first)').remove();

        const sortedByKeys = Object.keys(data).sort()
          .reduce((acc, key) => {
            acc[key] = data[key];
            return acc;
          }, {});

        // Iterate over the response data and append options
        $.each(sortedByKeys, function(index, item) {
          $select.append($('<option>', {
            value: index,
            text: index,
            "orig_val": item
          }));
        });

        // Refresh or initialize the MDB Incorrect value
        if ($select.length) {
          $select.materialSelect({
            //   destroy: true
            // validate: true,
            // validFeedback: 'Correct choice',
            // invalidFeedback: 'Wrong choice'
          });
        }
      }


      $('#Chkbox_SortValues').on("change", function() {
        if (this.checked) {
          // console.log("Checked");
          sortResultTables(3);
        } else {
          // console.log("Un-Checked");
          sortResultTables(0); // dari index kolom pada tbody (setiap tag <td>)
          //-------Index ke----|      0         |----|   1   |---|     2      |----|         3         |------|  4  |------
          //--------------<tr><td hidden="">0</td><td>813353</td><td>-689931</td><td>236.94191773393416</td><td></td></tr>
        }
      });

      function sortResultTables(RowOrder) {
        const ResultTables = document.querySelectorAll('#AppendedResult_TABLE table');


        ResultTables.forEach(function(table) {
          const tbody = table.querySelector('tbody'); // Target the tbody specifically
          const rows = Array.from(tbody.rows).slice(0); // Get all rows from tbody

          rows.sort(function(a, b) {
            const aValue = parseFloat(a.cells[RowOrder].textContent);
            const bValue = parseFloat(b.cells[RowOrder].textContent);
            if (isNaN(aValue) || isNaN(bValue)) {
              return 0; // Skip non-numeric values
            }
            if (aValue < bValue) {
              return -1;
            } else if (aValue > bValue) {
              return 1;
            } else {
              return 0;
            }
          });
          // If RowOrder is -1, reverse the order for descending sort
          if (RowOrder === -1) {
            rows.reverse();
          }
          // Clear existing tbody rows
          while (tbody.firstChild) {
            tbody.removeChild(tbody.firstChild);
          }
          // Append sorted rows back to tbody
          rows.forEach(function(row) {
            tbody.appendChild(row);
          });


        });


      }

      function copyTablesToClipboard(TableCont_ID) {
        var body = document.body,
          range, sel;

        range = document.createRange();
        sel = window.getSelection();
        sel.removeAllRanges();
        // Append table to Bottom Of results
        $("#Temp_CopyTABLE").html('');
        $("#Temp_CopyTABLE").append(`<table id="TempTable_Results"></table>`);
        if (document.createRange && window.getSelection) {

          var ResultTables = document.querySelectorAll('#AppendedResult_TABLE table');
          var theadRow_1 = ``;
          var theadRow_2 = ``;
          var tbodyRow_1 = ``;
          // Collect all rows from each table
          var allRows = [];

          ResultTables.forEach(function(table) {
            var Theadss = table.querySelectorAll('thead tr');
            Theadss.forEach(function(trs) {
              if (trs.children.length == 2) {
                theadRow_1 += trs.innerHTML;
              }
              if (trs.children.length == 5) {
                theadRow_2 += trs.innerHTML;
              }
            });

            var Tbodyss = table.querySelector('tbody');
            var Rowss = Array.from(Tbodyss.rows);
            allRows.push(Rowss);
          });
          var new_Tbody = document.createElement("tbody");
          // Determine the maximum length (in case tables have different row counts)
          var maxRowss = Math.max(...allRows.map(Rowss => Rowss.length));
          // Iterate over the maximum number of rows
          for (var i = 0; i < maxRowss; i++) {
            var newRow = document.createElement("tr");
            // Iterate over each table's rows and append cells to the new row
            allRows.forEach(function(Rowss) {
              if (Rowss[i]) {
                // If the row exists, add its cells
                Array.from(Rowss[i].cells).forEach(cell => {
                  var newCell = document.createElement("td");
                  newCell.innerHTML = cell.innerHTML;
                  // Check if the cell has the hidden attribute and preserve it
                  if (cell.hasAttribute('hidden')) {
                    newCell.setAttribute('hidden', '');
                  }
                  newRow.appendChild(newCell);
                });
              } else {
                // If no row exists, add empty cells to maintain the structure
                var numCells = Rowss[0].cells.length; // Assumes first row defines the number of columns
                for (var j = 0; j < numCells; j++) {
                  var emptyCell = document.createElement("td");
                  emptyCell.innerHTML = "";
                  newRow.appendChild(emptyCell);
                }
              }
            });
            // Append the new row to the new tbody
            new_Tbody.appendChild(newRow);
          }

          var new_Thead = `<thead><tr>` + theadRow_1 + `</tr><tr>` + theadRow_2 + `</tr></thead>`;
          $('#TempTable_Results').append(new_Thead);
          $('#TempTable_Results').append(new_Tbody);

          try {
            range.selectNodeContents(document.getElementById(TableCont_ID));
            sel.addRange(range);
          } catch (e) {
            range.selectNode(document.getElementById(TableCont_ID));
            sel.addRange(range);
          }

          document.execCommand("copy");
          sel.removeAllRanges();
          $("#Temp_CopyTABLE").html('');

        } else if (body.createTextRange) {
          range = body.createTextRange();
          elements.forEach(function(TableCont_ID) {
            range.moveToElementText(document.getElementById(TableCont_ID));
            range.select();
            range.execCommand("Copy");
            $("#Temp_CopyTABLE").html('');
          });
        }
        copyTablesToClipboard_Success();
      }

      $('#Picks_StartTime').click(function() {
        Selector_Start_OR_End_Picks = "picking_start_Time";
        if (ShadowRoot_markerX.length > 0) {
          ShadowRoot_markerX.forEach(function(elmnt) {
            elmnt.style.stroke = "#39b54a";
            elmnt.style.strokeDasharray = ""; //// its cammelCase wich the Capital become - dashed ==> stroke-dasharray
            // elmnt.style.strokeWidth = "1"; // its cammelCase wich the Capital become - dashed ==> stroke-width is unchange so no need
          });
        }
      });
      $('#Picks_EndTime').click(function() {
        Selector_Start_OR_End_Picks = "picking_end_Time";
        if (ShadowRoot_markerX.length > 0) {
          ShadowRoot_markerX.forEach(function(elmnt) {
            elmnt.style.stroke = "#ff1d25";
            elmnt.style.strokeDasharray = ""; //// its cammelCase wich the Capital become - dashed ==> stroke-dasharray
          });
        }
      });
      $('#Quit_PickMode').click(function() {
        Selector_Start_OR_End_Picks = "";
        if (ShadowRoot_markerX.length > 0) {
          ShadowRoot_markerX.forEach(function(elmnt) {
            elmnt.style.stroke = "#7d7d7d";
            elmnt.style.strokeDasharray = "5, 4"; //// its cammelCase wich the Capital become - dashed ==> stroke-dasharray
          });
        }
      });

      $('#Btn_Erase_Time_Picks').click(function() {
        Selector_Start_OR_End_Picks = "";
        TimeStamp_Selected_Start_TZ = ""; // DUmmy ajaaa formatnya 03:20:00.000
        TimeStamp_Selected_Start_MS = "";
        TimeStamp_Selected_End_TZ = ""; // DUmmy ajaaa ini harus lebih kecil biar gak trigger function  formatnya 03:20:00.000
        TimeStamp_Selected_End_MS = "";

        LOCK_TS_STRT_Pick = false;
        LOCK_TS_END_Pick = false;

        document.getElementById('input_starttime').value = "";
        document.getElementById('input_endtime').value = "";

        marker_remove("EndX");
        marker_remove("StartX");

        // Uncheck MDB4 radio buttons by setting prop to false
        $('#Picks_StartTime').prop("checked", false).parent().removeClass('active');
        $('#Picks_EndTime').prop("checked", false).parent().removeClass('active');
        $('#Quit_PickMode').prop("checked", false).parent().removeClass('active');

        $("#input_starttime").prop("disabled", true);
        $("#input_endtime").prop("disabled", true);
        $("#Appended_DtOption_PopUp").html('');

        st_lockeds = document.querySelectorAll('.TimeStamp_Start_Color, .TimeStamp_End_Color');
        st_lockeds.forEach(st_locked => {
          st_locked.classList.remove('TimeStamp_Start_Color');
          st_locked.classList.remove('TimeStamp_End_Color');
        });
        Reset_Form_PickersParameter();

        if (ShadowRoot_markerX.length > 0) {
          ShadowRoot_markerX.forEach(function(elmnt) {
            elmnt.style.stroke = "#7d7d7d";
            elmnt.style.strokeDasharray = "5, 4"; //// its cammelCase wich the Capital become - dashed ==> stroke-dasharray
          });
        }

      });

      function Init_EachStreamContainer(Channel_Selection, RawChannel_Selection) {
        // Chek if exist, if not then append
        if (Channel_Selection) {
          if ($('#Each_stream_' + Channel_Selection).length) {
            // console.log(Channel_Selection + " is Exist"); // Do Nothing
          } else {
            // $('#Each_stream_' + Channel_Selection).remove();
            var itemHtml = `<div class="card mb-2 p-2 seismograph-container w-100" id="Each_stream_${Channel_Selection}"></div>`;
            $("#append_data_stream").append(itemHtml);

            const checkSeimogram = document.querySelector(`#Each_stream_${Channel_Selection} sp-seismograph`);

            if (checkSeimogram) {
              console.log("Seismogram Exist");
              const checkSVG = checkSeimogram.shadowRoot.querySelector('svg');
              const checkCanvas = checkSeimogram.shadowRoot.querySelector('foreignObject canvas');
              if (checkSVG && checkCanvas) {
                console.log("SVG & Canvas Exist ");
              } else {
                // Init_WaveFormSeismogram(Channel_Selection); //Ini kalau bisa pakai module, kalau ndak pakai nomodle tag
                Init_Selected_WaveFormSeismogram(Channel_Selection, RawChannel_Selection); //Ini kalau bisa pakai module, kalau ndak pakai nomodle tag
              }
            } else {
              // Init_WaveFormSeismogram(Channel_Selection); //Ini kalau bisa pakai module, kalau ndak pakai nomodle tag
              Init_Selected_WaveFormSeismogram(Channel_Selection, RawChannel_Selection); //Ini kalau bisa pakai module, kalau ndak pakai nomodle tag
            }
          }
        } else {
          $('#Load_00_NoChannel_wrapper').prop("hidden", false);
        }
      };


      function Init_PopUpOption_Click(Fetch_Channel, Fetch_StationName, Fetch_DataIMG, Fetch_DataDomain_raw, Fetch_DataDomain_rounded, Frequency_Volt, Data_Window) {
        var ContentHtmlX = `<div class="col-lg-2 col-md-3 col-6">
                            <input type="radio" id="control_` + Fetch_StationName + `" name="DtOption_PopUp" value="` + Fetch_Channel + `" datas-raw-freq="` + Fetch_DataDomain_raw + `" datas-round-freq="` + Fetch_DataDomain_rounded + `" datas-windowing="` + Data_Window + `" datas-volt-amp="` + Frequency_Volt + `">
                            <label for="control_` + Fetch_StationName + `" class="card to_be_pulsees mee_rounded px-4 py-4">
                              <div class="row m-0 p-0">
                                <div class="col text-center">
                                  <p class="font-weight-bold m-0 p-0"><u>Parameter Freq</u></p><br><br>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-4 rounded white p-0 ">
                                  <a class="img-thumbnail img-fluid" href="data:image/png;base64, ` + Fetch_DataIMG + `" title="FreqDomain_IMG_` + Fetch_Channel + `" data-lightbox="FdomainGroup_` + Fetch_Channel + `">
                                    <img class="img-fluid" src="data:image/png;base64, ` + Fetch_DataIMG + `" alt="FreqDomain_IMG_` + Fetch_Channel + `">
                                  </a>
                                </div>
                                <div class="col-8 ">
                                  <p> &nbsp;⨍ == ` + (parseFloat(Fetch_DataDomain_raw).toFixed(6)) + `Hz 
                                    <br>
                                    ≈⨏ == ` + Fetch_DataDomain_rounded + `&nbsp;&nbsp;&nbsp;&nbsp;Hz
                                    <br><br>
                                    ∑ :` + Data_Window + ` &nbsp;|&nbsp;
                                    λ :` + Frequency_Volt + `
                                  </p>
                                </div>
                              </div>
                            </label>
                          </div>
                          `;
        $("#Appended_DtOption_PopUp").html(ContentHtmlX);
        Reset_Form_PickersParameter();

        var Data_Option_Stp02 = document.querySelectorAll('input[name="DtOption_PopUp"]');

        Data_Option_Stp02.forEach(function(DtOpt) {
          DtOpt.addEventListener('click', DtOption_PopUp_GotSelected);
        });

      }



      function Init_FinalResults_toTables(DataFinals) {
        let Keys_FinalDataX = DataFinals.channels;

        Keys_FinalDataX.forEach(function(key_Final) {
          // console.log(key_Final);
          // console.log(DataFinals[key_Final]);
          var nama_station_channel = DataFinals[key_Final]['data_Streams'];
          var images_each = DataFinals[key_Final]['img'];
          var images_each_spectogrm = DataFinals[key_Final]['img_spectogrm'];

          var ResultHtml_IMG = `<div class="col">
                        <div class="row">
                            <div class="col">
                              <a class="img-thumbnail img-fluid" href="data:image/png;base64, ` + images_each + `" title="image_pick_` + key_Final + `" data-lightbox="group_` + key_Final + `">
                              <img class="img-fluid" src="data:image/png;base64, ` + images_each + `" alt="image_pick_` + key_Final + `" >
                              </a>
                            </div>
                            <div class="col">
                              <a class="img-thumbnail img-fluid" href="data:image/png;base64, ` + images_each_spectogrm + `" title="image_spec_` + key_Final + `" data-lightbox="group_` + key_Final + `">
                              <img class="img-fluid" src="data:image/png;base64, ` + images_each_spectogrm + `" alt="image_spec_` + key_Final + `" >
                              </a>
                            </div>
                      </div>`;
          $("#AppendedResult_IMG").append(ResultHtml_IMG);



          var ResultHtml_TABLE = `<div class="col">
                       <div class="table-responsive text-nowrap text-center" id="table_container` + key_Final + `">
                         <center>
                           <table class="table table-striped" id="table_` + key_Final + `" style="width: 80%;">

                             <thead class="black white-text">
                               <tr>
                                 <th colspan="3"><center><b>Hasil Picking ` + nama_station_channel + `</b></center></th>
                                 <th></th>
                               </tr>
                               <tr>
                                 <th scope="col" hidden></th>
                                 <th scope="col">Peak</th>
                                 <th scope="col">Valley</th>
                                 <th scope="col">Sensitivitas</th>
                                 <th></th>
                               </tr>
                             </thead>
                             <tbody>

                             </tbody>
                           </table>
                         </center>
                       </div>
                     </div>
                   </div> `;
          $("#AppendedResult_TABLE").append(ResultHtml_TABLE);

          table_tbody_ref = document.getElementById("table_" + key_Final + "").getElementsByTagName('tbody')[0];

          var data_peaks = DataFinals[key_Final]['data_peaks'];
          var data_valleys = DataFinals[key_Final]['data_valleys'];
          var data_sensitivity = DataFinals[key_Final]['data_sensitivity'];

          var array_to_three_col = data_sensitivity.map(function(element, indx) {
            return [indx, data_peaks[indx], data_valleys[indx], data_sensitivity[indx], null]
          });
          // console.log(array_to_three_col);

          for (var idx = 0; idx < data_sensitivity.length; idx++) {
            // create a new row
            var newRow = table_tbody_ref.insertRow(table_tbody_ref.length);
            for (var j = 0; j < array_to_three_col[idx].length; j++) {
              // create a new cell
              var cell = newRow.insertCell(j);

              // add value to the cell
              cell.innerHTML = array_to_three_col[idx][j];
              // add class to the first cell
              if (j === 0) {
                cell.hidden = true;
              }
            }
          }

        });


      }


      function Picked_This_TimeeX(Start_Or_End, UnixTimeStamps) {
        let The_Hour = formatUnixTimestampToUTC(UnixTimeStamps, "H:i:s.L");
        let The_TZs = formatUnixTimestampToUTC(UnixTimeStamps, "Y-m-dTH:i:s.LZ");
        let Seisplot_Format = Convert_To_Seisplot_Time(The_TZs);

        if (Start_Or_End == "picking_start_Time") {
          TimeStamp_Selected_Start_TZ = The_TZs;
          TimeStamp_Selected_Start_MS = UnixTimeStamps;
          marker_remove("StartX");
          markers_Adds('add', 'StartX', 'Start-Type', Seisplot_Format);
          $("#input_starttime").prop("disabled", false);
          $("#input_starttime").val(The_Hour);
          // Manually trigger the 'change' event
          $("#input_starttime").trigger('change');
        }
        if (Start_Or_End == "picking_end_Time") {
          TimeStamp_Selected_End_TZ = The_TZs;
          TimeStamp_Selected_End_MS = UnixTimeStamps;
          marker_remove("EndX");
          markers_Adds('add', 'EndX', 'pick', Seisplot_Format);
          $("#input_endtime").prop("disabled", false);
          $("#input_endtime").val(The_Hour);
          // Manually trigger the 'change' event
          $("#input_endtime").trigger('change');
        }
      }

      // Picked_By_TimeStamp_Click And Hoverrrr
      function Attach_TimeStamp_Events(The_xTicks) {
        The_xTicks.forEach(function(tick) {
          tick.addEventListener("mouseover", TimeStamp_Ticker_Hovers);
          tick.addEventListener("mouseout", TimeStamp_Ticker_MouseOut);
          tick.addEventListener("click", TimeStamp_Ticker_Clicks);
        });
      }

      function TimeStamp_Ticker_Hovers() {
        if (Selector_Start_OR_End_Picks == "picking_start_Time") {
          if ($(this).hasClass('Locked_TS_Start') || $(this).hasClass('Locked_TS_End')) {} else {
            $(this).css(styling_startTIme);
          }
        } else if (Selector_Start_OR_End_Picks == "picking_end_Time") {
          if ($(this).hasClass('Locked_TS_Start') || $(this).hasClass('Locked_TS_End')) {} else {
            $(this).css(styling_endTIme);
          }
        } else {}
      }

      function TimeStamp_Ticker_MouseOut() {
        if ($(this).hasClass('Locked_TS_Start') || $(this).hasClass('Locked_TS_End')) {} else {
          $(this).removeAttr('style');
        }
      }

      function TimeStamp_Ticker_Clicks() {
        if (Selector_Start_OR_End_Picks == "picking_start_Time") {
          xTicks.forEach(function(tick) {
            $(tick).removeClass('Locked_TS_Start');
          });
          LOCK_TS_STRT_Pick = true;
          $(this).css(styling_startTIme);
          $(this).addClass('Locked_TS_Start');

          Picked_This_TimeeX(Selector_Start_OR_End_Picks, new Date(this.__data__).valueOf())

        } else if (Selector_Start_OR_End_Picks == "picking_end_Time") {
          xTicks.forEach(function(tick) {
            $(tick).removeClass('Locked_TS_End');
          });
          LOCK_TS_END_Pick = true;
          $(this).css(styling_endTIme);
          $(this).addClass('Locked_TS_End');
          Picked_This_TimeeX(Selector_Start_OR_End_Picks, new Date(this.__data__).valueOf())
        } else {}
      }
      // Picked_By_TimeStamp_Click And Hoverrrr



      function markers_Adds(add_or_rem, str_label, str_type, time_moment) {
        if (add_or_rem == 'add') {
          CurrentSeismogram_Lists.forEach(CurrentSeismogram => CurrentSeismogram.addMarkers({
            name: str_label,
            markertype: str_type,
            type: str_type,
            description: 'Mee Time',
            time: time_moment
          }));
          GraphSeismo_Lists.forEach(g => g.drawMarkers());
        }
      };


      function marker_remove(name_of_marker) {
        CurrentSeismogram_Lists.forEach(CurrentSeismogram =>
          CurrentSeismogram['markerList'].forEach((item, index) => {
            if (item.name == name_of_marker) {
              CurrentSeismogram['markerList'].splice(index, 1);
            }
          }));
        GraphSeismo_Lists.forEach(g => g.drawMarkers());
      }


      // Detector Both ID TimstampChanged so compare it
      $("#input_starttime, #input_endtime").on('change', function(event) {
        CompareTimeStampPicked();
      });


      function CompareTimeStampPicked() {
        if (TimeStamp_Selected_Start_MS && TimeStamp_Selected_End_MS) {
          if (TimeStamp_Selected_Start_MS < TimeStamp_Selected_End_MS) {
            get_domain_freq(TimeStamp_Selected_Start_TZ, TimeStamp_Selected_End_TZ);
          }
        };
      }

      // Langkah proses 2 freq domain freq_domain frekuensi pick frequency domain
      function get_domain_freq(StartTime_TZ, EndTime_TZ) {
        if (StartTime_TZ && EndTime_TZ && CurrentMseedFile && Selected_Digitizer && SelectedChannel_Lists.length > 0) {

          const AppendedFormData = new FormData();

          AppendedFormData.append('Step02_MseedFile', CurrentMseedFile);
          AppendedFormData.append('DigitizerType', JSON.stringify(Selected_Digitizer));
          AppendedFormData.append('ChannelSelected', JSON.stringify(SelectedChannel_Lists));
          const Time_Deltas = JSON.stringify({
            "starts": StartTime_TZ,
            "ends": EndTime_TZ
          });
          AppendedFormData.append('TimeDeltas', Time_Deltas);

          $.ajax({
            url: "script/02_get_freq_domain_mseed.php",
            type: "POST",
            data: AppendedFormData,
            dataType: 'json',
            contentType: false,
            processData: false,
            cache: false,
            beforeSend: function() {
              $('#Load_02_MseedParams_wrapper').prop("hidden", false);
            },
            success: function(response) {

              $('#Load_02_MseedParams_wrapper').prop("hidden", true);
              $("#Appended_DtOption_PopUp").html('');

              if ((!response.error || !response.data.error) && response.data) {

                var Fetch_Channel_Lists = response.data.channels;

                Fetch_Channel_Lists.forEach(function(Fetch_Channel) {

                  var Fetch_StationName = response.data[Fetch_Channel]['data_Streams'];
                  var Fetch_DataIMG = response.data[Fetch_Channel]['img'];
                  var Fetch_DataDomain = response.data[Fetch_Channel]['data_freqs_domain'];
                  // Matching data With Digitizer Parameter
                  var Frequency_Volt = Selected_Digitizer_Parameter[Selected_Digitizer]["freq_volt"][Fetch_DataDomain.rounded];
                  var Data_Window = Selected_Digitizer_Parameter[Selected_Digitizer]["opt_windowed"][Fetch_DataDomain.rounded];

                  if (Fetch_StationName && Fetch_DataIMG && Fetch_DataDomain && Frequency_Volt && Data_Window) {
                    Init_PopUpOption_Click(Fetch_Channel, Fetch_StationName, Fetch_DataIMG, Fetch_DataDomain.raw, Fetch_DataDomain.rounded, Frequency_Volt, Data_Window);
                  }
                });

              } else {
                OOOOPS_picking('Errors', response.error + response.data.error);
              }

            },
            error: function(e) {
              // $("#err").html(e).fadeIn();
              $('#Load_02_MseedParams_wrapper').prop("hidden", true);
            }
          });

        }
      };


      // Langkah proses 3 Waktunya Pickiiing boss
      $('#Form_PickersParameters').submit(function(evnt) {
        evnt.preventDefault();

        const Windowing_ParamsValue = $("#Windowing_ParamsValue").val();
        const Voltage_ParamsValue = $("#Voltage_ParamsValue").val();
        const Frequency_ParamsValue = $("#Frequency_ParamsValue").val();

        if (!Selected_Digitizer) {
          $("#Digitizer_Radio_Selections").children().addClass('pulse_thiss');
          evnt.preventDefault();
          evnt.stopPropagation();
          return false;
        }
        if (!SelectedChannel_Lists.length > 0) {
          evnt.preventDefault();
          evnt.stopPropagation();
          return false;
        }

        if (!Windowing_ParamsValue || !Voltage_ParamsValue || !Frequency_ParamsValue) {
          $(".to_be_pulsees").addClass('pulse_thiss');
          evnt.preventDefault();
          evnt.stopPropagation();
          return false;
        }

        if (!Constanta_ParamsValue) {
          evnt.preventDefault();
          evnt.stopPropagation();
          return false;
        }

        if (!TimeStamp_Selected_Start_TZ) {
          evnt.preventDefault();
          evnt.stopPropagation();
          return false;
        }
        if (!TimeStamp_Selected_End_TZ) {
          evnt.preventDefault();
          evnt.stopPropagation();
          return false;
        }


        if (SelectedChannel_Lists.length > 0 && Windowing_ParamsValue && Voltage_ParamsValue && Frequency_ParamsValue && Constanta_ParamsValue && TimeStamp_Selected_Start_TZ && TimeStamp_Selected_End_TZ) {
          const AppndForm_ForProccess_03 = new FormData();

          const Time_Deltas = JSON.stringify({
            "starts": TimeStamp_Selected_Start_TZ,
            "ends": TimeStamp_Selected_End_TZ
          });
          const Calibrate_Opt = JSON.stringify({
            "windowing": Windowing_ParamsValue,
            "voltage": Voltage_ParamsValue,
            "frequency": Frequency_ParamsValue,
            "constanta": Constanta_ParamsValue
          });

          AppndForm_ForProccess_03.append('Step03_MseedFile', CurrentMseedFile);
          AppndForm_ForProccess_03.append('ChannelSelected', JSON.stringify(SelectedChannel_Lists));
          AppndForm_ForProccess_03.append('TimeDeltas', Time_Deltas);
          AppndForm_ForProccess_03.append('CalibrateOption', Calibrate_Opt);

          $.ajax({
            url: "script/03_get_final_proccessed_mseed.php",
            type: "POST",
            data: AppndForm_ForProccess_03,
            dataType: 'json',
            contentType: false,
            processData: false,
            cache: false,
            beforeSend: function() {
              $('#Load_03_BearPicking_wrapper').prop("hidden", false);
            },
            success: function(response) {
              $('#Load_03_BearPicking_wrapper').prop("hidden", true);
              $("#AppendedResult_IMG").html('');
              $("#AppendedResult_TABLE").html('');

              if ((!response.error && !response.data.error) && response.data) {

                Init_FinalResults_toTables(response.data);

                $('#Final_rslt_Modal').modal('show');
              } else {
                OOOOPS_picking('Errors', response.error + response.data.error);
              }

            },
            error: function(e) {
              // $("#err").html(e).fadeIn();
              $('#Load_02_MseedParams_wrapper').prop("hidden", true);
            }
          });

        }

      });





      $('#ch_selectors').on('change', function() {
        const selectedOpt = $(this).find('option:selected');

        SelectedChannel_Lists = [];
        local_SelectedChannelId_Lists = [];

        if (selectedOpt.length > 0) {
          selectedOpt.each(function() {
            if ($(this).val() != "") {
              // $(this).text() itu hasilnya "HNE"...., tapi dari <opt>TEXT</opt>
              // $(this).val() itu hasilnya  "HNE"....
              // $(this).attr('orig_val') itu hasilnya "IA.MBPI.00.HNE"....
              SelectedChannel_Lists.push($(this).val());
              local_SelectedChannelId_Lists.push('Each_stream_' + $(this).val());
              // Draw Seismogram Container and Graph
              Init_EachStreamContainer($(this).val(), $(this).attr('orig_val'));
            }

          });

        } else {
          SelectedChannel_Lists = [];

          $("div[id^='Each_stream_']").hide();
          $("#input_starttime").prop("disabled", true);
          $("#input_endtime").prop("disabled", true);

          $('#Btn_Erase_Time_Picks').click();
          $("#Btn_Erase_Time_Picks").addClass("disss");
          $("#Btn_Erase_Time_Picks").prop("disabled", true);

          $('#Start_OR_End_Selection').find("label").each(function() {
            $(this).addClass('your-class'); // Add a class to each label

            $(this).find('input[type="radio"').prop("disabled", true);
            $(this).find('input[type="radio"').prop("checked", false);
          });

          $('#Load_00_NoChannel_wrapper').prop("hidden", false);

          Reset_Form_PickersParameter();
        }

        // Buat Toggle Hide or show Seismogram dari tampilan
        $("div[id^='Each_stream_']").each(function() {
          var id_ = $(this).attr("id")
          //check if not in array
          if (local_SelectedChannelId_Lists.indexOf(id_) == -1) {
            $(this).hide(); //hide it
          } else {
            $(this).show();

            $('#Btn_Erase_Time_Picks').click();
            $("#Btn_Erase_Time_Picks").removeClass("disss");
            $("#Btn_Erase_Time_Picks").prop("disabled", false);

            $('#Start_OR_End_Selection').find("label").each(function() {
              $(this).addClass('your-class'); // Add a class to each label

              $(this).find('input[type="radio"').prop("disabled", false);
              $(this).find('input[type="radio"').prop("checked", false);
            });

            $('#Load_00_NoChannel_wrapper').prop("hidden", true);
          }
        });

      });



      function Reset_Form_PickersParameter() {
        $("#Windowing_ParamsValue").prop("disabled", true);
        $("#Frequency_ParamsValue").prop("disabled", true);
        $("#Voltage_ParamsValue").prop("disabled", true);

        $("#Windowing_ParamsValue").val('');
        $("#Frequency_ParamsValue").val('');
        $("#Voltage_ParamsValue").val('');
      }

      function Digitizer_Radio_Checked(evnt) {
        const TempDgtzrSelect = $(this).find('input:checked').val();

        if (TempDgtzrSelect) {
          Selected_Digitizer = TempDgtzrSelect;
          $(this).children().removeClass('pulse_thiss');
          const value_cons = Selected_Digitizer_Parameter[Selected_Digitizer]["constanta"];
          Constanta_ParamsValue = parseFloat(value_cons);
          $("#Constanta_ParamsValue").val(parseFloat(value_cons));
          $("#Constanta_ParamsValue").prop("disabled", false);
          $("#Constanta_ParamsValue").siblings('label').addClass('active');

          $("#ch_selectors").prop("disabled", false);
          $("#ch_selectors").materialSelect();
        } else {
          $(this).children().addClass('pulse_thiss');
        }
      }



      $('#Start_OR_End_Selection').on("change", function() {
        const Strt_or_end = $(this).find('input:checked').val();
        if (Strt_or_end == "picking_start_Time") {
          Selector_Start_OR_End_Picks = Strt_or_end;
          // current_picks = "start_pick_time";
          if (ShadowRoot_markerX.length > 0) {
            ShadowRoot_markerX.forEach(function(elmnt) {
              elmnt.style.stroke = "#39b54a";
              elmnt.style.strokeDasharray = ""; //// its cammelCase wich the Capital become - dashed ==> stroke-dasharray
              // elmnt.style.strokeWidth = "1"; // its cammelCase wich the Capital become - dashed ==> stroke-width is unchange so no need
            });
          }
        }
        if (Strt_or_end == "picking_end_Time") {
          Selector_Start_OR_End_Picks = Strt_or_end;
          // current_picks = "end_pick_time";
          if (ShadowRoot_markerX.length > 0) {
            ShadowRoot_markerX.forEach(function(elmnt) {
              elmnt.style.stroke = "#ff1d25";
              elmnt.style.strokeDasharray = ""; //// its cammelCase wich the Capital become - dashed ==> stroke-dasharray
            });
          }
        }


      });





      function DtOption_PopUp_GotSelected(e) {
        if (this.checked) {
          $(".to_be_pulsees").removeClass('pulse_thiss');

          const raw_freqs = this.getAttribute('datas-raw-freq');
          const round_freqs = this.getAttribute('datas-round-freq');
          const windowing_dats = this.getAttribute('datas-windowing');
          const volt_amp_dats = this.getAttribute('datas-volt-amp');

          $("#Frequency_ParamsValue").val(parseFloat(round_freqs));
          $("#Frequency_ParamsValue").prop("disabled", false);
          $("#Frequency_ParamsValue").siblings('label').addClass('active');

          $("#Voltage_ParamsValue").val(parseFloat(volt_amp_dats));
          $("#Voltage_ParamsValue").prop("disabled", false);
          $("#Voltage_ParamsValue").siblings('label').addClass('active');

          $("#Windowing_ParamsValue").val(parseInt(windowing_dats));
          $("#Windowing_ParamsValue").prop("disabled", false);
          $("#Windowing_ParamsValue").siblings('label').addClass('active');
        }
      }





      //  Triger refresh window kalau di tutup modal pertama
      $('#Wave_containerModal').on('hidden.bs.modal', function(e) {
        if (window.history.replaceState) {
          window.history.replaceState(null, null, window.location.href);
        }
        window.location = window.location.href;
      });



      $('#Final_rslt_Modal').on('hidden.bs.modal', function(e) {
        $('#Chkbox_SortValues').prop('checked', false);
      });


      // AWAIT AND ASYNC Function ==================================================
      // AWAIT AND ASYNC Function ==================================================

      // Helper function to wait for an element to be available in the DOM
      function waitForElement(selector, timeout = 5000) {
        return new Promise((resolve, reject) => {
          const startTime = Date.now();

          const interval = setInterval(() => {
            const element = document.querySelector(selector);

            if (element) {
              clearInterval(interval);
              resolve(element);
            } else if (Date.now() - startTime > timeout) {
              clearInterval(interval);
              reject(`Element with selector ${selector} not found within ${timeout}ms`);
            }
          }, 100);
        });
      }

      // Helper function to wait for an element within a shadow DOM
      function waitForElementInShadowDOM(parentElement, selector, timeout = 5000) {
        return new Promise((resolve, reject) => {
          const startTime = Date.now();

          const interval = setInterval(() => {
            const element = parentElement.shadowRoot.querySelector(selector);

            if (element) {
              clearInterval(interval);
              resolve(element);
            } else if (Date.now() - startTime > timeout) {
              clearInterval(interval);
              reject(`Element ${selector} in shadow DOM not found within ${timeout}ms`);
            }
          }, 100);
        });
      }





      // Copy paste CSS=====================================================

      function cssX(a) {
        var sheets = document.styleSheets,
          o = {};
        for (var i in sheets) {
          var rules = sheets[i].rules || sheets[i].cssRules;
          for (var r in rules) {
            if (a.is(rules[r].selectorText)) {
              o = $.extend(o, cssX2json(rules[r].style), cssX2json(a.attr('style')));
            }
          }
        }
        return o;
      }

      function cssX2json(csstgt) {
        var s = {};
        if (!csstgt) return s;
        if (csstgt instanceof CSSStyleDeclaration) {
          for (var i in csstgt) {
            if ((csstgt[i]).toLowerCase) {
              s[(csstgt[i]).toLowerCase()] = (csstgt[csstgt[i]]);
            }
          }
        } else if (typeof csstgt == "string") {
          csstgt = csstgt.split("; ");
          for (var i in csstgt) {
            var l = csstgt[i].split(": ");
            s[l[0].toLowerCase()] = (l[1]);
          }
        }
        return s;
      }
      // Copy paste CSS=====================================================
    </script>





  <?php
  }

  // *********************************************** //
  // **********	FORM HAS BEEN SUBMITTED	********** //
  // *********************************************** //

  else if (isset($_POST['submit'])) {

    /* Check and assign submitted Username and Password to new variable */
    $Usernames = isset($_POST['username']) ? $_POST['username'] : '';
    $Passwords = isset($_POST['password']) ? $_POST['password'] : '';

    // if ($_POST['username'] == $username && $_POST['password'] == $password) {
    if (isset($logins_usr_PW_pairs[$Usernames]) && $logins_usr_PW_pairs[$Usernames] == $Passwords) {

      //IF USERNAME AND PASSWORD ARE CORRECT SET THE LOG-IN SESSION
      $_SESSION['Logged_Datas'] = $hash;
      header("Location: $self_url");
    } else {

      // DISPLAY FORM WITH ERROR
      display_login_form();
      echo "<script> OOOOPS_Login(); </script>";
    }
  }


  // *********************************************** //
  // **********	SHOW THE LOG-IN FORM	********** //
  // *********************************************** //

  else {
    display_login_form();
  }

  ?>

  <XXXXXX></XXXXXX>



</body>






</html>