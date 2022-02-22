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
                <h5 class="content-header-title text-center mt-1 text-white">User OTP Verify</h5>
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
                                    Enter User OTP
                                </h4>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="panel-body">
                            <div class="row p-2">
                            <?php if( $this->session->error ):?>
                                <div class="col-12 d-flex justify-content-center">
                                    <div class="w-100 alert alert-danger" role="alert">
                                    <?= $this->session->error?>
                                    </div>
                                </div>
                                <?php endif;?>
                                <form method="POST" class="col-12 row pr-0" action="<?= base_url() ?>manager/group_loans/user_otp_verify/<?= $group_loan_info['lsid'] ?>">
                                    <div class="col-12 d-flex">
                                        <input type="hidden" style="display: none;" value="<?= $mobile?>" name="user_contact">
                                        <input type="number" required name="otp_val" id="otp_val" class="form-control">
                                    </div>
                                    <div class="col-12 d-flex justify-content-end my-2">
                                        <button type="submit" id="submitBtn" disabled class="btn btn-lg btn-primary">Verify</button>
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

<script>
$( document ).ready(function()
{
    var otp_valInp = $( '#otp_val' );
    var submitBtn = $( '#submitBtn' );

    $( otp_valInp ).on( 'input', function()
    {
        $( submitBtn ).prop( 'disabled', true );

        if( /^[0-9]{4}$/gi.test( $( this ).val() ) )
        {
            $( submitBtn ).prop( 'disabled', false );
        }
    });
    
});
</script>