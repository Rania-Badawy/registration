<?php
class Answer_Homework_Model  extends CI_Model 
 {
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
 //get_exam_subject
	 public function get_exam_subject($test_ID )
	 {
		$idContact = (int)$this->session->userdata('id'); 
				
		$this->db->select('  Subject_ID	 ');


		$this->db->from('vw_home_select AS vw_test'); 

		
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
 //get_exams
	 public function get_exams($Lang)
	 {
		 
		$idContact = (int)$this->session->userdata('id'); 
					
		$this->db->select('vw_test.test_ID,vw_test.classID , vw_test.test_Name, vw_test.test_Description, vw_test.time_count, vw_test.contact_Name as teacher_Name, vw_test.subject_Name, vw_test.config_semester_Name, vw_test.row_level_Name');


		$this->db->from('contact');			
		$this->db->join('student', 'student.Contact_ID = contact.ID', 'INNER');			
	    $this->db->join('class_table', 'class_table.RowLevelID = student.R_L_ID and class_table.ClassID = student.Class_ID ', 'INNER');	
	    $this->db->join('vw_home_select AS vw_test', 'vw_test.contact_ID = class_table.EmpID and vw_test.row_level_ID	=  student.R_L_ID ', 'INNER');
				
		$this->db->join('test_questions', 'vw_test.test_ID = test_questions.Test_ID', 'INNER');

		
		$this->db->group_by('vw_test.test_ID');
		$this->db->order_by('vw_test.test_ID', 'DESC');
		$this->db->where('vw_test.IsActive',1);
		$this->db->where('contact.ID',$idContact);
		$this->db->where('class_table.SchoolID', (int)$this->session->userdata('SchoolID'));
		$this->db->where('date_from >=CURDATE() '  ); 
		$ResultExam = $this->db->get();			
		$NumRowResultExam = $ResultExam->num_rows() ; 
		
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->result() ;
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{return $NumRowResultExam ;return FALSE ;}
	}
 //get_exams
 	 public function get_exams_header($Lang,$subjectID,$homeworkID='',$task)
	 {   
	    
	    $idContact = (int)$this->session->userdata('id');
		$this->db->select('Class_ID,R_L_ID');
		$this->db->from('student');	
		$this->db->where('Contact_ID',$idContact);
		$ResultExam1 = $this->db->get();	
		$NumRowResultExam1 = $ResultExam1->num_rows() ; 
			if($NumRowResultExam1 >0)
			  {
				$ReturnExam1     = $ResultExam1 ->row_array() ;
			    $Class_ID       = $ReturnExam1['Class_ID'];
			    $R_L_ID         =$ReturnExam1['R_L_ID'];
			    
			  }
			 
		$this->db->select('vw_test.ID AS test_ID , vw_test.Name AS test_Name,vw_test.empID AS teacher_Name, vw_test.Description As test_Description, vw_test.time_count ,vw_test.date_from , vw_test.date_to, vw_test.num_student as num_student');


		$this->db->from('contact');			
		$this->db->join('student', 'student.Contact_ID = contact.ID ', 'INNER');	
	    $this->db->join('class_table', 'class_table.RowLevelID = student.R_L_ID and class_table.ClassID = student.Class_ID ', 'INNER');	
	    $this->db->join('test AS vw_test', 'vw_test.empID = class_table.EmpID and vw_test.RowLevelID	=  student.R_L_ID  ' , 'INNER');
//  		$this->db->join('test_questions', 'vw_test.ID = test_questions.Test_ID', 'INNER');
 	//	$this->db->join('test_student', 'vw_test.ID = test_student.test_id ', 'INNER');
		$this->db->where('vw_test.IsActive',1);
		$this->db->where('vw_test.type',1);
		$this->db->where('vw_test.is_deleted',0);
		$this->db->where('contact.ID',$idContact);
		$this->db->where('vw_test.subject_id',$subjectID); 
		$this->db->where('vw_test.RowLevelID',$R_L_ID);
		$this->db->where('vw_test.classID REGEXP ',$Class_ID);
		$this->db->where('vw_test.SchoolId', (int)$this->session->userdata('SchoolID'));
		if($task){
		$this->db->where('vw_test.ID',$homeworkID);
		}
		$this->db->group_by('vw_test.ID');
		$ResultExam = $this->db->get();
		$NumRowResultExam = $ResultExam->num_rows() ; 
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->result() ;
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{return $NumRowResultExam ;return FALSE ;}
			  
	}
	 public function get_exams_headerx($Lang,$subjectID)
	 { 
       
	    $idContact = (int)$this->session->userdata('id');
		$this->db->select('vw_test.test_ID ,vw_test.classID, vw_test.test_Name, vw_test.test_Description, vw_test.time_count, vw_test.contact_Name as teacher_Name, vw_test.subject_Name, vw_test.config_semester_Name, vw_test.row_level_Name , vw_test.date_from , vw_test.date_to ');


		$this->db->from('contact');			
		$this->db->join('student', 'student.Contact_ID = contact.ID', 'INNER');	
	    $this->db->join('class_table', 'class_table.RowLevelID = student.R_L_ID and class_table.ClassID = student.Class_ID ', 'INNER');	
	    $this->db->join('vw_home_select AS vw_test', 'vw_test.contact_ID = class_table.EmpID and vw_test.row_level_ID	=  student.R_L_ID ' , 'INNER');
 		$this->db->join('test_questions', 'vw_test.test_ID = test_questions.Test_ID', 'INNER');
        $this->db->join('contact as emp', 'emp.ID = vw_test.contact_ID', 'INNER');
		 $this->db->where('emp.SchoolID',(int)$this->session->userdata('SchoolID') );
		$this->db->where('vw_test.IsActive',1);
	//	$this->db->where('vw_test.config_semester_ID',2);
		$this->db->where('contact.ID',$idContact);
		$this->db->where('vw_test.Subject_ID',$subjectID); 
		$this->db->where('class_table.SchoolID', (int)$this->session->userdata('SchoolID'));
		//$this->db->where('date_from >=CURDATE() '  ); 
			$this->db->where("date_from >'2020-08-12 07:53:00'");
		$this->db->group_by('vw_test.test_ID');
		$ResultExam = $this->db->get();
		$NumRowResultExam = $ResultExam->num_rows() ; 
 
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->result() ;
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{return $NumRowResultExam ;return FALSE ;}
			  
	}
		public function get_exams_header_old($Lang,$subjectID)
	 {
		 
		$idContact = (int)$this->session->userdata('id'); 
					
		$this->db->select(
		    'send_box.Test_ID  as test_ID ,send_box.Class_ID as classID, send_box.Name as test_Name, send_box.time_count as  time_count, send_box.Degree  as Degree
		     ');


		$this->db->from('send_box');			
		$this->db->join('student', 'student.Class_ID = send_box.Class_ID', 'INNER');	
				
	    $this->db->join('class_table', 'class_table.RowLevelID = student.R_L_ID and class_table.ClassID = student.Class_ID ', 'INNER');	
		$this->db->where('send_box.Type_ID',6);
		$this->db->where('send_box.Is_Active',1);
		$this->db->where('student.Contact_ID',$idContact);
		$this->db->where('send_box.Subject_ID ',$subjectID); 
		$this->db->where('class_table.SchoolID', (int)$this->session->userdata('SchoolID'));
// 		$this->db->where('CURRENT_TIMESTAMP() BETWEEN send_box.date_from  and send_box.Date_to  '); 
	   $this->db->where("send_box.date_from >'2020-08-14 07:53:00'");
		$this->db->where('send_box.Stu_Degree',NULL,FALSE);
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
 //get_homework
	 public function get_homework($Lang)
	 {
		$idContact = (int)$this->session->userdata('id'); 
		$this->db->select('Class_ID');
		$this->db->from('student');	
		$this->db->where('Contact_ID',$idContact);
		$ResultExam = $this->db->get();	
		$NumRowResultExam = $ResultExam->num_rows() ; 
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->row_array() ;
			    $Class_ID       = $ReturnExam['Class_ID'];
			  
		$this->db->select('vw_test.test_ID , vw_test.test_Name, vw_test.test_Description, vw_test.time_count, vw_test.contact_Name as teacher_Name, vw_test.subject_Name, vw_test.config_semester_Name, vw_test.row_level_Name');


		$this->db->from('contact');			
		$this->db->join('student', 'student.Contact_ID = contact.ID', 'INNER');			
	    $this->db->join('vw_home_select AS vw_test', 'vw_test.row_level_ID = student.R_L_ID', 'INNER');	
		$this->db->join('test_questions', 'vw_test.test_ID = test_questions.Test_ID', 'INNER');

		
		$this->db->group_by('vw_test.test_ID');
		$this->db->where('vw_test.IsActive',1);
		$this->db->where('contact.ID',$idContact);
		$this->db->like('vw_test.classID', $Class_ID ); 
		$ResultExam = $this->db->get();			
		$NumRowResultExam = $ResultExam->num_rows() ; 
		
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->result() ;
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{return $NumRowResultExam ;return FALSE ;}  }else{return FALSE ;}
	}
	/// get_sum_degree
	public function get_sum_degree($TestID, $sid = null)
	{
		$StudentID = $sid ?? (int)$this->session->userdata('id');
        $result = $this->db->query("
		SELECT test_Degree AS SumDegreeQ 
		 FROM vw_home_select WHERE test_ID = ".$TestID."
		");
		$NumRowResultExam = $result->num_rows() ; 
			if($NumRowResultExam >0)
			  {	
				$result2 = $this->db->query("SELECT SUM(test_student.Degree)AS SumDegreeSt  FROM test_student 
				 RIGHT JOIN test_questions ON test_student.questions_content_ID =  test_questions.Questions_ID 
				WHERE test_questions.Test_ID =  ".$TestID." AND test_student.Contact_ID = ".$StudentID." 
				");	
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
	
	/// get_sum_degree_home
	public function get_sum_degree_home($TestID)
	{
		$StudentID =(int)$this->session->userdata('id'); 
        $result = $this->db->query("
		SELECT test_Degree AS SumDegreeQ 
		 FROM vw_home_select WHERE test_ID = ".$TestID."
		");
		$NumRowResultExam = $result->num_rows() ; 
			if($NumRowResultExam >0)
			  {	
				$result2 = $this->db->query("SELECT SUM(test_student.Degree)AS SumDegreeSt  FROM test_student 
				 RIGHT JOIN test_questions ON test_student.questions_content_ID =  test_questions.Questions_ID 
				WHERE test_questions.Test_ID =  ".$TestID." AND test_student.Contact_ID = ".$StudentID." 
				");	
				$NumRowResultExam = $result2->num_rows() ; 
				if($NumRowResultExam >0)
				  {	
					
					$data2 = $result2->row_array();
					 
				  }else{$data2=0;}$data = $result->row_array();
				  return array_merge($data,$data2);
			  }
		
	}
	
	
 //get_questions
	 public function get_questions($Lang)
	 {
		
		$Data['ExamID'] = $this->session->userdata('ExamID') ;
					
		$this->db->select('questions_content_ID,Degree,Question,Q_attach,q_Token,questions_types_Name,questions_types_ID,questions_types_Name,youtube_script');

		$this->db->from('vw_test_question_select');	
		$this->db->where('test_ID',$Data['ExamID']);
		$this->db->group_by('questions_content_ID'); 
		$this->db->order_by('questions_types_ID', "desc");
		$ResultExam = $this->db->get();			
		$NumRowResultExam = $ResultExam->num_rows() ; 
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->result() ;
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{return $NumRowResultExam ;return FALSE ;}
	}
 //get_answers
	 public function get_answers($Lang)
	 {
		
		$Data['ExamID'] = $this->session->userdata('ExamID') ;
					
		$this->db->select('Answer_ID,Answer,Answer_correct,answers_IsActive,answers_Token,answers_Date_Stm,questions_content_ID');

		$this->db->from('vw_test_question_select');	
		$this->db->where('test_ID',$Data['ExamID']);
		$this->db->order_by('questions_types_ID', "desc");
		$ResultExam = $this->db->get();			
		$NumRowResultExam = $ResultExam->num_rows() ; 
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->result() ;
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{return $NumRowResultExam ;return FALSE ;}
	}
 //get_exam_no_rpt
	 public function get_exam_no_rpt($Lang)
	 {
		
		$Data['ExamID'] = $this->session->userdata('ExamID') ;
					
		$this->db->select('test_ID,test_Name,test_Description,time_count,test_attach_file,questions_content_ID,Degree,Question,questions_types_ID,questions_types_Name');
		$this->db->from('vw_test_question_select');	
		$this->db->where('test_ID',$Data['ExamID']);
		$this->db->where('test_IsActive',1);
		$this->db->where('q_IsActive',1);
		$this->db->group_by('questions_types_ID'); 
		$this->db->order_by('questions_types_ID', "asc");
		$ResultExam = $this->db->get();			
		$NumRowResultExam = $ResultExam->num_rows() ; 
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->result() ;
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{return $NumRowResultExam ;return FALSE ;}
	}
 //check_answer
	 public function check_answer($answerID , $question_ID)
	 {
		$this->db->select('Degree');	
		$this->db->from('vw_test_question_select');	
		$this->db->where('questions_content_ID',$question_ID);
		$this->db->where('answers_IsActive',1);
		$this->db->where('Answer_correct',1);
		$this->db->where('Answer_ID',$answerID);
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
			return (int)$ResultContactData['Degree'];
		}
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
					$add_q = array('Contact_ID'=>$idContact , 'questions_content_ID'=>$id_q,'Degree'=>$degree,'Token'=>$Token); 
				  $this->db->insert('test_student', $add_q);
		 add_notification( $this->db->insert_id(),3,0,0,0 ,$idContact);


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
													 'Token'                  =>$Token
													 );
					 $this->db->where('ID', (int)$question_s_id);
					$Insert_q =  $this->db->update('test_student', $add_q);					  
			            }
			  }
	
			  return true;
	 }
	//insert_upload_answer
		 public function insert_upload_answer_array($q_answers_id_6,$txt_attach_f_6,$q_old_id_6)
	 {$x=0;
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
												  'test_id'=>$txt_test_ID,
												 'Token'                  =>$Token,
												 'is_updated'             =>1
												 );
					}else{$add_q = array(
												 'Contact_ID'             =>(int)$idContact  ,
												 'questions_content_ID'   =>(int)$q_ID ,
												 'answer_content'         =>$txt_attach_f ,
												 'answer_detail'          =>$answer,
												  'test_id'=>$txt_test_ID,
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
				
	 	 $this->db->where('ID', (int)$question_s_id);
	 	$Insert_q =  $this->db->update('test_student', $add_q);
			 
		 
		 
			}
			$x++;
	 }}
	 public function insert_upload_answer($txt_attach_f,$q_ID)
	 {
		$idContact           = (int)$this->session->userdata('id'); 		 
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
			if($txt_attach_f==""){
				$add_q = array(
					 'Contact_ID'             =>(int)$idContact  ,
					 'questions_content_ID'   =>(int)$q_ID ,
					 'Degree'                 =>0 ,
					 'Token'                  =>$Token
					 );

				}else{
				$add_q = array(
												 'Contact_ID'             =>(int)$idContact  ,
												 'questions_content_ID'   =>(int)$q_ID ,
												 'answer_content'         =>$txt_attach_f ,
												 'Token'                  =>$Token
												 );
				}
			$Insert_q =  $this->db->insert('test_student', $add_q);
		 add_notification( $this->db->insert_id(),3,0,0,0 ,$idContact);
		}else {
			$ResultContactData = $ResultContactData ->result() ;
			foreach($ResultContactData as $row ){
			$question_s_id = $row->ID;
	 		}
			$Token   = $this->create_token();
			if($txt_attach_f==""){
				$add_q = array(
					 'Contact_ID'             =>(int)$idContact  ,
					 'questions_content_ID'   =>(int)$q_ID ,
					 'Degree'                 =>0 ,
					 'Token'                  =>$Token
					 );

				}else{
			$add_q = array(
											 'Contact_ID'             =>(int)$idContact  ,
											 'questions_content_ID'   =>(int)$q_ID ,
											 'answer_content'         =>$txt_attach_f ,
											 'Token'                  =>$Token
											 );
				}
			 $this->db->where('ID', (int)$question_s_id);
			$Insert_q =  $this->db->update('test_student', $add_q);
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
											 'Token'                  =>$Token
											 );
								   $Insert_q =  $this->db->insert('test_student', $add_q);
		 add_notification( $this->db->insert_id(),3,0,0,0 ,$idContact);
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
			$all_answer     = explode(",",$all_answer);
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

		 add_notification( $this->db->insert_id(),3,0,0,0 ,$idContact);
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
 public function answer_exam($test_ID,$student_id){
     
     $query=$this->db->query("SELECT test_id ,Contact_ID
			  FROM test_student
              where test_id=$test_ID and Contact_ID=$student_id
			  ");
		      if($query->num_rows()>0){$Result = $query->result() ;return $Result ;}else{return 0;}
     }
     public function answer_exam2($test_ID,$student_id){
     
     $query=$this->db->query("SELECT is_updated 
			  FROM test_student
              where test_id=$test_ID and Contact_ID=$student_id and is_updated=0
			  ");
		      if($query->num_rows()>0){$Result = $query->result() ;return $Result ;}else{return 0;}
     }
     ///
 }

?>