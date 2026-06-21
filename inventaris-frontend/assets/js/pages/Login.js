import api from '../api.js';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

export default {
    template: `
        <div class="flex items-center justify-center h-screen bg-gray-100">
            <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-sm">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-primary">Login Admin</h2>
                    <p class="text-sm text-gray-500 mt-2">Silakan masukkan kredensial Anda</p>
                </div>
                
                <form @submit.prevent="prosesLogin">
                    <div class="mb-5">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                        <input v-model="username" type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Masukkan username..." required>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                        <input v-model="password" type="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Masukkan password..." required>
                    </div>
                    
                    <div v-if="pesanError" class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-3 text-sm rounded">
                        <p>{{ pesanError }}</p>
                    </div>
                    
                    <button type="submit" class="w-full bg-primary text-white font-bold py-3 px-4 rounded-lg hover:bg-indigo-600 transition duration-300">
                        Login
                    </button>
                </form>
                
                <div class="text-center mt-6 space-y-2">
                    <p class="text-sm text-gray-500">Belum punya akun? 
                        <router-link to="/register" class="text-primary font-bold hover:underline">Daftar sekarang</router-link>
                    </p>
                    <p>
                        <router-link to="/" class="text-xs text-gray-400 hover:text-gray-600">&larr; Kembali ke Beranda</router-link>
                    </p>
                </div>
            </div>
        </div>
    `,
    setup() {
        const username = ref('');
        const password = ref('');
        const pesanError = ref('');
        const router = useRouter();

        const prosesLogin = async () => {
            pesanError.value = ''; // Reset error saat tombol diklik
            
            try {
                // Tembak API backend
                const response = await api.post('/login', {
                    username: username.value,
                    password: password.value
                });
                
                // Kalau sukses, simpan token ke localStorage dan pindah ke dashboard
                if (response.data.status) {
                    localStorage.setItem('token', response.data.token);
                    router.push('/dashboard');
                }
            } catch (error) {
                // Tangkap pesan error dari backend CI4
                pesanError.value = error.response?.data?.message || 'Koneksi ke server gagal. Pastikan server CI4 menyala.';
            }
        };

        return { username, password, pesanError, prosesLogin };
    }
}