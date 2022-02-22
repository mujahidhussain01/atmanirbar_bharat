<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH.'/libraries/REST_Controller.php');
class Loan extends REST_Controller 
{
  	public function __construct() {
               parent::__construct();
               $this->load->model('User_model');
               $this->load->model('Loan_setting_model');
               $this->load->model('Loan_apply_model');

       }

	// -------------------------------------------


	
	public function index_get()
	{
            if(!$this->input->get('token') OR !$this->input->get('loan_id')){
                    $this->response(['status' => 201, 'error' =>true, 'message' => 'Required parameter is not set']);
            }
            else{
        		$userdata = $this->User_model->GetUserByToken($_GET['token']);
        		if (!empty($userdata))
				{
        		    if( $loan = $this->Loan_apply_model->getloandetail($_GET['loan_id']) )
					{

        		    $result['basic_detail'] = $loan;
        		  //  $result['basic_detail']['loan_closer_amount'] = 0;
        		    
        		  //  $loan = $this->Loan_apply_model->getloandetail($_GET['loan_id']);
        		  //  if($loan['/panelty_status'] != 'ACTIVE'){
        		    //    if($loan['loan_status'] == 'PAID' && $loan['loan_end_date'] != NUll && strtotime(date('Y-m-d',strtotime($loan['loan_end_date']))) <= strtotime(date('Y-m-d'))  && strtotime($loan['panelty_calc_date']) != strtotime(date('Y-m-d')))
					//    {
            		//         $panelty_days = round(abs(round(strtotime(date('Y-m-d h:i:s') - strtotime($loan['panelty_calc_date'])) ))/ 86400);
                	// 	    $paneltyData['panelty_status'] = 'ACTIVE';
                	// 	    $paneltyData['panelty_calc_date'] = date('Y-m-d');
                	// 	    $paneltyData['loan_panelty_days'] = $loan['loan_panelty_days']+$panelty_days; 
                	// 	    $paneltyData['loan_panelty_amount'] = $loan['loan_panelty_amount']+(($loan['penalty']/100)*$loan['amount'])*$panelty_days;
                	// 	    $paneltyData['loan_closer_amount'] = $loan['loan_closer_amount']+((($loan['penalty']/100)*$loan['amount'])*$panelty_days);
                	// 	    $this->Loan_apply_model->update($_GET['loan_id'],$paneltyData);
                	// 	    $loan = $this->Loan_apply_model->getloandetail($_GET['loan_id']);
            		//         $result['basic_detail']['loan_closer_amount'] = $loan['loan_closer_amount'];
        		    //         $result['basic_detail']['reject_comment'] = 'Your loan is running under panelty, with the panelty ammount of Rs '.$paneltyData['loan_panelty_amount'].' for the '.$paneltyData['loan_panelty_days'].' days of panelty';
            		//     } 
        		  //  }else{
            // 		    $result['basic_detail']['loan_closer_amount'] = $loan['loan_closer_amount'];
        		  //  }
        		    $result['basic_detail']['loan_end_date'] = date('D d,M Y',strtotime($loan['loan_end_date']));
        		    // $result['basic_detail']['extension_percent'] = $loan['extension_charges'];
        		    // $result['basic_detail']['extension_charges'] = ($loan['extension_charges']/100)*$loan['amount'];
        		    // if($loan['ext_status'] == 'ACTIVE'){
        		    //     $extentions = $this->Loan_extension_model->getAllloanextentiondetail($_GET['loan_id']);
        		    // }else{
        		    //     $extentions = [];
        		    // }
        		    // $result['extentions'] = $extentions;
                    $this->response(['status' => 200, 'error' =>false, 'data'=>$result ]);
					
				}
				else
				{
                    $this->response(['status' => 201, 'error' =>true, 'message'=> "Invalid Loan ID" ]);
				}
        		}
        		else {
        			$error = true;
        			$message = "Invalid User Token";
        			$this->response(['status' => 201, 'error' => true, 'message' => $message]);
        		}
           }
    }
	
	public function apply_loan_post()
	{
		// print_r($_POST);exit;
			if(!$this->input->post('token', true ) OR !$this->input->post('loan_id', true ))
			{
				$this->response(['status' => 201, 'error' =>true, 'message' => implode(',',$_POST).'Required parameter is not set'.(!$this->input->post('token', true )?' Token Missing':'').''.(!$this->input->post('loan_id', true )?' Loan Id Is missing':'')]);
			}
			else
			{
				// temporarily loading temp model ----
				// $this->load->model( 'Loan_apply_model' );

				$userdata = $this->User_model->GetUserByToken($_POST['token']);
				if (!empty($userdata))
				{
					$prev_loan = $this->Loan_apply_model->getuserlastloandetail($userdata->userid);

					if(empty($prev_loan))
					{

						if( $loan = $this->Loan_setting_model->getloan_setting($_POST['loan_id'], 'NORMAL' ))
						{


							$data['loan_id'] = $_POST['loan_id'];
							$data['user_id'] = $userdata->userid;

							$data['amount'] = $loan[ 'amount' ];
							$data['rate_of_interest'] = $loan[ 'rate_of_interest' ];
							$data['process_fee_percent'] = $loan[ 'process_fee_percent' ];
							$data['processing_fee'] = $loan[ 'processing_fee' ];
							$data['loan_duration'] = $loan[ 'loan_duration' ];
							$data['payment_mode'] = $loan[ 'payment_mode' ];
							$data['bouncing_charges_percent'] = $loan[ 'bouncing_charges_percent' ];
							$data['bouncing_charges'] = $loan[ 'bouncing_charges' ];
							$data['reject_comment'] = 'Your loan application is under process please wait for the approval';
							$data['emi_amount'] = $loan[ 'emi_amount' ];
							$data['payable_amt'] = (intval( $loan[ 'amount' ] ) - intval( $loan[ 'processing_fee' ] ) ) + ceil( ( intval( $loan[ 'amount' ] ) / 100 ) * intval( $loan[ 'rate_of_interest' ] ) );
							$data['remaining_balance'] = intval( $loan[ 'amount' ] ) + ceil( ( intval( $loan[ 'amount' ] ) / 100 ) * intval( $loan[ 'rate_of_interest' ] ) );
							$data['loan_closer_amount'] = $data[ 'remaining_balance' ];


							$sql = $this->Loan_apply_model->insert($data);

							if($sql)
							{
								$notifi['notify_content'] = 'New Loan Request from - '.$userdata->mobile.' of amount Rs'.$loan['amount'];
								$notifi['redirect_link'] = 'admin/loan';
								$notifi['notifi_for'] = 'ADMIN';
								$this->Notification_model->insert($notifi);
								$userDefaultMsgdata['default_title'] = 'Loan Applied successfully';

								$userDefaultMsgdata['default_message'] = 'your loan of Rs.'.$loan['amount'].' is under process, we will keep you informed. Thanks';
								$this->User_model->updateUserDataByUserId($userdata->userid,$userDefaultMsgdata);
								$message = 'Loan Applied successfully'; 
							}
							else
							{
								$message = 'Unable to apply for the loan';  
							}
							$this->response(['status' => 200, 'error' =>false, 'message'=>$message ]);  
						}
						else
						{
							$message = "Invalid Loan ID";
							$this->response(['status' => 201, 'error' => true, 'message' => $message]);
						}
					}
					else
					{
						if(($prev_loan['loan_status'] == 'PENDING' OR  $prev_loan['loan_status'] == 'RUNNING' OR $prev_loan['loan_status'] == 'APPROVED' ) AND $prev_loan['money_return'] == 'ACTIVE')
						{
							$error = true;
							$message = "Payment of your previous loan is in under verification. please wait until the Admin verifies your payment ";
							$this->response(['status' => 201, 'error' => true, 'message' => $message]);
						}
						elseif( $prev_loan['loan_status'] == 'PENDING' OR $prev_loan['loan_status'] == 'RUNNING' OR $prev_loan['loan_status'] == 'APPROVED' )
						{
							$error = true;
							$message = "A loan is already is running in your profile please wait until the loan completes ";
							$this->response(['status' => 201, 'error' => true, 'message' => $message]);
						}
						else
						{
							$loan = $this->Loan_setting_model->getloan_setting($_POST['loan_id']);
							$data['user_id'] = $userdata->userid;
							$data['loan_id'] = $_POST['loan_id'];

							$data['loan_closer_amount'] = $loan[ 'amount' ];
							$data['amount'] = $loan[ 'amount' ];
							$data['rate_of_interest'] = $loan[ 'rate_of_interest' ];
							$data['process_fee_percent'] = $loan[ 'process_fee_percent' ];
							$data['processing_fee'] = $loan[ 'processing_fee' ];
							$data['loan_duration'] = $loan[ 'loan_duration' ];
							$data['payment_mode'] = $loan[ 'payment_mode' ];
							$data['bouncing_charges_percent'] = $loan[ 'bouncing_charges_percent' ];
							$data['bouncing_charges'] = $loan[ 'bouncing_charges' ];
							$data['reject_comment'] = 'Your loan application is under process please wait for the approval';
							$data['emi_amount'] = $loan[ 'emi_amount' ];
							$data['payable_amt'] = ( intval( $loan[ 'amount' ] ) - intval( $loan[ 'processing_fee' ] ) ) + ceil( ( intval( $loan[ 'amount' ] ) / 100 ) * intval( $loan[ 'rate_of_interest' ] ) );
							$data['remaining_balance'] = intval( $loan[ 'amount' ] ) + ceil( ( intval( $loan[ 'amount' ] ) / 100 ) * intval( $loan[ 'rate_of_interest' ] ) );
							$data['loan_closer_amount'] = $data[ 'remaining_balance' ];

							$sql = $this->Loan_apply_model->insert($data);

							if($sql)
							{
								$notifi['notify_content'] = 'New Loan Request from - '.$userdata->mobile.' of amount Rs'.$loan['amount'];
								$notifi['redirect_link'] = 'admin/loan';
								$notifi['notifi_for'] = 'ADMIN';
								$this->Notification_model->insert($notifi);
								$userDefaultMsgdata['default_title'] = 'Loan Applied successfully';
								$userDefaultMsgdata['default_message'] = 'your loan of Rs.'.$loan['amount'].' is under process, we will keep you informed. Thanks';
								$this->User_model->updateUserDataByUserId($userdata->userid,$userDefaultMsgdata);
								$message = 'Loan Applied successfully'; 
							}
							else
							{
								$message = 'Unable to apply for the loan';  
							}
							$this->response(['status' => 200, 'error' =>false, 'message'=>$message ]);   
						}
					}
				}
				else
				{
					$error = true;
					$message = "Invalid User Token";
					$this->response(['status' => 201, 'error' => true, 'message' => $message]);
				}
		}
	}


	public function manual_loan_setting_get()
	{

		$token = trim( $this->input->get( 'token', true ) );
		
		if( empty( $token ) )
		{
			$this->response(
				[
					'status' => 201,
					'error' => validation_errors(),
					'message' => 'Token Required'
				]);

			return;
		}
		else
		{
			$userdata = $this->User_model->GetUserByToken( $this->input->get( 'token', true ) );

			if ( !empty( $userdata ) )
			{
				$this->load->model( 'manual_loan_setting_model' );
				$data = $this->manual_loan_setting_model->get_manual_loan_setting();

				$this->response( [
					'status' => 200,
					'error' =>false,
					'data'=> [
						'rate_of_interest' => $data[ 'rate_of_interest' ],
						'process_fee_percent' => $data[ 'process_fee_percent' ],
						'bouncing_charges_percent' => $data[ 'bouncing_charges_percent' ],
					] ]);  
			}
			else
			{
				$error = true;
				$message = "Invalid User Token";
				$this->response(['status' => 201, 'error' => true, 'message' => $message]);
			}
		}
	
	}

	public function apply_manual_loan_post()
	{
		$this->form_validation->set_rules( 'token', 'Token', 'trim|required');
		$this->form_validation->set_rules( 'amount', 'Amount', 'trim|required|numeric');
		$this->form_validation->set_rules( 'loan_duration', 'Loan Duration', 'trim|required|numeric');
		$this->form_validation->set_rules( 'payment_mode', 'Payment Mode', 'trim|required');
		
		if( $this->form_validation->run() !== true )
		{
			if( form_error( 'token' ) )
			{
				$message = form_error( 'token' );
			}
			else if( form_error( 'amount' ) )
			{
				$message = form_error( 'amount' );
			}
			else if( form_error( 'loan_duration' ) )
			{
				$message = form_error( 'loan_duration' );
			}
			else if( form_error( 'payment_mode' ) )
			{
				$message = form_error( 'payment_mode' );
			}
			else
			{
				$message = 'Invalid Form Value';
			}

			$this->response(
				[
					'status' => 201,
					'error' =>true,
					'message' => strip_tags( $message )
				]);

			return;
		}
		else
		{
			$userdata = $this->User_model->GetUserByToken( $_POST['token'] );

			if ( !empty($userdata))
			{


				if( $prev_loan = $this->Loan_apply_model->getuserlastloandetail($userdata->userid) )
				{
					if(($prev_loan['loan_status'] == 'PENDING' OR  $prev_loan['loan_status'] == 'RUNNING' OR $prev_loan['loan_status'] == 'APPROVED' ) AND $prev_loan['money_return'] == 'ACTIVE')
					{
						$error = true;
						$message = "Payment of your previous loan is in under verification. please wait until the Admin verifies your payment ";
						$this->response(['status' => 201, 'error' => true, 'message' => $message]);
						return;
					}
					else if( $prev_loan['loan_status'] == 'PENDING' OR $prev_loan['loan_status'] == 'RUNNING' OR $prev_loan['loan_status'] == 'APPROVED' )
					{
						$error = true;
						$message = "A loan is already is running in your profile please wait until the loan completes ";
						$this->response(['status' => 201, 'error' => true, 'message' => $message]);
						return;
					}
				}



				// calculate loan data ----

				$loan_amount = intval( $this->input->post( 'amount', true ) );

				$loan_duration = intval( $this->input->post( 'loan_duration', true ) ) ?? 1;
				$payment_mode = $this->input->post( 'payment_mode', true );

				$this->load->model( 'manual_loan_setting_model' );

				$manual_loan_setting = $this->manual_loan_setting_model->get_manual_loan_setting();

				$rate_of_interest = $manual_loan_setting[ 'rate_of_interest' ];
				$process_fee_percent = $manual_loan_setting[ 'process_fee_percent' ];
				$bouncing_charges_percent = $manual_loan_setting[ 'bouncing_charges_percent' ];

				$interest_amount = ceil( ( $loan_amount / 100 ) * $rate_of_interest );
				$processing_fee = ceil( ( $loan_amount / 100 ) * $process_fee_percent );
				$bouncing_charges = ceil( ( $loan_amount / 100 ) * $bouncing_charges_percent );

				$final_amount = $loan_amount + $interest_amount;

				// set initial emi count
				$total_emi_count = 1;
	
				// get value to be divided by loan duration to calculate emi amount
				$divided_by = 1;
	
				if( $payment_mode == 'weekly' )
				{
					$divided_by = 7;
				}
				else if( $payment_mode == 'every-15-days' )
				{
					$divided_by = 15;
				}
				else if( $payment_mode == 'monthly' )
				{
					$divided_by = 30;
				}
	
				$total_emi_count = floor( $loan_duration / $divided_by ) ;
	
				if( $total_emi_count >= 1 )
				{
					$emi_amount = ceil( $final_amount / $total_emi_count );
				}
				else
				{
					$emi_amount = $final_amount;
				}


				// calculate loan data End ----


				$data['user_id'] = $userdata->userid;
				$data['amount'] = $loan_amount;
				$data['rate_of_interest'] = $rate_of_interest;
				$data['process_fee_percent'] = $process_fee_percent;
				$data['processing_fee'] = $processing_fee;
				$data['loan_duration'] = $loan_duration;
				$data['payment_mode'] = $payment_mode;
				$data['bouncing_charges_percent'] = $bouncing_charges_percent;
				$data['bouncing_charges'] = $bouncing_charges;
				$data['reject_comment'] = 'Your loan application is under process please wait for the approval';
				$data['emi_amount'] = $emi_amount;
				$data['payable_amt'] = $final_amount - $processing_fee;
				$data['remaining_balance'] = $final_amount;
				$data['loan_closer_amount'] = $final_amount;


				$sql = $this->Loan_apply_model->insert( $data );

				if( $sql )
				{
					$notifi['notify_content'] = 'New Loan Request from - '.$userdata->mobile.' of amount Rs'.$loan_amount;
					$notifi['redirect_link'] = 'admin/loan';
					$notifi['notifi_for'] = 'ADMIN';

					$this->Notification_model->insert( $notifi );
					$userDefaultMsgdata['default_title'] = 'Loan Applied successfully';

					$userDefaultMsgdata['default_message'] = 'your loan of Rs.'.$loan_amount.' is under process, we will keep you informed. Thanks';
					$this->User_model->updateUserDataByUserId($userdata->userid,$userDefaultMsgdata);
					$message = 'Loan Applied successfully'; 
				}
				else
				{
					$message = 'Unable to apply for the loan, Please Try Again Later';  
				}

				$this->response(['status' => 200, 'error' =>false, 'message'=>$message ]);  
			}
			else
			{
				$error = true;
				$message = "Invalid User Token";
				$this->response(['status' => 201, 'error' => true, 'message' => $message]);
			}
		}
	}


	public function user_loan_list_get()
	{
		if(!$this->input->get('token')){
				$this->response(['status' => 201, 'error' =>true, 'message' => 'Required parameter is not set']);
		}
		else
		{
			$userdata = $this->User_model->GetUserByToken($_GET['token']);
			if (!empty($userdata))
			{
				if( $loan = $this->Loan_apply_model->getuserallloanlist($userdata->userid) )
				{
					$this->response(['status' => 200, 'error' =>false, 'data'=>$loan ]);
				}
				else
				{
					$this->response(['status' => 201, 'error' =>true, 'message'=> "Invalid Loan ID" ]);
				}
			}
			else {
				$error = true;
				$message = "Invalid User Token";
				$this->response(['status' => 201, 'error' => true, 'message' => $message]);
			}
		}
	}


	public function loan_payments_get()
	{
		if( !$this->input->get('token') )
		{
				$this->response( [ 'status' => 201, 'error' =>true, 'message' => 'Required parameter is not set' ] );
		}
		else
		{
			$userdata = $this->User_model->GetUserByToken( $_GET['token'] );

			if ( !empty($userdata) )
			{
				$this->load->model( 'Loan_payments_model' );

				$result = $this->Loan_payments_model->get_pending_payments_of_user( $userdata->userid );
				$result1[0] = $this->Loan_payments_model->get_upcoming_payment_of_user( $userdata->userid );

				for( $i=0 ; $i< count( $result ); $i++ )
				{
					$result[$i]['lp_doc'] = date('D d,M Y',strtotime($result[$i]['payment_date']));
				}


				$this->response(
					[
						'status' => 200,
						'error' =>false,
						'data'=> [ 
							'payed_payments' => $result,
							'upcoming_payment' => $result1[0] ? $result1 : [] 
						]
					]
				);
			}
			else
			{
				$error = true;
				$message = "Invalid User Token";
				$this->response(['status' => 201, 'error' => true, 'message' => $message]);
			}
		}
    }


	// -------------------------------------------
}

ob_flush();
?>