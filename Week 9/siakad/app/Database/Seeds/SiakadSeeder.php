<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SiakadSeeder extends Seeder
{
    public function run()
    {
        $db = $this->db;
        if ($db->table('users')->countAllResults() > 0) {
            echo "Seeder dilewati: tabel users sudah berisi data.\n";
            return;
        }

        $db->transStart();
        $db->table('users')->insert([
            'username'=>'admin','password'=>password_hash('admin123',PASSWORD_DEFAULT),
            'nama'=>'Administrator','role'=>'admin'
        ]);

        $db->table('users')->insert([
            'username'=>'0011223301','password'=>password_hash('0011223301',PASSWORD_DEFAULT),
            'nama'=>'Dr. Dosen Contoh, S.Kom.','role'=>'dosen'
        ]);
        $dosenUser=$db->insertID();
        $db->table('dosen')->insert(['user_id'=>$dosenUser,'nidn'=>'0011223301','email'=>'dosen@example.test']);
        $dosenId=$db->insertID();

        $db->table('users')->insert([
            'username'=>'5025241186','password'=>password_hash('5025241186',PASSWORD_DEFAULT),
            'nama'=>'Dyah Utami Kesuma Dewi','role'=>'mahasiswa'
        ]);
        $mhsUser=$db->insertID();
        $db->table('mahasiswa')->insert([
            'user_id'=>$mhsUser,'nim'=>'5025241186','angkatan'=>2025,'dosen_wali_id'=>$dosenId
        ]);

        $courses=[
            ['IF101','Algoritma dan Pemrograman',3,1,40],
            ['IF102','Matematika Diskrit',3,1,40],
            ['IF103','Pengantar Teknologi Informasi',2,1,40],
            ['IF104','Basis Data',3,2,40],
            ['IF105','Pemrograman Web',3,2,40],
            ['IF201','Struktur Data',4,3,35],
            ['IF202','Jaringan Komputer',3,3,35],
            ['IF203','Rekayasa Perangkat Lunak',3,4,35],
        ];
        foreach($courses as $c) $db->table('matakuliah')->insert([
            'kode'=>$c[0],'nama'=>$c[1],'sks'=>$c[2],'semester'=>$c[3],
            'dosen_id'=>$dosenId,'kuota'=>$c[4]
        ]);

        $courseRows=$db->table('matakuliah')->get()->getResultArray();
        foreach(array_slice($courseRows,0,3) as $i=>$c) $db->table('krs')->insert([
            'mahasiswa_id'=>1,'matakuliah_id'=>$c['id'],'tahun_ajaran'=>'2026/2027',
            'semester'=>'Ganjil','nilai'=>['A','AB','B'][$i]
        ]);
        $db->transComplete();
    }
}
