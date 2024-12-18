<?php if(!defined('BASEPATH'))exit('No direct script access allowed');
require_once APPPATH . '/traits/zoom/TokenTrait.php';
require_once APPPATH . '/traits/zoom/ZoomRecordTrait.php';

class Zoom extends CI_Controller{
		use TokenTrait; 
		use ZoomRecordTrait;
		 
	private $data = array() ;

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

	function __construct()
    {
	   parent::__construct();
	   $this->load->model(array( 'emp/zoom_model','emp/emp_class_table_model','admin/setting_model'));
	    $this->zoom_token       = $this->GetToken(); 
	    $this->data['date']     = $this->setting_model->converToTimezone();
	    $this->data['Lang']     = $this->session->userdata('language');
	    $get_api_setting        = $this->setting_model->get_api_setting(); 
	    $this->ApiDbname        = $get_api_setting[0]->{'ApiDbname'};
		// $get_zoom_token         = $this->zoom_model->get_zoom_token();
		// $this->zoom_token       = $get_zoom_token[0]->{'INFO'};
	   
    }
     	private function Zoom_Create($room,$data)
	{
	    if($room==""){
	    $room='info@diwan-language-school.com';
	    }
	
	        $token=$this->zoom_token;
	    	array_walk($data, function (&$item) {
			if (empty($item) && $item !== false) {
				$item = '';
			}
		});
		$curl    = curl_init();
        $room_url='https://api.zoom.us/v2/users/'.$room.'/meetings';
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
				"Authorization:Bearer".$token,
                "Content-Type:application/json",
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		return json_decode($response);
	
	}
	//////////////////////////////
	public function listZoomMeeting()
	{
        $Data['date'] = $this->data['date'];
	     if(! $this->session->userdata('id')){
		redirect('home/login');
		}
		$this->db->select('config_lesson.ID,config_lesson.start_time, config_lesson.end_time, config_lesson.lesson_name, ');	

		$this->db->where('end_time !=', '');
				 $this->db->where('semester_id', 1);
		 $this->db->where('level_id', 1);
		 $this->db->where('school_id', 1);
		 $Data['lessons'] = $this->db->get('config_lesson')->result();
		  
		$Data['UID']             = (int)$this->session->userdata('id'); 
	    $Data['get_All']         = $this->zoom_model->Get_mettingids_by_emp_id();
        $Data['rooms']           = $this->zoom_model->get_rooms();
		$Data['check_semester']  = $this->setting_model->get_semesters();
        if($this->ApiDbname=="SchoolAccTajRiyadh"){
        $Data['GetRowLevel']     = $this->zoom_model->getRowLevel_taj(); 
        $Data['getSubject']      = $this->zoom_model->getSubject_taj(); 
        }else{
        $Data['GetRowLevel']     = $this->zoom_model->getRowLevel(); 
        $Data['getSubject']      = $this->zoom_model->getSubject(); 
	    }

        $Data['GetPermission']   = $this->zoom_model->get_permission();
		$this->load->emp_template('list_Zoom_Meeting',$Data);
	}

	public function getlessons() {
		$this->db->select('config_lesson.ID,config_lesson.start_time, config_lesson.end_time, config_lesson.lesson_name, ');	

		$this->db->where('end_time !=', '');
				 $this->db->where('semester_id', 1);
		 $this->db->where('level_id', 1);
		 $this->db->where('school_id', 1);
		$Data['lessons'] = $this->db->get('config_lesson')->result();
		echo json_encode($Data);
	}
	
  //////////////////////////////////////////////////
	public function attend_listZoomMeeting()
	{
	     if(! $this->session->userdata('id')){
		redirect('home/login');
		}
		$Data['date'] = $this->data['date'];
          $Data['get_All']=$this->zoom_model->Get_mettingids_by_contact_id();
		$this->load->emp_template('attend_list_Zoom_Meeting',$Data);
	}
	//////////////////////////////////////////////////
  	public function Zoom_post()
	{
		// dd($_POST);

	    $Timezone                 = $this->data['date'];
		
	    $teacherid                = (int)$this->session->userdata('id');
	    $date1                    = date("Y-m-d\TH:i:s\Z",strtotime($this->input->post('date')));
		
	    $date                     = date("Y-m-d\TH:i:s",strtotime($this->input->post('start_time')));
		// dd($date);
	    $levels                   = explode("/", $this->input->post('level'));
        $levele_ID                = $levels[0];  
        $levele_name              = $levels[1];  
	    $RowLevels                = explode("/", $this->input->post('RowLevel'));
        $RowLevele_ID             = $RowLevels[0];  
        $RowLevele_name           = $RowLevels[1];  
	    $Subjects                 = explode("/", $this->input->post('Subject'));
        $Subject_ID               = $Subjects[0];  
        $Subject_name             = $Subjects[1];  
        $topic_name               = filter_var($this->input->post('topic'), FILTER_SANITIZE_STRING);
        $topic                    = $topic_name.' / '.$RowLevele_name.' / '.$Subject_name;
	    $type                     = $this->input->post('type');
		$duration = $this->input->post('duration');
		$Timezone = $this->input->post('timezone');
		// dd($this->session->userdata());
		if($_POST['fromeLessonTable']== 1){
			
			$lessonID = $_POST['lessonID'];
			$this->db->select('Level_ID');
			$this->db->where('ID',$_POST['RowLevel']);
			$levelID = 	$this->db->get('row_level');
			$levelID = (int) $levelID->row_array()['Level_ID'];
			$dateInput = $this->input->post('date');

			$curantData=date("Y-m-d");
			$this->db->select(['start_time', 'end_time']);
			$this->db->from('config_lesson');
			$this->db->join('config_semester', 'config_semester.ID = config_lesson.semester_id', 'inner');
			$this->db->where('level_id', $levelID);
			$this->db->where('config_count', $lessonID);
			$this->db->where('school_id', $this->session->userdata('SchoolID'));
			$this->db->where("'$curantData' BETWEEN config_semester.start_date AND config_semester.end_date");

			$startTimeAndEndTiome = $this->db->get();
			// dd($startTimeAndEndTiome->row_array());
			$startTime= $startTimeAndEndTiome->row_array()['start_time'];
			$endTime =  $startTimeAndEndTiome->row_array()['end_time'];
			if($startTime == null || $endTime == null){
				$this->session->set_flashdata('FailuerLessonTimeConfig', lang('lesson_time_config_error'));
				redirect('emp/class_table/class_table_emp/'.$_POST['ClassTableType'], 'refresh');
				return;
			}
			

			$startTimePerScand = strtotime($startTime);
			$endTimePerScand = strtotime($endTime);
	
			$minutes = ($endTimePerScand - $startTimePerScand) / 60;
			
			$duration = (string) $minutes;
			$Timezone = $this->db->query("SELECT time_zone FROM school_details ")->row_array()['time_zone'];
			$year = date("Y"); 
			$date = $year . '-' . $dateInput; 
			$fullDate = $year . '-' . $dateInput . ' ' . $startTime;
			$FromeLessonTable = date("Y-m-d\TH:i:s", strtotime($fullDate));

			$currentDateTime = new DateTime("now", new DateTimeZone($Timezone));
			$lessonDateTime = new DateTime($fullDate, new DateTimeZone($Timezone));
			if ($lessonDateTime < $currentDateTime) {
				$this->session->set_flashdata('FailuerLessonTimeConfig', 'يجب ان يكون التاريخ الجلسة اكبر من الوقت الحالي ');
				redirect('emp/class_table/class_table_emp/'.$_POST['ClassTableType'], 'refresh');
				return;
			} 
			$date= $FromeLessonTable;

			

		}
		
		// dd($FromeLessonTable);
	
		
	   

	   
	           $meeting_data = [
					"topic"           => $topic,
					"type"            => $type,
					"start_time"      => $date ,
					"duration"        => $duration,
					"schedule_for"    => $this->input->post('schedule_for'),
					"timezone"        => $Timezone,
					"password"        => $this->input->post('password'),
					"agenda"          => filter_var($this->input->post('agenda'),FILTER_SANITIZE_STRING), 
			 		"levele_ID"       => $levele_ID,  
			 		"RowLevele_ID"    => $RowLevele_ID,  
			 		"Subject_ID"      => $Subject_ID,  
			 		"teacherid"       => $teacherid,
			 		"group_id"        => $this->input->post('group_id'),
					"external_link"   => $this->input->post('external_link'), 
				];
				// dd($meeting_data);

		$room1               = $this->input->post('room');
	    $room                = explode(',',$room1);
		// $duration            = $this->input->post('duration');
        $token               = $this->zoom_token;
        $group_id            = $this->input->post('group_id');
        $query_room          = $this->zoom_model->room_alert($room[1],$date,$duration);
        $query_group         = $this->zoom_model->group_alert($group_id,$date,$duration);
        $query_teacher          = $this->zoom_model->teacher_alert($teacherid,$date,$duration);
     
                    if(empty($query_room)){
                        if(empty($query_group)){
                            if(empty($query_teacher)){
				               $meeting_result = $this->Zoom_Create($room[0],$meeting_data);
				               if(!$meeting_result->id) {
					              $this->session->set_flashdata('Failuer', lang('br_parent_error'));
				               }
				               else{
				                    $meetingId       = $meeting_result->id;
				                    $start_url       = $meeting_result->start_url;
				                    $join_url        = $meeting_result->join_url;
				                    $zoom_id         = $this->input->post('meeting_id');
				                    $uuid            = $meeting_result->uuid;
                                    $occurrences     = $meeting_result->{occurrences};
	  	                            $occurrence_id1  =	$occurrences[0]->{'occurrence_id'} ;
	      
				 $Timezone = $this->setting_model->converToTimezone();   
				 $this->zoom_model->add_zoom_meetings($meeting_data,$meetingId,$room[0],$room[1],$start_url,$join_url,$occurrence_id1,$uuid,$Timezone);
				 $date_notify = date("Y-m-d H:i", strtotime($this->input->post('start_time')));
				 $NotifyMessage =array(
					 'message'=> 'قام احد  المسئولين بإضافتك لجلسة إفتراضية جديدة بموعد '.$date_notify,
					 'title' => 'إشعار  لجلسة أفتراضيه جديده '
				 );
				 
				 $this->load->library('ci_pusher');
				 $pusher = $this->ci_pusher->get_pusher();
				 $pusher->trigger($_SERVER['SERVER_NAME'] . 'Zoom' . $_POST['group_id'],'AddZoom', $NotifyMessage);
	   	 
				}		 
		if($_POST['fromeLessonTable']== 1){
            $this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));
			redirect('emp/zoom/zoomTableEmp', 'refresh');
		}
				 
				    redirect('emp/zoom/listZoomMeeting/-1', 'refresh');
                            }
				else{
				    redirect('emp/zoom/listZoomMeeting/3/'.$query_teacher['start_time']."/".$query_teacher['end_time']."/".$query_teacher['teacherid']."/".$query_teacher['group_id']."/".$query_teacher['room_id'], 'refresh');
				}
                    }
				else{
				    redirect('emp/zoom/listZoomMeeting/2/'.$query_group['start_time']."/".$query_group['end_time']."/".$query_group['teacherid']."/".$query_group['group_id']."/".$query_group['room_id'], 'refresh');
				}
                    }
				else{
				    redirect('emp/zoom/listZoomMeeting/1/'.$query_room['start_time']."/".$query_room['end_time']."/".$query_room['teacherid']."/".$query_room['group_id']."/".$query_room['room_id'], 'refresh');
				}
				 
				
	}
	/////////////////////////////////
	public function Zoom_add_extenal()
	{
	    $id             = $this->input->post('id');
	    $external_link  = $this->input->post('external_link');
	   
	    if($this->zoom_model->add_external_link($id,$external_link))

        {
            

            $this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));

        }else{

            $this->session->set_flashdata('ErrorAdd',lang('br_add_error'));

        }
         redirect('emp/zoom/listZoomMeeting' , 'refresh');
	        
	    }
	    ////////////////////////////////////////
	public function user_attend($id,$zoom_id,$endTime)
	{ 
	     
	     if(! $this->session->userdata('id')){
		redirect('home/login');
		}
	    if(! $this->session->userdata('id')){
		redirect('zoom');
		}
		$date       = $this->data['date'];
        $en_time    = str_replace('%20',' ',$endTime);
         if($en_time<$date){
              redirect('emp/zoom/listZoomMeeting/' , 'refresh');
         }

        
	    $token=$this->zoom_token;
        $curl_h = curl_init('https://api.zoom.us/v2/meetings/'.$id);
        curl_setopt($curl_h, CURLOPT_HTTPHEADER,
            array(
               "Authorization:Bearer".$token,
            )
        );
        
        curl_setopt($curl_h, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($curl_h));
        $obj = json_decode($response);
        $Data['get_All']=$response;
        
        $curl_h_1 = curl_init('https://api.zoom.us/v2/past_meetings/'.$id.'/instances');
        curl_setopt($curl_h_1, CURLOPT_HTTPHEADER,
            array(
               "Authorization:Bearer".$token,
            )
        );
        
        curl_setopt($curl_h_1, CURLOPT_RETURNTRANSFER, true);
        $response_1 = json_decode(curl_exec($curl_h_1));
        
        $uuid=$response_1->meetings[0]->uuid;
        $time=date("Y-m-d", strtotime($response_1->meetings[0]->start_time));
        $this->db->query("UPDATE zoom_meetings  SET uuid ='$uuid'  WHERE zoom_meetings.meeting_id ='$id'  and date(zoom_meetings.start_time)='$time'");
        $idContact = (int) $this->session->userdata('id');
        
					$Data['first_view'] = true;
					$DataInsert = array(
						'contact_id' => $idContact,
						'meeting_id' => $zoom_id,
						'date'       => $this->data['date'],
					 
					);  
					$this->db->insert('send_box_zoom', $DataInsert);

					$query=	$this->db->query("select teacherid  from  zoom_meetings    WHERE zoom_meetings.meeting_id ='$id' ")->row_array();
					if($query['teacherid']== $this->session->userdata('id')){			
					redirect($response->{'start_url'}.'&uname='.$this->session->userdata('contact_name'));
					}else{
						redirect($response->{'join_url'}.'&uname='.$this->session->userdata('contact_name'));
					}
	} 

    public function delete_meeting($id)
	{
	    $token    = $this->zoom_token;

	     $curl_h = curl_init('https://api.zoom.us/v2/meetings/'.$id);
	     
        curl_setopt($curl_h, CURLOPT_HTTPHEADER,
            array(
               "Authorization:Bearer".$token,
            )
        );
        
        curl_setopt($curl_h, CURLOPT_CUSTOMREQUEST, "DELETE");
        $response = json_decode(curl_exec($curl_h));
        
        if($this->db->query("UPDATE zoom_meetings  SET is_deleted =1 ,deleted_by = '".$this->session->userdata('id')."'  WHERE zoom_meetings.meeting_id =$id ")){
        redirect('emp/zoom/listZoomMeeting','refresh');}
	}
	////////////////////////////////
	public function zoomTableEmp()
	{
		$id               = (int)$this->session->userdata('id');
        $data['date']     = $this->data['date'];
        // $day              = date('w');
        // $week_start       = date('Y-m-d 00:00:00', strtotime('-'.$day.' days'));
        // $week_end         = date('Y-m-d 23:59:59', strtotime('+'.(6-$day).' days'));

		$day = date('w'); 

			
			if ($day == 6) {
				$week_start = date('Y-m-d 00:00:00');
			} else {
				$week_start = date('Y-m-d 00:00:00', strtotime('last Saturday'));
			}

			
		$week_end = date('Y-m-d 23:59:59', strtotime($week_start . ' +6 days'));
        $data['all_data'] = $this->zoom_model->Teacher_Timetable($id, $week_start, $week_end);
        $data['getDay']   = $this->zoom_model->get_day_zoom($this->data['Lang']);
		$this->load->emp_template('emp_table_zoom', $data);
		
	}
	/////////////////////////////////////
		public function MeetingAttendDetails_Report()
	{  
	    $Data['Date']          = $this->data['date'];
	    $Data['DateFrom']      = $DayDateFrom=$this->input->post('from_time');
	    $Data['DateTo']        = $DayDateTo=$this->input->post('to_time');
	    $emp_id                = $this->session->userdata('id'); 
	    $SchoolID              = $this->session->userdata('SchoolID');
        $fromdate              = $DayDateFrom.' 00:00:00.000000'; 
        $todate                = $DayDateTo.' 23:59:59.999999';  
        if($emp_id =='' ){ 
              $Data['report_res'] =  '';  
        }else{  
          $a_procedure = "CALL `Usp_GetMeetingAttendDetails_ByStudent`(?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
        $query = $this->db->query( $a_procedure, array('p0'=>'','p1'=>'','p2'=>'','p3'=>'','p4'=>$SchoolID,'p5'=>'','p6'=>'','p7'=>$fromdate,'p8'=>$todate,'p9'=>$emp_id,'P10'=>'') );
        $res      = $query->result();  
        mysqli_next_result( $this->db->conn_id );  
        $Data['report_res'] =  $res;  
       }
 

		$this->load->emp_template('MeetingAttendDetails_Report',$Data);
   
	}
	/////////////////////////////////////////////
	 public function listZoomMeeting_by_emp()
	{
		
	    $Data['date'] = $this->setting_model->converToTimezone();
	    if(! $this->session->userdata('id')){
		redirect('home/login');
		}  
	    if(isset($_POST['from_time']))
	    {
 	     $emp              = (int)$this->session->userdata('id');   
	     $Data['DateFrom'] = $DayDateFrom=$this->input->post('from_time');
	     $Data['DateTo']   = $DayDateTo=$this->input->post('to_time'); 
	     $ids              = $this->zoom_model->Get_mettingids_by_emp_date($emp,$DayDateFrom,$DayDateTo); 
         $Data['get_All']  = $ids;
        
	}	
	$this->load->emp_template('list_Zoom_Meeting_by_emp',$Data);
	}
////////////////////////////////
	public function GroupsByRowLevel($rowLavel){
	   $rowLavel_id                    = $this->uri->segment(4);
        $dataResponse['GetClass']    = $this->zoom_model->GroupsByRowLevel($this->data['Lang'],$rowLavel_id);
        $this->output->set_content_type('application/json')->set_output(json_encode($dataResponse));
    }
	///////////////////////////////////////////////////////////rania

	/**
	 * get zoom recordings by meeting id 
	 */
	public function getMeetingRecordis($meetingId){
		$meetingRecordings = $this->getMeetingRecordings($meetingId,$this->zoom_token);
		
		echo json_encode($meetingRecordings);die;
	}

	
}