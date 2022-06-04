<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Loan_payments_model extends CI_Model 
{

    private $table,$primary_key;

    
    public function __construct()
    {
        parent::__construct();
        $this->table ='loan_payments';
        $this->primary_key='id';
    }

    public function get_all_payments_list()
    {
        $this->db->select( $this->table.'.*, ma.name as manager_name');

		$this->db->from( $this->table );

        $this->db->join( 'managers ma', 'ma.id = loan_payments.manager_id', 'left' );

		$query = $this->db->get();
		return $query->result_array();
    }

    public function get_payments_list_by_status( $status )
    {
        $this->db->select( $this->table.'.*, ma.name as manager_name');

		$this->db->from( $this->table );

        $this->db->join( 'managers ma', 'ma.id = loan_payments.manager_id', 'left' );

		$this->db->where( 'loan_payments.status', $status );

		$query = $this->db->get();
		return $query->result_array();
    }

    public function get_payments_list_by_status_count( $status )
    {
        $this->db->select('*');
		$this->db->from( $this->table );

		$this->db->where( 'loan_payments.status', $status );
		
		return $this->db->count_all_results();
    }

    public function get_all_payments( $loan_apply_id )
    {
        $this->db->select( $this->table.'.*, ma.name as manager_name');
		$this->db->from( $this->table );

        $this->db->join( 'managers ma', 'ma.id = loan_payments.manager_id', 'left' );
        
		$this->db->where( 'loan_apply_id', $loan_apply_id );
		$query = $this->db->get();
		return $query->result_array();
    }

    public function get_payments_by_date( $date )
    {
        $this->db->select("
        loan_payments.*,
        u.first_name,
        u.last_name,
        u.email,
        u.mobile,
        u.city,
        la.la_id,
        la.amount as loan_amount,
        la.loan_duration,
        la.payment_mode,
        la.payable_amt,
        la.deduct_lic_amount,
        la.rate_of_interest,
        la.remaining_balance,
        la.loan_closer_amount,
        la.processing_fee,
        la.loan_type,
        ma.name as manager_name
        ");
		$this->db->from( $this->table );

        $this->db->join( 'loan_apply la','la.la_id = loan_payments.loan_apply_id' );
		$this->db->join( 'user u','u.userid = loan_payments.user_id' );
        $this->db->join( 'managers ma','ma.id = loan_payments.manager_id', 'left' );

		$this->db->where( 'payment_date', $date );
		$query = $this->db->get();
		return $query->result_array();
    }

    public function get_payments_by_date_count( $date )
    {
        $this->db->select('*');
		$this->db->from( $this->table );
        
		$this->db->where( 'payment_date', $date );
		return $this->db->count_all_results();
    }

    public function get_all_payed_payments( $minvalue, $maxvalue )
    {
        $this->db->select("
        loan_payments.*,
        u.first_name,
        u.last_name,
        u.email,
        u.mobile,
        u.city,
        la.la_id,
        la.amount as loan_amount,
        la.loan_duration,
        la.payment_mode,
        la.payable_amt,
        la.deduct_lic_amount,
        la.rate_of_interest,
        la.remaining_balance,
        la.loan_closer_amount,
        la.processing_fee,
        la.loan_type,
        ma.name as manager_name
        ");
		$this->db->from( 'loan_payments' );

        $this->db->join( 'loan_apply la','la.la_id = loan_payments.loan_apply_id' );
		$this->db->join( 'user u','u.userid = loan_payments.user_id' );
		$this->db->join( 'managers ma','ma.id = loan_payments.manager_id', 'left');

		$this->db->where( 'loan_payments.status', 'ACTIVE' );

        $this->db->where("loan_payments.amount_received_at BETWEEN '$minvalue' AND '$maxvalue'");

		$this->db->order_by( 'loan_payments.amount_received_at', 'DESC' );
		$query = $this->db->get();
		return $query->result_array();
    }

    public function get_all_payed_payments_count()
    {
        $this->db->select('*');
		$this->db->from( 'loan_payments' );
		$this->db->where( 'loan_payments.status', 'ACTIVE' );

		return $this->db->count_all_results();
    }


    public function get_all_upcoming_payments()
    {
        $this->db->select("
        loan_payments.*,
        u.first_name,
        u.last_name,
        u.email,
        u.mobile,
        u.city,
        la.la_id,
        la.amount as loan_amount,
        la.loan_duration,
        la.payment_mode,
        la.payable_amt,
        la.deduct_lic_amount,
        la.rate_of_interest,
        la.remaining_balance,
        la.loan_closer_amount,
        la.processing_fee,
        la.loan_type,
        "
        );
		$this->db->from( $this->table );

        $this->db->join( 'loan_apply la','la.la_id = loan_payments.loan_apply_id' );
		$this->db->join( 'user u','u.userid = loan_payments.user_id' );

        $this->db->group_by( 'loan_payments.loan_apply_id' );
		$this->db->order_by( 'id', 'ASC' );
		$this->db->where( 'loan_payments.status', 'INACTIVE' );
		$query = $this->db->get();
		return $query->result_array();
    }

    public function get_all_upcoming_payments_count()
    {
        $this->db->select('id');
		$this->db->from( $this->table );
		// $this->db->join( 'loan_apply', 'loan_apply.la_id = loan_payments.loan_apply_id', 'left' );
        $this->db->group_by( 'loan_payments.loan_apply_id' );
		$this->db->order_by( 'id', 'ASC' );
		$this->db->where( 'loan_payments.status', 'INACTIVE' );
		
		return $this->db->count_all_results();
    }


    public function get_pending_payments_of_user( $user_id )
    {
        $this->db->select('
                loan_payments.id,
                loan_payments.user_id,
                loan_payments.loan_apply_id,
                loan_payments.amount_received_by,
                ma.name as manager_name,
                loan_payments.amount,
                loan_payments.amount_received,
                loan_payments.amount_received_at,
                loan_payments.payment_date,
                loan_payments.bounce_charges,
                loan_payments.status,
                loan_payments.created_at,
                loan_payments.updated_at
        ');
		$this->db->from( 'loan_payments' );
		$this->db->join('managers ma','ma.id = loan_payments.manager_id', 'left');

		$this->db->where( 'loan_payments.status', 'INACTIVE' );
		$this->db->where( 'loan_payments.user_id', $user_id );
		$query = $this->db->get();
		return $query->result_array();
    }

    public function get_upcoming_payment_of_user( $user_id )
    {
         $this->db->select( $this->table.'.*, ma.name as manager_name');

		$this->db->from( $this->table );

        $this->db->join( 'managers ma', 'ma.id = loan_payments.manager_id', 'left' );
        
		$this->db->order_by( 'loan_payments.id', 'ASC' );
		$this->db->where( 'loan_payments.status', 'INACTIVE' );
		$this->db->where( 'loan_payments.user_id', $user_id )->limit( 1 );
		$query = $this->db->get();
		return $query->row_array();
    }



    public function get_single_payment_where_id( $where, $id )
    {
         $this->db->select( '*');
		$this->db->from( $this->table );
		$this->db->where( $where )->limit( 1 );
		$this->db->where( $this->primary_key, $id );
        
		$query = $this->db->get();
		return $query->row_array();
    }

    public function get_next_payment_where_id( $payment_id, $loan_id )
    {
         $this->db->select( '*')
		->from( $this->table )
		->where( 'id !=', intval( $payment_id ) )
		->where( 'loan_apply_id', intval( $loan_id ) )
        ->where( 'status', 'INACTIVE' )
        ->order_by( 'payment_date', 'ASC' )
        ->limit( 1 );
        
		$query = $this->db->get();
		return $query->row_array();
    }


    public function get_all_loans_penalty_payments()
    {
        $this->db->select( '*')
		->from( $this->table )
        ->where( 'bounce_charges IS NULL' )
        ->where( 'status', 'INACTIVE' )
        ->where( "str_to_date( payment_date, '%Y-%m-%d') < str_to_date( '".date( 'Y-m-d' )."' ,'%Y-%m-%d')" )
        ->order_by( 'payment_date', 'ASC' );

		$query = $this->db->get();
		return $query->result_array();
    }

    
    public function update_single_payment( $data, $id )
    {
        $this->db->where( $this->primary_key, $id );
        $this->db->limit( 1 );
        return $this->db->update( $this->table, $data );
    }

    public function mark_all_active_where_loan_id( $loan_id )
    {
        $this->db->where( 'loan_apply_id', intval( $loan_id ) );
        return $this->db->update( $this->table, [ 'status' => 'ACTIVE' ] );
    }

    public function insert($data)
	{
		return $this->db->insert( $this->table, $data);
	}

    public function insert_batch($data)
	{
		return $this->db->insert_batch( $this->table, $data);
	}

    public function delete_inactive_payments_where_loan_id( $loan_id )
    {
        return $this->db->where(  'loan_apply_id', intval( $loan_id ) )
        ->where( 'status', 'INACTIVE' )
        ->delete( $this->table );
    }


    

}

/* End of file Managers_model.php */
