<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cronjob extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Loan_apply_model');
		date_default_timezone_set('asia/kolkata');
	}

	public function generate_panelty()
	{   
	   // $results = $this->Loan_apply_model->get_loan_by_status_panelty();
	   // $paneltyData = [];
	   //// echo '<pre>';
	   //// print_r($results);
	   // foreach($results as $loan){
	   //    // echo strtotime($loan['loan_end_date']).'-'.strtotime(date('Y-m-d h:i:s')).'<br>';
    //     	if($loan['loan_end_date'] != NUll && strtotime($loan['loan_end_date']) < strtotime(date('Y-m-d h:i:s')) && $loan['panelty_status'] == 'ACTIVE' && strtotime($loan['panelty_calc_date']) != strtotime(date('Y-m-d'))){
	   //         $panelty_days = round(abs(round(strtotime($loan['panelty_calc_date']) - strtotime(date('Y-m-d h:i:s')) ))/ 86400);// Calculate the days between last calculated date of panelty and current date 
    //             $paneltyData['panelty_status'] = 'ACTIVE';//set panelty status to active
    //             $paneltyData['loan_panelty_days'] = $loan['loan_panelty_days']+$panelty_days; //add the new panelty days to old ones
    //             $paneltyData['loan_panelty_amount'] = $loan['loan_panelty_amount']+(($loan['penalty']/100)*$loan['amount'])*($panelty_days);//add the new loan_panelty_amount to old ones
    //         	$paneltyData['loan_closer_amount'] = $loan['loan_closer_amount']+(($loan['penalty']/100)*$loan['amount'])*($panelty_days);//add the new loan_closer_amount to old ones
    //         	$paneltyData['panelty_calc_date'] = date('Y-m-d');//set the last calulated date of panelty to the current date
    //             $sql = $this->Loan_apply_model->update($loan['la_id'],$paneltyData);//update to the loan table
    //     	}
	   // }
	   // return $sql;
	}

}
