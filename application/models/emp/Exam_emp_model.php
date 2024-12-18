<?php
class Exam_Emp_Model extends CI_Model 
 {
	 private $txt_exam ;
	 private $slct_subject ;
	 private $slct_Semester ;
	 private $txt_description ;
	 private $txt_time  ;
	 private $Token ;
	 private $ID ;
	 private $txt_test_ID ;
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
 //get_subject_emp_id
	 public function get_subject_emp_id($row_level_id , $subject_id)
	 {
		$idContact = (int)$this->session->userdata('id'); 
		$Where  = array('EmpID'=>$idContact,'SubjectID'=> $subject_id,'RowLevelID'=>$row_level_id);
		$this->db->select('ID');
		$this->db->from('config_emp');	
		$this->db->where($Where);
		$ResultExam = $this->db->get();			
		$NumRowResultExam = $ResultExam->num_rows() ; 
		
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->row_array() ;
			   return $ReturnExam['ID'] ; 
			   
			   return TRUE ; 
							 
			  }else{return 0;} 
	 }
 //get_subject_emp_id_by_class
	 public function get_subject_emp_id_by_class($row_level_id )
	 {	  
		$idContact = (int)$this->session->userdata('id'); 
		$Where  = array('EmpID'=>$idContact,'RowLevelID'=>$row_level_id);
		$this->db->select('ID');
		$this->db->from('config_emp');	
		$this->db->where($Where);
		$ResultExam = $this->db->get();			
		$NumRowResultExam = $ResultExam->num_rows() ; 
		
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->result() ;
			    $array_subject  = array();
				foreach($ReturnExam as $key=>$item){
					$array_subject[$key]=$item->ID;
					}
			   return $array_subject ; 
			   
			   return TRUE ; 
							 
			  }else{return 0;} 
	 }
 //get_classID
	 public function get_classID($row_level_id , $subject_id)
	 {
		$idContact = (int)$this->session->userdata('id'); 
		$Where  = array('class_table.EmpID'=>$idContact,'class_table.SubjectID'=> $subject_id,'class_table.RowLevelID'=>$row_level_id,'base_class_table.IsActive'=> 1 );
		$this->db->select('class_table.ID');
		$this->db->from('class_table');	
		$this->db->join('base_class_table', 'base_class_table.ID =class_table.BaseTableID', 'INNER');
		$this->db->group_by('class_table.ClassID');	
		$this->db->where($Where);
		$ResultExam = $this->db->get();			
		$NumRowResultExam = $ResultExam->num_rows() ; 
		
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->row_array() ;
			   return $ReturnExam['ID'] ; 
			   
			   return TRUE ; 
							 
			  }else{return 89899;} 
	 }
 //get_class_classID
	 public function get_class_classID($row_level_id , $classID)
	 {
		$idContact = (int)$this->session->userdata('id'); 
		$Where  = array('class_table.EmpID'=>$idContact,'class_table.ClassID'=> $classID,'class_table.RowLevelID'=>$row_level_id,'base_class_table.IsActive'=> 1 );
		$this->db->select('class_table.ID');
		$this->db->from('class_table');	
		$this->db->join('base_class_table', 'base_class_table.ID =class_table.BaseTableID', 'INNER');
		$this->db->group_by('class_table.ClassID');	
		$this->db->where($Where);
		$ResultExam = $this->db->get();			
		$NumRowResultExam = $ResultExam->num_rows() ; 
		
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->row_array() ;
			   return $ReturnExam['ID'] ; 
			   
			   return TRUE ; 
							 
			  }else{return 0;} 
	 }
 //get_upload_answers
	 public function get_upload_answers($test_ID , $student_ID)
	 {
		$this->db->select('test_student.ID as t_s_ID,test_student.answer_content,vw_test_question_select.Question,vw_test_question_select.Degree as q_Degree,vw_test_question_select.Q_attach');
		$this->db->from('vw_test_question_select');	
		$this->db->join('test_student', 'test_student.questions_content_ID =vw_test_question_select.questions_content_ID', 'INNER');
		$this->db->join('`questions_types', 'questions_types.ID =vw_test_question_select.questions_types_ID', 'INNER');
		$this->db->where('vw_test_question_select.test_ID',$test_ID);
		$this->db->where('test_student.Contact_ID',$student_ID);
		$this->db->where('questions_types.ID',6);
		$this->db->where('test_student.Degree IS NULL', null, true);
		$this->db->where('test_student.answer_content IS NOT NULL', null, false);
		$ResultExam = $this->db->get();			
		$NumRowResultExam = $ResultExam->num_rows() ; 
		
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->result() ;
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{return $NumRowResultExam ;return FALSE ;} 
	 }
 //get_exams_students
	 public function get_exams_students()
	 {
		$idContact = (int)$this->session->userdata('id'); 
		$this->db->select('vw_test_emp_select.test_ID,vw_test_emp_select.test_Name,vw_test_emp_select.subject_Name,vw_test_emp_select.contact_Name,vw_test_emp_select.row_level_Name,vw_test_emp_select.config_semester_Name,vw_test_emp_select.test_Degree,contact.Name as student_name,contact.ID as student_ID,sum(test_student.Degree)as student_Degree');
		$this->db->from('config_emp');	
		$this->db->join('vw_test_emp_select', 'vw_test_emp_select.Subject_emp_ID =config_emp.ID', 'INNER');
		$this->db->join('test_questions', 'vw_test_emp_select.test_ID =test_questions.Test_ID', 'INNER');
		$this->db->join('questions_content', 'test_questions.Questions_ID =questions_content.ID', 'INNER');
		$this->db->join('test_student', 'test_student.questions_content_ID =questions_content.ID', 'INNER');
		$this->db->join('contact', 'test_student.Contact_ID =contact.ID', 'INNER');
		$this->db->where('config_emp.EmpID',$idContact);
		$this->db->where('vw_test_emp_select.IsActive',1);
		$this->db->group_by('vw_test_emp_select.test_ID,contact.ID');
		$ResultExam = $this->db->get();			
		$NumRowResultExam = $ResultExam->num_rows() ; 
		
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->result() ;
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{return $NumRowResultExam ;return FALSE ;}
	}
 //get_del_degree
	 public function get_del_degree($testID)
	 {
		$this->db->select('questions_content.Degree');
		$this->db->from('questions_content');
		$this->db->join('test_questions', 'test_questions.Questions_ID =questions_content.ID', 'INNER');
		$this->db->where('test_questions.Test_ID',(int)$testID);
		$this->db->where('questions_content.questions_types_ID',7);
		$ResultExam = $this->db->get();			
		$NumRowResultExam = $ResultExam->num_rows() ; 
		
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->result() ;
				$array_degree   = array();
				foreach($ReturnExam as $key=>$item){
					$Degree             = explode('%!%',$item->Degree);
					$array_degree[$key]=array_sum($Degree );
					}
			   return $array_degree ; 
			   
			   return TRUE ; 
							 
			  }else{return $NumRowResultExam ;return FALSE ;}
	 }
 //get_exams_students_father
	 public function get_exams_students_father()
	 {
		$idContact = (int)$this->session->userdata('id'); 
		$this->db->select('contact.Name as student_name,vw_test_emp_select.test_ID,vw_test_emp_select.test_Name,vw_test_emp_select.subject_Name,vw_test_emp_select.contact_Name,vw_test_emp_select.row_level_Name,vw_test_emp_select.config_semester_Name,vw_test_emp_select.test_Degree,sum(test_student.Degree)as student_Degree');
		$this->db->from('student');
		$this->db->join('contact', 'contact.ID =student.Contact_ID', 'INNER');
		$this->db->join('test_student', 'test_student.Contact_ID =student.Contact_ID', 'INNER');
		$this->db->join('test_questions', 'test_questions.Questions_ID =test_student.questions_content_ID', 'INNER');
		$this->db->join('vw_test_emp_select', 'vw_test_emp_select.test_ID =test_questions.Test_ID', 'INNER');
		$this->db->where('student.Father_ID',$idContact);
		$this->db->group_by('vw_test_emp_select.test_ID');
		$ResultExam = $this->db->get();			
		$NumRowResultExam = $ResultExam->num_rows() ; 
		
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->result() ;
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{return $NumRowResultExam ;return FALSE ;}
	}
 //get_exams_students_father_header
	 public function get_exams_students_father_header($studentID)
	 {
		$idContact = (int)$this->session->userdata('id'); 
		$this->db->select('contact.Name as student_name,vw_test_emp_select.test_ID,vw_test_emp_select.test_Name,vw_test_emp_select.subject_Name,vw_test_emp_select.contact_Name,vw_test_emp_select.row_level_Name,vw_test_emp_select.config_semester_Name,vw_test_emp_select.test_Degree,sum(test_student.Degree)as student_Degree');
		$this->db->from('student');
		$this->db->join('contact', 'contact.ID =student.Contact_ID', 'INNER');
		$this->db->join('test_student', 'test_student.Contact_ID =student.Contact_ID', 'INNER');
		$this->db->join('test_questions', 'test_questions.Questions_ID =test_student.questions_content_ID', 'INNER');
		$this->db->join('vw_test_emp_select', 'vw_test_emp_select.test_ID =test_questions.Test_ID', 'INNER');
		$this->db->where('student.Father_ID',$idContact);
		$this->db->where('student.Contact_ID',$studentID);
		$this->db->group_by('vw_test_emp_select.test_ID');
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
	 public function get_exam($Lang)
	 {
		
		$idContact    = (int)$this->session->userdata('id'); 
		$subjectEmpID =$this->session->userdata('subjectEmpIDSession');
		if($subjectEmpID==-1){ 
		if($Lang=="english"){
			 $this->db->select('test.Name, test.Description ,test.ID,test.Subject_emp_ID,test.time_count,subject.Name AS subject_Name , level.Name AS level_Name , row.Name AS row_Name,config_semester.Name_en AS Name_sms  ');
		 }else
		 {				
			$this->db->select('test.Name, test.Description ,test.ID,test.Subject_emp_ID,test.time_count,subject.Name AS subject_Name , level.Name AS level_Name , row.Name AS row_Name,config_semester.Name AS Name_sms');
		 }
		$this->db->from('test');			
		$this->db->join('config_semester', 'test.config_semester_ID =config_semester.ID', 'INNER');			
		$this->db->join('config_emp', 'config_emp.ID =test.Subject_emp_ID', 'INNER');	
		$this->db->join('subject', 'config_emp.SubjectID =subject.ID', 'INNER');		
		$this->db->join('row_level', 'config_emp.RowLevelID =row_level.ID', 'INNER');		
		$this->db->join('row', 'row_level.Row_ID =row.ID', 'INNER');			
		$this->db->join('level', 'row_level.Level_ID =level.ID', 'INNER');
		$this->db->where('test.IsActive',1);
		$this->db->where('test.type',5);
		$this->db->where('config_emp.EmpID',$idContact);
		$this->db->order_by("test.Date_Stm"); 
		$ResultExam = $this->db->get();			
		$NumRowResultExam = $ResultExam->num_rows() ; 
		
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->result() ;
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{return $NumRowResultExam ;return FALSE ;}
		}else{
		$classIDSession = (int)$this->session->userdata('classIDSession');
		if($Lang=="english"){
			 $this->db->select('test.Name, test.Description ,test.ID,test.Subject_emp_ID,test.time_count,subject.Name AS subject_Name , level.Name AS level_Name , row.Name AS row_Name,config_semester.Name_en AS Name_sms  ');
		 }else
		 {				
			$this->db->select('test.Name, test.Description ,test.ID,test.Subject_emp_ID,test.time_count,subject.Name AS subject_Name , level.Name AS level_Name , row.Name AS row_Name,config_semester.Name AS Name_sms');
		 }
		$this->db->from('test');			
		$this->db->join('config_semester', 'test.config_semester_ID =config_semester.ID', 'INNER');			
		$this->db->join('config_emp', 'config_emp.ID =test.Subject_emp_ID', 'INNER');	
		$this->db->join('subject', 'config_emp.SubjectID =subject.ID', 'INNER');		
		$this->db->join('row_level', 'config_emp.RowLevelID =row_level.ID', 'INNER');		
		$this->db->join('row', 'row_level.Row_ID =row.ID', 'INNER');			
		$this->db->join('level', 'row_level.Level_ID =level.ID', 'INNER');
		$this->db->where('test.IsActive',1);
		$this->db->where('test.type',5);
		if(is_array($subjectEmpID) ){
			//$subjectEmpID =implode(",", $subjectEmpID);
			foreach($subjectEmpID as $key=>$item_sub){
				if($key==0){
				$this->db->where('test.Subject_emp_ID',$item_sub);
				}else{
				$this->db->or_where('test.Subject_emp_ID',$item_sub);}
				}
			
			}else{
			$this->db->where('test.Subject_emp_ID',$subjectEmpID);
			}
		//$this->db->like('test.classID',$classIDSession, 'both'); 
		$this->db->order_by("test.Date_Stm", "desc"); 
		$ResultExam = $this->db->get();			
		$str = $this->db->last_query();	
		$NumRowResultExam = $ResultExam->num_rows() ; 
		
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->result() ;
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{return $NumRowResultExam ;return FALSE ;}
			
			}
	}
 //get_specific_exam
	 public function get_specific_exam($ID,$Lang)
	 {
		if($Lang=="english"){
		$this->db->select('test.ID AS test_ID,test.Name, test.Description  ,test.time_count ,test.ID,config_emp.SubjectID,subject.Name AS subject_Name , level.Name AS level_Name , row.Name AS row_Name,config_semester.Name_en AS Name_sms,config_semester.ID AS ID_sms');
		 }
		else
		 {	
		$this->db->select('test.ID AS test_ID,
		test.Name, test.Description  ,test.time_count ,test.ID,test.Subject_emp_ID as Subject_ID,subject.Name AS subject_Name , level.Name AS level_Name , row.Name AS row_Name,config_semester.Name AS Name_sms,config_semester.ID AS ID_sms');}
		$this->db->from('test');	
		$this->db->join('config_semester', 'test.config_semester_ID =config_semester.ID', 'INNER');			
		$this->db->join('config_emp', 'config_emp.ID =test.Subject_emp_ID', 'INNER');	
		$this->db->join('subject', 'config_emp.SubjectID =subject.ID', 'INNER');			
		$this->db->join('row_level', 'config_emp.RowLevelID =row_level.ID', 'INNER');		
		$this->db->join('row', 'row_level.Row_ID =row.ID', 'INNER');			
		$this->db->join('level', 'row_level.Level_ID =level.ID', 'INNER');	
		$this->db->where('test.ID',$ID);
		$this->db->order_by("test.Date_Stm", "desc"); 
		$ResultExam = $this->db->get();			
		$NumRowResultExam = $ResultExam->num_rows() ; 
		
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->result() ;
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{return FALSE ;}
	}
  ///add_exam
	 public function add_exam($data)
	 {
		 $idContact                      = (int)$this->session->userdata('id');
		 (string)$this->slct_Semester    = $data['slct_Semester'] ;	
		 (string)$this->slct_subject     = $data['slct_subject'] ;
		 (string)$this->txt_exam         = $data['txt_exam'] ;
		 (string)$this->txt_time         = $data['txt_time'] ;
		 (string)$this->txt_description  = $data['txt_description'] ;
		 (string)$this->Token            = $this->create_token();
		 
		 $Add_exam = array(
							 'type'                 => 5 ,
							 'Name'                 =>(string)$this->txt_exam  ,
							 'Description'          =>(string)$this->txt_description  ,
							 'time_count'           =>(string)$this->txt_time  ,
							 'Subject_emp_ID'       =>(int)$this->slct_subject  ,
							 'config_semester_ID'   =>(int)$this->slct_Semester  ,
							 'Token'                =>(string)$this->Token,
							 'date_from'            =>$data['Date_from'] ,
							 'date_to'              =>$data['Date_to'] ,
							 'num_student'          =>$data['num_student'] 
							 );
		 
        $Insert_Exam =  $this->db->insert('test', $Add_exam); 
		
		if($Insert_Exam){
			$this->db->select('ID,Token');
			$this->db->from('test');
			$this->db->where('Token', (string)$this->Token );
			$ResultContactData = $this->db->get();			
			$NumRowResultContactData  = $ResultContactData->num_rows() ; 
			if($NumRowResultContactData <=0)
			  {
				return FALSE;	
			  }
        	else 
			{
			   $ReturnExam     = $ResultContactData ->row_array() ;
			   return (int)$ReturnExam['ID'] ; 
			   return TRUE ;
			}
		}else{return FALSE ;}

	 }
   ///edit_exam
	 public function edit_exam($data)
	 {
		 $idContact                      = (int)$this->session->userdata('id');	
		 (string)$this->slct_Semester    = $data['slct_Semester'] ;	
		 (string)$this->slct_subject     = $data['slct_subject'] ;
		 (string)$this->txt_exam         = $data['txt_exam'] ;
		 (string)$this->txt_time         = $data['txt_time'] ;
		 (string)$this->txt_description  = $data['txt_description'] ;
		 (string)$this->txt_test_ID      = $data['txt_test_ID'] ;
		 (string)$this->Token            = $this->create_token();
		 
		 $edit_exam = array(
							 'Name'                 =>(string)$this->txt_exam  ,
							 'Description'          =>(string)$this->txt_description  ,
							 'time_count'           =>(string)$this->txt_time  ,
							 'Subject_emp_ID'       =>(int)$this->slct_subject  ,
							 'config_semester_ID'   =>(int)$this->slct_Semester  ,
							 'Token'                =>(string)$this->Token
							 );
		
		$this->db->where('ID', (int)$this->txt_test_ID); 
        $Insert_Exam =  $this->db->update('test', $edit_exam); 
		
		if($Insert_Exam){
			return TRUE ;
		}else{return FALSE ;}

	 }  
 ///delete_exam
	 public function delete_exam($examID)
	 {
		 
		(int)$this->ID  = $examID['ID'] ;
		
		$this->db->select('ID');
        $this->db->from('test');
        $this->db->where('ID', $this->ID  );
		$ResultContactData = $this->db->get();			
		$NumRowResultContactData  = $ResultContactData->num_rows() ; 
			if($NumRowResultContactData <=0)
			  {
				return FALSE;	
			  }
        	else 
			{
				 $edit_exam = array(
							 'IsActive'   =>0
							 );
		
				$this->db->where('ID', $this->ID ); 
				$Insert_Exam =  $this->db->update('test', $edit_exam); 
				if($Insert_Exam){
					return TRUE ;
				}else{return FALSE ;}
			}
		
	 }
	 
  ///add_exam_fast
	 public function add_exam_fast($data)
	 {
		 $idContact                      = (int)$this->session->userdata('id');
		    $this->db->select('ID');
			$this->db->from('questions_content');
			$this->db->where('degree_difficulty', $data['difficulty_test'] );
			$this->db->limit($data['num_question']);
		 $this->db->order_by('Date_Stm', "desc"); 
			$questions = $this->db->get();			
			$Num  = $questions->num_rows() ; 
			if($Num >0)
			  {
			   $questions     = $questions ->result() ; 
				  if($data['num_question']>$Num){
					  $quest_want = $data['num_question']-$Num;
					  $this->db->select('ID');
			$this->db->from('questions_content');
			$this->db->where('degree_difficulty!=', $data['difficulty_test'] );
			$this->db->limit($quest_want);
		     $this->db->order_by('Date_Stm', "desc"); 
			$quest_want = $this->db->get();			
			$want  = $quest_want->num_rows() ; 
			if($want >0)
			  { 
			  
			   $quest_want     = $quest_want ->result() ;}
					  }
		 (string)$this->slct_Semester    = $data['slct_Semester'] ;	
		 (string)$this->slct_subject     = $data['slct_subject'] ;
		 (string)$this->txt_exam         = $data['txt_exam'] ;
		 (string)$this->txt_time         = $data['txt_time'] ;
		 (string)$this->txt_description  = $data['txt_description'] ;
		 (string)$this->Token            = $this->create_token();
		 
		 $Add_exam = array(
							 'type'                 => 5 ,
							 'Name'                 =>(string)$this->txt_exam  ,
							 'Description'          =>(string)$this->txt_description  ,
							 'time_count'           =>(string)$this->txt_time  ,
							 'Subject_emp_ID'       =>(int)$this->slct_subject  ,
							 'config_semester_ID'   =>(int)$this->slct_Semester  ,
							 'Token'                =>(string)$this->Token,
							 'date_from'            =>$data['Date_from'] ,
							 'date_to'              =>$data['Date_to'] ,
							 'num_student'          =>$data['num_student'] 
							 );
		 
        $Insert_Exam =  $this->db->insert('test', $Add_exam); 
		
		if($Insert_Exam){
			$this->db->select('ID,Token');
			$this->db->from('test');
			$this->db->where('Token', (string)$this->Token );
			$ResultContactData = $this->db->get();			
			$NumRowResultContactData  = $ResultContactData->num_rows() ; 
			if($NumRowResultContactData <=0)
			  {
				return FALSE;	
			  }
        	else 
			{
			   $ReturnExam     = $ResultContactData ->row_array() ;
			   $test_id=$ReturnExam['ID'];
			   foreach($questions as $row){
		 $questions = array(
							 'Test_ID'                 =>  $test_id,
							 'Questions_ID'          => $row->ID ,
							 'Token'                 =>(string)$this->Token
							 );
        $questions =  $this->db->insert('test_questions', $questions); 
				   }
				   if($data['num_question']>$Num) {if($want>0){
			   foreach($quest_want as $row){
				   
		 $quest_want = array(
							 'Test_ID'                 =>  $test_id,
							 'Questions_ID'          => $row->ID ,
							 'Token'                 =>(string)$this->Token
							 );
        $quest_want =  $this->db->insert('test_questions', $quest_want); 
				   }}}
			    $ReturnExam     = $ResultContactData ->result() ;
			   return $ReturnExam ; 
			   return TRUE ;
			}
		}else{return FALSE ;}
			  }else{return FALSE ;
				  }

	 }
 }
?>