<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    // function __construct()
    // {
    //     parent::__construct();
    //     if( $this->session->manager )
    //     {
    //         redirect('manager/home');
    //     }

    //     $this->load->model( 'Managers_model' );
    // }


    public function index()
    {
        // $this->load->view('manager/login');
    }


    // public function logincheck()
    // {

    //     $this->form_validation->set_rules('email', 'Email', 'valid_email');
    //     $this->form_validation->set_rules('password', 'Password', 'trim|required');

    //     if ($this->form_validation->run() == FALSE)
    //     {
    //         $this->load->view('manager/login');
    //     }
    //     else
    //     {
    //         $data['email'] = $this->input->post('email');
    //         $data['pass_word'] = md5( $this->input->post('password') );

    //         $login_check = $this->Managers_model->get_single_manager_where( $data );

    //         if ( $login_check )
    //         {
    //             $this->session->unset_userdata( 'user' );
                
    //             $this->session->manager = $login_check['name'] ;
    //             $this->session->manager_id = $login_check[ 'id' ] ;

    //             redirect('manager/home', 'refresh');
    //         }
    //         else
    //         {
    //             $this->session->set_flashdata('error', 'Invalid username/Password');
    //             redirect('manager/login', 'refresh');
    //         }
    //     }
    // }





    // public function sendotp()

    // {



    //         $email=$this->input->post('email');



    //         $result=$this->Adminlogin->checkemail($email);

    //         if(!empty($result))

    //         {

    //             $res=$this->Otp_model->userotpsending($result['mobile']);

    //             if($res)

    //             {

    //                 $this->session->set_userdata('email',$email);

    //             echo json_encode(array('error'=>0 ,'mobile'=>$result['mobile'],'message'=>'OTP sent Successfully!'));

    //             }

    //             else

    //             {

    //                 echo json_encode(array('error'=>1 ,'message'=>'Some error Occured'));

    //             }

    //         }

    //         else

    //         {

    //             echo json_encode(array('error'=>1 ,'message'=>'Entered Email did not found in system !'));

    //         }



    // }



    // public function resendotp()

    // {

    //     $res=$this->Otp_model->userotpsending($_POST['mobile']);

    //            if($res)

    //             {

    //                 echo json_encode(array('error'=>0 ,'message'=>'OTP sent Successfully!'));

    //             }

    //             else

    //             {

    //                 echo json_encode(array('error'=>1 ,'message'=>'Some error Occured'));

    //             }

    // }



    // public function checkotp()

    // {



    //    // $otp=$_POST['otp'];

    //    $otp=$_POST['otp'];

    //     $mobile=$_POST['mobile'];

    //    // $result=$this->Otp_model->checkmobiledata($mobile,$otp);

    //     if($otp=='1234')

    //     {

    //         $this->session->set_userdata('user',$this->session->userdata('email'));

    //         echo json_encode(array('error'=>0));

    //     }

    //     else

    //     {

    //          echo json_encode(array('error'=>1));

    //     }

    // }

}
