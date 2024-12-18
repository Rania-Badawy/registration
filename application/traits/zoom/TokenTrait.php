<?php
trait TokenTrait
{
    public function GetToken()
    {
        $query = $this->db->select('INFO, updated_at')
            ->from('zoom_settings')
            ->limit(1)
            ->get();

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $token = $row->INFO;
            $updated_at = $row->updated_at;
        } else {
            echo "No results found.";
        }
        $current_datetime = date('Y-m-d H:i:s');
        $token_lifetime = strtotime($current_datetime) - strtotime($updated_at);

        if ($token_lifetime > 3600) {
            $new_token = $this->UpdateToken();

            $this->db->set('INFO', $new_token);
            $this->db->set('updated_at', $current_datetime);
            $this->db->update('zoom_settings');
            return $new_token;
        } else {
            return $token;
        }
    }


    public function UpdateToken()
    {
         $account_id = '8Rfar3hqTpW4ZTTUcYe9jw';
        $client_id = 'bz_9g_kaTUSlWjXFkty4Q';
        $client_secret = 'JTYMgySem24RiMeCUbOCyhNbFcByEKnR';

        $data = array( 
            'grant_type' => 'account_credentials',
            'account_id' => $account_id,
        );

        $headers = array(
            'Host: zoom.us',
            'Authorization: Basic ' . base64_encode($client_id . ':' . $client_secret),
        );

        $ch = curl_init('https://zoom.us/oauth/token');

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

              $response = json_decode(curl_exec($ch));
        curl_close($ch);

        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        } else {
            return $response->access_token;
        }

    }
}
