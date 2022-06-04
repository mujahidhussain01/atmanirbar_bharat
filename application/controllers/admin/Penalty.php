<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Penalty extends CI_Controller
{

    public $data = [
        'page' => 'Generate Penalty',
        
    ];

    public function __construct()
    {
        parent::__construct();

		if(!isset($this->session->userdata['user']))
        {
            redirect('admin/login');
        }

		$this->load->model('Loan_apply_model');
		$this->load->model('User_model');
		$this->load->model('Loan_payments_model');
        $this->load->model( 'Loan_extension_model' );
        $this->load->model( 'Group_loans_model' );
    }


    public function index()
    {
        $this->load->view('admin/penalty', $this->data);
    }


    public function generate_penalty( $token = false )
    {
        if(
            ( $token && $token !== 'hlwvkez96705vs11geny3sjl5webq0t80vx' ) ||
            $_SERVER[ 'REQUEST_METHOD' ] !== 'POST'
        )
        show_404();

        $penaltyGenerated = 0;
        $penaltyLoanCreated = 0;

        // generate payment penalty

        $allPenaltyPayments = $this->Loan_payments_model->get_all_loans_penalty_payments();

        foreach ( $allPenaltyPayments as $key => $penaltyPayment )
        {
            if( $loanApply = $this->Loan_apply_model->getSingleLoanById( $penaltyPayment[ 'loan_apply_id' ] ) )
            {

                // update payment -----
                $onePercent =  ceil( intval( $penaltyPayment[ 'amount' ] ) / 100 );
                $loanApplyBounceCharges = intval( $loanApply[ 'bouncing_charges' ] );

                $updatePayment[ 'bounce_charges' ] = $onePercent + $loanApplyBounceCharges;
                $updatePayment[ 'amount' ] = intval( $penaltyPayment[ 'amount' ] ) + $updatePayment[ 'bounce_charges' ];
    
                // update Loan Apply -----
                $updateLoanApply[ 'remaining_balance' ] = intval( $loanApply[ 'remaining_balance' ] ) + $updatePayment[ 'bounce_charges' ];
                $updateLoanApply[ 'emi_bounced_amount' ] = intval( $loanApply[ 'emi_bounced_amount' ] ) + $updatePayment[ 'bounce_charges' ];

                if( $this->Loan_payments_model->update_single_payment( $updatePayment, $penaltyPayment[ 'id' ] ) )
                {
                    $this->Loan_apply_model->update( $penaltyPayment[ 'loan_apply_id' ] ,$updateLoanApply );

                    $penaltyGenerated++;
                }
            }
        }

        // generate new loan if Loan Last Date ends today

        $allPenaltyLoans = $this->Loan_apply_model->get_all_penalty_loans();

        foreach ( $allPenaltyLoans as $key => $penaltyLoan )
        {
            $new_loan = [];

            $loan_amount = $penaltyLoan[ 'remaining_balance' ];
			$loan_duration = $penaltyLoan[ 'loan_duration' ];
			$payment_mode = $penaltyLoan[ 'payment_mode' ];
			$deduct_lic_amount = $penaltyLoan[ 'deduct_lic_amount' ];

			$rate_of_interest = $penaltyLoan[ 'rate_of_interest' ];
			$process_fee_percent = $penaltyLoan[ 'process_fee_percent' ];
			$bouncing_charges_percent = $penaltyLoan[ 'bouncing_charges_percent' ];
			$processing_fee = $penaltyLoan[ 'processing_fee' ];
			$bouncing_charges = $penaltyLoan[ 'bouncing_charges' ];

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
			
            // calculate loan last date
            $emi_count = floor( intval( $penaltyLoan[ 'loan_duration' ] ) / $divided_by );
            $emi_count = ( $emi_count >= 1 ) ? $emi_count : 1 ;

            $loan_last_date = date( 'Y-m-d' );

            for( $i = 0; $i < $emi_count; $i++ )
            {
                if( $divided_by !== 30  )
                {
                    $loan_last_date = date( 'Y-m-d', strtotime( $loan_last_date." + ".$divided_by." days" ) );
                }
                else
                {
                    $loan_last_date = date( 'Y-m-d', strtotime( $loan_last_date." + 1 month" ) );

                }
            }

			// calculate loan data End ----

			$new_loan['user_id'] = $penaltyLoan['user_id'] ;
			$new_loan['loan_id'] = $penaltyLoan[ 'loan_id' ];
			$new_loan['loan_type'] = $penaltyLoan['loan_type'];
			$new_loan['amount'] = $loan_amount;
			$new_loan['initial_amount'] = $loan_amount;
			$new_loan['rate_of_interest'] = $rate_of_interest;
			$new_loan['monthly_interest'] = $interest_amount_initial;
			$new_loan['process_fee_percent'] = $process_fee_percent;
			$new_loan['processing_fee'] = $processing_fee;
			$new_loan['loan_duration'] = $loan_duration;
			$new_loan['payment_mode'] = $payment_mode;
			$new_loan['bouncing_charges_percent'] = $bouncing_charges_percent;
			$new_loan['bouncing_charges'] = $bouncing_charges;
			$new_loan['reject_comment'] = 'New Penalty Loan Has Been Created Because Previous Loan Last Date Ended';
			$new_loan['emi_amount'] = $emi_amount;
			$new_loan['payable_amt'] = 0;
			$new_loan['remaining_balance'] = $loan_closer_amount;
			$new_loan['loan_closer_amount'] = $loan_closer_amount;
			$new_loan['deduct_lic_amount'] = $deduct_lic_amount;
			$new_loan['lic_amount'] = $one_percent;
            $new_loan['loan_status'] = 'RUNNING';
			$new_loan['extension_of'] = $penaltyLoan[ 'la_id' ];
            $new_loan['loan_start_date'] = date( 'Y-m-d' );
            $new_loan['loan_last_date'] = $loan_last_date;

			if( $new_loan_id = $this->Loan_apply_model->insert( $new_loan ) )
			{
                $current_loan_update['child_la_id'] = $new_loan_id;

                if( $penaltyLoan[ 'loan_type' ] == 'GROUP' )
                {
                    $current_loan_update['amount'] = abs( intval( $penaltyLoan[ 'remaining_balance' ] ) - intval( $penaltyLoan[ 'loan_closer_amount' ] ) );
    
                    $current_loan_update['remaining_balance'] = 0;
                }

                $current_loan_update['has_extensions'] = 'YES';
                $current_loan_update['loan_status'] = 'PAID';
                $current_loan_update['loan_end_date'] = date( 'Y-m-d' );
                $current_loan_update['reject_comment'] = 'Child Loan Is Created As Penalty Loan Because Loan Duration Ended';

                if( $this->Loan_apply_model->update( $penaltyLoan[ 'la_id' ], $current_loan_update ) )
                {
                    $this->Loan_payments_model->mark_all_active_where_loan_id( $penaltyLoan[ 'la_id' ] );

                    $insert_loan_payments = [];

                    $next_date = date( 'Y-m-d' );

                    for( $i = 0; $i < $emi_count; $i++ )
                    {
                        if( $divided_by !== 30  )
                        {
                            $next_date = date( 'Y-m-d', strtotime( $next_date." + ".$divided_by." days" ) );
                        }
                        else
                        {
                            $next_date = date( 'Y-m-d', strtotime( $next_date." + 1 month" ) );
                        }

                        $insert_loan_payments[] = [
                            'loan_apply_id' => $new_loan_id,
                            'user_id' => $new_loan[ 'user_id' ],
                            'amount' => $new_loan[ 'emi_amount' ],
                            'initial_amount' => $new_loan[ 'emi_amount' ],
                            'payment_date' => $next_date
                        ];
                    }

                    $this->Loan_payments_model->insert_batch( $insert_loan_payments );

                    $penaltyLoanCreated++ ;
                }
			}
        }
        
        echo "Total $penaltyGenerated Payment Penalty Generated And $penaltyLoanCreated New Penalty Loans Created";

    }
}

/* End of file Groups.php */
