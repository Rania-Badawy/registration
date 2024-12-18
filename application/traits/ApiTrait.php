<?php
trait ApiTrait
{
    public function ApiGet($url)
    {
        $curl = curl_init();
        
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($curl);
        
        // if ($response === false) {
        //     $error = curl_error($curl);
        //     die('Error: ' . $error);
        // }
        
        curl_close($curl);
        
        $data = json_decode($response, true);
        
        // if ($data) {
            return $data;
        // } else {
        //     die('Error: Invalid response.');
        // }
    }

    public function ApiPost($data)
    {
        
        $url = 'https://chat.lms.esol.com.sa/apikey/bank/question';

		$data = http_build_query($data);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		$response = curl_exec($ch);
		curl_close($ch);
        return $response;
    }
}

?>