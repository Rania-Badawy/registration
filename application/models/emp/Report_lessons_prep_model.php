<?php
class Report_Lessons_Prep_Model  extends CI_Model 
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
	{	
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

							 $vowels = array("https","http", ":",".com","embed", "/", "<", ">", "youtu", ".be", "www", "youtube", "watch?v=", "iframe", "src=", "allowfullscreen");
							 $txt_Scripts = str_replace($vowels, "", $full_Scripts);
							 
							 $ScriptsArray[] =  $txt_Scripts ;
							 $count4 ++;
						 } /// Scripts Txt While End
				  	$ImploadScripts = implode(',',$ScriptsArray);				 
					
		
		
		// Insert 1 [IDs + Title]
		$Select_subject      = $this->input->post('Select_subject');
		$Select_subject      = explode( '|' , $Select_subject );
		
		$TeacherID  		 = $this->session->userdata('id'); 
		$SubjectID           = $Select_subject[0];
		$RowLevelID          = $Select_subject[1];
		$Title 		         = $this->input->post('lessonTitle') ;
		$Intro 	 			 = $this->input->post('lessonIntro');
		$Content 			 = $this->input->post('lessonContent');
		(string)$this->Token = $this->create_token() ; 
		$image 				 = $data['img']; 
		
		$add_1 = array(
						 'Teacher_ID'             =>(int)$TeacherID  ,
						 'Subject_ID'  		      =>(int)$SubjectID  ,
						 'RowLevel_ID'  		  =>(int)$RowLevelID ,
						 'Lesson_Title'           =>(string)$Title ,
						 'Aims'					  =>(string)$ImploadAims ,
						 'Aids'					  =>(string)$ImploadAids ,
						 'Intro'				  =>(string)$Intro ,
						 'Content'				  =>(string)$Content ,
						 'Reviews'				  =>(string)$ImploadReviews ,
						 'Attachs'				  =>(string)$image ,
						 'Scripts'				  =>(string)$ImploadScripts ,
						 'Token'                  =>(string)$this->Token ,
						 'IsActive'               =>(int)1
					  );
		$Insert_1 =  $this->db->insert('lesson_prep', $add_1); 
		
		if($Insert_1)
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
	 	$this->db->select('');
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
		$Intro 	 			 = $this->input->post('lessonIntro');
		$Content 			 = $this->input->post('lessonContent');
		$LessonToken 		 = $this->input->post('LessonToken');
		$image 				 = $data['img'];
		
		$add_1 = array(
						 'Lesson_Title'           =>(string)$Title ,
						 'Aims'					  =>(string)$ImploadAims ,
						 'Aids'					  =>(string)$ImploadAids ,
						 'Intro'				  =>(string)$Intro ,
						 'Content'				  =>(string)$Content ,
						 'Reviews'				  =>(string)$ImploadReviews ,
						 'Attachs'				  =>(string)$image ,
						 'Scripts'				  =>(string)$ImploadScripts ,
					  );
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
		
		$this->db->select('lesson_prep.ID AS LessonID, lesson_prep.Lesson_Title AS LessonTitle ,lesson_prep.Date AS LessonDate , lesson_prep.Token AS LessonToken');
		$this->db->from('lesson_prep');
		$this->db->where('RowLevel_ID', $RowLevelID );
		$this->db->where('Subject_ID', $SubjectID );
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

	public function get_watch_report($dateFrom, $dateTo, $teacherID)
	{
		$dateFrom = strtotime($dateFrom);
		$dateTo = strtotime($dateTo);

		return $this->db->select('lesson_prep.Lesson_Title, teach.Name As teacher, contact.Name As student, lesson_report.watch_at')
						->join('lesson_report', 'lesson_report.lesson_id = lesson_prep.ID')
						->join('contact', 'contact.ID = lesson_report.student_id')
						->join('contact AS teach', 'teach.ID = lesson_prep.Teacher_ID')
						->where('lesson_report.watch_at > ', $dateFrom)
						->where('lesson_report.watch_at < ', $dateTo)
						->where(array('lesson_prep.Teacher_ID' => $teacherID))
						->get('lesson_prep')
						->result();
	}
	
	public function get_revision_report($dateFrom, $dateTo, $teacherID)
	{
		$dateFrom = strtotime($dateFrom);
		$dateTo = strtotime($dateTo);

		return $this->db->select('e_library.Title, e_library.ContactID, contact.Name As student, revision_report.watch_at')
						->join('revision_report', 'revision_report.lesson_id = e_library.lessonID')
						->join('contact', 'contact.ID = revision_report.student_id')
						->join('contact AS teach', 'teach.ID = e_library.ContactID')
						->where('revision_report.watch_at > ', $dateFrom)
						->where('revision_report.watch_at < ', $dateTo)
						->where(array('e_library.ContactID' => $teacherID))
						->get('e_library')
						->result();
	}
	
 }//End Class