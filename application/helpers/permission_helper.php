<?php 

 /////////////////////
    function get_branches()
	{
	    	$CI       = &get_instance();
	           $query = $CI->db->query("SELECT SchoolID  FROM contact WHERE ID = '".$CI->session->userdata('id')."' ")->row_array()['SchoolID'];
	           $SchoolID    = $query;
	           if($CI->session->userdata('type')=='E'){
                  $school_emp       = $CI->db->query("select school_id from permission_request where EmpID='".$CI->session->userdata('id')."' ")->row_array()['school_id'];
				  if($school_emp){
						$SchoolID       = $school_emp;
				  }
				}

		if($SchoolID)
		{
			return $SchoolID ;
		}else{

			return false ;
		}
	}
	
	/////////////////////////
	
    function get_levels()
    {
     $CI       = &get_instance();
	$UserType = $CI->session->userdata('type');  

	$api_name = $CI->db->query("select ApiDbname from setting")->row_array()['ApiDbname'];

	if($UserType === 'U' )
	{
	     $GetLevel   = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/$api_name/GetAllLevels"));
	     $GetLevel   = implode(",",array_column($GetLevel, 'LevelId'));
		
	}else
	{
	    	$GetLevel = $CI->db->query("select Level from permission_request where EmpID='".$CI->session->userdata('id')."' ")->row_array()['Level'];
	   	
	}
	if($GetLevel)
		{
			return $GetLevel ;
		}else{

			return false ;
		}
}
///////
function check_group_permission($PageID = 0)
{
	$CI      = &get_instance();
	$UserID  = $CI->session->userdata('id'); 
	$GroupID = $CI->session->userdata('GroupID'); 
	$CI->load->model('admin/user_permission_model');
	$CI->user_permission_model->check_group_permission($UserID , $GroupID , $PageID);
}
////////////////
function check_group_permission_add_btn($PageID = 0 , $Class = '' , $BtnOnChang = '' , $BtnName = '' ,$Value = '' )
{
	if($Class === '' ){$Class = 'btn btn-success pull-left'  ;}
	$CI      = &get_instance();
	$UserID  = $CI->session->userdata('id'); 
	$GroupID = $CI->session->userdata('GroupID');
	$UserType = $CI->session->userdata('type');  
	$Lang     = $CI->session->userdata('language');
	if($UserType == 'U')
	{
		 echo '<input type="submit" class="'.$Class.'" value="'.$Value.'" onchange="'.$BtnOnChang.'" name="'.$BtnName.'" />' ;	
	}
	else
	{
	 
	$CI->load->model('admin/user_permission_model');
	$CheckAdd = $CI->user_permission_model->check_group_permission($UserID , $GroupID , $PageID);
	if(sizeof($CheckAdd) > 0 )
	{
		if($CheckAdd['PermissionAdd'] !=0)
		{
		  echo '<input type="submit" class="'.$Class.'" value="'.$Value.'" onchange="'.$BtnOnChang.'" name="'.$BtnName.'" />' ;	
		}
		else{
			   echo '<p>'.lang('br_per_all').'-'.lang('br_page_add').'</p>' ;
			}
		
	  }
	}
}
/////////////
function check_group_permission_add_link($PageID = 0 , $Class = '' , $OnClick = '' , $href = '' , $Content = ''   )
{
   
	if($Class === '' ){$Class ='btn btn-success pull-left'  ;}
	$CI      = &get_instance();
	$UserID  = $CI->session->userdata('id'); 
	$GroupID = $CI->session->userdata('GroupID'); 
	$UserType = $CI->session->userdata('type');  
	$Lang     = $CI->session->userdata('language');
	if($UserType == 'U')
	{
		echo '<a href="'.$href.'" class="'.$Class.'" onclick="'.$OnClick.'">'.$Content.'</a>' ;
	}
	else
	{
	
	$CI->load->model('admin/user_permission_model');
	$CheckAdd = $CI->user_permission_model->check_group_permission_add_edit_delete($UserID , $GroupID , $PageID);
	if(sizeof($CheckAdd) > 0 )
	{
		if($CheckAdd['PermissionAdd'] !=0)
		{
		  echo '<a href="'.$href.'" class="'.$Class.'" onclick="'.$OnClick.'">'.$Content.'</a>' ;	
		}
		else{
			   echo '<p>'.lang('br_per_all').'-'.lang('br_page_add').'</p>' ;
			}
		
	 }
	}
}
///////////
function check_group_permission_edit_btn($PageID = 0 , $Class = 'btn btn-success btn-rounded' , $BtnOnChang = '' , $BtnName = '' ,$Value = '' )
{
	if($Class === '' ){$Class = 'btn btn-success btn-rounded'  ;}
	$CI      = &get_instance();
	$UserID  = $CI->session->userdata('id'); 
	$GroupID = $CI->session->userdata('GroupID'); 
	$UserType = $CI->session->userdata('type');  
	$Lang     = $CI->session->userdata('language');
	if($UserType == 'U')
	{
		 echo '<input type="submit" value="'.$Value.'" class="'.$Class.'" onchange="'.$BtnOnChang.'" name="'.$BtnName.'" />' ;	
	}
	else
	{
	
	$CI->load->model('admin/user_permission_model');
	$CheckEdit = $CI->user_permission_model->check_group_permission_add_edit_delete($UserID , $GroupID , $PageID);
	if(sizeof($CheckEdit) > 0 )
	{
		if($CheckEdit['PermissionEdit'] !=0)
		{
		  echo '<input type="submit" value="'.$Value.'" class="'.$Class.'" onchange="'.$BtnOnChang.'" name="'.$BtnName.'" />' ;	
		}
		else{
			   echo '<p>'.lang('br_per_all').'-'.lang('br_page_edit').'</p>' ;
			}
	  }
	}
}
/////////
function check_group_permission_edit_link($PageID = 0 , $Class = 'btn btn-success btn-rounded' , $OnClick = '' , $href = '' , $Content = ''   )
{
	if($Class === '' ){$Class = 'btn btn-success btn-rounded'  ;}
	$CI      = &get_instance();
	$UserID  = $CI->session->userdata('id'); 
	$GroupID = $CI->session->userdata('GroupID'); 
	$UserType = $CI->session->userdata('type');  
	$Lang     = $CI->session->userdata('language');
	if($UserType == 'U')
	{
	  echo '<a href="'.$href.'" class="'.$Class.'" onclick="'.$OnClick.'">'.$Content.'</a>' ;		
	}
	else
	{
	
	$CI->load->model('admin/user_permission_model');
	$CheckEdit = $CI->user_permission_model->check_group_permission_add_edit_delete($UserID , $GroupID , $PageID);
	if(sizeof($CheckEdit) > 0 )
	{
		if($CheckEdit['PermissionEdit'] !=0)
		{
		  echo '<a href="'.$href.'" class="'.$Class.'" onclick="'.$OnClick.'">'.$Content.'</a>' ;	
		}
		else{
			   echo '<p>'.lang('br_per_all').'-'.lang('br_page_edit').'</p>' ;
			}
	   }
	}
}
///////////
function check_group_permission_delete_btn($PageID = 0 , $Class = 'btn btn-danger btn-rounded' , $BtnOnChang = '' , $BtnName = '' ,$Value = '' , $CheckBox = false )
{
	if($Class === '' ){$Class = 'btn btn-success btn-rounded'  ;}
	$CI      = &get_instance();
	$UserID  = $CI->session->userdata('id'); 
	$GroupID = $CI->session->userdata('GroupID'); 
	$UserType = $CI->session->userdata('type');  
	$Lang     = $CI->session->userdata('language');
	if($UserType == 'U')
	{
		if($CheckBox == false)
		{
	        echo '<input type="submit" class="'.$Class.'" value="'.$Value.'" onchange="'.$BtnOnChang.'" name="'.$BtnName.'" />' ;		
		}
			else{
				  return true ;
				}
	}
	else
	{
	
	$CI->load->model('admin/user_permission_model');
	$CheckDelete = $CI->user_permission_model->check_group_permission_add_edit_delete($UserID , $GroupID , $PageID);
	if(sizeof($CheckDelete) > 0 )
	{
		if($CheckDelete['PermissionDelete'] !=0)
		{
			if($CheckBox == false)
		    {
		      echo '<input type="submit" class="'.$Class.'" value="'.$Value.'" onchange="'.$BtnOnChang.'" name="'.$BtnName.'" />' ;	
			}
			else{
				  return true ;
				}
		}
		else{
			   echo '<p>'.lang('br_per_all').'-'.lang('br_page_delete').'</p>' ;
			}
	 }
			
	}
}
/////////
function check_group_permission_delete_link($PageID = 0 , $Class = 'btn btn-danger btn-rounded' , $OnClick = '' , $href = '' , $Content = '' , $CheckBox = false   )
{
	if($Class === '' ){$Class = 'btn btn-success btn-rounded'  ;}
	$CI      = &get_instance();
	$UserID  = $CI->session->userdata('id'); 
	$GroupID = $CI->session->userdata('GroupID'); 
	$UserType = $CI->session->userdata('type');  
	$Lang     = $CI->session->userdata('language');
	if($UserType == 'U')
	{
		if($CheckBox == false)
		    {
	            echo '<a href="'.$href.'" class="'.$Class.'" onclick="'.$OnClick.'">'.$Content.'</a>' ;	
			}else{
				  return true ;
				}
	}
	else
	{
	
	$CI->load->model('admin/user_permission_model');
	$CheckDelete = $CI->user_permission_model->check_group_permission_add_edit_delete($UserID , $GroupID , $PageID);
	if(sizeof($CheckDelete) > 0 )
	{
		if($CheckDelete['PermissionDelete'] !=0)
		{
			if($CheckBox == false)
		    {
		      echo '<a href="'.$href.'" class="'.$Class.'" onclick="'.$OnClick.'">'.$Content.'</a>' ;
			}else{
				  return true ;
				}
		}
		else{
			   echo '<p>'.lang('br_per_all').'-'.lang('br_page_delete').'</p>' ;
			}
	  }
	}
}
/////////////////////get_emp_group
function get_emp_group()
{
	$CI       = &get_instance();
	$UserID   = $CI->session->userdata('id'); 
	$GroupID  = $CI->session->userdata('GroupID');
	$UserType = $CI->session->userdata('type');  
	$Lang     = $CI->session->userdata('language');
	$CI->load->model(array('admin/user_permission_model','admin/Permission_model'));
	
	if($UserType == 'U' )
	{
		
		return $CI->Permission_model->get_emp();
		
		
	}else
	{
	   $CheckData = $CI->Permission_model->Get_PerType();
	   if(sizeof($CheckData) > 0 )
	   {
		 switch($CheckData['Type'])
		 {
			 case 1 :
			 return $CI->Permission_model->get_emp_group_level($Lang  , $CheckData['PerType']);
			 break ;
			 case 2 : 
			 return $CI->Permission_model->get_emp_group_rowlevel($Lang , $CheckData['PerType']);
			 break ;
			 case 3 : 
			  $RowLevel = 0 ;
			 $Class    = 0 ;
			 if(!empty($CheckData['PerType']))
			 {
				$DataPerType = explode(',',$CheckData['PerType']); 
			 }
			 $second = [];
			 $first = [];
 			 foreach($DataPerType as $key=>$item){
 			      $ee=explode('|',$item);
                  $row_lev=$ee[0];
                  $Clas=$ee[1];
                  array_push($first,$row_lev);
                  array_push($second,$Clas);
 				 } 
			 $RowLevel = implode(',',$first);
			 $Class    = implode(',',$second);
			 return $CI->Permission_model->get_emp_group_class($Lang , $RowLevel , $Class);
			 break ;
			 case 4 : 
			      $RowLevel = 0 ;
			     $Subject   = 0 ;
			 if(!empty($CheckData['PerType']))
			 {
				$DataPerType = explode(',',$CheckData['PerType']); 
			 }
			 $second = [];
			 $first = [];
 			 foreach($DataPerType as $key=>$item){
 			      $ee=explode('|',$item);
                  $row_lev=$ee[0];
                  $Sub=$ee[1];
                  array_push($first,$row_lev);
                  array_push($second,$Sub);
 				 } 
			 $RowLevel = implode(',',$first);
			 $Subject    = implode(',',$second);
			 return $CI->Permission_model->get_emp_group_subject($Lang , $RowLevel,$Subject);

			 break ; 
		 }
	   }else{return false ;}	
	}
}
/////////////////////get_emp_job
function get_emp_job()
{
    
    
    
    	$CI       = &get_instance();
	$UserID   = $CI->session->userdata('id'); 
	$GroupID  = $CI->session->userdata('GroupID');
	$UserType = $CI->session->userdata('type');  
	$Lang     = $CI->session->userdata('language');
	$CI->load->model('admin/user_permission_model');
	
	if($UserType === 'U' )
	{
		return $CI->user_permission_model->get_emp_job();
	}else
	{
	   $CheckData = $CI->user_permission_model->get_emp_job_permission(0,$UserID );
	   if(sizeof($CheckData) > 0 )
	   { 
	       return $CheckData;
	   }else{return false ;}	
	}
}
/////////////////////
function get_level($PageID = 0 )
{
	$CI       = &get_instance();
	$UserID   = $CI->session->userdata('id'); 
	$GroupID  = $CI->session->userdata('GroupID');
	$UserType = $CI->session->userdata('type');  
	$Lang     = $CI->session->userdata('language');
	$CI->load->model('admin/user_permission_model');
	if($UserType === 'U' )
	{
		return $CI->user_permission_model->get_level($Lang);
	}else
	{
	   $CheckData = $CI->user_permission_model->check_group_permission_type($UserID );
	 // print_r( $CheckData);exit();
	   if(sizeof($CheckData) > 0 )
	   {
		   if($CheckData['Type'])
		   {
			 $CheckData = $CI->user_permission_model->get_level_per_helper($Lang , $CheckData['PerType']);
			 
		     return $CheckData ;
			  
		   }
		   else
		   {
			   return false ; 
		   }
	   }
	}
}


/////////////////////get_row_level
function get_row_level($PageID = 0 )
{
	$CI       = &get_instance();
	$UserID   = $CI->session->userdata('id'); 
	$GroupID  = $CI->session->userdata('GroupID');
	$UserType = $CI->session->userdata('type');  
	$Lang     = $CI->session->userdata('language');
	$CI->load->model('admin/user_permission_model');
	if($UserType === 'U' )
	{
		return $CI->user_permission_model->get_row_level($Lang);
	}else
	{
	   $CheckData = $CI->user_permission_model->check_group_permission($UserID , $GroupID , $PageID);
	   if(sizeof($CheckData) > 0 )
	   {
		   if($CheckData['Type'])
		   {
			   if($CheckData['Type'] == 1 )
			   {
				   $CheckData = $CI->user_permission_model->get_row_level_per_level($Lang , $CheckData['PerType']);
				 
			   }else if($CheckData['Type'] == 2 ){
				       $CheckData = $CI->user_permission_model->get_row_level_per_row($Lang , $CheckData['PerType']);
				    }
			   
			 else{
				     $CheckData = FALSE ;
				 }
		     return $CheckData ;
		   }
		   else
		   {
			   return false ; 
		   }
	   }
	}
}

/////////////////////
function get_student_group()
{
	$CI       = &get_instance();
	$UserID   = $CI->session->userdata('id'); 
	$GroupID  = $CI->session->userdata('GroupID');
	$UserType = $CI->session->userdata('type');  
	$Lang     = $CI->session->userdata('language');
	$CI->load->model('admin/user_permission_model');
	if($UserType === 'U' )
	{
		return $CI->user_permission_model->get_all_student($Lang);
	}else
	{
	   $CheckData = $CI->user_permission_model->check_group_permission_type($UserID );
	   if(sizeof($CheckData) > 0 )
	   {
		 switch($CheckData['Type'])
		 {
			 case 1 :
			 return $CI->user_permission_model->get_level_student($Lang  , $CheckData['PerType']);
			 break ;
			 case 2 : 
			 return $CI->user_permission_model->get_rowlevel_student($Lang , $CheckData['PerType']);
			 break ;
			 case 3 : 
			 $RowLevel = 0 ;
			 $Class    = 0 ;
			 if(!empty($CheckData['PerType']))
			 {
				$DataPerType = explode(',',$CheckData['PerType']); 
			 }
			 $second = [];
			 $first = [];
 			 foreach($DataPerType as $key=>$item){
 			      $ee=explode('|',$item);
                  $row_lev=$ee[0];
                  $Clas=$ee[1];
                  array_push($first,$row_lev);
                  array_push($second,$Clas);
 				 } 
			 $RowLevel = implode(',',$first);
			 $Class    = implode(',',$second);
			 return $CI->user_permission_model->get_student_group_class($Lang , $RowLevel , $Class);
			 break ;
			 case 4 : 
			     $RowLevel = 0 ;
			     $Subject   = 0 ;
			 if(!empty($CheckData['PerType']))
			 {
				$DataPerType = explode(',',$CheckData['PerType']); 
			 }
			 $second = [];
			 $first = [];
 			 foreach($DataPerType as $key=>$item){
 			      $ee=explode('|',$item);
                  $row_lev=$ee[0];
                  $Sub=$ee[1];
                  array_push($first,$row_lev);
                  array_push($second,$Sub);
 				 } 
			 $RowLevel = implode(',',$first);
			 $Subject    = implode(',',$second);
			 return $CI->user_permission_model->get_student_group_subject($Lang , $RowLevel , $Subject);
			 break ; 
		 }
	   }else{return false ;}	
	}
}
function get_father_select_in()
{
   	$father = get_student_group1();
	if(is_array($father))
	{
		$fatherArray = array() ; 
		  foreach($father as $Key=>$Row)
		  {
			
			  $fatherArray[$Key] = $Row->ID ; 
			  
		  }
		  
		  return implode(",", $fatherArray) ; 
	}else{
		    return 0  ; 
		 }
}

function get_student_group1()
{
	$CI       = &get_instance();
	$UserID   = $CI->session->userdata('id'); 
	$GroupID  = $CI->session->userdata('GroupID');
	$UserType = $CI->session->userdata('type');  
	$Lang     = $CI->session->userdata('language');
	$CI->load->model('admin/user_permission_model');
	if($UserType === 'U')
	{
		return $CI->user_permission_model->get_all_student1($Lang);
	}else
	{
	   $CheckData = $CI->user_permission_model->check_group_permission_type($UserID );
	   if(sizeof($CheckData) > 0 )
	   {
		 switch($CheckData['Type'])
		 {
			 case 1 :
			 return $CI->user_permission_model->get_level_student($Lang  , $CheckData['PerType']);
			 break ;
			 case 2 : 
			 return $CI->user_permission_model->get_rowlevel_student($Lang , $CheckData['PerType']);
			 break ;
			 case 3 : 
			 $RowLevel = 0 ;
			 $Class    = 0 ;
			 if(!empty($CheckData['PerType']))
			 {
				$DataPerType = explode(',',$CheckData['PerType']); 
			 }
			 $second = [];
			 $first = [];
 			 foreach($DataPerType as $key=>$item){
 			      $ee=explode('|',$item);
                  $row_lev=$ee[0];
                  $Clas=$ee[1];
                  array_push($first,$row_lev);
                  array_push($second,$Clas);
 				 } 
			 $RowLevel = implode(',',$first);
			 $Class    = implode(',',$second);
			 return $CI->user_permission_model->get_student_group_class($Lang , $RowLevel , $Class);
			 break ;
			 case 4 : 
			     $RowLevel = 0 ;
			     $Subject   = 0 ;
			 if(!empty($CheckData['PerType']))
			 {
				$DataPerType = explode(',',$CheckData['PerType']); 
			 }
			 $second = [];
			 $first = [];
 			 foreach($DataPerType as $key=>$item){
 			      $ee=explode('|',$item);
                  $row_lev=$ee[0];
                  $Sub=$ee[1];
                  array_push($first,$row_lev);
                  array_push($second,$Sub);
 				 } 
			 $RowLevel = implode(',',$first);
			 $Subject    = implode(',',$second);
			 return $CI->user_permission_model->get_student_group_subject($Lang , $RowLevel , $Subject);
			 break ; 
		 }
	   }else{return false ;}	
	}
}

function get_emp_select_in()
{
   	$Emp = get_emp_group();
	if(is_array($Emp))
	{
		$EmpArray = array() ; 
		  foreach($Emp as $Key=>$Row)
		  {
			
			  $EmpArray[$Key] = $Row->ContactID ; 
			  
		  }
		  
		  return implode(",", $EmpArray) ; 
	}else{
		    return 0  ; 
		 }
}	
//////////////////
function get_supervisor_select_in()
{
   	$Emp = get_supervisor_group();
	if(is_array($Emp))
	{
		$EmpArray = array() ; 
		  foreach($Emp as $Key=>$Row)
		  {
			
			  $EmpArray[$Key] = $Row->ContactID ; 
			  
		  }
		  
		  return implode(",", $EmpArray) ; 
	}else{
		    return 0  ; 
		 }
}	
////////////////////////

function get_supervisor_group()
{
	$CI       = &get_instance();
	$UserID   = $CI->session->userdata('id'); 
	$GroupID  = $CI->session->userdata('GroupID');
	$UserType = $CI->session->userdata('type');  
	$Lang     = $CI->session->userdata('language');
	$CI->load->model(array('admin/Permission_model'));
	
	if($UserType == 'U' )
	{
		
		return $CI->Permission_model->get_emp();
		
		
	}else
	{
	   $CheckData = $CI->Permission_model->Get_PerType();
	   if(sizeof($CheckData) > 0 )
	   {
		 switch($CheckData['Type'])
		 {
			 case 1 :
				$level_array    = $CheckData['PerType'];
				$rowLevel_array = $CI->db->query("SELECT GROUP_CONCAT(DISTINCT row_level.ID)  AS row_level_ID  
													FROM row_level
													WHERE row_level.IsActive = 1 AND row_level.Level_ID IN (".$CheckData['PerType'].")
												")->row_array()['row_level_ID'];
				$class_array    = $CI->db->query("SELECT GROUP_CONCAT(DISTINCT CONCAT(row_level.ID, '|', class.ID)) AS ClassID
													FROM class
													INNER join class_level on class.ID=class_level.classID
		                                            INNER join row_level ON class_level.levelID=row_level.Level_ID
													WHERE class.Is_Active =1 AND row_level.Level_ID IN (".$CheckData['PerType'].") AND row_level.IsActive = 1
													")->row_array()['ClassID'];
				$subject_array  = $CI->db->query("SELECT GROUP_CONCAT(DISTINCT CONCAT(row_level.ID, '|',subject.ID)) AS subjectID 
													FROM subject
													join row_level 
													WHERE subject.Is_Active =1 AND row_level.IsActive = 1
												")->row_array()['subjectID'];
			 break ;
			 case 2 : 
				$level_array = $CI->db->query("SELECT GROUP_CONCAT(DISTINCT row_level.Level_ID)  AS Level_ID  
													FROM row_level
													WHERE row_level.IsActive = 1 AND row_level.ID IN (".$CheckData['PerType'].")
												")->row_array()['Level_ID'];
				$rowLevel_array    = $CheckData['PerType'];
				$class_array    = $CI->db->query("SELECT GROUP_CONCAT(DISTINCT CONCAT(row_level.ID, '|', class.ID)) AS ClassID
													FROM class
													INNER join class_level on class.ID=class_level.classID
													INNER join row_level ON class_level.levelID=row_level.Level_ID
													WHERE class.Is_Active =1 AND row_level.ID IN (".$CheckData['PerType'].") AND row_level.IsActive = 1
													")->row_array()['ClassID'];
				$subject_array  = $CI->db->query("SELECT GROUP_CONCAT(DISTINCT CONCAT(row_level.ID, '|',subject.ID)) AS subjectID
													FROM subject
													join row_level 
													WHERE subject.Is_Active =1 AND row_level.IsActive = 1
												")->row_array()['subjectID'];
			 break ;
			 case 3 : 
			  $RowLevel = 0 ;
			  $Class    = 0 ;
			 if(!empty($CheckData['PerType']))
			 {
				$DataPerType = explode(',',$CheckData['PerType']); 
			 }
			 $second = [];
			 $first  = [];
 			 foreach($DataPerType as $key=>$item){
 			      $ee=explode('|',$item);
                  $row_lev=$ee[0];
                  $Clas=$ee[1];
                  array_push($first,$row_lev);
                  array_push($second,$Clas);
 				 } 
			 $RowLevel = implode(',',$first);
			 $Class    = implode(',',$second);
			    $level_array    = $CI->db->query("SELECT GROUP_CONCAT(DISTINCT row_level.Level_ID)  AS Level_ID  
													FROM row_level
													WHERE row_level.IsActive = 1 AND row_level.ID IN (".$RowLevel.")
												")->row_array()['Level_ID'];
				$rowLevel_array = $CI->db->query("SELECT GROUP_CONCAT(DISTINCT row_level.ID)  AS row_level_ID  
												FROM row_level
												WHERE row_level.IsActive = 1 AND row_level.ID IN (".$RowLevel.")
											")->row_array()['row_level_ID'];
				$class_array    = $CheckData['PerType'];
				$subject_array  = $CI->db->query("SELECT GROUP_CONCAT(DISTINCT CONCAT(row_level.ID, '|',subject.ID)) AS subjectID
													FROM subject
													join row_level 
													WHERE subject.Is_Active =1 AND row_level.IsActive = 1
												")->row_array()['subjectID'];
			 break ;
			 case 4 : 
			      $RowLevel = 0 ;
			     $Subject   = 0 ;
			 if(!empty($CheckData['PerType']))
			 {
				$DataPerType = explode(',',$CheckData['PerType']); 
			 }
			 $second = [];
			 $first = [];
 			 foreach($DataPerType as $key=>$item){
 			      $ee=explode('|',$item);
                  $row_lev=$ee[0];
                  $Sub=$ee[1];
                  array_push($first,$row_lev);
                  array_push($second,$Sub);
 				 } 
			 $RowLevel = implode(',',$first);
			 $Subject    = implode(',',$second);
			    $level_array    = $CI->db->query("SELECT GROUP_CONCAT(DISTINCT row_level.Level_ID)  AS Level_ID  
													FROM row_level
													WHERE row_level.IsActive = 1 AND row_level.ID IN (".$RowLevel.")
												")->row_array()['Level_ID'];
				$rowLevel_array = $CI->db->query("SELECT GROUP_CONCAT(DISTINCT row_level.ID)  AS row_level_ID  
												FROM row_level
												WHERE row_level.IsActive = 1 AND row_level.ID IN (".$RowLevel.")
											")->row_array()['row_level_ID'];
				$class_array    = $CI->db->query("SELECT GROUP_CONCAT(DISTINCT CONCAT(row_level.ID, '|', class.ID)) AS ClassID
											FROM class
											INNER join class_level on class.ID=class_level.classID
											INNER join row_level ON class_level.levelID=row_level.Level_ID
													WHERE class.Is_Active =1 AND row_level.ID IN (".$RowLevel.") AND row_level.IsActive = 1
											")->row_array()['ClassID'];
				$subject_array  = $CheckData['PerType'];

			 break ; 
		 }
		 $query = $CI->db->query("SELECT contact.ID AS ContactID ,employee.Type ,employee.PerType
									FROM contact
									INNER JOIN employee ON contact.ID = employee.Contact_ID
									WHERE contact.SchoolID IN ('".$CI->session->userdata('SchoolID')."')
									AND contact.Isactive = 1
									AND contact.Type = 'E'
									AND employee.Type != 0
									AND contact.GroupID != 0
									GROUP BY contact.ID;
									
									")->result();
		$level_array =explode(',',$level_array);
		$rowLevel_array =explode(',',$rowLevel_array);
		$class_array =explode(',',$class_array);
		$subject_array =explode(',',$subject_array);
		$arr=[];

		foreach($query as $val){
			if($val->Type==1){
				$per=array_intersect(explode(',',$val->PerType),$level_array);
				if (!empty($per)) {
					array_push($arr,$val->ContactID);

			}}elseif($val->Type==2){
				$per=array_intersect(explode(',',$val->PerType),$rowLevel_array);
				if (!empty($per)) {
					array_push($arr,$val->ContactID);

			}}elseif($val->Type==3){
				$per=array_intersect(explode(',',$val->PerType),$class_array);
				if (!empty($per)) {
					array_push($arr,$val->ContactID);

			}}elseif($val->Type==4){
				$per=array_intersect(explode(',',$val->PerType),$subject_array);
				if (!empty($per)) {
					array_push($arr,$val->ContactID);

			}
		}
	}
	$users=implode(',',$arr);

	$query = $CI->db->query("SELECT contact.ID AS ContactID 
	FROM contact
	WHERE 1 and FIND_IN_SET(contact.ID ,'$users')
	GROUP BY contact.ID;
	")->result();
		if(sizeof($query)> 0 ){return $query;}else{ return  FALSE  ;}
	   }else{return false ;}	
	}
}
/////////////////////
function get_student_select_in()
{
   	$student = get_student_group();
	if(is_array($student))
	{
		$studentArray = array() ; 
		  foreach($student as $Key=>$Row)
		  {
			
			  $studentArray[$Key] = $Row->StudentID ; 
			  
		  }
		  
		  return implode(",", $studentArray) ; 
	}else{
		    return 0  ; 
		 }
}
function get_level_select_in()
{
   	$level = get_level_group();
	if(is_array($level))
	{
		$levelArray = array() ; 
		  foreach($level as $Key=>$lev)
		  {
			
			  $levelArray[$Key] = $lev->LevelID ; 
			  
		  }
		  
		  return implode(",", $levelArray) ; 
	}else{
		    return 0  ; 
		 }
}
function get_level_group()
{
	$CI       = &get_instance();
	$UserID   = $CI->session->userdata('id'); 
	$GroupID  = $CI->session->userdata('GroupID');
	$UserType = $CI->session->userdata('type');  
	$Lang     = $CI->session->userdata('language');
	$CI->load->model(array('admin/user_permission_model','admin/Permission_model'));
	if($UserType === 'U' )
	{
		return $CI->Permission_model->get_level($Lang);
	}else
	{
	   $CheckData = $CI->Permission_model->Get_PerType();
	   if(sizeof($CheckData) > 0 )
	   {
		 switch($CheckData['Type'])
		 {
			 case 1 : 
			 return $CI->Permission_model->Get_level1($CheckData['PerType']);
			 break ;
			 case 2 : 
			 return $CI->Permission_model->Get_level2($CheckData['PerType']);
			 break ;
			 case 3 : 
			$RowLevel = 0 ;
			 $Class    = 0 ;
			 if(!empty($CheckData['PerType']))
			 {
				$DataPerType = explode(',',$CheckData['PerType']); 
			 }
			 $second = [];
			 $first = [];
 			 foreach($DataPerType as $key=>$item){
 			      $ee=explode('|',$item);
                  $row_lev=$ee[0];
                  $Clas=$ee[1];
                  array_push($first,$row_lev);
                  array_push($second,$Clas);
 				 } 
			 $RowLevel = implode(',',$first);
			 $Class    = implode(',',$second);
			  
			 return $CI->Permission_model->Get_level2( $RowLevel );
			 break ;
			 case 4 : 
			     $RowLevel = 0 ;
			     $Subject   = 0 ;
			 if(!empty($CheckData['PerType']))
			 {
				$DataPerType = explode(',',$CheckData['PerType']); 
			 }
			 $second = [];
			 $first = [];
 			 foreach($DataPerType as $key=>$item){
 			      $ee=explode('|',$item);
                  $row_lev=$ee[0];
                  $Sub=$ee[1];
                  array_push($first,$row_lev);
                  array_push($second,$Sub);
 				 } 
			 $RowLevel = implode(',',$first);
			 $Subject    = implode(',',$second);
			return $CI->Permission_model->Get_level2($RowLevel);
			 break ; 
		 }
	   }else{return false ;}	
	}
}
////////////////////////////////////
function get_level_group_without_student()
{
	$CI       = &get_instance();
	$UserID   = $CI->session->userdata('id'); 
	$GroupID  = $CI->session->userdata('GroupID');
	$UserType = $CI->session->userdata('type');  
	$Lang     = $CI->session->userdata('language');
	$CI->load->model(array('admin/user_permission_model','admin/Permission_model'));
	if($UserType === 'U' )
	{
		return $CI->Permission_model->get_level_without_student($Lang);
	}else
	{
	   $CheckData = $CI->Permission_model->Get_PerType();
	   if(sizeof($CheckData) > 0 )
	   {
		 switch($CheckData['Type'])
		 {
			 case 1 : 
			 return $CI->Permission_model->Get_level_without_student1($CheckData['PerType']);
			 break ;
			 case 2 : 
			 return $CI->Permission_model->Get_level_without_student2($CheckData['PerType']);
			 break ;
			 case 3 : 
			$RowLevel = 0 ;
			 $Class    = 0 ;
			 if(!empty($CheckData['PerType']))
			 {
				$DataPerType = explode(',',$CheckData['PerType']); 
			 }
			 $second = [];
			 $first = [];
 			 foreach($DataPerType as $key=>$item){
 			      $ee=explode('|',$item);
                  $row_lev=$ee[0];
                  $Clas=$ee[1];
                  array_push($first,$row_lev);
                  array_push($second,$Clas);
 				 } 
			 $RowLevel = implode(',',$first);
			 $Class    = implode(',',$second);
			  
			 return $CI->Permission_model->Get_level_without_student2( $RowLevel );
			 break ;
			 case 4 : 
			     $RowLevel = 0 ;
			     $Subject   = 0 ;
			 if(!empty($CheckData['PerType']))
			 {
				$DataPerType = explode(',',$CheckData['PerType']); 
			 }
			 $second = [];
			 $first = [];
 			 foreach($DataPerType as $key=>$item){
 			      $ee=explode('|',$item);
                  $row_lev=$ee[0];
                  $Sub=$ee[1];
                  array_push($first,$row_lev);
                  array_push($second,$Sub);
 				 } 
			 $RowLevel = implode(',',$first);
			 $Subject    = implode(',',$second);
			return $CI->Permission_model->Get_level_without_student2($RowLevel);
			 break ; 
		 }
	   }else{return false ;}	
	}
}

function get_rowlevel_select_in()
{
   	$rowlevel = get_rowlevel_group();
	if(is_array($rowlevel))
	{
		$rowlevelArray = array() ; 
		  foreach($rowlevel as $Key=>$Row)
		  {
			
			  $rowlevelArray[$Key] = $Row->RowLevelID ; 
			  
		  }
		  
		  return implode(",", $rowlevelArray) ; 
	}else{
		    return 0  ; 
		 }
}	
function get_rowlevel_group()
{
	$CI       = &get_instance();
	$UserID   = $CI->session->userdata('id'); 
	$GroupID  = $CI->session->userdata('GroupID');
	$UserType = $CI->session->userdata('type');  
	$Lang     = $CI->session->userdata('language');
	$CI->load->model('admin/Permission_model');
	if($UserType === 'U' )
	{
		return $CI->Permission_model->get_RowLevel_without_per($Lang);
	}else
	{
	   $CheckData = $CI->Permission_model->Get_PerType();
	   if(sizeof($CheckData) > 0 )
	   {
		 switch($CheckData['Type'])
		 {
			 case 1 :
			 return $CI->Permission_model->get_RowLevel_classtable1($CheckData['PerType']);
			 break ;
			 case 2 : 
			 return $CI->Permission_model->get_RowLevel_classtable2($CheckData['PerType']);
			 break ;
			 case 3 : 
			 $RowLevel = 0 ;
			 $Class    = 0 ;
			 if(!empty($CheckData['PerType']))
			 {
				$DataPerType = explode(',',$CheckData['PerType']); 
			 }
			 $second = [];
			 $first = [];
 			 foreach($DataPerType as $key=>$item){
 			      $ee=explode('|',$item);
                  $row_lev=$ee[0];
                  $Clas=$ee[1];
                  array_push($first,$row_lev);
                  array_push($second,$Clas);
 				 } 
			 $RowLevel = implode(',',$first);
			 $Class    = implode(',',$second);
			 return $CI->Permission_model->get_RowLevel_classtable2($RowLevel);
			 break ;
			 case 4 : 
			     $RowLevel = 0 ;
			     $Subject   = 0 ;
			 if(!empty($CheckData['PerType']))
			 {
				$DataPerType = explode(',',$CheckData['PerType']); 
			 }
			 $second = [];
			 $first = [];
 			 foreach($DataPerType as $key=>$item){
 			      $ee=explode('|',$item);
                  $row_lev=$ee[0];
                  $Sub=$ee[1];
                  array_push($first,$row_lev);
                  array_push($second,$Sub);
 				 } 
			 $RowLevel = implode(',',$first);
			 $Subject    = implode(',',$second);
			 return $CI->Permission_model->get_RowLevel_classtable2($RowLevel);
			 break ; 
		 }
	   }else{return false ;}	
	}
}
////////////////////////////

function get_rowlevel_select_without_student()
{
   	$rowlevel = get_rowlevel_group_without_student();
	if(is_array($rowlevel))
	{
		$rowlevelArray = array() ; 
		  foreach($rowlevel as $Key=>$Row)
		  {
			
			  $rowlevelArray[$Key] = $Row->RowLevelID ; 
			  
		  }
		  
		  return implode(",", $rowlevelArray) ; 
	}else{
		    return 0  ; 
		 }
}	
///////////////////////////
function get_rowlevel_group_without_student()
{
	$CI       = &get_instance();
	$UserID   = $CI->session->userdata('id'); 
	$GroupID  = $CI->session->userdata('GroupID');
	$UserType = $CI->session->userdata('type');  
	$Lang     = $CI->session->userdata('language');
	$CI->load->model('admin/Permission_model');
	if($UserType === 'U' )
	{
		return $CI->Permission_model->get_RowLevel_admin_without_student($Lang);
	}else
	{
	   $CheckData = $CI->Permission_model->Get_PerType();
	   if(sizeof($CheckData) > 0 )
	   {
		 switch($CheckData['Type'])
		 {
			 case 1 :
			 return $CI->Permission_model->get_RowLevel_classtable_without_student1($CheckData['PerType']);
			 break ;
			 case 2 : 
			 return $CI->Permission_model->get_RowLevel_classtable_without_student2($CheckData['PerType']);
			 break ;
			 case 3 : 
			 $RowLevel = 0 ;
			 $Class    = 0 ;
			 if(!empty($CheckData['PerType']))
			 {
				$DataPerType = explode(',',$CheckData['PerType']); 
			 }
			 $second = [];
			 $first = [];
 			 foreach($DataPerType as $key=>$item){
 			      $ee=explode('|',$item);
                  $row_lev=$ee[0];
                  $Clas=$ee[1];
                  array_push($first,$row_lev);
                  array_push($second,$Clas);
 				 } 
			 $RowLevel = implode(',',$first);
			 $Class    = implode(',',$second);
			 return $CI->Permission_model->get_RowLevel_classtable_without_student2($RowLevel);
			 break ;
			 case 4 : 
			     $RowLevel = 0 ;
			     $Subject   = 0 ;
			 if(!empty($CheckData['PerType']))
			 {
				$DataPerType = explode(',',$CheckData['PerType']); 
			 }
			 $second = [];
			 $first = [];
 			 foreach($DataPerType as $key=>$item){
 			      $ee=explode('|',$item);
                  $row_lev=$ee[0];
                  $Sub=$ee[1];
                  array_push($first,$row_lev);
                  array_push($second,$Sub);
 				 } 
			 $RowLevel = implode(',',$first);
			 $Subject    = implode(',',$second);
			 return $CI->Permission_model->get_RowLevel_classtable_without_student2($RowLevel);
			 break ; 
		 }
	   }else{return false ;}	
	}
}
///////////////////////////
function get_class_select_in()
{
   	$class = get_class_group();
	if(is_array($class))
	{
		$classArray = array() ; 
		  foreach($class as $Key=>$clas)
		  {
			
			  $classArray[$Key] = $clas->ClassID ; 
			  
		  }
		  
		  return implode(",", $classArray) ; 
	}else{
		    return 0  ; 
		 }
}

function get_class_group()
{
	$CI       = &get_instance();
	$UserID   = $CI->session->userdata('id'); 
	$GroupID  = $CI->session->userdata('GroupID');
	$UserType = $CI->session->userdata('type');  
	$Lang     = $CI->session->userdata('language');
	$CI->load->model(array('admin/user_permission_model','admin/Permission_model'));
	if($UserType === 'U' )
	{
		return $CI->Permission_model->get_row_level_class($Lang);
	}else
	{
	   $CheckData = $CI->Permission_model->Get_PerType();
	   if(sizeof($CheckData) > 0 )
	   {
		 switch($CheckData['Type'])
		 {
			 case 1 : 
			 return $CI->Permission_model->get_Class_case1($CheckData['PerType']);
			 break ;
			 case 2 : 
			 return $CI->Permission_model->get_Class_case2($CheckData['PerType']);
			 break ;
			 case 3 : 
			$RowLevel = 0 ;
			 $Class    = 0 ;
			 if(!empty($CheckData['PerType']))
			 {
				$DataPerType = explode(',',$CheckData['PerType']); 
			 }
			 $second = [];
			 $first = [];
 			 foreach($DataPerType as $key=>$item){
 			      $ee=explode('|',$item);
                  $row_lev=$ee[0];
                  $Clas=$ee[1];
                  array_push($first,$row_lev);
                  array_push($second,$Clas);
 				 } 
			 $RowLevel = implode(',',$first);
			 $Class    = implode(',',$second);
			  
			 return $CI->Permission_model->get_Class_case3( $RowLevel , $Class);
			 break ;
			 case 4 : 
			     $RowLevel = 0 ;
			     $Subject   = 0 ;
			 if(!empty($CheckData['PerType']))
			 {
				$DataPerType = explode(',',$CheckData['PerType']); 
			 }
			 $second = [];
			 $first = [];
 			 foreach($DataPerType as $key=>$item){
 			      $ee=explode('|',$item);
                  $row_lev=$ee[0];
                  $Sub=$ee[1];
                  array_push($first,$row_lev);
                  array_push($second,$Sub);
 				 } 
			 $RowLevel = implode(',',$first);
			 $Subject    = implode(',',$second);
			return $CI->Permission_model->get_Class_case2($RowLevel);
			 break ; 
		 }
	   }else{return false ;}	
	}
}

function get_subject_select_in()
{
   	$subject = get_subject_group();
	if(is_array($subject))
	{
		$subjectArray = array() ; 
		  foreach($subject as $Key=>$Row)
		  {
			
			  $subjectArray[$Key] = $Row->ID ; 
			  
		  }
		  
		  return implode(",", $subjectArray) ; 
	}else{
		    return 0  ; 
		 }
}	

function get_subject_group()
{
	$CI       = &get_instance();
	$UserID   = $CI->session->userdata('id'); 
	$GroupID  = $CI->session->userdata('GroupID');
	$UserType = $CI->session->userdata('type');  
	$Lang     = $CI->session->userdata('language');
	$CI->load->model('admin/Permission_model');
	if($UserType === 'U' )
	{
		return $CI->Permission_model->get_Subject1();
	}else
	{
	   $CheckData = $CI->Permission_model->Get_PerType();
	   if(sizeof($CheckData) > 0 )
	   {
		 switch($CheckData['Type'])
		 {
			 case 1 :
			 return $CI->Permission_model->get_Subject1();
			 break ;
			 case 2 : 
			 return $CI->Permission_model->get_Subject1();
			 break ;
			 case 3 : 
			 return $CI->Permission_model->get_Subject1();
			 break ;
			 case 4 : 
			     $RowLevel = 0 ;
			     $Subject   = 0 ;
			 if(!empty($CheckData['PerType']))
			 {
				$DataPerType = explode(',',$CheckData['PerType']); 
			 }
			 $second = [];
			 $first = [];
 			 foreach($DataPerType as $key=>$item){
 			      $ee=explode('|',$item);
                  $row_lev=$ee[0];
                  $Sub=$ee[1];
                  array_push($first,$row_lev);
                  array_push($second,$Sub);
 				 } 
			 $RowLevel = implode(',',$first);
			 $Subject    = implode(',',$second);
			 return $CI->Permission_model->get_Subject4($Subject);
			 break ; 
		 }
	   }else{return false ;}	
	}
}

/////////////////////get_student_group
function get_student_group_message()
{
	$CI       = &get_instance();
	$UserID   = $CI->session->userdata('id'); 
	$GroupID  = $CI->session->userdata('GroupID');
	$UserType = $CI->session->userdata('type');  
	$Lang     = $CI->session->userdata('language');
	$CI->load->model('admin/user_permission_model');
	if($UserType === 'U' )
	{
		return $CI->user_permission_model->get_all_student_message($Lang);
	}else
	{
	   $CheckData = $CI->user_permission_model->check_group_permission_type($UserID );
	   if(sizeof($CheckData) > 0 )
	   {
		 switch($CheckData['Type'])
		 {
			 case 1 :
			 return $CI->user_permission_model->get_level_student_message($Lang  , $CheckData['PerType']);
			 break ;
			 case 2 : 

			 return $CI->user_permission_model->get_rowlevel_student_message($Lang , $CheckData['PerType']);
			 break ;
			 case 3 : 
			 $RowLevel = 0 ;
			 $Class    = 0 ;
			 if(!empty($CheckData['PerType']))
			 {
				$DataPerType = explode(',',$CheckData['PerType']); 
			 }
			 $second = array();
			 $first = array();
 			 foreach($DataPerType as $key=>$item){
				 $second[$key] = substr($item, strpos($item, "|") + 1);
				 $arr = explode("|", $item, 2);
				 $first[$key]  = $arr[0];
 				 } 
			 $RowLevel = implode(',',$first);
			 $Class    = implode(',',$second);
			  
			 return $CI->user_permission_model->get_student_group_class_message($Lang , $RowLevel , $Class);
			 break ;
			 case 4 : 
			 return $CI->user_permission_model->get_student_group_subject_message($Lang , $CheckData['PerType']);
			 break ; 
		 }
	   }else{return false ;}	
	}
}
function get_class_per()
{
	$CI       = &get_instance();
	$UserID   = $CI->session->userdata('id'); 
	$GroupID  = $CI->session->userdata('GroupID');
	$UserType = $CI->session->userdata('type');  
	$Lang     = $CI->session->userdata('language');
	$CI->load->model('admin/user_permission_model');
	if($UserType === 'U' )
	{
		return $CI->user_permission_model->get_class_per($Lang);
	}else
	{
	   $CheckData = $CI->user_permission_model->check_group_permission_type($UserID);
	   if(sizeof($CheckData) > 0 )
	   {
		 switch($CheckData['Type'])
		 {
			 case 1 : 
			 return $CI->user_permission_model->get_class_per_level($Lang  , $CheckData['PerType']);
			 break ;
			 case 2 : 
			 return $CI->user_permission_model->get_class_per_row_level($Lang , $CheckData['PerType']);
			 break ;
			 case 3 : 
			 /*$RowLevel = 0 ;
			 $Class    = 0 ;
			 if(!empty($CheckData['PerType']))
			 {
				$DataPerType = explode(',',$CheckData['PerType']); 
			 }
			 $second = array();
			 $first = array();
			 $dataReturnClass = array();
 			 foreach($DataPerType as $key=>$item){
 			    $classAndLevel = explode('|',$item);
 			    $dataReturnClass[$key] = $CI->user_permission_model->get_class_khafagy($classAndLevel[0],$classAndLevel[1]);
				
 			 } 
			 return $dataReturnClass;*/
			 	 $RowLevel = 0 ;
			 $Class    = 0 ;
			 if(!empty($CheckData['PerType']))
			 {
				$DataPerType = explode(',',$CheckData['PerType']); 
			 }
			 $second = array();
			 $first = array();
 			 foreach($DataPerType as $key=>$item){
				 $second[$key] = substr($item, strpos($item, "|") + 1);
				 $arr = explode("|", $item, 2);
				 $first[$key]  = $arr[0];
 				 } 
			 $RowLevel = implode(',',$first);
			 $Class    = implode(',',$second);
			  
			 return $CI->user_permission_model->get_class_per_class($Lang , $RowLevel , $Class);
			 break ;
			 case 4 : 
			 return FALSE ;
			 break ; 
		 }
	   }else{return false ;}	
	}
	
}

function check_group_permission_page()
{
	$CI      = &get_instance();
	$GroupID = $CI->session->userdata('GroupID'); 
	$CI->load->model('admin/user_permission_model');
	$currentPath = $_SERVER['REQUEST_URI'];
	$currentPath = trim($currentPath, '/');
	$pathSegments = explode('/', $currentPath);
	if($pathSegments[2]==""){
		$pathSegments[2]="index";
	}
	
		$desiredPath = $pathSegments[0]."/".$pathSegments[1]."/".$pathSegments[2];
	return $CI->user_permission_model->check_group_permission_page($GroupID , $desiredPath);
}
///////////////////////////////

function get_student_select_notActive()
{
   	$student = get_student_group_notActive();
	if(is_array($student))
	{
		$studentArray = array() ; 
		  foreach($student as $Key=>$Row)
		  {
			
			  $studentArray[$Key] = $Row->StudentID ; 
			  
		  }
		  
		  return implode(",", $studentArray) ; 
	}else{
		    return 0  ; 
		 }
}
/////////////////////
function get_student_group_notActive()
{
	$CI       = &get_instance();
	$UserID   = $CI->session->userdata('id'); 
	$GroupID  = $CI->session->userdata('GroupID');
	$UserType = $CI->session->userdata('type');  
	$Lang     = $CI->session->userdata('language');
	$CI->load->model('admin/Permission_model');
	if($UserType === 'U' )
	{
		return $CI->Permission_model->get_all_student($Lang);
	}else
	{
		$CheckData = $CI->Permission_model->Get_PerType();
	   if(sizeof($CheckData) > 0 )
	   {
		 switch($CheckData['Type'])
		 {
			 case 1 :
			 return $CI->Permission_model->get_level_student($Lang  , $CheckData['PerType']);
			 break ;
			 case 2 : 
			 return $CI->Permission_model->get_rowlevel_student($Lang , $CheckData['PerType']);
			 break ;
			 case 3 : 
			 $RowLevel = 0 ;
			 $Class    = 0 ;
			 if(!empty($CheckData['PerType']))
			 {
				$DataPerType = explode(',',$CheckData['PerType']); 
			 }
			 $second = [];
			 $first = [];
 			 foreach($DataPerType as $key=>$item){
 			      $ee=explode('|',$item);
                  $row_lev=$ee[0];
                  $Clas=$ee[1];
                  array_push($first,$row_lev);
                  array_push($second,$Clas);
 				 } 
			 $RowLevel = implode(',',$first);
			 $Class    = implode(',',$second);
			 return $CI->Permission_model->get_student_group_class($Lang , $RowLevel , $Class);
			 break ;
			 case 4 : 
			     $RowLevel = 0 ;
			     $Subject   = 0 ;
			 if(!empty($CheckData['PerType']))
			 {
				$DataPerType = explode(',',$CheckData['PerType']); 
			 }
			 $second = [];
			 $first = [];
 			 foreach($DataPerType as $key=>$item){
 			      $ee=explode('|',$item);
                  $row_lev=$ee[0];
                  $Sub=$ee[1];
                  array_push($first,$row_lev);
                  array_push($second,$Sub);
 				 } 
			 $RowLevel = implode(',',$first);
			 $Subject    = implode(',',$second);
			 return $CI->Permission_model->get_student_group_subject($Lang , $RowLevel , $Subject);
			 break ; 
		 }
	   }else{return false ;}	
	}
}
?>