<?php include "common/header.php"?>

<?php include "common/sidebar.php"?>

<div id="content" class="content">

	<ol class="breadcrumb float-xl-right">

		<li class="breadcrumb-item"><a href="javascript:;">Admin</a></li>

		<li class="breadcrumb-item active"><a href="javascript:;">Group Loan Setting</a></li>

	</ol>

	<h1 class="page-header">Group Loan Settings</h1>

	<?php if($suc=$this->session->flashdata('success')) {?>

	<div class="alert alert-success" ><?php echo $suc?></div>

	<?php }?>

	<?php if($fail=$this->session->flashdata('error')) {?>

	<div class="alert alert-danger" ><?php echo $fail?></div>

	<?php }?>

	<div id="add_loan_setting" class="panel panel-inverse">

		<div class="panel-heading">

			<h4 class="panel-title">Add New Group Loan Settings</h4>

		</div>

		<div class="panel-body">

			<form action="<?php echo base_url()?>admin/group_loan_settings/loan_setting" method="post" class="margin-bottom-0">

				<div class="form-row">

					<div class="col-md-6 form-group m-b-15 ">

						<label>Group Loan Name:</label>	

						<input type="text" minlenght="2" maxlength="100" class="form-control form-control-md" placeholder="Loan Name" required name="loan_name" id='loan_name'>

						<?php echo form_error('loan_name', '<p class="alert alert-danger" role="alert">', '</p>'); ?>

					</div>

					
					<div class="col-md-6 form-group m-b-15 ">

						<label>Amount:</label>	

						<input type="number" step="1" class="form-control form-control-md" placeholder="Amount" required name="amt" id='loan_amount' min="0" step="1">

						<?php echo form_error('amt', '<p class="alert alert-danger" role="alert">', '</p>'); ?>

					</div>

										
					<div class="form-group m-b-15 col-md-6">

						<label>Rate Of Interest ( in % ) :</label>

						<input type="number" class="form-control form-control-md" placeholder="Rate Of Interest ( in % )" required name="rate_of_interest" id='rate_of_interest' min="0" max="100" step=".01">

						<?php echo form_error('rate_of_interest', '<p class="alert alert-danger" role="alert">', '</p>'); ?>

					</div>

					<div class="form-group m-b-15 col-md-6">

						<label>Processing fee (In %):</label>

						<input type="number" step="any" class="form-control form-control-md" placeholder="Processing fees %" required name="process_fee_percent" id='process_fee_percent' min="0" max="100" step=".01">

						<?php echo form_error('process_fee_percent', '<p class="alert alert-danger" role="alert">', '</p>'); ?>

					</div>

					<div class="form-group m-b-15 col-md-6">

						<label>Bouncing Charges ( in % ):</label>

						<input type="number" class="form-control form-control-md" placeholder="Bouncing Charges ( in % )" required name="bouncing_charges_percent" id='bouncing_charges_percent' step=".01" min="0">

						<?php echo form_error('bouncing_charges_percent', '<p class="alert alert-danger" role="alert">', '</p>'); ?>

					</div>

					<div class="form-group m-b-15 col-md-6">

						<label>Bouncing Charges:</label>

						<input type="number" step="any" class="form-control form-control-md" placeholder="Bouncing Charges" required name="bouncing_charges" id='bouncing_charges' min="0" readonly>

						<?php echo form_error('bouncing_charges', '<p class="alert alert-danger" role="alert">', '</p>'); ?>

					</div>

					<div class="form-group m-b-15 col-md-6">

						<label>Loan Duration ( in days ):</label>

						<input type="number" step="1" class="form-control form-control-md" placeholder="Loan Duration ( in days )" required name="loan_duration" id='loan_duration' min="1">

						<?php echo form_error('loan_duration', '<p class="alert alert-danger" role="alert">', '</p>'); ?>

					</div>

					<div class="form-group m-b-15 col-md-6">

						<label>Payment Mode:</label>

						<select type="number" class="form-control form-control-md" placeholder="Payment Mode" required name="payment_mode" id='payment_mode'>
							<option value="" selected readonly>select</option>
							<option value="daily">Daily</option>
							<option value="weekly">Weekly</option>
							<option value="every-15-days">Every 15 Days</option>
							<option value="monthly">Monthly</option>
						</select>

						<?php echo form_error('payment_mode', '<p class="alert alert-danger" role="alert">', '</p>'); ?>

					</div>

					
					<div class="form-group m-b-15 col-md-6">

						<label>Emi Amount:</label>

						<input type="number" step="any" class="form-control form-control-md" placeholder="Emi Amount" required name="emi_amount" id='emi_amount' readonly>

						<?php echo form_error('emi_amount', '<p class="alert alert-danger" role="alert">', '</p>'); ?>

					</div>

					<div class="form-group m-b-15 col-md-6">

						<label>Processing fee:</label>

						<input type="number" step="1" class="form-control form-control-md" placeholder="Processing fees" readonly required name="processing_fee" min="1" id='process_fee_value'>

						<?php echo form_error('process_fee', '<p class="alert alert-danger" role="alert">', '</p>'); ?>

					</div>


					<div class="login-buttons col-12">

						<button type="submit" class="btn btn-primary btn-sm">Save changes</button>

					</div>

				</div>

				

			</form>

			

		</div>

	</div>

	<div id="edit_loan_setting" class="panel panel-inverse" data-sortable-id="ui-general-6" style="display: none">

		<div class="panel-heading ui-sortable-handle">

			<h4 class="panel-title">Edit Group Loan Settings</h4>

		</div>

		<div class="panel-body">

		</div>

	</div>



	<div class="panel panel-inverse">

		<div class="panel-heading">

			<h4 class="panel-title">View all Group Loan Settings</h4>

			<div class="panel-heading-btn">

			

		</div>

	</div>



	<div class="panel-body">

		<div class="table-responsive">



			<table id="data-table-buttons"  class="table table-bordered table-centered table-nowrap">

				<thead>

					<tr>

						<th>S.no</th>

						<th data-toggle='tooltip' data-placement="top" title='Loan Name'>Loan Name</th>

						<th data-toggle='tooltip' data-placement="top" title='Loan Duration ( in days )'>Loan Duration</th>
						
						<th data-toggle='tooltip' data-placement="top" title='Amount paid to the user'>Loan Amount</th>
						
						<th data-toggle='tooltip' data-placement="top" title='Rate of Interest over Loan amount'>Rate Of Interest</th>
						
						<th data-toggle='tooltip' data-placement="top" title='Processing fee is over Loan amount'>Processing fees (In %)</th>

						<th data-toggle='tooltip' data-placement="top" title='Calculated processing fee (in rs)'>Processing fees (in Rs)</th>
						
						<th data-toggle='tooltip' data-placement="top" title='Payment Mode'>Payment Mode</th>
						
						<th data-toggle='tooltip' data-placement="top" title='Emi Amount'>Emi Amount</th>
						
						<th data-toggle='tooltip' data-placement="top" title='Bouncing Charges ( in % )'>Bouncing Charges ( in % )</th>
						
						<th data-toggle='tooltip' data-placement="top" title='Bouncing Charges'>Bouncing Charges</th>

						<th>Status</th>

						<th>Actions</th>

					</tr>

				</thead>



				<tbody>

				<?php $sno=0;?>

				<?php foreach($data as $record){?>

					<tr>

						<td><?php echo ++$sno ?></td>

						<td><?php echo $record['loan_name']?></td>

						<td><?php echo $record['loan_duration']?> Days</td>
						
						<td><?php echo "Rs.".$record['amount']?></td>
						
						<td><?php echo ($record['rate_of_interest']?$record['rate_of_interest']:0)."%"?></td>
						
						<td><?php echo ($record['process_fee_percent']?$record['process_fee_percent']:0)."%"?></td>
						
						<td><?php echo "Rs.".($record['processing_fee']?$record['processing_fee']:0)?></td>
						
						<td><?php echo $record['payment_mode']?></td>

						<td>Rs.<?php echo $record['emi_amount']?></td>

						<td><?php echo $record['bouncing_charges_percent']?>%</td>

						<td>Rs.<?php echo $record['bouncing_charges']?></td>


						<td><button type="button" onclick="delete_loan_settings(<?php echo $record['lsid']?>,'<?=($record['ls_status'] == 'Active'?'Inactive':'Active')?>')" class="btn btn-sm btn-<?=($record['ls_status'] == 'Active'?'success':'danger')?>"><?php echo $record['ls_status']?></button></td>

						<td><button type="button" onclick="view_edit_modal(<?php echo $record['lsid']?>)" class="btn btn-sm btn-primary"><i class='fa fa-pen'></i></button></td>

					</tr>

				<?php } ?>

				</tbody>

			</table>

		</div>

	</div>

</div>

</div>

<?php include "common/footer.php"?>



<script type="text/javascript">




$( document ).ready(function()
{
	$('#data-table-buttons').DataTable({

		dom: '<"row"<"col-sm-5"B><"col-sm-7"fr>>t<"row"<"col-sm-5"i><"col-sm-7"p>>',

		buttons: [ {

			extend: 'excel',

			className: 'btn-sm'

		}, {

			extend: 'pdf',

			className: 'btn-sm'

		}, {

			extend: 'print',

			className: 'btn-sm'

		},{

		extend: 'colvis',

		className: 'btn-sm'

		}],

		responsive: false

		});


	// emi calculate  amount -------------------------------------------

	$(".panel-body").on( "change keyup", "input[type='number'],select" , function()
	{

		// get all input values -----

        var loan_amount_inp = $( this ).parents( '.panel-body' ).find( '#loan_amount' );
        var loan_amount_val = parseInt( $( loan_amount_inp ).val() , 10 );

        var rate_of_interest_inp = $( this ).parents( '.panel-body' ).find( '#rate_of_interest' );
        var rate_of_interest_val = parseFloat( $( rate_of_interest_inp ).val() ).toFixed( 2 );

		if( rate_of_interest_val < 0 )
		{
			$( rate_of_interest_inp ).val( 0 );
			rate_of_interest_val = 0;
		}
		else if( rate_of_interest_val > 100 )
		{
			$( rate_of_interest_inp ).val( 100 );
			rate_of_interest_val = 100;
		}

        var process_fee_percent_inp = $( this ).parents( '.panel-body' ).find( '#process_fee_percent' );
        var process_fee_percent_val = parseFloat( $( process_fee_percent_inp ).val() ).toFixed( 2 );

		if( process_fee_percent_val < 0 )
		{
			$( process_fee_percent_inp ).val( 0 );
			process_fee_percent_val = 0;
		}
		else if( process_fee_percent_val > 100 )
		{
			$( process_fee_percent_inp ).val( 100 );
			process_fee_percent_val = 100;
		}

        var bouncing_charges_percent_inp = $( this ).parents( '.panel-body' ).find( '#bouncing_charges_percent' );
		var bouncing_charges_percent_val = parseFloat( $( bouncing_charges_percent_inp ).val() ).toFixed( 2 );

		if( bouncing_charges_percent_val < 0 )
		{
			$( bouncing_charges_percent_inp ).val( 0 );
			bouncing_charges_percent_val = 0;
		}
		else if( bouncing_charges_percent_val > 100 )
		{
			$( bouncing_charges_percent_inp ).val( 100 );
			bouncing_charges_percent_val = 100;
		}

        var loan_duration_inp = $( this ).parents( '.panel-body' ).find( '#loan_duration' );
        var loan_duration_val = parseInt( $( loan_duration_inp ).val(), 10 ) >= 1 ?
		parseInt( $( loan_duration_inp ).val(), 10 ) : 1 ;

        var payment_mode_inp = $( this ).parents( '.panel-body' ).find( '#payment_mode' );
        var payment_mode_val = $( payment_mode_inp ).val();

		//  get input whose values to be set -----
        var bouncing_charges_inp = $( this ).parents( '.panel-body' ).find( '#bouncing_charges' );
        var emi_amount_inp = $( this ).parents( '.panel-body' ).find( '#emi_amount' );
        var process_fee_inp = $( this ).parents( '.panel-body' ).find( '#process_fee_value' );

		// set initial value to 0
		$( bouncing_charges_inp ).val( 0 );
		$( emi_amount_inp ).val( 0 );
		$( process_fee_inp ).val( 0 );


		if( loan_amount_val > 1 )
		{
			// count bouncing charges ----
			if( bouncing_charges_percent_val > 0 )
			{
				var bouncing_charges_val = Math.ceil( ( loan_amount_val / 100 ) * bouncing_charges_percent_val );
				$( bouncing_charges_inp ).val( bouncing_charges_val );
			}


			// count Processing free charges ----

			var process_fee_val = 0 ;

			if( process_fee_percent_val > 0 )
			{
				var process_fee_val = Math.ceil( ( loan_amount_val / 100 ) * process_fee_percent_val );
				$( process_fee_inp ).val( process_fee_val );
			}


			// count emi Amount --------

			var interest_amount = 0;

			if( rate_of_interest_val > 0 )
			{
				interest_amount = Math.ceil( ( loan_amount_val / 100 ) * rate_of_interest_val );
			}

			// get full payable amount for emi amount
			// var payable_amount = loan_amount_val + process_fee_val + interest_amount;
			var payable_amount = loan_amount_val + interest_amount;

			// set initial emi count
			var total_emi_count = 1;

			// get value to be divided by loan duration to calculate emi amount
			var divided_by = 1;

			if( payment_mode_val == 'weekly' )
			{
				divided_by = 7;
			}
			else if( payment_mode_val == 'every-15-days' )
			{
				divided_by = 15;
			}
			else if( payment_mode_val == 'monthly' )
			{
				divided_by = 30;
			}

			total_emi_count = Math.floor( loan_duration_val / divided_by ) ;

			if( total_emi_count >= 1 )
			{
				$( emi_amount_inp ).val( Math.ceil( payable_amount / total_emi_count ) );
			}
			else
			{
				$( emi_amount_inp ).val( payable_amount );
			}
			
		}
	});


});

function delete_loan_settings(lsid,status) {



$.ajax({

url: "<?php echo base_url()?>admin/group_loan_settings/update_loan_setting/"+lsid,

type: "POST",

data:{

	ls_status:status

},

success: function(dataResult){

	var dataResult = JSON.parse(dataResult);

	if(dataResult.error==0)

	{	



		alert('Status updated successfully !');

		location.reload();					

	}

	else

	{

		alert('Error in Updating Status!');

	}

}

});

}

function view_edit_modal(lsid) {

$.ajax({

url: "<?php echo base_url()?>admin/group_loan_settings/View_edit_modal/"+lsid,

type: "POST",

success: function(data){

	$("#edit_loan_setting .panel-body").html(data);

	$("#edit_loan_setting").show();

	// $("#add_loan_setting").hide();

	$(window).scrollTop(0);

}

});

}

function edit_loan(form)

{

// 		$("#save").attr("disabled","disabled");

var formdata=$(form).serialize();

console.log(formdata);

$.ajax({

url:$(form).data('action'),

type: "POST",

data:formdata,

success:function(data)

{

	//  $("#save").removeAttr("disabled");

	var data=JSON.parse(data);

	if(data.error==0)

	{

		alert('Data updated successfully !');

		location.reload();

	}

	else

	{

		alert('Error in Updating data!');

	}

}


	
});



return false;

}



</script>









