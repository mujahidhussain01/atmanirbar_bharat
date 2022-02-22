<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH.'/libraries/REST_Controller.php');
class Home extends REST_Controller 
{
  		public function __construct() {
               parent::__construct();
               $this->load->model('User_model');
               $this->load->model('Loan_setting_model');
               $this->load->model('Loan_apply_model');
       }
        public function index_get(){
            if(!$this->input->get('token')){
                    $this->response(['status' => 201, 'error' =>true, 'message' => 'Required parameter is not set']);
            }
            else{
        		$userdata = $this->User_model->GetUserByTokenForApp($_GET['token']);
        		if (!empty($userdata)) {
        		    $result['user'] = $userdata;
        		    $loan = $this->Loan_apply_model->getuserlastPaidloandetail($userdata->userid);
        		    if(!empty($loan)){
        		        $remaining_days = round(round(strtotime($loan['loan_end_date']) - strtotime(date('Y-m-d h:i:s')) )/ 86400);
        		        if($remaining_days > 0 && $remaining_days <= 3){
        		            $result['user']->default_title = 'Your repayment date is near';
        		            $result['user']->default_message = 'your loan will end in '.$remaining_days.($remaining_days == 1?'day':'days').'.Please make repayment to avoid panelty charges. ';
        		        }
        		        if($remaining_days == 1){
        		            $result['user']->default_title = 'Your Loan will end today';
        		            $result['user']->default_message = 'Today is the last date of repayment of your loan of Rs. '.$loan['amount'].' .Please make repayment to avoid panelty charges. ';
        		        }
        		        // if($loan['loan_end_date'] != NUll && strtotime($loan['loan_end_date']) <= strtotime(date('Y-m-d h:i:s'))  && strtotime($loan['panelty_calc_date']) != strtotime(date('Y-m-d'))){
            		    //     $panelty_days = round(abs(round(strtotime(date('Y-m-d h:i:s') - strtotime($loan['panelty_calc_date'])) ))/ 86400);
                		//     $paneltyData['panelty_status'] = 'ACTIVE';
                		//     $paneltyData['panelty_calc_date'] = date('Y-m-d');
                		//     $paneltyData['loan_panelty_days'] = $loan['loan_panelty_days']+$panelty_days; 
                		//     $paneltyData['loan_panelty_amount'] = $loan['loan_panelty_amount']+(($loan['penalty']/100)*$loan['amount'])*$panelty_days;
                		//     $paneltyData['loan_closer_amount'] = $loan['loan_closer_amount']+((($loan['penalty']/100)*$loan['amount'])*$panelty_days);
                		//     $this->Loan_apply_model->update($loan['loan_id'],$paneltyData);
                		//     $result['user']->default_title = 'Your loan is under panelty';
        		        //     $result['user']->default_message = 'Your loan is running under panelty, with the panelty ammount of Rs '.$paneltyData['loan_panelty_amount'].' for the '.$paneltyData['loan_panelty_days'].' days of panelty';
            		    // } 
        		    }
        		    $loan_list = $this->Loan_setting_model->get_loan_settings_for_app();
        		    // $j=0;
        		    // for($i=0;$i<count($loan_list);$i++){
        		    //     $check = $this->Loan_apply_model->loantakenbyuserornot($userdata->userid,$loan_list[$i]['loan_id']);
        		        
        		    //     if(!empty($check)){
        		    //         $loan_list[$i]['eligible'] = true;
        		    //         $j++;
        		    //     }else{
        		    //         $loan_list[$i]['eligible'] = false;
        		    //         $loan_list[$j]['eligible'] = true;
        		    //     }
        		    // }
        		    $result['loan_list'] = $loan_list;
                    $this->response(['status' => 200, 'error' =>false, 'data'=>$result ]);
        		}
        		else {
        			$error = true;
        			$message = "Invalid User Token";
        			$this->response(['status' => 201, 'error' => true, 'message' => $message]);
        		}
           }
        }
}
?>