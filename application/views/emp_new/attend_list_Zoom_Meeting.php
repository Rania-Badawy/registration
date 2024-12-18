<!DOCTYPE html>
<html lang="en" dir="rtl">
    <head>
        <!-- Required Meta Tags -->
        <meta name="language" content="ar">
        <meta http-equiv="x-ua-compatible" content="text/html" charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="The Description of This Page Goes Right Here and its !Important" />
        <meta name="keywords" content="keywords,goes,here,for,this,web,site,its,!important,and,keep,it,dynamic" />
        <title>الفصول الافتراضيه</title>
        <!-- Open Graph Meta Tags -->
        <meta property="og:title" content="This Page title Goes Here" />
        <meta property="og:description" content="The Description of This Page Goes Right Here and its !Important" />
        <meta property="og:url" content="http://domain.com/page-url/" />
        <meta property="og:image" content="<?php echo base_url(); ?>zoom/img/logo.png" />
        <meta name="twitter:image" content="<?php echo base_url(); ?>zoom/img/logo.png">
        <meta name="facebook:description" content="The Description of This Page Goes Right Here and its !Important" />
        <!-- Other Meta Tags -->
        <meta name="robots" content="index, follow" />
        <meta name="copyright" content="Sitename Goes Here">
		<link rel="shortcut icon" type="image/png"  href="<?php echo base_url(); ?>zoom/img/logo.png">
        <!-- Required CSS Files -->
        <link href="<?php echo base_url(); ?>zoom/css/tornado-icons.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>zoom/css/tornado-rtl.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Modal Box -->
        <div class="modal-box" id="add-session">
            <!-- Container -->
            <form class="modal-content form-ui" action="<?php echo site_url('admin/zoom/Zoom_post'); ?>" method="post">
                <!-- Headline -->
              
                <!-- Content -->
                <!-- Footer -->
                <div class="modal-footer">
                    <button  class="btn round-corner small primary" type="submit">اضافة الجلسة</button>
                    <a href="#" class="btn round-corner small danger close-modal">اغلاق النافذة</a>
                </div>
            </form>
            <!--// Container -->
        </div>
        <!-- // Modal Box -->

        <!-- Page Content -->
        <div class="container seasson-page">
            <!-- Header -->
            <header class="tornado-header flex-box align-center-y align-between">
               <!-- <a href="" class="logo"><img src="<?php echo base_url(); ?>zoom/img/logo.png" alt=""></a> -->
                <div class="action-btns">
                    <?php if($this->session->userdata('type')=='U'||$this->session->userdata('type')=='E'){?>
                    <!--<a href="#" class="btn small primary round-corner" data-modal="add-session">اضافة جلسة</a>-->
                    <?php } ?>
                    <!-- Dropdown Button -->
                    <!--<div class="dropdown">
                        <a href="#" class="dropdown-btn btn small round-corner ti-arrow-down-chevron"><img src="https://via.placeholder.com/50x50" alt=""> مرحبا,  <?php echo $this->session->userdata('contact_name');?> </a>
                        <ul class="dropdown-list">
                            <li><a href="<?php echo site_url('zoom/log_out');?>" class="ti-power">تسجيل الخروج</a></li>
                        </ul>
                    </div>-->
                
                </div>
                    <?php if($this->session->userdata('cantadd') != '') 	{?>
                    <div class="alert alert-danger">
 <?=$this->session->userdata('cantadd')?>
 
</div><?php $this->session->unset_userdata('cantadd'); }?>
                
            </header>
            <!-- // Header -->

            <!-- Page Title -->
            <h1 class="h4 tx-align-center page-title"> <?= lang('List of sessions') ?>   </h1>
            <!-- // Page Title -->

            <!-- Tabel Wraper -->
            <div class="responsive-table">
                <!-- Table -->
                <table class="table bordered striped">
                    <!-- Head -->
                    <thead>
                        <tr>
                            
                                  <th class="primary-bg"> <?= lang('Session name') ?>   </th>
                            <th class="primary-bg"><?= lang('Room') ?>     </th> 
                            <th class="primary-bg"><?= lang('br_status') ?> </th>
                            <th class="primary-bg"><?= lang('br_date_st') ?>   </th>
                            <th class="primary-bg"><?= lang('Duration') ?></th>
                            <th class="primary-bg"><?= lang('time zone') ?> </th>
                            <th class="primary-bg"><?= lang('Added date') ?> </th>
                             <th class="primary-bg"><?= lang('joining') ?>   </th> 
                             <!--<th class="primary-bg"><?= lang('br_show') ?>   </th>  -->
                           
                            <th class="primary-bg hidden"></th>
                            <th class="primary-bg hidden"></th>
                        </tr>
                    </thead>
                    <!-- Table Body -->
                    <tbody>
                        <?php   
                       //  $date=date('Y/m/d H:i:s',strtotime('+2 hour'));
                         //print_r($date);
                        foreach($get_All as $k=>$item){
                        // $start_time=$item->start_time;
                        // $min=$item->duration;
                        // $endTime = date('Y-m-d H:i:s',strtotime($start_time) + $min*60);
                        
                        $start_time  = $item->start_time;
                        $min         = $item->duration;
                        $endTime     = date('Y-m-d H:i:s',strtotime($start_time) + $min*60);
                        $starttime   = date('Y-m-d H:i:s',strtotime($item->start_time));
                        $createdat   = $item->created_at;
                       // print_r($start_time);
                       // if($start_time>$date){print_r($start_time);}
                        
                        
                                      //get room 
                                      $token=$this->zoom_token;
                                        $curl_h = curl_init('https://api.zoom.us/v2/users/'.$item->host_id);
                                         curl_setopt($curl_h, CURLOPT_HTTPHEADER,
                                        array(
                                           "Authorization:Bearer".$token,
                                          )
                                         );
                                    
                                    curl_setopt($curl_h, CURLOPT_RETURNTRANSFER, true);
                                    $response =  json_decode(json_encode(curl_exec($curl_h)), true); 
                                 //   print_r($response);die;
                                    $obj = json_decode($response);
                                   $room_email= $obj->{'email'};
                                     foreach($rooms as $r){
                                    if($r->email ==$room_email ) {
                                       $room=$r->name;
                                    }
                                 } 
       
    // if($endTime<$date){}else{
                        ?>
                        <tr>
                            <th><?= $item->topic ?></th>
                            <th><?= $item->roomname ?></th>
                            <th><?php if($endTime<$date){?>
                                <span class="info-icon ti-stop text-danger">Finshed</span>
                                <?php } elseif($starttime>$date){?>
                                <span class="fa fa-clock-o text-primary">waititing start time</span>
                                <?php } else{?>
                                <span class="info-icon ti-videocam text-success">Live</span>
                                <?php }?></th>
                            <th style="width:100px;"><span class="info-icon ti-calendar"><?= date('j M, h:i:s A',strtotime($item->start_time));?></span></th>
                            <th><span class="info-icon ti-clock"><?= $item->duration ?></span></th>
                            <th><span class=""><?= "Africa/Cairo" ?></span></th>
                            <th style="width:100px;"><span class="info-icon ti-calendar"><?= date('j M, h:i:s A',strtotime($item->created_at)); ?></span></th>
                          
                            <th><?php if($starttime>$date||$endTime<$date){?>
                            <span class="ti-block"></span>
                            <?php } else{?>
                            
                                      <?php         
                                     $token=$this->zoom_token;
                                     $curl_h = curl_init('https://api.zoom.us/v2/meetings/'.$item->meeting_id);
                                     curl_setopt($curl_h, CURLOPT_HTTPHEADER,
                                     array("Authorization:Bearer".$token,));
                                     curl_setopt($curl_h, CURLOPT_RETURNTRANSFER, true);
                                     $response =  json_decode(json_encode(curl_exec($curl_h)), true); 
                                     $obj = json_decode($response);
        ?>
       <?php if($item->external_link !=NULL ||$item->external_link !=""){?>
					      <a href="<?php echo $item->external_link; ?>" target="_blank" class="btn small circle ti-plus success"></a>
					      <?php } else {?>
            <!--<a target="_blank" href="<?=   $obj->{'start_url'}; ?>" class="btn     success" ><?= lang('Join via the Zoom program') ?> </a>-->
       
       
       
            <a href="<?php echo site_url('admin/zoom/user_attend/' . $item->meeting_id.'/' . $item->id .'/'. $endTime) ?>" class="btn small circle ti-plus success"></a>
                            
                            
                         <!--  <a href="<?php echo site_url('student/cpanel/user_attend/' . $item->id ) ?>" class="btn small circle ti-plus success">
                                 -->
      
    
<!-- Central Modal Medium -->
    <div class="modal fade" id="centralModal<?=$item->id?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     
    <!-- Central Modal Medium -->


 
                            <?php }}?></th>
                             <!--<th>-->
                             <? /*
                             $token=$this->zoom_token;
        //  $x="https://api.zoom.us/v2/meetings/$id->meeting_id/recordings";
          echo $x;
	      $curl_h = curl_init("https://api.zoom.us/v2/meetings/$item->id/recordings");
        curl_setopt($curl_h, CURLOPT_HTTPHEADER,
            array(
               "Authorization:Bearer".$token,
            )
        );
        
        curl_setopt($curl_h, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($curl_h));
        // print_r($response->{recording_files});
        if($response->{recording_files}!=''){
            
          $recording_files=$response->{recording_files} ;
          foreach ($recording_files as $key => $value){
              //  echo $key;
                if($recording_files[$key]->{recording_type}=='shared_screen_with_speaker_view')
              { $show_link=$recording_files[$key]->{play_url};
               echo '<a href="'. $show_link.'"  target="_blank">مشاهده </a><br><br>';}
           }
          // print_r($response->{recording_files});
    //    if($response->{recording_files}!=''){
      //    $vedio_count= count($response->{recording_files});
      //    $recording_files=$response->{recording_files} ; 
         //  print_r ($recording_files);
           
        //   foreach ($recording_files as $key => $value){
      //         echo $key;
       //    }
    //    }
//           foreach ($recording_files as $value) {
//  $response = json_decode(curl_exec($curl_h));
//   print_r ($value);
// }
 
        }*/
         ?>
         <!--</th>-->
                            <th hidden><?= $item->uuid ?></th>
                            <th hidden><?= $item->host_id ?></th>
                        </tr>
                        <?php }?>
                    </tbody>
                    <!-- // Table Body -->
                </table>
                <!-- // Table -->
            </div>
            <!-- // Tabel Wraper -->

        </div>
        <!-- // Page Content -->
         <!-- Copyright -->
        <!--<div class="copyrights pt10 pb10 primary-bg tx-align-center"><a class="white-color" target="_blank" href="https://esol.com.sa">جميع الحقوق محفوظة لـتطوير الحلول الخبيرة</a></div>-->
        <!-- Required JS Files -->
        <script src="<?php echo base_url(); ?>zoom/js/tornado.min.js"></script>
        
<!--       <script type="text/javascript">-->

<!-- var datasend = [];-->
<!-- var dataChart = [];-->
<!-- var myChart = 0; -->
  
          <!--When the document is ready-->
<!-- function clearColumns(ColumnsArray){-->
<!--           $(ColumnsArray).each(function(){-->
<!--                $(this).empty();-->
<!--                $(this).append('<option value="0">تحديد الكل</option>')-->
<!--            });-->
<!--        }-->
<!--        $(document).ready(function () {  -->
 
  
<!--          $('select[name="level"]').on('change', function() { -->
<!--              var stateID = $(this).val();-->
<!--              if(stateID) {-->
<!--                  $.ajax({-->
<!--                      url: '<?php echo site_url();?>' + '/admin/report_student_eval/getRowLevel/'+stateID,-->
<!--                      type: "GET",-->
<!--                      dataType: "json",-->
<!--                      success:function(data) { -->
<!--                          clearColumns("#RowLevel");-->
<!--                          $.each(data, function(key, value) {-->
<!--                              $('select[name="RowLevel"]').append('<option value="'+ value.RowLevelID +'">'+ value.LevelName + '--' +  value.RowName + '</option>');-->
<!--                          }); -->
<!--                      } -->
<!--                  });-->
<!--              }else{-->
<!--                  $('select[name="RowLevel"]').empty();-->
<!--              }-->
<!--          });-->
   
 

<!--      });-->
   
<!--</script>-->
    

    </body>
</html>