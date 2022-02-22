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
                <h5 class="content-header-title text-center mt-1 text-white"><?= $sub_page?></h5>
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
                                <h4 class="panel-title text-capitalize text-center">
                                    Enter Received Amount
                                </h4>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="panel-body">
                            <div class="row p-2">

                                <?php if( $this->session->error ):?>
                                    <div class="col-12 alert alert-danger" role="alert">
                                        <?= $this->session->error?>
                                    </div>
                                <?php endif;?>

                                <form method="POST" class="col-12 row pr-0" action="<?= base_url() ?>manager/loans/mark_payment_received/<?= $loan_payment['id'] ?>">
                                    <div class="col-12">
                                        <input type="number" min="1" required name="amount" value="<?= $loan_payment[ 'amount' ]?>" class="form-control <?= form_error( 'amount' ) ? 'is-invalid' : ''?>">
                                       
                                        <div class="invalid-feedback">
                                            <?= form_error( 'amount' )?>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end my-2">
                                        <button type="submit" class="btn btn-lg btn-primary">Mark Payment Received</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "common/footer.php" ?>