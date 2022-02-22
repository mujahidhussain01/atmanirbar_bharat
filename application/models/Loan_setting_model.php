<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Loan_setting_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table="loan_setting";
		$this->primary_key ="lsid";
	}
	public function set_loan($data)
	{
		$this->db->insert('loan_setting',$data);
		return $this->db->insert_id();	  		
	}
	public function get_loan_settings()
	{
		$this->db->select('*');
		$this->db->from('loan_setting');
		$this->db->where( 'loan_type', 'NORMAL' );
		$query = $this->db->get();
		return $query->result_array();
	}
	public function get_group_loan_settings()
	{
		$this->db->select('*');
		$this->db->from('loan_setting');
		$this->db->where( 'loan_type', 'GROUP' );
		$query = $this->db->get();
		return $query->result_array();
	}
	public function get_group_loan_settings_for_manager( $search = false )
	{
		$this->db->select('*');
		$this->db->from('loan_setting');
		$this->db->where( 'loan_type', 'GROUP' );
		$this->db->where( 'ls_status', 'ACTIVE' );
		$this->db->order_by( 'ls_doc', 'DESC' );
		if( $search ) $this->db->where( "loan_name like '%$search%' " );
		$query = $this->db->get();
		return $query->result_array();
	}
	public function get_single_group_loan_setting_for_manager( $id )
	{
		$this->db->select('*');
		$this->db->from('loan_setting');
		$this->db->where( 'loan_type', 'GROUP' );
		$this->db->where( 'ls_status', 'ACTIVE' );
		$this->db->where( $this->primary_key, $id )->limit( 1 );
		$query = $this->db->get();
		return $query->row_array();
	}
	public function get_loan_settings_for_app()
	{
		$this->db->select('lsid as loan_id,loan_name,loan_duration,amount,rate_of_interest,process_fee_percent,processing_fee,payment_mode,emi_amount,bouncing_charges_percent,bouncing_charges');
		$this->db->where( 'loan_type', 'NORMAL' );
		$this->db->where( 'ls_status', 'ACTIVE' );
		$this->db->from('loan_setting');
		$this->db->where('ls_status','Active');
		$query = $this->db->get();
		return $query->result_array();
	}
	public function update($data,$id)
	{
		return $this->db->where('lsid', $id)->update($this->table,$data);
    }
	
    public function getloan_setting($lsid , $type = false )
    {
    	$this->db->select('*');
		$this->db->from('loan_setting');
		$this->db->where('lsid',$lsid);
		if( $type )
		{
			$this->db->where( 'loan_type', $type );
		}
		$query = $this->db->get();
		return $query->row_array();
    }
}