<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Exam_New extends CI_Controller
{

	private $data = array();

	function __construct()
	{
		parent::__construct();
	
		$this->load->model(array('emp/exam_new_model', 'admin/setting_model'));
	
		$this->data['UID']            = $this->session->userdata('id');
		$this->data['YearID']         = $this->session->userdata('YearID');
		$this->data['Year']           = $this->session->userdata('Year');
		$this->data['Semester']       = $this->session->userdata('Semester');
		$this->data['Lang']           = $this->session->userdata('language');
		$this->data['date']           = $this->setting_model->converToTimezone();
		if($_SERVER['SERVER_NAME'] == 'lms.test'){
		$this->data['apikey']         ='chat.lmsdevelopment.esol.com.sa';
			
		}else{
			$this->data['apikey']         ='chat.'. $_SERVER['SERVER_NAME'];

		}
		$get_api_setting     = $this->setting_model->get_api_setting();
		$this->ApiDbname     = $get_api_setting[0]->{'ApiDbname'};
	}
	public function index()
	{
		$Data['Semesters']       = $this->setting_model->get_semesters();
		$Data['date']            = $this->data['date'];
// 		$Data['rowlevelid']      = $this->uri->segment(4);
		$Data['type']            = $this->uri->segment(4);

		$Data['exam_details']    = $this->exam_new_model->get_exam($Data);

		$this->load->emp_template('all_exam', $Data);
	}
	//////////////////////////////
	public function get_result_students()
	{
		$this->data['test_ID']             = (int)$this->uri->segment(4);
		$this->data['exams_students']      = $this->exam_new_model->get_result_students($this->data['test_ID']);

		$this->load->emp_template('result_students', $this->data);
	}
	/////////////////////////////////////
	public function add_upload_degree()
	{
		$test_ID     = $this->uri->segment(4);
		$t_s_ID      = $this->input->post('t_s_ID');
		$s_Degree    = $this->input->post('s_degree');
		$t_Degree    = $this->input->post('total_degree');

		$this->exam_new_model->insert_s_d_upload($s_Degree, $t_Degree, $t_s_ID);
		redirect('/emp/exam_new/get_result_students/' . $test_ID, 'refresh');
	}
	/////////////////////
	public function repet_exam()
	{
		$Data['test_id']     = (int)$this->uri->segment(4);
		$Timezone            = $this->data['date'];
		$Data['Getstudent']  = $this->exam_new_model->get_student_name_repeat($Data['test_id'], $Timezone);
		$Data['student']     = $this->exam_new_model->get_student($Data['test_id']);

		$this->load->emp_template('view_repet_exam', $Data);
	}
	//////////////////////
	public function save_repet_exam()
	{
		$Timezone                = $this->data['date'];

		$data['test_id']         = (int)$this->uri->segment(4);
        $numStudentData = $this->db->query('SELECT test.num_student FROM test WHERE test.ID=' . $data['test_id'])->row_array();

		$oldStudentIds = $this->input->post('student[]');

		if (!empty($numStudentData['num_student'])) {
			$numStudentIdsArray = explode(',', $numStudentData['num_student']);

			$mergedStudentIds = implode(',', array_unique(array_merge($oldStudentIds, $numStudentIdsArray)));

			$data['student'] = $mergedStudentIds;
		} else {
			$data['student'] = implode(',', $oldStudentIds);
		}
				$CheckAdd               = $this->exam_new_model->update_student_name_repeat($data['test_id'], $data['student'], $Timezone);
				if ($CheckAdd) {
					$this->session->set_flashdata('SuccessAdd', lang('br_add_suc'));

			redirect('/emp/exam_new/repet_exam/' . $data['test_id'], 'refresh');
		} else {
			$this->session->set_flashdata('ErrorAdd', lang('br_add_error'));
			redirect('emp/exam_new/repet_exam/' . $data['test_id'], 'refresh');
		}
	}
	////////////////////////////////
	public function del_exam()
	{
		$Timezone          = $this->data['date'];
		$ID                = $this->uri->segment(4);
		$type              = $this->uri->segment(5);

		$this->exam_new_model->delete_exam($ID, $Timezone);
		redirect('/emp/exam_new/index/'. $type, 'refresh');
	}
	/////////////////////////////////////////////////////
	public function create_exam()
	{
		$Data['Lang']           = $this->session->userdata('language');
		$Data['Timezone']              = $this->data['date'];
// 		$Data['rowlevelid']            = $this->uri->segment(4);
		$Data['type']                  = $this->uri->segment(4);
		$Data['test_id']               = $this->uri->segment(5);
		$Data['GetSemester']           = $this->exam_new_model->get_semester((string)$this->data['Lang']);
		$Data['SemesterID']            = $this->setting_model->get_semester();
		$Data['Type_question']         = $this->exam_new_model->get_Type_question();
		$Data['check_semester']        = $this->setting_model->get_semesters();
		if ($Data['test_id']) {
			$Data['test_data']         = $this->exam_new_model->get_test_data($Data['test_id']);
			$Data['questions']         = $this->exam_new_model->get_question($Data['test_id']);
			$Data['TotalDegree']       = $this->exam_new_model->getTotalDegree($Data['test_id']);
			$Data['exam_student']      = $this->exam_new_model->get_exam_student($Data['test_id']);
			if($Data['TotalDegree'] &&$Data['TotalDegree']  ==$Data['test_data']['examDegree']  ){ 
				$Data['ableToActive'] =1;
			}
		}
	    $Data['studeType']        = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllStudyTypes"));
		$Data['ClassType']        = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllClassTypes"));
		$this->load->emp_template('create_exam', $Data);
	}
	////////////////////////////
	public function bankData()  {

		$Data['rowlevelid']            = $this->uri->segment(4);
		$Data['subjectid']             = $this->uri->segment(5);
		$Data['type']                  = $this->uri->segment(6);
		$Data['test_id']               = $this->uri->segment(7);
		$Data['bankID']                = $this->uri->segment(8);
		$Data['allBank']               = $this->ApiGet("https://chat.lms.esol.com.sa/apikey/bank?userID=" . $this->data['UID'] . "&apikey=" . $this->data['apikey']."&touse=1&gradeID=".$Data['rowlevelid']."&subjectID=".$Data['subjectid']);
        if($Data['bankID']){
		$Data['queBank']               = $this->getAPIData('https://chat.lms.esol.com.sa/apikey/bank/questions?id='.$Data['bankID'].'&apikey='. $this->data['apikey']);
	    }
		// print_r($Data['queBank']['data'][1]['answers']);die;
		$this->load->emp_template('view_bank_data', $Data);
   }
   /////////////////////////
   public function addBankQuestion(){

	    $Data['test_id']                    = $this->uri->segment(4);
		$Data['rowlevelid']                 = $this->input->post('rowlevelid');
		$Data['subjectid']                  = $this->input->post('subjectid');
		$Data['type']                       = $this->input->post('type');
		// dd($Data['test_id']	);

	    for($i = 1 ; $i<= $_POST['count'] ; $i++ )

		{

			$Data['addQuestion']              = $this->input->post('addQuestion_'.$i);
			
			$Data['questions_content_ID']     = $this->input->post('questions_content_ID_'.$i);

			$Data['Degree']                   = $this->input->post('txt_Degree-'.$i);
			$x = '';
            if($Data['addQuestion'] == 1){
                // dd('ASDSA');
				$addQues                             = $this->postAPIData('https://chat.lms.esol.com.sa/apikey/bank/question/store?id='.$Data['questions_content_ID'].'&apikey='. $this->data['apikey'].'&deegre='.$Data['Degree'].'&testId='.$Data['test_id'],$x);
				// dd($addQues);
			}
		}

		$data = json_decode($addQues, true); // Decode the JSON string and convert to an associative array

		$status = $data['status'];

		if ($status == true) {

			$this->session->set_flashdata('SuccessAdd', lang('br_add_suc'));

			redirect('emp/exam_new/create_exam/'.$Data['rowlevelid']."/".$Data['subjectid']."/".$Data['type']."/".$Data['test_id'], 'refresh');

		}else{

			$this->session->set_flashdata('Failuer', lang('br_add_suc'));

			redirect('emp/exam_new/create_exam/'.$Data['rowlevelid']."/".$Data['subjectid']."/".$Data['type']."/".$Data['test_id'], 'refresh');
		}
	
   }

	public function bank_view()
	{
		isset($_GET['id']) ? $Data["get"] = $_GET['id'] : null;
		isset($_GET['bankId']) ? $Data["bankId"] = $_GET['bankId'] : null;
		$Data['questions'] = $this->ApiGet("https://chat.lms.esol.com.sa/apikey/bank/questions/2?apikey=" . $this->data['apikey'])['data'];
		$Data['question_type'] = $this->exam_new_model->get_Type_question();

		$this->load->emp_template('bank_viwe', $Data);
	}
	/////////////////////////////////////////////////////
	public function ques_type()
	{
		$Data['Lang']                  = $this->session->userdata('language');
		$Data['Timezone']              = $this->data['date'];
// 		$Data['rowlevelid']            = $this->uri->segment(4);
		$Data['type']                  = $this->uri->segment(4);
		$Data['test_id']               = $this->uri->segment(5);
		$Data['Type_question_ID']      = $this->uri->segment(6);
		$Data['question_ID']           = $this->uri->segment(7);
		$Data['test_data']             = $this->exam_new_model->get_test_data($Data['test_id']);
		$Data['questions']             = $this->exam_new_model->get_question($Data['test_id']);
		$Data['Type_question']         = $this->exam_new_model->get_Type_question();
		$Data['question_type']         = $this->exam_new_model->get_Type_question_by_id($Data['Type_question_ID']);
		$Data['TotalDegree']         = $this->exam_new_model->getTotalDegree($Data['test_id']);
		if($Data['test_data']['examDegree']){ 
			$Data['AbleDegree'] = $Data['test_data']['examDegree']  - $Data['TotalDegree'] ;
			
		}
		if ($Data['question_ID']) {
			$Data['answers']     = $this->exam_new_model->get_question_data($Data['question_ID']);
			if($Data['test_data']['examDegree']){
			$Data['TotalDegree'] ? $Data['AbleDegree'] += $Data['answers'][0]->Degree: null;
			}
		}
	
		$this->load->emp_template('add_questions', $Data);
	}


	public function bank_question()
	{
		// print_r($_POST);die;

		isset($_GET['id']) ? $Data["get"] = $_GET['id'] : $Data["get"] = 3;
		// isset($_GET['bankId']) ? $Data["bankId"] = $_GET['bankId'] : null;
		if (isset($_POST['bankId'])) {
			$Data["bankId"] = $_POST['bankId'];
		}
		if (isset($_GET['bankId'])) {
			$Data["bankId"] = $_GET['bankId'];
		}
		// isset($_POST['bankId']) ? $Data["bankId"] = $_POST['id'] : $Data["bankId"] = 3;
		// $Data["bankId"] = $_POST['bankId'];
		// $Data['questions'] = $this->ApiGet("https://chat.lms.esol.com.sa/apikey/bank/questions/2?apikey=chat.lms.esol.com.sa")['data'];
		// print_r($Data['questions']);die;
		$Data['Type_question']         = $this->exam_new_model->get_Type_question();

		// chat.lms.esol.com.sa/apikey/bank/questions/2?apikey=chat.lms.esol.com.sa

		// $Data['Lang']                  = $this->session->userdata('language');
		// $Data['Timezone']              = $this->data['date'];
		// // $Data['rowlevelid']            = $this->uri->segment(4);
		// // $Data['subjectid']             = $this->uri->segment(5);
		// // $Data['type']                  = $this->uri->segment(6);
		// // $Data['test_id']               = $this->uri->segment(7);
		// // $Data['Type_question_ID']      = $this->uri->segment(8);
		// $Data['question_ID']           = 110;
		// // $Data['test_data']             = $this->exam_new_model->get_test_data($Data['test_id']);
		// $Data['question_type']             = $this->exam_new_model->get_question(110);
		// $Data['question_type'] = $this->exam_new_model->get_Type_question();
		// $Data['question_type']         = $this->exam_new_model->get_Type_question_by_id($Data['Type_question_ID']);
		// if ($Data['question_ID']) {
		// 	$Data['answers']     = $this->exam_new_model->get_question_data($Data['question_ID']);
		// }

		// $Data['UserBanks'] = $this->ApiGet("https://chat.lms.esol.com.sa/apikey/bank?userID=" . $this->data['UID'] . "&apikey=chat.lms.esol.com.sa&toAdd=1");
		// $this->load->library('ci_pusher');
		// $pusher = $this->ci_pusher->get_pusher();
		// $pusher->trigger('test', 'event', 's');


		$this->load->emp_template('add_questions_bank', $Data);
	}
	/////////////////////////////////////////////////////
	public function get_answer_emp()
	{
		$Data['Timezone']              = $this->data['date'];
		$Data['rowlevelid']            = $this->uri->segment(4);
		$Data['subjectid']             = $this->uri->segment(5);
		$Data['type']                  = $this->uri->segment(6);
		$Data['test_id']               = $this->uri->segment(7);
		$Data['GetSemester']           = $this->exam_new_model->get_semester((string)$this->data['Lang']);
		$Data['subjectEmp_details']    = $this->exam_new_model->get_Subjects_test($Data);
		$Data['get_classes']           = $this->exam_new_model->get_classes_test();
		$Data['SemesterID']            =  $this->setting_model->get_semester();
		$Data['lessonsTitles']         = $this->exam_new_model->get_lessons_prep($Data['rowlevelid'], $Data['subjectid'], $Data['SemesterID']);
		$Data['Type_question']         = $this->exam_new_model->get_Type_question();
		if ($Data['test_id']) {
			$Data['test_data']         = $this->exam_new_model->get_test_data($Data['test_id']);
			$Data['questions']         = $this->exam_new_model->get_question($Data['test_id']);
			$Data['exam_student']          = $this->exam_new_model->get_exam_student($Data['test_id']);
		}
		$this->load->emp_template('frame_exam_stu', $Data);
	}
	//////////////////////////////////////////////////
	public function add_exam()
	{

		// dd($_POST);
		$Data['date']          = $this->data['date'];
// 		$Data['rowlevelid'] = $this->uri->segment(4);
		$Data['type']          = $this->uri->segment(4);
		$Data['test_id']       = $this->uri->segment(5);
		$Data['txt_exam']      = $this->input->post('txt_exam');
		$Data['txt_time']      = $this->input->post('txt_time') * 60;
		$Data['Date_from']     = $this->input->post('Date_from');
		$Data['Date_to']       = $this->input->post('Date_to');
		$Data['examDegree']    = $this->input->post('examDegree');
		$Data['IsActive']      = $this->input->post('IsActive');
		$Data['classType']     = implode(",",$this->input->post('ClassTypeName'));
		$Data['studeType']     = implode(",",$this->input->post('studeType'));
		$Data['SchoolId']      = $this->input->post('schoolID');
		$Data['levelId']       = $this->input->post('levelID');
		$Data['rowId']         = $this->input->post('rowID');
		$Data['statusId']      = implode(",",$this->input->post('status'));
        $row_level             = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/".$this->ApiDbname."/GetRowLevel?schoolId=".$Data['SchoolId']."&rowId=".$Data['rowId']."&levelId=".$Data['levelId']."&studyTypeId=".$Data['studeType']."&genderId=".$Data['classType']."&feeStatusId=".$Data['statusId']." "));
// 		$Data['rowlevelid']    = implode(",",array_column($row_level, 'RowLevelId'));
// 		$Data['rowLevelName']  = implode(",",array_column($row_level, 'RowLevelName'));
// 		$Data['schoolName']    = $row_level[0]['SchoolName'];
		$Data['rowlevelid']    = $row_level->RowLevelId;
		$Data['rowLevelName']  = $row_level->RowLevelName;
		$Data['schoolName']    = $row_level->SchoolName;

		$query1 = $this->db->select('Name')
			->from('contact')
			->where('ID', $this->data['UID'])
			->get();

		if ($Data['test_id']) {
			$Data['add_exam_ID'] = $this->exam_new_model->edit_exam($Data);
		} else {
			$Data['add_exam_ID'] = $this->exam_new_model->add_exam($Data);

			
		}


		if ($Data['add_exam_ID'] != false) {

			$test_id = $Data['add_exam_ID'];
		}
		redirect('/emp/exam_new/create_exam/'. $Data['type'] . "/" . $test_id, 'refresh');
	}
	/////////////////////////////////////////////////
	public function up_ax()
	{
		$this->data['msg_type']           = '';
		$this->data['msg_upload']         = '';
		$this->data['base']               = base_url();
		$file_element_name                = 'file';
		if (empty($_FILES[$file_element_name]['name'])) {
			$this->data['msg_type']           = '0';
			$this->data['msg_upload']         = 'File Empty ';
			$this->output->set_content_type('application/json')->set_output(json_encode($this->data));
		} else {
			$config['upload_path']   = './assets/exam/';
			$config['allowed_types'] = 'mp3|wav|aif|aiff|ogg|MP3|gif|jpg|png|jpeg|doc|docx|txt|text|zip|rar|pdf|mp4|ppt|pptx|pptm|xls|xlsm|xlsx|m4p|M4P|PNG';
			$config['encrypt_name']  = TRUE;
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload($file_element_name)) {
				$this->data['msg_type']           = '0';
				$this->data['msg_upload']         = $this->upload->display_errors();
				$this->output->set_header('Content-Type: application/json; charset=utf-8');
				$this->output->set_content_type('application/json')->set_output(json_encode($this->data));
			} else {
				$upload_data                      = $this->upload->data();
				$this->data['msg_type']           = '1';
				$this->data['msg_upload']         = 'msg_sucsess_upload';
				$this->data['img']                = $upload_data['file_name'];
				$this->output->set_header('Content-Type: application/json; charset=utf-8');
				$this->output->set_content_type('application/json')->set_output(json_encode($this->data));
			}
		} //END  File Upload 
	}
	//////////////////////////////////////////////////
	public function add_exam_question()
	{
		// print_r($_POST);die;
		$Data['question_type']        = $this->uri->segment(4);
		$Data['test_id']              = $this->uri->segment(5);
		$Data['question_id']          = $this->uri->segment(6);
		$Data['txt_question']         = $this->input->post('txt_question');
		$Data['title']      	      = $this->input->post('txt_question');
		$Data['txt_Degree']           = $this->input->post('txt_Degree');
		$Data['txt_attach']           = $this->input->post('hidImg');
		$Data['rowlevelid']           = $this->input->post('rowlevelid');
		$Data['type']                 = $this->input->post('Type_question_ID');
		$Data["UserID"]               = $this->session->userdata['id'];
        $Data['status']               = 1;


		if ($Data['question_id']) {

			$add = $this->exam_new_model->edit_exam_question($Data);
		} else {
			$add = $this->exam_new_model->add_exam_question($Data);
		}
		$Data['type'] =0;
		if ($add) {
			$Data['type']       = $this->exam_new_model->get_test_data($Data['test_id'])['type'];
			redirect('/emp/exam_new/create_exam/' . $Data['rowlevelid'] . "/" . $Data['type'] . "/" . $Data['test_id'], 'refresh');
		}
	}
	/////////////////////////////////////
	public function edit_exam_question()
	{

		$Data['question_ID']          = $this->uri->segment(4);
		$Data['test_id']              = $this->uri->segment(5);
		$Data['degree_difficulty']    = $this->input->post('difficult_degree' . $Data['question_ID']);
		$Data['txt_question']         = $this->input->post('txt_question' . $Data['question_ID']);
		$Data['txt_Degree']           = $this->input->post('txt_Degree' . $Data['question_ID']);
		$Data['txt_attach']           = $this->input->post('hidImg' . $Data['question_ID']);
		$Data['rowlevelid']           = $this->input->post('rowlevelid');
		$Data['subjectid']            = $this->input->post('subjectid');
		$Data['type']                 = $this->input->post('type');
		$Data['question_type']        = $this->input->post('Type_question_ID');
		if ($this->exam_new_model->edit_exam_question($Data)) {
			redirect('/emp/exam_new/create_exam/' . $Data['rowlevelid'] . "/" . $Data['type'] . "/" . $Data['test_id'], 'refresh');
		}
	}
	///////////////////////////////////////
	public function exam_question()
	{

		$Data['type']                 = $this->input->post('type');

		$Data['rowlevelid']           = $this->input->post('rowlevelid');

		$Data['subjectid']            = $this->input->post('subjectid');

		$Data['Type_question_Name']   = $this->input->post('Type_question_Name');

		$Data['Type_question_ID']     = $this->input->post('Type_question_ID');

		$Data['test_id']              = $this->input->post('test_id');


		$this->load->view('emp_new/exam_question', $Data);
	}
	/////////////////////////////////////
	public function del_exam_question()
	{

		$Timezone          = $this->data['date'];
		$Questions_ID      = $this->uri->segment(4);
		$Data   = $this->db->query("select test.* from test inner join questions_content on test.ID=questions_content.test_id where questions_content.ID=$Questions_ID  ")->row_array();
		$this->exam_new_model->del_exam_question($Questions_ID);
		redirect('/emp/exam_new/create_exam/'. $Data['type'] . "/" . $Data['ID'], 'refresh');
	}
	/////////////////////////////
	public function follow_attendance()
	{
		$data['ID']             = $this->uri->segment(4);
		$data['RowlevelID']     = $this->uri->segment(5);
		$data['subjectid']      = $this->uri->segment(6);
		$data['type']           = $this->uri->segment(7);
		$data['exam_details']   = $this->exam_new_model->get_exam_by_id($data);

		$this->load->emp_template('follow_attendance', $data);
	}
	/////////////////////////////
	public function follow_attendance_show()
	{
		$data['ID']             = $this->uri->segment(4);
		$dataResponse['data']   = $this->exam_new_model->get_all_data($data);
		$this->output->set_content_type('application/json')->set_output(json_encode($dataResponse));
	}
	/////////////////////////////
	public function get_student($class, $RowLevel)
	{

		$School_id                      = (int)$this->session->userdata('SchoolID');
		$result                         = $this->exam_new_model->get_student_repeat($School_id, $RowLevel, $class);
		echo json_encode($result);
	}
	//////////////////////
	public function del_student()
	{
		$data['test_id']         = (int)$this->uri->segment(4);
		$id                      = (int)$this->uri->segment(5);
		$CheckAdd                = $this->exam_new_model->get_student($data['test_id']);
		$students                = $CheckAdd[0]->num_student;
		$arr1                    = explode(",", $students);
		$my_array                = array_diff($arr1, array($id));
		$arr2                    = implode(",", $my_array);
		$query                   = $this->db->query("UPDATE test SET num_student='" . $arr2 . "' where ID=" . $data['test_id'] . " ");
		if ($query) {
			$this->session->set_flashdata('SuccessAdd', lang('br_add_suc'));
			redirect('emp/exam_new/repet_exam/' . $data['test_id'], 'refresh');
		} else {
			$this->session->set_flashdata('ErrorAdd', lang('br_add_error'));
			redirect('emp/exam_new/repet_exam/' . $data['test_id'], 'refresh');
		}
	}


}