<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;

class BarangController extends ResourceController
{
    protected $modelName = 'App\Models\BarangModel';
    protected $format    = 'json';

    // 1. Tampil Semua Data (Menggunakan fungsi JOIN yang kita bikin di Model)
    public function index()
    {
        return $this->respond($this->model->getBarangLengkap());
    }

    // 2. Tampil 1 Data
    public function show($id = null)
    {
        $data = $this->model->getBarangLengkap($id);
        if ($data) {
            return $this->respond($data);
        }
        return $this->failNotFound('Data barang tidak ditemukan');
    }

    // 3. Tambah Data
    public function create()
    {
        // Validasi: kode_barang harus unik (tidak boleh dobel)
        $rules = [
            'kategori_id' => 'required|numeric',
            'supplier_id' => 'required|numeric',
            'kode_barang' => 'required|is_unique[barang.kode_barang]',
            'nama_barang' => 'required',
            'satuan'      => 'required',
            'harga'       => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = [
            'kategori_id' => $this->request->getVar('kategori_id'),
            'supplier_id' => $this->request->getVar('supplier_id'),
            'kode_barang' => $this->request->getVar('kode_barang'),
            'nama_barang' => $this->request->getVar('nama_barang'),
            'stok'        => 0, // Stok awal selalu 0, karena penambahan stok HANYA lewat Barang Masuk
            'satuan'      => $this->request->getVar('satuan'),
            'harga'       => $this->request->getVar('harga')
        ];

        $this->model->insert($data);
        
        return $this->respondCreated([
            'status'  => true,
            'message' => 'Data Barang berhasil ditambahkan'
        ]);
    }

    // 4. Update Data
    public function update($id = null)
    {
        $rules = [
            'nama_barang' => 'required',
            'harga'       => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = [
            'kategori_id' => $this->request->getRawInputVar('kategori_id'),
            'supplier_id' => $this->request->getRawInputVar('supplier_id'),
            'nama_barang' => $this->request->getRawInputVar('nama_barang'),
            'satuan'      => $this->request->getRawInputVar('satuan'),
            'harga'       => $this->request->getRawInputVar('harga')
        ];

        if ($this->model->find($id)) {
            $this->model->update($id, $data);
            return $this->respond([
                'status'  => true,
                'message' => 'Data Barang berhasil diupdate'
            ]);
        }
        return $this->failNotFound('Data barang tidak ditemukan');
    }

    // 5. Hapus Data
    public function delete($id = null)
    {
        if ($this->model->find($id)) {
            $this->model->delete($id);
            return $this->respondDeleted([
                'status'  => true,
                'message' => 'Data Barang berhasil dihapus'
            ]);
        }
        return $this->failNotFound('Data barang tidak ditemukan');
    }
}