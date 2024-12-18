<?php if(!defined('BASEPATH'))exit('No direct script access allowed');
require_once APPPATH . '/traits/zoom/TokenTrait.php';

class Zoom extends MY_Student_Base_Controller{
	use TokenTrait;
	private $data = array() ;
    public $DB1;
	function __construct()

    { 
        

	   parent::__construct();
	   $this->DB1= $this->load->database("db1", TRUE);
	   $this->load->model(array('home/login_model','student/student_class_table_model','student/zoom_model'));
	   $get_zoom_token=$this->zoom_model->get_zoom_token(); 
	     $this->zoom_token=$this->GetToken();
		//  $get_zoom_token = $this->zoom_model->get_zoom_token();
		// $this->zoom_token = $get_zoom_token[0]->{'INFO'};
	   
    }
    
   /* public function index()
	{
	
		$this->load->view('view_login');
	}
		public function check_login()
	{
	   if($this->session->userdata('language') == 'english')

			{
				$this->config->set_item('language','english');
			}else{
					   $this->config->set_item('language','arabic');

				 }
	$this->form_validation->set_rules('username', 'lang:br_User_Name','required|min_length[1]|max_length[15]|xss_clean');
	$this->form_validation->set_rules('password', 'lang:br_Password','required|min_length[1]|max_length[15]|xss_clean');
	    if ($this->form_validation->run() === false)
		{
            $this->index();			
		}
		else
		{

		 $this->data['username']     = 
		str_replace(""," ",(string)$this->security->xss_clean($this->input->post('username')));
		$this->data['password']     = 
		str_replace(""," ",(string)$this->security->xss_clean($this->input->post('password'))); 
		$GetDataLogin               = $this->login_model->check_login($this->data); 
			if($GetDataLogin){
				extract($GetDataLogin);
			if($Isactive == 0)
			{
				$this->session->set_userdata('CheckLoginNumber' ,0 ) ;
			    $this->session->set_flashdata('msg','الحساب غير مفعل برجاء مرجعه الاداره');
			    redirect('zoom','refresh');
			}else{

                if($SchoolID == 0){$SchoolID =$this->login_model->get_school(); }

					$SessionData = array ('id'=>$ID,'type'=>$Type,'contact_name'=>$Name,'SchoolID'=>$SchoolID ,'GroupID'=>$GroupID, 'login' => true) ;

					$this->session->set_userdata($SessionData);
					//// check type user
					 switch($Type)
					{
					 case 'U' :
					redirect('zoom/listZoomMeeting','refresh'); 
					 break ;
					 case 'E' :
					redirect('zoom/listZoomMeeting','refresh'); 
					break ;
					case 'F' :
					redirect('zoom/listZoomMeeting','refresh'); 
					break ;
					case 'S' :
					redirect('zoom/listZoomMeeting','refresh'); 
					break ;
					case 'A' :
					redirect('zoom/listZoomMeeting','refresh'); 
					break ;
					default :
					echo 'error' ;
					break ;   
					}
				}
		 }else
		  {
		   $this->session->set_flashdata('msg','برجاء مراجعه إسم المستخدم وكلمه المرور ');
		   redirect('zoom','refresh'); 
		}
	 }
  }
  		public function log_out()
	{
		$userID = $this->session->userdata('id');

		$data = array(
            'last_activity'=>NULL
        );
        
        $this->db->where('ID', $userID);
        $this->db->update('contact', $data);

		$this->session->sess_destroy();			
	    redirect('home', 'refresh'); 
	}
	*/
	
		public function listZoomMeeting()
	{
	     if(! $this->session->userdata('id')){
		redirect('home/login');
		}
		$data['UID']                  = (int)$this->session->userdata('id');
		$data['GetClass']             = $this->student_class_table_model->get_student_class($data['UID']);
		$ClassRowLevel        = (int)$data['GetClass']['Class_ID'] ;
		$row_level                    = (int)$data['GetClass']['R_L_ID'] ;
		$m_data                       = $this->zoom_model->get_data($row_level);
	//	$ids = $this->zoom_model->Get_mettingids($m_data->Level_ID ,$m_data->Row_ID ,$ClassRowLevel);
		$ids = $this->zoom_model->Get_mettingids($data['UID']);
		//print_r($ids);die;
	    $token=$this->GetToken();
        /*$curl_h = curl_init('https://api.zoom.us/v2/users/info@diwan-language-school.com/meetings');
        curl_setopt($curl_h, CURLOPT_HTTPHEADER,
            array(
               "Authorization:Bearer".$token,
            )
        );
        
        curl_setopt($curl_h, CURLOPT_RETURNTRANSFER, true);
        
        $response = json_decode(curl_exec($curl_h));
	    $Data['get_All']=$response->meetings;*/
	    
	      $arr=[];
	    foreach($ids as $k=>$id){
	     $id1=$id->meeting_id;
	     
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
	    $Data['get_All']=$arr;
		$this->load->student_template('list_Zoom_Meeting',$Data);
	}
		public function listZoomMeeting1()
	{
	      if(! $this->session->userdata('id')){
		redirect('home/login');
		}
		$data['UID']                  = (int)$this->session->userdata('id');
		$data['GetClass']             = $this->student_class_table_model->get_student_class($data['UID']);
		$ClassRowLevel        = (int)$data['GetClass']['Class_ID'] ;
		$row_level                    = (int)$data['GetClass']['R_L_ID'] ;
		$m_data                       = $this->zoom_model->get_data($row_level);
		$ids = $this->zoom_model->Get_mettingids1();
	    $token=$this->GetToken();
	    
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
	    $Data['get_All']=$arr;
		$this->load->father_template('list_Zoom_Meeting',$Data);
	}
	
	public function delete($id)
	{
	    $token="eyJhdWQiOm51bGwsImlzcyI6Ikphb2NfbjluU0x5Wk5LZ1AxSUdDZ1EiLCJleHAiOjE1OTgwNTg5ODcsImlhdCI6MTU5ODA1MzU4OH0.4ZmdBmLCyxIBA4pb6pCOFxWx-_lqiZ9PvAN2Hc81Kgc";
	     $curl_h = curl_init('https://api.zoom.us/v2/meetings/'.$id);
	     
        curl_setopt($curl_h, CURLOPT_HTTPHEADER,
            array(
               "Authorization:Bearer".$token,
            )
        );
        
        curl_setopt($curl_h, CURLOPT_CUSTOMREQUEST, "DELETE");
        $response = json_decode(curl_exec($curl_h));
        redirect('student/zoom/listZoomMeeting','refresh');
	}
	
		public function attend($id)
	{
	     if(! $this->session->userdata('id')){
		redirect('home/login');
		}
	    if(! $this->session->userdata('id')){
		redirect('zoom');
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
        $Data['get_All']=$response;
        $this->load->view('student/attend',$Data);
         
         
         
	}
		
		public function user_attend($id)
	{
	     if(! $this->session->userdata('id')){
		redirect('home/login');
		}
	    if(! $this->session->userdata('id')){
		redirect('zoom');
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
        $Data['get_All']=$response;
        
       // print_r($response);die;
        $this->load->view('student/user_attend',$Data);
         
         
         
	}
		public function Zoom_post()
	{
	     $meeting_data = [
					"topic" =>$this->input->post('topic'),
					"type" => $this->input->post('type'),
					"start_time" => $this->input->post('start_time'),
					"duration" => $this->input->post('duration'),
					"schedule_for" => $this->input->post('schedule_for'),
					"timezone" => $this->input->post('timezone'),
					"password" => $this->input->post('password'),
					"agenda" => $this->input->post('agenda'),
				];
			
				$meeting_result = $this->Zoom_Create($meeting_data);
				if(!$meeting_result->id) {
					$this->session->set_flashdata('Failuer', lang('br_parent_error'));
					redirect('student/zoom/listZoomMeeting', 'refresh');
				}
				else{
				    redirect('student/zoom/listZoomMeeting', 'refresh');
				}
	}
	
	
		private function Zoom_Create($data)
	{
	        $token="eyJhdWQiOm51bGwsImlzcyI6Ikphb2NfbjluU0x5Wk5LZ1AxSUdDZ1EiLCJleHAiOjE1OTgwNTg5ODcsImlhdCI6MTU5ODA1MzU4OH0.4ZmdBmLCyxIBA4pb6pCOFxWx-_lqiZ9PvAN2Hc81Kgc";
	    	array_walk($data, function (&$item) {
			if (empty($item) && $item !== false) {
				$item = '';
			}
		});
		$curl = curl_init();

		    curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://api.zoom.us/v2/users/info@diwan-language-school.com/meetings',
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
	public function MeetingAttendDetails_Report()
	{  
	    $Data['DayDateFrom'] =  $DayDateFrom=$this->input->post('from_time');
	       $Data['DayDateTo'] = $DayDateTo=$this->input->post('to_time');
	      $student_id=$this->session->userdata('id'); 
	      $SchoolID=   $this->session->userdata('SchoolID');
          $fromdate=$DayDateFrom.' 00:00:00.000000';
          $todate=$DayDateTo.' 23:59:59.999999';  
          
            if($student_id =='' ){ 
                  $Data['report_res'] =  '';  
            }else{  
              $a_procedure = "CALL `Usp_GetMeetingAttendDetails_ByStudent`(?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
            $query = $this->db->query( $a_procedure, array('p0'=>$student_id,'p1'=>'','p2'=>$rowlevel,'p3'=>$level,'p4'=>$SchoolID,'p5'=>$class,'p6'=>'','p7'=>$fromdate,'p8'=>$todate,'p9'=>'','p10'=>'') );
            $res      = $query->result();  
            mysqli_next_result( $this->db->conn_id );  
            
                  $Data['report_res'] =  $res;  
            }
 

		$this->load->student_template('MeetingAttendDetails_Report',$Data);
   
	}
	public function summer_courses()
	{
        $Data['student_id']     = $this->session->userdata('id');
    
        $Data['course']         = $this->zoom_model->summer_courses($Data);
        
		$this->load->student_template('view_summer_courses',$Data);
   
	}
	/////////////////
	public function add_student_course()
	{
	    $Data['GroupID']        = (int)$this->uri->segment(4);
	    
	    $Data['student_id']     = (int)$this->uri->segment(5);
	    
        if($this->zoom_model->add_student_course($Data))

        {
        
            redirect('student/zoom/summer_courses','refresh');

        }
         
	}
    
}