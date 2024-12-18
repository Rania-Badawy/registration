<?php
class Answer_Exam_Model  extends CI_Model 
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
 //get_exam_subject
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
	}
// 	public function get_exams1($test_ID)
// 	 {
		 
					
// 		$this->db->select('*');


// 		$this->db->from('vw_home_select');			
		
// 		$this->db->where('test_ID',$test_ID); 
// 		$ResultExam = $this->db->get();			
// 		$NumRowResultExam = $ResultExam->num_rows() ; 
		
// 			if($NumRowResultExam >0)
// 			  {
// 				$ReturnExam     = $ResultExam ->row_array() ;
// 			   return $ReturnExam ; 
			   
// 			   return TRUE ; 
							 
// 			  }else{return $NumRowResultExam ;return FALSE ;}
// 	} 
	public function get_student_classes ($idContact)
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
		  public function get_subject($test_ID)
	 { 
	     
	      $this->db->select('subject_id,Name');
		$this->db->from('test');
		$this->db->where('ID', $test_ID);
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
	     
	public function insert_student_degrees($answer,$id_q_degree,$idContact,$test_ID)
	 { 
	 
		 $q_id_edit =  array();
			foreach($id_q_degree as $id_q=>$degree)
			  { 
			        $txt_test_ID         = (int)$this->input->post("txt_test_ID");
			        $clerical = $this->get_student_classes($idContact);
			        $SubjectID=$this->get_subject($test_ID);
					$q_id_edit[]    = 	$id_q;	 
					$this->db->select('ID,Degree');	
					$this->db->from('test_student');	
					$this->db->where(array('Contact_ID'=>(int)$idContact,'questions_content_ID'=>(int)$id_q));	
					$this->db->limit(1);
					$ResultContactData = $this->db->get();			
					$NumRowResultContactData  = $ResultContactData->num_rows() ; 
					if($NumRowResultContactData ==0)
					  { 
					     
				    
				    $SchoolID	= (int)$this->session->userdata('SchoolID') ;
				    $Token   = $this->create_token();
					$add_q = array('Contact_ID'=>$idContact , 'questions_content_ID'=>$id_q,'Degree'=>$degree,'Token'=>$Token ,'answer_content' =>$answer,'test_id'=>$txt_test_ID );
					
				  $this->db->insert('test_student', $add_q);
			
				$Type_ID=(int)11;
				  add_notification( $this->db->insert_id(),2,0,0,0 ,$idContact);
					  
				  	$this->db->select('type ');	
					$this->db->from('test');	
					$this->db->where('ID',$test_ID);	
					$ResultContactData = $this->db->get();
					$NumRowResultContactData  = $ResultContactData->result() ; 
				
					if($NumRowResultContactData[0]->type==1)
					  { 
				  $add_q1 = array('Stu_ID  '=>$idContact ,'Stu_Degree'=>$degree ,'Test_ID' => $test_ID ,'Type_ID '=>11,'School_ID'=>$SchoolID,'Subject_ID'=>$SubjectID['subject_id'],	'R_L_ID'=>$clerical['R_L_ID'],
						'Class_ID'=>$clerical['Class_ID'],'Name'=>$SubjectID['Name']);
				  
				  $this->db->insert('send_box_student', $add_q1);
					  }
				  else{$add_q2 = array('Stu_ID  '=>$idContact ,'Stu_Degree'=>$degree ,'Test_ID' => $test_ID ,'Type_ID '=>8,'School_ID'=>$SchoolID,'Subject_ID'=>$SubjectID['subject_id'],	'R_L_ID'=>$clerical['R_L_ID'],
						'Class_ID' =>$clerical['Class_ID'],'Name'=>$SubjectID['Name']);
				  
				  $this->db->insert('send_box_student', $add_q2);}
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
													 'answer_content'         =>$answer,
													 'Token'                  =>$Token
													 );
					 $this->db->where('ID', (int)$question_s_id);
					$Insert_q =  $this->db->update('test_student', $add_q);	
						$add_q1 = array(
													 'Stu_ID  '=>$idContact ,'Stu_Degree'=>$degree ,'Test_ID' => $test_ID 
													 );
					 $this->db->where('Test_ID', (int)$test_ID);
					$Insert_q1 =  $this->db->update('send_box_student', $add_q1);
			            }
			  }
	
			  return true;
	 }
	 public function get_exams_header($Lang,$subjectID,$exam_ID='')
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
			 
		$this->db->select('vw_test.ID AS test_ID , vw_test.Name AS test_Name, vw_test.empID AS teacher_Name, vw_test.Description As test_Description, vw_test.time_count ,vw_test.date_from , vw_test.date_to, vw_test.num_student as num_student');


		$this->db->from('contact');			
		$this->db->join('student', 'student.Contact_ID = contact.ID ', 'INNER');	
	    $this->db->join('class_table', 'class_table.RowLevelID = student.R_L_ID and class_table.ClassID = student.Class_ID ', 'INNER');	
	    $this->db->join('test AS vw_test', 'vw_test.empID = class_table.EmpID and vw_test.RowLevelID	=  student.R_L_ID  ' , 'INNER');
 		$this->db->join('test_questions', 'vw_test.ID = test_questions.Test_ID', 'INNER');
 	
		$this->db->where('vw_test.IsActive',1);
		$this->db->where('vw_test.type',0);
 			if($exam_ID !='')
 			{$this->db->where('vw_test.ID',$exam_ID);}
		$this->db->where('contact.ID',$idContact);
		$this->db->where('vw_test.subject_id',$subjectID); 
		$this->db->where('vw_test.RowLevelID',$R_L_ID);
		$this->db->where('vw_test.classID REGEXP ',$Class_ID);
		$this->db->where('vw_test.SchoolId', (int)$this->session->userdata('SchoolID'));
	   // $this->db->where('vw_test.date_to  >=CURDATE()'); 
	//	$this->db->where("vw_test.date_from >'2020-10-30 07:53:00'");
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
		public function get_exams_header1($Lang,$subjectID)
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
		$this->db->select(
		    'send_box.Test_ID  as test_ID ,send_box.Class_ID as classID, send_box.Name as test_Name, send_box.time_count as  time_count, send_box.Stu_Degree  as Stu_Degree , send_box.Degree as Degree
		     ');


		$this->db->from('send_box');			
		$this->db->join('student', 'student.Class_ID = send_box.Class_ID', 'INNER');	
		$this->db->where('send_box.Type_ID',2);
		$this->db->where('send_box.Is_Active',1);
		$this->db->where('student.Contact_ID',$idContact);
		$this->db->where('send_box.Subject_ID ',$subjectID); 
		$this->db->where('send_box.School_ID', (int)$this->session->userdata('SchoolID'));
// 		$this->db->where('CURRENT_TIMESTAMP() BETWEEN send_box.date_from  and send_box.Date_to  '); 
	//	$this->db->where('send_box.Stu_Degree',NULL,FALSE);
	//	$this->db->where("send_box.date_from >'2020-10-30 07:53:00'");
		$this->db->where('send_box.R_L_ID',$R_L_ID);
		$this->db->where('send_box.Class_ID  REGEXP ',$Class_ID);
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
	 public function get_exams_headerx($Lang,$subjectID)
	 {
		 
	/*	$idContact = (int)$this->session->userdata('id'); 
					
		$this->db->select(
		    'vw_test.test_ID ,vw_test.classID, vw_test.test_Name, vw_test.test_Description, vw_test.time_count,
		    vw_test.contact_Name as teacher_Name, vw_test.subject_Name, vw_test.config_semester_Name, vw_test.row_level_Name ,vw_test.date_from  as date_from ,test.num_student as num_student');


		$this->db->from('contact');			
		$this->db->join('student', 'student.Contact_ID = contact.ID', 'INNER');	
				
	    $this->db->join('class_table', 'class_table.RowLevelID = student.R_L_ID and class_table.ClassID = student.Class_ID ', 'INNER');	
	    $this->db->join('vw_test_select AS vw_test', 'vw_test.contact_ID = class_table.EmpID  and vw_test.row_level_ID	=  student.R_L_ID', 'INNER');
		$this->db->join('test_questions', 'vw_test.test_ID = test_questions.Test_ID', 'INNER');
        $this->db->join('contact as emp', 'emp.ID = vw_test.contact_ID', 'INNER');
        $this->db->join('test', 'test.ID = vw_test.test_ID', 'INNER');
        
		
		 $this->db->where('emp.SchoolID',(int)$this->session->userdata('SchoolID') );
		
		$this->db->where('vw_test.IsActive',1);
		$this->db->where('contact.ID',$idContact);
		$this->db->where('vw_test.Subject_ID',$subjectID); 
		$this->db->where('class_table.SchoolID', (int)$this->session->userdata('SchoolID'));
		//$this->db->where('CURRENT_TIMESTAMP() BETWEEN test.date_from and test.date_to'); 
		$this->db->where("test.date_from >'2020-08-12 07:53:00'");
		$this->db->group_by('vw_test.test_ID');
		$ResultExam = $this->db->get();	 	
		$NumRowResultExam = $ResultExam->num_rows() ; 
 
			if($NumRowResultExam >0)
			  {	 
				$ReturnExam     = $ResultExam->result() ;
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{return $NumRowResultExam ;return FALSE ;}*/
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
			 
		$this->db->select('vw_test.ID AS test_ID , vw_test.Name AS test_Name, vw_test.Description As test_Description, vw_test.time_count ,vw_test.date_from , vw_test.date_to, vw_test.num_student   as num_student');


		$this->db->from('contact');			
		$this->db->join('student', 'student.Contact_ID = contact.ID ', 'INNER');	
	    $this->db->join('class_table', 'class_table.RowLevelID = student.R_L_ID and class_table.ClassID = student.Class_ID ', 'INNER');	
	    $this->db->join('test AS vw_test', 'vw_test.empID = class_table.EmpID and vw_test.RowLevelID	=  student.R_L_ID  ' , 'INNER');
 		$this->db->join('test_questions', 'vw_test.ID = test_questions.Test_ID', 'INNER');
 	//	$this->db->join('test_student', 'vw_test.ID = test_student.test_id ', 'INNER');
 	//	$this->db->join('questions_content', 'vw_test.ID = questions_content.test_id ', 'INNER');
		$this->db->where('vw_test.IsActive',1);
		$this->db->where('vw_test.type',0);
	//	$this->db->where('vw_test.config_semester_ID',2);
		$this->db->where('contact.ID',$idContact);
		$this->db->where('vw_test.subject_id',$subjectID); 
		$this->db->where('vw_test.RowLevelID',$R_L_ID);
		$this->db->where('vw_test.classID REGEXP ',$Class_ID);
		$this->db->where('contact.SchoolID', (int)$this->session->userdata('SchoolID'));
	   // $this->db->where('vw_test.date_to  >=CURDATE()'); 
		$this->db->where("date_from >'2020-08-12 07:53:00'");
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
	/// get_sum_degree

	public function get_sum_degree($TestID, $sid = null)
	{
		$StudentID = $sid ?? (int)$this->session->userdata('id');
        $result = $this->db->query("
		SELECT sum(questions_content.Degree)  AS SumDegreeQ 
		  FROM questions_content WHERE test_id = ".$TestID."
		");
		$NumRowResultExam = $result->num_rows() ; 
			if($NumRowResultExam >0)
			  {	
				$result2 = $this->db->query("SELECT SUM(test_student.Degree)AS SumDegreeSt  FROM test_student 
				WHERE test_student.test_id =  ".$TestID." AND test_student.Contact_ID = ".$StudentID." 
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
        $this->db->select(" send_box_student.Stu_Degree AS Stu_Degree"); 
  	    $this->db->from('send_box_student');
		$this->db->where('send_box_student.Test_ID',$TestID);
		$this->db->where('send_box_student.Stu_ID',$StudentID);
	   	$this->db->group_by('send_box_student.Test_ID');
		$ResultExam = $this->db->get();	 	
		$NumRowResultExam = $ResultExam->num_rows() ; 
 
			if($NumRowResultExam >0)
			  {	 
				$ReturnExam     = $ResultExam->result() ;
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{return $NumRowResultExam ;return FALSE ;}
			  
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
// 	 public function get_exam_no_rpt($Lang)
// 	 {
		
// 		$Data['ExamID'] = $this->session->userdata('ExamID') ;
					
// 		$this->db->select('test.date_from, test.date_to, test_ID,test_Name,test_Description,vw_test_question_select.time_count,test_attach_file,questions_content_ID,Degree,Question,questions_types_ID,questions_types_Name');
// 		$this->db->from('vw_test_question_select');	
// 		$this->db->join('test','vw_test_question_select.test_ID = test.ID');
// 		$this->db->where('test_ID',$Data['ExamID']);
// 		$this->db->where('test_IsActive',1);
// 		$this->db->where('q_IsActive',1);
// 		$this->db->group_by('questions_types_ID'); 
// 		$this->db->order_by('questions_types_ID', "asc");
// 		$ResultExam = $this->db->get();			
// 		$NumRowResultExam = $ResultExam->num_rows() ; 
// 			if($NumRowResultExam >0)
// 			  {
// 				$ReturnExam     = $ResultExam ->result() ;
// 			   return $ReturnExam ; 
			   
// 			   return TRUE ; 
							 
// 			  }else{return $NumRowResultExam ;return FALSE ;}
// 	}
public function get_exam_no_rpt($Lang)
	 {
		
		$Data['ExamID'] = $this->session->userdata('ExamID') ;
			if($Lang=="english"){
			    	$this->db->select('test.date_from, test.date_to, test_ID,test_Name,test_Description,vw_test_question_select.time_count,test_attach_file,questions_content_ID,Degree,Question,questions_types_ID,questions_types.Name_en as questions_types_Name');
			}else
		 {
		$this->db->select('test.date_from, test.date_to, test_ID,test_Name,test_Description,vw_test_question_select.time_count,test_attach_file,questions_content_ID,Degree,Question,questions_types_ID,questions_types_Name');
		 }
		$this->db->from('vw_test_question_select');	
		$this->db->join('test','vw_test_question_select.test_ID = test.ID');
			$this->db->join('questions_types','vw_test_question_select.questions_types_ID  = questions_types.ID');
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
		$this->db->select('Degree,test_ID ');	
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
													 'Token'                  =>$Token
													 );
					 $this->db->where('ID', (int)$question_s_id);
					$Insert_q =  $this->db->update('test_student', $add_q);					  
			            }
			  }
	
			  return true;
	 }
	//insert_upload_answer
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
				$add_q = array(
												 'Contact_ID'             =>(int)$idContact  ,
												 'questions_content_ID'   =>(int)$q_ID ,
												 'answer_content'         =>$txt_attach_f ,
												 'answer_detail'          =>$answer,
												 'Token'                  =>$Token,
												 'test_id'                =>$txt_test_ID,
												 );
				
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
			$add_q = array(
											 'Contact_ID'             =>(int)$idContact  ,
											 'questions_content_ID'   =>(int)$q_ID ,
											 'answer_content'         =>$txt_attach_f ,
											 'answer_detail'          =>$answer,
											 'Token'                  =>$Token
											 );
				
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
	 public function degree_report_homework($DateF,$SubjectID)
	 { 
	     if($DateF==0){
	         $date="DATE(test.date_from) >= (NOW() - INTERVAL 3 DAY)";}
	         else{$date= "DATE(test.date_from) >='".$DateF."'";}
	     if($SubjectID==0){$SubjectID="NULL";}
	     $idContact           = (int)$this->session->userdata('id');
			  $query=$this->db->query("SELECT ts.test_id, ts.SumDegreeSt,qc.SumDegreeQ,ts.Date_Stm,subject.Name AS subject_name,test.* 
			  FROM test
               RIGHT  JOIN ( SELECT Date_Stm,SUM(Degree)AS SumDegreeSt,test_id 
               FROM test_student
               WHERE test_student.Contact_ID=".$idContact."
              GROUP BY test_id) ts ON ts.test_id =  test.ID 
              RIGHT  JOIN ( SELECT SUM(Degree)AS SumDegreeQ,test_id 
              FROM questions_content
              GROUP BY test_id) qc ON qc.test_id =  test.ID 
              INNER JOIN subject ON subject.ID=test.subject_id
              where test.type=1 and $date
              and test.subject_id=IFNULL($SubjectID,test.subject_id)
              GROUP BY  test.ID
			  ");
		      if($query->num_rows()>0){$Result = $query->result() ;return $Result ;}else{return 0;}   
	 }
	 
	 
	  public function degree_report_exam($DateF,$SubjectID)
	 { 
	       if($DateF==0){
	         $date="DATE(test.date_from) >= (NOW() - INTERVAL 3 DAY)";}
	         else{$date= "DATE(test.date_from) >='".$DateF."'";}
	     if($SubjectID==0){$SubjectID="NULL";}
	     $idContact           = (int)$this->session->userdata('id');
			  $query=$this->db->query("SELECT ts.test_id, ts.SumDegreeSt,qc.SumDegreeQ,ts.Date_Stm,subject.Name AS subject_name,test.* 
			  FROM test
               RIGHT  JOIN ( SELECT Date_Stm,SUM(Degree)AS SumDegreeSt,test_id 
               FROM test_student
               WHERE test_student.Contact_ID=".$idContact."
              GROUP BY test_id) ts ON ts.test_id =  test.ID 
              RIGHT  JOIN ( SELECT SUM(Degree)AS SumDegreeQ,test_id 
              FROM questions_content
              GROUP BY test_id) qc ON qc.test_id =  test.ID 
              INNER JOIN subject ON subject.ID=test.subject_id
              where test.type=0 and $date
              and test.subject_id=IFNULL($SubjectID,test.subject_id)
              GROUP BY  test.ID
			  ");
		      if($query->num_rows()>0){$Result = $query->result() ;return $Result ;}else{return 0;}   
	 }
	  public function exam_report( $LevelID = 0 , $from = 0 , $to = 0, $num =0 ,$subjectID =0,$test =0)
 {
 $where_num='';$where='';$where_test='';
 	if($LevelID == 0 )   {$LevelID = 'NULL' ; }
 	if($subjectID == 0 )   {$subjectID = 'NULL' ; }
 	if($test!=0){ 
 	     	$where_test = "  AND  test.ID=$test   ";
 	} 
 	if($num=='all'){
 	}
 	elseif($num==100){
 	     	$where_num = "  AND  test_student.Degree=questions_content.Degree   ";
 	}
 	elseif($num=='less50'){
 	     	$where_num = "  AND  test_student.Degree!=0 AND  test_student.Degree!=questions_content.Degree AND  test_student.Degree< (questions_content.Degree/2)   ";
 	}
 	elseif($num=='more50'){
 	     	$where_num = "   AND  test_student.Degree!=0 AND  test_student.Degree!=questions_content.Degree  AND  test_student.Degree >(questions_content.Degree/2)   ";
 	}
 	elseif($num==0){
 	     	$where_num = "  AND  test_student.Degree=0   ";
 	}
 
 	if($from != 0 && $to != 0){
 		$where = "  AND 
		(test_student.Date_Stm  BETWEEN CAST('".$from."' AS DATE ) AND CAST('".$to."' AS DATE  )) ";
 	} 
	$query = $this->db->query("
	SELECT * FROM (SELECT 
    test_student.Degree,
	test_student.questions_content_ID,
	 questions_content.Question,
	 questions_content.Degree as questionDegree,
	test.ID as testID,
	test_student.Contact_ID,
	quesanswer.Answer as ques_answer,
	stanswer.Answer as st_answer,
	 subject.Contact_ID as empidsubject, test.empID, test.Name as testname,
	subject.Name AS subject_Name  ,config_semester.Name AS ClassName,stdnt.Name as FullName
	,teacher.Name as teacherName,
	(COUNT(test_student.Contact_ID) OVER (PARTITION BY test_student.questions_content_ID)) AS `failed_count`
	FROM
		test_student
	INNER JOIN questions_content ON test_student.questions_content_ID = questions_content.ID
	INNER JOIN answers as stanswer ON test_student.answer_content = stanswer.ID
	INNER JOIN answers as quesanswer ON questions_content.ID = quesanswer.Questions_Content_ID and quesanswer.Answer_correct =1
	INNER JOIN contact as stdnt ON test_student.Contact_ID = stdnt.ID
	INNER JOIN student ON stdnt.ID = student.Contact_ID

	INNER JOIN test_questions on test_questions.Questions_ID = questions_content.ID 
	INNER JOIN test on test.ID = test_questions.Test_ID 
	
	 
	
	INNER JOIN config_semester on test.config_semester_ID = config_semester.ID
	INNER JOIN config_emp on config_emp.ID =test.Subject_emp_ID 
	INNER JOIN subject on config_emp.SubjectID =subject.ID	
	INNER JOIN contact as teacher On config_emp.EmpID = teacher.ID	

	INNER JOIN contact AS tb2 ON student.Father_ID     = tb2.ID
	
 
	
	WHERE 
	 stdnt.ID = '". $this->session->userdata('id')."'
	AND  `config_emp`.SubjectID     = IFNULL($subjectID , `config_emp`.SubjectID)
	$where $where_num $where_test
	ORDER BY test_student.ID) t1 ");
	// echo json_encode($this->db->last_query()); die();
	if($query->num_rows() > 0 ){return $query->result();}else{return FALSE ; }
 }
  public function answer_exam($test_ID,$student_id){
     
     $query=$this->db->query("SELECT test_id ,Contact_ID
			  FROM test_student
              where test_id=$test_ID and Contact_ID=$student_id
			  ");
		      if($query->num_rows()>0){$Result = $query->result() ;return $Result ;}else{return 0;}
     }
 }

?>