<?php
class Report_Register_Model extends CI_Model
{
	private $Token           = '';
	function __construct()
	{
		parent::__construct();
		$this->Date       = date('Y-m-d H:i:s');
		$this->Encryptkey = $this->config->item('encryption_key');
		$this->Token      = $this->get_token();
	}
	////////
	private function get_token()
	{
		$this->Token            = md5($this->Encryptkey . uniqid(mt_rand()) . microtime());
		$this->Token            = substr($this->Token, 2, 5);
		return	$this->Token;
	}
	////////get_token_act
	public function get_token_act()
	{
		$this->Token            = md5($this->Encryptkey . uniqid(mt_rand()) . microtime());
		$this->Token            = substr($this->Token, 2, 4);
		return	$this->Token;
	}

	////////////////////////
	public function get_student_register($data = array())
	{
		extract($data);
		
		if ($level == 0) {
			$level = 'NULL';
		}
		if ($RowLevel == 0) {
			$RowLevel = 'NULL';
		}
		if ($semester != 0) {
			$semester = "and register_form.semester='$semester'";
		}else{
			$semester="";
		}
		$School         = 1;
		$idContact      = (int)$this->session->userdata('id');
		$get_levels     = get_levels();
		if ($this->session->userdata('type') == "E") {

			$ClassType      = $this->db->query("select ClassType,StudyType from permission_request where EmpID = " . $this->session->userdata('id') . " ")->row_array();
			$ClassTypeArray = "AND register_form.ClassTypeId IN(" . $ClassType['ClassType'] . ")";
			$StudyTypeArray = "AND register_form.studyType IN(" . $ClassType['StudyType'] . ")";
			$School         = "register_form.schoolID=" . $this->session->userdata('SchoolID') . " ";
		}
		if ($ApiDbname == "SchoolAccAndalos") {
			$where = "AND register_form.confirm_code =1";
		}
		$query = $this->db->query("select  register_form.*, register_form.name as stuname ,reg_parent.parent_name as parentname ,reg_parent.parent_mobile as parentmobile,
                                   reg_parent.ParentNumberID as ParentNumberID,reg_parent.mother_mobile as mothermobile,reg_parent.parent_mobile2,
                                   case when LENGTH(register_form.name) > 20 then register_form.name Else  CONCAT(register_form.name,' ',reg_parent.parent_name) END  AS FullName,
                                   reg_test_date.Date as InterviewDate,reg_test_date.duration,reg_test_date.note,reg_test_date.Absence AS is_attend ,reg_test_date.interview_gate,
								   reg_test_date.interview_place,reg_test_date.interview_type
		                           FROM register_form 
                    		       INNER JOIN reg_parent       ON reg_parent.ID =register_form.reg_parent_id
                                   LEFT  JOIN reg_test_date    ON register_form.id=reg_test_date.reg_id
                                   where register_form.YearId   = " . $Get_Year . " 
									$semester
                                    AND is_deleted=0  
                                    AND register_form.schoolID=$SchoolID 
                                    AND register_form.type=1 
                                    AND FIND_IN_SET(register_form.LevelID,'$get_levels')
                                    $where
                                    $ClassTypeArray
                                    $StudyTypeArray
                                    group by register_form.ID
 		                            ORDER BY register_form.ID desc 
		              ")->result();

		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
	///////////////////////////////////
public function get_rowlevel($LevelID)
	{
       

		$query  = $this->db->query("SELECT DISTINCT ID , Level_Name,Row_Name FROM row_level WHERE IsActive = 1 AND Level_ID = $LevelID ")->result();
		
		return $query  ;

	}
	////////////////////////////////
	public function get_student_register_brothers($Level)
	{
		$idContact = (int)$this->session->userdata('id');
		$data1 = $this->db->query("SELECT GenderId,SchoolID  FROM `supervisor` WHERE studytype IS NOT NULL AND `EmpID`='" . $idContact . "'")->result_array();
		if ($data1) {
			foreach ($data1 as $dat) {
				$all1[] = '\'' . $dat['GenderId'] . '\'';
				$all2[] = '\'' . $dat['SchoolID'] . '\'';
			}
			$ids = implode(',', $all);
			$ids1 = implode(',', $all1);
			$ids2 = implode(',', $all2);
			$where = "WHERE  register_form.gender IN ($ids1) AND register_form.SchoolID IN ($ids2) ";
		} else {
			$where = "";
		}
		$query = $this->db->query("
		    select  t.*, t.name as stuname ,reg_parent.parent_name as parentname ,reg_parent.parent_mobile as parentmobile,
		 reg_parent.mother_mobile as mothermobile ,
		 case when LENGTH(t.name) > 15 then t.name Else  CONCAT(t.name,' ',reg_parent.parent_name) END  AS FullName
		 FROM register_form as t
		    inner join reg_parent on reg_parent.ID =t.reg_parent_id
             $where
             AND  EXISTS (select * from register_form as  t1 where t1.`reg_parent_id` = t.`reg_parent_id` and t1.`id` <> t.`id` )ORDER by  t.`reg_parent_id` DESC
		")->result();

		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}

	///////////////////////////////////
	public function get_student_register_by_id($ID = 0)
	{
		$query = $this->db->query("
    		select  register_form.* , student_psy.*,reg_parent.* ,how_school.Name as how_school_name ,reg_parent.parent_name as parentname ,reg_parent.parent_name_eng as parentnameeng,
    		reg_parent.ParentNumberID as ParentNumber ,reg_parent.parent_email as parentemail ,reg_parent.parent_educational_qualification as parenteducationalqualification,
    		reg_parent.parent_mobile as parentmobile ,reg_parent.parent_mobile2 as parentmobile2 ,reg_parent.parent_phone as parentphone,register_form.note,
    		reg_parent.parent_access_station as parentaccessstation ,reg_parent.parent_house_number as parenthousenumber ,reg_parent.parent_region as parentregion,
    		reg_parent.parent_profession as parentprofession ,reg_parent.parent_profession_mather as parentprofessionmather,reg_parent.parent_work_address as parentworkaddress ,reg_parent.parent_phone2 as parentphone2,
		    reg_parent.mother_name as mothername,reg_parent.mother_educational_qualification as mothereducationalqualification,reg_parent.mother_mobile as mothermobile ,
		    reg_parent.mother_work as motherwork,reg_parent.mother_work_phone as motherworkphone,reg_parent.mother_email as motheremail,reg_parent.ID AS reg_parent_id,register_form.id as reg_id,
		    register_form.YearId
		    FROM register_form 
		    left join reg_parent on reg_parent.ID =register_form.reg_parent_id
            LEFT JOIN how_school on register_form.howScholl = how_school.ID
            LEFT JOIN student_psy on student_psy.register_id = register_form.id
            
		 WHERE register_form.id = '" . $ID . "'
		")->row_array();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
	////////////////////////
	public function add_student_register_accept($ID = 0)
	{

		//var_dump($ID);die;
		$query = $this->db->query("SELECT * FROM active_request WHERE RequestID = '" . $ID . "' AND Type = 2  ")->num_rows();
		if ($query == 0) {
			$query = $this->db->query("SELECT * FROM permission_request WHERE Type = 2 GROUP BY  NameSpaceID  ")->result();

			if (sizeof($query) > 0) {
				foreach ($query as $Key => $Result) {
					$this->db->query("
				INSERT INTO active_request
				 SET 
				 RequestID = '" . $ID . "' ,
				 NameSpaceID = '" . $Result->NameSpaceID . "' , 
				 Type = 2 ,
				 EmpID = 0
				   ");
				}
			}
		}
	}
	//////////////////////////////
	public function getStudentReasons($id)
	{
		$data = array();
		$records = $this->db->where('RequestID', $id)->get('active_request')->result();
		foreach ($records as $key => $value) {
			$data[$value->NameSpaceID] = $value;
		}
		return $data;
	}
	///////////////////////////
	public function check_user_accept_request($ID = 0, $Lang = NULL, $ID_request)
	{

		$Name = 'Name';
		if ($Lang == "english") {
			$Name = 'Name_En';
		}
		$query = $this->db->query("SELECT
	   active_request.* ,name_space.$Name as name_space
	   FROM
	   active_request 
	   INNER JOIN permission_request ON active_request.NameSpaceID = permission_request.NameSpaceID
	   INNER JOIN name_space         ON name_space.ID = permission_request.NameSpaceID
	   WHERE permission_request.EmpID = '" . $ID . "' AND permission_request.Type = 2   and RequestID = '" . $ID_request . "' LIMIT 1
	   ")->row_array();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
	///////////////////
	public function check_all_accept_request($ID = 0, $Lang = NULL, $ID_request)
	{

		$Name = 'Name';
		if ($Lang == "english") {
			$Name = 'Name_En';
		}
		$query = $this->db->query("SELECT
	   active_request.*  
	   FROM
	   active_request 
	   INNER JOIN permission_request ON active_request.NameSpaceID = permission_request.NameSpaceID
	   WHERE RequestID = '" . $ID_request . "' and active_request.IsActive=0  and permission_request.Type = 2  and permission_request.NameSpaceID =87 LIMIT 1
	   ")->row_array();
		if (sizeof($query) > 0) {
			return 1;
		} else {
			return FALSE;
		}
	}
	///////////////////////////////////
	public function check_all_accept_request2($ID = 0, $Lang = NULL, $ID_request)
	{
		$Name = 'Name';
		if ($Lang == "english") {
			$Name = 'Name_En';
		}
		$query = $this->db->query("SELECT
	   active_request.*  
	   FROM
	   active_request 
	   INNER JOIN permission_request ON active_request.NameSpaceID = permission_request.NameSpaceID
	   WHERE RequestID = '" . $ID_request . "' and active_request.IsActive=2  and permission_request.Type = 2  and permission_request.NameSpaceID !=85 LIMIT 1
	   ")->row_array();
		if (sizeof($query) > 0) {
			return 1;
		} else {
			return FALSE;
		}
	}
	///////////////////////////
	public function student_register_brothers($ParentNumberID, $studentNumberID)
	{
		$query = $this->db->query("
		 SELECT GROUP_CONCAT( DISTINCT st.Name SEPARATOR  '<br>') as student_name, GROUP_CONCAT( DISTINCT  level.Name , ',' ,row.Name SEPARATOR  '<br>') as row_name
         from reg_parent
         inner join contact as fa on reg_parent.ParentNumberID=fa.Number_ID
         inner join student on fa.ID =student.Father_ID
         inner join contact as st on student.Contact_ID=st.ID
         inner join row_level on student.R_L_ID=row_level.ID
         inner join level on row_level.Level_ID=level.ID
         inner join row on row_level.Row_ID=row.ID
         where reg_parent.ParentNumberID='" . $ParentNumberID . "' and st.Number_ID!=$studentNumberID
		 ")->row_array();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return  FALSE;
		}
	}
	/////////////////////////////////////////////
	public function register_date($ID)
	{

		$query = $this->db->query("
		 SELECT Date FROM reg_test_date
		 WHERE reg_id = " . $ID . " and Absence =1
		 order by ID desc
		 ")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return  FALSE;
		}
	}
	////////////////////////////
	/////////////////////
	public function get_student_register_data($ID)
	{
		$query = $this->db->query("
		 SELECT register_form.*,reg_parent.*,reg_brothers.*, register_form.name as student_name,register_form.rowLevelID as student_rowLevelID,register_form.student_NumberID as student_NumberID,register_form.reg_parent_id,
		 reg_parent.parent_name,reg_parent.ParentNumberID,reg_parent.parent_mobile,reg_parent.parent_email,
		 reg_parent.mother_name,reg_parent.mother_mobile,reg_parent.mother_email ,register_form.Year_lms
		 from register_form
		 inner join reg_parent on reg_parent.ID =register_form.reg_parent_id
		 left join reg_brothers on reg_brothers.reg_id =register_form.id
		 where register_form.id=" . $ID . "
		 ")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return  FALSE;
		}
	}
	////////////////////////
	public function get_row_level($ID = 0)
	{

		$query = $this->db->query("SELECT school_details.SchoolName ,row.ID as rowID ,row.Name as rowName ,level.ID as levelID ,level.Name as levelName ,
                            	  school_row_level.ID as RowLevel_schoolID,row_level.ID as row_level_ID
                            	   FROM school_row_level 
                            	   INNER JOIN school_details ON school_row_level.SchoolID = school_details.ID
                            	   INNER JOIN row_level  ON school_row_level.RowLevelID = row_level.ID
                            	   INNER JOIN row    ON row_level.Row_ID = row.ID
                            	   INNER JOIN level  ON row_level.Level_ID = level.ID  group by  row_level.ID order by level.ID ,row.Name
                            	   ")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
	/////////////////////////
	public function edit_student_register_model($Data = array())
	{
		extract($Data);
		$status = $status ? $status : NULL;
	
		$row_level             = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetRowLevel?schoolId=$school&rowId=$row&levelId=$level&studyTypeId=$study_type&genderId=$ClassTypeId&feeStatusId=$status"));
	    $rowID          = $row_level->RowId;
		$levelID        = $row_level->LevelId;
		$LevelName      = $row_level->LevelName;
		$RowLevelName   = $row_level->RowLevelName;
		$SchoolName     = $row_level->SchoolName;
		$rowLevelID     = $row_level->RowLevelId;
		$SchoolId       = $row_level->SchoolId;
		$edit_exam = array(
			'parent_name'                        => $Data['father_name'],
			'ParentNumberID'                     => $Data['fa_NumberID'],
			'parent_mobile'                      => $Data['fa_mobile'],
			'parent_email'                       => $Data['fa_Email'],
			'mother_name'                        => $Data['mother_name'],
			'mother_email'                       => $Data['mother_email'],
			'mother_mobile'                      => $Data['mother_mobile'],
			'IS_Updated'                         => 1,
			'parent_name_eng'                    => $Data['father_name_en'],
			'parent_educational_qualification'   => $Data['EducationalQualification'],
			'parent_mobile '                     => $Data['fa_mobile'],
			'parent_mobile2 '                    => $Data['fa_mobile2'],
			'parent_phone'                       => $Data['phone_home'],
			'parent_phone2'                      => $Data['work_phone'],
			'parent_profession'                  => $Data['fa_The_job'],
			'parent_work_address'                => $Data['parent_work_address'],
			'mother_educational_qualification'   => $Data['mother_educationa'],
			'parent_profession_mather'           => $Data['ma_The_job'],
			'mother_work_phone'                  => $Data['mother_work_phone'],
			'mother_work'                        => $Data['mother_work'],
			'father_national_id'                 => $Data['father_national_id'],
			"motherNumberID"                     => $Data['MotherNumberID'],
			"father_brith_date"                  => $Data['father_brith_date'],
			'YearId'                             => $GetYear

		);

		$this->db->where('ID', $Data['reg_parent_id']);
		$Insert_Exam =  $this->db->update('reg_parent', $edit_exam);
		
		$edit_exam1 = array(
			'name'                => $Data['student_name'],
			'student_NumberID'    => $Data['st_NumberID'],
			'IS_Updated'          => 1,
			'name_eng'            => $Data['student_name_en'],
			'student_region'      => $Data['student_region'],
			'gender'              => $Data['st_gender'],
			'birthdate'           => $Data['st_BirhtDate'],
			'birthdate_hij'       => $Data['st_BirhtDatehij'],
			'birthplace'          => $Data['st_place_birth'],
			'sec_language'        => $Data['second_lang'],
			'rowLevelID'          => $Data['RowLevelId'],
			'ClassTypeId'         => $ClassTypeId,
			'studyType'           => $study_type,
			'LevelID'             => $level,
			'levelName'           => $LevelName,
			'rowID'               => $row,
			'status'              => $status,
			'rowLevelID'          => $rowLevelID,
			'rowLevelName'        => $RowLevelName,
			'schoolID'            => $school,
			'schoolName'          => $SchoolName,
			'birth_certificate'   => $Data['birth_certificate'],
			'vaccination_certificate'   => $Data['vaccination_certificate'],
			'family_card1'              => $Data['family_card1'],
			'family_card2'              => $Data['family_card2'],
			'YearId'                    => $GetYear


		);

		$this->db->where('id', $Data['reg_id']);
		$Insert_Exam1 =  $this->db->update('register_form', $edit_exam1);
		foreach ($Data['bro_name'] as $key => $value) {
			$bro_id = $Data['bro_id'][$key];
			$edit_exam2 = array(
				'Bro_Name'              => $Data['bro_name'][$key],
				'Row_Level_Id'          => $Data['BR0_RowLevelId'][$key],
				'School_Name'           => $Data['bro_school_Name'][$key],
				'School_Type'           => $Data['bro_school_type'][$key],
			);
			$this->db->where('ID', $bro_id);
			$Insert_Exam2 =  $this->db->update('reg_brothers', $edit_exam2);
		}
		if ($Insert_Exam || $Insert_Exam1 || $edit_exam2) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	public function delete_student_register($ID)
	{
		$query = $this->db->query("
		
		 DELETE register_form , student_psy  FROM register_form  INNER JOIN student_psy  
         WHERE register_form.id= student_psy.register_id and register_form.id = " . $ID . "
		 
		 ");
		return true;
	}
	//////////////////////////
	public function Student_Register_marketing($data = array())
	{

		$where_level = 1;
		$School     = 1;
		$Group       = $this->db->query("select ID,GroupID from contact where ID=" . $this->session->userdata('id') . "")->row_array();
		$query_level = $this->db->query("select Level,school_id,NameSpaceID from permission_request where EmpID=" . $Group['ID'] . "")->row_array();
		if ($query_level && ($Group['GroupID'] == 18 || $Group['GroupID'] == 24)) {
			$where_level = "  register_form.LevelID IN(" . $query_level['Level'] . ") and register_form.schoolID IN(" . $query_level['school_id'] . ") ";
		}
		extract($data);
		// if($show == 1 || $show == 2){
		//     $where = "WHERE `Reg_Date` <= '$date_ago' and $where_level";
		// }else{
		//     $where = "where $where_level";
		// }
		if ($query_level['NameSpaceID'] == 85) {
			$where_reg = " register_form.id IN(select RequestID from active_request where (IsActive=1 or IsActive=2) and NameSpaceID=87) and register_form.id IN(select RequestID from active_request where IsActive=0 and NameSpaceID=85) ";
			$inner = " inner";
		} else {
			$where_reg = 1;
			$inner = " left";
		}
		if ($query_level['NameSpaceID'] == 87) {
			// $statuseWhere = "and status = 30";
		};
		if ($genderSelect == 1) {
			$where_gender = "and register_form.gender = 1";
		} elseif ($genderSelect == 2) {
			$where_gender = "and register_form.gender = 2";
		};
		if ($this->session->userdata('type') == "E") {
			$ClassType      = $this->db->query("select ClassType,StudyType from permission_request where EmpID = " . $this->session->userdata('id') . " ")->row_array();
			$ClassTypeArray = "AND register_form.ClassTypeId IN(" . $ClassType['ClassType'] . ")";
			$StudyTypeArray = "AND register_form.studyType IN(" . $ClassType['StudyType'] . ")";
		}
		$query = $this->db->query("
		    select  register_form.*, register_type.Name AS status_reg,student_register_type.is_contact,contact.ID AS ContactID,register_type.ID as register_type_ID,
		    reg_test_date.interview_type,reg_test_date.duration,reg_test_date.Date as interview_date,reg_test_date.Absence as is_attend,reg_test_date.note
		    FROM register_form 
		    left join student_register_type on register_form.id=student_register_type.reg_id
		    left join register_type on student_register_type.status=register_type.ID
		    left join contact on register_form.id=contact.reg_id
		    left join reg_test_date on register_form.id=reg_test_date.reg_id
		    $inner join active_request on register_form.id=active_request.RequestID
		    where   register_form.type=2 and $where_reg $statuseWhere  $where_gender and $where_level
		    and register_form.YearId=" . $Get_Year . " and register_form.schoolID=$SchoolID
			$ClassTypeArray
            $StudyTypeArray
		    group by register_form.ID
 		    ORDER BY register_form.ID DESC 
		")->result();
		//  print_r($this->db->last_query());die;
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
	//////////////////////////////
	/////////////////////////////////////
	public function get_Per_Emp($ID = 0)
	{
		$ID    = $this->session->userdata('id');
		$query = $this->db->query("SELECT `GroupID` FROM `contact` WHERE `ID`  =" . $ID . " ")->row_array();
		return $query['GroupID'];
	}
	//////////////////////////////////
	public function get_how_school($ID = 0)
	{

		$query = $this->db->query("SELECT ID,Name FROM how_school ")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
	//////////////////
	public function reg_employee_special($level, $School)
	{
		$query = $this->db->query("SELECT contact.GroupID  ,contact.Name , contact.IsActive 
	     FROM contact
	     inner join permission_request on contact.ID = permission_request.EmpID 
	     WHERE contact.IsActive=1 
	     AND  (contact.GroupID  =18 )  and FIND_IN_SET($level ,permission_request.Level) and FIND_IN_SET($School,permission_request.school_id) ")->row_array();
		return $query;
	}
	///////////////////////////////////
	public function edit_register($data)
	{
		extract($data);
		$status = $status ? $status : NULL;
	
		$row_level = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetRowLevel?schoolId=$school&rowId=$row&levelId=$level&studyTypeId=$study_type&genderId=$ClassTypeId&feeStatusId=$status"));
		$LevelName      = $row_level->LevelName;
		$RowLevelName   = $row_level->RowLevelName;
		$SchoolName     = $row_level->SchoolName;
		$rowLevelID     = $row_level->RowLevelId;
		$SchoolId       = $row_level->SchoolId;
		$this->db->query("UPDATE register_form 
		                  SET
		                      name               = '$student_name',
		                      ClassTypeId        = $ClassTypeId,
		                      studyType          = $study_type,
		                      LevelID            = $level,
		                      levelName          = '$LevelName',
		                      rowID              = $row,
		                      rowLevelID         = $rowLevelID,
		                      rowLevelName       = '$RowLevelName',
		                      howScholl          = $how_school,
							  schoolID           = $school,
							  schoolName         = '$SchoolName',
							  student_NumberID   ='$student_NumberID',
							  note               ='$note',
							  YearId             = $GetYear
		                      WHERE id           = $id
		                      
		                      ");
		$this->db->query("UPDATE reg_parent 
		                  SET
		                      parent_email       = '$parent_email',
		                      ParentNumberID     = '$ParentNumberID',
							  parent_region      = '$parent_region' 
		                       WHERE ID           = $reg_parent_id");
		$this->db->query("UPDATE student 
			                  inner join contact on student.Contact_ID=contact.ID
		                      SET
		                      R_L_ID  = $rowLevelID
		                      WHERE contact.reg_id      = $id
		                      
		                      ");
		return true;
	}
	///////////////////////////////
	public function delete_register($reg_id)
	{
		$this->db->query(" delete from register_form where id= $reg_id");
		return true;
	}
	//////////////////
	public function reg_employee($level, $School)
	{
		$query = $this->db->query("SELECT contact.GroupID  ,contact.Name , contact.IsActive 
	     FROM contact
	     inner join permission_request on contact.ID = permission_request.EmpID 
	     WHERE contact.IsActive=1 
	     AND  (contact.GroupID  =18 or contact.GroupID  =24)  and FIND_IN_SET($level ,permission_request.Level) and FIND_IN_SET($School,permission_request.school_id) ")->row_array();
		return $query;
	}
	/////////////////////////////
	public function reg_employee1($level, $School)
	{
		$query = $this->db->query("SELECT contact.GroupID  ,contact.Name , contact.Mail, contact.IsActive ,CASE WHEN LENGTH(contact.Mobile) >= 9 THEN contact.Mobile ELSE contact.Phone END AS mobile_number
	     FROM contact
	     inner join permission_request on contact.ID = permission_request.EmpID 
	     WHERE contact.IsActive=1 
	     AND contact.GroupID  = 18 and FIND_IN_SET($level ,permission_request.Level) and FIND_IN_SET($School,permission_request.school_id) ")->result();
		return $query;
	}
	/////////////////////////////////
	public function Get_state()
	{
		$query = $this->db->query("SELECT register_type.ID ,register_type.Name , register_type.IsActive,register_type.Name_en 
	     FROM register_type
	     WHERE register_type.IsActive=1 ")->result();
		return $query;
	}
	///////////////////////
	public function delete_state($record_id)
	{
		$this->db->query(" UPDATE register_type
          SET register_type.IsActive=0
           WHERE register_type.ID =$record_id ; ");
	}
	//////////////////////
	public function save_state($data)
	{
		extract($data);
		$this->db->query("insert into register_type SET register_type.Name='" . $Name . "',register_type.Name_en='" . $Name_en . "' ");
		return true;
	}
	///////////////////////
	public function update_state($data)
	{
		extract($data);
		$this->db->query(" UPDATE register_type
          SET register_type.Name='" . $Name . "',register_type.Name_en='" . $Name_en . "'
           WHERE register_type.ID =$record_id ; ");
	}
	///////////////////
	public function edit_state($record_id)
	{
		$query = $this->db->query("SELECT register_type.ID ,register_type.Name ,register_type.Name_en, register_type.IsActive 
	     FROM register_type
	     WHERE register_type.IsActive=1 
	     AND  register_type.ID =$record_id")->row_array();
		return $query;
	}
	/////////////////////////////////////////////
	public function get_status_register($reg_id)
	{
		$query = $this->db->query("SELECT contact.Name ,student_register_type.*
	     FROM contact
	     inner join student_register_type on contact.ID = student_register_type.emp_id
	     WHERE student_register_type.reg_id = $reg_id ")->row_array();
		return $query;
	}
	////////////////////////////////
	public function add_register_attend($data)
	{
		extract($data);
		$checkRoom = 1;
		if($interview_type==1){
			if(!$room_id){
				$checkRoom = 0;
			}
			if($room_id){
		      $query = $this->db->query("SELECT zoom_meetings.id ,zoom_meetings.start_time,zoom_meetings.teacherid as teacherid,zoom_meetings.group_id,zoom_meetings.room_id,
                                   (DATE_ADD(zoom_meetings.start_time,INTERVAL zoom_meetings.duration MINUTE))as end_time
                                   FROM zoom_meetings
                                   WHERE  zoom_meetings.is_deleted != 1 
								   AND zoom_meetings.reg_id !=$id
								   AND (zoom_meetings.room_id = $room_id
								   OR zoom_meetings.teacherid = '".$this->session->userdata('id')."')
                                   AND  (('$interview_date' BETWEEN start_time AND(DATE_ADD(zoom_meetings.start_time,INTERVAL zoom_meetings.duration MINUTE)))
                                   OR ('$interview_date'<=start_time AND (DATE_ADD('$interview_date',INTERVAL $duration MINUTE))BETWEEN start_time AND(DATE_ADD(zoom_meetings.start_time,INTERVAL zoom_meetings.duration MINUTE))) 
                                   OR ('$interview_date'<=start_time AND (DATE_ADD('$interview_date',INTERVAL $duration MINUTE)>=(DATE_ADD(zoom_meetings.start_time,INTERVAL zoom_meetings.duration MINUTE))))
                                   )  LIMIT 1  ")->result();
				$query1  = $this->db->query("select name from register_form 
				inner join reg_test_date on register_form.id=reg_test_date.reg_id  
				where reg_test_date.empId= '".$this->session->userdata('id')."'  AND reg_test_date.reg_id  !=$id and 
				(('$interview_date' BETWEEN reg_test_date.Date AND(DATE_ADD(reg_test_date.Date,INTERVAL duration MINUTE))) 
				OR '$interview_date'=reg_test_date.Date) ")->result();
				if (!empty($query1)){
						$checkRoom = 0;
				}
			}
		}else{
			$this->db->query("delete from zoom_meetings where reg_id=$id");
			$query  = $this->db->query("select name from register_form 
										inner join reg_test_date on register_form.id=reg_test_date.reg_id  
										where reg_test_date.empId= '".$this->session->userdata('id')."'  AND reg_test_date.reg_id  !=$id and 
										(('$interview_date' BETWEEN reg_test_date.Date AND(DATE_ADD(reg_test_date.Date,INTERVAL duration MINUTE))) 
										OR '$interview_date'=reg_test_date.Date) ")->result();
		}
		if (empty($query) && $checkRoom==1) {

			$check_reg = $this->db->query("SELECT * from reg_test_date where reg_id = $id")->result();
			$data_insert = array(
				'Date'             => $interview_date,
				'duration'         => $duration,
				'Absence'          => $is_attend,
				'note'             => $notes,
				'reg_id'           => $id,
				'empId'            => $this->session->userdata('id'),
				'interview_type'   => $interview_type,
				'interview_place'  => $interview_place,
				'interview_gate'   => $interview_gate
			);

			if (!empty($check_reg)) {
				$this->db->where('reg_id', $id);
				$this->db->update('reg_test_date', $data_insert);
			} else {

				$this->db->insert('reg_test_date', $data_insert);
			}
			return true;
		
		}else 	return false;
	}

	/////////////////////////////////////
	public function get_Per_level($ID = 0)
	{
		$ID    = $this->session->userdata('id');
		$query = $this->db->query("SELECT * FROM `permission_request` WHERE `EmpID`  =  " . $ID . " ")->row_array();
		return $query;
	}
	//////////////////////
	public function add_register_status($data)
	{
		extract($data);
		$user_id = $this->session->userdata('id');
		$query = $this->db->query("SELECT * FROM `student_register_type` WHERE `reg_id`  = " . $id . " ")->result();
		if (empty($query)) {
			$this->db->query("INSERT INTO student_register_type 
	                      SET 
						  Status    = $status , 
	                      remember_date = '" . $date_remember . "',
	                      is_contact    = '" . $contact . "',
	                      comments      = '" . $comments . "',
	                      status_date   = '$date',
	                      emp_id        = $user_id ,
	                      reg_id        = '" . $id . "'
	                      ");
		} else {
			$this->db->query("UPDATE student_register_type 
        	                      SET Status    = $status , 
        	                      remember_date = '" . $date_remember . "',
        	                      is_contact    = '" . $contact . "',
        	                      comments      = '" . $comments . "',
        	                      status_date   = '$date',
        	                      emp_id        = $user_id ,
        	                      send_email    =0
	                          WHERE reg_id      = '" . $id . "'
	                      ");
		}
	}
	////////////////////////////
	public function getTotalTestDegree($R_L_ID, $ContactID)
	{
		$result =  $this->db->query("
	        select  sum(questions_content.Degree) as totalDeg   from 
            questions_content 
            inner join test_student on questions_content.ID=test_student.questions_content_ID 
            INNER JOIN student ON test_student.Contact_ID = student.Contact_ID
            where student.R_L_ID = '" . $R_L_ID . "' and test_student.Contact_ID='" . $ContactID . "'
             ");
		$result = $result->row_array();
		return $result['totalDeg'];
	}
	///////////////////////////////
	public function Get_service_res()
	{
		$query = $this->db->query("SELECT contact.GroupID  ,contact.ID,contact.Name , contact.IsActive 
	     FROM contact 
	     WHERE contact.IsActive=1 
	     AND  contact.GroupID  =18  ")->result();
		return $query;
	}
	////////////////////////////////////////////
	public function get_student_register_report($data = array())
	{

		extract($data);
		
		if ($level == 0) {
			$level = 'NULL';
		}
		if ($RowLevel == 0) {
			$RowLevel = 'NULL';
		}
		if($semester!=0){
			$semester="and register_form.semester='$semester'";
		}else{
			$semester="";
		}
		if ($ApiDbname == "SchoolAccAndalos") {
			$where = "AND register_form.confirm_code =1";
		}
		if ($this->session->userdata('type') == "E") {
			$ClassType      = $this->db->query("select ClassType,StudyType from permission_request where EmpID = " . $this->session->userdata('id') . " ")->row_array();
			$ClassTypeArray = "AND register_form.ClassTypeId IN(" . $ClassType['ClassType'] . ")";
			$StudyTypeArray = "AND register_form.studyType IN(" . $ClassType['StudyType'] . ")";
		}
		$get_levels       = get_levels();
		$query = $this->db->query("select  register_form.* ,reg_parent.parent_email,reg_parent.parent_mobile as parentmobile,reg_parent.mother_mobile as mothermobile,reg_parent.parent_name,
                                   how_school.Name as how_school_name
                                   FROM register_form 
                                    LEFT JOIN how_school on register_form.howScholl = how_school.ID
                                    left JOIN reg_parent on reg_parent.ID = register_form.reg_parent_id
                                    where register_form.YearId=" . $Get_Year . " 
                                    and register_form.schoolID    = $SchoolID and register_form.type=$reg
                                    AND FIND_IN_SET(register_form.LevelID,'$get_levels')
									$semester
                        			$where
                        			$ClassTypeArray
                        			$StudyTypeArray
                        			group by register_form.ID
                         		    ORDER BY register_form.ID DESC 
                        		")->result();

		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
	///////////////////////////////
	public function get_level_user_request($ID = 0)
	{
		$query = $this->db->query("SELECT * FROM permission_request WHERE EmpID = '" . $ID . "' AND Type = 2 ")->result();

		if (sizeof($query) > 0) {
			$Level = '';
			foreach ($query as $Key => $Result) {
				$Level .= $Result->Level . ',';
			}

			return $Level;
		} else {
			return 0;
		}
	}
	///////////////////////
	public function count_student_register_model($data = array())
	{
		if ($this->session->userdata('type') == "E") {
			$ClassType      = $this->db->query("select ClassType,StudyType from permission_request where EmpID = " . $this->session->userdata('id') . " ")->row_array();
			$ClassTypeArray = "AND register_form.ClassTypeId IN(" . $ClassType['ClassType'] . ")";
			$StudyTypeArray = "AND register_form.studyType IN(" . $ClassType['StudyType'] . ")";
		}
		extract($data);
		if($semester!=0){
			$semester="and register_form.semester='$semester'";
		}else{
			$semester="";
		}
		if ($ApiDbname == "SchoolAccAndalos") {
			$where = "AND register_form.confirm_code =1";
		}
		$query = $this->db->query("
		 SELECT COUNT(register_form.id) as count_student,rowLevelID,studyType ,register_form.semester, rowLevelName
		 FROM register_form
		 where  register_form.YearId=" . $Get_Year . " 
		 and register_form.schoolID=$SchoolID
		 and register_form.type=$reg 
		 $semester
		 $ClassTypeArray  $StudyTypeArray
		 $where
		 GROUP BY rowLevelID,studyType
		 ")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return  FALSE;
		}
	}
	//////////////////////////////////////
	public function count_student_register_accepted($data=array())
	{
		if ($this->session->userdata('type') == "E") {
				$ClassType      = $this->db->query("select ClassType,StudyType from permission_request where EmpID = " . $this->session->userdata('id') . " ")->row_array();
			$ClassTypeArray = "AND register_form.ClassTypeId IN(" . $ClassType['ClassType'] . ")";
		}
		extract($data);
		if($semester!=0){
			$semester="and register_form.semester='$semester'";
		}else{
			$semester="";
		}
		$query = $this->db->query("
		 SELECT COUNT(id) as count_student_accepted,rowLevelID FROM register_form 
		 where register_form.IsAccepted = 1 and  register_form.rowLevelID=$rowLevelID and register_form.studyType=$studyType  and register_form.YearId=" . $Get_Year . "
		 and register_form.schoolID=$SchoolID   and register_form.type=$reg_type $ClassTypeArray
		 $semester
		 GROUP  BY rowLevelID,studyType
		 ")->row_array();
		if (sizeof($query) > 0) {
			return $query['count_student_accepted'];
		} else {
			return  FALSE;
		}
	}
	///////////////////////////////////
	public function count_student_register_refused($data=array())
	{
		if ($this->session->userdata('type') == "E") {
        	$ClassType      = $this->db->query("select ClassType,StudyType from permission_request where EmpID = " . $this->session->userdata('id') . " ")->row_array();
        	$ClassTypeArray = "AND register_form.ClassTypeId IN(" . $ClassType['ClassType'] . ")";
		}
		extract($data);
		if($semester!=0){
			$semester="and register_form.semester='$semester'";
		}else{
			$semester="";
		}
		$query = $this->db->query("
		 SELECT COUNT(id) as count_student_refused,rowLevelID FROM register_form 
		 where register_form.IsRefused= 1 and  register_form.rowLevelID=$rowLevelID and register_form.studyType=$studyType and register_form.YearId=" . $Get_Year . "
		 and register_form.schoolID=$SchoolID and register_form.type=$reg_type $ClassTypeArray
		 $semester
		 GROUP BY rowLevelID,studyType
		 ")->row_array();
		if (sizeof($query) > 0) {
			return $query['count_student_refused'];
		} else {
			return  FALSE;
		}
	}
	////////////////////////////
	public function count_student_register_pined($data=array())
	{

		if ($this->session->userdata('type') == "E") {
			$ClassType      = $this->db->query("select ClassType,StudyType from permission_request where EmpID = " . $this->session->userdata('id') . " ")->row_array();
			$ClassTypeArray = "AND register_form.ClassTypeId IN(" . $ClassType['ClassType'] . ")";
		}
		extract($data);
		if($semester!=0){
			$semester="and register_form.semester='$semester'";
		}else{
			$semester="";
		}
		$query = $this->db->query("
		 SELECT COUNT(id) as count_student_pined,rowLevelID FROM register_form 
		 where register_form.IsRefused= 0 and register_form.IsAccepted = 0 and  register_form.rowLevelID=$rowLevelID and register_form.studyType=$studyType
		 and register_form.YearId=" . $Get_Year . " and register_form.schoolID=$SchoolID and register_form.type=$reg_type $ClassTypeArray
		 $semester
		  GROUP BY rowLevelID,studyType
		 ")->row_array();
		if (sizeof($query) > 0) {
			return $query['count_student_pined'];
		} else {
			return  FALSE;
		}
	}
	/////////////////////////////
	public function get_reg_type($Lang = NULL)
	{
		if ($Lang == 'arabic') {
			$Name = 'Name';
		} else {
			$Name = 'Name_en';
		}
		$query = $this->db->query("SELECT register_type.ID, register_type.$Name as TypeName   FROM `register_type` where register_type.IsActive=1 GROUP BY register_type.ID");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	/////////////////////////////
	public function get_reg_total($type)
	{

		$where        = 1;
		$code         = "";
		if ($this->ApiDbname == "SchoolAccAndalos") {
			$code = "AND register_form.confirm_code =1";
		}
		$Group        = $this->get_Per_Emp();
		$school_level =  $this->get_Per_level();
		if ($school_level && $Group == 18) {
			$where = " register_form.LevelID IN(" . $school_level['Level'] . ") and register_form.schoolID IN(" . $school_level['school_id'] . ") ";
		}
		$query = $this->db->query("SELECT count(*) as total from register_form where $where and register_form.type=$type $code")->row_array();
		return $query['total'];
	}
	//////////////////////////////
	public function get_status_total($status)
	{
		$where = '';
		$Group = $this->get_Per_Emp();
		$school_level = $this->get_Per_level();
		if ($school_level && $Group == 18) {
			$where = "and register_form.LevelID IN(" . $school_level['Level'] . ") and register_form.schoolID IN(" . $school_level['school_id'] . ")";
		}
		// if($status==21){
		//     $query = $this->db->query("select count(distinct(register_form.id)) as status_total  from register_form 
		//                                left join student_register_type ON register_form.id=student_register_type.reg_id 
		//                                where (register_form.id NOT IN( SELECT reg_id from student_register_type) or student_register_type.Status=0 )$where and register_form.type=2")->row_array();
		// }else{
		$query = $this->db->query("select count(distinct(reg_id)) as status_total  from student_register_type
	        INNER join register_form ON register_form.id=student_register_type.reg_id where student_register_type.Status=$status $where and register_form.type=2 ")->row_array();
		// }

		return $query['status_total'];
	}
	//////////////////////////
	public function get_school()
	{
		$where = '';
		$Group = $this->get_Per_Emp();
		$school_level = $this->get_Per_level();
		if ($school_level && $Group == 18) {

			$where = "where school_details.ID IN(" . $school_level['school_id'] . ")";
		}
		$query = $this->db->query("SELECT *  from school_details where ID_ACC !=0 $where   ")->result();
		return $query;
	}
	/////////////////////////////
	public function get_school_total($school_id, $type)
	{
		$where = '';
		$code = '';
		$year_id = $this->db->query("select ID from year where IsActive=1")->row_array();
		if ($this->ApiDbname == "SchoolAccAndalos") {
			$code = "AND register_form.confirm_code =1";
		}
		$Group = $this->get_Per_Emp();
		$school_level = $this->get_Per_level();
		if ($school_level && $Group == 18) {

			$where = "and register_form.LevelID IN(" . $school_level['Level'] . ") ";
		}
		$query = $this->db->query("SELECT count(register_form.id) as total  from register_form
		where register_form.schoolID = $school_id $where $code 
		and register_form.type=$type ")->row_array();

		return $query['total'];
	}
	///////////////////////////////

	public function get_stu_type($ID)
	{
		$query = $this->db->query("SELECT register_form.* , student_register_type.* 
		    FROM `register_form` 
		    INNER JOIN student_register_type on register_form.id = student_register_type.reg_id
		    WHERE student_register_type.Status = '" . $ID . "' ");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	//////////////////////////////////////
	public function get_level_type()
	{
		$where = '';
		$Level_ID = get_level_select_in();
		$Group = $this->get_Per_Emp();
		$school_level = $this->get_Per_level();
		if ($school_level && $Group == 18) {

			$where = " where level.ID IN(" . $school_level['Level'] . ")";
		}
		$query = $this->db->query("SELECT level.Name , level.ID
		    FROM level where level.ID IN(" . $Level_ID . ") ")->result();
		return $query;
	}
	///////////////////////////
	public function get_level_total($level_id, $type)
	{
		$query = $this->db->query("SELECT count(*) as total  from register_form  where LevelID = $level_id and register_form.type=$type")->row_array();
		return $query['total'];
	}


	///////////////////////////////////
	public function get_reg_total_late($data = array())
	{

		$where_level = 1;
		$Group       = $this->db->query("select ID,GroupID from contact where ID=" . $this->session->userdata('id') . "")->row_array();
		$query_level = $this->db->query("select Level,school_id from permission_request where EmpID=" . $Group['ID'] . "")->row_array();
		if ($query_level && $Group['GroupID'] == 18) {
			$where_level = " register_form.LevelID IN(" . $query_level['Level'] . ") and register_form.schoolID IN(" . $query_level['school_id'] . ") ";
		}
		extract($data);
		$where = "WHERE `Reg_Date` <= '$date_ago' and $where_level";

		$query = $this->db->query("
		    select count(distinct( register_form.id)) as total_late  FROM register_form 
		    left join student_register_type on register_form.id=student_register_type.reg_id
		    left join register_type on student_register_type.status=register_type.ID
		    $where and register_form.type=2
		    group by register_form.ID
 		    ORDER BY register_form.ID DESC 
		")->row_array();

		return $query['total_late'];
	}
	/////////////////////
	public function check_accept_request($ID = 0, $NameSpace = 0, $UID = 0)
	{
		$UserType                  = $this->session->userdata('type');
		$accpet_reg_type           =  $this->db->query(" SELECT `accpet_reg_type`,IN_ERP FROM `school_details` ")->row_array();
		$query1                    = $this->db->query("SELECT jobTitleID FROM employee	WHERE Contact_ID = '".$this->session->userdata('id')."' ")->row_array();
		$get_permission_request    = $this->get_permission_request($UID);
	     if ($UserType == 'U' ||$accpet_reg_type['accpet_reg_type'] == 3 ||($UserType=='E' && $query1['jobTitleID']!=0 && ($get_permission_request['NameSpaceID'] !=87 && $get_permission_request['NameSpaceID'] !=85 ))) {
			$query = $this->db->query("SELECT * FROM permission_request WHERE Type = 2 and NameSpaceID > 0 GROUP BY  NameSpaceID  ")->result();

			if (sizeof($query) > 0) {
				foreach ($query as $Key => $Result) {
					$this->db->query("
            				UPDATE active_request 
            				 SET 
            				 RequestID    = " . $ID . " ,
            				 NameSpaceID  = " . $Result->NameSpaceID . " , 
            				 IsActive     = " . $this->input->post('IsActive') . ",
            				 Type         = 2 ,
            				 Reason       = '" . $this->input->post("Reason") . "',
            				 EmpID        = '" . $this->session->userdata('id') . "'
            				 WHERE RequestID = '" . $ID . "'  AND Type = 2 and NameSpaceID  = " . $Result->NameSpaceID . " 
            				   ");
				}
			}
			if ($this->input->post('IsActive') == 1) {
				$this->db->query("update  register_form SET  IsAccepted = 1 where id = '" . $ID . "' ");
			} else {

				$this->db->query("update  register_form SET  IsRefused = 1 where id = '" . $ID . "' ");
			}

			return true;
		} else {
			$this->db->query("UPDATE active_request SET 
        				 IsActive = " . $this->input->post('IsActive') . " , 
        				 EmpID    = '" . $UID . "',
        				 Reason = '" . $this->input->post("Reason") . "'
        				 WHERE RequestID = '" . $ID . "' AND NameSpaceID = '" . $NameSpace . "'  AND Type = 2 ");
		}
		$accept = $this->db->query("select  *  FROM active_request WHERE  RequestID = '" . $ID . "' AND NameSpaceID = '" . $NameSpace . "'  AND Type = 2")->row_array();
		return $accept['IsActive'];
	}
	///////////////////////////
	public function accept_student_register($ID = 0)
	{
		$this->db->query("UPDATE register_form SET IsAccepted = 1  WHERE id = '" . $ID . "'");
	}
	///////////////////////////
	public function get_permission_reg($data = array())
	{
		extract($data);
		$query = $this->db->query(" SELECT permission_request.`EmpID` , contact.Mail,CASE WHEN LENGTH(contact.Mobile) >= 9 THEN contact.Mobile ELSE contact.Phone END AS mobile_number
                                    FROM `permission_request` 
                                    INNER JOIN contact ON contact.ID = permission_request.EmpID
									WHERE  NameSpaceID=" . $NameSpaceID . " AND FIND_IN_SET($Level,`Level`)   AND FIND_IN_SET($school,school_id)
                                  ")->result();
		return $query;
	}
	//////////////////////
	public function create_student_account($Data = array(), $ID)
	{
		$Add_Contact = array(
			'Name'                => $Data['name'],
			'Gender'              => $Data['gender'],
			'Number_ID'           => $Data['ParentNumberID'],
			'User_Name'           => $Data['ParentNumberID'],
			'Mail'                => $Data['parent_email'],
			'reg_id'              => $ID,
			'Password'            => md5($this->Encryptkey . $Data['ParentNumberID']),
			'type'                => 'R',
			'Token'               => md5($this->Encryptkey . $Data['ParentNumberID'])
		);
		$Insert_Contact =  $this->db->insert('contact', $Add_Contact);

		if ($Insert_Contact) {
			$Contact_ID = $this->db->insert_id();
			$Add_Student = array(
				'Class_ID'       => 1,
				'StdetailID'     => 0,
				'Contact_ID'     => (int)$Contact_ID,
				'R_L_ID'         => (int)$Data['rowLevelID'],
				'StudyTypeID'    => (int) $Data['ClassTypeId'],
				'Token'          => (string)$this->Token
			);
			$Insert_Student =  $this->db->insert('student', $Add_Student);
			if ($Insert_Student) {
				return $Data['ParentNumberID'];
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}
	//////////////////////////
	public function get_type()
	{
		$query = $this->db->query("SELECT * FROM `school_details`")->result();

		return $query;
	}
	///////////////////
	public function edit_reg_type($data)
	{
		extract($data);
		if ($reg_type == 2) {
			$accpet_reg_type = '';
		}
		if ($reg_type == 1) {
			$smsTestDirect = 0;
		}
		$this->db->query("UPDATE `school_details` SET `reg_type` = '" . $reg_type . "' , `accpet_reg_type` = '" . $accpet_reg_type . "' , `smsTestDirect` = '" . $smsTestDirect . "'   ");

		return TRUE;
	}
	/////////////////
	////////////////
	public function add_student_brother($Data = array())
	{
		$this->db->query("
        INSERT INTO reg_brothers
        SET
        reg_id	             = '" . $Data['reg_id'] . "' ,
        Bro_Name             = '" . $Data['broName'] . "' ,
        Row_Level_Id         = '" . $Data['bro_rowlevel'] . "' ,
        School_Name          = '" . $Data['bro_schoolName'] . "' ,
        School_Type          = '" . $Data['bro_schooltype'] . "' 
         ");
		return TRUE;
	}
	public function get_permission_request($ID = 0)
	{
		$query = $this->db->query("SELECT * FROM permission_request WHERE EmpID = '" . $ID . "' AND Type = 2 ")->row_array();

		if (sizeof($query) > 0) {


			return $query;
		} else {
			return 0;
		}
	}
	public function get_auto_sms_accept($ID = 0)
	{
		$query = $this->db->query("SELECT content FROM auto_sms_accept WHERE id = '" . $ID . "' ")->row_array();

		if (sizeof($query) > 0) {


			return $query;
		} else {
			return 0;
		}
	}
	public function create_student_user($registration_data)
	{

		$row_level = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllRowLevels"));
		foreach ($row_level as $row) {
			if (($row->RowLevelId == $registration_data['rowLevelID'])) {
				$row_levelDetails = $row;
			}
		}
		$Class = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetClassesBySchool?schoolId=" . $registration_data['schoolID'] . ""));
		foreach ($Class as $row) {
			if (($row->ClassId == $registration_data['classID'])) {
				$classDetails = $row;
			}
		}
		$query = $this->db->query("SELECT ID FROM contact WHERE Number_ID =" . $registration_data['ParentNumberID'] . " ")->result();
		if (empty($query)) {
			$this->db->query("INSERT INTO  contact SET  
        		User_Name = '" . $registration_data['ParentNumberID'] . "' ,
        		Name = '" . $registration_data['parent_name'] . "' ,
        		ID_ACC = '" . $father_result->FatherID . "' ,
        		Number_ID = '" . $registration_data['ParentNumberID'] . "' ,
        		Phone = '" . $registration_data['parent_mobile'] . "' ,
        		Nationality_ID = '" . $registration_data['parent_national_ID'] . "' ,
        		SchoolID = " . $registration_data['school_lms'] . " , 
        		Type = 'F'   
        		");
			$fa_contact_id = $this->db->insert_id();
			$this->db->query("INSERT INTO  father SET  Contact_ID = '" . $fa_contact_id . "' ");
			$this->db->query("
				 update  contact
				 SET  
				 Token = '" . md5('qwwtertyrtuytyuiyuouippisdggdfghfjghkjhkjljh7455221456322872598vxcvxcvxcfjkyfgkbtium.ljnuytudfyfdghstwres5576432.21325454542vc22' . $fa_contact_id) . "',
				 Password = '" . md5('qwwtertyrtuytyuiyuouippisdggdfghfjghkjhkjljh7455221456322872598vxcvxcvxcfjkyfgkbtium.ljnuytudfyfdghstwres5576432.21325454542vc' . $registration_data['ParentNumberID']) . "'
				 where 
				 ID = '" . $fa_contact_id . "' ");
		} else {

			$fa_contact_id = $query[0]->{'ID'};
		}
		// insert student data 
		//first step

		if (empty($registration_data['student_NumberID'])) {
			$User_Name = $registration_data['name'];
		} else {
			$User_Name = $registration_data['student_NumberID'];
		}
		$this->db->query("INSERT INTO  contact SET 
		Gender = '" . $registration_data['gender'] . "' ,
		User_Name = '" . $User_Name . "' ,
		Name = '" . $registration_data['name'] . "' ,
		studentBasicID = '" . $student_result->StudentBasicDataID . "' ,
		Number_ID = '" . $registration_data['student_NumberID'] . "' ,
		Phone = '" . $registration_data['mother_mobile'] . "' ,
		Nationality_ID = '" . $registration_data['parent_national_ID'] . "' ,
		ID_ACC = '" . $father_result->FatherID . "' ,
		SchoolID = " . $registration_data['school_lms'] . ", 
		Isactive=1,
		Type = 'S' 

		");
		$contact_id = $this->db->insert_id();



		//second step


		$token = md5('qwwtertyrtuytyuiyuouippisdggdfghfjghkjhkjljh7455221456322872598vxcvxcvxcfjkyfgkbtium.ljnuytudfyfdghstwres5576432.21325454542vc22' . $contact_id);
		$password = md5('qwwtertyrtuytyuiyuouippisdggdfghfjghkjhkjljh7455221456322872598vxcvxcvxcfjkyfgkbtium.ljnuytudfyfdghstwres5576432.21325454542vc' . $User_Name);

		$this->db->query("
				update  contact
				 SET  
				 Token = '" . $token . "',
				 Password = '" . $password . "'
				 where 
				 ID = '" . $contact_id . "'
				   ");

		//fifth step

		$LevelId      = $row_levelDetails->LevelId;
		$RowName      = $row_levelDetails->RowName;
		$ClassName    = $classDetails->ClassName;
		$StudyTypeId  = $row_levelDetails->StudyTypeId;
		$LevelName    = $row_levelDetails->LevelName;



		$query = $this->db->query("SELECT ID FROM row_level WHERE Level_Name ='$LevelName'   and Row_Name='$RowName'  ")->result();

		foreach ($query as $Key => $Result) {
			$row_level_id = $Result->ID;
		}
		$query = $this->db->query("SELECT ID FROM class WHERE Name ='$ClassName'   ")->result();

		foreach ($query as $Key => $Result) {
			$class_id = $Result->ID;
		}

		if ($row_level_id == '') {
			$row_level_id = '0';
		}
		/////////////                  
		$this->db->query("INSERT INTO  student SET  
		Contact_ID = '" . $contact_id . "' ,
		Class_ID = '" . $class_id . "' ,
		R_L_ID = '" . $row_level_id . "' ,
		Father_ID = '" . $fa_contact_id . "',
		StudyTypeID = '" . $StudyTypeId . "'
		

		");

		$st_contact_id = $this->db->insert_id();

		$this->db->query("
				update  student
				 SET  
				 Token = '" . md5('qwwtertyrtuytyuiyuouippisdggdfghfjghkjhkjljh7455221456322872598vxcvxcvxcfjkyfgkbtium.ljnuytudfyfdghstwres5576432.21325454542vc22' . $st_contact_id) . "'
			 	 where 
				 ID = '" . $st_contact_id . "'
				   ");
	}
	/////////////
	public function get_contact()
	{
		$School = 0;
		if ($this->session->userdata('type') == 'U') {
			$School = $this->session->userdata('SchoolID');
		} else {
			$school_array = $this->db->query("SELECT employee.Branch FROM contact 
	        inner join employee on contact.ID = employee.Contact_ID
	        WHERE contact.ID	 = " . $this->session->userdata('id') . " ")->row_array();
			$School = $school_array['Branch'];
		}

		$query = $this->db->query("SELECT * FROM contact WHERE Type ='E' and Isactive = 1 and SchoolID IN($School) ")->result();
		return $query;
	}
	///////////////////
	public function get_level()
	{
		$R_L_ID = get_rowlevel_select_in();
		$query = $this->db->query("
		 SELECT
		 row_level.Level_ID  AS ID ,
		 row_level.Level_Name  AS Name 
		 FROM 
		 row_level
		 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = '" . $this->session->userdata('SchoolID') . "' 
		 WHERE row_level.IsActive = 1 and row_level.ID IN($R_L_ID) GROUP BY  row_level.Level_ID 
		")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
	/////////////////////
	public function get_level_without_student($Lang = NULL)
	{
		$R_L_ID = get_rowlevel_select_without_student();
		$GetData = $this->db->query("
		 SELECT
		 row_level.Level_ID  AS ID ,
		 row_level.Level_Name  AS Name 
		 FROM 
		 row_level
		 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = '" . $this->session->userdata('SchoolID') . "' 
		 WHERE row_level.IsActive = 1 and row_level.ID IN($R_L_ID) GROUP BY  row_level.Level_ID 
		");
		if ($GetData->num_rows() > 0) {
			return $GetData->result();
		} else {
			return FALSE;
		}
	}
	////////////////////
	public function get_name_space()
	{
		$query = $this->db->query("SELECT * FROM name_space WHERE Parent_ID	 = 81 ")->result();
		return $query;
	}
	//////////////
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
		employee.ClassType,
		employee.StudyType
		from permission_request 
		left JOIN name_space ON permission_request.NameSpaceID = name_space.ID
		INNER JOIN contact    ON permission_request.EmpID = contact.ID
		left JOIN employee ON contact.ID = employee.Contact_ID
		WHERE permission_request.Type = '" . $Type . "' AND  contact.Isactive = 1 ")->result();

		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
	//////////////////
	public function del_per_request($ID = 0, $EmpID)
	{
		$this->db->query("DELETE FROM permission_request WHERE EmpID = '" . $EmpID . "' ");
		$this->db->query("
                UPDATE contact
                SET
                GroupID     = '' 
        		WHERE ID    = $EmpID
         ");
		$this->db->query("
                UPDATE employee
                SET
                Type           = '' ,
        		PerType        = '' ,
        		Branch         = ''
        		WHERE Contact_ID    = $EmpID
         ");
		return true;
	}
	///////////////////
	public function add_per_request($Data = array())
	{
		$query     = $this->db->query("SELECT `Level`,`school_id` FROM `permission_request` WHERE `EmpID` = '" . $Data['EmpID'] . "' ")->result();
		if ($Data['Type'] == 2) {
			$GroupID = 24;
		} else {
			$GroupID = 18;
		}
		if (!empty($query)) {
			$this->db->query("
                UPDATE permission_request
                SET
                NameSpaceID    = '" . $Data['NameSpaceID'] . "' ,
        		Level          = '" . $Data['Level'] . "' ,
        		school_id      = '" . $Data['SchoolID'] . "',
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
		$this->db->query("
                UPDATE contact
                SET
                GroupID     = $GroupID 
        		WHERE ID    = '" . $Data['EmpID'] . "'
         ");
		$this->db->query("
                UPDATE employee
                SET
                Type           = 1 ,
        		PerType        = '" . $Data['Level'] . "' ,
        		Branch         = '" . $Data['SchoolID'] . "',
        		ClassType      = '" . $Data['class_type'] . "',
				StudyType      = '" . $Data['studeType'] . "'
        		WHERE Contact_ID    = '" . $Data['EmpID'] . "'
         ");
		return TRUE;
	}
	////////////////////////
	public function reg_per_level()
	{
		$query =  $this->db->query("SELECT DISTINCT reg_per_level.ID,reg_per_level.reg_percentage ,reg_level,school_id
                                    from reg_per_level 
                                   
                 			    ");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}

	///////////////////////////
	public function add_reg_per_level($data = array())
	{
		extract($data);
		foreach ($school_id as $school) {
			$query     = $this->db->query("SELECT * FROM `reg_per_level` WHERE `school_id` = '" . $school . "' and `reg_level` = '" . $reg_level . "'  ")->result();
			$DataInsert = array(
				'school_id'             => $school,
				'reg_level'             => $reg_level,
				'reg_percentage'        => $reg_percentage,
			);
			if (!empty($query)) {
				$this->db->where('ID', $query[0]->ID);
				$Update = $this->db->update('reg_per_level', $DataInsert);
			} else {
				$Insert = $this->db->insert('reg_per_level', $DataInsert);
			}
		}
		if ($Update || $Insert) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	///////////////////////
	public function delete_reg_per($ID = 0)
	{
		$this->db->query("DELETE FROM reg_per_level WHERE  ID = '" . $ID . "' ");
		return true;
	}
	////////////////////
	public function create_student_account_marketing($Data = array(), $ID)
	{
		$this->Token = $this->get_token();
		$Add_Contact = array(
			'Name'                => $Data['name'],
			'Gender'              => $Data['gender'],
			'Number_ID'           => $Data['student_NumberID'],
			'User_Name'           => $Data['student_NumberID'],
			'Mail'                => $Data['parent_email'],
			'reg_id'              => $ID,
			'Password'            => md5($this->Encryptkey . $Data['student_NumberID']),
			'type'                => 'R',
			'schoolID'            => $Data['schoolID'],
			'Token'               => md5($this->Encryptkey . $Data['student_NumberID'])
		);
		$this->db->insert('contact', $Add_Contact);
		$Contact_ID = $this->db->insert_id();
		if ($Contact_ID) {
		
			$Add_Student = array(
			
				'StdetailID'     => 0,
				'Contact_ID'     => (int)$Contact_ID,
				'R_L_ID'         => (int)$Data['rowLevelID'],
				'StudyTypeID'    => (int) $Data['ClassTypeId'],
				'Token'          => (string)$this->Token
			);
			$Insert_Student =  $this->db->insert('student', $Add_Student);
			if ($Insert_Student) {
				return $Data['student_NumberID'];
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}
	/////////////////////////////////////
	public function repeat_accept_academy($data)
	{
		extract($data);
		$query = $this->db->query("SELECT ID FROM `contact` WHERE `reg_id`  =  " . $reg_id . " ")->row_array();
		$this->db->query("DELETE  FROM `active_request` WHERE `RequestID`   =  " . $reg_id . " ");
		$this->db->query("UPDATE  `register_form` SET  IsAccepted=0  WHERE `ID`   =  " . $reg_id . " ");
		if ($query['ID']) {
		    $solveDate =$this->db->query("select Inserted_At FROM `test_student` WHERE `Contact_ID`     = ".$query['ID']." ")->row_array()['Inserted_At'];
			$this->db->query("DELETE FROM `test_student` WHERE `Contact_ID`     = ".$query['ID']." ");
			$check_exam = $this->db->query("select ID,num_student  FROM `test` WHERE SchoolId=$schoolID AND FIND_IN_SET($rowLevelID ,`RowLevelID`) AND IsActive=1 AND type =4 and ('$solveDate' BETWEEN test.date_from and test.date_to)  ")->result();
			foreach($check_exam as $val){
			if($val->num_student){
			    $num_stu = $query['ID'].",".$val->num_student;
			}else{
			    $num_stu= $query['ID'] ;
			}
			
			$this->db->query("UPDATE  `test` SET  num_student='$num_stu'  WHERE ID=".$val->ID." ");
			}
		}
		return true;
	}
	/////////////////////////////////////
	public function repeat_acceptance($reg_id)
	{
		
		$this->db->query("DELETE  FROM `active_request` WHERE `RequestID`   =  " . $reg_id . " ");
		$this->db->query("UPDATE  `register_form` SET  IsAccepted=0  WHERE `ID`   =  " . $reg_id . " ");
		return true;
	}
	/////////////////////
	public function Get_total_new($emp_id, $type)
	{
		$where = '';
		$code         = "";
		$year_id = $this->db->query("select ID from year where IsActive=1")->row_array();
		if ($this->ApiDbname == "SchoolAccAndalos") {
			$code = "AND register_form.confirm_code =1";
		}
		$school_level = $this->get_Per_level($emp_id);
		if ($school_level) {
			$where = " and LevelID IN(" . $school_level['Level'] . ") and schoolID IN(" . $school_level['school_id'] . ")  ";
		}
		$query = $this->db->query("SELECT count(register_form.id) as total_new    
	     FROM register_form
	     left JOIN student_register_type ON student_register_type.reg_id=register_form.id
	     where (register_form.id NOT IN( SELECT reg_id from student_register_type) or student_register_type.Status=0 ) and register_form.type=$type and Year_lms=" . $year_id['ID'] . "  $where $code ")->row_array();
		return $query;
	}
	/////////////////////////
	public function Get_total_underworking($emp_id)
	{
		$where = '';
		$Group = $this->get_Per_Emp($emp_id);
		$school_level = $this->get_Per_level($emp_id);
		if ($school_level && ($Group == 18 || $Group == 24)) {

			$where = " and LevelID IN(" . $school_level['Level'] . ") and schoolID IN(" . $school_level['school_id'] . ")  ";
		}
		$query = $this->db->query("SELECT count(student_register_type.ID) as totalUw  
	                              FROM student_register_type
	                              INNER JOIN register_form ON student_register_type.reg_id=register_form.id
	                              WHERE  remember_date !='0000-00-00' and register_form.type=2 and student_register_type.Status != 30 and student_register_type.Status != 0  $where
	      ")->row_array();
		return $query;
	}
	/////////////////////
	public function Get_total_finshed($emp_id)
	{
		$where = '';
		$Group = $this->get_Per_Emp($emp_id);
		$school_level = $this->get_Per_level($emp_id);
		if ($school_level && ($Group == 18 || $Group == 24)) {

			$where = " and LevelID IN(" . $school_level['Level'] . ") and schoolID IN(" . $school_level['school_id'] . ")  ";
		}
		$query = $this->db->query("SELECT count(student_register_type.ID) as total_finshed    
	                               FROM student_register_type
	                               INNER JOIN register_form ON student_register_type.reg_id=register_form.id
	                               WHERE   register_form.type=2 and student_register_type.Status =30 $where
	      ")->row_array();
		return $query;
	}
	/////////////////////////////////////
	public function student_exam($ID)
	{
		$query = $this->db->query("SELECT sum(test_student.Degree) as total FROM `test_student` WHERE test_student.Contact_ID =  " . $ID . " ")->row_array();
		return $query['total'];
	}
	//////////////////////////
	public function confirmRegistration($data = array())
	{
		extract($data);
		
		if ($level == 0) {
			$level = 'NULL';
		}
		if ($RowLevel == 0) {
			$RowLevel = 'NULL';
		}
		if ($semester != 0) {
			$semester = "and register_form.semester='$semester'";
		}else{
			$semester="";
		}
		$School         = 1;
		$idContact      = (int)$this->session->userdata('id');
		if ($this->session->userdata('type') == "E") {

			$ClassType      = $this->db->query("select ClassType,StudyType from permission_request where EmpID = " . $this->session->userdata('id') . " ")->row_array();
			$ClassTypeArray = "AND register_form.ClassTypeId IN(" . $ClassType['ClassType'] . ")";
			$StudyTypeArray = "AND register_form.studyType IN(" . $ClassType['StudyType'] . ")";
			$School         = "register_form.schoolID=" . $this->session->userdata('SchoolID') . " ";
		}
		$query = $this->db->query("select  register_form.*, register_form.name as stuname ,reg_parent.parent_name as parentname ,reg_parent.parent_mobile as parentmobile,
                                   reg_parent.ParentNumberID as ParentNumberID,reg_parent.mother_mobile as mothermobile,reg_parent.parent_mobile2,
                                   case when LENGTH(register_form.name) > 20 then register_form.name Else  CONCAT(register_form.name,' ',reg_parent.parent_name) END  AS FullName,
                                   reg_test_date.Date as InterviewDate,reg_test_date.duration,reg_test_date.note,reg_test_date.Absence AS is_attend ,reg_test_date.interview_gate,
								   reg_test_date.interview_place,reg_test_date.interview_type
		                           FROM register_form 
                    		       INNER JOIN reg_parent       ON reg_parent.ID =register_form.reg_parent_id
                                   LEFT  JOIN reg_test_date    ON register_form.id=reg_test_date.reg_id
                                 
                                   where register_form.YearId   = " . $Get_Year . " 
									$semester
                                    AND is_deleted=0  
                                    AND register_form.schoolID=$SchoolID 
                                    AND register_form.type=1
									AND register_form.confirm_code=0 
                                    $ClassTypeArray
                                    $StudyTypeArray
                                    group by register_form.ID
 		                            ORDER BY register_form.ID desc 
		              ")->result();

		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}

	///////////////////////////////////////////
	public function getParent($LevelID)
		{
			$schoolID = (int)$this->session->userdata('SchoolID');
			if ($LevelID == -1) {
				$query = $this->db->query("SELECT DISTINCT contact.ID , contact.Name  , contact.Mail ,CASE WHEN LENGTH(contact.Phone) >= 9 THEN contact.Phone ELSE contact.Mobile END AS mobile_number
			  FROM contact
			  INNER JOIN student ON contact.ID = student.Father_ID
			  INNER JOIN contact as tb2 ON student.Contact_ID = tb2.ID 
			  WHERE contact.Type IN('E','F')   AND tb2.SchoolID =" . $schoolID . " 
			   ");
			} else {
				$query = $this->db->query("SELECT DISTINCT contact.ID , contact.Name  , contact.Mail ,CASE WHEN LENGTH(contact.Phone) >= 9 THEN contact.Phone ELSE contact.Mobile END AS mobile_number
			  FROM contact
			  INNER JOIN student ON contact.ID = student.Father_ID
			  INNER JOIN contact as tb2 ON student.Contact_ID = tb2.ID
			  INNER JOIN row_level ON student.R_L_ID     = row_level.ID 
			  WHERE contact.Type IN('E','F')  
			  AND tb2.SchoolID =" . $schoolID . "  AND row_level.Level_ID =".$LevelID."
			   ");
			}
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return FALSE;
			}
		}

   ///////////////
	public function get_student_poll_school()
	{
		
		$query = $this->db->query("SELECT school_details.ID,school_details.SchoolName
									FROM school_details
									WHERE school_details.ID_ACC !=0 
									GROUP BY school_details.ID 
								 ")->result();
		return $query;
	}

	public function get_student_poll()
	{
		
		$query = $this->db->query("SELECT reasons.id,reasons.name,COUNT(reasons_withdrawal.id) AS count_num
									FROM reasons
									LEFT  JOIN reasons_withdrawal ON FIND_IN_SET(reasons.id,reasons_withdrawal.reasons)
									LEFT  JOIN school_details ON school_details.ID = reasons_withdrawal.schoolId AND school_details.ID_ACC !=0 
									GROUP BY reasons.id 
		                         ")->result();
		return $query;
	}
////////////////////////////////
	public function get_reasons()
	{

		$query = $this->db->query("SELECT reasons.id  ,reasons.name  FROM reasons where isActive=1")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
	/////////////////////////
	public function get_student_poll_details($Data)
	{
		extract($Data);
		if ($reasonID == '') {
            $reasonID     = 'NULL';
        }
		$query = $this->db->query("SELECT reasons_withdrawal.studentName,row_level.Level_Name,row_level.Row_Name ,
		                            case when $reasonID then reasons.name else GROUP_CONCAT(reasons.name) END  as reasonName,reasons_withdrawal.withdrawalDate,
								   reasons_withdrawal.deportedSchool,reasons_withdrawal.schoolType,reasons_withdrawal.notes
									FROM `reasons_withdrawal`
									INNER JOIN row_level ON reasons_withdrawal.rowLevelId = row_level.ID
									INNER JOIN reasons   ON FIND_IN_SET(reasons.id,reasons_withdrawal.reasons)
									where  reasons_withdrawal.`schoolId` = $schoolID
									AND reasons.id = IFNULL($reasonID,reasons.id)
									group by reasons_withdrawal.studentName
									")->result();
		return $query;
	}
}
