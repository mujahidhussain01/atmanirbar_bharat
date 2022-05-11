<style>
	.sidebar .sub-menu>li:first-child:before {

		top: -10px;

	}

	.sidebar .sub-menu>li:last-child:before {

		bottom: auto;

		height: 13px;

	}

	.sidebar .sub-menu>li:before {

		content: '';

		position: absolute;

		left: -13px;

		top: 0;

		bottom: 0;

		width: 2px;

		background: #dddddd;

	}

	.sidebar .sub-menu>li:after {

		content: '';

		position: absolute;

		left: 0;

		width: 6px;

		height: 6px;

		border: 1px solid rgba(255, 255, 255, .6);

		top: 11px;

		margin-top: -2px;

		z-index: 10;

		background: #ddd;

		-webkit-border-radius: 4px;

		border-radius: 4px;

	}

	.sidebar .sub-menu>li>a:after {

		content: '';

		position: absolute;

		left: -11px;

		top: 11px;

		width: 11px;

		height: 2px;

		background: #ddd;

	}

	.sidebar .nav>li>a .badge.badge-warning {

		background: #ff9800 !important;

		padding: 2px 10px !important;

		color: #fff;

	}

	.sidebar .nav>li>a>span {

		/*display: inline-block!important;*/

		/*display: -ms-flexbox;*/

		/* display: flex; */

		/* -webkit-box-flex: 1; */

		/*-ms-flex: 1;*/

		/* flex: 1; */

		/* -webkit-flex-wrap: wrap; */

		/*-ms-flex-wrap: wrap;*/

		/* flex-wrap: wrap; */

	}
</style>

<div id="sidebar" class="sidebar">

	<div data-scrollbar="true" data-height="100%">



		<ul class="nav ">

			<li class="nav-header">Dashboard</li>

			<li class="<?= (@$page == 'dashboard' ? 'active' : '') ?>">

				<a href="<?= site_url('admin/') ?>">

					<i class="fa fa-home"></i>

					<span>Dashboard</span>

				</a>

			</li>

			<hr class="mt-4">

			<!-- temp loan -->
			<li class="has-sub <?= (@$page == 'loans' ? 'active' : '') ?>">

				<a href="javascript:;">

					<b class="caret"></b>

					<i class="fa fa-piggy-bank"></i>

					<span>Loans</span>

				</a>

				<ul class="sub-menu" style="display: block;">

					<li <?= (@$sub_page == 'new_loan' ? 'class="active"' : '') ?>><a class='text-warning' href="<?= site_url('admin/loan/') ?>">New Loans <span class="badge badge-warning pull-right"><?= $pendingloans; ?></span></a></li>

					<li <?= (@$sub_page == 'approved_loan' ? 'class="active"' : '') ?>><a class='text-success' href="<?= site_url('admin/loan/approved_loan') ?>">Approved Loans <span class="badge badge-success pull-right"><?= $approvedloans; ?></span></a></li>

					<li <?= (@$sub_page == 'running_loan' ? 'class="active"' : '') ?>><a class='text-blue' href="<?= site_url('admin/loan/running_loan') ?>">Running Loans <span class="badge badge-blue pull-right"><?= $runningloans; ?></span></a></li>

					<li <?= (@$sub_page == 'rejected_loan' ? 'class="active"' : '') ?>><a class='text-danger' href="<?= site_url('admin/loan/rejected_loan') ?>">Rejected Loans <span class="badge badge-danger pull-right"><?= $rejectedloans; ?></span></a></li>

					<li <?= (@$sub_page == 'paid_loan' ? 'class="active"' : '') ?>><a class='text-success' href="<?= site_url('admin/loan/paid_loan') ?>">Closed Loans <span class="badge badge-success pull-right"><?= $paidloans; ?></span></a></li>

					<li <?= (@$sub_page == 'all_loan' ? 'class="active"' : '') ?>><a class='text-blue' href="<?= site_url('admin/loan/all_loan') ?>">All loan</a></li>

				</ul>

			</li>



			<!-- temp loan -->
			<li class="has-sub <?= (@$page == 'extensions' ? 'active' : '') ?>">

				<a href="javascript:;">

					<b class="caret"></b>

					<i class="fa fa-list-ol" aria-hidden="true"></i>

					<span>Extension Requests</span>

				</a>

				<ul class="sub-menu" style="display: block;">

					<li <?= (@$sub_page == 'new_loan' ? 'class="active"' : '') ?>><a class='text-warning' href="<?= site_url('admin/extensions/new_extensions') ?>">New Requests <span class="badge badge-warning pull-right"><?= $new_extensions; ?></span></a></li>

					<li <?= (@$sub_page == 'approved_loan' ? 'class="active"' : '') ?>><a class='text-success' href="<?= site_url('admin/extensions/approved_extensions') ?>">Approved Requests <span class="badge badge-success pull-right"><?= $approved_extensions; ?></span></a></li>

					<li <?= (@$sub_page == 'rejected_loan' ? 'class="active"' : '') ?>><a class='text-danger' href="<?= site_url('admin/extensions/rejected_extensions') ?>">Rejected Requests <span class="badge badge-danger pull-right"><?= $rejected_extensions; ?></span></a></li>

				</ul>

			</li>

			<!-- Todays Payments -->
			<li class="has-sub <?= (@$page == 'payments' ? 'active' : '') ?>">

				<a href="javascript:;">

					<b class="caret"></b>

					<i class="fas fa-funnel-dollar"></i>

					<span>Payments</span>

				</a>

				<ul class="sub-menu" style="display: block;">

					<li <?= (@$sub_page == 'todays_payments' ? 'class="active"' : '') ?>><a class='text-warning' href="<?= site_url('admin/manage_payments/todays_payments') ?>">Today's Payments <span class="badge badge-warning pull-right"><?= $todays_payment_count; ?></span></a></li>

					<li <?= (@$sub_page == 'payed_payments' ? 'class="active"' : '') ?>><a class='text-warning' href="<?= site_url('admin/manage_payments/payed_payments') ?>">Payed Payments <span class="badge badge-warning pull-right"><?= $payed_payment_count; ?></span></a></li>

					<li <?= (@$sub_page == 'upcoming_payments' ? 'class="active"' : '') ?>><a class='text-warning' href="<?= site_url('admin/manage_payments/upcoming_payments') ?>">Upcoming Payments <span class="badge badge-warning pull-right"><?= $upcoming_payment_count; ?></span></a></li>

				</ul>

			</li>

			<hr class="mt-4">






			<li class="has-sub <?= (@$page == 'app_installs' ? 'active' : '') ?>">

				<a href="javascript:;">

					<b class="caret"></b>

					<i class="fab fa-app-store"></i>

					<span>Users</span>

				</a>

				<ul class="sub-menu" style="display: block;">

					<li <?= (@$sub_page == 'pending_users' ? 'class="active"' : '') ?>><a class='text-warning' href="<?= site_url('admin/user/pending') ?>">Pending <span class="badge badge-warning pull-right"><?= $pendingusers; ?></span></a></li>

					<li <?= (@$sub_page == 'document_pending' ? 'class="active"' : '') ?>><a class='text-info' href="<?= site_url('admin/user/document_pending') ?>">Document Pending <span class="badge badge-warning pull-right"><?= $documentpendingusers; ?></span></a></li>


					<li <?= (@$sub_page == 'approved_users' ? 'class="active"' : '') ?>><a class='text-success' href="<?= site_url('admin/user/approved') ?>">Approved <span class="badge badge-success pull-right"><?= $approvedusers; ?></span></a></li>

					<li <?= (@$sub_page == 'rejected_users' ? 'class="active"' : '') ?>><a class='text-danger' href="<?= site_url('admin/user/rejected') ?>">Rejected <span class="badge badge-danger pull-right"><?= $rejectedusers; ?></span></a></li>

					<li <?= (@$sub_page == 'all_users' ? 'class="active"' : '') ?>><a class='text-info' href="<?= site_url('admin/user/') ?>">All <span class="badge badge-info pull-right"><?= $allusers; ?></span></a></li>

				</ul>

			</li>

			<li class="<?= (@$page == 'managers' ? 'active' : '') ?> my-3">

				<a href="<?php echo base_url() ?>admin/managers">

					<i class="fas fa-user-tie"></i>

					<span>Managers</span>

				</a>

			</li>

			<hr class="mt-4">


			<li class="<?= (@$page == 'loan_setting' ? 'active' : '') ?>">

				<a href="<?php echo base_url() ?>admin/settings/view_loan_setting">

					<i class="fa fa-cog fa-stack-1"></i>

					<span>Normal Loan settings</span>

				</a>

			</li>

			<li class="<?= (@$page == 'group_loan_settings' ? 'active' : '') ?> my-3">

			<a href="<?php echo base_url() ?>admin/group_loan_settings/view_group_loan_setting">

				<i class="fas fa-users"></i>

				<span>Group Loan Settings</span>

			</a>

			</li>

			<li class="<?= (@$page == 'manual_loan_setting' ? 'active' : '') ?>">

				<a href="<?php echo base_url() ?>admin/manual_loan_setting/view_manual_loan_setting">

					<i class="fa fa-cog fa-stack-1"></i>

					<span>Manual Loan settings</span>

				</a>

				</li>

<hr class="mt-4">

			<li class="<?= (@$page == 'feedback' ? 'active' : '') ?>">

				<a href="<?php echo base_url() ?>admin/Enquiries?type=FEEDBACK">

					<i class="fa fa-envelope-open"></i>

					<span>Feedback</span>

				</a>

			</li>



			<li class="<?= (@$page == 'help' ? 'active' : '') ?>">

				<a href="<?php echo base_url() ?>admin/Enquiries?type=HELP">

					<i class="fa fa-envelope"></i>

					<span>Help</span>

				</a>

			</li>



			<li class="<?= (@$page == 'user_otp' ? 'active' : '') ?>">

				<a href="<?php echo base_url() ?>admin/settings/user_otp">

					<i class="fa fa-key"></i>

					<span>User Otp</span>

				</a>

			</li>




		</ul>

	</div>

</div>



<div class="sidebar-bg"></div>