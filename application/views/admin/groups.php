<?php include "common/header.php"?>

<?php include "common/sidebar.php"?>

<div id="content" class="content">

	<ol class="breadcrumb float-xl-right">

		<li class="breadcrumb-item"><a href="javascript:;">Admin</a></li>

		<li class="breadcrumb-item active"><a href="javascript:;">Manage Groups</a></li>

	</ol>

	<h1 class="page-header">Groups List</h1>

	<?php if($suc=$this->session->flashdata('success')) {?>

	<div class="alert alert-success" ><?php echo $suc?></div>

	<?php }?>

	<?php if($fail=$this->session->flashdata('error')) {?>

	<div class="alert alert-danger" ><?php echo $fail?></div>

	<?php }?>

	<div id="create_new_group" class="panel panel-inverse">

		<div class="panel-heading">

			<h4 class="panel-title">Add New Group</h4>

		</div>

		<div class="panel-body">

			<form action="<?php echo base_url()?>admin/groups/create_new_group" method="post" class="margin-bottom-0">

				<div class="form-row">

					<div class="col-md-6 form-group m-b-15 ">
						<label>Group Name:</label>	
						<input type="text" minlenght="2" maxlength="100" class="form-control form-control-md" placeholder="Group Name" required name="group_name" id='group_name' value="<?php echo set_value( 'group_name' )?>">
						<?php echo form_error('group_name', '<p class="alert alert-danger" role="alert">', '</p>'); ?>
					</div>

					<div class="login-buttons col-12">
						<button type="submit" class="btn btn-primary btn-sm">Create Group</button>
					</div>

				</div>

				

			</form>

			

		</div>

	</div>

	<div id="edit_groups" class="panel panel-inverse" data-sortable-id="ui-general-6" style="display: none">

		<div class="panel-heading ui-sortable-handle">

			<h4 class="panel-title">Edit Groups</h4>

		</div>

		<div class="panel-body">

		</div>

	</div>



	<div class="panel panel-inverse">

		<div class="panel-heading">

			<h4 class="panel-title">Groups List</h4>

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

function delete_group( id )
{
	if( !confirm( 'Are You Sure You Want To Delete This Group' ) )
	{
		return;
	}

	$.ajax(
		{
			url: "<?php echo base_url()?>admin/groups/delete_group/"+id,
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

	url: "<?php echo base_url()?>admin/groups/view_edit_modal/"+id,

	type: "POST",

	success: function(data){

		$("#edit_groups .panel-body").html(data);

		$("#edit_groups").show();

		// $("#add_loan_setting").hide();

		$(window).scrollTop(0);

	}

	});

}

function edit_group(form)
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









