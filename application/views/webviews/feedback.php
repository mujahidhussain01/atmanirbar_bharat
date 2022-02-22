

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
    .s-msg
    {
        display:none;
        background: green;
        color: rgb(255, 255, 255);
        margin-bottom: 20px;
        padding: 5px;
        text-align: center;
    }
    .e-msg
    {
        display:none;
        background: red;
        color: rgb(255, 255, 255);
        margin-bottom: 20px;
        padding: 5px;
        text-align: center;
    }
</style>

<body>
<script src='//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
<script src="https://m.servedby-buysellads.com/monetization.js" type="text/javascript"></script>
<body>
<div class="content">
	<div class="main">
	    <h1 class='text-dark'>Feedback</h1><br>
	   
		<form action="post" id="feedbackform">
		<div id="errormessageidv" class="e-msg"></div>
	    <div id="sucmessageidv"   class="s-msg"></div>
	    
			<h5>Title</h5>
				<input type="text" placeholder="Type here" required="" name="title" class="enq">
			    <input type="hidden" value="FEEDBACK" name="f_type">
			    <input type="hidden" value="<?php echo $user_id?>" name="user_id">
			<h5>Comment </h5>	
				<textarea  required placeholder="Type here" name="message" class="enq"></textarea>
				<input type="submit" value="Submit Your enquiry">
		</form>
	</div>

</div>

</body>

<script type="text/javascript">
   $(document).ready(function(){
   $('#feedbackform').on('submit', function(event){
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
