<?php
class Model_answer_Model extends CI_Model{
	function __construct()
    {
	   parent::__construct();
	   $this->Date       = date('Y-m-d H:i:s');
	   $this->Encryptkey = $this->config->item('encryption_key');
    }
 //get_answers
	 public function get_answers($questions_ID)
	 {
		$this->db->select('Answer_ID,Answer,Answer_correct,answers_IsActive,answers_Token,answers_Date_Stm,questions_content_ID');
		$this->db->from('vw_test_question_select');	
		$this->db->where('questions_content_ID',(int)$questions_ID);
		$this->db->order_by('questions_types_ID', "desc");
		$ResultExam = $this->db->get();			
		$NumRowResultExam = $ResultExam->num_rows() ; 
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->result() ;
			   return $ReturnExam ; 
			  }else{return $NumRowResultExam ;return FALSE ;}
	}
 //get_student_answer
	 public function get_student_answer($questions_ID)
	 {
		$idContact = (int)$this->session->userdata('id'); 
		$this->db->select('answer_content,Degree as student_Degree');
		$this->db->from('test_student');	
		$this->db->where('Contact_ID',$idContact);
		$this->db->where('questions_content_ID',$questions_ID);
		$this->db->where('IsActive',1);
		$this->db->order_by('Date_Stm');
		$ResultExam = $this->db->get();			
		$NumRowResultExam = $ResultExam->num_rows() ; 
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->row_array() ;
			    return $ReturnExam ; 
			  }else{return $NumRowResultExam ;return FALSE ;}
	}
 //get_questions
	 public function get_questions($testID)
	 {
		$this->db->select('questions_content.ID ,questions_content.Degree,questions_content.Question,questions_content.Q_image,questions_content.Q_video,questions_content.Q_sound,questions_content.questions_types_ID as type_question');
		$this->db->from('test_questions');
		$this->db->join('questions_content','questions_content.ID = test_questions.Questions_ID');	
		$this->db->where('test_questions.Test_ID',$testID);
		$this->db->where('questions_content.IsActive',1);
		$this->db->order_by('questions_content.questions_types_ID', "desc");
		$ResultExam = $this->db->get();			
		$NumRowResultExam = $ResultExam->num_rows() ; 
			if($NumRowResultExam >0)
			  {
				$ReturnExam     = $ResultExam ->result() ;
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{return $NumRowResultExam ;return FALSE ;}
	}
 //get_exam_no_rpt
	 public function get_exam_no_rpt($testID)
	 {					
		$this->db->select('ID,type,Name,Description,time_count');
		$this->db->from('test');	
		$this->db->where('ID',$testID);
		$ResultExam = $this->db->get();			
		$NumRowResultExam = $ResultExam->num_rows() ; 
			if($NumRowResultExam >0)
			  {
			    $ReturnExam     = $ResultExam ->row_array() ;
			    return $ReturnExam ; 
			  }else{
				  return $NumRowResultExam ;return FALSE ;
				  }
	}
 }
?>