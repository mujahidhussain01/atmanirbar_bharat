<?php ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH.'/libraries/REST_Controller.php');
class Test extends REST_Controller 
{
  		public function __construct() 
  		{
               	parent::__construct();
               	$this->load->model('Otp_model');
               	$this->load->model('Notification_model');
 	    }
 	    public function push_notification_test_get(){
 	        $arrNotification= [];	
            $arrNotification["title"]   =   "Easy loan mantra push notification test";
            $arrNotification["body"] =   "this is test notification"; 
            $arrNotification["sound"]   =   "default";
            $arrNotification["type"]    =   1; 
            $arrNotification["action"]  =   "activity";
            $result = $this->Notification_model->SendPushnotification($_GET['token'], $arrNotification,'Android');
            $this->response(['status' => 200, 'error' =>false, 'data' => json_decode($result) ]);
 	    }
 	    public function send_otp_get(){
 	        $mobile = $_GET['mobile'];
 	        $response = $this->Otp_model->otpsending($mobile);
            $this->response(['status' => 200, 'error' =>false, 'data' => $response ]);
 	    }
}
ob_flush();
?>