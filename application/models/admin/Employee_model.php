<?php
class Employee_Model extends CI_Model{
	 private $Contact_ID     = 0 ;
	 private $JobTitle       = 0 ;
	 const   Type            = 'E';
	 private $Name           = '' ;
	 private $Gender         = 0;
	 private $Mail           = '';
	 private $Address        = '';
	 private $Phone          = '';
	 private $Mobile         = '';
	 private $Number_ID      = '';
	 private $Nationality_ID = 0 ;
	 private $User_Name      = '';
	 private $Password       = '';
	 private $specialization = '';
	 private $BirhtDate      = '';
	 private $JobNow         = '';
	 private $TeacherLevel   = '';
	 private $TeacherDegree  = '';
	 private $Salary         = '';
	 private $ServiceStart   = '';
	 private $EmpType        = '';
	 private $ContractType   = '' ;
     private $ContractDate   = '';
	 private $note 			 = '';
     private $Date           = '' ;
	 private $Encryptkey     = '' ;
	 private $Token          = '' ;
	 private $level          = '' ;
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
	///////////////////////
	public function get_employee_admin($Name="NULL", $Number_ID="NULL" ,$IsActive)
	{
	    if($Number_ID == 0 )   {$Number_ID = 'NULL' ; }
	   // $emp = get_emp_select_in();
	   // if($IsActive==1){
	   //    $where2= "AND contact.ID IN(".$emp.")" ;
	   // }
		$Name=urldecode($Name);
		if($Name!="NULL" || $Number_ID !="NULL"){
	    $where="(
	         contact.Name LIKE '$Name%'
			 OR 
			 contact.Name LIKE '%$Name%'
			  OR 
			 contact.Name_en LIKE '%$Name%'
			  OR 
			 contact.Name LIKE '%$Name%'
			 OR 
	         contact.Number_ID LIKE '%$Number_ID%'
	         or
	         contact.Number_ID LIKE '$Number_ID%'
	         or
	         contact.Number_ID LIKE '%$Number_ID'
	         or
	         contact.Number_ID = $Number_ID
	          
			 )" ;
	    }else{
	      
			 $where="
	   ( contact.Number_ID LIKE '%$Number_ID%'
	    or
	    contact.Number_ID LIKE '$Number_ID%'
	    or
	    contact.Number_ID LIKE '%$Number_ID'
	    or
	    contact.Number_ID = IFNULL($Number_ID,contact.Number_ID))
	     ";
	    }
	    
		$GetData = $this->db->query("
		SELECT 
		contact.ID ,
		contact.Number_ID ,
		contact.Name ,
		contact.Mail ,
		contact.Mobile ,
		contact.Token ,
		contact.Isactive ,
		contact.LastLogin ,
		contact.DateFromDeactive ,
		contact.DateToDeactive ,
		contact.Online ,
		employee.LevelID AS LevelID,
		CASE
            WHEN contact.Name_en IS NULL or contact.Name_en=' '  THEN contact.Name
            ELSE contact.Name_en
            END AS Name_en 
		FROM 
		contact 
		LEFT JOIN employee ON contact.ID = employee.Contact_ID 
		WHERE  contact.SchoolID = '".$this->session->userdata('SchoolID')."' AND contact.Type = 'E'
		$where2
		AND
		$where
        ORDER BY contact.Name
		");
		if($GetData->num_rows()>0){return $GetData->result();}else{return $GetData="" ; }
	}
    ///////////////////////
    public function get_employee($Data)
	{
	    extract($Data);
// 	    $emp = get_emp_select_in();
// 		$supervisor=get_supervisor_select_in();
// 	    $where = "AND contact.ID IN(".$emp.",$supervisor)";
	    
		$GetData = $this->db->query("
		SELECT 
		contact.ID ,
		contact.Number_ID ,
		CASE
    	WHEN contact.Name IS NULL THEN contact.Name_en
    	ELSE  contact.Name
    	END AS Name ,
		contact.Mail ,
		contact.Mobile ,
		contact.Token ,
		contact.Isactive ,
		contact.LastLogin ,
		contact.DateFromDeactive ,
		contact.DateToDeactive ,
		contact.Online ,
		employee.LevelID AS LevelID,
		CASE
            WHEN contact.Name_en IS NULL or contact.Name_en=' '  THEN contact.Name
            ELSE contact.Name_en
            END AS Name_en 
		
		FROM 
		contact 
		LEFT JOIN employee ON contact.ID = employee.Contact_ID 
		WHERE  contact.SchoolID IN(".$this->session->userdata('SchoolID').") 
		AND contact.Type = 'E'
		AND contact.Isactive=$IsActive
		$where
		GROUP BY contact.ID
		ORDER BY SUBSTR(contact.Name,1,LENGTH(contact.Name) -4) 
		");
		if($GetData->num_rows()>0){return $GetData->result();}else{return FALSE ; }
	}
	///add_employee
	 public function add_employee($data = array())
	 {
		 extract($data);
		 $Add_Contact = array(
							 'Name'                =>(string)$Name  ,
							 'Nationality_ID'      =>(int)$nationality  ,
							 'Number_ID'		   => $numberid ,
							 'Mobile'              =>$Mobile   ,
							 'Mail'                => $Email,
							 'User_Name'           =>(string)$UserName  ,
							 'Password'            =>(string)$Password  ,
							 'type'                =>'E',
							 'SchoolID'            =>$this->session->userdata('SchoolID'),
							 'Token'               =>$this->get_token(),
							 );
        $Insert_Contact =  $this->db->insert('contact', $Add_Contact); 
		if($Insert_Contact){
			return TRUE ;
		}else{
		    return FALSE ;
		}
	 }
	 /////////////////////
	 public function get_employee_edit($ID)
	 {	
		$GetData = $this->db->query("
		SELECT 
		contact.ID  AS ConID,
		contact.Name ,
		contact.User_Name ,
		contact.Password ,
		contact.Token ,
		contact.Isactive ,
		contact.Mobile ,
		contact.Mail ,
		contact.Nationality_ID ,
		contact.Number_ID 
		FROM 
		contact 
		WHERE contact.ID = '".$ID."'  LIMIT 1
		");
		if($GetData->num_rows()>0){return $GetData->row_array();}else{return FALSE ; }
	 }
	 /////////////////////
	 public function get_updated($ID )
	{	
	
	  $query  = $this->db->query("
		  SELECT tb1.Name ,tb2.last_update
		  FROM contact as tb1
		  INNER JOIN contact as tb2 ON tb1.ID = tb2.updated_by
		  WHERE tb2.ID = ".$ID."
	  "); 
	  if($query->num_rows()>0)
	  {
		  return $query->row_array(); 
	  }else{return FALSE ;}
		
	}
	///////////////////////////////
	public function edit_employee($data = array())
	{	
	     extract($data);
		  
		$UpdateEmp = array(
		            'Name'		      =>(string)$Name, 
		            'User_Name'	      => $UserName,
		            'Password'	      => $NewPass,
		            'Number_ID'	      => $numberid ,
		            'Nationality_ID'  => $nationality ,
		            'Mobile'	      => $am_mobile,
					'Mail'	          => $Email , 
					'updated_by'      => $this->session->userdata('id'),
					'last_update'     => $date,
					'Type'            => "E"
				);				 
		$this->db->where('ID',$ConID);
		$Update =  $this->db->update('contact', $UpdateEmp);
		if($Update){return TRUE ;}else{return FALSE ;}
	}
 }///////////////////////////END CLASS
?>