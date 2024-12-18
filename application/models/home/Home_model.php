<?php
class Home_Model extends CI_Model 
 {
	private $data = array() ;
	private $ID         = 0 ; 
	private $levelID    = 0 ;
	private $PollQToken = '' ;	
	
	function __construct()
    {
	   parent::__construct();
	   $this->Encryptkey   = $this->config->item('encryption_key');
	   $this->data['Lang'] = $this->session->userdata('language');
    }
     public function get_exam_reg()
	 {
		$idContact = (int)$this->session->userdata('id'); 
		$SchoolId  = $this->session->userdata('SchoolID'); 				
		$this->db->select('test.ID as test_ID , test.Name as test_Name, test.Description as test_Description, test.time_count,register_form.levelName,register_form.rowLevelName  ');
	    $this->db->from('test');	
        $this->db->join('student', 'FIND_IN_SET(test.RowLevelID, student.R_L_ID) > 0', 'INNER');
     	$this->db->join('register_form', 'register_form.rowLevelID =test.RowLevelID', 'left');	
		$this->db->group_by('test.ID');
		$this->db->where('test.IsActive',1);
		$this->db->where('test.type',4);
		$this->db->where('test.SchoolId',$SchoolId);
	 	$this->db->where('student.Contact_ID',$idContact);
		$this->db->where('(CURRENT_TIMESTAMP() BETWEEN test.date_from and test.date_to) or FIND_IN_SET('.$idContact.',test.num_student)');
 		$ResultExam = $this->db->get();	
		$NumRowResultExam = $ResultExam->num_rows() ; 
		
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->result() ;
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{return $NumRowResultExam ;return FALSE ;}
	}
 }/////////END CLSS 
?>
