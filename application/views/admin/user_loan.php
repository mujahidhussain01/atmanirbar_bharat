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

				        <div class='col-12 col-lg-5 mb-3'>

        				    <div id="advance-daterange" class="btn btn-white btn-block text-left">

                            <i class="fa fa-caret-down pull-right m-t-2"></i>

                            <span id="date_range_sel"></span>

                            </div>

				        </div>

				        <div class='col-12' id='filterdata'>

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

<script type="text/javascript">



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


    var start = moment().subtract(29, 'days');

    var end = moment();

    function cb(start, end) {

        $('#advance-daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

        getLoanData();

    }

    $('#advance-daterange').daterangepicker({

        startDate: start,

        endDate: end,

        ranges: {

            'Today': [moment(), moment()],

            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],

            'Last 7 Days': [moment().subtract(6, 'days'), moment()],

            'Last 30 Days': [moment().subtract(29, 'days'), moment()],

            'This Month': [moment().startOf('month'), moment().endOf('month')],

            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]

        },

        opens: 'right',

    }, cb);



    cb(start, end);

    function getLoanData(){   

        var date_range=$('#date_range_sel').html();

        var data = {
            date_range: date_range,
            page:'<?=$sub_page?>',
            type:'<?=$type?>',
            loan_id:'<?=$loan_id?>',
        };

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
                    alert( res.msg );
                    
                    window.location.reload();
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