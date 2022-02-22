<?php include('common/header.php')?>
<?php include('common/menu.php')?>

<style>
    .table > thead > tr > th {
    padding: 12px 10px 12px !important;
}

.table td
{
    text-align:center;
}



</style>

    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li><a href="<?php echo base_url()?>">Home</a></li>
                            <li class="active">Loan Options</li>
                        </ol>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="bg-white pinside30">
                        <div class="row align-items-center">
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-6">
                                <h1 class="page-title">Loan Options</h1>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-6">
                                <div class="btn-action"> <a href="<?=base_url('assets/apk/easyloanmantra.apk')?>" class="btn btn-secondary">Download App</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=" ">
        <!-- content start -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="wrapper-content bg-white p-3 p-lg-5">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="section-title mb30">
                                    <h1>How much do you need?</h1>
                                    <p>
                                        With our multiple loan options you can now opt to borrow money starting as low as ₹ 3,000. You start at Level 1 and proceed to Level 17 with every borrowing and Timely repayments .The following explains our Loan structure along with processing fee, convenience charges and penalty charges.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Loan</th>
                                            <th>Loan Ammount</th>
                                            <th>Processing Fees</th>
                                            <th>Gst</th>
                                            <th>Convenience Charges</th>
                                            <th>Net Amount Disbursed</th>
                                            <th>Duration(Days)</th>
                                            <th>Fine per day post Due date</th>
                                            <!--<th>Extension Charges</th>-->
                                            <!--<th>Extension Days</th>-->
                                            <th>Extensions allowed after submission of convenience charges + GST + Processing Fee</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=0;?>
                                        <?php foreach($loans as $record){?>
                                        <tr>
                                        <td><?php echo ++$i?></td>
                                        <td><?php echo "Rs.". $record['amount']?></td>
                						<td><?php echo "Rs.". $record['processing_fee']?></td>
                						<td><?php echo "Rs.". $record['gst']?></td>
                						<td><?php echo "Rs.". $record['convenience_charges']?></td>
                						<td><?php echo "Rs.". ($record['amount']-($record['processing_fee']+$record['gst']+$record['convenience_charges']))?></td>
                						<td><?php echo $record['tenure']?></td>
                						<td><?php echo "Rs.". ($record['penalty']/100)*$record['amount']?></td>
                						<!--<td><?php echo "Rs.". ($record['extension_charges']/100)*$record['amount']?></td>-->
                						<!--<td><?php echo $record['extension_days'].' days'?></td>-->
                						<td>
                						    <?php if($record['ext_redeem_days']==1){?>
                						    <?php echo "Once"?>
                						    <?php } elseif($record['ext_redeem_days']==2) {?>
                						    <?php echo "Twice"?>
                						    <?php } else {?>
                						    <?php echo "Thrice"?>
                						    <?php }?>
                						 </td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include('common/footer.php')?>