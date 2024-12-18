<?php
class Login_Model extends CI_Model 
 {
	private $UserName   = '' ; 
	private $Password   = '' ; 
	private $ID         = 0 ; 
	private $LastUpdate = '' ;
	private $Status     = 0 ;
	private $Encryptkey = '' ;
	
	function __construct()
    {
	   parent::__construct();
	   $this->LastLogin = date('Y-m-d H:i:s');
	   $this->Encryptkey = $this->config->item('encryption_key');
    }
	///////check_login 
	public function check_login($data = array())
	{
		extract($data);
		$date=date("Y-m-d H:i:s", strtotime("+2 hours"));
		$this->UserIP = $this->input->ip_address();
		$this->Device = $this->input->user_agent();
// 	    $json       = file_get_contents("http://ipinfo.io/{$this->UserIP}");
//          $details    = json_decode($json);
         $this->Country='null';
		$this->UserName = str_replace(" ","",$username) ;
		$this->Password = str_replace(" ","",$password) ; 
		$this->Password = md5($this->Encryptkey.$this->Password) ;
		$GetDataLogin = $this->db->query("SELECT Mail ,Mobile,Img ,count_login ,contact.ID,Type,Isactive,erp_active , Name , SchoolID , GroupID ,ID_ACC AS ID_ERB , call_emp , trace_emp , student.is_update FROM contact
		                                  LEFT JOIN student on student.Contact_ID = contact.ID
		                                  WHERE User_Name = ".$this->db->escape($this->UserName)." AND Password = ".$this->db->escape($this->Password)." ");
		if($GetDataLogin->num_rows()>0)
		{
		    if($GetDataLogin->num_rows()>1)
		     {
		   	$check_repeat =$GetDataLogin->result();
    		  $type=  array_column($check_repeat, 'Type');
    		 
    		  if(in_array('E',$type)||in_array('F',$type)){
    		      	$GetDataLogin = $this->db->query("SELECT Mail ,Mobile,Img ,count_login ,ID,Type,Isactive,Name , SchoolID , GroupID ,ID_ACC AS ID_ERB , call_emp , trace_emp FROM contact WHERE
		            User_Name = ".$this->db->escape($this->UserName)." AND Password = ".$this->db->escape($this->Password)."  AND Type!='A' ");
    		  }
    		  
    		}
			$DataLogin       =  $GetDataLogin->row_array();
				// 	$this->ID        =  $DataLogin['ID'];
				// 	$this->count_login        =  $DataLogin['count_login'];
				// 	$dataUpdata      = array('LastLogin'=>$this->LastLogin,'count_login'=>($this->count_login)+1,'Online'=>1);
				// 	$this->db->where('ID',$this->ID);
				// 	 if($this->db->update('contact', $dataUpdata))
				// 	{ 
					   //  $dataInserted      = array('User_ID'=>$this->ID,'User_IP'=>$this->UserIP,'Device'=>$this->Device,'Country'=>$this->Country,'Date'=>$date);
					   // $this->db->insert('Login_Details', $dataInserted);
					   // $session = generateRandomString(200);
					   // $SessionDate=array( 'SessionToken'=> $session, 'UserID' => $DataLogin['ID'] );
					   // $this->db->insert('sessionToken', $SessionDate);
					   // $DataLogin['sessionToken'] = $session;
						return  $DataLogin ; 
				    //  }  
		}else{
			   return FALSE ;  
			 }
	}
	
		public function check_login_android($data = array())
	{
		extract($data);
		$date=date("Y-m-d H:i:s", strtotime("+2 hours"));
		$this->UserName = str_replace(" ","",$username) ;
		$this->Password = str_replace(" ","",$password) ; 
		$this->Password = md5($this->Encryptkey.$this->Password) ;
		$GetDataLogin = $this->db->query("SELECT contact.Mail ,contact.Mobile,contact.Img ,contact.count_login ,contact.ID as user_id,contact.Type,
		                                  contact.Isactive,contact.Name , contact.SchoolID ,school_details.ID_ACC AS SchoolID_ACC,school_details.SchoolName,contact.GroupID ,contact.ID_ACC AS ID_ERB ,contact.IDHr, 
		                                  contact.call_emp , contact.trace_emp,employee.jobTitleID,row_level.Level_ID,
										  employee.PerType,employee.Type AS empType,employee.EmpType AS Supervisor,employee.Branch
		                                  FROM contact
		                                  INNER JOIN school_details ON school_details.ID = contact.SchoolID
		                                  left join employee on contact.ID =employee.Contact_ID
										  left join student on contact.ID = student.Contact_ID
										  left join row_level on student.R_L_ID =  row_level.ID
		                                  WHERE
		                                  contact.User_Name = ".$this->db->escape($this->UserName)." 
		                                  AND contact.Password = ".$this->db->escape($this->Password)." LIMIT 1");
		if($GetDataLogin->num_rows()>0)
		{
		   
					$DataLogin       =  $GetDataLogin->row_array();
						return  $DataLogin ; 
				    //  }  
		}else{
			   return FALSE ;  
			 }
	}
	public function userData($data = array())
	{
		extract($data);
		$date=date("Y-m-d H:i:s", strtotime("+2 hours"));
		$GetDataLogin = $this->db->query("SELECT contact.Mail ,contact.Mobile,contact.Img ,contact.count_login ,contact.ID as user_id,contact.Type,
		                                  contact.Isactive,contact.Name , contact.SchoolID ,school_details.ID_ACC AS SchoolID_ACC,school_details.SchoolName,contact.GroupID ,contact.ID_ACC AS ID_ERB ,contact.IDHr, 
		                                  contact.call_emp , contact.trace_emp,employee.jobTitleID,row_level.Level_ID,
										  employee.PerType,employee.Type AS empType,employee.EmpType AS Supervisor,employee.Branch,employee.emp_supervisor
		                                  FROM contact
		                                  INNER JOIN school_details ON school_details.ID = contact.SchoolID
		                                  left join employee on contact.ID =employee.Contact_ID
										  left join student on contact.ID = student.Contact_ID
										  left join row_level on student.R_L_ID =  row_level.ID
		                                  WHERE
		                                  contact.ID = $ID
		                                 LIMIT 1");
		if($GetDataLogin->num_rows()>0)
		{
		   
					$DataLogin       =  $GetDataLogin->row_array();
						return  $DataLogin ; 
				    //  }  
		}else{
			   return FALSE ;  
			 }
	}
	
		public function setting_data( )
	{
	     $this->db->select('*'); 
         $query = $this->db->get('setting'); 
		 if($query->num_rows()>0){ $query =$query->row_array(); return $query;}else{return 0;}   

	}
	public function get_school( )
	{
	     $this->db->select('ID'); 
 		 $this->db->order_by("ID", "ASC"); 
         $query = $this->db->get('school_details'); 
		 if($query->num_rows()>0){ $query =$query->row_array(); return $query['ID'];}else{return 0;}   

	}
	public function check_mobile($Mobile = 0 )
	{
		 $query = $this->db->query("SELECT ID FROM contact WHERE Mobile = '".$Mobile."' LIMIT 1  ")->row_array();
		 if(sizeof($query) > 0 )
		 {
			 return $query['ID'] ;

		 }else{return false ; }

	}
	public function check_email( $Mail= NULL  )
	{
		 $query = $this->db->query("SELECT ID FROM contact WHERE Mail = '".$Mail."' ")->row_array();
		if(sizeof($query) > 0 )
		{
			return $query['ID'] ;

		}else{return false ; }
	}
	public function update_pass( $UserID = 0 , $NewPass = 0  )
	{
		 $this->db->query("UPDATE  contact  SET Password = '".md5($this->Encryptkey.$NewPass)."' WHERE ID = '".$UserID."' ");

	}
	public function update_pass2( $schoolId = 0 , $NewPass = 0  ,$Number_ID=0 )
	{
	    
	     $remove[] = "'";
         $remove[] = '"';
          
          $NewPass = str_replace( $remove, "", $NewPass );
          $value = $this->db->query("select ID  from contact  where contact.Number_ID = '".$Number_ID."' AND SchoolID = '".$schoolId."'  AND User_Name = '".$NewPass."' ")->row();
          $ID=$value->ID;
          if($ID){
		  $this->db->query("UPDATE  contact  SET count_login = count_login + 1 , Password = '".md5($this->Encryptkey.$NewPass)."' WHERE ID = '".$ID."'");
		  if($this->db->affected_rows() > 0)
			{
				return true;
		}else{return false ; }
          }else{return false ; }
	}
	
		public function check_another_login($Active_Student)
	{
	    $date=date("Y-m-d H:i:s", strtotime("+2 hours"));
		$this->UserIP = $this->input->ip_address();
		$this->Device = $this->input->user_agent();
	    // $json       = file_get_contents("http://ipinfo.io/{$this->UserIP}");
        //  $details    = json_decode($json);
         $this->Country='null';
		$GetDataLogin = $this->db->query("SELECT Mail ,Mobile,Img ,count_login ,ID ,Type,Isactive,Name , SchoolID , GroupID  FROM contact WHERE contact.ID =".$Active_Student." LIMIT 1");
		if($GetDataLogin->num_rows()>0)
		{
		   
		$DataLogin       =  $GetDataLogin->row_array();
					$this->ID        =  $DataLogin['ID'];
					$this->count_login        =  $DataLogin['count_login'];
					$dataUpdata      = array('LastLogin'=>$this->LastLogin,'count_login'=>($this->count_login)+1,'Online'=>1);
					$this->db->where('ID',$this->ID);
					 if($this->db->update('contact', $dataUpdata))
					{ 
					     $dataInserted      = array('User_ID'=>$this->ID,'User_IP'=>$this->UserIP,'Device'=>$this->Device,'Country'=>$this->Country,'Date'=>$date);
					    $this->db->insert('Login_Details', $dataInserted);
					    $session = generateRandomString(200);
					    $SessionDate=array( 'SessionToken'=> $session, 'UserID' => $DataLogin['ID'] );
					    $this->db->insert('sessionToken', $SessionDate);
					    $DataLogin['sessionToken'] = $session;
						return  $DataLogin ; 
				     }  
				     
		}else{
			   return FALSE ; 
			   
			 }
	} 
	//////////////////
	public function get_vote($type)
	{
		 $date=date('Y-m-d');
		$ResultExam = $this->db->query("SELECT * from vote_quiz
                                        where vote_quiz.is_publish=1
                                        AND vote_quiz.type = 0 
    		                            AND vote_quiz.from <= '$date'
    		                            AND vote_quiz.to >= '$date'
    		                            AND (vote_quiz.permission_type = $type or vote_quiz.permission_type=0)
                                       ")->row_array();
        if($ResultExam['ID']){
            return 1;
        }else{
          return 0;  
        }

	}
	////////////////////
	public function perLevel($PerType,$ApiDbname)
	{
	    if($this->ApiDbname=="SchoolAccTabuk"){
	        $Name="Level_Name_en";
	    }else{
	        $Name="Level_Name";
	    }
		 $query = $this->db->query("SELECT $Name as Level_Name FROM `row_level` WHERE `Level_ID` IN($PerType) group by Level_ID ")->result();
		if(sizeof($query) > 0 )
		{
			return  $query;

		}else{return false ; }
	}
	////////////////////
	public function perrowLevel($PerType,$ApiDbname)
	{
	    if($this->ApiDbname=="SchoolAccTabuk"){
	        $levelName="Level_Name_en";
	        $rowName="Row_Name_en";
	    }else{
	        $levelName="Level_Name";
	         $rowName="Row_Name";
	    }
		 $query = $this->db->query("SELECT $levelName as Level_Name,$rowName as Row_Name, CONCAT(Level_Name,' ',Row_Name) AS rowLevelName FROM `row_level` WHERE `ID` IN($PerType) group by ID ")->result();
		if(sizeof($query) > 0 )
		{
			return  $query;

		}else{return false ; }
	}
	////////////////////
	public function perClass($row_lev,$class,$ApiDbname)
	{
	    if($this->ApiDbname=="SchoolAccTabuk"){
	        $levelName="Level_Name_en";
	        $rowName="Row_Name_en";
	        $className = "Name_en";
	    }else{
	        $levelName="Level_Name";
	        $rowName="Row_Name";
	        $className = "Name";
	         
	    }
		 $query = $this->db->query("SELECT row_level.$levelName AS Level_Name,row_level.$rowName AS Row_Name,class.$className AS className, CONCAT($levelName,'-',$rowName,'-',$className) AS fullClassName
		                            FROM class_level 
		                            INNER JOIN class ON class.ID = class_level.classID
		                            INNER JOIN row_level ON row_level.Level_ID = class_level.levelID 
		                            WHERE row_level.ID = $row_lev 
		                            AND class.ID = $class
		                            ")->row_array();
		if(sizeof($query) > 0 )
		{ 
			return  $query;

		}else{return false ; }
	}

	public function ExamToken($userID){
		$newToken = generateRandomString(64);
		$this->Encryptkey = $this->config->item('encryption_key');
		$encryptedToken = md5($this->Encryptkey . $newToken);
		$updateData = array(
			'exam_token' => $encryptedToken
		);
		$this->db->where('ID', $userID);
		$this->db->update('contact', $updateData);

		if ($this->db->affected_rows() > 0) {
			return $newToken; 
		} else {
			return false; 
		}
	}
	public function AuthFromeApi($token)
	{
		
		$this->Password = str_replace(" ","",$token) ; 
		$this->token = md5($this->Encryptkey.$this->Password) ;
		$GetDataLogin = $this->db->query("SELECT Mail ,Mobile,Img ,count_login ,contact.ID,Type,Isactive,erp_active , Name , SchoolID , GroupID ,ID_ACC AS ID_ERB , call_emp , trace_emp , student.is_update FROM contact
		                                  LEFT JOIN student on student.Contact_ID = contact.ID
		                                  WHERE  exam_token = ".$this->db->escape($this->token)." ");
		if($GetDataLogin->num_rows()>0)
		{
			$DataLogin       =  $GetDataLogin->row_array();
			return  $DataLogin ; 
				  
		}else{
			   return FALSE ;  
			 }
	}
	
 }/////////END CLSS 
