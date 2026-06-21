<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $header = $request->getServer('HTTP_AUTHORIZATION');
        $token = null;

        // Ekstrak token dari header "Bearer xxxxx"
        if (!empty($header)) {
            if (preg_match('/Bearer\s(\S+)/', $header, $matches)) {
                $token = $matches[1];
            }
        }

        // Kalau token kosong, tolak akses
        if (is_null($token) || empty($token)) {
            return \Config\Services::response()
                ->setJSON(['status' => false, 'message' => 'Akses ditolak, Token tidak ditemukan'])
                ->setStatusCode(401);
        }

        // Cek apakah token valid di database
        $userModel = new UserModel();
        $user = $userModel->where('token', $token)->first();

        if (!$user) {
            return \Config\Services::response()
                ->setJSON(['status' => false, 'message' => 'Token tidak valid atau sudah kadaluarsa'])
                ->setStatusCode(401);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}