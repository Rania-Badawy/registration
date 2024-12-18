<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_col_updat_log extends CI_Migration
{
  public function up()
  {
      $table_name = 'log_update';
  
      $existing_fields = $this->db->list_fields($table_name);
  
      if (!in_array('source', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'source' => array(
                  'type' => 'INT',
                  'constraint' => 11,
                  'after' => 'updateTime',
              ),
          ));
      }
  
      if (!in_array('goal', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'goal' => array(
                  'type' => 'INT',
                  'constraint' => 11,
                  'after' => 'updateTime',
              ),
          ));
      }

      if (!in_array('gender', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'gender' => array(
                  'type' => 'VARCHAR',
                  'constraint' => 11,
                  'after' => 'updateTime',
              ),
          ));
      }
  }

  public function down()
  {
    $fields_to_remove = ['goal', 'source', 'gender'];
    $this->dbforge->drop_column('log_update', $fields_to_remove);
  }
  
}