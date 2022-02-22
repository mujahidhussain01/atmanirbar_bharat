<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_us extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
		$this->load->model('Feedback_model');
		$this->load->model('Adminlogin');
		$this->data['bank_detail'] = $this->Adminlogin->get_admin();
	}

    
	public function index()
	{
	    $this->data['metatitle']='Contact Us - Easyloanmantra';
	    $this->data['metadescription']='Looking for  online loans? Apply for a personal line of credit up to 30k @ low interest rates and get approved in just 24 hours with Easyloanmantra';
	    $this->data['keywords']='Get Personal loan';
	    $this->data['classification']='Get Personal loan';
	    $this->data['pagetopic']='Contact Us - Easyloanmantra';
		$this->load->view('contact_us',$this->data);
	}
	
	public function submitenquiry()
	{
        if(preg_match('/^(?:(?:\+|0{0,2})91(\s*[\-]\s*)?|[0]?)?[6789]\d{9}$/', $this->input->post('phone')))
        {
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            {
                echo json_encode(array('error'=>1,'message'=>'Please enter a valid email address!'));
            }
            else
            {
        	       $result=$this->Feedback_model->insert($_POST);
        	       if($result)
        	       {
        	           if($_POST['f_type']=='FEEDBACK')
            	       {
            	        echo json_encode(array('error'=>0 ,'message'=>'Thanks for the feedback !'));
            	       }
            	       else
            	       {
            	           echo json_encode(array('error'=>0 ,'message'=>'Our team will contact you soon !'));
            	       }
        	       }
        	       
        	       else
        	       {
        	            echo json_encode(array('error'=>1,'message'=>'Some error occured !'));
        	       }
            }
	       
	    }
	    
	    else
	    {
	        echo json_encode(array('error'=>1,'message'=>'Please enter valid phone number !'));
	    }

	}
}