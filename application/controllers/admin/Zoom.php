<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . '/traits/zoom/TokenTrait.php';

class Zoom extends MY_Admin_Base_Controller
{
	use TokenTrait; 

	private $data = array();

	function __construct()
	{
		parent::__construct();
		$this->load->model(array('home/login_model', 'admin/zoom_model', 'admin/employee_model', 'admin/setting_model', 'admin/report_statistical_model', 'admin/Permission_model','admin/students_affairs_model' ));
		$this->load->library("pagination");
		$this->zoom_token = $this->GetToken();
		// $get_zoom_token = $this->zoom_model->get_zoom_token();
		// $this->zoom_token = $get_zoom_token[0]->{'INFO'};
	}






	public function test()
	{


		$token = $this->zoom_token;

		$token = $this->zoom_token;


		$curl_h = curl_init('https://api.zoom.us/v2/meetings/4744033538');
		curl_setopt(
			$curl_h,
			CURLOPT_HTTPHEADER,
			array(
				"Authorization:Bearer" . $token,
			)
		);

		curl_setopt($curl_h, CURLOPT_RETURNTRANSFER, true);
		$response = json_decode(curl_exec($curl_h));

		print_r($response); die;
		print_r($response);

		die;
		$data = [
			"action" => 'end',

		];
		$token = $this->zoom_token;
		$curl = curl_init();
		$room_url = 'https://api.zoom.us/v2/meetings/99063075021/status';
		curl_setopt_array($curl, array(
			CURLOPT_URL => $room_url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($data),
			CURLOPT_HTTPHEADER => array(
				"Authorization:Bearer" . $token,
				"Content-Type:application/json",
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		print_r($response);
		die;

		die;
		$curl_h = curl_init('https://api.zoom.us/v2/meetings/99063075021');
		curl_setopt(
			$curl_h,
			CURLOPT_HTTPHEADER,
			array(
				"Authorization:Bearer" . $token,
			)
		);

		curl_setopt($curl_h, CURLOPT_RETURNTRANSFER, true);
		$response = json_decode(curl_exec($curl_h));

		print_r($response);

		$curl_h = curl_init('https://api.zoom.us/v2/meetings/99063075021?action=end');
		curl_setopt(
			$curl_h,
			CURLOPT_HTTPHEADER,
			array(
				"Authorization:Bearer" . $token,
			)
		);

		curl_setopt($curl_h, CURLOPT_RETURNTRANSFER, true);
		$response = json_decode(curl_exec($curl_h));

		print_r($response);

		$curl_h = curl_init('https://api.zoom.us/v2/meetings/99063075021');
		curl_setopt(
			$curl_h,
			CURLOPT_HTTPHEADER,
			array(
				"Authorization:Bearer" . $token,
			)
		);

		curl_setopt($curl_h, CURLOPT_RETURNTRANSFER, true);
		$response = json_decode(curl_exec($curl_h));

		// print_r($response->{start_url}); die;
		print_r($response);
		die;
		$occurrences = $response->{occurrences};
		foreach ($occurrences as $k => $id) {
			echo   $id1 = $id->start_time;
			echo   $id1 = $id->occurrence_id;
		}
	}
	public function ZoomUseremail($user_id)
	{

		if (!$this->session->userdata('id')) {
			redirect('home/login');
		}

		$token = $this->zoom_token;
		$types = $this->session->userdata('type');
		if ($types == "U") {
			$arr = [];


			$curl_h = curl_init('https://api.zoom.us/v2/users/' . $user_id);
			curl_setopt(
				$curl_h,
				CURLOPT_HTTPHEADER,
				array(
					"Authorization:Bearer" . $token,
				)
			);

			curl_setopt($curl_h, CURLOPT_RETURNTRANSFER, true);
			$response =  json_decode(json_encode(curl_exec($curl_h)), true);

			$obj = json_decode($response);
			return $obj->{'email'};
		}
	}
	public function listZoomMeeting_without_emp_id($show = 0)
	{
		if (!$this->session->userdata('id')) {
			redirect('home/login');
		}

		$token = $this->zoom_token;
		$types = $this->session->userdata('type');

		$Data['rooms'] = $this->zoom_model->get_rooms();
		if ($show == 1) {
			// $Data['rooms'] = $this->zoom_model->get_rooms_by_empid();
			if ($types == "U") {
				/* $curl_h = curl_init('https://api.zoom.us/v2/users/info@diwan-language-school.com/meetings?page_size=5000');
       
      // $token=$this->zoom_token;
      // $curl_h = curl_init('https://api.zoom.us/v2/users/info@diwan-language-school.com/meetings?page_size=5000');
        curl_setopt($curl_h, CURLOPT_HTTPHEADER,
            array(
               "Authorization:Bearer".$token,
            )
        );
        
        curl_setopt($curl_h, CURLOPT_RETURNTRANSFER, true);
        
        $response = json_decode(curl_exec($curl_h));
	    $Data['get_All']=$response->meetings;*/
				/*   $ids = $this->zoom_model->Get_mettingids1();
             $arr=[];
	    foreach($ids as $k=>$id){
	     $id1=$id->MeetingId;
	     
	     $curl_h = curl_init('https://api.zoom.us/v2/meetings/'.$id1);
        curl_setopt($curl_h, CURLOPT_HTTPHEADER,
            array(
               "Authorization:Bearer".$token,
            )
        );
        
        curl_setopt($curl_h, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($curl_h));
        $arr[$k]= $response;
        }
         $Data['get_All']=$arr;*/
				$arr = [];
				foreach ($Data['rooms']  as $room) {
					$curl_h = curl_init('https://api.zoom.us/v2/users/' . $room->email . '/meetings?page_size=5000&type=upcoming');


					curl_setopt(
						$curl_h,
						CURLOPT_HTTPHEADER,
						array(
							"Authorization:Bearer" . $token,
						)
					);

					curl_setopt($curl_h, CURLOPT_RETURNTRANSFER, true);

					$response = json_decode(curl_exec($curl_h));
					$arr1 = $response->meetings;
					if (is_array($arr1)) {
						$arr = array_merge($arr, $arr1);
					}
				}

				$Data['get_All'] = $arr;
			} else {
				$ids = $this->zoom_model->Get_mettingids();
				$arr = [];
				foreach ($ids as $k => $id) {
					$id1 = $id->MeetingId;

					$curl_h = curl_init('https://api.zoom.us/v2/meetings/' . $id1);
					curl_setopt(
						$curl_h,
						CURLOPT_HTTPHEADER,
						array(
							"Authorization:Bearer" . $token,
						)
					);

					curl_setopt($curl_h, CURLOPT_RETURNTRANSFER, true);
					$response = json_decode(curl_exec($curl_h));
					$arr[$k] = $response;
				}
				$Data['get_All'] = $arr;
			}
		}
		$Data['GetEmp'] =  $this->zoom_model->get_emp(); // echo 1; print_r( $Data['GetEmp']);die;
		$Data['GetRowLevel'] =  $this->zoom_model->getRowLevel();
		$Data['getSubject'] =  $this->zoom_model->getSubject();

		$Data['GetPermission'] = $this->zoom_model->get_permission();
		$this->load->admin_template('list_Zoom_Meeting', $Data);
	}

	public function listZoomMeeting_by_room()
	{
		$Data['date'] = $this->setting_model->converToTimezone();
		if (!$this->session->userdata('id')) {
			redirect('home/login');
		}
		$Data['rooms'] = $this->zoom_model->get_rooms_by_schoolid();
		$Data['GetTeacher'] =  $this->zoom_model->get_all_teacher();

		if (isset($_POST['room']) || isset($_POST['start_time'])) {
			$room = $_POST['room'];
			$Data['start_time'] = $date = $_POST['start_time'];
			$teacher = $_POST['teacher_id'];

			$types = $this->session->userdata('type');
			if ($types == "U" || $types == "E") {
				$ids = $this->zoom_model->Get_mettingids_by_room_date($room, $date, $teacher);
				$Data['get_All'] = $ids;
			}

			$Data['GetEmp'] =  $this->zoom_model->get_emp(); // echo 1; print_r( $Data['GetEmp']);die;
			$Data['GetRowLevel'] =  $this->zoom_model->getRowLevel();
			$Data['getSubject'] =  $this->zoom_model->getSubject();

			$Data['rooms'] = $this->zoom_model->get_rooms_by_schoolid();
			$Data['GetPermission'] = $this->zoom_model->get_permission();
		}
		$this->load->admin_template('list_Zoom_Meeting_by_room', $Data);
	}


	public function last_listZoomMeeting()
	{
		$emp = get_emp_select_in();

		$Data['date'] = $this->setting_model->converToTimezone();
		if (!$this->session->userdata('id')) {
			redirect('home/login');
		}
		$Data['rooms'] = $this->zoom_model->get_rooms_by_schoolid();
		$idContact = (int)$this->session->userdata('id');
		$this->db->select('GroupID');
		$this->db->from('contact');
		$this->db->where('ID', $idContact);
		$Result = $this->db->get();
		$NumRowResult = $Result->num_rows();
		if ($NumRowResult > 0) {
			$Return     = $Result->row_array();
			$GroupID       = $Return['GroupID'];
		}
		if (isset($_POST['room']) || isset($_POST['start_time'])) {
			$room = $_POST['room'];
			$date = $_POST['start_time'];
			$types = $this->session->userdata('type');
			//print_r($types);die;
			if ($types == "U" || $types == "E") {
				$ids = $this->zoom_model->Get_mettingids_by_room_date1($room, $date);
				$Data['get_All'] = $ids;
				//  print_r($this->db->last_query());die;
			}

			$Data['GetEmp'] =  $this->zoom_model->get_emp(); // echo 1; print_r( $Data['GetEmp']);die;
			$Data['GetRowLevel'] =  $this->zoom_model->getRowLevel();
			$Data['getSubject'] =  $this->zoom_model->getSubject();

			$Data['rooms'] = $this->zoom_model->get_rooms_by_schoolid();
			$Data['GetPermission'] = $this->zoom_model->get_permission();
		} else {
			$room = $_POST['room'];
			$date = $_POST['start_time'];
			$types = $this->session->userdata('type');
			if ($types == "E" && $GroupID != 0) {
				$ids = $this->zoom_model->Get_mettingids_by_last_add1($emp);
				$Data['get_All'] = $ids;
			} elseif ($types == "E" && $GroupID == 0) {
				$ids = $this->zoom_model->Get_mettingids_by_last_add($emp);
				$Data['get_All'] = $ids;
			} elseif ($types == "U") {
				$ids = $this->zoom_model->Get_mettingids_by_last_add1($emp);
				//  print_r($this->db->last_query());die;
				$Data['get_All'] = $ids;
			}
			$Data['GetEmp'] =  $this->zoom_model->get_emp(); // echo 1; print_r( $Data['GetEmp']);die;
			$Data['GetRowLevel'] =  $this->zoom_model->getRowLevel();
			$Data['getSubject'] =  $this->zoom_model->getSubject();

			$Data['rooms'] = $this->zoom_model->get_rooms_by_schoolid();
			$Data['GetPermission'] = $this->zoom_model->get_permission();
		}

		$this->load->admin_template('last_listZoomMeeting', $Data);
	}
	public function listZoomMeeting_without_script()
	{

		if (!$this->session->userdata('id')) {
			redirect('home/login');
		}

		$token = $this->zoom_token;
		$types = $this->session->userdata('type');
		if ($types == "U" || $types == "E") {
			$ids = $this->zoom_model->Get_mettingids_by_emp_id();
			$Data['get_All'] = $ids;
		}

		$Data['GetEmp'] =  $this->zoom_model->get_emp(); // echo 1; print_r( $Data['GetEmp']);die;
		$Data['GetRowLevel'] =  $this->zoom_model->getRowLevel();
		$Data['getSubject'] =  $this->zoom_model->getSubject();

		$Data['rooms'] = $this->zoom_model->get_rooms_by_schoolid();
		$Data['GetPermission'] = $this->zoom_model->get_permission();
		$this->load->admin_template('list_Zoom_Meeting_by_emp_id_without_script', $Data);
	}
	public function listZoomMeeting()
	{

		if (!$this->session->userdata('id')) {
			redirect('home/login');
		}

		$token = $this->zoom_token;
		$types = $this->session->userdata('type');
		if ($types == "U" || $types == "E") {
			$ids = $this->zoom_model->Get_mettingids_by_emp_id();
			$Data['get_All'] = $ids;
		}

		$Data['GetEmp'] =  $this->zoom_model->get_emp(); // echo 1; print_r( $Data['GetEmp']);die;
		$Data['GetRowLevel'] =  $this->zoom_model->getRowLevel();
		$Data['getSubject'] =  $this->zoom_model->getSubject();

		$Data['rooms'] = $this->zoom_model->get_rooms_by_schoolid();
		$Data['GetPermission'] = $this->zoom_model->get_permission();
		$this->load->admin_template('list_Zoom_Meeting_by_emp_id', $Data);
	}




	public function previous_listZoomMeeting()
	{

		if (!$this->session->userdata('id')) {
			redirect('home/login');
		}

		$token = $this->zoom_token;
		$types = $this->session->userdata('type');
		if ($types == "U") {
			$ids = $this->zoom_model->Get_previous_mettingids();
			$Data['get_All'] = $ids;
		}

		$Data['rooms'] = $this->zoom_model->get_rooms();
		$Data['GetPermission'] = $this->zoom_model->get_permission();
		$this->load->admin_template('previous_list_Zoom_Meeting', $Data);
	}
	public function listZoomMeetingxxx()
	{

		if (!$this->session->userdata('id')) {
			redirect('home/login');
		}
		$Data['rooms'] = $this->zoom_model->get_rooms();
		$token = $this->zoom_token;
		$types = $this->session->userdata('type');
		if ($types == "U") {
			$arr = [];
			foreach ($Data['rooms']  as $room) {
				$curl_h = curl_init('https://api.zoom.us/v2/users/' . $room->email . '/meetings?page_size=5000');


				curl_setopt(
					$curl_h,
					CURLOPT_HTTPHEADER,
					array(
						"Authorization:Bearer" . $token,
					)
				);

				curl_setopt($curl_h, CURLOPT_RETURNTRANSFER, true);

				$response = json_decode(curl_exec($curl_h));
				$arr1 = $response->meetings;
				$arr = array_merge($arr, $arr1);
			}

			$Data['get_All'] = $arr;
		} else {
			$ids = $this->zoom_model->Get_mettingids();
			$arr = [];
			foreach ($ids as $k => $id) {
				$id1 = $id->MeetingId;

				$curl_h = curl_init('https://api.zoom.us/v2/meetings/' . $id1);
				curl_setopt(
					$curl_h,
					CURLOPT_HTTPHEADER,
					array(
						"Authorization:Bearer" . $token,
					)
				);

				curl_setopt($curl_h, CURLOPT_RETURNTRANSFER, true);
				$response = json_decode(curl_exec($curl_h));
				$arr[$k] = $response;
			}
			$Data['get_All'] = $arr;
		}
		$Data['GetPermission'] = $this->zoom_model->get_permission();
		$this->load->admin_template('list_Zoom_Meeting', $Data);
	}

	public function deletexx($id, $room = '')
	{
		$token = $this->zoom_token;
		//     $token=$this->zoom_token;

		$curl_h = curl_init('https://api.zoom.us/v2/meetings/' . $id);

		curl_setopt(
			$curl_h,
			CURLOPT_HTTPHEADER,
			array(
				"Authorization:Bearer" . $token,
			)
		);

		curl_setopt($curl_h, CURLOPT_CUSTOMREQUEST, "DELETE");
		$response = json_decode(curl_exec($curl_h));
		$this->db->query("UPDATE zoom_premission  SET MeetingId =NULL  WHERE zoom_premission.MeetingId =$id ");
		if ($room == 'room') {

			redirect('admin/zoom/list_Zoom_Meeting_by_room', 'refresh');
		} else {

			redirect('admin/zoom/listZoomMeeting', 'refresh');
		}
	}
	public function delete($id, $room = '')
	{
		// print_r($this->uri->segment(6));die;
		$token = $this->zoom_token;
		//     $token=$this->zoom_token;

		$curl_h = curl_init('https://api.zoom.us/v2/meetings/' . $id);

		curl_setopt(
			$curl_h,
			CURLOPT_HTTPHEADER,
			array(
				"Authorization:Bearer" . $token,
			)
		);

		curl_setopt($curl_h, CURLOPT_CUSTOMREQUEST, "DELETE");
		$respopnse = json_decode(curl_exec($curl_h));

		$this->db->query("UPDATE zoom_premission  SET MeetingId =NULL  WHERE zoom_premission.MeetingId =$id ");
		$this->db->query("UPDATE zoom_meetings  SET is_deleted =1  WHERE zoom_meetings.meeting_id =$id ");

		if ($this->uri->segment(6) == "emp") {
			redirect('admin/zoom/listZoomMeeting_by_emp', 'refresh');
		} elseif ($this->uri->segment(6) == "last") {

			redirect('admin/zoom/last_listZoomMeeting', 'refresh');
		} else {

			redirect('admin/zoom/listZoomMeeting_by_room', 'refresh');
		}
	}
	public function end($id)
	{
		$data = [
			"action" => 'end',

		];

		//		print_r( json_encode($data))
		$token = $this->zoom_token;
		$curl = curl_init();
		$room_url = 'https://api.zoom.us/v2/meetings/' . $id . '/status';
		curl_setopt_array($curl, array(
			CURLOPT_URL => $room_url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($data),
			CURLOPT_HTTPHEADER => array(
				"Authorization:Bearer" . $token,
				"Content-Type:application/json",
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		print_r($response);
		die;
		//  redirect('admin/zoom/listZoomMeeting','refresh');
	}
	public function attend($id)
	{
		if (!$this->session->userdata('id')) {
			redirect('home/login');
		}
		$token = $this->zoom_token;
		//   $token=$this->zoom_token;

		$curl_h = curl_init('https://api.zoom.us/v2/meetings/' . $id);
		curl_setopt(
			$curl_h,
			CURLOPT_HTTPHEADER,
			array(
				"Authorization:Bearer" . $token,
			)
		);

		curl_setopt($curl_h, CURLOPT_RETURNTRANSFER, true);
		$response = json_decode(curl_exec($curl_h));
		$Data['get_All'] = $response;
		if ($this->session->userdata('type') == 'U') {
			$metting_id = (string) $this->uri->segment(4);
			$idContact = (int) $this->session->userdata('id');

			$Data['first_view'] = true;
			$DataInsert = array(
				'contact_id'         => $idContact,
				'meeting_id'         => $metting_id,
				// 			'type'           => 2
			);
			$this->db->insert('send_box_zoom', $DataInsert);
		}
		$this->load->view('admin/attend', $Data);
	}




	public function Zoom_post()
	{

		$Timezone = $this->setting_model->converToTimezone();
		$date1 = date("Y-m-d\TH:i:s\Z", strtotime($this->input->post('start_time')));
		$date = date("Y-m-d\TH:i:s", strtotime($this->input->post('start_time')));
		$this->input->post('level');
		$levels = explode("/", $this->input->post('level'));
		$levele_ID = $levels[0];
		$levele_name = $levels[1];

		$RowLevels = explode("/", $this->input->post('RowLevel'));
		$RowLevele_ID = $RowLevels[0];
		$RowLevele_name = $RowLevels[1];


		$Subjects = explode("/", $this->input->post('Subject'));
		$Subject_ID = $Subjects[0];
		$Subject_name = $Subjects[1];
		$topic_name = filter_var($this->input->post('topic'), FILTER_SANITIZE_STRING);
		if ($RowLevele_name) {
			$topic = $topic_name . ' / ' . $RowLevele_name . ' / ' . $Subject_name;
		} else {
			$topic = $topic_name;
		}

		$type = $this->input->post('type');
		if ($this->input->post('repeat') != '') {
			$type = 8;

			$day = date('D', strtotime($date1));
			if ($day == 'Sun') {
				$weekly_days = '1';
			} elseif ($day == 'Mon') {
				$weekly_days = '2';
			} elseif ($day == 'Tue') {
				$weekly_days = '3';
			} elseif ($day == 'Wed') {
				$weekly_days = '4';
			} elseif ($day == 'Thu') {
				$weekly_days = '5';
			} elseif ($day == 'Fri') {
				$weekly_days = '6';
			} elseif ($day == 'Sat') {
				$weekly_days = '7';
			}


			if ($this->input->post('repeat') == 1) {
				$meeting_data = [
					"topic" => $topic,
					"type" => $type,
					"start_time" => $date,
					"duration" => $this->input->post('duration'),
					"schedule_for" => $this->input->post('schedule_for'),
					"timezone" => $this->input->post('timezone'),
					"password" => $this->input->post('password'),
					"agenda" => $this->input->post('teacherid'),
					"recurrence" => [
						"type" => $this->input->post('repeat'),
						"repeat_interval" => 1,
						"end_times" => 7,
					],
					"levele_ID" => $levele_ID,
					"RowLevele_ID" => $RowLevele_ID,
					"Subject_ID" => $Subject_ID,
					"teacherid" => $this->input->post('teacherid'),
					"group_id" => $this->input->post('group_id'),
					"external_link" => $this->input->post('external_link'),


				];
			} else if ($this->input->post('repeat') == 2) {
				$meeting_data = [
					"topic" => $topic,
					"type" => $type,
					"start_time" => $date,
					"duration" => $this->input->post('duration'),
					"schedule_for" => $this->input->post('schedule_for'),
					"timezone" => $this->input->post('timezone'),
					"password" => $this->input->post('password'),
					"agenda" => $this->input->post('agenda'),
					"recurrence" => [
						"type" => $this->input->post('repeat'),
						"repeat_interval" => 1,
						"end_times" => $this->input->post('repeat_count'),
						"weekly_days" => $weekly_days,
					],
					"levele_ID" => $levele_ID,
					"RowLevele_ID" => $RowLevele_ID,
					"Subject_ID" => $Subject_ID,
					"teacherid" => $this->input->post('teacherid'),
					"group_id" => $this->input->post('group_id'),
					"external_link" => $this->input->post('external_link'),


				]; // "end_times" => 7,  
			} else if ($this->input->post('repeat') == 3) {
				$meeting_data = [
					"topic" => $topic,
					"type" => $type,
					"start_time" => $date,
					"duration" => $this->input->post('duration'),
					"schedule_for" => $this->input->post('schedule_for'),
					"timezone" => $this->input->post('timezone'),
					"password" => $this->input->post('password'),
					"agenda" => $this->input->post('agenda'),
					"recurrence" => [
						"type" => $this->input->post('repeat'),
						"repeat_interval" => 3,
						"end_times" => 7,
					],
					"levele_ID" => $levele_ID,
					"RowLevele_ID" => $RowLevele_ID,
					"Subject_ID" => $Subject_ID,
					"teacherid" => $this->input->post('teacherid'),
					"group_id" => $this->input->post('group_id'),
					"external_link" => $this->input->post('external_link'),


				];
			}
		} else {
			$meeting_data = [
				"topic" => $topic,
				"type" => $type,
				"start_time" => $date,
				"duration" => $this->input->post('duration'),
				"schedule_for" => $this->input->post('schedule_for'),
				"timezone" => $this->input->post('timezone'),
				"password" => $this->input->post('password'),
				"agenda" => $this->input->post('agenda'),
				"levele_ID" => $levele_ID,
				"RowLevele_ID" => $RowLevele_ID,
				"Subject_ID" => $Subject_ID,
				"teacherid" => $this->input->post('teacherid'),
				"group_id" => $this->input->post('group_id'),
				"external_link" => $this->input->post('external_link'),

			];
		}


		$room1 = $this->input->post('room');
		$room = explode(',', $room1);
		$token = $this->zoom_token;
		$duration = $this->input->post('duration');
		$token = $this->zoom_token;
		$group_id = $this->input->post('group_id');
		$teacherid = $this->input->post('teacherid');
		$end_time = ".(DATE_ADD(
                      zoom_meetings.start_time,
                       INTERVAL zoom_meetings.duration MINUTE
                              )).";

		$query_room = $this->db->query("SELECT zoom_meetings.id ,zoom_meetings.start_time,(
                      DATE_ADD(
                      zoom_meetings.start_time,
                       INTERVAL zoom_meetings.duration MINUTE
                              ))as end_time,zoom_meetings.teacherid as teacherid,zoom_meetings.group_id,zoom_meetings.room_id
                       FROM
                          zoom_meetings
                       WHERE
                      room_id = '$room[1]'
                      AND zoom_meetings.is_deleted != 1 
                      AND  (('$date' BETWEEN start_time AND(DATE_ADD(zoom_meetings.start_time,INTERVAL zoom_meetings.duration MINUTE)))
                      OR ('$date'<=start_time AND (DATE_ADD('$date',INTERVAL $duration MINUTE))BETWEEN start_time AND(DATE_ADD(zoom_meetings.start_time,INTERVAL zoom_meetings.duration MINUTE))) 
                      OR ('$date'<=start_time AND (DATE_ADD('$date',INTERVAL $duration MINUTE)>=(DATE_ADD(zoom_meetings.start_time,INTERVAL zoom_meetings.duration MINUTE))))
                      )  LIMIT 1 ")->row_array();
		$query_group = $this->db->query("SELECT zoom_meetings.id ,zoom_meetings.start_time,(
                      DATE_ADD(
                      zoom_meetings.start_time,
                       INTERVAL zoom_meetings.duration MINUTE
                              ))as end_time,zoom_meetings.teacherid as teacherid,zoom_meetings.group_id,zoom_meetings.room_id
                       FROM
                          zoom_meetings
                       WHERE
                      group_id = $group_id
                      AND zoom_meetings.is_deleted != 1 
                      AND  (('$date' BETWEEN start_time AND(DATE_ADD(zoom_meetings.start_time,INTERVAL zoom_meetings.duration MINUTE)))
                      OR ('$date'<=start_time AND (DATE_ADD('$date',INTERVAL $duration MINUTE))BETWEEN start_time AND(DATE_ADD(zoom_meetings.start_time,INTERVAL zoom_meetings.duration MINUTE))) 
                      OR ('$date'<=start_time AND (DATE_ADD('$date',INTERVAL $duration MINUTE)>=(DATE_ADD(zoom_meetings.start_time,INTERVAL zoom_meetings.duration MINUTE))))
                      )  LIMIT 1 ")->row_array();
		$query_teacher = $this->db->query("SELECT zoom_meetings.id ,zoom_meetings.start_time,(
                      DATE_ADD(
                      zoom_meetings.start_time,
                       INTERVAL zoom_meetings.duration MINUTE
                              ))as end_time,zoom_meetings.teacherid as teacherid,zoom_meetings.group_id,zoom_meetings.room_id
                       FROM
                          zoom_meetings
                       WHERE
                      teacherid = $teacherid
                      AND zoom_meetings.is_deleted != 1 
                      AND  (('$date' BETWEEN start_time AND(DATE_ADD(zoom_meetings.start_time,INTERVAL zoom_meetings.duration MINUTE)))
                      OR ('$date'<=start_time AND (DATE_ADD('$date',INTERVAL $duration MINUTE))BETWEEN start_time AND(DATE_ADD(zoom_meetings.start_time,INTERVAL zoom_meetings.duration MINUTE))) 
                      OR ('$date'<=start_time AND (DATE_ADD('$date',INTERVAL $duration MINUTE)>=(DATE_ADD(zoom_meetings.start_time,INTERVAL zoom_meetings.duration MINUTE))))
                      )  LIMIT 1 ")->row_array();
		if (empty($query_room)) {
			if (empty($query_group)) {
				if (empty($query_teacher)) {
					$meeting_result = $this->Zoom_Create($room[0], $meeting_data);
					if (!$meeting_result->id) {
						$this->session->set_flashdata('Failuer', lang('br_parent_error'));
						redirect('admin/zoom/add_new_meeting/-2', 'refresh');
					} else {
						$meetingId = $meeting_result->id;
						$start_url = $meeting_result->start_url;
						$join_url = $meeting_result->join_url;
						$uuid = $meeting_result->uuid;
						$zoom_id = $this->input->post('meeting_id');

						$occurrences = $meeting_result->{occurrences};

						$occurrence_id1 =	$occurrences[0]->{'occurrence_id'};


						$this->zoom_model->add_zoom_meetings($meeting_data, $meetingId, $room[0], $room[1], $start_url, $join_url, $occurrence_id1, $uuid, $Timezone);

						$date_notify = date("Y-m-d H:i", strtotime($this->input->post('start_time')));
						$NotifyMessage = array(
							'message' => 'قام احد  المسئولين بإضافتك لجلسة إفتراضية جديدة بموعد ' . $date_notify,
							'title' => 'إشعار  لجلسة أفتراضيه جديده '
						);

						$this->load->library('ci_pusher');
						$pusher = $this->ci_pusher->get_pusher();
						$get_student = $this->zoom_model->get_student_new($_POST['group_id']);
						$pusher->trigger($_SERVER['SERVER_NAME'] . 'Zoom' . $_POST['group_id'], 'AddZoom', $NotifyMessage);
						if ($this->input->post('repeat') == 2) {
							$token = $this->zoom_token;
							$curl_h = curl_init("https://api.zoom.us/v2/meetings/$meetingId");
							curl_setopt(
								$curl_h,
								CURLOPT_HTTPHEADER,
								array(
									"Authorization:Bearer" . $token,
								)
							);

							curl_setopt($curl_h, CURLOPT_RETURNTRANSFER, true);
							$response = json_decode(curl_exec($curl_h));

							$occurrences = $response->{occurrences};
							$time_st=$this->db->query("select ST from school_details ")->row_array()['ST'];
							$st=explode(":",$time_st)[0];
							foreach ($occurrences as $k => $occurrence_id) {
								$new_date = date("Y-m-d H:i:s", strtotime("$st hours", strtotime($occurrence_id->start_time)));

								$meeting_data = [
									"topic" => $topic,
									"type" => $type,
									"start_time" => $new_date,
									"duration" => $this->input->post('duration'),
									"schedule_for" => $this->input->post('schedule_for'),
									"timezone" => $this->input->post('timezone'),
									"password" => $this->input->post('password'),
									"agenda" => $this->input->post('agenda'),
									"recurrence" => [
										"type" => $this->input->post('repeat'),
										"repeat_interval" => 1,
										"end_times" => $this->input->post('repeat_count'),
										"occurrence_id" => $occurrence_id->occurrence_id,
										"weekly_days" => $weekly_days,
									],
									"levele_ID" => $levele_ID,
									"RowLevele_ID" => $RowLevele_ID,
									"Subject_ID" => $Subject_ID,
									"teacherid" => $this->input->post('teacherid'),
									"group_id" => $this->input->post('group_id'),

								];
								$occurrence_id1 =	$occurrence_id->occurrence_id;

								if (date('m/d/Y', strtotime($occurrence_id->start_time)) != date('m/d/Y', strtotime($date))) {
									// print_r($meeting_data);die;

									$this->zoom_model->add_zoom_meetings($meeting_data, $meetingId, $room[0], $room[1], $start_url, $join_url, $occurrence_id1, $uuid, $Timezone);
									$this->session->set_flashdata('Sucsess', lang('br_add_suc'));
								}
							}
						}


						///end repeat
						$this->session->set_flashdata('Sucsess', lang('br_add_suc'));
						if ($RowLevele_name || $Subject_name) {
							redirect('admin/zoom/add_new_meeting/-1', 'refresh');
						} else {
							redirect('admin/zoom/add_meeting', 'refresh');
						}
					}
				} else {
					redirect('admin/zoom/add_new_meeting/3/' . $query_teacher['start_time'] . "/" . $query_teacher['end_time'] . "/" . $query_teacher['teacherid'] . "/" . $query_teacher['group_id'] . "/" . $query_teacher['room_id'], 'refresh');
				}
			} else {
				redirect('admin/zoom/add_new_meeting/2/' . $query_group['start_time'] . "/" . $query_group['end_time'] . "/" . $query_group['teacherid'] . "/" . $query_group['group_id'] . "/" . $query_group['room_id'], 'refresh');
			}
		} else {
			redirect('admin/zoom/add_new_meeting/1/' . $query_room['start_time'] . "/" . $query_room['end_time'] . "/" . $query_room['teacherid'] . "/" . $query_room['group_id'] . "/" . $query_room['room_id'], 'refresh');
		}
	}
	public function Zoom_post1()
	{
		$date1 = date("Y-m-d\TH:i:s\Z", strtotime($this->input->post('start_time')));
		$date = date("Y-m-d\TH:i:s", strtotime($this->input->post('start_time')));
		$this->input->post('level');
		$levels = explode("/", $this->input->post('level'));
		$levele_ID = $levels[0];
		$levele_name = $levels[1];

		$RowLevels = explode("/", $this->input->post('RowLevel'));
		$RowLevele_ID = $RowLevels[0];
		$RowLevele_name = $RowLevels[1];


		$Subjects = explode("/", $this->input->post('Subject'));
		$Subject_ID = $Subjects[0];
		$Subject_name = $Subjects[1];
		$topic  = $this->input->post('topic') . ' / ' . $RowLevele_name . ' / ' . $Subject_name;
		//print_r( $topic );die;
		$type = $this->input->post('type');
		if ($this->input->post('repeat') != '') {
			$type = 8;

			$day = date('D', strtotime($date1));
			if ($day == 'Sun') {
				$weekly_days = '1';
			} elseif ($day == 'Mon') {
				$weekly_days = '2';
			} elseif ($day == 'Tue') {
				$weekly_days = '3';
			} elseif ($day == 'Wed') {
				$weekly_days = '4';
			} elseif ($day == 'Thu') {
				$weekly_days = '5';
			} elseif ($day == 'Fri') {
				$weekly_days = '6';
			} elseif ($day == 'Sat') {
				$weekly_days = '7';
			}


			if ($this->input->post('repeat') == 1) {
				$meeting_data = [
					"topic" => $topic,
					"type" => $type,
					"start_time" => $date,
					"duration" => $this->input->post('duration'),
					"schedule_for" => $this->input->post('schedule_for'),
					"timezone" => $this->input->post('timezone'),
					"password" => $this->input->post('password'),
					"agenda" => $this->input->post('teacherid'),
					"recurrence" => [
						"type" => $this->input->post('repeat'),
						"repeat_interval" => 1,
						"end_times" => 7,
					],
					"levele_ID" => $levele_ID,
					"RowLevele_ID" => $RowLevele_ID,
					"Subject_ID" => $Subject_ID,
					"teacherid" => $this->input->post('teacherid'),
					"group_id" => $this->input->post('group_id'),


				];
			} else if ($this->input->post('repeat') == 2) {
				$meeting_data = [
					"topic" => $topic,
					"type" => $type,
					"start_time" => $date,
					"duration" => $this->input->post('duration'),
					"schedule_for" => $this->input->post('schedule_for'),
					"timezone" => $this->input->post('timezone'),
					"password" => $this->input->post('password'),
					"agenda" => $this->input->post('agenda'),
					"recurrence" => [
						"type" => $this->input->post('repeat'),
						"repeat_interval" => 1,
						"end_times" => $this->input->post('repeat_count'),
						"weekly_days" => $weekly_days,
					],
					"levele_ID" => $levele_ID,
					"RowLevele_ID" => $RowLevele_ID,
					"Subject_ID" => $Subject_ID,
					"teacherid" => $this->input->post('teacherid'),
					"group_id" => $this->input->post('group_id'),


				]; // "end_times" => 7,  
			} else if ($this->input->post('repeat') == 3) {
				$meeting_data = [
					"topic" => $topic,
					"type" => $type,
					"start_time" => $date,
					"duration" => $this->input->post('duration'),
					"schedule_for" => $this->input->post('schedule_for'),
					"timezone" => $this->input->post('timezone'),
					"password" => $this->input->post('password'),
					"agenda" => $this->input->post('agenda'),
					"recurrence" => [
						"type" => $this->input->post('repeat'),
						"repeat_interval" => 3,
						"end_times" => 7,
					],
					"levele_ID" => $levele_ID,
					"RowLevele_ID" => $RowLevele_ID,
					"Subject_ID" => $Subject_ID,
					"teacherid" => $this->input->post('teacherid'),
					"group_id" => $this->input->post('group_id'),


				];
			}
		} else {
			$meeting_data = [
				"topic" => $topic,
				"type" => $type,
				"start_time" => $date,
				"duration" => $this->input->post('duration'),
				"schedule_for" => $this->input->post('schedule_for'),
				"timezone" => $this->input->post('timezone'),
				"password" => $this->input->post('password'),
				"agenda" => $this->input->post('agenda'),
				"levele_ID" => $levele_ID,
				"RowLevele_ID" => $RowLevele_ID,
				"Subject_ID" => $Subject_ID,
				"teacherid" => $this->input->post('teacherid'),
				"group_id" => $this->input->post('group_id'),

			];
		}



		//   "recurrence": {
		//     "type": "integer",
		//     "repeat_interval": "integer",
		//     "weekly_days": "string",
		//     "monthly_day": "integer",
		//     "monthly_week": "integer",
		//     "monthly_week_day": "integer",
		//     "end_times": "integer",
		//     "end_date_time": "string [date-time]"
		//   },


		$room = $this->input->post('room');
		//get room 
		$token = $this->zoom_token;
		/*     $curl_h = curl_init('https://api.zoom.us/v2/users/'.$room.'/meetings?type=upcoming');
             curl_setopt($curl_h, CURLOPT_HTTPHEADER,
            array(
               "Authorization:Bearer".$token,
              )
             );
        
        curl_setopt($curl_h, CURLOPT_RETURNTRANSFER, true);
        $response =  json_decode(json_encode(curl_exec($curl_h)), true); 
        
        $obj = json_decode($response);
        
           foreach ($obj->{'meetings'} as $rooms) {
                
                 //zoom meeting
                $meeting_time=   new DateTime($rooms->{'start_time'});
                $start_meeting=  $meeting_time->format('Y-m-d H:i');
                $minutes_to_add = $rooms->{'duration'};
                $time = new DateTime($rooms->{'start_time'});
                $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
                $end_meeting = $time->format('Y-m-d H:i'); 
                //zoom meeting
                 //post meeting
                $post_meeting_time=   new DateTime($this->input->post('start_time'));
                $post_start_meeting=  $post_meeting_time->format('Y-m-d H:i');
                $post_minutes_to_add = $this->input->post('duration');
                $post_time = new DateTime($this->input->post('start_time'));
                $post_time->add(new DateInterval('PT' . $post_minutes_to_add . 'M'));
                $post_end_meeting = $post_time->format('Y-m-d H:i'); 
                //post meeting
             //   echo  $start_meeting.'/'.$end_meeting.'<br>';
             //   echo  $post_start_meeting.'/'.$post_end_meeting.'<br>';
             //   echo '<br>';   echo '<br>';
             */
		/*  if ($post_start_meeting >= $start_meeting && $post_start_meeting <= $end_meeting){	$this->session->set_userdata('cantadd' ,'لا يمكنك إضافة فصل فى هذا الموعد '
   );  redirect('admin/zoom/listZoomMeeting', 'refresh');die;} 
   elseif ($post_end_meeting >= $start_meeting && $post_end_meeting <= $end_meeting){	$this->session->set_userdata('cantadd' ,'لا يمكنك إضافة فصل فى هذا الموعد') ;
         redirect('admin/zoom/listZoomMeeting', 'refresh');die;
   }  */

		/*    }
         */
		/////////////


		$meeting_result = $this->Zoom_Create($room, $meeting_data);
		//	print_r($meeting_result);die;
		//	print_r($meeting_result);die;
		if (!$meeting_result->id) {
			$this->session->set_flashdata('Failuer', lang('br_parent_error'));
			redirect('admin/zoom/listZoomMeeting', 'refresh');
		} else {
			$meetingId = $meeting_result->id;
			$start_url = $meeting_result->start_url;
			$join_url = $meeting_result->join_url;
			$zoom_id = $this->input->post('meeting_id');
			// $this->db->query("UPDATE zoom_premission  SET MeetingId =$meetingId  WHERE zoom_premission.ID =$zoom_id "); 

			//	  print_r($meeting_result);echo '<br><br><br>';
			//	   print_r($meeting_result);echo '<br><br><br>';//die;
			$occurrences = $meeting_result->{occurrences};
			//  $occurrence_id1=	'' ;  
			//  print_r($occurrences[0]->{'occurrence_id'});die;
			$occurrence_id1 =	$occurrences[0]->{'occurrence_id'};
			//echo $this->input->post('start_time');echo $occurrence_id->start_time;
			//  echo   $occurrence_id1;die;

			$this->zoom_model->add_zoom_meetings($meeting_data, $meetingId, $room, $start_url, $join_url, $occurrence_id1, '');

			///startrepeat

			if ($this->input->post('repeat') == 2) {
				$token = $this->zoom_token;
				$curl_h = curl_init("https://api.zoom.us/v2/meetings/$meetingId");
				curl_setopt(
					$curl_h,
					CURLOPT_HTTPHEADER,
					array(
						"Authorization:Bearer" . $token,
					)
				);

				curl_setopt($curl_h, CURLOPT_RETURNTRANSFER, true);
				$response = json_decode(curl_exec($curl_h));
				//   echo '<br>';
				//  print_r($response->{occurrences});  
				$occurrences = $response->{occurrences};
				foreach ($occurrences as $k => $occurrence_id) {
					// echo   $id1=$id->start_time;
					// echo   $id1=$id->occurrence_id;

					$meeting_data = [
						"topic" => $topic,
						"type" => $type,
						"start_time" => $occurrence_id->start_time,
						"duration" => $this->input->post('duration'),
						"schedule_for" => $this->input->post('schedule_for'),
						"timezone" => $this->input->post('timezone'),
						"password" => $this->input->post('password'),
						"agenda" => $this->input->post('agenda'),
						"recurrence" => [
							"type" => $this->input->post('repeat'),
							"repeat_interval" => 1,
							"end_times" => $this->input->post('repeat_count'),
							"occurrence_id" => $occurrence_id->occurrence_id,
							"weekly_days" => $weekly_days,
						],
						"levele_ID" => $levele_ID,
						"RowLevele_ID" => $RowLevele_ID,
						"Subject_ID" => $Subject_ID,
						"teacherid" => $this->input->post('teacherid'),
						"group_id" => $this->input->post('group_id'),
					];
					$occurrence_id1 =	$occurrence_id->occurrence_id;
					//	$start_url=	$occurrence_id->start_url;

					//   print_r($meeting_data);echo '<br>';echo  $occurrence_id->occurrence_id ;echo '<br>';echo  $occurrence_id->start_time ;echo '<br><br>///////////////////////////////////////////////////////<br>';
					if ($occurrence_id->start_time != $date) {


						$this->zoom_model->add_zoom_meetings($meeting_data, $meetingId, $room, $start_url, $join_url, $occurrence_id1, '');
						$this->session->set_flashdata('Sucsess', lang('br_add_suc'));
					}
				}
			}


			///end repeat
			$this->session->set_flashdata('Sucsess', lang('br_add_suc'));

			redirect('admin/zoom/add_new_meeting', 'refresh');
		}
	}


	private function Zoom_Create($room, $data)
	{

		//  print_r(json_encode($data));die;
		if ($room == "") {
			$room = 'info@diwan-language-school.com';
		}

		$token = $this->zoom_token;

		//   $token=$this->zoom_token;
		//  $token=$this->zoom_token;

		array_walk($data, function (&$item) {
			if (empty($item) && $item !== false) {
				$item = '';
			}
		});
		$curl = curl_init();
		$room_url = 'https://api.zoom.us/v2/users/' . $room . '/meetings';
		curl_setopt_array($curl, array(
			CURLOPT_URL => $room_url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($data),
			CURLOPT_HTTPHEADER => array(
				"Authorization:Bearer" . $token,
				"Content-Type:application/json",
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		return json_decode($response);
	}

	public function get_emp_rooms()
	{
		$EmpID   = $this->input->post('teacherid');
		$emp_rooms =  $this->zoom_model->get_emp_rooms11($EmpID);
		$this->output->set_content_type('application/json')->set_output(json_encode($emp_rooms));
	}

	public function delete_zoom_by_room($Name = "NULL", $NumberID = "NULL")
	{
		$Data['get_employee'] = "NULL";
		if (($Name != "NULL") || ($NumberID != "NULL")) {
			$Data['get_employee']     = $this->employee_model->get_employee_admin($Name, $NumberID);
			$Data['Name']            = $Name;
			$Data['NumberID']            = $NumberID;
		}
		$this->load->admin_template('view_employee_for_zoom', $Data);
	}
	public function employee($Name = "NULL", $NumberID = "NULL")
	{
		if ($this->uri->segment(4) == 'show') {

			$Data['get_employee']     = $this->employee_model->get_employee($Data);
			$Data['Name']             = '';
			$Data['NumberID']            = '';
		} else {
			$Data['get_employee'] = "NULL";
			$Name = filter_var($this->security->xss_clean($Name), FILTER_SANITIZE_STRING);

			if (($Name != "NULL") || ($NumberID != "NULL")) {
				$Data['get_employee']     = $this->employee_model->get_employee_admin_zoom($Name);
				// 			print_r($this->db->last_query());die;
				$Data['Name']            = $Name;
				$Data['NumberID']            = $NumberID;
			}
		}
		$this->load->admin_template('view_employee_for_zoom', $Data);
	}


	public function edit_employee_rooms($ID = NULL)
	{
		$Data = array();
		$Data['GetJobTitle']        = $this->employee_model->get_job_title($this->data['Lang']);
		$Data['GetLevel']         = $this->employee_model->get_level();
		//	$Data['get_employee']       = $this->employee_model->get_employee_edit($Token);
		$Data['get_employee']       = $this->employee_model->get_employee_edit($ID);
		$Data['GetAllPer']       = $this->employee_model->get_group();
		$Data['rooms'] = $this->zoom_model->get_rooms_by_schoolid();
		$Data['emp_rooms'] = $this->zoom_model->get_emp_rooms($ID);
		//   print_r( $Data['emp_rooms']);
		//   die();

		if (is_array($Data['get_employee'])) {
			$this->load->admin_template('zoom_room_employee', $Data);
		} else {
			exit('Error 5462310');
		}
	}
	public function add_room_employee()
	{
		$this->data['name']         = $this->input->post('name1');
		$this->data['type']         = $this->input->post('type');
		$this->data['empid']         = $this->input->post('empid');
		$this->data['emp_rooms']         = $this->input->post('rooms');



		// $Data['rooms'] = $this->zoom_model->get_rooms();
		// $Data['emp_rooms'] = $this->zoom_model->get_emp_rooms($ID);


		if ($this->zoom_model->add_emp_rooms($this->data)) {


			$this->session->set_flashdata('SuccessAdd', lang('br_add_suc'));
		} else {

			$this->session->set_flashdata('ErrorAdd', lang('br_add_error'));
		}
		$n = urldecode($this->data['name']);

		$url = 'admin/zoom/employee';
		redirect($url, 'refresh');
	}
	public function add_new_meeting()
	{


		$rowlevel  = get_rowlevel_select_in();
		$subject  = get_subject_select_in();
		$emp       = get_emp_select_in();
		if (!$this->session->userdata('id')) {
			redirect('home/login');
		}
		$Data['GetEmp'] =  $this->zoom_model->get_emp_per();
		$Data['GetRowLevel'] =  $this->zoom_model->getRowLevel_per($rowlevel);
		$Data['getSubject'] =  $this->zoom_model->getSubject_per($subject);

		$Data['rooms'] = $this->zoom_model->get_rooms_by_schoolid();
		$Data['GetPermission'] = $this->zoom_model->get_permission();
		$this->load->admin_template('add_new_meeting', $Data);
	}
	public function add_meeting()
	{
		// print_r(NOW());die;
		$rowlevel  = get_rowlevel_select_in();
		$subject  = get_subject_select_in();
		$emp       = get_emp_select_in();
		if (!$this->session->userdata('id')) {
			redirect('home/login');
		}
		$Data['GetEmp'] =  $this->zoom_model->get_emp_per();
		$Data['GetRowLevel'] =  $this->zoom_model->getRowLevel_per($rowlevel);
		$Data['getSubject'] =  $this->zoom_model->getSubject_per($subject);

		$Data['rooms'] = $this->zoom_model->get_rooms_by_schoolid();
		$Data['GetPermission'] = $this->zoom_model->get_permission();
		$this->load->admin_template('view_add_meeting', $Data);
	}
	public function MeetingAttendDetails_Report()
	{
		$Data['Lang']           = $this->session->userdata('language');
		$Data['DayDateFrom']  = $DayDateFrom = $this->input->post('from_time');
		$Data['DayDateTo']    = $DayDateTo = $this->input->post('to_time');

		$Data['student_id']   = $student_id=$this->uri->segment(4) ;
		//print_r($Data['student_id'] );die;
		if($student_id){
			$stu_data = $this->db->query("SELECT student.Class_ID  , student.R_L_ID , row_level.Level_ID  FROM student  
															inner join row_level on row_level.ID = student.R_L_ID
															WHERE Contact_ID  = '".$student_id."' ")->row_array();
			$Data['RowLevel']     =  $rowlevel  =  $stu_data['R_L_ID']; 
			$Data['level']        =  $level     =  $stu_data['Level_ID'];  
			$Data['Class']        =  $class     = $stu_data['Class_ID']; 
			$Data['get_Subject']    = $this->students_affairs_model->get_subject_per_row_level_class($rowlevel ,$class);
			
			//print_r($Data['Class']    );die;
			}else{
			$Data['RowLevel']     = $rowlevel  = $this->input->post('RowLevel');   //  echo '2<br>';
			$Data['level']        = $level = $this->input->post('level');    //  echo '3<br>';
			$Data['Class']        = $class  = $this->input->post('Class');
			$Data['get_Subject']  = $this->Permission_model->get_Subject1($Data['RowLevel'], $Data['Class']);
			}   // echo '5<br>';

		$SchoolID             = $this->session->userdata('SchoolID');
		$Data['type']         = $type = $this->input->post('type');
		//print_r($Data['type'] );die;
		$Data['subject']      = $subject = $this->input->post('subject');
		if ($Data['level']) {

			$Data['row_level']         = $this->report_statistical_model->get_rowlevel($Data['level']);
		}
		if ($rowlevel) {
			$Data['get_class']    = $this->report_statistical_model->getclass($rowlevel);
			
		}
		
		if ($rowlevel != '') {

			$rowlevel1 = $this->db->query(" select Row_ID  from   row_level where ID=  $rowlevel")->result_array();

			$rowlevel =	$rowlevel1[0][Row_ID];
		}

		$fromdate              = $DayDateFrom . ' 00:00:00.000000';
		$todate                = $DayDateTo . ' 23:59:59.999999';

		if ($student_id == '' && $rowlevel == '' && $level == '' && $class == '') {

			$Data['report_res'] =  '';
		} else {

			$a_procedure = "CALL `Usp_GetMeetingAttendDetails_ByStudent`(?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
			$query = $this->db->query($a_procedure, array('p0' => $student_id, 'p1' => '', 'p2' => $rowlevel, 'p3' => $level, 'p4' => $SchoolID, 'p5' => $class, 'p6' => '', 'p7' => $fromdate, 'p8' => $todate, 'p9' => '', 'p10' => $subject));
			$res      = $query->result();
			mysqli_next_result($this->db->conn_id);

			$res_details = [];

			foreach ($res as $value) {

				$MeetingId = $value->MeetingId;

				$teacher_attend = $this->db->query("SELECT `contact_id` FROM `send_box_zoom` 
                            INNER JOIN contact ON send_box_zoom.contact_id = contact.ID 
                            WHERE send_box_zoom.meeting_id = $MeetingId AND contact.Type='E' ")->row_array();
				if (empty($teacher_attend)) {
					if ($Data['Lang'] == "english") {
						$type1 = "wating";
					} else {
						$type1 = "انتظار";
					}
				} else {

					if ($Data['Lang'] == "english") {

						if ($value->MeetingAttendStatus == "حضور"  ||  ($value->MeetingAttendStatus == "تأخير" && $value->TotalLateMinutes == 0)) {

							$type1 = "Attend";
						} elseif ($value->MeetingAttendStatus == "غياب") {

							$type1   = "Absence";
						} elseif ($value->MeetingAttendStatus == "تأخير") {

							$type1   = "delay";
						} else {

							$type1 = "wating";
						}
					} else {
						if ($value->MeetingAttendStatus == "حضور"  ||  ($value->MeetingAttendStatus == "تأخير" && $value->TotalLateMinutes == 0)) {

							$type1 = "حضور";
						} elseif ($value->MeetingAttendStatus == "غياب") {

							$type1   = "غياب";
						} elseif ($value->MeetingAttendStatus == "تأخير") {

							$type1   = "تأخير";
						} else {

							$type1 = "انتظار";
						}
					}
				}
				if ($type1 === $type) {


					$res_details[] = $value;
				}
			}
			// print_r($res);die;
			if ($type == '' || $type == 'NULL') {
				$Data['report_res'] =  $res;
			} else {
				$Data['report_res'] =  $res_details; 
			}
		}

		$Data['student']      = get_student_select_in();
		$Data['GetStudent'] =  $this->zoom_model->get_all_student_per($Data['student']);

		$this->load->admin_template('MeetingAttendDetails_Report', $Data);
	}
	public function MeetingAttendDetails_amira()
	{
		$Data['student']      = get_student_select_in();
		$Data['GetStudent'] =  $this->zoom_model->get_all_student_per($Data['student']);

		$this->load->admin_template('MeetingAttendDetails_amira', $Data);
	}
	public function MeetingAttendDetails_amira1()
	{

		$config = array();
		$config["base_url"] = base_url() . "admin/zoom/MeetingAttendDetails_amira";
		$config["total_rows"] = 53;
		$config["per_page"] = $perpage = 10;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
		// print_r($page);die;
		// $offset = ($page - 1) * $perpage;
		$Data["links"] = $this->pagination->create_links();
		$Data['DayDateFrom'] = $DayDateFrom = $this->input->post('from_time');
		$Data['DayDateTo'] = $DayDateTo = $this->input->post('to_time');
		$Data['student_id'] = $student_id = (int)$this->input->post('student_id1');
		$rowlevel = $this->input->post('RowLevel');   //  echo '2<br>';
		$Data['level'] =  $level = $this->input->post('level');    //  echo '3<br>';
		$class = $this->input->post('Class');   // echo '5<br>';
		$SchoolID =   $this->session->userdata('SchoolID');
		$Data['type'] =   $type = $this->input->post('type');
		$Data['subject'] =   $subject = $this->input->post('subject');
		if ($rowlevel != '') {
			$rowlevel1 = $this->db->query(" 
        		select Row_ID  from   row_level where ID=  $rowlevel
			")->result_array();

			$rowlevel =	$rowlevel1[0][Row_ID];
		}

		$fromdate = $DayDateFrom . ' 00:00:00.000000';
		$todate = $DayDateTo . ' 23:59:59.999999';
		//print_R((int)$student_id);die;
		if ($student_id == '' && $rowlevel == '' && $level == '' && $class == '') {

			$Data['report_res'] =  '';
		} else {
			$a_procedure = "CALL `Usp_GetMeetingAttendDetails_amira`(?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?)";
			$query = $this->db->query($a_procedure, array('p0' => $student_id, 'p1' => '', 'p2' => $rowlevel, 'p3' => $level, 'p4' => $SchoolID, 'p5' => $class, 'p6' => '', 'p7' => $fromdate, 'p8' => $todate, 'p9' => '', 'p10' => $subject, 'p11' => $page, 'p12' => $perpage));
			$res      = $query->result();

			mysqli_next_result($this->db->conn_id);
			$res_details = [];
			foreach ($res as $value) {

				if ($value->MeetingAttendStatus  == $type) {
					$res_details[] = $value;
				}
			}
			if ($type == '' || $type == 'NULL') {
				$Data['report_res'] =  $res;
			} else {
				$Data['report_res'] =  $res_details;
			}
		}

		$this->load->view('admin/meetingsdetailtable.php', $Data);
	}





	/////////////////////////////////////
	//count zoom meeting for student
	public function MeetingAttendstudent_count()
	{
		$Data['DayDateFrom'] = $DayDateFrom = $this->input->post('from_time');
		$Data['DayDateTo']  = $DayDateTo = $this->input->post('to_time');
		$Data['student_id'] = $student_id = $this->input->post('student_id');
		$SchoolID           = $this->session->userdata('SchoolID');
		$fromdate = $DayDateFrom . ' 00:00:00.000000';
		$todate = $DayDateTo . ' 23:59:59.999999';

		if ($student_id == '') {
			$Data['report_res'] =  '';
		} else {
			$a_procedure = "CALL `Usp_GetMeetingAttendDetails_ByStudent`(?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
			$query = $this->db->query($a_procedure, array('p0' => $student_id, 'p1' => '', 'p2' => '', 'p3' => '', 'p4' => $SchoolID, 'p5' => '', 'p6' => '', 'p7' => $fromdate, 'p8' => $todate, 'p9' => '', 'p10' => ''));
			$res      = $query->result();

			mysqli_next_result($this->db->conn_id);
			$res_attend = [];
			$res_delay  = [];
			$res_abcent = [];



			foreach ($res as $value) {

				$MeetingStartTime  = $value->MeetingStartTime;

				$ActualAttendTime  = $value->ActualAttendTime;

				$MeetingStartTime  = date('Y-m-d H:i', strtotime($MeetingStartTime));

				$ActualAttendTime  = date('Y-m-d H:i', strtotime($ActualAttendTime));


				if ($value->MeetingAttendStatus  == "حضور" || ($value->MeetingAttendStatus  == "تأخير" && $MeetingStartTime == $ActualAttendTime)) {
					$res_attend[] = $value;
				} elseif ($value->MeetingAttendStatus  == "تأخير") {
					$res_delay[] = $value;
				} elseif ($value->MeetingAttendStatus  == "غياب") {
					$res_abcent[] = $value;
				}
			}

			$Data['report_res'] =  $res;
			$Data['attend_count'] =  count($res_attend);
			$Data['delay_count'] =  count($res_delay);
			$Data['abcent_count'] = count($res_abcent);
		}

		$Data['student']      = get_student_select_in();
		$Data['GetStudent'] =  $this->zoom_model->get_all_student_per($Data['student']);

		$this->load->admin_template('MeetingAttendstudent_count', $Data);
	}
	//count zoom meeting details for student
	public function MeetingAttendstudent_details()
	{
		$Data['student_id'] = $student_id = $this->uri->segment(5);
		$Data['DayDateFrom'] = $DayDateFrom = $this->uri->segment(6);
		$Data['DayDateTo']  = $DayDateTo = $this->uri->segment(7);
		$SchoolID           = $this->session->userdata('SchoolID');
		$fromdate = $DayDateFrom . ' 00:00:00.000000';
		$todate = $DayDateTo . ' 23:59:59.999999';

		$a_procedure = "CALL `Usp_GetMeetingAttendDetails_ByStudent`(?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
		$query = $this->db->query($a_procedure, array('p0' => $student_id, 'p1' => '', 'p2' => '', 'p3' => '', 'p4' => $SchoolID, 'p5' => '', 'p6' => '', 'p7' => $fromdate, 'p8' => $todate, 'p9' => '', 'p10' => ''));
		$res      = $query->result();

		mysqli_next_result($this->db->conn_id);
		$res_details = [];

		foreach ($res as $value) {

			$MeetingStartTime  = $value->MeetingStartTime;

			$ActualAttendTime  = $value->ActualAttendTime;

			$MeetingStartTime  = date('Y-m-d H:i', strtotime($MeetingStartTime));

			$ActualAttendTime  = date('Y-m-d H:i', strtotime($ActualAttendTime));

			if ($this->uri->segment(4) == 1 && (($value->MeetingAttendStatus == "حضور")  || ($value->MeetingAttendStatus == "تأخير" && $MeetingStartTime ==  $ActualAttendTime))) {

				$value->MeetingAttendStatus = "حضور";
			} elseif ($this->uri->segment(4) == 2 && ($value->MeetingAttendStatus == "تأخير" && $value->TotalLateMinutes !=  0)) {

				$value->MeetingAttendStatus = "تأخير";
			} elseif ($this->uri->segment(4) == 2 && ($value->MeetingAttendStatus == "تأخير" && $value->TotalLateMinutes ==  0)) {

				$value->MeetingAttendStatus = "حضور";
			} elseif ($this->uri->segment(4) == 3 && $value->MeetingAttendStatus == "غياب") {

				$value->MeetingAttendStatus = "غياب";
			}

			if ($this->uri->segment(4) == 1 && (($value->MeetingAttendStatus == "حضور")  || ($value->MeetingAttendStatus == "تأخير" && $MeetingStartTime ==  $ActualAttendTime))) {
				$type = "حضور";
			} elseif ($this->uri->segment(4) == 2 && ($value->MeetingAttendStatus == "تأخير" && $value->TotalLateMinutes ==  0)) {

				$type = "حضور";
			} elseif ($this->uri->segment(4) == 2 && ($value->MeetingAttendStatus == "تأخير" && $value->TotalLateMinutes != 0)) {
				$type = "تأخير";
			} elseif ($this->uri->segment(4) == 3  && $value->MeetingAttendStatus == "غياب") {
				$type = "غياب";
			}

			//  print_r($value->TotalLateMinutes);die;
			if ($value->MeetingAttendStatus  == $type) {
				$res_details[] = $value;
			}
		}


		$Data['report_res'] =  $res_details;

		$this->load->admin_template('MeetingAttendstudent_details', $Data);
	}
	public function Meeting_Teacher_Report()
	{
		$Data['from_time'] =  $DayDateFrom = $this->input->post('from_time');
		$Data['to_time']   = $DayDateTo = $this->input->post('to_time');
		$Data['teacher_id'] =  $teacher_id = $this->input->post('teacher_id');
		$type = $this->input->post('type');
		$fromdate = $DayDateFrom . ' 00:00:00.000000';
		$todate = $DayDateTo . ' 23:59:59.999999';


		$a_procedure = "CALL `Usp_GetMeetingAttendDetails_By_Teacher`(?, ?, ?)";
		$query = $this->db->query($a_procedure, array('p0' => $fromdate, 'p1' => $todate, 'p2' => $teacher_id));
		$res      = $query->result();
		mysqli_next_result($this->db->conn_id);
		$status = [];

		foreach ($res as $value) {

			if ($value->MeetingAttendStatus  == $type) {
				$status[] = $value;
			}
		}
		if ($type == '' || $type == 'NULL') {
			$Data['report_res'] =  $res;
		} else {
			$Data['report_res'] =  $status;
		}

		$Data['GetTeacher'] =  $this->zoom_model->get_emp_per();
		$Data['teacher'] = $teacher_id;
		$Data['DayDateFrom'] = $DayDateFrom;
		$Data['DayDateTo'] = $DayDateTo;

		$this->load->admin_template('Meeting_Teacher_Report', $Data);
	}
	////////////////
    public function Meeting_Teacher_Report_attendence(){
		$Data['type']   =  $this->uri->segment(4);
		$Data['zoomId'] =  $this->uri->segment(5);
		$Data['meet']   =  $this->uri->segment(6);
		$Data['Data']   =  $this->zoom_model->Meeting_Teacher_Report_attendence($Data);
		$this->load->admin_template('Meeting_Teacher_Report_attendence', $Data);
	}
	////////////////////////////////
	public function listZoomMeeting_by_emp()
	{
		$this->session->set_userdata('referred_from', current_url());
		$Data['date'] = $this->setting_model->converToTimezone();
		if (!$this->session->userdata('id')) {
			redirect('home/login');
		}
		$DayDateFrom = $this->input->post('from_time');
		$DayDateTo = $this->input->post('to_time');
		$Data['GetEmp'] =  $this->zoom_model->get_emp_per();
		if (isset($_POST['emp']) || isset($_POST['from_time']) || isset($_POST['to_time'])) {
			$emp = $_POST['emp'];
			$date = $_POST['start_time'];
			$types = $this->session->userdata('type');
			if ($types == "U" || $types == "E") {
				$ids = $this->zoom_model->Get_mettingids_by_emp_date($emp, $DayDateFrom, $DayDateTo);
				$Data['get_All'] = $ids;
			}

			$Data['GetPermission'] = $this->zoom_model->get_permission();
		}


		$this->load->admin_template('list_Zoom_Meeting_by_emp', $Data);
	}



	public function MeetingAttendStudents_Report()
	{
		$DayDateFrom = $this->input->post('DayDateFrom');
		$DayDateTo = $this->input->post('DayDateTo');
		$rowlevel = $this->input->post('RowLevel');
		$level = $this->input->post('level');
		$class = $this->input->post('Class');
		$SchoolID =   $this->session->userdata('SchoolID');
		if ($rowlevel != '') {
			$rowlevel1 = $this->db->query(" 
        		select Row_ID  from   row_level where ID=  $rowlevel
			")->result_array();

			$rowlevel =	$rowlevel1[0][Row_ID];
		}
		$Data['data']  = $this->zoom_model->get_attend_students($level, $rowlevel, $class, $DayDateFrom, $DayDateTo);
		$this->load->model(array('evaluation/evaluation_model'));
		$Data['rowlevels'] 	= $this->evaluation_model->getRowLevel();

		$Data['levels'] 		= $this->evaluation_model->getLevels();

		$Data['classes']		= $this->evaluation_model->getClasses();

		$this->load->admin_template('MeetingAttendStudents_Report', $Data);
	}

	/////////////////////////////////////

	// public function update_uuid(){

	//     $meeting_id=$this->db->query("select meeting_id from zoom_meetings  GROUP BY meeting_id  HAVING count(meeting_id)>1")->result();

	//      $token=$this->zoom_token;
	// 	      foreach($meeting_id as $k=>$id){
	// 	    $meet_id=$k->meeting_id;

	// 	     $curl_h = curl_init('https://api.zoom.us/v2/past_meetings/'.$meet_id.'/instances');
	//         curl_setopt($curl_h, CURLOPT_HTTPHEADER,
	//             array(
	//               "Authorization:Bearer".$token,
	//             )
	//         );

	//         curl_setopt($curl_h, CURLOPT_RETURNTRANSFER, true);
	//         $response =json_decode(curl_exec($curl_h));
	//       // print_r($response->meetings);die;
	//          if(!empty($response->meetings)){
	//          foreach($response->meetings as $row){
	//             $uuid= $row->uuid;
	//             $start_time= $row->start_time;
	//             $newDate = date("Y-m-d", strtotime($start_time));  
	//             if( $this->db->query("update zoom_meetings set uuid='$uuid' where '$newDate'=date(start_time) and meeting_id=$meet_id  ")){
	//                 echo "updated";
	//             }
	//          }  
	//          }

	// 	      }



	// }
	public function user_attend($id, $zoom_id, $endTime)
	{

		if (!$this->session->userdata('id')) {
			redirect('home/login');
		}
		if (!$this->session->userdata('id')) {
			redirect('zoom');
		}
		$date = $this->setting_model->converToTimezone();
		$en_time = str_replace('%20', ' ', $endTime);
		if ($en_time < $date) {
			redirect('admin/zoom/last_listZoomMeeting/', 'refresh');
		}


		$token = $this->zoom_token;
		$curl_h = curl_init('https://api.zoom.us/v2/meetings/' . $id);
		curl_setopt(
			$curl_h,
			CURLOPT_HTTPHEADER,
			array(
				"Authorization:Bearer" . $token,
			)
		);

		curl_setopt($curl_h, CURLOPT_RETURNTRANSFER, true);
		$response = json_decode(curl_exec($curl_h));
		$this->GetUserID($response->host_email);

		$obj = json_decode($response);
		$Data['get_All'] = $response;
		$idContact = (int) $this->session->userdata('id');

		$Data['first_view'] = true;
		$DataInsert = array(
			'contact_id' => $idContact,
			'meeting_id' => $zoom_id,
			'date' => $date,

		);
		$this->db->insert('send_box_zoom', $DataInsert);
		$query=	$this->db->query("select teacherid  from  zoom_meetings    WHERE zoom_meetings.meeting_id ='$id' ")->row_array();
		redirect($response->{'start_url'}.'&uname='.$this->session->userdata('contact_name'));
		
	}
	public function GetUserID($id){
		$token=$this->zoom_token;

		$curl    = curl_init();
        $room_url='https://api.zoom.us/v2/users/'.$id;
		    curl_setopt_array($curl, array(
			CURLOPT_URL => $room_url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			// CURLOPT_POSTFIELDS => json_encode($data),
			CURLOPT_HTTPHEADER => array(
				"Authorization:Bearer".$token,
                "Content-Type:application/json",
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$response = json_decode($response);
		$this->changeName($response->id);	
	}
	public function changeName($id){
		$token=$this->zoom_token;
		$Name = $this->session->userdata('contact_name');	
		

		// dd($token);
		$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => "https://api.zoom.us/v2/users/".$id,

    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_CUSTOMREQUEST => "PATCH", 
    CURLOPT_POSTFIELDS => json_encode(["first_name" => $Name, 'last_name' => ' ']), 
    CURLOPT_HTTPHEADER => array(
		"Authorization:Bearer".$token,
		"Content-Type:application/json",)
	));
	$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);
return true;

	}
	public function delete_session_group()
	{

		$ids = $this->input->post('ids');
		$meetingIds = $this->input->post('meetingIds');

		$arr = [];
		foreach ($ids as $value) {
			$this->zoom_model->delete_session_group($value);
		}
		
		foreach ($meetingIds as $val) {
			$this->zoom_model->delete_session_byMeeting($val);
		}


		$this->session->set_flashdata('SuccessAdd', "تم حذف الجلسات بنجاح  ");
		redirect("admin/zoom/last_listZoomMeeting", 'refresh');
	}
	public function delete_session()
	{

		$ids = $this->input->post('ids');

		$arr = [];
		foreach ($ids as $value) {
			$this->zoom_model->delete_session_group($value);
		}


		$this->session->set_flashdata('SuccessAdd', "تم حذف الجلسات بنجاح  ");
		redirect("admin/zoom/listZoomMeeting_by_room", 'refresh');
	}
	public function add_external_link($id = 0)
	{

		if ($this->uri->segment(4) === FALSE) {
			$this->session->set_flashdata('Failuer', 'لا يمكن الوصول للملف المطلوب');
			redirect('admin/zoom/last_listZoomMeeting', 'refresh');
		} else {
			$meetingid = $this->uri->segment(4);
			$Data['show'] = $this->uri->segment(5);
			// 			$Data['from_time']=$this->input->post('from_time');
			// 	        $Data['to_time']=$this->input->post('to_time'); 
			// 	        $Data['emp']=$this->input->post('emp'); 


			$Data['meetings'] 		= $this->zoom_model->get_meeting_by_id($meetingid);

			$this->load->admin_template('add_external_link', $Data);
		}
	}


	public function Zoom_add_extenal()
	{
		$id = $this->input->post('id');
		$show = $this->input->post('show');
		$external_link = $this->input->post('external_link');
		// if( isset($_POST['emp']) || isset($_POST['from_time']) || isset($_POST['to_time']) ){
		// $emp=$_POST['emp'];
		// $date=$_POST['start_time'];
		//     $types = $this->session->userdata('type');
		//     if($types=="U"||$types=="E"){ 
		// $ids = $this->zoom_model->Get_mettingids_by_emp_date($emp,$DayDateFrom,$DayDateTo); 
		//     $Data['get_All']=$ids;
		//     }}


		if ($this->zoom_model->add_external_link($id, $external_link)) {


			$this->session->set_flashdata('SuccessAdd', lang('br_add_suc'));
		} else {

			$this->session->set_flashdata('ErrorAdd', lang('br_add_error'));
		}
		if ($show == 1) {
			redirect('admin/zoom/last_listZoomMeeting', 'refresh');
		} else {
			redirect('emp/zoom/listZoomMeeting', 'refresh');
		}
	}

	public function edit_meeting($id = 0)
	{

		if ($this->uri->segment(4) === FALSE) {
			$this->session->set_flashdata('Failuer', 'لا يمكن الوصول للملف المطلوب');
			redirect('admin/zoom/last_listZoomMeeting', 'refresh');
		} else {
			$meetingid = $this->uri->segment(4);

			$Data['meetings'] 		= $this->zoom_model->get_meeting_by_id($meetingid);

			$this->load->admin_template('edit_new_meeting', $Data);
		}
	}


	public function Zoom_edit()
	{
		$date = date("Y-m-d\TH:i:s", strtotime($this->input->post('start_time')));

		$meeting_data = [
			"start_time" => $date
		];
		$curl = curl_init();
		$url = 'https://api.zoom.us/v2/users/' . $room . '/meetings';
		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($meeting_data),
			CURLOPT_HTTPHEADER => array(
				"Authorization:Bearer" . $token,
				"Content-Type:application/json",
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
	}
	//////////////////
	public function meetings_listZoom()
{
    $Data['date'] = $this->setting_model->converToTimezone();
    if (!$this->session->userdata('id')) {
        redirect('home/login');
    }
    $Data['rooms'] = $this->zoom_model->get_rooms_by_schoolid();
    $idContact = (int)$this->session->userdata('id');
    $this->db->select('GroupID');
    $this->db->from('contact');
    $this->db->where('ID', $idContact);
    $Result = $this->db->get();
    $NumRowResult = $Result->num_rows();
    if ($NumRowResult > 0) {
        $Return     = $Result->row_array();
        $GroupID       = $Return['GroupID'];
    }
    if (isset($_POST['room']) && isset($_POST['start_time'])) {
        $room = $_POST['room'];
        $date = $_POST['start_time'];
        $types = $this->session->userdata('type');
        if ($types == "U" || $types == "E") {
            $ids = $this->zoom_model->Get_mettingids_by_school($room, $date);
            $Data['get_All'] = $ids;
        }
    } else {
        // Only assign values if they are set in $_POST
        $room = isset($_POST['room']) ? $_POST['room'] : '';
        $date = isset($_POST['start_time']) ? $_POST['start_time'] : '';
        $types = $this->session->userdata('type');
        
        $ids = $this->zoom_model->Get_mettingids_by_school($room, $date);
        $Data['get_All'] = $ids;
    }

    $this->load->admin_template('meetings_listZoom', $Data);
}

	////////////////////////////////
	public function meeting_attendance_report()
	{
		$Data['from_time'] =  $DayDateFrom = $this->input->post('from_time');
		$Data['to_time']   = $DayDateTo = $this->input->post('to_time');
		$Data['teacher_id'] =  $teacher_id = $this->input->post('teacher_id');
		$type = $this->input->post('type');
		$fromdate = $DayDateFrom . ' 00:00:00.000000';
		$todate = $DayDateTo . ' 23:59:59.999999';


		$a_procedure = "CALL `Usp_GetMeetingAttendDetails_By_Teacher`(?, ?, ?)";
		$query = $this->db->query($a_procedure, array('p0' => $fromdate, 'p1' => $todate, 'p2' => $teacher_id));
		$res      = $query->result();
		mysqli_next_result($this->db->conn_id);
		$status = [];

		foreach ($res as $value) {

			if ($value->MeetingAttendStatus  == $type) {
				$status[] = $value;
			}
		}
		if ($type == '' || $type == 'NULL') {
			$Data['report_res'] =  $res;
		} else {
			$Data['report_res'] =  $status;
		}

		$Data['GetTeacher'] =  $this->zoom_model->get_emp_per();
		$Data['teacher'] = $teacher_id;
		$Data['DayDateFrom'] = $DayDateFrom;
		$Data['DayDateTo'] = $DayDateTo;

		$this->load->admin_template('view_meeting_attendance_report', $Data);
	}
	//////////////////////
	public function attend_emp_meeting()
	{
		$Data['timeZone']      = $this->setting_model->converToTimezone();
		$Data['GetTeacher']    = $this->zoom_model->get_emp_only();
		$Data['from_time']     = $this->input->post('from_time');
		$Data['to_time']       = $this->input->post('to_time');
		$Data['teacher_id']    = $this->input->post('teacher_id');

		$this->load->admin_template('view_attend_emp_meeting', $Data);
	}
	//////////////////////
	public function attend_emp_meeting_details()
	{
		$Data['timeZone']      = $this->setting_model->converToTimezone();
		$Data['type']          = $this->uri->segment(4);
		$Data['current_date']  = $this->uri->segment(5);
		$teacher_id            = $this->uri->segment(6);

		if($Data['type'] == 1){

			$Data['Data']    = $this->zoom_model->create_emp_meeting($Data['current_date'],$teacher_id,$date);   
                        
		}elseif ($Data['type'] == 2) {

			$Data['Data'] = $this->zoom_model->not_attend_emp_meeting($Data['current_date'],$teacher_id,$date);

		}elseif ($Data['type'] == 3) {
			
			$Data['Data']    = $this->zoom_model->not_add_emp_meeting($Data['current_date'],$teacher_id,$date);
		}

		$this->load->admin_template('view_attend_emp_meeting_details', $Data);
	}
	//////////////////////
	public function attend_emp_all_meeting_details()
	{
		$Data['timeZone']      = $this->setting_model->converToTimezone();
		$Data['current_date']  = $this->uri->segment(4);
		$Data['teacher_id']    = $this->uri->segment(5);
		$Data['Data']          = $this->zoom_model->create_emp_all_meeting($Data['current_date'],$Data['teacher_id']);   
		$this->load->admin_template('view_attend_emp_all_meeting_details', $Data);
	}
	public function meeting_report()
	{
		$Data['meeting_id']             = $this->uri->segment(4);
		$Data['meeting_info'] 		    = $this->zoom_model->get_meeting_info();
		$Data['meeting_minutes'] 		= $this->zoom_model->get_meeting_minutes_data();
		$this->load->admin_template('view_meeting_report', $Data);
	}

	public function add_meeting_minutes()
{
    $meeting_id = $this->input->post('meeting_id');

    $clauses = $this->input->post('clause');
    $what_dones = $this->input->post('what_done');
    $duration_implementations = $this->input->post('duration_implementation');
    $clause_titles = $this->input->post('clause_title');

    $dataToInsert = array();

    foreach ($clauses as $key => $clause) {
        $rowData = array(
            'title' => $this->input->post('title'),
            'place' => $this->input->post('place'),
            'meeting_id' => $meeting_id,
            'clause_title' => $clause_titles[$key],
            'clause' => $clause,
            'what_done' => $what_dones[$key],
            'duration_implementation' => isset($duration_implementations[$key]) ? $duration_implementations[$key] : ''
        );

        $dataToInsert[] = $rowData;
    }

	foreach ($dataToInsert as $rowData) {
        if (!$this->zoom_model->add_meeting_minutes($rowData)) {
            $this->session->set_flashdata('Failuer', lang('br_add_error'));
            redirect('admin/zoom/meeting_report/' . $meeting_id);
            return;
        }
    }

    $this->session->set_flashdata('Sucsess', lang('br_add_suc'));
    redirect('admin/zoom/meeting_report/' . $meeting_id);
}

}
