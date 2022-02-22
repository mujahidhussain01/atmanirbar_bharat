    <div class="sticky-top">
        <?php if($this->agent->is_mobile()){?>
        <div class="header-topbar">
            <!-- top-bar -->
            <div class="container">
                <div class="row">
                            <div class="top-text col-4 text-center" style="border-right:1px solid #fff">
                                 <a href="tel:999999999"><i class="fa fa-phone" style="font-size:18px;"></i></a>
                            </div>
                            <div class="top-text col-4 text-center" style="border-right:1px solid #fff">
                                <a href="mailto:+1800-123-4567"><i class="fa fa-envelope" style="font-size:18px"></i></a>
                            </div> 
                            <div class="top-text col-4 text-center">
                                <a href="https://wa.me/91999999999?text=Hello%20Easy%20Loan%20Mantra%2C%20Provide%20me%20a%20loan" target='_blank'><i class="fab fa-whatsapp" style="font-size:18px"></i></a>
                            </div>
                </div>
            </div>
        </div>
        <?php } else {?>
        <div class="header-topbar">
            <!-- top-bar -->
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-4 col-sm-6 col-6 d-none d-xl-block d-lg-block">
                        <p class="mail-text">Welcome to Atmanirbharbharat</p>
                    </div>
                    <div class="col-xl-8 col-lg-7 col-md-12 col-sm-12 col-12 text-right">
                        <div class="top-nav">
                            <span class="top-text">
                                 <a href="tel:999999999"><i class="fa fa-phone"></i>+91-999999999</a>
                            </span>
                            <span class="top-text">
                                <a href="mailto:+1800-123-4567"><i class="fa fa-envelope"></i> info@atmanirbharbharat.com</a>
                            </span> 
                            <span class="top-text">
                                <a href="https://wa.me/91999999999?text=Hello%20Easy%20Loan%20Mantra%2C%20Provide%20me%20a%20loan" target='_blank'><i class="fab fa-whatsapp"></i>+91-999999999</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php }?>
        <!-- /.top-bar -->
        <div class="bg-white">
            <nav class="navbar navbar-expand-lg navbar-light bg-white  p-0  border-top border-bottom">
                <div class="container">
                    <a href="<?php echo base_url()?>">
                        <img src="<?=base_url()?>images/aamjan-04.png" alt="atmanirbharbharat - Loan Company" style="height: 60px;width: 85px;margin: 5px 0;">
                        </a>
                    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="icon-bar top-bar mt-0"></span>
                        <span class="icon-bar middle-bar"></span>
                        <span class="icon-bar bottom-bar"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-lg-auto ">
                            <li class="nav-item">
                                <a  class="nav-link "  href="<?php echo base_url()?>">
                                    Home
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a  class="nav-link "  href="<?php echo base_url()?>loan_options">
                                    Loan Options
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a  class="nav-link "  href="<?php echo base_url()?>about">
                                    About
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a  class="nav-link " href="<?php echo base_url()?>faq">
                                    Faq
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link " href="<?php echo base_url()?>contact_us">
                                    Contact us
                                </a>
                            </li>
                        </ul>
                        <!--<span class="search-nav"> <a class="search-btn collapsed" role="button" data-toggle="collapse" href="#searchbar" aria-expanded="false"><i class="fa fa-search"></i></a> </span>-->
                    </div>
                </div>
            </nav>
        </div>
    </div>