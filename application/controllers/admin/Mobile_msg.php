<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Mobile_Msg extends MY_Admin_Base_Controller{

	private $data = array() ;

	function __construct()

    {

	   parent::__construct();

	   $this->load->library('get_data_admin');

	   	$this->load->model(array('admin/mobile_model','admin/setting_model'));

	   $this->data['UID']            = $this->session->userdata('id');

	   $this->data['YearID']         = $this->session->userdata('YearID');

	   $this->data['Year']           = $this->session->userdata('Year');

	   $this->data['Semester']       = $this->session->userdata('Semester');

	   $this->data['Lang']           = $this->session->userdata('language');
	   
	   $this->token                  = $this->setting_model->acess_token();
	   $get_api_setting              = $this->setting_model->get_api_setting(); 
	   $this->ApiDbname              = $get_api_setting[0]->{'ApiDbname'};

    }
////////////////////////////////////
   public function get_msg_balance_new()
 	{ 
     	    $token= $this->token;
            $authorization = "Authorization: Bearer ".$token;
            $url = lang("api_sec_link")."/api/".$this->ApiDbname."/Sms/balance";
            $ch=curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: application/json' , $authorization) );
            $result = curl_exec($ch);
            $result=json_decode($result, true);
            curl_close($ch);
            return  $result['data'];
		
	}
	////////////////////////////////////
   public function sender()
 	{ 
     	    $token= $this->token;
            $authorization = "Authorization: Bearer ".$token;
            $url = lang("api_sec_link")."/api/".$this->ApiDbname."/Sms/senders";
            $ch=curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: application/json' , $authorization) );
            $result = curl_exec($ch);
            $result=json_decode($result, true);
            curl_close($ch);
            return  array_reverse($result['data']);
		
	}
	////////////////////////////////
	  public function send_sms_parents()
  {
	   	$Data['GetLevel']           = get_level_group();
	   	$Data['GetRowLevel']        = get_rowlevel_group();
		$Data['GetClass']           = get_class_group();
		$Data['GetFather']          = get_student_group1();
        $Data['Balance']            = $this->get_msg_balance_new();
        $Data['SenderArchive']      = $this->sender();
	    $this->load->admin_template('view_send_sms_parents',$Data); 
  }
  //////////////////////////////////////
  public function active_sms_parents()

  {
	  $date              = $this->setting_model->converToTimezone();
      $token             = $this->token;
	  $Type              = $this->input->post('Type');
	  $RowLevel          = $this->input->post('RowLevel');
	  $GetFather         = $this->input->post('GetFather');
	  $Father_special    = $this->input->post('Father_special');
	  $SelectClass       = $this->input->post('SelectClass');
	  $SelectLevel       = $this->input->post('SelectLevel');
	  $message           = filter_var($this->input->post('message'), FILTER_SANITIZE_STRING);
	  $Sender            = $this->input->post('Sender');
	  $CountMsg          = 1 ;
	  $LastMsg           = $this->db->query("SELECT CountMsg FROM temp_msg  ORDER BY ID DESC LIMIT 1")->row_array();

	   if(sizeof($LastMsg) > 0  ){$CountMsg = (int)$LastMsg['CountMsg']+1 ; }
       if($Type == 1 )
    	  {
    		  $this->mobile_model->send_row_msg($RowLevel , $message  , $CountMsg,$Sender,$token,$date );
    	  }else if($Type == 2)
	      {
		   $this->mobile_model->send_class_msg($SelectClass , $message , $CountMsg ,$Sender,$token,$date);
	      }
    	  else if($Type == 3)
    
    	  {
    		$this->mobile_model->send_father_msg($GetFather , $message, $CountMsg ,$Sender,$token,$date  );
    	  }
    	  else if($Type == 5)
    	  {
    	    $this->mobile_model->send_father_msg($Father_special , $message, $CountMsg ,$Sender,$token,$date  );
    
    	  }
    	  else if($Type == 4 )
    	   {
    
    		  $this->mobile_model->send_level_msg($SelectLevel , $message, $CountMsg ,$Sender,$token,$date );
    	   }

		$this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));

		redirect('admin/cpanel/send_sms_class_row','refresh');



  }
  
	//////////////////////////////////////
	public function send_sms_emp()

    {

	    $this->data['GetLevel']      = get_level_group();
		$this->data['get_emp_per']   = get_emp_select_in() ;
    	$this->data['NumMsg']        = $this->mobile_model->check_msg_not_send();
    	$this->data['Balance']       = $this->get_msg_balance_new();
		$this->data['Contact']       = $this->db->query("SELECT contact.ID , contact.Name , contact.Mobile , contact.Mail FROM contact WHERE contact.Type='E' AND contact.Isactive = 1 and contact.ID IN(".$this->data['get_emp_per'].") ")->result();
        $this->data['SenderArchive'] = $this->sender();
	    $this->load->admin_template('view_send_sms_emp',$this->data); 

    }
    //////////////////////////////
 public function active_sms_emp()
  {
      $data['token']       = $this->token;
	  $data['GetEmp']      = $this->input->post('GetEmp');
	  $data['LevelID']     = $this->input->post('SelectLevel');
	  $data['Msg']         = filter_var($this->input->post('message'), FILTER_SANITIZE_STRING);
	  $data['Sender']      = $this->input->post('Sender');
	  $data['Date']        = $this->setting_model->converToTimezone();
	  $data['CountMsg']    = 1 ;
	  if($data['LevelID']==-2){
	      $data['GetEmp']      = explode(",",$this->input->post('GetEmp_written'));
	  }
	  $LastMsg     = $this->db->query("SELECT CountMsg FROM temp_msg  ORDER BY ID DESC LIMIT 1")->row_array();
	   if(sizeof($LastMsg) > 0  ){$data['CountMsg'] = (int)$LastMsg['CountMsg']+1 ; }

		  if($data['LevelID'] !=0){$this->mobile_model->send_emp_msg($data);}

		$this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));

		redirect('admin/mobile_msg/send_sms_emp','refresh');
  }
  /////////////////////////////////
   public function getSelectUser($Level)
       {   
        $dataResponse['Selectstudent'] =  $this->mobile_model->get_employee($Level);
        $this->output->set_content_type('application/json')->set_output(json_encode($dataResponse));
       }
  ////////////////////////////////////
  public function getSelectUser_father($class_rowlevel_id)
    {
        $dataResponse['Selectfather'] =  $this->mobile_model->get_father($class_rowlevel_id);
        $this->output->set_content_type('application/json')->set_output(json_encode($dataResponse));
    }
////////////////////////////////////rania

  public function send_mail()

  {
	    $Data['GetRowLevel'] = get_row_level();
		$Data['GetClass']    = get_class_per();
		$Data['GetFather']   = get_student_group();
	    $this->load->admin_template('view_send_mail',$Data); 

  } ///////////////////////////active_send_mail

  public function active_send_mail()

  {

	  $FileNameHid      = $this->input->post('FileNameHid');

	  $SelectClass      = $this->input->post('SelectClass');

	  $GetStudent       = $this->input->post('GetStudent');

	  $message          = filter_var($this->input->post('message'), FILTER_SANITIZE_STRING);

	  $this->mobile_model->send_mail($SelectClass , $GetStudent , $message , $FileNameHid  );

	  $this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));

		redirect('admin/mobile_msg/send_mail','refresh');

	  

  }

  ///////////msg_sender

  public function msg_sender()

  {

	    $Data['GetLevel']    = get_level();

		if($Data['GetLevel'])

		{

		    $SchoolID = $this->session->userdata('SchoolID'); 	

		   foreach($Data['GetLevel'] as $Key=>$Row)

		   {

			 $LevelID = $Row->ID ;

			 $query   = $this->db->query("SELECT ID FROM msg_sms_sender WHERE LevelID = '".$LevelID."' AND SchoolID = '".$SchoolID."' ")->num_rows();    

		     if($query == 0)

			 {

				 $this->db->query(" INSERT INTO msg_sms_sender SET LevelID = '".$LevelID."' , SchoolID = '".$SchoolID."' ") ;

			 }

		   }	

		}

	    $this->load->admin_template('view_msg_sender',$Data);

  }

  ////////msg_sender

  public function active_msg_sender()

  {

	  $Key = $this->input->post('Key');

	  for($i=0;$i<=$Key;$i++)

	  {

		  $Sender    = $this->input->post('Sender_'.$i);

		  $UserName  = $this->input->post('UserName_'.$i);

		  $Password  = $this->input->post('Password_'.$i);

		  $NumMsg    = $this->input->post('NumMsg_'.$i);

		  $MsgID     = $this->input->post('MsgID_'.$i);

		  $this->db->query(" UPDATE  msg_sms_sender SET UserName = '".$UserName."' , Password  = '".$Password."' ,  NumMsg = '".$NumMsg."' , ContactID = '".$this->data['UID']."' , SenderName = '".$Sender."'  WHERE ID  = '".$MsgID."' ") ;



	  }

	  

	  $this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));

		redirect('admin/mobile_msg/msg_sender','refresh');

  }

   ////////////get_msg_balance

    public function get_msg_balance()

	{

	

		//yourdomain/yourspecialapi/getCountries.php?return=xml

		$Username            = "" ;

		$Password            = "123456" ;

		$Url                 = 'http://www.4jawaly.net/api/getbalance.php?username='.$Username.'&password='.$Password.'&hangedBalance=true' ;

		echo file_get_contents('http://www.4jawaly.net/api/getbalance.php?username='.$Username.'&password='.$Password.'&hangedBalance=true');

		echo $Url ; exit;

		exit;

		curl_setopt_array($ch = curl_init(), array(

		CURLOPT_URL => "http://www.4jawaly.net/api/getbalance.php",

		CURLOPT_POSTFIELDS => array(

		"username" => $Username,

		"password" => $Password,

		"hangedBalance" => true)));

		$str = curl_exec($ch);

		$info = curl_getinfo($ch);

		curl_close($ch);

		// the value of $str is actually bool(true), not empty string ''

		var_dump($info); 

	}

	private function send_msg($Mobile = 0 , $msg = null )

	{

		//echo $Mobile ; exit;

		$Mobile = $Mobile;

		$array  = array_map('intval', str_split($Mobile));

		//var_dump($array);exit;

		if($array[0] == 0  )

		{

			$Mobile = ltrim($Mobile , '0');

		}



		$sender              = ''  ;

		$Username            = "" ;

		$Password            = "123456" ;

		$Mobile              = '966'.$Mobile ;

		$Message             = $msg;



		if(strlen($Mobile) >= 9)

		{

			curl_setopt_array($ch = curl_init(), array(

				CURLOPT_URL => "http://www.4jawaly.net/api/sendsms.php",

				CURLOPT_POSTFIELDS => array(

					"username" => $Username,

					"password" => $Password,

					"numbers" => $Mobile,

					"sender" => $sender,

					"message" => $Message,
					
					"unicode" =>'E',
					
    				"return" =>'Json')));

			$result = curl_exec($ch);

			curl_close($ch);

		}

		return $result ;

	}

	

	

 /////////////////END CLASS 	

}
