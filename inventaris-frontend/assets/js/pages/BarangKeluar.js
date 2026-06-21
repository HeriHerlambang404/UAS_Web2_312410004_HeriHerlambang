import api from '../api.js';
import { ref, onMounted } from 'vue';

export default {
    template: `
        <div class="p-8">
            <header class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">📤 Transaksi Barang Keluar</h1>
                    <p class="text-gray-500 mt-1">Catat pengeluaran barang atau distribusi barang ke luar gudang.</p>
                </div>
                <button @click="bukaForm" class="bg-red-500 text-white px-5 py-2.5 rounded-lg shadow-md hover:bg-red-600 transition font-medium">
                    + Catat Barang Keluar
                </button>
            </header>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider border-b border-gray-100">
                            <th class="p-4">Tanggal</th>
                            <th class="p-4">Kode</th>
                            <th class="p-4">Nama Barang</th>
                            <th class="p-4 text-center">Jumlah Keluar</th>
                            <th class="p-4">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in riwayat" :key="item.id" class="border-b border-gray-50 hover:bg-gray-50/50">
                            <td class="p-4 text-gray-600">{{ item.tanggal_keluar }}</td>
                            <td class="p-4 font-semibold text-primary">{{ item.kode_barang }}</td>
                            <td class="p-4 font-medium">{{ item.nama_barang }}</td>
                            <td class="p-4 text-center font-bold text-red-500">-{{ item.jumlah }}</td>
                            <td class="p-4 text-gray-500 text-sm">{{ item.keterangan || '-' }}</td>
                        </tr>
                        <tr v-if="riwayat.length === 0">
                            <td colspan="5" class="p-8 text-center text-gray-400">Belum ada riwayat barang keluar.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-if="showModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-xl font-bold text-gray-800">Form Barang Keluar</h3>
                        <button @click="tutupForm" class="text-gray-400 hover:text-red-500 text-2xl">&times;</button>
                    </div>
                    <form @submit.prevent="simpanTransaksi" class="p-6">
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Barang *</label>
                            <select v-model="form.barang_id" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:outline-none" required>
                                <option value="" disabled>-- Pilih Barang --</option>
                                <option v-for="b in barangs" :value="b.id">[{{ b.kode_barang }}] {{ b.nama_barang }} (Stok: {{ b.stok }})</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Keluar *</label>
                                <input v-model="form.jumlah" type="number" min="1" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:outline-none" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal *</label>
                                <input v-model="form.tanggal_keluar" type="date" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:outline-none" required>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Keterangan / Keperluan</label>
                            <textarea v-model="form.keterangan" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:outline-none" rows="2" placeholder="Contoh: Barang rusak / Pengiriman ke toko cabang..."></textarea>
                        </div>
                        
                        <div class="flex justify-end gap-3">
                            <button type="button" @click="tutupForm" class="px-5 py-2 rounded-lg bg-gray-100 font-medium">Batal</button>
                            <button type="submit" class="px-5 py-2 rounded-lg text-white bg-red-500 hover:bg-red-600 font-medium">Kurangi Stok</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    `,
    setup() {
        const riwayat = ref([]);
        const barangs = ref([]);
        const showModal = ref(false);
        const form = ref({ barang_id: '', jumlah: 1, tanggal_keluar: '', keterangan: '' });

        const loadData = async () => {
            try {
                const resKeluar = await api.get('/barang-keluar'); riwayat.value = resKeluar.data;
                const resBarang = await api.get('/barang'); barangs.value = resBarang.data;
            } catch (error) { console.error(error); }
        };

        const bukaForm = () => {
            const hariIni = new Date().toISOString().split('T')[0];
            form.value = { barang_id: '', jumlah: 1, tanggal_keluar: hariIni, keterangan: '' };
            showModal.value = true;
        };
        const tutupForm = () => { showModal.value = false; };

        const simpanTransaksi = async () => {
            try {
                await api.post('/barang-keluar', form.value);
                tutupForm();
                loadData();
            } catch (error) {
                // Menangkap pesan error "Stok tidak mencukupi" yang dikirim oleh Controller Backend CI4 kita kemarin
                const pesanGagal = error.response?.data?.message || "Gagal memproses transaksi barang keluar!";
                alert(pesanGagal);
            }
        };

        onMounted(loadData);
        return { riwayat, barangs, showModal, form, bukaForm, tutupForm, simpanTransaksi };
    }
}