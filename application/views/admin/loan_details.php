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

                                <?php if( !empty( $loan_name ) ):?>

                                <div class="col-12 row">
                                    <div class="col-md-6 p-25 border-bottom"> <strong> <?= $loan_details[ 'loan_type' ]?> Loan Name</strong> </div>
                                    <div class="col-md-6 p-25 border-bottom"><?= $loan_name?></div>
                                </div>
                                    
                                <?php endif;?>

                            </div>

                            <div class="row col-12">

                                <div class="col-md-6 row">
                                    <div class="col-md-6 p-25 border-bottom"> <strong> Amount </strong> </div>
                                    <div class="col-md-6 p-25 border-bottom"><?=( $loan_details['amount']?'₹'. $loan_details['amount']:'NA')?></div>
                                </div>

                                <div class="col-md-6 row">
                                    <div class="col-md-6 p-25 border-bottom"> <strong> Rate Of Interest </strong> </div>
                                    <div class="col-md-6 p-25 border-bottom"><?=$loan_details['rate_of_interest']?>%</div>
                                </div>

                            </div>

                            <div class="row col-12">

                                <div class="col-md-6 row">
                                    <div class="col-md-6 p-25 border-bottom"> <strong> Interest In Rupees( Monthly ) </strong> </div>
                                    <div class="col-md-6 p-25 border-bottom"><?=( $loan_details['monthly_interest']?'₹'. $loan_details['monthly_interest']:'NA')?></div>
                                </div>

                                <div class="col-md-6 row">
                                    <div class="col-md-6 p-25 border-bottom"> <strong> Deduct 1% LIC Amount </strong> </div>
                                    <div class="col-md-6 p-25 border-bottom"><?=( $loan_details['deduct_lic_amount'] )?></div>
                                </div>

                            </div>
                           
                            

                            
                            <div class="row col-12">

                                <div class="col-md-6 row">
                                    <div class="col-md-6 p-25 border-bottom"> <strong> LIC Amount </strong> </div>
                                    <div class="col-md-6 p-25 border-bottom">₹<?=( $loan_details['lic_amount'] )?></div>
                                </div>

                                <div class="col-md-6 row">
                                    <div class="col-md-6 p-25 border-bottom"> <strong> Processing Fee </strong> </div>
                                    <div class="col-md-6 p-25 border-bottom">₹<?=( $loan_details['processing_fee'] )?></div>
                                </div>

                            </div>

                            <div class="row col-12">

                                <div class="col-md-6 row">
                                    <div class="col-md-6 p-25 border-bottom"> <strong> Final Loan Amount </strong> </div>
                                    <div class="col-md-6 p-25 border-bottom">₹<?= $loan_details['loan_closer_amount']?></div>
                                </div>

                                <div class="col-md-6 row">
                                    <div class="col-md-6 p-25 border-bottom"> <strong> Loan Duration </strong> </div>
                                    <div class="col-md-6 p-25 border-bottom"><?= $loan_details['loan_duration']?> Days</div>
                                </div>

                            </div>

                            <div class="row col-12">

                                <div class="col-md-6 row">
                                    <div class="col-md-6 p-25 border-bottom"> <strong> Payment Mode </strong> </div>
                                    <div class="col-md-6 p-25 border-bottom"><?= $loan_details['payment_mode']?></div>
                                </div>
                            
                                <div class="col-md-6 row">
                                    <div class="col-md-6 p-25 border-bottom"> <strong> Emi Amount </strong> </div>
                                    <div class="col-md-6 p-25 border-bottom">₹<?= $loan_details['emi_amount']?></div>
                                </div>

                            </div>

                            <div class="row col-12">

                                <div class="col-md-6 row">
                                    <div class="col-md-6 p-25 border-bottom"> <strong> Payable Amount </strong> </div>
                                    <div class="col-md-6 p-25 border-bottom">₹<?= $loan_details['payable_amt']?></div>
                                </div>

                                <div class="col-md-6 row">
                                    <div class="col-md-6 p-25 border-bottom"> <strong> Requested By Manager </strong> </div>
                                    <div class="col-md-6 p-25 border-bottom"><?= $loan_details[ 'manager_name' ] ? $loan_details[ 'manager_name' ].' ( Manager ) ' : 'NONE' ?></div>
                                </div>

                            </div>

                            <div class="row col-12">

                                <div class="col-md-6 row">
                                    <div class="col-md-6 p-25 border-bottom"> <strong> Remaining Balance  </strong> </div>
                                    <div class="col-md-6 p-25 border-bottom">₹<?= $loan_details[ 'remaining_balance' ] ?></div>
                                </div>

                                <div class="col-md-6 row">
                                    <div class="col-md-6 p-25 border-bottom"> <strong> Loan Status </strong> </div>
                                    <div class="col-md-6 p-25 border-bottom"><?= $loan_details[ 'loan_status' ] ?></div>
                                </div>

                            </div>

                            <div class="row col-12">

                                <div class="col-md-6 row">
                                    <div class="col-md-6 p-25 border-bottom"> <strong>Loan Start Date </strong> </div>
                                    <div class="col-md-6 p-25 border-bottom">
                                        <?= $loan_details[ 'loan_start_date' ] ? date( 'Y-m-d', strtotime( $loan_details[ 'loan_start_date' ] )) : '' ?>
                                    </div>
                                </div>

                                <div class="col-md-6 row">
                                    <div class="col-md-6 p-25 border-bottom"> <strong>Loan End Date</strong> </div>
                                    <div class="col-md-6 p-25 border-bottom">
                                        <?= $loan_details[ 'loan_end_date' ] ? date( 'Y-m-d', strtotime( $loan_details[ 'loan_end_date' ] )) : '' ?>
                                    </div>
                                </div>

                            </div>

                            <div class="row col-12">
                                <div class="col-12 p-25 border-bottom"> <strong> Comment  </strong> </div>
                                <div class="col-12 p-25 border-bottom"><?= $loan_details[ 'reject_comment' ] ?></div>
                            </div>

                            <div class="row col-12">
                                <div class="col-12 p-25 border-bottom"> <strong> User Details  </strong> </div>
                                <div class="col-12 p-25 border-bottom">
                                    <ul class="list-unstyled">
                                        <li class="mt-2"><strong>Name : </strong> <?= $loan_details['first_name'].' '.$loan_details['last_name']?></li>
                                        <li class="mt-2"><strong>Email : </strong> <?= $loan_details['email']?></li>
                                        <li class="mt-2"><strong>Mobile : </strong> <?= $loan_details['mobile']?></li>
                                        <li class="mt-2"><strong>City : </strong> <?= $loan_details['city']?></li>

                                        <button type="button" class="btn btn-info btn-sm my-2" onclick="getUserDetail(<?=$loan_details['userid']?>,`all`)">View Documents</button>
									</ul>
                                </div>
                            </div>

                            <?php if( !in_array( $loan_details[ 'loan_status' ], [ 'PENDING', 'APPROVED', 'REJECTED' ] ) ):?>
                            <div class="row col-12">
                                <div class="col-6 p-25 border-bottom"> <strong> Payment Details  </strong> </div>
                                <div class="col-6 p-25 border-bottom">
                                    <button type="button" class="btn btn-success btn-sm my-2" onclick="getPaymentDetails(<?=$loan_details['la_id']?>)">View Payments</button>
                                </div>
                            </div>
                            <?php endif;?>

                            <?php if( $loan_details[ 'extension_of' ] ):?>
                                <div class="row col-12">
                                    <div class="col-md-6 p-25 border-bottom"> <strong> Parent Loan  </strong> </div>
                                    <div class="col-md-6 p-25 border-bottom">
                                        <a href="<?= base_url( 'admin/loan/details/'.$loan_details[ 'extension_of' ] )?>">
                                            <button type="button" class="btn btn-primary btn-sm my-2">
                                                View Parent Loan
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            <?php endif;?>

                            <div class="row col-12">
                                <div class="col-md-6 p-25 border-bottom"> <strong> Has Extension Request  </strong> </div>
                                <div class="col-md-6 p-25 border-bottom">
                                    <?= !empty( $loan_extension ) ? 'Yes' : 'No' ?>
                                </div>
                            </div>

                            <div class="row col-12">

                                <?php if( !empty( $loan_extension ) ):?>

                                    <div class="row col-md-6">
                                        <div class="col-md-6 p-25 border-bottom"> <strong>Extension Approval Status  </strong> </div>
                                        <div class="col-md-6 p-25 border-bottom">
                                            <?= $loan_extension[ 'extension_status' ] ?>
                                        </div>
                                    </div>

                                <?php endif;?>


                                <?php if( !empty( $loan_details['child_la_id'] ) ) : ?>

                                    <div class="row col-md-6">
                                        <div class="col-md-6 p-25 border-bottom"> <strong>Extended Or Child Loan Details  </strong> </div>
                                        <div class="col-md-6 p-25 border-bottom">

                                            <a href="<?= base_url( 'admin/loan/details/'.$loan_details['child_la_id'] )?>">
                                                <button type="button" class="btn btn-primary btn-sm my-2">
                                                    View Details
                                                </button>
                                            </a>

                                            
                                        </div>
                                    </div>
                                <?php endif;?>

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

    // ---------------------------------------------------------

    function getPaymentDetails( loan_apply_id )
    {

        $.ajax(
        {

            url:'<?=site_url('admin/loan/getPaymentDetails')?>',

            type:'POST',

            data:{ 'la_id': loan_apply_id },

            success:function(data)
            {

            //  console.log(data);

                $('#userdetailmodal .modal-content').html(data);

                $('#userdetailmodal').modal('show');

            },
            error:function(jqxhr, status)
            {
                alert( status+' Server Error' );
            }

        });

    }

    // ---------------------------------------------------------

    function getLoanData()
    {   

        var date_range=$('#date_range_sel').html();

        var data = {date_range:date_range,page:'<?=$sub_page?>'};

        $.ajax({

            method: "POST",

            url: '<?=base_url('admin/loan/getLoanData')?>',

            data:data, 

            success:function(data)

            { 

                $('#filterdata').html(data);

                $('#data-table-buttons').DataTable({

                    dom: '<"dataTables_wrapper dt-bootstrap"<"row"<"col-xl-7 d-block d-sm-flex d-xl-block justify-content-center"<"d-block d-lg-inline-flex mr-0 mr-sm-3"l><"d-block d-lg-inline-flex"B>><"col-xl-5 d-flex d-xl-block justify-content-center"fr>>t<"row"<"col-sm-5"i><"col-sm-7"p>>>',

                    buttons: [ {

                        extend: 'excel',

                        className: 'btn-sm'

                    },{

                    extend: 'colvis',

                    className: 'btn-sm'

                }],

                    responsive: false

                });

                

            }

        })

    

        return false;

    }

    function getUserDetail(userid,status){

        $.ajax({

            url:'<?=site_url('admin/user/getUserDetail')?>',

            type:'POST',

            data:{'userid':userid,'status':status},

            success:function(data){

                //  console.log(data);

                $('#userdetailmodal .modal-content').html(data);

                $('#userdetailmodal').modal('show');

            }

        });

    }

    function updateUserdetails(form){

        var userid = $(form).data('userid');

        var formData = new FormData($(form)[0]);

        console.log(formData);

        $.ajax({

            url:'<?=site_url('admin/user/updateUserdetails/')?>'+userid,

            type:"POST",

            data:formData,

            contentType: false,

            cache: false,

            processData:false,

            success:function(response){

                var json = JSON.parse(response);

                if(json.status == false){

                    getUserDetail(userid,json.doc_type);

                }

                alert(json.message);

            }

        });

        return false;

    }

    function updateloanStatus(select){ 

        var value = $(select).val();

        var la_id = $(select).data('la_id');

        if(confirm('Are You Sure to change the status')){

        var message = '';

        if(value=="REJECTED"){

            message = prompt('Enter The Reason of rejection');

        }

        var data={value:value,la_id:la_id,message:message};

        $.ajax({

            url:'<?=site_url('admin/loan/updateloanStatus')?>',

            type: "POST",

            data:data,

            success:function(data)
            {
                var response = JSON.parse( data );

                if( !response.status )
                {
                    alert( response.message );
                    location.reload();
                }
                else
                {
                    alert( response.message );
                }

            }

        });

        }

        

    }

    function UpdateDocumentStatus(col_name,value,userid){ 

        var message = '';

        if(value=="REJECTED"){

            message = prompt('Enter The Reason of rejection');

        }

        var data={col_name:col_name,value:value,userid:userid,message:message};

        $.ajax({

            url:'<?=site_url('admin/user/UpdateDocumentStatus')?>',

            type: "POST",

            data:data,

            success:function(data){

                console.log(data);

                var json = JSON.parse(data);

                if(json.status == false){

                    getUserDetail(userid,'all');

                    // $('#'+json.col_id).html(json.data);

                    // $('#userdetailmodal').modal('hide');

                }

                alert(json.message);

                //$('#status'+id).html(data);

            }

        });

        

        

    }

    function markPaymentReceived( pay_id, amount )
    {
        var received_amount = prompt( 'Enter Amount Received', amount );
        
        received_amount = parseInt( received_amount );

        if( !received_amount )
        {
            alert( 'Invalid Amount Received Value' );
            return;
        }

        if( !confirm( 'Confirm Mark Payment Received ?' ) )
        {
            return;
        }

        $.ajax(
        {

            url:'<?=site_url('admin/manage_payments/mark_payment_received')?>',

            type:'POST',

            data:{ 
                'pay_id': pay_id,
                'received_amount': received_amount
            },

            success:function( data )
            {
                var res = JSON.parse( data );

                if( res.success )
                {
                    alert( res.message );
                    
                    window.location.reload();
                }
                else
                {
                    alert( res.message );
                }
            },
            error:function( jqxhr )
            {
                alert( jqxhr.status+' Server Error' );
            }

        });
    }



</script>
				    