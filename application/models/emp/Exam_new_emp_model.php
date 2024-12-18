<?php
class Exam_New_Emp_Model  extends CI_Model 
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
 //get_del_degree
	 public function get_sum_degree($testID)
	 {
		$this->db->select('sum(questions_content.Degree) as Degrees');
		$this->db->from('questions_content');
		$this->db->join('test_questions', 'test_questions.Questions_ID =questions_content.ID', 'INNER');
		$this->db->where('test_questions.Test_ID',(int)$testID);
 
		$ResultExam = $this->db->get();			
		$NumRowResultExam = $ResultExam->num_rows() ; 
		
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->row_array() ;
				 
			   return $ReturnExam['Degrees']; 
			   
			   return TRUE ; 
							 
			  }else{return 0 ;}
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
 //get_exams
	 public function get_exam($Lang)
	 {
		 
		$idContact    = (int)$this->session->userdata('id'); 
		
	
		$classIDSession = (int)$this->session->userdata('classIDSession');
		if($Lang=="english"){
			 $this->db->select('test.Name, test.Description ,test.ID,test.job_specializationsID as Subject_emp_ID,test.time_count,job_specializations.Name AS subject_Name   ');
		 }else
		 {				
			$this->db->select('test.Name, test.Description ,test.ID,test.job_specializationsID as Subject_emp_ID,test.time_count,job_specializations.Name AS subject_Name  ');
		 }
		$this->db->from('test');			
 		$this->db->join('job_specializations', 'job_specializations.ID =test.job_specializationsID', 'INNER');	
 		$this->db->join('contact', 'test.empID =contact.ID', 'INNER');			
 		$this->db->where('test.IsActive',1);
		$this->db->where('test.type',5);
		$this->db->where('test.empID',$idContact); 
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
 //get_specific_exam
	 public function get_specific_exam($ID,$Lang)
	 {
		$idContact    = (int)$this->session->userdata('id'); 
		
		if($Lang=="english"){
		$this->db->select('test.ID AS test_ID,test.date_to,test.date_from ,test.Name, test.Description  ,test.time_count ,test.ID,test.job_specializationsID as SubjectID,job_specializations.Name AS subject_Name ,test.num_student ');
		 }
		else
		 {	
		$this->db->select('test.ID AS test_ID,test.date_to,test.date_from, 
		test.Name, test.Description  ,test.time_count ,test.ID,test.job_specializationsID as Subject_ID,job_specializations.Name AS subject_Name ,test.num_student');}
		$this->db->from('test');	
 		$this->db->join('job_specializations', 'job_specializations.ID =test.job_specializationsID', 'INNER');	
 		$this->db->join('contact', 'test.empID =contact.ID', 'INNER');	
		$this->db->where('test.empID',$idContact); 	
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
 //get_specific_exam_Admin
	 public function get_specific_exam_admin($ID,$Lang)
	 {
		$idContact    = (int)$this->session->userdata('id'); 
		
		if($Lang=="english"){
		$this->db->select('test.ID AS test_ID,test.date_to,test.date_from ,test.Name, test.Description  ,test.time_count ,test.ID,test.job_specializationsID as SubjectID,job_specializations.Name AS subject_Name ,test.num_student ');
		 }
		else
		 {	
		$this->db->select('test.ID AS test_ID,test.date_to,test.date_from, 
		test.Name, test.Description  ,test.time_count ,test.ID,test.job_specializationsID as Subject_ID,job_specializations.Name AS subject_Name ,test.num_student');}
		$this->db->from('test');	
 		$this->db->join('job_specializations', 'job_specializations.ID =test.job_specializationsID', 'INNER');	
 		$this->db->join('contact', 'test.empID =contact.ID', 'INNER');	
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
 		 (string)$this->slct_subject     = $data['slct_subject'] ;
		 (string)$this->txt_exam         = $data['txt_exam'] ;
		 (string)$this->txt_time         = $data['txt_time'] ;
 		 (string)$this->txt_description  = $data['txt_description'] ;
		 (string)$this->Token            = $this->create_token();
 
			      
			   
		 
		 $Add_exam = array(
							 'type'                 => 5,
							 'Name'                 =>(string)$this->txt_exam  ,
							 'Description'          =>(string)$this->txt_description  ,
							 'time_count'           =>(string)$this->txt_time  ,
							 'job_specializationsID'       =>(int)$this->slct_subject  ,
 							 'empID'              => (int)$idContact ,
							 'Token'                =>(string)$this->Token,
							 'date_from'            =>$data['Date_from'] ,
							 'date_to'              =>$data['Date_to'] ,
 							 'num_student'          =>$data['num_student'] 
							 );
		 
        $Insert_Exam =  $this->db->insert('test', $Add_exam); 
		 //add_notification( $this->db->insert_id(),2,0,(int)$config_emp_ID,0 ,0);
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
							 'job_specializationsID'=>(int)$this->slct_subject  ,
							 'empID'                =>(int)$idContact  ,
 							 'date_from'            =>$data['Date_from'] ,
							 'date_to'              =>$data['Date_to'] ,
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
	 
 
 }
?>