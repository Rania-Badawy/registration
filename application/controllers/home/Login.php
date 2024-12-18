<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller
{
	private $data = array();

	function __construct()
	{ //$this->output->delete_cache();
		// $this->output->disable_cache();

		//opcache_reset();
		parent::__construct();
		$this->load->model(array('home/login_model', 'admin/setting_model'));
		$this->data['NewPass'] = rand(111111, 999999);

		if ($this->session->userdata('language') == 'english') {
			$this->config->set_item('language', 'english');
			$this->lang->load('am', 'english');
			$this->lang->load('br', 'english');
			$this->lang->load('er', 'english');
			$this->lang->load('config', $this->session->userdata('language'));
		} else {
			$this->config->set_item('language', 'arabic');
			$this->lang->load('am', 'arabic');
			$this->lang->load('br', 'arabic');
			$this->lang->load('er', 'arabic');
			$this->lang->load('config', 'arabic');
		}
		$get_api_setting = $this->setting_model->get_api_setting();

		$this->ApiDbname = $get_api_setting[0]->{'ApiDbname'};
	}
	///////////////////////////////////////////////
	public function index()
	{

		$LoginNumber = 1;
		if ((int)$this->session->userdata('CheckLoginNumber') > 0) {
			$LoginNumber = $this->session->userdata('CheckLoginNumber');
			$this->session->set_userdata('CheckLoginNumber', $LoginNumber + 1);
		} else {
			$this->session->set_userdata('CheckLoginNumber', $LoginNumber);
		}
		if (isset($_GET['user_name']) && isset($_GET['password'])) {
		     $user_name = $this->input->get('user_name');
			
             $password = $this->input->get('password');
			//print_r($password );die;
			 $GetData_url      = $this->db->query(" SELECT ID , Type ,Isactive  FROM  contact
                                            WHERE  User_Name =$user_name 
                                        
                                        ")->row_array();
			$type_url     = $GetData_url['Type']; 
			$isactive_url = $GetData_url['Isactive']; 
			$id_ur        = $GetData_url['ID'];
			$queryfastu_url              = $this->db->query("SELECT ID FROM student  WHERE Father_ID ='".$id_ur."' ")->row_array();
			
		}
		if (($_SERVER['REQUEST_METHOD'] === 'POST' )|| (($this->ApiDbname == "SchoolAccAlebdaa") && (($type_url=='F')|| $queryfastu_url )&& ($isactive_url==1) ) ) {
			if ($this->session->userdata('language') == 'english') {
				$this->config->set_item('language', 'english');
			} else {
				$this->config->set_item('language', 'arabic');
			} 
			
			$this->form_validation->set_rules('username', 'lang:br_User_Name', 'required|min_length[1]|max_length[50]|xss_clean');
			$this->form_validation->set_rules('password', 'lang:br_Password', 'required|min_length[1]|max_length[50]|xss_clean');
			if (($this->form_validation->run() === false) && ($_SERVER['REQUEST_METHOD'] === 'POST' )) {
			} else {
				if(($this->ApiDbname == "SchoolAccAlebdaa") && (($type_url=='F')|| $queryfastu_url )&& ($isactive_url==1) && isset($_GET['user_name'])){
					$this->data['username'] = $this->input->get('user_name');
					$this->data['password'] = $this->input->get('password');
				
				}else{
				
					$this->data['username']     =
					str_replace("", " ", (string)$this->security->xss_clean($this->input->post('username')));
				$this->data['password']     =
					str_replace("", " ", (string)$this->security->xss_clean($this->input->post('password')));
				}

				
				$GetDataLogin               = $this->login_model->check_login($this->data);

				$queryfastu              = $this->db->query("SELECT ID FROM student  WHERE Father_ID ='".$GetDataLogin['ID']."' ")->row_array();
               
				if ($GetDataLogin) {
					extract($GetDataLogin);
					if ($Isactive == 0) {
						if (($this->ApiDbname == "SchoolAccAlebdaa") && (($GetDataLogin['Type']=='F')|| $queryfastu  ) && ($GetDataLogin['erp_active']==1) ) {
							redirect('home_new/home/accept_condtions/'.$this->data['username'] ."/" . $this->data['password'] ); 	    
						}else if($Isactive == 0 && $is_update == 2 ){
        				    $this->session->set_userdata('CheckLoginNumber', 0);
        					$this->session->set_flashdata('msg', 'الحساب غير مفعل برجاء مراجعة الاداره المالية للمدارس');
        					redirect('home/login', 'refresh');
        				} else{
							   $this->session->set_userdata('CheckLoginNumber', 0);
							$this->session->set_flashdata('msg', lang("br_login_error"));
							redirect('home/login', 'refresh'); 
						}
					} else {

						
						if ($Type=='U') {
			            	$schoolArray    = explode(',', $SchoolID);
							$SchoolID       = $schoolArray[0];
						} elseif($Type=='E'){
                          $school_emp       = $this->db->query("select school_id from permission_request where EmpID=$ID ")->row_array()['school_id'];
						  if($school_emp){
						      	$schoolArray    = explode(',', $SchoolID);
								$SchoolID       = $schoolArray[0];
						  }
						}
						$Timezone    = $this->setting_model->converToTimezone();
						$query       = $this->db->query("SELECT ID,Name,Name_en FROM `config_semester` WHERE date('" . $Timezone . "') BETWEEN `start_date` AND end_date")->row_array();
						if ($query['ID']) {
							$semester_id   = $query['ID'];
							$semester_name = $query['Name']."|".$query['Name_en'];
						} else {
							$semester_id = 1;
							$semester_name = 'الفصل الدراسي الاول'."|".'Semester 1';
						}
						$SessionData = array('id' => $ID, 'type' => $Type, 'contact_name' => $Name, 'SchoolID' => $SchoolID, 'GroupID' => $GroupID, 'login' => true, 'ActiveUser' => '', 'RedirectUser' => '', 'currentSemesterID' => $semester_id , 'currentSemesterName' => $semester_name , 'schools' => $schoolArray );

						$date   = $this->setting_model->converToTimezone_api();
						$this->UserIP = $this->input->ip_address();
						$this->Device = $this->input->user_agent();

						$dataUpdata      = array('LastLogin' => $date, 'count_login' => ($count_login) + 1, 'Online' => 1);
						$this->db->where('ID', $ID);
						$this->db->update('contact', $dataUpdata);

						$dataInserted      = array('User_ID' => $ID, 'User_IP' => $this->UserIP, 'Device' => $this->Device, 'Country' => "", 'Date' => $date);
						$this->db->insert('Login_Details', $dataInserted);
						$session = generateRandomString(200);
						$SessionDate = array('SessionToken' => $session, 'UserID' => $ID, 'Date' => $date);
						$this->db->insert('sessionToken', $SessionDate);

						if($Type == 'S'){
							$studentData = 	$this->db->query("SELECT DISTINCT R_L_ID, Class_ID
							FROM student
							WHERE Contact_ID = $ID;
									  ")->row_array();
							$SessionData['rowLevelId'] = $studentData['R_L_ID'];
							$SessionData['classId'] = $studentData['Class_ID'];
						}
						
						$this->session->set_userdata($SessionData);
						
						switch ($Type) {
							case 'U':
								redirect('admin/cpanel', 'refresh');
								break;
							case 'E':
								redirect('emp/cpanel', 'refresh');
								break;
							case 'F':
								$GetStudentID_header = $this->db->query("SELECT DISTINCT contact.ID , contact.Token
									   FROM student
									   INNER JOIN contact 
									   ON student.Contact_ID = contact.ID 
									   WHERE contact.IsActive = 1 and student.Father_ID = $ID
									  ")->row_array();

						$sonID         = $GetStudentID_header['ID'];
						$sonToken      = $GetStudentID_header['Token'];
						if ($this->ApiDbname == "SchoolAccAndalos"){
							redirect("father/requests", 'refresh');
						}else{
							redirect("father/cpanel/index/$sonToken/$sonID", 'refresh');
						}
								break;
							case 'S':
									redirect('student/cpanel/main_page', 'refresh');
								
								break;
						
							case 'R':
								redirect('home/home/Reg_exam', 'refresh');
							default:
								echo 'error';
								break;
						}
					}
				} else {
					$this->session->set_flashdata('msg', 'برجاء مراجعه إسم المستخدم وكلمه المرور ');
					redirect('home/login', 'refresh');
				}
			}
		}
		$this->load->view('home_new/view_login');
	}
/////////////////////////////////////////////// last update
	public function login_new()
	{
		$this->load->view('home/view_login_new');
	}
	public function check_login_new()
	{


		if ($this->session->userdata('language') == 'english') {
			$this->config->set_item('language', 'english');
		} else {
			$this->config->set_item('language', 'arabic');
		}
		$this->form_validation->set_rules('username', 'lang:br_User_Name', 'required|min_length[1]|max_length[50]|xss_clean');
		$this->form_validation->set_rules('password', 'lang:br_Password', 'required|min_length[1]|max_length[50]|xss_clean');

		if ($this->form_validation->run() === false) {
			//$this->index();			
		} else {

			$this->data['username']     =
				str_replace("", " ", (string)$this->security->xss_clean($this->input->post('username')));
			$this->data['password']     =
				str_replace("", " ", (string)$this->security->xss_clean($this->input->post('password')));
			$GetDataLogin               = $this->login_model->check_login($this->data);
			if ($GetDataLogin) {
				extract($GetDataLogin);
				if ($Isactive == 0) {
					$this->session->set_userdata('CheckLoginNumber', 0);
					$this->session->set_flashdata('msg', 'الحساب غير مفعل برجاء مرجعه الاداره');
					// redirect('home/loginsss','refresh');
				} else {

					if ($SchoolID == 0) {
						$SchoolID = $this->login_model->get_school();
					}
					// echo $SchoolID ;exit;
					$SessionData = array('id' => $ID, 'type' => $Type, 'contact_name' => $Name, 'SchoolID' => $SchoolID, 'GroupID' => $GroupID, 'login' => true);

					$this->session->set_userdata($SessionData);
					//// check type user
					switch ($Type) {
						case 'U':
							redirect('admin/cpanel', 'refresh');
							break;
						case 'E':
							redirect('emp/cpanel', 'refresh');
							break;
						case 'F':
							redirect('father/cpanel', 'refresh');
							break;
						case 'S':
							redirect('student/cpanel', 'refresh');
							break;
						case 'A':
							redirect('job/answer_exam', 'refresh');
							break;
						default:
							echo 'error';
							break;
					}
				}
			} else {
				$this->session->set_flashdata('msg', 'برجاء مراجعه إسم المستخدم وكلمه المرور ');
				// redirect('home/loginaa','refresh'); 
			}
		}
	}
	///check_login
	public function check_login()
	{
		if ($this->session->userdata('language') == 'english') {
			$this->config->set_item('language', 'english');
		} else {
			$this->config->set_item('language', 'arabic');
		}
		$this->form_validation->set_rules('username', 'lang:br_User_Name', 'required|min_length[1]|max_length[50]|xss_clean');
		$this->form_validation->set_rules('password', 'lang:br_Password', 'required|min_length[1]|max_length[50]|xss_clean');
		if ($this->form_validation->run() === false) {
			$this->index();
		} else {

			$this->data['username']     =
				str_replace("", " ", (string)$this->security->xss_clean($this->input->post('username')));
			$this->data['password']     =
				str_replace("", " ", (string)$this->security->xss_clean($this->input->post('password')));
			$GetDataLogin               = $this->login_model->check_login($this->data);
			if ($GetDataLogin) {
				extract($GetDataLogin);
				if ($Isactive == 0) {
					$this->session->set_userdata('CheckLoginNumber', 0);
					$this->session->set_flashdata('msg', 'الحساب غير مفعل برجاء مرجعه الاداره');
					redirect('home/login', 'refresh');
				} else {

					if ($SchoolID == 0) {
						$SchoolID = $this->login_model->get_school();
					}
					// echo $SchoolID ;exit;
					$SessionData = array('id' => $ID, 'type' => $Type, 'contact_name' => $Name, 'SchoolID' => $SchoolID, 'GroupID' => $GroupID, 'login' => true);

					$this->session->set_userdata($SessionData);
					//// check type user
					switch ($Type) {
						case 'U':
							redirect('admin/cpanel', 'refresh');
							break;
						case 'E':
							redirect('emp/cpanel', 'refresh');
							break;
						case 'F':
							redirect('father/cpanel', 'refresh');
							break;
						case 'S':
							redirect('student/cpanel', 'refresh');
							break;
						case 'A':
							redirect('job/answer_exam', 'refresh');
							break;
						case 'R':
							redirect('job/answer_exam/Reg_exam', 'refresh');
							break;
						default:
							echo 'error';
							break;
					}
				}
			} else {
				$this->session->set_flashdata('msg', 'برجاء مراجعه إسم المستخدم وكلمه المرور ');
				redirect('home/login', 'refresh');
			}
		}
	}
	///// up_login
	public function up_login()
	{
		$userID = (int)$this->input->post('userID');
		if ($this->login_model->up_login($userID)) {
			return TRUE;
		} else {
			$this->log_out();
		}
	}
	///// log out
	public function log_out()
	{
		$userID = $this->session->userdata('id');

		$data = array(
			'last_activity' => NULL,
			'Online'      => 0
		);

		$this->db->where('ID', $userID);
		$this->db->update('contact', $data);

		$this->session->sess_destroy();
		redirect('home', 'location');
	}
	////index
	public function reset_pass()
	{
		$this->load->view('home_new/view_reset_pass');
		//redirect('home/login'); 

	}

	public function reset_pass_send()
	{
		$User_Name = $this->input->post('User_Name');
		$SchoolName  = $this->input->post('SchoolName');
		$Number_ID  = $this->input->post('Number_ID');
		if (empty($User_Name) && empty($SchoolName)) {
			$this->session->set_flashdata('msg', lang('br_reset_pass_msg'));
			redirect('home/login/reset_pass', 'refresh');
		}
		if (!empty($User_Name) && !empty($Number_ID)) {
			$this->form_validation->set_rules('User_Name', 'lang:br_User_Name', 'required|min_length[1]|max_length[50]|xss_clean');
			$this->form_validation->set_rules('Number_ID', 'lang:reg_id_number', 'required|numeric|min_length[1]|max_length[50]|xss_clean');
			$this->form_validation->set_rules('SchoolName', 'lang:br_school_name', 'required|integer|min_length[1]|max_length[3]|xss_clean');
		}


		if ($this->form_validation->run() === false) {
			$this->reset_pass();
		} else {
			if ($this->login_model->update_pass2($SchoolName, $User_Name, $Number_ID)) {

				$this->session->set_flashdata('msg', 'لقد تم تغيير الباسورد بنجاح');
				redirect('home/login', 'refresh');
			} else {
				$this->session->set_flashdata('msg', 'من فضلك ادخل االبيانات الصحيحه');
				redirect('home/login/reset_pass', 'refresh');
			}
		}
	}
	/////////////////////////////////////
	public function check_mobile()
	{
		$Mobile = $this->input->post('mobile');
		if (!empty($Mobile)) {
			$UserID = $this->login_model->check_mobile($Mobile);
			if ((int)$UserID > 0) {
				$this->login_model->update_pass($UserID, $this->data['NewPass']);
				$this->send_msg($Mobile, lang('br_new_pass') . ':' . $this->data['NewPass']);
				$this->session->set_flashdata('msg', lang('br_msg_home_new_pass'));
				redirect('home/login', 'refresh');
			} else {
				$this->form_validation->set_message('check_mobile', '' . lang('br_check_mobile_database') . '');
				return FALSE;
			}
		}
	}
	/////////////////////////////////////
	public function check_email()
	{
		$Mail = $this->input->post('email');
		if (!empty($Mail)) {
			$UserID = $this->login_model->check_email($Mail);
			if ((int)$UserID > 0) {
				$this->login_model->update_pass($UserID, $this->data['NewPass']);

				$this->sent_mail($Mail, lang('br_new_pass') . ':' . $this->data['NewPass']);

				$this->session->set_flashdata('msg', lang('br_msg_home_new_pass'));
				redirect('home/login', 'refresh');
			} else {
				$this->form_validation->set_message('check_email', '' . lang('br_check_mail_database') . '');
				return FALSE;
			}
		}
	}

	//////send mail to admin
	private function sent_mail($UserMail = NULL, $Msg = NULL)
	{
		// print_r($Data);exit;
		$config['protocol'] = 'mail';
		$config['wordwrap'] = FALSE;
		$config['mailtype'] = 'html';
		$config['charset']  = 'utf-8';
		$config['crlf']     = "\r\n";
		$config['newline']  = "\r\n";
		$this->load->library('email', $config);
		$this->email->from(lang('am_mail_school'), lang('am_title_school'));
		$this->email->to($UserMail);
		$this->email->subject(lang('am_title_school'));
		$email = $Msg;
		$this->email->message($email);
		if ($this->email->send()) {
			//print_r($Data);exit;
			return TRUE;
		} else {
			return FALSE;
		}
	}
	////////////////////////// send_msg
	private function send_msg($Mobile = 0, $msg = null)
	{
		$Mobile = $Mobile;
		$array  = array_map('intval', str_split($Mobile));
		//var_dump($array);exit;
		if ($array[0] == 0) {
			$Mobile = ltrim($Mobile, '0');
		}

		$sender              = 'esol-AD';
		$Username            = "Aboabdo";
		$Password            = "123456";
		$Mobile              = '966' . $Mobile;
		$Message             = $msg;

		if (strlen($Mobile) >= 9) {
			curl_setopt_array($ch = curl_init(), array(
				CURLOPT_URL => "http://www.csms.co/api/sendsms.php",
				CURLOPT_POSTFIELDS => array(
					"username" => $Username,
					"password" => $Password,
					"numbers" => $Mobile,
					"sender" => $sender,
					"message" => $Message
				)
			));
			$result = curl_exec($ch);
			curl_close($ch);
		}
		return TRUE;
	}

	public function sent_username()
	{
		$query = $this->db->query("SELECT ID , User_Name , Mobile  FROM contact WHERE Type = 'F' AND Msg = 0  LIMIT 100")->result();
		if (sizeof($query) > 0) {
			$Count = 0;
			foreach ($query as $Key => $Father) {
				$FatherID = $Father->ID;
				$UserName = $Father->User_Name;
				$Mobile   = $Father->Mobile;
				$StudentUSerName = "";
				//$query = $this->db->query("SELECT  contact.User_Name AS StudentUserName  FROM contact INNER JOIN student ON contact.ID = student.Contact_ID WHERE student.Father_ID  = '".$FatherID."' ")->row_array();	
				//if(sizeof($query)>0)
				//{
				//  $StudentUSerName = $query['StudentUserName'] ;	
				//}
				$Message  = " السادة أولياء الأمور بيانات الدخول لمتابعة التقارير بمدارس بيت القيم  إسم المستخدم  : " . $UserName . "  كلمة المرور هى نفس إسم  المستخدم ";
				//echo $Message ; exit; 
				$this->send_msg($Mobile, $Message);
				$this->db->query("UPDATE  contact SET Msg = 1   WHERE ID  = '" . $Father->ID . "' ");
				// $Count++;
				//if($Count == 10 ){redirect("admin/cpanel/sent_username",'refresh');}
			}
		}
	}

	public function login_with_other()
	{
		$Active_Student   = $this->uri->segment(4); //student
		$RedirectUser     = $this->uri->segment(5); //admin
		$GetDataLogin     = $this->login_model->check_another_login($Active_Student);
		$studentData      = $this->db->query("SELECT DISTINCT R_L_ID, Class_ID FROM student WHERE Contact_ID = $Active_Student")->row_array();
		$rowLevelId       = $studentData['R_L_ID'];
		$classId          = $studentData['Class_ID'];
		if ($GetDataLogin) {
			extract($GetDataLogin);

			if ($SchoolID == 0) {
				$SchoolID = $this->login_model->get_school();
			}
			$SessionData = array('id' => $ID, 'type' => $Type, 'contact_name' => $Name, 'SchoolID' => $SchoolID, 'GroupID' => $GroupID, 'login' => true, 'ActiveUser' => $ID,'RedirectUser' => $RedirectUser,'rowLevelId' => $rowLevelId,'classId' => $classId);
			$this->session->set_userdata($SessionData);
			switch ($Type) {
				case 'U':
					redirect('admin/cpanel', 'refresh');
					break;
				case 'E':
					redirect('emp/cpanel', 'refresh');
					break;
				case 'F':
					redirect('father/cpanel', 'refresh');
					break;
				case 'S':
					redirect('student/cpanel/main_page', 'refresh');
					break;
				default:
					echo 'error';
					break;
			}
		}
	}

	public function AuthForExam(){
		$token = $this->input->get('Token'); 
		$examID = $this->input->get('ExamID'); 
		$this->db->select('subject_id,type');	
					$this->db->from('test');	
					$this->db->where('ID',$examID);	
					$ExamResult = $this->db->get();
					$ExamData  = $ExamResult->row_array() ; 
			//  dd($ExamData);
		if (!$token) {
			echo json_encode(['error' => true, 'message' => 'Token is required.']);
			return;
		}
	
		if (!$examID) {
			echo json_encode(['error' => true, 'message' => 'ExamID is required.']);
			return;
		}
		if ($token) {
		$GetDataLogin   = $this->login_model->AuthFromeApi($token);
		if (!$GetDataLogin) {
			echo json_encode(['error' => true, 'message' => 'Authentication failed.']);
			return;
		}else {
			extract($GetDataLogin);

			if ($SchoolID == 0) {
				$SchoolID = $this->login_model->get_school();
			}
			$SessionData = array('id' => $ID, 'type' => $Type, 'contact_name' => $Name, 'SchoolID' => $SchoolID, 'GroupID' => $GroupID, 'login' => true, 'ActiveUser' => '', 'RedirectUser' => '', 'currentSemesterID' => $semester_id , 'currentSemesterName' => $semester_name , 'schools' => $querySchool );
			$this->session->set_userdata($SessionData);
			switch ($Type) {
				case 'S':
					redirect('student/answer_exam/show_exam/'.$ExamData['subject_id'].'/'.$ExamData['type'].'/'.$examID, 'refresh');
					break;
				default:
					echo json_encode(['error' => true, 'message' => 'User type error.']);
					break;
			}
		}
		}else {
			$this->session->set_flashdata('msg', "send {ExamToken} plese");
			redirect('home/login', 'refresh'); 
		}
	}	
	
}
