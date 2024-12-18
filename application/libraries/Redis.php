<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'config/redis/config.php';

class Redis extends Predis\Client {

    public function __construct($params = array()) {
        parent::__construct($params ?: array(
            'scheme' => $this->socket_type,
            'host'   => $this->host,
            'port'   => $this->port,
            'password' => $this->password,
            'timeout' => $this->timeout
        ));
    }

}