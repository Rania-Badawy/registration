<?php
class Report_Model extends CI_Model{

	function __construct()
    {
	   parent::__construct();
	   $this->Date       = date('Y-m-d H:i:s');
    }
    ////////////////////
    public function get_student_father_login($Lang = NULL , $LevelID = 0 , $RowLevelID = 0  , $ClassID = 0 ,$datefrom, $dateto ,$Student )
	{
		if($LevelID == 0 )   {$LevelID = 'NULL' ; }
		if($RowLevelID == 0 ){$RowLevelID = 'NULL' ; }
		if($ClassID == 0 )   {$ClassID = 'NULL' ; }
		$NameArray = array("Level"=>"Name AS LevelName" ,"row"=>"Name AS RowName" , "class"=>"Name AS ClassName");
		if($Lang == "english")
		{
			$NameArray = array("Level"=>"Name_en AS LevelName" ,"row"=>" Name_en AS RowName" , "class"=>"Name_en AS ClassName");
		}
		$query = $this->db->query("SELECT DISTINCT tb2.ID AS FatherID,tb2.Token AS FatherToken ,tb2.Name  AS FatherName ,tb2.User_Name  AS FathertUserName ,
		     tb2.Mobile	AS FathertMobile,tb2.Mail  AS FatherMail
			 FROM sessionToken
			 INNER JOIN student          ON sessionToken.UserID              = student.Contact_ID
			 INNER JOIN contact AS tb2   ON student.Father_ID   = tb2.ID
			 INNER JOIN class            ON student.Class_ID    = class.ID
			 INNER JOIN row_level        ON student.R_L_ID      = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID    = row.ID
			 INNER JOIN level            ON row_level.Level_ID  = level.ID
			 WHERE tb2.SchoolID = '".$this->session->userdata('SchoolID')."'AND  level.ID = IFNULL($LevelID,level.ID)AND row_level.ID =IFNULL($RowLevelID,row_level.ID)
			 AND class.ID = IFNULL($ClassID,class.ID) AND tb2.Type='F'AND tb2.ID IN(".$Student.")AND DATE(sessionToken.Date) between '$datefrom' AND '$dateto'
			 AND tb2.Isactive=1
			 ORDER BY tb2.Name
			");
			if($query->num_rows()>0)
			{
			   return $query->result();	
			}else{return false ;}
	}
	////////////////////
    public function evaluationSupervisor($data)
	{
		extract($data);
		if($ApiDbname=="SchoolAccTabuk"){
			$where ="contact.ID IN(59857,59905,59986,50938,59983)";
		}else{
			$where ="(contact.Type='U' OR (contact.Type='E' AND contact.GroupID!=0))";
		}
		$query = $this->db->query("select contact.ID,contact.Name from contact 
		where contact.Isactive =1 
		AND $where
		");
			if($query->num_rows()>0)
			{
			   return $query->result();	
			}else{return false ;}
	}
	////////////////////
    public function login($data)
	{
		extract($data);
		$query = $this->db->query("select count(sessionToken.ID) AS login from contact 
		INNER JOIN  sessionToken ON contact.ID=sessionToken.UserID
		where contact.Isactive =1 
		AND  DATE(sessionToken.Date) between '$Date_from' AND '$Date_to'
		AND contact.ID=$user
		");
			if($query->num_rows()>0)
			{
			   return $query->row_array()['login'];	
			}else{return false ;}
	}
	////////////////////
    public function messagesRecieved($data)
	{
		extract($data);
		$query = $this->db->query('SELECT COUNT(*) AS messagesRecieve
                FROM conversation
                JOIN messages ON messages.conversation_id = conversation.id  
                WHERE  messages.created_at BETWEEN "' . $Date_from . ' 00:00:00" AND "' . $Date_to . ' 23:59:59" 
                AND messages.is_deleted = 0 and conversation.to_user='.$user.'
				 and conversation.cat=0
                ');
			if($query->num_rows()>0)
			{
			   return $query->row_array()['messagesRecieve'];	
			}else{return false ;}
	}
	////////////////////
    public function messagesOut($data)
	{
		extract($data);
		$query = $this->db->query('SELECT COUNT(*) AS messagesOut
                FROM conversation
                JOIN messages ON messages.conversation_id = conversation.id 
                WHERE  messages.created_at BETWEEN "' . $Date_from . ' 00:00:00" AND "' . $Date_to . ' 23:59:59" 
                AND messages.is_deleted = 0 and conversation.from_user='.$user.'
				 and conversation.cat=0
                ');
			if($query->num_rows()>0)
			{
			   return $query->row_array()['messagesOut'];	
			}else{return false ;}
	}
	////////////////////
    public function messagesRecievedChat($data)
	{
		extract($data);
		$query = $this->db->query('SELECT COUNT(distinct(messages.chat_id)) AS messagesRecieve
                FROM conversation
                JOIN messages ON messages.conversation_id = conversation.id  
                WHERE  messages.created_at BETWEEN "' . $Date_from . ' 00:00:00" AND "' . $Date_to . ' 23:59:59" 
                AND messages.is_deleted = 0 and conversation.to_user='.$user.'
				and conversation.cat=0
				AND conversation.id  in(select min(conversation.id) as id from conversation   group by conversation.chat_id )
                ');
			if($query->num_rows()>0)
			{
			   return $query->row_array()['messagesRecieve'];	
			}else{return false ;}
	}
	////////////////////
    public function messagesOutChat($data)
	{
		extract($data);
		$query = $this->db->query('SELECT COUNT(distinct(messages.chat_id)) AS messagesOut
                FROM conversation
                JOIN messages ON messages.conversation_id = conversation.id  
                WHERE  messages.created_at BETWEEN "' . $Date_from . ' 00:00:00" AND "' . $Date_to . ' 23:59:59" 
                AND messages.is_deleted = 0 and conversation.from_user='.$user.'
				 and conversation.cat=0
				AND conversation.id not in(select min(conversation.id) as id from conversation   group by conversation.chat_id )
                ');
			if($query->num_rows()>0)
			{
			   return $query->row_array()['messagesOut'];	
			}else{return false ;}
	}
	////////////////////
    public function evaluation($data)
	{
		extract($data);
		$query = $this->db->query("SELECT emp_evaluation.ID
		FROM emp_evaluation
		INNER JOIN contact ON  emp_evaluation.ContactID = contact.ID 
		INNER JOIN contact As contactEmp ON emp_evaluation.EmpID        = contactEmp.ID
		WHERE contact.Isactive = 1 AND emp_evaluation.date between '$Date_from' AND '$Date_to'
		AND emp_evaluation.ContactID=$user and contactEmp.Isactive = 1 AND contactEmp.Type='E' AND emp_evaluation.semesterID>0 
		group by emp_evaluation.EmpID,emp_evaluation.date
                ");
			if($query->num_rows()>0)
			{
			   return $query->num_rows();	
			}else{return false ;}
	}
	////////////////////
    public function evaluationEmp($data)
	{
		extract($data);
		$query = $this->db->query("SELECT COUNT(distinct(emp_evaluation.EmpID)) AS total
		FROM emp_evaluation
		INNER JOIN contact ON  emp_evaluation.ContactID = contact.ID 
		INNER JOIN contact As contactEmp ON emp_evaluation.EmpID        = contactEmp.ID
		WHERE contact.Isactive = 1 AND emp_evaluation.date between '$Date_from' AND '$Date_to'
		AND emp_evaluation.ContactID=$user and contactEmp.Isactive = 1 AND contactEmp.Type='E' AND emp_evaluation.semesterID>0 
                ");
			if($query->num_rows()>0)
			{
			   return $query->row_array()['total'];	
			}else{return false ;}
	}
	////////////////////
    public function attendance($data)
	{
		extract($data);
		$query = $this->db->query("	SELECT COUNT(DISTINCT students_evaluation.Date) AS attendance 
		FROM students_evaluation 
		INNER JOIN contact 	ON students_evaluation.StudentID = contact.ID
		where
		contact.Isactive = 1 
	    AND students_evaluation.Date between '$Date_from' AND '$Date_to'
		AND IsDeleted    = 0
		AND `ClassTableID` IS NULL
		AND students_evaluation.TeacherID=$user
                ");
			if($query->num_rows()>0)
			{
			   return $query->row_array()['attendance'];	
			}else{return false ;}
	}
}