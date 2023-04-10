<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePostsTable extends Migration
{
     public function up(){
          $this->forge->addField([
               'id' => [
                     'type' => 'INT',
                     'constraint' => 10,
                     'unsigned' => true,
                     'auto_increment' => true,
               ],
               'title' => [
                   'type' => 'VARCHAR',
                   'constraint' => '100',
               ],
               'description' => [
                    'type' => 'TEXT',
                    'null' => true,
               ],
               'link' => [
                    'type' => 'VARCHAR',
                    'constraint' => '255',
               ],
          ]); 
          $this->forge->addKey('id', true); 
          $this->forge->createTable('posts'); 
     } 
     
     public function down(){ 
          $this->forge->dropTable('posts'); 
     } 
}