<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PraktikumSeeder extends Seeder
{
    public function run()
    {
        if ($this->db->table('kategori')->countAllResults() === 0) {
            $this->db->table('kategori')->insertBatch([
                [
                    'nama_kategori' => 'Teknologi',
                    'slug_kategori' => 'teknologi',
                ],
                [
                    'nama_kategori' => 'Pendidikan',
                    'slug_kategori' => 'pendidikan',
                ],
            ]);
        }

        if ($this->db->table('user')->countAllResults() === 0) {
            $this->db->table('user')->insert([
                'username' => 'admin',
                'useremail' => 'admin@example.com',
                'userpassword' => password_hash('admin123', PASSWORD_DEFAULT),
            ]);
        }
    }
}
