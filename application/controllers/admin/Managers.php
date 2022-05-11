<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Managers extends CI_Controller
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
        $this->load->model( 'Loan_extension_model' );
		$this->load->model('Loan_payments_model');

        $this->load->model( 'Managers_model' );
    }


    public function index()
    {
        $data['page'] = 'managers';
        $data['data'] = $this->Managers_model->get_all_active_managers();
        $this->load->view('admin/managers',$data);
    }

    public function create_new_manager()
	{	
        $this->form_validation->set_rules('manager_name', 'Manager Name', 'trim|required|min_length[2]|max_length[100]');
        $this->form_validation->set_rules('manager_email', 'Manager Email', 'trim|required|min_length[2]|max_length[100]|valid_email' );
        $this->form_validation->set_rules('manager_mobile', 'Manager Mobile', 'trim|required|numeric|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('manager_city', 'Manager City', 'trim|required|min_length[2]|max_length[100]');
        $this->form_validation->set_rules('manager_pass_word', 'Manager Password', 'trim|required|min_length[6]|max_length[100]');

        if ($this->form_validation->run() == FALSE)
        {
            $data['page'] = 'managers';
            $data['data'] = $this->Managers_model->get_all_active_managers();
            $this->load->view('admin/managers',$data);
            return;
        }

        $is_exists = $this->Managers_model->get_single_manager_where(
            [ 
                'email' => $this->input->post( 'manager_email' ),
                'status' => 'ACTIVE'
            ]
        );

        if( $is_exists )
        {
            $this->session->set_flashdata( 'error', 'Manager With Given Email Already Exists, Please Try Another One' );

            $data['page'] = 'managers';
            $data['data'] = $this->Managers_model->get_all_active_managers();
            $this->load->view('admin/managers',$data);
            return;
        }

        $data['name'] = $this->input->post('manager_name');
        $data['email'] = $this->input->post('manager_email');
        $data['mobile'] = $this->input->post('manager_mobile');
        $data['city'] = $this->input->post('manager_city');
        $data['pass_word'] =  md5( $this->input->post('manager_pass_word') );

        $length=35;
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));
        for ($i = 0; $i < $length; $i++) 
        {
          $key .= $keys[array_rand($keys)];
        }
        $token = $key;
        $data['token'] = $token;

        // $data['token'] =  bin2hex( random_bytes( 32 ) );

        $result=$this->Managers_model->create_manager( $data );

        if( $result > 0 ) 
        {
            $this->session->set_flashdata('success','New Manager Added successfully!');
        }
        else
        {
            $this->session->set_flashdata('error','Error in Adding new Manager!');
        }
        redirect('admin/managers');
	}


	public function view_edit_modal( $id )
	{
		$result = $this->Managers_model->get_manager_by_id( $id );
        
        if( !$result )
        {
            show_404();
            return;
        }
        ?>

        <form data-action="<?php echo base_url()?>admin/managers/update_manager/<?=$result[ 'id']?>" onsubmit="return edit_manager(this)" method="post" class="margin-bottom-0">

                <div class="form-row">

                <div class="col-md-6 form-group m-b-15 ">
						<label>Manager Name:</label>	
						<input type="text" minlenght="2" maxlength="100" class="form-control form-control-md" placeholder="Manager Name" required name="manager_name" id='manager_name' value="<?php echo $result[ 'name' ];?>">
					</div>

                    <div class="col-md-6 form-group m-b-15 ">
						<label>Manager Email:</label>	
						<input type="email" minlenght="2" maxlength="100" class="form-control form-control-md" placeholder="Manager Email" required name="manager_email" id='manager_email' value="<?php echo $result[ 'email' ];?>">
					</div>

                    <div class="col-md-6 form-group m-b-15 ">
						<label>Manager Mobile:</label>	
						<input type="text" minlenght="10" maxlength="10" pattern="^[6-9][0-9]{9}$" class="form-control form-control-md" placeholder="Mobile ex. 9999999999" required name="manager_mobile" id='manager_mobile' value="<?php echo $result[ 'mobile' ];?>">
					</div>

                    <div class="col-md-6 form-group m-b-15 ">
						<label>Manager City:</label>	
						<input type="text" minlenght="2" maxlength="100" class="form-control form-control-md" placeholder="Manager City" required name="manager_city" id='manager_city' value="<?php echo $result[ 'city' ];?>">
					</div>

                    <div class="col-md-6 form-group m-b-15 ">
						<label>Reset Manager's Password( Optional ):</label>	
						<input type="text" minlenght="6" maxlength="100" class="form-control form-control-md" placeholder="Reset Manager's Password( Optional )" name="manager_pass_word" id='manager_pass_word' value="">
					</div>

					<div class="login-buttons col-12">
						<button type="submit" class="btn btn-primary btn-sm">Save changes</button>
					</div>

                </div>
            </form>

	<?php 

    }


    public function update_manager( $id )
    {

        $old_data = $this->Managers_model->get_manager_by_id( $id );

        if( !$old_data )
        {
            echo 'Manager Not Found';
            return;
        }

        $this->form_validation->set_rules('manager_name', 'Manager Name', 'trim|required|min_length[2]|max_length[100]');
        $this->form_validation->set_rules('manager_email', 'Manager Email', 'trim|required|min_length[2]|max_length[100]|valid_email');
        $this->form_validation->set_rules('manager_mobile', 'Manager Mobile', 'trim|required|numeric|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('manager_city', 'Manager City', 'trim|required|min_length[2]|max_length[100]');
        $this->form_validation->set_rules('manager_pass_word', 'Manager Password', 'trim|min_length[6]|max_length[100]');

        if ($this->form_validation->run() == FALSE)
        {
            $error = 'Validation Error';

            if( form_error( 'manager_name' ) )
            {
                $error = form_error( 'manager_name' );
            }
            else if( form_error( 'manager_email' ) )
            {
                $error = form_error( 'manager_email' );
            }
            else if( form_error( 'manager_mobile' ) )
            {
                $error = form_error( 'manager_mobile' );
            }
            else if( form_error( 'manager_city' ) )
            {
                $error = form_error( 'manager_city' );
            }
            else if( form_error( 'manager_pass_word' ) )
            {
                $error = form_error( 'manager_pass_word' );
            }

            echo json_encode(
                [ 
                    "error" => 1,
                    "msg" => $error
                ]
            );
            return;
        }

        if( $old_data[ 'email' ] != $this->input->post( 'manager_email' ) )
        {
            $is_exists = $this->Managers_model->get_single_manager_where(
                [ 
                    'email' => $this->input->post( 'manager_email' ),
                    'status' => 'ACTIVE'
                ]
            );
    
            if( $is_exists )
            {
                echo json_encode(array("error"=>1, 'msg' => 'Manager With Given Email Already Exists, Please Try Another One'));
                return;
            }
        }

        $data['name']=$this->input->post('manager_name');
        $data['email']=$this->input->post('manager_email');
        $data['mobile']=$this->input->post('manager_mobile');
        $data['city']=$this->input->post('manager_city');

        if( $this->input->post( 'manager_pass_word' ) )
        {
            $data['pass_word'] = md5( $this->input->post('manager_pass_word') );
        }

        if ( $this->Managers_model->update_single_manager( $data, $id ) )
        {
            echo json_encode(array("error"=>0));
        } 
        else 
        {
            echo json_encode(array("error"=>1, 'msg' => 'Unknow Error'));
        }
    }

    public function delete_manager( $id )
    {
        if( $_SERVER[ 'REQUEST_METHOD' ] != 'POST' )
        {
            show_error( 'Action You Are Trying Is Prohibited' );
        }

        if ( $this->Managers_model->update_single_manager( [ 'status' => 'INACTIVE' ] , intval( $id ) ) )
        {
            echo json_encode(array("error"=>0));
        } 
        else 
        {
            echo json_encode(array("error"=>1));
        }
    }

}

/* End of file Managers.php */
