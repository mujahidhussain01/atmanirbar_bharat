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
        $this->load->model( 'loan_extension_model' );
        $this->load->model( 'Managers_model' );
        $this->load->model( 'User_model' );
    }
    

    public function index( $type = '' )
    {
        $data[ 'page' ] = 'Loans';
        $data[ 'sub_page' ] = 'Claim Loan';

        if( $search = trim( $this->input->get( 'search', true ) ))
        {
            $where = "( u.first_name like '%$search%' OR u.last_name like '%$search%' ) ";
        }
        else
        {
            $where = '';
        }

        if( $type )
        {

            if( $where != '' )
            {
                $where .= 'AND ';
            }

            if( $type == 'loans_under_approval' )
            {
                $where .= 'la.loan_status IN ( "APPROVED", "PENDING" )';
            }
            else if( $type == 'running_loans' )
            {
                $where .= 'la.loan_status IN ( "RUNNING" )';
            }
            else if( $type == 'closed_loans' )
            {
                $where .= 'la.loan_status IN ( "PAID", "REJECTED" )';
            }
        }

        $data['loans'] = $this->Loan_apply_model->getloandetail3( $where );

        $this->load->view( 'manager/loan_search', $data );
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
        
        if( !$loan_apply = $this->Loan_apply_model->getloandetail( $payment[ 'loan_apply_id' ] ) )
        {
            redirect('manager/home','refresh');
            return;
        }

        if( $loan_apply[ 'loan_status' ] != 'RUNNING' )
        {
            $this->session->set_flashdata( 'error', 'Loan Is Not In Running Condition, Cannot Receive Payments' );
            $this->load->view( 'manager/mark_payment_form', $data );
            return;
        }

        $amount_received = $this->input->post( 'amount', true );

        $update_payment[ 'amount_received' ] = intval( $amount_received );
        $update_payment[ 'amount_received_at' ] = date( 'Y-m-d H:i:s' );
        $update_payment[ 'status' ] = 'ACTIVE';
        $update_payment[ 'amount_received_by' ] = 'MANAGER';
        $update_payment[ 'manager_id' ] = $this->session->manager_id;

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

    // --------------------------------------------------

	public function details( $loan_id = false )
	{
        $this->data['page'] = 'loan';
	    $this->data['sub_page'] = 'Loan Details';
	    $this->data['page_title'] = 'Loan Details';

		if( empty( intval( $loan_id ) ) )
        {
            $this->data[ 'message' ] = 'Invalid Loan ID';
	        $this->load->view( 'manager/show_404', $this->data );
            return;
        } 
		
		if( !$this->data[ 'loan_details' ] = $this->Loan_apply_model->getloandetail2( intval( $loan_id ) ) )
		{
            $this->data[ 'message' ] = 'No Loan Found With Given Loan ID';
	        $this->load->view( 'manager/show_404', $this->data );
            return;
        }

		$this->load->model( 'loan_extension_model' );

	    $this->data['loan_extension'] = $this->loan_extension_model->get_single_extension_by_loan_id( intval( $loan_id ) );

        $this->data[ 'loan_name' ] = '';

		if( $this->data[ 'loan_details' ][ 'loan_type' ] == 'NORMAL' )
		{
			$this->load->model( 'Loan_setting_model' );

			$get_loan_info = $this->Loan_setting_model->get_loan_name( $this->data[ 'loan_details' ][ 'loan_id' ] );

			if( $get_loan_info )
			{
				$this->data[ 'loan_name' ] = $get_loan_info[ 'loan_name' ];
			}
		}
		else if( $this->data[ 'loan_details' ][ 'loan_type' ] == 'GROUP' )
		{
			$this->load->model( 'Group_loans_model' );

			$get_loan_info = $this->Group_loans_model->get_single_group_loan( $this->data[ 'loan_details' ][ 'loan_id' ] );

			if( $get_loan_info )
			{
				$this->data[ 'loan_name' ] = $get_loan_info[ 'name' ];
			}
		}

	    $this->load->view('manager/loan_details',$this->data);
	}

    
    public function foreclose_loan_request( $loan_id = false )
    {
        $this->data['page'] = 'ForeClose Loan';
	    $this->data['sub_page'] = 'ForeClose Loan Request';
	    $this->data['page_title'] = 'ForeClose Loan Request';

		if( empty( intval( $loan_id ) ) )
        {
            $this->data[ 'message' ] = 'Invalid Loan ID';
	        $this->load->view( 'manager/show_404', $this->data );
            return;
        } 

        if( !$this->data[ 'loan_details' ] = $this->Loan_apply_model->getloandetail2( intval( $loan_id ) ) )
        {
            $this->data[ 'message' ] = 'Invalid Loan ID';
	        $this->load->view( 'manager/show_404', $this->data );
            return;
        } 

        if( $this->data[ 'loan_details' ][ 'loan_status' ] != 'RUNNING' )
        {
            $this->data[ 'message' ] = 'Loan Is Not In Running Condition';
	        $this->load->view( 'manager/show_404', $this->data );
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
	    $this->load->view('manager/foreclose_loan_request', $this->data);
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
            echo json_encode( [ 'success' => false, 'msg' => 'Invalid Received Amount, Received Amount Can Only Be : ',$foreClose_amount ] );
            return;
        }

        $this->load->model( 'loan_payments_model' );

        $new_foreClose_payment = [
            'user_id' => $loan_details[ 'user_id' ],
            'loan_apply_id' => $loan_id,
            'amount_received_by' => 'MANAGER',
            'manager_id' => $this->session->manager_id,
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

/* End of file Claim.php */
?>