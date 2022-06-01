<?php include "common/header.php" ?>

<?php include "common/sidebar.php" ?>


<div class="app-content content">
    <div class="content-wrapper-before" style="position: relative;">
        <div class="content-header row">
            <div class="content-header-left col-md-4 col-12">
                <h5 class="content-header-title text-center mt-1 text-white"><?= $sub_page ?></h5>
            </div>
        </div>
    </div>

    <?php if (!empty($loan_details)) : ?>

        <div class="content-wrapper">
            <div id="content" class="content-body">
                    <div class="card">
                        <div class="card-body">
                            <div class='row '>

                                <div class="col-12">

                                    <div class="col-12 row m-0 p-0">
                                        <div class="col-6 p-2 border-bottom"> <strong> Loan ID </strong> </div>
                                        <div class="col-6 p-2 border-bottom"><?= $loan_details['la_id'] ?></div>
                                    </div>

                                    <div class="col-12 row m-0 p-0">
                                        <div class="col-6 p-2 border-bottom"> <strong> Loan Type </strong> </div>
                                        <div class="col-6 p-2 border-bottom"><?= $loan_details['loan_type'] ?></div>
                                    </div>

                                   

                                </div>
                                
                                <?php if( !empty( $loan_name ) ):?>

                                    <div class="col-12">
                                        <div class="col-12 row m-0 p-0">
                                            <div class="col-6 p-2 border-bottom"> <strong> <?= $loan_details[ 'loan_type' ]?> Loan Name</strong> </div>
                                            <div class="col-6 p-2 border-bottom"><?= $loan_name?></div>
                                        </div>
                                    </div>

                                <?php endif;?>

                                <div class="col-12">

                                    <div class="col-12 row m-0 p-0">
                                        <div class="col-6 p-2 border-bottom"> <strong> Amount </strong> </div>
                                        <div class="col-6 p-2 border-bottom"><?= ($loan_details['amount'] ? '₹' . $loan_details['amount'] : 'NA') ?></div>
                                    </div>

                                    <div class="col-12 row m-0 p-0">
                                        <div class="col-6 p-2 border-bottom"> <strong> Rate Of Interest </strong> </div>
                                        <div class="col-6 p-2 border-bottom"><?= $loan_details['rate_of_interest'] ?>%</div>
                                    </div>

                                </div>

                                <div class="col-12">

                                    <div class="col-12 row m-0 p-0">
                                        <div class="col-6 p-2 border-bottom"> <strong> Interest In Rupees( Monthly ) </strong> </div>
                                        <div class="col-6 p-2 border-bottom"><?= ($loan_details['monthly_interest'] ? '₹' . $loan_details['monthly_interest'] : 'NA') ?></div>
                                    </div>

                                    <div class="col-12 row m-0 p-0">
                                        <div class="col-6 p-2 border-bottom"> <strong> Deduct 1% LIC Amount </strong> </div>
                                        <div class="col-6 p-2 border-bottom"><?= ($loan_details['deduct_lic_amount']) ?></div>
                                    </div>

                                </div>




                                <div class="col-12">

                                    <div class="col-12 row m-0 p-0">
                                        <div class="col-6 p-2 border-bottom"> <strong> LIC Amount </strong> </div>
                                        <div class="col-6 p-2 border-bottom">₹<?= ($loan_details['lic_amount']) ?></div>
                                    </div>

                                    <div class="col-12 row m-0 p-0">
                                        <div class="col-6 p-2 border-bottom"> <strong> Processing Fee </strong> </div>
                                        <div class="col-6 p-2 border-bottom">₹<?= ($loan_details['processing_fee']) ?></div>
                                    </div>

                                </div>

                                <div class="col-12">

                                    <div class="col-12 row m-0 p-0">
                                        <div class="col-6 p-2 border-bottom"> <strong> Final Loan Amount </strong> </div>
                                        <div class="col-6 p-2 border-bottom">₹<?= $loan_details['loan_closer_amount'] ?></div>
                                    </div>

                                    <div class="col-12 row m-0 p-0">
                                        <div class="col-6 p-2 border-bottom"> <strong> Loan Duration </strong> </div>
                                        <div class="col-6 p-2 border-bottom"><?= $loan_details['loan_duration'] ?> Days</div>
                                    </div>

                                </div>

                                <div class="col-12">

                                    <div class="col-12 row m-0 p-0">
                                        <div class="col-6 p-2 border-bottom"> <strong> Payment Mode </strong> </div>
                                        <div class="col-6 p-2 border-bottom"><?= $loan_details['payment_mode'] ?></div>
                                    </div>

                                    <div class="col-12 row m-0 p-0">
                                        <div class="col-6 p-2 border-bottom"> <strong> Emi Amount </strong> </div>
                                        <div class="col-6 p-2 border-bottom">₹<?= $loan_details['emi_amount'] ?></div>
                                    </div>

                                </div>

                                <div class="col-12">

                                    <div class="col-12 row m-0 p-0">
                                        <div class="col-6 p-2 border-bottom"> <strong> Payable Amount </strong> </div>
                                        <div class="col-6 p-2 border-bottom">₹<?= $loan_details['payable_amt'] ?></div>
                                    </div>

                                    <div class="col-12 row m-0 p-0">
                                        <div class="col-6 p-2 border-bottom"> <strong> Requested By Manager </strong> </div>
                                        <div class="col-6 p-2 border-bottom"><?= $loan_details['manager_name'] ? $loan_details['manager_name'] . ' ( Manager ) ' : 'NONE' ?></div>
                                    </div>

                                </div>

                                <div class="col-12">

                                    <div class="col-12 row m-0 p-0">
                                        <div class="col-6 p-2 border-bottom"> <strong> Remaining Balance </strong> </div>
                                        <div class="col-6 p-2 border-bottom">₹<?= $loan_details['remaining_balance'] ?></div>
                                    </div>

                                    <div class="col-12 row m-0 p-0">
                                        <div class="col-6 p-2 border-bottom"> <strong> Loan Status </strong> </div>
                                        <div class="col-6 p-2 border-bottom"><?= $loan_details['loan_status'] ?></div>
                                    </div>

                                </div>

                                <div class="col-12">

                                    <div class="col-12 row m-0 p-0">
                                        <div class="col-6 p-2 border-bottom"> <strong>Loan Start Date </strong> </div>
                                        <div class="col-6 p-2 border-bottom">
                                            <?= $loan_details[ 'loan_start_date' ] ? date( 'Y-m-d', strtotime( $loan_details[ 'loan_start_date' ] )) : '' ?>
                                        </div>
                                    </div>

                                    <div class="col-12 row m-0 p-0">
                                        <div class="col-6 p-2 border-bottom"> <strong>Loan End Date</strong> </div>
                                        <div class="col-6 p-2 border-bottom">
                                            <?= $loan_details[ 'loan_end_date' ] ? date( 'Y-m-d', strtotime( $loan_details[ 'loan_end_date' ] )) : '' ?>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-12">
                                    <div class="col-12 p-2 border-bottom"> <strong> Comment </strong> </div>
                                    <div class="col-12 p-2 border-bottom"><?= $loan_details['reject_comment'] ?></div>
                                </div>

                                <div class="col-12">

                                    <div class="col-12 row m-0 p-0">
                                        <div class="col-6 p-2 border-bottom"> <strong> User Name </strong> </div>
                                        <div class="col-6 p-2 border-bottom"><?= $loan_details['first_name'] . ' ' . $loan_details['last_name'] ?></div>
                                    </div>

                                    <div class="col-12 row m-0 p-0">
                                        <div class="col-6 p-2 border-bottom"> <strong> User Email </strong> </div>
                                        <div class="col-6 p-2 border-bottom"><?= $loan_details['email'] ?></div>
                                    </div>

                                </div>

                                <div class="col-12">

                                    <div class="col-12 row m-0 p-0">
                                        <div class="col-6 p-2 border-bottom"> <strong> User Mobile </strong> </div>
                                        <div class="col-6 p-2 border-bottom"><?= $loan_details['mobile'] ?></div>
                                    </div>

                                    <div class="col-12 row m-0 p-0">
                                        <div class="col-6 p-2 border-bottom"> <strong> User City </strong> </div>
                                        <div class="col-6 p-2 border-bottom"><?= $loan_details['city'] ?></div>
                                    </div>

                                </div>
                                

                                <div class="col-12">

                                    <?php if (!in_array($loan_details['loan_status'], ['PENDING', 'APPROVED', 'REJECTED'])) : ?>
                                        <div class="col-12 row m-0 p-0">
                                            <div class="col-6 p-2 border-bottom"> <strong> Payment Details </strong> </div>
                                            <div class="col-6 p-2 border-bottom">
                                                <a href="<?= base_url( 'manager/loans/loan_payments/'.$loan_details[ 'la_id' ] )?>">
                                                    <button type="button" class="btn btn-primary btn-sm">
                                                    Show Payments
                                                    </button>        
                                                </a>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($loan_details['extension_of']) : ?>
                                        <div class="col-12 row m-0 p-0">
                                            <div class="col-6 p-2 border-bottom"> <strong> Parent Loan </strong> </div>
                                            <div class="col-6 p-2 border-bottom">
                                                <a href="<?= base_url('manager/loans/details/' . $loan_details['extension_of']) ?>">
                                                    <button type="button" class="btn btn-primary btn-sm">
                                                        View Parent Loan
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                </div>

                                <div class="col-12">
                                    <div class="col-12 row m-0 p-0">
                                        <div class="col-6 p-2 border-bottom"> <strong> Has Extension Request </strong> </div>
                                        <div class="col-6 p-2 border-bottom">
                                            <?= !empty($loan_extension) ? 'Yes' : 'No' ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">

                                    <?php if (!empty($loan_extension)) : ?>

                                        <div class="col-12 row m-0 p-0">
                                            <div class="col-6 p-2 border-bottom"> <strong>Extension Approval Status </strong> </div>
                                            <div class="col-6 p-2 border-bottom">
                                                <?= $loan_extension['extension_status'] ?>
                                            </div>
                                        </div>

                                    <?php endif; ?>

                                    <?php if( !empty( $loan_details['child_la_id'] ) ) : ?>

                                    <div class="col-12 row m-0 p-0">
                                        <div class="col-6 p-2 border-bottom"> <strong>Extended Or Child Loan Details </strong> </div>
                                        <div class="col-6 p-2 border-bottom">
                                                <a href="<?= base_url('manager/loans/details/' . $loan_details['child_la_id']) ?>">
                                                    <button type="button" class="btn btn-primary btn-sm">
                                                        View Details
                                                    </button>
                                                </a>
                                        </div>
                                    </div>
                                    
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    <?php else : ?>
        <div class="col"> No Loan Found</div>
    <?php endif; ?>
</div>
</div>
<?php include "common/footer.php" ?>