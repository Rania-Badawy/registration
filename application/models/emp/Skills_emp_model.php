<?php
class Skills_emp_model extends CI_Model{
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
    //////////get_skills
    public function get_skills($data=array())
    {
        extract($data);
        $Name = 'Name' ; 
		if($this->session->userdata('language') == 'english'){$Name = 'Name_en' ;}
		$idContact = (int)$this->session->userdata('id');
        $query = $this->db->query("select  
			 row_level.Level_Name     AS LevelName,
			 row_level.Row_Name       AS RowName,
			 row_level.ID             AS RowLevelID,
			 subject.ID               AS SubjectID,
			 subject.Name             AS SubjectName ,
			 config_semester.".$Name." AS config_semester ,
			 contact.Name             AS ContactName ,
			 contact.ID               AS ContactID,
			 skills.*
			  from skills 
			  INNER JOIN contact         ON skills.contactID    = contact.ID
 			  LEFT JOIN subject          ON skills.SubjectID   = subject.ID AND subject.Is_Active =1 
 			  LEFT JOIN row_level        ON skills.RowLevelID  = row_level.ID
		      INNER JOIN config_semester ON skills.termID     = config_semester.ID
		      INNER JOIN  class_table    ON class_table.EmpID = $UID AND skills.SubjectID    = class_table.SubjectID  and skills.RowLevelID    = class_table.RowLevelID 
 		      where   skills.IsActive =  1 
 		      AND skills.termID = $SemesterID
			  AND skills.year_id = $YearID
 		      group by skills.ID
              order BY skills.ID DESC  ")->result();
        if(sizeof($query)> 0 ){return $query;}else{return 0 ;return FALSE ;}
    } //////////
    public function get_skills_row_level($item)
    { 
$item = explode("|", $item);
 //return $item ;
        $query = $this->db->query("select  
			 level.Name     AS LevelName,
			 row.Name       AS RowName,
			 row_level.ID   AS RowLevelID,
			 subject.ID     AS SubjectID,
			 subject.Name   AS SubjectName ,
			 config_term.Name   AS config_term ,
			 config_semester.Name   AS config_semester ,
			 skills.*
			  from skills 
 			  INNER JOIN subject          ON skills.SubjectID   = subject.ID
 			  INNER JOIN row_level        ON skills.RowLevelID  = row_level.ID
			  INNER JOIN row              ON row_level.Row_ID       = row.ID
			  INNER JOIN level            ON row_level.Level_ID     = level.ID
			  INNER JOIN config_term     ON config_term.ID     = skills.termID
			  INNER JOIN config_semester     ON config_term.config_semesterID     = config_semester.ID
 		      where  subject.Is_Active =1 and  subject.Method = 1 and skills.IsActive =  1 and config_term.IsActive =  1
and  skills.RowLevelID  = $item[1] and skills.SubjectID   = $item[0]
              order BY skills.ID DESC  ")->result();
        if(sizeof($query)> 0 ){  return $query;}else{return 0 ;return FALSE ;}
    } 

    //////////get_item
    public function get_item($ID =null)
    {
        $query = $this->db->query("select  
			 level.Name     AS LevelName,
			 row.Name       AS RowName,
			 row_level.ID   AS RowLevelID,
			 subject.ID     AS SubjectID,
			 subject.Name   AS SubjectName ,
			 config_term.Name   AS config_term ,
			 config_semester.Name   AS config_semester ,
			 skills.*
			  from skills 
 			  INNER JOIN subject          ON skills.SubjectID   = subject.ID
 			  INNER JOIN row_level        ON skills.RowLevelID  = row_level.ID
			  INNER JOIN row              ON row_level.Row_ID       = row.ID
			  INNER JOIN level            ON row_level.Level_ID     = level.ID
			  INNER JOIN config_term     ON config_term.ID     = skills.termID
			  INNER JOIN config_semester     ON config_term.config_semesterID     = config_semester.ID
 		      where  subject.Is_Active =1 and  subject.Method = 1 and skills.IsActive =  1 and config_term.IsActive =  1 and skills.ID = '".$ID."'
               ")->row_array();
        if(sizeof($query)> 0 ){return $query;}else{return 0 ;return FALSE ;}
    } 
    //////////remove_item
    public function remove_item($ID)
    {
        $query = $this->db->query("DELETE 
			  from skills 
  		      where ID = '".$ID."'
               ");
        return true;  
    } 
    //////////get_subjects
    public function get_subjects()
    {
        $idContact = (int)$this->session->userdata('id');
        $query = $this->db->query(" SELECT 
             level.Name     AS LevelName,
             row.Name       AS RowName,
             row_level.ID   AS RowLevelID,
             subject.ID     AS SubjectID,
             subject.Name   AS SubjectName
             FROM 
              class_table
              INNER JOIN base_class_table          ON class_table.BaseTableID   = base_class_table.ID
              INNER JOIN subject          ON class_table.SubjectID   = subject.ID
              INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
              INNER JOIN row              ON row_level.Row_ID       = row.ID
              INNER JOIN level            ON row_level.Level_ID     = level.ID
            
              WHERE base_class_table.IsActive = 1 AND class_table.EmpID = $idContact
                         GROUP BY class_table.SubjectID , class_table.RowLevelID  ")->result();
        if(sizeof($query)> 0 ){return $query;}else{return 0 ;return FALSE ;}
    }
    //////////get_subjects
    public function get_term()
    {
        $Name = 'Name' ; 
		if($this->session->userdata('language') == 'english'){$Name = 'Name_en' ;}
        $query = $this->db->query(" 
              SELECT 
			  config_term.ID              AS ID ,
			  config_term.Name            AS config_term ,
			  config_semester.".$Name."   AS config_semester 
			  FROM 
			  config_term   
			  INNER JOIN config_semester  ON config_term.config_semesterID     = config_semester.ID
			  WHERE config_term.isActive = 1
                         ")->result();
        if(sizeof($query)> 0 ){return $query;}else{return 0 ;return FALSE ;}
    }  
    ///////////////////////////
    public function get_semester()
    {
        $Name = 'Name' ; 
		if($this->session->userdata('language') == 'english'){$Name = 'Name_en' ;}
        $query = $this->db->query(" SELECT config_semester.ID AS ID,config_semester.".$Name."   AS config_semester 
			                        FROM config_semester   
			                        WHERE config_semester.Is_Active = 1
                                  ")->result();
        if(sizeof($query)> 0 ){return $query;}else{return 0 ;return FALSE ;}
    } 
	//get_skills_student
	public function get_skills_student($data = array())
	{
		extract($data);
        $query = $this->db->query("select  
			 level.Name     AS LevelName,
			 row.Name       AS RowName,
			 row_level.ID   AS RowLevelID,
			 subject.ID     AS SubjectID,
			 subject.Name   AS SubjectName ,
			 config_term.Name   AS config_term ,
			 config_semester.Name   AS config_semester ,
			 skills.*
			  from skills 
 			  INNER JOIN subject          ON skills.SubjectID   = subject.ID
 			  INNER JOIN row_level        ON skills.RowLevelID  = row_level.ID
			  INNER JOIN row              ON row_level.Row_ID       = row.ID
			  INNER JOIN level            ON row_level.Level_ID     = level.ID
			  INNER JOIN config_term     ON config_term.ID     = skills.termID
			  INNER JOIN config_semester     ON config_term.config_semesterID     = config_semester.ID
 		      where  subject.Is_Active =1 and  subject.Method = 1 and skills.IsActive =  1 and config_term.IsActive =  1
			  and skills.RowLevelID =  '".$RowLevelID."' and skills.SubjectID =  '".$SubjectID."'
              order BY skills.ID DESC  ")->result();
        if(sizeof($query)> 0 ){return $query;}else{return 0 ;return FALSE ;}
	}
	//send_message_row
	public function insert_skills($data = array())
	{
		 $idContact = (int)$this->session->userdata('id'); 
		 extract($data);
		 $this->db->escape_str($name);
		 $term_arr =   explode(',',$term[0]);
		//	print_r($term_arr );die;
		   foreach($term_arr as $ter ){
			$Select_arr =   explode(',',$Select[0]);
 	    foreach($Select_arr as $sub ){
			
  		 		 $sub = explode("|", $sub);
 	if($skill_id){
		$query_exist = $this->db->query("select ID  from skills WHERE  name = '".trim($name)."'  AND  RowLevelID='".$sub[0]."'  AND  SubjectID ='".$sub[1]."' AND termID = '".$ter."' AND year_id = $YearID AND ID != $skill_id ")->row_array();
		if(empty($query_exist)){
 	    $DataUpdate = array
								 ( 
								  'name'          =>$name ,
								  'RowLevelID'    =>$sub[0] ,
								  'SubjectID'     =>$sub[1],
								  'termID'        =>$ter ,
								  'year_id'       =>$YearID,
								  'contactID'     =>$idContact ,
								  'Token'         =>$this->get_token(),
								  'date'          =>$Timezone
								);
								// print_R($DataUpdate);die;
						$this->db->where('ID', $skill_id);		
						$this->db->update('skills', $DataUpdate); }
 	}else{
		
					$query_exist = $this->db->query("select ID  from skills WHERE  name = '".trim($name)."'  AND  RowLevelID='".$sub[0]."'  AND  SubjectID ='".$sub[1]."' AND termID = '".$ter."' AND year_id = $YearID ")->row_array();
		
					if(empty($query_exist)){ 
					 	 $DataInsert = array
								 ( 
								  'name'          =>$name ,
								  'RowLevelID'    =>$sub[0] ,
								  'SubjectID'     =>$sub[1],
								  'termID'        =>$ter ,
								  'year_id'       =>$YearID,
								  'contactID'     =>$idContact ,
								  'Token'         =>$this->get_token(),
								  'date'          =>$Timezone
								);
								
						$this->db->insert('skills', $DataInsert);
							}
 	}
 	    }
 	}
		
 											 	return true ;
												 
	}
	//update_skills
	public function update_skills($data = array())
	{
		 $idContact = (int)$this->session->userdata('id'); 
		 extract($data);
		 $this->db->escape_str($name);
 				 foreach($Select as $item ){
					 
  		 		 $item = explode(",", $item);
					 	 $DataInsert = array
								 ( 
								  'name'           =>$name ,
								  'RowLevelID'     =>$item[0] ,
								  'SubjectID'      =>$item[1],
								  'termID'         =>$term ,
								  'contactID'      =>$idContact ,
								  'Token'          =>$this->get_token(),
								  'date'           =>$Timezone
								);
						$this->db->where('ID', $ID);
						$this->db->update('skills', $DataInsert);
					 }
							
 											 	return true ;
										 
												return false ; 
												 
	}
}