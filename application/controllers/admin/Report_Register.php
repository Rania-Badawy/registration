<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . '/traits/zoom/TokenTrait.php';

class Report_Register extends MY_Admin_Base_Controller
{
    use TokenTrait; 
	private $data = array();
	private $finance_api_base = 'https://api-school-public.esol.dev/api/';
	function __construct()

	{
		parent::__construct();
		$this->load->model(array('admin/Report_Register_model', 'admin/setting_model', 'emp/zoom_model', 'admin/mobile_model', 'report/report_emp_model'));
		$this->load->library('get_data_admin');
		$this->data['UID'] = $this->session->userdata('id');
		$this->data['Semester'] = $this->session->userdata('Semester');
		$this->data['Lang']   = $this->session->userdata('language');
		$get_api_setting     = $this->setting_model->get_api_setting();
		$this->ApiDbname     = $get_api_setting[0]->{'ApiDbname'};
		$get_zoom_token      = $this->zoom_model->get_zoom_token();
		$this->zoom_token    = $this->GetToken();
		$this->token         = $this->setting_model->acess_token();
	}

	///////////////////////////////	
	public function index()
	{
		$this->data['ApiDbname']        = $this->ApiDbname;
		$this->data['SchoolID']         = $schoolId   = $this->input->post('school');
		$this->data['Get_Year']         = $this->input->post('GetYear');
		$this->data['semester']         = $this->input->post('semester');
		$this->data['level']            = $this->input->post('level');
		$this->data['RowLevel']         = $this->input->post('RowLevel');
		$this->data['date_now']         = $this->setting_model->converToTimezone();
	
		if (!$this->data['Get_Year']) {
			$this->data['SchoolID']         = $schoolId   = $this->uri->segment(4);
			$this->data['Get_Year']         = $this->uri->segment(5);
		}
		$token = $this->token;
		$authorization = "Authorization: Bearer " . $token;
		$url = lang('api_sec_link')."/odata/v1.0/" . $this->ApiDbname . "/Years/GetBySchoolId(schoolId=$schoolId)";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
		$result = curl_exec($ch);
		$result = json_decode($result, true);
		curl_close($ch);
		$this->data['getAllYear']       = $result['value'];
		$this->data['get_schools']      = json_decode(file_get_contents(lang('api_link')."/api/Schools/" . $this->ApiDbname . "/GetAllSchools"));
		$this->data['openedYear']       = json_decode(file_get_contents(lang('api_link')."/api/Years/" . $this->ApiDbname . "/GetOpenedYearsBySchoolId?schoolId=$schoolId"));
		$this->data['get_nationality']  = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllNationalities"));
		if ($this->data['Get_Year']) {
			$this->data['getStudentR']      = $this->Report_Register_model->get_student_register($this->data);
		}
		$this->data['allStudeType']      = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllStudyTypes"));
		$this->load->admin_template('Student_Register_Form', $this->data);
	}
	/////////////////////////////
	public function get_all_year()
	{

		$schoolId      = $this->uri->segment(4);
		$token = $this->token;
		$authorization = "Authorization: Bearer " . $token;
		$url = lang('api_sec_link')."/odata/v1.0/" . $this->ApiDbname . "/Years/GetBySchoolId(schoolId=$schoolId)";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
		$result = curl_exec($ch);
		$result = json_decode($result, true);
		curl_close($ch);

		$this->output->set_content_type('application/json')->set_output(json_encode($result['value']));
	}
	////////////////////////////
	public function student_register_brother($IsActive = 0)
	{

		$this->data['IsActive'] = $IsActive;
		$this->data['get_nationality']  = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllNationalities"));
		$this->data['getRowLevel']  = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllRowLevels"));

		$this->data['getStudentR']  = $this->Report_Register_model->get_student_register_brothers($IsActive);

		$this->load->admin_template('student_register_brothers', $this->data);
	}
	///////////////////////////////////////
	public function view_student_register($ID = 0)
	{
		$this->data['id']               = $this->uri->segment(4);
		$this->data['school_id']        = $this->uri->segment(5);
		$this->data['year_id']          = $this->uri->segment(6);
		$this->data['isNextYear']       = $this->uri->segment(7);
		$this->Report_Register_model->add_student_register_accept($ID);
		$this->data['getStudentR']      = $this->Report_Register_model->get_student_register_by_id($ID);
		$this->data['reason']           = $this->Report_Register_model->getStudentReasons($ID);
		$this->data['get_identities']   = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllIdentityTypes"));
		$this->data['get_educations']   = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllGraduationStudies"));
		$this->data['studeType']        = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllStudyTypes"));
		$this->data['get_genders']      = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllGenders"));
		$this->data['get_nationality']  = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllNationalities"));
		$this->data['religion']         = json_decode(file_get_contents(lang('api_link')."/api/Fathers/GetAllReligions?dbName=" . $this->ApiDbname . ""));
		$schoolid                       = $this->data['getStudentR']['schoolID'];
		$levelId                        = $this->data['getStudentR']['LevelID'];
		$rowId                          = $this->data['getStudentR']['rowID'];
		$ClassTypeId                    = $this->data['getStudentR']['ClassTypeId'];
		$studyType                      = $this->data['getStudentR']['studyType'];
		$this->data['getYear']          = json_decode(file_get_contents(lang('api_link')."/api/Years/" . $this->ApiDbname . "/GetOpenedYearsBySchoolId?schoolId=$schoolid"));
		$this->data['get_ClassTypeName']  = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllClassTypes"));
		$this->data['getStatus']          = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetFeeStatus?schoolId=$schoolid&levelId=$levelId&rowId=$rowId&studyTypeId=$studyType&genderId=$ClassTypeId"));
		$UserType                       = $this->session->userdata('type');
		if ($UserType == 'U') {
			$this->data['getPerEmp']             =  'U';
		} else {
			$this->data['getPerEmp']             = $this->Report_Register_model->check_user_accept_request($this->data['UID'], $this->data['Lang'], $ID);
			$this->data['all_accept_request']    = $this->Report_Register_model->check_all_accept_request($this->data['UID'], $this->data['Lang'], $ID);
			$this->data['all_accept_request2']   = $this->Report_Register_model->check_all_accept_request2($this->data['UID'], $this->data['Lang'], $ID);
			$this->data['get_permission_request'] = $this->Report_Register_model->get_permission_request($this->data['UID']);

		}
		$this->data['NameSpaceID']  = 0;
		if (sizeof($this->data['getPerEmp']) > 0) {
			$this->data['NameSpaceID']  = $this->data['getPerEmp']['NameSpaceID'];
		}
		$this->load->admin_template('Student_Register_Form_by_id', $this->data);
	}
	///////////////////////////////////////
	public function view_student_register_complete($ID = 0)
	{
		$this->data['id']               = $this->uri->segment(4);
		$this->data['school_id']        = $this->uri->segment(5);
		$this->data['year_id']          = $this->uri->segment(6);
		$this->Report_Register_model->add_student_register_accept($ID);
		$this->data['getStudentR']      = $this->Report_Register_model->get_student_register_by_id($ID);
		$this->data['reason']           = $this->Report_Register_model->getStudentReasons($ID);
		$this->data['get_identities']   = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllIdentityTypes"));
		$this->data['get_educations']   = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllGraduationStudies"));
		$this->data['studeType']        = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllStudyTypes"));
		$this->data['get_genders']      = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllGenders"));
		$this->data['get_nationality']  = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllNationalities"));
		$this->data['religion']         = json_decode(file_get_contents(lang('api_link')."/api/Fathers/GetAllReligions?dbName=" . $this->ApiDbname . ""));
		$schoolid                       = $this->data['getStudentR']['schoolID'];
		$this->data['study_types']      = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetStudyTypesBySchool?schoolId=$schoolid"));
		$this->data['getClasses']       = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetClassesBySchool?schoolId=$schoolid"));
		$this->data['getYear']          = json_decode(file_get_contents(lang('api_link')."/api/Years/" . $this->ApiDbname . "/GetOpenedYearsBySchoolId?schoolId=$schoolid"));
		$this->data['get_ClassTypeName']  = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllClassTypes"));
		$UserType                       = $this->session->userdata('type');
		if ($UserType == 'U') {
			$this->data['getPerEmp']             =  'U';
		} else {
			$this->data['getPerEmp']             = $this->Report_Register_model->check_user_accept_request($this->data['UID'], $this->data['Lang'], $ID);
			$this->data['all_accept_request']    = $this->Report_Register_model->check_all_accept_request($this->data['UID'], $this->data['Lang'], $ID);
			$this->data['all_accept_request2']   = $this->Report_Register_model->check_all_accept_request2($this->data['UID'], $this->data['Lang'], $ID);
			$this->data['get_permission_request'] = $this->Report_Register_model->get_permission_request($this->data['UID']);

		}
		$this->data['NameSpaceID']  = 0;
		if (sizeof($this->data['getPerEmp']) > 0) {
			$this->data['NameSpaceID']  = $this->data['getPerEmp']['NameSpaceID'];
		}
		$this->load->admin_template('Student_Register_complete_by_id', $this->data);
	}
	//////////////////////////////////
	public function get_student_register()
	{
		$this->data['reg_id']        = $this->uri->segment(4);
		$Year_lms                    = $this->data['stu_data'] = $this->Report_Register_model->get_student_register_data($this->data['reg_id']);
		$ClassTypeId                 = $Year_lms[0]->ClassTypeId;
		$schoolID                    = $Year_lms[0]->schoolID;
		$studyType                   = $Year_lms[0]->studyType;
		$gender                      = $Year_lms[0]->gender;
		$levelId                     = $Year_lms[0]->LevelID;
		$rowId                       = $Year_lms[0]->rowID;
		$this->data['get_row_level'] = $this->Report_Register_model->get_row_level();
		$this->data['get_educations']     = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllGraduationStudies"));
		$this->data['get_nationality']    = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllNationalities"));
		$this->data['getRowLevel']        = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllRowLevelsOfNewRegisteration?schoolId=$schoolID&studyTypeId=$studyType&classTypeId=$ClassTypeId"));
		$this->data['GetYear']            = json_decode(file_get_contents(lang('api_link')."/api/Years/" . $this->ApiDbname . "/GetOpenedYearsBySchoolId?schoolId=$schoolID"));
		$this->data['Get_Year']           = $Year_lms[0]->YearId;
		$this->data['get_schools']        = json_decode(file_get_contents(lang('api_link')."/api/Schools/" . $this->ApiDbname . "/GetSchoolsByStudyType?studyTypeId=$studyType"));
		$this->data['getLevel']           = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetLevelsBySchool?schoolId=$schoolID&studyTypeId=$studyType&genderId=$ClassTypeId"));
		$this->data['getRow']             = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetRowsByLevel?schoolId=$schoolID&levelId=$levelId&studyTypeId=$studyType&genderId=$ClassTypeId"));
		$this->data['getStatus']          = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetFeeStatus?schoolId=$schoolID&levelId=$levelId&rowId=$rowId&studyTypeId=$studyType&genderId=$ClassTypeId"));
		$this->data['get_ClassTypeName']  = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllClassTypes"));
		$this->data['study_types']        = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllStudyTypes"));
		$query                            = $this->db->query("SELECT reg_year FROM setting")->row_array();
		if($query['reg_year']){
			$this->data['reg_year']       = $query['reg_year'];
		  }else{
			 $this->data['reg_year']      = 0;
		  }
		$this->load->admin_template('edit_student_register', $this->data);
	}
	public function edit_student_register()
	{
		$this->data['reg_id']           = $this->uri->segment(4);
		$this->data['reg_parent_id']    = $this->uri->segment(5);
		$this->data['father_name']      = $this->input->post('father_name');
		$this->data['fa_NumberID']      = $this->input->post('fa_NumberID');
		$this->data['fa_mobile']        = $this->input->post('fa_mobile');
		$this->data['fa_Email']         = $this->input->post('fa_Email');
		$this->data['mother_name']      = $this->input->post('mother_name');
		$this->data['mother_email']     = $this->input->post('mother_email');
		$this->data['mother_mobile']    = $this->input->post('mother_mobile');
		$this->data['student_name']     = $this->input->post('student_name');
		$this->data['st_NumberID']      = $this->input->post('st_NumberID');
		$this->data['father_name_en']   = $this->input->post('father_name_en');
		$this->data['EducationalQualification']         = $this->input->post('EducationalQualification');
		$this->data['fa_mobile']           = $this->input->post('fa_mobile');
		$this->data['fa_mobile2']          = $this->input->post('fa_mobile2');
		$this->data['phone_home']          = $this->input->post('phone_home');
		$this->data['work_phone']          = $this->input->post('work_phone');
		$this->data['fa_The_job']          = $this->input->post('fa_The_job');
		$this->data['parent_work_address']          = $this->input->post('parent_work_address');
		$this->data['mother_educationa']   = $this->input->post('mother_educationa');
		$this->data['ma_The_job']          = $this->input->post('ma_The_job');
		$this->data['mother_work_phone']   = $this->input->post('mother_work_phone');
		$this->data['mother_work']         = $this->input->post('mother_work');
		$this->data['student_name_en']     = $this->input->post('student_name_en');
		$this->data['student_region']      = $this->input->post('student_region');
		$this->data['st_gender']           = $this->input->post('st_gender');
		$this->data['st_BirhtDate']        = $this->input->post('st_BirhtDate');
		$this->data['st_BirhtDatehij']     = $this->input->post('st_BirhtDatehij');
		$this->data['st_place_birth']      = $this->input->post('st_place_birth');
		$this->data['second_lang']         = $this->input->post('second_lang');
		$this->data['RowLevelId']          = $this->input->post('RowLevelId');
		$this->data['bro_name']            = $this->input->post('bro_name');
		$this->data['BR0_RowLevelId']      = $this->input->post('BR0_RowLevelId');
		$this->data['bro_school_Name']     = $this->input->post('bro_school_Name');
		$this->data['bro_school_type']     = $this->input->post('bro_school_type');
		$this->data['bro_id']              = $this->input->post('bro_id');
		$this->data['MotherNumberID']      = $this->input->post('MotherNumberID');
		$this->data['level']               = $this->input->post('level');
		$this->data['row']                 = $this->input->post('row');
		$this->data['status']              = $this->input->post('status');
		$this->data['ClassTypeId']         = $this->input->post('ClassTypeId');
		$this->data['study_type']          = $this->input->post('study_type');
		$this->data['school']              = $this->input->post('school');
		$this->data['GetYear']             = $this->input->post('GetYear');
		$this->data['birth_certificate']   =  $this->input->post('birth_certificate');
		$this->data['vaccination_certificate']   =  $this->input->post('vaccination_certificate');
		$this->data['father_national_id']        =  $this->input->post('father_national_id');
		$this->data['family_card1']   =  $this->input->post('family_card1');
		$this->data['family_card2']   =  $this->input->post('family_card2');
		$this->data['father_brith_date']   =  $this->input->post('father_brith_date');


		if ($this->Report_Register_model->edit_student_register_model($this->data)) {

			$this->session->set_flashdata('SuccessAdd', lang('br_add_suc'));
		} else {

			$this->session->set_flashdata('ErrorAdd', lang('br_add_error'));
		}
		redirect('admin/Report_Register/index/' . $this->data['school'] . "/" . $this->data['GetYear'], 'refresh');
	}
	/////////////////////////
	public function delete_student_register()
	{
		$ID       = $this->uri->segment(4);
		$query    = $this->db->query("select register_form.schoolID	,register_form.YearId	 
                                                       from register_form
                                                       where register_form.id=" . $ID . " ")->row_array();
		$schoolID  = $query['schoolID'];
		$YearId    = $query['YearId'];

		if ($this->Report_Register_model->delete_student_register($ID)) {

			$this->session->set_flashdata('SuccessAdd', lang('br_add_suc'));
		} else {

			$this->session->set_flashdata('ErrorAdd', lang('br_add_error'));
		}
		redirect('admin/Report_Register/index/' . $schoolID . "/" . $YearId, 'refresh');
	}
	///////////////////////
	public function Student_Register_marketing()
	{
		$this->data['date']             = $this->setting_model->converToTimezone();
		$this->data['SchoolID']         = $schoolId   = $this->input->post('school');
		$this->data['Get_Year']         = $this->input->post('GetYear');
		$this->data['get_schools']      = json_decode(file_get_contents(lang('api_link')."/api/Schools/" . $this->ApiDbname . "/GetAllSchools"));
		$this->data['GetYear']          = json_decode(file_get_contents(lang('api_link')."/api/Years/" . $this->ApiDbname . "/GetOpenedYearsBySchoolId?schoolId=$schoolId"));
		$this->data['allStudeType']     = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllStudyTypes"));
		$this->data['getPerEmp']        = $this->Report_Register_model->get_Per_Emp($this->data['UID']);
		if ($this->data['Get_Year']) {
			$this->data['getStudentR']  = $this->Report_Register_model->Student_Register_marketing($this->data);
		}

		
		$this->load->admin_template('Student_Register_marketing', $this->data);
	}
	////////////////////
	public function view_student_register_new()
	{
		$this->data['ID']                 = $this->uri->segment(4);
		$this->data['getStudentR']        = $this->Report_Register_model->get_student_register_by_id($this->data['ID']);
		$studyType                        = $this->data['getStudentR']['studyType'];
		$schoolID                         = $this->data['getStudentR']['schoolID'];
		$gender                           = $this->data['getStudentR']['ClassTypeId'];
		$levelId                          = $this->data['getStudentR']['LevelID'];
		$rowId                            = $this->data['getStudentR']['rowID'];
		$LevelLMS                         = $this->data['getStudentR']['LevelLMS'];
		$school_lms                       = $this->data['getStudentR']['school_lms'];
		$this->data['get_schools']        = json_decode(file_get_contents(lang('api_link')."/api/Schools/" . $this->ApiDbname . "/GetSchoolsByStudyType?studyTypeId=$studyType"));
		$this->data['getLevel']           = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetLevelsBySchool?schoolId=$schoolID&studyTypeId=$studyType&genderId=$gender"));
		$this->data['getRow']             = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetRowsByLevel?schoolId=$schoolID&levelId=$levelId&studyTypeId=$studyType&genderId=$gender"));
		$this->data['GetYear']            = json_decode(file_get_contents(lang('api_link')."/api/Years/" . $this->ApiDbname . "/GetOpenedYearsBySchoolId?schoolId=$schoolID"));
		$this->data['getRowLevel']        = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllRowLevels"));
		$this->data['get_genders']        = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllGenders"));
		$this->data['study_types']        = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllStudyTypes"));
		$this->data['get_ClassTypeName']  = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllClassTypes"));
		$this->data['get_how_school']     = $this->Report_Register_model->get_how_school();
			$query                            = $this->db->query("SELECT reg_year FROM setting")->row_array();
		if($query['reg_year']){
			$this->data['reg_year']       = $query['reg_year'];
		  }else{
			 $this->data['reg_year']      = 0;
		  }
		if ($LevelLMS) {
			$this->data['reg_employee']       = $this->Report_Register_model->reg_employee_special($LevelLMS, $school_lms);
		}
		$this->load->admin_template('Student_Register_by_id', $this->data);
	}
	////////////////////////////
	public function edit_register($id)
	{
		$data['id']                           = $this->uri->segment(4);
		$data['parent_name']                  = $this->input->post('parent_name');
		$data['parent_mobile']                = $this->input->post('parent_mobile');
		$data['parent_email']                 = $this->input->post('parent_email');
		$data['student_name']                 = $this->input->post('student_name');
		$data['ClassTypeId']                  = $this->input->post('ClassTypeId');
		$data['study_type']                   = $this->input->post('study_type');
		$data['exSchool']                     = $this->input->post('exSchool');
		$data['how_school']                   = $this->input->post('how_school');
		$data['level']                        = $this->input->post('level');
		$data['row']                          = $this->input->post('row');
		$data['Class']                        = $this->input->post('Class');
		$data['student_NumberID']             = $this->input->post('student_NumberID');
		$data['ParentNumberID']               = $this->input->post('ParentNumberID');
		$data['school']                       = $this->input->post('school');
		$data['note']                         = $this->input->post('note');
		$data['parent_region']                = $this->input->post('parent_region');
		$data['reg_parent_id']                = $this->input->post('reg_parent_id');
		$data['GetYear']                      = $this->input->post('GetYear');

		$this->Report_Register_model->edit_register($data);
		redirect('/admin/Report_Register/view_student_register_new/' . $data['id'], 'refresh');
	}
	/////////////////////////////
	public function delete_register()
	{
		$id = $this->uri->segment(4);
		$this->Report_Register_model->delete_register($id);

		redirect('/admin/Report_Register/Student_Register_marketing', 'refresh');
	}
	//////////////////////
	public function register_status()
	{
		$this->data['id']                 = $this->uri->segment(4);
		$this->data['getStudentR']        = $this->Report_Register_model->get_student_register_by_id($this->data['id']);
		$this->data['reg_employee']       = $this->Report_Register_model->reg_employee($this->data['getStudentR']['LevelID'], $this->data['getStudentR']['schoolID']);
		$this->data['status']             = $this->Report_Register_model->Get_state();
		$this->data['getStudent_status']  = $this->Report_Register_model->get_status_register($this->data['id']);
		$this->load->admin_template('Student_Register_status', $this->data);
	}
	/////////////////////////
	public function add_register_status($id)
	{
		$token                    = $this->token;
		$Sender_array             = $this->sender();
		$Sender                   = $Sender_array[0];
		$data['date']             = $this->setting_model->converToTimezone();
		$data['id']               = $this->uri->segment(4);
		$data['parent_email']     = $this->input->post('parent_email');
		$data['status']           = $this->input->post('status');
		$data['contact']          = $this->input->post('contact');
		$data['date_remember']    = $this->input->post('date_remember');
		$data['comments']         = $this->input->post('comments');
		$this->Report_Register_model->add_register_status($data);

		$registration_data        = $this->Report_Register_model->get_student_register_by_id($data['id']);
		if ($data['status'] == 30) {
			$Data['schoolLMS']        =  $registration_data['school_lms'];
			$Data['LevelLMS']         =  $registration_data['LevelLMS'];
			$data['Level_LMS']        =  $this->db->query(" SELECT `ID` as Level_ID ,Name as Level_Name FROM `level` WHERE `ID` =" . $registration_data['LevelLMS'] . "")->row_array();
			$data['school_LMS']       =  $this->db->query(" SELECT `ID`,SchoolName FROM `school_details` WHERE `ID` = " . $registration_data['school_lms'] . "")->row_array();
			$Data['NameSpaceID']      = 87;
			$data['get_per_emp']      =  $this->Report_Register_model->get_permission_reg($Data);
			$row_level = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetRowLevel?schoolId=" . $registration_data['schoolID'] . "&rowId=" . $registration_data['rowID'] . "&levelId=" . $registration_data['LevelID'] . "&studyTypeId=" . $registration_data['studyType'] . "&genderId=" . $registration_data['ClassTypeId'] . "&feeStatusId=" . $registration_data['status'] . " "));
				$rowID = $row_level->RowId;
				$levelID = $row_level->LevelId;
				$RowLevelName   = $row_level->RowLevelName;
				$newTempDatqa['schoolName']  =  $data['school_LMS']['SchoolName'];
				$newTempDatqa['studentName'] = $registration_data['name'];
				$newTempDatqa['studentID'] = $registration_data['student_NumberID'];
				$newTempDatqa['rowLevelName'] =$RowLevelName;
				foreach ($data['get_per_emp'] as $key => $val) {
					$subject1   = " طلب جديد";
					$msg1 = '';
						$newTempDatqa['Slink'] = site_url('admin/Report_Register/view_student_register_complete/' . $data['id']);
					$this->mobile_model->send_mail($val->Mail, $subject1, $msg1, '',true, $newTempDatqa);
				}
			//   $to                       = $data['parent_email'];
			//   $subject                  = lang('reg_form_complete');
			//   $Msg     =lang('reg_form_complete'). PHP_EOL
			//     . lang('reg_massage_new')." ".$registration_data['name'].lang('reg_new').PHP_EOL.site_url('home/Student_register/index/'.$data['id']);
			//   $this->mobile_model->send_msg($registration_data['parent_mobile'], $Msg,$Sender,$token);
			//   $this->mobile_model->send_mail($to,$subject,$Msg,'');
		}
		redirect('/admin/Report_Register/view_student_register_new/' . $data['id'], 'refresh');
	}
	////////////////////
	public function reg_complete()
	{

		$this->data['date']             = $this->setting_model->converToTimezone();
		$this->data['SchoolID']         = $schoolId   = $this->input->post('school');
		$this->data['Get_Year']         = $this->input->post('GetYear');
		if (!$this->data['Get_Year']) {
			$this->data['SchoolID']         = $schoolId   = $this->uri->segment(4);
			$this->data['Get_Year']         = $this->uri->segment(5);
		}
		$this->data['get_schools']      = json_decode(file_get_contents(lang('api_link')."/api/Schools/" . $this->ApiDbname . "/GetAllSchools"));
		$this->data['GetYear']          = json_decode(file_get_contents(lang('api_link')."/api/Years/" . $this->ApiDbname . "/GetOpenedYearsBySchoolId?schoolId=$schoolId"));
		$this->data['getPerEmp']        = $this->Report_Register_model->get_Per_Emp($this->data['UID']);
		$this->data['reg_per']          = $this->Report_Register_model->get_Per_level($this->data['UID']);

		if ($this->data['Get_Year']) {
			$this->data['getStudentR']  = $this->Report_Register_model->Student_Register_marketing($this->data);
		}
		$this->data['allStudeType']      = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllStudyTypes"));
		$this->load->admin_template('Student_Register_complete', $this->data);
	}
	//////////////////////////////////////
	public function add_register_attend()
	{
		$data['id']  = $id           = $this->uri->segment(4);
		$data['interview_date']      = date('Y-m-d H:i:s', strtotime($this->input->post('interview_date') . ':00'));
		$data['duration']            = $this->input->post('duration');
		$data['notes']               = $this->input->post('notes');
		$data['is_attend']           = $this->input->post('attend');
		$data['interview_place']     = $this->input->post('interview_place');
		$data['interview_gate']      = $this->input->post('interview_gate');
		$data['interview_type']      = $this->input->post('interview_type');
		$teacherid                   = (int)$this->session->userdata('id');
		$registration_data           = $this->Report_Register_model->get_student_register_by_id($id);
		$row_level = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetRowLevel?schoolId=" . $registration_data['schoolID'] . "&rowId=" . $registration_data['rowID'] . "&levelId=" . $registration_data['LevelID'] . "&studyTypeId=" . $registration_data['studyType'] . "&genderId=" . $registration_data['ClassTypeId'] . "&feeStatusId=" . $registration_data['status'] . " "));
				$rowID = $row_level->RowId;
				$levelID = $row_level->LevelId;
				$RowLevelName   = $row_level->RowLevelName;
		$this->db->select('check_code');
					$this->db->where('ID',$id);
		$check_code = $this->db->get('register_form');
		$newTempDatqa['rentCode']    = false;
		$newTempDatqa['schoolName']  = $registration_data['schoolName'];
		$newTempDatqa['studentName'] = $registration_data['name'];
		$newTempDatqa['studentID']   = $registration_data['student_NumberID'];
		$newTempDatqa['link']        = false;
		$newTempDatqa['rowLevelName']= $RowLevelName;

		$accpet_reg_type            =  $this->db->query(" SELECT `accpet_reg_type`,IN_ERP,Logo FROM `school_details` ")->row_array();
		$get_logo                   = $this->db->query("select Logo from setting ")->row_array();
		$newTempDatqa['logo']       = base_url().'/intro/images/school_logo/'.$get_logo['Logo'];
		$interview_date             = date('Y-m-d H:i:s', strtotime($data['interview_date']));
		$date                       = date("Y-m-d\TH:i:s", strtotime($interview_date));
	    $duration                   = $data['duration'];
		$room_email                 = $this->db->query("SELECT  zoom_rooms.id as room_id , zoom_rooms.email FROM `zoom_rooms`
					                                    where zoom_rooms.id not in(SELECT zoom_meetings.room_id 
															FROM zoom_meetings
															WHERE zoom_meetings.is_deleted != 1 
															AND  (('$date' BETWEEN start_time AND(DATE_ADD(zoom_meetings.start_time,INTERVAL zoom_meetings.duration MINUTE)))
															OR ('$date'<=start_time AND (DATE_ADD('$date',INTERVAL $duration MINUTE))BETWEEN start_time AND(DATE_ADD(zoom_meetings.start_time,INTERVAL zoom_meetings.duration MINUTE))) 
															OR ('$date'<=start_time AND (DATE_ADD('$date',INTERVAL $duration MINUTE)>=(DATE_ADD(zoom_meetings.start_time,INTERVAL zoom_meetings.duration MINUTE))))
															)) ")->row_array();
		$data['room']                = $room_email['email'];
		$data['room_id']             = $room_email['room_id'];
		$query                       = $this->db->query("select reg_parent.parent_email,register_form.name,reg_test_date.Date,reg_parent.parent_mobile,register_form.schoolID,
		                                                register_form.YearId,reg_test_date.interview_gate, reg_test_date.interview_place,reg_test_date.interview_type
                                                       from register_form
                                                       left join reg_test_date on register_form.id=reg_test_date.reg_id
                                                       inner join reg_parent on register_form.reg_parent_id=reg_parent.ID
                                                       where register_form.id=" . $data['id'] . " ")->row_array();

		$query_date                  = $this->db->query("select name from register_form 
                                                       inner join reg_test_date on register_form.id=reg_test_date.reg_id
                                                       where (('$interview_date' BETWEEN reg_test_date.Date AND(DATE_ADD(reg_test_date.Date,INTERVAL duration MINUTE))) 
                                                       OR '$interview_date'=reg_test_date.Date) ")->row_array();
        $checkAttend       =$this->Report_Register_model->add_register_attend($data);
		if ( $checkAttend== 1 && ($query['Date'] != $interview_date ||$data['interview_type'] !=$query['interview_type'])) {
			$Timezone                 = $this->data['date'];
			$teacherid                = (int)$this->session->userdata('id');
			$topic                    = lang('meeting_topic') . " " . $query['name'];
			$type                     = $this->input->post('type');
			if ($data['interview_type'] == 1) {
				$meeting_data = [
					"topic"           => $topic,
					"type"            => $type,
					"start_time"      => $date,
					"duration"        => $data['duration'],
					"schedule_for"    => $this->input->post('schedule_for'),
					"timezone"        => $this->input->post('timezone'),
					"password"        => '123456',
					"agenda"          => 'abc',
					"teacherid"       => $teacherid,
					"group_id"        => 1,
					"reg_id"          => $id,
				];



				$meeting_result = $this->Zoom_Create($room_email['email'], $meeting_data);
				if (!$meeting_result->id) {
					$this->session->set_flashdata('Failuer', lang('br_parent_error'));
				} else {
					$meetingId       = $meeting_result->id;
					$start_url       = $meeting_result->start_url;
					$join_url        = $meeting_result->join_url;
					$zoom_id         = $this->input->post('meeting_id');
					$uuid            = $meeting_result->uuid;
					$occurrences     = $meeting_result->{occurrences};
					$occurrence_id1  =	$occurrences[0]->{'occurrence_id'};
					$this->db->query("delete from zoom_meetings where reg_id=$id");
					$this->zoom_model->add_zoom_meetings($meeting_data, $meetingId, $room_email['email'], $room_email['room_id'], $start_url, $join_url, $occurrence_id1, $uuid, $Timezone);
				}
			}
			$to      = $query['parent_email'];
			$subject = lang('interview_date');
			if ($data['interview_type'] == 1) {
				$Msg =  lang("reg_interview") . $query['name'] . PHP_EOL . lang('am_date') . "::." . $interview_date . PHP_EOL . "Link ::" . $join_url;
			} else {
				if ($this->ApiDbname == "SchoolAccGheras") {
					$Msg =
						'السلام عليكم ورحمة الله وبركاته' . PHP_EOL
						. 'نشكركم لاختيار غراس الأخلاق' . PHP_EOL
						. 'ويسعدنا تحديد موعد مقابلة ' . PHP_EOL
						. 'لابنتكم / لابنكم ' . PHP_EOL
						. 'اسم الطالبة / الطالب : ' . $query['name'] . PHP_EOL
						. 'مكان المقابلة : ' . $query['interview_place'] . PHP_EOL
						. 'البوابة : '  . $query['interview_gate'] . PHP_EOL
						. lang('am_date') . " : " . $interview_date . PHP_EOL
						. 'دعواتنا بالتوفيق' . PHP_EOL;
				} else {
					$Msg =  lang("reg_interview") . $query['name'] . PHP_EOL . lang('am_date') . "::." . $interview_date;
				}
			}

			$token                      = $this->token;
			$Sender_array               = $this->sender();
			$Sender                     = $Sender_array[0];
			$this->mobile_model->send_mail($to, $subject, $Msg, '',true ,$newTempDatqa);
			$SmsRegistration     = $this->db->query("select SmsRegistration from setting")->row_array();
			if ($SmsRegistration['SmsRegistration'] == 1) {
				$this->mobile_model->send_msg($query['parent_mobile'], $Msg, $Sender, $token);
			}



			if ($this->uri->segment(5) == 1) {
				redirect('/admin/Report_Register/index/' . $query['schoolID'] . "/" . $query['YearId'], 'refresh');
			} else {
				redirect('/admin/Report_Register/reg_complete/' . $query['schoolID'] . "/" . $query['YearId'], 'refresh');
			}
		} elseif ($checkAttend != 1) {
			$reg_alert = lang('reg_alert');
			$schoolID  = $query['schoolID'];
			$YearId    = $query['YearId'];
			if ($this->uri->segment(5) == 1) {
				
				echo "<script> 
                    alert('$reg_alert. " . $query_date['name'] . "');   
                    window.location.replace('" . site_url() . "/admin/Report_Register/index/$schoolID/$YearId');
                    </script>";
			} else {
				echo "<script> 
                    alert('$reg_alert. " . $query_date['name'] . "');   
                    window.location.replace('" . site_url() . "/admin/Report_Register/reg_complete/$schoolID/$YearId');
                    </script>";
			}
		} else {
			if ($this->uri->segment(5) == 1) {
				redirect('/admin/Report_Register/index/' . $query['schoolID'] . "/" . $query['YearId'], 'refresh');
			} else {
				redirect('/admin/Report_Register/reg_complete/' . $query['schoolID'] . "/" . $query['YearId'], 'refresh');
			}
		}
	}
	////////////
	public function Zoom_Create($room, $data)
	{
		$token = $this->zoom_token;
		array_walk($data, function (&$item) {
			if (empty($item) && $item !== false) {
				$item = '';
			}
		});
		$curl    = curl_init();
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
	//////////////////////////
	public function register_type()
	{
		$Data['record_id'] = $this->uri->segment(4);
		if ($Data['record_id']) {
			$Data['edit_Data'] = $this->Report_Register_model->edit_state($Data['record_id']);
		}
		$Data['typeData'] = $this->Report_Register_model->Get_state();
		$this->load->admin_template('viewReg_status_type', $Data);
	}
	///////////////////
	public function delete_state()
	{
		$record_id = $this->uri->segment(4);
		$this->Report_Register_model->delete_state($record_id);
		redirect('/admin/Report_Register/register_type', 'refresh');
	}
	/////////////////////
	public function save_state()
	{
		$data['record_id'] = $this->uri->segment(4);
		$data['Name']  = $this->input->Post('Name');
		$data['Name_en'] = $this->input->post('Name_en');
		if ($data['record_id']) {
			$this->Report_Register_model->update_state($data);
		} else {
			$this->Report_Register_model->save_state($data);
		}
		redirect('/admin/Report_Register/register_type', 'refresh');
	}
	////////////////////
	public function edit_state($record_id)
	{
		$data['record_id'] = $this->uri->segment(4);
		$data['record']    = $this->Report_Register_model->edit_state($record_id);


		redirect('/admin/Report_Register/register_type', $data);
	}
	/////////////////////////
	public function Get_service_res()
	{
		$Data['record'] = $this->Report_Register_model->Get_service_res();
		$this->load->admin_template('view_reg_emp', $Data);
	}
	///////////////////////////////////
	public function report_register()
	{
		$this->data['ApiDbname']        = $this->ApiDbname;
		$this->data['reg_type']         = $this->uri->segment(4);
		$this->data['Get_Year']         = $this->input->post('GetYear');
		$this->data['semester']         = $this->input->post('semester');
		$this->data['reg']              = $this->input->post('reg');
		$this->data['SchoolID']         = $schoolId        = $this->input->post('school');
		$this->data['get_schools']      = json_decode(file_get_contents(lang('api_link')."/api/Schools/" . $this->ApiDbname . "/GetAllSchools"));
		$token = $this->token;
		$authorization = "Authorization: Bearer " . $token;
		$url = lang('api_sec_link')."/odata/v1.0/" . $this->ApiDbname . "/Years/GetBySchoolId(schoolId=$schoolId)";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
		$result = curl_exec($ch);
		$result = json_decode($result, true);
		curl_close($ch);
		$this->data['getAllYear']          = $result['value'];
		if ($this->data['Get_Year']) {
			$this->data['getStudentR']      = $this->Report_Register_model->get_student_register_report($this->data);
		}
		$this->data['get_nationality']      = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllNationalities"));
		$this->data['allStudeType']         = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllStudyTypes"));
		$this->load->admin_template('Report_Student_Register_Form', $this->data);
	}
	/////////////////////////
	public function count_student_register()
	{
		$query = $this->db->query("SELECT * FROM form_setting WHERE input_id = 'semester'");
		$cuarantSemester = $query->row();

		$this->data['ApiDbname']        = $this->ApiDbname;
		$this->data['reg_type']         = $this->uri->segment(4);
		$this->data['Get_Year']         = $this->input->post('GetYear');
		$this->data['semester']         = $this->input->post('semester') ?? $cuarantSemester->semester;
		$this->data['reg']              = $this->input->post('reg');
		$this->data['SchoolID']         = $schoolId        = $this->input->post('school');
		$this->data['allStudeType']     = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllStudyTypes"));
		$this->data['get_schools']      = json_decode(file_get_contents(lang('api_link')."/api/Schools/" . $this->ApiDbname . "/GetAllSchools"));
		$token = $this->token;
		$authorization = "Authorization: Bearer " . $token;
		$url = lang('api_sec_link')."/odata/v1.0/" . $this->ApiDbname . "/Years/GetBySchoolId(schoolId=$schoolId)";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
		$result = curl_exec($ch);
		$result = json_decode($result, true);
		curl_close($ch);
		$this->data['getAllYear']          = $result['value'];
		if ($this->data['Get_Year']) {
			$this->data['getdate']        = $this->Report_Register_model->count_student_register_model($this->data);
		} else {
		}
		$this->load->admin_template('count_register_form', $this->data);
	}
	////////////////////////
	public function dashboard()
	{
		$this->data['type']      = 1;
		$data['date']            = $this->setting_model->converToTimezone();
		$this->data['total']     = $this->Report_Register_model->get_reg_total($this->data['type']);
		$this->data['school']    = json_decode(file_get_contents(lang('api_link')."/api/Schools/" . $this->ApiDbname . "/GetAllSchools"));
		$this->data['total_new'] = $this->Report_Register_model->Get_total_new($this->data['UID'], $this->data['type']);
		$this->load->admin_template('view_dashboard', $this->data);
	}
	////////////////////////
	public function dashboard_register()
	{
		$this->data['type']      = 2;
		$data['date']            = $this->setting_model->converToTimezone();
		$data['date_ago']        = date('Y-m-d', strtotime('-5 days', strtotime($data['date'])));
		$this->data['reg_type']  = $this->Report_Register_model->get_reg_type($this->data['Lang']);
		$this->data['total']     = $this->Report_Register_model->get_reg_total($this->data['type']);
		$this->data['school']    = json_decode(file_get_contents(lang('api_link')."/api/Schools/" . $this->ApiDbname . "/GetAllSchools"));
		$this->data['Level']     = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllLevels"));
		$this->data['total_new'] = $this->Report_Register_model->Get_total_new($this->data['UID'], $this->data['type']);
		$this->data['total_late']= $this->Report_Register_model->get_reg_total_late($data);
		$this->load->admin_template('view_dashboard_register', $this->data);
	}
	/////////////////////////////////////////
	public function accept_student_register($ID = 0, $NameSpace = 0)
	{
		$token                      = $this->token;
		$Sender_array               = $this->sender();
		$Sender                     = $Sender_array[0];
		$this->Report_Register_model->check_accept_request($ID, $NameSpace, $this->data['UID']);
		$x                            = 0;
		$registration_data            = $this->Report_Register_model->get_student_register_by_id($ID);
		$rowID                        = $registration_data['rowID'];
		$levelID                      = $registration_data['LevelID'];
		$RowLevelName                 = $registration_data['rowLevelName'];
		$newTempDatqa['schoolName']   = $registration_data['schoolName'];
		$newTempDatqa['studentName']  = $registration_data['name'];
		$newTempDatqa['studentID']    = $registration_data['student_NumberID'];
		$newTempDatqa['link']         = false;
		$newTempDatqa['rowLevelName'] = $RowLevelName;
		$accpet_reg_type              =  $this->db->query(" SELECT `accpet_reg_type`,IN_ERP,Logo FROM `school_details` ")->row_array();
		$get_logo                     = $this->db->query("select Logo from setting ")->row_array();
		$newTempDatqa['logo']         = base_url().'/intro/images/school_logo/'.$get_logo['Logo'];
		$query1                       = $this->db->query("SELECT jobTitleID FROM employee	WHERE Contact_ID = '".$this->session->userdata('id')."' ")->row_array();
		$get_permission_request       = $this->Report_Register_model->get_permission_request($this->data['UID']);
		if (($accpet_reg_type['accpet_reg_type'] == 3) ||($this->session->userdata('type') == "U")||($this->session->userdata('type')=='E' && $query1['jobTitleID']!=0 && ($get_permission_request['NameSpaceID'] !=87 && $get_permission_request['NameSpaceID'] !=85 ))) {
			$x = 1;
		}

		if ($this->input->post('IsActive') == 1) {
            if ($NameSpace == 87 && $accpet_reg_type['accpet_reg_type'] == 2 && $this->ApiDbname !='SchoolAccGheras'){
				$Data['school']       =  $registration_data['schoolID'];
		        $Data['Level']        =  $registration_data['LevelID'];
		        $Data['NameSpaceID']     =  85;
				$data['get_per_emp']     =  $this->Report_Register_model->get_permission_reg($Data);
				$message = "";
				foreach ($data['get_per_emp'] as $key => $val) {
					$to                          = $val->Mail;
					$subject                     = lang('Student_registered');
					$this->mobile_model->send_mail($to, $subject, $message, '',true,$newTempDatqa);
				}

			} 

			$Data['FullName'] = $registration_data['name'];
			$Data['SName']    = $registration_data['name'];
			$Data['FName']    = $registration_data['parent_name'];

			if ($NameSpace == 85 || $x == 1) {

				$this->db->query("UPDATE active_request SET 
        				 IsActive = " . $this->input->post('IsActive') . " , 
        				 EmpID    = '" . $this->data['UID'] . "',
        				 Reason = '" . $this->input->post("Reason") . "'
        				 WHERE RequestID = '" . $ID . "' AND NameSpaceID = 85  AND Type = 2 ");
				if ($this->input->post('IsActive') == 1) {
					$this->db->query("update  register_form SET  IsAccepted = 1,IsRefused = 0 where id = '" . $ID . "' ");
					$this->db->select('check_code');
					$this->db->where('ID',$ID);
					$check_code = $this->db->get('register_form');
					$newTempDatqa['rentCode'] = false;
					
					if ($accpet_reg_type['IN_ERP'] == 2) {
        				$this->Report_Register_model->create_student_user($registration_data);
        			}
				} else {

					$this->db->query("update  register_form SET  IsRefused = 1,IsAccepted = 0 where id = '" . $ID . "' ");
				}
			
			

				$Data['rowLevelID']          = $registration_data['RowLevelID'];
				$Data['SchoolID']            = $registration_data['schoolID'];
				$Data['StudyTypeID']         = $registration_data['studyType'];
				$Data['rowID_acc']           = $row_levelDetails->RowId;
				$Data['levelID_acc']         = $row_levelDetails->LevelId;
				$Data['birthdate']           = $registration_data['birthdate'];
				$Data['Sgender']             = $registration_data['gender'];
				$Data['national_ID']         = $registration_data['parent_national_ID'];
				$Data['Fgender']             = 1;
				$Data['FNumberID']           = $registration_data['ParentNumberID'];
				$Data['Mobile']              = $registration_data['parent_mobile'];
				$Data['parent_address']      = $registration_data['parent_address'];
				$Data['nationality']         = $registration_data['parent_national_ID'];
				$Data['student_NumberID']    = $registration_data['student_NumberID'];
				$variableArray = array();
				$index = 1;
				$father_certificate = $registration_data['father_certificate'];
				$father_national_id = $registration_data['father_national_id'];
				$father_national_id2 = $registration_data['father_national_id2'];
				$father_brith_certificate = $registration_data['father_brith_certificate'];
				$mother_certificate = $registration_data['mother_certificate'];
				$mother_national_id = $registration_data['mother_national_id'];
				$mother_national_id2 = $registration_data['mother_national_id2'];
				$mother_brith_certificate = $registration_data['mother_brith_certificate'];
				$kg_picture = $registration_data['kg_picture'];
				$birth_certificate = $registration_data['birth_certificate'];
				$parent_degre_img = $registration_data['parent_degre_img'];
				$Financial_clearance = $registration_data['Financial_clearance'];
				$vaccination_certificate = $registration_data['vaccination_certificate'];
				$family_card1 = $registration_data['family_card1'];
				$family_card2 = $registration_data['family_card2'];

				
				$variables = array(
					$father_certificate,
					$father_national_id,
					$father_national_id2,
					$father_brith_certificate,
					$mother_certificate,
					$mother_national_id,
					$mother_national_id2,
					$mother_brith_certificate,
					$kg_picture,
					$parent_degre_img,
					$Financial_clearance,
					$birth_certificate,
					$vaccination_certificate,
					$family_card1,
					$family_card2,



				);
				
				foreach ($variables as $variable) {
				 
					if ($variable !== null && $variable !== '') {
						$variableArray[] = base_url('upload/' . $variable);
						$index++; // Increment the index
					}
				}
               $variableString = array_map('trim', $variableArray);
				// Post father data to API
				$father_data = [
					"Name"            => $registration_data['parent_name'],
					"HomePhone"       => $registration_data['parent_phone'],
					"WorkPhone"       => $registration_data['parent_phone2'],
					"Mobile1"         => $registration_data['parent_mobile'],
					"Mobile2"         => $registration_data['parent_mobile2'],
					"StreetName"      => $registration_data['parent_access_station'],
					"HouseNumber"     => $registration_data['parent_house_number'],
					"Nationality_ID"  => intval($registration_data['parent_national_ID']),
					"Region"          => $registration_data['parent_region'],
					"WorkPlace"       => $registration_data['parent_work_address'],
					"Job"             => $registration_data['parent_profession'],
					"Mail"            => $registration_data['parent_email'],
					"GraduationStudy" => $registration_data['ar_education'],
					"IDType"          => $registration_data['ar_identity'],
					"IDNumber"        => $registration_data['ParentNumberID'],
					"IDSource"        => $registration_data['ID_place'],
					"ResponsibleName"  => $registration_data['person_name'],
					"ResponsibleIDNumber" => $registration_data['person_NumberID'],
					"ResponsiblePhoneNumber" => $registration_data['person_mobile'],
					"ResponsibleRelativeRelation" => $registration_data['person_relative'],
					"kgPicture"       => base_url('upload/' . $registration_data['kg_picture']),
					"IsSchoolBelong"  => true,
					"EmpId"           =>0,
					"EnName"          => $registration_data['parent_name_eng'],
					"Religionid"      => 1,
				];
				
				if ($accpet_reg_type['IN_ERP'] != 2) {
					$father_result = $this->post_father_data($father_data);

					if (!$father_result->FatherID) {
					
						if(!$father_result->Message){
					        $fatherMessage=$father_result;
					    }else{
					         $fatherMessage=$father_result->Message;
					    }
						$this->session->set_flashdata('Failuer', $fatherMessage);
						redirect('admin/Report_Register/view_student_register/' . $ID, 'refresh');
					}
				}
				$student_data = [
					"FirstName"          => $registration_data['name'],
					"GenderId"           => intval($registration_data['gender']),
					"ClassTypeId"        => intval($registration_data['ClassTypeId']),
					"DateOfBirth"        => $registration_data['birthdate'],
					"Region"             => $registration_data['student_region'],
					"Notes"              => $registration_data['note'],
					"RegistrationDate"   => $registration_data['Reg_Date'],
					"IDNumber"           => $registration_data['student_NumberID'],
					"LastSchool"         => $registration_data['exSchool'],
					"PlaceOfBirth"       => $registration_data['birthplace'],
					"Father_ID"          => $father_result->FatherID,
					"StudyType"          => intval($registration_data['studyType']),
					"EnName"             => $registration_data['name_eng'],
					"MotherName"         => $registration_data['mother_name'],
					"MotherJob"          => $registration_data['mother_work'],
					"Year_ID"            => intval($registration_data['YearId']),
					"Class_ID"           => $registration_data['classID'],
					"RowID"              => $registration_data['rowID'],
					"LevelID"            => $registration_data['LevelID'],
					"School_ID"          => intval($registration_data['schoolID']),
					"MotherMobile"       => $registration_data['mother_mobile'],
					"MotherName"         => $registration_data['mothername'],
					"MotherWork"         => $registration_data['motherwork'],
					"MotherWorkPhone"    => $registration_data['motherworkphone'],
					"MotherEmail"        => $registration_data['motheremail'],
					"MotherIDNumber"     => $registration_data['motherNumberID'],
					"MotherEducationalQualification" => $registration_data['mothereducationalqualification'],
					"FeeStatusID"        => $registration_data['status'],
					"Attachments"        => $variableString,
					"semester"           => $registration_data['semester'],
				];
				if ($accpet_reg_type['IN_ERP'] != 2) {
					$student_result = $this->post_student_data($student_data);
                    // print_r($student_data);die;
					if (!$student_result->StudentBasicDataID) {
						if(!$student_result->Message){
					        $studentMessage=$student_result;
					    }else{
					         $studentMessage=$student_result->Message;
					    }
						$this->session->set_flashdata('Failuer', $studentMessage);
						redirect('admin/Report_Register/view_student_register/' . $ID, 'refresh');
					}
					$Data['FatherID']                     = $father_result->FatherID;
					$Data['StudentBasicDataID']           =  $student_result->StudentBasicDataID;
					$Data['Message']                      =  $student_result->Message;
				}
				$message = lang('accept_affair');
				if ($this->ApiDbname == "SchoolAccGheras") {
					$message = lang('am_date') . ":" . $registration_data['Reg_Date'] . PHP_EOL . lang('am_Check_Code_student') . ":" . PHP_EOL . $registration_data['check_code'] .
						PHP_EOL . lang('GH_accept1') . " " . $registration_data['name'] . " " . lang('GH_accept2') . " " . lang('am_row') . ":" . $registration_data['rowLevelName'] . PHP_EOL . lang('GH_accept');
				}
				$this->Report_Register_model->accept_student_register($ID);
				$to      = $registration_data['parent_email'];
				$subject = lang('br_request_accepted_mail') . ' ' . $registration_data['name'];
				$this->mobile_model->send_mail($to, $subject, $message, '',true,$newTempDatqa);
				$SmsRegistration     = $this->db->query("select SmsRegistration from setting")->row_array();
				if ($SmsRegistration['SmsRegistration'] == 1) {
					$this->mobile_model->send_msg($registration_data['parent_mobile'], $message, $Sender, $token);
				}
			}
		} elseif ($this->input->post('IsActive') == 2) {
			$message = lang('br_request_refused_email') . "\n" . $this->input->post('Reason');
			$to      = $registration_data['parent_email'];
			$subject = lang('br_request_refused_subject');
			$this->mobile_model->send_mail($to, $subject, $message, '',true,$newTempDatqa);
			$SmsRegistration     = $this->db->query("select SmsRegistration from setting")->row_array();
			if ($SmsRegistration['SmsRegistration'] == 1) {
				$this->mobile_model->send_msg($registration_data['parent_mobile'], $message, $Sender, $token);
			}
		}

		$this->session->set_flashdata('SuccessAdd', lang('br_add_suc'));
		redirect('admin/Report_Register/index/' . $registration_data['schoolID'] . "/" . $registration_data['YearId'], 'refresh');
	}
	/////////////////////////////////
	public function accept_student_register_marketing($ID = 0, $NameSpace = 0)
	{
		$token                      = $this->token;
		$Sender_array               = $this->sender();
		$Sender                     = $Sender_array[0];
		$this->data['CheckAccept']  = $this->Report_Register_model->check_accept_request($ID, $NameSpace, $this->data['UID']);
		$registration_data          = $this->Report_Register_model->get_student_register_by_id($ID);
		$Data['school']             =  $registration_data['schoolID'];
		$Data['Level']              =  $registration_data['LevelID'];
		$Data['NameSpaceID']        = 85;
		$data['get_per_emp']        =  $this->Report_Register_model->get_permission_reg($Data);
		$rowID                      = $registration_data['rowID'];
		$levelID                    = $registration_data['LevelID'];
		$RowLevelName               = $registration_data['rowLevelName'];
		$newTempDatqa['schoolName'] = $registration_data['schoolName'];
		$newTempDatqa['studentName']= $registration_data['name'];
		$newTempDatqa['studentID']  = $registration_data['student_NumberID'];
		$newTempDatqa['rowLevelName'] =$RowLevelName;
		if ($this->data['CheckAccept'] == 2 && $NameSpace == 87) {
			foreach ($data['get_per_emp'] as $key => $val) {

				$to = $val->Mail;
				$subject = "مراجعة طلب استثناء ";
				$msg     = '';
				$newTempDatqa['Slink'] =  site_url('admin/Report_Register/view_student_register_complete/' . $ID);
					
				$message = $msg;
				$this->mobile_model->send_mail($to, $subject, $message, '',true , $newTempDatqa);
			}
		}
		if ($this->data['CheckAccept'] == 1) {
			$x = 0;

			$query = $this->db->query("SELECT * FROM active_request WHERE RequestID = '" . $ID . "'  AND Type = 2 and NameSpaceID=87 ")->row_array();

			if ($NameSpace == 87 && $query['IsActive'] == 1) {
				$reg_per_level = $this->db->query("SELECT * FROM reg_per_level  WHERE reg_level=" . $registration_data['LevelID'] . " and school_id=" . $registration_data['schoolID'] . " ")->result();

				if (!empty($reg_per_level)) {
					$contact_id = $this->db->query("SELECT ID FROM `contact` WHERE contact.reg_id  =" . $ID . " ")->row_array();

					if ($contact_id['ID']) {
						$student_exam   = $this->Report_Register_model->student_exam($contact_id['ID']);
						$exam_total     = $this->Report_Register_model->getTotalTestDegree($registration_data['R_L_ID_LMS'], $contact_id['ID']);
					}

					if ($student_exam != "" && (($student_exam / $exam_total) * 100) >= $reg_per_level[0]->reg_percentage) {
					
					} else {
						foreach ($data['get_per_emp'] as $key => $val) {

							$to = $val->Mail;
							$subject = "مراجعة طلب استثناء ";
							$msg     = '';
							$newTempDatqa['Slink'] =  site_url('admin/Report_Register/view_student_register_complete/' . $ID);
							$message = $msg;
							$this->mobile_model->send_mail($to, $subject, $message, '',true, $newTempDatqa);
						}
					}
				} else {
					// $x = 1;
					// $this->db->query("UPDATE active_request SET IsActive = 1 , EmpID    = '" . $UID . "',Reason   = '" . $this->input->post("Reason") . "'
        			// 	                      WHERE RequestID = '" . $ID . "' AND NameSpaceID = 85  AND Type = 2 ");
				}
			}
			$Data['FullName'] = $registration_data['name'];
			$Data['SName']    = $registration_data['name'];
			$Data['FName']    = $registration_data['parent_name'];
			$query1                     = $this->db->query("SELECT jobTitleID FROM employee	WHERE Contact_ID = '".$this->session->userdata('id')."' ")->row_array();
		    $get_permission_request     = $this->Report_Register_model->get_permission_request($this->data['UID']);
				if (($this->session->userdata('type') == "U")||($this->session->userdata('type')=='E' && $query1['jobTitleID']!=0 && ($get_permission_request['NameSpaceID'] !=87 && $get_permission_request['NameSpaceID'] !=85 ))) {
					$x = 1;
				}
			
			if ($NameSpace == 85 || $x == 1) {

				$this->db->query("UPDATE active_request SET 
        				 IsActive = " . $this->input->post('IsActive') . " , 
        				 EmpID    = '" . $this->data['UID'] . "',
        				 Reason = '" . $this->input->post("Reason") . "'
        				 WHERE RequestID = '" . $ID . "' AND NameSpaceID = 85  AND Type = 2 ");
				if ($this->input->post('IsActive') == 1) {
					$this->db->query("update  register_form SET  IsAccepted = 1,IsRefused = 0 where id = '" . $ID . "' ");
				} else {

					$this->db->query("update  register_form SET  IsRefused = 1,IsAccepted = 0 where id = '" . $ID . "' ");
				}
				$row_level = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllRowLevels"));
				foreach ($row_level as $row) {
					if (($row->RowLevelId == $registration_data['rowLevelID'])) {
						$row_levelDetails = $row;
						$RowLevelName   = $row->RowLevelName;
					}
				}
				$Class = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetClassesBySchool?schoolId=" . $registration_data['schoolID'] . ""));
				foreach ($Class as $row) {
					if (($row->ClassId == $registration_data['classID'])) {
						$classDetails = $row;
					}
				}

				$Data['rowLevelID']          = $registration_data['RowLevelID'];
				$Data['SchoolID']            = $registration_data['schoolID'];
				$Data['StudyTypeID']         = $registration_data['studyType'];
				$Data['rowID_acc']           = $row_levelDetails->RowId;
				$Data['levelID_acc']         = $row_levelDetails->LevelId;
				$Data['birthdate']           = $registration_data['birthdate'];
				$Data['Sgender']             = $registration_data['gender'];
				$Data['national_ID']         = $registration_data['parent_national_ID'];
				$Data['Fgender']             = 1;
				$Data['FNumberID']           = $registration_data['ParentNumberID'];
				$Data['Mobile']              = $registration_data['parent_mobile'];
				$Data['parent_address']      = $registration_data['parent_address'];
				$Data['nationality']         = $registration_data['parent_national_ID'];
				$Data['student_NumberID']    = $registration_data['student_NumberID'];

				// Post father data
				$father_data = [
					"Name"            => $registration_data['parent_name'],
					"HomePhone"       => $registration_data['parent_phone'],
					"WorkPhone"       => $registration_data['parent_phone2'],
					"Mobile1"         => $registration_data['parent_mobile'],
					"Mobile2"         => $registration_data['parent_mobile2'],
					"StreetName"      => $registration_data['parent_access_station'],
					"HouseNumber"     => $registration_data['parent_house_number'],
					"Nationality_ID"  => intval($registration_data['parent_national_ID']),
					"Region"          => $registration_data['parent_region'],
					"WorkPlace"       => $registration_data['parent_work_address'],
					"Job"             => $registration_data['parent_profession'],
					"Mail"            => $registration_data['parent_email'],
					"GraduationStudy" => $registration_data['ar_education'],
					"IDType"          => $registration_data['ar_identity'],
					"IDNumber"        => $registration_data['ParentNumberID'],
					"IDSource"        => $registration_data['ID_place'],
					"ResposibleName"  => $registration_data['person_name'],
					"ResposiblePhone" => $registration_data['person_phone'],
					"IsSchoolBelong"  => true,
					"EmpId"           =>0,
					"EnName"          => $registration_data['parent_name_eng'],
					"Religionid"      => 1,
				];
				if ($accpet_reg_type['IN_ERP'] != 2) {
					$father_result = $this->post_father_data($father_data);

					if (!$father_result->FatherID) {
						$this->session->set_flashdata('Failuer', lang('br_parent_error'));
						redirect('admin/Report_Register/view_student_register/' . $ID, 'refresh');
					}
				}
				$student_data = [
					"FirstName"          => $registration_data['name'],
					"GenderId"           => intval($registration_data['gender']),
					"ClassTypeId"        => intval($registration_data['ClassTypeId']),
					"DateOfBirth"        => $registration_data['birthdate'],
					"Region"             => $registration_data['student_region'],
					"Notes"              => $registration_data['note'],
					"RegistrationDate"   => $registration_data['Reg_Date'],
					"IDNumber"           => $registration_data['student_NumberID'],
					"LastSchool"         => $registration_data['exSchool'],
					"PlaceOfBirth"       => $registration_data['birthplace'],
					"Father_ID"          => $father_result->FatherID,
					"StudyType"          => intval($registration_data['studyType']),
					"EnName"             => $registration_data['name_eng'],
					"MotherName"         => $registration_data['mother_name'],
					"MotherJob"          => $registration_data['mother_work'],
					"Year_ID"            => intval($registration_data['YearId']),
					"Class_ID"           => $registration_data['classID'],
					"RowID"              => $registration_data['rowID'],
					"LevelID"            => $registration_data['LevelID'],
					"School_ID"          => intval($registration_data['schoolID']),
					"MotherMobile"       => $registration_data['mother_mobile'],
					"MotherName"         => $registration_data['mothername'],
					"MotherWork"         => $registration_data['motherwork'],
					"MotherWorkPhone"    => $registration_data['motherworkphone'],
					"MotherEmail"        => $registration_data['motheremail'],
					"MotherEducationalQualification" => $registration_data['mothereducationalqualification'],
					"semester"           => $registration_data['semester'],
				];
				if ($accpet_reg_type['IN_ERP'] != 2) {
					$student_result = $this->post_student_data($student_data);

					if (!$student_result->StudentBasicDataID) {
						$this->session->set_flashdata('Failuer', $student_result->Message);
						redirect('admin/Report_Register/view_student_register/' . $ID, 'refresh');
					}
					$Data['FatherID']                     = $father_result->FatherID;
					$Data['StudentBasicDataID']           =  $student_result->StudentBasicDataID;
					$Data['Message']                      =  $student_result->Message;
				}
				if ($this->ApiDbname == "SchoolAccGheras") {
					$message = lang('am_date') . ":" . $registration_data['Reg_Date'] . PHP_EOL . lang('am_Check_Code_student') . ":" . PHP_EOL . $registration_data['check_code'] .
						PHP_EOL . lang('GH_accept1') . " " . $registration_data['name'] . " " . lang('GH_accept2') . " " . lang('am_row') . ":" . $RowLevelName . PHP_EOL . lang('GH_accept');
				}
				$this->Report_Register_model->accept_student_register($ID);
				$to      = $registration_data['parent_email'];
				if($query['IsActive'] == 1){
					$subject = lang('studentAcceptedmail') ;
					$message = lang('final_accept');

				}else{
					$subject = lang('studentrefusdedmail');
					$message = lang('final_refused');
				}
				
				$this->mobile_model->send_mail($to, $subject, $message, '',true, $newTempDatqa);
				$SmsRegistration     = $this->db->query("select SmsRegistration from setting")->row_array();
				if ($SmsRegistration['SmsRegistration'] == 1) {
					$this->mobile_model->send_msg($registration_data['parent_mobile'], $message, $Sender, $token);
				}
			}
		}
		$this->session->set_flashdata('SuccessAdd', lang('br_add_suc'));
		redirect('admin/Report_Register/reg_complete/' . $registration_data['schoolID'] . "/" . $registration_data['YearId'], 'refresh');
	}
	///////////////////////////////////
	private function post_father_data($data)
	{
		array_walk($data, function (&$item) {
			if (empty($item) && $item !== false) {
				$item = '';
			}
		});
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => lang('api_link') . "/api/Fathers/" . $this->ApiDbname . "/AddFather",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($data),
			CURLOPT_HTTPHEADER => array(
				"Content-Type: application/json",
				"Cookie: AspxAutoDetectCookieSupport=1"
			),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		return json_decode($response);
	}

	private function post_student_data($data)
	{
		array_walk($data, function (&$item) {
			if (empty($item) && $item !== false) {
				$item = '';
			}
		});

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => lang('api_link') . "/api/Students/" . $this->ApiDbname . "/AddStudent",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($data),
			CURLOPT_HTTPHEADER => array(
				"Content-Type: application/json",
				"Cookie: AspxAutoDetectCookieSupport=1"
			),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		return json_decode($response);
	}
	/////////////////////
	public function set_reg_type()

	{

		$data['get_type'] = $this->Report_Register_model->get_type();

		$this->load->admin_template('view_reg_type', $data);
	}

	public function edit_reg_type()

	{
		$data['reg_type']            = $this->input->post('reg_type');

		$data['accpet_reg_type']     = $this->input->post('accpet_reg_type');

		$data['smsTestDirect']       = $this->input->post('smsTestDirect');

		// $data['IN_ERP']            = $this->input->post('IN_ERP');

		$this->Report_Register_model->edit_reg_type($data);

		redirect('admin/Report_Register/set_reg_type', 'refresh');
	}
	///////////////
	public function add_student_brother()
	{
		$this->data['reg_id']           = $this->uri->segment(4);

		$this->data['broName']          = $this->input->post('broName');

		$this->data['bro_rowlevel']     = $this->input->post('bro_rowlevel');

		$this->data['bro_schoolName']   = $this->input->post('bro_schoolName');

		$this->data['bro_schooltype']   = $this->input->post('bro_schooltype');

		if ($this->Report_Register_model->add_student_brother($this->data)) {

			$this->session->set_flashdata('SuccessAdd', lang('br_add_suc'));
		} else {

			$this->session->set_flashdata('ErrorAdd', lang('br_add_error'));
		}
		redirect('admin/Report_Register/get_student_register/' . $this->data['reg_id'], 'refresh');
	}
	////////////////////
	public function sender()
	{
		$token = $this->token;
		$authorization = "Authorization: Bearer " . $token;
		$url = lang('api_sec_link')."/api/" . $this->ApiDbname . "/Sms/senders";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
		$result = curl_exec($ch);
		$result = json_decode($result, true);
		curl_close($ch);
		return  $result['data'];
	}
	public function per_request()

	{
		$this->data['GetClassType']    = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllClassTypes"));
		$this->data['allStudeType']    = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllStudyTypes"));
		$this->data['Type']            = $this->uri->segment(4);
		$this->data['GetAllEmp']       = $this->Report_Register_model->get_contact();
		$this->data['GetLevel']        = $this->Report_Register_model->get_level_without_student();
		$this->data['GetAllNameSpace'] = $this->Report_Register_model->get_name_space();
		$this->data['GetSchool']       = $this->setting_model->get_branches($this->data['Lang']);
		$this->data['GetAllrequest']   = $this->Report_Register_model->get_per_request($this->data['Lang'], $this->data['Type']);

		$this->load->admin_template('view_per_request', $this->data);
	}
	///////////////////////
	public function add_per_request($Type = 0, $ID = 0)

	{
		$Type                      = $this->uri->segment(4);
		$this->data['EmpID']       = $this->input->post('EmpID');
		$this->data['Level']       = implode(',', $_POST['Level']);
		$this->data['NameSpaceID'] = $this->input->post('NameSpace');
		$this->data['SchoolID']    = implode(',', $_POST['school']);
		$this->data['class_type']  = implode(',', $_POST['class_type']);
		$this->data['studeType']   = implode(',', $_POST['studeType']);
		$this->data['IsUpdate']    = 1;
		$this->data['Type']        = $Type;
		if ($this->Report_Register_model->add_per_request($this->data)) {

			$this->session->set_flashdata('Sucsess', lang('br_add_suc'));
		} else {

			$this->session->set_flashdata('Failuer', lang('br_add_error'));
		}
		redirect('admin/Report_Register/per_request/' . $Type . '', 'refresh');
	}
	////////////////
	public function del_per_request($Type = 0, $ID = 0)

	{

		$Type                      = $this->uri->segment(4);
		$ID                        = $this->uri->segment(5);
		$EmpID                     = $this->uri->segment(6);

		if ($this->Report_Register_model->del_per_request($ID, $EmpID)) {

			$this->session->set_flashdata('Sucsess', lang('br_add_suc'));
		} else {

			$this->session->set_flashdata('Failuer', lang('br_add_error'));
		}

		redirect('admin/Report_Register/per_request/' . $Type . '', 'refresh');
	}
	/////////////////////////////
	public function reg_per_level()

	{

		$this->data['get_level']       = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllLevels"));
		$this->data['get_school']      = json_decode(file_get_contents(lang('api_link')."/api/Schools/" . $this->ApiDbname . "/GetAllSchools"));
		$this->data['get_data']        = $this->Report_Register_model->reg_per_level();

		$this->load->admin_template('view_reg_per', $this->data);
	}

	/////////////////////////////
	public function add_reg_per_level()

	{

		$this->data['school_id']         = $this->input->post('school_id');

		$this->data['reg_level']         = $this->input->post('reg_level');

		$this->data['reg_percentage']    = $this->input->post('reg_percentage');

		$this->Report_Register_model->add_reg_per_level($this->data);

		redirect('admin/Report_Register/reg_per_level', 'refresh');
	}

	//////////////////////////
	public function delete_reg_per($ID = 0)

	{
		$ID = $this->uri->segment(4);
		$this->Report_Register_model->delete_reg_per($ID);

		redirect('admin/Report_Register/reg_per_level', 'refresh');
	}
	////////////////
	public function send_sms($ID)
	{
		$token              = $this->token;
		$Sender_array       = $this->sender();
		$Sender             = $Sender_array[0];
		$ID                 = $this->uri->segment(4);
		$test_attend        = $this->input->post('test_attend');
		$registration_data  = $this->Report_Register_model->get_student_register_by_id($ID);
		$user               = $this->Report_Register_model->create_student_account_marketing($registration_data, $ID);
		$reg_per_level      = $this->db->query("SELECT * FROM reg_per_level  WHERE reg_level=" . $registration_data['LevelID'] . " and school_id=" . $registration_data['schoolID'] . " ")->result();
		if (!empty($reg_per_level)) {
			$to = $registration_data['parent_email'];

			if ($test_attend == 1) {
				$subject = lang("reg_test_remotly");
				$newTempDatqa['userName'] = $user;
				$newTempDatqa['password'] = $user;
				$newTempDatqa['examLink'] = (string) base_url("home/login");

				$msg     =  '';
			} elseif ($test_attend == 2) {
				$subject = lang("reg_test");
				$msg     = '';
				$newTempDatqa['userName'] = $user;
				$newTempDatqa['password'] = $user;	
			}
			$message = $msg;
			if ($test_attend == 1) {
				$Msg     = lang("reg_test_remotly");
					$newTempDatqa['userName'] = $user;
				$newTempDatqa['password'] = $user;
				$newTempDatqa['examLink'] = (string) base_url("home/login");
			} elseif ($test_attend == 2) {
				$Msg  = lang("reg_test");
				$newTempDatqa['userName'] = $user;
				$newTempDatqa['password'] = $user;	
			}
			$row_level = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetRowLevel?schoolId=" . $registration_data['schoolID'] . "&rowId=" . $registration_data['rowID'] . "&levelId=" . $registration_data['LevelID'] . "&studyTypeId=" . $registration_data['studyType'] . "&genderId=" . $registration_data['ClassTypeId'] . "&feeStatusId=" . $registration_data['status'] . " "));
// 			$data['school_LMS']      =  $this->db->query(" SELECT `ID`,SchoolName FROM `school_details` WHERE `ID` = " . $registration_data['school_lms'] . "")->row_array();

			$rowID = $row_level->RowId;
			$levelID = $row_level->LevelId;
			$RowLevelName   = $row_level->RowLevelName;
			$newTempDatqa['schoolName']  =  $data['schoolName'];
			$newTempDatqa['studentName'] = $registration_data['name'];
			$newTempDatqa['studentID'] = $registration_data['student_NumberID'];
			$newTempDatqa['rowLevelName'] =$RowLevelName;
			$this->mobile_model->send_mail($to, $subject, $message, '' ,true, $newTempDatqa);
			$SmsRegistration     = $this->db->query("select SmsRegistration from setting")->row_array();
			if ($SmsRegistration['SmsRegistration'] == 1) {
				$this->mobile_model->send_msg($registration_data['parent_mobile'], $Msg, $Sender, $token);
			}
		}

		redirect('admin/Report_Register/reg_complete/' . $registration_data['schoolID'] . "/" . $registration_data['YearId'], 'refresh');
	}
	//////////////////////
	public function repeat_accept_academy($ID)
	{
		$ID                 = $this->uri->segment(4);
		$registration_data  = $this->Report_Register_model->get_student_register_by_id($ID);
		$this->Report_Register_model->repeat_accept_academy($registration_data);

		redirect('admin/Report_Register/reg_complete/' . $registration_data['schoolID'] . "/" . $registration_data['YearId'], 'refresh');
	}
	//////////////////////
	public function repeat_acceptance($ID)
	{
		$ID                 = $this->uri->segment(4);
		$registration_data  = $this->Report_Register_model->get_student_register_by_id($ID);
		$this->Report_Register_model->repeat_acceptance($ID);

		redirect('admin/Report_Register/reg_complete/' . $registration_data['schoolID'] . "/" . $registration_data['YearId'], 'refresh');
	}
	/////////////////////////////
	public function add_exam()

	{
	    $this->data['studeType']        = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllStudyTypes"));
		$this->data['ClassType']        = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllClassTypes"));
		$row_level                      = $this->input->post('row_level');
		if ($row_level ) {
			redirect('emp/exam_new/create_exam/' . $row_level . "/" . "4", 'refresh');
		}
		$this->load->admin_template('view_add_exam', $this->data);
	}
	////////////////////////////
	public function config_semester_register()
	{
		$query = $this->db->query("SELECT semester FROM setting");
		$this->data['firstRow'] = $query->row();
		$this->load->admin_template('Config_semester_register', $this->data);

	}
//////////////////////////////////////
	public function updateSemestreConfig()
	{
		if (isset($_POST['reg_type']) && !empty($_POST['reg_type'])) {
			$reg_type = $_POST['reg_type'];
			
			$reg_type = $this->db->escape($reg_type);

			$sql = "UPDATE setting SET semester = $reg_type";
			$update = $this->db->query($sql);

			
		} else {
			$this->db->set(['semester' => null, ]);
			$update =  $this->db->update('setting');
		}
		if($update){
			$this->session->set_flashdata('success_msg', 'تم التحديث بنجاح.');

		}

	

		redirect('admin/Report_Register/config_semester_register', 'refresh');
	}
	////////////////////////////
	public function configYearRegister()
	{
		$get_schools                    = json_decode(file_get_contents(lang('api_link')."/api/Schools/" . $this->ApiDbname . "/GetAllSchools"));
		$schoolId                       = $get_schools[0]->SchoolId;
		$this->data['openedYear']       = json_decode(file_get_contents(lang('api_link')."/api/Years/" . $this->ApiDbname . "/GetOpenedYearsBySchoolId?schoolId=$schoolId"));
		$query                          = $this->db->query("SELECT reg_year FROM setting")->row_array();
		$this->data['reg_year']         = explode(",",$query['reg_year']);
		$this->load->admin_template('Config_year_register', $this->data);

	}
/////////////////////////////
	public function updateYearConfig()
	{
		if (isset($_POST['reg_year']) && !empty($_POST['reg_year'])) {
			$reg_year = implode(",",$_POST['reg_year']);
			
			$reg_year = $this->db->escape($reg_year);

			$sql = "UPDATE setting SET reg_year = $reg_year";
			$update = $this->db->query($sql);

			
		} else {
			$this->db->set(['reg_year' => null, ]);
			$update =  $this->db->update('setting');
		}
		if($update){
			$this->session->set_flashdata('success_msg', 'تم التحديث بنجاح.');

		}
		redirect('admin/Report_Register/configYearRegister', 'refresh');

	}
	///////////////////////////////
	public function admission_form(){
		$this->load->admin_template('admission_form');
    }
	///////////////////////////////	
	public function confirmRegistration()
	{
		$this->data['ApiDbname']        = $this->ApiDbname;
		$this->data['SchoolID']         = $schoolId   = $this->input->post('school');
		$this->data['Get_Year']         = $this->input->post('GetYear');
		$this->data['semester']         = $this->input->post('semester');
		$this->data['date_now']         = $this->setting_model->converToTimezone();
		if ($this->data['level']) {
			$this->data['row_level']        = $this->Report_Register_model->get_rowlevel($this->data['level']);
		}
		if (!$this->data['Get_Year']) {
			$this->data['SchoolID']         = $schoolId   = $this->uri->segment(4);
			$this->data['Get_Year']         = $this->uri->segment(5);
		}
		$token = $this->token;
		$authorization = "Authorization: Bearer " . $token;
		$url = lang('api_sec_link')."/odata/v1.0/" . $this->ApiDbname . "/Years/GetBySchoolId(schoolId=$schoolId)";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
		$result = curl_exec($ch);
		$result = json_decode($result, true);
		curl_close($ch);
		$this->data['getAllYear']       = $result['value'];
		$this->data['get_schools']      = json_decode(file_get_contents(lang('api_link')."/api/Schools/" . $this->ApiDbname . "/GetAllSchools"));
		$this->data['openedYear']       = json_decode(file_get_contents(lang('api_link')."/api/Years/" . $this->ApiDbname . "/GetOpenedYearsBySchoolId?schoolId=$schoolId"));
		$this->data['get_nationality']  = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllNationalities"));
		$this->data['getRowLevel']      = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllRowLevels"));
		if ($this->data['Get_Year']) {

			$this->data['getStudentR']  = $this->Report_Register_model->confirmRegistration($this->data);
		}
		$this->data['allStudeType']     = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllStudyTypes"));
		$this->load->admin_template('confirmRegistration', $this->data);
	}

	public function updateConfirmRegistration()
	{
		
		$data['date']     = $this->setting_model->converToTimezone_api();
		$token            = $this->token;
		$Sender_array     = $this->sender();
		$Sender           = $Sender_array[0];
		$check_code       = $data['check_code'];
		$regId            = $this->input->post('regId');
		foreach($regId as $id){
			$data             = $this->Report_Register_model->get_student_register_by_id($id);
			$parent_mobile    = $data['parent_mobile'];
			$schoolID         = $data['schoolID'];
			$school_lms       = $data['school_lms'];
			$schoolName       = $this->db->query("select SchoolName from school_details where ID=$school_lms")->row_array()['SchoolName'];
			$YearId           = $data['YearId'];
			$Code             = rand(100000, 999999);
			$check_code       = $data['check_code'];
			if ($parent_mobile) {

				$Msg           = lang('school_confirm')." ".$schoolName." ".lang('code_confirm')." ".$Code. " ".lang('reg_new').PHP_EOL.site_url('home/student_register/confirm_code/'.$Code."/".$check_code);

				$subject       = lang('request_code');
				
				$Send_Msg      = $this->mobile_model->send_msg($parent_mobile, $Msg, $Sender, $token);
	
			}
		}

		if($update){
			$this->session->set_flashdata('SuccessAdd', 'تم الارسال بنجاح.');
		}

		redirect('admin/Report_Register/confirmRegistration/' . $schoolID . "/" . $YearId, 'refresh');

		
	}
	///////////////////////////////
	public function registerFormPrint(){
		$this->load->admin_template('registerFormPrint');
    }

	//////////////////////////////////////
	public function send_sms_parent()

    {

	    $this->data['GetLevel']      = get_level_group();
    	$this->data['Balance']       = $this->get_msg_balance_new();
        $this->data['SenderArchive'] = $this->sender();
	    $this->load->admin_template('sendSmsParentPoll',$this->data); 

    }

	////////////////////////////////////
	public function get_msg_balance_new()
	{ 
			$token= $this->token;
		   $authorization = "Authorization: Bearer ".$token;
		   $url = lang('api_sec_link')."/api/".$this->ApiDbname."/Sms/balance";
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

     /////////////////////////////////
	 public function getSelectUser($Level)
	 {   
	  $dataResponse['parent'] =  $this->Report_Register_model->getParent($Level);
	  $this->output->set_content_type('application/json')->set_output(json_encode($dataResponse));
	 }

	//////////////////////////////
	public function sendSmsParent()
	{
		$data['token']       = $this->token;
		$data['GetEmp']      = $this->input->post('getParent');
		$data['LevelID']     = $this->input->post('SelectLevel');
		$data['Msg']         = filter_var($this->input->post('message'), FILTER_SANITIZE_STRING);
		$data['Sender']      = $this->input->post('Sender');
		$data['Date']        = $this->setting_model->converToTimezone();
		$data['CountMsg']    = 1 ;
		$LastMsg             = $this->db->query("SELECT CountMsg FROM temp_msg  ORDER BY ID DESC LIMIT 1")->row_array();
		if(sizeof($LastMsg) > 0  ){$data['CountMsg'] = (int)$LastMsg['CountMsg']+1 ; }

			if($data['LevelID'] !=0){$this->mobile_model->send_parent_msg($data);}

		$this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));

		redirect('admin/Report_Register/send_sms_parent','refresh');
	}
	/////////////////////////
	public function student_poll_report()
	{
		$Data['reasons']         = $this->Report_Register_model->get_student_poll();
		$Data['school_data']     = $this->Report_Register_model->get_student_poll_school();
		$Data['get_reasons']     = $this->Report_Register_model->get_reasons();
		$this->load->admin_template('view_student_poll', $Data);
	}

	public function student_poll_details_report()

	{
		$Data['schoolID']     = $this->uri->segment(4);
		$Data['reasonID']     = $this->uri->segment(5);
		$Data['Data']         = $this->Report_Register_model->get_student_poll_details($Data);

		$this->load->admin_template('view_student_poll_details', $Data);
	}
		/////////////////////////////////////////
		public function accept_student_register_automatically()
		{
			$NameSpace=0;
			$query=$this->db->query("select  id,student_NumberID from register_form where IsAccepted=0 ")->result();
			$_POST['IsActive']=1;
			foreach($query as $val){
				 $ID=$val->id;
				 $student_NumberID=$val->student_NumberID;
				 $check_student     = json_decode(file_get_contents(lang('api_link')."/api/Students/" . $this->ApiDbname . "/GetStudentStatus?studentIdNumber=" . $student_NumberID . ""));
				 if ($check_student->StBasicId == ""){
				 $this->accept_student_register($ID, $NameSpace);
				 }
				
			}
		}


}
