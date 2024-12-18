<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Config_System extends MY_Admin_Base_Controller
{
	private $data = array();
	function __construct()
	{
		parent::__construct();
		$this->load->model(array( 'admin/config_model', 'admin/setting_model', 'admin/Config_model', 'admin/mobile_model'));
		//$this->load->library('get_data_admin');
		$this->data['UID']            = $this->session->userdata('id');
		$this->data['YearID']         = $this->session->userdata('YearID');
		$this->data['Year']           = $this->session->userdata('Year');
		$this->data['Semester']       = $this->session->userdata('Semester');
		$this->data['Lang']           = $this->session->userdata('language');
		$get_api_setting              = $this->setting_model->get_api_setting();
		$this->ApiDbname              = $get_api_setting[0]->{'ApiDbname'};
	}
	//////
	public function index()
	{
		$ID                               = $this->uri->segment(4);
		$this->data['get_year']           = $this->config_system_model->get_allYear();
		if ($ID) {
			$this->data['get_specific_year']  = $this->config_system_model->get_specific_year($ID);
		}
		$this->load->admin_template('view_config_system', $this->data);
	}
	
	//////////////////////////////
	public function config_accounts_erp()
	{
		$query = $this->db->query("SELECT `IN_ERP` FROM `school_details` ")->row_array();

		$Data['confige'] = $query['IN_ERP'];

		$this->load->admin_template('view_config_accounts_erp', $Data);
	}
	/////////////////////////////////////
	
	public function config_form_register()
	{
		$Data['form_main']        = $this->config_model->get_config_register_main();
		$Data['form_father']      = $this->config_model->get_config_register_father();
		$Data['form_mother']      = $this->config_model->get_config_register_mother();
		$Data['form_student']     = $this->config_model->get_config_register_student();
		$Data['form_public']      = $this->config_model->get_config_register_public();
		$Data['form_psy']         = $this->config_model->get_config_register_psy();
		$Data['form_medical']     = $this->config_model->get_config_register_medical();

		$this->load->admin_template('config_register_view', $Data);
	}

	/////////////////////
	public function deActivateInput()

	{

		$data['ID'] = $this->uri->segment(4);

		if ($this->Config_model->de_active_input($data)) {
			$this->session->set_flashdata('Sucsess', lang('br_add_suc'));

			redirect('admin/config_system/config_form_register', 'refresh');
		} else {
			echo 'error';
		}
	}


	public function activateInput()

	{
		$data['ID'] = $this->uri->segment(4);

		if ($this->Config_model->active_input($data)) {
			$this->session->set_flashdata('Sucsess', lang('br_add_suc'));

			redirect('admin/config_system/config_form_register', 'refresh');
		} else {
			echo 'error';
		}
	}
	/////////////////////////////////////////////// 

	public  function  active_input_required()
	{

		$settingID = $this->input->post('settingID');

		$query = $this->db->query("SELECT * FROM form_setting where ID = '" . $settingID . "' ")->row_array();

		if ($query['required'] == 1) {
			$this->db->query("UPDATE `form_setting` SET `required` = 0 WHERE ID = '" . $settingID . "' ");
		} else {

			$this->db->query("UPDATE `form_setting` SET `required` = 1 WHERE ID = '" . $settingID . "' ");
		}
	}
	///////////// 

	public function active_input_hij()
	{

		$settingID = $this->input->post('settingID');

		$query = $this->db->query("SELECT * FROM form_setting where ID = '" . $settingID . "' ")->row_array();

		if ($query['hij_date'] == 1) {
			$this->db->query("UPDATE `form_setting` SET `hij_date` = 0 WHERE ID IN(248,239,238,232,231,227) ");
		} else {

			$this->db->query("UPDATE `form_setting` SET `hij_date` = 1 WHERE ID IN(248,239,238,232,231,227) ");
		}
	}
	
	///////////// last update 
	public function new_year()
	{
		$arr = [];
		$this->data['YearFrom']        = $this->input->post('YearFrom');
		$this->data['YearTo']          = $this->input->post('YearTo');
		$this->data['year_name_hij']   = $this->input->post('year_name_hij');
		$this->data['ID']              = $this->input->post('ID');
		$get_schools                   = json_decode(file_get_contents(lang('api_link')."/api/Schools/" . $this->ApiDbname . "/GetAllSchools"));
		foreach ($get_schools as $val) {
			$schoolId                  = $val->SchoolId;
			$GetYear                   = json_decode(file_get_contents(lang('api_link')."/api/Years/" . $this->ApiDbname . "/GetOpenedYearsBySchoolId?schoolId=$schoolId"));
			$year                      = end($GetYear);
			array_push($arr, $year->YearId);
		}
		$this->data['ID_ERP'] = implode(',', $arr);

		$GetDataYear                   = $this->config_system_model->new_year($this->data);
		if ($GetDataYear) {
			$this->session->set_flashdata('msg', 'lang:br_add_suc ');
			redirect('admin/config_system', 'refresh');
		} else {
			$this->session->set_flashdata('msg', 'lang:br_add_error ');
			redirect('admin/config_system', 'refresh');
		}
	}

	public function deActivateEmployment()

	{

		$data['ID'] = $this->uri->segment(4);

		if ($this->Config_model->de_active_input($data)) {
			$this->session->set_flashdata('Sucsess', lang('br_add_suc'));

			redirect('admin/config_system/config_recruitment_form', 'refresh');
		} else {
			echo 'error';
		}
	}

	///////////////////////////////////////
	public function activateEmployment()

	{
		$data['ID'] = $this->uri->segment(4);

		if ($this->Config_model->active_input($data)) {
			$this->session->set_flashdata('Sucsess', lang('br_add_suc'));

			redirect('admin/config_system/config_recruitment_form', 'refresh');
		} else {
			echo 'error';
		}
	}
	///////////// 
	public function config_class_table_degree()
	{
		$Data['emp_config']      = $this->config_model->get_config_class_table_degree();
		$this->load->admin_template('view_config_class_table_degree', $Data);
	}
	/////////////////////
	public function add_config_class_table_degree()
	{
		$data['date']                          = $this->setting_model->converToTimezone();
		$data['Token']                         = $this->security->xss_clean($this->input->post('Token'));
		$data['TestMark']                      = (int)$this->input->post('TestMark');
		$data['DelVirtualClass']               = (int)$this->input->post('DelVirtualClass');
		$data['EditVirtualClass']              = (int)$this->input->post('EditVirtualClass');
		$data['HomeDegree']                    = (int)$this->input->post('HomeDegree');
		$data['classTableShow']                = (int)$this->input->post('classTableShow');
		$data['exam_result']                   = (int)$this->input->post('exam_result');
		$data['appear_exam_result_after']      = (int)$this->input->post('appear_exam_result_after');
		$data['homework_result']               = (int)$this->input->post('homework_result');
		$data['appear_homework_result_after']  = (int)$this->input->post('appear_homework_result_after');
		if ($this->config_model->add_config_class_table_degree($data)) {
			$this->session->set_flashdata('SuccessAdd', lang('br_add_suc'));
			redirect('admin/config_system/config_class_table_degree');
		} else {
			$this->session->set_flashdata('ErrorAdd', lang('br_add_error'));
			redirect('admin/config_system/config_class_table_degree');
		}
	}
	//////////////////////////
	public function basic_non_basic_subject()
	{
		$Data['emp_config']      = $this->config_model->get_config_class_table_degree();
		// 		print_r($Data['emp_config']);die;
		$this->load->admin_template('view_basic_non_basic_subject', $Data);
	}
	/////////////////////
	public function add_basic_non_basic_subject()
	{
		$data['date']               = $this->setting_model->converToTimezone();
		$data['contactID']       	= $this->session->userdata('id');
		$data['subjectname']		= filter_var($this->input->post('subjectname'), FILTER_SANITIZE_STRING);
		$data['subject_type']       = $this->input->post('subject_type');
		if ($this->config_model->add_basic_non_basic_subject($data)) {
			$this->session->set_flashdata('SuccessAdd', lang('br_add_suc'));
			redirect('admin/config_system/basic_non_basic_subject');
		} else {
			$this->session->set_flashdata('ErrorAdd', lang('br_add_error'));
			redirect('admin/config_system/basic_non_basic_subject');
		}
	}
	////////////////////////

	///////class_table_master
	public function class_table_master()
	{
		$this->data['check_year']    = $this->config_system_model->check_year($this->data['YearID']);
		$this->data['get_day']       = $this->config_system_model->get_day($this->data['Lang']);
		$this->data['config_class']  = $this->config_system_model->get_config_class_table($this->data['Lang']);
		$this->load->admin_template('view_class_table_master', $this->data);
	}
	////add_new_config
	public function add_new_config()
	{
		$this->form_validation->set_rules('select_start_day', 'lang:br_start_day', 'is_natural_no_zero|xss_clean');
		$this->form_validation->set_rules('select_end_day', 'lang:br_end_day', 'is_natural_no_zero|xss_clean');

		if ($this->form_validation->run() === false) {
			$this->class_table_master();
		} else {
			$this->data['start_day']   = (int)$this->input->post('select_start_day');
			$this->data['end_day']     = (int)$this->input->post('select_end_day');
			$GetDataConfig             = $this->config_system_model->add_new_config($this->data);
			if ($GetDataConfig) {
				$this->session->set_flashdata('msg', 'lang:br_add_suc ');
				redirect('admin/config_system/class_table_master', 'refresh');
			} else {
				$this->session->set_flashdata('msg', 'lang:br_add_error ');
				redirect('admin/config_system/class_table_master', 'refresh');
			}
		}
	}
	////////////////////
	//////////////////////////
	public function get_complaints()
	{
		$Data['request_type']  = $this->config_model->get_request_type();

		$Data['get_category']  = $this->config_model->get_category($this->data['Lang']);

		$Data['get_status']  = $this->config_model->get_status($this->data['Lang']);

		$this->load->admin_template('view_Complaints_and_suggestions', $Data);
	}
	/////////////////////
	public function add_type()
	{
		$data['request_name']		= $this->input->post('request_name');
		$data['request_nameEN']     = $this->input->post('request_nameEN');
		$data['isEmp']              = $this->input->post('isEmp');
		$data['type_id']            = $this->uri->segment(4);
		if ($data['type_id']) {
			$actoin = $this->config_model->update_type($data);
		} else {
			$actoin = $this->config_model->add_type($data);
		}
		if ($actoin) {
			$this->session->set_flashdata('SuccessAdd', lang('br_add_suc'));
			redirect('admin/config_system/get_complaints');
		} else {
			$this->session->set_flashdata('ErrorAdd', lang('br_add_error'));
			redirect('admin/config_system/get_complaints');
		}
	}
	/////////////////////
	public function delete_type()
	{
		$data['type_id']         = $this->uri->segment(4);

		if ($this->config_model->delete_type($data)) {
			$this->session->set_flashdata('Sucsess', lang('br_add_suc'));

			redirect('admin/config_system/get_complaints', 'refresh');
		} else {
			echo 'error';
		}
	}
	/////////////////////
	public function add_category()
	{
		$data['category_name']		= $this->input->post('category_name');
		$data['category_nameEN']    = $this->input->post('category_nameEN');
		$data['isEmp']              = $this->input->post('category_isEmp');
		$data['category_id']         = $this->uri->segment(4);
		if ($data['category_id']) {
			$actoin = $this->config_model->update_category($data);
		} else {
			$actoin = $this->config_model->add_category($data);
		}
		if ($actoin) {
			$this->session->set_flashdata('SuccessAdd', lang('br_add_suc'));
			redirect('admin/config_system/get_complaints');
		} else {
			$this->session->set_flashdata('ErrorAdd', lang('br_add_error'));
			redirect('admin/config_system/get_complaints');
		}
	}
	/////////////////////
	public function delete_category()
	{
		$data['category_id']         = $this->uri->segment(4);

		if ($this->config_model->delete_category($data)) {
			$this->session->set_flashdata('Sucsess', lang('br_add_suc'));

			redirect('admin/config_system/get_complaints', 'refresh');
		} else {
			echo 'error';
		}
	}
	/////////////////////
	public function add_status()
	{
		$data['status_name']		= $this->input->post('status_name');
		$data['status_nameEN']     = $this->input->post('status_nameEN');
		$data['status_ID']         = $this->uri->segment(4);
		if ($data['status_ID']) {
			$actoin = $this->config_model->update_status($data);
		} else {
			$actoin = $this->config_model->add_status($data);
		}
		if ($actoin) {
			$this->session->set_flashdata('SuccessAdd', lang('br_add_suc'));
			redirect('admin/config_system/get_complaints');
		} else {
			$this->session->set_flashdata('ErrorAdd', lang('br_add_error'));
			redirect('admin/config_system/get_complaints');
		}
	}
	/////////////////////
	public function delete_status()
	{
		$data['status_ID']         = $this->uri->segment(4);

		if ($this->config_model->delete_status($data)) {
			$this->session->set_flashdata('Sucsess', lang('br_add_suc'));

			redirect('admin/config_system/get_complaints', 'refresh');
		} else {
			echo 'error';
		}
	}
	/////////////////////
	public function call_trac_config()
	{
		$Data['get_call_trac']  = $this->config_model->get_call_trac();

		$this->load->admin_template('view_call_trac', $Data);
	}
	////////////////////
	public  function  active_input_Trac()

	{

		$ID = $this->input->post('ID');

		$query = $this->db->query("SELECT * FROM setting  ")->row_array();

		if ($query['Trac_school'] == 1) {
			$this->db->query("UPDATE `setting` SET `Trac_school` = 0 ");
		} else {

			$this->db->query("UPDATE `setting` SET `Trac_school` = 1   ");
		}
	}
	////////////////////
	public  function  active_input_Call()

	{

		$ID = $this->input->post('ID');

		$query = $this->db->query("SELECT * FROM setting  ")->row_array();

		if ($query['Call_school'] == 1) {
			$this->db->query("UPDATE `setting` SET `Call_school` = 0 ");
		} else {

			$this->db->query("UPDATE `setting` SET `Call_school` = 1   ");
		}
	}
	////////////////////
	public  function  active_input_registration()

	{

		$ID = $this->input->post('ID');

		$query = $this->db->query("SELECT * FROM setting  ")->row_array();

		if ($query['Registration'] == 1) {
			$this->db->query("UPDATE `setting` SET `Registration` = 0 ");
			$this->db->query("UPDATE `permission_page` SET `active_system` = 0 where CatNum=7 ");
		} else {

			$this->db->query("UPDATE `setting` SET `Registration` = 1   ");
			$this->db->query("UPDATE `permission_page` SET `active_system` = 1 where CatNum=7 ");
		}
	}
	////////////////////
	public  function  active_input_Employment()

	{

		$ID = $this->input->post('ID');

		$query = $this->db->query("SELECT * FROM setting  ")->row_array();

		if ($query['Employment'] == 1) {
			$this->db->query("UPDATE `setting` SET `Employment` = 0 ");
			$this->db->query("UPDATE `permission_page` SET `active_system` = 0 where CatNum=4 ");
		} else {

			$this->db->query("UPDATE `setting` SET `Employment` = 1   ");
			$this->db->query("UPDATE `permission_page` SET `active_system` = 1 where CatNum=4 ");
		}
	}
	////////////////////
	public  function  active_input_Medical()

	{

		$ID = $this->input->post('ID');

		$query = $this->db->query("SELECT * FROM setting  ")->row_array();

		if ($query['Medical'] == 1) {
			$this->db->query("UPDATE `setting` SET `Medical` = 0 ");
			$this->db->query("UPDATE `permission_page` SET `active_system` = 0 where CatNum=13 ");
		} else {

			$this->db->query("UPDATE `setting` SET `Medical` = 1   ");
			$this->db->query("UPDATE `permission_page` SET `active_system` = 1 where CatNum=13 ");
		}
	}
	////////////////////
	public  function  active_input_SMS()

	{

		$ID = $this->input->post('ID');

		$query = $this->db->query("SELECT * FROM setting  ")->row_array();

		if ($query['SMS'] == 1) {
			$this->db->query("UPDATE `setting` SET `SMS` = 0 ");
			$this->db->query("UPDATE `permission_page` SET `active_system` = 0 where CatNum=14 ");
		} else {

			$this->db->query("UPDATE `setting` SET `SMS` = 1   ");
			$this->db->query("UPDATE `permission_page` SET `active_system` = 1 where CatNum=14 ");
		}
	}
	////////////////////
	public  function  active_input_installment()

	{

		$ID = $this->input->post('ID');
		$query = $this->db->query("SELECT * FROM setting  ")->row_array();

		if ($query['installment'] == 1) {
			$this->db->query("UPDATE `setting` SET `installment` = 0 ");
		} else {

			$this->db->query("UPDATE `setting` SET `installment` = 1   ");
		}

		// $this->db->query("UPDATE `setting` SET `installment` = $ID   ");
	}
	////////////////////////////
	public  function  active_input_SmsRegistration()

	{

		$ID = $this->input->post('ID');

		$query = $this->db->query("SELECT * FROM setting  ")->row_array();

		if ($query['SmsRegistration'] == 1) {
			$this->db->query("UPDATE `setting` SET `SmsRegistration` = 0 ");
		} else {

			$this->db->query("UPDATE `setting` SET `SmsRegistration` = 1   ");
		}
	}
	////////////////////////////
	public  function  active_input_Communications()

	{

		$ID = $this->input->post('ID');

		$query = $this->db->query("SELECT * FROM setting  ")->row_array();

		if ($query['Communications'] == 1) {
			$this->db->query("UPDATE `setting` SET `Communications` = 0 ");
			$this->db->query("UPDATE `permission_page` SET `active_system` = 0 where CatNum=16 ");
		} else {

			$this->db->query("UPDATE `setting` SET `Communications` = 1   ");
			$this->db->query("UPDATE `permission_page` SET `active_system` = 1 where CatNum=16 ");
		}
	}
	////////////////////////////
	public  function  active_input_platform()

	{

		$ID = $this->input->post('ID');

		$query = $this->db->query("SELECT * FROM setting  ")->row_array();

		if ($query['platform'] == 1) {
			$this->db->query("UPDATE `setting` SET `platform` = 0 ");
			$this->db->query("UPDATE `permission_page` SET `active_system` = 0 where CatNum in(1,5,6,10,11,12,17) ");
		} else {

			$this->db->query("UPDATE `setting` SET `platform` = 1   ");
			$this->db->query("UPDATE `permission_page` SET `active_system` = 1 where CatNum in(1,5,6,10,11,12,17) ");
		}
	}
	////////////////////////////
	public  function  active_input_messages()

	{

		$ID = $this->input->post('ID');

		$query = $this->db->query("SELECT * FROM setting  ")->row_array();

		if ($query['messages'] == 1) {
			$this->db->query("UPDATE `setting` SET `messages` = 0 ");
			$this->db->query("UPDATE `permission_page` SET `active_system` = 0 where CatNum=2 ");
		} else {

			$this->db->query("UPDATE `setting` SET `messages` = 1   ");
			$this->db->query("UPDATE `permission_page` SET `active_system` = 1 where CatNum=2 ");
		}
	}
	
	////////////////////
	public  function  add_config_accounts_erp()
	{

		$confige = $this->input->post('confige');

		
		// if ($query['IN_ERP'] == 1 || $query['IN_ERP'] == 2) {
		//    $msg = lang('config_accounts_alert');

		// echo "<script> 

		//       window.alert('$msg');
		//      window.location.replace('".site_url()."/admin/config_system/config_accounts_erp');

		//   </script>";

		// 	$this->session->set_flashdata('ErrorAdd', lang('config_accounts_alert'));
		// } else {

			$this->db->query("UPDATE `school_details` SET `IN_ERP` = $confige   ");
			$query = $this->db->query("SELECT `IN_ERP`,IN_HR FROM `school_details` ")->row_array();

			if($confige==1){
				$this->db->query("UPDATE `permission_page` SET `IsActive` = 1 where PageUrl='admin/student_register/report_need_update_api' ");
				$this->db->query("UPDATE `permission_page` SET `IsActive` = 1 where PageUrl='admin/report_emp/get_update_report' ");
			}elseif($confige==2){

				if ($query['IN_ERP'] == 2 && $query['IN_HR'] == 2) {
					$this->db->query("UPDATE `permission_page` SET `IsActive` = 0 where PageUrl='admin/report_emp/get_update_report' ");
				}
			$this->db->query("UPDATE `permission_page` SET `IsActive` = 0 where PageUrl='admin/student_register/report_need_update_api' ");
		}
		$this->session->set_flashdata('SuccessAdd', lang('br_add_suc'));
		// }
		redirect('admin/config_system/config_accounts_erp', 'refresh');
	}
	/////////////////////////////
	public function config_hr()
	{
		$query = $this->db->query("SELECT `IN_HR` FROM `school_details` ")->row_array();

		$Data['confige'] = $query['IN_HR'];

		$this->load->admin_template('view_config_hr', $Data);
	}
	////////////////////
	public  function  add_config_hr()
	{
		$confige = $this->input->post('confige');

		

		// if ($query['IN_HR'] == 1 || $query['IN_HR'] == 2) {

		// 	$this->session->set_flashdata('ErrorAdd', lang('er_config_hr_alert'));
		// } else {

			$this->db->query("UPDATE `school_details` SET `IN_HR` = $confige   ");
			$query = $this->db->query("SELECT `IN_HR`,IN_ERP FROM `school_details` ")->row_array();
			if($confige==1){
				$this->db->query("UPDATE `permission_page` SET `IsActive` = 1 where PageUrl='admin/employee/report_need_update_api' ");
				$this->db->query("UPDATE `permission_page` SET `IsActive` = 1 where PageUrl='admin/report_emp/get_update_report' ");
			}elseif($confige==2){

				if ($query['IN_ERP'] == 2 && $query['IN_HR'] == 2) {
					$this->db->query("UPDATE `permission_page` SET `IsActive` = 0 where PageUrl='admin/report_emp/get_update_report' ");
				}
			$this->db->query("UPDATE `permission_page` SET `IsActive` = 0 where PageUrl='admin/employee/report_need_update_api' ");
		}

		$this->session->set_flashdata('SuccessAdd', lang('br_add_suc'));
		// }
		redirect('admin/config_system/config_hr', 'refresh');
	}
	/////////////////////
	public function GPA_config()
	{
		if (!$this->session->userdata('id')) {

			redirect('home/login');
		}

		$Data['date']                = $this->setting_model->converToTimezone();

		$Data['row_level']           = $this->Exam_result_model->get_row_level($this->data['Lang']);

		$Data['current_year_id']     = $this->setting_model->get_current_year();

		$Data['ApiDbname']           = $this->ApiDbname;

		$Data['year_id']             = $this->input->post('year_id');

		$Data['row_level_id']        = implode(',', $this->input->post('row_level_id'));

		$Data['GPA_Name']            = $this->input->post('GPA_Name');

		$Data['GPA_from']            = $this->input->post('GPA_from');

		$Data['GPA_to']              = $this->input->post('GPA_to');

		$Data['GPA_ID']              = $this->uri->segment(4);

		$Data['get_GPA']             = $this->config_model->get_GPA($Data);

		if ($Data['GPA_ID']) {

			$Data['GPA']  = $this->config_model->get_GPA_by_id($Data);
		}

		$this->load->admin_template('view_GPA_config', $Data);
	}
	/////////////////////
	public function add_edit_GPA_config()
	{
		$Data['date']                = $this->setting_model->converToTimezone();

		$Data['current_year_id']     = $this->setting_model->get_current_year();

		$Data['ApiDbname']           = $this->ApiDbname;

		$Data['row_level_id']        = $this->input->post('row_level_id');

		$Data['GPA_Name']            = $this->input->post('GPA_Name');

		$Data['GPA_Color']            = $this->input->post('GPA_Color');

		$Data['GPA_from']            = $this->input->post('GPA_from');

		$Data['GPA_to']              = $this->input->post('GPA_to');

		$Data['grade_point']         = (int)$this->input->post('grade_point');

		$Data['GPA_ID']              = $this->uri->segment(4);

		$Data['checkData']           = $this->config_model->check_gpa_data($Data);

		if(empty($Data['checkData'])){

		if (($Data['GPA_Name'] || $Data['GPA_Color'])  || $Data['GPA_ID']) {

			$this->config_model->add_edit_GPA_config($Data);

			$this->session->set_flashdata('Sucsess', lang('br_add_suc'));

			redirect('admin/config_system/GPA_config', 'refresh');
		} else {

			$this->session->set_flashdata('Failuer', lang('br_add_error'));

			redirect('admin/config_system/GPA_config', 'refresh');
		}
	}else{

		   $this->session->set_flashdata('Failuer', lang('unique_alert'));

			redirect('admin/config_system/GPA_config', 'refresh');
	}
	}
	///////////////////
	public function delete_GPA_config()
	{

		$Data['GPA_ID']   = $this->uri->segment(4);

		if ($Data['GPA_ID']) {

			$this->config_model->delete_GPA_config($Data);

			$this->session->set_flashdata('Sucsess', lang('br_add_suc'));

			redirect('admin/config_system/GPA_config', 'refresh');
		} else {

			$this->session->set_flashdata('Failuer', lang('br_add_error'));

			redirect('admin/config_system/GPA_config', 'refresh');
		}
	}
	/////////////////////
	public function config_exam_type()
	{
		if (!$this->session->userdata('id')) {

			redirect('home/login');
		}

		$Data['date']           = $this->setting_model->converToTimezone();

		$Data['GPA_Name']       = $this->input->post('GPA_Name');

		$Data['GPA_from']       = $this->input->post('GPA_from');

		$Data['GPA_to']         = $this->input->post('GPA_to');

		$Data['Exam_ID']         = $this->uri->segment(4);

		$Data['get_exam_type']  = $this->config_model->get_exam_type();

		if ($Data['Exam_ID']) {

			$Data['Exam_type']  = $this->config_model->get_exam_type_id($Data);
		}

		$this->load->admin_template('view_config_exam_type', $Data);
	}
	/////////////////////
	public function add_edit_exam_type()
	{
		$Data['date']          = $this->setting_model->converToTimezone();

		$Data['Exam_Name']     = $this->input->post('Exam_Name');

		$Data['Exam_Name_En']  = $this->input->post('Exam_Name_En');

		$Data['Exam_Degree']   = $this->input->post('Exam_Degree');

		$Data['Exam_ID']       = $this->uri->segment(4);


		if ($Data['Exam_Name'] || $Data['Exam_ID']) {

			$this->config_model->add_edit_exam_type($Data);

			$this->session->set_flashdata('Sucsess', lang('br_add_suc'));

			redirect('admin/config_system/config_exam_type', 'refresh');
		} else {

			$this->session->set_flashdata('Failuer', lang('br_add_error'));

			redirect('admin/config_system/config_exam_type', 'refresh');
		}
	}
	///////////////////
	public function delete_exam_type()
	{

		$Data['Exam_ID']   = $this->uri->segment(4);

		if ($Data['Exam_ID']) {

			$this->config_model->delete_exam_type($Data);

			$this->session->set_flashdata('Sucsess', lang('br_add_suc'));

			redirect('admin/config_system/config_exam_type', 'refresh');
		} else {

			$this->session->set_flashdata('Failuer', lang('br_add_error'));

			redirect('admin/config_system/config_exam_type', 'refresh');
		}
	}
	/////////////////
	public function config_certificate_form()
	{
		if (!$this->session->userdata('id')) {
			redirect('home/login');
		}

		$Data['ApiDbname']          = $this->ApiDbname;

		$Data['Lang']               = $this->session->userdata('language');

		$Data['ID']                 = $this->uri->segment(4);

		$Data['Semester']           = $this->Exam_result_model->get_semester($this->data['Lang']);

		$Data['certificate_form']   = $this->config_model->get_config_certificate_form();

		$Data['config_emp_school']  = $this->config_model->get_config_emp_school();

		$Data['emp_edit_cer']       = $this->config_model->emp_edit_cer($Data);

		if ($Data['ID']) {

			$Data['emp_cer']            = $this->config_model->emp_cer($Data);
		}
		$this->load->admin_template('view_certificate_form', $Data);
	}
	///////////////////////////

	public  function edit_certificate_form()

	{

		$ID = $this->input->post('ID');

		$query = $this->db->query("SELECT * FROM certificate_form where ID = '" . $ID . "' ")->row_array();

		if ($query['display'] == 1) {
			$this->db->query("UPDATE `certificate_form` SET `display` = 0 WHERE ID = '" . $ID . "' ");
		} else {

			$this->db->query("UPDATE `certificate_form` SET `display` = 1 WHERE ID = '" . $ID . "' ");
		}
	}
	///////////////////////////

	public  function emp_certificate()

	{
		$SchoolID             = $this->session->userdata('SchoolID');

		$Semesterid           = $this->input->post('Semesterid');

		$emp_edit_cer         = $this->input->post('emp_edit_cer');

		$show_certificate     = $this->input->post('show_certificate');

		$degree_report_father = $this->input->post('degree_report_father');

		if ($this->ApiDbname != "SchoolAccAsrAlMawaheb") {

			$cheak_school         = $this->db->query("SELECT `ID` FROM `config_emp_school` WHERE `schoolID` = $SchoolID AND `SemesterID`= $Semesterid ")->row_array();

			if ($cheak_school['ID']) {

				$this->db->query("UPDATE `config_emp_school` SET SemesterID = '" . $Semesterid . "' , `certificate_emp` = $emp_edit_cer , `certificate_father` = $show_certificate , degree_report_father = $degree_report_father where ID = " . $cheak_school['ID'] . " ");
			} else {

				$this->db->query("insert into `config_emp_school` SET schoolID = '" . $SchoolID . "' , SemesterID = '" . $Semesterid . "' , `certificate_emp` = $emp_edit_cer , `certificate_father` = $show_certificate , degree_report_father = $degree_report_father ");
			}
		} else {

			$this->db->query("UPDATE `config_emp_school` SET  `certificate_emp` = $emp_edit_cer ");
		}
		redirect('admin/config_system/config_certificate_form', 'refresh');
	}
	/////////////////////
	public function config_certificate_system()

	{
		$str = "eyJJZCI6ImNiMzc1ZTJkLTBmOTItZWIxMS04MGNiLTkzOTQzMmIwYzRmYSIsIlVzZXJOYW1lIjoic3lzdGVtQHN5c3RlbS5jb20iLCJMYXN0TG9naW4iOiIyMDIyLTEyLTEzVDE1OjM5OjA1LjE1NTM2NDQrMDM6MDAiLCJTY0lEIjoxODAsIkhySUQiOjMwNjQsIkFjY0lEIjoxMDcyLCJTYWxlc0lEIjoyLCJCdXNlc0lEIjoyOSwiRGFzaElEIjoiOWU0NDU4NjUtYTI0ZC00NTQzLWE2YzYtOTQ0M2QwNDhjZGI5IiwiU2Nob29scyI6WzIsMyw0XSwiU2VsZWN0ZWRTY2hvb2wiOjIsIlNlbGVjdGVkWWVhciI6OCwiTmFtZSI6IlN5c3RlbSIsIklzU1NPQWRtaW4iOnRydWV9";

		// echo base64_decode($str);die;

		$data['get_type'] = $this->config_model->get_type_cer();

		$this->load->admin_template('view_config_certificate_system', $data);
	}

	////////////////////
	public function edit_cer_type()

	{
		$data['cer_type']       = $this->input->post('cer_type');

		$data['model_type']     = $this->input->post('model_type');

		$data['emp_edit_cer']   = $this->input->post('emp_edit_cer');

		$data['check_add']      = $this->config_model->get_call_trac();
		// print_r($data['check_add'][0]->certificate_type);die;


		if ($data['check_add'][0]->certificate_type == 0) {

			$this->config_model->edit_cer_type($data);

			$this->session->set_flashdata('Sucsess', lang('br_add_suc'));

			redirect('admin/config_system/config_certificate_system', 'refresh');
		} else {

			$this->session->set_flashdata('Failuer', lang('prepare_once'));

			redirect('admin/config_system/config_certificate_system', 'refresh');
		}
	}

	///////////////////////config_zoom_rooms
	public function zoom_rooms()

	{

		$data['get_rooms']   = $this->config_model->get_zoom_room();

		$this->load->admin_template('view_zoom_rooms', $data);
	}
	/////////update_room_name
	public function update_room_name()
	{
		$num_room               = $this->input->post('num_room');
		for ($i = 1; $i <= $num_room; $i++) {
			$data['roomName']       = $this->input->post('roomName' . $i);
			$data['roomID']         = $this->input->post('roomID' . $i);

			$this->config_model->edit_room_name($data);
		}
		redirect('admin/config_system/zoom_rooms', 'refresh');
	}

	///////////////////
	public function send_mail()
	{
		$email = $this->input->post('email');
		$subject = $this->input->post('subject');
		$Msg = $this->input->post('message');
		if ($email) {
			$this->mobile_model->send_mail($email, $subject, $Msg, '');
		}
		$this->load->admin_template('view_send_email', $Data);
	}
	/////////////////////////////////////////
	public function prepare_class()

	{
		$this->data['get_details']  = $this->config_model->get_class_details();

		$this->load->admin_template('prepare_class', $this->data);
	}
	////////////////////////////////
	public function editClassLevel()

	{
		$this->data['levelID']           = $this->uri->segment(4);

		$this->data['getLevel']          = get_level_group_without_student();

		$this->data['getClass']          = $this->db->query("select ID,Name from class where Is_Active=1 group by ID")->result();

		$this->load->admin_template('edit_class_level', $this->data);
	}

	////////////////////////////////////////////
	public function updateClassLevel()

	{

		$data['levelID']	= $levelID = $this->input->post('levelID');

		$data['class']	= $this->input->post('class');

		if (sizeof($data['class']) > 0) {

			$this->db->query("DELETE FROM class_level WHERE levelID = " . $levelID . " ");
			foreach ($data['class'] as $Key => $val) {

				$query = $this->db->query("SELECT ID FROM class_level WHERE classID = '" . $val . "' AND levelID = '" . $levelID . "'")->num_rows();

				if ($query <= 0) {

					$this->db->query("INSERT INTO  class_level     SET classID = '" . $val . "' , levelID = '" . $levelID . "' ");
				}
			}

			$this->session->set_flashdata('SuccessAdd', lang('br_add_suc'));

			redirect('admin/Config_system/prepare_class', 'refresh');
		}
	}

	////////////////////////////////
	public function prepareSmsAbsence()

	{
		
		$SmsAbsence	                         = $this->input->post('SmsAbsence');
		$motherSms	                         = $this->input->post('motherSms');
		$motherSms                           = $motherSms?$motherSms:0;
		if($_POST['submit']){
		  $this->db->query("UPDATE `setting` SET `SmsAbsence` = '$SmsAbsence',motherSms=$motherSms ");
		}
		$this->data['get_details']           = $query = $this->db->query("SELECT SmsAbsence,motherSms FROM setting  ")->row_array();
		$this->load->admin_template('prepareSmsAbsence', $this->data);
	}
	/////////////////////
	public function system_tools()
	{
		$this->load->admin_template('view_system_tools', $Data);
	}
	///////////// 

	public function active_tool()
	{

		$toolID = $this->input->post('toolID');
		$UID    = $this->session->userdata('id');
		$date   = $this->setting_model->converToTimezone();

		$query = $this->db->query("SELECT * FROM system_tools where id = '" . $toolID . "' ")->row_array();

		if ($query['isActive'] == 1) {
			$this->db->query("UPDATE `system_tools` SET `isActive` = 0 , update_by = $UID , update_at = '$date' WHERE id = '" . $toolID . "' ");
		} else {

			$this->db->query("UPDATE `system_tools` SET `isActive` = 1 , update_by = $UID , update_at = '$date' WHERE id = '" . $toolID . "' ");
		}
	}
}////// END CLASS