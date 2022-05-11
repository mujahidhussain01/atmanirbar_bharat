<?php   
		//  Loan Counts
		$pendingloans = $this->Loan_apply_model->get_loan_by_status_count('PENDING');
		$approvedloans = $this->Loan_apply_model->get_loan_by_status_count('APPROVED');
		$runningloans = $this->Loan_apply_model->get_loan_by_status_count('RUNNING');
		$rejectedloans = $this->Loan_apply_model->get_loan_by_status_count('REJECTED');
		$paidloans = $this->Loan_apply_model->get_loan_by_status_count('PAID');

		// payments ----
		$todays_payment_count = $this->Loan_payments_model->get_payments_by_date_count( date( 'Y-m-d' ) );
		$payed_payment_count = $this->Loan_payments_model->get_all_payed_payments_count();
		$upcoming_payment_count = $this->Loan_payments_model->get_all_upcoming_payments_count();

        //  User counts
		$allusers = $this->User_model->GetAllUsersCount();
		$pendingusers = $this->User_model->GetAllPendingUsersCount();
		$documentpendingusers = $this->User_model->GetdocumentPendingUserscount();
		$approvedusers = $this->User_model->GetAllVerifiedUserscount();
		$rejectedusers = $this->User_model->GetAllRejectedUsersCount();



		$new_extensions = $this->Loan_extension_model->get_extentions_by_status_count( 'PENDING' );

		$approved_extensions = $this->Loan_extension_model->get_extentions_by_status_count( 'APPROVED' );

		$rejected_extensions = $this->Loan_extension_model->get_extentions_by_status_count( 'REJECTED' );

?>