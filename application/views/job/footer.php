       
<?php $css_cpanel =$this->session->userdata('css_cpanel');?>
<?php $js_cpanel=$this->session->userdata('js_cpanel');?> 
    
                      <div class="clearfix"></div>
 
        </div>
           </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper --> 
<div class="clearfix"></div>
      <div class="clearfix"></div> 
  <div class="footer-page">   
   <div class="container">
       <div class="col-lg-12">
         <p class="text-center">جميع الحقوق محفوظة لشركة <a hrefs="http://esol.com.sa/">الحلول الخبيرة</a></p>
       </div><!-- col-lg-12 -->   
   </div><!-- container -->
  </div><!-- footer-page -->
    </div>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url(); ?>assets/new/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/new/js/bootstrap-dropdownhover.js"></script>
    <script src="<?php echo base_url(); ?>assets/new/js/bootstrap-select.js"></script>
    <script src="<?php echo base_url(); ?>assets/new/js/bootstrap-filestyle.js"></script>
    <script src="<?php echo base_url(); ?>assets/new/js/wow.min.js"></script>  
    <script src="<?php echo base_url(); ?>assets/new/fancybox-master/jquery.fancybox.min.js"></script>  
    
    <script src="<?php echo base_url(); ?>assets/new/js/plugins.js"></script> 
    <script src="https://harvesthq.github.io/chosen/chosen.jquery.js"></script>

    <script>

		$(document).ready(function () {
          
			  var trigger = $('.hamburger'),
				  overlay = $('.overlay'),
				 isClosed = false;

				trigger.click(function () {
				  hamburger_cross();      
				});
				 $('.overlay').click(function () {   
					 hamburger_cross();   
				 }); 
				function hamburger_cross() {

				  if (isClosed == true) {          
					overlay.hide();
					trigger.removeClass('is-open');
					trigger.addClass('is-closed');
					isClosed = false;
				  } else {   
					overlay.show();
					trigger.removeClass('is-closed');
					trigger.addClass('is-open');
					isClosed = true;
					 $('.overlay').click(function () {    
						$('.hamburger').removeClass('is-open');
						$('.hamburger').addClass('is-closed');
					 }); 
				  }
			  }

			  $('[data-toggle="offcanvas"] , .overlay').click(function () {
					$('#wrapper').toggleClass('toggled');
			  });  
			});
	  
       !function ($) {

        // Le left-menu sign
        /* for older jquery version
        $('#left ul.nav li.parent > a > span.sign').click(function () {
            $(this).find('i:first').toggleClass("icon-minus");
        }); */

        $(document).on("click","#left ul.nav li.parent > a > span.sign", function(){          
            $(this).find('i:first').toggleClass("fa-minus");      
        }); 

        // Open Le current menu
			$("#left ul.nav li.parent.active > a > span.sign").find('i:first').addClass("fa fa-minus");
			$("#left ul.nav li.current").parents('ul.children').addClass("in");
        }
        (window.jQuery);
        $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        })

/*	var stickyOffset = $('.navbar-default-bg-js').offset().top;
		$(window).scroll(function(){
		  var sticky = $('.navbar-default-bg-js'),
			  scroll = $(window).scrollTop();
		  if (scroll >= stickyOffset) sticky.addClass('change-fixed');
		  else sticky.removeClass('change-fixed');
		});*/
/*			$(function(){
			$('#div_tools').show();
			$('.emp_tools a').click(function(){
				$('#div_tools').slideToggle({});
				$(this).toggleClass('open');
				$("html, body").animate({ scrollTop: 0 }, 600);
    			return false;
			});
		});*/
    </script>  
</body>
</html>