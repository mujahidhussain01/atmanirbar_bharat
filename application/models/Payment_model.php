<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table="loan_payment";
	}
	
	public function insert($data)
	{
		$this->db->insert('loan_payment',$data);
		return $this->db->insert_id();	  		
	}
	public function update($lp_id,$data)
	{
		$this->db->where('lp_id',$lp_id);
		return $this->db->update('loan_payment',$data);
	}
    public function get_all_loan_payment_by_userid($user_id)
    {
    	$this->db->select('*');
		$this->db->from($this->table.' lp');
		$this->db->join('loan_apply la','la.la_id = lp.la_id');
		$this->db->where('lp.user_id',$user_id);
		$this->db->order_by('lp.lp_doc','desc');
		$query = $this->db->get();
		return $query->result_array();
    }
    public function get_loan_payment_by_lpid($lp_id)
    {
    	$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('lp_id',$lp_id);
		$query = $this->db->get();
		return $query->row_array();
    }
    public function filter_get_loan_payment($data)
    {
    	$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($data);
		$query = $this->db->get();
		return $query->row_array();
    }
    
    public function get_payment_by_status($status){
		$this->db->select('*');
		$this->db->from('loan_payment lp');
		$this->db->join('loan_apply la','lp.la_id=la.la_id');
		$this->db->join('loan_setting ls','ls.lsid=la.loan_id');
		$this->db->join('user u','u.userid=lp.user_id');
        $this->db->where('lp.payment_status',$status);
        $this->db->order_by('lp.lp_doc','desc');
        $query = $this->db->get();
        return $query->result_array();
	}
    public function get_payment_by_status_count($status){
		$this->db->select('*');
		$this->db->from('loan_payment lp');
		$this->db->join('loan_apply la','lp.la_id=la.la_id');
		$this->db->join('loan_setting ls','ls.lsid=la.loan_id');
		$this->db->join('user u','u.userid=lp.user_id');
        $this->db->where('lp.payment_status',$status);
        $query = $this->db->get();
        return $query->num_rows();
	}

}