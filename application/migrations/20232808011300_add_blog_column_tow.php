<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_blog_column_tow extends CI_Migration {

        public function up()
        { 

              
        }

        public function down()
        {
                $this->dbforge->drop_column('blog', 'categorassy');
        }
}