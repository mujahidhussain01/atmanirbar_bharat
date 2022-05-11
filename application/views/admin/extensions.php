<?php include "common/header.php"?>
<?php include "common/sidebar.php"?>
<style>
    .media.media-sm .media-object {
    width: 64px;
    height: 64px;
    border: 1px solid grey;
}
table.table-bordered.dataTable th, table.table-bordered.dataTable td {
    border-left-width: 0;
    white-space: nowrap;
}
</style>
<div id="content" class="content">
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item"><a href="<?=site_url('admin/')?>">Home</a></li>
		<li class="breadcrumb-item"><a href="javascript:;">Extensions</a></li>
		<li class="breadcrumb-item active"><a href="javascript:;"><?=$page_title?></a></li>
	</ol>
	<h1 class="page-header"><?=$page_title?> </h1>
	<div class="row">
		<div class="col-12">
			<div class="panel">
				<div class="panel-body  table-responsive">
						<table id="data-table-buttons"  class="table table-centered table-bordered table-condensed table-nowrap">
							<thead>
								<tr>
									<th>S.no</th>
									<th>Loan Info</th>
									<th>Customer Info</th>
									<th>Extension Amount</th>
									<th>Extension Duration</th>
									<th>Extension Payment Mode</th>
									<?php if($sub_page != 'approved_extensions'&&$sub_page != 'rejected_extensions'): ?>
									<th>Action</th>
									<?php endif; ?>
									<?php if( $sub_page == 'approved_extensions' ):?>
										<th>
											Extended Loan
										</th>
									<?php endif;?>
									<th>Requested Time</th>
								</tr>
							</thead>
							<?php $sno=0;?>
							<tbody>
							<?php $i=1; foreach($extensions as $la){ ?>
								<tr>
									<td><?=$i?></td>
									<td>
										<ul class="list-unstyled">
											<li class="mt-2"><strong>Loan ID : </strong> <?= $la['la_id']?></li>
											<li class="mt-2"><strong>Loan Type : </strong> <?= $la['loan_type']?></li>
											<li class="mt-2"><strong>Amount : </strong> <?=( $la['amount']?'₹'. $la['amount']:'NA')?></li>

											<li class="mt-2">
											<strong>Processing Fees : </strong> <?=( $la['processing_fee']?'₹'. $la['processing_fee']:'NA')?>
											</li>

											<li class="mt-2"><strong>Payable Amount : </strong> <?=( $la['payable_amt']?'₹'. $la['payable_amt']:'NA')?></li>

											<li class="mt-2">
											<strong>Deduct 1% LIC Amount : </strong> <?=$la['deduct_lic_amount']?>
											</li>

											<li class="mt-2"><strong>Final Loan Amount : </strong> <?=( $la['loan_closer_amount']?'₹'. $la['loan_closer_amount']:'NA')?></li>

											<li class="mt-2"><strong>Remaining Balance : </strong> <?=( $la['remaining_balance']?'₹'. $la['remaining_balance']:'NA')?></li>

											<li class="mt-2"><strong>Loan Status : </strong> <?= $la[ 'loan_status' ]?></li>

											<li>
												<a href="<?= base_url( 'admin/loan/details/'.$la[ 'la_id' ] )?>">
													<button type="button" class="btn btn-primary btn-sm my-2">
														View Loan Details
													</button>
												</a>
											</li>
										</ul>
									</td>
									<td>
									<ul class="list-unstyled">
											<li class="mt-2"><strong>Name : </strong> <?= $la['first_name'].' '.$la['last_name']?></li>
											<li class="mt-2"><strong>Email : </strong> <?= $la['email']?></li>
											<li class="mt-2"><strong>Mobile : </strong> <?= $la['mobile']?></li>
											<li class="mt-2"><strong>City : </strong> <?= $la['city']?></li>

										</ul>
									</td>

									<td><?=(@$la['ext_amount']?'₹'.@$la['ext_amount']:'NA')?></td>

									<td><?=(@$la['ext_duration']? @$la['ext_duration'].' Days' :'NA')?></td>

									<td><?=(@$la['ext_payment_mode']? @$la['ext_payment_mode']:'NA')?></td>

									<?php if( $sub_page != 'approved_extensions' && $sub_page != 'rejected_extensions' ): ?>
									<td>
										<?php if( $la[ 'extension_status' ] === 'PENDING' ): ?>
											<select onchange='UpdateDocumentStatus(this)' data-le_id='<?=$la['le_id']?>'>
												<option value='' selected disabled>Change Status</option>
												<?php if($sub_page == 'new_extensions'): ?>
												<option value='APPROVED'>Approved</option>
												<option value='REJECTED'>Rejected</option>
												<?php endif; ?>
											</select>
										<?php endif; ?>
									</td>
									<?php endif; ?>

									<?php if( $sub_page == 'approved_extensions' && $la[ 'extension_status' ] == 'APPROVED' ): ?>
										<td>

										<a href="<?= base_url( 'admin/loan/details/'.$la[ 'new_la_id' ] )?>">
                                            <button type="button" class="btn btn-primary btn-sm my-2">
                                                View Extended Loan
                                            </button>
                                        </a>
										</td>

									<?php endif;?>

									<td>
										<?= date( 'd-M-y, H:i A', strtotime( $la[ 'le_doc' ] ) )?>
									</td>

								</tr>
							<?php $i++;} ?>
							</tbody>
						</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include "common/footer.php"?>
<script type="text/javascript">
	$('#data-table-buttons').DataTable({
			dom: '<"dataTables_wrapper dt-bootstrap"<"row"<"col-xl-7 d-block d-sm-flex d-xl-block justify-content-center"<"d-block d-lg-inline-flex mr-0 mr-sm-3"l><"d-block d-lg-inline-flex"B>><"col-xl-5 d-flex d-xl-block justify-content-center"fr>>t<"row"<"col-sm-5"i><"col-sm-7"p>>>',
            
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


		function UpdateDocumentStatus(select)
		{ 
		    var value = $(select).val();
		    var le_id = $(select).data('le_id');

		    if(confirm('Are You Sure to change the status'))
			{
				var message = '';

				if(value=="REJECTED")
				{
					message = prompt('Enter The Reason of rejection');
				}

				var data={value:value,le_id:le_id,message:message};

				$.ajax(
					{
						url:'<?=site_url('admin/extensions/UpdateLoanStatus')?>',
						type: "POST",
						data:data,
						success:function(data)
						{
							var response = JSON.parse( data );

							if( response )
							{
								alert( response.msg );
							}

							if( response.success )
							{
								location.reload();
							}
						}
            		}
				);
		    }
            
        }
</script>