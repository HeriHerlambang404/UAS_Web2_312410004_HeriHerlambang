<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangKeluarModel extends Model
{
    protected $table            = 'barang_keluar';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    protected $allowedFields    = ['barang_id', 'jumlah', 'tanggal_keluar', 'keterangan'];
    protected $useTimestamps    = true;

    // Fungsi untuk nampilin histori barang keluar beserta nama barangnya
    public function getBarangKeluarLengkap()
    {
        return $this->db->table($this->table)
            ->select('barang_keluar.*, barang.nama_barang, barang.kode_barang')
            ->join('barang', 'barang.id = barang_keluar.barang_id')
            ->orderBy('barang_keluar.created_at', 'DESC')
            ->get()->getResultArray();
    }
}