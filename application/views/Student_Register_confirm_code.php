<style>
  .row,
  .flexbox,
  .flex-box,
  .flexbox.container,
  .flex-box.container,
  .form-repeater .repeater-item,
  .form-group,
  .modal-box .modal-content .modal-footer,
  #lightbox-modal .modal-content,
  .secondary-header,
  #plan-table table .table tbody td {
    display: block !important;
  }

  #SchoolData,
  .news-bar {
    display: none !important;
  }

  #school_id {
    visibility: hidden;
    opacity: 0;
  }
</style>
<?php $query = $this->db->query("select * from setting")->row_array();

$home_theme = $query['home_theme'];
if ($home_theme) {
  include('home_new/' . $home_theme . '/header.php');
} else {
  include('home_new/header.php');
}
?>
<link href="https://fonts.cdnfonts.com/css/neo-sans-arabic?styles=50556,50562" rel="stylesheet">

<link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">



<?php
//print_r($lang);die;
$langSession = $lang;
switch ($langSession) {
  case 'arabic':

    $this->session->set_userdata('language', 'arabic');
    break;
  case 'english':
    $this->session->set_userdata('language', 'english');
    break;
  default:
    $this->session->set_userdata('language', 'arabic');
}
?>

<style>
  <?php if ($this->session->userdata('language') == 'english') { ?>.success-data {
    text-align: left;
    font-family: 'Neo Sans Arabic', sans-serif;
    direction: ltr;
  }

  .success-data ul li:before {
    float: left;
  }

  <?php } else { ?>.success-data {
    text-align: right;
    font-family: 'Neo Sans Arabic', sans-serif;
    direction: rtl;
  }

  .success-data ul li:before {
    float: right;
  }

  <?php } ?>body {
    font-family: 'Neo Sans Arabic', sans-serif;
    ;
  }

  .top-bar,
  .nav-bar,
  footer {
    display: none;
  }

  .widgets-box {
    box-shadow: none !important;
  }

  .widgets-box h4 {
    font-size: 19px;
    font-weight: 600;
    float: initial !important;
    background-color: var(--main-color2);
    /*padding: 14px;*/
    text-align: center;
    margin: 0 0 25px 0;
  }

  .widgets-box h4 span {
    border-bottom: 0 !important;
    color: #fff !important;
  }

  .all-data-content {
    padding: 0 0 10px;
    background-color: #f5f5f5;
    box-shadow: 0px 1px 3px #cecece;
  }

  .refuse-data {
    text-align: right;
    font-family: 'Neo Sans Arabic', sans-serif;
    direction: rtl;
  }


  .success-data h3 {
    color: green;
    font-size: 25px;
    margin: 0;
    padding: 14px 10px;
    position: relative;
    margin-right: 10px;
    margin-top: 3px;
  }

  .success-data h3::after {
    content: "";
    width: 109px;
    height: 3px;
    display: block;
    background: green;
    margin-right: -5px;
  }

  .success-data ul {
    list-style: none;
  }

  .success-data ul li {
    font-size: 18px;
    margin-bottom: 14px;
    margin-top: 17px;
  }

  .success-data ul li:before {
    content: "";
    color: green;
    font-family: FontAwesome;
    font-size: 12px;
    margin-left: 7px;
    line-height: 0;
    width: 15px;
    height: 15px;
    display: inline-block;
    background: green;
    border-radius: 50%;

  }

  .refuse-data1 {
    text-align: right;
    font-family: 'Neo Sans Arabic', sans-serif;
    border: 1px solid red;
    background: #f00;
    color: #fff;
    border-radius: 10px;
    width: 50%;
    margin: auto;
  }

  .refuse-data1 ul {
    list-style: none;
  }

  .refuse-data1 ul li {
    font-size: 20px;
    margin-bottom: 14px;
    margin-top: 17px;
    font-weight: bold;
  }

  .refuse-data1 ul li:after {
    content: "";
    color: red;
    font-family: FontAwesome;
    font-size: 12px;
    margin-left: 7px;
    line-height: 0;
    width: 15px;
    height: 15px;
    display: inline-block;
    background: #940000;
    margin-right: 13px;
    border-radius: 50%;
  }

  .block-symbol:after {
    content: "\f056" !important;
    color: red;
    font-family: FontAwesome;
    font-size: 12px;
    margin-left: 7px;
    line-height: 0;
  }

  .codeInput {
    height: 36px;
    border-color: #e6e6e6;
    box-shadow: none;
    border: 0;
    width: 500px;
    text-align: center;
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 25px;
  }

  .btn.btn-success {
    min-width: 150px;
    height: 36px;
    display: inline-block;
    border: 2px solid var(--main-color);
    outline: none;
    background: var(--main-color);
    border-radius: 15px;
    font-size: 20px;
    font-weight: bold;
    color: #fff;
    cursor: pointer;
  }

  .btn.btn-info {
    text-align: left;
    text-decoration: none;
    display: inline-block;
    width: 200px;
    font-size: 18px;
    font-weight: bold;
    color: var(--main-color2);
  }

  .requestContent {
    background: #fff;
    padding-top: 50px;
  }
</style>





<div class="col-lg-12 col-md-12">
  <div class="widgets-box widgets-box-in wow fadeIn" data-wow-duration="0s" data-wow-delay="0s" style="margin-top: 30;min-height: 420px;background: border-box;">
    <div class="all-data-content col-xs-12" style="width:60%;margin:auto;margin-top: 150px;">
      <?php if ($this->session->flashdata('ErrorAdd')) { ?>
        <div class="col-lg-12 row text-right btn btn-success" style="text-align:center;background: red;">
          <?php
          echo $this->session->flashdata('ErrorAdd'); ?>
        </div>
      <?php } else if ($this->session->flashdata('SuccessAdd')) { ?>
        <div class="alert alert-success">
          <?php echo $this->session->flashdata('SuccessAdd'); ?>
        </div>
      <?php } ?>
      <h4><span class="text-color"><?php echo lang('am_new_student_confirm_Code'); ?></span></h4>

      <div class="col-lg-2 form-group"></div>
      <form action="<?= site_url('home/student_register/confirm_code/' . $confirmCode . "/" . $cheackCode); ?>" method="post">
        <input type="hidden" id="confirmCode" value="<?= $confirmCode; ?>" />
        <input type="hidden" id="cheackCode" value="<?= $cheackCode; ?>" />
        <div class="col-lg-5 form-group">
          <label class="control-label"> </label>
          <div class="col-lg-12 row" style="text-align: center">
            <input class="form-control codeInput" dir="rtl" type="text" id="code" name="code" placeholder="<?php echo lang('bar_code'); ?>">
          </div>
        </div>
        <div class="col-lg-5 form-group">
          <label class="control-label"> </label>
          <div class="col-lg-12 row text-right" dir="rtl" style="text-align:center">
            <input id="check_data" class="btn btn-success" type="submit" value="<?php echo lang('confirm'); ?>">
          </div>
        </div>

        <div class="col-lg-5 form-group">
          <label class="control-label"> </label>
          <div class="col-lg-12 row text-right" dir="rtl" style="text-align:center;padding: 40px;color: red;">
            <?php echo lang("br_message_confirm"); ?>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>