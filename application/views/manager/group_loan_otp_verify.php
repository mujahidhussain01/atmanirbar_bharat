<?php include "common/header.php" ?>
<?php include "common/sidebar.php" ?>
<style>
    /* #partitioned {
  padding-left: 15px;
  letter-spacing: 42px;
  border: 0;
  background-image: linear-gradient(to left, black 70%, rgba(255, 255, 255, 0) 0%);
  background-position: bottom;
  background-size: 50px 1px;
  background-repeat: repeat-x;
  background-position-x: 35px;
  width: 220px;
} */
</style>
<div class="app-content content">
    <div class="content-wrapper-before" style="position: relative;">
        <div class="content-header row">
            <div class="content-header-left col-md-4 col-12">
                <h5 class="content-header-title text-center mt-1 text-white">User OTP Verify</h5>
            </div>
        </div>
    </div>
    <div class="content-wrapper">
        <div id="content" class="content-body mt-5">
            <div class="panel-group" id="accordion">
                <div class="card">
                    <div class="card-header">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title text-capitalize text-center">
                                    Enter User OTP
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="panel-body">
                            <div class="row p-2">
                                <form id="applyGroupLoanForm" class="col-12 row pr-0">

                                    <div class="col-12 my-1">
                                        <strong>Group Name:</strong>
                                        <p><?= $group_loan_info[ 'name' ]?></p>
                                        
                                    </div>

                                    <div class="col-12 my-1">

                                        <input type="hidden" style="display: none;" required value="<?= $mobile ?>" id="mobile">

                                        <strong>Enter OTP:</strong>
                                        <input type="number" required name="otp_val" id="otp_val" class="form-control" min="0">

                                    </div>

                                    <div class="col-12 my-1">
                                        <label>Amount:</label>
                                        <input type="number" step="1" class="form-control editableInp form-control-md" placeholder="Amount" required name="amt" id='loan_amount' min="0" step="1">
                                    </div>

                                    <div class="col-12 my-1">
                                        <label>Loan Duration ( in days ):</label>
                                        <input type="number" step="1" class="form-control editableInp form-control-md" placeholder="Loan Duration ( in days )" required name="loan_duration" id='loan_duration' min="1">
                                    </div>

                                    <div class="col-12 my-1">
                                        <label>Payment Mode:</label>
                                        <select type="number" class="form-control editableInp form-control-md" placeholder="Payment Mode" required name="payment_mode" id='payment_mode'>
                                            <option value="" selected readonly>select</option>
                                            <option value="daily">Daily</option>
                                            <option value="weekly">Weekly</option>
                                            <option value="every-15-days">Every 15 Days</option>
                                            <option value="monthly">Monthly</option>
                                        </select>
                                    </div>

                                    <div class="col-12 my-1">
                                        <label>Deduct 1% LIC Amount:</label>
                                        <select type="number" class="form-control editableInp form-control-md" placeholder="Deduct LIC Amount" required name="deduct_lic_amount" id='deduct_lic_amount'>
                                            <option value="" selected readonly>select</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>

                                    <div class="col-12 my-1">
                                        <label>Rate Of Interest ( in % ) :</label>
                                        <input disabled type="number" class="form-control form-control-md" placeholder="Rate Of Interest ( in % )" name="rate_of_interest" id='rate_of_interest' min="0" max="100" step=".01" value="<?= $group_loan_info[ 'rate_of_interest' ]?>">
                                    </div>
                                    <div class="col-12 my-1">
                                        <label>Processing fee (In %):</label>
                                        <input disabled type="number" step="any" class="form-control form-control-md" placeholder="Processing fees %" name="process_fee_percent" id='process_fee_percent' min="0" max="100" step=".01" value="<?= $group_loan_info[ 'process_fee_percent' ]?>">
                                    </div>
                                    <div class="col-12 my-1">
                                        <label>Bouncing Charges ( in % ):</label>
                                        <input disabled type="number" class="form-control form-control-md" placeholder="Bouncing Charges ( in % )" name="bouncing_charges_percent" id='bouncing_charges_percent' step=".01" min="0" value="<?= $group_loan_info[ 'bouncing_charges_percent' ]?>">
                                    </div>
                                    <div class="col-12 my-1">
                                        <label>Bouncing Charges:</label>
                                        <input disabled type="number" step="any" class="form-control form-control-md" placeholder="Bouncing Charges" name="bouncing_charges" id='bouncing_charges' min="0" readonly>
                                    </div>
                                    <div class="col-12 my-1">
                                        <label>Processing fee:</label>
                                        <input disabled type="number" step="1" class="form-control form-control-md" placeholder="Processing fees" readonly name="processing_fee" min="1" id='process_fee_value'>
                                    </div>
                                    <div class="col-12 my-1">
                                        <label>Payable Amount:</label>
                                        <input disabled type="number" step="any" class="form-control form-control-md" placeholder="Payable Amount" id='payable_amount' readonly>
                                    </div>
                                    <hr class="col-12 p-0 m-0">
                                    <div class="col-12 my-1">
                                        <label>Emi Amount: <span class="emiCountShow"></span></label>
                                        <input disabled type="number" step="any" class="form-control form-control-md" placeholder="Emi Amount" name="emi_amount" id='emi_amount' readonly>
                                    </div>
                                    <div class="col-12 my-1">
                                        <label>Final Loan Amount:</label>
                                        <input disabled type="number" step="any" class="form-control form-control-md" placeholder="Final Loan Amount" id='final_loan_amount' readonly>
                                    </div>
                                    <hr class="col-12 p-0 m-0">
                                    <div class="col-12 my-1">
                                        <label>Emi Amount ( With LIC Deduction ): <span class="emiCountShow"></span></label>
                                        <input disabled type="number" step="any" class="form-control form-control-md" placeholder="Emi Amount ( With LIC Deduction )" id='emi_amount_with_lic' readonly>
                                    </div>
                                    <div class="col-12 my-1">
                                        <label>Final Loan Amount ( With LIC Deduction ):</label>
                                        <input disabled type="number" step="any" class="form-control form-control-md" placeholder="Final Loan Amount ( With LIC Deduction )" id='final_loan_amount_with_lic' readonly>
                                    </div>
                                    <div class="col-12 my-1 d-flex justify-content-end my-2">
                                        <button type="submit" id="submitBtn" class="btn btn-lg btn-primary">Apply Now</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "common/footer.php" ?>
<link rel="stylesheet" href="<?= base_url('assets/css/jquery-confirm.css') ?>">
<script src="<?= base_url('assets/js/jquery-confirm.min.js') ?>"></script>
<script>
$(document).ready(function()
{
    var applyGroupLoanForm = $('#applyGroupLoanForm');

    var mobileInp = $('#mobile');
    var otp_valInp = $('#otp_val');
    var loan_amountInp = $('#loan_amount');
    var loan_durationInp = $('#loan_duration');
    var payment_modeInp = $('#payment_mode');
    var deduct_lic_amountInp = $('#deduct_lic_amount');

    $(applyGroupLoanForm).on('submit', function(e)
    {
        e.preventDefault();
        $.confirm(
        {
            title: 'Send OTP',
            content: function()
            {
                var self = this;
                var formData = new FormData;

                formData.append('mobile', $( mobileInp ).val() );
                formData.append('otp_val', $( otp_valInp ).val() );
                formData.append('loan_amount', $( loan_amountInp ).val() );
                formData.append('loan_duration', $( loan_durationInp ).val() );
                formData.append('payment_mode', $( payment_modeInp ).val() );
                formData.append('deduct_lic_amount', $( deduct_lic_amountInp ).val() );

                return $.ajax(
                    {
                        url: '<?= base_url('manager/group_loans/user_otp_verify/' . $group_loan_info['id']) ?>',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false
                    })
                    .done(function(response)
                    {
                        try
                        {
                            var response = JSON.parse(response);

                            self.setTitle(response.success ? 'Success' : 'Error');
                            self.setType(response.success ? 'green' : 'red');
                            self.setContent(response.msg);
                            
                            if( response.success )
                            {
                                $( submitBtn ).prop( 'disabled', true );

                                setTimeout(function()
                                {
                                    window.location.href = '<?= base_url('manager/loans/details/') ?>'+response.data.new_loan_id;
                                }, 3000);
                            }
                        }
                        catch
                        {
                            self.setTitle('Unknown Error');
                            self.setType('red');
                            self.setContent('Please Try Again Later');
                        }
                    })
                    .fail(function()
                    {
                        self.setContent('Unknown Error, Please Try Again Later');
                    });
            }
        });
    });

    var submitBtn = $('#submitBtn');

    $( otp_val ).on('input', function()
    {
        $(submitBtn).prop('disabled', true);
        
        if (/^[0-9]{4}$/gi.test($(this).val()))
        {
            $(submitBtn).prop('disabled', false);
        }
    });

    
    // emi calculate  amount -------------------------------------------

    $(".panel-body").on("change keyup", ".editableInp", function()
    {
        // get all input values -----

        var parentForm = $(this).parents('.panel-body');

        var loan_amount_inp = $( parentForm ).find('#loan_amount');
        var loan_amount_val = parseInt($(loan_amount_inp).val(), 10);

        var rate_of_interest_inp = $( parentForm ).find('#rate_of_interest');
        var rate_of_interest_val = parseFloat($(rate_of_interest_inp).val()).toFixed(2);

        if (rate_of_interest_val < 0) {
            $(rate_of_interest_inp).val(0);
            rate_of_interest_val = 0;
        } else if (rate_of_interest_val > 100) {
            $(rate_of_interest_inp).val(100);
            rate_of_interest_val = 100;
        }

        var process_fee_percent_inp = $( parentForm ).find('#process_fee_percent');
        var process_fee_percent_val = parseFloat($(process_fee_percent_inp).val()).toFixed(2);

        if (process_fee_percent_val < 0) {
            $(process_fee_percent_inp).val(0);
            process_fee_percent_val = 0;
        } else if (process_fee_percent_val > 100) {
            $(process_fee_percent_inp).val(100);
            process_fee_percent_val = 100;
        }

        var bouncing_charges_percent_inp = $( parentForm ).find('#bouncing_charges_percent');
        var bouncing_charges_percent_val = parseFloat($(bouncing_charges_percent_inp).val()).toFixed(2);

        if (bouncing_charges_percent_val < 0) {
            $(bouncing_charges_percent_inp).val(0);
            bouncing_charges_percent_val = 0;
        } else if (bouncing_charges_percent_val > 100) {
            $(bouncing_charges_percent_inp).val(100);
            bouncing_charges_percent_val = 100;
        }

        var loan_duration_inp = $( parentForm ).find('#loan_duration');
        var loan_duration_val = parseInt($(loan_duration_inp).val(), 10) >= 1 ?
            parseInt($(loan_duration_inp).val(), 10) : 1;

        var payment_mode_inp = $( parentForm ).find('#payment_mode');
        var payment_mode_val = $(payment_mode_inp).val();

        //  get input whose values to be set -----
        var bouncing_charges_inp = $( parentForm ).find('#bouncing_charges');
        var process_fee_inp = $( parentForm ).find('#process_fee_value');

        var emi_amount_inp = $( parentForm ).find('#emi_amount');
        var emi_count_show = $( parentForm ).find('.emiCountShow');
        var final_loan_amount_inp = $( parentForm ).find('#final_loan_amount');
        var payable_amount_inp = $( parentForm ).find('#payable_amount');

        var emi_amount_with_lic_inp = $( parentForm ).find('#emi_amount_with_lic');
        var final_loan_amount_with_lic_inp = $( parentForm ).find('#final_loan_amount_with_lic');


        // set initial value to 0
        $(bouncing_charges_inp).val(0);
        $(process_fee_inp).val(0);

        $(emi_amount_inp).val(0);
        $(final_loan_amount_inp).val(0);
        $(payable_amount_inp).val(0);

        $(emi_amount_with_lic_inp).val(0);
        $(final_loan_amount_with_lic_inp).val(0);


        if (loan_amount_val > 1) {
            // count bouncing charges ----
            if (bouncing_charges_percent_val > 0) {
                var bouncing_charges_val = Math.ceil((loan_amount_val / 100) * bouncing_charges_percent_val);
                $(bouncing_charges_inp).val(bouncing_charges_val);
            }


            // count Processing free charges ----

            var process_fee_val = 0;

            if (process_fee_percent_val > 0) {
                var process_fee_val = Math.ceil((loan_amount_val / 100) * process_fee_percent_val);
                $(process_fee_inp).val(process_fee_val);
            }


            // count emi Amount --------

            var interest_amount = 0;

            if ( rate_of_interest_val > 0 )
            {
                interest_amount_initial = Math.ceil( ( loan_amount_val / 100 ) * rate_of_interest_val );

                if( loan_duration_val > 30 )
                {
                    multiply_by = Math.ceil( loan_duration_val / 30 );
                    interest_amount = Math.ceil( interest_amount_initial * multiply_by );
                }
                else
                {
                    interest_amount = interest_amount_initial;
                }
            }


            var final_loan_amount = loan_amount_val + interest_amount;
            var payable_amount = ( loan_amount_val ) - process_fee_val;

            $(final_loan_amount_inp).val(final_loan_amount);
            $(payable_amount_inp).val(payable_amount);

            // ----------------

            var one_percent = Math.ceil((loan_amount_val / 100));

            var final_loan_amount_with_lic = final_loan_amount + one_percent;

            $(final_loan_amount_with_lic_inp).val(final_loan_amount_with_lic);

            // set initial emi count
            var total_emi_count = 1;

            // get value to be divided by loan duration to calculate emi amount
            var divided_by = 1;

            if (payment_mode_val == 'weekly') {
                divided_by = 7;
            } else if (payment_mode_val == 'every-15-days') {
                divided_by = 15;
            } else if (payment_mode_val == 'monthly') {
                divided_by = 30;
            }

            total_emi_count = Math.floor(loan_duration_val / divided_by);

            if (total_emi_count >= 1) {
                $(emi_amount_inp).val(Math.ceil(final_loan_amount / total_emi_count));
            } else {
                $(emi_amount_inp).val(final_loan_amount);
            }
            
            $( emi_count_show ).text( ' x '+total_emi_count );

            if (total_emi_count >= 1) {
                $(emi_amount_with_lic_inp).val(Math.ceil(final_loan_amount_with_lic / total_emi_count));
            } else {
                $(emi_amount_with_lic_inp).val(final_loan_amount_with_lic);
            }

        }
    });
});
</script>