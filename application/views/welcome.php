
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="Bootstrap, Landing page, Template, Registration, Landing">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="author" content="Grayrids">
    <title>Easy Loan Mantra</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=base_url()?>web-assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=base_url()?>web-assets/css/line-icons.css">
    <link rel="stylesheet" href="<?=base_url()?>web-assets/css/owl.carousel.css">
    <link rel="stylesheet" href="<?=base_url()?>web-assets/css/owl.theme.css">
    <link rel="stylesheet" href="<?=base_url()?>web-assets/css/animate.css">
    <link rel="stylesheet" href="<?=base_url()?>web-assets/css/magnific-popup.css">
    <link rel="stylesheet" href="<?=base_url()?>web-assets/css/nivo-lightbox.css">
    <link rel="stylesheet" href="<?=base_url()?>web-assets/css/main.css">    
    <link rel="stylesheet" href="<?=base_url()?>web-assets/css/responsive.css">
  </head>
  <body>

<style>
    .loan
    {
        padding-top:100px;
        padding-bottom:100px;
    }
    
    .loan td
    {
        color:#333 !important;
        text-align:center !important;
    }
    
    .loan th
    {
        color:#fff !important;
        text-align:center !important;
    }
    
</style>

    <header id="home" class="hero-area-2">  

      <div class="container">
        
        <div class="row space-100" style="justify-content: center;align-items: center;">
          <div class="col-lg-7 col-md-12 col-xs-12">
              <img src="<?=base_url()?>assets/img/logo/easyloanmantra.png" alt="" height="150" width="150">
            <div class="contents">
              <h2 class="head-title" style="color:#333">Loans Better. Faster. Simpler</h2>
              <h4 style="font-size:30px;">Credit solutions that empower your decisions, in a paperless and hasslefree world.</h4>
              <div class="header-button">
                <a href="<?=base_url('assets/apk/easyloanmantraapk.apk')?>" class="btn p-0" download>
                    <img src="<?php echo base_url() ?>assets/img/googleplay.png" style="height: 40px;width: 180px;">
                </a>
              </div>
            </div>
          </div>
          <div class="col-lg-5 col-md-12 col-xs-12">
            <div class="intro-img">
              <img src="<?=base_url()?>assets/img/appoverimage.png" alt="">
            </div>            
          </div>
        </div> 
      </div>             
    </header>

    <div id="preloader">
      <div class="loader" id="loader-1"></div>
    </div>
    <!-- End Preloader -->
    
    <section class="loan">
        <div class="container">
            <div class="row">
                <div class="card col-12 p-0">
            <div class="card-content collapse show">
                <div class="card-body card-dashboard">
                    <h3 class="card-text">How Much Do You Need?</h3>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead class="bg-primary white">
                            <tr>
                                <th>Loan</th>
                                <th>Loan Ammount</th>
                                <th>Processing Fees</th>
                                <th>Gst</th>
                                <th>Tenure</th>
                                <th>Penalty</th>
                                <th>Extension Charges</th>
                                <th>Extension Days</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0;?>
                            <?php foreach($loans as $record){?>
                            <tr>
                            <td><?php echo ++$i?></td>
                            <td><?php echo "Rs.".$record['amount']?></td>
    						<td><?php echo "Rs.".$record['processing_fee']?></td>
    						<td><?php echo "Rs.".$record['gst']?></td>
    						<td><?php echo $record['tenure'].' days'?></td>
    						<td><?php echo $record['penalty']."%"?></td>
    						<td><?php echo $record['extension_charges']."%"?></td>
    						<td><?php echo $record['extension_days'].' days'?></td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
            </div>
        </div>
    </section>

    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="<?=base_url()?>web-assets/js/jquery-min.js"></script>
    <script src="<?=base_url()?>web-assets/js/popper.min.js"></script>
    <script src="<?=base_url()?>web-assets/js/bootstrap.min.js"></script>
    <script src="<?=base_url()?>web-assets/js/owl.carousel.js"></script> 
    <script src="<?=base_url()?>web-assets/js/jquery.mixitup.js"></script>       
    <script src="<?=base_url()?>web-assets/js/jquery.nav.js"></script>    
    <script src="<?=base_url()?>web-assets/js/scrolling-nav.js"></script>    
    <script src="<?=base_url()?>web-assets/js/jquery.easing.min.js"></script>     
    <script src="<?=base_url()?>web-assets/js/wow.js"></script>   
    <script src="<?=base_url()?>web-assets/js/jquery.counterup.min.js"></script>     
    <script src="<?=base_url()?>web-assets/js/nivo-lightbox.js"></script>     
    <script src="<?=base_url()?>web-assets/js/jquery.magnific-popup.min.js"></script>     
    <script src="<?=base_url()?>web-assets/js/waypoints.min.js"></script>      
    <script src="<?=base_url()?>web-assets/js/form-validator.min.js"></script>
    <script src="<?=base_url()?>web-assets/js/contact-form-script.js"></script>   
    <script src="<?=base_url()?>web-assets/js/main.js"></script>
    
  </body>
</html>