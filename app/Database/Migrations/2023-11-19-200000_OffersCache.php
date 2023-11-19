<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OffersCache extends Migration
{
    protected $DBGroup = 'default';

    public function up()
    {
        $this->forge->addField([
            'offer_id' => ['type' => 'INT', 'auto_increment' => true, 'null' => false],
            'hotel_id' => ['type' => 'INT', 'null' => false],
            'hotel_name' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'price' => ['type' => 'DECIMAL', 'constraint' => '4,2', 'null' => false],
            'source' => ['type' => 'VARCHAR', 'constraint' => 5, 'null' => false],
            'country_id' => ['type' => 'INT', 'null' => false],
            'country' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => false],
            'city_id' => ['type' => 'INT', 'null' => false],
            'city'  => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
            'zip'  => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => false],
            'address'  => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
            'latitude'  => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
            'longitude'  => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false], 
            'star' => ['type' => 'INT', 'null' => true, 'default' => 0],
            'image' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'default' => 'NULL']
        ])
            ->addKey('offer_id', true)
            ->createTable('cache', true);
    }

    public function down()
    {
        $this->forge->dropTable('cache');
    }
}