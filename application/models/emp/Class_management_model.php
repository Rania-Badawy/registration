<?php
class Class_Management_Model extends CI_Model{
	
	//get Titles
	public function get_classes($Lang = NULL )
	 {
		if($Lang == 'arabic')
		{
			$query = $this->db->query("SELECT
										class_table.ID AS ClassTableID ,
										level.ID AS LevelID,
										row.ID AS RowID,
										class.ID AS ClassID,
										level.Name AS LevelName,
										row.Name AS RowName,
										row_level.ID As RowLevelID ,
										class.ID As ClassID ,
										class.Name AS ClassName
									 FROM class_table
									 INNER JOIN base_class_table ON class_table.BaseTableID = base_class_table.ID
									 INNER JOIN class ON class_table.ClassID = class.ID
									 INNER JOIN row_level ON class_table.RowLevelID = row_level.ID
									 INNER JOIN row ON row_level.Row_ID = row.ID
									 INNER JOIN level ON row_level.Level_ID = level.ID
									 WHERE base_class_table.IsActive = 1
									 GROUP BY class_table.RowLevelID , class_table.ClassID
									");
		}
		else
		{
			$query = $this->db->query("SELECT
										class_table.ID AS ClassTableID ,
										level.ID AS LevelID,
										row.ID AS RowID,
										class.ID AS ClassID,
										level.Name_en AS LevelName,
										row.Name_en AS RowName,
										row_level.ID As RowLevelID ,
										class.ID As ClassID ,
										class.Name_en AS ClassName
									 FROM class_table
									 INNER JOIN base_class_table ON class_table.BaseTableID = base_class_table.ID
									 INNER JOIN class ON class_table.ClassID = class.ID
									 INNER JOIN row_level ON class_table.RowLevelID = row_level.ID
									 INNER JOIN row ON row_level.Row_ID = row.ID
									 INNER JOIN level ON row_level.Level_ID = level.ID
									 WHERE base_class_table.IsActive = 1
									 GROUP BY class_table.RowLevelID , class_table.ClassID
									");
		}
		if($query->num_rows() >0)
		{return $query->result();}else{return FALSE ;}
	}
 
	//get Titles
	public function get_students($Lang = NULL )
	 {	/*
		 $query = $this->db->query("SELECT tb1.ID AS StudentID, tb1.Name AS StudentName, tb2.ID AS FatherID , tb2.Name AS FatherName , 
                                    CONCAT(tb1.Name,' ',tb2.Name) AS FullName 
                                    FROM contact As tb1 
                                    INNER JOIN student ON tb1.ID = student.Contact_ID 
                                    INNER JOIN contact AS tb2 ON student.Father_ID = tb2.ID 
                                    WHERE tb1.SchoolID = '".$this->session->userdata('SchoolID')."' 
                                    and  student.R_L_ID in(
                                    select GROUP_CONCAT(class_table.RowLevelID) from class_table where class_table.EmpID = '".$this->session->userdata('id')."'  group by class_table.RowLevelID
                                    )
								");	*/
		
		if($Lang == 'arabic'){
		    	 $query = $this->db->query("SELECT tb1.ID AS StudentID, tb1.Name AS StudentName, tb2.ID AS FatherID , tb2.Name AS FatherName , 
                                    CONCAT(tb1.Name,' ',tb2.Name ) AS FullName   ,
										level.Name AS LevelName,
										row.Name AS RowName,
										row_level.ID As RowLevelID ,
										class.ID As ClassID ,
										class.Name AS ClassName
                                    FROM contact As tb1 
                                    INNER JOIN student ON tb1.ID = student.Contact_ID 
                                    INNER JOIN contact AS tb2 ON student.Father_ID = tb2.ID 
                                    inner join class_table on class_table.RowLevelID = student.R_L_ID  and class_table.SchoolID =tb1.SchoolID
									 INNER JOIN class ON student.Class_ID = class.ID
									 INNER JOIN row_level ON student.R_L_ID = row_level.ID
									 INNER JOIN row ON row_level.Row_ID = row.ID
									 INNER JOIN level ON row_level.Level_ID = level.ID
                                    WHERE tb1.SchoolID = '".$this->session->userdata('SchoolID')."' 
                                    and  class_table.EmpID = '".$this->session->userdata('id')."'  group by class_table.RowLevelID  ,tb1.ID
                                    
								");
		    
		}else{
		    	 $query = $this->db->query("SELECT tb1.ID AS StudentID, tb1.Name AS StudentName, tb2.ID AS FatherID , tb2.Name AS FatherName , 
                                    CONCAT(tb1.Name,' ',tb2.Name ) AS FullName   ,level.Name_en AS LevelName,
										row.Name_en AS RowName,
 										class.Name_en AS ClassName
                                    FROM contact As tb1 
                                    INNER JOIN student ON tb1.ID = student.Contact_ID 
                                    INNER JOIN contact AS tb2 ON student.Father_ID = tb2.ID 
                                    inner join class_table on class_table.RowLevelID = student.R_L_ID  and class_table.SchoolID =tb1.SchoolID
									 INNER JOIN class ON student.Class_ID = class.ID
									 INNER JOIN row_level ON student.R_L_ID = row_level.ID
									 INNER JOIN row ON row_level.Row_ID = row.ID
									 INNER JOIN level ON row_level.Level_ID = level.ID
                                    WHERE tb1.SchoolID = '".$this->session->userdata('SchoolID')."' 
                                    and  class_table.EmpID = '".$this->session->userdata('id')."'  group by class_table.RowLevelID  ,tb1.ID
                                    
								");
		    
		}
						 
	 	
		if($query->num_rows() >0)
		{return $query->result();}else{return FALSE ;}
	 }
	 public function get_students_where($class_id,$row_level_id)
	 {	/*
		 $query = $this->db->query("SELECT tb1.ID AS StudentID, tb1.Name AS StudentName, tb2.ID AS FatherID , tb2.Name AS FatherName , 
                                    CONCAT(tb1.Name,' ',tb2.Name) AS FullName 
                                    FROM contact As tb1 
                                    INNER JOIN student ON tb1.ID = student.Contact_ID 
                                    INNER JOIN contact AS tb2 ON student.Father_ID = tb2.ID 
                                    WHERE tb1.SchoolID = '".$this->session->userdata('SchoolID')."' 
                                    and  student.R_L_ID in(
                                    select GROUP_CONCAT(class_table.RowLevelID) from class_table where class_table.EmpID = '".$this->session->userdata('id')."'  group by class_table.RowLevelID
                                    )
								");	*/
		
		
		$query = $this->db->query("
						SELECT tb1.ID AS StudentID, tb1.Name AS StudentName, tb2.ID AS FatherID , tb2.Name AS FatherName , 
						CONCAT(tb1.Name,' ',tb2.Name ) AS FullName   ,
							level.Name AS LevelName,
							row.Name AS RowName,
							row_level.ID As RowLevelID ,
							class.ID As ClassID ,
							class.Name AS ClassName
						FROM contact As tb1 
						INNER JOIN student ON tb1.ID = student.Contact_ID 
						INNER JOIN contact AS tb2 ON student.Father_ID = tb2.ID 
						INNER JOIN class ON student.Class_ID = class.ID
						INNER JOIN row_level ON student.R_L_ID = row_level.ID
						INNER JOIN row ON row_level.Row_ID = row.ID
						INNER JOIN level ON row_level.Level_ID = level.ID
						WHERE tb1.SchoolID = '".$this->session->userdata('SchoolID')."' 
						and student.R_L_ID = '".$row_level_id."' and student.Class_ID = '".$class_id."'
		");			 
		if($query->num_rows() >0)
		{return $query->result();}else{return FALSE ;}
	 }
	// get_row_level_class
	public function get_row_level_class($Lang = NULL )
	 {
		if($Lang == 'arabic'){
		    $query = $this->db->query("SELECT 
										level.ID AS LevelID,
										row.ID AS RowID,
										class.ID AS ClassID,
										level.Name AS LevelName,
										row.Name AS RowName,
										row_level.ID As RowLevelID ,
										class.ID As ClassID ,
										class.Name AS ClassName
                                    FROM  class_table 
									 INNER JOIN class ON class_table.ClassID = class.ID
									 INNER JOIN row_level ON class_table.RowLevelID = row_level.ID
									 INNER JOIN row ON row_level.Row_ID = row.ID
									 INNER JOIN level ON row_level.Level_ID = level.ID
                                    WHERE class_table.SchoolID = '".$this->session->userdata('SchoolID')."' 
                                    and  class_table.EmpID = '".$this->session->userdata('id')."'  group by class_table.RowLevelID , class_table.ClassID
                                    
								");}else{
		    $query = $this->db->query("SELECT 
										level.ID AS LevelID,
										row.ID AS RowID,
										class.ID AS ClassID,
										level.Name_en AS LevelName,
										row.Name_en AS RowName,
										row_level.ID As RowLevelID ,
										class.ID As ClassID ,
										class.Name_en AS ClassName
                                    FROM  class_table  
									 INNER JOIN class ON class_table.ClassID = class.ID
									 INNER JOIN row_level ON class_table.RowLevelID = row_level.ID
									 INNER JOIN row ON row_level.Row_ID = row.ID
									 INNER JOIN level ON row_level.Level_ID = level.ID
                                    WHERE class_table.SchoolID = '".$this->session->userdata('SchoolID')."' 
                                    and  class_table.EmpID = '".$this->session->userdata('id')."'  group by class_table.RowLevelID , class_table.ClassID
                                    
								");
		    
		}
	  
		  
	 	
							 
	 	
		if($query->num_rows() >0)
		{return $query->result();}else{return FALSE ;}
	 }

	//get Titles
	public function add_class_students($data = array())
	 {
	 	extract($data) ;
		
	 	foreach ($SelectStudent as $Key=>$Row)
		{
			$StudentID  = $Row ;
			if($ClassID!=0&&$RowLevelID!=0){
			$DataUpdate = array("Class_ID"  =>$ClassID , "R_L_ID"  =>$RowLevelID,'contactID_update'=>$this->session->userdata('id'));
			$this->db->update('student',$DataUpdate, array('Contact_ID' => $StudentID));
			}
		}
		return TRUE ;
	 }

	//get Titles
	public function get_student_class($StudentIDs)
	 {
	 	//echo count($StudentIDs);
		//print_r($StudentIDs);exit();
		//echo "size of array = ".sizeof($StudentIDs);
		//exit();
		//$IDsNum = count($StudentIDs);
		$rows = array();
		for($i=0;$i<count($StudentIDs);$i++)
        {
            $StudentID = $StudentIDs[$i];
			
        	$query = $this->db->query("SELECT
									student.Father_ID, student.Class_ID, student.R_L_ID,
									tb1.Name AS StudentName,
									tb2.Name AS FatherName,
									CONCAT(tb1.Name,' ',tb2.Name) AS FullName,
									CONCAT(row_level.Row_Name,'-',row_level.Level_Name) AS RowLevelName,
									class.Name AS ClassName
									FROM student
									INNER JOIN contact AS tb1 ON student.Contact_ID = tb1.ID
									INNER JOIN contact AS tb2 ON student.Father_ID = tb2.ID
									INNER JOIN row_level ON student.R_L_ID = row_level.ID
									INNER JOIN class ON student.Class_ID = class.ID
									WHERE student.Contact_ID = '".$StudentID."'
									LIMIT 1
									");
			$row = $query->row_array();
			$rows[] = $row;
		}
		
			   return $rows;
		
	
		 // returning rows, not row
		
		/*$query = $this->db->query("SELECT
									student.Father_ID, student.Class_ID, student.R_L_ID,
									tb1.Name AS StudentName,
									tb2.Name AS FatherName,
									CONCAT(tb1.Name,' ',tb2.Name) AS FullName,
									CONCAT(row_level.Row_Name,'-',row_level.Level_Name) AS RowLevelName,
									class.Name AS ClassName
									FROM student
									INNER JOIN contact AS tb1 ON student.Contact_ID = tb1.ID
									INNER JOIN contact AS tb2 ON student.Father_ID = tb2.ID
									INNER JOIN row_level ON student.R_L_ID = row_level.ID
									INNER JOIN class ON student.Class_ID = class.ID
									WHERE student.Contact_ID = '".$StudentID."'
									LIMIT 1
									");
	 	
		if($query->num_rows() >0)
		{return $query->row_array();}else{return FALSE ;}*/
	 }


	 public function get_level_emp(){
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		SELECT level.ID AS LevelID , row.ID AS RowID , level.".$Name." AS LevelName , row.".$Name." AS RowName , row_level.ID As RowLevelID FROM row_level 
		INNER JOIN row ON row_level.Row_ID = row.ID 
		INNER JOIN level ON row_level.Level_ID = level.ID 
		INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = '".$this->session->userdata('SchoolID')."'
		where row_level.ID IN(
		(
		select concat_ws(',',class_table.RowLevelID ) from class_table where class_table.EmpID = '".$this->session->userdata('id')."' group by class_table.RowLevelID
		)
		)
		");
		if($query->num_rows()>0){
			return $query->result();
		}
	 }


 }
?>