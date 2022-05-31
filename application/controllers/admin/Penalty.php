<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Penalty extends CI_Controller
{

    public $data = [
        'page' => 'Generate Penalty',
        
    ];

    public function __construct()
    {
        parent::__construct();

		if(!isset($this->session->userdata['user']))
        {
            redirect('admin/login');
        }

		$this->load->model('Loan_apply_model');
		$this->load->model('User_model');
		$this->load->model('Loan_payments_model');
        $this->load->model( 'Loan_extension_model' );
        $this->load->model( 'Group_loans_model' );
    }


    public function index()
    {
        $this->load->view('admin/penalty', $this->data);
    }


    public function generate_penalty()
    {
        $allPenaltyPayments = $this->Loan_payments_model->get_all_loans_pending_payments();

        foreach ( $allPenaltyPayments as $key => $penaltyPayment )
        {
            $sameLoanPayment = array_filter( $allPenaltyPayments, function( $singlePayment ) use ( $penaltyPayment )
            {
                if( ( $singlePayment[ 'loan_apply_id' ] == $penaltyPayment[ 'loan_apply_id' ] ) && ( $penaltyPayment !== $singlePayment ) )
                {
                    return true;
                }
            } );

            ( var_dump( $sameLoanPayment ) );
        }

    }

}

/* End of file Groups.php */
