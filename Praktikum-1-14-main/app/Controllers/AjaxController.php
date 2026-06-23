<?php

namespace App\Controllers;

use App\Models\ArtikelModel;

class AjaxController extends BaseController
{
    public function index()
    {
        return view('ajax/index', [
            'title' => 'Data Artikel AJAX',
        ]);
    }

    public function getData()
    {
        $model = new ArtikelModel();

        return $this->response->setJSON($model->orderBy('id', 'DESC')->findAll());
    }

    public function delete($id)
    {
        $model = new ArtikelModel();
        $model->delete($id);

        return $this->response->setJSON([
            'status' => 'OK',
        ]);
    }
}
