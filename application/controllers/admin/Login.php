<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Login extends CI_Controller {

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

		

	  $this->load->view('admin/login');

	}



	public function logincheck()

	{

			    $this->form_validation->set_rules('email', 'Email', 'valid_email');

                $this->form_validation->set_rules('password', 'Password', 'trim|required');



                if ($this->form_validation->run() == FALSE)

                {

                        $this->load->view('admin/login');

                }

                else

                {

                	$data['email']=$this->input->post('email');

                	$data['password']=md5($this->input->post('password'));

                	$result=$this->Adminlogin->login_check($data);



                	if($result)

                	{
						$this->session->unset_userdata( 'manager' );
						$this->session->unset_userdata( 'manager_id' );

                		$this->session->set_userdata('user',$data['email']);

                        redirect('admin');

                	}

                	else

                	{

                		$this->session->set_flashdata('error','Invalid username/Password');

                		redirect('admin/login');

                	}

                }

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

	

	public function resendotp()

	{

	    $res=$this->Otp_model->userotpsending($_POST['mobile']);

	           if($res)

                {

                    echo json_encode(array('error'=>0 ,'message'=>'OTP sent Successfully!'));

                }

                else

                {

                    echo json_encode(array('error'=>1 ,'message'=>'Some error Occured'));

                }

	}

	

	public function checkotp()

	{



	   // $otp=$_POST['otp'];

	   $otp=$_POST['otp'];

	    $mobile=$_POST['mobile'];

	   // $result=$this->Otp_model->checkmobiledata($mobile,$otp);

	    if($otp=='1234')

	    {

	        $this->session->set_userdata('user',$this->session->userdata('email'));

            echo json_encode(array('error'=>0));

	    }

	    else

	    {

             echo json_encode(array('error'=>1));

	    }

	}

}

