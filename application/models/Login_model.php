<?php 
class Login_model extends CI_model{

	public function __construct(){
		$this->table ='admin_table';
		$this->primary_key='id';
	}


	public function superadmincheck($username,$password){
		$query = $this->db->select('*')
								->from($this->table)
								->where('username',$username)
								->where('password',md5($password))
								->where('admin_type','SUPERADMIN')
								->get();
		return $query->row();

	}
	public function admincheck($username,$password){
		$query = $this->db->select('*')
								->from($this->table)
								->where('a_email',$username)
								->where('a_pass',md5($password))
								->where('a_type','ADMIN')
								->get();
		return $query->row();

	}
	public function GetAdminInfo($a_id){
		$query = $this->db->select('*')
								->from($this->table)
								->where($this->primary_key,$a_id)
								->get();
		return $query->row();

	}


	public function insert_new_client($dataArray)
	{
		$sql = $this->db->insert('client',$dataArray);
		return $sql;

	}
}
?>