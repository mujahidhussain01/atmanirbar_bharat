<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
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
        $this->load->model( 'Group_loans_model' );
    }
    

    public function index()
    {
        $data[ 'page' ] = 'dashboard';
        $this->load->view( 'manager/dashboard', $data );
    }

    public function logout()
	{
		$this->session->unset_userdata('manager');
		$this->session->unset_userdata('manager_id');
		redirect('manager/login', 'refresh');
	}

}

/* End of file Welcome.php */
?>