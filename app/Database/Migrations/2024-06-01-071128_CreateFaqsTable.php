<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFaqsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'question' => [
                'type' => 'TEXT',
            ],
            'answer' => [
                'type' => 'TEXT',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('faqs');
    }

    public function down()
    {
        $this->forge->dropTable('faqs');
    }
}
