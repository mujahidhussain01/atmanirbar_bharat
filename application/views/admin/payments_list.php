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

                    <?php if( $sub_page == 'payed_payments' ):?>

                        <form class="col-12 row">
                            <div class='col-12 col-lg-5 mb-3'>

                                <div id="advance-daterange" class="btn btn-white btn-block text-left p-0">

                                    <input type="text" name="date_range" id="date_range_sel" class="form-control"></span>

                                </div>

                            </div>

                            <div class='col-12 col-lg-5 mb-3'>
                                <button class="btn btn-primary" type="submit" >Filter Date</button>
                            </div>
                        </form>

                    <?php endif;?>


                        <div class="col-12 table-responsive">
                            <table id="payments_data_table" class="table table-centered table-bordered table-condensed table-nowrap">
                                <thead>
                                    <tr>
                                        <th>S.no</th>
                                        <th>Loan Details</th>
                                        <th>User Details</th>
                                        <th>Initial Amount</th>
                                        <th>Bouncing Charges</th>
                                        <th>Emi Amount</th>
                                        <th>Payment Date</th>
                                        <th>Payment Received Date</th>
                                        <th>Amount Received</th>
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
											<li class="mt-2"><strong>Loan ID : </strong> <?= $payment['la_id']?></li>
											<li class="mt-2"><strong>Loan Type : </strong> <?= $payment['loan_type']?></li>
											<li class="mt-2"><strong>Amount : </strong> <?=( $payment['amount']?'₹'. $payment['amount']:'NA')?></li>

											
											<li class="mt-2">
											<strong>Processing Fees : </strong> <?=( $payment['processing_fee']?'₹'. $payment['processing_fee']:'NA')?>
											</li>
											<li class="mt-2">
											<strong>Payable Amount : </strong> <?=( $payment['payable_amt']?'₹'. $payment['payable_amt']:'NA')?>
											</li>

											<li class="mt-2">
											<strong>Deduct 1% LIC Amount : </strong> <?=$payment['deduct_lic_amount']?>
											</li>

											<li class="mt-2">
											<strong>Final Loan Amount : </strong> <?=( $payment['loan_closer_amount']?'₹'. $payment['loan_closer_amount']:'NA')?>
											</li>
											<li class="mt-2">
											<strong>Remaining Balance : </strong> <?=( $payment['remaining_balance']?'₹'. $payment['remaining_balance']:'NA')?>
											</li>

											<li>
												<a href="<?= base_url( 'admin/loan/details/'.$payment[ 'la_id' ] )?>">
													<button type="button" class="btn btn-primary btn-sm my-2">
														View Loan Details
													</button>
												</a>
											</li>

										</ul>
                                                </td>
                                                <td>
                                                    <ul class="list-unstyled">
                                                        <li class="my-2"><strong>User Name : </strong> <?= $payment[ 'first_name' ].' '.$payment[ 'last_name' ] ?></li>
                                                        <li class="my-2"><strong>Email : </strong> <?= $payment[ 'email' ]?></li>
                                                        <li class="my-2"><strong>Mobile : </strong> <?= $payment[ 'mobile' ] ?></li>
                                                        <li class="my-2"><strong>City : </strong> <?= $payment[ 'city' ] ?></li>
                                                    </ul>

                                                </td>
                                                <td>₹<?php echo $payment[ 'initial_amount' ] ?></td>
                                                <td><?php echo $payment[ 'bounce_charges' ] ? $payment[ 'bounce_charges' ] : "NA" ?></td>

                                                <td>₹<?php echo $payment[ 'amount' ] ?></td>
                                                <td><?php echo date('d-M-Y', strtotime($payment[ 'payment_date' ])) ?></td>

                                                    <td>
                                                        <?php echo $payment[ 'amount_received_at' ] ? date('d-M-Y, H:i A', strtotime($payment[ 'amount_received_at' ])) : '' ?>
                                                    </td>
                                                    <td>
                                                        <?php echo '₹' . $payment[ 'amount_received' ] ?>
                                                    </td>

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
        
        <?php if( $sub_page == 'payed_payments' ):?>

            <?php if( $daterange_param =  $this->input->get( 'date_range' ) ):?>

                <?php
                    $daterange = explode('-', $daterange_param );
                    
                    $minvalue = date('Y-m-d',strtotime($daterange[0])).' 00:00:00';
                    $maxvalue = date('Y-m-d',strtotime($daterange[1])).' 23:59:59';
                ?>

                var start = moment('<?= $minvalue?>');
                var end = moment( '<?= $maxvalue?>' );

            <?php else:?>

                var start = moment().subtract(29, 'days');
                var end = moment();
                
            <?php endif;?>

        function cb(start, end) {

            $('#advance-daterange #date_range_sel').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

        }

        $('#advance-daterange').daterangepicker({

            startDate: start,

            endDate: end,

            ranges: {

            'Today': [moment(), moment()],

            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],

            'Last 7 Days': [moment().subtract(6, 'days'), moment()],

            'Last 30 Days': [moment().subtract(29, 'days'), moment()],

            'This Month': [moment().startOf('month'), moment().endOf('month')],

            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]

            },

            opens: 'right',

        }, cb);



        cb(start, end);
        <?php endif;?>

$('#payments_data_table').DataTable();

    });

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
                        alert(res.msg);

                        window.location.reload();
                    } else {
                        alert(res.msg);
                    }
                },
                error: function(jqxhr) {
                    alert(jqxhr.status + ' Server Error');
                }

            });
        }

</script>