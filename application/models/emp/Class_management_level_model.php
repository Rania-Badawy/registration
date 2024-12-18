<?php
class Class_Management_Level_Model extends CI_Model{
	
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
	public function get_students()
	 {
	     $Lang   = $this->session->userdata('language');

		if($Lang == 'arabic'){
		  $query = $this->db->query("SELECT
 									tb1.ID AS StudentID,
									tb1.Name AS StudentName,
									tb2.ID AS FatherID ,
									tb2.Name AS FatherName ,
									CONCAT(tb1.Name,' ',tb2.Name ,' - ',level.Name,' - ',row.Name,' - ',class.Name) AS FullName
									FROM class_table
									 INNER JOIN row_level as rl_emp ON class_table.RowLevelID = rl_emp.ID
									 INNER JOIN row_level as rl_stu ON rl_emp.Level_ID = rl_stu.Level_ID 
                                     
                                     
 									 INNER JOIN row ON rl_stu.Row_ID = row.ID
									 INNER JOIN level ON rl_stu.Level_ID = level.ID
                                     
									INNER JOIN student ON rl_stu.ID =  student.R_L_ID
									INNER JOIN class ON student.Class_ID= class.ID
                                    inner join contact As tb1 on student.Contact_ID = tb1.ID  and class_table.SchoolID =tb1.SchoolID
									INNER JOIN contact AS tb2 ON student.Father_ID = tb2.ID
									WHERE tb1.SchoolID =  '".$this->session->userdata('SchoolID')."' and  class_table.EmpID = '".$this->session->userdata('id')."'
 									");
		}else{
		  $query = $this->db->query("SELECT
 									tb1.ID AS StudentID,
									tb1.Name AS StudentName,
									tb2.ID AS FatherID ,
									tb2.Name AS FatherName ,
									CONCAT(tb1.Name,' ',tb2.Name ,' - ',level.Name_en as Name,' - ',row.Name_en as Name,' - ',class.Name_en as Name) AS FullName
									FROM class_table
									 INNER JOIN row_level as rl_emp ON class_table.RowLevelID = rl_emp.ID
									 INNER JOIN row_level as rl_stu ON rl_emp.Level_ID = rl_stu.Level_ID 
									 INNER JOIN school_row_level ON school_row_level.RowLevelID = rl_stu.ID and school_row_level.SchoolID ='".$this->session->userdata('id')."'
                                     
                                     
 									 INNER JOIN row ON rl_stu.Row_ID = row.ID
									 INNER JOIN level ON rl_stu.Level_ID = level.ID
                                     
									INNER JOIN student ON rl_stu.ID =  student.R_L_ID
									INNER JOIN class ON student.Class_ID= class.ID
                                    inner join contact As tb1 on student.Contact_ID = tb1.ID  and class_table.SchoolID =tb1.SchoolID
									INNER JOIN contact AS tb2 ON student.Father_ID = tb2.ID
									WHERE tb1.SchoolID =  '".$this->session->userdata('SchoolID')."' and  class_table.EmpID = '".$this->session->userdata('id')."'
 									");
		    
		    
		}
		if($query->num_rows() >0)
		{return $query->result();}else{return FALSE ;}
	 }
	//get get_class_rowlevel
	public function get_class_rowlevel()
	 {
	     $Lang   = $this->session->userdata('language');

		if($Lang == 'arabic'){
		  $query = $this->db->query("SELECT
 									school_row_level.RowLevelID,
 									school_class.ClassID,
 									CONCAT(level.Name,' - ',row.Name,' - ',class.Name) AS rlclass
									FROM class_table
									 INNER JOIN row_level as rl_emp ON class_table.RowLevelID = rl_emp.ID
									 INNER JOIN row_level as rl_stu ON rl_emp.Level_ID = rl_stu.Level_ID 
 									 INNER JOIN row ON rl_stu.Row_ID = row.ID
									 INNER JOIN level ON rl_stu.Level_ID = level.ID
									 INNER JOIN school_row_level ON school_row_level.RowLevelID = rl_stu.ID and school_row_level.SchoolID ='".$this->session->userdata('id')."'
									 INNER JOIN school_class ON school_class.SchoolID =   school_row_level.SchoolID  
 									INNER JOIN class ON school_class.ClassID= class.ID 
									WHERE class_table.SchoolID =  '".$this->session->userdata('SchoolID')."' and  class_table.EmpID = '".$this->session->userdata('id')."' group by class_table.RowLevelID , class_table.ClassID
 									");
		}else{
		  $query = $this->db->query("SELECT
 									school_row_level.RowLevelID,
 									school_class.ClassID,
									CONCAT( level.Name_en as Name,' - ',row.Name_en as Name,' - ',class.Name_en as Name) AS rlclass
									FROM class_table
									 INNER JOIN row_level as rl_emp ON class_table.RowLevelID = rl_emp.ID
									 INNER JOIN row_level as rl_stu ON rl_emp.Level_ID = rl_stu.Level_ID 
 									 INNER JOIN row ON rl_stu.Row_ID = row.ID
									 INNER JOIN level ON rl_stu.Level_ID = level.ID
									 INNER JOIN school_row_level ON school_row_level.RowLevelID = rl_stu.ID and school_row_level.SchoolID ='".$this->session->userdata('id')."'
									 INNER JOIN school_class ON school_class.SchoolID =   school_row_level.SchoolID  
 									INNER JOIN class ON school_class.ClassID= class.ID 
									WHERE class_table.SchoolID =  '".$this->session->userdata('SchoolID')."' and  class_table.EmpID = '".$this->session->userdata('id')."' group by class_table.RowLevelID , class_table.ClassID
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
			$DataUpdate = array("Class_ID"  =>$ClassID , "R_L_ID"  =>$RowLevelID,'contactID_update'=>$this->session->userdata('id'));
			$this->db->update('student',$DataUpdate, array('Contact_ID' => $StudentID));
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





 }
?>