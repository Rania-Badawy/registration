<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login Page</title>
	<meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
		
	<!-- bootstrap framework -->
	<link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<!-- google webfonts -->
	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400&amp;subset=latin-ext,latin' rel='stylesheet' type='text/css'>
		
	<link href="<?php echo base_url(); ?>assets/css/login.css" rel="stylesheet">
	
</head>
<body>

	<div class="login_container">
		<form id="login_form" action="<?php echo site_url('home/login/check_login'); ?>" method="post">
        <!------------------------------------------------------------------------------------------>
        <?php if($this->session->flashdata('msg')){?>
        <p class="alert alert-error"><?php echo $this->session->flashdata('msg');?> </p> <?php } ?>
        <!------------------------------------------------------------------------------------------>
			<h1 class="login_heading">تسجيل الدخول </h1>
			<div class="form-group">
				<label for="login_username">إسم المستخدم</label>
				<input type="text" class="form-control input-lg" name="username"
                value="<?php echo set_value('username'); ?>"/></p><?php echo form_error('username'); ?>
			</div>
			<div class="form-group">
				<label for="login_password">كلمه المرور</label>
				<input type="password" class="form-control input-lg" value="password" name="password"
                 value="<?php echo set_value('password'); ?>"/></p><?php echo form_error('password'); ?>
			</div>
			<div class="submit_section">
				<input type="submit" class="btn btn-lg btn-success btn-block" value="تسجيل الدخول">
			</div>
		</form>
	
	</div>
	
	<div class="modal fade" id="terms_modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Terms & Conditions</h4>
				</div>
				<div class="modal-body">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus eaque tempora! Porro cumque labore voluptate dolore alias libero commodi deserunt unde aspernatur dignissimos quaerat similique maiores quasi eos optio quidem.
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus eaque tempora! Porro cumque labore voluptate dolore alias libero commodi deserunt unde aspernatur dignissimos quaerat similique maiores quasi eos optio quidem.
				</div>
			</div>
		</div>
	</div>
	
	<!-- jQuery -->
	<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
	<!-- bootstrap js plugins -->
	<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
	<script>
		$(function() {
			// switch forms
			$('.open_register_form').click(function(e) {
				e.preventDefault();
				$('#login_form').removeClass().addClass('animated fadeOutDown');
				setTimeout(function() {
					$('#login_form').removeClass().hide();
					$('#register_form').show().addClass('animated fadeInUp');
				}, 700);
			})
			$('.open_login_form').click(function(e) {
				e.preventDefault();
				$('#register_form').removeClass().addClass('animated fadeOutDown');
				setTimeout(function() {
					$('#register_form').removeClass().hide();
					$('#login_form').show().addClass('animated fadeInUp');
				}, 700);
			})
		})
	</script>
	
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-49181536-1']);
		_gaq.push(['_trackPageview']);
	  
		(function() {
		  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>
</body>
</html>