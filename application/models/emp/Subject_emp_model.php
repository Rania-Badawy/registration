<?php
class Subject_Emp_Model  extends CI_Model 
 {
 //get_subjects for emp By contact_id
	 public function get_Subjects_emp()
	 {
		$this->db->select(' job_specializations.ID AS SubEmpID, job_specializations.Name AS subject_Name  ');
        $this->db->from('job_specializations');
       	$ResultSubjectEmp = $this->db->get();
        $NumRowResultSubjectEmp  = $ResultSubjectEmp->num_rows() ; 	
        if($NumRowResultSubjectEmp >0)
			  {
				return $ResultSubjectEmp ->result() ; 
			   
			   return TRUE ; 
							 
			  }else{return false ;}
	}
 } 
?>