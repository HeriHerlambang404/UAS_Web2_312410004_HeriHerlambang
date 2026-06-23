<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateArtikelForKategoriAndUpload extends Migration
{
    public function up()
    {
        if (!$this->db->tableExists('artikel')) {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'judul' => [
                    'type' => 'VARCHAR',
                    'constraint' => 200,
                ],
                'isi' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'slug' => [
                    'type' => 'VARCHAR',
                    'constraint' => 200,
                    'null' => true,
                ],
                'status' => [
                    'type' => 'TINYINT',
                    'constraint' => 1,
                    'default' => 0,
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->createTable('artikel');
        }

        if (!$this->db->fieldExists('id_kategori', 'artikel')) {
            $this->forge->addColumn('artikel', [
                'id_kategori' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'null' => true,
                ],
            ]);
        }

        if (!$this->db->fieldExists('gambar', 'artikel')) {
            $this->forge->addColumn('artikel', [
                'gambar' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                ],
            ]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('gambar', 'artikel')) {
            $this->forge->dropColumn('artikel', 'gambar');
        }

        if ($this->db->fieldExists('id_kategori', 'artikel')) {
            $this->forge->dropColumn('artikel', 'id_kategori');
        }
    }
}
