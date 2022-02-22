<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loan extends CI_Controller {
	function __construct()
	{
		parent::__construct();
			if(!isset($this->session->userdata['user']))
       		{
     			redirect('admin/login');
        	}

			$this->load->model('User_model');
            $this->load->model('Loan_apply_model');
            $this->load->model('Loan_payments_model');
            date_default_timezone_set('asia/kolkata');

	}

	public function index(){
	    $this->data['page'] = 'loans';
	    $this->data['sub_page'] = 'new_loan';
	    $this->data['page_title'] = 'New Loan Request';
	    // $this->data['loans']= $this->Loan_apply_model->get_loan_by_status('PENDING');
	    $this->load->view('admin/user_loan',$this->data);
	}
	public function approved_loan(){
	    $this->data['page'] = 'loans';
	    $this->data['sub_page'] = 'approved_loan';
	    $this->data['page_title'] = 'Approved Loans';
	    // $this->data['loans']= $this->Loan_apply_model->get_loan_by_status('APPROVED');	
	    $this->load->view('admin/user_loan',$this->data);
	}
	public function running_loan(){
	    $this->data['page'] = 'loans';
	    $this->data['sub_page'] = 'running_loan';
	    $this->data['page_title'] = 'All Running Loans';
	    // $this->data['loans']= $this->Loan_apply_model->get_loan_by_status('RUNNING');
	    $this->load->view('admin/user_loan',$this->data);
	}
	public function rejected_loan(){
	    $this->data['page'] = 'loans';
	    $this->data['sub_page'] = 'rejected_loan';
	    $this->data['page_title'] = 'All Rejected Loans';
	    // $this->data['loans']= $this->Loan_apply_model->get_loan_by_status('REJECTED');	
	    $this->load->view('admin/user_loan',$this->data);
	}
	public function paid_loan(){
	    $this->data['page'] = 'loans';
	    $this->data['sub_page'] = 'paid_loan';
	    $this->data['page_title'] = 'All Paid Loans';
	    // $this->data['loans']= $this->Loan_apply_model->get_loan_by_status('PAID');	
	    $this->load->view('admin/user_loan',$this->data);
	}

	public function all_loan(){
	    $this->data['page'] = 'loans';
	    $this->data['sub_page'] = 'all_loan';
	    $this->data['page_title'] = 'All Loans';
	    // $this->data['loans']= $this->Loan_apply_model->get_loan_by_status(NULL);	
	    $this->load->view('admin/user_loan',$this->data);
	}

	public function getLoanData()
    {
	    $daterange = explode('-',$_POST['date_range']);
	    $minvalue = date('Y-m-d',strtotime($daterange[0])).' 00:00:00';
        $maxvalue = date('Y-m-d',strtotime($daterange[1])).' 23:59:59';

        if($_POST['page'] == 'new_loan')
		{
            $loans = $this->Loan_apply_model->getLoanByStatusByDateRange('PENDING',$minvalue,$maxvalue);
        }

        if($_POST['page'] == 'approved_loan')
		{
            $loans = $this->Loan_apply_model->getLoanByStatusByDateRange('APPROVED',$minvalue,$maxvalue);
        }

		if($_POST['page'] == 'running_loan')
		{
            $loans = $this->Loan_apply_model->getLoanByStatusByDateRange( 'RUNNING', $minvalue, $maxvalue );
        }

        if($_POST['page'] == 'rejected_loan')
		{
            $loans = $this->Loan_apply_model->getLoanByStatusByDateRange('REJECTED',$minvalue,$maxvalue);
        }

        if($_POST['page'] == 'paid_loan')
		{
            $loans = $this->Loan_apply_model->getLoanByStatusByDateRange('PAID',$minvalue,$maxvalue);
        }

        if($_POST['page'] == 'all_loan')
		{
            $loans = $this->Loan_apply_model->getLoanByStatusByDateRange(NULL,$minvalue,$maxvalue);
        }
	    ?>
		<div class="table-responsive">
	    <table id="data-table-buttons"  class="table table-centered table-bordered table-condensed table-nowrap">
							<thead>
								<tr>
									<th>S.no</th>
									<th>Loan Info</th>
									<th>Customer Info</th>

									<?php if( $_POST[ 'page' ] != 'running_loan' && $_POST[ 'page' ] != 'paid_loan' ):?>

									<th>Profile Status</th>
									<th>Profile Approved</th>

									<?php else:?>

									<th>Payment</th>

									<?php endif;?>

									<?php if( $_POST[ 'page' ] == 'rejected_loan' || $_POST[ 'page' ] == 'all_loan'):?>
										<th>Comment</th>
									<?php endif;?>
									<!-- <th>Previous Loan</th> -->

									<th>Loan Created Date</th>
									<!-- <th>Contacts</th> -->
									<?php if($_POST['page'] != 'complete_loan' && $_POST['page'] != 'all_loan' && $_POST['page'] != 'rejected_loan' && $_POST['page'] != 'running_loan' && $_POST['page'] != 'paid_loan' && $_POST['page'] != 'panelty_loan'&& $_POST['page'] != 'loan_with_extentions'): ?>
									<th>Action</th>
									<?php endif; ?>
								</tr>
							</thead>
							<?php $sno=0;?>
							<tbody>
							<?php $i=1; foreach($loans as $la){?>
								<tr>
									<td><?=$i?></td>
									<td>
										<ul class="list-unstyled">
											<li class="mt-2"><strong>Loan ID : </strong> <?= $la['la_id']?></li>
											<li class="mt-2"><strong>Loan Type : </strong> <?= $la['loan_type']?></li>
											<li class="mt-2"><strong>Amount : </strong> <?=( $la['amount']?'₹'. $la['amount']:'NA')?></li>
											<li class="mt-2"><strong>Rate Of Interest : </strong> <?=$la['rate_of_interest']?>%</li>
											<li class="mt-2"><strong>Processing Fee : </strong> <?=( $la['processing_fee']?'₹'. $la['processing_fee']:'NA')?></li>
											<li class="mt-2"><strong>Closer Amount : </strong> ₹<?= $la['loan_closer_amount']?></li>
											<li class="mt-2"><strong>Loan Duration : </strong> <?= $la['loan_duration']?> Days</li>
											<li class="mt-2"><strong>Payment Mode : </strong> <?= $la['payment_mode']?></li>
											<li class="mt-2"><strong>Emi Amount : </strong> ₹<?= $la['emi_amount']?></li>
											<li class="mt-2"><strong>Claimed By  : </strong> <?= $la[ 'manager_name' ] ? $la[ 'manager_name' ].' ( Manager ) ' : 'NONE' ?></li>

											<?php if( $_POST['page'] == 'running_loan' || $_POST['page'] == 'paid_loan' || $_POST['page'] == 'all_loan'  ):?>
											<li class="mt-2"><strong>Remaining Balance  : </strong> ₹<?= $la[ 'remaining_balance' ] ?></li>
											<?php endif;?>
											
										</ul>
									</td>
									<td>
										<ul class="list-unstyled">
											<li class="mt-2"><strong>Name : </strong> <?= $la['first_name'].' '.$la['last_name']?></li>
											<li class="mt-2"><strong>Email : </strong> <?= $la['email']?></li>
											<li class="mt-2"><strong>Mobile : </strong> <?= $la['mobile']?></li>
											<li class="mt-2"><strong>City : </strong> <?= $la['city']?></li>

											<?php if( $_POST[ 'page' ] == 'running_loan' ):?>
												<button type="button" class="btn btn-info btn-sm my-2" onclick="getUserDetail(<?=$la['userid']?>,`all`)">View Documents</button>
											<?php endif;?>

										</ul>
									</td>
									<?php if( $_POST[ 'page' ] != 'running_loan' && $_POST[ 'page' ] != 'paid_loan' ):?>

                                    <td>
                                    <?php
                                        $profile_status = '<button class="btn btn-warning">Incomplete</button>';
										$is_profile_completed = false;

                                        if( $la[ 'bda_status' ] == 'APPROVED' && $la[ 'adhar_card_front' ] != '' && $la[ 'adhar_card_back' ] != '' && $la[ 'pan_card_image' ] != '' && $la[ 'passbook_image' ] != ''  )
                                        {
                                            $profile_status = '<button class="btn btn-success">Completed</button>';
											$is_profile_completed = true;

                                        }
                                        echo $profile_status;
                                    ?>
                                    </td>
                                    
									<td>
                                    <?php 
                                        $profile_approved = '<button class="btn btn-warning">Pending</button>';
										$is_profile_approved = false;


                                        if( $la[ 'bda_status' ] == 'APPROVED' && $la[ 'docv_status' ] == 'APPROVED' && $la[ 'pan_card_approved_status' ] == 'APPROVED' && $la[ 'passbook_approved_status' ] == 'APPROVED' )
                                        {
                                            $profile_approved = '<button class="btn btn-success">Approved</button>';
											$is_profile_approved = true;

                                        }
                                        elseif( $la[ 'bda_status' ] == 'REJECTED' || $la[ 'docv_status' ] == 'REJECTED' || $la[ 'pan_card_approved_status' ] == 'REJECTED' || $la[ 'passbook_approved_status' ] == 'REJECTED' )
                                        {
                                            $profile_approved = '<button class="btn btn-danger">Rejected</button>';
                                        }
                                        echo $profile_approved;
                                    ?>
									<br>
									<button type="button" class="btn btn-info btn-sm my-2" onclick="getUserDetail(<?=$la['userid']?>,`all`)">View Documents</button>
                                    </td>

									<?php else:?>

										<td><button type="button" class="btn btn-success btn-sm my-2" onclick="getPaymentDetails(<?=$la['la_id']?>)">View Payments</button>
                                    	</td>

									<?php endif;?>

									<?php if( $_POST[ 'page' ] == 'rejected_loan' || $_POST[ 'page' ] == 'all_loan' ):?>

									<td>Status : <?php echo $la['loan_status'];?>,<br><?php echo $la[ 'reject_comment' ]?></td>

									<?php endif;?>


									<td><?=(  $la['la_doc'] ? ( date( 'd M Y, H:i A', strtotime( $la['la_doc'] ) ) ) : 'NA' ) ?></td>

									<!-- <td>
										<a class='btn btn-info btn-sm' target='_blank'  href='<?//=base_url('admin/user/contacts/'.$la['userid'])?>'>View Contacts</a>
									</td> -->

									<?php if($_POST['page'] != 'complete_loan' && $_POST['page'] != 'all_loan' && $_POST['page'] != 'rejected_loan' && $_POST['page'] != 'running_loan' && $_POST['page'] != 'paid_loan' && $_POST['page'] != 'panelty_loan'&& $_POST['page'] != 'loan_with_extentions'): ?>
										<td>

										<?php if( $is_profile_completed && $is_profile_approved ):?>
									
											<select onchange='updateloanStatus(this)' data-la_id='<?=$la['la_id']?>'>
												<option value=''>Change Status</option>
												<?php if($_POST['page'] == 'new_loan'): ?>
												<option value='APPROVED'>Approved</option>
												<option value='REJECTED'>Rejected</option>
												<?php elseif($_POST['page'] == 'approved_loan'): ?>
												<option value='REJECTED'>Rejected</option>
												<option value='RUNNING'>Amount Disbursed</option>
												<?php elseif($_POST['page'] == 'paid_loan'): ?>
												<option value='PAID'>Completed</option>
												<?php endif; ?>
											</select>
											
											<?php endif;?>
										</td>
									<?php endif; ?>
								</tr>
							<?php $i++;} ?>
							</tbody>
						</table>
												</div>
	    <?php
	    
	    
	}


	public function UpdateloanStatus()
	{
	    $loan = $this->Loan_apply_model->getloandetail( $_POST['la_id'] );

        if( $_POST['value'] == 'APPROVED')
		{
          	$data['reject_comment'] = 'Amount will be dispersed soon'; 
           
          
        }

        if($_POST['value'] == 'REJECTED')
		{
          	$data['reject_comment'] = $_POST['message'];  
           
        }

		if($_POST['value'] == 'RUNNING')
		{
          	$data['reject_comment'] = "Loan Amount Disbursed";  
			$data['loan_start_date'] = date('Y-m-d H:i:s');

			$divided_by = 1;

			if( $loan[ 'payment_mode' ] == "weekly" )
			{
				$divided_by = 7;
			}
			else if( $loan[ 'payment_mode' ] == 'every-15-days' )
			{
				$divided_by = 15;
			}
			else if( $loan[ 'payment_mode' ] == 'monthly' )
			{
				$divided_by = 30;
			}

			$emi_count = floor( intval( $loan[ 'loan_duration' ] ) / $divided_by );

			$emi_count = ( $emi_count >= 1 ) ? $emi_count : 1 ;

			$insert_loan_payments = [];

			$next_date = date( 'Y-m-d' );

			for( $i = 0; $i < $emi_count; $i++ )
			{
				$next_date = date( 'Y-m-d', strtotime( $next_date." + ".$divided_by." days" ) );
				$insert_loan_payments[] = [
					'loan_apply_id' => $loan[ 'la_id' ],
					'user_id' => $loan[ 'user_id' ],
					'amount' => $loan[ 'emi_amount' ],
					'payment_date' => $next_date

				];
			}

			if( !$this->Loan_payments_model->insert_batch( $insert_loan_payments ) )
			{
				$error['status'] = true;
				$error['message'] = 'Status Not Updated';
				echo json_encode($error); return;
			}
        }



        if($_POST['value'] == 'PAID')
		{
          $data['reject_comment'] = 'Loan closer payemnt notice recieved ! Please wait for admin aproval'; 
          
        }


	    $data[ 'loan_status' ] = $_POST[ 'value' ];
	    $sql = $this->Loan_apply_model->update( $_POST[ 'la_id' ], $data );
		 
	    if( $sql )
		{

    		$error['status'] = false;
    		$error['message'] = 'Status Updated Successfully';
	    }else{
    		$error['status'] = true;
    		$error['message'] = 'Status Not Updated';
	    }
	    echo json_encode($error);
	}


		// --------------------------------------------------

		public function getPaymentDetails()
		{
			if( $payments = $this->Loan_payments_model->get_all_payments( intval( $_POST[ 'la_id' ] ) ) )
			{
				$has_inactive = false;
			?>
			<div class="p-5">
			<h4 class="my-4 text-center" >Payment Details Of Loan ID : <?php echo $_POST[ 'la_id' ]?></h4>
			<hr>
			<div class="table-responsive p-4">
				<table class="table table-centered table-bordered table-condensed table-nowrap">
					<thead>
						<tr>
							<th>S.no</th>
							<th>Emi Amount</th>
							<th>Payment Date</th>
							<th>Bouncing Charges</th>
							<th>Payment Status</th>
							<th>Amount Received</th>
							<th>Received By</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $payments as $key => $payment ):?>
	
							<tr>
								<td><?php echo ++$key ?></td>
								<td>₹<?php echo $payment[ 'amount' ]?></td>
								<td><?php echo date( 'd-M-Y', strtotime( $payment[ 'payment_date' ] ) )?></td>
								<td><?php echo $payment[ 'bounce_charges' ] ? $payment[ 'bounce_charges' ] : "NA" ?></td>
								<td>
									<?php if( $payment[ 'status' ] == 'ACTIVE' ):?>
	
										<button class="btn btn-success">Payed</button>
	
									<?php  elseif( $payment[ 'status' ] == 'INACTIVE' ):?>
										
										<?php if( !$has_inactive ):?>

											<?php $has_inactive = true;?>

										<button onclick="markPaymentReceived( '<?php echo $payment[ 'id' ]?>','<?php echo $payment[ 'amount' ]?>' )" class="btn btn-info m-3">Mark Received</button>

										<?php else:?>

											<button class="btn btn-secondary m-3">Pending</button>

										<?php endif;?>
									
									<?php endif;?>
								</td>
								<td>
								₹<?php echo $payment[ 'amount_received' ]?>
								</td>
								<td>
									<?php if( $payment[ 'amount_received_by' ] == 'MANAGER' )
									{
										echo $payment[ 'manager_name' ].' ( Manager ) ';
									}
									else if( $payment[ 'amount_received_by' ] == 'ADMIN' )
									{
										echo 'ADMIN';
									}
									
									?>
								</td>
							</tr>
	
						<?php endforeach;?>
					</tbody>
	
				</table>
	
			</div>
			</div>
	
			<?php 
			}
			else
			{
				show_404();
			}
	
	
		}
	
		// --------------------------------------------------
	
}
