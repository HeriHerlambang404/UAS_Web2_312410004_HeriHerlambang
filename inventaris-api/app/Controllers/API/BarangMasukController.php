<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use App\Models\BarangModel;

class BarangMasukController extends ResourceController
{
    protected $modelName = 'App\Models\BarangMasukModel';
    protected $format    = 'json';

    public function index()
    {
        return $this->respond($this->model->getBarangMasukLengkap());
    }

    public function create()
    {
        $rules = [
            'barang_id'     => 'required|numeric',
            'jumlah'        => 'required|numeric|greater_than[0]',
            'tanggal_masuk' => 'required|valid_date'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $barangModel = new BarangModel();
        
        $barang_id = $this->request->getVar('barang_id');
        $jumlah = $this->request->getVar('jumlah');
        $barang = $barangModel->find($barang_id);

        if (!$barang) return $this->failNotFound('Barang tidak ditemukan');

        // Mulai Database Transaction
        $db->transStart();

        // 1. Simpan histori barang masuk
        $this->model->insert([
            'barang_id'     => $barang_id,
            'jumlah'        => $jumlah,
            'tanggal_masuk' => $this->request->getVar('tanggal_masuk'),
            'keterangan'    => $this->request->getVar('keterangan')
        ]);

        // 2. Tambah stok di tabel barang
        $stok_baru = $barang['stok'] + $jumlah;
        $barangModel->update($barang_id, ['stok' => $stok_baru]);

        // Selesaikan Transaction
        $db->transComplete();

        if ($db->transStatus() === false) {
            $dbError = $db->error(); // Tangkap error SQL aslinya
            return $this->failServerError('Error DB: ' . $dbError['message']);
        }

        return $this->respondCreated(['status' => true, 'message' => 'Barang masuk berhasil, stok bertambah']);
    }
}