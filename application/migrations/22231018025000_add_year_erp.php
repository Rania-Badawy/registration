<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_year_erp extends CI_Migration
{
  public function up()
  {
      $table_name = 'year';
  
      $existing_fields = $this->db->list_fields($table_name);
  
      if (!in_array('ID_ERP', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'ID_ERP' => array(
                  'type'       => 'VARCHAR',
                  'constraint' => 255,
                  'after'      => 'IsActive',
                  'default'    => NULL,
                
              ),
          ));
      }
  
  }
  
  
  
  

  public function down()
  {
    $fields_to_remove = ['ID_ERP'];
    $this->dbforge->drop_column('year', $fields_to_remove);
  }
}