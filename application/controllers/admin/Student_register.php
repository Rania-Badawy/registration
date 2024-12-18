<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Student_Register extends MY_Admin_Base_Controller
{

	private $data = array();
	private $finance_api_base = 'https://api-school-public.esol.dev/api/';

	function __construct()

	{
		parent::__construct();
		$this->load->model(array('admin/student_register_model', 'admin/setting_model', 'evaluation/evaluation_report_complex_model'));
		$this->load->library('get_data_admin');
		$this->data['UID'] = $this->session->userdata('id');
		$this->data['YearID'] = $this->session->userdata('YearID');
		$this->data['Year'] = $this->session->userdata('Year');
		$this->data['Semester'] = $this->session->userdata('Semester');
		$this->data['Lang'] = $this->session->userdata('language');
		if ($this->data['YearID'] == 0) {
			redirect('admin/config_system');
		}


		$get_api_setting = $this->setting_model->get_api_setting();
		$this->ApiDbname = $get_api_setting[0]->{'ApiDbname'};


		$this->data['Lang'] = $this->session->userdata('language');
	}

	////index	
	public function index($IsActive = 0)
	{
		$rowlevel                       = get_rowlevel_select_in();
		$this->data['Get_Year']         = $this->uri->segment(4);
		$get_schools                    = json_decode(file_get_contents(lang('api_link')."/api/Schools/" . $this->ApiDbname . "/GetAllSchools"));
		$schoolId                       = $get_schools[0]->SchoolId;
		$this->data['GetYear']         = json_decode(file_get_contents(lang('api_link')."/api/Years/" . $this->ApiDbname . "/GetOpenedYearsBySchoolId?schoolId=$schoolId"));
		$this->data['IsActive']         = $IsActive;
		$this->data['get_nationality']  = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllNationalities"));
		$this->data['getRowLevel']      = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllRowLevels"));
		if ($this->data['Get_Year']) {
			$this->data['getStudentR']      = $this->student_register_model->get_student_register($rowlevel, $this->data['Get_Year']);
		}
		$this->load->admin_template('Student_Register_Form', $this->data);
	}

	public function student_register_brother($IsActive = 0)
	{

		$this->data['IsActive'] = $IsActive;
		$this->data['get_nationality']  = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllNationalities"));
		$this->data['getRowLevel']  = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllRowLevels"));

		$this->data['getStudentR']  = $this->student_register_model->get_student_register_brothers($IsActive);

		$this->load->admin_template('student_register_brothers', $this->data);
	}

	public function add_from_report_need_register_api()
	{
		if ($this->ApiDbname == 'SchoolAccShorouqAlmamlakah' || $this->ApiDbname == 'SchoolAccRemas') {
			$Name_en = Name;
			$Name    = Name_en;
		} else {
			$Name_en = Name_en;
			$Name    = Name;
		}
		$add_school_id_to    = $this->input->post('add_school_id_to');
		$add_school_id_from  = $this->input->post('add_school_id_from');
		$type                = $this->input->post('type');
		$year_name           = $this->input->post('add_year_name');
		$year_ID             = $this->input->post('add_year_id');
		$contacts = array();
		$json = file_get_contents(lang('api_link')."/api/Students/" . $this->ApiDbname . "/GetAllStudentData?schoolId=$add_school_id_from&genderId=$type&yearId=$year_ID");
		$all_students =  json_decode($json);

		foreach ($all_students as $Key => $StudentR) {


			$contacts[$StudentR->StBasicId]['StName']          = filter_var($StudentR->StName, FILTER_SANITIZE_STRING);
			$contacts[$StudentR->StBasicId]['StNameEn']        = filter_var($StudentR->StNameEn, FILTER_SANITIZE_STRING);
			$contacts[$StudentR->StBasicId]['StIdNumber']      = $StudentR->StIdNumber;
			$contacts[$StudentR->StBasicId]['StBasicId']       = $StudentR->StBasicId;
			$contacts[$StudentR->StBasicId]['StDetailsId']     = $StudentR->StDetailsId;
			$contacts[$StudentR->StBasicId]['FaId']            = $StudentR->FaId;
			$contacts[$StudentR->StBasicId]['FaIdNumber']      = $StudentR->FaIdNumber;
			$contacts[$StudentR->StBasicId]['FaName']          = filter_var($StudentR->FaName, FILTER_SANITIZE_STRING);
			$contacts[$StudentR->StBasicId]['FaNameEn']        = filter_var($StudentR->FaNameEn, FILTER_SANITIZE_STRING);
			$contacts[$StudentR->StBasicId]['FaMobile1']       = $StudentR->FaMobile1;
			$contacts[$StudentR->StBasicId]['RowLevelId']      = $StudentR->RowLevelId;
			$contacts[$StudentR->StBasicId]['NationalityId']   = $StudentR->NationalityId;
			$contacts[$StudentR->StBasicId]['StNationalityId'] = $StudentR->StNationalityId;
			$contacts[$StudentR->StBasicId]['StLongtude']      = $StudentR->StLongtude;
			$contacts[$StudentR->StBasicId]['StLatitude']      = $StudentR->StLatitude;
			$contacts[$StudentR->StBasicId]['NameAtPassport']  = $StudentR->NameAtPassport;
			$contacts[$StudentR->StBasicId]['NameEnAtPassport'] = $StudentR->NameEnAtPassport;
			$contacts[$StudentR->StBasicId]['PassportNumber']  = $StudentR->PassportNumber;
			$contacts[$StudentR->StBasicId]['PassportReleaseDate']   = $StudentR->PassportReleaseDate;
			$contacts[$StudentR->StBasicId]['PassportExpiryDate']   = $StudentR->PassportExpiryDate;
			$contacts[$StudentR->StBasicId]['LevelID']         = $StudentR->LevelID;
			$contacts[$StudentR->StBasicId]['RowID']           = $StudentR->RowID;
			$contacts[$StudentR->StBasicId]['ClassId']         = $StudentR->ClassId;
			$contacts[$StudentR->StBasicId]['SchoolId']        = $StudentR->SchoolId;
			$contacts[$StudentR->StBasicId]['StGenderId']      = $StudentR->StGenderId;
			$contacts[$StudentR->StBasicId]['LevelName']       = filter_var($StudentR->LevelName, FILTER_SANITIZE_STRING);
			$contacts[$StudentR->StBasicId]['RowName']         = filter_var($StudentR->RowName, FILTER_SANITIZE_STRING);
			$contacts[$StudentR->StBasicId]['ClassName']       = filter_var($StudentR->ClassName, FILTER_SANITIZE_STRING);
			$contacts[$StudentR->StBasicId]['StatusId']        = $StudentR->StatusId;
			$contacts[$StudentR->StBasicId]['StatusName']      = $StudentR->StatusName;
			$contacts[$StudentR->StBasicId]['LeavingDate']     = $StudentR->LeavingDate;
			$contacts[$StudentR->StBasicId]['StudyTypeId']     = $StudentR->StudyTypeId;
			$contacts[$StudentR->StBasicId]['IsExists']        = $StudentR->IsExists;
			$contacts[$StudentR->StBasicId]['YearName']        = $StudentR->YearName;
			$contacts[$StudentR->StBasicId]['religion']        = $StudentR->religion;
			$contacts[$StudentR->StBasicId]['SecondLangauge']  = $StudentR->SecondLangauge;
			$contacts[$StudentR->StBasicId]['EmpId']           = $StudentR->EmpId;
			$contacts[$StudentR->StBasicId]['IsSchoolBelong']  = $StudentR->IsSchoolBelong;
			$contacts[$StudentR->StBasicId]['StDetailsId']     = $StudentR->StDetailsId;
			$contacts[$StudentR->StBasicId]['motherName']      = filter_var($StudentR->MotherNAme, FILTER_SANITIZE_STRING);
			$contacts[$StudentR->StBasicId]['motherMobile']    = filter_var($StudentR->MotherMobile, FILTER_SANITIZE_STRING);
		}

		$ids = $this->input->post('ids');
		foreach ($ids as $value) {
			if ($this->ApiDbname == 'SchoolAccAsrAlMawaheb') {
				$st_name_en = $contacts[$value]['StName'];
			} else {
				$st_name_en = $contacts[$value]['StNameEn'];
			}
			$YearName =  $contacts[$value]['YearName'];
			if ($YearName == $year_name) {
				$FaIdNumber =  $contacts[$value]['FaIdNumber'];
				$EmpId      =  $contacts[$value]['EmpId'];
				$FaId       =  $contacts[$value]['FaId'];
				if ($EmpId) {
					$query = $this->db->query("SELECT ID ,Type FROM contact WHERE IDHr =$EmpId ")->result();
				} elseif ($FaId) {
					$query = $this->db->query("SELECT ID ,Type FROM contact WHERE ID_ACC =$FaId ")->result();
				}
				if (!sizeof($query) > 0) {
					$this->db->query("INSERT INTO  contact SET  
                    		User_Name       = '" . $contacts[$value]['FaIdNumber'] . "' ,
                    		$Name           = '" . $contacts[$value]['FaName'] . "' ,
                    		$Name_en        = '" . $contacts[$value]['FaNameEn'] . "' ,
                    		ID_ACC          = '" . $contacts[$value]['FaId'] . "' ,
                    		Number_ID       = '" . $contacts[$value]['FaIdNumber'] . "' ,
                    		Phone           = '" . $contacts[$value]['FaMobile1'] . "' ,
                    		Nationality_ID  = '" . $contacts[$value]['NationalityId'] . "' ,
                    		Longtude        = '" . $contacts[$value]['StLongtude'] . "' ,
                    		Latitude        = '" . $contacts[$value]['StLatitude'] . "' ,
                    		NameAtPassport  = '" . $contacts[$value]['NameAtPassport'] . "' ,
                    		NameEnAtPassport= '" . $contacts[$value]['NameEnAtPassport'] . "' ,
                    		PassportNumber  = '" . $contacts[$value]['PassportNumber'] . "' ,
                    		PassportReleaseDate = '" . $contacts[$value]['PassportReleaseDate'] . "' ,
                    		PassportExpiryDate  = '" . $contacts[$value]['PassportExpiryDate'] . "' ,
                    		IDHr            = '" . $contacts[$value]['EmpId'] . "' ,
                    		typeHr          = '" . $contacts[$value]['IsSchoolBelong'] . "' ,
                    		SchoolID        = '" . $add_school_id_to . "' ,
                    		Type            = 'F'   
                    
                    		");
					$fa_contact_id = $this->db->insert_id();
					$this->db->query("INSERT INTO  father SET  Contact_ID = '" . $fa_contact_id . "' ");


					$this->db->query("update  contact SET  
            				 Token = '" . md5('qwwtertyrtuytyuiyuouippisdggdfghfjghkjhkjljh7455221456322872598vxcvxcvxcfjkyfgkbtium.ljnuytudfyfdghstwres5576432.21325454542vc22' . $fa_contact_id) . "',
            				 Password = '" . md5('qwwtertyrtuytyuiyuouippisdggdfghfjghkjhkjljh7455221456322872598vxcvxcvxcfjkyfgkbtium.ljnuytudfyfdghstwres5576432.21325454542vc' . $contacts[$value]['FaIdNumber']) . "'
            				 where 
            				 ID = '" . $fa_contact_id . "'
            				   ");
				} else {
					$fa_contact_id = $query[0]->{'ID'};
					$this->db->query("update  contact SET  
			                            	ID_ACC   = '" . $contacts[$value]['FaId'] . "',
			                               	IDHr     = '" . $contacts[$value]['EmpId'] . "' ,
                    		                typeHr   = '" . $contacts[$value]['IsSchoolBelong'] . "' 
				                            where ID = '" . $fa_contact_id . "' ");
				}

				$StBasicId =  $contacts[$value]['StBasicId'];
				$query = $this->db->query("SELECT ID FROM contact WHERE studentBasicID ='$StBasicId'   ")->result();

				if (!sizeof($query) > 0) {
					if (empty($contacts[$value]['StIdNumber'])) {
						$User_Name = $contacts[$value]['StName'];
					} else {
						$User_Name = $contacts[$value]['StIdNumber'];
					}

					$LevelName      = $contacts[$value]['LevelName'];
					$RowName        = $contacts[$value]['RowName'];
					$query_level    = $this->db->query("SELECT ID FROM row_level WHERE Level_Name ='$LevelName'   and Row_Name='$RowName'  ")->row_array();

					$this->db->query("INSERT INTO  contact SET 
                    		Gender            = '" . $contacts[$value]['StGenderId'] . "' ,
                    		User_Name         = '" . $User_Name . "' ,
                    		RealEstateComID   = '" . $contacts[$value]['StDetailsId'] . "',
                    		$Name             = '" . $contacts[$value]['StName'] . "',
                    		$Name_en          = '" . $st_name_en . "',
                    		studentBasicID    = '" . $contacts[$value]['StBasicId'] . "' ,
                    		Number_ID         = '" . $contacts[$value]['StIdNumber'] . "' ,
                    		Phone             = '" . $contacts[$value]['FaMobile1'] . "' ,
                    		Nationality_ID    = '" . $contacts[$value]['StNationalityId'] . "' ,
                    		Longtude          = '" . $contacts[$value]['StLongtude'] . "' ,
                    		Latitude          = '" . $contacts[$value]['StLatitude'] . "' ,
                    		NameAtPassport    = '" . $contacts[$value]['NameAtPassport'] . "' ,
                    		NameEnAtPassport  = '" . $contacts[$value]['NameEnAtPassport'] . "' ,
                    		PassportNumber    = '" . $contacts[$value]['PassportNumber'] . "' ,
                    		PassportReleaseDate = '" . $contacts[$value]['PassportReleaseDate'] . "' ,
                    		PassportExpiryDate  = '" . $contacts[$value]['PassportExpiryDate'] . "' ,
                    		ID_ACC            = '" . $contacts[$value]['FaId'] . "' ,
                    		SchoolID          = '" . $add_school_id_to . "' , 
                    		Isactive          = '" . $contacts[$value]['IsExists'] . "',
                    		GR_Number         = '" . $contacts[$value]['Notes'] . "' ,
							motherName        = '" . $contacts[$value]['motherName'] . "' ,
							motherMobile      = '" . $contacts[$value]['motherMobile'] . "' ,
                    		Type              = 'S' 
                    		");
					$contact_id = $this->db->insert_id();

					$token    = md5('qwwtertyrtuytyuiyuouippisdggdfghfjghkjhkjljh7455221456322872598vxcvxcvxcfjkyfgkbtium.ljnuytudfyfdghstwres5576432.21325454542vc22' . $contact_id);
					$password = md5('qwwtertyrtuytyuiyuouippisdggdfghfjghkjhkjljh7455221456322872598vxcvxcvxcfjkyfgkbtium.ljnuytudfyfdghstwres5576432.21325454542vc' . $User_Name);

					$this->db->query("update  contact SET  
                        				 Token = '" . $token . "',
                        				 Password = '" . $password . "'
                        				 where 
                        				 ID = '" . $contact_id . "' ");

					$LevelName      = $contacts[$value]['LevelName'];
					$RowName        = $contacts[$value]['RowName'];
					$ClassName      = $contacts[$value]['ClassName'];
					$StudyTypeId    = $contacts[$value]['StudyTypeId'];
					$religion       = $contacts[$value]['religion'];
					$SecondLangauge = $contacts[$value]['SecondLangauge'];
					$LevelID        = $contacts[$value]['LevelID'];
					$RowID          = $contacts[$value]['RowID'];
					$ClassId        = $contacts[$value]['ClassId'];


					$query_class    = $this->db->query("SELECT ID FROM class WHERE Name ='$ClassName'   ")->row_array();
					if ($this->ApiDbname == 'SchoolAccGheras' || $this->ApiDbname == 'SchoolAccTabuk') {
						$query_level    = $this->db->query("SELECT ID,Level_ID FROM row_level WHERE level_erp =$LevelID   and row_erp=$RowID AND StudyTypeID=$StudyTypeId ")->row_array();
						$query_class    = $this->db->query("SELECT ID FROM class WHERE 1 and FIND_IN_SET($ClassId, ID_ERP)")->row_array();
					}
					if ($this->ApiDbname == 'SchoolAccAlebdaa' && $LevelID == 58 && $contacts[$value]['StGenderId'] == 1) {
						$query_level    = $this->db->query("SELECT ID,Level_ID FROM row_level WHERE Level_ID = 2   and row_erp=$RowID AND StudyTypeID=$StudyTypeId ")->row_array();
					} elseif ($this->ApiDbname == 'SchoolAccAlebdaa' && $LevelID == 58 && $contacts[$value]['StGenderId'] == 2) {
						$query_level    = $this->db->query("SELECT ID,Level_ID FROM row_level WHERE Level_ID = 5   and row_erp=$RowID AND StudyTypeID=$StudyTypeId ")->row_array();
					}

					$R_L_ID         = $query_level['ID'];
					$class_id       = $query_class['ID'];
					if ($sec_lang) {
						$query_sub = $this->db->query("SELECT ID FROM subject WHERE Name_en ='$SecondLangauge' ")->row_array();
						$sec_lang = $query_sub['ID'];
					}
					if ($religion) {
						$query_religion = $this->db->query("SELECT ID FROM subject WHERE Name_en ='$religion' ")->row_array();

						$religion_id = $query_religion['ID'];
					}
					if ($sec_lang && $religion_id) {

						$s_language = $religion_id . ',' . $sec_lang;
					} elseif ($sec_lang) {

						$s_language = $sec_lang;
					} elseif ($religion_id) {

						$s_language = $religion_id;
					} else {

						$s_language = "";
					}

					if ($R_L_ID == '') {
						$R_L_ID = '0';
					}

					$this->db->query("INSERT INTO  student SET  
                		Contact_ID         = '" . $contact_id . "' ,
                		Class_ID           = '" . $class_id . "' ,
                		R_L_ID             = '" . $R_L_ID . "' ,
                		Father_ID          = '" . $fa_contact_id . "',
                		StudyTypeID        = '" . $StudyTypeId . "',
                		s_language         = '" . $s_language . "' ");

					$st_contact_id = $this->db->insert_id();

					$this->db->query("update  student SET  
        				 Token = '" . md5('qwwtertyrtuytyuiyuouippisdggdfghfjghkjhkjljh7455221456322872598vxcvxcvxcfjkyfgkbtium.ljnuytudfyfdghstwres5576432.21325454542vc22' . $st_contact_id) . "'
        			 	 where ID = '" . $st_contact_id . "' ");
				}
			}
		}

		redirect('admin/student_register/report_need_register_api/' . $add_school_id_to . "/" . $type);
	}


	//////////
public function add_from_report_need_update_api()
{
    $batchSize = 100; // Process 100 rows at a time

    // Get all student data in batches
    	$get_schools         = json_decode(file_get_contents(lang('api_link')."/api/Schools/" . $this->ApiDbname . "/GetAllSchools"));
		$schoolId            = $get_schools[0]->SchoolId;
		$GetYear             = json_decode(file_get_contents(lang('api_link')."/api/Years/" . $this->ApiDbname . "/GetOpenedYearsBySchoolId?schoolId=$schoolId"));
		$add_school_id_to    = $this->input->post('school_id_to');
		$add_school_id_from  = $this->input->post('school_id_from');
		$years               = explode("/", $this->input->post('GetYear'));
		$year_name           = $years[0];
		$year_ID             = $years[1];
		$studyType           = explode("/", $this->input->post('studeType'));
		$studeType           = $studyType[0];
		$studeTypeName       = $studyType[1];
		$levelID             = $this->input->post('levelID');
		$arr=[];
        $arr1=[];
         foreach($levelID as $Key=>$i)
        {
         $ee=explode('/',$i);
         $lev_id=$ee[0];
         $lev_name=$ee[1];
            array_push($arr,$lev_id);
            array_push($arr1,$lev_name);
        }
        $level=implode(',',$arr);
        $levelName=implode(',',$arr1);
		$type                = $this->input->post('type');
		$x = 0;
		$UP_Data = 0;
		$IN_Data = 0;
    $students = json_decode(file_get_contents(lang('api_link')."/api/Students/" . $this->ApiDbname . "/GetAllStudentData?schoolId=$add_school_id_from&genderId=$type&yearId=$year_ID"));

    $totalStudents = count($students);
    $start = 0;

    while ($start < $totalStudents) {
        $end = min($start + $batchSize, $totalStudents);
        $batch = array_slice($students, $start, $end - $start);
        $this->processStudentBatch($batch);

        // Update the start position
        $start += $batchSize;
	}
	if($add_school_id_from && $add_school_id_to ){
	$this->db->query("INSERT INTO log_update SET  contactID = '" . $this->session->userdata('id'). "' ,
	 type = 'S' ,source = '" .$add_school_id_from. "' , goal = '".$add_school_id_to."', gender = '".$type."' ,
	 level_name = '".$levelName."' , studt_type = '".$studeTypeName."',year='".$year_name."'  ");
	}
	echo json_encode(['status' => 'completed']);
    // redirect('admin/student_register/report_need_update_api/' . $add_school_id_to . "/" . $type . "/" . $UP_Data . "/" . $IN_Data);
}

private function processStudentBatch($batch)
{

		$add_school_id_to    = $this->input->post('school_id_to');
		$add_school_id_from  = $this->input->post('school_id_from');
		$user_changed        = $this->input->post('user_changed');
		$years               = explode("/", $this->input->post('GetYear'));
		$year_name           = $years[0];
		$year_ID             = $years[1];
		$type                = $this->input->post('type');
		$studyType           = explode("/", $this->input->post('studeType'));
		$studeType           = $studyType[0];
		$studeTypeName       = $studyType[1];
		$levelID             = $this->input->post('levelID');
		$arr=[];
        $arr1=[];
         foreach($levelID as $Key=>$i)
        {
         $ee=explode('/',$i);
         $lev_id=$ee[0];
         $lev_name=$ee[1];
            array_push($arr,$lev_id);
            array_push($arr1,$lev_name);
        }
        $level=$arr;
        $levelName=implode(',',$arr1);
		$x = 0;
		$UP_Data = 0;
		$IN_Data = 0;
				if ($this->ApiDbname == 'SchoolAccShorouqAlmamlakah' || $this->ApiDbname == 'SchoolAccRemas' ||  $this->ApiDbname == 'SchoolAccAtlas') {
			$Name_en = Name;
			$Name    = Name_en;
		} else {
			$Name_en = Name_en;
			$Name    = Name;
		}
    foreach ($batch as $StudentR) {
           $whereISactive="";
            $LevelName        = $StudentR->LevelName;
			$RowName          = $StudentR->RowName;
			$ClassName        = $StudentR->ClassName;
			$StudyTypeId      = $StudentR->StudyTypeId;
			$religion         = $StudentR->religion;
			$LevelID          = $StudentR->LevelID;
			$RowID            = $StudentR->RowID;
			$ClassId          = $StudentR->ClassId;
			$SecondLangauge   = $StudentR->SecondLangauge;
			$LastSchool       = $StudentR->LastSchool;
			$DateOfBirth      = $StudentR->DateOfBirth;
			$PlaceOfBirth     = $StudentR->PlaceOfBirth;
			$RegistrationDate = $StudentR->RegistrationDate;
			$RegistrationDate = date('Y-m-d', strtotime($RegistrationDate));
			$StLongtude       = $StudentR->StLongtude;
			$StLatitude       = $StudentR->StLatitude;
			$NameAtPassport   = filter_var($StudentR->NameAtPassport, FILTER_SANITIZE_STRING);
			$NameEnAtPassport = filter_var($StudentR->NameEnAtPassport, FILTER_SANITIZE_STRING);
			$PassportNumber   = $StudentR->PassportNumber;
			$PassportReleaseDate = $StudentR->PassportReleaseDate;
			$PassportExpiryDate  = $StudentR->PassportExpiryDate;
			$StName           = filter_var($StudentR->StName, FILTER_SANITIZE_STRING);
			$StNameEn         = filter_var($StudentR->StNameEn, FILTER_SANITIZE_STRING);
			$FaName           = filter_var($StudentR->FaName, FILTER_SANITIZE_STRING);
			$FaNameEn         = filter_var($StudentR->FaNameEn, FILTER_SANITIZE_STRING);
			$query_level      = $this->db->query("SELECT ID,Level_ID FROM row_level WHERE Level_Name ='$LevelName'   and Row_Name='$RowName'  ")->row_array();
			$query_class      = $this->db->query("SELECT ID FROM class WHERE 1 and FIND_IN_SET($ClassId, ID_ERP)")->row_array();
			if ($this->ApiDbname == 'SchoolAccAsrAlMawaheb') {
				$StNameEn = $StName;
			}
			if ($this->ApiDbname == 'SchoolAccGheras' || $this->ApiDbname == 'SchoolAccTabuk') {
				$query_level    = $this->db->query("SELECT ID,Level_ID FROM row_level WHERE level_erp =$LevelID   and row_erp=$RowID AND StudyTypeID=$StudyTypeId ")->row_array();
			}

			if ($this->ApiDbname == 'SchoolAccAlebdaa' && $LevelID == 58 && $StudentR->StGenderId == 1) {
				$query_level    = $this->db->query("SELECT ID,Level_ID FROM row_level WHERE Level_ID = 2   and row_erp=$RowID AND StudyTypeID=$StudyTypeId ")->row_array();
			} elseif ($this->ApiDbname == 'SchoolAccAlebdaa' && $LevelID == 58 && $StudentR->StGenderId == 2) {
				$query_level    = $this->db->query("SELECT ID,Level_ID FROM row_level WHERE Level_ID = 5   and row_erp=$RowID AND StudyTypeID=$StudyTypeId ")->row_array();
			}
			if ($this->ApiDbname == 'SchoolAccTabuk') {

				if ($query_level['Level_ID'] == 1) {

					$add_school_id_to = 3;
				} else {

					if ($StudentR->StGenderId == 1) {

						$add_school_id_to = 1;
					} elseif ($StudentR->StGenderId == 2) {

						$add_school_id_to = 2;
					}
				}
			}
			if ($this->ApiDbname == 'SchoolAccTajRiyadh' && $StudyTypeId == 1320) {
				$StudentR->IsExists = 0;
			}

			$class_id       = $query_class['ID'];
			$R_L_ID         = $query_level['ID'];
			if ($R_L_ID == '') {
				$R_L_ID = '0';
			}
			$where = 1;
			if ($this->ApiDbname == 'SchoolAccAndalos') {
				$where = "" . $StudentR->IsExists . "==1";
			}
		    if ($StudentR->YearName == $year_name && $where && $StudentR->IsActive === true  && ((in_array($LevelID,$level) && $studeType == $StudyTypeId) ||count($level) == 0) ) {

				$query1 = $this->db->query("select studentBasicID,Isactive,Number_ID,user_changed FROM contact where studentBasicID='" . $StudentR->StBasicId . "' ")->row_array();
				if ($query1['studentBasicID']) {
					if (empty($StudentR->StIdNumber)) {
						$query_ID = $this->db->query("select max(ID) as conId FROM contact  ")->row_array();
						$User_Name = $query_ID['conId']+1;
					} else {
						$User_Name = $StudentR->StIdNumber;
					}
					$where_student = "";
					if($query1['user_changed']!=1 && $user_changed==1) {
						$where_student = " User_Name         = '" . $User_Name . "' ,
				                      Password          = '" . md5('qwwtertyrtuytyuiyuouippisdggdfghfjghkjhkjljh7455221456322872598vxcvxcvxcfjkyfgkbtium.ljnuytudfyfdghstwres5576432.21325454542vc' . $User_Name) . "',";
					}

					
					// if ($this->ApiDbname == 'SchoolAccAlebdaa') {
					// 	$queryAgree = $this->db->query("select agree_condition FROM contact where ID_ACC='" . $StudentR->FaId . "' AND Type IN('F','E')  ")->row_array();
					// 	if($queryAgree['agree_condition']==0){
					// 		if($StudentR->IsExists == 0){
					// 			$erp_notactiveFather="erp_active = 0 ,";	
					// 		}else{
					// 		  	$erp_notactiveFather="erp_active = 1 ,";	  
					// 		}
					// 		$StudentR->IsExists = 0;
						
					// 		$ActiveFather="Isactive          = '".$StudentR->IsExists."',";
					// 	}else{
					// 	    $erp_notactiveFather="erp_active = '".$StudentR->IsExists."',";
					// 	    $ActiveFather="Isactive          = '".$StudentR->IsExists."',";
					// 	}
					// 	if($StudentR->IsExists ==0 && $queryAgree['agree_condition']==1){
					// 		$erp_notactiveFather="erp_active = 0 ,";	
					// 	}
						
					// }
					
				    $query4 = $this->db->query("select contact.ID,student.is_update FROM contact
					inner join student on contact.ID=student.Contact_ID
					where contact.studentBasicID=".$StudentR->StBasicId." ")->row_array() ;
			        if($query4['is_update']!='2'){
			            $whereISactive = "Isactive          = '" . $StudentR->IsExists . "',";
			        }
					$this->db->query("update  contact SET  
					$Name             = '" . $StName . "',
					$Name_en          = '" . $StNameEn . "',
					$where_student
					$erp_notactiveFather
					Gender            = '" . $StudentR->StGenderId . "' ,
					Number_ID         = '" . $StudentR->StIdNumber . "' ,
					Phone             = '" . $StudentR->FaMobile1 . "' ,
					Nationality_ID    = '" . $StudentR->StNationalityId . "' ,
					Longtude          = '" . $StudentR->StLongtude . "' ,
					Latitude          = '" . $StudentR->StLatitude . "' ,
					NameAtPassport    = '" . $NameAtPassport . "' ,
					NameEnAtPassport  = '" . $NameEnAtPassport . "' ,
					PassportNumber    = '" . $StudentR->PassportNumber . "' ,
					PassportReleaseDate = '" . $StudentR->PassportReleaseDate . "' ,
					PassportExpiryDate  = '" . $StudentR->PassportExpiryDate . "' ,
					SchoolID          = '" . $add_school_id_to . "' ,
					$whereISactive
					ID_ACC            = '" . $StudentR->FaId . "' ,
					GR_Number         = '" . $StudentR->Notes . "' ,
					RealEstateComID   = '" . $StudentR->StDetailsId . "',
					Birth_Place       = '" . $PlaceOfBirth . "' ,
					motherName        = '" . $StudentR->MotherNAme . "' ,
					motherMobile      = '" . $StudentR->MotherMobile . "' 
					where studentBasicID='" . $StudentR->StBasicId . "' and Type='S' ");
					$UP_Data++;

					$query2 =  $this->db->query("select  student.Father_ID,fa.IDHr,fa.Number_ID,fa.user_changed,fa.Type FROM student
                            				 inner join contact on student.Contact_ID=contact.ID 
                            				 inner join contact as fa on student.Father_ID=fa.ID
                            				 where contact.studentBasicID='" . $StudentR->StBasicId . "' ")->row_array();
					if ($query2['IDHr']) {
						if($query2['Type']=='U'){
					        $adminType="";
					    }else{
					        $adminType=",Type = 'E' ";
					    }
						$this->db->query("update  contact SET  
		            ID_ACC           = '" . $StudentR->FaId . "' ,
		            Nationality_ID   = '" . $StudentR->NationalityId . "' ,
		            IDHr             = '" . $StudentR->EmpId . "' ,
                    typeHr           = '" . $StudentR->IsSchoolBelong . "'
					$adminType
		            where ID         = '" . $query2['Father_ID'] . "' ");
					$cheack  = $this->db->query("SELECT Contact_ID  FROM `employee` WHERE `Contact_ID` = '".$query2['Father_ID']."' ")->row_array();
            	    if(empty($cheack['Contact_ID'])){
            		     $this->db->query("insert into  employee set  Contact_ID = '".(int)$query2['Father_ID']."'");
            	    }
					} else {
						$where_father = "";
						if($query2['user_changed']!=1 && $user_changed==1) {
							$where_father = "   User_Name        = '" . $StudentR->FaIdNumber . "' ,
				                       Password         = '" . md5('qwwtertyrtuytyuiyuouippisdggdfghfjghkjhkjljh7455221456322872598vxcvxcvxcfjkyfgkbtium.ljnuytudfyfdghstwres5576432.21325454542vc' . $StudentR->FaIdNumber) . "', ";
						}
						$this->db->query("update  contact SET  
		            $Name            = '" . $FaName . "' ,
		            $Name_en         = '" . $FaNameEn . "' ,
		            $where_father
					$ActiveFather
					$erp_notactiveFather
		            ID_ACC           = '" . $StudentR->FaId . "' ,
		            Number_ID        = '" . $StudentR->FaIdNumber . "' ,
		            Phone            = '" . $StudentR->FaMobile1 . "' ,
		            Nationality_ID   = '" . $StudentR->NationalityId . "' ,
		            Longtude          = '" . $StudentR->StLongtude . "' ,
    		        Latitude          = '" . $StudentR->StLatitude . "' ,
    		        NameAtPassport    = '" . $NameAtPassport . "' ,
    		        NameEnAtPassport  = '" . $NameEnAtPassport . "' ,
    		        PassportNumber    = '" . $StudentR->PassportNumber . "' ,
    		        PassportReleaseDate = '" . $StudentR->PassportReleaseDate . "' ,
    		        PassportExpiryDate  = '" . $StudentR->PassportExpiryDate . "' ,
		            IDHr             = '" . $StudentR->EmpId . "' ,
                    typeHr           = '" . $StudentR->IsSchoolBelong . "' 
		            where ID         = '" . $query2['Father_ID'] . "' ");
					}
					$query_s_language =  $this->db->query("select  s_language FROM student inner join contact on student.Contact_ID=contact.ID   where contact.studentBasicID='" . $StudentR->StBasicId . "' ")->row_array();
					$stu_sec = $query_s_language['s_language'];
					$array1 = explode(',', $stu_sec);
					if ($SecondLangauge) {
						$query_sub = $this->db->query("SELECT ID FROM subject WHERE Name_en ='$SecondLangauge' ")->row_array();
						$sec_lang = $query_sub['ID'];
					}
					if ($religion) {
						$query_religion = $this->db->query("SELECT ID FROM subject WHERE Name_en ='$religion' ")->row_array();
						$religion_id = $query_religion['ID'];
					}
					if ($sec_lang && $religion_id) {
						$s_language = $religion_id . ',' . $sec_lang;
					} elseif ($sec_lang) {
						$s_language = $sec_lang;
					} elseif ($religion_id) {
						$s_language = $religion_id;
					} else {
						$s_language = "";
					}
					$array2 = explode(',', $s_language);
					if ($array1[0] && $array2[0]) {
						$x = array_unique(array_merge($array1, $array2), SORT_REGULAR);
						$stu_sec_lang = implode(',', $x);
					} elseif ($array1[0] != "") {
						$stu_sec_lang = $query_s_language['s_language'];
					} elseif ($array2[0] != "") {
						$stu_sec_lang = $s_language;
					} else {
						$stu_sec_lang = "";
					}

					$query4 = $this->db->query("select contact.ID,student.is_update FROM contact
					inner join student on contact.ID=student.Contact_ID
					where contact.studentBasicID='".$StudentR->StBasicId."' ")->row_array() ;
			        if($query4['is_update']!=1){
					$this->db->query("UPDATE student 
                                      SET  
                                	  R_L_ID         = '" . $R_L_ID . "' ,
                                	  Class_ID       = '" . $class_id . "',
                                	  StudyTypeID    = '" . $StudyTypeId . "',
                                	  Birth_Date     = '" . $DateOfBirth . "',
                                	  Register_Date  = '" . $RegistrationDate . "',
                                	  previous_school= '" . $LastSchool . "',
                                	  s_language     = '" . $stu_sec_lang . "'
									  where Contact_ID  = '" . $query4['ID'] . "' ");
			        }


				// 			print_r($this->db->last_query());die;		  
									  
				} else {
					// if ($this->ApiDbname == 'SchoolAccAlebdaa' ) {
					// 	if($StudentR->IsExists == 0){
					// 		$erp_notactiveFather="erp_active = 0 ,";	
					// 	}
			        // 	$StudentR->IsExists = 0;
					// 	$ActiveFather="Isactive          = '" . $StudentR->IsExists . "',";
		         	// }
					$FaIdNumber =  $StudentR->FaIdNumber;
					$EmpId      =  $StudentR->EmpId;
					$FaId       =  $StudentR->FaId;
					if ($EmpId) {
						$query = $this->db->query("SELECT ID ,Type FROM contact WHERE IDHr =$EmpId ")->result();
					} elseif ($FaId) {
						$query = $this->db->query("SELECT ID ,Type FROM contact WHERE ID_ACC =$FaId ")->result();
					}
					if (!sizeof($query) > 0) {

						$this->db->query("INSERT INTO  contact SET  
						                  $erp_notactiveFather
										  $ActiveFather
                                		User_Name      = '" . $StudentR->FaIdNumber . "' ,
                                	    $Name          = '" . $FaName . "' ,
		                                 $Name_en      = '" . $FaNameEn . "' ,
                                		ID_ACC         = '" . $StudentR->FaId . "' ,
                                		Number_ID      = '" . $StudentR->FaIdNumber . "' ,
                                		Phone          = '" . $StudentR->FaMobile1 . "' ,
                                		Nationality_ID = '" . $StudentR->NationalityId . "' ,
                                		Longtude       = '" . $StudentR->StLongtude . "' ,
                        		        Latitude       = '" . $StudentR->StLatitude . "' ,
                        		        NameAtPassport = '" . $NameAtPassport. "' ,
                        		        NameEnAtPassport  = '" . $NameEnAtPassport . "' ,
                        		        PassportNumber    = '" . $StudentR->PassportNumber . "' ,
                        		        PassportReleaseDate = '" . $StudentR->PassportReleaseDate . "' ,
                        		        PassportExpiryDate  = '" . $StudentR->PassportExpiryDate . "' ,
                                		IDHr              = '" . $StudentR->EmpId . "' ,
                                        typeHr            = '" . $StudentR->IsSchoolBelong . "' ,
                                		SchoolID          = '" . $add_school_id_to . "' , 
                                		Type           = 'F'   ");
						$IN_Data++;
						$fa_contact_id = $this->db->insert_id();

						$this->db->query("INSERT INTO  father SET  Contact_ID = '" . $fa_contact_id . "' ");


						
						$this->db->query("update  contact SET  
                        				 Token = '" . md5('qwwtertyrtuytyuiyuouippisdggdfghfjghkjhkjljh7455221456322872598vxcvxcvxcfjkyfgkbtium.ljnuytudfyfdghstwres5576432.21325454542vc22' . $fa_contact_id) . "',
                        				 Password = '" . md5('qwwtertyrtuytyuiyuouippisdggdfghfjghkjhkjljh7455221456322872598vxcvxcvxcfjkyfgkbtium.ljnuytudfyfdghstwres5576432.21325454542vc' . $StudentR->FaIdNumber) . "'
                        				 where 
                        				 ID = '" . $fa_contact_id . "' ");
					} else {
						$fa_contact_id = $query[0]->{'ID'};
						$this->db->query("update  contact SET  
                                   ID_ACC         = '" . $StudentR->FaId . "' ,
                                   IDHr           = '" . $StudentR->EmpId . "' ,
                                   typeHr         = '" . $StudentR->IsSchoolBelong . "' 
                				   where  ID = '" . $fa_contact_id . "'
                				   ");
					}
					// if ($this->ApiDbname == 'SchoolAccAlebdaa') {
					// 		$this->db->query("update contact set Isactive = 0 where ID = '" . $fa_contact_id . "' AND agree_condition = 0 ");
					// 	}
					if (empty($StudentR->StIdNumber)) {
						$User_Name = $StudentR->StName;
					} else {
						$User_Name = $StudentR->StIdNumber;
					}
					$this->db->query("INSERT INTO  contact SET 
					         $erp_notactiveFather
                		        Gender           = '" . $StudentR->StGenderId . "' ,
                        		User_Name        = '" . $User_Name . "' ,
                        		 $Name           = '" . $StName . "',
				                $Name_en         = '" . $StNameEn . "',
                        		studentBasicID   = '" . $StudentR->StBasicId . "' ,
                        		RealEstateComID  = '" . $StudentR->StDetailsId . "',
                        		Number_ID        = '" . $StudentR->StIdNumber . "' ,
                        		Phone            = '" . $StudentR->FaMobile1 . "' ,
                        		Nationality_ID   = '" . $StudentR->StNationalityId . "' ,
                        		Longtude         = '" . $StudentR->StLongtude . "' ,
                		        Latitude         = '" . $StudentR->StLatitude . "' ,
                		        NameAtPassport   = '" . $NameAtPassport . "' ,
                		        NameEnAtPassport = '" . $NameEnAtPassport . "' ,
                		        PassportNumber   = '" . $StudentR->PassportNumber . "' ,
                		        PassportReleaseDate = '" . $StudentR->PassportReleaseDate . "' ,
                		        PassportExpiryDate  = '" . $StudentR->PassportExpiryDate . "' ,
                        		ID_ACC           = '" . $StudentR->FaId . "' ,
                        		Isactive         = '" . $StudentR->IsExists . "',
                        		SchoolID         = '" . $add_school_id_to . "' ,
                        		GR_Number        ='" . $StudentR->Notes . "' ,
                        		Birth_Place      = '" . $PlaceOfBirth . "' ,
								motherName       = '" . $StudentR->MotherNAme . "' ,
				                motherMobile     = '" . $StudentR->MotherMobile . "' ,
                        		Type             = 'S' ");
					$contact_id = $this->db->insert_id();

					$token    = md5('qwwtertyrtuytyuiyuouippisdggdfghfjghkjhkjljh7455221456322872598vxcvxcvxcfjkyfgkbtium.ljnuytudfyfdghstwres5576432.21325454542vc22' . $contact_id);
					$password = md5('qwwtertyrtuytyuiyuouippisdggdfghfjghkjhkjljh7455221456322872598vxcvxcvxcfjkyfgkbtium.ljnuytudfyfdghstwres5576432.21325454542vc' . $User_Name);

					$this->db->query("update  contact SET  
                				 Token     = '" . $token . "',
                				 Password  = '" . $password . "'
                				 where ID = '" . $contact_id . "' ");


					if ($SecondLangauge) {
						$query_sub = $this->db->query("SELECT ID FROM subject WHERE Name_en ='$SecondLangauge' ")->row_array();

						$sec_lang = $query_sub['ID'];
					}
					if ($religion) {

						$query_religion = $this->db->query("SELECT ID FROM subject WHERE Name_en ='$religion' ")->row_array();

						$religion_id = $query_religion['ID'];
					}
					if ($sec_lang && $religion_id) {

						$s_language = $religion_id . ',' . $sec_lang;
					} elseif ($sec_lang) {

						$s_language = $sec_lang;
					} elseif ($religion_id) {

						$s_language = $religion_id;
					} else {

						$s_language = "";
					}


					$this->db->query("INSERT INTO  student 
                             SET  
                    	     Contact_ID      = '" . $contact_id . "' ,
                    	     Class_ID        = '" . $class_id . "' ,
                    	     R_L_ID          = '" . $R_L_ID . "' ,
                    	     Father_ID       = '" . $fa_contact_id . "',
                    	     StudyTypeID     = '" . $StudyTypeId . "',
                    	     Birth_Date      = '" . $DateOfBirth . "',
                             Register_Date   = '" . $RegistrationDate . "',
                             previous_school = '" . $LastSchool . "',
                    	     s_language      = '" . $s_language . "'	");

					$st_contact_id = $this->db->insert_id();

					$this->db->query("update  student SET  
				 Token = '" . md5('qwwtertyrtuytyuiyuouippisdggdfghfjghkjhkjljh7455221456322872598vxcvxcvxcfjkyfgkbtium.ljnuytudfyfdghstwres5576432.21325454542vc22' . $st_contact_id) . "'
			 	 where ID = '" . $st_contact_id . "'");
				}
			}
		
	}
}
// 	public function add_from_report_need_update_api()
// 	{
// 		$get_schools         = json_decode(file_get_contents(lang('api_link')."/api/Schools/" . $this->ApiDbname . "/GetAllSchools"));
// 		$schoolId            = $get_schools[0]->SchoolId;
// 		$GetYear             = json_decode(file_get_contents(lang('api_link')."/api/Years/" . $this->ApiDbname . "/GetOpenedYearsBySchoolId?schoolId=$schoolId"));
// 		$add_school_id_to    = $this->input->post('school_id_to');
// 		$add_school_id_from  = $this->input->post('school_id_from');
// 		$years               = explode("/", $this->input->post('GetYear'));
// 		$year_name           = $years[0];
// 		$year_ID             = $years[1];
// 		$type                = $this->input->post('type');

// 		if ($this->ApiDbname == 'SchoolAccShorouqAlmamlakah' || $this->ApiDbname == 'SchoolAccRemas' ||  $this->ApiDbname == 'SchoolAccAtlas') {
// 			$Name_en = Name;
// 			$Name    = Name_en;
// 		} else {
// 			$Name_en = Name_en;
// 			$Name    = Name;
// 		}
// 		$contacts = array();
// 		$json = file_get_contents(lang('api_link')."/api/Students/" . $this->ApiDbname . "/GetAllStudentData?schoolId=$add_school_id_from&genderId=$type&yearId=$year_ID");
// 		$all_students =  json_decode($json);
// 		$x = 0;
// 		$UP_Data = 0;
// 		$IN_Data = 0;
// 		foreach ($all_students as $Key => $StudentR) {
// 			$LevelName        = $StudentR->LevelName;
// 			$RowName          = $StudentR->RowName;
// 			$ClassName        = $StudentR->ClassName;
// 			$StudyTypeId      = $StudentR->StudyTypeId;
// 			$religion         = $StudentR->religion;
// 			$LevelID          = $StudentR->LevelID;
// 			$RowID            = $StudentR->RowID;
// 			$ClassId          = $StudentR->ClassId;
// 			$SecondLangauge   = $StudentR->SecondLangauge;
// 			$LastSchool       = $StudentR->LastSchool;
// 			$DateOfBirth      = $StudentR->DateOfBirth;
// 			$PlaceOfBirth     = $StudentR->PlaceOfBirth;
// 			$RegistrationDate = $StudentR->RegistrationDate;
// 			$RegistrationDate = date('Y-m-d', strtotime($RegistrationDate));
// 			$StLongtude       = $StudentR->StLongtude;
// 			$StLatitude       = $StudentR->StLatitude;
// 			$NameAtPassport   = $StudentR->NameAtPassport;
// 			$NameEnAtPassport = $StudentR->NameEnAtPassport;
// 			$PassportNumber   = $StudentR->PassportNumber;
// 			$PassportReleaseDate = $StudentR->PassportReleaseDate;
// 			$PassportExpiryDate  = $StudentR->PassportExpiryDate;
// 			$StName           = filter_var($StudentR->StName, FILTER_SANITIZE_STRING);
// 			$StNameEn         = filter_var($StudentR->StNameEn, FILTER_SANITIZE_STRING);
// 			$FaName           = filter_var($StudentR->FaName, FILTER_SANITIZE_STRING);
// 			$FaNameEn         = filter_var($StudentR->FaNameEn, FILTER_SANITIZE_STRING);
// 			$query_level      = $this->db->query("SELECT ID,Level_ID FROM row_level WHERE Level_Name ='$LevelName'   and Row_Name='$RowName'  ")->row_array();
// 			$query_class      = $this->db->query("SELECT ID FROM class WHERE 1 and FIND_IN_SET($ClassId, ID_ERP)")->row_array();
// 			if ($this->ApiDbname == 'SchoolAccAsrAlMawaheb') {
// 				$StNameEn = $StName;
// 			}
// 			if ($this->ApiDbname == 'SchoolAccGheras' || $this->ApiDbname == 'SchoolAccTabuk') {
// 				$query_level    = $this->db->query("SELECT ID,Level_ID FROM row_level WHERE level_erp =$LevelID   and row_erp=$RowID AND StudyTypeID=$StudyTypeId ")->row_array();
// 			}

// 			if ($this->ApiDbname == 'SchoolAccAlebdaa' && $LevelID == 58 && $StudentR->StGenderId == 1) {
// 				$query_level    = $this->db->query("SELECT ID,Level_ID FROM row_level WHERE Level_ID = 2   and row_erp=$RowID AND StudyTypeID=$StudyTypeId ")->row_array();
// 			} elseif ($this->ApiDbname == 'SchoolAccAlebdaa' && $LevelID == 58 && $StudentR->StGenderId == 2) {
// 				$query_level    = $this->db->query("SELECT ID,Level_ID FROM row_level WHERE Level_ID = 5   and row_erp=$RowID AND StudyTypeID=$StudyTypeId ")->row_array();
// 			}
// 			if ($this->ApiDbname == 'SchoolAccTabuk') {

// 				if ($query_level['Level_ID'] == 1) {

// 					$add_school_id_to = 3;
// 				} else {

// 					if ($StudentR->StGenderId == 1) {

// 						$add_school_id_to = 1;
// 					} elseif ($StudentR->StGenderId == 2) {

// 						$add_school_id_to = 2;
// 					}
// 				}
// 			}
// 			if ($this->ApiDbname == 'SchoolAccTajRiyadh' && $StudyTypeId == 1320) {
// 				$StudentR->IsExists = 0;
// 			}

// 			$class_id       = $query_class['ID'];
// 			$R_L_ID         = $query_level['ID'];
// 			if ($R_L_ID == '') {
// 				$R_L_ID = '0';
// 			}
// 			$where = 1;
// 			if ($this->ApiDbname == 'SchoolAccAndalos') {
// 				$where = "" . $StudentR->IsExists . "==1";
// 			}
// 			if ($StudentR->YearName == $year_name && $where && $StudentR->IsActive === true) {

// 				$query1 = $this->db->query("select studentBasicID,Isactive FROM contact where studentBasicID='" . $StudentR->StBasicId . "' ")->result();
// 				if (sizeof($query1) > 0) {
// 					if (empty($StudentR->StIdNumber)) {
// 						$User_Name = $StName;
// 					} else {
// 						$User_Name = $StudentR->StIdNumber;
// 					}
// 					$where_student = "";
// 					if ($this->ApiDbname == 'SchoolAccTabuk') {
// 						$where_student = " User_Name         = '" . $User_Name . "' ,
// 				                      Password          = '" . md5('qwwtertyrtuytyuiyuouippisdggdfghfjghkjhkjljh7455221456322872598vxcvxcvxcfjkyfgkbtium.ljnuytudfyfdghstwres5576432.21325454542vc' . $User_Name) . "',";
// 					}
// 					$queryAgree = $this->db->query("select agree_condition FROM contact where ID_ACC='" . $StudentR->FaId . "' AND Type='F' ")->result();
// 					if ($this->ApiDbname == 'SchoolAccAlebdaa' && sizeof($queryAgree) > 0) {
// 						$StudentR->IsExists = 0;
// 					}
// 					$this->db->query("update  contact SET  
// 					$Name             = '" . $StName . "',
// 					$Name_en          = '" . $StNameEn . "',
// 					$where_student
// 					Gender            = '" . $StudentR->StGenderId . "' ,
// 					Number_ID         = '" . $StudentR->StIdNumber . "' ,
// 					Phone             = '" . $StudentR->FaMobile1 . "' ,
// 					Nationality_ID    = '" . $StudentR->NationalityId . "' ,
// 					Longtude          = '" . $StudentR->StLongtude . "' ,
// 					Latitude          = '" . $StudentR->StLatitude . "' ,
// 					NameAtPassport    = '" . $StudentR->NameAtPassport . "' ,
// 					NameEnAtPassport  = '" . $StudentR->NameEnAtPassport . "' ,
// 					PassportNumber    = '" . $StudentR->PassportNumber . "' ,
// 					PassportReleaseDate = '" . $StudentR->PassportReleaseDate . "' ,
// 					PassportExpiryDate  = '" . $StudentR->PassportExpiryDate . "' ,
// 					SchoolID          = '" . $add_school_id_to . "' ,
// 					Isactive          = '" . $StudentR->IsExists . "',
// 					ID_ACC            = '" . $StudentR->FaId . "' ,
// 					GR_Number         = '" . $StudentR->Notes . "' ,
// 					RealEstateComID   = '" . $StudentR->StDetailsId . "',
// 					Birth_Place       = '" . $PlaceOfBirth . "' ,
// 					motherName        = '" . $StudentR->MotherNAme . "' ,
// 					motherMobile      = '" . $StudentR->MotherMobile . "' 
// 					where studentBasicID='" . $StudentR->StBasicId . "' and Type='S' ");
// 					$UP_Data++;

// 					$query2 =  $this->db->query("select  student.Father_ID,fa.IDHr FROM student
//                             				 inner join contact on student.Contact_ID=contact.ID 
//                             				 inner join contact as fa on student.Father_ID=fa.ID
//                             				 where contact.studentBasicID='" . $StudentR->StBasicId . "' ")->row_array();
// 					if ($query2['IDHr']) {
// 						$this->db->query("update  contact SET  
// 		            ID_ACC           = '" . $StudentR->FaId . "' ,
// 		            Nationality_ID   = '" . $StudentR->NationalityId . "' ,
// 		            IDHr             = '" . $StudentR->EmpId . "' ,
//                     typeHr           = '" . $StudentR->IsSchoolBelong . "' 
// 		            where ID         = '" . $query2['Father_ID'] . "' ");
// 					} else {
// 						$where_father = "";
// 						if ($this->ApiDbname == 'SchoolAccTabuk') {
// 							$where_father = "   User_Name        = '" . $StudentR->FaIdNumber . "' ,
// 				                       Password         = '" . md5('qwwtertyrtuytyuiyuouippisdggdfghfjghkjhkjljh7455221456322872598vxcvxcvxcfjkyfgkbtium.ljnuytudfyfdghstwres5576432.21325454542vc' . $StudentR->FaIdNumber) . "', ";
// 						}
// 						$this->db->query("update  contact SET  
// 		            $Name            = '" . $FaName . "' ,
// 		            $Name_en         = '" . $FaNameEn . "' ,
// 		            $where_father
// 		            ID_ACC           = '" . $StudentR->FaId . "' ,
// 		            Number_ID        = '" . $StudentR->FaIdNumber . "' ,
// 		            Phone            = '" . $StudentR->FaMobile1 . "' ,
// 		            Nationality_ID   = '" . $StudentR->NationalityId . "' ,
// 		            Longtude          = '" . $StudentR->StLongtude . "' ,
//     		        Latitude          = '" . $StudentR->StLatitude . "' ,
//     		        NameAtPassport    = '" . $StudentR->NameAtPassport . "' ,
//     		        NameEnAtPassport  = '" . $StudentR->NameEnAtPassport . "' ,
//     		        PassportNumber    = '" . $StudentR->PassportNumber . "' ,
//     		        PassportReleaseDate = '" . $StudentR->PassportReleaseDate . "' ,
//     		        PassportExpiryDate  = '" . $StudentR->PassportExpiryDate . "' ,
// 		            IDHr             = '" . $StudentR->EmpId . "' ,
//                     typeHr           = '" . $StudentR->IsSchoolBelong . "' 
// 		            where ID         = '" . $query2['Father_ID'] . "' ");
// 					}
// 					$query_s_language =  $this->db->query("select  s_language FROM student inner join contact on student.Contact_ID=contact.ID   where contact.studentBasicID='" . $StudentR->StBasicId . "' ")->row_array();
// 					$stu_sec = $query_s_language['s_language'];
// 					$array1 = explode(',', $stu_sec);
// 					if ($sec_lang) {
// 						$query_sub = $this->db->query("SELECT ID FROM subject WHERE Name_en ='$SecondLangauge' ")->row_array();
// 						$sec_lang = $query_sub['ID'];
// 					}
// 					if ($religion) {
// 						$query_religion = $this->db->query("SELECT ID FROM subject WHERE Name_en ='$religion' ")->row_array();
// 						$religion_id = $query_religion['ID'];
// 					}
// 					if ($sec_lang && $religion_id) {
// 						$s_language = $religion_id . ',' . $sec_lang;
// 					} elseif ($sec_lang) {
// 						$s_language = $sec_lang;
// 					} elseif ($religion_id) {
// 						$s_language = $religion_id;
// 					} else {
// 						$s_language = "";
// 					}
// 					$array2 = explode(',', $s_language);
// 					if ($array1[0] && $array2[0]) {
// 						$x = array_unique(array_merge($array1, $array2), SORT_REGULAR);
// 						$stu_sec_lang = implode(',', $x);
// 					} elseif ($array1[0] != "") {
// 						$stu_sec_lang = $query_s_language['s_language'];
// 					} elseif ($array2[0] != "") {
// 						$stu_sec_lang = $s_language;
// 					} else {
// 						$stu_sec_lang = "";
// 					}
// $query4 = $this->db->query("select ID FROM contact where studentBasicID='".$StudentR->StBasicId."' ")->row_array() ;
					
// 					$this->db->query("UPDATE student 
//                                       SET  
//                                 	  R_L_ID         = '" . $R_L_ID . "' ,
//                                 	  Class_ID       = '" . $class_id . "',
//                                 	  StudyTypeID    = '" . $StudyTypeId . "',
//                                 	  Birth_Date     = '" . $DateOfBirth . "',
//                                 	  Register_Date  = '" . $RegistrationDate . "',
//                                 	  previous_school= '" . $LastSchool . "',
//                                 	  s_language     = '" . $stu_sec_lang . "'
// 									  where Contact_ID  = '" . $query4['ID'] . "' ");


							  
									  
// 				} else {
// 					if ($this->ApiDbname == 'SchoolAccAlebdaa' ) {
// 			        	$StudentR->IsExists = 0;
// 		         	}
// 					$FaIdNumber =  $StudentR->FaIdNumber;
// 					$EmpId      =  $StudentR->EmpId;
// 					$FaId       =  $StudentR->FaId;
// 					if ($EmpId) {
// 						$query = $this->db->query("SELECT ID ,Type FROM contact WHERE IDHr =$EmpId ")->result();
// 					} elseif ($FaId) {
// 						$query = $this->db->query("SELECT ID ,Type FROM contact WHERE ID_ACC =$FaId ")->result();
// 					}
// 					if (!sizeof($query) > 0) {

// 						$this->db->query("INSERT INTO  contact SET  
//                                 		User_Name      = '" . $StudentR->FaIdNumber . "' ,
//                                 	    $Name          = '" . $FaName . "' ,
// 		                                 $Name_en      = '" . $FaNameEn . "' ,
//                                 		ID_ACC         = '" . $StudentR->FaId . "' ,
//                                 		Number_ID      = '" . $StudentR->FaIdNumber . "' ,
//                                 		Phone          = '" . $StudentR->FaMobile1 . "' ,
//                                 		Nationality_ID = '" . $StudentR->NationalityId . "' ,
//                                 		Longtude       = '" . $StudentR->StLongtude . "' ,
//                         		        Latitude       = '" . $StudentR->StLatitude . "' ,
//                         		        NameAtPassport = '" . $StudentR->NameAtPassport . "' ,
//                         		        NameEnAtPassport  = '" . $StudentR->NameEnAtPassport . "' ,
//                         		        PassportNumber    = '" . $StudentR->PassportNumber . "' ,
//                         		        PassportReleaseDate = '" . $StudentR->PassportReleaseDate . "' ,
//                         		        PassportExpiryDate  = '" . $StudentR->PassportExpiryDate . "' ,
//                                 		IDHr              = '" . $StudentR->EmpId . "' ,
//                                         typeHr            = '" . $StudentR->IsSchoolBelong . "' ,
//                                 		SchoolID          = '" . $add_school_id_to . "' , 
//                                 		Type           = 'F'   ");
// 						$IN_Data++;
// 						$fa_contact_id = $this->db->insert_id();

// 						$this->db->query("INSERT INTO  father SET  Contact_ID = '" . $fa_contact_id . "' ");


						
// 						$this->db->query("update  contact SET  
//                         				 Token = '" . md5('qwwtertyrtuytyuiyuouippisdggdfghfjghkjhkjljh7455221456322872598vxcvxcvxcfjkyfgkbtium.ljnuytudfyfdghstwres5576432.21325454542vc22' . $fa_contact_id) . "',
//                         				 Password = '" . md5('qwwtertyrtuytyuiyuouippisdggdfghfjghkjhkjljh7455221456322872598vxcvxcvxcfjkyfgkbtium.ljnuytudfyfdghstwres5576432.21325454542vc' . $StudentR->FaIdNumber) . "'
//                         				 where 
//                         				 ID = '" . $fa_contact_id . "' ");
// 					} else {
// 						$fa_contact_id = $query[0]->{'ID'};
// 						$this->db->query("update  contact SET  
//                                   ID_ACC         = '" . $StudentR->FaId . "' ,
//                                   IDHr           = '" . $StudentR->EmpId . "' ,
//                                   typeHr         = '" . $StudentR->IsSchoolBelong . "' 
//                 				   where  ID = '" . $fa_contact_id . "'
//                 				   ");
// 					}
// 					if ($this->ApiDbname == 'SchoolAccAlebdaa') {
// 							$this->db->query("update contact set Isactive = 0 where ID = '" . $fa_contact_id . "' AND agree_condition = 0 ");
// 						}
// 					if (empty($StudentR->StIdNumber)) {
// 						$User_Name = $StudentR->StName;
// 					} else {
// 						$User_Name = $StudentR->StIdNumber;
// 					}
// 					$this->db->query("INSERT INTO  contact SET 
//                 		        Gender           = '" . $StudentR->StGenderId . "' ,
//                         		User_Name        = '" . $User_Name . "' ,
//                         		 $Name           = '" . $StName . "',
// 				                $Name_en         = '" . $StNameEn . "',
//                         		studentBasicID   = '" . $StudentR->StBasicId . "' ,
//                         		RealEstateComID  = '" . $StudentR->StDetailsId . "',
//                         		Number_ID        = '" . $StudentR->StIdNumber . "' ,
//                         		Phone            = '" . $StudentR->FaMobile1 . "' ,
//                         		Nationality_ID   = '" . $StudentR->NationalityId . "' ,
//                         		Longtude         = '" . $StudentR->StLongtude . "' ,
//                 		        Latitude         = '" . $StudentR->StLatitude . "' ,
//                 		        NameAtPassport   = '" . $StudentR->NameAtPassport . "' ,
//                 		        NameEnAtPassport = '" . $StudentR->NameEnAtPassport . "' ,
//                 		        PassportNumber   = '" . $StudentR->PassportNumber . "' ,
//                 		        PassportReleaseDate = '" . $StudentR->PassportReleaseDate . "' ,
//                 		        PassportExpiryDate  = '" . $StudentR->PassportExpiryDate . "' ,
//                         		ID_ACC           = '" . $StudentR->FaId . "' ,
//                         		Isactive         = '" . $StudentR->IsExists . "',
//                         		SchoolID         = '" . $add_school_id_to . "' ,
//                         		GR_Number        ='" . $StudentR->Notes . "' ,
//                         		Birth_Place      = '" . $PlaceOfBirth . "' ,
// 								motherName       = '" . $StudentR->MotherNAme . "' ,
// 				                motherMobile     = '" . $StudentR->MotherMobile . "' ,
//                         		Type             = 'S' ");
// 					$contact_id = $this->db->insert_id();

// 					$token    = md5('qwwtertyrtuytyuiyuouippisdggdfghfjghkjhkjljh7455221456322872598vxcvxcvxcfjkyfgkbtium.ljnuytudfyfdghstwres5576432.21325454542vc22' . $contact_id);
// 					$password = md5('qwwtertyrtuytyuiyuouippisdggdfghfjghkjhkjljh7455221456322872598vxcvxcvxcfjkyfgkbtium.ljnuytudfyfdghstwres5576432.21325454542vc' . $User_Name);

// 					$this->db->query("update  contact SET  
//                 				 Token     = '" . $token . "',
//                 				 Password  = '" . $password . "'
//                 				 where ID = '" . $contact_id . "' ");


// 					if ($sec_lang) {
// 						$query_sub = $this->db->query("SELECT ID FROM subject WHERE Name_en ='$SecondLangauge' ")->row_array();

// 						$sec_lang = $query_sub['ID'];
// 					}
// 					if ($religion) {

// 						$query_religion = $this->db->query("SELECT ID FROM subject WHERE Name_en ='$religion' ")->row_array();

// 						$religion_id = $query_religion['ID'];
// 					}
// 					if ($sec_lang && $religion_id) {

// 						$s_language = $religion_id . ',' . $sec_lang;
// 					} elseif ($sec_lang) {

// 						$s_language = $sec_lang;
// 					} elseif ($religion_id) {

// 						$s_language = $religion_id;
// 					} else {

// 						$s_language = "";
// 					}


// 					$this->db->query("INSERT INTO  student 
//                              SET  
//                     	     Contact_ID      = '" . $contact_id . "' ,
//                     	     Class_ID        = '" . $class_id . "' ,
//                     	     R_L_ID          = '" . $R_L_ID . "' ,
//                     	     Father_ID       = '" . $fa_contact_id . "',
//                     	     StudyTypeID     = '" . $StudyTypeId . "',
//                     	     Birth_Date      = '" . $DateOfBirth . "',
//                              Register_Date   = '" . $RegistrationDate . "',
//                              previous_school = '" . $LastSchool . "',
//                     	     s_language      = '" . $s_language . "'	");

// 					$st_contact_id = $this->db->insert_id();

// 					$this->db->query("update  student SET  
// 				 Token = '" . md5('qwwtertyrtuytyuiyuouippisdggdfghfjghkjhkjljh7455221456322872598vxcvxcvxcfjkyfgkbtium.ljnuytudfyfdghstwres5576432.21325454542vc22' . $st_contact_id) . "'
// 			 	 where ID = '" . $st_contact_id . "'");
// 				}
// 			}
// 		}
// 		redirect('admin/student_register/report_need_update_api/' . $add_school_id_to . "/" . $type . "/" . $UP_Data . "/" . $IN_Data);
// 	}

	public function report_need_register_api()
	{
		$this->data['school_id_to']    = $add_school_id_to            = $this->input->post('school_id_to');
		$this->data['school_id_from']  = $add_school_id_from          = $this->input->post('school_id_from');
		$this->data['type']            = $type                        = $this->input->post('type');
		$this->data['year_name']       = $year_name                   = $this->input->post('GetYear');
		$years                         = explode("/", $this->input->post('GetYear'));
		$this->data['year_name']       = $year_name           = $years[0];
		$this->data['yearID']          = $yearID              = $years[1];
		$this->data['GetYear']         = json_decode(file_get_contents(lang('api_link')."/api/Years/" . $this->ApiDbname . "/GetOpenedYearsBySchoolId?schoolId=$add_school_id_from"));
		if (isset($_POST['school_id_from'])) {
			$contacts = $this->db->query('select contact.Number_ID,contact.Name,contact.studentBasicID  from   contact ')->result_array();
			$this->data['contacts'] = $contacts;
			$json = file_get_contents(lang('api_link')."/api/Students/" . $this->ApiDbname . "/GetAllStudentData?schoolId=$add_school_id_from&genderId=$type&yearId=$yearID");
			$this->data['all_students'] = json_decode($json);
			//  print_r($this->data['all_students']);die;
		}
		$this->load->admin_template('report_need_register_api', $this->data);
	}
	/////////////////////////////
	public function report_need_update_api()
	{
		$this->data['ApiDbname']     = $this->ApiDbname;
		$this->data['school_id_to1'] = $this->uri->segment(4);
		$this->data['type1']         = $this->uri->segment(5);
		$this->data['GetYear']       = json_decode(file_get_contents(lang('api_link')."/api/Years/" . $this->ApiDbname . "/GetOpenedYearsBySchoolId?schoolId=" . $_POST['school_id_from'] . ""));
		if (isset($_POST['school_id_from'])) {
			$contacts = $this->db->query('select contact.Number_ID  from   contact ')->result_array();
			$json = file_get_contents(lang('api_link')."/api/Students/" . $this->ApiDbname . "/GetAllStudentData?schoolId=" . $_POST['school_id_from'] . "&genderId=" . $_POST['school_id_from']); // this will require php.ini to be setup to allow 
			$this->data['message']         =  '  ';
			$this->data['type']            = $_POST['type'];
			$this->data['school_id_from']  = $_POST['school_id_from'];
			$this->data['school_id_to']    = $_POST['school_id_to'];
			$this->data['contacts']        = $contacts;
			$this->data['all_students']    = json_decode($json);
		}
		$this->load->admin_template('report_need_update_api', $this->data);
	}

	////report	
	public function report_register()
	{
		$rowlevel  = get_rowlevel_select_in();
		$this->data['Get_Year'] = $this->uri->segment(4);
		$get_schools  = json_decode(file_get_contents(lang('api_link')."/api/Schools/" . $this->ApiDbname . "/GetAllSchools"));
		$schoolId     = $get_schools[0]->SchoolId;
		$this->data['GetYear']       = json_decode(file_get_contents(lang('api_link')."/api/Years/" . $this->ApiDbname . "/GetOpenedYearsBySchoolId?schoolId=$schoolId"));
		$this->data['getLevel']     = $this->student_register_model->get_level_user_request($this->data['UID']);
		if ($this->data['Get_Year']) {
			$this->data['getStudentR']  = $this->student_register_model->get_student_register_report($rowlevel, $this->data['Get_Year']);
		} else {
		}
		$this->data['get_nationality']  = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllNationalities"));
		$this->data['getRowLevel']  = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllRowLevels"));
		$this->load->admin_template('Report_Student_Register_Form', $this->data);
	}
	public function report_counts()
	{
		$this->data['getStudentR']  = $this->student_register_model->get_all_student_report();
		// $this->data['get_nationality']  = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/".$this->ApiDbname."/GetAllNationalities"));
		$this->data['getRowLevel']  = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllRowLevels"));
		$this->load->admin_template('Report_Student_Register_counts', $this->data);
	}

	////view_student_register	
	public function view_student_register($ID = 0)
	{
		$this->data['id'] = $this->uri->segment(4);
		$this->data['year_id'] = $this->uri->segment(5);
		$this->student_register_model->add_student_register_accept($ID);
		$this->data['getStudentR']  = $this->student_register_model->get_student_register_by_id($ID);
		//print_r($this->data['getStudentR']);
		$this->data['reason'] = $this->student_register_model->getStudentReasons($ID);
		$this->data['get_identities']  = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllIdentityTypes"));
		$this->data['get_educations']  = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllGraduationStudies"));
		$this->data['get_schools']  = json_decode(file_get_contents(lang('api_link')."/api/Schools/" . $this->ApiDbname . "/GetAllSchools"));
		$this->data['studeType']  = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllStudyTypes"));
		$this->data['get_genders']  = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllGenders"));
		$this->data['get_nationality']  =  json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllNationalities"));
		$schoolid = $this->data['getStudentR']['schoolID'];
		$this->data['study_types']  = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetStudyTypesBySchool?schoolId=$schoolid"));
		$this->data['getRowLevel']  = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllRowLevels"));
		$this->data['getClasses']  = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetClassesBySchool?schoolId=$schoolid"));
		$this->data['getYear']  = json_decode(file_get_contents(lang('api_link')."/api/Years/" . $this->ApiDbname . "/GetOpenedYearsBySchoolId?schoolId=$schoolid"));
		$this->data['get_ClassTypeName']  = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllClassTypes"));
		$UserType = $this->session->userdata('type');

		if ($UserType == 'U') {
			$this->data['getPerEmp']             =  'U';
		} else {
			$this->data['getPerEmp']             = $this->student_register_model->check_user_accept_request($this->data['UID'], $this->data['Lang'], $ID);
			$this->data['all_accept_request']    = $this->student_register_model->check_all_accept_request($this->data['UID'], $this->data['Lang'], $ID);
			$this->data['all_accept_request2']    = $this->student_register_model->check_all_accept_request2($this->data['UID'], $this->data['Lang'], $ID);
			$this->data['get_permission_request'] = $this->student_register_model->get_permission_request($this->data['UID']);

			if ($get_permission_request['NameSpaceID'] == 85) {
				$auto_sms_accept = $this->student_register_model->get_auto_sms_accept(3);
				$this->data['auto_sms_accept'] = $auto_sms_accept['content'];
			}
			if ($get_permission_request['NameSpaceID'] == 11) {
				$auto_sms_accept = $this->student_register_model->get_auto_sms_accept(2);
				$this->data['auto_sms_accept'] = $auto_sms_accept['content'];
			} else {
				$auto_sms_accept = $this->student_register_model->get_auto_sms_accept(1);
				$this->data['auto_sms_accept'] = $auto_sms_accept['content'];
			}
		}
		$this->data['NameSpaceID']  = 0;
		if (sizeof($this->data['getPerEmp']) > 0) {
			$this->data['NameSpaceID']  = $this->data['getPerEmp']['NameSpaceID'];
		}
		$this->load->admin_template('Student_Register_Form_by_id', $this->data);
	}


	////accept_student_register	
	public function accept_student_register($ID = 0, $NameSpace = 0)
	{
		$Mobile              =  filter_var($this->input->post('parent_mobile'), FILTER_SANITIZE_STRING);
		$msg                     =  filter_var($this->input->post('txtSms'), FILTER_SANITIZE_STRING);
		if ($msg == null && $this->input->post('IsActive') == 1) {
			$msg = 'تم قبول الطالب';
		}
		if ($msg == null && $this->input->post('IsActive') == 2) {
			$msg = 'تم رفض الطالب';
		}
		$schooleSender = 'School';
		$Username =  'aboabdo1';
		$Password = '123456';
		$Mobile = $Mobile;
		$array  = array_map('intval', str_split($Mobile));
		if ($array[0] == 0) {
			$Mobile = ltrim($Mobile, '0');
		}
		if (substr($Mobile, 0, 3) == '966' || substr($Mobile, 0, 3) == '009') {
			$Mobile = substr($Mobile, 3);
		}
		$Mobile              = '966' . $Mobile;
		$Message             = $msg;

		if (strlen($Mobile) >= 9) {
			curl_setopt_array($ch = curl_init(), array(
				CURLOPT_URL => "http://www.csms.co/api/sendsms.php",
				CURLOPT_POSTFIELDS => array(
					"username" => $Username,
					"password" => $Password,
					"numbers" => $Mobile,
					"sender" => $schooleSender,
					"message" => $Message
				)
			));

			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; pl; rv:1.9) Gecko/2008052906 Firefox/3.0");
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
			$result = curl_exec($ch);
			curl_close($ch);
		}
		$this->data['CheckAccept']  = $this->student_register_model->check_accept_request($ID, $NameSpace, $this->data['UID']);
		// $this->data['CheckAccept']  = 1;

		if ($this->data['CheckAccept'] == 1) {

			$registration_data  = $this->student_register_model->get_student_register_by_id($ID);

			$Data['FullName'] = $registration_data['name'];
			$Data['SName']    = $registration_data['name'];
			$Data['FName']    = $registration_data['parent_name'];
			if ($NameSpace == 85) {
				$row_level = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllRowLevels"));
				foreach ($row_level as $row) {
					if (($row->RowLevelId == $registration_data['rowLevelID'])) {
						$row_levelDetails = $row;
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

				// Post father data to API
				$father_data = [
					"Name" => $registration_data['parent_name'],
					"HomePhone" => $registration_data['parent_phone'],
					"WorkPhone" => $registration_data['parent_phone2'],
					"Mobile1" => $registration_data['parent_mobile'],
					"Mobile2" => $registration_data['parent_mobile2'],
					"StreetName" => $registration_data['parent_access_station'],
					"HouseNumber" => $registration_data['parent_house_number'],
					"Nationality_ID" => intval($registration_data['parent_national_ID']),
					"Region" => $registration_data['parent_region'],
					"WorkPlace" => $registration_data['parent_work_address'],
					"Job" => $registration_data['parent_profession'],
					"Mail" => $registration_data['parent_email'],
					"GraduationStudy" => $registration_data['ar_education'],
					"IDType" => $registration_data['ar_identity'],
					"IDNumber" => $registration_data['ParentNumberID'],
					"IDSource" => $registration_data['ID_place'],
					"ResposibleName" => $registration_data['person_name'],
					"ResposiblePhone" => $registration_data['person_phone'],
					"IsSchoolBelong" => true,
					"EnName" => $registration_data['parent_name_eng'],
				];

				$father_result = $this->post_father_data($father_data);

				if (!$father_result->FatherID) {
					$this->session->set_flashdata('Failuer', lang('br_parent_error'));
					redirect('admin/student_register', 'refresh');
				}

				$student_data = [
					"FirstName" => $registration_data['name'],
					"GenderId" => intval($registration_data['gender']),
					"ClassTypeId" => intval($registration_data['ClassTypeId']),
					"DateOfBirth" => $registration_data['birthdate'],
					"Region" => $registration_data['student_region'],
					"Notes" => $registration_data['note'],
					"RegistrationDate" => $registration_data['Reg_Date'],
					"IDNumber" => $registration_data['studentnationalityID'],
					"LastSchool" => $registration_data['exSchool'],
					"PlaceOfBirth" => $registration_data['birthplace'],
					"Father_ID" => $father_result->FatherID,
					"StudyType" => intval($registration_data['studyType']),
					"EnName" => $registration_data['name_eng'],
					"MotherName" => $registration_data['mother_name'],
					"MotherJob" => $registration_data['mother_work'],
					"Year_ID" => intval($registration_data['YearId']),
					"Class_ID" => intval($classDetails->ClassId),
					"RowID" => intval($row_levelDetails->RowId),
					"LevelID" => intval($row_levelDetails->LevelId),
					"School_ID" => intval($registration_data['schoolID']),
					"MotherMobile" => $registration_data['mother_mobile'],
					"MotherName" => $registration_data['mothername'],
					"MotherEducationalQualification" => $registration_data['mothereducationalqualification'],
					"MotherWork" => $registration_data['motherwork'],
					"MotherWorkPhone" => $registration_data['motherworkphone'],
					"MotherEmail" => $registration_data['motheremail']
				];

				$student_result = $this->post_student_data($student_data);
				// print_r($student_result);die;
				if (!$student_result->StudentBasicDataID) {
					$this->session->set_flashdata('Failuer', $student_result->Message);
					redirect('admin/student_register', 'refresh');
				}
				$Data['FatherID']                     = $father_result->FatherID;
				$Data['StudentBasicDataID']           =  $student_result->StudentBasicDataID;
				$Data['Message']                      =  $student_result->Message;


				$this->student_register_model->accept_student_register($ID, $Data['StuConID']);
			}
		}
		// 				// insert data in lms
		// 				if($student_result->Message=="تم إضافة بيانات الطالب بنجاح")   { 
		// 				$query = $this->db->query("SELECT ID FROM contact WHERE Number_ID =".$registration_data['ParentNumberID']." ")->result() ; 
		// if(empty($query))
		// 		{  

		// //third step   add father 
		// 	$this->db->query("INSERT INTO  contact SET  
		// 		User_Name = '".$registration_data['ParentNumberID'] ."' ,
		// 		Name = '".$registration_data['parent_name'] ."' ,
		// 		ID_ACC = '".$father_result->FatherID."' ,
		// 		Number_ID = '".$registration_data['ParentNumberID'] ."' ,
		// 		Phone = '".$registration_data['parent_mobile'] ."' ,
		// 		Nationality_ID = '".$registration_data['parent_national_ID'] ."' ,
		// 		SchoolID = ".$registration_data['school_lms']." , 
		// 		Type = 'F'   

		// 		");
		// 			$fa_contact_id= $this->db->insert_id();
		//  $this->db->query("INSERT INTO  father SET  Contact_ID = '".$fa_contact_id ."' ");

		//                 $this->db->query("
		// 				update  contact
		// 				 SET  
		// 				 Token = '".md5( 'qwwtertyrtuytyuiyuouippisdggdfghfjghkjhkjljh7455221456322872598vxcvxcvxcfjkyfgkbtium.ljnuytudfyfdghstwres5576432.21325454542vc22'.$fa_contact_id)."',
		// 				 Password = '".md5( 'qwwtertyrtuytyuiyuouippisdggdfghfjghkjhkjljh7455221456322872598vxcvxcvxcfjkyfgkbtium.ljnuytudfyfdghstwres5576432.21325454542vc'. $registration_data['ParentNumberID'])."'
		// 				 where 
		// 				 ID = '".$fa_contact_id."'
		// 				   ") ;
		// }else{

		//     $fa_contact_id=$query[0]->{'ID'};
		// }
		// // insert student data 
		// //first step
		//       $StBasicId=  $student_result->StudentBasicDataID;
		// 	$query = $this->db->query("SELECT ID FROM contact WHERE studentBasicID ='$StBasicId'   ")->result() ;   

		// if(!sizeof($query)>0)
		// {
		//     if(empty($registration_data['student_NumberID']))  {
		//                   $User_Name= $registration_data['name'];
		//                 }
		//                 else{
		//                     $User_Name= $registration_data['student_NumberID']; 
		//                 }
		// 	$this->db->query("INSERT INTO  contact SET 
		// 		Gender = '".$registration_data['gender'] ."' ,
		// 		User_Name = '".$User_Name ."' ,
		// 		Name = '".$registration_data['name'] ."' ,
		// 		studentBasicID = '".$student_result->StudentBasicDataID ."' ,
		// 		Number_ID = '".$registration_data['student_NumberID'] ."' ,
		// 		Phone = '".$registration_data['mother_mobile'] ."' ,
		// 		Nationality_ID = '".$registration_data['parent_national_ID'] ."' ,
		// 		ID_ACC = '".$father_result->FatherID ."' ,
		// 		SchoolID = ".$registration_data['school_lms'].", 
		// 		Isactive=1,
		// 		Type = 'S' 

		// 		");
		// 	 		$contact_id= $this->db->insert_id();



		//  //second step


		//                 $token=md5('qwwtertyrtuytyuiyuouippisdggdfghfjghkjhkjljh7455221456322872598vxcvxcvxcfjkyfgkbtium.ljnuytudfyfdghstwres5576432.21325454542vc22'.$contact_id);
		//               $password=md5('qwwtertyrtuytyuiyuouippisdggdfghfjghkjhkjljh7455221456322872598vxcvxcvxcfjkyfgkbtium.ljnuytudfyfdghstwres5576432.21325454542vc'. $User_Name);

		//               $this->db->query("
		// 				update  contact
		// 				 SET  
		// 				 Token = '".$token."',
		// 				 Password = '".$password."'
		// 				 where 
		// 				 ID = '".$contact_id."'
		// 				   ") ;	

		//  //fifth step

		//                     $LevelId      = $row_levelDetails->LevelId ;
		//                     $RowName      = $row_levelDetails->RowName; 
		//                     $ClassName    = $classDetails->ClassName; 
		//                     $StudyTypeId  = $row_levelDetails->StudyTypeId;
		//                     $LevelName    = $row_levelDetails->LevelName ;



		//         	$query = $this->db->query("SELECT ID FROM row_level WHERE Level_Name ='$LevelName'   and Row_Name='$RowName'  ")->result() ;   

		// 			foreach($query as $Key=>$Result)
		// 			{$row_level_id=$Result->ID;	
		// 			}
		//         	$query = $this->db->query("SELECT ID FROM class WHERE Name ='$ClassName'   ")->result() ;   

		// 			foreach($query as $Key=>$Result)
		// 			{$class_id=$Result->ID;	
		// 			}

		// if($row_level_id==''){
		//     $row_level_id='0';
		// }
		// 		 /////////////                  
		//         $this->db->query("INSERT INTO  student SET  
		// 		Contact_ID = '".$contact_id ."' ,
		// 		Class_ID = '".$class_id ."' ,
		// 		R_L_ID = '".$row_level_id ."' ,
		// 		Father_ID = '".$fa_contact_id ."',
		// 		StudyTypeID = '".$StudyTypeId ."'


		// 		");    

		//   	$st_contact_id= $this->db->insert_id();



		//  //forth step

		//                 $this->db->query("
		// 				update  student
		// 				 SET  
		// 				 Token = '".md5( 'qwwtertyrtuytyuiyuouippisdggdfghfjghkjhkjljh7455221456322872598vxcvxcvxcfjkyfgkbtium.ljnuytudfyfdghstwres5576432.21325454542vc22'.$st_contact_id)."'
		// 			 	 where 
		// 				 ID = '".$st_contact_id."'
		// 				   ") ;


		//                       }
		// 				}
		$this->session->set_flashdata('SuccessAdd', lang('br_add_suc'));
		$this->index();
		//redirect('admin/student_register/view_student_register/'.$ID.'','refresh');


	}


	function Getasp()
	{

		$url = 'https://api-eduregdiwan.esol.dev/api/StudentRegister/CheckApiStatus';
		$curlHandle = curl_init($url);
		$headers = array(
			'Content-type: application/json'
		);
		curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, TRUE);
		$execResult = curl_exec($curlHandle);
		print_r($execResult);
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
			CURLOPT_URL => lang('api_link'). "/api/Fathers/" . $this->ApiDbname . "/AddFather",
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
			CURLOPT_URL => lang('api_link'). "/api/Students/" . $this->ApiDbname . "/AddStudent",
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

	private function dd($var)
	{
		echo '<pre>';
		var_dump($var);
		echo '</pre>';
		die;
	}
	public function register_form_date()
	{
		$this->data['reg_id'] = $this->uri->segment(4);
		$this->data['getdate']  = $this->student_register_model->register_formdate($this->data['reg_id']);
		$this->load->admin_template('register_form_date', $this->data);
	}
	public function add_register_date()
	{
		$this->data['reg_id'] = $this->uri->segment(4);
		$this->data['Date']         = $this->input->post('txt_Date');

		$this->data['Absence']         = $this->input->post('absence');

		$this->data['note']     = $this->input->post('note');


		if ($this->student_register_model->add_register_formdate($this->data)) {

			$this->session->set_flashdata('SuccessAdd', lang('br_add_suc'));
		} else {

			$this->session->set_flashdata('ErrorAdd', lang('br_add_error'));
		}
		redirect('admin/student_register/register_form_date/' . $this->data['reg_id'], 'refresh');
	}
	public function edit_register_date()
	{
		$this->data['reg_test_id']  = $this->input->post('iddd');
		$this->data['reg_id']       = $this->input->post('reg_idddd');
		$this->data['test_date']         = $this->input->post('test_date');
		$this->data['Absence']         = $this->input->post('absence_edit');
		$this->data['note']     = $this->input->post('note_edit');

		if ($this->student_register_model->edit_register_formdate($this->data)) {

			$this->session->set_flashdata('SuccessAdd', lang('br_add_suc'));
		} else {
		}
		redirect('admin/student_register/register_form_date/' . $this->data['reg_id'], 'refresh');
	}

	////////////////////////
	public function register_type()
	{
		$Data['record_id'] = $this->uri->segment(4);
		if ($Data['record_id']) {
			$Data['edit_Data'] = $this->student_register_model->edit_state($Data['record_id']);
		}
		$Data['typeData'] = $this->student_register_model->Get_state();
		$this->load->admin_template('viewReg_status_type.php', $Data);
	}
	public function delete_state()
	{
		$record_id = $this->uri->segment(4);
		$this->student_register_model->delete_state($record_id);
		redirect('/admin/Student_register/register_type', 'refresh');
	}
	public function save_state()
	{
		$data['record_id'] = $this->uri->segment(4);
		$data['Name']  = $this->input->Post('Name');
		$data['Name_en'] = $this->input->post('Name_en');
		if ($data['record_id']) {
			$this->student_register_model->update_state($data);
		} else {
			$this->student_register_model->save_state($data);
		}
		redirect('/admin/Student_register/register_type', 'refresh');
	}
	public function edit_state($record_id)
	{
		$data['record_id'] = $this->uri->segment(4);
		$data['record']    = $this->student_register_model->edit_state($record_id);


		redirect('/admin/Student_register/register_type', $data);
	}

	public function Get_service_res()
	{
		$Data['record'] = $this->student_register_model->Get_service_res();
		// $Data['Get_total'] = $this->student_register_model->Get_total();
		$this->load->admin_template('view_reg_emp.php', $Data);
	}
	/////////////////////////////////
	public function delete_register_date()
	{
		$reg_test_id  = $this->uri->segment(4);
		$reg_id  = $this->uri->segment(5);
		if ($this->student_register_model->delete_formdate($reg_test_id)) {

			$this->session->set_flashdata('SuccessAdd', lang('br_add_suc'));
		} else {
		}
		redirect('admin/student_register/register_form_date/' . $reg_id, 'refresh');
	}
	public function get_student_register()
	{
		$this->data['reg_id'] = $this->uri->segment(4);
		$Year_lms = $this->data['stu_data'] = $this->student_register_model->get_student_register_data($this->data['reg_id']);
		$ClassTypeId = $Year_lms[0]->ClassTypeId;
		$schoolID = $Year_lms[0]->schoolID;
		$studyType = $Year_lms[0]->studyType;
		$this->data['get_row_level'] = $this->student_register_model->get_row_level();
		$get_schools  = json_decode(file_get_contents(lang('api_link')."/api/Schools/" . $this->ApiDbname . "/GetAllSchools"));
		$schoolId     = $get_schools[0]->SchoolId;
		$this->data['getRowLevel']   = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllRowLevelsOfNewRegisteration?schoolId=$schoolID&studyTypeId=$studyType&classTypeId=$ClassTypeId"));
		$this->data['GetYear']       = json_decode(file_get_contents(lang('api_link')."/api/Years/" . $this->ApiDbname . "/GetOpenedYearsBySchoolId?schoolId=$schoolId"));
		$this->data['Get_Year']      = $Year_lms[0]->Year_lms;
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

		// $this->data['GetYear']          = $this->input->post('GetYear')  ;

		$this->data['father_name_en']   = $this->input->post('father_name_en');

		$this->data['EducationalQualification']         = $this->input->post('EducationalQualification');

		$this->data['fa_mobile']           = $this->input->post('fa_mobile');

		$this->data['fa_mobile2']          = $this->input->post('fa_mobile2');

		$this->data['phone_home']          = $this->input->post('phone_home');

		$this->data['work_phone']          = $this->input->post('work_phone');

		$this->data['fa_The_job']          = $this->input->post('fa_The_job');

		$this->data['fa_Address']          = $this->input->post('fa_Address');

		$this->data['mother_educationa']   = $this->input->post('mother_educationa');

		$this->data['ma_The_job']          = $this->input->post('ma_The_job');

		$this->data['mother_work_phone']   = $this->input->post('mother_work_phone');

		$this->data['mother_work']         = $this->input->post('mother_work');

		$this->data['student_name_en']     = $this->input->post('student_name_en');

		$this->data['student_region']      = $this->input->post('student_region');

		$this->data['st_gender']           = $this->input->post('st_gender');

		$this->data['st_BirhtDate']        = $this->input->post('st_BirhtDate');

		$this->data['st_place_birth']      = $this->input->post('st_place_birth');

		$this->data['second_lang']         = $this->input->post('second_lang');

		$this->data['RowLevelId']          = $this->input->post('RowLevelId');

		$this->data['bro_name']            = $this->input->post('bro_name');

		$this->data['BR0_RowLevelId']      = $this->input->post('BR0_RowLevelId');

		$this->data['bro_school_Name']     = $this->input->post('bro_school_Name');

		$this->data['bro_school_type']     = $this->input->post('bro_school_type');

		$this->data['bro_id']              = $this->input->post('bro_id');

		if ($this->student_register_model->edit_student_register_model($this->data)) {

			$this->session->set_flashdata('SuccessAdd', lang('br_add_suc'));
		} else {

			$this->session->set_flashdata('ErrorAdd', lang('br_add_error'));
		}
		redirect('admin/student_register/', 'refresh');
	}
	public function count_student_register()
	{
		$this->data['Get_Year'] = $this->uri->segment(4);
		$get_schools  = json_decode(file_get_contents(lang('api_link')."/api/Schools/" . $this->ApiDbname . "/GetAllSchools"));
		$schoolId     = $get_schools[0]->SchoolId;
		$this->data['GetYear']       = json_decode(file_get_contents(lang('api_link')."/api/Years/" . $this->ApiDbname . "/GetOpenedYearsBySchoolId?schoolId=$schoolId"));
		$this->data['getRowLevel']  = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetAllRowLevels"));
		if ($this->data['Get_Year']) {
			$this->data['getdate']  = $this->student_register_model->count_student_register_model($this->data['Get_Year']);
		} else {
		}
		$this->load->admin_template('count_register_form', $this->data);
	}
	/////////////////////////
	public function delete_student_register()
	{
		$ID = $this->uri->segment(4);
		if ($this->student_register_model->delete_student_register($ID)) {

			$this->session->set_flashdata('SuccessAdd', lang('br_add_suc'));
		} else {

			$this->session->set_flashdata('ErrorAdd', lang('br_add_error'));
		}
		redirect('admin/student_register/', 'refresh');
	}
	///////////////
	public function add_student_brother()
	{
		$this->data['reg_id']           = $this->uri->segment(4);

		$this->data['broName']          = $this->input->post('broName');

		$this->data['bro_rowlevel']     = $this->input->post('bro_rowlevel');

		$this->data['bro_schoolName']   = $this->input->post('bro_schoolName');

		$this->data['bro_schooltype']   = $this->input->post('bro_schooltype');

		if ($this->student_register_model->add_student_brother($this->data)) {

			$this->session->set_flashdata('SuccessAdd', lang('br_add_suc'));
		} else {

			$this->session->set_flashdata('ErrorAdd', lang('br_add_error'));
		}
		redirect('admin/student_register/get_student_register/' . $this->data['reg_id'], 'refresh');
	}


	public function student_update_report()
	{
		$Data['details']         = 0;
		$Data['school_data']     = $this->student_register_model->get_student_updated($Data);
		$Data['get_level']       = $this->student_register_model->get_row_level1();
		$this->load->admin_template('view_student_updated', $Data);
	}
	public function student_update_row_level_report()
	{
		$Data['details']         = 1;
		$Data['schoolID']        = $this->uri->segment(4);
		$Data['levelID']         = $this->uri->segment(5);
		$Data['school_data']     = $this->student_register_model->get_student_updated($Data);
		$Data['get_rowlevel']    = $this->student_register_model->get_rowlevel($Data);
		$this->load->admin_template('view_student_update_row_level', $Data);
	}
	public function student_update_details_report()
	{
		$Data['schoolID']    =  $schoolID     = $this->uri->segment(4);
		$Data['rowlevelID']  =  $rowlevelID   = $this->uri->segment(5);
		// $Data['Data']            = $this->student_register_model->student_update_details_report($Data);
		
			$Data['Data']   =$this->db->query("SELECT contact.*,row_level.Level_Name,row_level.Row_Name
                                                        FROM `student_updated`
                                                        INNER JOIN father_update on father_update.ID_ACC = student_updated.IDACC
                                                        INNER JOIN contact ON contact.studentBasicID = student_updated.studentBasicID
                                                        INNER JOIN student ON student.Contact_ID = contact.ID
                                                        INNER JOIN row_level ON student.R_L_ID = row_level.ID
                                                        where student_updated.`SchoolID` = $schoolID
                                                        AND row_level.ID = $rowlevelID
                                                        AND father_update.confirm_code = 1
                                                        ")->result();
// 		$Data['Data']             = $this->db->query("
//     		SELECT contact.*,row_level.Level_Name,row_level.Row_Name
//             FROM `contact`
//             INNER JOIN student ON student.Contact_ID = contact.ID
//             INNER JOIN row_level ON student.R_L_ID = row_level.ID
//             where contact.SchoolID = " . $Data['schoolID'] . "
//             AND contact.Isactive = 1
//             AND contact.studentBasicID not in(select studentBasicID from student_updated)
// 		 ")->result();

		$this->load->admin_template('view_student_update_details', $Data);
	}
	public function unconfirm_code_student_update()
	{
		$Data['fatherID']        = $this->uri->segment(4);
		if ($Data['fatherID']) {

			$this->db->query("UPDATE `father_update` SET `confirm_code`= 1 WHERE `ID_ACC` = '" . $Data['fatherID'] . "' ");
		}
		$Data['Data']            = $this->student_register_model->unconfirm_code_student_update();
		$this->load->admin_template('view_unconfirm_code_student_update', $Data);
	}
	////////data which in lms and not in erp
	public function get_data_lms()
	{
		$get_schools  = json_decode(file_get_contents(lang('api_link')."/api/Schools/" . $this->ApiDbname . "/GetAllSchools"));
		$schoolId     = $get_schools[0]->SchoolId;
		$json         = file_get_contents(lang('api_link')."/api/Students/" . $this->ApiDbname . "/GetAllStudentData?schoolId=$schoolId&genderId=");

		$all_students =  json_decode($json);
		$arr = [];
		foreach ($all_students as $Key => $StudentR) {
			$STU = $StudentR->StBasicId;
			$IsExists = $StudentR->IsExists;
			if ($IsExists == 1 && $StudentR->YearName == "2022-2023" && $StudentR->LevelName == "رياض الاطفال") {
				array_push($arr, $STU);
			}
		}
		$AA = implode(',', $arr);


		$query = $this->db->query("select studentBasicID,Name 
from contact 
INNER join student on contact.ID=student.Contact_ID
where Type='S'AND Isactive=1 and student.R_L_ID IN(238,241,244) AND studentBasicID NOT IN(" . $AA . ")")->result();
		PRINT_R(json_encode($query));
	}
	//////////////////////////data which in erp and not  lms
	public function get_data_erp()
	{
		$get_schools  = json_decode(file_get_contents(lang('api_link')."/api/Schools/" . $this->ApiDbname . "/GetAllSchools"));
		$schoolId     = $get_schools[0]->SchoolId;
		$json         = file_get_contents(lang('api_link')."/api/Students/" . $this->ApiDbname . "/GetAllStudentData?schoolId=17&genderId=");

		$all_students =  json_decode($json);
		$arr1 = [];

		$query = $this->db->query("select studentBasicID,Name 
from contact 
INNER join student on contact.ID=student.Contact_ID
where Type='S'AND Isactive=1 and SchoolID=80 ")->result();

		foreach ($query as $Key => $val) {
			$studentBasicID = $val->studentBasicID;
			array_push($arr1, $studentBasicID);
		}
		$bbb = implode(',', $arr1);
		$xx = explode(',', $bbb);
		foreach ($all_students as $Key => $StudentR) {
			if ($StudentR->IsExists == 1 && $StudentR->YearName == "2023-2024" ) {
				$STU = $StudentR->StBasicId;
				if (!in_array($STU, $xx)) {
					print_r($StudentR->StName);
					die;
				}
			}
		}
	}
}
