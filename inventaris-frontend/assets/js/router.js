import { createRouter, createWebHashHistory } from 'vue-router';
import Login from './pages/Login.js';
import Home from './pages/Home.js';
import Dashboard from './pages/Dashboard.js'; // <-- Tambahan 1
import Register from './pages/Register.js';
import Kategori from './pages/Kategori.js';
import Supplier from './pages/Supplier.js';
import Barang from './pages/Barang.js';
import BarangMasuk from './pages/BarangMasuk.js';  
import BarangKeluar from './pages/BarangKeluar.js'; 

const routes = [
    { path: '/', component: Home },
    { path: '/login', component: Login, meta: { guest: true } },
    { path: '/register', component: Register, meta: { guest: true } },
    { path: '/dashboard', component: Dashboard, meta: { requiresAuth: true } },
    { path: '/kategori', component: Kategori, meta: { requiresAuth: true } },
    { path: '/supplier', component: Supplier, meta: { requiresAuth: true } },
    { path: '/barang', component: Barang, meta: { requiresAuth: true } },
    { path: '/barang-masuk', component: BarangMasuk, meta: { requiresAuth: true } },
    { path: '/barang-keluar', component: BarangKeluar, meta: { requiresAuth: true } }

];

const router = createRouter({
    history: createWebHashHistory(),
    routes
});

// Satpam Navigasi (tetap sama)
router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('token');
    
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!token) next('/login');
        else next();
    } else if (to.matched.some(record => record.meta.guest)) {
        if (token) next('/dashboard');
        else next();
    } else {
        next();
    }
});

export default router;