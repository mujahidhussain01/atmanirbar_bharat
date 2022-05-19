<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Loan_apply_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table="loan_apply";
	}
	public function insert($data)
	{
		$this->db->insert('loan_apply',$data);
		return $this->db->insert_id();	  		
	}
	public function update($la_id,$data)
	{
		$this->db->where('la_id',$la_id);
		return $this->db->update('loan_apply',$data);
	}
	public function getloandetail($la_id)
	{
		$this->db->select("
		la.*,
		ma.name as manager_name");
		$this->db->from('loan_apply la');

		$this->db->join('managers ma','ma.id = la.manager_id', 'left');
		$this->db->join('user u','u.userid=la.user_id');
		
		$this->db->where('la.la_id',$la_id);
		$query = $this->db->get();
		return $query->row_array();
	}



	//  -------------------------



	
	public function getloandetail2( $la_id, $where = false )
	{
		$this->db->select("
		u.*,
		la.*,
		ma.name as manager_name");
		$this->db->from('loan_apply la');

		$this->db->join('user u','u.userid=la.user_id');
		$this->db->join('managers ma','ma.id = la.manager_id', 'left');

		$this->db->where('la.la_id',$la_id);
		if( $where )
		{
			$this->db->where( $where );
		}
		$query = $this->db->get();
		return $query->row_array();
	}

	public function getloandetail3( $where )
	{
		$this->db->select("
		u.first_name,
		u.last_name,
		u.mobile,
		u.email,
		u.city,
		u.bda_status,
		u.adhar_card_front,
		u.adhar_card_back,
		u.pan_card_image,
		u.passbook_image,
		u.bda_status,
		u.docv_status,
		u.pan_card_approved_status,
		u.passbook_approved_status,
		la.*,
		ma.name as manager_name");

		$this->db->from('loan_apply la');

		$this->db->join('managers ma','ma.id = la.manager_id', 'left');
		$this->db->join('user u','u.userid=la.user_id' );

		$this->db->where( $where );
		$this->db->order_by( 'la.loan_status' );
		$this->db->order_by( 'la.la_doc', 'DESC' );

		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_loans_list_by_manager_id( $manager_id , $status = false )
	{
		$this->db->select("
		u.*,
		la.*,
		ma.name as manager_name");
		$this->db->from('loan_apply la');

		$this->db->join('managers ma','ma.id = la.manager_id', 'left');
		$this->db->join('user u','u.userid=la.user_id');

		// $this->db->where( 'manager_id', $manager_id );
		if( $status )
		{
			$this->db->where_in( 'loan_status', $status );
		}
		$this->db->order_by('la.loan_start_date','desc');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_loans_count_by_manager_id( $manager_id, $status = false )
	{
		$this->db->select('*');
		$this->db->from('loan_apply la');
// 		$this->db->join('loan_setting ls','la.loan_id=ls.lsid');
		$this->db->join('user u','u.userid=la.user_id');
		// $this->db->where( 'manager_id', $manager_id );
		if( $status )
		{
			$this->db->where_in( 'loan_status', $status );
		}
		return $this->db->count_all_results();
	}

	public function check_loan_taken_by_user( $user_id, $cur_loan )
	{
		$this->db->select('*');
		$this->db->from('loan_apply la');
		$this->db->join('user u','u.userid=la.user_id');
		$this->db->where( 'user_id', $user_id );
		$this->db->where( 'la_id !=', $cur_loan );
		return $this->db->count_all_results();
	}

	public function check_loan_taken_by_user_mobile( $mobile )
	{
		$this->db->select('*');
		$this->db->from('loan_apply la');
		$this->db->join('user u','u.userid=la.user_id');
		$this->db->where( 'mobile', $mobile );
		$this->db->where_in( 'loan_status', [ 'PENDING', 'APPROVED', 'RUNNING' ] );
		return $this->db->count_all_results();
	}

	//  -------------------------



	public function getuserlastPaidloandetail($user_id)
	{
		$this->db->select('*');
		$this->db->from('loan_apply la');
		$this->db->where('la.user_id',$user_id);
		$this->db->where('la.loan_status','PAID');
		$this->db->order_by('la.la_id','desc');
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row_array();
	}
	public function getuserlastloandetail($user_id)
	{
		$this->db->select('*');
		$this->db->from('loan_apply la');
		$this->db->where('la.user_id',$user_id);
// 		$this->db->where('la.loan_status','PAID');
		$this->db->order_by('la.la_id','desc');
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row_array();
	}
	public function getuserallloanlist($user_id)
	{
		$this->db->select("
		la.*,
		ma.name as manager_name");
		$this->db->from('loan_apply la');

		$this->db->join('managers ma','ma.id = la.manager_id', 'left');

		$this->db->where('la.user_id',$user_id);
		$this->db->order_by('la.la_doc','desc');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_user_loan_by_loan_id( $user_id, $la_id )
	{
		$this->db->select('*');
		$this->db->from('loan_apply la');
		$this->db->where('la.user_id',$user_id);
		$this->db->where('la.la_id',$la_id);

		$query = $this->db->get();
		return $query->row_array();
	}
	public function getusercurrentloan($user_id)
	{
		$this->db->select('*');
		$this->db->from('loan_apply la');
// 		$this->db->join('loan_setting ls','la.loan_id=ls.lsid');
		$this->db->where('la.user_id = '.$user_id.' AND (la.loan_status != "COMPLETE")');
// 		$this->db->where('la.loan_status','PENDING');
// 		$this->db->or_where('la.loan_status','APPROVED');
		$query = $this->db->get();
		return $query->row_array();
	}
	public function GetCurrentAppliedLoan($user_id)
	{
		$this->db->select('*');
		$this->db->from('loan_apply la');
// 		$this->db->join('loan_setting ls','la.loan_id=ls.lsid');
		$this->db->where('la.user_id',$user_id);
		$this->db->where('la.loan_status = "PENDING" OR la.loan_status = "APPROVED" OR la.loan_status = "PAID"');
// 		$this->db->or_where('la.loan_status ','REJECTED');
// 		$this->db->or_where('la.loan_status !=','PAID');
		$query = $this->db->get();
		return $query->row_array();
	}
	public function get_loan_by_status($status){
		$this->db->select('*');
		$this->db->from('loan_apply la');
// 		$this->db->join('loan_setting ls','ls.lsid=la.loan_id');
		$this->db->join('user u','u.userid=la.user_id');
		if($status != NULL){
		$this->db->where('la.loan_status',$status);
		}
		$query = $this->db->get();
		return $query->result_array();
	}
	public function get_loan_by_status_count($status){
		$this->db->select('*');
		$this->db->from('loan_apply la');
		$this->db->join('user u','u.userid=la.user_id');
		$this->db->where('la.loan_status',$status);
		$query = $this->db->get();
		return $query->num_rows();
	}
	public function getallextendedloanscount($minvalue,$maxvalue){
		$this->db->select('*');
		$this->db->from('loan_apply la');
		$this->db->join('user u','u.userid=la.user_id');
		$this->db->where('la.ext_status','ACTIVE');
		$this->db->where("la_doc BETWEEN '$minvalue' AND '$maxvalue'");
		$query = $this->db->get();
		return $query->num_rows();
	}
	public function getLoanByStatusCountByDateRange($status,$minvalue,$maxvalue){
		$this->db->select('*');
		$this->db->from('loan_apply la');
		// $this->db->join('user u','u.userid=la.user_id');
		$this->db->where('la.loan_status',$status);
		$this->db->where("la_doc BETWEEN '$minvalue' AND '$maxvalue'");
		$query = $this->db->get();
		// echo $this->db->last_query();
		return $query->num_rows();
	}
	public function getallextendedloanscountByDateRange($minvalue,$maxvalue){
		$this->db->select('*');
		$this->db->from('loan_apply la');
		$this->db->join('user u','u.userid=la.user_id');
		$this->db->where('la.ext_status','ACTIVE');
		$this->db->where("la_doc BETWEEN '$minvalue' AND '$maxvalue'");
		$this->db->where('la.loan_status','PAID');
		$query = $this->db->get();
		return $query->num_rows();
	}
	public function getallloanswithpaneltycountByDateRange($minvalue,$maxvalue){
		$this->db->select('*');
		$this->db->from('loan_apply la');
		$this->db->join('user u','u.userid=la.user_id');
		$this->db->where('la.panelty_status','ACTIVE');
		$this->db->where("la_doc BETWEEN '$minvalue' AND '$maxvalue'");
		$this->db->where('la.loan_status','PAID');
		$query = $this->db->get();
		return $query->num_rows();
	}
	public function get_loan_by_status_panelty(){
		$this->db->select('*');
		$this->db->from('loan_apply la');
		$this->db->join('user u','u.userid=la.user_id');
		// $this->db->where('la.panelty_status','ACTIVE');
		$this->db->where('la.loan_status','PAID');
		$query = $this->db->get();
		return $query->result_array();
	}
	public function getLoanByStatusByDateRange( $status, $minvalue, $maxvalue, $type = false, $loan_id = false )
	{
		$this->db->select("
		u.*,
		la.*,
		ma.name as manager_name");
		$this->db->from('loan_apply la');
		$this->db->join('managers ma','ma.id=la.manager_id', 'left');
		$this->db->join('user u','u.userid=la.user_id');

		if($status != NULL)
		{
			$this->db->where('la.loan_status',$status);
		}

		if( $type )
		{
			$this->db->where( 'la.loan_type', $type );
		}

		if( $loan_id )
		{
			$this->db->where( 'la.loan_id', intval( $loan_id ) );
		}

		$this->db->where("la_doc BETWEEN '$minvalue' AND '$maxvalue'");
		$this->db->order_by( 'la.la_doc', 'DESC' );

		$query = $this->db->get();
		// echo $this->db->last_query();
		return $query->result_array();
	}
	public function getallextendedloansByDateRange($minvalue,$maxvalue){
		$this->db->select('*');
		$this->db->from('loan_apply la');
// 		$this->db->join('loan_setting ls','ls.lsid=la.loan_id');
		$this->db->join('user u','u.userid=la.user_id');
		$this->db->where('la.ext_status','ACTIVE');
		$this->db->where("la_doc BETWEEN '$minvalue' AND '$maxvalue'");
		$this->db->where('la.loan_status','PAID');
		$query = $this->db->get();
		return $query->result_array();
	}
	public function getallloanswithpaneltyByDateRange($minvalue,$maxvalue){
		$this->db->select('*');
		$this->db->from('loan_apply la');
// 		$this->db->join('loan_setting ls','ls.lsid=la.loan_id');
		$this->db->join('user u','u.userid=la.user_id');
		$this->db->where('la.panelty_status','ACTIVE');
		$this->db->where("la_doc BETWEEN '$minvalue' AND '$maxvalue'");
		$this->db->where('la.loan_status','PAID');
		$query = $this->db->get();
		return $query->result_array();
	}
	public function getallloanswithpaneltycount(){
		$this->db->select('*');
		$this->db->from('loan_apply la');
		$this->db->join('user u','u.userid=la.user_id');
		$this->db->where('la.panelty_status','ACTIVE');
		$this->db->where('la.loan_status','PAID');
		$query = $this->db->get();
		return $query->num_rows();
	}
	public function getAllPaneltyLoans(){
		$this->db->select('*');
		$this->db->from('loan_apply la');
// 		$this->db->join('loan_setting ls','ls.lsid=la.loan_id');
		$this->db->join('user u','u.userid=la.user_id');
		$this->db->where('la.panelty_status','ACTIVE');
		$this->db->where('la.loan_status','PAID');
		$query = $this->db->get();
		return $query->result_array();
	}
	public function getallloanswithExtentionscount(){
		$this->db->select('*');
		$this->db->from('loan_apply la');
		$this->db->join('user u','u.userid=la.user_id');
		$this->db->where('la.ext_status','ACTIVE');
		$this->db->where('la.loan_status','PAID');
		$query = $this->db->get();
		return $query->num_rows();
	}
	public function getallloanswithExtentions(){
		$this->db->select('*');
		$this->db->from('loan_apply la');
// 		$this->db->join('loan_setting ls','ls.lsid=la.loan_id');
		$this->db->join('user u','u.userid=la.user_id');
		$this->db->where('la.ext_status','ACTIVE');
		$this->db->where('la.loan_status','PAID');
		$query = $this->db->get();
		return $query->result_array();
	}
}