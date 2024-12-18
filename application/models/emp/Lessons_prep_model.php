<?php
class Lessons_Prep_Model  extends CI_Model 
 {
	 private $Level_Row_ID ;
	 private $Subject_ID ;
	 private $Token;
	 
 	// Get Info (RowLevel)
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
	
	// Get Info (Subject)
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
	
	
	// get contact Subjects
	public function get_contact_subjects()
	{
		$ContactID  	= $this->session->userdata('id');
		
		$this->db->select('subject_emp.Subject_ID AS SubjectID , subject_emp.Row_Level_ID AS RowLevelID , subject.Name AS SubjectName , 
						   row_level.Level_Name AS LevelName , row_level.Row_Name AS RowName
						  ');
		$this->db->from('subject_emp');
		$this->db->join('subject', 		'subject.ID		= subject_emp.Subject_ID'  			, 'INNER');
		$this->db->join('row_level', 	'row_level.ID	= subject_emp.Row_Level_ID' 		, 'INNER');
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
	public function add_lesson_prep ($data)
	{	print_r(ddd);
		// Insert 2 [Aims Txt]
					$num_Aims     = $this->input->post('num_Aims');			
					$count  = 1 ; 
					$AimsArray = array();
					while($count <= $num_Aims)
						 {
							 $txt_Aims = 'txt_Aims'.$count;
							 $txt_Aims = $this->input->post($txt_Aims);
							 $AimsArray[] =  $txt_Aims ; 
							 $count ++;
						 } /// Aims Txt While End
		 			$ImploadAims = implode(',',$AimsArray);
		
		
		// Insert 3 [Aids Txt]
					$num_Aids     = $this->input->post('num_Aids');			
					$count2  = 1 ;
					$AidsArray = array(); 
					while($count2 <= $num_Aids)
						 {
							 $txt_Aids = 'txt_Aids'.$count2;
							 $txt_Aids = $this->input->post($txt_Aids);
							 $AidsArray[] =  $txt_Aids ;
							 $count2 ++;
						 } /// Aids Txt While End
					$ImploadAids = implode(',',$AidsArray);

		// Insert 6 [Reviews Txt]
					$num_Reviews   = $this->input->post('num_Reviews');			
					$count3  = 1 ; 
					$ReviewsArray = array(); 
					while($count3 <= $num_Reviews)
						 {
							 $txt_Reviews = 'txt_Reviews'.$count3;
							 $txt_Reviews = $this->input->post($txt_Reviews);
							 $ReviewsArray[] =  $txt_Reviews ;
							 $count3 ++;
						 } /// Reviews Txt While End
				  	$ImploadReviews = implode(',',$ReviewsArray);				 
		
		// Insert 7 [Scripts Txt]
					$num_Scripts   = $this->input->post('num_Scripts');			
					$count4  = 1 ; 
					$ScriptsArray = array(); 
					while($count4 <= $num_Scripts)
						 {
							 $txt_Scripts = 'txt_Script'.$count4;
							 $full_Scripts = $this->input->post($txt_Scripts);

							 /*$vowels = array("https","http", ":",".com","embed", "/", "<", ">", "youtu", ".be", "www", "youtube", "watch?v=", "iframe", "src=", "allowfullscreen");
							 $txt_Scripts = str_replace($vowels, "", $full_Scripts);*/
							 
							 $ScriptsArray[] =  $full_Scripts  ;
							 $count4 ++;
						 } /// Scripts Txt While End
				  	$ImploadScripts = implode(',',$ScriptsArray);				 
					
		
		
		// Insert 1 [IDs + Title]
		$TeacherID  		 = $this->session->userdata('id'); 
		$SubjectID           = $Select_subject[0];
		$RowLevelID          = $Select_subject[1];
		$Title 		         = $this->input->post('lessonTitle') ;
		$Stratigy 		     = $this->input->post('lessonStratigy') ;
		$Intro 	 			 = $this->input->post('lessonIntro');
		$Content 			 = $this->input->post('lessonContent');
		$TrainHome 			 = $this->input->post('trainhome');
		$SelectSkills 			 = $this->input->post('SelectSkills'); 
		(string)$this->Token = $this->create_token() ; 
		$image 				 = $this->input->post('hidImg'); 
		$Select_subject      = $this->input->post('Select_subject');
		$Select_subject      = explode( '|' , $Select_subject );
		print_r($Select_subject);
		
		$add_1 = array(
						 'Teacher_ID'             =>(int)$TeacherID  ,
						 'Subject_ID'  		      =>(int)$SubjectID  ,
						 'RowLevel_ID'  		  =>(int)$RowLevelID ,
						 'Lesson_Title'           =>(string)$Title ,
						 'stratigy'           	  =>(string)$Stratigy ,
						 'Aims'					  =>(string)$ImploadAims ,
						 'Aids'					  =>(string)$ImploadAids ,
						 'Intro'				  =>(string)$Intro ,
						 'Content'				  =>(string)$Content ,
						 'Reviews'				  =>(string)$ImploadReviews ,
						 'trainhome'			  =>(string)$TrainHome ,
						 'Attachs'				  =>(string)$image ,
						 'Scripts'				  =>(string)$ImploadScripts ,
						 'skillsID'				  =>(int)$SelectSkills, 
						 'Token'                  =>(string)$this->Token ,
						 'IsActive'               =>(int)1
					  );
					  $Insert_1 =  $this->db->insert('lesson_prep', $add_1);
					  $Insert_ID= $this->db->insert_id();
					  add_notification($this->db->insert_id(),4,$RowLevelID,$SubjectID,0);
					  
					  $add_2 = array(
						 'Emp_ID'             =>(int)$TeacherID  ,
						 'Subject_ID'  		      =>(int)$SubjectID  ,
						 'R_L_ID'  		  =>(int)$RowLevelID ,
						 'Name'           =>(string)$Title ,
						 'Type_ID'         =>(int)4,
				         'Is_Active '      =>1,
				         'Test_ID'          =>$Insert_ID
					  );
		           $Insert_2   =  $this->db->insert('send_box', $add_2);
		           add_notification($this->db->insert_id(),4,$RowLevelID,$SubjectID,0);
		
		if($Insert_1 && $Insert_2)
		{
			
			return TRUE ;	    
		} 
		else 
		{
			return FALSE;	
		}
	} // Add End

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	// get Lessons Titles
	public function get_lessons_prep($data)
	{
		$RowLevelID 	= $data['RowLevelID'] ;
		$SubjectID 		= $data['SubjectID'] ;
		$TeacherID  	= $this->session->userdata('id');
		
		$this->db->select('lesson_prep.ID AS LessonID, lesson_prep.Lesson_Title AS LessonTitle ,lesson_prep.Date AS LessonDate , lesson_prep.Token AS LessonToken');
		$this->db->from('lesson_prep');
		$this->db->where('lesson_prep.RowLevel_ID', $RowLevelID );
		$this->db->where('lesson_prep.Subject_ID', $SubjectID );
		$this->db->where('lesson_prep.Teacher_ID', $TeacherID );	
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

	// get Lesson Details
	public function get_lesson_details($LessonToken)
	{
	 	$this->db->select('*');
		$this->db->from('lesson_prep');
		$this->db->where('Token', $LessonToken );
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
	 	$this->db->select('');
		$this->db->from('lesson_prep');
		$this->db->where('Token', $LessonToken );
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
	public function lesson_prep_del($LessonToken)
	{
	 	$this->db->delete('lesson_prep', array('Token' => $LessonToken));
		return TRUE ;
	}
	
	// Update Lesson Prep
	public function update_lesson_prep ($data)
	{	
		// Update 2 [Aims Txt]
					$num_Aims     = $this->input->post('num_Aims');			
					$count  = 1 ; 
					$AimsArray = array();
					while($count < $num_Aims)
						 {
							 $txt_Aims = 'txt_Aims'.$count;
							 $txt_Aims = $this->input->post($txt_Aims);
							 $AimsArray[] =  $txt_Aims ; 
							 $count ++;
						 } /// Aims Txt While End
		 			$ImploadAims = implode(',',$AimsArray);
		
		// Update 3 [Aids Txt]
					$num_Aids     = $this->input->post('num_Aids');			
					$count2  = 1 ;
					$AidsArray = array(); 
					while($count2 < $num_Aids)
						 {
							 $txt_Aids = 'txt_Aids'.$count2;
							 $txt_Aids = $this->input->post($txt_Aids);
							 $AidsArray[] =  $txt_Aids ;
							 $count2 ++;
						 } /// Aids Txt While End
					$ImploadAids = implode(',',$AidsArray);

		// Update 6 [Reviews Txt]
					$num_Reviews   = $this->input->post('num_Reviews');			
					$count3  = 1 ; 
					$ReviewsArray = array(); 
					while($count3 < $num_Reviews)
						 {
							 $txt_Reviews = 'txt_Reviews'.$count3;
							 $txt_Reviews = $this->input->post($txt_Reviews);
							 $ReviewsArray[] =  $txt_Reviews ;
							 $count3 ++;
						 } /// Reviews Txt While End
				  	$ImploadReviews = implode(',',$ReviewsArray);				 
								
		// Update 7 [Scripts Txt]
					$num_Scripts   = $this->input->post('num_Scripts');			
					$count4  = 1 ; 
					$ScriptsArray = array(); 
					while($count4 < $num_Scripts)
						 {
							 $txt_Scripts = 'txt_Script'.$count4;
							 $txt_Scripts = $this->input->post($txt_Scripts);
							 $ScriptsArray[] =  $txt_Scripts ;
							 $count4 ++;
						 } /// Scripts Txt While End
				  	$ImploadScripts = implode(',',$ScriptsArray);
		
		// Update 1
		$Title 		         = $this->input->post('lessonTitle') ;
		$Stratigy 		     = $this->input->post('lessonStratigy') ;
		$Intro 	 			 = $this->input->post('lessonIntro');
		$Content 			 = $this->input->post('lessonContent');
		$TrainHome 			 = $this->input->post('trainhome');
		$LessonToken 		 = $this->input->post('LessonToken');
		$image 				 = $this->input->post('hidImg'); 
		
		$add_1 = array(
						 'Lesson_Title'           =>(string)$Title ,
						 'stratigy'           	  =>(string)$Stratigy ,
						 'Aims'					  =>(string)$ImploadAims ,
						 'Aids'					  =>(string)$ImploadAids ,
						 'Intro'				  =>(string)$Intro ,
						 'Content'				  =>(string)$Content ,
						 'Reviews'				  =>(string)$ImploadReviews ,
						 'trainhome'			  =>(string)$TrainHome ,
						 'Attachs'				  =>(string)$image ,
						 'Scripts'				  =>(string)$ImploadScripts ,
					  );

////print_r($add_1 ) ; echo '<br>===='.$LessonToken; exit();
				    $this->db->where('Token', $LessonToken);
		$Update_1=  $this->db->update('lesson_prep', $add_1); 
					
		
		if($Update_1)
		{
			return TRUE ;	    
		} 
		else 
		{
			return FALSE;	
		}
	} // Update End

	// Get Lessons 2 Students
	public function get_student_lessons ($data)
	{	
		$RowLevelID 	= $data['RowLevelID'] ;
		$SubjectID 		= $data['SubjectID'] ;
		$SemesterID     = $data['SemesterID'] ;
		$date           =date('Y-m-d',strtotime($data['date']));
		$idContact = (int)$this->session->userdata('id'); 
		$this->db->select('Class_ID');
		$this->db->from('student');	
		$this->db->where('Contact_ID',$idContact);
		$ResultExam = $this->db->get();	

		$ReturnExam     = $ResultExam ->row_array() ;
		$Class_ID       = $ReturnExam['Class_ID'];
		
		$this->db->select('lesson_prep.ID AS LessonID, lesson_prep.Lesson_Title AS LessonTitle ,lesson_prep.startDate AS LessonDate , lesson_prep.Token AS LessonToken,
		lesson_prep.date_from,lesson_prep.date_to,contact.Name as teacher ,subject.Name as Subject_Name ');
		$this->db->from('lesson_prep');
		$this->db->join('class_table', ' lesson_prep.RowLevel_ID=class_table.RowLevelID  and  lesson_prep.Subject_ID=class_table.SubjectID	 and lesson_prep.Teacher_ID=class_table.EmpID AND FIND_IN_SET(class_table.ClassID,lesson_prep.ClassId) ', 'INNER');
		$this->db->join('contact', ' lesson_prep.Teacher_ID=contact.ID and class_table.EmpID = contact.ID','INNER'); 
		$this->db->join("config_semester","config_semester.ID=$SemesterID AND lesson_prep.date_from  BETWEEN config_semester.start_date AND config_semester.end_date ");
	    $this->db->join('subject', ' lesson_prep.Subject_ID= subject.ID','INNER'); 
		$this->db->where('lesson_prep.RowLevel_ID', $RowLevelID );
		$this->db->where('lesson_prep.Subject_ID', $SubjectID );
		$this->db->where('lesson_prep.School_ID', (int)$this->session->userdata('SchoolID'));
		$this->db->where("lesson_prep.Subject_ID=class_table.SubjectID AND FIND_IN_SET($Class_ID,lesson_prep.classID) "  ); 
		$this->db->where("class_table.ClassID = $Class_ID");
		$this->db->group_by('lesson_prep.ID');
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
			  return 0 ;
			  return false ;
		  }
	}
	
	public function get_more_lessons($data)
	{	
		$RowLevelID 	= $data['RowLevelID'] ;
		$SubjectID 		= $data['SubjectID'] ;
		$start          = $data['start'] ;
		
		$this->db->select('lesson_prep.ID AS LessonID, lesson_prep.Lesson_Title AS LessonTitle ,lesson_prep.Date AS LessonDate , lesson_prep.Token AS LessonToken , Subject_ID ');
		$this->db->from('lesson_prep');
		$this->db->where('RowLevel_ID', $RowLevelID );
		$this->db->where('Subject_ID', $SubjectID );
		$this->db->where('startDate <=CURDATE() '  ); 
		$this->db->order_by('ID','DESC');
		if($start > 0 ){
		    $this->db->limit('12' , $start - 1 );
		}else{
		    $this->db->limit('12','0');
		    
		}
		
		$ResultLessons = $this->db->get();			
		$NumRowResultLessons  = $ResultLessons->num_rows() ; 
 		if($NumRowResultLessons != 0)
		  {
				$ReturnLessons = $ResultLessons ->result() ;
				return $ReturnLessons ;
		  }
		  else
		  {
			  return 0;
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
		public function get_student_class ($idContact)
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


	
 }//End Class