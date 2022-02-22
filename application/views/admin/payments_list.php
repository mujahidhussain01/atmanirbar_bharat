<?php include "common/header.php" ?>

<?php include "common/sidebar.php" ?>

<style>
    .media.media-sm .media-object {

        width: 64px;

        height: 64px;

        border: 1px solid grey;

    }

    .justify-content-center {

        justify-content: center;

    }

    table.table-bordered.dataTable th,
    table.table-bordered.dataTable td {

        border-left-width: 0;

        white-space: nowrap;

    }
</style>

<link href="<?= base_url() ?>/assets/plugins/lightbox2/dist/css/lightbox.css" rel="stylesheet" />



<div id="content" class="content">

    <ol class="breadcrumb float-xl-right">

        <li class="breadcrumb-item"><a href="<?= site_url('admin/') ?>">Home</a></li>

        <li class="breadcrumb-item"><a href="javascript:;">Payments</a></li>

        <li class="breadcrumb-item active"><a href="javascript:;"><?= $page_title ?></a></li>

    </ol>

    <h1 class="page-header"><?= $page_title ?> </h1>

    <div class="row">

        <div class="col-12">

            <div class="panel">

                <div class="panel-body">

                    <div class='row '>
                        <div class="col-12 table-responsive">
                            <table id="payments_data_table" class="table table-centered table-bordered table-condensed table-nowrap">
                                <thead>
                                    <tr>
                                        <th>S.no</th>
                                        <th>Loan Details</th>
                                        <th>User Details</th>
                                        <th>Emi Amount</th>
                                        <th>Payment Date</th>
                                        <th>Payment Received Date</th>
                                        <th>Amount Received</th>
                                        <th>Bouncing Charges</th>
                                        <th>Payment Status</th>
                                        <th>Amount Received</th>
                                        <th>Received By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($payments)) : ?>
                                        <?php $has_inactive = false; ?>
                                        <?php foreach ($payments as $key => $payment) : ?>

                                            <tr>
                                                <td><?php echo ++$key ?></td>
                                                <td>
                                                    <ul class="list-unstyled">
                                                        <li class="my-2"><strong>Loan ID : </strong> <?= $payment[ 'la_id' ] ?></li>
                                                        <li class="my-2"><strong>Loan Type : </strong> <?= $payment[ 'loan_type' ] ?></li>
                                                        <li class="my-2"><strong>Amount : </strong> <?= ( $payment[ 'loan_amount' ] ? '₹' . $payment[ 'loan_amount' ] : 'NA' ) ?></li>
                                                        <li class="mt-2"><strong>Rate Of Interest : </strong> <?= $payment['rate_of_interest']?>%</li>
                                                        <li class="my-2"><strong>Loan Duration : </strong> <?= $payment[ 'loan_duration' ] ?> Days</li>
                                                        <li class="my-2"><strong>Payment Mode : </strong> <?= $payment[ 'payment_mode' ] ?></li>
                                                        <li class="my-2"><strong>Payable Amount : </strong> ₹<?= $payment[ 'payable_amt' ] ?></li>
                                                        <li class="my-2"><strong>Remaining Balance : </strong> ₹<?= $payment[ 'remaining_balance' ] ?></li>
                                                        
                                                    </ul>
                                                </td>
                                                <td>
                                                    <ul class="list-unstyled">
                                                        <li class="my-2"><strong>User Name : </strong> <?= $payment[ 'first_name' ].' '.$payment[ 'last_name' ] ?></li>
                                                        <li class="my-2"><strong>Email : </strong> <?= $payment[ 'email' ]?></li>
                                                        <li class="my-2"><strong>Mobile : </strong> <?= $payment[ 'mobile' ] ?> Days</li>
                                                        <li class="my-2"><strong>City : </strong> <?= $payment[ 'city' ] ?></li>
                                                    </ul>

                                                </td>
                                                <td>₹<?php echo $payment[ 'amount' ] ?></td>
                                                <td><?php echo date('d-M-Y', strtotime($payment[ 'payment_date' ])) ?></td>

                                                    <td>
                                                        <?php echo $payment[ 'amount_received_at' ] ? date('d-M-Y, H:i A', strtotime($payment[ 'amount_received_at' ])) : '' ?>
                                                    </td>
                                                    <td>
                                                        <?php echo '₹' . $payment[ 'amount_received' ] ?>
                                                    </td>

                                                <td><?php echo $payment[ 'bounce_charges' ] ? $payment[ 'bounce_charges' ] : "NA" ?></td>
                                                <td>
                                                    <?php if ($payment[ 'status' ] == 'ACTIVE') : ?>

                                                        <button class="btn btn-success">Payed</button>

                                                    <?php elseif ($payment[ 'status' ] == 'INACTIVE') : ?>

                                                        <?php if (!$has_inactive || $sub_page == 'upcoming_payments' ) : ?>

                                                            <?php $has_inactive = true; ?>

                                                            <button onclick="markPaymentReceived( '<?php echo $payment[ 'id' ] ?>','<?php echo $payment[ 'amount' ]?>' )" class="btn btn-info m-3">Mark Received</button>

                                                        <?php else : ?>

                                                            <button class="btn btn-secondary m-3">Pending</button>

                                                        <?php endif; ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php echo $payment[ 'amount_received' ] ?>
                                                </td>
                                                <td>
                                                    <?php if ( $payment[ 'amount_received_by' ] == 'MANAGER')
                                                    {
                                                        echo $payment[ 'manager_name' ].' ( Manager ) ' ;
                                                    }
                                                    else if ( $payment[ 'amount_received_by' ] == 'ADMIN')
                                                    {
                                                        echo 'ADMIN';
                                                    }

                                                    ?>
                                                </td>
                                            </tr>


                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="8">No Payments</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "common/footer.php" ?>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script src="<?= base_url() ?>/assets/plugins/lightbox2/dist/js/lightbox.min.js" type="text/javascript"></script>

<div class="modal fade" id="userdetailmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">

        </div>

    </div>

</div>

<script>
    $(document).ready(function() {
        $('#payments_data_table').DataTable();
    });

    <?php if (@$sub_page != 'payed_payments') : ?>

        function markPaymentReceived(pay_id, amount) {
            var received_amount = prompt('Enter Amount Received', amount);

            received_amount = parseInt(received_amount);

            if (!received_amount) {
                alert('Invalid Amount Received Value');
                return;
            }

            if (!confirm('Confirm Mark Payment Received ?')) {
                return;
            }

            $.ajax({

                url: '<?= site_url('admin/manage_payments/mark_payment_received') ?>',

                type: 'POST',

                data: {
                    'pay_id': pay_id,
                    'received_amount': received_amount
                },

                success: function(data) {
                    var res = JSON.parse(data);

                    if (res.success) {
                        alert(res.message);

                        window.location.reload();
                    } else {
                        alert(res.message);
                    }
                },
                error: function(jqxhr) {
                    alert(jqxhr.status + ' Server Error');
                }

            });
        }

    <?php endif; ?>
</script>