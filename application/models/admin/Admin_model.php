<?php
class Admin_Model extends CI_Model{
	private $Token           = '' ;
	// var $table = "users";  contact.*,school_details.SchoolName
	// var $select_column = array(" contact.*", "school_details.SchoolName", "SchoolName");  
	var $order_column = array("contact.ID", "contact.Name", "school_details.SchoolName");
    function __construct()
    {
        parent::__construct();
        $this->Date       = date('Y-m-d H:i:s');
        $this->Encryptkey = $this->config->item('encryption_key');
        $this->Token      = $this->get_token();
    }
    ////////get_token
    private function get_token()
    {
        $this->Token            = md5($this->Encryptkey.uniqid(mt_rand()).microtime()) ;
        return	$this->Token ;
    }
    //////////get_admin
    public function get_admin()
    {
        $query = $this->db->query("SELECT
		 contact.* 
		 FROM contact
		 WHERE contact.Type = 'U' AND  contact.Isactive = 1 ")->result();
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
    //////////get_admin_data
    public function get_admin_data($ID = 0 )
    {
        $query = $this->db->query("SELECT contact.* ,school_details.SchoolName FROM contact LEFT JOIN school_details ON contact.SchoolID = school_details.ID WHERE contact.Type = 'U' AND  contact.ID = '".$ID."'  ")->row_array();
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
	public function add_admin($data = array())
	{
		 $query = $this->db->query("SELECT SchoolID FROM contact WHERE ID = '".$data['UID']."'")->row_array();
			    $Add_Contact = array(
							 'type'                =>'U'  ,
							 'SchoolID'            =>$data['SchoolID']  ,
							 'RealSchoolID'        =>$query['SchoolID']  
							 
							 );
                  $this->db->where('ID',$data['UID']);			 
		          $Update =  $this->db->update('contact', $Add_Contact);
				  return true ;
	}
	public function get_contact($Type = 0 )
	{
	    $emp = get_emp_select_in();
        $student =get_student_select_in();

		if($Type == 0)
		{
			$GetData = $this->db->query("
			SELECT DISTINCT
			contact.ID    AS ContactID,
			contact.Name  AS ContactName
			FROM 
			contact 
			INNER JOIN employee ON contact.ID = employee.Contact_ID
			WHERE contact.SchoolID = '".$this->session->userdata('SchoolID')."'
	        and contact.Type ='E' AND contact.ID IN(".$emp.") group by contact.ID
			"); 
			if($GetData->num_rows()>0)
			{
				return $GetData->result();
			}else{
				   return FALSE ;
				 }
			
		}else{
			   
			 $query = $this->db->query("
			 SELECT DISTINCT
			 tb1.ID    AS ContactID,
			 tb1.Token AS StudentToken,
			 tb1.Name  AS ContactName,
			 tb2.ID    AS FatherID ,
			 tb2.Token AS FatherToken ,
		     tb2.Name  AS FatherName ,
			 CONCAT(tb1.Name,' ',tb2.Name) AS FullName
			 FROM contact As tb1
			 INNER JOIN student ON tb1.ID = student.Contact_ID
			 INNER JOIN contact AS tb2 ON student.Father_ID     = tb2.ID
			 WHERE tb1.SchoolID = '".$this->session->userdata('SchoolID')."'
			 and tb1.Type ='S' AND tb1.ID IN(".$student.") group by tb1.ID
			 ORDER BY tb1.Name
			 
			");
			if($query->num_rows()>0)
			{
			   return $query->result();	
			}else{return false ;}
			 }
	}
	////////////////////get_emp_admin
	public function get_emp_admin()
	{
	  $query = $this->db->query("SELECT * FROM contact WHERE Type IN ('E') AND  Isactive= 1  AND SchoolID ='".$this->session->userdata('SchoolID')."' ")->result();
	  if(sizeof($query)>0)
	  {
		  return $query ;
	  }else{return false ;}
	}
	////////////////change_type_users
	public function change_type_users($UserID = 0 )
	{
	  $query = $this->db->query("SELECT Type ,RealSchoolID FROM contact WHERE ID = '".$UserID."'")->row_array();
	  if(sizeof($query)>0)
	  {
         if($query['Type'] == 'U' )
		 {
		   $this->db->query("UPDATE contact SET Type = 'E',SchoolID='".$query['RealSchoolID']."' WHERE ID = '".$UserID."'");	 
		 }
		 if($query['Type'] == 'E' )
		 {
		   $this->db->query("UPDATE contact SET Type = 'U' WHERE ID = '".$UserID."'");	 
		 }		  
	  }	
	}/////////////////////////////get_emp_rate
	public function get_emp_rate($Type = 0 )
	{
	  $query = $this->db->query("SELECT * FROM emp_rate WHERE EmpType = '".$Type."'")->result();
	  if(sizeof($query)>0)
	  {
		  return $query ;
	  }else{
		     return false ; 
		   }
	} 
	public function check_emp_rate($Type = 0 ,$Lang = NULL , $RateType = 1 )
	{
		$query = $this->db->query("SELECT * FROM emp_rate WHERE EmpType = '".$RateType."' AND Type = '".$Type."'")->row_array();
	  if(sizeof($query)>0)
	  {
		  return  true;
	  }else{
		     $this->db->query("INSERT INTO  emp_rate SET EmpType = '".$RateType."' , Rate = 0  , Type = '".$Type."'  , FiledName = '".$Lang."' ") ; 
		   }
	}
	
	public function update_emp_rate($Data= array())
	{
	  $this->db->query("UPDATE  emp_rate SET   Rate = '".$Data['Rate']."' , NumRate = '".$Data['NumRate']."' WHERE ID = '".$Data['ID']."' ") ; 

	}
	////////////////////////check_type_rate
	public function check_type_rate($Type = 0 )
	{
	  			$query = $this->db->query("SELECT * FROM emp_rate WHERE Type = '".$Type."'")->row_array();
	  if(sizeof($query)>0)
	  {
		  return  $query;
	  }
	  else{
	          return false ; 
	      }
	}
	
	public function get_data_user_msg()
	{
		$query = $this->db->query("
		SELECT 
		level.Name ,
		school_details.SchoolName ,
		msg_sms_sender.* 
		FROM
		msg_sms_sender
		INNER JOIN school_details ON msg_sms_sender.SchoolID = school_details.ID 
		LEFT JOIN level          ON msg_sms_sender.LevelID  = level.ID ORDER BY msg_sms_sender.SchoolID 
		   ")->result();
	if(sizeof($query)>0){return $query ;}else{return FALSE ;}
		   
	}
	public function get_contact_search($search,$type,$numper,$page)
	{
	    $offset = $page * 100;
	    $where = 'contact.Name like "%'.$search.'%"';
	    if($numper == 1){ $where = 'contact.Number_ID like "%'.$search.'%"'; }
	    if($type == 2){
	         $query = $this->db->query('select contact.Name ,contact.ID as contactID , contact.SchoolID ,school_details.SchoolName,contact.Number_ID   
            from contact 
            INNER JOIN school_details on school_details.ID = contact.SchoolID
            WHERE '.$where.'  and contact.type = "E" group by contact.ID limit '.$offset.' , 100   ');
	    }else{
	         $query = $this->db->query('select contact.Name ,contact.id as contactID , contact.SchoolID ,school_details.SchoolName,contact.Number_ID   
            from contact 
            INNER JOIN school_details on school_details.ID = contact.SchoolID
            WHERE contact.Name like "%'.$search.'%" and contact.type = "S" ');
	    }
	       

        if($query->num_rows() > 0){
            return $query->result();
            
        }else{
            return false;
        }  
	}

	public function update_user_last_activity($id)
	{
		
		$this->db->query("UPDATE  contact SET   last_activity = '".date('Y-m-d H:i:s')."'  WHERE id = '".$id."' ") ;
		
	}






	//////////////////////////
	function make_query($type, $school_id)  
    {  
		$date = date('Y-m-d');

		$Where  = array('contact.Online'=>1, 'contact.SchoolID' => $school_id);

		$this->db->select('contact.*,school_details.SchoolName');  
		$this->db->from('contact');  
		$this->db->join('school_details','contact.SchoolID = school_details.ID', 'LEFT');
		$this->db->where($Where);
		$this->db->where('contact.Type', $type);
        $this->db->where("date(contact.LastLogin)>='$date'");
		if($_POST["search"]["value"] != null)  
		{  
			$this->db->like("contact.ID", $_POST["search"]["value"]);  
			$this->db->or_like("contact.Name", $_POST["search"]["value"]);  
			$this->db->or_like("school_details.SchoolName", $_POST["search"]["value"]);  
		}  
		if($_POST["order"] != null)  
		{  
			$this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
		}  
		else  
		{  
			$this->db->order_by('contact.LastLogin', 'DESC');  
		} 
	}  
	  
	function make_datatables($type, $school_id){  
		$this->make_query($type, $school_id);  
		if($_POST["length"] != -1)  
		{  
			$this->db->limit($_POST['length'], $_POST['start']);  
		}  
		$query = $this->db->get(); 
		return $query->result();  
	}  
	
	function get_filtered_data($type, $school_id){  
		$this->make_query($type, $school_id);  
		$query = $this->db->get();  
		return $query->num_rows();  
	}       
	
	// public function get_school_name($id)
	// {
	// 	$query = $this->db->select('')
	// }

	function get_all_data($type=0, $school_id)  
	{  
		$date = date('Y-m-d H:i:s', strtotime('-5 minutes'));
		$Where  = array('contact.SchoolID' => $school_id, 'LastLogin >='=>$date);

			$this->db->select('contact.*,school_details.SchoolName');  
			$this->db->from('contact');  
			$this->db->join('school_details','contact.SchoolID = school_details.ID','left');
			if($type != 0){
				$this->db->where('contact.Type', $type);
			}
			$this->db->where($Where);
		return $this->db->count_all_results();  
	}

	public function get_data_user_msg_new($Type,$datefrom, $dateto,$Father,$emp)
	{
	    if($Type==1){
	        $where="and temp_msg.ContactID IN($Father)";
	    }
	    elseif($Type==2){
	        $where="and temp_msg.ContactID IN($emp)";
	    }
		$query = $this->db->query("
		SELECT 
		Sen.Name as Sender ,
		Sen.ID as Sender_ID,
		Rec.Name AS Receiver,
		school_details.SchoolName as SchoolName ,
		temp_msg.Msg as Message,
		temp_msg.DateInsert as Date,
		school_details.ID AS SchoolID,
		temp_msg.Type as Type,
		temp_msg.Reason as Reason,
		temp_msg.IsSend as IsSend,
		temp_msg.ContactID
		FROM
		temp_msg
		INNER JOIN school_details ON temp_msg.SchoolID = school_details.ID 
	    INNER JOIN contact AS Sen ON temp_msg.EmpID =Sen.ID
	    left JOIN contact AS Rec ON temp_msg.ContactID =Rec.ID
	    WHERE  temp_msg.Type=$Type AND date(temp_msg.DateInsert) between '$datefrom' AND '$dateto'  and school_details.ID ='" . $this->session->userdata('SchoolID') . "'
	    group by Sender,SchoolName,Message,Date,ContactID
		ORDER BY temp_msg.ID DESC
		   ")->result();
	if(sizeof($query)>0){return $query ;}else{return FALSE ;}
		   
	}


	////////////////////////////END CLASS	
}