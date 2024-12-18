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
	   $this->Token        = $this->get_token();
    }
	////////get_token
	private function get_token()
	{
	   $this->Token            = md5($this->Encryptkey.uniqid(mt_rand()).microtime()) ;
	   return	$this->Token ; 
	}
	/////////////////////////////////////////////////////////
	public function get_config_header($data=array())
	{
	    extract($data);
			$data['SchoolID']             = (int)$this->session->userdata('SchoolID');
			$TeacherID  	              = $this->session->userdata('id');
			
 					  if($Lang=="english"){
						  $this->db->select('lesson_prep.Lesson_Title as titleLesson,row.Name_en as row,level.Name_en as level,subject.Name as subject,ask_teacher.mail_address,ask_teacher.name,ask_teacher.title,ask_teacher.content,ask_teacher.Date,ask_teacher.studentID,ask_teacher.ID,ask_teacher.answer,ask_teacher.isactive,ask_teacher.Date as inserted_date');
					  }else{
						  $this->db->select('lesson_prep.Lesson_Title as titleLesson,row.Name as row,level.Name as level,subject.Name as subject,ask_teacher.mail_address,ask_teacher.name,ask_teacher.title,ask_teacher.content,ask_teacher.Date,ask_teacher.studentID,ask_teacher.ID,ask_teacher.answer,ask_teacher.isactive,ask_teacher.Date as inserted_date');	
					  }
					 $Where  = array('subject.ID'=>$SubID,'class_table.RowLevelID'=>$rowlevelid , 'contact.SchoolID'=>$data['SchoolID'], 
					 'class_table.EmpID'=>$TeacherID ,'student.R_L_ID'=>$rowlevelid , 'subject.ID'=>$SubID , 'lesson_prep.Teacher_ID'=>$TeacherID );
 
					  $this->db->from('ask_teacher');
		     	  	  $this->db->join('config_subject','config_subject.ID = ask_teacher.config_subjectID');
		     	  	  $this->db->join('student','student.Contact_ID = ask_teacher.studentID');
		     	  	  $this->db->join('class_table','student.Class_ID=class_table.ClassID');
		     	  	  $this->db->join('contact','contact.ID = ask_teacher.studentID');
		     	  	  
		     	  	  $this->db->join('lesson_prep','lesson_prep.ID= ask_teacher.lessonID','left');
		     	  	  $this->db->join('row_level','row_level.ID = class_table.RowLevelID');
		     	  	  $this->db->join('row','row.ID = row_level.Row_ID');
		     	  	  $this->db->join('level','level.ID = row_level.Level_ID');
		     	  	  $this->db->join('class','class.ID = class_table.ClassID');
					  $this->db->join('subject','subject.ID = class_table.SubjectID and subject.ID =config_subject.SubjectID ');
					 $this->db->join("config_semester","config_semester.ID=$SemesterID AND ask_teacher.Date  BETWEEN config_semester.start_date AND config_semester.end_date ");
					 
					  $this->db->where($Where); 
					  $this->db->group_by("ask_teacher.ID" ); 
					  $this->db->order_by("ask_teacher.Date", "desc"); 
					  $query = $this->db->get();	
 					  if($query->num_rows() >0)
					  {	
						return $query->result() ;
 						 
						}else{
							return 0 ;  
						}
	}
		//////////////////////////////////////
	public function get_student_name($UID)
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
        /////////////////////////////////////
    public function disable_ask($id)
    { 
				 $DataInsert = array
				 ( 
				  'isactive' =>0 
				);
				$this->db->where('ID',$id);
				if($this->db->update('ask_teacher', $DataInsert))
					{			
						return true ;  
					}else{
						return false ;  
						}
	}
	//////////////////////////////////
	public function enable_ask($id)
	{ 
				 $DataInsert = array
				 ( 
				  'isactive' =>1 
				);
				$this->db->where('ID',$id);
				if($this->db->update('ask_teacher', $DataInsert))
					{			
						return true ;  
					}else{
						return false ;  
						}
	}
	////////////////////////////////////////////
	public function addAnswer($data = array())
	{
		         extract($data);
				 $this->db->escape_str($txt_answer);
				 $DataInsert = array
				 ( 
				  'answer'      =>$txt_answer ,
				  'teacherID'   =>$UID ,
				  'isactive'    =>1 
				);
				$this->db->where('ID',$ask_id);
				if($this->db->update('ask_teacher', $DataInsert))
					{		
	
						return true ;  
					}else{
						return false ;  
						}
	}
	/////////////////////////////////// end 
	public function get_config($UID ,$lang)
	{
		
			$data['SchoolID']             = (int)$this->session->userdata('SchoolID');
		      $this->db->select('*');	
		      $Where  = array('EmpID'=>$UID);
		      $this->db->from('config_emp');
		      $this->db->where($Where); 
			  $query = $this->db->get();			
			  if($query->num_rows() >0)
			  {	
			  	$ReturnResult = $query->result() ;
				}else{
					return 0 ;  
				}
				
				$Result=array();
				$count=0;
				foreach($ReturnResult as $key=>$item){
					  $SubjectID  = $item->SubjectID;
					  $RowLevelID = $item->RowLevelID;
					  if($lang=="english"){
						  $this->db->select('lesson_prep.Lesson_Title as titleLesson,row.Name_en as row,level.Name_en as level,subject.Name as subject,ask_teacher.mail_address,ask_teacher.name,ask_teacher.title,ask_teacher.content,ask_teacher.Date,ask_teacher.studentID,ask_teacher.ID,ask_teacher.answer,ask_teacher.isactive');
					  }else{
						  $this->db->select('lesson_prep.Lesson_Title as titleLesson,row.Name as row,level.Name as level,subject.Name as subject,ask_teacher.mail_address,ask_teacher.name,ask_teacher.title,ask_teacher.content,ask_teacher.Date,ask_teacher.studentID,ask_teacher.ID,ask_teacher.answer,ask_teacher.isactive');	
					  }
					  $Where  = array('SubjectID'=>$SubjectID,'RowLevelID'=>$RowLevelID , 'contact.SchoolID'=>$data['SchoolID'] 
);
					  $this->db->from('config_subject');
		     	  	  $this->db->join('ask_teacher','ask_teacher.config_subjectID = config_subject.ID');
		     	  	  $this->db->join('contact','contact.ID = ask_teacher.studentID');
 		     	  	  $this->db->join('row_level','row_level.ID = config_subject.RowLevelID');
		     	  	  $this->db->join('row','row.ID = row_level.Row_ID');
		     	  	  $this->db->join('level','level.ID = row_level.Level_ID');
					  $this->db->join('subject','subject.ID = config_subject.SubjectID');
					  $this->db->join('lesson_prep','lesson_prep.ID= ask_teacher.lessonID','left');
					  $this->db->where($Where); 
					  $this->db->order_by("ask_teacher.Date", "desc"); 
					  $this->db->group_by("ask_teacher.ID" ); 
					  $query = $this->db->get();			
					  if($query->num_rows() >0)
					  {	
						$Result[$key] = $query->result() ;
						$count++;
						 
						}
					}
					if($count!=0){
						return $Result;  
					}else{
							return 0 ;  
						}
	}

	

	
	

 }/////////END CLSS 
?>