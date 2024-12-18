<?php
class User_Permission_Model extends CI_Model
{
	private $Date            = '';
	private $Encryptkey      = '';
	private $Token           = '';
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
		$this->Token            = md5($this->Encryptkey . uniqid(mt_rand()) . microtime());
		return	$this->Token;
	}
	
	/////////////////////////////////////
	public function get_level($Lang = NULL)
	{
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		$query = $this->db->query("
		 SELECT
		 level.ID         AS ID ,
		 level." . $Name . "  AS Name 
		 FROM 
		 row_level
		 INNER JOIN row              ON row_level.Row_ID        = row.ID
		 INNER JOIN level            ON row_level.Level_ID      = level.ID
		 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = '" . $this->session->userdata('SchoolID') . "' 
		 WHERE level.Is_Active = 1  GROUP BY  level.ID 
		")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
	
	////////////////////get_user_per_by_id
	public function get_user_per_by_id($ID = 0)
	{
		$query1 = $this->db->query("select * from user_permission where EmpID = '" . $ID . "' ");
		$query = $query1->row_array();
		if ($query1->num_rows() > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
	
	/////// get_row_level_school
	public function get_row_level_school($Lang = NULL)
	{
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		$query = $this->db->query("
		 SELECT
		 level.ID         AS LevelID ,
		 row.ID           AS RowID ,
		 level." . $Name . "  AS LevelName ,
		 row." . $Name . "    AS RowName ,
		 row_level.ID     As RowLevelID 
		 FROM 
		 row_level
		 INNER JOIN row              ON row_level.Row_ID        = row.ID
		 INNER JOIN level            ON row_level.Level_ID      = level.ID
		 WHERE level.Is_Active = 1 
		 GROUP BY row_level.ID
		 ")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return  FALSE;
		}
	}
	//////////////////////////////////
	public function get_group_by_id($ID = 0)
	{
		$query = $this->db->query("select * from permission_group where ID = '" . $ID . "' ")->row_array();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
	//////get_emp
	public function get_emp($SchoolID = 0)
	{
		$GetData = $this->db->query("
		SELECT 
		contact.ID    AS ContactID,
		contact.Name  AS ContactName
		FROM 
		contact 
		WHERE contact.SchoolID = '" . $this->session->userdata('SchoolID') . "'
        AND  contact.Isactive = 1 AND contact.Type='E' 
        group by contact.ID
		");
		if ($GetData->num_rows() > 0) {
			return $GetData->result();
		} else {
			return FALSE;
		}
	}
	
	////get_page_permission
	public function get_page_permission()
	{
		$this->db->select('*');
		$this->db->from('permission_page');
		$this->db->where('IsActive', 1);
		$this->db->where('active_system', 1);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	} 
	////////////////////////////
	
	public function get_group()
	{
		$query = $this->db->query("select * from permission_group WHERE IsUpdate =  1   ")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
	
	////////////////////////

	public function del_group($id)
	{
		$query = $this->db->query("delete from permission_group WHERE ID =  $id   ");
		if ($query) {
			return true;
		} else {
			return FALSE;
		}
	}
	
	///////////////get_contact
	
	public function get_contact()
	{
		$School = 0;
		if ($this->session->userdata('type') == 'U') {
			$School = $this->session->userdata('SchoolID');
		} else {
			$school_array = $this->db->query("SELECT  permission_request.school_id FROM contact 
	        inner join  permission_request on contact.ID =  permission_request.EmpID
	        WHERE contact.ID	 = " . $this->session->userdata('id') . " ")->row_array();
			$School = $school_array['school_id'];
		}
	

		$query = $this->db->query("SELECT * FROM contact WHERE Type ='E' and Isactive = 1 and SchoolID IN($School) ")->result();
		return $query;
	}
	
	//////////get_school
	public function get_school()
	{
		$query = $this->db->query("select * from school_details  ")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
	
	////////////////////////get_emp_by_id
	public function get_emp_by_id($EmpID = 0)
	{
		$query = $this->db->query("SELECT 
		
		permission_request.school_id  as Branch,
		contact.Name AS ContactName ,
		permission_group.Name AS GroupName   ,
		permission_request.NameSpaceID,
		permission_request.ClassType,
		permission_request.StudyType,
		permission_request.Level,
		permission_request.Type
		FROM
		contact
		LEFT  JOIN permission_group    ON contact.GroupID = permission_group.ID
		LEFT  JOIN permission_request  ON permission_request.EmpID  = contact.ID
		WHERE permission_request.EmpID = '" . $EmpID . "' AND  contact.Isactive = 1  ")->row_array();
		if (sizeof($query) > 0) {
			return $query;
		} else {

			return false;
		}
	}
	
	//////////////////////
	public function get_request_type()
	{
		extract($data);

		$GetType = $this->db->query("SELECT `ID`, Name , Name_en, `is_active` FROM `request_type` WHERE is_active = 1");

		if ($GetType->num_rows() > 0) {
			return $GetType->result();
		} else {
			return FALSE;
		}
	}
	
	
	//////////////////////
	public function get_category()
	{

		$GetCategory = $this->db->query("SELECT `ID`, Name, Name_en, `is_active` FROM `category` WHERE is_active = 1");

		if ($GetCategory->num_rows() > 0) {
			return $GetCategory->result();
		} else {
			return FALSE;
		}
	}
	////////////////////////////////
	
		public function edit_group($Data = array())
	{
	    if($Data['ID']){
		$this->db->query("
        UPDATE permission_group
        SET
        Name          = '" . $Data['Name'] . "' ,
        Contact_ID    = '" . $Data['UID'] . "' ,
        SchoolID      = '" . $Data['SchoolID'] . "' ,
		IsUpdate      = '" . $Data['IsUpdate'] . "' ,
		IsAdmin       = '" . $Data['IsAdmin'] . "' 
        WHERE ID      = '" . $Data['ID'] . "'
         ");
	    }else{
	     $this->db->query("
        insert into permission_group
        SET
        Name          = '" . $Data['Name'] . "' ,
        Contact_ID    = '" . $Data['UID'] . "' ,
        SchoolID      = '" . $Data['SchoolID'] . "' ,
		IsUpdate      = 1 ,
		IsAdmin       = '" . $Data['IsAdmin'] . "' 
         ");  
	    }
		return TRUE;
	}
	
	///////////////////////////////////
	public function add_group_emp($data = array())
	{
		extract($data);
		$this->db->query("UPDATE contact SET  GroupID = '" . $GroupID . "' WHERE ID ='" . $EmpID . "'");
	
		if ($GroupID == 24 || ($GroupID == 18 &&  $reg_type!=0) ) {
			$Type = 2;
		} elseif ($GroupID == 18) {
			$Type = 3;
		} else {
			$Type = 0;
		}

		$query = $this->db->query("select * from permission_request where  EmpID='" . $EmpID . "'")->result();

		if (empty($query)) {
		
				$this->db->query("insert into permission_request SET  NameSpaceID = '" . $reg_type . "',EmpID ='" . $EmpID . "',school_id ='" . $Branch . "',
          Level ='" . $PerType . "',Type ='" . $Type . "'  , ClassType = '" . $class_type . "', StudyType = '" . $study_type . "' ");
		
		} else {
			
				$this->db->query("UPDATE permission_request SET  NameSpaceID = '" . $reg_type . "',school_id ='" . $Branch . "',
          Level ='" . $PerType . "',Type ='" . $Type . "' , ClassType = '" . $class_type . "', StudyType = '" . $study_type . "'  where EmpID ='" . $EmpID . "' ");
		
		}
		if ($update_emp) {
			return true;
		} else {
			return false;
		}
	}
	
	/////////////////remove_emp_permission 
	public function remove_emp_permission($userID)
	{
		$this->db->query("UPDATE contact SET  GroupID = 0 WHERE ID ='" . $userID . "'");
		$this->db->query("DELETE FROM `permission_request` WHERE  EmpID ='" . $userID . "'");
	}
	////////////////////////////////////////
	
	public function get_subject_rowlevel_id($id)
	{
		$this->db->select('class_table.SubjectID, class_table.SchoolID, class_table.RowLevelID, class_table.EmpID, subject.ID AS SubID, subject.Name AS SubName, subject.Name_en AS SubNameEn,row_level.Level_Name AS Levelname,row_level.Row_Name AS RowName');
		$this->db->from('class_table');
		$this->db->join('row_level', 'class_table.RowLevelID = row_level.ID');
		$this->db->join('subject', 'class_table.SubjectID = subject.ID');
		$this->db->where('class_table.RowLevelID', $id);
		$this->db->group_by('class_table.SubjectID');

		$query = $this->db->get();


		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	
	///////////////////delete_group_page
	public function delete_group_page($GetGroup = 0)
	{
		$this->db->query("DELETE FROM  group_page  where GroupID = '" . $GetGroup . "'  ");
	}
	
	/////////////////update_group_data
	public function update_group_data($Data = array())
	{
		$this->db->query("UPDATE permission_group SET PerType = '" . $Data['PerType'] . "' , Type =  '" . $Data['type'] . "' , Branch = '" . $Data['Branches'] . "' , IsAdmin = '" . $Data['IsAdmin'] . "' where ID = '" . $Data['GetGroup'] . "'  ");
	}
	
	///////////////////delete_group_page
	public function add_group_page($Data = array())
	{
		$this->db->query("INSERT INTO  group_page SET 
		
		GroupID          = '" . $Data['GetGroup'] . "' ,  
		PageID           = '" . $Data['PageID'] . "' ,
		PermissioView    = '" . $Data['ChkView'] . "' ,
		PermissionAdd    = '" . $Data['ChkAdd'] . "' ,
		PermissionEdit   = '" . $Data['ChkEdit'] . "' ,
		PermissionDelete = '" . $Data['ChkDel'] . "' ,
		ConID            = '" . $Data['UID'] . "' ,
		Date             = '" . $this->Date . "' 
		");
	}
	
	///////////////////////copy_group_page
	public function copy_group_page($GroupID = 0, $CopyGroupID = 0)
	{
		$query = $this->db->query("SELECT * FROM permission_group WHERE ID ='" . $CopyGroupID . "'")->row_array();
		if (sizeof($query) > 0) {
			$ArrayUpdate = array(
				"Branch" => $query['Branch'],
				"SchoolID" => $query['SchoolID'],
				"PerType" => $query['PerType'],
				"Type" => $query['Type']
			);

			$this->db->where('ID', $GroupID);
			$this->db->update('permission_group', $ArrayUpdate);
			$this->db->query("DELETE  FROM group_page WHERE GroupID ='" . $GroupID . "'");
			$query = $this->db->query("SELECT * FROM group_page WHERE GroupID ='" . $CopyGroupID . "'")->result();
			// print_r($query);exit;
			if (sizeof($query) > 0) {
				foreach ($query as  $Key => $row) {
					$ArrayInsert = array(
						"GroupID"           => $GroupID,
						"PageID"            => $row->PageID,
						"PermissioView"     => $row->PermissioView,
						"PermissionAdd"     => $row->PermissionAdd,
						"PermissionEdit"    => $row->PermissionEdit,
						"PermissionDelete"  => $row->PermissionDelete,
					);
					$this->db->insert('group_page', $ArrayInsert);
				}

				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	/////////////////////////////////////////////////////last update  ///////////////////////

	//////get_emp
	public function get_emp_job($SchoolID = 0)
	{
		$GetData = $this->db->query("
		SELECT 
		contact.ID    AS ContactID,
		contact.Name  AS ContactName
		FROM 
		contact 
		inner join emp_application on contact.ID  =emp_application.contactID
		WHERE   contact.Isactive = 1 and contact.Type='A' and emp_application.candidate =1
		");
		if ($GetData->num_rows() > 0) {
			return $GetData->result();
		} else {
			return FALSE;
		}
	}
	//////get_emp
	public function get_emp_job_permission($SchoolID = 0, $ID = 0)
	{
		$GetData = $this->db->query("
		SELECT 
		contact.ID    AS ContactID,
		contact.Name  AS ContactName
		FROM 
		contact 
	    INNER JOIN emp_application ON emp_application.contactID = contact.ID
	    inner join eva_job_specializations_rules on eva_job_specializations_rules.ElementID = emp_application.subjectID
		WHERE   contact.Isactive = 1 and Type='A' and eva_job_specializations_rules.EmpID = '" . $ID . "' and emp_application.candidate =1
		");
		if ($GetData->num_rows() > 0) {
			return $GetData->result();
		} else {
			return FALSE;
		}
	}

////////////delete_permission
	public function delete_permission($EmpID = 0)
	{
		$WHERE = array('EmpID' => $EmpID);
		$this->db->where($WHERE);
		$this->db->delete('user_permission');
	}
	////add_user_permission
	public function add_user_permission($data = array())
	{
		extract($data);
		$DataInsert = array(
			'EmpID'             => $SelectUser,
			'PageID'            => $PageID,
			'PermissioView'     => $ChkView,
			'PermissionAdd'     => $ChkAdd,
			'PermissionEdit'    => $ChkEdit,
			'PermissionDelete'  => $ChkDel,
			'ConID'             => $this->session->userdata('id'),
			'PerType'           => $PerType,
			'Type'              => $type,
			'BranchID'          => $BranchID,
			'DateFromH'         => $DateFromH,
			'DateToH'           => $DateToH,
			'DateFrom'          => $DateFrom,
			'DateTo'            => $DateTo
		);
		//print_r($DataInsert);echo '<br>'; 
		if ($this->db->insert('user_permission', $DataInsert)) {
			return TRUE;
		} else {
			return FALSE;
		}
	} ////get_emp_permission
	public function get_emp_permission($PageID = 0, $emp_id = 0)
	{
		$this->db->select('*');
		$this->db->from('user_permission');
		$this->db->where('PageID', $PageID);
		$this->db->where('EmpID', $emp_id);
		$this->db->limit(1);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return FALSE;
		}
	}
	public function get_Class($Lang = NULL)
	{
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		$this->db->select(" class." . $Name . " AS ClassName , class.ID AS ClassID ,row_level.ID AS RowLevelID ,row_level.Level_Name AS LevelName,row_level.Row_Name AS RowName");
		$this->db->from('class');
		$this->db->join('class_level', 'class.ID=class_level.classID');
		$this->db->join('row_level', 'class_level.levelID=row_level.Level_ID');
		$this->db->where('class.Is_Active', 1);
		// $this->db->group_by('class_level.ID');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	////////////////////////////////////
	public function get_class_school_active($Lang = NULL)
	{
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		$query = $this->db->query("SELECT
		  class.ID  AS ClassID ,
		  class. " . $Name . " AS ClassName 
		  FROM class
		  INNER JOIN school_class ON class.ID = school_class.ClassID AND school_class.SchoolID = '" . $this->session->userdata('SchoolID') . "'
		   ");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}

	public function get_admin_row_level_school_active($Lang = NULL)
	{
		if ($Lang == 'arabic') {
			$query = $this->db->query("SELECT 
									level.ID AS LevelID,
									row.ID AS RowID,
									class.ID AS ClassID,
									level.Name AS LevelName,
									row.Name AS RowName,
									row_level.ID As RowLevelID ,
									class.ID As ClassID ,
									class.Name AS ClassName
								FROM  class_table 
								 INNER JOIN class ON class_table.ClassID = class.ID
								 INNER JOIN row_level ON class_table.RowLevelID = row_level.ID
								 INNER JOIN row ON row_level.Row_ID = row.ID
								 INNER JOIN level ON row_level.Level_ID = level.ID
								WHERE class_table.SchoolID = '" . $this->session->userdata('SchoolID') . "' 
								  group by class_table.RowLevelID , class_table.ClassID
								
							");
		} else {
			$query = $this->db->query("SELECT 
									level.ID AS LevelID,
									row.ID AS RowID,
									class.ID AS ClassID,
									level.Name_en AS LevelName,
									row.Name_en AS RowName,
									row_level.ID As RowLevelID ,
									class.ID As ClassID ,
									class.Name_en AS ClassName
								FROM  class_table  
								 INNER JOIN class ON class_table.ClassID = class.ID
								 INNER JOIN row_level ON class_table.RowLevelID = row_level.ID
								 INNER JOIN row ON row_level.Row_ID = row.ID
								 INNER JOIN level ON row_level.Level_ID = level.ID
								WHERE class_table.SchoolID = '" . $this->session->userdata('SchoolID') . "' 
								 group by class_table.RowLevelID , class_table.ClassID
								
							");
		}





		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	public function get_row_level_school_active_test($Lang = NULL)
	{
		if ($Lang == 'arabic') {
			$query = $this->db->query("SELECT 
										level.ID AS LevelID,
										row.ID AS RowID,
										class.ID AS ClassID,
										level.Name AS LevelName,
										row.Name AS RowName,
										row_level.ID As RowLevelID ,
										class.ID As ClassID ,
										class.Name AS ClassName
                                    FROM  class_table 
									 INNER JOIN class ON class_table.ClassID = class.ID
									 INNER JOIN row_level ON class_table.RowLevelID = row_level.ID
									 INNER JOIN row ON row_level.Row_ID = row.ID
									 INNER JOIN level ON row_level.Level_ID = level.ID
                                    WHERE class_table.SchoolID = '" . $this->session->userdata('SchoolID') . "' 
                                    and  class_table.EmpID = '" . $this->session->userdata('id') . "'  group by class_table.RowLevelID , class_table.ClassID
                                    
								");
		} else {
			$query = $this->db->query("SELECT 
										level.ID AS LevelID,
										row.ID AS RowID,
										class.ID AS ClassID,
										level.Name_en AS LevelName,
										row.Name_en AS RowName,
										row_level.ID As RowLevelID ,
										class.ID As ClassID ,
										class.Name_en AS ClassName
                                    FROM  class_table  
									 INNER JOIN class ON class_table.ClassID = class.ID
									 INNER JOIN row_level ON class_table.RowLevelID = row_level.ID
									 INNER JOIN row ON row_level.Row_ID = row.ID
									 INNER JOIN level ON row_level.Level_ID = level.ID
                                    WHERE class_table.SchoolID = '" . $this->session->userdata('SchoolID') . "' 
                                    and  class_table.EmpID = '" . $this->session->userdata('id') . "'  group by class_table.RowLevelID , class_table.ClassID
                                    
								");
		}





		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	///////////////////////////////////
	/////// get_row_level_school_active
	public function get_row_level_school_active($Lang = NULL)
	{
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		$query = $this->db->query("
		 SELECT
		 level.ID         AS LevelID ,
		 row.ID           AS RowID ,
		 level." . $Name . "  AS LevelName ,
		 row." . $Name . "    AS RowName ,
		 row_level.ID     As RowLevelID 
		 FROM 
		 row_level
		 INNER JOIN row              ON row_level.Row_ID        = row.ID
		 INNER JOIN level            ON row_level.Level_ID      = level.ID
		 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = '" . $this->session->userdata('SchoolID') . "' 
		 WHERE level.Is_Active = 1 
		 ")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return  FALSE;
		}
	}
	public function check_class_emp($EmpID = 0, $ClassID = 0)
	{
		$this->db->select('*');
		$this->db->from('class_per');
		$this->db->where('ClassID', $ClassID);
		$this->db->where('EmpID', $EmpID);
		$this->db->limit(1);
		$query = $this->db->get();
		$CheckNum = $query->num_rows();
		return $CheckNum;
	}
	public function add_class_per($EmpID, $ClassID)
	{
		$this->db->query("INSERT INTO class_per SET ClassID = " . $ClassID . " ,  EmpID = " . $EmpID . " ");
		return true;
	}
	public function delete_class_per($EmpID)
	{
		$this->db->query("DELETE FROM class_per WHERE  EmpID = '" . $EmpID . "' ");
		return true;
	}
	public function get_row_level()
	{
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		////////////////////////////////////////////////////////////////////////////////
		$query = $this->db->query("
			 SELECT
 			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
			 level." . $Name . "  AS LevelName ,
		     row." . $Name . "    AS RowName ,
 			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
			 class." . $Name . "  AS ClassName
			 FROM
			 student
			 INNER JOIN class            ON student.Class_ID     = class.ID
			 INNER JOIN row_level        ON student.R_L_ID  = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID        = row.ID
			 INNER JOIN level            ON row_level.Level_ID      = level.ID
			 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = '" . $this->session->userdata('SchoolID') . "' 
			 GROUP BY student.R_L_ID
			")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {

			return false;
		}
	}
	public function check_msg_emp($EmpID = 0, $RowLevelID = 0)
	{
		$this->db->select('*');
		$this->db->from('per_msg');
		$this->db->where('RowLevelID', $RowLevelID);
		$this->db->where('EmpID', $EmpID);
		$this->db->limit(1);
		$query = $this->db->get();
		$CheckNum = $query->num_rows();
		return $CheckNum;
	}
	/////////////////////////////
	public function add_group()
	{
		$query = $this->db->query("select * from permission_group where IsUpdate = 0  ")->row_array();
		if (sizeof($query) > 0) {
			return $query['ID'];
		} else {
			$this->db->query("INSERT INTO  permission_group SET IsUpdate = 0 ");
			return $this->db->insert_id();
		}
	}





	////////////get_subject
	public function get_subject()
	{
		$query = $this->db->query("
		  SELECT
		  config_subject.ID AS ConfigSubjectID ,
		  config_subject.ID  AS Subid ,
		  subject.Name  AS SubName ,
		  level.ID       AS LevelID,
		  row.ID         AS RowID,
		  level.Name     AS LevelName,
		  row.Name       AS RowName,
		  row_level.ID   As RowLevelID
		  FROM 
		  config_subject
		  INNER JOIN subject                   ON config_subject.SubjectID = subject.ID
		  INNER JOIN row_level        ON config_subject.RowLevelID  = row_level.ID
		  INNER JOIN row              ON row_level.Row_ID        = row.ID
		  INNER JOIN level            ON row_level.Level_ID      = level.ID
		  GROUP BY config_subject.ID  DESC
		");

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}



	public function get_subject_new()
	{
		$this->db->select("subject.Name  AS SubName ,subject.ID    AS SubID ");
		$this->db->from('subject');
		$this->db->where('Is_Active', 1);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	////////////get_class_school
	public function get_class_school($Lang = NULL)
	{
		if ($Lang == 'arabic') {
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
		} else {
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
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return;
		}
	}
	///////////check_group_page
	public function check_group_page($GroupID = 0, $PageID = 0)
	{
		$query = $this->db->query("select * from group_page where GroupID = '" . $GroupID . "' AND PageID = '" . $PageID . "' ")->row_array();
	if (is_array($query) && sizeof($query) > 0) {
        return $query;
    } else {
        return FALSE;
    }
	}



	//////////////////add_per_request
	public function add_per_request()
	{
		$query = $this->db->query("select * from permission_request where IsUpdate = 0  ")->row_array();
		if (sizeof($query) > 0) {
			return $query['ID'];
		} else {
			$this->db->query("INSERT INTO  permission_request SET IsUpdate = 0 ");
			return $this->db->insert_id();
		}
	}
	//////////get_per_request_by_id
	public function get_per_request_by_id($ID = 0)
	{
		$query = $this->db->query("select * from permission_request where ID = '" . $ID . "' ")->row_array();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
	///////////////get_per_request
	public function get_per_request($Lang = NULL,  $Type = 0)
	{
		if ($Lang == 'arabic') {
			$Name = 'Name AS Name';
		} else {
			$Name = 'Name_En AS Name';
		}
		$query = $this->db->query("
		SELECT
		permission_request.* , 
		name_space." . $Name . " , 
		contact.Name AS ContactName,
		school_details.SchoolName,
		level.Name as level_name,
		permission_request.ClassType
		from permission_request 
		left JOIN name_space ON permission_request.NameSpaceID = name_space.ID
		left JOIN school_details ON permission_request.school_id = school_details.ID
		left JOIN level ON permission_request.Level = level.ID
		INNER JOIN contact    ON permission_request.EmpID = contact.ID
		WHERE permission_request.IsUpdate =  1
		AND 
		permission_request.Type = '" . $Type . "' AND  contact.Isactive = 1 ")->result();

		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
	///////////////edit_per_request
	// 	public function edit_per_request($Data = array())
	// 	{
	// 		$this->db->query("
	//         UPDATE permission_request
	//         SET
	//         EmpID          = '".$Data['EmpID']."' ,
	//         NameSpaceID    = '".$Data['NameSpaceID']."' ,
	// 		Level          = '".$Data['Level']."' ,
	//         Type           = '".$Data['Type']."' ,
	// 		IsUpdate       = '".$Data['IsUpdate']."' 
	// 		WHERE ID       = '".$Data['ID']."'
	//          ");
	// 		return TRUE ;
	// 	}
	public function edit_per_request($Data = array())
	{
		if ($Data['Type'] == 3) {
			$query     = $this->db->query("SELECT `Level`,`school_id` FROM `permission_request` WHERE `EmpID` = '" . $Data['EmpID'] . "' ")->row_array();
			$level_id  = $query['Level'] . ',' . $Data['Level'];
			if ($Data['SchoolID']) {
				$school_id = $query['school_id'] . ',' . $Data['SchoolID'];
			} else {
				$school_id = $query['school_id'];
			}
			if (!empty($query)) {
				$this->db->query("
        UPDATE permission_request
        SET
        NameSpaceID    = '" . $Data['NameSpaceID'] . "' ,
		Level          = '" . $level_id . "' ,
		school_id      = '" . $school_id . "',
        Type           = '" . $Data['Type'] . "' ,
		IsUpdate       = '" . $Data['IsUpdate'] . "' 
		WHERE EmpID    = '" . $Data['EmpID'] . "'
         ");
			} else {
				$this->db->query("
        INSERT INTO permission_request
        SET
        EmpID          = '" . $Data['EmpID'] . "' ,
        NameSpaceID    = '" . $Data['NameSpaceID'] . "' ,
		Level          = '" . $Data['Level'] . "' ,
        Type           = '" . $Data['Type'] . "' ,
		IsUpdate       = '" . $Data['IsUpdate'] . "',
		school_id      = '" . $Data['SchoolID'] . "'
         ");
			}
		} else {
			$this->db->query("
        UPDATE permission_request
        SET
        EmpID          = '" . $Data['EmpID'] . "' ,
        NameSpaceID    = '" . $Data['NameSpaceID'] . "' ,
		Level          = '" . $Data['Level'] . "' ,
        Type           = '" . $Data['Type'] . "' ,
		IsUpdate       = '" . $Data['IsUpdate'] . "' 
		WHERE ID       = '" . $Data['ID'] . "'
         ");
		}
		return TRUE;
	}
	///////////get_name_space
	public function get_name_space()
	{
		$query = $this->db->query("SELECT * FROM name_space WHERE Parent_ID	 = 81 ")->result();
		return $query;
	}
	
	///////////////del_per_request
	public function del_per_request($ID = 0)
	{
		$query = $this->db->query("DELETE FROM permission_request WHERE ID = '" . $ID . "' ");
		return true;
	}

	///////////check_group_page
	public function check_user_page($UserID = 0, $PageID = 0)
	{
		$query = $this->db->query("select * from user_permission where EmpID = '" . $UserID . "' AND PageID = '" . $PageID . "' ")->row_array();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
	///////////check_group_permission
	public function check_group_permission($UserID = 0, $GroupID = 0,  $PageID = 0)
	{
		$query = $this->db->query("
		SELECT
		permission_request.school_id as Branch , 
		permission_group.SchoolID , 
		group_page.PermissioView , 
		group_page.PermissionAdd , 
		group_page.PermissionEdit , 
		group_page.PermissionDelete 
		FROM 
		group_page 
		INNER JOIN permission_group ON group_page.GroupID = permission_group.ID
		INNER JOIN contact  ON permission_group.ID = contact.GroupID
		INNER JOIN permission_request ON contact.ID = permission_request.EmpID 
		where contact.ID = '" . $UserID . "' AND  contact.Isactive = 1 ")->row_array();
		if (sizeof($query) > 0) {
			return $query;
		} else {

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
		user_permission.EmpID = '" . $UserID . "' 
		AND CURDATE() between    DateFrom and DateTo ")->row_array();
			if (sizeof($query) > 0) {
				return $query;
			} else {
				return  FALSE;
			}
		}
	}
	///////////check_group_permission
	public function check_group_permission_add_edit_delete($UserID = 0, $GroupID = 0,  $PageID = 0)
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
		where contact.ID = '" . $UserID . "' AND  contact.Isactive = 1 AND group_page.PageID = '" . $PageID . "' ")->row_array();
		if (sizeof($query) > 0) {
			return $query;
		} else {

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
		user_permission.EmpID = '" . $UserID . "' 
		AND user_permission.PageID = '" . $PageID . "'
		AND CURDATE() between    DateFrom and DateTo ")->row_array();
			if (sizeof($query) > 0) {
				return $query;
			} else {
				return  FALSE;
			}
		}
	}
	///////////check_group_permission
	public function check_group_permission_type($UserID = 0)
	{

		$query = $this->db->query("
		SELECT
		employee.PerType ,
		employee.Type ,
		employee.Branch 
		FROM 
		contact 
		INNER JOIN employee ON contact.ID = employee.Contact_ID  
		where contact.ID = '" . $UserID . "' AND  contact.Isactive = 1 ")->row_array();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			
				return  FALSE;
			}
	}
	/////////////////////////get_emp_group_level
	public function get_emp_group_level($Lang = NULL,  $PerType = 0)
	{
		if (empty($PerType)) {
			$PerType = 0;
		}
		$PerType_last_char = substr($PerType, -1);
		if ($PerType_last_char == ',') {
			$PerType = substr($PerType, 0, -1);
		}
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		$query = $this->db->query("
		 SELECT
		 contact.ID       AS ContactID , 
		 contact.Name     AS ContactName , 
		 level.ID         AS LevelID,
		 row.ID           AS RowID,
		 class.ID         AS ClassID,
		 level." . $Name . "  AS LevelName,
		 row." . $Name . "    AS RowName,
		 row_level.ID     As RowLevelID ,
		 class.ID         As ClassID ,
		 class." . $Name . "  AS ClassName
		 FROM 
		 class_table
		 INNER JOIN base_class_table ON class_table.BaseTableID = base_class_table.ID
		 INNER JOIN class            ON class_table.ClassID     = class.ID
		 INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
		 INNER JOIN row              ON row_level.Row_ID        = row.ID
		 INNER JOIN level            ON row_level.Level_ID      = level.ID
		 INNER JOIN contact          ON contact.ID              = class_table.EmpID
		 WHERE contact.SchoolID = '" . $this->session->userdata('SchoolID') . "'
		 AND  contact.Isactive = 1
		 AND level.ID IN (" . $PerType . ")
		 GROUP BY contact.ID
		 ")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return  FALSE;
		}
	}
	public function get_level_per_helper($Lang = NULL, $PerType = NULL)
	{
		//exit($PerType);
		if (empty($PerType)) {
			$PerType = 0;
		}
		$PerType_last_char = substr($PerType, -1);
		if ($PerType_last_char == ',') {
			$PerType = substr($PerType, 0, -1);
		}
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		$query = $this->db->query("
		 SELECT
		 level.ID         AS ID ,
		 level." . $Name . "  AS Name 
		 FROM 
		 row_level
		 INNER JOIN row              ON row_level.Row_ID        = row.ID
		 INNER JOIN level            ON row_level.Level_ID      = level.ID
		 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = '" . $this->session->userdata('SchoolID') . "' 
		 WHERE level.Is_Active = 1  AND  level.ID IN (" . $PerType . ")  GROUP BY  level.ID 
		")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}

	public function get_level_per($Lang = NULL)
	{
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		$query = $this->db->query("
		 SELECT
		 level.ID         AS ID ,
		 level." . $Name . "  AS Name 
		 FROM  level
		 WHERE level.Is_Active = 1  GROUP BY  level.ID 
		")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}

	////////////////get_emp_group_rowlevel
	public function get_emp_group_rowlevel($Lang = NULL,  $PerType = 0)
	{
		if (empty($PerType)) {
			$PerType = 0;
		}
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		$PerType_last_char = substr($PerType, -1);
		if ($PerType_last_char == ',') {
			$PerType = substr($PerType, 0, -1);
		}
		$query = $this->db->query("
		 SELECT
		 contact.ID       AS ContactID , 
		 contact.Name     AS ContactName , 
		 level.ID         AS LevelID,
		 row.ID           AS RowID,
		 class.ID         AS ClassID,
		 level." . $Name . "  AS LevelName,
		 row." . $Name . "    AS RowName,
		 row_level.ID     As RowLevelID ,
		 class.ID         As ClassID ,
		 class." . $Name . "  AS ClassName
		 FROM 
		 class_table
		 INNER JOIN base_class_table ON class_table.BaseTableID = base_class_table.ID
		 INNER JOIN class            ON class_table.ClassID     = class.ID
		 INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
		 INNER JOIN row              ON row_level.Row_ID        = row.ID
		 INNER JOIN level            ON row_level.Level_ID      = level.ID
		 INNER JOIN contact          ON contact.ID              = class_table.EmpID
		 WHERE contact.SchoolID = '" . $this->session->userdata('SchoolID') . "'
		 AND  contact.Isactive = 1
		 AND row_level.ID IN (" . $PerType . ")
		 GROUP BY contact.ID
		 ")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return  FALSE;
		}
	}
	////////////////get_emp_group_class
	public function get_emp_group_class($Lang = NULL,  $RowLevel = 0, $Class = 0)
	{
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		$RowLevel_last_char = substr($RowLevel, -1);
		if ($RowLevel_last_char == ',') {
			$RowLevel = substr($RowLevel, 0, -1);
		}
		$Class_last_char = substr($Class, -1);
		if ($Class_last_char == ',') {
			$Class = substr($Class, 0, -1);
		}
		$query = $this->db->query("
		 SELECT
		 contact.ID       AS ContactID , 
		 contact.Name     AS ContactName , 
		 level.ID         AS LevelID,
		 row.ID           AS RowID,
		 class.ID         AS ClassID,
		 level." . $Name . "  AS LevelName,
		 row." . $Name . "    AS RowName,
		 row_level.ID     As RowLevelID ,
		 class.ID         As ClassID ,
		 class." . $Name . "  AS ClassName
		 FROM 
		 class_table
		 INNER JOIN base_class_table ON class_table.BaseTableID = base_class_table.ID
		 INNER JOIN class            ON class_table.ClassID     = class.ID
		 INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
		 INNER JOIN row              ON row_level.Row_ID        = row.ID
		 INNER JOIN level            ON row_level.Level_ID      = level.ID
		 INNER JOIN contact          ON contact.ID              = class_table.EmpID
         WHERE contact.SchoolID = '" . $this->session->userdata('SchoolID') . "'
		 AND  contact.Isactive = 1
		 AND row_level.ID IN (" . $RowLevel . ")
		 AND class.ID IN (" . $Class . ")
		 GROUP BY contact.ID
		 ")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return  FALSE;
		}
	} ////////////////get_emp_group_subject
	public function get_emp_group_subject($Lang = NULL, $PerType = 0)
	{
		if (empty($PerType)) {
			$PerType = 0;
		}
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		$PerType_last_char = substr($PerType, -1);
		if ($PerType_last_char == ',') {
			$PerType = substr($PerType, 0, -1);
		}
		$query = $this->db->query("
		 SELECT
		 contact.ID       AS ContactID , 
		 contact.Name     AS ContactName , 
		 level.ID         AS LevelID,
		 row.ID           AS RowID,
		 class.ID         AS ClassID,
		 level." . $Name . "  AS LevelName,
		 row." . $Name . "    AS RowName,
		 row_level.ID     As RowLevelID ,
		 class.ID         As ClassID ,
		 class." . $Name . "  AS ClassName , 
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
		 WHERE contact.SchoolID = '" . $this->session->userdata('SchoolID') . "'
		 AND  contact.Isactive = 1
		 AND  config_subject.ID IN (" . $PerType . ")
		 GROUP BY contact.ID
		 ")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return  FALSE;
		}
	}
	public function get_all_student($Lang = NULL)
	{
		$NameArray = array("Level" => "Name AS LevelName", "row" => "Name AS RowName", "class" => "Name AS ClassName");
		if ($Lang == "english") {
			$NameArray = array("Level" => "Name_en AS LevelName", "row" => " Name_en AS RowName", "class" => "Name_en AS ClassName");
		}
		$query = $this->db->query("
			 SELECT
			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
			 level." . $NameArray['Level'] . ",
			 row." . $NameArray['row'] . ",
			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
			 class." . $NameArray['class'] . " ,
			 tb1.ID    AS StudentID,
			 tb1.Token AS StudentToken,
			 tb1.Name  AS StudentName,
			 tb2.ID    AS FatherID ,
			 tb2.Token AS FatherToken ,
		     tb2.Name  AS FatherName ,
			 CONCAT(tb1.Name,' ',tb2.Name) AS FullName
			 FROM contact As tb1
			 INNER JOIN student ON tb1.ID = student.Contact_ID
			 left JOIN contact AS tb2 ON student.Father_ID     = tb2.ID
			 INNER JOIN class            ON student.Class_ID    = class.ID
			 INNER JOIN row_level        ON student.R_L_ID      = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID    = row.ID
			 INNER JOIN level            ON row_level.Level_ID  = level.ID
			 WHERE tb1.SchoolID = '" . $this->session->userdata('SchoolID') . "'
			 AND tb1.Isactive = 1 
			 ORDER BY tb1.Name
			 
			");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	public function get_all_student1()
	{

		$query = $this->db->query("
			SELECT DISTINCT (Phone), Name, type, ID FROM `contact` WHERE ID IN( SELECT DISTINCT father_id FROM student ) 
			and contact.SchoolID IN(" . $this->session->userdata('SchoolID') . ") 
			");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	public function get_level_student($Lang = NULL,  $PerType = NULL)
	{

		$NameArray = array("Level" => "Name AS LevelName", "row" => "Name AS RowName", "class" => "Name AS ClassName");
		if ($Lang == "english") {
			$NameArray = array("Level" => "Name_en AS LevelName", "row" => " Name_en AS RowName", "class" => "Name_en AS ClassName");
		}
		$query = $this->db->query("
			 SELECT distinct
			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
			 level." . $NameArray['Level'] . ",
			 row." . $NameArray['row'] . ",
			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
			 class." . $NameArray['class'] . " ,
			 tb1.ID    AS StudentID,
			 tb1.Token AS StudentToken,
			 tb1.Name  AS StudentName,
			 tb2.ID    AS ID ,
			 tb2.Token AS FatherToken ,
		     tb2.Name  AS Name ,
		     tb2.Phone  AS Phone ,
		     tb2.type  AS type ,
			 CONCAT(tb1.Name,' ',tb2.Name) AS FullName
			 FROM contact As tb1
			 INNER JOIN student ON tb1.ID = student.Contact_ID
			 INNER JOIN contact AS tb2 ON student.Father_ID     = tb2.ID
			 INNER JOIN class            ON student.Class_ID    = class.ID
			 INNER JOIN row_level        ON student.R_L_ID      = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID    = row.ID
			 INNER JOIN level            ON row_level.Level_ID  = level.ID
			 WHERE tb1.SchoolID = '" . $this->session->userdata('SchoolID') . "'
			 AND level.ID IN (" . $PerType . ")
			 AND tb1.Isactive = 1 
			 ORDER BY tb1.Name
			 
			");

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	/////////////////get_rowlevel_student
	public function get_rowlevel_student($Lang = NULL,  $PerType = NULL)
	{

		$NameArray = array("Level" => "Name AS LevelName", "row" => "Name AS RowName", "class" => "Name AS ClassName");
		if ($Lang == "english") {
			$NameArray = array("Level" => "Name_en AS LevelName", "row" => " Name_en AS RowName", "class" => "Name_en AS ClassName");
		}
		$query = $this->db->query("
			 SELECT distinct
			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
			 level." . $NameArray['Level'] . ",
			 row." . $NameArray['row'] . ",
			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
			 class." . $NameArray['class'] . " ,
			 tb1.ID    AS StudentID,
			 tb1.Token AS StudentToken,
			 tb1.Name  AS StudentName,
			 tb2.ID    AS ID ,
			 tb2.Token AS FatherToken ,
		     tb2.Name  AS Name ,
		     tb2.Phone  AS Phone ,
		     tb2.type  AS type ,
			 CONCAT(tb1.Name,' ',tb2.Name) AS FullName
			 FROM contact As tb1
			 INNER JOIN student ON tb1.ID = student.Contact_ID
			 INNER JOIN contact AS tb2 ON student.Father_ID     = tb2.ID
			 INNER JOIN class            ON student.Class_ID    = class.ID
			 INNER JOIN row_level        ON student.R_L_ID      = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID    = row.ID
			 INNER JOIN level            ON row_level.Level_ID  = level.ID
			 WHERE tb1.SchoolID = '" . $this->session->userdata('SchoolID') . "'
			 AND row_level.ID IN (" . $PerType . ")
			 AND tb1.Isactive = 1 
			 ORDER BY tb1.Name
			 
			");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	/////////////////get_student_group_class
	public function get_student_group_class($Lang = NULL,  $RowLevel = NULL, $Class = NULL)
	{
		// if(empty( $PerType)){ $PerType = 0 ; }
		//  $PerType_last_char = substr($PerType, -1);
		//         if($PerType_last_char==','){
		//           $PerType = substr($PerType, 0, -1); 
		//         }
		//         $Class_last_char = substr($Class, -1);
		//         if($Class_last_char==','){
		//           $Class = substr($Class, 0, -1); 
		//         }

		$NameArray = array("Level" => "Name AS LevelName", "row" => "Name AS RowName", "class" => "Name AS ClassName");
		if ($Lang == "english") {
			$NameArray = array("Level" => "Name_en AS LevelName", "row" => " Name_en AS RowName", "class" => "Name_en AS ClassName");
		}
		$query = $this->db->query("
			 SELECT distinct
			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
			 level." . $NameArray['Level'] . ",
			 row." . $NameArray['row'] . ",
			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
			 class." . $NameArray['class'] . " ,
			 tb1.ID    AS StudentID,
			 tb1.Token AS StudentToken,
			 tb1.Name  AS StudentName,
			 tb2.ID    AS ID ,
			 tb2.Token AS FatherToken ,
		     tb2.Name  AS Name ,
		     tb2.Phone  AS Phone ,
		     tb2.type  AS type ,
			 CONCAT(tb1.Name,' ',tb2.Name) AS FullName
			 FROM contact As tb1
			 INNER JOIN student ON tb1.ID = student.Contact_ID
			 INNER JOIN contact AS tb2 ON student.Father_ID     = tb2.ID
			 INNER JOIN class            ON student.Class_ID    = class.ID
			 INNER JOIN row_level        ON student.R_L_ID      = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID    = row.ID
			 INNER JOIN level            ON row_level.Level_ID  = level.ID
			 
			 WHERE tb1.SchoolID = '" . $this->session->userdata('SchoolID') . "'
			 AND row_level.ID IN (" . $RowLevel . ")
			 AND class.ID IN (" . $Class . ")
			 AND tb1.Isactive = 1 
			 ORDER BY tb1.Name
			 
			");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	/////////////////get_student_group_subject
	public function get_student_group_subject($Lang = NULL, $RowLevel, $Subject)
	{
		//   $PerType_last_char = substr($PerType, -1);
		//     if($PerType_last_char==','){
		//       $PerType = substr($PerType, 0, -1); 
		//     }
		$NameArray = array("Level" => "Name AS LevelName", "row" => "Name AS RowName", "class" => "Name AS ClassName");
		if ($Lang == "english") {
			$NameArray = array("Level" => "Name_en AS LevelName", "row" => " Name_en AS RowName", "class" => "Name_en AS ClassName");
		}
		$query = $this->db->query("
			 SELECT distinct
			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
			 level." . $NameArray['Level'] . ",
			 row." . $NameArray['row'] . ",
			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
			 class." . $NameArray['class'] . " ,
			 tb1.ID    AS StudentID,
			 tb1.Token AS StudentToken,
			 tb1.Name  AS StudentName,
			 tb2.ID    AS ID ,
			 tb2.Token AS FatherToken ,
		     tb2.Name  AS Name ,
		     tb2.Phone  AS Phone ,
		     tb2.type  AS type ,
			 CONCAT(tb1.Name,' ',tb2.Name) AS FullName 
			 FROM contact As tb1
			 
			 INNER JOIN student ON tb1.ID = student.Contact_ID
			 INNER JOIN contact AS tb2 ON student.Father_ID     = tb2.ID
			 INNER JOIN class            ON student.Class_ID    = class.ID
			 INNER JOIN row_level        ON student.R_L_ID      = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID    = row.ID
			 INNER JOIN level            ON row_level.Level_ID  = level.ID
		
			 WHERE tb1.SchoolID = '" . $this->session->userdata('SchoolID') . "'
			 AND row_level.ID  IN (" . $RowLevel . ")
			 AND tb1.Isactive = 1 
			 GROUP BY tb1.ID
			 ORDER BY tb1.Name
			 
			");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	

	//////////////get_branches_per_helper
	public function get_branches_per_helper($Lang = NULL, $Branch = NULL)
	{
		if (empty($Branch)) {
			$Branch = 0;
		}
		$Name = 'SchoolName';
		if ($Lang == 'english') {
			$Name = 'SchoolNameEn';
		}
		$query = $this->db->query("SELECT ID ," . $Name . " as Name FROM school_details WHERE ID IN (" . $Branch . ") ")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {

			return false;
		}
	}
	public function get_branches($Lang = NULL)
	{
		if (empty($Branch)) {
			$Branch = 0;
		}
		$Name = 'SchoolName';
		if ($Lang == 'english') {
			$Name = 'SchoolNameEn';
		}
		$query = $this->db->query("SELECT ID ," . $Name . " as Name FROM school_details   ")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {

			return false;
		}
	}


	/********************************Msg Student********************************************************/
	public function get_level_student_message($Lang = NULL,  $PerType = NULL)
	{
		if (empty($PerType)) {
			$PerType = 0;
		}
		$PerType_last_char = substr($PerType, -1);
		if ($PerType_last_char == ',') {
			$PerType = substr($PerType, 0, -1);
		}
		$NameArray = array("Level" => "Name AS level", "row" => "Name AS row", "class" => "Name AS className");
		if ($Lang == "english") {
			$NameArray = array("Level" => "Name_en AS level", "row" => " Name_en AS row", "class" => "Name_en AS className");
		}
		$query = $this->db->query("
			 SELECT
			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
			 level." . $NameArray['Level'] . ",
			 row." . $NameArray['row'] . ",
			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
			 class." . $NameArray['class'] . " ,
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
			 WHERE tb1.SchoolID = '" . $this->session->userdata('SchoolID') . "'
			 AND tb1.Isactive = 1 AND tb2.Isactive = 1
			 AND level.ID IN (" . $PerType . ")
			 ORDER BY tb1.Name
			 
			");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	/////////////////get_rowlevel_student
	public function get_rowlevel_student_message($Lang = NULL,  $PerType = NULL)
	{
		if (empty($PerType)) {
			$PerType = 0;
		}
		$PerType_last_char = substr($PerType, -1);
		if ($PerType_last_char == ',') {
			$PerType = substr($PerType, 0, -1);
		}
		$NameArray = array("Level" => "Name AS level", "row" => "Name AS row", "class" => "Name AS className");
		if ($Lang == "english") {
			$NameArray = array("Level" => "Name_en AS level", "row" => " Name_en AS row", "class" => "Name_en AS className");
		}
		$query = $this->db->query("
			 SELECT
			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
			 level." . $NameArray['Level'] . ",
			 row." . $NameArray['row'] . ",
			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
			 class." . $NameArray['class'] . " ,
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
			 WHERE tb1.SchoolID = '" . $this->session->userdata('SchoolID') . "'
			 AND tb1.Isactive = 1 AND tb2.Isactive = 1 
			 AND row_level.ID IN (" . $PerType . ")
			 ORDER BY tb1.Name
			 
			");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	/////////////////get_student_group_class
	public function get_student_group_class_message($Lang = NULL,  $PerType = NULL)
	{
		if (empty($PerType)) {
			$PerType = 0;
		}
		$PerType_last_char = substr($PerType, -1);
		if ($PerType_last_char == ',') {
			$PerType = substr($PerType, 0, -1);
		}
		$NameArray = array("Level" => "Name AS level", "row" => "Name AS row", "class" => "Name AS className");
		if ($Lang == "english") {
			$NameArray = array("Level" => "Name_en AS level", "row" => " Name_en AS row", "class" => "Name_en AS className");
		}
		$query = $this->db->query("
			 SELECT
			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
			 level." . $NameArray['Level'] . ",
			 row." . $NameArray['row'] . ",
			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
			 class." . $NameArray['class'] . " ,
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
			 
			 WHERE tb1.SchoolID = '" . $this->session->userdata('SchoolID') . "'
			 AND row_level.ID IN (" . $PerType . ")
			 AND class.ID IN (" . $Class . ")
			 AND tb1.Isactive = 1 AND tb2.Isactive = 1
			 ORDER BY tb1.Name
			 
			");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	/////////////////get_student_group_subject
	public function get_student_group_subject_message($Lang = NULL,  $RowLevel = 0, $Class = 0)
	{
		$NameArray = array("Level" => "Name AS level", "row" => "Name AS row", "class" => "Name AS className");
		if ($Lang == "english") {
			$NameArray = array("Level" => "Name_en AS level", "row" => " Name_en AS row", "class" => "Name_en AS className");
		}
		$query = $this->db->query("
			 SELECT
			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
			 level." . $NameArray['Level'] . ",
			 row." . $NameArray['row'] . ",
			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
			 class." . $NameArray['class'] . " ,
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
			 WHERE tb1.SchoolID = '" . $this->session->userdata('SchoolID') . "'
			 AND config_subject.ID IN (" . $PerType . ")
			 AND tb1.Isactive = 1 AND tb2.Isactive = 1
			 GROUP BY tb1.ID
			 ORDER BY tb1.Name
			 
			");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	//////////////////////////////////////////////////////////////////////
	public function get_all_student_message($Lang = NULL)
	{
		$NameArray = array("Level" => "Name AS level", "row" => "Name AS row", "class" => "Name AS className");
		if ($Lang == "english") {
			$NameArray = array("Level" => "Name_en AS level", "row" => " Name_en AS row", "class" => "Name_en AS className");
		}
		$query = $this->db->query("
			 SELECT
			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
			 level." . $NameArray['Level'] . ",
			 row." . $NameArray['row'] . ",
			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
			 class." . $NameArray['class'] . " ,
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
			 WHERE tb1.SchoolID = '" . $this->session->userdata('SchoolID') . "'
			 AND tb2.Isactive = 1 AND tb1.Isactive = 1
			 ORDER BY tb1.Name
			 
			");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	///////////////////////////////////////////////////////////
	/////// get_row_level_per_level
	public function get_row_level_per_level($Lang = NULL, $PerType = 0)
	{
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		$query = $this->db->query("
		 SELECT
		 level.ID         AS LevelID ,
		 row.ID           AS RowID ,
		 level." . $Name . "  AS LevelName ,
		 row." . $Name . "    AS RowName ,
		 row_level.ID     As RowLevelID 
		 FROM 
		 row_level
		 INNER JOIN row              ON row_level.Row_ID        = row.ID
		 INNER JOIN level            ON row_level.Level_ID      = level.ID
		 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = '" . $this->session->userdata('SchoolID') . "' 
		 WHERE level.Is_Active = 1  AND  level.ID IN (" . $PerType . ")
		 ")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return  FALSE;
		}
	}

	/////// get_row_level_per_row
	public function get_row_level_per_row($Lang = NULL, $PerType = 0)
	{
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		$query = $this->db->query("
		 SELECT
		 level.ID         AS LevelID ,
		 row.ID           AS RowID ,
		 level." . $Name . "  AS LevelName ,
		 row." . $Name . "    AS RowName ,
		 row_level.ID     As RowLevelID 
		 FROM 
		 row_level
		 INNER JOIN row              ON row_level.Row_ID        = row.ID
		 INNER JOIN level            ON row_level.Level_ID      = level.ID
		 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = '" . $this->session->userdata('SchoolID') . "' 
		 WHERE level.Is_Active = 1  AND  row_level.ID IN (" . $PerType . ")
		 ")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return  FALSE;
		}
	}
	/////////////////get_class_per_level/////////////////
	public function get_class_per_level($Lang = NULL, $PerType = 0)
	{
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		////////////////////////////////////////////////////////////////////////////////
		$query = $this->db->query("
		     SELECT
 			 level.ID         AS LevelID,
			 row.ID           AS RowID,
			 class.ID         AS ClassID,
			 level." . $Name . "  AS LevelName ,
		     row." . $Name . "    AS RowName ,
			 row_level.ID     As RowLevelID ,
			 class." . $Name . "  AS ClassName
			 FROM
			 student
 			 INNER JOIN contact            ON student.Contact_ID  = contact.ID
 			 INNER JOIN class            ON student.Class_ID  = class.ID
			 INNER JOIN row_level        ON student.R_L_ID    = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID        = row.ID
			 INNER JOIN level            ON row_level.Level_ID      = level.ID
		     INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = '" . $this->session->userdata('SchoolID') . "' 
		     WHERE level.Is_Active = 1  AND  level.ID IN (" . $PerType . ") AND contact.SchoolID = '" . $this->session->userdata('SchoolID') . "'
		 group by student.`Class_ID` ,student.R_L_ID order by student.R_L_ID  ;
			")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {

			return false;
		}
	}

	/////////////////get_class_per_row_level/////////////////
	public function get_class_per_row_level($Lang = NULL, $PerType = 0)
	{
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		////////////////////////////////////////////////////////////////////////////////
		$query = $this->db->query("
		     SELECT
 			 level.ID         AS LevelID,
			 row.ID           AS RowID,
			 class.ID         AS ClassID,
			 level." . $Name . "  AS LevelName ,
		     row." . $Name . "    AS RowName ,
			 row_level.ID     As RowLevelID ,
			 class." . $Name . "  AS ClassName
			 from student
 			 INNER JOIN contact         ON student.Contact_ID  = contact.ID
			 INNER JOIN class            ON student.Class_ID    = class.ID
			 INNER JOIN row_level        ON student.R_L_ID  = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID        = row.ID
			 INNER JOIN level            ON row_level.Level_ID      = level.ID
		     INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = '" . $this->session->userdata('SchoolID') . "' 
		     WHERE level.Is_Active = 1  AND  row_level.ID  IN (" . $PerType . ")
			   AND contact.SchoolID = '" . $this->session->userdata('SchoolID') . "'
		 group by student.`Class_ID` ,student.R_L_ID order by student.R_L_ID  ;
			")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {

			return false;
		}
	}

	/////////////////get_class_per_row_level/////////////////
	public function get_class_per_class($Lang = NULL, $RowLevel = 0, $Class  = 0)
	{
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		////////////////////////////////////////////////////////////////////////////////
		$query = $this->db->query("
		     SELECT
			 
			 level.ID         AS LevelID,
			 row.ID           AS RowID,
			 class.ID         AS ClassID,
			 level." . $Name . "  AS LevelName ,
		     row." . $Name . "    AS RowName ,
			 row_level.ID     As RowLevelID ,
			 class." . $Name . "  AS ClassName
			from student
 			 INNER JOIN contact            ON student.Contact_ID  = contact.ID
			 INNER JOIN class            ON student.Class_ID     = class.ID
			 INNER JOIN row_level        ON student.R_L_ID  = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID        = row.ID
			 INNER JOIN level            ON row_level.Level_ID      = level.ID
		     INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = '" . $this->session->userdata('SchoolID') . "' 
		     WHERE level.Is_Active = 1  AND  row_level.ID  = '" . $RowLevel . "' AND class.ID = '" . $Class . "' 
			AND contact.SchoolID = '" . $this->session->userdata('SchoolID') . "'
		 group by student.`Class_ID` ,student.R_L_ID order by student.R_L_ID  ; 
			")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {

			return false;
		}
	}


	/////////////////get_class_per_row_level/////////////////
	public function get_class_per_class_row_level($Lang = NULL, $RowLevel = 0)
	{
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		////////////////////////////////////////////////////////////////////////////////
		$query = $this->db->query("
		     SELECT
			 
			 level.ID         AS LevelID,
			 row.ID           AS RowID,
			 class.ID         AS ClassID,
			 level." . $Name . "  AS LevelName ,
		     row." . $Name . "    AS RowName ,
			 row_level.ID     As RowLevelID ,
			 class." . $Name . "  AS ClassName
			from student
 			 INNER JOIN contact            ON student.Contact_ID  = contact.ID
			 INNER JOIN class            ON student.Class_ID     = class.ID
			 INNER JOIN row_level        ON student.R_L_ID  = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID        = row.ID
			 INNER JOIN level            ON row_level.Level_ID      = level.ID
		     INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = '" . $this->session->userdata('SchoolID') . "' 
		     WHERE level.Is_Active = 1  AND  row_level.ID  = '" . $RowLevel . "'  
			AND contact.SchoolID = '" . $this->session->userdata('SchoolID') . "'
		 group by student.`Class_ID` ,student.R_L_ID order by student.R_L_ID  ; 
			")->result();
		if (sizeof($query) > 0) {
			print_r($query);
			return $query;
		} else {

			return false;
		}
	}
	/////////////////get_class_per/////////////////
	public function get_class_per($Lang = NULL)
	{
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		////////////////////////////////////////////////////////////////////////////////
		$query = $this->db->query("
		     select 
			 level.ID         AS LevelID,
			 row.ID           AS RowID,
			 class.ID         AS ClassID,
			 level." . $Name . "  AS LevelName ,
		     row." . $Name . "    AS RowName ,
			 row_level.ID     As RowLevelID ,
			 class." . $Name . "  AS ClassName
             from student
 			 INNER JOIN contact            ON student.Contact_ID  = contact.ID
		     left JOIN class            ON student.Class_ID = class.ID
			 left JOIN row_level        ON student.R_L_ID  = row_level.ID
			 left JOIN row              ON row_level.Row_ID        = row.ID
			 left JOIN level            ON row_level.Level_ID      = level.ID
		     left JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = '" . $this->session->userdata('SchoolID') . "' 
		     WHERE level.Is_Active = 1    AND contact.SchoolID = '" . $this->session->userdata('SchoolID') . "'
		     GROUP BY  student.R_L_ID , student.Class_ID order by student.R_L_ID 
			")->result();


		if (sizeof($query) > 0) {
			return $query;
		} else {

			return false;
		}
	}

	public function get_class_and_rowlevel($rowLevel, $classID)
	{
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		$oneDataClas =  $this->db->query('
 			        SELECT level.' . $Name . ' as LevelName ,
 			        row_level.ID  As RowLevelID ,
 			        level.ID as  LevelID,
 			        row.' . $Name . ' as RowName ,
 			        (SELECT class.' . $Name . ' FROM class where class.ID ="' . $classID . '") as ClassName ,
 			        (SELECT class.ID FROM class where class.ID ="' . $classID . '") as ClassID 
                    from row_level 
                    INNER JOIN level on level.ID = row_level.Level_ID
                    INNER JOIN row on row.ID = row_level.Row_ID
                    where row_level.ID = ' . $rowLevel . '             
 			    ');
		return $oneDataClas->row();
	}

	public function get_class_and_rowlevel111()
	{
		//$query=	$this->db->query('SELECT Name , ID  FROM class where class.Is_Active=1');
		$oneDataClas =  $this->db->query('
 			        SELECT level.Name as LevelName ,
 			        row_level.ID  As RowLevelID ,
 			        level.ID as  LevelID,
 			        row.Name as RowName ,
 			        class.Name as ClassName ,
 			        class.ID as ClassID 
                    from row_level 
                    INNER JOIN class ON row_level.ID = class.parentID
                    INNER JOIN level on level.ID = row_level.Level_ID
                    INNER JOIN row on row.ID = row_level.Row_ID
                    GROUP BY  RowLevelID  order by RowLevelID         
 			    ');
		if ($oneDataClas->num_rows() > 0) {
			return $oneDataClas->result();
		} else {
			return FALSE;
		}
	}


	/////////////////////
	public function check_group_permission_page( $GroupID = 0,  $PageName = 0)
	{
		$UserType = $this->session->userdata('type');  
		if($UserType=="U"){
		$query = $this->db->query("
		SELECT
		1 as PermissioView , 
		1 as PermissionAdd , 
		1 as PermissionEdit , 
		1 as PermissionDelete 
		FROM group_page ")->row_array();
		}else{
		$query = $this->db->query("
		SELECT
		group_page.PermissioView , 
		group_page.PermissionAdd , 
		group_page.PermissionEdit , 
		group_page.PermissionDelete 
		FROM 
		group_page 
		INNER JOIN permission_page ON group_page.PageID = permission_page.ID
		where group_page.GroupID = '" . $GroupID . "' AND  permission_page.PageUrl LIKE '%$PageName%' ")->row_array();
		}
		if (sizeof($query) > 0) {
			return $query;
		} else {
			$query = $this->db->query("
			SELECT
			group_page.PermissioView , 
			group_page.PermissionAdd , 
			group_page.PermissionEdit , 
			group_page.PermissionDelete 
			FROM 
			group_page 
			INNER JOIN permission_page ON group_page.PageID = permission_page.ID
			INNER JOIN permission_page as sub_page ON permission_page.PageUrl = sub_page.sub_page_url
			where group_page.GroupID = '" . $GroupID . "' AND  sub_page.PageUrl LIKE '%$PageName%' ")->row_array();
			if (sizeof($query) > 0) {
				return $query;
			} else {
			return false;
			}
	    }
   }
}/////////END CLASS
