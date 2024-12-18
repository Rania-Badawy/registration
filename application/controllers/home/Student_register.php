<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Student_Register extends CI_Controller
{

	private $data = array();
	private $finance_api_base = 'https://api-school-public.esol.dev/api/';
	function __construct()

	{
		parent::__construct();
		$this->load->model(array( 'admin/student_register_model', 'admin/setting_model', 'admin/mobile_model', 'admin/Report_Register_model'));
		$this->load->helper('language');
		$this->data['Lang'] = $this->session->userdata('language');
		if ($this->data['Lang']) {
			$this->lang->load('am', $this->session->userdata('language'));
			$this->lang->load('er', $this->session->userdata('language'));
		} else {
			$this->lang->load('am', 'arabic');
			$this->lang->load('er', 'arabic');
		};

		$get_api_setting = $this->setting_model->get_api_setting();

		$this->ApiDbname = $get_api_setting[0]->{'ApiDbname'};

		$this->token      = $this->setting_model->acess_token();
	}
	public function index1()
	{
		$Data['reg'] = $this->db->query("SELECT Content FROM cms_details WHERE Token = '7fb561bfa86a865b99a364c7499b6088' ")->result();
		$Data['reg_system'] = $Data['reg'][0]->Content;
		$this->load->view('view_admission', $Data);
	}
	//////////////////////////////	
	public function index()
	{
	
		$Data['ApiDbname']          = $this->ApiDbname;
		$Data['Reg_ID']             = $this->uri->segment(4);
		$Data['lang']               = $this->session->userdata('language');
		$Data['get_identities']     = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllIdentityTypes"));
		$Data['get_educations']     = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllGraduationStudies"));
		$Data['studeType']          = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllStudyTypes"));
		$Data['get_genders']        = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllGenders"));
		$Data['get_ClassTypeName']  = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllClassTypes"));
		$Data['get_nationality']    = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllNationalities"));
		$Data['religion']           = json_decode(file_get_contents(lang('api_link')."/api/Fathers/GetAllReligions?dbName=" . $this->ApiDbname . ""));
		$Data['get_how_school']     = $this->student_register_model->get_how_school();
		$query                      = $this->db->query("SELECT reg_year FROM setting")->row_array();
		if($query['reg_year']){
			$Data['reg_year']         = $query['reg_year'];
		  }else{
			 $Data['reg_year'] =0;
		  }
		if ($this->ApiDbname == "SchoolAccExpertAcademy") {
			$this->load->view('Student_Register_Form_new12', $Data);
		} else {
			$this->load->view('Student_Register_Form_new1', $Data);
		} 
	}
	//////////////////////////////////////
	public function getStudentView($addStudentValue)
	{

		$Data['studeType']    = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "2/GetAllStudyTypes"));
		$data['get_schools']  = json_decode(file_get_contents(lang('api_link')."/api/Schools/" . $this->ApiDbname . "/GetAllSchools"));
		$data['get_genders']  = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllGenders"));
		$data['religion']     = json_decode(file_get_contents(lang('api_link')."/api/Fathers/GetAllReligions?dbName=" . $this->ApiDbname . ""));
		$data['get_row_level'] = $this->student_register_model->get_row_level();
		$data['val'] = true;
		$data['addStudentValue'] = $addStudentValue;
		if ($this->ApiDbname == "SchoolAccExpertAcademy") {
			return $this->load->view('Student_Register_Form_LoadData', $data);
		} else {
			return $this->load->view('Student_Register_Form_LoadDataNew', $data);
		}
	}

	////////////////////////////////////
	public function getStudentPsy($addStudentValue)
	{
		$data['addStudentValue'] = $addStudentValue;
		return $this->load->view('Student_Register_Form_Psy', $data);
	}
	///////////////////////////////
	public function NewRegister()
	{

		$token                      = $this->token;
		$Sender_array               = $this->sender();
		$Sender                     = $Sender_array[0];
		$data['date']               = $this->setting_model->converToTimezone_api();
		$number_id                  = $this->input->post('student_NumberID')[0];
		$fa_number_id               = $this->input->post('ParentNumberID');
		$data['Reg_ID']             = $this->input->post('Reg_ID');
		$YearId                     = $this->input->post('YearId')[0];
		$check_erp                  = $this->db->query("select Logo,IN_ERP,accpet_reg_type,reg_type,smsTestDirect from school_details ")->row_array();
		$get_logo                   = $this->db->query("select Logo from setting ")->row_array();
		$newTempDatqa['logo'] =base_url().'/intro/images/school_logo/'.$get_logo['Logo'];
		if ($check_erp['IN_ERP'] == 2 || $this->ApiDbname == "SchoolAccDigitalCulture") {
			$this->form_validation->set_rules('student_NumberID[]', ' رقم الهويه للطالب', 'trim|required|numeric|max_length[14]|unique_number_id');
			if ($this->form_validation->run() === false) {
				$this->session->set_flashdata('ErrorAdd', validation_errors());
			}
			$query   = $this->db->query("SELECT check_code  
    		                             FROM register_form 
    		                             INNER JOIN reg_parent ON reg_parent.ID = register_form.reg_parent_id
    		                             WHERE (student_NumberID = $number_id OR reg_parent.ParentNumberID = $number_id) AND register_form.YearId = $YearId")->row();

			$query_fa   = $this->db->query("SELECT check_code  
    		                             FROM register_form 
    		                             INNER JOIN reg_parent ON reg_parent.ID = register_form.reg_parent_id
    		                             WHERE student_NumberID = $fa_number_id AND register_form.YearId = $YearId")->row();
			if ($number_id == $fa_number_id) {

				$this->session->set_flashdata('ErrorAdd', lang('unique_number_id'));
			}
			if ($query->check_code && $query_fa->check_code) {
				$unique_number_id         = lang('student_already_registered') . " " . $query->check_code;
				$unique_ParentNumberID    = lang('numberid_already_registered') . " " . $query_fa->check_code;
				$this->session->set_flashdata('ErrorAdd', $unique_number_id);
				$this->session->set_flashdata('ErrorAdd', $unique_ParentNumberID);
			}

			if ($query->check_code) {
				$unique_number_id         = lang('student_already_registered') . " " . $query->check_code;
				$this->session->set_flashdata('ErrorAdd', $unique_number_id);
			}

			if ($query_fa->check_code) {
				$unique_ParentNumberID    = lang('numberid_already_registered') . " " . $query_fa->check_code;
				$this->session->set_flashdata('ErrorAdd', $unique_ParentNumberID);
			}

			if (!($data['Reg_ID']) && ($this->form_validation->run() === false || ($number_id == $fa_number_id || $query || $query_fa))) {

				$Data['get_identities']     = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllIdentityTypes"));
				$Data['get_educations']     = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllGraduationStudies"));
				$Data['studeType']          = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllStudyTypes"));
				$Data['get_genders']        = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllGenders"));
				$Data['get_ClassTypeName']  = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllClassTypes"));
				$Data['get_nationality']    = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllNationalities"));
				$data['religion']           = json_decode(file_get_contents(lang('api_link')."/api/Fathers/GetAllReligions?dbName=" . $this->ApiDbname . ""));
				$Data['get_how_school']     = $this->student_register_model->get_how_school();
				
				redirect('home/student_register/message','refresh');
			}
		}

		$name2                       	           =  filter_var($this->input->post('name2'), FILTER_SANITIZE_STRING);
		$name3                       	           =  filter_var($this->input->post('name3'), FILTER_SANITIZE_STRING);
		$name4                       	           =  filter_var($this->input->post('name4'), FILTER_SANITIZE_STRING);
		$name5                       	           =  filter_var($this->input->post('name5'), FILTER_SANITIZE_STRING);
		$data['parent_name']                       =  $name2 . ' ' . $name3 . ' ' . $name4 . ' ' . $name5;
		$frist_name_eng2                           =  filter_var($this->input->post('frist_name_eng2'), FILTER_SANITIZE_STRING);
		$frist_name_eng3                           =  filter_var($this->input->post('frist_name_eng3'), FILTER_SANITIZE_STRING);
		$frist_name_eng4                           =  filter_var($this->input->post('frist_name_eng4'), FILTER_SANITIZE_STRING);
		$frist_name_eng5                           =  filter_var($this->input->post('frist_name_eng5'), FILTER_SANITIZE_STRING);
		$data['parent_name_eng']                   =  $frist_name_eng2 . ' ' . $frist_name_eng3 . ' ' . $frist_name_eng4 . ' ' . $frist_name_eng5;
		$data['ParentNumberID']                    =  filter_var($this->input->post('ParentNumberID'), FILTER_SANITIZE_STRING);
		$data['parent_mobile']                     =  filter_var($this->input->post('parent_mobile'), FILTER_SANITIZE_STRING);
		$data['parent_type_Identity']              =  filter_var($this->input->post('parent_type_Identity'), FILTER_SANITIZE_STRING);
		$data['parent_source_identity']            =  filter_var($this->input->post('parent_source_identity'), FILTER_SANITIZE_STRING);
		$data['parent_email']                      =  filter_var($this->input->post('parent_email'), FILTER_SANITIZE_STRING);
		$data['parent_educational_qualification']  =  filter_var($this->input->post('parent_educational_qualification'), FILTER_SANITIZE_STRING);
		$data['parent_national_ID']                =  filter_var($this->input->post('parent_national_ID'), FILTER_SANITIZE_STRING);
		$data['parent_access_station']             =  filter_var($this->input->post('parent_access_station'), FILTER_SANITIZE_STRING);
		$data['parent_house_number']               =  filter_var($this->input->post('parent_house_number'), FILTER_SANITIZE_STRING);
		$data['parent_region']                     =  filter_var($this->input->post('parent_region'), FILTER_SANITIZE_STRING);
		$data['parent_profession']                 =  filter_var($this->input->post('parent_profession'), FILTER_SANITIZE_STRING);
		$data['parent_profession_mather']          =  filter_var($this->input->post('parent_profession_mather'), FILTER_SANITIZE_STRING);
		$data['parent_work_address']               =  filter_var($this->input->post('parent_work_address'), FILTER_SANITIZE_STRING);
		$data['person_name']                       =  filter_var($this->input->post('person_name'), FILTER_SANITIZE_STRING);
		$data['person_NumberID']                   =  filter_var($this->input->post('person_NumberID'), FILTER_SANITIZE_STRING);
		$data['person_mobile']                     =  filter_var($this->input->post('person_mobile'), FILTER_SANITIZE_STRING);
		$data['person_relative']                   =  filter_var($this->input->post('person_relative'), FILTER_SANITIZE_STRING);
		$data['school_staff']                      =  filter_var($this->input->post('school_staff'), FILTER_SANITIZE_STRING);
		$data['father_certificate']                =  filter_var($this->input->post('father_certificate'), FILTER_SANITIZE_STRING);
		$data['father_national_id']                =  filter_var($this->input->post('father_national_id'), FILTER_SANITIZE_STRING);
		$data['father_national_id2']               =  filter_var($this->input->post('father_national_id2'), FILTER_SANITIZE_STRING);
		$data['father_brith_certificate']          =  filter_var($this->input->post('father_brith_certificate'), FILTER_SANITIZE_STRING);
		$data['mother_certificate']                =  filter_var($this->input->post('mother_certificate'), FILTER_SANITIZE_STRING);
		$data['mother_national_id']                =  filter_var($this->input->post('mother_national_id'), FILTER_SANITIZE_STRING);
		$data['mother_national_id2']               =  filter_var($this->input->post('mother_national_id2'), FILTER_SANITIZE_STRING);
		$data['mother_brith_certificate']          =  filter_var($this->input->post('mother_brith_certificate'), FILTER_SANITIZE_STRING);
		$data['kg_picture']                        =  $this->input->post('kg_picture');
		$data['name']                              =  $this->input->post('name');
		$data['name_eng']                          =  $this->input->post('frist_name_eng');
		$data['student_NumberID']                  =  $this->input->post('student_NumberID');
		$data['student_region']                    =  $this->input->post('student_region');
		$data['gender']                            =  $this->input->post('gender');
		$data['ClassTypeName']                     =  $this->input->post('ClassTypeName');
		$data['birthdate']                         =  $this->input->post('birthdate');
		$data['birthdate_hij']                     =  $this->input->post('birthdate_hij');
		$data['birthplace']                        =  $this->input->post('birthplace');
		$data['rowID']                             =  $this->input->post('rowID');
		$data['school']                            =  $this->input->post('school');
		$data['studeType']                         =  $this->input->post('studeType');
		$data['level']                             =  $this->input->post('level');
		$data['status']                            =  $this->input->post('status')? $this->input->post('status'): NULL;
		$data['classID']                           =  $this->input->post('classID');
		$data['language']                          =  $this->input->post('language');
		$data['exSchool']                          =  $this->input->post('exSchool');
		$data['Academic_Issues']                   =  $this->input->post('Academic_Issues');
		$data['Admin_Issues']                      =  $this->input->post('Admin_Issues');
		$data['Finance_Issues']                    =  $this->input->post('Finance_Issues');
		$data['howScholl']                         =  filter_var($this->input->post('how_school'), FILTER_SANITIZE_STRING);
		$data['na_school_type']                    =  $this->input->post('na_school_type');
		$data['Financial_clearance']               =  $this->input->post('Financial_clearance');
		$data['Signature']                         =  filter_var($this->input->post('Signature'), FILTER_SANITIZE_STRING);
		$data['allowphoto']                        =  filter_var($this->input->post('allowphoto'), FILTER_SANITIZE_STRING);
		$data['parent_degre_img']                  =  $this->input->post('img_name');
		$data['birth_certificate']                 =  $this->input->post('birth_certificate');
		$data['vaccination_certificate']           =  $this->input->post('vaccination_certificate');
		$data['transport_address']                 =  $this->input->post('transport_address');
		$data['bro_name']                          =  $this->input->post('bro_name');
		$data['bro_levelID']                       =  $this->input->post('bro_levelID');
		$data['bro_School']                        =  $this->input->post('bro_School');
		$data['school_type']                       =  $this->input->post('school_type');
		$data['father_brith_date']                 =  $this->input->post('father_brith_date');
		$data['par_religion']                      =  filter_var($this->input->post('par_religion'), FILTER_SANITIZE_STRING);
		$data['emergency_number']                  =  filter_var($this->input->post('emergency_number'), FILTER_SANITIZE_STRING);
		$data['family_card1']                      =  $this->input->post('family_card1');
		$data['family_card2']                      =  $this->input->post('family_card2');
		$check_code                                =  $this->student_register_model->generate_unique_token();
		$msg                                       =  lang('Registration_successfully') . ' ' . lang('am_Check_Code_student') . ':' . $check_code;
		$newTempDatqa['rentCode']                  = $check_code;
		$newTempDatqa['schoolName']                = $check_code;
		$row_level                                 = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetRowLevel?schoolId=" . $data['school'][0] . "&rowId=" . $data['rowID'][0] . "&levelId=" . $data['level'][0] . "&studyTypeId=" . $data['studeType'][0] . "&genderId=" . $data['ClassTypeName'][0] . "&feeStatusId=" . $data['status'][0] . " "));
		$rowID                                     = $row_level->RowId;
		$levelID                                   = $row_level->LevelId;
		$data['levelName']                         = $LevelName      = $row_level->LevelName;
		$data['rowLevelName']                      = $RowLevelName   = $row_level->RowLevelName;
		$data['schoolName']                        = $SchoolName     = $row_level->SchoolName;
		$data['rowLevelID']                        = $rowLevelID     = $row_level->RowLevelId;
		$data['SchoolId']                          = $SchoolId       = $row_level->SchoolId;
		$reg_id                                    = $this->student_register_model->add_new_register($data, $check_code);
		if ($reg_id) {
			$registration_data                     = $this->student_register_model->get_student_register_by_id($reg_id);
			
				$Class = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetClassesBySchool?schoolId=" . $registration_data['schoolID'] . ""));
				foreach ($Class as $row) {
					$classDetails = $row;
				}
			$check_student      = json_decode(file_get_contents(lang('api_link')."/api/Students/" . $this->ApiDbname . "/GetStudentStatus?studentIdNumber=$number_id"));
			if (($check_erp['accpet_reg_type'] == 2 || $check_erp['accpet_reg_type'] == 3) && $check_erp['IN_ERP'] == 1 && $this->ApiDbname !='SchoolAccGheras') {
				$data['type']              =  2;
				$data['NameSpaceID']       =  87;
				$data['Level']             =  $levelID;
				$data['school']            =  $SchoolId;
				$data['get_per_emp']       =  $this->student_register_model->get_permission_reg($data);
				$message = "";
				foreach ($data['get_per_emp'] as $key => $val) {
					$to                          = $val->Mail;
					$subject                     = lang('Student_registered');
					$newTempData['schoolName']   = $SchoolName;
    				$newTempData['studentName']  = $registration_data['name'];
    				$newTempData['studentID']    = $registration_data['student_NumberID'];
    				$newTempData['rowLevelName'] = $RowLevelName;
    				$newTempData['logo']         = base_url().'/intro/images/school_logo/'.$get_logo['Logo'];
					$this->mobile_model->send_mail($to, $subject, $message, '',true,$newTempData);
				}
			}
			if ($check_erp['IN_ERP'] == 2 && $check_erp['accpet_reg_type'] == 1) {
				$this->Report_Register_model->create_student_user($registration_data);
			}
			if ($check_erp['IN_ERP'] == 1 && $check_student->StBasicId != "") {
				if ($this->ApiDbname == "SchoolAccAdvanced") {
					$msg      = "عزيزي ولي الأمر بيانات ابنكم/ابنتكم مقيده في برنامج الطلاب في المدارس يمكنكم مراجعة لجنة القبول والتسجيل لانهاء الاجراءات المتبقية";
				} else {
					$msg      =  lang('am_registe_erp')." ".lang('request_code')." ".$check_code ;
				}
			}
			if ($check_erp['accpet_reg_type'] == 1 && $check_erp['IN_ERP'] == 1 && $check_student->StBasicId == "") {
			
				
				$variableArray = array();
				$index = 1;
				$father_certificate        = $registration_data['father_certificate'];
				$father_national_id        = $registration_data['father_national_id'];
				$father_national_id2       = $registration_data['father_national_id2'];
				$father_brith_certificate  = $registration_data['father_brith_certificate'];
				$mother_certificate        = $registration_data['mother_certificate'];
				$mother_national_id        = $registration_data['mother_national_id'];
				$mother_national_id2       = $registration_data['mother_national_id2'];
				$mother_brith_certificate  = $registration_data['mother_brith_certificate'];
				$kg_picture                = $registration_data['kg_picture'];
				$birth_certificate         = $registration_data['birth_certificate'];
				$parent_degre_img          = $registration_data['parent_degre_img'];
				$Financial_clearance       = $registration_data['Financial_clearance'];
				$vaccination_certificate   = $registration_data['vaccination_certificate'];
				$family_card1              = $registration_data['family_card1'];
				$family_card2              = $registration_data['family_card2'];

				
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
						$index++; 

					}
				}
				$variableString = array_map('trim', $variableArray);
				// Post father data to API
				$father_data = [
					"Name"                        => $registration_data['parent_name'],
					"HomePhone"                   => $registration_data['parent_phone'],
					"WorkPhone"                   => $registration_data['parent_phone2'],
					"Mobile1"                     => $registration_data['parent_mobile'],
					"Mobile2"                     => $registration_data['parent_mobile2'],
					"StreetName"                  => $registration_data['parent_access_station'],
					"HouseNumber"                 => $registration_data['parent_house_number'],
					"Nationality_ID"              => intval($registration_data['parent_national_ID']),
					"Region"                      => $registration_data['parent_region'],
					"WorkPlace"                   => $registration_data['parent_work_address'],
					"Job"                         => $registration_data['parent_profession'],
					"Mail"                        => $registration_data['parent_email'],
					"GraduationStudy"             => $registration_data['ar_education'],
					"IDType"                      => $registration_data['ar_identity'],
					"IDNumber"                    => $registration_data['ParentNumberID'],
					"IDSource"                    => $registration_data['ID_place'],
					"ResponsibleName"             => $registration_data['person_name'],
					"ResponsibleIDNumber"         => $registration_data['person_NumberID'],
					"ResponsiblePhoneNumber"      => $registration_data['person_mobile'],
					"ResponsibleRelativeRelation" => $registration_data['person_relative'],	
					"kgPicture"                   => base_url('upload/' . $registration_data['kg_picture']),				
					"IsSchoolBelong"              => true,
					"EmpId"                       => 0,
					"EnName"                      => $registration_data['parent_name_eng'],
					"Religionid"                  => 1,
				];

				$father_result = $this->post_father_data($father_data);
				if (!$father_result->FatherID) {
					if(!$father_result->Message){
						$fatherMessage=$father_result;
					}else{
						 $fatherMessage=$father_result->Message;
					}
					$this->session->set_flashdata('ErrorAdd', $fatherMessage);
					redirect('home/student_register/message', 'refresh');
				}
				$student_data = [
					"FirstName"         => $registration_data['name'],
					"GenderId"          => intval($registration_data['gender']),
					"ClassTypeId"       => intval($registration_data['ClassTypeId']),
					"DateOfBirth"       => $registration_data['birthdate'],
					"Region"            => $registration_data['student_region'],
					"Notes"             => $registration_data['note'],
					"RegistrationDate"  => $registration_data['Reg_Date'],
					"IDNumber"          => $registration_data['student_NumberID'],
					"LastSchool"        => $registration_data['exSchool'],
					"PlaceOfBirth"      => $registration_data['birthplace'],
					"Father_ID"         => $father_result->FatherID,
					"StudyType"         => intval($registration_data['studyType']),
					"EnName"            => $registration_data['name_eng'],
					"MotherName"        => $registration_data['mother_name'],
					"MotherJob"         => $registration_data['mother_work'],
					"Year_ID"           => intval($registration_data['YearId']),
					"Class_ID"          => $registration_data['classID'],
					"RowID"             => $registration_data['rowID'],
					"LevelID"           => $registration_data['LevelID'],
					"School_ID"         => intval($registration_data['schoolID']),
					"MotherMobile"      => $registration_data['mother_mobile'],
					"MotherName"        => $registration_data['mothername'],
					"MotherWork"        => $registration_data['motherwork'],
					"MotherWorkPhone"   => $registration_data['motherworkphone'],
					"MotherEmail"       => $registration_data['motheremail'],
					"MotherIDNumber"    => $registration_data['motherNumberID'],
					"FeeStatusID"       => $registration_data['status'],
					"Attachments"       => $variableString,
					"semester"          => $registration_data['semester'],
					"MotherEducationalQualification" => $registration_data['mothereducationalqualification'],

				];

				$student_result = $this->post_student_data($student_data);

				if (!$student_result->StudentBasicDataID) {
					if(!$student_result->Message){
						$studentMessage=$student_result;
					}else{
						 $studentMessage=$student_result->Message;
					}
					$this->session->set_flashdata('ErrorAdd', $studentMessage);
					redirect('home/student_register/message', 'refresh');
				}

				if ($student_result->StudentBasicDataID) {
					$query = $this->db->query("SELECT * FROM active_request WHERE RequestID = '" . $reg_id . "' AND Type = 2  ")->num_rows();
					if ($query == 0) {
						$query = $this->db->query("SELECT * FROM permission_request WHERE Type = 2 GROUP BY  NameSpaceID  ")->result();

						if (sizeof($query) > 0) {
							foreach ($query as $Key => $Result) {
								$this->db->query("
            				INSERT INTO active_request
            				 SET 
            				 RequestID    = '" . $reg_id . "' ,
            				 NameSpaceID  = '" . $Result->NameSpaceID . "' , 
            				 IsActive     = 1,
            				 Type         = 2 ,
            				 EmpID        = '" . $this->session->userdata('id') . "'
            				   ");
							}
							$this->db->query("update  register_form SET  IsAccepted = 1 where id = '" . $reg_id . "' ");
						}
					}

					$message = lang('final_accept');
					if ($this->ApiDbname == "SchoolAccGheras") {
						$message = lang('am_date') . ":" . $registration_data['Reg_Date'] . PHP_EOL . lang('am_Check_Code_student') . ":" . PHP_EOL . $registration_data['check_code'] .
							PHP_EOL . lang('GH_accept1') . " " . $registration_data['name'] . " " . lang('GH_accept2') . " " . lang('am_row') . ":" . $RowLevelName . PHP_EOL . lang('GH_accept');
					}
					$to      = $data['parent_email'];
					$subject = lang('br_request_accepted') . ' ' . lang('For the student') . ' ' . $data['name'][0];
					if ($this->ApiDbname != "SchoolAccAdvanced") {
						$newTempDatqa['schoolName']   = $SchoolName;
						$newTempDatqa['studentName']  = $registration_data['name'];
						$newTempDatqa['studentID']    = $registration_data['student_NumberID'];
						$newTempDatqa['link']         = base_url() . '/home/student_register/check_code';
						$newTempDatqa['rowLevelName'] = $RowLevelName;
						$this->mobile_model->send_mail($to, $subject, $message, '',true,$newTempDatqa);

						$SmsRegistration     = $this->db->query("select SmsRegistration from setting")->row_array();
						if ($SmsRegistration['SmsRegistration'] == 1) {
							$this->mobile_model->send_msg($registration_data['parent_mobile'], $message, $Sender, $token);
						}
					}
				}
			}
			
			if ($check_code) {
				
				$to      = $registration_data['parent_email'];
				$subject = lang('Student_registered') . ' ' . $registration_data['name'];
				$message = lang('Registration_successfully') ;
				if ($check_erp['IN_ERP'] == 1 && $check_student->StBasicId != "") {
					$message      =  lang('am_registe_erp')." ".lang('request_code')." ".$check_code ;
				}
				if ($this->ApiDbname == "SchoolAccAdvanced") {
					$message = "نشكر لكم ثقتكم في اختياركم لمجمع  " . $SchoolName . "  " . "ونفيدكم انه تم تقييد ابنكم/ابنتكم " . "  " . $registration_data['name'] . PHP_EOL . "  في قائمة الانتظار نأمل منكم مراجعة قسم القبول والتسجيل للتوقيع على العقد المالي وانهاء إجراءات التسجيل.";
				}
				$newTempDatqa['schoolName']  = $SchoolName ;
				$newTempDatqa['studentName'] = $registration_data['name'];
				$newTempDatqa['studentID']   = $registration_data['student_NumberID'];
				$newTempDatqa['link']   = base_url() . '/home/student_register/check_code';
				$newTempDatqa['rowLevelName'] = $RowLevelName;
				
				$this->mobile_model->send_mail($to, $subject, $message, '' ,true,$newTempDatqa);

				$SmsRegistration     = $this->db->query("select SmsRegistration from setting")->row_array();
				if ($SmsRegistration['SmsRegistration'] == 1) {
					if ($this->ApiDbname == "SchoolAccAdvanced") {
						$message = "نشكر لكم ثقتكم في اختياركم لمجمع  " . $SchoolName . "  " . ". ونفيدكم انه تم تقييد ابنكم/ابنتكم في قائمة الانتظار نأمل منكم مراجعة قسم القبول والتسجيل للتوقيع على العقد المالي وانهاء إجراءات التسجيل";
					}
					if ($this->ApiDbname != "SchoolAccAndalos" && $this->ApiDbname != "SchoolAccElinjaz") {
					       $this->mobile_model->send_msg($registration_data['parent_mobile'], $message, $Sender, $token);
					}
				}
			}
			if ($this->ApiDbname == "SchoolAccAndalos" || $this->ApiDbname == "SchoolAccElinjaz") {

				$Code             = rand(100000, 999999);
				$token            = $this->token;
				$Sender_array     = $this->sender();
				$Sender           = $Sender_array[0];

				if ($data['parent_mobile']) {

					$query         = $this->db->query("INSERT INTO  INMobileCode SET FatherID = '" . $data['ParentNumberID'] . "',Mobile = '" . $data['parent_mobile'] . "' , Code = '" . $Code . "'  , Date = '" . $data['date'] . "' ");

					$Msg           = lang('br_message_code') ." " . $Code;

					$subject       = lang('request_code');

					$Send_Msg      = $this->mobile_model->send_msg($data['parent_mobile'], $Msg, $Sender, $token);

					$this->mobile_model->send_mail($data['parent_email'], $subject, $Msg, '');
				}
				redirect('home/student_register/confirm_code/' . $Code . "/" . $check_code);
			} else {
				$this->session->set_flashdata('SuccessAdd', $msg);

				if ($data['Reg_ID']) {
					redirect('home/student_register/index/' . $data['Reg_ID'], 'refresh');
				} else {
					redirect('home/student_register/message', 'refresh');
				}
			}
		} else {

			$this->session->set_flashdata('ErrorAdd', lang('br_add_error'));
			if ($data['Reg_ID']) {
				redirect('home/student_register/index/' . $data['Reg_ID'], 'refresh');
			} else {
				redirect('home/student_register', 'refresh');
			}
		}
	}
	//////////////////////////
	public function message()
	{
		$this->load->view('Student_Register_Form_message');
	}
	////////////////////////////////////
	public function do_upload()
	{
		$config = array(
			'upload_path' => "upload/",
			'allowed_types' => "gif|jpg|png|jpeg|pdf",
			'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
			'encrypt_name' => true
		);
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('userfile')) {
			$dataResponse['success'] = 1;
			$dataResponse['img'] = $this->upload->data()['file_name'];
			$this->output->set_content_type('application/json')->set_output(json_encode($dataResponse));
		} else {
			$dataResponse['success'] = 0;
			$dataResponse['msg'] = $this->upload->display_errors();
			$this->output->set_content_type('application/json')->set_output(json_encode($dataResponse));
		}
	}
/////////////////////////////////////
	public function register_form()
	{
	     $Data['get_genders']        = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/".$this->ApiDbname."/GetAllGenders"));
	     $Data['get_ClassTypeName']  = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/".$this->ApiDbname."/GetAllClassTypes"));
	     $Data['studeType']          = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/".$this->ApiDbname."/GetAllStudyTypes"));
	     $Data['get_nationality']    = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/".$this->ApiDbname."/GetAllNationalities"));
	     $Data['get_how_school']     = $this->student_register_model->get_how_school( );
		 $query                      = $this->db->query("SELECT reg_year FROM setting")->row_array();
		if($query['reg_year']){
			$Data['reg_year']         = $query['reg_year'];
		  }else{
			 $Data['reg_year'] =0;
		  }
	    $this->load->view('Add_Register_Form',$Data);
	    
	}
	//////////////////////////
	public function add_another_stu()
	{
		$Data['val']                = true;
		$Data['num_student']        = $this->uri->segment(4);
		$Data['get_genders']        = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllGenders"));
		$Data['get_ClassTypeName']  = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllClassTypes"));
		$Data['studeType']          = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllStudyTypes"));
		$Data['get_nationality']    = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllNationalities"));
		$Data['get_how_school']     = $this->student_register_model->get_how_school();
		$this->load->view('add_another_student', $Data);
	}
	//////////////////////////////////////////
	public function add_father_data()
	{
	    	  
		$this->form_validation->set_rules('parent_mobile', 'الجوال', 'required|numeric|max_length[20]');
		if ($this->form_validation->run() === false) {
			$this->session->set_flashdata('ErrorAdd', validation_errors());

			$this->load->view('Add_Register_Form');
		} else {

			$data['date']               =  $this->setting_model->converToTimezone();
			$data['parent_name']        =  filter_var($this->input->post('parent_name'), FILTER_SANITIZE_STRING);
			$data['grandba_name']       =  filter_var($this->input->post('grandba_name'), FILTER_SANITIZE_STRING);
            $data['family_name']        =  filter_var($this->input->post('family_name'), FILTER_SANITIZE_STRING);
			$data['parent_mobile']      =  filter_var($this->input->post('parent_mobile'), FILTER_SANITIZE_STRING);
			$data['parent_mobile2']     =  filter_var($this->input->post('parent_mobile2'), FILTER_SANITIZE_STRING);
			$data['parent_email']       =  filter_var($this->input->post('parent_email'), FILTER_SANITIZE_STRING);
			$data['parent_national_ID'] =  filter_var($this->input->post('parent_national_ID'), FILTER_SANITIZE_STRING);
			$data['ParentNumberID']     =  $this->input->post('ParentNumberID');
			$data['parent_region']      =  $this->input->post('parent_region');
			$this->data['Getdata']      =  $this->student_register_model->add_father_data($data);

			$this->output->set_content_type('application/json')->set_output(json_encode($this->data['Getdata']));
		}
    }
    ////////////////////////////////////////////////////////
	public function add_step_reg_data()
	{
	    	  
	         $arr=[];
		    $num_student               =  $this->input->post('num_ALL_Student');
		    for($i=1;$i<=$num_student;$i++){
            $data['date']              =  $this->setting_model->converToTimezone();   
            $data['stu_name']          =  filter_var($this->input->post('stu_name'.$i), FILTER_SANITIZE_STRING);
			$data['Parent_ID']         =  filter_var($this->input->post('Parent_ID'), FILTER_SANITIZE_STRING);
			$data['parent_name']       =  filter_var($this->input->post('parent_name_new'), FILTER_SANITIZE_STRING);
			$data['grandba_name']      =  filter_var($this->input->post('grandba_name_new'), FILTER_SANITIZE_STRING);
            $data['family_name']       =  filter_var($this->input->post('family_name_new'), FILTER_SANITIZE_STRING);
			$data['parent_mobile']     =  filter_var($this->input->post('parent_mobile_new'), FILTER_SANITIZE_STRING);
			$data['parent_mobile2']    =  filter_var($this->input->post('parent_mobile2_new'), FILTER_SANITIZE_STRING);
			$data['parent_email']      =  filter_var($this->input->post('parent_email_new'), FILTER_SANITIZE_STRING);
			$data['parent_national_ID']=  filter_var($this->input->post('parent_national_ID_new'), FILTER_SANITIZE_STRING);
			$data['parent_region']     =  filter_var($this->input->post('parent_region_new'), FILTER_SANITIZE_STRING);
			$data['ParentNumberID']    =  $this->input->post('ParentNumberID_new');
			$data['gender']            =  $gender    =  $this->input->post('gender'.$i);
			$data['ClassTypeName']     =  $ClassTypeName= $this->input->post('ClassTypeName'.$i);
			$data['studeType']         =  $studeType =  $this->input->post('studeType'.$i);
			$data['school']            =  $school    =  $this->input->post('school'.$i);
			$data['levelID']           =  $levelID   =  $this->input->post('levelID'.$i);
			$data['rowID']             =  $rowID     =  $this->input->post('rowID'.$i);
			$data['classes']           = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/".$this->ApiDbname."/GetClassesBySchool?schoolId=$school"));
            $data['classID']           = $data['classes'][0]->ClassId;
			$data['YearId']            =  $this->input->post('YearId'.$i);
			$data['student_NumberID']  =  filter_var($this->input->post('student_NumberID'.$i), FILTER_SANITIZE_STRING);
			$data['xschool']           =  $this->input->post('xschool'.$i);
			$data['how_school']        =  filter_var($this->input->post('how_school'.$i), FILTER_SANITIZE_STRING);
			$data['note']              =  filter_var($this->input->post('note'.$i), FILTER_SANITIZE_STRING);
			$data['ApiDbname']         =  $this->ApiDbname;
			$data['status']            =  $this->input->post('status'.$i);
			$data['status']            =  $data['status'] ? $data['status'] : NULL;
			$data['semester']          =  $this->input->post('semester'.$i);
			$row_level = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetRowLevel?schoolId=$school&rowId=$rowID&levelId=$levelID&studyTypeId=$studeType&genderId=$ClassTypeName&feeStatusId=" . $data['status'] . " "));
				$rowID                 = $row_level->RowId;
            	$levelID               = $row_level->LevelId;
            	$data['levelName']     = $LevelName      = $row_level->LevelName;
            	$data['rowLevelName']  = $RowLevelName   = $row_level->RowLevelName;
            	$data['schoolName']    = $SchoolName     = $row_level->SchoolName;
			if($data['stu_name']!=""){
			    	$query   = $this->db->query("SELECT check_code  
		                             FROM register_form 
		                             WHERE student_NumberID = ".$data['student_NumberID']."  AND register_form.YearId = ".$data['YearId']."")->result();
		          if(!empty($query)){
		               $unique_number_id         = lang('student_already_registered')." ".$query[0]->check_code."--".lang("student_name").":".$data['stu_name'];
		               $this->session->set_flashdata('ErrorAdd',$unique_number_id);
		               redirect('home/student_register/register_form','refresh');
		          }
			

			$data['type']              =  3;
			$data['get_per_emp']       =  $this->student_register_model->get_permission_emp($data);
			$data['check_code']        =  $check_code   =  $this->student_register_model->generate_unique_token();
			$regestredId = $this->student_register_model->add_step_reg_data($data);
			if($regestredId){
			    $data['studeType']          = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/".$this->ApiDbname."/GetAllStudyTypes"));
			foreach($data['studeType'] as $val){
			    if($studeType==$val->StudyTypeId){
			        $data['studyTypeName']=$val->StudyTypeName;
			     
			    }
			}
			$check_erp          = $this->db->query("select Logo,IN_ERP,accpet_reg_type,reg_type,smsTestDirect from school_details ")->row_array();
			$registration_data  = $this->student_register_model->get_student_register_by_id($regestredId);
			
// 			$check_exam         = $this->db->query("select ID  FROM `test` WHERE SchoolId=$school_lms AND FIND_IN_SET($R_L_ID_LMS ,`RowLevelID`) AND IsActive=1 AND type =4  ")->row_array();
			if ($check_erp['IN_ERP'] == 1 && $check_erp['reg_type'] == 2 && $check_erp['smsTestDirect'] == 1 && $check_exam['ID']) {
				$this->send_sms($regestredId);
			}
			    $query_mail   = $this->db->query("SELECT parent_email  
		                             FROM reg_parent  WHERE ID = ".$data['Parent_ID']." ")->row_array();
				$subject = lang('Student_registered') . ' ' . $data['stu_name'];
				$message = lang('Registration_successfully') ;
				
				$RowLevelName   = $row_level->RowLevelName;
				$newTempDatqa['rentCode']     = $check_code;
				$newTempDatqa['schoolName']	  = $SchoolName;
				$newTempDatqa['studentName']  = $data['stu_name'];
				$newTempDatqa['studentID']    = $data['student_NumberID'];
				$newTempDatqa['rowLevelName'] = $RowLevelName;
				$newTempDatqa['Slink']        = false;
				$newTempDatqa['link']         = base_url() . '/home/student_register/check_code';
			    $this->mobile_model->send_mail($query_mail['parent_email'],$subject,$message,'',true,$newTempDatqa);
			    foreach($data['get_per_emp'] as $key=>$val){
			        $to                    = $val->Mail;
			        $subject               = 'طلب جديد' ;
					$message               = 'تم تسجيل طلب جديد' ;
					$newTempDatqa['link']  = false;
					$newTempDatqa['rentCode']= false;
					$newTempDatqa['Slink'] =  base_url('admin/Report_Register/view_student_register_new/' . $regestredId);

			    $this->mobile_model->send_mail($to,$subject,$message,'',true,$newTempDatqa);
			    }
		    }
		   $msg_arr=$data['stu_name']." ".lang('request_code')." ".$check_code.PHP_EOL;
		    array_push($arr,$msg_arr);

        }}
        
                $msg          = implode(",",$arr);
                $msg1          = lang("reg_complete")." ".$msg;
				$this->session->set_flashdata('SuccessAdd',$msg1);
				 redirect('home/student_register/register_form','refresh');
}
///////////////////////////////////////
public function send_sms($ID)
	{
		$token              = $this->token;
		$Sender_array       = $this->sender();
		$Sender             = $Sender_array[0];
		$test_attend        = 1;
		$registration_data  = $this->Report_Register_model->get_student_register_by_id($ID);
		$user               = $this->Report_Register_model->create_student_account_marketing($registration_data, $ID);
		$reg_per_level      = $this->db->query("SELECT * FROM reg_per_level  WHERE reg_level=" . $registration_data['LevelLMS'] . " and school_id=" . $registration_data['school_lms'] . " ")->result();
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
			$data['school_LMS']      =  $this->db->query(" SELECT `ID`,SchoolName FROM `school_details` WHERE `ID` = " . $registration_data['school_lms'] . "")->row_array();

			$rowID = $row_level->RowId;
			$levelID = $row_level->LevelId;
			$RowLevelName   = $row_level->RowLevelName;
			$newTempDatqa['schoolName']  =  $data['school_LMS']['SchoolName'];
			$newTempDatqa['studentName'] = $registration_data['name'];
			$newTempDatqa['studentID'] = $registration_data['student_NumberID'];
			$newTempDatqa['rowLevelName'] =$RowLevelName;
			$this->mobile_model->send_mail($to, $subject, $message, '' ,true, $newTempDatqa);
			$SmsRegistration     = $this->db->query("select SmsRegistration from setting")->row_array();
			if ($SmsRegistration['SmsRegistration'] == 1) {
				$this->mobile_model->send_msg($registration_data['parent_mobile'], $Msg, $Sender, $token);
			}
		}

	}
	//////////////////////////////
	public function checkStudentNumberId($student_NumberID){
		$query = $this->db->query("select student_NumberID from register_form where student_NumberID=$student_NumberID ")->row_array()['student_NumberID'];
	   if($query)
	   {
		   $dataResponse['success'] = 0;
		   $this->output->set_content_type('application/json')->set_output(json_encode($dataResponse));
	   }
	   else
	   {
		   $dataResponse['success'] = 1;
		   $this->output->set_content_type('application/json')->set_output(json_encode($dataResponse));
	   }
   }

	////////////////////////////////////////last update

	public function check_student($NumberID = 0)
	{
		if (is_numeric($NumberID)) {
			$this->load->model(array('admin/student_register_model'));
			$this->data['getStudentR']  = $this->student_register_model->get_student_register_by_number_id($NumberID);
			$this->load->home_template('check_Student_Register_Form', $this->data);
		} else {
			$this->session->set_flashdata('ErrorAdd', lang('br_add_error'));
			redirect('home/student_register/check_student', 'refresh');
		}
	}


	public function check_code()
	{
		$data['lang']                = $this->uri->segment(4);
		$this->load->view('Student_Register_check_code', $data);
	}
	///////////////////////

	public function registerCode()
	{
		$reg_id           = $this->uri->segment(4);
		$data             = $this->student_register_model->get_student_register_by_id($reg_id);
		$data['date']     = $this->setting_model->converToTimezone_api();
		$Code             = rand(100000, 999999);
		$token            = $this->token;
		$Sender_array     = $this->sender();
		$Sender           = $Sender_array[0];
		$check_code       = $data['check_code'];
		$parent_mobile    = $data['parent_mobile'];

		if ($parent_mobile) {

			$query         = $this->db->query("INSERT INTO  INMobileCode SET FatherID = '" . $data['ParentNumberID'] . "',Mobile = '" . $parent_mobile . "' , Code = '" . $Code . "'  , Date = '" . $data['date'] . "' ");

			$Msg           = lang('br_message_code') ." " . $Code;

			$subject       = lang('request_code');
			
			$Send_Msg      = $this->mobile_model->send_msg($parent_mobile, $Msg, $Sender, $token);

			redirect('home/student_register/confirm_code/' . $Code . "/" . $check_code);
			
		}
		// $this->load->view('Student_Register_check_mobile', $this->data);
	}
	public function confirm_code()
	{
		$data['confirmCode']         = $this->uri->segment(4);
		$data['cheackCode']          = $this->uri->segment(5);
		$data['code']                =  $this->input->post('code');
		$msg                         =  lang('br_add_suc') . ' ' . lang('am_Check_Code_student') . ':' . $data['cheackCode'];
		if ($data['code']) {

			if ($data['confirmCode'] == $data['code']) {

				$this->db->query("UPDATE `register_form` SET `confirm_code`= 1 WHERE `check_code` = '" . $data['cheackCode'] . "' ");
				$this->session->set_flashdata('SuccessAdd', $msg);
				redirect('home/student_register/message', 'refresh');
			} else {
				$this->session->set_flashdata('ErrorAdd', 'الكود غيرمتطابق برجاء المحاوله مره اخري');
				redirect('home/student_register/confirm_code/' . $data['confirmCode'] . "/" . $data['cheackCode'], 'refresh');
			}
		} else {

			$this->load->view('Student_Register_confirm_code', $data);
		}
	}

	public function check()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->form_validation->set_rules('code', 'code', 'required');
			if ($this->form_validation->run() === false) {
				$dataResponse['success'] = 0;
				$this->output->set_content_type('application/json')->set_output(json_encode($dataResponse));
			} else {
				$code = $this->input->post('code');
				$check_code = $this->student_register_model->check_code($code);
				if ($check_code) {
					$dataResponse['success'] = 1;
					$dataResponse['data'] = $check_code;
					$dataResponse['levels'] = $this->student_register_model->getPermissionRequestsForApplication();
					$dataResponse['lang'] = $_SESSION["language"];
					$this->output->set_content_type('application/json')->set_output(json_encode($dataResponse));
				} else {
					$dataResponse['success'] = 0;
					$this->output->set_content_type('application/json')->set_output(json_encode($dataResponse));
				}
			}
		}
	}




	public function get_level($schoolID, $StudyTypeID)

	{
		$returnLevel = $this->student_register_model->get_level($schoolID, $StudyTypeID);
		if ($returnLevel) {
			$dataResponse['success'] = 1;
			$dataResponse['data'] = $returnLevel;
			$this->output->set_content_type('application/json')->set_output(json_encode($dataResponse));
		} else {
			$dataResponse['success'] = 0;
			$this->output->set_content_type('application/json')->set_output(json_encode($dataResponse));
		}
	}
	public function get_row_level($levelID, $schoolID)

	{
		$returnLevel = $this->student_register_model->get_row_level_register($levelID, $schoolID);
		if ($returnLevel) {
			$dataResponse['success'] = 1;
			$dataResponse['data'] = $returnLevel;
			$this->output->set_content_type('application/json')->set_output(json_encode($dataResponse));
		} else {
			$dataResponse['success'] = 0;
			$this->output->set_content_type('application/json')->set_output(json_encode($dataResponse));
		}
	}
	public function get_StudyType($schoolID)
	{
		$returnStudyType = $this->student_register_model->get_StudyType($schoolID);
		if ($returnStudyType) {
			$dataResponse = $returnStudyType;
			$this->output->set_content_type('application/json')->set_output(json_encode($dataResponse));
		} else {
			$dataResponse['success'] = 0;
			$this->output->set_content_type('application/json')->set_output(json_encode($dataResponse));
		}
	}

	public function getWebSystemId($schoolId)
	{
		return $this->db->select('SchoolName, ID')->where('ID_ACC', $schoolId)->get('school_details')->row_array();
	}

	private function fetchFromAPI($url)
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"Cookie: AspxAutoDetectCookieSupport=1"
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return $response;
	}
	//////////////////////////
	public function add_stu_bro()
	{
		$data['get_row_level'] = $this->student_register_model->get_row_level();
		$data['val'] = true;
		$data['addStudentValue'] = $addStudentValue;
		$this->load->view('Student_Register_brothers', $data);
	}

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
		//	print_r(json_decode($response));die;
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
		//	print_r(json_decode($response));die;
		return json_decode($response);
	}
	////////////////////////////////////
	public function sender()
	{
		$token = $this->token;
		$authorization = "Authorization: Bearer " . $token;
		$url = lang("api_sec_link")."/api/" . $this->ApiDbname . "/Sms/senders";
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
	
	function add_message($FaMobile, $FaNumberID)
	{
		$date             = $this->setting_model->converToTimezone_api();
		// $FaMobile         = $this->uri->segment(4);
		// $FaNumberID       = $this->uri->segment(5);
		$Code             = rand(100000, 999999);
		$token            = $this->token;
		$Sender_array     = $this->sender();
		$Sender           = $Sender_array[0];

		if ($FaMobile) {

			$query         = $this->db->query("INSERT INTO  INMobileCode SET FatherID = '" . $FaNumberID . "',Mobile = '" . $FaMobile . "' , Code = '" . $Code . "'  , Date = '" . $date . "' ");

			$Msg           = lang('request_code') . PHP_EOL . $Code;

			$Send_Msg      = $this->mobile_model->send_msg($FaMobile, $Code, $Sender, $token);
		}

		echo json_encode($Code);
	}
	public function config_semester_register()
	{
		$query = $this->db->query("SELECT * FROM form_setting WHERE input_id = 'semester'");
		$this->data['firstRow'] = $query->row();
		$this->load->admin_template('Config_semester_register', $this->data);

	}

	public function updateSemestreConfig()
	{
		if (isset($_POST['reg_type']) && !empty($_POST['reg_type'])) {
			$reg_type = $_POST['reg_type'];
			
			$reg_type = $this->db->escape($reg_type);

			$sql = "UPDATE form_setting SET Edit = $reg_type, display = 0 WHERE input_id = 'semester'";
			$update = $this->db->query($sql);

			
		} else {
			$this->db->set(['Edit' => '', 'display' => 1]);
			$this->db->where('input_id', 'semester');
			$update =  $this->db->update('form_setting');
		}
		if($update){
			$this->session->set_flashdata('success_msg', 'تم التحديث بنجاح.');

		}
		redirect('admin/Config_system/config_semester_register', 'refresh');

	}
	
   ////////////////////////

}
