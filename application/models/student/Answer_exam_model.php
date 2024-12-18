<?php
require_once APPPATH . '/traits/VistorTrait.php';
class Answer_Exam_Model  extends CI_Model 
 {
	use VistorTrait;
///create_token
	 public function create_token()
	{
			$ArrayNum = array('0','1','2','3','4','5','6', '7','8','9');
			$Num = '';
			$Count = 0;
			while ($Count <= 9) {$Num .= $ArrayNum[mt_rand(0, 8)];$Count++; }
			$ArrayStr = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','W','X','Y','Z');
			$Str = '';
			$Count = 0;
	
			while ($Count <= 14) {$Str .= $ArrayStr[mt_rand(0, 15)];$Count++;}	
			$encrypt = 'qwdfghm,][poiasdfghj.zxcvbnm,.957365254068061531qwertyuiasdfghjkl;12345678-=dfdsfsdfdferwerrvxcvbbn' ;	
			$Token            = md5($encrypt.$Str.$Num.uniqid(mt_rand()).microtime()) ;
			
			return $Token ; 
	}
	///////////////////////////////
	public function get_exams_header($data)
	 {
	    extract($data);
		$shcoolId  = $this->session->userdata('SchoolID');
		$idContact = (int)$this->session->userdata('id');
	    // if($task){$where=" AND test.ID = $examID ";}
		// $idContact = (int)$this->session->userdata('id');
		// $this->db->select('Class_ID,R_L_ID');
		// $this->db->from('student');	
		// $this->db->where('Contact_ID',$idContact);
		// $ResultExam1 = $this->db->get();	
		// $NumRowResultExam1 = $ResultExam1->num_rows() ; 
		// 	if($NumRowResultExam1 >0)
		// 	  {
		// 		$ReturnExam1     = $ResultExam1 ->row_array() ;
		// 	    $Class_ID       = $ReturnExam1['Class_ID'];
		// 	    $R_L_ID         =$ReturnExam1['R_L_ID'];
			    
		// 	  }
			  
	          $ResultExam = $this->getAPIData("https://chat.lms.esol.com.sa/student/exam?apikey=chat." . $_SERVER['HTTP_HOST'] . '&studentId=' . $idContact. '&rowLevelId=' . $rowLevelId. '&classId=' . $classId. '&subjectId=' . $subjectID. '&type=' . $type. '&semesterId=' . $SemesterID. '&examId=' . $examID. '&schoolId=' . $shcoolId );
			  return json_decode(json_encode($ResultExam));
		// 	  $ResultExam=$this->db->query("select test.ID AS test_ID , test.Name AS test_Name,test.empID AS teacher_Name, test.Description As test_Description,
		// 	  test.time_count ,test.date_from , test.date_to, test.num_student as num_student,test.subject_id,test.type,teach.Name as teacher ,subject.Name  AS SubjectName 
		// 	  from contact
		// 	  inner join student on student.Contact_ID = contact.ID
		// 	  inner join test  on  test.RowLevelID =  student.R_L_ID
		// 	   INNER JOIN contact AS teacher
		// 	  ON test.empID = teacher.ID
		// 	  inner join class_table on class_table.RowLevelID = student.R_L_ID and class_table.ClassID = student.Class_ID and  test.empID  = class_table.EmpID 
 
		// 	  INNER JOIN subject ON subject.ID = test.subject_id
		// 	  inner join contact as teach on teach.ID =test.empID
		// 	  inner join questions_content  on questions_content.test_id = test.ID 
		// 	  inner join config_semester on config_semester.ID = test.config_semester_ID and config_semester.ID=$SemesterID
		// 	  where test.IsActive = 1
		// 	  and test.type     = $type
		// 	  and test.is_deleted = 0
		// 	  and contact.ID = $idContact
		// 	  and test.subject_id = $subjectID
		// 	  and test.RowLevelID = $R_L_ID
		// 	  and FIND_IN_SET($Class_ID,test.classID)
		// 	  and test.SchoolId =".$this->session->userdata('SchoolID')." 
		// 	  and (test.Students ='' OR test.Students IS NULL OR FIND_IN_SET($idContact,Students) )
		// 	  $where
		// 	  group by test.ID
		// 	  order by test.ID DESC
		// 	  ");
		// $NumRowResultExam = $ResultExam->num_rows() ; 
		// 	if($NumRowResultExam >0)
		// 	  {
		// 		$ReturnExam     = $ResultExam ->result() ;
		// 	   return $ReturnExam ; 
			   
		// 	   return TRUE ; 
							 
		// 	  }else{return $NumRowResultExam ;return FALSE ;}
	}
 /////////////////////////////////////////
  public function get_questions($ExamID)
	 {
	     
		$this->db->select('questions_content.ID,Degree,Question,Q_attach,questions_content.Token,questions_types.Name AS questions_types_Name,questions_types_ID,youtube_script,num_ques');
		$this->db->from('questions_content');	
		$this->db->join('questions_types', 'questions_types.ID =questions_content.questions_types_ID', 'INNER');	
		$this->db->where('test_ID',$ExamID);
		$this->db->group_by('questions_content.ID'); 
		$this->db->order_by('questions_content.ID', "ASC");
		$ResultExam = $this->db->get();			
		$NumRowResultExam = $ResultExam->num_rows() ; 
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->result() ;
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{return $NumRowResultExam ;return FALSE ;}
	}
	//////////////////////////////////
	 public function get_answers($ExamID)
	 {
		$this->db->select('answers.ID AS Answer_ID,answers.Answer as Answer,answers.Answer_match,answers.Answer_correct as Answer_correct,answers.IsActive as answers_IsActive,answers.Token as answers_Token,answers.Date_Stm as answers_Date_Stm,questions_content_ID');
		$this->db->from('answers');	
		$this->db->join('questions_content','answers.Questions_Content_ID=questions_content.ID');
		$this->db->where('answers.test_ID',$ExamID);
		$this->db->order_by('Answer_ID', "ASC");
		$ResultExam = $this->db->get();			
		$NumRowResultExam = $ResultExam->num_rows() ; 
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->result() ;
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{return $NumRowResultExam ;return FALSE ;}
	}
		//////////////////////////////////
	 public function get_answers_by_ques($ques)
	 {
		$this->db->select('answers.ID AS Answer_ID,answers.Answer as Answer,answers.Answer_match,answers.Answer_correct as Answer_correct,answers.IsActive as answers_IsActive,answers.Token as answers_Token,answers.Date_Stm as answers_Date_Stm,questions_content_ID');
		$this->db->from('answers');	
		$this->db->join('questions_content','answers.Questions_Content_ID=questions_content.ID');
		$this->db->where('questions_content.ID',$ques);
		$this->db->order_by('Answer_ID', "ASC");
		$ResultExam = $this->db->get();			
		$NumRowResultExam = $ResultExam->num_rows() ; 
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->result() ;
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{return $NumRowResultExam ;return FALSE ;}
	}
 /////////////////////////////////////

	public function getConsumedTime($params)
	 {
		 extract($params);
		 $query=$this->db->query("SELECT MAX(consumed_time) AS consumed_time FROM test_time_consumed where test_id=$examID and student_id = $student_id");
		 
         if($query->num_rows() > 0) {
         $result = $query->row_array() ;
	    	return $result['consumed_time'];
         }
         else{return FALSE ;}
	 }
	  /////////////////////////////////////
     public function setConsumedTime($params)
	 {
		 extract($params);
	     $data = array(
						"test_id"             =>$examID,
						"student_id"          =>$student_id,
						"consumed_time"       =>$consumed_time,
						"last_updated_date" => $Timezone,
						"in_out" => $in_out,
						"in_out_time" => $Timezone
						);
		 $result =  $this->db->insert('test_time_consumed', $data);
		 if($result){return TRUE;}else{return FALSE ;}
	 }
	 ////////////////////////////////////
	 public function get_exam_data($Lang,$ExamID)
	 {
		
	   if($Lang=="english"){
			     $Name= "Name_en";
	   }else{
			    $Name= "Name";
	    }
		$this->db->select("test.date_from, test.date_to,test.ID as test_ID, test.Name as test_Name,test.Description as test_Description,test.time_count,test.subject_id,
		questions_content.ID AS questions_content_ID,questions_content.Degree,questions_content.Question,questions_types.ID as questions_types_ID,questions_types.$Name as questions_types_Name");
		$this->db->from('test');	
		$this->db->join('questions_content','test.ID  = questions_content.test_id');
		$this->db->join('questions_types','questions_content.questions_types_ID  = questions_types.ID');
		$this->db->where('test.ID',$ExamID);
		if($this->session->userdata('type')=='S'){
			$this->db->where('test.IsActive',1);
		}
		$this->db->where('questions_content.IsActive',1);
		$this->db->group_by('questions_types_ID'); 
		$this->db->order_by('questions_types.order_by', "asc");
		$ResultExam = $this->db->get();			
		$NumRowResultExam = $ResultExam->num_rows() ; 
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->result() ;
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{return $NumRowResultExam ;return FALSE ;}
	}

	 /////////////////////////////////////////
	 public function get_ques_answer( $question_ID,$answerID)
	 {
		$this->db->select('ID,Degree,Answer,Answer_correct');	
		$this->db->from('answers');	
		$this->db->where('Questions_Content_ID',$question_ID);
		$this->db->where('ID',$answerID);
		$this->db->where('IsActive',1);
		$ResultContactData = $this->db->get();			
		$NumRowResultContactData  = $ResultContactData->num_rows() ; 
		if($NumRowResultContactData <=0)
		  {
			return 0;	
		  }
		else 
		{
			$ResultContactData = $ResultContactData ->row_array() ;
			return $ResultContactData;
		}
	 }
	 
	 public function get_ques_match_answer( $question_ID)
	 {
		$this->db->select('ID,Degree,Answer,Answer_match,Answer_correct');	
		$this->db->from('answers');	
		$this->db->where('Questions_Content_ID',$question_ID);
		$this->db->where('IsActive',1);
		$ResultContactData = $this->db->get();			
		$NumRowResultContactData  = $ResultContactData->num_rows() ; 
		if($NumRowResultContactData <=0)
		  {
			return 0;	
		  }
		else 
		{
			$ResultContactData = $ResultContactData ->result_array() ;
			return $ResultContactData;
		}
	 }
	 public function get_ques_matches($answer_word,$id)
	 {
		$this->db->select('ID');	
		$this->db->from('answers');	
		$this->db->where('answer',$answer_word);
		$this->db->where('Questions_Content_ID',$id);
		$ResultContactData = $this->db->get();			
		$NumRowResultContactData  = $ResultContactData->num_rows() ; 
		if($NumRowResultContactData <=0)
		  {
			return 0;	
		  }
		else 
		{
			$ResultContactData = $ResultContactData ->row_array() ;
			return $ResultContactData;
		}
	 }
	 /////////////////////////////////////
	 	public function insert_student_degrees($answer_id,$ques_id,$degree,$test_ID,$Timezone,$hidImg,$answer_ques)
	 { 
	                 
                    $idContact          = $this->session->userdata('id');
			        $clerical           = $this->get_student_classes($idContact);
			        $SubjectID          = $this->get_subject($test_ID);
			        $where              ="";
			        $ques_type          = $this->db->query("SELECT questions_types.ID FROM questions_types 
                                                            INNER JOIN questions_content on questions_types.ID=questions_content.questions_types_ID
                                                            where questions_content.ID=$ques_id")->row_array();
                    if($ques_type['ID']!=6){
                        $where="and test_student.answer_detail ='$answer_ques'";
                        $hidImg=$answer_ques;
                    }
                    
				    $student_answer= $this->db->query("select test_student.ID,test_student.Degree 
                                    				    from test_student 
                                    				    where test_student.Contact_ID=$idContact and test_student.questions_content_ID=$ques_id $where limit 1")->result(); 
				

					if(empty($student_answer))
					  { 
					     
				         $SchoolID	        = (int)$this->session->userdata('SchoolID') ;
				         $Token              = $this->create_token();
					     $query              = $this->db->query("select num_student from test where test.ID=$test_ID and FIND_IN_SET($idContact,num_student)   ");
					     $result_array       = $query->row_array();
		
					     if($result_array){
					             $add_q = array('Contact_ID'=>$idContact , 'questions_content_ID'=>$ques_id,'Degree'=>$degree,'Token'=>$Token ,'answer_content' =>$answer_id,'test_id'=>$test_ID,'answer_detail'=>$hidImg ,
					             'is_updated'=>1 ,'last_degree'=>$degree, 'is_updated_date'=>$Timezone,'Date_Stm'=>$Timezone,'Inserted_By'=> $this->session->userdata('RedirectUser'),'Inserted_At' => $Timezone);
					     }else{
					    	        $add_q = array('Contact_ID'=>$idContact , 'questions_content_ID'=>$ques_id,'Degree'=>$degree,'Token'=>$Token ,'answer_content' =>$answer_id,'answer_detail'=>$hidImg,
					    	        'test_id'=>$test_ID ,'last_degree'=>$degree,'Date_Stm'=>$Timezone,'Inserted_By'=> $this->session->userdata('RedirectUser'),'Inserted_At' => $Timezone);
					    	
					     }
		    	         $Insert  =  $this->db->insert('test_student', $add_q);
					     $test_type = $this->db->query("select type from test where ID=$test_ID")->result() ; 
					    //  if( $test_type[0]->type==1)
					    //  { 
				        //     $add_q1 = array('Stu_ID  '=>$idContact ,'Stu_Degree'=>$degree ,'Test_ID' => $test_ID ,'Type_ID '=>11,'School_ID'=>$SchoolID,
				        //     'Subject_ID'=>$SubjectID['subject_id'],'R_L_ID'=>$clerical['R_L_ID'],'Class_ID'=>$clerical['Class_ID'],'Name'=>$SubjectID['Name']);
				        //      $this->db->insert('send_box_student', $add_q1);
					    //  }else
					    //  {
					    //      if($this->session->userdata('type')!='A'){
					    //      $add_q2 = array('Stu_ID  '=>$idContact ,'Stu_Degree'=>$degree ,'Test_ID' => $test_ID ,'Type_ID '=>8,'School_ID'=>$SchoolID,
					    //      'Subject_ID'=>$SubjectID['subject_id'],	'R_L_ID'=>$clerical['R_L_ID'],'Class_ID' =>$clerical['Class_ID'],'Name'=>$SubjectID['Name']);
				        //       $this->db->insert('send_box_student', $add_q2);
					    //      }  
					    //  }
			          }else
			          {
			     
					    foreach($student_answer as $rows ){
					      $question_s_id = $rows->ID;
					     }
					      
					    $Token   = $this->create_token();
					    $add_q = array(
													 'Contact_ID'             =>(int)$idContact  ,
													 'questions_content_ID'   =>(int)$ques_id ,
													 'Degree'                 =>$degree ,
													 'answer_content'         =>$answer_id,
													 'Token'                  =>$Token,
													 'is_updated'             =>1,
													 'is_updated_date'        =>$Timezone,
													 'Updated_by'             => $this->session->userdata('RedirectUser'),
				                                     'Updated_at'             => $Timezone,
				                                     'answer_detail'          =>$hidImg
													 );
													 //print_r($add_q);die;
					   $this->db->where('ID', (int)$question_s_id);
				       $Update=	 $this->db->update('test_student', $add_q);	
					//    $add_q1 = array('Stu_ID  '=>$idContact ,'Stu_Degree'=>$degree ,'Test_ID' => $test_ID  );
					//    $this->db->where('Test_ID', (int)$test_ID);
				    //    $this->db->update('send_box_student', $add_q1);
			         }
			  if($Insert || $Update){
			    return true;
			  }else{
			      return false;
			  }
	 }
  ////////////////////////////////////////
   public function exam_report( $LevelID = 0 , $from = 0 , $to = 0, $num =0 ,$subjectID =0,$test =0)
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
    WHERE contact.Isactive = 1 AND student.Contact_ID = '". $this->session->userdata('id')."')

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
      LIMIT 1)
     ");
	// echo json_encode($this->db->last_query()); die();
	if($query->num_rows() > 0 ){return $query->result();}else{return FALSE ; }
 }
	 //////////////////////////////////rania
 //get_exam_subject
 	/////////////////////////////////////////
	 public function check_answer($answerID , $question_ID)
	 {
		$this->db->select('Degree');	
		$this->db->from('answers');	
		$this->db->where('Questions_Content_ID',$question_ID);
		$this->db->where('IsActive',1);
		$this->db->where('Answer_correct',1);
		$this->db->where('ID',$answerID);
		$this->db->limit(1);
		$ResultContactData = $this->db->get();			
		$NumRowResultContactData  = $ResultContactData->num_rows() ; 
		if($NumRowResultContactData <=0)
		  {
			return 0;	
		  }
		else 
		{
			$ResultContactData = $ResultContactData ->row_array() ;
			return (string)$ResultContactData['Degree'];
		}
	 }
	 public function get_exam_subject($test_ID )
	 {
		$idContact = (int)$this->session->userdata('id'); 
				
		$this->db->select('  Subject_ID	 ');


		$this->db->from('vw_test_select AS vw_test'); 

		
 		$this->db->where('test_ID',$test_ID );
 		$this->db->order_by('vw_test.test_ID', 'DESC');
		$ResultExam = $this->db->get(); 			
		$NumRowResultExam = $ResultExam->num_rows() ; 
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->row_array() ; 
			   return $ReturnExam['Subject_ID']  ; 
			   
			   return TRUE ; 
							 
			  }else{return $NumRowResultExam ;return FALSE ;}
	}
	public function get_exam_subject_test($test_ID )
	 {
		$idContact = (int)$this->session->userdata('id'); 
				
		$this->db->select('  subject_id	 ');


		$this->db->from('test'); 

		
 		$this->db->where('ID',$test_ID );
 		$this->db->order_by('test.ID', 'DESC');
		$ResultExam = $this->db->get(); 			
		$NumRowResultExam = $ResultExam->num_rows() ; 
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->row_array() ; 
			   return $ReturnExam['subject_id']  ; 
			   
			   return TRUE ; 
							 
			  }else{return $NumRowResultExam ;return FALSE ;}
	}
 //get_exams
	 public function get_exams($Lang)
	 {
		$idContact = (int)$this->session->userdata('id'); 
					
		$this->db->select('vw_test.test_ID,vw_test.classID , vw_test.test_Name, vw_test.test_Description, vw_test.time_count, vw_test.contact_Name as teacher_Name, vw_test.subject_Name, vw_test.config_semester_Name, vw_test.row_level_Name');


		$this->db->from('contact');			
		$this->db->join('student', 'student.Contact_ID = contact.ID', 'INNER');			
	    $this->db->join('class_table', 'class_table.RowLevelID = student.R_L_ID and class_table.ClassID = student.Class_ID ', 'INNER');	
	    $this->db->join('vw_test_select AS vw_test', 'vw_test.contact_ID = class_table.EmpID and vw_test.row_level_ID	=  student.R_L_ID ', 'INNER');	
		$this->db->join('test_questions', 'vw_test.test_ID = test_questions.Test_ID', 'INNER');

		
		$this->db->group_by('vw_test.test_ID');
		$this->db->order_by('vw_test.test_ID', 'DESC');
		$this->db->where('vw_test.IsActive',1);
		$this->db->where('contact.ID',$idContact);
		$this->db->where('class_table.SchoolID', (int)$this->session->userdata('SchoolID'));
		$this->db->where('date_from <=CURDATE() '  ); 
		$ResultExam = $this->db->get();			
		$NumRowResultExam = $ResultExam->num_rows() ; 
		
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->result() ;
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{return $NumRowResultExam ;return FALSE ;}
		
	} 	public function get_student_classes ($idContact)
	{
		 $this->db->select('Class_ID,R_L_ID');
		$this->db->from('student');
		$this->db->where('Contact_ID', $idContact);
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
		  public function get_subject($txt_test_ID)
	 { 
	     
	      $this->db->select('subject_id,Name');
		$this->db->from('test');
		$this->db->where('ID', $txt_test_ID);
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
	     

	
	/// get_sum_degree
	public function get_exams_header_old($Lang,$subjectID)
	 {
		 
		$idContact = (int)$this->session->userdata('id'); 
					
		$this->db->select(
		    'send_box.Test_ID  as test_ID ,send_box.Class_ID as classID, send_box.Name as test_Name, send_box.time_count as  time_count, send_box.Stu_Degree  as Stu_Degree , send_box.Degree as Degree
		     ');


		$this->db->from('send_box');			
		$this->db->join('student', 'student.Class_ID = send_box.Class_ID', 'INNER');	
				
	    $this->db->join('class_table', 'class_table.RowLevelID = student.R_L_ID and class_table.ClassID = student.Class_ID ', 'INNER');	
		$this->db->where('send_box.Type_ID',2);
		$this->db->where('send_box.Is_Active',1);
		$this->db->where('student.Contact_ID',$idContact);
		$this->db->where('send_box.Subject_ID ',$subjectID); 
		$this->db->where('class_table.SchoolID', (int)$this->session->userdata('SchoolID'));
// 		$this->db->where('CURRENT_TIMESTAMP() BETWEEN send_box.date_from  and send_box.Date_to  ');
         // $this->db->where('send_box.Date_to  >=CURDATE() '  );
		$this->db->where('send_box.Stu_Degree',NULL,FALSE);
		$this->db->where("send_box.date_from >'2020-08-14 07:53:00'");
		$this->db->group_by('send_box.Test_ID');
			$this->db->limit(100);
		$ResultExam = $this->db->get();	 	
		$NumRowResultExam = $ResultExam->num_rows() ; 
 
			if($NumRowResultExam >0)
			  {	 
				$ReturnExam     = $ResultExam->result() ;
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{return $NumRowResultExam ;return FALSE ;}
	}
	public function get_sum_degree($TestID, $sid = null)
	{
		$StudentID = $sid ?? (int)$this->session->userdata('id');
        $result = $this->db->query("
		SELECT SUM(Degree) AS SumDegreeQ 
		 FROM questions_content WHERE test_id = ".$TestID."
		");
		$NumRowResultExam = $result->num_rows() ; 
			if($NumRowResultExam >0)
			  {		
				
				$result2 = $this->db->query("SELECT SUM(test_student.Degree)AS SumDegreeSt  FROM test_student 
				WHERE test_student.test_id =  ".$TestID." AND test_student.Contact_ID = ".$StudentID." AND test_student.is_updated_date IS NOT NULL
				");
				 $row = $result2->row_array();

				 if($row['SumDegreeSt'] == null){
				$result2 = $this->db->query("SELECT SUM(test_student.last_degree)AS SumDegreeSt  FROM test_student 
				WHERE test_student.test_id =  ".$TestID." AND test_student.Contact_ID = ".$StudentID." AND test_student.is_updated_date IS NULL
				");
				}
				
				$NumRowResultExam = $result2->num_rows() ; 
				if($NumRowResultExam >0)
				  {	
					
					$data2 = $result2->row_array();
					 
				  }else{$data2=0;}$data = $result->row_array();
				  return array_merge($data,$data2);
			  }
		
	}
	public function get_sum_degree1($TestID)
	{
		$StudentID = (int)$this->session->userdata('id');
        $this->db->select(" send_box.Stu_Degree AS Stu_Degree"); 
  	    $this->db->from('send_box');
		$this->db->where('send_box.Test_ID',$TestID);
		$this->db->where('send_box.Stu_ID',$StudentID);
	   	$this->db->group_by('send_box.Test_ID');
		$ResultExam = $this->db->get();	 	
		$NumRowResultExam = $ResultExam->num_rows() ; 
 
			if($NumRowResultExam >0)
			  {	 
				$ReturnExam     = $ResultExam->result() ;
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{return $NumRowResultExam ;return FALSE ;}
			  
	}
	

 //get_degree
	 public function get_degree($question_ID)
	 {
		$this->db->select('Degree,count(Answer_ID) as countRows');	
		$this->db->from('vw_test_question_select');	
		$this->db->where('questions_content_ID',$question_ID);
		$this->db->where('answers_IsActive',1);
		$this->db->limit(1);
		$ResultContactData = $this->db->get();			
		$NumRowResultContactData  = $ResultContactData->num_rows() ; 
		if($NumRowResultContactData <=0)
		  {
			return 0;	
		  }
		else 
		{
			$ResultContactData = $ResultContactData ->row_array() ;
			return $ResultContactData;
		}
	 }
 //get_answer_correct_count
	 public function get_answer_correct_count($question_ID)
	 {
		$this->db->select('count(Answer_ID) as countAnsCorrect,Answer_ID');	
		$this->db->from('vw_test_question_select');	
		$this->db->where('questions_content_ID',$question_ID);
		$this->db->where('answers_IsActive',1);
		$this->db->where('Answer_correct',1);
		$this->db->limit(1);
		$ResultContactData = $this->db->get();			
		$NumRowResultContactData  = $ResultContactData->num_rows() ; 
		if($NumRowResultContactData <=0)
		  {
			return 0;	
		  }
		else 
		{
			$ResultContactData = $ResultContactData ->row_array() ;
			return $ResultContactData;
		}
	 }

 //get_answer_correct
	 public function get_answer_correct($question_ID)
	 {
		$this->db->select('Answer_ID');	
		$this->db->from('vw_test_question_select');	
		$this->db->where('questions_content_ID',$question_ID);
		$this->db->where('answers_IsActive',1);
		$this->db->where('Answer_correct',1);
		$ResultContactData = $this->db->get();			
		$NumRowResultContactData  = $ResultContactData->num_rows() ; 
		if($NumRowResultContactData <=0)
		  {
			return 0;	
		  }
		else 
		{
			$ResultContactData = $ResultContactData ->result() ;
			return $ResultContactData;
		}
	 }

 //get_answer
	 public function get_answer($question_ID)
	 {
		$this->db->select('Answer');	
		$this->db->from('vw_test_question_select');	
		$this->db->where('questions_content_ID',$question_ID);
		$this->db->where('answers_IsActive',1);
		$this->db->where('Answer_correct',1);
		$ResultContactData = $this->db->get();			
		$NumRowResultContactData  = $ResultContactData->num_rows() ; 
		if($NumRowResultContactData <=0)
		  {
			return 0;	
		  }
		else 
		{
			$ResultContactData = $ResultContactData ->result() ;
			return $ResultContactData;
		}
	 }
 

	//insert_s_degrees
	 public function insert_s_degrees($id_q_degree,$idContact)
	 { 
		 $q_id_edit =  array();
			foreach($id_q_degree as $id_q=>$degree)
			  {
			      $txt_test_ID         = (int)$this->input->post("txt_test_ID");
					$q_id_edit[]    = 	$id_q;	 
					$this->db->select('ID,Degree');	
					$this->db->from('test_student');	
					$this->db->where(array('Contact_ID'=>(int)$idContact,'questions_content_ID'=>(int)$id_q));	
					$this->db->limit(1);
					$ResultContactData = $this->db->get();			
					$NumRowResultContactData  = $ResultContactData->num_rows() ; 
					if($NumRowResultContactData ==0)
					  { 
				    $Token   = $this->create_token();
					$add_q = array('Contact_ID'=>$idContact , 'questions_content_ID'=>$id_q,'Degree'=>$degree,'Token'=>$Token,'test_id'=>$txt_test_ID); 
				  $this->db->insert('test_student', $add_q);
		 add_notification( $this->db->insert_id(),2,0,0,0 ,$idContact);
			      }else {
					$q_id_edit           = 	$id_q;	
					$ResultContactData = $ResultContactData ->result() ;
					foreach($ResultContactData as $row ){
					$question_s_id = $row->ID;
					}
					$Token   = $this->create_token();
					$add_q = array(
													 'Contact_ID'             =>(int)$idContact  ,
													 'questions_content_ID'   =>(int)$id_q ,
													 'Degree'                 =>$degree ,
													 'test_id'                 =>$txt_test_ID,
													 'Token'                  =>$Token,
													 
													 );
					 $this->db->where('ID', (int)$question_s_id);
					$Insert_q =  $this->db->update('test_student', $add_q);					  
			            }
			  }
	
			  return true;
	 }
	//insert_upload_answer
	//public function insert_upload_answer($answer,$txt_attach_f,$q_ID)

	 public function insert_upload_answer_array($q_answers_id_6,$txt_attach_f_6,$q_old_id_6,$Timezone)
	 {
	   //   $Date       = date('Y-m-d H:i:s');
	     $x=0;
	 foreach ($q_old_id_6 as $value) {
	    $q_ID=$value;
	    $answer=$q_answers_id_6[$x];
	    $txt_attach_f=$txt_attach_f_6[$x];
		$idContact           = (int)$this->session->userdata('id'); 
		$txt_test_ID         = (int)$this->input->post("txt_test_ID");  
		$this->db->select('ID,Degree');	
		$this->db->from('test_student');	
		$this->db->where('Contact_ID',(int)$idContact);	
		$this->db->where('questions_content_ID',(int)$q_ID);
		$this->db->limit(1);
		$ResultContactData = $this->db->get();			
		$NumRowResultContactData  = $ResultContactData->num_rows() ; 
		if($NumRowResultContactData <=0)
		  { 
			$idContact           = (int)$this->session->userdata('id'); 
			$Token   = $this->create_token();
			/*if($txt_attach_f==""){
				$add_q = array(
					 'Contact_ID'             =>(int)$idContact  ,
					 'questions_content_ID'   =>(int)$q_ID ,
					 'Degree'                 =>0 ,
					 'Token'                  =>$Token
					 );

				}else{*/
					$query = $this->db->query("select num_student from test where test.ID=$txt_test_ID and (num_student) REGEXP  $idContact");
					$result_array = $query->result_array();
					if($result_array){
				$add_q = array(
												 'Contact_ID'             =>(int)$idContact  ,
												 'questions_content_ID'   =>(int)$q_ID ,
												 'answer_content'         =>$txt_attach_f ,
												 'answer_detail'          =>$answer,
												  'test_id'               =>$txt_test_ID,
												 'Token'                  =>$Token,
												 'is_updated'             =>1,
												 'is_updated_date'        =>$Timezone,
												 'Date_Stm'               =>$Timezone,
												 'Inserted_By'            => $this->session->userdata('RedirectUser'),
				                                'Inserted_At'             => $Timezone
												 );
					}else{$add_q = array(
												 'Contact_ID'             =>(int)$idContact  ,
												 'questions_content_ID'   =>(int)$q_ID ,
												 'answer_content'         =>$txt_attach_f ,
												 'answer_detail'          =>$answer,
												  'test_id'               =>$txt_test_ID,
												 'Token'                  =>$Token,
												 'Date_Stm'               =>$Timezone,
												 'Inserted_By'            => $this->session->userdata('RedirectUser'),
				                                'Inserted_At'             => $Timezone
												 );}
				
			$Insert_q =  $this->db->insert('test_student', $add_q);
		 add_notification( $this->db->insert_id(),2,0,0,0 ,$idContact);
		}else {
			$ResultContactData = $ResultContactData ->result() ;
			foreach($ResultContactData as $row ){
			$question_s_id = $row->ID;
	 		}
			$Token   = $this->create_token();
		/*	if($txt_attach_f==""){
				$add_q = array(
					 'Contact_ID'             =>(int)$idContact  ,
					 'questions_content_ID'   =>(int)$q_ID ,
					 'Degree'                 =>0 ,
					 'Token'                  =>$Token
					 );

				}else{ */
				$Degree="NULL";
			$add_q = array(
											 'Contact_ID'             =>(int)$idContact  ,
											 'questions_content_ID'   =>(int)$q_ID ,
											 'answer_content'         =>$txt_attach_f ,
											 'answer_detail'          =>$answer,
											 'test_id'               =>$txt_test_ID,
											 'Token'                  =>$Token,
											 'is_updated'             =>1,
											 'Degree'                 =>$dd,
											 'is_updated_date'        =>$Timezone,
											 'Updated_by'             => $this->session->userdata('RedirectUser'),
				                             'Updated_at'             => $Timezone
											 );
				
	 	 $this->db->where('ID', (int)$question_s_id);
	 	$Insert_q =  $this->db->update('test_student', $add_q);
			 
		 
		 
			}
			$x++;
	 }}
	 public function insert_upload_answer($answer,$txt_attach_f,$q_ID)
	 { 
		$idContact           = (int)$this->session->userdata('id'); 
		$txt_test_ID         = (int)$this->input->post("txt_test_ID");  
		$this->db->select('ID,Degree');	
		$this->db->from('test_student');	
		$this->db->where('Contact_ID',(int)$idContact);	
		$this->db->where('questions_content_ID',(int)$q_ID);
		$this->db->limit(1);
		$ResultContactData = $this->db->get();			
		$NumRowResultContactData  = $ResultContactData->num_rows() ; 
		if($NumRowResultContactData <=0)
		  { 
			$idContact           = (int)$this->session->userdata('id'); 
			$Token   = $this->create_token();
			/*if($txt_attach_f==""){
				$add_q = array(
					 'Contact_ID'             =>(int)$idContact  ,
					 'questions_content_ID'   =>(int)$q_ID ,
					 'Degree'                 =>0 ,
					 'Token'                  =>$Token
					 );

				}else{*/
					$query = $this->db->query("select num_student from test where test.ID=$txt_test_ID and (num_student) REGEXP  $idContact");
					$result_array = $query->result_array();
					if($result_array){
				$add_q = array(
												 'Contact_ID'             =>(int)$idContact  ,
												 'questions_content_ID'   =>(int)$q_ID ,
												 'answer_content'         =>$txt_attach_f ,
												 'answer_detail'          =>$answer,
												  'test_id'                =>$txt_test_ID,
												 'Token'                  =>$Token,
												 'is_updated'             =>1
												 );
					}else{$add_q = array(
												 'Contact_ID'             =>(int)$idContact  ,
												 'questions_content_ID'   =>(int)$q_ID ,
												 'answer_content'         =>$txt_attach_f ,
												 'answer_detail'          =>$answer,
												  'test_id'               =>$txt_test_ID,
												 'Token'                  =>$Token
												 );}
				
			$Insert_q =  $this->db->insert('test_student', $add_q);
		 add_notification( $this->db->insert_id(),2,0,0,0 ,$idContact);
		}else {
			$ResultContactData = $ResultContactData ->result() ;
			foreach($ResultContactData as $row ){
			$question_s_id = $row->ID;
	 		}
			$Token   = $this->create_token();
		/*	if($txt_attach_f==""){
				$add_q = array(
					 'Contact_ID'             =>(int)$idContact  ,
					 'questions_content_ID'   =>(int)$q_ID ,
					 'Degree'                 =>0 ,
					 'Token'                  =>$Token
					 );

				}else{ */
				$Degree="NULL";
			$add_q = array(
											 'Contact_ID'             =>(int)$idContact  ,
											 'questions_content_ID'   =>(int)$q_ID ,
											 'answer_content'         =>$txt_attach_f ,
											 'answer_detail'          =>$answer,
											 'test_id'               =>$txt_test_ID,
											 'Token'                  =>$Token,
											 'is_updated'             =>1,
											 'Degree'                 =>$dd
											 );
				
		 //	 $this->db->where('ID', (int)$question_s_id);
		 //	$Insert_q =  $this->db->update('test_student', $add_q);
			
			
		 	$Insert_q =  $this->db->insert('test_student', $add_q);
	   	   add_notification( $this->db->insert_id(),2,0,0,0 ,$idContact);
		 
		 
			}
	 }
	// not answer
 public function not_answer($q_id_edit)
	 {      	
	 		  $txt_test_ID         = (int)$this->input->post("txt_test_ID");  
			  $idContact           = (int)$this->session->userdata('id'); 
			  $Token               = $this->create_token();		 
			  $this->db->select('questions_content_ID');	
			  $this->db->from('vw_test_question_select');	
			  $this->db->where('test_ID',$txt_test_ID);
			  $ResultContactData = $this->db->get();			
			  $NumRowResultContactData  = $ResultContactData->num_rows() ;
			  
			  if($NumRowResultContactData <=0){
				  }else{
				   $ResultContactData = $ResultContactData ->result() ;
				  // print_r($ResultContactData);die;
				   foreach($ResultContactData as $row ){
						$q_cntnt_ID = $row->questions_content_ID;
						if(!in_array($q_cntnt_ID , $q_id_edit)){
							  $this->db->select('ID');	
							  $this->db->from('test_student');	
							  $this->db->where('Contact_ID',$idContact);
							  $this->db->where('questions_content_ID',$q_cntnt_ID);
							  $ResultContactDataS = $this->db->get();			
							  $NumRowResultContactDataS  = $ResultContactDataS->num_rows() ; 
							  if($NumRowResultContactDataS<=0){
								   $add_q = array(
											 'Contact_ID'             =>(int)$idContact  ,
											 'questions_content_ID'   =>(int)$q_cntnt_ID ,
											 'Degree'                 =>0 ,
											 'Token'                  =>$Token,
											 'test_id'                =>$txt_test_ID
											 );
								   $Insert_q =  $this->db->insert('test_student', $add_q);
		 add_notification( $this->db->insert_id(),2,0,0,0 ,$idContact);
								  }else{
									 /* $ResultContactDataS = $ResultContactDataS ->result() ;
									   foreach($ResultContactDataS as $rowS ){
										   $ID_t_s = $rowS->ID;
										   }
										  $add_q = array(
														 'Contact_ID'             =>(int)$idContact  ,
														 'questions_content_ID'   =>(int)$q_cntnt_ID ,
														 'Degree'                 =>0 ,
														 'Token'                  =>$Token
														 );
										   $this->db->where('ID', (int)$ID_t_s);
										   $Insert_q =  $this->db->update('test_student', $add_q);*/
							  }
							}
					}
					/*print_r($q_cntnt_ID);
					echo '<br/>';
					print_r($q_id_edit);*/
					
				  }
	 }
 //insert_s_d_upload
	 public function insert_s_d_upload($s_degree,$t_degree,$t_s_ID)
	 {
		 foreach($t_s_ID as $key =>$row){
			 if($s_degree[$key]!=""&&$s_degree[$key]<=$t_degree[$key]){
				 $update = array( 'Degree'  =>$s_degree[$key]  );
				 $this->db->where('ID', $row);
				 $update =  $this->db->update('test_student', $update);
			 }
		 }
	 }
 //check_del_answer
	 public function check_del_answer($answerID , $question_ID,$all_answer,$q_count,$idContact)
	 {
		$this->db->select('Question,Degree');	
		$this->db->from('questions_content');	
		$this->db->where('ID',$question_ID);
		$ResultData = $this->db->get();			
		$NumRowResultData  = $ResultData->num_rows() ; 
		if($NumRowResultData <=0)
		  {
			return 0;	
		  }
		else 
		{
		   
			$ResultData     = $ResultData ->row_array() ;
			$ques_degree    = explode("%!%",$ResultData['Question']);
			$count_Question = (count($ques_degree)-1);
			$item_degree    = $ResultData['Degree']/$count_Question;
			$degree=0;
			foreach($ques_degree as $key => $value) if(!($key&1)) unset($ques_degree[$key]);
			$ques_degree= implode(',',$ques_degree);
			$ques_degree= explode(',',$ques_degree);
		
            foreach($all_answer as $key=>$item)
			{
				$answer_replace = 'ans_'.$q_count.'_';
				$item_answer = (int)str_replace($answer_replace,'',$item);
				
				if($key==$item_answer){
					$degree=$degree+$item_degree;
					}
			}
					$this->db->select('ID,Degree');	
					$this->db->from('test_student');	
					$this->db->where(array('Contact_ID'=>(int)$idContact,'questions_content_ID'=>(int)$question_ID));	
					$this->db->limit(1);
					$ResultContactData = $this->db->get();			
					$NumRowResultContactData  = $ResultContactData->num_rows() ; 
					if($NumRowResultContactData ==0)
					  { 
						$Token   = $this->create_token();
						$add_q = array('Contact_ID'=>$idContact , 'questions_content_ID'=>$question_ID,'Degree'=>$degree,'Token'=>$Token); 
					   $this->db->insert('test_student', $add_q);
		 add_notification( $this->db->insert_id(),2,0,0,0 ,$idContact);
			      }else {
					$q_id_edit           = 	$question_ID;	
					$ResultContactData = $ResultContactData ->result() ;
					foreach($ResultContactData as $row ){
					$question_s_id = $row->ID;
					}
					$Token   = $this->create_token();
					$add_q = array(
													 'Contact_ID'             =>(int)$idContact  ,
													 'questions_content_ID'   =>(int)$question_ID ,
													 'Degree'                 =>$degree ,
													 'Token'                  =>$Token
													 );
					 $this->db->where('ID', (int)$question_s_id);
					$Insert_q =  $this->db->update('test_student', $add_q);					  
			            }
			  return $degree;
			
		}
	 }

 public function get_student_class  ()
	 {
			  $idContact           = (int)$this->session->userdata('id'); 

		$this->db->select('Class_ID');	
		$this->db->from('student');	
		$this->db->where('Contact_ID',$idContact); 
		$ResultContactData = $this->db->get();			
		if($ResultContactData ->num_rows()>0)
					{			
						$ReturnResult = $ResultContactData->row_array() ;
						return $ReturnResult['Class_ID'] ;  
					}else{
						return 0 ;  
						}
	 }
	 ///////////////////////////
	 public function degree_report_homework($DayDateFrom,$DayDateTo,$SubjectID)
	 { 
	     $where='';
	   if($DayDateFrom != 0 && $DayDateTo != 0){
 		$where = " and 
	     date(test.date_from)  BETWEEN '$DayDateFrom'  AND '$DayDateTo'  ";
     	} 
	   //if($DateF==0){
	   //  $date="DATE(test.date_from) >= (NOW() - INTERVAL 3 DAY)";}
	   //else{$date= "DATE(test.date_from) >='".$DateF."'";}
	   if($SubjectID==0){$SubjectID="NULL";}
	   $idContact           = (int)$this->session->userdata('id');
		$query=$this->db->query("SELECT ts.test_id, ts.SumDegreeSt,qc.SumDegreeQ,subject.Name AS subject_name,test.* ,stu_date,stu_date_updated,is_updated
		FROM test
        RIGHT JOIN (SELECT test_student.Date_Stm AS stu_date,test_student.is_updated_date AS stu_date_updated,test_student.is_updated AS is_updated,SUM(Degree)AS SumDegreeSt,test_id 
        FROM test_student
        WHERE test_student.Contact_ID=".$idContact."
        GROUP BY test_id) ts ON ts.test_id =  test.ID 
        RIGHT  JOIN ( SELECT SUM(Degree)AS SumDegreeQ,test_id 
        FROM questions_content
        GROUP BY test_id) qc ON qc.test_id =  test.ID 
        INNER JOIN subject ON subject.ID=test.subject_id
        where test.type=1  $where
        and test.subject_id=IFNULL($SubjectID,test.subject_id)
        GROUP BY  test.ID
			  ");
		      if($query->num_rows()>0){$Result = $query->result() ;return $Result ;}else{return 0;}   
	 }
	 
	 
	  public function degree_report_exam($DayDateFrom,$DayDateTo,$SubjectID)
	 { 
	     $where='';
	   if($DayDateFrom != 0 && $DayDateTo != 0){
 		$where = " and 
		date(test.date_from)  BETWEEN '$DayDateFrom'  AND '$DayDateTo'  ";
     	} 
	   //if($DateF==0){
	   //  $date="DATE(test.date_from) >= (NOW() - INTERVAL 3 DAY)";}
	   //else{$date= "DATE(test.date_from) >='".$DateF."'";}
	   if($SubjectID==0){$SubjectID="NULL";}
	   $idContact           = (int)$this->session->userdata('id');
		$query=$this->db->query("SELECT ts.test_id, ts.SumDegreeSt,qc.SumDegreeQ,subject.Name AS subject_name,test.* ,stu_date,stu_date_updated,is_updated
		FROM test
        RIGHT JOIN (SELECT test_student.Date_Stm AS stu_date,test_student.is_updated_date AS stu_date_updated,test_student.is_updated AS is_updated,SUM(Degree)AS SumDegreeSt,test_id 
        FROM test_student
        WHERE test_student.Contact_ID=".$idContact."
        GROUP BY test_id) ts ON ts.test_id =  test.ID 
        RIGHT  JOIN ( SELECT SUM(Degree)AS SumDegreeQ,test_id 
        FROM questions_content
        GROUP BY test_id) qc ON qc.test_id =  test.ID 
        INNER JOIN subject ON subject.ID=test.subject_id
        where test.type=0  $where
        and test.subject_id=IFNULL($SubjectID,test.subject_id)
        GROUP BY  test.ID
			  ");
		      if($query->num_rows()>0){$Result = $query->result() ;return $Result ;}else{return 0;} 
	 }
	 
  public function answer_exam($test_ID,$student_id){
     
     $query=$this->db->query("SELECT test_id ,Contact_ID, is_updated 
			  FROM test_student
              where test_id=$test_ID and Contact_ID=$student_id
			  ");
		      if($query->num_rows()>0){$Result = $query->result() ;return $Result ;}else{return 0;}
     }
      public function answer_exam2($test_ID,$student_id){
     
     $query=$this->db->query("SELECT is_updated 
			  FROM test_student
              where test_id=$test_ID and Contact_ID=$student_id 
			  ");
		      if($query->num_rows()>0){$Result = $query->row_array() ;return $Result ;}else{return 0;}
     }
    
	 /////////////////////////////////////
     
 }

?>