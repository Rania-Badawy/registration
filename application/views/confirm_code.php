<?php $query = $this->db->query("select * from setting")->row_array();

$home_theme = $query['home_theme'];
if ($home_theme) {
  include('home_new/' . $home_theme . '/header.php');
} else {
  include('home_new/header.php');
}
?>
<link href="https://fonts.cdnfonts.com/css/neo-sans-arabic?styles=50556,50562" rel="stylesheet">

<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" />
<?php if ($this->session->userdata('language') != 'english') { ?>
  <link href="<?php echo base_url(); ?>css/rtl.css" rel="stylesheet">
<?php } else { ?>
  <link href="<?php echo base_url(); ?>css/ltr.css" rel="stylesheet">
<?php } ?>
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

  .widgets-box h4 {
    font-size: 19px;
    font-weight: 600;
    float: initial !important;
    background-color: var(--main-color2);
    padding: 14px;
    text-align: center;
    margin: 0 0 25px 0;
  }

  .widgets-box h4 span {
    border-bottom: 0 !important;
    color: #fff !important;
  }

  .all-data-content {
    padding: 0 0 10px;
    /*background:linear-gradient(90deg,#96cce5,#79ccf2, #85c4e1,#7dc3e3);*/
    background: #f9f9f9;
    box-shadow: 0px 1px 3px #cecece;
    width: 100%;
  }

  .refuse-data {
    text-align: right;
    font-family: 'Neo Sans Arabic', sans-serif;
    direction: rtl;
  }

  .widgets-box-in {
    padding-bottom: 0 !important;
    margin-bottom: 0 !important;
    margin-top: 100px;
    background: transparent;
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
    border-radius: 25px;
    margin-bottom: 25px;
    background: #fff;
  }

  @media screen and (max-width: 500px) {
    .codeInput {
      width: 280px !important;
    }
  }

  .btn.btn-success {
    min-width: 150px;
    height: 36px;
    display: inline-block;
    border: 0;
    outline: none;
    border-radius: 5px;
    font-size: 20px;
    font-weight: bold;
  }

  .btn.btn-info {
    text-align: center;
    text-decoration: none;
    display: inline-block;
    width: 120px;
    font-size: 18px;
    font-weight: bold;
    color: #fff;
    background: var(--main-color);
    border-color: var(--main-color);
    border-radius: 25px;
    outline: none;
  }

  .requestContent {
    background: #fff;
    padding-top: 50px;
  }

  .news-bar {
    display: none;
  }

  #school_id {
    visibility: hidden;
    opacity: 0;
  }

  .errMsg {
    position: absolute;
    top: 30px;
    right: 14px;
    height: 50px;
    border-radius: 4px;
    border: 1px solid #000;
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
    font-size: 18px;
    line-height: 35px;
    width: 50%;
    font-weight: bold;
    text-align: right;
    padding: 0 10px;
  }

  .codeCon {
    display: flex;
    justify-content: center;
    margin-top: 70px
  }

  @media (max-width:500px) {

    .codeCon {
      display: block;
      width: 98%;
      margin-right: 10px;
    }

    .all-data-content {
      width: 98%;
    }

    .btnMobile {
      width: 108%;
    }

    .upper {
      top: 60px !important;
    }
  }

  .Iconbtn {
    display: none !important;
  }
</style>



<div class="codeCon">
  <div>
    <div class="widgets-box widgets-box-in wow fadeIn" data-wow-duration="0s" data-wow-delay="0s">
      <div class="all-data-content col-xs-12">
        <?php if ($this->session->flashdata('ErrorAdd') && $enter_code) { ?>
          <div class="errMsg">
            <?php
            echo $this->session->flashdata('ErrorAdd'); ?>
          </div>
        <?php } else if ($this->session->flashdata('SuccessAdd')) { ?>
          <div class="alert alert-success">
            <?php echo $this->session->flashdata('SuccessAdd'); ?>
          </div>
        <?php } ?>
        <h4><span class="text-color"><?php echo lang('request_code'); ?></span></h4>

        <div class="col-lg-2 form-group"></div>
        <form action="<?= site_url('home_new/home/confirm_code'); ?>" method="post">
          <input type="hidden" name="Number_ID" value="<?= $Number_ID; ?>" />
          <input type="hidden" name="GetYear" value="<?= $SelectYear; ?>" />
          <input type="hidden" name="school" value="<?= $SelectSchool; ?>" />
          <input type="hidden" name="code" value="<?= $code; ?>" />
          <div class="col-lg-8 form-group ">
            <label class="control-label"> </label>
            <div class="col-lg-12 row" style="text-align: center">
              <input class="form-control codeInput" dir="rtl" type="text" id="enter_code" name="enter_code" placeholder="<?php echo lang('br_mobile_code'); ?>">
            </div>
          </div>
          <div class="col-lg-12 form-group">
            <label class="control-label"> </label>
            <div class="col-lg-12 row btnMobile" style="justify-content: center" dir="rtl">
              <input id="check_data" class="btn btn-info" type="submit" value="<?php echo lang('confirm'); ?>">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>