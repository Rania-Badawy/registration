<?php
class Homework_Model  extends CI_Model 
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
		$this->db->select('vw_select.test_ID,vw_select.test_Name,vw_select.subject_Name,vw_select.contact_Name,vw_select.row_level_Name,vw_select.config_semester_Name,vw_select.test_Degree,contact.Name as student_name,contact.ID as student_ID,sum(test_student.Degree)as student_Degree');
		$this->db->from('config_emp');	
		$this->db->join('vw_home_select as vw_select', 'vw_select.Subject_emp_ID =config_emp.ID', 'INNER');
		$this->db->join('test_questions', 'vw_select.test_ID =test_questions.Test_ID', 'INNER');
		$this->db->join('questions_content', 'test_questions.Questions_ID =questions_content.ID', 'INNER');
		$this->db->join('test_student', 'test_student.questions_content_ID =questions_content.ID', 'INNER');
		$this->db->join('contact', 'test_student.Contact_ID =contact.ID', 'INNER');
		$this->db->where('config_emp.EmpID',$idContact);
	    $this->db->where('vw_select.IsActive',1);
		$this->db->group_by('vw_select.test_ID,contact.ID');
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
		$this->db->select('contact.Name as student_name,vw_test_select.test_ID,vw_test_select.test_Name,vw_test_select.subject_Name,vw_test_select.contact_Name,vw_test_select.row_level_Name,vw_test_select.config_semester_Name,vw_test_select.test_Degree,sum(test_student.Degree)as student_Degree');
		$this->db->from('student');
		$this->db->join('contact', 'contact.ID =student.Contact_ID', 'INNER');
		$this->db->join('test_student', 'test_student.Contact_ID =student.Contact_ID', 'INNER');
		$this->db->join('test_questions', 'test_questions.Questions_ID =test_student.questions_content_ID', 'INNER');
		$this->db->join('vw_home_select as vw_test_select', 'vw_test_select.test_ID =test_questions.Test_ID', 'INNER');
		$this->db->where('student.Father_ID',$idContact);
		$this->db->group_by('vw_test_select.test_ID');
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
		$this->db->select('contact.Name as student_name,vw_test_select.test_ID,vw_test_select.test_Name,vw_test_select.subject_Name,vw_test_select.contact_Name,vw_test_select.row_level_Name,vw_test_select.config_semester_Name,vw_test_select.test_Degree,sum(test_student.Degree)as student_Degree');
		$this->db->from('student');
		$this->db->join('contact', 'contact.ID =student.Contact_ID', 'INNER');
		$this->db->join('test_student', 'test_student.Contact_ID =student.Contact_ID', 'INNER');
		$this->db->join('test_questions', 'test_questions.Questions_ID =test_student.questions_content_ID', 'INNER');
		$this->db->join('vw_home_select as vw_test_select', 'vw_test_select.test_ID =test_questions.Test_ID', 'INNER');
		$this->db->where('student.Father_ID',$idContact);
		$this->db->where('student.Contact_ID',$studentID);
		$this->db->group_by('vw_test_select.test_ID');
		$ResultExam = $this->db->get();			
		$NumRowResultExam = $ResultExam->num_rows() ; 
		
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->result() ;
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{return $NumRowResultExam ;return FALSE ;}
	}
 //get_class_details
	 public function get_class_details($Lang = NULL)
	 {
		 $Where  = array('row_level.IsActive'=>1,'row.Is_Active'=>1,'level.Is_Active'=>1,'base_class_table.IsActive'=>1);
		$LangArray = array("Name"=>"Name");
		if((string)$Lang ==='english'){ $LangArray = array("Name"=>"Name_en"); }
		$this->db->select("class_table.ClassID ,row_level.ID as rowlevelID ,level.".$LangArray['Name']." AS level,row.".$LangArray['Name']." AS row,class.".$LangArray['Name']." AS className ");
                    $this->db->where($Where);
					$this->db->from('row_level');
		     		$this->db->join('level','level.ID = row_level.Level_ID');
		     		$this->db->join('row','row.ID = row_level.Row_ID');
		     		$this->db->join('class_table','class_table.RowLevelID = row_level.ID');
		     		$this->db->join('class','class_table.ClassID = class.ID');
		     		$this->db->join('base_class_table','base_class_table.ID = class_table.BaseTableID');
					$this->db->where('base_class_table.IsActive ',1);
					$this->db->group_by("class_table.ClassID,class_table.RowLevelID"); 
					$Result = $this->db->get();	
					if($Result->num_rows()>0)
					{			
						$ReturnResult = $Result->result() ;
						return $ReturnResult ;  
					}else{
						return 0 ;  
						}
	 }
 //get_exams
	 public function get_exam($Lang)
	 {
		
		$idContact = (int)$this->session->userdata('id'); 
		$subjectEmpID = $this->session->userdata('subjectEmpIDSession');
		if($subjectEmpID==-1){ 
		if($lang=="english"){
			 $this->db->select('class.Name_en as class_Name,test.Name, test.Description ,test.ID,test.Subject_emp_ID,test.time_count,subject.Name AS subject_Name , level.Name AS level_Name , row.Name AS row_Name,config_semester.Name_en AS Name_sms  ');
		 }else
		 {				
			$this->db->select('class.Name as class_Name,test.Name, test.Description ,test.ID,test.Subject_emp_ID,test.time_count,subject.Name AS subject_Name , level.Name AS level_Name , row.Name AS row_Name,config_semester.Name AS Name_sms');
		 }
		$this->db->from('test');			
		$this->db->join('config_semester', 'test.config_semester_ID =config_semester.ID', 'INNER');			
		$this->db->join('config_emp', 'config_emp.ID =test.Subject_emp_ID', 'INNER');	
		$this->db->join('subject', 'config_emp.SubjectID =subject.ID', 'INNER');		
		$this->db->join('row_level', 'config_emp.RowLevelID =row_level.ID', 'INNER');		
		$this->db->join('row', 'row_level.Row_ID =row.ID', 'INNER');			
		$this->db->join('level', 'row_level.Level_ID =level.ID', 'INNER');		
		$this->db->join('class', 'class.ID =test.classID', 'INNER');
		$this->db->where('test.IsActive',1);
		$this->db->where('test.type',1);
		$this->db->where('config_emp.EmpID',$idContact);
		$this->db->order_by("test.Date_Stm", "desc");
		$this->db->group_by("test.ID" ); 
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
		$language= $this->session->userdata('language');	
	
		if($language=="english"){
			 $this->db->select('class.Name_en as class_Name,test.Name, test.Description ,test.ID,test.Subject_emp_ID,test.time_count,subject.Name AS subject_Name , level.Name AS level_Name , row.Name AS row_Name,config_semester.Name_en AS Name_sms  ');
		 }else
		 {				
			$this->db->select('class.Name as class_Name,test.Name, test.Description ,test.ID,test.Subject_emp_ID,test.time_count,subject.Name AS subject_Name , level.Name AS level_Name , row.Name AS row_Name,config_semester.Name AS Name_sms');
		 }
		$this->db->from('test');			
		$this->db->join('config_semester', 'test.config_semester_ID =config_semester.ID', 'INNER');			
		$this->db->join('config_emp', 'config_emp.ID =test.Subject_emp_ID', 'INNER');	
		$this->db->join('subject', 'config_emp.SubjectID =subject.ID', 'INNER');		
		$this->db->join('row_level', 'config_emp.RowLevelID =row_level.ID', 'INNER');		
		$this->db->join('row', 'row_level.Row_ID =row.ID', 'INNER');			
		$this->db->join('level', 'row_level.Level_ID =level.ID', 'INNER');		
		$this->db->join('class', 'class.ID =test.classID', 'INNER'); 

		$this->db->join('class_table', 'class_table.ClassID=class.ID ', 'INNER');	
		$this->db->where('test.IsActive',1);
		$this->db->where('test.type',1);
		$this->db->where('config_emp.EmpID',$idContact);
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
		$this->db->like('class_table.ID',$classIDSession, 'both'); 
		
		$this->db->group_by("test.ID" );
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
 //get_class_details
	 public function get_class_by_subject($Lang,$slct_subject)
	 {
					$Where  = array('config_emp.ID'=>$slct_subject);
					$LangArray = array("Name"=>"Name");
					if((string)$Lang ==='english'){ $LangArray = array("Name"=>"Name_en"); }
					$this->db->select("class.ID as ClassID ,class.".$LangArray['Name']." AS className , config_emp.ID as config_emp_ID");
                    $this->db->where($Where);
					$this->db->from('config_emp');
		     		$this->db->join('class_table','class_table.RowLevelID = config_emp.RowLevelID and class_table.EmpID = config_emp.EmpID ');
		     		$this->db->join('row_level','row_level.ID =class_table.RowLevelID');
		     		$this->db->join('class','class_table.ClassID = class.ID');
					$this->db->group_by('class_table.ClassID'); 
					$Result = $this->db->get();
 					if($Result->num_rows()>0)
					{			
						$ReturnResult = $Result->result() ;
						return $ReturnResult ;  
					}else{
						return 0 ;  
						}
	 }
 //get_specific_exam
	 public function get_specific_exam($data,$Lang)
	 {
    	$ID     =(int)$data['id'] ;
		if($lang=="english"){
		$this->db->select('row_level.ID AS rowlevelID,test.classID AS classID,test.ID AS test_ID,test.Name, test.Description  ,test.time_count ,test.ID,config_emp.SubjectID,subject.Name AS subject_Name , level.Name AS level_Name , row.Name AS row_Name,config_semester.Name_en AS Name_sms,config_semester.ID AS ID_sms');
		 }
		else
		 {	
		$this->db->select('row_level.ID AS rowlevelID,test.classID AS classID,test.ID AS test_ID,
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
		  $this->Select                   = implode(",", $data['Select']);
		 (string)$this->txt_description  = $data['txt_description'] ;
		 (string)$this->Token            = $this->create_token();
		 
		 $Add_exam = array(
							 'type'                 =>1  ,
							 'Name'                 =>(string)$this->txt_exam  ,
							 'Description'          =>(string)$this->txt_description  ,
							 'classID'              =>$this->Select  ,
							 'Subject_emp_ID'       =>(int)$this->slct_subject  ,
							 'config_semester_ID'   =>(int)$this->slct_Semester  ,
							 'Token'                =>(string)$this->Token 
							 );
		 
        $Insert_Exam =  $this->db->insert('test', $Add_exam); 
				 add_notification( $this->db->insert_id(),3,0,(int)$this->slct_subject,0 ,0);
		
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
			   $ReturnExam     = $ResultContactData ->result() ;
			   return $ReturnExam ; 
			   return TRUE ;
			}
		}else{return FALSE ;}

	 }
   ///edit_exam
	 public function edit_exam($data)
	 {
		 $idContact                      = (int)$this->session->userdata('id');	
		 (string)$this->slct_Semester    = $data['slct_Semester'] ;	
		 $this->slct_subject     = $data['slct_subject'] ;
		 (string)$this->txt_exam         = $data['txt_exam'] ;
		/* $class_array = array();
		 foreach($data['Select'] as $key=>$item){
			 $class_array[$key]=$item;
			 }*/
		 $this->Select            = implode(',',$data['Select'] ) ;
		 (string)$this->txt_description  = $data['txt_description'] ;
		 (string)$this->txt_test_ID      = $data['txt_test_ID'] ;
		 (string)$this->Token            = $this->create_token();
		 
		 $edit_exam = array(
							 'Name'                 =>(string)$this->txt_exam  ,
							 'Description'          =>(string)$this->txt_description  ,
							 'classID'              =>$this->Select  ,
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
 }
?>