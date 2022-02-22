<!DOCTYPE html>
<html lang="en">
	<!-- Mirrored from seantheme.com/color-admin/admin/google/login_v3.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 24 Sep 2020 06:59:02 GMT -->
	<head>
		<meta charset="utf-8" />
		<title>Easy loan Mantra Admin | Login Page</title>
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
			
				<div class="right-content">
				    <div class="login-header">
                    <div class="brand">
                        <span class="logo">
                        <span class="text-blue">E</span>
                        <span class="text-red">A</span>
                        <span class="text-orange">S</span>
                        <span class="text-blue">Y</span>
                        <span class="text-green">L</span>
                        <span class="text-blue">O</span>
                        <span class="text-red">A</span>
                        <span class="text-orange">N</span>
                        <span class="text-blue">M</span>
                        <span class="text-green">A</span>
                        <span class="text-red">N</span>
                        <span class="text-orange">T</span>
                        <span class="text-blue">R</span>
                        <span class="text-green">A</span>
                        </span> <b>Admin</b> Panel
                       
                    </div>
                        <div class="icon">
                            <i class="fa fa-lock"></i>
                        </div>
                    </div>

					<?php if($fail=$this->session->flashdata('error')) {?>
    				<div class="alert alert-danger" ><?php echo $fail?></div>
					<?php }?>
					<div class="login-content">
					    <div class="error-msg mb-3" style="background:red;color:#fff;display:none;font-weight:bold;font-size:16px;"></div>
						<form method="post" class="margin-bottom-0" id="loginform">
							<div class="form-group m-b-15">
								<input type="text" class="form-control form-control-lg" placeholder="Email Address" required name="email" >
							</div>
                            <!--<a href="<?=base_url()?>admin/forgot_password" class="d-block text-right mt-3 mb-3">Forgot Password?</a>-->
							<div class="login-buttons">
								<button type="submit" class="btn btn-primary btn-block btn-lg">Send Otp</button>
							</div>
						</form>
					</div>
					<div class="otp-content" style="display:none;">
						<form id="otpform" method="post" class="margin-bottom-0">
						    <p class="mt-2" style="color:#fff">An OTP has been sent on this mobile number: <span id="mobnum" style="color:red;"></span></p>
						      <div class="otp-error-msg mb-3 " style="background:red;color:#fff;display:none;font-weight:bold;font-size:16px;"></div>
							<div class="form-group m-b-15">
								<input type="number" maxlength = "4" class="form-control form-control-lg" placeholder="Enter OTP" required name='otp' oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
								<input type="hidden" class="form-control form-control-lg"  name='mobile' id="mobile">
							</div>
							<div class="d-block text-right"><a style="color:#333;" role="button" aria-disabled="true" class="btn btn-default btn-sm disabled mb-3" id="resendotpbtn" onclick="resendotp()"></a></div>
							<div class="login-buttons">
								<button type="submit" class="btn btn-primary btn-block btn-lg">Login</button>
							</div>
						
						</form>
					</div>
				</div>
			</div>
		</div>
		<script src="<?php echo base_url()?>assets/js/app.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url()?>assets/js/theme/google.min.js" type="text/javascript"></script>
		
		
<script type="text/javascript">

let timerOn = true;

function timer(remaining) {
  var m = Math.floor(remaining / 60);
  var s = remaining % 60;
  
  m = m < 10 ? '0' + m : m;
  s = s < 10 ? '0' + s : s;
  document.getElementById('resendotpbtn').innerHTML = m + ':' + s;
  remaining -= 1;
  
  if(remaining >= 0 && timerOn) {
    setTimeout(function() {
        timer(remaining);
    }, 1000);
    return;
  }

  if(!timerOn) {
    // Do validate stuff here
    return;
  }
  
    $("#resendotpbtn").html('resend otp');
     $("#resendotpbtn").removeClass("disabled");
}


function resendotp()
{
var mobile=$('#mobile').val();
$.ajax({
url:"<?php echo base_url()?>admin/Login/resendotp",
method:"POST",
data:{mobile:mobile},
                success:function(data)
                {
                var data=JSON.parse(data);
                if(data.error==0)
                {
                    $(".otp-error-msg").html(data.message);
                    $(".otp-error-msg").show();
                    $("#resendotpbtn").addClass("disabled");
                    timer(60);
                }
                else
                {
                  $(".otp-error-msg").html(data.message);
                  $(".otp-error-msg").show()
                }


                }
});
}

$(document).ready(function(){
$('#loginform').on('submit', function(event){
event.preventDefault();
$.ajax({
url:"<?php echo base_url()?>admin/Login/sendotp",
method:"POST",
data:$(this).serialize(),
                success:function(data)
                {
                var data=JSON.parse(data);
                if(data.error==0)
                {
                    $(".login-content").hide();
                    $(".otp-content").show();
                    $('#mobile').val(data.mobile);
                    $("#mobnum").html(data.mobile);
                    timer(60);
                }
                else
                {
                   $(".error-msg").html(data.message);
                   $(".error-msg").show();
                }


                }
});
});
});
</script>		
		
<script type="text/javascript">

$(document).ready(function(){
$('#otpform').on('submit', function(event){
event.preventDefault();
$.ajax({
url:"<?php echo base_url()?>admin/Login/checkotp",
method:"POST",
data:$(this).serialize(),
                success:function(data)
                {
                var data=JSON.parse(data);
                if(data.error==0)
                {
                    window.location.href = "<?=base_url()?>admin";
                }
                else
                {
                  $(".otp-error-msg").html('Invalid OTP !');
                  $(".otp-error-msg").show()
                }

                }
});
});
});
</script>		
		
	</html>