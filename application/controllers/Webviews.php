<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webviews extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
		$this->load->model('Feedback_model');
	}


	public function feedback()
	{
	    if(isset($_GET['token']))
	    {
	       $token=$_GET['token'];
	       $result=$this->User_model->checktoken($token);
    	    if(!empty($result))
    	    {
    	        $data['user_id']=$result['userid'];
    		    $this->load->view('webviews/feedback',$data);
    	    }
    	    
    	    else
    	    {
    	        echo "Some error Occured !";
    	    }
	    }
	    else
	    {
	        echo "We are unable to open the url as the required perimeter is not set  !";
	    }
	}
	public function help()
	{
	    if(isset($_GET['token']))
	    {
	       $token=$_GET['token'];
	       $result=$this->User_model->checktoken($token);
	        if(!empty($result))
    	    {
    	        $data['user_id']=$result['userid'];
	            $this->load->view('webviews/help',$data);
    	    }
    	    
    	    else
    	    {
    	        echo "Some error Occured !";
    	    }
	    }
	    
	   else
	    {
	        echo "Some error Occured !";
	    }
	}
	public function contact()
	{
	    if(isset($_GET['token']))
	    {
	       $token=$_GET['token'];
	       $result=$this->User_model->checktoken($token);
	       //print_r($result);
	        if(!empty($result))
    	    {
    	        $data['user_id']=$result['userid'];
	            $this->load->view('webviews/contact',$data);
    	    }
    	    
    	    else
    	    {
    	        echo "Some error Occured !";
    	    }
	    }
	    
	   else
	    {
	        echo "Some error Occured !";
	    }
	}
	
	public function submitfeedback()
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

	public function loan_topup()
	{
	    if(isset($_GET['token']))
	    {
	       $token=$_GET['token'];
	       $result=$this->User_model->checktoken($token);
	       //print_r($result);
	        if(!empty($result))
    	    {
    	        $data['user_id']=$result['userid'];
	            $this->load->view('webviews/loan_topup',$data);
    	    }
    	    
    	    else
    	    {
    	        echo "Some error Occured !";
    	    }
	    }
	    
	   else
	    {
	        echo "Some error Occured !";
	    }
	}
		
}
