<?php   
		// temp section -----------------

		//  Loan temp Counts
		$pendingloans = $this->Loan_apply_model->get_loan_by_status_count('PENDING');
		$approvedloans = $this->Loan_apply_model->get_loan_by_status_count('APPROVED');
		$runningloans = $this->Loan_apply_model->get_loan_by_status_count('RUNNING');
		$rejectedloans = $this->Loan_apply_model->get_loan_by_status_count('REJECTED');
		$paidloans = $this->Loan_apply_model->get_loan_by_status_count('PAID');

		// payments ----

		$todays_payment_count = $this->Loan_payments_model->get_payments_by_date_count( date( 'Y-m-d' ) );
		$payed_payment_count = $this->Loan_payments_model->get_all_payed_payments_count();
		$upcoming_payment_count = $this->Loan_payments_model->get_all_upcoming_payments_count();

		// temp section -----------------



        //  User counts
		$allusers = $this->User_model->GetAllUsersCount();
		$pendingusers = $this->User_model->GetAllPendingUsersCount();
		$documentpendingusers = $this->User_model->GetdocumentPendingUserscount();
		$userinsigths = array('bda_status'=>'NOT_AVAILABLE','pa_status'=>'PENDING','aadhar_upload_status'=>'INCOMPLETE','sa_status'=>'PENDING');
		$only_app_installed = $this->User_model->GetFilteredUserCount($userinsigths);
		$userinsigths = array('bda_status'=>'PENDING','pa_status'=>'PENDING','aadhar_upload_status'=>'INCOMPLETE','sa_status'=>'PENDING');
		$complete_basic_details = $this->User_model->GetFilteredUserCount($userinsigths);
		$userinsigths = array('bda_status'=>'APPROVED','pa_status'=>'APPROVED','aadhar_upload_status'=>'INCOMPLETE','sa_status'=>'NOT_AVAILABLE');
		$completed_pay_slips = $this->User_model->GetFilteredUserCount($userinsigths);
		$userinsigths = array('aadhar_upload_status'=>'COMPLETE','docv_status'=>'PENDING','sa_status'=>'NOT_AVAILABLE');
		$complete_documents = $this->User_model->GetFilteredUserCount($userinsigths);
		$userinsigths = array('bda_status'=>'PENDING','pa_status'=>'PENDING','aadhar_upload_status'=>'COMPLETE','sa_status'=>'PENDING');
		$completed_selfie = $this->User_model->GetFilteredUserCount($userinsigths);
		$approvedusers = $this->User_model->GetAllVerifiedUserscount();
		$rejectedusers = $this->User_model->GetAllRejectedUsersCount();
        //  Extension Counts
		
       
        //  notification counts
		$newnotificaton = $this->Notification_model->getAllUnreadNotifications();
?>