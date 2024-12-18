 <?php $query = $this->db->query("SELECT * FROM `setting` WHERE 1")->row_array(); ?>
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

     .fas.fa-plus.add-item {
         display: flex;
         justify-content: center;
         align-items: center;
     }

     .tooltip {
         position: absolute;
         z-index: 1;
         padding: 3px;
         width: fit-content;
         height: 20px;
     }
 </style>




 <div class="loading_div" id="loadingDiv"></div>
 <script>
     $(document).ready(function() {
         $("#loadingDiv").hide();
     });
 </script>



 <form class="form-ui manage-content__form" action="<?php echo site_url('admin/Content_management/add_call_us') ?>" method="post" style="width: 100%;">
     <?php
        if ($this->session->flashdata('SuccessAdd')) {
        ?>
         <div class="widget-content">
             <div class="widget-box">
                 <div style="text-align: center;" class="alert alert-success fade in">
                     <button data-dismiss="alert" class="close" type="button">×</button>
                     <?php
                        echo $this->session->flashdata('SuccessAdd');
                        ?>
                 </div>
             </div>
         </div>
     <?php
        }

        if ($this->session->flashdata('Failuer')) {
        ?>
         <div class="widget-content">
             <div class="widget-box">
                 <div style="text-align: center;" class="alert alert-danger fade in">
                     <button data-dismiss="alert" class="close" type="button">×</button>
                     <?php
                        echo $this->session->flashdata('Failuer');
                        ?>
                 </div>
             </div>
         </div>
     <?php
        }
        ?>
     <div class="page-head container-xl pt30 blue">
         <div class="row">
             <div class="col-auto">
                 <div class="breadcrumb">
                     <a href="<?php echo site_url('admin/cpanel') ?>" class="ti-x fas fa-home"><?php echo lang('am_home'); ?></a>
                 </div>
                 <h1><?php echo lang('am_contact_us'); ?> </h1>
             </div>
         </div>
     </div>

     <div class="container-xl white-bg padding-all-20 mb40 round-corner main-container">
         <h5 class="mb20"><?php echo lang('Social_Media'); ?> </h5>
         <div class="row mb30">
             <!-- field -->
             <div class="col-12 col-m-4 col-xl-4">
                 <label class="mb5"><?php echo lang('youtube_link'); ?></label>
                 <input type="text" name="youtube" class="form-control" value="<?php echo $get_social_data['youtube']; ?>">
             </div>
             <div class="col-12 col-m-4 col-xl-4">
                 <label class="mb5"><?php echo lang('facebook_link'); ?></label>
                 <input type="text" name="facebook" class="form-control" value="<?php echo $get_social_data['facebooklink']; ?>">
             </div>
             <div class="col-12 col-m-4 col-xl-4">
                 <label class="mb5"><?php echo lang('twitter_link'); ?></label>
                 <input type="text" name="twitter" class="form-control" value="<?php echo $get_social_data['twitterlink']; ?>">
             </div>
             <!--<div class="col-12 col-m-4 col-xl-4">-->
             <!--  <label class="mb5"><?php echo lang('snapchat_link'); ?></label>-->
             <!--  <input type="text" name="snapchat" class="form-control" value="<?php echo $get_social_data['snapchat']; ?>">-->
             <!--</div>-->
             <div class="col-12 col-m-4 col-xl-4">
                 <label class="mb5"><?php echo lang('tiktok'); ?></label>
                 <input type="text" name="tiktok" class="form-control" value="<?php echo $get_social_data['tiktok']; ?>">
             </div>

             <div class="col-12 col-m-4 col-xl-4">
                 <label class="mb5"><?php echo lang('Instagram_link'); ?></label>
                 <input type="text" name="Instagram" class="form-control" value="<?php echo $get_social_data['instagramLink']; ?>">
             </div>
             <div class="col-12 col-m-4 col-xl-4">
                 <label class="mb5"><?php echo lang('google_plus_link'); ?></label>
                 <input type="text" name="google_plus" class="form-control" value="<?php echo $get_social_data['google-plus']; ?>">
             </div>
             <div class="col-12 col-m-4 col-xl-4">
                 <label class="mb5"><?php echo lang('br_school_web'); ?></label>
                 <input type="text" name="web_page" class="form-control" value="<?php echo $get_social_data['web_page']; ?>">
             </div>

             <div class="col-12 col-m-4 col-xl-4">
                 <label class="mb5">linkedin</label>
                 <input type="text" name="linkedin" class="form-control" value="<?php echo $get_social_data['linkedin']; ?>">
             </div>

             <div class="form-repeater col-12 col-m-4 col-xl-4">
                 <label class="mb5"><?php echo lang('snapchat_link'); ?></label>
                 <?php
                    $LinkArray = $get_social_data['snapchat'];
                    $Links = explode('||', $LinkArray);
                    $url = $Links[0];
                    $Link = explode(',', $url);
                    $Name = $Links[1];
                    $LinkName = explode(',', $Name);
                    ?>
                 <?php foreach ($Link as $key => $val) { ?>
                     <div class="repeater-item" style="width: -webkit-fill-available;">
                         <div style="display: inline-flex;">

                             <input type="text" name="snapchat[]" class="form-control" value="<?php echo $val ?>">
                             <input type="text" name="snapchat_name[]" class="form-control" value="<?php echo $LinkName[$key] ?>" style="width: 75%;">

                         </div>
                         <?php if ($key == 0) { ?>
                             <a href="#" class="fas fa-plus add-item"></a><?php } else { ?>
                             <a href="#" class="fas rpdone remove-item fa-minus"></a>
                         <?php } ?>

                         <!--</div>-->

                     </div>
                 <?php } ?>
             </div>
         </div>
     
         <div class="col-12 col-m-4 col-xl-4" style="margin-top: 23px;">

             <button class="btn small blue-bg" type="submit"><?php echo lang('br_save'); ?></button>

         </div>
     </div>
 </form>