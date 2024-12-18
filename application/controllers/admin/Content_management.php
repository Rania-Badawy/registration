<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Content_management extends MY_Admin_Base_Controller{
	private $data = array() ;
	function __construct()
    {  
	  parent::__construct(); 
	   $this->load->model(array('admin/content_management_model','admin/setting_model')); 
	   $this->data['UID']            = $this->session->userdata('id');
	   $this->data['Semester']       = $this->session->userdata('Semester');
	   $this->data['Lang']           = $this->session->userdata('language');
	   $this->data['date']           = $this->setting_model->converToTimezone();
	   $get_api_setting              = $this->setting_model->get_api_setting();
	   $this->ApiDbname              = $get_api_setting[0]->{'ApiDbname'};
    }
    //////////////////////
    public function main_content_management()
	{
		$Data['get_setting']        = $this->content_management_model->get_school_setting();
		$this->load->admin_template('view_main_content_management',$Data);
	}
	////////////////////////////////
	public function update_setting()
	{
	    $Data['main_color']         = $this->input->post('main-color'); 
		$Data['main_color2']        = $this->input->post('main-color2'); 
		$Data['home_color']         = $this->input->post('home_color'); 
		$Data['primary_color']      = $this->input->post('primary-color'); 
		$Data['hover_color']        = $this->input->post('hover_color'); 
		$Data['logoimg']            = $this->input->post('hidImg');
		if($this->content_management_model->update_setting($Data))
			{
				$this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));
	            redirect('admin/content_management/main_content_management');
			}else{
			   
				$this->session->set_flashdata('ErrorAdd',lang('br_add_error'));
                redirect('admin/content_management/main_content_management');
		    }
	}
	/////////////////////////////////////////////////
	public function up_ax_content()
	{
		$this->data['msg_type']           = '';
		$this->data['msg_upload']         = '';
		$this->data['base']               = base_url();
		$file_element_name                = 'file';
		if(empty($_FILES[$file_element_name]['name']))
          {
			  $this->data['msg_type']           = '0';
			  $this->data['msg_upload']         = 'File Empty ';
			  $this->output->set_content_type('application/json')->set_output(json_encode($this->data));
		  }	
         else
			{	
					$config['upload_path']   = './intro/images/school_logo/';
			    	$config['allowed_types'] = 'jfif|mp3|wav|aif|aiff|ogg|MP3|gif|jpg|png|jpeg|doc|docx|txt|text|zip|rar|pdf|mp4|ppt|pptx|pptm|xls|xlsm|xlsx|m4p|M4P|PNG';
					$config['encrypt_name']  = TRUE;
					$this->load->library('upload', $config);
					if (!$this->upload->do_upload($file_element_name))
					{  
					     $this->data['msg_type']           = '0';
		                 $this->data['msg_upload']         = $this->upload->display_errors();
						 $this->output->set_header('Content-Type: application/json; charset=utf-8');
					     $this->output->set_content_type('application/json')->set_output(json_encode($this->data));
					}
					else
					{
							   $upload_data                      = $this->upload->data();
							   $this->data['msg_type']           = '1';
							   $this->data['msg_upload']         = 'msg_sucsess_upload';
							   $this->data['img']                = $upload_data['file_name'];
							   $this->output->set_header('Content-Type: application/json; charset=utf-8');
							   $this->output->set_content_type('application/json')->set_output(json_encode($this->data)); 
					}
					   
			}
	}
	//////////////////
	public function call_us()
	{
	    if(! $this->session->userdata('id'))
	    {redirect('home/login');}
		$Data['get_social_data']           = $this->content_management_model->get_social_data();
		$this->load->admin_template('view_call_us',$Data);
	}
	//////////////////
	public function add_call_us()
	{
	    $Data['youtube']         = $this->input->post('youtube') ; 
		$Data['facebook']        = $this->input->post('facebook');
		$Data['twitter']         = $this->input->post('twitter');
		$Data['snapchat']        = implode(",",$this->input->post('snapchat'));
		$Data['snapchat_name']   = implode(",",$this->input->post('snapchat_name'));
		$Data['Instagram']       = $this->input->post('Instagram');
		$Data['google_plus']     = $this->input->post('google_plus');
		$Data['web_page']        = $this->input->post('web_page');
		$Data['tiktok']          = $this->input->post('tiktok');
		$Data['linkedin']        = $this->input->post('linkedin');
		$Data['Map_school']      = implode(",",$this->input->post('Map_school'));
		$Data['phone']           = implode(",",$this->input->post('phone'));
		$Data['e_mail']          = implode(",",$this->input->post('e_mail')) ;
		$Data['title']           = implode(",",$this->input->post('title')) ;
		$Data['whatsup_phone']   = implode(",",$this->input->post('whatsup_phone')) ;
		$Data['AdressEn']        = implode(",",$this->input->post('AdressEn')) ;
        if($this->content_management_model->add_call_us($Data))
			{
				$this->session->set_flashdata('SuccessAdd',lang('br_add_suc'));
	            redirect('admin/content_management/call_us');
			}else{
				$this->session->set_flashdata('Failuer',lang('br_add_error'));
                redirect('admin/content_management/call_us');
		    }
	}
    
}