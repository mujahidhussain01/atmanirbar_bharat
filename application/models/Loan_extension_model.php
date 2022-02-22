<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loan_extension_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table="loan_extension";
	}
	
	public function insert($data)
	{
		$this->db->insert('loan_extension',$data);
		return $this->db->insert_id();	  		
	}
	
	public function update($le_id,$data)
	{
		$this->db->where('le_id',$le_id);
		return $this->db->update('loan_extension',$data);
	}
    public function getloanextentiondetail($loan_id)
    {
    	$this->db->select('le_id,extention_status,reject_comment,le_doc');
		$this->db->from('loan_extension le');
		$this->db->where('le.la_id',$loan_id);
		$query = $this->db->get();
		return $query->row_array();
    }
    public function getAllloanextentiondetail($loan_id)
    {
    	$this->db->select('*');
		$this->db->from('loan_extension le');
		$this->db->where('le.la_id',$loan_id);
		$query = $this->db->get();
		return $query->result_array();
    }
    public function getloanextentiondetailbyleid($le_id)
    {
    	$this->db->select('*');
		$this->db->from('loan_extension le');
		$this->db->where('le.le_id',$le_id);
		$query = $this->db->get();
		return $query->row_array();

    }
    public function getAllloanextentiondetailbyuserid($userid,$loan_id)
    {
    	$this->db->select('le.*');
		$this->db->from('loan_extension le');
		$this->db->where('le.la_id',$loan_id);
		$query = $this->db->get();
		return $query->result_array();
    }
    public function getloanextentiondetailbyuserid($userid,$loan_id)
    {
    	$this->db->select('le.*');
		$this->db->from('loan_extension le');
		$this->db->where('le.la_id',$loan_id);
		$query = $this->db->get();
		return $query->row_array();
    }
    public function get_extentions_by_status($status){
		$this->db->select('le.*,la.la_id,la.amount,u.first_name,u.last_name,u.mobile');
		$this->db->from('loan_extension le');
		$this->db->join('loan_apply la','le.la_id=la.la_id');
// 		$this->db->join('loan_setting ls','ls.lsid=la.loan_id');
		$this->db->join('user u','u.userid=le.user_id');
        $this->db->where('le.extention_status',$status);
        $this->db->order_by('le.le_id','desc');
        $query = $this->db->get();
        return $query->result_array();
	}
    public function get_extentions_by_status_count($status){
		$this->db->select('*');
		$this->db->from('loan_extension le');
		$this->db->join('loan_apply la','le.la_id=la.la_id');
// 		$this->db->join('loan_setting ls','ls.lsid=la.loan_id');
		$this->db->join('user u','u.userid=le.user_id');
        $this->db->where('le.extention_status',$status);
        $query = $this->db->get();
        return $query->num_rows();
	}

}