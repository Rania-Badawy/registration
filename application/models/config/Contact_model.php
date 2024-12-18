<?php
class Contact_Model  extends CI_Model 
 {
	 private $ID ;
	 private $Name ;
	 private $Gender ;
	 private $Mail ;
	 private $Address ;
	 private $Phone ;
	 private $Mobile ;
	 private $img ;
	 private $Number_ID ;
	 private $Nationality_ID ;
	 private $User_Name ;
	 private $Password ;
	 
	 ///get_details
	 public function get_details($ID)
	 {
			
		$this->db->select('Name,Gender,Number_ID,mail,Address,Phone,Mobile,img,Nationality_ID,User_Name,Password,Name_en');
        $this->db->from('contact');
        $this->db->where('ID',$ID);
		$this->db->limit(1);
        $ResultUserData = $this->db->get();			
		$NumRowResultUserData  = $ResultUserData->num_rows() ; 
			if($NumRowResultUserData >0)
			  {
				$ReturnUserDataEdit     = $ResultUserData->row_array() ;
				
			   return $ReturnUserDataEdit ; 
							 
			  }else{return FALSE ;}
		
	 }
	 	 ///auth_user
	 public function auth_user($ID)
	 {
				
        $this->db->from('contact');
        $this->db->where('ID',$ID);
		$this->db->limit(1);
        $ResultUserData = $this->db->get();			
		$NumRowResultUserData  = $ResultUserData->num_rows() ; 
			if($NumRowResultUserData >0)
			  {
				$ReturnUserDataEdit     = $ResultUserData->row_array() ;
				
			   return $ReturnUserDataEdit ; 
							 
			  }else{return FALSE ;}
		
	 }
	 ///update_contacts
	 public function update_contacts($data)
	 {
	     extract($data);
		 (int)$this->ID            = $data['id'] ; 
		 (string)$this->Name       = $this->db->escape_str($data['Name']) ;
		 (int)$this->Gender        = $this->db->escape_str($data['Gender']);
		 (string)$this->Address    = $this->db->escape_str($data['Address']) ;
		 (string)$this->Mail       = $this->db->escape_str($data['mail']) ;
		 (string)$this->Phone      = $this->db->escape_str($data['Phone']) ;
		 (string)$this->Mobile     = $this->db->escape_str($data['Mobile']) ;
		 (string)$this->img        = $this->db->escape_str($data['img']) ;
		 (string)$this->UserName   = $this->db->escape_str($data['UserName']) ;
		 (string)$this->Password   = $this->db->escape_str($data['Password']) ;
		 
         $reg=$this->db->query("select reg_type, IN_ERP from school_details  ")->row_array();
		 $user=$this->db->query("select User_Name, Password,user_changed from contact where ID='".$this->ID."' ")->row_array();
		 if($user['User_Name']!=$this->UserName || $user['Password']!=$this->Password){
			$user_changed=1;
		 }else{
			$user_changed=$user['user_changed'];
		 }
         if($reg['IN_ERP']== 2){
		 $Data_Array = array( 
		 'Name'          =>(string)$this->Name  ,
		 'Gender'        =>(int)$this->Gender  ,
		 'mail'          =>(string)$this->Mail  ,
		 'Address'       =>(string)$this->Address  ,
		 'Phone'         =>(string)$this->Phone  ,
		 'Mobile'        =>(string)$this->Mobile  ,
		 'img'           =>(string)$this->img  ,
		 'User_Name'     =>(string)$this->UserName  ,
		 'Password'      =>(string)$this->Password  ,
		 'updated_by'    =>(int)$this->ID,
		 'user_changed'  =>$user_changed,
		 'last_update'   =>$data['date']
		 );
		 
         }else{
             if($this->ApiDbname !="SchoolAccShorouqAlmamlakah")
             {
             $Data_Array = array( 
        	 
        	 'img'           =>(string)$this->img  ,
        	 'User_Name'     =>(string)$this->UserName  ,
        	 'Password'      =>(string)$this->Password  ,
        	 'mail'          =>(string)$this->Mail  ,
        	 'updated_by'    =>(int)$this->ID,
			 'user_changed'  =>$user_changed,
        	 'last_update'   =>$data['date']
		    );
             }else{
                  $Data_Array = array( 
        	 
                	 'img'           =>(string)$this->img  ,
                	 'Password'      =>(string)$this->Password  ,
                	 'mail'          =>(string)$this->Mail  ,
                	 'updated_by'    =>(int)$this->ID,
					 'user_changed'  =>$user_changed,
                	 'last_update'   =>$data['date']
        		    );
             }

         }

		           $this->db->where('ID', (int)$this->ID);
        $Update =  $this->db->update('contact', $Data_Array); 
	
		if($Update){return TRUE ;
		}else{return FALSE ;}
	 }
	 public function check_username($UserName = NULL , $USerID = 0 )
	 {
		$this->UserName   =  $UserName ;
		$CheckUser        =  $this->db->query("SELECT ID FROM contact WHERE User_Name LIKE '%".$this->UserName."%' AND ID !=".$USerID."") ; 
		if($CheckUser->num_rows() == 0 ){return TRUE ;}else{return FALSE ;}
	 }
	 /////////////////////
	// public function check_username($UserName = NULL , $USerID = 0 )
	// {
	//	$this->UserName   =  $UserName ;
	//	$CheckUser        =  $this->db->query("SELECT md5(CONCAT('qwwtertyrtuytyuiyuouippisdggdfghfjghkjhkjljh7455221456322872598vxcvxcvxcfjkyfgkbtium.ljnuytudfyfdghstwres5576432.21325454542vc',))") ; 
	//	if($CheckUser->num_rows() == 0 ){return TRUE ;}else{return FALSE ;}
	// }
 }
?>