<?php include "common/header.php" ?>

<?php include "common/sidebar.php" ?>

<style>
    table tr th,
    table tr td {
        padding: 15px !important;
        word-break: break-all;
    }
</style>

<div class="app-content content">
<div class="content-wrapper-before" style="position: relative;">
		<div class="content-header row">
			<div class="content-header-left col-md-4 col-12">
				<h5 class="content-header-title text-center mt-1 text-white">Claim Loan</h5>
			</div>
		</div>
	</div>
    
    <div class="content-wrapper">
        <div id="content" class="content-body">




            <div class="row">
                <form method="get" class="col-12 row pr-0" action="<?php echo base_url('manager/loans') ?>">
                    <div class="col-12 d-flex">
                        <input type="text" required name="search" class="form-control" id="search" placeholder="Enter User Name">
                        <button type="submit" class="btn btn-primary ml-1"><i class="fa fa-search"></i></button>
                    </div>
                </form>
            </div>

            <hr>
           

            <?php if (!empty($loans)) : ?>

                <div class="panel-group" id="accordion">


                    <?php foreach ($loans as $key => $loan) : ?>

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

                                            <?php if( $sub_page == 'My Running Loans' ):?>

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
                                                    <th>Loan Closer Amount</th>
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

                                                        $profile_status = '<button class="btn btn-warning">Incomplete</button>';

                                                        if ( $loan[ 'bda_status' ] == 'APPROVED' && $loan[ 'adhar_card_front' ] != '' && $loan[ 'adhar_card_back' ] != '' && $loan[ 'pan_card_image' ] != '' && $loan[ 'passbook_image' ] != '') {
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

                                                        if ($loan[ 'bda_status' ] == 'APPROVED' && $loan[ 'docv_status' ] == 'APPROVED' && $loan[ 'pan_card_approved_status' ] == 'APPROVED' && $loan[ 'passbook_approved_status' ] == 'APPROVED') {
                                                            $profile_approved = '<button class="btn btn-success">Approved</button>';
                                                        } elseif ($loan[ 'bda_status' ] == 'REJECTED' || $loan[ 'docv_status' ] == 'REJECTED' || $loan[ 'pan_card_approved_status' ] == 'REJECTED' || $loan[ 'passbook_approved_status' ] == 'REJECTED') {
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

                                                <tr>
                                                    <th>Claim Loan</th>

                                                    <td>

                                                    <?php if ( $loan['manager_id'] == null && ( $loan['loan_status'] == 'APPROVED' || $loan['loan_status'] == 'PENDING' )) : ?> 

                                                        <button type="button" class="btn btn-primary" id="claimBtn" data-id="<?php echo $loan['la_id'] ?>" >Claim This Loan</button>

                                                    <?php else:?>

                                                        <button type="button" class="btn btn-primary" disabled>Claimed</button>

                                                    <?php endif;?>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Loan Claimed By</th>
                                                    <td>
                                                    <?php if ($loan['manager_id'] != null ) : ?>

                                                    <?php 
                                                        echo $loan['manager_name'] ? $loan['manager_name'] : 'NONE' ?>

                                                    <?php else: ?>
                                                        NONE
                                                    <?php endif; ?>
                                                    </td>
                                                </tr>

                                                <?php if( $loan[ 'loan_status' ] == 'RUNNING' || $loan[ 'loan_status' ] == 'PAID' ):?>
                                                <tr>
                                                    <th>Loan Payments</th>
                                                    <td>
                                                        <a class="btn btn-primary" href="<?= base_url( 'manager/loans/loan_payments/'.$loan[ 'la_id' ] )?>">
                                                                Show <br> Payments
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php endif;?>
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

                    <?php endforeach; ?>
                </div>
                <?php else : ?>
                <div class="col"> No Loans Found</div>
                <?php endif; ?>


        </div>
    </div>
</div>

<?php include "common/footer.php" ?>

<link rel="stylesheet" href="<?= base_url( 'assets/css/jquery-confirm.css' ) ?>">
<script src="<?= base_url( 'assets/js/jquery-confirm.min.js' )?>"></script>
<script>
    $(document).ready(function()
    {
        var confirmed = false;
        var claimBtn = $('#claimBtn');

        $(claimBtn).on('click', function() 
        {
            if( confirmed )
            {
                return;
            }
                var data = {
                loan_id: $(this).data('id')
            };

            $.confirm(
            {
                title: 'Claim Loan',
                content: 'Confirm Claim This Loan ?',
                buttons:
                {
                    confirm: function ()
                    {
                        $.confirm(
                        {
                            content: function ()
                            {
                                var self = this;

                                return $.ajax(
                                {
                                    url: '<?php echo base_url() ?>manager/loans/claim_loan',
                                    type: 'POST',
                                    data: data,
                                    headers:
                                    {
                                        accepts: 'application/json; charset=utf-8'
                                    }
                                })
                                .done( function ( response )
                                {
                                    response = JSON.parse( response );

                                    self.setTitle( response.success ? 'Success' : 'Error' );
                                    self.setType( response.success ? 'green' : 'red' );
                                    if( response.success )
                                    {
                                        confirmed = true;
                                        $( claimBtn ).text( 'Claimed' );
                                        $( claimBtn ).prop( 'disabled', true );
                                        self.setContent( 'Loan Claimed Successfully' );
                                    }
                                    else
                                    {
                                        self.setContent('Unknown Error, Please Try Again Later');
                                    }
                                })
                                .fail( function()
                                {
                                    self.setContent('Unknown Error, Please Try Again Later');
                                });
                            }
                        });
                    },
                    cancel: function () {
                    },
                }
            });
        });
    });
    </script>