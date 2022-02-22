<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if(!isset($this->session->userdata['user']))

        {

     			redirect('admin/login');

        }

		$this->load->model('User_model');

		$this->load->model('Loan_apply_model');
		$this->load->model('Loan_payments_model');


	}



	public function index()
	{
		$this->load->model( 'Feedback_model' );

		$this->data['page'] = 'dashboard';
		
	    $this->data['payments']= $this->Loan_payments_model->get_payments_by_date( date( 'Y-m-d' ) );
	    $this->data['upcoming_payments']= $this->Loan_payments_model->get_all_upcoming_payments();	

	    $this->data['feedback_count']= $this->Feedback_model->get_unread_feedback_count();
	    $this->data['help_count']= $this->Feedback_model->get_unread_help_count();
		$this->load->view('admin/dashboard',$this->data);
	}

	public function getLoanAnalyticsData()

	{   

	    $daterange = explode('-',$_POST['date_range']);

	    $minvalue = date('Y-m-d',strtotime($daterange[0])).' 00:00:00';

        $maxvalue = date('Y-m-d',strtotime($daterange[1])).' 23:59:00';

        $data['start_date'] = $minvalue;

        $data['end_date'] = $maxvalue;

        $data['complete_loan'] = $this->Loan_apply_model->getLoanByStatusCountByDateRange('PROCESSED',$minvalue,$maxvalue);

        $data['rejected_loan'] = $this->Loan_apply_model->getLoanByStatusCountByDateRange('REJECTED',$minvalue,$maxvalue);

        $data['paid_loan'] = $this->Loan_apply_model->getLoanByStatusCountByDateRange('PAID',$minvalue,$maxvalue);

        $data['new_loan'] = $this->Loan_apply_model->getLoanByStatusCountByDateRange('PENDING',$minvalue,$maxvalue);

        $data['approved_loan'] = $this->Loan_apply_model->getLoanByStatusCountByDateRange('APPROVED',$minvalue,$maxvalue);

        $data['extended_loan'] = $this->Loan_apply_model->getallextendedloanscountByDateRange($minvalue,$maxvalue);

        $data['panelty_loan'] = $this->Loan_apply_model->getallloanswithpaneltycountByDateRange($minvalue,$maxvalue);

		echo json_encode($data);

	}



	public function logout()

	{

		$this->session->unset_userdata('user');

		redirect('admin');

	}

}

