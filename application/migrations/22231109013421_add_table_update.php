<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Migration_Add_table_update extends CI_Migration {
    public function up()
    {
        $fields = array(
            'ID' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'contactID' => array(
                'type' => 'VARCHAR',
                'constraint' => 100
            ),
            'updateTime' => array(
                'type' => 'TIMESTAMP',
            ),
            'type' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'comment' => 'E for emp update S for student update'
            )
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('ID', TRUE);
        $this->dbforge->create_table('log_update');
    }

    public function down()
    {
        $this->dbforge->drop_table('log_update', TRUE);
    }
}
