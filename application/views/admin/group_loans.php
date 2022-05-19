<?php include "common/header.php"?>

<?php include "common/sidebar.php"?>

<div id="content" class="content">

	<ol class="breadcrumb float-xl-right">

		<li class="breadcrumb-item"><a href="javascript:;">Admin</a></li>

		<li class="breadcrumb-item active"><a href="javascript:;">Manage Group Loans</a></li>

	</ol>

	<h1 class="page-header">Group Loans List</h1>

	<?php if($this->session->flashdata('success')) {?>

	<div class="alert alert-success" ><?php echo $this->session->flashdata('success')?></div>

	<?php }?>

	<?php if($this->session->flashdata('error')) {?>

	<div class="alert alert-danger" ><?php echo $this->session->flashdata('error')?></div>

	<?php }?>

	<div id="create_new_group_loan" class="panel panel-inverse">

		<div class="panel-heading">

			<h4 class="panel-title">Add New Group</h4>

		</div>

		<div class="panel-body">

			<form action="<?php echo base_url()?>admin/group_loans/create_new_group_loan" method="post" class="margin-bottom-0">

				<div class="form-row">

					<div class="col-md-6 form-group m-b-15 ">
						<label>Group Name:</label>	
						<input type="text" minlenght="2" maxlength="100" class="form-control form-control-md" placeholder="Group Name" required name="group_name" id='group_name' value="<?php echo set_value( 'group_name' )?>">
						<?php echo form_error('group_name', '<p class="alert alert-danger" role="alert">', '</p>'); ?>
					</div>

															
					<div class="col-md-6 form-group m-b-15">

						<label>Rate Of Interest( in % ) :</label>

						<input type="number" class="form-control form-control-md" placeholder="Rate Of Interest ( in % )" required name="rate_of_interest" id='rate_of_interest' min="0" max="100" step=".01" value="<?= ( set_value( 'rate_of_interest' ) ) ?>">

						<?php echo form_error('rate_of_interest', '<p class="alert alert-danger" role="alert">', '</p>'); ?>

					</div>

					<div class="col-md-6 form-group m-b-15">

						<label>Processing Fee Percent( in % ) :</label>

						<input type="number" class="form-control form-control-md" placeholder="Processing Fee Percent ( in % )" required name="process_fee_percent" id='process_fee_percent' min="0" max="100" step=".01" value="<?= ( set_value( 'process_fee_percent' ) ) ?>">

						<?php echo form_error('process_fee_percent', '<p class="alert alert-danger" role="alert">', '</p>'); ?>

					</div>

					<div class="col-md-6 form-group m-b-15">

						<label>Bouncing Charges Percent( in % ) :</label>

						<input type="number" class="form-control form-control-md" placeholder="Bouncing Charges Percent ( in % )" required name="bouncing_charges_percent" id='bouncing_charges_percent' min="0" max="100" step=".01" value="<?= ( set_value( 'bouncing_charges_percent' ) ) ?>">

						<?php echo form_error('bouncing_charges_percent', '<p class="alert alert-danger" role="alert">', '</p>'); ?>

					</div>

					<div class="login-buttons col-12">
						<button type="submit" class="btn btn-primary btn-sm">Create Group</button>
					</div>

				</div>

				

			</form>

			

		</div>

	</div>

	<div id="edit_group_loan" class="panel panel-inverse" data-sortable-id="ui-general-6" style="display: none">

		<div class="panel-heading ui-sortable-handle">

			<h4 class="panel-title">Edit Group</h4>

		</div>

		<div class="panel-body">

		</div>

	</div>



	<div class="panel panel-inverse">

		<div class="panel-heading">

			<h4 class="panel-title">Group List</h4>

			<div class="panel-heading-btn">

			

		</div>

	</div>



	<div class="panel-body">

		<div class="table-responsive">

			<table id="data-table-buttons"  class="table table-bordered table-centered table-nowrap">

				<thead>

					<tr>

						<th>S.no</th>

						<th data-toggle='tooltip' data-placement="top" title='Group Name'>Group Name</th>
						
						<th data-toggle='tooltip' data-placement="top" title='Total Loan Amount' >Total Loan Amount</th>

						<th data-toggle='tooltip' data-placement="top" title='Total Amount Disbursed' >Total Amount Disbursed</th>

						<th data-toggle='tooltip' data-placement="top" title='Total Remaining Balance' >Total Remaining Balance</th>

						<th data-toggle='tooltip' data-placement="top" title='Active Users' >Active Users</th>

						<th data-toggle='tooltip' data-placement="top" title='Pending Users' >Pending Users</th>
						
						<th data-toggle='tooltip' data-placement="top" title='Rate Of Interest ( In % )' >Rate Of Interest <br> ( In % )</th>

						<th data-toggle='tooltip' data-placement="top" title='Processing Fee ( In % )' >Processing Fee <br> ( In % )</th>
						
						<th data-toggle='tooltip' data-placement="top" title='Bouncing Changer ( In % )' >Bouncing Changes <br> ( In % )</th>

						<th data-toggle='tooltip' data-placement="top" title='View Loans' >View Loans</th>


						<th data-toggle='tooltip' data-placement="top" title='Date Created'>Date Created</th>

						<th data-toggle='tooltip' data-placement="top" title='Date Updated'>Date Updated</th>
						
						<th>Edit</th>

					</tr>

				</thead>



				<tbody>

				<?php $sno=0;?>

				<?php foreach($data as $record){?>

					<tr>

						<td><?php echo ++$sno ?></td>

						<td><?php echo $record['name']?></td>

						<td>₹<?php echo $record['total_amount']?></td>

						<td>₹<?php echo $record['amount_payed']?></td>

						<td>₹<?php echo $record['remaining_balance']?></td>

						<td><?= $this->Group_loans_model->get_group_loan_active_user_count( $record[ 'id' ] ) ?> Users</td>

						<td><?= $this->Group_loans_model->get_group_loan_pending_user_count( $record[ 'id' ] ) ?> Users</td>

						<td><?php echo $record['rate_of_interest']?>%</td>

						<td><?php echo $record['process_fee_percent']?>%</td>

						<td><?php echo $record['bouncing_charges_percent']?>%</td>

						<td> <a href="<?= base_url( 'admin/loan/all_loan/GROUP/'.$record[ 'id' ] )?>" class="btn btn-primary">View Loans</a> </td>

						<td><?php echo date( 'd-M-Y, H:i A', strtotime( $record['created_at'] ) );?></td>

						<td><?php echo $record['updated_at'] ? date( 'd-M-Y, H:i A', strtotime( $record['updated_at'] ) ): '' ;?></td>

						<td><button type="button" onclick="view_edit_modal(<?php echo $record['id']?>)" class="btn btn-sm btn-primary"><i class='fa fa-pen'></i></button></td>


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
});

function delete_group_loan( id )
{
	if( !confirm( 'Are You Sure You Want To Delete This Group' ) )
	{
		return;
	}

	$.ajax(
		{
			url: "<?php echo base_url()?>admin/group_loans/delete_group_loan/"+id,
			type: "POST",
			data:{},
			success:function(data)
			{
				//  $("#save").removeAttr("disabled");
				var data=JSON.parse(data);

				if(data.error==0)
				{
					alert('Group deleted successfully !');
					location.reload();
				}
				else
				{
					alert('Error in Updating data! : '+data.msg);
				}
			},
			error: function( jqxhr, statusText )
			{
				alert( 'Server Error : '+statusText )
			}
		});

}

function view_edit_modal(id) {

	$.ajax({

	url: "<?php echo base_url()?>admin/group_loans/view_edit_modal/"+id,

	type: "POST",

	success: function(data){

		$("#edit_group_loan .panel-body").html(data);

		$("#edit_group_loan").show();

		// $("#add_loan_setting").hide();

		$(window).scrollTop(0);

	}

	});

}

function edit_group_loan(form)
{

	var formdata=$(form).serialize();

	$.ajax(
		{

		url:$(form).data('action'),

		type: "POST",

		data:formdata,

		success:function(data)
		{
			//  $("#save").removeAttr("disabled");
			var data=JSON.parse(data);

			if(data.error==0)
			{
				alert('Group updated successfully !');
				location.reload();
			}
			else
			{
				alert('Error in Updating data! : '+data.msg);
			}
		},
		error: function( jqxhr, statusText )
		{
			alert( 'Server Error : '+statusText )
		}
	});

	return false;
}



</script>









