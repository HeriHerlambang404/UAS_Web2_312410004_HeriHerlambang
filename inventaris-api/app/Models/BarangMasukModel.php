<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangMasukModel extends Model
{
    protected $table            = 'barang_masuk';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    protected $allowedFields    = ['barang_id', 'jumlah', 'tanggal_masuk', 'keterangan'];
    protected $useTimestamps    = true;

    // Fungsi untuk nampilin histori barang masuk beserta nama barangnya
    public function getBarangMasukLengkap()
    {
        return $this->db->table($this->table)
            ->select('barang_masuk.*, barang.nama_barang, barang.kode_barang')
            ->join('barang', 'barang.id = barang_masuk.barang_id')
            ->orderBy('barang_masuk.created_at', 'DESC')
            ->get()->getResultArray();
    }
}