<?php
class User_Permission_Model extends CI_Model 
 {
	private $Date            = '' ;
	private $Encryptkey      = '' ;
	private $Token           = '' ;
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
	//////get_emp
	public function get_emp($SchoolID = 0 )
	{
		$GetData = $this->db->query("
		SELECT 
		contact.ID    AS ContactID,
		contact.Name  AS ContactName
		FROM 
		contact 
		INNER JOIN employee ON contact.ID = employee.Contact_ID
		WHERE contact.SchoolID = '".$this->session->userdata('SchoolID')."'
        AND  contact.Isactive = 1
		");
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			   return FALSE ;
			 }
	}
	////get_level
	public function get_level($Lang = NULL )
	{
		 $Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT
		 level.ID         AS ID ,
		 level.".$Name."  AS Name 
		 FROM 
		 row_level
		 INNER JOIN row              ON row_level.Row_ID        = row.ID
		 INNER JOIN level            ON row_level.Level_ID      = level.ID
		 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = '".$this->session->userdata('SchoolID')."' 
		 WHERE level.Is_Active = 1  GROUP BY  level.ID 
		")->result();
		if(sizeof($query)>0){return $query ; }else{return FALSE ; }
	}
	////get_page_permission
	public function get_page_permission()
	{
		  $this->db->select('*');    
		  $this->db->from('permission_page');
		  $query = $this->db->get();			
		  if($query->num_rows() >0)
		  {return $query->result();}else{return FALSE ;}
	}////////////delete_permission
	public function delete_permission($EmpID = 0 )
	{
		$WHERE = array('EmpID'=>$EmpID);
		$this->db->where($WHERE);
        $this->db->delete('user_permission');
	}
	////add_user_permission
	public function add_user_permission($data = array())
	{
		  extract($data);
		  $DataInsert = array(
		  'EmpID'             =>$SelectUser , 
		  'PageID'            =>$PageID , 
		  'PermissioView'     =>$ChkView , 
		  'PermissionAdd'     =>$ChkAdd , 
		  'PermissionEdit'    =>$ChkEdit , 
		  'PermissionDelete'  =>$ChkDel , 
		  'ConID'             =>$this->session->userdata('id'),
		  'PerType'           => $PerType ,
		  'Type'              => $type , 
		  'BranchID'          => $BranchID , 
		  'DateFromH'         =>$DateFromH ,
		  'DateToH'           =>$DateToH  , 
		  'DateFrom'          =>$DateFrom , 
		  'DateTo'            =>$DateTo  
		  );
		  //print_r($DataInsert);echo '<br>'; 
		  if($this->db->insert('user_permission',$DataInsert)){return TRUE  ;}else{return FALSE ;}
	}////get_emp_permission
	public function get_emp_permission($PageID = 0,$emp_id = 0)
	{
		  $this->db->select('*');    
		  $this->db->from('user_permission');
		  $this->db->where('PageID',$PageID);
		  $this->db->where('EmpID',$emp_id);
		  $this->db->limit(1);
		  $query = $this->db->get();			
		  if($query->num_rows() >0)
		  {return $query->row_array();}else{return FALSE ;}
	}
	public function get_Class($Lang = NULL)
	{
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		  $this->db->select("".$Name." AS ClassName , ID AS ClassID ");    
		  $this->db->from('class');
		  $query = $this->db->get();			
		  if($query->num_rows() >0)
		  {return $query->result();}else{return FALSE ;}
	}
	////////////////////////////////////
	public function get_class_school_active($Lang = NULL)
	{
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		  $query = $this->db->query("SELECT
		  class.ID  AS ClassID ,
		  class. ".$Name." AS ClassName 
		  FROM class
		  INNER JOIN school_class ON class.ID = school_class.ClassID AND school_class.SchoolID = '".$this->session->userdata('SchoolID')."'
		   ");			
		  if($query->num_rows() >0)
		  {return $query->result();}else{return FALSE ;}
	}
	/////// get_row_level_school
	public function get_row_level_school($Lang = NULL)
	{
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT
		 level.ID         AS LevelID ,
		 row.ID           AS RowID ,
		 level.".$Name."  AS LevelName ,
		 row.".$Name."    AS RowName ,
		 row_level.ID     As RowLevelID 
		 FROM 
		 row_level
		 INNER JOIN row              ON row_level.Row_ID        = row.ID
		 INNER JOIN level            ON row_level.Level_ID      = level.ID
		 WHERE level.Is_Active = 1 
		 ")->result();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}
	}///////////////////////////////////
	/////// get_row_level_school_active
	public function get_row_level_school_active($Lang = NULL)
	{
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT
		 level.ID         AS LevelID ,
		 row.ID           AS RowID ,
		 level.".$Name."  AS LevelName ,
		 row.".$Name."    AS RowName ,
		 row_level.ID     As RowLevelID 
		 FROM 
		 row_level
		 INNER JOIN row              ON row_level.Row_ID        = row.ID
		 INNER JOIN level            ON row_level.Level_ID      = level.ID
		 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = '".$this->session->userdata('SchoolID')."' 
		 WHERE level.Is_Active = 1 and row_level.ID in(
                                    select GROUP_CONCAT(class_table.RowLevelID) from class_table where class_table.EmpID = '".$this->session->userdata('id')."'  group by class_table.RowLevelID
                                    )
		 ")->result();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}
	}
	public function check_class_emp($EmpID = 0 , $ClassID = 0)
	{
		  $this->db->select('*');    
		  $this->db->from('class_per');
		  $this->db->where('ClassID',$ClassID);
		  $this->db->where('EmpID'  ,$EmpID );
		  $this->db->limit(1);
		  $query = $this->db->get();			
		  $CheckNum = $query->num_rows()  ; 
		  return $CheckNum ; 
	}
	public function add_class_per($EmpID , $ClassID)
	{
		$this->db->query("INSERT INTO class_per SET ClassID = ".$ClassID." ,  EmpID = ".$EmpID." ");
        return true ; 

	}
	public function delete_class_per($EmpID)
	{
		$this->db->query("DELETE FROM class_per WHERE  EmpID = '".$EmpID."' ");
        return true ; 
	}
	public function get_row_level()
	{
		////////////////////////////////////////////////////////////////////////////////
		$query = $this->db->query("
			 SELECT
 			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
			 level.Name     AS LevelName,
			 row.Name       AS RowName,
			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
			 class.Name     AS ClassName
			 FROM
			 student
			 INNER JOIN class            ON student.Class_ID     = class.ID
			 INNER JOIN row_level        ON student.R_L_ID  = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID        = row.ID
			 INNER JOIN level            ON row_level.Level_ID      = level.ID
			 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = '".$this->session->userdata('SchoolID')."' 
			 GROUP BY student.R_L_ID
			")->result();
		if(sizeof($query)>0)
		{
			return $query ;
		}else{

			return false ;
		}
	}	public function check_msg_emp($EmpID = 0 , $RowLevelID = 0)
      {
		$this->db->select('*');
		$this->db->from('per_msg');
		$this->db->where('RowLevelID',$RowLevelID);
		$this->db->where('EmpID'  ,$EmpID );
		$this->db->limit(1);
		$query = $this->db->get();
		$CheckNum = $query->num_rows()  ;
		return $CheckNum ;
     }
	 /////////////////////////////
	 	public function add_group()
	    {
		$query = $this->db->query("select * from permission_group where IsUpdate = 0  ")->row_array();
		if(sizeof($query)> 0 ){return $query['ID'];}
		else{
			$this->db->query("INSERT INTO  permission_group SET IsUpdate = 0 ");
			return $this->db->insert_id();
		}
	   }
	public function get_group_by_id($ID = 0 )
	{
		$query = $this->db->query("select * from permission_group where ID = '".$ID."' ")->row_array();
		if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
	}
	public function get_group( )
	{
		$query = $this->db->query("select * from permission_group WHERE IsUpdate =  1   ")->result();
		if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
	}
	public function edit_group($Data = array())
	{
		$this->db->query("
        UPDATE permission_group
        SET
        Name          = '".$Data['Name']."' ,
        Contact_ID    = '".$Data['UID']."' ,
        SchoolID      = '".$Data['SchoolID']."' ,
		IsUpdate      = '".$Data['IsUpdate']."' ,
		IsUpdate      = '".$Data['IsUpdate']."' ,
		IsAdmin       = '".$Data['IsAdmin']."' 
        WHERE ID      = '".$Data['ID']."'
         ");
		return TRUE ;
	}
	  //////////get_school
    public function get_school()
    {
        $query = $this->db->query("select * from school_details  ")->result();
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
	////////////get_subject
	public function get_subject()
	{
		$query = $this->db->query("
		  SELECT
		  config_subject.ID AS ConfigSubjectID ,
		  subject.Name  AS SubName ,
		  level.Name     AS LevelName,
		  row.Name       AS RowName
		  FROM 
		  config_subject
		  INNER JOIN subject ON config_subject.SubjectID = subject.ID
		  INNER JOIN row_level        ON config_subject.RowLevelID  = row_level.ID
		  INNER JOIN row              ON row_level.Row_ID        = row.ID
		  INNER JOIN level            ON row_level.Level_ID      = level.ID
		  GROUP BY config_subject.ID  DESC
		");
				
			  if($query->num_rows() >0)
			  {return $query->result();}else{return FALSE ;}
	}
	////////////get_class_school
	public function get_class_school($Lang = NULL )
	{
		if($Lang == 'arabic')	
		{
			$query = $this->db->query("
			 SELECT 
			 class_table.ID AS ClassTableID ,
			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
			 level.Name     AS LevelName,
			 row.Name       AS RowName,
			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
			 class.Name     AS ClassName
			 FROM 
			 class_table
			 INNER JOIN base_class_table ON class_table.BaseTableID = base_class_table.ID
			 INNER JOIN class            ON class_table.ClassID     = class.ID
			 INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID        = row.ID
			 INNER JOIN level            ON row_level.Level_ID      = level.ID
			 WHERE base_class_table.IsActive = 1 
			 GROUP BY class_table.RowLevelID , class_table.ClassID
			");
		}
		else{
			   $query = $this->db->query("
				 SELECT 
				 class_table.ID AS ClassTableID ,
				 level.ID       AS LevelID,
				 row.ID         AS RowID,
				 class.ID       AS ClassID,
				 level.Name_en  AS LevelName,
				 row.Name_en    AS RowName,
				 row_level.ID   As RowLevelID ,
				 class.ID       As ClassID ,
				 class.Name_en  AS ClassName
				 FROM 
				 class_table
				 INNER JOIN base_class_table ON class_table.BaseTableID = base_class_table.ID
				 INNER JOIN class            ON class_table.ClassID     = class.ID
				 INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
				 INNER JOIN row              ON row_level.Row_ID        = row.ID
				 INNER JOIN level            ON row_level.Level_ID      = level.ID
				 WHERE base_class_table.IsActive = 1 
				 GROUP BY class_table.RowLevelID , class_table.ClassID
				");
			}
			  if($query->num_rows() >0)
			  {return $query->result();}else{return;}
	}
	///////////check_group_page
	public function check_group_page($GroupID = 0  , $PageID = 0 )
	{
		$query = $this->db->query("select * from group_page where GroupID = '".$GroupID."' AND PageID = '".$PageID."' ")->row_array();
		if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
	}
	/////////////////update_group_data
	public function update_group_data($Data = array())
	{
		$this->db->query("UPDATE permission_group SET PerType = '".$Data['PerType']."' , Type =  '".$Data['type']."' , Branch = '".$Data['Branches']."' , IsAdmin = '".$Data['IsAdmin']."' where ID = '".$Data['GetGroup']."'  ") ;
	}
	///////////////////delete_group_page
	public function delete_group_page($GetGroup = 0)
	{
		$this->db->query("DELETE FROM  group_page  where GroupID = '".$GetGroup."'  ") ;
	}
	///////////////////delete_group_page
	public function add_group_page($Data = array())
	{
		$this->db->query("INSERT INTO  group_page SET 
		
		GroupID          = '".$Data['GetGroup']."' ,  
		PageID           = '".$Data['PageID']."' ,
		PermissioView    = '".$Data['ChkView']."' ,
		PermissionAdd    = '".$Data['ChkAdd']."' ,
		PermissionEdit   = '".$Data['ChkEdit']."' ,
		PermissionDelete = '".$Data['ChkDel']."' ,
		ConID            = '".$Data['UID']."' ,
		Date             = '".$this->Date."' 
		") ;
	}
	//////////////////add_per_request
	 	public function add_per_request()
	    {
		$query = $this->db->query("select * from permission_request where IsUpdate = 0  ")->row_array();
		if(sizeof($query)> 0 ){return $query['ID'];}
		else{
			$this->db->query("INSERT INTO  permission_request SET IsUpdate = 0 ");
			return $this->db->insert_id();
		}
	   }
	   //////////get_per_request_by_id
	public function get_per_request_by_id($ID = 0 )
	{
		$query = $this->db->query("select * from permission_request where ID = '".$ID."' ")->row_array();
		if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
	}
	///////////////get_per_request
	public function get_per_request( $Lang = NULL ,  $Type = 0  )
	{
		if($Lang == 'arabic'){$Name = 'Name AS Name' ; }else{$Name = 'Name_En AS Name' ;}
		$query = $this->db->query("
		SELECT
		permission_request.* , 
		name_space.".$Name." , 
		contact.Name AS ContactName 
		from permission_request 
		INNER JOIN name_space ON permission_request.NameSpaceID = name_space.ID
		INNER JOIN contact    ON permission_request.EmpID = contact.ID
		WHERE permission_request.IsUpdate =  1
		AND 
		permission_request.Type = '".$Type."' AND  contact.Isactive = 1 ")->result();
		
		if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
	}
	///////////////edit_per_request
	public function edit_per_request($Data = array())
	{
		$this->db->query("
        UPDATE permission_request
        SET
        EmpID          = '".$Data['EmpID']."' ,
        NameSpaceID    = '".$Data['NameSpaceID']."' ,
		Level          = '".$Data['Level']."' ,
        Type           = '".$Data['Type']."' ,
		IsUpdate       = '".$Data['IsUpdate']."' 
		WHERE ID       = '".$Data['ID']."'
         ");
		return TRUE ;
	}
	///////////get_name_space
	public function get_name_space()
	{
		$query = $this->db->query("SELECT * FROM name_space WHERE Parent_ID	 = 22 ")->result();
		return $query ;
	}
	///////////////get_contact
	public function get_contact()
	{
		$query = $this->db->query("SELECT * FROM contact WHERE Type IN ('E') ")->result();
		return $query ;
	}
	///////////////del_per_request
	public function del_per_request($ID = 0 )
	{
		$query = $this->db->query("DELETE FROM permission_request WHERE ID = '".$ID."' ");
		return true  ;
	}
	////////////////////get_user_per_by_id
	public function get_user_per_by_id($ID = 0 )
	{
		$query = $this->db->query("select * from user_permission where EmpID = '".$ID."' ")->row_array();
		if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
	}
	///////////check_group_page
	public function check_user_page($UserID = 0  , $PageID = 0 )
	{
		$query = $this->db->query("select * from user_permission where EmpID = '".$UserID."' AND PageID = '".$PageID."' ")->row_array();
		if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
	}
	///////////check_group_permission
	public function check_group_permission( $UserID = 0 , $GroupID = 0 ,  $PageID = 0 )
	{
		$query = $this->db->query("
		SELECT
		employee.PerType ,
		employee.Type ,
		employee.Branch , 
		permission_group.SchoolID , 
		group_page.PermissioView , 
		group_page.PermissionAdd , 
		group_page.PermissionEdit , 
		group_page.PermissionDelete 
		FROM 
		group_page 
		INNER JOIN permission_group ON group_page.GroupID = permission_group.ID
		INNER JOIN contact  ON permission_group.ID = contact.GroupID
		INNER JOIN employee ON contact.ID = employee.Contact_ID 
		where contact.ID = '".$UserID."' AND  contact.Isactive = 1 ")->row_array();
		if(sizeof($query)> 0 ){return $query;}
		else
		{
			
		$query = $this->db->query("
		SELECT
		user_permission.PerType ,
		user_permission.Type ,
		user_permission.PermissioView , 
		user_permission.PermissionAdd , 
		user_permission.PermissionEdit , 
		user_permission.PermissionDelete 
		FROM 
	    user_permission 
		where 
		user_permission.EmpID = '".$UserID."' 
		AND CURDATE() between    DateFrom and DateTo ")->row_array();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}
		}
	}
	///////////check_group_permission
	public function check_group_permission_add_edit_delete( $UserID = 0 , $GroupID = 0 ,  $PageID = 0 )
	{
		$query = $this->db->query("
		SELECT
		employee.PerType ,
		employee.Type ,
		employee.Branch , 
		permission_group.SchoolID , 
		group_page.PermissioView , 
		group_page.PermissionAdd , 
		group_page.PermissionEdit , 
		group_page.PermissionDelete 
		FROM 
		group_page 
		INNER JOIN permission_group ON group_page.GroupID = permission_group.ID
		INNER JOIN contact  ON permission_group.ID = contact.GroupID
		INNER JOIN employee ON contact.ID = employee.Contact_ID 
		where contact.ID = '".$UserID."' AND  contact.Isactive = 1 AND group_page.PageID = '".$PageID."' ")->row_array();
		if(sizeof($query)> 0 ){return $query;}
		else
		{
			
		$query = $this->db->query("
		SELECT
		user_permission.PerType ,
		user_permission.Type ,
		user_permission.PermissioView , 
		user_permission.PermissionAdd , 
		user_permission.PermissionEdit , 
		user_permission.PermissionDelete 
		FROM 
	    user_permission 
		where 
		user_permission.EmpID = '".$UserID."' 
		AND user_permission.PageID = '".$PageID."'
		AND CURDATE() between    DateFrom and DateTo ")->row_array();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}
		}
	}
	///////////check_group_permission
	public function check_group_permission_type( $UserID = 0 )
	{
		
		$query = $this->db->query("
		SELECT
		employee.PerType ,
		employee.Type ,
		employee.Branch , 
		permission_group.SchoolID , 
		group_page.PermissioView , 
		group_page.PermissionAdd , 
		group_page.PermissionEdit , 
		group_page.PermissionDelete 
		FROM 
		group_page 
		INNER JOIN permission_group ON group_page.GroupID = permission_group.ID
		INNER JOIN contact  ON permission_group.ID = contact.GroupID
		INNER JOIN employee ON contact.ID = employee.Contact_ID  
		where contact.ID = '".$UserID."' AND  contact.Isactive = 1 ")->row_array(); 
		if(sizeof($query)> 0 ){return $query;}
		else
		{
		$query = $this->db->query("
		SELECT
		user_permission.PerType ,
		user_permission.Type ,
		user_permission.PermissioView , 
		user_permission.PermissionAdd , 
		user_permission.PermissionEdit , 
		user_permission.PermissionDelete 
		FROM 
	    user_permission 
		where 
		user_permission.EmpID = '".$UserID."' 
		AND CURDATE() between    DateFrom and DateTo ")->row_array();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}
		}
	}
	/////////////////////////get_emp_group_level
	public function get_emp_group_level( $Lang = NULL ,  $PerType = 0)
	{
if(empty( $PerType)){ $PerType = 0 ; }
        $PerType_last_char = substr($PerType, -1);
        if($PerType_last_char==','){
           $PerType = substr($PerType, 0, -1); 
        }
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT
		 contact.ID       AS ContactID , 
		 contact.Name     AS ContactName , 
		 level.ID         AS LevelID,
		 row.ID           AS RowID,
		 class.ID         AS ClassID,
		 level.".$Name."  AS LevelName,
		 row.".$Name."    AS RowName,
		 row_level.ID     As RowLevelID ,
		 class.ID         As ClassID ,
		 class.".$Name."  AS ClassName
		 FROM 
		 class_table
		 INNER JOIN base_class_table ON class_table.BaseTableID = base_class_table.ID
		 INNER JOIN class            ON class_table.ClassID     = class.ID
		 INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
		 INNER JOIN row              ON row_level.Row_ID        = row.ID
		 INNER JOIN level            ON row_level.Level_ID      = level.ID
		 INNER JOIN contact          ON contact.ID              = class_table.EmpID
		 WHERE contact.SchoolID = '".$this->session->userdata('SchoolID')."'
		 AND  contact.Isactive = 1
		 AND level.ID IN (".$PerType.")
		 GROUP BY contact.ID
		 ")->result();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}
	}
	public function get_level_per_helper($Lang = NULL , $PerType = NULL )
	{
		//exit($PerType);
        if(empty( $PerType)){ $PerType = 0 ; }
         $PerType_last_char = substr($PerType, -1);
        if($PerType_last_char==','){
           $PerType = substr($PerType, 0, -1); 
        }
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT
		 level.ID         AS ID ,
		 level.".$Name."  AS Name 
		 FROM 
		 row_level
		 INNER JOIN row              ON row_level.Row_ID        = row.ID
		 INNER JOIN level            ON row_level.Level_ID      = level.ID
		 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = '".$this->session->userdata('SchoolID')."' 
		 WHERE level.Is_Active = 1  AND  level.ID IN (".$PerType.")  GROUP BY  level.ID 
		")->result();
		if(sizeof($query)>0){return $query ; }else{return FALSE ; }
	}
	////////////////get_emp_group_rowlevel
	public function get_emp_group_rowlevel($Lang = NULL ,  $PerType = 0)
	{
if(empty( $PerType)){ $PerType = 0 ; }
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		 $PerType_last_char = substr($PerType, -1);
        if($PerType_last_char==','){
           $PerType = substr($PerType, 0, -1); 
        }
		$query = $this->db->query("
		 SELECT
		 contact.ID       AS ContactID , 
		 contact.Name     AS ContactName , 
		 level.ID         AS LevelID,
		 row.ID           AS RowID,
		 class.ID         AS ClassID,
		 level.".$Name."  AS LevelName,
		 row.".$Name."    AS RowName,
		 row_level.ID     As RowLevelID ,
		 class.ID         As ClassID ,
		 class.".$Name."  AS ClassName
		 FROM 
		 class_table
		 INNER JOIN base_class_table ON class_table.BaseTableID = base_class_table.ID
		 INNER JOIN class            ON class_table.ClassID     = class.ID
		 INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
		 INNER JOIN row              ON row_level.Row_ID        = row.ID
		 INNER JOIN level            ON row_level.Level_ID      = level.ID
		 INNER JOIN contact          ON contact.ID              = class_table.EmpID
		 WHERE contact.SchoolID = '".$this->session->userdata('SchoolID')."'
		 AND  contact.Isactive = 1
		 AND row_level.ID IN (".$PerType.")
		 GROUP BY contact.ID
		 ")->result();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}
	}
	////////////////get_emp_group_class
	public function get_emp_group_class($Lang = NULL ,  $RowLevel = 0  , $Class = 0 )
	{
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		 $RowLevel_last_char = substr($RowLevel, -1);
        if($RowLevel_last_char==','){
           $RowLevel = substr($RowLevel, 0, -1); 
        }
		 $Class_last_char = substr($Class, -1);
        if($Class_last_char==','){
           $Class = substr($Class, 0, -1); 
        }
		$query = $this->db->query("
		 SELECT
		 contact.ID       AS ContactID , 
		 contact.Name     AS ContactName , 
		 level.ID         AS LevelID,
		 row.ID           AS RowID,
		 class.ID         AS ClassID,
		 level.".$Name."  AS LevelName,
		 row.".$Name."    AS RowName,
		 row_level.ID     As RowLevelID ,
		 class.ID         As ClassID ,
		 class.".$Name."  AS ClassName
		 FROM 
		 class_table
		 INNER JOIN base_class_table ON class_table.BaseTableID = base_class_table.ID
		 INNER JOIN class            ON class_table.ClassID     = class.ID
		 INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
		 INNER JOIN row              ON row_level.Row_ID        = row.ID
		 INNER JOIN level            ON row_level.Level_ID      = level.ID
		 INNER JOIN contact          ON contact.ID              = class_table.EmpID
         WHERE contact.SchoolID = '".$this->session->userdata('SchoolID')."'
		 AND  contact.Isactive = 1
		 AND row_level.ID IN (".$RowLevel.")
		 AND class.ID IN (".$Class.")
		 GROUP BY contact.ID
		 ")->result();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}
	}////////////////get_emp_group_subject
	public function get_emp_group_subject($Lang = NULL , $PerType = 0)
	{
if(empty( $PerType)){ $PerType = 0 ; }
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		 $PerType_last_char = substr($PerType, -1);
        if($PerType_last_char==','){
           $PerType = substr($PerType, 0, -1); 
        }
		$query = $this->db->query("
		 SELECT
		 contact.ID       AS ContactID , 
		 contact.Name     AS ContactName , 
		 level.ID         AS LevelID,
		 row.ID           AS RowID,
		 class.ID         AS ClassID,
		 level.".$Name."  AS LevelName,
		 row.".$Name."    AS RowName,
		 row_level.ID     As RowLevelID ,
		 class.ID         As ClassID ,
		 class.".$Name."  AS ClassName , 
		 subject.Name     AS SubjectName
		 FROM 
		 class_table
		 INNER JOIN base_class_table ON class_table.BaseTableID  = base_class_table.ID
		 INNER JOIN class            ON class_table.ClassID      = class.ID
		 INNER JOIN row_level        ON class_table.RowLevelID   = row_level.ID
		 INNER JOIN row              ON row_level.Row_ID         = row.ID
		 INNER JOIN level            ON row_level.Level_ID       = level.ID
		 INNER JOIN contact          ON contact.ID               = class_table.EmpID
		 INNER JOIN config_subject   ON config_subject.SubjectID = class_table.SubjectID
		 AND   config_subject.RowLevelID = class_table.RowLevelID
		 INNER JOIN subject   ON config_subject.SubjectID = subject.ID
		 WHERE contact.SchoolID = '".$this->session->userdata('SchoolID')."'
		 AND  contact.Isactive = 1
		 AND  config_subject.ID IN (".$PerType.")
		 GROUP BY contact.ID
		 ")->result();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}
	}
  public function get_all_student($Lang = NULL )
  {
	  $NameArray = array("Level"=>"Name AS LevelName" ,"row"=>"Name AS RowName" , "class"=>"Name AS ClassName");
		if($Lang == "english")
		{
			$NameArray = array("Level"=>"Name_en AS LevelName" ,"row"=>" Name_en AS RowName" , "class"=>"Name_en AS ClassName");
		}
		$query = $this->db->query("
			 SELECT
			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
			 level.".$NameArray['Level'].",
			 row.".$NameArray['row'].",
			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
			 class.".$NameArray['class']." ,
			 tb1.ID    AS StudentID,
			 tb1.Token AS StudentToken,
			 tb1.Name  AS StudentName,
			 tb2.ID    AS FatherID ,
			 tb2.Token AS FatherToken ,
		     tb2.Name  AS FatherName ,
			 CONCAT(tb1.Name,' ',tb2.Name) AS FullName
			 FROM contact As tb1
			 INNER JOIN student ON tb1.ID = student.Contact_ID
			 INNER JOIN contact AS tb2 ON student.Father_ID     = tb2.ID
			 INNER JOIN class            ON student.Class_ID    = class.ID
			 INNER JOIN row_level        ON student.R_L_ID      = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID    = row.ID
			 INNER JOIN level            ON row_level.Level_ID  = level.ID
			 WHERE tb1.SchoolID = '".$this->session->userdata('SchoolID')."'
			 AND tb1.Isactive = 1 AND tb2.Isactive = 1
			 ORDER BY tb1.Name
			 
			");
			if($query->num_rows()>0)
			{
			   return $query->result();	
			}else{return false ;}

  }
  public function get_level_student($Lang = NULL ,  $PerType = NULL )
  {
if(empty( $PerType)){ $PerType = 0 ; }
	 $PerType_last_char = substr($PerType, -1);
        if($PerType_last_char==','){
           $PerType = substr($PerType, 0, -1); 
        }
	  $NameArray = array("Level"=>"Name AS LevelName" ,"row"=>"Name AS RowName" , "class"=>"Name AS ClassName");
		if($Lang == "english")
		{
			$NameArray = array("Level"=>"Name_en AS LevelName" ,"row"=>" Name_en AS RowName" , "class"=>"Name_en AS ClassName");
		}
		$query = $this->db->query("
			 SELECT
			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
			 level.".$NameArray['Level'].",
			 row.".$NameArray['row'].",
			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
			 class.".$NameArray['class']." ,
			 tb1.ID    AS StudentID,
			 tb1.Token AS StudentToken,
			 tb1.Name  AS StudentName,
			 tb2.ID    AS FatherID ,
			 tb2.Token AS FatherToken ,
		     tb2.Name  AS FatherName ,
			 CONCAT(tb1.Name,' ',tb2.Name) AS FullName
			 FROM contact As tb1
			 INNER JOIN student ON tb1.ID = student.Contact_ID
			 INNER JOIN contact AS tb2 ON student.Father_ID     = tb2.ID
			 INNER JOIN class            ON student.Class_ID    = class.ID
			 INNER JOIN row_level        ON student.R_L_ID      = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID    = row.ID
			 INNER JOIN level            ON row_level.Level_ID  = level.ID
			 WHERE tb1.SchoolID = '".$this->session->userdata('SchoolID')."'
			 AND level.ID IN (".$PerType.")
			 AND tb1.Isactive = 1 AND tb2.Isactive = 1
			 ORDER BY tb1.Name
			 
			");
		
			if($query->num_rows()>0)
			{
			   return $query->result();	
			}else{return false ;}

  }
  /////////////////get_rowlevel_student
   public function get_rowlevel_student($Lang = NULL ,  $PerType = NULL )
  {
if(empty( $PerType)){ $PerType = 0 ; }
 $PerType_last_char = substr($PerType, -1);
        if($PerType_last_char==','){
           $PerType = substr($PerType, 0, -1); 
        }
	  $NameArray = array("Level"=>"Name AS LevelName" ,"row"=>"Name AS RowName" , "class"=>"Name AS ClassName");
		if($Lang == "english")
		{
			$NameArray = array("Level"=>"Name_en AS LevelName" ,"row"=>" Name_en AS RowName" , "class"=>"Name_en AS ClassName");
		}
		$query = $this->db->query("
			 SELECT
			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
			 level.".$NameArray['Level'].",
			 row.".$NameArray['row'].",
			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
			 class.".$NameArray['class']." ,
			 tb1.ID    AS StudentID,
			 tb1.Token AS StudentToken,
			 tb1.Name  AS StudentName,
			 tb2.ID    AS FatherID ,
			 tb2.Token AS FatherToken ,
		     tb2.Name  AS FatherName ,
			 CONCAT(tb1.Name,' ',tb2.Name) AS FullName
			 FROM contact As tb1
			 INNER JOIN student ON tb1.ID = student.Contact_ID
			 INNER JOIN contact AS tb2 ON student.Father_ID     = tb2.ID
			 INNER JOIN class            ON student.Class_ID    = class.ID
			 INNER JOIN row_level        ON student.R_L_ID      = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID    = row.ID
			 INNER JOIN level            ON row_level.Level_ID  = level.ID
			 WHERE tb1.SchoolID = '".$this->session->userdata('SchoolID')."'
			 AND row_level.ID IN (".$PerType.")
			 AND tb1.Isactive = 1 AND tb2.Isactive = 1
			 ORDER BY tb1.Name
			 
			");
			if($query->num_rows()>0)
			{
			   return $query->result();	
			}else{return false ;}

  } 
   /////////////////get_student_group_class
   public function get_student_group_class($Lang = NULL ,  $PerType = NULL )
  {
if(empty( $PerType)){ $PerType = 0 ; }
 $PerType_last_char = substr($PerType, -1);
        if($PerType_last_char==','){
           $PerType = substr($PerType, 0, -1); 
        }
        $Class_last_char = substr($Class, -1);
        if($Class_last_char==','){
           $Class = substr($Class, 0, -1); 
        }
	  $NameArray = array("Level"=>"Name AS LevelName" ,"row"=>"Name AS RowName" , "class"=>"Name AS ClassName");
		if($Lang == "english")
		{
			$NameArray = array("Level"=>"Name_en AS LevelName" ,"row"=>" Name_en AS RowName" , "class"=>"Name_en AS ClassName");
		}
		$query = $this->db->query("
			 SELECT
			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
			 level.".$NameArray['Level'].",
			 row.".$NameArray['row'].",
			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
			 class.".$NameArray['class']." ,
			 tb1.ID    AS StudentID,
			 tb1.Token AS StudentToken,
			 tb1.Name  AS StudentName,
			 tb2.ID    AS FatherID ,
			 tb2.Token AS FatherToken ,
		     tb2.Name  AS FatherName ,
			 CONCAT(tb1.Name,' ',tb2.Name) AS FullName
			 FROM contact As tb1
			 INNER JOIN student ON tb1.ID = student.Contact_ID
			 INNER JOIN contact AS tb2 ON student.Father_ID     = tb2.ID
			 INNER JOIN class            ON student.Class_ID    = class.ID
			 INNER JOIN row_level        ON student.R_L_ID      = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID    = row.ID
			 INNER JOIN level            ON row_level.Level_ID  = level.ID
			 
			 WHERE tb1.SchoolID = '".$this->session->userdata('SchoolID')."'
			 AND row_level.ID IN (".$PerType.")
			 AND class.ID IN (".$Class.")
			 AND tb1.Isactive = 1 AND tb2.Isactive = 1
			 ORDER BY tb1.Name
			 
			");
			if($query->num_rows()>0)
			{
			   return $query->result();	
			}else{return false ;}
  }
  /////////////////get_student_group_subject
   public function get_student_group_subject($Lang = NULL ,  $RowLevel = 0  , $Class = 0 )
  {
       $PerType_last_char = substr($PerType, -1);
        if($PerType_last_char==','){
           $PerType = substr($PerType, 0, -1); 
        }
	  $NameArray = array("Level"=>"Name AS LevelName" ,"row"=>"Name AS RowName" , "class"=>"Name AS ClassName");
		if($Lang == "english")
		{
			$NameArray = array("Level"=>"Name_en AS LevelName" ,"row"=>" Name_en AS RowName" , "class"=>"Name_en AS ClassName");
		}
		$query = $this->db->query("
			 SELECT
			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
			 level.".$NameArray['Level'].",
			 row.".$NameArray['row'].",
			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
			 class.".$NameArray['class']." ,
			 tb1.ID    AS StudentID,
			 tb1.Token AS StudentToken,
			 tb1.Name  AS StudentName,
			 tb2.ID    AS FatherID ,
			 tb2.Token AS FatherToken ,
		     tb2.Name  AS FatherName ,
			 CONCAT(tb1.Name,' ',tb2.Name) AS FullName , 
			 subject.Name     AS SubjectName
			 FROM contact As tb1
			 
			 INNER JOIN student ON tb1.ID = student.Contact_ID
			 INNER JOIN contact AS tb2 ON student.Father_ID     = tb2.ID
			 INNER JOIN class            ON student.Class_ID    = class.ID
			 INNER JOIN row_level        ON student.R_L_ID      = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID    = row.ID
			 INNER JOIN level            ON row_level.Level_ID  = level.ID
			 INNER JOIN class_table ON class_table.RowLevelID = student.R_L_ID AND class_table.ClassID = student.Class_ID
			 INNER JOIN config_subject   ON config_subject.SubjectID = class_table.SubjectID
		     AND   config_subject.RowLevelID = class_table.RowLevelID
		     INNER JOIN subject   ON config_subject.SubjectID = subject.ID
			 WHERE tb1.SchoolID = '".$this->session->userdata('SchoolID')."'
			 AND config_subject.ID IN (".$PerType.")
			 AND tb1.Isactive = 1 AND tb2.Isactive = 1
			 GROUP BY tb1.ID
			 ORDER BY tb1.Name
			 
			");
			if($query->num_rows()>0)
			{
			   return $query->result();	
			}else{return false ;}
  }
  
  ///////////////////////copy_group_page
  public function copy_group_page($GroupID = 0 , $CopyGroupID = 0 )
  {
	  $query = $this->db->query("SELECT * FROM permission_group WHERE ID ='".$CopyGroupID."'")->row_array();
	  if(sizeof($query )> 0 )
	  {
		 $ArrayUpdate = array(
		 "Branch"=>$query['Branch'] ,
		 "SchoolID"=>$query['SchoolID'] ,
		 "PerType"=>$query['PerType'] ,
		 "Type"=>$query['Type'] 
		 ) ; 
		 
		 $this->db->where('ID',$GroupID);
		 $this->db->update('permission_group',$ArrayUpdate);
		 $this->db->query("DELETE  FROM group_page WHERE GroupID ='".$GroupID."'");
		 $query = $this->db->query("SELECT * FROM group_page WHERE GroupID ='".$CopyGroupID."'")->result();
		// print_r($query);exit;
      if(sizeof($query )> 0 )
	  {
		  foreach($query as  $Key=>$row)
		  {
			 $ArrayInsert = array(
			 "GroupID"           =>$GroupID ,
			 "PageID"            =>$row->PageID ,
			 "PermissioView"     =>$row->PermissioView ,
			 "PermissionAdd"     =>$row->PermissionAdd ,
			 "PermissionEdit"    =>$row->PermissionEdit ,
			 "PermissionDelete"  =>$row->PermissionDelete,
			 ) ; 
		     $this->db->insert('group_page', $ArrayInsert); 
		  }
		 
		 return TRUE ;
	  }else{return FALSE ;}   
	  }else{return FALSE ;}
  }
  /////////////////add_group_emp 
  public function add_group_emp($data = array() )
  {
	  $this->db->query("UPDATE contact SET  GroupID = '".$data['GroupID']."' WHERE ID ='".$data['EmpID']."'");
	  $this->db->query("UPDATE employee SET PerType = '".$data['PerType']."' , Branch = '".$data['Branch']."' , Type = '".$data['Type']."' WHERE Contact_ID ='".$data['EmpID']."'"); 
  }
  /////////////////remove_emp_permission 
  public function remove_emp_permission($userID )
  {
	  $this->db->query("UPDATE contact SET  GroupID = 0 WHERE ID ='".$userID."'"); 
	  $this->db->query("UPDATE employee SET PerType = null , Branch = null , Type = 0  WHERE Contact_ID ='".$userID."'"); 
  }
  //////////////get_branches_per_helper
public function get_branches_per_helper($Lang = NULL , $Branch = NULL )
	{
if(empty($Branch)){$Branch = 0 ;}
		$Name = 'SchoolName' ; 
		if($Lang == 'english'){$Name = 'SchoolNameEn' ;}
		$query = $this->db->query("SELECT ID ,".$Name." as Name FROM school_details WHERE ID IN (".$Branch.") ")->result();
		if(sizeof($query)>0)
		{
			return $query ;
		}else{

			return false ;
		}
	} 
public function get_branches($Lang = NULL   )
	{
if(empty($Branch)){$Branch = 0 ;}
		$Name = 'SchoolName' ; 
		if($Lang == 'english'){$Name = 'SchoolNameEn' ;}
		$query = $this->db->query("SELECT ID ,".$Name." as Name FROM school_details   ")->result();
		if(sizeof($query)>0)
		{
			return $query ;
		}else{

			return false ;
		}


	}
	////////////////////////get_emp_by_id
	public function get_emp_by_id($EmpID = 0 )
	{
		$query = $this->db->query("SELECT 
		employee.PerType ,
		employee.Branch ,
		employee.Type ,
		contact.Name AS ContactName ,
		permission_group.Name AS GroupName   
		FROM
		employee
		INNER JOIN contact ON employee.Contact_ID = contact.ID
		LEFT  JOIN permission_group ON contact.GroupID = permission_group.ID
		WHERE employee.Contact_ID = '".$EmpID."' AND  contact.Isactive = 1  ")->row_array();
		if(sizeof($query)>0)
		{
			return $query ;
		}else{

			return false ;
		}
	}
	
	/********************************Msg Student********************************************************/
	public function get_level_student_message($Lang = NULL ,  $PerType = NULL )
  {
if(empty( $PerType)){ $PerType = 0 ; }
 $PerType_last_char = substr($PerType, -1);
        if($PerType_last_char==','){
           $PerType = substr($PerType, 0, -1); 
        }
	  $NameArray = array("Level"=>"Name AS level" ,"row"=>"Name AS row" , "class"=>"Name AS className");
		if($Lang == "english")
		{
			$NameArray = array("Level"=>"Name_en AS level" ,"row"=>" Name_en AS row" , "class"=>"Name_en AS className");
		}
		$query = $this->db->query("
			 SELECT
			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
			 level.".$NameArray['Level'].",
			 row.".$NameArray['row'].",
			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
			 class.".$NameArray['class']." ,
			 tb1.ID    AS contactID,
			 tb1.Token AS StudentToken,
			 tb1.Name  AS StudentName,
			 tb2.ID    AS FatherID ,
			 tb2.Token AS FatherToken ,
		     tb2.Name  AS FatherName ,
			 CONCAT(tb1.Name,' ',tb2.Name) AS Name
			 FROM contact As tb1
			 INNER JOIN student ON tb1.ID = student.Contact_ID
			 INNER JOIN contact AS tb2 ON student.Father_ID     = tb2.ID
			 INNER JOIN class            ON student.Class_ID    = class.ID
			 INNER JOIN row_level        ON student.R_L_ID      = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID    = row.ID
			 INNER JOIN level            ON row_level.Level_ID  = level.ID
			 WHERE tb1.SchoolID = '".$this->session->userdata('SchoolID')."'
			 AND tb1.Isactive = 1 AND tb2.Isactive = 1
			 AND level.ID IN (".$PerType.")
			 ORDER BY tb1.Name
			 
			");
			if($query->num_rows()>0)
			{
			   return $query->result();	
			}else{return false ;}

  }
  /////////////////get_rowlevel_student
   public function get_rowlevel_student_message($Lang = NULL ,  $PerType = NULL )
  {
if(empty( $PerType)){ $PerType = 0 ; }
 $PerType_last_char = substr($PerType, -1);
        if($PerType_last_char==','){
           $PerType = substr($PerType, 0, -1); 
        }
	  $NameArray = array("Level"=>"Name AS level" ,"row"=>"Name AS row" , "class"=>"Name AS className");
		if($Lang == "english")
		{
			$NameArray = array("Level"=>"Name_en AS level" ,"row"=>" Name_en AS row" , "class"=>"Name_en AS className");
		}
		$query = $this->db->query("
			 SELECT
			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
			 level.".$NameArray['Level'].",
			 row.".$NameArray['row'].",
			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
			 class.".$NameArray['class']." ,
			 tb1.ID    AS contactID,
			 tb1.Token AS StudentToken,
			 tb1.Name  AS StudentName,
			 tb2.ID    AS FatherID ,
			 tb2.Token AS FatherToken ,
		     tb2.Name  AS FatherName ,
			 CONCAT(tb1.Name,' ',tb2.Name) AS Name
			 FROM contact As tb1
			 INNER JOIN student ON tb1.ID = student.Contact_ID
			 INNER JOIN contact AS tb2 ON student.Father_ID     = tb2.ID
			 INNER JOIN class            ON student.Class_ID    = class.ID
			 INNER JOIN row_level        ON student.R_L_ID      = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID    = row.ID
			 INNER JOIN level            ON row_level.Level_ID  = level.ID
			 WHERE tb1.SchoolID = '".$this->session->userdata('SchoolID')."'
			 AND tb1.Isactive = 1 AND tb2.Isactive = 1 
			 AND row_level.ID IN (".$PerType.")
			 ORDER BY tb1.Name
			 
			");
			if($query->num_rows()>0)
			{
			   return $query->result();	
			}else{return false ;}

  } 
   /////////////////get_student_group_class
   public function get_student_group_class_message($Lang = NULL ,  $PerType = NULL )
  {
if(empty( $PerType)){ $PerType = 0 ; }
 $PerType_last_char = substr($PerType, -1);
        if($PerType_last_char==','){
           $PerType = substr($PerType, 0, -1); 
        }
	  $NameArray = array("Level"=>"Name AS level" ,"row"=>"Name AS row" , "class"=>"Name AS className");
		if($Lang == "english")
		{
			$NameArray = array("Level"=>"Name_en AS level" ,"row"=>" Name_en AS row" , "class"=>"Name_en AS className");
		}
		$query = $this->db->query("
			 SELECT
			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
			 level.".$NameArray['Level'].",
			 row.".$NameArray['row'].",
			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
			 class.".$NameArray['class']." ,
			 tb1.ID    AS contactID,
			 tb1.Token AS StudentToken,
			 tb1.Name  AS StudentName,
			 tb2.ID    AS FatherID ,
			 tb2.Token AS FatherToken ,
		     tb2.Name  AS FatherName ,
			 CONCAT(tb1.Name,' ',tb2.Name) AS Name
			 FROM contact As tb1
			 INNER JOIN student ON tb1.ID = student.Contact_ID
			 INNER JOIN contact AS tb2 ON student.Father_ID     = tb2.ID
			 INNER JOIN class            ON student.Class_ID    = class.ID
			 INNER JOIN row_level        ON student.R_L_ID      = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID    = row.ID
			 INNER JOIN level            ON row_level.Level_ID  = level.ID
			 
			 WHERE tb1.SchoolID = '".$this->session->userdata('SchoolID')."'
			 AND row_level.ID IN (".$PerType.")
			 AND class.ID IN (".$Class.")
			 AND tb1.Isactive = 1 AND tb2.Isactive = 1
			 ORDER BY tb1.Name
			 
			");
			if($query->num_rows()>0)
			{
			   return $query->result();	
			}else{return false ;}
  }
  /////////////////get_student_group_subject
   public function get_student_group_subject_message($Lang = NULL ,  $RowLevel = 0  , $Class = 0 )
  {
	  $NameArray = array("Level"=>"Name AS level" ,"row"=>"Name AS row" , "class"=>"Name AS className");
		if($Lang == "english")
		{
			$NameArray = array("Level"=>"Name_en AS level" ,"row"=>" Name_en AS row" , "class"=>"Name_en AS className");
		}
		$query = $this->db->query("
			 SELECT
			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
			 level.".$NameArray['Level'].",
			 row.".$NameArray['row'].",
			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
			 class.".$NameArray['class']." ,
			 tb1.ID    AS contactID,
			 tb1.Token AS StudentToken,
			 tb1.Name  AS StudentName,
			 tb2.ID    AS FatherID ,
			 tb2.Token AS FatherToken ,
		     tb2.Name  AS FatherName ,
			 CONCAT(tb1.Name,' ',tb2.Name) AS Name , 
			 subject.Name     AS SubjectName
			 FROM contact As tb1
			 
			 INNER JOIN student ON tb1.ID = student.Contact_ID
			 INNER JOIN contact AS tb2 ON student.Father_ID     = tb2.ID
			 INNER JOIN class            ON student.Class_ID    = class.ID
			 INNER JOIN row_level        ON student.R_L_ID      = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID    = row.ID
			 INNER JOIN level            ON row_level.Level_ID  = level.ID
			 INNER JOIN class_table ON class_table.RowLevelID = student.R_L_ID AND class_table.ClassID = student.Class_ID
			 INNER JOIN config_subject   ON config_subject.SubjectID = class_table.SubjectID
		     AND   config_subject.RowLevelID = class_table.RowLevelID
		     INNER JOIN subject   ON config_subject.SubjectID = subject.ID
			 WHERE tb1.SchoolID = '".$this->session->userdata('SchoolID')."'
			 AND config_subject.ID IN (".$PerType.")
			 AND tb1.Isactive = 1 AND tb2.Isactive = 1
			 GROUP BY tb1.ID
			 ORDER BY tb1.Name
			 
			");
			if($query->num_rows()>0)
			{
			   return $query->result();	
			}else{return false ;}
  }
  //////////////////////////////////////////////////////////////////////
  public function get_all_student_message($Lang = NULL )
  {
	  $NameArray = array("Level"=>"Name AS level" ,"row"=>"Name AS row" , "class"=>"Name AS className");
		if($Lang == "english")
		{
			$NameArray = array("Level"=>"Name_en AS level" ,"row"=>" Name_en AS row" , "class"=>"Name_en AS className");
		}
		$query = $this->db->query("
			 SELECT
			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
			 level.".$NameArray['Level'].",
			 row.".$NameArray['row'].",
			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
			 class.".$NameArray['class']." ,
			 tb1.ID    AS contactID,
			 tb1.Token AS StudentToken,
			 tb1.Name  AS StudentName,
			 tb2.ID    AS FatherID ,
			 tb2.Token AS FatherToken ,
		     tb2.Name  AS FatherName ,
			 CONCAT(tb1.Name,' ',tb2.Name) AS Name
			 FROM contact As tb1
			 INNER JOIN student ON tb1.ID = student.Contact_ID
			 INNER JOIN contact AS tb2 ON student.Father_ID     = tb2.ID
			 INNER JOIN class            ON student.Class_ID    = class.ID
			 INNER JOIN row_level        ON student.R_L_ID      = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID    = row.ID
			 INNER JOIN level            ON row_level.Level_ID  = level.ID
			 WHERE tb1.SchoolID = '".$this->session->userdata('SchoolID')."'
			 AND tb2.Isactive = 1 AND tb1.Isactive = 1
			 ORDER BY tb1.Name
			 
			");
			if($query->num_rows()>0)
			{
			   return $query->result();	
			}else{return false ;}

  }
  ///////////////////////////////////////////////////////////
  /////// get_row_level_per_level
	public function get_row_level_per_level($Lang = NULL , $PerType = 0 )
	{
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT
		 level.ID         AS LevelID ,
		 row.ID           AS RowID ,
		 level.".$Name."  AS LevelName ,
		 row.".$Name."    AS RowName ,
		 row_level.ID     As RowLevelID 
		 FROM 
		 row_level
		 INNER JOIN row              ON row_level.Row_ID        = row.ID
		 INNER JOIN level            ON row_level.Level_ID      = level.ID
		 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = '".$this->session->userdata('SchoolID')."' 
		 WHERE level.Is_Active = 1  AND  level.ID IN (".$PerType.")
		 ")->result();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}
	}
	
	 /////// get_row_level_per_row
	public function get_row_level_per_row($Lang = NULL , $PerType = 0 )
	{
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT
		 level.ID         AS LevelID ,
		 row.ID           AS RowID ,
		 level.".$Name."  AS LevelName ,
		 row.".$Name."    AS RowName ,
		 row_level.ID     As RowLevelID 
		 FROM 
		 row_level
		 INNER JOIN row              ON row_level.Row_ID        = row.ID
		 INNER JOIN level            ON row_level.Level_ID      = level.ID
		 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = '".$this->session->userdata('SchoolID')."' 
		 WHERE level.Is_Active = 1  AND  row_level.ID IN (".$PerType.")
		 ")->result();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}
	}
  /////////////////get_class_per_level/////////////////
  public function get_class_per_level($Lang = NULL , $PerType = 0)
	{
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		////////////////////////////////////////////////////////////////////////////////
		$query = $this->db->query("
		     SELECT
 			 level.ID         AS LevelID,
			 row.ID           AS RowID,
			 class.ID         AS ClassID,
			 level.".$Name."  AS LevelName ,
		     row.".$Name."    AS RowName ,
			 row_level.ID     As RowLevelID ,
			 class.".$Name."  AS ClassName
			 FROM
			 student
 			 INNER JOIN contact            ON student.Contact_ID  = contact.ID
 			 INNER JOIN class            ON student.Class_ID  = class.ID
			 INNER JOIN row_level        ON student.R_L_ID    = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID        = row.ID
			 INNER JOIN level            ON row_level.Level_ID      = level.ID
		     INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = '".$this->session->userdata('SchoolID')."' 
		     WHERE level.Is_Active = 1  AND  level.ID IN (".$PerType.") AND contact.SchoolID = '".$this->session->userdata('SchoolID')."'
		 group by student.`Class_ID` ,student.R_L_ID order by student.R_L_ID  ;
			")->result();
		if(sizeof($query)>0)
		{
			return $query ;
		}else{

			return false ;
		}
	}
  
  /////////////////get_class_per_row_level/////////////////
  public function get_class_per_row_level($Lang = NULL , $PerType = 0)
	{
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		////////////////////////////////////////////////////////////////////////////////
		$query = $this->db->query("
		     SELECT
 			 level.ID         AS LevelID,
			 row.ID           AS RowID,
			 class.ID         AS ClassID,
			 level.".$Name."  AS LevelName ,
		     row.".$Name."    AS RowName ,
			 row_level.ID     As RowLevelID ,
			 class.".$Name."  AS ClassName
			 from student
 			 INNER JOIN contact         ON student.Contact_ID  = contact.ID
			 INNER JOIN class            ON student.Class_ID    = class.ID
			 INNER JOIN row_level        ON student.R_L_ID  = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID        = row.ID
			 INNER JOIN level            ON row_level.Level_ID      = level.ID
		     INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = '".$this->session->userdata('SchoolID')."' 
		     WHERE level.Is_Active = 1  AND  row_level.ID  IN (".$PerType.")
			   AND contact.SchoolID = '".$this->session->userdata('SchoolID')."'
		 group by student.`Class_ID` ,student.R_L_ID order by student.R_L_ID  ;
			")->result();
		if(sizeof($query)>0)
		{
			return $query ;
		}else{

			return false ;
		}
	}
  
  /////////////////get_class_per_row_level/////////////////
  public function get_class_per_class($Lang = NULL , $RowLevel = 0  , $Class  = 0 )
	{
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		////////////////////////////////////////////////////////////////////////////////
		$query = $this->db->query("
		     SELECT
			 
			 level.ID         AS LevelID,
			 row.ID           AS RowID,
			 class.ID         AS ClassID,
			 level.".$Name."  AS LevelName ,
		     row.".$Name."    AS RowName ,
			 row_level.ID     As RowLevelID ,
			 class.".$Name."  AS ClassName
			from student
 			 INNER JOIN contact            ON student.Contact_ID  = contact.ID
			 INNER JOIN class            ON student.Class_ID     = class.ID
			 INNER JOIN row_level        ON student.R_L_ID  = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID        = row.ID
			 INNER JOIN level            ON row_level.Level_ID      = level.ID
		     INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = '".$this->session->userdata('SchoolID')."' 
		     WHERE level.Is_Active = 1  AND  row_level.ID  = '".$RowLevel."' AND class.ID = '".$Class."'  
			AND contact.SchoolID = '".$this->session->userdata('SchoolID')."'
		 group by student.`Class_ID` ,student.R_L_ID order by student.R_L_ID  ; 
			")->result();
		if(sizeof($query)>0)
		{
			return $query ;
		}else{

			return false ;
		}
	}
   /////////////////get_class_per/////////////////
  public function get_class_per($Lang = NULL , $PerType = 0)
	{
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		////////////////////////////////////////////////////////////////////////////////
		$query = $this->db->query("
		     select 
			 level.ID         AS LevelID,
			 row.ID           AS RowID,
			 class.ID         AS ClassID,
			 level.".$Name."  AS LevelName ,
		     row.".$Name."    AS RowName ,
			 row_level.ID     As RowLevelID ,
			 class.".$Name."  AS ClassName
             from student
 			 INNER JOIN contact            ON student.Contact_ID  = contact.ID
		     INNER JOIN class            ON student.Class_ID = class.ID
			 INNER JOIN row_level        ON student.R_L_ID  = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID        = row.ID
			 INNER JOIN level            ON row_level.Level_ID      = level.ID
		     INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = '".$this->session->userdata('SchoolID')."' 
		     WHERE level.Is_Active = 1    AND contact.SchoolID = '".$this->session->userdata('SchoolID')."'
		     GROUP BY  student.R_L_ID , student.Class_ID order by student.R_L_ID 
			")->result(); 

 
		if(sizeof($query)>0)
		{
			return $query ;
		}else{

			return false ;
		}
	} 
 }/////////END CLASS
?>
