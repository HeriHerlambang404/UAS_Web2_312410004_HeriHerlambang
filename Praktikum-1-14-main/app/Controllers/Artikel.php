<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;

class Artikel extends BaseController
{
    public function index()
    {
        $model = new ArtikelModel();

        $data = [
            'title'   => 'Daftar Artikel',
            'artikel' => $model->getArtikelDenganKategori()
        ];

        return view('artikel/index', $data);
    }

    public function view($slug)
    {
        $model = new ArtikelModel();

        $artikel = $model->where([
            'slug' => $slug
        ])->first();

        if (!$artikel) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title'   => $artikel['judul'],
            'artikel' => $artikel,
        ];

        return view('artikel/detail', $data);
    }

    public function admin_index()
    {
        $title = 'Daftar Artikel (Admin)';
        $q = $this->request->getVar('q') ?? '';
        $kategori_id = $this->request->getVar('kategori_id') ?? '';
        $sort = $this->request->getVar('sort') ?? 'id';
        $order = strtolower($this->request->getVar('order') ?? 'desc');
        $page = (int) ($this->request->getVar('page') ?? 1);

        $allowedSort = [
            'id' => 'artikel.id',
            'judul' => 'artikel.judul',
            'kategori' => 'kategori.nama_kategori',
            'status' => 'artikel.status',
        ];

        if (!array_key_exists($sort, $allowedSort)) {
            $sort = 'id';
        }

        if (!in_array($order, ['asc', 'desc'], true)) {
            $order = 'desc';
        }

        $model = new ArtikelModel();
        $builder = $model->select('artikel.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left');

        if ($q !== '') {
            $builder->like('artikel.judul', $q);
        }

        if ($kategori_id !== '') {
            $builder->where('artikel.id_kategori', $kategori_id);
        }

        $artikel = $builder
            ->orderBy($allowedSort[$sort], $order)
            ->paginate(10, 'default', $page);

        $data = [
            'title'   => $title,
            'q'       => $q,
            'kategori_id' => $kategori_id,
            'sort' => $sort,
            'order' => $order,
            'artikel' => $artikel,
            'pager'   => $model->pager,
        ];

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'artikel' => $artikel,
                'pager' => [
                    'links' => $model->pager->links('default', 'array'),
                ],
                'q' => $q,
                'kategori_id' => $kategori_id,
                'sort' => $sort,
                'order' => $order,
            ]);
        }

        $kategoriModel = new KategoriModel();
        $data['kategori'] = $kategoriModel->findAll();

        return view('artikel/admin_index', $data);
    }

    public function add()
    {
        $model = new ArtikelModel();
        $kategoriModel = new KategoriModel();

        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'judul' => 'required',
                'id_kategori' => 'required|integer',
                'gambar' => 'permit_empty|is_image[gambar]|max_size[gambar,2048]',
            ];

            if (!$this->validate($rules)) {
                return view('artikel/form_add', [
                    'title' => 'Tambah Artikel',
                    'kategori' => $kategoriModel->findAll(),
                    'validation' => $this->validator,
                ]);
            }

            $file = $this->request->getFile('gambar');
            $namaGambar = null;

            if ($file && $file->isValid() && !$file->hasMoved()) {
                $namaGambar = $file->getRandomName();
                $file->move(ROOTPATH . 'public/gambar', $namaGambar);
            }

            $data = [
                'judul'       => $this->request->getPost('judul'),
                'isi'         => $this->request->getPost('isi'),
                'id_kategori' => $this->request->getPost('id_kategori'),
                'slug'        => url_title(
                    $this->request->getPost('judul'),
                    '-',
                    true
                ),
                'status'      => $this->request->getPost('status') ?? 1,
                'gambar'      => $namaGambar,
            ];

            $model->insert($data);

            return redirect()->to('/admin/artikel');
        }

        $data = [
            'title' => 'Tambah Artikel',
            'kategori' => $kategoriModel->findAll(),
        ];

        return view('artikel/form_add', $data);
    }

    public function edit($id)
    {
        $model = new ArtikelModel();
        $kategoriModel = new KategoriModel();

        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'judul' => 'required',
                'id_kategori' => 'required|integer',
                'gambar' => 'permit_empty|is_image[gambar]|max_size[gambar,2048]',
            ];

            if (!$this->validate($rules)) {
                return view('artikel/form_edit', [
                    'title' => 'Edit Artikel',
                    'artikel' => $model->where('id', $id)->first(),
                    'kategori' => $kategoriModel->findAll(),
                    'validation' => $this->validator,
                ]);
            }

            $data = [
                'judul'       => $this->request->getPost('judul'),
                'isi'         => $this->request->getPost('isi'),
                'id_kategori' => $this->request->getPost('id_kategori'),
                'slug'        => url_title(
                    $this->request->getPost('judul'),
                    '-',
                    true
                ),
                'status'      => $this->request->getPost('status') ?? 1,
            ];

            $file = $this->request->getFile('gambar');

            if ($file && $file->isValid() && !$file->hasMoved()) {
                $namaGambar = $file->getRandomName();
                $file->move(ROOTPATH . 'public/gambar', $namaGambar);
                $data['gambar'] = $namaGambar;
            }

            $model->update($id, $data);

            return redirect()->to('/admin/artikel');
        }

        $data = [
            'title' => 'Edit Artikel',
            'artikel' => $model->where('id', $id)->first(),
            'kategori' => $kategoriModel->findAll(),
        ];

        if (!$data['artikel']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('artikel/form_edit', $data);
    }

    public function delete($id)
    {
        $model = new ArtikelModel();

        $model->delete($id);

        return redirect()->to('/admin/artikel');
    }
}
