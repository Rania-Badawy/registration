<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_school_id_files extends CI_Migration
{
  public function up()
  {
      $table_name = 'files';
  
      $existing_fields = $this->db->list_fields($table_name);
  
      if (!in_array('schoolID', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'schoolID' => array(
                  'type'       => 'int',
                  'constraint' => 11,
                  'default'    => NULL,
                  'after'      => 'semesterId',
              ),
          ));
      }
}

  public function down()
  {
    $fields_to_remove = ['schoolID'];
    $this->dbforge->drop_column('files', $fields_to_remove);
  }
  
}