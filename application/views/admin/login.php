<!DOCTYPE html>

<html lang="en">

	<!-- Mirrored from seantheme.com/color-admin/admin/google/login_v3.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 24 Sep 2020 06:59:02 GMT -->

	<head>

		<meta charset="utf-8" />

		<title>Atma Nirbhar Bharat Admin | Login Page</title>

		<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />

		<meta content="" name="description" />

		<meta content="" name="author" />

		<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet" />

		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

		<link href="<?php echo base_url()?>assets/css/google/app.min.css" rel="stylesheet" />

		<style>

.login.login-with-news-feed .right-content {

    min-height: 500px;

    background: #fff;

    width: 380px;

     height: auto; 

    margin: 30px auto;

    padding: 20px;

    display: -webkit-box;

    display: -ms-flexbox;

    display: flex;

    -webkit-box-orient: vertical;

    -webkit-box-direction: normal;

    -ms-flex-direction: column;

    flex-direction: column;

    -webkit-box-pack: center;

    -ms-flex-pack: center;

    justify-content: center;

    box-shadow: 0 0 10px #00000030;

    border-radius: 0.4em;

}

.login.login-with-news-feed .right-content .login-header+.login-content {

    padding-top: 0;

}

		</style>

	</head>

	<body class="pace-top">

		<div id="page-loader" class="fade show">

			<span class="spinner"></span>

		</div>

		<div class="login-cover">

<div class="login-cover-image" style="background-image: url('../assets/img/login-bg-13.jpg');" data-id="login-cover-image"></div>

<div class="login-cover-bg"></div>

</div>

		<div id="page-container" class="fade">

			<div class="login login-v2 animated fadeIn">

				<!--<div class="news-feed">-->

				<!--	<div class="news-image" style="background-image: url(<?=base_url('assets/img/logo/easyloanmantra.png')?>)"></div>-->

				<!--</div>-->

				<div class="right-content">

				    <div class="login-header">

                    <div class="brand">

                        <span class="logo">

                        <span class="text-blue">A</span>

                        <span class="text-red">T</span>

                        <span class="text-orange">M</span>

                        <span class="text-blue">A</span>

                        <span class="text-green">N</span>

                        <span class="text-blue">I</span>

                        <span class="text-red">R</span>

                        <span class="text-orange">B</span>

                        <span class="text-blue">H</span>

                        <span class="text-green">A</span>

                        <span class="text-red">R</span>

                        <span class="text-orange">B</span>

                        <span class="text-blue">H</span>

                        <span class="text-green">A</span>

                        <span class="text-orange">R</span>

                        <span class="text-green">A</span>

                        <span class="text-blue">T</span>

                        </span> <b>Admin</b> Panel

                        <!--<small>responsive bootstrap 4 admin template</small>-->

                    </div>

                        <div class="icon">

                            <i class="fa fa-lock"></i>

                        </div>

                    </div>

<!--					<div class="login-header">-->

<!--						<div class="brand">-->

<!--						<img src="<?=base_url('assets/img/logo/easyloanmantra.png')?>" style="-->

<!--    width: 100%;-->

<!--    height: 1005;-->

<!--    object-fit: contain;-->

<!--">-->

<!--						</div>-->

<!--					</div>-->

					<?php if($fail=$this->session->flashdata('error')) {?>

    				<div class="alert alert-danger" ><?php echo $fail?></div>

					<?php }?>

					<div class="login-content">

						<form action="<?php echo base_url()?>admin/login/logincheck" method="post" class="margin-bottom-0">

							<div class="form-group m-b-15">

								<input type="text" class="form-control form-control-lg" placeholder="Email Address" required name="email" value="<?php echo set_value('email')?>">

								 <?php echo form_error('email', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

							</div>



							<div class="form-group m-b-15">

								<input type="password" class="form-control form-control-lg" placeholder="Password" required name="password" />

								 <?php echo form_error('password', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

							</div>

		

							<div class="login-buttons">

								<button type="submit" class="btn btn-primary btn-block btn-lg">Sign me in</button>

							</div>

							

							<!--<p class="text-center text-grey-darker mb-0">

								&copy; Color Admin All Right Reserved 2020

							</p>-->

						</form>

					</div>

				</div>

			</div>

		</div>

		<script src="<?php echo base_url()?>assets/js/app.min.js" type="text/javascript"></script>

		<script src="<?php echo base_url()?>assets/js/theme/google.min.js" type="text/javascript"></script>

		<!-- <script src="https://ajax.cloudflare.com/cdn-cgi/scripts/7089c43e/cloudflare-static/rocket-loader.min.js" data-cf-settings="2ce2ae630048bbab531af076-|49" defer=""></script></body> -->

	</html>