import api from '../api.js';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

export default {
    template: `
        <div class="flex items-center justify-center h-screen bg-gray-100">
            <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-sm">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-primary">Daftar Akun</h2>
                    <p class="text-sm text-gray-500 mt-2">Buat akun admin baru Anda</p>
                </div>
                
                <form @submit.prevent="prosesRegister">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                        <input v-model="username" type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Pilih username..." required>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                        <input v-model="password" type="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Minimal 6 karakter..." required minlength="6">
                    </div>
                    
                    <div v-if="pesan" :class="isSuccess ? 'bg-green-100 border-green-500 text-green-700' : 'bg-red-100 border-red-500 text-red-700'" class="mb-6 border-l-4 p-3 text-sm rounded">
                        <p>{{ pesan }}</p>
                    </div>
                    
                    <button type="submit" class="w-full bg-secondary text-white font-bold py-3 px-4 rounded-lg hover:bg-emerald-600 transition duration-300">
                        Buat Akun
                    </button>
                </form>
                
                <div class="text-center mt-6">
                    <p class="text-sm text-gray-500">Sudah punya akun? 
                        <router-link to="/login" class="text-primary font-bold hover:underline">Login di sini</router-link>
                    </p>
                </div>
            </div>
        </div>
    `,
    setup() {
        const username = ref('');
        const password = ref('');
        const pesan = ref('');
        const isSuccess = ref(false);
        const router = useRouter();

        const prosesRegister = async () => {
            pesan.value = ''; 
            isSuccess.value = false;
            
            try {
                const response = await api.post('/register', {
                    username: username.value,
                    password: password.value
                });
                
                if (response.data.status) {
                    isSuccess.value = true;
                    pesan.value = response.data.message;
                    
                    // Setelah sukses, beri waktu 2 detik lalu otomatis pindah ke halaman Login
                    setTimeout(() => {
                        router.push('/login');
                    }, 2000);
                }
            } catch (error) {
                isSuccess.value = false;
                // Menangkap pesan error dari validasi CI4 (misal: username sudah ada)
                if (error.response?.data?.messages) {
                    pesan.value = Object.values(error.response.data.messages).join(', ');
                } else {
                    pesan.value = error.response?.data?.message || 'Gagal mendaftar.';
                }
            }
        };

        return { username, password, pesan, isSuccess, prosesRegister };
    }
}