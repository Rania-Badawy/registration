<?php
class Room_Educational_Model extends CI_Model 
 {
	private $Date            = '' ;
	private $Encryptkey      = '' ;
	private $Token           = '' ;
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
	//////get_emp
	public function get_room($UID = 0)
	{
		$GetDateToday = date('Y-m-d');
	   $GetRoomToday = $this->db->query("SELECT 
	   room_create.FromDate ,
	   room_create.FromTime ,
	   room_create.ToDate ,
	   room_create.ToTime ,
	   room_create.RoomName ,
	   room_create.PassRoom ,
	   room_create.HashModerate ,
	   room_create.Token ,
	   subject.Name AS SubjectName ,
	   contact.Name AS ContactName
	   FROM room_create 
	   INNER JOIN 
	   subject ON room_create.SubjectID  = subject.ID
	   INNER JOIN
	   contact ON room_create.ModerateID  = contact.ID
	   WHERE room_create.FromDate = '".$GetDateToday ."'
	   AND   room_create.ModerateID = '".$UID ."'
		");
		if( $GetRoomToday->num_rows()>0)
		{
			return $GetRoomToday->result();
		}else{return FALSE ;}
	}
 }/////////END CLASS 
?>