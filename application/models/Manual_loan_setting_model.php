<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Manual_loan_setting_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table="manual_loan_setting";
		$this->primary_key ="id";
	}

	public function get_manual_loan_setting()
	{
		$this->db->select( '*' );
		$this->db->from( 'manual_loan_setting' );
		$this->db->limit( 1 );
		$query = $this->db->get();
		return $query->row_array();
	}

	public function update($data,$id)
	{
		return $this->db->where( 'id', $id )->limit( 1 )->update( $this->table, $data );
    }

}