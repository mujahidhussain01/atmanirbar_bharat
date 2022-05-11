<?php include "common/header.php"?>

<?php include "common/sidebar.php"?>

<style>

    .media.media-sm .media-object {

    width: 64px;

    height: 64px;

    border: 1px solid grey;

}

.justify-content-center{

    justify-content:center;

}

table.table-bordered.dataTable th, table.table-bordered.dataTable td {

    border-left-width: 0;

    white-space: nowrap;

}

</style>

<link href="<?=base_url()?>/assets/plugins/lightbox2/dist/css/lightbox.css" rel="stylesheet" />



<div id="content" class="content">

	<ol class="breadcrumb float-xl-right">

		<li class="breadcrumb-item"><a href="<?=site_url('admin/')?>">Home</a></li>

		<li class="breadcrumb-item"><a href="javascript:;">User loans</a></li>

		<li class="breadcrumb-item active"><a href="javascript:;"><?=$page_title?></a></li>

	</ol>

	<h1 class="page-header"><?=$page_title?> </h1>

	<div class="row">

		<div class="col-12">

			<div class="panel">

				<div class="panel-body">

				    <div class='row '>

                            <div class="row col-12">

                                <div class="col-md-6 row">
                                    <div class="col-md-6 p-25 border-bottom"> <strong> Loan ID </strong> </div>
                                    <div class="col-md-6 p-25 border-bottom"><?= $loan_details['la_id']?></div>
                                </div>

                                <div class="col-md-6 row">
                                    <div class="col-md-6 p-25 border-bottom"> <strong> Loan Type </strong> </div>
                                    <div class="col-md-6 p-25 border-bottom"><?= $loan_details['loan_type']?></div>
                                </div>

                            </div>

                            <div class="row col-12">

                                <div class="col-md-6 row">
                                    <div class="col-md-6 p-25 border-bottom"> <strong> Amount </strong> </div>
                                    <div class="col-md-6 p-25 border-bottom"><?=( $loan_details['amount']?'₹'. $loan_details['amount']:'NA')?></div>
                                </div>

                                <div class="col-md-6 row">
                                    <div class="col-md-6 p-25 border-bottom"> <strong> Final Loan Amount </strong> </div>
                                    <div class="col-md-6 p-25 border-bottom">₹<?= $loan_details['loan_closer_amount']?></div>
                                </div>

                            </div>

                            <div class="row col-12">

                                <div class="col-12 row">
                                    <div class="col-md-6 p-25 border-bottom"> <strong>Remaining Balance</strong> </div>
                                    <div class="col-md-6 p-25 border-bottom"><?='₹'.$loan_details['remaining_balance'] ?></div>
                                </div>

                            </div>

                            <div class="row col-12">

                                <div class="col-12 row">
                                    <div class="col-md-6 p-25 border-bottom"> <strong>ForeClose Amount </strong> </div>
                                    <div class="col-md-6 p-25 border-bottom"><?='₹'.$loan_details['foreClose_amount'] ?></div>
                                </div>

                            </div>

                            <div class="row col-12">

                                <div class="col-12 row">

                                    <div class="col-md-6 p-25 border-bottom"> <strong>Click To ForeClose Loan</strong> </div>
                                    <div class="col-md-6 p-25 border-bottom">
                                        <button type="button" class="btn btn-primary" onclick="markPaymentReceived( '<?= $loan_details[ 'la_id' ]?>', '<?= $loan_details[ 'foreClose_amount' ]?>' )">
                                            ForeClose Loan
                                        </button>
                                    </div>
                                </div>

                            </div>

				    </div>

				</div>

			</div>

		</div>

	</div>

</div>

<?php include "common/footer.php"?>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script src="<?=base_url()?>/assets/plugins/lightbox2/dist/js/lightbox.min.js" type="text/javascript"></script>

<div class="modal fade" id="userdetailmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

    <div class="modal-content">

    </div>

  </div>

</div>

<script>

    var foreClose_amount = parseInt( '<?= $loan_details[ 'foreClose_amount' ]?>' );

    function markPaymentReceived( loan_id, amount )
    {
        var received_amount = prompt( 'Enter Amount Received' );
        
        received_amount = parseInt( received_amount );

        if( !received_amount ) return;

        if( received_amount != foreClose_amount )
        {
            alert( 'Invalid Received Amount, To ForeClose The Loan, Received Amount Must Be : '+foreClose_amount );
            return;
        }

        if( !confirm( 'Confirm Mark Payment Received ?' ) ) return;

        $.ajax(
        {
            url:'<?= base_url('admin/manage_payments/foreclose_loan' ) ?>',
            type:'POST',
            data:{ 
                'loan_id': loan_id,
                'received_amount': received_amount
            },
            success:function( data )
            {
                var res = JSON.parse( data );

                if( res.success )
                {
                    alert( res.msg );
                    
                    window.location.href = '<?= base_url( 'admin/loan/details/'.$loan_details[ 'la_id' ] )?>';
                }
                else
                {
                    alert( res.msg );
                }
            },
            error:function( jqxhr )
            {
                alert( jqxhr.status+' Server Error' );
            }

        });
    }



</script>
				    