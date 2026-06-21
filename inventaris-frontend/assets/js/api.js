import axios from 'axios';

const api = axios.create({
    baseURL: 'http://localhost:8080/api', // Alamat backend CI4 lo
    headers: { 'Content-Type': 'application/json' }
});

// Menyisipkan token ke Header secara otomatis
api.interceptors.request.use(config => {
    const token = localStorage.getItem('token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

// Menangkap error jika token kadaluarsa atau tidak valid (401)
api.interceptors.response.use(response => response, error => {
    if (error.response && error.response.status === 401) {
        localStorage.removeItem('token');
        window.location.hash = '#/login'; // Tendang balik ke halaman login
    }
    return Promise.reject(error);
});

export default api;