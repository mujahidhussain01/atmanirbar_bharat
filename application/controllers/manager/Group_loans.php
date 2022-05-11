<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Group_loans extends CI_Controller
{
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
        $this->load->model( 'Loan_setting_model' );
        $this->load->model( 'Loan_apply_model' );
        $this->load->model( 'User_model' );
    }
    

    public function index()
    {
        $data[ 'page' ] = 'Group Loans';
        $data[ 'sub_page' ] = 'Group Loans List';
        $data[ 'search' ] = trim( $this->input->get( 'search', true ) );

        if( !empty( $data[ 'search' ] ) )
        {
            $data[ 'group_loans' ] = $this->Loan_setting_model->get_group_loan_settings_for_manager( $data[ 'search' ] );
        }
        else
        {
            $data[ 'group_loans' ] = $this->Loan_setting_model->get_group_loan_settings_for_manager();
        }

        $this->load->view( 'manager/group_loans', $data );
    }

    public function loan_info( $id )
    {
        $data[ 'page' ] = 'Group Loans';
        $data[ 'sub_page' ] = 'Loan Info';
        $data[ 'group_loan' ] = $this->Loan_setting_model->get_single_group_loan_setting_for_manager( intval( $id ) );

        $data[ 'search' ] = trim( $this->input->get( 'search', true ) );

        if( !empty( $data[ 'search' ] ) )
        {
            $data[ 'loan_users' ] = $this->Loan_apply_model->get_users_of_group_loan( intval( $id ) , $data[ 'search' ] );
        }
        else
        {
            $data[ 'loan_users' ] = $this->Loan_apply_model->get_users_of_group_loan( intval( $id ) );
        }

        $this->load->view( 'manager/group_loan_info', $data );
    }


    public function loan_user_info( $la_id )
    {
        $data[ 'page' ] = 'Group Loans';
        $data[ 'sub_page' ] = 'Loan Details';
        $data[ 'loan' ] = $this->Loan_apply_model->getloandetail2( intval( $la_id ) );

        $this->load->view( 'manager/group_loan_user_info', $data );
    }


    public function loan_add_user( $id )
    {
        $data[ 'page' ] = 'Group Loans';
        $data[ 'mobile' ] = '';
        $data[ 'sub_page' ] = 'Add User';
        $data[ 'group_loan_info' ] = $this->Loan_setting_model->get_single_group_loan_setting_for_manager( intval( $id ) );

        $this->load->view( 'manager/group_loan_add_user', $data );
    }


    
    public function user_otp_send( $id )
    {
        $data[ 'page' ] = 'Group Loans';
        $data[ 'sub_page' ] = 'Add User';
        $data[ 'group_loan_info' ] = $this->Loan_setting_model->get_single_group_loan_setting_for_manager( intval( $id ) );

        $mobile = $this->input->post( 'user_contact', true );

        $data[ 'mobile' ] = $mobile;

        if( !$this->User_model->get_single_user_by_mobile( $mobile ) )
        {
            $this->session->set_flashdata( 'error', 'No User Registered With Given Mobile Number' );
            $this->load->view( 'manager/group_loan_add_user', $data );
            return; 
        }

        if( $this->Loan_apply_model->check_loan_taken_by_user_mobile( $mobile ) )
        {
            $this->session->set_flashdata( 'error', 'A Loan Is Already Running For Given User' );
            $this->load->view( 'manager/group_loan_add_user', $data );
            return;
        }

        // Send OTP Here -------

        $data[ 'page' ] = 'Group Loans';
        $data[ 'otp_val' ] = '';
        $data[ 'sub_page' ] = 'OTP Verify';

        $this->load->view( 'manager/group_loan_otp_verify', $data );
    }


    public function user_otp_verify( $id )
    {
        $data[ 'page' ] = 'Group Loans';
        $data[ 'sub_page' ] = 'OTP Verify';
        $data[ 'group_loan_info' ] = $this->Loan_setting_model->get_single_group_loan_setting_for_manager( intval( $id ) );

        $mobile = $this->input->post( 'user_contact', true );
        $otp_val = $this->input->post( 'otp_val', true );
        $deduct_lic_amount = $this->input->post( 'deduct_lic_amount', true );

        $data[ 'mobile' ] = $mobile;
        $data[ 'otp_val' ] = $otp_val;

        if( !$userdata = $this->User_model->get_single_user_by_mobile( $mobile ) )
        {
            $this->session->set_flashdata( 'error', 'No User Registered With Given Mobile Number' );
            $this->load->view( 'manager/group_loan_otp_verify', $data );
            return; 
        }

        if( $prev_loan = $this->Loan_apply_model->getuserlastloandetail( $userdata['userid'] ) )
		{
			if( ($prev_loan['loan_status'] == 'PENDING' OR  $prev_loan['loan_status'] == 'RUNNING' OR $prev_loan['loan_status'] == 'APPROVED' ) )
			{
                $this->session->set_flashdata( 'error', 'Payment of your previous loan is in under verification. please wait until the Admin verifies your payment ' );
                $this->load->view( 'manager/group_loan_otp_verify', $data );
                return;
			}
			else if( $prev_loan['loan_status'] == 'PENDING' OR $prev_loan['loan_status'] == 'RUNNING' OR $prev_loan['loan_status'] == 'APPROVED' )
			{
                $this->session->set_flashdata( 'error', 'A loan is already is running in your profile please wait until the loan completes ' );
                $this->load->view( 'manager/group_loan_otp_verify', $data );
                return;
			}

		}
		else if( $this->input->post( 'deduct_lic_amount', true ) !== 'yes' )
		{
            $this->session->set_flashdata( 'error', 'LIC Amount Deduction Is Compulsory For First Loan' );
            $this->load->view( 'manager/group_loan_otp_verify', $data );
            return;
		}

        // verify OTP Here -----


        // calculate loan data ----

        $loan_amount = $data[ 'group_loan_info' ][ 'amount' ];
        $loan_duration = $data[ 'group_loan_info' ][ 'loan_duration' ];
        $payment_mode = $data[ 'group_loan_info' ][ 'payment_mode' ];
        $deduct_lic_amount = $this->input->post( 'deduct_lic_amount', true );

        $rate_of_interest = $data[ 'group_loan_info' ][ 'rate_of_interest' ];
        $process_fee_percent = $data[ 'group_loan_info' ][ 'process_fee_percent' ];
        $bouncing_charges_percent = $data[ 'group_loan_info' ][ 'bouncing_charges_percent' ];
        $processing_fee = $data[ 'group_loan_info' ][ 'processing_fee' ];
        $bouncing_charges = $data[ 'group_loan_info' ][ 'bouncing_charges' ];

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


        $loan_apply['user_id'] = $userdata['userid'];
        $loan_apply['loan_id'] = $data['group_loan_info'][ 'lsid' ];
        $loan_apply['amount'] = $loan_amount;
        $loan_apply['rate_of_interest'] = $rate_of_interest;
        $loan_apply['process_fee_percent'] = $process_fee_percent;
        $loan_apply['processing_fee'] = $processing_fee;
        $loan_apply['loan_duration'] = $loan_duration;
        $loan_apply['payment_mode'] = $payment_mode;
        $loan_apply['bouncing_charges_percent'] = $bouncing_charges_percent;
        $loan_apply['bouncing_charges'] = $bouncing_charges;
        $loan_apply['reject_comment'] = 'Your loan application is under process please wait for the approval';
        $loan_apply['emi_amount'] = $emi_amount;
        $loan_apply['payable_amt'] = $loan_amount - $processing_fee;
        $loan_apply['remaining_balance'] = $loan_closer_amount;
        $loan_apply['loan_closer_amount'] = $loan_closer_amount;
        $loan_apply['deduct_lic_amount'] = $deduct_lic_amount;
        $loan_apply['lic_amount'] = $one_percent;

        $loan_apply['manager_id'] = $this->session->manager_id;

        // apply for Loan Here ---------
        if( $this->Loan_apply_model->insert( $loan_apply ) )
        {
            $data[ 'page' ] = 'Group Loans';
            $data[ 'sub_page' ] = 'Loan Applied Success';
            $this->load->view( 'manager/group_loan_success', $data );
        }
        else
        {
            $this->session->set_flashdata( 'error', 'Failed To Apply For Loan, Please Try Again Later' );
            $this->load->view( 'manager/group_loan_otp_verify', $data );
            return;
        }

    }



    public function claim_loan()
    {
        if( $_SERVER[ 'REQUEST_METHOD' ] !== 'POST' ) show_404();

        $loan_id = intval( $this->input->post( 'loan_id' ) );

        $loan = $this->Loan_apply_model->getloandetail2( $loan_id, [ 'loan_status' => 'APPROVED' ] );

        if( !$loan || $loan[ 'manager_id' ] != null )
        {
            echo json_encode( [ 'success' => false, 'msg' => 'Loan Unavailable To Claim Or Invalid Loan ID' ] );
            return;
        }

        if( $this->Loan_apply_model->update( $loan_id, [ 'manager_id' => $this->session->manager_id ] ) )
        {
            echo json_encode( [ 'success' => true, 'msg' => 'Loan Claimed Successfully' ] );
        }
        else
        {
            echo json_encode( [ 'success' => false, 'msg' => 'Loan Invalid Or Unavailable For Claim' ] );
        }
    }

}

/* End of file Claim.php */
?>