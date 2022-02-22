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
	    $this->data['page'] = 'payments';
	    $this->data['sub_page'] = 'payed_payments';
	    $this->data['page_title'] = 'Payed Payments';
	    $this->data['payments']= $this->Loan_payments_model->get_all_payed_payments();	
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
            echo json_encode( [ 'success' => false, 'message' => 'Payment Not Found' ] );
            return;
        }

        if( !$loan_apply = $this->Loan_apply_model->getloandetail( $payment[ 'loan_apply_id' ] ) )
        {
            echo json_encode( [ 'success' => false, 'message' =>  'Invalid Loan ID' ] );
            return;
        }

        if( !$amount_received =  intval( $this->input->post( 'received_amount', true ) ) )
        {
            echo json_encode( [ 'success' => false, 'message' =>  'Invalid Amount Received Value' ] );
            return;
        }


        $update_payment[ 'amount_received' ] = $amount_received;
        $update_payment[ 'amount_received_at' ] = date( 'Y-m-d H:i:s' );
        $update_payment[ 'status' ] = 'ACTIVE';

        if( $this->session->userdata( 'manager_id' ) )
        {
            $update_payment[ 'amount_received_by' ] = 'MANAGER';
            $update_payment[ 'manager_id' ] = $this->session->manager_id;
        }
        else
        {
            $update_payment[ 'amount_received_by' ] = 'ADMIN';
        }


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
                echo json_encode( [ 'success' => false,  'message' =>  'Failed To Mark Payment As Received, Please Try Again Later' ] );
            }
            else
            {
                echo json_encode( [ 'success' => true, 'message' =>  'Payment Marked As Received' ] );
            }


        }
        else
        {
            echo json_encode( [ 'success' => false, 'message' =>  'Failed To Mark Payment As Received, Please Try Again Later' ] );
        }



    }

}

/* End of file Manage_payments.php */
