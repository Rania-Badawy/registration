<?php
class Lessons_Model  extends CI_Model 
 {
	 private $Level_Row_ID ;
	 private $Subject_ID ;
	 private $Token;
	 
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
 public function get_lessons_prep($data)
	{
		$RowLevelID 	= $data['RowLevelID'] ;
		$SubjectID 		= $data['SubjectID'] ;
		$SemesterID     = $data['SemesterID'] ;
		$TeacherID  	= $this->session->userdata('id');
		
		$this->db->select('lesson_prep.ID AS LessonID , lesson_prep.classID AS LessonclassID, lesson_prep.Lesson_Title AS LessonTitle ,lesson_prep.Date AS LessonDate , 
		                   lesson_prep.Token AS LessonToken ,lesson_prep.RowLevel_ID ,lesson_prep.Subject_ID,row_level.Level_Name AS LevelName,row_level.Row_Name  AS RowName,
		                   subject.Name  AS SubjectName,lesson_prep.date_from,lesson_prep.date_to' );
		$this->db->from('lesson_prep');
		$this->db->join('subject','lesson_prep.Subject_ID=subject.ID');
		$this->db->join('row_level','lesson_prep.RowLevel_ID=row_level.ID');
		$this->db->join("config_semester","config_semester.ID=$SemesterID AND lesson_prep.date_from  BETWEEN config_semester.start_date AND config_semester.end_date ");
		$this->db->where('lesson_prep.RowLevel_ID', $RowLevelID );
		$this->db->where('lesson_prep.Subject_ID', $SubjectID );
		$this->db->where('lesson_prep.Teacher_ID', $TeacherID );
		$this->db->order_by('lesson_prep.ID', 'desc');
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
	/////////////////////////////
	public function get_lesson_eva($LessonID)
	{
	 	 $query = $this->db->query(" SELECT lesson_prep.Lesson_Title,lesson_prep_eval.Degree,lesson_prep_eval.Notes,lesson_prep_eval.DateSTM,tb2.ID AS ContactID,tb2.Name AS ContactName 
			                         FROM lesson_prep_eval
                        			 INNER JOIN contact AS tb2 ON lesson_prep_eval.ContactID = tb2.ID 
                        			 INNER JOIN lesson_prep ON lesson_prep_eval.LessonPrepID = lesson_prep.ID
                        			 WHERE lesson_prep.ID ='".$LessonID."' ");  
	 if($query->num_rows()>0)
        {
            return $query->result();
        }else{return false ;}
	}
	////////////////////////////////////
	public function test_class($class_ID)
	{
		$result = $this->db->query("select ID,Name from class where ID IN( $class_ID)  ");
		
		return $result->result();
	}
	/////////////////////////////////
	public function get_lesson_details($lessonID)
	{
	 	$this->db->select('lesson_prep.*,row_level.Level_Name,row_level.Row_Name,subject.Name as subject_name,contact.Name as teacher_name');
		$this->db->from('lesson_prep');
		$this->db->join('subject', 'subject.ID = lesson_prep.Subject_ID' ,'INNER');
		$this->db->join('row_level', 'lesson_prep.RowLevel_ID = row_level.ID' ,'INNER');
		$this->db->join('contact', 'lesson_prep.Teacher_ID = contact.ID' ,'INNER');
		$this->db->where('lesson_prep.ID', $lessonID );
		$this->db->limit(1);
		$ResultLessonDetails = $this->db->get();			
		$NumRowResultLessonDetails  = $ResultLessonDetails->num_rows() ; 
		if($NumRowResultLessonDetails != 0)
		  {
				return $ResultLessonDetails->row_array() ;
		  }
		  else
		  {
			  return false ;
		  }
	}
	////////////////////////////
	 public function get_emp_subjects( $UID = 0 ,$rowlevelid,$SubjectID)
	{
	  
			$query = $this->db->query("SELECT level.Name AS LevelName,row.Name AS RowName,row_level.ID AS RowLevelID, subject.ID AS SubjectID,subject.Name AS SubjectName
                        			   FROM  class_table
                            		   INNER JOIN subject          ON class_table.SubjectID   = subject.ID
                            		   INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
                            		   INNER JOIN row              ON row_level.Row_ID       = row.ID
                            		   INNER JOIN level            ON row_level.Level_ID     = level.ID
                        			   WHERE class_table.EmpID = ".$UID." AND class_table.RowLevelID = '".$rowlevelid."'  AND class_table.SubjectID = '".$SubjectID."'
                                       GROUP BY class_table.SubjectID , class_table.RowLevelID
			");
	
			  if($query->num_rows() >0)
			  {return $query->result();}else{return FALSE ;}
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
	///////////////////////////////////
	 public function get_skills_row_level($rowlevelid,$SubjectID)
    { 

       
        $query = $this->db->query("select  
			 row_level.Level_Name     AS LevelName,
			 row_level.Row_Name       AS RowName,
			 row_level.ID   AS RowLevelID,
			 subject.ID     AS SubjectID,
			 subject.Name   AS SubjectName ,
			 config_semester.Name   AS config_semester ,
			 skills.*
			  from skills 
 			  INNER JOIN subject          ON skills.SubjectID   = subject.ID
 			  INNER JOIN row_level        ON skills.RowLevelID  = row_level.ID
			  INNER JOIN config_semester  ON skills.termID     = config_semester.ID 
 		      WHERE subject.Is_Active = 1 
 		      AND skills.IsActive     = 1 
              AND skills.RowLevelID   = '".$rowlevelid."' 
              AND skills.SubjectID    = '".$SubjectID."'
			  AND skills.termID       = '".$this->session->userdata('currentSemesterID')."'
			  AND skills.year_id      = '".$this->session->userdata('YearID')."'
              GROUP BY skills.name
             order BY skills.ID DESC  ")->result();
        if(sizeof($query)> 0 ){  return $query;}else{return 0 ;return FALSE ;}
    } 
    ///////////////////////////////////////////////////
    	public function add_lesson_prep($data)
	{	
	   
	    extract($data);
	                $txt_Aims                             = $this->input->post('txt_Aims');
		 			$ImploadAims                          = implode(',',$txt_Aims);
					$num_Aids                             = $this->input->post('txt_Aids');			
					$ImploadAids                          = implode(',',$num_Aids);
					$num_Reviews                          = $this->input->post('txt_Reviews');			
				  	$ImploadReviews                       = implode(',',$num_Reviews);
					$Learning_intentions                  = $this->input->post('Learning_intentions');			
				  	$ImploadLearning_intentions           = implode(',',$Learning_intentions);
					$Assessment_opportunities             = $this->input->post('Assessment_opportunities');			
				  	$ImploadAssessment_opportunities      = implode(',',$Assessment_opportunities);
					$Differentiation_opportunities        = $this->input->post('Differentiation_opportunities');			
				  	$ImploadDifferentiation_opportunities = implode(',',$Differentiation_opportunities);
					$Plenary_reflection                   = $this->input->post('Plenary_reflection');			
				  	$ImploadPlenary_reflection            = implode(',',$Plenary_reflection);
					$num_Scripts                          = $this->input->post('num_Scripts');	
					$count4                               = 1 ; 
					$ScriptsArray = array(); 
					while($count4 <= $num_Scripts)
						 {
						     
							 $txt_Scripts = 'txt_Script'.$count4;
							 $full_Scripts = $this->input->post($txt_Scripts);
							 if($full_Scripts!=""){
							 $ScriptsArray[] =  $full_Scripts  ;
							 }
							 $count4 ++;
						 }
				  	    $ImploadScripts      = implode(',',$ScriptsArray);
                		$Select_subject      = $this->input->post('Select_subject');
                		$Select_subject      = explode( '|' , $Select_subject );
                 		$TeacherID  		 = $this->session->userdata('id'); 
                 		$SchoolID            = $this->session->userdata('SchoolID');
                		$SubjectID           = $Select_subject[0];
                		$RowLevelID          = $Select_subject[1];
                		$Title 		         = $this->input->post('lessonTitle') ;
                		$Stratigy 		     = implode( '||',$this->input->post('lessonStratigy') );
                		$Intro 	 			 = $this->input->post('lessonIntro');
                		$Content 			 = $this->input->post('lessonContent');
                		$TrainHome 			 = $this->input->post('trainhome');
                		$slct_class          = implode( ',' , $this->input->post('slct_class'));
                		$fileUpload_image 	 = implode( ',' ,$this->input->post('fileUpload_image'));
                    	$SelectSkills 	     = implode( ',' ,$this->input->post('SelectSkills')); 
                		(string)$this->Token = $this->create_token() ; 
                		$image 				 = $this->input->post('hidImg'); 
                		$image2 			 = $this->input->post('hidImg2'); 
                		$date_from 			 = $this->input->post('DayDateFrom'); 
                		$date_to 			 = $this->input->post('DayDateTo'); 
						$teacher_tools 	     = implode( ',' ,$this->input->post('teacher_tools')); 
						$clerical 			 = $this->input->post('clerical'); 
						$why_learn_content 	 = $this->input->post('why_learn_content'); 
						$why_learn_tool 	 = $this->input->post('why_learn_tool'); 
						$why_learn_date      = $this->input->post('why_learn_date'); 
						$what_learn_content  = $this->input->post('what_learn_content'); 
						$what_learn_tool 	 = $this->input->post('what_learn_tool'); 
						$what_learn_date     = $this->input->post('what_learn_date'); 
						$how_learn_content 	 = $this->input->post('how_learn_content'); 
						$how_learn_tool 	 = $this->input->post('how_learn_tool'); 
						$how_learn_date      = $this->input->post('how_learn_date'); 
						$what_if_learn_content 	 = $this->input->post('what_if_learn_content'); 
						$what_if_learn_tool  = $this->input->post('what_if_learn_tool'); 
						$what_if_learn_date  = $this->input->post('what_if_learn_date'); 
		                $add_1 = array(
						 'Teacher_ID'                   =>(int)$TeacherID  ,
						 'School_ID'                    =>(int)$SchoolID  ,
						 'classID'                      =>$slct_class,
						 'Subject_ID'  		            =>(int)$SubjectID  ,
						 'RowLevel_ID'  		        =>(int)$RowLevelID ,
						 'Lesson_Title'                 =>(string)$Title ,
						 'stratigy'           	        =>(string)$Stratigy ,
						 'Aims'					        =>(string)$ImploadAims ,
						 'Aids'					        =>(string)$ImploadAids ,
						 'Intro'				        =>(string)$Intro ,
						 'Content'				        =>(string)$Content ,
						 'Reviews'				        =>(string)$ImploadReviews ,
						 'Learning_intentions'          =>(string)$ImploadLearning_intentions ,
						 'Assessment_opportunities'     =>(string)$ImploadAssessment_opportunities ,
						 'Differentiation_opportunities'=>(string)$ImploadDifferentiation_opportunities ,
						 'Plenary_reflection'           =>(string)$ImploadPlenary_reflection ,
						 'trainhome'			        =>(string)$TrainHome ,
						 'Attachs'				        =>(string)$image ,
						 'Attach_prepare'		        =>(string)$image2 ,
						 'Scripts'				        =>(string)$ImploadScripts ,
						 'skillsID'				        =>(string)$SelectSkills, 
						 'Token'                        =>(string)$this->Token ,
						 'IsActive'                     =>(int)1,
						 'Image'                        =>$fileUpload_image,
						 'teacher_tools'				=>$teacher_tools, 
						 'clerical'				        =>$clerical, 
						 'why_learn'				    =>$why_learn_content."||".$why_learn_tool."||".$why_learn_date, 
						 'what_learn'				    =>$what_learn_content."||".$what_learn_tool."||".$what_learn_date, 
						 'how_learn'				    =>$how_learn_content."||".$how_learn_tool."||".$how_learn_date, 
						 'what_if_learn'				=>$what_if_learn_content."||".$what_if_learn_tool."||".$what_if_learn_date, 
						 'Date'                         =>$date,
						 'date_from'                    =>$date_from,
						 'date_to'                      =>$date_to
						 
					    );
					  	$Insert_1 =  $this->db->insert('lesson_prep', $add_1);
					    $test_id  =  $this->db->insert_id();
		                $add_2 = array(
						 'Emp_ID'                 =>(int)$TeacherID  ,
						 'Subject_ID'  		      =>(int)$SubjectID  ,
						 'R_L_ID'  		          =>(int)$RowLevelID ,
						 'Name'                   =>(string)$Title ,
						 'Type_ID'                =>(int)3,
						 'Is_Active '             =>1,
						 'token'                  =>(string)$this->Token,
						 "Test_ID "               =>(int)$test_id,
						 'Class_ID'               =>$slct_class,
						 'School_ID'              =>$SchoolID,
						 'DATE'                   =>$date
					  );
	
		$Insert_2 =  $this->db->insert('send_box', $add_2); 
		if($Insert_1 && $Insert_2)
		{
			add_notification($this->db->insert_id(),4,$RowLevelID,$SubjectID,0);
			return TRUE ;	    
		} 
		else 
		{
			return FALSE;	
		}
	} 
    /////////////////////////////////////////////////////
    	public function update_lesson_prep($lessonID)
	{	
                   

					$Stratigy 		                      = $this->input->post('lessonStratigy') ;
		 			$ImploadStratigy                      = implode('||',$Stratigy);
		 			$txt_Aims                             = $this->input->post('txt_Aims');
		 			$ImploadAims                          = implode(',',$txt_Aims);
					$num_Aids                             = $this->input->post('txt_Aids');			
					$ImploadAids                          = implode(',',$num_Aids);
					$num_Reviews                          = $this->input->post('txt_Reviews');			
				  	$ImploadReviews                       = implode(',',$num_Reviews);		
					$Learning_intentions                  = $this->input->post('Learning_intentions');			
				  	$ImploadLearning_intentions           = implode(',',$Learning_intentions);
					$Assessment_opportunities             = $this->input->post('Assessment_opportunities');			
				  	$ImploadAssessment_opportunities      = implode(',',$Assessment_opportunities);
					$Differentiation_opportunities        = $this->input->post('Differentiation_opportunities');			
				  	$ImploadDifferentiation_opportunities = implode(',',$Differentiation_opportunities);
					$Plenary_reflection                   = $this->input->post('Plenary_reflection');			
				  	$ImploadPlenary_reflection            = implode(',',$Plenary_reflection);		 
					$num_Scripts                          = $this->input->post('num_Scripts');
					if($num_Scripts==""){
					    $num_Scripts=1;
					}
					$count4  = 1 ; 
					$ScriptsArray = array(); 
					while($count4 <= $num_Scripts)
						 {
							 $txt_Scripts = 'txt_Script'.$count4;
							 $full_Scripts = $this->input->post($txt_Scripts);

							 if($full_Scripts!=""){
							 $ScriptsArray[] =  $full_Scripts  ;
							 }
							 $count4 ++;
						 }
				  	$ImploadScripts      = implode(',',$ScriptsArray);
            		$Title 		         = $this->input->post('lessonTitle') ; 
            		$Intro 	 			 = $this->input->post('lessonIntro');
            		$Content 			 = $this->input->post('lessonContent');
            		$TrainHome 			 = $this->input->post('trainhome');
            		$image 				 = $this->input->post('hidImg'); 
            		$image2 			 = $this->input->post('hidImg2');
            		$skills_ID		     = implode(',',$this->input->post('SelectSkills')); 
            		$classID			 = implode(',',$this->input->post('slct_class'));
					$teacher_tools 	     = implode( ',' ,$this->input->post('teacher_tools')); 
					$clerical 			 = $this->input->post('clerical'); 
					$why_learn_content 	 = $this->input->post('why_learn_content'); 
					$why_learn_tool 	 = $this->input->post('why_learn_tool'); 
					$why_learn_date      = $this->input->post('why_learn_date'); 
					$what_learn_content  = $this->input->post('what_learn_content'); 
					$what_learn_tool 	 = $this->input->post('what_learn_tool'); 
					$what_learn_date     = $this->input->post('what_learn_date'); 
					$how_learn_content 	 = $this->input->post('how_learn_content'); 
					$how_learn_tool 	 = $this->input->post('how_learn_tool'); 
					$how_learn_date      = $this->input->post('how_learn_date'); 
					$what_if_learn_content 	 = $this->input->post('what_if_learn_content'); 
					$what_if_learn_tool  = $this->input->post('what_if_learn_tool'); 
					$what_if_learn_date  = $this->input->post('what_if_learn_date'); 
            		$date_from 			 = $this->input->post('DayDateFrom');
            		$date_to 			 = $this->input->post('DayDateTo');
                    
		if($Title !=""&& $Content != "" ){
		$add_1 = array(
						 'Lesson_Title'           =>(string)$Title ,
						 'stratigy'           	  =>(string)$ImploadStratigy ,
						 'Aims'					  =>(string)$ImploadAims ,
						 'Aids'					  =>(string)$ImploadAids ,
						 'Intro'				  =>(string)$Intro ,
						 'Content'				  =>(string)$Content ,
						 'Reviews'				  =>(string)$ImploadReviews ,
						 'Learning_intentions'    =>(string)$ImploadLearning_intentions ,
						 'Assessment_opportunities'     =>(string)$ImploadAssessment_opportunities ,
						 'Differentiation_opportunities'=>(string)$ImploadDifferentiation_opportunities ,
						 'Plenary_reflection'     =>(string)$ImploadPlenary_reflection ,
						 'trainhome'			  =>(string)$TrainHome ,
						 'Attachs'				  =>(string)$image ,
						 'Attach_prepare'		  =>(string)$image2 ,
						 'Scripts'				  =>(string)$ImploadScripts ,
						 'skillsID '              =>(string)$skills_ID,
						 'classID '               =>(string)$classID,
						 'teacher_tools'		  =>$teacher_tools, 
						 'clerical'				  =>$clerical, 
						 'why_learn'			  =>$why_learn_content."||".$why_learn_tool."||".$why_learn_date, 
						 'what_learn'			  =>$what_learn_content."||".$what_learn_tool."||".$what_learn_date, 
						 'how_learn'			  =>$how_learn_content."||".$how_learn_tool."||".$how_learn_date, 
						 'what_if_learn'		  =>$what_if_learn_content."||".$what_if_learn_tool."||".$what_if_learn_date, 
						 'date_from '             =>$date_from,
						 'date_to '               =>$date_to
						 
					  );
// print_r($add_1);die;
				    $this->db->where('ID', $lessonID);
		$Update_1=  $this->db->update('lesson_prep', $add_1); 
						$add_2 = array(
						 'Name'           =>(string)$Title ,
						 'Class_ID'         =>(string)$classID
						
					  );


				    $this->db->where('ID', $lessonID);
		$Update_2=  $this->db->update('send_box', $add_2); 
					
	}
		if($Update_1 &&$Update_2)
	
		{
			return TRUE ;	    
		} 
		else 
		{
			return FALSE;	
		}
	} 
/////////////////////////////////////////////////
   public function lesson_prep_del($LessonID)
	{
	 	$this->db->delete('lesson_prep', array('ID' => $LessonID));
		return TRUE ;
	}
	////////////////////////////////
	public function student_lesson_report($Data=array())
    {
       extract($Data);
	   $Lang=$this->session->userdata('language');
       $query=$this->db->query("SELECT lesson_prep.`id`,lesson_report.`watch-at` AS Date , 
	   CASE
            WHEN '$Lang' = 'english' and contact.Name_en IS not NULL and contact.Name_en !=' ' THEN contact.Name_en
            ELSE contact.Name
            END AS Name ,
	       lesson_prep.Lesson_Title AS Title FROM `lesson_report` 
                                INNER JOIN student ON student.Contact_ID = lesson_report.student_id 
                                INNER JOIN contact ON contact.ID = student.Contact_ID
                                INNER JOIN lesson_prep ON lesson_prep.ID = lesson_report.lesson_id and lesson_prep.RowLevel_ID=student.R_L_ID and FIND_IN_SET(student.Class_ID,lesson_prep.classID)
                                WHERE lesson_report.lesson_id = $ID
                                GROUP BY lesson_report.student_id
								order by Name asc
                                ") ;
       if($query->num_rows()>0)
            {
                return $query->result();
            }else{
                return false ;
            }
    }
    //////////////////////////
    public function get_rowlevel($data)
	{
		$RowLevelID = $data['RowLevelID'] ;
		$this->db->select('ID AS rowLevelID , Level_Name AS LevelName , Row_Name AS RowName ');    
		$this->db->from('row_level');
		$this->db->where('ID',$RowLevelID);
		
		$RowLevelJoin = $this->db->get();
			
		$NumRowLevelJoin  = $RowLevelJoin->num_rows() ; 
			if($NumRowLevelJoin >0)
			  {
				$ReturnRowLevelJoin = $RowLevelJoin->row_array() ;
			   	return $ReturnRowLevelJoin ; 
			  }else{return FALSE ;}
	}
	/////////////////////////////
	public function get_subject($data)
	{
		$SubjectID = $data['SubjectID'] ;
		$this->db->select('ID AS SubjectID , Name AS SubjectName');    
		$this->db->from('subject');
		$this->db->where('ID', $SubjectID);
		
		$SubjectName = $this->db->get();
			
		$NumSubjectName  = $SubjectName->num_rows() ; 
			if($NumSubjectName >0)
			  {
				$ReturnSubjectName = $SubjectName->row_array() ;
			   	return $ReturnSubjectName ; 
			  }else{return FALSE ;}
	}
	/////////////////////////////////////////hajer
	// get contact Subjects
	public function get_contact_subjects()
	{
		$ContactID  	= $this->session->userdata('id');
		
		$this->db->select('subject_emp.Subject_ID AS SubjectID , subject_emp.Row_Level_ID AS RowLevelID , subject.Name AS SubjectName , 
						   row_level.Level_Name AS LevelName , row_level.Row_Name AS RowName
						  ');
		$this->db->from('subject_emp');
		$this->db->join('subject', 		'subject.ID		= subject_emp.Subject_ID', 'INNER');
		$this->db->join('row_level', 	'row_level.ID	= subject_emp.Row_Level_ID', 'INNER');
		$this->db->where('subject_emp.Contact_ID', $ContactID );
		
		$ResultTeacherSubjects = $this->db->get();			
		$NumRowResultTeacherSubjects  = $ResultTeacherSubjects->num_rows() ; 
		if($NumRowResultTeacherSubjects != 0)
		  {
				$ReturnTeacherSubjects = $ResultTeacherSubjects ->result() ;
				return $ReturnTeacherSubjects ;
		  }
		  else
		  {
			  return false ;
		  }
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	// Add Lesson Prep


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function get_row_subject($RowLevelID  ,	$SubjectID  )
	{
	  	if($this->session->userdata('language') == 'arabic')
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
			
			  WHERE class_table.RowLevelID= ".$RowLevelID." and class_table.SubjectID  = ".$SubjectID."
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
				 
			        	  WHERE class_table.RowLevelID= ".$RowLevelID." and class_table.SubjectID  = ".$SubjectID."
				");
			}
			  if($query->num_rows() >0)
			  {return $query->row_array();}else{return FALSE ;}
	}
	
	



	/// Lessons Counter
	public function check_count($SubID,$rowLevelId)
	{
		$TeacherID  	= $this->session->userdata('id');
				$WhereArray     = array('RowLevel_ID'=>$rowLevelId,'Subject_ID'=>$SubID,'Teacher_ID'=>$TeacherID);
				
				$this->db->select('count(ID) AS Count');
				$this->db->from('lesson_prep');
				$this->db->where($WhereArray);
				$this->db->limit(1);
				$ResultLessonDetails = $this->db->get();
				$Return = $ResultLessonDetails->row_array();
				$Count  = $Return['Count'];
				return (int)$Count;		
	}

///////////////////////////////////// Update /////////////////////////////////////////////////////////////////////////////////////////////////

	// get Lesson Data
	public function get_lesson_edit($LessonToken)
	{
	 	$this->db->select('lesson_prep.*');
		$this->db->from('lesson_prep');
		
		$this->db->where('lesson_prep.Token', $LessonToken );
		$this->db->limit(1);
		$ResultLessonData = $this->db->get();			
		$NumRowResultLessonData  = $ResultLessonData->num_rows() ; 
		if($NumRowResultLessonData != 0)
		  {
				return $ResultLessonData->row_array() ;
		  }
		  else
		  {
			  return false ;
		  }
	}
	
	// get Lesson Data
	
	
	// Update Lesson Prep

	// Get Lessons 2 Students
	public function get_student_lessons ($data)
	{	
		$RowLevelID 	= $data['RowLevelID'] ;
		$SubjectID 		= $data['SubjectID'] ;
		
		$this->db->select('lesson_prep.ID AS LessonID, lesson_prep.Lesson_Title AS LessonTitle ,lesson_prep.Date AS LessonDate , lesson_prep.Token AS LessonToken');
		$this->db->from('lesson_prep');
		$this->db->where('RowLevel_ID', $RowLevelID );
		$this->db->where('Subject_ID', $SubjectID );
		$this->db->where('startDate <=CURDATE() '  ); 
		$ResultLessons = $this->db->get();			
		$NumRowResultLessons  = $ResultLessons->num_rows() ; 
 		if($NumRowResultLessons != 0)
		  {
				$ReturnLessons = $ResultLessons ->result() ;
				return $ReturnLessons ;
		  }
		  else
		  {
			  return 0 ;
			  return false ;
		  }
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////
	public function get_RowLevel_Name ($RowLevel_ID)
	{	
		$this->db->select('level.Name AS LevelName , row.Name AS RowName');
		$this->db->from('row_level');
		$this->db->join('level', 'level.ID = row_level.Level_ID');
		$this->db->join('row', 'row.ID = row_level.Row_ID');
		$this->db->where('row_level.ID', $RowLevel_ID );
		
		$ResultRowLevelName = $this->db->get();			
		$NumRowResultRowLevelName  = $ResultRowLevelName->num_rows() ; 
		if($NumRowResultRowLevelName != 0)
		  {
				$ReturnRowLevelName = $ResultRowLevelName ->row_array() ;
				return $ReturnRowLevelName ;
		  }
		  else
		  {
			  return false ;
		  }
	}

	public function get_Teacher_Name ($TeacherID)
	{	
		$this->db->select('Name');
		$this->db->from('contact');
		$this->db->where('ID', $TeacherID );
		$ResultTeacher = $this->db->get();			
		$NumRowResultTeacher  = $ResultTeacher->num_rows() ; 
		if($NumRowResultTeacher != 0)
		  {
				$ReturnTeacher = $ResultTeacher ->row_array() ;
				return $ReturnTeacher ;
		  }
		  else
		  {
			  return false ;
		  }
	}

	public function get_Subject_Name ($SubjectID)
	{	
		$this->db->select('Name');
		$this->db->from('subject');
		$this->db->where('ID', $SubjectID);
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
	public function get_lesson_class ($classID,$lessonID)
	{
	    $query1 = $this->db->query("select classID from lesson_prep where lesson_prep.ID='".$lessonID."'")->row_array();
	    $classid=$query1['classID'];
	    if($classid){
	    $query = $this->db->query("select class.ID AS ID,class.Name AS Name from class where ID in ($classid)")->result();
	    }else{
	        $query=0;
	    }
        if(sizeof($query)> 0 ){return $query;}else{return 0 ;return FALSE ;}
	}
	 public function get_skill_1($ID =null)
    {
        $query = $this->db->query("select * from skills where ID in ($ID) ")->result();
        if(sizeof($query)> 0 ){return $query;}else{return 0 ;return FALSE ;}
    }
    	public function edit_lesson_class ($SubjectID)
	{	if($this->session->userdata('language')=="english"){
		$this->db->select('class.Name_en as Name , class.ID');  }
		else
		 { $this->db->select('class.Name  as Name, class.ID');}
		$this->db->from('config_emp');	
		$this->db->join('class_table', 'class_table.RowLevelID = config_emp.RowLevelID ', 'INNER'); 
		$this->db->join('class', 'class.ID =class_table.ClassID', 'INNER'); 
		$this->db->where('class_table.EmpID',(int)$this->session->userdata('id'));
		$this->db->where('config_emp.SubjectID',(int)$SubjectID);
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
	 public function get_skills_row_level1($SubjectID,$RowLevelID)
    { 
$item = explode("|", $item);
 //return $item ;
        $query = $this->db->query("select  
			 level.Name     AS LevelName,
			 row.Name       AS RowName,
			 row_level.ID   AS RowLevelID,
			 subject.ID     AS SubjectID,
			 subject.Name   AS SubjectName ,
			 config_term.Name   AS config_term ,
			 config_semester.Name   AS config_semester ,
			 skills.*
			  from skills 
 			  INNER JOIN subject          ON skills.SubjectID   = subject.ID
 			  INNER JOIN row_level        ON skills.RowLevelID  = row_level.ID
			  INNER JOIN row              ON row_level.Row_ID       = row.ID
			  INNER JOIN level            ON row_level.Level_ID     = level.ID
			  INNER JOIN config_term     ON config_term.ID     = skills.termID
			  INNER JOIN config_semester     ON config_term.config_semesterID     = config_semester.ID
 		      where  subject.Is_Active =1 and  subject.Method = 1 and skills.IsActive =  1 and config_term.IsActive =  1
              and  skills.RowLevelID  = $RowLevelID and skills.SubjectID   = $SubjectID
              order BY skills.ID DESC  ")->result();
        if(sizeof($query)> 0 ){  return $query;}else{return 0 ;return FALSE ;}
    } 
    public function get_lesson_details2($lesson_id)
	{
	 	$this->db->select('* ,lesson_prep_eval.ID as lesson_prep_eval_ID ');
		$this->db->from('lesson_prep_eval');
		$this->db->join('lesson_prep','lesson_prep_eval.LessonPrepID=lesson_prep.ID','INNER');
		$this->db->where('lesson_prep.ID', $lesson_id );
		$ResultLessonDetails = $this->db->get();			
		$NumRowResultLessonDetails  = $ResultLessonDetails->num_rows() ; 
		if($NumRowResultLessonDetails != 0)
		  {
				return $ResultLessonDetails->row_array() ;
		  }
		  else
		  {
			  return false ;
		  }
	}

	
 }//End Class