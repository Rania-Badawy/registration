<?php
class Clerical_Homework_Model extends CI_Model{
	function __construct()
	{
		parent::__construct();
		$this->Date       = date('Y-m-d H:i:s');
		$this->Encryptkey = $this->config->item('encryption_key');
	}
	//////////////////////////////////////
	public function get_homework_header($data)
	{
	    extract($data);
	    if($task){$where = "AND homework.ID = ".$homework_id." ";}
		    $idContact    = (int)$this->session->userdata('id'); 
		    $ReturnResult = $this->db->query("select Class_ID,R_L_ID from student where Contact_ID = $idContact ")->row_array();  
		    $Class_ID=$ReturnResult['Class_ID'];
		    $R_L_ID=$ReturnResult['R_L_ID'];
		    $Result=$this->db->query("select homework.ID,homework.title,homework.content,homework.attach,homework.date_homework,homework.token,subject.ID as subjectid,
		                                 subject.Name as subject,homework.date_from,homework.date_to,contact.Name as teacher
		                              from clerical_homework as homework
		                              
		                              inner join class_table on  class_table.RowLevelID=homework.RowLevelID 
		                              and class_table.SubjectID=homework.Subject_ID and FIND_IN_SET(class_table.ClassID,homework.classID)
		                              inner join contact on contact.ID =homework.Emp_ID and contact.ID = class_table.EmpID
		                              inner join subject on subject.ID = homework.Subject_ID
		                              inner join config_semester on config_semester.ID=$SemesterID AND homework.date_from  BETWEEN config_semester.start_date AND config_semester.end_date 
		                              where homework.Subject_ID = $subject_id
		                              and homework.RowLevelID = $R_L_ID
		                              and FIND_IN_SET($Class_ID,homework.classID)
		                              and homework.SchoolID = ".(int)$this->session->userdata('SchoolID')."
		                              and homework.is_deleted = 0
		                              and class_table.EmpID =homework.Emp_ID and FIND_IN_SET(class_table.ClassID,homework.classID)
		                              and homework.type = $type
		                              $where
		                              group by homework.ID
		                              order by homework.Date  DESC
		                           ");
			if($Result->num_rows()>0)
			{
				$ReturnResult = $Result->result() ;
				return $ReturnResult ;
			}else{
				return 0 ;
			}
	}
	///////////////////////////////////////////
	public function add_homework($data = array())
	{
	   
	   extract($data);
		 $homework       = $this->db->query("SELECT * FROM `clerical_homework` WHERE `ID` = $homework_id ")->row_array();
		 $idContact      = (int)$this->session->userdata('id'); 
		 $SchoolID	      = (int)$this->session->userdata('SchoolID') ;
		 $clerical = $this->clerical_homework_model->get_student_class($idContact);
		$exists = $this->db->query("select * from clerical_homework_answer where homework_id=$homework_id and contact_idst= $idContact")->row_array();
		$answer_id=$exists['ID'];
		
		if(empty($exists)) {
		    
			$DataInsert = array
			 ( 
				'homework_id'      => $homework_id,
				'answer'           => $answer, 
				'attachment'       => $Img, 
				'contact_idst'     => $idContact,
				'date'             => $date,
				'Inserted_By'      => $this->session->userdata('RedirectUser'),
				'Inserted_At'      => $date
			);
			$data_ins=	$this->db->insert('clerical_homework_answer', $DataInsert);
			if($homework['type']==0){
				$x=3; 
			}else{
				$x=4; 
			}
			$DataInsert1 = array
			 ( 
				'Test_ID'         => $homework_id,
			    'Name'            => $homework['title'],
				'Stu_ID'          => $idContact,
				'Type_ID'         => (int)$x,
				'Stu_Degree'      => 1,
				'Subject_ID'      => $homework['Subject_ID'],
				'DATE'            => $homework['date_homework'],
				'date_from'       => $homework['date_from'],
				'Date_to'         => $homework['date_to'],
				'School_ID '      => $SchoolID,
				'R_L_ID'          => $clerical['R_L_ID'],
				'Class_ID'        => $clerical['Class_ID'],
				'DATE'            => $date,
				
			);
			$data_ins1=	$this->db->insert('send_box_student', $DataInsert1);
			if($data_ins && $data_ins1){
			return true;}
	    	}else{
		    $DataInsert = array
			 ( 
				'homework_id'       => $homework_id,
				'answer'            => $answer, 
				'attachment'        => $Img, 
				'contact_idst'      => $idContact,
				'date'              => $date,
				'Updated_by'        => $this->session->userdata('RedirectUser'),
				'Updated_at'        => $date
			);
			$this->db->where('ID', $answer_id);
			$data_ins=	$this->db->update('clerical_homework_answer', $DataInsert);
		
			if($data_ins){
			return true;}}

	}
	/////////////////////////////////////
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

	public function get_homework()
	{
		$idContact = (int)$this->session->userdata('id');
	 
 			$this->db->select('homework.ID,homework.title,homework.content,config_emp.EmpID AS EmpID ,homework.attach,homework.date_from,homework.date_to,homework.date_homework,homework.token,contact.Name as emp,subject.Name as subject');
			$this->db->from('student');
            $this->db->join('class_table','class_table.ClassID = student.Class_ID and student.R_L_ID = class_table.RowLevelID');
			$this->db->join('config_emp' ,' class_table.EmpID = config_emp.EmpID  and config_emp.SubjectID = class_table.SubjectID  and config_emp.RowLevelID = class_table.RowLevelID');
			$this->db->join('clerical_homework as homework','homework.subjectEmpID = config_emp.ID and homework.classID = student.Class_ID');
			
			$this->db->join('base_class_table','base_class_table.ID = class_table.BaseTableID');
			$this->db->join('contact','class_table.EmpID = contact.ID');
 
		
		    $this->db->where('contact.SchoolID',(int)$this->session->userdata('SchoolID') );
			$this->db->join('subject','subject.ID = class_table.SubjectID');
 			$this->db->where('student.Contact_ID',$idContact);
		    $this->db->where('class_table.SchoolID', (int)$this->session->userdata('SchoolID'));
			$this->db->order_by('homework.Date','DESC');
			$this->db->group_by('homework.ID');
			$Result = $this->db->get();
			if($Result->num_rows()>0)
			{
				$ReturnResult = $Result->result() ;
				return $ReturnResult ;
			}else{
				return 0 ;
			}
		 
	}



	
}
?>