<link href="<?php echo base_url(); ?>assets_new/css/fontawsome.css" rel="stylesheet" crossorigin="anonymous" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets_new/css/table_style.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets_new/css/load.css">
<link href="<?php echo base_url(); ?>assets_new/css/inbox-style.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets_new/css/select2.min.css" rel="stylesheet" />
<?php if ($this->session->userdata('language') != 'english') { ?>
  <link href="<?php echo base_url(); ?>assets_emp/exam/css/tornado-rtl.css" rel="stylesheet" />
<?php } else { ?>
  <link href="<?php echo base_url(); ?>assets_emp/exam/css/tornado.css" rel="stylesheet" />
<?php } ?>
<script src="<?php echo base_url(); ?>assets_new/js/tornado.min.js"></script>
<style>
  .quiz__settings .advanced-uploader::before {
    color: black;
  }

  .quiz__settings .advanced-uploader span {
    color: black;
  }

  .logo_img {
    width: 100%;
    background-position: center;
    background-size: 300px;
    background-repeat: no-repeat;
    padding: 0 !important;
    height: 300px !important;
  }

  .color_div {
    width: 20%;
    display: table-row-group;
    margin-left: 0.5%;
    float: right;
  }

  .color_div input {
    height: 60px !important;
  }

  <?php if ($this->session->userdata('language') == 'english') { ?>.enLink {
    width: 70% !important;
  }

  .enLink i {
    margin-right: -220px !important;
  }

  i.fa-edit {
    margin-right: -195px !important;
  }

  <?php } else { ?>.enLink {
    width: 8rem !important;
  }

  .enLink i {
    margin-right: 240px !important;
  }

  <?php } ?>.manage-content-home__section-box a {
    color: #2f1818;
  }

  .newNavPa {
    height: 84px;
  }

  .tooltip {
    position: absolute;
    z-index: 1;
    left: 0;
    width: fit-content;
    padding: 0 3px;
  }

  .tooltip-inner {
    padding: 5px;
    position: absolute !important;
    top: -15px !important;
    left: -61px;
    width: 65px !important;
  }

  .badge {
    display: inline-block;
    min-width: 10px;
    padding: 3px 7px;
    font-size: 12px;
    font-weight: 700;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    top: -7px !important;
    left: -7px !important;
    background: #fd1901;
    border-radius: 10px;
    height: 20px;
  }

  .quiz__settings {
    margin: 0 !important;
  }

  .quiz__settings label {
    margin-top: 0;
  }

  .advanced-uploader span {
    position: absolute;
    top: 60px;
    right: 40px;
  }
</style>
<div class="loading_div" id="loadingDiv"></div>

<div class="form-ui container-xl white-bg padding-all-20 mb40 round-corner" style="width: 100%;">
  <!-- Page Head -->
  <div class="page-head container-xl pt30 blue">
    <div class="row">
      <!-- Col auto -->
      <div class="col-auto">
        <!-- Breadcrumb -->

        <!-- Title -->
        <h1><?php echo lang('am_cms'); ?></h1>
      </div>
      <!-- //end -->
    </div>
  </div>
  <!-- // Page Head -->

  <?php
  if ($this->session->flashdata('SuccessAdd')) {
    echo  '<div class="alert alert-success">' . $this->session->flashdata('SuccessAdd') . '</div>';
  }
  if ($this->session->flashdata('ErrorAdd')) {
    echo  '<div class="alert alert-error">' . $this->session->flashdata('ErrorAdd') . '</div>';
  }
  ?>
  <!-- Filters -->

  <div class="modal-box edit-lang" id="edit-lang">
    <!-- Container -->
    <form action="<?php echo site_url('admin/content_management/update_language') ?>" method="post" class="modal-content mxw-768 form-ui overflow" style="width:1000px">
      <!-- Headline -->
      <h2 class="modal-head light-blue-bg">
        <?php echo lang('edit_lang'); ?>
        <button class="close-modal fas fa-times-circle"></button>
      </h2>
      <!-- Content -->
      <div class="modal-body tabs form-ui">
        <!-- row -->
        <div class="row">
          <div class="col-12 col-m-1">
            <label><?php echo lang('am_home') ?></label>
          </div>
          <div class="col-12 col-m-11">
            <input type="text" id="Schools_seek__ar" name="Schools_seek__ar" value="<?php echo specificlang('Schools_seek',  'config_lang', 'arabic'); ?>">
          </div>
        </div>
        <!-- row -->
        <div class="row">
          <div class="col-12 col-m-1">
            <label><?php echo lang('am_album') ?></label>
          </div>
          <div class="col-12 col-m-11">
            <input type="text" id="am_album_notes__ar" name="am_album_notes__ar" value="<?php echo specificlang('am_album_notes',  'config_lang', 'arabic'); ?>">
          </div>
        </div>


        <div class="row">
          <div class="col-12 col-m-1">
            <label><?php echo lang('Videos'); ?> <span><?php echo lang('school_Videos'); ?></span></label>
          </div>
          <div class="col-12 col-m-11">
            <input type="text" id="youtube_info__ar" name="youtube_info__ar" value="<?php echo specificlang('youtube_info',  'config_lang', 'arabic'); ?>">
          </div>
        </div>


        <div class="row">
          <div class="col-12 col-m-1">
            <label><?php echo lang('am_Activities_school') ?><span><?php echo lang('am_schools') ?></span></label>
          </div>
          <div class="col-12 col-m-11">
            <input type="text" id="am_Activities_notes__ar" name="am_Activities_notes__ar" value="<?php echo specificlang('am_Activities_notes',  'config_lang', 'arabic'); ?>">
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-m-1">
            <label>Home</label>
          </div>
          <div class="col-12 col-m-11">
            <input type="text" id="Schools_seek__en" name="Schools_seek__en" value="<?php echo specificlang('Schools_seek',  'config_lang', 'english'); ?>">
          </div>
        </div>
        <!-- row -->
        <div class="row">
          <div class="col-12 col-m-1">
            <label>Album</label>
          </div>
          <div class="col-12 col-m-11">
            <input type="text" id="am_album_notes__en" name="am_album_notes__en" value="<?php echo specificlang('am_album_notes',  'config_lang', 'english'); ?>">
          </div>
        </div>


        <div class="row">
          <div class="col-12 col-m-1">
            <label>Videos</label>
          </div>
          <div class="col-12 col-m-11">
            <input type="text" id="youtube_info__en" name="youtube_info__en" value="<?php echo specificlang('youtube_info',  'config_lang', 'english'); ?>">
          </div>
        </div>


        <div class="row">
          <div class="col-12 col-m-1">
            <label>Activities</label>
          </div>
          <div class="col-12 col-m-11">
            <input type="text" id="am_Activities_notes__en" name="am_Activities_notes__en" value="<?php echo specificlang('am_Activities_notes',  'config_lang', 'english'); ?>">
          </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer">
          <button class="btn miw-120 small primary rounded" type="submit"><?php echo lang('am_save'); ?></button>
        </div>

      </div>
    </form>

    <!--// Container -->
  </div>

  <!--<php  if($this->session->userdata('id') == '4471'){ ?>-->
  <form action="<?php echo site_url('admin/content_management/update_setting') ?>" method="post" class="form-ui quiz__settings" style="width: 100%;">
    <div class="color_Picker">
      <div class="color_div">
        <label style="font-size: 16px;" for="main-color">لون الموقع الالكتروني الاساسي:</label>

        <input type="color" id="main-color2" name="main-color2" value="<?php echo $get_setting['main-color2'] ?>"><br><br>
      </div>
      <div class="color_div">
        <label style="font-size: 16px;" for="main-color2">لون الموقع الالكتروني الثانوي:</label>
        <input type="color" id="main-color" name="main-color" value="<?php echo $get_setting['main-color'] ?>"><br><br>
      </div>

      <div class="color_div">
        <label style="font-size: 16px;" for="primary-color">اللون الاساسي :</label>
        <input type="color" id="primary-color" name="primary-color" value="<?php echo $get_setting['primary-color'] ?>"><br><br>
      </div>
      <!--<div class="color_div">-->
      <!--  <label style="font-size: 16px;" for="hover_color">اللون الثانوي:</label>-->
      <!--  <input type="color" id="hover_color" name="hover_color" value="<?php echo $get_setting['hover_color'] ?>"><br><br>-->
      <!--</div>-->
      <div>
        <label style="font-size: 16px;" for="primary-color"> صورة الشعار</label>
        <div class="advanced-uploader fas fa-images" data-text="اضغط هنا لرفع صورة الشعار" data-size="hd" style="padding :0;<?php if ($get_setting['Logo']) { ?>background-image: url(<?php echo base_url(); ?>intro/images/school_logo/<?php echo $get_setting['Logo'] ?>)<?php } ?>;height: 250px">


          <input type="file" name="logoimg" id="fileUpload" style="height: 100%" />
          <input name="hidImg" id="hidImg" type="hidden" value="<?php echo $get_setting['Logo'] ?>" />
        </div>
      </div>
      <div style="width: 60%;margin-top: -17%;">
        <label style="font-size: 20px;" for="main_color">لون الشريط الاساسي:</label>
        <!--<input  style="<?php echo $get_setting['home_color'] ?>" id="main_color" name="home_color" value="<?php echo $get_setting['home_color'] ?>"><br><br>-->
        <input type="color" id="main_color" name="home_color" value="<?php echo $get_setting['home_color'] ?>" style="height: 60px"><br><br>
      </div>
    </div>
    <button type="submit" class="btn small blue-bg">حفظ</button>
  </form>
  <!-- modal--
  <!-- //end div -->
</div>
<!-- // Page Wraper -->
</div>
<!-- // Layout Wraper -->
</div>
<script>
  $(document).ready(function() {
    $("#loadingDiv").hide();
  });
</script>
<script>
  $('#fileUpload').change(function(e) {
    $("#loadingDiv").show();
    var xhr = new XMLHttpRequest();
    var data = new FormData();
    jQuery.each($('#fileUpload')[0].files, function(i, file) {
      data.append('file', file);
    });
    /*==============================================================================================*/
    /*----------------------------------------------------------------------------*/
    $.ajax({
      url: '<?php echo site_url('admin/Content_management/up_ax_content') ?>',
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      type: 'POST',
      beforeSend: function() {

      },
      success: function(data) {
        $("#loadingDiv").hide();
        if (data.msg_type == 0) {
          $("#msgUpload").html(data.msg_upload);
        } else if (data.msg_type == 1) {
          var newImg = data.base + 'upload/' + data.img;
          var hidImg = $("#hidImg").val(data.img);
          $("#div_img").append('<div id="imgcon"><a href="' + newImg + '" ><?php echo lang('am_download'); ?></a><button class="uploadclose" onClick="delImgUp();">X</button></div>');
        }
      }
    });
    /*==============================================================================================*/
  });

  function delImgUp() {
    $("#imgcon").remove()
  }
</script>