<?php
class Report_Emp_Class_Model extends CI_Model{	
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
	//get_model_list
	public function get_row_level()
	 {
		$Lang = $this->session->userdata('language'); 
	    $data['SchoolID']             = (int)$this->session->userdata('SchoolID');
 		if((string)$Lang == 'english'){
        $query = $this->db->query("SELECT row_level.ID as row_level_ID ,CONCAT_WS(' ',row.Name_En, level.Name_En) as row_level_name FROM school_row_level
 inner join   `row_level` on  `row_level`.ID = school_row_level.RowLevelID
 inner join   `level` on  `level`.ID = row_level.`Level_ID`
 inner join   `row` on  `row`.ID = row_level.`Row_ID`
where school_row_level.SchoolID = ".$data['SchoolID']." and school_row_level.IsActive = 1
order by row_level.ID
")->result();
		}else{
        $query = $this->db->query("SELECT row_level.ID as row_level_ID ,CONCAT_WS(' ',row.Name, level.Name) as row_level_name FROM school_row_level
 inner join   `row_level` on  `row_level`.ID = school_row_level.RowLevelID
 inner join   `level` on  `level`.ID = row_level.`Level_ID`
 inner join   `row` on  `row`.ID = row_level.`Row_ID`
where school_row_level.SchoolID = ".$data['SchoolID']." and school_row_level.IsActive = 1
order by row_level.ID
")->result();
			
			}
 			if(sizeof($query)> 0)
			  {
 			    return $query ; 
			  }else{ return 0 ;}
	 }	 
	//get_subject
	public function get_subject($RowLevelID )
	 {
		$Lang = $this->session->userdata('language'); 
	    $data['SchoolID']             = (int)$this->session->userdata('SchoolID');
         $query = $this->db->query("SELECT subject.ID as subject_ID  ,subject.Name	as subject_Name	
FROM  class_table 
inner join  base_class_table on base_class_table.ID = class_table.BaseTableID
inner join  subject on subject.ID = class_table.SubjectID



where base_class_table.IsActive	=1 and class_table.RowLevelID =".$RowLevelID."
group by subject.ID

")->result();
		 
 			if(sizeof($query)> 0)
			  {
 			    return $query ; 
			  }else{ return 0 ;}
	 }	 	 
	//get_row_class
	public function get_row_class($RowLevelID )
	 {
		$Lang = $this->session->userdata('language'); 
	    $data['SchoolID']             = (int)$this->session->userdata('SchoolID');
         $query = $this->db->query("SELECT class.ID as class_ID  ,class.Name	as class_Name	
FROM  class_table 
inner join  base_class_table on base_class_table.ID = class_table.BaseTableID
inner join  class on class.ID = class_table.ClassID



where base_class_table.IsActive	=1 and class_table.RowLevelID =".$RowLevelID."
group by class.ID

")->result();
		 
 			if(sizeof($query)> 0)
			  {
 			    return $query ; 
			  }else{ return 0 ;}
	 }	 	 
	//get_emp_row_level
	public function get_emp_row_level($RowLevelID )
	 {
		$Lang = $this->session->userdata('language'); 
	    $data['SchoolID']             = (int)$this->session->userdata('SchoolID');
         $query = $this->db->query("SELECT contact.ID as contact_ID  ,contact.Name  as contact_Name , job_title.Name_Ar as job_title_Name ,count(DISTINCT ask_teacher.ID) as ask_teacher,count(DISTINCT  class_table .ID) as class_table ,count(DISTINCT plan_week.ID) as plan_week ,count(DISTINCT students_evaluation.ID) as students_evaluation
FROM  class_table 
inner join  base_class_table on base_class_table.ID = class_table.BaseTableID
inner join  contact on contact.ID = class_table.EmpID

 left join   ask_teacher on contact.ID =  ask_teacher.teacherID


inner join  employee on contact.ID = employee.Contact_ID

left join   job_title on  job_title.ID = employee.jobTitleID

left join   plan_week on  plan_week.ClassTableID= class_table.ID

left join   students_evaluation on  students_evaluation.TeacherID= contact.ID

where base_class_table.IsActive	=1 and class_table.RowLevelID =".$RowLevelID."
 group by contact.ID 

")->result();
		 
 			if(sizeof($query)> 0)
			  {
 			    return $query ; 
			  }else{ return 0 ;}
	 }	 
 }
?>