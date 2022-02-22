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

					<div class="stats-warning">

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

					<div class="stats-warning">

						<h4>New Help</h4>

						<p><?= $help_count; ?></p>

					</div>

				</div>

			</a>

		</div>

	</div>

	<div class="row">

		<div class="col-xl-12 mt-5">

			<div class="panel panel-inverse">

				<div class="panel-heading">

					<h4 class="panel-title">Today's Payments<span class='badge badge-danger' id='total_loan_payable' style='display:none'></span></h4>

				</div>

				<div class="table-responsive v-scroll">
					<table id="payments_data_table" class="table table-centered table-bordered table-condensed table-nowrap">
						<thead>
							<tr>
								<th>S.no</th>
								<th>Loan Details</th>
								<th>User Details</th>
								<th>Emi Amount</th>
								<th>Payment Date</th>
								<th>Bouncing Charges</th>
								<th>Payment Status</th>
								<th>Amount Received</th>
								<th>Received By</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($payments)) : ?>
								<?php foreach ($payments as $key => $payment) : ?>

									<tr>
										<td><?php echo ++$key ?></td>
										<td>
											<ul>
												
												<li>Loan ID : <?= $payment['la_id'] ?></li>
												<li>Amount : <?= ($payment['loan_amount'] ? '₹' . $payment['loan_amount'] : 'NA') ?></li>
												<li>Loan Duration : <?= $payment['loan_duration'] ?> Days</li>
												<li>Payment Mode : <?= $payment['payment_mode'] ?></li>
												<li>Payable Amount : <?= $payment['payable_amt'] ?></li>
												<li>Remaining Balance : <?= $payment['remaining_balance'] ?></li>
											</ul>
										</td>
										<td>
											<li>User Name <?= $payment[ 'first_name' ].' '.$payment[ 'last_name' ] ?></li>
											<li>Email : <?= $payment[ 'email' ]?></li>
											<li>Mobile : <?= $payment[ 'mobile' ] ?> Days</li>
											<li>City : <?= $payment[ 'city' ] ?></li>
										</td>
										<td>₹<?php echo $payment['amount'] ?></td>
										<td><?php echo date('d-M-Y', strtotime($payment['payment_date'])) ?></td>
										<td><?php echo $payment['bounce_charges'] ? $payment['bounce_charges'] : "NA" ?></td>
										<td>
											<?php if ($payment['status'] == 'ACTIVE') : ?>

												<button class="btn btn-success">Payed</button>

											<?php elseif ($payment['status'] == 'INACTIVE') : ?>

												<button class="btn btn-info m-3" onclick="markPaymentReceived('<?php echo $payment['id'] ?>','<?php echo $payment['amount'] ?>')">Mark Received</button>

											<?php endif; ?>
										</td>
										<td>
											<?php echo $payment['amount_received'] ?>
										</td>
										<td>
											<?php if ($payment['amount_received_by'] == 'MANAGER')
											{
												echo $payment[ 'manager_name' ].' ( Manager ) ' ;
											}
											else if ($payment['amount_received_by'] == 'ADMIN')
											{
												echo 'ADMIN';
											}

											?>
										</td>
									</tr>


								<?php endforeach; ?>
							<?php else : ?>
								<tr>
									<td colspan="8">No Payments Found For Today</td>
								</tr>
							<?php endif; ?>
						</tbody>

					</table>

				</div>

			</div>

		</div>

		<div class="col-xl-12 mt-5">

			<div class="panel panel-inverse">

				<div class="panel-heading">

					<h4 class="panel-title">Upcoming Payments<span class='badge badge-danger' id='total_loan_payable' style='display:none'></span></h4>

				</div>

				<div class="table-responsive v-scroll">
					<table id="payments_data_table" class="table table-centered table-bordered table-condensed table-nowrap">
						<thead>
							<tr>
								<th>S.no</th>
								<th>Loan Details</th>
								<th>User Details</th>
								<th>Emi Amount</th>
								<th>Payment Date</th>
								<th>Bouncing Charges</th>
								<th>Payment Status</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($upcoming_payments)) : ?>
								<?php $has_inactive = false; ?>
								<?php foreach ($upcoming_payments as $key => $payment) : ?>

									<tr>
										<td><?php echo ++$key ?></td>
										<td>
											<ul>
												<li>Loan ID : <?= $payment['la_id'] ?></li>
												<li>Amount : <?= ($payment['loan_amount'] ? '₹' . $payment['amount'] : 'NA') ?></li>
												<li>Loan Duration : <?= $payment['loan_duration'] ?> Days</li>
												<li>Payment Mode : <?= $payment['payment_mode'] ?></li>
												<li>Payable Amount : <?= $payment['payable_amt'] ?></li>
												<li>Remaining Balance : <?= $payment['remaining_balance'] ?></li>
											</ul>
										</td>
										<td>
											<li>User Name <?= $payment[ 'first_name' ].' '.$payment[ 'last_name' ] ?></li>
											<li>Email : <?= $payment[ 'email' ]?></li>
											<li>Mobile : <?= $payment[ 'mobile' ] ?> Days</li>
											<li>City : <?= $payment[ 'city' ] ?></li>
										</td>
										<td>₹<?php echo $payment['amount'] ?></td>
										<td><?php echo date('d-M-Y', strtotime($payment['payment_date'])) ?></td>

										<td><?php echo $payment['bounce_charges'] ? $payment['bounce_charges'] : "NA" ?></td>
										<td>
											<?php if ($payment['status'] == 'ACTIVE') : ?>

												<button class="btn btn-success">Payed</button>

											<?php elseif ($payment['status'] == 'INACTIVE') : ?>

												<button onclick="markPaymentReceived( '<?php echo $payment['id'] ?>','<?php echo $payment['amount'] ?>' )" class="btn btn-info m-3">Mark Received</button>

											<?php endif; ?>
										</td>
									</tr>


								<?php endforeach; ?>
							<?php else : ?>
								<tr>
									<td colspan="8">No Payments</td>
								</tr>
							<?php endif; ?>
						</tbody>

					</table>

				</div>

			</div>

		</div>

		<div class="col-xl-12 mt-5">

			<div class="panel panel-inverse">

				<div class="panel-heading">

					<h4 class="panel-title">Running Loans<span class='badge badge-danger' id='total_loan_payable' style='display:none'></span></h4>

				</div>

				<div class="table-responsive v-scroll pt-4">
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

<script>
	// ---------------------------------------------------------

	function getPaymentDetails(loan_apply_id) {

		$.ajax({

			url: '<?= site_url('admin/loan/getPaymentDetails') ?>',

			type: 'POST',

			data: {
				'la_id': loan_apply_id
			},

			success: function(data) {

				//  console.log(data);

				$('#userdetailmodal .modal-content').html(data);

				$('#userdetailmodal').modal('show');

			},
			error: function(jqxhr, status) {
				alert(status + ' Server Error');
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

	function getLoanData() {

		var date_range = $('#date_range_sel').html();

		var data = {
			date_range: date_range,
			page: 'running_loan'
		};

		$.ajax({

			method: "POST",

			url: '<?= base_url('admin/loan/getLoanData') ?>',

			data: data,

			success: function(data)

			{

				$('#filterdata').html(data);

				$('#data-table-buttons').DataTable({

					dom: '<"dataTables_wrapper dt-bootstrap"<"row"<"col-xl-7 d-block d-sm-flex d-xl-block justify-content-center"<"d-block d-lg-inline-flex mr-0 mr-sm-3"l><"d-block d-lg-inline-flex"B>><"col-xl-5 d-flex d-xl-block justify-content-center"fr>>t<"row"<"col-sm-5"i><"col-sm-7"p>>>',

					buttons: [{

						extend: 'excel',

						className: 'btn-sm'

					}, {

						extend: 'colvis',

						className: 'btn-sm'

					}],

					responsive: false

				});



			}

		})



		return false;

	}

	function getUserDetail(userid, status) {

		$.ajax({

			url: '<?= site_url('admin/user/getUserDetail') ?>',

			type: 'POST',

			data: {
				'userid': userid,
				'status': status
			},

			success: function(data) {

				//  console.log(data);

				$('#userdetailmodal .modal-content').html(data);

				$('#userdetailmodal').modal('show');

			}

		});

	}

	function updateUserdetails(form) {

		var userid = $(form).data('userid');

		var formData = new FormData($(form)[0]);

		console.log(formData);

		$.ajax({

			url: '<?= site_url('admin/user/updateUserdetails/') ?>' + userid,

			type: "POST",

			data: formData,

			contentType: false,

			cache: false,

			processData: false,

			success: function(response) {

				var json = JSON.parse(response);

				if (json.status == false) {

					getUserDetail(userid, json.doc_type);

				}

				alert(json.message);

			}

		});

		return false;

	}

	function updateloanStatus(select) {

		var value = $(select).val();

		var la_id = $(select).data('la_id');

		if (confirm('Are You Sure to change the status')) {

			var message = '';

			if (value == "REJECTED") {

				message = prompt('Enter The Reason of rejection');

			}

			var data = {
				value: value,
				la_id: la_id,
				message: message
			};

			$.ajax({

				url: '<?= site_url('admin/loan/updateloanStatus') ?>',

				type: "POST",

				data: data,

				success: function(data) {
					var response = JSON.parse(data);

					if (!response.status) {
						alert(response.message);
						location.reload();
					} else {
						alert(response.message);
					}

				}

			});

		}



	}

	function UpdateDocumentStatus(col_name, value, userid) {

		var message = '';

		if (value == "REJECTED") {

			message = prompt('Enter The Reason of rejection');

		}

		var data = {
			col_name: col_name,
			value: value,
			userid: userid,
			message: message
		};

		$.ajax({

			url: '<?= site_url('admin/user/UpdateDocumentStatus') ?>',

			type: "POST",

			data: data,

			success: function(data) {

				console.log(data);

				var json = JSON.parse(data);

				if (json.status == false) {

					getUserDetail(userid, 'all');

					// $('#'+json.col_id).html(json.data);

					// $('#userdetailmodal').modal('hide');

				}

				alert(json.message);

				//$('#status'+id).html(data);

			}

		});





	}

	function markPaymentReceived(pay_id, amount) {
		var received_amount = prompt('Enter Amount Received', amount);

		received_amount = parseInt(received_amount);

		if (!received_amount) {
			alert('Invalid Amount Received Value');
			return;
		}

		if (!confirm('Confirm Mark Payment Received ?')) {
			return;
		}

		$.ajax({

			url: '<?= site_url('admin/manage_payments/mark_payment_received') ?>',

			type: 'POST',

			data: {
				'pay_id': pay_id,
				'received_amount': received_amount
			},

			success: function(data) {
				var res = JSON.parse(data);

				if (res.success) {
					alert(res.message);

					window.location.href = "<?php echo base_url() ?>admin/manage_payments/payed_payments"
				} else {
					alert(res.message);
				}
			},
			error: function(jqxhr) {
				alert(jqxhr.status + ' Server Error');
			}

		});
	}
</script>