<?php 
class User_model extends CI_model{

	public function __construct(){
		$this->table       = 'user';
        $this->primary_key = 'userid';
		$this->mobile_no='mobile';
	}

	public function checkmob($mobile_number,$data)
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('mobile',$mobile_number);
		$query=$this->db->get();
		$checkmob=$query->row();
         $returnData = [];
		 $length=35;
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));
        for ($i = 0; $i < $length; $i++) 
        {
          $key .= $keys[array_rand($keys)];
        }
        $token= $key;
        $data['token']=$token;
		if(!empty($checkmob))
        {                 
        $this->updateUserData($mobile_number,$data);
        }
        else
        {
            $data['mobile']=$mobile_number; 
            $data['default_title']='Account Created successfully';
            $data['default_message']='Your account has been created successfully please provide your employment documents to verify your profile.Please wait until our team will verify you.We will keep you informed.Thanks ';
            $this->InsertNewUser($data);
        }
        $this->Otp_model->updatestatus($mobile_number);
        $returnData=$this->readUniqueUserforMobile($mobile_number);
        return $returnData;

	}

    public function updateUserData($mobile,$data){
		$this->db->where('mobile',$mobile);
		$sql = $this->db->update($this->table,$data);
		return $sql;

	}
    public function updateUserDataByUserId($userid,$data){
		$this->db->where('userid',$userid);
		$sql = $this->db->update($this->table,$data);
		return $sql;

	}
	public function updateUserDataByToken($token,$data){
		$this->db->where('token',$token);
		$sql = $this->db->update($this->table,$data);
		return $sql;

	}
	public function updateUserDataByWebToken($token,$data){
		$this->db->where('web_token',$token);
		$sql = $this->db->update($this->table,$data);
		return $sql;

	}
	public function InsertNewUser($dataArray)
	{
		$sql = $this->db->insert($this->table,$dataArray);
		return $sql;
	}

	public function readUniqueUserforMobile($mobileNumber)
	{   
	    $base_url = base_url('uploads/profile_image/');
		$this->db->select("*,CONCAT('$base_url',profile_image) as profile_image");
        $this->db->from($this->table);
        $this->db->where('mobile', $mobileNumber);
        $query = $this->db->get();
        return $query->row();
	}
	public function readUniqueUserforWeb($mobileNumber)
	{
		$this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('mobile', $mobileNumber);
        $query = $this->db->get();
        return $query->row();
	}

	public function GetValidUserforWeb($mobileNumber)
	{
		$this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('mobile', $mobileNumber);
        $this->db->where('web_user_status','ACTIVE');
        // $this->db->where('password !=',NULL);
        $query = $this->db->get();
        return $query->result_array();
	}
	public function GetFilteredUser($array)
	{
		$this->db->select('*');
        $this->db->from($this->table);
        $this->db->where($array);
        $this->db->order_by('userCreationDate','desc');
        $query = $this->db->get();
        return $query->result_array();
	}
	public function GetFilteredUserCount($array)
	{
		$this->db->select('*');
        $this->db->from($this->table);
        $this->db->where($array);
        $query = $this->db->get();
        return $query->num_rows();
	}
	public function GetUserByToken($token)
	{
		$this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('token', $token);
        $query = $this->db->get();
        return $query->row();
	}
	public function GetUserByTokenForApp($token)
	{   
	    $aadhar_front = base_url('uploads/adhar_card/front/');
	    $aadhar_back = base_url('uploads/adhar_card/back/');
	    $check_image = base_url('uploads/check_image/');
	    $pay_slip_image = base_url('uploads/pay_slip_image/');
	    $profile_image = base_url('uploads/profile_image/');
		$this->db->select("*,   CONCAT('$aadhar_front',adhar_card_front) as adhar_card_front,
                        		CONCAT('$aadhar_back',adhar_card_back) as adhar_card_back,
                        		CONCAT('$check_image',check_image) as check_image,
                        		CONCAT('$pay_slip_image',pay_slip_image) as pay_slip_image,
                        		CONCAT('$profile_image',profile_image) as profile_image");
        $this->db->from($this->table);
        $this->db->where('token', $token);
        $query = $this->db->get();
        return $query->row();
	}
	public function GetCurrentUserCityDetail($token)
	{	
		$base_url = base_url('uploads/city/');
		$this->db->select("b.id,b.city_name,CONCAT('$base_url',b.city_image) as city_image");
        $this->db->from('user a');
        $this->db->join('city b','b.id = a.city');
        $this->db->where('a.token', $token);
        $query = $this->db->get();
        return $query->result_array();
	}
	public function GetUserByWebToken($token)
	{
		$this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('web_token', $token);
        $query = $this->db->get();
        return $query->row();
	}
    public function GetUserById($id)
	{
		$this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('userid', $id);
        $query = $this->db->get();
        return $query->row();
	}
    public function GetAllUsers()
	{
		$this->db->select('*');
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->result_array();
	}
    public function GetAllUsersCount()
	{
		$this->db->select('*');
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->num_rows();
	}
    public function GetAllPendingUsers()
	{
		$this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('status','ACTIVE');
        $this->db->where('(bda_status = "NOT_AVAILABLE" AND
        pan_card_approved_status = "NOT_AVAILABLE" AND 
        docv_status = "NOT_AVAILABLE" AND 
        passbook_approved_status = "NOT_AVAILABLE")');
        $query = $this->db->get();
        // echo $this->db->last_query();exit;
        return $query->result_array();
	}
    public function GetAllPendingUsersCount()
	{
		$this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('status','ACTIVE');
        $this->db->where('(bda_status = "NOT_AVAILABLE" AND
        pan_card_approved_status = "NOT_AVAILABLE" AND 
        docv_status = "NOT_AVAILABLE" AND 
        passbook_approved_status = "NOT_AVAILABLE")');
        $query = $this->db->get();
        // echo $this->db->last_query();exit;
        return $query->num_rows();
	}
	
	public function GetdocumentPendingUsers()
	{
		$this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('status','ACTIVE');
        $this->db->where('(bda_status = "PENDING" OR
        pan_card_approved_status = "PENDING" OR 
        docv_status = "PENDING" OR 
        passbook_approved_status = "PENDING")');
        $query = $this->db->get();
        // echo $this->db->last_query();exit;
        return $query->result_array();
	}
	
	public function GetdocumentPendingUserscount()
	{
		$this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('status','ACTIVE');
        $this->db->where('(bda_status = "PENDING" OR
        pan_card_approved_status = "PENDING" OR 
        docv_status = "PENDING" OR 
        passbook_approved_status = "PENDING")');
        $query = $this->db->get();
        // echo $this->db->last_query();exit;
        return $query->num_rows();
	}
	
	
    public function GetAllVerifiedUsers()
	{
		$this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('status','ACTIVE');
        $this->db->where('(bda_status = "APPROVED" AND pan_card_approved_status = "APPROVED" AND docv_status = "APPROVED" AND passbook_approved_status = "APPROVED")');
        $query = $this->db->get();
        return $query->result_array();
	}
    public function GetAllVerifiedUserscount()
	{
		$this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('status','ACTIVE');
        $this->db->where('(bda_status = "APPROVED" AND pan_card_approved_status = "APPROVED" AND docv_status = "APPROVED" AND passbook_approved_status = "APPROVED")');
        $query = $this->db->get();
        return $query->num_rows();
	}
    public function GetAllRejectedUsers()
	{
		$this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('status','ACTIVE');
        $this->db->where('(bda_status = "REJECTED" OR pan_card_approved_status = "REJECTED" OR docv_status = "REJECTED" OR passbook_approved_status = "REJECTED")');
        $query = $this->db->get();
        return $query->result_array();
	}
    public function GetAllRejectedUsersCount()
	{
		$this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('status','ACTIVE');
        $this->db->where('(bda_status = "REJECTED" OR ecv_status = "REJECTED" OR company_approve_status = "REJECTED" OR ba_status = "REJECTED" OR pan_card_approved_status = "REJECTED" OR docv_status = "REJECTED" OR passbook_approved_status = "REJECTED")');
        $query = $this->db->get();
        return $query->num_rows();
	}
	
	public function checktoken($token)
	{
	    $this->db->select('token,userid')->from('user')->where('token',$token);
	    $query=$this->db->get();
	    return $query->row_array();
	 }
	 
	 public function getusersByStatusByDateRange($status,$minvalue,$maxvalue){

        if($status=='ALL')
        {
            $this->db->select('*');
            $this->db->from($this->table);
            $this->db->where("userCreationDate BETWEEN '$minvalue' AND '$maxvalue'");
            $query = $this->db->get();
            return $query->result_array();
        }
        
        if($status=='PENDING')
        {
            $this->db->select('*');
            $this->db->from($this->table);
            $this->db->where('status','ACTIVE');
            $this->db->where('(bda_status = "NOT_AVAILABLE" OR
            pan_card_approved_status = "NOT_AVAILABLE" OR 
            docv_status = "NOT_AVAILABLE" OR 
            passbook_approved_status = "NOT_AVAILABLE")');
            $this->db->where("userCreationDate BETWEEN '$minvalue' AND '$maxvalue'");
            $query = $this->db->get();
            return $query->result_array();
        }
        
        if($status=='DPENDING')
        {
            $this->db->select('*');
            $this->db->from($this->table);
            $this->db->where('status','ACTIVE');
            $this->db->where('(bda_status = "PENDING" OR
            pan_card_approved_status = "PENDING" OR 
            docv_status = "PENDING" OR 
            passbook_approved_status = "PENDING")');
            $this->db->where("userCreationDate BETWEEN '$minvalue' AND '$maxvalue'");
            $query = $this->db->get();
            return $query->result_array();
        }
        
        // if($status=='PENDING')
        // {
        //     $this->db->select('*');
        //     $this->db->from($this->table);
        //     $this->db->where('status','ACTIVE');
        //     $this->db->where('(bda_status = "PENDING" AND
        //     pan_card_approved_status = "PENDING" AND 
        //     docv_status = "PENDING" AND 
        //     passbook_approved_status = "PENDING")');
        //     $this->db->where("userCreationDate BETWEEN '$minvalue' AND '$maxvalue'");
        //     $query = $this->db->get();
        //     return $query->result_array();
        // }
        
        // if($status=='DPENDING')
        // {
        //     $this->db->select('*');
        //     $this->db->from($this->table);
        //     $this->db->where('status','ACTIVE');
        //     $this->db->where('(bda_status = "NOT_AVAILABLE" OR
        //     pan_card_approved_status = "NOT_AVAILABLE" OR 
        //     docv_status = "NOT_AVAILABLE" OR 
        //     passbook_approved_status = "NOT_AVAILABLE")');
        //     $this->db->where("userCreationDate BETWEEN '$minvalue' AND '$maxvalue'");
        //     $query = $this->db->get();
        //     return $query->result_array();
        // }
        
        
        if($status=='REJECTED')
        {
            $this->db->select('*');
            $this->db->from($this->table);
            $this->db->where('status','ACTIVE');
            $this->db->where('(bda_status = "REJECTED" OR pan_card_approved_status = "REJECTED" OR docv_status = "REJECTED" OR passbook_approved_status = "REJECTED")');
            $this->db->where("userCreationDate BETWEEN '$minvalue' AND '$maxvalue'");
            $query = $this->db->get();
            return $query->result_array();
        }
        
        if($status=='APPROVED')
        {
            $this->db->select('*');
            $this->db->from($this->table);
            $this->db->where('status','ACTIVE');
            $this->db->where('(bda_status = "APPROVED" AND pan_card_approved_status = "APPROVED" AND docv_status = "APPROVED" AND passbook_approved_status = "APPROVED")');
            $this->db->where("userCreationDate BETWEEN '$minvalue' AND '$maxvalue'");
            $query = $this->db->get();
            return $query->result_array();
            
        }
	}
	

    //  added by Mujahid hussain --------------------------

    public function get_single_user_by_mobile( $mobile )
    {
        $this->db->select( '*' )
        ->from( $this->table )
        ->where( 'mobile', $mobile )
        ->limit( 1 );

        $query = $this->db->get();

        return $query->row_array();
    }
}
?>