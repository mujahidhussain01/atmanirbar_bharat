<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot_password extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		{
			if(isset($this->session->userdata['user']))
       		{
     			redirect('admin');
        	}

			$this->load->model('Adminlogin');
			$this->load->model('Otp_model');
		}
	}

	public function index()
	{
		
	  $this->load->view('admin/forgot_password');
	}

	public function sendotp()
	{
            $email=$this->input->post('email');
            
            $result=$this->Adminlogin->checkemail($email);
            if(!empty($result))
            {
                $res=$this->Otp_model->userotpsending($result['mobile']);
                if($res)
                {
                    $this->session->set_userdata('email',$email);
                echo json_encode(array('error'=>0 ,'mobile'=>$result['mobile'],'message'=>'OTP sent Successfully!'));
                }
                else
                {
                    echo json_encode(array('error'=>1 ,'message'=>'Some error Occured'));
                }
            }
            else
            {
                echo json_encode(array('error'=>1 ,'message'=>'Entered Email did not found in system !'));
            }
	}
	
	public function checkotp()
	{
	    $otp=$_POST['otp'];
	    $mobile=$_POST['mobile'];
        $data['Password']=md5($_POST['Password']);
        $result=$this->Otp_model->checkmobiledata($mobile,$otp);
	    if($result)
	    {
        	    if($_POST['Password']==$_POST['confPassword'])
        	    {
        	        $update=$this->Adminlogin->update_password($mobile,$data);
        	        if($update)
        	        {
        	            $this->session->set_userdata('user',$this->session->userdata('email'));
        	             echo json_encode(array('error'=>0));
        	        }
        	        else
        	        {
        	            echo json_encode(array('error'=>1 ,'message'=>'Some error Occured !'));
        	        }
                   
        	    }
        	    else
        	    {
        	        echo json_encode(array('error'=>1,'message'=>'Confirm Password field does not match with Password field!'));
        	    }
	    }
	    
	    else
	    {
	           echo json_encode(array('error'=>1 ,'message'=>'Please enter a valid OTP!'));
	    }
	    
	}
}
