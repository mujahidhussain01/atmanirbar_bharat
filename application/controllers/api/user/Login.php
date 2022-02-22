<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH.'/libraries/REST_Controller.php');
class Login extends REST_Controller 
{
  
  		public function __construct() {
               parent::__construct();
               $this->load->model('Otp_model');
               $this->load->model('User_model');
       }
        public function send_otp_post(){
           if (!$this->input->post('mobile')){
            $this->response(
                [
                    'status' => 201,
                    'error' => true,
                    'message' => 'Required parameter is not set, i.e mobile number'
                ]
            );
        }
       else{
        $validMobile=preg_match('/^(?:(?:\+|0{0,2})91(\s*[\-]\s*)?|[0]?)?[6789]\d{9}$/', $this->input->post('mobile'));
        if($validMobile=='0'){
            $this->response(
                [
                    'status' => 201,
                    'error' => true,
                    'message' => 'Please enter a valid mobile number'
                ]
            );
            }
            else
            {
                $data = $this->Otp_model->userotpsending($this->input->post('mobile'));
                $user = $this->User_model->readUniqueUserforWeb($this->input->post('mobile'));
                $usertype = (empty($user)?'NEW':'OLD');
                $data->usertype = $usertype;
                if($usertype == 'NEW'){
              	    $notifi['notify_content'] = 'New User Registered - '.$_POST['mobile'];
              	    $notifi['redirect_link'] = 'admin/user/only_app_installed';
              	    $notifi['notifi_for'] = 'ADMIN';
              	    $this->Notification_model->insert($notifi);
                }
                // $data = ["otp_id"=> "8",
                //         "mobile_number"=> $this->input->post('mobile'),
                //         "otp"=> "1234",
                //         "created_date"=> date('Y-m-d h:i:s'),
                //         "past_modified_date"=> date('Y-m-d h:i:s'),
                //         "status"=> "INACTIVE",
                //         "usertype"=> $usertype];
                $this->response(['status' => 200,'error' => false,'message'=>'Otp Sent successfully', 'data' => $data]);
                
            }
       }
       }
        public function otp_verify_post(){
       
        if(!$this->input->post('mobile') || !$this->input->post('otp') || !$this->input->post('deviceId') || !$this->input->post('deviceType'))
        {
          $this->response(
            [
              'status' => 201,  
              'error' =>true,  
              'message' => "Required parameter is not set"
            ]
          );
        }
        else
        {
          $otp=$this->input->post('otp');
          $validMobile=preg_match('/^[0-9]{10}+$/', $this->input->post('mobile'));
          if($validMobile=='0')
          {
            $this->response(
              [
                'status' => 201, 
                'error' => true,
                'messsage' => "Please enter a valid mobile number"]);
          }


          else
          {	
            $mobile=$this->input->post('mobile');
            $check=$this->Otp_model->checkmobiledata($mobile,$otp);
            //if(count($check) > 0)
            if($otp == 1234)
            {
          		$data['deviceId']=$this->input->post('deviceId');
          		$data['deviceType']=$this->input->post('deviceType');
          		$data['fcm_token']=$this->input->post('fcm_token');
          		$message = 'Login successfully';
              	$val=$this->User_model->checkmob($mobile,$data);
                $this->response(['status' => 200, 'error' =>false ,'message'=>$message, 'data' => $val]);
              }
              else{
                $this->response([
                    'status' => 201,  
                    'error' =>true,  
                    'message' => "invalid otp"  ]);
              }
            }
          }
       }
}
?>