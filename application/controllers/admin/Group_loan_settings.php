<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Group_loan_settings extends CI_Controller
{



    public function __construct()

    {

        parent::__construct();

        if (!isset($this->session->userdata['user'])) {

            redirect('admin/login');
        }

        $this->load->model('loan_setting_model');

        $this->load->model('Otp_model');

        $this->load->model('Loan_apply_model');
        $this->load->model('Loan_payments_model');
        $this->load->model( 'Loan_extension_model' );

        $this->load->model('Adminlogin');

        $this->load->model('User_model');
    }



    public function View_group_loan_setting()

    {

        $this->data['page'] = 'group_loan_settings';

        $this->data['data'] = $this->loan_setting_model->get_group_loan_settings();

        $this->load->view('admin/group_loan_setting', $this->data);
    }



    public function loan_setting()

    {

        $this->form_validation->set_rules('loan_name', 'Loan Name', 'trim|required');

        $this->form_validation->set_rules('amt', 'Ammount', 'trim|required');

        $this->form_validation->set_rules('rate_of_interest', 'Rate Of Interest', 'trim|required');

        $this->form_validation->set_rules('processing_fee', 'Processing fees ', 'trim|required');

        $this->form_validation->set_rules('process_fee_percent', 'Processing fees Percent ', 'trim|required');

        $this->form_validation->set_rules('loan_duration', 'Loan Duration', 'trim|required');

        $this->form_validation->set_rules('payment_mode', 'Payment Mode', 'trim|required');

        $this->form_validation->set_rules('emi_amount', 'Emi Amount', 'trim|required');

        $this->form_validation->set_rules('bouncing_charges_percent', 'Bouncing Charges Percent', 'trim|required');

        $this->form_validation->set_rules('bouncing_charges', 'Bouncing Charges', 'trim|required');


        if ($this->form_validation->run() == FALSE) {

            $data['data'] = $this->loan_setting_model->get_group_loan_settings();

            $this->load->view('admin/group_loan_setting', $data);
        } else {

            $data['loan_name'] = $this->input->post('loan_name');

            $data['loan_type'] = 'GROUP';

            $data['amount'] = $this->input->post('amt');

            $data['rate_of_interest'] = $this->input->post('rate_of_interest');

            $data['processing_fee'] = $this->input->post('processing_fee');

            $data['process_fee_percent'] = $this->input->post('process_fee_percent');

            $data['loan_duration'] = $this->input->post('loan_duration');

            $data['payment_mode'] = $this->input->post('payment_mode');

            $data['emi_amount'] = $this->input->post('emi_amount');

            $data['bouncing_charges_percent'] = $this->input->post('bouncing_charges_percent');

            $data['bouncing_charges'] = $this->input->post('bouncing_charges');

            $result = $this->loan_setting_model->set_loan($data);



            if ($result > 0) {

                $this->session->set_flashdata('success', 'New Settings Added successfully!');
            } else {

                $this->session->set_flashdata('error', 'Error in Adding new Settings!');
            }

            redirect('admin/group_loan_settings/loan_setting');
        }
    }



    public function view_edit_modal($lsid)

    {

        $result = $this->loan_setting_model->getloan_setting($lsid, 'GROUP'); ?>

        <form data-action="<?php echo base_url() ?>admin/group_loan_settings/update_loan_setting/<?= $result['lsid'] ?>" onsubmit="return edit_loan(this)" method="post" class="margin-bottom-0">

            <div class="form-row">

                <div class="col-md-6 form-group m-b-15 ">

                    <label>Group Loan Name:</label>

                    <input type="text" minlenght="2" maxlength="100" class="form-control form-control-md" placeholder="Loan Name" value='<?php echo $result['loan_name'] ?>' required name="loan_name" id='loan_name'>

                </div>


                <div class="col-md-6 form-group m-b-15 ">

                    <label>Amount:</label>

                    <input type="number" step='any' class="form-control form-control-md" placeholder="Amount" value='<?php echo $result['amount'] ?>' required name="amount" id='loan_amount'>

                </div>

                <div class="form-group m-b-15 col-md-6">

                    <label>Rate Of Interest ( in % ):</label>

                    <input type="number" step='any' class="form-control form-control-md" placeholder="Rate Of Interest" value='<?php echo $result['rate_of_interest'] ?>' required name="rate_of_interest" id='rate_of_interest'>

                </div>

                <div class="form-group m-b-15 col-md-6">

                    <label>Processing fee ( in % ):</label>

                    <input type="number" step='any' class="form-control form-control-md" placeholder="Processing fees" value='<?php echo $result['process_fee_percent'] ?>' required name="process_fee_percent" id='process_fee_percent'>

                </div>


                <div class="form-group m-b-15 col-md-6">

                    <label>Bouncing Charges ( in % ):</label>

                    <input type="number" class="form-control form-control-md" placeholder="Bouncing Charges ( in % )" required name="bouncing_charges_percent" id='bouncing_charges_percent' step=".01" min="0" value="<?php echo $result['bouncing_charges_percent'] ?>">

                </div>

                <div class="form-group m-b-15 col-md-6">

                    <label>Bouncing Charges:</label>

                    <input type="number" step="any" class="form-control form-control-md" placeholder="Bouncing Charges" required name="bouncing_charges" id='bouncing_charges' min="0" value="<?php echo $result['bouncing_charges'] ?>" readonly>

                </div>

                <div class="form-group m-b-15 col-md-6">

                    <label>Loan Duration ( in days ):</label>

                    <input type="number" step="1" class="form-control form-control-md" placeholder="Loan Duration ( in days )" required name="loan_duration" id='loan_duration' min="1" value="<?php echo $result['loan_duration'] ?>">

                </div>


                <div class="form-group m-b-15 col-md-6">

                    <label>Payment Mode:</label>

                    <select type="number" class="form-control form-control-md" placeholder="Payment Mode" required name="payment_mode" id='payment_mode'>
                        <option value="" readonly>select</option>
                        <option <?php if ($result['payment_mode'] == 'daily') echo 'selected'; ?> value="daily">Daily</option>
                        <option <?php if ($result['payment_mode'] == 'weekly') echo 'selected'; ?> value="weekly">Weekly</option>
                        <option <?php if ($result['payment_mode'] == 'every-15-days') echo 'selected'; ?> value="every-15-days">Every 15 Days</option>
                        <option <?php if ($result['payment_mode'] == 'monthly') echo 'selected'; ?> value="monthly">Monthly</option>
                    </select>

                </div>


                <div class="form-group m-b-15 col-md-6">

                    <label>Processing fee:</label>

                    <input type="number" step='any' class="form-control form-control-md" placeholder="Processing fees" readonly value='<?php echo $result['processing_fee'] ?>' required name="processing_fee" id='process_fee_value'>

                </div>

                <div class="form-group m-b-15 col-md-6">

                <label>Payable Amount:</label>

                <input type="number" step="any" class="form-control form-control-md" placeholder="Payable Amount" id='payable_amount' readonly>


                </div>

                <hr class="col-12">


                <div class="form-group m-b-15 col-md-6">

                    <label>Emi Amount: <span class="emiCountShow" ></span></label>

                    <input type="number" step="any" class="form-control form-control-md" placeholder="Emi Amount" required name="emi_amount" id='emi_amount' readonly value="<?php echo $result['emi_amount'] ?>">

                </div>

                <div class="form-group m-b-15 col-md-6">

                    <label>Loan Closer Amount:</label>

                    <input type="number" step="any" class="form-control form-control-md" placeholder="Loan Closer Amount" id='loan_closer_amount' readonly>

                </div>



                <hr class="col-12">


                <div class="form-group m-b-15 col-md-6">

                    <label>Emi Amount ( With LIC Deduction ): <span class="emiCountShow" ></span></label>

                    <input type="number" step="any" class="form-control form-control-md" placeholder="Emi Amount ( With LIC Deduction )" id='emi_amount_with_lic' readonly>

                </div>


                <div class="form-group m-b-15 col-md-6">

                    <label>Loan Closer Amount ( With LIC Deduction ):</label>

                    <input type="number" step="any" class="form-control form-control-md" placeholder="Loan Closer Amount ( With LIC Deduction )" id='loan_closer_amount_with_lic' readonly>


                </div>



                <div class="login-buttons col-12">

                    <button type="submit" class="btn btn-primary btn-sm">Save changes</button>

                </div>

            </div>



        </form>

<?php

    }



    public function update_loan_setting($lsid)

    {

        $result = $this->loan_setting_model->update($_POST, $lsid);

        if ($result) {

            echo json_encode(array("error" => 0));
        } else {

            echo json_encode(array("error" => 1));
        }
    }
}
