<?php
class Content_Management_Model extends CI_Model{
    
    function __construct()
    {
	   parent::__construct();
	   $this->Date  = date('Y-m-d H:i:s');
	   $this->Encryptkey = $this->config->item('encryption_key');
    }
    /////////////////// 
    public function get_school_setting()
    {
        $query = $this->db->query("select * from setting ")->row_array();

        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
    ///////////////////
    public function update_setting( $data=array())
    {
        extract($data);
		 $DataInsert = array
		  (
		  'main-color'                 =>$main_color ,
		  'main-color2'                =>$main_color2,
		  'primary-color'              =>$primary_color,
		  'hover_color'                =>$hover_color,
		  'home_color'                 =>$home_color,
		  'logo'                       =>$logoimg
		  );
		  
		if($this->db->update('setting', $DataInsert)){return TRUE ;}else{return FALSE ;}
    }
    //////////////////////////
    public function get_social_data()
    {
        $query = $this->db->query("SELECT * FROM `contact_us`")->row_array();

        if(sizeof($query)> 0 ){return $query;}else{return FALSE;}
    }
    ///////////////////
	public function add_call_us($data = array())
	{ 
		extract($data);
		 $id = 1;
		 $DataInsert = array
		  (
		  'youtube'          =>$youtube,
		  'facebooklink'     =>$facebook,
		  'twitterlink'      =>$twitter,
		  'snapchat'         =>$snapchat."||".$snapchat_name,
		  'instagramLink'    =>$Instagram,
		  'google-plus'      =>$google_plus ,
		  'tiktok'           =>$tiktok ,
		  'web_page'         =>$web_page ,
		  'school_map'       =>$Map_school,
		  'Mobile'           =>$phone ,
		  'Email'            =>$e_mail ,
		  'Adress'           =>$title ,
		  'whatsapp_number'  =>$whatsup_phone,
		  'linkedin'         =>$linkedin,
		  'AdressEn'         =>$AdressEn
		  );

		if($this->db->update('contact_us', $DataInsert)){return TRUE ;}else{return FALSE ;}
	}
}