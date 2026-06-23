<?php

namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
    public function login()
    {
        helper(['form']);

        $session = session();

        if ($this->request->getMethod() == 'POST') {

            $model = new UserModel();

            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $user = $model->where('username', $username)->first();

            // cek username
            if (!$user) {

                $session->setFlashdata(
                    'msg',
                    'Username tidak ditemukan'
                );

                return redirect()->to('/user/login');
            }

            // cek password
            if (!password_verify(
                    $password,
                    $user['userpassword']
                )) {

                $session->setFlashdata(
                    'msg',
                    'Password salah'
                );

                return redirect()->to('/user/login');
            }

            // login berhasil
            $ses_data = [
                'user_id'   => $user['id'],
                'username'  => $user['username'],
                'logged_in' => true
            ];

            $session->set($ses_data);

            return redirect()->to('/admin/artikel');
        }

        return view('user/login');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/user/login');
    }
}