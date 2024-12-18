<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Migration_Rate_emp_table extends CI_Migration {
    public function up()
    {
        $fields = array(
            'ID' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'empID' => array(
                'type' => 'VARCHAR',
                'constraint' => 100
            ),
            'fatherID' => array(
                'type' => 'VARCHAR',
                'constraint' => 100
            ),
            'rateCount' => array(
                'type' => 'int',
                'constraint' => 11,
            ),
            'note' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ),
            'student_id' => array(
                'type' => 'int',
                'constraint' => 11,
            ),
            'studentRLID' => array(
                'type' => 'int',
                'constraint' => 11,
            ),
            'rateTime' => array(
                'type' => 'datetime',
            )
        );
        if(!$this->db->table_exists('father_emp_rate')){
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('ID', TRUE);
        $this->dbforge->create_table('father_emp_rate');
        }
        
    }

    public function down()
    {
        $this->dbforge->drop_table('father_emp_rate', TRUE);
    }
}
