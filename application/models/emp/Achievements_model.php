<?php 
class Achievements_Model extends CI_Model 
 { 
    private $Date       = '' ;
	private $Encryptkey  = '' ;
	private $Token       = '' ;
	
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
	 //get_root_department
	 public function get_achievements()
	 {
		 $idContact = (int)$this->session->userdata('id'); 
		 $Where  = array('contactID'=>$idContact,'IsActive'=>1);
		 $this->db->select('*');
         $this->db->where($Where);
		 $this->db->from('achievements');
		 $Result = $this->db->get();	
			if($Result->num_rows()>0)
				{			
				$ReturnResult = $Result->row_array() ;
				return $ReturnResult ;  
				}else{
						 $DataInsert = array
								 ( 
								  'contactID'         =>$idContact ,
								  'Token'             =>$this->get_token()
								);
								if($this->db->insert('achievements', $DataInsert))
											{
												$Where  = array('contactID'=>$idContact,'IsActive'=>1);
				 								$this->db->select('*');
												$this->db->where($Where);
				                                $this->db->from('achievements');
				                                $Result = $this->db->get();	
					                             if($Result->num_rows()>0)
						                             {			
						                                $ReturnResult = $Result->row_array() ;
						                                return $ReturnResult ;  
					                                 	}	 	
											}
				}
	 } 
	 //get_pic
	 public function get_pic()
	 {
		 $idContact = (int)$this->session->userdata('id'); 
		 $Where  = array('achievements.contactID'=>$idContact,'achievements.IsActive'=>1);
		 $this->db->select('*');
         $this->db->where($Where);
		 $this->db->from('achievements');
		 $this->db->join('achievements_pic','achievements_pic.achievementsID = achievements.ID ');
		 $Result = $this->db->get();	
			if($Result->num_rows()>0)
				{			
				$ReturnResult = $Result->result() ;
				return $ReturnResult ;  
				}else{
					 return 0;  
				}
	 } 
	public function set_achievements($data = array())
	{
		 $idContact = (int)$this->session->userdata('id'); 
extract($data);
		 $DataInsert = array
								 ( 
								  'indexing'         =>$indexing,
								  'values_institution'         =>$values_institution,
								  'biography'         =>$biography,
								  'basic_data'         =>$basic_data,
								  'training_programs'         =>$training_programs,
								  'certificates_thanks'         =>$certificates_thanks,
								  'refresher_episodes'         =>$refresher_episodes,
								  'educational_institution'         =>$educational_institution,
								  'participation'         =>$participation,
								  'creations'         =>$creations,
								  'accomplishments'         =>$accomplishments
								);
		$this->db->where('ID', $achievements_id);
								if($this->db->update('achievements', $DataInsert))
											{

											 	return true;
											}else{
												return false ; 
												}
	}
	public function add_pic($img)
	{
		 $idContact = (int)$this->session->userdata('id'); 

		 $Where  = array('contactID'=>$idContact,'IsActive'=>1);
		 $this->db->select('*');
         $this->db->where($Where);
		 $this->db->from('achievements');
		 $Result = $this->db->get();	
			if($Result->num_rows()>0)
				{			
				$ReturnResult = $Result->row_array() ;
				  
				


								 $DataInsert = array
								 ( 
								  'pic'               =>$img ,
								  'achievementsID'    =>$ReturnResult['ID'],
								  'contactID'         =>$idContact ,
								  'Token'             =>$this->get_token()
								);
								if($this->db->insert('achievements_pic', $DataInsert))
											{
											 	return true;
											}else{
												return false ; 
												}
}
	}
 }////end cms?>