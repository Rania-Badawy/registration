<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Zoom_premission extends MY_Admin_Base_Controller

{

    private $data = array();



    function __construct()

    {

        parent::__construct();

        $this->load->library('get_data_admin');

        $this->load->model(array('admin/supervisor_model','emp/emp_class_table_model','config/config_class_table_model','control_emp/control_emp_model','home/emp_application_model','admin/zoom_model'));

        $this->data['UID'] = $this->session->userdata('id');

        $this->data['YearID'] = $this->session->userdata('YearID');

        $this->data['Year'] = $this->session->userdata('Year');

        $this->data['Semester'] = $this->session->userdata('Semester');

        $this->data['Lang'] = $this->session->userdata('language');

        if ($this->data['YearID'] == 0) {

            redirect('admin/config_system');

        }

        $this->data['Lang'] = $this->session->userdata('language');

    }

    
    	  public function all_permission_zoom($Name="")

    {
        
        // if($Name !=""){ 
        // $this->data['GetPermission']   = $this->zoom_model->get_permission($Name );
        // $this->data['Name']            =$Name;
        // }
         $this->data['GetPermission']   = $this->zoom_model->get_permission_zoom($Name );
        
        $this->load->admin_template('view_get_Permission_zoom', $this->data);
        

    }////////////// new_supervisor
    
    public function get_permission_zoom()

    {
        
       
        $this->data['GetPermission']   = $this->zoom_model->get_permission_zoom($Name );
       
        $this->load->admin_template('view_Permission_zoom', $this->data);
        

    }
     public function get_all_level($ID)

      {
           $level         =  $this->zoom_model->get_all_level($this->data['Lang'],$ID);
           
           $this->output->set_content_type('application/json')->set_output(json_encode($level));
      }
    
     public function get_all_row($schoolId,$ID)

      {
           $row           =  $this->zoom_model->get_all_row($this->data['Lang'],$schoolId,$ID);
           
           $this->output->set_content_type('application/json')->set_output(json_encode($row));
      }
      
       public function get_all_class($schoolId,$levelID,$RowID)

      {
           $class          =  $this->zoom_model->get_all_class($this->data['Lang'],$schoolId,$levelID,$RowID);
           
           $this->output->set_content_type('application/json')->set_output(json_encode($class));
      }
   
    public function add_new_permission_zoom($ID = 0)

      {
         
         $this->data['GetSchool']     = $this->emp_application_model->get_school();
          
       //  $this->data['level']           =  $this->zoom_model->get_all_level($this->data['Lang']);
         
         
          $this->data['GetEmp']        = $this->supervisor_model->get_emp();
         
           if($ID != 0){
                $this->data['GetPermission'] = $this->zoom_model->get_zoom_by_id($ID);
           }
           
            if(is_array($this->data['GetPermission']))

          {
              $this->data['ID']        = $this->data['GetPermission']['ID'] ;
              
               $this->data['Name']        = $this->data['GetPermission']['Name'] ;

              $this->data['EmpID']        = $this->data['GetPermission']['EmpID'] ;

              $this->data['SchoolID']    = $this->data['GetPermission']['SchoolID'] ;
              
               $this->data['LevelID']    = $this->data['GetPermission']['LevelID'] ;

              $this->data['RowID']         = $this->data['GetPermission']['RowID'] ;

              $this->data['ClassID']       = $this->data['GetPermission']['ClassID'] ;
              
            //  $this->data['LevelID']     = $this->data['GetPermission']['LevelID'] ;
            
            $this->data['level']           =  $this->zoom_model->get_all_level($this->data['Lang'],$this->data['SchoolID']);
            
             $this->data['row']           =  $this->zoom_model->get_all_row($this->data['Lang'],$this->data['SchoolID'],$this->data['LevelID']);
         
          $this->data['class']           =  $this->zoom_model->get_all_class($this->data['Lang'],$this->data['SchoolID'],$this->data['LevelID'],$this->data['RowID']);

              

          }

          $this->load->admin_template('view_new_premission_zoom', $this->data);

      }


        public function add_permission_zoom($ID=0)

        {
            
            
        $this->data['ID'] = $ID;
        
        $this->data['Name']         = filter_var($this->input->post('Name'), FILTER_SANITIZE_STRING);
        
        $this->data['EmpID']         = $this->input->post('emp')  ;

        $this->data['SchoolID']     = $this->input->post('SchoolID') ;

        $this->data['LevelID']       = $this->input->post('LevelID') ;

        $this->data['RowID']      = $this->input->post('RowID') ;
        
        $this->data['ClassID']      = implode(',' , $this->input->post('ClassID')) ;
        
         $query=$this->db->query("select Name from zoom_premission where SchoolID=".$this->session->userdata('SchoolID')." and Name='".$this->data['Name']."'  ")->row_array();  
      
      if(empty($query)){
		if($ID==0){
        if($this->zoom_model->add_permission($this->data))

        {

            $this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));

        }else{

            $this->session->set_flashdata('ErrorAdd',lang('br_add_error'));

        }

        } else{
            if($this->zoom_model->edit_permission($this->data))

        {

            $this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));

        }else{

            $this->session->set_flashdata('ErrorAdd',lang('br_add_error'));

        }
            
        }
 }
  else{
      
        redirect('admin/zoom_premission/add_new_permission_zoom/-1','refresh');
    }
        redirect('admin/zoom_premission/all_permission_zoom','refresh');



    }
     public function delete_permission_zoom($ID = 0 )

    {
         if($this->zoom_model->delete_permission($ID))

        {

            $this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));

        }else{

            $this->session->set_flashdata('ErrorAdd',lang('br_add_error'));

        }
         redirect('admin/zoom_premission/all_permission_zoom','refresh');
    }
     public function add_meeting_zoom($ID)

    {   
     $ids='';
     $Group_ID = $this->input->post('group_id') ;
     $category         = $_POST['category'] ;
    
        if($_POST['category']=='levels'){
           $levels= $this->input->post('to_user');
            
            foreach($levels as $level){
                 //print_r($level);die;
              $data['Level'] =   array(
                'Level_ID' => $level,
                'Group_ID'=>$Group_ID
                );
               
                 $this->zoom_model->add_permission_new($category,$data);
            }
       
        } elseif($_POST['category']=='row'){
            
            $RowLevels= $this->input->post('to_user');
            foreach($RowLevels as $RowLevel){
                $data['RowLevel'] =   array(
                'RowLevel' => $RowLevel,
                'Group_ID'=>$Group_ID 
                );
               
                 $this->zoom_model->add_permission_new($category,$data);
            }     
        }elseif(($_POST['category']=='class')||($_POST['category']=='U-class'))
        {
            $Classes= $this->input->post('to_user');
            
            foreach($Classes as $Class){
                $class_array=explode(',',$Class);
                $RowLevels=$class_array[0];
                $Clas=$class_array[1];
                $data['class'] =   array(
                'class' => $Clas,
                'RowLevels'=> $RowLevels,
                'Group_ID'=>$Group_ID
                );
               
                 $this->zoom_model->add_permission_new($category,$data);
            }     
         
        }else{
            
         $this->data['Contact_ID']     = implode(',', $_POST['to_user']);
         
        }
         $this->data['Group_ID']         = $this->input->post('group_id') ;
           $idContact = (int)$this->session->userdata('id');
          $this->Date       = date('Y-m-d H:i:s');
          $this->db->query("UPDATE zoom_premission SET Updated_by =".$idContact.", 	Updated_at='".$this->Date."'  WHERE zoom_premission.ID =".$this->data['Group_ID']." ");
         if($this->zoom_model->add_permission1($this->data))

        {
            

            $this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));

        }else{

            $this->session->set_flashdata('ErrorAdd',lang('br_add_error'));

        }
        
         redirect('admin/zoom_premission/all_permission_zoom','refresh');
    }

    public function getLevelIds($level)
    {
    $SchoolID   = (int)$this->session->userdata('SchoolID'); 
        
            return $this->db
                        ->select('contact.ID')
                        ->join('father', 'father.Contact_ID = contact.ID')
                        ->join('student', 'student.Father_ID = father.Contact_ID')
                        ->join('contact as st', 'st.ID = student.Contact_ID')
                        ->join('row_level', 'row_level.ID = student.R_L_ID')
                        ->where(array('row_level.Level_ID'=>$level, 'contact.SchoolID'=>$SchoolID, 'contact.Isactive'=>1))
                        ->get('contact')
                        ->result();
         
    }

    public function getRowIds($row)
    {
    $SchoolID   = (int)$this->session->userdata('SchoolID'); 
        
   
                          return $this->db
                        ->select('contact.ID') 
                        ->join('student  ', 'contact.ID = student.Contact_ID')
                        ->where(array('student.R_L_ID'=>$row, 'contact.SchoolID'=>$SchoolID, 'contact.Isactive'=>1, 'contact.type'=>'S'))
                        ->get('contact')
                        ->result();
                        
                        
         
    }
    
     public function getClassIds($row,$class)
    {
    $SchoolID   = (int)$this->session->userdata('SchoolID'); 
        
   
                          return $this->db
                         ->select('contact.ID') 
                        ->join('student  ', 'contact.ID = student.Contact_ID')
                        ->where(array('student.R_L_ID'=>$row,'student.Class_ID'=>$class, 'contact.SchoolID'=>$SchoolID, 'contact.Isactive'=>1, 'contact.type'=>'S'))
                        ->get('contact')
                        ->result();
                        
                        
         
    }

	public function show_details1()

    {
         $this->data['ID'] = $this->uri->segment(4);
         $this->data['students']           = $this->zoom_model->get_student_new($this->data['ID']);
        $this->load->admin_template('view_zoom_show_details',$this->data);
    }
    
    public function show_deleted()

    {
         $this->data['ID'] = $this->uri->segment(4);
         $this->data['students']           = $this->zoom_model->get_student_deleted($this->data['ID']);
        $this->load->admin_template('view_zoom_permission_deleted',$this->data);
    }
    /////////////////////////////////////
    public function get_group_name($ID = 0 )

    {
        $this->data['ID'] = $this->uri->segment(4);
        
        $ID=$this->data['ID'];
        
     //   $this->data['details']           = $this->zoom_model->get_groupname($ID);
     
        $this->load->admin_template('view_edit_group_zoom',$this->data);
    }
    //////////////////////////////
    public function edit_group_name( )

    {
         $ID = $this->uri->segment(4);
        
         $idContact = (int)$this->session->userdata('id');
         
         $name = filter_var($this->input->post('Name'), FILTER_SANITIZE_STRING);
        
         $this->Date       = date('Y-m-d H:i:s');
        
         $query=$this->db->query("select Name from zoom_premission where SchoolID=".$this->session->userdata('SchoolID')." and Name='".$name."'  ")->row_array();  
      
      if(empty($query)){
         if(  $this->db->query("UPDATE zoom_premission  SET zoom_premission.Name = '".$name."',Updated_by =".$idContact.", 	Updated_at='".$this->Date."'  WHERE zoom_premission.ID =$ID ") )

        {

            $this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));

        }else{

            $this->session->set_flashdata('ErrorAdd',lang('br_add_error'));

        }
      }else{
          
          redirect('admin/Zoom_premission/get_group_name/'.$ID."/".'-1','refresh');
      }
         redirect('admin/zoom_premission/all_permission_zoom','refresh');

        $this->load->admin_template('view_edit_group_zoom',$this->data);
    }
    ////////////////////////
     public function delete_meeting_zoom($ID = 0 )

    {
         //  if(  $this->db->query("UPDATE Zoom_Details  SET Contact_ID =NULL  WHERE Zoom_Details.Group_ID =$ID ") )
        //  $ID=$this->data['ID'];
        $this->data['ID'] = $this->uri->segment(4);
        
          if($this->supervisor_model->zoom_model->delete_meeting1($this->data['ID'])&&
         $this->zoom_model->delete_group_level($this->data['ID'])&&
         $this->zoom_model->delete_group_row($this->data['ID'])&&
         $this->zoom_model->delete_group_class($this->data['ID'])&&
         $this->zoom_model->delete_group_ExcludedContacts($this->data['ID'])&&
         $this->supervisor_model->zoom_model->delete_meeting($this->data['ID']))
       

        {

            $this->session->set_flashdata('SuccessAdd',"تم حذف أعضاء المجموعه");

        }else{

            $this->session->set_flashdata('ErrorAdd',lang('br_add_error'));

        }
         redirect('admin/zoom_premission/all_permission_zoom','refresh');
    }
    public function delete_user_from_group() 
	{
	$contacts=array(); 
 
	     $group_id=$this->input->post('group_id') ; 
	    $ids=$this->input->post('ids') ; //  print_r($ids)  ;echo '<br>'; 
	   
	     $query = $this->db->query("SELECT Contact_ID FROM Zoom_Details WHERE Group_ID ='$group_id'   ")->result() ;   
 
			foreach($query as $Key=>$Result)
			{$group_user=$Result->Contact_ID;	
			}
			
 
	     foreach ($ids as $value )
                        {   
                            
  // if in                           
   $group_user= str_replace(",$value,", ",",$group_user  );//echo '<br><br>';  


 $strnlen= strlen($value);
 $strnlen=$strnlen+1;
  
 // if end
 if(",$value"== substr($group_user, -$strnlen)){
//echo $value;
   $group_user =  substr_replace($group_user ,"",-$strnlen);//echo '<br><br>';  
 } 
 // if start
     $group_user = preg_replace('/^' . preg_quote("$value,", '/') . '/', '', $group_user);//echo '<br><br>';  
 if( $value==  $group_user ){ 
   $group_user = '';//echo '<br><br>';  
 }   

 $this->db->query("UPDATE Zoom_Details  SET Contact_ID = '$group_user'  WHERE Zoom_Details.Group_ID =$group_id  ")  ;
                         
                        }
	    
	       $this->session->set_flashdata('SuccessAdd',"تم حذف الاعضاء بنجاح  ");
   redirect("admin/zoom_premission/show_details1/$group_id",'refresh');  
   
   
	}
	 public function delete_user_from_group_new() 
	{
	    $UID=$this->session->userdata('id');
	    
        $DATE=date("Y-m-d H:i:s");
        
	     $group_id=$this->uri->segment(4) ; 
	     
	     $ids=$this->input->post('ids') ; 
	     
	    $arr=[];
	    foreach($ids as $value)
	    {
	       array_push($arr,$value); 
	    }
	    $contacts=implode(',',$arr);
      
       if($contacts){
       $this->db->query("
        INSERT INTO Zoom_Permissions_ExcludedContacts(ZoomPermissionsID,Contact_ID,Deleted_by,Date)
        select $group_id as ZoomPermissionsID,T.Contact_ID as Contact_ID, $UID AS Deleted_by , '$DATE' AS Date FROM(
        SELECT ID as Contact_ID  FROM contact where ID IN  ( $contacts)
        )AS T
         ");
	 $this->db->query("UPDATE zoom_premission SET Updated_by =".$UID.", 	Updated_at='".$DATE."'  WHERE zoom_premission.ID =".$group_id." ");
		
	       $this->session->set_flashdata('SuccessAdd',"تم حذف الاعضاء بنجاح  ");

       }else{
           
           $this->session->set_flashdata('ErrorDelete',"برجاء اختيار اعضاء للحذف  ");
           
       }
       
          redirect("admin/zoom_premission/show_details1/$group_id",'refresh');  
   
	}
	
	public function return_deleted_contact() 
	{
	    $UID=$this->session->userdata('id');
	    
        $DATE=date("Y-m-d H:i:s");
        
	     $group_id=$this->uri->segment(4) ; 
	     
	     $ids=$this->input->post('ids') ; 
	     
	    $arr=[];
	    foreach($ids as $value)
	    {
	       array_push($arr,$value); 
	    }
	    $contacts=implode(',',$arr);
      

       $this->db->query("
        INSERT INTO temp_zoom_permission(ZoomPermissionsID,Contact_ID,Deleted_by,Date)
        select $group_id as ZoomPermissionsID,T.Contact_ID as Contact_ID, $UID AS Deleted_by , '$DATE' AS Date FROM(
        SELECT ID as Contact_ID  FROM contact where ID IN  ( $contacts)
        )AS T
         ");
         $query= $this->db->query("SELECT  Contact_ID FROM Zoom_Details WHERE Group_ID=".$group_id." ")->row_array();
         if(empty($query)){
             
             $this->db->query("
        INSERT INTO Zoom_Details
        SET
        Group_ID      = ".$group_id." ,
        Contact_ID    = '".$contacts."'
         ");
         }
         else{
             
            $this->db->query("
       UPDATE Zoom_Details
        SET
        Contact_ID   =CONCAT('".$query['Contact_ID']."' , ',' , '".$contacts."')
        WHERE Group_ID = ".$group_id."
         ");  
         }
         
          $this->db->query("
        DELETE FROM Zoom_Permissions_ExcludedContacts where Contact_ID IN  ($contacts) AND ZoomPermissionsID= '".$group_id."'
       
         ");
         $this->db->query("UPDATE zoom_premission SET Updated_by =".$UID.", 	Updated_at='".$DATE."'  WHERE zoom_premission.ID =".$group_id." ");
	
		
	       $this->session->set_flashdata('SuccessAdd',"تم استعاده الاعضاء بنجاح");
   redirect("admin/zoom_premission/show_details1/$group_id",'refresh');  
   
   
	}
	public function summer_courses()
	{
	    $Data['courses_details']=$this->zoom_model->summer_courses_details();
	   // PRINT_R($Data['courses_details']);DIE;
	    $this->load->admin_template('view_summer_ courses',$Data);   
	}
	
	 public function add_summer_courses()

        {
            
        
        $this->data['course_name']         = $this->input->post('course_name')  ;
        
        $this->data['details']         = $this->input->post('details')  ;

        $this->data['date_from']     = $this->input->post('date_from') ;

        $this->data['date_to']       = $this->input->post('date_to') ;
        
        $this->data['date_anno']       = $this->input->post('date_anno') ;
        
        $this->data['date_anno2']       = $this->input->post('date_anno2') ;
        
        $this->data['row_level']       = implode(',',$this->input->post('row_level[]') );

        if($this->zoom_model->add_summer_courses($this->data))

        {

            $this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));

        }else{

            $this->session->set_flashdata('ErrorAdd',lang('br_add_error'));

        }

        redirect('admin/zoom_premission/summer_courses','refresh');



    }
    
    public function delete_summer_courses($ID = 0 ,$GroupID=0)

    {
         if($this->zoom_model->delete_summer_courses($ID,$GroupID))

        {

            $this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));

        }else{

            $this->session->set_flashdata('ErrorAdd',lang('br_add_error'));

        }
         redirect('admin/zoom_premission/summer_courses','refresh');
    }
    
    public function edit_summer_courses()

        {
        
        $this->data['ID']         = $this->uri->segment(4)  ;
        
        $this->data['GroupID']         = $this->uri->segment(5)  ;
        
        $this->data['course_name']         = $this->input->post('course_name2')  ;
        
        $this->data['details']         = $this->input->post('details2')  ;

        $this->data['date_from']     = $this->input->post('date_from2') ;

        $this->data['date_to']       = $this->input->post('date_to2') ;
        
        $this->data['adver_start']       = $this->input->post('adver_start') ;
        
        $this->data['adver_finish']       = $this->input->post('adver_finish') ;
        
        $this->data['row_level2']       = implode(',',$this->input->post('row_level2[]') );

        if($this->zoom_model->edit_summer_courses($this->data))

        {

            $this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));

        }else{

            $this->session->set_flashdata('ErrorAdd',lang('br_add_error'));

        }

        redirect('admin/zoom_premission/summer_courses','refresh');



    }
    

}