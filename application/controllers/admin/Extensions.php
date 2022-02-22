<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Extensions extends CI_Controller {
	function __construct()
	{
		parent::__construct();
			if(!isset($this->session->userdata['user']))
       		{
     			redirect('admin/login');
        	}

			$this->load->model('User_model');
		$this->load->model('Loan_apply_model');
		$this->load->model('Loan_extension_model');
		date_default_timezone_set('asia/kolkata');
	}

	public function new_extensions(){
	    $this->data['page'] = 'extensions';
	    $this->data['sub_page'] = 'new_extensions';
	    $this->data['page_title'] = 'New Extensions Request';
	    $this->data['extensions']= $this->Loan_extension_model->get_extentions_by_status('PENDING');	
	    $this->load->view('admin/extensions',$this->data);
	}
	public function approved_extensions(){
	    $this->data['page'] = 'extensions';
	    $this->data['sub_page'] = 'approved_extensions';
	    $this->data['page_title'] = 'Approved Extensions';
	    $this->data['extensions']= $this->Loan_extension_model->get_extentions_by_status('APPROVED');	
	    $this->load->view('admin/extensions',$this->data);
	}
	public function rejected_extensions(){
	    $this->data['page'] = 'extensions';
	    $this->data['sub_page'] = 'rejected_extensions';
	    $this->data['page_title'] = 'All Rejected Extensions';
	    $this->data['extensions']= $this->Loan_extension_model->get_extentions_by_status('REJECTED');	
	    $this->load->view('admin/extensions',$this->data);
	}
	public function UpdateloanStatus(){
	    $lp = $this->Loan_extension_model->getloanextentiondetailbyleid($_POST['le_id']);
	    $loan = $this->Loan_apply_model->getloandetail($lp['la_id']);
	    $data['extention_status'] = $_POST['value'];
	    $data['reject_comment'] = $_POST['message'];
        $arrNotification["title"]   =   "Extention Request Rejected";
        $arrNotification["body"] =   "Your extention request regarding loan of Rs.".$loan['amount']." has been rejected. Please re-apply after 24 Hours or contact us at +91-9818929408 "; 
	    if($_POST['value'] == 'APPROVED'){
            $loan_apply_detail = $this->Loan_apply_model->getloandetail($lp['la_id']);
	        $la_data['ext_status'] = 'ACTIVE';
	        $la_data['loan_end_date']=date('Y-m-d h:i:s', strtotime($loan_apply_detail['loan_end_date'].'+'.((int)$loan_apply_detail['extension_days']-1).' days'));
	        $la_data['panelty_calc_date']=date('Y-m-d', strtotime($loan_apply_detail['panelty_calc_date'].'+'.((int)$loan_apply_detail['extension_days']-1).' days'));
            $la_data['ext_days'] = $loan_apply_detail['ext_days']+$loan_apply_detail['extension_days'];
            $la_data['ext_charges'] = $loan_apply_detail['ext_charges']+(($loan_apply_detail['extension_charges']/100)*$loan_apply_detail['amount']);
            $la_data['loan_closer_amount'] = $loan_apply_detail['loan_closer_amount']+(($loan_apply_detail['extension_charges']/100)*$loan_apply_detail['amount']);
            $la_data['reject_comment'] = 'Your Extension request is approved successfully!';
	        $this->Loan_apply_model->update($lp['la_id'],$la_data);
            $arrNotification["title"]   =   "Extention Request Approved";
            $arrNotification["body"] =   "Your extention request regarding loan of Rs.".$loan['amount']." has been approved by Easy Loan Mantra.Thanks ";
	    }
	    $sql = $this->Loan_extension_model->update($_POST['le_id'],$data);
	    if($sql){
	        $user = $this->User_model->GetUserById($lp['user_id']);
            $arrNotification["sound"]   =   "default";
            $arrNotification["type"]    =   1; 
            $arrNotification["action"]  =   "activity";
            $this->Notification_model->SendPushnotification($user->fcm_token, $arrNotification,'Android');
            $candata['default_title'] = $arrNotification["title"];
            $candata['default_message'] = $arrNotification["body"];
            $this->User_model->updateUserDataByUserId($lp['user_id'],$candata);
    		$error['status'] = false;
    		$error['message'] = 'Status Updated Successfully';
	    }else{
    		$error['status'] = true;
    		$error['message'] = 'Status Not Updated';
	    }
	    echo json_encode($error);
	}
	
}
