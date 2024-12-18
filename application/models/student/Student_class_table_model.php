<?php
class Student_Class_Table_Model extends CI_Model{
	private $Date='',$Encryptkey='',$Token='',$UID=0,$ClassID=0,$ClassTableID=0,$WeekID=0;
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
	/////////////////////////////////
	public function get_student_class($UID = NULL)
	{         
        $this->db->select('Class_ID,R_L_ID');    
	    $this->db->from('student');
		$this->db->where('Contact_ID',$UID);
		$this->db->limit(1);
		$query = $this->db->get();			
		if($query->num_rows() >0)
		{
			return $query->row_array();
		}else{
		    return FALSE ;
		}
	}
	////////////////////////
	public function get_base_id()
	{
		      $this->db->select('ID');    
		      $this->db->from('base_class_table');
			  $this->db->where('IsActive',1);
			  $this->db->limit(1);
			  $query = $this->db->get();			
			  if($query->num_rows() >0)
			  {$GetBaseID =  $query->row_array(); return $GetBaseID['ID']; $this->session->set_userdata('BaseTableIDPlanWeek',$BaseTableID);}
			  else{
				  if($this->db->query("INSERT INTO base_class_table SET IsActive = 1 , Token = '".$this->Token."' ")) 
				  {
					 $this->db->select('ID');    
					 $this->db->from('base_class_table');
					 $this->db->where('IsActive',1);
					 $this->db->limit(1);
					 $query = $this->db->get();			
					if($query->num_rows() >0)
					{$GetBaseID =  $query->row_array();$this->session->set_userdata('BaseTableIDPlanWeek',$GetBaseID['ID']);return $GetBaseID['ID'];} 
				  }; 
				  return FALSE ;}
	}
	///////////////////////////
	public function get_day($Lang = NULL )
	{
	     if($Lang=='arabic'){
	        $image_night = 'image_night';
	        $DayName     = 'Name';
	        $Image       ='Image';
	    }
	    else{
	        $image_night = 'image_night_en';
	        $DayName     = 'Name_en';
	        $Image       ='Image_en';
	    }
		 
			      $query = $this->db->query("
				  SELECT 
				  config_row_level.ID As ConfigID ,
				  config_row_level.NumLesson As ConfigNumLesson ,
				  day.ID As DayID ,
				  day.$DayName As DayName,
				  day.$Image As Image,
				  day.$image_night As image_night
				  FROM config_row_level 
				  INNER JOIN day ON config_row_level.DayID = day.ID 
				  where day.is_active = 1
				   GROUP BY day.ID 
		         ");
		
		 if($query->num_rows() >0)
		 {
			 return $query->result(); 
		 }else
		  {
			  return FALSE ;
		  }
	}
	///////////////////////////
	public function get_day_main_page($Lang = NULL,$day )
	{
	     if($Lang == "arabic")
		  {		 
			      $query = $this->db->query("
				  SELECT 
				  day.ID As DayID ,
				  day.Name As DayName ,
				  day.Name_en As Name
				  FROM day 
				  WHERE day.Name_en like '%$day%'
				  GROUP BY day.ID
		         ");
		  }else{
			      $query = $this->db->query("
				  SELECT 
				  day.ID As DayID ,
				  day.Name_en As DayName,
				  day.Name_en As Name
				  FROM day 
				  WHERE day.Name_en like '%$day%'
				  GROUP BY day.ID 
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
	/////////////////////////////////////////////////
	public function get_max_numlesson()
	{
	
		$GetData          = $this->db->query("SELECT max(NumLesson) AS MaxNumLesson	FROM config_row_level ");
	  if($GetData->num_rows()>0)
		{
			$GetMax          =  $GetData->row_array();
			$MaxNumLesson    = $GetMax['MaxNumLesson'];
			return $MaxNumLesson ;
		}else{
			   return FALSE ;
			 }
	}
	/////////////////////////
	public function get_level_emp($RowLevelID)
	{
			$GetData = $this->db->query
			("
			  SELECT row_level.Level_ID 
			  FROM `row_level` 
			  WHERE row_level.ID=".$RowLevelID."
			  GROUP BY row_level.Level_ID
			");
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			   return FALSE ;
			 }
	}
	//////////////////////////////
	public function get_group_day($data)
	{
	    extract($data);
		
		$query = $this->db->query("SELECT `group_day` FROM lesson GROUP BY `group_day`");
		if(!empty($query->row_array())){
			$GetData = $this->db->query
			("
			  SELECT lesson.group_day FROM class_table 
              INNER JOIN student on class_table.RowLevelID=student.R_L_ID and class_table.ClassID=student.Class_ID
               INNER JOIN lesson on class_table.Lesson=lesson.ID
               WHERE class_table.SchoolID = '".$SchoolID."' AND student.Contact_ID=".$UID."
			");
		
			$GetGroupDay       =  $GetData->row_array();
			$get_group_day     = $GetGroupDay['group_day'];
			
			if(!empty($get_group_day)){
			    $group_day     = $GetGroupDay['group_day'];
			}else{
			    if($query->num_rows()>1){
			    $group_day     = 1;
			    }else{
			      $x             =  $query->row_array(); 
			      $group_day     =  $x['group_day'];
			    }
			}
			
		}else{
		    $group_day     = 1;
		}
			return $group_day;
		
	}
	//////////////////////////////
	public function get_group_day_header($SchoolID,$UID)
	{
		
			$GetData = $this->db->query
			("
			  SELECT lesson.group_day FROM class_table 
              INNER JOIN student on class_table.RowLevelID=student.R_L_ID and class_table.ClassID=student.Class_ID
               INNER JOIN lesson on class_table.Lesson=lesson.ID
               WHERE class_table.SchoolID = '".$SchoolID."' AND student.Contact_ID=".$UID."
			");
		
		if($GetData->num_rows()>0)
		{
			$GetGroupDay       =  $GetData->row_array();
			$group_day      = $GetGroupDay['group_day'];
			return $group_day;
		}else{
			   return FALSE ;
			 }
	}
	
	public function get_group_day_header1($SchoolID)
	{
		
			$GetData = $this->db->query
			("
			  SELECT lesson.group_day FROM lesson 
			  left JOIN class_table on class_table.Lesson=lesson.ID
               WHERE class_table.SchoolID = '".$SchoolID."'
			");
		
		if($GetData->num_rows()>0)
		{
			$GetGroupDay       =  $GetData->row_array();
			$group_day      = $GetGroupDay['group_day'];
			return $group_day;
		}else{
			   return FALSE ;
			 }
	}
	/////////////////////////
	public function get_lesson_by_group_day($data)
	{
	    extract($data);
		if($Lang == 'arabic')
		{
			$GetData = $this->db->query
			("
			  SELECT ID AS LessonID , lesson AS LessonName FROM  lesson 
			  WHERE group_day = ".$group_day."
			");
		}
		else
		{
		   $GetData = $this->db->query
			("
			  SELECT ID AS LessonID , Lesson_en AS LessonName FROM  lesson
			  WHERE group_day = ".$group_day."
			");
		}
		
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			   return FALSE ;
			 } 
	}	
	//////////////////////////////
	public function get_lesson_time($semester_id,$Level_ID,$SchoolID,$LessonID)
	{
		
			$GetData = $this->db->query
			("
			  SELECT `start_time`,`end_time` 
              FROM `config_lesson`
              WHERE `semester_id` = ".$semester_id." AND `level_id`= IFNULL(".$Level_ID.", level_id) AND `school_id` = ".$SchoolID." AND `config_count` = ".$LessonID."
			");
		
		if($GetData->num_rows()>0)
		{
			return  $GetData->row_array();
		}else{
			   return FALSE ;
			 }
	}
	//////////////////////////////
	public function Get_Class_Table($BaseClassTableID,$RowLevelID,$DayID,$count,$ClassRowLevel,$SchoolID)
	{
		
			$GetData = $this->db->query
			("
			  SELECT class_table.* ,subject.icon FROM class_table 
			  inner join student on  class_table.ClassID = student.Class_ID and class_table.RowLevelID= student.R_L_ID 
			  inner join subject on class_table.SubjectID = subject.ID 
			  WHERE (class_table.RowLevelID = ".$RowLevelID."
	          AND class_table.Day_ID = ".$DayID." AND class_table.Lesson = ".$count."  AND class_table.ClassID = ".$ClassRowLevel." AND class_table.SchoolID = '".$this->session->userdata('SchoolID')."')  
	          and (CASE WHEN subject.basic=0 THEN (FIND_IN_SET(subject.ID ,student.s_language)) ELSE 1 END ) AND student.Contact_ID=".$this->session->userdata('id')."
	          LIMIT 1
			");
		
		if($GetData->num_rows()>0)
		{
			return  $GetData->row_array();
		}else{ return FALSE ;
			 }
	}
		//////////////////////////////
	public function Get_Class_Table_new($BaseClassTableID,$RowLevelID,$DayID,$count,$ClassRowLevel,$SchoolID,$chkMove)
	{
		
			$GetData = $this->db->query
			("
			  SELECT class_table.* ,subject.icon FROM class_table 
			  inner join student on  class_table.ClassID = student.Class_ID and class_table.RowLevelID= student.R_L_ID 
			  inner join subject on class_table.SubjectID = subject.ID 
			  WHERE (class_table.RowLevelID = ".$RowLevelID." and class_table.chkMove=$chkMove
	          AND class_table.Day_ID = ".$DayID." AND class_table.Lesson = ".$count."  AND class_table.ClassID = ".$ClassRowLevel." AND class_table.SchoolID = '".$this->session->userdata('SchoolID')."')  
	          and (CASE WHEN subject.basic=0 THEN (FIND_IN_SET(subject.ID ,student.s_language)) ELSE 1 END ) AND student.Contact_ID=".$this->session->userdata('id')." 
	          LIMIT 1
			");
		
		if($GetData->num_rows()>0)
		{
			return  $GetData->row_array();
		}else{ return FALSE ;
			 }
	}
	/////////////////////////nada
	//////get_week
	public function get_week($Lang = NULL, $sid = null)
	{
	    $class_data = $this->get_student_class($sid);
	    if($class_data !== false) {
	        $this->db->select('ID');
	        $this->db->from('class_table');
	        $this->db->where('ClassID', $class_data['Class_ID']);
	        $this->db->where('RowLevelID', $class_data['R_L_ID']);
	        $qu = $this->db->get();
	        if($qu->num_rows() >0) {
	           // $res = $qu->row_array();
	            $res = $qu->result();
	            $class_table_id = $res['ID'];
	        }
	    } //if($this->session->userdata('id')==83460){echo $class_table_id;die;}
		if($Lang == 'arabic')
		{
		  $this->db->select('week.ID ,week.Name ,FromDate,ToDate');
		} else {
	      $this->db->select('week.ID ,week.Name_en AS Name ,FromDate,ToDate');    
		}
		$this->db->from('week');
		if(isset($class_table_id)) {
		    $this->db->join('plan_week', 'week.ID = plan_week.WeekID');
		    $this->db->wherein('plan_week.ClassTableID', $res);
		 //   $this->db->where('plan_week.content IS NOT NULL', NULL, false);
		}
		  $query = $this->db->get();
		 
		  if($query->num_rows() >0)
		  { return $query->result();}else{return FALSE ;}
	}
	//////////////////////////////
	public function get_planweek($ClassTableID,$week,$SemesterID)
	{
	
			$GetData = $this->db->query("SELECT   plan_week.* 
            			                 FROM plan_week 
            			                 WHERE WeekID = ".$week." AND ClassTableID = ".$ClassTableID." AND SemesterID = ".$SemesterID."   LIMIT 1")->row_array();
		
	
			   return $GetData ;
			
	}
	/////////////////////////
	public function get_file_week($week = 0, $Semester = 0  , $RowLevel = 0 , $ClassID = 0 )
   {
       if ($this->session->userdata('language') == 'english') {
			
			$subjectName = "CASE
				WHEN subject.Name_en IS NULL THEN subject.Name
				ELSE subject.Name_en
				END AS SubjectName";
            $contactName = "CASE
				WHEN contact.Name_en IS NULL or contact.Name_en='' THEN contact.Name
				ELSE contact.Name_en
				END AS Name";
		} else {
			$subjectName = "subject.Name AS SubjectName";
            $contactName = "contact.Name AS Name";
		}
	   $query = $this->db->query("SELECT DISTINCT plan_week.FileAttach,subject.ID AS SubjectID ,$subjectName ,$contactName
                                  FROM plan_week
                                  INNER JOIN class_table ON plan_week.RowLevelID  = class_table.RowLevelID  and plan_week.ClassID = class_table.ClassID and plan_week.SubjectID = class_table.SubjectID
                                  INNER JOIN subject ON subject.ID=plan_week.SubjectID
                                  INNER JOIN contact ON contact.ID=plan_week.EmpID
                                  WHERE WeekID                = '".$week."'
                                  AND SemesterID              = '".$Semester."'
                                  AND plan_week.RowLevelID    = '".$RowLevel."'
                                  AND plan_week.ClassID       = '".$ClassID."'
                                  AND FileAttach <>''
								  AND contact.SchoolID        = '".$this->session->userdata('SchoolID')."'
                                  ")->result() ;


	   if(is_array($query) && sizeof($query)>0)
	   {
		   return $query ;
	   }else{return FALSE ;}
   }
   public function get_all_week($data) 
	 {
	     
	   extract($data);
	   
	   if($SemesterID){$Semester_ID = $SemesterID;}
	   
       if($this->session->userdata('language')=='arabic'){
           $name = 'Name';
       }else{
              $name = 'Name_en'; 
           }
       $query=$this->db->query("SELECT week.$name AS Name  , week.ID ,FromDate,ToDate FROM `week` WHERE semester_id = $Semester_ID ")->result() ;
       
       if(is_array($query) && sizeof($query)>0)
	   {
		   return $query ;
	   }else{return FALSE ;}
   }
	/////////////////////////
		public function get_lesson($get_max_numlesson = NULL,$Lang = NULL)
	{
		if($Lang == 'arabic')
		{
			$GetData = $this->db->query
			("
			  SELECT ID AS LessonID , lesson AS LessonName FROM  lesson WHERE ID <= ".(int)$get_max_numlesson." 
			");
		}
		else
		{
		   $GetData = $this->db->query
			("
			  SELECT ID AS LessonID , Lesson_en AS LessonName FROM  lesson WHERE ID <= ".(int)$get_max_numlesson." 
			");
		}
		
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			   return FALSE ;
			 }
	}
	
	public function get_lesson_night($get_max_numlesson = NULL,$Lang = NULL)
	{
		if($Lang == 'arabic')
		{
			$GetData = $this->db->query
			("
			  SELECT ID AS LessonID , lesson AS LessonName FROM  lesson  
			  WHERE ID > ".(int)$get_max_numlesson." 
			");
		}
		else
		{
		   $GetData = $this->db->query
			("
			  SELECT ID AS LessonID , Lesson_en AS LessonName FROM  lesson   
			 WHERE ID > ".(int)$get_max_numlesson." 
			");
		}
		
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			   return FALSE ;
			 }
	}
   
 }//////END CLASS?>