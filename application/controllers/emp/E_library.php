<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class E_Library extends CI_Controller
{

	private $data = array();

	function __construct()
	{
		parent::__construct();
		$this->load->model(array('e_library_model', 'config/config_subjects_model', 'config/config_levels_rows_model', 'emp/emp_class_table_model', 'emp/lessons_model', 'emp/exam_new_model', 'emp/subject_model', 'emp/homework_new_model', 'admin/setting_model'));
		$this->load->library('get_data_emp');
		$this->data['UID']            = $this->session->userdata('id');
		$this->data['YearID']         = $this->session->userdata('YearID');
		$this->data['Year']           = $this->session->userdata('Year');
		$this->data['Semester']       = $this->session->userdata('Semester');
		$this->data['Lang']           = $this->session->userdata('language');
		$this->data['SchoolID']       = $this->session->userdata('SchoolID');
	}
	public function review_methodSubject($RowLevelID = 0, $SubjectID  = 0, $SemesterID = 0)
	{
		$Data['Semesters']  	   = $this->e_library_model->get_semesters();
		$Data['SubjectID']         = $SubjectID;
		$Data['RowLevelID']        = $RowLevelID;
		$Data['SemesterIDUrl']     = $SemesterID;
		if (!$Data['SemesterIDUrl']) {
			$Data['SemesterIDUrl']    =  $this->setting_model->get_semester();
		}
		$Data['ContactID']         = $this->data['UID'];
		$Data['mLib'] 			   = $this->e_library_model->load_methodLib($Data);

		$this->load->emp_template('review_m_library', $Data);
	}
	///////////////////////////////
	public function show_library()
	{
		$Revision_ID = (int) $this->uri->segment(4);
		$Data['datails'] = $this->e_library_model->get_e_library_details($Revision_ID);
		$this->load->emp_template('e_library_detials', $Data);
	}

	///////////////////////////
	public function empMethodSubject()
	{
		$Data['Semesters']  	      = $this->e_library_model->get_semesters();
		$Data['SemesterID']            = $this->setting_model->get_semester();;
		$Data['RowLevelID']           = $this->uri->segment(4);
		$Data['SubjectID']            = $this->uri->segment(5);
		$Data['RevisionID']           = $this->uri->segment(6);
		if ($Data['RevisionID']) {
			$Data['mFileData'] 	          = $this->e_library_model->getMFileData($Data['RevisionID']);
		}
		$Data['SemesterID']           = $this->setting_model->get_semester();
		$Data['lessonsTitles']        = $this->e_library_model->get_lessons_prep($Data);
		$Data['get_classes']          = $this->e_library_model->get_classes($Data['RowLevelID'], $Data['SubjectID']);
		$this->load->emp_template('add_m_library_emp', $Data);
	}
	//////////////////////////////
	public function add_emp_e_library()
	{

		$Data['img'] = "";

		if (empty($_FILES['userfile']['name'])) {
			$Old_Img       = $this->input->post('Old_Img');
			$data['img']   = $Old_Img;
		} ///////////// END IF EMPTY FILE ;
		else {
			//START  File Upload 
			$config['upload_path']   = './assets/e_library/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['encrypt_name']  = TRUE;
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload()) {
				$error = array('error' => $this->upload->display_errors());
				$this->edit_contact();
			} ////////END IF CHECK ! UPLOAD 
			else {
				$data = array('upload_data' => $this->upload->data());
				//create largest dimension 480 px
				$config['image_library'] = 'gd2';
				$config['source_image'] = $data['upload_data']['full_path'];
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = TRUE;
				$config['width']   = 200;
				$config['height']  = 200;
				$config['quality'] = 95;
				$this->load->library('image_lib', $config);
				$this->image_lib->initialize($config);
				if (!$this->image_lib->resize()) {
					$error = $this->image_lib->display_errors();
					$this->edit_contact();
				}
			}
			$upload_data          = $this->upload->data();
			$data['img']          = $upload_data['file_name'];
		} //////// END ELSE UPLOAD 

		$valid_extension_txt   = array('doc', 'docx', 'xls', 'xlsx', 'pdf', 'csv', 'pptx', 'gif', 'jpeg', 'jpg', 'jpe', 'png', 'text', 'word', 'ppt', 'gz', 'zip');
		$valid_extension_audio = array('mp3', 'mp4', 'wav', 'mid', 'midi', 'mp2', 'aif', 'aiff', 'aifc', 'ram', 'rm', 'rpm', 'ra');
		$valid_extension_video = array('rv', 'mpeg', 'mpg', 'mpe', 'qt', 'mov', 'avi', 'movie', 'flv', 'swf');
		$ext = pathinfo($data['img'], PATHINFO_EXTENSION);
		//exit($ext);
		$data['AddType'] = 1;
		if (in_array($ext, $valid_extension_txt)) {
			$data['AddType'] = 1;
		}
		if (in_array($ext, $valid_extension_audio)) {
			$data['AddType'] = 2;
		}
		if (in_array($ext, $valid_extension_video)) {
			$data['AddType'] = 3;
		}

		$data['date']             = $this->setting_model->converToTimezone();
		$data['UID']              = (int)$this->data['UID'];
		$data['MethodID']         = 1;
		$data['RevisionID']       = (int)$this->input->post('RevisionID');
		$data['RowLevelID']       = (int)$this->input->post('RowLevelID');
		$data['SubjectID']        = (int)$this->input->post('SubjectID');
		$data['select_semester']  = (int)$this->input->post('select_semester');
		$data['fileTitle']   	  = $this->input->post('fileTitle');
		$data['VedioID']          = $this->input->post('txt_Script');
		// print_r($data['img']);die;
		$data['lessonsTitles']    = $this->input->post('lessonsTitles');
		$data['slct_class']       =  implode(',', $this->input->post('slct_class'));
		$RowLevelID               = (int)$this->input->post('RowLevelID');
		$SubjectID                = (int)$this->input->post('SubjectID');
		if ($this->e_library_model->add_emp_e_library($data)) {
			$query1 = $this->db->select('Name')
				->from('contact')
				->where('ID', $this->data['UID'])
				->get();
			$result1 = $query1->row();
			$contactName = $result1->Name;
			$query2 = $this->db->select('Name')->from('subject')->where('ID', $SubjectID)->get();
			$result2 = $query2->row();
			$subName = $result2->Name;
			
			
			$eventName = 'Createlibarary';
			$NotfyMessage = "قام المعلم " . $contactName . " بإضافة مراجعة جديد في مادة " . $subName;
			
			//إرسال الاشعار 
			$this->load->library('ci_pusher');
			$pusher = $this->ci_pusher->get_pusher();
			foreach ($_POST['slct_class'] as $a) {
				$School_id = $this->data['SchoolID'];
				$chanelID = $a . '-' . $RowLevelID . '-' . $School_id;

				$pusher->trigger($_SERVER['SERVER_NAME'] . 'Class' . $chanelID, $eventName, $NotfyMessage);
			} 
			$this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));
			redirect('emp/e_library/review_methodSubject/' . $RowLevelID . '/' . $SubjectID . '', 'refresh');
		} else {
			$this->load->library('ci_pusher');

			$pusher = $this->ci_pusher->get_pusher();
			$pusher->trigger('test', 'event', 's');
			$this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));
			redirect('emp/e_library/review_methodSubject/' . $RowLevelID . '/' . $SubjectID, 'refresh');
		}
	}
	//////////////////////////////
	public function student_report()
	{
		$Data['ID']          = $this->uri->segment(4);
		$Data['GetData']     = $this->e_library_model->student_revision_report($Data);
		$this->load->emp_template('student_revision_report', $Data);
	}
	////////////////////////////////
	public function delete_elibrary($FileID = 0, $RowLevelID = 0, $SubjectID = 0)
	{
		$this->db->query("DELETE FROM e_library  WHERE ID ='" . $FileID . "' ");
		redirect('emp/e_library/review_methodSubject/' . $RowLevelID . '/' . $SubjectID . '', 'refresh');
	}
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
			$config['upload_path']   = './assets/e_library/';
      $config['allowed_types'] = 'mp3|wav|aif|aiff|ogg|MP3|gif|jpg|png|jpeg|doc|docx|txt|text|zip|rar|pdf|mp4|ppt|pptx|pptm|xls|xlsm|xlsx|m4p|M4P|mov|avi|mkv|wmv|flv|webm|m4v|mpeg|mpg|3gp|3g2';
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
}////// END CLASS