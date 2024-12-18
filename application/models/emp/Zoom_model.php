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
    ///////////////////////////////////////
    public function get_permission()
    {
        $idContact = (int)$this->session->userdata('id');
        
        $query = $this->db->query("select zoom_premission.* , contact.Name As contactName 
                                   from zoom_premission
                                   INNER JOIN contact ON zoom_premission.Created_by = contact.ID  or zoom_premission.ConactId = contact.ID
                                   where zoom_premission.IsUpdate = 1 
                                   AND zoom_premission.SchoolID='".$this->session->userdata('SchoolID')."'
                                   group by zoom_premission.ID order by zoom_premission.ID DESC
                                   ")->result();
       
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
    //////////////////////////////////////////
     public function add_permission($Data = array())
    {
         $SchoolID      = (int)$this->session->userdata('SchoolID');
         $idContact     = (int)$this->session->userdata('id');
        $this->db->query("INSERT INTO zoom_premission
                          SET
                          Name          = '".$Data['Name']."' ,
                          EmpID         = '".$idContact."' ,
                          SchoolID      = '".$SchoolID."' ,
                          ConactId      = '".$idContact."' ,
                          Token         = '".$this->Token."' ,
                          Date          = '".$Data['date']."',
                          Created_by    = '".$idContact."',
                          Created_at    = '".$Data['date']."',
                          IsActive      = 1 ,
                          IsUpdate	  = 1
                           ");
                          return TRUE ;
    }
    ////////////////////////////////////
     public function edit_permission($Data = array())
    {
         $SchoolID     = (int)$this->session->userdata('SchoolID');
         $idContact    = (int)$this->session->userdata('id');
        $this->db->query("UPDATE zoom_premission
                          SET
                          Name          = '".$Data['Name']."' ,
                          EmpID         = '".$Data['EmpID']."' ,
                          SchoolID      = '".$SchoolID."' ,
                          ConactId      = '".$idContact."' ,
                          Token         = '".$this->Token."' ,
                          Date          = '".$this->Date."',
                          Updated_by    = '".$idContact."',
                          Updated_at    = '".$this->Date."',
                          IsActive      = 1 ,
                          IsUpdate	  = 1
                          WHERE ID       = '".$Data['ID']."'
                           ");
                          return TRUE ;
    }
    /////////////////////////////////////////////
    public function add_members_group($Data=array())
    {
     
      extract($Data);
           $Contact_ID= ltrim($Contact_ID, ',');
      $query=array(  
        
        "Contact_ID"        => $Contact_ID,
        "Group_ID"           =>$Group_ID 
        
         );
      
        $query1 = $this->db->query("select * from Zoom_Details WHERE  	Group_ID = ".$Group_ID." ")->result();
        if(sizeof($query1)> 0 ){  
    	  $Contact_ID_add=','.$Contact_ID;
          $Contact_ID_add= ltrim($Contact_ID_add, ',');
          $Contact_ID_add=','.$Contact_ID_add;
    	  $sql = "update `Zoom_Details` set Contact_ID =  CONCAT(Contact_ID,  '$Contact_ID_add') where Group_ID = $Group_ID  ";
		  $this->db->query($sql); 
			 return TRUE;
                   }else
                    { if($this->db->insert('Zoom_Details',$query)){return $query;}else{return FALSE ;}
                    }
       
      
    }
    //////////////////////////////////////////////
    public function add_members_group_r_l_c($category,$Data=array())
    {
     
      extract($Data);
      
      if($category=='levels'){
       $query_level=array(  
        
        "LevelID"              => $Level['Level_ID'],
        "ZoomPermissionsID"    =>$Level['Group_ID']
        
         );
         if($this->db->insert('Zoom_Permissions_Levels',$query_level)){return $query_level;}else{return FALSE ;}
      }
      elseif($category=='row'){
       $query_Row_Level=array(  
        
        "RowLevelID"           => $RowLevel['RowLevel'],
        "ZoomPermissionsID"    =>$RowLevel['Group_ID']
        
         );
         if($this->db->insert('Zoom_Permissions_RowLevel',$query_Row_Level)){return $query_Row_Level;}else{return FALSE ;}
      }
       elseif($category=='class' || $category=='E-class' || $category=='U-class'){
       $query_class=array(  
         'ClassID'             => $class['class'],
        "RowLevelID"           => $class['RowLevels'],
        "ZoomPermissionsID"    => $class['Group_ID']
        
         );
         if($this->db->insert('Zoom_Permissions_Class',$query_class)){return $query_class;}else{return FALSE ;}
      }
    }
    ////////////////////////////////////////////////
     public function show_details($ID)
    {
        
      extract($Data);
      $query = $this->db->query("select zoom_premission.Name AS GroupName,contact.Name as contactName 
                                 from zoom_premission 
                                 INNER JOIN contact ON zoom_premission.ConactId = contact.ID 
                                 where zoom_premission.ID =".$ID." ")->result();
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
      
    }
    /////////////////////////////////////
     public function get_student_new($Group_ID)
	{
        $Lang=$this->session->userdata('language');
		$query = $this->db->query("SELECT DISTINCT contact.ID as Contact_ID ,
         CASE
            WHEN '$Lang' = 'english' and contact.Name_en IS not NULL and contact.Name_en !=' ' THEN contact.Name_en
            ELSE contact.Name
            END AS StudentName ,
         contact.Type,contact.User_Name AS StudentUserName 
		                           FROM contact 
                                   INNER JOIN  vw_zoom_premission_per_contact_select AS T on contact.ID = T.contactID and contact.Isactive != 0  AND  contact.Name !='' 
                                   and contact.ID not in(select Contact_ID from Zoom_Permissions_ExcludedContacts where ZoomPermissionsID=".$Group_ID.")
                                   WHERE ZoomPremissionID=".$Group_ID." 
                                   order by StudentName asc");	
			
			  if($query->num_rows()>0)
			{
			   return $query->result();	
			}else{return false ;}	
		
			
	}
	//////////////////////////////////////////////
	 public function delete_members_group($ID)
    {
        $this->db->query(" DELETE from Zoom_Details WHERE Group_ID = '".$ID."'");
        return TRUE ;
    }
    //////////////////////////
     public function delete_group_level($ID)
    {
        $this->db->query("DELETE from  Zoom_Permissions_Levels WHERE ZoomPermissionsID = '".$ID."' ");
        return TRUE ;
    }
    ///////////////////////////////
     public function delete_group_row($ID)
    {
        $this->db->query("DELETE from  Zoom_Permissions_RowLevel WHERE ZoomPermissionsID = '".$ID."' ");
        return TRUE ;
    }
    ////////////////////////////
     public function delete_group_class($ID)
    {
        $this->db->query("DELETE from   Zoom_Permissions_Class WHERE ZoomPermissionsID = '".$ID."' ");
        return TRUE ;
    }
    //////////////////////////////
    public function delete_group_ExcludedContacts($ID)
    {
        $this->db->query("DELETE from  Zoom_Permissions_ExcludedContacts WHERE ZoomPermissionsID = '".$ID."' ");
        return TRUE ;
    }
    /////////////////////////////
    public function delete_group($ID)
    {
        $this->db->query(" DELETE from zoom_premission WHERE ID = '".$ID."' ");
        return TRUE ;
    }
    //////////////////////////////////////
    public function get_student_deleted($Group_ID)
	{
        $Lang=$this->session->userdata('language');
	    $query=$this->db->query("select DISTINCT contact.ID as Contact_ID , 
        CASE
        WHEN '$Lang' = 'english' and contact.Name_en IS not NULL and contact.Name_en !=' ' THEN contact.Name_en
        ELSE contact.Name
        END AS StudentName ,
        contact.Type,contact.User_Name AS StudentUserName
	                             from contact
	                             INNER JOIN Zoom_Permissions_ExcludedContacts ON contact.ID =Zoom_Permissions_ExcludedContacts.Contact_ID
	                             where ZoomPermissionsID=".$Group_ID."
                                 order by StudentName asc
                                 ");
			  if($query->num_rows()>0)
			{
			   return $query->result();	
			}else{return false ;}	
		
			
	}
	/////////////////////////////////////
	public function Get_mettingids_by_emp_id()
    {
        $idContact = (int)$this->session->userdata('id');
        $query = $this->db->query("select zoom_meetings.*,zoom_rooms.name as roomname
                                   from zoom_meetings 
                                   inner join zoom_premission on zoom_meetings.group_id = zoom_premission.id 
                                   inner join zoom_rooms on zoom_meetings.room_id=zoom_rooms.id 
                                   LEFT join Zoom_Details ON zoom_meetings.group_id = Zoom_Details.Group_ID
                                   where (zoom_meetings.teacherid = $idContact OR FIND_IN_SET($idContact, Zoom_Details.Contact_ID)) and is_deleted=0 and date(start_time) = CURDATE() GROUP BY zoom_meetings.id ORDER BY zoom_meetings.start_time DESC  ")->result();
        if (sizeof($query) > 0) {
            return $query;
        } else {
            return FALSE;
        }
    }
    //////////////////////////////////////
     public function get_rooms()
        {
            
            $ID        = $this->session->userdata('id');   
            $query1    = $this->db->query("select rooms from zoom_rooms_employee where empid=$ID")->row_array();
            $rooms=$query1['rooms'];
            if($rooms){
                 $query=$this->db->query("SELECT * FROM `zoom_rooms` WHERE `id` IN($rooms)")->result();
            }else{}
             
             if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
            
        }
        ///////////////////////////////////////////////
	public function getRowLevel($Lang = NULL)
	{
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("SELECT row_level.Level_ID    AS LevelID ,row_level.Row_ID  AS RowID ,row_level.Level_Name  AS LevelName ,row_level.Row_Name AS RowName ,row_level.ID As RowLevelID 
		                           FROM row_level
		                           INNER JOIN class_table            ON row_level.ID      = class_table.RowLevelID
		                           INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = '".$this->session->userdata('SchoolID')."' 
		                           WHERE row_level.IsActive = 1  and EmpID ='".(int)$this->session->userdata('id') ."'
		                           group by row_level.ID
		                           ")->result();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}
	}

////////////////////////////////////////////
	public function getSubject($Lang = NULL)
	{
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("SELECT DISTINCT  subject.ID   AS SubjectID , subject.".$Name."  AS SubjectName   
		                           FROM subject 
		                           inner join class_table on subject.ID = class_table.SubjectID 
		                           WHERE   subject.Is_Active = 1  and EmpID ='".(int)$this->session->userdata('id') ."' ")->result();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}
	}
	  ///////////////////////////////////////////////
	public function getRowLevel_taj($Lang = NULL)
	{
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("SELECT row_level.Level_ID AS LevelID ,row_level.Row_ID  AS RowID ,row_level.Level_Name  AS LevelName ,row_level.Row_Name AS RowName ,row_level.ID As RowLevelID 
		                           FROM row_level
		                           INNER JOIN config_row_level_emp   ON row_level.ID      = config_row_level_emp.row_levelID
		                           INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = '".$this->session->userdata('SchoolID')."' 
		                           WHERE row_level.IsActive = 1  and empID ='".(int)$this->session->userdata('id') ."'
		                           group by row_level.ID
		                           ")->result();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}
	}

////////////////////////////////////////////
	public function getSubject_taj($Lang = NULL)
	{
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("SELECT DISTINCT  subject.ID   AS SubjectID , subject.".$Name."  AS SubjectName   
		                           FROM subject 
		                           inner join config_subject_emp on subject.ID = config_subject_emp.subjectID 
		                           WHERE   subject.Is_Active = 1  and empID ='".(int)$this->session->userdata('id') ."' ")->result();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}
	}
	//////////////////////////////////////////////
	public function room_alert($room,$date,$duration)
	{
		
		$query = $this->db->query("SELECT zoom_meetings.id ,zoom_meetings.start_time,zoom_meetings.teacherid as teacherid,zoom_meetings.group_id,zoom_meetings.room_id,
                                   (DATE_ADD(zoom_meetings.start_time,INTERVAL zoom_meetings.duration MINUTE))as end_time
                                   FROM zoom_meetings
                                   WHERE room_id = '$room'
                                   AND zoom_meetings.is_deleted != 1 
                                   AND  (('$date' BETWEEN start_time AND(DATE_ADD(zoom_meetings.start_time,INTERVAL zoom_meetings.duration MINUTE)))
                                   OR ('$date'<=start_time AND (DATE_ADD('$date',INTERVAL $duration MINUTE))BETWEEN start_time AND(DATE_ADD(zoom_meetings.start_time,INTERVAL zoom_meetings.duration MINUTE))) 
                                   OR ('$date'<=start_time AND (DATE_ADD('$date',INTERVAL $duration MINUTE)>=(DATE_ADD(zoom_meetings.start_time,INTERVAL zoom_meetings.duration MINUTE))))
                                   )  LIMIT 1  ")->row_array();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}
	}
	//////////////////////////////////////////////
    public function add_zoom_meetings($Data = array(),$meetingId,$room_mail,$room,$start_url,$join_url,$occurrence_id,$uuid,$Timezone)
    { 
         $SchoolID = (int)$this->session->userdata('SchoolID');
         $idContact = (int)$this->session->userdata('id');
         
         
        $this->db->query("
        INSERT INTO zoom_meetings
        SET
        meeting_id                 = '".$meetingId."' ,
        room                       = '".$room_mail."' ,
        room_id                    = '".$room."' ,
        topic                      = '".$Data['topic']."' ,
        type                       = '".$Data['type']."' ,  
        start_time                 = '".$Data['start_time']."' ,
        start_url                  = '".$start_url."' ,
        duration                   = '".$Data['duration']."' ,
        schedule_for               = '".$Data['schedule_for']."' ,
        timezone                   = '".$Data['timezone']."' ,
        password                   = '".$Data['password']."' ,
        agenda                     = '".$Data['agenda']."' , 
        recurrence_type            = '".$Data['recurrence']['type']."' , 
        recurrence_repeat_interval = '".$Data['recurrence']['repeat_interval']."' , 
        recurrence_end_times       = '".$Data['recurrence']['end_times']."' ,  
        occurrence_id              = '".$occurrence_id."' ,  
        occurrence_weekly_days     = '".$Data['recurrence']['weekly_days']."' ,  
        levele_ID                  = '".$Data['levele_ID']."' ,  
        RowLevele_ID               = '".$Data['RowLevele_ID']."' ,  
        SubjectID                  = '".$Data['Subject_ID']."' ,  
        teacherid                  = '".$Data['teacherid']."' ,  
        group_id                   = '".$Data['group_id']."' ,  
        is_deleted                 = '0' ,  
        created_by                 = ".$idContact.",
        created_at                 = '".$Timezone."',
        join_url	               = '".$join_url."' ,
        uuid                       = '".$uuid."',
        reg_id                     = '".$Data['reg_id']."',
        external_link              = '".$Data['external_link']."'
        
         ");
        return TRUE ;
    }
	//////////////////////////////////////////////
	public function group_alert($group_id,$date,$duration)
	{
		
		$query = $this->db->query("SELECT zoom_meetings.id ,zoom_meetings.start_time,zoom_meetings.teacherid as teacherid,zoom_meetings.group_id,zoom_meetings.room_id,
                                   (DATE_ADD(zoom_meetings.start_time,INTERVAL zoom_meetings.duration MINUTE))as end_time
                                   FROM zoom_meetings
                                   WHERE group_id = $group_id
                                   AND zoom_meetings.is_deleted != 1 
                                   AND  (('$date' BETWEEN start_time AND(DATE_ADD(zoom_meetings.start_time,INTERVAL zoom_meetings.duration MINUTE)))
                                   OR ('$date'<=start_time AND (DATE_ADD('$date',INTERVAL $duration MINUTE))BETWEEN start_time AND(DATE_ADD(zoom_meetings.start_time,INTERVAL zoom_meetings.duration MINUTE))) 
                                   OR ('$date'<=start_time AND (DATE_ADD('$date',INTERVAL $duration MINUTE)>=(DATE_ADD(zoom_meetings.start_time,INTERVAL zoom_meetings.duration MINUTE))))
                                   )  LIMIT 1  ")->row_array();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}
	}
	//////////////////////////////////////////////
	public function teacher_alert($teacherid,$date,$duration)
	{
		
		$query = $this->db->query("SELECT zoom_meetings.id ,zoom_meetings.start_time,zoom_meetings.teacherid as teacherid,zoom_meetings.group_id,zoom_meetings.room_id,
                                   (DATE_ADD(zoom_meetings.start_time,INTERVAL zoom_meetings.duration MINUTE))as end_time
                                   FROM zoom_meetings
                                   WHERE teacherid = $teacherid
                                   AND zoom_meetings.is_deleted != 1 
                                   AND  (('$date' BETWEEN start_time AND(DATE_ADD(zoom_meetings.start_time,INTERVAL zoom_meetings.duration MINUTE)))
                                   OR ('$date'<=start_time AND (DATE_ADD('$date',INTERVAL $duration MINUTE))BETWEEN start_time AND(DATE_ADD(zoom_meetings.start_time,INTERVAL zoom_meetings.duration MINUTE))) 
                                   OR ('$date'<=start_time AND (DATE_ADD('$date',INTERVAL $duration MINUTE)>=(DATE_ADD(zoom_meetings.start_time,INTERVAL zoom_meetings.duration MINUTE))))
                                   )  LIMIT 1  ")->row_array();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}
	}
	///////////////////////////////////////////////
	 public function add_external_link($ID,$external)
    {
        $this->db->query("UPDATE zoom_meetings  SET external_link ='".$external."'  WHERE zoom_meetings.id ='".$ID."'");
        return TRUE ;
    }
    ///////////////////////////////
    public function Teacher_Timetable($id,$week_start,$week_end)
	{
	    $query=$this->db->query("SELECT contact.ID AS TeacherId,contact.Name AS TeacherName,GROUP_CONCAT(DISTINCT(school_details.SchoolName)) AS SchoolNames,zoom_meetings.Group_ID AS MeetingGroupId,
                                 zoom_premission.Name AS MeetingGroupName,zoom_meetings.id AS MeetingId,zoom_meetings.meeting_id AS meeting_id,zoom_meetings.topic AS MeetingTopic,
                                 zoom_meetings.start_time AS MeetingStartTime,DATE_ADD(zoom_meetings.start_time,INTERVAL zoom_meetings.duration MINUTE) AS MeetingEndTime,DAYNAME(zoom_meetings.start_time) AS DayName
                                 FROM contact
                                 INNER JOIN school_details ON contact.SchoolID = school_details.ID
                                 INNER JOIN zoom_meetings ON contact.ID = zoom_meetings.teacherid  AND zoom_meetings.is_deleted != 1 
                                 AND DATE(zoom_meetings.start_time) BETWEEN DATE('$week_start') AND DATE('$week_end') AND zoom_meetings.teacherid =".$id."  
                                 INNER JOIN zoom_premission ON zoom_meetings.group_id=zoom_premission.ID
                                 GROUP BY contact.ID,contact.Name,zoom_meetings.id,zoom_meetings.topic,zoom_meetings.duration,zoom_meetings.start_time
                                 UNION 
                                 SELECT contact.ID AS TeacherId,contact.Name AS TeacherName,GROUP_CONCAT( DISTINCT(school_details.SchoolName)) AS SchoolNames,zoom_meetings.Group_ID AS MeetingGroupId,
                                 zoom_premission.Name AS MeetingGroupName,zoom_meetings.id AS MeetingId,zoom_meetings.meeting_id AS meeting_id,zoom_meetings.topic AS MeetingTopic,zoom_meetings.start_time AS MeetingStartTime,
                                 DATE_ADD(zoom_meetings.start_time,INTERVAL zoom_meetings.duration MINUTE) AS MeetingEndTime,DAYNAME(zoom_meetings.start_time) AS DayName
                                 FROM contact
                                 INNER JOIN school_details ON contact.SchoolID = school_details.ID
                                 INNER JOIN zoom_meetings ON contact.ID = zoom_meetings.teacherid  AND zoom_meetings.is_deleted != 1 
                                 AND DATE(zoom_meetings.start_time) BETWEEN DATE('$week_start') AND DATE('$week_end')   
                                 INNER JOIN zoom_premission ON zoom_meetings.group_id=zoom_premission.ID
                                 INNER JOIN Zoom_Details ON zoom_meetings.group_id=Zoom_Details.Group_ID
                                 where FIND_IN_SET(".$id.",Zoom_Details.Contact_ID) 
                                 GROUP BY contact.ID,zoom_meetings.id,zoom_meetings.topic,zoom_meetings.duration,zoom_meetings.start_time ORDER BY MeetingStartTime");
	
			
			  if($query->num_rows()>0)
			{
			   return $query->result();	
			}else{return false ;}	
		
			
	}
	////////////////////////////////////////////
	public function get_day_zoom($Lang = NULL )
	{
		if($Lang == "arabic")
		  {		 
			      $query = $this->db->query("
				  SELECT 
				  day_zoom.ID As DayID ,
				  day_zoom.Name As DayName ,
				  day_zoom.Name_En As Name
				  FROM day_zoom 
				  GROUP BY day_zoom.ID
                  ORDER BY FIELD(day_zoom.Name_En, 'Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday');
		         ");
		  }else{
			      $query = $this->db->query("
				  SELECT 
				  day_zoom.ID As DayID ,
				  day_zoom.Name_En As DayName,
				  day_zoom.Name_En As Name
				  FROM day_zoom
				  GROUP BY day_zoom.ID 
                  ORDER BY FIELD(day_zoom.Name_En, 'Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday');
		         ");
			   }
		 if($query->num_rows() >0)
		 {
			 return $query->result(); 
		 }else
		  {
			  return FALSE ;
		  }
	}
	/////////////////////////////////////////////rania
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
	
	  public function Get_mettingids_by_contact_id()
    {
        
        $idContact = (int)$this->session->userdata('id');
        $query = $this->db->query("select zoom_meetings.*,zoom_rooms.name as roomname
        from zoom_meetings 
        inner join zoom_rooms on zoom_meetings.room_id=zoom_rooms.id
         INNER JOIN Zoom_Details ON zoom_meetings.group_id = Zoom_Details.Group_ID
        where    FIND_IN_SET('".$idContact."', Zoom_Details.Contact_ID) AND date(start_time)  = CURDATE() AND  is_deleted=0 and date(start_time) = CURDATE() GROUP BY zoom_meetings.id  order by start_time ASC limit 50  ")->result();
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }

    public function get_zoom_by_id($ID = 0 )
    {
        $query = $this->db->query("select * from zoom_premission where ID = '".$ID."' ")->row_array();
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
    	
    
    
    
    public function delete_permission($ID)
    {
        $this->db->query("
       DELETE from zoom_premission 
        WHERE ID = '".$ID."'
         ");
        return TRUE ;
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
    
    
   
    
    		public function get_student($ID, $Lang = NULL)
	{
	    if($ID){
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
	    }
			if($query->num_rows()>0)
			{
			   return $query->result();	
			}else{return false ;}
			
	}
		public function get_student1($ID)
	{
	   /* $Contact_ID= ltrim($ID, ',');
           $Contact_ID= ltrim($ID, ', ');
            $Contact_ID= rtrim($ID, ',');*/
            
        $Contact_ID = explode(",", $ID);
         $Contact_ID = array_filter($Contact_ID, 'strlen');
          $Contact_ID = implode(",", $Contact_ID);
         if($Contact_ID){
          
		$query = $this->db->query("
			 SELECT
			 tb1.ID AS StudentID,
			 tb1.User_Name AS StudentUserName,
			 tb1.Name AS StudentName
			 FROM contact As tb1
			  where tb1.ID IN ($Contact_ID)
			");//print_r($IDs);die;
         }
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
   
       
	////////////////////////////////
	public function Get_mettingids_by_emp_date($emp='',$fromdate='',$todate='')
    {
        $SchoolID = (int)$this->session->userdata('SchoolID');
        // print_R($SchoolID);
        // die();
        
           if(($emp!='') && ($fromdate!='') && ($todate!='') ){
            $where= "where   teacherid = '$emp' and date(start_time) >= '$fromdate'  and date(start_time) <= '$todate' ";
        }else if(($date!='') ){
            $where= "where  date(start_time) >= '$fromdate'  and date(start_time) <= '$todate' ";
        }else if(($emp!='') ){
            $where= "where   teacherid = '$emp' ";
        }else{
           return FALSE ;
        }
        
        $idContact = (int)$this->session->userdata('id');
        $query = $this->db->query("select zoom_meetings.*,zoom_rooms.name as roomname
        from zoom_meetings    
        inner join zoom_premission on zoom_meetings.group_id = zoom_premission.id 
        inner join zoom_rooms on zoom_meetings.room_id=zoom_rooms.id 
        inner join send_box_zoom on zoom_meetings.teacherid=send_box_zoom.contact_id and zoom_meetings.id = send_box_zoom.meeting_id
        $where and zoom_rooms.SchoolID = $SchoolID and is_deleted=0 and   date(start_time) >= '$date'   GROUP BY zoom_meetings.id  limit 50  ")->result(); 
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
 
        public function get_group_name($id)
        { 
            $query = $this->db->query("select Name 
            from  	zoom_premission  where ID = $id 
            ")->result();
             if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
            
        }
        
   ///////////////////////////////////////////
	 public function get_groupname($ID){
            	$query = $this->db->query("
			 SELECT
			 ID ,
			 Name 
			 FROM zoom_premission 
			  where  ID=$ID
			");
		 
			if($query->num_rows()>0)
			{
			   return $query->result_array();	
			}else{return false ;}
     }
     
//////////////////////////
	public function GroupsByRowLevel($Lang,$rowLavel)
	{

	    $Name = 'Name';
		if($Lang == 'english'){$Name = 'Name_en';}
		$query = $this->db->query("select zoom_premission.* , contact.Name As contactName 
                                   from zoom_premission
                                   INNER JOIN contact ON zoom_premission.Created_by = contact.ID  or zoom_premission.ConactId = contact.ID
                                   where zoom_premission.IsUpdate = 1  and zoom_premission.RowID = $rowLavel
                                   AND zoom_premission.SchoolID='".$this->session->userdata('SchoolID')."'
                                   group by zoom_premission.ID order by zoom_premission.ID DESC
                                   ")->result();
       
		return $query  ;
	}
	
    
   
}