<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Loans extends CI_Controller
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
        $this->load->model( 'Loan_apply_model' );
        $this->load->model( 'Loan_payments_model' );
        $this->load->model( 'Managers_model' );
        $this->load->model( 'User_model' );
    }
    

    public function index()
    {
        $data[ 'page' ] = 'Loans';
        $data[ 'sub_page' ] = 'Claim Loan';

        $search = trim( $this->input->get( 'search', true ) );

        if( $search )
        {
            if( $loans = $this->Loan_apply_model->getloandetail3( "u.first_name like '%$search%' OR u.last_name like '%$search%' " ) )
            {
                $data[ 'loans' ] = $loans;
            }
        }

        $this->load->view( 'manager/loan_search', $data );
    }



    public function claim_loan()
    {
        if( $_SERVER[ 'REQUEST_METHOD' ] !== 'POST' ) show_404();

        $loan_id = intval( $this->input->post( 'loan_id' ) );

        $loan = $this->Loan_apply_model->getloandetail2( $loan_id, [ 'loan_status IN ( "APPROVED", "PENDING" )' ] );

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

    
    public function loans_under_approval()
    {
        $data[ 'page' ] = 'Loans';
        $data[ 'sub_page' ] = 'My Loans Under Approval';
        $data[ 'loans' ] = $this->Loan_apply_model->get_loans_list_by_manager_id( $this->session->manager_id, [ 'PENDING', 'APPROVED' ] );

        $this->load->view( 'manager/my_loans', $data );
    }

    public function my_running_loans()
    {
        $data[ 'page' ] = 'Loans';
        $data[ 'sub_page' ] = 'My Running Loans';
        $data[ 'loans' ] = $this->Loan_apply_model->get_loans_list_by_manager_id( $this->session->manager_id, [ 'RUNNING' ] );

        $this->load->view( 'manager/my_loans', $data );
    }

    public function closed_loans()
    {
        $data[ 'page' ] = 'Loans';
        $data[ 'sub_page' ] = 'Closed Loans';
        $data[ 'loans' ] = $this->Loan_apply_model->get_loans_list_by_manager_id( $this->session->manager_id, [ 'REJECTED', 'PAID' ]  );

        $this->load->view( 'manager/my_loans', $data );
    }


    public function loan_payments( $loan_id )
    {
        $data[ 'page' ] = 'Loans';
        $data[ 'sub_page' ] = 'Loan Payments';

        $data[ 'loan' ] = $this->Loan_apply_model->getloandetail2( intval( $loan_id ) );
        $data[ 'loan_payments' ] = $this->Loan_payments_model->get_all_payments_order_by( intval( $loan_id ) );

        $this->load->view( 'manager/loan_payments', $data );
    }


    public function mark_payment_form( $payment_id )
    {
        $data[ 'page' ] = 'Loans';
        $data[ 'sub_page' ] = 'Mark Payment Received';

        if( !$data[ 'loan_payment' ] = $this->Loan_payments_model->get_single_payment_where_id( [ 'status' => 'INACTIVE' ] , intval( $payment_id ) ) )
        {
            redirect('manager/home','refresh');
            return;
        }

        $this->load->view( 'manager/mark_payment_form', $data );
    }



    public function mark_payment_received( $payment_id )
    {
        $this->load->library( 'form_validation' );

        $data[ 'page' ] = 'Loans';
        $data[ 'sub_page' ] = 'Payment Received';

        $payment_id = intval( $payment_id );

        if( !$payment = $this->Loan_payments_model->get_single_payment_where_id( [ 'status' => 'INACTIVE' ], $payment_id ) )
        {
            redirect('manager/home','refresh');
            return;
        }

        $data[ 'loan_payment' ] = $payment;

        $this->form_validation->set_rules('amount', 'Amount', 'trim|required|numeric');

        if( $this->form_validation->run() !== true )
        {
            $this->load->view( 'manager/mark_payment_form', $data );
            return;
        }
        
        if( !$load_apply = $this->Loan_apply_model->getloandetail( $payment[ 'loan_apply_id' ] ) )
        {
            redirect('manager/home','refresh');
            return;
        }

        $amount_received = $this->input->post( 'amount', true );

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

            $update_loan_apply[ 'remaining_balance' ] = intval( $load_apply[ 'remaining_balance' ] ) - intval( $amount_received );

            if( $update_loan_apply[ 'remaining_balance' ] <= 0 )
            {
                $update_loan_apply[ 'remaining_balance' ] = 0;
                $update_loan_apply[ 'loan_status' ] = "PAID";
                $update_loan_apply[ 'loan_end_date' ] = date( 'Y-m-d' );
            }

            if( $this->Loan_apply_model->update( $payment[ 'loan_apply_id' ], $update_loan_apply ) )
            {
                $this->session->success = 'Payment Marked As Received Successfully';
                redirect( 'manager/loans/show_paid/'.$payment[ 'loan_apply_id' ], 'refresh');
            }
            else
            {
                $this->session->set_flashdata( 'error', 'Something Went Wrong, Please Try Again Later' );
                $this->load->view( 'manager/mark_payment_form', $data );
                return;
            }
        }
        else
        {
            $this->session->set_flashdata( 'error', 'Failed To Mark Payment As Received' );
            $this->load->view( 'manager/mark_payment_form', $data );
            return;
        }
    }

    public function show_paid( $loan_apply_id )
    {
        $data[ 'page' ] = 'Loans';
        $data[ 'sub_page' ] = 'Payment Received';
        $data[ 'loan_apply_id' ] = $loan_apply_id;
        
        $this->load->view( 'manager/mark_payed', $data );
    }
}

/* End of file Claim.php */
?>