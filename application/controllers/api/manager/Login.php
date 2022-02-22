<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH.'/libraries/REST_Controller.php');
class Login extends REST_Controller 
{
  
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Managers_model');
    }

    public function authenticate_post()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            if( form_error( 'username' ) )
            {
                $msg = form_error( 'username' );
            }
            else
            {
                $msg = form_error( 'password' );
            }

            $this->response( [ 'status' => 201, 'error' =>true, 'message' => strip_tags($msg) ] );
        }

        $data['email'] = $this->input->post('username');
        $data['pass_word'] = md5( $this->input->post('password') );
        $data['status'] = 'ACTIVE' ;

        $login_check = $this->Managers_model->get_single_manager_where( $data );

        if ( $login_check )
        {
            unset( $login_check[ 'pass_word' ] );

            $length=35;
            $key = '';
            $keys = array_merge(range(0, 9), range('a', 'z'));
            for ($i = 0; $i < $length; $i++) 
            {
              $key .= $keys[array_rand($keys)];
            }

            $login_check['token'] = $key;

            $response = $login_check;

            if( $this->Managers_model->update_single_manager( [ 'token' => $key ], $login_check[ 'id' ] ) )
            {
                $this->response( ['status' => 200, 'error' =>false ,'message'=> 'Manager Logged In Successfully' , 'data' => $response ] );
            }
            else
            {
                $this->response( ['status' => 201, 'error' =>true ,'message'=> 'Unable To Login, Please Try Again' ] );
            }

        }
        else
        {
            $this->response( ['status' => 201, 'error' =>true ,'message'=> 'Invalid Username Or Password' ] );
        }
    }
}
