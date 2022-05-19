<?php include "common/header.php" ?>

<?php include "common/sidebar.php" ?>


<div class="app-content content">
    <div class="content-wrapper-before" style="position: relative;">
        <div class="content-header row">
            <div class="content-header-left col-md-4 col-12">
                <h5 class="content-header-title text-center mt-1 text-white"><?= $sub_page ?></h5>
            </div>
        </div>
    </div>

    <?php if (!empty($loan_details)) : ?>

        <div class="content-wrapper">
            <div id="content" class="content-body">
                    <div class="card">
                        <div class="card-body">
                            <div class='row '>

                                <div class="col-12">

                                    <div class="col-12 row m-0 p-0">
                                        <div class="col-6 p-2 border-bottom"> <strong> Loan ID </strong> </div>
                                        <div class="col-6 p-2 border-bottom"><?= $loan_details['la_id'] ?></div>
                                    </div>

                                    <div class="col-12 row m-0 p-0">
                                        <div class="col-6 p-2 border-bottom"> <strong> Loan Type </strong> </div>
                                        <div class="col-6 p-2 border-bottom"><?= $loan_details['loan_type'] ?></div>
                                    </div>

                                </div>

                                <div class="col-12">

                                    <div class="col-12 row m-0 p-0">
                                        <div class="col-6 p-2 border-bottom"> <strong> Amount </strong> </div>
                                        <div class="col-6 p-2 border-bottom"><?= ($loan_details['amount'] ? '₹' . $loan_details['amount'] : 'NA') ?></div>
                                    </div>

                                    <div class="col-12 row m-0 p-0">
                                        <div class="col-6 p-2 border-bottom"> <strong> Final Loan Amount </strong> </div>
                                        <div class="col-6 p-2 border-bottom">₹<?= $loan_details['loan_closer_amount'] ?></div>
                                    </div>

                                    <div class="col-12 row m-0 p-0">
                                        <div class="col-6 p-2 border-bottom"> <strong> Remaining Balance </strong> </div>
                                        <div class="col-6 p-2 border-bottom">₹<?= $loan_details['remaining_balance'] ?></div>
                                    </div>

                                </div>

                                <div class="col-12">

                                    <div class="col-12 row m-0 p-0">
                                        <div class="col-6 p-2 border-bottom"> <strong> ForeClose Amount</strong> </div>
                                        <div class="col-6 p-2 border-bottom"><?= ($loan_details['foreClose_amount'] ? '₹' . $loan_details['foreClose_amount'] : 'NA') ?></div>
                                    </div>

                                    <div class="col-12 row m-0 p-0">
                                        <div class="col-6 p-2 border-bottom"> <strong>Click To ForeClose Loan </strong> </div>
                                        <div class="col-6 p-2 border-bottom">
                                            <button type="button" id="foreClose_loan_btn" class="btn btn-primary btn-sm">
                                            ForeClose
                                            </button>        
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    <?php else : ?>
        <div class="col"> No Loan Found</div>
    <?php endif; ?>
</div>
</div>
<?php include "common/footer.php" ?>

<link rel="stylesheet" href="<?= base_url( 'assets/css/jquery-confirm.css' ) ?>">
<script src="<?= base_url( 'assets/js/jquery-confirm.min.js' )?>"></script>
<script>
    $(document).ready(function()
    {
        var foreClose_amount = parseInt( '<?= $loan_details[ 'foreClose_amount' ]?>' );
        var loan_id = parseInt( '<?= $loan_details[ 'la_id' ]?>' );

        var foreClose_loan_btn = $( '#foreClose_loan_btn' );

        $( foreClose_loan_btn ).on('click', function() 
        {
            $.confirm(
            {
                title: 'Receive Amount ',
                content: '' +
                '<form action="" class="formName">' +
                '<div class="form-group">' +
                '<label>Enter Received Amount</label>' +
                '<input type="text" placeholder="Enter Received Amount" id="received_amount" class="name form-control" required />' +
                '</div>' +
                '</form>',
                buttons:
                {
                    formSubmit:
                    {
                        text: 'Submit',
                        btnClass: 'btn-primary',
                        action: function ()
                        {
                            var received_amount = this.$content.find('#received_amount').val();

                            if( received_amount != foreClose_amount )
                            {
                                $.alert( 'Invalid Amount Received. To ForeClose Loan, The Amount Received Must Be : '+foreClose_amount );
                                return false;
                            }

                            $.confirm(
                            {
                                content: function ()
                                {
                                    var self = this;

                                    var formData =  new FormData;

                                    formData.append( 'loan_id', loan_id );
                                    formData.append( 'received_amount', received_amount );
        
                                    return $.ajax(
                                    {
                                        url: '<?= base_url( 'manager/loans/foreclose_loan' )?>',
                                        type: 'POST',
                                        data: formData,
                                        processData: false,
                                        contentType: false
                                    })
                                    .done( function ( response )
                                    {
                                        response = JSON.parse( response );

                                        self.setTitle( response.success ? 'Success' : 'Error' );
                                        self.setType( response.success ? 'green' : 'red' );
                                        self.setContent( response.msg );

                                        if( response.success )
                                        {
                                            setTimeout( function ()
                                            {
                                                window.location.href = '<?= base_url( 'manager/loans/details/'.$loan_details[ 'la_id' ] )?>';

                                            }, 3000 );
                                        }
                                    })
                                    .fail( function()
                                    {
                                        self.setContent('Unknown Error, Please Try Again Later');
                                    });
                                }
                            });
                        }
                    },
                    cancel: function ()
                    {},
                },
                onContentReady: function ()
                {
                    var jc = this;
                    this.$content.find('form').on('submit', function (e)
                    {
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click');
                    });
                }
            });
        });
    });
</script>