<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Manual_loan_setting extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		if(!isset($this->session->userdata['user']))
        {
            redirect('admin/login');
        }
        $this->load->model('manual_loan_setting_model');
        $this->load->model('Otp_model');
		$this->load->model('Loan_apply_model');
		$this->load->model('Loan_payments_model');
		$this->load->model('Adminlogin');
		$this->load->model('User_model');
	}


    public function View_manual_loan_setting()
    {
		$this->data['page'] = 'manual_loan_setting';
        $this->data['manual_loan_setting'] = $this->manual_loan_setting_model->get_manual_loan_setting();
       
        $this->load->view('admin/manual_loan_setting',$this->data);
    }



    public function update_manual_loan_setting( $id )
    {
        
        $this->form_validation->set_rules( 'rate_of_interest', '
        Rate Of Interest', 'trim|required|numeric');
        $this->form_validation->set_rules( 'process_fee_percent', '
        Processing Fee Percent', 'trim|required|numeric');
        $this->form_validation->set_rules( 'bouncing_charges_percent', '
        Bouncing Charges Percent', 'trim|required|numeric');

        
        if ( $this->form_validation->run() !== TRUE )
        {
            $this->session->set_flashdata('error', 'Form Error');
            
            $this->data['page'] = 'manual_loan_setting';
            $this->data['manual_loan_setting'] = $this->manual_loan_setting_model->get_manual_loan_setting();
        
            $this->load->view('admin/manual_loan_setting',$this->data);
        }
        
        

        $update[ 'rate_of_interest' ] = $this->input->post( 'rate_of_interest', true );
        $update[ 'process_fee_percent' ] = $this->input->post( 'process_fee_percent', true );
        $update[ 'bouncing_charges_percent' ] = $this->input->post( 'bouncing_charges_percent', true );

        $result = $this->manual_loan_setting_model->update( $update, $id );

        if ( $result )
        {
            $this->session->set_flashdata( 'success', 'Manual Loan Setting Updated Successfully');
            
            redirect('admin/manual_loan_setting/view_manual_loan_setting','refresh');
            
        } 
        else 
        {
            $this->session->set_flashdata('error', 'Failed To Update Manual Loan Setting, Please Try Again');
            
            $this->data['page'] = 'manual_loan_setting';
            $this->data['manual_loan_setting'] = $this->manual_loan_setting_model->get_manual_loan_setting();
        
            $this->load->view('admin/manual_loan_setting',$this->data);
        }
    }
}
