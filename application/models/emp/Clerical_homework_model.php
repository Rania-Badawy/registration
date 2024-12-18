<?php
class Clerical_Homework_Model extends CI_Model{
	 private $Contact_ID     = 0 ;
	 private $Name           = '' ;
	 private $Gender         = 0;
	 private $Mail           = '';
	 private $Address        = '';
	 private $Phone          = '';
	 private $Mobile         = '';
	 private $Number_ID      = '';
	 private $Nationality_ID = 0 ;
	 private $User_Name      = '';
	 private $Password       = '';
	 private $specialization = '';
	 private $BirhtDate      = '';
	 private $JobNow         = '';
	 private $TeacherLevel   = '';
	 private $TeacherDegree  = '';
	 private $Salary         = '';
	 private $ServiceStart   = '';
	 private $EmpType        = '';
	 private $ContractType   = '' ;
     private $ContractDate   = '';
	 private $note 			 = '';
     private $Date           = '' ;
	private $Encryptkey      = '' ;
	private $Token           = '' ;
	function __construct()
    {
	   parent::__construct();
	   $this->Date       = date('Y-m-d H:i:s');
	   $this->Encryptkey = $this->config->item('encryption_key');
	   $this->Token      = $this->get_token();
    }
	////////get_token
	private function get_token()
	{
	   $this->Token            = md5($this->Encryptkey.uniqid(mt_rand()).microtime()) ;
	   return	$this->Token ; 
	}
	///////////////////////////////////
	public function get_clerical_homework_header($data=array())
	{
	    extract($data);
		$idContact = (int)$this->session->userdata('id'); 
		$this->db->select('lesson_prep.Lesson_Title , homework.subjectEmpID,homework.ID,homework.title,homework.content,homework.attach,homework.date_from,homework.date_to,homework.classID,
		homework.date_homework,homework.token,contact.Name as emp,subject.Name as subject,reporter.Name as rep_name,homework.report_degree,homework.report_comment,homework.date_eval,homework.RowLevelID');
		$this->db->from('clerical_homework as homework');
		$this->db->join('lesson_prep','homework.lessonID = lesson_prep.ID','left');
		$this->db->join('contact','homework.Emp_ID = contact.ID');
		$this->db->join('contact as reporter','homework.reporter_id = reporter.ID','left');
		$this->db->join('subject','subject.ID = homework.Subject_ID');
		$this->db->join("config_semester","config_semester.ID=$SemesterID AND homework.date_from  BETWEEN config_semester.start_date AND config_semester.end_date ");
		$this->db->where('homework.Emp_ID',$idContact);
		$this->db->where('homework.RowLevelID',$rowlevelid);
		$this->db->where('homework.Subject_ID',$SubjectID);
		$this->db->where('homework.is_deleted',0);
		$this->db->where('homework.type',$type);
		$this->db->group_by('homework.token');
		$this->db->order_by('homework.Date','DESC');
 		$Result = $this->db->get();
		if($Result->num_rows()>0)
		{			
			$ReturnResult = $Result->result() ;
			return $ReturnResult ;  
		}else{
			return 0 ;  
		}	
	}
	//////////////////////////////////////////
	public function get_lessons_prep($data)
	{
	    extract($data);
		$TeacherID  	= $this->session->userdata('id');
		
		$this->db->select('lesson_prep.ID AS LessonID , lesson_prep.classID AS LessonclassID, lesson_prep.Lesson_Title AS LessonTitle ,lesson_prep.Date AS LessonDate , lesson_prep.Token AS LessonToken, 
		                  lesson_prep.RowLevel_ID ,lesson_prep.Subject_ID' );
		$this->db->from('lesson_prep');
		$this->db->join("config_semester","config_semester.ID=$SemesterID AND lesson_prep.date_from  BETWEEN config_semester.start_date AND config_semester.end_date ");
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
	//////////////////////////////////////
		public function get_Subjects_emp($rowlevelid,$SubjectID)
	 {
		$idContact = (int)$this->session->userdata('id');				
		$this->db->select('config_emp.ID AS subject_ID,config_emp.ID AS SubEmpID, subject.Name AS subject_Name ,row.Name  AS row_Name ,level.Name  AS level_Name ,row_level.ID AS R_L_ID,subject.ID AS Sub_ID');
		$this->db->from('class_table');
		$this->db->join('config_emp', 'config_emp.RowLevelID = class_table.RowLevelID and config_emp.EmpID = class_table.EmpID and  config_emp.SubjectID = class_table.SubjectID', 'left');
		$this->db->join('subject', 'class_table.SubjectID =subject.ID', 'INNER');
		$this->db->join('row_level', 'class_table.RowLevelID =row_level.ID', 'INNER');
		$this->db->join('row', 'row_level.Row_ID =row.ID', 'INNER');
		$this->db->join('level', 'row_level.Level_ID =level.ID', 'INNER');
		$this->db->where('row_level.ID',$rowlevelid);
		$this->db->where('subject.ID',$SubjectID);
		$this->db->where('class_table.EmpID',$idContact);
		$this->db->group_by('subject.ID');
		$this->db->group_by('row_level.ID');
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
	public function get_classes($rowlevelid,$SubjectID)
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
	/////////////////////////////////////////////
		public function edit_clerical_homework($id)
	{
	    
		$idContact = (int)$this->session->userdata('id'); 
		$this->db->select('homework.lessonID, homework.ID as homework_id,homework.classID as homework_classID,homework.subjectEmpID as home_subjectEmpID,homework.title,
		homework.Degree,homework.content,homework.attach,homework.date_homework,homework.token,contact.Name as emp,subject.Name as subject,homework.date_from,homework.date_to');
		$this->db->from('clerical_homework as homework');
		$this->db->join('config_emp','homework.subjectEmpID = config_emp.ID');
		$this->db->join('contact','config_emp.EmpID = contact.ID');
		$this->db->join('subject','subject.ID = config_emp.SubjectID');
		$this->db->where('config_emp.EmpID',$idContact);
		$this->db->where('homework.ID',(int)$id);
		$Result = $this->db->get();
		if($Result->num_rows()>0)
		{			
			$ReturnResult = $Result->row_array() ;
			return $ReturnResult ;  
		}else{
			return 0 ;  
		}	
	}
	/////////////////////////////////////////
		public function add_homework($data = array())
	{
		
		 $idContact            = (int)$this->session->userdata('id'); 
		 $School_id            = (int)$this->session->userdata('SchoolID');
		 extract($data);
		 $this->db->escape_str($txt_title);
		 $this->db->escape_str($txt_content);
		 $token =$this->get_token();
		$DataInsert = array
			 ( 
				'date_from'       => $from ,
				'date_to'         => $to ,
			    'subjectEmpID'    => $slct_subject, 
			    'classID'         => $Select_class ,
				'title'           => $txt_title, 
				'content'         => $txt_content, 
				'attach'          => $hidImg, 
				'yearID'          => $this->session->userdata('YearID'), 
				'token'           => $token ,
				'SchoolID'        => $School_id ,
				'lessonID'        => $lessonsTitles,
				'Emp_ID'          => $idContact,
				'Subject_ID'      => $SubjectID,
				'RowLevelID'      => $RowLevelID,
				'Degree'          => $degree,
				'Date'            => $date,
				'type'            => $type
			);
		
		$Insert_1   =  $this->db->insert('clerical_homework', $DataInsert);
	
    	$Insert_ID= $this->db->insert_id();
  	$DataInsert1 = array
			 ( 
				'date_from'       =>$from ,
			    'Subject_ID'      =>$SubjectID,
			    'R_L_ID'          =>$RowLevelID ,
			    'Class_ID'        =>$Select_class,
				'Name'            =>$txt_title,
				'Emp_ID'          =>$idContact,
				'Type_ID'         =>(int)4,
				'Is_Active '      =>1,
				'Test_ID'         =>$Insert_ID,
				'School_ID'       =>$School_id,
				'Degree'          =>$degree,
				'token '          =>$token,
				'DATE'            => $date
			);
			$Insert_2   =  $this->db->insert('send_box', $DataInsert1);
				
		if($Insert_1 && $Insert_2)
		{
			 add_notification(  $this->db->insert_id(),10,0,0,0 ,0);
			return TRUE ;	    
		} 
		else 
		{
			return FALSE;	
		}
		
					return true ; 
	}
	///////////////////////////////////
	public function edit_homework($data = array())
	{
	     extract($data);
		 $idContact = (int)$this->session->userdata('id'); 
		 $School_id = (int)$this->session->userdata('SchoolID');
		 $this->db->escape_str($txt_title);
		 $this->db->escape_str($txt_content);
		 $token =$this->get_token();
		 $insert_id =0;
		 
	if($homework_id){
		$DataInsert = array
			 ( 
				'date_from'       => $from ,
				'date_to'         => $to ,
			    'subjectEmpID'    =>$slct_subject, 
			    'classID'         =>$Select_class,
				'title'           =>$txt_title, 
				'content'         =>$txt_content, 
				'attach'          =>$hidImg, 
				'yearID'          =>$this->session->userdata('YearID'), 
				'token'           =>$token,
				'SchoolID'        =>$School_id ,
				'Emp_ID'          =>$idContact,
				'Subject_ID'      => $SubjectID,
				'RowLevelID'      =>$RowLevelID,
				'lessonID'        => $lessonsTitles,
				'Degree'          =>$degree,
				'Date'            => $date
				
			);
		$this->db->where('ID', $homework_id);
		 $this->db->update('clerical_homework', $DataInsert);
 		 $insert_id = $this->db->insert_id();
		 	$DataInsert1 = array
			 ( 
				
				'date_from'       =>$from ,
			    'Subject_ID'      =>$SubjectID,
			    'R_L_ID'          =>$RowLevelID,
			    'Class_ID'        =>$Select_class,
				'Name'            =>$txt_title,
				'Emp_ID'          =>$idContact,
				'Type_ID'         =>(int)4,
				'Is_Active '      =>1,
				'Test_ID'         =>$insert_id,
				'School_ID'       =>$School_id,
			    'Degree'          =>$degree,
			    'token '          =>$token,
			    'DATE'            => $date
			);
			$this->db->where('ID', $homework_id);
		 $this->db->update('send_box', $DataInsert1);
	}
						return $insert_id ; 
	}
	////////////////////////////////////////////
	public function student_answer_correct($ID,$show)
	{
		$Lang=$this->session->userdata('language');
	  if($show==1){
	      $where=" and (student_result IS NOT NULL and student_result!='') ";
	  }  
	  else{
	      $where=" and (student_result IS  NULL or student_result ='') ";
	  }
		$query=$this->db->query("SELECT CASE
								WHEN '$Lang' = 'english' and st.Name_en IS not NULL and st.Name_en !=' ' THEN st.Name_en
								ELSE st.Name
								END AS student_name,clerical_homework_answer.ID,clerical_homework_answer.answer,clerical_homework_answer.homework_id,
		                         clerical_homework_answer.attachment,clerical_homework_answer.date,clerical_homework_answer.student_result,clerical_homework.Degree as Degree,clerical_homework_answer.Note as Note ,class.Name as className
		                         FROM clerical_homework_answer
		                         INNER JOIN contact as st ON clerical_homework_answer.contact_idst =st.ID
                                 INNER JOIN student  ON student.Contact_ID =st.ID and st.Type='S' 
								  INNER JOIN class 	 ON student.Class_ID = class.ID
                                 INNER JOIN clerical_homework  ON clerical_homework_answer.homework_id  =clerical_homework.ID
	                             WHERE clerical_homework.ID =$ID  ".$where."
								 order by student_name asc  ")->result();
		return $query;
	}
///////////////////////////////////////////////////
   public function get_clerical_eva($ID)
    { 
       $query=$this->db->query("select report_degree,date_eval,report_comment,reporter_id from  clerical_homework where ID=$ID AND reporter_id !='NULL' ") ;
      if($query->num_rows()>0)
        {
            return $query->result();
        }else{return false ;}
    }
/////////////////////////////////////////////////////////////////rania
	//get_clerical_homework
	public function get_clerical_homework()
	{
		$idContact = (int)$this->session->userdata('id'); 
		$this->db->select('homework.ID,homework.title,homework.content,homework.attach,homework.date_homework,homework.token,contact.Name as emp,subject.Name as subject');
		$this->db->from('clerical_homework as homework');
		$this->db->join('config_emp','homework.subjectEmpID = config_emp.ID');
		$this->db->join('contact','config_emp.EmpID = contact.ID');
		$this->db->join('subject','subject.ID = config_emp.SubjectID');
		$this->db->where('config_emp.EmpID',$idContact);
		$this->db->order_by('homework.Date','DESC');
		$this->db->group_by('homework.ID');
		$this->db->group_by('homework.token');
		$Result = $this->db->get();
		if($Result->num_rows()>0)
		{			
			$ReturnResult = $Result->result() ;
			return $ReturnResult ;  
		}else{
			return 0 ;  
		}	
	}
	//get_clerical_homework

	//get_clerical_homework
	public function get_clerical_homework_details($rowlevelid  ,$SubjectID,$ClericalHomeworkID)
	{
		// $idContact = (int)$this->session->userdata('id'); 
		$this->db->select('lesson_prep.Lesson_Title , homework.subjectEmpID
		,homework.ID,homework.title,homework.content,homework.attach,homework.date_homework,
		homework.token,contact.Name as emp,subject.Name as subject');
		$this->db->from('clerical_homework as homework');
		$this->db->join('config_emp','homework.subjectEmpID = config_emp.ID');
		$this->db->join('lesson_prep','homework.lessonID = lesson_prep.ID','left');
		$this->db->join('contact','config_emp.EmpID = contact.ID');
		$this->db->join('subject','subject.ID = config_emp.SubjectID');
		// $this->db->where('config_emp.EmpID',$idContact);
		$this->db->where('homework.ID',$ClericalHomeworkID);
		// $this->db->where('config_emp.RowLevelID',$rowlevelid);
		// $this->db->where('config_emp.SubjectID',$SubjectID);
		$this->db->group_by( 'homework.token' );
		$this->db->order_by('homework.Date','DESC');
 		$Result = $this->db->get(); 		
		if($Result->num_rows()>0)
		{			
			$ReturnResult = $Result->result() ;
			return $ReturnResult ;  
		}else{
			return 0 ;  
		}	
	}
	//////////////////////////////////////

	public function edit_clerical_homework_details($id)
	{
		$this->db->select('group_concat(DISTINCT(class.Name)) as className, lesson_prep.Lesson_Title ,homework.lessonID, homework.ID as homework_id,
		homework.classID as homework_classID, homework.report_degree AS reportDegree, homework.report_comment AS reportComment,
		homework.subjectEmpID as home_subjectEmpID,homework.title,homework.content,homework.attach,homework.type,
		homework.date_homework,homework.token,contact.Name as emp,subject.Name as subject,homework.date_from,homework.date_to');
		$this->db->from('clerical_homework as homework');
		$this->db->join('lesson_prep','homework.lessonID = lesson_prep.ID','left');
		$this->db->join('class','homework.classID=homework.classID AND FIND_IN_SET(class.ID,homework.classID)','left');
		$this->db->join('contact','homework.Emp_ID = contact.ID');
		$this->db->join('subject','subject.ID = homework.Subject_ID');
		$this->db->where('homework.ID',(int)$id);
		$Result = $this->db->get();
		if($Result->num_rows()>0)
		{			
			$ReturnResult = $Result->row_array() ;
			return $ReturnResult ;  
		}else{
			return 0 ;  
		}	
	}
	/////////////////////////////////
	public function get_class_check($token)
	{
		$idContact = (int)$this->session->userdata('id'); 
		$this->db->select('  homework.classID as homework_classID  ');
		$this->db->from('clerical_homework as homework');
		$this->db->join('config_emp','homework.subjectEmpID = config_emp.ID');
		$this->db->join('contact','config_emp.EmpID = contact.ID');
		$this->db->join('subject','subject.ID = config_emp.SubjectID');
 		$this->db->where('homework.token',$token);
		$Result = $this->db->get();
		if($Result->num_rows()>0)
		{			
			$ReturnResult = $Result->result() ;
			return $ReturnResult ;  
		}else{
			return 0 ;  
		}	
	}
		public function get_class_homework($token)
	{
		$idContact = (int)$this->session->userdata('id'); 
		$this->db->select('class.ID,class.Name  ');
		$this->db->from('clerical_homework ');
		$this->db->join('class','clerical_homework.classID = class.ID');
		$this->db->where('clerical_homework.token',$token);
 		$this->db->where('clerical_homework.token',$token);
		$Result = $this->db->get();
		if($Result->num_rows()>0)
		{			
			$ReturnResult = $Result->result() ;
			return $ReturnResult ;  
		}else{
			return 0 ;  
		}	
	}
	//add_homework

	//delete_homework
	public function delete_homework($id, $type)
	{
	 	$this->db->query(" 
	    
	    update clerical_homework set is_deleted=1 where clerical_homework.ID = '".$id."' AND clerical_homework.type=$type
	    
	    ");
	    return true ; 
	}
	public function student_answer_model($ID)
	{
	     $data=$this->db->query("SELECT title FROM `clerical_homework` WHERE `ID`='".$ID."'")->result();
	     $data1=$this->db->query("SELECT ID FROM `clerical_homework` WHERE `title`='".$data[0]->title."' AND `subjectEmpID`='".$this->session->userdata('subjectEmpIDSession')."'")->result_array();
	  if($data1){
	  foreach($data1 as $dat) {
        $all[] = '\''.$dat['ID'].'\'';
    }
    $ids = implode(',',$all);
   }else{$ids=1;}
    $get_token=$this->db->query("select token from clerical_homework where ID=".$ID."")->row_array();
		$query=$this->db->query("
		SELECT 
		st.Name as student_name,
		fa.Name as father_name,
		clerical_homework_answer.ID,
		clerical_homework_answer.answer,
		clerical_homework_answer.homework_id,
		clerical_homework_answer.attachment,
		clerical_homework_answer.date,
		clerical_homework_answer.student_result,
		clerical_homework.Degree as Degree,
		clerical_homework_answer.Note as Note
		FROM clerical_homework_answer
		INNER JOIN contact as st ON clerical_homework_answer.contact_idst =st.ID
         INNER JOIN student  ON student.Contact_ID =st.ID and st.Type='S' 
        INNER JOIN contact as fa ON student.Father_ID  =fa.ID
         INNER JOIN clerical_homework  ON clerical_homework_answer.homework_id  =clerical_homework.ID
	WHERE clerical_homework.token ='".$get_token['token']."'
		
		")->result();
		return $query;
	}
		
	
	
	
    //////////////////////
    public function get_class_by_subject($Lang,$SubjectID,$rowlevelid)
	{
	  $Name = 'Name';
		if($Lang == 'english'){$Name = 'Name_en';}
		$query=$this->db->query("
		SELECT `class`.`ID` as `ClassID`, `class`.`Name` AS `className`
        FROM class_table 
        JOIN `row_level` ON `row_level`.`ID` =`class_table`.`RowLevelID` 
        JOIN `class` ON `class_table`.`ClassID` = `class`.`ID` 
        WHERE `row_level`.`ID` = ".$rowlevelid." AND class_table.SubjectID = ".$SubjectID."
        GROUP BY `class_table`.`ClassID`
		
		")->result();
		return $query;
	}
    //add_homework
	public function add_work_paper($data = array())
	{
		 $idContact            = (int)$this->session->userdata('id'); 
		 $School_id            = (int)$this->session->userdata('SchoolID');
		 extract($data);
		 $this->db->escape_str($txt_title);
		 $this->db->escape_str($txt_content);
		 $token =$this->get_token();
	
		$DataInsert = array
			 ( 
				'date_from'       => $from ,
				'date_to'         => $to,
			    'subjectEmpID'    => $slct_subject, 
			    'type'            => 1,
			    'classID'         => $Select_class ,
				'title'           => $txt_title, 
				'content'         => $txt_content, 
				'attach'          => $hidImg, 
				'yearID'          => $this->session->userdata('YearID'), 
				'token'           => $token ,
				'SchoolID'        => $School_id ,
				'lessonID'        => $lessonsTitles,
				'Emp_ID'          => $idContact,
				'Subject_ID'      => $SubjectID,
				'RowLevelID'      => $rowlevelid,
				'Degree'          => $degree,
				'Date'            => $date
			);
// 		print_r($DataInsert);die;
		$Insert_1   =  $this->db->insert('clerical_homework', $DataInsert);
		
		
    	$Insert_ID= $this->db->insert_id();
  	    $DataInsert1 = array
			 ( 
				'date_from'       =>$from ,
			    'Subject_ID'      =>$SubjectID,
			    'R_L_ID'          =>$rowlevelid ,
			    'Class_ID'        =>$Select_class,
				'Name'            =>$txt_title,
				'Emp_ID'          =>$idContact,
				'Type_ID'         =>(int)4,
				'Is_Active '      =>1,
				'Test_ID'         =>$Insert_ID,
				'School_ID'       =>$School_id,
				'Degree'          =>$degree,
				'token '          =>$token,
				'DATE'            => $date
			);
			$Insert_2   =  $this->db->insert('send_box', $DataInsert1);
				
		if($Insert_1 && $Insert_2)
		{
			 add_notification(  $this->db->insert_id(),10,0,0,0 ,0);
			return TRUE ;	    
		} 
		else 
		{
			return FALSE;	
		}
		
					return true ; 
	}
	//////////////////////////
	public function get_work_paper_header($rowlevelid  ,$SubjectID)
	{
		$idContact = (int)$this->session->userdata('id'); 
		$this->db->select('lesson_prep.Lesson_Title , homework.subjectEmpID,homework.classID,homework.ID,homework.title,homework.content,homework.attach,homework.date_from,homework.date_to,
		homework.date_homework,homework.token,contact.Name as emp,subject.Name as subject,reporter.Name as rep_name,homework.report_degree,homework.report_comment,homework.date_eval');
		$this->db->from('clerical_homework as homework');
		$this->db->join('lesson_prep','homework.lessonID = lesson_prep.ID','left');
		$this->db->join('contact','homework.Emp_ID = contact.ID');
		$this->db->join('contact as reporter','homework.reporter_id = reporter.ID','left');
		$this->db->join('subject','subject.ID = homework.Subject_ID');
		$this->db->where('homework.Emp_ID',$idContact);
		$this->db->where('homework.RowLevelID',$rowlevelid);
		$this->db->where('homework.Subject_ID',$SubjectID);
		$this->db->where('homework.is_deleted',0);
		$this->db->where('homework.type',1);
		$this->db->group_by('homework.ID');
		$this->db->order_by('homework.Date','DESC');
 		$Result = $this->db->get();
//  		PRINT_R($idContact);
//  		DIE();
		if($Result->num_rows()>0)
		{			
			$ReturnResult = $Result->result() ;
			return $ReturnResult ;  
		}else{
			return 0 ;  
		}	
	}
	////////////////////////////
	//edit_homework
	public function edit_work_paper($data = array())
	{
	     extract($data);
		 $idContact = (int)$this->session->userdata('id'); 
		 $School_id = (int)$this->session->userdata('SchoolID');
		 $this->db->escape_str($txt_title);
		 $this->db->escape_str($txt_content);
		 $token =$this->get_token();
		 $insert_id =0;

		$DataInsert = array
			 ( 
				'date_from'       => $from ,
				'date_to'         => $to ,
			    'subjectEmpID'    =>$slct_subject, 
			    'classID'         =>$Select_class,
			    'type'            => 1,
				'title'           =>$txt_title, 
				'content'         =>$txt_content, 
				'attach'          =>$hidImg, 
				'yearID'          =>$this->session->userdata('YearID'), 
				'token'           =>$token,
				'SchoolID'        =>$School_id ,
				'Emp_ID'          =>$idContact,
				'Subject_ID'      => $SubjectID,
				'RowLevelID'      => $rowlevelid,
				'lessonID'        => $lessonsTitles,
				'Degree'          =>$degree,
				'Date'            => $date
			);
		 $this->db->where('clerical_homework.ID',(int)$homework_id);
		 $this->db->update('clerical_homework', $DataInsert);
		 	$DataInsert1 = array
			 ( 
				
				'date_from'       =>$from ,
			    'Subject_ID'      =>$SubjectID,
			    'R_L_ID'          =>$rowlevelid,
			    'Class_ID'        =>$item,
				'Name'            =>$txt_title,
				'Emp_ID'          =>$idContact,
				'Type_ID'         =>(int)4,
				'Is_Active '      =>1,
				'Test_ID'         =>$homework_id,
				'School_ID'       =>$School_id,
			    'Degree'          =>$degree,
			    'token '          =>$token,
			    'DATE'            => $date
			);
		 $this->db->where('ID',(int)$homework_id);
		 $this->db->update('send_box', $DataInsert1);
		
	
		
						return TRUE ; 
	}
 }
?>