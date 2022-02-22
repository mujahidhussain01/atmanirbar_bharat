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
            $this->session->set_flashdata( 'error', 'User Not Registered With Given Mobile Number' );
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
        $data[ 'sub_page' ] = 'OTP Verify';

        $this->load->view( 'manager/group_loan_otp_verify', $data );
    }


    public function user_otp_verify( $id )
    {
        $data[ 'page' ] = 'Group Loans';
        $data[ 'sub_page' ] = 'OTP Verify';
        $data[ 'group_loan_info' ] = $this->Loan_setting_model->get_single_group_loan_setting_for_manager( intval( $id ) );

        $mobile = $this->input->post( 'user_contact', true );

        $data[ 'mobile' ] = $mobile;

        if( !$userdata = $this->User_model->get_single_user_by_mobile( $mobile ) )
        {
            $this->session->set_flashdata( 'error', 'User Not Registered With Given Mobile Number' );
            $this->load->view( 'manager/group_loan_otp_verify', $data );
            return; 
        }

        if( $this->Loan_apply_model->check_loan_taken_by_user_mobile( $mobile ) )
        {
            $this->session->set_flashdata( 'error', 'A Loan Is Already Running For Given User' );
            $this->load->view( 'manager/group_loan_otp_verify', $data );
            return;
        }

        $loan_apply['loan_id'] = $data[ 'group_loan_info' ]['lsid'];
        $loan_apply['user_id'] = $userdata['userid'];

        $loan_apply['amount'] = $data[ 'group_loan_info' ][ 'amount' ];
        $loan_apply['rate_of_interest'] = $data[ 'group_loan_info' ][ 'rate_of_interest' ];
        $loan_apply['process_fee_percent'] = $data[ 'group_loan_info' ][ 'process_fee_percent' ];
        $loan_apply['processing_fee'] = $data[ 'group_loan_info' ][ 'processing_fee' ];
        $loan_apply['loan_duration'] = $data[ 'group_loan_info' ][ 'loan_duration' ];
        $loan_apply['payment_mode'] = $data[ 'group_loan_info' ][ 'payment_mode' ];
        $loan_apply['bouncing_charges_percent'] = $data[ 'group_loan_info' ][ 'bouncing_charges_percent' ];
        $loan_apply['bouncing_charges'] = $data[ 'group_loan_info' ][ 'bouncing_charges' ];
        $loan_apply['reject_comment'] = 'Your loan application is under process please wait for the approval';
        $loan_apply['emi_amount'] = $data[ 'group_loan_info' ][ 'emi_amount' ];
        $loan_apply['payable_amt'] = ( intval( $data[ 'group_loan_info' ][ 'amount' ] ) - intval( $data[ 'group_loan_info' ][ 'processing_fee' ] ) ) + ceil( ( intval( $data[ 'group_loan_info' ][ 'amount' ] ) / 100 ) * intval( $data[ 'group_loan_info' ][ 'rate_of_interest' ] ) );
        $loan_apply['remaining_balance'] = intval( $data[ 'group_loan_info' ][ 'amount' ] ) + ceil( ( intval( $data[ 'group_loan_info' ][ 'amount' ] ) / 100 ) * intval( $data[ 'group_loan_info' ][ 'rate_of_interest' ] ) );
        $loan_apply['loan_closer_amount'] = $loan_apply[ 'remaining_balance' ];
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