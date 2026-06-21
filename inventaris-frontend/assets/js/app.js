import { createApp, ref, watch } from 'vue';
import router from './router.js';

const App = {
    template: `
        <div class="flex h-screen overflow-hidden bg-gray-100 font-sans">
            
            <aside v-if="isLoggedIn" class="w-64 bg-slate-900 text-white flex flex-col transition-all duration-300 shadow-2xl z-20">
                <div class="p-6 text-center border-b border-slate-700">
                    <h2 class="text-3xl font-bold text-primary">Inv<span class="text-white">Pro</span></h2>
                    <p class="text-xs text-slate-400 mt-1 tracking-widest uppercase">Admin Panel</p>
                </div>
                
                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    <router-link to="/dashboard" class="block px-4 py-3 rounded-lg hover:bg-slate-800 transition text-sm font-medium" active-class="bg-primary hover:bg-primary">📊 Dashboard</router-link>
                    
                    <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mt-8 mb-2 px-4">Master Data</div>
                    <router-link to="/kategori" class="block px-4 py-3 rounded-lg hover:bg-slate-800 transition text-sm" active-class="bg-primary hover:bg-primary">📁 Kategori</router-link>
                    <router-link to="/supplier" class="block px-4 py-3 rounded-lg hover:bg-slate-800 transition text-sm" active-class="bg-primary hover:bg-primary">🏢 Supplier</router-link>
                    <router-link to="/barang" class="block px-4 py-3 rounded-lg hover:bg-slate-800 transition text-sm" active-class="bg-primary hover:bg-primary">📦 Data Barang</router-link>
                    
                    <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mt-8 mb-2 px-4">Transaksi</div>
                    <router-link to="/barang-masuk" class="block px-4 py-3 rounded-lg hover:bg-slate-800 transition text-sm" active-class="bg-primary hover:bg-primary">📥 Barang Masuk</router-link>
                    <router-link to="/barang-keluar" class="block px-4 py-3 rounded-lg hover:bg-slate-800 transition text-sm" active-class="bg-primary hover:bg-primary">📤 Barang Keluar</router-link>
                </nav>
                
                <div class="p-4 border-t border-slate-700">
                    <button @click="logout" class="w-full flex items-center justify-center gap-2 bg-red-500/10 text-red-500 px-4 py-3 rounded-lg hover:bg-red-500 hover:text-white transition font-semibold text-sm">
                        Keluar
                    </button>
                </div>
            </aside>

            <main class="flex-1 overflow-y-auto relative">
                <router-view></router-view>
            </main>
        </div>
    `,
    setup() {
        const isLoggedIn = ref(!!localStorage.getItem('token'));
        
        // Memantau perpindahan halaman. Kalau token ada, sidebar dimunculkan.
        watch(() => router.currentRoute.value, () => {
            isLoggedIn.value = !!localStorage.getItem('token');
        });

        const logout = () => {
            if(confirm('Yakin ingin keluar dari sistem?')) {
                localStorage.removeItem('token');
                router.push('/login');
            }
        };

        return { isLoggedIn, logout };
    }
};

const app = createApp(App);
app.use(router);
app.mount('#app');