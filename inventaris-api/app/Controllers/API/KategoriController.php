<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;

class KategoriController extends ResourceController
{
    protected $modelName = 'App\Models\KategoriModel';
    protected $format    = 'json';

    // 1. Tampil Semua Data (GET /api/kategori)
    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    // 2. Tampil 1 Data Berdasarkan ID (GET /api/kategori/{id})
    public function show($id = null)
    {
        $data = $this->model->find($id);
        if ($data) {
            return $this->respond($data);
        }
        return $this->failNotFound('Data kategori tidak ditemukan');
    }

    // 3. Tambah Data (POST /api/kategori)
    public function create()
    {
        // Validasi inputan tidak boleh kosong
        $rules = [
            'nama_kategori' => 'required',
            'deskripsi'     => 'permit_empty' // Boleh dikosongkan
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        // Ambil data dari request
        $data = [
            'nama_kategori' => $this->request->getVar('nama_kategori'),
            'deskripsi'     => $this->request->getVar('deskripsi')
        ];

        // Simpan ke database
        $this->model->insert($data);
        
        return $this->respondCreated([
            'status'  => true,
            'message' => 'Data Kategori berhasil ditambahkan'
        ]);
    }

    // 4. Update Data (PUT /api/kategori/{id})
    public function update($id = null)
    {
        $rules = [
            'nama_kategori' => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        // Untuk method PUT, CI4 menggunakan getRawInputVar
        $data = [
            'nama_kategori' => $this->request->getRawInputVar('nama_kategori'),
            'deskripsi'     => $this->request->getRawInputVar('deskripsi')
        ];

        // Cek apakah datanya ada di database
        if ($this->model->find($id)) {
            $this->model->update($id, $data);
            return $this->respond([
                'status'  => true,
                'message' => 'Data Kategori berhasil diupdate'
            ]);
        }
        return $this->failNotFound('Data kategori tidak ditemukan');
    }

    // 5. Hapus Data (DELETE /api/kategori/{id})
    public function delete($id = null)
    {
        if ($this->model->find($id)) {
            $this->model->delete($id);
            return $this->respondDeleted([
                'status'  => true,
                'message' => 'Data Kategori berhasil dihapus'
            ]);
        }
        return $this->failNotFound('Data kategori tidak ditemukan');
    }
}