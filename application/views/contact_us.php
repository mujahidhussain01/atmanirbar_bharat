<?php include('common/header.php')?>
<?php include('common/menu.php')?>

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


    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li><a href="<?php echo base_url()?>">Home</a></li>
                            <li class="active">Contact us</li>
                        </ol>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="bg-white pinside30">
                        <div class="row align-items-center">
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-6">
                                <h1 class="page-title">Contact Us</h1>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-6">
                                <div class="btn-action"><a href="#" class="btn btn-secondary">Download App</a> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="">
        <!-- content start -->
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="wrapper-content bg-white p-3 p-lg-5">
                        <div class="contact-form mb60">
                            <div class=" ">
                                <div class="offset-xl-2 col-xl-8 offset-lg-2 col-lg-8 col-md-12 col-sm-12 col-12">
                                    <div class="mb60  section-title text-center  ">
                                        <!-- section title start-->
                                        <h1>Get In Touch</h1>
                                        <p>Reach out to us &amp; we will respond as soon as we can.</p>
                                    </div>
                                </div>
                                <form class="contact-us" id="contactform">
                                    
                                <div id="errormessageidv"></div>
	    
	                            <div id="sucmessageidv"></div>
                                    
                                    <div class=" ">
                                        <!-- Text input-->
                                        <div class="row">
                                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label class="sr-only control-label" for="name">Name<span class=" "> </span></label>
                                                    <input type="hidden" value="HELP" name="f_type">
                                                    <input id="name" name="name" type="text" placeholder="Name" class="form-control input-md" required>
                                                </div>
                                            </div>
                                            <!-- Text input-->
                                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label class="sr-only control-label" for="email">Email<span class=" "> </span></label>
                                                    <input id="email" name="email" type="email" placeholder="Email" class="form-control input-md" required>
                                                </div>
                                            </div>
                                            <!-- Text input-->
                                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label class="sr-only control-label" for="phone">Phone<span class=" "> </span></label>
                                                    <input id="phone" name="phone" type="number" placeholder="Phone" class="form-control input-md"   maxlength = "10" required oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                </div>
                                            </div>
                                            <!-- Select Basic -->
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label class="control-label" for="message"> </label>
                                                    <textarea class="form-control" id="message" rows="7" name="message" placeholder="Message" required></textarea>
                                                </div>
                                            </div>
                                            <!-- Button -->
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <button type="submit" class="btn btn-secondary">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.section title start-->
                        <div class="contact-us mb60">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="mb60  section-title">
                                        <!-- section title start-->
                                        <h1>We are here to help you </h1>
                                        <p class="lead">Various versions have evolved over the years sometimes by accident sometimes on purpose injected humour and the like.</p>
                                    </div>
                                    <!-- /.section title start-->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                    <div class="bg-boxshadow pinside60 outline text-center mb30">
                                        <div class="mb40"><i class="icon-briefcase icon-2x icon-default"></i></div>
                                        <h2 class="capital-title">Branch Office</h2>
                                        <p>#</p>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                    <div class="bg-boxshadow pinside60 outline text-center mb30">
                                        <div class="mb40"><i class="icon-phone-call icon-2x icon-default"></i></div>
                                        <h2 class="capital-title">Call us at </h2>
                                        <h1 class="text-big">+91-9999999999</h1>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                    <div class="bg-boxshadow pinside60 outline text-center mb30">
                                        <div class="mb40"> <i class="icon-letter icon-2x icon-default"></i></div>
                                        <h2 class="capital-title">Email Address</h2>
                                        <p>info@atmanirbharbharat .com</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--<div class="map" id="googleMap"></div>-->
                    </div>
                   
                </div>
            </div>
        </div>
    </div>

<?php include('common/footer.php')?>


<script type="text/javascript">
   $(document).ready(function(){
   $('#contactform').on('submit', function(event){
   event.preventDefault();
   $.ajax({
   url:"<?= base_url();?>Contact_us/submitenquiry",
   method:"POST",
   data:$(this).serialize(),
                   success:function(data)
                   {
                   var data=JSON.parse(data);
                   if(data.error==0)
                   {    
                       $(window).scrollTop(0);
                       $('#sucmessageidv').html(data.message);
                       $("#errormessageidv").hide();
                       $("#sucmessageidv").show();
                   }
                   else
                   {
                        $(window).scrollTop(0);
                       $("#errormessageidv").html(data.message);
                       $("#sucmessageidv").hide();
                       $("#errormessageidv").show();
                   }
   
                   }
   });
   });
   });
</script>