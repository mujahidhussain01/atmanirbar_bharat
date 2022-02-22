<?php
// sidebar Count ------------------------------------------------------------------------------------

$loans_under_approval = $this->Loan_apply_model->get_loans_count_by_manager_id( $this->session->manager_id, [ 'PENDING', 'APPROVED' ] );
$my_running_loans = $this->Loan_apply_model->get_loans_count_by_manager_id( $this->session->manager_id, ['RUNNING'] );
$closed_loans = $this->Loan_apply_model->get_loans_count_by_manager_id( $this->session->manager_id, ['PAID', 'REJECTED'] );


// sidebar Count ------------------------------------------------------------------------------------

?>