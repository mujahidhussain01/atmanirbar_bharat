<?php include "common/header.php" ?>

<?php include "common/sidebar.php" ?>


<div class="app-content content">
<div class="content-wrapper-before" style="position: relative;">
		<div class="content-header row">
			<div class="content-header-left col-md-4 col-12">
				<h5 class="content-header-title text-center mt-1 text-white"><?=$sub_page?></h5>
			</div>
		</div>
	</div>

    <?php if (!empty($loan)) : ?>

    <div class="content-wrapper">
        <div id="content" class="content-body">
            <div class="panel-group">
                <div class="card">
                    <div class="card-header">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title text-capitalize">
                                   <strong> Loan ID : </strong> <?= $loan[ 'la_id' ]?>
                                   <div class="my-1">
                                       <strong>
                                    Name : </strong> <?= $loan['first_name'] . ' ' . $loan['last_name'] . ' (' . $loan['mobile'] . ')' ?>
                                   </div>

                                   <div class="my-1">
                                       <strong>
                                   Loan Type : </strong> <?php echo $loan[ 'loan_type' ]?>
                                   </div>

                                   <div class="my-1">
                                       <strong>
                                   Loan Amount : </strong> ₹<?php echo $loan[ 'amount' ]?>
                                   </div>

                                   <div class="my-1">
                                       <strong>
                                    EMI Amount : </strong> ₹<?= $loan['emi_amount'] ?>
                                    </div>

                                   <div class="my-1">
                                       <strong>
                                   Rate Of Interest : </strong> <?= $loan['rate_of_interest'] ?>%
                                    </div>

                                   <div class="my-1">
                                       <strong>
                                   Payable Amount : </strong> ₹<?= $loan['payable_amt'] ?>
                                    </div>

                                    <div class="my-1">
                                        <strong>
                                    Remaining Balance : </strong> ₹<?= $loan['remaining_balance'] ? $loan['remaining_balance'] : 0 ?>
                                    </div>
                                    
                                    <div class="my-1">
                                        <strong>
                                    Loan Status : </strong>
                                        <?php if ($loan['loan_status'] == 'PAID') : ?>
                                            <span class="badge badge-success">Closed</span>
                                        <?php elseif ($loan['loan_status'] == 'RUNNING') : ?>
                                            <span class="badge badge-primary">Running</span>
                                        <?php elseif ($loan['loan_status'] == 'PENDING') : ?>
                                            <span class="badge badge-warning">Pending</span>
                                        <?php elseif ($loan['loan_status'] == 'APPROVED') : ?>
                                            <span class="badge badge-info">Approved</span>
                                        <?php elseif ($loan['loan_status'] == 'REJECTED') : ?>
                                            <span class="badge badge-danger">Rejected</span>
                                        <?php endif; ?>
                                    </div>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <?php if ( $loan['loan_status'] == 'RUNNING') : ?>
        <div class="content-wrapper">
            <div id="content" class="content-body">
                <div class="panel-group">
                    <div class="d-flex justify-content-end">
                        <a href="<?= base_url( 'manager/loans/foreclose_loan_request/'.$loan[ 'la_id' ] )?>" class="btn btn-primary">ForeClose Loan</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if( !empty( $loan_payments ) ):?>
            
            <?php $mark_payment = true;?>
            <?php foreach( $loan_payments as $key => $loan_payment ):?>


            <div class="content-wrapper">
                <div id="content" class="content-body">
                    <div class="panel-group">
                        <div class="card mb-0">
                            <div class="card-header">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h6 class="panel-title text-capitalize d-flex justify-content-between">
                                        <div><strong>Date :</strong> <?= $loan_payment['payment_date'] ? date( 'd M Y', strtotime( $loan_payment['payment_date'] ) ) : '' ?></div>
                                        <div>
                                        <strong>Amount :</strong> ₹<?= $loan_payment['amount'] ?>
                                        </div>
                                        
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="panel-body">
                                    <?php if( $loan_payment[ 'status' ] == 'ACTIVE' ):?>
                                        <div class="row">
                                            <div class="col-6">
                                                <strong>Initial Amount : </strong>
                                                ₹<?= $loan_payment[ 'initial_amount' ]?>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-6">
                                                <small><strong>Status : </strong>Done</small>
                                            </div>
                                            <div class="col-6  d-flex justify-content-end">
                                                <small><strong>Received : </strong>₹<?= $loan_payment[ 'amount_received' ]?></small>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-6">
                                                <small><strong>Received By : </strong>
                                                <?php if ( $loan_payment[ 'amount_received_by' ] == 'MANAGER')
                                                    {
                                                        echo $loan_payment[ 'manager_name' ].' ( Manager ) ' ;
                                                    }
                                                    else if ( $loan_payment[ 'amount_received_by' ] == 'ADMIN')
                                                    {
                                                        echo 'ADMIN';
                                                    }
                                                    else
                                                    {
                                                        echo 'NONE';
                                                    }

                                                    ?>
                                                </small>
                                            </div>
                                            <div class="col-6 d-flex justify-content-end">
                                                <small><strong>Received At : </strong><?= $loan_payment['amount_received_at'] ? date( 'd M Y', strtotime( $loan_payment['amount_received_at'] ) ) : ''?></small>
                                            </div>
                                        </div>
                                    <?php else:?>
                                        <div class="row">
                                            <div class="col-6">
                                                <strong>Status : </strong>Pending
                                            </div>

                                            <div class="col-6 d-flex justify-content-end">
                                                <strong>Initial Amount : </strong> ₹<?= $loan_payment['initial_amount'] ?>
                                            </div>

                                            <?php if( $mark_payment ):?>

                                                <?php $mark_payment = false;?>

                                                <div class="col-12 mt-3 d-flex justify-content-end">
                                                    <a href="<?= base_url( 'manager/loans/mark_payment_form/'.$loan_payment[ 'id' ] )?>">
                                                        <button class="btn btn-primary" >Mark Received</button>
                                                    </a>
                                                </div>
                                            <?php endif;?>

                                        </div>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php endforeach;?>
        
        <?php else:?>
            No Loan Payments Found
        <?php endif;?>

    <?php else:?>
        <div class="col"> No Loans Found</div>
    <?php endif;?>
</div>
</div>
<?php include "common/footer.php" ?>