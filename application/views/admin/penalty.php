<?php include "common/header.php"?>

<?php include "common/sidebar.php"?>

<div id="content" class="content">

	<ol class="breadcrumb float-xl-right">

		<li class="breadcrumb-item"><a href="javascript:;">Admin</a></li>

		<li class="breadcrumb-item active"><a href="javascript:;">Generate Penalty</a></li>

	</ol>

	<h1 class="page-header">Generate Penalty</h1>

	<?php if($suc=$this->session->flashdata('success')) {?>

	<div class="alert alert-success" ><?php echo $suc?></div>

	<?php }?>

	<?php if($fail=$this->session->flashdata('error')) {?>

	<div class="alert alert-danger" ><?php echo $fail?></div>

	<?php }?>

	<div id="add_loan_setting" class="panel panel-inverse">

		<div class="panel-heading">

			<h4 class="panel-title">Generate Penalty</h4>

		</div>

		<div class="panel-body">

			<form action="<?php echo base_url()?>admin/penalty/generate_penalty" method="post" class="margin-bottom-0">
				<div class="form-row">
					<div class="login-buttons col-12">

						<button type="submit" class="btn btn-primary btn-sm">Click To Generate Penalty</button>

					</div>
				</div>
			</form>
		</div>
	</div>
</div>

</div>

<?php include "common/footer.php"?>








