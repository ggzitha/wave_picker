<?php
session_start();

// ***************************************** //
// **********	DECLARE VARIABLES  ********** //
// ***************************************** //

// $username = 'inskal';
// $password = 'password';

$random1 = 'secret_key1';
$random2 = 'secret_key2';

$logins_usr_PW_pairs = array('inskal' => '@dmin_inskal',
                              'admin' => '@dmin_inskal',
                              'mee' => 'qwertyuiop');

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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">



  <link rel="stylesheet" type="text/css" href="assets/vendor/mdbootstrap_4_mee/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="assets/vendor/mdbootstrap_4_mee/css/mdb.min.css">
  <link rel="stylesheet" type="text/css" href="assets/vendor/mdbootstrap_4_mee/css/style.css">
  <link rel="stylesheet" type="text/css" href="assets/vendor/mdbootstrap_4_mee/plugins/MDB-File-Upload/css/addons/mdb-file-upload.css">
  <link rel="stylesheet" type="text/css" href="assets/vendor/fontawesomePro/css/all.min.css">
  <link rel="stylesheet" href="assets/vendor/roundSlider-1.6.1/roundslider.css" />
  <link rel="stylesheet" href="assets/vendor/sweetalert2-11.4.24/sweetalert2.css" />
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
      border-radius: 10px;

      background-color: #82B1FF;
    }

    .scrollbar-light-blue {
      scrollbar-color: #82B1FF #F5F5F5;
    }
  </style>
  <link href="images/icon/favicon.png" rel="shortcut icon">
</head>

<body>

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
                <input type="file" id="file_mseed" name="mseed" class="file-upload" data-max-file-size="20M" />
              </div>
            </div>





          </div>
        </div>
      </div>

    </div>


    <div class="modal top fade" id="Wave_containerModal" tabindex="-1" role="dialog" aria-labelledby="Wave_containerModalTitle" aria-hidden="true" data-backdrop="static" data-mdb-backdrop="static" data-keyboard="false" data-mdb-keyboard="false">


      <div class="modal-dialog modal-dialog-centered modal-fluid modal-dialog-scrollable " role="document">



        <div class="modal-content">
          <div class="modal-header blue lighten-2">
            <h5 class="modal-title" id="Wave_containerModalTitle">Waveform Picker's</h5>
            <button type="button" class="btn  btn-danger" data-dismiss="modal" aria-label="Close" style="position: absolute; top: 0px; right: 0px;">
              <i class="fa-solid fa-xmark-large fa-1x"></i>
            </button>
          </div>
          <div class="modal-body">

            <div class="row">

              <div class="col-7">

                <section class="scrollbar-light-blue">
                  <div class="card">
                    <div class="card-body  w-100" id="append_data_stream">




                    </div>
                  </div>

                </section>

              </div>

              <div class="col">

                <div class="card " style="position: sticky !important; top: 0px;">

                  <h5 class="card-header info-color white-text text-center py-4">
                    <strong>Parameter Picker</strong>
                  </h5>


                  <div class="card-body px-lg-5 pt-0">


                    <form style="color: #757575;" id="form_pickers_param_id" name="pickers_param" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>


                      <div class="md-form">
                        <select class="mdb-select md-form colorful-select dropdown-primary" id="ch_selectors" name="ch_selectors" multiple searchable="Cari. ..">
                          <option value="" disabled selected>Pilih....</option>
                        </select>
                        <label class="mdb-main-label">Channel Stream</label>
                      </div>



                      <div class="row">
                        <div class="col">
                          <div class="md-form">
                            <input placeholder="Start time" type="text" name="input_starttime" id="input_starttime" class="form-control timepicker">
                            <label for="input_starttime">Start Time</label>
                          </div>
                        </div>


                        <div class="col">
                          <div class="md-form">
                            <input placeholder="End time" type="text" name="input_endtime" id="input_endtime" class="form-control timepicker">
                            <label for="input_endtime">End Time</label>
                          </div>
                        </div>



                      </div>

                      <div class="row">
                        <div class="col">
                          <div class="md-form input-group">
                            <div class="input-group-prepend">
                              <a data-toggle="tooltip" data-html="true" title="freq-kecil-->input=(~100)<br>freq-besar-->input=(~1) <u>Menyesuiakan</u>">
                                <i class="green-text text-muted fa-regular fa-messages-question"></i>
                              </a>
                            </div>
                            <input type="number" id="number_checked" name="number_checked" class="form-control" step="1" min="1">
                            <label for="number_checked">Windowing Number </label>

                          </div>
                        </div>

                        <div class="col">
                          <div class="md-form input-group">
                            <div class="input-group-prepend">
                              <a data-toggle="tooltip" data-html="true" title="Di Excel, Kolom Frekuensi<br>Bisa Juga Dari Spectra PQL ">
                                <i class="green-text text-muted fa-regular fa-messages-question"></i>
                              </a>
                            </div>
                            <input type="number" id="freq_number" name="freq_number" class="form-control" step="0.001">
                            <label for="freq_number">Frekuensi(Hz) </label>

                          </div>
                        </div>
                        <div class="col">
                          <div class="md-form input-group">
                            <div class="input-group-prepend">
                              <a data-toggle="tooltip" data-html="true" title="Di Excel, Kolom Amplitudo(Volt) ">
                                <i class="green-text text-muted fa-regular fa-messages-question"></i>
                              </a>
                            </div>
                            <input type="number" id="volt_number" name="volt_number" class="form-control" step="0.001">
                            <label for="volt_number">Amplitudo(Volt) </label>


                          </div>
                        </div>



                      </div>


                      <div class="row">
                        <div class="md-form input-group">
                          <div class="input-group-prepend">
                            <a data-toggle="tooltip" data-html="true" title="Di Excel(Rumus Sensitivitas)<br>contoh: 0.0000161935461400047 <br> 0.000788081020399124">
                              <i class="green-text text-muted fa-regular fa-messages-question"></i>
                            </a>
                          </div>
                          <input type="number" id="const_number" name="const_number" class="form-control" step="0.0000000000000001">
                          <label for="const_number">Konstanta Perhitungan</label>

                        </div>
                      </div>
                  </div>




                  <input type="hidden" id="current_date" name="current_date">

                  <button class="btn btn-outline-info btn-rounded btn-block z-depth-0 my-4 waves-effect" type="submit">Send</button>

                  </form>


                </div>

              </div>
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
    <div class="modal fade" id="strtime_second_modal" tabindex="-1" role="dialog" aria-labelledby="strtime_second_modalLabel" aria-hidden="true">
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
    <div class="modal fade" id="endtime_second_modal" tabindex="-1" role="dialog" aria-labelledby="endtime_second_modalLabel" aria-hidden="true">
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
                  <label for="username">UserName</label>
                </div>

                <div class="md-form pb-3">
                  <input type="password" id="password" name="password"  class="form-control">
                  <label for="password">Password</label>
                </div>

                <div class="text-center mb-4">
                <button class="btn btn-default btn-rounded" name="submit" value="submit" type="submit">Log-In<i class="fa-solid fa-paper-plane white-text ml-2"></i></i></button>
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



  <script type="text/javascript" src="assets/vendor/seisplotjs-2.0.1/seisplotjs_2.0.1_standalone.js"></script>
  <script type="text/javascript" src="assets/vendor/roundSlider-1.6.1/roundslider.js"></script>

  <script type="text/javascript" src="assets/vendor/sweetalert2-11.4.24/sweetalert2.js"></script>


  <?php
  if (isset($_SESSION['Logged_Datas']) && $_SESSION['Logged_Datas'] == $hash) {
  ?>
    <script type="text/javascript">
      $(document).ready(function() {

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

        file_mseed.onchange = function(event) {
          var formData = new FormData();
          formData.append('file_mseed', $('#file_mseed')[0].files[0]);







          $.ajax({
            url: "script/mseed_upload.php",
            type: "POST",
            data: formData,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
              //$("#preview").fadeOut();
              $("#err").fadeOut();
            },
            success: function(datas) {
              // console.log(datas);
              // console.log(datas.channels);


              document.getElementById('append_data_stream').innerHTML = "";
              document.getElementById('ch_selectors').innerHTML = "";





              var channels_stream = datas.channels;
              var idx_stream = (datas.channels.length) - 1; // -1 buat manggil array, kalau rawnya nda perlu -1



              $("#ch_selectors").append(`<option value="" disabled >Pilih....</option>`);
              $('#Wave_containerModal').modal('show');

              channels_stream.forEach(function(ch_stream) {
                // console.log(datas[ch_stream].sample_rate);

                document.forms['pickers_param']['current_date'].value = datas[ch_stream].start_time;


                var itemHtml = `<div class="seismograph" id="sinewave_` + ch_stream + `"></div>`;
                $("#append_data_stream").append(itemHtml);

                var ch_selectors_id_html = `<option value="` + ch_stream + `">` + ch_stream + `</option>`;
                $("#ch_selectors").append(ch_selectors_id_html);






                sampleRate = datas[ch_stream].sample_rate;
                start = seisplotjs.moment.utc(datas[ch_stream].start_time);




                seismogram = seisplotjs.seismogram.Seismogram.createFromContiguousData(datas[ch_stream].trace_data, sampleRate, start);


                div = seisplotjs.d3.select('div#sinewave_' + ch_stream);
                seisConfig = new seisplotjs.seismographconfig.SeismographConfig();
                seisConfig.title = datas[ch_stream].sta_names + '_' + ch_stream + ' ' + timeConverter(start);
                seisConfig.margin.top = 25;
                seisConfig.maxWidth = 1080;
                seisConfig.minWidth = 900;

                seisConfig.maxHeight = 600;
                seisConfig.minHeight = 250;

                // seisConfig.margin.bottom = 0;
                // seisConfig.margin.left = 0;
                // seisConfig.margin.right = 0;
                seisData = seisplotjs.seismogram.SeismogramDisplayData.fromSeismogram(seismogram);
                graph = new seisplotjs.seismograph.Seismograph(div, seisConfig, seisData);
                graph.draw();



              });

              // document.getElementById('append_data_stream').innerHTML = document.getElementById('data_stream_temp_pushed').innerHTML;
              // document.getElementById('data_stream_temp_pushed').innerHTML ='';

              $('.mdb-select').materialSelect({
                destroy: true
              });


              $('#Wave_containerModal').data('bs.modal').handleUpdate();


            },
            error: function(e) {
              $("#err").html(e).fadeIn();
            }
          });


        };

        var valuesd = [];

        $('#ch_selectors').on('change', function() {
          var $selectedOptions = $(this).find('option:selected');
          valuesd = [];
          $selectedOptions.each(function() {
            valuesd.push($(this).text());
          });

          // console.log(valuesd);
        });

        $('#form_pickers_param_id').submit(function(evnt) {
          evnt.preventDefault();

          var formData_params = new FormData($('#form_pickers_param_id')[0]);
          formData_params.append('current_mseed_file', $('#file_mseed')[0].files[0]);

          var selected_chs = [];

          var dat_selected_chs = JSON.stringify(valuesd);
          formData_params.append('ch_selectors', dat_selected_chs);



          $.ajax({

            type: "POST",

            url: "script/mseed_process.php",

            data: formData_params, // get all form field value in serialize form
            // data: {
            //                 channels: dat_selected_chs,
            //                 forms: formData_params,
            //             },

            contentType: false,
            cache: false,
            processData: false,
            success: function(result_finale) {
              $("#append_final_results").html('');
              // console.log(result_finale);


              var channels_to_stream = result_finale.channels;



              channels_to_stream.forEach(function(ch_selector) {
                // console.log(ch_selector);
                // console.log(result_finale[ch_selector]);
                var nama_station_channel = result_finale[ch_selector]['data_Streams'];
                var images_each = result_finale[ch_selector]['img'];
                var images_each_spectogrm = result_finale[ch_selector]['img_spectogrm'];




                var itemHtml = `<div class="col">
                                  <div class="row">
                                      <div class="col">
                                          <img class="img-fluid" src="data:image/png;base64, ` + images_each + `" alt="image_` + ch_selector + `" />
                                      </div>
                                      <div class="col">
                                          <img class="img-fluid" src="data:image/png;base64, ` + images_each_spectogrm + `" alt="image_spec_` + ch_selector + `" />
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

                var array_to_three_col = data_sensitivity.map(function(element, indx) {
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





              $('#Final_rslt_Modal').modal('show');

            }



          });
        });
      });


      function addZero(number) {
        if (number < 10)
          return "0" + number;
        else
          return number;
      }

      function seconds_starttime() {
        var start_hr_minutes = document.getElementById('input_starttime').value;

        $('#strtime_second_modal').on('show.bs.modal', function(e) {
          document.getElementById('strtime_second_modal_titles').innerText = start_hr_minutes + ':' + addZero(0);
          var seconds_Html = ` <center> <input type="range" id="seconds_range" value="0" max="59"> </center>`;
          document.getElementById('append_round_slider_seconds').innerHTML = seconds_Html;
        });

        $('#strtime_second_modal').modal('show');

        $("#seconds_range").roundSlider({
          sliderType: "default",
          handleShape: "dot",
          startAngle: 90,
          mouseScrollAction: true,
          endAngle: "+360",
          min: 0,
          value: 0,
          max: 59,
          value: 0,
          width: 10, // width of outer line
          radius: 125, // radius size
          handleSize: "+16",
          svgMode: true,
          pathColor: "#58a79c",
          rangeColor: "#fff",
          borderWidth: 0,
          handleColor: "#07786d",
          tooltipColor: "#000",
          tooltipFormat: function(args) {
            return addZero(args.value);
          },
          create: function() {
            document.getElementById('input_starttime').value = start_hr_minutes + ':' + addZero(0);
          },
          beforeCreate: function() {
            document.getElementById('input_starttime').value = start_hr_minutes + ':' + addZero(0);
          },
          drag: function(args) {
            document.getElementById('strtime_second_modal_titles').innerText = start_hr_minutes + ':' + addZero(args.value);
            document.getElementById('input_starttime').value = start_hr_minutes + ':' + addZero(args.value);
          },
          stop: function(args) {
            document.getElementById('input_starttime').value = start_hr_minutes + ':' + addZero(args.value);
            $('#strtime_second_modal').modal('hide');
            $("#seconds_range").roundSlider("destroy");
            document.getElementById('append_round_slider_seconds').innerHTML = "";
          },
        });

      };




      function seconds_endtime() {
        var start_hr_minutes = document.getElementById('input_endtime').value;

        $('#endtime_second_modal').on('show.bs.modal', function(e) {
          document.getElementById('endtime_second_modal_titles').innerText = start_hr_minutes + ':' + addZero(0);
          var seconds_Html = ` <center> <input type="range" id="seconds_end_range" value="0" max="59"> </center>`;
          document.getElementById('append_round_slider_end_seconds').innerHTML = seconds_Html;
        });

        $('#endtime_second_modal').modal('show');

        $("#seconds_end_range").roundSlider({
          sliderType: "default",
          handleShape: "dot",
          startAngle: 90,
          mouseScrollAction: true,
          endAngle: "+360",
          min: 0,
          value: 0,
          max: 59,
          value: 0,
          width: 10, // width of outer line
          radius: 125, // radius size
          handleSize: "+16",
          svgMode: true,
          pathColor: "#a1a1a1",
          rangeColor: "#fff",
          borderWidth: 0,
          handleColor: "#ffffff",
          tooltipColor: "#a1a1a1",
          tooltipFormat: function(args) {
            return addZero(args.value);
          },
          create: function() {
            document.getElementById('input_endtime').value = start_hr_minutes + ':' + addZero(0);
          },
          beforeCreate: function() {
            document.getElementById('input_endtime').value = start_hr_minutes + ':' + addZero(0);
          },
          drag: function(args) {
            document.getElementById('endtime_second_modal_titles').innerText = start_hr_minutes + ':' + addZero(args.value);
            document.getElementById('input_endtime').value = start_hr_minutes + ':' + addZero(args.value);
          },
          stop: function(args) {
            document.getElementById('input_endtime').value = start_hr_minutes + ':' + addZero(args.value);
            $('#endtime_second_modal').modal('hide');
            $("#seconds_end_range").roundSlider("destroy");
            document.getElementById('append_round_slider_end_seconds').innerHTML = "";
          },
        });

      };











      function meeee_cust_file_reset() {
        window.location.reload(true);
      };


      $(document).ready(() => {
        new WOW().init();


        $('[data-toggle="tooltip"]').tooltip();
        $('.mdb-select').materialSelect();
        $('.file-upload').file_upload();
        $('#input_starttime').pickatime({
          // Light or Dark theme
          darktheme: false,
          autoclose: true,
          afterDone: seconds_starttime
        });
        $('#input_endtime').pickatime({
          // Light or Dark theme
          darktheme: true,
          autoclose: true,
          afterDone: seconds_endtime
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
$Usernames= isset($_POST['username']) ? $_POST['username'] : '';
$Passwords = isset($_POST['password']) ? $_POST['password'] : '';

    // if ($_POST['username'] == $username && $_POST['password'] == $password) {
      if (isset($logins_usr_PW_pairs[$Usernames]) && $logins_usr_PW_pairs[$Usernames] == $Passwords){

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