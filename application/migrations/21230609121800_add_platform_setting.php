<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_platform_setting extends CI_Migration
{
  public function up()
  {
      $table_name = 'setting';
  
      $existing_fields = $this->db->list_fields($table_name);
  
      if (!in_array('Communications', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'Communications' => array(
                  'type' => 'INT',
                  'constraint' => 11,
                  'after' => 'SmsRegistration',
                  'default' => 1,
              ),
          ));
      }
  
      if (!in_array('platform', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'platform' => array(
                  'type' => 'INT',
                  'constraint' => 11,
                  'default' => 1,
              ),
          ));
      }
  
      if (!in_array('messages', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'messages' => array(
                  'type' => 'INT',
                  'constraint' => 11,
                  'default' => 1,
              ),
          ));
      }
  }
  
  
  
  

  public function down()
  {
    $fields_to_remove = ['Communications', 'platform', 'messages'];
    $this->dbforge->drop_column('setting', $fields_to_remove);
  }
}
