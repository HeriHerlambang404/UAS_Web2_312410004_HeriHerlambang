<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use App\Models\BarangModel;

class BarangKeluarController extends ResourceController
{
    protected $modelName = 'App\Models\BarangKeluarModel';
    protected $format    = 'json';

    public function index()
    {
        return $this->respond($this->model->getBarangKeluarLengkap());
    }

    public function create()
    {
        $rules = [
            'barang_id'      => 'required|numeric',
            'jumlah'         => 'required|numeric|greater_than[0]',
            'tanggal_keluar' => 'required|valid_date'
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

        // Validasi: Cek apakah stok cukup
        if ($barang['stok'] < $jumlah) {
            return $this->fail('Stok tidak mencukupi. Stok saat ini: ' . $barang['stok']);
        }

        // Mulai Database Transaction
        $db->transStart();

        // 1. Simpan histori barang keluar
        $this->model->insert([
            'barang_id'      => $barang_id,
            'jumlah'         => $jumlah,
            'tanggal_keluar' => $this->request->getVar('tanggal_keluar'),
            'keterangan'     => $this->request->getVar('keterangan')
        ]);

        // 2. Kurangi stok di tabel barang
        $stok_baru = $barang['stok'] - $jumlah;
        $barangModel->update($barang_id, ['stok' => $stok_baru]);

        // Selesaikan Transaction
        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->failServerError('Gagal memproses transaksi barang keluar');
        }

        return $this->respondCreated(['status' => true, 'message' => 'Barang keluar berhasil, stok berkurang']);
    }
}