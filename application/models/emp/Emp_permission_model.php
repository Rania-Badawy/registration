<?php
class Emp_Permission_Model extends CI_Model{
	private $Date='',$Encryptkey='',$Token='';
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
	//////get_page
	public function get_page($UID = 0)
	{
		$GetDataUser = $this->db->query("SELECT GroupID FROM contact WHERE ID = '".$UID."'")->row_array();
		
		 $query = $this->db->query("
		 SELECT 
		 permission_page.ID             AS PageID  ,
		 permission_page.PageUrl        AS PageUrl  ,
		 permission_page.PageName       AS PageName
		 FROM 
		 permission_page
		 INNER JOIN group_page ON permission_page.ID = group_page.PageID 
		 WHERE group_page.GroupID = ".$GetDataUser['GroupID']."
group by  permission_page.ID 

		");
		if($query->num_rows() >0)
		{return $query->result();}else{return FALSE ;}
	}
	//////get_page
	public function check_user_page($PageUrl ,$UID = 0)
	{
		 $query = $this->db->query("
		 SELECT 
		 permission_page.PageName       AS PageName ,
		 user_permission.PermissioLevel ,
		 user_permission.PermissioView ,
		 user_permission.PermissionAdd ,
		 user_permission.PermissionEdit ,
		 user_permission.PermissionDelete 
		 FROM 
		 permission_page
		 INNER JOIN user_permission ON permission_page.ID = user_permission.PageID 
		 WHERE user_permission.EmpID = ".$UID." AND permission_page.PageUrl LIKE '%$PageUrl%'
		 LIMIT 1
		");
		if($query->num_rows() >0)
		{return $query->row_array();}else{return FALSE ;}
	}
		////get_level
		public function get_level()
		{
			  $this->db->select('ID ,Name ,Token');    
			  $this->db->from('level');
			  $this->db->where('Is_Active',1);
			  $query = $this->db->get();			
			  if($query->num_rows() >0)
			 {return $query->result();}else{return FALSE ;}
		}////get_job_title
		public function get_job_title($ContactID = 0 )
		{
			  $this->db->select('*');    
			  $this->db->from('employee');
			  $this->db->where('Contact_ID',$ContactID);
			  $query = $this->db->get();			
			  if($query->num_rows() >0)
			 {return $query->row_array();}else{return FALSE ;}
		}
 }//////END CLASS?>