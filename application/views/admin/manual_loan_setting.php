<?php include "common/header.php"?>

<?php include "common/sidebar.php"?>

<div id="content" class="content">

	<ol class="breadcrumb float-xl-right">

		<li class="breadcrumb-item"><a href="javascript:;">Admin</a></li>

		<li class="breadcrumb-item active"><a href="javascript:;">Manual Loan Setting</a></li>

	</ol>

	<h1 class="page-header">Manual Loan Setting</h1>

	<?php if($suc=$this->session->flashdata('success')) {?>

	<div class="alert alert-success" ><?php echo $suc?></div>

	<?php }?>

	<?php if($fail=$this->session->flashdata('error')) {?>

	<div class="alert alert-danger" ><?php echo $fail?></div>

	<?php }?>

	<div id="add_loan_setting" class="panel panel-inverse">

		<div class="panel-heading">

			<h4 class="panel-title">Manual Loan Setting</h4>

		</div>

		<div class="panel-body">

			<form action="<?php echo base_url()?>admin/manual_loan_setting/update_manual_loan_setting/<?= $manual_loan_setting[ 'id' ]?>" method="post" class="margin-bottom-0">

				<div class="form-row">

										
					<div class="form-group m-b-15 col-12">

						<label>Rate Of Interest For All Manual Loans ( in % ) :</label>

						<input type="number" class="form-control form-control-md" placeholder="Rate Of Interest ( in % )" required name="rate_of_interest" id='rate_of_interest' min="0" max="100" step=".01" value="<?= ( set_value( 'rate_of_interest' ) ?  set_value( 'rate_of_interest' ) : $manual_loan_setting[ 'rate_of_interest' ] ) ?>">

						<?php echo form_error('rate_of_interest', '<p class="alert alert-danger" role="alert">', '</p>'); ?>

					</div>

					<div class="form-group m-b-15 col-12">

						<label>Processing Fee Percent For All Manual Loans ( in % ) :</label>

						<input type="number" class="form-control form-control-md" placeholder="Processing Fee Percent ( in % )" required name="process_fee_percent" id='process_fee_percent' min="0" max="100" step=".01" value="<?= ( set_value( 'process_fee_percent' ) ?  set_value( 'process_fee_percent' ) : $manual_loan_setting[ 'process_fee_percent' ] ) ?>">

						<?php echo form_error('process_fee_percent', '<p class="alert alert-danger" role="alert">', '</p>'); ?>

					</div>

					<div class="form-group m-b-15 col-12">

						<label>Bouncing Charges Percent For All Manual Loans ( in % ) :</label>

						<input type="number" class="form-control form-control-md" placeholder="Bouncing Charges Percent ( in % )" required name="bouncing_charges_percent" id='bouncing_charges_percent' min="0" max="100" step=".01" value="<?= ( set_value( 'bouncing_charges_percent' ) ?  set_value( 'bouncing_charges_percent' ) : $manual_loan_setting[ 'bouncing_charges_percent' ] ) ?>">

						<?php echo form_error('bouncing_charges_percent', '<p class="alert alert-danger" role="alert">', '</p>'); ?>

					</div>


					<div class="login-buttons col-12">

						<button type="submit" class="btn btn-primary btn-sm">Save changes</button>

					</div>

				</div>

			</form>
		</div>
	</div>
</div>

</div>

<?php include "common/footer.php"?>








