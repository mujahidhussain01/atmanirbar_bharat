<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Group_loans extends CI_Controller
{

    public $data = [
        'page' => 'Group Loans'
    ];

    public function __construct()
    {
        parent::__construct();

        $this->load->model( 'Managers_model' );

        if( !$this->session->manager )
        {
            if( empty( $this->input->get( 'token' ) ) )
            {
                redirect( 'manager/login' );
                exit;
            }
            elseif( !$manager = $this->Managers_model->get_manager_by_token( $this->input->get( 'token' ) ) )
            {
                redirect( 'manager/login' );
                exit;
            }

            $this->session->unset_userdata( 'user' );

            $this->session->manager =  $manager[ 'name' ];
            $this->session->manager_id =  $manager[ 'id' ];
        }

        $this->load->model( 'Group_loans_model' );
        $this->load->model( 'Loan_apply_model' );
        $this->load->model( 'User_model' );
    }
    
    public function index()
    {
        $this->data[ 'sub_page' ] = 'Group Loans List';
        $this->data[ 'search' ] = trim( $this->input->get( 'search', true ) );

        if( !empty( $this->data[ 'search' ] ) )
        {
            $this->data[ 'group_loans' ] = $this->Group_loans_model->get_all_group_loans_with_amount_count( $this->data[ 'search' ] );
        }
        else
        {
            $this->data[ 'group_loans' ] = $this->Group_loans_model->get_all_group_loans_with_amount_count();
        }

        $this->load->view( 'manager/group_loans', $this->data );
    }

    public function loan_info( $id )
    {
        $this->data[ 'sub_page' ] = 'Loan Info';
        
        if( !$this->data[ 'group_loan' ] = $this->Group_loans_model->get_single_group_loan_with_amount_count( $id ) )
        {
            $this->session->set_flashdata( 'error', 'Invalid Loan ID' );
            redirect( 'manager/group_loans' );
            return;
        }

        $this->data[ 'search' ] = trim( $this->input->get( 'search', true ) );

        if( !empty( $this->data[ 'search' ] ) )
        {
            $this->data[ 'all_loans' ] = $this->Group_loans_model->get_all_loans_of_group_loan( intval( $id ) , $this->data[ 'search' ] );
        }
        else
        {
            $this->data[ 'all_loans' ] = $this->Group_loans_model->get_all_loans_of_group_loan( intval( $id ) );
        }

        $this->load->view( 'manager/group_loan_info', $this->data );
    }

    public function loan_add_user( $id )
    {
        if( !$this->data[ 'group_loan_info' ] = $this->Group_loans_model->get_single_group_loan( intval( $id ) ) )
        {
            $this->session->set_flashdata( 'error', 'Invalid Loan ID, Cannot Add User' );
            redirect( 'manager/group_loans' );
            return;
        }

        $this->data[ 'sub_page' ] = 'Add User';

        $this->load->view( 'manager/group_loan_add_user', $this->data );
    }

    public function user_otp_send( $id )
    {
        if( $_SERVER[ 'REQUEST_METHOD' ] !== 'POST' )
        {
            echo json_encode( [ 'success' => false, 'msg' => 'Invalid Action' ] );
            return;
        }
       
        if( !$group_loan_info = $this->Group_loans_model->get_single_group_loan( intval( $id ) ) )
        {
            echo json_encode( [ 'success' => false, 'msg' => 'Invalid Loan ID' ] );
            return;
        }

        $mobile = $this->input->post( 'mobile', true );

        if( !$this->User_model->get_single_user_by_mobile( $mobile ) )
        {
            echo json_encode( [ 'success' => false, 'msg' => 'No User Registered With Given Mobile Number' ] );
            return;
        }

        if( $this->Loan_apply_model->check_loan_taken_by_user_mobile( $mobile ) )
        {
            echo json_encode( [ 'success' => false, 'msg' => 'A Loan Is Already Running For Given User' ] );
            return;
        }

        // Send OTP Here -------

        echo json_encode( [ 'success' => true, 'msg' => 'OTP Sent To Given Mobile Number Successfully', 'data' => [ 'mobile' => $mobile ] ] );
        return;
    }

    public function user_otp_verify_form( $id, $mobile )
    {
        $this->data[ 'sub_page' ] = 'OTP Verify';

        if( !$this->data[ 'group_loan_info' ] = $this->Group_loans_model->get_single_group_loan( intval( $id ) ) )
        {
            $this->session->set_flashdata( 'error', 'Invalid Loan ID, Cannot Verify OTP' );
            redirect( 'manager/group_loans' );
            return;
        }

        $this->data[ 'mobile' ] = $mobile;

        if( !preg_match( '/^[6-9][0-9]{9}$/', $this->data[ 'mobile' ] ) )
        {
            $this->session->set_flashdata( 'error', 'Invalid Mobile Number' );
            redirect( 'manager/group_loans/loan_add_user/'.intval( $id ) );
        }

        if( !$this->User_model->get_single_user_by_mobile( $mobile ) )
        {
            $this->session->set_flashdata( 'error', 'No User Registered With Given Mobile Number' );
            redirect( 'manager/group_loans/loan_add_user/'.intval( $id ) );
        }

        if( $this->Loan_apply_model->check_loan_taken_by_user_mobile( $mobile ) )
        {
            $this->session->set_flashdata( 'error', 'A Loan Is Already Running For Given User' );
            redirect( 'manager/group_loans/loan_add_user/'.intval( $id ) );
        }

        $this->load->view( 'manager/group_loan_otp_verify', $this->data );
    }

    public function user_otp_verify( $id )
    {
        // First Verify OTP Then Apply For New Group Loan

        if( $_SERVER[ 'REQUEST_METHOD' ] !== 'POST' )
        {
            echo json_encode( [ 'success' => false, 'msg' => 'Invalid Id' ] );
            return;
        }

        if( empty( intval( $id ) ) )
        {
            echo json_encode( [ 'success' => false, 'msg' => 'Invalid Id' ] );
            return;
        }

        if( !$group_loan_info = $this->Group_loans_model->get_single_group_loan( intval( $id ) ) )
        {
            echo json_encode( [ 'success' => false, 'msg' => 'No Group Loan Found With Given ID' ] );
            return;
        }

		$this->form_validation->set_rules( 'mobile', 'Mobile', 'trim|required|numeric|regex_match[/^[6-9][0-9]{9}$/]');
		$this->form_validation->set_rules( 'otp_val', 'OTP Value', 'trim|required|numeric|greater_than[0]');
		$this->form_validation->set_rules( 'loan_amount', 'Loan Amount', 'trim|required|numeric|greater_than[0]');
		$this->form_validation->set_rules( 'loan_duration', 'Loan Duration', 'trim|required|numeric|greater_than[0]');
		$this->form_validation->set_rules( 'payment_mode', 'Payment Mode', 'trim|required|alpha_dash');
		$this->form_validation->set_rules( 'deduct_lic_amount', 'Deduct LIC Amount', 'trim|required|alpha_dash');


		if( $this->form_validation->run() !== true )
		{
			if( form_error( 'mobile' ) )
			{
				$message = form_error( 'mobile' );
			}
			else if( form_error( 'otp_val' ) )
			{
				$message = form_error( 'otp_val' );
			}
			else if( form_error( 'loan_amount' ) )
			{
				$message = form_error( 'loan_amount' );
			}
			else if( form_error( 'loan_duration' ) )
			{
				$message = form_error( 'loan_duration' );
			}
			else if( form_error( 'payment_mode' ) )
			{
				$message = form_error( 'payment_mode' );
			}
			else if( form_error( 'deduct_lic_amount' ) )
			{
				$message = form_error( 'deduct_lic_amount' );
			}
			else
			{
				$message = 'Invalid Form Value';
			}

			echo json_encode( [ 'success' => false, 'msg' => strip_tags( $message ) ] );
			return;
		}

        
        // Validate OTP Here --

        $mobile = $this->input->post( 'mobile', true );
        $otp_val = $this->input->post( 'otp_val', true );


        // Apply For New Group Loan --

		$userdata = $this->User_model->get_single_user_by_mobile( $mobile );

		if ( empty( $userdata ) )
		{
			$message = "Invalid User Token";
			echo json_encode([ 'success' => false, 'msg' => $message ] );
			return;
		}


		if( $prev_loan = $this->Loan_apply_model->getuserlastloandetail( $userdata[ 'userid' ] ) )
		{
			if( $prev_loan['loan_status'] == 'PENDING' )
			{
				$message = "Cannot Apply For New Loan, A Loan Request Is Pending In Your Profile, Please Wait For Admin To Respond.";

				echo json_encode([ 'success' => false, 'msg' => $message] );
				return;
			}
			else if( $prev_loan['loan_status'] == 'APPROVED' )
			{
				$message = "Cannot Apply For New Loan, A Loan Is Waiting For Amount Disbursement, Please Wait For Admin To Respond.";
				
				echo json_encode([ 'success' => false, 'msg' => $message] );
				return;
			}
			else if( $prev_loan['loan_status'] == 'RUNNING' )
			{
				$message = "Cannot Apply For New Loan, A Loan Is Already Running With Your Account, Please Complete The Previous Loan First.";

				echo json_encode([ 'success' => false, 'msg' => $message] );
				return;
			}
		}
		else if( $this->input->post( 'deduct_lic_amount', true ) !== 'yes' )
		{
			$message = "LIC Amount Deduction Is Compulsory For First Loan";
			echo json_encode([ 'success' => false, 'msg' => $message] );
			return;
		}

		// calculate loan data ----

		$loan_amount = intval( $this->input->post( 'loan_amount', true ) );
		$loan_duration = intval( $this->input->post( 'loan_duration', true ) ) ?? 1;
		$payment_mode = $this->input->post( 'payment_mode', true );
		$deduct_lic_amount = $this->input->post( 'deduct_lic_amount', true );

		$rate_of_interest = $group_loan_info[ 'rate_of_interest' ];
		$process_fee_percent = $group_loan_info[ 'process_fee_percent' ];
		$bouncing_charges_percent = $group_loan_info[ 'bouncing_charges_percent' ];

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
		
		if( $deduct_lic_amount == 'yes' )
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

		$new_group_loan['user_id'] = $userdata[ 'userid' ];
		$new_group_loan['loan_id'] = $group_loan_info[ 'id' ];
		$new_group_loan['loan_type'] = 'GROUP';
		$new_group_loan['amount'] = $loan_amount;
		$new_group_loan['rate_of_interest'] = $rate_of_interest;
		$new_group_loan['monthly_interest'] = $interest_amount_initial;
		$new_group_loan['process_fee_percent'] = $process_fee_percent;
		$new_group_loan['processing_fee'] = $processing_fee;
		$new_group_loan['loan_duration'] = $loan_duration;
		$new_group_loan['payment_mode'] = $payment_mode;
		$new_group_loan['bouncing_charges_percent'] = $bouncing_charges_percent;
		$new_group_loan['bouncing_charges'] = $bouncing_charges;
		$new_group_loan['reject_comment'] = 'Your loan application is under process please wait for the approval';
		$new_group_loan['emi_amount'] = $emi_amount;
		$new_group_loan['payable_amt'] = $loan_amount - $processing_fee;
		$new_group_loan['remaining_balance'] = $loan_closer_amount;
		$new_group_loan['loan_closer_amount'] = $loan_closer_amount;
		$new_group_loan['deduct_lic_amount'] = $deduct_lic_amount;
		$new_group_loan['lic_amount'] = $one_percent;
		$new_group_loan['manager_id'] = $this->session->manager_id;


		$sql = $this->Loan_apply_model->insert( $new_group_loan );

		if( $sql )
		{
			$userDefaultMsgdata['default_title'] = 'Loan Applied successfully';
			$userDefaultMsgdata['default_message'] = 'your loan of Rs.'.$loan_amount.' is under process, we will keep you informed. Thanks';

			$this->User_model->updateUserDataByUserId($userdata[ 'userid' ], $userDefaultMsgdata);

			$message = 'Loan Applied successfully'; 
		}
		else
		{
			$message = 'Unable to apply for the loan, Please Try Again Later';  
		}

		echo json_encode( [ 'success' => true, 'msg' => $message, 'data' => [ 'new_loan_id' => $sql ] ] );  
	}
}

/* End of file Claim.php */
?>