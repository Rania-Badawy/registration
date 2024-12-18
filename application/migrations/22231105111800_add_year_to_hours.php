<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_year_to_hours extends CI_Migration
{
  public function up()
  {
      $table_name = 'credit_hours';
  
      $existing_fields = $this->db->list_fields($table_name);
  
      if (!in_array('year_id', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'year_id' => array(
                  'type'       => 'INT',
                  'constraint' => 11,
                  'default'    => 0,
                  'after'      => 'hours'
              ),
          ));
      }
  
  }
  
  
  
  

  public function down()
  {
    $fields_to_remove = ['year_id'];
    $this->dbforge->drop_column('credit_hours', $fields_to_remove);
  }
}