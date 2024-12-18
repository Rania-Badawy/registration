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
	public function get_clerical_homework_header($rowlevelid  ,$SubjectID)
	{
		$idContact = (int)$this->session->userdata('id'); 
		$this->db->select('lesson_prep.Lesson_Title , homework.subjectEmpID,homework.ID,homework.title,homework.content,homework.attach,homework.date_homework,homework.token,contact.Name as emp,subject.Name as subject');
		$this->db->from('clerical_homework as homework');
		$this->db->join('config_emp','homework.subjectEmpID = config_emp.ID');
		$this->db->join('lesson_prep','homework.lessonID = lesson_prep.ID','left');
		$this->db->join('contact','config_emp.EmpID = contact.ID');
		$this->db->join('subject','subject.ID = config_emp.SubjectID');
		$this->db->where('config_emp.EmpID',$idContact);
		$this->db->where('config_emp.RowLevelID',$rowlevelid);
		$this->db->where('config_emp.SubjectID',$SubjectID);
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
	//edit_clerical_homework
	public function edit_clerical_homework($id)
	{
		$idContact = (int)$this->session->userdata('id'); 
		$this->db->select('homework.lessonID, homework.ID as homework_id,homework.classID as homework_classID,homework.subjectEmpID as home_subjectEmpID,homework.title,homework.content,homework.attach,homework.date_homework,homework.token,contact.Name as emp,subject.Name as subject');
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
	//get_class_check
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
	//add_homework
	public function add_homework($data = array())
	{
		
		 $idContact = (int)$this->session->userdata('id'); 
		 extract($data);
		 $this->db->escape_str($txt_title);
		 $this->db->escape_str($txt_content);
		 $token =$this->get_token();
		foreach( $Select_class as $item )
		{
		$DataInsert = array
			 ( 
				'date_homework'   =>$txt_Date ,
			    'subjectEmpID'    =>$slct_subject, 
			    'classID'         =>$item,
				'title'           =>$txt_title, 
				'content'         =>$txt_content, 
				'attach'          =>$hidImg, 
				'yearID'          => $this->session->userdata('YearID'), 
				'token'           => $token ,
				'lessonID'        => $lessonsTitles
			);
		$this->db->insert('clerical_homework', $DataInsert);

				 add_notification(  $this->db->insert_id(),10,0,0,0 ,0);
		}
					return true ; 
	}
	//edit_homework
	public function edit_homework($data = array())
	{
		
		 $idContact = (int)$this->session->userdata('id'); 
		 extract($data);
		 $query = $this->db->query(" delete    FROM   clerical_homework where token ='".$token."' "); 
		 $this->db->escape_str($txt_title);
		 $this->db->escape_str($txt_content);$token2=$token;
		 $token =$this->get_token();
		 $insert_id =0;
		foreach( $Select_class as $item )
		{
		if($hidImg!=0){
		$DataInsert = array
			 ( 
				'date_homework'   =>$txt_Date ,
			    'subjectEmpID'    =>$slct_subject, 
			    'classID'         =>$item,
				'title'           =>$txt_title, 
				'content'         =>$txt_content, 
				'attach'          =>$hidImg, 
				'yearID'          =>$this->session->userdata('YearID'), 
				'token'           =>$token,
				'lessonID'        => $lessonsTitles
			);
		 $this->db->insert('clerical_homework', $DataInsert);
		 $insert_id = $this->db->insert_id();
		}else{
		$DataInsert = array
			 ( 
				'date_homework'   =>$txt_Date ,
			    'subjectEmpID'    =>$slct_subject, 
			    'classID'         =>$item,
				'title'           =>$txt_title, 
				'content'         =>$txt_content, 
				'yearID'          => $this->session->userdata('YearID'), 
				'token'           =>$token,
				'lessonID'        => $lessonsTitles
			);
 		 $this->db->insert('clerical_homework', $DataInsert);
		 $insert_id = $this->db->insert_id();
			
			}
		}
					return $insert_id ; 
	}
	//delete_homework
	public function delete_homework($id)
	{
	 	if($this->db->delete('clerical_homework', array('ID' => (int)$id))){ 	return true ; }else{	return false ; }	
	}
 }
?>