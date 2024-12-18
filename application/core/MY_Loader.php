<?php
/**
 * /application/core/MY_Loader.php
 *
 */
class MY_Loader extends CI_Loader {
	
	private $CI ;
	function __construct()
    {
        parent::__construct();
        $this->CI =& get_instance();
        
    }
	
	/////////////home_template
    public function home_template($template_name, $vars = array(), $return = FALSE)
    {
        $query=$this->CI->db->query("select home_type from setting")->row_array();
        $home_theme=$this->CI->db->query("select home_theme from setting")->row_array();
        if($home_theme['home_theme']){
            $home_theme = '/'.$home_theme['home_theme'].'/';
        }else{
            $home_theme = '/';
        }
        if($query['home_type'] == 2){
    		$content  = $this->view('home_new'.$home_theme.'header', $vars, $return);
            $content  = $this->view('home_new'.$home_theme.$template_name, $vars, $return);
            if($query['ApiDbname'] != 'SchoolAccAbnaAlriyada'){
                $content  = $this->view('home_new'.$home_theme.'footer', $vars, $return);
            }else{
                $content  = $this->view('home_new/footer_ryada', $vars, $return);
            }
        }else{
            $content  = $this->view('home/header', $vars, $return);
            $content  = $this->view('home/'.$template_name, $vars, $return);
            $content  = $this->view('home/footer', $vars, $return);
        }
        
        if ($return)
        {
            return $content;
        }
    }
	public function admin_template($template_name, $vars = array(), $return = FALSE)
    {
         if(authuser('S' , $this->CI->session->userdata('id')) || authuser('A' , $this->CI->session->userdata('id')) || authuser('F' , $this->CI->session->userdata('id'))){
	     redirect('home/home', 'refresh');
	   }else{
	       	if($this->CI->session->userdata('type')=='E')
    		{$content  = $this->view('emp_new/header_admin', $vars, $return);}
    		 elseif($this->CI->session->userdata('type')=='U'){
    		$content  = $this->view('admin/header', $vars, $return);
	       
	   }
            
            $content = $this->view('admin/'.$template_name, $vars, $return);
            $content = $this->view('admin/footer', $vars, $return);
            if ($return)
            {
                return $content;
            }
	   }
	
    }/////////////emp_template
	public function emp_template($template_name, $vars = array(), $return = FALSE)
    {
           if( substr($_SERVER['REQUEST_URI'], 0, 14 ) === "/emp/exam_new/"){
               $content  = $this->view('emp_new/header_emp', $vars, $return);
               $content = $this->view('emp_new/'.$template_name, $vars, $return);
               $content = $this->view('emp_new/footer', $vars, $return);
           }else{
               $content  = $this->view('emp_new/header_admin', $vars, $return);
               $content = $this->view('emp_new/'.$template_name, $vars, $return);
               $content = $this->view('admin/footer', $vars, $return);
           }
	       
        		 
        	   
            if ($return)
            {
                return $content;
            }
	   //}
       
    }
	/////////////father_template
	public function father_template($template_name, $vars = array(), $return = FALSE)
    {
       if(authuser('S' , $this->CI->session->userdata('id')) || authuser('A' , $this->CI->session->userdata('id'))){
	     redirect('home/home', 'refresh');
	   }else{
	      /* if($this->CI->session->userdata('SchoolID')==1){
	       $content  = $this->view('father_new/header', $vars, $return);
        $content = $this->view('father_new/'.$template_name, $vars, $return);
        $content = $this->view('father_new/footer', $vars, $return);}
        else{
            $content  = $this->view('father/header', $vars, $return);
        $content = $this->view('father/'.$template_name, $vars, $return);
        $content = $this->view('father/footer', $vars, $return); 
        }*/
        $content  = $this->view('father_new/header', $vars, $return);
        $content = $this->view('father_new/'.$template_name, $vars, $return);
        $content = $this->view('father_new/footer', $vars, $return);
        if ($return)
        {
            return $content;
        }
	   }
        
    }
	/////////////student_template
	public function student_template($template_name, $vars = array(), $return = FALSE)
    {
	   //if(!authuser('S' , $this->CI->session->userdata('id'))){
	   //  redirect('home/home', 'refresh');
	   //}else{
	      /* if($this->CI->session->userdata('SchoolID')==1){
	           $content  = $this->view('student_new/header', $vars, $return);
            $content = $this->view('student_new/'.$template_name, $vars, $return);
            $content = $this->view('student_new/footer', $vars, $return);
	       }else{
	        $content  = $this->view('student/header', $vars, $return);
            $content = $this->view('student/'.$template_name, $vars, $return);
            $content = $this->view('student/footer', $vars, $return);}*/
              $content  = $this->view('student_new/header', $vars, $return);
            $content = $this->view('student_new/'.$template_name, $vars, $return);
            $content = $this->view('student_new/footer', $vars, $return);
            if ($return)
            {
                return $content;
            }
	   //}
        
    }
    
    	/////////////admin_template
	public function counseling_template($template_name, $vars = array(), $return = FALSE)
    {
		if($this->CI->session->userdata('type')=='E')
		{$content  = $this->view('emp/header', $vars, $return);}
		else if($this->CI->session->userdata('type')=='U')
		{$content  = $this->view('admin/header', $vars, $return);}
        
        $content = $this->view(''.$template_name, $vars, $return);
        $content = $this->view('admin/footer', $vars, $return);
        if ($return)
        {
            return $content;
        }
    }
    
    
    	/////////////job_template
    public function job_template($template_name, $vars = array(), $return = FALSE)
    {
	   // if(!authuser('A' , $this->CI->session->userdata('id'))){
	   //  redirect('home/home', 'refresh');
	   //}else{
	        $content  = $this->view('home/header', $vars, $return);
            $content = $this->view('home/'.$template_name, $vars, $return);
            $content = $this->view('home/footer', $vars, $return);
            if ($return)
            {
                return $content;
            }
	   //}
       
    }
}