<?php defined('BASEPATH') OR exit('No direct script access allowed');

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
        $this->db->select( '`group_loans`.`name`, `group_loans`.`id`, COALESCE( ( select  sum( `loan_apply`.`amount` ) from `loan_apply` where `loan_apply`.`loan_id` = `group_loans`.`id` AND `loan_apply`.`loan_type` = "GROUP" GROUP BY loan_apply.loan_id ), 0 ) as `total_amount`' )
		->from( 'group_loans' );

		if( $search ) $this->db->where( "group_loans.name like '%$search%' " );
        
		$query = $this->db->get();

		return $query->result_array();
    }

    public function get_group_loan_for_manager( $search = false )
	{
		$this->db->select('*');
		$this->db->from( $this->table );
		$this->db->order_by( 'created_at', 'DESC' );

		if( $search ) $this->db->where( "name like '%$search%' " );
		$query = $this->db->get();

		return $query->result_array();
	}

	public function get_single_group_loans_for_manager( $id )
	{
		$this->db->select('*');
		$this->db->from('loan_setting');
		$this->db->where( 'loan_type', 'GROUP' );
		$this->db->where( 'ls_status', 'ACTIVE' );
		$this->db->where( $this->primary_key, $id )->limit( 1 );
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
        $this->db->select('*');
		$this->db->from( $this->table );
		$query = $this->db->get();
		return $query->result_array();
    }

    public function get_single_group_loan_where( $where )
    {
        $this->db->select('*');
		$this->db->from( $this->table );
        $this->db->where( $where )->limit( 1 );
		$query = $this->db->get();
		return $query->row_array();
    }



    public function get_group_loan_by_id( $id )
    {
    	$this->db->select('*');
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
