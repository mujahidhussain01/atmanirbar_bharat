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
                <h5 class="content-header-title text-center mt-1 text-white"><?= $group_loan['loan_name'] ?> ( ₹<?= $group_loan['amount'] ?> )</h5>
            </div>
        </div>
    </div>

    <div class="content-wrapper">
        <div id="content" class="content-body">

            <div class="row justify-content-end mb-1">

                <div class="col-6 d-flex justify-content-end">
                    <a style="width: 95%;" href="<?php echo base_url() ?>manager/group_loans/loan_add_user/<?= $group_loan['lsid'] ?>">
                        <button class="w-100 py-1 btn bg-gradient-x-purple-blue text-white">
                            Add User
                        </button>
                    </a>
                </div>

            </div>

            <hr>

            <div class="row mb-2">
                <form method="get" class="col-12 row pr-0" action="<?php echo base_url('manager/group_loans/loan_info/'.$group_loan[ 'lsid' ]) ?>">
                    <div class="col-12 d-flex">
                        <input type="text" required name="search" class="form-control" id="search" placeholder="Search By User Name" value="<?=( !empty( $_GET[ 'search' ] ) ) ? $_GET[ 'search' ] : '' ?>">
                        <button type="submit" class="btn btn-primary ml-1"><i class="fa fa-search"></i></button>
                    </div>
                </form>
            </div>

            <?php if (!empty($group_loan)) : ?>

            <div class="panel-group" id="accordion">

                <div class="card">
                    <div class="card-header">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title text-capitalize">
                                Group : <?= $group_loan['loan_name'] ?> ( ₹<?= $group_loan['amount'] ?> )
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
                                            <th>Emi Amount</th>
                                            <td>₹<?= $group_loan['emi_amount'] ?></td>
                                        </tr>

                                        <tr>
                                            <th>Rate Of Interest</th>
                                            <td><?= $group_loan['rate_of_interest'] ?>%</td>
                                        </tr>

                                        <tr>
                                            <th>Processing Fees</th>
                                            <td>₹<?= $group_loan['processing_fee'] ?></td>
                                        </tr>

                                        <tr>
                                            <th>Loan Duration</th>
                                            <td><?= $group_loan['loan_duration'] ?> Days</td>
                                        </tr>
                                        <tr>
                                            <th>Payment Mode</th>
                                            <td><?= $group_loan['payment_mode'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>Users Count</th>
                                            <td><?= $this->Loan_apply_model->get_group_loan_user_count( $group_loan[ 'lsid' ] ) ?></td>
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

            <h4 class="my-2 text-center">Active Users List</h4>


            <?php if (!empty($loan_users)) :?>

                <div class="panel-group" id="accordion">


                    <?php foreach ( $loan_users as $key => $loan_user ) :?>
                        <div class="card">
                            <a href="<?=base_url()?>manager/group_loans/loan_user_info/<?=$loan_user[ 'la_id' ] ?>">
                                <div class="card-header">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title text-capitalize">
                                                <?= $loan_user['first_name'] . ' ' . $loan_user['last_name'] . ' (' . $loan_user['mobile'] . ')'?>
                                                <div class="my-1">
                                                Status : <?php if ($loan_user['loan_status'] == 'PAID') : ?>
                                                    <span class="badge badge-success">Closed</span>
                                                <?php elseif ($loan_user['loan_status'] == 'RUNNING') : ?>
                                                    <span class="badge badge-primary">Running</span>
                                                <?php elseif ($loan_user['loan_status'] == 'PENDING') : ?>
                                                    <span class="badge badge-warning">Pending</span>
                                                <?php elseif ($loan_user['loan_status'] == 'APPROVED') : ?>
                                                    <span class="badge badge-info">Approved</span>
                                                <?php elseif ($loan_user['loan_status'] == 'REJECTED') : ?>
                                                    <span class="badge badge-danger">Rejected</span>
                                                <?php endif; ?>
                                            </div>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </a>
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