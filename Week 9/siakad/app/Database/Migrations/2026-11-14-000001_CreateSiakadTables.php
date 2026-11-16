<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSiakadTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'username'=>['type'=>'VARCHAR','constraint'=>50],
            'password'=>['type'=>'VARCHAR','constraint'=>255],
            'nama'=>['type'=>'VARCHAR','constraint'=>120],
            'role'=>['type'=>'ENUM','constraint'=>['admin','dosen','mahasiswa']],
            'created_at'=>['type'=>'DATETIME','null'=>true],
            'updated_at'=>['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id',true);
        $this->forge->addUniqueKey('username');
        $this->forge->createTable('users',true);

        $this->forge->addField([
            'id'=>['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'user_id'=>['type'=>'INT','unsigned'=>true],
            'nidn'=>['type'=>'VARCHAR','constraint'=>20],
            'email'=>['type'=>'VARCHAR','constraint'=>120,'null'=>true],
        ]);
        $this->forge->addKey('id',true);
        $this->forge->addUniqueKey('user_id');
        $this->forge->addUniqueKey('nidn');
        $this->forge->addForeignKey('user_id','users','id','CASCADE','CASCADE');
        $this->forge->createTable('dosen',true);

        $this->forge->addField([
            'id'=>['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'user_id'=>['type'=>'INT','unsigned'=>true],
            'nim'=>['type'=>'VARCHAR','constraint'=>20],
            'angkatan'=>['type'=>'YEAR','null'=>true],
            'dosen_wali_id'=>['type'=>'INT','unsigned'=>true,'null'=>true],
            'foto'=>['type'=>'VARCHAR','constraint'=>255,'null'=>true],
        ]);
        $this->forge->addKey('id',true);
        $this->forge->addUniqueKey('user_id');
        $this->forge->addUniqueKey('nim');
        $this->forge->addForeignKey('user_id','users','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('dosen_wali_id','dosen','id','CASCADE','SET NULL');
        $this->forge->createTable('mahasiswa',true);

        $this->forge->addField([
            'id'=>['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'kode'=>['type'=>'VARCHAR','constraint'=>20],
            'nama'=>['type'=>'VARCHAR','constraint'=>120],
            'sks'=>['type'=>'TINYINT','unsigned'=>true],
            'semester'=>['type'=>'TINYINT','unsigned'=>true],
            'dosen_id'=>['type'=>'INT','unsigned'=>true,'null'=>true],
            'kuota'=>['type'=>'SMALLINT','unsigned'=>true,'default'=>40],
        ]);
        $this->forge->addKey('id',true);
        $this->forge->addUniqueKey('kode');
        $this->forge->addForeignKey('dosen_id','dosen','id','CASCADE','SET NULL');
        $this->forge->createTable('matakuliah',true);

        $this->forge->addField([
            'id'=>['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'mahasiswa_id'=>['type'=>'INT','unsigned'=>true],
            'matakuliah_id'=>['type'=>'INT','unsigned'=>true],
            'tahun_ajaran'=>['type'=>'VARCHAR','constraint'=>30],
            'semester'=>['type'=>'VARCHAR','constraint'=>10],
            'nilai'=>['type'=>'VARCHAR','constraint'=>2,'null'=>true],
            'created_at'=>['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id',true);
        $this->forge->addUniqueKey(['mahasiswa_id','matakuliah_id','tahun_ajaran','semester'],'uq_krs_period');
        $this->forge->addForeignKey('mahasiswa_id','mahasiswa','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('matakuliah_id','matakuliah','id','CASCADE','RESTRICT');
        $this->forge->createTable('krs',true);
    }

    public function down()
    {
        $this->forge->dropTable('krs',true);
        $this->forge->dropTable('matakuliah',true);
        $this->forge->dropTable('mahasiswa',true);
        $this->forge->dropTable('dosen',true);
        $this->forge->dropTable('users',true);
    }
}
