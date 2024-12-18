<?php
class Zoom_Model extends CI_Model 
 {
	private $Date            = '' ;
	private $Encryptkey      = '' ;
	private $Token           = '' ;
	function __construct()
    {
	   parent::__construct();
	   $this->Date       = date('Y-m-d H:i:s');
	   $this->Encryptkey = $this->config->item('encryption_key');
    }
    
    //////get_all_class
	public function get_all_level($Lang = NULL ,$ID=0)
	{
	     if($ID == 0 )       { $ID    = 'NULL'; }
		if($Lang == 'arabic')
		{
			$query = $this->db->query("
			 SELECT 
			 level.ID       AS LevelID,
			 level.Name     AS LevelName
			 FROM 
			 row_level
			 INNER JOIN level            ON row_level.Level_ID      = level.ID
			 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = IFNULL ( $ID ,school_row_level.schoolID )
			 GROUP BY level.ID 
			");
		}
		else{
			   $query = $this->db->query("
				 SELECT 
				 level.ID       AS LevelID,
				 level.Name_en  AS LevelName
				 FROM 
				 row_level
    			 INNER JOIN level            ON row_level.Level_ID      = level.ID
    			 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = IFNULL ( $ID ,school_row_level.schoolID )
    			 GROUP BY level.ID
				");
			}
			  if($query->num_rows() >0)
			  {return $query->result();}else{return FALSE ;}
	}///////////////////////////////check_class_table_plan_week
	
	//////get_all_class
	public function get_all_row($Lang = NULL ,$schoolId=0,$ID=0)
	{
	     if($schoolId == 0 )       { $schoolId    = 'NULL'; }
	     if($ID == 0 )       { $ID    = 'NULL'; }
		if($Lang == 'arabic')
		{
			$query = $this->db->query("
			 SELECT 
			 row.ID         AS RowID,
			 level.ID       AS LevelID,
			 row.Name       AS RowName
			 FROM 
			 row_level
			 INNER JOIN row              ON row_level.Row_ID        = row.ID
			 INNER JOIN level            ON row_level.Level_ID      = level.ID
			 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = IFNULL ( $schoolId ,school_row_level.schoolID )
			 where
			 level.ID	= IFNULL ( $ID ,level.ID )
			 GROUP BY row.ID
			");
		}
		else{
			   $query = $this->db->query("
				 SELECT 
				 row.ID         AS RowID,
				 level.ID       AS LevelID,
				 row.Name_en    AS RowName
				 FROM 
				 row_level
			     INNER JOIN row              ON row_level.Row_ID        = row.ID
			     INNER JOIN level            ON row_level.Level_ID      = level.ID
			     INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = IFNULL ( $schoolId ,school_row_level.schoolID )
			     where
			      level.ID	= IFNULL ( $ID ,level.ID )
			     GROUP BY row.ID
				");
			}
			  if($query->num_rows() >0)
			  {return $query->result();}else{return FALSE ;}
	}
	
	public function get_all_class($Lang = NULL ,$schoolId=0,$levelID =0,$RowID =0)
	{
	    if($schoolId == 0 )       { $schoolId    = 'NULL'; }
	     if($levelID == 0 )       { $levelID    = 'NULL'; }
	     if($RowID == 0 )       { $RowID    = 'NULL'; }
		if($Lang == 'arabic')
		{
			$query = $this->db->query("
			 SELECT 
			 class_table.ID AS ClassTableID ,
			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 level.Name     AS LevelName,
			 row.Name       AS RowName,
			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
			 class.Name     AS ClassName
			 FROM 
			 class_table
			 INNER JOIN base_class_table ON class_table.BaseTableID = base_class_table.ID
			 INNER JOIN class            ON class_table.ClassID     = class.ID
			 INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID        = row.ID
			 INNER JOIN level            ON row_level.Level_ID      = level.ID
			 INNER JOIN school_class ON class.ID = school_class.ClassID  AND school_class.SchoolID = IFNULL ($schoolId ,school_class.SchoolID )
			 WHERE 
			 level.ID	= IFNULL ( $levelID ,level.ID )
			 AND row.ID	= IFNULL ( $RowID ,row.ID )
			 AND base_class_table.IsActive = 1 
			 GROUP BY  class.ID
			");
		}
		else{
			   $query = $this->db->query("
				 SELECT 
				 class_table.ID AS ClassTableID ,
				 level.ID       AS LevelID,
				 row.ID         AS RowID,
				 level.Name_en  AS LevelName,
				 row.Name_en    AS RowName,
				 row_level.ID   As RowLevelID ,
				 class.ID       As ClassID ,
				 class.Name_en  AS ClassName
				 FROM 
				 class_table
				 INNER JOIN base_class_table ON class_table.BaseTableID = base_class_table.ID
				 INNER JOIN class            ON class_table.ClassID     = class.ID
				 INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
				 INNER JOIN row              ON row_level.Row_ID        = row.ID
				 INNER JOIN level            ON row_level.Level_ID      = level.ID
				 INNER JOIN school_class ON class.ID = school_class.ClassID  AND school_class.SchoolID  = IFNULL ($schoolId ,school_class.SchoolID  )
				 WHERE 
				 level.ID	= IFNULL ( $levelID ,level.ID )
			     AND row.ID	= IFNULL ( $RowID ,row.ID )
				 AND base_class_table.IsActive = 1 
				 GROUP BY  class.ID
				");
			}
			  if($query->num_rows() >0)
			  {return $query->result();}else{return FALSE ;}
	}
	 public function get_class_data($Data = NULL)
    {
        if($Data!=NULL){
        $query = $this->db->query("select * from class WHERE ID IN (".$Data.")  ")->result();
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
        }
    }
	
   public function Get_mettingids_by_emp_id()
    {
        $idContact = (int)$this->session->userdata('id');
        $query = $this->db->query("select zoom_meetings.*,zoom_rooms.name as roomname
        from zoom_meetings 
        inner join zoom_premission on zoom_meetings.group_id = zoom_premission.id 
        inner join zoom_rooms on zoom_meetings.room=zoom_rooms.email 
        where   zoom_meetings.teacherid = $idContact and  is_deleted=0  GROUP BY zoom_meetings.id limit 50  ")->result();
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
    
    public function get_zoom_by_id($ID = 0 )
    {
        $query = $this->db->query("select * from zoom_premission where ID = '".$ID."' ")->row_array();
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
    	
// 	 public function get_permission()
//     {
//         $query = $this->db->query("select zoom_premission.* , contact.Name As contactName ,school_details.SchoolName ,level.Name  As levelName , row.Name AS RowName
//         from zoom_premission
//         INNER JOIN contact ON zoom_premission.EmpID = contact.ID  
//         INNER JOIN school_details ON zoom_premission.SchoolID = school_details.ID
//         INNER JOIN level            ON zoom_premission.LevelID      = level.ID
//         INNER JOIN row              ON zoom_premission.RowID        = row.ID
//         where zoom_premission.IsUpdate = 1 
//         ")->result();
//         if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
//     }
    public function get_permission()
    {
        $types = $this->session->userdata('type');
        if($types=="U"){
        $query = $this->db->query("select zoom_premission.* , contact.Name As contactName ,school_details.SchoolName 
        from zoom_premission
        INNER JOIN contact ON zoom_premission.EmpID = contact.ID  
        INNER JOIN school_details ON contact.SchoolID   = school_details.ID
        where zoom_premission.IsUpdate = 1
        group by zoom_premission.ID order by zoom_premission.ID
        ")->result();}
        else{
            $idContact = (int)$this->session->userdata('id');
        $query = $this->db->query("select zoom_premission.* , contact.Name As contactName ,school_details.SchoolName 
        from zoom_premission
        INNER JOIN contact ON zoom_premission.EmpID = contact.ID  
        INNER JOIN school_details ON zoom_premission.SchoolID = school_details.ID
        where zoom_premission.IsUpdate = 1 
        AND (zoom_premission.EmpID=$idContact OR zoom_premission.ConactId=$idContact)
        ")->result();
        }
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
    
     public function add_permission($Data = array())
    {
         $SchoolID = (int)$this->session->userdata('SchoolID');
         $idContact = (int)$this->session->userdata('id');
        $this->db->query("
        INSERT INTO zoom_premission
        SET
        Name         = '".$Data['Name']."' ,
        EmpID         = '".$Data['EmpID']."' ,
        SchoolID     = '".$SchoolID."' ,
        LevelID       = '".$Data['LevelID']."' ,
        RowID      = '".$Data['RowID']."' ,
        ClassID      = '".$Data['ClassID']."' ,
         ConactId     = '".$idContact."' ,
        Token         = '".$this->Token."' ,
        Date          = '".$this->Date."',
        IsActive      = 1 ,
        IsUpdate	  = 1
         ");
        return TRUE ;
    }
     public function edit_permission($Data = array())
    {
         $SchoolID = (int)$this->session->userdata('SchoolID');
         $idContact = (int)$this->session->userdata('id');
        $this->db->query("
        UPDATE zoom_premission
        SET
        Name         = '".$Data['Name']."' ,
        EmpID         = '".$Data['EmpID']."' ,
        SchoolID     = '".$SchoolID."' ,
        LevelID       = '".$Data['LevelID']."' ,
        RowID      = '".$Data['RowID']."' ,
        ClassID      = '".$Data['ClassID']."' ,
        ConactId     = '".$idContact."' ,
        Token         = '".$this->Token."' ,
        Date          = '".$this->Date."',
        IsActive      = 1 ,
        IsUpdate	  = 1
        WHERE ID = '".$Data['ID']."'
         ");
        return TRUE ;
    }
    public function delete_permission($ID)
    {
        $this->db->query("
       DELETE from zoom_premission 
        WHERE ID = '".$ID."'
         ");
        return TRUE ;
    }
     public function add_permission1($Data=array())
    {
     
      extract($Data);
      
    //  $to_user=$Data['to_user'];
     
           $Contact_ID= ltrim($Contact_ID, ',');
           $Contact_ID= ltrim($Contact_ID, ', ');
      $query=array(  
        
        "Contact_ID"        => $Contact_ID,
        "Group_ID"           =>$Group_ID
        
         );
      
             $query1 = $this->db->query("select * from Zoom_Details WHERE  	Group_ID = $Group_ID ")->result();
        if(sizeof($query1)> 0 ){  
    	 $Contact_ID_add=','.$Contact_ID;
   //  $Contact_ID_add=	 str_replace(",,", ",",  $Contact_ID_add);
   
   // if(substr( $Contact_ID_add, 1)==','){
           $Contact_ID_add= ltrim($Contact_ID_add, ',');
         //  $Contact_ID_add= ltrim($Contact_ID_add, ', ');
    // }
   // echo  $Contact_ID_add;die;
   
   $Contact_ID_add=','.$Contact_ID_add;
    		$sql = "update `Zoom_Details` set Contact_ID =  CONCAT(Contact_ID,  '$Contact_ID_add') where Group_ID = $Group_ID  ";
			$this->db->query($sql); 
			 return TRUE;
                   }else
                    { if($this->db->insert('Zoom_Details',$query)){return $query;}else{return FALSE ;}
                    }
       
      
    }
    public function Get_mettingidsxxx()
    {
        $idContact = (int)$this->session->userdata('id');
        $query = $this->db->query("select MeetingId
        from zoom_premission
        INNER JOIN Zoom_Details ON zoom_premission.ID = Zoom_Details.Group_ID
        where
        (zoom_premission.EmpID=$idContact
        OR  FIND_IN_SET('".$idContact."', Zoom_Details.Contact_ID))
        AND zoom_premission.MeetingId IS NOT NULL
        GROUP by MeetingId
        ")->result();
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
    public function Get_mettingids()
    {
        $idContact = (int)$this->session->userdata('id');
        $query = $this->db->query("select meeting_id
        from zoom_meetings 
        where teacherid=$idContact 
        AND is_deleted=0 
        ")->result();
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
    public function Get_mettingids11()
    {
        $idContact = (int)$this->session->userdata('id');
        $query = $this->db->query("select MeetingId
        from zoom_premission
        INNER JOIN Zoom_Details ON zoom_premission.ID = Zoom_Details.Group_ID
        where
        (zoom_premission.EmpID=$idContact)
        AND zoom_premission.MeetingId IS NOT NULL
        GROUP by MeetingId
        ")->result();
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
    public function Get_user_groups_ids()
    {
        $idContact = (int)$this->session->userdata('id');
        $query = $this->db->query("select Group_ID
        from Zoom_Details  
        where   FIND_IN_SET('".$idContact."', Zoom_Details.Contact_ID) 
        ")->result();
      //   echo $this->db->last_query();die;
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
    public function Get_attend_mettingids($group_id)
    {
	    foreach($group_id as $k=>$id){
	     $id1=$id->Group_ID;
	      
        $group_ids[$k]= $id1;
        
	    } 
        
        $group_id=implode(",", $group_ids);
         if($group_id){
        $idContact = (int)$this->session->userdata('id');
        $query = $this->db->query("select Meeting_Id
        from zoom_meetings  
        where group_id IN ($group_id) 
        ")->result();  
         }else{
          
        }
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
     public function show_details($ID)
    {
        extract($Data);
        
      $query = $this->db->query("select Zoom_Details.* , zoom_premission.Name As Group_Name,Zoom_Details.Contact_ID as contactid ,contact.Name as contactName
        from Zoom_Details
        INNER JOIN zoom_premission ON zoom_premission.ID = Zoom_Details.Group_ID 
        INNER JOIN contact ON zoom_premission.EmpID = contact.ID 
        where Zoom_Details.Group_ID  = $ID
       
        
        
        ")->result();
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
      
    }
    public function delete_meeting($ID)
    {
        $this->db->query("
       DELETE from zoom_premission 
        WHERE ID = '".$ID."'
         ");
        return TRUE ;
    }
    public function delete_meeting1($ID)
    {
        $this->db->query("
       DELETE from Zoom_Details 
        WHERE Group_ID = '".$ID."'
         ");
        return TRUE ;
    }
    
    		public function get_student($ID, $Lang = NULL)
	{
		$NameArray = array("Level"=>"Name AS LevelName" ,"row"=>"Name AS RowName" , "class"=>"Name AS ClassName");
		if($Lang == "english")
		{
			$NameArray = array("Level"=>"Name_en AS LevelName" ,"row"=>" Name_en AS RowName" , "class"=>"Name_en AS ClassName");
		}
		$query = $this->db->query("
			 SELECT
			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
			 level.".$NameArray['Level'].",
			 row.".$NameArray['row'].",
			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
			 class.".$NameArray['class']." ,
			 tb1.ID AS StudentID,
			 tb1.User_Name AS StudentUserName,
			 tb1.Name AS StudentName,
			 tb2.ID AS FatherID ,
			 tb2.User_Name AS FatherUserName,
		     tb2.Name AS FatherName ,
			 case when LENGTH(tb1.Name) > 15 then tb1.Name Else  CONCAT(tb1.Name,' ',tb2.Name) END AS FullName
			 FROM contact As tb1
			 INNER JOIN student ON tb1.ID = student.Contact_ID
			 INNER JOIN contact AS tb2 ON student.Father_ID     = tb2.ID
			 INNER JOIN class            ON student.Class_ID    = class.ID
			 INNER JOIN row_level        ON student.R_L_ID      = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID    = row.ID
			 INNER JOIN level            ON row_level.Level_ID  = level.ID
			  where tb1.ID =  $ID
			");//print_r($IDs);die;
			if($query->num_rows()>0)
			{
			   return $query->result();	
			}else{return false ;}
			
	}
   public function get_zoom_token()
        {//$SchoolID= $this->session->userdata('SchoolID') ; 
            $query = $this->db->query("select * 
            from zoom_settings where id = 1

            ")->result();
             if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
            
        }
  public function add_zoom_meetings($Data = array(),$meetingId,$room)
    { 
         $SchoolID = (int)$this->session->userdata('SchoolID');
         $idContact = (int)$this->session->userdata('id');
         
         
        $this->db->query("
        INSERT INTO zoom_meetings
        SET
        meeting_id         = '".$meetingId."' ,
        room         = '".$room."' ,
        topic         = '".$Data['topic']."' ,
        type         = '".$Data['type']."' ,  
        start_time       = '".$Data['start_time']."' ,
        duration      = '".$Data['duration']."' ,
        schedule_for      = '".$Data['schedule_for']."' ,
        timezone      = '".$Data['timezone']."' ,
        password      = '".$Data['password']."' ,
        agenda      = '".$Data['agenda']."' , 
        recurrence_type      = '".$Data['recurrence']['type']."' , 
        recurrence_repeat_interval      = '".$Data['recurrence']['repeat_interval']."' , 
        recurrence_end_times     = '".$Data['recurrence']['end_times']."' ,  
        levele_ID     = '".$Data['levele_ID']."' ,  
        RowLevele_ID     = '".$Data['RowLevele_ID']."' ,  
        SubjectID     = '".$Data['Subject_ID']."' ,  
        teacherid     = '".$Data['teacherid']."' ,  
        group_id     = '".$Data['group_id']."' ,  
        
         is_deleted     = '0' ,  
         created_by     = '".$idContact."'   
         ");
        return TRUE ;
    }

        public function get_rooms()
        {
             $types = $this->session->userdata('type');
              if($types=="U"){
            $query = $this->db->query("select * 
            from zoom_rooms

            ")->result();
              }
              else{
              $ID= $this->session->userdata('id');   
            $query1 = $this->db->query("select rooms from zoom_rooms_employee where empid=$ID")->row_array();
            $rooms=$query1['rooms'];
            if($rooms){
            $query=$this->db->query("SELECT * FROM `zoom_rooms` WHERE `id` IN($rooms)")->result();
            }else{}
              }
             if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
            
        }
        
		public function getRowLevel($Lang = NULL)
	{
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT
		 level.ID         AS LevelID ,
		 row.ID           AS RowID ,
		 level.".$Name."  AS LevelName ,
		 row.".$Name."    AS RowName ,
		 row_level.ID     As RowLevelID 
		 FROM 
		 row_level
		 INNER JOIN row              ON row_level.Row_ID        = row.ID
		 INNER JOIN level            ON row_level.Level_ID      = level.ID
		 INNER JOIN class_table            ON row_level.ID      = class_table.RowLevelID
		 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = '".$this->session->userdata('SchoolID')."' 
		 WHERE level.Is_Active = 1  and EmpID ='".(int)$this->session->userdata('id') ."'
		 ")->result();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}
	}

		public function getSubject($Lang = NULL)
	{
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT
		DISTINCT  subject.ID         AS SubjectID , 
		 subject.".$Name."  AS SubjectName   
		 FROM 
		 subject join class_table on subject.ID = class_table.SubjectID  WHERE   subject.Is_Active = 1  and EmpID ='".(int)$this->session->userdata('id') ."'
		 ")->result();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}
	}
	
 
}