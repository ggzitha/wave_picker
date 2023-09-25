<?php
ob_start();
session_start();
// ***************************************** //
// **********	DECLARE VARIABLES  ********** //
// ***************************************** //

// $username = 'inskal';
// $password = 'password';

$random1 = 'secret_key1';
$random2 = 'secret_key2';

$logins_usr_PW_pairs = array(
  'inskal' => 'inskal',
  'admin' => 'admin',
  'user'=> 'user',
  'mee' => 'qwertyuiop'
);

$hash = md5($random1  . $random2);

$self_url = $_SERVER['PHP_SELF'];


// ************************************ //
// **********	USER LOGOUT  ********** //
// ************************************ //

if (isset($_GET['logout'])) {
  unset($_SESSION['Logged_Datas']);
  header("Location: $self_url");
}

?>

<!DOCTYPE html>



<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">


<head>
  <meta charset="UTF-8">
  <title>The Wave</title>
  <meta name="author" content="ggzitha">
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">



  <link rel="stylesheet" type="text/css" href="assets/vendor/mdbootstrap_4_mee/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="assets/vendor/mdbootstrap_4_mee/css/mdb.min.css">
  <link rel="stylesheet" type="text/css" href="assets/vendor/mdbootstrap_4_mee/css/style.css">
  <link rel="stylesheet" type="text/css" href="assets/vendor/mdbootstrap_4_mee/plugins/MDB-File-Upload/css/addons/mdb-file-upload.css">
  <link rel="stylesheet" type="text/css" href="assets/vendor/fontawesomePro/css/all.min.css">
  <link rel="stylesheet" href="assets/vendor/roundSlider-1.6.1/roundslider.css" />
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

    #loader-wrapper {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 2000;
      background: #00000099;
    }
    #loader-wrapper1 {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 2000;
      background: #00000099;
    }
    #loader-wrapper1 .mt-3.text-center {
      position: relative;
      margin-bottom: 0% !important;
      padding-bottom: 0% !important;
      margin-top: 25% !important;
    }
    #loader-wrapper2 {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 2000;
      background: #00000099;
    }

    #input_ms:disabled ~ label, #input_ms:disabled ~ span {
        opacity: 0.2;
      }
      

    #input_starttime:disabled, .md-form>#input_starttime:disabled+label {
        opacity: 0.2;
      }
    #input_endtime:disabled, .md-form>#input_endtime:disabled+label {
        opacity: 0.2;
      }


      #ch_selectors:disabled, .md-form>#ch_selectors:disabled+label {
        opacity: 0.2;
      }
    #number_checked:disabled, .md-form>#number_checked:disabled+label {
        opacity: 0.2;
      }
    #freq_number:disabled, .md-form>#freq_number:disabled+label {
        opacity: 0.2;
      }
    #volt_number:disabled, .md-form>#volt_number:disabled+label {
        opacity: 0.2;
      }
    #const_number:disabled, .md-form>#const_number:disabled+label {
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



.purple-gradient-mee:not([disabled]):not(.disabled):active, .purple-gradient-mee:not([disabled]):not(.disabled).active, .show > .purple-gradient-mee.dropdown-toggle{
  background: linear-gradient(0deg, #ff009773, #b1aff4a1) !important;
  color: #fff;
  font-weight: 900;
  box-shadow: rgb(243, 25, 229) 0px 1px 2px 0px, rgb(208, 55, 205) 0px 2px 6px 2px;
}


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
	bottom: -45px;
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
input[type=radio]:not(:disabled) ~ label {
  cursor: pointer;
}
input[type=radio]:disabled ~ label {
  color: #bcc2bf;
  border-color: #bcc2bf;
  box-shadow: none;
  cursor: not-allowed;
}

 input[type=radio]:hover + label  {
  border: 2px solid #20df80;
  /* box-shadow: 0px 0px 10px rgba(0, 255, 128, 0.25); */
  transform: translateY(-4%);
}
 input[type=radio]:checked + label  {
  background: #20df80;
  color: white;
  box-shadow: 0px 0px 20px rgba(0, 255, 128, 0.75);
  transform: translateY(-2%);
}

input[type=radio]:checked + label::after {
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

.mee_rounded{
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
    -moz-box-shadow: 0 0 0 0 rgba(204,169,44, 0.4);
    box-shadow: 0 2px 5px 0 rgb(249, 52, 7);
  }
  70% {
      -moz-box-shadow: 0 0 0 10px rgba(204,169,44, 0);
      box-shadow: 0 0 0 10px rgba(215, 170, 11, 0.64);
  }
  100% {
      -moz-box-shadow: 0 0 0 0 rgba(204,169,44, 0);
      box-shadow: 0 0 0 0 rgba(215, 171, 15, 0.9);
  }
}




/* Ini Buat Time Stamp boss */
.timestamp_hovers{
    cursor:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' version='1.1' id='Layer_1' width='30' height='30' %3E%3Cg%3E%3Cpolygon fill='%2300FF00' points='14.76,22.5 14.76,9.5 6.239,9.5 15,1.054 23.761,9.5 15.24,9.5 15.24,22.5 '/%3E%3Cpath fill='%2329A329' d='M15,1.749L22.522,9H15.74h-1h-0.48H7.478L15,1.749 M15,0.36L5,10h9.26v12H1v1h28v-1H15.74V10H25L15,0.36 L15,0.36z'/%3E%3C/g%3E%3Cg%3E%3Cpath fill='%2339B54A' d='M4.575,28.751c0.351,0.188,0.862,0.346,1.402,0.346c0.8,0,1.267-0.369,1.267-0.903 c0-0.495-0.323-0.778-1.141-1.054c-0.989-0.306-1.6-0.754-1.6-1.501c0-0.824,0.782-1.438,1.959-1.438 c0.62,0,1.069,0.126,1.339,0.259l-0.216,0.559c-0.197-0.095-0.603-0.252-1.15-0.252c-0.827,0-1.142,0.433-1.142,0.794 c0,0.495,0.369,0.738,1.204,1.021c1.025,0.346,1.546,0.778,1.546,1.556c0,0.817-0.691,1.524-2.121,1.524 c-0.584,0-1.222-0.148-1.545-0.338L4.575,28.751z'/%3E%3Cpath fill='%2339B54A' d='M10.267,24.869H8.425v-0.582h4.484v0.582h-1.852v4.715h-0.791V24.869z'/%3E%3Cpath fill='%2339B54A' d='M13.892,27.918l-0.63,1.666h-0.809l2.059-5.297h0.943l2.067,5.297h-0.836l-0.647-1.666H13.892z M15.877,27.384l-0.593-1.524c-0.135-0.346-0.225-0.66-0.314-0.967h-0.018c-0.09,0.314-0.189,0.637-0.306,0.959l-0.594,1.532 H15.877z'/%3E%3Cpath fill='%2339B54A' d='M18.414,24.358c0.396-0.071,0.962-0.11,1.501-0.11c0.836,0,1.375,0.134,1.753,0.433 c0.306,0.235,0.477,0.597,0.477,1.006c0,0.699-0.504,1.163-1.142,1.352v0.023c0.468,0.142,0.746,0.519,0.89,1.068 c0.198,0.739,0.342,1.25,0.468,1.454h-0.81c-0.099-0.149-0.233-0.605-0.404-1.266c-0.18-0.73-0.503-1.006-1.213-1.029h-0.737v2.295 h-0.782V24.358z M19.196,26.771h0.8c0.836,0,1.366-0.4,1.366-1.006c0-0.684-0.566-0.982-1.393-0.99 c-0.378,0-0.647,0.032-0.773,0.063V26.771z'/%3E%3Cpath fill='%2339B54A' d='M24.483,24.869h-1.842v-0.582h4.484v0.582h-1.852v4.715h-0.791V24.869z'/%3E%3C/g%3E%3C/svg%3E%0A") 16 16, crosshair;
    color: #39B54A;
}
.timestamp_hovers_lock{
  color: #39B54A;
  font-weight: 700;
}
.timestamp_hovers_END{
    cursor:url("data:image/svg+xml,%3Csvg version='1.1' id='Layer_1' width='30' height='30' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'%3E%3Cg%3E%3Cpolygon fill='%23FF1D25' points='14.76,22.5 14.76,9.5 6.239,9.5 15,1.054 23.761,9.5 15.24,9.5 15.24,22.5 '/%3E%3Cpath fill='%239C272D' d='M15,1.749L22.522,9H15.74h-1h-0.48H7.478L15,1.749 M15,0.36L5,10h9.26v12H1v1h28v-1H15.74V10H25L15,0.36 L15,0.36z'/%3E%3C/g%3E%3Cg%3E%3Cpath fill='%239C272D' d='M10.819,27.101H8.465v1.91h2.624v0.573H7.683v-5.297h3.271v0.574H8.465v1.674h2.354V27.101z'/%3E%3Cpath fill='%239C272D' d='M12.106,29.584v-5.297h0.854l1.941,2.68c0.449,0.621,0.8,1.179,1.087,1.722l0.019-0.008 c-0.072-0.708-0.09-1.352-0.09-2.177v-2.217h0.736v5.297h-0.791l-1.923-2.688c-0.423-0.59-0.827-1.194-1.133-1.769l-0.026,0.008 c0.045,0.668,0.062,1.305,0.062,2.185v2.264H12.106z'/%3E%3Cpath fill='%239C272D' d='M18.023,24.358c0.477-0.063,1.043-0.11,1.663-0.11c1.123,0,1.923,0.229,2.453,0.66 c0.54,0.433,0.854,1.045,0.854,1.901c0,0.865-0.306,1.572-0.872,2.06c-0.566,0.495-1.501,0.762-2.678,0.762 c-0.558,0-1.025-0.023-1.421-0.062V24.358z M18.806,29.042c0.198,0.031,0.485,0.039,0.791,0.039c1.672,0,2.579-0.817,2.579-2.247 c0.009-1.25-0.8-2.044-2.453-2.044c-0.404,0-0.71,0.032-0.917,0.071V29.042z'/%3E%3C/g%3E%3C/svg%3E%0A") 16 16, crosshair;
    color: #FF1D25;
}
.timestamp_hovers_END_lock{
  color: #FF1D25;
  font-weight: 700;
}
.mee_clear_pickings {
	position: absolute;
	z-index: 99999999;
	top: 10%;
	left: 59%;
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
}


  </style>

  <!-- Head Libs -->
  <script src="assets/vendor/modernizr/modernizr.min.js"></script>



</head>

<body>




  <div id="loader-wrapper" style="z-index:999999 !important" hidden aria-hidden="true">
        <span class="loader_rockets"></span>
        <div class="mt-3 text-center">
          <h1 class=" display-4 white-text lighten-5 animated heartBeat slow infinite">Uploading Mseed</h1>
        </div>

        <div class="d-flex justify-content-center">
            <div class="spinner-border  text-info" role="status">
              <span class="sr-only">Loading...</span>
            </div>
        </div>
  </div>
  <div id="loader-wrapper1" style="z-index:999999 !important" hidden aria-hidden="true">
        <span class="loader_wave"></span>
        <div class="mt-3 text-center">
          <h1 class=" display-5 white-text lighten-5 animated tada slow infinite">Reading Mseed Param's</h1>
        </div>

        <div class="d-flex justify-content-center">
            <div class="spinner-border  text-info" role="status">
              <span class="sr-only">Loading...</span>
            </div>
        </div>
  </div>
  <div id="loader-wrapper2" style="z-index:999999 !important" hidden aria-hidden="true">
        <span class="loader_bear"></span>
        <div class="mt-3 text-center">
          <h1 class=" display-4 grey-text lighten-5 animated flipInY slower infinite">Sa BEAR, Lagi Picking</h1>
        </div>

        <div class="d-flex justify-content-center">
            <div class="spinner-border  text-light" role="status">
              <span class="sr-only">Loading...</span>
            </div>
        </div>
  </div>






  <?php
  if (isset($_SESSION['Logged_Datas']) && $_SESSION['Logged_Datas'] == $hash) {
  ?>




    <div id="home" class="viewss  bg_globs">

      <div class="container h-100 d-flex justify-content-center align-items-center">

        <div class="butt_logout_containers" style="position: absolute; top: 0px; right: 0px; display: block;">
          <a href="?logout=true" type="button" class="btn btn-outline-danger btn-rounded waves-effect btn-sm"><i class="fas fa-power-off mr-2 fa-2x white-text"></i> Log-Out</a>
        </div>


        <div class="row smooth-scroll">
          <div class="col-md-12 white-text text-center">

            <div class="wow fadeInDown" data-wow-delay="0.3s">

              <h3 class="display-3 font-weight-bold mb-2"><span><img src="images/icon/favicon.png" width="75px"></span> The Wave Pickers</h3>
              <hr class="hr-light">

            </div>

            <div class="wow fadeInUp" data-wow-delay="0.5s">
              <div class="file-upload-wrapper">
                <input type="file" id="file_mseed" name="mseed" class="file-upload" data-max-file-size="200M"  style="display:none"/>
              </div>
            </div>





          </div>
        </div>
      </div>

    </div>


    <div class="modal top fade" id="Wave_containerModal" tabindex="-1" role="dialog" aria-labelledby="Wave_containerModalTitle" aria-hidden="true" data-backdrop="static" data-mdb-backdrop="static" data-keyboard="false" data-mdb-keyboard="false">


      <div class="modal-dialog modal-dialog-centered modal-fluid modal-dialog-scrollable  mt-0" role="document">



        <div class="modal-content">

              <div class="mee_clear_pickings">
                    <a class="btn-floating btn-sm picks_button disss" id="erase_pickings" 
                    style="position: absolute; top: 0px; right: 0px;" 
                    data-toggle="tooltip" data-html="true" title="<i><u>Reset Time Pick's</u></i>"
                    disabled>
                        <i class="fa-light fa-eraser"></i>
                    </a>
              </div>


          <div class="modal-header blue lighten-2">
            <h5 class="modal-title" id="Wave_containerModalTitle">Waveform Picker's</h5>
            <button type="button" class="btn  btn-danger" data-dismiss="modal" aria-label="Close" style="position: absolute; top: 0px; right: 0px;">
              <i class="fa-solid fa-xmark-large fa-1x"></i>
            </button>
          </div>
          <div class="modal-body m-0 p-0 py-2">

            <div class="row no-gutters">

              <div class="col-7">

              



                <div class="card scroll-content scrollbar-light-blue bolds" style="min-height: 100%;" >
                    <div class="card-body " >

                    <div class=" w-100" id="append_data_stream"></div>


                    </div>
                  </div>


              </div>

              <div class="col px-2">

                <div class="card " style="position: sticky !important; top: 0px;">

                  <h5 class="card-header info-color white-text text-center py-2">
                    <strong>Parameter Picker</strong>
                  </h5>


                  <div class="card-body px-lg-4 pt-2">
                  <form style="color: #757575;" id="form_time_domain_param" name="form_time_domain_param" method="POST" enctype="multipart/form-data" >
                  </form>

                    <form style="color: #757575;" id="form_pickers_param_id" name="pickers_param" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>

                    <div class="row">
                    <div class="btn-group  btn-sm btn-block" data-toggle="buttons" id="Logger_select">
                          
                      </div>
                    </div>

                      <div class="md-form">
                        <select class="mdb-select md-form colorful-select dropdown-primary" id="ch_selectors" name="ch_selectors" multiple searchable="Cari. .." required>
                          <option value="" disabled selected>Pilih....</option>
                        </select>
                        <label class="mdb-main-label">Channel Stream</label>
                      </div>



                      <div class="row">
                        <!-- <div class="col-2">
                            <div class="switch">
                          
                              <label>
                                
                                <input type="checkbox" id="input_ms" name="input_ms" disabled>
                                <span class="lever"></span> 
                                
                                <label  class="active" for="input_ms"> Milisecond</label>
                              
                              </label>
                            </div>
                        </div> -->


                        <div class="col">
                          <div class="md-form" id="input_starttime_container" data-toggle="helper_start_Time">
                            <input  placeholder="Start time" type="text" name="input_starttime" id="input_starttime" disabled class="form-control timepicker timepicker_start_class" required>
                            <label  class="active" for="input_starttime">Start Time</label>
                            <div class="invalid-tooltip">Please select Start Time.</div>
                          </div>
                        </div>


                        <div class="col">
                          <div class="md-form" id="input_endtime_container" data-toggle="helper_end_Time">
                            <input placeholder="End time" type="text" name="input_endtime" id="input_endtime" disabled class="form-control timepicker" required>
                            <label  class="active" for="input_endtime">End Time</label>
                            <div class="invalid-feedback">Please select End Time.</div>
                          </div>
                        </div>



                      </div>

                      <div class="row">
                        <div class="col">
                          <div class="md-form input-group"  data-toggle="helper_windowing">
                            <div class="input-group-prepend">
                              <!-- <a data-toggle="tooltip" data-html="true" title="freq-kecil==>input=(~100)<br>freq-besar==>input=(~1) <u>Menyesuiakan</u>">
                                <i class="green-text text-muted fa-regular fa-messages-question"></i>
                              </a> -->
                            </div>
                            <input type="number" id="number_checked" name="number_checked" class="form-control" step="1" min="1" required>
                            <label  class="active" for="number_checked">Windowing Number </label>

                          </div>
                        </div>

                        <div class="col">
                          <div class="md-form input-group">
                            <div class="input-group-prepend">
                              <!-- <a data-toggle="tooltip" data-html="true" title="Di Excel, Kolom Frekuensi<br>Bisa Juga Dari Spectra PQL ">
                                <i class="green-text text-muted fa-regular fa-messages-question"></i>
                              </a> -->
                            </div>
                            <input type="number" id="freq_number" name="freq_number" class="form-control" step="0.001" required>
                            <label  class="active" for="freq_number">Frekuensi(Hz) </label>

                          </div>
                        </div>
                        <div class="col">
                          <div class="md-form input-group">
                            <div class="input-group-prepend">
                              <!-- <a data-toggle="tooltip" data-html="true" title="Di Excel, Kolom Amplitudo(Volt) ">
                                <i class="green-text text-muted fa-regular fa-messages-question"></i>
                              </a> -->
                            </div>
                            <input type="number" id="volt_number" name="volt_number" class="form-control" step="0.001" required>
                            <label  class="active" for="volt_number">Amplitudo(Volt) </label>


                          </div>
                        </div>



                      </div>


                      <div class="row">
                      <div class="col">
                        <div class="md-form input-group">
                          <div class="input-group-prepend">
                            <!-- <a data-toggle="tooltip" data-html="true" title="Di Excel(Rumus Sensitivitas)<br>contoh: 0.0000161935461400047 <br> 0.000788081020399124">
                              <i class="green-text text-muted fa-regular fa-messages-question"></i>
                            </a> -->
                          </div>
                          <input type="number" id="const_number" name="const_number" class="form-control" step="0.000000000000000001"  >
                          <label  class="active" for="const_number">Konstanta Perhitungan</label>

                        </div>
                        </div>
                      </div>

                      <input type="hidden" id="current_date" name="current_date">
                      <input type="hidden" id="current_dateTime_ms" name="current_dateTime_ms">

                      <input type="hidden" id="current_starts_date" name="current_starts_date">
                      <input type="hidden" id="current_ends_date" name="current_ends_date">

                      <button class="btn btn-outline-info btn-rounded btn-block z-depth-0 py-2 mt-3 waves-effect " type="submit">Proccess</button>

                      </form>
                  </div>




                  


                </div>

              </div>
            </div>
          </div>





       

        <div class="p-0 m-0 mee_offside_footer" >
                    

                    <div class="row justify-content-end" id="append_data_freqss">
                       </div>


                    
            </div>
        

            </div>
   
        <div class="modal-footer justify-content-center p-0 grey lighten-1">
          <small class="purple-text text-muted">◭@Mee ⩤Lutcx⩥ @◮</small>
        </div>

       

      </div>
    </div>





    <div class="modal fade" id="Final_rslt_Modal" tabindex="-1" role="dialog" aria-labelledby="Final_rslt_ModalTitle" aria-hidden="true" data-backdrop="static" data-mdb-backdrop="static" data-keyboard="false" data-mdb-keyboard="false">


      <div class="modal-dialog modal-dialog-centered modal-fluid modal-dialog-scrollable " role="document">


        <div class="modal-content">
          <div class="modal-header green lighten-3">
            <h5 class="modal-title" id="Final_rslt_ModalTitle">Picks By Parameter Result</h5>
            <button type="button" class="btn  btn-danger" data-dismiss="modal" aria-label="Close" style="position: absolute; top: 0px; right: 0px;">
              <i class="fa-solid fa-xmark-large fa-1x"></i>
            </button>
          </div>
          <div class="modal-body grey lighten-2">

            <div class="row" id="append_final_results">




            </div>



          </div>

        </div>
        <div class="modal-footer justify-content-center p-0 grey lighten-1">
          <small class="purple-text text-muted">◭@Mee ⩤Lutcx⩥ @◮</small>
        </div>

      </div>
    </div>





    <!-- ====================================
            SECOND ON START Times 
========================================== -->
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


    <!-- ====================================
            SECOND ON END Times 
========================================== -->
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


  <?php
  }

  function display_login_form()
  {

    $self_url = $_SERVER['PHP_SELF'];
  ?>


    <div id="home" class="viewss  bg_globs">

      <div class="container h-100 d-flex justify-content-center align-items-center">



        <!--Form with header-->
        <div class="card" style="background-color: #ffffff6b !important; width:40% !important;">

          <!--Header-->
          <div class="header  blue lighten-2 ">

            <div class="row d-flex justify-content-center">
              <h2 class=" white-text mt-4 mb-4 ">Log-in </h2>
            </div>

          </div>
          <!--Header-->

          <div class="card-body mx-4 mt-4">
            <form action="<?php echo $self_url; ?>" method='post'>
              <!--Body-->
              <div class="md-form">
                <input type="text" id="username" name="username" class="form-control">
                <label  class="active" for="username">UserName</label>
              </div>

              <div class="md-form pb-3">
                <input type="password" id="password" name="password" class="form-control">
                <label  class="active" for="password">Password</label>
              </div>

              <div class="text-center mb-4">
                <button class="btn btn-default btn-rounded" name="submit" value="submit" type="submit">Log-In<i class="fa-solid fa-paper-plane white-text ml-2"></i></i></button>
              </div>
                 <div class="text-center mb-4">
                        user dan PW : <br>
                        &nbsp;&nbsp;user::user<br>
                        &nbsp;&nbsp;admin::admin
                </div>

            </form>
          </div>

        </div>






      </div>

    </div>



    <script>
      function OOOOPS() {
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
      
    </script>



  <?php } ?>




  <script type="text/javascript" src="assets/vendor/mdbootstrap_4_mee/js/jquery.min.js"></script>

  <script type="text/javascript" src="assets/vendor/mdbootstrap_4_mee/js/popper.min.js"></script>

  <script type="text/javascript" src="assets/vendor/mdbootstrap_4_mee/js/bootstrap.min.js"></script>

  <script type="text/javascript" src="assets/vendor/mdbootstrap_4_mee/js/mdb.min.js"></script>
  <script type="text/javascript" src="assets/vendor/mdbootstrap_4_mee/plugins/MDB-File-Upload/js/addons/mdb-file-upload.min.js"></script>


  <script type="text/javascript" src="assets/vendor/lightbox2/js/lightbox.js"></script>


  <script type="text/javascript" src="assets/vendor/seisplotjs-2.0.1/seisplotjs_2.0.1_standalone.js"></script>
  <script type="text/javascript" src="assets/vendor/roundSlider-1.6.1/roundslider.js"></script>

  <script type="text/javascript" src="assets/vendor/sweetalert2-11.4.24/sweetalert2.js"></script>



  <script>
    lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true
    })
  </script>

  <script>
   (function () {
    'use strict';
    window.addEventListener('load', function () {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function (form) {
        form.addEventListener('submit', function (event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();
  </script>


  <?php
  if (isset($_SESSION['Logged_Datas']) && $_SESSION['Logged_Datas'] == $hash) {
  ?>
    <script type="text/javascript">
     
                    var current_picks = "start_pick_time";
                    var seism_selected_start = 100; // DUmmy ajaaa
                    var seism_selected_start_inMS;
                    var seism_selected_end = 10; // DUmmy ajaaa ini harus lebih kecil biar gak trigger function
                    var seism_selected_end_inMS;


                    var seisData;
                    var graph;
                    var MseedValues;
                    var MseedValues_Cross = [];

                    var selected_logger;
                    var params_logger = [];

                    var selected_chann = [];
                    var graphList = [];
                    var seisDataList = [];
                    var streamList = [];
                    var value_cahnnel = [];
                

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
                                      $('#erase_pickings').click();
                                  },
                        customClass: {
                                  // container: '',
                                  popup: 'swall_borders',
                                  // header: '...',
                                  // title: '...',
                                  // closeButton: '...',
                                  // icon: '...',
                                  // image: '...',
                                  // htmlContainer: '...',
                                  // input: '...',
                                  // inputLabel: '...',
                                  // validationMessage: '...',
                                  // actions: '...',
                                  // confirmButton: '...',
                                  // denyButton: '...',
                                  // cancelButton: '...',
                                  // loader: '...',
                                  // footer: '....',
                                  timerProgressBar: 'swall_borders_timers',
                                }
                      })
                    };

                    $('#erase_pickings').click(function () {
                        // samaain sama initial di paling atas
                        current_picks = "start_pick_time";
                        seism_selected_start = 100; // DUmmy ajaaa
                        seism_selected_start_inMS = 100;
                        seism_selected_end = 10; // DUmmy ajaaa ini harus lebih kecil biar gak trigger function
                        seism_selected_end_inMS = 10;

                        marker_remove("Ends");
                        marker_remove("Start");

                        document.getElementById('input_starttime').value= "";
                        document.getElementById('input_endtime').value= "";

                        $("#input_endtime").prop("disabled", true);

                        st_lockeds = document.querySelectorAll('.timestamp_hovers_lock, .timestamp_hovers_END_lock');
                                  st_lockeds.forEach(st_locked => {
                                    st_locked.classList.remove('timestamp_hovers_lock');
                                    st_locked.classList.remove('timestamp_hovers_END_lock');
                                    });
                        reset_window_freq_ampli();
                      });

                    function  append_from_Timestamp_picker(time_selector, this_datess, this_hour) {
                      // var date_Timestamp = document.getElementById('current_date').value;
                      // var datess_for_Timestamp = date_Timestamp.substr(0, date_Timestamp.indexOf('T'));
                      var datess_for_Timestamp = this_datess;
                      // console.log(datess_for_Timestamp);
                      // console.log(this_datess);
                      

                            if( time_selector == "start_time_hr" && current_picks == "start_pick_time"){

                              document.forms['pickers_param']['current_starts_date'].value = datess_for_Timestamp;
                              seism_selected_start = this_hour;
                              // IN MS
                              seism_selected_start_inMS = new Date(datess_for_Timestamp + ' ' +this_hour).getTime();
                              // Convert to Unix
                              // seism_selected_start_inMS = Math.floor(new Date(this_hour).getTime()/ 1000);
                              datess_To_moment = datess_for_Timestamp + 'T' + this_hour  + 'Z';
                                marker_remove("Start");
                                markers_Adds('add', 'Start', 'Start-Type', datess_To_moment);

                                document.getElementById('input_starttime').value= this_hour;
                                $("#input_starttime").prop("disabled", false);

                                
                              // console.log("st"+seism_selected_start_inMS);
                              current_picks = "end_pick_time";

                                  st_lockeds = document.querySelectorAll('.timestamp_hovers_lock');
                                  st_lockeds.forEach(st_locked => {
                                    st_locked.classList.remove('timestamp_hovers_lock');
                                    });
                              
                                start_time_class_locked = 'locked';

                                
                                get_pickertimess("end_times_init");
                            };
                            if( time_selector == "end_time_hr" && current_picks == "end_pick_time"){
                              document.forms['pickers_param']['current_ends_date'].value = datess_for_Timestamp;
                              seism_selected_end = this_hour;
                              // IN MS
                              seism_selected_end_inMS = new Date(datess_for_Timestamp + ' ' +this_hour).getTime();
                              // Convert to Unix
                              // seism_selected_start_inMS = Math.floor(new Date(this_hour).getTime()/ 1000);
                              datess_To_moment = datess_for_Timestamp + 'T' + this_hour  + 'Z';
                                marker_remove("Ends");
                                markers_Adds('add', 'Ends', 'pick', datess_To_moment);
                                
                                document.getElementById('input_endtime').value= this_hour;
                                $("#input_endtime").prop("disabled", false);
                              // console.log("end"+seism_selected_end_inMS);
                              current_picks = "start_pick_time";

                                  end_lockeds = document.querySelectorAll('.timestamp_hovers_END_lock');
                                  end_lockeds.forEach(end_locked => {
                                    end_locked.classList.remove('timestamp_hovers_END_lock');
                                        });

                              end_time_class_locked = 'locked';
                            };

                            if(seism_selected_start_inMS && seism_selected_end_inMS){
                                if(seism_selected_start_inMS < seism_selected_end_inMS ){
                                  get_domain_freq(seism_selected_start , seism_selected_end);
                                }
                            };
                      
                    }


                    function init_logger_select() {
                      // console.log(params_logger);

                      Object.entries(params_logger).forEach(([key, valuess]) => {
                        // console.log(key);
                        // console.log(valuess);
                        var itemHtmls = `<label class="btn waves-effect waves-light purple-gradient-mee btn-rounded form-check-label">
                                            <input class="form-check-input" type="radio" value="`+key+`" name="options_logger" id="`+key+`" autocomplete="off"> 
                                            `+key+`
                                         </label>`;
                              $("#Logger_select").append(itemHtmls);
                      });

                      var selected_radios = document.querySelectorAll('input[name="options_logger"]');

                      for(var selected_rad of selected_radios){
                            selected_rad.addEventListener('change', Radio_Got_Selected);
                        } 
                    };



                    $('#Wave_containerModal').on('hidden.bs.modal', function (e) {
                      if ( window.history.replaceState ) {
                            window.history.replaceState( null, null, window.location.href );
                        }
                        window.location = window.location.href;
                      });
                      
                      function Radio_Got_Selected(e) {
                          if (this.checked) {
                             selected_logger = this.value;
                             value_cons = params_logger[selected_logger]["constanta"];
                              

                              
                              $("#const_number").val(parseFloat(value_cons));
                              $("#const_number").prop("disabled", false);
                              $("#const_number").siblings('label').addClass('active');
                              

                              $("#ch_selectors").prop("disabled", false);
                              
                              $('.mdb-select').materialSelect({
                              destroy: true
                                });
                              $('.mdb-select').materialSelect();
                              $('.mdb-select.select-wrapper .select-dropdown').val("").removeAttr('readonly').attr("placeholder",
                                "Stream Data").prop('required', true).addClass('form-control').css('background-color', '#fff');
                          }
                      }



                     
                      function Radio_Freq_Got_Selected(e) {
                          if (this.checked) {
                            $(".to_be_pulsees").removeClass('pulse_thiss');

                             raw_freqs = this.getAttribute('datas-raw-freq');
                             round_freqs = this.getAttribute('datas-round-freq');
                             windowing_dats = this.getAttribute('datas-windowing');
                             volt_amp_dats = this.getAttribute('datas-volt-amp');
                             
                            
                                // console.log(raw_freqs);
                                // console.log(round_freqs);
                                // console.log(windowing_dats);
                                // console.log(volt_amp_dats);
                             
                          $("#freq_number").val(parseFloat(round_freqs));
                          $("#freq_number").prop("disabled", false);
                          $("#freq_number").siblings('label').addClass('active');

                          $("#volt_number").val(parseFloat(volt_amp_dats));
                          $("#volt_number").prop("disabled", false);
                          $("#volt_number").siblings('label').addClass('active');

                          $("#number_checked").val(parseInt(windowing_dats));
                          $("#number_checked").prop("disabled", false);
                          $("#number_checked").siblings('label').addClass('active');
                        }
                      }

               
                      function reset_window_freq_ampli(){
                        $("#number_checked").prop("disabled", true);
                        $("#freq_number").prop("disabled", true);
                        $("#volt_number").prop("disabled", true);

                        $("#number_checked").val(''); 
                        $("#freq_number").val(''); 
                        $("#volt_number").val(''); 
                      }

                        
                    function get_pickertimess(which_to_init) {
                      
                      MseedValues_Cross = [];

                     
                      selected_chann.forEach((item, index) => {
                                MseedValues_Cross.push(MseedValues[item]);
                          })

                          
                        Object.entries(MseedValues_Cross).forEach(([key, valuess]) => {
                          if(valuess.start_time){
                              Datetimes_selectors = valuess.start_time;
                              times_selectors = (Datetimes_selectors.split('T')[1]).split('.')[0]; 

                              Datetimes_selectorsEND = valuess.end_time;
                              times_selectorsEND = (Datetimes_selectorsEND.split('T')[1]).split('.')[0]; 
                              
                              
                              
                             
                              if(which_to_init == 'start_times_init'){
                              document.getElementById('input_starttime_container').innerHTML = "";
                              document.getElementById('input_starttime_container').innerHTML = `<input placeholder="" onkeyup="typing_starttime();" type="text" name="input_starttime" id="input_starttime" disabled class="timepicker_start_class form-control timepicker" required>
                                                                                                 <label class="active" for="input_starttime">Start Time</label>`;


                                          // $('#input_starttime').pickatime({
                                          //           // Light or Dark theme
                                          //           twelvehour: false,
                                          //           darktheme: false,
                                          //           autoclose: true,
                                          //           closeOnClear: true,
                                          //           vibrate: true,
                                          //           min:  twenty_to_twelve_Convert(times_selectors),
                                          //           max:  twenty_to_twelve_Convert(times_selectorsEND),
                                          //           afterDone: seconds_starttime
                                          //         });
                                                  
                                      


                                            $("#input_starttime").prop("disabled", false);
                                            $("#input_ms").prop("disabled", false);

                                    
                                            marker_remove("Start");

                                    }


                                    if(which_to_init == 'end_times_init'){
                                      picker_start_datesss = document.getElementById('input_starttime').value;

                                      document.getElementById('input_endtime_container').innerHTML = "";
                                      document.getElementById('input_endtime_container').innerHTML = `<input placeholder="" type="text" name="input_endtime" id="input_endtime" disabled class="form-control timepicker" required>
                                                                                                        <label  class="active" for="input_endtime">End Time</label>`;
                                            // $('#input_endtime').pickatime({
                                            //             // Light or Dark theme
                                            //             twelvehour: false,
                                            //             darktheme: true,
                                            //             autoclose: true,
                                            //             closeOnClear: true,
                                            //             vibrate: true,
                                            //             min:  twenty_to_twelve_Convert(picker_start_datesss),
                                            //             max:  twenty_to_twelve_Convert(times_selectorsEND),
                                            //             beforeShow: check_start_inputs,
                                            //             afterHide: check_start_inputs,
                                            //             afterDone: seconds_endtime
                                            //           });

                                                      $("#input_endtime").prop("disabled", false);
                                                      marker_remove("Ends");
                                    }
                      
                                    reset_window_freq_ampli();
                                  
                          }else{
                            
                          }
                        })
                      
                      // console.log(times_selectors);
                    }



                


                    
                    function timeConverter(UNIX_timestamp) {

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


                    function twenty_to_twelve_Convert (timeX) {
                      var [hourString, minute] = timeX.split(":");
                      var hour = +hourString % 24;
                      return (hour % 12 || 12) + ":" + minute + (hour < 12 ? "am" : "pm");
                      }


                    function addZeroSecond(number) {
                      if (number < 10)
                        return "0" + number;
                      else
                        return number;
                    }


                    // function seconds_starttime() {
                    //   var start_hr_minutes = document.getElementById('input_starttime').value;  
                      
                    //   if(start_hr_minutes){
                      
                    //   var start_dat = document.getElementById('current_date').value;
                    //   var AAstart_datess = start_dat.substr(0, start_dat.indexOf('T'));
                    //   var AAstart_hr_minutes = document.getElementById('input_starttime').value;

                    //   $('#strtime_second_modal').on('show.bs.modal', function (e) {
                    //     document.getElementById('strtime_second_modal_titles').innerText = start_hr_minutes + ':' + addZeroSecond(0);
                    //     var seconds_Html = ` <center> <input type="range" id="seconds_range" value="0" max="59"> </center>`;
                    //     document.getElementById('append_round_slider_seconds').innerHTML = seconds_Html;
                    //   });

                    //   $('#strtime_second_modal').modal('show');

                    //   $("#seconds_range").roundSlider({
                    //     sliderType: "default",
                    //     handleShape: "dot",
                    //     startAngle: 90,
                    //     mouseScrollAction: true,
                    //     endAngle: "+360",
                    //     min: 0,
                    //     value: 0,
                    //     max: 59,
                    //     value: 0,
                    //     width: 10, // width of outer line
                    //     radius: 125, // radius size
                    //     handleSize: "+16",
                    //     svgMode: true,
                    //     pathColor: "#58a79c",
                    //     rangeColor: "#fff",
                    //     borderWidth: 0,
                    //     handleColor: "#07786d",
                    //     tooltipColor: "#000",
                    //     tooltipFormat: function (args) {
                    //       return addZeroSecond(args.value);
                    //     },
                    //     create: function () {
                    //       document.getElementById('input_starttime').value = start_hr_minutes + ':' + addZeroSecond(0);
                    //     },
                    //     beforeCreate: function () {
                    //       document.getElementById('input_starttime').value = start_hr_minutes + ':' + addZeroSecond(0);
                    //     },
                    //     drag: function (args) {
                    //       document.getElementById('strtime_second_modal_titles').innerText = start_hr_minutes + ':' + addZeroSecond(args.value);
                    //       document.getElementById('input_starttime').value = start_hr_minutes + ':' + addZeroSecond(args.value);
                    //     },
                    //     stop: function (args) {
                    //       document.getElementById('input_starttime').value = start_hr_minutes + ':' + addZeroSecond(args.value);
                    //       $('#strtime_second_modal').modal('hide');
                    //       $("#seconds_range").roundSlider("destroy");
                    //       document.getElementById('append_round_slider_seconds').innerHTML = "";
                    //       get_pickertimess("end_times_init");


                        

                    //       // Formatted to 2022-10-15T01:30:00.000000Z
                    //       datesto_moment = AAstart_datess + 'T' + AAstart_hr_minutes + ':' + addZeroSecond(args.value) + '.000000Z';
                    //       marker_remove("Start");
                    //       markers_Adds('add', 'Start', 'Start-Type', datesto_moment);




                    //     },
                    //   });

                    // };
                    // };




                

          
                    let typingtimer;
                    let timedelay = 1000;

                    function typing_starttime() {
                      var start_hr_minutes = document.getElementById('input_starttime').value; 
                      clearTimeout(typingtimer)
                        if (start_hr_minutes){
                            typingtimer = setTimeout(()=>{
                                //do stuff
                                get_pickertimess("end_times_init");
                            }, timedelay);
                        };
                    }


                    function check_start_inputs() {
                      var start_hr_minutes = document.getElementById('input_starttime').value; 
                      if(!start_hr_minutes){
                        var end_hr_minutes = document.getElementById('input_endtime').value= "";
                        $("#input_endtime").prop("disabled", false);
                      }
                    }


                    // function seconds_endtime() {
                    //   var start_dat = document.getElementById('current_date').value;
                    //   var start_datess = start_dat.substr(0, start_dat.indexOf('T'));



                      
                    //   var start_hr_minutes = document.getElementById('input_starttime').value;  

                    //   var end_hr_minutes = document.getElementById('input_endtime').value;
                    //   if(start_hr_minutes && end_hr_minutes){
                    //   $('#endtime_second_modal').on('show.bs.modal', function (e) {
                    //     document.getElementById('endtime_second_modal_titles').innerText = end_hr_minutes + ':' + addZeroSecond(0);
                    //     var seconds_Html = ` <center> <input type="range" id="seconds_end_range" value="0" max="59"> </center>`;
                    //     document.getElementById('append_round_slider_end_seconds').innerHTML = seconds_Html;
                    //   });

                    //   $('#endtime_second_modal').modal('show');

                    //   $("#seconds_end_range").roundSlider({
                    //     sliderType: "default",
                    //     handleShape: "dot",
                    //     startAngle: 90,
                    //     mouseScrollAction: true,
                    //     endAngle: "+360",
                    //     min: 0,
                    //     value: 0,
                    //     max: 59,
                    //     value: 0,
                    //     width: 10, // width of outer line
                    //     radius: 125, // radius size
                    //     handleSize: "+16",
                    //     svgMode: true,
                    //     pathColor: "#a1a1a1",
                    //     rangeColor: "#fff",
                    //     borderWidth: 0,
                    //     handleColor: "#ffffff",
                    //     tooltipColor: "#a1a1a1",
                    //     tooltipFormat: function (args) {
                    //       return addZeroSecond(args.value);
                    //     },
                    //     create: function () {
                    //       document.getElementById('input_endtime').value = end_hr_minutes + ':' + addZeroSecond(0);
                    //     },
                    //     beforeCreate: function () {
                    //       document.getElementById('input_endtime').value = end_hr_minutes + ':' + addZeroSecond(0);
                    //     },
                    //     drag: function (args) {
                    //       document.getElementById('endtime_second_modal_titles').innerText = end_hr_minutes + ':' + addZeroSecond(args.value);
                    //       document.getElementById('input_endtime').value = end_hr_minutes + ':' + addZeroSecond(args.value);
                    //     },
                    //     stop: function (args) {
                    //       document.getElementById('input_endtime').value = end_hr_minutes + ':' + addZeroSecond(args.value);
                    //       $('#endtime_second_modal').modal('hide');
                    //       $("#seconds_end_range").roundSlider("destroy");
                    //       document.getElementById('append_round_slider_end_seconds').innerHTML = "";



                    //       // Formatted to 2022-10-15T01:30:00.000000Z
                    //       datesEND_to_moment = start_datess + 'T' + end_hr_minutes + ':' + addZeroSecond(args.value) + '.000000Z';
                    //       marker_remove("Ends");
                    //       markers_Adds('add', 'Ends', 'pick', datesEND_to_moment);


                    //         //ambil value atau update duluuuk 
                      
                          
                    //       var end_hr_minutessss = end_hr_minutes + ':' + addZeroSecond(args.value);

                    //       if(start_hr_minutes && end_hr_minutessss){
                    //         get_domain_freq(start_hr_minutes , end_hr_minutessss);
                    //       }


                    //       // console.log(seisplotjs.moment.utc(datesEND_to_moment));
                    //       // console.log(datesEND_to_moment);

                    //     },
                    //   });

                    // }else{
                    //   var end_hr_minutes = document.getElementById('input_endtime').value= "";
                    //   $("#input_endtime").prop("disabled", true);
                    // }
                    // };



                    function markers_Adds(add_or_rem, str_label, str_type, time_moment) {
                      if (add_or_rem == 'add') {
                        seisDataList.forEach(seisData => seisData.addMarkers({
                          name: str_label,
                          type: str_type,
                          description: 'Mee Time',
                          time: seisplotjs.moment.utc(time_moment)
                        }));
                        graphList.forEach(g => g.drawMarkers());
                      }
                    };


                    function marker_remove(name_of_marker) {
                      seisDataList.forEach(seisData => 
                      seisData['markerList'].forEach((item, index) => {
                                if (item.name == name_of_marker){
                                  seisData['markerList'].splice(index, 1);
                                }
                               
                          })
                      
                      
                      )

                      graphList.forEach(g => g.drawMarkers());
                    }


                    // function marker_remove() {
                    //   seisDataList.forEach(seisData => seisData['markerList'] = []
                    //   );

                    //   graphList.forEach(g => g.drawMarkers());
                    // }

                    function meeee_cust_file_reset() {
                      // window.location.reload(true);
                      if ( window.history.replaceState ) {
                            window.history.replaceState( null, null, window.location.href );
                        }
                        window.location = window.location.href;
                    };


                    // Langkah proses 1 freq domain freq_domain frekuensi pick frequency domain
                    function get_domain_freq(startssss, endsss){
                      $('#form_time_domain_param').submit();
                    };


                    $('#form_time_domain_param').submit(function (evnt) {
                        evnt.preventDefault();

                      var start_hr_minutess = document.getElementById('input_starttime').value;
                      var end_hr_minutess = document.getElementById('input_endtime').value;

                        // console.log(MseedValues_Cross);
                      var data_freq_domains = new FormData($('#form_time_domain_param')[0]);
                      data_freq_domains.append('thisss_mseed', $('#file_mseed')[0].files[0]);

                      var start_dat = document.getElementById('current_date').value;
                        data_freq_domains.append('thisss_current_date', start_dat);


                      var start_datesxx = document.getElementById('current_starts_date').value;
                        data_freq_domains.append('thisss_startss_date', start_datesxx);

                      var end_datesxx = document.getElementById('current_ends_date').value;
                        data_freq_domains.append('thisss_endd_date', end_datesxx);


                        var sensor_types = JSON.stringify(selected_logger);
                        data_freq_domains.append('sensor_types', sensor_types);

                        var hmmm_channs = JSON.stringify(value_cahnnel);
                        data_freq_domains.append('ch_selectorsssss', hmmm_channs);

                        var timsess_deltass = JSON.stringify({"starts" : start_hr_minutess , "ends" : end_hr_minutess});
                        data_freq_domains.append('times_deltas', timsess_deltass);

                        // console.log(data_freq_domains);
                      $.ajax({
                          url: "script/02_get_freq_domain_mseed.php",
                          type: "POST",
                          data: data_freq_domains,
                          dataType: 'json',
                          contentType: false,
                          cache: false,
                          processData: false,
                          beforeSend: function () {
                            document.getElementById('loader-wrapper1').hidden = false;
                            $("#err").fadeOut();
                          },
                          success: function (datas) {
                            // console.log(datas);
                            $("#append_data_freqss").html('');
                           

                            var channels_to_stream = datas.channels;



                              channels_to_stream.forEach(function (ch_selector) {
                                // console.log(ch_selector);
                                // console.log(result_finale[ch_selector]);
                                var nama_station_channel = datas[ch_selector]['data_Streams'];
                                var images_each = datas[ch_selector]['img'];
                                var data_domain = datas[ch_selector]['data_freqs_domain'];
                                // var images_each_spectogrm = result_finale[ch_selector]['img_spectogrm'];

                                freqs_volt = params_logger[selected_logger]["freq_volt"][data_domain.rounded];
                                datas_window = params_logger[selected_logger]["opt_windowed"][data_domain.rounded];
                                


                                // Error enabled
                                // if(!freqs_volt || !datas_window){

                                //   title_msg = 'λ OR ∑ : Unknown';
                                //   html_msg = ` <hr>
                                //               <p>Please get better Picking at <u><b>Start-time</b></u> and <u><b>End-time</b></u> </p>
                                //               <p>Maybe Caused By Incorrect Logger <u><b><small>Centaur/Q330</small></b></u> </p>`;

                                //   OOOOPS_picking(title_msg, html_msg)
                                // }
                                
                                
                              // // Error enabled
                              //   if(freqs_volt && datas_window){
                                var itemHtml = `<div class="col-2">
                                                  <input type="radio" id="control_`+nama_station_channel+`"  name="selector_freqss" value="`+ch_selector+`" 
                                                  datas-raw-freq="`+data_domain.raw+`" 
                                                  datas-round-freq="`+data_domain.rounded+`" 
                                                  datas-windowing="`+datas_window+`" 
                                                  datas-volt-amp="`+freqs_volt+`" 
                                                  >
                                                  <label for="control_`+nama_station_channel+`" class="card to_be_pulsees mee_rounded px-4 py-4">
                                                  <div class="row  m-0 p-0">  
                                                  <div class="col text-center">
                                                    <p class="font-weight-bold m-0 p-0"><u>Parameter Freq</u></p><br><br>
                                                    </div>
                                                    </div>
                                                    <div class="row">
                                                      <div class="col-4 rounded white p-0 ">
                                                        <a class="img-thumbnail img-fluid" href="data:image/png;base64, ` + images_each + `" title="image_` + ch_selector + `" data-lightbox="group_` + ch_selector + `">
                                                          <img class="img-fluid" src="data:image/png;base64, ` + images_each + `" alt="image_` + ch_selector + `">
                                                        </a>

                                                      </div>
                                                      <div class="col-8  ">
                                                        <p> &nbsp;⨍ == `+  (parseFloat(data_domain.raw).toFixed(6)) +` Hz <br>
                                                          ≈⨏ == `+ data_domain.rounded +`&nbsp;&nbsp;&nbsp;&nbsp;Hz
                                                          <br><br>
                                                          ∑ :`+ datas_window +` &nbsp;|&nbsp;
                                                          λ :`+ freqs_volt +`
                                                          </p>
                                                      </div>
                                                    </div>

                                                  </label>
                                                </div> `;
                                // $("#append_data_freqss").append(itemHtml); //Ini kalau mau buat 3, kalau 1 pakai yang di bawah
                                $("#append_data_freqss").html(itemHtml);
                               
                              // Error enabled
                              // }
                              
                              });

                              document.getElementById('loader-wrapper1').hidden = true;
                              // $('#Final_rslt_Modal').modal('show');

                              reset_window_freq_ampli();

                              var freqss_rads = document.querySelectorAll('input[name="selector_freqss"]');

                              for(var freqss_rad of freqss_rads){
                                freqss_rad.addEventListener('change', Radio_Freq_Got_Selected);
                                } 


                           },
                          error: function (e) {
                            $("#err").html(e).fadeIn();
                          }
                        });



                    });








                    
                      file_mseed.onchange = function (event) {
                        var formData = new FormData();
                        formData.append('file_mseed', $('#file_mseed')[0].files[0]);

                        $.ajax({
                          url: "script/01_mseed_upload_to_array.php",
                          type: "POST",
                          data: formData,
                          dataType: 'json',
                          contentType: false,
                          cache: false,
                          processData: false,
                          beforeSend: function () {
                            document.getElementById('loader-wrapper').hidden = false;
                            $("#err").fadeOut();
                          },
                          success: function (datas) {
                            // console.log(datas);
                            // console.log(datas.channels);
                            MseedValues = datas;


                            document.getElementById('append_data_stream').innerHTML = "";
                            document.getElementById('ch_selectors').innerHTML = "";

                            document.getElementById('loader-wrapper').hidden = true;



                            var channels_stream = datas.channels;
                            var idx_stream = (datas.channels.length) - 1; // -1 buat manggil array, kalau rawnya nda perlu -1



                            $("#ch_selectors").append(`<option value="" disabled >Pilih....</option>`);






                            channels_stream.forEach(function (ch_stream) {
                              // console.log(datas[ch_stream].sample_rate);

                              // Append Date Value to input form
                              document.forms['pickers_param']['current_date'].value = datas[ch_stream].start_time;
                              document.forms['pickers_param']['current_dateTime_ms'].value = Date.parse(datas[ch_stream].start_time);
                              
                          

                              var itemHtml = `<div class="card my-2 px-1 py-2 seismograph" id="Each_stream_` + ch_stream + `" style="display:none"></div>`;
                              $("#append_data_stream").append(itemHtml);

                              var ch_selectors_id_html = `<option value="` + ch_stream + `">` + ch_stream + `</option>`;
                              $("#ch_selectors").append(ch_selectors_id_html);



                              sampleRate = datas[ch_stream].sample_rate;
                              start = seisplotjs.moment.utc(datas[ch_stream].start_time);

                              Seismo_segment = new seisplotjs.seismogram.SeismogramSegment(datas[ch_stream].trace_data, sampleRate, start);
                              // seismogram=  new seisplotjs.seismogram.Seismogram(Seismo_segment);
                              seismogram = seisplotjs.seismogram.Seismogram.createFromContiguousData(datas[ch_stream].trace_data, sampleRate, start);


                              element_sel = seisplotjs.d3.select('div#Each_stream_' + ch_stream);

                              seisConfig = new seisplotjs.seismographconfig.SeismographConfig();
                              seisConfig.title = datas[ch_stream].sta_names + '_' + ch_stream + ' ' + timeConverter(start);
                              seisConfig.margin.top = 25;
                              seisConfig.maxWidth = 1080;
                              seisConfig.minWidth = 900;

                              seisConfig.maxHeight = 600;
                              seisConfig.minHeight = 250;
                              seisConfig.wheelZoom = true;
                              seisConfig.doRMean = true;
                              seisConfig.doGain = true;
                              seisConfig.xScaleFormat = function(date) {
                                 const formatMillisecond = seisplotjs.d3.utcFormat(".%L");
                                 const formatSecond = seisplotjs.d3.utcFormat(":%S");
                                 const formatMinute = seisplotjs.d3.utcFormat("%H:%M");
                                 const formatHour = seisplotjs.d3.utcFormat("%H:%M");
                                 const formatDay = seisplotjs.d3.utcFormat("%m/%d");
                                 const formatMonth = seisplotjs.d3.utcFormat("%Y/%m");
                                 const formatYear = seisplotjs.d3.utcFormat("%Y");
                                 const formatTanggals = seisplotjs.d3.utcFormat("%Y-%m-%d");
                                 const formatFulll = seisplotjs.d3.utcFormat("%H:%M:%S.%L");
                                 const formatHMS = seisplotjs.d3.utcFormat("%H:%M:%S");
                                 
                            
                                        $(this).click(function () {
                                          if( current_picks == "start_pick_time"){
                                                      if(seism_selected_start != formatFulll(date) && seism_selected_end != formatFulll(date)){
                                                          if(seism_selected_start != seism_selected_end && seism_selected_end != seism_selected_start){
                                                            append_from_Timestamp_picker("start_time_hr", formatTanggals(date), formatFulll(date));
                                                            if(start_time_class_locked == 'locked'){
                                                              $(this).addClass("timestamp_hovers_lock");
                                                            }else{
                                                              $(this).removeClass("timestamp_hovers_lock");
                                                            }
                                                          }
                                                        };
                                                    }
                                            else if(current_picks == "end_pick_time"){
                                                    if(seism_selected_start != formatFulll(date) && seism_selected_end != formatFulll(date) ){
                                                      if(seism_selected_start != seism_selected_end && seism_selected_end != seism_selected_start){
                                                        append_from_Timestamp_picker("end_time_hr", formatTanggals(date), formatFulll(date));
                                                        if(end_time_class_locked == 'locked'){
                                                              $(this).addClass("timestamp_hovers_END_lock");
                                                            }else{
                                                              $(this).removeClass("timestamp_hovers_END_lock");
                                                            }
                                                      }
                                                      };
                                            }
                                          });

                                        $(this).mouseover(function(){
                                          if( current_picks == "start_pick_time"){
                                            $(this).addClass("timestamp_hovers");
                                            $(this).removeClass("timestamp_hovers_END");
                                          }
                                          else if(current_picks == "end_pick_time"){
                                            $(this).addClass("timestamp_hovers_END");
                                            $(this).removeClass("timestamp_hovers");

                                          }
                                          
                                        });

                                        $(this).mouseout(function(){
                                          if( current_picks == "start_pick_time"){
                                              $(this).removeClass("timestamp_hovers");
                                              $(this).removeClass("timestamp_hovers_END");

                                            }
                                            else if(current_picks == "end_pick_time"){
                                              $(this).removeClass("timestamp_hovers_END");
                                              $(this).removeClass("timestamp_hovers");

                                            }
                                        });

                                        $(this).mouseenter(function(){
                                          if( current_picks == "start_pick_time"){
                                              $(this).addClass("timestamp_hovers");
                                              $(this).removeClass("timestamp_hovers_END");

                                          }
                                          else if(current_picks == "end_pick_time"){
                                              $(this).addClass("timestamp_hovers_END");
                                              $(this).removeClass("timestamp_hovers");

                                          }
                                        });

                                        $(this).mouseleave(function(){
                                          if( current_picks == "start_pick_time"){
                                              $(this).removeClass("timestamp_hovers");
                                              $(this).removeClass("timestamp_hovers_END");

                                            }
                                            else if(current_picks == "end_pick_time"){
                                              $(this).removeClass("timestamp_hovers_END");
                                              $(this).removeClass("timestamp_hovers");

                                            }
                                        });
                                return (
                                  seisplotjs.d3.utcSecond(date) < date ? formatFulll
                                : seisplotjs.d3.utcMinute(date) < date ? formatHMS
                                : seisplotjs.d3.utcHour(date) < date ? formatHMS
                                : seisplotjs.d3.utcDay(date) < date ? formatHMS
                                : seisplotjs.d3.utcMonth(date) < date ?  formatDay
                                : seisplotjs.d3.utcYear(date) < date ? formatMonth
                                : formatYear)(date);

                                // seisplotjs.d3.utcSecond(date) < date ? formatMillisecond
                                // : seisplotjs.d3.utcMinute(date) < date ? formatSecond
                                // : seisplotjs.d3.utcHour(date) < date ? formatMinute
                                // : seisplotjs.d3.utcDay(date) < date ? formatHour
                                // : seisplotjs.d3.utcMonth(date) < date ?  formatDay
                                // : seisplotjs.d3.utcYear(date) < date ? formatMonth
                                // : formatYear)(date);


                                };
                              seisConfig.lineColors = [
                                "#87ceeb"];
                              seisConfig.lineWidth = 1;
                              seisConfig.xLabelOrientation = "horizontal";
                              seisConfig.xLabel = "";
                              seisConfig.xSublabel = "Time";



                              // seisConfig.margin.bottom = 0;
                              // seisConfig.margin.left = 0;
                              // seisConfig.margin.right = 0;
                              seisData = seisplotjs.seismogram.SeismogramDisplayData.fromSeismogram(seismogram);
                              // sdd = seisplotjs.seismogram.SeismogramDisplayData.fromSeismogram(seismogram);




                              graph = new seisplotjs.seismograph.Seismograph(element_sel, seisConfig, seisData);

                              graphList.forEach(g => graph);
                              graphList.push(graph);

                              seisDataList.push(seisData);
                              streamList.push(ch_stream);


                              // graph.calcScaleAndZoom();
                              graph.draw();
                              graph.drawSeismogramsSvg();


                            });




                            // document.getElementById('append_data_stream').innerHTML = document.getElementById('data_stream_temp_pushed').innerHTML;
                            // document.getElementById('data_stream_temp_pushed').innerHTML ='';

                            
                            $('.mdb-select').materialSelect({
                              destroy: true
                            });

                            
                            $('.mdb-select').materialSelect();
                            $('.mdb-select.select-wrapper .select-dropdown').val("").removeAttr('readonly').attr("placeholder",
                                "Stream Data").prop('required', true).addClass('form-control').css('background-color', '#fff');

                            $('#Wave_containerModal').modal('show');

                            $('#Wave_containerModal').data('bs.modal').handleUpdate();


                          },
                          error: function (e) {
                            $("#err").html(e).fadeIn();
                          }
                        });


                      };

                      

                      $('#ch_selectors').on('change', function () {
                        var $selectedOptions = $(this).find('option:selected');
                        value_cahnnel = [];
                        $selectedOptions.each(function () {
                          value_cahnnel.push($(this).text());
                        });

                        $('#erase_pickings').click();
                        $("#erase_pickings").prop("disabled", true);
                        // console.log(value_cahnnel);
                      });







                      

                      $('#form_pickers_param_id').submit(function (evnt) {
                        var formss = document.getElementById('form_pickers_param_id');
                        if ( formss.checkValidity() === false) {
                          evnt.preventDefault();
                          evnt.stopPropagation();
                          return false;
                        }


                        if(!value_cahnnel.length ){
                          evnt.preventDefault();
                          evnt.stopPropagation();
                          return false;
                        }
                        if(!$("#number_checked").val()){
                          
                          $(".to_be_pulsees").addClass('pulse_thiss');
                          evnt.preventDefault();
                          evnt.stopPropagation();
                          return false;
                        }
                        if(!$("#volt_number").val()){
                          $(".to_be_pulsees").addClass('pulse_thiss');
                          evnt.preventDefault();
                          evnt.stopPropagation();
                          return false;
                        }
                        if(!$("#freq_number").val()){
                          $(".to_be_pulsees").addClass('pulse_thiss');
                          evnt.preventDefault();
                          evnt.stopPropagation();
                          return false;
                        }
                        if(!$("#const_number").val()){
                          evnt.preventDefault();
                          evnt.stopPropagation();
                          return false;
                        }


                        formss.classList.add('was-validated');
                        evnt.preventDefault();

                        var formData_params = new FormData($('#form_pickers_param_id')[0]);
                        formData_params.append('current_mseed_file', $('#file_mseed')[0].files[0]);

                       

                        var dat_selected_chs = JSON.stringify(value_cahnnel);
                        formData_params.append('ch_selectors', dat_selected_chs);

                        var start_datesxx = document.getElementById('current_starts_date').value;
                        formData_params.append('current_starts_datex', start_datesxx);

                      var end_datesxx = document.getElementById('current_ends_date').value;
                      formData_params.append('current_starts_datex', end_datesxx);

                        $.ajax({

                          type: "POST",

                          url: "script/03_get_final_proccessed_mseed.php",

                          data: formData_params, // get all form field value in serialize form
                          // data: {
                          //                 channels: dat_selected_chs,
                          //                 forms: formData_params,
                          //             },

                          contentType: false,
                          cache: false,
                          processData: false,
                          beforeSend: function () {
                            document.getElementById('loader-wrapper2').hidden = false;
                            $("#err").fadeOut();
                          },
                          success: function (result_finale) {
                            $("#append_final_results").html('');
                            // console.log(result_finale);


                            var channels_to_stream = result_finale.channels;



                            channels_to_stream.forEach(function (ch_selector) {
                              // console.log(ch_selector);
                              // console.log(result_finale[ch_selector]);
                              var nama_station_channel = result_finale[ch_selector]['data_Streams'];
                              var images_each = result_finale[ch_selector]['img'];
                              var images_each_spectogrm = result_finale[ch_selector]['img_spectogrm'];




                              var itemHtml = `<div class="col">
                                                      <div class="row">
                                                            <div class="col">
                                                                <a class="img-thumbnail img-fluid" href="data:image/png;base64, ` + images_each + `" title="image_` + ch_selector + `"  data-lightbox="group_` + ch_selector + `">
                                                                  <img class="img-fluid" src="data:image/png;base64, ` + images_each + `" alt="image_` + ch_selector + `"  >
                                                                </a>
                                                            </div>
                                                            <div class="col">
                                                                <a class="img-thumbnail img-fluid" href="data:image/png;base64, ` + images_each_spectogrm + `" title="image_spec_` + ch_selector + `"  data-lightbox="group_` + ch_selector + `">
                                                                  <img class="img-fluid" src="data:image/png;base64, ` + images_each_spectogrm + `" alt="image_spec_` + ch_selector + `"  >
                                                                </a>
                                                            </div>
                                                      </div>

                                                  

                                                      <div class="row">
                                                          <div class="table-responsive text-nowrap text-center" id="table_container` + ch_selector + `">
                                                              <center>
                                                                  <table class="table table-striped" id="table_` + ch_selector + `" style="width: 80%;">

                                                                      <thead class="black white-text">
                                                                          <tr>
                                                                              <th colspan="3"><center><b>Hasil Picking ` + nama_station_channel + `</b></center></th>
                                                                          </tr>
                                                                          <tr>
                                                                              <th scope="col">Peak</th>
                                                                              <th scope="col">Valley</th>
                                                                              <th scope="col">Sensitivitas</th>
                                                                          </tr>
                                                                      </thead>
                                                                      <tbody>

                                                                      </tbody>
                                                                  </table>
                                                              </center>
                                                          </div>
                                                      </div>
                                                  </div> `;
                              $("#append_final_results").append(itemHtml);

                              table_tbody_ref = document.getElementById("table_" + ch_selector + "").getElementsByTagName('tbody')[0];

                              // console.log(table_ids);

                              // var arr_dat2 = data_peaks.map((element, indx) => ({ element,  x:data_valleys[indx], z:data_sensitivity[indx]  }));
                              //             console.log(arr_dat2);

                              var data_peaks = result_finale[ch_selector]['data_peaks'];
                              var data_valleys = result_finale[ch_selector]['data_valleys'];
                              var data_sensitivity = result_finale[ch_selector]['data_sensitivity'];

                              var array_to_three_col = data_sensitivity.map(function (element, indx) {
                                return [data_peaks[indx], data_valleys[indx], data_sensitivity[indx]]
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
                                }
                              }








                            });




                            document.getElementById('loader-wrapper2').hidden = true;
                            $('#Final_rslt_Modal').modal('show');

                          }



                        });
                      });


                      
                    


                      
                      $('#input_ms').click(function () {
                        var ms_true = $(this).is(':checked');
                        if(!ms_true){
                          // console.log('1111111');
                        }else{
                          // console.log('222222');
                        }
                      });



                      $('.mdb-select').change(function () {
                        

                        var selss = [];
                        selected_chann = [];
                        selected_chann_id = [];
                        selss = $('.mdb-select option:selected');
                        if(selss.length > 0){
                          for (loops = 0; loops < selss.length; loops++) {
                              if(selss[loops]){
                                selected_chann.push(selss[loops].value);
                                selected_chann_id.push('Each_stream_'+selss[loops].value);
                              }
                              else{
                                selected_chann = [];
                                $("#input_starttime").prop("disabled", true);
                                $("#input_endtime").prop("disabled", true);
                                
                                reset_window_freq_ampli();
                              }
                            }

                            // selected_chann.forEach((item) => {
                            //   $('#Each_stream_'+item).show();
                            //   })

                              $("div[id^='Each_stream_']").each(function() {
                                //get id
                                  var id_ = $(this).attr("id")
                                  //check if not in array
                                  if (selected_chann_id.indexOf(id_) == -1) {
                                    $(this).hide(); //hide it

                                    

                                  }else{
                                    $(this).show();

                                  $('#erase_pickings').click();
                                  $("#erase_pickings").removeClass("disss");
                                  $("#erase_pickings").prop("disabled", false);
                                  }
                                // console.log($(this));
                                    // $(this).toggleClass("shown", !selected_chann_id.includes(this.id));
                                });



                            get_pickertimess('start_times_init');
                            get_pickertimess("end_times_init");
                            
                          $("#input_endtime").prop("disabled", true);
                            
                        }
                        else{
                          $("div[id^='Each_stream_']").hide();
                          
                          selected_chann = [];
                          $("#input_starttime").prop("disabled", true);
                          $("#input_endtime").prop("disabled", true);
                          
                          $('#erase_pickings').click();
                          $("#erase_pickings").addClass("disss");
                          $("#erase_pickings").prop("disabled", true);

                          reset_window_freq_ampli();
                        }
                      });
                      

                      $(document).ready(function () {
                        
                        $.getJSON("/script/parameter_logger.json", function(json_dat) {
                          params_logger = json_dat;
                            // console.log(json_dat); // this will show the info it in firebug console
                            init_logger_select();
                        });


                      new WOW().init();

                      reset_window_freq_ampli();
                     
                      $("#input_starttime").prop("disabled", true);
                      $("#input_endtime").prop("disabled", true);

                      $("#ch_selectors").prop("disabled", true);

                      

                      $("#const_number").prop("disabled", true);




                      $('[data-toggle="tooltip"]').tooltip();
                      $('.mdb-select').materialSelect();
                            $('.mdb-select.select-wrapper .select-dropdown').val("").removeAttr('readonly').attr("placeholder",
                                "Stream Data").prop('required', true).addClass('form-control').css('background-color', '#fff');
                      $('.file-upload').file_upload();
                      $('.file-upload').show();



                 
                $('[data-toggle="helper_start_Time"]').popover({
                    html: true,
                    trigger: ' focus',
                    placement: 'top',
                    content: function () { return `<img src="/images/tuts/TimeStartPick.gif" alt="This How To"  width="250" /><ul> </ul>`; }
                });

                $('[data-toggle="helper_end_Time"]').popover({
                    html: true,
                    trigger: ' focus',
                    placement: 'top',
                    content: function () { return `<img src="/images/tuts/TimeEndPick.gif" alt="This How To"  width="250" /><ul> </ul>`; }
                });

                $('[data-toggle="helper_windowing"]').popover({
                    html: true,
                    trigger: ' focus',
                    placement: 'left',
                    content: function () { return `<img src="/images/tuts/WindowingNumb.gif" alt="This How To"  width="250" /> <ul> <li class="list_helpers_jumbotron" >  Makin Kecil Untuk Freq Tinggi </li> <li class="list_helpers_jumbotron" >  Bagian Hijau Dan Merah Harus Ada di setiap Gelombang </li> <li class="list_helpers_jumbotron" >  Tidak Boleh Bertabrakan Kedua Poin Tersebut </li></ul>`; }
                });

                    });


                  

  
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
      echo "<script> OOOOPS(); </script>";
    }
  }


  // *********************************************** //
  // **********	SHOW THE LOG-IN FORM	********** //
  // *********************************************** //

  else {
    display_login_form();
  }




  ?>





</body>






</html>
