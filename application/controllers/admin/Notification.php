<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Notification extends CI_Controller {



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

		$this->data['page'] = 'dashboard';

		$this->data['notifications'] = $this->Notification_model->getAllNotifications();

		$this->data['newnotificaton'] = $this->Notification_model->getAllUnreadNotifications();

		foreach($this->data['newnotificaton'] as $not){

		    $data['read_status'] = 'ACTIVE';

		    $this->Notification_model->update($not['notify_id'],$data);

		}

		$this->load->view('admin/notification',$this->data);

	}

}

