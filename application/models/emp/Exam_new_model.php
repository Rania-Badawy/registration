<?php
class Exam_New_Model  extends CI_Model 
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
	/////////////////////////////
	public function get_exam($Data)
	 {
		
		$idContact    = (int)$this->session->userdata('id'); 
		$userType     = $this->session->userdata('type');
		$subject      = $Data['subjectid'] ;
		$row_level    = $Data['rowlevelid'];
		$type         = $Data['type'];
		$SemesterID   = $Data['SemesterID'];
		$this->db->select('test.RowLevelID as rowLavelID , test.Name, test.Description ,test.ID,test.time_count,test.date_from,
		                    test.classID AS class_id ,reporter.Name as rep_name,test.report_degree,test.schoolName,test.rowLevelName,
		                   test.report_comment,test.date_eval,test.IsActive,test.empID');
		$this->db->from('test');		
		$this->db->join('contact as reporter','test.reporter_id = reporter.ID','left');
		$this->db->where('test.type',$type);
		$this->db->where('test.is_deleted',0);
		 $this->db->group_start();
		 $this->db->where('test.empID',$idContact);
		 if($type==4 || $type==5){
			 $this->db->or_where("'$userType'", 'U');
		 }
		 $this->db->group_end();
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
	//////////////////////////////
	 public function test_class($class_ID)
	 {
		    
		    $result = $this->db->query("select ID,Name from class where ID IN($class_ID)");
		
		       return $result->result();
	 }
    ////////////////////////
     public function get_exist_exam($exam_id)
	  {
		$this->db->select('ID');
		$this->db->from('test_student');
		$this->db->where('test_id',$exam_id);
		$ResultExam = $this->db->get();			
		$NumRowResultExam = $ResultExam->num_rows() ; 
		
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->result() ;
				

			   
			   return TRUE ; 
							 
			  }else{
				 
				  return FALSE ;}
	  }
	//////////////////////////////////
	
	public function get_test_eva($ID)
     {
         $query=$this->db->query("select report_degree,date_eval,report_comment,reporter_id from  test where ID=$ID AND reporter_id !='NULL' ") ;
         if($query->num_rows()>0)
           {
             return $query->result();
           }else{return false ;}
     }
     ////////////////////////////
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
 /////////////////////////////////////
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
	 /////////////////////////////////
	  public function get_upload_answers($test_ID , $student_ID)
	 {
	     
	    $query_update = $this->db->query(" SELECT is_updated 
	                                FROM `test_student`  
	                                INNER JOIN `questions_content` ON `questions_content`.`ID` =`test_student`.`questions_content_ID` 
	                                INNER JOIN `questions_types` ON `questions_types`.`ID` =`questions_content`.`questions_types_ID`
	                                WHERE `test_student`.`test_id` = $test_ID 
	                                AND `test_student`.`Contact_ID` = $student_ID 
	                                AND `questions_types`.`ID` = 8
	                                ")->num_rows(); 
	    if($query_update == 2){ $where = " AND test_student.is_updated = 1 "; }                    
	    $query = $this->db->query("SELECT `test_student`.`ID` as `t_s_ID`, `test_student`.`answer_content`, `test_student`.`answer_detail`, `questions_content`.`Question`,
	           `questions_content`.`Degree` as `q_Degree`, `questions_content`.`Q_attach`, `questions_types`.`ID` as `questions_type_ID`, `test_student`.`is_updated`
	            FROM `test_student` 
	            INNER JOIN `questions_content` ON `questions_content`.`ID` =`test_student`.`questions_content_ID` 
	            INNER JOIN `questions_types` ON `questions_types`.`ID` =`questions_content`.`questions_types_ID`
	            WHERE `test_student`.`test_id` = $test_ID 
	            AND `test_student`.`Contact_ID` = $student_ID
	            AND `questions_types`.`ID` in(6,8)
	            AND `test_student`.`Degree` IS NULL 
	            AND test_student.answer_content IS NOT NULL
	            $where
	            ")->result(); 
	
			if($query){return $query ; }else{return FALSE ;} 
	 } 
	 //////////////////////////////////
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
	 ///////////////////////////////////////
	 public function get_student_name_repeat($ID, $Timezone)
	{
		$School_id = (int) $this->session->userdata('SchoolID');
		$query_date = $this->db->query("SELECT ID from test where '" . $Timezone . "' BETWEEN date_from AND date_to AND ID = $ID")->row_array();
		$query = $this->db->query("SELECT repet_exam_type FROM config_emp_school WHERE schoolID = '" . $this->session->userdata('SchoolID') . "'  ")->row_array();
		$query_date2 = $this->db->query("SELECT ID from test_student where test_student.test_id = $ID")->row_array();

		sizeof($query) > 0 ? $repetType = $query['repet_exam_type'] : $repetType = 0;
		if (!empty($query_date)) {
			if ($repetType == 0) {
				if($query_date2){
					// print_r('wwwwwqqwwww');die;

					$ResultExam = $this->db->query("SELECT contact.ID AS ID , contact.Name AS  Name
						from contact 
						inner join student on contact.ID =student.Contact_ID
						inner join test    on student.R_L_ID=test.RowLevelID 
						where test.ID ='" . $ID . "' 
						and contact.Isactive =1 
						and contact.SchoolID=" . $School_id . "
						and	FIND_IN_SET(student.Class_ID,test.classID) 
						and (test.Students ='' OR test.Students IS NULL OR FIND_IN_SET(contact.ID,Students) )
						
						group by contact.ID ")->result();
				}else{

					$ResultExam = $this->db->query("SELECT contact.ID AS ID , contact.Name AS  Name
					from contact 
					inner join student on contact.ID =student.Contact_ID
					inner join test    on student.R_L_ID=test.RowLevelID 
					where test.ID ='" . $ID . "' 
					 and contact.Isactive =1 
					and contact.SchoolID=" . $School_id . "
					and	FIND_IN_SET(student.Class_ID,test.classID) 
					and (test.Students ='' OR test.Students IS NULL OR FIND_IN_SET(contact.ID,Students) )
					AND contact.ID NOT IN (
						SELECT num_student
						FROM test
						WHERE test.ID = $ID
					)
					group by contact.ID ")->result();
				}
				
					// dd($ResultExam);
			} elseif ($repetType == 1) {

					$ResultExam = $this->db->query("SELECT contact.ID AS ID , contact.Name AS  Name
					from contact 
					inner join student on contact.ID =student.Contact_ID
					inner join test    on student.R_L_ID=test.RowLevelID 
					where test.ID ='" . $ID . "' 
					 and contact.Isactive =1 
					and contact.SchoolID=" . $School_id . "
					and	FIND_IN_SET(student.Class_ID,test.classID) 
					and (test.Students ='' OR test.Students IS NULL OR FIND_IN_SET(contact.ID,Students) )
					AND contact.ID NOT IN (
						SELECT num_student
						FROM test
						WHERE test.ID = $ID
					)
					group by contact.ID ")->result();

			}
		} else {

			$ResultExam = $this->db->query("SELECT contact.ID AS ID , contact.Name AS  Name
						from contact 
						inner join student on contact.ID =student.Contact_ID
						inner join test    on student.R_L_ID=test.RowLevelID 
						where test.ID ='" . $ID . "' 
						and contact.Isactive =1 
						and contact.SchoolID=" . $School_id . "
						and	FIND_IN_SET(student.Class_ID,test.classID) 
						and (test.Students ='' OR test.Students IS NULL OR FIND_IN_SET(contact.ID,Students) )
						
						group by contact.ID ")->result();
		}
		// dd($ResultExam);
		return $ResultExam;


	}
		/////////////////////////////
	public function get_student($ID)
	{ 
		
		$ResultExam = $this->db->query("SELECT DISTINCT contact.Name as contact_name,contact.ID AS contact_id,test.ID as test_ID,test.num_student
		                                from contact 
		                                inner join test      on test.ID ='".$ID."'  and FIND_IN_SET(contact.ID,test.num_student)
		                                  group by contact.ID ")->result();		

 		     return $ResultExam ; 
	
	}
	//////////////////////////////////////////////
		public function get_student_repeat($School_id,$RowLevel,$class)
	{ 
		
		$ResultExam = $this->db->query(" SELECT contact.ID   AS StudentID ,contact.Name   AS StudentName
		                                 FROM contact
		                                 inner join student on contact.ID=student.Contact_ID and student.R_L_ID = ".$RowLevel."
		                                 WHERE student.Class_ID IN(".$class.") and contact.SchoolID=".$School_id." and  contact.Isactive=1
		                                 GROUP BY contact.ID 
		                                  ")->result();		

 		     return $ResultExam ; 
	
	}
	//////////////////////////
	public function update_student_name_repeat($ID,$student,$Timezone)
	{ 
	     
		$ResultExam = $this->db->query("update test set test.num_student = '".$student."' , Date_Stm = '".$Timezone."' where test.ID='".$ID."' ");
		$stu= $this->db->query("SELECT `ID` FROM `contact` WHERE  FIND_IN_SET (`ID`,'".$student."') ")->result();
		
		foreach($stu as $Key=>$i)
             {
		     $STU_ID = $i->ID;
		     $time_consumed = $this->db->query("SELECT `ID` FROM `test_time_consumed` WHERE `test_id`= '".$ID."' AND `student_id` = '".$STU_ID."' ")->row_array();
		       if($time_consumed){
		         $test_time_consumed = $this->db->query("update test_time_consumed set consumed_time = 0 , last_updated_date = '".$Timezone."'WHERE `test_id`= '".$ID."' AND `student_id`='".$STU_ID."' ");
		      }else{ 
		        $test_time_consumed = $this->db->query("insert into test_time_consumed set consumed_time = 0 , last_updated_date = '".$Timezone."' , `test_id`= '".$ID."' , `student_id`='".$STU_ID."'");
		      }
             }	
 		if($ResultExam && $test_time_consumed){
			return TRUE ;
		}else{return FALSE ;}
	}
	///////////////////////////////////////////////////
	public function get_semester($Lang)
	 {
		
		 if($Lang == 'english')
		 {
		     $Name='Name_en';
		 }else{
		     $Name='Name';
		 }
		 
			     $Where = array('Is_Active'=>1);
			     $this->db->select("ID,$Name AS Name");
                 $this->db->from('config_semester');
                 $this->db->where($Where);
				 $ResultData = $this->db->get();
				 if($ResultData->num_rows()>0)
				 {
					 return $ResultData->result();
					 return TRUE ;
				 } else{return FALSE ;}
		
	 }
	public function get_lessons_prep($RowLevelID,$SubjectID,$SemesterID)
	{
		$TeacherID  	= $this->session->userdata('id');
		
		$this->db->select('lesson_prep.ID AS LessonID , lesson_prep.classID AS LessonclassID, lesson_prep.Lesson_Title AS LessonTitle ,lesson_prep.Date AS LessonDate , lesson_prep.Token AS LessonToken ,lesson_prep.RowLevel_ID ,lesson_prep.Subject_ID' );
		$this->db->from('lesson_prep');
		$this->db->join("config_semester","config_semester.ID=$SemesterID AND lesson_prep.date_from  BETWEEN config_semester.start_date AND config_semester.end_date ");
		$this->db->where('lesson_prep.RowLevel_ID', $RowLevelID );
		$this->db->where('lesson_prep.Subject_ID', $SubjectID );
		$this->db->where('lesson_prep.Teacher_ID', $TeacherID );
		$this->db->group_by('lesson_prep.ID');
		$ResultLessons = $this->db->get();
		$NumRowResultLessons  = $ResultLessons->num_rows() ; 
		if($NumRowResultLessons != 0)
		  {
				$ReturnLessons = $ResultLessons ->result() ;
				return $ReturnLessons ;
		  }
		  else
		  {
			  return false ;
		  }
	}
////////////////////////////////////////////////
     public function get_Subjects_emp($rowlevelid,$SubjectID)
	 {
		$idContact = (int)$this->session->userdata('id');				
		$this->db->select('config_emp.ID AS subject_ID,config_emp.ID AS SubEmpID, subject.Name AS subject_Name ,row_level.Row_Name  AS row_Name ,row_level.Level_Name  AS level_Name ,row_level.ID AS R_L_ID,subject.ID AS Sub_ID');
		$this->db->from('class_table');
		$this->db->join('config_emp', 'config_emp.RowLevelID = class_table.RowLevelID and config_emp.EmpID = class_table.EmpID and  config_emp.SubjectID = class_table.SubjectID', 'left');
		$this->db->join('subject', 'class_table.SubjectID =subject.ID', 'INNER');
		$this->db->join('row_level', 'class_table.RowLevelID =row_level.ID', 'INNER');
		$this->db->where('row_level.ID',$rowlevelid);
		$this->db->where('subject.ID',$SubjectID);
		$this->db->where('class_table.EmpID',$idContact);
		$this->db->group_by('class_table.SubjectID');
		$this->db->group_by('class_table.RowLevelID');
		$ResultSubjectEmp = $this->db->get();	 
		$NumRowResultSubjectEmp  = $ResultSubjectEmp->num_rows() ; 
			if($NumRowResultSubjectEmp >0)
			  {
				$ReturnSubjectEmpEdit     = $ResultSubjectEmp ->result() ;
			   return $ReturnSubjectEmpEdit ; 
			   
			   return TRUE ; 
							 
			  }else{return FALSE ;}
	}
	/////////////////////////////////////////////
	public function get_classes_emp($rowlevelid,$SubjectID)
	 { 
		if($this->session->userdata('language')=="english"){
		$this->db->select('class.Name_en as Name , class.ID');  }
		else
		 { $this->db->select('class.Name  as Name, class.ID');}
		$this->db->from('class');	
		$this->db->join('class_table', 'class.ID =class_table.ClassID', 'INNER'); 
		$this->db->where('class_table.EmpID',(int)$this->session->userdata('id'));
		$this->db->where('class_table.RowLevelID',(int)$rowlevelid);
		$this->db->where('class_table.SubjectID',(int)$SubjectID);
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
	////////////////////////////////////////////////
     public function get_Subjects_test($Data)
	 {
	     extract($Data);
		$idContact = (int)$this->session->userdata('id');				
		$this->db->select('subject.Name AS subject_Name ,row_level.Row_Name  AS row_Name ,row_level.Level_Name  AS level_Name ,row_level.ID AS R_L_ID,subject.ID AS Sub_ID');
		$this->db->from('test');
		$this->db->join('subject', 'test.subject_id =subject.ID', 'INNER');
		$this->db->join('row_level', 'test.RowLevelID =row_level.ID', 'INNER');
		$this->db->where('row_level.ID',$rowlevelid);
		$this->db->where('subject.ID',$subjectid);
		$this->db->group_by('test.subject_id');
		$this->db->group_by('test.RowLevelID');
		$ResultSubjectEmp = $this->db->get();	 
		$NumRowResultSubjectEmp  = $ResultSubjectEmp->num_rows() ; 
			if($NumRowResultSubjectEmp >0)
			  {
				$ReturnSubjectEmpEdit     = $ResultSubjectEmp ->result() ;
			   return $ReturnSubjectEmpEdit ; 
			   
			   return TRUE ; 
							 
			  }else{return FALSE ;}
	}
	/////////////////////////////////////////////
	public function get_classes_test()
	 { 
		if($this->session->userdata('language')=="english"){
		$this->db->select('class.Name_en as Name , class.ID');  }
		else
		 { $this->db->select('class.Name  as Name, class.ID');}
		$this->db->from('class');	
		$this->db->group_by( "class.ID" ); 
		$ResultExam = $this->db->get();		 
		$NumRowResultExam = $ResultExam->num_rows() ; 
		
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->result() ;
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{return FALSE ;}
	}
	///////////////////////////////////
	public function get_exam_student($test_id){
	    $query=$this->db->query("select contact.ID,contact.Name from contact 
	                             INNER JOIN student ON contact.ID =student.Contact_ID
	                             INNER JOIN test ON student.R_L_ID=test.RowLevelID
	                             where test.ID=$test_id and FIND_IN_SET(student.Class_ID ,test.classID)")->result();
	       return $query;
	}
	///////////////////////////////////////
	 public function add_exam($data=array())
	 { 
	     extract($data);
		 $idContact                      = (int)$this->session->userdata('id');
		 (string)$this->Token            = $this->create_token();
		 
		 $Add_exam = array(
							 'Name'                 =>$txt_exam ,
							 'empID'                =>$idContact ,
							 'time_count'           =>$txt_time ,
							 'Token'                =>(string)$this->Token,
							 'date_from'            =>$Date_from,
							 'date_to'              =>$Date_to,
							 'RowLevelID'           =>$rowlevelid,
							 'IsActive'             =>$IsActive,
							 'Date_Stm'             =>$date,
							 'type'                 =>$type,
							 'examDegree'           =>$examDegree,
							 'SchoolId'             =>$SchoolId,
							 'schoolName'           =>$schoolName,
							 'classType'            =>$classType,
							 'studyType'            =>$studeType,
							 'levelId'              =>$levelId,
							 'rowId'                =>$rowId,
							 'statusId'             =>$statusId,
							 'rowLevelName'         =>$rowLevelName
							 
							 );
	
		 
         $this->db->insert('test', $Add_exam);
        $insert_id = $this->db->insert_id();

		if($insert_id){
		
			 
			   return $insert_id ; 
			  
		}else{return FALSE ;}

	 }
	 public function get_test_data($test_id)
	 {
		$this->db->select('*');
		$this->db->from('test');	
		$this->db->where('ID',$test_id);
		$ResultExam = $this->db->get();			
		$NumRowResultExam = $ResultExam->num_rows() ; 
		
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->row_array() ;
			   return $ReturnExam ; 
							 
			  }else{return 0;} 
	 }
	 //////////////////////////////////////
	  public function edit_exam($data=array())
	 {
	     extract($data);
		 $idContact                      = (int)$this->session->userdata('id');
		 $School_id                      = (int)$this->session->userdata('SchoolID');
		 
		 $edit_exam = array(
							 'Name'                 =>$txt_exam ,
							 'time_count'           =>$txt_time ,
							 'config_semester_ID'   =>$slct_Semester ,
							 'date_from'            =>$Date_from ,
							 'date_to'              =>$Date_to,
							 'IsActive'             =>$IsActive,
							 'Date_Stm'             =>$date,
							 'examDegree'           =>$examDegree,
							 //'classType'            =>$classType,
							 //'studyType'            =>$studeType,
							 //'SchoolId'             =>$SchoolId,
							 //'schoolName'           =>$schoolName,
							 //'levelId'              =>$levelId,
							 //'rowId'                =>$rowId,
							 //'statusId'             =>$statusId,
							 //'rowLevelName'         =>$rowLevelName
							 );
		
		$this->db->where('ID', $test_id); 
        $Edit_Exam =  $this->db->update('test', $edit_exam); 
		 
		
		if($Edit_Exam ){
			return $test_id ;
		}else{return FALSE ;}

	 }  
	 /////////////////////////////////////////////////////
     public function get_Type_question()
	 {
	     $Name = 'Name';
	     if( $this->session->userdata('language') !='arabic'){
	        $Name = 'Name_en';
	     }
	     $query= $this->db->query("SELECT `ID`,$Name as Name ,IsActive ,Token FROM `questions_types` WHERE  IsActive = 1 ")->result();
		 return $query ;
	
	 }
	 
	  /////////////////////////////////////////////////////
     public function get_Type_question_by_id($Type_question_ID)
	 {
	     $Name = 'Name';
	     if( $this->session->userdata('language') !='arabic'){
	        $Name = 'Name_en';
	     }
	     $query= $this->db->query("SELECT `ID`,$Name as Name ,IsActive ,Token FROM `questions_types` WHERE  ID=".$Type_question_ID." ")->row_array();
			   return $query ;
		
	 }
	 
	 //////////////////////////////////////////////////
	public function add_exam_question($Data=array())
	{
	    extract($Data);
	    (string)$this->Token         = $this->create_token();	
	
				$add_q = array(
				                'test_id'                 => $test_id  ,
								 'Degree'                 => $txt_Degree  ,
								 'Question'               => $txt_question ,
								 'Q_attach'               => $txt_attach ,
								 'questions_types_ID'     => $question_type,
								 'degree_difficulty'      => $degree_difficulty,
 								 'Token'                  => $this->Token
								 );
					
			  if($question_id){
			   $this->db->where('ID', $question_id);
			   $this->db->update('questions_content', $add_q);
	           }else{
			  if($this->db->insert('questions_content', $add_q)){
			   $insert_id = $this->db->insert_id();
			   $ReturnExam     = $this->db->query("select sum(Degree) AS SumDegreeQ from questions_content WHERE test_id =$test_id")->row_array(); 
			   $Degree=$ReturnExam['SumDegreeQ'];

		   switch($question_type){
		     
			   case '2':
	            $max                           = count($this->input->post('txt_multi_Choices'));
			    $choice_count                 = $this->input->post('choice_count');
			    $arr=[];
			    for($j=1;$j<=$max;$j++){
			        $correct_answer           = $this->input->post("slct_Correct_Answer1[$j]");
			        if($correct_answer==1){
                     array_push($arr,$correct_answer);
                     }
			    }
                      $count_correct=count($arr);
			    for($j=1;$j<=$max;$j++){
				    $txt_choice               = $this->input->post("txt_multi_Choices[$j]");
			        $correct_answer           = $this->input->post("slct_Correct_Answer1[$j]");
			        $hidImg                   = $this->input->post("hidImg$j");
			        if($correct_answer==""){
			            $correct_answer  = 0 ;
			        }
			        if($correct_answer==1){
			               $degree  = $txt_Degree/$count_correct;
			           }
			           else{
			               $degree =0;
			           }
					 if($hidImg){
					     $txt_choice=$hidImg;
					 }else{
					     $txt_choice=$txt_choice;
					 }
 					 $add_answer = array(
								 'Answer'                 => (string)$txt_choice  ,
								 'Answer_correct'         => $correct_answer ,
								 'Questions_Content_ID'   => $insert_id ,
								 'Token'                  => (string)$this->create_token(),
								 'test_id'                => $test_id,
								 'Degree'                 => $degree
								 );
				 
				// 	print_r($add_answer);die;
					 $this->db->insert('answers', $add_answer);
					 }
			
					break;
			   
			   case '3':
					$false_txt     = $this->input->post('false_txt');
					$true_txt      = $this->input->post('true_txt');		
 					if($false_txt==1&&$true_txt==0){$degree_false=$txt_Degree;$degree_true=0;}else{$degree_false=0;$degree_true=$txt_Degree;}
					
						$add_answer = array(
								 'Answer'                 =>lang("right_answer"),
								 'Answer_correct'         =>$true_txt  ,
								 'Questions_Content_ID'   =>$insert_id ,
								 'Token'                  =>(string)$this->create_token(),
								 'test_id'                =>$test_id,
								 'Degree'                 =>$degree_true
								 );
						  $this->db->insert('answers', $add_answer); 
						  
						  	$add_answer = array(
								 'Answer'                 =>lang("wrong_answer"),
								 'Answer_correct'         =>$false_txt  ,
								 'Questions_Content_ID'   =>$insert_id ,
								 'Token'                  =>(string)$this->create_token(),
								 'test_id'                =>$test_id,
								 'Degree'                 =>$degree_false
								 );
						$this->db->insert('answers', $add_answer);
						 

						  
					break;
			   case '4':			   
 					$txt_answer = $this->input->post('txt_answer');
						foreach($txt_answer as $key=>$val){
 							$add_answer = array(
								 'Answer'                 =>trim((string)$txt_answer[$key]) ,
								 'Answer_correct'         =>1  ,
								 'Questions_Content_ID'   =>$insert_id ,
								 'Token'                  =>(string)$this->create_token(),
								 'test_id'                =>$test_id,
								 'Degree'                 =>$txt_Degree/count($txt_answer)
								 );
								 
						  $this->db->insert('answers', $add_answer); 
						}
					break;
			   case '6':
			   case '8':
 						$add_answer = array(
								 'Answer'                 =>''   ,
								 'Answer_correct'         =>1  ,
								 'Questions_Content_ID'   =>(string)$insert_id ,
								 'Token'                  =>(string)$this->create_token(),
								 'Degree'                 =>$txt_Degree,
								 'test_id'                =>$test_id
								 );
					 $this->db->insert('answers', $add_answer); 
					break;
			    

		   }}}
			   
			return true;
	    
	}
	 //////////////////////////////////////////////////
	public function edit_exam_question($Data=array())
	{
	    extract($Data);
	     
	    (string)$this->Token   = $this->create_token();	
				$add_q = array(
								 'Degree'                 => $txt_Degree,
								 'Question'               => $txt_question ,
								 'Q_attach'               => $txt_attach
								 );
					
				$this->db->where('ID', $question_id);		 
			  if($this->db->update('questions_content', $add_q)){
			     
			   $insert_id = $this->db->insert_id();
			   $ReturnExam     = $this->db->query("select sum(Degree) AS SumDegreeQ from questions_content WHERE test_id =$test_id")->row_array(); 
			   $Degree=$ReturnExam['SumDegreeQ'];
		       $this->db->query("DELETE from answers WHERE Questions_Content_ID =$question_id");
			 
			 
		   switch($question_type){
		       
			   case '2':
			      $max                           = count($this->input->post('txt_multi_Choices'));
				  $choice_count                  = $this->input->post('choice_count');
				  $for_count                     = $this->input->post('for_count_choice');
			     if($choice_count){
                    $counter=$choice_count;
                }else{
                    $counter=$for_count;
                }
                $arr=[];
			    for($j=1;$j<=$max;$j++){
			        $correct_answer           = $this->input->post("slct_Correct_Answer1[$j]");
			        if($correct_answer==1){
                     array_push($arr,$correct_answer);
                     }
			    }
                      $count_correct=count($arr);
			    for($j=1;$j<=$max;$j++){
				    $txt_choice               = $this->input->post("txt_multi_Choices[$j]");
			        $correct_answer           = $this->input->post("slct_Correct_Answer1[$j]");
			        $hidImg                   = $this->input->post("hidImg$j");
                      if($hidImg!=""){
        				 $txt_choice  = $hidImg;
        			  }else{
					     $txt_choice  = $txt_choice;
					 }
			        if($correct_answer==""){
			            $correct_answer  = 0 ;
			        }
			        if($correct_answer==1){
			               $degree  = $txt_Degree/$count_correct;
			           }
			           else{
			               $degree =0;
			           }
 					 $add_answer = array(
								 'Answer'                 => (string)$txt_choice,
								 'Answer_correct'         => $correct_answer,
								 'Questions_Content_ID'   =>$question_id ,
								 'Token'                  =>(string)$this->create_token(),
								 'test_id'                =>$test_id,
								 'Degree'                 =>$degree
								 );
				 
					
					 $this->db->insert('answers', $add_answer);
					 }

					break;
			   case '3':
					$false_txt     = $this->input->post('false_txt');
					$true_txt      = $this->input->post('true_txt');	
 					if($false_txt==1&&$true_txt==0){$degree_false=$txt_Degree;$degree_true=0;}else{$degree_false=0;$degree_true=$txt_Degree;}
						$add_answer = array(
								 'Answer'                 =>lang("right_answer")    ,
								 'Answer_correct'         =>$true_txt  ,
								 'Questions_Content_ID'   =>$question_id ,
								 'Token'                  =>(string)$this->create_token(),
								 'test_id'                =>$test_id,
								 'Degree'                 =>$degree_true
								 );
								 
						  $this->db->insert('answers', $add_answer); 
						  
						  	$add_answer = array(
								 'Answer'                 =>lang("wrong_answer")    ,
								 'Answer_correct'         =>$false_txt  ,
								 'Questions_Content_ID'   =>$question_id ,
								 'Token'                  =>(string)$this->create_token(),
								 'test_id'                =>$test_id,
								 'Degree'                 =>$degree_false
								 );
						$this->db->insert('answers', $add_answer);

						  
					break;
			   case '4':			   
 					$txt_answer = $this->input->post('txt_answer');
						foreach($txt_answer as $key=>$val){
 							$add_answer = array(
								 'Answer'                 =>trim((string)$txt_answer[$key]) ,
								 'Answer_correct'         =>1  ,
								 'Questions_Content_ID'   =>$question_id ,
								 'Token'                  =>(string)$this->create_token(),
								 'test_id'                =>$test_id,
								 'Degree'                 =>$txt_Degree/count($txt_answer)
								 );
						  $this->db->insert('answers', $add_answer); 
						}
					break;
			   case '6':
			   case '8':
			       
 						$add_answer = array(
								 'Answer'                 =>''   ,
								 'Answer_correct'         =>1  ,
								 'Questions_Content_ID'   =>$question_id ,
								 'Token'                  =>(string)$this->create_token(),
								 'Degree'                 =>$txt_Degree,
								 'test_id'                =>$test_id
								 );
					 $this->db->insert('answers', $add_answer); 
					break;
				
			  

		   }}
			return true;
	    
	}
	//////////////////////////////////////////////
	public function get_question($test_id)
	 {
	     if($this->session->userdata('language')=='english'){
	         $name='Name_en';
	     }else{
	         $name='Name';
	     }
		$this->db->select("questions_content.ID AS questions_content_ID , 
		                   questions_content.Degree , questions_content.Question, questions_content.degree_difficulty,questions_content.Q_attach,
		                   questions_types.$name as questions_type_Name,questions_types.ID AS questions_types_ID ,questions_content.num_ques ");
        $this->db->from('questions_content');
		$this->db->join('questions_types', 'questions_types.ID =questions_content.questions_types_ID', 'INNER');
        $this->db->where('questions_content.test_id', $test_id );
        $this->db->order_by('questions_content.ID','ASC' );
		$ResultContactData = $this->db->get();
 		$NumRowResultContactData = $ResultContactData->num_rows() ; 	 
			if($NumRowResultContactData <=0)
			  {
				return FALSE;	
			  }
        	else 
			{
			   $ResultContactData     = $ResultContactData ->result() ;
 			   return $ResultContactData ; 
			   return TRUE ;
				
			}

	 }
	 public function getTotalDegree($test_id) {
		$this->db->select_sum('Degree', 'total_degree');
		$this->db->from('questions_content');
		$this->db->where('questions_content.test_id', $test_id);
	
		$ResultContactData = $this->db->get();
		$row = $ResultContactData->row();
	
		if (isset($row->total_degree)) {
			return (Float) $row->total_degree;
		} else {
			return 0;
		}
	}
	
	 	//////////////////////////////////////////////
	public function get_question_data($question_ID)
	 {
		$query=$this->db->query("SELECT questions_content.ID,questions_content.Question,answers.ID as answers_ID,answers.Answer,answers.Answer_match,
		                         answers.Answer_correct,questions_content.Degree,questions_content.Q_attach
		                         FROM `questions_content` 
		                         INNER JOIN answers ON answers.Questions_Content_ID = questions_content.ID 
		                         WHERE questions_content.ID = $question_ID ")->result();
        
      return $query;
	 }
	 ///////////////////////////////////
	 public function get_answer($questions_content_ID,$questions_types_ID)
	 {
	    $this->db->select('Answer_correct , answers.ID AS answers_ID,answers.Answer,answers.Answer_match');
        $this->db->from('answers');
        $this->db->where('Questions_Content_ID', $questions_content_ID );
        $this->db->group_by('answers.ID' );
        $this->db->order_by("answers.ID", "ASC");
		$ResultContactData = $this->db->get();
 		$NumRowResultContactData = $ResultContactData->num_rows() ; 	 
			if($NumRowResultContactData <=0)
			  {
				return FALSE;	
			  }
        	else 
			{
			   $ResultContactData     = $ResultContactData ->result() ;
 			   return $ResultContactData ; 
			   return TRUE ;
				
			}

	 }
	  public function delete_exam($examID,$Timezone)
	 {
		 
		$this->db->select('ID');
        $this->db->from('test');
        $this->db->where('ID', $examID  );
		$ResultContactData = $this->db->get();			
		$NumRowResultContactData  = $ResultContactData->num_rows() ; 
			if($NumRowResultContactData <=0)
			  {
				return FALSE;	
			  }
        	else 
			{
				 $edit_exam = array(
							 'is_deleted'   =>(int)1,
							 'Date_Stm'     =>$Timezone
							 );
							 $edit_exam1 = array(
							 'is_deleted'   =>(int)1,
							 'DATE'         =>$Timezone
							 );
		
				$this->db->where('ID', $examID ); 
				$Insert_Exam =  $this->db->update('test', $edit_exam); 
				if($Insert_Exam ){
					return TRUE ;
				}else{return FALSE ;}
			}
		
	 }
    //////////////////////////////////////////////////
     public function del_exam_question($Questions_ID)
	 {
	
		$delete_answer   =  $this->db->query("delete from answers where Questions_Content_ID=$Questions_ID"); 
		$delete_question =  $this->db->query("delete from questions_content where ID=$Questions_ID");
		if($delete_answer && $delete_question){
			return TRUE ;
		}else{return FALSE ;}
			
	 }
	 /////////////////////////////////
	 public function get_exam_by_id($data = array())
	 { 
	     extract($data);
		
		$ResultExam = $this->db->query("SELECT `test`.`Name`, `test`.`Description`, `test`.`ID`,`test`.`Subject_emp_ID`,`test`.`time_count`,`subject`.`Name` AS `subject_Name`,
		                                  `level`.`Name` AS `level_Name`,`row`.`Name` AS `row_Name`,`config_semester`.`Name` AS `Name_sms`,`test`.`classID` AS `class_id`,`test`.`IsActive`, 
		                                   `test`.`RowLevelID`,`test`.`subject_id`,`reporter`.`Name` as `rep_name`,`test`.`report_degree`,`test`.`report_comment`,`test`.`date_eval`,
		                                    `test`.`date_from`,`test`.`date_to` 
		                               FROM `test` 
		                               INNER JOIN `config_semester` ON `test`.`config_semester_ID` =`config_semester`.`ID` 
		                               INNER JOIN `subject` ON `test`.`subject_id` =`subject`.`ID` 
		                               INNER JOIN `row_level` ON `test`.`RowLevelID` =`row_level`.`ID` 
		                               LEFT JOIN `contact` as `reporter` ON `test`.`reporter_id` = `reporter`.`ID` 
		                               INNER JOIN `row` ON `row_level`.`Row_ID` =`row`.`ID` 
		                               INNER JOIN `level` ON `row_level`.`Level_ID` =`level`.`ID` 
		                               WHERE `test`.`is_deleted` = 0 
		                               AND `test`.`type` = '".$type."' 
		                               AND `test`.`subject_id` = '".$subjectid."' 
		                               AND `test`.`RowLevelID` = '".$RowlevelID."' 
		                               AND `test`.`ID` = '".$ID."' 
		                               ORDER BY `test`.`Date_Stm` DESC ");		

 		$NumRowResultExam = $ResultExam->result() ; 
 		if($NumRowResultExam >0){$ReturnExam     = $ResultExam ->result() ;
 		return $ReturnExam ; 
        return TRUE ; 
		}else{return $NumRowResultExam ;return FALSE ;}
	}
	//////////////////////////////////////
	public function get_all_data($data = array() )
	{
	    extract($data);
	    
		$GetData = $this->db->query(" call Usp_GetStudentExamAttend(".$ID.")");
		
		if($GetData->num_rows()>0)
		{
		
            $result= $GetData->result();
            mysqli_next_result( $this->db->conn_id ); 
            return $GetData->result();

		}else
		{
			   return FALSE ;
	    }
	}
	///////////////////////////////////////rania
//  //get_subject_emp_id
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
 
 //get_exams_students
	 public function get_exams_students()
	 { 
		$idContact = (int)$this->session->userdata('id'); 
	 



		$ResultExam = $this->db->query("SELECT `vw_test_select`.`test_ID`, `vw_test_select`.`test_Name`, `vw_test_select`.`subject_Name`, `vw_test_select`.`contact_Name`, `vw_test_select`.`row_level_Name`, `vw_test_select`.`config_semester_Name`, `vw_test_select`.`test_Degree`, `st`.`Name` as `student_name`, `fa`.`Name` as `father_name`, `st`.`ID` as student_ID , sum(test_student.Degree)as student_Degree  FROM  `vw_test_select`  INNER JOIN `vw_test_question_select` ON `vw_test_select`.`test_ID` =`vw_test_question_select`.`test_ID`   INNER JOIN `test_student` ON `test_student`.`questions_content_ID` =`vw_test_question_select`.`questions_content_ID` INNER JOIN `contact` as st ON `test_student`.`Contact_ID` =`st`.`ID` and st.Type= 'S' 
INNER JOIN `student`  ON student.Contact_ID =st.ID
INNER JOIN contact as fa ON student.Father_ID  =fa.ID
 


WHERE `vw_test_select`.`contact_ID` = '".$idContact."' AND `vw_test_select`.`IsActive` = 1 GROUP BY `vw_test_select`.`test_ID`, `st`.`ID`");		



 		$NumRowResultExam = $ResultExam->num_rows() ; 
		
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->result() ;
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{return $NumRowResultExam ;return FALSE ;}
	}
 
 //get_exams_students
	 public function get_student_answer($question_id,$studentID)
	 { 
		$idContact = (int)$this->session->userdata('id'); 
	 



		$ResultExam = $this->db->query("SELECT `st`.`Name` as `student_name`, `fa`.`Name` as `father_name`,   `st`.`ID` as student_ID,  test_student.Degree ,  test_student.answer_content ,  test_student.questions_content_ID	 FROM  `test_student`  INNER JOIN  `test_questions`   ON `test_student`.`questions_content_ID` = `test_questions` .Questions_ID	 INNER JOIN `contact` as st ON `test_student`.`Contact_ID` =`st`.`ID`
INNER JOIN `student`  ON student.Contact_ID =st.ID and st.Type='S' 
INNER JOIN contact as fa ON student.Father_ID  =fa.ID
 


WHERE   `test_student`.`questions_content_ID` = '".(int)$question_id."' and st.ID='".(int)$studentID."' ");		



 		$NumRowResultExam = $ResultExam->num_rows() ; 
		
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->row_array() ;
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{return $NumRowResultExam ;return FALSE ;}
	}
//  //get_del_degree
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
		$this->db->join('vw_test_select', 'vw_test_select.test_ID =test_questions.Test_ID', 'INNER');
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
//  //get_exams_students_father_header
	 public function get_exams_students_father_header($studentID)
	 {
		$idContact = (int)$this->session->userdata('id'); 
		$this->db->select('contact.Name as student_name,vw_test_select.test_ID,vw_test_select.test_Name,vw_test_select.subject_Name,vw_test_select.contact_Name,vw_test_select.row_level_Name,vw_test_select.config_semester_Name,vw_test_select.test_Degree,sum(test_student.Degree)as student_Degree');
		$this->db->from('student');
		$this->db->join('contact', 'contact.ID =student.Contact_ID', 'INNER');
		$this->db->join('test_student', 'test_student.Contact_ID =student.Contact_ID', 'INNER');
		$this->db->join('test_questions', 'test_questions.Questions_ID =test_student.questions_content_ID', 'INNER');
		$this->db->join('vw_test_select', 'vw_test_select.test_ID =test_questions.Test_ID', 'INNER');
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
 
//  //get_specific_exam
	 public function get_specific_exam($ID,$Lang)
	 {
		if($Lang=="english"){
			$this->db->select('test.ID AS test_ID,test.report_degree AS reportDegree, test.report_comment AS reportComment,test.date_to,test.date_from,test.classID ,test.IsActive,test.empID AS teacher_id,
		test.Name, test.Description  ,test.time_count ,test.ID,test.Subject_emp_ID as Subject_ID,subject.Name AS subject_Name , level.Name AS level_Name , row.Name AS row_Name,config_semester.Name AS Name_sms,config_semester.ID AS ID_sms,test.num_student,test.RowLevelID as RowLevelID, lesson_prep.Lesson_Title,test.lessonID	,test.subject_id as SubjectID_subject');
		 }
		else
		 {	
		$this->db->select('test.ID AS test_ID,test.report_degree AS reportDegree, test.report_comment AS reportComment,test.date_to,test.date_from,test.classID ,test.IsActive ,test.empID AS teacher_id,
		test.Name, test.Description  ,test.time_count ,test.ID,test.Subject_emp_ID as Subject_ID,subject.Name AS subject_Name , level.Name AS level_Name , row.Name AS row_Name,config_semester.Name AS Name_sms,config_semester.ID AS ID_sms,test.num_student,test.RowLevelID as RowLevelID, lesson_prep.Lesson_Title,test.lessonID	,test.subject_id as SubjectID_subject');}
		$this->db->from('test');	
		$this->db->join('config_semester', 'test.config_semester_ID =config_semester.ID', 'INNER');			
		$this->db->join('config_emp', 'config_emp.ID =test.Subject_emp_ID', 'left');	
		$this->db->join('subject', 'test.subject_id =subject.ID', 'INNER');			
		$this->db->join('row_level', 'test.RowLevelID =row_level.ID', 'INNER');		
		$this->db->join('row', 'row_level.Row_ID =row.ID', 'INNER');			
		$this->db->join('level', 'row_level.Level_ID =level.ID', 'INNER');				
		$this->db->join('lesson_prep', 'lesson_prep.ID =test.lessonID', 'left');	
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

  ///
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
							 'num_student'          =>$data['num_student'] 
							 );
		 
        $Insert_Exam =  $this->db->insert('test', $Add_exam); 
				 add_notification( $this->db->insert_id(),2,0,(int)$this->slct_subject,0 ,0);

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

//  //get_classes
	 public function get_classes($rowlevelid,$SubjectID)
	 { 
		if($this->session->userdata('language')=="english"){
		$this->db->select('class.Name_en as Name , class.ID');  }
		else
		 { $this->db->select('class.Name  as Name, class.ID');}
		$this->db->from('class');	
// 		$this->db->join('class_table', 'class_table.RowLevelID = config_emp.RowLevelID and class_table.SubjectID= config_emp.SubjectID', 'INNER'); 
		$this->db->join('class_table', 'class.ID =class_table.ClassID', 'INNER'); 
		$this->db->where('class_table.EmpID',(int)$this->session->userdata('id'));
		$this->db->where('class_table.RowLevelID',(int)$rowlevelid);
		$this->db->where('class_table.SubjectID',(int)$SubjectID);
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



	public function get_classes_android($teacher_id,$RowLevelID,$SubjectID,$SchoolID)
	 { 
		
		 $this->db->select('class.Name  as Name, class.ID');
		$this->db->from('class');	
		$this->db->join('class_table', 'class.ID =class_table.ClassID', 'INNER'); 
		$this->db->where('class_table.EmpID',$teacher_id);
		$this->db->where('class_table.SubjectID',$SubjectID);
		$this->db->where('class_table.SchoolID',$SchoolID);
		$this->db->where('class_table.RowLevelID',$RowLevelID);
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
		public function get_classes_new($ID,$teacher_id)
	 { 
		if($this->session->userdata('language')=="english"){
		$this->db->select('class.Name_en as Name , class.ID');  }
		else
		 { $this->db->select('class.Name  as Name, class.ID');}
		$this->db->from('config_emp');	
		$this->db->join('class_table', 'class_table.RowLevelID = config_emp.RowLevelID and class_table.SubjectID= config_emp.SubjectID', 'INNER'); 
		$this->db->join('class', 'class.ID =class_table.ClassID', 'INNER'); 
		$this->db->where('class_table.EmpID',(int)$teacher_id);
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
		/////////////
	public function show_exam($Data)
	{
	    $RowLevel_array =get_rowlevel_select_in();
	    $Emp_array      =get_emp_select_in();
	    $Subject_array  =get_subject_select_in();
	    $level      = $Data['level'];
	    $RowLevel   = $Data['RowLevel'];
	    $Class      = $Data['Class'];
	    $subject    = $Data['subject'];
	    if($level == 0 )   {$level = 'NULL' ; }
	   if($RowLevel == 0 )   {$RowLevel = 'NULL' ; }
	   //if($Class == 0 )   {$Class = 'NULL' ; }
	   if($subject == 0 )   {$subject = 'NULL' ; }
	   if($Class!= 0){
				$whereClass = "AND  test.classID REGEXP $Class"; 
			}
	    $query = $this->db->query(" select test.ID,test.Name AS Name ,test.empID ,contact.Name AS teachername,
		test.Token AS token,test.Date_Stm as date
	    from test 
	    inner join contact on contact.ID = test.empID
	    inner join row_level on row_level.ID = test.RowLevelID
	    where
	    test.is_deleted=0 
	    and test.type=0 
	    AND row_level.Level_ID	= IFNULL($level, row_level.Level_ID)
	    AND test.RowLevelID = IFNULL($RowLevel, test.RowLevelID)
	    ".$whereClass."
	    AND test.subject_id = IFNULL($subject, test.subject_id)
	    AND test.SchoolId=".(int)$this->session->userdata('SchoolID')."
	    AND test.RowLevelID IN(".$RowLevel_array.")
	    AND test.empID IN(".$Emp_array.")
	    AND test.subject_id IN(".$Subject_array.")
	    ");
	    if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
	}
	///////////////
	public function show_homework($Data)
	{
	    $RowLevel_array =get_rowlevel_select_in();
	    $Emp_array      =get_emp_select_in();
	    $Subject_array  =get_subject_select_in();
	    $level      = $Data['level'];
	    $RowLevel   = $Data['RowLevel'];
	    $Class      = $Data['Class'];
	    $subject    = $Data['subject'];
	   if($level == 0 )   {$level = 'NULL' ; }
	   if($RowLevel == 0 )   {$RowLevel = 'NULL' ; }
	   //if($Class == 0 )   {$Class = 'NULL' ; }
	   if($subject == 0 )   {$subject = 'NULL' ; }
	   if($Class!= 0){
				$whereClass = "AND  test.classID REGEXP $Class"; 
			}
	    
	    $query = $this->db->query(" select test.ID,test.Name AS Name,test.empID ,contact.Name AS teachername,
		test.Token	AS token,test.Date_Stm as date
	    from test 
	    inner join contact on contact.ID = test.empID
	    inner join row_level on row_level.ID = test.RowLevelID
	    where 
	    test.is_deleted=0 
	    and test.type=1 
	    AND row_level.Level_ID	= IFNULL($level, row_level.Level_ID)
	    AND test.RowLevelID = IFNULL($RowLevel, test.RowLevelID)
	    AND test.IsActive=1
	    ".$whereClass."
	    AND test.subject_id = IFNULL($subject, test.subject_id)
	    AND test.SchoolId= ".(int)$this->session->userdata('SchoolID')."
	    AND test.RowLevelID IN(".$RowLevel_array.")
	    AND test.empID IN(".$Emp_array.")
	    AND test.subject_id IN(".$Subject_array.")
	    ");
	    if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
	}
	///////////////
	public function show_clerical_homework($Data)
	{
	     $RowLevel_array =get_rowlevel_select_in();
	    $Emp_array      =get_emp_select_in();
	    $Subject_array  =get_subject_select_in();
	    $level      = $Data['level'];
	    $RowLevel   = $Data['RowLevel'];
	    $Class      = $Data['Class'];
	    $subject    = $Data['subject'];
	    if($level == 0 )   {$level = 'NULL' ; }
	   if($RowLevel == 0 )   {$RowLevel = 'NULL' ; }
	   if($Class == 0 )   {$Class = 'NULL' ; }
	   if($subject == 0 )   {$subject = 'NULL' ; }
	    
	    $query = $this->db->query(" select clerical_homework.ID,clerical_homework.title AS Name,clerical_homework.Emp_ID ,
		contact.Name AS teachername,clerical_homework.token,clerical_homework.date_homework as date
	    from clerical_homework 
	    inner join contact on contact.ID     = clerical_homework.Emp_ID
	    inner join row_level on row_level.ID = clerical_homework.RowLevelID
	    where 
	    clerical_homework.is_deleted=0 
		AND clerical_homework.type = 0
	    AND($level    ='' OR row_level.Level_ID	= COALESCE($level, row_level.Level_ID))
	    AND($RowLevel ='' OR clerical_homework.RowLevelID = COALESCE($RowLevel, clerical_homework.RowLevelID))
	    AND($Class    ='' OR   FIND_IN_SET($Class, clerical_homework.classID))
	    AND($subject  ='' OR clerical_homework.Subject_ID = COALESCE($subject, clerical_homework.Subject_ID))
	    AND clerical_homework.SchoolID=".(int)$this->session->userdata('SchoolID')."
	    AND clerical_homework.RowLevelID IN(".$RowLevel_array.")
	    AND clerical_homework.Emp_ID IN(".$Emp_array.")
	    AND clerical_homework.Subject_ID IN(".$Subject_array.")
	    group by clerical_homework.token
	    ");
	    if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
	}
	///////////////
	public function show_revision($Data)
	{
	     $RowLevel_array =get_rowlevel_select_in();
	    $Emp_array      =get_emp_select_in();
	    $Subject_array  =get_subject_select_in();
	    $level      = $Data['level'];
	    $RowLevel   = $Data['RowLevel'];
	    $Class      = $Data['Class'];
	    $subject    = $Data['subject'];
	    if($level == 0 )   {$level = 'NULL' ; }
	   if($RowLevel == 0 )   {$RowLevel = 'NULL' ; }
	   if($Class == 0 )   {$Class = 'NULL' ; }
	   if($subject == 0 )   {$subject = 'NULL' ; }
	    
	    $query = $this->db->query(" select e_library.ID,e_library.Title AS Name,e_library.ContactID   ,
		contact.Name AS teachername,e_library.Token,e_library.Stm_Date as date
	    from e_library 
	    inner join contact on contact.ID     = e_library.ContactID  
	    inner join row_level on row_level.ID = e_library.RowLevelID 
		INNER JOIN subject ON subject.ID = e_library.SubjectID
	    where row_level.Level_ID	= IFNULL($level, row_level.Level_ID)
	    AND e_library.RowLevelID  = IFNULL($RowLevel, e_library.RowLevelID)
	    AND($Class    ='' OR   FIND_IN_SET($Class, e_library.ClassID ))
	    AND e_library.SubjectID     = IFNULL($subject , e_library.SubjectID )
	    AND e_library.SchoolID =".(int)$this->session->userdata('SchoolID')."
	    AND e_library.RowLevelID IN(".$RowLevel_array.")
	    AND e_library.ContactID IN(".$Emp_array.")
	    AND e_library.SubjectID IN(".$Subject_array.")
	    group by e_library.Token
	    ");
	    if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
	}
	/////////////////

	public function show_lessons($Data)
	{
	    $RowLevel_array =get_rowlevel_select_in();
	    $Emp_array      =get_emp_select_in();
	    $Subject_array  =get_subject_select_in();
	    $level      = $Data['level'];
	    $RowLevel   = $Data['RowLevel'];
	    $Class      = $Data['Class'];
	    $subject    = $Data['subject'];
	    if($level == 0 )   {$level = 'NULL' ; }
	   if($RowLevel == 0 )   {$RowLevel = 'NULL' ; }
	   if($Class == 0 )   {$Class = 'NULL' ; }
	   if($subject == 0 )   {$subject = 'NULL' ; }
	    
	    $query = $this->db->query(" select lesson_prep.ID,lesson_prep.Lesson_Title AS Name,lesson_prep.Teacher_ID    ,
		contact.Name AS teachername,lesson_prep.Token ,lesson_prep.Date as date
	    from lesson_prep 
	    inner join contact on contact.ID     = lesson_prep.Teacher_ID   
	    inner join row_level on row_level.ID = lesson_prep.RowLevel_ID  
		INNER JOIN subject ON subject.ID = lesson_prep.Subject_ID 
	    where row_level.Level_ID	= IFNULL($level, row_level.Level_ID)
	    AND lesson_prep.RowLevel_ID   = IFNULL($RowLevel, lesson_prep.RowLevel_ID )
	    AND($Class    ='' OR   FIND_IN_SET($Class, lesson_prep.ClassID ))
	    AND lesson_prep.Subject_ID      = IFNULL($subject , lesson_prep.Subject_ID  )
	    AND lesson_prep.School_ID  =".(int)$this->session->userdata('SchoolID')."
	    AND lesson_prep.RowLevel_ID  IN(".$RowLevel_array.")
	    AND lesson_prep.Teacher_ID  IN(".$Emp_array.")
	    AND lesson_prep.Subject_ID  IN(".$Subject_array.")
	    group by lesson_prep.Token 
	    ");
	    if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
	}
	/////////////////

	public function show_work_paper($Data)
	{
	     $RowLevel_array =get_rowlevel_select_in();
	    $Emp_array      =get_emp_select_in();
	    $Subject_array  =get_subject_select_in();
	    $level      = $Data['level'];
	    $RowLevel   = $Data['RowLevel'];
	    $Class      = $Data['Class'];
	    $subject    = $Data['subject'];
	    if($level == 0 )   {$level = 'NULL' ; }
	   if($RowLevel == 0 )   {$RowLevel = 'NULL' ; }
	   if($Class == 0 )   {$Class = 'NULL' ; }
	   if($subject == 0 )   {$subject = 'NULL' ; }
	    
	    $query = $this->db->query(" select clerical_homework.ID,clerical_homework.title AS Name,clerical_homework.Emp_ID ,
		contact.Name AS teachername,clerical_homework.token,clerical_homework.date_homework as date
	    from clerical_homework 
	    inner join contact on contact.ID     = clerical_homework.Emp_ID
	    inner join row_level on row_level.ID = clerical_homework.RowLevelID
	    where 
	    clerical_homework.is_deleted=0 
		AND clerical_homework.type = 1
	    AND($level    ='' OR row_level.Level_ID	= COALESCE($level, row_level.Level_ID))
	    AND($RowLevel ='' OR clerical_homework.RowLevelID = COALESCE($RowLevel, clerical_homework.RowLevelID))
	    AND($Class    ='' OR   FIND_IN_SET($Class, clerical_homework.classID))
	    AND($subject  ='' OR clerical_homework.Subject_ID = COALESCE($subject, clerical_homework.Subject_ID))
	    AND clerical_homework.SchoolID=".(int)$this->session->userdata('SchoolID')."
	    AND clerical_homework.RowLevelID IN(".$RowLevel_array.")
	    AND clerical_homework.Emp_ID IN(".$Emp_array.")
	    AND clerical_homework.Subject_ID IN(".$Subject_array.")
	    group by clerical_homework.token
	    ");
	    if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
	}
	/////////////////
	public function deletee($id,$type,$token)
	{
	    if($type==EX || $type==HW){
	    $query = $this->db->query("
	    
	    update test set is_deleted=1 where test.ID = $id

	    
	    ");
		if($type==EX ){
			$query2 = $this->db->query(" DELETE FROM `send_box_student` WHERE Test_ID = '".$id."'  AND Type_ID = 5 ");
			}elseif($type==HW){
			$query2 = $this->db->query(" DELETE FROM `send_box_student` WHERE Test_ID = '".$id."'  AND Type_ID = 6 ");
			}
	}
	    elseif($type==CL||$type==PW){
	    $query = $this->db->query("
	    
	    update clerical_homework set is_deleted=1 where clerical_homework.token = '".$token."'
	    
	    ");
		if($type==CL ){
			$query2 = $this->db->query(" DELETE FROM `send_box_student` WHERE Test_ID = '".$id."'  AND Type_ID = 3 ");
			}elseif($type==PW){
			$query2 = $this->db->query(" DELETE FROM `send_box_student` WHERE Test_ID = '".$id."'  AND Type_ID = 4 ");
			}
	}
		elseif($type==RV){
			$query = $this->db->query(" DELETE FROM `e_library` where e_library.ID  = '".$id."'");
			$query2 = $this->db->query(" DELETE FROM `send_box_student` WHERE Test_ID = '".$id."'  AND Type_ID = 2 ");
			$query3 = $this->db->query(" DELETE FROM `revision_report` WHERE lesson_id = '".$id."' ");
		}
			elseif($type==LE){
				$query = $this->db->query("
				
				DELETE FROM `lesson_prep` WHERE  lesson_prep.ID   = '".$id."'
				
				");
			$query2 = $this->db->query(" DELETE FROM `send_box_student` WHERE Test_ID = '".$id."'  AND Type_ID = 1 ");
			$query3 = $this->db->query(" DELETE FROM `lesson_report` WHERE lesson_id = '".$id."'  ");
			}
	    else{}                  
	    return true;
	}
	/////////////////////////////
	public function get_type($ID)
	 { 
		
		$ResultExam = $this->db->query("SELECT `type` FROM `test` WHERE `ID`= $ID ");		

 		$NumRowResultExam = $ResultExam->result() ; 
 		if($NumRowResultExam >0){$ReturnExam     = $ResultExam ->result() ;
 		return $ReturnExam ; 
        return TRUE ; 
		}else{return $NumRowResultExam ;return FALSE ;}
	}
// 	/////////////////////////////
// 
// 	////////////////////////////

	
	public function exam_analysis($Exam_ID)
	{
	    $GetData = $this->db->query("call Usp_GetExamResultStatistics(".$Exam_ID.")");
		//$this->db->reconnect();
		if($GetData->num_rows()>0)
		{
		    mysqli_next_result( $this->db->conn_id );
		    return $GetData->result();
		   
		}else{
			   return FALSE ;
			 }
 
	}
	
	public function exam_questions($Exam_ID)
	{
	    $GetData = $this->db->query("call Usp_GetExamResultStatisticsPerQuestion(".$Exam_ID.")");
		//$this->db->reconnect();
		if($GetData->num_rows()>0)
		{
		    mysqli_next_result( $this->db->conn_id );
		    return $GetData->result();
		   
		}else{
			   return FALSE ;
			 }
 
	}
 }
?>