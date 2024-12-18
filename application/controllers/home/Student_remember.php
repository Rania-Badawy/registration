<?php if(!defined('BASEPATH'))exit('No direct script access allowed');
include APPPATH . 'third_party/recaptchalib.php';
class Student_Remember extends CI_Controller{

	private $data = array() ;

	function __construct()

    {
	   parent::__construct();
	    $this->load->model(array('admin/Report_Register_model','admin/setting_model','admin/mobile_model'));
		$this->load->helper('language');
		$this->data['Lang'] = $this->session->userdata('language');
	    if($this->data['Lang'] )
	    {
			$this->lang->load('am',$this->session->userdata('language'));
			$this->lang->load('er',$this->session->userdata('language'));
		}
	    else{$this->lang->load('am','arabic');$this->lang->load('er','arabic');};
    }

    ////index	
	public function send_direct( )
    {
           $Timezone   = $this->setting_model->converToTimezone();
           $date_ago   =  date('Y-m-d', strtotime('-1 days', strtotime($Timezone)));
           $date      = date('Y-m-d H:i:s',strtotime($Timezone));
           $query =$this->db->query("SELECT  register_form.* , student_register_type.*, student_register_type.ID as register_type_ID, contact.Mail ,register_form.levelName as level_name
                                    FROM register_form 
                                    inner JOIN student_register_type on register_form.id = student_register_type.reg_id
                                    inner JOIN contact on contact.ID = student_register_type.emp_id
                                    WHERE student_register_type.send_email=0  and TIMESTAMPDIFF(MINUTE,student_register_type.remember_date,'$date') =0  limit 400")->result(); 
                                    // print_r($query);die;
           foreach($query as $item){
                $employees       = $this->Report_Register_model->reg_employee1($item->LevelID ,$item->schoolID);
                $from    = $this->config->item('smtp_user');
                $subject = "تذكير باستكمال الطلب";
                $msg     =  " الرجاء استكمال الطلب المقدم باسم ".$item->name." للمرحله ".$item->level_name." علي الرابط: ".PHP_EOL.site_url('admin/Report_Register/view_student_register_new/'.$item->id);
                
                foreach($employees as $item1){
                    $to =  $item1->Mail;
                     $this->mobile_model->send_mail($to,$subject,$msg,'');
                }
            $this->db->query("UPDATE student_register_type  SET send_email = 1  WHERE student_register_type.ID = ".$item->register_type_ID." "); 
        }
        
    }
}