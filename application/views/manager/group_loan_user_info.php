<?php include "common/header.php" ?>

<?php include "common/sidebar.php" ?>

<style>
    table tr th,
    table tr td {
        padding: 15px !important;
        word-break: break-all;
    }
    .card-footer .showHideToggle::after {
        content: "Show";
    }

    .card-footer[aria-expanded="true"] .showHideToggle::after {
        content: "Hide";
    }
</style>

<div class="app-content content">
<div class="content-wrapper-before" style="position: relative;">
		<div class="content-header row">
			<div class="content-header-left col-md-4 col-12">
				<h5 class="content-header-title text-center mt-1 text-white"><?=$sub_page?></h5>
			</div>
		</div>
	</div>
    
    <div class="content-wrapper">
        <div id="content" class="content-body">

            <?php if (!empty($loan)) : ?>

                <div class="panel-group" id="accordion">

                        <div class="card">
                            <div class="card-header">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title text-capitalize">

                                            <div>
                                            <strong><?= $loan['first_name'] . ' ' . $loan['last_name'] . ' (' . $loan['mobile'] . ')' ?></strong>
                                            </div>
                                            
                                            <div class="my-1">
                                            <strong>Loan Type :</strong> <?php echo $loan[ 'loan_type' ]?>
                                            </div>

                                            <div class="my-1">
                                            <strong>Loan Amount :</strong> ₹<?php echo $loan[ 'amount' ]?>
                                            </div>

                                            <div class="my-1">
                                            <strong>EMI Amount : </strong>₹<?= $loan['emi_amount'] ?>
                                            </div>

                                            <div class="my-1">
                                            <strong>Rate Of Interest :</strong> <?= $loan['rate_of_interest'] ?>%
                                            </div>


                                            <?php if( $sub_page == 'My Running Loans' ):?>

                                                <div class="my-1">
                                               <strong> Remaining Balance :</strong> ₹<?= $loan['remaining_balance'] ?>
                                                </div>
                                            
                                            <?php endif;?>
                                            <div class="my-1">
                                                <strong>Status :</strong> <?php if ($loan['loan_status'] == 'PAID') : ?>
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

                            <div class="card-body p-0">
                                    <div class="panel-body">

                                        <table id="data-table-buttons" class="table table-centered col-12 m-0">
                                            <tbody>

                                                <tr>
                                                    <th>Loan ID</th>
                                                    <td><?= $loan['la_id'] ?></td>
                                                </tr>

                                                <tr>
                                                    <th>Email</th>
                                                    <td><?= $loan['email'] ?></td>
                                                </tr>

                                                <tr>
                                                    <th>city</th>
                                                    <td><?= $loan['city'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Processing Fee</th>
                                                    <td>₹<?= $loan['processing_fee']?></td>
                                                </tr>
                                                <tr>
                                                    <th>Deduct 1% LIC Amount</th>
                                                    <td><?= $loan['deduct_lic_amount']?></td>
                                                </tr>
                                                <tr>
                                                    <th>Loan Closer Amount</th>
                                                    <td>₹<?= $loan['loan_closer_amount'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Loan Duration</th>
                                                    <td><?= $loan['loan_duration'] ?> Days</td>
                                                </tr>
                                                <tr>
                                                    <th>Payment Mode</th>
                                                    <td><?= $loan['payment_mode'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Loan Created Date</th>
                                                    <td><?= ($loan['la_doc'] ? $loan['la_doc'] : 'NA') ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Loan Disbursal Date</th>
                                                    <td><?= ($loan['loan_start_date'] ? $loan['loan_start_date'] : 'NA') ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Loan End Date</th>
                                                    <td><?= ($loan['loan_end_date'] ? $loan['loan_end_date'] : 'NA') ?></td>
                                                </tr>
                                                <tr>

                                                    <th>Profile Status</th>
                                                    <td>
                                                        <?php
                                                        $user = $this->User_model->GetUserById($loan['userid']);

                                                        $profile_status = '<button class="btn btn-warning">Incomplete</button>';

                                                        if ($user->bda_status == 'APPROVED' && $user->adhar_card_front != '' && $user->adhar_card_back != '' && $user->pan_card_image != '' && $user->passbook_image != '') {
                                                            $profile_status = '<button class="btn btn-success">Completed</button>';
                                                        }
                                                        echo $profile_status;
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Profile Approved</th>
                                                    <td>
                                                        <?php
                                                        $profile_approved = '<button class="btn btn-warning">Pending</button>';

                                                        if ($user->bda_status == 'APPROVED' && $user->docv_status == 'APPROVED' && $user->pan_card_approved_status == 'APPROVED' && $user->passbook_approved_status == 'APPROVED') {
                                                            $profile_approved = '<button class="btn btn-success">Approved</button>';
                                                        } elseif ($user->bda_status == 'REJECTED' || $user->docv_status == 'REJECTED' || $user->pan_card_approved_status == 'REJECTED' || $user->passbook_approved_status == 'REJECTED') {
                                                            $profile_approved = '<button class="btn btn-danger">Rejected</button>';
                                                        }
                                                        echo $profile_approved;
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Comment</th>
                                                    <td><?= $loan['reject_comment'] ?></td>
                                                </tr>

                                                <?php if( $loan[ 'loan_status' ] == 'RUNNING' || $loan[ 'loan_status' ] == 'PAID' ):?>
                                                <tr>
                                                    <th>Loan Payments</th>
                                                    <td>
                                                        <a class="btn btn-primary" href="<?= base_url( 'manager/loans/loan_payments/'.$loan[ 'la_id' ] )?>">
                                                            Show Payments
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php endif;?>
                                            </tbody>
                                        </table>
                                    </div>
                            </div>
                        </div>
                </div>
            <?php else : ?>
                <div class="col"> No Loans Found</div>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>
<?php include "common/footer.php" ?>