<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_mulClass_to_tempClasstable extends CI_Migration
{
  public function up()
  {
      $table_name = 'temp_class_table';
  
      $existing_fields = $this->db->list_fields($table_name);
  
      if (!in_array('multipleClass', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'multipleClass' => array(
                  'type'       => 'VARCHAR',
                  'constraint' => 255,
                  'default'    => NULL,
                  'collation'  => 'utf8_general_ci',
                  'after'      => 'ClassID',
              ),
          ));
      }
}

  public function down()
  {
    $fields_to_remove = ['multipleClass'];
    $this->dbforge->drop_column('temp_class_table', $fields_to_remove);
  }
  
}