<?php include "common/header.php"?>

<?php include "common/sidebar.php"?>

<div id="content" class="content">

	<ol class="breadcrumb float-xl-right">

		<li class="breadcrumb-item"><a href="javascript:;">Admin</a></li>

		<li class="breadcrumb-item active"><a href="javascript:;">Manage Managers</a></li>

	</ol>

	<h1 class="page-header">Managers List</h1>

	<?php if($suc=$this->session->flashdata('success')) {?>

	<div class="alert alert-success" ><?php echo $suc?></div>

	<?php }?>

	<?php if($fail=$this->session->flashdata('error')) {?>

	<div class="alert alert-danger" ><?php echo $fail?></div>

	<?php }?>

	<div id="create_new_manager" class="panel panel-inverse">

		<div class="panel-heading">

			<h4 class="panel-title">Add New Manager</h4>

		</div>

		<div class="panel-body">

			<form action="<?php echo base_url()?>admin/managers/create_new_manager" method="post" class="margin-bottom-0">

				<div class="form-row">

					<div class="col-md-6 form-group m-b-15 ">
						<label>Manager Name:</label>	
						<input type="text" minlenght="2" maxlength="100" class="form-control form-control-md" placeholder="Manager Name" required name="manager_name" id='manager_name' value="<?php echo set_value( 'manager_name' )?>">
						<?php echo form_error('manager_name', '<p class="alert alert-danger" role="alert">', '</p>'); ?>
					</div>

                    <div class="col-md-6 form-group m-b-15 ">
						<label>Manager Email:</label>	
						<input type="email" minlenght="2" maxlength="100" class="form-control form-control-md" placeholder="Manager Email" required name="manager_email" id='manager_email' value="<?php echo set_value( 'manager_email' )?>">
						<?php echo form_error('manager_email', '<p class="alert alert-danger" role="alert">', '</p>'); ?>
					</div>

                    <div class="col-md-6 form-group m-b-15 ">
						<label>Manager Mobile:</label>	
						<input type="text" minlenght="10" maxlength="10" pattern="^[6-9][0-9]{9}$" class="form-control form-control-md" placeholder="Mobile ex. 9999999999" required name="manager_mobile" id='manager_mobile' value="<?php echo set_value( 'manager_mobile' )?>">
						<?php echo form_error('manager_mobile', '<p class="alert alert-danger" role="alert">', '</p>'); ?>
					</div>

                    <div class="col-md-6 form-group m-b-15 ">
						<label>Manager City:</label>	
						<input type="text" minlenght="2" maxlength="100" class="form-control form-control-md" placeholder="Manager City" required name="manager_city" id='manager_city' value="<?php echo set_value( 'manager_city' )?>">
						<?php echo form_error('manager_city', '<p class="alert alert-danger" role="alert">', '</p>'); ?>
					</div>

                    <div class="col-md-6 form-group m-b-15 ">
						<label>Set Manager's Password:</label>	
						<input type="text" minlenght="6" maxlength="100" class="form-control form-control-md" placeholder="Set Manager's Password" required name="manager_pass_word" id='manager_pass_word' value="<?php echo set_value( 'manager_pass_word' )?>">
						<?php echo form_error('manager_pass_word', '<p class="alert alert-danger" role="alert">', '</p>'); ?>
					</div>


					<div class="login-buttons col-12">
						<button type="submit" class="btn btn-primary btn-sm">Create Manager</button>
					</div>

				</div>

				

			</form>

			

		</div>

	</div>

	<div id="edit_managers" class="panel panel-inverse" data-sortable-id="ui-general-6" style="display: none">

		<div class="panel-heading ui-sortable-handle">

			<h4 class="panel-title">Edit Managers</h4>

		</div>

		<div class="panel-body">

		</div>

	</div>



	<div class="panel panel-inverse">

		<div class="panel-heading">

			<h4 class="panel-title">Managers List</h4>

			<div class="panel-heading-btn">

			

		</div>

	</div>



	<div class="panel-body">

		<div class="table-responsive">



			<table id="data-table-buttons"  class="table table-bordered table-centered table-nowrap">

				<thead>

					<tr>

						<th>S.no</th>

						<th data-toggle='tooltip' data-placement="top" title='Manager Name'>Manager Name</th>

						<th data-toggle='tooltip' data-placement="top" title='Email'>Email</th>
						
						<th data-toggle='tooltip' data-placement="top" title='Mobile'>Mobile</th>
						
						<th data-toggle='tooltip' data-placement="top" title='City'>City</th>

						<th data-toggle='tooltip' data-placement="top" title='Date Created'>Date Created</th>

						<th data-toggle='tooltip' data-placement="top" title='Date Updated'>Date Updated</th>
						
						<th>Edit</th>

						<th>Delete</th>


					</tr>

				</thead>



				<tbody>

				<?php $sno=0;?>

				<?php foreach($data as $record){?>

					<tr>

						<td><?php echo ++$sno ?></td>

						<td><?php echo $record['name']?></td>

						<td><?php echo $record['email']?></td>
						
						<td><?php echo $record['mobile']?></td>

						<td><?php echo $record['city']?></td>

						<td><?php echo date( 'd-M-y H:i A', strtotime( $record['created_at'] ) );?></td>

						<td><?php echo $record['updated_at'] ? date( 'd-M-y H:i A', strtotime( $record['updated_at'] ) ): '' ;?></td>

						<td><button type="button" onclick="view_edit_modal(<?php echo $record['id']?>)" class="btn btn-sm btn-primary"><i class='fa fa-pen'></i></button></td>

						<td><button type="button" onclick="delete_manager(<?php echo $record['id']?>)" class="btn btn-sm btn-danger">Delete</button></td>


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

function delete_manager( id )
{
	if( !confirm( 'Are You Sure You Want To Delete This Manager' ) )
	{
		return;
	}

	$.ajax(
		{
			url: "<?php echo base_url()?>admin/managers/delete_manager/"+id,
			type: "POST",
			data:{},
			success:function(data)
			{
				//  $("#save").removeAttr("disabled");
				var data=JSON.parse(data);

				if(data.error==0)
				{
					alert('Manager deleted successfully !');
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

	url: "<?php echo base_url()?>admin/managers/view_edit_modal/"+id,

	type: "POST",

	success: function(data){

		$("#edit_managers .panel-body").html(data);

		$("#edit_managers").show();

		// $("#add_loan_setting").hide();

		$(window).scrollTop(0);

	}

	});

}

function edit_manager(form)
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
				alert('Manager updated successfully !');
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









