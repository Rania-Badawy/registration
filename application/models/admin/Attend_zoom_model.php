<?php
class Attend_zoom_Model extends CI_Model{
    private $Token           = '' ;
    function __construct()
    {
        parent::__construct();
        $this->Date       = date('Y-m-d H:i:s');
        // $this->Encryptkey = $this->config->item('encryption_key');
        // $this->Token      = $this->get_token();
    }
    public function attend_zoom()
    {
        $query = $this->db->query("SELECT send_box_zoom.*,contact.Name AS Name,zoom_meetings.topic AS topic,zoom_meetings.start_time as start_time ,send_box_zoom.date AS Date_join  FROM send_box_zoom 
inner JOIN contact on send_box_zoom.contact_id =contact.ID
INNER JOIN zoom_meetings on zoom_meetings.meeting_id=send_box_zoom.meeting_id

")->result();
        if(sizeof($query)> 0 ){return $query;}else{return FALSE ;}
    }
}