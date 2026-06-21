<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;

class SupplierController extends ResourceController
{
    protected $modelName = 'App\Models\SupplierModel';
    protected $format    = 'json';

    // 1. Tampil Semua Data
    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    // 2. Tampil 1 Data
    public function show($id = null)
    {
        $data = $this->model->find($id);
        if ($data) {
            return $this->respond($data);
        }
        return $this->failNotFound('Data supplier tidak ditemukan');
    }

    // 3. Tambah Data
    public function create()
    {
        $rules = [
            'nama_supplier' => 'required',
            'telepon'       => 'required',
            'email'         => 'permit_empty|valid_email'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = [
            'nama_supplier' => $this->request->getVar('nama_supplier'),
            'alamat'        => $this->request->getVar('alamat'),
            'telepon'       => $this->request->getVar('telepon'),
            'email'         => $this->request->getVar('email')
        ];

        $this->model->insert($data);
        
        return $this->respondCreated([
            'status'  => true,
            'message' => 'Data Supplier berhasil ditambahkan'
        ]);
    }

    // 4. Update Data
    public function update($id = null)
    {
        $rules = [
            'nama_supplier' => 'required',
            'telepon'       => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = [
            'nama_supplier' => $this->request->getRawInputVar('nama_supplier'),
            'alamat'        => $this->request->getRawInputVar('alamat'),
            'telepon'       => $this->request->getRawInputVar('telepon'),
            'email'         => $this->request->getRawInputVar('email')
        ];

        if ($this->model->find($id)) {
            $this->model->update($id, $data);
            return $this->respond([
                'status'  => true,
                'message' => 'Data Supplier berhasil diupdate'
            ]);
        }
        return $this->failNotFound('Data supplier tidak ditemukan');
    }

    // 5. Hapus Data
    public function delete($id = null)
    {
        if ($this->model->find($id)) {
            $this->model->delete($id);
            return $this->respondDeleted([
                'status'  => true,
                'message' => 'Data Supplier berhasil dihapus'
            ]);
        }
        return $this->failNotFound('Data supplier tidak ditemukan');
    }
}