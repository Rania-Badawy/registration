<?php
class Homework_New_Model  extends CI_Model 
 {
	 private $txt_exam ;
	 private $slct_subject ;
	 private $slct_Semester ;
	 private $txt_description ;
	 private $txt_time  ;
	 private $Token ;
	 private $ID ;
	 private $txt_test_ID ;

		public function lessonTest($id,$rowLavelID){
		$result = $this->db->query('
			SELECT lesson_prep.Lesson_Title , lesson_prep.ID 
			FROM lesson_prep 
			where 
			lesson_prep.RowLevel_ID = (SELECT tb.RowLevel_ID FROM  lesson_prep as tb WHERE tb.ID = lesson_prep.ID )
			and lesson_prep.Teacher_ID = "'.$this->session->userdata('id').'" and lesson_prep.RowLevel_ID = "'.$this->session->userdata('rowLavelID').'" and lesson_prep.Subject_ID="'. (int) $this->session->userdata('SubjectID').'"
			ORDER BY lesson_prep.ID DESC
		');
		
		return $result->result();
	}

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
		$this->db->where('questions_content.test_id',(int)$testID);
 
		$ResultExam = $this->db->get();			
		$NumRowResultExam = $ResultExam->num_rows() ; 
		
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->row_array() ;
				 
			    return $ReturnExam['Degrees'];
			    
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
		$this->db->select('test_student.ID as t_s_ID,test_student.answer_content,test_student.answer_detail,questions_content.Question,questions_content.Degree as q_Degree,questions_content.Q_attach');
		$this->db->from('test_student');	
		$this->db->join('questions_content', 'questions_content.ID =test_student.questions_content_ID', 'INNER');
		$this->db->join('`questions_types', 'questions_types.ID =questions_content.questions_types_ID', 'INNER');
		$this->db->where('test_student.test_id',$test_ID);
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
	
		$ResultExam = $this->db->query("SELECT `vw_home_select`.`test_ID`, `vw_home_select`.`test_Name`, `vw_home_select`.`subject_Name`, `vw_home_select`.`contact_Name`, `vw_home_select`.`row_level_Name`, `vw_home_select`.`config_semester_Name`, `vw_home_select`.`test_Degree`, `st`.`Name` as `student_name`, `fa`.`Name` as `father_name`, `st`.`ID` as student_ID, sum(test_student.Degree)as student_Degree  FROM  `vw_home_select`  INNER JOIN `vw_test_question_select` ON `vw_home_select`.`test_ID` =`vw_test_question_select`.`test_ID`   INNER JOIN `test_student` ON `test_student`.`questions_content_ID` =`vw_test_question_select`.`questions_content_ID` INNER JOIN `contact` as st ON `test_student`.`Contact_ID` =`st`.`ID` and st.Type= 'S' 
INNER JOIN `student`  ON student.Contact_ID =st.ID
INNER JOIN contact as fa ON student.Father_ID  =fa.ID
 


WHERE `vw_home_select`.`contact_ID` = '".$idContact."' AND `vw_home_select`.`IsActive` = 1 GROUP BY `vw_home_select`.`test_ID`, `st`.`ID`");		



 		$NumRowResultExam = $ResultExam->num_rows() ; 
		
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->result() ;
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{return $NumRowResultExam ;return FALSE ;}
	}
 //get_exams_students
	 public function get_result_students($test_ID)
	 { 
		$idContact = (int)$this->session->userdata('id'); 
		$ResultExam = $this->db->query("SELECT contact.Name as student_name, contact.ID as student_ID, sum(test_student.Degree)as student_Degree, row_level.Level_Name AS level_Name ,
		                                row_level.Row_Name AS row_Name ,test.Name as test_name  ,subject.Name AS subject_Name
		                                FROM  test
		                                LEFT JOIN test_student       ON test_student.test_id =test.ID
		                                LEFT JOIN contact    ON test_student.Contact_ID =contact.ID
                                        LEFT JOIN student    ON student.Contact_ID =contact.ID and contact.Type='S'
                                        INNER JOIN row_level  ON  test.RowLevelID =row_level.ID
                                        INNER JOIN subject    ON test.subject_id =subject.ID
                                        WHERE test.ID = '".$test_ID."' 
                                        GROUP BY  contact.ID  ");		
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
		$this->db->select('contact.Name as student_name,vw_home_select.test_ID,vw_home_select.test_Name,vw_home_select.subject_Name,vw_home_select.contact_Name,vw_home_select.row_level_Name,vw_home_select.config_semester_Name,vw_home_select.test_Degree,sum(test_student.Degree)as student_Degree');
		$this->db->from('student');
		$this->db->join('contact', 'contact.ID =student.Contact_ID', 'INNER');
		$this->db->join('test_student', 'test_student.Contact_ID =student.Contact_ID', 'INNER');
		$this->db->join('test_questions', 'test_questions.Questions_ID =test_student.questions_content_ID', 'INNER');
		$this->db->join('vw_home_select', 'vw_home_select.test_ID =test_questions.Test_ID', 'INNER');
		$this->db->where('student.Father_ID',$idContact);
		$this->db->group_by('vw_home_select.test_ID');
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
		$this->db->select('contact.Name as student_name,vw_home_select.test_ID,vw_home_select.test_Name,vw_home_select.subject_Name,vw_home_select.contact_Name,vw_home_select.row_level_Name,vw_home_select.config_semester_Name,vw_home_select.test_Degree,sum(test_student.Degree)as student_Degree');
		$this->db->from('student');
		$this->db->join('contact', 'contact.ID =student.Contact_ID', 'INNER');
		$this->db->join('test_student', 'test_student.Contact_ID =student.Contact_ID', 'INNER');
		$this->db->join('test_questions', 'test_questions.Questions_ID =test_student.questions_content_ID', 'INNER');
		$this->db->join('vw_home_select', 'vw_home_select.test_ID =test_questions.Test_ID', 'INNER');
		$this->db->where('student.Father_ID',$idContact);
		$this->db->where('student.Contact_ID',$studentID);
		$this->db->group_by('vw_home_select.test_ID');
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
  public function get_exam_old($Lang)
	 {
	     
	     $SubjectID    =(int) $this->session->userdata('SubjectID');
	     $RowLevelID   = (int)$this->session->userdata('rowlevelid');
	     $idContact    = (int)$this->session->userdata('id');
	    //PRINT_R( $idContact);
	     //   DIE();
	     $query = $this->db->query("select * from send_box WHERE Emp_ID=$idContact and Subject_ID=$SubjectID and R_L_ID=$RowLevelID  and Type_ID=6  ")->result();
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
       
	 }
	 public function get_exam($Data)
	 {
		
		$idContact    = (int)$this->session->userdata('id'); 
		$subject      = $Data['SubjectID'] ;
		$row_level    = $Data['rowlevelid'];
		$type         = $Data['type'];
		$this->db->select('row_level.ID as rowLavelID , test.Name, test.Description ,test.ID,test.time_count,test.subject_id AS subjectid,subject.Name AS subject_Name ,
		                   row_level.Level_Name AS level_Name , row_level.Row_Name AS row_Name,config_semester.Name AS Name_sms,test.classID AS class_id ,reporter.Name as rep_name,test.report_degree,
		                   test.report_comment,test.date_eval,test.IsActive');
		$this->db->from('test');			
		$this->db->join('config_semester', 'test.config_semester_ID =config_semester.ID', 'INNER');			
		$this->db->join('subject', 'test.subject_id =subject.ID', 'INNER');		
		$this->db->join('row_level', 'test.RowLevelID =row_level.ID', 'INNER');	
		$this->db->join('contact as reporter','test.reporter_id = reporter.ID','left');
		$this->db->where('test.type',$type);
		$this->db->where('test.is_deleted',0);
		$this->db->where('test.empID',$idContact);
		$this->db->where('test.subject_id',$subject);
		$this->db->where('test.RowLevelID',$row_level);
		$this->db->order_by("test.Date_Stm", "desc"); 
		$ResultExam = $this->db->get();			
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

		$this->db->select('lesson_prep.Lesson_Title AS LessonTitle,test.lessonID,test.ID AS test_ID,test.date_to,test.date_from,test.classID,test.Name, test.Description  ,
		test.time_count ,test.ID,test.subject_id as SubjectID,subject.Name AS subject_Name , row_level.Level_Name AS level_Name , row_level.Row_Name AS row_Name,config_semester.Name_en AS Name_sms,
		config_semester.ID AS ID_sms,test.report_degree, test.report_comment,test.IsActive,test.empID,test.RowLevelID,test.Subject_emp_ID as Subject_ID');
		$this->db->from('test');	
		$this->db->join('config_semester', 'test.config_semester_ID =config_semester.ID', 'INNER');			
		$this->db->join('subject', 'test.subject_id =subject.ID', 'INNER');
		$this->db->join('lesson_prep', 'lesson_prep.ID = test.lessonID', 'left');			
		$this->db->join('row_level', 'test.RowLevelID =row_level.ID', 'INNER');		
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
	     extract($data);
		 $idContact                      = (int)$this->session->userdata('id');
		 $SubjectID                      = (int) $this->session->userdata('SubjectID');
		 $RowLevelID                     = (int)$this->session->userdata('rowlevelid');
		 $SchoolID                       = $this->session->userdata('SchoolID');
		 (string)$this->slct_Semester    = $data['slct_Semester'] ;	
		 (string)$this->slct_subject     = $data['slct_subject'] ;
		 (string)$this->txt_exam         = $data['txt_exam'] ;
		 (string)$this->txt_time         = $data['txt_time'] ;
		 (string)$this->slct_class       = $data['slct_class'] ;
		 (string)$this->txt_description  = $data['txt_description'] ;
		 (string)$this->Token            = $this->create_token();
		 
		 $Add_exam = array(
							 'Name'                 =>(string)$this->txt_exam  ,
							 'Description'          =>(string)$this->txt_description  ,
							 'time_count'           =>$data['txt_time'],
							 'Subject_emp_ID'       =>(int)$this->slct_subject  ,
							 'config_semester_ID'   =>(int)$this->slct_Semester  ,
							 'classID'              =>(string)$this->slct_class ,
							 'Token'                =>(string)$this->Token,
							 'date_from'            =>$data['Date_from'] ,
							 'date_to'              =>$data['Date_to'] ,
							 'type'                 =>1,
							 'lessonID'             =>$data['slct_lesson'],
							 'num_student'          =>$data['num_student'] ,
							 'subject_id'           =>$SubjectID,
							 'RowLevelID'           =>$RowLevelID,
							  'empID'               =>$idContact,
							  'SchoolId'            =>$SchoolID,
							  'IsActive'            =>0,
							  'Date_Stm'            =>$date
							 );
    	
		 
        $Insert_Exam   = $this->db->insert('test', $Add_exam); 
        $insert_id     = $this->db->insert_id();
         add_notification( $this->db->insert_id(),3,0,(int)$this->slct_subject,0 ,0);
        
         $Add_exam1 = array(
							 'Name'                =>(string)$this->txt_exam  ,
							 'Class_ID '           => (string)$this->slct_class ,
							 'date_from'           =>$data['Date_from'] ,
							 'Date_to'             =>$data['Date_to'] ,
							 'Type_ID '            =>(int)6,
							 'Emp_ID '             =>$idContact ,
							 'Subject_ID'          =>$SubjectID ,
							 'R_L_ID'               =>$RowLevelID ,
							 'Is_Active '          =>1,
							 'time_count'          =>$data['txt_time'],
							 'Test_ID'             =>$insert_id,
							 'token'               =>(string)$this->Token,
							 'semester_ID'         =>(int)$this->slct_Semester,
							 'School_ID'           =>$SchoolID,
							 'DATE'                =>$date
							 );
// print_r($SubjectID);
// die();
        $Insert_Exam1 =  $this->db->insert('send_box', $Add_exam1); 
				 add_notification( $this->db->insert_id(),3,0,(int)$this->slct_subject,0 ,0);

		if($Insert_Exam && $Insert_Exam1 ){
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
	     extract($data);
		 $idContact                      = (int)$this->session->userdata('id');	
		 (string)$this->slct_Semester    = $data['slct_Semester'] ;	
		 (string)$this->slct_subject     = $data['slct_subject'] ;
		 (string)$this->txt_exam         = $data['txt_exam'] ;
		 (string)$this->txt_time         = $data['txt_time'] ;
		 (string)$this->txt_description  = $data['txt_description'] ;
		
		
		 (string)$this->Token            = $this->create_token();
		 (string)$this->slct_class = $data['slct_class'] ;
		 $edit_exam = array(
							 'Name'                 =>(string)$this->txt_exam  ,
							 'Description'          =>(string)$this->txt_description  ,
							 'time_count'           =>(string)$this->txt_time  ,
							 'Subject_emp_ID'       =>(int)$this->slct_subject  ,
							 'config_semester_ID'   =>(int)$this->slct_Semester  ,
							 'Token'                =>(string)$this->Token,
							 'lessonID'             => $data['lesson'] ,
							 'date_from'            =>$data['Date_from'] ,
							 'date_to'              => $data['Date_to'],
							 'classID'              => (string)$this->slct_class ,
							 'IsActive'             => $data['IsActive'],
							 'Date_Stm'             =>$date
							 );

		$this->db->where('ID', $data['txt_test_ID']); 
        $Insert_Exam =  $this->db->update('test', $edit_exam); 
		
	    $edit_exam1 = array(
							 'Name'                 =>(string)$this->txt_exam  ,
							 'time_count'           =>(string)$this->txt_time  ,
							 'semester_ID'          =>(int)$this->slct_Semester  ,
							 'token'                =>(string)$this->Token,
							 'date_from'            =>$data['Date_from'] ,
							 'Date_to'              => $data['Date_to'],
							 'Class_ID'             => (string)$this->slct_class ,
							 'DATE'                 =>$date
							 );
		
		$this->db->where('Test_ID', $data['txt_test_ID']); 
        $Insert_Exam1 =  $this->db->update('send_box', $edit_exam1); 
		if($Insert_Exam && $Insert_Exam1){
			return TRUE ;
		}else{return FALSE ;}

	 }  
 ///delete_exam
	 public function delete_exam($examID,$Timezone)
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
							 'is_deleted'   =>1,
							 'Date_Stm'     =>$Timezone
							 );
		
				$this->db->where('ID', $this->ID ); 
				$Insert_Exam =  $this->db->update('test', $edit_exam); 
				$edit_exam1 = array(
							 'is_deleted '   =>1,
							 'DATE'          =>$Timezone
							 );
		
				$this->db->where('Test_ID ', $this->ID ); 
				$Insert_Exam =  $this->db->update('send_box', $edit_exam1); 
				if($Insert_Exam && $edit_exam1){
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
							 'Name'                 =>(string)$this->txt_exam  ,
							 'Description'          =>(string)$this->txt_description  ,
							 'time_count'           =>(string)$this->txt_time  ,
							 'Subject_emp_ID'       =>(int)$this->slct_subject  ,
							 'config_semester_ID'   =>(int)$this->slct_Semester  ,
							 'Token'                =>(string)$this->Token,
							 'date_from'            =>$data['Date_from'] ,
							 'date_to'              =>$data['Date_to'] ,
							 	 'type'              =>1,
 							 'num_student'          =>$data['num_student'] 
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

	 } //get_classes
	 public function get_classes($ID)
	 { 
		if($this->session->userdata('language')=="english"){
		$this->db->select('class.Name_en as Name , class.ID');  }
		else
		 { $this->db->select('class.Name  as Name, class.ID');}
		$this->db->from('config_emp');	
		$this->db->join('class_table', 'class_table.RowLevelID = config_emp.RowLevelID ', 'INNER'); 
		$this->db->join('class', 'class.ID =class_table.ClassID', 'INNER'); 
		$this->db->where('class_table.EmpID',(int)$this->session->userdata('id'));
		$this->db->where('config_emp.ID',(int)$ID);
	//	$this->db->where('class_table.SchoolID',(int)$this->session->userdata('SchoolID'));
		$this->db->group_by( "class_table.ClassID" ); 
		$ResultExam = $this->db->get();		 
		$NumRowResultExam = $ResultExam->num_rows() ; 
		
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->result() ;
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{return FALSE ;}
	} 
 //get_class_name
	 public function get_class_name($ID)
	 { 
		if($this->session->userdata('language')=="english"){
		$this->db->select('class.Name_en as Name , class.ID');  }
		else
		 { $this->db->select('class.Name  as Name, class.ID');}
		$this->db->from('class');	 
		$this->db->where('ID',(int)$ID);
 		$ResultExam = $this->db->get();		 
		$NumRowResultExam = $ResultExam->num_rows() ; 
		
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->row_array() ;
			   return $ReturnExam['Name'] ; 
			   
			   return TRUE ; 
							 
			  }else{return FALSE ;}
	}
		public function test_class($class_ID){
		$result = $this->db->query("select ID,Name from class where ID IN( $class_ID)  ");
		
		return $result->result();
	}
		public function get_test_eva($ID)
{
   $query=$this->db->query("select report_degree,date_eval,report_comment,reporter_id from  test where ID=$ID AND reporter_id !='NULL' ") ;
   if($query->num_rows()>0)
        {
            return $query->result();
        }else{return false ;}
}
  //insert_s_d_upload
	 public function insert_s_d_upload($s_degree,$t_degree,$t_s_ID)
	 {
		 foreach($t_s_ID as $key =>$row){
			 if($s_degree[$key]!=""&&$s_degree[$key]<=$t_degree[$key]){
				 $query=$this->db->query("select Degree from test_student where ID = $row AND Degree IS NULL AND last_degree IS NOT NULL ")->row_array();
			     if($query){
				 $update = array( 'Degree'  =>$s_degree[$key]);
			     }else{
			     $update = array( 'Degree'  =>$s_degree[$key] ,'last_degree'=>$s_degree[$key] );
			     }
				 $this->db->where('ID', $row);
				 $update =  $this->db->update('test_student', $update);
			 }
		 }
	 }

 }
?>