<?php 

 $query = $this->db->query("SELECT employee.jobTitleID,IsAdmin FROM employee
 inner join contact on employee.Contact_ID =contact.ID
 left join permission_group on contact.GroupID=permission_group.ID
 WHERE contact.ID = '".$this->session->userdata('id')."' ")->row_array();
  if( $query['jobTitleID'] != 0 && !(substr($_SERVER['REQUEST_URI'], 0, 13 ) === "/emp/requests")&& !(substr($_SERVER['REQUEST_URI'], 0, 26 ) === "/chatting_new/conversation")
                                &&!(substr($_SERVER['REQUEST_URI'], 0, 14 ) === "/emp/exam_new/")&&!(substr($_SERVER['REQUEST_URI'], 0, 19 ) === "/emp/pic/uplodeFile")&&!(substr($_SERVER['REQUEST_URI'], 0, 25 ) === "/emp/zoom/listZoomMeeting"))
  {  
  
		 $this->load->view('emp/header_admin');  
   }else
   {
     if(substr($_SERVER['REQUEST_URI'], 0, 7 ) === "/admin/"){
         $this->load->view('admin/header');
     }else{
	 $this->load->view('emp_new/header_emp');

   }
   }

?>

