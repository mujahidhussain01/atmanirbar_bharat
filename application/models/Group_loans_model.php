<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Group_loans_model extends CI_Model 
{

    private $table,$primary_key;

    
    public function __construct()
    {
        parent::__construct();
        $this->table ='group_loans';
        $this->primary_key='id';
    }

    public function get_all_group_loans_count()
    {
        return $this->db->count_all_results( $this->table );
    }

    public function get_all_group_loans_with_amount_count( $search = FALSE )
    {
        $this->db->select( '
		`group_loans`.*,

		COALESCE( ( select  sum( `loan_apply`.`amount` ) from `loan_apply` where `loan_apply`.`loan_id` = `group_loans`.`id` AND `loan_apply`.`loan_type` = "GROUP"AND ( loan_status in ( "RUNNING", "PAID", "APPROVED" ) ) GROUP BY loan_apply.loan_id ), 0 ) as `total_amount`' )
		->from( $this->table );

		if( $search ) $this->db->where( "group_loans.name like '%$search%' " );
        
		$query = $this->db->get();

		return $query->result_array();
    }

	public function get_all_group_loans_with_amount_count_admin()
    {
        $this->db->select( '
		`group_loans`.*,

		COALESCE( ( select  sum( `loan_apply`.`amount` ) from `loan_apply` where `loan_apply`.`loan_id` = `group_loans`.`id` AND `loan_apply`.`loan_type` = "GROUP"AND ( loan_status in ( "RUNNING", "PAID", "APPROVED" ) ) GROUP BY loan_apply.loan_id ), 0 ) as `total_amount`,

		COALESCE( ( select  sum( `loan_apply`.`remaining_balance` ) from `loan_apply` where `loan_apply`.`loan_id` = `group_loans`.`id` AND `loan_apply`.`loan_type` = "GROUP"AND ( loan_status in ( "RUNNING", "PAID" ) ) GROUP BY loan_apply.loan_id ), 0 ) as `remaining_balance`,

		COALESCE( ( select  sum( `loan_apply`.`payable_amt` ) from `loan_apply` where `loan_apply`.`loan_id` = `group_loans`.`id` AND `loan_apply`.`loan_type` = "GROUP" AND ( loan_status in ( "RUNNING", "PAID" ) ) GROUP BY loan_apply.loan_id ), 0 ) as `amount_payed`
		
		' )
		->from( $this->table );

		$query = $this->db->get();

		return $query->result_array();
    }


	public function get_single_group_loan_with_amount_count( $id )
    {
        $this->db->select( '
		`group_loans`.*,

		COALESCE( ( select  sum( `loan_apply`.`amount` ) from `loan_apply` where `loan_apply`.`loan_id` = `group_loans`.`id` AND `loan_apply`.`loan_type` = "GROUP" AND ( loan_status in ( "RUNNING", "PAID", "APPROVED" ) ) GROUP BY loan_apply.loan_id ), 0 ) as `total_amount`,

		COALESCE( ( select  sum( `loan_apply`.`remaining_balance` ) from `loan_apply` where `loan_apply`.`loan_id` = `group_loans`.`id` AND `loan_apply`.`loan_type` = "GROUP" AND ( loan_status in ( "RUNNING", "PAID" ) ) GROUP BY loan_apply.loan_id ), 0 ) as `remaining_balance`,

		COALESCE( ( select  sum( `loan_apply`.`payable_amt` ) from `loan_apply` where `loan_apply`.`loan_id` = `group_loans`.`id` AND `loan_apply`.`loan_type` = "GROUP" AND ( loan_status in ( "RUNNING", "PAID" ) ) GROUP BY loan_apply.loan_id ), 0 ) as `amount_payed`
		
		' )
		->from( $this->table )
		->where( $this->primary_key, intval( $id ) )
		->limit( 1 );

		$query = $this->db->get();

		return $query->row_array();
    }

	
	public function get_group_loan_active_user_count( $id )
	{
		$this->db->select( 'user_id' );
		$this->db->from( 'loan_apply' );
		$this->db->where( 'loan_id' , intval( $id ) );
		$this->db->where( 'loan_type' , 'GROUP' );
		$this->db->where( 'loan_status' , 'RUNNING' );
		$this->db->group_by( 'user_id' );
		
		return $this->db->count_all_results();
	}

	public function get_group_loan_pending_user_count( $id )
	{
		$this->db->select( 'user_id' );
		$this->db->from( 'loan_apply' );
		$this->db->where( 'loan_id' , intval( $id ) );
		$this->db->where( 'loan_type' , 'GROUP' );
		$this->db->where_in( 'loan_status' , [ 'PENDING', 'APPROVED' ] );
		$this->db->group_by( 'user_id' );
		
		return $this->db->count_all_results();
	}

	public function get_all_loans_of_group_loan( $id ,$search = false )
	{
		$this->db->select( '
			loan_apply.*,
			user.first_name,
			user.last_name,
			user.mobile,
			user.email,
			user.city,
			user.adhar_card_front,
			user.adhar_card_back,
			user.pan_card_image,
			user.passbook_image,
			user.bda_status,
			user.docv_status,
			user.pan_card_approved_status,
			user.passbook_approved_status,
			managers.name as manager_name
			' );
		$this->db->from( 'loan_apply' );
		$this->db->where( 'loan_apply.loan_id' , intval( $id ) );
		$this->db->where( 'loan_apply.loan_type' , 'GROUP' );
		$this->db->order_by( 'loan_apply.loan_status' );
		$this->db->order_by( 'loan_apply.la_doc', 'DESC' );

		if( $search ) $this->db->where( " ( user.first_name like '%$search%' OR user.last_name like  '%$search%' ) " );

		$this->db->join( 'user', 'user.userid = loan_apply.user_id', 'left' );
		$this->db->join( 'managers', 'loan_apply.manager_id = managers.id', 'left' );

		$query = $this->db->get();
		return $query->result_array();
	}


    public function get_group_loan_for_manager( $search = false )
	{
		$this->db->select( '*' );
		$this->db->from( $this->table );
		$this->db->order_by( 'created_at', 'DESC' );

		if( $search ) $this->db->where( "name like '%$search%' " );
		$query = $this->db->get();

		return $query->result_array();
	}

	public function get_single_group_loan( $id )
	{
		$this->db->select( '*' );
		$this->db->from( $this->table );
		$this->db->where( $this->primary_key, intval( $id ) )
		->limit( 1 );

		$query = $this->db->get();

		return $query->row_array();
	}

    public function create_group_loan($data)
	{
		$this->db->insert( $this->table, $data);
		return $this->db->insert_id();	  		
	}

    public function get_all_group_loans()
    {
        $this->db->select( '*' );
		$this->db->from( $this->table );
		$query = $this->db->get();
		return $query->result_array();
    }

    public function get_single_group_loan_where( $where )
    {
        $this->db->select( '*' );
		$this->db->from( $this->table );
        $this->db->where( $where )->limit( 1 );
		$query = $this->db->get();
		return $query->row_array();
    }



    public function get_group_loan_by_id( $id )
    {
    	$this->db->select( '*' );
		$this->db->from( $this->table );
		$this->db->where( $this->primary_key , $id )->limit( 1 );
		$query = $this->db->get();
		return $query->row_array();
    }

    public function update_single_group_loan( $data, $id )
    {
        $this->db->where( $this->primary_key, $id );
        $this->db->limit( 1 );
        return $this->db->update( $this->table, $data );
    }
    

}

/* End of file Group_loans_model.php */
