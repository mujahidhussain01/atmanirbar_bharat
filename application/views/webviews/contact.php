

<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html>
<head>
<title></title>
<!-- for-mobile-apps -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<!-- //for-mobile-apps -->
<link href='//fonts.googleapis.com/css?family=Amaranth:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Josefin+Slab:400,100,100italic,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
<link href="<?=base_url('assets/css/')?>feedback_widget.css" rel="stylesheet" type="text/css" media="all" />
</head>

<style>
    #sucmessageidv
    {
        display:none;
        background: green;
        color: rgb(255, 255, 255);
        margin: 20px 0;
        padding: 5px;
        text-align: center;
        border-radius: 0;
        box-shadow: 0 5px 0 #036703;
    }
    #errormessageidv
    {
        display:none;
        background: red;
        color: rgb(255, 255, 255);
        margin: 20px 0;
        padding: 5px;
        text-align: center;
        border-radius: 0;
        box-shadow: 0 5px 0 #dc0505;
    }
</style>

<body>
<script src='//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
<!--<script src="https://m.servedby-buysellads.com/monetization.js" type="text/javascript"></script>-->
<body>
<div class="content">
	<div class="main">
	    <h1 class='text-dark'>Drop us a Line</h1><br>
	    <div class='content'>
	        <div class="col-md-6">
                <div>
                    <div class="icon-block pb-3">
                        <span class="icon-block__icon">
                            <span class="mbri-letter mbr-iconfont" media-simple="true"></span>
                        </span>
                        <h4 class="icon-block__title align-left mbr-fonts-style display-5">
                            Don't hesitate to contact us
                        </h4>
                    </div>
                    <div class="icon-contacts pb-3">
                        <h5 class="align-left mbr-fonts-style display-7">
                            Ready for offers and cooperation
                        </h5>
                        <p class="mbr-text align-left mbr-fonts-style display-7">
                            Phone: +91-9818929408 <br>
                            Email: info@easyloanmantra.com
                        </p>
                    </div>
                </div>
            </div>
	    </div>
		<form id="helpform">
		    <div id="errormessageidv"></div>
	    
	        <div id="sucmessageidv"></div>
	        
			<h5>Title</h5>
				<input type="text" placeholder="Type here" name='title'  required="">
			     <input type="hidden" value="HELP" name="f_type">
			     <input type="hidden" value="<?php echo $user_id?>" name="user_id">
			<h5>Comment </h5>	
				<textarea name='message' required="" placeholder="Type here"></textarea>
				<input type="submit" value="Send Feedback">
		</form>
	</div>

</div>

</body>

<script type="text/javascript">
   $(document).ready(function(){
   $('#helpform').on('submit', function(event){
   event.preventDefault();
   $.ajax({
   url:"<?= base_url();?>Webviews/submitfeedback",
   method:"POST",
   data:$(this).serialize(),
                   success:function(data)
                   {
                   var data=JSON.parse(data);
                   if(data.error==0)
                   {    
                       $(window).scrollTop(0)
                       $('#sucmessageidv').html(data.message);
                       $(".enq").val('');
                       $("#sucmessageidv").show();
                   }
                   else
                   {
                       $("#errormessageidv").html(data.message);
                       $("#errormessageidv").show();
                   }
   
                   }
   });
   });
   });
</script>

</html>
