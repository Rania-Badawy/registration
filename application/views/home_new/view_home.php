<style>
    .mkak iframe {
        height: 99% !important;
    }

    .owl-carousel .owl-item img {
        display: block;
        width: 100%;
        height: auto;
        max-height: 600px;
    }
</style>

<?php
if ($this->session->userdata('language') == 'english') {
    $SchoolName  = 'SchoolEnName';
} else {
    $SchoolName  = 'SchoolName';
}

$settingQuery = $this->db->query("select *, setting.$SchoolName as SchoolName from setting")->row_array();
?>
<script>
    // let slideIndex = 1;
    // showSlides(slideIndex);

    // Next/previous controls
    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    // Thumbnail image controls
    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    // function showSlides(n) {
    //   let i;
    //   let slides = document.getElementsByClassName("abmySlides");
    //   if (n > slides.length) {slideIndex = 1}
    //   if (n < 1) {slideIndex = slides.length}
    //   for (i = 0; i < slides.length; i++) {
    //     slides[i].style.display = "none";
    //   }
    //   slides[slideIndex-1].style.display = "block";
    // }
</script>
<?php if (!empty($Advertisement)) { ?>
    <div class="popupCon">
        <div class="popup">
            <button id="close">&times;</button>
            <div style="text-align: center">
                <?php if ($Advertisement[0]->ImagePath) {
                    $ext = pathinfo(explode(',', $Advertisement[0]->ImagePath)[0], PATHINFO_EXTENSION);
                    if ($Advertisement[0]->ImagePath) {
                        if ($ext == MP4 || $ext == mp4) { ?>
                            <video width="80%" height="500" controls>
                                <source src="<?php echo base_url() . 'upload/' . explode(',', $Advertisement[0]->ImagePath)[0]; ?>" type="video/<?= $ext; ?>">
                            </video>
                        <?php } else { ?>
                            <img width="80%" height="500" src="<?php echo base_url() . 'upload/' . explode(',', $Advertisement[0]->ImagePath)[0]; ?>" title="<?php echo $Advertisement[0]->img_description; ?>">
                <?php }
                    }
                } ?>
            </div>
            <h2><?php echo $Advertisement[0]->Title ?></h2>
            <p><?php echo $Advertisement[0]->Content ?></p>
        </div>
    </div>
<?php } ?>



<?php $validDatabases = ['esolcom_alfadeelah', 'SchoolAccDaralahfad', 'SchoolAccExpert'];
$class = in_array($settingQuery['ApiDbname'], $validDatabases) ? 'openDiv' : 'validDatabasesDiv'; ?>

<div class="<?= $class ?>">
    <?php if (in_array($settingQuery['ApiDbname'], $validDatabases)) { ?>
        <h1 style="font-size: 1.8em;">
            <? echo lang('welcome_to') ?><span span class="spanOpen"><?php echo " " . $settingQuery['SchoolName'] . " "; ?></span>
        </h1>
    <? } ?>

</div>

<?php if (!empty($banner)) { ?>
    <?php if (in_array($settingQuery['ApiDbname'], $validDatabases)) { ?>
        <div class="slideshow-container">
            <div style="width: 85%;margin: auto;">
                <div class="carousel main">
                    <?php foreach ($banner as $num => $item) {
                        $ImagePath = $item->ImagePath;
                        $img_description = explode(",", $item->img_description);
                        $title =  $item->Title;
                        if ($item->ImagePath) {
                            $ImagePath = explode(",", $item->ImagePath);
                            foreach ($ImagePath as $key => $Image) {
                                $ext = pathinfo($Image, PATHINFO_EXTENSION);
                                if ($Image) {
                    ?>
                                    <a href="#" class="carousel-item">
                                        <?php if ($ext == MP4 || $ext == mp4) { ?>
                                            <video width="100%" height="100%" controls>
                                                <source src="<?php echo base_url() . 'upload/' . $Image; ?>" type="video/<?= $ext; ?>">
                                            </video>
                                        <?php } elseif ($ext == 'pdf' || $ext == 'txt') { ?>
                                            <iframe width="100%" height="100%" src="https://docs.google.com/gview?url=<?php echo base_url() . 'upload/' . $Image; ?>&embedded=true" style="border:2px solid #ddd"></iframe>
                                        <? } else { ?>
                                            <img data-cat='photo<?= $num + 1 ?>' src="<?php echo base_url() . 'upload/' . $Image ?>" style="width:100%;height:100%;border-radius: 25px">
                                        <?php } ?>
                                    </a>
                    <?php }
                            }
                        }
                    } ?>
                </div>
                <?php ?>
            </div>
        <? } else { ?>

            <!-- <div style="width: 85%;margin: auto;">
            <div class="carousel main">
                
            </div>
            <?php ?>
        </div> -->

            <div class="full-carousel">
                <?php foreach ($banner as $num => $item) {
                    $ImagePath = $item->ImagePath;
                    $img_description = explode(",", $item->img_description);
                    $title =  $item->Title;
                    if ($item->ImagePath) {
                        $ImagePath = explode(",", $item->ImagePath);
                        foreach ($ImagePath as $key => $Image) {
                            $ext = pathinfo($Image, PATHINFO_EXTENSION);
                            if ($Image) {
                ?>
                                <a href="#" class="full-carousel-item">
                                    <?php if ($ext == MP4 || $ext == mp4) { ?>
                                        <video width="100%" height="100%" controls>
                                            <source src="<?php echo base_url() . 'upload/' . $Image; ?>" type="video/<?= $ext; ?>">
                                        </video>
                                    <?php } elseif ($ext == 'pdf' || $ext == 'txt') { ?>
                                        <iframe width="100%" height="100%" src="https://docs.google.com/gview?url=<?php echo base_url() . 'upload/' . $Image; ?>&embedded=true" style="border:2px solid #ddd"></iframe>
                                    <? } else { ?>
                                        <div class="slide-image" title="<?php $img_description ?>" style="background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), url('<?php echo base_url() . 'upload/' . $Image ?>');object-fit: cover">
                                            <div class="carouselContent">
                                                <h2 class="carouselContentTitle"><?php echo $title; ?></h2>
                                                <?php if ($Content) { ?>
                                                    <p><?php echo $Content ?></p>
                                                <?php } ?>
                                                <!-- <span>More</span> -->
                                            </div>
                                        </div>

                                    <?php } ?>
                                </a>
                <?php }
                        }
                    }
                } ?>

                <button class="next-button">
                    < </button>
                        <button class="prev-button"> > </button>
            </div>

    <?php }
}  ?>
    <?php $get_sub_main = $this->db->query("SELECT * FROM `cms_main_sub_new` WHERE IsSystem=1")->result(); ?>
    <div class="content">

        <div>
            <p class="maintitle" style="<? if ($settingQuery['ApiDbname'] == 'SchoolAccRowadAlgamaa') {
                                            echo 'font-size: 20px;margin-top: 5%;';
                                        } else {
                                            echo 'font-size: 30px;margin-bottom: 5%;margin-top: 5%;padding: 15px;';
                                        } ?>">
                <?php echo lang('Schools_seek'); ?> </p>
            <?php if (!empty($get_message)) { ?>
                <div class="school-goals">
                    <div class="card">
                        <?php $Content = filter_var($get_message[0]->Content, FILTER_SANITIZE_STRING); ?>
                        <?php
                        if ($this->session->userdata('language') == 'english') {
                            $strlen  = '150';
                            $strlen2 = '400';
                        } else {
                            $strlen  = '130';
                            $strlen2 = '400';
                        }
                        ?>
                        <img src="<?php echo base_url() . 'upload/' . explode(',', $get_message[0]->ImagePath)[0]; ?>" width="100" height="100" style="border-radius: unset;" />
                        <h2> <?php echo $get_message[0]->Title; ?></h2>
                        <p> <?= mb_substr($Content, 0, $strlen);
                            if (mb_strlen($Content) > $strlen) {
                                echo " ......";
                            } ?></p>
                        <?php if (mb_strlen($Content) > $strlen) { ?>
                            <a href="<?php echo site_url('home_new/home/get_details/' . $school_id . "/" . "154" . "/" . $get_message[0]->ID); ?>" target="_blank" class="readmore"><?php echo lang('am_more'); ?></a>
                        <?php } ?>
                    </div>
                    <div class="card">
                        <?php $ContentObjectives = filter_var($get_objectives[0]->Content, FILTER_SANITIZE_STRING) ?>
                        <img src="<?php echo base_url() . 'upload/' . explode(',', $get_objectives[0]->ImagePath)[0]; ?>" width="100" height="100" />
                        <h2><?php echo $get_objectives[0]->Title ?></h2>
                        <p> <?= mb_substr($ContentObjectives, 0, $strlen2);
                            if (mb_strlen($ContentObjectives) > $strlen2) {
                                echo " ......";
                            } ?>
                        </p>
                        <?php if (mb_strlen($ContentObjectives) > $strlen2) { ?>
                            <a href="<?php echo site_url('home_new/home/get_details/' . $school_id . "/" . "157" . "/" . $get_objectives[0]->ID); ?>" target="_blank" class="readmore"><?php echo lang('am_more'); ?></a>
                        <?php } ?>
                    </div>
                    <div class="card">
                        <?php $ContentVision = filter_var($get_vision[0]->Content, FILTER_SANITIZE_STRING) ?>
                        <img src="<?php echo base_url() . 'upload/' . explode(',', $get_vision[0]->ImagePath)[0]; ?>" width="100" height="100" />
                        <h2><?php echo $get_vision[0]->Title ?></h2>
                        <p> <?= mb_substr($ContentVision, 0, $strlen);
                            if (mb_strlen($ContentVision) > $strlen) {
                                echo " ......";
                            }; ?>
                        </p>
                        <?php if (mb_strlen($ContentVision) > $strlen) { ?>
                            <a href="<?php echo site_url('home_new/home/get_details/' . $school_id . "/" . "151" . "/" . $get_vision[0]->ID); ?>" target="_blank" class="readmore"><?php echo lang('am_more'); ?></a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
            <div class="clear"></div>
        </div>

        <?php if (!empty($get_album)) { ?>
            <div class="photoDiv">
                <div class="textDiv">
                    <h1><a target="_blank" style="color: inherit;" href="<?php echo site_url('home_new/home/get_all_album') ?>">
                            <?php echo lang('am_cms_album');
                            echo " " ?><span><?php echo lang('am_all_images'); ?></span></a></h1>
                    <p> <?php echo lang('am_album_notes'); ?> </p>
                    <div class="cardContent" style="height: 100%;">
                        <?php if ($get_album[0]->ImagePath) { ?>
                            <img src="<?php echo base_url() . 'upload/' . explode(',', $get_album[0]->ImagePath)[0]; ?>" title="<?php echo $get_album[0]->img_description; ?>">
                        <?php } else { ?>
                            <img src="<?php echo base_url() ?>images/new_home/5/5.png">
                        <?php } ?>
                        <b><a href="<?php echo site_url('home_new/home/get_album_details/' . $school_id . "/" . $get_album[0]->cms_main_sub_ID); ?>" target="_blank" class="text-color background-color-hover"><?php echo $get_album[0]->cms_main_sub_Name; ?></a></b>
                    </div>
                </div>
                <?php if ($get_album[1]->ID) { ?>
                    <div class="secendDiv">
                        <div class="images" style="margin-bottom: 10px">
                            <img src="<?php echo base_url(); ?>images/new_home/13/Ellipse 127.png" width="90" height="90" style="margin-top: 10px" />
                            <img src="<?php echo base_url(); ?>images/new_home/13/Ellipse 153.png" width="90" height="90" />
                        </div>
                        <div class="cardContent">
                            <?php if ($get_album[1]->ImagePath) { ?>
                                <img src="<?php echo base_url() . 'upload/' . explode(',', $get_album[1]->ImagePath)[0]; ?>" title="<?php echo $get_album[0]->img_description; ?>">
                            <?php } else { ?>
                                <img src="<?php echo base_url() ?>images/new_home/5/5.png">
                            <?php } ?>
                            <b><a href="<?php echo site_url('home_new/home/get_album_details/' . $school_id . "/" . $get_album[1]->cms_main_sub_ID); ?>" target="_blank" class="text-color background-color-hover"><?php echo $get_album[1]->cms_main_sub_Name; ?></a></b>
                        </div>
                        <div class="images">
                            <img src="<?php echo base_url(); ?>images/new_home/13/Ellipse 159.png" width="45" height="45" />
                            <img src="<?php echo base_url(); ?>images/new_home/13/Ellipse 159.png" width="45" height="45" />
                        </div>
                    </div>

                <?php }
                if ($get_album[2]->ID) { ?>
                    <div class="thirdDiv">
                        <div class="cardContent" style="height: 55%">
                            <?php if ($get_album[2]->ImagePath) { ?>
                                <img src="<?php echo base_url() . 'upload/' . explode(',', $get_album[2]->ImagePath)[0]; ?>" title="<?php echo $get_album[0]->img_description; ?>">
                            <?php } else { ?>
                                <img src="<?php echo base_url() ?>images/new_home/5/5.png">
                            <?php } ?>
                            <b><a href="<?php echo site_url('home_new/home/get_album_details/' . $school_id . "/" . $get_album[2]->cms_main_sub_ID); ?>" target="_blank" class="text-color background-color-hover"><?php echo $get_album[2]->cms_main_sub_Name; ?></a></b>
                        </div>
                        <div class="images">
                            <img src="<?php echo base_url(); ?>images/new_home/13/Ellipse 130.png" width="80" height="80" />
                            <img src="<?php echo base_url(); ?>images/new_home/13/Ellipse 130.png" width="60" height="60" style="margin-top: 10px" />
                        </div>
                        <?php if ($get_album[3]->ID) { ?>
                            <div class="cardContent" style="height: 33%;">
                                <?php if ($get_album[3]->ImagePath) { ?>
                                    <img src="<?php echo base_url() . 'upload/' . explode(',', $get_album[3]->ImagePath)[0]; ?>" title="<?php echo $get_album[0]->img_description; ?>">
                                <?php } else { ?>
                                    <img src="<?php echo base_url() ?>images/new_home/5/5.png">
                                <?php } ?>
                                <b><a href="<?php echo site_url('home_new/home/get_album_details/' . $school_id . "/" . $get_album[3]->cms_main_sub_ID); ?>" target="_blank" class="text-color background-color-hover"><?php echo $get_album[3]->cms_main_sub_Name; ?></a></b>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if ($get_album[4]->ID) { ?>
                    <div class="forthDiv">
                        <div class="cardContent" style="margin-bottom: 20px">
                            <?php if ($get_album[4]->ImagePath) { ?>
                                <img src="<?php echo base_url() . 'upload/' . explode(',', $get_album[4]->ImagePath)[0]; ?>" title="<?php echo $get_album[0]->img_description; ?>">
                            <?php } else { ?>
                                <img src="<?php echo base_url() ?>images/new_home/5/5.png">
                            <?php } ?>
                            <b><a href="<?php echo site_url('home_new/home/get_album_details/' . $school_id . "/" . $get_album[4]->cms_main_sub_ID); ?>" target="_blank" class="text-color background-color-hover"><?php echo $get_album[4]->cms_main_sub_Name; ?></a></b>
                        </div>
                        <?php if ($get_album[5]->ID) { ?>
                            <div class="cardContent" style="height: 100%;">
                                <?php if ($get_album[5]->ImagePath) { ?>
                                    <img src="<?php echo base_url() . 'upload/' . explode(',', $get_album[5]->ImagePath)[0]; ?>" title="<?php echo $get_album[0]->img_description; ?>">
                                <?php } else { ?>
                                    <img src="<?php echo base_url() ?>images/new_home/5/5.png">
                                <?php } ?>
                                <b><a href="<?php echo site_url('home_new/home/get_album_details/' . $school_id . "/" . $get_album[5]->cms_main_sub_ID); ?>" target="_blank" class="text-color background-color-hover"><?php echo $get_album[5]->cms_main_sub_Name; ?></a></b>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
        <?php if (!empty($carrying_capacity)) { ?>
            <div class="indications">
                <div class="rightDiv">
                    <div class="indication_card">
                        <h1><?php echo lang('Indications'); ?></h1>
                    </div>
                    <div class="indication_card">
                        <img src="<?php echo base_url(); ?>assets/upload_home/Group 354.svg" class="ficon" />
                        <span><b id="visitor_all" class="count">loading..</b><span class="indication_card_text"><?php echo lang('visitor_all'); ?> </span></span>
                        <img src="<?php echo base_url(); ?>assets/upload_home/Group 354.svg" class="sicon" />
                    </div>
                    <div class="indication_card">
                        <img src="<?php echo base_url(); ?>assets/upload_home/Group 406.svg" class="ficon" />
                        <span><b id="visitor_day" class="count">loading..</b><span class="indication_card_text"><?php echo lang('visitor_day'); ?></span></span>
                        <img src="<?php echo base_url(); ?>assets/upload_home/Group 406.svg" class="sicon" />
                    </div>
                </div>
                <div class="leftDiv">
                    <div class="indication_card">
                        <img src="<?php echo base_url(); ?>assets/upload_home/Group 408.svg" class="ficon" />
                        <span><b class="count"><?php echo filter_var($carrying_capacity[0]->Content, FILTER_SANITIZE_STRING); ?></b></span>
                        <span class="indication_card_text"><?php echo filter_var($carrying_capacity[0]->Title, FILTER_SANITIZE_STRING); ?></span>
                        <img src="<?php echo base_url(); ?>assets/upload_home/Group 408.svg" class="sicon" />
                    </div>
                    <div class="indication_card" style="margin-right: 15%;margin-top: -10px">
                        <img src="<?php echo base_url(); ?>assets/upload_home/Group 407.svg" class="ficon" />
                        <span><b class="count"><?php echo filter_var($years_experience[0]->Content, FILTER_SANITIZE_STRING); ?></b></span>
                        <span class="indication_card_text"><?php echo filter_var($years_experience[0]->Title, FILTER_SANITIZE_STRING); ?>
                        </span></span>
                        <img src="<?php echo base_url(); ?>assets/upload_home/Group 407.svg" class="sicon" />
                    </div>
                    <div class="indication_card" style="margin-top: -10px">
                        <img src="<?php echo base_url(); ?>assets/upload_home/Group 409.svg" class="ficon" />
                        <span><b class="count"><?php echo filter_var($school_space[0]->Content, FILTER_SANITIZE_STRING); ?></b></span>
                        <span class="indication_card_text"><?php echo filter_var($school_space[0]->Title, FILTER_SANITIZE_STRING); ?></span></span>
                        <img src="<?php echo base_url(); ?>assets/upload_home/Group 409.svg" class="sicon" />
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if (!empty($get_advertisment)) { ?>
            <h1 class="adisHeader"><?php echo lang('am_billBoard');
                                    echo " "; ?><span><?php echo lang('am_billBoard_22') ?></span>
            </h1>
            <div class="adsi">

                <div class="owl-carousel owl-theme adCar" style=" width: 95%;">
                    <?php foreach ($get_advertisment as $item) {

                        $ID              = $item->ID;
                        $ImagePath = explode(",", $item->ImagePath);
                        $img_description = explode(",", $item->img_description);
                        array_pop($ImagePath);
                        foreach ($ImagePath as $key => $Image)
                            $Title           = $item->Title;
                        $Content         = filter_var($item->Content, FILTER_SANITIZE_STRING);
                        $Date            = $item->Date;


                    ?>
                        <div class="item">
                            <div class="ad">
                                <div style='height:auto'>
                                    <a href="<?php echo site_url('home_new/home/get_details/' . $school_id . "/" . "115" . "/" . $ID); ?>"><img src="<?php echo base_url() . 'upload/' . $Image ?>" height="100%" title="<?php echo $img_description[$key]; ?>"></a>
                                </div>
                                <div class="adi-content">
                                    <div class="adDate">
                                        <span><i class="fa fa-calendar"></i> <?php echo date("M-D-y  h:i:s", strtotime($Date)); ?>
                                        </span>
                                    </div>
                                    <a href="<?php echo site_url('home_new/home/get_details/' . $school_id . "/" . "115" . "/" . $ID); ?>" class="newLink" style="text-align: start!important;border-bottom: none" dir="auto"><?php echo $Title ?></a>
                                    <p><?= mb_substr($Content, 0, 100, 'utf-8');
                                        if (strlen($Content) > 100) {
                                            echo "......";
                                        } ?></p>
                                    <?php if (strlen($Content) > 100) { ?>
                                        <div class="btnCon"><a href="<?php echo site_url('home_new/home/get_details/' . $school_id . "/" . "115" . "/" . $ID); ?>" target="_blank" class="adBtn"><i class="adBtn"></i>..<?php echo lang('am_more'); ?></a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <br>
        <?php if (!empty($get_Youtube)) { ?>
            <div class="youtubechannel">
                <div class="upDiv">
                    <div class="textChannel" style="position: relative">
                        <img class="ball-img" src="<?php echo base_url(); ?>images/new_home/13/Ellipse 153.png" width="40" height="40" style="position: absolute;left: -60px;top:25px" />
                        <h2><?php echo lang('Videos'); ?> <span><?php echo lang('school_Videos'); ?></span>
                            <!--<php echo lang('school');?> -->
                        </h2>

                        <p><?php echo lang('youtube_info'); ?></p>
                        <img class="ball-img" src="<?php echo base_url(); ?>images/new_home/13/Ellipse 127.png" width="60" height="60" style="position: absolute;right: 240px;bottom:40px" />
                        <img class="ball-img" src="<?php echo base_url(); ?>images/new_home/13/Ellipse 127.png" width="60" height="60" style="position: absolute;right: 80px;bottom:10px" />
                    </div>
                    <div class="imgChannel">
                        <?php if ($get_Youtube[0]->YoutubeScript) { ?>
                            <?php
                            if (strpos($get_Youtube[0]->YoutubeScript, 'https://www.youtube.com/watch?v=') !== false) {
                                $yotube_space = strstr($get_Youtube[0]->YoutubeScript, "&");
                                $del_space  = str_replace($yotube_space, '', $get_Youtube[0]->YoutubeScript);
                                $get_Youtube_embed = str_replace('https://www.youtube.com/watch?v=', 'https://www.youtube.com/embed/', $del_space);
                            } elseif (strpos($get_Youtube[0]->YoutubeScript, 'https://youtu.be/') !== false) {
                                $get_Youtube_embed = str_replace('https://youtu.be/', 'https://www.youtube.com/embed/', $get_Youtube[0]->YoutubeScript);
                            } else {
                                $get_Youtube_embed = $get_Youtube[0]->YoutubeScript;
                            }

                            ?>
                            <iframe style="border: none;border-radius: 15px" height="100%" id="mainFrame" width="100%" src="<?php echo $get_Youtube_embed; ?>" frameborder="0" allowfullscreen="true"></iframe>
                            <video style="border: none;border-radius: 15px;display:none" height="100%" width="100%" src="<?php echo base_url() . 'upload/' . explode(",", $get_Youtube[0]->ImagePath)[0] ?>" type="video/mp4" id="mainVideo" controls>
                            </video>
                        <?php } else {  ?>
                            <video style="border: none;border-radius: 15px" height="100%" width="100%" src="<?php echo base_url() . 'upload/' . explode(",", $get_Youtube[0]->ImagePath)[0] ?>" type="video/mp4" id="mainVideo" controls>
                            </video>
                            <iframe style="border: none;border-radius: 15px;display:none" height="100%" width="100%" id="mainFrame" src="" frameborder="0" allowfullscreen="true"></iframe>
                        <?php } ?>
                    </div>
                </div>
                <div class="owl-carousel owl-theme videos" style=" width: 85%;margin:0% 7% 3% 0%;">
                    <?php
                    if ($get_Youtube != 0) {
                        foreach ($get_Youtube as $item) {
                            $Name               = $item->SubName;
                            $ID                 = $item->ID;
                            $Youtube            = $item->YoutubeScript;
                            $ImagePath = explode(",", $item->ImagePath);
                            array_pop($ImagePath);

                            if (strpos($Youtube, 'https://www.youtube.com/watch?v=') !== false) {
                                $yotube_space = strstr($Youtube, "&");
                                $del_space  = str_replace($yotube_space, '', $Youtube);
                                $YoutubeScript = str_replace('https://www.youtube.com/watch?v=', 'https://www.youtube.com/embed/', $del_space);
                            } elseif (strpos($Youtube, 'https://youtu.be/') !== false) {
                                $YoutubeScript = str_replace('https://youtu.be/', 'https://www.youtube.com/embed/', $Youtube);
                            } else {
                                $YoutubeScript = $Youtube;
                            }
                    ?>
                            <?php if ($YoutubeScript) { ?>
                                <div class="item">
                                    <div style="position:relative">
                                        <div class="iframeCons" style="position: absolute;top: 0;width: 100%;height: 100%;left: 0;"></div>
                                        <iframe height="105px" width="100%" src="<?php echo $YoutubeScript; ?>" style="border-radius: 10px;border:0" allowfullscreen="true"></iframe>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <?php foreach ($ImagePath as $key => $Image) { ?>
                                    <div class="item">
                                        <video src="<?php echo base_url() . 'upload/' . $Image; ?>" type="video/mp4" height="105px" width="100%" style="border-radius: 10px;border:0">
                                        </video>
                                    </div>
                    <?php }
                            }
                        }
                    } ?>
                </div>

            </div>
        <?php } ?>
        <?php if (!empty($latest_news)) { ?>
            <h1 class="newHead"><?php echo lang('am_last'); ?><span style="color: var(--main-color);"><?php echo lang('am_news'); ?></span> </h1>
            <div class="adsi news">

                <div class="owl-carousel owl-theme adCar" style=" width: 95%;">
                    <?php foreach ($latest_news as $new) {

                        $ID              = $new->ID;
                        $ImagePath = explode(",", $new->ImagePath);
                        $img_description = explode(",", $item->img_description);
                        array_pop($ImagePath);
                        foreach ($ImagePath as $key => $Image)
                            $Title           = $new->Title;
                        $Content         = filter_var($new->Content, FILTER_SANITIZE_STRING);
                        $Date            = $new->Date;
                    ?>
                        <div class="item">
                            <div class="ad">
                                <div style='height:auto'>
                                    <a href="<?php echo site_url('home_new/home/get_details/' . $school_id . "/" . "145" . "/" . $ID); ?>">
                                        <img src="<?php echo base_url() . 'upload/' . $Image ?>" height="100%" title="<?php echo $img_description[$key]; ?>">
                                    </a>
                                </div>
                                <div class="adi-content">
                                    <a href="<?php echo site_url('home_new/home/get_details/' . $school_id . "/" . "145" . "/" . $ID); ?>" style="text-align: start!important;margin:0 0 10px" dir="auto" class="newsLink"><?php echo $Title ?></a>

                                    <p><?= mb_substr($Content, 0, 100, 'utf-8');
                                        if (strlen($Content) > 100) {
                                            echo "......";
                                        } ?></p>
                                    <?php if (strlen($Content) > 100) { ?>
                                        <div class="btnCon"><a href="<?php echo site_url('home_new/home/get_details/' . $school_id . "/" . "145" . "/" . $ID); ?>" target="_blank" class="adBtn"><i class="adBtn"></i>..<?php echo lang('am_more'); ?></a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                    <?php } ?>
                </div>
            </div>

        <?php } ?>
        <?php if (!empty($school_activities)) { ?>
            <div class="activities" style="margin-top: 5%;">
                <div class="rightAct">
                    <div class="rightup">
                        <div class="text">
                            <h1><a target="_blank" style="color: inherit;" href="<?php echo site_url('home_new/home/get_details_new/' . $school_id . "/" . "106"); ?>"><?php echo lang('am_Activities_school') ?><span><?php echo lang('am_schools') ?></span></a>
                            </h1>
                            <p><?php echo lang('am_Activities_notes'); ?></p>
                        </div>

                        <div class="img">
                            <?php if ($school_activities[0]->ImagePath) {
                                $ext = pathinfo(explode(',', $school_activities[0]->ImagePath)[0], PATHINFO_EXTENSION);
                                if ($school_activities[0]->ImagePath) {
                                    if ($ext == MP4 || $ext == mp4) { ?>
                                        <video width="100%" height="100%" controls>
                                            <source src="<?php echo base_url() . 'upload/' . explode(',', $school_activities[0]->ImagePath)[0]; ?>" type="video/<?= $ext; ?>">
                                        </video>
                                    <?php } elseif ($ext == 'xlsx' || $ext == 'xls' || $ext == 'pdf' || $ext == 'txt') { ?>
                                        <a href="<?php echo base_url() . 'upload/' . explode(',', $school_activities[0]->ImagePath)[0]; ?>" name="Band ring" title="Delete">
                                        <?php } else { ?>
                                            <img src="<?php echo base_url() . 'upload/' . explode(',', $school_activities[0]->ImagePath)[0]; ?>" width="100%" height="100%" title="<?php echo $school_activities[0]->img_description; ?>" />
                                <?php }
                                }
                            } ?>
                        </div>
                    </div>
                    <div class="rightDown">
                        <?php if ($school_activities[1]->ImagePath) {
                            $ext = pathinfo(explode(',', $school_activities[1]->ImagePath)[0], PATHINFO_EXTENSION);
                            if ($school_activities[1]->ImagePath) {
                                if ($ext == MP4 || $ext == mp4) { ?>
                                    <video width="100%" height="100%" controls>
                                        <source src="<?php echo base_url() . 'upload/' . explode(',', $school_activities[1]->ImagePath)[0]; ?>" type="video/<?= $ext; ?>">
                                    </video>
                                <?php } else { ?>
                                    <img src="<?php echo base_url() . 'upload/' . explode(',', $school_activities[1]->ImagePath)[0]; ?>" width="100%" height="100%" title="<?php echo $school_activities[0]->img_description; ?>" />
                        <?php }
                            }
                        } ?>
                    </div>
                </div>
                <div class="leftAct">
                    <?php if ($school_activities[2]->ImagePath) {
                        $ext = pathinfo(explode(',', $school_activities[2]->ImagePath)[0], PATHINFO_EXTENSION);
                        if ($school_activities[2]->ImagePath) {
                            if ($ext == MP4 || $ext == mp4) { ?>
                                <video width="100%" height="100%" controls>
                                    <source src="<?php echo base_url() . 'upload/' . explode(',', $school_activities[2]->ImagePath)[0]; ?>" type="video/<?= $ext; ?>">
                                </video>
                            <?php } else { ?>
                                <img src="<?php echo base_url() . 'upload/' . explode(',', $school_activities[2]->ImagePath)[0]; ?>" width="100%" height="100%" />
                    <?php }
                        }
                    } ?>
                </div>
            </div>
        <?php } ?>
        <?php if (!empty($honor_board_emp) || !empty($honor_board_stu)) { ?>
            <h1 class="honoraryHead"><?php echo lang('am_Honour_bill'); ?><span><?php echo lang('am_Honour'); ?></span></h1>
            <div class="carousel2" data-carousel>
                <div class="honorary-board">
                    <?php if (!empty($honor_board_emp)) { ?>
                        <div class="teachers">
                            <h2><a target="_blank" style="color: inherit;" href="<?php echo site_url('home_new/home/get_details_new/' . $school_id . "/" . "124"); ?>"><?php echo lang('am_teacher'); ?></a>
                            </h2>
                            <?php if ($honor_board_emp[0]) { ?>
                                <div class="one">
                                    <img class="ball-img" src="<?php echo base_url(); ?>images/new_home/13/Ellipse 153.png" width="55" height="55" style="position: absolute;left: 250px;top:80px" />
                                    <?php foreach (explode(',', substr_replace($honor_board_emp[0]->ImagePath, "", -1)) as $key => $image) { ?>
                                        <div class="pomySlides fade">
                                            <img src="<?php echo base_url() . 'upload/' . $image ?>" width="180" height="180" title="<?php echo $honor_board_emp[0]->img_description; ?>">
                                            <b><?php echo $honor_board_emp[0]->Title; ?> </b>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            <div class="insideClass">
                                <?php if ($honor_board_emp[1]) { ?>
                                    <div class="two">
                                        <?php foreach (explode(',', substr_replace($honor_board_emp[1]->ImagePath, "", -1)) as $key => $image) { ?>
                                            <div class="ptmySlides fade">
                                                <img src="<?php echo base_url() . 'upload/' . $image; ?>" width="120" height="120">
                                                <b><?php echo $honor_board_emp[1]->Title; ?> </b>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>

                                <?php if ($honor_board_emp[2]) { ?>
                                    <div class="three" style="margin-top: -100px;margin-left: 100px">
                                        <img class="ball-img" src="<?php echo base_url(); ?>images/new_home/13/Ellipse 153.png" width="45" height="45" style="position: absolute;left: 260px;bottom:10px" />
                                        <?php foreach (explode(',', substr_replace($honor_board_emp[2]->ImagePath, "", -1)) as $key => $image) { ?>
                                            <div class="pthmySlides fade">
                                                <img src="<?php echo base_url() . 'upload/' .  $image ?>" width="150" height="150" title="<?php echo $honor_board_emp[0]->img_description; ?>">
                                                <b><?php echo $honor_board_emp[2]->Title; ?> </b>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (!empty($honor_board_emp) && !empty($honor_board_stu)) { ?>
                        <div class="images">
                            <img class="ball-img" src="<?php echo base_url(); ?>images/new_home/13/Ellipse 153.png" width="80" height="80" style="margin-left: 15px" />
                            <img class="ball-img" src="<?php echo base_url(); ?>images/new_home/13/Ellipse 127.png" width="95" height="95" />
                        </div>
                    <?php } ?>
                    <?php if (!empty($honor_board_stu)) { ?>
                        <div class="students">
                            <h2><a target="_blank" style="color: inherit;" href="<?php echo site_url('home_new/home/get_details_new/' . $school_id . "/" . "125"); ?>"><?php echo lang('am_students'); ?></a>
                            </h2>
                            <div class="one">
                                <img class="ball-img" src="<?php echo base_url(); ?>images/new_home/13/Ellipse 127.png" width="60" height="60" style="position: absolute;right: 250px;top: 80px" />
                                <?php ?>
                                <?php foreach (explode(',', substr_replace($honor_board_stu[0]->ImagePath, "", -1)) as $key => $image) { ?>
                                    <div class="fmySlides fade">
                                        <img src="<?php echo base_url() . 'upload/' . $image; ?>" width="180" height="180" title="<?php echo $honor_board_stu[0]->img_description; ?>">
                                        <div class="text"><b><?php echo $honor_board_stu[0]->Title; ?> </b></div>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php if ($honor_board_stu[1]) { ?>
                                <div class="insideClass">
                                    <div class="two" style="margin-top: -100px;margin-right: 150px;">
                                        <?php foreach (explode(',', substr_replace($honor_board_stu[1]->ImagePath, "", -1)) as $key => $image) {  ?>
                                            <div class="tmySlides fade">
                                                <img src="<?php echo base_url() . 'upload/' .  $image; ?>" width="150" height="150" title="<?php echo $honor_board_stu[0]->img_description; ?>">
                                                <b><?php echo $honor_board_stu[1]->Title; ?> </b>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <?php if ($honor_board_stu[2]) { ?>
                                        <div class="three" style="margin-right: 30px;">
                                            <?php foreach (explode(',', substr_replace($honor_board_stu[2]->ImagePath, "", -1)) as $key => $image) {  ?>
                                                <div class="thmySlides fade">
                                                    <img src="<?php echo base_url() . 'upload/' .  $image ?>" width="120" height="120" title="<?php echo $honor_board_stu[0]->img_description; ?>">
                                                    <b><?php echo $honor_board_stu[2]->Title; ?> </b>
                                                </div>
                                            <?php } ?>
                                            <img class="ball-img" src="<?php echo base_url(); ?>images/new_home/13/Ellipse 127.png" width="50" height="50" style="position: absolute;right: 260px;bottom:0" />
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        <?php } ?>
                        </div>
                </div>
            </div>
        <?php } ?>


        <?php if (!empty($school_tour)) { ?>
            <h1 class="adisHeader"><?php echo lang('am_tour'); ?><span><?php echo lang('am_in_school'); ?></span></h1>
            <div class="virsual-tour" <? if ($settingQuery['ApiDbname'] == 'SchoolAccRowadAlgamaa') { ?>style="border-radius: 205px" <? } ?>>
                <div class="carousel" <? if ($settingQuery['ApiDbname'] == 'SchoolAccRowadAlgamaa') { ?>style="border-radius: 205px" <? } ?>>
                    <?php
                    if ($school_tour != 0) {
                        foreach ($school_tour as $key => $item) {
                            $Title              = $item->Title;
                            $img_description = explode(",", $item->img_description);
                            $Content         = filter_var($item->Content, FILTER_SANITIZE_STRING);
                            $ImagePath       = $item->ImagePath;
                            $ext                = pathinfo($ImagePath, PATHINFO_EXTENSION);
                            $ImagePath = explode(",", $item->ImagePath);
                            foreach ($ImagePath as $key => $Image) {
                                if ($Image) {
                    ?>
                                    <a href="#<?= $Image ?>" class="carousel-item"><img src="<?php echo base_url() . 'upload/' . $Image; ?>" style="width:100%;height:100%;border-radius: 50%" title="<?php echo $img_description[$key]; ?>"></a>
                    <?php }
                            }
                        }
                    } ?>
                </div>
            </div>
        <?php } ?>
    </div>
    <section class="pattern"></section>
        </div>