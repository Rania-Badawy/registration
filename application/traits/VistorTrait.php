<?php
trait VistorTrait
{
    public function getAPIData($url, $token =null)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);

        
        // Check if a token is provided and set it in the request headers
        if ($token) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
            ]);
        }
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

    private function postAPIData($url, $dataArray)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($dataArray),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Cookie: AspxAutoDetectCookieSupport=1"
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        // print_R($response);die;
        return $response;
    }

    public function add_visitors($url)
    {
        $data = array(
            'ip' => $_SERVER['REMOTE_ADDR'],
        );
        $data = http_build_query($data);


        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_RETURNTRANSFER => true
        );

        $curl = curl_init();
        curl_setopt_array($curl, $options);

        $response = curl_exec($curl);

        curl_close($curl);

        $dataa = json_decode($response, true);

        return $dataa;
    }
}
