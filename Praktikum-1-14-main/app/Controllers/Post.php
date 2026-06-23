<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Post extends ResourceController
{
    use ResponseTrait;

    protected $format = 'json';

    public function index()
    {
        $model = new ArtikelModel();

        return $this->respond([
            'artikel' => $model->orderBy('id', 'DESC')->findAll(),
        ]);
    }

    public function create()
    {
        $model = new ArtikelModel();
        $judul = $this->request->getVar('judul');

        $model->insert([
            'judul' => $judul,
            'isi' => $this->request->getVar('isi'),
            'status' => $this->request->getVar('status') ?? 0,
            'slug' => url_title($judul, '-', true),
            'id_kategori' => $this->request->getVar('id_kategori'),
        ]);

        return $this->respondCreated([
            'status' => 201,
            'error' => null,
            'messages' => [
                'success' => 'Data artikel berhasil ditambahkan.',
            ],
        ]);
    }

    public function show($id = null)
    {
        $model = new ArtikelModel();
        $data = $model->where('id', $id)->first();

        if ($data) {
            return $this->respond($data);
        }

        return $this->failNotFound('Data tidak ditemukan.');
    }

    public function update($id = null)
    {
        $model = new ArtikelModel();
        $judul = $this->request->getVar('judul');

        if (!$model->find($id)) {
            return $this->failNotFound('Data tidak ditemukan.');
        }

        $model->update($id, [
            'judul' => $judul,
            'isi' => $this->request->getVar('isi'),
            'status' => $this->request->getVar('status') ?? 0,
            'slug' => url_title($judul, '-', true),
            'id_kategori' => $this->request->getVar('id_kategori'),
        ]);

        return $this->respond([
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Data artikel berhasil diubah.',
            ],
        ]);
    }

    public function delete($id = null)
    {
        $model = new ArtikelModel();

        if (!$model->find($id)) {
            return $this->failNotFound('Data tidak ditemukan.');
        }

        $model->delete($id);

        return $this->respondDeleted([
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Data artikel berhasil dihapus.',
            ],
        ]);
    }
}
