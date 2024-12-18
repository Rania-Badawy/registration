<?php

     function authuser($type,$userid){
     	$CI = &get_instance();
        $CI->load->model('config/contact_model');
        $result = $CI->contact_model->auth_user($userid);
        if($result['Type'] == $type ){
            return true;            
        }else{
            return false;
        }

    }
    
     function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
            return $randomString;
     }
     
if (!function_exists('dd')) {
    /**
     * Dump and Die
     *
     * @param mixed $data Data to be dumped
     */
    function dd($data) {
        echo '<pre>';
        echo json_encode($data, JSON_PRETTY_PRINT);
        echo '</pre>';
        die();
    }
    
}