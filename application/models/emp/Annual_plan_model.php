<?php
class Annual_Plan_Model extends CI_Model{
	 
	private $Date            = '' ;
	private $Encryptkey      = '' ;
	private $Token      	 = '' ;
	
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
	   $this->Token = md5($this->Encryptkey.uniqid(mt_rand()).microtime()) ;
	   return $this->Token ; 
	}
	
	////////get_data
	public function get_Data()
	{
		$ContactID = $this->session->userdata('id');
		$this->db->select(' ID AS ProgID,  token AS ProgToken, name AS ProgName, fromDate AS StartDate, toDate AS EndDate, 
						    levelID AS ProgLevelID, IsActive AS Status,
						 ');
		$this->db->from('counseling_students');
		$this->db->order_by('Date', 'desc');
		$this->db->where('ContactID', $ContactID);
		
		$ResultData = $this->db->get();			
		$NumRowResultData  = $ResultData->num_rows() ; 
		if($NumRowResultData != 0)
		  {
				$ReturnData = $ResultData ->result() ;
				return $ReturnData ;
		  }
		  else
		  {
			  return $NumRowResultData ;
		  }
	}
	
	//get Choosen subjects
	 public function get_levels($Lang = NULL)
	 {
		 if($Lang == 'arabic')
		{
		    $query = $this->db->query("
			SELECT ID   AS  LevelID , Name   AS  LevelName 
			FROM level 
			WHERE Is_Active = 1
		");
		}else{
			    $query = $this->db->query("
				SELECT ID   AS  LevelID , Name_en   AS  LevelName 
				FROM level 
				WHERE Is_Active = 1
			   ");
			 }
			 if($query->num_rows() >0)
			  {return $query->result();}else{return FALSE ;}
	 }
	
	//get Choosen subjects
	 public function get_levels_name($Lang = NULL , $LevelID = NULL)
	 {
		 if($Lang == 'arabic')
		{
		    $query = $this->db->query("
			SELECT Name AS LevelName 
			FROM level 
			WHERE ID = '".$LevelID."'
		");
		}else{
			    $query = $this->db->query("
				SELECT Name_en AS LevelName 
				FROM level 
				WHERE ID = '".$LevelID."'
			   ");
			 }
			 if($query->num_rows() >0)
			  {return $query->row_array();}else{return FALSE ;}
	 }
	 
	////////get_data
	public function addProg($data)
	{
		extract($data);
		$DataInsert = array("name"  		=>$ProgramName ,
							"Target"  		=>$Target ,
							"TargetDetails"	=>$TargetDetails ,
							"fromDate"  	=>$FromDate ,
							"toDate"  		=>$ToDate ,
							"Requirements"	=>$Requirements ,
							"levelID"  		=>$RowLevelID ,
							"responsibleEntityMain"	=>$ResponEntityMain ,
							"responsibleEntitySub"	=>$ResponEntitySub ,
							"Support"  		=>$Support ,
							"investigationIndicators"  	=>$InvestIndicat ,
							"notes"  		=>$Notes ,
							"carriedOut"  	=>$carriedOut ,
							"scriptYoutube"	=>$YoutubeScript ,
							"Explanation"  	=>$Explanation ,
							"IsActive" 		=> 1 , 
							"token" 		=>$this->Token ,
							"ContactID"		=>$contactID
							);
		$this->db->insert('counseling_students',$DataInsert);
		return TRUE ;
	}
	
	////////get_data
	public function getProg($ProgToken)
	{
		$this->db->select('*');
		$this->db->from('counseling_students');
		$this->db->where('token', $ProgToken);
		
		$ResultData = $this->db->get();			
		$NumRowResultData  = $ResultData->num_rows() ; 
		if($NumRowResultData != 0)
		  {
				$ReturnData = $ResultData ->row_array() ;
				return $ReturnData ;
		  }
		  else
		  {
			  return $NumRowResultData ;
		  }
	}
	
	////////get_data
	public function editProg($data)
	{
		extract($data);
		$DataUpdate = array("name"  		=>$ProgramName ,
							"Target"  		=>$Target ,
							"TargetDetails"	=>$TargetDetails ,
							"fromDate"  	=>$FromDate ,
							"toDate"  		=>$ToDate ,
							"Requirements"	=>$Requirements ,
							"levelID"  		=>$RowLevelID  ,
							"responsibleEntityMain"	=>$ResponEntityMain ,
							"responsibleEntitySub"	=>$ResponEntitySub ,
							"Support"  		=>$Support ,
							"investigationIndicators"  	=>$InvestIndicat ,
							"notes"  		=>$Notes ,
							"carriedOut"  	=>$carriedOut ,
							"scriptYoutube"	=>$YoutubeScript ,
							"Explanation"  	=>$Explanation 
							);
		$this->db->where('token', $ProgramToken);
		$this->db->update('counseling_students', $DataUpdate); 
		return TRUE ;
	}
	
	 	////////Active Dep
	public function activeProg($ProgID)
	{
		$DataUpdate = array("IsActive" => 1);
		$this->db->update('counseling_students', $DataUpdate , array('ID' => $ProgID));
		return TRUE ;
	}
 
	////////Not Active Dep
	public function notActiveProg($ProgID)
	{
		$DataUpdate = array("IsActive" => 0);
		$this->db->update('counseling_students', $DataUpdate , array('ID' => $ProgID));
		return TRUE ;
	}

	////////Not Active Dep
	public function delProg($ProgID)
	{
		$this->db->delete('counseling_students', array('ID' => $ProgID));
		return TRUE ;
	}

	
	
	
	
	
	
	
	
	
 }
?>