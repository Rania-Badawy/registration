<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_sms_absence extends CI_Migration
{
  public function up()
  {
      $table_name = 'setting';
  
      $existing_fields = $this->db->list_fields($table_name);
  
      if (!in_array('SmsAbsence', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'SmsAbsence' => array(
                  'type'       => 'varchar',
                  'constraint' => 255,
                  'default'    => NULL,
                  'after'      => 'reg_year',
              ),
          ));
      }
}

  public function down()
  {
    $fields_to_remove = ['SmsAbsence'];
    $this->dbforge->drop_column('setting', $fields_to_remove);
  }
  
}