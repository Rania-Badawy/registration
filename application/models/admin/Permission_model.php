<?php
class Permission_Model extends CI_Model 
 {
	private $Date            = '' ;
	private $Encryptkey      = '' ;
	private $Token           = '' ;
	function __construct()
    {
	   parent::__construct();
	   $this->Date       = date('Y-m-d H:i:s');
	  
    }
   
  public function Get_PerType(){
      
      
      $query = $this->db->query("
		 SELECT
		 employee.Type , employee.PerType 
		 FROM employee
		 WHERE employee.Contact_ID = ".$this->session->userdata('id')."
		 LIMIT 1 ");
  if($query->num_rows() >0) {return $query->row_array();}else{return FALSE ;}
  }
  
  //////////////////////////////////
  
   public function Get_level1($PerType){
      
      
      	$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT
		 level.ID         AS LevelID ,
		 level.".$Name."  AS LevelName
		 FROM level
		 INNER JOIN row_level  ON row_level.Level_ID = level.ID
		 INNER JOIN student    ON student.R_L_ID           = row_level.ID 
		 INNER JOIN contact    ON student.Contact_ID      = contact.ID  AND contact.Isactive =1 AND contact.SchoolID = ".$this->session->userdata('SchoolID')."
		 WHERE level.ID IN(".$PerType.")
		 GROUP BY level.ID
		");
	 if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
  }
   //////////////////////////////////
  
   public function Get_level_without_student1($PerType){
      
      
      	$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT
		 level.ID         AS LevelID ,
		 level.".$Name."  AS LevelName
		 FROM level
		 INNER JOIN row_level  ON row_level.Level_ID = level.ID
		 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID and school_row_level.schoolID IN(".$this->session->userdata('SchoolID').")
		 WHERE level.ID IN(".$PerType.")
		 GROUP BY level.ID
		");
	 if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
  }
  
 /////////////////////////////////////////////
  public function get_RowLevel1($PerType,$levelID)
  {
         	$R_L_ID_array =get_rowlevel_select_in();
      		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT
		 row_level.Level_ID         AS LevelID ,
		 row_level.Row_ID           AS RowID ,
		 row_level.Level_Name       AS LevelName ,
		 row_level.Row_Name         AS RowName ,
		 row_level.ID               As RowLevelID 
		 FROM 
		 row_level
		 INNER JOIN school_row_level ON row_level.ID            = school_row_level.RowLevelID
		 INNER JOIN student          ON student.R_L_ID          = row_level.ID
		 INNER JOIN contact          ON student.Contact_ID      = contact.ID  AND contact.Isactive =1 AND contact.SchoolID = ".$this->session->userdata('SchoolID')."
		 WHERE row_level.IsActive = 1 AND row_level.Level_ID IN (".$PerType.") and row_level.Level_ID=".$levelID."  AND row_level.ID IN ($R_L_ID_array) AND school_row_level.SchoolID IN(".$this->session->userdata('SchoolID').")
		 GROUP BY row_level.ID
		");
	 if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
  }
  /////////////////////////
  public function get_RowLevel_without_student1($PerType,$levelID)
  {

      		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT
		 row_level.Level_ID         AS LevelID ,
		 row_level.Row_ID           AS RowID ,
		 row_level.Level_Name       AS LevelName ,
		 row_level.Row_Name         AS RowName ,
		 row_level.ID               As RowLevelID 
		 FROM 
		 row_level
		 INNER JOIN school_row_level ON row_level.ID            = school_row_level.RowLevelID
		 WHERE row_level.IsActive = 1 AND row_level.Level_ID IN (".$PerType.") and row_level.Level_ID=".$levelID." AND row_level.ID IN (school_row_level.RowLevelID) 
		 AND school_row_level.SchoolID IN(".$this->session->userdata('SchoolID').")
		 GROUP BY row_level.ID
		");
	 if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
  }
  ///////////////////////////////////////////////////////
  public function get_Class1($R_L_ID)
  {
      
      	$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		SELECT
		class.ID         AS ClassID ,
		 class.".$Name."  AS ClassName ,row_level.Level_Name AS LevelName,row_level.Row_Name AS RowName,row_level.ID AS RowLevelID
		 FROM class
		 inner join class_level on class.ID=class_level.classID
		 INNER join row_level ON class_level.levelID=row_level.Level_ID
		 INNER JOIN student      ON student.R_L_ID           = row_level.ID and student.Class_ID  = class.ID
		 INNER JOIN contact      ON student.Contact_ID      = contact.ID  AND contact.Isactive =1 AND contact.SchoolID = ".$this->session->userdata('SchoolID')."
		 WHERE class.Is_Active =1 AND row_level.ID=".$R_L_ID."
		 GROUP BY class.ID
		");
	 if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
  }
 ///////////////////////////////////////////////////////////////// 
  
  public function get_Subject1()
  {
      
		$query = $this->db->query("
		 SELECT
		 subject.ID         AS ID ,
		 subject.Name  AS Name 
		 FROM subject
		 WHERE subject.Is_Active =1 
		 GROUP BY subject.ID
		");
	 if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
  }
  /////////////////////////////////
   public function Get_level2($PerType)
  {

      		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT DISTINCT
		 level.ID         AS LevelID ,
		 level.".$Name."  AS LevelName 
		 FROM 
		 row_level
		 INNER JOIN level            ON row_level.Level_ID      = level.ID
		 INNER JOIN student    ON student.R_L_ID           = row_level.ID 
		 INNER JOIN contact    ON student.Contact_ID      = contact.ID  AND contact.Isactive =1 AND contact.SchoolID = ".$this->session->userdata('SchoolID')."
		 WHERE level.Is_Active = 1 AND row_level.ID IN (".$PerType.")
		 GROUP BY level.ID
		");
	 if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
  }
   /////////////////////////////////
   public function Get_level_without_student2($PerType)
  {

      		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT DISTINCT
		 level.ID         AS LevelID ,
		 level.".$Name."  AS LevelName 
		 FROM 
		 row_level
		 INNER JOIN level            ON row_level.Level_ID      = level.ID
		 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID and school_row_level.schoolID IN(".$this->session->userdata('SchoolID').")
		 WHERE level.Is_Active = 1 AND row_level.ID IN (".$PerType.")
		 GROUP BY level.ID
		");
	 if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
  }
   /////////////////////////////////
   public function get_RowLevel2($PerType,$levelID)
  {

      		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT 
		 row_level.Level_ID         AS LevelID ,
		 row_level.Row_ID           AS RowID ,
		 row_level.Level_Name       AS LevelName ,
		 row_level.Row_Name         AS RowName ,
		 row_level.ID     As RowLevelID 
		 FROM 
		 row_level
		 INNER JOIN school_row_level ON row_level.ID            = school_row_level.RowLevelID
		 INNER JOIN student          ON student.R_L_ID          = row_level.ID
		 INNER JOIN contact          ON student.Contact_ID      = contact.ID  AND contact.Isactive =1 AND contact.SchoolID = ".$this->session->userdata('SchoolID')."
		 WHERE row_level.IsActive = 1  AND row_level.Level_ID =".$levelID." AND row_level.ID IN (".$PerType.") AND row_level.ID IN (school_row_level.RowLevelID) AND school_row_level.SchoolID IN(".$this->session->userdata('SchoolID').")
		 GROUP BY row_level.ID
		");
	 if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
  }
  /////////////////////////////////
   public function get_RowLevel_without_student2($PerType,$levelID)
  {

      		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT 
		 row_level.Level_ID         AS LevelID ,
		 row_level.Row_ID           AS RowID ,
		 row_level.Level_Name       AS LevelName ,
		 row_level.Row_Name         AS RowName ,
		 row_level.ID     As RowLevelID 
		 FROM 
		 row_level
		 INNER JOIN school_row_level ON row_level.ID            = school_row_level.RowLevelID
		  WHERE row_level.IsActive = 1  AND row_level.Level_ID =".$levelID." AND row_level.ID IN (".$PerType.") AND row_level.ID IN (school_row_level.RowLevelID) 
		  AND school_row_level.SchoolID IN(".$this->session->userdata('SchoolID').")
		 GROUP BY row_level.ID
		");
	 if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
  }
   ///////////////////////////////////////////////////////
  
  public function get_Class3($Class)
  {
      
      	$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT
		 class.ID         AS ClassID ,
		 class.".$Name."  AS ClassName,row_level.Level_Name AS LevelName,row_level.Row_Name AS RowName,row_level.ID AS RowLevelID
		 FROM class
		 inner join class_level on class.ID=class_level.classID
		 INNER join row_level ON class_level.levelID=row_level.Level_ID
		 WHERE class.Is_Active =1 AND class.ID IN (".$Class.") 
		 GROUP BY class.ID
		");
	 if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
  }
  ////////////////////////////////////////////////
   public function get_Class_special($Class,$row_level)
  {
      
      	$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT
		 class.ID         AS ClassID ,
		 class.".$Name."  AS ClassName,row_level.Level_Name AS LevelName,row_level.Row_Name AS RowName,row_level.ID AS RowLevelID
		 FROM class
		 inner join class_level on class.ID=class_level.classID
		 INNER join row_level ON class_level.levelID=row_level.Level_ID
		 INNER JOIN school_class ON class.ID = school_class.ClassID AND school_class.SchoolID = '".$this->session->userdata('SchoolID')."'
		 INNER JOIN student      ON student.R_L_ID           = row_level.ID and student.Class_ID         = class.ID
		 INNER JOIN contact      ON student.Contact_ID      = contact.ID  AND contact.Isactive =1 AND contact.SchoolID = ".$this->session->userdata('SchoolID')."

		 WHERE class.Is_Active =1 AND class.ID IN (".$Class.") AND row_level.ID=".$row_level."
		 GROUP BY class.ID
		");
	 if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
  }
  
  ///////////////////////////////////////////////////////////////// 
  
  public function get_Subject4($subject)
  {
      
		$query = $this->db->query("
		 SELECT
		 subject.ID         AS ID ,
		 subject.Name  AS Name 
		 FROM subject 
		 WHERE subject.Is_Active =1 
		 AND subject.ID IN (".$subject.") 
		 GROUP BY subject.ID
		");
	 if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
  }
  	public function get_level($Lang = NULL )
	{
		$GetData = $this->db->query("
		select level.ID AS LevelID,level.Name as LevelName
		from row_level
		INNER JOIN level 				ON row_level.Level_ID = level.ID
		INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID
		 INNER JOIN student      ON student.R_L_ID           = row_level.ID 
		 INNER JOIN contact      ON student.Contact_ID      = contact.ID  AND contact.Isactive =1 AND contact.SchoolID = ".$this->session->userdata('SchoolID')."
		where school_row_level.schoolID IN(".$this->session->userdata('SchoolID').")
		group by level.ID
		");
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			return FALSE ;
		}
	}
	/////////////////////
	public function get_level_without_student($Lang = NULL )
	{
		$GetData = $this->db->query("
		select level.ID AS LevelID,level.Name as LevelName
		from row_level
		INNER JOIN level 				ON row_level.Level_ID = level.ID
		INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID
		where school_row_level.schoolID IN(".$this->session->userdata('SchoolID').")
		group by level.ID
		");
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			return FALSE ;
		}
	}
	///////////////////////////////////
public function get_RowLevel($Lang,$levelID)
  {

      		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT 
		 row_level.Level_ID         AS LevelID ,
		 row_level.Row_ID           AS RowID ,
		 row_level.Level_Name       AS LevelName ,
		 row_level.Row_Name         AS RowName ,
		 row_level.ID     As RowLevelID 
		 FROM 
		 row_level
		 INNER JOIN school_row_level ON row_level.ID            = school_row_level.RowLevelID
		 INNER JOIN student          ON student.R_L_ID           = row_level.ID
		 INNER JOIN contact          ON student.Contact_ID      = contact.ID  AND contact.Isactive =1 AND contact.SchoolID = ".$this->session->userdata('SchoolID')."
		 WHERE row_level.IsActive = 1  and row_level.Level_ID =".$levelID." AND row_level.ID IN (school_row_level.RowLevelID) AND school_row_level.SchoolID IN(".$this->session->userdata('SchoolID').")
		 GROUP BY row_level.ID
		");
	 if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
  }
  //////////////////////////////
  	 public function get_RowLevel_without_student($Lang,$levelID)
  {

      		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT 
		 row_level.Level_ID         AS LevelID ,
		 row_level.Row_ID           AS RowID ,
		 row_level.Level_Name       AS LevelName ,
		 row_level.Row_Name         AS RowName ,
		 row_level.ID     As RowLevelID 
		 FROM 
		 row_level
		 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID and school_row_level.schoolID IN(".$this->session->userdata('SchoolID').")
	 	 WHERE row_level.IsActive = 1  and row_level.Level_ID =".$levelID." AND row_level.ID IN (school_row_level.RowLevelID) 
	 	 AND school_row_level.SchoolID IN(".$this->session->userdata('SchoolID').")
		 GROUP BY row_level.ID
		");
	 if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
  }
	
	public function get_row_level_class()
  {
      
      	$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		SELECT
		class.ID         AS ClassID ,
		 class.".$Name."  AS ClassName ,row_level.Level_Name AS LevelName,row_level.Row_Name AS RowName,row_level.ID AS RowLevelID
		 FROM class
		 inner join class_level on class.ID=class_level.classID
		 INNER join row_level ON class_level.levelID=row_level.Level_ID
		 INNER JOIN level ON level.ID = class_level.levelID
		 INNER JOIN school_class ON class.ID = school_class.ClassID AND school_class.SchoolID = '".$this->session->userdata('SchoolID')."'
		 INNER JOIN student        ON student.R_L_ID           = row_level.ID and student.Class_ID         = class.ID
		 INNER JOIN contact        ON student.Contact_ID      = contact.ID  AND contact.Isactive =1 AND contact.SchoolID = ".$this->session->userdata('SchoolID')."
		 WHERE class.Is_Active =1 
		 GROUP BY class.ID,row_level.ID
		 ORDER BY row_level.ID , level.ID ASC
		");
	 if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
  }
	//تقرير جدول الحصص بالفصل
	 
  public function get_Class_case1($level_id)
  {
      
      	$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		SELECT
		class.ID         AS ClassID ,
		 class.".$Name."  AS ClassName ,row_level.Level_Name AS LevelName,row_level.Row_Name AS RowName,row_level.ID AS RowLevelID
		 FROM class
		 inner join class_level on class.ID=class_level.classID
		 INNER join row_level ON class_level.levelID=row_level.Level_ID
		 INNER JOIN school_class ON class.ID = school_class.ClassID AND school_class.SchoolID = '".$this->session->userdata('SchoolID')."'
		 INNER JOIN student        ON student.R_L_ID           = row_level.ID and student.Class_ID         = class.ID
		 INNER JOIN contact          ON student.Contact_ID      = contact.ID  AND contact.Isactive =1 AND contact.SchoolID = ".$this->session->userdata('SchoolID')."
		 WHERE class.Is_Active =1 and class_level.levelID IN(".$level_id.")
		 GROUP BY class.ID,row_level.ID
		");
	 if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
  }
  public function get_Class_case2($R_L_ID)
  {
      
      	$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		SELECT
		class.ID         AS ClassID ,
		 class.".$Name."  AS ClassName ,row_level.Level_Name AS LevelName,row_level.Row_Name AS RowName,row_level.ID AS RowLevelID
		 FROM class
		 inner join class_level on class.ID=class_level.classID
		 INNER join row_level ON class_level.levelID=row_level.Level_ID
		  INNER JOIN school_class ON class.ID = school_class.ClassID AND school_class.SchoolID = '".$this->session->userdata('SchoolID')."'
		 INNER JOIN student        ON student.R_L_ID           = row_level.ID and student.Class_ID         = class.ID
		 INNER JOIN contact          ON student.Contact_ID      = contact.ID  AND contact.Isactive =1 AND contact.SchoolID = ".$this->session->userdata('SchoolID')."
		 WHERE class.Is_Active =1 AND row_level.ID IN(".$R_L_ID.")
		 GROUP BY class.ID,row_level.ID
		");
	 if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
  }
  
  public function get_Class_case3($R_L_ID,$Class)
  {
    //   $R_L_ID_Array=get_rowlevel_select_in();
    //   $Class_array=get_class_select_in();

      	$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		select ClassID,ClassName,LevelName,RowName,RowLevelID from( SELECT class.ID AS ClassID , class.".$Name." AS ClassName ,row_level.Level_Name AS LevelName,
		row_level.Row_Name AS RowName,row_level.ID AS RowLevelID 
		FROM class
		inner join class_level on class.ID=class_level.classID 
		INNER join row_level ON class_level.levelID=row_level.Level_ID
		 INNER JOIN school_class ON class.ID = school_class.ClassID AND school_class.SchoolID = '".$this->session->userdata('SchoolID')."'
		 INNER JOIN student        ON student.R_L_ID           = row_level.ID and student.Class_ID         = class.ID
		 INNER JOIN contact          ON student.Contact_ID      = contact.ID  AND contact.Isactive =1 AND contact.SchoolID = ".$this->session->userdata('SchoolID')."
		WHERE class.Is_Active =1 AND row_level.ID IN(".$R_L_ID.") )AS t
		where ClassID IN (".$Class.") 
		");
	 if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
  }
   /////////////////////////////////////////////////
  public function get_class_new($Lang = NULL , $RowLevelID = 0)
	{
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		////////////////////////////////////////////////////////////////////////////////
		$query = $this->db->query("
		 SELECT
		  class.ID         AS ClassID ,
		 class.".$Name."  AS ClassName ,row_level.Level_Name AS LevelName,row_level.Row_Name AS RowName,row_level.ID AS RowLevelID
		 FROM class
		 inner join class_level on class.ID=class_level.classID
		 INNER join row_level ON class_level.levelID=row_level.Level_ID
		 INNER JOIN student on row_level.ID = student.R_L_ID AND class.ID=student.Class_ID
		 INNER JOIN contact          ON student.Contact_ID      = contact.ID  AND contact.Isactive =1 AND contact.SchoolID = ".$this->session->userdata('SchoolID')."
		 INNER JOIN school_class on   class.ID    = school_class.ClassID
		 WHERE class.Is_Active =1 AND row_level.ID=".$RowLevelID." AND contact.Isactive=1 
	     AND school_class.SchoolID = '".$this->session->userdata('SchoolID')."' 
		 GROUP BY class.ID 
			")->result(); 

 
		if(sizeof($query)>0)
		{
			return $query ;
		}else{

			return false ;
		}
	} 
		public function get_row_level_new($Lang = NULL,$LevelID)
	{
	    $Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		////////////////////////////////////////////////////////////////////////////////
		$query = $this->db->query("
			 SELECT DISTINCT
 			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
			 level.".$Name."  AS LevelName ,
		     row.".$Name."    AS RowName ,
 			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
			 class.".$Name."  AS ClassName
			 FROM
			 student
			 INNER JOIN class            ON student.Class_ID     = class.ID
			 INNER JOIN row_level        ON student.R_L_ID  = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID        = row.ID
			 INNER JOIN level            ON row_level.Level_ID      = level.ID and row_level.Level_ID=$LevelID
			 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID IN('".$this->session->userdata('SchoolID')."')
			 GROUP BY student.R_L_ID
			")->result();
		if(sizeof($query)>0)
		{
			return $query ;
		}else{

			return false ;
		}
	}
	////////////////////////
   public function get_RowLevel_classtable1($PerType)
  {

      		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT 
		 row_level.Level_ID         AS LevelID ,
		 row_level.Row_ID           AS RowID ,
		 row_level.Level_Name       AS LevelName ,
		 row_level.Row_Name         AS RowName ,
		 row_level.ID               As RowLevelID 
		 FROM 
		 row_level
		 INNER JOIN student          ON student.R_L_ID = row_level.ID
		 INNER JOIN contact          ON student.Contact_ID      = contact.ID  AND contact.Isactive =1 AND contact.SchoolID = ".$this->session->userdata('SchoolID')."
		 WHERE row_level.IsActive = 1   AND row_level.Level_ID IN (".$PerType.")
		 
		 GROUP BY row_level.ID
		");
	 if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
  }
  public function get_RowLevel_classtable_without_student1($PerType)
  {

      		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT 
		 row_level.Level_ID         AS LevelID ,
		 row_level.Row_ID           AS RowID ,
		 row_level.Level_Name       AS LevelName ,
		 row_level.Row_Name         AS RowName ,
		 row_level.ID               As RowLevelID 
		 FROM 
		 row_level
		 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID 
		 WHERE row_level.IsActive = 1   AND row_level.Level_ID IN (".$PerType.")
		 
		 GROUP BY row_level.ID
		");
	 if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
  }
  ///////////////////////////////
  public function get_RowLevel_classtable2($PerType)
  {

      		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT 
		 row_level.Level_ID         AS LevelID ,
		 row_level.Row_ID           AS RowID ,
		 row_level.Level_Name       AS LevelName ,
		 row_level.Row_Name         AS RowName ,
		 row_level.ID               As RowLevelID 
		 FROM row_level
		 INNER JOIN student          ON student.R_L_ID = row_level.ID
		 INNER JOIN contact          ON student.Contact_ID      = contact.ID  AND contact.Isactive =1 AND contact.SchoolID = ".$this->session->userdata('SchoolID')."
		 WHERE row_level.IsActive = 1   AND row_level.ID IN (".$PerType.")
		 GROUP BY row_level.ID
		");
	 if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
  }
  ////////////////////////////////////
   public function get_RowLevel_classtable_without_student2($PerType)
  {

      		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT 
		 row_level.Level_ID         AS LevelID ,
		 row_level.Row_ID           AS RowID ,
		 row_level.Level_Name       AS LevelName ,
		 row_level.Row_Name         AS RowName ,
		 row_level.ID               As RowLevelID 
		 FROM row_level
		 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID 
		 WHERE row_level.IsActive = 1   AND row_level.ID IN (".$PerType.")
		 GROUP BY row_level.ID
		");
	 if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
  }
  public function get_Class_classtable2($R_L_ID)
  {
      
      	$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		SELECT
		class.ID         AS ClassID ,
		 class.".$Name."  AS ClassName ,row_level.Level_Name AS LevelName,row_level.Row_Name AS RowName,row_level.ID AS RowLevelID
		 FROM class
		 inner join class_level on class.ID=class_level.classID
		 INNER join row_level ON class_level.levelID=row_level.Level_ID
		 WHERE class.Is_Active =1 AND row_level.ID IN(".$R_L_ID.")
		 GROUP BY class.ID
		");
	 if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
  }
  ///////////////////////////////////
   public function get_RowLevel_without_per($Lang)
  {

      		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT 
		 row_level.Level_ID         AS LevelID ,
		 row_level.Row_ID           AS RowID ,
		 row_level.Level_Name       AS LevelName ,
		 row_level.Row_Name         AS RowName ,
		 row_level.ID     As RowLevelID 
		 FROM 
		 row_level
		 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID
		 INNER JOIN student          ON student.R_L_ID           = row_level.ID
		 INNER JOIN contact          ON student.Contact_ID      = contact.ID  AND contact.Isactive =1 AND contact.SchoolID = ".$this->session->userdata('SchoolID')."
		 WHERE school_row_level.schoolID IN(".$this->session->userdata('SchoolID').")
		 AND row_level.IsActive = 1   
		 GROUP BY row_level.ID
		");
	 if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
  }
  /////////////////////////////
   public function get_RowLevel_admin_without_student($Lang)
  {

      		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT 
		 row_level.Level_ID         AS LevelID ,
		 row_level.Row_ID           AS RowID ,
		 row_level.Level_Name       AS LevelName ,
		 row_level.Row_Name         AS RowName ,
		 row_level.ID     As RowLevelID 
		 FROM 
		 row_level
		 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID
		 WHERE  row_level.IsActive = 1   
		 GROUP BY row_level.ID
		");
	 if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
  }
  public function get_emp_group_level( $Lang = NULL ,  $PerType = 0)
	{

		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT
		 contact.ID       AS ContactID , 
		 contact.Name     AS ContactName,
		 class.ID         AS ClassID,
		 subject.ID       AS SubjectID,
		 row_level.ID     AS RowLevelID
		 
		  FROM 
		 class_table
		 INNER JOIN contact          ON contact.ID               = class_table.EmpID
		 INNER JOIN row_level        ON class_table.RowLevelID   = row_level.ID
		 INNER JOIN subject          ON class_table.SubjectID    = subject.ID
		 INNER JOIN class            ON  class_table.ClassID    = class.ID
		 WHERE contact.SchoolID     IN('".$this->session->userdata('SchoolID')."')
		 AND  contact.Isactive = 1
		 AND  contact.Type='E'
		 AND  row_level.Level_ID IN (".$PerType.")
		 GROUP BY contact.ID
		 ")->result();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}
	}
	 public function get_emp_group_rowlevel( $Lang = NULL ,  $PerType = 0)
	{

		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT
		 contact.ID       AS ContactID , 
		 contact.Name     AS ContactName,
		 class.ID         AS ClassID,
		 subject.ID       AS SubjectID,
		 row_level.ID     AS RowLevelID
		  FROM 
		 class_table
		 INNER JOIN contact          ON contact.ID               = class_table.EmpID
		 INNER JOIN row_level        ON class_table.RowLevelID   = row_level.ID
		 INNER JOIN subject          ON class_table.SubjectID    = subject.ID
		 INNER JOIN class            ON  class_table.ClassID    = class.ID
		 WHERE contact.SchoolID IN('".$this->session->userdata('SchoolID')."')
		 AND  contact.Isactive = 1
		 AND  contact.Type='E'
		 AND  row_level.ID IN (".$PerType.")
		 GROUP BY contact.ID
		 ")->result();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}
	}
		public function get_emp_group_class($Lang = NULL ,  $RowLevel = 0  , $Class = 0 )
	{
	     $per_type = $this->db->query("SELECT employee.Type , employee.PerType FROM employee WHERE employee.Contact_ID = ".$this->session->userdata('id')." ")->row_array();
	     
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT
		 contact.ID       AS ContactID , 
		 contact.Name     AS ContactName,
		 class.ID         AS ClassID,
		 subject.ID       AS SubjectID,
		 row_level.ID     AS RowLevelID
		  FROM 
		 class_table
		 INNER JOIN contact          ON contact.ID               = class_table.EmpID
		 INNER JOIN row_level        ON class_table.RowLevelID   = row_level.ID
		 INNER JOIN subject          ON class_table.SubjectID    = subject.ID
		 INNER JOIN class            ON  class_table.ClassID    = class.ID
         WHERE contact.SchoolID IN('".$this->session->userdata('SchoolID')."')
		 AND  contact.Isactive = 1
		 AND  contact.Type='E'
		 AND row_level.ID IN (".$RowLevel.")
		 AND class.ID IN (".$Class.")
		 and FIND_IN_SET(CONCAT(RowLevelID,'|',ClassID) , '".$per_type['PerType']."')
		 GROUP BY contact.ID
		 ")->result();
		 

		 if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}
		
	}
		public function get_emp_group_subject($Lang = NULL ,$RowLevel ,$Subject)
	{
      $per_type = $this->db->query("SELECT employee.Type , employee.PerType FROM employee WHERE employee.Contact_ID = ".$this->session->userdata('id')." ")->row_array();
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		
		$query = $this->db->query("
		 SELECT
		 contact.ID       AS ContactID , 
		 contact.Name     AS ContactName,
		 class.ID         AS ClassID,
		 subject.ID       AS SubjectID,
		 row_level.ID     AS RowLevelID
		 FROM 
		 class_table
		 INNER JOIN contact          ON contact.ID               = class_table.EmpID
		 INNER JOIN row_level        ON class_table.RowLevelID   = row_level.ID
		 INNER JOIN subject          ON class_table.SubjectID    = subject.ID
		 INNER JOIN class            ON  class_table.ClassID    = class.ID
		 WHERE contact.SchoolID IN('".$this->session->userdata('SchoolID')."')
		 AND  contact.Isactive = 1
		 AND  contact.Type='E'
		 AND  row_level.ID IN (".$RowLevel.")
		 AND  subject.ID   IN (".$Subject.")
		 and FIND_IN_SET(CONCAT(RowLevelID,'|',SubjectID) ,'".$per_type['PerType']."')
		 GROUP BY contact.ID
		 ")->result();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}
	}
	/////////////////////////////
   public function get_emp($SchoolID = 0 )
	{
		$GetData = $this->db->query("
		SELECT 
		contact.ID    AS ContactID,
		contact.Name  AS ContactName
		FROM 
		contact 
		LEFT JOIN employee ON contact.ID = employee.Contact_ID
		WHERE contact.SchoolID IN('".$this->session->userdata('SchoolID')."') 
		AND contact.Isactive = 1
		AND contact.Type='E' 
        group by contact.ID
		");
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			   return FALSE ;
			 }
	}
	////////////////
	 public function get_emp_class_table()
	{
		 $GetData = $this->db->query("SELECT contact.ID    AS ContactID,contact.Name  AS ContactName
                                		FROM contact 
                                		INNER JOIN employee ON contact.ID = employee.Contact_ID
                                		WHERE contact.Isactive = 1 AND contact.Type='E' AND contact.SchoolID IN(".$this->session->userdata('SchoolID').") AND employee.jobTitleID=0
                                        group by contact.ID
		");
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			   return FALSE ;
			 }
	}
	//////////////////////////////
		
		public function get_emp_rowlevclas($Class ,$RowLevel)
	{
	    
         
		$GetData = $this->db->query("
		SELECT DISTINCT	contact.ID ,contact.Name  FROM `contact` 
        INNER JOIN employee ON contact.ID = employee.Contact_ID
        inner join school_row_level on  school_row_level.SchoolID=contact.SchoolID
        inner join class_table on  class_table.RowLevelID=school_row_level.RowLevelID and class_table.EmpID=contact.ID
        INNER JOIN row_level ON class_table.RowLevelID=row_level.ID
        INNER JOIN class     ON class_table.ClassID=class.ID
	    where contact.SchoolID = '".$this->session->userdata('SchoolID')."'
        AND  class.ID     		=$Class 
        AND class_table.RowLevelID ='".$RowLevel."'
		and contact.Type ='E'
		group by contact.ID
	
		");
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			   return FALSE ;
			 }
	}
	
	
		public function get_emp_rowlevclas_delete($level)
	{
	    
         if($level == 0 ) {$level = 'NULL' ; }
		$GetData = $this->db->query("
		SELECT DISTINCT	contact.ID ,contact.Name  FROM `temp_class_table` 
        
        inner join contact on contact.ID = temp_class_table.EmpID
        left JOIN row_level ON temp_class_table.RowLevelID=row_level.ID
        inner join school_row_level on  school_row_level.SchoolID=contact.SchoolID
	    where contact.SchoolID = '".$this->session->userdata('SchoolID')."'
	    and row_level.Level_ID=IFNULL($level,row_level.Level_ID)
		and contact.Type ='E'
		group by contact.ID
	
		");
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			   return FALSE ;
			 }
	}

  	public function get_emp_level($level)
	{
	    
         
		$GetData = $this->db->query("
		SELECT DISTINCT	contact.ID ,contact.Name  FROM `contact` 
        INNER JOIN employee ON contact.ID = employee.Contact_ID and FIND_IN_SET($level ,employee.LevelID)
        inner join school_row_level on  school_row_level.SchoolID=contact.SchoolID
	    where contact.SchoolID = '".$this->session->userdata('SchoolID')."'
		and contact.Type ='E'
		group by contact.ID
	
		");
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			   return FALSE ;
			 }
	}
	public function get_row_level_per_emp($emp_id)
	{
		$GetData = $this->db->query("
		SELECT 
		 level.ID         AS LevelID ,
		 row.ID           AS RowID ,
		 level.Name  AS LevelName ,
		 row.Name    AS RowName ,
		 row_level.ID     As RowLevelID 
		 FROM 
		 row_level
		 INNER JOIN row              ON row_level.Row_ID        = row.ID
		 INNER JOIN level            ON row_level.Level_ID      = level.ID
		 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID
         INNER JOIN contact ON contact.SchoolID = school_row_level.SchoolID
         INNER JOIN employee ON employee.Contact_ID = contact.ID AND FIND_IN_SET(row_level.Level_ID,employee.LevelID) AND contact.ID = $emp_id
		WHERE school_row_level.schoolID IN('".$this->session->userdata('SchoolID')."')
		 AND row_level.IsActive = 1   
		 GROUP BY row_level.ID
	
		");
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			   return FALSE ;
			 }
	}
	///////////////////////
	public function get_emp_by_level($level)
	{
	    
         if($level == 0 ) {$level = 'NULL' ; }
		$GetData = $this->db->query("
		SELECT DISTINCT	contact.ID ,contact.Name  FROM `contact` 
        INNER JOIN employee ON contact.ID = employee.Contact_ID 
        left join config_row_level_emp on  config_row_level_emp.empID=contact.ID
        left JOIN row_level ON config_row_level_emp.row_levelID=row_level.ID
        inner join school_row_level on  school_row_level.SchoolID=contact.SchoolID
	    where contact.SchoolID = '".$this->session->userdata('SchoolID')."'
	    and employee.LevelID=IFNULL($level,employee.LevelID)
		and contact.Type ='E'
		group by contact.ID
	
		");
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			   return FALSE ;
			 }
	}
	
	 public function get_class_new_scho($Lang = NULL , $RowLevelID = 0 ,$SchoolID=0)
	{
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		////////////////////////////////////////////////////////////////////////////////
		$query = $this->db->query("
		 SELECT
		  class.ID         AS ClassID ,
		 class.".$Name."  AS ClassName ,row_level.Level_Name AS LevelName,row_level.Row_Name AS RowName,row_level.ID AS RowLevelID
		 FROM class
		 inner join class_level on class.ID=class_level.classID
		 INNER join row_level ON class_level.levelID=row_level.Level_ID
		 INNER JOIN student on row_level.ID = student.R_L_ID AND class.ID=student.Class_ID
		 INNER JOIN contact          ON student.Contact_ID      = contact.ID  AND contact.Isactive =1 AND contact.SchoolID = ".$this->session->userdata('SchoolID')."
		 INNER JOIN school_class on   class.ID    = school_class.ClassID
		 WHERE class.Is_Active =1 AND row_level.ID=".$RowLevelID." AND contact.Isactive=1 
	     AND contact.SchoolID   IN(".$SchoolID.")
	     AND school_class.SchoolID = $SchoolID 
		 GROUP BY class.ID 
			")->result(); 

 
		if(sizeof($query)>0)
		{
			return $query ;
		}else{

			return false ;
		}
	}
	 public function get_Class_special_scho($Class,$row_level,$SchoolID)
  {
      
      	$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT
		 class.ID         AS ClassID ,
		 class.".$Name."  AS ClassName,row_level.Level_Name AS LevelName,row_level.Row_Name AS RowName,row_level.ID AS RowLevelID
		 FROM class
		 inner join class_level on class.ID=class_level.classID
		 INNER join row_level ON class_level.levelID=row_level.Level_ID
		 INNER JOIN school_class ON class.ID = school_class.ClassID 
		 AND school_class.SchoolID = $SchoolID 
		 AND contact.SchoolID   IN(".$SchoolID.")
		 INNER JOIN student        ON student.R_L_ID           = row_level.ID and student.Class_ID         = class.ID
		 INNER JOIN contact          ON student.Contact_ID      = contact.ID  AND contact.Isactive =1 AND contact.SchoolID = ".$this->session->userdata('SchoolID')."
		 WHERE class.Is_Active =1 AND class.ID IN (".$Class.") AND row_level.ID=".$row_level."
		 GROUP BY class.ID
		");
	 if($query->num_rows() >0){return $query->result();}else{return FALSE ;}
  }
  ////////////////////////////
	 public function get_emp_class_table_sub($RowLevelID,$idContact)
	 {
		 $Lang = $this->session->userdata('language');
    	 $LangArray = array("Name"=>"Name_Ar");
		 if((string)$Lang ==='english'){ $LangArray = array("Name"=>"Name_En"); }
		 $this->db->select('subject.Name,config_subject_emp.ID as config_ID,subject.ID  as ID ');
			$this->db->from('config_subject_emp');
			$this->db->join('subject','subject.ID = config_subject_emp.subjectID'); 
			if($this->ApiDbname  == "SchoolAccGheras"){
			$this->db->join('config_subject','subject.ID = config_subject.SubjectID and config_subject_emp.RowLevelID=config_subject.RowLevelID'); 
			$this->db->where('config_subject_emp.RowLevelID',$RowLevelID); 
			}
			
			$this->db->where('config_subject_emp.empID',$idContact); 
            $this->db->group_by('config_subject_emp.subjectID');
			$Result = $this->db->get(); 
			if($Result->num_rows()>0)
			{
				$ReturnResult = $Result->result() ;
				return $ReturnResult ;
			}else{
				return 0 ;
			}
	 }
	 ///////////////////////////////
	 public function get_all_student($Lang = NULL)
	 {
		 $NameArray = array("Level" => "Name AS LevelName", "row" => "Name AS RowName", "class" => "Name AS ClassName");
		 if ($Lang == "english") {
			 $NameArray = array("Level" => "Name_en AS LevelName", "row" => " Name_en AS RowName", "class" => "Name_en AS ClassName");
		 }
		 $query = $this->db->query("
			  SELECT
			  level.ID       AS LevelID,
			  row.ID         AS RowID,
			  class.ID       AS ClassID,
			  level." . $NameArray['Level'] . ",
			  row." . $NameArray['row'] . ",
			  row_level.ID   As RowLevelID ,
			  class.ID       As ClassID ,
			  class." . $NameArray['class'] . " ,
			  tb1.ID    AS StudentID,
			  tb1.Token AS StudentToken,
			  tb1.Name  AS StudentName,
			  tb2.ID    AS FatherID ,
			  tb2.Token AS FatherToken ,
			  tb2.Name  AS FatherName ,
			  CONCAT(tb1.Name,' ',tb2.Name) AS FullName
			  FROM contact As tb1
			  INNER JOIN student ON tb1.ID = student.Contact_ID
			  left JOIN contact AS tb2 ON student.Father_ID     = tb2.ID
			  INNER JOIN class            ON student.Class_ID    = class.ID
			  INNER JOIN row_level        ON student.R_L_ID      = row_level.ID
			  INNER JOIN row              ON row_level.Row_ID    = row.ID
			  INNER JOIN level            ON row_level.Level_ID  = level.ID
			  WHERE tb1.SchoolID = '" . $this->session->userdata('SchoolID') . "'
			  ORDER BY tb1.Name
			 ");
		 if ($query->num_rows() > 0) {
			 return $query->result();
		 } else {
			 return false;
		 }
	 }
	 public function get_level_student($Lang = NULL,  $PerType = NULL)
	 {
 
		 $NameArray = array("Level" => "Name AS LevelName", "row" => "Name AS RowName", "class" => "Name AS ClassName");
		 if ($Lang == "english") {
			 $NameArray = array("Level" => "Name_en AS LevelName", "row" => " Name_en AS RowName", "class" => "Name_en AS ClassName");
		 }
		 $query = $this->db->query("
			  SELECT distinct
			  level.ID       AS LevelID,
			  row.ID         AS RowID,
			  class.ID       AS ClassID,
			  level." . $NameArray['Level'] . ",
			  row." . $NameArray['row'] . ",
			  row_level.ID   As RowLevelID ,
			  class.ID       As ClassID ,
			  class." . $NameArray['class'] . " ,
			  tb1.ID    AS StudentID,
			  tb1.Token AS StudentToken,
			  tb1.Name  AS StudentName,
			  tb2.ID    AS ID ,
			  tb2.Token AS FatherToken ,
			  tb2.Name  AS Name ,
			  tb2.Phone  AS Phone ,
			  tb2.type  AS type ,
			  CONCAT(tb1.Name,' ',tb2.Name) AS FullName
			  FROM contact As tb1
			  INNER JOIN student ON tb1.ID = student.Contact_ID
			  INNER JOIN contact AS tb2 ON student.Father_ID     = tb2.ID
			  INNER JOIN class            ON student.Class_ID    = class.ID
			  INNER JOIN row_level        ON student.R_L_ID      = row_level.ID
			  INNER JOIN row              ON row_level.Row_ID    = row.ID
			  INNER JOIN level            ON row_level.Level_ID  = level.ID
			  WHERE tb1.SchoolID = '" . $this->session->userdata('SchoolID') . "'
			  AND level.ID IN (" . $PerType . ")
			  ORDER BY tb1.Name
			  
			 ");
 
		 if ($query->num_rows() > 0) {
			 return $query->result();
		 } else {
			 return false;
		 }
	 }
	 /////////////////
	 public function get_rowlevel_student($Lang = NULL,  $PerType = NULL)
	 {
 
		 $NameArray = array("Level" => "Name AS LevelName", "row" => "Name AS RowName", "class" => "Name AS ClassName");
		 if ($Lang == "english") {
			 $NameArray = array("Level" => "Name_en AS LevelName", "row" => " Name_en AS RowName", "class" => "Name_en AS ClassName");
		 }
		 $query = $this->db->query("
			  SELECT distinct
			  level.ID       AS LevelID,
			  row.ID         AS RowID,
			  class.ID       AS ClassID,
			  level." . $NameArray['Level'] . ",
			  row." . $NameArray['row'] . ",
			  row_level.ID   As RowLevelID ,
			  class.ID       As ClassID ,
			  class." . $NameArray['class'] . " ,
			  tb1.ID    AS StudentID,
			  tb1.Token AS StudentToken,
			  tb1.Name  AS StudentName,
			  tb2.ID    AS ID ,
			  tb2.Token AS FatherToken ,
			  tb2.Name  AS Name ,
			  tb2.Phone  AS Phone ,
			  tb2.type  AS type ,
			  CONCAT(tb1.Name,' ',tb2.Name) AS FullName
			  FROM contact As tb1
			  INNER JOIN student ON tb1.ID = student.Contact_ID
			  INNER JOIN contact AS tb2 ON student.Father_ID     = tb2.ID
			  INNER JOIN class            ON student.Class_ID    = class.ID
			  INNER JOIN row_level        ON student.R_L_ID      = row_level.ID
			  INNER JOIN row              ON row_level.Row_ID    = row.ID
			  INNER JOIN level            ON row_level.Level_ID  = level.ID
			  WHERE tb1.SchoolID = '" . $this->session->userdata('SchoolID') . "'
			  AND row_level.ID IN (" . $PerType . ")
			  ORDER BY tb1.Name
			  
			 ");
		 if ($query->num_rows() > 0) {
			 return $query->result();
		 } else {
			 return false;
		 }
	 }
	 /////////////////
	 public function get_student_group_class($Lang = NULL,  $RowLevel = NULL, $Class = NULL)
	 {
		
		 $NameArray = array("Level" => "Name AS LevelName", "row" => "Name AS RowName", "class" => "Name AS ClassName");
		 if ($Lang == "english") {
			 $NameArray = array("Level" => "Name_en AS LevelName", "row" => " Name_en AS RowName", "class" => "Name_en AS ClassName");
		 }
		 $query = $this->db->query("
			  SELECT distinct
			  level.ID       AS LevelID,
			  row.ID         AS RowID,
			  class.ID       AS ClassID,
			  level." . $NameArray['Level'] . ",
			  row." . $NameArray['row'] . ",
			  row_level.ID   As RowLevelID ,
			  class.ID       As ClassID ,
			  class." . $NameArray['class'] . " ,
			  tb1.ID    AS StudentID,
			  tb1.Token AS StudentToken,
			  tb1.Name  AS StudentName,
			  tb2.ID    AS ID ,
			  tb2.Token AS FatherToken ,
			  tb2.Name  AS Name ,
			  tb2.Phone  AS Phone ,
			  tb2.type  AS type ,
			  CONCAT(tb1.Name,' ',tb2.Name) AS FullName
			  FROM contact As tb1
			  INNER JOIN student ON tb1.ID = student.Contact_ID
			  INNER JOIN contact AS tb2 ON student.Father_ID     = tb2.ID
			  INNER JOIN class            ON student.Class_ID    = class.ID
			  INNER JOIN row_level        ON student.R_L_ID      = row_level.ID
			  INNER JOIN row              ON row_level.Row_ID    = row.ID
			  INNER JOIN level            ON row_level.Level_ID  = level.ID
			  
			  WHERE tb1.SchoolID = '" . $this->session->userdata('SchoolID') . "'
			  AND row_level.ID IN (" . $RowLevel . ")
			  AND class.ID IN (" . $Class . ")
			  ORDER BY tb1.Name
			  
			 ");
		 if ($query->num_rows() > 0) {
			 return $query->result();
		 } else {
			 return false;
		 }
	 }
	 /////////////////
	 public function get_student_group_subject($Lang = NULL, $RowLevel, $Subject)
	 {
		 
		 $NameArray = array("Level" => "Name AS LevelName", "row" => "Name AS RowName", "class" => "Name AS ClassName");
		 if ($Lang == "english") {
			 $NameArray = array("Level" => "Name_en AS LevelName", "row" => " Name_en AS RowName", "class" => "Name_en AS ClassName");
		 }
		 $query = $this->db->query("
			  SELECT distinct
			  level.ID       AS LevelID,
			  row.ID         AS RowID,
			  class.ID       AS ClassID,
			  level." . $NameArray['Level'] . ",
			  row." . $NameArray['row'] . ",
			  row_level.ID   As RowLevelID ,
			  class.ID       As ClassID ,
			  class." . $NameArray['class'] . " ,
			  tb1.ID    AS StudentID,
			  tb1.Token AS StudentToken,
			  tb1.Name  AS StudentName,
			  tb2.ID    AS ID ,
			  tb2.Token AS FatherToken ,
			  tb2.Name  AS Name ,
			  tb2.Phone  AS Phone ,
			  tb2.type  AS type ,
			  CONCAT(tb1.Name,' ',tb2.Name) AS FullName 
			  FROM contact As tb1
			  
			  INNER JOIN student ON tb1.ID = student.Contact_ID
			  INNER JOIN contact AS tb2 ON student.Father_ID     = tb2.ID
			  INNER JOIN class            ON student.Class_ID    = class.ID
			  INNER JOIN row_level        ON student.R_L_ID      = row_level.ID
			  INNER JOIN row              ON row_level.Row_ID    = row.ID
			  INNER JOIN level            ON row_level.Level_ID  = level.ID
		 
			  WHERE tb1.SchoolID = '" . $this->session->userdata('SchoolID') . "'
			  AND row_level.ID  IN (" . $RowLevel . ")
			  GROUP BY tb1.ID
			  ORDER BY tb1.Name
			  
			 ");
		 if ($query->num_rows() > 0) {
			 return $query->result();
		 } else {
			 return false;
		 }
	 }
 
 }