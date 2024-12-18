<?php
class Report_Emp_Model extends CI_Model 
 {
	private $Date       = '' ;
	private $Encryptkey = '' ;
	private $Token      = '' ;
	
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
	/////////////report_plan_week
	public function report_plan_week($EmpID = 0)
	{
		$getReport = $this->db->query("
		SELECT 
		plan_week.ID 
		FROM plan_week 
		INNER JOIN class_table ON plan_week.ClassTableID = class_table.ID 
		WHERE class_table.EmpID = ".$EmpID." AND plan_week.Content != '' GROUP BY plan_week.WeekID
		 ");
		 return (int)$getReport->num_rows();
	}
	/////////////report_e_library
	public function report_e_library($EmpID = 0)
	{
		$getReport = $this->db->query("
		SELECT 
		COUNT(ID) AS Count_library 
		FROM e_library 
		WHERE ContactID = ".$EmpID."
		 ");
		 $GetNumCount = $getReport->row_array();
		 return (int)$GetNumCount['Count_library'];
	}
	/////////////report_test_exam
	public function report_test_exam($EmpID = 0)
	{
		$getReport = $this->db->query("
		SELECT 
		test.ID AS TestID
		FROM test 
		INNER JOIN config_emp ON test.Subject_emp_ID = config_emp.ID
		WHERE config_emp.EmpID = ".$EmpID." AND test.type = 0 
		 ");
		  return (int)$getReport->num_rows();
	}
	/////////////report_home_work
	public function report_home_work($EmpID = 0)
	{
		$getReport = $this->db->query("
		SELECT 
		test.ID AS TestID
		FROM test 
		INNER JOIN config_emp ON test.Subject_emp_ID = config_emp.ID
		WHERE config_emp.EmpID = ".$EmpID." AND test.type != 0 
		 ");
		  return (int)$getReport->num_rows();
	}
	/////////////report_last_login
	public function report_last_login($EmpID = 0)
	{
		$getReport = $this->db->query("
		SELECT 
		LastLogin
		FROM contact 
		WHERE ID = ".$EmpID."  
		 ");
		 if($getReport->num_rows()>0)
		 {
			 $GetLastLogin = $getReport->row_array();
			 return $GetLastLogin['LastLogin'];
		 }else{return FALSE ;}
	}/////////////report_last_login
	public function report_student_eval($EmpID = 0)
	{
		$getReport = $this->db->query("
		SELECT 
		ID
		FROM students_evaluation 
		WHERE TeacherID = ".$EmpID."   GROUP BY Date_stm
		 ");
		 return (int)$getReport->num_rows();
	}/////////////report_last_login
	public function report_emp_prep($EmpID = 0)
	{
		$getReport = $this->db->query("
		SELECT 
		ID
		FROM lesson_prep 
		WHERE Teacher_ID = ".$EmpID."  
		 ");
		return (int)$getReport->num_rows();
	}//////////////////clerical_homework
	public function report_clerical_homework($EmpID = 0)
	{
		$getReport = $this->db->query("
		SELECT 
		clerical_homework.ID
		FROM clerical_homework 
		INNER JOIN config_emp ON clerical_homework.subjectEmpID = config_emp.ID
		WHERE config_emp.EmpID = ".$EmpID."  
		 ");
		return (int)$getReport->num_rows();
	}//////get_emp
	public function get_emp($Lang = NULL)
	{
		$NameArray   = array("Name"=>"Name AS LevelName");if($Lang == "english"){array("Name"=>"Name_en AS LevelName");}
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
		");
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			   return FALSE ;
			 }
	}/////////////////////////////get_class_table_row
	public function get_class_table_row($ID = 0,$Lang = NULL)
	{
		$NameArray = array("Day"=>"Name AS DayName","Lesson"=>"lesson As LessonName " ,"Level"=>"Name AS LevelName" ,
		"row"=>"Name AS RowName" , "class"=>"Name AS ClassName");
		if($Lang == "english")
		{
			$NameArray = array("Day"=>"Name_en AS DayName","Lesson"=>"Lesson_en As LessonName " ,"Level"=>"Name_en AS LevelName" ,
		    "row"=>" Name_en AS RowName" , "class"=>"Name_en AS ClassName");
		}
		$query = $this->db->query("
			 SELECT 
			 class_table.ID AS ClassTableID ,
			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
			 level.".$NameArray['Level'].",
			 row.".$NameArray['row'].",
			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
			 class.".$NameArray['class']." ,
			 subject.Name   AS SubjectName ,
			 lesson.".$NameArray['Lesson']." ,
			 day.".$NameArray['Day']."
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
			 class_table.EmpID = ".$ID."
			 GROUP BY level.ID
			");
			if($query->num_rows()>0)
			{
			   return $query->result();	
			}else{return false ;}
			
	}/////////////////////////////get_class_table_row
	public function get_student($Lang = NULL)
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
			 tb1.ID AS StudentID,
			 tb1.User_Name AS StudentUserName,
			 tb1.Name AS StudentName,
			 tb2.ID AS FatherID ,
			 tb2.User_Name AS FatherUserName,
		     tb2.Name AS FatherName ,
			 CONCAT(tb1.Name,' ',tb2.Name) AS FullName
			 FROM contact As tb1
			 INNER JOIN student ON tb1.ID = student.Contact_ID
			 INNER JOIN contact AS tb2 ON student.Father_ID     = tb2.ID
			 INNER JOIN class            ON student.Class_ID    = class.ID
			 INNER JOIN row_level        ON student.R_L_ID      = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID    = row.ID
			 INNER JOIN level            ON row_level.Level_ID  = level.ID
			 
			");
			if($query->num_rows()>0)
			{
			   return $query->result();	
			}else{return false ;}
			
	}
	

 }//////END CLASS 
?>