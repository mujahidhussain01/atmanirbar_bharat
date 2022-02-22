<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adminlogin extends CI_Model
{
	public function login_check($data)
	{
		  $query = $this->db->get_where("admin",array("Email"=>$data['email'],"Password"=>$data['password']));
		  if($query->result())
		  {
		  	return true;
		  }
		  else
		  {
		  	return false;
		  }
	}
	public function get_admin()
	{
		  $this->db->select('*');
		$this->db->from('admin');
		$query = $this->db->get();
		return $query->row_array();
	}
	public function update($id,$data)
	{
		 return $this->db->where('id',$id)->update('admin',$data);
	}
	
	public function checkemail($email)
	{
	    $this->db->select('*');
		$this->db->from('admin');
		$this->db->where('Email',$email);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	public function update_password($mobile,$data)
	{
	    return $this->db->where('mobile',$mobile)->update('admin',$data);
	}
}