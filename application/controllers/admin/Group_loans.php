<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Group_loans extends CI_Controller
{

    public $data = [
        'page' => 'Group Loans',
        
    ];

    public function __construct()
    {
        parent::__construct();

		if(!isset($this->session->userdata['user']))
        {
            redirect('admin/login');
        }

		$this->load->model('Loan_apply_model');
		$this->load->model('User_model');
		$this->load->model('Loan_payments_model');
        $this->load->model( 'Loan_extension_model' );
        $this->load->model( 'Group_loans_model' );
    }


    public function index()
    {
        $this->data['data'] = $this->Group_loans_model->get_all_group_loans();
        $this->load->view('admin/group_loans',$this->data);
    }

    public function create_new_group_loan()
	{	
        $this->form_validation->set_rules('group_name', 'Group Name', 'trim|required|min_length[2]|max_length[100]');
        $this->form_validation->set_rules( 'rate_of_interest', 'Rate Of Interest', 'trim|required|less_than_equal_to[100]|greater_than[0]');
        $this->form_validation->set_rules( 'process_fee_percent', 'Processing Fee Percent', 'trim|required|less_than_equal_to[100]|greater_than[0]');
        $this->form_validation->set_rules( 'bouncing_charges_percent', 'Bouncing Charges Percent', 'trim|required|less_than_equal_to[100]|greater_than[0]');

        if ($this->form_validation->run() == FALSE)
        {
            $this->data['data'] = $this->Group_loans_model->get_all_group_loans();
            $this->load->view('admin/group_loans',$this->data);
            return;
        }

        $is_exists = $this->Group_loans_model->get_single_group_loan_where(
            [ 
                'name' => $this->input->post( 'group_name' )                
            ]
        );

        if( $is_exists )
        {
            $this->session->set_flashdata( 'error', 'Group With Given Name Already Exists, Please Try Another One' );

            $this->data['data'] = $this->Group_loans_model->get_all_group_loan();
            $this->load->view('admin/group_loans',$this->data);
            return;
        }

        $new_group_loan[ 'name' ] = $this->input->post( 'group_name' );
        $new_group_loan[ 'rate_of_interest' ] = $this->input->post( 'rate_of_interest' );
        $new_group_loan[ 'process_fee_percent' ] = $this->input->post( 'process_fee_percent' );
        $new_group_loan[ 'bouncing_charges_percent' ] = $this->input->post( 'bouncing_charges_percent' );

        if( $this->Group_loans_model->create_group_loan( $new_group_loan ) ) 
        {
            $this->session->set_flashdata('success','New Group Added successfully!');
        }
        else
        {
            $this->session->set_flashdata('error','Error in Adding new Group!');
        }
        redirect('admin/group_loans');
	}


	public function view_edit_modal( $id )
	{
		$result = $this->Group_loans_model->get_group_loan_by_id( $id );
        
        if( !$result )
        {
            show_404();
            return;
        }
        ?>

        <form data-action="<?php echo base_url()?>admin/group_loans/update_group_loan/<?=$result[ 'id']?>" onsubmit="return edit_group_loan(this)" method="post" class="margin-bottom-0">

                <div class="form-row">

                    <div class="col-md-6 form-group m-b-15 ">
						<label>Group Name:</label>	
						<input type="text" minlength="2" maxlength="100" class="form-control form-control-md" placeholder="Group Name" required name="group_name" id='group_name' value="<?php echo $result[ 'name' ];?>">
					</div>
                    										
					<div class="col-md-6 form-group m-b-15">

                        <label>Rate Of Interest( in % ) :</label>

                        <input type="number" class="form-control form-control-md" placeholder="Rate Of Interest ( in % )" required name="rate_of_interest" id='rate_of_interest' min="0" max="100" step=".01" value="<?= $result[ 'rate_of_interest' ] ?>">

                        <?php echo form_error('rate_of_interest', '<p class="alert alert-danger" role="alert">', '</p>'); ?>

                    </div>

                    <div class="col-md-6 form-group m-b-15">

                    <label>Processing Fee Percent( in % ) :</label>

                        <input type="number" class="form-control form-control-md" placeholder="Processing Fee Percent ( in % )" required name="process_fee_percent" id='process_fee_percent' min="0" max="100" step=".01" value="<?= $result[ 'process_fee_percent' ] ?>">

                        <?php echo form_error('process_fee_percent', '<p class="alert alert-danger" role="alert">', '</p>'); ?>

                    </div>

                    <div class="col-md-6 form-group m-b-15">

                        <label>Bouncing Charges Percent( in % ) :</label>

                        <input type="number" class="form-control form-control-md" placeholder="Bouncing Charges Percent ( in % )" required name="bouncing_charges_percent" id='bouncing_charges_percent' min="0" max="100" step=".01" value="<?= $result[ 'bouncing_charges_percent' ] ?>">

                        <?php echo form_error('bouncing_charges_percent', '<p class="alert alert-danger" role="alert">', '</p>'); ?>

                    </div>

					<div class="login-buttons col-12">
						<button type="submit" class="btn btn-primary btn-sm">Save changes</button>
					</div>

                </div>
        </form>

	<?php 

    }


    public function update_group_loan( $id )
    {
        if( $_SERVER[ 'REQUEST_METHOD' ] !== 'POST' ) show_404();

        $old_data = $this->Group_loans_model->get_group_loan_by_id( $id );

        if( !$old_data )
        {
            echo 'Group Not Found';
            return;
        }

        $this->form_validation->set_rules('group_name', 'Group Name', 'trim|required|min_length[2]|max_length[100]');

        if ($this->form_validation->run() == FALSE)
        {

            echo json_encode(
                [ 
                    "error" => 1,
                    "msg" => form_error( 'group_name' )
                ]
            );
            return;
        }

        if( $old_data[ 'name' ] != $this->input->post( 'group_name' ) )
        {
            $is_exists = $this->Group_loans_model->get_single_group_loan_where(
                [ 
                    'name' => $this->input->post( 'group_name' )
                ]
            );
    
            if( $is_exists )
            {
                echo json_encode(array("error"=>1, 'msg' => 'Group With Given Name Already Exists, Please Try Another One'));
                return;
            }
        }

        $update_group_loan['name']=$this->input->post('group_name');

        if ( $this->Group_loans_model->update_single_group_loan( $update_group_loan, $id ) )
        {
            echo json_encode(array("error"=>0));
        } 
        else 
        {
            echo json_encode(array("error"=>1, 'msg' => 'Unknow Error'));
        }
    }

    public function delete_group_loan( $id )
    {
        if( $_SERVER[ 'REQUEST_METHOD' ] != 'POST' )
        {
            show_error( 'Action You Are Trying Is Prohibited' );
        }

        if ( $this->Group_loans_model->update_single_group_loan( [ 'status' => 'INACTIVE' ] , intval( $id ) ) )
        {
            echo json_encode(array("error"=>0));
        } 
        else 
        {
            echo json_encode(array("error"=>1));
        }
    }

}

/* End of file Groups.php */
