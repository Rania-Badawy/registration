<?php
class Config_Model  extends CI_Model
 {
	 private $ID ; 
	 private $Name ; 
	 private $Name_en ; 
	 private $Value ; 
	 private $Start_Date = 0; 
	 private $End_Date   = 0; 
	 private $Parent_ID  = 0;
	 const   Is_Active   = 1 ;  
	 private $Token ;
	 private $year ; 
	 private $num_semester ;
	 ///create_token
	 public function create_token()
	{
			$ArrayNum = array('0','1','2','3','4','5','6', '7','8','9');
			$Num = '';
			$Count = 0;
			while ($Count <= 9) {$Num .= $ArrayNum[mt_rand(0, 8)];$Count++; }
			$ArrayStr = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P',
			'Q','R','S','T','U','W','X','Y','Z');
			$Str = '';
			$Count = 0;
	
			while ($Count <= 14) {$Str .= $ArrayStr[mt_rand(0, 15)];$Count++;}	
			$encrypt = 'qwdfghm,][poiasdfghj.zxcvbnm,.957365254068061531qwertyuiasdfghjkl;12345678-=dvxcvbbn' ;	
			$Token            = md5($encrypt.$Str.$Num.uniqid(mt_rand()).microtime()) ;
			return $Token ; 
	}
	 //git_config_active
	 public function git_config_active()
	 {
			    $WHERE = array('Is_Active'=>self::Is_Active) ; 
			    $this->db->select('ID');
                $this->db->from('config_semester');
                $this->db->where($WHERE);
				$this->db->limit(1);
				$ResultData = $this->db->get();
			    if($ResultData->num_rows()>0){return TRUE;}	else{return FALSE;}
	 }
	 ///get_semester
	 public function get_semester($Lang)
	 {
		
		 if($Lang == 'english')
		 {
			     $Where = array('Is_Active'=>1);
			     $this->db->select('ID,Name_en AS Name');
                 $this->db->from('config_semester');
                 $this->db->where($Where);
				 $ResultData = $this->db->get();
				 if($ResultData->num_rows()>0)
				 {
					 return $ResultData->result();
					 return TRUE ;
				 } else{return FALSE ;}
		 }else
		 {
			     $Where = array('Is_Active'=>1);
			     $this->db->select('ID,Name AS Name');
                 $this->db->from('config_semester');
                 $this->db->where($Where);
				 $ResultData = $this->db->get();
				 if($ResultData->num_rows()>0)
				 {
					 return $ResultData->result();
					 return TRUE ;
				 } else{return FALSE ;}
		 }
	 }
 }//end class
?>