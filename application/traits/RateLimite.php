<?
trait RateLimite
{
    public function rate($AvailbaleRateCount, $inPerScand)
    {
        $CI = &get_instance();
        $CI->load->database();

        $max_requests_per_minute = $AvailbaleRateCount;
        $ip_address = $_SERVER['REMOTE_ADDR'];

        $query = $CI->db->where('ip_address', $ip_address)->get('rate_limiting');
        $data = $query->row();

        if ($data) {
            $time_passed = strtotime(date('Y-m-d H:i:s')) - strtotime($data->first_request);
            if ($time_passed < $inPerScand) {
                if ($data->request_count >= $max_requests_per_minute) {
                    $this->session->set_flashdata('message', 'تم تجاوز الحد المسموح به من الطلبات .');
                    redirect('/');
                } else {
                    $CI->db->set('request_count', 'request_count+1', FALSE)
                        ->where('ip_address', $ip_address)
                        ->update('rate_limiting');
                }
            } else {
                $CI->db->where('ip_address', $ip_address)
                    ->update('rate_limiting', ['request_count' => 1, 'first_request' => date('Y-m-d H:i:s')]);
            }
        } else {
            $CI->db->insert('rate_limiting', ['ip_address' => $ip_address, 'request_count' => 1]);
        }
    }
}
