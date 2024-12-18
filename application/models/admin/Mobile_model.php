<?php
class Mobile_Model extends CI_Model
{
	private $Token          = '';
	private $Date           = '';
	private $Encryptkey     = '';
	function __construct()
	{
		parent::__construct();
		$this->Date       = date('Y-m-d H:i:s');
		$this->Encryptkey = $this->config->item('encryption_key');
		$this->Token      = $this->get_token();
	}
	/////////////////////
	private function get_token()
	{
		$this->Token            = md5($this->Encryptkey . uniqid(mt_rand()) . microtime());
		return	$this->Token;
	}
	///////////////////////////
	public function send_mail($to, $subject, $message, $attach,$studentReg =null,$newTempDatqa=null)
	{
		$this->load->config('email');
		$this->load->library('email');
		$from = $this->config->item('smtp_user');
		if($studentReg == null){
			$emailTemplate = file_get_contents(base_url('email/email.html')); 
			$emailTemplate = str_replace('{{subject}}', $subject, $emailTemplate);
			$emailTemplate = str_replace('{{message}}', $message, $emailTemplate);
			$emailTemplate = str_replace('{{attach}}', $attach, $emailTemplate);
		}elseif($newTempDatqa['Code']){
		    $emailTemplate = file_get_contents(base_url('email/email.html')); 
    		$emailTemplate = str_replace('{{subject}}', $subject, $emailTemplate);
    		$emailTemplate = str_replace('{{message}}', $message, $emailTemplate);
    		$emailTemplate = str_replace('{{attach}}', $attach, $emailTemplate);
    		$emailTemplate = str_replace('{{logo}}', $newTempDatqa['logo'] ?? $this->getLogo(), $emailTemplate);
		}else{
			$emailTemplate = file_get_contents(base_url('email/email2.html')); 
			$emailTemplate = str_replace('{{subject}}', $subject, $emailTemplate);
			$emailTemplate = str_replace('{{message}}', $message, $emailTemplate);
			$emailTemplate = str_replace('{{attach}}', $attach, $emailTemplate);
			$emailTemplate = str_replace('{{logo}}', $newTempDatqa['logo'] ?? $this->getLogo(), $emailTemplate);
			$emailTemplate = str_replace('{{schoolName}}', $newTempDatqa['schoolName'], $emailTemplate);
			$emailTemplate = str_replace('{{frome}}', $from, $emailTemplate);
			$emailTemplate = str_replace('{{studentName}}', $newTempDatqa['studentName'], $emailTemplate);
			$emailTemplate = str_replace('{{studentID}}', $newTempDatqa['studentID'], $emailTemplate);
			if($newTempDatqa['link']){
				$emailTemplate = str_replace('{{link}}', $newTempDatqa['link'], $emailTemplate);
				$emailTemplate = str_replace('{{linkName}}','رابط تتبع الطلب:',  $emailTemplate);

			}else{
				$emailTemplate = str_replace('{{link}}', '', $emailTemplate);
				$emailTemplate = str_replace('رابط تتبع الطلب:', '', $emailTemplate);
				$emailTemplate = str_replace('{{linkName}}','',  $emailTemplate);
			}
			if($newTempDatqa['rentCode']){
				$emailTemplate = str_replace('{{rentCode}}', $newTempDatqa['rentCode'], $emailTemplate);
				$emailTemplate = str_replace('{{codeName}}','كود تتبع الطلب:', $emailTemplate);
				$emailTemplate = str_replace('{{clickhere}}','اضغط هنا لتتبع الطلب', $emailTemplate);

			}else{
				$emailTemplate = str_replace('{{rentCode}}', '', $emailTemplate);
				$emailTemplate = str_replace('{{codeName}}','', $emailTemplate);
				$emailTemplate = str_replace('{{clickhere}}','', $emailTemplate);
			}
			if($newTempDatqa['Slink']){
				$emailTemplate = str_replace('{{Slink}}', $newTempDatqa['Slink'], $emailTemplate);
				$emailTemplate = str_replace('{{SlinkName}}','بيانات الطالب:',  $emailTemplate);
				$emailTemplate = str_replace('{{Sclickhere}}','رابط الانتقال',  $emailTemplate);
			}else{
				$emailTemplate = str_replace('{{Slink}}', '', $emailTemplate);
				$emailTemplate = str_replace('{{Sclickhere}}','',  $emailTemplate);
				$emailTemplate = str_replace('{{SlinkName}}','',  $emailTemplate);
			}

			if($newTempDatqa['examLink']){
				$emailTemplate = str_replace('{{LoginName}}', ' رابط تسجيل الدخول' , $emailTemplate);
				// $emailTemplate = str_replace('{{LoginLink}}',  $emailTemplate['examLink'], $emailTemplate);
				$emailTemplate = str_replace('{{textLoginLink}}', $newTempDatqa['examLink'], $emailTemplate);
			}else{
				$emailTemplate = str_replace('{{LoginName}}', '', $emailTemplate);
				// $emailTemplate = str_replace('{{LoginLink}}', '', $emailTemplate);
				$emailTemplate = str_replace('{{textLoginLink}}', '', $emailTemplate);
			}

			if($newTempDatqa['userName']){
				$emailTemplate = str_replace('{{userName}}', 'إسم المستخدم', $emailTemplate);
				$emailTemplate = str_replace('{{userNameCode}}',$newTempDatqa['userName'], $emailTemplate);
			}else{
				$emailTemplate = str_replace('{{userName}}', '', $emailTemplate);
				$emailTemplate = str_replace('{{userNameCode}}', '', $emailTemplate);
			}

			if($newTempDatqa['password']){
				$emailTemplate = str_replace('{{password}}', 'كلمة المرور', $emailTemplate);
				$emailTemplate = str_replace('{{passwordCode}}',$newTempDatqa['password'], $emailTemplate);
			}else{
				$emailTemplate = str_replace('{{password}}', '', $emailTemplate);
				$emailTemplate = str_replace('{{passwordCode}}', '', $emailTemplate);
			}
			$emailTemplate = str_replace('{{rowLevelName}}', $newTempDatqa['rowLevelName'], $emailTemplate);

		}
		
		$this->email->set_newline("\r\n");
		$this->email->from($from);
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($emailTemplate);
		$this->email->set_mailtype('html');
		$this->email->attach($attach);
		$this->email->send();
		// if($this->email->send()){
		//     return true ;
		// }else{
		//     print_r($this->email->print_debugger(array('headers')));die;
		// }
	}
	function getLogo() {
		$check_erp = $this->db->query("SELECT Logo FROM setting")->row_array();
		$newTempData['logo'] = base_url() . '/intro/images/school_logo/' . $check_erp['Logo'];
		return $newTempData['logo'];
	}
	
	///////////////////////////
	public function get_user()
	{
		$query = $this->db->query("select msg_user,msg_pass from setting")->row_array();
		return $query;
	}
	/////////////////////////
	public function send_msg($Mobile = 0, $msg = null, $Sender, $token)

	{
		$Mobile = ltrim($Mobile, '0');
		$Mobile = ltrim($Mobile, '966');
		$Mobile = ltrim($Mobile, '+966');

		$sender              = $Sender;

		$Mobile              = '966' . $Mobile;

		$Message             = str_replace('&nbsp;', ' ', $msg);

		$result;

		if (strlen($Mobile) >= 9) {

			$authorization = "Authorization: Bearer " . $token;
			$url = lang("api_sec_link")."/api/" . $this->ApiDbname . "/Sms/send";

			$data = array("message" => $Message, "mobileNumber" => $Mobile, "sender" => $sender);
			$postdata = json_encode($data);
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
			$result = curl_exec($ch);
			$result = json_decode($result, true);
			curl_close($ch);
		}
		return $result;
	}

	/////////////////////////////////////
	public function send_row_msg($RowLevel = array(), $Msg = NULL, $CountMsg = 0, $Sender, $token, $date)
	{
		$RowLevelImplode = implode(',', $RowLevel);

		$father_mobiles_arr = $this->db->query("
	    SELECT CASE WHEN LENGTH(Phone) >= 9 THEN Phone ELSE Mobile END AS mobile_number, ID As contactID 
        FROM
            `contact`
        WHERE ID IN(
            SELECT DISTINCT
                father_id
            FROM
                student
            WHERE  R_L_ID IN (" . $RowLevelImplode . ")    
        )
         AND (LENGTH(Phone) >= 9 OR LENGTH(Mobile) >= 9)
	     AND Isactive = 1
		 AND SchoolID = '" . $this->session->userdata('SchoolID') . "'")->result();


		foreach ($father_mobiles_arr as $key => $item) {
			$Reason =  $this->send_msg($item->mobile_number, $Msg, $Sender, $token);
			$this->db->query("
		   INSERT INTO temp_msg
			(EmpID ,Msg , ContactID , DateInsert , DateSend , Type , FileAttach , CountMsg	 , SchoolID , LevelID , IsSend ,Reason ) 
			VALUES( '" . $this->session->userdata('id') . "' , '" . $Msg . "', '" . $item->contactID . "' , '" . $date . "' , '0000-00-00' , 1 , '' , '" . $CountMsg . "'	 , '" . $this->session->userdata('SchoolID') . "' , '','" . $Reason['status'] . "' ,'" . $Reason['message'] . "')
		   ");
			// $this->send_msg($item->mobile_number  , $Msg,$Sender );
		}
		//  if($Reason=="تم استلام الارقام بنجاح"){
		//      $IsSend = 1;
		//  }
		//  else{
		//      $IsSend = 0;
		//  }



		//   return TRUE ;
	}
	/////////////////////////////////
	public function send_class_msg($Class = array(), $Msg = NULL, $CountMsg = 0, $Sender, $token, $date)
	{
		if (sizeof($Class) <= 0) {
			return FALSE;
		}

		$class_arr = array();
		$row_level_arr = array();
		foreach ($Class as $Key => $Value) {
			$GetClass =   explode('|', $Value);
			array_push($row_level_arr, $GetClass[0]);
			array_push($class_arr, $GetClass[1]);
		}
		$R_L_ID = implode(',', $row_level_arr);
		$Class_ID = implode(',', $class_arr);


		$father_mobiles_arr = $this->db->query("
	    SELECT CASE WHEN LENGTH(Phone) >= 9 THEN Phone ELSE Mobile END AS mobile_number, ID As contactID 
        FROM
            `contact`
        WHERE ID IN(
            SELECT DISTINCT
                father_id
            FROM
                student
            WHERE  R_L_ID IN (" . $R_L_ID . ") AND Class_ID IN (" . $Class_ID . ")   
        )
         AND (LENGTH(Phone) >= 9 OR LENGTH(Mobile) >= 9)
	     AND Isactive = 1
		 AND SchoolID = '" . $this->session->userdata('SchoolID') . "'")->result();


		foreach ($father_mobiles_arr as $key => $item) {
			//$this->send_msg($item->mobile_number  , $Msg ,$Sender);
			$Reason =  $this->send_msg($item->mobile_number, $Msg, $Sender, $token);
			$this->db->query("
	         INSERT INTO temp_msg
			 (EmpID ,Msg , ContactID , DateInsert , DateSend , Type , FileAttach , CountMsg	  , SchoolID , LevelID, IsSend , Reason) 
			 VALUES( '" . $this->session->userdata('id') . "' , '" . $Msg . "', '" . $item->contactID . "' , '" . $date . "' , '0000-00-00' , 1 , '' , '" . $CountMsg . "'	, '" . $this->session->userdata('SchoolID') . "' , '','" . $Reason['status'] . "' ,'" . $Reason['message'] . "')
			");
		}
		//   if($Reason=="تم استلام الارقام بنجاح"){
		//          $IsSend = 1;
		//      }
		//      else{
		//          $IsSend = 0;
		//      }
		// foreach ($Class as $Key => $Value) {
		// 	$GetClass    =   explode('|', $Value);
		// 	$ClassID     =   $GetClass[1];
		// 	$RowLevelID  =   $GetClass[0];
		// 	$this->db->query("
		//      INSERT INTO temp_msg
		// 	 (EmpID ,Msg , ContactID , DateInsert , DateSend , Type , FileAttach , CountMsg	  , SchoolID , LevelID, IsSend , Reason) 
		// 	 SELECT '" . $this->session->userdata('id') . "' , '" . $Msg . "', student.Father_ID , '" . $date . "' , '0000-00-00' , 1 , '' , '" . $CountMsg . "'	, '" . $this->session->userdata('SchoolID') . "' , row_level.Level_ID,'" . $Reason['status'] . "' ,'" . $Reason['message'] . "' FROM student
		// 	 INNER JOIN contact ON student.Contact_ID = contact.ID 
		// 	 INNER JOIN row_level ON student.R_L_ID = row_level.ID 
		// 	 INNER JOIN contact as f ON student.Father_ID = f.ID
		// 	 WHERE contact.Isactive = 1  AND f.Isactive = 1 AND student.R_L_ID = '" . $RowLevelID . "'   AND student.Class_ID	= '" . $ClassID . "' AND contact.SchoolID = '" . $this->session->userdata('SchoolID') . "' 
		// 	");
		// }
		//return TRUE ;

	} /////////////////////////////////
	public function send_father_msg($GetFather = array(), $Msg = NULL, $CountMsg = 0, $Sender, $token, $date)
	{
		$GetFatherImplode = implode(',', $GetFather);

		$father_mobiles_arr = $this->db->query("
	    SELECT CASE WHEN LENGTH(Phone) >= 9 THEN Phone ELSE Mobile END AS mobile_number, ID As contactID 
        FROM
            `contact`
        WHERE ID IN(" . $GetFatherImplode . ")
         AND (LENGTH(Phone) >= 9 OR  LENGTH(Mobile) >= 9)
	     AND Isactive = 1
		 AND SchoolID = '" . $this->session->userdata('SchoolID') . "'")->result();


		foreach ($father_mobiles_arr as $key => $item) {
			$Reason =  $this->send_msg($item->mobile_number, $Msg, $Sender, $token);
			$this->db->query("
	         INSERT INTO temp_msg
			 (EmpID ,Msg , ContactID , DateInsert , DateSend , Type , FileAttach , CountMsg		, SchoolID , IsSend , Reason) 
			 VALUES ('" . $this->session->userdata('id') . "' , '" . $Msg . "', '" . $item->contactID . "' , '" . $date . "' , '0000-00-00' , 1 , '' , '" . $CountMsg . "'	, '" . $this->session->userdata('SchoolID') . "' ,'" . $Reason['status'] . "' ,'" . $Reason['message'] . "'  )  
			");
		}
		// if($Reason=="تم استلام الارقام بنجاح"){
		//          $IsSend = 1;
		//      }
		//      else{
		//          $IsSend = 0;
		//      }
		// $this->db->query("
		//      INSERT INTO temp_msg
		// 	 (EmpID ,Msg , ContactID , DateInsert , DateSend , Type , FileAttach , CountMsg		, SchoolID , IsSend , Reason) 
		// 	 SELECT '" . $this->session->userdata('id') . "' , '" . $Msg . "', ID , '" . $date . "' , '0000-00-00' , 1 , '' , '" . $CountMsg . "'	, '" . $this->session->userdata('SchoolID') . "' ,'" . $Reason['status'] . "' ,'" . $Reason['message'] . "'  FROM contact
		// 	  WHERE ID  IN (" . $GetFatherImplode . ")  
		// 	");

		// return TRUE;

	}
	////////////////////////////////
	public function send_level_msg($LevelID = array(), $Msg = NULL, $CountMsg = 0, $Sender, $token, $date)
	{
		$levels_arr = implode(',', $LevelID);
		$father_mobiles_arr = $this->db->query("
	   
	    SELECT CASE WHEN LENGTH(Phone) >= 9 THEN Phone ELSE Mobile END AS mobile_number, ID As contactID 
        FROM
            `contact`
        WHERE ID IN(
            SELECT DISTINCT
                father_id
            FROM
                student
            INNER JOIN row_level 
            ON student.R_L_ID = row_level.ID AND row_level.Level_ID IN ($levels_arr)
          
        )
         AND (LENGTH(Phone) >= 9 OR  LENGTH(Mobile) >= 9)
	     AND Isactive = 1
		 AND SchoolID = '" . $this->session->userdata('SchoolID') . "'")->result();

		foreach ($father_mobiles_arr as $key => $item) {
			$Reason =  $this->send_msg($item->mobile_number, $Msg, $Sender, $token);
			$this->db->query("
	          INSERT INTO temp_msg
			  (EmpID , Msg , ContactID , DateInsert , DateSend , Type , FileAttach , CountMsg , SchoolID , LevelID , IsSend , Reason) 
			  VALUES( '" . $this->session->userdata('id') . "' , '" . $Msg . "', '" . $item->contactID . "'  , '" . $date . "' , '0000-00-00' , 1 , '' , '" . $CountMsg . "' , '" . $this->session->userdata('SchoolID') . "', '' ,'" . $Reason['status'] . "' ,'" . $Reason['message'] . "' ");
			//   $this->send_msg($item->mobile_number  , $Msg ,$Sender ) ;
		}
		// if($Reason=="تم استلام الارقام بنجاح"){
		//          $IsSend = 1;
		//      }
		//      else{
		//          $IsSend = 0;
		//      }
		// $this->db->query("
		//       INSERT INTO temp_msg
		// 	  (EmpID , Msg , ContactID , DateInsert , DateSend , Type , FileAttach , CountMsg , SchoolID , LevelID , IsSend , Reason) 
		// 	  SELECT '" . $this->session->userdata('id') . "' , '" . $Msg . "', student.Father_ID  , '" . $date . "' , '0000-00-00' , 1 , '' , '" . $CountMsg . "' , '" . $this->session->userdata('SchoolID') . "', row_level.Level_ID ,'" . $Reason['status'] . "' ,'" . $Reason['message'] . "'
		// 	  FROM student
		// 	  INNER JOIN contact ON student.Contact_ID        = contact.ID 
		// 	  INNER JOIN row_level ON student.R_L_ID          = row_level.ID
		// 	  INNER JOIN contact as f ON student.Father_ID = f.ID
		// 	  WHERE contact.Isactive = 1  AND f.Isactive = 1 AND row_level.Level_ID  IN (" . $GetLevelImplode . ")  AND contact.SchoolID = '" . $this->session->userdata('SchoolID') . "' 

		// 	");
	}
	//////////////////////////////////
	public function get_father($class_rowlevel_id)
	{
		$PerType = explode(',', $class_rowlevel_id);
		$rowlevel = $PerType[0];
		$class    = $PerType[1];
		$query = $this->db->query("SELECT
									tb2.ID AS fatherID,
									tb2.Name AS FatherName,
									CASE WHEN LENGTH(tb2.Phone) >= 9 THEN tb2.Phone ELSE tb2.Mobile END AS mobile_number
									FROM contact As tb1
									INNER JOIN student ON tb1.ID = student.Contact_ID
									INNER JOIN contact as tb2 ON student.Father_ID = tb2.ID
									WHERE tb1.SchoolID = '" . $this->session->userdata('SchoolID') . "' AND student.R_L_ID =" . $rowlevel . " AND student.Class_ID  =" . $class . "
									 AND (LENGTH(tb2.Phone) >= 9 OR LENGTH(tb2.Mobile) >= 9)
	                                 AND tb2.Isactive = 1
		  
		   ");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	public function send_emp_msg($data = array())
	{
		extract($data);
		$employees_arr = implode(',', $GetEmp);
		$employee_mobiles_arr = $this->db->query("
	   
	    SELECT CASE WHEN LENGTH(Phone) >= 9 THEN Phone ELSE Mobile END AS mobile_number, ID As contactID 
        FROM
            `contact`
        WHERE ID IN($employees_arr)
        AND (LENGTH(Phone) >= 9 OR  LENGTH(Mobile) >= 9)
	     AND Isactive = 1
		 AND SchoolID = '" . $this->session->userdata('SchoolID') . "'")->result();

		if ($LevelID == -2) {
			$employee_mobiles_arr = $GetEmp;
		}
		foreach ($employee_mobiles_arr as $key => $item) {
			if ($LevelID == -2) {
				$mobile_number = $item;
			} else {
				$mobile_number = $item->mobile_number;
			}

			$Reason =  $this->send_msg($mobile_number, $Msg, $Sender, $token);
			if ($LevelID == -2) {
				$this->db->query("INSERT INTO temp_msg
                    			 (EmpID ,Msg ,ContactID,DateInsert , DateSend , Type , FileAttach , CountMsg	, SchoolID , LevelID, IsSend ,Reason ) 
                    			 VALUES( '" . $this->session->userdata('id') . "' , '" . $Msg . "', $mobile_number, '" . $Date . "' , '0000-00-00' , 3 , '' , '" . $CountMsg . "'	, '" . $this->session->userdata('SchoolID') . "' , '" . $LevelID . "','" . $Reason['status'] . "' ,'" . $Reason['message'] . "' )
			                   ");
			}
		}
		if ($LevelID != -2) {
			$this->db->query("INSERT INTO temp_msg
                			 (EmpID ,Msg , ContactID , DateInsert , DateSend , Type , FileAttach , CountMsg	, SchoolID , LevelID, IsSend ,Reason ) 
                			 SELECT '" . $this->session->userdata('id') . "' , '" . $Msg . "', ID , '" . $Date . "' , '0000-00-00' , 2 , '' , '" . $CountMsg . "'	, '" . $this->session->userdata('SchoolID') . "' , '" . $LevelID . "','" . $Reason['status'] . "' ,'" . $Reason['message'] . "' FROM contact
                			  WHERE ID IN (" . $employees_arr . ")   
			                ");
		}
	}
	///////////////////////////////////////////
	public function get_employee($LevelID)
	{
		$emp = get_emp_select_in();
		$schoolID = (int)$this->session->userdata('SchoolID');
		if ($LevelID == -1) {
			$query = $this->db->query("SELECT DISTINCT contact.ID , contact.Name  , contact.Mail ,CASE WHEN LENGTH(Phone) >= 9 THEN Phone ELSE Mobile END AS mobile_number
		  FROM contact 
		  WHERE contact.Type='E' AND contact.Isactive = 1 and contact.ID NOT IN (SELECT EmpID FROM class_table ) AND contact.SchoolID =" . $schoolID . "
		  
		   ");
		} else {
			$query = $this->db->query("SELECT DISTINCT contact.ID , contact.Name  , contact.Mail ,CASE WHEN LENGTH(Phone) >= 9 THEN Phone ELSE Mobile END AS mobile_number
		  FROM contact 
		  INNER JOIN class_table on contact.ID=class_table.EmpID
		  INNER JOIN row_level   on class_table.RowLevelID=row_level.ID
		  WHERE contact.Type='E' AND contact.Isactive = 1 and contact.ID IN(" . $emp . ") AND contact.SchoolID =" . $schoolID . " AND row_level.Level_ID = " . $LevelID . "  
		  
		   ");
		}
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	/////////////////////////////////rania
	public function add_msg($UserData = array())
	{
		$this->db->query("
	  INSERT INTO temp_msg SET
	  EmpID       = '" . $this->session->userdata('id') . "' , 
	  Msg         = '" . $UserData['Msg'] . "' ,
	  ContactID   = '" . $UserData['ContactID'] . "' ,
	  DateInsert  = '" . $this->Date . "' 
	  ");

		return true;
	}

	/////////////////////////////
	public function get_msg_not_send()
	{
		$query = $this->db->query(" 
		SELECT
		contact.Phone , 
		contact.ID AS ContactID ,
		temp_msg.ID AS MsgID , 
		temp_msg.Msg , 
		temp_msg.CountMsg ,
		temp_msg.SchoolID  , 
		temp_msg.LevelID   
		FROM contact
        INNER JOIN temp_msg ON contact.ID  = temp_msg.ContactID WHERE IsSend = 0 AND DATE(DateInsert) = DATE(CURDATE()) AND  contact.Phone<>'' LIMIT 70")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return false;
		}
	}
	////////////////////get_msg_mail_not_send
	public function get_msg_mail_not_send()
	{
		$query = $this->db->query(" 
		SELECT
		contact.Mail	 , 
		temp_msg.ID AS MsgID , 
		temp_msg.Msg ,
		temp_msg.FileAttach 
		FROM contact
        INNER JOIN temp_msg ON contact.ID  = temp_msg.ContactID WHERE temp_msg.IsSend = 0 AND DATE(temp_msg.DateInsert) = DATE(CURDATE()) AND temp_msg.Type = 0  AND  contact.Mail<>'' LIMIT 100 ")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return false;
		}
	}
	////////////////////update_msg
	public function update_msg($MsgID = 0)
	{
		$this->db->query("
	  UPDATE temp_msg SET
	  IsSend      = 1 , 
	  DateSend    = '" . $this->Date . "' 
	  WHERE ID = '" . $MsgID . "'
	  ");
		return true;
	}

	////////////////////get_msg_not_send
	public function check_msg_not_send()
	{
		$query = $this->db->query(" 
		SELECT
		contact.Phone , 
		temp_msg.ID AS MsgID , 
		temp_msg.Msg
		FROM contact
        INNER JOIN temp_msg ON contact.ID  = temp_msg.ContactID WHERE IsSend = 0 AND  contact.Phone<>'' ")->num_rows();
		return $query;
	}
	/////////////////////////
	public function send_message_andalas($Mobile = 0, $msg = null, $Sender, $token)

	{
		$Mobile = ltrim($Mobile, '0');
		$Mobile = ltrim($Mobile, '966');
		$Mobile = ltrim($Mobile, '+966');

		$sender              = $Sender;

		$Mobile              = '966' . $Mobile;

		$Message             = $msg;

		$result;

		if (strlen($Mobile) >= 9) {

			$authorization = "Authorization: Bearer " . $token;
			$url = lang("api_sec_link")."/api/" . $this->ApiDbname . "/Sms/send";

			$data = array("message" => $Message, "mobileNumber" => $Mobile, "sender" => $sender);
			$postdata = json_encode($data);
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
			$result = curl_exec($ch);
			$result = json_decode($result, true);
			curl_close($ch);
		}
		return $result;
	}
	public function send_parent_msg($data = array())
	{
		extract($data);
		$employees_arr = implode(',', $GetEmp);
		$employee_mobiles_arr = $this->db->query("SELECT CASE WHEN LENGTH(Phone) >= 9 THEN Phone ELSE Mobile END AS mobile_number, ID As contactID 
        FROM `contact`
        WHERE ID IN($employees_arr)
	    ")->result();

		foreach ($employee_mobiles_arr as $key => $item) {

			$Message           = "";

			$Message           = $Msg.PHP_EOL.site_url('home_new/home/opinionPoll/'.$item->contactID);
			
			$mobile_number     = $item->mobile_number;
			
			$Reason            =  $this->send_msg($mobile_number, $Message, $Sender, $token);
			
		}
		
			$this->db->query("INSERT INTO temp_msg
                			 (EmpID ,Msg , ContactID , DateInsert , DateSend , Type , FileAttach , CountMsg	, SchoolID , LevelID, IsSend ,Reason ) 
                			 SELECT '" . $this->session->userdata('id') . "' , '" . $Message . "', ID , '" . $Date . "' , '0000-00-00' , 2 , '' , '" . $CountMsg . "'	, '" . $this->session->userdata('SchoolID') . "' , '" . $LevelID . "','" . $Reason['status'] . "' ,'" . $Reason['message'] . "' FROM contact
                			  WHERE ID IN (" . $employees_arr . ")   
			                ");
	}


	////////////////////////////END CLASS	
}
