<?php
class Report_Percent_Model extends CI_Model 
 {
	private $Date       = '' ;
	private $Encryptkey = '' ;
	private $Token      = '' ;
	
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
	/////////////testTotalDegree
	public function testTotalDegree( $LevelID = 0 , $RowLevelID =0 ,  $ClassID = 0  , $DayDateFrom = 0 , $DayDateTo = 0 ,$subjectID = 0,$skills=0   )
	{ 
	               
                	if($LevelID    == 0 ){$LevelID    = 'NULL';  }
                	if($RowLevelID == 0 ){$RowLevelID = 'NULL';  }
                	if($ClassID    == 0 ){$ClassID    = 'NULL'; }
                	if($subjectID  == 0 ){$subjectID  = ''; }else{ $subjectID  = 'AND vw_test_select.Subject_ID  = '.$subjectID; }
                	if($skills     == 0 ){$skills     = 'NULL'; }
                	if($DayDateFrom  == 0 && $DayDateFrom  == 0  )
                	{
    			      	$Result = $this->db->query("
                              SELECT `test_questions`.`Test_ID`, `vw_test_select`.`test_Name`, SUM(questions_content.Degree) as testTotalDegree, count(test_questions.Questions_ID) as numQuestions 
                              FROM (`vw_test_select`) 
                              left JOIN `row_level` ON `vw_test_select`.`row_level_ID` = `row_level`.`ID` 
                              left  JOIN `test_questions` ON `test_questions`.`Test_ID` = `vw_test_select`.`test_ID` 
                              left JOIN `questions_content` ON `questions_content`.`ID` = `test_questions`.`Questions_ID` 
                              left JOIN skills on skills.SubjectID = vw_test_select.Subject_ID
                     		  WHERE row_level.Level_ID     			= IFNULL($LevelID , row_level.Level_ID )
                     		  AND   skills.ID                         = IFNULL($skills , skills.ID )
                    		  AND   vw_test_select.classID     		= IFNULL($ClassID , vw_test_select.classID )
                    		  AND   row_level.ID  			       	= IFNULL($RowLevelID , row_level.ID )
                    		  ".$subjectID."
                              GROUP BY `vw_test_select`.`test_ID`");

                   }else{
                       
    			      	$Result = $this->db->query("
                              SELECT `test_questions`.`Test_ID`, `vw_test_select`.`test_Name`, SUM(questions_content.Degree) as testTotalDegree, count(test_questions.Questions_ID) as numQuestions 
                              FROM (`vw_test_select`) 
                              JOIN `row_level` ON `vw_test_select`.`row_level_ID` = `row_level`.`ID` 
                              JOIN `test_questions` ON `test_questions`.`Test_ID` = `vw_test_select`.`test_ID` 
                              JOIN `questions_content` ON `questions_content`.`ID` = `test_questions`.`Questions_ID` 
                              JOIN skills on skills.SubjectID = vw_test_select.Subject_ID
                     		  WHERE row_level.Level_ID     			= IFNULL($LevelID , row_level.Level_ID )
                    		  AND   vw_test_select.classID     		= IFNULL($ClassID , vw_test_select.classID )
                    		  AND   skills.ID                         = IFNULL($skills , skills.ID )
                    		  AND   row_level.ID  			       	= IFNULL($RowLevelID , row_level.ID )
                    		  ".$subjectID."
                    		  AND vw_test_select.date_from >= '".$DayDateFrom."' 
                    		  AND vw_test_select.date_to   <= '".$DayDateTo."'  
                              GROUP BY `vw_test_select`.`test_ID`");
                	} 
                	
     				if($Result->num_rows()>0)
    				{			
    				  $ReturnResult = $Result->result() ;	 
    				  return $ReturnResult ;  
    				}else{
    					return 0 ;  
    				}
			  
	}  
	/////////////testStudentTotalDegree
	public function testStudentTotalDegree($testID)
	{ 
                 
	   	$Result = $this->db->query(" 
	   	select sum(test_student.Degree) as testStudentTotalDegree,count(test_student.questions_content_ID) as countStudentQuestions ,count( distinct(test_student.Contact_ID)) as numStudent 
	   	from test_student
	   	inner join test_questions on test_questions.Questions_ID = test_student.questions_content_ID 
	   	where test_questions.Test_ID ='".$testID."' group by test_questions.Test_ID ");

 		if($Result->num_rows()>0)
		{			
		  $ReturnResult = $Result->row() ;	 
		  return $ReturnResult ;  
		}else{
			return 0 ;  
		}
			  
	}  
	
	/////////////testStudentTotalDegree1
	/*public function testStudentTotalDegree1( $testID=0   )
	{ 
                 
    			   	$Result = $this->db->query("select sum(test_student.Degree) as testStudentTotalDegree,count(test_student.questions_content_ID) as countStudentQuestions
    			      	from test_student 
                        inner join test_questions on test_questions.Questions_ID = test_student.questions_content_ID
                        where test_questions.Test_ID ='".$testID."' group by test_student.Contact_ID  ");

     				if($Result->num_rows()>0)
    				{			
    				  $ReturnResult = $Result->result() ;	 
    				  return $ReturnResult ;  
    				}else{
    					return 0 ;  
    				}
			  
	}*/  
		public function discriminationOneTest($id){
		   $Result = $this->db->query("
		        SELECT test_student.Contact_ID
                ,sum(test_student.Degree) as student_drugs 
                , GROUP_CONCAT(questions_content.ID) as  questions_contentID_Array
                , GROUP_CONCAT(questions_content.Question) as questions_contentQuestion_Array
                , GROUP_CONCAT(test_student.Degree) as  test_studentDegree_Array
                , GROUP_CONCAT(questions_content.Degree) as  questions_contentDegree_array 
                ,CONCAT(sContact.Name, ' ', fContact.Name) as fullName
                FROM `test_student` 
                inner JOIN test_questions on test_student.questions_content_ID=test_questions.Questions_ID 
                inner join questions_content on questions_content.ID=test_student.questions_content_ID 
                inner join contact as sContact on  test_student.Contact_ID = sContact.ID
                inner join student on  student.Contact_ID = sContact.ID
                inner join contact as fContact on   student.Father_ID = fContact.ID
                WHERE test_questions.Test_ID = '".$id."'
                group by test_student.Contact_ID 
                order by sum(test_student.Degree) DESC
		   ");	
            if($Result->num_rows()>0)
			{			
			  $ReturnResult= $Result->result() ;
			  return $ReturnResult ;  
			}else{
				return 0 ;  
			}
		}
		public function getStudentTest($ID){
		   $Result = $this->db->query("
    		      SELECT  test_student.Contact_ID , test_student.questions_content_ID , contact.Name  , questions_content.Degree,
                   (
                	 select contact.Name from contact where contact.ID =  
                	(select student.Father_ID from student where student.Contact_ID = test_student.Contact_ID ) 
                	) as fatherName
                	from test_student 
                    INNER JOIN  questions_content on questions_content.ID = test_student.questions_content_ID 
                    INNER JOIN test_questions on test_questions.Questions_ID = questions_content.ID
                    INNER JOIN contact on test_student.Contact_ID = contact.ID
                    where test_questions.Test_ID = ".$ID."
                    
		   ");	
            if($Result->num_rows()>0)
			{			
			  $ReturnResult = $Result->result() ;	 
			  return $ReturnResult ;  
			}else{
				return 0 ;  
			}
		}
	
	
 }//////END CLASS 
?>