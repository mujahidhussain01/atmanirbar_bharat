
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    @media screen and (max-width:480px)
    {
    .navbar-container
    {
        background-image: none !important;
    }
    .fa-bars
    {
        color: gray;
    }
    }
</style>
<!-- BEGIN: Body-->
<body class="horizontal-layout horizontal-menu 2-columns  " data-open="hover" data-menu="horizontal-menu" data-color="bg-gradient-x-purple-blue" data-col="2-columns">
<div id="overlay">
	<div class="cv-spinner">
		<span class="spinner"></span>
	</div>
</div>
    <!-- BEGIN: Header-->
    <!-- fixed-top-->
    <nav style="position: sticky; top:0; z-index:9999" class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow navbar-fixed-top navbar-light navbar-brand-center">

      <div class="navbar-wrapper">
        <div class="navbar-container content">
          <div class="collapse navbar-collapse" id="navbar-mobile" style="display:block">
            <ul class="nav navbar-nav mr-auto float-left d-flex justify-content-between w-100">
            <?php if( $page != 'dashboard' ) :?>
                <li class="nav-item mobile-menu" onclick="window.history.go(-1); return false;">
                    <a class="nav-link text-dark" href="#">
                        <i class="fa fa-chevron-left"></i>
                    </a>
                </li>
            <?php else:?>
              <li class="nav-item mobile-menu">
                    <a class="nav-link text-dark" href="#">
                    </a>
                </li>
            <?php endif;?>

                <li class="nav-item" style="display: flex;"><a style="display:flex" class="navbar-brand" href="<?= base_url();?>manager/home"><img style="height: 60px;margin-right: 5px;align-self: center;" class="brand-logo" alt="atmanirbhar logo" src="<?= base_url();?>images/ATM.png">
             </a></li>

             <li class="nav-item d-flex align-items-center"><a class="nav-link text-dark" href="<?= base_url();?>manager/home/logout"> <i class="fa fa-sign-out"></i></a></li>
         
            </ul>
          </div>
        </div>
      </div>
    </nav>
    <!-- END: Header-->   