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
    
   
	 public function get_data($ID = NULL)
    {
        $query = $this->db->query("select * from row_level WHERE ID = $ID  ")->row();
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
	
    
   public function Get_mettingidsxxx($id)
    {   
        //   zoom_premission.LevelID=$levelid
        //   AND zoom_premission.RowID=$rowid
        //   AND zoom_premission.ClassID  IN ($classid)
      
        $idContact = (int)$this->session->userdata('id');
        $query = $this->db->query("select MeetingId
        from zoom_premission 
        INNER JOIN Zoom_Details ON zoom_premission.ID = Zoom_Details.Group_ID
        where
        FIND_IN_SET('".$id."', Zoom_Details.Contact_ID)
        AND zoom_premission.MeetingId IS NOT NULL  GROUP by MeetingId
        ")->result();
         
        
        
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
     public function Get_mettingids($id)
    {   
        //   zoom_premission.LevelID=$levelid
        //   AND zoom_premission.RowID=$rowid
        //   AND zoom_premission.ClassID  IN ($classid)
        $date =date("yy-m-d");
        $idContact = (int)$this->session->userdata('id');
        $query = $this->db->query("select meeting_id
        from zoom_meetings 
        INNER JOIN Zoom_Details ON zoom_meetings.group_id = Zoom_Details.Group_ID
        where
        `start_time` >= '$date' AND
        FIND_IN_SET('".$id."', Zoom_Details.Contact_ID)
         GROUP by meeting_id
        ")->result();
         
        
       // `start_time` REGEXP '$date' AND
        
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
    
     public function Get_mettingids_by_emp_id()
    {
        
        $idContact = (int)$this->session->userdata('id');
        $query = $this->db->query("select zoom_meetings.*,zoom_rooms.name as roomname
        from zoom_meetings 
        inner join zoom_rooms on zoom_meetings.room=zoom_rooms.email
         INNER JOIN Zoom_Details ON zoom_meetings.group_id = Zoom_Details.Group_ID
        where    FIND_IN_SET('".$idContact."', Zoom_Details.Contact_ID) AND date(start_time) = CURDATE() and is_deleted=0  GROUP BY zoom_meetings.id  ")->result();
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
    
    public function Get_recording_mettingids_by_emp_id($data)
    {
        extract($data);
        
        if($subject!=''){
            $where=" and SubjectID =$subject ";
        }
        
        $idContact = (int)$this->session->userdata('id');
    
        $query = $this->db->query("SELECT
                                     zoom_meetings.*
                                   FROM zoom_meetings
                                     INNER JOIN vw_zoom_premission_per_contact_select AS zoom_group
                                       ON zoom_meetings.group_id = zoom_group.ZoomPremissionID
                                       AND zoom_group.contactID = $idContact
                                       AND DATE(start_time) BETWEEN '$date_from' AND '$date_to'
                                       AND is_deleted != 1
                                   $where   
                                   GROUP BY zoom_meetings.id
                                   ORDER BY zoom_meetings.start_time DESC LIMIT 50;")->result();
        
     if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    
    }
    
    
    public function Get_mettingids1()
    {
        $idContact = (int)$this->session->userdata('id');
        $query = $this->db->query("select MeetingId
        from zoom_premission 
        INNER JOIN Zoom_Details ON zoom_premission.ID = Zoom_Details.Group_ID
        where
         Zoom_Details.Contact_ID  IN ($idContact)
        AND
        zoom_premission.MeetingId IS NOT NULL
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


        public function get_rooms()
        {
            $query = $this->db->query("select * 
            from zoom_rooms

            ")->result();
             if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
            
        }    public function Get_user_groups_ids()
    {
        $idContact = (int)$this->session->userdata('id');
        $query = $this->db->query("select Group_ID
        from Zoom_Details  
        where   FIND_IN_SET('".$idContact."', Zoom_Details.Contact_ID) 
        ")->result();
      //   echo $this->db->last_query();die;
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
        public function Get_attend_mettingids_by_RowLevele_ID($R_L_ID)
    {   
        $query = $this->db->query("select Meeting_Id
        from zoom_meetings 
        where RowLevele_ID  = $R_L_ID
        ")->result();
          
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    

}
    public function Get_attend_mettingid($group_id)
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
////////////////////
    public function summer_courses($Data)
    {
        $date = date("Y-m-d");
        
        $student_id    = $Data['student_id'];
        
        $query1=$this->db->query("select R_L_ID from student WHERE Contact_ID = $student_id ")->result();
        
        $stu_row_level=$query1[0]->R_L_ID;
    
	    $query = $this->DB1->query("select *
        from Summer_Courses 
        where  '".$date."' BETWEEN Advert_start AND Advert_finish
        ")->result();
          
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
    ///////////////////////////
    public function add_student_course($Data=array())
    {
      $Group_ID         = $Data['GroupID'];
      
      $student_id      = $Data['student_id'];
      $query4 = $this->DB1->query("select Name as course from Summer_Courses WHERE  GroupID = $Group_ID ")->row_array();
      $query3 = $this->db->query("select contact.ID, contact.Number_ID,school_details.SchoolName,contact.Name from contact
      inner join school_details on contact.SchoolID= school_details.ID
      WHERE   contact.ID = $student_id ")->row_array();
     $Number_ID= $query3['Number_ID'];
     $Branch= $query3['SchoolName'];
     $Stu_Name= $query3['Name'];
     $Stu_Id= $query3['ID'];
     $Course_Name= $query4['course'];
     
      $query=array(  
        
        "Contact_ID"        => $Number_ID,
        "Group_ID"           =>$Group_ID
        
         );
         
         $Data_Inserted=array(  
        
        "Number_ID"        => $Number_ID,
        "Branch"           =>$Branch,
        "Stu_Name"           =>$Stu_Name,
        "Stu_Id"            =>$Stu_Id,
        "Course_Name"           =>$Course_Name,
        "School"           =>' مدارس ديوان ',
        
         );
             $query1 = $this->DB1->query("select * from Zoom_Details WHERE   Group_ID = $Group_ID ")->result();
        if(sizeof($query1)> 0 ){  
         
        
          
            $Contact_ID_add=','.$Number_ID;
            $sql = "update `Zoom_Details` set Contact_ID =  CONCAT(if(Contact_ID is null ,'',Contact_ID),  '$Contact_ID_add') where Group_ID = $Group_ID  ";
            $this->DB1->query($sql); 
            $this->db->query($sql); 
            
      
           $query2 = $this->DB1->query("select * from Zoom_Details WHERE   Group_ID = $Group_ID ")->result();
           $student_id= $query2[0]->{'Contact_ID'} ;
            
            $student_id = explode(",", $student_id);
            $student_id = array_unique($student_id);
            $student_id = implode(",", $student_id); 
            
                $sql = "update `Zoom_Details` set Contact_ID =    '$student_id'  where Group_ID = $Group_ID  ";
            $this->DB1->query($sql); 
            $this->db->query($sql); 
               $this->DB1->insert('summer_cours_details',$Data_Inserted);
             return TRUE;
                   }else
                    { 
                        if($this->DB1->insert('Zoom_Details',$query)&&$this->db->insert('Zoom_Details',$query)&&$this->DB1->insert('summer_cours_details',$Data_Inserted)){return $query;}else{return FALSE ;}
                    }
      
   }
}