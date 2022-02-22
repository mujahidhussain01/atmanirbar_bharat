<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Managers_model extends CI_Model 
{

    private $table,$primary_key;

    
    public function __construct()
    {
        parent::__construct();
        $this->table ='managers';
        $this->primary_key='id';
    }

    public function get_all_managers()
    {
        $this->db->select('*');
		$this->db->from( $this->table );
		$query = $this->db->get();
		return $query->result_array();
    }

    public function get_all_active_managers()
    {
        $this->db->select('*');
		$this->db->from( $this->table );
		$this->db->where( [ 'status' => 'ACTIVE' ] );
		$query = $this->db->get();
		return $query->result_array();
    }

    public function get_single_manager_where( $where )
    {
        $this->db->select('*');
		$this->db->from( $this->table );
        $this->db->where( $where )->limit( 1 );
		$query = $this->db->get();
		return $query->row_array();
    }

    public function create_manager($data)
	{
		$this->db->insert( $this->table, $data);
		return $this->db->insert_id();	  		
	}

    public function get_manager_by_id( $id )
    {
    	$this->db->select('*');
		$this->db->from( $this->table );
		$this->db->where( $this->primary_key , $id )->limit( 1 );
		$query = $this->db->get();
		return $query->row_array();
    }

    public function get_manager_by_token( $token )
    {
    	$this->db->select('*');
		$this->db->from( $this->table );
        $this->db->where( [ 
            'status' => 'ACTIVE',
            'token' => $token,
        ] )->limit( 1 );
		$query = $this->db->get();
		return $query->row_array();
    }

    public function update_single_manager( $data, $id )
    {
        $this->db->where( $this->primary_key, $id );
        $this->db->limit( 1 );
        return $this->db->update( $this->table, $data );
    }
    

}

/* End of file Managers_model.php */
