<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Enquiries extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		if(!isset($this->session->userdata['user']))
        {
     			redirect('admin/login');
        }
		$this->load->model('User_model');
		$this->load->model('Feedback_model');
		$this->load->model('Loan_apply_model');
		$this->load->model('Loan_payments_model');
        $this->load->model( 'Loan_extension_model' );
	}
	public function index()
	{
		if(isset($_GET['type']))
		{
		    $type=$_GET['type'];
		}
		else
		{
		    $type='ALL';
		}
	    if($_GET['type']=='FEEDBACK')
	    {
	        $this->data['page'] = 'feedback';
	        $this->data['sub_page'] = 'feedback';
	        $this->data['page_title'] = 'New Feedback';
			$this->Feedback_model->mark_all_feedback_as_read();
	    }
	    else
	    {
	        $this->data['page'] = 'help';
	        $this->data['sub_page'] = 'help';
	        $this->data['page_title'] = 'New Help';
			$this->Feedback_model->mark_all_help_as_read();
	    }
	    $this->data['notifications'] = $this->Notification_model->getAllNotifications();
		$this->data['newnotificaton'] = $this->Notification_model->getAllUnreadNotifications();
		$this->data['enquiry'] = $this->Feedback_model->getenquiries($type);
		$this->load->view('admin/enquiry',$this->data);
	}
}