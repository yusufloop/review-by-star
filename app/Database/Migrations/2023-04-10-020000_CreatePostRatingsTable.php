<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePostRatingsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=> [ //field id
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' =>[ //field user_id field
                'type' =>'INT',
                'contraint' => '10',
                'unsigned' => true,
            ], 
            'post_id' =>[ //field description
                'type' => 'INT',
                'constraint' => '10',
                'unsigned' => true
            ],
            'rating' => [ //field link
               'type' => 'VARCHAR',
               'constraint' => '10'
            ]
            ]);

            $this->forge->addKEy('id',true);
            $this->forge->addForeignKey('post_id', 'posts', 'id', 'CASCADE','CASCADE' );
            $this->forge->createTable('post_ratings');
    }

    public function down()
    {
        $this->forge->dropTable('post_ratings');
    }
}
