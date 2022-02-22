<?php include "common/header.php" ?>

<?php include "common/sidebar.php" ?>

<style>

</style>

<div class="app-content content">

    <div class="content-wrapper-before" style="position: relative;">
        <div class="content-header row">
            <div class="content-header-left col-md-4 col-12">
                <h5 class="content-header-title text-center mt-1 text-white">Add User</h5>
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
                                    Add User To Group
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

                                <form method="POST" class="col-12 row pr-0" action="<?= base_url() ?>manager/group_loans/user_otp_send/<?= $group_loan_info['lsid'] ?>">
                                    <div class="col-12 d-flex">
                                        <input type="number" required name="user_contact" class="form-control" id="user_contact" placeholder="Enter Mobile Number" value="<?= $mobile?>" minlength="10" maxlength="10" pattern="^[6-9][0-9]{9}">
                                    </div>
                                    <div class="col-12 d-flex justify-content-end my-2">
                                        <button id="submitBtn" disabled type="submit" class="btn btn-lg btn-primary">Send OTP</button>
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
</div>
<?php include "common/footer.php" ?>

<script>
$( document ).ready(function()
{
    var user_contactInp = $( '#user_contact' );
    var submitBtn = $( '#submitBtn' );

    if( /^[6-9][0-9]{9}$/gi.test( $( user_contactInp ).val() ) )
    {
        $( submitBtn ).prop( 'disabled', false );
    }

    $( user_contactInp ).on( 'input', function()
    {
        $( submitBtn ).prop( 'disabled', true );

        if(  /^[6-9][0-9]{9}$/gi.test( $( this ).val() ) )
        {
            $( submitBtn ).prop( 'disabled', false );
        }
    });
    
});
</script>