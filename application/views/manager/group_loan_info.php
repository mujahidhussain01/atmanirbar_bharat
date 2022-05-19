<?php include "common/header.php" ?>

<?php include "common/sidebar.php" ?>

<style>
    table tr th,
    table tr td {
        padding: 15px !important;
        word-break: break-all;
    }

    .card-footer::after {
        content: "Show";
    }

    .card-footer[aria-expanded="true"]::after {
        content: "Hide";
    }
</style>

<div class="app-content content">

    <div class="content-wrapper-before" style="position: relative;">
        <div class="content-header row">
            <div class="content-header-left col-md-4 col-12">
                <h5 class="content-header-title text-center mt-1 text-white"><?= $group_loan['name'] ?> ( Group Loan )</h5>
            </div>
        </div>
    </div>

    <div class="content-wrapper">
        <div id="content" class="content-body">

            <div class="row justify-content-end mb-1">

                <div class="col-6 d-flex justify-content-end">
                    <a style="width: 95%;" href="<?php echo base_url() ?>manager/group_loans/loan_add_user/<?= $group_loan['id'] ?>">
                        <button class="w-100 py-1 btn bg-gradient-x-purple-blue text-white">
                            Add User
                        </button>
                    </a>
                </div>

            </div>

            <hr>

            <div class="row mb-2">
                <form method="get" class="col-12 row pr-0" action="<?php echo base_url('manager/group_loans/loan_info/'.$group_loan[ 'id' ]) ?>">
                    <div class="col-12 d-flex">
                        <input type="text" required name="search" class="form-control" id="search" placeholder="Search By User Name" value="<?=( !empty( $_GET[ 'search' ] ) ) ? $_GET[ 'search' ] : '' ?>">
                        <button type="submit" class="btn btn-primary ml-1"><i class="fa fa-search"></i></button>
                    </div>
                </form>
            </div>

            <?php if( $this->session->error ):?>
                <div class="col-12 d-flex justify-content-center">
                    <div class="w-100 alert alert-danger" role="alert">
                    <?= $this->session->error?>
                    </div>
                </div>
            <?php endif;?>

            <?php if (!empty($group_loan)) : ?>

            <div class="panel-group" id="accordion">

                <div class="card">
                    <div class="card-header">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title text-capitalize">
                                Group : <?= $group_loan['name'] ?> ( ₹<?= $group_loan['total_amount'] ?> )
                                </h4>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div>
                            <div class="panel-body">


                                <table id="data-table-buttons" class="table table-centered col-12 m-0">
                                    <tbody>

                                        <tr>
                                            <th>Rate Of Interest</th>
                                            <td><?= $group_loan['rate_of_interest'] ?>%</td>
                                        </tr>

                                        <tr>
                                            <th>Processing Fees Percent</th>
                                            <td><?= $group_loan['process_fee_percent'] ?>%</td>
                                        </tr>

                                        <tr>
                                            <th>Bouncing Charges Percent</th>
                                            <td><?= $group_loan['bouncing_charges_percent'] ?>%</td>
                                        </tr>

                                        <tr>
                                            <th>Total Loan Amount</th>
                                            <td>₹<?= $group_loan[ 'total_amount' ] ?></td>
                                        </tr>

                                        <tr>
                                            <th>Total Amount Disbursed</th>
                                            <td>₹<?= $group_loan[ 'amount_payed' ] ?></td>
                                        </tr>

                                        <tr>
                                            <th>Total Remaining Balance</th>
                                            <td>₹<?= $group_loan[ 'remaining_balance' ] ?></td>
                                        </tr>

                                        <tr>
                                            <th>Active Users</th>
                                            <td><?= $this->Group_loans_model->get_group_loan_active_user_count( $group_loan[ 'id' ] ) ?></td>
                                        </tr>

                                        <tr>
                                            <th>Pending Users</th>
                                            <td><?= $this->Group_loans_model->get_group_loan_pending_user_count( $group_loan[ 'id' ] ) ?></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?php else : ?>
            <div class="col"> No Loan Found Found</div>
            <?php endif; ?>

            <h4 class="my-2 text-center">All Loan Users List</h4>


            <?php if (!empty($all_loans)) :?>

                <div class="panel-group" id="accordion">

                    <?php foreach ( $all_loans as $key => $loan ) :?>
                        <div class="card">
                            <div class="card-header">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title text-capitalize">

                                            <div>
                                            <?= $loan['first_name'] . ' ' . $loan['last_name'] . ' (' . $loan['mobile'] . ')' ?>
                                            </div>
                                            
                                            <div class="mt-1">
                                            Loan Type : <?php echo $loan[ 'loan_type' ]?>
                                            </div>

                                            <div class="mt-1">
                                            Loan Amount : ₹<?php echo $loan[ 'amount' ]?>
                                            </div>

                                            <div class="mt-1">
                                            EMI Amount : ₹<?= $loan['emi_amount'] ?>
                                            </div>

                                            <?php if( $loan[ 'loan_status' ] == 'RUNNING' ):?>

                                                <div class="mt-1">
                                                Remaining Balance : ₹<?= $loan['remaining_balance'] ?>
                                                </div>
                                            
                                            <?php endif;?>
                                            <div class="my-1">
                                                Status : <?php if ($loan['loan_status'] == 'PAID') : ?>
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
                                <div id="collapse<?php echo $key ?>" class="panel-collapse collapse">
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
                                                    <td>₹<?= ( $loan['processing_fee'] ?  $loan['processing_fee'] : 'NA') ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Final Loan Amount</th>
                                                    <td>₹<?= $loan['loan_closer_amount'] ?></td>
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

                                                        $profile_status = '<button class="btn btn-warning btn-sm">Incomplete</button>';

                                                        if ( $loan[ 'bda_status' ] == 'APPROVED' && $loan[ 'adhar_card_front' ] != '' && $loan[ 'adhar_card_back' ] != '' && $loan[ 'pan_card_image' ] != '' && $loan[ 'passbook_image' ] != '') {
                                                            $profile_status = '<button class="btn btn-success btn-sm">Completed</button>';
                                                        }
                                                        echo $profile_status;
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Profile Approved</th>
                                                    <td>
                                                        <?php
                                                        $profile_approved = '<button class="btn btn-warning btn-sm">Pending</button>';

                                                        if ($loan[ 'bda_status' ] == 'APPROVED' && $loan[ 'docv_status' ] == 'APPROVED' && $loan[ 'pan_card_approved_status' ] == 'APPROVED' && $loan[ 'passbook_approved_status' ] == 'APPROVED') {
                                                            $profile_approved = '<button class="btn btn-success btn-sm">Approved</button>';
                                                        } elseif ($loan[ 'bda_status' ] == 'REJECTED' || $loan[ 'docv_status' ] == 'REJECTED' || $loan[ 'pan_card_approved_status' ] == 'REJECTED' || $loan[ 'passbook_approved_status' ] == 'REJECTED') {
                                                            $profile_approved = '<button class="btn btn-danger btn-sm">Rejected</button>';
                                                        }
                                                        echo $profile_approved;
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Comment</th>
                                                    <td><?= $loan['reject_comment'] ?></td>
                                                </tr>

                                                <?php if ( !empty( $loan['manager_id']  ) ) : ?>
                                                <tr>
                                                    <th>Requested By Manager</th>
                                                    <td>
                                                    <?php 
                                                        echo $loan['manager_name'] ? $loan['manager_name'] : 'NONE' ?>

                                                    </td>
                                                </tr>
                                                <?php endif; ?>

                                                <?php if( $loan[ 'loan_status' ] == 'RUNNING' || $loan[ 'loan_status' ] == 'PAID' ):?>
                                                <tr>
                                                    <th>Loan Payments</th>
                                                    <td>
                                                        <a class="btn btn-primary btn-sm" href="<?= base_url( 'manager/loans/loan_payments/'.$loan[ 'la_id' ] )?>">
                                                                Show Payments
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php endif;?>
                                                <tr>
                                                    <th>Full Detail</th>
                                                    <td>
                                                        <a href="<?= base_url( 'manager/loans/details/'.$loan[ 'la_id' ] )?>" class="btn btn-primary btn-sm">
                                                            View Details
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-muted d-flex justify-content-between" data-toggle="collapse" data-target="#collapse<?php echo $key ?>">
                                <?php if( $loan[ 'loan_status' ] == 'RUNNING' || $loan[ 'loan_status' ] == 'PAID'  ):?>
                                <p>Loan Start Date : <?= date( 'd M Y', strtotime( $loan[ 'loan_start_date' ] ) )?></p>
                                <?php else:?>
                                    <p>Loan Apply Date : <?= date( 'd M Y', strtotime( $loan[ 'la_doc' ] ) )?></p>
                                <?php endif;?>

                                <p class="showHideToggle"></p>
                            
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
            <?php else :?>
                <div class="col"> No User Found For The Group</div>
            <?php endif;?>
    </div>
</div>
</div>
<?php include "common/footer.php" ?>