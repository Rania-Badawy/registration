<?php
class Report_Emp_Model extends CI_Model
{
	private $Date       = '';
	private $Encryptkey = '';
	private $Token      = '';

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
	/////////////report_plan_week
	public function report_plan_week($EmpID = 0, $DayDateFrom = 'NULL', $DayDateTo = 'NULL', $rowLavel, $classID)
	{

		$dataWhere = '';
		$rowLavelWhere = '';
		if ($DayDateFrom  !== 'NULL' && $DayDateTo  !== 'NULL') {
			$dataWhere = "AND (DATE(plan_week.Date_Stm)  BETWEEN CAST('" . $DayDateFrom . "' AS DATE ) AND CAST('" . $DayDateTo . "' AS DATE  )) ";
		}
		if ($rowLavel != 0) {
			$rowLavelWhere = 'AND class_table.RowLevelID = "' . $rowLavel . '" ';
		}

		$getReport = $this->db->query("
			SELECT 
			plan_week.ID 
			FROM plan_week 
			INNER JOIN class_table ON plan_week.ClassTableID = class_table.ID 
			WHERE class_table.EmpID = " . $EmpID . "
			" . $dataWhere . " " . $rowLavelWhere . " 
		    GROUP BY SemesterID , WeekID
		 ");

		// print_r($this->db->last_query());exit();
		return (int)$getReport->num_rows();
	}
	/////////////report_weekly_plan
	public function report_weekly_plan($Lang = 'arabic', $EmpID = 0, $DayDateFrom = 'NULL', $DayDateTo = 'NULL')
	{
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		if ($DayDateFrom  == 'NULL' && $DayDateTo  == 'NULL') {
			$getReport = $this->db->query("
			SELECT 
			plan_week.ID AS PlanWeek ,
			level." . $Name . " AS LevelName ,
			row." . $Name . "   AS RowName ,
			class." . $Name . " AS ClassName ,
			week." . $Name . " AS WeekName , 
			contact.Name   AS ContactName ,
			subject.Name   AS SubjectName   
			FROM plan_week 
			INNER JOIN class_table ON plan_week.ClassTableID          = class_table.ID 
			INNER JOIN class 				ON class_table.ClassID    = class.ID
			INNER JOIN row_level 			ON class_table.RowLevelID = row_level.ID
			INNER JOIN row 					ON row_level.Row_ID       = row.ID
			INNER JOIN level 				ON row_level.Level_ID     = level.ID
			INNER JOIN week 				ON plan_week.WeekID       = week.ID
			INNER JOIN contact              ON class_table.EmpID      = contact.ID
			INNER JOIN subject              ON class_table.SubjectID  = subject.ID
			WHERE class_table.EmpID = " . $EmpID . " AND  TRIM(plan_week.Content) <> '' GROUP BY plan_week.SemesterID , plan_week.WeekID
		 ");
		} else {
			$getReport = $this->db->query("
			SELECT 
			plan_week.ID AS PlanWeek ,
			level." . $Name . " AS LevelName ,
			row." . $Name . "   AS RowName ,
			class." . $Name . " AS ClassName ,
			week." . $Name . " AS WeekName , 
			contact.Name   AS ContactName ,
			subject.Name   AS SubjectName   
			FROM plan_week 
			INNER JOIN class_table ON plan_week.ClassTableID          = class_table.ID 
			INNER JOIN class 				ON class_table.ClassID    = class.ID
			INNER JOIN row_level 			ON class_table.RowLevelID = row_level.ID
			INNER JOIN row 					ON row_level.Row_ID       = row.ID
			INNER JOIN level 				ON row_level.Level_ID     = level.ID
			INNER JOIN week 				ON plan_week.WeekID       = week.ID
			INNER JOIN contact              ON class_table.EmpID      = contact.ID
			INNER JOIN subject              ON class_table.SubjectID  = subject.ID
			WHERE class_table.EmpID = " . $EmpID . " AND  TRIM(plan_week.Content) <> '' 
			AND 
			(DATE(plan_week.Date_Stm)	 BETWEEN CAST('" . $DayDateFrom . "' AS DATE ) AND CAST('" . $DayDateTo . "' AS DATE  )) 
		    GROUP BY plan_week.SemesterID , plan_week.WeekID
		 ");
		}
		return $getReport->result();
	}

	/////////////////////////////////////////////////////////////////////////// Emp E Lib
	public function report_e_library($EmpID = 0,  $DayDateFrom = 'NULL', $DayDateTo = 'NULL')
	{
		if ($DayDateFrom  == 'NULL' && $DayDateTo  == 'NULL') {
			$getReport = $this->db->query("
		SELECT 
		COUNT(ID) AS Count_library 
		FROM e_library 
		WHERE ContactID = " . $EmpID . " AND File_url<>''
		 ");
		} else {

			$getReport = $this->db->query("
			SELECT 
			COUNT(ID) AS Count_library 
			FROM e_library 
			WHERE ContactID = " . $EmpID . " AND File_url<>''
			AND 
			(DATE(Stm_Date) BETWEEN CAST('" . $DayDateFrom . "' AS DATE ) AND CAST('" . $DayDateTo . "' AS DATE  )) 
		 ");
		}
		$GetNumCount = $getReport->row_array();
		return (int)$GetNumCount['Count_library'];
	}

	public function report_emp_elib($EmpID = 0, $DayDateFrom = NULL,  $DayDateTo = NULL)
	{

		$query = $this->db->query("
		SELECT
		e_library.ID AS ItemID,
	   e_library.Method AS ItemMethod,
	   e_library.Type AS ItemType,
	   e_library.SemesterID AS ItemSem,
	   e_library.Title AS ItemTitle,
	   e_library.File_url AS ItemUrl,
	   e_library.Downloads AS ItemDownCount,
	   e_library.Stm_Date AS ItemDate,
	   subject.Name AS ItemSubject,
	   row_level.Level_Name AS ItemLevel,
	   row_level.Row_Name AS ItemRow
	   FROM
	   e_library
	   INNER JOIN subject ON subject.ID = e_library.SubjectID 
	   INNER JOIN row_level ON row_level.ID = e_library.RowLevelID
	   WHERE e_library.ContactID = '" . $EmpID . "'
	   AND 
	  (DATE(e_library.Stm_Date)	 BETWEEN CAST('" . $DayDateFrom . "' AS DATE ) AND CAST('" . $DayDateTo . "' AS DATE  ))
		")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}

	////get_semester Name
	public function get_semester($Lang, $SemesterID)
	{
		if ($Lang == 'arabic') {
			$this->db->select('Name AS Name');
			$this->db->from('config_semester');
			$this->db->where('ID', $SemesterID);
		} else {
			$this->db->select('Name_en AS Name');
			$this->db->from('config_semester');
			$this->db->where('ID', $SemesterID);
		}
		$ResultSemeName 	= $this->db->get();
		$ReturnSemeName	= $ResultSemeName->row_array();
		return $ReturnSemeName;
	}
	///////////////////////////////////////////////////////////////////////////	


	/////////////report_test_exam
	public function report_test_exam($EmpID = 0,  $DayDateFrom = 'NULL', $DayDateTo = 'NULL')
	{
		if ($DayDateFrom  == 'NULL' && $DayDateTo  == 'NULL') {
			$getReport = $this->db->query("
		SELECT 
		test.ID AS TestID
		FROM test 
		INNER JOIN config_emp ON test.Subject_emp_ID = config_emp.ID
		WHERE config_emp.EmpID = " . $EmpID . " AND test.type = 0 
		 ");
		} else {
			$getReport = $this->db->query("
				SELECT 
				test.ID AS TestID
				FROM test 
				INNER JOIN config_emp ON test.Subject_emp_ID = config_emp.ID
				WHERE config_emp.EmpID = " . $EmpID . " AND test.type = 0 
				AND 
			(DATE(Date_Stm)	 BETWEEN CAST('" . $DayDateFrom . "' AS DATE ) AND CAST('" . $DayDateTo . "' AS DATE  ))
			 ");
		}
		return (int)$getReport->num_rows();
	}
	/////////////report_home_work
	public function report_home_work($EmpID = 0,  $DayDateFrom = 'NULL', $DayDateTo = 'NULL')
	{

		if ($DayDateFrom  == 'NULL' && $DayDateTo  == 'NULL') {

			$getReport = $this->db->query("
			SELECT 
			test.ID AS TestID
			FROM test 
			INNER JOIN config_emp ON test.Subject_emp_ID = config_emp.ID
			WHERE config_emp.EmpID = " . $EmpID . " AND test.type = 1 
		 ");
		} else {
			$getReport = $this->db->query("
				SELECT 
				test.ID AS TestID
				FROM test 
				INNER JOIN config_emp ON test.Subject_emp_ID = config_emp.ID
				WHERE config_emp.EmpID = " . $EmpID . " AND test.type = 1 
				AND 
			(DATE(Date_Stm)	 BETWEEN CAST('" . $DayDateFrom . "' AS DATE ) AND CAST('" . $DayDateTo . "' AS DATE  ))
			 ");
		}
		return (int)$getReport->num_rows();
	}
	/////////////report_last_login
	public function report_last_login($EmpID = 0)
	{
		$getReport = $this->db->query("
		SELECT 
		LastLogin
		FROM contact 
		WHERE ID = " . $EmpID . "  
		 ");
		if ($getReport->num_rows() > 0) {
			$GetLastLogin = $getReport->row_array();
			return $GetLastLogin['LastLogin'];
		} else {
			return FALSE;
		}
	}

	///////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////// Emp Students Eval
	public function report_student_eval_num($EmpID = 0,  $DayDateFrom = 'NULL', $DayDateTo = 'NULL')
	{

		if ($DayDateFrom  == 'NULL' && $DayDateFrom  == 'NULL') {
			$getReport = $this->db->query("
		SELECT 
		students_evaluation.ID
		FROM 
		students_evaluation
		INNER JOIN student ON students_evaluation.StudentID = student.Contact_ID
		WHERE students_evaluation.TeacherID = " . $EmpID . "  GROUP BY student.R_L_ID , student.Class_ID ,  students_evaluation.Date_stm
		 ");
		} else {
			$getReport = $this->db->query("
			   SELECT 
				students_evaluation.ID
				FROM 
				students_evaluation
				INNER JOIN student ON students_evaluation.StudentID = student.Contact_ID
				WHERE students_evaluation.TeacherID = " . $EmpID . "  
				AND 
			   (DATE(students_evaluation.Date)	 BETWEEN CAST('" . $DayDateFrom . "' AS DATE ) AND CAST('" . $DayDateTo . "' AS DATE  )) 
		       GROUP BY student.R_L_ID , student.Class_ID ,  students_evaluation.Date_stm
		 ");
		}


		return (int)$getReport->num_rows();
	}

	public function report_student_eval($EmpID = 0)
	{
		$Lang = $this->session->userdata('language');

		$NameArray = array("Level" => "Name AS LevelName", "row" => "Name AS RowName", "class" => "Name AS ClassName");
		if ($Lang == "english") {
			$NameArray = array("Level" => "Name_en AS LevelName", "row" => " Name_en AS RowName", "class" => "Name_en AS ClassName");
		}
		$query = $this->db->query("
		SELECT
			level.ID AS LevelID,
			row.ID AS RowID,
			class.ID AS ClassID,
			level." . $NameArray['Level'] . ",
			row." . $NameArray['row'] . ",
			row_level.ID As RowLevelID ,
			class.ID As ClassID ,
			class." . $NameArray['class'] . " ,
			tb1.ID AS StudentID,
			tb1.Name AS StudentName,
			tb2.ID AS FatherID ,
			tb2.Name AS FatherName ,
			CONCAT(tb1.Name,' ',tb2.Name) AS FullName ,
			students_evaluation.ID AS EvalID , 
			students_evaluation.Absence AS EvalAbsence,
			students_evaluation.PostsCount AS EvalPosts,
			students_evaluation.TestMark AS TestMark,
			students_evaluation.StudentID AS StudentContactID, 
			students_evaluation.TeacherID, students_evaluation.SubjectID, students_evaluation.Lesson, 
			students_evaluation.Date AS EvalDate ,
			tb3.Name AS TeacherName ,
			subject.Name AS subjectName 
		FROM contact As tb1
		INNER JOIN student 				ON tb1.ID = student.Contact_ID
		INNER JOIN contact AS tb2 		ON student.Father_ID = tb2.ID
		INNER JOIN class 				ON student.Class_ID = class.ID
		INNER JOIN row_level 			ON student.R_L_ID = row_level.ID
		INNER JOIN row 					ON row_level.Row_ID = row.ID
		INNER JOIN level 				ON row_level.Level_ID = level.ID
		INNER JOIN students_evaluation 	ON students_evaluation.StudentID = tb1.ID
		INNER JOIN contact AS tb3 		ON tb3.ID = students_evaluation.TeacherID
		INNER JOIN subject		 		ON subject.ID = students_evaluation.SubjectID
		WHERE students_evaluation.TeacherID = " . $EmpID . " 
		AND tb1.Isactive = 1 
		AND tb2.Isactive = 1 
		GROUP BY students_evaluation.StudentID
		");

		$NumData = $query->num_rows();
		if ($NumData > 0) {
			$ReturnData    = $query->result();
			return $ReturnData;
		} else {
			return $NumData;
		}
	}

	public function get_EvalNum($StudentID = 0, $TeacherID = 0)
	{
		$this->db->select('*');
		$this->db->from('students_evaluation');
		$this->db->where('StudentID', $StudentID);
		$this->db->where('TeacherID', $TeacherID);
		$ResultData = $this->db->get();
		$NumRowResultData  = $ResultData->num_rows();
		return $NumRowResultData;
	}

	public function get_student_eval($StudentID = 0, $TeacherID = 0, $SubjectID = 0)
	{
		$Lang = $this->session->userdata('language');
		$NameArray = array("Level" => "Name AS LevelName", "row" => "Name AS RowName", "class" => "Name AS ClassName", "lesson" => "lesson AS lessonName");
		if ($Lang == "english") {
			$NameArray = array("Level" => "Name_en AS LevelName", "row" => " Name_en AS RowName", "class" => "Name_en AS ClassName", "lesson" => "Lesson_en AS lessonName");
		}

		$query = $this->db->query("
		SELECT
			tb1.ID AS StudentID,
			tb1.Name AS StudentName,
			tb2.ID AS FatherID ,
			tb2.Name AS FatherName ,
			CONCAT(tb1.Name,' ',tb2.Name) AS FullName ,
			students_evaluation.ID AS EvalID , 
			students_evaluation.Absence AS EvalAbsence,
			students_evaluation.PostsCount AS EvalPosts,
			students_evaluation.TestMark AS TestMark,
			students_evaluation.HomeDegree ,
		    students_evaluation.skills ,
		    students_evaluation.skillsType ,
		    students_evaluation.Delay,
		    students_evaluation.skillsType ,
			students_evaluation.StudentID AS StudentContactID, 
			students_evaluation.TeacherID, 
			students_evaluation.SubjectID,
			students_evaluation.Lesson, 
			students_evaluation.Date AS EvalDate, 
			students_evaluation.PositiveID AS EvalPositiveID,
			students_evaluation.MOreNote,
			students_evaluation.NoteID AS EvalNoteID ,
			subject.Name AS subjectName ,
			lesson_prep.Lesson_Title,
			tb3.Name AS TeacherName 
			
		FROM contact As tb1
		INNER JOIN student 				ON tb1.ID = student.Contact_ID
		INNER JOIN contact AS tb2 		ON student.Father_ID = tb2.ID
		INNER JOIN students_evaluation 	ON students_evaluation.StudentID = tb1.ID
		INNER JOIN contact AS tb3 		ON tb3.ID = students_evaluation.TeacherID
		INNER JOIN subject		 		ON subject.ID = students_evaluation.SubjectID
		left JOIN lesson_prep		    ON lesson_prep.ID = students_evaluation.lesson_prepID
		WHERE students_evaluation.StudentID = '" . $StudentID . "'
		AND students_evaluation.TeacherID = '" . $TeacherID . "'
		AND students_evaluation.SubjectID='" . $SubjectID . "'
		AND tb1.Isactive = 1 
		AND ((students_evaluation.Delay IS NOT NULL AND students_evaluation.Absence = 0)
        OR  (students_evaluation.Absence =1 AND students_evaluation.Delay IS NULL))
		");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	//////////////////////////////////////////////////////////////////////////// Emp Lesson Prep

	public function report_emp_prep_num($EmpID = 0,  $DayDateFrom = 'NULL', $DayDateTo = 'NULL')
	{

		if ($DayDateFrom  == 'NULL' && $DayDateTo  == 'NULL') {

			$getReport = $this->db->query("
		SELECT 
		ID
		FROM lesson_prep 
		WHERE Teacher_ID = " . $EmpID . "
		GROUP BY  RowLevel_ID , Subject_ID
		 ");
		} else {
			$getReport = $this->db->query("
			SELECT 
			ID
			FROM lesson_prep 
			WHERE Teacher_ID = " . $EmpID . "
			AND 
			(DATE(Date) BETWEEN CAST('" . $DayDateFrom . "' AS DATE ) AND CAST('" . $DayDateTo . "' AS DATE  ))
			GROUP BY  RowLevel_ID , Subject_ID
			
		 ");
		}
		return (int)$getReport->num_rows();
	}

	public function lesson_prep_check_count($SubjectID = 0, $RowLevelID = 0, $TeacherID = 0)
	{
		$WhereArray     = array('RowLevel_ID' => $RowLevelID, 'Subject_ID' => $SubjectID, 'Teacher_ID' => $TeacherID);

		$this->db->select('count(ID) AS Count');
		$this->db->from('lesson_prep');
		$this->db->where($WhereArray);
		$this->db->limit(1);
		$ResultLessonDetails = $this->db->get();
		$Return = $ResultLessonDetails->row_array();
		$Count  = $Return['Count'];
		return (int)$Count;
	}

	public function get_lessons_prep($data)
	{
		$RowLevelID 	= $data['RowLevelID'];
		$SubjectID 		= $data['SubjectID'];
		$TeacherID  	= $data['TeacherID'];

		$this->db->select('ID AS LessonID, Lesson_Title AS LessonTitle ,Date AS LessonDate , Token AS LessonToken');
		$this->db->from('lesson_prep');
		$this->db->where('RowLevel_ID', $RowLevelID);
		$this->db->where('Subject_ID', $SubjectID);
		$this->db->where('Teacher_ID', $TeacherID);
		$ResultLessons = $this->db->get();
		$NumRowResultLessons  = $ResultLessons->num_rows();
		if ($NumRowResultLessons != 0) {
			$ReturnLessons = $ResultLessons->result();
			return $ReturnLessons;
		} else {
			return false;
		}
	}

	public function get_lesson_details($LessonToken = 0)
	{
		$this->db->select('');
		$this->db->from('lesson_prep');
		$this->db->where('Token', $LessonToken);
		$this->db->limit(1);
		$ResultLessonDetails = $this->db->get();
		$NumRowResultLessonDetails  = $ResultLessonDetails->num_rows();
		if ($NumRowResultLessonDetails != 0) {
			return $ResultLessonDetails->row_array();
		} else {
			return false;
		}
	}

	public function get_RowLevel_Name($RowLevel_ID)
	{
		$this->db->select('level.Name AS LevelName , row.Name AS RowName');
		$this->db->from('row_level');
		$this->db->join('level', 'level.ID = row_level.Level_ID');
		$this->db->join('row', 'row.ID = row_level.Row_ID');
		$this->db->where('row_level.ID', $RowLevel_ID);

		$ResultRowLevelName = $this->db->get();
		$NumRowResultRowLevelName  = $ResultRowLevelName->num_rows();
		if ($NumRowResultRowLevelName != 0) {
			$ReturnRowLevelName = $ResultRowLevelName->row_array();
			return $ReturnRowLevelName;
		} else {
			return false;
		}
	}

	public function get_Teacher_Name($TeacherID)
	{
		$this->db->select('Name');
		$this->db->from('contact');
		$this->db->where('ID', $TeacherID);
		$ResultTeacher = $this->db->get();
		$NumRowResultTeacher  = $ResultTeacher->num_rows();
		if ($NumRowResultTeacher != 0) {
			$ReturnTeacher = $ResultTeacher->row_array();
			return $ReturnTeacher;
		} else {
			return false;
		}
	}

	public function get_Subject_Name($SubjectID)
	{
		$this->db->select('Name');
		$this->db->from('subject');
		$this->db->where('ID', $SubjectID);
		$ResultSubject = $this->db->get();
		$NumRowResultSubject  = $ResultSubject->num_rows();
		if ($NumRowResultSubject != 0) {
			$ReturnSubject = $ResultSubject->row_array();
			return $ReturnSubject;
		} else {
			return false;
		}
	}




	///////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////

	//////////////////clerical_homework
	public function report_clerical_homework($EmpID = 0,  $DayDateFrom = 'NULL', $DayDateTo = 'NULL')
	{
		if ($DayDateFrom  == 'NULL' && $DayDateTo  == 'NULL') {
			$getReport = $this->db->query("
		SELECT 
		clerical_homework.ID
		FROM clerical_homework 
		INNER JOIN config_emp ON clerical_homework.subjectEmpID = config_emp.ID
		WHERE config_emp.EmpID = " . $EmpID . "  
		 ");
		} else {
			$getReport = $this->db->query("
			SELECT 
			clerical_homework.ID
			FROM clerical_homework 
			INNER JOIN config_emp ON clerical_homework.subjectEmpID = config_emp.ID
			WHERE config_emp.EmpID = " . $EmpID . "  
			AND 
			(DATE(clerical_homework.Date)	 BETWEEN CAST('" . $DayDateFrom . "' AS DATE ) AND CAST('" . $DayDateTo . "' AS DATE  ))
			 ");
		}
		return (int)$getReport->num_rows();
	} //////get_emp
	public function get_emp($Lang = NULL)
	{
		$NameArray   = array("Name" => "Name AS LevelName");
		if ($Lang == "english") {
			array("Name" => "Name_en AS LevelName");
		}
		$GetData = $this->db->query("
		SELECT 
		contact.ID ,
		contact.Name ,
		employee.NumLesson AS EmpNumLesson ,
		employee.LevelID   AS EmpLevelID ,
		employee.NumWait   AS EmpNumWait 
		FROM 
		contact 
		INNER JOIN employee ON contact.ID       = employee.Contact_ID 
		WHERE contact.SchoolID   IN(" . $this->session->userdata('SchoolID') . ")
		AND  contact.Isactive = 1
		");
		if ($GetData->num_rows() > 0) {
			return $GetData->result();
		} else {
			return FALSE;
		}
	}
	public function emp_not_in_classtable()
	{
		$query = $this->db->query('
	    select contact.Name , school_details.SchoolName 
        FROM contact
        INNER JOIN school_details on school_details.ID = contact.SchoolID
        INNER join employee on employee.Contact_ID = contact.ID
        where employee.jobTitleID = 0 and contact.Type = "E" and  school_details.ID ="' . $this->session->userdata('SchoolID') . '" and
        contact.ID NOT in (SELECT class_table.ConID FROM class_table GROUP BY class_table.EmpID ) AND contact.Isactive = 1
        ');
		return $query->result();
	}
	//////
	public function get_all_emp($Lang = NULL, $lavelID, $RowLevelID, $classID, $subjectID, $dateFrom, $dateTo)
	{

		$lavelClass = '';
		if ($lavelID != 'NULL') {
			$lavelClass = " and row_level.ID in (select row_level.ID from row_level where row_level.Level_ID = " . $lavelID . " group by  row_level.ID  )";
		}
		$GetData = $this->db->query(" call usp_EMPRPT(" . $lavelID . "," . $RowLevelID . "," . $this->session->userdata('SchoolID') . "," . $classID . "," . $subjectID . ",'" . $dateFrom . "','" . $dateTo . "')");
		$this->db->reconnect();
		if ($GetData->num_rows() > 0) {

			$result = $GetData->result();
			mysqli_next_result($this->db->conn_id);
			$bussines = [];
			foreach ($result as $number) {
				$emp = get_emp_select_in();
				$PerType = explode(',', $emp);
				if (in_array($number->conID, $PerType)) {
					$bussines[] = $number;
				}
			}
			$type = $this->session->userdata('type');
			if ($type == 'U') {
				return $GetData->result();
			} else {
				return $bussines;
			}
		} else {
			return FALSE;
		}
	}
	//////get_emp_with_in
	public function get_all_emp_permission($Lang = NULL, $lavelID, $RowLevelID, $classID, $subjectID, $dateFrom, $dateTo)
	{
		$dateFromMinus = 'NULL';
		$dateToplus    = 'NULL';
		if ($dateTo !== NULL) {
			$thirtyDaysUnixplus  = strtotime('+1 day', strtotime($dateTo));
			$dateToplus          = date("Y-m-d", $thirtyDaysUnixplus);
		}
		if ($dateFrom !== NULL) {
			$thirtyDaysUnixMinus = strtotime('-1 day', strtotime($dateFrom));
			$dateFromMinus       = date("Y-m-d", $thirtyDaysUnixMinus);
		}

		$getType = $this->db->query('
        		select contact.type as typeUser, employee.Type , PerType from  employee 
        		inner join contact on contact.ID = employee.Contact_ID
        		where Contact_ID = "' . $this->session->userdata('id') . '" 
				')->row();
		$whereLevel = "Level_ID  = " . $lavelID . " ";
		$whereRowLevel = "ID  = " . $RowLevelID . " ";
		$whereclass = "ClassID  = " . $classID . " ";
		// add this for column Clerical_homework classID not === ClassID in var $whereclass 
		$whereclassClerical_homework = " classID = " . $classID . " ";
		$whereSubjectID = "SubjectID = " . $subjectID . " ";
		// add this for column LessonPrep Subject_ID not === SubjectID in var $whereclass 
		$whereLessonPrepSubjectID = "Subject_ID = " . $subjectID . " ";
		// use this for Type 1 and 2 and 3 
		if ($subjectID == 'NULL') {
			$GetDataSubject = $this->db->query("SELECT GROUP_CONCAT(ID) as allSubject FROM subject  ")->row();
			$whereSubjectID = "SubjectID IN(" . $GetDataSubject->allSubject . ") ";
			$whereLessonPrepSubjectID = "Subject_ID IN(" . $GetDataSubject->allSubject . ")";
		}
		if ($getType->Type == 1) {

			if ($lavelID == 'NULL') {
				$whereLevel = "Level_ID IN(" . $getType->PerType . ") ";
			}
			// get all rowLevel when user permission in Level
			$GetDatarowLevel = $this->db->query("SELECT GROUP_CONCAT(ID) as allRowLevel FROM `row_level` WHERE row_level.Level_ID IN(" . $getType->PerType . ") ")->row();
			if ($RowLevelID == 'NULL') {
				$whereRowLevel = "ID IN(" . $GetDatarowLevel->allRowLevel . ") ";
			}
			// get all class when user permission in Level
			$GetDataclass = $this->db->query("SELECT GROUP_CONCAT(ClassID) as allClass FROM school_class WHERE school_class.SchoolID  =" . $this->session->userdata('SchoolID') . " ")->row();
			if ($classID == 'NULL') {
				$whereclass = "ClassID IN(" . $GetDataclass->allClass . ") ";
				$whereclassClerical_homework = " classID  IN(" . $GetDataclass->allClass . ") ";
			}
		} elseif ($getType->Type == 2) {
			// get level when user permission in rowLevel
			$GetData = $this->db->query("SELECT GROUP_CONCAT(Level_ID) as allLevel FROM `row_level` WHERE row_level.ID IN(" . $getType->PerType . ") ")->row();
			if ($lavelID == 'NULL') {
				$whereLevel = "Level_ID IN(" . $GetData->allLevel . ") ";
			}
			if ($RowLevelID == 'NULL') {
				$whereRowLevel = "ID IN(" . $getType->PerType . ") ";
			}
			// get all class when user permission in rowLevel
			$GetDataclass = $this->db->query("SELECT GROUP_CONCAT(ClassID) as allClass FROM school_class WHERE school_class.SchoolID  = " . $this->session->userdata('SchoolID') . " ")->row();
			if ($classID == 'NULL') {
				$whereclass = "ClassID IN(" . $GetDataclass->allClass . ") ";
				$whereclassClerical_homework = " classID  IN(" . $GetDataclass->allClass . ") ";
			}
		} elseif ($getType->Type == 3) {
			$allClass    = array();
			$allRowLevel = array();
			foreach (explode(",", $getType->PerType) as $key => $item) {
				$rowLevelAndClass = explode('|', $item);
				$allRowLevel[$key] = $rowLevelAndClass[0];
				$allClass[$key]    = $rowLevelAndClass[1];
			}
			$GetData = $this->db->query("SELECT GROUP_CONCAT(Level_ID) as allLevel FROM `row_level` WHERE row_level.ID IN(" . implode(',', $allRowLevel) . ") ")->row();
			if ($lavelID == 'NULL') {
				$whereLevel = "Level_ID IN(" . $GetData->allLevel . ") ";
			}
			if ($RowLevelID == 'NULL') {
				$whereRowLevel = "ID IN(" . implode(',', $allRowLevel) . ") ";
			}
			if ($classID == 'NULL') {
				$whereclass = "ClassID IN(" . implode(',', $allClass) . ") ";
				$whereclassClerical_homework = " classID  IN(" . implode(',', $allClass) . ") ";
			}
		} elseif ($getType->Type == 4) {
			$RowLevelAndSubject = $this->db->query("SELECT GROUP_CONCAT(RowLevelID) as allRowLevelID , GROUP_CONCAT(SubjectID) as allSubjectID FROM `config_subject` WHERE config_subject.ID IN(" . $getType->PerType . ") ")->row();
			if ($RowLevelID == 'NULL') {
				$whereRowLevel = "ID IN(" . $RowLevelAndSubject->allRowLevelID . ") ";
			}
			$GetData = $this->db->query("SELECT GROUP_CONCAT(Level_ID) as allLevel FROM `row_level` WHERE row_level.ID IN(" . $RowLevelAndSubject->allRowLevelID . ") ")->row();
			if ($lavelID == 'NULL') {
				$whereLevel = "Level_ID IN(" . $GetData->allLevel . ") ";
			}
			// get all class when user permission in rowLevel
			$GetDataclass = $this->db->query("SELECT GROUP_CONCAT(ClassID) as allClass FROM school_class WHERE school_class.SchoolID  =" . $this->session->userdata('SchoolID') . " ")->row();
			if ($classID == 'NULL') {
				$whereclass = "ClassID IN(" . $GetDataclass->allClass . ") ";
				$whereclassClerical_homework = " classID  IN(" . $GetDataclass->allClass . ") ";
			}
			if ($subjectID == 'NULL') {
				$whereSubjectID = "SubjectID IN(" . $RowLevelAndSubject->allSubjectID . ") ";
				$whereLessonPrepSubjectID = "Subject_ID IN(" . $RowLevelAndSubject->allSubjectID . ")";
			}
		}
		$lavelClass = '';
		if ($lavelID != 'NULL') {
			$lavelClass = " and row_level.ID in (select row_level.ID from row_level where row_level.Level_ID = " . $lavelID . " group by  row_level.ID  )";
		}
		$GetData = $this->db->query("
	        SELECT contact.Name as nameUser , contact.ID as conID ,contact.LastLogin,
	        GROUP_CONCAT(DISTINCT  row_level.Level_Name) as allLavelName ,GROUP_CONCAT(DISTINCT  subject.Name) as allSubjectName ,
	        count(class_table.ID) as newCount ,
            (
            select count(DISTINCT plan1.FileAttach) from plan_week as plan1 
            inner join class_table as class_table1 on class_table1.ID = plan1.ClassTableID
            inner join row_level as rowLavelPlan on class_table1.RowLevelID = rowLavelPlan.ID
            where class_table1.EmpID = contact.ID 
            AND rowLavelPlan." . $whereLevel . " 
            AND rowLavelPlan." . $whereRowLevel . "
            AND class_table1." . $whereclass . "
            AND class_table1." . $whereSubjectID . "
            AND (case WHEN " . $dateFromMinus . " IS NULL THEN plan1.Date_Stm = plan1.Date_Stm ELSE ( plan1.Date_Stm BETWEEN cast('" . $dateFromMinus . "' as DATE )  and  cast('" . $dateToplus . "' as DATE ) ) END )
            AND (plan1.Content !='' or plan1.FileAttach is not NULL)
            
            ) as countPlan1 ,
            (
            select count(e_library.ID) from e_library 
            inner join row_level as rowLavelLibrary on rowLavelLibrary.ID = e_library.RowLevelID
            where e_library.ContactID = contact.ID 
            AND rowLavelLibrary." . $whereLevel . " 
            AND rowLavelLibrary." . $whereRowLevel . "
            AND e_library." . $whereSubjectID . "
            AND (case WHEN " . $dateFromMinus . " IS NULL THEN e_library.Stm_Date = e_library.Stm_Date ELSE ( e_library.Stm_Date BETWEEN cast('" . $dateFromMinus . "' as DATE )  and  cast('" . $dateToplus . "' as DATE ) ) END )
            ) as countLib ,
            (
            select count(lesson_prep.ID) from lesson_prep 
            inner join row_level as rowLavelPrep on rowLavelPrep.ID = lesson_prep.RowLevel_ID
            where lesson_prep.Teacher_ID = contact.ID
            AND rowLavelPrep." . $whereLevel . " 
            AND rowLavelPrep." . $whereRowLevel . "
            AND lesson_prep." . $whereLessonPrepSubjectID . "
            AND (case WHEN " . $dateFromMinus . " IS NULL THEN lesson_prep.Date = lesson_prep.Date ELSE ( lesson_prep.Date BETWEEN cast('" . $dateFromMinus . "' as DATE )  and  cast('" . $dateToplus . "' as DATE ) ) END )
            ) as countLessonPrep ,
            (
            select count(clerical_homework.ID) from  config_emp
            INNER JOIN clerical_homework ON clerical_homework.subjectEmpID = config_emp.ID
            INNER JOIN row_level as row_levelClerical on row_levelClerical.ID = config_emp.RowLevelID
            WHERE config_emp.EmpID = contact.ID 
            AND row_levelClerical." . $whereLevel . " 
            AND row_levelClerical." . $whereRowLevel . "
            AND clerical_homework." . $whereclassClerical_homework . "
            AND config_emp." . $whereSubjectID . "
            AND (case WHEN " . $dateFromMinus . " IS NULL THEN clerical_homework.Date = clerical_homework.Date ELSE ( clerical_homework.Date BETWEEN cast('" . $dateFromMinus . "' as DATE )  and  cast('" . $dateToplus . "' as DATE ) ) END )
            AND (clerical_homework.title !=''  ) 
            ) as countClericalHomework,
            (
            select count(test.ID) from config_emp as config_emp1
            inner join test on test.Subject_emp_ID = config_emp1.ID
            INNER JOIN row_level as row_levelTest on row_levelTest.ID = config_emp1.RowLevelID
            where config_emp1.EmpID = contact.ID AND test.type = 0
            AND row_levelTest." . $whereLevel . " 
            AND row_levelTest." . $whereRowLevel . "
            AND config_emp1." . $whereSubjectID . "
            AND (case WHEN " . $dateFromMinus . " IS NULL THEN test.Date_Stm = test.Date_Stm ELSE ( test.Date_Stm BETWEEN cast('" . $dateFromMinus . "' as DATE )  and  cast('" . $dateToplus . "' as DATE ) ) END )
           
            ) as countTest ,
            (
            select count(test.ID) from config_emp as config_emp1
            inner join test on test.Subject_emp_ID = config_emp1.ID
            INNER JOIN row_level as row_levelTest on row_levelTest.ID = config_emp1.RowLevelID
            where config_emp1.EmpID = contact.ID AND test.type = 1
            AND row_levelTest." . $whereLevel . "
            AND row_levelTest." . $whereRowLevel . "
            AND config_emp1." . $whereSubjectID . "
            AND (case WHEN " . $dateFromMinus . " IS NULL THEN test.Date_Stm = test.Date_Stm ELSE ( test.Date_Stm BETWEEN cast('" . $dateFromMinus . "' as DATE )  and  cast('" . $dateToplus . "' as DATE ) ) END )
           
            ) as countHomework 
            from class_table
            left join contact on contact.ID = class_table.EmpID 
            left join employee on employee.Contact_ID = class_table.EmpID
            inner join row_level on row_level.ID = class_table.RowLevelID
            inner join subject on subject.ID = class_table.SubjectID
            where employee.jobTitleID = 0 and contact.SchoolID  IN(" . $this->session->userdata('SchoolID') . ")
            AND row_level." . $whereLevel . "
            AND row_level." . $whereRowLevel . "
            AND class_table." . $whereclass . "
			AND class_table." . $whereSubjectID . "
			AND (case WHEN " . $dateFromMinus . " IS NULL THEN contact.LastLogin = contact.LastLogin ELSE  contact.LastLogin BETWEEN cast('" . $dateFromMinus . "' as DATE )  and  cast('" . $dateToplus . "' as DATE  ) END )
			AND (case WHEN " . $dateFromMinus . " IS NULL THEN class_table.Date_Stm = class_table.Date_Stm ELSE  class_table.Date_Stm BETWEEN cast('" . $dateFromMinus . "' as DATE )  and  cast('" . $dateToplus . "' as DATE  ) END )
			group by class_table.EmpID 
		");
		//print_r($this->db->last_query());exit();
		if ($GetData->num_rows() > 0) {
			return $GetData->result();
		} else {
			return FALSE;
		}
	}
	/////////////////////////////get_class_table_row
	public function get_class_table_row($ID = 0, $Lang = NULL)
	{
		$NameArray = array(
			"Day" => "Name AS DayName", "Lesson" => "lesson As LessonName ", "Level" => "Name AS LevelName",
			"row" => "Name AS RowName", "class" => "Name AS ClassName"
		);
		if ($Lang == "english") {
			$NameArray = array(
				"Day" => "Name_en AS DayName", "Lesson" => "Lesson_en As LessonName ", "Level" => "Name_en AS LevelName",
				"row" => " Name_en AS RowName", "class" => "Name_en AS ClassName"
			);
		}
		$query = $this->db->query("
			 SELECT 
			 class_table.ID AS ClassTableID ,
			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
			 level." . $NameArray['Level'] . ",
			 row." . $NameArray['row'] . ",
			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
			 class." . $NameArray['class'] . " ,
			 subject.Name   AS SubjectName ,
			 lesson." . $NameArray['Lesson'] . " ,
			 day." . $NameArray['Day'] . "
			 FROM 
			 class_table
			 INNER JOIN base_class_table ON class_table.BaseTableID = base_class_table.ID
			 INNER JOIN day              ON class_table.Day_ID      = day.ID
			 INNER JOIN subject          ON class_table.SubjectID   = subject.ID
			 INNER JOIN lesson           ON class_table.Lesson      = lesson.ID
			 INNER JOIN class            ON class_table.ClassID     = class.ID
			 INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID        = row.ID
			 INNER JOIN level            ON row_level.Level_ID      = level.ID
			 WHERE 
			 class_table.EmpID = " . $ID . "
			 GROUP BY level.ID
			");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	} /////////////////////////////get_class_table_row
	public function get_student($Lang = NULL, $LevelID = 0, $RowLevelID = 0, $ClassID = 0)
	{
		$Lang=$this->session->userdata('language');
		$R_L_ID_array = get_rowlevel_select_in();
		$Class_array = get_class_select_in();
		$Student  = get_student_select_in();

		if ($LevelID == 0) {
			$LevelID = 'NULL';
		}
		if ($RowLevelID == 0) {
			$RowLevelID = 'NULL';
		}
		if ($ClassID == 0) {
			$ClassID = 'NULL';
		}

		$NameArray = array("Level" => "Level_Name AS LevelName", "row" => "Row_Name AS RowName", "class" => "Name AS ClassName", 'SchoolName' => "SchoolName", 'contact' => "Name AS FullName");
		if ($Lang == "english") {
			$NameArray = array("Level" => "Level_Name_en AS LevelName", "row" => " Row_Name_en AS RowName", "class" => "Name_en AS ClassName", 'SchoolName' => "SchoolNameEn", 'contact' => "Name_en AS FullName");
		}
		$query = $this->db->query("
			 SELECT
			 row_level.Level_ID       AS LevelID,
			 row_level.Row_ID         AS RowID,
			 class.ID       AS ClassID,
			 row_level." . $NameArray['Level'] . ",
			 row_level." . $NameArray['row'] . ",
			 row_level.ID   As RowLevelID ,
			 student.Class_ID    As student_Class_ID  ,
			 class.ID       As ClassID ,
			 class." . $NameArray['class'] . " ,
			 school_details.SchoolName , 
			 tb1.ID         AS StudentID,
			 CASE
            WHEN '$Lang' = 'english' and tb1.Name_en IS not NULL and tb1.Name_en !=' ' THEN tb1.Name_en
            ELSE tb1.Name
            END AS FullName ,
			 CASE
			 WHEN tb1.Name_en IS NULL  or tb1.Name_en=' ' THEN tb1.Name
			 ELSE tb1.Name_en
			 END AS Name_EN ,
			 tb1.User_Name  AS StudentUserName,
			 tb2.ID         AS FatherID ,
			 CASE WHEN LENGTH(tb2.Mobile) >= 9 THEN tb2.Mobile ELSE tb2.Phone END AS MobilFather,
			  tb1.LastLogin,
			 tb2.User_Name AS FatherUserName,
			 tb1.motherName,
			 tb1.motherMobile,
			 tb1.GR_Number
			 FROM contact As tb1
			 INNER JOIN student ON tb1.ID = student.Contact_ID
			 INNER JOIN contact AS tb2 ON student.Father_ID     = tb2.ID
			 INNER JOIN class            ON student.Class_ID    = class.ID   
			 AND 
			 student.Class_ID      = IFNULL($ClassID,class.ID)
			 INNER JOIN row_level        ON student.R_L_ID      = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID    = row.ID
			 INNER JOIN level            ON row_level.Level_ID  = level.ID
			 LEFT JOIN school_details    ON tb1.SchoolID  = school_details.ID
			 WHERE tb1.SchoolID  IN(" . $this->session->userdata("SchoolID") . ")
			 AND 
		     tb1.ID IN(" . $Student . ")
			 AND 
			 student.R_L_ID IN(" . $R_L_ID_array . ")
			 AND
			 student.Class_ID IN(" . $Class_array . ")
			 AND
			 row_level.Level_ID      = IFNULL($LevelID,level.ID)
			 AND 
			 row_level.ID  = IFNULL($RowLevelID,row_level.ID)
			 AND 
			 class.ID      = IFNULL($ClassID,class.ID)
			 AND 
			 student.Class_ID      = IFNULL($ClassID,class.ID)
			 AND tb1.Isactive  = 1
			 AND tb1.Type      = 'S' 
		    group by tb1.ID
			order by FullName asc
			");
		//	print_r($this->db->last_query());
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	//////////////////////////////////////
	public function get_student_emp($Lang = NULL, $LevelID = 0, $RowLevelID = 0, $ClassID = 0)
	{

		if ($LevelID == 0) {
			$LevelID = 'NULL';
		}
		if ($RowLevelID == 0) {
			$RowLevelID = 'NULL';
		}
		if ($ClassID == 0) {
			$ClassID = 'NULL';
		}

		$NameArray = array("Level" => "Name AS LevelName", "row" => "Name AS RowName", "class" => "Name AS ClassName", 'SchoolName' => "SchoolName");
		if ($Lang == "english") {
			$NameArray = array("Level" => "Name_en AS LevelName", "row" => " Name_en AS RowName", "class" => "Name_en AS ClassName", 'SchoolName' => "SchoolNameEn");
		}
		$query = $this->db->query("
			 SELECT
			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
			 level." . $NameArray['Level'] . ",
			 row." . $NameArray['row'] . ",
			 row_level.ID   As RowLevelID ,
			 student.Class_ID    As student_Class_ID  ,
			 class.ID       As ClassID ,
			 class." . $NameArray['class'] . " ,
			 school_details.SchoolName , 
			 tb1.ID AS StudentID,
			 tb1.Name AS FullName,
			 tb1.User_Name AS StudentUserName,
			 tb2.ID AS FatherID ,
			 tb2.Mobile AS MobilFather ,
			  tb1.LastLogin,
			 tb2.User_Name AS FatherUserName
			 FROM contact As tb1
			 INNER JOIN student ON tb1.ID = student.Contact_ID
			 INNER JOIN contact AS tb2 ON student.Father_ID     = tb2.ID
			 INNER JOIN class            ON student.Class_ID    = class.ID   
			 AND 
			 student.Class_ID      = IFNULL($ClassID,class.ID)
			 INNER JOIN row_level        ON student.R_L_ID      = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID    = row.ID
			 INNER JOIN level            ON row_level.Level_ID  = level.ID
			 LEFT JOIN school_details    ON tb1.SchoolID  = school_details.ID
			 WHERE tb1.SchoolID  IN(" . $this->session->userdata("SchoolID") . ")
			 AND level.ID      = IFNULL($LevelID,level.ID)
			 AND row_level.ID  = IFNULL($RowLevelID,row_level.ID)
			 AND class.ID      = IFNULL($ClassID,class.ID)
			 AND student.Class_ID      = IFNULL($ClassID,class.ID)
			 AND tb1.Isactive = 1 
		     AND tb2.Isactive = 1 
			");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	/////////////////////////////
	public function get_all_student($data)
	{

		extract($data);
		$Class_array = get_class_select_in();
		$Student_new  = get_student_select_in() ;
		if ($level == 0) {
			$level = 'NULL';
		}
		if ($RowLevel == 0) {
			$RowLevel = 'NULL';
		}
		if ($Classgg == 0) {
			$Classgg = 'NULL';
		}

		if ($year_id == $current_year_id) {

			$student     = "student";

			$contact     = "contact";

			$whereStudent = "AND tb1.ID IN($Student_new)";
		} else {

			$student = "student_certificate";

			$contact = "contact_certificate";

			// if ($this->ApiDbname == "SchoolAccAsrAlMawaheb") {

				$whereYear = "AND tb1.yearID = $year_id AND tb2.yearID = $year_id AND $student.yearID = $year_id";
			// }
		}
		if ($Branche == 0) {
			if ($this->session->userdata('type') == "U") {
				$query_admin = $this->db->query("SELECT SchoolID  FROM contact WHERE ID = '" . $this->session->userdata('id') . "' ")->row_array();
				$school = explode(",", $query_admin['SchoolID']);
				if ($query_admin['SchoolID'] == 0 || $school[1] != "") {
					if ($query_admin['SchoolID'] == 0) {
						$query = $this->db->query("SELECT ID  as Name FROM school_details ")->result();
						$Branche = 'NULL';
						$whereschool = "tb1.SchoolID = IFNULL($Branche,tb1.SchoolID)";
					} elseif ($school[1] != "") {
						$query = $this->db->query("SELECT ID  as Name FROM school_details WHERE ID IN(" . $query_admin['SchoolID'] . ") ")->result();
						$Branche = $query_admin['SchoolID'];
						$whereschool = "tb1.SchoolID IN($Branche)";
					}
				} else {
					$query = $this->db->query("SELECT ID  as Name FROM school_details WHERE ID  =" . $this->session->userdata('SchoolID') . " ")->result();
					$Branche = $this->session->userdata('SchoolID');
					$whereschool = "tb1.SchoolID =$Branche";
				}
			} else {
				$query_emp = $this->db->query("SELECT Branch  FROM contact
    	        inner join employee on contact.ID=employee.Contact_ID
    	        WHERE contact.ID = '" . $this->session->userdata('id') . "' ")->row_array();
				$query = $this->db->query("SELECT ID  as Name FROM school_details WHERE ID IN(" . $query_emp['Branch'] . ") ")->result();
				$Branche = $query_emp['Branch'];
				$whereschool = "tb1.SchoolID IN($Branche)";
			}
		} else {
			$whereschool = "tb1.SchoolID =$Branche";
		}

		$NameArray = array("Level" => "Level_Name AS LevelName", "row" => "Row_Name AS RowName", "class" => "Name AS ClassName", 'SchoolName' => "SchoolName AS SchoolName");
		if ($Lang == "english") {
			$NameArray = array("Level" => "Level_Name_en AS LevelName", "row" => " Row_Name_en AS RowName", "class" => "Name_en AS ClassName", 'SchoolName' => "SchoolNameEn AS SchoolName ");
		}
		$query = $this->db->query("
			 SELECT
			 row_level.Level_ID       AS LevelID,
			 row_level.Row_ID         AS RowID,
			 class.ID       AS ClassID,
			 row_level." . $NameArray['Level'] . ",
			 school_details." . $NameArray['SchoolName'] . " , 
			 row_level." . $NameArray['row'] . ",
			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
			 class." . $NameArray['class'] . " ,
			 school_details.ID AS SchoolID , 
			 tb1.ID AS StudentID,
			 CASE
            WHEN '$Lang' = 'english' and tb1.Name_en IS not NULL and tb1.Name_en !=' ' THEN tb1.Name_en
            ELSE tb1.Name
            END AS StudentName ,
			 CASE
            WHEN tb1.Name_en IS NULL or tb1.Name_en=' ' THEN tb1.Name
            ELSE tb1.Name_en
            END AS Name_EN ,
			 tb1.User_Name AS StudentUserName,
			 tb2.ID AS FatherID ,
			 CASE WHEN LENGTH(tb2.Phone) >= 9 THEN tb2.Phone ELSE tb2.Mobile END AS MobilFather,
			 tb2.User_Name AS FatherUserName,
			 tb1.motherName,
			 tb1.motherMobile,
			 tb1.GR_Number,
			 tb1.Number_ID
			 FROM $contact As tb1
			 INNER JOIN $student ON tb1.ID = $student.Contact_ID
			 INNER JOIN $contact AS tb2 ON $student.Father_ID     = tb2.ID
			 INNER JOIN class            ON $student.Class_ID    = class.ID
			 INNER JOIN row_level        ON $student.R_L_ID      = row_level.ID
			 INNER JOIN school_details    ON tb1.SchoolID  = school_details.ID
			 WHERE $whereschool
			 AND tb1.Isactive = 1 
			 AND tb1.Type = 'S'
			 AND row_level.Level_ID      = IFNULL($level,row_level.Level_ID)
			 AND row_level.ID  = IFNULL($RowLevel,row_level.ID)
			 AND class.ID      = IFNULL($Classgg,class.ID)
			 and $student.R_L_ID
			 $whereYear
			 $whereStudent
			 group by tb1.ID
			 order by StudentName asc
		    
			");

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	/////////////////////////get_eval_subject
	public function get_eval_subject($ID = 0)
	{
		$this->db->select('*');
		$this->db->from('evaluation_rules');
		$this->db->where('EmpID', $ID);
		$this->db->limit(1);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return FALSE;
		}
	} ////////////////////////get_report_eval
	public function get_report_eval($YearID, $Lang = NULL, $EmpPer = 0, $UserID)
	{
		//print_r($EmpPer);die;
		$query = $this->db->query("
		SELECT
		emp_evaluation.Degree    AS EmpDegree ,
		emp_evaluation.DateStm   AS EvaluationDateStm,
		emp_evaluation.ID        AS emp_evaluation_ID,
		evaluation_elements.Name AS EvalElement ,
		evaluation_note.Name     AS EvalNote ,
		contact.ID               AS ContactID,
		contact.Name             AS ContactName ,
		contactEmp.Name          AS ContactNameEmp ,
		contactEmp.ID            AS ContactEmpID,
		emp_evaluation.Note 
		FROM
		emp_evaluation
		LEFT JOIN contact               ON emp_evaluation.ContactID    = contact.ID
		LEFT JOIN contact As contactEmp ON emp_evaluation.EmpID        = contactEmp.ID
		LEFT JOIN evaluation_note       ON emp_evaluation.noteID       = evaluation_note.ID
		LEFT JOIN evaluation_elements   ON evaluation_note.elementID   = evaluation_elements.ID
		WHERE   contact.Isactive = 1
		 AND contactEmp.ID IN (" . $EmpPer . ")
		 AND contact.ID=" . $UserID . "
		");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	public function get_report_eval1($YearID, $Lang = NULL, $EmpPer = 0, $ContactID, $ContactEmpID, $datee, $Semesterid)
	{
		//print_r($EmpPer);die;
		$query = $this->db->query("
		SELECT
		emp_evaluation.Degree    AS EmpDegree ,
		emp_evaluation.date   AS EvaluationDateStm,
		emp_evaluation.ID        AS emp_evaluation_ID,
		evaluation_elements.Name AS EvalElement ,
		evaluation_note.Name     AS EvalNote ,
		contact.ID               AS ContactID,
		contact.Name             AS ContactName ,
		contactEmp.Name          AS ContactNameEmp ,
		contactEmp.ID            AS ContactEmpID,
		emp_evaluation.Note ,
	    
	    evaluation_note.NoteDegree as NoteDegree
	    
		FROM
		emp_evaluation
		LEFT JOIN contact               ON emp_evaluation.ContactID    = contact.ID
		LEFT JOIN contact As contactEmp ON emp_evaluation.EmpID        = contactEmp.ID
		LEFT JOIN evaluation_note       ON emp_evaluation.noteID       = evaluation_note.ID
		LEFT JOIN evaluation_elements   ON evaluation_note.elementID   = evaluation_elements.ID
		WHERE   contact.Isactive = 1
		AND contactEmp.ID =" . $ContactEmpID . "
		AND contact.ID=" . $ContactID . "
		AND emp_evaluation.date  LIKE '%$datee%'
		AND emp_evaluation.semesterID IN($Semesterid)
		");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	} //////get_report_level
	public function get_report_eval5($YearID, $Lang = NULL, $EmpPer = 0, $ContactID, $ContactEmpID, $datee, $Semesterid)
	{
		//print_r($EmpPer);die;
		$query = $this->db->query("
		SELECT
		emp_evaluation.Degree    AS EmpDegree ,
		emp_evaluation.DateStm   AS EvaluationDateStm,
		emp_evaluation.ID        AS emp_evaluation_ID,
		evaluation_elements.Name AS EvalElement ,
		evaluation_note.Name     AS EvalNote ,
		contact.ID               AS ContactID,
		contact.Name             AS ContactName ,
		contactEmp.Name          AS ContactNameEmp ,
		contactEmp.ID            AS ContactEmpID,
		emp_evaluation.Note ,
	    sum(emp_evaluation.Degree) as s_Degree,
	    evaluation_note.NoteDegree as NoteDegree,
	    sum(evaluation_note.NoteDegree) as s_NoteDegree
	    
		FROM
		emp_evaluation
		LEFT JOIN contact               ON emp_evaluation.ContactID    = contact.ID
		LEFT JOIN contact As contactEmp ON emp_evaluation.EmpID        = contactEmp.ID
		LEFT JOIN evaluation_note       ON emp_evaluation.noteID       = evaluation_note.ID
		LEFT JOIN evaluation_elements   ON evaluation_note.elementID   = evaluation_elements.ID
		WHERE   contact.Isactive = 1
		AND contactEmp.ID =" . $ContactEmpID . "
		AND contact.ID=" . $ContactID . "
		AND emp_evaluation.date LIKE '%$datee%'
		AND emp_evaluation.semesterID IN($Semesterid)
		");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	} //////get_report_level
	public function get_report_eval2($YearID, $Lang = NULL, $EmpPer = 0, $UserID)
	{
		$newDate = date("d-m-Y", strtotime($EvaluationDateStm));
		$query = $this->db->query("
		SELECT
		emp_evaluation.Degree    AS EmpDegree ,
		SUM(emp_evaluation.Degree) as s_EmpDegree,
		evaluation_note.NoteDegree as NoteDegree,
		SUM(evaluation_note.NoteDegree) AS s_NoteDegree,
		(SUM(emp_evaluation.Degree))*100/(SUM(evaluation_note.NoteDegree)) as precentage,
	    emp_evaluation.date      AS EvaluationDateStm,
		emp_evaluation.ID        AS emp_evaluation_ID,
		evaluation_elements.Name AS EvalElement ,
		evaluation_note.Name     AS EvalNote ,
		contact.ID               AS ContactID,
		contact.Name             AS ContactName ,
		contactEmp.Name          AS ContactNameEmp ,
		contactEmp.ID            AS ContactEmpID,
		emp_evaluation.Note 
		FROM
		emp_evaluation
		LEFT JOIN contact               ON emp_evaluation.ContactID    = contact.ID
		LEFT JOIN contact As contactEmp ON emp_evaluation.EmpID        = contactEmp.ID
		LEFT JOIN evaluation_note       ON emp_evaluation.noteID       = evaluation_note.ID
		LEFT JOIN evaluation_elements   ON evaluation_note.elementID   = evaluation_elements.ID
		WHERE   emp_evaluation.semesterID = " . $Semesterid . "
		AND  contact.Isactive = 1
		 
		 AND  contact.ID=" . $UserID . "
		  AND  contactEmp.ID in(" . $EmpPer . ")
		 group by contactEmp.ID ,CAST(emp_evaluation.date AS DATE)
		");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}

	public function emp_eval_report_details($data)
	{
		extract($data);

		$query = $this->db->query("
		SELECT
		emp_evaluation.Degree    AS EmpDegree ,
		SUM(emp_evaluation.Degree) as s_EmpDegree,
		evaluation_note.NoteDegree as NoteDegree,
		SUM(evaluation_note.NoteDegree) AS s_NoteDegree,
		(SUM(emp_evaluation.Degree))*100/(SUM(evaluation_note.NoteDegree)) as precentage,
	    emp_evaluation.date      AS EvaluationDateStm,
		emp_evaluation.ID        AS emp_evaluation_ID,
		evaluation_elements.Name AS EvalElement ,
		evaluation_note.Name     AS EvalNote ,
		contact.ID               AS ContactID,
		contact.Name             AS ContactName ,
		contactEmp.Name          AS ContactNameEmp ,
		contactEmp.ID            AS ContactEmpID,
		emp_evaluation.visit_type,
		emp_evaluation.visit_number,
		emp_evaluation.topic,
		emp_evaluation.class,
		emp_evaluation.Note 
		FROM
		emp_evaluation
		LEFT JOIN contact               ON emp_evaluation.ContactID    = contact.ID
		LEFT JOIN contact As contactEmp ON emp_evaluation.EmpID        = contactEmp.ID
		LEFT JOIN evaluation_note       ON emp_evaluation.noteID       = evaluation_note.ID
		LEFT JOIN evaluation_elements   ON evaluation_note.elementID   = evaluation_elements.ID
		WHERE   emp_evaluation.semesterID IN(" . $Semesterid . ")
		AND  contact.Isactive = 1
		AND  contact.ID =" . $UserID . "
		AND  contactEmp.ID in(" . $GetEmpper . ")
		group by contactEmp.ID ,CAST(emp_evaluation.date AS DATE)
		");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	public function  get_report_level($Lang = NULL)
	{
		$LangArray = array();
		if ($Lang == 'arabic') {
			$LangArray['Name'] = 'Name';
		} else {
			$LangArray['Name'] = 'Name_en';
		}
		$GetLevel =  $this->db->query("SELECT  ID , " . $LangArray['Name'] . " FROM level WHERE Is_Active = 1  ");
		//echo "SELECT  ID , '".$LangArray['Name'] ."' FROM level WHERE Is_Active = 1  " ;exit;
		if ($GetLevel->num_rows() > 0) {
			return $GetLevel->result();
		} else {
			return FALSE;
		}
	} //////get_emp_level
	public function  get_emp_level($LevelID = 0, $RowLevelID = 0, $ClassID = 0)
	{

		$emp = get_emp_select_in();

		if ($LevelID == 0) {
			$LevelID = 'NULL';
		}
		if ($RowLevelID == 0) {
			$RowLevelID = 'NULL';
		}
		if ($ClassID == 0) {
			$ClassID = 'NULL';
		}
		$GetEmp =  $this->db->query("
		SELECT
		contact.Name
		FROM
        class_table
        INNER JOIN contact   ON class_table.EmpID      = contact.ID
        INNER JOIN row_level ON class_table.RowLevelID =  row_level.ID
        INNER JOIN level     ON row_level.Level_ID     = level.ID
        WHERE level.ID =  IFNULL($LevelID,level.ID)  AND 
			 row_level.ID  = IFNULL($RowLevelID,row_level.ID)
			 AND 
			 class_table.ClassID      = IFNULL($ClassID,class_table.ClassID)
		AND  contact.Isactive = 1
		AND contact.ID IN(" . $emp . ")
        GROUP BY contact.ID
		");
		if ($GetEmp->num_rows() > 0) {
			return $GetEmp->result();
		} else {
			return FALSE;
		}
	} //////emp_plan_week_report
	public function  emp_plan_week_report($ID = 0, $Lang = NULL)
	{
		$NameArray = array("Level" => "Name AS LevelName", "row" => "Name AS RowName", "class" => "Name AS ClassName", "lesson" => "lesson AS LessonName");
		if ($Lang == "english") {
			$NameArray = array("Level" => "Name_en AS LevelName", "row" => " Name_en AS RowName", "class" => "Name_en AS ClassName", "lesson" => "Lesson_en AS LessonName");
		}
		$GetEmp =  $this->db->query("
		SELECT
			  class_table.ID AS ClassTableID ,
			  subject.Name   AS SubjectName  ,
			  lesson." . $NameArray['lesson'] . " ,
			  level." . $NameArray['Level'] . ",
			  row." . $NameArray['row'] . ",
			  class." . $NameArray['class'] . ",
			  plan_week.Content  AS PlanWeek
			  FROM
			  class_table
			  INNER JOIN subject           ON class_table.SubjectID   = subject.ID
			  INNER JOIN lesson            ON class_table.Lesson      = lesson.ID
			  INNER JOIN row_level        ON class_table.RowLevelID   = row_level.ID
			  INNER JOIN row              ON row_level.Row_ID         = row.ID
			  INNER JOIN level            ON row_level.Level_ID       = level.ID
			  INNER JOIN class            ON class_table.ClassID      = class.ID
			  INNER JOIN base_class_table  ON class_table.BaseTableID = base_class_table.ID
			  LEFT JOIN plan_week          ON class_table.ID          = plan_week.ClassTableID
			  WHERE
			  class_table.empID             = " . $ID . "
			  AND
			  base_class_table.IsActive     = 1

              ORDER BY  class_table.Lesson
		");
		//echo "SELECT  ID , '".$LangArray['Name'] ."' FROM level WHERE Is_Active = 1  " ;exit;
		if ($GetEmp->num_rows() > 0) {
			return $GetEmp->result();
		} else {
			return FALSE;
		}
	}
	public function emp_report_cms()
	{
		$emp = get_emp_select_in();
		$Gettype = $this->db->query("SELECT Type from contact where ID =" . $id = $this->session->userdata('id') . "")->result();
		if ($Gettype[0]->Type == 'E') {
			$GetData = $this->db->query("
	     SELECT 
		 cms_details.contactID ,
		 contact.Name  , 
		 school_details.SchoolName
		  FROM
		 cms_details
		 LEFT  JOIN     cms_album_pic ON cms_details.ID      = cms_album_pic.item_data
		 INNER  JOIN     cms_main_sub ON cms_main_sub.ID    = cms_details.MainSubID
		 INNER  JOIN     contact ON   cms_details.contactID   = contact.ID
		 LEFT   JOIN     school_details ON contact.SchoolID = school_details.ID
		 WHERE  
		 cms_details.ContentTypeID =1 
		 AND  contact.Isactive = 1
		 AND  contact.ID IN (" . $emp . ")
		 group by  contact.ID  
		");
		} else {
			$GetData = $this->db->query("
	     SELECT 
		 cms_details.contactID ,
		 contact.Name  , 
		 school_details.SchoolName
		  FROM
		 cms_details
		 LEFT  JOIN     cms_album_pic ON cms_details.ID      = cms_album_pic.item_data
		 INNER  JOIN     cms_main_sub ON cms_main_sub.ID    = cms_details.MainSubID
		 INNER  JOIN     contact ON   cms_details.contactID   = contact.ID
		 LEFT   JOIN     school_details ON contact.SchoolID = school_details.ID
		 WHERE  
		 cms_details.ContentTypeID =1 
		 AND  contact.Isactive = 1
		 group by  contact.ID  
		");
		}
		if ($GetData->num_rows() > 0) {
			return $GetData->result();
		} else {
			return FALSE;
		}
	}
	public function sum_emp_report_cms($ContactID = 0, $SubMainID = 0)
	{
		$GetData = $this->db->query("
		SELECT 
		 	cms_details.contactID 
		 FROM
		 cms_details
		 INNER  JOIN     contact ON   cms_details.contactID   = contact.ID
		 LEFT   JOIN     school_details ON contact.SchoolID = school_details.ID
		 WHERE  
		 cms_details.contactID = '" . $ContactID . "' AND cms_details.MainSubID = '" . $SubMainID . "'
		 AND  contact.Isactive = 1
		 ");
		return $GetData->num_rows();
	}


	public function emp_eval_report($Data)
	{
		extract($Data);

		$emp = get_emp_select_in();

		if ($this->session->userdata('type') == 'U') {

			$GetSchool = $this->db->query("SELECT `SchoolID` FROM `contact` WHERE `ID` = '" . $this->session->userdata('id') . "' ")->row_array();

			$SchoolId  = $GetSchool['SchoolID'];

			if ($SchoolId != '0') {

				$where = "AND contact.SchoolID IN($SchoolId) OR contact.SchoolID = 0";
			} else {

				$where = "AND 1";
			}

			$GetData = $this->db->query("
		SELECT
		contact.ID ,
		contact.Name,
		COUNT(EmpID) AS CountEval
		FROM
		contact
		INNER JOIN emp_evaluation ON contact.ID = emp_evaluation.ContactID
		INNER JOIN contact As contactEmp ON emp_evaluation.EmpID        = contactEmp.ID
		WHERE contact.Isactive = 1 AND emp_evaluation.semesterID IN($Semesterid) AND  FIND_IN_SET('" . $this->session->userdata('SchoolID') . "' ,contact.SchoolID)
		AND  contactEmp.ID in(" . $emp . ")
		GROUP BY emp_evaluation.ContactID DESC
		");
			// 		print_r($where);die;
		} else {

			$GetData = $this->db->query("
		SELECT
		contact.ID ,
		contact.Name,
		COUNT(EmpID) AS CountEval
		FROM
		contact
		INNER JOIN emp_evaluation ON contact.ID  = emp_evaluation.ContactID
		INNER JOIN contact As contactEmp ON emp_evaluation.EmpID        = contactEmp.ID
		WHERE contact.Isactive = 1 
		AND emp_evaluation.semesterID IN($Semesterid)
	    AND  FIND_IN_SET('" . $this->session->userdata('SchoolID') . "' ,contact.SchoolID)
		AND  contactEmp.ID in(" . $emp . ")
		GROUP BY emp_evaluation.ContactID DESC
		");
		}
		if ($GetData->num_rows() > 0) {
			return $GetData->result();
		} else {
			return FALSE;
		}
	}
	public function sum_emp_eval_report($ContactID = 0)
	{
		$GetData = $this->db->query("SELECT * FROM cms_details WHERE ContactID = '" . $ContactID . "'  ");
		return $GetData->num_rows();
	}
	public function sum_emp_eval_report1($ContactID, $Semesterid)
	{
		$emp = get_emp_select_in();
		$GetData = $this->db->query("SELECT emp_evaluation.ID FROM emp_evaluation 
		INNER JOIN contact ON contact.ID  = emp_evaluation.ContactID
		WHERE emp_evaluation.ContactID  = $ContactID 
		AND emp_evaluation.semesterID IN($Semesterid) AND emp_evaluation.EmpID IN(" . $emp . ") 
		AND  FIND_IN_SET('" . $this->session->userdata('SchoolID') . "' ,contact.SchoolID)
		group by emp_evaluation.EmpID ,date");
		return $GetData->num_rows();
	}

	public function emp_eval_report_lesson($Data)
	{
		extract($Data);

		$emp = get_emp_select_in();

		if ($this->session->userdata('type') == 'U') {

			$GetSchool = $this->db->query("SELECT `SchoolID` FROM `contact` WHERE `ID` = '" . $this->session->userdata('id') . "' ")->row_array();

			$SchoolId  = $GetSchool['SchoolID'];

			if ($SchoolId != '0') {

				$where = "AND contact.SchoolID IN($SchoolId) OR contact.SchoolID = 0";
			} else {

				$where = "AND 1";
			}
			$GetData = $this->db->query("
		SELECT
		contact.ID ,
		contact.Name,
		COUNT(EmpID) AS CountEval
		FROM
		contact
		INNER JOIN lesson_prep_eval	 ON contact.ID       = lesson_prep_eval	.ContactID
		INNER JOIN config_semester ON DATE(lesson_prep_eval.DateSTM) BETWEEN config_semester.start_date AND config_semester.end_date AND config_semester.ID IN($Semesterid)
		WHERE contact.Isactive = 1 AND  '" . $this->session->userdata('SchoolID') . "' IN (contact.SchoolID)
		GROUP BY lesson_prep_eval.ContactID DESC
		");
		} else {
			$GetData = $this->db->query("
		SELECT
		contact.ID ,
		contact.Name,
		COUNT(EmpID) AS CountEval
		FROM
		contact
		INNER JOIN lesson_prep_eval	 ON contact.ID       = lesson_prep_eval	.ContactID
		INNER JOIN config_semester ON DATE(lesson_prep_eval.DateSTM) BETWEEN config_semester.start_date AND config_semester.end_date AND config_semester.ID IN($Semesterid)
		WHERE contact.Isactive = 1  AND  '" . $this->session->userdata('SchoolID') . "' IN (contact.SchoolID)
		GROUP BY lesson_prep_eval.ContactID DESC
		");
		}
		if ($GetData->num_rows() > 0) {
			return $GetData->result();
		} else {
			return FALSE;
		}
	}

	public function sum_emp_eval_report_lesson($ContactID = 0, $Semesterid)
	{
		$emp = get_emp_select_in();
		$GetData = $this->db->query("SELECT * 
                            		FROM lesson_prep_eval	
                            		inner join contact on lesson_prep_eval.EmpID = contact.ID
                            		inner join lesson_prep on lesson_prep.ID= lesson_prep_eval.LessonPrepID
                            		INNER JOIN config_semester ON DATE(lesson_prep_eval.DateSTM) BETWEEN config_semester.start_date AND config_semester.end_date AND config_semester.ID IN($Semesterid)
                            		WHERE contact.Isactive =1 and ContactID = '" . $ContactID . "' and lesson_prep_eval.EmpID IN(" . $emp . ") group by LessonPrepID ,lesson_prep_eval.DateSTM");
		return $GetData->num_rows();
	}
	public function report_home_work_view($EmpID = 0, $DayDateFrom = 'NULL', $DayDateTo = 'NULL')
	{
		$getReport = $this->db->query("
		 SELECT
		 test.ID        AS TestID ,
		 test.Name      AS TestName ,
		 test.Date_Stm	AS TestDateStm	 ,
		 level.ID       AS LevelID,
		 row.ID         AS RowID,
		 level.Name     AS LevelName,
		 row.Name       AS RowName,
		 row_level.ID   As RowLevelID ,
		 subject.Name   AS SubName
		FROM test
		INNER JOIN config_emp ON test.Subject_emp_ID = config_emp.ID
		INNER JOIN subject    ON subject.ID          = config_emp.SubjectID
		INNER JOIN row_level  ON config_emp.RowLevelID  = row_level.ID
		INNER JOIN row        ON row_level.Row_ID        = row.ID
		INNER JOIN level      ON row_level.Level_ID      = level.ID
	    WHERE config_emp.EmpID = " . $EmpID . " AND test.type = 1
		AND 
		(DATE(test.Date_Stm)	 BETWEEN CAST('" . $DayDateFrom . "' AS DATE ) AND CAST('" . $DayDateTo . "' AS DATE  )) 
		 ")->result();
		if (sizeof($getReport) > 0) {
			return $getReport;
		} else {
			return false;
		}
	}
	public function report_exam_view($EmpID = 0, $DayDateFrom = 'NULL', $DayDateTo = 'NULL')
	{
		$getReport = $this->db->query("
		SELECT
		 test.ID   AS TestID ,
		 test.Name AS TestName ,
		 test.Date_Stm	AS TestDateStm	 ,
		 level.ID       AS LevelID,
		 row.ID         AS RowID,
		 level.Name     AS LevelName,
		 row.Name       AS RowName,
		 row_level.ID   As RowLevelID ,
		 subject.Name   AS SubName
		FROM test
		INNER JOIN config_emp ON test.Subject_emp_ID = config_emp.ID
		INNER JOIN subject    ON subject.ID          = config_emp.SubjectID
		INNER JOIN row_level  ON config_emp.RowLevelID  = row_level.ID
		INNER JOIN row        ON row_level.Row_ID        = row.ID
		INNER JOIN level      ON row_level.Level_ID      = level.ID
	    WHERE config_emp.EmpID = " . $EmpID . " AND test.type = 0
		AND 
		(DATE(test.Date_Stm)	 BETWEEN CAST('" . $DayDateFrom . "' AS DATE ) AND CAST('" . $DayDateTo . "' AS DATE  )) 

		
		 ")->result();
		if (sizeof($getReport) > 0) {
			return $getReport;
		} else {
			return false;
		}
	}
	////get_level
	public function get_level($Lang = NULL)
	{
		if ($Lang == 'arabic') {
			$this->db->select('ID ,Name ,Token');
			$this->db->from('level');
			$this->db->where('Is_Active', 1);
		} else {
			$this->db->select('ID ,Name_en AS Name ,Token');
			$this->db->from('level');
			$this->db->where('Is_Active', 1);
		}
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
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
		 ")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return  FALSE;
		}
	}
	public function get_Class($Lang = NULL)
	{
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		$this->db->select("" . $Name . " AS ClassName , ID AS ClassID ");
		$this->db->from('class');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	////////////////////////get_level_number_student
	public function get_level_number_student($Lang = NULL)
	{
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		$query = $this->db->query("
		 SELECT  distinct
		 level.ID         AS LevelID ,
		 row.ID           AS RowID ,
		 level." . $Name . "  AS LevelName ,
		 row." . $Name . "    AS RowName ,
		 row_level.ID     As RowLevelID 
		 FROM 
		 row_level
		 INNER JOIN row              ON row_level.Row_ID      = row.ID
		 INNER JOIN level            ON row_level.Level_ID    = level.ID
		 INNER JOIN student          ON row_level.ID          = student.R_L_ID
		 INNER JOIN contact          ON student.Contact_ID    = contact.ID
		 WHERE level.Is_Active = 1 
		 AND contact.SchoolID  IN(" . $this->session->userdata('SchoolID') . ")
		 AND  contact.Isactive = 1
		  ORDER BY row_level.ID ASC
		 
		 ")->result();

		if (sizeof($query) > 0) {
			return $query;
		} else {
			return  FALSE;
		}
	}

	////////////////////////get_emp
	public function get_Job_Title($Lang = NULL)
	{
		$Name       = 'Name_Ar';

		if ($Lang == 'english') {
			$Name = 'Name_En';
		}
		$query = $this->db->query("SELECT ID ,  " . $Name . " AS Name  FROM job_title ")->result();

		if (sizeof($query) > 0) {
			return $query;
		} else {
			return  FALSE;
		}
	} ////////////////////////get_emp_Job_Title
	public function get_emp_Job_Title($JobTitle = 0)
	{
		if ($JobTitle == 0) {
			$JobTitle = 'NULL';
		}
		$query = $this->db->query("
		SELECT 
		contact.ID ,
		contact.Name ,
		contact.User_Name ,
		contact.Mobile 
		FROM 
		contact 
		INNER JOIN employee ON contact.ID       = employee.Contact_ID 
		WHERE employee.jobTitleID = IFNULL($JobTitle , employee.jobTitleID)
		AND 
		contact.SchoolID IN(" . $this->session->userdata('SchoolID') . ")
		AND  contact.Isactive = 1 and contact.type = 'E'
		")->result();

		if (sizeof($query) > 0) {
			return $query;
		} else {
			return  FALSE;
		}
	}
	public function get_branches($Lang = NULL)
	{
		$Name = 'SchoolName';
		if ($Lang == 'english') {
			$Name = 'SchoolNameEn';
		}
		if ($this->session->userdata('type') == "U") {
			$query_admin = $this->db->query("SELECT SchoolID  FROM contact WHERE ID = '" . $this->session->userdata('id') . "' ")->row_array();
			$school = explode(",", $query_admin['SchoolID']);
			if ($query_admin['SchoolID'] == 0 || $school[1] != "") {
				if ($query_admin['SchoolID'] == 0) {
					$query = $this->db->query("SELECT ID ," . $Name . " as Name FROM school_details ")->result();
				} elseif ($school[1] != "") {
					$query = $this->db->query("SELECT ID ," . $Name . " as Name FROM school_details WHERE ID IN(" . $query_admin['SchoolID'] . ") ")->result();
				}
			} else {
				$query = $this->db->query("SELECT ID ," . $Name . " as Name FROM school_details WHERE ID  =" . $this->session->userdata('SchoolID') . " ")->result();
			}
		} else {
			$query_emp = $this->db->query("SELECT Branch  FROM contact
	        inner join employee on contact.ID=employee.Contact_ID
	        WHERE contact.ID = '" . $this->session->userdata('id') . "' ")->row_array();
			$query = $this->db->query("SELECT ID ," . $Name . " as Name FROM school_details WHERE ID IN(" . $query_emp['Branch'] . ") ")->result();
		}



		if (sizeof($query) > 0) {
			return $query;
		} else {

			return false;
		}
	}
	////////////////////////get_emp_Job_Title
	public function emp_all_data($BranchID = 0, $LevelID = 0, $RowLevelID = 0, $ClassID = 0)
	{
		if ($LevelID == 0) {
			$LevelID = 'NULL';
		}
		if ($RowLevelID == 0) {
			$RowLevelID = 'NULL';
		}
		if ($ClassID == 0) {
			$ClassID = 'NULL';
		}
		// $emp = get_emp_select_in();
		$NameArray = array("contact" => " contact.Name");
		if ($this->session->userdata('language') == "english") {
			$NameArray = array("contact" => " contact.Name_en ");
		}
		if ($BranchID == 0) {
			if ($this->session->userdata('type') == "U") {
				$query_admin = $this->db->query("SELECT SchoolID  FROM contact WHERE ID = '" . $this->session->userdata('id') . "' ")->row_array();
				$school = explode(",", $query_admin['SchoolID']);
				if ($query_admin['SchoolID'] == 0 || $school[1] != "") {
					if ($query_admin['SchoolID'] == 0) {
						$query = $this->db->query("SELECT ID  as Name FROM school_details ")->result();
						$BranchID = 'NULL';
						$whereschool = "contact.SchoolID = IFNULL($BranchID,contact.SchoolID)";
					} elseif ($school[1] != "") {
						$query = $this->db->query("SELECT ID  as Name FROM school_details WHERE ID IN(" . $query_admin['SchoolID'] . ") ")->result();
						$BranchID = $query_admin['SchoolID'];
						$whereschool = "contact.SchoolID IN($BranchID)";
					}
				} else {
					$query = $this->db->query("SELECT ID  as Name FROM school_details WHERE ID  =" . $this->session->userdata('SchoolID') . " ")->result();
					$BranchID = $this->session->userdata('SchoolID');
					$whereschool = "contact.SchoolID =$BranchID";
				}
			} else {
				$query_emp = $this->db->query("SELECT Branch  FROM contact
    	        inner join employee on contact.ID=employee.Contact_ID
    	        WHERE contact.ID = '" . $this->session->userdata('id') . "' ")->row_array();
				$query = $this->db->query("SELECT ID  as Name FROM school_details WHERE ID IN(" . $query_emp['Branch'] . ") ")->result();
				$BranchID = $query_emp['Branch'];
				$whereschool = "contact.SchoolID IN($BranchID)";
			}
		} else {
			$whereschool = "contact.SchoolID =$BranchID";
		}
		if ($this->session->userdata('language') == "english") {
			$name = "Name_En";
		} else {
			$name = "Name_Ar";
		}
		$query = $this->db->query("
		SELECT 
		contact.ID ,
		contact.Name,
		contact.Name_en,
		contact.User_Name ,
		contact.Mobile ,
		contact.Type ,
		contact.Mail ,
		school_details.SchoolName , 
		job_title.Name_Ar , 
		contact.Note ,
		permission_group.Name	AS GroupName,
		employee.jobTitleID,
		job_title.$name as job_title_name
		FROM 
		contact 
		INNER JOIN employee        ON contact.ID              = employee.Contact_ID 
		LEFT JOIN class_table      ON contact.ID              = class_table.EmpID
		LEFT JOIN row_level        ON class_table.RowLevelID  = row_level.ID
		LEFT JOIN class            ON class_table.ClassID     = class.ID
		LEFT JOIN school_details   ON contact.SchoolID        = school_details.ID
		LEFT JOIN job_title        ON employee.jobTitleID     = job_title.ID
		LEFT JOIN permission_group ON contact.GroupID         = permission_group.ID
		WHERE 
		$whereschool
		AND  contact.Isactive = 1
		AND  contact.type = 'E'
    	AND  row_level.Level_ID =  IFNULL($LevelID,row_level.Level_ID)  
		AND  row_level.ID       = IFNULL($RowLevelID,row_level.ID)
	    AND  class.ID           = IFNULL($ClassID,class.ID)
	    GROUP BY contact.Name
		")->result();

		if (sizeof($query) > 0) {
			return $query;
		} else {
			return  FALSE;
		}
	}
	/////////////////
	public function employee_all_data($BranchID = 0)
	{

		$NameArray = array("contact" => " contact.Name");
		if ($this->session->userdata('language') == "english") {
			$NameArray = array("contact" => " contact.Name_en ");
		}
		if ($BranchID == 0) {
			if ($this->session->userdata('type') == "U") {
				$query_admin = $this->db->query("SELECT SchoolID  FROM contact WHERE ID = '" . $this->session->userdata('id') . "' ")->row_array();
				$school = explode(",", $query_admin['SchoolID']);
				if ($query_admin['SchoolID'] == 0 || $school[1] != "") {
					if ($query_admin['SchoolID'] == 0) {
						$query = $this->db->query("SELECT ID  as Name FROM school_details ")->result();
						$BranchID = 'NULL';
						$whereschool = "contact.SchoolID = IFNULL($BranchID,contact.SchoolID)";
					} elseif ($school[1] != "") {
						$query = $this->db->query("SELECT ID  as Name FROM school_details WHERE ID IN(" . $query_admin['SchoolID'] . ") ")->result();
						$BranchID = $query_admin['SchoolID'];
						$whereschool = "contact.SchoolID IN($BranchID)";
					}
				} else {
					$query = $this->db->query("SELECT ID  as Name FROM school_details WHERE ID  =" . $this->session->userdata('SchoolID') . " ")->result();
					$BranchID = $this->session->userdata('SchoolID');
					$whereschool = "contact.SchoolID =$BranchID";
				}
			} else {
				$query_emp = $this->db->query("SELECT Branch  FROM contact
    	        inner join employee on contact.ID=employee.Contact_ID
    	        WHERE contact.ID = '" . $this->session->userdata('id') . "' ")->row_array();
				$query = $this->db->query("SELECT ID  as Name FROM school_details WHERE ID IN(" . $query_emp['Branch'] . ") ")->result();
				$BranchID = $query_emp['Branch'];
				$whereschool = "contact.SchoolID IN($BranchID)";
			}
		} else {
			$whereschool = "contact.SchoolID =$BranchID";
		}
		if ($this->session->userdata('language') == "english") {
			$name = "Name_En";
		} else {
			$name = "Name_Ar";
		}
		$query = $this->db->query("
		SELECT 
		contact.ID ,
		contact.Name,
		contact.Name_en,
		contact.User_Name ,
		contact.Mobile ,
		contact.Type ,
		contact.Mail ,
		school_details.SchoolName , 
		job_title.Name_Ar , 
		contact.Note ,
		permission_group.Name	AS GroupName,
		employee.jobTitleID,
		job_title.$name as job_title_name
		FROM 
		contact 
		INNER JOIN employee        ON contact.ID              = employee.Contact_ID 
		LEFT JOIN school_details   ON contact.SchoolID        = school_details.ID
		LEFT JOIN job_title        ON employee.jobTitleID     = job_title.ID
		LEFT JOIN permission_group ON contact.GroupID         = permission_group.ID
		WHERE 
		$whereschool
		AND  contact.Isactive = 1
		AND  contact.type = 'E'
	    GROUP BY contact.ID
		")->result();

		if (sizeof($query) > 0) {
			return $query;
		} else {
			return  FALSE;
		}
	}

	public function emp_all_data_emp()
	{

		$query = $this->db->query("
		SELECT 
		contact.ID ,
		contact.Name ,
		contact.User_Name ,
		contact.Mobile ,
		contact.Type ,
		contact.Mail ,
		school_details.SchoolName , 
		job_title.Name_Ar , 
		permission_group.Name	AS GroupName   
		FROM 
		contact 
		INNER JOIN employee        ON contact.ID            = employee.Contact_ID 
		LEFT JOIN school_details   ON contact.SchoolID      = school_details.ID
		LEFT JOIN job_title        ON employee.jobTitleID   = job_title.ID
		LEFT JOIN permission_group ON contact.GroupID       = permission_group.ID
		WHERE 
		contact.Isactive = 1 AND contact.type = 'E'
		
		")->result();

		if (sizeof($query) > 0) {
			return $query;
		} else {
			return  FALSE;
		}
	}
	////////////////////////get_emp_Job_Title
	public function emp_all_data_without_class($BranchID = 0)
	{
		$emp = get_emp_select_in();
		if ($BranchID == 0) {
			$BranchID = 'NULL';
		}
		$query = $this->db->query("
		SELECT 
		contact.ID ,
		contact.Name ,
		contact.User_Name ,
		contact.Mobile ,
		contact.Type ,
		contact.Mail ,
		school_details.SchoolName , 
		job_title.Name_Ar , 
		permission_group.Name	AS GroupName   
		FROM 
		contact 
		INNER JOIN employee        ON contact.ID            = employee.Contact_ID 
		LEFT JOIN school_details   ON contact.SchoolID      = school_details.ID
		LEFT JOIN job_title        ON employee.jobTitleID   = job_title.ID
		LEFT JOIN permission_group ON contact.GroupID       = permission_group.ID
		WHERE 
		contact.SchoolID =  IFNULL($BranchID , contact.SchoolID)
		AND  contact.ID NOT IN (SELECT EmpID FROM class_table)
		AND  contact.Isactive = 1 and contact.Type = 'E' and employee.jobTitleID=0
	    ##AND  contact.ID IN($emp)
		
		")->result();

		if (sizeof($query) > 0) {
			return $query;
		} else {
			return  FALSE;
		}
	}
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
	public function get_row_level_school_active1($Lang = NULL, $LevelID)
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
		 WHERE level.Is_Active = 1 and level.ID=$LevelID
		 ")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return  FALSE;
		}
	}
	public function get_row_level_school_active2($Lang = NULL, $levelID, $WhereInRowLevel)
	{
		$whereIN = "";
		if ($WhereInRowLevel != 0) {
			$exploadWhereInRowLevel = explode('and', $WhereInRowLevel);
			$whereIN = "AND  row_level.ID IN(" . implode(',', $exploadWhereInRowLevel) . ")";
		}
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		if ($levelID == 0) {
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
		 ")->result();
			if (sizeof($query) > 0) {
				return $query;
			} else {
				return  FALSE;
			}
		} else {
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
		 WHERE level.ID = " . $levelID . "  " . $whereIN . "
		 ")->result();
			if (sizeof($query) > 0) {
				return $query;
			} else {
				return  FALSE;
			}
		}
	}


	public function get_row_level_school_active_On_zero($Lang = NULL, $WhereInLevel, $WhereInRowLevel)
	{
		if ($WhereInRowLevel != 0) {
			$exploadWhereInRowLevel = explode('and', $WhereInRowLevel);
			$whereIN = "  row_level.ID IN(" . implode(',', $exploadWhereInRowLevel) . ")";
		} else {
			$exploadWhereInLevel = explode('and', $WhereInLevel);
			//print_r($exploadWhereInLevel );exit();
			$whereIN = "  level.ID IN(" . implode(',', $exploadWhereInLevel) . ")";
		}

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
		 WHERE  " . $whereIN . "
		 ")->result();
		//print_r($this->db->last_query());exit();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return  FALSE;
		}
	}
	public function get_row_level_school_active3($Lang = NULL, $levelID)
	{

		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		if ($levelID == 0) {
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
		 ")->result();
		} else {
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
		 WHERE  row_level.ID = " . $levelID . "
		 ")->result();
			if (sizeof($query) > 0) {
				return $query;
			} else {
				return  FALSE;
			}
		}
	}
	public function get_row_level_school_active3_per($Lang = NULL, $levelID, $rowLavelOnSelectAll = 0)
	{

		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		if ($levelID == 0) {
			$where = '';
			if ($rowLavelOnSelectAll != 0) {
				$where = "WHERE level.ID = " . $rowLavelOnSelectAll . " ";
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
		INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID 
		AND school_row_level.schoolID = '" . $this->session->userdata('SchoolID') . "'
		" . $where . " 
		 ")->result();
			if (sizeof($query) > 0) {
				return $query;
			} else {
				return  FALSE;
			}
		} else {
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
		 WHERE  row_level.ID = " . $levelID . "
		 ")->result();
			if (sizeof($query) > 0) {
				return $query;
			} else {
				return  FALSE;
			}
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
		  class." . $Name . " AS ClassName ,row_level.Level_Name AS LevelName,row_level.Row_Name AS RowName,row_level.ID AS RowLevelID
		  FROM class
		   INNER join class_level on class.ID=class_level.classID
		  INNER join row_level ON class_level.levelID=row_level.Level_ID
		  INNER JOIN school_class ON class.ID = school_class.ClassID AND school_class.SchoolID = '" . $this->session->userdata('SchoolID') . "'
		  group by class.ID,row_level.ID
		   ");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	public function get_class_school_active1($Lang = NULL, $RowLevelID)
	{
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		$query = $this->db->query("SELECT
		  class.ID  AS ClassID ,
		  class. " . $Name . " AS ClassName ,
		  level.Name  as LevelName,
		  row.Name as RowName,
		   level.ID       AS LevelID,
		   row.ID         AS RowID,
		    row_level.ID   As RowLevelID 
		  FROM class
		 
		   INNER JOIN class_table ON class.ID  = class_table.ClassID
		    INNER JOIN row_level ON class_table.RowLevelID  = row_level.ID
		  INNER JOIN row              ON row_level.Row_ID        = row.ID
		 INNER JOIN level            ON row_level.Level_ID      = level.ID
		  INNER JOIN school_class ON class.ID = school_class.ClassID AND school_class.SchoolID = '" . $this->session->userdata('SchoolID') . "'
		  where row_level.ID=$RowLevelID
		  and class.Is_Active =1 
		  group by 
		   class.ID
		   ");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	public function get_class_school_active2($Lang = NULL)
	{
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		$query = $this->db->query("SELECT DISTINCT 
		   level.ID       AS LevelID,
			 row.ID         AS RowID,
			 level.Name     AS LevelName,
			 row.Name       AS RowName,
			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
		  class.ID  AS ClassID ,
		  class. " . $Name . " AS ClassName 
		  FROM class
		  INNER JOIN school_class ON class.ID = school_class.ClassID AND school_class.SchoolID = '" . $this->session->userdata('SchoolID') . "'
		  INNER JOIN class_table ON class.ID=class_table.ClassID 
		  INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
		  INNER JOIN row              ON row_level.Row_ID        = row.ID
		  INNER JOIN level            ON row_level.Level_ID      = level.ID
		  where class_table.EmpID ='" . $this->session->userdata('id') . "'
		 
		  
		   ");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	public function get_class_school_active_per($Lang = NULL, $WhereInRowLevel)
	{
		$where = '';
		if ($WhereInRowLevel != 0) {
			$WhereInRowLevelexplode = explode('and', $WhereInRowLevel);
			$where = "WHERE class.ID IN(" . implode(',', $WhereInRowLevelexplode) . ")";
		}
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		$query = $this->db->query("SELECT
		  class.ID  AS ClassID ,
		  class. " . $Name . " AS ClassName 
		  FROM class
		  INNER JOIN school_class ON class.ID = school_class.ClassID AND school_class.SchoolID = '" . $this->session->userdata('SchoolID') . "'
		  " . $where . "
		   ");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}

	////////////get_subject
	public function get_subject($configSubjectID)
	{
		$query = $this->db->query("
			  SELECT
			  config_subject.ID AS ConfigSubjectID ,
			  subject.Name   AS SubName ,
			  level.Name     AS LevelName,
			  row.Name       AS RowName ,
			  level.ID       AS LevelID,
			  row_level.ID   AS RowLevelID
			  FROM 
			  config_subject
			  INNER JOIN subject ON config_subject.SubjectID = subject.ID
			  INNER JOIN row_level        ON config_subject.RowLevelID  = row_level.ID
			  INNER JOIN row              ON row_level.Row_ID        = row.ID
			  INNER JOIN level            ON row_level.Level_ID      = level.ID
			  where config_subject.ID IN(" . $configSubjectID . ")
			  GROUP BY config_subject.ID  DESC
			");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	public function get_active_library($EmpPer = 0, $Lang = NULL)
	{
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		$query = $this->db->query("
		SELECT 
		contact.ID   AS  ContactID,
		contact.Name AS  ContactName,
		e_library.ID AS LibraryID  ,
		e_library.SemesterID , 
		e_library.Stm_Date ,
		e_library.File_url	 ,
		e_library.Title ,
		level.ID         AS LevelID ,
		row.ID           AS RowID ,
		level." . $Name . "  AS LevelName ,
		row." . $Name . "    AS RowName ,
		row_level.ID     As RowLevelID ,
		subject.Name     AS SubjectName , 
		school_details.SchoolName	
		FROM 
		contact 
		INNER JOIN e_library ON contact.ID                     = e_library.ContactID 
		INNER JOIN row_level ON  e_library.RowLevelID          = row_level.ID 
		INNER JOIN subject   ON  e_library.SubjectID	       = subject.ID 
		INNER JOIN row              ON row_level.Row_ID        = row.ID
		INNER JOIN level            ON row_level.Level_ID      = level.ID
		INNER JOIN school_details   ON contact.SchoolID        = school_details.ID
		WHERE contact.ID IN(" . $EmpPer . ")
		AND e_library.IsActive = 0 
		AND  contact.Isactive = 1
		")->result();
		//print_r($query);exit;
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return  FALSE;
		}
	}
	public function active_library($active_library = 0)
	{
		$this->db->query("UPDATE e_library SET IsActive = 1 WHERE ID = '" . $active_library . "'");
	}

	/////////////////////////////get_student_without_class
	public function get_student_without_class()
	{
		$query = $this->db->query("
			 SELECT
			 tb1.ID    AS StudentID,
			 tb1.Token AS StudentToken,
			 tb1.Name  AS StudentName,
			 tb2.ID    AS FatherID ,
			 tb2.Token AS FatherToken ,
		     tb2.Name  AS FatherName ,
			 school_details.SchoolName ,
			 CONCAT(tb1.Name,' ',tb2.Name) AS FullName
			 FROM contact As tb1
			 INNER JOIN student         ON tb1.ID              = student.Contact_ID
			 INNER JOIN contact AS tb2  ON student.Father_ID   = tb2.ID
			 LEFT JOIN school_details   ON tb1.SchoolID        = school_details.ID 
			 WHERE 
			  tb1.Isactive = 1 
		     AND tb2.Isactive = 1 
			 AND student.R_L_ID = 0
			 OR student.Class_ID = 0 
			 ORDER BY tb1.Name
			");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	public function  lesson_prep_eval_report($EmpSelect = 0)
	{
		// $EmpSelect = 0;
		$query = $this->db->query("
			 SELECT 
			 tb1.ID AS EmpID , 
			 tb1.Name AS EmpName ,
			 lesson_prep.Lesson_Title , 
			 lesson_prep_eval.Degree  ,
			 lesson_prep_eval.DateSTM  ,
			 tb2.ID AS ContactID , 
			 tb2.Name AS ContactName,
			 lesson_prep_eval.Notes
			 FROM 
			 lesson_prep_eval
			 INNER JOIN contact AS tb1 ON lesson_prep_eval.EmpID     = tb1.ID
			 INNER JOIN contact AS tb2 ON lesson_prep_eval.ContactID = tb2.ID 
			 INNER JOIN lesson_prep ON lesson_prep_eval.LessonPrepID = lesson_prep.ID
			 WHERE tb1.IsActive = 1
			 AND tb1.ID IN (" . $EmpSelect . ")
			 group by lesson_prep.ID
			");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	public function  lesson_prep_eval_report1($Date)
	{
		extract($Date);
		// $EmpSelect = 0;
		$query = $this->db->query("
			 SELECT 
			 tb1.ID AS EmpID , 
			 tb1.Name AS EmpName ,
			 lesson_prep.Lesson_Title , 
			 lesson_prep_eval.Degree  ,
			 lesson_prep_eval.DateSTM  ,
			 tb2.ID AS ContactID , 
			 tb2.Name AS ContactName,
			 lesson_prep_eval.Notes
			 FROM 
			 lesson_prep_eval
			 INNER JOIN contact AS tb1 ON lesson_prep_eval.EmpID     = tb1.ID
			 INNER JOIN contact AS tb2 ON lesson_prep_eval.ContactID = tb2.ID 
			 INNER JOIN lesson_prep ON lesson_prep_eval.LessonPrepID = lesson_prep.ID
			 INNER JOIN config_semester ON DATE(lesson_prep_eval.DateSTM) BETWEEN config_semester.start_date AND config_semester.end_date AND config_semester.ID IN($Semesterid)
			 WHERE tb1.IsActive = 1
			 AND lesson_prep.ID = " . $lesson_id . "
			 AND tb2.ID=" . $ContactID . "
			 AND lesson_prep_eval.DateSTM  LIKE '%$datee%'
			 
			 group by lesson_prep.ID
			");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function  lesson_prep_eval_report2($Date)
	{
		extract($Date);
		// $EmpSelect = 0;
		$query = $this->db->query("
			 SELECT 
			 tb1.ID AS EmpID , 
			 tb1.Name AS EmpName ,
			 lesson_prep.Lesson_Title , 
			 lesson_prep_eval.Degree  ,
			 lesson_prep_eval.DateSTM  ,
			 tb2.ID AS ContactID , 
			 tb2.Name AS ContactName,
			 lesson_prep_eval.Notes,
			 (SUM(lesson_prep_eval.Degree))*100/(COUNT(lesson_prep_eval.ID)*10) as precentage,
			 lesson_prep.ID as lesson_id
			 FROM 
			 lesson_prep_eval
			 INNER JOIN contact AS tb1 ON lesson_prep_eval.EmpID     = tb1.ID
			 INNER JOIN contact AS tb2 ON lesson_prep_eval.ContactID = tb2.ID 
			 INNER JOIN lesson_prep ON lesson_prep_eval.LessonPrepID = lesson_prep.ID
			 INNER JOIN config_semester ON DATE(lesson_prep_eval.DateSTM) BETWEEN config_semester.start_date AND config_semester.end_date AND config_semester.ID IN($Semesterid)
			 WHERE tb1.IsActive = 1
			 AND tb1.ID IN (" . $GetEmpper . ")
			 AND tb2.ID=" . $UserID . "
			 group by lesson_prep.ID
			");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function  lesson_prep_eval_group_contact_report($EmpSelect = 0)
	{
		$query = $this->db->query("
			SELECT school_details.SchoolName,COUNT(View_vallesson.ContactID) AS value,virw_group.name_val FROM View_vallesson 
inner join contact on View_vallesson.EmpID=contact.ID 
INNER JOIN school_details ON school_details.ID=contact.SchoolID
INNER JOIN virw_group ON View_vallesson.ContactID=virw_group.idcont
group by  school_details.SchoolName,virw_group.name_val HAVING COUNT(View_vallesson.ContactID)>1  
ORDER BY `virw_group`.`name_val` ASC
			");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	////////get_class_school
	public function get_class_school($Lang = NULL)
	{
		$class = get_class_select_in();
		$NameArray = array("Level" => "Name AS LevelName", "row" => "Name AS RowName", "class" => "Name AS ClassName", "lesson" => "lesson AS LessonName");
		if ($Lang == "english") {
			$NameArray = array("Level" => "Name_en AS LevelName", "row" => " Name_en AS RowName", "class" => "Name_en AS ClassName", "lesson" => "Lesson_en AS LessonName");
		}
		$GetEmp =  $this->db->query("
		  SELECT
		  level." . $NameArray['Level'] . ",
		  row." . $NameArray['row'] . ",
		  class." . $NameArray['class'] . " , 
		  class.ID     AS ClassID ,
		  level.ID     AS LevelID  ,
		  row_level.ID AS RowLevelID 
		  FROM
		  student
		  INNER JOIN row_level        ON student.R_L_ID           = row_level.ID
		  INNER JOIN row              ON row_level.Row_ID         = row.ID
		  INNER JOIN level            ON row_level.Level_ID       = level.ID
		  INNER JOIN class            ON student.Class_ID         = class.ID
		  INNER JOIN contact          ON student.Contact_ID       = contact.ID
		  WHERE
		   contact.SchoolID IN(" . $this->session->userdata('SchoolID') . ")
		   AND class.ID  IN(" . $class . ")
		  GROUP BY  class.ID
		  ORDER BY class.ID
		");
		//echo "SELECT  ID , '".$LangArray['Name'] ."' FROM level WHERE Is_Active = 1  " ;exit;
		if ($GetEmp->num_rows() > 0) {
			return $GetEmp->result();
		} else {
			return FALSE;
		}
	}

	////////get_class_school
	public function get_row_level_school_report($Lang = NULL, $data = array())
	{
		extract($data);
		if ($level == 0) {
			$level = 'NULL';
		}
		if ($RowLevel == 0) {
			$RowLevel = 'NULL';
		}
		$R_L_ID = get_rowlevel_select_in();
		$NameArray = array("Level" => "Name AS LevelName", "row" => "Name AS RowName", "class" => "Name AS ClassName", "lesson" => "lesson AS LessonName");
		if ($Lang == "english") {
			$NameArray = array("Level" => "Name_en AS LevelName", "row" => " Name_en AS RowName", "class" => "Name_en AS ClassName", "lesson" => "Lesson_en AS LessonName");
		}
		$GetEmp =  $this->db->query("
		  SELECT
		  level." . $NameArray['Level'] . ",
		  row." . $NameArray['row'] . ",
		  class." . $NameArray['class'] . " , 
		  level.ID     AS LevelID  ,
		  class.ID     AS ClassID ,
		  row_level.ID AS RowLevelID 
		  FROM
		  student
		  INNER JOIN row_level        ON student.R_L_ID           = row_level.ID
		  INNER JOIN row              ON row_level.Row_ID         = row.ID
		  INNER JOIN level            ON row_level.Level_ID       = level.ID
		  INNER JOIN class            ON student.Class_ID         = class.ID
		  INNER JOIN contact          ON student.Contact_ID       = contact.ID
		  WHERE
		   contact.SchoolID IN(" . $this->session->userdata('SchoolID') . ")
		   AND row_level.ID IN (" . $R_L_ID . ")
		   AND  level.ID     			= IFNULL($level , level.ID)
	       AND  row_level.ID  		= IFNULL($RowLevel , row_level.ID) 
		  GROUP BY  row_level.ID
		  ORDER BY row_level.Level_ID ,row_level.ID
		");
		//echo "SELECT  ID , '".$LangArray['Name'] ."' FROM level WHERE Is_Active = 1  " ;exit;
		if ($GetEmp->num_rows() > 0) {
			return $GetEmp->result();
		} else {
			return FALSE;
		}
	}
	//////////////////////////////emp_lesson_prep_report
	public function emp_lesson_prep_report($Lang = NULL, $EmpID = 0, $DayDateFrom = NULL,  $DayDateTo = NULL)
	{
		$NameArray = array("Level" => "Name AS LevelName", "row" => "Name AS RowName", "class" => "Name AS ClassName", "lesson" => "lesson AS LessonName");
		if ($Lang == "english") {
			$NameArray = array("Level" => "Name_en AS LevelName", "row" => " Name_en AS RowName", "class" => "Name_en AS ClassName", "lesson" => "Lesson_en AS LessonName");
		}
		$getReport = $this->db->query("
			SELECT 
			lesson_prep.ID AS LessonID , 
			lesson_prep.Lesson_Title , 
			lesson_prep.Date	AS Date  ,
			level." . $NameArray['Level'] . ",
		    row." . $NameArray['row'] . ",
		    level.ID     AS LevelID  ,
		    row_level.ID AS RowLevelID , 
			contact.Name   AS ContactName ,
			subject.Name   AS SubjectName   
			FROM lesson_prep 
		    INNER JOIN row_level        ON lesson_prep.RowLevel_ID  = row_level.ID
		    INNER JOIN row              ON row_level.Row_ID         = row.ID
		    INNER JOIN level            ON row_level.Level_ID       = level.ID
		    INNER JOIN contact          ON lesson_prep.Teacher_ID   = contact.ID
			INNER JOIN subject          ON lesson_prep.Subject_ID   = subject.ID
			WHERE lesson_prep.Teacher_ID = " . $EmpID . "
			AND 
			(DATE(lesson_prep.Date) BETWEEN CAST('" . $DayDateFrom . "' AS DATE ) AND CAST('" . $DayDateTo . "' AS DATE  ))
			GROUP BY  lesson_prep.RowLevel_ID , lesson_prep.Subject_ID
			
		 ")->result();

		if (sizeof($getReport) > 0) {
			return $getReport;
		} else {
			return FALSE;
		}
	}
	//////////////////////////////////students_eval_report
	public function students_eval_report($Lang = NULL, $EmpID = 0,  $DayDateFrom = NULL,  $DayDateTo = NULL)
	{
		$NameArray = array("Level" => "Name AS LevelName", "row" => "Name AS RowName", "class" => "Name AS ClassName", "lesson" => "lesson AS LessonName");
		if ($Lang == "english") {
			$NameArray = array("Level" => "Name_en AS LevelName", "row" => " Name_en AS RowName", "class" => "Name_en AS ClassName", "lesson" => "Lesson_en AS LessonName");
		}
		if ($DayDateFrom  == 'NULL' && $DayDateFrom  == 'NULL') {
			$getReport = $this->db->query("
		SELECT 
		students_evaluation.ID , 
		students_evaluation.Date , 
		level." . $NameArray['Level'] . ",
		row." . $NameArray['row'] . ",
		class." . $NameArray['class'] . ",
		level.ID     AS LevelID  ,
		row_level.ID AS RowLevelID , 
		contact.Name   AS ContactName ,
		subject.Name   AS SubjectName
		FROM 
		students_evaluation
		INNER JOIN student ON students_evaluation.StudentID             = student.Contact_ID
		INNER JOIN row_level        ON student.R_L_ID                   = row_level.ID
	    INNER JOIN row              ON row_level.Row_ID                 = row.ID
	    INNER JOIN level            ON row_level.Level_ID               = level.ID
	    INNER JOIN class            ON student.Class_ID                 = class.ID
	    INNER JOIN contact          ON students_evaluation.TeacherID    = contact.ID
		INNER JOIN subject          ON students_evaluation.SubjectID    = subject.ID
		WHERE students_evaluation.TeacherID = " . $EmpID . "  GROUP BY student.R_L_ID , student.Class_ID ,  students_evaluation.Date_stm
		 ")->result();
		} else {
			$getReport = $this->db->query("
			    SELECT 
				students_evaluation.ID , 
				students_evaluation.Date , 
				level." . $NameArray['Level'] . ",
				row." . $NameArray['row'] . ",
				class." . $NameArray['class'] . ",
				level.ID     AS LevelID  ,
				row_level.ID AS RowLevelID , 
				contact.Name   AS ContactName ,
				subject.Name   AS SubjectName
				FROM 
				students_evaluation
				INNER JOIN student ON students_evaluation.StudentID             = student.Contact_ID
				INNER JOIN row_level        ON student.R_L_ID                   = row_level.ID
				INNER JOIN row              ON row_level.Row_ID                 = row.ID
				INNER JOIN level            ON row_level.Level_ID               = level.ID
				INNER JOIN class            ON student.Class_ID                 = class.ID
				INNER JOIN contact          ON students_evaluation.TeacherID    = contact.ID
				INNER JOIN subject          ON students_evaluation.SubjectID    = subject.ID
				WHERE students_evaluation.TeacherID = " . $EmpID . "  
				AND 
			   (DATE(students_evaluation.Date)	 BETWEEN CAST('" . $DayDateFrom . "' AS DATE ) AND CAST('" . $DayDateTo . "' AS DATE  )) 
			   GROUP BY student.R_L_ID , student.Class_ID ,  students_evaluation.Date
		 ")->result();
		}
		if (sizeof($getReport) > 0) {
			return $getReport;
		} else {
			return FALSE;
		}
	}
	//////////////////////////////////students_eval_report
	public function students_eval_absence_report($Lang = NULL,   $DayDateFrom = NULL,  $DayDateTo = NULL, $Student = 0)
	{
		$NameArray = array("Level" => "Name AS LevelName", "row" => "Name AS RowName", "class" => "Name AS ClassName", "lesson" => "lesson AS LessonName");
		if ($Lang == "english") {
			$NameArray = array("Level" => "Name_en AS LevelName", "row" => " Name_en AS RowName", "class" => "Name_en AS ClassName", "lesson" => "Lesson_en AS LessonName");
		}

		$getReport = $this->db->query("
		SELECT
		students_evaluation.*,
		students_evaluation.Date AS Date,
		row_level.Level_ID   AS LevelID,
		row_level.Level_Name AS LevelName,
		row_level.Row_ID     AS RowID,
		row_level.Row_Name   AS RowName,
		row_level.ID         As RowLevelID ,
		class.ID             As ClassID ,
		class.Name           AS ClassName,
		tb1.ID               AS StudentID,
		tb1.Name             AS StudentName,
		tb3.Name             AS TeacherName ,
		lesson.lesson        AS LessonName,
		subject.Name         AS subjectName 
		FROM contact As tb1
		INNER JOIN student 				ON tb1.ID = student.Contact_ID
		INNER JOIN class 				ON student.Class_ID = class.ID
		INNER JOIN row_level 			ON student.R_L_ID = row_level.ID
		INNER JOIN students_evaluation 	ON students_evaluation.StudentID = tb1.ID
		INNER JOIN class_table          ON class_table.ID = students_evaluation.ClassTableID
		INNER JOIN subject              ON subject.ID     = class_table.SubjectID
		INNER JOIN lesson               ON lesson.ID      = class_table.Lesson
		INNER JOIN contact AS tb3 		ON tb3.ID         = class_table.EmpID
		WHERE `Date`    >= '$DayDateFrom' 
       	AND `Date`      <= '$DayDateTo' 
       	AND `ClassTableID` IS NOT NULL
		ORDER BY  students_evaluation.Date
		 ")->result();

		if (sizeof($getReport) > 0) {
			return $getReport;
		} else {
			return FALSE;
		}
	}
	//////////////////////////////////students_eval_report
	public function students_delay_absence_report($Lang = NULL,   $DayDateFrom = NULL,  $DayDateTo = NULL, $Student = 0)
	{
		$NameArray = array("Level" => "Name AS LevelName", "row" => "Name AS RowName", "class" => "Name AS ClassName", "lesson" => "lesson AS LessonName");
		if ($Lang == "english") {
			$NameArray = array("Level" => "Name_en AS LevelName", "row" => " Name_en AS RowName", "class" => "Name_en AS ClassName", "lesson" => "Lesson_en AS LessonName");
		}

		$getReport = $this->db->query("
		SELECT
		level.ID AS LevelID,
		row.ID AS RowID,
		class.ID AS ClassID,
		level." . $NameArray['Level'] . ",
		row." . $NameArray['row'] . ",
		row_level.ID As RowLevelID ,
		class.ID As ClassID ,
		class." . $NameArray['class'] . " ,
		tb1.ID AS StudentID,
		tb1.Name AS StudentName,
		tb2.ID AS FatherID ,
		tb2.Name AS FatherName ,
		CONCAT(tb1.Name,' ',tb2.Name) AS FullName ,
		student_abcent.ID AS AbcentID , 
		student_abcent.BehaviorID, 
		student_abcent.Delay  AS Delay ,
		student_abcent.Date  AS AbcentDate ,
		tb3.Name AS TeacherName 
		FROM contact As tb1
		INNER JOIN student 				ON tb1.ID = student.Contact_ID
		INNER JOIN contact AS tb2 		ON student.Father_ID = tb2.ID
		INNER JOIN class 				ON student.Class_ID = class.ID
		INNER JOIN row_level 			ON student.R_L_ID = row_level.ID
		INNER JOIN row 					ON row_level.Row_ID = row.ID
		INNER JOIN level 				ON row_level.Level_ID = level.ID
		INNER JOIN student_abcent 	    ON student_abcent.StudentID = tb1.ID
		INNER JOIN contact AS tb3 		ON tb3.ID = student_abcent.EmpID
		WHERE 
		(DATE(student_abcent.Date)	 BETWEEN CAST('" . $DayDateFrom . "' AS DATE ) AND CAST('" . $DayDateTo . "' AS DATE  )) 
		AND 
		tb1.Isactive = 1 
		AND 
		tb2.Isactive = 1
		AND 
		tb1.ID IN(" . $Student . ")	
			
		ORDER BY  student_abcent.Date
		 ")->result();

		if (sizeof($getReport) > 0) {
			return $getReport;
		} else {
			return FALSE;
		}
	}

	public function getSupRowLavel($classID, $rowLavel, $allSubject)
	{
		$where = '';
		if ($allSubject != 0) {
			$arraySubject = explode('and', $allSubject);
			$where = 'and config_subject.ID in (' . implode(',', $arraySubject) . ')';
		}
		$result =  $this->db->query(
			'SELECT subject.ID , subject.Name from subject 
                INNER JOIN  class_table on subject.ID = class_table.SubjectID
				LEFT JOIN config_subject on config_subject.SubjectID = subject.ID
				WHERE class_table.RowLevelID = ' . $rowLavel . ' and class_table.ClassID = ' . $classID . '
				 ' . $where . '
                GROUP BY subject.ID '
		);
		return $result->result();
	}

	public function getskills($subject, $rowLavel)
	{
		$result =  $this->db->query(
			'SELECT name,ID from skills where RowLevelID=' . $rowLavel . ' and SubjectID=' . $subject . ' '
		);
		return $result->result();
	}

	public function report_emp_add_test()
	{
		$query = $this->db->query('SELECT test.ID AS testID,
	                              test.Name AS testName,
	                              test.time_count,
	                              test.date_from,
	                              test.date_to,
	                              contact.Name AS contactName,
	                              subject.Name AS subjectName
                                  FROM `test` 
                                  INNER JOIN contact ON contact.ID = test.empID
                                  INNER JOIN subject ON subject.ID = test.subject_id
                                  WHERE test.`type` = 5 
                                  AND test.IsActive  =1 
                                  AND test.is_deleted = 0 
                                  ');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}


	public function report_plan_week_school($schoolID, $LevelID, $RowLevelID, $classID, $subjectID)
	{
		$getReport = $this->db->query("
		SELECT 
		DISTINCT plan_week.WeekID, plan_week.SemesterID,contact.ID
		FROM plan_week 
		INNER JOIN class_table ON plan_week.ClassTableID = class_table.ID 
		inner join row_level  on class_table.RowLevelID = row_level.ID
		inner JOIN contact on contact.ID = class_table.EmpID
		WHERE class_table.SchoolID = " . $schoolID . " AND plan_week.Content != '' 
		AND row_level.Level_ID =  IFNULL( " . $LevelID . " , row_level.Level_ID  ) 
		AND row_level.ID = IFNULL( " . $RowLevelID . " , row_level.ID  ) 
		AND class_table.ClassID =  IFNULL( " . $classID . " , class_table.ClassID  ) 
		AND class_table.SubjectID = IFNULL( " . $subjectID . " ,  class_table.SubjectID ) 
		 ");
		return (int)$getReport->num_rows();
	}

	public function report_library_school($schoolID, $LevelID, $RowLevelID, $classID, $subjectID)
	{
		$getReport = $this->db->query("
			select e_library.ID from e_library 
			inner join row_level  on row_level.ID = e_library.RowLevelID
			inner join contact on contact.ID =  e_library.ContactID
			where  contact.SchoolID='" . $schoolID . "' 
			AND row_level.Level_ID =  IFNULL( " . $LevelID . " , row_level.Level_ID  ) 
			AND row_level.ID = IFNULL( " . $RowLevelID . " , row_level.ID  ) 
			AND e_library.SubjectID = IFNULL( " . $subjectID . " ,  e_library.SubjectID )
			group by e_library.ID
		 ");
		return (int)$getReport->num_rows();
	}

	public function report_class_table_school($schoolID, $LevelID, $RowLevelID, $classID, $subjectID)
	{
		$getReport = $this->db->query("
			SELECT class_table.ID
			FROM class_table 
			inner join row_level on row_level.ID = class_table.RowLevelID
			WHERE SchoolID = " . $schoolID . " 
			AND row_level.Level_ID =  IFNULL( " . $LevelID . " , row_level.Level_ID  ) 
            AND row_level.ID = IFNULL( " . $RowLevelID . " , row_level.ID  ) 
            AND class_table.ClassID =  IFNULL( " . $classID . " , class_table.ClassID  ) 
            AND class_table.SubjectID = IFNULL( " . $subjectID . " ,  class_table.SubjectID ) 
		 ");
		return (int)$getReport->num_rows();
	}
	public function report_clerical_homework_school($schoolID, $LevelID, $RowLevelID, $classID, $subjectID)
	{
		$getReport = $this->db->query("
			select clerical_homework.ID from config_emp
			INNER JOIN clerical_homework ON clerical_homework.subjectEmpID = config_emp.ID
			INNER JOIN row_level as row_levelClerical on row_levelClerical.ID = config_emp.RowLevelID
			WHERE  clerical_homework.title !='' 
	  	    AND row_levelClerical.Level_ID = IFNULL( " . $LevelID . " , row_levelClerical.Level_ID  )
			AND row_levelClerical.ID = IFNULL( " . $RowLevelID . " , row_levelClerical.ID  )
			AND clerical_homework.classID = IFNULL( " . $classID . " , clerical_homework.classID  )
			AND config_emp.SubjectID = IFNULL( " . $subjectID . " , config_emp.SubjectID  )
			group by clerical_homework.ID
		 ");
		return (int)$getReport->num_rows();
	}
	public function report_lesson_prep_school($schoolID, $LevelID, $RowLevelID, $classID, $subjectID)
	{
		$getReport = $this->db->query("
			select lesson_prep.ID from lesson_prep 
			inner join row_level as rowLavelPrep on rowLavelPrep.ID = lesson_prep.RowLevel_ID
			inner join contact on contact.ID = lesson_prep.Teacher_ID
			where contact.SchoolID='" . $schoolID . "' 
			AND rowLavelPrep.Level_ID = IFNULL( " . $LevelID . " ,   rowLavelPrep.Level_ID )
            AND rowLavelPrep.ID = IFNULL( " . $RowLevelID . " , rowLavelPrep.ID ) 
            AND lesson_prep.Subject_ID = IFNULL( " . $subjectID . " , lesson_prep.Subject_ID )
			group by lesson_prep.ID 
			
		 ");
		return (int)$getReport->num_rows();
	}
	public function report_homework_school($schoolID, $LevelID, $RowLevelID, $classID, $subjectID)
	{
		$getReport = $this->db->query("
		select test.ID from config_emp as config_emp1
		inner join test on test.Subject_emp_ID = config_emp1.ID
		INNER JOIN row_level as row_levelTest on row_levelTest.ID = config_emp1.RowLevelID
		inner join contact on contact.ID = config_emp1.EmpID
		where contact.SchoolID='" . $schoolID . "' AND test.type = 1 
		AND row_levelTest.Level_ID = IFNULL( " . $LevelID . " ,   row_levelTest.Level_ID )
		AND row_levelTest.ID = IFNULL( " . $RowLevelID . " , row_levelTest.ID )
		AND config_emp1.SubjectID = IFNULL( " . $subjectID . " , config_emp1.SubjectID )
		group by test.ID 
		");
		return (int)$getReport->num_rows();
	}
	public function report_test_school($schoolID, $LevelID, $RowLevelID, $classID, $subjectID)
	{
		$getReport = $this->db->query("
		select test.ID from config_emp as config_emp1
		inner join test on test.Subject_emp_ID = config_emp1.ID
		INNER JOIN row_level as row_levelTest on row_levelTest.ID = config_emp1.RowLevelID
		inner join contact on contact.ID = config_emp1.EmpID
		where contact.SchoolID='" . $schoolID . "' AND test.type = 0 
		AND row_levelTest.Level_ID =IFNULL( " . $LevelID . " , row_levelTest.Level_ID ) 
		AND row_levelTest.ID = IFNULL( " . $RowLevelID . " , row_levelTest.ID )
		AND config_emp1.SubjectID = IFNULL( " . $subjectID . " , config_emp1.SubjectID )
		group by test.ID 
		");
		return (int)$getReport->num_rows();
	}
	public function Subject_school($schoolID, $LevelID, $RowLevelID, $classID, $subjectID)
	{
		$getReport = $this->db->query("
			select GROUP_CONCAT(DISTINCT subject.Name) as allSub from class_table
			inner join subject on subject.ID = class_table.SubjectID
			where class_table.SchoolID = '" . $schoolID . "' 
            AND class_table.SubjectID = IFNULL( " . $subjectID . " ,  class_table.SubjectID ) 
			group by class_table.SchoolID
		");
		return $getReport->row()->allSub;
	}
	public function Subject_st_school()
	{
		$schoolID = $this->session->userdata('SchoolID');
		$getReport = $this->db->query("
			select subject.Name ,subject.ID from subject
			inner join class_table on subject.ID = class_table.SubjectID
			where class_table.SchoolID = '" . $schoolID . "' 
			group by subject.Name
		");
		return $getReport->result();
	}
	public function rowLevel_school($schoolID, $LevelID, $RowLevelID, $classID, $subjectID)
	{
		$getReport = $this->db->query("
		select GROUP_CONCAT(DISTINCT CONCAT(row.Name , ' ' , level.Name) ) as allSub from class_table
		inner join row_level on row_level.ID = class_table.RowLevelID
		inner join row on row.ID = row_level.Row_ID
		inner join level on  level.ID = row_level.Level_ID
		where class_table.SchoolID = " . $schoolID . "  
		AND row_level.ID = IFNULL( " . $RowLevelID . " , row_level.ID  ) 
		AND row_level.Level_ID = IFNULL( " . $LevelID . " , row_level.Level_ID )
		group by class_table.SchoolID and row_level.ID
		");
		return $getReport->row()->allSub;
	}

	public function emp_report_cms2()
	{
		$GetData = $this->db->query("
	     SELECT 
		 cms_album_pic.contactID ,
		 contact.Name  , contact.Number_ID,
		 school_details.SchoolName	 
		 FROM
		 cms_album_pic
		 INNER  JOIN     cms_details ON cms_details.ID      = cms_album_pic.item_data
		 INNER  JOIN     cms_main_sub ON cms_main_sub.ID    = cms_details.MainSubID
		 INNER  JOIN     contact ON   cms_album_pic.contactID   = contact.ID
		 LEFT   JOIN     school_details ON contact.SchoolID = school_details.ID
		 WHERE  
		 cms_details.ContentTypeID =1 and cms_album_pic.contactID !=0
		 AND  contact.Isactive = 1
		 group by  contact.ID  
		 
		");
		if ($GetData->num_rows() > 0) {
			return $GetData->result();
		} else {
			return FALSE;
		}
	}


	public function get_all_emp_reaction($Lang = NULL, $lavelID, $RowLevelID, $classID, $subjectID, $dateFrom, $dateTo)
	{
		$emp = get_emp_select_in();
		$whereChat = 1;
		$whereAsk = 1;
		$whereHome = 1;
		if ($dateFrom != 'NULL' && $dateTo != "NULL") {
			$whereChat = 'messages.created_at BETWEEN "' . $dateFrom . ' 00:00:00" AND "' . $dateTo . ' 23:59:59"'; //message outcoming
			$whereAsk = 'ask_teacher.Date BETWEEN "' . $dateFrom . ' 00:00:00" AND "' . $dateTo . ' 23:59:59" '; // asks reply on it
			$whereHome = 'clerical_homework.date_from BETWEEN "' . $dateFrom . ' 00:00:00" AND "' . $dateTo . ' 23:59:59" '; // clerical_homework created
		}

		return $this->db->query('
            SELECT c.*, Coalesce(m.total,0) AS chatTotal,Coalesce(m_s.total,0) AS chatTotal_s, Coalesce(a.total,0) AS askTotal, Coalesce(a_s.total,0) AS askTotal_s
            ,Coalesce(h.total,0) AS homeTotal ,Coalesce(P.total,0) AS PaperTotal,Coalesce(h_answer.total,0) AS homeTotal_answer,Coalesce(h_correct.total,0) AS homeTotal_correct,Coalesce(h_St_Count.total,0) AS total_student
            ,Coalesce(w_answer.total,0) AS paperTotal_answer,Coalesce(w_correct.total,0) AS paperTotal_correct,Coalesce(w_St_Count.total,0) AS paper_total_student
			FROM(
                SELECT contact.Name AS nameUser, contact.ID AS conID, GROUP_CONCAT(DISTINCT  row_level.Level_Name) AS allLavelName, GROUP_CONCAT(DISTINCT  subject.Name) AS allSubjectName 
                FROM class_table
                LEFT JOIN contact ON contact.ID = class_table.EmpID 
	            LEFT JOIN employee ON employee.Contact_ID = class_table.EmpID
	            INNER JOIN row_level ON row_level.ID = class_table.RowLevelID
	            INNER JOIN subject ON subject.ID = class_table.SubjectID
	            WHERE employee.jobTitleID = 0  AND class_table.ClassID != 0
	            AND contact.SchoolID IN("' . $this->session->userdata('SchoolID') . '") 
	            AND row_level.Level_ID = IFNULL(' . $lavelID . ' ,row_level.Level_ID)  
	            AND row_level.ID = IFNULL(' . $RowLevelID . ' ,row_level.ID)  
	            AND class_table.ClassID = IFNULL(' . $classID . ', class_table.ClassID)
	            AND class_table.SubjectID = IFNULL(' . $subjectID . ' ,class_table.SubjectID )
	            AND class_table.EmpID IN(' . $emp . ')
	            GROUP BY class_table.EmpID, class_table.ClassID
            ) c
            LEFT JOIN (
                SELECT COUNT(*) AS total, conversation.from_user
                FROM conversation
                JOIN messages ON messages.conversation_id = conversation.id 
                JOIN contact ON contact.ID = conversation.to_user AND contact.Type="S" 
                JOIN student ON contact.ID = student.Contact_ID
                JOIN row_level ON row_level.ID = student.R_L_ID
                WHERE ' . $whereChat . ' 
                AND messages.is_deleted = 0
                GROUP BY conversation.from_user
            ) m
            ON (c.conID = m.from_user)
            LEFT JOIN (
                SELECT COUNT(*) AS total, conversation.to_user
                FROM conversation
                JOIN messages ON messages.conversation_id = conversation.id 
                JOIN contact ON contact.ID = conversation.from_user AND contact.Type="S"
                JOIN student ON contact.ID = student.Contact_ID
                JOIN row_level ON row_level.ID = student.R_L_ID
                WHERE ' . $whereChat . '
                AND messages.is_deleted = 0
                GROUP BY conversation.to_user
            ) m_s
            ON (c.conID = m_s.to_user)
            LEFT JOIN (
                SELECT COUNT(DISTINCT(ask_teacher.ID)) AS total, ask_teacher.teacherID
                FROM ask_teacher
                inner join config_subject on ask_teacher.config_subjectID = config_subject.ID
                INNER JOIN contact ON ask_teacher.teacherID=contact.ID
                 JOIN row_level ON row_level.ID = config_subject.RowLevelID
                WHERE    ' . $whereAsk . ' and ask_teacher.teacherID IS NOT NULL
                GROUP BY ask_teacher.teacherID
            ) a
            ON (c.conID = a.teacherID)
            LEFT JOIN (
                SELECT COUNT(DISTINCT(ask_teacher.ID)) AS total, ask_teacher.teacherID
                FROM ask_teacher
                 inner join config_subject on ask_teacher.config_subjectID = config_subject.ID
                  JOIN row_level ON row_level.ID = config_subject.RowLevelID
                WHERE ' . $whereAsk . ' 
                 GROUP BY ask_teacher.teacherID
            ) a_s
            ON (c.conID = a_s.teacherID)
            
            LEFT JOIN (
                SELECT COUNT(DISTINCT(clerical_homework.token)) AS total, clerical_homework.Emp_ID
                FROM clerical_homework
                inner join class_table on class_table.RowLevelID=clerical_homework.RowLevelID
                inner JOIN contact ON contact.ID = clerical_homework.Emp_ID
	            INNER JOIN row_level ON row_level.ID = class_table.RowLevelID
	            INNER JOIN subject ON subject.ID = class_table.SubjectID
	            WHERE  contact.SchoolID IN("' . $this->session->userdata('SchoolID') . '")
	            AND row_level.Level_ID = IFNULL(' . $lavelID . ' ,row_level.Level_ID)  
	            AND row_level.ID = IFNULL(' . $RowLevelID . ' ,row_level.ID)  
	            AND class_table.ClassID = IFNULL(' . $classID . ', class_table.ClassID)
	            AND class_table.SubjectID = IFNULL(' . $subjectID . ' ,class_table.SubjectID )
                and ' . $whereHome . ' and clerical_homework.is_deleted=0 and clerical_homework.type=0
                GROUP BY clerical_homework.Emp_ID
            ) h
            ON (c.conID = h.Emp_ID)
            LEFT JOIN (
                SELECT COUNT(DISTINCT(clerical_homework.token)) AS total, clerical_homework.Emp_ID
                FROM clerical_homework
                inner join class_table on class_table.RowLevelID=clerical_homework.RowLevelID
                inner JOIN contact ON contact.ID = clerical_homework.Emp_ID
	            INNER JOIN row_level ON row_level.ID = class_table.RowLevelID
	            INNER JOIN subject ON subject.ID = class_table.SubjectID
	            WHERE  contact.SchoolID IN("' . $this->session->userdata('SchoolID') . '")
	            AND row_level.Level_ID = IFNULL(' . $lavelID . ' ,row_level.Level_ID)  
	            AND row_level.ID = IFNULL(' . $RowLevelID . ' ,row_level.ID)  
	            AND class_table.ClassID = IFNULL(' . $classID . ', class_table.ClassID)
	            AND class_table.SubjectID = IFNULL(' . $subjectID . ' ,class_table.SubjectID )
                and ' . $whereHome . ' and clerical_homework.is_deleted=0 and clerical_homework.type=1
                GROUP BY clerical_homework.Emp_ID
            ) P
            ON (c.conID = P.Emp_ID)
            LEFT JOIN (
                SELECT COUNT(ST.ID) AS total, clerical_homework.Emp_ID
                FROM clerical_homework
               
                inner JOIN contact ON contact.ID = clerical_homework.Emp_ID
                INNER JOIN student ON clerical_homework.RowLevelID=student.R_L_ID and FIND_IN_SET(student.Class_ID,clerical_homework.classID)
                inner JOIN contact AS ST ON ST.ID = student.Contact_ID
	            INNER JOIN row_level ON row_level.ID = clerical_homework.RowLevelID
	            INNER JOIN subject ON subject.ID = clerical_homework.Subject_ID
	            WHERE  contact.SchoolID IN("' . $this->session->userdata('SchoolID') . '") and ST.SchoolID IN("' . $this->session->userdata('SchoolID') . '") and ST.Isactive=1
	            AND row_level.Level_ID = IFNULL(' . $lavelID . ' ,row_level.Level_ID)  
	            AND row_level.ID = IFNULL(' . $RowLevelID . ' ,row_level.ID)  
	            AND student.Class_ID = IFNULL(' . $classID . ', student.Class_ID)
	            AND clerical_homework.Subject_ID = IFNULL(' . $subjectID . ' ,clerical_homework.Subject_ID )
                and ' . $whereHome . ' and clerical_homework.is_deleted=0 and clerical_homework.type=0
                GROUP BY clerical_homework.Emp_ID
            ) h_St_Count
            ON (c.conID = h_St_Count.Emp_ID)
            LEFT JOIN (
                SELECT COUNT(DISTINCT(clerical_homework_answer.ID)) AS total, clerical_homework.Emp_ID
                FROM  clerical_homework_answer
                INNER JOIN clerical_homework ON  clerical_homework_answer.homework_id = clerical_homework.ID
                 INNER JOIN student ON clerical_homework.RowLevelID=student.R_L_ID and FIND_IN_SET(student.Class_ID,clerical_homework.classID) and clerical_homework_answer.contact_idst =student.Contact_ID
                inner JOIN contact ON contact.ID = clerical_homework.Emp_ID
	            INNER JOIN row_level ON row_level.ID = clerical_homework.RowLevelID
	            INNER JOIN subject ON subject.ID = clerical_homework.Subject_ID
                WHERE contact.SchoolID IN("' . $this->session->userdata('SchoolID') . '") 
	            AND row_level.Level_ID = IFNULL(' . $lavelID . ' ,row_level.Level_ID)  
	            AND row_level.ID = IFNULL(' . $RowLevelID . ' ,row_level.ID)  
	             AND student.Class_ID = IFNULL(' . $classID . ', student.Class_ID)
	            AND clerical_homework.Subject_ID = IFNULL(' . $subjectID . ' ,clerical_homework.Subject_ID )
                and ' . $whereHome . ' and clerical_homework.is_deleted=0 and clerical_homework.type=0
                GROUP BY clerical_homework.Emp_ID
            ) h_answer
            ON (c.conID =h_answer.Emp_ID)
             LEFT JOIN (
                SELECT COUNT(DISTINCT(clerical_homework_answer.ID)) AS total, clerical_homework.Emp_ID
                FROM  clerical_homework_answer
                INNER JOIN clerical_homework ON  clerical_homework_answer.homework_id = clerical_homework.ID
                 INNER JOIN student ON clerical_homework.RowLevelID=student.R_L_ID and FIND_IN_SET(student.Class_ID,clerical_homework.classID) and clerical_homework_answer.contact_idst =student.Contact_ID
                inner JOIN contact ON contact.ID = clerical_homework.Emp_ID
	            INNER JOIN row_level ON row_level.ID = clerical_homework.RowLevelID
	            INNER JOIN subject ON subject.ID = clerical_homework.Subject_ID
                WHERE contact.SchoolID IN ("' . $this->session->userdata('SchoolID') . '") 
	            AND row_level.Level_ID = IFNULL(' . $lavelID . ' ,row_level.Level_ID)  
	            AND row_level.ID = IFNULL(' . $RowLevelID . ' ,row_level.ID)  
	            AND student.Class_ID = IFNULL(' . $classID . ', student.Class_ID)
	            AND clerical_homework.Subject_ID = IFNULL(' . $subjectID . ' ,clerical_homework.Subject_ID )
                and ' . $whereHome . ' AND clerical_homework_answer.student_result IS NOT NULL AND clerical_homework_answer.student_result !=""
                and clerical_homework.is_deleted=0 and clerical_homework.type=0
                GROUP BY clerical_homework.Emp_ID 
            ) h_correct
            ON (c.conID = h_correct.Emp_ID)
			LEFT JOIN (
                SELECT COUNT(ST.ID) AS total, clerical_homework.Emp_ID
                FROM clerical_homework
               
                inner JOIN contact ON contact.ID = clerical_homework.Emp_ID
                INNER JOIN student ON clerical_homework.RowLevelID=student.R_L_ID and FIND_IN_SET(student.Class_ID,clerical_homework.classID)
                inner JOIN contact AS ST ON ST.ID = student.Contact_ID
	            INNER JOIN row_level ON row_level.ID = clerical_homework.RowLevelID
	            INNER JOIN subject ON subject.ID = clerical_homework.Subject_ID
	            WHERE  contact.SchoolID IN("' . $this->session->userdata('SchoolID') . '") and ST.SchoolID IN("' . $this->session->userdata('SchoolID') . '") and ST.Isactive=1
	            AND row_level.Level_ID = IFNULL(' . $lavelID . ' ,row_level.Level_ID)  
	            AND row_level.ID = IFNULL(' . $RowLevelID . ' ,row_level.ID)  
	            AND student.Class_ID = IFNULL(' . $classID . ', student.Class_ID)
	            AND clerical_homework.Subject_ID = IFNULL(' . $subjectID . ' ,clerical_homework.Subject_ID )
                and ' . $whereHome . ' and clerical_homework.is_deleted=0 and clerical_homework.type=1
                GROUP BY clerical_homework.Emp_ID
            ) w_St_Count
            ON (c.conID = w_St_Count.Emp_ID)
            LEFT JOIN (
                SELECT COUNT(DISTINCT(clerical_homework_answer.ID)) AS total, clerical_homework.Emp_ID
                FROM  clerical_homework_answer
                INNER JOIN clerical_homework ON  clerical_homework_answer.homework_id = clerical_homework.ID
                 INNER JOIN student ON clerical_homework.RowLevelID=student.R_L_ID and FIND_IN_SET(student.Class_ID,clerical_homework.classID) and clerical_homework_answer.contact_idst =student.Contact_ID
                inner JOIN contact ON contact.ID = clerical_homework.Emp_ID
	            INNER JOIN row_level ON row_level.ID = clerical_homework.RowLevelID
	            INNER JOIN subject ON subject.ID = clerical_homework.Subject_ID
                WHERE contact.SchoolID IN("' . $this->session->userdata('SchoolID') . '") 
	            AND row_level.Level_ID = IFNULL(' . $lavelID . ' ,row_level.Level_ID)  
	            AND row_level.ID = IFNULL(' . $RowLevelID . ' ,row_level.ID)  
	             AND student.Class_ID = IFNULL(' . $classID . ', student.Class_ID)
	            AND clerical_homework.Subject_ID = IFNULL(' . $subjectID . ' ,clerical_homework.Subject_ID )
                and ' . $whereHome . ' and clerical_homework.is_deleted=0 and clerical_homework.type=1
                GROUP BY clerical_homework.Emp_ID
            ) w_answer
            ON (c.conID =w_answer.Emp_ID)
             LEFT JOIN (
                SELECT COUNT(DISTINCT(clerical_homework_answer.ID)) AS total, clerical_homework.Emp_ID
                FROM  clerical_homework_answer
                INNER JOIN clerical_homework ON  clerical_homework_answer.homework_id = clerical_homework.ID
                 INNER JOIN student ON clerical_homework.RowLevelID=student.R_L_ID and FIND_IN_SET(student.Class_ID,clerical_homework.classID) and clerical_homework_answer.contact_idst =student.Contact_ID 
                inner JOIN contact ON contact.ID = clerical_homework.Emp_ID
	            INNER JOIN row_level ON row_level.ID = clerical_homework.RowLevelID
	            INNER JOIN subject ON subject.ID = clerical_homework.Subject_ID
                WHERE contact.SchoolID IN ("' . $this->session->userdata('SchoolID') . '") 
	            AND row_level.Level_ID = IFNULL(' . $lavelID . ' ,row_level.Level_ID)  
	            AND row_level.ID = IFNULL(' . $RowLevelID . ' ,row_level.ID)  
	            AND student.Class_ID = IFNULL(' . $classID . ', student.Class_ID)
	            AND clerical_homework.Subject_ID = IFNULL(' . $subjectID . ' ,clerical_homework.Subject_ID )
                and ' . $whereHome . ' AND clerical_homework_answer.student_result IS NOT NULL AND clerical_homework_answer.student_result !=""
                and clerical_homework.is_deleted=0 and clerical_homework.type=1
                GROUP BY clerical_homework.Emp_ID 
            ) w_correct
            ON (c.conID = w_correct.Emp_ID)
            
            group by c.conID
            ')->result();
	}


	public function get_all_emp_reaction_total($Lang = NULL, $dateFrom, $dateTo, $lavelID)
	{
		$emp = get_emp_select_in();
		$whereChat = 1;
		$whereAsk = 1;
		$whereHome = 1;
		if ($dateFrom != 'NULL' && $dateTo != "NULL") {
			$whereChat = 'messages.created_at BETWEEN "' . $dateFrom . ' 00:00:00" AND "' . $dateTo . ' 23:59:59"'; //message outcoming
			$whereAsk = 'ask_teacher.Date BETWEEN "' . $dateFrom . ' 00:00:00" AND "' . $dateTo . ' 23:59:59" '; // asks reply on it
			$whereHome = 'clerical_homework.date_from BETWEEN "' . $dateFrom . ' 00:00:00" AND "' . $dateTo . ' 23:59:59" '; // clerical_homework created
		}

		return $this->db->query('
            SELECT c.*, Coalesce(m.total,0) AS chatTotal,Coalesce(m_s.total,0) AS chatTotal_s, Coalesce(a.total,0) AS askTotal, Coalesce(a_s.total,0) AS askTotal_s
            ,Coalesce(h.total,0) AS homeTotal ,Coalesce(P.total,0) AS PaperTotal,Coalesce(h_answer.total,0) AS homeTotal_answer,Coalesce(h_correct.total,0) AS homeTotal_correct,Coalesce(h_St_Count.total,0) AS total_student
            FROM(
                SELECT contact.Name AS nameUser, contact.ID AS conID,row_level.Level_ID, GROUP_CONCAT(DISTINCT  row_level.Level_Name) AS allLavelName, GROUP_CONCAT(DISTINCT  subject.Name) AS allSubjectName 
                FROM class_table
                LEFT JOIN contact ON contact.ID = class_table.EmpID 
	            LEFT JOIN employee ON employee.Contact_ID = class_table.EmpID
	            INNER JOIN row_level ON row_level.ID = class_table.RowLevelID
	            INNER JOIN subject ON subject.ID = class_table.SubjectID
	            WHERE employee.jobTitleID = 0  AND class_table.ClassID != 0
	            AND contact.SchoolID IN("' . $this->session->userdata('SchoolID') . '") 
	            AND row_level.Level_ID = IFNULL(' . $lavelID . ' ,row_level.Level_ID)  
	            AND class_table.EmpID IN(' . $emp . ')
	            GROUP BY row_level.Level_ID
            ) c
            LEFT JOIN (
                SELECT COUNT(*) AS total, conversation.from_user,row_level.Level_ID
                FROM conversation
                JOIN messages ON messages.conversation_id = conversation.id 
                JOIN contact ON contact.ID = conversation.to_user AND contact.Type="S"
                JOIN student ON contact.ID = student.Contact_ID
                JOIN row_level ON row_level.ID = student.R_L_ID
                WHERE ' . $whereChat . '
                 AND row_level.Level_ID = IFNULL(' . $lavelID . ' ,row_level.Level_ID)  
                GROUP BY row_level.Level_ID
            ) m
            ON (c.Level_ID = m.Level_ID)
            LEFT JOIN (
                SELECT COUNT(*) AS total, conversation.to_user,row_level.Level_ID
                FROM conversation
                JOIN messages ON messages.conversation_id = conversation.id 
                JOIN contact ON contact.ID = conversation.from_user AND contact.Type="S"
                JOIN student ON contact.ID = student.Contact_ID
                JOIN row_level ON row_level.ID = student.R_L_ID
                WHERE ' . $whereChat . '
                 AND row_level.Level_ID = IFNULL(' . $lavelID . ' ,row_level.Level_ID)  
                GROUP BY row_level.Level_ID
            ) m_s
            ON (c.Level_ID = m_s.Level_ID)
            LEFT JOIN (
                SELECT COUNT(DISTINCT(ask_teacher.ID)) AS total, ask_teacher.teacherID,row_level.Level_ID
                FROM ask_teacher
                inner join config_subject on ask_teacher.config_subjectID = config_subject.ID
                INNER JOIN contact ON ask_teacher.teacherID=contact.ID
                JOIN row_level ON row_level.ID = config_subject.RowLevelID
                WHERE   ask_teacher.teacherID IS NOT NULL AND ' . $whereAsk . '
                 AND row_level.Level_ID = IFNULL(' . $lavelID . ' ,row_level.Level_ID)  
                GROUP BY row_level.Level_ID
            ) a
            ON (c.Level_ID = a.Level_ID)
            LEFT JOIN (
                SELECT COUNT(DISTINCT(ask_teacher.ID)) AS total, ask_teacher.teacherID,row_level.Level_ID
                FROM ask_teacher
                 inner join config_subject on ask_teacher.config_subjectID = config_subject.ID
                 JOIN row_level ON row_level.ID = config_subject.RowLevelID
                WHERE ' . $whereAsk . '
                  AND row_level.Level_ID = IFNULL(' . $lavelID . ' ,row_level.Level_ID)  
                 GROUP BY row_level.Level_ID
            ) a_s
            ON (c.Level_ID = a_s.Level_ID)
            
            LEFT JOIN (
                SELECT COUNT(DISTINCT(clerical_homework.token)) AS total, clerical_homework.Emp_ID,row_level.Level_ID
                FROM clerical_homework
                inner join class_table on class_table.RowLevelID=clerical_homework.RowLevelID
                inner JOIN contact ON contact.ID = clerical_homework.Emp_ID
	            INNER JOIN row_level ON row_level.ID = class_table.RowLevelID
	            INNER JOIN subject ON subject.ID = class_table.SubjectID
	            WHERE  contact.SchoolID IN("' . $this->session->userdata('SchoolID') . '")
	            AND row_level.Level_ID = IFNULL(' . $lavelID . ' ,row_level.Level_ID)  
                and ' . $whereHome . ' and clerical_homework.is_deleted=0 and clerical_homework.type=0
                GROUP BY row_level.Level_ID
            ) h
            ON (c.Level_ID = h.Level_ID)
             LEFT JOIN (
                SELECT COUNT(DISTINCT(clerical_homework.token)) AS total, clerical_homework.Emp_ID,row_level.Level_ID
                FROM clerical_homework
                inner join class_table on class_table.RowLevelID=clerical_homework.RowLevelID
                inner JOIN contact ON contact.ID = clerical_homework.Emp_ID
	            INNER JOIN row_level ON row_level.ID = class_table.RowLevelID
	            INNER JOIN subject ON subject.ID = class_table.SubjectID
	            WHERE  contact.SchoolID IN("' . $this->session->userdata('SchoolID') . '")
	            AND row_level.Level_ID = IFNULL(' . $lavelID . ' ,row_level.Level_ID)  
                and ' . $whereHome . ' and clerical_homework.is_deleted=0 and clerical_homework.type=1
                GROUP BY row_level.Level_ID
            ) P
            ON (c.Level_ID = P.Level_ID)
            LEFT JOIN (
                SELECT COUNT(ST.ID) AS total, clerical_homework.Emp_ID,row_level.Level_ID
                FROM clerical_homework
               
                inner JOIN contact ON contact.ID = clerical_homework.Emp_ID
                INNER JOIN student ON clerical_homework.RowLevelID=student.R_L_ID and FIND_IN_SET(student.Class_ID,clerical_homework.classID)
                inner JOIN contact AS ST ON ST.ID = student.Contact_ID
	            INNER JOIN row_level ON row_level.ID = clerical_homework.RowLevelID
	            INNER JOIN subject ON subject.ID = clerical_homework.Subject_ID
	            WHERE  contact.SchoolID IN("' . $this->session->userdata('SchoolID') . '") and ST.SchoolID IN("' . $this->session->userdata('SchoolID') . '") and ST.Isactive=1
	            AND row_level.Level_ID = IFNULL(' . $lavelID . ' ,row_level.Level_ID)  
                and ' . $whereHome . ' and clerical_homework.is_deleted=0 and clerical_homework.type=0
                GROUP BY row_level.Level_ID
            ) h_St_Count
            ON (c.Level_ID = h_St_Count.Level_ID)
            LEFT JOIN (
                SELECT COUNT(DISTINCT(clerical_homework_answer.ID)) AS total, clerical_homework.Emp_ID,row_level.Level_ID
                FROM  clerical_homework_answer
                INNER JOIN clerical_homework ON  clerical_homework_answer.homework_id = clerical_homework.ID
                inner JOIN contact ON contact.ID = clerical_homework.Emp_ID
	            INNER JOIN row_level ON row_level.ID = clerical_homework.RowLevelID
	            INNER JOIN subject ON subject.ID = clerical_homework.Subject_ID
                WHERE contact.SchoolID IN("' . $this->session->userdata('SchoolID') . '") 
	            AND row_level.Level_ID = IFNULL(' . $lavelID . ' ,row_level.Level_ID)  
                and ' . $whereHome . ' and clerical_homework.is_deleted=0 and clerical_homework.type=0
                GROUP BY row_level.Level_ID
            ) h_answer
            ON (c.Level_ID = h_answer.Level_ID)
             LEFT JOIN (
                SELECT COUNT(DISTINCT(clerical_homework_answer.ID)) AS total, clerical_homework.Emp_ID,row_level.Level_ID
                FROM  clerical_homework_answer
                INNER JOIN clerical_homework ON  clerical_homework_answer.homework_id = clerical_homework.ID
                inner JOIN contact ON contact.ID = clerical_homework.Emp_ID
	            INNER JOIN row_level ON row_level.ID = clerical_homework.RowLevelID
	            INNER JOIN subject ON subject.ID = clerical_homework.Subject_ID
                WHERE contact.SchoolID IN ("' . $this->session->userdata('SchoolID') . '") 
	            AND row_level.Level_ID = IFNULL(' . $lavelID . ' ,row_level.Level_ID)  
                and ' . $whereHome . ' AND clerical_homework_answer.student_result IS NOT NULL AND clerical_homework_answer.student_result !=0
                and clerical_homework.is_deleted=0 and clerical_homework.type=0
                GROUP BY row_level.Level_ID 
            ) h_correct
            ON (c.Level_ID = h_correct.Level_ID)
            
            group by c.Level_ID
            ')->result();
	}


	public function get_teacher_weeks_data($TeacherID, $LevelID, $RowLevelID, $classID, $subjectID, $DayDateFrom, $DayDateTo)
	{
		$where = '';
		$where1 = '';
		$rowlevelwhere = '';
		$ClassIDwhere = '';
		$SubjectIDwhere = '';
		if ($DayDateFrom && $DayDateTo) {
			$where = ' AND plan_week.Date_Stm BETWEEN "' . $DayDateFrom . ' 00:00:00" AND "' . $DayDateTo . ' 00:00:00"  ';
		}
		if ($LevelID != 0) {
			$where1 = ' AND row_level.Level_ID =' . $LevelID;
		}
		if ($RowLevelID != 0) {
			$rowlevelwhere = '  AND row_level.ID =' . $RowLevelID;
		}

		if ($classID != 0) {
			$ClassIDwhere = ' AND class_table.ClassID =' . $classID;
		}

		if ($subjectID != 0) {
			$SubjectIDwhere = ' AND class_table.SubjectID =' . $subjectID;
		}

		$data = $this->db->query("
		 	SELECT 
			  DISTINCT plan_week.WeekID, plan_week.ID as plan_week_id, 
			  	plan_week.report_degree, plan_week.report_comment,plan_week.reporter_id,
			   plan_week.SemesterID,contact.ID ,row_level.Level_Name, row_level.Row_Name
			,contact.Name as teachename
			FROM plan_week 	
			INNER JOIN class_table ON plan_week.ClassTableID = class_table.ID 
			inner join row_level  on class_table.RowLevelID = row_level.ID
			inner join level  on row_level.Level_ID = level.ID
			inner JOIN contact on contact.ID = class_table.EmpID
			WHERE class_table.SchoolID  =" . $this->session->userdata('SchoolID') . "
			
			AND (contact.ID = " . $TeacherID . " )
			AND (plan_week.Content !='' or plan_week.FileAttach is not NULL)"
			. $where . $where1 . $rowlevelwhere . $ClassIDwhere . $SubjectIDwhere . " GROUP BY plan_week.WeekID");

		return $data->result();
	}

	public function get_teacher_libiraries($TeacherID, $LevelID, $RowLevelID, $classID, $subjectID, $DayDateFrom, $DayDateTo)
	{
		$where = '';
		$where1 = '';
		$rowlevelwhere = '';
		$ClassIDwhere = '';
		$SubjectIDwhere = '';
		if ($DayDateFrom && $DayDateTo) {
			$where = " AND date(e_library.Stm_Date) BETWEEN '" . $DayDateFrom . "' AND '" . $DayDateTo . "'  ";
		}
		if ($RowLevelID != 0) {
			$where1 = ' AND row_level.ID =' . $RowLevelID; // 
		}
		if ($LevelID != 0) {
			$rowlevelwhere = '  AND row_level.Level_ID =' . $LevelID;
		}

		if ($classID != 0) {
			$ClassIDwhere = " AND FIND_IN_SET(" . $classID . ",e_library.ClassID)";
		}

		if ($subjectID != 0) {
			$SubjectIDwhere = ' AND e_library.SubjectID  =' . $subjectID;
		}


		$data = $this->db->query("
				select e_library.ID as countLib, e_library.Title as lib_title ,e_library.ContactID , contact.name,
				e_library.report_degree, e_library.report_comment,e_library.reporter_id, e_library.RowLevelID,e_library.SubjectID,
				subject.Name as allSubjectName , row_level.Level_Name, row_level.Row_Name ,Date(e_library.Stm_Date) as Date
				from e_library 
				inner join row_level  on row_level.ID = e_library.RowLevelID
				inner join subject  on subject.ID = e_library.SubjectID
				inner join contact  on contact.ID = e_library.ContactID
				left join config_semester  on config_semester.ID = e_library.SemesterID
				where e_library.ContactID = " . $TeacherID . " 	"
			. $where . $where1 . $rowlevelwhere . $ClassIDwhere . $SubjectIDwhere);

		return $data->result();
	}


	public function get_teacher_tests($TeacherID, $LevelID, $RowLevelID, $classID, $subjectID, $DayDateFrom, $DayDateTo)
	{
		$where = '';
		$where1 = '';
		$rowlevelwhere = '';
		$ClassIDwhere = '';
		$SubjectIDwhere = '';
		if ($DayDateFrom && $DayDateTo) {
			$where = ' AND cast(test.Date_Stm as date) BETWEEN "' . $DayDateFrom . ' 00:00:00" AND "' . $DayDateTo . ' 00:00:00"  ';
		}
		if ($RowLevelID != 0) {
			$where1 = ' AND row_level.ID =' . $RowLevelID; // 
		}
		if ($LevelID != 0) {
			$rowlevelwhere = '  AND row_level.Level_ID =' . $LevelID;
		}
		if ($classID != 0) {
			$ClassIDwhere = " AND FIND_IN_SET($classID,test.classID )";
		}
		if ($subjectID != 0) {
			$SubjectIDwhere = ' AND test.subject_id =' . $subjectID;
		}
		$data = $this->db->query("
								select test.ID,test.Name as test_name, contact.name , test.empID,test.RowLevelID,test.subject_id
								, row_level.Level_Name, row_level.Row_Name , subject.Name as allSubjectName,
								test.report_degree, test.report_comment,test.reporter_id ,Date(test.date_from) as date_from,Date(test.date_to) as date_to
								from test								
								inner join config_semester  on config_semester.ID = test.config_semester_ID
								INNER JOIN row_level  on row_level.ID = test.RowLevelID
								INNER JOIN contact  on contact.ID = test.empID
								INNER JOIN subject  on subject.ID = test.subject_id
								where test.type = 0 AND test.is_deleted=0
								AND test.empID = " . $TeacherID . " 	"
			. $where . $where1 . $rowlevelwhere . $ClassIDwhere . $SubjectIDwhere .
			" group by test.ID
								");

		return $data->result();
	}

	public function get_teacher_homeWorks($TeacherID, $LevelID, $RowLevelID, $classID, $subjectID, $DayDateFrom, $DayDateTo)
	{
		$where = '';
		if ($DayDateFrom && $DayDateTo) {
			$where .= ' AND cast(test.Date_Stm as date) BETWEEN "' . $DayDateFrom . ' 00:00:00" AND "' . $DayDateTo . ' 00:00:00"  ';
		}
		if ($RowLevelID != 0) {
			$where .= ' AND row_level.ID =' . $RowLevelID; // 
		}
		if ($LevelID != 0) {
			$where .= '  AND row_level.Level_ID =' . $LevelID;
		}
		if ($classID != 0) {
			$where .= " AND FIND_IN_SET($classID,test.classID )";
		}
		if ($subjectID != 0) {
			$where .= ' AND test.subject_id =' . $subjectID;
		}
		$data = $this->db->query("
								select test.ID,test.Name as test_name, contact.name , test.empID,test.RowLevelID,test.subject_id
								, row_level.Level_Name, row_level.Row_Name , subject.Name as allSubjectName,
								test.report_degree, test.report_comment,test.reporter_id ,Date(test.date_from) as date_from,Date(test.date_to) as date_to
								from test								
								INNER JOIN row_level  on row_level.ID = test.RowLevelID
							    INNER JOIN contact  on contact.ID = test.empID
								INNER JOIN subject  on subject.ID = test.subject_id
								where test.type = 1 AND test.is_deleted=0 
								AND test.empID = " . $TeacherID . " 	"
			. $where .
			" group by test.ID
								");

		return $data->result();
	}

	public function get_teacher_lessonPreps($TeacherID, $LevelID, $RowLevelID, $classID, $subjectID, $DayDateFrom, $DayDateTo)
	{
		$where = '';
		if ($DayDateFrom && $DayDateTo) {
			$where .= ' AND((lesson_prep.startDate BETWEEN  "' . $DayDateFrom . '" and  "' . $DayDateTo . '")OR (lesson_prep.date_from  BETWEEN   "' . $DayDateFrom . '" and  "' . $DayDateTo . '"))  ';
		}
		if ($RowLevelID != 0) {
			$where .= ' AND row_level.ID =' . $RowLevelID; // 
		}
		if ($LevelID != 0) {
			$where .= '  AND row_level.Level_ID =' . $LevelID;
		}
		if ($classID != 0) {
			$where .= " AND FIND_IN_SET($classID,lesson_prep.classID )";
		}
		if ($subjectID != 0) {
			$where .= ' AND lesson_prep.Subject_ID =' . $subjectID;
		}
		$data = $this->db->query("
								select lesson_prep.ID,lesson_prep.Lesson_Title ,lesson_prep.Teacher_ID, contact.name ,lesson_prep.Token
								, row_level.Level_Name, row_level.Row_Name , subject.Name as allSubjectName,
								lesson_prep.report_degree, lesson_prep.report_comment,lesson_prep.reporter_id,lesson_prep.startDate
								from lesson_prep								
								INNER JOIN row_level  on row_level.ID = lesson_prep.RowLevel_ID
								INNER JOIN contact  on contact.ID = lesson_prep.Teacher_ID
								INNER JOIN subject  on subject.ID = lesson_prep.Subject_ID								
								where lesson_prep.Teacher_ID = " . $TeacherID . " 	"
			. $where .
			" group by lesson_prep.ID		
											
								");

		return $data->result();
	}


	public function get_teacher_ClericalHomework($TeacherID, $LevelID, $RowLevelID, $classID, $subjectID, $DayDateFrom, $DayDateTo, $type)
	{
		$where = '';
		if ($DayDateFrom && $DayDateTo) {
			$where .= ' AND ((DATE(clerical_homework.date_homework) BETWEEN "' . $DayDateFrom . '" AND "' . $DayDateTo . '")OR
			(DATE(clerical_homework.date_from) BETWEEN "' . $DayDateFrom . '" AND "' . $DayDateTo . '"))   ';
		}
		if ($RowLevelID != 0) {
			$where .= ' AND row_level.ID =' . $RowLevelID; // 
		}
		if ($LevelID != 0) {
			$where .= '  AND row_level.Level_ID =' . $LevelID;
		}
		if ($classID != 0) {
			$where .= " AND FIND_IN_SET($classID,clerical_homework.classID ) ";
		}
		if ($subjectID != 0) {
			$where .= ' AND clerical_homework.Subject_ID = ' . $subjectID;
		}
		$data = $this->db->query("select
								clerical_homework.ID, contact.name , clerical_homework.title,clerical_homework.RowLevelID,clerical_homework.Subject_ID
								, row_level.Level_Name, row_level.Row_Name , subject.Name as allSubjectName,clerical_homework.type,clerical_homework.classID,
								clerical_homework.report_degree, clerical_homework.report_comment,clerical_homework.reporter_id,clerical_homework.date_from
								from clerical_homework			

								INNER JOIN row_level  on row_level.ID = clerical_homework.RowLevelID
								INNER JOIN contact  on contact.ID = clerical_homework.Emp_ID
								INNER JOIN subject  on subject.ID = clerical_homework.Subject_ID
								where clerical_homework.Emp_ID = " . $TeacherID . " AND clerical_homework.is_deleted=0 and clerical_homework.type=$type " . $where . " 
								group by clerical_homework.token		
											
								");

		return $data->result();
	}



	public function get_teacher_classTables($TeacherID, $LevelID, $RowLevelID, $classID, $subjectID, $DayDateFrom, $DayDateTo)
	{
		$where = '';
		if ($DayDateFrom && $DayDateTo) {
			// $where.= ' AND clerical_homework.Date BETWEEN "'.$DayDateFrom.' 00:00:00" AND "'.$DayDateTo.' 00:00:00"  ';
		}
		if ($RowLevelID != 0) {
			$where .= ' AND row_level.ID =' . $RowLevelID; // 
		}
		if ($LevelID != 0) {
			$where .= '  AND row_level.Level_ID =' . $LevelID;
		}
		if ($classID != 0) {
			$where .= ' AND class_table.ClassID =' . $classID;
		}
		if ($subjectID != 0) {
			$where .= ' AND class_table.SubjectID =' . $subjectID;
		}
		$data = $this->db->query("select
								class_table.ID as newCount,
								 contact.name 
								, row_level.Level_Name, row_level.Row_Name , subject.Name as allSubjectName,
								class_table.report_degree, class_table.report_comment,class_table.reporter_id
								from class_table	
								
								left join contact on contact.ID = class_table.EmpID 
								left join employee on employee.Contact_ID = class_table.EmpID
								inner join row_level on row_level.ID = class_table.RowLevelID
								inner join subject on subject.ID = class_table.SubjectID

								WHERE employee.jobTitleID = 0  and class_table.ClassID != 0
								AND contact.SchoolID  IN(" . $this->session->userdata('SchoolID') . ")
																
								AND contact.ID = " . $TeacherID . " 	"
			. $where .
			" 	
											
								");

		return $data->result();
	}
	///////////////////////////////////////////
	public function students_delay_absence($Lang = NULL, $level = NULL, $RowLevel = NULL, $Class = NULL, $DateFrom = NULL, $DateTo = NULL)
	{

		$student = get_student_select_in();
		if ($level == 0) {
			$level1 = "NULL";
		} else {
			$level1 = $level;
		}
		if ($RowLevel == 0) {
			$RowLevel1 = "NULL";
		} else {
			$RowLevel1 = $RowLevel;
		}
		if ($Class == 0) {
			$Class1 = "NULL";
		} else {
			$Class1 = $Class;
		}
		if ($DateFrom == 0) {
			$DateFrom1 = "0000-00-00";
		} else {
			$DateFrom1 = "'$DateFrom'";
		}
		if ($DateTo == 0) {
			$DateTo1 = "CURDATE()";
		} else {
			$DateTo1 = "'$DateTo'";
		}
		$NameArray = array("Level" => "Name AS LevelName", "row" => "Name AS RowName", "class" => "Name AS ClassName", "lesson" => "lesson AS LessonName");
		if ($Lang == "english") {
			$NameArray = array("Level" => "Name_en AS LevelName", "row" => " Name_en AS RowName", "class" => "Name_en AS ClassName", "lesson" => "Lesson_en AS LessonName");
		}

		$getReport = $this->db->query("
		SELECT
		level.ID AS LevelID,
		row.ID AS RowID,
		class.ID AS ClassID,
		level." . $NameArray['Level'] . ",
		row." . $NameArray['row'] . ",
		row_level.ID As RowLevelID ,
		class.ID As ClassID ,
		class." . $NameArray['class'] . " ,
		contact.ID AS StudentID,
		contact.Name AS FullName,
		students_evaluation.ID AS AbcentID , 
		students_evaluation.attendance , 
		students_evaluation.Absence, 
		students_evaluation.Delay  AS Delay ,
		students_evaluation.Date  AS AbcentDate ,
		students_evaluation.SubjectID,
		students_evaluation.lesson_prepID,
		students_evaluation.TeacherID AS TeacherName ,
		contact.SchoolID
		FROM contact 
		INNER JOIN student 				ON contact.ID = student.Contact_ID
		INNER JOIN class 				ON student.Class_ID = class.ID
		INNER JOIN row_level 			ON student.R_L_ID = row_level.ID
		INNER JOIN row 					ON row_level.Row_ID = row.ID
		INNER JOIN level 				ON row_level.Level_ID = level.ID
		INNER JOIN students_evaluation 	ON students_evaluation.StudentID = contact.ID
		INNER JOIN contact AS tb1 		ON tb1.ID = students_evaluation.TeacherID
		where
		contact.Isactive = 1 
	    AND
	    students_evaluation.Date >= IFNULL($DateFrom1, students_evaluation.Date)
	     AND
	    students_evaluation.Date <= IFNULL($DateTo1, students_evaluation.Date)
    	AND
		level.ID = IFNULL($level1,level.ID)
		AND
		row_level.ID = IFNULL($RowLevel1,row_level.ID)
		AND
		class.ID = IFNULL($Class1,class.ID)
		AND
		students_evaluation.BehaviorID =0
		AND
		(students_evaluation.Absence IN (0,1)
		OR
		attendance IS NOT NULL)
		AND
		students_evaluation.lesson_prepID IS NULL
		AND
		students_evaluation.SubjectID =0
		AND
		contact.SchoolID IN(" . $this->session->userdata('SchoolID') . ") 
		AND contact.ID IN(" . $student . ")
		ORDER BY  students_evaluation.ID
		 ")->result();
		if (sizeof($getReport) > 0) {
			return $getReport;
		} else {
			return FALSE;
		}
	}
	///////////////////////////////////
	public function get_students()
	{
		$GetData = $this->db->query("
		select ID,Name 
		from contact
		where Type='S' and SchoolID  IN(" . $this->session->userdata('SchoolID') . ")
		");
		if ($GetData->num_rows() > 0) {
			return $GetData->result();
		} else {
			return FALSE;
		}
	}
	////////////////////////////////////////
	public function edit_students($id)
	{
		$GetData = $this->db->query("
		select ID,StudentID 
		from students_evaluation
		where ID=" . $id . "
		");
		if ($GetData->num_rows() > 0) {
			return $GetData->result();
		} else {
			return FALSE;
		}
	}
	////////////////////////////
	public function add_delay_absence($StID  = 0, $CheckAttend = 0, $CheckData = 0, $CheckDelay = 0, $id, $Timezone)
	{
		$Today         =  date("l");
		$DayArray  = array('Saturday' => 'السبت', 'Sunday' => 'الأحد', 'Monday' => 'الأثنين', 'Tuesday' => 'الثلاثاء', 'Wednesday' => 'الأربعاء', 'Thursday' => 'الخميس', 'Friday' => 'الجمعة');
		$TodayString   = $DayArray[$Today];
		//echo $TodayString ; exit ; 
		$CheckBehavior = 1;
		if ($CheckData == 0 && !empty($CheckDelay)) {
			$CheckBehavior = 2;
		}
		$Msg = "";
		$GetMsg = $this->db->query("SELECT Message FROM config_behavior WHERE ID = '" . $CheckBehavior . "' LIMIT 1  ")->row_array();
		if (sizeof($GetMsg) > 0) {
			$Msg = $GetMsg['Message'];
		}

		$FatherID = 0;
		$LevelID  = 0;
		$SchoolID = 0;
		$StuName  = "";
		$GetStuData = $this->edit_students($StID, $this->session->userdata('language'));
		if (sizeof($GetStuData) > 0) {
			$FatherID = $GetStuData['FatherID'];
			$LevelID  = $GetStuData['LevelID'];
			$SchoolID = $GetStuData['StuSchoolID'];
			$StuName  = $GetStuData['StudentName'];
		}
		$LastMsg = "";
		if ($CheckBehavior == 1) {
			$LastMsg = $Msg . " " . $StuName . " " . $TodayString . " " . date('Y-m-d');
		} else {
			$LastMsg = $Msg . " " . $StuName . ' مده التأخير ' . $CheckDelay . ' دقيقة' . " " . $TodayString . " " . date('Y-m-d');
		}
		$CountMsg    = 1;
		$LastCount     = $this->db->query("SELECT CountMsg FROM temp_msg  ORDER BY ID DESC LIMIT 1")->row_array();
		if (sizeof($LastMsg) > 0) {
			$CountMsg = (int)$LastCount['CountMsg'] + 1;
		}
		if ($CheckAttend == 1) {
			$this->db->query("
        update  students_evaluation
        SET
        attendance  = '" . $CheckAttend . "' ,
        Absence     = '' ,
        Delay       = '" . $CheckDelay . "' ,
        Date_stm    = '" . $Timezone . "'
        where  StudentID   = '" . $StID . "' and TeacherID   = '" . $this->session->userdata('id') . "' and ID=" . $id . "
         ");
		} else {
			$this->db->query("
        update  students_evaluation
        SET
        attendance  = '" . $CheckAttend . "' ,
        Absence     = '" . $CheckBehavior . "' ,
        Delay       = '" . $CheckDelay . "' ,
        Date_stm    = '" . $Timezone . "' 
        where  StudentID   = '" . $StID . "' and TeacherID   = '" . $this->session->userdata('id') . "' and ID=" . $id . "
         ");
		}
		return TRUE;
	}
	///////////////////////////////////
	public function dele_delay_absence($id)
	{
		$this->db->query("
		delete  FROM students_evaluation where ID=" . $id . "
		");
	}
	///////////////////////////////////
	public function get_level_school()
	{
		$GetData = $this->db->query("
		select level.ID AS LevelID,level.Name
		from row_level
		INNER JOIN level 				ON row_level.Level_ID = level.ID
		INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID
		where SchoolID  =" . $this->session->userdata('SchoolID') . "
		group by level.ID
		");
		if ($GetData->num_rows() > 0) {
			return $GetData->result();
		} else {
			return FALSE;
		}
	}
	public function getRowLevel($Lang = NULL, $levelID = 0)
	{

		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		if ($levelID == 0) {
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
		 ")->result();
			if (sizeof($query) > 0) {
				return $query;
			} else {
				return  FALSE;
			}
		} else {
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
		 WHERE level.ID IN(" . $levelID . ")
		 group by RowLevelID
		 ")->result();
			if (sizeof($query) > 0) {
				return $query;
			} else {
				return  FALSE;
			}
		}
	}
	////////////////////
	public function get_row_level($Lang = NULL, $row_level = 0)
	{

		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		if ($row_level == 0) {
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
		 ")->result();
			if (sizeof($query) > 0) {
				return $query;
			} else {
				return  FALSE;
			}
		} else {
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
		 WHERE  row_level.ID IN(" . $row_level . ")
		 ")->result();
			if (sizeof($query) > 0) {
				return $query;
			} else {
				return  FALSE;
			}
		}
	}
	///////////////////
	public function get_all_Class($Lang = NULL, $row_level = 0)
	{

		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		if ($row_level == 0) {
			$query = $this->db->query("SELECT
		  row_level.ID AS RowLevelID ,
          row_level.Level_Name AS LevelName ,
          row_level.Row_Name AS RowName ,
		  class.ID  AS ClassID ,
		  class.Name AS ClassName 
		  FROM class
		  INNER JOIN school_class ON class.ID = school_class.ClassID AND school_class.SchoolID = '" . $this->session->userdata('SchoolID') . "'
		  INNER JOIN school_row_level ON school_class.SchoolID = school_row_level.SchoolID
		  INNER JOIN row_level ON row_level.ID = school_row_level.RowLevelID
		  order by row_level.ID
		 ")->result();
			if (sizeof($query) > 0) {
				return $query;
			} else {
				return  FALSE;
			}
		} else {
			$Name = 'Name';
			if ($Lang == 'english') {
				$Name = 'Name_en';
			}
			$query = $this->db->query("SELECT
		  row_level.ID AS RowLevelID ,
          row_level.Level_Name AS LevelName ,
          row_level.Row_Name AS RowName ,
		  class.ID  AS ClassID ,
		  class.Name AS ClassName 
		  FROM class
		  INNER JOIN school_class ON class.ID = school_class.ClassID AND school_class.SchoolID = '" . $this->session->userdata('SchoolID') . "'
		  INNER JOIN school_row_level ON school_class.SchoolID = school_row_level.SchoolID
		  INNER JOIN row_level ON row_level.ID = school_row_level.RowLevelID
          WHERE row_level.ID = " . $row_level . "
          order by row_level.ID AND class.ID
		 	 ")->result();
			if (sizeof($query) > 0) {
				return $query;
			} else {
				return  FALSE;
			}
		}
	}
	public function delete_evaluation($Data)
	{
		extract($Data);

		$this->db->query(" delete  FROM emp_evaluation where ID = " . $emp_evaluation_ID . " ");
		return true;
	}
	////////////////////////////////////
	public function delete_total_evaluation($ContactID, $ContactEmpID, $EvaluationDateStm)
	{

		$this->db->query("
		delete  FROM emp_evaluation where ContactID=" . $ContactID . " and EmpID=" . $ContactEmpID . " and date= '$EvaluationDateStm' ");
	}
	public function eval_report($emp_evaluation_ID)
	{
		//$emp_evaluation_ID=$this->uri->segment(4);
		$GetData = $this->db->query("
		SELECT
		emp_evaluation.Note ,
		emp_evaluation.Degree,
		evaluation_note.NoteDegree
		FROM
		emp_evaluation
	inner join evaluation_note on emp_evaluation.noteID =evaluation_note.ID
		WHERE emp_evaluation.ID = $emp_evaluation_ID
	
		");
		if ($GetData->num_rows() > 0) {
			return $GetData->result();
		} else {
			return FALSE;
		}
	}



	public function get_subject_emp1($select_emp, $RowLevel, $Lang = NULL)
	{
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		$query = $this->db->query("SELECT DISTINCT 
		  level.ID       AS LevelID,
		  row.ID         AS RowID,
		  level.Name     AS LevelName,
		  row.Name       AS RowName,
		  row_level.ID   As RowLevelID ,
		  subject.ID AS SubjectID ,
		  subject.Name AS SubjectName 
		 
		  FROM class_table
		  inner join school_row_level on  school_row_level.SchoolID=class_table.SchoolID and class_table.RowLevelID=school_row_level.RowLevelID
		  INNER JOIN subject ON subject.ID=class_table.SubjectID
		  INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
		  INNER JOIN row              ON row_level.Row_ID        = row.ID
		  INNER JOIN level            ON row_level.Level_ID      = level.ID
		  INNER JOIN class            ON class_table.ClassID=class.ID
		  where  class_table.EmpID ='" . $select_emp . "'
		  AND  row_level.ID   	   ='" . $RowLevel . "' 
		 
		  
		   ");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}


	public function get_subject_emp2($id, $Lang = NULL)
	{
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		$query = $this->db->query("SELECT DISTINCT 
		  level.ID       AS LevelID,
		  row.ID         AS RowID,
		  level.Name     AS LevelName,
		  row.Name       AS RowName,
		  row_level.ID   As RowLevelID ,
		  class.ID       As ClassID ,
		  subject.ID AS SubjectID ,
		  subject. " . $Name . " AS SubjectName ,
		  class.ID  AS ClassID ,
		  class. " . $Name . " AS ClassName 
		  FROM class
		  INNER JOIN school_class ON class.ID = school_class.ClassID AND school_class.SchoolID = '" . $this->session->userdata('SchoolID') . "'
		  INNER JOIN class_table ON class.ID=class_table.ClassID
		  inner join school_row_level on  school_row_level.SchoolID=class_table.SchoolID and class_table.RowLevelID=school_row_level.RowLevelID
		  INNER JOIN subject ON subject.ID=class_table.SubjectID
		  INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
		  INNER JOIN row              ON row_level.Row_ID        = row.ID
		  INNER JOIN level            ON row_level.Level_ID      = level.ID
		  where  class_table.EmpID ='" . $id . "'
		 
		  
		   ");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}

	public function get_exam_ids($select_subject, $RowLevel, $select_emp)
	{

		$ResultExam = $this->db->query("SELECT Distinct test.ID AS testID  ,test.Name AS testName from test
			INNER JOIN questions_content on questions_content.test_id =test.ID 
            where test.empID=$select_emp
            AND test.type=0
    		AND test.subject_id=$select_subject
    		AND test.RowLevelID=$RowLevel
    		ORDER BY test.ID DESC")->result();

		if (sizeof($ResultExam) > 0) {
			$ReturnExam     = $ResultExam;

			return $ReturnExam;

			return TRUE;
		} else {
			return $NumRowResultExam;
			return FALSE;
		}
	}


	public function get_exam_details($test_id)
	{

		$ResultExam = $this->db->query("SELECT test.Name as test_name,test.ID as Test_ID,questions_content.ID as Questions_ID,questions_types.Name,questions_types.ID AS questions_types_ID ,questions_content.Degree,questions_content.Question,questions_content.Q_attach,questions_content.ID AS questions_content_ID,GROUP_CONCAT( CONCAT_WS('-', answers.Answer , answers.Answer_correct) SEPARATOR ',')AS answers from test 
            INNER JOIN questions_content on questions_content.test_id =test.ID 
            INNER JOIN answers on questions_content.ID =answers.Questions_Content_ID 
            INNER JOIN questions_types on questions_types.ID =questions_content.questions_types_ID 
            where test.ID=$test_id
            group by questions_content.Question,questions_content.ID
            ORDER BY questions_content.ID ASC")->result_array();

		if (sizeof($ResultExam) > 0) {
			$ReturnExam     = $ResultExam;

			return $ReturnExam;

			return TRUE;
		} else {
			return $NumRowResultExam;
			return FALSE;
		}
	}

	public function get_exam_students($test_id)
	{

		$ResultExam = $this->db->query("SELECT test_student.* ,contact.Name as contactName,questions_content.questions_types_ID  ,test_student.answer_detail,(CASE
    WHEN test_student.answer_content IS NULL THEN GROUP_CONCAT( CONCAT_WS('-', ifnull(answers.Answer,0),ifnull(test_student.answer_content,0) , test_student.Degree ,test_student.questions_content_ID) SEPARATOR ',')
    ELSE GROUP_CONCAT( CONCAT_WS('-',ifnull(answers.Answer,0) ,ifnull(test_student.answer_content,0) ,test_student.Degree ,test_student.questions_content_ID) SEPARATOR ',')
END) AS answers,SUM(test_student.Degree) as stdegree  from  test_student
			left JOIN answers on  test_student.answer_content=answers.ID
			INNER JOIN questions_content on test_student.questions_content_ID=questions_content.ID
			INNER JOIN contact on test_student.Contact_ID =contact.ID
            where test_student.test_id=$test_id
            group by test_student.Contact_ID")->result_array();

		if (sizeof($ResultExam) > 0) {

			$ReturnExam     = $ResultExam;

			return $ReturnExam;

			return TRUE;
		} else {
			return $NumRowResultExam;
			return FALSE;
		}
	}
	public function get_row_level_school_active4($Lang = NULL, $levelID)
	{

		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		$query = $this->db->query("SELECT
		  class.ID  AS ClassID ,
		  class. " . $Name . " AS ClassName ,
		  level.Name  as LevelName,
		  row.Name as RowName,
		   level.ID       AS LevelID,
		   row.ID         AS RowID,
		    row_level.ID   As RowLevelID ,
		    concat(row_level.ID,'_',class.ID) as id
		  FROM class
		 
		   INNER JOIN class_table ON class.ID  = class_table.ClassID
		    INNER JOIN row_level ON class_table.RowLevelID  = row_level.ID
		  INNER JOIN row              ON row_level.Row_ID        = row.ID
		 INNER JOIN level            ON row_level.Level_ID      = level.ID
		  INNER JOIN school_class ON class.ID = school_class.ClassID AND school_class.SchoolID = '" . $this->session->userdata('SchoolID') . "'
		  where row_level.ID=" . $levelID . "
		  and class.Is_Active =1 
		  group by 
		   class.ID
		 ")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return  FALSE;
		}
	}

	public function get_students_new($class, $rowLavel)
	{
		$student = get_student_select_in();
		$query = $this->db->query("SELECT
									tb1.ID AS StudentID,
									tb1.Name AS FullName,
									tb1.studentBasicID
									FROM contact As tb1
									INNER JOIN student ON tb1.ID = student.Contact_ID
									WHERE tb1.SchoolID IN(" . $this->session->userdata('SchoolID') . ") 
									AND student.R_L_ID   = " . $rowLavel . " 
									AND student.Class_ID = " . $class . "
									AND tb1.Isactive     = 1
									AND tb1.Type         = 'S'
		                            group by tb1.ID
		   ");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	////////////////////////////////////
	public function get_class_per_type($Lang = NULL, $rowLavel)
	{
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		$query = $this->db->query("SELECT
		  class.ID  AS ClassID ,
		  class. " . $Name . " AS ClassName ,
		  row_level.Level_Name  AS LevelName ,
		  row_level.Row_Name   AS RowName ,
		  row_level.ID     As RowLevelID 
		  FROM class
		  INNER JOIN class_table on class_table.ClassID = class.ID
		  INNER JOIN row_level ON row_level.ID = class_table.RowLevelID
		  where class_table.SchoolID = '" . $this->session->userdata('SchoolID') . "'
		  AND class_table.EmpID = '" . $this->session->userdata('id') . "'
		  AND row_level.ID = '" . $rowLavel . "'
		  GROUP BY class_table.ClassID , row_level.ID
		   ");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}

	public function get_class_school_active_class_table($Lang = NULL, $rowLavel)
	{
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		$query = $this->db->query("
		  SELECT DISTINCT class.ID AS ClassID , class.Name AS ClassName , row_level.Level_Name AS LevelName,row_level.Row_Name AS RowName ,row_level.ID AS row_level_ID
          FROM class 
          INNER JOIN school_class ON class.ID = school_class.ClassID 
		  inner join class_level on class.ID=class_level.classID
		  INNER join row_level ON class_level.levelID=row_level.Level_ID
          INNER JOIN student on row_level.ID=student.R_L_ID AND student.Class_ID=class.ID
		  INNER JOIN contact on contact.ID = student.Contact_ID
		  WHERE class.Is_Active = 1
		  AND student.R_L_ID = $rowLavel 
		  AND school_class.SchoolID = '" . $this->session->userdata('SchoolID') . "'
		  AND contact.Isactive = 1
		  group by class.ID

		   ");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	////////////////////////////
	public function get_father($class_rowlevel_id)
	{
		//  print_r($class_rowlevel_id);die;
		$PerType = explode(',', $class_rowlevel_id);
		$rowlevel = $PerType[0];
		$class    = $PerType[1];

		//  $rowlevel_arr = [];
		//  $class_arr    = [];
		//         foreach ($PerType as $Key => $i) {              
		//             $arr = explode('/', $i);             
		//                 $rowlevel = $arr[0];
		//                 $class    = $arr[1];
		//                 array_push($class_arr, $class);
		//                 array_push($rowlevel_arr, $rowlevel);
		//         }
		//         $R_L_ID=implode(',',$rowlevel_arr);
		//       $Class_ID=implode(',',$class_arr);
		$query = $this->db->query("SELECT
									tb2.ID AS fatherID,
									tb2.Name AS FatherName,
									tb1.Name AS studentname,
									CASE WHEN LENGTH(tb2.Mobile) >= 9 THEN tb2.Mobile ELSE tb2.Phone END AS mobile_number
									FROM contact As tb1
									INNER JOIN student  ON tb1.ID = student.Contact_ID
									INNER JOIN contact as tb2 ON student.Father_ID = tb2.ID
									WHERE tb1.SchoolID IN(" . $this->session->userdata('SchoolID') . ") AND student.R_L_ID =" . $rowlevel . " AND student.Class_ID  =" . $class . "
									 AND (LENGTH(tb2.Phone) >= 9 OR LENGTH(tb2.Mobile) >= 9)
	                                 AND tb2.Isactive = 1
		  
		   ");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	//////////////////////////
	public function get_rowlevel($Data = array(), $Lang = NULL)
	{
		extract($Data);
		// print_r($Data);die;

		$query  = $this->db->query("SELECT DISTINCT ID , Level_Name,Row_Name FROM row_level WHERE IsActive = 1 AND Level_ID = " . $level . " ")->result();

		return $query;
	}
	//////////////////////////
	public function getclass($Data = array(), $Lang = NULL)
	{
		// print_r($row_level_id);die;
		extract($Data);
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		$query = $this->db->query("SELECT class.ID AS class_ID , class." . $Name . " AS class_Name,row_level.Level_Name AS Level_Name,row_level.Row_Name AS Row_Name
		                           FROM `class_level`
                                   INNER JOIN class ON class.ID = class_level.classID
                                   INNER JOIN row_level ON row_level.Level_ID = class_level.levelID
                                   WHERE row_level.ID =" . $RowLevel . " AND class.Is_Active =1 
                                   group by row_level.ID,class.ID
                                   ")->result();
		return $query;
	}
	/////////////////////////////////////////////
	public function get_RowLevel1($levelID)
	{

		$R_L_ID_array = get_rowlevel_select_in();
		$Name = 'Name';
		if ($this->session->userdata('language') == 'english') {
			$Name = 'Name_en';
		}
		$query = $this->db->query("
		 SELECT
		  row_level.Level_ID         AS LevelID ,
		 row_level.Row_ID           AS RowID ,
		 row_level.Level_Name       AS LevelName ,
		 row_level.Row_Name         AS RowName ,
		 row_level.ID               As RowLevelID 
		 FROM 
		 row_level
		 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID
		 INNER JOIN student          ON student.R_L_ID = row_level.ID
		 INNER JOIN contact          ON student.Contact_ID      = contact.ID   
		 AND contact.SchoolID = " . $this->session->userdata('SchoolID') . " AND contact.Isactive=1
		 INNER JOIN contact AS tb2 ON student.Father_ID     = tb2.ID
		 WHERE row_level.IsActive = 1  and row_level.Level_ID=" . $levelID . " AND contact.type='S'
		 AND row_level.ID IN ($R_L_ID_array) AND school_row_level.SchoolID IN(" . $this->session->userdata('SchoolID') . ")
		 GROUP BY row_level.ID
		");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	///////////////////////////////////////////////////////
	public function get_Class1($R_L_ID)
	{

		$Name = 'Name';
		if ($this->session->userdata('language') == 'english') {
			$Name = 'Name_en';
		}
		$query = $this->db->query("
		SELECT
		class.ID         AS ClassID ,
		 class." . $Name . "  AS ClassName ,row_level.Level_Name AS LevelName,row_level.Row_Name AS RowName,row_level.ID AS RowLevelID
		 FROM class
		 inner join class_level on class.ID=class_level.classID
		 INNER join row_level ON class_level.levelID=row_level.Level_ID
		 INNER JOIN student on row_level.ID = student.R_L_ID AND class.ID=student.Class_ID
		 INNER JOIN contact on student.Contact_ID=contact.ID
		 INNER JOIN contact AS tb2 ON student.Father_ID     = tb2.ID
		 WHERE class.Is_Active =1 AND row_level.ID=" . $R_L_ID . " AND contact.Isactive=1  AND contact.type='S'
		 and contact.SchoolID   IN(" . $this->session->userdata('SchoolID') . ") 
		 GROUP BY class.ID 
		");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	public function get_father_id()
	{

		$query  = $this->db->query("
		  SELECT 
		  contact.ID as fatherID,
		  contact.Name AS fatherName
		  FROM 
		  contact
		  inner join father on contact.ID=father.Contact_ID
		  WHERE contact.Isactive = 1  and contact.SchoolID   IN(" . $this->session->userdata('SchoolID') . ")
		  group by contact.ID
	  ");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	///////////////////
	public function delete_report_eval($Data)
	{
		extract($Data);
		$this->db->query(" DELETE FROM `emp_evaluation` WHERE `EmpID` = " . $ContactEmpID . " AND `ContactID` = " . $ContactID . "  AND `date` = '" . $Date . "' ");
		return true;
	}

	//////////////////
	public function add_certificate_photo($Data = array())
	{
		extract($Data);
		$check_data = $this->db->query("SELECT class_id FROM course_attend  where  class_id = '" . $Class . "'  ");
		if ($check_data->num_rows() > 0) {
			$this->db->query(" 
        update  course_attend
        SET
        row_level_id	         = '" . $level . "' ,
        class_id                 = '" . $Class . "' ,
        certificate_attach        = '" . $hidImg . "' 
         where row_level_id= '" . $level . "' 
         ");
			return true;
		} else {
			$this->db->query(" 
        INSERT INTO  course_attend
        SET
        row_level_id	         = '" . $level . "' ,
        class_id                 = '" . $Class . "' ,
        certificate_attach        = '" . $hidImg . "' 
        
         ");
			return true;
		}
	}
	public function delete_cource_attach($Data = array())
	{
		extract($Data);
		$this->db->query(" DELETE FROM `course_attend` WHERE `ID` = " . $course_attend_ID . "  ");
		return true;
	}
	public function certificate_report_attach($Data = array())
	{
		extract($Data);
		$query  = $this->db->query(" SELECT subject.certificate_attach1 ,  subject.certificate_attach FROM  subject  WHERE subject.ID = '" . $subject . "'  and subject.certificate_attach IS NOT NULL ");
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return FALSE;
		}
	}

	public function add_rowlevel($data)
	{
		extract($data);

		$this->db->query("INSERT INTO level SET   Name = '" . $rowlevel_name . "' ,
			   Name_en = '" . $rowlevel_nameEN . "'   ");

		$level_ID  = $this->db->insert_id();
		$this->db->query("INSERT INTO row_level SET Level_ID = '" . $level_ID . "' , Level_Name = '" . $rowlevel_name . "' ,
			  Level_Name_en = '" . $rowlevel_nameEN . "'  , Row_ID = 1 
			  ");
		$schoolrowlevel_ID  = $this->db->insert_id();
		$this->db->query("INSERT INTO school_row_level SET RowLevelID = '" . $schoolrowlevel_ID . "'  ,
			  SchoolID = '" . $school_id . "'   
			  ");
		$this->db->query("	INSERT INTO class_level(`classID`,`levelID`)
           SELECT ID ,$level_ID    FROM class ");
	}
	///////////////////////////////
	public function update_rowlevel($data)
	{
		extract($data);
		$this->db->query("UPDATE level SET   Name = '" . $rowlevel_name . "' ,
			   Name_en = '" . $rowlevel_nameEN . "' where ID = '" . $rowlevel_id . "'  ");

		//$level_ID  =$this->db->insert_id();
		$this->db->query("UPDATE row_level SET  Level_Name = '" . $rowlevel_name . "' ,
			  Level_Name_en = '" . $rowlevel_nameEN . "' , Row_ID = 1   where Level_ID = '" . $rowlevel_id . "'   
			  ");

		// 		 $schoolrowlevel_ID  =$this->db->insert_id();
		// 		 $this->db->query("UPDATE school_row_level SET RowLevelID = '".$schoolrowlevel_ID."'  ,
		// 			  SchoolID = '".$school_id."'  where RowLevelID = '".$schoolrowlevel_ID."'    
		// 			  " ) ;


	}
	public function delete_rowlevel($data)
	{
		extract($data);
		$this->db->query("delete from school_row_level  where RowLevelID = '" . $rowlevel_id . "'    
			  ");
		$this->db->query("delete from row_level   where ID = '" . $rowlevel_id . "'  
			  ");
		$this->db->query("delete from level where ID = '" . $level_id . "'  ");
	}


	public function add_class($data)
	{
		extract($data);
		$this->db->query("INSERT INTO class SET   Name = '" . $class_name . "' ,
			   Name_en = '" . $class_nameEN . "'   ");

		$class_ID  = $this->db->insert_id();
		$this->db->query("INSERT INTO school_class SET ClassID = '" . $class_ID . "' , SchoolID = '" . $school_id . "' 
			    
			  ");
	}
	///////////////////////////////
	public function update_class($data)
	{
		extract($data);
		$this->db->query("update  class SET   Name = '" . $class_name . "' ,
			   Name_en = '" . $class_nameEN . "' where class.ID = '" . $class_id . "' ");
	}

	/////////////////////
	public function delete_class($data)
	{
		extract($data);
		$this->db->query("delete from school_class  where ClassID = '" . $class_id . "'    
			  ");
		$this->db->query("delete from class   where ID = '" . $class_id . "'  
			  ");
	}

	///////////////////////////////////////////
	public function get_students_by_eval($data)
	{
		extract($data);
		$query = $this->db->query("SELECT
								    contact.ID             AS StudentID,
								    contact.Name           AS StudentName
								    FROM contact
								    INNER JOIN student     ON contact.ID    = student.Contact_ID
								    INNER JOIN class_table ON class_table.ClassID = student.Class_ID and class_table.RowLevelID= student.R_L_ID 
			                        INNER JOIN subject     ON class_table.SubjectID = subject.ID 
								    WHERE contact.SchoolID                 = '" . $this->session->userdata('SchoolID') . "'
								    AND contact.Isactive                   = 1
								    AND student.R_L_ID                     = $RowLevel
								    AND student.Class_ID                   = $Classgg
								   
								   
								    GROUP BY student.Contact_ID
							");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	////////////////////////////
	public function students_evaluation_items($Data)
	{
		extract($Data);

		if ($Lang == 'arabic') {
			$Name = Name_ar;
		} else {
			$Name = Name_en;
		}
		$query = $this->db->query("
			 SELECT `ID`," . $Name . " AS Name FROM `students_evaluation_items` WHERE `Type` = 1
			");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}


	/////////////////
	public function students_Behavior_report($data)
	{
		extract($data);
		// print_r($data);die;
		$student = get_student_select_in();
		if ($level == 0) {
			$level1 = "NULL";
		} else {
			$level1 = $level;
		}
		if ($RowLevel == 0) {
			$RowLevel1 = "NULL";
		} else {
			$RowLevel1 = $RowLevel;
		}
		if ($Classgg == 0) {
			$Class1 = "NULL";
		} else {
			$Class1 = $Classgg;
		}
		if ($subject == 0) {
			$subjectID = "NULL";
		} else {
			$subjectID = $subject;
		}
		$getReport = $this->db->query("SELECT students_behavior.*, contact.Name AS StudentName , row_level.Level_Name,
        	                           row_level.Row_Name,class.Name as ClassName,emp.Name AS TeacherName,subject.Name AS SubjectName,
                                       lesson_prep.Lesson_Title , skills.name AS SkillName 
        	                           FROM `students_behavior` 
        	                           INNER JOIN student ON student.Contact_ID = students_behavior.StudentID 
        	                           INNER JOIN contact ON contact.ID = student.Contact_ID 
        	                           INNER JOIN contact AS emp ON emp.ID = students_behavior.TeacherID
        	                           INNER JOIN row_level ON row_level.ID = student.R_L_ID
        	                           INNER JOIN class ON class.ID = student.Class_ID
        	                           LEFT JOIN skills ON skills.ID = students_behavior.SkillsID
                                       LEFT JOIN lesson_prep ON lesson_prep.ID = students_behavior.lesson_prepID
                                       LEFT JOIN subject ON subject.ID  = students_behavior.SubjectID
        	                           WHERE contact.Isactive = 1 
                                	
                                    	AND  row_level.Level_ID = IFNULL($level1,row_level.Level_ID)
                                		AND	 row_level.ID = IFNULL($RowLevel1,row_level.ID)
                                		AND  class.ID = IFNULL($Class1,class.ID)
                                		AND  contact.SchoolID = " . $this->session->userdata('SchoolID') . "
                                			AND
		                                 subject.ID = IFNULL($subjectID,subject.ID)
                                		AND  contact.ID IN(" . $student . ")
                                		
                                		ORDER BY students_behavior.ID
		 ")->result();

		if (sizeof($getReport) > 0) {
			return $getReport;
		} else {
			return FALSE;
		}
	}
	/////////////////////////
	public function get_subject_data($Data = array(), $Lang = NULL)
	{
		extract($Data);
		// print_r($Data);die;

		$query  = $this->db->query("SELECT * FROM  subject  WHERE  subject.ID = " . $subject . " ")->row_array();

		return $query;
	}


	/////////////////////////
	public function get_all_Stu_Data($data = array())
	{
		extract($data);

		$query = $this->db->query("
			 SELECT students_evaluation.* , contact.Name AS StudentName
			 FROM `students_evaluation` 
			 INNER JOIN contact        ON contact.ID = students_evaluation.StudentID
             INNER JOIN student        ON students_evaluation.StudentID = student.Contact_ID
             INNER JOIN class_table    ON students_evaluation.ClassTableID = class_table.ID AND class_table.RowLevelID = student.R_L_ID AND class_table.ClassID = student.Class_ID
			 WHERE `ClassTableID`= '" . $ClassTableID . "' 
			 and    students_evaluation.`Date`       = '" . $Eval_date . "' 
			")->result();

		return $query;
	}

	////////////////////
	public function students_eval_absence_report2($Data)
	{

		extract($Data);

		if ($level == 0) {
			$levelID = "NULL";
		} else {
			$levelID = $level;
		}

		if ($RowLevel == 0) {
			$RowLevelID = "NULL";
		} else {
			$RowLevelID = $RowLevel;
		}

		if ($Classgg == 0) {
			$ClassID = "NULL";
		} else {
			$ClassID = $Classgg;
		}

		if ($subject == 0) {
			$subjectID = "NULL";
		} else {
			$subjectID = $subject;
		}
		if ($attend == 0) {
			$attendID = "NULL";
		} else {
			$attendID = $attend;
		}

		if ($DateFrom == 0) {
			$Date_From = "0000-00-00";
		} else {
			$Date_From = "'$DateFrom'";
		}

		if ($DateTo == 0) {
			$Date_To = "CURDATE()";
		} else {
			$Date_To = "'$DateTo'";
		}

		if ($attend == 0) {

			$where = "AND students_evaluation.Absence_class IN(1,2)";
		} else {

			$where = "AND students_evaluation.Absence_class = IFNULL($attend,students_evaluation.Absence_class)";
		}

		$getReport = $this->db->query("
		SELECT
		students_evaluation.*,
		students_evaluation.Date AS Date,
		row_level.Level_ID   AS LevelID,
		row_level.Level_Name AS LevelName,
		row_level.Row_ID     AS RowID,
		row_level.Row_Name   AS RowName,
		row_level.ID         As RowLevelID ,
		class.ID             As ClassID ,
		class.Name           AS ClassName,
		tb1.ID               AS StudentID,
		tb1.Name             AS StudentName,
		tb3.Name             AS TeacherName ,
		lesson.lesson        AS LessonName,
		subject.Name         AS subjectName,
		class_table.start_time, 
		class_table.end_time 
		FROM contact As tb1
		INNER JOIN student 				ON tb1.ID = student.Contact_ID
		INNER JOIN class 				ON student.Class_ID = class.ID
		INNER JOIN row_level 			ON student.R_L_ID = row_level.ID
		INNER JOIN students_evaluation 	ON students_evaluation.StudentID = tb1.ID
		INNER JOIN class_table          ON class_table.ID = students_evaluation.ClassTableID
		INNER JOIN subject              ON subject.ID     = class_table.SubjectID
		INNER JOIN lesson               ON lesson.ID      = class_table.Lesson
		INNER JOIN contact AS tb3 		ON tb3.ID         = class_table.EmpID
		where students_evaluation.Date >= IFNULL($Date_From, students_evaluation.Date)
	     AND
	    students_evaluation.Date <= IFNULL($Date_To, students_evaluation.Date)
    	AND
		row_level.Level_ID = IFNULL($levelID,row_level.Level_ID)
		AND
		row_level.ID = IFNULL($RowLevelID,row_level.ID)
		AND
		class.ID = IFNULL($ClassID,class.ID)
		AND
		subject.ID = IFNULL($subjectID,subject.ID)
		AND tb1.SchoolID    = '" . $this->session->userdata('SchoolID') . "'
       	AND `ClassTableID` IS NOT NULL
       	$where
		ORDER BY  students_evaluation.Date
		 ")->result();

		if (sizeof($getReport) > 0) {
			return $getReport;
		} else {
			return FALSE;
		}
	}

		//////////////////////////////////
		public function show_father_aceept($Data=array() )
	{
		extract($Data);
		if($level == 0 )   {$level= 'NULL' ; }
		if($RowLevel == 0 ){$RowLevel = 'NULL' ; }
		if($ClassID == 0 )   {$ClassID = 'NULL' ; }
		if($Type == 'F'){$groupby = 'tb2.ID';}else{$groupby = 'tb1.ID';}
		$NameArray = array("Level"=>"Name AS LevelName" ,"row"=>"Name AS RowName" , "class"=>"Name AS ClassName");
		if($Lang == "english")
		{
			$NameArray = array("Level"=>"Name_en AS LevelName" ,"row"=>" Name_en AS RowName" , "class"=>"Name_en AS ClassName");
		}
		$query = $this->db->query("
			 SELECT DISTINCT
			 tb2.Name  AS FatherName ,
			 tb2.ID  FatherID
			
			 FROM contact As tb1
			 INNER JOIN student          ON tb1.ID = student.Contact_ID
			 INNER JOIN contact AS tb2   ON student.Father_ID     = tb2.ID
			 INNER JOIN class            ON student.Class_ID    = class.ID
			 INNER JOIN row_level        ON student.R_L_ID      = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID    = row.ID
			 INNER JOIN level            ON row_level.Level_ID  = level.ID
			 WHERE tb1.SchoolID = '".$this->session->userdata('SchoolID')."'
			 AND  
			 level.ID      = IFNULL($level,level.ID)
			 AND 
			 row_level.ID  = IFNULL($RowLevel,row_level.ID)
			 AND 
			 class.ID      = IFNULL($ClassID,class.ID)
			 AND tb2.agree_condition = 1
			 GROUP BY $groupby
			");
			if($query->num_rows()>0)
			{
			   return $query->result();	
			}else{return false ;}
	}
	//////////////////////////////////
	public function get_update_report()
	{
		$query = $this->db->query("
			SELECT log_update.*, school_details.SchoolName AS school_goal
			FROM log_update 
			LEFT JOIN school_details on log_update.goal = school_details.ID
			GROUP BY `updateTime`
			ORDER BY log_update.ID DESC
			");
			if($query->num_rows()>0)
			{
			   return $query->result();	
			}else{return false ;}
	}
}//////END CLASS 