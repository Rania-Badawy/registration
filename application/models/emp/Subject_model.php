<?php
class Subject_Model  extends CI_Model 
 {
 //get_subjects for emp By contact_id
	 public function get_Subjects_emp()
	 {
		$idContact = (int)$this->session->userdata('id');				
		$this->db->select('config_emp.ID AS subject_ID,config_emp.ID AS SubEmpID, subject.Name AS subject_Name ,row.Name  AS row_Name ,level.Name  AS level_Name ');
		$this->db->from('class_table');
		$this->db->join('config_emp', 'config_emp.RowLevelID = class_table.RowLevelID and config_emp.EmpID = class_table.EmpID and  config_emp.SubjectID = class_table.SubjectID', 'left');
		$this->db->join('subject', 'config_emp.SubjectID =subject.ID', 'INNER');
		$this->db->join('row_level', 'config_emp.RowLevelID =row_level.ID', 'INNER');
		$this->db->join('row', 'row_level.Row_ID =row.ID', 'INNER');
		$this->db->join('level', 'row_level.Level_ID =level.ID', 'INNER');
		
		$this->db->where('config_emp.EmpID',$idContact);
		$this->db->group_by('config_emp.ID');
		$ResultSubjectEmp = $this->db->get();	 
		$NumRowResultSubjectEmp  = $ResultSubjectEmp->num_rows() ; 
		//print_r($this->db->last_query());exit();
			if($NumRowResultSubjectEmp >0)
			  {
				$ReturnSubjectEmpEdit     = $ResultSubjectEmp ->result() ;
			   return $ReturnSubjectEmpEdit ; 
			   
			   return TRUE ; 
							 
			  }else{return FALSE ;}
	}
	public function get_Subjects_emp1($rowlevelid,$SubjectID)
	 {
		$idContact = (int)$this->session->userdata('id');				
		$this->db->select('config_emp.ID AS subject_ID,config_emp.ID AS SubEmpID, subject.Name AS subject_Name ,row.Name  AS row_Name ,level.Name  AS level_Name ,row_level.ID AS R_L_ID,subject.ID AS Sub_ID');
		$this->db->from('class_table');
		$this->db->join('config_emp', 'config_emp.RowLevelID = class_table.RowLevelID and config_emp.EmpID = class_table.EmpID and  config_emp.SubjectID = class_table.SubjectID', 'left');
		$this->db->join('subject', 'config_emp.SubjectID =subject.ID', 'INNER');
		$this->db->join('row_level', 'config_emp.RowLevelID =row_level.ID', 'INNER');
		$this->db->join('row', 'row_level.Row_ID =row.ID', 'INNER');
		$this->db->join('level', 'row_level.Level_ID =level.ID', 'INNER');
		$this->db->where('row_level.ID',$rowlevelid);
		$this->db->where('subject.ID',$SubjectID);
		$this->db->where('config_emp.EmpID',$idContact);
		$this->db->group_by('config_emp.SubjectID');
		$this->db->group_by('config_emp.RowLevelID');
		$ResultSubjectEmp = $this->db->get();	 
		$NumRowResultSubjectEmp  = $ResultSubjectEmp->num_rows() ; 
		//print_r($this->db->last_query());exit();
			if($NumRowResultSubjectEmp >0)
			  {
				$ReturnSubjectEmpEdit     = $ResultSubjectEmp ->result() ;
			   return $ReturnSubjectEmpEdit ; 
			   
			   return TRUE ; 
							 
			  }else{return FALSE ;}
	}
 }
?>