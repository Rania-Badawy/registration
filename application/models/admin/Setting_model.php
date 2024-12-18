<?php
class Setting_Model extends CI_Model 
 { 
	function __construct()
    {
	   parent::__construct(); 
	   
	   
    } 
        public function get_api_setting()
        {
            $query = $this->db->query("select ApiDbname from setting")->result();
             if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
        }
        ////////////////////////
         function converToTimezone()
        {
          $today=date('Y-m-d H:i:s');  
         
          $query = $this->db->query("SELECT time_zone FROM school_details ")->row_array();

          $time_zone = $query['time_zone'];
          $fromTz="UTC";
          $date = new DateTime($today, new DateTimeZone($fromTz));
          $date->setTimezone(new DateTimeZone($time_zone));
          $time= $date->format('Y-m-d H:i:s');
          return $time;
      }
      /////////////////////////////
        function converToTimezone_api()
        {
          $today=date('Y-m-d H:i:s');  
          $query = $this->db->query("SELECT time_zone FROM school_details")->row_array();
          $time_zone = $query['time_zone'];
          $fromTz="UTC";
          $date = new DateTime($today, new DateTimeZone($fromTz));
          $date->setTimezone(new DateTimeZone($time_zone));
          $time= $date->format('Y-m-d H:i:s A');
          return $time;
      }
      /////////////////////////////
        function get_semester()
        {
          $Timezone    = $this->converToTimezone();
          $query       = $this->db->query("SELECT `ID` FROM `config_semester` WHERE date('".$Timezone."') BETWEEN `start_date` AND end_date")->row_array();
          if($query['ID']){
          $semester_id = $query['ID'];
          }else{
           $semester_id = 1;   
          }
          return $semester_id;
       }
       ///////////////////////////
        function get_semester_api()
        {
          $Timezone    = $this->converToTimezone_api();
          $query       = $this->db->query("SELECT `ID` FROM `config_semester` WHERE date('".$Timezone."') BETWEEN `start_date` AND end_date")->row_array();
          if($query['ID']){
          $semester_id = $query['ID'];
          }else{
           $semester_id = 1;   
          }
          return $semester_id;
        }
      /////////////////////////////
        function get_semester_byDate($date_to)
        {
          
          $query       = $this->db->query("SELECT `ID` FROM `config_semester` WHERE date('".$date_to."') BETWEEN `start_date` AND end_date")->row_array();
          if($query['ID']){
          $semester_id = $query['ID'];
          }else{
           $semester_id = 1;   
          }
          return $semester_id;
      }
      /////////////////////////////
        function get_week()
        {
          $Timezone    = $this->converToTimezone();
          $query       = $this->db->query("select week.ID  from week 
	                                       inner join config_semester on week.semester_id=config_semester.ID
	                                       where date('".$Timezone."') BETWEEN week.FromDate and week.ToDate")->row_array();
          if($query['ID']){
          $week_id = $query['ID'];
          }else{
           $week_id = 1;  
          }
          return $week_id;
      }
      /////////////////////////////
        function get_week_per_semester($SemesterID)
        {
          
          $query       = $this->db->query("SELECT * FROM `week` WHERE `semester_id` = $SemesterID ")->result();
          
          return $query;
      }
      //////////////////////
      function get_all_year()
        {
            
          $query = $this->db->query("SELECT * FROM `year`")->result();
         
          return $query;
      }
      //////////////////////
      function get_current_year()
        {
            
          $query = $this->db->query("SELECT * FROM `year` WHERE `IsActive` = 1")->row_array();
          
          $year_id = $query['ID'];
          return $year_id;
      }
      /////////////////////
     public function get_branches()
	{
	           $query = $this->db->query("SELECT SchoolID  FROM contact WHERE ID = '".$this->session->userdata('id')."' ")->row_array()['SchoolID'];
	           $SchoolID    = $query;
	           if($this->session->userdata('type')=='E'){
                  $school_emp       = $this->db->query("select school_id from permission_request where EmpID='".$this->session->userdata('id')."' ")->row_array()['school_id'];
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

	$UserType = $CI->session->userdata('type');  

	$api_name = $this->db->query("select ApiDbname from setting")->row_array()['ApiDbname'];

	if($UserType === 'U' )
	{
	     $GetLevel   = json_decode(file_get_contents(lang('api_link')."/api/RowLevels/$api_name/GetAllLevels"));
	     $GetLevel   = array_column($GetLevel, 'LevelId');
		
	}else
	{
	    	$GetLevel = $this->db->query("select Level from permission_request")->row_array();
	   	
	}
	if($GetLevel)
		{
			return $GetLevel ;
		}else{

			return false ;
		}
}

	/////////////////////////////
    function get_row_level_name($rowlevelid)
    {
      
      $query       = $this->db->query("SELECT CONCAT(Level_Name,'-',Row_Name) AS rowlevel_name  FROM `row_level` WHERE `ID` =  $rowlevelid ")->row_array();

      return $query['rowlevel_name'];
   }
   ////////////////////////
    public function acess_token()
	{   
	  
        $token_url = 'https://identity-server.esol.dev/connect/token';
        $client_id="cc.php.101";
        $client_secret="#cc.php#";
        $content = "grant_type=client_credentials";
    	$authorization = base64_encode("$client_id:$client_secret");
    	$header = array("Authorization: Basic {$authorization}","Content-Type: application/x-www-form-urlencoded");
    
    	$curl = curl_init();
    	curl_setopt_array($curl, array(
    		CURLOPT_URL => $token_url,
    		CURLOPT_HTTPHEADER => $header,
    		CURLOPT_SSL_VERIFYPEER => false,
    		CURLOPT_RETURNTRANSFER => true,
    		CURLOPT_POST => true,
    		CURLOPT_POSTFIELDS => $content
    	));
    	$response = curl_exec($curl);
    	curl_close($curl);
    	return json_decode($response)->access_token;
                
	}
	function get_semesters()
        {
          $query       = $this->db->query("SELECT ID,Name,Name_en,Token,start_date,end_date FROM `config_semester` WHERE Is_Active= 1")->result();
         
          return $query;
       }

  public function getUserGroup()
       {
        $query=  $this->db->query("SELECT DISTINCT ZoomPremissionID
                                    FROM  vw_zoom_premission_per_contact_select AS T
                                    INNER JOIN contact ON contact.ID = T.contactID 
                                    WHERE T.contactID = '".$this->session->userdata('id')."' ")->result();	
        
         return $query;
      }
      
         
}