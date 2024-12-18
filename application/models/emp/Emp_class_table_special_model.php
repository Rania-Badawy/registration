<?php
class Emp_Class_Table_Special_Model extends CI_Model{
	private $Date='',$Encryptkey='',$Token='',$UID=0,$ClassID=0,$ClassTableID=0,$WeekID=0;
	function __construct()
    {
	   parent::__construct();
	   $this->Date       = date('Y-m-d H:i:s');
	   $this->Encryptkey = $this->config->item('encryption_key');
	  // $this->Token      = $this->get_token();
    }
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
    public function check_class_table($ID = 0 )
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
    }
    public function get_day($Lang = NULL )
	{
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
		 }else
		  {
			  return FALSE ;
		  }
	}

    public function get_row_level($Lang = NULL)
	 {
		 if($Lang == 'arabic')
		{
		    $query = $this->db->query("
			SELECT 
			level.Name   AS  LevelName ,
			row.Name     AS  RowName ,
			row_level.ID AS  RowLevelID
			FROM
			row_level 
			INNER JOIN row              ON row_level.Row_ID        = row.ID
			INNER JOIN level            ON row_level.Level_ID      = level.ID
			INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = '".$this->session->userdata('SchoolID')."' 

			WHERE level.Is_Active       = 1
		");
		}else{
			    $query = $this->db->query("
				SELECT 
				level.Name_en   AS  LevelName ,
				row.Name_en     AS  RowName ,
				row_level.ID    AS  RowLevelID
				FROM
				row_level 
				INNER JOIN row              ON row_level.Row_ID        = row.ID
				INNER JOIN level            ON row_level.Level_ID      = level.ID
				WHERE level.Is_Active       = 1
			   ");
			 }
			 if($query->num_rows() >0)
			  {return $query->result();}else{return FALSE ;}
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
    public function getclass($Lang = NULL)
	{
		//echo $this->session->userdata('SchoolID').'----' ; exit;
		if($Lang == 'arabic')
		{
			$GetData = $this->db->query("SELECT class.ID AS ClassID , class.Name AS ClassName FROM class INNER JOIN school_class ON class.ID = school_class.ClassID WHERE class.Is_Active = 1 AND school_class.SchoolID = '".$this->session->userdata('SchoolID')."' ");
		}
		else
		{
		$GetData = $this->db->query("SELECT class.ID AS  ClassID, class.Name_en AS ClassName FROM class INNER JOIN school_class ON class.ID = school_class.ClassID WHERE class.Is_Active = 1 AND school_class.SchoolID = '".$this->session->userdata('SchoolID')."'  ");
		}
		
		if($GetData->num_rows()>0)
		{
			return $GetData->result();
		}else{
			   return FALSE ;
			 }
    }
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
    public function get_emp_subjects($Lang = NULL , $UID = 0)
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
				 
			         WHERE class_table.EmpID = ".$UID."
                                 GROUP BY class_table.SubjectID , class_table.RowLevelID
				");
			}
			  if($query->num_rows() >0)
			  {return $query->result();}else{return FALSE ;}
	}
	public function class_table_update($data = array())
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
										'ConID'      => $StudentID,
										'Token'      => $this->get_token(),
										'special_st' =>1
										);
										
										$this->db->insert('class_table', $DataInsert);
										
										return 1;
					}
			 }
		
	}////////////////get emp class table 
}