<?php
class Report_Student_Eval_Model extends CI_Model
{
	///////get_subject
	public function get_subject()
	{
		$Where  = array('Method'=>1,'Is_Active'=>1);
		$this->db->select('*');    
		$this->db->from('subject');
		$this->db->where($Where);
		
		$GetSubject = $this->db->get();			
		if($GetSubject->num_rows() >0)
		{return $GetSubject->result();}
		else{return FALSE ;}
	}
	
	//////get_emp
	public function get_emp()
	{
		$this->db->select('contact.ID    AS ContactID, contact.Name  AS ContactName');    
		$this->db->from('contact');
		$this->db->join('employee' , 'contact.ID = employee.Contact_ID');

		$GetEmp = $this->db->get();	
		if($GetEmp->num_rows()>0)
		{return $GetEmp->result();}
		else{ return FALSE ;}
	}
	
	////////get_data
	public function get_Data()
	{
		$this->db->select('students_evaluation.ID AS EvalID , 
						   students_evaluation.Absence AS EvalAbsence,
						   students_evaluation.PostsCount AS EvalPosts,
						   students_evaluation.TestMark AS TestMark,
						   students_evaluation.StudentID, students_evaluation.TeacherID, students_evaluation.SubjectID, students_evaluation.Lesson, 
						   students_evaluation.Date AS EvalDate,
						   student.Father_ID
						  ');
		$this->db->from('students_evaluation');
		$this->db->join('student' , 'student.Contact_ID = students_evaluation.StudentID');
		$this->db->order_by('Date', 'desc');
		
		$ResultData = $this->db->get();			
		$NumRowResultData  = $ResultData->num_rows() ; 
		if($NumRowResultData != 0)
		  {
				$ReturnData = $ResultData ->result() ;
				return $ReturnData ;
		  }
		  else
		  {
			  return $NumRowResultData ;
		  }
	}


public function get_student($Lang = NULL ,$SubID = "NULL" ,$EmpID ="NULL" ,$RowLevel = "NULL")
{
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
		students_evaluation.TeacherID,
		students_evaluation.SubjectID,
		students_evaluation.Lesson, 
		students_evaluation.Date AS EvalDate ,
		students_evaluation.PositiveID AS EvalPositiveID, 
		students_evaluation.NoteID AS EvalNoteID ,
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
	WHERE students_evaluation.SubjectID     = IFNULL($SubID,students_evaluation.SubjectID)
	AND   students_evaluation.TeacherID     = IFNULL($EmpID,students_evaluation.TeacherID)
	AND  row_level.ID                       = IFNULL($RowLevel,row_level.ID)
	GROUP BY students_evaluation.StudentID , students_evaluation.SubjectID 
	");
	if($query->num_rows()>0)
	{
	return $query->result();
}else{return false ;}
   }

	public function get_student_eval($StudentID,$subjectID,$RowLevelID)
	{
	
	$teacherID = $this->session->userdata('id');
	
	$Lang = $this->session->userdata('language');
	
	$NameArray = array("Level"=>"Name AS LevelName" ,"row"=>"Name AS RowName" , "class"=>"Name AS ClassName", "lesson"=>"lesson AS lessonName");
	if($Lang == "english")
	{
		$NameArray = array("Level"=>"Name_en AS LevelName" ,"row"=>" Name_en AS RowName" , "class"=>"Name_en AS ClassName", "lesson"=>"Lesson_en AS lessonName");
	}
	
	$query = $this->db->query("
	SELECT
		tb1.ID AS StudentID,
		tb1.Name AS StudentName,
		tb2.ID AS FatherID ,
		tb2.Name AS FatherName ,
		lesson_prep.Lesson_Title,
		tb1.Name AS FullName ,
		students_evaluation.ID AS EvalID , 
		students_evaluation.lesson_prepID AS lessonID ,
		students_evaluation.HomeDegree AS HomeDegree , 
		students_evaluation.Absence AS EvalAbsence,
		students_evaluation.PostsCount AS EvalPosts,
		students_evaluation.TestMark AS TestMark,
		students_evaluation.skills ,
		students_evaluation.Delay ,
		students_evaluation.skillsType ,
		students_evaluation.StudentID ,
		students_evaluation.MOreNote,
		students_evaluation.HomeDegree ,
		students_evaluation.StudentID AS StudentContactID, 
		students_evaluation.TeacherID, students_evaluation.SubjectID, students_evaluation.Lesson, 
		students_evaluation.Date AS EvalDate, 
		students_evaluation.PositiveID AS EvalPositiveID, 
		students_evaluation.NoteID AS EvalNoteID ,
		subject.Name AS subjectName ,
		subject.ID  AS subjectID ,
		student.R_L_ID AS R_L_ID ,
		student.Class_ID AS Class_ID ,
		tb3.Name AS TeacherName 
		
	FROM contact As tb1
	INNER JOIN student 				ON tb1.ID = student.Contact_ID
	INNER JOIN contact AS tb2 		ON student.Father_ID = tb2.ID
	INNER JOIN students_evaluation 	ON students_evaluation.StudentID = tb1.ID
	INNER JOIN contact AS tb3 		ON tb3.ID = students_evaluation.TeacherID
	INNER JOIN subject		 		ON subject.ID = students_evaluation.SubjectID
	left JOIN lesson_prep		    ON lesson_prep.ID = students_evaluation.lesson_prepID
	WHERE students_evaluation.StudentID = '".$StudentID."'
	AND students_evaluation.TeacherID = '".$teacherID."'
	AND subjectID = '".$subjectID."'
	AND R_L_ID = '".$RowLevelID."'
	AND ((students_evaluation.Delay IS NOT NULL AND students_evaluation.Absence = 0)
	
    OR  (students_evaluation.Absence =1 AND students_evaluation.Delay IS NULL))
	");
		if($query->num_rows()>0)
		{
			return $query->result();
		}else{return false ;}
	}
	
	public function get_itemName($ItemID)
	{
		$Lang = $this->session->userdata('language');
		if($Lang =='arabic')
		{
			$this->db->select('Name_ar AS ItemName');
			$this->db->from('students_evaluation_items');
			$this->db->where('ID' , $ItemID);
		}else
		{
			$this->db->select('Name_en AS ItemName');
			$this->db->from('students_evaluation_items');
			$this->db->where('ID' , $ItemID);
		}
		
		$ResultData = $this->db->get();			
		$NumRowResultData  = $ResultData->num_rows() ; 
		if($NumRowResultData != 0)
		  {
				$ReturnData = $ResultData ->row_array() ;
				return $ReturnData ;
		  }
		  else
		  {
			  return $NumRowResultData ;
		  }
	}
	
	public function get_EvalNum_old($StudentID)
	{
		$teacherID = $this->session->userdata('id');
		
		$this->db->select('*');
		$this->db->from('students_evaluation');
		$this->db->where('StudentID' , $StudentID);
		$this->db->where('TeacherID' , $teacherID );
		
		$ResultData = $this->db->get();
		$NumRowResultData  = $ResultData->num_rows() ; 
		return $NumRowResultData ;
	}
	
/////////////////////////

	public function get_EvalNum($StudentID,$subjectID)
	{
		$teacherID = $this->session->userdata('id');
		
		$query = $this->db->query("
	SELECT
	students_evaluation.*
		
	FROM contact As tb1
	INNER JOIN student 				ON tb1.ID = student.Contact_ID
	INNER JOIN contact AS tb2 		ON student.Father_ID = tb2.ID
	INNER JOIN students_evaluation 	ON students_evaluation.StudentID = tb1.ID
	INNER JOIN contact AS tb3 		ON tb3.ID = students_evaluation.TeacherID
	INNER JOIN subject		 		ON subject.ID = students_evaluation.SubjectID
	left JOIN lesson_prep		    ON lesson_prep.ID = students_evaluation.lesson_prepID
	WHERE students_evaluation.StudentID = '".$StudentID."'
	AND students_evaluation.TeacherID = '".$teacherID."'
	and students_evaluation.SubjectID='".$subjectID."'
	AND tb1.SchoolID = '".$this->session->userdata('SchoolID')."'
	AND ((students_evaluation.Delay IS NOT NULL AND students_evaluation.Absence = 0)
	
    OR  (students_evaluation.Absence =1 AND students_evaluation.Delay IS NULL))
	");
		$NumRowResultData  = $query->num_rows() ; 
		return $NumRowResultData ;
	}
	
public function get_teacher_student($Lang = NULL , $SubjectID = 0 , $RowLevelID = 0  )
{
	if($SubjectID == 0 )      {$SubjectID = 'NULL';}
	if($RowLevelID == 0 )      {$RowLevelID = 'NULL';}
	$teacherID = $this->session->userdata('id');
	
	$NameArray = array("Level"=>"Name AS LevelName" ,"row"=>"Name AS RowName" , "class"=>"Name AS ClassName");
	if($Lang == "english")
	{
		$NameArray = array("Level"=>"Name_en AS LevelName" ,"row"=>" Name_en AS RowName" , "class"=>"Name_en AS ClassName");
	}
	$query = $this->db->query("
	SELECT
		level.ID AS LevelID,
		row.ID AS RowID,
		subject.ID as subjectID,
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
		tb1.Name AS FullName ,
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
	INNER JOIN class_table          ON students_evaluation.TeacherID = class_table.EmpID
	WHERE students_evaluation.TeacherID = ".$teacherID."
	AND subject.ID   = IFNULL($SubjectID,subject.ID)
	AND row_level.ID = IFNULL($RowLevelID,row_level.ID)
	AND tb1.SchoolID = '".$this->session->userdata('SchoolID')."'
	AND tb1.Isactive = 1 
	AND ((students_evaluation.Delay IS NOT NULL AND students_evaluation.Absence = 0)
	
    OR  (students_evaluation.Absence =1 AND students_evaluation.Delay IS NULL))
	GROUP BY students_evaluation.StudentID
	");
	
	$NumData = $query->num_rows() ; 
	if($NumData >0)
	  {
		$ReturnData    = $query->result() ;
		return $ReturnData ; 
	  }else{ return $NumData ; }
	
   }	
	
	//get Choosen subjects
	public function get_rowlevel_name($RowLevelID = NULL)
	{
		$Lang = $this->session->userdata('language');
		if($Lang == 'arabic')
		{
			$this->db->select('row_level.Row_ID , row_level.Level_ID , 
						       row.Name AS RowName , level.Name AS LevelName
						      ');
			$this->db->from('row_level');
			$this->db->join('row', 'row.ID = row_level.Row_ID');
			$this->db->join('level', 'level.ID = row_level.Level_ID');
			$this->db->where('row_level.ID', $RowLevelID );
		}else{
				$this->db->select('row_level.Row_ID , row_level.Level_ID , 
						           row.Name_en AS RowName , level.Name_en AS LevelName
						          ');
				$this->db->from('row_level');
				$this->db->join('row', 'row.ID = row_level.Row_ID');
				$this->db->join('level', 'level.ID = row_level.Level_ID');
				$this->db->where('row_level.ID', $RowLevelID );
			 }
		$ResultRLName = $this->db->get();			
		$NumRLName = $ResultRLName->num_rows() ; 
			if($NumRLName >0)
			  {
				$ReturnRLName    = $ResultRLName->row_array() ;
			    return $ReturnRLName ; 
			  }else{ return $NumRLName ; return FALSE ;}
	}////////////////////////
	public function get_StuData($StudentID = 0 )
	{
		$query = $this->db->query("
		SELECT
		(SELECT COUNT(PositiveID) FROM students_evaluation WHERE PositiveID !=0  AND StudentID = ".$StudentID." ) AS CountPositiveID ,
		(SELECT COUNT(NoteID)     FROM students_evaluation WHERE NoteID     !=0  AND StudentID = ".$StudentID.")  AS CountNoteID ,
		(SELECT COUNT(ID)         FROM students_evaluation WHERE StudentID = ".$StudentID.")  AS CountAll 
		");
		return $query->row_array();
	}
	////////////////////
	public function dele_studentpage($id)
	{
        $this->db->query("
		delete  FROM students_evaluation where ID=".$id."
		");
	}
 }///////////////////END MODEL
?>