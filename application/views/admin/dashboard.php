<?php include "common/header.php" ?>

<?php include "common/sidebar.php" ?>

<style>
	a:hover {

		color: #0d5bdd;

		text-decoration: none;

	}

	@media(min-width:990px) {

		.h-xl-90 {

			height: 90%;

		}

		.widget-stats,
		.widget.widget-stats {

			position: relative;

			color: #fff;

			padding: 5px;

			-webkit-border-radius: 6px;

			border-radius: 6px;

		}

		.widget-stats .stats-title,
		.widget.widget-stats .stats-title {

			position: relative;

			margin: 0 0 2px;

			font-size: 16px;

			font-weight: 500;

			color: #ffffff;

		}

		.widget-stats .stats-number,
		.widget.widget-stats .stats-number {

			font-size: 24px;

			margin-bottom: 12px;

			font-weight: 500;

			letter-spacing: 1px;

			line-height: 1;

			margin-bottom: 0;

		}

	}

	.table td,
	.table th {

		padding: 8px;

		vertical-align: top;

		border-top: 1px solid #dadce0;

		white-space: nowrap;

	}



	.v-scroll {

		max-height: 345px;

		overflow-y: scroll;

	}
</style>

<div id="content" class="content">

	<ol class="breadcrumb float-xl-right">

		<li class="breadcrumb-item"><a href="<?= site_url('admin/') ?>">Home</a></li>

		<li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>

	</ol>

	<h1 class="page-header">Dashboard </h1>

	<div class="row">

		<div class="col-xl-3 col-md-6">

			<a href="<?= site_url('admin/loan') ?>">

				<div class="widget widget-stats bg-blue">

					<div class="stats-icon"><i class="fa fa-desktop"></i></div>

					<div class="stats-info">

						<h4>Pending Loans</h4>

						<p><?= $pendingloans; ?></p>

					</div>

				</div>

			</a>

		</div>

		<div class="col-xl-3 col-md-6">

			<a href="<?= site_url('admin/loan/approved_loan') ?>">

				<div class="widget widget-stats bg-info">

					<div class="stats-icon"><i class="fa fa-link"></i></div>

					<div class="stats-info">

						<h4>Approved Loans</h4>

						<p><?= $approvedloans; ?></p>

					</div>

				</div>

			</a>

		</div>

		<div class="col-xl-3 col-md-6">

			<a href="<?= site_url('admin/loan/running_loan') ?>">

				<div class="widget widget-stats bg-info">

					<div class="stats-icon"><i class="fas fa-tasks"></i></div>

					<div class="stats-info">

						<h4>Running Loans</h4>

						<p><?= $runningloans; ?></p>

					</div>

				</div>

			</a>

		</div>

	</div>

	<div class="row">

		<div class="col-xl-3 col-md-6">

			<a href="<?= site_url('admin/manage_payments/todays_payments') ?>">

				<div class="widget widget-stats bg-info">

					<div class="stats-icon"><i class="fa fa-funnel-dollar"></i></div>

					<div class="stats-info">

						<h4>Todays Payments</h4>

						<p><?= $todays_payment_count; ?></p>

					</div>

				</div>

			</a>

		</div>

		<div class="col-xl-3 col-md-6">

			<a href="<?= site_url('admin/manage_payments/upcoming_payments') ?>">

				<div class="widget widget-stats bg-warning">

					<div class="stats-icon"><i class="fa fa-funnel-dollar"></i></div>

					<div class="stats-info">

						<h4>Upcoming Payments</h4>

						<p><?= $upcoming_payment_count; ?></p>

					</div>

				</div>

			</a>

		</div>

	</div>
	<hr>
	<div class="row">

		<div class="col-xl-3 col-12">

			<a href="<?= site_url('admin/user/pending') ?>">

				<div class="widget widget-stats bg-warning h-xl-90">

					<div class="stats-content">

						<div class="stats-icon stats-icon-lg"><i class="fa fa-user fa-fw"></i></div>

						<div class="stats-title">Pending Users</div>

						<div class="stats-number"><?= $pendingusers; ?></div>

					</div>

				</div>

			</a>

		</div>


		<div class="col-xl-3 col-12">

			<a href="<?= site_url('admin/user/document_pending') ?>">

				<div class="widget widget-stats bg-blue h-xl-90">

					<div class="stats-content">

						<div class="stats-icon stats-icon-lg"><i class="fa fa-user fa-fw"></i></div>

						<div class="stats-title">Document Pending Users</div>

						<div class="stats-number"><?= $documentpendingusers; ?></div>

					</div>

				</div>

			</a>

		</div>

		<div class="col-xl-3 col-12">

			<a href="<?= site_url('admin/user/approved') ?>">

				<div class="widget widget-stats bg-success h-xl-90">

					<div class="stats-content">

						<div class="stats-icon stats-icon-lg"><i class="fa fa-user fa-fw"></i></div>

						<div class="stats-title">Approved Users</div>

						<div class="stats-number"><?= $approvedusers; ?></div>

					</div>

				</div>

			</a>

		</div>

		<div class="col-xl-3 col-12">

			<a href="<?= site_url('admin/user/rejected') ?>">

				<div class="widget widget-stats bg-danger h-xl-90">

					<div class="stats-content">

						<div class="stats-icon stats-icon-lg"><i class="fa fa-user fa-fw"></i></div>

						<div class="stats-title">Rejected Users</div>

						<div class="stats-number"><?= $rejectedusers; ?></div>

					</div>

				</div>

			</a>

		</div>

	</div>
	<hr>
	<div class="row">

		<div class="col-xl-3 col-md-6">

			<a href="<?= site_url('admin/Enquiries?type=FEEDBACK') ?>">

				<div class="widget widget-stats bg-info">

					<div class="stats-icon"><i class="fas fa-info-circle"></i></i></div>

					<div class="stats-info">

						<h4>New Feedback</h4>

						<p><?= $feedback_count; ?></p>

					</div>

				</div>

			</a>

		</div>

		<div class="col-xl-3 col-md-6">

			<a href="<?= site_url('admin/Enquiries?type=HELP') ?>">

				<div class="widget widget-stats bg-warning">

					<div class="stats-icon"><i class="far fa-question-circle"></i></div>

					<div class="stats-info">

						<h4>New Help</h4>

						<p><?= $help_count; ?></p>

					</div>

				</div>

			</a>

		</div>

	</div>


</div>

<?php include "common/footer.php" ?>



<script src="<?= base_url() ?>assets/plugins/apexcharts/dist/apexcharts.min.js" type="text/javascript"></script>

<!--<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>-->

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<div class="modal fade" id="userdetailmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

	<div class="modal-dialog modal-dialog-centered" role="document">

		<div class="modal-content">

		</div>

	</div>

</div>