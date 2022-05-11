<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Extensions extends CI_Controller {
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
		$this->load->model('Loan_extension_model');
		date_default_timezone_set('asia/kolkata');
	}

	public function new_extensions(){
	    $this->data['page'] = 'extensions';
	    $this->data['sub_page'] = 'new_extensions';
	    $this->data['page_title'] = 'New Extensions Request';
	    $this->data['extensions']= $this->Loan_extension_model->get_extentions_by_status('PENDING');	
	    $this->load->view('admin/extensions',$this->data);
	}
	public function approved_extensions(){
	    $this->data['page'] = 'extensions';
	    $this->data['sub_page'] = 'approved_extensions';
	    $this->data['page_title'] = 'Approved Extensions';
	    $this->data['extensions']= $this->Loan_extension_model->get_extentions_by_status('APPROVED');	
	    $this->load->view('admin/extensions',$this->data);
	}
	
	public function rejected_extensions(){
	    $this->data['page'] = 'extensions';
	    $this->data['sub_page'] = 'rejected_extensions';
	    $this->data['page_title'] = 'All Rejected Extensions';
	    $this->data['extensions']= $this->Loan_extension_model->get_extentions_by_status('REJECTED');	
	    $this->load->view('admin/extensions',$this->data);
	}

	public function UpdateLoanStatus()
	{
		if( $_SERVER[ 'REQUEST_METHOD' ] != 'POST' )
		show_404();

		$loan_extension_id =  intval( $this->input->post( 'le_id', true ) );

	    if( !$loan_extension = $this->Loan_extension_model->getloanextentiondetailbyleid( $loan_extension_id ) )
		{
			echo json_encode( [ 'success' => false, 'msg' => 'Invalid Extension' ] );
			return;
		}

		if( $loan_extension[ 'extension_status' ] !== 'PENDING' )
		{
			echo json_encode( [ 'success' => false, 'msg' => 'Extension Request Already Marked As '.$loan_extension[ 'extension_status' ] ] );
			return;
		}

	    if( !$current_loan = $this->Loan_apply_model->getloandetail( $loan_extension[ 'la_id' ] ) )
		{
			echo json_encode( [ 'success' => false, 'msg' => 'No loan Found On Which Extension Is Requested' ] );
			return;
		}

	    $extension_update['extension_status'] = $this->input->post( 'value', true );
	    $extension_update['reject_comment'] = $this->input->post( 'message', true );

	    if( $this->input->post( 'value', true ) == 'APPROVED' )
		{
			if( $current_loan[ 'loan_status' ] != 'RUNNING' )
			{
				echo json_encode( [ 'success' => false, 'msg' => 'Loan Is Not In Running Condition, Cannot Extend Closed Loan' ] );
				return;
			}

			// calculate loan data ----

			$loan_amount = intval( $current_loan[ 'remaining_balance' ] ) + intval( $loan_extension[ 'ext_amount' ] );
			$loan_duration = intval( $loan_extension[ 'ext_duration' ] ) ?? 1;
			$payment_mode = $loan_extension[ 'ext_payment_mode' ];
			$deduct_lic_amount = $current_loan[ 'deduct_lic_amount' ];

			$rate_of_interest = $current_loan[ 'rate_of_interest' ];
			$process_fee_percent = $current_loan[ 'process_fee_percent' ];
			$bouncing_charges_percent = $current_loan[ 'bouncing_charges_percent' ];

			$interest_amount_initial = ceil( ( $loan_amount / 100 ) * $rate_of_interest );

			if( $loan_duration > 30 )
			{
				$multiply_by = ceil( $loan_duration / 30 );
				$interest_amount = ceil( $interest_amount_initial * $multiply_by );
			}
			else
			{
				$interest_amount = $interest_amount_initial;
			}
			
			$processing_fee = ceil( ( $loan_amount / 100 ) * $process_fee_percent );
			$bouncing_charges = ceil( ( $loan_amount / 100 ) * $bouncing_charges_percent );

			$one_percent = 0;
			
			if( $deduct_lic_amount == 'YES' )
			{
				$one_percent = ceil( $loan_amount / 100 );
				$loan_closer_amount = $loan_amount + $interest_amount + $one_percent;
			}
			else
			{
				$loan_closer_amount = $loan_amount + $interest_amount;
			}

			// set initial emi count
			$total_emi_count = 1;

			// get value to be divided by loan duration to calculate emi amount
			$divided_by = 1;

			if( $payment_mode == 'weekly' )
			{
				$divided_by = 7;
			}
			else if( $payment_mode == 'every-15-days' )
			{
				$divided_by = 15;
			}
			else if( $payment_mode == 'monthly' )
			{
				$divided_by = 30;
			}

			$total_emi_count = floor( $loan_duration / $divided_by ) ;

			$emi_amount = ceil( $loan_closer_amount / $total_emi_count );
		
			// calculate loan data End ----

			$new_loan['user_id'] = $current_loan[ 'user_id' ];
			$new_loan['loan_id'] = $current_loan[ 'loan_id' ];
			$new_loan['manager_id'] = $current_loan[ 'manager_id' ];
			$new_loan['amount'] = $loan_amount;
			$new_loan['rate_of_interest'] = $rate_of_interest;
			$new_loan['monthly_interest'] = $interest_amount_initial;
			$new_loan['process_fee_percent'] = $process_fee_percent;
			$new_loan['processing_fee'] = $processing_fee;
			$new_loan['loan_duration'] = $loan_duration;
			$new_loan['payment_mode'] = $payment_mode;
			$new_loan['bouncing_charges_percent'] = $bouncing_charges_percent;
			$new_loan['bouncing_charges'] = $bouncing_charges;
			$new_loan['reject_comment'] = 'Your loan application is under process please wait for the approval';
			$new_loan['emi_amount'] = $emi_amount;
			$new_loan['payable_amt'] = $loan_amount - $processing_fee;
			$new_loan['remaining_balance'] = $loan_closer_amount;
			$new_loan['loan_closer_amount'] = $loan_closer_amount;
			$new_loan['deduct_lic_amount'] = $deduct_lic_amount;
			$new_loan['lic_amount'] = $one_percent;
			$new_loan['loan_status'] = 'APPROVED';
			$new_loan['extension_of'] = $current_loan[ 'la_id' ];


			if( !$new_loan_id = $this->Loan_apply_model->insert( $new_loan ) )
			{
				echo json_encode( [ 'success' => false, 'msg' => 'Unable To Create New Loan With Extended Amount, Database Error' ] );
				return;
			}

			$current_loan_update['loan_status'] = 'PAID';
			$current_loan_update['loan_end_date'] = date( 'Y-m-d' );
            $current_loan_update['reject_comment'] = 'Extension Request is approved successfully!';

	        if( !$this->Loan_apply_model->update( $current_loan[ 'la_id' ], $current_loan_update ) )
			{
				echo json_encode( [ 'success' => false, 'msg' => 'New Loan Created But Failed To Close Current Loan' ] );
				return;
			}

			$this->load->model( 'loan_payments_model' );

			if( !$this->loan_payments_model->delete_inactive_payments_where_loan_id( $current_loan[ 'la_id' ] ) )
			{
				echo json_encode( [ 'success' => false, 'msg' => 'New Loan Created But Failed To Delete Current Loan Payment Schedule' ] );
				return;
			}

			$extension_update[ 'new_la_id' ] = $new_loan_id;
			$extension_update[ 'reject_comment' ] = 'Loan Extension Request Approved Successfully';

			$userDefaultMsgData['default_title'] = 'Loan Extension Request Approved And A New Loan With Extended Amount Assigned To Your Account';
			$userDefaultMsgData['default_message'] = 'Your Loan Extended With Total Amount Rs.'.$loan_amount.' Successfully, Please Wait For Amount Disbursement. we will keep you informed. Thanks';
			
			$this->User_model->updateUserDataByUserId( $current_loan[ 'user_id' ], $userDefaultMsgData);
	    }

	    $sql = $this->Loan_extension_model->update( $loan_extension_id, $extension_update );
	    
		if( $sql )
		{
    		$error['success'] = true;
    		$error['msg'] = 'Extension Request Status Updated Successfully';
	    }
		else
		{
    		$error['success'] = false;
    		$error['msg'] = 'Extension Request Status Not Updated';
	    }

	    echo json_encode($error);
	}
	
}
