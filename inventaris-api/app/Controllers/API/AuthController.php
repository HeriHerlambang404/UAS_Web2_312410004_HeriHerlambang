<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;

class AuthController extends ResourceController
{
    protected $format = 'json';

    // --- METHOD LOGIN (Tetap seperti sebelumnya) ---
    public function login()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $userModel = new UserModel();
        $user = $userModel->where('username', $this->request->getVar('username'))->first();

        if ($user && password_verify($this->request->getVar('password'), $user['password'])) {
            $token = bin2hex(random_bytes(32));
            $userModel->update($user['id'], ['token' => $token]);

            return $this->respond([
                'status'  => true,
                'message' => 'Login Berhasil',
                'token'   => $token
            ]);
        }
        
        return $this->failUnauthorized('Username atau Password salah');
    }

    // --- METHOD BARU: REGISTER ---
    public function register()
    {
        // Validasi: Username harus unik (belum dipakai)
        $rules = [
            'username' => 'required|is_unique[users.username]',
            'password' => 'required|min_length[6]' // Minimal 6 karakter
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $userModel = new UserModel();
        
        // Enkripsi password menggunakan BCRYPT bawaan PHP
        $data = [
            'username' => $this->request->getVar('username'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
        ];

        $userModel->insert($data);

        return $this->respondCreated([
            'status'  => true,
            'message' => 'Akun berhasil didaftarkan. Silakan login.'
        ]);
    }

    // --- METHOD LOGOUT (Tetap seperti sebelumnya) ---
    public function logout()
    {
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        $token = null;

        if (!empty($header)) {
            if (preg_match('/Bearer\s(\S+)/', $header, $matches)) {
                $token = $matches[1];
            }
        }

        if ($token) {
            $userModel = new UserModel();
            $userModel->where('token', $token)->set(['token' => null])->update();
        }
        
        return $this->respond(['status' => true, 'message' => 'Logout Berhasil']);
    }
}