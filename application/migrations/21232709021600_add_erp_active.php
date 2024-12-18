<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_erp_active extends CI_Migration
{
  public function up()
  {
      $table_name = 'contact';
  
      $existing_fields = $this->db->list_fields($table_name);
  
      if (!in_array('erp_active', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'erp_active' => array(
                  'type'       => 'TINYINT',
                  'constraint' => 4,
                  'after'      => 'motherMobile',
                  'default'    => 1,
              ),
          ));
      }
  
  }
  
  
  
  

  public function down()
  {
    $fields_to_remove = ['erp_active'];
    $this->dbforge->drop_column('contact', $fields_to_remove);
  }
}
