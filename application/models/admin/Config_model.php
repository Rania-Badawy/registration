<?php
class Config_Model extends CI_Model
{
	private $Date       = '';
	private $Encryptkey = '';
	private $Token      = '';
	private $ID         = 0;
	private $YearFrom   = 0;
	private $YearTo     = 0;
	private $ContactID  = 0;
	function __construct()
	{
		parent::__construct();
		$this->Date  = date('Y-m-d H:i:s');
		$this->Encryptkey = $this->config->item('encryption_key');
	}
	////////get_token
	private function get_token()
	{
		$this->Token            = md5($this->Encryptkey . uniqid(mt_rand()) . microtime());
		return	$this->Token;
	}
	////////////////////////////////
	public function get_request_type()
	{
		extract($data);

		$GetType = $this->db->query("SELECT `ID`, Name , Name_en, `is_active`,isEmp FROM `request_type` WHERE is_active = 1");

		if ($GetType->num_rows() > 0) {
			return $GetType->result();
		} else {
			return FALSE;
		}
	}
	
	//////////////////////
	public function get_category()
	{

		$GetCategory = $this->db->query("SELECT `ID`, Name, Name_en, `is_active`,isEmp FROM `category` WHERE is_active = 1");

		if ($GetCategory->num_rows() > 0) {
			return $GetCategory->result();
		} else {
			return FALSE;
		}
	}
	
	//////////////////////
	public function get_status()
	{

		$GetStatus = $this->db->query("SELECT `ID`, Name, Name_en, `is_active` FROM `status` WHERE is_active = 1");

		if ($GetStatus->num_rows() > 0) {
			return $GetStatus->result();
		} else {
			return FALSE;
		}
	}
	/////////////////////////////// last update 
	///////////////////////
	public function get_config_register_main()
	{
		$setting = $this->db->query("SELECT * FROM `form_setting` where `Edit` != 'disabled' AND type = 'E' AND form_type = 1")->result();

		return $setting;
	}
	///////////////////////
	public function get_config_register_father()
	{
		$setting = $this->db->query("SELECT * FROM `form_setting` where `Edit` != 'disabled' AND type = 'F' AND form_type = 1")->result();

		return $setting;
	}
	///////////////////////
	public function get_config_register_mother()
	{
		$setting = $this->db->query("SELECT * FROM `form_setting` where `Edit` != 'disabled' AND type = 'M' AND form_type = 1")->result();

		return $setting;
	}
	///////////////////////
	public function get_config_register_student()
	{
		$setting = $this->db->query("SELECT * FROM `form_setting` where `Edit` != 'disabled' AND type = 'S' AND form_type = 1")->result();

		return $setting;
	}
	///////////////////////
	public function get_config_register_psy()
	{
		$setting = $this->db->query("SELECT * FROM `form_setting` where `Edit` != 'disabled' AND type = 'ph' AND form_type = 1")->result();

		return $setting;
	}
	//////////////////////////////////////
	public function get_config_register_medical()
	{
		$setting = $this->db->query("SELECT * FROM `form_setting` where `Edit` != 'disabled' AND type = 'MD' AND form_type = 1")->result();

		return $setting;
	}
	///////////////////////
	public function get_config_register_public()
	{
		$setting = $this->db->query("SELECT * FROM `form_setting` where `Edit` != 'disabled' AND type not in ('F','M','S','ph','MD','E') AND form_type = 1")->result();

		return $setting;
	}
	///////////////////////
	public function de_active_input($data)
	{
		$settingID	= $data['ID'];

		$query = $this->db->query("UPDATE `form_setting` SET `required` = 0 ,`display` = 0 WHERE `ID` = '" . $settingID . "' ");
		// 		print_r($query);die;
		return true;
	}

	///////////////////
	public function active_input($data)
	{
		$settingID	= $data['ID'];
		$query = $this->db->query("UPDATE `form_setting` SET `display` = 1 WHERE `ID` = '" . $settingID . "' ");

		return $query;
	}
	///////////////////////
	public function get_config_class_table_degree()
	{
		$ifExist = $this->db->query("
		SELECT 
		ID
		FROM 
		config_emp_school
		WHERE  SchoolID = '" . $this->session->userdata('SchoolID') . "'  
		");
		if ($ifExist->num_rows() == 0) {
			$GetData = $this->db->query("
            	INSERT INTO `config_emp_school`( `schoolID`,  `contactID`, `Token`) VALUES ('" . $this->session->userdata('SchoolID') . "' ,'" . $this->session->userdata('id') . "', '" . $this->get_token() . "')  
            		");
		}
		$GetData = $this->db->query("
		SELECT 
		*
		FROM 
		config_emp_school
		WHERE  SchoolID = '" . $this->session->userdata('SchoolID') . "'  
		");
		if ($GetData->num_rows() > 0) {
			return $GetData->row_array();
		} else {
			return FALSE;
		}
	}
	///////////////////////
	public function add_config_class_table_degree($data = array())
	{
		extract($data);
		$GetData = $this->db->query(" 
            	update `config_emp_school` 
            	set   
            	classTableShow = '" . $classTableShow . "',
            	DelVirtualClass = '" . $DelVirtualClass . "',
            	EditVirtualClass = '" . $EditVirtualClass . "',
            	HomeDegree = '" . $HomeDegree . "',
            	`TestMark`='" . $TestMark . "' ,
            	`exam_result`='" . $exam_result . "' ,
            	`appear_exam_result_after`='" . $appear_exam_result_after . "',
            	`homework_result`='" . $homework_result . "' ,
            	`appear_homework_result_after`='" . $appear_homework_result_after . "' ,
            	 Date='" . $date . "'
            	 where `schoolID` ='" . $this->session->userdata('SchoolID') . "' 
            	and Token ='" . $Token . "'
            		");
		return true;
	}
	//////////////////
	public function add_basic_non_basic_subject($data)
	{
		extract($data);
		$Data_Array = array(
			'Contact_ID'   => $contactID,
			'name'      	=> $subjectname,
			'Name_en'      => $subjectname,
			'basic'        => $subject_type,
			'Token' 		=> $this->Token,
			'Date_Stm'     => $date
		);
		// 		print_r($Data_Array);die;
		$Insert =  $this->db->insert('subject', $Data_Array);
		if ($Insert) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	//////////////////
	public function add_type($data)
	{
		extract($data);
		$Data_Array = array(
			'Name'      	=> $request_name,
			'Name_en'       => $request_nameEN,
			'isEmp'         => $isEmp
		);
		$Insert =  $this->db->insert('request_type', $Data_Array);
		if ($Insert) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	///////////////////////////////
	public function update_type($data)
	{
		extract($data);

		$Update = $this->db->query("UPDATE request_type  SET Name = '" . $request_name . "' ,Name_en = '" . $request_nameEN . "',isEmp='".$isEmp."' where ID = " . $type_id . " ");

		if ($Update) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	//////////////////////
	public function delete_type($data)
	{
		extract($data);
		// 		print_r($data);die;
		$query = $this->db->query("UPDATE `request_type` SET `is_active` = 0  WHERE `ID` = '" . $type_id . "' ");
		if ($query) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	//////////////////////
	public function add_category($data)
	{
		extract($data);
		$Data_Array = array(
			'Name'      	=> $category_name,
			'Name_en'       => $category_nameEN,
			'isEmp'         => $isEmp
		);
		$Insert =  $this->db->insert('category', $Data_Array);
		if ($Insert) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	///////////////////////////////
	public function update_category($data)
	{
		extract($data);

		$Update = $this->db->query("UPDATE category  SET Name = '" . $category_name . "' ,Name_en = '" . $category_nameEN . "',isEmp='".$isEmp."' where ID = " . $category_id . " ");

		if ($Update) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	//////////////////////
	public function delete_category($data)
	{
		extract($data);

		$query = $this->db->query("UPDATE `category` SET `is_active` = 0  WHERE `ID` = '" . $category_id . "' ");
		if ($query) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	//////////////////////
	public function add_status($data)
	{
		extract($data);
		$Data_Array = array(
			'Name'      	=> $status_name,
			'Name_en'      => $status_nameEN
		);
		$Insert =  $this->db->insert('status', $Data_Array);
		if ($Insert) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	///////////////////////////////
	public function update_status($data)
	{
		extract($data);

		$Update = $this->db->query("UPDATE status  SET Name = '" . $status_name . "' ,Name_en = '" . $status_nameEN . "' where ID = " . $status_ID . " ");

		if ($Update) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	//////////////////////
	public function delete_status($data)
	{
		extract($data);

		$query = $this->db->query("UPDATE `status` SET `is_active` = 0  WHERE `ID` = '" . $status_ID . "' ");
		if ($query) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	//////////////////////
	public function get_call_trac()
	{
		if ($Lang == 'english') {
			$Name = 'SchoolEnName';
		} else {
			$Name = 'SchoolName';
		}

		$query = $this->db->query("select 
		$Name AS Name,
		 Trac_school,
		 Call_school,
		 certificate_type,
		 Registration,
		 Employment,
		 Medical,
		 SMS,
		 installment,
		 SmsRegistration,
		 Communications,
         platform,
         messages

		 from `setting`");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	//////////////////////
	public function get_GPA($Data)
	{
		extract($Data);

		if ($Lang == 'english') {
			$Level_Name = 'Level_Name_en';
			$Row_Name   = 'Row_Name_en';
		} else {
			$Level_Name = 'Level_Name';
			$Row_Name   = 'Row_Name';
		}

		if($ApiDbname == "SchoolAccDigitalCulture" || $ApiDbname == "SchoolAccLavanda" || $ApiDbname == "SchoolAccExpert"){

			$select   =",year.year_name,year.year_name_hij,CONCAT(row_level.$Level_Name,'-',row_level.$Row_Name) AS rowLevelName";
			$join     = "INNER JOIN year ON year.ID = GPA.year_id
			           INNER JOIN row_level ON row_level.ID = GPA.row_level_id";
			$ORDER    ="ORDER BY  row_level_id,GPA.ID";

		}

		$query = $this->db->query("SELECT GPA.* $select
		                            FROM `GPA`
									$join
									$ORDER
								");

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	//////////////////////
	public function get_GPA_config()
	{

		$query = $this->db->query("SELECT * FROM `GPA`");

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	//////////////////////
	public function get_GPA_by_id($Data)
	{
		extract($Data);

		$query = $this->db->query("SELECT * FROM `GPA` where ID = $GPA_ID ");

		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return FALSE;
		}
	}
	//////////////////////
	public function check_gpa_data($Data)
	{
		extract($Data);

		if($row_level_id){

		$row_level_id = implode(",",$row_level_id);

		$where        = "AND `row_level_id` IN($row_level_id) AND `year_id`= $current_year_id";

		}

		$query = $this->db->query("SELECT `ID` 
		                           FROM `GPA`
								   WHERE ((`max_percent` = $GPA_from OR `min_percent`  = $GPA_from ) OR (`max_percent` = $GPA_to OR `min_percent`  = $GPA_to )) AND `grade_point`= $grade_point $where");

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	//////////////////////
	public function add_edit_GPA_config($Data)
	{
		extract($Data);

		if (empty($GPA_Name)) {
			$GPA_Name = $GPA_Color;
		}

		if ($GPA_ID) {
			
            $row_level_id = implode(',',$row_level_id);

			$Data_Update = array(
				'Name'      	=> $GPA_Name,
				'row_level_id'  => $row_level_id,
				'year_id'      	=> $current_year_id,
				'max_percent'   => $GPA_from,
				'min_percent'   => $GPA_to,
				'grade_point'   => $grade_point,
				'Date'          => $date
			);

			$this->db->where('ID', $GPA_ID);

			$Update =  $this->db->update('GPA', $Data_Update);

		} else {

			if ($ApiDbname == "SchoolAccDigitalCulture" || $ApiDbname == "SchoolAccLavanda" || $ApiDbname == "SchoolAccExpert") { 

			foreach ($row_level_id as $key => $value) {

				$Data_Insert = array(
					'Name'      	=> $GPA_Name,
					'row_level_id'  => $value,
					'year_id'      	=> $current_year_id,
					'max_percent'   => $GPA_from,
					'min_percent'   => $GPA_to,
					'grade_point'   => $grade_point,
					'Date'          => $date
				);
				$Insert =  $this->db->insert('GPA', $Data_Insert);
			}
		}else{
			$Data_Insert = array(
				'Name'      	=> $GPA_Name,
				'max_percent'   => $GPA_from,
				'min_percent'   => $GPA_to,
				'grade_point'   => $grade_point,
				'Date'          => $date
			);
			$Insert =  $this->db->insert('GPA', $Data_Insert);
		}
		}
		if ($Insert || $Update) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	//////////////////////
	public function delete_GPA_config($Data)
	{
		extract($Data);

		$query = $this->db->query("DELETE FROM `GPA` WHERE `ID` = $GPA_ID  ");

		if ($query) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	//////////////////////
	public function get_exam_type()
	{
		extract($Data);

		$query = $this->db->query("SELECT * FROM `exam_types` ");

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	//////////////////////
	public function get_exam_type_id($Data)
	{
		extract($Data);

		$query = $this->db->query("SELECT * FROM `exam_types` where id = $Exam_ID ");

		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return FALSE;
		}
	}
	//////////////////////
	public function add_edit_exam_type($Data)
	{
		extract($Data);

		if ($Exam_ID) {

			$Data_Update = array(
				'name'      => $Exam_Name,
				'name_en'   => $Exam_Name_En,
				'Date'      => $date
			);

			$this->db->where('id', $Exam_ID);

			$Update =  $this->db->update('exam_types', $Data_Update);
		} else {

			$Data_Insert = array(
				'name'      	=> $Exam_Name,
				'name_en'      => $Exam_Name_En,
				'Date'         => $date
			);
			$Insert =  $this->db->insert('exam_types', $Data_Insert);
		}
		if ($Insert || $Update) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	//////////////////////
	public function delete_exam_type($Data)
	{
		extract($Data);

		$query = $this->db->query("DELETE FROM `exam_types` WHERE `id` = $Exam_ID  ");

		if ($query) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	///////////////////////
	public function get_config_certificate_form()
	{
		$setting = $this->db->query("SELECT * FROM `certificate_form`")->result();

		return $setting;
	}
	///////////////////
	public function edit_cer_type($data)
	{
		extract($data);

		if ($cer_type == 2) {
			$model_type = '';
		}
		$this->db->query("UPDATE `setting` SET `certificate_type` = '" . $cer_type . "' , `certificate_model` = '" . $model_type . "' ");


		return TRUE;
	}
	//////////////////////////
	public function get_type_cer()
	{
		$query = $this->db->query("SELECT * FROM `setting` WHERE certificate_type != 0 ")->result();

		return $query;
	}
	//////////////////////////
	public function emp_edit_cer($Date)
	{
		extract($Date);

		if ($Lang == 'english') {
			$Name = 'Name_en';
		} else {
			$Name = 'Name';
		}

		$query = $this->db->query("SELECT config_emp_school.* ,config_semester.$Name AS SemesterName  FROM `config_emp_school` 
	                              INNER JOIN config_semester ON config_semester.ID = config_emp_school.SemesterID
	                              where schoolID = " . $this->session->userdata('SchoolID') . " ")->result();

		return $query;
	}
	//////////////////////////
	public function emp_cer($Date)
	{
		extract($Date);

		if ($Lang == 'english') {
			$Name = 'Name_en';
		} else {
			$Name = 'Name';
		}

		$query = $this->db->query("SELECT config_emp_school.* ,config_semester.$Name AS SemesterName  FROM `config_emp_school` 
	                              INNER JOIN config_semester ON config_semester.ID = config_emp_school.SemesterID
	                              where config_emp_school.ID = $ID ")->row_array();

		return $query;
	}
	///////////////////////
	public function get_config_emp_school()
	{
		$setting = $this->db->query("SELECT * FROM `config_emp_school`")->row_array();

		return $setting;
	}

	/////////
	public function get_zoom_room()
	{
		$GetRooms = $this->db->query("SELECT zoom_rooms.*,school_details.SchoolName FROM `zoom_rooms`  

                                        INNER JOIN school_details on school_details.ID = zoom_rooms.schoolid
                                        
                                        WHERE zoom_rooms.schoolid = '" . $this->session->userdata('SchoolID') . "'
                            ")->result();
		return $GetRooms;
	}
	///////////////////
	public function edit_room_name($data)
	{
		extract($data);

		$DataUpdate = array(
			'name' => $roomName
		);
		$this->db->where('id', $roomID);
		$this->db->update('zoom_rooms', $DataUpdate);

		return TRUE;
	}
	///////////////////////
	public function get_class_details()
	{

		$query = $this->db->query(" SELECT 
			GROUP_CONCAT(DISTINCT(class.Name)) as className,level.Name as levelName,level.ID as levelID
			FROM class_level
			INNER JOIN level on  level.ID=class_level.levelID
			INNER JOIN class   on  class.ID =class_level.classID  
			group by level.ID ");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
}/////////END CLSS 