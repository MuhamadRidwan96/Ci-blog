<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Admin extends Seeder
{
    public function run()
    {
        //
        $data = [
            'username'=>'admin',
            'password'=>password_hash('123456',PASSWORD_BCRYPT),
            'nama_lengkap'=>'muhamad ridwan',
            'email'=>'muhammadreadone96@gmail.com'
        ];

        $this->db->table('admin')->insert($data);
    }
}
