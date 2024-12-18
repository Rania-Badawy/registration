<?php
class Evaluation_Teacher_Model extends CI_Model{
	private $Date='',$Encryptkey='',$Token='',$UID=0,$ClassID=0,$ClassTableID=0,$WeekID=0;
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
	   $this->Token            = md5($this->Encryptkey.uniqid(mt_rand()).microtime()) ;
	   return	$this->Token ; 
	}
	public function get_emp($StudentID = 0 )
	{
		$query = $this->db->query("SELECT
 		contact.ID ,
		contact.Name ,
		subject.ID ,
		subject.Name ,
		contact.Token
		FROM contact
		INNER JOIN class_table ON contact.ID = class_table.EmpID
		INNER JOIN student ON student.R_L_ID = class_table.RowLevelID AND student.Class_ID = class_table.ClassID
		WHERE student.Contact_ID = '" . $StudentID . "'
		GROUP BY contact.ID
        ")->result();
		if (sizeof($query) > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}
	//////////////get_emp_id
		public function get_emp_id($Token  = NULL)
	   {
		$query = $this->db->query("SELECT contact.ID FROM contact WHERE Token = '".$Token."' ")->row_array();
		if(sizeof($query) > 0 )
		{
		  return $query['ID'] ;
		}else{return FALSE ;}
	  }
	//////////////get_emp_id
	public function get_emp_exam($EmpID  = 0 , $StudentID = 0 , $Type = 0  )
	{
		$query = $this->db->query("SELECT
        test.ID ,
        test.Name
        FROM test
        INNER JOIN test_questions ON test.ID = test_questions.Test_ID
        INNER JOIN questions_content ON test_questions.Questions_ID = questions_content.ID
        INNER JOIN test_student ON  questions_content.ID = test_student.questions_content_ID
        INNER JOIN config_emp ON test.Subject_emp_ID = config_emp.ID
        WHERE config_emp.EmpID       = '".$EmpID."'
        AND test_student.Contact_ID  = '".$StudentID."'
        AND test.type                = '".$Type."'
        GROUP BY  test.ID
         ")->result();
		if(sizeof($query) > 0 )
		{
			return $query ;
		}else{return FALSE ;}
	}/////
	//////////////////////
	public function get_emp_clerical_homework($EmpID  = 0 , $StudentID = 0 )
    {
	  $query = $this->db->query("SELECT
        clerical_homework.ID ,
        clerical_homework.title AS Name
        FROM clerical_homework
        INNER JOIN config_emp ON clerical_homework.subjectEmpID = config_emp.ID
        WHERE config_emp.EmpID = '".$EmpID."'
        AND clerical_homework.classID  = (SELECT Class_ID FROM student WHERE Contact_ID = '".$StudentID."' )
        AND config_emp.RowLevelID         = (SELECT R_L_ID  FROM student WHERE Contact_ID = '".$StudentID."' )
        GROUP BY  clerical_homework.ID DESC
         ")->result();
		if(sizeof($query) > 0 )
		{
			return $query ;
		}else{return FALSE ;}
    }
	//////get_emp_ask
	public function get_emp_ask($EmpID  = 0 , $StudentID = 0 )
	{
		$query = $this->db->query("SELECT
		ID ,
        title AS Name ,
        content
        FROM ask_teacher
        WHERE teacherID = '".$EmpID."'
        AND studentID   = '".$StudentID."'
        GROUP BY  ID DESC
         ")->result();
		if(sizeof($query) > 0 )
		{
			return $query ;
		}else{return FALSE ;}
	}
 public function add_eval_teacher($Data = array())
   {
	 $DataInsert = array(

		 "EmpID"     => $Data['EmpID'] ,
		 "StudentID" => $Data['UID'] ,
		 "EvalType"  => $Data['EvalType'] ,
		 "EvalTypeID"=> $Data['EvalTypeID'] ,
		 "Degree"    => $Data['Eval'] ,
		 "Token"     => $this->Token ,
		 "Date"      => $this->Date

	 );
	 $this->db->insert('evalution_teacher',$DataInsert);
    }
	public function check_degree_eval($EmpID = 0  , $ID = 0  , $UID = 0 , $Type = 0)
    {
		$query = $this->db->query("SELECT * FROM evalution_teacher WHERE EmpID = '".$EmpID."'  AND  StudentID = '".$UID."' AND EvalTypeID = '".$ID."' AND EvalType = '".$Type."' ORDER BY ID DESC  ")->row_array();
		if(sizeof($query) > 0 )
		{
			return $query ;
		}else{return FALSE ;}
    }
	public function get_emp_eval_admin()
	{
		$query = $this->db->query("SELECT contact.ID , contact.Name FROM contact INNER JOIN  evalution_teacher ON contact.ID = evalution_teacher.EmpID GROUP BY contact.ID   ")->result();
		if(sizeof($query) > 0 )
		{
			return $query ;
		}else{return FALSE ;}
	}
	public function get_sum_emp_eval_admin($EmpID = 0  , $type = 0 )
	{
		$query = $this->db->query("SELECT SUM(Degree) AS SumDegree FROM evalution_teacher WHERE EmpID = '".$EmpID."' AND EvalType = '".$type."'  ")->row_array();
		if(sizeof($query) > 0 )
		{
			return $query ;
		}else{return FALSE ;}
	}

	public function get_num_emp_eval_admin($EmpID = 0  , $type = 0 )
	{
		$query = $this->db->query("SELECT SUM(Degree) AS SumDegree FROM evalution_teacher WHERE EmpID = '".$EmpID."' AND EvalType = '".$type."'  ")->num_rows();
		if(sizeof($query) > 0 )
		{
			return $query ;
		}else{return FALSE ;}
	}

 }//////END CLASS?>