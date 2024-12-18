<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_installment_link extends CI_Migration
{
  public function up()
  {
      $table_name = 'setting';
  
      $existing_fields = $this->db->list_fields($table_name);
  
      if (!in_array('installment_link', $existing_fields)) {
          $this->dbforge->add_column($table_name, array(
              'installment_link' => array(
                  'type'       => 'VARCHAR',
                  'constraint' => 255,
                  'default'    => NULL,
                  'collation'  => 'utf8_general_ci' ,
                  'after'      => 'installment',
              ),
          ));
      }
}

  public function down()
  {
    $fields_to_remove = ['installment_link'];
    $this->dbforge->drop_column('setting', $fields_to_remove);
  }
  
}