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

        <?php if( $this->session->error ):?>
                <div class="col-12 d-flex justify-content-center">
                    <div class="w-100 alert alert-danger" role="alert">
                    <?= $this->session->error?>
                    </div>
                </div>
        <?php endif;?>

            <div class="panel-group" id="accordion">

                <div class="card">
                    <div class="card-header">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title text-capitalize text-center">
                                    Add User To Group <br>
                                    "<?= $group_loan_info[ 'name' ]?>"
                                </h4>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="panel-body">
                            <div class="row p-2">

                                <form id="sendOTPForm" class="col-12 row pr-0">
                                    <div class="col-12 d-flex">
                                        <input type="number" required name="mobile" class="form-control" id="mobile" placeholder="Enter Mobile Number" minlength="10" maxlength="10" pattern="^[6-9][0-9]{9}">
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
<link rel="stylesheet" href="<?= base_url( 'assets/css/jquery-confirm.css' ) ?>">
<script src="<?= base_url( 'assets/js/jquery-confirm.min.js' )?>"></script>
<script>
    $(document).ready(function()
    {
        var mobileInp = $( '#mobile' );
        var submitBtn = $( '#submitBtn' );

        var sendOTPForm = $( '#sendOTPForm' );

        $( sendOTPForm ).on('submit', function( e ) 
        {
            e.preventDefault();

            $.confirm(
            {
                title: 'Send OTP',
                content: function ()
                {
                    var self = this;
                    var formData =  new FormData;
                    var mobile = $( '#mobile' ).val();

                    formData.append( 'mobile', mobile );

                    return $.ajax(
                    {
                        url: '<?= base_url( 'manager/group_loans/user_otp_send/'.$group_loan_info[ 'id' ] )?>',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false
                    })
                    .done( function ( response )
                    {
                        try
                        {
                            var response = JSON.parse( response );
                            
                            self.setTitle( response.success ? 'Success' : 'Error' );
                            self.setType( response.success ? 'green' : 'red' );
                            self.setContent( response.msg );

                            if( response.success )
                            {
                                $( submitBtn ).prop( 'disabled', true );

                                setTimeout( function ()
                                {
                                    window.location.href = '<?= base_url( 'manager/group_loans/user_otp_verify_form/'.$group_loan_info[ 'id' ] )?>/'+response.data.mobile;
                                    
                                }, 3000 );
                            }
                        }
                        catch
                        {
                            self.setTitle( 'Unknown Error' );
                            self.setType('red' );
                            self.setContent( 'Please Try Again Later' );
                        }
                    })
                    .fail( function()
                    {
                        self.setContent('Unknown Error, Please Try Again Later');
                    });
                }
            });

        });


    if( /^[6-9][0-9]{9}$/gi.test( $( mobileInp ).val() ) )
    {
        $( submitBtn ).prop( 'disabled', false );
    }

    $( mobileInp ).on( 'input', function()
    {
        $( submitBtn ).prop( 'disabled', true );

        if(  /^[6-9][0-9]{9}$/gi.test( $( this ).val() ) )
        {
            $( submitBtn ).prop( 'disabled', false );
        }
    });
    
});
</script>