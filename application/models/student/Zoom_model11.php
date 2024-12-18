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
        `start_time` REGEXP '$date' AND
        FIND_IN_SET('".$id."', Zoom_Details.Contact_ID)
         GROUP by meeting_id
        ")->result();
         
        
        
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
    
   public function Get_mettingidsxx($id)
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
        public function Get_attend_mettingidsxxx($R_L_ID)
    {   
        $query = $this->db->query("select Meeting_Id
        from zoom_meetings 
        where RowLevele_ID  = $R_L_ID
        ")->result();
          
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
     public function Get_recording_mettingids_by_emp_id($date , $subject='')
    {
        if($subject!=''){
            $where=" and SubjectID =$subject ";
        }
        $idContact = (int)$this->session->userdata('id');
        $query = $this->db->query("select zoom_meetings.*
        from zoom_meetings  
         INNER JOIN Zoom_Details ON zoom_meetings.group_id = Zoom_Details.Group_ID
        where   FIND_IN_SET('".$idContact."', Zoom_Details.Contact_ID) AND    date(start_time) = '$date' $where  and   is_deleted=0  GROUP BY zoom_meetings.id order by zoom_meetings.start_time desc limit 50 ")->result();
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
       
      //  where    FIND_IN_SET('".$idContact."', Zoom_Details.Contact_ID) AND   date(start_time) = '$date' $where  and is_deleted=0  GROUP BY zoom_meetings.id  ")->result();
    }

}