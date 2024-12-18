<?php
class Cpanel_Model extends CI_Model{
	
		private $Date            = '' ;
	private $Encryptkey      = '' ;
	private $Token      	 = '' ;
	
	function __construct()
	{
		parent::__construct();
// 		$this->Date       = date('Y-m-d H:i:s');
// 		$this->Encryptkey = $this->config->item('encryption_key');
// 		$this->Token      = $this->get_token();
	}
	public function get_student_lessons_dashboard_student ($RowLevelID,$Class_ID)
	{
	    $schoolid=(int)$this->session->userdata('SchoolID');
	    $date=date("Y-m-d", strtotime("-10 days"));
	    $date1=date("Y-m-d");

		$idContact = (int)$this->session->userdata('id');
         $where=(" NOT EXISTS (SELECT * FROM   lesson_report
                  WHERE  lesson_prep.ID=lesson_report.lesson_id and student.Contact_ID=lesson_report.student_id ) ");
		$this->db->select('lesson_prep.ID AS LessonID, lesson_prep.Lesson_Title AS LessonTitle ,lesson_prep.startDate AS LessonDate , lesson_prep.Token AS LessonToken');
		$this->db->from('lesson_prep');
		 $this->db->join('class_table', ' lesson_prep.RowLevel_ID=class_table.RowLevelID  and  lesson_prep.Subject_ID=class_table.SubjectID	 and lesson_prep.Teacher_ID=class_table.EmpID  ', 'INNER');
		 $this->db->join('student', ' class_table.ClassID = student.Class_ID ', 'INNER');
		$this->db->where('lesson_prep.RowLevel_ID', $RowLevelID );
		$this->db->where('lesson_prep.School_ID', (int)$this->session->userdata('SchoolID'));
		$this->db->where("lesson_prep.startDate >= '$date' "  ); 
		$this->db->where("lesson_prep.startDate <= '$date1' "  );
		$this->db->where($where);
		$this->db->where('student.Contact_ID',$idContact);
		$this->db->where("(class_table.ClassID = $Class_ID OR class_table.special_st = 1)");
		$this->db->where("lesson_prep.classID REGEXP $Class_ID");
		$this->db->group_by('lesson_prep.ID', 'DESC');
		$ResultLessons = $this->db->get();			
		$NumRowResultLessons  = $ResultLessons->num_rows() ; 
 		if($NumRowResultLessons != 0)
		  {
				$ReturnLessons = $ResultLessons ->result() ;
				return $ReturnLessons ;
		  }
		  else
		  {
			  return 0 ;
			  return false ;
		  }
		 
	}
		public function get_student_lessons_dashboard_student_count($RowLevelID,$Class_ID)
	{
	    $schoolid=(int)$this->session->userdata('SchoolID');
	    $date=date("Y-m-d", strtotime("-10 days"));
	    $date1=date("Y-m-d");

		$idContact = (int)$this->session->userdata('id');

		  $query=	$this->db->query(" select count(LessonID) AS less_count from (
		  SELECT 
		  lesson_prep.ID AS LessonID
		  FROM lesson_prep 
		  INNER JOIN class_table ON lesson_prep.RowLevel_ID=class_table.RowLevelID and lesson_prep.Subject_ID=class_table.SubjectID and lesson_prep.Teacher_ID=class_table.EmpID 
		  INNER JOIN student ON class_table.ClassID = student.Class_ID 
		  WHERE 
		   lesson_prep.RowLevel_ID = $RowLevelID
		   AND lesson_prep.School_ID = $schoolid
		   AND lesson_prep.startDate >= '$date' 
		   AND lesson_prep.startDate <= '$date1' 
		   AND NOT EXISTS (SELECT * FROM lesson_report WHERE lesson_prep.ID=lesson_report.lesson_id and student.Contact_ID = lesson_report.student_id ) 
		   AND student.Contact_ID = $idContact
		   AND (class_table.ClassID = $Class_ID OR class_table.special_st = 1)
		   AND lesson_prep.classID REGEXP $Class_ID 
		   GROUP BY lesson_prep.ID) as le
		  ");
  if($query->num_rows()>0){$Result = $query->result() ;return $Result ;}else{return 0;}
	}
	///////////////////////////
	public function get_exams_header_new($Lang,$R_L_ID,$Class_ID)
	 {
	$date=date("Y-m-d", strtotime("-10 days"));
    $date1=date("Y-m-d H:i:s");
    $idContact = (int)$this->session->userdata('id');
	$query=	$this->db->query(" select test.ID AS test_ID , test.Name AS test_Name, test.empID AS teacher_Name, test.Description As test_Description, test.time_count AS time_count ,test.date_from AS date_from , test.date_to AS date_to, test.num_student as num_student
	from contact
	inner join student on student.Contact_ID = contact.ID
	inner join class_table on class_table.RowLevelID = student.R_L_ID and class_table.ClassID = student.Class_ID
	inner join test on test.empID = class_table.EmpID and test.RowLevelID	=  student.R_L_ID
	inner join test_questions on test.ID = test_questions.Test_ID
	where
	test.IsActive=1 and test.type=0 and test.is_deleted=0 and test.RowLevelID=$R_L_ID
	and student.Contact_ID=$idContact
	AND NOT EXISTS (SELECT * FROM test_student WHERE test.ID=test_student.test_id and student.Contact_ID=test_student.Contact_ID )
	and test.classID REGEXP $Class_ID and test.SchoolId=".(int)$this->session->userdata('SchoolID')." and '$date'<=DATE(test.date_to) 
    group by test.ID
	");
   if($query->num_rows()>0){$Result = $query->result() ;return $Result ;}else{return 0;}


		
	}
		public function get_exams_header_new_count($Lang,$R_L_ID,$Class_ID)
	 {
         $date=date("Y-m-d", strtotime("-10 days"));
         

         $idContact = (int)$this->session->userdata('id');
	$query=	$this->db->query(" select count(test_ID) as count_exam
	from 
	(select test.ID AS test_ID 	from contact
	inner join student on student.Contact_ID = contact.ID
	inner join class_table on class_table.RowLevelID = student.R_L_ID and class_table.ClassID = student.Class_ID
	inner join test on test.empID = class_table.EmpID and test.RowLevelID	=  student.R_L_ID
	inner join test_questions on test.ID = test_questions.Test_ID
	where
	test.IsActive=1 and test.type=0 and test.is_deleted=0 and test.RowLevelID=$R_L_ID
	and student.Contact_ID=$idContact
	AND NOT EXISTS (SELECT * FROM test_student WHERE test.ID=test_student.test_id and student.Contact_ID=test_student.Contact_ID )
	and test.classID REGEXP $Class_ID and test.SchoolId=".(int)$this->session->userdata('SchoolID')." and '$date'<=DATE(test.date_to) 
    group by test.ID) as e
	");
   if($query->num_rows()>0){$Result = $query->result() ;return $Result ;}else{return 0;}


		
	}
	//////////////////
	public function get_clerical_homework_new($R_L_ID,$Class_ID)
	{
	    $schoolid=(int)$this->session->userdata('SchoolID');
	    $date=date("Y-m-d", strtotime("-10 days"));
	    $date1=date("Y-m-d");
		$idContact = (int)$this->session->userdata('id');
	 $where=(" NOT EXISTS (SELECT * FROM   clerical_homework_answer
                  WHERE  homework.ID=clerical_homework_answer.homework_id and student.Contact_ID=clerical_homework_answer.contact_idst ) ");
	
 			$this->db->select('homework.ID,homework.title,homework.content,config_emp.EmpID AS EmpID ,homework.attach,homework.date_homework,homework.token,contact.Name as emp,subject.ID as subjectid,subject.Name as subject');
			$this->db->from('student');
            $this->db->join('class_table','class_table.ClassID = student.Class_ID and student.R_L_ID = class_table.RowLevelID');
			$this->db->join('config_emp' ,' class_table.EmpID = config_emp.EmpID  and config_emp.SubjectID = class_table.SubjectID  and config_emp.RowLevelID = class_table.RowLevelID');
			$this->db->join('clerical_homework as homework','homework.subjectEmpID = config_emp.ID and homework.classID = student.Class_ID');
			
			$this->db->join('base_class_table','base_class_table.ID = class_table.BaseTableID');
			$this->db->join('contact','class_table.EmpID = contact.ID');
 
		
			$this->db->join('subject','subject.ID = class_table.SubjectID');
			$this->db->where('contact.SchoolID',(int)$this->session->userdata('SchoolID') );

 			$this->db->where('student.Contact_ID',$idContact);
 			$this->db->where('homework.RowLevelID',$R_L_ID);
 			$this->db->where("homework.classID REGEXP $Class_ID");
 			$this->db->where("DATE(date_homework) >= '$date'");
 			$this->db->where("DATE(date_homework) <= '$date1'");
 			$this->db->where($where);
		    $this->db->where('class_table.SchoolID', (int)$this->session->userdata('SchoolID'));
			$this->db->order_by('homework.Date','DESC');
			$this->db->group_by('homework.ID');
			$Result = $this->db->get();
			if($Result->num_rows()>0)
			{
				$ReturnResult = $Result->result() ;
				return $ReturnResult ;
			}else{
				return 0 ;
			}
}
	
		public function get_clerical_homework_new_count($R_L_ID,$Class_ID)
	{
	    $schoolid=(int)$this->session->userdata('SchoolID');
	    $date=date("Y-m-d", strtotime("-10 days"));
	    $date1=date("Y-m-d");
		$idContact = (int)$this->session->userdata('id');
					$query=	$this->db->query(" select count(ID)AS cler_count from(
			SELECT 
			homework.ID AS ID
			FROM student 
			JOIN class_table ON class_table.ClassID = student.Class_ID and student.R_L_ID = class_table.RowLevelID 
			JOIN config_emp ON class_table.EmpID = config_emp.EmpID and config_emp.SubjectID = class_table.SubjectID and config_emp.RowLevelID = class_table.RowLevelID 
			JOIN clerical_homework as homework ON homework.subjectEmpID = config_emp.ID and homework.classID = student.Class_ID 
			JOIN base_class_table ON base_class_table.ID = class_table.BaseTableID 
			JOIN contact ON class_table.EmpID = contact.ID 
			JOIN subject ON subject.ID = class_table.SubjectID 
			WHERE contact.SchoolID = $schoolid 
			AND student.Contact_ID = $idContact
			AND homework.RowLevelID = $R_L_ID 
			AND homework.classID REGEXP $Class_ID 
			AND DATE(date_homework) >= '$date'
			AND DATE(date_homework) <= '$date1' 
			AND NOT EXISTS (SELECT * FROM clerical_homework_answer WHERE homework.ID=clerical_homework_answer.homework_id and student.Contact_ID = clerical_homework_answer.contact_idst ) 
			AND class_table.SchoolID = $schoolid
			GROUP BY homework.ID 
			ORDER BY homework.Date DESC) as c
			");
 if($query->num_rows()>0){$Result = $query->result() ;return $Result ;}else{return 0;} 
	}
	/////////////////////////
	public function get_homework_new($R_L_ID,$Class_ID)
	 {
         $date=date("Y-m-d", strtotime("-10 days"));
         $date1=date("Y-m-d");
         $idContact = (int)$this->session->userdata('id');
	$query=	$this->db->query(" select test.ID AS test_ID , test.Name AS test_Name, T.Name AS teacher_Name, test.Description As test_Description, test.time_count AS time_count ,test.date_from AS date_from , test.date_to AS date_to, test.num_student as num_student
	from contact
	inner join student on student.Contact_ID = contact.ID
	inner join class_table on class_table.RowLevelID = student.R_L_ID and class_table.ClassID = student.Class_ID
	inner join test on test.empID = class_table.EmpID and test.RowLevelID	=  student.R_L_ID  
	inner join contact AS T on T.ID = test.empID
	inner join test_questions on test.ID = test_questions.Test_ID
	where
	test.IsActive=1 and test.type=1 and test.is_deleted=0 and test.RowLevelID=$R_L_ID
	and student.Contact_ID=$idContact
	AND NOT EXISTS (SELECT * FROM test_student WHERE test.ID=test_student.test_id and student.Contact_ID=test_student.Contact_ID )
	and test.classID REGEXP $Class_ID and test.SchoolId=".(int)$this->session->userdata('SchoolID')." and '$date'<=DATE(test.date_to) 
    group by test.ID
	");
 if($query->num_rows()>0){$Result = $query->result() ;return $Result ;}else{return 0;} 


		
	}
	public function get_homework_new_count($Lang,$R_L_ID,$Class_ID)
	 {
         $date=date("Y-m-d", strtotime("-10 days"));
         $idContact = (int)$this->session->userdata('id');
	$query=	$this->db->query(" select count(test_ID) as count_homework
	from 
	(select test.ID AS test_ID 	from contact
	inner join student on student.Contact_ID = contact.ID
	inner join class_table on class_table.RowLevelID = student.R_L_ID and class_table.ClassID = student.Class_ID
	inner join test on test.empID = class_table.EmpID and test.RowLevelID	=  student.R_L_ID
	inner join test_questions on test.ID = test_questions.Test_ID
	where
	test.IsActive=1 and test.type=1 and test.is_deleted=0 and test.RowLevelID=$R_L_ID
	and student.Contact_ID=$idContact
	AND NOT EXISTS (SELECT * FROM test_student WHERE test.ID=test_student.test_id and student.Contact_ID=test_student.Contact_ID )
	and test.classID REGEXP $Class_ID and test.SchoolId=".(int)$this->session->userdata('SchoolID')." and  '$date'<= DATE(test.date_to) 
    group by test.ID) as h
	");
 if($query->num_rows()>0){$Result = $query->result() ;return $Result ;}else{return 0;} 


		
	}
	///////////////////////
	public function get_e_library_dashbored_student($R_L_ID,$Class_ID)
	{
	    $date=date("Y-m-d", strtotime("-10 days"));
	    $date1=date("Y-m-d");
	    $idContact = (int)$this->session->userdata('id');
		 $query = $this->db->query("  SELECT
		  contact.ID          AS ContactID , 
		  contact.SchoolID    AS SchoolID , 
          e_library.ID        AS FileID ,
          e_library.Type      AS FileType ,
          e_library.Title     AS FileTitle ,
          e_library.File_url  AS FileUrl ,
		  e_library.link_youtube AS link_youtube ,
          e_library.Downloads AS Downloads ,
		  e_library.Stm_Date  AS FileDate , 
		  e_library.lessonID  AS lessonID, 
		  contact.Name        AS ContactName ,
		  subject.Name        AS SubjectName ,
		  school_details.SchoolName AS SchoolName
          FROM e_library 
		  INNER JOIN contact ON e_library.ContactID = contact.ID 
		  INNER JOIN subject ON subject.ID = e_library.SubjectID
		  INNER JOIN class_table ON  e_library.RowLevelID = class_table.RowLevelID AND e_library.SubjectID = class_table.SubjectID
		  INNER JOIN student ON e_library.RowLevelID = student.R_L_ID	and class_table.ClassID = student.Class_ID 
		  INNER JOIN school_details ON contact.SchoolID = school_details.ID
          where 
          e_library.RowLevelID        = $R_L_ID
          AND class_table.ClassID     = $Class_ID 
		  AND DATE(e_library.Stm_Date)     >= '$date'
		   AND DATE(e_library.Stm_Date)     <= '$date1'
		  and NOT EXISTS (SELECT * FROM   revision_report
          WHERE  e_library.ID=revision_report.lesson_id and student.Contact_ID=revision_report.student_id  )
		  and student.Contact_ID   =$idContact
          AND contact.SchoolID        = ".$this->session->userdata('SchoolID')."
          AND e_library.ClassID REGEXP $Class_ID
          GROUP BY e_library.ID
		  ORDER BY e_library.ID DESC
		  ");
	      $NumRowResultLib  = $query->num_rows() ;
		 if($NumRowResultLib > 0)
		  {
				$ReturnLib = $query->result() ;
				return $ReturnLib ;
		  }
		  else
		  {
			  return false ;
		  }
	
	}
    public function get_e_library_dashbored_student_count($R_L_ID,$Class_ID)
	{
	    $date=date("Y-m-d", strtotime("-10 days"));
	    $date1=date("Y-m-d");
	    $idContact = (int)$this->session->userdata('id');
		 $query = $this->db->query(" SELECT count(FileID) as e_lib_count    FROM ( SELECT
		  e_library.ID        AS FileID
          FROM e_library 
		  INNER JOIN contact ON e_library.ContactID = contact.ID 
		  INNER JOIN subject ON subject.ID = e_library.SubjectID
		  INNER JOIN class_table ON  e_library.RowLevelID = class_table.RowLevelID AND e_library.SubjectID = class_table.SubjectID
		  INNER JOIN student ON e_library.RowLevelID = student.R_L_ID	and class_table.ClassID = student.Class_ID 
		  INNER JOIN school_details ON contact.SchoolID = school_details.ID
          where 
          e_library.RowLevelID        = $R_L_ID
          AND class_table.ClassID     = $Class_ID 
		  AND DATE(e_library.Stm_Date)     >= '$date'
		   AND DATE(e_library.Stm_Date)     <= '$date1'
		  and NOT EXISTS (SELECT * FROM   revision_report
          WHERE  e_library.ID=revision_report.lesson_id and student.Contact_ID=revision_report.student_id  )
		  and student.Contact_ID   =$idContact
          AND contact.SchoolID        = ".$this->session->userdata('SchoolID')."
          AND e_library.ClassID REGEXP $Class_ID
          GROUP BY e_library.ID
		  ORDER BY e_library.ID DESC)AS E
		  ");
	      $NumRowResultLib  = $query->num_rows() ;
		 if($NumRowResultLib > 0)
		  {
				$ReturnLib = $query->result() ;
				return $ReturnLib ;
		  }
		  else
		  {
			  return false ;
		  }
	
	}
	public function get_ZOOM_student_count($R_L_ID)
	{
	$ID=(int)$this->session->userdata('id');
	$date=date("Y-m-d");
    $query=	$this->db->query("
	SELECT COUNT(zoom_meetings.id) AS zoom_count 
	FROM zoom_meetings INNER 
	JOIN Zoom_Details on Zoom_Details.Group_ID=zoom_meetings.group_id 
	WHERE FIND_IN_SET($ID,Zoom_Details.Contact_ID) 
	AND RowLevele_ID = $R_L_ID 
	AND start_time LIKE '%$date%' 
    AND is_deleted=0
    ");
    if($query->num_rows()>0){$Result = $query->result() ;return $Result ;}else{return 0;} 
	}
 
}//Class
?>