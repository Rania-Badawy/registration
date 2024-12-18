<?php if(!defined('BASEPATH')) exit('No direct script access allowed');ini_set('default_charset','UTF-8');
class Get_Room_Create{
	private $CI ;
   function __construct()
   {
			$this->CI =& get_instance();
			$this->CI->load->library('nusoap_base');
  }/////////////get_hash
   public function GetHashRoom($userData = array())
     {
		 $client_userService = new nusoap_client("http://2smartedu.com:5080/openmeetings/services/UserService?wsdl", array("trace" =>1, "exceptions"=>0,'encoding'=>'UTF-8'));
    //$client_userService->setUseCurl(true);
	$err = $client_userService->getError();
	if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
	echo '<h2>Debug</h2><pre>' .
	htmlspecialchars($client->getDebug(),
	ENT_QUOTES) . '</pre>';
	exit();
	}
	$client_roomService = new nusoap_client("http://2smartedu.com:5080/openmeetings/services/RoomService?wsdl", array("trace" =>1, "exceptions"=>0,'encoding'=>'UTF-8'));
	 //$client_userService->setUseCurl(true);
	$err = $client_roomService->getError();
	$client_roomService->decode_utf8== true;
	if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
	echo '<h2>Debug</h2><pre>' .
	htmlspecialchars($client->getDebug(),
	ENT_QUOTES) . '</pre>';
	exit();
	}
	$err = $client_userService->getError();
	if ($err) {return FALSE ;}//////// end test conection 
	
	$resultSesssion = $client_userService->call('getSession');
	if ($client_userService->fault)
	{return FALSE ;}
	else
	{
	$err = $client_userService->getError();
	if ($err) {return FALSE ;}
	else
	{
		$client_userService->session_id = $resultSesssion["return"]["session_id"]; 
	    $paramsSesssion = array(
		'SID' => $client_userService->session_id,
		'username' => 'softraysc',
		'userpass' => 'qGVp3NyHKx62g'
		);
		//$params = array();
		$autologin = $client_userService->call('loginUser',$paramsSesssion);
		if ($client_userService->fault)
		{
		echo '<h2>Fault (Expect - The request contains an invalid SOAP
		body)'.$autologin.'</h2><pre>';
		echo '</pre>';
		 exit() ;
		}
		else
		{
		  $err = $client_userService->getError();
		  if ($err) {
		  echo '<h2>Error</h2><pre>' . $err . '</pre>';
		  exit() ;
		}
	}
	
	 extract($userData);
						$paramsGetHashRoom = array(
													'SID' => $client_userService->session_id ,
													"username"=>$username,
													"room_id"=>$room_id,
													"isPasswordProtected"=>true,
													"invitationpass"=>$invitationpass ,
													"valid"=>3 ,
													"validFromDate"=>$validFromDate ,
													"validFromTime"=>$validFromTime ,
													"validToDate"=>$validToDate,
													"validToTime"=>$validToTime 
						                        );
						
						$GetHashRoom =
						$client_roomService->call('getInvitationHash',$paramsGetHashRoom);
						if ($client_roomService->fault) {
						echo '<h2>Fault (Expect - The request contains an invalid SOAP
						body)</h2><pre>'; print_r($GetHashRoom); echo '</pre>' ;exit();
						} else {
						$err = $client_roomService->getError();
						if ($err) {
						echo '<h2>Error</h2><pre>' . $err . '</pre>';exit();
						}
						 else
						 {
						    return $GetHashRoom["return"] ;        
						//return $addroom["return"];
						// invit_hash  ----   
						//2smartedu.com:5080/openmeetings/?invitationHash=06b62398493e03c7c631bf3ea7771e13&language=1
						}
				}
	     }
 	   }
     }/////////////////GenerateRoomHash
	 public function GenerateRoomHash($userData = array())
	 {
		 $client_userService = new nusoap_client("http://2smartedu.com:5080/openmeetings/services/UserService?wsdl", array("trace" =>1, "exceptions"=>0,'encoding'=>'UTF-8'));
    //$client_userService->setUseCurl(true);
	$err = $client_userService->getError();
	if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
	echo '<h2>Debug</h2><pre>' .
	htmlspecialchars($client->getDebug(),
	ENT_QUOTES) . '</pre>';
	exit();
	}
	$client_roomService = new nusoap_client("http://2smartedu.com:5080/openmeetings/services/RoomService?wsdl", array("trace" =>1, "exceptions"=>0,'encoding'=>'UTF-8'));
	 //$client_userService->setUseCurl(true);
	$err = $client_roomService->getError();
	$client_roomService->decode_utf8== true;
	if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
	echo '<h2>Debug</h2><pre>' .
	htmlspecialchars($client->getDebug(),
	ENT_QUOTES) . '</pre>';
	exit();
	}
	$err = $client_userService->getError();
	if ($err) {return FALSE ;}//////// end test conection 
	
	$resultSesssion = $client_userService->call('getSession');
	if ($client_userService->fault)
	{return FALSE ;}
	else
	{
	$err = $client_userService->getError();
	if ($err) {return FALSE ;}
	else
	{
		$client_userService->session_id = $resultSesssion["return"]["session_id"]; 
	    $paramsSesssion = array(
		'SID' => $client_userService->session_id,
		'username' => 'softraysc',
		'userpass' => 'qGVp3NyHKx62g'
		);
		//$params = array();
		$autologin = $client_userService->call('loginUser',$paramsSesssion);
		if ($client_userService->fault)
		{
		echo '<h2>Fault (Expect - The request contains an invalid SOAP
		body)'.$autologin.'</h2><pre>';
		echo '</pre>';
		 exit() ;
		}
		else
		{
		  $err = $client_userService->getError();
		  if ($err) {
		  echo '<h2>Error</h2><pre>' . $err . '</pre>';
		  exit() ;
		}
	}
	 extract($userData);
						$paramsUserObject = array(
										'SID'                       => $client_userService->session_id ,
										"username"                  =>$username ,
										"firstname"                 =>$firstname  ,
										"lastname"                  =>$profilePictureUrl   ,
										"profilePictureUrl"         =>$email  ,
										"email"                     =>$externalUserId  ,
										"externalUserId"            =>$externalUserType  ,
										"externalUserType"          =>$externalUserType   ,
										"room_id"                   =>$room_id   ,
										"becomeModeratorAsInt"      =>$becomeModeratorAsInt   ,
										"showAudioVideoTestAsInt"   =>$showAudioVideoTestAsInt   
										);
										$getRoomsHash =
									$client_userService->call('setUserObjectAndGenerateRoomHashByURL',$paramsUserObject);
										if ($client_roomService->fault) {
										echo '<h2>Fault (Expect - The request contains an invalid SOAP
										body)</h2><pre>'; print_r($client_roomService->fault); echo '</pre>';exit();
										} else {
										$err = $client_roomService->getError();
										if ($err) {
										echo '<h2>Error</h2><pre>' . $err . '</pre>';
										} else {
										return $getRoomsHash["return"];
									}
								}
	     }
 	   }
	 }
}///// END OF LIBRARY 

?>