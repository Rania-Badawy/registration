<?php
class Student_Register_Model extends CI_Model
{
	private $Token           = '';
	function __construct()
	{
		parent::__construct();
		$this->Date       = date('Y-m-d H:i:s');
		$this->Encryptkey = $this->config->item('encryption_key');
		$this->Token      = $this->get_token();
	}
	////////get_token
	private function get_token()
	{
		$this->Token            = md5($this->Encryptkey . uniqid(mt_rand()) . microtime());
		$this->Token            = substr($this->Token, 2, 5);
		return	$this->Token;
	}
	////////get_token_act
	public function get_token_act()
	{
		$this->Token            = md5($this->Encryptkey . uniqid(mt_rand()) . microtime());
		$this->Token            = substr($this->Token, 2, 4);
		return	$this->Token;
	}
	//////////////////////////////////
	public function get_how_school()
	{

		$Name = 'name';
		if ($this->session->userdata('language') == "english") {
			$Name = 'name_en';
		}
		$query = $this->db->query("SELECT ID,$Name  as Name FROM how_school ")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
	///////////////////////////
	public function get_row_level($ID = 0)
	{

		$query = $this->db->query("SELECT school_details.SchoolName ,row.ID as rowID ,row.Name as rowName ,level.ID as levelID ,level.Name as levelName ,
                            	  school_row_level.ID as RowLevel_schoolID,row_level.ID as row_level_ID
                            	   FROM school_row_level 
                            	   INNER JOIN school_details ON school_row_level.SchoolID = school_details.ID
                            	   INNER JOIN row_level  ON school_row_level.RowLevelID = row_level.ID
                            	   INNER JOIN row    ON row_level.Row_ID = row.ID
                            	   INNER JOIN level  ON row_level.Level_ID = level.ID  group by  row_level.ID order by level.ID ,row.Name
                            	   ")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
	public function add_new_register($data, $check_code)
	{
	    extract($data);
		$Date  =  $data['date'];
		$queryCode = $this->db->query("SELECT `country_code` FROM `school_details` GROUP BY `country_code`")->row_array();
		$semesterquery = $this->db->query("SELECT semester FROM setting");
		$semester = $semesterquery->row();
		if($semester->semester ==NULL){
			$semester= $this->input->post('semester')[0];
		}else{
			$semester =$semester->semester;
		}

		if ($data['Reg_ID']) {
			$query_reg        = $this->db->query("select ID,reg_parent_id from register_form where ID=" . $data['Reg_ID'] . " ")->row_array();
			$Data_update = array(

				"parent_name_eng"                       => $data['parent_name_eng'],
				"parent_type_Identity" 		            => $data['parent_type_Identity'],
				"parent_source_identity" 	            => $data['parent_source_identity'],
				"parent_educational_qualification" 		=> $data['parent_educational_qualification'],
				"parent_address" 		                => $data['parent_region'],
				"parent_national_ID" 		            => $data['parent_national_ID'],
				"parent_mobile2" 		                => $this->input->post('parent_mobile2') ? $queryCode['country_code'] . $this->input->post('parent_mobile2') : "",
				"parent_phone" 		                    => $this->input->post('parent_phone') ? $queryCode['country_code'] . $this->input->post('parent_phone') : "",
				"parent_access_station" 	            => $data['parent_access_station'],
				"parent_house_number" 		            => $data['parent_house_number'] ? $data['parent_house_number'] : 000,
				"parent_region" 	                    => $data['parent_region'],
				"parent_profession" 		            => $data['parent_profession'],
				"parent_profession_mather" 		        => $data['parent_profession_mather'],
				"parent_work_address" 		            => $data['parent_work_address'],
				"parent_phone2" 	                    => $this->input->post('parent_phone2'),
				"parent_work_phone" 	                => $this->input->post('parent_phone2'),
				"parent_relative" 		                => '',
				"parent_degre_img"                      => $data['parent_degre_img'][$key],
				"mother_name"              		        => $this->input->post('mother_name'),
				"motherNumberID"                        => $this->input->post('MotherNumberID'),
				"mother_educational_qualification"      => $this->input->post('mother_educational_qualification'),
				"mother_work"              		        => $this->input->post('mother_work'),
				"mother_mobile"              	        => $this->input->post('mother_mobile') ? $queryCode['country_code'] . $this->input->post('mother_mobile') : "",
				"mother_work_phone"                     => $this->input->post('mother_work_phone'),
				"mother_email"              	        => $this->input->post('mother_email'),
				"person_relative" 		                => $data['person_relative'],
				"kg_picture" 	                        => $data['kg_picture'],
				"person_address" 		                => $data['parent_region'],
				"person_name" 		                    => $data['person_name'] ? $data['person_name'] : $data['parent_name'] ,
				"person_NumberID" 		                => $data['person_NumberID'] ? $data['person_NumberID'] : $data['ParentNumberID'],
				"person_mobile" 		                => $data['person_mobile'] ? $queryCode['country_code'] . $data['person_mobile'] :  $queryCode['country_code'] . $this->input->post('parent_mobile'),
				"par_religion" 	                        => $data['par_religion'],
				"emergency_number" 	                    => $data['emergency_number'] ? $data['emergency_number'] : '',
				"father_certificate"                    => $this->input->post('father_certificate'),
				"father_national_id"                    => $this->input->post('father_national_id'),
				"father_brith_certificate"              => $this->input->post('father_brith_certificate'),
				"mother_certificate"                    => $this->input->post('mother_certificate'),
				"mother_national_id"                    => $this->input->post('mother_national_id'),
				"mother_brith_certificate"              => $this->input->post('mother_brith_certificate'),
				"person_phone" 		                    => $this->input->post('parent_mobile') ? $queryCode['country_code'] . $this->input->post('parent_mobile') : "",
				"father_certificate" 		            => $this->input->post('father_certificate'),
				"father_national_id" 		            => $this->input->post('father_national_id'),
				"father_brith_certificate" 		        => $this->input->post('father_brith_certificate'),
				"mother_certificate" 		            => $this->input->post('mother_certificate'),
				"mother_national_id" 		            => $this->input->post('mother_national_id'),
				"mother_brith_certificate" 		        => $this->input->post('mother_brith_certificate'),
			);

			$this->db->where('ID', $query_reg['reg_parent_id']);
			$this->db->update('reg_parent', $Data_update);
			$Student_Update = array(
				"check_code"   		           => $check_code,
				"student_region" 	    	   => isset($data['student_region'][0]) ? $data['student_region'][0] : '',
				"birthdate" 		           => $data['birthdate'][0],
				"birthplace" 		           => $data['birthplace'][0],
				"sec_language"                 => $data['language'][0],
				"exSchool" 		               => isset($data['exSchool'][0]) ? $data['exSchool'][0] : '',
				"birth_certificate"            => $data['birth_certificate'][0],
				"parent_degre_img"             => $data['parent_degre_img'][0],
				"Signature" 	               => $data['Signature'],
				"name_eng"                     => $data['name_eng'][0],
				"allowphoto" 	               => $data['allowphoto'],
				"want_transport"               => $this->input->post('want_transport')[0],
				"transport_address"            => $data['transport_address'],
				"transport_type"               => $this->input->post('transport_type')[0],
				"Reg_Date"                     => $Date,
				"schoolName"                   => $schoolName,
				"Academic_Issues"              => $data['Academic_Issues'],
				"Admin_Issues"                 => $data['Admin_Issues'],
				"Finance_Issues"               => $data['Finance_Issues']
			);
			$this->db->where('ID', $data['Reg_ID']);
			$this->db->update('register_form', $Student_Update);
			$insertId = $data['Reg_ID'];
			$this->addStudentPsy($insertId, 0);
			foreach ($data['bro_name']  as $key => $value) {
				$DataInsert_bro = array(

					"Bro_Name" 		           => $data['bro_name'][$key],
					"Row_Level_Id" 		       => $data['bro_levelID'][$key],
					"School_Name" 		       => $data['bro_School'][$key],
					"School_Type" 		       => $data['school_type'][$key],
					"reg_id" 		           => $insertId
				);
				$this->db->insert('reg_brothers', $DataInsert_bro);
			}
		}
		foreach ($data['name'] as $key => $value) {
			$data['school']      = $shoolid             = $data['school'][$key];
			$rowid               = $data['rowID'][$key];
			$levelid             = $data['level'][$key];
			$studyid             = $data['studyType']= $data['studeType'][$key];
			$data['ClassTypeName'] =		$genderid            = $data['ClassTypeName'][$key];
			$ParentNumberID      = $data['ParentNumberID'];
			$YearId              = $this->input->post('YearId')[$key];
			$status              = $data['status'][$key] ? $data['status'][$key] : NULL;
			
			if ($this->ApiDbname  == "SchoolAccDigitalCulture") {
				$parent_mobile2        = $this->input->post('parent_mobile2');
			} else {
				$parent_mobile2     = $this->input->post('parent_mobile2') ? $queryCode['country_code'] . $this->input->post('parent_mobile2') : "";
			}
			if ($ParentNumberID) {
				$father_entry        = $this->db->query("select ID from reg_parent where ParentNumberID=$ParentNumberID AND YearId=$YearId")->result();
			}
		
			$Year_ID           =  $this->db->query("select * from year where IsActive=1 ")->row_array();
			$Year_lms          =  $Year_ID['ID'];

			if ($father_entry) {
	          $fatherId =$father_entry[0]->ID;
			} else {
				$DataInsert1 = array(
					"parent_name" 		                    => $data['parent_name'],
					"parent_name_eng"                       => $data['parent_name_eng'],
					"ParentNumberID" 		                => $data['ParentNumberID'],
					"parent_type_Identity" 		            => $data['parent_type_Identity'],
					"parent_source_identity" 	            => $data['parent_source_identity'],
					"parent_email" 		                    => $data['parent_email'],
					"parent_educational_qualification" 		=> $data['parent_educational_qualification'],
					"parent_address" 		                => $data['parent_region'],
					"parent_national_ID" 		            => $data['parent_national_ID'],
					"parent_mobile" 		                => $this->input->post('parent_mobile') ? $queryCode['country_code'] . $this->input->post('parent_mobile') : "",
					"parent_mobile2" 		                => $parent_mobile2,
					"parent_phone" 		                    => $this->input->post('parent_phone'),
					"parent_access_station" 	            => $data['parent_access_station'],
					"parent_house_number" 		            => $data['parent_house_number'] ? $data['parent_house_number'] : 000,
					"parent_region" 	                    => $data['parent_region'],
					"parent_profession" 		            => $data['parent_profession'],
					"parent_profession_mather" 		        => $data['parent_profession_mather'],
					"parent_work_address" 		            => $data['parent_work_address'],
					"parent_phone2" 	                    => $this->input->post('parent_phone2'),
					"parent_work_phone" 	                => $this->input->post('parent_phone2'),
					"parent_relative" 		                => '',
					"parent_degre_img"                      => $data['parent_degre_img'][$key],
					"mother_name"              		        => $this->input->post('mother_name'),
					"mother_name_eng"              		    => $this->input->post('mother_name_eng'),
					"motherNumberID"                        => $this->input->post('MotherNumberID'),
					"mother_educational_qualification"      => $this->input->post('mother_educational_qualification'),
					"mother_work"              		        => $this->input->post('mother_work'),
					"mother_mobile"              	        => $this->input->post('mother_mobile') ? $queryCode['country_code'] . $this->input->post('mother_mobile') : "",
					"mother_work_phone"                     => $this->input->post('mother_work_phone'),
					"mother_email"              	        => $this->input->post('mother_email'),
					"YearId"             	                => $this->input->post('YearId')[$key],
					"Year_lms"                              => $Year_lms,
					"person_relative" 		                => $data['person_relative'],
					"kg_picture" 	                        => $data['kg_picture'],
					"person_address" 		                => $data['parent_region'],
					"person_name" 		                    => $data['person_name'] ? $data['person_name'] : $data['parent_name'] ,
					"person_NumberID" 		                => $data['person_NumberID'] ? $data['person_NumberID'] : $data['ParentNumberID'],
					"person_mobile" 		                => $data['person_mobile'] ? $queryCode['country_code'] . $data['person_mobile'] :  $queryCode['country_code'] . $this->input->post('parent_mobile'),
					"par_religion" 	                        => $data['par_religion'],
					"father_brith_date"                     => date('Y-m-d', strtotime($data['father_brith_date'])),
					// 			"moth_religion" 	                    =>$data['moth_religion'] ,
					"emergency_number" 	                    => $data['emergency_number'] ? $data['emergency_number'] : '',
					"father_certificate"                    => $this->input->post('father_certificate'),
					"father_national_id"                    => $this->input->post('father_national_id'),
					"father_national_id2"                   => $this->input->post('father_national_id2'),
					"father_brith_certificate"              => $this->input->post('father_brith_certificate'),
					"mother_certificate"                    => $this->input->post('mother_certificate'),
					"mother_national_id"                    => $this->input->post('mother_national_id'),
					"mother_brith_certificate"              => $this->input->post('mother_brith_certificate'),
					"person_phone" 		                    => $this->input->post('parent_mobile'),
					"father_certificate" 		            => $this->input->post('father_certificate'),
					"father_national_id" 		            => $this->input->post('father_national_id'),
					"father_brith_certificate" 		        => $this->input->post('father_brith_certificate'),
					"mother_certificate" 		            => $this->input->post('mother_certificate'),
					"mother_national_id" 		            => $this->input->post('mother_national_id'),
					"mother_national_id2" 		            => $this->input->post('mother_national_id2'),
					"mother_brith_certificate" 		        => $this->input->post('mother_brith_certificate'),
				);


				$this->db->insert('reg_parent', $DataInsert1);
				 $fatherId = $this->db->insert_id();
			 } 
				$DataInsert = array(
					"check_code"   		           => $check_code,
					"nationality" 		           => $data['parent_national_ID'],
					"name" 		                   => $data['name'][$key],
					"student_NumberID" 		       => $data['student_NumberID'][$key],
					"studentnationalityID" 		   => $data['student_NumberID'][$key],
					"Identity" 		               => $data['student_NumberID'][$key],
					"studentIdentity" 		       => $data['student_NumberID'][$key],
					"student_region" 	    	   => isset($data['student_region'][$key]) ? $data['student_region'][$key] : '',
					"gender" 		               => $data['gender'][$key],
					"ClassTypeId" 		           => $data['ClassTypeName'][$key],
					"birthdate" 		           => $data['birthdate'][$key],
					"birthdate_hij" 		       => $data['birthdate_hij'][$key],
					"birthplace" 		           => $data['birthplace'][$key],
					'LevelID'                      => $levelid,
					'levelName'                    => $levelName,
					"rowID" 		               => $rowid,
					"classID"                      => $data['classID'][$key],
					"rowLevelID" 		           => $rowLevelID,
					"rowLevelName"                 => $rowLevelName,
					"sec_language"                 => $data['language'][$key],
					"schoolID"                     => $data['school'],
					"status"                       => $status,
					"schoolName"                   => $schoolName,
					"exSchool" 		               => isset($data['exSchool'][$key]) ? $data['exSchool'][$key] : '',
					"note" 		                   => isset($data['na_school_type'][$key]) ? $data['na_school_type'][$key] : '',
					"Financial_clearance"          => $data['Financial_clearance'][$key],
					"birth_certificate"            => $data['birth_certificate'][$key],
					"vaccination_certificate"      => $data['vaccination_certificate'][$key],
					"family_card1"                 => $data['family_card1'][$key],
					"family_card2"                 => $data['family_card2'][$key],
					"parent_degre_img"             => $data['parent_degre_img'][$key],
					"Signature" 	               => $data['Signature'],
					"studyType" 		           => $data['studeType'][$key],
					"name_eng"                     => $data['name_eng'][$key],
					"howScholl"                    => $data['howScholl'],
					"allowphoto" 	               => $data['allowphoto'],
					"want_transport"               => $this->input->post('want_transport')[$key],
					"transport_address"            => $data['transport_address'],
					"transport_type"               => $this->input->post('transport_type')[$key],
					"YearId"             	       => $this->input->post('YearId')[$key],
					"Year_lms"                     => $Year_lms,
					"semester"             	       =>  $semester,
					"reg_parent_id"                => $fatherId,
					"Reg_Date"                     => $Date,
					"Academic_Issues"              => $data['Academic_Issues'],
					"Admin_Issues"                 => $data['Admin_Issues'],
					"Finance_Issues"               => $data['Finance_Issues'],
					"type"                         => 1
				);

				$this->db->insert('register_form', $DataInsert);
				$insertId = $this->db->insert_id();
				$this->addStudentPsy($insertId, $key);
				foreach ($data['bro_name']  as $key => $value) {
					$DataInsert_bro = array(

						"Bro_Name" 		           => $data['bro_name'][$key],
						"Row_Level_Id" 		       => $data['bro_levelID'][$key],
						"School_Name" 		       => $data['bro_School'][$key],
						"School_Type" 		       => $data['school_type'][$key],
						"reg_id" 		           => $insertId
					);
					$this->db->insert('reg_brothers', $DataInsert_bro);
				}
			
		}
		return $insertId;
	}

	public function addStudentPsy($register_id, $key)
	{

		$data['register_id'] 	    = $register_id;


		if ($this->input->post('check_val') == 2) {

			$data['grand_parents']     = "لا";
		} elseif ($this->input->post('check_val') == 1 && $this->input->post('grand_parents')[$key] == "") {
			$data['grand_parents']     = "نعم";
		} else {
			$data['grand_parents']  = implode(",", $this->input->post('grand_parents')[$key]);
		}
		if ($this->input->post('check_game') == 2) {

			$data['student_games']    = "لا";
		} elseif ($this->input->post('check_game') == 1 && $this->input->post('student_games')[$key] == "") {
			$data['student_games']     = "نعم";
		} else {
			$data['student_games'] = $this->input->post('student_games')[$key];
		}
		if ($this->input->post('check_behavior') == 2) {

			$data['student_behavior']    = "لا";
		} elseif ($this->input->post('check_behavior') == 1 && $this->input->post('student_behavior')[$key] == "") {
			$data['student_behavior']    = "نعم";
		} else {
			$data['student_behavior'] = $this->input->post('student_behavior')[$key];
		}

		if ($this->input->post('check_specialist') == 2) {

			$data['student_specialist']    = "لا";
		} elseif ($this->input->post('check_specialist') == 1 && $this->input->post('student_specialist')[$key] == "") {
			$data['student_specialist']    = "نعم";
		} else {
			$data['student_specialist'] = $this->input->post('student_specialist')[$key];
		}

		if ($this->input->post('check_diseases') == 2) {

			$data['student_diseases']    = "لا";
		} elseif ($this->input->post('check_diseases') == 1  && $this->input->post('student_diseases')[$key] == "") {
			$data['student_diseases']    = "نعم";
		} else {
			$data['student_diseases'] = $this->input->post('student_diseases')[$key];
		}
		if ($this->input->post('check_treatment') == 2) {

			$data['student_treatment']    = "لا";
		} elseif ($this->input->post('check_treatment') == 1 && $this->input->post('student_treatment')[$key] == "") {
			$data['student_treatment']    = "نعم";
		} else {
			$data['student_treatment'] = implode(",", $this->input->post('student_treatment')[$key]);
		}
		if ($this->input->post('check_history') == 2) {

			$data['student_history']    = "لا";
		} elseif ($this->input->post('check_history') == 1 && $this->input->post('student_history')[$key] == "") {
			$data['student_history']    = "نعم";
		} else {
			$data['student_history'] = implode(",", $this->input->post('student_history')[$key]);
		}

		if ($this->input->post('check_allergy') == 2) {

			$data['student_allergy']    = "لا";
		} elseif ($this->input->post('check_allergy') == 1 && $this->input->post('student_allergy')[$key] == "") {
			$data['student_allergy']    = "نعم";
		} else {
			$data['student_allergy'] = implode(",", $this->input->post('student_allergy')[$key]);
		}

		if ($this->input->post('check_health') == 2) {

			$data['student_health']    = "لا";
		} elseif ($this->input->post('check_health') == 1 && $this->input->post('student_health')[$key] == "") {
			$data['student_health']    = "نعم";
		} else {
			$data['student_health'] = $this->input->post('student_health')[$key];
		}

		if ($this->input->post('check_health_not') == 2) {

			$data['student_health_not']    = "لا";
		} elseif ($this->input->post('check_health_not') == 1 && $this->input->post('student_health_not')[$key] == "") {
			$data['student_health_not']    = "نعم";
		} else {
			$data['student_health_not'] = $this->input->post('student_health_not')[$key];
		}

		$data['religion'] 		    = $this->input->post('religion')[$key];
		$data['brothers_num']       = $this->input->post('brothers_num')[$key];
		$data['student_order']      = $this->input->post('student_order')[$key];
		$data['live_with']          = $this->input->post('live_with')[$key];
		$data['social_parents']     = $this->input->post('social_parents')[$key];
		//	$data['grand_parents']      = $grand_parents;
		//	PRINT_R($data['student_games'] );DIE;	
		$data['student_skills']     = $this->input->post('student_skills')[$key];
		//	$data['student_games']      = $this->input->post('student_games')[$key];
		$data['student_sport']      = $this->input->post('student_sport')[$key];
		$data['student_place']      = $this->input->post('student_place')[$key];
		$data['student_relation']   = $this->input->post('student_relation')[$key];
		$data['student_descripe']   = $this->input->post('student_descripe')[$key];
		//	$data['student_behavior']   = $this->input->post('student_behavior')[$key];
		$data['student_get_rid']    = $this->input->post('student_get_rid')[$key];
		$data['student_pressure']   = $this->input->post('student_pressure')[$key];
		$data['student_person']     = $this->input->post('student_person')[$key];
		$data['student_punish']     = $this->input->post('student_punish')[$key];
		//	$data['student_specialist'] = $this->input->post('student_specialist')[$key];
		//	$data['student_diseases']   = $this->input->post('student_diseases')[$key];
		//	$data['student_treatment']  = $this->input->post('student_treatment')[$key];
		//	$data['student_history']    = serialize($this->input->post('student_history')[$key]);
		//	$data['student_allergy']    = serialize($this->input->post('student_allergy')[$key]);
		$data['student_academy']         = $this->input->post('student_academy')[$key];
		$data['child_favorite_color']    = $this->input->post('child_favorite_color')[$key];
		$data['child_favorite_game']     = $this->input->post('child_favorite_game')[$key];
		$data['child_favorite_type_toy'] = $this->input->post('child_favorite_type_toy')[$key];
		$data['child_favorite_animal']   = $this->input->post('child_favorite_animal')[$key];
		$data['child_favorite_nickname'] = $this->input->post('child_favorite_nickname')[$key];
		$data['child_favorite_food']     = $this->input->post('child_favorite_food')[$key];
		$data['things_scare_child']      = $this->input->post('things_scare_child')[$key];
		$data['additional_information']  = $this->input->post('additional_information')[$key];
		$data['enter_bathroom']          = $this->input->post('enter_bathroom')[$key];
		$data['method_enter_bathroom']   = $this->input->post('method_enter_bathroom')[$key];
		$data['time_electronic_devices'] = $this->input->post('time_electronic_devices')[$key];
		$data['child_hobbies']           = $this->input->post('child_hobbies')[$key];
		$data['activities_programs']     = $this->input->post('activities_programs')[$key];
		$data['child_routine']           = $this->input->post('child_routine')[$key];
		$data['memorize_Quran']          = $this->input->post('memorize_Quran')[$key];
		$data['parenting_strategies']    = $this->input->post('parenting_strategies')[$key];

		$this->db->insert('student_psy', $data);
	}
	////////////////////////////
	public function get_R_L_ID_LMS($data)
	{
		extract($data);
		$query = $this->db->query(" SELECT `ID` as Level_ID ,Name as Level_Name FROM `level` WHERE `Name` LIKE '%" . $LevelName . "%'")->row_array();
		return $query;
	}
	//////////////////////////////
	public function get_permission_emp($data)
	{
		extract($data);
		$query = $this->db->query(" SELECT permission_request.`EmpID` , contact.Mail,CASE WHEN LENGTH(contact.Mobile) >= 9 THEN contact.Mobile ELSE contact.Phone END AS mobile_number
                                    FROM `permission_request` 
                                    INNER JOIN contact ON contact.ID = permission_request.EmpID
                                        WHERE permission_request.`Type`= $type  AND FIND_IN_SET(".$levelID.",Level)  AND FIND_IN_SET(".$school.",school_id) 
                                  ")->result();
		return $query;
	}
	////////////////////////////////////////
	public function get_school_LMS($data)
	{
		extract($data);
		$query = $this->db->query(" SELECT `ID`,SchoolName FROM `school_details` WHERE `ID_ACC`=$school and FIND_IN_SET($ClassTypeName,gender)")->row_array();
		return $query;
	}
	//////////////////////////////////
	public function add_father_data($data)
	{
		extract($data);
		$DataInsert1 = array(
			"parent_mobile" 		       => $parent_mobile,
			"parent_mobile2"               => $parent_mobile2,
			"parent_email" 		           => $parent_email,
			"parent_name" 		           => $parent_name.' '.$grandba_name.' '.$family_name,
			"ParentNumberID"               => $ParentNumberID,
			"parent_national_ID"           => $parent_national_ID,
			"parent_region"                => $parent_region

		);
		$this->db->insert('reg_parent', $DataInsert1);
		$insertparentId = $this->db->insert_id();

		$DataInsert = array(
			"Parent_ID"                    => $insertparentId

		);

		return $DataInsert;
	}
	//////////////////////////////////
	public function add_step_reg_data($data)
	{
		extract($data);
		$row_level = (array) json_decode(file_get_contents(lang('api_link')."/api/RowLevels/" . $this->ApiDbname . "/GetRowLevel?schoolId=$school&rowId=$rowID&levelId=$levelID&studyTypeId=$studeType&genderId=$ClassTypeName&feeStatusId=$status"));
		$query      = $this->db->query("SELECT ID ,Level_ID FROM row_level WHERE Level_Name ='" . $row_level['LevelName'] . "' and Row_Name='" . $row_level['RowName'] . "'  ")->row_array();

		$insertparentId = $Parent_ID;
		$DataUpdated = array(
		 "parent_mobile" 		        => $parent_mobile,
		 "parent_mobile2"               => $parent_mobile2,
		 "parent_email" 		        => $parent_email,
		 "parent_name" 		            => $parent_name.' '.$grandba_name.' '.$family_name,
		 "ParentNumberID"               => $ParentNumberID,
		 "parent_national_ID"           => $parent_national_ID,
		 "parent_region"                => $parent_region
		 );
		$this->db->where('ID',$insertparentId);
		$this->db->update('reg_parent',$DataUpdated);
		$DataInsert = array(
			"name" 		                   => $stu_name,
			"gender" 		               => $gender,
			"ClassTypeId" 		           => $ClassTypeName,
			"studyType" 		           => $studeType,
			"schoolID"                     => $school,
			"LevelID" 		               => $levelID,
			"rowID" 		               => $rowID,
			"classID"                      => $classID,
			"rowLevelID" 		           => $row_level['RowLevelId'],
			"rowLevelName"                 => $rowLevelName,
			'levelName'                    => $levelName,
			"schoolName"                   => $schoolName,
			"howScholl"                    => $how_school,
			"check_code"                   => $check_code,
			"classID"                      => $classID,
			"YearId"             	       => $YearId,
			"student_NumberID"             => $student_NumberID,
			"note"                         => $note,
			"Reg_Date"                     => $date,
			"type"                         => 2,
			"reg_parent_id"                => $insertparentId,
			"status"                       => $status,
			"semester"                     => $semester
		);
		$this->db->insert('register_form', $DataInsert);

		$inserted_id = $this->db->insert_id();

		return $inserted_id;
	}
	
	///////////////////////////////////
	public function get_student_register_by_id($ID = 0)
	{
		$query = $this->db->query("
    		select  register_form.* , student_psy.*,reg_parent.* ,how_school.Name as how_school_name ,reg_parent.parent_name as parentname ,reg_parent.parent_name_eng as parentnameeng,
    		reg_parent.ParentNumberID as ParentNumber ,reg_parent.parent_email as parentemail ,reg_parent.parent_educational_qualification as parenteducationalqualification,
    		reg_parent.parent_mobile as parentmobile ,reg_parent.parent_mobile2 as parentmobile2 ,reg_parent.parent_phone as parentphone,
    		reg_parent.parent_access_station as parentaccessstation ,reg_parent.parent_house_number as parenthousenumber ,reg_parent.parent_region as parentregion,
    		reg_parent.parent_profession as parentprofession ,reg_parent.parent_profession_mather as parentprofessionmather,reg_parent.parent_work_address as parentworkaddress ,reg_parent.parent_phone2 as parentphone2,
		    reg_parent.mother_name as mothername,reg_parent.mother_educational_qualification as mothereducationalqualification,reg_parent.mother_mobile as mothermobile ,
		    reg_parent.mother_work as motherwork,reg_parent.mother_work_phone as motherworkphone,reg_parent.mother_email as motheremail,reg_parent.ID AS reg_parent_id
		    FROM register_form 
		    inner join reg_parent on reg_parent.ID =register_form.reg_parent_id
            LEFT JOIN how_school on register_form.howScholl = how_school.ID
            LEFT JOIN student_psy on student_psy.register_id = register_form.id
		 WHERE register_form.id = '" . $ID . "'
		")->row_array();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
	////	////////////////////////////
	public function get_permission_reg($data)
	{
		extract($data);
		$query = $this->db->query(" SELECT permission_request.`EmpID` , contact.Mail,CASE WHEN LENGTH(contact.Mobile) >= 9 THEN contact.Mobile ELSE contact.Phone END AS mobile_number
                                    FROM `permission_request` 
                                    INNER JOIN contact ON contact.ID = permission_request.EmpID
                                    WHERE  NameSpaceID=" . $NameSpaceID . " AND FIND_IN_SET($Level,`Level`)   AND FIND_IN_SET($school,`school_id`)   
                                  ")->result();
		return $query;
	}

	////////////////////////
	public function get_student_register($rowlevel, $GetYear)
	{
		$idContact = (int)$this->session->userdata('id');

		$query = $this->db->query("
		    select  register_form.*, register_form.name as stuname ,reg_parent.parent_name as parentname ,reg_parent.parent_mobile as parentmobile,reg_parent.ParentNumberID as ParentNumberID,
		 reg_parent.mother_mobile as mothermobile ,
		 case when LENGTH(register_form.name) > 15 then register_form.name Else  CONCAT(register_form.name,' ',reg_parent.parent_name) END  AS FullName
		 FROM register_form 
		    inner join reg_parent on reg_parent.ID =register_form.reg_parent_id
             where
              register_form.YearId=" . $GetYear . " AND register_form.R_L_ID_LMS IN(" . $rowlevel . ")
             AND is_deleted=0
 		    ORDER BY register_form.ID asc 
		")->result();

		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
	///////////////////////////
	

	public function get_student_register_brothers($Level)
	{
		$idContact = (int)$this->session->userdata('id');
		$data1 = $this->db->query("SELECT GenderId,SchoolID  FROM `supervisor` WHERE studytype IS NOT NULL AND `EmpID`='" . $idContact . "'")->result_array();
		if ($data1) {
			foreach ($data1 as $dat) {
				$all1[] = '\'' . $dat['GenderId'] . '\'';
				$all2[] = '\'' . $dat['SchoolID'] . '\'';
			}
			$ids = implode(',', $all);
			$ids1 = implode(',', $all1);
			$ids2 = implode(',', $all2);
			$where = "WHERE  register_form.gender IN ($ids1) AND register_form.SchoolID IN ($ids2) ";
		} else {
			$where = "";
		}
		$query = $this->db->query("
		    select  t.*, t.name as stuname ,reg_parent.parent_name as parentname ,reg_parent.parent_mobile as parentmobile,
		 reg_parent.mother_mobile as mothermobile ,
		 case when LENGTH(t.name) > 15 then t.name Else  CONCAT(t.name,' ',reg_parent.parent_name) END  AS FullName
		 FROM register_form as t
		    inner join reg_parent on reg_parent.ID =t.reg_parent_id
             $where
             AND  EXISTS (select * from register_form as  t1 where t1.`reg_parent_id` = t.`reg_parent_id` and t1.`id` <> t.`id` )ORDER by  t.`reg_parent_id` DESC
		")->result();

		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
	

	///////////////////accept_student_register
	public function accept_student_register($ID = 0, $StuConID = 0)
	{
		$this->db->query("UPDATE register_form SET IsAccepted = 1 , StudentContactID =  '" . $StuConID . "' WHERE id = '" . $ID . "'");
	}
	///////////////
	public function add_new_father($Data = array())
	{
		$Add_Contact = array(
			'Name'                => $Data['FName'],
			'ID_ACC'              => $Data['FatherID'],
			'Gender'              => 1,
			'Address'             => $Data['parent_address'],
			'SchoolID'             => $Data['SchoolID'],
			'Mobile'              => $Data['Mobile'],
			'Nationality_ID'      => $Data['nationality'],
			'User_Name'           => $Data['FNumberID'],
			'Password'            => md5($this->Encryptkey . $Data['FNumberID']),
			'type'                => 'F',
			'Token'               => $this->Token
		);
		$Insert_Contact =  $this->db->insert('contact', $Add_Contact);
		if ($Insert_Contact) {
			$this->db->select('ID');
			$this->db->from('contact');
			$this->db->where('Token', (string)$this->Token);
			$this->db->limit(1);
			$ResultData = $this->db->get();
			$NumRowResultData  = $ResultData->num_rows();
			if ($NumRowResultData > 0) {
				$ReturnData     = $ResultData->row_array();
				(int)$Contact_ID = $ReturnData['ID'];
				$Add_Father = array(
					'AccountNum'     => 0,
					'Contact_ID'     => (int)$Contact_ID,
					'Token'          => (string)$this->Token
				);
				$Insert_Employee =  $this->db->insert('father', $Add_Father);
				if ($Insert_Contact) {
					return $Contact_ID;
				} else {
					return FALSE;
				}
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	} ////////////
	public function new_student($Data = array())
	{
		$this->Token = $this->get_token();
		$FatherContactID = $Data['FatherConID'];
		$Add_Contact = array(
			'Name'                => $Data['SName'],
			'studentBasicID'      => $Data['StudentBasicDataID'],
			'Gender'              => $Data['Sgender'],
			'Number_ID'           => $Data['national_ID'],
			'User_Name'           => $Data['national_ID'],
			'SchoolID'             => $Data['SchoolID'],
			'Password'            => md5($this->Encryptkey . $Data['national_ID']),
			'type'                => 'S',
			'Token'               => $this->Token
		);
		$Insert_Contact =  $this->db->insert('contact', $Add_Contact);
		if ($Insert_Contact) {
			$this->db->select('ID');
			$this->db->from('contact');
			$this->db->where('Token', (string)$this->Token);
			$this->db->limit(1);
			$ResultData = $this->db->get();
			$NumRowResultData  = $ResultData->num_rows();
			if ($NumRowResultData > 0) {
				$ReturnData      = $ResultData->row_array();
				(int)$Contact_ID = $ReturnData['ID'];
				$RowLevelID      = $Data['rowLevelID'];
				$Add_Student = array(
					'Father_ID'      => $FatherContactID,
					'Class_ID'       => 1,
					'StdetailID'     => 0,
					'Contact_ID'     => (int)$Contact_ID,
					'R_L_ID'         => (int)$Data['rowLevelID'],
					'StudyTypeID'    => (int) $Data['StudyTypeID'],
					'Token'          => (string)$this->Token
				);
				$Insert_Student =  $this->db->insert('student', $Add_Student);
				if ($Insert_Student) {
					return $Contact_ID;
				} else {
					return FALSE;
				}
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}
	//////////get_student_register_by_number_id
	public function get_student_register_by_number_id($NumberID = 0)
	{
		$query = $this->db->query("
		 select 
		 register_form.* , 
		 level.ID        AS LevelID,
		 row.ID          AS RowID,
		 level.Name      AS LevelName,
		 row.Name        AS RowName,
		 row_level.ID    As RowLevelID ,
		 name_space.Name AS Nationality
		 FROM
		 register_form
		 INNER JOIN  name_space      ON register_form.nationality	 = name_space.ID 
		 INNER JOIN row_level        ON register_form.rowLevelID     = row_level.ID
		 INNER JOIN row              ON row_level.Row_ID             = row.ID
	     INNER JOIN level            ON row_level.Level_ID           = level.ID
		 WHERE register_form.ParentNumberID = '" . $NumberID . "'
		")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
	public function get_level_user_request($ID = 0)
	{
		$query = $this->db->query("SELECT * FROM permission_request WHERE EmpID = '" . $ID . "' AND Type = 2 ")->result();

		if (sizeof($query) > 0) {
			$Level = '';
			foreach ($query as $Key => $Result) {
				$Level .= $Result->Level . ',';
			}

			return $Level;
		} else {
			return 0;
		}
	}
	public function get_permission_request($ID = 0)
	{
		$query = $this->db->query("SELECT * FROM permission_request WHERE EmpID = '" . $ID . "' AND Type = 2 ")->row_array();

		if (sizeof($query) > 0) {


			return $query;
		} else {
			return 0;
		}
	}
	public function get_auto_sms_accept($ID = 0)
	{
		$query = $this->db->query("SELECT content FROM auto_sms_accept WHERE id = '" . $ID . "' ")->row_array();

		if (sizeof($query) > 0) {


			return $query;
		} else {
			return 0;
		}
	}
	////////////////////////
	public function add_student_register_accept($ID = 0)
	{

		//var_dump($ID);die;
		$query = $this->db->query("SELECT * FROM active_request WHERE RequestID = '" . $ID . "' AND Type = 2  ")->num_rows();
		if ($query == 0) {
			$query = $this->db->query("SELECT * FROM permission_request WHERE Type = 2 GROUP BY  NameSpaceID  ")->result();

			if (sizeof($query) > 0) {
				foreach ($query as $Key => $Result) {
					$this->db->query("
				INSERT INTO active_request
				 SET 
				 RequestID = '" . $ID . "' ,
				 NameSpaceID = '" . $Result->NameSpaceID . "' , 
				 Type = 2 ,
				 EmpID = 0
				   ");
					/*	$this->db->query("
				update  register_form
				 SET  
				 IsAccepted = 1
				 where 
				 id = '".$ID."'
				   ") ;	*/
				}
			}
		}
	}
	public function check_user_accept_request($ID = 0, $Lang = NULL, $ID_request)
	{

		$Name = 'Name';
		if ($Lang == "english") {
			$Name = 'Name_En';
		}
		$query = $this->db->query("SELECT
	   active_request.* ,name_space.$Name as name_space
	   FROM
	   active_request 
	   INNER JOIN permission_request ON active_request.NameSpaceID = permission_request.NameSpaceID
	   INNER JOIN name_space         ON name_space.ID = permission_request.NameSpaceID
	   WHERE permission_request.EmpID = '" . $ID . "' AND permission_request.Type = 2   and RequestID = '" . $ID_request . "' LIMIT 1
	   ")->row_array();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
	public function check_all_accept_request($ID = 0, $Lang = NULL, $ID_request)
	{

		$Name = 'Name';
		if ($Lang == "english") {
			$Name = 'Name_En';
		}
		$query = $this->db->query("SELECT
	   active_request.*  
	   FROM
	   active_request 
	   INNER JOIN permission_request ON active_request.NameSpaceID = permission_request.NameSpaceID
	   WHERE RequestID = '" . $ID_request . "' and active_request.IsActive=0  and permission_request.Type = 2  and permission_request.NameSpaceID =87 LIMIT 1
	   ")->row_array();
		if (sizeof($query) > 0) {
			return 1;
		} else {
			return FALSE;
		}
	}

	public function check_all_accept_request2($ID = 0, $Lang = NULL, $ID_request)
	{
		$Name = 'Name';
		if ($Lang == "english") {
			$Name = 'Name_En';
		}
		$query = $this->db->query("SELECT
	   active_request.*  
	   FROM
	   active_request 
	   INNER JOIN permission_request ON active_request.NameSpaceID = permission_request.NameSpaceID
	   WHERE RequestID = '" . $ID_request . "' and active_request.IsActive=2  and permission_request.Type = 2  and permission_request.NameSpaceID !=85 LIMIT 1
	   ")->row_array();
		if (sizeof($query) > 0) {
			return 1;
		} else {
			return FALSE;
		}
	}

	public function get_row_level1()
	{

		$query = $this->db->query("SELECT level.ID as levelID ,level.Name as levelName FROM level")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
	public function get_nationality($ID = 0)
	{

		$query = $this->db->query("SELECT
	   ID,Name
	   FROM
	   name_space  where Parent_ID =1
	   ")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}


	public function get_semester($ID = 0)
	{

		$query = $this->db->query("SELECT
	   ID ,Name
	   FROM
	   config_semester  
	   ")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
	public function get_row_levelDetails($ID = 0)
	{

		$query = $this->db->query("SELECT
	   school_row_level.*,level.StudyTypeID ,school_details.ID_ACC as schoolIDAcc , level.StudyTypeID as StudyTypeIDAcc ,school_details.YearID_acc,row_level.Level_ID, row_level.Row_ID
	   FROM
	   school_row_level
	   INNER JOIN school_details  ON school_details.ID = school_row_level.SchoolID
	   INNER JOIN row_level  ON school_row_level.RowLevelID = row_level.ID
	   INNER JOIN row    ON row_level.Row_ID = row.ID
	   INNER JOIN level  ON row_level.Level_ID = level.ID  
	   where school_row_level.ID = '" . $ID . "'
	   ")->row_array();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
	//////////////////////////check_accept_request
	public function check_accept_request($ID = 0, $NameSpace = 0, $UID = 0)
	{
		$UserType = $this->session->userdata('type');
		if ($UserType == 'U') {
			$this->db->query("
				UPDATE active_request
				 SET 
				 IsActive = " . $this->input->post('IsActive') . " , 
				 EmpID    = '" . $UID . "',
				  Reason = '" . $this->input->post("Reason") . "'
				 WHERE
				 RequestID = '" . $ID . "'  
				 AND 
				 Type = 2 
				 And   
				 IsActive = 0
				   ");
			if ($this->input->post('IsActive') == 1) {
				$query = $this->db->query("SELECT
                	   *
                	   FROM
                	   active_request 
                	   WHERE RequestID = '" . $ID . "' AND IsActive = 0 AND Type = 2 LIMIT 1
                	   ")->num_rows();
				$this->db->query("
            				update  register_form
            				 SET  
            				 IsAccepted = 1
            				 where 
            				 id = '" . $ID . "'
				      ");
			} else {
				$query = $this->db->query("SELECT
                	   *
                	   FROM
                	   active_request 
                	   WHERE RequestID = '" . $ID . "' AND IsActive = 0 AND Type = 2 LIMIT 1
                	   ")->num_rows();
				$this->db->query("
            				update  register_form
            				 SET  
            				 IsRefused = 1
            				 where 
            				 id = '" . $ID . "'
				      ");
			}

			return true;
		} else {
			$this->db->query("
				UPDATE active_request
				 SET 
				 IsActive = " . $this->input->post('IsActive') . " , 
				 EmpID    = '" . $UID . "',
				 Reason = '" . $this->input->post("Reason") . "'
				 WHERE
				 RequestID = '" . $ID . "'
				 AND 
				 NameSpaceID = '" . $NameSpace . "'  
				 AND 
				 Type = 2 
				   ");
			$query = $this->db->query("SELECT
                	   *
                	   FROM
                	   active_request 
                	   WHERE RequestID = '" . $ID . "' AND IsActive = 0 AND Type = 2 LIMIT 1
                	   ")->num_rows();
			if ($query == 0) {
				/*$this->db->query("
            				update  register_form
            				 SET  
            				 IsAccepted = 1
            				 where 
            				 id = '".$ID."'
				      ") ;*/
				return true;
			} else {
				/*$this->db->query("
            				update  register_form
            				 SET  
            				 IsAccepted = 1
            				 where 
            				 id = '".$ID."'
				      ") ;*/
				return true;
			}
		}
	}

	public function getStudentReasons($id)
	{
		$data = array();
		$records = $this->db->where('RequestID', $id)->get('active_request')->result();
		foreach ($records as $key => $value) {
			$data[$value->NameSpaceID] = $value;
		}
		return $data;
	}
	//// get_admission
	public function get_admission($ID = 0)
	{

		$lang = $this->session->userdata('language');
		if ($lang == "english") {
			$this->db->select('dtls.ID,dtls.Title_en AS Title_item,dtls.Content_en AS Content,dtls.ImagePath,dtls.YoutubeScriptArray AS script_item,dtls.Token,cms_main_sub.Name_en AS Name,dtls.like_count,dtls.Token,cms_album_pic.pic,cms_album_pic.type_file ,dtls.MainSubID,dtls.schoolID');
		} else {
			$this->db->select('dtls.ID,dtls.Title  AS Title_item,dtls.Content,dtls.ImagePath,dtls.YoutubeScriptArray AS script_item,dtls.Token,cms_main_sub.Name,dtls.like_count,dtls.Token,cms_album_pic.pic,cms_album_pic.type_file,dtls.MainSubID,dtls.schoolID');
		}
		$this->db->from('cms_details AS dtls');
		$this->db->join('cms_main_sub', 'cms_main_sub.ID = dtls.MainSubID');
		$this->db->join('level', 'dtls.LevelID=level.ID', 'left');
		$this->db->join('cms_album_pic', 'cms_album_pic.item_data = dtls.ID', 'left');
		$this->db->where('dtls.MainSubID', $ID);
		// $this->db->where('dtls.IsSystem',0);
		// $this->db->group_by('cms_album_pic.item_data');
		// $this->db->order_by('dtls.date');
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return 0;
		}
	}


	public function get_item_images($ID = 0)
	{

		$lang = $this->session->userdata('language');
		if ($lang == "english") {
			$this->db->select('dtls.ID,dtls.Title_en AS Title_item,dtls.Content_en AS Content,dtls.ImagePath,dtls.YoutubeScriptArray AS script_item,dtls.Token,cms_main_sub.Name_en AS Name,dtls.like_count,dtls.Token,cms_album_pic.pic,cms_album_pic.type_file ,dtls.MainSubID,dtls.schoolID');
		} else {
			$this->db->select('dtls.ID,dtls.Title  AS Title_item,dtls.Content,dtls.ImagePath,dtls.YoutubeScriptArray AS script_item,dtls.Token,cms_main_sub.Name,dtls.like_count,dtls.Token,cms_album_pic.pic,cms_album_pic.type_file,dtls.MainSubID,dtls.schoolID');
		}
		$this->db->from('cms_details AS dtls');
		$this->db->join('cms_main_sub', 'cms_main_sub.ID = dtls.MainSubID');
		$this->db->join('level', 'dtls.LevelID=level.ID', 'left');
		$this->db->join('cms_album_pic', 'cms_album_pic.item_data = dtls.ID', 'left');
		$this->db->where('dtls.MainSubID', $ID);

		//$this->db->where('cms_album_pic.type_file',1);

		$this->db->group_by('cms_album_pic.item_data');
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return 0;
		}
	}
	public function check_code($code)
	{
		$query = $this->db->query("SELECT active_request.*, register_form.IsAccepted , register_form.IsRefused, register_form.name FROM  register_form 
			LEFT JOIN active_request on active_request.RequestID = register_form.id
		WHERE register_form.check_code = '" . $code . "' order by active_request.ID DESC ");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	public function Get_service_res()
	{
		$query = $this->db->query("SELECT contact.GroupID  ,contact.ID,contact.Name , contact.IsActive 
	     FROM contact 
	     WHERE contact.IsActive=1 
	     AND  contact.GroupID  =18 ")->result();
		return $query;
	}
	public function Get_state()
	{
		$query = $this->db->query("SELECT register_type.ID ,register_type.Name , register_type.IsActive,register_type.Name_en 
	     FROM register_type
	     WHERE register_type.IsActive=1 ")->result();
		return $query;
	}
	public function delete_state($record_id)
	{
		$this->db->query(" UPDATE register_type
          SET register_type.IsActive=0
           WHERE register_type.ID =$record_id ; ");
	}
	public function save_state($data)
	{
		extract($data);
		$this->db->query("insert into register_type SET register_type.Name='" . $Name . "',register_type.Name_en='" . $Name_en . "' ");
		return true;
	}
	public function update_state($data)
	{
		extract($data);
		$this->db->query(" UPDATE register_type
          SET register_type.Name='" . $Name . "',register_type.Name_en='" . $Name_en . "'
           WHERE register_type.ID =$record_id ; ");
	}
	public function edit_state($record_id)
	{
		$query = $this->db->query("SELECT register_type.ID ,register_type.Name , register_type.IsActive 
	     FROM register_type
	     WHERE register_type.IsActive=1 
	     AND  register_type.ID =$record_id")->row_array();
		return $query;
	}
	//get_q_answers



	public function get_level($schoolID, $StudyTypeID)
	{
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		$query = $this->db->query("
		 SELECT
		 level.ID         AS ID ,
		 level." . $Name . "  AS Name 
		 FROM 
		 row_level
		 INNER JOIN row              ON row_level.Row_ID        = row.ID
		 INNER JOIN level            ON row_level.Level_ID      = level.ID
		 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = '" . $schoolID . "' 
		 WHERE level.Is_Active = 1  and level.StudyTypeID = '" . $StudyTypeID . "' GROUP BY  level.ID 
		")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
	public function get_StudyType($schoolID)
	{
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		$query = $this->db->query("
		 SELECT
		 level.StudyTypeID,
		 level.StudyTypeName
		 FROM 
		 row_level
		 INNER JOIN row              ON row_level.Row_ID        = row.ID
		 INNER JOIN level            ON row_level.Level_ID      = level.ID
		 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = '" . $schoolID . "' 
		 WHERE level.Is_Active = 1  GROUP BY  level.StudyTypeID 
		")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
	public function get_row_level_register($levelID, $schoolID)
	{
		$Name = 'Name';
		if ($Lang == 'english') {
			$Name = 'Name_en';
		}
		$query = $this->db->query("
		 SELECT
		 level.ID         AS LevelID ,
		 row.ID           AS RowID ,
		 level." . $Name . "  AS LevelName ,
		 row." . $Name . "    AS RowName ,
		 school_row_level.ID     As RowLevelID 
		 FROM 
		 row_level
		 INNER JOIN row              ON row_level.Row_ID        = row.ID
		 INNER JOIN level            ON row_level.Level_ID      = level.ID
		 INNER JOIN school_row_level ON row_level.ID = school_row_level.RowLevelID AND school_row_level.schoolID = '" . $schoolID . "' 
		 WHERE level.ID = " . $levelID . " 
		 ")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return  FALSE;
		}
	}

	public function getPermissionRequestsForApplication()
	{
		$reg = $this->db->query("select * from school_details limit 1")->row_array();
		if ($reg['accpet_reg_type'] == 3 || $reg['accpet_reg_type'] == 1) {
			$where = 'name_space.ID=87';
		} else {
			$where = 1;
		}
		$query   =	  $this->db->query("select permission_request.*, name_space.* 
	                                    from permission_request 
                                    	inner join name_space on permission_request.NameSpaceID=name_space.ID
                                    	where permission_request.type = 2 and $where
                                    	group by permission_request.NameSpaceID")->result();
		return $query;
	}
	public function register_formdate($ID)
	{

		$query = $this->db->query("
		 SELECT * FROM reg_test_date
		 WHERE reg_id = " . $ID . " 
		 ")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return  FALSE;
		}
	}
	public function add_register_formdate($Data = array())
	{
		$this->db->query("
        INSERT INTO reg_test_date
        SET
        reg_id             = '" . $Data['reg_id'] . "' ,
        Date     = '" . $Data['Date'] . "' ,
        Absence         ='" . $Data['Absence'] . "' ,
        note         ='" . $Data['note'] . "' 
         ");
		return TRUE;
	}
	public function edit_register_formdate($Data = array())
	{
		$edit_exam = array(
			Date     => $Data['test_date'],
			Absence         => $Data['Absence'],
			note            => $Data['note']
		);
		$this->db->where('ID', $Data['reg_test_id']);
		$Insert_Exam =  $this->db->update('reg_test_date', $edit_exam);
	}

	public function delete_formdate($reg_test_id)
	{

		$query = $this->db->query("
		 DELETE  FROM reg_test_date
		 WHERE ID = " . $reg_test_id . " 
		 ");
		return true;
	}
	public function register_date($ID)
	{

		$query = $this->db->query("
		 SELECT Date FROM reg_test_date
		 WHERE reg_id = " . $ID . " and Absence =1
		 order by ID desc
		 ")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return  FALSE;
		}
	}
	/////////////////////
	public function get_student_register_data($ID)
	{
		$query = $this->db->query("
		 SELECT register_form.*,reg_parent.*,reg_brothers.*, register_form.name as student_name,register_form.rowLevelID as student_rowLevelID,register_form.student_NumberID as student_NumberID,register_form.reg_parent_id,
		 reg_parent.parent_name,reg_parent.ParentNumberID,reg_parent.parent_mobile,reg_parent.parent_email,
		 reg_parent.mother_name,reg_parent.mother_mobile,reg_parent.mother_email ,register_form.Year_lms
		 from register_form
		 inner join reg_parent on reg_parent.ID =register_form.reg_parent_id
		 inner join reg_brothers on reg_brothers.reg_id =register_form.id
		 where register_form.id=" . $ID . "
		 ")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return  FALSE;
		}
	}
	
	public function student_register_brothers($ParentNumberID, $studentNumberID)
	{
		$query = $this->db->query("
		 SELECT GROUP_CONCAT( DISTINCT st.Name SEPARATOR  '<br>') as student_name, GROUP_CONCAT( DISTINCT  level.Name , ',' ,row.Name SEPARATOR  '<br>') as row_name
         from reg_parent
         inner join contact as fa on reg_parent.ParentNumberID=fa.Number_ID
         inner join student on fa.ID =student.Father_ID
         inner join contact as st on student.Contact_ID=st.ID
         inner join row_level on student.R_L_ID=row_level.ID
         inner join level on row_level.Level_ID=level.ID
         inner join row on row_level.Row_ID=row.ID
         where reg_parent.ParentNumberID='" . $ParentNumberID . "' and st.Number_ID!=$studentNumberID
		 ")->row_array();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return  FALSE;
		}
	}
	//////////////////
	public function delete_student_register($ID)
	{
		$query = $this->db->query("
		
		 DELETE register_form , student_psy  FROM register_form  INNER JOIN student_psy  
         WHERE register_form.id= student_psy.register_id and register_form.id = " . $ID . "
		 
		 ");
		return true;
	}
	////////////////
	public function add_student_brother($Data = array())
	{
		$this->db->query("
        INSERT INTO reg_brothers
        SET
        reg_id	             = '" . $Data['reg_id'] . "' ,
        Bro_Name             = '" . $Data['broName'] . "' ,
        Row_Level_Id         = '" . $Data['bro_rowlevel'] . "' ,
        School_Name          = '" . $Data['bro_schoolName'] . "' ,
        School_Type          = '" . $Data['bro_schooltype'] . "' 
         ");
		return TRUE;
	}

	///////////////
	public function get_student_updated($Data)
	{
		extract($Data);
		if ($details == 1) {
			$where = "AND school_details.ID = '" . $schoolID . "' ";
		}
		$query = $this->db->query("
    		SELECT
                school_details.ID,
                school_details.SchoolName,
                COUNT(student_updated.SchoolID) AS count_num
            FROM
                student_updated
            INNER JOIN school_details ON school_details.ID = student_updated.SchoolID
            INNER JOIN father_update on father_update.ID_ACC = student_updated.IDACC
            
            WHERE
                school_details.ID not in(65,4) AND father_update.confirm_code = 1
                $where
            GROUP BY
                school_details.ID 
		 ")->result();
		return $query;
	}
	///////////////
	public function student_update_details_report($Data)
	{
		extract($Data);
		if ($rowlevelID == "") {
			$rowlevelID = "NULL";
		}
		$query = $this->db->query("
    		SELECT contact.*,row_level.Level_Name,row_level.Row_Name
            FROM `student_updated`
            INNER JOIN father_update on father_update.ID_ACC = student_updated.IDACC
            INNER JOIN contact ON contact.studentBasicID = student_updated.studentBasicID
            INNER JOIN student ON student.Contact_ID = contact.ID
            INNER JOIN row_level ON student.R_L_ID = row_level.ID
            where contact.SchoolID = $schoolID
            AND row_level.ID =IFNULL($rowlevelID,row_level.ID)
            AND father_update.confirm_code = 1
            AND contact.Isactive = 1
		 ")->result();
		return $query;
	}
	public function get_rowlevel($Data)
	{
		extract($Data);
		$query = $this->db->query("SELECT
	   row_level.ID AS rowlevelID,Level_ID as levelID ,Level_Name as levelName , row_level.`Row_Name`,row_level.`Row_ID`
	   FROM
	   row_level
	   
	   where Level_ID = $levelID
	   ")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
	public function unconfirm_code_student_update()
	{

		$query = $this->db->query("SELECT father_update.ID_ACC,contact.Name , father_update.parent_mobile,school_details.SchoolName  
	                             FROM `father_update`
                                 INNER JOIN contact ON contact.ID_ACC = father_update.ID_ACC
                                 INNER JOIN school_details ON school_details.ID = contact.SchoolID
                                 WHERE `confirm_code` = 0 GROUP BY father_update.ID_ACC")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
    /////////////////////////
	public function generate_unique_token() {
        
        $token = '';
        do {
            $token = md5($this->Encryptkey . uniqid(mt_rand(), true) . microtime());
            $token = substr($token, 2, 4);
            $this->db->where('check_code', $token);
            $query = $this->db->get('register_form');
        } while ($query->num_rows() > 0); 
        
        return $token; 
    }
	////////////////////////////END CLASS   
}
