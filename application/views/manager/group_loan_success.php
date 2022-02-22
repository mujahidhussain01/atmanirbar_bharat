<?php include "common/header.php" ?>

<?php include "common/sidebar.php" ?>

<style>
/* #partitioned {
  padding-left: 15px;
  letter-spacing: 42px;
  border: 0;
  background-image: linear-gradient(to left, black 70%, rgba(255, 255, 255, 0) 0%);
  background-position: bottom;
  background-size: 50px 1px;
  background-repeat: repeat-x;
  background-position-x: 35px;
  width: 220px;
} */
</style>

<div class="app-content content">

    <div class="content-wrapper-before" style="position: relative;">
        <div class="content-header row">
            <div class="content-header-left col-md-4 col-12">
                <h5 class="content-header-title text-center mt-1 text-white">Loan Applied Successfully</h5>
            </div>
        </div>
    </div>

    <div class="content-wrapper">
        <div id="content" class="content-body mt-5">
            <div class="panel-group" id="accordion">

                <div class="card">
                    <div class="card-header">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <p class="text-center text-success display-4"><i class="fa fa-check"></i></p>
                                <h4 class="panel-title text-capitalize text-center">
                                    User Added To Group Loan Successfully 
                                </h4>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="panel-body">
                            <div class="row p-2 justify-content-center">
                            <a href="<?=base_url()?>manager/home"><button type="submit" class="btn btn-lg btn-primary">Ok</button></a>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "common/footer.php" ?>