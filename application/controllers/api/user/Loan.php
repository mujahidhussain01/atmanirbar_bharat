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
            if(!$this->input->get('token') OR !$this->input->get('loan_id'))
			{
                $this->response(['status' => 201, 'error' =>true, 'message' => 'Required parameter is not set']);
            }
            else
			{
        		$userdata = $this->User_model->GetUserByToken($this->input->get( 'token' ));

        		if (!empty($userdata))
				{
        		    if( $loan = $this->Loan_apply_model->getloandetail($this->input->get( 'loan_id' )) )
					{

        		    $result['basic_detail'] = $loan;
        		    $result['basic_detail']['loan_end_date'] = date('D d,M Y',strtotime($loan['loan_end_date']));
        		    
                    $this->response(['status' => 200, 'error' =>false, 'data'=>$result ]);
				}
				else
				{
                    $this->response(['status' => 201, 'error' =>true, 'message'=> "Invalid Loan ID" ]);
				}
        		}
        		else {
        			$message = "Invalid User Token";
        			$this->response(['status' => 201, 'error' => true, 'message' => $message]);
        		}
           }
    }
	
	public function apply_loan_post()
	{
		$this->form_validation->set_rules( 'token', 'Token', 'trim|required');
		$this->form_validation->set_rules( 'loan_id', 'Loan ID', 'trim|required|numeric');
		$this->form_validation->set_rules( 'deduct_lic_amount', 'Deduct LIC Amount', 'trim|required');
		
		if( $this->form_validation->run() !== true )
		{
			if( form_error( 'token' ) )
			{
				$message = form_error( 'token' );
			}
			else if( form_error( 'loan_id' ) )
			{
				$message = form_error( 'loan_id' );
			}
			else if( form_error( 'deduct_lic_amount' ) )
			{
				$message = form_error( 'deduct_lic_amount' );
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


		$userdata = $this->User_model->GetUserByToken( $_POST['token'] );

		if ( empty($userdata))
		{
			$message = "Invalid User Token";
			$this->response(['status' => 201, 'error' => true, 'message' => $message]);
		}



		if( $prev_loan = $this->Loan_apply_model->getuserlastloandetail($userdata->userid) )
		{
			if( $prev_loan['loan_status'] == 'PENDING' )
			{
				$message = "Cannot Apply For New Loan, A Loan Request Is Pending In Your Profile, Please Wait For Admin To Respond.";

				$this->response(['status' => 201, 'error' => true, 'message' => $message]);
				return;
			}
			else if( $prev_loan['loan_status'] == 'APPROVED' )
			{
				$message = "Cannot Apply For New Loan, A Loan Is Waiting For Amount Disbursement, Please Wait For Admin To Respond.";
				
				$this->response(['status' => 201, 'error' => true, 'message' => $message]);
				return;
			}
			else if( $prev_loan['loan_status'] == 'RUNNING' )
			{
				$message = "Cannot Apply For New Loan, A Loan Is Already Running With Your Account, Please Complete The Previous Loan First.";

				$this->response(['status' => 201, 'error' => true, 'message' => $message]);
				return;
			}
		}
		else if( $this->input->post( 'deduct_lic_amount', true ) !== 'yes' )
		{
			$message = "LIC Amount Deduction Is Compulsory For First Loan";
			$this->response(['status' => 201, 'error' => true, 'message' => $message]);
			return;
		}
		

		if( $loan = $this->Loan_setting_model->getloan_setting( $this->input->post( 'loan_id', true ) ) )
		{
			// calculate loan data ----

			$loan_amount = $loan[ 'amount' ];
			$loan_duration = $loan[ 'loan_duration' ];
			$payment_mode = $loan[ 'payment_mode' ];
			$deduct_lic_amount = $this->input->post( 'deduct_lic_amount', true );

			$rate_of_interest = $loan[ 'rate_of_interest' ];
			$process_fee_percent = $loan[ 'process_fee_percent' ];
			$bouncing_charges_percent = $loan[ 'bouncing_charges_percent' ];
			$processing_fee = $loan[ 'processing_fee' ];
			$bouncing_charges = $loan[ 'bouncing_charges' ];

			$interest_amount_initial = ceil( ( $loan_amount / 100 ) * $rate_of_interest );

			if( $loan_duration > 30 )
			{
				$multiply_by = ceil( $loan_duration / 30 );
				$interest_amount = ceil( $interest_amount_initial * $multiply_by );
			}
			else
			{
				$interest_amount = $interest_amount_initial;
			}

			$one_percent = 0;

			if( $deduct_lic_amount == 'yes' )
			{
				$one_percent = ceil( $loan_amount / 100 );
				$loan_closer_amount = $loan_amount + $interest_amount + $one_percent;
			}
			else
			{
				$loan_closer_amount = $loan_amount + $interest_amount;
			}

			

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

			$emi_amount = ceil( $loan_closer_amount / $total_emi_count );
			


			// calculate loan data End ----


			$data['user_id'] = $userdata->userid;
			$data['loan_id'] = $loan[ 'lsid' ];
			$data['loan_type'] = 'NORMAL';
			$data['amount'] = $loan_amount;
			$data['rate_of_interest'] = $rate_of_interest;
			$data['monthly_interest'] = $interest_amount_initial;
			$data['process_fee_percent'] = $process_fee_percent;
			$data['processing_fee'] = $processing_fee;
			$data['loan_duration'] = $loan_duration;
			$data['payment_mode'] = $payment_mode;
			$data['bouncing_charges_percent'] = $bouncing_charges_percent;
			$data['bouncing_charges'] = $bouncing_charges;
			$data['reject_comment'] = 'Your loan application is under process please wait for the approval';
			$data['emi_amount'] = $emi_amount;
			$data['payable_amt'] = $loan_amount - $processing_fee;
			$data['remaining_balance'] = $loan_closer_amount;
			$data['loan_closer_amount'] = $loan_closer_amount;
			$data['deduct_lic_amount'] = $deduct_lic_amount;
			$data['lic_amount'] = $one_percent;


			$sql = $this->Loan_apply_model->insert( $data );

			if( $sql )
			{
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
			$message = "Invalid Loan ID";
			$this->response(['status' => 201, 'error' => true, 'message' => $message]);
		}
	}


	public function manual_loan_setting_post()
	{
		$this->form_validation->set_rules( 'token', 'Token', 'trim|required');
		$this->form_validation->set_rules( 'amount', 'Amount', 'trim|required|numeric');
		$this->form_validation->set_rules( 'loan_duration', 'Loan Duration', 'trim|required|numeric');
		$this->form_validation->set_rules( 'payment_mode', 'Payment Mode', 'trim|required');
		$this->form_validation->set_rules( 'deduct_lic_amount', 'Deduct LIC Amount', 'trim|required');
		
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
			else if( form_error( 'deduct_lic_amount' ) )
			{
				$message = form_error( 'deduct_lic_amount' );
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

		$userdata = $this->User_model->GetUserByToken( $this->input->post( 'token' ) );

		if ( empty($userdata))
		{
			$message = "Invalid User Token";
			$this->response(['status' => 201, 'error' => true, 'message' => $message]);
			return;
		}



		// calculate loan data ----

		$loan_amount = intval( $this->input->post( 'amount', true ) );
		$loan_duration = intval( $this->input->post( 'loan_duration', true ) ) ?? 1;
		$payment_mode = $this->input->post( 'payment_mode', true );
		$deduct_lic_amount = $this->input->post( 'deduct_lic_amount', true );

		$this->load->model( 'manual_loan_setting_model' );

		$manual_loan_setting = $this->manual_loan_setting_model->get_manual_loan_setting();

		$rate_of_interest = $manual_loan_setting[ 'rate_of_interest' ];
		$process_fee_percent = $manual_loan_setting[ 'process_fee_percent' ];
		$bouncing_charges_percent = $manual_loan_setting[ 'bouncing_charges_percent' ];

		$interest_amount_initial = ceil( ( $loan_amount / 100 ) * $rate_of_interest );

		if( $loan_duration > 30 )
		{
			$multiply_by = ceil( $loan_duration / 30 );
			$interest_amount = ceil( $interest_amount_initial * $multiply_by );
		}
		else
		{
			$interest_amount = $interest_amount_initial;
		}

		$processing_fee = ceil( ( $loan_amount / 100 ) * $process_fee_percent );
		$bouncing_charges = ceil( ( $loan_amount / 100 ) * $bouncing_charges_percent );

		$one_percent = 0;
		
		if( $deduct_lic_amount == 'yes' )
		{
			$one_percent = ceil( $loan_amount / 100 );
			$loan_closer_amount = $loan_amount + $interest_amount + $one_percent;
		}
		else
		{
			$loan_closer_amount = $loan_amount + $interest_amount;
		}

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

		$emi_amount = ceil( $loan_closer_amount / $total_emi_count );
	


		// calculate loan data End ----


		$data['amount'] = $loan_amount;
		$data['rate_of_interest'] = $rate_of_interest;
		$data['process_fee_percent'] = $process_fee_percent;
		$data['processing_fee'] = $processing_fee;
		$data['loan_duration'] = $loan_duration;
		$data['payment_mode'] = $payment_mode;
		$data['bouncing_charges_percent'] = $bouncing_charges_percent;
		$data['bouncing_charges'] = $bouncing_charges;
		$data['emi_amount'] = $emi_amount;
		$data['total_emi_count'] = $total_emi_count;
		$data['disbursal_amount'] = $loan_amount - $processing_fee;
		$data['loan_closer_amount'] = $loan_closer_amount;


		$this->response(['status' => 200, 'error' =>false, 'data'=> $data ]); 
	}





	public function apply_manual_loan_post()
	{
		$this->form_validation->set_rules( 'token', 'Token', 'trim|required');
		$this->form_validation->set_rules( 'amount', 'Amount', 'trim|required|numeric');
		$this->form_validation->set_rules( 'loan_duration', 'Loan Duration', 'trim|required|numeric');
		$this->form_validation->set_rules( 'payment_mode', 'Payment Mode', 'trim|required');
		$this->form_validation->set_rules( 'deduct_lic_amount', 'Deduct LIC Amount', 'trim|required');
		
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
			else if( form_error( 'deduct_lic_amount' ) )
			{
				$message = form_error( 'deduct_lic_amount' );
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

		$userdata = $this->User_model->GetUserByToken( $this->input->post( 'token' ) );

		if ( empty($userdata))
		{
			$message = "Invalid User Token";
			$this->response(['status' => 201, 'error' => true, 'message' => $message]);
			return;
		}


		if( $prev_loan = $this->Loan_apply_model->getuserlastloandetail($userdata->userid) )
		{
			if( $prev_loan['loan_status'] == 'PENDING' )
			{
				$message = "Cannot Apply For New Loan, A Loan Request Is Pending In Your Profile, Please Wait For Admin To Respond.";

				$this->response(['status' => 201, 'error' => true, 'message' => $message]);
				return;
			}
			else if( $prev_loan['loan_status'] == 'APPROVED' )
			{
				$message = "Cannot Apply For New Loan, A Loan Is Waiting For Amount Disbursement, Please Wait For Admin To Respond.";
				
				$this->response(['status' => 201, 'error' => true, 'message' => $message]);
				return;
			}
			else if( $prev_loan['loan_status'] == 'RUNNING' )
			{
				$message = "Cannot Apply For New Loan, A Loan Is Already Running With Your Account, Please Complete The Previous Loan First.";

				$this->response(['status' => 201, 'error' => true, 'message' => $message]);
				return;
			}
		}
		else if( $this->input->post( 'deduct_lic_amount', true ) !== 'yes' )
		{
			$message = "LIC Amount Deduction Is Compulsory For First Loan";
			$this->response(['status' => 201, 'error' => true, 'message' => $message]);
			return;
		}

		// calculate loan data ----

		$loan_amount = intval( $this->input->post( 'amount', true ) );
		$loan_duration = intval( $this->input->post( 'loan_duration', true ) ) ?? 1;
		$payment_mode = $this->input->post( 'payment_mode', true );
		$deduct_lic_amount = $this->input->post( 'deduct_lic_amount', true );

		$this->load->model( 'manual_loan_setting_model' );

		$manual_loan_setting = $this->manual_loan_setting_model->get_manual_loan_setting();

		$rate_of_interest = $manual_loan_setting[ 'rate_of_interest' ];
		$process_fee_percent = $manual_loan_setting[ 'process_fee_percent' ];
		$bouncing_charges_percent = $manual_loan_setting[ 'bouncing_charges_percent' ];

		$interest_amount_initial = ceil( ( $loan_amount / 100 ) * $rate_of_interest );

		if( $loan_duration > 30 )
		{
			$multiply_by = ceil( $loan_duration / 30 );
			$interest_amount = ceil( $interest_amount_initial * $multiply_by );
		}
		else
		{
			$interest_amount = $interest_amount_initial;
		}
		
		$processing_fee = ceil( ( $loan_amount / 100 ) * $process_fee_percent );
		$bouncing_charges = ceil( ( $loan_amount / 100 ) * $bouncing_charges_percent );

		$one_percent = 0;
		
		if( $deduct_lic_amount == 'yes' )
		{
			$one_percent = ceil( $loan_amount / 100 );
			$loan_closer_amount = $loan_amount + $interest_amount + $one_percent;
		}
		else
		{
			$loan_closer_amount = $loan_amount + $interest_amount;
		}

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

		$emi_amount = ceil( $loan_closer_amount / $total_emi_count );
	


		// calculate loan data End ----


		$data['user_id'] = $userdata->userid;
		$data['loan_type'] = 'MANUAL';
		$data['amount'] = $loan_amount;
		$data['rate_of_interest'] = $rate_of_interest;
		$data['monthly_interest'] = $interest_amount_initial;
		$data['process_fee_percent'] = $process_fee_percent;
		$data['processing_fee'] = $processing_fee;
		$data['loan_duration'] = $loan_duration;
		$data['payment_mode'] = $payment_mode;
		$data['bouncing_charges_percent'] = $bouncing_charges_percent;
		$data['bouncing_charges'] = $bouncing_charges;
		$data['reject_comment'] = 'Your loan application is under process please wait for the approval';
		$data['emi_amount'] = $emi_amount;
		$data['payable_amt'] = $loan_amount - $processing_fee;
		$data['remaining_balance'] = $loan_closer_amount;
		$data['loan_closer_amount'] = $loan_closer_amount;
		$data['deduct_lic_amount'] = $deduct_lic_amount;
		$data['lic_amount'] = $one_percent;


		$sql = $this->Loan_apply_model->insert( $data );

		if( $sql )
		{
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

	public function apply_loan_extension_post()
	{
		$this->form_validation->set_rules( 'token', 'Token', 'trim|required');
		$this->form_validation->set_rules( 'current_loan_id', 'Loan ID', 'trim|required|numeric');
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
			else if( form_error( 'current_loan_id' ) )
			{
				$message = form_error( 'current_loan_id' );
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

		$userdata = $this->User_model->GetUserByToken( $this->input->post( 'token' ) );

		if ( empty( $userdata ) )
		{
			$message = "Invalid User Token";
			$this->response(['status' => 201, 'error' => true, 'message' => $message]);
			return;
		}

		$requested_loan_id = intval( $this->input->post( 'current_loan_id', true ) );

		if( !$requested_loan = $this->Loan_apply_model->get_user_loan_by_loan_id( $userdata->userid, $requested_loan_id ) )
		{
			$this->response([ 'status' => 201, 'error' => true, 'message' => 'Invalid Loan ID' ]);
			return;
		}

		if( $requested_loan['loan_status'] != 'RUNNING' )
		{
			$this->response(['status' => 201, 'error' => true, 'message' => 'Loan Is Not In Running Status, Cannot Apply Extension']);
			return;
		}

		$this->load->model( 'loan_extension_model' );

		if( $this->loan_extension_model->get_pending_extension_by_loan_id( $requested_loan_id ) )
		{
			$this->response(['status' => 201, 'error' => true, 'message' => 'Previous Extension Request Is Pending For Approval, Cannot Request For New Extension']);
			return;
		}

		// calculate loan data End ----

		$data['la_id'] = $requested_loan_id;
		$data['user_id'] = $userdata->userid;
		$data['ext_amount'] = $this->input->post( 'amount', true );
		$data['ext_duration'] = $this->input->post( 'loan_duration', true );
		$data['ext_payment_mode'] = $this->input->post( 'payment_mode', true );
		$data['reject_comment'] = 'Loan Extension Request Applied' ;
		$data['le_doc'] = date( 'Y-m-d H:i:s' );

		$sql = $this->loan_extension_model->insert( $data );

		if( $sql )
		{
			$userDefaultMsgdata['default_title'] = 'Loan Extension Request Applied successfully';
			$userDefaultMsgdata['default_message'] = 'your Loan Extension Request of Rs.'.$this->input->post( 'amount', true ).' is under process, we will keep you informed. Thanks';
			$this->User_model->updateUserDataByUserId($userdata->userid,$userDefaultMsgdata);
			$message = 'Loan Extension Request Applied successfully'; 
		}
		else
		{
			$message = 'Unable to apply for the Loan Extension, Please Try Again Later';  
		}

		$this->response(['status' => 200, 'error' =>false, 'message'=>$message ]);  
	}


	public function user_loan_list_get()
	{
		if(!$this->input->get('token')){
				$this->response(['status' => 201, 'error' =>true, 'message' => 'Required parameter is not set']);
		}
		else
		{
			$userdata = $this->User_model->GetUserByToken($this->input->get( 'token' ));
			if (!empty($userdata))
			{
				if( $loan = $this->Loan_apply_model->getuserallloanlist($userdata->userid) )
				{
					$this->response(['status' => 200, 'error' =>false, 'data'=>$loan ]);
				}
				else
				{
					$this->response(['status' => 201, 'error' =>true, 'message'=> "No Loans Found" ]);
				}
			}
			else
			{
				$message = "Invalid User Token";
				$this->response(['status' => 201, 'error' => true, 'message' => $message]);
			}
		}
	}


	public function loan_payments_get()
	{
		if( !$this->input->get('token') || !$this->input->get( 'loan_id' ) )
		{
			$this->response( [ 'status' => 201, 'error' =>true, 'message' => 'Required parameter is not set' ] );
		}
		else
		{
			$userdata = $this->User_model->GetUserByToken( $this->input->get( 'token' ) );

			if ( !empty($userdata) )
			{
				$this->load->model( 'Loan_payments_model' );

				$result = $this->Loan_payments_model->get_all_payments_order_by( $this->input->get( 'loan_id' ) );

				for( $i=0 ; $i< count( $result ); $i++ )
				{
					$result[$i]['lp_doc'] = date('D d,M Y',strtotime($result[$i]['payment_date']));
				}


				$this->response(
					[
						'status' => 200,
						'error' =>false,
						'data'=> $result
					]
				);
			}
			else
			{
				$message = "Invalid User Token";
				$this->response(['status' => 201, 'error' => true, 'message' => $message]);
			}
		}
    }



	public function all_payments_get()
	{
		if( !$this->input->get('token') )
		{
			$this->response( [ 'status' => 201, 'error' =>true, 'message' => 'Required parameter is not set' ] );
		}
		else
		{
			$userdata = $this->User_model->GetUserByToken( $this->input->get( 'token' ) );

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
				$message = "Invalid User Token";
				$this->response(['status' => 201, 'error' => true, 'message' => $message]);
			}
		}
    }


	// -------------------------------------------
}

ob_flush();
?>