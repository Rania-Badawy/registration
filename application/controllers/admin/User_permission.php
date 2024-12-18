<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_Permission extends MY_Admin_Base_Controller
{

	private $data = array();

	function __construct()

	{

		parent::__construct();

		$this->load->model(array('admin/user_permission_model', 'admin/config_model', 'admin/setting_model'));

		$this->load->library('get_data_admin');

		$this->data['UID']            = $this->session->userdata('id');

		$this->data['YearID']         = $this->session->userdata('YearID');

		$this->data['Year']           = $this->session->userdata('Year');

		$this->data['Semester']       = $this->session->userdata('Semester');

		$this->data['Lang']           = $this->session->userdata('language');

		$this->data['SchoolID']       = $this->session->userdata('SchoolID');

		$get_api_setting              = $this->setting_model->get_api_setting();

		$this->ApiDbname              = $get_api_setting[0]->{'ApiDbname'};
	}

	//////index

	public function index($UserID = 0)

	{

		$this->data['UserID']      = $UserID;

		$this->data['CheckUserPer']  = $this->user_permission_model->get_user_per_by_id($this->data['UserID']);



		$this->data['PerType']     = array();

		$this->data['Type']        = 0;

		$this->data['DateFromH']   = "";

		$this->data['DateToH']     = "";

		if (is_array($this->data['CheckUserPer'])) {

			$this->data['PerType']     = explode(',', $this->data['CheckUserPer']['PerType']);

			$this->data['Type']        = $this->data['CheckUserPer']['Type'];

			$this->data['DateFromH']   = $this->data['CheckUserPer']['DateFromH'];

			$this->data['DateToH']     = $this->data['CheckUserPer']['DateToH'];
		}



		$this->data['GetLevel']    = $this->user_permission_model->get_level($this->data['Lang']);

		$this->data['GetRowLevel'] = $this->user_permission_model->get_row_level_school($this->data['Lang']);

// 		$this->data['GetSubject']  = $this->user_permission_model->get_subject();

// 		$this->data['GetClass']    = $this->user_permission_model->get_Class($this->data['Lang']);

		$this->data['GetGroup']    = $this->user_permission_model->get_group();

		$this->data['get_emp']     = $this->user_permission_model->get_emp($this->data['SchoolID']);

		$this->data['get_page']    = $this->user_permission_model->get_page_permission();

		$this->load->admin_template('view_user_permission', $this->data);
	}
	
		///////////////////////////////////////

	public function group_page($GroupID = 0)

	{

		$this->data['GroupID']     = $GroupID;

		$this->data['CheckGroup']  = $this->user_permission_model->get_group_by_id($this->data['GroupID']);

		$this->data['GetGroup']    = $this->user_permission_model->get_group();

		$this->data['get_page']    = $this->user_permission_model->get_page_permission();

		$this->load->admin_template('view_group_page', $this->data);
	}
	
	///////////////////////////////////////////
	
		public function per_group($ID = 0)

	{

		$this->data['GetID'] = (int)$ID;


		$this->data['Name']     = '';

		$this->data['Isactive'] = 0;

		$this->data['GetGroup'] = $this->user_permission_model->get_group_by_id($this->data['GetID']);

	

		if (is_array($this->data['GetGroup']) && $ID) {

			$this->data['Name']     = $this->data['GetGroup']['Name'];

			$this->data['IsActive'] = $this->data['GetGroup']['IsActive'];
		}

		

		$this->data['GetAllPer'] = $this->user_permission_model->get_group();

		$this->load->admin_template('view_per_group', $this->data);
	}
	
	
	////////////////////////////////////
	public function del_group($ID = 0)

	{


		if ($this->user_permission_model->del_group($ID)) {

			$this->session->set_flashdata('Sucsess', lang('am_delete_suc'));
		} else {

			$this->session->set_flashdata('Failuer', lang('am_op_error'));
		}

		redirect('admin/user_permission/per_group', 'refresh');
	}
	
	////////////////////////////
	
		public function emp_group($GroupID = 0)

	{
		
		$this->data['GetClassType']     = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllClassTypes"));

		$this->data['GetStudyType']     = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllStudyTypes"));
		
		$this->data['get_schools']     = json_decode(file_get_contents(lang('api_link')."/api/Schools/" . $this->ApiDbname . "/GetAllSchools"));
		
		$this->data['row_level']       = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllLevels"));
		

		$this->data['GroupID']          = $GroupID;

		$this->data['GetGroup']         = $this->user_permission_model->get_group_by_id($GroupID);

		$this->data['GetAllEmp']        = $this->user_permission_model->get_contact();

		$this->data['GetLevel']         = $this->user_permission_model->get_level($this->data['Lang']);

 		$this->data['GetRowLevel']      = $this->user_permission_model->get_row_level_school($this->data['Lang']);



		$this->data['GetSchool']        = $this->user_permission_model->get_school();

		$this->data['request_type']     = $this->config_model->get_request_type();

	

		$this->data['get_status']       = $this->config_model->get_status();


		$this->load->admin_template('view_emp_group', $this->data);
	}
	
	//////////////////////////////////////
		public function check_emp_permission()

	{

		$this->data['GetClassType']    = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllClassTypes"));
		$this->data['GetStudyType']    = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllStudyTypes"));
		$this->data['get_schools']     = json_decode(file_get_contents(lang('api_link')."/api/Schools/" . $this->ApiDbname . "/GetAllSchools"));
		$this->data['row_level']       = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllLevels"));
		

		$this->data['EmpID']           = $this->input->post('EmpID');

		$this->data['GroupID']         = $this->input->post('GroupID');

	


		$this->data['GetGroup']        = $this->user_permission_model->get_group_by_id($this->data['GroupID']);

		$this->data['EmpData']         = $this->user_permission_model->get_emp_by_id($this->data['EmpID']);
	//	print_r(	$this->data['EmpData'] );die;

		$this->data['request_type']    = $this->user_permission_model->get_request_type();



		$this->data['PerType']         = array();

		$this->data['Type']            = 0;

		$this->data['Branch']          = 0;

		$this->data['GroupName']       = '';

		$this->data['ContactName']     = '';

		if (is_array($this->data['EmpData'])) {

			$this->data['PerType']     = explode(',', $this->data['EmpData']['Level']);

			$this->data['Branch']      = explode(',', $this->data['EmpData']['Branch']);

			$this->data['req_type']    = explode(',', $this->data['EmpData']['req_type']);

// 			$this->data['category']    = explode(',', $this->data['EmpData']['category']);

			$this->data['Type']        = $this->data['EmpData']['Type'];
// 			$this->data['user']['Type']        = $this->data['EmpData']['Type'];

			$this->data['GroupName']   = $this->data['EmpData']['GroupName'];

			$this->data['NameSpaceID'] = $this->data['EmpData']['NameSpaceID'];

			$this->data['ContactName'] = $this->data['EmpData']['ContactName'];

			$this->data['ClassType']   = explode(',', $this->data['EmpData']['ClassType']);

			$this->data['StudyType']   = explode(',', $this->data['EmpData']['StudyType']);
		}
		if ($this->data['user']['Type'] == 4) {
			$input = $this->data["PerType"];
			$result = array();
			$rowlevel = array();
			foreach ($input as $part) {
				list($key, $value) = explode('|', $part);
				$subjectrowlevel[]=$key;
				if (array_key_exists($key, $result)) {
					$result[$key][] = $value;
				} else {
					$result[$key] = array($value);
				}
			}
			$this->data['subjectrowlevel'] = $subjectrowlevel;

			$this->data['subjectData'] = $result;
		}

	


		$this->load->view('admin/view_check_emp_group', $this->data);
	}
	
	
	
	////////edit_per_group

	public function edit_per_group($ID = 0)

	{

		$this->data['ID']             = $ID;

		$this->data['Name']           = filter_var($this->input->post('Name'), FILTER_SANITIZE_STRING);


		$this->data['IsUpdate']       = 1;

		$this->data['IsActive']       = 1;

		if ($this->user_permission_model->edit_group($this->data)) {

			$this->session->set_flashdata('Sucsess', lang('br_add_suc'));
		} else {

			$this->session->set_flashdata('Failuer', lang('br_add_error'));
		}

		redirect('admin/user_permission/per_group', 'refresh');
	}
	



	///////////////////////////////////
	
		public function add_group_emp()

	{
	
			$data['class_type']    = $this->input->post('class_type');

			$data['study_type']    = $this->input->post('study_type');
		

		$data['EmpID']         = $this->input->post('EmpID');

		$data['Branch']        = $this->input->post('Branches');

		$data['Type']          = $this->input->post('Type');

		$data['PerType']       = $this->input->post('PerType');

		$data['GroupID']       = $this->input->post('GroupID');

		$data['reg_type']      = $this->input->post('reg_type');

		$data['req_type']      = $this->input->post('req_type');
		
		

	



		if ($this->user_permission_model->add_group_emp($data)) {
			echo lang("br_add_suc");
		}
	}

	///////////////

	public function remove_emp_permission()

	{

		$this->data['EmpID']         = $this->input->post('EmpID');

		$this->user_permission_model->remove_emp_permission($this->data['EmpID']);

		echo lang("br_add_suc");
	}
	
	
	////////////////////////



	public function get_subject()
	{
		$data['EmpData']         = $this->user_permission_model->get_emp_by_id($this->input->get('EmpID'));

		if (is_array($data['EmpData'])) {

			$data['PerType']     = explode(',', $this->data['EmpData']['PerType']);

		}
		$userrowlevelid = explode(',', $data['EmpData']['PerType']);

		$rowLevelIds = $this->input->get('rowLevelId');

		$subjects = array();
		if (!empty($rowLevelIds)) {
			if (!is_array($rowLevelIds)) {
				$rowLevelIds = explode(',', $rowLevelIds);
			}

			foreach ($rowLevelIds as $rowLevelId) {
				$rowLevelSubjects = $this->user_permission_model->get_subject_rowlevel_id($rowLevelId);

				echo '  <optgroup label="' . $rowLevelSubjects[0]->Levelname . "--" . $rowLevelSubjects[0]->RowName . '">';
				foreach ($rowLevelSubjects as $subject) {
					$id =  $rowLevelId . "|" . $subject->SubjectID;
					echo '<option '.(in_array($id, $userrowlevelid) ? 'selected' : '').' value="' . $id . '">' . $subject->SubName . '</option>';
				}
				echo '</optgroup>';
			}
		}
	}
	
	
		////////////////////////////////////////////////

	public function add_group_page($GroupID = 0)

	{

		$Count = $this->input->post('KeyPage');

		$this->data['GetGroup']   = $this->input->post('GetGroup');

		$this->data['IsAdmin']    = (int)$this->input->post('IsAdmin');

		$this->data['type']       = 0;

		$this->data['Branches']   = "";

		$this->data['PerType']    = '';

		$this->user_permission_model->update_group_data($this->data);

		$this->user_permission_model->delete_group_page($GroupID);

		for ($i = 0; $i <= $Count; $i++) {

			$this->data['ChkAdd']   = (int)$this->input->post('ChkAdd' . $i);

			$this->data['ChkEdit']  = (int)$this->input->post('ChkEdit' . $i);

			$this->data['ChkDel']   = (int)$this->input->post('ChkDel' . $i);

			$this->data['ChkView']  = (int)$this->input->post('ChkView' . $i);

			$this->data['PageID']   = (int)$this->input->post('pageID' . $i);

			if ($this->data['ChkAdd'] == 1 || $this->data['ChkEdit'] == 1 || $this->data['ChkDel'] == 1 || $this->data['ChkView'] == 1) {
                if($this->data['ChkAdd'] == 1 || $this->data['ChkEdit'] == 1 || $this->data['ChkDel'] == 1){
					$this->data['ChkView'] =1;
				}
				$this->user_permission_model->add_group_page($this->data);
			}
		}
		$this->session->set_flashdata('SuccessAdd', lang('br_add_suc'));

		redirect('admin/user_permission/group_page/' . $this->data['GetGroup'] . '', 'refresh');
	}
	
	////////////////////

	public function copy_group_page($GroupID = 0, $CopyGroupID = 0)

	{

		if ($this->user_permission_model->copy_group_page($GroupID, $CopyGroupID)) {

			$this->session->set_flashdata('Sucsess', lang('br_add_suc'));
		} else {

			$this->session->set_flashdata('Failuer', lang('br_add_error'));
		}



		redirect('admin/user_permission/group_page/' . $GroupID . '', 'refresh');
	}
	/////     end 


}/////////////END CLASS