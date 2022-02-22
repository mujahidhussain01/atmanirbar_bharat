<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_app_contacts_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table="user_app_contacts";
	}
	
    public function getAllContactsByUser($user_id)
    {
    	$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('user_id',$user_id);
		$query = $this->db->get();
		return $query->result_array();
    }
    public function getAllContactsByUsermobileanduser($userid,$mobileNumber)
    {
    	$this->db->select('*');
		$this->db->from($this->table);
// 		$this->db->where('user_id',$userid);
		$this->db->where('mobileNumber',$mobileNumber);
		$query = $this->db->get();
		return $query->row_array();
    }

}