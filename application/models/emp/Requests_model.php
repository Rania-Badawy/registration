<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Requests_Model extends CI_Model {

	function __construct() {
	   parent::__construct();
	   $this->Date       = date('Y-m-d H:i:s');
	   $this->Encryptkey = $this->config->item('encryption_key');
	   $this->Token      = $this->get_token();
       $this->user_id    = (int)$this->session->userdata("id");
       $this->SchoolID   = (int)$this->session->userdata('SchoolID');
    }

    private function get_token()
    {
       $this->Token = md5($this->Encryptkey.uniqid(mt_rand()).microtime()) ;
       return $this->Token ; 
    }

    public function getSchoolName()
    {
        return $this->db->select('SchoolName')->where('ID', $this->SchoolID)->get('school_details')->row_array()['SchoolName'];
    }
    
    public function getRequestType()
    {
        return $this->db->select('*')->where('is_active',1)->get('request_type')->result();
    }
    
    public function getRequestCategory()
    {
        return $this->db->select('*')->where('is_active',1)->get('category')->result();
    }
    
    public function getRequestStatus()
    {
        return $this->db->select('*')->where('is_active',1)->get('status')->result();
    }

   

    
    
     public function GetRequestList()
    {   
       $query = $this->db->query("SELECT requests.*, CASE WHEN LENGTH(f.Mobile) >= 9 THEN f.Mobile ELSE f.Phone END AS Mobile ,s.Name As studenName,row_level.Level_Name,row_level.Row_Name,class.Name as class_Name,school_details.SchoolName,request_type.Name  As typeName, category.Name  As categoryName , status.Name  As statusName,status.ID  As statusID,row_level.Level_ID ,student.Class_ID,student.R_L_ID,employee.PerType ,employee.Branch ,employee.Type ,emp.Name AS ContactName ,permission_group.Name AS GroupName,
	                            emp.GroupID ,name_space.Name as reg_name , permission_request.req_type , permission_request.category 
                        		FROM  contact as emp
                        		LEFT JOIN employee ON employee.Contact_ID = emp.ID
                        		LEFT JOIN permission_group ON emp.GroupID = permission_group.ID
                        		LEFT JOIN permission_request on emp.ID =permission_request.EmpID
                        		LEFT JOIN name_space  on permission_request.NameSpaceID =name_space.ID
                                INNER JOIN requests  on FIND_IN_SET(requests.type_id,permission_request.req_type) and FIND_IN_SET(requests.category_id,permission_request.category)
                                INNER JOIN request_type on requests.type_id =request_type.id
                                INNER JOIN category on requests.category_id =category.id
                                left JOIN status on requests.status_id =status.id
                                INNER JOIN student ON requests.student_id=student.Contact_ID
                                INNER JOIN row_level on student.R_L_ID=row_level.ID 
                                INNER JOIN class on student.Class_ID=class.ID 
                                INNER JOIN contact as s on s.ID=student.Contact_ID and FIND_IN_SET(s.SchoolID,employee.Branch) 
                                INNER JOIN contact as f on f.ID=requests.sender 
                                INNER JOIN school_details on school_details.ID=s.SchoolID
                        		WHERE emp.ID = '". $this->user_id."' AND emp.GroupID = 98 AND emp.Isactive = 1 AND requests.is_deleted = 0 AND requests.status_id != 2
                        		ORDER BY requests.created_at DESC , requests.status_id DESC")->result();

		if(sizeof($query)>0)
		{
			return $query ;
		}else{

			return false ;
		}
    }
    
     public function GetRequestEmployeeList()
    {   
       $query = $this->db->query("SELECT requests.*, CASE WHEN LENGTH(sender.Mobile) >= 9 THEN sender.Mobile ELSE sender.Phone END AS Mobile ,sender.Name As senderName,school_details.SchoolName,request_type.Name  As typeName, category.Name  As categoryName , status.Name  As statusName,status.ID  As statusID,employee.PerType ,employee.Branch ,employee.Type ,emp.Name AS ContactName ,permission_group.Name AS GroupName,
	                            emp.GroupID ,name_space.Name as reg_name , permission_request.req_type , permission_request.category 
                        		FROM  contact as emp
                        		LEFT JOIN employee ON employee.Contact_ID = emp.ID
                        		LEFT JOIN permission_group ON emp.GroupID = permission_group.ID
                        		LEFT JOIN permission_request on emp.ID =permission_request.EmpID
                        		LEFT JOIN name_space  on permission_request.NameSpaceID =name_space.ID
                                INNER JOIN requests  on FIND_IN_SET(requests.type_id,permission_request.req_type) and FIND_IN_SET(requests.category_id,permission_request.category)
                                INNER JOIN request_type on requests.type_id =request_type.id
                                INNER JOIN category on requests.category_id =category.id
                                left JOIN status on requests.status_id =status.id
                                INNER JOIN contact as sender on sender.ID=requests.sender and FIND_IN_SET(sender.SchoolID,employee.Branch) and sender.Type='E'
                                INNER JOIN school_details on school_details.ID=sender.SchoolID
                        		WHERE emp.ID = '". $this->user_id."' AND emp.GroupID = 98 AND emp.Isactive = 1 AND requests.is_deleted = 0 AND requests.status_id != 2 and requests.student_id IS NULL
                        		ORDER BY requests.created_at DESC, requests.status_id DESC")->result();

		if(sizeof($query)>0)
		{
			return $query ;
		}else{

			return false ;
		}
    }
    
    
    
    public function count_requests()
    {   
       $total = $this->db->query("SELECT * FROM (
                                    SELECT max(replies.id) as id   FROM `replies` GROUP BY  replies.request_id) t
                                 INNER join replies on t.id=replies.id
                                 INNER JOIN requests on requests.id=replies.request_id
                                 INNER JOIN contact on  contact.ID=replies.reply_by 
                                 INNER JOIN contact AS SUP on  SUP.ID=".$this->session->userdata("id")."
                                 INNER JOIN contact AS send on  requests.sender=send.ID
                                 INNER JOIN employee ON employee.Contact_ID = SUP.ID and FIND_IN_SET(send.SchoolID,employee.Branch)
                                 INNER JOIN permission_request on SUP.ID =permission_request.EmpID and FIND_IN_SET(requests.category_id,permission_request.category)
                                 and FIND_IN_SET(requests.type_id,permission_request.req_type)
                                 WHERE contact.GroupID!=98 and replies.is_read=0 and requests.status_id != 2 AND requests.is_deleted=0")->num_rows();
		if($total>0)
		{
			return $total ;
		}else{

			return 0 ;
		}
    }
     ////////////////////////////
    public function count_requests_emp()
    {   
       $total = $this->db->query("SELECT * FROM (
                                    SELECT max(replies.id) as id   FROM `replies` GROUP BY  replies.request_id) t
                                 INNER join replies on t.id=replies.id
                                 INNER JOIN requests on requests.id=replies.request_id
                                 INNER JOIN contact on  contact.ID=replies.reply_by 
                                 INNER JOIN contact AS SUP on  SUP.ID=".$this->session->userdata("id")." and SUP.ID=requests.sender
                                 WHERE replies.is_read=0 and replies.is_read=0 and contact.GroupID=98  AND requests.is_deleted=0")->num_rows();
		if($total>0)
		{
			return $total ;
		}else{

			return 0 ;
		}
    }
     public function addReply($id,$Timezone)
    {
        $reply   = $this->input->post('reply');
        $status_id   = $this->input->post('status_id');
        if($status_id==17){
            $closed=1;
            $closed_by= $this->user_id;
        }else{
            $closed=0;
            $closed_by=0;
        }
        if($reply){ $where = "reply='".$reply."',";}else{$where = "";}
        $Request=$this->db->query("UPDATE requests   SET reply='".$reply."', status_id='".$status_id."' ,is_closed='".$closed."' ,updated_at	='".$Timezone."',reply_emp_id	='".$this->user_id."'
            				 ,closed_by=$closed_by WHERE id = '".$id."' ") ;
        	if($Request ){
					return TRUE ;
				}else{return FALSE ;}
       
    }
    
    
      
    public function sendRequest($Timezone)
    {

        $data['type_id']          = $this->input->post('type_id');
        $data['category_id']      = $this->input->post('category_id');
        $data['sender']           = $this->user_id;
        $data['request']          = $this->input->post('request_text');
        $data['attachment']       = $this->input->post('attachment');
        $data['created_at']       = $Timezone;
        
            $this->db->insert('requests', $data); 
           
        $id                          = $this->db->insert_id();
        $Data['reply']               = $this->input->post('request_text');
        $Data['request_id']          = $id;
        $Data['reply_by']            = $this->user_id;
        $Data['created_at']          = $Timezone;
        
        $this->db->insert('replies', $Data); 
    }
    
     public function updateRequest($Timezone)
    {
        
     
        $data['type_id']       = $this->input->post('type_id');
        $data['category_id']   = $this->input->post('category_id');
        $data['status_id']     = $this->input->post('status_id');
        $data['sender']        = $this->user_id;
        $data['request']       = $this->input->post('request_text');
        $data['attachment']    = $this->input->post('attachment');
        $data['updated_at']    = $Timezone;
        $id                    =  $this->input->post('rid');
            $this->db->where('id', $id ); 
				$Request =  $this->db->update('requests', $data); 
					if($Request ){
					     $Data['reply']               = $this->input->post('request_text');
					     $this->db->where('request_id', $id ); 
				         $this->db->update('replies', $Data); 
					return TRUE ;
				}else{return FALSE ;}
       
    }
     public function GetRequestList1()
    {   
        return $this->db
                    ->select('requests.*,request_type.Name  As typeName, category.Name  As categoryName , status.Name  As statusName')
                    ->join('request_type','requests.type_id =request_type.id') 
                    ->join('category','requests.category_id =category.id')
                    ->join('status','requests.status_id =status.id', 'left') 
                    ->join('contact emp','requests.sender = emp.ID and emp.Type="E"')
                    ->where('requests.sender= '.$this->user_id.'')
                    ->where('requests.is_deleted=0')
                    ->where('requests.student_id IS NULL')
                    ->order_by('requests.created_at desc,requests.status_id asc')
                    ->get('requests')
                    ->result();
    }
    
     public function count_requests1()
    {   
       $query = $this->db->query("SELECT COUNT(id) as total FROM `requests` WHERE `reply`IS Null and `is_closed`=0 and sender = '". $this->user_id."'")->row();
        $total=$query->total;
		if($total>0)
		{
			return $total ;
		}else{

			return 0 ;
		}
    }
    
     public function addEvaluation($id,$Timezone)
    {
        $evaluation   = $this->input->post('evaluation');
        $Request=$this->db->query("UPDATE requests   SET evaluation='".$evaluation."' , updated_at	='".$Timezone."' 
            				  WHERE id = '".$id."' ") ;
        if($Request ){
					return TRUE ;
				}else{return FALSE ;}
       
    }
    
     public function DelRequest($id,$Timezone)
	 {
		 
		
				 $data = array(
				 'is_deleted'   =>(int)1,
				 'updated_at'     =>$Timezone
				 );
		
				$this->db->where('id', $id ); 
				$Request =  $this->db->update('requests', $data); 
				if($Request ){
					return TRUE ;
				}else{return FALSE ;}
			
		
	 }

   public function get_replies($id)
	 {
	      $group = $this->db->query("SELECT GroupID from contact where ID =".$this->session->userdata('id')." ")->row_array();
	      if($group['GroupID']!=98){
	          $where=" and contact.Type !='U'";
	      }
             $query = $this->db->query("SELECT requests.id as r_id, requests.request,requests.satisfy,
             requests.status_id,replies.* ,contact.* FROM `requests`
             left join replies on replies.request_id=requests.id
             left join contact on replies.reply_by=contact.ID
             WHERE  requests.id = '". $id."' $where ")->result();
        
			return $query ;
		
	 }
	 
	  public function addReply1($request_id,$Timezone)
    {
        $data['reply']        = $this->input->post('reply');
        $data['attachment']   = $this->input->post('hidImg');
        $satisfy              = $this->input->post('satisfy');
        $data['request_id']   = $request_id;
        $data['reply_by']     = $this->user_id;
        $data['created_at']   = $Timezone;
        $status_id            = $this->input->post('status_id');
        if($data['reply']|| $data['attachment'] || $status_id){
            $this->db->insert('replies', $data);}
            
        if($status_id){
        if($status_id==17){
            $closed=1;
            $closed_by= $this->user_id;
        }else{
            $closed=0;
            $closed_by=0;
        }
        $Request=$this->db->query("UPDATE requests   SET  status_id='".$status_id."' ,is_closed='".$closed."' ,updated_at	='".$Timezone."',satisfy='".$satisfy."'
            				 ,closed_by=$closed_by WHERE id = '".$request_id."' ") ;}
       
    }

   

}
?>