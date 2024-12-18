<?php $css_cpanel = $this->session->userdata('css_cpanel'); ?>
    <?php $js_cpanel = $this->session->userdata('js_cpanel'); ?>

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
                <p class="text-center"><?php echo lang('ra_All rights reserved to the company'); ?> <a href="http://esol.com.sa/"><?php echo lang('ra_expert solution'); ?> </a></p>
            </div><!-- col-lg-12 -->
        </div><!-- container -->
    </div><!-- footer-page -->
    </div>

    
    <script src="<?php echo base_url(); ?>assets/new/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/new/js/bootstrap-dropdownhover.js"></script>
    <script src="<?php echo base_url(); ?>assets/new/js/bootstrap-select.js"></script>
    <script src="<?php echo base_url(); ?>assets/new/js/bootstrap-filestyle.js"></script>
    <script src="<?php echo base_url(); ?>assets/new/js/wow.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/new/fancybox-master/jquery.fancybox.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/new/js/plugins.js"></script>
   

    <script>
        $(document).ready(function() {
            var trigger = $('.hamburger'),
                overlay = $('.overlay'),
                isClosed = false;

            trigger.click(function() {
                hamburger_cross();
            });
            $('.overlay').click(function() {
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
                    $('.overlay').click(function() {
                        $('.hamburger').removeClass('is-open');
                        $('.hamburger').addClass('is-closed');
                    });
                }
            }

            $('[data-toggle="offcanvas"] , .overlay').click(function() {
                $('#wrapper').toggleClass('toggled');
            });
        });

        ! function($) {

            $(document).on("click", "#left ul.nav li.parent > a > span.sign", function() {
                $(this).find('i:first').toggleClass("fa-minus");
            });

            // Open Le current menu
            $("#left ul.nav li.parent.active > a > span.sign").find('i:first').addClass("fa fa-minus");
            $("#left ul.nav li.current").parents('ul.children').addClass("in");
        }
        (window.jQuery);
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
       
    </script>

    <script>
       
        $(document).ready(function() {
            $('.close_ds2').click(function() {
                $('#help_img').hide();
                $('.close_ds2').hide();
            });
        });

        $(function() {
            $('.open-button , .btn.cancel , .head-title , #help_img').click(function() {
                //$('#help_img').toggle();
                $('#myForm').toggle();
            });
        });

        function sendMsg() {
           
            var phone = $('#phone').val();
            var msg = $('#msg').val();
            data = {
                phone: phone,
                msg: msg,
                url: window.location.href
            };
            $.ajax({
                url: "<?= site_url('support'); ?>",
                type: 'POST',
                data: data,
                success: function(response) {
                    if (response.success == 0) {
                        $('#errorPhone').html(response.phone);
                        $('#errorMsg').html(response.msg);
                    } else if (response.success == 1) {
                        $('#phone').val("");
                        $('#msg').val("");
                        $('#help_img').toggle();
                        $('#myForm').toggle();
                    }
                },
                cache: false,
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);
                }

            });
        }
        
    </script>





    </body>

    </html>
