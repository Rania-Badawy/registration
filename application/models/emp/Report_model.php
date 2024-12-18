<?php
class Report_Model  extends CI_Model 
 {
	private $Date='',$Encryptkey='',$Token='';
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
	}////////////////////////get_report_eval
	public function get_report_eval($ID = 0 ,$YearID = 0  ,$Lang = NULL, $SemesterID)
	{
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
		COUNT(emp_evaluation.ID) AS nameeval,
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
			LEFT JOIN evaluation_note ON emp_evaluation.noteID           = evaluation_note.ID 
			LEFT JOIN evaluation_elements ON evaluation_note.elementID   = evaluation_elements.ID 
		WHERE emp_evaluation.EmpID = ".$ID."
		 AND emp_evaluation.semesterID = $SemesterID
		AND  emp_evaluation.YearID = ".$YearID."
		group by contact.ID , emp_evaluation.date 
		 order by emp_evaluation.date desc
		");
		if($query->num_rows()>0)
		{
			return $query->result() ;
		}else{return FALSE ;}
	}
	public function get_report_eval1($YearID ,$ContactEmpID,$datee)
	{
	    //print_r($EmpPer);die;
		$query = $this->db->query("
		SELECT
		emp_evaluation.Degree    AS EmpDegree ,
		emp_evaluation.date      AS EvaluationDateStm,
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
		WHERE  emp_evaluation.YearID = ".$YearID."
		AND  contact.Isactive = 1
		 AND contactEmp.ID =".$ContactEmpID."
		
		 AND emp_evaluation.date  LIKE '%$datee%'
		");
		if($query->num_rows()>0)
		{
			return $query->result() ;
		}else{return FALSE ;}
	}
	///////////////////////////////////
	  public function exam_report( $level_id = 0 , $from = 0 , $to = 0, $subjectID =0)
    {  
 	if($level_id == 0 )   {$level_id = 'NULL' ; }
 	if($subjectID == 0 )   {$subjectID = 'NULL' ; }
 	if($from != 0 && $to != 0){
 		$where = "  AND 
		date(test.date_from)  BETWEEN '$from'  AND '$to'  ";
 	}
	$query = $this->db->query("
	SELECT qc.SumDegreeQ,subject.Name AS subject_Name,contact.Name AS teacherName,test.* ,row_level.Level_Name  ,row_level.Row_Name
	    FROM test
               
        right  JOIN (SELECT SUM(Degree)AS SumDegreeQ,test_id
        FROM questions_content
        GROUP BY test_id) qc ON qc.test_id =  test.ID 
        INNER JOIN subject ON subject.ID=test.subject_id
        INNER JOIN contact ON contact.ID = test.empID
 	    INNER JOIN row_level ON test.RowLevelID = row_level.ID
	    INNER JOIN class_table ON class_table.EmpID = contact.ID AND class_table.RowLevelID = row_level.ID AND class_table.SubjectID = subject.ID
	    WHERE 
	    test.empID          = '". $this->session->userdata('id')."'
	    AND test.type       = 0 
	    AND test.is_deleted = 0
	    AND test.IsActive = 1
	    AND  row_level.Level_ID = IFNULL($level_id , row_level.Level_ID)
	    AND test.subject_id = IFNULL($subjectID , test.subject_id)
	    $where 
	    group by test.ID
	    ORDER BY test.ID ");
	if($query->num_rows() > 0 ){return $query->result();}else{return FALSE;}
 }
 ///////////////////////////////////
  public function homework_report( $level_id = 0 , $from = 0 , $to = 0 ,$subjectID =0,$student_name ='',$hw_name=0)
 {  
     
 	if($level_id == 0 )   {$level_id = 'NULL' ; }
 	if($subjectID == 0 )   {$subjectID = 'NULL' ; }
 	if($from != 0 && $to != 0){
 		$where = "  AND 
		date(test.date_from)  BETWEEN '$from'  AND '$to'  ";
 	}
	$query = $this->db->query("
	SELECT qc.SumDegreeQ,subject.Name AS subject_Name,contact.Name AS teacherName,test.* ,row_level.Level_Name  ,row_level.Row_Name
	    FROM test
               
        RIGHT  JOIN (SELECT SUM(Degree)AS SumDegreeQ,test_id
        FROM questions_content
        GROUP BY test_id) qc ON qc.test_id =  test.ID 
        INNER JOIN subject ON subject.ID=test.subject_id
        INNER JOIN contact ON contact.ID = test.empID
 	    INNER JOIN row_level ON test.RowLevelID = row_level.ID
	    INNER JOIN class_table ON class_table.EmpID = contact.ID AND class_table.RowLevelID = row_level.ID AND class_table.SubjectID = subject.ID
	    WHERE 
	    test.empID           = '". $this->session->userdata('id')."'
	    AND test.type       = 1
	    AND test.is_deleted = 0
    	AND row_level.Level_ID = IFNULL($level_id , row_level.Level_ID)
	    AND test.subject_id = IFNULL($subjectID , test.subject_id)
    	$where
    	group by test.ID
	    ORDER BY test.ID ");
	if($query->num_rows() > 0 ){return $query->result();}else{return FALSE ; }
    }
    //////////////////////////
    public function exam_report_detils( $LevelID = 0 , $from = 0 , $to = 0, $num =0 ,$subjectID =0,$test =0)
 {
	$query = $this->db->query("
WITH cte_exam (test_id, test_name, test_type, teacher_id, teacher_name, subject_id, subject_name, semester_id, semester_name, specific_students, school_id, row_level_id, class_id)
AS
(SELECT
      test.ID AS test_id,
      test.Name AS test_name,
      test.type AS test_type,
      test.empID AS teacher_id,
      teacher.Name AS teacher_name,
      test.subject_id AS subject_id,
      subject.Name AS subject_Name,
      test.config_semester_ID AS semester_id,
      config_semester.Name AS semester_name,
      test.students AS specific_students,
      test.SchoolId AS school_id,
      test.RowLevelID AS row_level_id,
      test.classID AS class_id
    FROM test
      INNER JOIN contact AS teacher
        ON test.empID = teacher.ID
      INNER JOIN config_semester
        ON test.config_semester_ID = config_semester.ID
      INNER JOIN subject
        ON test.subject_id = subject.ID
    WHERE test.ID = 5987
    AND test.IsActive != 0
    AND test.is_deleted != 1),
cte_exam_questions (test_id, question_id, question, question_type_id, question_degree, question_type_name, question_answer, question_answer_match, question_answer_order_number)
AS
(SELECT
      cte_exam.test_id,
      questions_content.ID AS question_id,
      questions_content.question AS question,
      questions_content.questions_types_ID AS question_type_id,
      answers.Degree AS question_degree,
      questions_types.Name AS question_type_name,
      answers.Answer AS question_answer,
      answers.Answer_match AS question_answer_match,
      ROW_NUMBER() OVER (PARTITION BY answers.Questions_Content_ID ORDER BY answers.ID) AS question_answer_order_number
    FROM cte_exam
      INNER JOIN questions_content
        ON cte_exam.test_id = questions_content.test_id
      INNER JOIN questions_types
        ON questions_types.ID = questions_content.questions_types_ID
      INNER JOIN answers
        ON questions_content.ID = answers.Questions_Content_ID
        AND answers.Answer_correct = 1
    WHERE questions_content.IsActive != 0),

cte_exam_students (test_id, student_id, student_name)
AS
(SELECT DISTINCT
      cte_exam.test_id,
      contact.ID AS student_id,
      contact.Name AS student_name
    FROM cte_exam
      INNER JOIN student
        ON FIND_IN_SET(student.R_L_ID, cte_exam.row_level_id) != 0
        AND FIND_IN_SET(student.Class_ID, cte_exam.class_id) != 0
        AND (cte_exam.specific_students IS NULL
        OR cte_exam.specific_students = ''
        OR FIND_IN_SET(student.Contact_ID, cte_exam.specific_students) != 0)
      INNER JOIN contact
        ON student.Contact_ID = contact.ID
        AND contact.SchoolID = cte_exam.school_id
      INNER JOIN class_table
        ON student.Class_ID = class_table.ClassID
        AND student.R_L_ID = class_table.RowLevelID
        AND contact.SchoolID = class_table.SchoolID
        AND FIND_IN_SET(class_table.SubjectID, cte_exam.subject_id) != 0
      INNER JOIN subject
        ON FIND_IN_SET(subject.ID, cte_exam.subject_id) != 0
        AND (subject.basic = 1
        OR FIND_IN_SET(cte_exam.subject_id, student.s_language) <> 0)
    WHERE contact.Isactive = 1)

-- >> سؤال التوصيل
SELECT DISTINCT
  cte_exam.test_id,
  cte_exam.test_name,
  cte_exam.subject_name,
  cte_exam.semester_name,
  cte_exam.teacher_name,
  cte_exam_questions.question_answer_match AS question,
  cte_exam_questions.question_degree,
  cte_exam_questions.question_type_id,
  cte_exam_questions.question_type_name,
  cte_exam_questions.question_answer,
  cte_exam_students.student_id,
  cte_exam_students.student_name,
  answers.Answer AS student_answer,
  test_student.Degree AS student_answer_degree,
  test_student.Inserted_At AS student_answer_date,
  test_student.is_updated AS is_updated,
  test_student.is_updated_date AS stu_date_updated
FROM cte_exam
  INNER JOIN cte_exam_questions
    ON cte_exam.test_id = cte_exam_questions.test_id
  INNER JOIN cte_exam_students
    ON cte_exam.test_id = cte_exam_students.test_id
  INNER JOIN test_student
    ON test_student.ID = (SELECT
      DISTINCT
        test_student.ID
      FROM test_student
        INNER JOIN (SELECT
            ID,
            Contact_ID,
            questions_content_ID,
            ROW_NUMBER() OVER (PARTITION BY Contact_ID, questions_content_ID ORDER BY test_student.ID) AS student_answer_order_number
          FROM test_student) AS T
          ON T.ID = test_student.ID
      WHERE T.questions_content_ID = cte_exam_questions.question_id
      AND T.Contact_ID = cte_exam_students.student_id
      AND T.student_answer_order_number = cte_exam_questions.question_answer_order_number
      AND cte_exam_questions.question_type_id IN (7)
      LIMIT 1)
  INNER JOIN answers
    ON test_student.answer_content = answers.ID
    AND test_student.questions_content_ID = answers.Questions_Content_ID



UNION ALL
-- >> أختر أكثر من إجابة 
SELECT DISTINCT
  cte_exam.test_id,
  cte_exam.test_name,
  cte_exam.subject_name,
  cte_exam.semester_name,
  cte_exam.teacher_name,
  cte_exam_questions.question,
  cte_exam_questions.question_degree,
cte_exam_questions.question_type_id,
  cte_exam_questions.question_type_name,
  cte_exam_questions.question_answer,
  cte_exam_students.student_id,
  cte_exam_students.student_name,
  answers.Answer AS student_answer,
  test_student.Degree AS student_answer_degree,
  test_student.Inserted_At AS student_answer_date,
  test_student.is_updated AS is_updated,
  test_student.is_updated_date AS stu_date_updated
FROM cte_exam
  INNER JOIN cte_exam_questions
    ON cte_exam.test_id = cte_exam_questions.test_id
  INNER JOIN cte_exam_students
    ON cte_exam.test_id = cte_exam_students.test_id
  INNER JOIN test_student
    ON test_student.ID = (SELECT
      DISTINCT
        test_student.ID
      FROM test_student
        INNER JOIN (SELECT
            ID,
            Contact_ID,
            questions_content_ID,
            ROW_NUMBER() OVER (PARTITION BY Contact_ID, questions_content_ID ORDER BY test_student.ID) AS student_answer_order_number
          FROM test_student) AS T
          ON T.ID = test_student.ID
      WHERE T.questions_content_ID = cte_exam_questions.question_id
      AND T.Contact_ID = cte_exam_students.student_id
      AND T.student_answer_order_number = cte_exam_questions.question_answer_order_number
      AND cte_exam_questions.question_type_id IN (2)
      LIMIT 1)
  INNER JOIN answers
    ON test_student.answer_content = answers.ID
    AND test_student.questions_content_ID = answers.Questions_Content_ID



UNION ALL
-- >>  صح أم خطأ
SELECT DISTINCT
  cte_exam.test_id,
  cte_exam.test_name,
  cte_exam.subject_name,
  cte_exam.semester_name,
  cte_exam.teacher_name,
  cte_exam_questions.question,
  cte_exam_questions.question_degree,
cte_exam_questions.question_type_id,
  cte_exam_questions.question_type_name,
  cte_exam_questions.question_answer,
  cte_exam_students.student_id,
  cte_exam_students.student_name,
  answers.Answer AS student_answer,
  test_student.Degree AS student_answer_degree,
  test_student.Inserted_At AS student_answer_date,
  test_student.is_updated AS is_updated,
  test_student.is_updated_date AS stu_date_updated
FROM cte_exam
  INNER JOIN cte_exam_questions
    ON cte_exam.test_id = cte_exam_questions.test_id
  INNER JOIN cte_exam_students
    ON cte_exam.test_id = cte_exam_students.test_id
  INNER JOIN test_student
    ON question_id = test_student.questions_content_ID
    AND cte_exam_students.student_id = test_student.Contact_ID
  INNER JOIN answers
    ON test_student.answer_content = answers.ID
    AND test_student.questions_content_ID = answers.Questions_Content_ID
WHERE cte_exam_questions.question_type_id IN (3)


UNION ALL
-- >>  رفع السؤال والإجابة + الرسم
SELECT DISTINCT
  cte_exam.test_id,
  cte_exam.test_name,
  cte_exam.subject_name,
  cte_exam.semester_name,
  cte_exam.teacher_name,
  cte_exam_questions.question,
  cte_exam_questions.question_degree,
cte_exam_questions.question_type_id,
  cte_exam_questions.question_type_name,
  cte_exam_questions.question_answer,
  cte_exam_students.student_id,
  cte_exam_students.student_name,
  test_student.answer_content AS student_answer,
  test_student.Degree AS student_answer_degree,
  test_student.Inserted_At AS student_answer_date,
  test_student.is_updated AS is_updated,
  test_student.is_updated_date AS stu_date_updated
FROM cte_exam
  INNER JOIN cte_exam_questions
    ON cte_exam.test_id = cte_exam_questions.test_id
  INNER JOIN cte_exam_students
    ON cte_exam.test_id = cte_exam_students.test_id
  INNER JOIN test_student
    ON question_id = test_student.questions_content_ID
    AND cte_exam_students.student_id = test_student.Contact_ID
WHERE cte_exam_questions.question_type_id IN (6, 8)

UNION ALL
-- >> سؤال أكمل
SELECT DISTINCT
  cte_exam.test_id,
  cte_exam.test_name,
  cte_exam.subject_name,
  cte_exam.semester_name,
  cte_exam.teacher_name,
  cte_exam_questions.question,
  cte_exam_questions.question_degree,
cte_exam_questions.question_type_id,
  cte_exam_questions.question_type_name,
  cte_exam_questions.question_answer,
  cte_exam_students.student_id,
  cte_exam_students.student_name,
  test_student.answer_content AS student_answer,
  test_student.Degree AS student_answer_degree,
  test_student.Inserted_At AS student_answer_date,
  test_student.is_updated AS is_updated,
  test_student.is_updated_date AS stu_date_updated
FROM cte_exam
  INNER JOIN cte_exam_questions
    ON cte_exam.test_id = cte_exam_questions.test_id
  INNER JOIN cte_exam_students
    ON cte_exam.test_id = cte_exam_students.test_id
  INNER JOIN test_student
    ON test_student.ID = (SELECT
      DISTINCT
        test_student.ID
      FROM test_student
        INNER JOIN (SELECT
            ID,
            Contact_ID,
            questions_content_ID,
            ROW_NUMBER() OVER (PARTITION BY Contact_ID, questions_content_ID ORDER BY test_student.ID) AS student_answer_order_number
          FROM test_student) AS T
          ON T.ID = test_student.ID
      WHERE T.questions_content_ID = cte_exam_questions.question_id
      AND T.Contact_ID = cte_exam_students.student_id
      AND T.student_answer_order_number = cte_exam_questions.question_answer_order_number
      AND cte_exam_questions.question_type_id IN (4)
      LIMIT 1) ");
	if($query->num_rows() > 0 ){return $query->result();}else{return FALSE ; }
 }
 ////////////////////////////////////
    public function get_emp_row_level($Lang = NULL , $UID = 0)
	{
	  	if($Lang == 'arabic')
		{
			$query = $this->db->query("
			 SELECT 
			 level.Name     AS LevelName,
			 row.Name       AS RowName,
			 row_level.ID   AS RowLevelID,
			 level.ID       AS level_ID
			 FROM 
			 class_table
			 INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID       = row.ID
			 INNER JOIN level            ON row_level.Level_ID     = level.ID
			 WHERE class_table.EmpID = ".$UID."
             GROUP BY level.ID
			");
		}
		else{
			   $query = $this->db->query("
				 SELECT 
				 level.Name_en   AS LevelName,
				 row.Name_en     AS RowName,
				 row_level.ID    AS RowLevelID
				 FROM 
				 class_table
				 INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
			     INNER JOIN row              ON row_level.Row_ID       = row.ID
			     INNER JOIN level            ON row_level.Level_ID     = level.ID
				 WHERE class_table.EmpID = ".$UID."
                 GROUP BY level.ID
				");
			}
			  if($query->num_rows() >0)
			  {return $query->result();}else{return FALSE ;}
	}
	///////////////////////////
	public function get_emp_subjects($Lang = NULL , $UID = 0)
	{
	  	if($Lang == 'arabic')
		{
			$query = $this->db->query("
			 SELECT 
			 level.Name     AS LevelName,
			 row.Name       AS RowName,
			 row_level.ID   AS RowLevelID,
			 subject.ID     AS SubjectID,
			 subject.Name   AS SubjectName
			 FROM 
			  class_table
			  INNER JOIN subject          ON class_table.SubjectID   = subject.ID
			  INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
			  INNER JOIN row              ON row_level.Row_ID       = row.ID
			  INNER JOIN level            ON row_level.Level_ID     = level.ID
			
			  WHERE class_table.EmpID = ".$UID."
              GROUP BY class_table.SubjectID
			");
		}
		else{
			   $query = $this->db->query("
				 SELECT 
				 level.Name_en   AS LevelName,
				 row.Name_en     AS RowName,
				 row_level.ID    AS RowLevelID,
				 subject.ID      AS SubjectID,
				 subject.Name    AS SubjectName
				 FROM 
				 class_table
				 INNER JOIN subject          ON class_table.SubjectID   = subject.ID
				 INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
				 INNER JOIN row              ON row_level.Row_ID       = row.ID
				 INNER JOIN level            ON row_level.Level_ID     = level.ID
				 
			         WHERE class_table.EmpID = ".$UID."
                                 GROUP BY class_table.SubjectID 
				");
			}
			  if($query->num_rows() >0)
			  {return $query->result();}else{return FALSE ;}
	}

	////////////////////////
	public function get_class_school_active($Lang = NULL)
	{
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		  $query = $this->db->query("SELECT DISTINCT 
		   row_level.Level_ID       AS LevelID,
		   row_level.Row_ID         AS RowID,
		   row_level.Level_Name     AS LevelName,
		   row_level.Row_Name       AS RowName,
		   row_level.ID             As RowLevelID ,
		   class.ID                 As ClassID ,
		   class. ".$Name."         AS ClassName 
		   FROM class
		   INNER JOIN school_class     ON class.ID = school_class.ClassID AND school_class.SchoolID = '".$this->session->userdata('SchoolID')."'
		   INNER JOIN class_table      ON class.ID=class_table.ClassID 
		   INNER JOIN subject          ON subject.ID = class_table.SubjectID
		   INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
		   where class_table.EmpID ='".$this->session->userdata('id')."' and BaseTableID =1
		   group by row_level.ID,class.ID
		   order by row_level.ID,class.ID
		   ");			
		  if($query->num_rows() >0)
		  {return $query->result();}else{return FALSE ;}
	}
	////////////////////////////
	public function get_student_emp($Lang = NULL  , $LevelID = 0 , $RowLevelID = 0  , $ClassID = 0  )
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
			 student.Class_ID    As student_Class_ID  ,
			 class.ID       As ClassID ,
			 class.".$NameArray['class']." ,
			 school_details.SchoolName , 
			 tb1.ID AS StudentID,
			 CASE
			 WHEN '$Lang' = 'english' and tb1.Name_en IS not NULL and tb1.Name_en !=' ' THEN tb1.Name_en
			 ELSE tb1.Name
			 END AS FullName ,
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
			 WHERE tb1.SchoolID  = '".$this->session->userdata("SchoolID")."'
			 AND
			 level.ID      = IFNULL($LevelID,level.ID)
			 AND 
			 row_level.ID  = IFNULL($RowLevelID,row_level.ID)
			 AND 
			 class.ID      = IFNULL($ClassID,class.ID)
			 AND 
			 student.Class_ID      = IFNULL($ClassID,class.ID)
			 AND tb1.Isactive = 1 
		     AND tb2.Isactive = 1 
			 AND tb1.Type = 'S'
		     GROUP BY StudentID
			 order by FullName asc
			");
		 //	print_r($this->db->last_query());
			if($query->num_rows()>0)
			{
			   return $query->result();	
			}else{return false ;}
			
	}
	/////////////////////////
	public function get_student_absent_by_day($DateFrom,$DateTo,$StudentID)
	{
	   	$GetData = $this->db->query("SELECT COUNT(`absence_day`) AS absence_day 
	   	                               FROM `students_evaluation`
	   	                               WHERE `Date`    >= '$DateFrom' 
	   	                               AND `Date`      <= '$DateTo' 
	   	                               AND `StudentID` = $StudentID
	   	                                ");
		
		if($GetData->num_rows()> 0){return $GetData->row_array();}
		else{return  FALSE;}
	}
	/////////////////////////
	public function get_student_absent_by_class($DateFrom,$DateTo,$StudentID)
	{
	   	$GetData = $this->db->query("SELECT COUNT(`Absence_class`) AS Absence_class 
	   	                               FROM `students_evaluation`
	   	                               INNER JOIN class_table ON class_table.ID = students_evaluation.ClassTableID
	   	                               WHERE `Date`    >= '$DateFrom' 
	   	                               AND `Date`      <= '$DateTo' 
	   	                               AND `StudentID` = $StudentID
	   	                                ");
		
		if($GetData->num_rows()> 0){return $GetData->row_array();}
		else{return  FALSE;}
	}
	////////////////////////
	public function absent_report_details($Data)
	{
	    extract($Data);
		
		  $query = $this->db->query("SELECT students_evaluation.*,contact.Name AS StudentName ,lesson.lesson,day.Name AS DayName 
		                            FROM `students_evaluation` 
		                            INNER JOIN contact ON contact.ID = students_evaluation.StudentID
                                    INNER JOIN class_table ON class_table.ID = students_evaluation.ClassTableID
                                    INNER JOIN subject ON subject.ID = class_table.SubjectID
                                    INNER JOIN lesson ON lesson.ID = class_table.Lesson
                                    INNER JOIN day ON day.ID = class_table.Day_ID
                                    WHERE `StudentID` = $StudentID AND `TeacherID` = '".$this->session->userdata('id')."'
		   ");			
		  if($query->num_rows() >0)
		  {return $query->result();}else{return FALSE ;}
	}
	/////////////////////////
	public function get_absent_details($Data)
	{
	    extract($Data);
	    
	    if($type == "D"){
	       // PRINT_R($Data);DIE;
	   	$GetData = $this->db->query("SELECT students_evaluation.*,contact.Name AS StudentName
	   	                               FROM `students_evaluation`
	   	                               INNER JOIN contact     ON contact.ID     = students_evaluation.StudentID
	   	                               WHERE `Date`    >= '$DateFrom' 
	   	                               AND `Date`      <= '$DateTo' 
	   	                               AND `StudentID` = $StudentID
	   	                               AND `ClassTableID` IS NULL
	   	                               order by Date DESC
	   	                                ")->result();
	    }else{
	        
        $GetData = $this->db->query("SELECT students_evaluation.*,contact.Name AS StudentName,subject.Name AS SubjectName ,lesson.lesson AS LessonName,
                                     students_evaluation.Date AS Date,day.Name AS DayName 
       	                               FROM `students_evaluation`
       	                               INNER JOIN class_table ON class_table.ID = students_evaluation.ClassTableID
                                       INNER JOIN contact     ON contact.ID     = students_evaluation.StudentID
                                       INNER JOIN subject     ON subject.ID     = class_table.SubjectID
                                       INNER JOIN lesson      ON lesson.ID      = class_table.Lesson
                                       INNER JOIN day         ON day.ID = class_table.Day_ID
       	                               WHERE `Date`    >= '$DateFrom' 
       	                               AND `Date`      <= '$DateTo' 
       	                               AND `StudentID` = $StudentID
       	                               AND `TeacherID` = '".$this->session->userdata('id')."'
       	                               AND `ClassTableID` IS NOT NULL
       	                               order by Date DESC
       	                                ")->result();
	    }
		return $GetData;
	
	}
/////////////////////////
	public function get_all_rate($Data)
	{
	    extract($Data);
	    
	   	$GetData = $this->db->query("SELECT `rateCount`, COUNT(`rateCount`) AS totalRate, rateCount*COUNT(`rateCount`) AS sorce 
									FROM `father_emp_rate` 
									WHERE `empID` = '" . $this->session->userdata('id') . "' GROUP BY `rateCount`
						")->result_array();
	    
		return $GetData;
	
	}
	/////////////////////////
	public function get_rate_details($Data)
	{
	    // extract($Data);
	    
	   	$GetData = $this->db->query("SELECT
                                        COUNT(`father_emp_rate`.`rateCount`) AS totalRate,
                                        COUNT(CASE WHEN `father_emp_rate`.`note` IS NOT NULL AND `father_emp_rate`.`note` <> '' THEN 1 END) AS comments,
                                        SUM(`father_emp_rate`.`rateCount`) AS sorce,
                                        subject.Name AS subject_name,
                                        CONCAT(
                                            row_level.Level_Name,
                                            ' ',
                                            row_level.Row_Name
                                        ) AS row_level_name,
                                        subject_ID, 
                                        studentRLID
                                    FROM
                                        `father_emp_rate`
                                    INNER JOIN subject ON subject.ID = `father_emp_rate`.subject_ID
                                    INNER JOIN row_level ON row_level.ID = `father_emp_rate`.studentRLID
                                    WHERE
                                        `father_emp_rate`.`empID` = '" . $this->session->userdata('id') . "'
                                    GROUP BY
                                        `father_emp_rate`.subject_ID,
                                        `father_emp_rate`.studentRLID
                                    ORDER BY
                                        sorce DESC;
								")->result();
	    
		return $GetData;
	
	}
 }//End Class
