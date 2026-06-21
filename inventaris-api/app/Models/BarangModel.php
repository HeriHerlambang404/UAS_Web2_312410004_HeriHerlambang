<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table            = 'barang';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // Kolom yang boleh diisi
    protected $allowedFields    = ['kategori_id', 'supplier_id', 'kode_barang', 'nama_barang', 'stok', 'satuan', 'harga'];

    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    // Fungsi khusus untuk JOIN tabel barang dengan kategori & supplier
    public function getBarangLengkap($id = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('barang.*, kategori.nama_kategori, supplier.nama_supplier');
        $builder->join('kategori', 'kategori.id = barang.kategori_id');
        $builder->join('supplier', 'supplier.id = barang.supplier_id');
        
        if ($id) {
            $builder->where('barang.id', $id);
            return $builder->get()->getRowArray();
        }
        
        $builder->orderBy('barang.created_at', 'DESC');
        return $builder->get()->getResultArray();
    }
}