<?php
class Emp_Class_Table_Model extends CI_Model{
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
     ///////////////////////////////////////
     
    public function get_prepare_week($SemesterID)
	{
	    if($SemesterID == 0 ){$SemesterID = 'NULL' ; }
	    if($this->session->userdata('language')=='arabic'){
	        $semester_name = 'Name';
	        $week_name     = 'Name';
	    }
	    else{
	        $semester_name = 'Name_en';
	        $week_name     = 'Name_en';
	    }
		$query = $this->db->query("SELECT week.*,config_semester.$semester_name as semester_name,week.$week_name as week_name 
		                           FROM week
		                           INNER JOIN config_semester ON week.semester_id = config_semester.ID
		                           where week.semester_id = $SemesterID ")->result();
		 if(sizeof($query)>0){return $query ; }else{return false ; }
	}
	//////////////////////////////////////////
   public function get_file_week( $WeekID = 0 , $Semester = 0 , $ContactID = 0 ,$group_day )
   {
	$query = $this->db->query("SELECT DISTINCT plan_week.FileAttach,
	                           row_level.ID   As RowLevelID ,
                    		   class.ID       As ClassID ,
                    		   subject.ID AS SubjectID ,
	                           row_level.Level_Name     AS LevelName,
		                       row_level.Row_Name       AS RowName,
		                       class.Name AS ClassName ,
		                       subject.Name AS SubjectName,
		                       contact.Name AS contact_Name,
		                       contact.ID AS Contact_ID
                               FROM plan_week
                               INNER JOIN class_table      ON plan_week.RowLevelID    = class_table.RowLevelID  and plan_week.ClassID = class_table.ClassID and plan_week.SubjectID = class_table.SubjectID
                               INNER JOIN contact          ON plan_week.EmpID         = contact.ID
                               INNER JOIN class            ON plan_week.ClassID       = class.ID
                               INNER JOIN row_level        ON plan_week.RowLevelID    = row_level.ID
		                       INNER JOIN subject          ON plan_week.SubjectID     = subject.ID 
                               INNER JOIN lesson           ON class_table.Lesson      = lesson.ID
                               WHERE WeekID = $WeekID AND SemesterID =".$Semester." AND plan_week.EmpID = $ContactID AND lesson.group_day= $group_day AND  FileAttach <>''")->result() ;


	if(is_array($query) && sizeof($query)>0)
	{
		return $query ;
	}else{return FALSE ;}

  }
  //////////////////////////////////////////
   public function get_file_per_week( $WeekID = 0 , $Semester = 0 , $ContactID = 0 ,$group_day )
   {
	$query = $this->db->query("SELECT DISTINCT plan_week.FileAttach
		                       contact.Name AS contact_Name
                               FROM plan_week
                               WHERE WeekID = $WeekID AND SemesterID =".$Semester." AND plan_week.RowLevelID=0 AND plan_week.EmpID = $ContactID AND plan_week.GroupID= $group_day AND  FileAttach <>''")->row_array() ;


	if(is_array($query) && sizeof($query)>0)
	{
		return $query ;
	}else{return FALSE ;}

  }
  ///////////////////////////////////////////
  
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
				  WHERE day.is_active = 1
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
	//////////////////////////////////
	public function get_row_level($Lang = NULL)
	 {
		if((string)$Lang ==='english'){ 
		 
			$row_level='row_level.Level_Name_en as LevelName,row_level.Row_Name_en as RowName';
		}else{
			$row_level='row_level.Level_Name as LevelName,row_level.Row_Name as RowName';
			
			}
		  $query = $this->db->query("
		  SELECT 
		  $row_level,
		  row_level.ID AS  RowLevelID
		  FROM
		  row_level 
		  inner join student on student.R_L_ID = row_level.ID
		  inner join contact on student.Contact_ID  = contact.ID  AND contact.Isactive =1 AND contact.SchoolID = '".$this->session->userdata('SchoolID')."'
		  INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID IN(".$this->session->userdata('SchoolID').")
		  WHERE row_level.IsActive       = 1
		  group by row_level.ID
	    ");
			 if($query->num_rows() >0)
			  {return $query->result();}else{return FALSE ;}
	 }
	 //////////////////////
	 public function get_subject()
	{
	    if ($this->session->userdata('language') == 'english') {
			
			$Name = "CASE
				WHEN subject.Name_en IS NULL THEN subject.Name
				ELSE subject.Name_en 
				END  AS Name";
		} else {
			$Name = "subject.Name AS Name";
		}
		 $query = $this->db->query("
				 SELECT  subject.ID     , $Name  
				 FROM 
				 subject
				
				 
			         WHERE Is_Active = 1  
                                 GROUP BY subject.ID 
				");
			
			  if($query->num_rows() >0)
			  {return $query->result();}else{return FALSE ;}
		
		  //    $Where  = array('Is_Active'=>1);
		  //    $this->db->select('ID , $Name');    
		  //    $this->db->from('subject');
		  //    $this->db->where($Where);
		  //    $this->db->group_by('ID');
			 // $query = $this->db->get();			
			 // if($query->num_rows() >0)
			 // {return $query->result();}else{return FALSE ;}
	}
	////////////////
		public function getclass($Lang = NULL)
	{
		
		
			$GetData = $this->db->query("SELECT DISTINCT class.ID AS ClassID , class.Name AS ClassName FROM class
        		 inner join class_level on class.ID=class_level.classID
		 INNER join row_level ON class_level.levelID=row_level.Level_ID
		 INNER JOIN level ON level.ID = class_level.levelID
		 INNER JOIN school_class ON class.ID = school_class.ClassID AND school_class.SchoolID = '".$this->session->userdata('SchoolID')."'
		 INNER JOIN student        ON student.R_L_ID           = row_level.ID and student.Class_ID         = class.ID
		 INNER JOIN contact        ON student.Contact_ID      = contact.ID  AND contact.Isactive =1 AND contact.SchoolID = ".$this->session->userdata('SchoolID')."
			WHERE class.Is_Active = 1  AND school_class.SchoolID IN(".$this->session->userdata('SchoolID').")  ");
	
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			   return FALSE ;
			 }
	}
	///////////////////////
	
		public function get_lesson($get_max_numlesson = NULL,$Lang = NULL)
	{
		if($Lang=='arabic'){
	        $LessonName       ='lesson';
	    }
	    else{
	        $LessonName       ='Lesson_en';
	    }
			$GetData = $this->db->query
			("
			  SELECT ID AS LessonID ,$LessonName AS LessonName FROM  lesson WHERE ID <= ".(int)$get_max_numlesson." 
			");
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
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
	////////////////////////////////////
	public function get_lesson_night($get_max_numlesson = NULL,$Lang = NULL)
	{
		if($Lang=='arabic'){
	        $LessonName       ='lesson';
	    }
	    else{
	        $LessonName       ='Lesson_en';
	    }
			$GetData = $this->db->query
			("
			  SELECT ID AS LessonID , $LessonName AS LessonName FROM  lesson  
			  LIMIT 8, 8
			");
	
		
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			   return FALSE ;
			 }
	}
	/////////////////////////////////////////////////
	public function get_classtable($DayID,$count,$UID)
	{
	    if ($this->session->userdata('language') == 'english') {
			
		$subjectName = "CASE
			WHEN subject.Name_en IS NULL THEN subject.Name
			ELSE subject.Name_en
			END AS SubjectName";
    	} else {
    		$subjectName = "subject.Name AS SubjectName";
    	}
	
			$GetData = $this->db->query("SELECT class_table.*,row_level.Level_Name AS LevelName ,row_level.Row_Name AS RowName,subject.icon,$subjectName,
			                             class.Name as ClassName,GROUP_CONCAT(class.ID) AS classes
                                         FROM class_table 
                                         INNER JOIN row_level ON class_table.RowLevelID=row_level.ID
                                         INNER JOIN subject   ON class_table.SubjectID = subject.ID
                                         INNER JOIN class     ON class_table.ClassID=class.ID
                                         WHERE class_table.Day_ID = ".$DayID." AND class_table.Lesson = ".$count." AND class_table.EmpID = ".$UID."  LIMIT 1")->row_array();
		
	
			   return $GetData ;
			
	}
		/////////////////////////////////////////////////
	public function get_classtable_new($DayID,$count,$UID,$chkMove)
	{
	     if ($this->session->userdata('language') == 'english') {
			
    		$subjectName = "CASE
    			WHEN subject.Name_en IS NULL THEN subject.Name
    			ELSE subject.Name_en
    			END AS SubjectName";
        	} else {
        		$subjectName = "subject.Name AS SubjectName";
        	}
	
	
			$GetData = $this->db->query("SELECT class_table.*,row_level.Level_Name AS LevelName ,row_level.Row_Name AS RowName,subject.icon,$subjectName,
			                             class.Name as ClassName,GROUP_CONCAT(class.ID) AS classes
                                         FROM class_table 
                                         INNER JOIN row_level ON class_table.RowLevelID=row_level.ID
                                         INNER JOIN subject   ON class_table.SubjectID = subject.ID
                                         INNER JOIN class     ON class_table.ClassID=class.ID
                                         WHERE class_table.Day_ID = ".$DayID." AND class_table.chkMove= $chkMove
                                         AND class_table.Lesson = ".$count." AND class_table.EmpID = ".$UID."  LIMIT 1")->row_array();
		
	
			   return $GetData ;
			
	}
		/////////////////////////////////////////////////
	public function get_planweek($week,$ClassTableID,$SemesterID)
	{
	
			$GetData = $this->db->query("SELECT   plan_week.* 
            			                 FROM plan_week 
            			                 WHERE WeekID = ".$week." AND ClassTableID = ".$ClassTableID." AND SemesterID = ".$SemesterID."   LIMIT 1")->row_array();
		
	
			   return $GetData ;
			
	}
	/////////////////////////////////////////
	public function edit_plan_weeks($data = array())
	{
	    extract($data);
		
		 if ($multipleClass) {

			$classTable = $this->db->query("SELECT GROUP_CONCAT(ID) AS classTableID  FROM `class_table` WHERE `multipleClass` = $multipleClass ")->row_array();
			
			$class_tableID = $classTable['classTableID'];

			$check_plan= $this->db->query("select * from  plan_week
			                               WHERE ClassTableID  IN ($class_tableID) and WeekID=".$week." and SemesterID=".$SemesterID."
			                          ")->result();
									 
		 }else{
	    	$check_plan= $this->db->query("select * from  plan_week
			                          WHERE ClassTableID     = $class_tableID and WeekID=".$week." and SemesterID=".$SemesterID."
			                          ")->result();
		 }
 	                        
		if(empty($check_plan)){
			
		    $class_tableID = explode(",",$class_tableID);
			
			foreach ($class_tableID as $key => $value) {
				
				$Datainsert = array( 'Content' => $txtPlan,'Date_Stm' => $date,'ClassTableID'=> $value,'WeekID'=> $week,'SemesterID'=> $SemesterID ,'FileAttach'=> $FileName);
	  
	            $this->db->insert('plan_week', $Datainsert); 
			}
		    

		}else{

			$class_tableID = explode(",",$class_tableID);
			
			foreach ($class_tableID as $key => $value) {	
					

			$Dataupdate = array( 'Content' => $txtPlan,'Date_Stm' => $date ,'FileAttach' => $FileName);
			
			$this->db->where('ClassTableID', $value);
			$this->db->where('WeekID', $week);
			$this->db->where('SemesterID', $SemesterID);
			$this->db->update('plan_week', $Dataupdate); 
		   }
	    }
		$SubjectEmpID = 0 ; 
		
        $GetEmpSubjectID = $this->db->query("SELECT * FROM config_emp WHERE EmpID = '".$EmpID."'
		 AND  SubjectID = '".$SubjectID."' AND  RowLevelID = '".$RowLevelID."' and ClassID ='".$classID."'")->row_array();	
		 if(sizeof($GetEmpSubjectID) > 0 ){$SubjectEmpID = $GetEmpSubjectID['ID'] ; }else{
		     	 
			 $this->db->query("INSERT INTO config_emp SET 
		            	 EmpID = '".$EmpID."' ,  SubjectID = '".$SubjectID."' ,  RowLevelID = '".$RowLevelID."' , ClassID ='".$classID."'
			 ");
			 $SubjectEmpID = $this->db->last_query();
 
		 }
		 
	}
	///////////////////////////////////////////
	
		public function emp_plan_week_file($ContactID  = 0 , $FileName =NULL   , $Semester = 0 , $WeekID = 0  ,$type = 1)
	{
	    
		$check_plan= $this->db->query("select * from  plan_week
			                          WHERE EmpID     = $ContactID
			                          AND RowLevelID  IS NULL
			                          AND ClassTableID  = 0
			                         
			                          AND WeekID      = $WeekID
			                          AND SemesterID  = $Semester ")->row_array();
			                 
		if($check_plan['ID']==""){
		  $this->db->query("insert into  plan_week
			                          SET FileAttach   = '".$FileName."',
			                          WeekID           = $WeekID,
			                          SemesterID       = $Semester,
			                          EmpID            = $ContactID,
			                          GroupID          =$type
			                         
			                          ");
			                 
		}else{
		 $this->db->query("UPDATE plan_week
			                          SET FileAttach = '".$FileName."'
			                          WHERE EmpID      = $ContactID 
			                          AND WeekID       = $WeekID
			                          AND SemesterID   = $Semester
			                          AND GroupID           =$type
			                          ");
		}
	    
	
	    return TRUE;
	    

	}
	
	/////////////////////////////////////
	public function up_ax_plan_week_file($ContactID  = 0 , $File =NULL   , $Semester = 0 , $WeekID = 0  ,$type = 1)
	{
	     $arr1         = implode(",",$this->input->post('select_subject'));
	     $arr2         = explode(",",$arr1);
	     foreach($arr2 as $val){
	    $arr=explode('-' ,$val);
	    
	     $ClassID     =   $arr[1] ; 
		 $RowLevelID  =   $arr[0] ;
		 $SubjectID   =   $arr[2] ;
		$check_plan= $this->db->query("select * from  plan_week
			                          WHERE EmpID     = $ContactID
			                          AND RowLevelID  = $RowLevelID
			                          AND ClassID     = $ClassID
			                          AND SubjectID   = $SubjectID
			                          AND WeekID      = $WeekID
			                          AND SemesterID  = $Semester ")->result();
			                          
		if(empty($check_plan)){
		  $this->db->query("insert into  plan_week
			                          SET FileAttach   = '".$File."',
			                          WeekID           = $WeekID,
			                          SemesterID       = $Semester,
			                          EmpID            = $ContactID,
			                          RowLevelID       = $RowLevelID,
			                          ClassID          = $ClassID,
			                          SubjectID        = $SubjectID
			                          ");
			                 
		}else{
		 $this->db->query("UPDATE plan_week
			                          SET FileAttach = '".$File."'
			                          WHERE EmpID      = $ContactID
			                          AND RowLevelID   = $RowLevelID
			                          AND ClassID      = $ClassID
			                          AND SubjectID    = $SubjectID
			                          AND WeekID       = $WeekID
			                          AND SemesterID   = $Semester ");
		}
	     }
	
	    return TRUE;
	    

	}
	
	
		public function delete_plan_week_file($ContactID  = 0 , $File =NULL   , $Semester = 0 , $WeekID = 0  ,$type = 1,$RowLevelID,$ClassID,$SubjectID)
	{
	   
		if($query = $this->db->query("delete from  plan_week  where ID in(select plan_week.ID from plan_week
			                          INNER JOIN class_table ON plan_week.RowLevelID  = class_table.RowLevelID  and plan_week.ClassID = class_table.ClassID and plan_week.SubjectID = class_table.SubjectID
			                          INNER JOIN  lesson     ON class_table.Lesson     = lesson.ID
			                          WHERE plan_week.EmpID      = $ContactID
			                          AND plan_week.RowLevelID   = $RowLevelID
			                          AND plan_week.ClassID      = $ClassID
			                          AND plan_week.SubjectID    = $SubjectID
			                          AND plan_week.WeekID       = $WeekID
			                          AND plan_week.SemesterID   = $Semester
			                          AND lesson.group_day= $type) "))
	{
	    return TRUE;
	    
	}
	}
	
	public function delete_plan_week_file_class($ContactID,$File =NULL ,$Semester = 0 , $WeekID = 0 ,$RowLevelID,$ClassID,$SubjectID)
	{
	   
		if($query = $this->db->query("delete from  plan_week  where ID in(select plan_week.ID from plan_week
			                          INNER JOIN class_table ON plan_week.RowLevelID  = class_table.RowLevelID  and plan_week.ClassID = class_table.ClassID and plan_week.SubjectID = class_table.SubjectID
			                          INNER JOIN  lesson     ON class_table.Lesson     = lesson.ID
			                          WHERE plan_week.EmpID      = $ContactID
			                          AND plan_week.RowLevelID   = $RowLevelID
			                          AND plan_week.ClassID      = $ClassID
			                          AND plan_week.SubjectID    = $SubjectID
			                          AND plan_week.WeekID       = $WeekID
			                          AND plan_week.SemesterID   = $Semester
			                          ) "))
	{
	    return TRUE;
	    
	}
	}
	//////////////////////////////////////////////////////////
	public function Checklesson($data=array())
	{
	    extract($data);
	    if($this->get_base_id()){$BaseTabeID = $this->get_base_id();}
	    $query = $this->db->query("
	                        SELECT class_table.* ,contact.Name AS empName,contact.ID AS empID,subject.basic
	                        FROM `class_table` 
	                        INNER JOIN contact ON contact.ID = class_table.EmpID
	                        INNER JOIN subject ON subject.ID = class_table.SubjectID
	                        WHERE `RowLevelID` = $GetRLID 
	                        AND `Lesson` = $lessonID
	                        AND `Day_ID` = $DayID
	                        AND `ClassID` IN($ClassID)
	                        AND `BaseTableID` = $BaseTabeID
	                        AND class_table.`SchoolID` = $SchoolID
	                        AND chkMove =$chkMove
	                        LIMIT 1
	    ")->row_array();
	    $sub = $this->db->query("select basic from subject where ID=$get_subject ")->row_array();
	    if(!empty($query))
	    {
	        $EmpID     = $query['EmpID'];
			if(($EmpID != $UID && $EmpID != 0 && (($sub['basic']==1&&$query['basic']==1)||($sub['basic']==1&&$query['basic']==0)||($sub['basic']==0&&$query['basic']==1))&&$rotation!=1)
			||($query['chkMove']==1 && $teaching==1)||($query['chkMove']==2 && $teaching==2)||($query['chkMove']==0 && $rotation==1 &&$EmpID != $UID)||($rotation==2 && ($query['chkMove']==1||$query['chkMove']==2)))
			{
				return $query;
			}else{
	        return 1;
	        }
	    }else{
	        return 1;
	    }
	 
	}
	/////////////////////////////////
	public function class_table_update($data = array())
	{
		extract($data);
		$multipleClass = rand(100000,999999);
		if(!$teaching){$teaching=0;}
		////////////////////////CHECK SUBJECT AND ROW LEVEL ID  
		$WHERE  = array('SubjectID'=>$get_subject,'RowLevelID'=>$GetRLID);
		$this->db->select('ID');    
		$this->db->from('config_subject');
		$this->db->where($WHERE);
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() == 0)
		{$this->db->query("INSERT INTO config_subject SET SubjectID = ".$get_subject." ,RowLevelID = ".$GetRLID.",DateStm = '$Timezone'") ;}
		////////////////////////GET BASE TABLE ID 
		if($this->get_base_id()){$BaseTabeID = $this->get_base_id();}
		
		$get_day_lesson = $this->get_day_lesson($lessonID ,$DayID);
		
		/////////////////////CHECK DATA SENT INTO CLASS TABLE USER ADD NEW ROW OR UPDATE 

		$Where1 = array('RowLevelID'=>$GetRLID,'Lesson'=>$lessonID,'Day_ID'=>$DayID,'SchoolID' => $SchoolID , 'EmpID' => $UID );
		$this->db->select('*');    
		$this->db->from('class_table');
		$this->db->where($Where1);
		$this->db->where(" ClassID IN($ClassID) ");
		$this->db->limit(1);
		$query = $this->db->get();	
	
	    if($query->num_rows() <=0){
	    $Where = array('RowLevelID'=>$GetRLID,'Lesson'=>$lessonID,'Day_ID'=>$DayID,'SchoolID' => $SchoolID);
	    
		$this->db->select('*');    
		$this->db->from('class_table');
		$this->db->where($Where);
		$this->db->where(" ClassID IN($ClassID) ");
		$this->db->limit(1);
	    $query = $this->db->get();	
	    }
		
	    if($query->num_rows() >0)
	    { 
			$GetData       = $query->row_array();
			$EmpID         = $GetData['EmpID'];
			$ClassTableID  = $GetData['ID'];
			$subject_id    = $GetData['SubjectID'];
			$chkMove       = $GetData['chkMove'];

			if($EmpID != $UID && $EmpID != 0 )
			{
    			    $check_sub = $this->db->query("select basic from subject where ID=$get_subject")->row_array();
    			    $check_sub_get = $this->db->query("select basic from subject where ID=$subject_id")->row_array();
    			    
    	            if(($check_sub['basic']==0 && $check_sub_get['basic']==0)||($rotation==1 && $chkMove!=0 && $chkMove!=$teaching)){
						
    	                foreach ($classId as $key => $value) {

							if (count($classId) != 1) {
								$multipleClass = $multipleClass;
							}else {
								$multipleClass = "";
							}
							
						
							$DataInsert = array(
												'BaseTableID'   => $BaseTabeID, 
												'LessonDayID'   => $get_day_lesson,
												'Day_ID'        => $DayID,
												'RowLevelID'    => $GetRLID,
												'ClassID'       => $value,
												'multipleClass' => $multipleClass,
												'EmpID'         => $UID,
												'SubjectID'     => $get_subject,
												'SchoolID'      => $SchoolID ,
												'Lesson'        => $lessonID,
												'chkMove'       => $teaching,
												'start_time'    => $lessonFromDate,
												'end_time'      => $lessonToDate,
												'ConID'         => $this->session->userdata('id'),
												'Token'         => $this->get_token(),
												'Date_Stm'      => $Timezone
												);
												$insert = $this->db->insert('class_table', $DataInsert);
											}				
												if($insert){
												 return true; 
												}else{
													return false; 
												}
    	            
    	                
    	            }else{
    	                return 0 ;
    	            }
			
			}
			else if($EmpID == $UID && $BasicClassTableID !=0)
			{
				$Where = array('Lesson'=>$lessonID,'Day_ID'=>$DayID,'SchoolID' => $SchoolID , 'EmpID' => $UID );
				$this->db->select('*');    
				$this->db->from('class_table');
				$this->db->where($Where);
				// $this->db->limit(1);
				$query = $this->db->get();	
				
				if($query->num_rows() >0)
				{
					if (count($classId) == count($query->result())) {
						foreach ($classId as $key => $cls) {
							
							$update = $this->db->query("UPDATE class_table 
							                  SET 
											  SubjectID = ".$get_subject." ,
					                          ClassID = ".$cls." ,
											  RowLevelID = ".$GetRLID." , 
											  SchoolID = ".$SchoolID." ,
											  chkMove = $teaching , 
											  Date_Stm = '$Timezone',
											  ConID= ".$this->session->userdata('id')." 
											  WHERE ID  = ".$query->result()[$key]->ID." 
											  ");
						}
						if($update){
							   return true; 
						   }else{
							   return false; 
						   }
					}
					elseif (count($classId) < count($query->result())) {
						
						$arr = [];
						foreach ($classId as $key => $cls) {
							
							$update = $this->db->query("UPDATE class_table 
							                  SET 
											  SubjectID = ".$get_subject." ,
					                          ClassID = ".$cls." ,
											  RowLevelID = ".$GetRLID." , 
											  SchoolID = ".$SchoolID." ,
											  chkMove = $teaching , 
											  Date_Stm = '$Timezone',
											  ConID= ".$this->session->userdata('id')." 
											  WHERE ID  = ".$query->result()[$key]->ID." 
											  ");
											  array_push($arr,$query->result()[$key]->ID);				  
						}
						$deleteID = implode(",",$arr);
						
						$getMultipleClass = $this->db->query("select multipleClass from class_table where ID IN($deleteID) ")->row_array();

						$multiple_Class = $getMultipleClass['multipleClass'];
						
						$checkDelete = $this->db->query("select * from class_table where ID NOT IN($deleteID) AND multipleClass = ".$multiple_Class." ")->result();
						
                        $deleted_by=$this->session->userdata('id');

                         foreach ($checkDelete as $key => $value) {

						$DATA = array_merge((array)$value, array('deleted_by' => $deleted_by));
						
						
						$this->db->insert('temp_class_table',$DATA);

						$dele = $this->db->query(" DELETE  FROM class_table WHERE ID =  '".$value->ID."'"); 

					  }
					  if($dele){
						return true; 
					   }else{
						   return false; 
					   }

					}elseif (count($classId) > count($query->result())) {
						$arr = [];
						foreach ($query->result() as $key => $clsTabID) {
							
							$update = $this->db->query("UPDATE class_table 
							                  SET 
											  SubjectID = ".$get_subject." ,
					                          ClassID = ".$classId[$key]." ,
											  multipleClass = ".$multipleClass.",
											  RowLevelID = ".$GetRLID." , 
											  SchoolID = ".$SchoolID." ,
											  chkMove = $teaching , 
											  Date_Stm = '$Timezone',
											  ConID= ".$this->session->userdata('id')." 
											  WHERE ID  = ".$clsTabID->ID." 
											  ");
											  array_push($arr,$classId[$key]);
						}
						
						$result   = array_diff($classId,$arr);
				
				        foreach ($result as $key => $value) {
					
				
					    $DataInsert = array(
										'BaseTableID'   => $BaseTabeID, 
										'LessonDayID'   => $get_day_lesson,
										'Day_ID'        => $DayID,
										'RowLevelID'    => $GetRLID,
										'ClassID'       => $value,
										'multipleClass' => $multipleClass,
										'EmpID'         => $UID,
										'SubjectID'     => $get_subject,
										'SchoolID'      => $SchoolID ,
										'Lesson'        => $lessonID,
										'chkMove'       => $teaching,
										'start_time'    => $lessonFromDate,
    									'end_time'      => $lessonToDate,
										'ConID'         => $this->session->userdata('id'),
										'Token'         => $this->get_token(),
										'Date_Stm'      => $Timezone
										);
										$insert = $this->db->insert('class_table', $DataInsert);
									}				
										if($insert){
										 return true; 
                    					}else{
                    					    return false; 
                    					}

	
					  }

					}
				}else{
					
					return false; 
				}
		}else{

            if($BasicClassTableID !=0 )
			{
				$Where = array('Lesson'=>$lessonID,'Day_ID'=>$DayID,'SchoolID' => $SchoolID , 'EmpID' => $UID );
				$this->db->select('*');    
				$this->db->from('class_table');
				$this->db->where($Where);
				$query = $this->db->get();	
				
				if($query->num_rows() >0)
				{
					if (count($classId) == count($query->result())) {
						foreach ($classId as $key => $cls) {
							
							$update = $this->db->query("UPDATE class_table 
							                  SET 
											  SubjectID = ".$get_subject." ,
					                          ClassID = ".$cls." ,
											  RowLevelID = ".$GetRLID." , 
											  SchoolID = ".$SchoolID." ,
											  chkMove = $teaching , 
											  Date_Stm = '$Timezone',
											  ConID= ".$this->session->userdata('id')." 
											  WHERE ID  = ".$query->result()[$key]->ID." 
											  ");
						}
						if($update){
							   return true; 
						   }else{
							   return false; 
						   }
					}
					elseif (count($classId) < count($query->result())) {
						$arr = [];
						foreach ($classId as $key => $cls) {
							
							$update = $this->db->query("UPDATE class_table 
							                  SET 
											  SubjectID = ".$get_subject." ,
					                          ClassID = ".$cls." ,
											  RowLevelID = ".$GetRLID." , 
											  SchoolID = ".$SchoolID." ,
											  chkMove = $teaching , 
											  Date_Stm = '$Timezone',
											  ConID= ".$this->session->userdata('id')." 
											  WHERE ID  = ".$query->result()[$key]->ID." 
											  ");
											  array_push($arr,$query->result()[$key]->ID);				  
						}
						
						$deleteID = implode(",",$arr);
						
						$getMultipleClass = $this->db->query("select multipleClass from class_table where ID IN($deleteID) ")->row_array();

						$multiple_Class = $getMultipleClass['multipleClass'];
						
						$checkDelete = $this->db->query("select * from class_table where ID NOT IN($deleteID) AND multipleClass = ".$multiple_Class." ")->result();
						
                        $deleted_by=$this->session->userdata('id');
                         foreach ($checkDelete as $key => $value) {
						$DATA = array_merge((array)$value, array('deleted_by' => $deleted_by));
						
						
						$this->db->insert('temp_class_table',$DATA);

						$dele = $this->db->query(" DELETE  FROM class_table WHERE ID =  '".$value->ID."'");

					}
					if($dele){
						return true; 
				   }else{
					   return false; 
				   }

					}elseif (count($classId) > count($query->result())) {
						$arr = [];
						foreach ($query->result() as $key => $clsTabID) {
							
							$update = $this->db->query("UPDATE class_table 
							                  SET 
											  SubjectID = ".$get_subject." ,
					                          ClassID = ".$classId[$key]." ,
											  multipleClass = ".$multipleClass.",
											  RowLevelID = ".$GetRLID." , 
											  SchoolID = ".$SchoolID." ,
											  chkMove = $teaching , 
											  Date_Stm = '$Timezone',
											  ConID= ".$this->session->userdata('id')." 
											  WHERE ID  = ".$clsTabID->ID." 
											  ");
											  array_push($arr,$classId[$key]);
						}
						
						$result   = array_diff($classId,$arr);
				
				        foreach ($result as $key => $value) {
					
				
					    $DataInsert = array(
										'BaseTableID'   => $BaseTabeID, 
										'LessonDayID'   => $get_day_lesson,
										'Day_ID'        => $DayID,
										'RowLevelID'    => $GetRLID,
										'ClassID'       => $value,
										'multipleClass' => $multipleClass,
										'EmpID'         => $UID,
										'SubjectID'     => $get_subject,
										'SchoolID'      => $SchoolID ,
										'Lesson'        => $lessonID,
										'chkMove'       => $teaching,
										'start_time'    => $lessonFromDate,
    									'end_time'      => $lessonToDate,
										'ConID'         => $this->session->userdata('id'),
										'Token'         => $this->get_token(),
										'Date_Stm'      => $Timezone
										);
										$insert = $this->db->insert('class_table', $DataInsert);
									}				
										if($insert){
										 return true; 
                    					}else{
                    					    return false; 
                    					}

	
					  }
				   	
				}
			}else{
				
				foreach ($classId as $key => $value) {

					if (count($classId) != 1) {
						$multipleClass = $multipleClass;
					}else {
						$multipleClass = "";
					}
					
				
					$DataInsert = array(
										'BaseTableID'   => $BaseTabeID, 
										'LessonDayID'   => $get_day_lesson,
										'Day_ID'        => $DayID,
										'RowLevelID'    => $GetRLID,
										'ClassID'       => $value,
										'multipleClass' => $multipleClass,
										'EmpID'         => $UID,
										'SubjectID'     => $get_subject,
										'SchoolID'      => $SchoolID ,
										'Lesson'        => $lessonID,
										'chkMove'       => $teaching,
										'start_time'    => $lessonFromDate,
    									'end_time'      => $lessonToDate,
										'ConID'         => $this->session->userdata('id'),
										'Token'         => $this->get_token(),
										'Date_Stm'      => $Timezone
										);
										$insert = $this->db->insert('class_table', $DataInsert);
									}				
										if($insert){
										 return true; 
                    					}else{
                    					    return false; 
                    					}	   
					}
			 }
		
	}
	/////////////
	public function empty_emp_class_table($class_table_id)
	{
	   
		$cheak = $this->db->query("SELECT *  FROM class_table  WHERE ID =  '".$class_table_id."'")->row_array();

		if (!empty($cheak['multipleClass'])) {

			$select = $this->db->query("SELECT *  FROM class_table  WHERE multipleClass =  '".$cheak['multipleClass']."'")->result(); // for tow classes in one lesson

		}else {

			$select = $this->db->query("SELECT *  FROM class_table  WHERE ID =  '".$class_table_id."'")->result();

		}

			  if(!empty($select)){

				$deleted_by=$this->session->userdata('id');
				
					foreach ($select as $key => $value) {
						$DATA = array_merge((array)$value, array('deleted_by' => $deleted_by));
						
						
						$this->db->insert('temp_class_table',$DATA);

					}
			     }
		if (!empty($cheak['multipleClass'])) {

			$this->db->query(" DELETE  FROM class_table WHERE multipleClass =  '".$cheak['multipleClass']."'"); 
			return true;

		}else {

			$this->db->query(" DELETE  FROM class_table WHERE ID =  '".$class_table_id."'"); 
			return true;

		}		 
	    
	}
//////////////////////////////////////////
   public function GetClassTable($BaseClassTableID,$DayID,$count,$UID)
   {
	if ($this->session->userdata('language') == 'english') {
		$row_level='row_level.Level_Name_en as Level_Name,row_level.Row_Name_en as Row_Name';	
		$subjectName = "CASE
			WHEN subject.Name_en IS NULL THEN subject.Name
			ELSE subject.Name_en
			END AS subjectName";
	} else {
		$subjectName = "subject.Name AS subjectName";
		$row_level='row_level.Level_Name as Level_Name,row_level.Row_Name as Row_Name';
	}
	$query = $this->db->query(" SELECT class_table.ID AS BasicClassTableID ,row_level.ID AS row_level_ID ,row_level.Level_ID,$row_level,
						        subject.ID AS subjectID,$subjectName,subject.icon,class_table.chkMove ,
						        class_table.start_time AS lesson_start_time ,class_table.end_time AS lesson_end_time,class_table.multipleClass,
						        GROUP_CONCAT(class.ID) AS classID, class.Name AS className
                                FROM class_table 
                                INNER JOIN row_level ON row_level.ID = class_table.RowLevelID
                                INNER JOIN subject ON subject.ID = class_table.SubjectID
                                INNER JOIN class ON class.ID = class_table.ClassID
                                WHERE Day_ID = ".$DayID." AND Lesson = ".$count." AND EmpID = ".$UID." LIMIT 1
                            ")->row_array(); 


	if(sizeof($query)>0)
	{
		return $query ;
	}else{return FALSE ;}

  }
  //////////////////////////////////////////
   public function GetClassTable_new($BaseClassTableID,$DayID,$count,$UID,$chkMove)
   {
	if ($this->session->userdata('language') == 'english') {
			
		$subjectName = "CASE
			WHEN subject.Name_en IS NULL THEN subject.Name
			ELSE subject.Name_en
			END AS subjectName";
	} else {
		$subjectName = "subject.Name AS subjectName";
	}
	$query = $this->db->query(" SELECT class_table.ID AS BasicClassTableID ,row_level.ID AS row_level_ID ,row_level.Level_ID,row_level.Level_Name, row_level.Row_Name,
						        subject.ID AS subjectID,$subjectName,subject.icon,class_table.chkMove,class_table.multipleClass,
						        GROUP_CONCAT(class.ID) AS classID, class.Name AS className
                                FROM class_table 
                                INNER JOIN row_level ON row_level.ID = class_table.RowLevelID
                                INNER JOIN subject ON subject.ID = class_table.SubjectID
                                INNER JOIN class ON class.ID = class_table.ClassID
                                WHERE Day_ID = ".$DayID." AND Lesson = ".$count." AND EmpID = ".$UID." and class_table.chkMove=$chkMove LIMIT 1
                            ")->row_array();


	if(sizeof($query)>0)
	{
		return $query ;
	}else{return FALSE ;}

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
	public function getclass_based_student($Lang,$rowLavel)
	{

		if ($Lang == 'english') {
			$row_level='row_level.Level_Name_en as LevelName,row_level.Row_Name_en as RowName';	
			 $Name = 'Name_en';
		 } else {
			 $Name = 'Name';
			 $row_level='row_level.Level_Name as LevelName,row_level.Row_Name as RowName';
		 }
		$query = $this->db->query("
		  SELECT
		  class.ID  AS ClassID ,
		  class.".$Name." AS ClassName ,
		  $row_level,
		  row_level.ID     As RowLevelID 
		  FROM class
		  INNER JOIN student on student.Class_ID = class.ID
		  INNER JOIN row_level ON row_level.ID = student.R_L_ID
		  INNER JOIN class_level on class.ID=class_level.classID and row_level.Level_ID=class_level.levelID
          INNER JOIN contact ON contact.ID = student.Contact_ID
          INNER JOIN school_class ON class.ID = school_class.ClassID 
		  where 
		  contact.SchoolID = '".$this->session->userdata('SchoolID')."'
		  and  contact.Isactive =1
		  AND row_level.ID = ".$rowLavel." AND class.Is_Active = 1
		  GROUP BY student.Class_ID , row_level.ID
           ")->result();
		return $query  ;
	}
	/////////////////////////
	public function getrowlevel_emp()
	 {
		 $Lang = $this->session->userdata('language');
		 $idContact = (int)$this->session->userdata('id'); 
 		 if((string)$Lang ==='english'){ 
		 
		      $this->db->select('row_level.Level_Name_en as level,row_level.Row_Name_en as row,config_row_level_emp.ID as config_ID,row_level.ID as RowLevelID');
		  }else{
		      $this->db->select('row_level.Level_Name as level,row_level.Row_Name as row,config_row_level_emp.ID as config_ID,row_level.ID as RowLevelID');
			  
			  }
			$this->db->from('config_row_level_emp');
			$this->db->join('row_level','row_level.ID = config_row_level_emp.row_levelID');
			$this->db->where('config_row_level_emp.empID',$idContact); 
			$this->db->group_by('row_level.ID'); 
			$this->db->order_by('row_level.ID'); 
			$Result = $this->db->get(); 
			if($Result->num_rows()>0)
			{
				$ReturnResult = $Result->result() ;
				return $ReturnResult ;
			}else{
				return 0 ;
			}
	 }
	 ////////////////////////////
	 public function getsubject_emp()
	 {
		$Lang = $this->session->userdata('language');
		$idContact = (int)$this->session->userdata('id'); 
		if ($Lang == 'english') {
		   
		  $subjectName = "CASE
		   WHEN subject.Name_en IS NULL THEN subject.Name
		   ELSE subject.Name_en
		   END AS Name";
		   } else {
			   $subjectName = "subject.Name AS Name";
		   }
		   $Result=$this->db->query("select $subjectName,config_subject_emp.ID as config_ID,subject.ID  as subject_ID
		   from config_subject_emp
		   inner join subject on subject.ID = config_subject_emp.subjectID
		   where config_subject_emp.empID=$idContact
		   group by config_subject_emp.subjectID");
		   if($Result->num_rows()>0)
		   {
			   $ReturnResult = $Result->result() ;
			   return $ReturnResult ;
		   }else{
			   return 0 ;
		   }
	 }
	 /////////////////////////////
	 public function get_level_table()
	{
			$GetData = $this->db->query
			("
			  SELECT row_level.Level_ID 
			  FROM `config_row_level_emp` 
			  INNER JOIN row_level ON row_level.ID = config_row_level_emp.row_levelID 
			  WHERE config_row_level_emp.empID=".$this->session->userdata('id')."
			  GROUP BY row_level.Level_ID
			");
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			   return FALSE ;
			 }
	}
	////////////////////////
	public function get_emp_config()
	{
	    $ifExist = $this->db->query("
		SELECT 
		ID
		FROM 
		config_emp_school
		WHERE  SchoolID = '".$this->session->userdata('SchoolID')."'  
		");
		if($ifExist->num_rows()==0){
		    	$GetData = $this->db->query("
            	INSERT INTO `config_emp_school`( `schoolID`,  `contactID`, `Token`) VALUES ('".$this->session->userdata('SchoolID')."' ,'".$this->session->userdata('id')."', '".$this->get_token()."')  
            		"); 
		}
		$GetData = $this->db->query("
		SELECT 
		*
		FROM 
		config_emp_school
		WHERE  SchoolID = '".$this->session->userdata('SchoolID')."'  
		");
		if($GetData->num_rows()>0){return $GetData->row_array();}else{return FALSE ; }
	}
	////////////////////////
	private function get_day_lesson($lessonID = 0 , $DayID = 0)
	{
		$WHERE  = array('lessonID'=>$lessonID,'DayID'=>$DayID);
		$this->db->select('ID');    
		$this->db->from('day_lesson');
		$this->db->limit(1);
		$this->db->where($WHERE);
		$query = $this->db->get();
		if($query->num_rows() >0)
		{$GetDayLesson =  $query->row_array(); return $GetDayLesson['ID'];}else{exit('error 3 ') ; ;}///// CHECK AND GET ID 
	}
	///////////////////////////////////
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
		         ");
		  }else{
			      $query = $this->db->query("
				  SELECT 
				  day_zoom.ID As DayID ,
				  day_zoom.Name_En As DayName,
				  day_zoom.Name_En As Name
				  FROM day_zoom
				  GROUP BY day_zoom.ID 
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
	////////////////////////////////////////rania
	//////get_week
	public function get_week($Lang = NULL)
	{
		if($Lang == 'arabic')
		{
		  $this->db->select('ID ,Name,FromDate,ToDate ');    
		  $this->db->from('week');
		}
		else{
		      $this->db->select('ID ,Name_en AS Name ,FromDate,ToDate ');    
		      $this->db->from('week');
			}
			  $query = $this->db->get();			
			  if($query->num_rows() >0)
			  {return $query->result();}else{return FALSE ;}
	}
	///////////////////
	
	
	//////get_emp_class
	public function get_emp_class($Lang = NULL , $UID = 0)
	{
       $GetSubConfig = $this->db->query("SELECT SubjectID  , RowLevelID , EmpID ,ClassID FROM class_table  WHERE SubjectID >0 AND RowLevelID >0  
       group BY SubjectID ,  RowLevelID, EmpID ,ClassID  ORDER BY SubjectID ,  RowLevelID  ")->result();
		if(sizeof($GetSubConfig)>0)
		{
			foreach($GetSubConfig as $Key=>$Config)
			{
				$CheckConfig = $this->db->query("SELECT ID FROM config_subject WHERE SubjectID	='".$Config->SubjectID."' AND RowLevelID		='".$Config->RowLevelID."' ")->num_rows();
				if($CheckConfig <=0 )
				{
					$this->db->query("INSERT INTO config_subject SET SubjectID	='".$Config->SubjectID."', RowLevelID		='".$Config->RowLevelID."' ");

                    $CheckConfigEmp = $this->db->query("SELECT ID FROM config_emp  WHERE SubjectID	='".$Config->SubjectID."' AND RowLevelID		='".$Config->RowLevelID."' AND EmpID = '".$Config->EmpID ."' ")->num_rows();
                  if($CheckConfigEmp <=0 )
				    {

                  $this->db->query("INSERT INTO config_emp SET SubjectID	='".$Config->SubjectID."', RowLevelID ='".$Config->RowLevelID."'  , EmpID = '".$Config->EmpID ."' , ClassID = '".$Config->ClassID ."' ");
				
     }
}
                else{
                   	$CheckConfig_emp = $this->db->query("SELECT ID FROM config_emp WHERE SubjectID	='".$Config->SubjectID."' AND RowLevelID		='".$Config->RowLevelID."'AND EmpID	='".$Config->EmpID."' ")->num_rows();
                	if($CheckConfig_emp <=0 )
                				{
                 
                                    $this->db->query("INSERT INTO config_emp SET SubjectID	='".$Config->SubjectID."', RowLevelID ='".$Config->RowLevelID."'  , EmpID = '".$Config->EmpID ."' , ClassID = '".$Config->ClassID ."'  ");

                }
                    
                }
			}

		}
		if($Lang == 'arabic')
		{
			$query = $this->db->query("
			 SELECT 
			 class_table.ID AS ClassTableID ,
			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
			 level.Name     AS LevelName,
			 row.Name       AS RowName,
			 row_level.ID   As RowLEvelID ,
			 class.Name     AS ClassName
			 FROM 
			 class_table
			 INNER JOIN base_class_table ON class_table.BaseTableID = base_class_table.ID
			 INNER JOIN class            ON class_table.ClassID     = class.ID
			 INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID        = row.ID
			 INNER JOIN level            ON row_level.Level_ID      = level.ID
			 WHERE base_class_table.IsActive = 1 
			 AND   class_table.EmpID = ".$UID."
			 GROUP BY class_table.RowLevelID , class_table.ClassID
			");
		}
		else{
			   $query = $this->db->query("
				 SELECT 
				 class_table.ID AS ClassTableID ,
				 level.ID       AS LevelID,
				 row.ID         AS RowID,
				 class.ID       AS ClassID,
				 level.Name_en  AS LevelName,
				 row.Name_en    AS RowName,
				 class.Name_en  AS ClassName
				 FROM 
				 class_table
				 INNER JOIN base_class_table ON class_table.BaseTableID = base_class_table.ID
				 INNER JOIN class            ON class_table.ClassID     = class.ID
				 INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
				 INNER JOIN row              ON row_level.Row_ID        = row.ID
				 INNER JOIN level            ON row_level.Level_ID      = level.ID
				 WHERE base_class_table.IsActive = 1 
				 AND   class_table.EmpID = ".$UID."
				 GROUP BY class_table.RowLevelID , class_table.ClassID
				");
			}
			  if($query->num_rows() >0)
			  {return $query->result();}else{return FALSE ;}
	}
	//////get_emp_plan_week
	public function get_plan_week($data = array())
	{
		extract($data);
		$this->UID           = $UID ; 
		$this->ClassTableID  = $EmpClass ; 
		$this->WeekID        = $week ; 
		$Where  = array('ID'=> $this->ClassTableID,'EmpID'=>$this->UID);
		$this->db->select('RowLevelID,ClassID,BaseTableID');    
		$this->db->from('class_table');
		$this->db->where($Where);
        $query = $this->db->get();			
		if($query->num_rows() >0)
		{
			$GetData     = $query->row_array();
			$RowLevelID  = $GetData['RowLevelID'];
			$ClassID     = $GetData['ClassID'];
			$BaseTableID = $GetData['BaseTableID'];
			$Where  = array('RowLevelID'=>$RowLevelID ,'EmpID'=>$this->UID,'BaseTableID'=>$BaseTableID);
			$this->db->select('ID');    
			$this->db->from('class_table');
			$this->db->where($Where);
			$query = $this->db->get();
			 if($query->num_rows() >0)
		     {
				 $this->session->set_userdata('RowLevelPlanWeek',$RowLevelID);
				 $this->session->set_userdata('ClassIDPlanWeek',$ClassID);
				 $this->session->set_userdata('BaseTableIDPlanWeek',$BaseTableID);
				 $ClassTableArray = array();
				 foreach($query->result() as $Key=>$RowClassTable)
				 {
					$ClassTableID      =  $RowClassTable->ID;
					$ClassTableArray[] = $ClassTableID ; 
				 }
				
				 if(sizeof($ClassTableArray)>0)
				 {
					 $ClassTableArrayImp = implode(',',$ClassTableArray);
					 $query = $this->db->query("SELECT * FROM plan_week WHERE WeekID = ".$this->WeekID." AND ClassTableID IN(".$ClassTableArrayImp.")");
					 if($query->num_rows()>0)
					 {
						   return TRUE;
					 }else{
						    foreach($ClassTableArray as $Key=>$ValueClassID)
							{
							  $query = $this->db->query("
							  INSERT INTO plan_week
							  SET
							  ClassTableID = '".$ValueClassID."' ,
							  WeekID       = '".$this->WeekID."' ,
							  Content      = '' ,
							  Token        = '".$this->get_token()."'
							  ");
							}
						$query = $this->db->query("SELECT * FROM plan_week WHERE WeekID = ".$this->WeekID." AND ClassTableID IN(".$ClassTableArrayImp.")");
							 if($query->num_rows()>0)
							 {
								   return TRUE;
							 }else{return FALSE ;}
						  }
				}else{return FALSE ;} 
		     }else{return FALSE ;}	 
		}else{return FALSE ;}
	}
	////////////get_emp_subjects
	public function get_emp_subjects($Lang = NULL , $UID)
	{
	    $Level_Name = 'Level_Name';
	    $Row_Name = 'Row_Name';
	  	if($Lang == 'english')
		{$Level_Name = 'Level_Name_en';$Row_Name = 'Row_Name_en';}
			   $query = $this->db->query("
				 SELECT 
			     level.ID               AS LevelID,
				 row_level.$Level_Name  AS LevelName,
			     row_level.$Row_Name    AS RowName,
				 row_level.ID           AS RowLevelID,
				 subject.ID             AS SubjectID,
				 CASE
					WHEN '$Lang' = 'english' and subject.Name_en IS not NULL and subject.Name_en !=' ' THEN subject.Name_en
					ELSE subject.Name
					END AS SubjectName 
				 FROM 
				 class_table
				 INNER JOIN subject          ON class_table.SubjectID   = subject.ID
				 INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
				 INNER JOIN row              ON row_level.Row_ID       = row.ID
				 INNER JOIN level            ON row_level.Level_ID     = level.ID
				 
			         WHERE class_table.EmpID = ".$UID."
                                 GROUP BY class_table.SubjectID , class_table.RowLevelID
				");
			  if($query->num_rows() >0)
			  {return $query->result();}else{return FALSE ;}
	}
	//////////edit_plan_week
	
	
	////////////get_day


	public function get_day_for_zoom($Lang = NULL )
	{
		if($Lang == "arabic")
		  {		 
			      $query = $this->db->query("
				  SELECT 
				  config_row_level.ID As ConfigID ,
				  config_row_level.NumLesson As ConfigNumLesson ,
				  day.ID As DayID ,
				  day.Name As DayName ,
				  day.Name_en As Name
				  FROM config_row_level 
				  INNER JOIN day ON config_row_level.DayID = day.ID 
				  GROUP BY day.ID
		         ");
		  }else{
			      $query = $this->db->query("
				  SELECT 
				  config_row_level.ID As ConfigID ,
				  config_row_level.NumLesson As ConfigNumLesson ,
				  day.ID As DayID ,
				  day.Name_en As DayName,
				  day.Name_en As Name
				  FROM config_row_level 
				  INNER JOIN day ON config_row_level.DayID = day.ID 
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
	
		
	//////////get_base_id
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

	//////////get_day_lesson
	
	//////class_table_update
	public function class_table_update1($data = array())
	{
		extract($data);
		////////////////////////CHECK EMP CONFIG  AND ROW LEVEL ID  
		
	$query = $this->db->query("SELECT ID FROM config_emp WHERE EmpID =".$UID." AND SubjectID =".$GetSubID." AND RowLevelID =".$GetRLID." LIMIT 1");
	if($query->num_rows() <= 0)
	{$this->db->query("INSERT INTO config_emp SET EmpID = ".$UID." , SubjectID = ".$GetSubID." ,RowLevelID = ".$GetRLID."") ;}
		////////////////////////CHECK SUBJECT AND ROW LEVEL ID  
		$WHERE  = array('SubjectID'=>$GetSubID,'RowLevelID'=>$GetRLID);
		$this->db->select('ID');    
		$this->db->from('config_subject');
		$this->db->where($WHERE);
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() == 0)
		{$this->db->query("INSERT INTO config_subject SET SubjectID = ".$GetSubID." ,RowLevelID = ".$GetRLID.",DateStm = $Timezone") ;}
		////////////////////////GET BASE TABLE ID 
		if($this->get_base_id()){$BaseTabeID = $this->get_base_id();}
		
		
		$get_day_lesson = $this->get_day_lesson($GetLessonID ,$GetDayID);
		
		/////////////////////CHECK DATA SENT INTO CLASS TABLE USER ADD NEW ROW OR UPDATE 
		$Where = array('RowLevelID'=>$GetRLID,'Lesson'=>$GetLessonID,'Day_ID'=>$GetDayID,'ClassID'=>$GetClassID,'BaseTableID'=>$BaseTabeID , 'SchoolID' => $SchoolID );
		$this->db->select('*');    
		$this->db->from('class_table');
		$this->db->where($Where);
		$this->db->limit(1);
	    $query = $this->db->get();			
	    if($query->num_rows() >0)
	    {
			$GetData = $query->row_array();$EmpID = $GetData['EmpID'];$ClassTableID  = $GetData['ID'];
			
			if($EmpID != $UID && $EmpID != 0 )
			{
				return 0 ;
			}
			else if($EmpID == $UID && $LastClassTableID !=0)
			{
				$ClassTableID = $LastClassTableID ;
			   $this->db->query("UPDATE class_table SET SubjectID = ".$GetSubID." ,
			    ClassID = ".$GetClassID." ,RowLevelID = ".$GetRLID." , SchoolID = ".$SchoolID." , Date_Stm = $Timezone  WHERE ID  = ".$ClassTableID." ");
			   return 1 ;	   
			}
		
		}else{
			
			if($LastClassTableID !=0)
			{
				$Where = array('ID'=>$LastClassTableID,'EmpID'=>$UID);
				$this->db->select('*');    
				$this->db->from('class_table');
				$this->db->where($Where);
				$this->db->limit(1);
				$query = $this->db->get();			
				if($query->num_rows() >0)
				{
					$ClassTableID = $LastClassTableID ;
				   $this->db->query("UPDATE class_table SET SubjectID = ".$GetSubID." ,
					ClassID = ".$GetClassID." ,RowLevelID = ".$GetRLID." , SchoolID = ".$SchoolID.", Date_Stm = $Timezone WHERE ID  = ".$ClassTableID." ");
				   return 1 ;	
				}
			}else{
					$DataInsert = array(
										'BaseTableID'=> $BaseTabeID, 
										'Day_ID'     => $GetDayID,
										'LessonDayID'=> $get_day_lesson,
										'RowLevelID' => $GetRLID,
										'ClassID'    => $GetClassID,
										'EmpID'      => $UID,
										'SubjectID'  => $GetSubID,
										'SchoolID'   => $SchoolID ,
										'Lesson'     => $GetLessonID,
										'start_time'     => $lessonFromDate,
    									'end_time'       => $lessonToDate,
										'ConID'      => $this->session->userdata('id'),
										'Token'      => $this->get_token(),
										'Date_Stm'   => $Timezone
										);
										
										$this->db->insert('class_table', $DataInsert);
										
										return 1;
					}
			 }
		
	}////////////////get emp class table 
	public function check_emp_calss_table($data = array())
	{
		extract($data);
		////////////////////////GET BASE TABLE ID 
		if($this->get_base_id()){$BaseTabeID = $this->get_base_id();}
	    $query = $this->db->query("
	                        SELECT class_table.* ,contact.Name AS empName,contact.ID AS empID,subject.basic
	                        FROM `class_table` 
	                        INNER JOIN contact ON contact.ID = class_table.EmpID
	                        INNER JOIN subject ON subject.ID = class_table.SubjectID
	                        WHERE `RowLevelID` = $GetRLID 
	                        AND `Lesson` = $lessonID
	                        AND `Day_ID` = $DayID
	                        AND `ClassID` IN($ClassID)
	                        AND `BaseTableID` = $BaseTabeID
	                        AND class_table.`SchoolID` = $SchoolID
	                        LIMIT 1
	    ")->row_array();
	    $sub = $this->db->query("select basic from subject where ID=$get_subject ")->row_array();
	    if(!empty($query))
	    {
	        $EmpID     = $query['EmpID'];
			if(($EmpID != $UID && $EmpID != 0 && (($sub['basic']==1&&$query['basic']==1)||($sub['basic']==1&&$query['basic']==0)||($sub['basic']==0&&$query['basic']==1))&&$rotation!=1)
			||($query['chkMove']==1 && $teaching==1)||($query['chkMove']==2 && $teaching==2)||($query['chkMove']==0 && $rotation==1 &&$EmpID != $UID)||($rotation==2 && ($query['chkMove']==1||$query['chkMove']==2)))
			{
				$EmpID = $query['EmpID'];$ClassTableID  = $query['ID'];
    			$this->db->select('*');    
    		    $this->db->from('contact');
    		    $this->db->where('ID',$EmpID);
    			$this->db->limit(1);
    	        $query1 = $this->db->get();
    			return  $query1->row_array();
    			}else{
    	        return FALSE ;
    	        }
	    }else{
	        return FALSE;
	    }
		
// 		$get_day_lesson = $this->get_day_lesson($GetLessonID ,$GetDayID);
		
// 		$Where = array('RowLevelID'=>$GetRLID,'ClassID'=>$GetClassID,'Lesson'=>$GetLessonID,'Day_ID'=>$GetDayID , 'SchoolID' => $SchoolID);
// 		$this->db->select('*');    
// 		$this->db->from('class_table');
// 		$this->db->where($Where);
// 		$this->db->limit(1);
// 	    $query = $this->db->get();			
// 	    if($query->num_rows() >0)
// 	    {
			
// 			$GetData = $query->row_array();$EmpID = $GetData['EmpID'];$ClassTableID  = $GetData['ID'];
// 			$this->db->select('*');    
// 		    $this->db->from('contact');
// 		    $this->db->where('ID',$EmpID);
// 			$this->db->limit(1);
// 	        $query = $this->db->get();
// 			return  $query->row_array();
// 		}else{return FALSE;}

	}
	
	//////get_all_class
	public function get_all_class($Lang = NULL )
	{
		if($Lang == 'arabic')
		{
			$query = $this->db->query("
			 SELECT 
			 class_table.ID AS ClassTableID ,
			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
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
			 WHERE base_class_table.IsActive = 1 
			 GROUP BY class_table.RowLevelID , class_table.ClassID
			");
		}
		else{
			   $query = $this->db->query("
				 SELECT 
				 class_table.ID AS ClassTableID ,
				 level.ID       AS LevelID,
				 row.ID         AS RowID,
				 class.ID       AS ClassID,
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
				 WHERE base_class_table.IsActive = 1 
				 GROUP BY class_table.RowLevelID , class_table.ClassID
				");
			}
			  if($query->num_rows() >0)
			  {return $query->result();}else{return FALSE ;}
	}///////////////////////////////check_class_table_plan_week
	public function delete_emp_class_table($data = array())
	{
		extract($data);
		if($this->db->query("DELETE FROM class_table WHERE EmpID = ".$empID.""))
		{
			if($this->db->query("DELETE p.* FROM plan_week AS p INNER JOIN class_table AS c ON p.ClassTableID = c.ID WHERE c.EmpID = ".$empID."
			AND c.BaseTableID = ".$this->get_base_id()." "))
			{
				return TRUE ;
			}else{return FALSE ;}
		}else{return FALSE ;}
		
	}///////////////////////////////check_chang_class_table
	public function check_chang_class_table($data = array())
	{
		extract($data);
		if($this->get_base_id()){$BaseTabeID = $this->get_base_id();}
		$this->db->select('*');    
		$this->db->from('class_table');
		$this->db->where('EmpID',$select_emp_change);
		$this->db->where('BaseTableID',$BaseTabeID);
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() >0){return FALSE ;}else{return TRUE ;}
	}///////////////////////////////add_chang_class_table
	public function add_chang_class_table($data = array())
	{
		extract($data);
		if($this->get_base_id()){$BaseTabeID = $this->get_base_id();}
		if($this->db->query("UPDATE class_table SET EmpID = ".$select_emp_change.",Date_Stm = '".$date."'  WHERE EmpID = ".$select_emp." AND BaseTableID = ".$BaseTabeID."  "))
			{
				return TRUE ;
		}else{return FALSE ;}
	}//////////////////////check_class_table
	public function check_class_table($ID = 0)
	{
		if($this->get_base_id()){$BaseTabeID = $this->get_base_id();}
		$DataArray = array();
		$this->db->select('*');    
		$this->db->from('day_lesson');
	    $query = $this->db->get();			
	    if($query->num_rows() >0)
	    {
			foreach($query->result() as $Key=>$RowLesson)
			{
				$LessonDayID = $RowLesson->ID ;
				$this->db->select('*');    
				$this->db->from('class_table');
				$this->db->where('EmpID',$ID);
				$this->db->where('BaseTableID',$BaseTabeID);
				$this->db->where('LessonDayID',$LessonDayID);
				$query = $this->db->get();
				if($query->num_rows()>1)
				{
				   foreach($query->result() as $Key=>$RowClassTable)
			       {
					 $DataArray[] = $RowClassTable;
				   }
				}
			}
		}
		return $DataArray ;
	}/////////////////////////////get_class_table_row
	public function get_class_table_row($data = array())
	{
		extract($data);
		$NameArray = array("Day"=>"Name AS DayName","Lesson"=>"lesson As LessonName " ,"Level"=>"Name AS LevelName" ,
		"row"=>"Name AS RowName" , "class"=>"Name AS ClassName");
		if($Lang == "english")
		{
			$NameArray = array("Day"=>"Name_en AS DayName","Lesson"=>"Lesson_en As LessonName " ,"Level"=>"Name_en AS LevelName" ,
		    "row"=>" Name_en AS RowName" , "class"=>"Name_en AS ClassName");
		}
		$query = $this->db->query("
			 SELECT 
			 class_table.ID AS ClassTableID ,
			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
			 level.".$NameArray['Level'].",
			 row.".$NameArray['row'].",
			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
			 class.".$NameArray['class']." ,
			 subject.Name   AS SubjectName ,
			 lesson.".$NameArray['Lesson']." ,
			 day.".$NameArray['Day']."
			 FROM 
			 class_table
			 INNER JOIN base_class_table ON class_table.BaseTableID = base_class_table.ID
			 INNER JOIN day              ON class_table.Day_ID      = day.ID
			 INNER JOIN subject          ON class_table.SubjectID   = subject.ID
			 INNER JOIN lesson           ON class_table.Lesson      = lesson.ID
			 INNER JOIN class            ON class_table.ClassID     = class.ID
			 INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID        = row.ID
			 INNER JOIN level            ON row_level.Level_ID      = level.ID
			 WHERE 
			 class_table.ID = ".$ID."
			 AND 
			 class_table.Day_ID = ".$Day_ID."
			 AND
			 class_table.Lesson = ".$Lesson."
			 AND
			 class_table.ClassID = ".$ClassID."
			 AND
			 class_table.RowLevelID = ".$RowLevelID."
			 AND 
			 class_table.BaseTableID = ".$BaseTableID."
			 LIMIT 1
			");
			return $query->row_array();
	}///////////////////////////delete_row_class
	public function delete_row_class($Token = NULL )
	{
		if($query = $this->db->query("DELETE FROM class_table WHERE Token = '".$Token."' ")){return TRUE;}
	}

	/////////
	public function up_ax_plan_week_file_class($ContactID  = 0 , $File =NULL   , $Semester = 0 , $WeekID = 0 , $RowLevelID = 0 , $ClassID = 0,$SubjectID=0 ,$Timezone  )
	{
	   if($SubjectID==0){
	   $subject_array=$this->get_subject1($RowLevelID,$ClassID);
	   foreach($subject_array as $val){
	       $SubjectID=$val->SubjectID;
		$check_plan= $this->db->query("select * from  plan_week
			                          WHERE EmpID     = $ContactID
			                          AND RowLevelID  = $RowLevelID
			                          AND ClassID     = $ClassID
			                          AND SubjectID   = $SubjectID
			                          AND WeekID      = $WeekID
			                          AND SemesterID  = $Semester ")->result();
			                          
		if(empty($check_plan)){
		  $this->db->query("insert into  plan_week
			                          SET FileAttach   = '".$File."',
			                          WeekID           = $WeekID,
			                          SemesterID       = $Semester,
			                          EmpID            = $ContactID,
			                          RowLevelID       = $RowLevelID,
			                          ClassID          = $ClassID,
			                          SubjectID        = $SubjectID
			                          ");
			                 
		}else{
		 $this->db->query("UPDATE plan_week
			                          SET FileAttach = '".$File."'
			                          WHERE EmpID      = $ContactID
			                          AND RowLevelID   = $RowLevelID
			                          AND ClassID      = $ClassID
			                          AND SubjectID    = $SubjectID
			                          AND WeekID       = $WeekID
			                          AND SemesterID   = $Semester ");
		}}
	   }else{	$check_plan= $this->db->query("select * from  plan_week
			                          WHERE EmpID     = $ContactID
			                          AND RowLevelID  = $RowLevelID
			                          AND ClassID     = $ClassID
			                          AND SubjectID   = $SubjectID
			                          AND WeekID      = $WeekID
			                          AND SemesterID  = $Semester ")->result();
			                          
		if(empty($check_plan)){
		  $this->db->query("insert into  plan_week
			                          SET FileAttach   = '".$File."',
			                          WeekID           = $WeekID,
			                          SemesterID       = $Semester,
			                          EmpID            = $ContactID,
			                          RowLevelID       = $RowLevelID,
			                          ClassID          = $ClassID,
			                          SubjectID        = $SubjectID
			                          ");
			                 
		}else{
		 $this->db->query("UPDATE plan_week
			                          SET FileAttach = '".$File."'
			                          WHERE EmpID      = $ContactID
			                          AND RowLevelID   = $RowLevelID
			                          AND ClassID      = $ClassID
			                          AND SubjectID    = $SubjectID
			                          AND WeekID       = $WeekID
			                          AND SemesterID   = $Semester ");
		}
	       
	   }
	     return TRUE;
	}

  ///////////////////////////////////////////////////////
  public function get_file_week_class( $WeekID = 0 , $Semester = 0 , $RowLevelID = 0 , $ClassID = 0  ,$SubjectID=0 )
   {
      if($SubjectID!=0){$where="AND plan_week.SubjectID    = '".$SubjectID."'";}else{$where="";}
	   $query = $this->db->query("SELECT DISTINCT plan_week.FileAttach,subject.ID AS SubjectID ,subject.Name AS SubjectName,contact.Name AS contact_Name,contact.ID AS contact_ID
                                  FROM plan_week
                                  INNER JOIN subject          ON subject.ID=plan_week.SubjectID
                                  INNER JOIN contact          ON plan_week.EmpID = contact.ID
                                  WHERE plan_week.WeekID   = '".$WeekID."'
                                  AND plan_week.SemesterID = '".$Semester."'
                                  AND plan_week.RowLevelID = '".$RowLevelID."'
                            	  AND plan_week.ClassID    = '".$ClassID."'
                            	  AND contact.SchoolID='".$this->session->userdata('SchoolID')."'
                                  $where
                                  ")->result() ;
	if(is_array($query) && sizeof($query)>0)
	{
		return $query ;
	}else{return FALSE ;}

  }
  ///////////////////////get_emp_class_clerical_homework
  public function get_emp_class_clerical_homework ($Data = array())
  {
	  $NameArray = array("Day"=>"Name AS DayName","Lesson"=>"lesson As LessonName " ,"Level"=>"Name AS LevelName" ,
		"row"=>"Name AS RowName" , "class"=>"Name AS ClassName");
		if($Data['Lang'] == "english")
		{
			$NameArray = array("Day"=>"Name_en AS DayName","Lesson"=>"Lesson_en As LessonName " ,"Level"=>"Name_en AS LevelName" ,
		    "row"=>" Name_en AS RowName" , "class"=>"Name_en AS ClassName");
		}
		$query = $this->db->query("
			 SELECT 
			 class_table.ID AS ClassTableID ,
			 level.ID       AS LevelID,
			 row.ID         AS RowID,
			 class.ID       AS ClassID,
			 level.".$NameArray['Level'].",
			 row.".$NameArray['row'].",
			 row_level.ID   As RowLevelID ,
			 class.ID       As ClassID ,
			 class.".$NameArray['class']." ,
			 subject.Name   AS SubjectName ,
			 lesson.".$NameArray['Lesson']." ,
			 day.".$NameArray['Day']."
			 FROM 
			 class_table
			 INNER JOIN base_class_table ON class_table.BaseTableID = base_class_table.ID
			 INNER JOIN day              ON class_table.Day_ID      = day.ID
			 INNER JOIN subject          ON class_table.SubjectID   = subject.ID
			 INNER JOIN lesson           ON class_table.Lesson      = lesson.ID
			 INNER JOIN class            ON class_table.ClassID     = class.ID
			 INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID        = row.ID
			 INNER JOIN level            ON row_level.Level_ID      = level.ID
			 WHERE 
			 class_table.SubjectID  = '".$Data['SubjectID']."'
			 AND
			 class_table.RowLevelID = '".$Data['RowLevelID']."'
			 AND
			 class_table.EmpID      = '".$Data['EmpID']."'
			 
			 GROUP BY class_table.ClassID
			")->result();
			if(sizeof($query) > 0 ){return $query;}else{return FALSE ;}
			
  }
  public function class_table_special_update($data = array())
  {
	  extract($data);
  
	  
  $query = $this->db->query("SELECT ID FROM config_emp WHERE EmpID =".$UID." AND SubjectID =".$GetSubID." AND RowLevelID =".$GetRLID." LIMIT 1");
  if($query->num_rows() <= 0)
  {$this->db->query("INSERT INTO config_emp SET EmpID = ".$UID." , SubjectID = ".$GetSubID." ,RowLevelID = ".$GetRLID."") ;}
	  ////////////////////////CHECK SUBJECT AND ROW LEVEL ID  
	  $WHERE  = array('SubjectID'=>$GetSubID,'RowLevelID'=>$GetRLID);
	  $this->db->select('ID');    
	  $this->db->from('config_subject');
	  $this->db->where($WHERE);
	  $this->db->limit(1);
	  $query = $this->db->get();
	  if($query->num_rows() == 0)
	  {$this->db->query("INSERT INTO config_subject SET SubjectID = ".$GetSubID." ,RowLevelID = ".$GetRLID."") ;}
	  ////////////////////////GET BASE TABLE ID 
	  if($this->get_base_id()){$BaseTabeID = $this->get_base_id();}
	  
	  
	  $get_day_lesson = $this->get_day_lesson($GetLessonID ,$GetDayID);
	  
	  /////////////////////CHECK DATA SENT INTO CLASS TABLE USER ADD NEW ROW OR UPDATE 
	  $Where = array('RowLevelID'=>$GetRLID,'Lesson'=>$GetLessonID,'Day_ID'=>$GetDayID,'ClassID'=>$GetClassID,'BaseTableID'=>$BaseTabeID , 'SchoolID' => $SchoolID );
	  $this->db->select('*');    
	  $this->db->from('class_table');
	  $this->db->where($Where);
	  $this->db->limit(1);
	  $query = $this->db->get();			
	  if($query->num_rows() >0)
	  {
		  $GetData = $query->row_array();$EmpID = $GetData['EmpID'];$ClassTableID  = $GetData['ID'];
		  
		  if($EmpID != $UID && $EmpID != 0 )
		  {
			  return 0 ;
		  }
		  else if($EmpID == $UID && $LastClassTableID !=0)
		  {
			  $ClassTableID = $LastClassTableID ;
			 $this->db->query("UPDATE class_table SET SubjectID = ".$GetSubID." ,
			  ClassID = ".$GetClassID." ,RowLevelID = ".$GetRLID." , SchoolID = ".$SchoolID."  WHERE ID  = ".$ClassTableID." ");
			 return 1 ;	   
		  }
	  
	  }else{
		  
		  if($LastClassTableID !=0)
		  {
			  $Where = array('ID'=>$LastClassTableID,'EmpID'=>$UID);
			  $this->db->select('*');    
			  $this->db->from('class_table');
			  $this->db->where($Where);
			  $this->db->limit(1);
			  $query = $this->db->get();			
			  if($query->num_rows() >0)
			  {
				  $ClassTableID = $LastClassTableID ;
				 $this->db->query("UPDATE class_table SET SubjectID = ".$GetSubID." ,
				  ClassID = ".$GetClassID." ,RowLevelID = ".$GetRLID." , SchoolID = ".$SchoolID." WHERE ID  = ".$ClassTableID." ");
				 return 1 ;	
			  }
		  }else{
				  $DataInsert = array(
									  'BaseTableID'=> $BaseTabeID, 
									  'Day_ID'     => $GetDayID,
									  'LessonDayID'=> $get_day_lesson,
									  'RowLevelID' => $GetRLID,
									  'ClassID'    => $GetClassID,
									  'EmpID'      => $UID,
									  'SubjectID'  => $GetSubID,
									  'SchoolID'   => $SchoolID ,
									  'Lesson'     => $GetLessonID,
									  'start_time'     => $lessonFromDate,
    								  'end_time'       => $lessonToDate,
									  'ConID'      => $StudentID,
									  'Token'      => $this->get_token(),
									  'special_st' =>1
									  );
									  
									  $this->db->insert('class_table', $DataInsert);
									  
									  return 1;
				  }
		   }
	  
  }
  ///////////////////////////check_add_class
  public function check_add_class($Data = array())
  {
	  $query = $this->db->query("SELECT * FROM clerical_homework WHERE WeeklyPlanID = '".$Data['plnID']."'
	   AND classID = '".$Data['ClassID']."' ")->row_array();
	   if(sizeof($query) > 0 ){return $query;}else{return FALSE ;}
  }
  ///////////////////////////get_clerical_homework
  public function get_clerical_homework($Data = array())
  {
	  $query = $this->db->query("SELECT * FROM clerical_homework WHERE WeeklyPlanID = '".$Data['plnID']."' ")->row_array();
      if(sizeof($query) > 0 ){return $query;}else{return FALSE ;}
  }
   /////////////////////////////
  public function get_emp_subjects1($Lang = NULL , $UID = 0 ,$rowlevelid,$SubjectID)
	{
	  	if($Lang == 'arabic')
		{
			$query = $this->db->query("
			 SELECT 
			 level.Name     AS LevelName,
			 row.Name       AS RowName,
			 row_level.ID   AS RowLevelID,
			 subject.ID     AS SubjectID,
			 subject.Name   AS SubjectName
			 FROM 
			  class_table
			  INNER JOIN subject          ON class_table.SubjectID   = subject.ID
			  INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
			  INNER JOIN row              ON row_level.Row_ID       = row.ID
			  INNER JOIN level            ON row_level.Level_ID     = level.ID
			
			  WHERE class_table.EmpID = ".$UID." AND class_table.RowLevelID = '".$rowlevelid."'  AND class_table.SubjectID = '".$SubjectID."'
                         GROUP BY class_table.SubjectID , class_table.RowLevelID
			");
		}
		else{
			   $query = $this->db->query("
				 SELECT 
				 level.Name_en   AS LevelName,
				 row.Name_en     AS RowName,
				 row_level.ID    AS RowLevelID,
				 subject.ID      AS SubjectID,
				 subject.Name    AS SubjectName
				 FROM 
				 class_table
				 INNER JOIN subject          ON class_table.SubjectID   = subject.ID
				 INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
				 INNER JOIN row              ON row_level.Row_ID       = row.ID
				 INNER JOIN level            ON row_level.Level_ID     = level.ID
				 
			         WHERE class_table.EmpID = ".$UID." AND class_table.RowLevelID = '".$rowlevelid."' AND class_table.SubjectID = '".$SubjectID."'
                                 GROUP BY class_table.SubjectID , class_table.RowLevelID
				");
			}
			  if($query->num_rows() >0)
			  {return $query->result();}else{return FALSE ;}
	}
	public function get_emp_subjects_new($Lang = NULL , $UID = 0)
	{
	  	if($Lang == 'arabic')
		{
			$query = $this->db->query("
			 SELECT 
			 level.Name     AS LevelName,
			 row.Name       AS RowName,
			 row_level.ID   AS RowLevelID,
			 subject.ID     AS SubjectID,
			 subject.Name   AS SubjectName
			 FROM 
			  class_table
			  INNER JOIN subject          ON class_table.SubjectID   = subject.ID
			  INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
			  INNER JOIN row              ON row_level.Row_ID       = row.ID
			  INNER JOIN level            ON row_level.Level_ID     = level.ID
			
			  WHERE class_table.EmpID = ".$UID."
              GROUP BY class_table.SubjectID
			");
		}
		else{
			   $query = $this->db->query("
				 SELECT 
				 level.Name_en   AS LevelName,
				 row.Name_en     AS RowName,
				 row_level.ID    AS RowLevelID,
				 subject.ID      AS SubjectID,
				 subject.Name    AS SubjectName
				 FROM 
				 class_table
				 INNER JOIN subject          ON class_table.SubjectID   = subject.ID
				 INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
				 INNER JOIN row              ON row_level.Row_ID       = row.ID
				 INNER JOIN level            ON row_level.Level_ID     = level.ID
				 
			         WHERE class_table.EmpID = ".$UID."
                                 GROUP BY class_table.SubjectID 
				");
			}
			  if($query->num_rows() >0)
			  {return $query->result();}else{return FALSE ;}
	}
	public function get_emp_row_level($Lang = NULL , $UID = 0)
	{
	  	if($Lang == 'arabic')
		{
			$query = $this->db->query("
			 SELECT 
			 level.Name     AS LevelName,
			 row.Name       AS RowName,
			 row_level.ID   AS RowLevelID
			 FROM 
			 class_table
			 INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID       = row.ID
			 INNER JOIN level            ON row_level.Level_ID     = level.ID
			 WHERE class_table.EmpID = ".$UID."
             GROUP BY level.ID
			");
		}
		else{
			   $query = $this->db->query("
				 SELECT 
				 level.Name_en   AS LevelName,
				 row.Name_en     AS RowName,
				 row_level.ID    AS RowLevelID
				 FROM 
				 class_table
				 INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
			     INNER JOIN row              ON row_level.Row_ID       = row.ID
			     INNER JOIN level            ON row_level.Level_ID     = level.ID
				 WHERE class_table.EmpID = ".$UID."
                 GROUP BY level.ID
				");
			}
			  if($query->num_rows() >0)
			  {return $query->result();}else{return FALSE ;}
	}
	
	 
	public function get_day_for_zoom_new($Lang = NULL ,$day)
	{
		if($Lang == "arabic")
		  {		 
			      $query = $this->db->query("
				  SELECT 
				  config_row_level.ID As ConfigID ,
				  config_row_level.NumLesson As ConfigNumLesson ,
				  day.ID As DayID ,
				  day.Name As DayName ,
				  day.Name_en As Name
				  FROM config_row_level 
				  INNER JOIN day ON config_row_level.DayID = day.ID 
				   WHERE   day.Name like '%$day%'
				  GROUP BY day.ID
		         ");
		  }else{
			      $query = $this->db->query("
				  SELECT 
				  config_row_level.ID As ConfigID ,
				  config_row_level.NumLesson As ConfigNumLesson ,
				  day.ID As DayID ,
				  day.Name_en As DayName,
				  day.Name_en As Name
				  FROM config_row_level 
				  INNER JOIN day ON config_row_level.DayID = day.ID 
				  WHERE   day.Name like '%$day%'
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
		public function get_day_without_year($Lang = NULL )
	{
	    
		if($Lang == "arabic")
		  {		 
			      $query = $this->db->query("
				  SELECT 
				  config_row_level.ID As ConfigID ,
				  config_row_level.NumLesson As ConfigNumLesson ,
				  day.ID As DayID ,
				  day.Name As DayName ,
				  day.Name_en As Name,
				  day.Image As Image,
				  day.image_night As image_night
				  FROM config_row_level 
				  INNER JOIN day ON config_row_level.DayID = day.ID 
				  GROUP BY day.ID
		         ");
		  }else{
			      $query = $this->db->query("
				  SELECT 
				  config_row_level.ID As ConfigID ,
				  config_row_level.NumLesson As ConfigNumLesson ,
				  day.ID As DayID ,
				  day.Name_en As DayName,
				  day.Name_en As Name,
				  day.Image_en As Image,
				  day.image_night_en As image_night
				  FROM config_row_level 
				  INNER JOIN day ON config_row_level.DayID = day.ID 
	
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
   
   
   	public function get_subject1($RowLevelID,$ClassID)
	{
		$subject_array=get_subject_select_in();
			   $query = $this->db->query("
				 SELECT 
				 subject.ID      AS SubjectID,
				 subject.Name    AS SubjectName
				 FROM 
				 class_table
				 INNER JOIN subject          ON class_table.SubjectID   = subject.ID
				 
			         WHERE class_table.RowLevelID = ".$RowLevelID." AND class_table.ClassID =".$ClassID."
					 and subject.ID in($subject_array)
                                 GROUP BY class_table.SubjectID 
				");
			
			  if($query->num_rows() >0)
			  {return $query->result();}else{return FALSE ;}
	}
	
	//////////////////////////////////
	 public function get_file_week_emp( $WeekID = 0 , $Semester = 0 , $ContactID = 0 ,$group_day )
   {
	$query = $this->db->query("SELECT DISTINCT plan_week.FileAttach,
	                            plan_week.ID,
		                       contact.Name AS contact_Name,
		                       contact.ID AS Contact_ID
                               FROM plan_week
                              
                               INNER JOIN contact          ON plan_week.EmpID         = contact.ID
                              
                               WHERE WeekID = $WeekID AND SemesterID =".$Semester." AND plan_week.EmpID = $ContactID 
                               and plan_week.RowLevelID IS NULL
                               AND plan_week.ClassTableID = 0 
                               AND  FileAttach <>''")->result() ;


	if(is_array($query) && sizeof($query)>0)
	{
		return $query ;
	}else{return FALSE ;}

  }
  ///////////////////////////
  		public function delete_plan_week_file_emp($ContactID  = 0 , $File =NULL   , $Semester = 0 , $WeekID = 0  ,$type = 1 , $id_emp)
	{
	   
		if($query = $this->db->query("delete  from  plan_week  
			                         
			                          
			                          WHERE plan_week.EmpID      = $ContactID
			                          AND plan_week.ID               =  $id_emp
			                          AND plan_week.RowLevelID     IS NULL
			                          AND plan_week.WeekID       = $WeekID
			                          AND plan_week.SemesterID   = $Semester
			                          AND plan_week.GroupID= $type "))
	{
	    return TRUE;
	    
	}
	}
	
		public function delete_plan_week_file_emp_admin($ContactID,$File =NULL ,$Semester = 0 , $WeekID = 0 )
	{
	   
		if($query = $this->db->query("delete from  plan_week  where ID in(select plan_week.ID from plan_week
			                          
			                          WHERE plan_week.EmpID      = $ContactID
			                          AND plan_week.RowLevelID     IS NULL
			                          AND plan_week.WeekID       = $WeekID
			                          AND plan_week.SemesterID   = $Semester
			                          ) "))
	{
	    return TRUE;
	    
	}
	}
	
	public function empty_emp_plan_week($data)
	{
	    extract($data);
	   if ($multipleClass) {

			$classTable = $this->db->query("SELECT GROUP_CONCAT(ID) AS classTableID  FROM `class_table` WHERE `multipleClass` = $multipleClass ")->row_array();
			$class_tableID = $classTable['classTableID'];

			$check_plan= $this->db->query("select * from  plan_week
			                               WHERE ClassTableID  IN ($class_tableID) and WeekID=".$WeekID." and SemesterID=".$Semester."
			                          ")->result();
			
									 
		 }else{
	    	$check_plan= $this->db->query("select * from  plan_week
			                          WHERE ClassTableID     = $class_table_id and WeekID=".$WeekID." and SemesterID=".$Semester."
			                          ")->result();
		 }
			
			foreach ($check_plan as $key => $value) {

				$query = $this->db->query("delete 
				                           from  plan_week 
			                               WHERE  plan_week.RowLevelID   IS NULL
			                               AND plan_week.ClassTableID = ".$value->ClassTableID."
			                           ");
			}
			if($query){
			    return true;
			}
		
	}
	///////////////////
	/////////////////////////
	public function getrowlevel_adminTable($idContact)
	 {
		 $Lang = $this->session->userdata('language');
 		 if((string)$Lang ==='english'){ 
		 
		      $this->db->select('level.Name_en as LevelName,row.Name_en as RowName,config_row_level_emp.ID as config_ID,row_level.ID as RowLevelID');
		  }else{
		      $this->db->select('level.Name as LevelName,row.Name as RowName,config_row_level_emp.ID as config_ID,row_level.ID as RowLevelID');
			  
			  }
			$this->db->from('config_row_level_emp');
			$this->db->join('row_level','row_level.ID = config_row_level_emp.row_levelID');
			$this->db->join('student','student.R_L_ID = row_level.ID');
			$this->db->join('contact',"student.Contact_ID  = contact.ID  AND contact.Isactive =1 AND contact.SchoolID = '".$this->session->userdata('SchoolID')."'");
			$this->db->join('level','row_level.Level_ID = level.ID'); 
			$this->db->join('row','row_level.Row_ID = row.ID'); 
			$this->db->where('config_row_level_emp.empID',$idContact); 
			$this->db->group_by('row_level.ID'); 
			$this->db->order_by('RowLevelID'); 
			$Result = $this->db->get(); 
			if($Result->num_rows()>0)
			{
				$ReturnResult = $Result->result() ;
				return $ReturnResult ;
			}else{
				return 0 ;
			}
	 }
	 	/////////////////////////
	public function getrowlevel_adminTableByLevel($idContact)
	 {
		 $Lang = $this->session->userdata('language');
 		 if((string)$Lang ==='english'){ 
		 
		      $this->db->select('row_level.Level_Name_en as LevelName,row_level.Row_Name_en as RowName,row_level.ID as RowLevelID');
		  }else{
		      $this->db->select('row_level.Level_Name as LevelName,row_level.Row_Name as RowName,row_level.ID as RowLevelID');
			  
			  }
			$this->db->from('row_level');
			$this->db->join('student','student.R_L_ID = row_level.ID');
			$this->db->join('contact',"student.Contact_ID  = contact.ID  AND contact.Isactive =1 AND contact.SchoolID = '".$this->session->userdata('SchoolID')."'");
			$this->db->join('employee','row_level.Level_ID = employee.LevelID');
			$this->db->where('employee.Contact_ID ',$idContact); 
			$this->db->group_by('row_level.ID'); 
			$this->db->order_by('RowLevelID'); 
			$Result = $this->db->get(); 
			if($Result->num_rows()>0)
			{
				$ReturnResult = $Result->result() ;
				return $ReturnResult ;
			}else{
				return 0 ;
			}
	 }
	 ////////////////////////////
	 public function getsubject_adminTable($idContact)
	 {
		 $Lang = $this->session->userdata('language');
    	 $LangArray = array("Name"=>"Name_Ar");
		 if((string)$Lang ==='english'){ $LangArray = array("Name"=>"Name_En"); }
		 $this->db->select('subject.Name,config_subject_emp.ID as config_ID,subject.ID  as ID ');
			$this->db->from('config_subject_emp');
			$this->db->join('subject','subject.ID = config_subject_emp.subjectID'); 
			if($this->ApiDbname  == "SchoolAccGheras" ){
			$this->db->join('config_subject','subject.ID = config_subject.SubjectID and config_subject_emp.RowLevelID=config_subject.RowLevelID'); 
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
	 ////////////////////
	 	public function get_group_day($RowLevelID,$ClassID)
	{
	  
			  $GetData          = $this->db->query("
				 SELECT  
				 lesson.group_day
				 FROM 
				 lesson
				 INNER JOIN class_table          ON class_table.Lesson   = lesson.ID
				 
			         WHERE class_table.RowLevelID = ".$RowLevelID."
			         AND class_table.ClassID =".$ClassID."
                                 
				");
				if($GetData->num_rows()>0)
		{
			$Getgroup_day          =  $GetData->row_array();
			$group_day   = $Getgroup_day['group_day'];
			return $group_day ;
		}else{
			   return FALSE ;
			 }
			
	}
	//////////////////
	public function get_subject_emp($data=array())
	{
	    extract($data);
	    
	    if($Lang == 'english'){
	            $Name = 'Name_en';
        		$subjectName = 'CASE
        			WHEN subject.Name_en IS NULL THEN subject.Name
        			ELSE subject.Name_en
        			END AS SubjectName';
		}else{
		        $Name = 'Name' ; 
			    $subjectName = "subject.Name AS SubjectName";
		}
			
			
		
		  $query = $this->db->query("SELECT DISTINCT 
		  row_level.Level_ID       AS LevelID,
		  row_level.Row_ID         AS RowID,
		  row_level.Level_Name     AS LevelName,
		  row_level.Row_Name       AS RowName,
		  row_level.ID   As RowLevelID ,
		  class.ID       As ClassID ,
		  subject.ID AS SubjectID ,
		  $subjectName ,
		  class.ID  AS ClassID ,
		  class. ".$Name." AS ClassName 
		  FROM class
		  INNER JOIN school_class ON class.ID = school_class.ClassID AND school_class.SchoolID = '".$this->session->userdata('SchoolID')."'
		  INNER JOIN class_table ON class.ID=class_table.ClassID
		  inner join school_row_level on  school_row_level.SchoolID=class_table.SchoolID and class_table.RowLevelID=school_row_level.RowLevelID
		  INNER JOIN subject ON subject.ID=class_table.SubjectID
		  INNER JOIN row_level        ON class_table.RowLevelID    = row_level.ID
		  INNER JOIN lesson           ON class_table.Lesson        = lesson.ID
		  where  class_table.EmpID ='".$UID."' and lesson.group_day= $group_day
		  group by subject.ID, class.ID,row_level.ID
		  
		   ");			
		  if($query->num_rows() >0)
		  {return $query->result();}else{return FALSE ;}
	}
	/////////////////////////////////////
		public function delete_emp_classtable($data=array())
	{
	    extract($data);
	$per_rowLevel =	get_rowlevel_select_in();
	 if($level_ID == 0 )   {$level_ID = 'NULL' ; }
	 	$lesson_delete = 'lesson' ;
	 	$day_name      = 'Name'   ;
	 	$subjectName      = 'Name'   ;
		if($Lang == 'english'){
		    $lesson_delete = 'Lesson_en' ; 
		    $day_name      = 'Name_en'   ;
		    $subjectName   = 'Name_en'   ;
		}
		  $query = $this->db->query("SELECT DISTINCT 
		    temp_class_table.ID AS ClassTableID ,
		    temp_class_table.EmpID,
		    temp_class_table.deleted_by,
		    temp_class_table.deleted_at ,
		    temp_class_table.Date_Stm ,
		    temp_class_table.SubjectID,
		    subject.".$subjectName." AS subjectName,
	
			temp_class_table.Lesson,
			temp_class_table.Day_ID,
			lesson. ".$lesson_delete."  AS lesson_delete,
			
			day. ".$day_name." AS day_name ,
		
			row_level.Level_Name      AS LevelName,
			row_level.Row_Name     AS RowName,
			row_level.ID   As RowLevelID ,
		    class.ID       As ClassID ,
    	    class.Name     AS ClassName,
    	    contact.ID ,
    		contact.Name   AS EMP_insert ,
    	    tb2.Name         AS EMP_delete ,
    	    tb3.Name          AS ConIDt 
		  FROM temp_class_table 
		  INNER JOIN class ON class.ID=temp_class_table.ClassID
		  INNER JOIN school_class ON class.ID                           = school_class.ClassID AND school_class.SchoolID = '".$this->session->userdata('SchoolID')."'
		  INNER JOIN contact ON contact.ID                              = temp_class_table.EmpID
		  INNER JOIN contact AS tb2      ON tb2.ID                      = temp_class_table.deleted_by 
		  INNER JOIN contact AS tb3      ON tb3.ID                      = temp_class_table.ConID
		  inner join school_row_level    on school_row_level.SchoolID   = temp_class_table.SchoolID and temp_class_table.RowLevelID=school_row_level.RowLevelID
		  INNER JOIN subject             ON subject.ID                  = temp_class_table.SubjectID
		  INNER JOIN lesson              ON temp_class_table.Lesson     = lesson.ID
		  INNER JOIN day                 ON temp_class_table.Day_ID     = day.ID 
		  INNER JOIN row_level           ON temp_class_table.RowLevelID = row_level.ID
		 
		  where  temp_class_table.EmpID = $select_emp  
		  AND row_level.Level_ID = IFNULL($level_ID,row_level.Level_ID)
		  order by temp_class_table.deleted_at DESC
	     
		   ");			
		  if($query->num_rows() >0)
		  {return $query->result();}else{return FALSE ;}
	}
	
}//////END CLASS?>