<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends CI_Controller
{

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
        $this->load->model( 'Groups_model' );
    }


    public function index()
    {
        $data['page'] = 'groups';
        $data['data'] = $this->Groups_model->get_all_groups();
        $this->load->view('admin/groups',$data);
    }

    public function create_new_group()
	{	
        $this->form_validation->set_rules('group_name', 'Group Name', 'trim|required|min_length[2]|max_length[100]');

        if ($this->form_validation->run() == FALSE)
        {
            $data['page'] = 'groups';
            $data['data'] = $this->Groups_model->get_all_groups();
            $this->load->view('admin/groups',$data);
            return;
        }

        $is_exists = $this->Groups_model->get_single_group_where(
            [ 
                'name' => $this->input->post( 'group_name' )
            ]
        );

        if( $is_exists )
        {
            $this->session->set_flashdata( 'error', 'Group With Given Name Already Exists, Please Try Another One' );

            $data['page'] = 'groups';
            $data['data'] = $this->Groups_model->get_all_groups();
            $this->load->view('admin/groups',$data);
            return;
        }

        $data['name'] = $this->input->post('group_name');

        if( $this->Groups_model->create_group( $data ) ) 
        {
            $this->session->set_flashdata('success','New Group Added successfully!');
        }
        else
        {
            $this->session->set_flashdata('error','Error in Adding new Group!');
        }
        redirect('admin/groups');
	}


	public function view_edit_modal( $id )
	{
		$result = $this->Groups_model->get_group_by_id( $id );
        
        if( !$result )
        {
            show_404();
            return;
        }
        ?>

        <form data-action="<?php echo base_url()?>admin/groups/update_group/<?=$result[ 'id']?>" onsubmit="return edit_group(this)" method="post" class="margin-bottom-0">

                <div class="form-row">

                    <div class="col-md-6 form-group m-b-15 ">
						<label>Group Name:</label>	
						<input type="text" minlenght="2" maxlength="100" class="form-control form-control-md" placeholder="Group Name" required name="group_name" id='group_name' value="<?php echo $result[ 'name' ];?>">
					</div>

					<div class="login-buttons col-12">
						<button type="submit" class="btn btn-primary btn-sm">Save changes</button>
					</div>

                </div>
        </form>

	<?php 

    }


    public function update_group( $id )
    {

        $old_data = $this->Groups_model->get_group_by_id( $id );

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
            $is_exists = $this->Groups_model->get_single_group_where(
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

        $data['name']=$this->input->post('group_name');

        if ( $this->Groups_model->update_single_group( $data, $id ) )
        {
            echo json_encode(array("error"=>0));
        } 
        else 
        {
            echo json_encode(array("error"=>1, 'msg' => 'Unknow Error'));
        }
    }

    public function delete_group( $id )
    {
        if( $_SERVER[ 'REQUEST_METHOD' ] != 'POST' )
        {
            show_error( 'Action You Are Trying Is Prohibited' );
        }

        if ( $this->Groups_model->update_single_group( [ 'status' => 'INACTIVE' ] , intval( $id ) ) )
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
