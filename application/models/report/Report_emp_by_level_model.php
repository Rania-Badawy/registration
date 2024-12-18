<?php
class Report_Emp_By_Level_Model extends CI_Model 
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
	public function report_plan_week($EmpID = 0 , $DayDateFrom = 'NULL' , $DayDateTo = 'NULL' ,$rowLavel, $classID)
	{
	    
		$dataWhere = '';
		$rowLavelWhere = '';
		if($DayDateFrom  !== 'NULL' && $DayDateTo  !== 'NULL'  ){ $dataWhere = "AND (DATE(plan_week.Date_Stm)  BETWEEN CAST('".$DayDateFrom."' AS DATE ) AND CAST('".$DayDateTo."' AS DATE  )) ";	}
		if($rowLavel != 0 ){ $rowLavelWhere = 'AND class_table.RowLevelID = "'.$rowLavel.'" '; }
		
			$getReport = $this->db->query("
			SELECT 
			plan_week.ID 
			FROM plan_week 
			INNER JOIN class_table ON plan_week.ClassTableID = class_table.ID 
			WHERE class_table.EmpID = ".$EmpID."
			".$dataWhere." ".$rowLavelWhere." 
		    GROUP BY SemesterID , WeekID
		 ");
		
		// print_r($this->db->last_query());exit();
		 return (int)$getReport->num_rows();
	}
/////////////report_weekly_plan
	public function report_weekly_plan( $Lang = 'arabic' , $EmpID = 0 , $DayDateFrom = 'NULL' , $DayDateTo = 'NULL'  )
	{
		   $Name = 'Name';
		if($Lang == 'english'){$Name = 'Name_en' ;}
		if($DayDateFrom  == 'NULL' && $DayDateTo  == 'NULL'  )
		{
			$getReport = $this->db->query("
			SELECT 
			plan_week.ID AS PlanWeek ,
			level.".$Name." AS LevelName ,
			row.".$Name."   AS RowName ,
			class.".$Name." AS ClassName ,
			week.".$Name." AS WeekName , 
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
			WHERE class_table.EmpID = ".$EmpID." AND  TRIM(plan_week.Content) <> '' GROUP BY plan_week.SemesterID , plan_week.WeekID
		 ");
		}else
		{
			$getReport = $this->db->query("
			SELECT 
			plan_week.ID AS PlanWeek ,
			level.".$Name." AS LevelName ,
			row.".$Name."   AS RowName ,
			class.".$Name." AS ClassName ,
			week.".$Name." AS WeekName , 
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
			WHERE class_table.EmpID = ".$EmpID." AND  TRIM(plan_week.Content) <> '' 
			AND 
			(DATE(plan_week.Date_Stm)	 BETWEEN CAST('".$DayDateFrom."' AS DATE ) AND CAST('".$DayDateTo."' AS DATE  )) 
		    GROUP BY plan_week.SemesterID , plan_week.WeekID
		 ");
		}
		 return $getReport->result();
	}

/////////////////////////////////////////////////////////////////////////// Emp E Lib
	public function report_e_library($EmpID = 0 ,  $DayDateFrom = 'NULL' , $DayDateTo = 'NULL' )
	{
		if($DayDateFrom  == 'NULL' && $DayDateTo  == 'NULL'  )
		{
		$getReport = $this->db->query("
		SELECT 
		COUNT(ID) AS Count_library 
		FROM e_library 
		WHERE ContactID = ".$EmpID." AND File_url<>''
		 ");
		}else{
			
			$getReport = $this->db->query("
			SELECT 
			COUNT(ID) AS Count_library 
			FROM e_library 
			WHERE ContactID = ".$EmpID." AND File_url<>''
			AND 
			(DATE(Stm_Date) BETWEEN CAST('".$DayDateFrom."' AS DATE ) AND CAST('".$DayDateTo."' AS DATE  )) 
		 ");
			}
		 $GetNumCount = $getReport->row_array();
		 return (int)$GetNumCount['Count_library'];
	}
	
	public function report_emp_elib($EmpID = 0 , $DayDateFrom = NULL ,  $DayDateTo = NULL  )
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
	   WHERE e_library.ContactID = '".$EmpID."'
	   AND 
	  (DATE(e_library.Stm_Date)	 BETWEEN CAST('".$DayDateFrom."' AS DATE ) AND CAST('".$DayDateTo."' AS DATE  ))
		")->result();
		if(sizeof($query) >0)
		  {
			return $query ; 
		  }else{ return FALSE ;}
	}
	
	////get_semester Name
	public function get_semester($Lang , $SemesterID)
	{
		if($Lang == 'arabic')
		{
		  $this->db->select('Name AS Name');
		  $this->db->from('config_semester');
		  $this->db->where('ID', $SemesterID );
		}else
		{
		  $this->db->select('Name_en AS Name');
		  $this->db->from('config_semester');
		  $this->db->where('ID', $SemesterID );
		}
	  $ResultSemeName 	= $this->db->get();
	  $ReturnSemeName	= $ResultSemeName->row_array() ;
	  return $ReturnSemeName ;	
	}
///////////////////////////////////////////////////////////////////////////	


	/////////////report_test_exam
	public function report_test_exam($EmpID = 0 ,  $DayDateFrom = 'NULL' , $DayDateTo = 'NULL' )
	{
		 if($DayDateFrom  == 'NULL' && $DayDateTo  == 'NULL'  )
		{
		$getReport = $this->db->query("
		SELECT 
		test.ID AS TestID
		FROM test 
		INNER JOIN config_emp ON test.Subject_emp_ID = config_emp.ID
		WHERE config_emp.EmpID = ".$EmpID." AND test.type = 0 
		 ");
		 }else{
				$getReport = $this->db->query("
				SELECT 
				test.ID AS TestID
				FROM test 
				INNER JOIN config_emp ON test.Subject_emp_ID = config_emp.ID
				WHERE config_emp.EmpID = ".$EmpID." AND test.type = 0 
				AND 
			(DATE(Date_Stm)	 BETWEEN CAST('".$DayDateFrom."' AS DATE ) AND CAST('".$DayDateTo."' AS DATE  ))
			 ");
			}
		  return (int)$getReport->num_rows();
	}
	/////////////report_home_work
	public function report_home_work($EmpID = 0,  $DayDateFrom = 'NULL' , $DayDateTo = 'NULL')
	{
		
        if($DayDateFrom  == 'NULL' && $DayDateTo  == 'NULL'  )
		{

			$getReport = $this->db->query("
			SELECT 
			test.ID AS TestID
			FROM test 
			INNER JOIN config_emp ON test.Subject_emp_ID = config_emp.ID
			WHERE config_emp.EmpID = ".$EmpID." AND test.type = 1 
		 ");
		}else{
				$getReport = $this->db->query("
				SELECT 
				test.ID AS TestID
				FROM test 
				INNER JOIN config_emp ON test.Subject_emp_ID = config_emp.ID
				WHERE config_emp.EmpID = ".$EmpID." AND test.type = 1 
				AND 
			(DATE(Date_Stm)	 BETWEEN CAST('".$DayDateFrom."' AS DATE ) AND CAST('".$DayDateTo."' AS DATE  ))
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
		WHERE ID = ".$EmpID."  
		 ");
		 if($getReport->num_rows()>0)
		 {
			 $GetLastLogin = $getReport->row_array();
			 return $GetLastLogin['LastLogin'];
		 }else{return FALSE ;}
	}

///////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////// Emp Students Eval
	public function report_student_eval_num($EmpID = 0 ,  $DayDateFrom = 'NULL' , $DayDateTo = 'NULL')
	{
		
       if($DayDateFrom  == 'NULL' && $DayDateFrom  == 'NULL'  )
		{
		$getReport = $this->db->query("
		SELECT 
		students_evaluation.ID
		FROM 
		students_evaluation
		INNER JOIN student ON students_evaluation.StudentID = student.Contact_ID
		WHERE students_evaluation.TeacherID = ".$EmpID."  GROUP BY student.R_L_ID , student.Class_ID ,  students_evaluation.Date_stm
		 ");
		}
		else{
			   $getReport = $this->db->query("
			   SELECT 
				students_evaluation.ID
				FROM 
				students_evaluation
				INNER JOIN student ON students_evaluation.StudentID = student.Contact_ID
				WHERE students_evaluation.TeacherID = ".$EmpID."  
				AND 
			   (DATE(students_evaluation.Date)	 BETWEEN CAST('".$DayDateFrom."' AS DATE ) AND CAST('".$DayDateTo."' AS DATE  )) 
		       GROUP BY student.R_L_ID , student.Class_ID ,  students_evaluation.Date_stm
		 ");
			}
	
			
		 return (int)$getReport->num_rows();
	}
	
	public function report_student_eval($EmpID = 0)
	{
		$Lang = $this->session->userdata('language');
		
		$NameArray = array("Level"=>"Name AS LevelName" ,"row"=>"Name AS RowName" , "class"=>"Name AS ClassName");
		if($Lang == "english")
		{
			$NameArray = array("Level"=>"Name_en AS LevelName" ,"row"=>" Name_en AS RowName" , "class"=>"Name_en AS ClassName");
		}
		$query = $this->db->query("
		SELECT
			level.ID AS LevelID,
			row.ID AS RowID,
			class.ID AS ClassID,
			level.".$NameArray['Level'].",
			row.".$NameArray['row'].",
			row_level.ID As RowLevelID ,
			class.ID As ClassID ,
			class.".$NameArray['class']." ,
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
		WHERE students_evaluation.TeacherID = ".$EmpID." 
		AND tb1.Isactive = 1 
		AND tb2.Isactive = 1 
		GROUP BY students_evaluation.StudentID
		");
		
		$NumData = $query->num_rows() ; 
		if($NumData >0)
		  {
			$ReturnData    = $query->result() ;
			return $ReturnData ; 
		  }else{ return $NumData ; }
	}
	
	public function get_EvalNum($StudentID = 0 , $TeacherID = 0)
	{
		$this->db->select('*');
		$this->db->from('students_evaluation');
		$this->db->where('StudentID' , $StudentID);
		$this->db->where('TeacherID' , $TeacherID );
		$ResultData = $this->db->get();
		$NumRowResultData  = $ResultData->num_rows() ; 
		return $NumRowResultData ;
	}
	
	public function get_student_eval($StudentID = 0 , $TeacherID = 0)
	{
		$Lang = $this->session->userdata('language');
		$NameArray = array("Level"=>"Name AS LevelName" ,"row"=>"Name AS RowName" , "class"=>"Name AS ClassName", "lesson"=>"lesson AS lessonName" );
		if($Lang == "english")
		{
			$NameArray = array("Level"=>"Name_en AS LevelName" ,"row"=>" Name_en AS RowName" , "class"=>"Name_en AS ClassName", "lesson"=>"Lesson_en AS lessonName" );
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
			students_evaluation.StudentID AS StudentContactID, 
			students_evaluation.TeacherID, students_evaluation.SubjectID, students_evaluation.Lesson, 
			students_evaluation.Date AS EvalDate, students_evaluation.PositiveID AS EvalPositiveID, students_evaluation.NoteID AS EvalNoteID ,
			subject.Name AS subjectName ,
			tb3.Name AS TeacherName 
			
		FROM contact As tb1
		INNER JOIN student 				ON tb1.ID = student.Contact_ID
		INNER JOIN contact AS tb2 		ON student.Father_ID = tb2.ID
		INNER JOIN students_evaluation 	ON students_evaluation.StudentID = tb1.ID
		INNER JOIN contact AS tb3 		ON tb3.ID = students_evaluation.TeacherID
		INNER JOIN subject		 		ON subject.ID = students_evaluation.SubjectID
		WHERE students_evaluation.StudentID = '".$StudentID."'
		AND students_evaluation.TeacherID = '".$TeacherID."'
		AND tb1.Isactive = 1 
		AND tb2.Isactive = 1 
		");
			if($query->num_rows()>0)
			{
				return $query->result();
			}else{return false ;}
	}

//////////////////////////////////////////////////////////////////////////// Emp Lesson Prep
	
	public function report_emp_prep_num($EmpID = 0 ,  $DayDateFrom = 'NULL' , $DayDateTo = 'NULL' )
	{
		
       if($DayDateFrom  == 'NULL' && $DayDateTo  == 'NULL'  )
		{

		$getReport = $this->db->query("
		SELECT 
		ID
		FROM lesson_prep 
		WHERE Teacher_ID = ".$EmpID."
		GROUP BY  RowLevel_ID , Subject_ID
		 ");
		}else{
			$getReport = $this->db->query("
			SELECT 
			ID
			FROM lesson_prep 
			WHERE Teacher_ID = ".$EmpID."
			AND 
			(DATE(Date) BETWEEN CAST('".$DayDateFrom."' AS DATE ) AND CAST('".$DayDateTo."' AS DATE  ))
			GROUP BY  RowLevel_ID , Subject_ID
			
		 ");
			}
		return (int)$getReport->num_rows();
	}

	public function lesson_prep_check_count($SubjectID = 0,$RowLevelID = 0 , $TeacherID = 0)
	{
		$WhereArray     = array('RowLevel_ID'=>$RowLevelID,'Subject_ID'=>$SubjectID,'Teacher_ID'=>$TeacherID);
		
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
		$RowLevelID 	= $data['RowLevelID'] ;
		$SubjectID 		= $data['SubjectID'] ;
		$TeacherID  	= $data['TeacherID'] ;
		
		$this->db->select('ID AS LessonID, Lesson_Title AS LessonTitle ,Date AS LessonDate , Token AS LessonToken');
		$this->db->from('lesson_prep');
		$this->db->where('RowLevel_ID', $RowLevelID );
		$this->db->where('Subject_ID', $SubjectID );
		$this->db->where('Teacher_ID', $TeacherID );	
		$ResultLessons = $this->db->get();			
		$NumRowResultLessons  = $ResultLessons->num_rows() ; 
		if($NumRowResultLessons != 0)
		  {
				$ReturnLessons = $ResultLessons ->result() ;
				return $ReturnLessons ;
		  }
		  else
		  {
			  return false ;
		  }
	}
	
	public function get_lesson_details($LessonToken = 0)
	{
	 	$this->db->select('');
		$this->db->from('lesson_prep');
		$this->db->where('Token', $LessonToken );
		$this->db->limit(1);
		$ResultLessonDetails = $this->db->get();			
		$NumRowResultLessonDetails  = $ResultLessonDetails->num_rows() ; 
		if($NumRowResultLessonDetails != 0)
		  {
				return $ResultLessonDetails->row_array() ;
		  }
		  else
		  {
			  return false ;
		  }
	}

	public function get_RowLevel_Name ($RowLevel_ID)
	{	
		$this->db->select('level.Name AS LevelName , row.Name AS RowName');
		$this->db->from('row_level');
		$this->db->join('level', 'level.ID = row_level.Level_ID');
		$this->db->join('row', 'row.ID = row_level.Row_ID');
		$this->db->where('row_level.ID', $RowLevel_ID );
		
		$ResultRowLevelName = $this->db->get();			
		$NumRowResultRowLevelName  = $ResultRowLevelName->num_rows() ; 
		if($NumRowResultRowLevelName != 0)
		  {
				$ReturnRowLevelName = $ResultRowLevelName ->row_array() ;
				return $ReturnRowLevelName ;
		  }
		  else
		  {
			  return false ;
		  }
	}

	public function get_Teacher_Name ($TeacherID)
	{	
		$this->db->select('Name');
		$this->db->from('contact');
		$this->db->where('ID', $TeacherID );
		$ResultTeacher = $this->db->get();			
		$NumRowResultTeacher  = $ResultTeacher->num_rows() ; 
		if($NumRowResultTeacher != 0)
		  {
				$ReturnTeacher = $ResultTeacher ->row_array() ;
				return $ReturnTeacher ;
		  }
		  else
		  {
			  return false ;
		  }
	}

	public function get_Subject_Name ($SubjectID)
	{	
		$this->db->select('Name');
		$this->db->from('subject');
		$this->db->where('ID', $SubjectID);
		$ResultSubject = $this->db->get();			
		$NumRowResultSubject  = $ResultSubject->num_rows() ; 
		if($NumRowResultSubject != 0)
		  {
				$ReturnSubject = $ResultSubject ->row_array() ;
				return $ReturnSubject ;
		  }
		  else
		  {
			  return false ;
		  }
	}




///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////

	//////////////////clerical_homework
	public function report_clerical_homework($EmpID = 0 ,  $DayDateFrom = 'NULL' , $DayDateTo = 'NULL')
	{
		if($DayDateFrom  == 'NULL' && $DayDateTo  == 'NULL'  )
		{
		$getReport = $this->db->query("
		SELECT 
		clerical_homework.ID
		FROM clerical_homework 
		INNER JOIN config_emp ON clerical_homework.subjectEmpID = config_emp.ID
		WHERE config_emp.EmpID = ".$EmpID."  
		 ");
		}else{
			$getReport = $this->db->query("
			SELECT 
			clerical_homework.ID
			FROM clerical_homework 
			INNER JOIN config_emp ON clerical_homework.subjectEmpID = config_emp.ID
			WHERE config_emp.EmpID = ".$EmpID."  
			AND 
			(DATE(clerical_homework.Date)	 BETWEEN CAST('".$DayDateFrom."' AS DATE ) AND CAST('".$DayDateTo."' AS DATE  ))
			 ");
			 }
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
	public function emp_not_in_classtable(){
	    $query = $this->db->query('
	    select contact.Name , school_details.SchoolName 
        FROM contact
        INNER JOIN school_details on school_details.ID = contact.SchoolID
        INNER join employee on employee.Contact_ID = contact.ID
        where employee.jobTitleID = 0 and contact.Type = "E" and  school_details.ID = "'.$this->session->userdata('SchoolID').'" and
        contact.ID NOT in (SELECT class_table.ConID FROM class_table GROUP BY class_table.EmpID )
        ');
	    return $query->result();
	}
	//////get_emp_with_in
	public function get_all_emp($Lang = NULL , $lavelID , $RowLevelID , $classID , $subjectID , $dateFrom  , $dateTo )
	{

 
	    if($lavelID != 'NULL'){ $lavelClass = " and row_level.ID in (select row_level.ID from row_level where row_level.Level_ID = ".$lavelID." group by  row_level.ID  )"; }
	    $GetData = $this->db->query(" call usp_EMPRPT(".$lavelID.",".$RowLevelID.",".$this->session->userdata('SchoolID').",".$classID.",".$subjectID.",".$dateFrom.",NULL)");
	   //print_r($this->db->last_query());exit();
	    /*if($this->session->userdata('SchoolID') != 	43 ){
            print_r($this->db->last_query());exit();
        }*/
	    /*
	    $lavelWhere = '';
	    $RowLevelIDWhere = '';
	    $RowLevelIDPlanWhere = '';
	    $classIDWhere = '';
	    $classIDPlanWhere = '';
	    $subjectIDWhere = '';
	    $subjectIDPlanWhere = '';
	    $tast = 'NULL';
	    if($lavelID != 'NULL' ){ $lavelWhere = "AND row_level.Level_ID = ".$lavelID." ";  }
	    if($RowLevelID != 0 ){ $RowLevelIDWhere = "AND row_level.ID = ".$RowLevelID." "; $RowLevelIDPlanWhere = "AND rowLavelPlan.ID = ".$RowLevelID." "; }
	    if($classID != 0 ){ $classIDWhere = "AND class_table.ClassID = ".$classID." "; $classIDPlanWhere = "AND class_table1.ClassID = ".$classID." "; }
	    if($subjectID != 0 ){ $subjectIDWhere = "AND class_table.SubjectID = ".$subjectID." "; $subjectIDPlanWhere = "AND class_table1.SubjectID = ".$subjectID." "; }
	    if($dateFrom != 0 ){ $dateFromWhere = "and ( plan1.Date_Stm BETWEEN cast('".$dateFrom."' as DATE )  and  cast('".$dateTo."' as DATE ) )"; }
	    
	    	$GetData = $this->db->query("
	    	    SELECT contact.Name as nameUser , DATE(plan_week.Date_Stm) , GROUP_CONCAT(DISTINCT  row_level.Level_Name) as allLavelName ,GROUP_CONCAT(DISTINCT  subject.Name) as allSubjectName , 
                (
                    select count(plan1.ID) 
                    from class_table as class_table1 
                    inner join plan_week as plan1 on class_table1.ID = plan1.ClassTableID
                    inner join row_level as rowLavelPlan on class_table1.RowLevelID = rowLavelPlan.ID
                    where class_table1.EmpID = contact.ID  ".$dateFromWhere." AND rowLavelPlan.Level_ID = (case WHEN ".$lavelID." IS NULL THEN rowLavelPlan.Level_ID ELSE ".$lavelID." END )   ".$RowLevelIDPlanWhere." ".$classIDPlanWhere." ".$subjectIDPlanWhere."
                ) as countPlan1 ,
                (
                    select count(e_library.ID) from e_library 
                    inner join row_level as rowLavelLibrary on rowLavelLibrary.ID = e_library.RowLevelID
                    where e_library.ContactID = contact.ID AND rowLavelLibrary.Level_ID = (case WHEN ".$tast." IS NULL THEN rowLavelLibrary.Level_ID ELSE 4 END )
                ) as countLib
                from class_table
                inner join contact on contact.ID = class_table.EmpID 
                inner join employee on employee.Contact_ID = class_table.EmpID
                inner join row_level on row_level.ID = class_table.RowLevelID
                inner join subject on subject.ID = class_table.SubjectID
                left join plan_week on plan_week.ClassTableID = class_table.ID
                where employee.jobTitleID = 0 and contact.SchoolID = '".$this->session->userdata('SchoolID')."' ".$lavelWhere." ".$RowLevelIDWhere." ".$classIDWhere." ".$subjectIDWhere."
                group by class_table.EmpID 

	    	");*/
	    	
	    /* old one my khafagy
		$GetData = $this->db->query("
		    SELECT contact.Name as nameUser , GROUP_CONCAT(DISTINCT  row_level.Level_Name) as allLavelName ,
		    GROUP_CONCAT(DISTINCT  subject.Name) as allSubjectName ,
		    (
                select count(plan1.ID) from
                plan_week as plan1 inner join class_table as class_table1 on class_table1.EmpID = plan1.ClassTableID
                where class_table1.EmpID = contact.ID ) as countPlan1
            from class_table
            inner join contact on contact.ID = class_table.EmpID 
            inner join employee on employee.Contact_ID = class_table.EmpID
            inner join row_level on row_level.ID = class_table.RowLevelID
            inner join subject on subject.ID = class_table.SubjectID
            left join plan_week on plan_week.ClassTableID = class_table.ID
            where employee.jobTitleID = 0 and contact.SchoolID = '".$this->session->userdata('SchoolID')."' ".$lavelWhere." ".$RowLevelIDWhere." ".$classIDWhere." ".$subjectIDWhere."
            group by class_table.EmpID 
		");
		*/
		// old query 
		/*$GetData = $this->db->query("
		SELECT 
		contact.ID ,
		contact.Name ,
		employee.NumLesson AS EmpNumLesson ,
		employee.LevelID   AS EmpLevelID ,
		employee.NumWait   AS EmpNumWait 
		FROM 
		contact 
		INNER JOIN employee ON contact.ID       = employee.Contact_ID 
		WHERE contact.SchoolID = '".$this->session->userdata('SchoolID')."' AND contact.ID IN (".$EmpID.")
		AND  contact.Isactive = 1 and contact.Type = 'E' 
		");*/
		if($GetData->num_rows()>0)
		{
		   // print_r($this->db->last_query());
			return $GetData->result();
		}else{
			   return FALSE ;
			 }
	}
	//////get_emp_with_in
	public function get_all_emp_permission($Lang = NULL , $lavelID , $RowLevelID , $classID , $subjectID , $dateFrom  , $dateTo )
	{
		$dateFromMinus = 'NULL';
		$dateToplus    = 'NULL';
		if($dateTo!== NULL){
			$thirtyDaysUnixplus  = strtotime('+1 day', strtotime($dateTo));
			$dateToplus          = date("Y-m-d", $thirtyDaysUnixplus);
		}
		if($dateFrom !== NULL ){
			$thirtyDaysUnixMinus = strtotime('-1 day', strtotime($dateFrom));
			$dateFromMinus       = date("Y-m-d", $thirtyDaysUnixMinus);
		}

		$getType = $this->db->query('
        		select contact.type as typeUser, employee.Type , PerType from  employee 
        		inner join contact on contact.ID = employee.Contact_ID
        		where Contact_ID = "'.$this->session->userdata('id').'" 
				')->row();
				$whereLevel = "Level_ID  = ".$lavelID." "; 
				$whereRowLevel = "ID  = ".$RowLevelID." "; 
				$whereclass = "ClassID  = ".$classID." "; 
				// add this for column Clerical_homework classID not === ClassID in var $whereclass 
				$whereclassClerical_homework = " classID = ".$classID." "; 
				$whereSubjectID = "SubjectID = ".$subjectID." ";
				// add this for column LessonPrep Subject_ID not === SubjectID in var $whereclass 
				$whereLessonPrepSubjectID = "Subject_ID = ".$subjectID." ";
				// use this for Type 1 and 2 and 3 
				if($subjectID=='NULL'){
					$GetDataSubject = $this->db->query("SELECT GROUP_CONCAT(ID) as allSubject FROM subject  ")->row();
					$whereSubjectID = "SubjectID IN(".$GetDataSubject->allSubject.") ";
					$whereLessonPrepSubjectID = "Subject_ID IN(".$GetDataSubject->allSubject.")";
				}
		if($getType->Type == 1 ){
			
			if($lavelID=='NULL'){
				$whereLevel = "Level_ID IN(".$getType->PerType.") "; 
			}
			// get all rowLevel when user permission in Level
			$GetDatarowLevel = $this->db->query("SELECT GROUP_CONCAT(ID) as allRowLevel FROM `row_level` WHERE row_level.Level_ID IN(".$getType->PerType.") ")->row();
			if($RowLevelID == 'NULL'){
				$whereRowLevel = "ID IN(".$GetDatarowLevel->allRowLevel.") "; 
			}
			// get all class when user permission in Level
			$GetDataclass = $this->db->query("SELECT GROUP_CONCAT(ClassID) as allClass FROM school_class WHERE school_class.SchoolID = ".$this->session->userdata('SchoolID')." ")->row();
			if($classID=='NULL'){
				$whereclass = "ClassID IN(".$GetDataclass->allClass.") "; 
				$whereclassClerical_homework = " classID  IN(".$GetDataclass->allClass.") ";
			}
			

		}elseif($getType->Type == 2 ){
			// get level when user permission in rowLevel
			$GetData = $this->db->query("SELECT GROUP_CONCAT(Level_ID) as allLevel FROM `row_level` WHERE row_level.ID IN(".$getType->PerType.") ")->row();
			if($lavelID=='NULL'){
				$whereLevel = "Level_ID IN(".$GetData->allLevel.") "; 
			}
			if($RowLevelID == 'NULL'){
				$whereRowLevel = "ID IN(".$getType->PerType.") "; 
			}
			// get all class when user permission in rowLevel
			$GetDataclass = $this->db->query("SELECT GROUP_CONCAT(ClassID) as allClass FROM school_class WHERE school_class.SchoolID = ".$this->session->userdata('SchoolID')." ")->row();
			if($classID == 'NULL'){
				$whereclass = "ClassID IN(".$GetDataclass->allClass.") "; 
				$whereclassClerical_homework = " classID  IN(".$GetDataclass->allClass.") ";
			}

		}elseif($getType->Type == 3 ){
			$allClass    = array();
			$allRowLevel = array();
			foreach(explode(",",$getType->PerType) as $key=>$item){
				$rowLevelAndClass = explode('|',$item);
				$allRowLevel[$key] = $rowLevelAndClass[0];
				$allClass[$key]    = $rowLevelAndClass[1];

			}
			$GetData = $this->db->query("SELECT GROUP_CONCAT(Level_ID) as allLevel FROM `row_level` WHERE row_level.ID IN(".implode(',',$allRowLevel).") ")->row();
			if($lavelID=='NULL'){
				$whereLevel = "Level_ID IN(".$GetData->allLevel.") "; 
			}
			if($RowLevelID == 'NULL'){
				$whereRowLevel = "ID IN(".implode(',',$allRowLevel).") "; 
			}
			if($classID=='NULL'){
				$whereclass = "ClassID IN(".implode(',',$allClass).") "; 
				$whereclassClerical_homework = " classID  IN(".implode(',',$allClass).") ";
			}

		}elseif($getType->Type == 4 ){
			$RowLevelAndSubject = $this->db->query("SELECT GROUP_CONCAT(RowLevelID) as allRowLevelID , GROUP_CONCAT(SubjectID) as allSubjectID FROM `config_subject` WHERE config_subject.ID IN(".$getType->PerType.") ")->row();
			if($RowLevelID == 'NULL'){
				$whereRowLevel = "ID IN(".$RowLevelAndSubject->allRowLevelID.") "; 
			}
			$GetData = $this->db->query("SELECT GROUP_CONCAT(Level_ID) as allLevel FROM `row_level` WHERE row_level.ID IN(".$RowLevelAndSubject->allRowLevelID.") ")->row();
			if($lavelID=='NULL'){
				$whereLevel = "Level_ID IN(".$GetData->allLevel.") "; 
			}
			// get all class when user permission in rowLevel
			$GetDataclass = $this->db->query("SELECT GROUP_CONCAT(ClassID) as allClass FROM school_class WHERE school_class.SchoolID = ".$this->session->userdata('SchoolID')." ")->row();
			if($classID == 'NULL'){
				$whereclass = "ClassID IN(".$GetDataclass->allClass.") "; 
				$whereclassClerical_homework = " classID  IN(".$GetDataclass->allClass.") ";
			}
			if($subjectID=='NULL'){
				$whereSubjectID = "SubjectID IN(".$RowLevelAndSubject->allSubjectID.") ";
				$whereLessonPrepSubjectID = "Subject_ID IN(".$RowLevelAndSubject->allSubjectID.")";
			}
			
		}			
	    $lavelClass = '';
	    if($lavelID != 'NULL'){ $lavelClass = " and row_level.ID in (select row_level.ID from row_level where row_level.Level_ID = ".$lavelID." group by  row_level.ID  )"; }
	    $GetData = $this->db->query("
	        SELECT contact.Name as nameUser , contact.ID as conID ,contact.LastLogin,
	        GROUP_CONCAT(DISTINCT  row_level.Level_Name) as allLavelName ,GROUP_CONCAT(DISTINCT  subject.Name) as allSubjectName ,
	        count(class_table.ID) as newCount ,
            (
            select count(DISTINCT plan1.FileAttach) from plan_week as plan1 
            inner join class_table as class_table1 on class_table1.ID = plan1.ClassTableID
            inner join row_level as rowLavelPlan on class_table1.RowLevelID = rowLavelPlan.ID
            where class_table1.EmpID = contact.ID 
            AND rowLavelPlan.".$whereLevel." 
            AND rowLavelPlan.".$whereRowLevel."
            AND class_table1.".$whereclass."
            AND class_table1.".$whereSubjectID."
            AND (case WHEN ".$dateFromMinus." IS NULL THEN plan1.Date_Stm = plan1.Date_Stm ELSE ( plan1.Date_Stm BETWEEN cast('".$dateFromMinus."' as DATE )  and  cast('".$dateToplus."' as DATE ) ) END )
            AND (plan1.Content !='' or plan1.FileAttach is not NULL)
            
            ) as countPlan1 ,
            (
            select count(e_library.ID) from e_library 
            inner join row_level as rowLavelLibrary on rowLavelLibrary.ID = e_library.RowLevelID
            where e_library.ContactID = contact.ID 
            AND rowLavelLibrary.".$whereLevel." 
            AND rowLavelLibrary.".$whereRowLevel."
            AND e_library.".$whereSubjectID."
            AND (case WHEN ".$dateFromMinus." IS NULL THEN e_library.Stm_Date = e_library.Stm_Date ELSE ( e_library.Stm_Date BETWEEN cast('".$dateFromMinus."' as DATE )  and  cast('".$dateToplus."' as DATE ) ) END )
            ) as countLib ,
            (
            select count(lesson_prep.ID) from lesson_prep 
            inner join row_level as rowLavelPrep on rowLavelPrep.ID = lesson_prep.RowLevel_ID
            where lesson_prep.Teacher_ID = contact.ID
            AND rowLavelPrep.".$whereLevel." 
            AND rowLavelPrep.".$whereRowLevel."
            AND lesson_prep.".$whereLessonPrepSubjectID."
            AND (case WHEN ".$dateFromMinus." IS NULL THEN lesson_prep.Date = lesson_prep.Date ELSE ( lesson_prep.Date BETWEEN cast('".$dateFromMinus."' as DATE )  and  cast('".$dateToplus."' as DATE ) ) END )
            ) as countLessonPrep ,
            (
            select count(clerical_homework.ID) from  config_emp
            INNER JOIN clerical_homework ON clerical_homework.subjectEmpID = config_emp.ID
            INNER JOIN row_level as row_levelClerical on row_levelClerical.ID = config_emp.RowLevelID
            WHERE config_emp.EmpID = contact.ID 
            AND row_levelClerical.".$whereLevel." 
            AND row_levelClerical.".$whereRowLevel."
            AND clerical_homework.".$whereclassClerical_homework."
            AND config_emp.".$whereSubjectID."
            AND (case WHEN ".$dateFromMinus." IS NULL THEN clerical_homework.Date = clerical_homework.Date ELSE ( clerical_homework.Date BETWEEN cast('".$dateFromMinus."' as DATE )  and  cast('".$dateToplus."' as DATE ) ) END )
            AND (clerical_homework.title !=''  ) 
            ) as countClericalHomework,
            (
            select count(test.ID) from config_emp as config_emp1
            inner join test on test.Subject_emp_ID = config_emp1.ID
            INNER JOIN row_level as row_levelTest on row_levelTest.ID = config_emp1.RowLevelID
            where config_emp1.EmpID = contact.ID AND test.type = 0
            AND row_levelTest.".$whereLevel." 
            AND row_levelTest.".$whereRowLevel."
            AND config_emp1.".$whereSubjectID."
            AND (case WHEN ".$dateFromMinus." IS NULL THEN test.Date_Stm = test.Date_Stm ELSE ( test.Date_Stm BETWEEN cast('".$dateFromMinus."' as DATE )  and  cast('".$dateToplus."' as DATE ) ) END )
           
            ) as countTest ,
            (
            select count(test.ID) from config_emp as config_emp1
            inner join test on test.Subject_emp_ID = config_emp1.ID
            INNER JOIN row_level as row_levelTest on row_levelTest.ID = config_emp1.RowLevelID
            where config_emp1.EmpID = contact.ID AND test.type = 1
            AND row_levelTest.".$whereLevel."
            AND row_levelTest.".$whereRowLevel."
            AND config_emp1.".$whereSubjectID."
            AND (case WHEN ".$dateFromMinus." IS NULL THEN test.Date_Stm = test.Date_Stm ELSE ( test.Date_Stm BETWEEN cast('".$dateFromMinus."' as DATE )  and  cast('".$dateToplus."' as DATE ) ) END )
           
            ) as countHomework 
            from class_table
            left join contact on contact.ID = class_table.EmpID 
            left join employee on employee.Contact_ID = class_table.EmpID
            inner join row_level on row_level.ID = class_table.RowLevelID
            inner join subject on subject.ID = class_table.SubjectID
            where employee.jobTitleID = 0 and contact.SchoolID =  '".$this->session->userdata('SchoolID')."' 
            AND row_level.".$whereLevel."
            AND row_level.".$whereRowLevel."
            AND class_table.".$whereclass."
			AND class_table.".$whereSubjectID."
			AND (case WHEN ".$dateFromMinus." IS NULL THEN contact.LastLogin = contact.LastLogin ELSE  contact.LastLogin BETWEEN cast('".$dateFromMinus."' as DATE )  and  cast('".$dateToplus."' as DATE  ) END )
			AND (case WHEN ".$dateFromMinus." IS NULL THEN class_table.Date_Stm = class_table.Date_Stm ELSE  class_table.Date_Stm BETWEEN cast('".$dateFromMinus."' as DATE )  and  cast('".$dateToplus."' as DATE  ) END )
			group by class_table.EmpID 
		");
		//print_r($this->db->last_query());exit();
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			   return FALSE ;
			 }
	}
	/////////////////////////////get_class_table_row
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
	public function get_student($Lang = NULL  , $LevelID = 0 , $RowLevelID = 0  , $ClassID = 0 )
	{
		
		if($LevelID == 0 )   {$LevelID = 'NULL' ; }
		if($RowLevelID == 0 ){$RowLevelID = 'NULL' ; }
		if($ClassID == 0 )   {$ClassID = 'NULL' ; }
		
		$NameArray = array("Level"=>"Name AS LevelName" ,"row"=>"Name AS RowName" , "class"=>"Name AS ClassName", 'SchoolName'=>"SchoolName");
		if($Lang == "english")
		{
			$NameArray = array("Level"=>"Name_en AS LevelName" ,"row"=>" Name_en AS RowName" , "class"=>"Name_en AS ClassName", 'SchoolName'=>"SchoolNameEn");
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
			 school_details.SchoolName , 
			 tb1.ID AS StudentID,
			 tb1.Name AS StudentName,
			 tb1.User_Name AS StudentUserName,
			 tb2.ID AS FatherID ,
		     tb2.Name AS FatherName ,
			 tb2.Mobile AS MobilFather ,
			 tb2.User_Name AS FatherUserName,
			 CONCAT(tb1.Name,' ',tb2.Name) AS FullName
			 FROM contact As tb1
			 INNER JOIN student ON tb1.ID = student.Contact_ID
			 INNER JOIN contact AS tb2 ON student.Father_ID     = tb2.ID
			 INNER JOIN class            ON student.Class_ID    = class.ID
			 INNER JOIN row_level        ON student.R_L_ID      = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID    = row.ID
			 INNER JOIN level            ON row_level.Level_ID  = level.ID
			 LEFT JOIN school_details    ON tb1.SchoolID  = school_details.ID
			 WHERE tb1.SchoolID  = '".$this->session->userdata("SchoolID")."'
			 AND  
			 level.ID      = IFNULL($LevelID,level.ID)
			 AND 
			 row_level.ID  = IFNULL($RowLevelID,row_level.ID)
			 AND 
			 class.ID      = IFNULL($ClassID,class.ID)
			 AND tb1.Isactive = 1 
		     AND tb2.Isactive = 1 
			");
			
			if($query->num_rows()>0)
			{
			   return $query->result();	
			}else{return false ;}
			
	}
	/////////////////////////////get_all_student
	public function get_all_student($Lang = NULL , $Branche = 0 )
	{
		if($Branche == 0 )   {$Branche = 'NULL' ; }
		
		$NameArray = array("Level"=>"Name AS LevelName" ,"row"=>"Name AS RowName" , "class"=>"Name AS ClassName", 'SchoolName'=>"SchoolName AS SchoolName");
		if($Lang == "english")
		{
			$NameArray = array("Level"=>"Name_en AS LevelName" ,"row"=>" Name_en AS RowName" , "class"=>"Name_en AS ClassName", 'SchoolName'=>"SchoolNameEn AS SchoolName ");
		}
		$query = $this->db->query("
			 SELECT
			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
			 level.".$NameArray['Level'].",
			 school_details.".$NameArray['SchoolName']." , 
			 row.".$NameArray['row'].",
			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
			 class.".$NameArray['class']." ,
			 school_details.ID AS SchoolID , 
			 tb1.ID AS StudentID,
			 tb1.Name AS StudentName,
			 tb1.User_Name AS StudentUserName,
			 tb2.ID AS FatherID ,
		     tb2.Name AS FatherName ,
			 tb2.Mobile AS MobilFather ,
			 tb2.User_Name AS FatherUserName,
			 CONCAT(tb1.Name,' ',tb2.Name) AS FullName
			 FROM contact As tb1
			 INNER JOIN student ON tb1.ID = student.Contact_ID
			 INNER JOIN contact AS tb2 ON student.Father_ID     = tb2.ID
			 INNER JOIN class            ON student.Class_ID    = class.ID
			 INNER JOIN row_level        ON student.R_L_ID      = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID    = row.ID
			 INNER JOIN level            ON row_level.Level_ID  = level.ID
			 LEFT JOIN school_details    ON tb1.SchoolID  = school_details.ID
			 WHERE tb1.SchoolID = IFNULL($Branche,tb1.SchoolID)
			 AND tb1.Isactive = 1 
		     AND tb2.Isactive = 1 
			 
			");
			
			if($query->num_rows()>0)
			{
			   return $query->result();	
			}else{return false ;}
			
	}
	/////////////////////////get_eval_subject
	public function get_eval_subject($ID = 0 )
	{
		$this->db->select('*');
		$this->db->from('evaluation_rules');
		$this->db->where('EmpID',$ID);
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows()>0){return $query->row_array();}else{return FALSE ;}
	}////////////////////////get_report_eval
	public function get_report_eval($YearID ,$Lang = NULL , $EmpPer = 0 )
	{
		$query = $this->db->query("
		SELECT
		emp_evaluation.Degree    AS EmpDegree ,
		emp_evaluation.DateStm   AS EvaluationDateStm,
		evaluation_elements.Name AS EvalElement ,
		evaluation_note.Name     AS EvalNote ,
		contact.ID               AS ContactID,
		contact.Name             AS ContactName ,
		contactEmp.Name          AS ContactNameEmp ,
		contactEmp.ID            AS ContactEmpID
		FROM
		emp_evaluation
		LEFT JOIN contact               ON emp_evaluation.ContactID    = contact.ID
		LEFT JOIN contact As contactEmp ON emp_evaluation.EmpID        = contactEmp.ID
		LEFT JOIN evaluation_note       ON emp_evaluation.noteID       = evaluation_note.ID
		LEFT JOIN evaluation_elements   ON evaluation_note.elementID   = evaluation_elements.ID
		WHERE  emp_evaluation.YearID = ".$YearID."
		AND  contact.Isactive = 1
		AND contactEmp.ID IN (".$EmpPer.")
		");
		if($query->num_rows()>0)
		{
			return $query->result() ;
		}else{return FALSE ;}
	}//////get_report_level
	public function  get_report_level($Lang = NULL)
	{
		$LangArray = array();
		if($Lang == 'arabic'){$LangArray['Name'] = 'Name';}else{$LangArray['Name'] = 'Name_en';}
		$GetLevel =  $this->db->query("SELECT  ID , ".$LangArray['Name'] ." FROM level WHERE Is_Active = 1  ");
		//echo "SELECT  ID , '".$LangArray['Name'] ."' FROM level WHERE Is_Active = 1  " ;exit;
		if($GetLevel->num_rows()>0){return $GetLevel->result();}else{return FALSE ;}
	}//////get_emp_level
	public function  get_emp_level($LevelID = 0  , $RowLevelID = 0  , $ClassID = 0 )
	{
                if($LevelID == 0 )   {$LevelID = 'NULL' ; }
		if($RowLevelID == 0 ){$RowLevelID = 'NULL' ; }
		if($ClassID == 0 )   {$ClassID = 'NULL' ; }
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
        GROUP BY contact.ID
		");// print_r($this->db->last_query());
		//echo "SELECT  ID , '".$LangArray['Name'] ."' FROM level WHERE Is_Active = 1  " ;exit;
		if($GetEmp->num_rows()>0){return $GetEmp->result();}else{return FALSE ;}

}//////emp_plan_week_report
public function  emp_plan_week_report($ID = 0 ,$Lang = NULL)
{
	$NameArray = array("Level"=>"Name AS LevelName" ,"row"=>"Name AS RowName" , "class"=>"Name AS ClassName","lesson"=>"lesson AS LessonName");
	if($Lang == "english")
	{
		$NameArray = array("Level"=>"Name_en AS LevelName" ,"row"=>" Name_en AS RowName" , "class"=>"Name_en AS ClassName","lesson"=>"Lesson_en AS LessonName");
	}
	$GetEmp =  $this->db->query("
		SELECT
			  class_table.ID AS ClassTableID ,
			  subject.Name   AS SubjectName  ,
			  lesson.".$NameArray['lesson']." ,
			  level.".$NameArray['Level'].",
			  row.".$NameArray['row'].",
			  class.".$NameArray['class'].",
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
			  class_table.empID             = ".$ID."
			  AND
			  base_class_table.IsActive     = 1

              ORDER BY  class_table.Lesson
		");
	//echo "SELECT  ID , '".$LangArray['Name'] ."' FROM level WHERE Is_Active = 1  " ;exit;
	if($GetEmp->num_rows()>0){return $GetEmp->result();}else{return FALSE ;}
}
	public function emp_report_cms()
	{   
		$GetData = $this->db->query("
	     SELECT 
		 cms_album_pic.contactID ,
		 contact.Name  , 
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
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			return FALSE ;
		}
	}
	public function sum_emp_report_cms($ContactID = 0 , $SubMainID = 0 )
	{
		$GetData = $this->db->query("
		SELECT 
		 cms_album_pic.contactID ,
		 contact.Name  , 
		 school_details.SchoolName	 
		 FROM
		 cms_album_pic
		 INNER  JOIN     cms_details ON cms_details.ID      = cms_album_pic.item_data
		 INNER  JOIN     cms_main_sub ON cms_main_sub.ID    = cms_details.MainSubID
		 INNER  JOIN     contact ON   cms_album_pic.contactID   = contact.ID
		 LEFT   JOIN     school_details ON contact.SchoolID = school_details.ID
		 WHERE  
		 cms_details.ContentTypeID =1 and cms_album_pic.contactID !=0
		 AND
		 contact.ID = '".$ContactID."' AND cms_details.MainSubID = '".$SubMainID."'
		 AND  contact.Isactive = 1
		 ");
		return $GetData->num_rows();
	}


	public function emp_eval_report()
	{
		$GetData = $this->db->query("
		SELECT
		contact.ID ,
		contact.Name
		FROM
		contact
		INNER JOIN emp_evaluation ON contact.ID       = emp_evaluation.ContactID
		WHERE contact.Isactive = 1
		GROUP BY emp_evaluation.ContactID DESC
		");
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			return FALSE ;
		}
	}
	public function sum_emp_eval_report($ContactID = 0 )
	{
		$GetData = $this->db->query("SELECT * FROM cms_details WHERE ContactID = '".$ContactID."'  ");
		return $GetData->num_rows();
	}

	public function emp_eval_report_lesson()
	{
		$GetData = $this->db->query("
		SELECT
		contact.ID ,
		contact.Name
		FROM
		contact
		INNER JOIN lesson_prep_eval	 ON contact.ID       = lesson_prep_eval	.ContactID
		WHERE contact.Isactive = 1
		GROUP BY lesson_prep_eval.ContactID DESC
		");
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			return FALSE ;
		}
	}

	public function sum_emp_eval_report_lesson($ContactID = 0  )
	{
		$GetData = $this->db->query("SELECT * FROM lesson_prep_eval	 WHERE ContactID = '".$ContactID."' ");
		return $GetData->num_rows();
	}
	public function report_home_work_view($EmpID = 0 , $DayDateFrom = 'NULL' , $DayDateTo = 'NULL'   )
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
	    WHERE config_emp.EmpID = ".$EmpID." AND test.type = 1
		AND 
		(DATE(test.Date_Stm)	 BETWEEN CAST('".$DayDateFrom."' AS DATE ) AND CAST('".$DayDateTo."' AS DATE  )) 
		 ")->result();
		if(sizeof($getReport)> 0 )
		{
			return $getReport ;
		}else{return false ; }
	}
	public function report_exam_view($EmpID = 0  , $DayDateFrom = 'NULL' , $DayDateTo = 'NULL'  )
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
	    WHERE config_emp.EmpID = ".$EmpID." AND test.type = 0
		AND 
		(DATE(test.Date_Stm)	 BETWEEN CAST('".$DayDateFrom."' AS DATE ) AND CAST('".$DayDateTo."' AS DATE  )) 

		
		 ")->result();
		if(sizeof($getReport)> 0 )
		{
			return $getReport ;
		}else{return false ; }
	}
	////get_level
	public function get_level($Lang = NULL )
	{
		if($Lang == 'arabic')
		{
		  $this->db->select('ID ,Name ,Token');    
		  $this->db->from('level');
		  $this->db->where('Is_Active',1);
		}
		else{
		      $this->db->select('ID ,Name_en AS Name ,Token');    
		      $this->db->from('level');
		      $this->db->where('Is_Active',1);
			}
			  $query = $this->db->get();			
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
	////////////////////////get_level_number_student
	public function get_level_number_student($Lang = NULL)
	{
	  $Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT  distinct
		 level.ID         AS LevelID ,
		 row.ID           AS RowID ,
		 level.".$Name."  AS LevelName ,
		 row.".$Name."    AS RowName ,
		 row_level.ID     As RowLevelID 
		 FROM 
		 row_level
		 INNER JOIN row              ON row_level.Row_ID      = row.ID
		 INNER JOIN level            ON row_level.Level_ID    = level.ID
		 INNER JOIN student          ON row_level.ID          = student.R_L_ID
		 INNER JOIN contact          ON student.Contact_ID    = contact.ID
		 WHERE level.Is_Active = 1 
		 AND contact.SchoolID  = '".$this->session->userdata('SchoolID')."'
		 AND  contact.Isactive = 1
		  ORDER BY row_level.ID ASC
		 
		 ")->result();
		 
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}	
	}
	
	////////////////////////get_emp
	public function get_Job_Title($Lang = NULL)
	{
	  $Name       = 'Name_Ar' ; 
	  
		if($Lang == 'english'){$Name = 'Name_En' ;}
		$query = $this->db->query("SELECT ID ,  ".$Name." AS Name  FROM job_title ")->result();
		 
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}	
	}////////////////////////get_emp_Job_Title
	public function get_emp_Job_Title( $JobTitle = 0 )
	{
	    if($JobTitle == 0 ){$JobTitle = 'NULL' ;}
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
		contact.SchoolID = '".$this->session->userdata('SchoolID')."'
		AND  contact.Isactive = 1 and contact.type = 'E'
		")->result();
		 
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}	
	}
	public function get_branches($Lang = NULL   )
	{
       
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
	////////////////////////get_emp_Job_Title
	public function emp_all_data($BranchID = 0  )
	{
		if($BranchID == 0 ){$BranchID = 'NULL' ;}
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
		AND  contact.Isactive = 1 AND contact.type = 'E'
		
		")->result();
		 
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}	
	}
	////////////////////////get_emp_Job_Title
	public function emp_all_data_without_class($BranchID = 0  )
	{
		if($BranchID == 0 ){$BranchID = 'NULL' ;}
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
		AND contact.ID NOT IN (SELECT EmpID FROM class_table)
		AND  contact.Isactive = 1 and contact.Type = 'E'
	
		
		")->result();
		 
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}	
	}
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
		 WHERE level.Is_Active = 1 
		 ")->result();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}
	}
		public function get_row_level_school_active2($Lang = NULL , $levelID,$WhereInRowLevel)
	{
		$whereIN = "";
	    if($WhereInRowLevel!=0){
			$exploadWhereInRowLevel = explode('and',$WhereInRowLevel);
			$whereIN = "AND  row_level.ID IN(".implode(',',$exploadWhereInRowLevel).")";
		}
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		if($levelID == 0){
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
		 ")->result();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;} 
		}else{
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
		 WHERE level.ID = " . $levelID ."  ".$whereIN."
		 ")->result();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;} 
		}
		
	}


	public function get_row_level_school_active_On_zero($Lang = NULL , $WhereInLevel,$WhereInRowLevel)
	{
		if($WhereInRowLevel!=0){
			$exploadWhereInRowLevel = explode('and',$WhereInRowLevel);
			$whereIN = "  row_level.ID IN(".implode(',',$exploadWhereInRowLevel).")";
		}else{
			$exploadWhereInLevel = explode('and',$WhereInLevel);
			//print_r($exploadWhereInLevel );exit();
			$whereIN = "  level.ID IN(".implode(',',$exploadWhereInLevel).")";
		}
		
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
		 WHERE  ".$whereIN."
		 ")->result();
		 //print_r($this->db->last_query());exit();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;} 
		
		
	}
	public function get_row_level_school_active3($Lang = NULL , $levelID)
	{
	    
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		if($levelID == 0){
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
		 ")->result();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;} 
		}else{
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
		 WHERE  row_level.ID = " . $levelID ."
		 ")->result();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;} 
		}
		
	}
		public function get_row_level_school_active3_per($Lang = NULL , $levelID,$rowLavelOnSelectAll = 0)
	{
	    
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		if($levelID == 0){
			$where = '';
			if($rowLavelOnSelectAll!=0){
				$where = "WHERE level.ID = ".$rowLavelOnSelectAll." ";
			}
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
		INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID 
		AND school_row_level.schoolID = '".$this->session->userdata('SchoolID')."'
		".$where." 
		 ")->result();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;} 
		}else{
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
		 WHERE  row_level.ID = " . $levelID ."
		 ")->result();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;} 
		}
		
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
	public function get_class_school_active_per($Lang = NULL,$WhereInRowLevel)
	{
		$where = '';
		if($WhereInRowLevel != 0){
			$WhereInRowLevelexplode= explode('and',$WhereInRowLevel);
			$where = "WHERE class.ID IN(".implode(',',$WhereInRowLevelexplode).")";
		}
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		  $query = $this->db->query("SELECT
		  class.ID  AS ClassID ,
		  class. ".$Name." AS ClassName 
		  FROM class
		  INNER JOIN school_class ON class.ID = school_class.ClassID AND school_class.SchoolID = '".$this->session->userdata('SchoolID')."'
		  ".$where."
		   ");			
		  if($query->num_rows() >0)
		  {return $query->result();}else{return FALSE ;}
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
			  where config_subject.ID IN(".$configSubjectID.")
			  GROUP BY config_subject.ID  DESC
			");
				  if($query->num_rows() >0){
					  return $query->result();
					}else{
						return FALSE ;
					}
		}
	public function get_active_library($EmpPer = 0  , $Lang = NULL)
	{
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
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
		level.".$Name."  AS LevelName ,
		row.".$Name."    AS RowName ,
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
		WHERE contact.ID IN(".$EmpPer.")
		AND e_library.IsActive = 0 
		AND  contact.Isactive = 1
		")->result();
	//print_r($query);exit;
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}	
	}
	public function active_library($active_library = 0 )
	{
	  $this->db->query("UPDATE e_library SET IsActive = 1 WHERE ID = '".$active_library."'");	
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
        if($query->num_rows()>0)
        {
            return $query->result();
        }else{return false ;}
    }
	public function  lesson_prep_eval_report ($EmpSelect = 0 )
	{
		 $query = $this->db->query("
			 SELECT 
			 tb1.ID AS EmpID , 
			 tb1.Name AS EmpName ,
			 lesson_prep.Lesson_Title , 
			 lesson_prep_eval.Degree  ,
			 lesson_prep_eval.DateSTM  ,
			 tb2.ID AS ContactID , 
			 tb2.Name AS ContactName 
			 FROM 
			 lesson_prep_eval
			 INNER JOIN contact AS tb1 ON lesson_prep_eval.EmpID     = tb1.ID
			 INNER JOIN contact AS tb2 ON lesson_prep_eval.ContactID = tb2.ID 
			 INNER JOIN lesson_prep ON lesson_prep_eval.LessonPrepID = lesson_prep.ID
			 WHERE tb1.IsActive = 1
			 AND tb1.ID IN (".$EmpSelect.")
			 group by lesson_prep.ID
			");
        if($query->num_rows()>0)
        {
            return $query->result();
        }else{return false ;}
	}
	////////get_class_school
	public function get_class_school($Lang = NULL)
    {
	$NameArray = array("Level"=>"Name AS LevelName" ,"row"=>"Name AS RowName" , "class"=>"Name AS ClassName","lesson"=>"lesson AS LessonName");
	if($Lang == "english")
	{
		$NameArray = array("Level"=>"Name_en AS LevelName" ,"row"=>" Name_en AS RowName" , "class"=>"Name_en AS ClassName","lesson"=>"Lesson_en AS LessonName");
	}
	$GetEmp =  $this->db->query("
		  SELECT
		  level.".$NameArray['Level'].",
		  row.".$NameArray['row'].",
		  class.".$NameArray['class']." , 
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
		   contact.SchoolID = '".$this->session->userdata('SchoolID')."'
		  GROUP BY  class.ID
		  ORDER BY class.ID
		");
	//echo "SELECT  ID , '".$LangArray['Name'] ."' FROM level WHERE Is_Active = 1  " ;exit;
	if($GetEmp->num_rows()>0){return $GetEmp->result();}else{return FALSE ;}
    }
	
	////////get_class_school
	public function get_row_level_school_report($Lang = NULL)
    {
	$NameArray = array("Level"=>"Name AS LevelName" ,"row"=>"Name AS RowName" , "class"=>"Name AS ClassName","lesson"=>"lesson AS LessonName");
	if($Lang == "english")
	{
		$NameArray = array("Level"=>"Name_en AS LevelName" ,"row"=>" Name_en AS RowName" , "class"=>"Name_en AS ClassName","lesson"=>"Lesson_en AS LessonName");
	}
	$GetEmp =  $this->db->query("
		  SELECT
		  level.".$NameArray['Level'].",
		  row.".$NameArray['row'].",
		  class.".$NameArray['class']." , 
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
		   contact.SchoolID = '".$this->session->userdata('SchoolID')."'
		  GROUP BY  row_level.ID
		  ORDER BY row_level.ID
		");
	//echo "SELECT  ID , '".$LangArray['Name'] ."' FROM level WHERE Is_Active = 1  " ;exit;
	if($GetEmp->num_rows()>0){return $GetEmp->result();}else{return FALSE ;}
    }
	//////////////////////////////emp_lesson_prep_report
	public function emp_lesson_prep_report( $Lang = NULL  , $EmpID = 0 , $DayDateFrom = NULL ,  $DayDateTo = NULL )
	{
		$NameArray = array("Level"=>"Name AS LevelName" ,"row"=>"Name AS RowName" , "class"=>"Name AS ClassName","lesson"=>"lesson AS LessonName");
	if($Lang == "english")
	{
		$NameArray = array("Level"=>"Name_en AS LevelName" ,"row"=>" Name_en AS RowName" , "class"=>"Name_en AS ClassName","lesson"=>"Lesson_en AS LessonName");
	}
		$getReport = $this->db->query("
			SELECT 
			lesson_prep.ID AS LessonID , 
			lesson_prep.Lesson_Title , 
			lesson_prep.Date	AS Date  ,
			level.".$NameArray['Level'].",
		    row.".$NameArray['row'].",
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
			WHERE lesson_prep.Teacher_ID = ".$EmpID."
			AND 
			(DATE(lesson_prep.Date) BETWEEN CAST('".$DayDateFrom."' AS DATE ) AND CAST('".$DayDateTo."' AS DATE  ))
			GROUP BY  lesson_prep.RowLevel_ID , lesson_prep.Subject_ID
			
		 ")->result();
		 
		 if(sizeof($getReport )>0){return $getReport ; }else{return FALSE ;} 
	}
	//////////////////////////////////students_eval_report
	public function students_eval_report( $Lang = NULL  , $EmpID = 0 ,  $DayDateFrom = NULL ,  $DayDateTo = NULL )
	{
		$NameArray = array("Level"=>"Name AS LevelName" ,"row"=>"Name AS RowName" , "class"=>"Name AS ClassName","lesson"=>"lesson AS LessonName");
	   if($Lang == "english")
	   {
		$NameArray = array("Level"=>"Name_en AS LevelName" ,"row"=>" Name_en AS RowName" , "class"=>"Name_en AS ClassName","lesson"=>"Lesson_en AS LessonName");
	   }
		if($DayDateFrom  == 'NULL' && $DayDateFrom  == 'NULL'  )
		{
		$getReport = $this->db->query("
		SELECT 
		students_evaluation.ID , 
		students_evaluation.Date , 
		level.".$NameArray['Level'].",
		row.".$NameArray['row'].",
		class.".$NameArray['class'].",
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
		WHERE students_evaluation.TeacherID = ".$EmpID."  GROUP BY student.R_L_ID , student.Class_ID ,  students_evaluation.Date_stm
		 ")->result();
		}
		else{
			   $getReport = $this->db->query("
			    SELECT 
				students_evaluation.ID , 
				students_evaluation.Date , 
				level.".$NameArray['Level'].",
				row.".$NameArray['row'].",
				class.".$NameArray['class'].",
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
				WHERE students_evaluation.TeacherID = ".$EmpID."  
				AND 
			   (DATE(students_evaluation.Date)	 BETWEEN CAST('".$DayDateFrom."' AS DATE ) AND CAST('".$DayDateTo."' AS DATE  )) 
			   GROUP BY student.R_L_ID , student.Class_ID ,  students_evaluation.Date
		 ")->result();
			}
           if(sizeof($getReport )>0){return $getReport ; }else{return FALSE ;} 
 	}
	//////////////////////////////////students_eval_report
	public function students_eval_absence_report( $Lang = NULL  ,   $DayDateFrom = NULL ,  $DayDateTo = NULL , $Student = 0  )
	{
		$NameArray = array("Level"=>"Name AS LevelName" ,"row"=>"Name AS RowName" , "class"=>"Name AS ClassName","lesson"=>"lesson AS LessonName");
	   if($Lang == "english")
	   {
		$NameArray = array("Level"=>"Name_en AS LevelName" ,"row"=>" Name_en AS RowName" , "class"=>"Name_en AS ClassName","lesson"=>"Lesson_en AS LessonName");
	   }
		
		$getReport = $this->db->query("
		SELECT
		level.ID AS LevelID,
		row.ID AS RowID,
		class.ID AS ClassID,
		level.".$NameArray['Level'].",
		row.".$NameArray['row'].",
		row_level.ID As RowLevelID ,
		class.ID As ClassID ,
		class.".$NameArray['class']." ,
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
		students_evaluation.Date  AS EvalDate ,
		students_evaluation.Delay AS EvalDelay ,
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
		WHERE 
		(
		(DATE(students_evaluation.Date)	 BETWEEN CAST('".$DayDateFrom."' AS DATE ) AND CAST('".$DayDateTo."' AS DATE  )) 
		AND 
		tb1.Isactive = 1 
		AND 
		tb2.Isactive = 1
		AND 
		tb1.ID IN(".$Student.")
		AND
		students_evaluation.Absence = 1
		)
		 OR
		 (
		 (DATE(students_evaluation.Date)	 BETWEEN CAST('".$DayDateFrom."' AS DATE ) AND CAST('".$DayDateTo."' AS DATE  )) 
		AND 
		tb1.Isactive = 1 
		AND 
		tb2.Isactive = 1
		AND 
		tb1.ID IN(".$Student.")
		AND
		students_evaluation.Delay !=0 
		)
		ORDER BY  students_evaluation.Date
		 ")->result();
		 
           if(sizeof($getReport )>0){return $getReport ; }else{return FALSE ;} 	
	}
	//////////////////////////////////students_eval_report
	public function students_delay_absence_report( $Lang = NULL  ,   $DayDateFrom = NULL ,  $DayDateTo = NULL , $Student = 0  )
	{
		$NameArray = array("Level"=>"Name AS LevelName" ,"row"=>"Name AS RowName" , "class"=>"Name AS ClassName","lesson"=>"lesson AS LessonName");
	   if($Lang == "english")
	   {
		$NameArray = array("Level"=>"Name_en AS LevelName" ,"row"=>" Name_en AS RowName" , "class"=>"Name_en AS ClassName","lesson"=>"Lesson_en AS LessonName");
	   }
		
		$getReport = $this->db->query("
		SELECT
		level.ID AS LevelID,
		row.ID AS RowID,
		class.ID AS ClassID,
		level.".$NameArray['Level'].",
		row.".$NameArray['row'].",
		row_level.ID As RowLevelID ,
		class.ID As ClassID ,
		class.".$NameArray['class']." ,
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
		(DATE(student_abcent.Date)	 BETWEEN CAST('".$DayDateFrom."' AS DATE ) AND CAST('".$DayDateTo."' AS DATE  )) 
		AND 
		tb1.Isactive = 1 
		AND 
		tb2.Isactive = 1
		AND 
		tb1.ID IN(".$Student.")	
			
		ORDER BY  student_abcent.Date
		 ")->result();
		 
           if(sizeof($getReport )>0){return $getReport ; }else{return FALSE ;} 	
	}
	
	public function getSupRowLavel($classID,$rowLavel){
	   $result =  $this->db->query(
        	    'SELECT subject.ID , subject.Name from subject 
                INNER JOIN  class_table on subject.ID = class_table.SubjectID
                WHERE class_table.RowLevelID = '.$rowLavel.' and class_table.ClassID = '.$classID.' 
                GROUP BY subject.ID '
	    );
	   return $result->result();
	}
	
	public function getskills($subject,$rowLavel){
	     $result =  $this->db->query(
	        'SELECT name,ID from skills where RowLevelID='.$rowLavel.' and SubjectID='.$subject.' '
	     );
	     return $result->result();
	}
	
	public function report_emp_add_test(){
	   $query = $this->db->query('SELECT * FROM vw_test_emp_select where IsActive =1 order by test_ID  ');
	   if($query->num_rows() > 0 ){
	       return $query->result();
	   }else{
	       return false;
	   }
	}
	

 public function report_plan_week_school($schoolID,$LevelID,$RowLevelID,$classID,$subjectID)
	{
		$getReport = $this->db->query("
		SELECT 
		plan_week.ID 
		FROM plan_week 
		INNER JOIN class_table ON plan_week.ClassTableID = class_table.ID 
		inner join row_level  on class_table.RowLevelID = row_level.ID
		WHERE class_table.SchoolID = ".$schoolID." AND plan_week.Content != '' 
		AND row_level.Level_ID =  IFNULL( ".$LevelID." , row_level.Level_ID  ) 
		AND row_level.ID = IFNULL( ".$RowLevelID." , row_level.ID  ) 
		AND class_table.ClassID =  IFNULL( ".$classID." , class_table.ClassID  ) 
		AND class_table.SubjectID = IFNULL( ".$subjectID." ,  class_table.SubjectID ) 
		 ");
		 return (int)$getReport->num_rows();
	}

public function report_library_school($schoolID,$LevelID,$RowLevelID,$classID,$subjectID)
	{
		$getReport = $this->db->query("
			select e_library.ID from e_library 
			inner join row_level  on row_level.ID = e_library.RowLevelID
			inner join contact on contact.ID =  e_library.ContactID
			where  contact.SchoolID='".$schoolID."' 
			AND row_level.Level_ID =  IFNULL( ".$LevelID." , row_level.Level_ID  ) 
			AND row_level.ID = IFNULL( ".$RowLevelID." , row_level.ID  ) 
			AND e_library.SubjectID = IFNULL( ".$subjectID." ,  e_library.SubjectID )
			group by e_library.ID
		 ");
		 return (int)$getReport->num_rows();
	}

	public function report_class_table_school($schoolID,$LevelID,$RowLevelID,$classID,$subjectID)
	{
		$getReport = $this->db->query("
			SELECT class_table.ID
			FROM class_table 
			inner join row_level on row_level.ID = class_table.RowLevelID
			WHERE SchoolID = ".$schoolID." 
			AND row_level.Level_ID =  IFNULL( ".$LevelID." , row_level.Level_ID  ) 
            AND row_level.ID = IFNULL( ".$RowLevelID." , row_level.ID  ) 
            AND class_table.ClassID =  IFNULL( ".$classID." , class_table.ClassID  ) 
            AND class_table.SubjectID = IFNULL( ".$subjectID." ,  class_table.SubjectID ) 
		 ");
		 return (int)$getReport->num_rows();
	}
public function report_clerical_homework_school($schoolID,$LevelID,$RowLevelID,$classID,$subjectID)
	{
		$getReport = $this->db->query("
			select clerical_homework.ID from config_emp
			INNER JOIN clerical_homework ON clerical_homework.subjectEmpID = config_emp.ID
			INNER JOIN row_level as row_levelClerical on row_levelClerical.ID = config_emp.RowLevelID
			WHERE clerical_homework.SchoolID ='".$schoolID."' 	AND clerical_homework.title !='' 
			AND row_levelClerical.Level_ID = IFNULL( ".$LevelID." , row_levelClerical.Level_ID  )
			AND row_levelClerical.ID = IFNULL( ".$RowLevelID." , row_levelClerical.ID  )
			AND clerical_homework.classID = IFNULL( ".$classID." , clerical_homework.classID  )
			AND config_emp.SubjectID = IFNULL( ".$subjectID." , config_emp.SubjectID  )
			group by clerical_homework.ID
		 ");
		 return (int)$getReport->num_rows();
	}
public function report_lesson_prep_school($schoolID,$LevelID,$RowLevelID,$classID,$subjectID)
	{
		$getReport = $this->db->query("
			select lesson_prep.ID from lesson_prep 
			inner join row_level as rowLavelPrep on rowLavelPrep.ID = lesson_prep.RowLevel_ID
			inner join contact on contact.ID = lesson_prep.Teacher_ID
			where contact.SchoolID='".$schoolID."' 
			AND rowLavelPrep.Level_ID = IFNULL( ".$LevelID." ,   rowLavelPrep.Level_ID )
            AND rowLavelPrep.ID = IFNULL( ".$RowLevelID." , rowLavelPrep.ID ) 
            AND lesson_prep.Subject_ID = IFNULL( ".$subjectID." , lesson_prep.Subject_ID )
			group by lesson_prep.ID 
			
		 ");
		 return (int)$getReport->num_rows();
	}
	public function report_homework_school($schoolID,$LevelID,$RowLevelID,$classID,$subjectID)
	{
		$getReport = $this->db->query("
		select test.ID from config_emp as config_emp1
		inner join test on test.Subject_emp_ID = config_emp1.ID
		INNER JOIN row_level as row_levelTest on row_levelTest.ID = config_emp1.RowLevelID
		inner join contact on contact.ID = config_emp1.EmpID
		where contact.SchoolID='".$schoolID."' AND test.type = 1 
		AND row_levelTest.Level_ID = IFNULL( ".$LevelID." ,   row_levelTest.Level_ID )
		AND row_levelTest.ID = IFNULL( ".$RowLevelID." , row_levelTest.ID )
		AND config_emp1.SubjectID = IFNULL( ".$subjectID." , config_emp1.SubjectID )
		group by test.ID 
		");
		 return (int)$getReport->num_rows();
	}
	public function report_test_school($schoolID,$LevelID,$RowLevelID,$classID,$subjectID)
	{
		$getReport = $this->db->query("
		select test.ID from config_emp as config_emp1
		inner join test on test.Subject_emp_ID = config_emp1.ID
		INNER JOIN row_level as row_levelTest on row_levelTest.ID = config_emp1.RowLevelID
		inner join contact on contact.ID = config_emp1.EmpID
		where contact.SchoolID='".$schoolID."' AND test.type = 0 
		AND row_levelTest.Level_ID =IFNULL( ".$LevelID." , row_levelTest.Level_ID ) 
		AND row_levelTest.ID = IFNULL( ".$RowLevelID." , row_levelTest.ID )
		AND config_emp1.SubjectID = IFNULL( ".$subjectID." , config_emp1.SubjectID )
		group by test.ID 
		");
		 return (int)$getReport->num_rows();
	}
	public function Subject_school($schoolID,$LevelID,$RowLevelID,$classID,$subjectID)
	{
		$getReport = $this->db->query("
			select GROUP_CONCAT(DISTINCT subject.Name) as allSub from class_table
			inner join subject on subject.ID = class_table.SubjectID
			where class_table.SchoolID = '".$schoolID."' 
            AND class_table.SubjectID = IFNULL( ".$subjectID." ,  class_table.SubjectID ) 
			group by class_table.SchoolID
		");
		return $getReport->row()->allSub;
	}
	public function rowLevel_school($schoolID,$LevelID,$RowLevelID,$classID,$subjectID)
	{
		$getReport = $this->db->query("
		select GROUP_CONCAT(DISTINCT CONCAT(row.Name , ' ' , level.Name) ) as allSub from class_table
		inner join row_level on row_level.ID = class_table.RowLevelID
		inner join row on row.ID = row_level.Row_ID
		inner join level on  level.ID = row_level.Level_ID
		where class_table.SchoolID = ".$schoolID."  
		AND row_level.ID = IFNULL( ".$RowLevelID." , row_level.ID  ) 
		AND row_level.Level_ID = IFNULL( ".$LevelID." , row_level.Level_ID )
		group by class_table.SchoolID and row_level.ID
		");
		return $getReport->row()->allSub;
	}
	
 }//////END CLASS 
?>