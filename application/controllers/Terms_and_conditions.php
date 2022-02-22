<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Terms_and_conditions extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Adminlogin');
		$this->data['bank_detail'] = $this->Adminlogin->get_admin();
	}

	public function index()
	{   
		$this->data['metatitle']='Term & Conditions - Easyloanmantra';
	    $this->data['metadescription']='Looking for  online loans? Apply for a personal line of credit up to 30k @ low interest rates and get approved in just 24 hours with Easyloanmantra';
	    $this->data['keywords']='Get Personal loan';
	    $this->data['classification']='Get Personal loan';
	    $this->data['pagetopic']='Term & Conditions - Easyloanmantra';
		$this->load->view('terms_and_conditions',$this->data);
	}

}
