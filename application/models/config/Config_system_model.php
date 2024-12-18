<?php
class Config_System_Model extends CI_Model 
 {
	private $Date       = '' ;
	private $Encryptkey = '' ;
	private $Token      = '' ;
	private $ID         = 0 ;
	private $YearFrom   = 0 ;
	private $YearTo     = 0 ;
	private $ContactID  = 0 ;
	function __construct()
    {
	   parent::__construct();
	   $this->Date  = date('Y-m-d H:i:s');
	   $this->Encryptkey = $this->config->item('encryption_key');
    }
	////////get_token
	private function get_token()
	{
	   $this->Token            = md5($this->Encryptkey.uniqid(mt_rand()).microtime()) ;
	   return	$this->Token ; 
	}
	///////////////////////
	public function get_year_hook()
	{
		$GetData = $this->db->query
		(" SELECT * FROM year WHERE IsActive = 1 GROUP BY ID DESC LIMIT 1 ");
		if($GetData->num_rows()>0)
		{
		  return $GetData->row_array();
		} else {return FALSE ;}
		
	}
	/////////////////////////
	public function get_year()
	{
		$GetData = $this->db->query
		(" SELECT * FROM year WHERE IsActive = 1 GROUP BY ID DESC ");
		if($GetData->num_rows()>0)
		{
		  return $GetData->result();		
		} else {return FALSE ;}
		
	}
	/////////////////////////
	public function get_allYear()
	{
		$GetData = $this->db->query
		(" SELECT * FROM year ");
		if($GetData->num_rows()>0)
		{
		  return $GetData->result();		
		} else {return FALSE ;}
		
	}
	public function get_specific_year($ID)
	{
		$GetData = $this->db->query
		(" SELECT * FROM year WHERE ID = $ID ");
		if($GetData->num_rows()>0)
		{
		  return $GetData->row_array();		
		} else {return FALSE ;}
	}	
	////get_semester
	public function get_semester($Lang)
	{
		if($Lang == 'arabic')
		{
		  $GetData = $this->db->query(" SELECT ID ,Name AS Name FROM config_semester ");
		}else
		{
		  $GetData = $this->db->query(" SELECT ID , Name_en AS Name FROM config_semester ");
		}
		  return $GetData->result();		
	}
	//////////////
	public function new_year($data = array())
	{
		extract($data);
		
		$DataInsert = array(
		'YearFrom'      =>$YearFrom,
		'YearTo'        =>$YearTo,
		'ContactID'     =>$UID,
		'year_name'     =>$YearFrom."-".$YearTo,
		'year_name_hij' =>$year_name_hij,
		'ID_ERP'        =>$ID_ERP
		);
		if($ID){
			$this->db->where('ID', $ID);
			if($this->db->update('year', $DataInsert)){return TRUE ;}else{return FALSE ;}
			
		}else{
			$this->db->query(" update year set IsActive=0 ");
			if($this->db->insert('year', $DataInsert)){return TRUE ;}else{return FALSE ;}
			
		}
		
			
	}
	////check_year
	public function check_year($YearID)
	{
		$GetData = $this->db->query(" SELECT ID FROM config_class_table WHERE YearID = ".$YearID." ");
		if($GetData->num_rows()>0)
		  {
		     return TRUE ;		
		  }  else {return FALSE ;}		
	}
	////get_day
	public function get_day($Lang)
	{
		if($Lang == 'arabic')
		{
		  $GetData = $this->db->query(" SELECT ID ,Name AS Name FROM day ");
		}else
		{
		  $GetData = $this->db->query(" SELECT ID , Name_en AS Name FROM day ");
		}
		  return $GetData->result();		
	}
	////get_config_class_table
	public function get_config_class_table($Lang)
	{
		if($Lang == 'arabic')
		{
		  $GetData = $this->db->query(" 
		  SELECT 
		  config_class_table.ID ,
		  day.Name               AS StDayName ,
		  dayt1.Name             AS EndDayName ,
		  year.YearFrom          AS YearFrom ,
		  year.YearTo            AS YearTo 
		  FROM
		  config_class_table
		  INNER JOIN day ON config_class_table.StartDay = day.ID
		  INNER JOIN day as dayt1 ON config_class_table.EndDay = dayt1.ID
		  INNER JOIN year ON config_class_table.YearID = year.ID 
		  GROUP BY config_class_table.ID  DESC
		  ");
		}else
		{
		  $GetData = $this->db->query(" 
		  SELECT 
		  config_class_table.ID ,
		  day.Name                  AS StDayName ,
		  dayt1.Name_en             AS EndDayName ,
		  year.YearFrom             AS YearFrom ,
		  year.YearTo               AS YearTo 
		  FROM
		  config_class_table
		  INNER JOIN day ON config_class_table.StartDay = day.ID
		  INNER JOIN day as dayt1 ON config_class_table.EndDay = dayt1.ID
		  INNER JOIN year ON config_class_table.YearID = year.ID 
		  GROUP BY config_class_table.ID  DESC
		  ");
		}
		  
		  if($GetData->num_rows()>0)
		  {
		     return $GetData->result();		
		  }  else {return FALSE ;}		
	}
	
	////add_new_config
	public function add_new_config($data = array())
	{
		extract($data);
		$DataInsert = array(
		'StartDay'=>$start_day,
		'EndDay'=>$end_day,
		'YearID'=>$YearID
		);
		if($this->db->insert('config_class_table', $DataInsert)){return TRUE ;}else{return FALSE ;}
	}
	
	public function Get_school()
	{
		$GetSchool = $this->db->query("select * from school_details")->row_array();
		return $GetSchool ;
		
	}
 }/////////END CLSS 
?>