<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_payments extends CI_Controller
{

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
            $this->load->model( 'Loan_extension_model' );
            $this->load->model('Managers_model');
            date_default_timezone_set('asia/kolkata');
	}

    public function todays_payments()
    {
	    $this->data['page'] = 'payments';
	    $this->data['sub_page'] = 'todays_payments';
	    $this->data['page_title'] = 'Todays Payments';


	    $this->data['payments']= $this->Loan_payments_model->get_payments_by_date( date( 'Y-m-d' ) );	
	    $this->load->view('admin/payments_list',$this->data);
	}

    public function payed_payments()
    {
        if( $daterange_param = $this->input->get( 'date_range' ) )
        {
            $daterange = explode('-', $daterange_param );
            $minvalue = date('Y-m-d',strtotime($daterange[0])).' 00:00:00';
            $maxvalue = date('Y-m-d',strtotime($daterange[1])).' 23:59:59';
        }
        else
        {
            $minvalue = date( 'Y-m-d', strtotime( '-1 month' ) ).' 00:00:00';
            $maxvalue = date( 'Y-m-d' ).' 23:59:59';
        }

	    $this->data['page'] = 'payments';
	    $this->data['sub_page'] = 'payed_payments';
	    $this->data['page_title'] = 'Payed Payments';
	    $this->data['payments']= $this->Loan_payments_model->get_all_payed_payments( $minvalue, $maxvalue );	
	    $this->load->view('admin/payments_list',$this->data);
	}

    public function upcoming_payments()
    {
	    $this->data['page'] = 'payments';
	    $this->data['sub_page'] = 'upcoming_payments';
	    $this->data['page_title'] = 'Upcoming Payments';
	    $this->data['payments']= $this->Loan_payments_model->get_all_upcoming_payments();	
	    $this->load->view('admin/payments_list',$this->data);
	}

    public function mark_payment_received()
    {

        $payment_id = intval( $this->input->post( 'pay_id', true ) );

        if( !$payment = $this->Loan_payments_model->get_single_payment_where_id( [ 'status' => 'INACTIVE' ], $payment_id ) )
        {
            echo json_encode( [ 'success' => false, 'msg' => 'Payment Not Found' ] );
            return;
        }

        if( !$loan_apply = $this->Loan_apply_model->getloandetail( $payment[ 'loan_apply_id' ] ) )
        {
            echo json_encode( [ 'success' => false, 'msg' =>  'Invalid Loan ID' ] );
            return;
        }

        if( $loan_apply[ 'loan_status' ] != 'RUNNING' )
        {
            echo json_encode( [ 'success' => false, 'msg' =>  'Loan Is Not In Running Condition, Cannot Receive Payments' ] );
            return;
        }

        if( !$amount_received =  intval( $this->input->post( 'received_amount', true ) ) )
        {
            echo json_encode( [ 'success' => false, 'msg' =>  'Invalid Amount Received Value' ] );
            return;
        }


        $update_payment[ 'amount_received' ] = $amount_received;
        $update_payment[ 'amount_received_at' ] = date( 'Y-m-d H:i:s' );
        $update_payment[ 'status' ] = 'ACTIVE';
        $update_payment[ 'amount_received_by' ] = 'ADMIN';

        if( $this->Loan_payments_model->update_single_payment( $update_payment, $payment_id ) )
        {
            // update loan apply

            $update_loan_apply[ 'remaining_balance' ] = intval( $loan_apply[ 'remaining_balance' ] ) - intval( $amount_received );

            if( $update_loan_apply[ 'remaining_balance' ] <= 0 )
            {
                $update_loan_apply[ 'remaining_balance' ] = 0;
                $update_loan_apply[ 'loan_status' ] = "PAID";
                $update_loan_apply[ 'loan_end_date' ] = date( 'Y-m-d' );
            }

            if( !$this->Loan_apply_model->update( $payment[ 'loan_apply_id' ], $update_loan_apply ) )
            {
                echo json_encode( [ 'success' => false,  'msg' =>  'Failed To Mark Payment As Received, Please Try Again Later' ] );
            }
            else
            {
                echo json_encode( [ 'success' => true, 'msg' =>  'Payment Marked As Received' ] );
            }


        }
        else
        {
            echo json_encode( [ 'success' => false, 'msg' =>  'Failed To Mark Payment As Received, Please Try Again Later' ] );
        }



    }


    public function foreclose_loan_request( $loan_id = false )
    {
        if( !intval( $loan_id ) )
        show_404();

        if( !$this->data[ 'loan_details' ] = $this->Loan_apply_model->getloandetail2( intval( $loan_id ) ) )
        show_404();

        if( $this->data[ 'loan_details' ][ 'loan_status' ] != 'RUNNING' )
        {
            show_error( 'Loan Is Not In Running Condition', 201, 'Cannot ForeClose Loan' );
            return;
        }

        $current_month = date_create( date( 'Y-m-d' ) );
        $last_month = date_create( date( 'Y-m', strtotime( $this->data[ 'loan_details' ][ 'loan_last_date' ] ) ) );
        $interval = date_diff( $current_month, $last_month );
        
        $months_left = intval( $interval->format( '%m' ) );

        if( $months_left )
        {
            $this->data[ 'loan_details' ][ 'foreClose_amount' ] = intval( $this->data[ 'loan_details' ][ 'remaining_balance' ] ) - ceil( intval( $this->data[ 'loan_details' ][ 'monthly_interest' ] ) *  $months_left );
        }
        else
        {
            $this->data[ 'loan_details' ][ 'foreClose_amount' ] = intval( $this->data[ 'loan_details' ][ 'remaining_balance' ] );
        }


	    $this->data['page'] = 'ForeClose Loan';
	    $this->data['sub_page'] = 'ForeClose Loan';
	    $this->data['page_title'] = 'ForeClose Loan';
	    $this->load->view('admin/foreclose_loan_request', $this->data);
	}

    public function foreclose_loan()
    {
        if( !$loan_id = intval( $this->input->post( 'loan_id', true ) ) )
        {
            echo json_encode( [ 'success' => false, 'msg' => 'Invalid Or Empty Loan ID' ] );
            return;
        }

        if( !$received_amount = intval( $this->input->post( 'received_amount', true ) ) )
        {
            echo json_encode( [ 'success' => false, 'msg' => 'Received Amount Required' ] );
            return;
        }

        if( !$loan_details = $this->Loan_apply_model->getloandetail2( $loan_id ) )
        {
            echo json_encode( [ 'success' => false, 'msg' => 'Invalid Loan ID' ] );
            return;
        }

        if( $loan_details[ 'loan_status' ] != 'RUNNING' )
        {
            echo json_encode( [ 'success' => false, 'msg' => 'Loan Is Not In Running Status' ] );
            return;
        }

        $current_month = date_create( date( 'Y-m-d' ) );
        $last_month = date_create( date( 'Y-m', strtotime( $loan_details[ 'loan_last_date' ] ) ) );
        $interval = date_diff( $current_month, $last_month );
        
        $months_left = intval( $interval->format( '%m' ) );

        if( $months_left )
        {
            $foreClose_amount = intval( $loan_details[ 'remaining_balance' ] ) - ( intval( $loan_details[ 'monthly_interest' ] ) * $months_left );
        }
        else
        {
            $foreClose_amount = intval( $loan_details[ 'remaining_balance' ] );
        }


        if( $foreClose_amount !== $received_amount )
        {
            echo json_encode( [ 'success' => false, 'msg' => 'Invalid Received Amount, To Close Loan, Received Amount Must Be : ',$foreClose_amount ] );
            return;
        }

        $this->load->model( 'loan_payments_model' );

        $new_foreClose_payment = [
            'user_id' => $loan_details[ 'user_id' ],
            'loan_apply_id' => $loan_id,
            'amount_received_by' => 'ADMIN',
            'amount' => $received_amount,
            'amount_received' => $received_amount,
            'amount_received_at' => date( 'Y-m-d H:i:s' ),
            'status' => 'ACTIVE'
        ];

        if( !$this->loan_payments_model->insert( $new_foreClose_payment ) )
        {
            echo json_encode( [ 'success' => false, 'msg' => 'Failed To Receive ForeClose Payment, Database Error' ] );
            return;
        }
        
        if( !$this->loan_payments_model->delete_inactive_payments_where_loan_id( $loan_id ) )
        {
            echo json_encode( [ 'success' => false, 'msg' => 'Failed To Delete Old Inactive Payments, Database Error' ] );
            return;
        }

        $current_loan_update['loan_status'] = 'PAID';
        $current_loan_update['remaining_balance'] = 0;
        $current_loan_update['loan_end_date'] = date( 'Y-m-d' );
        $current_loan_update['reject_comment'] = 'Loan ForeClosed Successfully';

        if( !$this->Loan_apply_model->update( $loan_id, $current_loan_update ) )
        {
            echo json_encode( [ 'success' => false, 'msg' => 'Failed To ForeClose Loan, Database Error' ] );
            return;
        }

        echo json_encode( [ 'success' => true, 'msg' => 'Loan Closed Successfully' ] );
    }

}

/* End of file Manage_payments.php */
