<?php
class Message_Model extends CI_Model{
	 private $Contact_ID     = 0 ;
	 private $Name           = '' ;
	 private $Gender         = 0;
	 private $Mail           = '';
	 private $Address        = '';
	 private $Phone          = '';
	 private $Mobile         = '';
	 private $Number_ID      = '';
	 private $Nationality_ID = 0 ;
	 private $User_Name      = '';
	 private $Password       = '';
	 private $specialization = '';
	 private $BirhtDate      = '';
	 private $JobNow         = '';
	 private $TeacherLevel   = '';
	 private $TeacherDegree  = '';
	 private $Salary         = '';
	 private $ServiceStart   = '';
	 private $EmpType        = '';
	 private $ContractType   = '' ;
     private $ContractDate   = '';
	 private $note 			 = '';
     private $Date           = '' ;
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
	//show_teacher
	public function show_teacher($Lang)
	{
		$idContact = (int)$this->session->userdata('id');
		$data['SchoolID']             = (int)$this->session->userdata('SchoolID');
		$Where  = array('student.Contact_ID'=>$idContact,'base_class_table.IsActive'=>1,'contact.SchoolID'=>$data['SchoolID']);
		$this->db->select('contact.Name,contact.ID');
		$this->db->from('student');
		$this->db->join('class_table','class_table.ClassID = student.Class_ID and class_table.RowLevelID=student.R_L_ID');
		$this->db->join('base_class_table','base_class_table.ID = class_table.BaseTableID');
		$this->db->join('contact','class_table.EmpID = contact.ID');
		$this->db->group_by('contact.ID');
		$this->db->where($Where);
		$Result = $this->db->get();	
		if($Result->num_rows()>0)
		{		
			$ReturnResult = $Result->result() ;
			return $ReturnResult ;  
		}else{
			return 0 ;  
		}
	}
	//show_administration
	public function show_administration($Lang)
	{$data['SchoolID']             = (int)$this->session->userdata('SchoolID');
        $JobTitleName = 'Name_Ar';
		if($Lang == 'english'){$JobTitleName = 'Name_En' ; }
		$query = $this->db->query("
		 SELECT
		 contact.ID ,
		 contact.Name ,
		 job_title.".$JobTitleName." AS JobTitle
		 FROM
		 contact
		 INNER JOIN employee ON contact.ID = employee.Contact_ID
		 INNER JOIN job_title ON employee.jobTitleID = job_title.ID
where contact.SchoolID = '".$data['SchoolID']."'
		")->result();
		if(sizeof($query)>0){return $query ;}else{return 0; }
	}
	//show_student
	public function show_student($Lang)
	{
		$data['SchoolID']             = (int)$this->session->userdata('SchoolID');
		$idContact = (int)$this->session->userdata('id');
		$Where  = array('Contact_ID'=>$idContact);
		$this->db->select('Class_ID,R_L_ID');
		$this->db->from('student');
		$this->db->where($Where);
		$Result = $this->db->get();
	    

		if($Result->num_rows()>0)
		{			
			$ReturnResult = $Result->row_array() ;
		
				$Result = $this->db->query(" 


select CONCAT(s.Name,' ',f.Name) as Name ,s.ID FROM student INNER JOIN contact as s on student.Contact_ID = s.ID  INNER JOIN contact as f on student.Father_ID = f.ID where student.Class_ID = '".$ReturnResult['Class_ID']."' AND student.R_L_ID = '".$ReturnResult['R_L_ID']."' and s.SchoolID = '".$data['SchoolID']."' AND student.Contact_ID != '".$idContact."'

");
 			if($Result->num_rows()>0)
			{	
			$ReturnResult = $Result->result() ;
				return $ReturnResult ;  
			}else{
				return 0 ;  
			}		
		}else{
		    
			return 0 ;  
		}
	}
	//send_message
	public function send_message($data = array())
	{
		
		 $idContact = (int)$this->session->userdata('id'); 
		 extract($data);
		 $this->db->escape_str($txt_title);
		 $this->db->escape_str($txt_content);
		 
		 		 $chk_level = $Select;
								 $DataInsert = array
								 ( 
								  'contactID'         =>','.$chk_level.',' ,
								  'Token'             =>$this->get_token()
								);
								if($this->db->insert('message_contact', $DataInsert))
								{
									
								 $to_array = $this->db->insert_id();
								 
		$data['SchoolID']             = (int)$this->session->userdata('SchoolID');		
								 $DataInsert = array
								 ( 
								  'SchoolID'          =>$data['SchoolID']  ,
								  'ParentID'          =>0 ,
								  'fromID'            =>$idContact, 
								  'toID'              =>$to_array,
								  'title'             =>$txt_title, 
								  'message'           =>$txt_content, 
								  'attach'            =>$hidImg, 
								  'token'             =>$this->get_token() 
								);
								if($this->db->insert('message', $DataInsert))
											{
												return true ; 
											}else{
												return false ; 
												}
											}else{
												return false ; 
												}
	}
	//send_replay
	public function send_replay($data = array())
	{
		 $idContact = (int)$this->session->userdata('id'); 
		 extract($data);
		 $this->db->escape_str($txt_title);
		 $this->db->escape_str($txt_content);
		 $data['SchoolID']             = (int)$this->session->userdata('SchoolID');		
		 $DataInsert = array ( 
                			    'SchoolID'          =>$data['SchoolID']  ,
                				'ParentID'          =>$txt_id_message ,
                			    'fromID'            =>$idContact, 
                			    'toID'              =>$txt_to_id,
                				'title'             =>$txt_title, 
                				'message'           =>$txt_content, 
                				'token'             =>$this->get_token()
                			);
			if($this->db->insert('message', $DataInsert))
				{
				    $this->updateOpenMessage($txt_id_message);
					return true ; 
				}else{	return false ; }
	}
	//send_replay_incoming
	public function send_replay_incoming($data = array())
	{
		 $idContact = (int)$this->session->userdata('id'); 
		 extract($data);
		$Where  = ('contactID = "'.$txt_to_id.'" ');
		$this->db->select('ID');
		$this->db->from('message_contact');
		$this->db->where($Where);
		$Result = $this->db->get();	
		if($Result->num_rows()>0)
		{			
			$message_contact = $Result->row_array() ;
			$to_array =$message_contact['ID'];
		}else{
			$DataInsert = array( 
								  'contactID'         =>$txt_to_id,
								  'Token'             =>$this->get_token()
								);
			$this->db->insert('message_contact', $DataInsert);
			$to_array = $this->db->insert_id();	
		}
			 
		if($to_array!=0)
		{	
		 $this->db->escape_str($txt_title);
		 $this->db->escape_str($txt_content);
		 
		$data['SchoolID']             = (int)$this->session->userdata('SchoolID');		
		$DataInsert = array ( 
								    'SchoolID'          =>$data['SchoolID']  ,
                    				'ParentID'          =>$txt_id_message ,
                    			    'fromID'            =>$idContact, 
                    			    'toID'              =>$to_array,
                    				'title'             =>$txt_title, 
                    				'message'           =>$txt_content, 
                    				'token'             =>$this->get_token()
                    			);
			if($this->db->insert('message', $DataInsert))
				{
				    $this->updateOpenMessage($txt_id_message);
					return true ; 
					}else{ 	return false ;  	}
		}else{return false ; 	}
	}

	//show_sent_message
	public function show_sent_message($Lang)
	{
		$idContact = (int)$this->session->userdata('id');
		$data['SchoolID']             = (int)$this->session->userdata('SchoolID');
		$Where  = array('message.fromID'=>$idContact,'message.isactive'=>1,'message.ParentID'=>0);
		$this->db->select('message.isopen,message.fromID,message.toID,message.title,message.message,message.attach,message.ID as message_ID,message.Date,contact.Name as toID_name');
		$this->db->from('message');
		$this->db->join('message_contact','message_contact.ID = message.toID');
		$this->db->join('contact','contact.ID = message_contact.contactID and  message.SchoolID = "'.$data['SchoolID'].'"');
		$this->db->order_by('message.isopen','DESC');
		$this->db->order_by('message.Date','DESC');
		$this->db->where($Where);
		$Result = $this->db->get();	
		if($Result->num_rows()>0)
		{			
			$ReturnResult = $Result->result() ;
			return $ReturnResult ;  
		}else{
			return 0 ;  
		}
	}
		public function count_new_messages($Lang)
	{

		$idContact = (int)$this->session->userdata('id');  
		 
		$Where  = ('messages.read =0 ' );
		$this->db->select('messages.id');
		$this->db->from('messages');
		$this->db->join('conversation','conversation.ID = messages.conversation_id and conversation.to_user= "'.$idContact.'"');
	/*	$this->db->join('contact','contact.ID = message.fromID and  message.SchoolID = "'.$data['SchoolID'].'"');
		$this->db->order_by('message.isopen','DESC');
		$this->db->order_by('message.Date','DESC');
		$this->db->group_by('message.ID','DESC');*/
		$this->db->where($Where);
		$Result = $this->db->get();	 
		if($Result->num_rows()>0)
		{		//	echo $Result->num_rows() ;  die;
		//	$ReturnResult = $Result->result() ; 
			return $Result->num_rows() ;  
		 
		}else{ 
			return 0 ;  
		}
	}
	//show_incoming_messages_new
	public function show_incoming_messages_new($Lang)
	{

		$idContact = (int)$this->session->userdata('id');  
		$message_parent=array();
		$message_new=array();
		$this->db->select('messageID,message_newID');
		$this->db->from('message_parent');
		$this->db->where('contactID',$idContact );
		$Result = $this->db->get();	
		if($Result->num_rows()>0)
		{
			$message_p = $Result->result() ;
			foreach($message_p as $key=>$item_p){
				$message_parent[$key]=$item_p->messageID;
				$message_new[$key]=$item_p->message_newID;
				}
			}
		
		
			
		$data['SchoolID']             = (int)$this->session->userdata('SchoolID');
		$Where  = ('message.isactive =1 and message.ParentID =0  and message_contact.contactID LIKE "%,'.$idContact.',%"   ' );
		$this->db->select('message.isopen,message.fromID,message.toID,message.title,message.message,message.attach,message.ID as message_ID,message.Date,contact.Name as fromID_name');
		$this->db->from('message');
		$this->db->join('message_contact','message_contact.ID = message.toID');
		$this->db->join('contact','contact.ID = message.fromID and  message.SchoolID = "'.$data['SchoolID'].'"');
		$this->db->order_by('message.isopen','DESC');
		$this->db->order_by('message.Date','DESC');
		$this->db->group_by('message.ID','DESC');
		$this->db->where($Where);
		$Result = $this->db->get();	 
		if($Result->num_rows()>0)
		{			
					
			$ReturnResult = $Result->result() ;
			foreach($ReturnResult as $key=>$item){
				if(!in_array($item->message_ID,$message_parent)&&!in_array($item->message_ID,$message_new)){
					if($key==0){
			$Where  = ('contactID = "'.$idContact.'" ');
		$this->db->select('ID');
		$this->db->from('message_contact');
		$this->db->where($Where);
		 $this->db->limit(1);
		$Result = $this->db->get();	
		if($Result->num_rows()>0)
		{			
					
			$message_contact = $Result->row_array() ;
			$to_array =$message_contact['ID'];
		}else{
			$DataInsert = array
								 ( 
								  'contactID'         =>$idContact,
								  'Token'             =>$this->get_token()
								);
			$this->db->insert('message_contact', $DataInsert);
			
			$to_array = $this->db->insert_id();	
		}
			}
				
		$data['SchoolID']             = (int)$this->session->userdata('SchoolID');		
								 $DataInsert = array
								 ( 
								  'SchoolID'          =>$data['SchoolID']  ,
									  'ParentID'          =>0 ,
									  'fromID'            =>$item->fromID, 
									  'toID'              =>$to_array,
									  'title'             =>$item->title, 
									  'message'           =>$item->message, 
									  'attach'            =>$item->attach,
									  'token'             =>$this->get_token()  
									);
				$this->db->insert('message', $DataInsert);
				$messageID_new_insert = $this->db->insert_id();	
			$DataInsert = array
								 ( 
								  'messageID'         =>$item->message_ID,
								  'message_newID'         =>$messageID_new_insert,
								  'contactID'         =>$idContact,
								);
			$this->db->insert('message_parent', $DataInsert);
			}
			}
		}
		
		////////////////////////////
		
		////////////////////////////
			
			
		$data['SchoolID']             = (int)$this->session->userdata('SchoolID');
		$Where  = ('message_contact.contactID = "'.$idContact.'" and message.isactive = 1 and message.isopen = 0');
		$this->db->select('message.isopen,message.fromID,message.toID,message.title,message.message,message.attach,message.ID as message_ID,message.Date,contact.Name as fromID_name');
		$this->db->from('message');
		$this->db->join('message_contact','message_contact.ID = message.toID');
		$this->db->join('message_parent','message.ID = message_parent.message_newID');
		$this->db->join('contact','contact.ID = message.fromID  and  message.SchoolID = "'.$data['SchoolID'].'"');
		$this->db->order_by('message.isopen','DESC');
		$this->db->order_by('message.Date','DESC');
		$this->db->where($Where);
		$Result = $this->db->get(); 
		if($Result->num_rows()>0)
		{			
			$ReturnResult = $Result->result() ;
			return $ReturnResult ;  
		}else{
			return 0 ;  
		}
	 
	}
	//show_incoming_messages
	public function show_incoming_messages($Lang)
	{
		$idContact = (int)$this->session->userdata('id');
		$data['SchoolID']             = (int)$this->session->userdata('SchoolID'); 
		$message_parent=array();
		$message_new=array();
		$this->db->select('messageID,message_newID');
		$this->db->from('message_parent');
		$this->db->where('contactID',$idContact );
		$Result = $this->db->get();	
		if($Result->num_rows()>0)
		{
			$message_p = $Result->result() ;
			foreach($message_p as $key=>$item_p){
				$message_parent[$key]=$item_p->messageID;
				$message_new[$key]=$item_p->message_newID;
				}
			}
		
		
		
		
		$data['SchoolID']             = (int)$this->session->userdata('SchoolID');	
		$Where  = ('message.isactive =1 and message.ParentID =0 and message_contact.contactID LIKE "%,'.$idContact.',%" ');
		$this->db->select('message.isopen,message.fromID,message.toID,message.title,message.message,message.attach,message.ID as message_ID,message.Date,contact.Name as fromID_name');
		$this->db->from('message');
		$this->db->join('message_contact','message_contact.ID = message.toID');
		$this->db->join('contact','contact.ID = message.fromID and  message.SchoolID = "'.$data['SchoolID'].'"');
		$this->db->order_by('message.isopen','DESC');
		$this->db->order_by('message.Date','DESC');
		$this->db->group_by('message.ID','DESC');
		$this->db->where($Where);
		$Result = $this->db->get();	
		if($Result->num_rows()>0)
		{			
					
			$ReturnResult = $Result->result() ;
			foreach($ReturnResult as $key=>$item){
				if(!in_array($item->message_ID,$message_parent)&&!in_array($item->message_ID,$message_new)){
					if($key==0){
			$Where  = ('contactID = "'.$idContact.'" ');
		$this->db->select('ID');
		$this->db->from('message_contact');
		$this->db->where($Where);
		$Result = $this->db->get();	
		if($Result->num_rows()>0)
		{			
					
			$message_contact = $Result->row_array() ;
			$to_array =$message_contact->ID;
		}else{
			$DataInsert = array
								 ( 
								  'contactID'         =>$idContact,
								  'Token'             =>$this->get_token()
								);
			$this->db->insert('message_contact', $DataInsert);
			
			$to_array = $this->db->insert_id();	
		}
			}
				
		$data['SchoolID']             = (int)$this->session->userdata('SchoolID');		
								 $DataInsert = array
								 ( 
								  'SchoolID'          =>$data['SchoolID']  , 
									  'ParentID'          =>0 ,
									  'fromID'            =>$item->fromID, 
									  'toID'              =>$to_array,
									  'title'             =>$item->title, 
									  'message'           =>$item->message, 
									  'attach'            =>$item->attach,
									  'token'             =>$this->get_token()  
									);
				$this->db->insert('message', $DataInsert);
				$messageID_new_insert = $this->db->insert_id();	
			$DataInsert = array
								 ( 
								  'messageID'         =>$item->message_ID,
								  'message_newID'         =>$messageID_new_insert,
								  'contactID'         =>$idContact,
								);
			$this->db->insert('message_parent', $DataInsert);
			}
			}
		}
		
		////////////////////////////
			
		
		$data['SchoolID']             = (int)$this->session->userdata('SchoolID');	
		$Where  = ('message_contact.contactID = "'.$idContact.'"     and message.isactive =1 and message.ParentID =0');
		$this->db->select('message.isopen,message.fromID,message.toID,message.title,message.message,message.attach,message.ID as message_ID,message.Date,contact.Name as fromID_name');
		$this->db->from('message');
		$this->db->join('message_contact','message_contact.ID = message.toID');
		$this->db->join('message_parent','message.ID = message_parent.message_newID');
		$this->db->join('contact','contact.ID = message.fromID and  message.SchoolID = "'.$data['SchoolID'].'"');
		$this->db->order_by('message.isopen','DESC');
		$this->db->order_by('message.Date','DESC');
		$this->db->where($Where);
		$Result = $this->db->get();	
		if($Result->num_rows()>0)
		{			
			$ReturnResult = $Result->result() ;
			return $ReturnResult ;  
		 
		}else{
			return 0 ;  
		}
	}	
	public function updateOpenMessage($ID){
	    $Where  = array('ID'=>$ID );
	    $this->db->select('ParentID');
		$this->db->from('message'); 
		$this->db->where($Where);
		$Result = $this->db->get();	
		if($Result->num_rows()>0)
		{			
			$ReturnResult = $Result->row_array() ;
    	    $DataInsert = array( 
            			    'isopen'          =>0 
    			);
    		$this->db->where('ID', $ID);
    		if($this->db->update('message', $DataInsert))
    				{
    				    if($ReturnResult['ParentID']!=0){
    				    updateOpenMessage($ReturnResult['ParentID']);
    				    }else{return true ; }
    			    }else{return false ; } 
		}else{return false;}
	}
	//get_child
	public function get_child($parent_id)
	{
		$data['SchoolID']             = (int)$this->session->userdata('SchoolID');	
		$Where  = array('message.isactive'=>1,'message.ParentID'=>$parent_id);
		$this->db->select('message.fromID,message.toID,message.title,message.message,message.attach,message.ID as message_ID,message.Date,contact.Name as toID_name');
		$this->db->from('message');
		$this->db->join('message_contact','message_contact.ID = message.toID');
		$this->db->join('contact','contact.ID = message_contact.contactID and  message.SchoolID = "'.$data['SchoolID'].'"');
		$this->db->where($Where);
		$Result = $this->db->get();	
		if($Result->num_rows()>0)
		{			
			$ReturnResult = $Result->result() ;
			return $ReturnResult ;  
		}else{
			return 0 ;  
		}
	}
	//get_child_incoming
	public function get_child_incoming($parent_id)
	{
		$data['SchoolID']             = (int)$this->session->userdata('SchoolID');	
		$Where  = array('message.isactive'=>1,'message.ParentID'=>$parent_id);
		$this->db->select('message.fromID,message.toID,message.title,message.message,message.attach,message.ID as message_ID,message.Date,contact.Name as fromID_name');
		$this->db->from('message');
		$this->db->join('message_contact','message_contact.ID = message.toID');
		$this->db->join('contact','contact.ID = message.fromID and  message.SchoolID = "'.$data['SchoolID'].'"');
		$this->db->where($Where);
		$Result = $this->db->get();	
		if($Result->num_rows()>0)
		{			
			$ReturnResult = $Result->result() ;
			return $ReturnResult ;  
		}else{
			return 0 ;  
		}
	}
	
	//update_root
	public function update_root($root_id,$txt_id_message)
	{
		
		$idContact = (int)$this->session->userdata('id');
		$Where  = array('message.ID'=>$txt_id_message,'message.fromID'=>$idContact);
		$this->db->select('message.ID');
		$this->db->from('message');
		$this->db->where($Where);
		$Result = $this->db->get();	
		if($Result->num_rows()>0)
		{return true ;  
		}else{
		$DataInsert = array
					 ( 
						 'isopen'         =>1
					);
		$this->db->where('ID', $root_id);
				if($this->db->update('message', $DataInsert))
				{
						return true ;  
				}else{
					return 0 ;  
				}
			
		}
		
	}
 }
?>