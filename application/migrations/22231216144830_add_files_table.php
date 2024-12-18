<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Migration_Add_files_table extends CI_Migration {
    public function up()
    {
        $fields = array(
            'ID' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'file' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'collation'  => 'utf8_general_ci' ,
            ),
            'type' => array(
                'type' => 'TINYINT',
                'constraint' => 4,
                'comment' => '1 -> calendar , 2 -> exam scope ,3 -> exam schedule'

            ),
            'rowLevelId' => array(
                'type' => 'int',
                'constraint' => 11,
                'default'    => NULL,
            ),
            'subjectId' => array(
                'type' => 'int',
                'constraint' => 11,
                'default'    => NULL,
            ),
            'semesterId' => array(
                'type' => 'int',
                'constraint' => 11,
            ),
            'yearId' => array(
                'type' => 'int',
                'constraint' => 11,
            ),
            'createdBy' => array(
                'type' => 'INT',
                'constraint' => 11,
            ),
            'createdAt' => array(
                'type' => 'datetime',
            ),
        );
        if(!$this->db->table_exists('files')){
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('ID', TRUE);
        $this->dbforge->create_table('files');
        }
        
    }

    public function down()
    {
        $this->dbforge->drop_table('files', TRUE);
    }
}
