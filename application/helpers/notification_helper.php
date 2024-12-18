<?php 

function add_notification($NotificationID = 0,$Type = 0,$RowLevelID = 0,$SubjectID = 0,$ClassID = 0 , $StudentID = 0)
{
	$CI = &get_instance();
	$CI->load->model('admin/notification_model');
	$CI->notification_model->add_notification_emp($NotificationID,$Type,$RowLevelID,$SubjectID,$ClassID , $StudentID );
	
}
   function validateDate($date) {
        $format = 'Y-m-d h:i'; // Eg : 2014-09-24 10:19 PM
        $dateTime = DateTime::createFromFormat($format, $date);
    
        if ($dateTime instanceof DateTime && $dateTime->format('Y-m-d h:i') == $date) {
            return true;
        }else{
             return false;
        }
    
       
    }
?>