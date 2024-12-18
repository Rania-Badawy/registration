<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_type_and_change extends CI_Migration
{
  public function up()
  {
      $table_name = 'INMobileCode';
  
      $existing_fields = $this->db->list_fields($table_name);
  
      if (!in_array('type', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'type' => array(
                  'type'       => 'int',
                  'constraint' => 11,
                  'default'    => NULL,
                  'after'      => 'Date',
              ),
          ));
      }
}

  public function down()
  {
    $fields_to_remove = ['type'];
    $this->dbforge->drop_column('INMobileCode', $fields_to_remove);
  }
  
}