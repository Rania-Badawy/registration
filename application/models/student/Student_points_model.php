<?php
class Student_Points_Model  extends CI_Model
{
	private $student;

	private function set_student($sid)
	{
		$this->student = $this->db->get_where('student', ['Contact_ID' => $sid], 1)->row();
	}

	public function points_entry($id, $contact_id, $activity_id, $activity_type, $points)
	{
	  //  $test_id=$this->uri->segment(4);
		$conds = array(
			'student_id'         => $contact_id,
			'activity_id'        => $activity_id,
			'activity_type'        => $activity_type,
		);
		$conds1 = array(
			'Stu_ID'         => $contact_id,
			'Test_ID '  =>$id,
			
			
		);
		
		$query = $this->db->get_where('student_points', $conds);
		$query1 = $this->db->get_where('send_box_student', $conds1);	
		$exists = $query->num_rows();
		$exists1 = $query1->num_rows();
// 		print_r($test_id);
// 		die();
		if ($exists && $exists1) {
			$this->db->update('student_points', ['points' => $points], $conds);
			$this->db->update('send_box_student', ['Stu_Degree' => $points], $conds1);
		} else {
			$this->db->insert('student_points', array_merge($conds, ['points' => $points]));
			$this->db->insert('send_box_student', array_merge($conds1, ['Stu_Degree' => $points]));
			
		}
		return true;
	}
	public function get_student_points($sid)
	{
		$start = strtotime('today');
		$end = strtotime('tomorrow');
		
		$Date=date('Y-m-d');
        $fromdate=$Date.' 00:00:00'; 
        $todate=$Date.' 23:59:59';  
		// Count lessons
		$this->db->where('`student_id` = ' . $sid);
		$this->db->where('`watch_at` BETWEEN ' . $start . ' AND ' . $end);
		$this->db->from('lesson_report');
		$lessons = $this->db->count_all_results();
		// Count revisions
		$this->db->where('`student_id` = ' . $sid);
		$this->db->where('`watch_at` BETWEEN ' . $start . ' AND ' . $end);
		$this->db->from('revision_report');
		$revisions = $this->db->count_all_results();
		$return = [
			'lessons' => $lessons,
			'revisions' => $revisions,
			'clerical' => $this->db->query("SELECT sum(points) as result FROM `student_points` WHERE `student_id` = $sid  AND`activity_type`='clerical_homework' AND created_at BETWEEN '$fromdate' AND '$todate'")->row_array(),
		//	'homework' => $this->db->from('student_points')->where(['student_id' => $sid, '`created_at` BETWEEN ' . $fromdate . ' AND ' . $todate, 'activity_type' => 'homework'])->count_all_results(),
			'homework' =>$this->db->query("SELECT sum(points) as result FROM `student_points` WHERE `student_id` = $sid  AND`activity_type`='homework' AND created_at BETWEEN '$fromdate' AND '$todate'")->row_array(),
			'exams'=>$this->db->query("SELECT sum(points) as result FROM `student_points` WHERE `student_id` = $sid  AND`activity_type`='exam' AND created_at BETWEEN '$fromdate' AND '$todate'")->row_array()
		];
	//	print_r($return);die;
		return array_sum($return) > 0 ? $return : false;
	}

	public function get_class_order($sid)
	{
		$this->set_student($sid);
		$start = strtotime('today');
		$end = strtotime('tomorrow');
		$today = date('Y-m-d');
		$school = $this->session->userdata('SchoolID');
		$rl_id = $this->student->R_L_ID;
		$class_id = $this->student->Class_ID;
		$query = $this->db->query("
		SELECT `student`.`Contact_ID`, COUNT(DISTINCT `student_points`.`id`) + COUNT(DISTINCT `lesson_report`.`id`) + COUNT(DISTINCT `revision_report`.`id`) AS `total`
		FROM `student`
		LEFT JOIN `contact` ON `contact`.`ID` = `student`.`Contact_ID` AND `contact`.`Isactive` = 1
		LEFT JOIN `student_points` ON `student_points`.`student_id` = `student`.`Contact_ID` AND `student_points`.`created_at` = '$today'
		LEFT JOIN `lesson_report` ON `lesson_report`.`student_id` = `student`.`Contact_ID` AND `lesson_report`.`watch_at` BETWEEN $start AND $end
		LEFT JOIN `revision_report` ON `revision_report`.`student_id` = `student`.`Contact_ID` AND `revision_report`.`watch_at` BETWEEN $start AND $end
		WHERE `contact`.`SchoolID` = $school AND `student`.`R_L_ID` = $rl_id AND `student`.`Class_ID` = $class_id
		GROUP BY `student`.`Contact_ID`
		ORDER BY `total`, `contact`.`LastLogin` DESC
		");
		$result_array = $query->result_array();
		return [
			'order' => array_search($sid, $result_array) + 1,
			'total' => sizeof($result_array)
		];
	}

	public function get_level_order($sid)
	{
		$this->set_student($sid);
		$start = strtotime('today');
		$end = strtotime('tomorrow');
		$today = date('Y-m-d');
		$school = $this->session->userdata('SchoolID');
		$rl_id = $this->student->R_L_ID;
		$query = $this->db->query("
		SELECT `student`.`Contact_ID`, COUNT(DISTINCT `student_points`.`id`) + COUNT(DISTINCT `lesson_report`.`id`) + COUNT(DISTINCT `revision_report`.`id`) AS `total`
		FROM `student`
		LEFT JOIN `contact` ON `contact`.`ID` = `student`.`Contact_ID` AND `contact`.`Isactive` = 1
		LEFT JOIN `student_points` ON `student_points`.`student_id` = `student`.`Contact_ID` AND `student_points`.`created_at` = '$today'
		LEFT JOIN `lesson_report` ON `lesson_report`.`student_id` = `student`.`Contact_ID` AND `lesson_report`.`watch_at` BETWEEN $start AND $end
		LEFT JOIN `revision_report` ON `revision_report`.`student_id` = `student`.`Contact_ID` AND `revision_report`.`watch_at` BETWEEN $start AND $end
		WHERE `contact`.`SchoolID` = $school AND `student`.`R_L_ID` = $rl_id
		GROUP BY `student`.`Contact_ID`
		ORDER BY `total`, `contact`.`LastLogin` DESC
		");
		$result_array = $query->result_array();
		return [
			'order' => array_search($sid, $result_array) + 1,
			'total' => sizeof($result_array)
		];
	}
	
	public function get_school_order($sid)
	{
		$this->set_student($sid);
		$start = strtotime('today');
		$end = strtotime('tomorrow');
		$today = date('Y-m-d');
		$school = $this->session->userdata('SchoolID');
		$level = $this->db->get_where('row_level', ['ID' => $this->student->R_L_ID], 1)->row();
		$row_levels = $this->db->select('ID')->from('row_level')->where('Level_ID', $level->Level_ID)->get()->result_array();
		$row_levels_txt = implode(',', array_map(function($row) {
			return $row['ID'];
		}, $row_levels));
		
		$query = $this->db->query("
		SELECT `student`.`Contact_ID`, COUNT(DISTINCT `student_points`.`id`) + COUNT(DISTINCT `lesson_report`.`id`) + COUNT(DISTINCT `revision_report`.`id`) AS `total`
		FROM `student`
		LEFT JOIN `contact` ON `contact`.`ID` = `student`.`Contact_ID` AND `contact`.`Isactive` = 1
		LEFT JOIN `student_points` ON `student_points`.`student_id` = `student`.`Contact_ID` AND `student_points`.`created_at` = '$today'
		LEFT JOIN `lesson_report` ON `lesson_report`.`student_id` = `student`.`Contact_ID` AND `lesson_report`.`watch_at` BETWEEN $start AND $end
		LEFT JOIN `revision_report` ON `revision_report`.`student_id` = `student`.`Contact_ID` AND `revision_report`.`watch_at` BETWEEN $start AND $end
		WHERE `contact`.`SchoolID` = $school AND `student`.`R_L_ID` IN ($row_levels_txt)
		GROUP BY `student`.`Contact_ID`
		ORDER BY `total`, `contact`.`LastLogin` DESC
		");
		$result_array = $query->result_array();
		return [
			'order' => array_search($sid, $result_array) + 1,
			'total' => sizeof($result_array)
		];
	}

		
	public function get_all_schools_order($sid)
	{
		$this->set_student($sid);
		$start = strtotime('today');
		$end = strtotime('tomorrow');
		$today = date('Y-m-d');
		$level = $this->db->get_where('row_level', ['ID' => $this->student->R_L_ID], 1)->row();
		$rl_id = $this->student->R_L_ID;
		
		$query = $this->db->query("
		SELECT `student`.`Contact_ID`, COUNT(DISTINCT `student_points`.`id`) + COUNT(DISTINCT `lesson_report`.`id`) + COUNT(DISTINCT `revision_report`.`id`) AS `total`
		FROM `student`
		LEFT JOIN `contact` ON `contact`.`ID` = `student`.`Contact_ID` AND `contact`.`Isactive` = 1
		LEFT JOIN `student_points` ON `student_points`.`student_id` = `student`.`Contact_ID` AND `student_points`.`created_at` = '$today'
		LEFT JOIN `lesson_report` ON `lesson_report`.`student_id` = `student`.`Contact_ID` AND `lesson_report`.`watch_at` BETWEEN $start AND $end
		LEFT JOIN `revision_report` ON `revision_report`.`student_id` = `student`.`Contact_ID` AND `revision_report`.`watch_at` BETWEEN $start AND $end
		WHERE `student`.`R_L_ID` = $rl_id
		GROUP BY `student`.`Contact_ID`
		ORDER BY `total`, `contact`.`LastLogin` DESC
		");
		$result_array = $query->result_array();
		return [
			'order' => array_search($sid, $result_array) + 1,
			'total' => sizeof($result_array)
		];
	}

	public function report_level_lessons($level_id, $school_id, $from, $to)
	{
		$query = $this->db->query("
			SELECT COUNT(`lesson_report`.`id`) AS `total`
			FROM `student`
			INNER JOIN `contact` ON `contact`.`ID` = `student`.`Contact_ID` AND `contact`.`SchoolID` = $school_id
			INNER JOIN `lesson_report` ON `student`.`Contact_ID` = `lesson_report`.`student_id` AND `lesson_report`.`watch_at` BETWEEN $from AND $to
			INNER JOIN `row_level` ON `row_level`.`ID` = `student`.`R_L_ID` AND `row_level`.`Level_ID` = $level_id
		");
		return $query->row();
	}

	public function report_level_revisions($level_id, $school_id, $from, $to)
	{
		$query = $this->db->query("
			SELECT COUNT(`revision_report`.`id`) AS `total`
			FROM `student`
			INNER JOIN `contact` ON `contact`.`ID` = `student`.`Contact_ID` AND `contact`.`SchoolID` = $school_id
			INNER JOIN `revision_report` ON `student`.`Contact_ID` = `revision_report`.`student_id` AND `revision_report`.`watch_at` BETWEEN $from AND $to
			INNER JOIN `row_level` ON `row_level`.`ID` = `student`.`R_L_ID` AND `row_level`.`Level_ID` = $level_id
		");
		return $query->row();
	}

	public function report_level_clerical($level_id, $school_id, $from, $to)
	{
		$query = $this->db->query("
			SELECT SUM(`clerical_homework_answer`.`student_result`) AS `total`
			FROM `student`
			INNER JOIN `contact` ON `contact`.`ID` = `student`.`Contact_ID` AND `contact`.`SchoolID` = $school_id
			INNER JOIN `clerical_homework_answer` ON `student`.`Contact_ID` = `clerical_homework_answer`.`contact_idst` AND DATE(`clerical_homework_answer`.`date`) BETWEEN '$from' AND '$to'
			INNER JOIN   clerical_homework        ON  clerical_homework_answer.homework_id=clerical_homework.ID
			INNER JOIN `row_level` ON `row_level`.`ID` = `student`.`R_L_ID` AND `row_level`.`Level_ID` = $level_id
			WHERE clerical_homework.type=0
		");
		return $query->row();
	}

	public function report_level_homework($level_id, $school_id, $from, $to)
	{
		$query = $this->db->query("
			SELECT SUM(`test_student`.`Degree`) AS `total`
			FROM `student`
			INNER JOIN `contact` ON `contact`.`ID` = `student`.`Contact_ID` AND `contact`.`SchoolID` = $school_id
			INNER JOIN `test_student` ON `student`.`Contact_ID` = `test_student`.`Contact_ID` AND DATE(`test_student`.`Inserted_At`) BETWEEN '$from' AND '$to'
			INNER JOIN   test          ON test_student.test_id=test.ID
			INNER JOIN `row_level` ON `row_level`.`ID` = `student`.`R_L_ID` AND `row_level`.`Level_ID` = $level_id
			WHERE test.type=0
		");
		return $query->row();
	}

	public function report_level_exam($level_id, $school_id, $from, $to)
	{
		$query = $this->db->query("
			SELECT SUM(`test_student`.`Degree`) AS `total`
			FROM `student`
			INNER JOIN `contact` ON `contact`.`ID` = `student`.`Contact_ID` AND `contact`.`SchoolID` = $school_id
			INNER JOIN `test_student` ON `student`.`Contact_ID` = `test_student`.`Contact_ID` AND DATE(`test_student`.`Inserted_At`) BETWEEN '$from' AND '$to'
			INNER JOIN   test          ON test_student.test_id=test.ID
			INNER JOIN `row_level` ON `row_level`.`ID` = `student`.`R_L_ID` AND `row_level`.`Level_ID` = $level_id
			WHERE test.type=1
		");
		return $query->row();
	}

	public function report_students($level_id =0 , $school_id, $strfrom, $strto, $from, $to,$max = 0,$rowlevelID = 0)
	{
		if($level_id != 0){
			$level = " AND `row_level`.`Level_ID` = $level_id ";
		}

		if($max != 0){
			$order = " ORDER BY `total` DESC ";
			$limit = " LIMIT ".$max;
		}

		if($rowlevelID != 0){
			$row_level = " AND `student`.`R_L_ID` = $rowlevelID ";
		}else{
			$row_level = ' ';
		}

		
		$query = $this->db->query("
			SELECT 
			`student`.`ID`,
			CONCAT(`stdnt`.Name,' ',tb2.Name) AS Name
			,COUNT(DISTINCT `lesson_report`.`id`) AS `lessons`
			,COUNT(DISTINCT `revision_report`.`id`) AS `revisions`
			,COUNT(DISTINCT `clerical_homework_answer`.`ID`) AS `clerical`
			,COUNT(DISTINCT `homework`.`ID`) AS `homework`
			,COUNT(DISTINCT `exam`.`ID`) AS `exam`
			,(COUNT(DISTINCT `lesson_report`.`id`) + COUNT(DISTINCT `revision_report`.`id`) + COUNT(DISTINCT `clerical_homework_answer`.`ID`) + COUNT(DISTINCT `homework`.`ID`) + COUNT(DISTINCT `exam`.`ID`)) AS `total`


			FROM `student`
			INNER JOIN `contact` as stdnt ON `stdnt`.`ID` = `student`.`Contact_ID` AND `stdnt`.`SchoolID` = $school_id
			INNER JOIN `contact` AS tb2 ON `student`.`Father_ID`     = tb2.ID
			LEFT JOIN `lesson_report` ON `stdnt`.`ID` = `lesson_report`.`student_id` AND `lesson_report`.`watch_at` BETWEEN $strfrom AND $strto


			LEFT JOIN `revision_report` ON `student`.`Contact_ID` = `revision_report`.`student_id` AND `revision_report`.`watch_at` BETWEEN $strfrom AND $strto

			LEFT JOIN `clerical_homework_answer` ON `student`.`Contact_ID` = `clerical_homework_answer`.`contact_idst`

			LEFT JOIN `student_points` as homework ON `student`.`Contact_ID` = `homework`.`student_id` AND DATE(`homework`.`created_at`) BETWEEN '$from' AND '$to' AND `homework`.`activity_type` = 'homework'

			LEFT JOIN `student_points` as exam ON `student`.`Contact_ID` = `exam`.`student_id` AND DATE(`exam`.`created_at`) BETWEEN '$from' AND '$to' ANd  `homework`.`activity_type` = 'exam'

			INNER JOIN `row_level` ON `row_level`.`ID` = `student`.`R_L_ID`  " .$level." ".$row_level."

			GROUP BY
        	student.ID
        	".$order." ".$limit."


		");
		return $query->result();


	}
}
