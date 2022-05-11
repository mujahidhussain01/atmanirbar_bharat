<?php 
class Otp_model extends CI_model{

	public function __construct(){
		$this->table       = 'otp';
        $this->primary_key = 'otp_id';
		$this->mobile_no='mobile_number';
		$this->otp='otp';
	}

	public function getOtp($id = null,$mobileNumber = null)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        if ($id != null) {
            $this->db->where($this->primary_key,$id);
        }else{
			$this->db->where($this->mobile_no , $mobileNumber);
		} 
        $query = $this->db->get();

        return $query->result_array();
    }

    public function update($dataArray,$mobileNumber)
    {
        $result = $this->db->where($this->mobile_no ,$mobileNumber)
        ->update($this->table,$dataArray); 

        if ($result)
        {
            return $result;
        }
    }

    public function insert($data)
    {

        if ($this->db->insert($this->table, $data)) {
            return $msg = 'Data is inserted successfully';
        } else {
            return "Some technical eroor please restart your device";
        }
    }

    public function otpsending($mobile)
    {
        $returnData = [];
         
         // creating unique 4 digit OTP
         $length=4;
         $key = '';
         $keys = array_merge(range(0, 9));
        for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
         }
        $token= $key;
        
         // checking number already exist or not                         
        $checknumber=$this->checkmobile($mobile);
         if(count($checknumber) > 0){
             //updating otp table 
             $updatedata['otp']=$token;
             $updatedata['status']='INACTIVE';
             $this->update($updatedata ,$mobile);
         }else{
             // inserting in otp Table
              $insertdata['otp'] =$token;
              $insertdata['mobile_number']=$mobile;
            $this->insert($insertdata);
         }
                //sending otp to mobile
                $message = 'Your ELM App verification OTP is '.$token.'. - Sent By Easy Loan Mantra';
			    $curl = curl_init();
    			curl_setopt_array($curl, array(
			    CURLOPT_URL=>"http://sms3.pepanimation.com/api/sendhttp.php?authkey=359764An5sG6DaeSB60892d1aP1&mobiles=$mobile&message=Your%20ELM%20App%20verification%20OTP%20is%20$token.%20-%20Sent%20By%20Easy%20Loan%20Mantra&sender=ELMSMS&route=4&country=91&DLT_TE_ID=1207161945110838406",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET"
                ));

		    $response = curl_exec($curl);
		    $err = curl_error($curl);
		    curl_close($curl);
         
         //fetching data for response
          $returnData = $otpdetail=$this->getdata($mobile);
          $returnData['responseCode'] = $response;
          return $returnData;
         
        
    }
    public function userotpsending($mobile)
    {
        $returnData = [];
         
        // creating unique 4 digit OTP
        $length=4;
        $key = '';
        $keys = array_merge(range(0, 9));

        for ($i = 0; $i < $length; $i++) 
        {
            $key .= $keys[array_rand($keys)];
        }

        $token= $key;
        
         // checking number already exist or not                         
        $checknumber=$this->checkmobile($mobile);

        if(count($checknumber) > 0)
        {
            //updating otp table 
            $updatedata['otp']=$token;
            $updatedata['status']='INACTIVE';
            $this->update($updatedata ,$mobile);
        }
        else
        {
            // inserting in otp Table
            $insertdata['otp'] =$token;
            $insertdata['mobile_number']=$mobile;
            $this->insert($insertdata);
        }
            //sending otp to mobile
            //     $curl = curl_init();
            //     curl_setopt_array($curl, array(
            //         CURLOPT_URL=>"http://sms3.pepanimation.com/api/sendhttp.php?authkey=359764An5sG6DaeSB60892d1aP1&mobiles=$mobile&message=Your%20ELM%20App%20verification%20OTP%20is%20$token.%20-%20Sent%20By%20Easy%20Loan%20Mantra&sender=ELMSMS&route=4&country=91&DLT_TE_ID=1207161945110838406",
            //         CURLOPT_RETURNTRANSFER => true,
            //         CURLOPT_ENCODING => "",
            //         CURLOPT_MAXREDIRS => 10,
            //         CURLOPT_TIMEOUT => 30,
            //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //         CURLOPT_CUSTOMREQUEST => "GET",
            //         CURLOPT_HTTPHEADER => array(
            //         "authorization: Basic T2ZmZXItQWRtaW46b2ZmZXJfYWRtaW5fMTIzKjg5MA==",
            //         "cache-control: no-cache",
            //         "x-api-key: V9FH5BCSKP8XQGMC6WVTS"
            //         )
            //     ));

		    // $response = curl_exec($curl);
		    // $err = curl_error($curl);
		    // curl_close($curl);
         
        //fetching data for response
        $returnData = $this->getrowdata($mobile);
        
        return $returnData;
    }


    public function getrowdata($mobile)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('mobile_number',$mobile);
        $query=$this->db->get();
        return $query->row();
    }
    public function getdata($mobile)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('mobile_number',$mobile);
        $this->db->order_by('past_modified_date','desc');
        $query=$this->db->get();
        return $query->result_array();
    }
    public function getAllOtpdata()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('past_modified_date','desc');
        $query=$this->db->get();
        return $query->result_array();
    }
    public function checkmobiledata($mobile_number,$otp)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('mobile_number',$mobile_number);
        $this->db->where('otp',$otp);
        $this->db->where('status','INACTIVE');
        $query=$this->db->get();
        return $query->result_array();
    }

    public function checkmobile($data)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('mobile_number',$data);
        $query=$this->db->get();
        return $query->result_array();
    }

    public function updatestatus($mobile_number){
        $data['status']="ACTIVE";
        $this->db->where('mobile_number',$mobile_number);
        $this->db->update($this->table,$data);
    }

	
}
?>