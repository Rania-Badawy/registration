<?php
class Config_Class_Table_Model extends CI_Model 
 {
	private $Date       = '' ;
	private $Encryptkey = '' ;
	private $Token      = '' ;
	
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
	//////get_level
	public function get_level($Lang)
	{
		if($Lang == 'arabic')
		{
		  $this->db->select('ID ,Name ,Token');    
		  $this->db->from('level');
		  $this->db->where('Is_Active',1);
		}
		else{
		      $this->db->select('ID ,Name_en AS Name ,Token');    
		      $this->db->from('level');
		      $this->db->where('Is_Active',1);
			}
			  $query = $this->db->get();			
			  if($query->num_rows() >0)
			  {return $query->result();}else{return FALSE ;}
	}
	//////get_row
	public function get_row($LevelID = 0,$Lang = NULL)
	{
		
		if($Lang == 'arabic')
		{
			$query = $this->db->query("
			 SELECT
			 row_level.ID    AS RowLevelID, 
			 row_level.Token AS RowLevelToken, 
			 row.Name AS RowName 
			 FROM 
			 row_level
			 INNER JOIN row ON row_level.Row_ID = row.ID 
			 WHERE row_level.Level_ID = ".$LevelID."
			 AND   row_level.IsActive = 1
			");
		}
		else{
		      $query = $this->db->query("
			  SELECT
			  row_level.ID    AS RowLevelID,
			  row_level.Token AS RowLevelToken, 
			  row.Name_en AS RowName 
			  FROM 
			  row_level
			  INNER JOIN row ON row_level.Row_ID = row.ID 
			  WHERE row_level.Level_ID = ".$LevelID."
			  AND   row_level.IsActive = 1
			");
			}
			  if($query->num_rows() >0)
			  {return $query->result();}else{return FALSE ;}
	}
	
	///////check_row_Level_token
	public function check_row_Level_token($Token)
	{
		      $Where  = array('IsActive'=>1,'Token'=>$Token);
		      $this->db->select('*');    
		      $this->db->from('row_level');
		      $this->db->where($Where);
			  $this->db->limit(1);
			  $query = $this->db->get();			
			  if($query->num_rows() >0)
			  {return $query->row_array();}else{return FALSE ;}
	}
	///////get_subject
	public function get_subject()
	{
		      $Where  = array('Method'=>1,'Is_Active'=>1);
		      $this->db->select('*');    
		      $this->db->from('subject');
		      $this->db->where($Where);
			  $query = $this->db->get();			
			  if($query->num_rows() >0)
			  {return $query->result();}else{return FALSE ;}
	}
	///////get_subject
	public function check_subject($data = array())
	{
		      extract($data);
		      $Where  = array('SubjectID'=>$SubID,'RowLevelID'=>$RowLevelID);
		      $this->db->select('*');    
		      $this->db->from('config_subject');
		      $this->db->where($Where); 
			  $this->db->limit(1);
			  $query = $this->db->get();			
			  if($query->num_rows() >0)
			  {return FALSE ;}else{return TRUE ;}
	}
	/////add_new_sub
	public function add_new_sub($data = array())
	{
		extract($data);
		$DataInsert = array
		(
		  'SubjectID'  =>$SubID ,
		  'RowLevelID' =>$RowLevelID ,
		  'NumLesson'  =>$NumLesson ,
		  'is_prim'    =>$is_prim ,
		  'is_lab'     =>$is_lab ,
		  'is_beside'  =>$is_beside ,
		  'ConID'      =>$UID ,
		  'Token'      =>$this->Token  
		);
		if($this->db->insert('config_subject', $DataInsert)){return TRUE ;}else{return FALSE ;}
	}
	///////get_sub_row
	public function get_sub_row($RowLevelID)
	{
		
		$query = $this->db->query("
		  SELECT
		  config_subject.ID AS ConfigSubid ,
		  config_subject.NumLesson ,
		  config_subject.is_prim ,
		  config_subject.is_lab ,
		  config_subject.is_beside ,
		  subject.Name  AS SubName
		  FROM 
		  config_subject
		  INNER JOIN subject ON config_subject.SubjectID = subject.ID
		  WHERE config_subject.RowLevelID = ".$RowLevelID." GROUP BY config_subject.ID  DESC 
		");
				
			  if($query->num_rows() >0)
			  {return $query->result();}else{return FALSE ;}
	}
	/////edit_sub
	public function edit_sub($data = array())
	{
		extract($data);
		$DataUpdate = array
		(
		  'NumLesson'  =>$NumLesson ,
		  'ConID'      =>$UID ,
		  'is_prim'    =>$is_prim ,
		  'is_lab'     =>$is_lab ,
		  'is_beside'  =>$is_beside 
		   
		);
		   $this->db->where('ID', $config_sub_id);
		if($this->db->update('config_subject', $DataUpdate)){return TRUE ;}else{return FALSE ;}
	}
	/////get_config
	public function get_config()
	{
	  	
      $query = $this->db->query("SELECT * FROM config_class_table GROUP BY ID DESC LIMIT 1");
	  if($query->num_rows() >0){ return $query->row_array();}else{return FALSE ;}
 	}
	/////get_day_row_config
	public function get_day_row_config($data = array())
	{
	  extract($data);
	  
		  if($Lang == "arabic")
		  {		 
			      $query = $this->db->query("
				  SELECT 
				  config_row_level.ID As ConfigID ,
				  config_row_level.NumLesson As ConfigNumLesson ,
				  day.ID As DayID ,
				  day.Name As DayName 
				  FROM config_row_level 
				  INNER JOIN day ON config_row_level.DayID = day.ID
				  WHERE  config_row_level.YearID        = '".(int)$this->session->userdata('YearID')."' 
				  GROUP BY day.ID
		         ");
		  }else{
			      $query = $this->db->query("
				  SELECT 
				  config_row_level.ID As ConfigID ,
				  config_row_level.NumLesson As ConfigNumLesson ,
				  day.ID As DayID ,
				  day.Name_en As DayName 
				  FROM config_row_level 
				  INNER JOIN day ON config_row_level.DayID = day.ID
				  WHERE  config_row_level.YearID        = '".(int)$this->session->userdata('YearID')."' 
				  GROUP BY day.ID 
		         ");
			   }
		  if($query->num_rows() >0)
		  {
			 return $query->result(); 
		  }
		  else
		  {
			  $GetData = $this->get_config();
		   if($GetData)
		   {
			  $StartDay = $GetData['StartDay'];
			  $EndDay   = $GetData['EndDay'];
			  for($i=$StartDay ; $i<=$EndDay;$i++)
			  {
				  $DataInsert = array(
				  "RowLevelID"    =>$RowLevelID ,
				  "NumLesson"     =>0 ,
				  "DayID"         =>$i ,
				  "YearID"        =>(int)$this->session->userdata('YearID') ,
				  "ConID"         =>$ConID ,
				  "Token"         =>$this->get_token() 
				  );
				 $this->db->insert('config_row_level', $DataInsert);
			  }
			  return $this->get_day_row_config($data);
		    }else{return FALSE ;}
		  }
 	}
 	public function add_new_config_lesson($max)
	{
	  $classtable_type     = (int)$this->input->post('classtable_type');
	 
	  if($classtable_type==1){
 	 for($i=1 ; $i<=$max;$i++)
			  {
				  $DataInsert = array(
				  "ID"  =>$i,
				  "lesson"    =>$i ,
				  "Lesson_en"     =>$i ,
				  "group_day"    =>1
				  );
				 $this->db->insert('lesson', $DataInsert);
			  }
	  }else if($classtable_type==2){
	       for($i=1 ; $i<=$max;$i++)
			  {
			      $DataInsert = array(
			       "ID"  =>$i,
				  "lesson"    =>$i." - "."مسائي",
				  "Lesson_en"     =>$i." - "."evening",
				  "group_day"    =>2
				  );
				  
				 $this->db->insert('lesson', $DataInsert);
			  }
	  }
	else if($classtable_type==3){
	    $count=0;
	       for($i=1 ; $i<=$max;$i++)
			  {
				  $DataInsert = array(
				  "ID"  =>$i,
				  "lesson"    =>$i ,
				  "Lesson_en"     =>$i ,
				  "group_day"    =>1
				  );
				 $this->db->insert('lesson', $DataInsert);
				$count=$i;
			  }
			  
			  for($i=1 ; $i<=$max;$i++)
			  {
			      $count++;
				  $DataInsert = array(
				   "ID"  =>$count,
				  "lesson"    =>$i." - "."مسائي",
				  "Lesson_en"     =>$i." - "."evening",
				  "group_day"    =>2
				  );
				 $this->db->insert('lesson', $DataInsert);
			  }
	  }
	  $days= $this->db->query("SELECT * from day where is_active=1 ")->result();
	  $lessons= $this->db->query("SELECT * from lesson ")->result();
	  
	  foreach($days as $k=>$day){
	      foreach($lessons as $k1=>$lesson)
			  {
				  $DataInsert = array(
				  "lessonID"    =>$lesson->ID,
				  "DayID"     =>$day->ID,
				  );
				 $this->db->insert('day_lesson', $DataInsert);
			  }
	      
	  }
	}
	
		public function update_config_row($num_lesson)
	{
		$DataUpdate = array("NumLesson" =>$num_lesson);
		if($this->db->update('config_row_level', $DataUpdate)){return TRUE ;}else{return FALSE ;}
	} 
		public function get_group_day()
	{
		$GetData = $this->db->query("
		SELECT 
		group_day
		FROM 
		lesson 
		group by group_day
		");
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			   return FALSE ;
			 }
	}
	//////add_new_config_row
	public function add_new_config_row($data = array())
	{
		extract($data);
		$DataUpdate = array("NumLesson" =>$num_lesson);
		$this->db->where('ID', $ConfigID);
		if($this->db->update('config_row_level', $DataUpdate)){return TRUE ;}else{return FALSE ;}
	}
	public function get_teacher()
	{
		$GetData = $this->db->query("
		SELECT 
		contact.ID ,
		contact.Name ,
		employee.NumLesson AS EmpNumLesson ,
		employee.NumWait   AS EmpNumWait, 
		employee.jobTitleID
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
	//////get_emp

	public function get_teacher_classes()
	{
		$GetData = $this->db->query("
		SELECT 
		contact.ID , COUNT(class_table.ID) AS total_classes,
		contact.Name 
		FROM 
		contact 
		LEFT JOIN employee ON contact.ID = employee.Contact_ID
		LEFT JOIN class_table ON class_table.EmpID = contact.ID
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
	public function get_emp($EmpID = 0)
	{
		$GetData = $this->db->query("
		SELECT 
		contact.ID ,
		contact.Name ,
		employee.NumLesson AS EmpNumLesson ,
		employee.NumWait   AS EmpNumWait, 
		employee.jobTitleID
		FROM 
		contact 
		INNER JOIN employee ON contact.ID = employee.Contact_ID 
		where contact.SchoolID IN(".$this->session->userdata('SchoolID').")
		AND contact.ID IN (".$EmpID.")
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
	//////update_emp_numlesson
	public function update_emp_numlesson($data = array())
	{
		extract($data);
		$DataUpdate = array("NumLesson" =>$TxtEmpNumLesson,"NumWait" =>$TxtEmpNumWait);
		$this->db->where('Contact_ID', $hdiID);
		$this->db->update('employee', $DataUpdate);
	}
	//////get_sub
	public function get_sub($RowLevelID = 0)
	{
		$GetData = $this->db->query("
		SELECT 
		subject.ID ,
		subject.Name
		FROM 
		subject 
		INNER JOIN config_subject  ON subject.ID = config_subject.SubjectID 
		WHERE config_subject.RowLevelID = ".(int)$RowLevelID."
		");
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			   return FALSE ;
			 }
	}
	//////getclass
	public function getclass($Lang = NULL)
	{
		if($Lang == 'arabic')
		{
			$GetData = $this->db->query("SELECT ID AS ClassID , Name AS ClassName FROM class WHERE Is_Active = 1 ");
		}
		else
		{
		$GetData = $this->db->query("SELECT ID AS  ClassID, Name_en AS ClassName FROM class WHERE Is_Active = 1 ");
		}
		
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			   return FALSE ;
			 }
	}
	public function get_max_numlesson()
	{
		$GetConfigClassID = $this->get_config();
		 $ConfigClassID   = (int)$GetConfigClassID['ID'];
		$GetData          = $this->db->query
		   ("
		    SELECT
		    max(NumLesson) AS MaxNumLesson
			FROM config_row_level
		
      ");
	  if($GetData->num_rows()>0)
		{
			$GetMax          =  $GetData->row_array();
			$MaxNumLesson    = $GetMax['MaxNumLesson'];
			return $MaxNumLesson ;
		}else{
			   return FALSE ;
			 }
	}
	public function get_max_numlesson_without_year()
	{
		$GetConfigClassID = $this->get_config();
		 $ConfigClassID   = (int)$GetConfigClassID['ID'];
		$GetData          = $this->db->query
		   ("
		    SELECT
		    max(NumLesson) AS MaxNumLesson
			FROM config_row_level 
      ");
	  if($GetData->num_rows()>0)
		{
			$GetMax          =  $GetData->row_array();
			$MaxNumLesson    = $GetMax['MaxNumLesson'];
			return $MaxNumLesson ;
		}else{
			   return FALSE ;
			 }
	}//////////////////get_max_numlesson_rl
	public function get_max_numlesson_rl($RowLevel = 0 )
	{
		$GetData          = $this->db->query
		   ("
		    SELECT
		    max(NumLesson) AS MaxNumLesson
			FROM config_row_level
			WHERE  YearID       = ".(int)$this->session->userdata('YearID')." 
			AND    RowLevelID   = ".(int)$RowLevel."
      ");
	  if($GetData->num_rows()>0)
		{
			$GetMax          =  $GetData->row_array();
			$MaxNumLesson    = $GetMax['MaxNumLesson'];
			return $MaxNumLesson ;
		}else{
			   return FALSE ;
			 }
	}
	//////////get_lesson
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
	////////get_day_lesson
	public function get_day_lesson($RowLevelID= NULL,$DayID = NULL)
	{
		 $GetConfigClassID = $this->get_config();
		 $ConfigClassID   = (int)$GetConfigClassID['ID'];
		 $GetData = $this->db->query("
				  SELECT 
				  NumLesson 
				  FROM config_row_level 
				  WHERE RowLevelID  = ".$RowLevelID." 
				  AND YearID       = ".(int)$this->session->userdata('YearID')."  
				  AND DayID         = ".$DayID." 
		         ");
		if($GetData->num_rows()>0)
		{
			$get_num =$GetData->row_array();
			$num     = $get_num['NumLesson'];
			return $num;
		}else{
			   return FALSE ;
			 }
	}
	
	////////day_lesson
	public function day_lesson($LessonID= 0,$DayID = 0)
	{
		 $GetData = $this->db->query("
				  SELECT 
				  ID 
				  FROM day_lesson 
				  WHERE lessonID  = ".$LessonID." 
				  AND DayID       = ".$DayID." 
		         ");
		if($GetData->num_rows()>0)
		{
			$get_num = $GetData->row_array();
			$num     = $get_num['ID'];
			return $num;
		}else{
			   return 0 ;
			 }
	}
	////////add_emp_config
	public function add_emp_config($data = array())
	{ 
		 extract($data);
		  
		 $GetData = $this->db->query("
				  SELECT 
				  ID 
				  FROM config_emp 
				  WHERE EmpID       = ".$select_emp." 
				  AND SubjectID     = ".$select_sub." 
				  AND RowLevelID    = ".$RowLevelID." 
				  AND YearID        = ".$YearID." 
		         ");
		if($GetData->num_rows()>0)
		{ 
			    return FALSE ;
		}else{ 
		
		      $Where  = array('SubjectID'=>$select_sub,'RowLevelID'=>$RowLevelID);
		      $this->db->select('NumLesson');    
		      $this->db->from('config_subject');
		      $this->db->where($Where); 
			  $this->db->limit(1);
			  $query = $this->db->get();			
			  if($query->num_rows() >0)
			  {$GetNumLesson =  $query->row_array() ; $NumLessonSub = $GetNumLesson['NumLesson'];}else{return TRUE ;}
		
		         $ClassEmpconfig = trim($ClassEmpconfig, ",");
				 $ClassEmpconfig = explode(',' ,$ClassEmpconfig) ;
				 $NumLesson      = $NumLessonSub*sizeof($ClassEmpconfig);
				 $ClassEmpconfig = implode(',' ,$ClassEmpconfig) ;
				 $DayEmpconfig   = trim($DayEmpconfig, ",");
		         $chkDayLesson   = trim($chkDayLesson, ",");

				$DataInsert = array(
				  "EmpID"         =>$select_emp ,
				  "SubjectID"     =>$select_sub,
				  "RowLevelID"    =>$RowLevelID ,
				  "ClassID"       =>$ClassEmpconfig ,
				  "NumLesson"     =>$NumLesson ,
				  "Day"           =>$DayEmpconfig ,
				  "DayLesson"     =>$chkDayLesson ,
				  "ConID"         =>$ConID ,
				  "YearID"        =>$YearID ,
				  "Token"         =>$this->get_token() 
				  );
				 if($this->db->insert('config_emp', $DataInsert)){ return TRUE ;}else{ return FALSE ;};
			 }
	}////////edit_emp_config
	public function edit_emp_config($data = array())
	{ 
		  extract($data);
		  $chkDayLesson   = trim($chkDayLesson, ",");
		  $ClassEmpconfig = trim($ClassEmpconfig, ",");
		  $DayEmpconfig   = trim($DayEmpconfig, ",");

				$DataUpdate = array(
				  "SubjectID"     =>$select_sub,
				  "ClassID"       =>$ClassEmpconfig ,
				  "NumLesson"     =>$numLesson ,
				  "NumWait"       =>$numWait ,
				  "Day"           =>$DayEmpconfig ,
				  "DayLesson"     =>$chkDayLesson ,
				  "ConID"         =>$ConID 
				  );
				  
		   $this->db->where('ID', $ConfigEmpID_h);
		if($this->db->update('config_emp', $DataUpdate)){return TRUE ;}else{return FALSE ;}
	}
	public function delete_config_emp($ConfigEmpID_h)
	{
		 $this->db->where('ID', $ConfigEmpID_h);
         if($this->db->delete('config_emp')){return TRUE  ;}else{return FALSE ;}; 
	}
	////get_emp_config
	public function get_emp_config($RowLevelID = 0,$YearID = 0 )
	{
		 $GetData = $this->db->query("
				    SELECT 
					config_emp.ID        AS ConfigEmpID ,
					config_emp.NumLesson AS ConfigNumLesson ,
					config_emp.NumWait   AS ConfigNumWait ,
					contact.Name  AS ContactName,
					subject.Name  AS SubName
					FROM 
					config_emp
					INNER JOIN contact ON config_emp.EmpID = contact.ID
					INNER JOIN subject ON config_emp.SubjectID = subject.ID
					WHERE  config_emp.RowLevelID      = ".(int)$RowLevelID."
					AND    config_emp.YearID          = ".(int)$YearID." 
					ORDER BY config_emp.ID  DESC 
		         ");
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			   return FALSE ;
			 }
	}
	///////get_edit_emp_config
	public function get_edit_emp_config($ConfigID)
	{
		      $Where  = array('ID'=>$ConfigID);
		      $this->db->select('*');    
		      $this->db->from('config_emp');
		      $this->db->where($Where); 
			  $this->db->limit(1);
			  $query = $this->db->get();			
			  if($query->num_rows() >0)
			  {return $query->row_array() ;}else{return TRUE ;}
	}
	///////get_edit_emp_config
	public function emp_numlesson($EmpID = 0 )
	{
		      $Where  = array('Contact_ID'=>$EmpID);
		      $this->db->select('*');    
		      $this->db->from('employee');
		      $this->db->where($Where); 
			  $this->db->limit(1);
			  $query = $this->db->get();			
			  if($query->num_rows() >0)
			  {return $query->row_array() ;}else{return TRUE ;}
	}
	///////get_edit_emp_config
	public function get_emp_config_lesson($EmpID = 0 ,$yearID = 0 )
	{
		      $Where  = array('EmpID'=>$EmpID,'YearID'=>$yearID);
		      $this->db->select('SUM(NumLesson) AS SumNumLesson');    
		      $this->db->from('config_emp');
		      $this->db->where($Where); 
			  $query = $this->db->get();			
			  if($query->num_rows() >0)
			  {$GetNum = $query->row_array() ; $SumNum = $GetNum['SumNumLesson']  ;return (int)$SumNum ;}else{return 0 ;}
	}
	//////check_data_emp_config
	public function check_data_emp_config($data = array() )
	{
		extract($data);
		$dataReturn = array();
		$dataReturn['select_emp']        = $select_emp ;
		$dataReturn['select_sub']        = $select_sub ;
		$dataReturn['select_row_level']  = $select_row_level ;
		$dataReturn['YearID']            = $YearID ;
		$dataReturn['NumLessonSub']      = 0 ;
		$dataReturn['SumNum']            = 0 ;
		$dataReturn['NumLessonEmp']      = 0 ;
		
		      $Where  = array('SubjectID'=>$dataReturn['select_sub'],'RowLevelID'=>$dataReturn['select_row_level']);
		      $this->db->select('NumLesson');    
		      $this->db->from('config_subject');
		      $this->db->where($Where); 
			  $this->db->limit(1);
			  $query = $this->db->get();			
			  if($query->num_rows() >0)
			  {$GetNumLesson =  $query->row_array() ; $dataReturn['NumLessonSub']  = (int)$GetNumLesson['NumLesson'];}
		
		      $Where  = array('EmpID'=>$dataReturn['select_emp'],'YearID'=>$dataReturn['YearID']);
		      $this->db->select('SUM(NumLesson) AS SumNumLesson');    
		      $this->db->from('config_emp');
		      $this->db->where($Where); 
			  $query = $this->db->get();			
			  if($query->num_rows() >0)
			  {$GetNum = $query->row_array() ; $dataReturn['SumNum']  = (int)$GetNum['SumNumLesson']  ;}
			  
			  $Where  = array('Contact_ID'=>$dataReturn['select_emp']);
		      $this->db->select('*');    
		      $this->db->from('employee');
		      $this->db->where($Where); 
			  $this->db->limit(1);
			  $query = $this->db->get();			
			  if($query->num_rows() >0)
		{$GetNum = $query->row_array() ; $dataReturn['NumLessonEmp']  = (int)$GetNum['NumLesson']  ;}
		
		return   $dataReturn ;

	}
	
	///////add_emp_num_lesson
	public function add_emp_num_lesson($data = array())
	{
		extract($data);
		                $DataUpdate = array(
				        "NumLesson"     =>$numLesson,
				        "NumWait"       =>$numWait 
				  );
				  
		   $this->db->where('Contact_ID', $select_emp);
		if($this->db->update('employee', $DataUpdate)){return TRUE ;}else{return FALSE ;}
	}
	public function get_week($lang)
	{
	    if($lang=='arabic'){
	        $semester_name = 'Name';
	        $week_name     = 'Name';
	    }
	    else{
	        $semester_name = 'Name_en';
	        $week_name     = 'Name_en';
	    }
		$query = $this->db->query("SELECT week.*,config_semester.$semester_name as semester_name,week.$week_name as week_name FROM week
		INNER JOIN config_semester ON week.semester_id = config_semester.ID ")->result();
		if(sizeof($query)>0){return $query ; }else{return false ; }
	}
	
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
		$query = $this->db->query("SELECT week.*,config_semester.$semester_name as semester_name,week.$week_name as week_name FROM week
		INNER JOIN config_semester ON week.semester_id = config_semester.ID
		where week.semester_id=IFNULL($SemesterID,week.semester_id)")->result();
		if(sizeof($query)>0){return $query ; }else{return false ; }
	}
	
	
	public function get_emp12()
	{
		$GetData = $this->db->query("
		SELECT DISTINCT	contact.ID ,contact.Name  FROM `contact` 
        INNER JOIN employee ON contact.ID = employee.Contact_ID
        inner join school_row_level on  school_row_level.SchoolID=contact.SchoolID
        inner join class_table on  class_table.RowLevelID=school_row_level.RowLevelID and class_table.EmpID=contact.ID
	    where contact.SchoolID = '".$this->session->userdata('SchoolID')."'
		and contact.Type ='E'
	
		");
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			   return FALSE ;
			 }
	}
	public function get_lesson_table()
	{
		$GetData = $this->db->query("
		SELECT lesson.ID AS ID,lesson.lesson AS lesson_name  FROM `lesson`
		");
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			   return FALSE ;
			 }
	}
	public function get_lesson_time($level_id,$Semester_id=0)
	{
	    if($Semester_id == 0 ){$Semester_id = 'NULL' ; }
	    if($level_id == 0 ){$level_id = 'NULL' ; }
		$GetData = $this->db->query("
		SELECT `ID`,`lesson_name`,`start_time`,`end_time` FROM `config_lesson`
	    where 
	    semester_id = IFNULL( $Semester_id , semester_id )
	    AND level_id = IFNULL( $level_id , level_id )
	    AND school_id = ".$this->session->userdata('SchoolID')."
		");
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			   return FALSE ;
			 }
	}
	public function add_config_lesson($config_id,$lessonID,$UID,$level_id,$SemesterID,$lessonName,$FromDate,$ToDate,$date)
	{
	    $SchoolID = $this->session->userdata('SchoolID');
	    if($lessonID){
	        $DataInsert = array
		(
		  'semester_id'  =>$SemesterID ,
		  'level_id'     =>$level_id ,
		  'lesson_name'  =>$lessonName ,
		  'start_time'   =>$FromDate ,
		  'end_time'     =>$ToDate ,
		  'school_id'    =>$SchoolID,
		  'updated_by'   =>$UID,
		  'updated_at'   =>$date  
		);
		$this->db->where('ID', $lessonID);
		if($this->db->update('config_lesson', $DataInsert)){return TRUE ;}else{return FALSE ;}
	    }else{
	        $DataInsert = array
		(
		  'semester_id'  =>$SemesterID ,
		  'level_id'     =>$level_id ,
		  'lesson_name'  =>$lessonName ,
		  'start_time'   =>$FromDate ,
		  'end_time'     =>$ToDate ,
		  'school_id'    =>$SchoolID,
		  'config_count' =>$config_id,
		  'inserted_by'  =>$UID,
		  'inserted_at'  =>$date
		);
		if($this->db->insert('config_lesson', $DataInsert)){return TRUE ;}else{return FALSE ;}
	    }
	}
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
	public function get_level_from_config_lesson($Level_ID)
	{
			$GetData = $this->db->query
			("
			  SELECT level_id 
			  FROM `config_lesson` 
			  WHERE config_lesson.level_id=".$Level_ID."
			");
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			   return FALSE ;
			 }
	}
	public function get_lesson1($get_max_numlesson = NULL,$Lang = NULL,$Level_ID)
	{
		if($Lang == 'arabic')
		{
			$GetData = $this->db->query
			("
			  SELECT lesson.ID AS LessonID , lesson.lesson AS LessonName,config_lesson.start_time,config_lesson.end_time 
			  FROM lesson 
			  INNER JOIN config_lesson ON config_lesson.lesson_name=lesson.lesson
			  where config_lesson.level_id= $Level_ID
			  AND config_lesson.semester_id=1
			  AND lesson.ID <= ".(int)$get_max_numlesson."
			  
			");
		}
		else
		{
		   $GetData = $this->db->query
			("
			  SELECT lesson.ID AS LessonID , lesson.lesson AS LessonName,config_lesson.start_time,config_lesson.end_time 
			  FROM lesson 
			  INNER JOIN config_lesson ON config_lesson.lesson_name=lesson.lesson
			  where config_lesson.level_id= $Level_ID
			  AND config_lesson.semester_id=1
			  AND lesson.ID <= ".(int)$get_max_numlesson."
			  
			");
		}
		
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			   return FALSE ;
			 }
	}
	public function get_lesson2($group_day = 1,$Lang = NULL,$Level_ID,$semester_id)
	{
		if($Lang == 'arabic')
		{
			$GetData = $this->db->query
			("
			  SELECT lesson.ID AS LessonID , lesson.lesson AS LessonName,config_lesson.start_time,config_lesson.end_time 
			  FROM lesson 
			  left JOIN config_lesson ON config_lesson.lesson_name=lesson.lesson and config_lesson.level_id= $Level_ID and config_lesson.semester_id=$semester_id
			  where  lesson.group_day = ".$group_day."
			  group by lesson.ID
			  
			");
		}
		else
		{
		   $GetData = $this->db->query
			("
			  SELECT lesson.ID AS LessonID , lesson.lesson AS LessonName,config_lesson.start_time,config_lesson.end_time 
			  FROM lesson 
			  left JOIN config_lesson ON config_lesson.lesson_name=lesson.lesson and config_lesson.level_id= $Level_ID and config_lesson.semester_id=$semester_id
			  where 
			   lesson.group_day = ".$group_day."
			   group by lesson.ID
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
			   where 
			   lesson.group_day =2
			");
		}
		else
		{
		   $GetData = $this->db->query
			("
			  SELECT ID AS LessonID , Lesson_en AS LessonName FROM  lesson  
			  where 
			   lesson.group_day =2
			");
		}
		
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			   return FALSE ;
			 }
	}
	public function get_lesson_night1($get_max_numlesson = NULL,$Lang = NULL,$Level_ID)
	{
		if($Lang == 'arabic')
		{
			$GetData = $this->db->query
			("
			  SELECT lesson.ID AS LessonID , lesson.lesson AS LessonName,config_lesson.start_time,config_lesson.end_time 
			  FROM lesson 
			  INNER JOIN config_lesson ON config_lesson.lesson_name=lesson.lesson
			  where config_lesson.level_id= $Level_ID
			  AND config_lesson.semester_id=1
			  AND lesson.group_day=2
			");
		}
		else
		{
		   $GetData = $this->db->query
			("
			  SELECT lesson.ID AS LessonID , lesson.lesson AS LessonName,config_lesson.start_time,config_lesson.end_time 
			  FROM lesson 
			  INNER JOIN config_lesson ON config_lesson.lesson_name=lesson.lesson
			  where config_lesson.level_id= $Level_ID
			  AND config_lesson.semester_id=1
			  AND lesson.group_day=2
			");
		}
		
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			   return FALSE ;
			 }
	}
	public function del_per_emp($ID = 0 ,$group_id,$Timezone)
	{
	    $select=$this->db->query("
			  SELECT class_table.* FROM class_table  
			  INNER JOIN lesson ON lesson.ID = class_table.Lesson
			  WHERE EmpID = '".$ID."' AND lesson.group_day = $group_id")->result(); 
			  
			  if(!empty($select)){
			   foreach($select as $Key=>$select1)
		         {
		            $select1->deleted_by=$this->session->userdata('id');
		            $select1->deleted_at=$Timezone;
			        $this->db->insert('temp_class_table',$select1);}
			      
			     }
		$query = $this->db->query("DELETE FROM class_table WHERE ID IN (
                                   SELECT class_table.ID FROM class_table
                                   INNER JOIN lesson ON lesson.ID = class_table.Lesson
		                           WHERE EmpID = '".$ID."' AND lesson.group_day = $group_id )");
		return true  ;
	}
	public function get_semester($Lang)
	{
		if($Lang == 'arabic')
		{
			$GetData = $this->db->query
			("
			  SELECT ID,Name as Name,start_date,end_date FROM  config_semester  
			  
			");
		}
		else
		{
		   $GetData = $this->db->query
			("
			  SELECT ID,Name_en as Name,start_date,end_date FROM  config_semester 
			 
			");
		}
		
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			   return FALSE ;
			 }
	}
		public function update_schoolyear($data = array())
	{ 
		extract($data);
		
		$DataUpdated = array
		(
		  'start_date'  =>$FromDate ,
		  'end_date'    =>$ToDate 
		   
		);
		$this->db->where('ID', $SemesterID);
		if($this->db->update('config_semester', $DataUpdated)){return TRUE ;}else{return FALSE ;}
	}
	///////////////////////////////////////////
		public function add_week($data = array())
	{ 
		extract($data);
        $week_name=$this->db->query("select Name,Name_en from week where semester_id = 0 ")->result();
        
		 $DataInsert = array
		  (
		  'Name'        =>$week_name[$count]->Name ,
		  'Name_en'     =>$week_name[$count]->Name_en ,
		  'semester_id' =>$SemesterID,
		  'FromDate'    =>$start_date  ,
		  'ToDate'      =>$end_date,
		  'Date'        =>$date
		  );
		
		if($this->db->insert('week', $DataInsert)){return TRUE ;}else{return FALSE ;}
	}
 }//////END CLASS 
?>