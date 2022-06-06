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
    	$this->db->select('le_id,extension_status,reject_comment,le_doc');
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
		$this->db->select('
la.la_id,
la.loan_type,
la.amount,
la.initial_amount,
la.rate_of_interest,
la.processing_fee,
la.deduct_lic_amount,
la.loan_closer_amount,
la.loan_duration,
la.payment_mode,
la.emi_amount,
la.payable_amt,
la.loan_status,
la.remaining_balance,
ma.name as manager_name,
u.first_name,
u.last_name,
u.email,
u.mobile,
u.city,
le.*,

		');
		$this->db->from('loan_extension le');
		$this->db->join('loan_apply la','le.la_id=la.la_id');
		$this->db->join('managers ma','ma.id = la.manager_id', 'left');
		$this->db->join('user u','u.userid=le.user_id');
        $this->db->where('le.extension_status',$status);
        $this->db->order_by('le.le_id','desc');
        $query = $this->db->get();
        return $query->result_array();
	}

	public function get_pending_extension_by_loan_id( $loan_id )
	{
		$this->db->select( '*' )
		->from( $this->table )
		->where( 'extension_status', 'PENDING' )
		->where( 'la_id', intval( $loan_id ) )
		->limit( 1 );

		$query = $this->db->get();
		return $query->row_array();
	}

    public function get_extentions_by_status_count($status){
		$this->db->select('*');
		$this->db->from('loan_extension le');
		$this->db->join('loan_apply la','le.la_id=la.la_id');
// 		$this->db->join('loan_setting ls','ls.lsid=la.loan_id');
		$this->db->join('user u','u.userid=le.user_id');
        $this->db->where('le.extension_status',$status);
        $query = $this->db->get();
        return $query->num_rows();
	}

	public function get_single_extension_by_loan_id( $loan_id )
	{
		$this->db->select('*');
		$this->db->from('loan_extension');
		$this->db->where('la_id',$loan_id);
		$this->db->order_by( 'le_doc', 'DESC' );
		$this->db->limit( 1 );

		$query = $this->db->get();
		return $query->row_array();
	}

	public function get_all_extensions_by_loan_id( $loan_id )
	{
		$this->db->select('*');
		$this->db->from('loan_extension');
		$this->db->where('la_id',$loan_id);
		$this->db->order_by( 'le_doc', 'DESC' );

		$query = $this->db->get();
		return $query->row_array();
	}

}