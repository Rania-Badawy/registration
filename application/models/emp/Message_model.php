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
		$Where  = array('contact.Type'=>'E','contact.SchoolID' =>$data['SchoolID'],'contact.ID != ' =>$idContact );
		$this->db->select('contact.Name,contact.ID');
		$this->db->from('contact');
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
	///get student class
	public function getColumns_class($item)
	{
		$data['SchoolID']             = (int)$this->session->userdata('SchoolID');
		     		$this->db->join('student','student.R_L_ID= row_level.ID and student.Class_ID=class.ID');
		$Result = $this->db->query("SELECT GROUP_CONCAT(contact.ID SEPARATOR ',') as ColumnsIDs FROM class_table  
		                            inner join student  on  student.R_L_ID= class_table.RowLevelID and student.Class_ID=class_table.ClassID
		                            inner join contact  on   contact.ID = student.Contact_ID
		                            WHERE contact.SchoolID ='".$data['SchoolID']."' and contact.Isactive= 1  and class_table.ID= '".$item."' 
		                            ");
	    
		if($Result->num_rows()>0)
		{			
			$ReturnResult = $Result->row_array() ;
			return $ReturnResult['ColumnsIDs'] ;  
		}else{
			return false;  
		}
	    
	}
	//send_message_class
	public function send_message_class($data = array())
	{
		 $idContact = (int)$this->session->userdata('id'); 
         $data['SchoolID']             = (int)$this->session->userdata('SchoolID');
		 extract($data);
		 ////////////////////start get contact array///////////////////////
	    $columnsIDArray = ''; 
	    if(is_array($Select)){
	        foreach($Select as $key=>$item){ 
	            $columns = $this->getColumns_class($item); 
	            if($columns!=false){$columnsIDArray =$columnsIDArray.$columns;}
	        }
	    }else if($Select!=0){
	            $columns = $this->getColumns_class($Select);
	            if($columns!=false){$columnsIDArray =$columnsIDArray.$columns;}
	    }else{
	        return false;
	    }
 		 
	    ////////////////////end get contact array///////////////////////
		 $this->db->escape_str($txt_title);
		 $this->db->escape_str($txt_content);
		 $chk_level = ','.$columnsIDArray.',';
				 
								 $DataInsert = array
								 ( 
								  'contactID'         =>$chk_level ,
								  'Token'             =>$this->get_token()
								);
								if($this->db->insert('message_contact', $DataInsert))
											{
											 	$to_array = $this->db->insert_id();	
											}else{
												return false ; 
												}
												
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
	}
	public function show_class($Lang)
	{
		            $idContact = (int)$this->session->userdata('id');

		        	$data['SchoolID']             = (int)$this->session->userdata('SchoolID');
            		$Where  = array('row_level.IsActive'=>1,'row.Is_Active'=>1,'level.Is_Active'=>1,'base_class_table.IsActive'=>1,'class_table.EmpID'=>$idContact);
            		$LangArray = array("Name"=>"Name");
            		if((string)$Lang ==='english'){ $LangArray = array("Name"=>"Name_en"); }
            		$this->db->select("class_table.ID AS ClassID ,level.".$LangArray['Name']." AS level,row.".$LangArray['Name']." AS row,class.".$LangArray['Name']." AS className ");
                    $this->db->where($Where);
					$this->db->from('row_level');
		     		$this->db->join('level','level.ID = row_level.Level_ID');
		     		$this->db->join('row','row.ID = row_level.Row_ID');
		     		$this->db->join('class_table','class_table.RowLevelID = row_level.ID');
		     		$this->db->join('class','class_table.ClassID = class.ID');
		     		$this->db->join('base_class_table','base_class_table.ID = class_table.BaseTableID');
		     		$this->db->join('student','student.R_L_ID= row_level.ID and student.Class_ID=class.ID');
					$this->db->where("class_table.SchoolID", $data['SchoolID'] ); 
					$this->db->order_by("row_level.ID", "desc"); 
					$this->db->group_by("class_table.ClassID , class_table.RowLevelID"); 
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
	{
		$data['SchoolID']             = (int)$this->session->userdata('SchoolID');
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
		if(sizeof($query)>0){return $query ;}else{return false ; }

	}
	//show_student
	public function show_student($Lang)
	{
	    $data['SchoolID']             = (int)$this->session->userdata('SchoolID');
		$idContact = (int)$this->session->userdata('id');
		$Result = $this->db->query("select CONCAT(s.Name,' ',f.Name) as Name ,s.ID from class_table 
		                           JOIN  base_class_table on class_table.BaseTableID = base_class_table.ID 
		                           JOIN student on student.Class_ID = class_table.ClassID AND student.R_L_ID = class_table.RowLevelID 
		                           JOIN contact as s on student.Contact_ID = s.ID  
		                           JOIN contact as f on student.Father_ID = f.ID 
		                           where  class_table.EmpID ='".$idContact."' and base_class_table.IsActive =1 and s.SchoolID ='".$data['SchoolID']."' group by s.ID");
		if($Result->num_rows() >0)
		{return $Result->result();}else{return FALSE ;}
	}
	//show_parents
	public function show_parents($Lang)
	{
	     $data['SchoolID']             = (int)$this->session->userdata('SchoolID');
		$idContact = (int)$this->session->userdata('id');
		$Result = $this->db->query("select (f.Name) as Name ,f.ID from class_table 
		                           JOIN  base_class_table on class_table.BaseTableID = base_class_table.ID 
		                           JOIN student on student.Class_ID = class_table.ClassID AND student.R_L_ID = class_table.RowLevelID 
		                           JOIN contact as s on student.Contact_ID = s.ID  
		                           JOIN contact as f on student.Father_ID = f.ID 
		                           where  class_table.EmpID ='".$idContact."' and base_class_table.IsActive =1 and s.SchoolID ='".$data['SchoolID']."' group by f.ID");
		if($Result->num_rows() >0)
		{return $Result->result();}else{return FALSE ;}
	}
	//send_message
	public function send_message($data = array())
	{
		
		 $idContact = (int)$this->session->userdata('id'); 
		 extract($data);
		 $this->db->escape_str($txt_title);
		 $this->db->escape_str($txt_content);
		 
		 		 $chk_level = ','.implode(',',$Select).','; 
		 		 
								 $DataInsert = array
								 ( 
								  'contactID'         => $chk_level  ,
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
					}else{
						return false ; 
					}
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
								 $DataInsert = array
								 ( 
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
                    				}else{	return false ; 	}
         }else{	return false ; 	}
	}

	public function get_nested_message($messageID)
	{
		$idContact = (int)$this->session->userdata('id'); 
		$Where  = array('message_parent.messageID'=>(int)$messageID);
		$this->db->select('message.ID as message_id,message.title,message.message,message.attach,message.Date,message.isopen,message.toID,message.isactive,message_contact.contactID,message_contact.typeID,message_contact.levelID,message_contact.rowLevelID,message_contact.classID,message_contact.ID as message_contact');
		$this->db->where($Where);
		$this->db->from('message');
		$this->db->join('message_contact','message.toID = message_contact.ID');
		$this->db->join('message_parent','message_parent.message_newID= message.ID');
		$Result = $this->db->get();	
		if($Result->num_rows()>0)
		{			
			$ReturnResult = $Result->result() ;
			return $ReturnResult ;  
		}else{
			return 0 ;  
		}
	}
	
	public function get_class_name($class_id)
	{
		$LangArray = array("Name"=>"Name");
$Lang = $this->session->userdata('language');
		if((string)$Lang ==='english'){ $LangArray = array("Name"=>"Name_en"); }
		$this->db->select("row.".$LangArray['Name']." AS row ,level.".$LangArray['Name']." AS level,class.".$LangArray['Name']." AS class ");
		$Where  = array('class_table.ID'=>$class_id);
		$this->db->where($Where);
		$this->db->from('class_table');
		$this->db->join('base_class_table','base_class_table.ID = class_table.BaseTableID');
		$this->db->join('class','class.ID = class_table.ClassID');
		$this->db->join('row_level','class_table.RowLevelID = row_level.ID');
		$this->db->join('level','level.ID = row_level.Level_ID');
		$this->db->join('row','row.ID = row_level.Row_ID');
		$Result = $this->db->get();	
		if($Result->num_rows()>0)
		{			
			$ReturnResult = $Result->row_array() ;
			return $ReturnResult ;  
		}else{
			return 0 ;  
		}
	}
	public function show_sent_message($Lang)
	{
		$idContact = (int)$this->session->userdata('id'); 
        $data['SchoolID']             = (int)$this->session->userdata('SchoolID');
		$Where  = array('message.fromID'=>$idContact,'message.ParentID'=>0,'message.SchoolID'=>$data['SchoolID'] );
		$this->db->select('message.ID as message_id,message.title,message.message,message.attach,message.Date,message.isopen,message.toID,message.isactive,message_contact.contactID,message_contact.typeID,message_contact.levelID,message_contact.rowLevelID,message_contact.classID,message_contact.ID as message_contact');
		$this->db->where($Where);
		$this->db->from('message');
		$this->db->join('message_contact','message.toID = message_contact.ID');
		//$this->db->join('message_parent','message_parent.messageID= message.ID' );

		//$this->db->join('contact','contact.ID = message_contact.contactID');
		$this->db->order_by("message.Date", "desc"); 
		$Result = $this->db->get();	
 
		if($Result->num_rows()>0)
		{			
			$ReturnResult = $Result->result() ;
			return $ReturnResult ;  
		}else{
			return 0 ;  
		}
	}
	//show_incoming_messages_new
	public function show_incoming_messages_new($Lang)
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
		
		
			
		$Where  = ("message.isactive =1 and message.ParentID =0 and  message.SchoolID = '".$data['SchoolID']."' and  message_contact.contactID LIKE '%,".$idContact.",%' ");
		$this->db->select('message.isopen,message.fromID,message.toID,message.title,message.message,message.attach,message.ID as message_ID,message.Date,contact.Name as fromID_name');
		$this->db->from('message');
		$this->db->join('message_contact','message_contact.ID = message.toID');
		$this->db->join('contact','contact.ID = message.fromID');
		
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
		
$data['SchoolID']             = (int)$this->session->userdata('SchoolID');
		$Where  = ("message_contact.contactID = '".$idContact."'  and message.isactive =1 AND message.isopen=0  AND message.isopen=0 and message.SchoolID = '".$data['SchoolID'] ."' ");
		$this->db->select('message.isopen,message.fromID,message.toID,message.title,message.message,message.attach,message.ID as message_ID,message.Date,contact.Name as fromID_name ,contact.Type ');
		$this->db->from('message');
		$this->db->join('message_contact','message_contact.ID = message.toID');
 		$this->db->join('contact','contact.ID = message.fromID');
		$this->db->join('message_parent','message_parent.message_newID = message.ID');
		
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
		////////////////////////////////
	}
	//show_incoming_messages
	public function show_incoming_messages($Lang)
	{
$data['SchoolID']             = (int)$this->session->userdata('SchoolID');
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
		
		
		
		$Where  = ( 'message.isactive =1 and message.ParentID =0 and message.SchoolID = "'.$data['SchoolID'] .'" and  message_contact.contactID LIKE  "%,'.$idContact.',%"');
		$this->db->select('message.isopen,message.fromID,message.toID,message.title,message.message,message.attach,message.ID as message_ID,message.Date,contact.Name as fromID_name ,message.SchoolID ');
		$this->db->from('message');
		$this->db->join('message_contact','message_contact.ID = message.toID');

		$this->db->join('contact','contact.ID = message.fromID');
		
		$this->db->order_by('message.Date','DESC');
	
		$this->db->group_by('message.ID','DESC');
		$this->db->where($Where);
		$Result = $this->db->get();	   
		if($Result->num_rows()>0)
		{			
					
			$ReturnResult = $Result->result() ;
			foreach($ReturnResult as $key=>$item){
			//eman	if(!in_array($item->message_ID,$message_parent)&&!in_array($item->message_ID,$message_new)){
				if(in_array($item->message_ID,$message_parent)&&in_array($item->message_ID,$message_new)){
					if($key==0){
			$Where  = ('contactID = "'.$idContact.'" ');
		$this->db->select('ID');
		$this->db->from('message_contact');
		$this->db->where($Where);
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
		
	//eman	$Where  = ('message_contact.contactID = "'.$idContact.'"  and message.isactive =1 and message.ParentID =0 and message.SchoolID ="'.$data['SchoolID'].'"    ');
		$Where  = ('message_contact.contactID = "'.$idContact.'"  and message.isactive =1 and message.ParentID =0   ');
		$this->db->select('message.isopen,message.fromID,message.toID,message.title,message.message,message.attach,message.ID as message_ID,message.Date,contact.Name as fromID_name  ,contact.Type ');
		$this->db->from('message');
		$this->db->join('message_contact','message_contact.ID = message.toID');
		$this->db->join('message_parent','message.ID = message_parent.message_newID');
		$this->db->join('contact','contact.ID = message.fromID');
		
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

	public function get_contact_name($contact_id)
	{
			$data['SchoolID']             = (int)$this->session->userdata('SchoolID');
		$Where  = array('ID'=>$contact_id );
		$this->db->select('Name,Type');
		$this->db->where($Where);
		$this->db->from('contact');
		$Result = $this->db->get();	
/*$Result = $query = $this->db->query("SELECT case 
when st.Type = 'S' Then ( select concat_ws( ' ', contact.Name, fa.Name ) from contact   LEFT JOIN student ON contact.ID = student.Contact_ID LEFT JOIN contact AS fa ON fa.ID = student.Father_ID and st.Type='S' )
when st.Type != 'S' Then  st.Name End as Name
FROM contact AS st 
WHERE st.ID ='".$contact_id."' and  st.SchoolID='".$data['SchoolID'] ."'");	*/ 
		if($Result->num_rows()>0)
		{			
			$ReturnResult = $Result->row_array() ; 
 
                        if($ReturnResult['Type']=='S' ){
 
		            $Where  = array('st.ID'=>$contact_id );
		            $this->db->select('concat_ws( " ", st.Name, fa.Name ) as Name');
		            $this->db->where($Where);
		            $this->db->from('contact as st');
		            $this->db->join('student','student.Contact_ID = st.ID');
		            $this->db->join('contact as fa','student.Father_ID  = fa.ID');
		            $Result = $this->db->get();
 
                            if($Result->num_rows()>0)
		               {			
			        $ReturnResult = $Result->row_array() ;	
return $ReturnResult ;  
                               }else{return 0 ;  }
                         }else{ 
			return $ReturnResult ;  
                         } 
		}else{
			return 0 ;  
		}
	}
public function get_ifParent($messageID)
	{
		$idContact = (int)$this->session->userdata('id'); 
		$Where  = array('message_parent.message_newID'=>(int)$messageID);
		$this->db->select('message.ID as message_id,message.title,message.message,message.attach,message.Date,message.isopen,message.toID,message.isactive,message_contact.contactID,message_contact.typeID,message_contact.levelID,message_contact.rowLevelID,message_contact.classID,message_contact.ID as message_contact');
		$this->db->where($Where);
		$this->db->from('message');
		$this->db->join('message_contact','message.toID = message_contact.ID');
		$this->db->join('message_parent','message_parent.message_newID= message.ID');
		$Result = $this->db->get();	
		if($Result->num_rows()>0)
		{			
			$ReturnResult = $Result->result() ;
			return $ReturnResult ;  
		}else{
			return 0 ;  
		}
	}
	//get_child
	public function get_child($parent_id)
	{
$data['SchoolID']             = (int)$this->session->userdata('SchoolID');
		$Where  = array('message.isactive'=>1,'message.ParentID'=>$parent_id ,  'message.SchoolID' =>$data['SchoolID'] );
		$this->db->select('message.fromID,message.toID,message.title,message.message,message.attach,message.ID as message_ID,message.Date,contact.Name as toID_name');
		$this->db->from('message');
		$this->db->join('message_contact','message_contact.ID = message.toID');
		$this->db->join('contact','contact.ID = message_contact.contactID');
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
		$Where  = array('message.isactive'=>1,'message.ParentID'=>$parent_id ,'message.SchoolID' =>$data['SchoolID']  );
		$this->db->select('message.fromID,message.toID,message.title,message.message,message.attach,message.ID as message_ID,message.Date,contact.Name as fromID_name');
		$this->db->from('message');
		$this->db->join('message_contact','message_contact.ID = message.toID');
		$this->db->join('contact','contact.ID = message.fromID');
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
	{$data['SchoolID']             = (int)$this->session->userdata('SchoolID');
		
		$idContact = (int)$this->session->userdata('id');
		$Where  = array('message.ID'=>$txt_id_message,'message.fromID'=>$idContact,'message.SchoolID' =>$data['SchoolID']);
		$this->db->select('message.ID');
		$this->db->from('message');
		$this->db->where($Where);
		$Result = $this->db->get();	
		if($Result->num_rows()>0)
		{
			return true ; 
			
		}else{
		$Where  = array('ID'=>$root_id);
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