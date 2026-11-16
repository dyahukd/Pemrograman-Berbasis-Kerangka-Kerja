<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFotoToMahasiswaTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('mahasiswa', [
            'foto' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'angkatan',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('mahasiswa', 'foto');
    }
}