<?php
class Students_Evaluation_Model  extends CI_Model 
 {
     
    public function get_class($data)
	{
	    extract($data);
			$query = $this->db->query("
			 SELECT 
			 class_table.ID         AS ClassTableID ,
			 row_level.Level_Name   AS LevelName,
			 row_level.Row_Name     AS RowName,
			 row_level.ID           AS RowLevelID,
			 class.ID               AS ClassID,
			 class.Name             AS ClassName
			 FROM 
			 class_table
			 INNER JOIN class            ON class_table.ClassID     = class.ID
			 INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
             INNER JOIN student          ON class_table.RowLevelID           = student.R_L_ID AND class_table.ClassID = student.Class_ID
             INNER JOIN contact          ON contact.ID                       = student.Contact_ID
			 WHERE class_table.EmpID     = ".$UID." 
			 AND class_table.RowLevelID  = ".$RowLevelID." 
			 AND contact.SchoolID        = '".$this->session->userdata('SchoolID')."'
			 AND contact.Isactive        = 1
			 GROUP BY class_table.RowLevelID , class_table.ClassID
			");
			  if($query->num_rows() >0)
			  {return $query->result();}else{return FALSE ;}
	} 
    ///////////////////
    public function get_students_by_eval($data)
	{
		extract($data);
		$Lang=$this->session->userdata('language');
		$query = $this->db->query("SELECT
								    contact.ID             AS StudentID,
									CASE
									WHEN '$Lang' = 'english' and contact.Name_en IS not NULL and contact.Name_en !=' ' THEN contact.Name_en
									ELSE contact.Name
									END AS StudentName 
								    FROM contact
								    INNER JOIN student     ON contact.ID    = student.Contact_ID
								    INNER JOIN class_table ON class_table.ClassID = student.Class_ID and class_table.RowLevelID= student.R_L_ID 
			                        INNER JOIN subject     ON class_table.SubjectID = subject.ID 
								    WHERE contact.SchoolID                 = '".$this->session->userdata('SchoolID')."'
								    AND contact.Isactive                   = 1
								    AND student.R_L_ID                     = $RowLevelID
								    AND student.Class_ID                   = $class_id
								    AND subject.ID                         = $SubjectID
								    and (CASE WHEN subject.basic=0 THEN (FIND_IN_SET(subject.ID ,student.s_language)) ELSE 1 END )
								    GROUP BY student.Contact_ID
									order by StudentName asc
							");			
		if($query->num_rows() >0)
		{return $query->result();}else{return FALSE ;}
	}
	///////////////////
    public function get_students($data)
	{
		extract($data);
		$Lang=$this->session->userdata('language');
		$LangArray = array("Name"=>"Name");
		if($this->session->userdata('language') =='english'){$LangArray = array("Name"=>"Name_en");}
		$sub_subject = $this->db->query(" SELECT subject.ID,subject.basic 
		                                  FROM subject 
		                                  INNER JOIN class_table ON subject.ID = class_table.SubjectID 
		                                  WHERE class_table.ID IN($ClassTableID)")->row_array();
		$subjectID =  $sub_subject['ID'];      
		
		if($sub_subject['basic'] == 0){
		    
		    $where = " AND FIND_IN_SET($subjectID, student.s_language) ";
		    
		}else{
		    
		    $where = "AND 1";
		}    
		if ($multipleClass) {

			$classes    = $this->db->query("SELECT GROUP_CONCAT(class_table.ClassID) AS classID , RowLevelID FROM `class_table` WHERE `multipleClass` = $multipleClass ")->row_array();
			
			$whereClass = " AND student.R_L_ID = ".$classes['RowLevelID']." AND student.Class_ID   IN(".$classes['classID'].")";
		}else {

			$whereClass = " AND class_table.ID = $ClassTableID";
		}            
		
		                 
		$query = $this->db->query("SELECT
								    contact.ID             AS StudentID,
									CASE
									WHEN '$Lang' = 'english' and contact.Name_en IS not NULL and contact.Name_en !=' ' THEN contact.Name_en
									ELSE contact.Name
									END AS StudentName ,
								    row_level.Level_Name   AS LevelName,
			                        row_level.Row_Name     AS RowName,
			                        class.Name             AS ClassName,
									CONCAT(row_level.Level_Name,'-',row_level.Row_Name,'-',class.Name) AS studentClass
								    FROM contact
								    INNER JOIN student        ON contact.ID = student.Contact_ID
								    INNER JOIN class          ON student.Class_ID    = class.ID
			                        INNER JOIN row_level      ON student.R_L_ID      = row_level.ID
			                        INNER JOIN class_table    ON class_table.RowLevelID = student.R_L_ID AND class_table.ClassID = student.Class_ID
								    WHERE contact.SchoolID    = '".$this->session->userdata('SchoolID')."'
								    AND contact.Isactive      = 1
									AND contact.Type          = 'S'
								    $whereClass
									$where
								    GROUP BY student.Contact_ID
									order by class.ID
							");			
		if($query->num_rows() >0)
		{return $query->result();}else{return FALSE ;}
	}
	/////////////////////
	public function get_positives($Lang = NULL)
	{
		$LangArray = array("Name"=>"Name_ar");
		if($Lang =='english'){$LangArray = array("Name"=>"Name_en");}
		
		$this->db->select("ID AS PositiveID,".$LangArray['Name']." AS PositiveName");
		$this->db->from('students_evaluation_items');
		$this->db->where('Type', 1 );
		
		$ResultPositives  = $this->db->get();			
		$NumRowPositives  = $ResultPositives->num_rows() ; 
		if($NumRowPositives != 0)
		  {
				$ReturnPositives = $ResultPositives ->result() ;
				return $ReturnPositives ;
		  }
		  else
		  {
			  return false ;
		  }
	}
	///////////////////
	public function get_notes($Lang = NULL)
	{
		$LangArray = array("Name"=>"Name_ar");
		if($Lang =='english'){$LangArray = array("Name"=>"Name_en");}
		
		$this->db->select("ID AS NoteID,".$LangArray['Name']." AS NoteName");
		$this->db->from('students_evaluation_items');
		$this->db->where('Type', 3 );
		
		$ResultNotes  = $this->db->get();			
		$NumRowNotes  = $ResultNotes->num_rows() ; 
		if($NumRowNotes != 0)
		  {
				$ReturnNotes = $ResultNotes ->result() ;
				return $ReturnNotes ;
		  }
		  else
		  {
			  return false ;
		  }
	}
	///////////////////
	public function get_behavior($Lang = NULL)
	{
		$LangArray = array("Name"=>"Name_ar");
		if($Lang =='english'){$LangArray = array("Name"=>"Name_en");}
		
		$this->db->select("ID AS BehaviorID,".$LangArray['Name']." AS BehaviorName");
		$this->db->from('students_evaluation_items');
		$this->db->where('Type', 2 );
		
		$ResultNotes  = $this->db->get();			
		$NumRowNotes  = $ResultNotes->num_rows() ; 
		if($NumRowNotes != 0)
		  {
				$ReturnNotes = $ResultNotes ->result() ;
				return $ReturnNotes ;
		  }
		  else
		  {
			  return false ;
		  }
	}
	/////////////////////
	public function get_eval_skills($Lang = NULL)
	{
		$LangArray = array("Name"=>"Name");
		if($Lang =='english'){$LangArray = array("Name"=>"Name_en");}
		
		$this->db->select("ID AS EvalSkillID,".$LangArray['Name']." AS EvalSkillName");
		$this->db->from('Eval_Skills');
		$this->db->where('Is_Active', 1 );
		
		$ResultSkills  = $this->db->get();			
		$NumRowSkills  = $ResultSkills->num_rows() ; 
		if($NumRowSkills != 0)
		  {
				$ReturnSkills = $ResultSkills ->result() ;
				return $ReturnSkills ;
		  }
		  else
		  {
			  return false ;
		  }
	}
	//////////////////////////
	public function students_evaluation_items($Data)
	{
	     extract($Data);

	       if($Lang == 'arabic'){ $Name = Name_ar;}else{$Name = Name_en;}
			$query = $this->db->query("
			 SELECT `ID`,".$Name." AS Name FROM `students_evaluation_items` WHERE `Type` = ".$eval_type."
			");
		if($query->num_rows() >0)
		{return $query->result();}else{return FALSE ;}
	}
	//////////////////////////
	public function get_exam_home_degree()
	{
			$query = $this->db->query("
			 SELECT `HomeDegree`,`TestMark` FROM `config_emp_school`
			");
		if($query->num_rows() >0)
		{return $query->row_array();}else{return FALSE ;}
	}
	//////////////////////////////////////
    public function add_student_abcent($data = array())
	{ 
	    extract($data);
	    if($CheckAttend){$Check = 2;}else{$Check = 1; }

		if ($multipleClass) {

			$query        = $this->db->query("SELECT `Class_ID`,`R_L_ID` FROM `student` WHERE `Contact_ID` =$StID ")->row_array();

			$ClassTable   = $this->db->query("SELECT `ID`  FROM `class_table` WHERE `multipleClass` = $multipleClass AND `RowLevelID`= ".$query['R_L_ID']." AND `ClassID`=".$query['Class_ID']." ")->row_array();

			$ClassTableID =  $ClassTable['ID'];
		}

		$this->db->query("
        INSERT INTO  students_evaluation
        SET
        StudentID      = '".$StID."' ,
        TeacherID      = '".$this->session->userdata('id')."' ,
        ClassTableID   = '".$ClassTableID."' ,
        Absence_class  = '".$Check."' ,
        Delay_class    = '".$CheckDelay."' ,
        notes          = '".$note."' ,
        Date           = '".$Date."' ,
        Date_stm       = '".$Timezone."' 
         ");
		
        return TRUE ;
	}
	//////////////////////////
	public function checkStudent($date,$StID,$SubjectID)
	{ 
		$query = $this->db->query(" SELECT * FROM `students_behavior` WHERE `Date` = '".$date."' AND `StudentID` = $StID AND `SubjectID`= $SubjectID ")->row_array();
    
    	return $query;
	}
	//////////////////////////////////////
    public function add_student_evaluation($data = array())
	{ 
	    extract($data);
	    if($edit == 1){$IsUpdate = 1;}else{$IsUpdate = 0;}
	    if($eval_type == 1){$eval = 'PositiveID';}
	    if($eval_type == 2){$eval = 'NoteID';}
	    if($eval_type == 3){$eval = 'BehaviorID';}
	    if($eval_type == 4){
			if($skills_id != 0){
				$checkStu = $this->db->query(" SELECT * 
                                                      FROM `students_behavior` 
                                                      WHERE `Date` = '".$date."' 
                                                      AND `StudentID` = $StID 
                                                      AND `SubjectID`= $SubjectID 
                                                      AND SkillsID   = IFNULL(".$skills_id.", SkillsID)
													  AND semester_id = $semester_id
													  AND year_id     = $YearID
                                                      ")->row_array();
			}else{
				$checkStu = $this->db->query(" SELECT * 
                                                      FROM `students_behavior` 
                                                      WHERE `Date` = '".$date."' 
                                                      AND `StudentID` = $StID 
                                                      AND `SubjectID`= $SubjectID 
                                                      AND (SkillsID   = NULL OR SkillsID   = 0)
													  AND semester_id = $semester_id
													  AND year_id     = $YearID
                                                      ")->row_array();
			}
	        $eval = 'SkillsEval';
	        
	        $update = "lesson_prepID  = '".$lesson_id."',
                      SkillsID       = '".$skills_id."',";

			 $where	= "AND lesson_prepID  = '".$lesson_id."'
			           AND SkillsID   = '".$skills_id."'";
	    }
	    // print_r($checkStu);die;
	    if($checkStu['ID'] == ""){
		$this->db->query("
        insert into `students_behavior`
        SET
        StudentID      = '".$StID."',
        TeacherID      = '".$this->session->userdata('id')."' ,
        $eval          = '".$eval_item_id."' ,
		$update
        SubjectID      = '".$SubjectID."',
		semester_id    = $semester_id,
		year_id        = $YearID,
        Date           = '".$date."',
        Date_stm       = '".$Timezone."' 
         ");
	    }else{
	       $this->db->query(" 
	        UPDATE `students_behavior`
            SET
            TeacherID      = '".$this->session->userdata('id')."' ,
            $eval          = '".$eval_item_id."' ,
            $update
            Date_stm       = '".$Timezone."'
            WHERE
            StudentID       = '".$StID."'
            AND SubjectID   = '".$SubjectID."'
			AND semester_id = $semester_id
			AND year_id     = $YearID
            AND Date        = '".$date."'
			$where
	         ");
	    }
        return TRUE ;
	}
	//////////////////////////
	public function get_group_day($data)
	{
	    extract($data);
			$query = $this->db->query("
			 SELECT `group_day` 
			 FROM `lesson` 
			 INNER JOIN class_table ON class_table.Lesson = lesson.ID 
			 WHERE class_table.ID = '".$ClassTableID."' 
			")->row_array();
		
		return $query['group_day'];
		
	}
	//////////////////////////
	public function CheckEval($ClassTableID,$StudentID,$Eval_date,$multipleClass)
	{
		if ($multipleClass) {

			$query        = $this->db->query("SELECT `Class_ID`,`R_L_ID` FROM `student` WHERE `Contact_ID` =$StudentID ")->row_array();

			$ClassTable   = $this->db->query("SELECT `ID`  FROM `class_table` WHERE `multipleClass` = $multipleClass AND `RowLevelID`= ".$query['R_L_ID']." AND `ClassID`=".$query['Class_ID']." ")->row_array();

			$ClassTableID =  $ClassTable['ID'];
		}
			$query = $this->db->query("
			 SELECT `StudentID`,`ClassTableID`, contact.Name AS StudentName,students_evaluation.*
               FROM `students_evaluation` 
               INNER JOIN contact        ON contact.ID = students_evaluation.StudentID
               WHERE `ClassTableID` = $ClassTableID
               AND    StudentID = '".$StudentID."'
               AND `Date` = '$Eval_date' 
               AND  (`PositiveID` IS NOT null OR `NoteID` IS NOT null OR `BehaviorID` IS NOT null 
                      OR `skills` IS NOT null OR `HomeDegree` IS NOT null OR `TestMark` IS NOT null 
                      OR `PostsCount` IS NOT null) 
                AND `Absence_class`!=1
			")->row_array();
		
		return $query;
		
	}
	//////////////////////////
	public function CheckClass($ClassTableID,$StudentID,$Eval_date,$multipleClass)
	{
		if ($multipleClass) {

			$query        = $this->db->query("SELECT `Class_ID`,`R_L_ID` FROM `student` WHERE `Contact_ID` =$StudentID ")->row_array();

			$ClassTable   = $this->db->query("SELECT `ID`  FROM `class_table` WHERE `multipleClass` = $multipleClass AND `RowLevelID`= ".$query['R_L_ID']." AND `ClassID`=".$query['Class_ID']." ")->row_array();

			$ClassTableID =  $ClassTable['ID'];
		}
			$query = $this->db->query("
			   SELECT `Absence_class`,`Delay_class`, 
			   CASE
            WHEN '$Lang' = 'english' and contact.Name_en IS not NULL and contact.Name_en !=' ' THEN contact.Name_en
            ELSE contact.Name
            END AS StudentName 
               FROM `students_evaluation` 
               INNER JOIN contact        ON contact.ID = students_evaluation.StudentID
               WHERE `ClassTableID` = $ClassTableID 
               AND `StudentID`= $StudentID 
               AND `Date` = '$Eval_date' 
               AND  Absence_class IN (1,2)
               AND ClassTableID IS NOT NULL
			   order by StudentName
			")->row_array();
		
		return $query;
		
	}
	//////////////////////////
	public function CheckDay($StudentID,$Eval_date)
	{
			$query = $this->db->query("
			   SELECT `absence_day`
               FROM `students_evaluation` 
               WHERE `StudentID`= $StudentID 
               AND `Date` = '$Eval_date' 
               AND  absence_day = 1
			")->row_array();
		
		return $query;
		
	}
	//////////////////////////
	public function get_student_data($ClassTableID,$StudentID,$Eval_date)
	{
			$query = $this->db->query("
			 SELECT * 
			 FROM `students_evaluation` 
			 WHERE `ClassTableID` = $ClassTableID AND `StudentID` = $StudentID AND `Date` = '$Eval_date'
			")->row_array();
		
		return $query;
		
	}
	//////////////////////////////////////
    public function update_student_absent($data = array())
	{ 
	    extract($data);
	    if($CheckAttend){$Check = 2;}else{$Check = 1 ; $CheckDelay = 0; }

		if ($multipleClass) {

			$query        = $this->db->query("SELECT `Class_ID`,`R_L_ID` FROM `student` WHERE `Contact_ID` =$StID ")->row_array();

			$ClassTable   = $this->db->query("SELECT `ID`  FROM `class_table` WHERE `multipleClass` = $multipleClass AND `RowLevelID`= ".$query['R_L_ID']." AND `ClassID`=".$query['Class_ID']." ")->row_array();

			$ClassTableID =  $ClassTable['ID'];
		}

		$this->db->query("
        UPDATE students_evaluation
        SET
        TeacherID      = '".$this->session->userdata('id')."' ,
        Absence_class  = '".$Check."' ,
        Delay_class    = '".$CheckDelay."',
        IsUpdate       = 1,
        Date_stm       = '".$Timezone."' 
        WHERE ClassTableID   = '".$ClassTableID."' 
        AND   StudentID      = '".$StID."' 
        AND   Date           = '".$Date."' 
        
         ");
		
        return TRUE ;
	}
	////////////////////
	public function delete_student_absent($data)
	{
	    extract($data);

		if ($multipleClass) {

			$query        = $this->db->query("SELECT `Class_ID`,`R_L_ID` FROM `student` WHERE `Contact_ID` =$StudentID ")->row_array();

			$ClassTable   = $this->db->query("SELECT `ID`  FROM `class_table` WHERE `multipleClass` = $multipleClass AND `RowLevelID`= ".$query['R_L_ID']." AND `ClassID`=".$query['Class_ID']." ")->row_array();

			$ClassTableID =  $ClassTable['ID'];
		}
	    
        $this->db->query("
		DELETE FROM `students_evaluation` 
		WHERE ClassTableID   = '".$ClassTableID."' 
        AND   StudentID      = '".$StudentID."' 
        AND   Date           = '".$Eval_date."' 
		");
	}
	//////////////////////////////////////
    public function delete_student_evaluation($data = array())
	{ 
	    extract($data);

		$this->db->query(" DELETE FROM `students_behavior` WHERE `ID` =  '".$EvalID."' ");
		
        return TRUE ;
	}
	//////////////////////////
	public function get_all_Stu_Data($data = array())
	{
	    extract($data); 

		if ($multipleClass) {

			$classes    = $this->db->query("SELECT GROUP_CONCAT(class_table.ClassID) AS classID , RowLevelID FROM `class_table` WHERE `multipleClass` = $multipleClass ")->row_array();
			
			$whereClass = " student.R_L_ID = ".$classes['RowLevelID']." AND student.Class_ID   IN(".$classes['classID'].")";
		}else {

			$whereClass = " ClassTableID = $ClassTableID";
		}       
		    
	    
			$query = $this->db->query("
			 SELECT students_evaluation.* , 
			 CASE
            WHEN '$Lang' = 'english' and contact.Name_en IS not NULL and contact.Name_en !=' ' THEN contact.Name_en
            ELSE contact.Name
            END AS StudentName 
			 ,
			 CONCAT(row_level.Level_Name,'-',row_level.Row_Name,'-',class.Name) AS studentClass
			 FROM `students_evaluation` 
			 INNER JOIN contact        ON contact.ID = students_evaluation.StudentID
             INNER JOIN student        ON students_evaluation.StudentID = student.Contact_ID
             INNER JOIN class          ON student.Class_ID    = class.ID
			 INNER JOIN row_level      ON student.R_L_ID      = row_level.ID
             INNER JOIN class_table    ON students_evaluation.ClassTableID = class_table.ID AND class_table.RowLevelID = student.R_L_ID AND class_table.ClassID = student.Class_ID
			 WHERE $whereClass
			 and    students_evaluation.`Date`       = '".$Eval_date."'
			 order by class.ID
			")->result();
		
		return $query;
		
	}
	/////////////////////
    //////////////////////////nada
	public function get_subjects_emp($Lang , $data = array())
	{
	    extract($data);
			$query = $this->db->query("
			 SELECT
			 level.Name          AS LevelName,
			 row.Name            AS RowName,
			 row_level.ID        AS RowLevelID,
			 subject.ID          AS SubjectID,
			 subject.Name        AS SubjectName
			 FROM
			  class_table
			  INNER JOIN subject          ON class_table.SubjectID   = subject.ID
			  INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
			  INNER JOIN row              ON row_level.Row_ID       = row.ID
			  INNER JOIN level            ON row_level.Level_ID     = level.ID
			  WHERE class_table.EmpID = ".$UID." AND class_table.SubjectID = ".$SubjectID."
              GROUP BY class_table.SubjectID
			");
		if($query->num_rows() >0)
		{return $query->result();}else{return FALSE ;}
	}
	//////////////////////////////////
	public function get_skills_student($data = array())
	{
		extract($data);
		$query = $this->db->query("SELECT skills.*
			  from skills 
              INNER JOIN lesson_prep ON lesson_prep.skillsID = skills.ID
			  INNER JOIN config_semester ON config_semester.ID = skills.termID AND '".$date."' BETWEEN config_semester.start_date AND config_semester.end_date
 		      where skills.IsActive = 1
			  AND skills.RowLevelID = '".$RowLevelID."' 
			  AND skills.SubjectID  = '".$SubjectID."'
			  AND skills.termID     = '".$semester_id."'
			  AND skills.year_id    = '".$YearID."'
              AND lesson_prep.ID    = '".$lesson_id."'
			  
              GROUP BY skills.ID
              order BY skills.ID DESC ")->result();
        if(sizeof($query)<= 0){      
        $query = $this->db->query("select  
			  skills.*
			  from skills 
			  INNER JOIN config_semester ON config_semester.ID = skills.termID AND '".$date."' BETWEEN config_semester.start_date AND config_semester.end_date
 		      where skills.IsActive = 1
			  AND skills.RowLevelID = '".$RowLevelID."' 
			  AND skills.SubjectID  = '".$SubjectID."'
			  AND skills.termID     = '".$semester_id."'
			  AND skills.year_id    = '".$YearID."'
              order BY skills.ID DESC  ")->result();
        }
        if(sizeof($query)> 0 ){return $query;}else{return 0 ;return FALSE ;}
	}
	//////////////////////////////////
	public function skillsType($Lang)
	{
	    if($Lang == 'arabic'){ $Name = name;}else{$Name = name_en;}
        $query = $this->db->query("  
			 SELECT `ID`,skills_type.".$Name."  AS Name 
			 FROM `skills_type` 
			 WHERE `is_active` = 1 ")->result();
        if(sizeof($query)> 0 ){return $query;}else{return 0 ;return FALSE ;}
	}
	////////////////////////////////
	public function get_lessons_prep($data=array())
	{
		extract($data);
		$this->db->select('lesson_prep.ID AS LessonID , lesson_prep.classID AS LessonclassID, lesson_prep.Lesson_Title AS LessonTitle ,lesson_prep.Date AS LessonDate , lesson_prep.Token AS LessonToken ,lesson_prep.RowLevel_ID ,lesson_prep.Subject_ID' );
		$this->db->from('lesson_prep');
		$this->db->join('config_semester', 'config_semester.start_date <= lesson_prep.date_from AND config_semester.end_date >= lesson_prep.date_to');
		$this->db->where('lesson_prep.RowLevel_ID', $RowLevelID );
		$this->db->where('lesson_prep.Subject_ID', $SubjectID );
		$this->db->where('lesson_prep.classID', $class_id );
		$this->db->where('lesson_prep.Teacher_ID', $UID );	
		$this->db->where('config_semester.ID', $semester_id );
		$this->db->where('lesson_prep.School_ID', $this->session->userdata('SchoolID') );
		$ResultLessons = $this->db->get();
		$NumRowResultLessons  = $ResultLessons->num_rows() ; 
		if($NumRowResultLessons != 0)
		  {
				$ReturnLessons = $ResultLessons ->result() ;
				return $ReturnLessons ;
		  }
		  else
		  {
			  return false ;
		  }
	}
	////////////////////////////
	public function get_skills()
	{
		$GetData = $this->db->query("
		SELECT 
		*
		FROM 
		config_emp_school
		WHERE  SchoolID = '".$this->session->userdata('SchoolID')."'  
		");
		if($GetData->num_rows()>0){return $GetData->row_array();}else{return FALSE ; }
	}
	////////////////////////////
	public function get_emp_config()
	{
		$GetData = $this->db->query("
		SELECT 
		*
		FROM 
		config_emp_school
		WHERE  SchoolID = '".$this->session->userdata('SchoolID')."'  
		");
		if($GetData->num_rows()>0){return $GetData->row_array();}else{return FALSE ; }
	}
	//////////////////////////////
	
	public function get_student_eval($StudentID,$subjectID,$RowLevelID)
	{
	
	$teacherID = $this->session->userdata('id');
	
	$Lang = $this->session->userdata('language');
	
	$NameArray = array("Level"=>"Name AS LevelName" ,"row"=>"Name AS RowName" , "class"=>"Name AS ClassName", "lesson"=>"lesson AS lessonName");
	if($Lang == "english")
	{
		$NameArray = array("Level"=>"Name_en AS LevelName" ,"row"=>" Name_en AS RowName" , "class"=>"Name_en AS ClassName", "lesson"=>"Lesson_en AS lessonName");
	}
	
	$query = $this->db->query("
	SELECT
		tb1.ID AS StudentID,
		tb1.Name AS StudentName,
		lesson_prep.Lesson_Title,
		tb1.Name AS FullName ,
		students_evaluation.ID AS EvalID , 
		lesson_prep.ID AS lessonID ,
		students_evaluation.HomeDegree AS HomeDegree , 
		students_evaluation.Absence AS EvalAbsence,
		students_evaluation.PostsCount AS EvalPosts,
		students_evaluation.TestMark AS TestMark,
		students_evaluation.skills ,
		skills.name AS skillsname ,
		students_evaluation.Delay ,
		students_evaluation.skillsType ,
		skills_type.name AS skills_typeName,
		students_evaluation.StudentID ,
		students_evaluation.MOreNote,
		students_evaluation.HomeDegree ,
		students_evaluation.StudentID AS StudentContactID, 
		students_evaluation.TeacherID, students_evaluation.SubjectID, 
		students_evaluation.Lesson, 
		students_evaluation.Date AS EvalDate, 
		students_evaluation.PositiveID AS EvalPositiveID, 
		students_evaluation.NoteID AS EvalNoteID ,
		subject.Name AS subjectName ,
		subject.ID  AS subjectID ,
		student.R_L_ID AS R_L_ID ,
		student.Class_ID AS Class_ID ,
		tb3.Name AS TeacherName,
		students_evaluation_items.Name_ar  as PositiveName,
		stu_item.Name_ar as noteName
	FROM contact As tb1
	INNER JOIN student 				ON tb1.ID = student.Contact_ID
	INNER JOIN students_evaluation 	ON students_evaluation.StudentID = tb1.ID
	INNER JOIN contact AS tb3 		ON tb3.ID = students_evaluation.TeacherID
	INNER JOIN subject		 		ON subject.ID = students_evaluation.SubjectID
	left JOIN lesson_prep		    ON lesson_prep.ID = students_evaluation.lesson_prepID
	left JOIN students_evaluation_items ON students_evaluation_items.ID = students_evaluation.PositiveID
	left JOIN students_evaluation_items AS stu_item ON stu_item.ID = students_evaluation.NoteID
	left JOIN skills               ON skills.ID = students_evaluation.skills
	left JOIN skills_type          ON skills_type.ID = students_evaluation.skillsType
	WHERE students_evaluation.StudentID = '".$StudentID."'
	AND students_evaluation.TeacherID = '".$teacherID."'
	AND subject.ID = '".$subjectID."'
	AND R_L_ID = '".$RowLevelID."'
	AND ((students_evaluation.Delay IS NOT NULL AND students_evaluation.Absence = 0)
	
    OR  (students_evaluation.Absence =1 AND students_evaluation.Delay IS NULL))
	");
		if($query->num_rows()>0)
		{
			return $query->result();
		}else{return false ;}
	}
	/////////////////////////////////
	public function get_Mark()
	 {
		$this->db->select('Name AS TheMark');
        $this->db->from('name_space');
        $this->db->where('Parent_ID', 4 );
		$ResultMark = $this->db->get();			
		$NumRowMark = $ResultMark->num_rows() ; 
			if($NumRowMark > 0)
			  {
				$ReturnMark     = $ResultMark->row_array() ;
			    return $ReturnMark ; 
			  }else{ return $NumRowMark ; return FALSE ;}
	 }
	 /////////////////////////////////
	public function get_student_eval_data($Data)
    {
        extract($Data);
	    $query = $this->db->query("SELECT students_behavior.*, contact.Name AS StudentName , row_level.Level_Name,
    	                           row_level.Row_Name,class.Name as ClassName, subject.Name AS SubjectName,lesson_prep.Lesson_Title ,
    	                           skills.name AS SkillName
    	                           FROM `students_behavior` 
    	                           INNER JOIN student ON student.Contact_ID = students_behavior.StudentID 
    	                           INNER JOIN contact ON contact.ID = student.Contact_ID 
    	                           INNER JOIN row_level ON row_level.ID = student.R_L_ID
    	                           INNER JOIN subject ON subject.ID = students_behavior.SubjectID
    	                           INNER JOIN class ON class.ID = student.Class_ID
    	                           LEFT  JOIN lesson_prep ON lesson_prep.ID = students_behavior.lesson_prepID
                                   LEFT  JOIN skills ON skills.ID = students_behavior.SkillsID
                                   INNER JOIN config_semester  ON config_semester.ID=$SemesterID AND students_behavior.Date  BETWEEN config_semester.start_date AND config_semester.end_date 
    	                           WHERE student.R_L_ID = $RowLevelID 
    	                           AND students_behavior.SubjectID = $SubjectID
    	                           AND students_behavior.TeacherID = $UID
                            	")->result();
	
	return $query ;
	
   }
   /////////////////////////////////
	public function get_eval_name($Lang,$PositiveID)
    {

        if($Lang == 'arabic'){ $Name = Name_ar;}else{$Name = Name_en;}
			$query = $this->db->query(" SELECT `ID`,".$Name." AS Name FROM `students_evaluation_items` WHERE `ID` IN($PositiveID)")->result();
	
	return $query ;
	
   }
   ////////////////////////
   public function get_EvalNum($StudentID,$subjectID)
	{
		$teacherID = $this->session->userdata('id');
		
		$query = $this->db->query("
	    SELECT
	    students_evaluation.*
	    FROM contact As tb1
	    INNER JOIN student 				ON tb1.ID = student.Contact_ID
	    INNER JOIN contact AS tb2 		ON student.Father_ID = tb2.ID
	    INNER JOIN students_evaluation 	ON students_evaluation.StudentID = tb1.ID
	    INNER JOIN contact AS tb3 		ON tb3.ID = students_evaluation.TeacherID
	    INNER JOIN subject		 		ON subject.ID = students_evaluation.SubjectID
	    left JOIN lesson_prep		    ON lesson_prep.ID = students_evaluation.lesson_prepID
	    WHERE students_evaluation.StudentID = '".$StudentID."'
	    AND students_evaluation.TeacherID = '".$teacherID."'
	    and students_evaluation.SubjectID='".$subjectID."'
	    AND tb1.SchoolID = '".$this->session->userdata('SchoolID')."'
	    AND ((students_evaluation.Delay IS NOT NULL AND students_evaluation.Absence = 0)
        OR  (students_evaluation.Absence =1 AND students_evaluation.Delay IS NULL))
	");
		$NumRowResultData  = $query->num_rows() ; 
		return $NumRowResultData ;
	}
	////////////////////////
	////////////////////
	public function dele_studentpage($id)
	{
        $this->db->query("
		delete  FROM students_evaluation where ID=".$id."
		");
	}
	 //////////////////////////////////////nada
	 ///////////////////////get_evaluation
	 public function get_evaluation($RowLevel = 0  , $ClassID = 0 , $SubjectID = 0 ,$Date = NULL  )
	 {
		 $query = $this->db->query(" 
		 SELECT 
		 students_evaluation.*
		 FROM 
		 students_evaluation
		 INNER JOIN student ON students_evaluation.StudentID = student.Contact_ID
		  
		 WHERE 
		 students_evaluation.SubjectID  = '".$SubjectID."'
		 AND 
		 student.R_L_ID                 = '".$RowLevel."'
		 AND
		 student.Class_ID	            = '".$ClassID."'  
		 AND
		 DATE(students_evaluation.Date ) = '".$Date."'
		 AND 
		 students_evaluation.TeacherID   = '".$this->session->userdata('id')."' 
		  ")->row_array();
		  if(sizeof($query)>0){return $query ; }else{return false ; }
	 }
	//////get_emp_class
	public function get_emp_class($Lang = NULL , $UID = 0)
	{
		if($Lang == 'arabic')
		{
			$query = $this->db->query("
			 SELECT 
			 class_table.ID AS ClassTableID ,
			 level.Name     AS LevelName,
			 row.Name       AS RowName,
			 row_level.ID   AS RowLevelID,
			 class.ID       AS ClassID,
			 class.Name     AS ClassName
			 FROM 
			 class_table
			 INNER JOIN base_class_table ON class_table.BaseTableID = base_class_table.ID
			 INNER JOIN class            ON class_table.ClassID     = class.ID
			 INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
			 INNER JOIN row              ON row_level.Row_ID        = row.ID
			 INNER JOIN level            ON row_level.Level_ID      = level.ID
			 WHERE base_class_table.IsActive = 1 
			 AND   class_table.EmpID = ".$UID."
			 GROUP BY class_table.RowLevelID , class_table.ClassID
			");
		}
		else{
			   $query = $this->db->query("
				 SELECT 
				 class_table.ID AS ClassTableID ,
				 level.Name_en  AS LevelName,
				 row.Name_en    AS RowName,
				 row_level.ID   AS RowLevelID,
				 class.ID       AS ClassID,
				 class.Name_en  AS ClassName
				 FROM 
				 class_table
				 INNER JOIN base_class_table ON class_table.BaseTableID = base_class_table.ID
				 INNER JOIN class            ON class_table.ClassID     = class.ID
				 INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
				 INNER JOIN row              ON row_level.Row_ID        = row.ID
				 INNER JOIN level            ON row_level.Level_ID      = level.ID
				 WHERE base_class_table.IsActive = 1 
				 AND   class_table.EmpID = ".$UID."
				 GROUP BY class_table.RowLevelID , class_table.ClassID
				");
			}
			  if($query->num_rows() >0)
			  {return $query->result();}else{return FALSE ;}
	}
	
	//////get_emp_class_subjects
	public function get_emp_class_subject($data)
	{
		extract($data);
		$this->db->select('class_table.SubjectID AS SubjectID ,subject.Name AS SubjectName');
		$this->db->from('class_table');
		$this->db->join('subject', 'subject.ID = class_table.SubjectID');
		$this->db->join('base_class_table', 'base_class_table.ID = class_table.BaseTableID');
		$this->db->where('class_table.EmpID', $UID);
		$this->db->where('class_table.RowLevelID', $RowLevelID);
		$this->db->where('class_table.ClassID', $ClassID);
		$this->db->where('base_class_table.IsActive', 1 );
		$this->db->group_by('class_table.SubjectID'); 
		
		$Subjects = $this->db->get();

		if($Subjects->num_rows()>0)
		{
			return $Subjects->result();
		}else{return FALSE ;}
	}

	////////////get_emp_subjects
	public function get_emp_subjects($Lang = NULL , $UID = 0)
	{
		if($Lang == 'arabic')
		{
			$query = $this->db->query("
			 SELECT
			 level.Name     AS LevelName,
			 row.Name       AS RowName,
			 row_level.ID   AS RowLevelID,
			 subject.ID     AS SubjectID,
			 subject.Name   AS SubjectName
			 FROM
			  class_table
			  INNER JOIN subject          ON class_table.SubjectID   = subject.ID
			  INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
			  INNER JOIN row              ON row_level.Row_ID       = row.ID
			  INNER JOIN level            ON row_level.Level_ID     = level.ID

			  WHERE class_table.EmpID = ".$UID."
                         GROUP BY class_table.SubjectID
			");
		}
		else{
			$query = $this->db->query("
				 SELECT
				 level.Name_en   AS LevelName,
				 row.Name_en     AS RowName,
				 row_level.ID    AS RowLevelID,
				 subject.ID      AS SubjectID,
				 subject.Name    AS SubjectName
				 FROM
				 class_table
				 INNER JOIN subject          ON class_table.SubjectID   = subject.ID
				 INNER JOIN row_level        ON class_table.RowLevelID  = row_level.ID
				 INNER JOIN row              ON row_level.Row_ID       = row.ID
				 INNER JOIN level            ON row_level.Level_ID     = level.ID

			         WHERE class_table.EmpID = ".$UID."
                                 GROUP BY class_table.SubjectID
				");
		}
		if($query->num_rows() >0)
		{return $query->result();}else{return FALSE ;}
	}
	
	//////get_emp_class_subjects
	public function get_class_subjects($UID = 0 , $RowLevelID = 0 , $ClassID = 0 , $SubjectID = 0 )
	{
		$this->db->select('class_table.SubjectID AS SubjectID ,subject.Name AS SubjectName');
		$this->db->from('class_table');
		$this->db->join('subject', 'subject.ID = class_table.SubjectID');
		$this->db->join('base_class_table', 'base_class_table.ID = class_table.BaseTableID');
		$this->db->where('class_table.EmpID', $UID);
		$this->db->where('class_table.RowLevelID', $RowLevelID);
		$this->db->where('class_table.ClassID', $ClassID);
		$this->db->where('class_table.SubjectID', $SubjectID);
		$this->db->where('base_class_table.IsActive', 1 );
		$this->db->group_by('class_table.SubjectID'); 
		
		$Subjects = $this->db->get();
		if($Subjects->num_rows()>0)
		{
			return $Subjects->result();
		}else{return FALSE ;}
	}
	
//////get_emp_class_subjects
	public function get_class_emp_android($UID = 0 , $RowLevelID = 0 , $ClassID = 0 )
	{
		$this->db->select('class_table.SubjectID AS SubjectID ,subject.Name AS SubjectName');
		$this->db->from('class_table');
		$this->db->join('subject', 'subject.ID = class_table.SubjectID');
		$this->db->join('base_class_table', 'base_class_table.ID = class_table.BaseTableID');
		$this->db->where('class_table.EmpID', $UID);
		$this->db->where('class_table.RowLevelID', $RowLevelID);
		$this->db->where('class_table.ClassID', $ClassID);

		$this->db->where('base_class_table.IsActive', 1 );
		$this->db->group_by('class_table.SubjectID'); 
		// $Where  = array('class_table.RowLevelID'=>$R_L_ID,'class_table.ClassID'=>$Class_ID,'class_table.SchoolID'=>$data['SchoolID'] );
		$Subjects = $this->db->get();
		if($Subjects->num_rows()>0)
		{
			return $Subjects->result();
		}else{return FALSE ;}
	}

	//////get_emp_class
	public function get_emp_classTTTT($Lang = NULL , $UID = 0)
	{
		$LangArray = array("Name"=>"Name");
		if($Lang =='english'){$LangArray = array("Name"=>"Name_en");}
		$this->db->select("ID,".$LangArray['Name'].",Contact_ID,Token");
		$this->db->from('level');
		$this->db->where('Is_Active', 1);
		$ActiveLevels = $this->db->get();
		if($ActiveLevels->num_rows()>0)
		{
		return $ActiveLevels->result();
		}else{return FALSE ;}
	}
	
	//////get_emp_class
	public function get_table_lessons($Lang = NULL)
	{
		$LangArray = array("Name"=>"lesson");
		if($Lang =='english'){$LangArray = array("Name"=>"Lesson_en");}
		$this->db->select("ID AS LessonID,".$LangArray['Name']." AS LessonName");
		$this->db->from('lesson');
		$TableLessons = $this->db->get();
		if($TableLessons ->num_rows()>0)
		{
		return $TableLessons ->result();
		}else{return FALSE ;}
	}

	

	//////get_class_Students
	public function get_class_students_android($data)
	{
		extract($data);
				
		$ResultClassStudents = $this->db->query("SELECT
								tb1.ID AS StudentID,
							    (case when tb1.Img is null then '' else tb1.Img end) as img , 
								tb1.Name AS StudentName,
								tb2.ID AS FatherID ,
								tb2.Name AS FatherName ,
								CONCAT(tb1.Name,' ',tb2.Name) AS FullName
								FROM contact As tb1
												
								INNER JOIN student ON tb1.ID = student.Contact_ID
								INNER JOIN contact AS tb2 ON student.Father_ID = tb2.ID
												
								WHERE student.Class_ID = ".$ClassID."
								AND student.R_L_ID = ".$RowLevelID."
								AND tb1.SchoolID   = ".$SchoolID."
								AND tb1.Isactive = 1

							");	
		$NumRowClassStudents  = $ResultClassStudents->num_rows() ; 
		if($NumRowClassStudents != 0)
		  {
				$ReturnClassStudents = $ResultClassStudents ->result() ;
				return $ReturnClassStudents ;
		  }
		  else
		  {
			  return false ;
		  }
	}
	//////get_Positives for Android
	public function get_positives_and($Lang = NULL)
	{
		$LangArray = array("Name"=>"Name_ar");
		if($Lang =='en'){$LangArray = array("Name"=>"Name_en");}
		
		$this->db->select("ID AS PositiveID,".$LangArray['Name']." AS PositiveName");
		$this->db->from('students_evaluation_items');
		$this->db->where('Type', 1 );
		
		$ResultPositives  = $this->db->get();			
		$NumRowPositives  = $ResultPositives->num_rows() ; 
		if($NumRowPositives != 0)
		  {
				$ReturnPositives = $ResultPositives ->result() ;
				return $ReturnPositives ;
		  }
		  else
		  {
			  return false ;
		  }
	}
	//////get_Notes for Android
	public function get_notes_and($Lang = NULL)
	{
		$LangArray = array("Name"=>"Name_ar");
		if($Lang =='en'){$LangArray = array("Name"=>"Name_en");}
		
		$this->db->select("ID AS NoteID,".$LangArray['Name']." AS NoteName");
		$this->db->from('students_evaluation_items');
		$this->db->where('Type', 2 );
		
		$ResultNotes  = $this->db->get();			
		$NumRowNotes  = $ResultNotes->num_rows() ; 
		if($NumRowNotes != 0)
		  {
				$ReturnNotes = $ResultNotes ->result() ;
				return $ReturnNotes ;
		  }
		  else
		  {
			  return false ;
		  }
	}
	
	//////Add
	public function add_evalution($Timezone)
	{
		$TeacherID 		     = (int)$this->session->userdata('id');
		$StudentsNum	     = (int)$this->input->post('StudentsNum');
		$SubjectID 		     = (int)$this->input->post('SubjectID');
		$tableLessonID 	     = (int)$this->input->post('tableLessonID');
		$skills 	         = (int)$this->input->post('skills');
		$RowLevelID 	     = (int)$this->input->post('RowLevelID');
		$Date 		         = $this->input->post('DayDate');
		$TestMarkDefault 	 = (int)$this->input->post('TestMarkDefault');
		$HomeDegreeDefault 	 = (int)$this->input->post('HomeDegreeDefault');
		$count  = 1 ; 
		
		while($count <= $StudentsNum)
		{
			$StudentID 	 = (int)$this->input->post('StudentID'.$count);
			$Absence 	 = (int)$this->input->post('StAbsence'.$count);
			$Posts 		 = (int)$this->input->post('StPosts'.$count);
			$TestMark	 = $this->input->post('TestMark'.$count);
			$Positive 	 = (int)$this->input->post('PositiveID'.$count);
			$Note 		 = (int)$this->input->post('NoteID'.$count);
			$HomeDegree	 = $this->input->post('HomeDegree'.$count);
			$skil_active =  $this->input->post('skil_active'.$count);
			$MOreNote    =  $this->input->post('MOreNote_'.$count);
			$Delay       =  $this->input->post('Delay_'.$count);
			$lessonsID   = $this->input->post('lessonsID'.$count);
			if($Positive!=0 && ($Note==0 ||$Note==-1)){$points="1";}
			elseif($Note!=0 && $Note!=-1 && $Positive==0){$points="-1";} 
			elseif($Note!=0 && $Note!=-1 && $Positive!=0){$points="0";}
			else{$points=NULL;}
// 			print_R($TestMark);die;
			if($Posts!=0 || $Absence!=0 || $TestMark!=0 ||$Positive!=0 || $Note!=0 || $MOreNote!=""||
			$tableLessonID!=0 || $HomeDegree!=0 || $skills!=0 ||$skil_active!=0 || $lessonsID!=0 || $Delay!=0)
			{
  			$DataInsert  = array(
							 "HomeDegreeDefault" =>$HomeDegreeDefault ,
							 "TestMarkDefault"   =>$TestMarkDefault ,
							 "StudentID"         =>$StudentID ,
							 "Absence"           =>$Absence ,
							 "PostsCount"        =>$Posts ,
							 "TestMark"   	     =>$TestMark ,
							 "PositiveID"        =>$Positive ,
							 "NoteID"    	     =>$Note ,
							 "TeacherID"         =>$TeacherID ,
							 "SubjectID"         =>$SubjectID ,
							 "MOreNote"          =>$MOreNote , 
							 "Lesson" 		     =>$tableLessonID ,
							 "HomeDegree"        =>$HomeDegree ,
							 "skills" 	         =>$skills ,
							 "skillsType"        =>$skil_active,
							 "Date"    	         =>$Date,
							 "lesson_prepID"     =>$lessonsID,
							 "Delay"             =>$Delay,
							 "Points"            =>$points,
							 "Date_stm"          =>$Timezone
							 );
				// 	print_r($DataInsert);die;		 
		 	$this->db->insert('students_evaluation',$DataInsert);
			}
			
			$count ++;
		}
		 return TRUE ;
	}
	//////Add
	public function update_eval($Timezone)
	{
		$TeacherID 		= (int)$this->session->userdata('id');
		$StudentsNum	= (int)$this->input->post('StudentsNum');
		$SubjectID 		= (int)$this->input->post('SubjectID');
		$tableLessonID 	= (int)$this->input->post('tableLessonID');
		$skills 	    = (int)$this->input->post('skills');
		$RowLevelID 	 = (int)$this->input->post('RowLevelID');
		$Date 			= $this->input->post('DayDate');
		$count  = 0 ; 
		while($count <= $StudentsNum)
		{
			$EvalID  	 = (int)$this->input->post('EvalID_'.$count);
			$StudentID 	 = (int)$this->input->post('StudentID'.$count);
			$Absence 	 = (int)$this->input->post('StAbsence'.$count);
			$Posts 		 = (int)$this->input->post('StPosts'.$count);
			$TestMark	 = (int)$this->input->post('TestMark'.$count);
			$Positive 	 = (int)$this->input->post('PositiveID'.$count);
			$Note 		 = (int)$this->input->post('NoteID'.$count);
			$HomeDegree	 = (int)$this->input->post('HomeDegree'.$count);
			$skil_active =  $this->input->post('skil_active'.$count);
			$MOreNote    =  $this->input->post('MOreNote_'.$count);
			$Delay       =  $this->input->post('Delay_'.$count);
		//print_r( $this->input->post());exit ; 
  			$DataInsert  = array(
							 "Absence"      =>$Absence ,
							 "PostsCount"   =>$Posts ,
							 "TestMark"   	=>$TestMark ,
							 "PositiveID"   =>$Positive ,
							 "NoteID"    	=>$Note ,
							 "TeacherID"    =>$TeacherID ,
							 "SubjectID"    =>$SubjectID ,
							 "MOreNote"     =>$MOreNote , 
							 "Lesson" 		=>$tableLessonID ,
							 "HomeDegree"   =>$HomeDegree ,
							 "skills" 		=>$skills ,
							 "skillsType" 	=>$skil_active,
							 "Delay" 	    =>$Delay,
							 "Date"    		=>$Date,
							 "Date_stm"     =>$Timezone
							 );
			$this->db->where('ID', $EvalID);
		 	$this->db->update('students_evaluation',$DataInsert);
            
			$count ++;
		}
		return TRUE ;
	}
	
	///////////////////
	
 }//End Class