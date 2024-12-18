<?php
class Ask_Teacher_Model extends CI_Model 
 {
	private $data = array() ;
	private $ID         = 0 ; 
	private $levelID    = 0 ;
	private $Token       = '' ;	
	
	function __construct()
    {
	   parent::__construct();
	   $this->Encryptkey   = $this->config->item('encryption_key');
	   $this->data['Lang'] = $this->session->userdata('language');
	   $this->Token      = $this->get_token();
    }
	////////get_token
	private function get_token()
	{
	   $this->Token            = md5($this->Encryptkey.uniqid(mt_rand()).microtime()) ;
	   return	$this->Token ; 
	}
	///////////////////////////////
	public function get_subjects($UID ,$lang,$SubjectID)
	{
		$data['SchoolID']             = (int)$this->session->userdata('SchoolID');
			  $this->db->select('Class_ID,R_L_ID');	
		      $Where  = array('Contact_ID'=>$UID  );
		      $this->db->from('student');
		      $this->db->where($Where); 
			  $query = $this->db->get();	
			  if($query->num_rows() >0)
			  {	
			  	$ReturnResult = $query->row_array() ;
				$Class_ID = $ReturnResult['Class_ID'];
				$R_L_ID   = $ReturnResult['R_L_ID'];
			    $this->db->select('subject.Name as subject,class_table.RowLevelID,config_subject.ID as config_subjectID,subject.ID as SubjectID ');	
		        $Where  = array('class_table.RowLevelID'=>$R_L_ID,'class_table.ClassID'=>$Class_ID,'class_table.SchoolID'=>$data['SchoolID'],'class_table.SubjectID'=>$SubjectID );
		        $this->db->from('class_table');
		        $this->db->join('row_level','class_table.RowLevelID = row_level.ID');
				$this->db->join('row','row.ID = row_level.Row_ID');
		        $this->db->join('subject','class_table.SubjectID = subject.ID');
		        $this->db->join('config_subject','config_subject.SubjectID = subject.ID and config_subject.RowLevelID =class_table.RowLevelID');
			   $this->db->group_by('config_subject.ID'); 
		        $this->db->where($Where); 
			    $query = $this->db->get();			
			    if($query->num_rows() >0)
			     {	
			  		$ReturnResult = $query->result() ;
					return $ReturnResult;
			     }
				  }else{	
					return 0 ;  
				 }
	}
	//////////////////////////
	public function get_config_header($data=array())
	{
	    extract($data);
			  $this->db->select('lesson_prep.Lesson_Title as titleLesson, lesson_prep.Teacher_ID      ,subject.Name as subject,level.Name as level,row.Name as row,ask_teacher.title,ask_teacher.content,
			  ask_teacher.answer,ask_teacher.teacherID,ask_teacher.mail_address,ask_teacher.name,ask_teacher.Date,ask_teacher.studentID,ask_teacher.ID,ask_teacher.isactive,config_subject.ID as config_subject_ID');	
		      $Where  = array('config_subject.RowLevelID'=>$RowLevelID,'ask_teacher.studentID'=>$UID ,'config_subject.SubjectID'=>$subject_id );
		      $this->db->from('config_subject');

		      $this->db->join('ask_teacher','config_subject.ID = ask_teacher.config_subjectID' );
		      $this->db->join('student','student.Contact_ID = ask_teacher.studentID' );
			  $this->db->join('lesson_prep','lesson_prep.ID= ask_teacher.lessonID','left');
		      $this->db->join('subject','subject.ID = config_subject.SubjectID');
		      $this->db->join('row_level','row_level.ID = config_subject.RowLevelID');
		      $this->db->join('level','level.ID = row_level.Level_ID');
		      $this->db->join('row','row.ID = row_level.Row_ID');
		      $this->db->join("config_semester","config_semester.ID=$SemesterID AND ask_teacher.Date  BETWEEN config_semester.start_date AND config_semester.end_date ");
		       $this->db->where("ask_teacher.isactive",1);
		      $this->db->where($Where);
		      $this->db->group_by ('ask_teacher.ID');
		      $this->db->order_by ('ask_teacher.Date DESC');
			  $query = $this->db->get();			
			  if($query->num_rows() >0)
			  {	
			  	$ReturnResult = $query->result() ;
				return $ReturnResult ;  
				}else{
					return 0 ;  
				}
	}
	///////////////////////////
	public function getLesson($Subject_ID , $SemesterID)
	{
	    $SchoolID  = $this->session->userdata('SchoolID');
	    
		$userID    = $this->session->userdata('id');
		
		$this->db->select('Class_ID,R_L_ID');	
		      $Where  = array('Contact_ID'=>$userID  );
		      $this->db->from('student');
		      $this->db->where($Where); 
			  $query = $this->db->get();	
			  if($query->num_rows() >0)
			  {	
			  	$ReturnResult = $query->row_array() ;
				$Class_ID = $ReturnResult['Class_ID'];
				$R_L_ID   = $ReturnResult['R_L_ID'];
			  }
		
		$emp_query = $this->db->query('
			SELECT `EmpID` 
			FROM `class_table` 
			WHERE `RowLevelID` = '.$R_L_ID.' 
			AND `ClassID`= '.$Class_ID.' 
			AND `SubjectID`= '.$Subject_ID.' 
			AND `SchoolID`= '.$SchoolID.'
			group by EmpID
		')->row_array();
		$TeacherID = $emp_query['EmpID'];
		$query = $this->db->query('
			select lesson_prep.Lesson_Title ask_teacher, lesson_prep.ID as lessonID , student.Class_ID from student
			INNER JOIN contact ON student.Contact_ID = contact.ID
			INNER JOIN lesson_prep ON student.R_L_ID = lesson_prep.RowLevel_ID
		    INNER JOIN config_semester on config_semester.ID='.$SemesterID.' AND lesson_prep.date_from  BETWEEN config_semester.start_date AND config_semester.end_date 
			WHERE lesson_prep.`RowLevel_ID` = '.$R_L_ID.' 
			AND lesson_prep.`Subject_ID` = '.$Subject_ID.' 
			AND FIND_IN_SET('.$Class_ID.',lesson_prep.`classID`)
			AND lesson_prep.School_ID = '.$SchoolID.'
			
			group by lesson_prep.ID
		');
		return $query->result();
	}
	/////////////////////////////////
	public function addAsk($data = array())
	{
		         extract($data);
				 $this->db->escape_str($txt_title);
				 $this->db->escape_str($txt_ques);
		         $SubjectID                     =(int) $this->session->userdata('SubjectID');
		        
				 $DataInsert = array
				 ( 
				  'config_subjectID' => $slctSubject ,
				  'studentID'        => $UID ,
				//   'title'            => $txt_title ,
				  'content'          => $txt_ques ,
				  'token'            => $this->Token,
				  'lessonID'         => $getLesson,
				  'isactive'         => 1,
				  'Date'             => $date,
				  'Inserted_By'      => $UID,
				  'Inserted_At'      => $date
				);
				$DataInsert1 = array
				 ( 
				  'Subject_ID'    => $slctSubject ,
				  'Stu_ID'        => $UID ,
				  'Name'          => $txt_ques ,
				  'Type_ID'       => (int)5,
				  'Is_Active '    => (int)1,
				  'DATE'          => $date
				);
				// print_r($DataInsert);die;
				$add=$this->db->insert('ask_teacher', $DataInsert);
				$add1=$this->db->insert('send_box', $DataInsert1);
				
				if($add && $add1)
					{	
				 add_notification( $this->db->insert_id(),9,0,0,0 ,$UID);		
						return true ;  
					}else{
						return false ;  
						}
	}
	///////////////////////
	public function get_teacher_name($UID)
	{
		 $this->db->select('Name');	
		 $this->db->from('contact');
		 $this->db->where('ID',$UID);
		 $query = $this->db->get();
		 if($query->num_rows()>0){
			 $Result = $query->row_array() ;
			 return $Result ;  
			}else{return 0;}   
	}
		///////////////////////
	public function get_teacher_ask_name($ask_ID)
	{
		$query = $this->db->query("SELECT contact.Name as contact_name FROM `ask_teacher` 
						              inner join student on ask_teacher.studentID=student.Contact_ID
						              inner join class_table on student.R_L_ID=class_table.RowLevelID and student.Class_ID=class_table.ClassID
						              inner join config_subject on config_subject.ID = ask_teacher.config_subjectID
						              inner join contact on contact.ID = class_table.EmpID 
						              inner join subject on subject.ID = class_table.SubjectID and subject.ID =config_subject.SubjectID
                                      WHERE ask_teacher.studentID='".$this->session->userdata('id')."' and ask_teacher.ID=$ask_ID
                                 ");
		 if($query->num_rows()>0){
			 $Result = $query->row_array() ;
			 return $Result['contact_name'] ;  
			}else{return 0;}   
	}
	///////////////////////
	public function add_watch($data)
	{
	    extract($data);
	    
	    $select = $this->db->query("SELECT `answer` FROM `ask_teacher` WHERE `ID` =  ".$id." ")->row_array();
	    
	    if($select['answer'] != "" || $select['answer'] != NULL ){

		$query = $this->db->query("UPDATE `ask_teacher` SET `watched`= 1  WHERE `ID` = ".$id." ");
		
        }
		return true;  
	}
 }/////////END CLSS 

?>