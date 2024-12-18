<?php $this->load->model(array('home_new/home_model')); 
$get_school_setting     = $this->home_model->get_school_setting();
?>
<?php $query=$this->db->query("SELECT * FROM `setting` WHERE 1")->row_array();?>

<?php
global $x;
$x=$query['home_color'];

?>
<style>
    .mapouter iframe{
        width: 90%;
        border: 0;
        height: 314px;
        margin-bottom: 50px;
    }
</style>

<div class="footerContent" style="">
        <div class="col4">
            <img src="<?php echo base_url();?>intro/images/school_logo/<?php echo $get_school[0]->Logo;?>" width="120px"/>
            <div class="social-links">
                <ul style="padding:0;margin:5px 0">
                <?php if($get_school_setting['facebooklink']){ ?>
                <a target="_blank" href="<?php  echo $get_school_setting['facebooklink'];?>"><i class="fa fa-facebook"></i></a>
                <?php } if($get_school_setting['twitterlink']){ ?>
                <a target="_blank" href="<?php  echo $get_school_setting['twitterlink'];?>"><i class="fa fa-twitter"></i></a>
                <?php } if($get_school_setting['youtube']){ ?>
                <a target="_blank" href="<?php  echo $get_school_setting['youtube'];?>"><i class="fa fa-youtube"></i></a>
                <?php } if($get_school_setting['instagramLink']){ ?>
                <a target="_blank" href="<?php  echo $get_school_setting['instagramLink'];?>"><i class="fa fa-instagram"></i></a>
                <?php } if($get_school_setting['google-plus']){ ?>
                <a target="_blank" href="<?php  echo $get_school_setting['google-plus'];?>"><i class="fa fa-google-plus"></i></a>
                <?php } if($get_school_setting['tiktok']){ ?>
                <a target="_blank" href="<?php  echo $get_school_setting['tiktok'];?>"><i class="fa-brands fa-tiktok"></i></a>
                <?php } if($get_school_setting['web_page']){ ?>
                <a target="_blank" href="<?php  echo $get_school_setting['web_page'];?>"><i class="fa fa-globe"></i></a> 
                <?php } if($get_school_setting['snapchat']){  
                   $LinkArray = $get_school_setting['snapchat'];
                   $Links = explode ('||' , $LinkArray );
                   $url = $Links[0];
                   $Link = explode (',' ,$url); 
                   $Name = $Links[1];
                   $LinkName = explode (',' ,$Name);
                   
                   if($Link[1]){
                   ?>
                <ul class="navbar-links hiddens" style="display: inline-block;list-style: none;padding: 0;">
                    <li class="nav-link" style="position:relative;width: 50px">
                        <a target="_blank" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-snapchat-ghost"></i></a>
                        <ul class="droplistLinks langAndLog">
                            <?php foreach($Link as $key=>$val){?>
                            <div>
                                <li style="width: max-content;">
                                    <a href="<?php echo $val ?>" target="_blank"><?php echo $LinkName[$key] ?></a>
                                </li>
                            </div>
                            <?php } ?>
                        </ul>
                    </li>
                </ul>
                <?php }else{?>
                <a href="<?php echo $url?>" target="_blank"><i class="fa fa-snapchat-ghost"></i></a>
                <?php }} ?>
            </ul>
            </div>
        </div>
        <div class="col4">
            <?php  if($this->session->userdata('language') != 'english'){$Title = 'Title';$content = 'Content'; }else{$Title =  'Title_en';$content = 'Content_en'; } ?>
            <?php $query=$this->db->query("SELECT $Title AS Title, $content AS Content FROM `cms_details` WHERE `MainSubID` = 130")->result();?>
            <h5> <?php echo $query[0]->Title; ?>   </h5>
            <p><?= filter_var($query[0]->Content, FILTER_SANITIZE_STRING); ?> </p>
        </div>
        <div class="col4">
            <h5>تواصل معنا</h5>
            <div class="conCont">
                <i class="fa fa-map-marker " ></i>
                <div class="addContent">
                    <?php $Adress =str_replace(",",' - ',$get_school_setting['Adress']);?>
                    <h6><span><?php echo lang('am_title');?></span>&nbsp;<span><?php echo $Adress ?></span></h6>
                </div>
            </div>
            <div class="conCont">
                <i class="fa fa-envelope 2x" style="font-size:18px"></i>
                <div class="addContent"> 
                    <?php $Email =str_replace(",",' - ',$get_school_setting['Email']);?>
                    <h6><span><?php echo lang('am_mail');?></span>&nbsp;<span><?php echo $Email; ?></span></h6>

                </div>
            </div>
            <div class="conCont">
                <i class="fa fa-phone " ></i>
                <div class="addContent">
                    <h6><span><?php echo lang('Phone_Number');?></span>&nbsp;<span><?php echo $get_school_setting['Mobile']; ?></span></h6>
                </div>
            </div>
            <div class="conCont">
                <i class="fa fa-whatsapp " ></i>
                <div class="addContent">
                    <h6><span><?php echo lang('whatsup_phone');?></span>&nbsp;<span><?php echo $get_school_setting['whatsapp_number']; ?></span></h6>
                </div>
            </div>
            
        </div>
</div>    
    
    <footer style="margin-bottom: 0;background:#203147;width:100%">
        <p style="text-align: center !important;color:#fff"><?php echo lang('br_All_rights_reserved_to');?><a href="https://esolwp.esol.com.sa/" style="text-decoration:none;color:#aaa"><?php echo lang('br_expert_solution');?></a></p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/new_home.js"></script>
    <script>
        $(document).ready(function(){
            $('.carousel').carousel({
                numVisible:3,
            });
            setInterval(function () {
                $('.carousel').carousel('prev');
            }, 4500);
            $('.next').click(function() {
                $('.carousel.tour').carousel('next');
            });
            $('.prev').click(function() {
                $('.carousel.tour').carousel('prev');
            });
          });
          
          
    </script>
    <script>
        let slideIndex = 0;
        showSlides();
        
        function showSlides() {
          let i;
          let slides = document.getElementsByClassName("mySlides");
          for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
          }
          slideIndex++;
          if (slideIndex > slides.length) {slideIndex = 1}
          slides[slideIndex-1].style.display = "block";
          setTimeout(showSlides, 5000); // Change image every 2 seconds
        }
        </script>
    <script>
        let tslideIndex = 0;
        tshowSlides();
        
        function tshowSlides() {
          let i;
          let slides = document.getElementsByClassName("tmySlides");
          for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
          }
          tslideIndex++;
          if (tslideIndex > slides.length) {tslideIndex = 1}
          slides[tslideIndex-1].style.display = "block";
          setTimeout(tshowSlides, 5000); // Change image every 2 seconds
        }
        </script>
    <script>
        let thslideIndex = 0;
        thshowSlides();
        
        function thshowSlides() {
          let i;
          let slides = document.getElementsByClassName("thmySlides");
          for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
          }
          thslideIndex++;
          if (thslideIndex > slides.length) {thslideIndex = 1}
          slides[thslideIndex-1].style.display = "block";
          setTimeout(thshowSlides, 5000); // Change image every 2 seconds
        }
        </script>
    <script>
        let poslideIndex = 0;
        poshowSlides();
        
        function poshowSlides() {
          let i;
          let slides = document.getElementsByClassName("pomySlides");
          for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
          }
          poslideIndex++;
          if (poslideIndex > slides.length) {poslideIndex = 1}
          slides[poslideIndex-1].style.display = "block";
          setTimeout(poshowSlides, 5000); // Change image every 2 seconds
        }
        </script>
    <script>
        let ptslideIndex = 0;
        ptshowSlides();
        
        function ptshowSlides() {
          let i;
          let slides = document.getElementsByClassName("ptmySlides");
          for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
          }
          ptslideIndex++;
          if (ptslideIndex > slides.length) {ptslideIndex = 1}
          slides[ptslideIndex-1].style.display = "block";
          setTimeout(ptshowSlides, 5000); // Change image every 2 seconds
        }
        </script>
    <script>
        let pthslideIndex = 0;
        pthshowSlides();
        
        function pthshowSlides() {
          let i;
          let slides = document.getElementsByClassName("pthmySlides");
          for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
          }
          pthslideIndex++;
          if (pthslideIndex > slides.length) {pthslideIndex = 1}
          slides[pthslideIndex-1].style.display = "block";
          setTimeout(pthshowSlides, 5000); // Change image every 2 seconds
        }
        </script>
 <div class="clearfix"></div>


 