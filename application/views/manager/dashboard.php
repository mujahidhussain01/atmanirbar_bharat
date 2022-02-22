<?php include "common/header.php" ?>

<?php include "common/sidebar.php" ?>

<?php include "common/sidebarcount.php" ?>

<style>
	.btn-outline-white:hover {
		background-color: green;
		color: orange;
	}
</style>

<!-- BEGIN: Content-->
<div class="app-content content">
	<div class="content-wrapper-before" style="position: relative;">
		<div class="content-header row">
			<div class="content-header-left col-md-4 col-12">
				<h5 class="content-header-title text-center mt-1 text-white">Welcome <?php echo $this->session->manager ?></h5>
			</div>
		</div>
	</div>
	<div class="content-wrapper">

		<div class="content-body container-fluid">

			<div class="row">

				<div class="col-6 pr-0 d-flex justify-content-start">
					<a style="width: 97%;" href="<?php echo base_url() ?>manager/group_loans">
						<button class="py-2 w-100 btn bg-gradient-x-blue-green text-white">
							Group Loan
						</button>
					</a>
				</div>
 
				<div class="col-6 pl-0 d-flex justify-content-end">
					<a style="width: 97%;" href="<?php echo base_url() ?>manager/loans">
						<button class="py-2 w-100 btn bg-gradient-x-purple-blue text-white">
							Claim Loan
						</button>
					</a>
				</div>

			</div>
			<div class="row mt-2">
				<div class="col-xl-3 col-lg-6 col-12">
					<div class="card bg-gradient-x-purple-red">
						<div class="card-content">
							<a href="<?php echo base_url() ?>manager/loans/loans_under_approval">
								<div class="card-body">
									<div class="media d-flex">
										<div class="media-body text-white text-right align-self-bottom mt-1">
											<span class="d-block mb-1 font-medium-1">Loans Under Approval</span>
											<h1 class="text-white mb-0"><?= $loans_under_approval ?></h1>
										</div>
									</div>
								</div>
							</a>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-6 col-12">
					<div class="card bg-gradient-x-purple-blue">
						<div class="card-content">
							<a href="<?php echo base_url() ?>manager/loans/my_running_loans">
								<div class="card-body">
									<div class="media d-flex">

										<div class="media-body text-white text-right align-self-bottom mt-1">
											<span class="d-block mb-1 font-medium-1">My Running Loans</span>
											<h1 class="text-white mb-0"><?= $my_running_loans ?></h1>
										</div>
									</div>
								</div>
							</a>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-6 col-12">
					<div class="card bg-gradient-x-blue-green">
						<div class="card-content">
							<a href="<?php echo base_url() ?>manager/loans/closed_loans">
								<div class="card-body">
									<div class="media d-flex">
										<div class="media-body text-white text-right align-self-bottom mt-1">
											<span class="d-block mb-1 font-medium-1">Closed Loans</span>
											<h1 class="text-white mb-0"><?= $closed_loans ?></h1>
										</div>
									</div>
								</div>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END: Content-->

<?php include "common/footer.php" ?>