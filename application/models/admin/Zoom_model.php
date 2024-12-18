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
    //////////////////////
   
    
    //////get_all_class1
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
		public function get_student($ID=0, $Lang = NULL)
	{
	    if($ID!=0){
		$query = $this->db->query("
			 SELECT
			 ID AS StudentID,
			 User_Name AS StudentUserName,
			 Name AS FullName,
			 Type
			 FROM contact 
			  where ID =  $ID
			");
			}else{}//print_r($IDs);die;
			if($query->num_rows()>0)
			{
			   return $query->result();	
			}else{return false ;}
			
	}
	
	public function get_student1($ID)
	{
	    
         $Contact_ID = explode(",", $ID);
         $Contact_ID = array_filter($Contact_ID, 'strlen');
          $Contact_ID = implode(",", $Contact_ID);
         if($Contact_ID){
		$query = $this->db->query("
			 SELECT
			 tb1.ID AS StudentID,
			 tb1.User_Name AS StudentUserName,
			 tb1.User_Name AS StudentUserName,
			 tb1.Type,
			 tb1.Name AS StudentName
			 
			 FROM contact As tb1
			  where
			  
			  tb1.ID IN ($Contact_ID)
			  
			");//print_r($IDs);die;
         }
			if($query->num_rows()>0)
			{
			   return $query->result();	
			}else{return false ;}
			
	}
	
	public function get_student_new($Group_ID)
	{
        $Lang=$this->session->userdata('language');
	    $query1=$this->db->query("select Contact_ID from Zoom_Permissions_ExcludedContacts where ZoomPermissionsID=".$Group_ID."")->row_array();
		$query = $this->db->query("SELECT DISTINCT
                                     contact.ID AS Contact_ID,
                                     CASE
                                    WHEN '$Lang' = 'english' and contact.Name_en IS not NULL and contact.Name_en !=' ' THEN contact.Name_en
                                    ELSE contact.Name
                                    END AS StudentName ,
                                     contact.Type,
                                     contact.User_Name AS StudentUserName
                                   FROM contact
                                     INNER JOIN vw_zoom_premission_per_contact_select AS T
                                       ON contact.ID = T.contactID
                                       AND contact.Name != ''
                                   WHERE ZoomPremissionID = ".$Group_ID."
                                    order by StudentName asc");	
			
			  if($query->num_rows()>0)
			{
			   return $query->result();	
			}else{return false ;}	
		
			
	}
	
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
         order by StudentName asc");
	
			
			  if($query->num_rows()>0)
			{
			   return $query->result();	
			}else{return false ;}	
		
			
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
	

    public function get_zoom_by_id($ID = 0 )
    {
        $query = $this->db->query("select * from zoom_premission where ID = '".$ID."' ")->row_array();
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
    
     public function get_meeting_by_id($ID = 0 )
    {
        $query = $this->db->query("select * from  zoom_meetings where ID = '".$ID."' ")->row_array();
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
    
    public function add_external_link($ID,$external)
    {
        $this->db->query("UPDATE zoom_meetings  SET external_link ='".$external."'  WHERE zoom_meetings.id ='".$ID."'");
        return TRUE ;
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
          public function get_emp_rooms11($ID)
        {
            $query1 = $this->db->query("select rooms from zoom_rooms_employee where empid=$ID")->row_array();
            $rooms=$query1['rooms'];
            $query=$this->db->query("SELECT * FROM `zoom_rooms` WHERE `id` IN($rooms)")->result();
            
             if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
            
        }

        public function get_rooms_by_empid()
        {  $idContact = (int)$this->session->userdata('id');
            $query = $this->db->query("select zoom_rooms.*
            from zoom_rooms join zoom_rooms_employee  ON  zoom_rooms_employee.empid= $idContact
             

            ")->result();
             if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
            
        }
        
        public function get_rooms_by_schoolid()
        {$SchoolID= $this->session->userdata('SchoolID') ; 
            $query = $this->db->query("select * 
            from zoom_rooms where SchoolID IN(".$SchoolID.")

            ")->result();
             if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
            
        }
        
        
        public function get_emp()
        {
            $emp = get_emp_select_in();
            $SchoolID= $this->session->userdata('SchoolID') ; 
            $query = $this->db->query("select * 
            from contact where  type='E' AND ID IN(".$emp.")

            ")->result();
             if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
            
        }
        public function get_emp_per()
        { 
            if ($this->session->userdata('language') == 'english') {
                $contactName = "CASE
                    WHEN contact.Name_en IS NULL or contact.Name_en='' THEN contact.Name
                    ELSE contact.Name_en
                    END AS Name";
            } else {
                $contactName = "CASE
                    WHEN contact.Name IS NULL or contact.Name='' THEN contact.Name_en
                    ELSE contact.Name
                    END AS Name";
            }
            $emp_Id       = get_emp_select_in() ;
            $sup_Id       = get_supervisor_select_in() ;
            $SchoolID     = $this->session->userdata('SchoolID') ;
            $query        = $this->db->query("select ID,$contactName 
                                                from contact where ID IN(".$emp_Id.", ".$sup_Id.") 
                                                ")->result();
             if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
            
        }
        public function get_contact_name($id)
        {
            $SchoolID= $this->session->userdata('SchoolID') ; 
            $query = $this->db->query("select Name 
            from contact where ID = $id 
            ")->result();
             if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
            
        }
        public function get_group_name($id)
        { 
            $query = $this->db->query("select Name 
            from  	zoom_premission  where ID = $id 
            ")->result();
             if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
            
        }
        public function get_zoom_token()
        {//$SchoolID= $this->session->userdata('SchoolID') ; 
            $query = $this->db->query("select * 
            from zoom_settings where id = 1

            ")->result();
             if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
            
        }
        
    public function get_permission_with_teacher()
    {
        $types = $this->session->userdata('type');
        if($types=="U"){
        $query = $this->db->query("select zoom_premission.* , contact.Name As contactName ,school_details.SchoolName 
        from zoom_premission
        INNER JOIN contact ON zoom_premission.EmpID = contact.ID  
        INNER JOIN school_details ON  school_details.ID IN(contact.SchoolID)
        
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
    
    public function get_permission($Name="")
    {
        $Name=urldecode($Name);
        $SchoolID = (int)$this->session->userdata('SchoolID');
        $types = $this->session->userdata('type');
        if($types=="U"||$types=="E"){
        $query = $this->db->query("select zoom_premission.*    
        from zoom_premission 
        
        where zoom_premission.IsUpdate = 1 
        AND(zoom_premission.Name LIKE '$Name%'OR zoom_premission.Name LIKE '%$Name%')
        AND zoom_premission.SchoolID  IN(".$this->session->userdata('SchoolID').")
        group by zoom_premission.ID order by zoom_premission.ID 
        ")->result();}
        else{
            $idContact = (int)$this->session->userdata('id');
        $query = $this->db->query("select zoom_premission.*  
        from zoom_premission 
        ")->result();
        }
        
        
       // where zoom_premission.IsUpdate = 1 
       // AND (zoom_premission.EmpID=$idContact OR zoom_premission.ConactId=$idContact)
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
    
     public function get_permission_zoom()
    {
        
        $SchoolID = (int)$this->session->userdata('SchoolID');
      
        $query = $this->db->query("select zoom_premission.* , contact.Name As contactName   
        from zoom_premission 
        INNER JOIN contact ON zoom_premission.Created_by = contact.ID  or zoom_premission.ConactId = contact.ID
        where zoom_premission.IsUpdate = 1 
        AND zoom_premission.SchoolID IN(".$this->session->userdata('SchoolID').")
        group by zoom_premission.ID order by zoom_premission.ID 
        ")->result();
        
       
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
    
     public function add_permission($Data = array())
    { 
         $SchoolID = (int)$this->session->userdata('SchoolID');
         $idContact = (int)$this->session->userdata('id');
        $this->db->query("
        INSERT INTO zoom_premission
        SET
        Name          = '".$Data['Name']."' ,
        EmpID         = '".$Data['EmpID']."' ,
        SchoolID      = '".$SchoolID."' ,
        LevelID       = '".$Data['LevelID']."' ,
        RowID         = '".$Data['RowID']."' ,
        ClassID       = '".$Data['ClassID']."' ,
        ConactId      = '".$idContact."' ,
        Token         = '".$this->Token."' ,
        Date          = '".$this->Date."',
        Created_by    = '".$idContact."',
        Created_at    = '".$this->Date."',
        IsActive      = 1 ,
        IsUpdate	  = 1
         ");
        return TRUE ;
    }
    
     public function add_zoom_meetings($Data = array(),$meetingId,$room1,$room,$start_url,$join_url,$occurrence_id,$uuid,$Timezone)
    { 
         $SchoolID = (int)$this->session->userdata('SchoolID');
         $idContact = (int)$this->session->userdata('id');
         
         
        $this->db->query("
        INSERT INTO zoom_meetings
        SET
        meeting_id         = '".$meetingId."' ,
         room         = '".$room1."' ,
        room_id         = '".$room."' ,
        topic         = '".$Data['topic']."' ,
        type         = '".$Data['type']."' ,  
        start_time       = '".$Data['start_time']."' ,
        start_url       = '".$start_url."' ,
        duration      = '".$Data['duration']."' ,
        schedule_for      = '".$Data['schedule_for']."' ,
        timezone      = '".$Data['timezone']."' ,
        password      = '".$Data['password']."' ,
        agenda      = '".$Data['agenda']."' , 
        recurrence_type      = '".$Data['recurrence']['type']."' , 
        recurrence_repeat_interval      = '".$Data['recurrence']['repeat_interval']."' , 
        recurrence_end_times     = '".$Data['recurrence']['end_times']."' ,  
        occurrence_id     = '".$occurrence_id."' ,  
        occurrence_weekly_days     = '".$Data['recurrence']['weekly_days']."' ,  
        levele_ID     = '".$Data['levele_ID']."' ,  
        RowLevele_ID     = '".$Data['RowLevele_ID']."' ,  
        SubjectID     = '".$Data['Subject_ID']."' ,  
        teacherid     = '".$Data['teacherid']."' ,  
        group_id     = '".$Data['group_id']."' ,  
         is_deleted     = '0' ,  
         created_by     = '".$idContact."' ,
         created_at     = '".$Timezone."',
         uuid         = '".$uuid."' ,
         join_url        = '".$join_url."' ,
         external_link ='".$Data['external_link']."'
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
        Updated_by    = '".$idContact."',
        Updated_at    = '".$this->Date."',
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
    public function add_permission_new($category,$Data=array())
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
       elseif($category=='class' || $category=='U-class'){
       $query_class=array(  
         'ClassID'             => $class['class'],
        "RowLevelID"           => $class['RowLevels'],
        "ZoomPermissionsID"    => $class['Group_ID']
        
         );
         if($this->db->insert('Zoom_Permissions_Class',$query_class)){return $query_class;}else{return FALSE ;}
      }
    }
    public function add_permission1($Data=array())
    {
     
      extract($Data);
      

     
           $Contact_ID= ltrim($Contact_ID, ',');
           $Contact_ID= ltrim($Contact_ID, ', ');
           
           
      $query=array(  
        
        "Contact_ID"        => $Contact_ID,
        "Group_ID"           =>$Group_ID
        
         );
      
             $query1 = $this->db->query("select * from Zoom_Details WHERE   Group_ID = $Group_ID ")->result();
        if(sizeof($query1)> 0 ){  
         
          
            $Contact_ID_add=','.$Contact_ID;
            $sql = "update `Zoom_Details` set Contact_ID =  CONCAT(if(Contact_ID is null ,'',Contact_ID),  '$Contact_ID_add') where Group_ID = $Group_ID  ";
            $this->db->query($sql); 
            
      
    $query2 = $this->db->query("select * from Zoom_Details WHERE   Group_ID = $Group_ID ")->result();
     $Contact_ID= $query2[0]->{'Contact_ID'} ;
            
             $Contact_ID = explode(",", $Contact_ID);
            $Contact_ID = array_unique($Contact_ID);
            $Contact_ID = implode(",", $Contact_ID); 
            
                $sql = "update `Zoom_Details` set Contact_ID =    '$Contact_ID'  where Group_ID = $Group_ID  ";
            $this->db->query($sql); 
               
        
             return TRUE;
                   }else
                    { if($this->db->insert('Zoom_Details',$query)){return $query;}else{return FALSE ;}
                    }
       
    }
    
    public function Get_mettingids()
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
    
    public function Get_previous_mettingids()
    {
        $idContact = (int)$this->session->userdata('id');
        $query = $this->db->query("select *
        from zoom_meetings  ")->result();
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
        
    public function Get_mettingids_by_room_date($room='',$date='',$teacher='')
    {
        $emp = get_emp_select_in(); 
        //print_r($emp);die;
        $SchoolID = (int)$this->session->userdata('SchoolID');
        if(($room!='') && ($date!='')&& ($teacher!='') ){
            $where= "where   zoom_rooms.id = '$room' and date(start_time) = '$date' and teacherid=$teacher " ;
        }else if(($teacher!='') && ($room!='') ){
            $where= "where   teacherid=$teacher and zoom_rooms.id='$room' ";
        }else if(($teacher!='') && ($date!='') ){
            $where= "where   teacherid=$teacher and date(start_time) = '$date' ";
        }else if(($date!='') && ($room!='') ){
            $where= "where   date(start_time) = '$date' and zoom_rooms.id='$room' ";
        }else if(($date!='') ){
            $where= "where   date(start_time) = '$date' ";
        }else if(($room!='') ){
            $where= "where   zoom_rooms.id = '$room' ";
        }else if(($teacher!='') ){
            $where= "where teacherid=$teacher ";
       
        }else{
           return FALSE ;
        }
        
        $idContact = (int)$this->session->userdata('id');
        $query = $this->db->query("select zoom_meetings.*,zoom_rooms.name as roomname,school_details.ID,school_details.time_zone
        from zoom_meetings    
        inner join zoom_premission on zoom_meetings.group_id = zoom_premission.id 
        inner join zoom_rooms on zoom_meetings.room_id=zoom_rooms.id 
        inner join contact on zoom_meetings.teacherid = contact.ID
        INNER JOIN school_details ON school_details.ID = zoom_rooms.schoolid
        $where and zoom_rooms.SchoolID IN(".$SchoolID.") and contact.SchoolID IN(".$SchoolID.") and is_deleted=0 and zoom_meetings.teacherid IN(".$emp.") and   date(start_time) >= '$date'   GROUP BY zoom_meetings.id   order by start_time ASC ")->result(); 
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
    public function Get_mettingids_by_room_date1($room='',$date='')
    {
        $emp = get_emp_select_in(); 
        $supervisor=get_supervisor_select_in();
        //print_r($emp);die;
        $SchoolID = (int)$this->session->userdata('SchoolID');
        if(($date!='') && ($room!='') ){
            $where= "where   date(start_time) = '$date' and zoom_rooms.id='$room' ";
        }else if(($date!='') ){
            $where= "where   date(start_time) = '$date' "; 
        }else if(($room!='') ){
            $where= "where   zoom_rooms.id = '$room' and date(start_time) = CURDATE() ";
        }else{
           return FALSE ;
        }
        
        $idContact = (int)$this->session->userdata('id');
        $query = $this->db->query("select zoom_meetings.*,zoom_rooms.name as roomname,school_details.ID,school_details.time_zone
        from zoom_meetings    
        inner join zoom_premission on zoom_meetings.group_id = zoom_premission.id 
        inner join zoom_rooms on zoom_meetings.room_id=zoom_rooms.id 
        inner join contact on zoom_meetings.teacherid = contact.ID
        INNER JOIN school_details ON school_details.ID = zoom_rooms.schoolid
        $where and RowLevele_ID != 0 AND SubjectID != 0 AND zoom_rooms.SchoolID IN(".$SchoolID.") and contact.SchoolID IN(".$SchoolID.") and is_deleted=0 and zoom_meetings.teacherid IN(".$emp.",$supervisor) and   date(start_time) >= '$date'   GROUP BY zoom_meetings.id   order by start_time ASC ")->result(); 
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
    public function Get_mettingids_by_school($room='', $date='')
    {
        $SchoolID = (int)$this->session->userdata('SchoolID');

        if ($date != '' && $room != '') {
            $where = "where date(start_time) = '$date' and zoom_rooms.id = '$room'";
        } else if ($date != '') {
            $where = "where date(start_time) = '$date'";
        } else if ($room != '') {
            $where = "where zoom_rooms.id = '$room' and date(start_time) = CURDATE()";
        } else if ($date == '' && $room == '') { // Corrected condition
            $where = "where date(start_time) = CURDATE()"; 
        } else {
            return FALSE;
        }

        $query = $this->db->query("select zoom_meetings.*, zoom_rooms.name as roomname, school_details.ID, school_details.time_zone
            from zoom_meetings    
            inner join zoom_premission on zoom_meetings.group_id = zoom_premission.id 
            inner join zoom_rooms on zoom_meetings.room_id = zoom_rooms.id 
            inner join contact on zoom_meetings.teacherid = contact.ID
            INNER JOIN school_details ON school_details.ID = zoom_rooms.schoolid
            $where and RowLevele_ID = 0 AND SubjectID = 0 AND  zoom_rooms.SchoolID IN(".$SchoolID.") and is_deleted=0  GROUP BY zoom_meetings.id   order by start_time ASC ")->result(); 
        if (sizeof($query) > 0) {
            return $query;
        } else {
            return FALSE;
        }
    }

    public function Get_mettingids_by_last_add($emp)
    {
        $SchoolID = (int)$this->session->userdata('SchoolID');
         
        
        $idContact = (int)$this->session->userdata('id');
        $query = $this->db->query("select zoom_meetings.*,zoom_rooms.name as roomname,school_details.time_zone
        from zoom_meetings    
        inner join zoom_premission on zoom_meetings.group_id = zoom_premission.id 
        inner join zoom_rooms on zoom_meetings.room_id=zoom_rooms.id 
        INNER JOIN school_details ON school_details.ID = zoom_rooms.schoolid
        where RowLevele_ID != 0 AND SubjectID != 0 AND date(start_time) = CURDATE() and zoom_meetings.created_by=$idContact and   zoom_rooms.SchoolID IN(".$SchoolID.") and is_deleted=0 and zoom_meetings.teacherid IN(".$emp.")  GROUP BY zoom_meetings.id   ")->result(); 
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
    public function Get_mettingids_by_last_add1($emp)
    {
        $Emp = get_emp_select_in();
        $supervisor=get_supervisor_select_in();
        //print_r($Emp);die;
        $SchoolID = (int)$this->session->userdata('SchoolID');
     
        $idContact = (int)$this->session->userdata('id');
        
        $query = $this->db->query("select zoom_meetings.*,zoom_rooms.name as roomname,school_details.time_zone
        from zoom_meetings    
        INNER JOIN zoom_premission on zoom_meetings.group_id = zoom_premission.id 
        INNER JOIN zoom_rooms on zoom_meetings.room_id=zoom_rooms.id
        INNER JOIN school_details ON school_details.ID = zoom_rooms.schoolid
        where  date(start_time) = CURDATE()
        and  zoom_rooms.SchoolID IN(".$SchoolID.") 
        and is_deleted=0   
        and (RowLevele_ID != 0 OR SubjectID != 0) AND case when zoom_meetings.RowLevele_ID!=0 then zoom_meetings.teacherid IN(".$Emp.",$supervisor)else 1 end
        GROUP BY zoom_meetings.id
        order by start_time ASC
       
        ")->result(); 
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
    public function Get_mettingids_by_emp_idxxx()
    {
        $SchoolID = (int)$this->session->userdata('SchoolID');
        // print_R($SchoolID);
        // die();
        $idContact = (int)$this->session->userdata('id');
        $query = $this->db->query("select zoom_meetings.*,zoom_rooms.name as roomname
        from zoom_meetings 
        inner join zoom_premission on zoom_meetings.group_id = zoom_premission.id 
        inner join zoom_rooms on zoom_meetings.room_id=zoom_rooms.id 
        where   zoom_premission.SchoolID IN(".$SchoolID.") and date(start_time) >= CURDATE() and is_deleted=0  
        GROUP BY zoom_meetings.id order by zoom_meetings.id desc limit 10 ")->result();
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
        public function Get_mettingids_by_emp_id()
    {
        $SchoolID = (int)$this->session->userdata('SchoolID');
        // print_R($SchoolID);
        // die();
        $idContact = (int)$this->session->userdata('id');
        $query = $this->db->query("select zoom_meetings.*,zoom_rooms.name as roomname
        from zoom_meetings  
        inner join zoom_rooms on zoom_meetings.room_id=zoom_rooms.id 
        where created_by=$idContact and date(start_time) >= CURDATE() and is_deleted=0  GROUP BY zoom_meetings.id order by zoom_meetings.id desc  limit 10  ")->result();
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
    
    public function Get_mettingids_by_emp_id_by_zoom_premission()
    {
        $SchoolID = (int)$this->session->userdata('SchoolID');
        // print_R($SchoolID);
        // die();
        $idContact = (int)$this->session->userdata('id');
        $query = $this->db->query("select *
        from zoom_meetings
        inner join zoom_premission on zoom_meetings.meeting_id = zoom_premission.MeetingId 
        inner join zoom_rooms on zoom_premission.SchoolID=zoom_rooms.schoolid 
        where  zoom_rooms.schoolid IN(".$SchoolID.") and date(start_time) >= CURDATE() and is_deleted=0 ")->result();
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
    
     public function Get_mettingids1()
    {
       
        $query = $this->db->query("select MeetingId
        from zoom_premission
        INNER JOIN Zoom_Details ON zoom_premission.ID = Zoom_Details.Group_ID
        where
        zoom_premission.MeetingId IS NOT NULL
        GROUP by MeetingId
        ")->result();
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
     public function show_details($ID)
    {
       // extract($Data);
        
      $query = $this->db->query("select Zoom_Details.* , zoom_premission.Name As Group_Name,Zoom_Details.Contact_ID as contactid 
        from Zoom_Details
        INNER JOIN zoom_premission ON zoom_premission.ID = Zoom_Details.Group_ID 
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
      public function delete_group_level($ID)
    {
        $this->db->query("
       DELETE from  Zoom_Permissions_Levels
        WHERE ZoomPermissionsID = '".$ID."'
         ");
        return TRUE ;
    }
     public function delete_group_row($ID)
    {
        $this->db->query("
       DELETE from  Zoom_Permissions_RowLevel
        WHERE ZoomPermissionsID = '".$ID."'
         ");
        return TRUE ;
    }
     public function delete_group_class($ID)
    {
        $this->db->query("
       DELETE from   Zoom_Permissions_Class
        WHERE ZoomPermissionsID = '".$ID."'
         ");
        return TRUE ;
    }
    public function delete_group_ExcludedContacts($ID)
    {
        $this->db->query("
       DELETE from  Zoom_Permissions_ExcludedContacts 
        WHERE ZoomPermissionsID = '".$ID."'
         ");
        return TRUE ;
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
		 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID IN(".$this->session->userdata('SchoolID').")
		 WHERE level.Is_Active = 1 
		 group by row_level.ID
		 
		 ")->result();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}
	}

		public function getSubject($Lang = NULL)
	{
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT
		 subject.ID         AS SubjectID , 
		 subject.".$Name."  AS SubjectName   
		 FROM 
		 subject  WHERE subject.Is_Active = 1 
		 ")->result();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}
	}
	public function get_emp_rooms($ID=0)
	{
	    if($ID!=0){
		$query = $this->db->query("
			 SELECT
			 ID ,
			 empid,
			 rooms
			 FROM zoom_rooms_employee 
			  where empid =  $ID
			");
			}else{}//print_r($IDs);die;
			if($query->num_rows()>0)
			{
			   return $query->result();	
			}else{return false ;}
			
	}
    public function add_emp_rooms($Data=array())
    {
     
      extract($Data);
       
    if($Data['type']=='update'){  
      $empid=  $Data['empid'];
      $rooms=  $Data['emp_rooms'];
        $rooms = implode(",", $rooms);
    		$sql = "update `zoom_rooms_employee` set rooms = '$rooms'  where empid = $empid  ";
			$this->db->query($sql); 
			 return TRUE;
        
        
    }
    elseif($Data['type']=='insert'){
        
      $rooms=  $Data['emp_rooms'];
        $rooms = implode(",", $rooms);
         $query=array(  
        
        "empid"        =>  $Data['empid'],
        "rooms"           =>$rooms
        
         );
         if($this->db->insert('zoom_rooms_employee',$query)){return $query;}else{return FALSE ;}
    }
     /*
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
        //   $Contact_ID_add= ltrim($Contact_ID_add, ',');
         //  $Contact_ID_add= ltrim($Contact_ID_add, ', ');
    // }
   // echo  $Contact_ID_add;die;
    		$sql = "update `Zoom_Details` set Contact_ID =  CONCAT(Contact_ID,  '$Contact_ID_add') where Group_ID = $Group_ID  ";
			$this->db->query($sql); 
			 return TRUE;
                   }else
                    { if($this->db->insert('Zoom_Details',$query)){return $query;}else{return FALSE ;}
                    }
       */
      
    }
    public function get_all_student(){
           $SchoolID= $this->session->userdata('SchoolID');
            	$query = $this->db->query("
			 SELECT
			 ID ,
			 Name 
			 FROM contact 
			  where  type='S' and SchoolID IN(".$SchoolID.")  
			");
		 
			if($query->num_rows()>0)
			{
			   return $query->result_array();	
			}else{return false ;}
    }
     public function get_all_student_per($student)
     {
           $SchoolID= $this->session->userdata('SchoolID');
            	$query = $this->db->query("
			 SELECT
			 ID ,
			 Name 
			 FROM contact 
			  where  type='S' and SchoolID IN(".$SchoolID.")  and ID IN(".$student.")
			");
		 
			if($query->num_rows()>0)
			{
			   return $query->result_array();	
			}else{return false ;}
    }
      public function get_all_teacher(){
          $emp = get_emp_select_in();
           $SchoolID= $this->session->userdata('SchoolID');
            	$query = $this->db->query("
			 SELECT
			 ID ,
			 Name 
			 FROM contact 
			  where  type='E' and SchoolID IN(".$SchoolID.")  AND contact.ID IN(".$emp.")
			");
		 
			if($query->num_rows()>0)
			{
			   return $query->result_array();	
			}else{return false ;}
     }
     ///////////////////////////
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
     ////////////////////
     public function Get_mettingids_by_emp_date($emp='',$fromdate='',$todate='')
    {
        $SchoolID = (int)$this->session->userdata('SchoolID');
        if(($emp!='') && ($fromdate!='') && ($todate!='') ){
            $where= "where   teacherid = '$emp' and date(start_time) >= '$fromdate'  and date(start_time) <= '$todate' ";
        }else if(($fromdate!='') && ($todate!='')  ){
            $where= "where  date(start_time) >= '$fromdate'  and date(start_time) <= '$todate' ";
        }else if(($emp!='') ){
            $where= "where   teacherid = '$emp' ";
        }else{
           return FALSE ;
        }
        $idContact = (int)$this->session->userdata('id');
        $query = $this->db->query("select zoom_meetings.*,zoom_rooms.name as roomname,school_details.time_zone
        from zoom_meetings    
        inner join zoom_premission on zoom_meetings.group_id = zoom_premission.id 
        inner join zoom_rooms on zoom_meetings.room_id=zoom_rooms.id 
        INNER JOIN school_details ON school_details.ID = zoom_rooms.schoolid
        $where and zoom_rooms.SchoolID IN(".$SchoolID.") and is_deleted=0 GROUP BY zoom_meetings.id  ")->result(); 
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
    
    
    
    	public function get_attend_students($LevelID = 0 , $RowLevelID =0 ,  $ClassID = 0  , $DayDateFrom = 0 , $DayDateTo = 0 )
	 { 
	     
	   //  print_r($ClassID);die;
	     
	    if($LevelID    == 0 ){$LevelID    = 'NULL';  }
    	if($RowLevelID == 0 ){$RowLevelID = 'NULL';  }
    	if($ClassID    == 0 ){$ClassID    = 'NULL'; }
	    
			$ResultExam = $this->db->query("SELECT
        T.*,
        (
            T.TotalNumberOfParticipants - T.TotalNumberOfAttendees
        ) AS TotalNumberOfAbsences
    FROM
        (
        SELECT
            S_contact.ID AS StudentId,
            S_contact.Name AS StudentName,
            school_details.ID AS SchoolId,
            school_details.SchoolName,
            row_level.Level_ID AS LevelId,
            row_level.Level_Name AS LevelName,
            row_level.Row_ID AS RowId,
            row_level.Row_Name AS RowName,
            class.ID AS ClassId,
            class.Name AS ClassName,
            zoom_meetings.id AS MeetingId,
            zoom_meetings.Group_ID AS MeetingGroupId,
            zoom_premission.Name AS MeetingGroupName,
            zoom_meetings.topic AS MeetingTopic,
            zoom_meetings.start_time AS MeetingStartTime,
            COUNT((S_contact.ID)) AS TotalNumberOfParticipants,
            COUNT(
                (send_box_zoom.contact_id)
            ) AS TotalNumberOfAttendees
        FROM
            student
        INNER JOIN contact AS S_contact
        ON student.Contact_ID = S_contact.ID AND S_contact.TYPE = 'S'
        INNER JOIN row_level ON row_level.ID = student.R_L_ID
        INNER JOIN school_details ON S_contact.SchoolID = school_details.ID
        INNER JOIN class ON student.Class_ID = class.ID
        INNER JOIN Zoom_Details ON FIND_IN_SET(
                S_contact.ID,
                Zoom_Details.Contact_ID
            ) > 0
        INNER JOIN zoom_premission ON Zoom_Details.Group_ID = zoom_premission.ID
        INNER JOIN zoom_meetings ON Zoom_Details.Group_ID = zoom_meetings.group_id AND zoom_meetings.is_deleted != 1 AND DATE(zoom_meetings.start_time) BETWEEN DATE('2020-03-01 14:30:00') AND DATE('2021-03-17 14:30:00')
        INNER JOIN contact AS T_contact
        ON
            zoom_meetings.teacherid = T_contact.ID
        LEFT JOIN send_box_zoom ON S_contact.ID = send_box_zoom.contact_id AND zoom_meetings.id = send_box_zoom.meeting_id AND send_box_zoom.date BETWEEN DATE(zoom_meetings.start_time) AND DATE_ADD(
                zoom_meetings.start_time,
                INTERVAL zoom_meetings.duration MINUTE
            )
            
              WHERE row_level.Level_ID     			= IFNULL($LevelID , row_level.Level_ID )
              AND   class.ID    		= IFNULL($ClassID , class.ID )
              AND   row_level.ID  			       	= IFNULL($RowLevelID , row_level.ID )
        GROUP BY
            S_contact.ID,
            S_contact.Name,
            school_details.ID,
            school_details.SchoolName,
            row_level.Level_ID,
            row_level.Level_Name,
            row_level.Row_ID,
            row_level.Row_Name,
            class.ID,
            class.Name
    ) AS T")->result_array();
            
            if(sizeof($ResultExam)>0)
		
			  {
				$ReturnExam     = $ResultExam;
				
			   return $ReturnExam ; 
			   
			   return TRUE ; 
							 
			  }else{
				  return $NumRowResultExam ; 
				  return FALSE ;}
	}
	public function add_summer_courses($Data = array())
    { 
         $SchoolID = (int)$this->session->userdata('SchoolID');
         $idContact = (int)$this->session->userdata('id');
         $date=date("Y-m-d H:i:s");
           $DataInsert = array(
		                    "Name"   		           =>$Data['course_name'] ,
							"ConactId" 		           =>$idContact ,
							"EmpID" 		           =>$idContact ,
							"Date "                    =>$date,
							"SchoolID"                 =>$SchoolID,
							"IsActive"                 =>1
							);
							$this->db->insert('zoom_premission',$DataInsert);
							$insertId = $this->db->insert_id();
         $DataInsert1 = array(
		                    "Name"   		                       =>$Data['course_name'] ,
		                    "Details" 		                       =>$Data['details'] ,
							"Date_from" 		                   =>$Data['date_from'] ,
							"Date_to" 		                       =>$Data['date_to'] ,
							"Advert_start" 		                  =>$Data['date_anno'] ,
							"Advert_finish" 		              =>$Data['date_anno2'] ,
							" row_level " 		                   =>$Data['row_level'] ,
							"GroupID" 		                        =>$insertId ,
							);
							$this->db->insert('Summer_Courses',$DataInsert1);
			
        
        return TRUE ;
    }
    
    public function summer_courses_details()
    {
     $query=$this->db->query("select * from Summer_Courses");  
    	if($query->num_rows()>0)
			{
			   return $query->result();	
			}else{return false ;}
    }
    public function delete_summer_courses($ID,$GroupID)
    {
       
        $this->db->query("
        DELETE  Summer_Courses, zoom_premission FROM Summer_Courses INNER JOIN zoom_premission ON Summer_Courses.GroupID = zoom_premission.ID 
        WHERE Summer_Courses.GroupID= $GroupID
         ");
        
        return TRUE ;
    }
    
    	public function edit_summer_courses($Data = array())
    { 
         $SchoolID = (int)$this->session->userdata('SchoolID');
         $idContact = (int)$this->session->userdata('id');
         $date=date("Y-m-d H:i:s");
           $DataUpdate = array(
		                    "Name"   		           =>$Data['course_name'] ,
							"ConactId" 		           =>$idContact ,
							"EmpID" 		           =>$idContact ,
							"Date "                    =>$date,
							"SchoolID"                 =>$SchoolID,
							"IsActive"                 =>1,
							"IsUpdate"                 =>1,
							);
							$this->db->where('ID',$Data['GroupID']);
							$this->db->update('zoom_premission',$DataUpdate);
							
         $DataUpdate2 = array(
		                    "Name"   		           =>$Data['course_name'] ,
		                    "Details" 		           =>$Data['details'] ,
							"Date_from" 		       =>$Data['date_from'] ,
							"Date_to" 		           =>$Data['date_to'] ,
							"Advert_start" 		        =>$Data['adver_start'] ,
							"Advert_finish" 		   =>$Data['adver_finish'] ,
							"row_level" 		         =>$Data['row_level2'] ,
							);
							$this->db->where('ID',$Data['ID']);
							$this->db->update('Summer_Courses',$DataUpdate2);
			
        
        return TRUE ;
    }
    public function get_level($row_level)
    {
    $result=$this->db->query("SELECT
		 row_level.Level_Name  AS level_name ,
		 row_level.Row_Name  AS row_name
		 FROM 
		 row_level
		 WHERE row_level.ID IN ($row_level)");
		return $result->result();
    }
    public function getRowLevel_per($rowlevel)
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
		 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID IN(".$this->session->userdata('SchoolID').")
		 WHERE level.Is_Active = 1 and row_level.ID in(".$rowlevel.")
		 group by row_level.ID
		 ")->result();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}
	}
		public function getSubject_per($subject)
	{
		$Name = 'Name' ; 
		if($Lang == 'english'){$Name = 'Name_en' ;}
		$query = $this->db->query("
		 SELECT
		 subject.ID         AS SubjectID , 
		 subject.".$Name."  AS SubjectName   
		 FROM 
		 subject  WHERE subject.Is_Active = 1 and ID IN (".$subject.")
		 ")->result();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}
	}
	 public function delete_session_group($ID)
    {
         $UID=$this->session->userdata('id');
	    
         $DATE=date("Y-m-d H:i:s");
       $this->db->query("UPDATE zoom_meetings SET is_deleted =1, 	deleted_at ='".$DATE."' ,deleted_by = '".$UID."' WHERE id =".$ID." ");
        
        return TRUE ;
    }
    /////////////////////////////////////
    public function delete_session_byMeeting($meetingID)
    {
         $UID=$this->session->userdata('id');
	    
         $DATE=date("Y-m-d H:i:s");
       $this->db->query("UPDATE zoom_meetings SET is_deleted =1, 	deleted_at ='".$DATE."' ,deleted_by = '".$UID."' WHERE meeting_id =".$meetingID." ");
        
        return TRUE ;
    }
    public function Meeting_Teacher_Report_attendence($Data)
    {
        extract($Data);
        if($type==1){
            $query = $this->db->query("SELECT   contact.Name,zoom_meetings.topic ,contact.Type AS contactType,concat(row_level.Level_Name,'_',row_level.Row_Name,'_',class.Name) AS R_L_C,employee.jobTitleID
            FROM contact
            INNER JOIN send_box_zoom ON contact.ID=send_box_zoom.contact_id
            INNER JOIN zoom_meetings ON send_box_zoom.meeting_id=zoom_meetings.id
            LEFT JOIN  student       ON contact.ID=student.Contact_ID 
            LEFT JOIN row_level      ON student.R_L_ID  = row_level.ID
            LEFT JOIN class          ON student.Class_ID  = class.ID
            LEFT JOIN  employee      ON contact.ID=student.Contact_ID 
            WHERE send_box_zoom.contact_id!= zoom_meetings.teacherid AND send_box_zoom.meeting_id = $zoomId AND contact.Isactive=1 
           GROUP BY contact.ID
           ")->result();
        }else{
            $query = $this->db->query("SELECT   contact.Name,zoom_meetings.topic ,contact.Type AS contactType,concat(row_level.Level_Name,'_',row_level.Row_Name,'_',class.Name) AS R_L_C,employee.jobTitleID
          FROM contact
            INNER JOIN vw_zoom_premission_per_contact_select AS T ON contact.ID = T.contactID AND contact.Name != ''
            INNER JOIN zoom_meetings ON T.ZoomPremissionID=zoom_meetings.group_id
            LEFT JOIN  student       ON contact.ID=student.Contact_ID 
            LEFT JOIN  row_level     ON student.R_L_ID  = row_level.ID
            LEFT JOIN  class         ON student.Class_ID  = class.ID
            LEFT JOIN  employee      ON contact.ID=student.Contact_ID 
            WHERE zoom_meetings.id = $zoomId AND contact.Isactive=1 
            AND contact.ID NOT IN(SELECT contact.ID FROM contact
            INNER JOIN send_box_zoom ON contact.ID=send_box_zoom.contact_id
            WHERE send_box_zoom.contact_id!= zoom_meetings.teacherid AND send_box_zoom.meeting_id = $zoomId AND contact.Isactive=1 
           GROUP BY contact.ID)
          GROUP BY contact.ID
          ")->result();
        }
        
        return $query ;
    }
    //////////////////////////
    public function create_emp_meeting($current_date,$teacher_id,$date)
    {
        if(empty($teacher_id)){
            $teacher_id = "NULL";
        }
            $query = $this->db->query("
            SELECT zoom_meetings.*,zoom_rooms.name as roomName 
            FROM zoom_meetings
            INNER JOIN contact ON contact.ID = zoom_meetings.teacherid
            INNER JOIN employee ON employee.Contact_ID = contact.ID
            INNER JOIN zoom_premission ON zoom_premission.ID = zoom_meetings.group_id
            INNER JOIN zoom_rooms on zoom_meetings.room_id=zoom_rooms.id 
            WHERE date(`start_time`) = '$current_date'
            AND employee.jobTitleID = 0
            AND zoom_meetings.teacherid = IFNULL($teacher_id ,zoom_meetings.teacherid)
            AND zoom_premission.SchoolID = ".$this->session->userdata('SchoolID')."
            AND zoom_meetings.`SubjectID` != 0
            AND zoom_meetings.`is_deleted` = 0
            GROUP BY  zoom_meetings.teacherid
            ORDER BY zoom_meetings.teacherid
           ");      
        return $query;
    }
    public function create_emp_all_meeting($current_date,$teacher_id)
    {
        if(empty($teacher_id)){
            $teacher_id = "NULL";
        }
            $query = $this->db->query("
            SELECT zoom_meetings.*,zoom_rooms.name as roomName 
            FROM zoom_meetings
            INNER JOIN contact ON contact.ID = zoom_meetings.teacherid
            INNER JOIN employee ON employee.Contact_ID = contact.ID
            INNER JOIN zoom_premission ON zoom_premission.ID = zoom_meetings.group_id
            INNER JOIN zoom_rooms on zoom_meetings.room_id=zoom_rooms.id 
            WHERE date(`start_time`) = '$current_date'
            AND employee.jobTitleID = 0
            AND zoom_meetings.teacherid = IFNULL($teacher_id ,zoom_meetings.teacherid)
            AND zoom_premission.SchoolID = ".$this->session->userdata('SchoolID')."
            AND zoom_meetings.`SubjectID` != 0
            AND zoom_meetings.`is_deleted` = 0
            GROUP BY  zoom_meetings.id
            
           ");      
        return $query;
    }
    //////////////////////////
    public function attend_emp_meeting($current_date,$teacher_id,$date)
    {
        if(empty($teacher_id)){
            $teacher_id = "NULL";
        }
            $query = $this->db->query("
            SELECT zoom_meetings.*,zoom_rooms.name as roomName 
            FROM zoom_meetings
            INNER JOIN contact ON contact.ID = zoom_meetings.teacherid
            INNER JOIN employee ON employee.Contact_ID = contact.ID
            INNER JOIN send_box_zoom ON send_box_zoom.meeting_id = zoom_meetings.id AND send_box_zoom.contact_id = zoom_meetings.teacherid
            INNER JOIN zoom_premission ON zoom_premission.ID = zoom_meetings.group_id
            INNER JOIN zoom_rooms on zoom_meetings.room_id=zoom_rooms.id 
            WHERE date(`start_time`) = '$current_date'
            AND employee.jobTitleID = 0
            AND zoom_meetings.teacherid = IFNULL($teacher_id ,zoom_meetings.teacherid)
            AND zoom_premission.SchoolID = ".$this->session->userdata('SchoolID')."
            AND zoom_meetings.`SubjectID` != 0
            AND zoom_meetings.`is_deleted` = 0
            AND DATE_ADD( zoom_meetings.start_time, INTERVAL zoom_meetings.duration MINUTE ) < '$date'
            GROUP BY zoom_meetings.id , zoom_meetings.teacherid
           ");      
        return $query;
    }
    //////////////////////////
    public function not_attend_emp_meeting($current_date,$teacher_id,$date)
    {
        if(empty($teacher_id)){
            $teacher_id = "NULL";
        }
            $query = $this->db->query("
            SELECT zoom_meetings.*,zoom_rooms.name as roomName
            FROM zoom_meetings
            INNER JOIN contact ON contact.ID = zoom_meetings.teacherid
            INNER JOIN employee ON employee.Contact_ID = contact.ID
            INNER JOIN zoom_premission ON zoom_premission.ID = zoom_meetings.group_id
            INNER JOIN zoom_rooms on zoom_meetings.room_id=zoom_rooms.id 
            WHERE date(`start_time`) = '$current_date'
            AND employee.jobTitleID = 0
            AND zoom_meetings.teacherid = IFNULL($teacher_id ,zoom_meetings.teacherid)
            AND zoom_premission.SchoolID = ".$this->session->userdata('SchoolID')."
            AND zoom_meetings.`SubjectID` != 0
            AND zoom_meetings.`is_deleted` = 0
            AND DATE_ADD( zoom_meetings.start_time, INTERVAL zoom_meetings.duration MINUTE ) < '$date'
            AND zoom_meetings.id not IN (SELECT zoom_meetings.id FROM `zoom_meetings`
            INNER JOIN contact ON contact.ID = zoom_meetings.teacherid
            INNER JOIN employee ON employee.Contact_ID = contact.ID
            INNER JOIN send_box_zoom ON send_box_zoom.meeting_id = zoom_meetings.id AND send_box_zoom.contact_id = zoom_meetings.teacherid
            INNER JOIN zoom_premission ON zoom_premission.ID = zoom_meetings.group_id
            WHERE date(`start_time`) = '$current_date'
            AND employee.jobTitleID = 0
            AND zoom_meetings.teacherid = IFNULL($teacher_id ,zoom_meetings.teacherid)
            AND zoom_premission.SchoolID = ".$this->session->userdata('SchoolID')."
            AND zoom_meetings.`SubjectID` != 0
            AND zoom_meetings.`is_deleted` = 0
            AND DATE_ADD( zoom_meetings.start_time, INTERVAL zoom_meetings.duration MINUTE ) < '$date'
                         )
           ");   
        return $query;
    }
    //////////////////////////
    public function not_add_emp_meeting($current_date,$teacher_id,$date)
    {
        if(empty($teacher_id)){
            $teacher_id = "NULL";
        }
            $query = $this->db->query("
            SELECT contact.ID AS teacherid,contact.Name FROM contact
            INNER JOIN employee ON employee.Contact_ID = contact.ID
            WHERE contact.Type = 'E' 
            AND contact.Isactive = 1
            AND employee.jobTitleID = 0
            AND contact.SchoolID = ".$this->session->userdata('SchoolID')."
            AND contact.ID = IFNULL($teacher_id ,contact.ID)
            AND contact.ID NOT IN (SELECT zoom_meetings.teacherid FROM `zoom_meetings`
            INNER JOIN contact ON contact.ID = zoom_meetings.teacherid
            INNER JOIN employee ON employee.Contact_ID = contact.ID
            INNER JOIN zoom_premission ON zoom_premission.ID = zoom_meetings.group_id
            WHERE date(`start_time`) = '$current_date'
            AND employee.jobTitleID = 0
            AND zoom_meetings.teacherid = IFNULL($teacher_id ,zoom_meetings.teacherid)
            AND zoom_premission.SchoolID = ".$this->session->userdata('SchoolID')."
            AND zoom_meetings.`SubjectID` != 0
            AND zoom_meetings.`is_deleted` = 0
            
                         )
                         GROUP BY contact.ID;
           ");   
        return $query;
    }
    //////////////////////
    //////////////////////////
    public function get_emp_only()
    {
        if ($this->session->userdata('language') == 'english') {
            $contactName = "CASE
                WHEN contact.Name_en IS NULL or contact.Name_en='' THEN contact.Name
                ELSE contact.Name_en
                END AS Name";
        } else {
            $contactName = "CASE
                WHEN contact.Name IS NULL or contact.Name='' THEN contact.Name_en
                ELSE contact.Name
                END AS Name";
        }
        $emp_Id       = get_emp_select_in() ;
        $sup_Id       = get_supervisor_select_in() ;
        $SchoolID     = $this->session->userdata('SchoolID') ;
        $query        = $this->db->query("SELECT contact.ID,$contactName 
                                            FROM contact 
                                            INNER JOIN employee ON employee.Contact_ID = contact.ID
                                            WHERE contact.Type = 'E' 
                                            AND contact.Isactive = 1
                                            AND employee.jobTitleID = 0
                                            AND contact.SchoolID = ".$this->session->userdata('SchoolID')." 
                                            AND contact.ID IN(".$emp_Id.", ".$sup_Id.") 
                                            ")->result();
         if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }

    public function get_meeting_info()
    {
        $query        = $this->db->query("SELECT zoom_meetings.`id`,zoom_meetings.`start_time` , meeting_report.title , meeting_report.place
                                            FROM `meeting_report` 
                                            left join zoom_meetings on meeting_report.meeting_id = zoom_meetings.id
                                            WHERE meeting_report.meeting_id = ".$this->uri->segment(4)."  group by meeting_report.meeting_id
                                            ")->row_array();
         if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }

    public function get_meeting_minutes_data()
    {
        $query        = $this->db->query("SELECT *
                                            FROM `meeting_report` 
                                            WHERE meeting_report.meeting_id = ".$this->uri->segment(4)." 
                                            ")->result();
         if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }

    public function add_meeting_minutes($data = array())
    {
        extract($data);

        $DataInsert = array(
            'title' => $title,
            'place' => $place,
            'meeting_id' => $meeting_id,
            'clause_title' => $clause_title,
            'clause' => $clause,
            'what_done' => $what_done,
            'duration_implementation' => $duration_implementation
        );

        if ($this->db->insert('meeting_report', $DataInsert)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}