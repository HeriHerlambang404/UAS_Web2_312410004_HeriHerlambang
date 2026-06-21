import api from '../api.js';
import { ref, onMounted } from 'vue';

export default {
    template: `
        <div class="p-8">
            <header class="mb-10">
                <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
                <p class="text-gray-500 mt-1">Ringkasan sistem inventaris Anda saat ini.</p>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5 hover:shadow-md transition transform hover:-translate-y-1">
                    <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-3xl">📦</div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Barang</p>
                        <p class="text-3xl font-bold text-gray-800">{{ stats.barang }}</p>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5 hover:shadow-md transition transform hover:-translate-y-1">
                    <div class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 text-3xl">📁</div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Kategori</p>
                        <p class="text-3xl font-bold text-gray-800">{{ stats.kategori }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5 hover:shadow-md transition transform hover:-translate-y-1">
                    <div class="w-16 h-16 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 text-3xl">📥</div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Barang Masuk</p>
                        <p class="text-3xl font-bold text-gray-800">{{ stats.masuk }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5 hover:shadow-md transition transform hover:-translate-y-1">
                    <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center text-red-600 text-3xl">📤</div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Barang Keluar</p>
                        <p class="text-3xl font-bold text-gray-800">{{ stats.keluar }}</p>
                    </div>
                </div>

            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden">
                <div class="relative z-10">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Selamat Datang di Panel Admin 👋</h2>
                    <p class="text-gray-600 leading-relaxed max-w-3xl">
                        Pilih menu di sidebar sebelah kiri untuk mulai mengelola data master (Kategori, Supplier, Barang) 
                        hingga mencatat transaksi keluar masuk. Sistem akan secara otomatis mengalkulasi stok barang berdasarkan 
                        transaksi yang Anda inputkan.
                    </p>
                </div>
                <div class="absolute -right-10 -bottom-10 text-9xl opacity-5">⚙️</div>
            </div>
        </div>
    `,
    setup() {
        const stats = ref({ barang: 0, kategori: 0, masuk: 0, keluar: 0 });

        // Mengambil data dari seluruh API secara bersamaan untuk dihitung jumlahnya
        const loadStats = async () => {
            try {
                const [resBarang, resKategori, resMasuk, resKeluar] = await Promise.all([
                    api.get('/barang'),
                    api.get('/kategori'),
                    api.get('/barang-masuk'),
                    api.get('/barang-keluar')
                ]);
                
                stats.value = {
                    barang: resBarang.data.length,
                    kategori: resKategori.data.length,
                    masuk: resMasuk.data.length,
                    keluar: resKeluar.data.length
                };
            } catch (error) {
                console.error("Gagal memuat statistik", error);
            }
        };

        onMounted(loadStats);

        return { stats };
    }
}