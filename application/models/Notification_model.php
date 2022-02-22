<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table="notification";
		$this->fcm_api_key = 'AAAAhREXUTA:APA91bEK3GJrWJhDM98x35oxOJnah4mZuZqBwZuUiixRNb9JR-tadITDHQrah2hhTyQB0dYgyeuJEsNQSCrryUK53er7deXvpr1T3R1TDxwEd23x0cyhSlBhhKKayJknM50-XDrRqEKr';
	}
	public function insert($data){
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();	  		
	}
	public function update($notify_id,$data){
		$this->db->where('notify_id',$notify_id);
		return $this->db->update($this->table,$data);
	}
    public function getAllNotifications(){
    	$this->db->select('*');
		$this->db->from($this->table);
// 		$this->db->where('read_status','INACTIVE');
		$this->db->order_by('notify_id','desc');
		$query = $this->db->get();
		return $query->result_array();
    }
    public function getAllUnreadNotifications(){
    	$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('read_status','INACTIVE');
		$this->db->order_by('notify_id','desc');
		$query = $this->db->get();
		return $query->result_array();
    }
    public function get_loan_payment_by_lpid($lp_id){
    	$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('lp_id',$lp_id);
		$query = $this->db->get();
		return $query->row_array();
    }
    public function filter_get_loan_payment($data){
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
	public function SendPushnotification($registatoin_ids, $notification,$device_type)
	{
	    $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
            'to' => $registatoin_ids,
            'notification' => $notification
        );
        // Firebase API Key
        $headers = array('Authorization:key='.$this->fcm_api_key,'Content-Type:application/json');
        // Open connection
        $ch = curl_init();
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
	}

}