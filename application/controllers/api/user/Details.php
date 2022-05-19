<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');
require (APPPATH . '/libraries/REST_Controller.php');
class Details extends REST_Controller
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('User_model');
		$this->load->model('User_app_contacts_model');
		$this->load->library('upload');
		$this->load->library('session');
	}
	
	public function adhar_card_front_upload_post() 
	{
		if (!$this->input->post('token') || !isset($_POST['token']) || empty($_FILES['adhar_card_front']['name']) || !isset($_FILES['adhar_card_front']['name'])) 
		{
		    
    		    $message = [];
    		 if(!$this->input->post('token') || !isset($_POST['token']))
			 {array_push($message,'token');}   
    		 if(empty($_FILES['adhar_card_front']['name']) || !isset($_FILES['adhar_card_front']))
			 {array_push($message,'adhar_card_front');} 
			$this->response(['status' => 201, 'error' => true, 'message' => "Required parameter is not set i.e:".implode(',',$message)]);
		}
		else 
		{
			$token = $this->input->post('token');
			$userdata = $this->User_model->GetUserByToken($token);
			if (!empty($userdata)) 
			{
				// Adhar card front
				$ext = pathinfo($_FILES['adhar_card_front']['name'], PATHINFO_EXTENSION);
				$filename = 'aadhar_card_front_image_'.rand('111111', '999999') . '_' . time() . '.' . $ext;
				$config = array(
					'file_name' => $filename,
					'upload_path' => "./uploads/adhar_card/front/",
					'allowed_types' => "gif|jpg|png|jpeg|svg",
					'overwrite' => TRUE
				);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('adhar_card_front'))
				{
				    if($userdata->adhar_card_front != NULL)
					{
					    if (file_exists('uploads/adhar_card/front/' . $userdata->adhar_card_front))
						{
						unlink('uploads/adhar_card/front/' . $userdata->adhar_card_front);
					}
				    }
					$data['adhar_card_front'] = $filename;
    				if ($this->User_model->updateUserDataByToken($token,$data)) 
					{
    				    
    					$userdata = $this->User_model->GetUserByToken($token);
    					if($userdata->adhar_card_front != NULL && $userdata->adhar_card_back != NULL)
						{
    					    $upload_data['aadhar_upload_status'] = 'PENDING';
    					    $upload_data['docv_status'] = 'PENDING';
    					    $upload_data['docv_status_comment'] = 'Aadhar Documents are updated by user successfully';
        					$upload_data['default_message'] = NULL;
        					$upload_data['default_title'] = 'Your Aadhar Documents is submitted successfully';
    					    $this->User_model->updateUserDataByToken($token,$upload_data);
    					}
    					$userdata = $this->User_model->GetUserByToken($token);
    					$error = false;
    					$message = "Aadhar card front document is successfully saved";
    					$this->response(['status' => 200, 'error' => false, 'message' => $message, "img_url" => base_url('uploads/adhar_card/front/') . $userdata->adhar_card_front]);
    				}
    				else 
					{
    					$error = true;
    					$message = "An error occured while updating data";
    					$this->response(['status' => 201, 'error' => true, 'message' => $message]);
    				}
				}
				else 
				{
					$this->response(['status' => 201, 'error' => true, 'message' => $this->upload->display_errors() ]);
				}
				
			}
			else 
			{
				$error = true;
				$message = "Invalid User";
				$this->response(['status' => 201, 'error' => true, 'message' => $message]);
			}
		}
	}

	public function adhar_card_back_upload_post() 
	{
		
		if (!$this->input->post('token') || !isset($_POST['token']) || empty($_FILES['adhar_card_back']['name']) || !isset($_FILES['adhar_card_back']['name'])) 
		{
		    
    		    $message = [];
    		 if(!$this->input->post('token') || !isset($_POST['token']))
			 {array_push($message,'token');}   
    		 if(empty($_FILES['adhar_card_back']['name']) || !isset($_FILES['adhar_card_back']))
			 {array_push($message,'adhar_card_back');} 
			$this->response(['status' => 201, 'error' => true, 'message' => "Required parameter is not set i.e:".implode(',',$message)]);
		}
		else 
		{
			$token = $this->input->post('token');
			$userdata = $this->User_model->GetUserByToken($token);
			if (!empty($userdata)) 
			{
				// Adhar card front
				$ext = pathinfo($_FILES['adhar_card_back']['name'], PATHINFO_EXTENSION);
				$filename = 'aadhar_card_back_image_'.rand('111111', '999999') . '_' . time() . '.' . $ext;
				$config = array(
					'file_name' => $filename,
					'upload_path' => "./uploads/adhar_card/back/",
					'allowed_types' => "gif|jpg|png|jpeg|svg",
					'overwrite' => TRUE
				);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('adhar_card_back'))
				{
				    if($userdata->adhar_card_back !=NULL)
					{
					    if (file_exists('uploads/adhar_card/back/'.$userdata->adhar_card_back) )
						{
						unlink('uploads/adhar_card/back/'.$userdata->adhar_card_back);
					}
				    }
					$data['adhar_card_back'] = $filename;
    				if ($this->User_model->updateUserDataByToken($token,$data)) 
					{
    					$userdata = $this->User_model->GetUserByToken($token);
    					if($userdata->adhar_card_front != NULL && $userdata->adhar_card_back != NULL)
						{
    					    $upload_data['aadhar_upload_status'] = 'PENDING';
    					    $upload_data['docv_status'] = 'PENDING';
    					    $upload_data['docv_status_comment'] = 'Aadhar Documents are updated by user successfully';
        					$upload_data['default_message'] = NULL;
        					$upload_data['default_title'] = 'Your Aadhar Documents is submitted successfully';
    					    $this->User_model->updateUserDataByToken($token,$upload_data);
    					}
    					$userdata = $this->User_model->GetUserByToken($token);
    					$error = false;
    					$message = "Aadhar card back document is successfully saved";
    					$this->response(['status' => 200, 'error' => false, 'message' => $message, "img_url" => base_url('uploads/adhar_card/back/') . $userdata->adhar_card_back]);
    				}
    				else 
					{
    					$error = true;
    					$message = "An error occured while updating data";
    					$this->response(['status' => 201, 'error' => true, 'message' => $message]);
    				}
				}
				else 
				{
					$this->response(['status' => 201, 'error' => true, 'message' => $this->upload->display_errors() ]);
				}
				
			}
			else 
			{
				$error = true;
				$message = "Invalid User";
				$this->response(['status' => 201, 'error' => true, 'message' => $message]);
			}
		}
	}

	public function pan_card_image_upload_post() 
	{
		
		if (!$this->input->post('token') || !isset($_POST['token']) || empty($_FILES['pan_card_image']['name']) || !isset($_FILES['pan_card_image']['name'])) 
		{
		    
    		    $message = [];
    		 if(!$this->input->post('token') || !isset($_POST['token']))
			 {array_push($message,'token');}   
    		 if(empty($_FILES['pan_card_image']['name']) || !isset($_FILES['pan_card_image']))
			 {array_push($message,'pan_card_image');} 
			$this->response(['status' => 201, 'error' => true, 'message' => "Required parameter is not set i.e:".implode(',',$message)]);
		}
		else 
		{
			$token = $this->input->post('token');
			$userdata = $this->User_model->GetUserByToken($token);
			if (!empty($userdata)) 
			{
				// Adhar card front
				$ext = pathinfo($_FILES['pan_card_image']['name'], PATHINFO_EXTENSION);
				$filename = 'pan_card_image_'.rand('111111', '999999') . '_' . time() . '.' . $ext;
				$config = array(
					'file_name' => $filename,
					'upload_path' => "./uploads/pan_card_image/",
					'allowed_types' => "gif|jpg|png|jpeg|svg",
					'overwrite' => TRUE
				);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('pan_card_image'))
				{
				    if($userdata->pan_card_image != NULL)
					{
					    if (file_exists('uploads/pan_card_image/'.$userdata->pan_card_image) )
						{
						unlink('uploads/pan_card_image/'.$userdata->pan_card_image);
					}
				    }
					$data['pan_card_image'] = $filename;
					$data['pan_card_approved_status'] = 'PENDING';
					$data['pan_card_approved_status_comment'] = 'Waiting For Admin To Approve Pan Card Image';

    				if ($this->User_model->updateUserDataByToken($token,$data)) 
					{
    					$userdata = $this->User_model->GetUserByToken($token);
    					$error = false;
    					$message = "Pan Card document is successfully saved";
    					$this->response(['status' => 200, 'error' => false, 'message' => $message, "img_url" => base_url('uploads/pan_card_image/') . $userdata->pan_card_image]);
    				}
    				else 
					{
    					$error = true;
    					$message = "An error occured while updating data";
    					$this->response(['status' => 201, 'error' => true, 'message' => $message]);
    				}
				}
				else 
				{
					$this->response(['status' => 201, 'error' => true, 'message' => $this->upload->display_errors() ]);
				}
				
			}
			else 
			{
				$error = true;
				$message = "Invalid User";
				$this->response(['status' => 201, 'error' => true, 'message' => $message]);
			}
		}
	}

	public function passbook_image_upload_post() 
	{
		
		if (!$this->input->post('token') || !isset($_POST['token']) || empty($_FILES['passbook_image']['name']) || !isset($_FILES['passbook_image']['name'])) 
		{
		    
    		    $message = [];
    		 if(!$this->input->post('token') || !isset($_POST['token']))
			 {array_push($message,'token');}   
    		 if(empty($_FILES['passbook_image']['name']) || !isset($_FILES['passbook_image']))
			 {array_push($message,'passbook_image');} 
			$this->response(['status' => 201, 'error' => true, 'message' => "Required parameter is not set i.e:".implode(',',$message)]);
		}
		else 
		{
			$token = $this->input->post('token');
			$userdata = $this->User_model->GetUserByToken($token);
			if (!empty($userdata)) 
			{
				// Adhar card front
				$ext = pathinfo($_FILES['passbook_image']['name'], PATHINFO_EXTENSION);
				$filename = 'passbook_image_'.rand('111111', '999999') . '_' . time() . '.' . $ext;
				$config = array(
					'file_name' => $filename,
					'upload_path' => "./uploads/passbook_image/",
					'allowed_types' => "gif|jpg|png|jpeg|svg",
					'overwrite' => TRUE
				);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('passbook_image'))
				{
				    if($userdata->passbook_image != NULL)
					{
					    if (file_exists('uploads/passbook_image/'.$userdata->passbook_image) )
						{
						unlink('uploads/passbook_image/'.$userdata->passbook_image);
					}
				    }
					$data['passbook_image'] = $filename;
					$data['passbook_approved_status'] = 'PENDING';
					$data['passbook_approved_status_comment'] = 'Waiting For Admin To Approve Passbook Image';
    				if ($this->User_model->updateUserDataByToken($token,$data)) 
					{
    					$userdata = $this->User_model->GetUserByToken($token);
    					$error = false;
    					$message = "Passbook document is successfully saved";
    					$this->response(['status' => 200, 'error' => false, 'message' => $message, "img_url" => base_url('uploads/passbook_image/') . $userdata->passbook_image]);
    				}
    				else 
					{
    					$error = true;
    					$message = "An error occured while updating data";
    					$this->response(['status' => 201, 'error' => true, 'message' => $message]);
    				}
				}
				else 
				{
					$this->response(['status' => 201, 'error' => true, 'message' => $this->upload->display_errors() ]);
				}
				
			}
			else 
			{
				$error = true;
				$message = "Invalid User";
				$this->response(['status' => 201, 'error' => true, 'message' => $message]);
			}
		}
	}

	public function profile_image_upload_post() 
	{
		
		if (!$this->input->post('token') || !isset($_POST['token']) || empty($_FILES['profile_image']['name']) || !isset($_FILES['profile_image']['name'])) 
		{
		    
    		    $message = [];
    		 if(!$this->input->post('token') || !isset($_POST['token']))
			 {array_push($message,'token');}   
    		 if(empty($_FILES['profile_image']['name']) || !isset($_FILES['profile_image']))
			 {array_push($message,'profile_image');} 
			$this->response(['status' => 201, 'error' => true, 'message' => "Required parameter is not set i.e:".implode(',',$message)]);
		}
		else 
		{
			$token = $this->input->post('token');
			$userdata = $this->User_model->GetUserByToken($token);
			if (!empty($userdata)) 
			{
				//Selfie
				$ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
				$filename = 'profile_image_'.rand('111111', '999999') . '_' . time() . '.' . $ext;
				$config = array(
					'file_name' => $filename,
					'upload_path' => "./uploads/profile_image",
					'allowed_types' => "gif|jpg|png|jpeg|svg",
					'overwrite' => TRUE
				);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('profile_image')) 
				{
				    if( $userdata->profile_image !=NULL)
					{
					    if (file_exists('uploads/profile_image/' . $userdata->profile_image)) 
						{
						unlink('uploads/profile_image/' . $userdata->profile_image);
					}
				    }
					$data['profile_image'] = $filename;
					$data['sa_status'] = 'PENDING';
    				$data['sa_status_comment'] = 'Profile Image is updated by user successfully';
        			$data['default_message'] = NULL;
        			$data['default_title'] = 'Your Profile Image is submitted successfully';
    				if ($this->User_model->updateUserDataByToken($token,$data)) 
					{
    					$userdata = $this->User_model->GetUserByToken($token);
    					$error = false;
    					$message = "Your Profile image is successfully saved";
    					$this->response(['status' => 200, 'error' => false, 'message' => $message, "img_url" => base_url('uploads/profile_image/') . $userdata->profile_image]);
    				}
    				else 
					{
    					$error = true;
    					$message = "An error occured while updating data";
    					$this->response(['status' => 201, 'error' => true, 'message' => $message]);
    				}
				}
				else 
				{
					$this->response(['status' => 201, 'error' => true, 'message' => $this->upload->display_errors() ]);
				}
			}
			else 
			{
				$error = true;
				$message = "Invalid Token";
				$this->response(['status' => 201, 'error' => true, 'message' => $message]);
			}
		}
	}

	public function check_image_upload_post() 
	{
		
		if (!$this->input->post('token') || !isset($_POST['token']) || empty($_FILES['check_image']['name']) || !isset($_FILES['check_image']['name'])) 
		{
		    
    		    $message = [];
    		 if(!$this->input->post('token') || !isset($_POST['token']))
			 {array_push($message,'token');}   
    		 if(empty($_FILES['check_image']['name']) || !isset($_FILES['check_image']))
			 {array_push($message,'check_image');} 
			$this->response(['status' => 201, 'error' => true, 'message' => "Required parameter is not set i.e:".implode(',',$message)]);
		}
		else 
		{
			$token = $this->input->post('token');
			$userdata = $this->User_model->GetUserByToken($token);
			if (!empty($userdata)) 
			{
				//Selfie
				$ext = pathinfo($_FILES['check_image']['name'], PATHINFO_EXTENSION);
				$filename = 'check_image_'.rand('111111', '999999') . '_' . time() . '.' . $ext;
				$config = array(
					'file_name' => $filename,
					'upload_path' => "./uploads/check_image",
					'allowed_types' => "gif|jpg|png|jpeg|svg",
					'overwrite' => TRUE
				);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('check_image')) 
				{
					if ($userdata->check_image != NULL) 
					{
					    if (file_exists('uploads/check_image/' . $userdata->check_image)) 
						{
						unlink('uploads/check_image/' . $userdata->check_image);
					    }
					}
					$data['check_image'] = $filename;
    				if ($this->User_model->updateUserDataByToken($token,$data)) 
					{
    					$userdata = $this->User_model->GetUserByToken($token);

    					$error = false;
    					$message = "Bank Detail image is successfully saved";
    					$this->response(['status' => 200, 'error' => false, 'message' => $message, "img_url" => base_url('uploads/check_image/') . $userdata->check_image]);
    				}
    				else 
					{
    					$error = true;
    					$message = "An error occured while updating data";
    					$this->response(['status' => 201, 'error' => true, 'message' => $message]);
    				}
				}
				else 
				{
					$this->response(['status' => 201, 'error' => true, 'message' => $this->upload->display_errors() ]);
				}
			}
			else 
			{
				$error = true;
				$message = "Invalid Token";
				$this->response(['status' => 201, 'error' => true, 'message' => $message]);
			}
		}
	}

	public function pay_slip_image_upload_post() 
	{
		
		if (!$this->input->post('token') || !isset($_POST['token']) || empty($_FILES['pay_slip_image']['name']) || !isset($_FILES['pay_slip_image']['name'])) 
		{
		    
    		    $message = [];
    		 if(!$this->input->post('token') || !isset($_POST['token']))
			 {array_push($message,'token');}   
    		 if(empty($_FILES['pay_slip_image']['name']) || !isset($_FILES['pay_slip_image']))
			 {array_push($message,'pay_slip_image');} 
			$this->response(['status' => 201, 'error' => true, 'message' => "Required parameter is not set i.e:".implode(',',$message)]);
		}
		else 
		{
			$token = $this->input->post('token');
			$userdata = $this->User_model->GetUserByToken($token);
			if (!empty($userdata)) 
			{
				//Selfie
				$ext = pathinfo($_FILES['pay_slip_image']['name'], PATHINFO_EXTENSION);
				$filename = 'pay_slip_image_'.rand('111111', '999999') . '_' . time() . '.' . $ext;
				$config = array(
					'file_name' => $filename,
					'upload_path' => "./uploads/pay_slip_image",
					'allowed_types' => "gif|jpg|png|jpeg|svg|pdf",
					'overwrite' => TRUE
				);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('pay_slip_image')) 
				{
					if ($userdata->pay_slip_image != NULL) 
					{
					    if (file_exists('uploads/pay_slip_image/' . $userdata->pay_slip_image)) 
						{
						unlink('uploads/pay_slip_image/' . $userdata->pay_slip_image);
					    }
					}
					$data['pay_slip_image'] = $filename;
					$data['pa_status'] = 'APPROVED';
    				$data['pa_status_comment'] = 'Payslip Documents are updated by user successfully';
        			$data['default_message'] = NULL;
        			$data['default_title'] = 'Your Payslip Documents is submitted successfully';
    				if ($this->User_model->updateUserDataByToken($token,$data)) 
					{
    					$userdata = $this->User_model->GetUserByToken($token);
    					$error = false;
    					$message = "Pay slip document is successfully saved";
    					$this->response(['status' => 200, 'error' => false, 'message' => $message, "img_url" => base_url('uploads/pay_slip_image/') . $userdata->pay_slip_image]);
    				}
    				else 
					{
    					$error = true;
    					$message = "An error occured while updating data";
    					$this->response(['status' => 201, 'error' => true, 'message' => $message]);
    				}
				}
				else 
				{
					$this->response(['status' => 201, 'error' => true, 'message' => strip_tags($this->upload->display_errors()) ]);
				}
			}
			else 
			{
				$error = true;
				$message = "Invalid Token";
				$this->response(['status' => 201, 'error' => true, 'message' => $message]);
			}
		}
	}

	public function profile_edit_post()
	{
        if(!$this->input->post('token'))
		{
                $this->response(['status' => 201, 'error' =>true, 'message' => 'Required parameter is not set']);
        }else
		{
		$userdata = $this->User_model->GetUserByToken($_POST['token']);
		if (!empty($userdata)) 
		{
			$data=$this->input->post();
			$data['bda_status']='PENDING';
    		$data['bda_status_comment'] = 'Basic Documents are updated by user successfully';
            $sql = $this->db->where('token', $_POST['token'])->update('user',$data);
    		$userdata = $this->User_model->GetUserByToken($_POST['token']);
            $this->response(['status' => 200, 'error' =>false, 'message'=>'User Updated Successfully' , 'data'=>$userdata ]);
		}else 
		{
			$error = true;
			$message = "Invalid User Token";
			$this->response(['status' => 201, 'error' => true, 'message' => $message]);
		}
                
                
       
       }
    }

	public function get_profile_details_get()
	{
        if(!$this->input->get('token'))
		{
                $this->response(['status' => 201, 'error' =>true, 'message' => 'Required parameter is not set']);
       }
       else
	   {
		$userdata = $this->User_model->GetUserByTokenForApp($_GET['token']);
		if (!empty($userdata)) 
		{
		    $userdata->avatar_img = base_url('assets/img/user-avatar.png'); 
            $this->response(['status' => 200, 'error' =>false, 'data'=>$userdata ]);
		}
		else 
		{
			$error = true;
			$message = "Invalid User Token";
			$this->response(['status' => 201, 'error' => true, 'message' => $message]);
		}
                
                
       
       }
    }

	public function save_contact_post()
	{
        if(!$this->input->post('token') OR !$this->input->post('contact'))
		{
                $this->response(['status' => 201, 'error' =>true, 'message' => 'Required parameter is not set']);
       }
       else
	   {
		$userdata = $this->User_model->GetUserByToken($_POST['token']);
		if (!empty($userdata)) 
		{
		    $sql = true;
            foreach(json_decode($_POST['contact']) as $key => $value)
			{
                // print_r($key);
                $data['mobileNumber'] = $key;
                $data['name'] = $value;
                $data['user_id'] = $userdata->userid;
                $check = $this->User_app_contacts_model->getAllContactsByUsermobileanduser($userdata->userid,$data['mobileNumber']);
                if(empty($check))
				{
                    $sql = $this->db->insert('user_app_contacts',$data);
                }
            }
            if(@$sql)
			{
                $this->response(['status' => 200, 'error' =>false, 'message'=>'Contacts saved Successfully' ]);
            }
            else
			{
                $this->response(['status' => 200, 'error' =>true, 'message'=>'These contacts already saved' ]);
            }
		}
		else 
		{
			$error = true;
			$message = "Invalid User Token";
			$this->response(['status' => 201, 'error' => true, 'message' => $message]);
		}
       }
    }
}
ob_flush();
?>
