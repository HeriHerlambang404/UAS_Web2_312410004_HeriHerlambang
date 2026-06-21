import api from '../api.js';
import { ref, onMounted } from 'vue';

export default {
    template: `
        <div class="p-8">
            <header class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Data Barang</h1>
                    <p class="text-gray-500 mt-1">Master data barang beserta stok saat ini.</p>
                </div>
                <button @click="bukaFormTambah" class="bg-primary text-white px-5 py-2.5 rounded-lg shadow-md hover:bg-indigo-600 transition">
                    + Tambah Barang
                </button>
            </header>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider border-b border-gray-100">
                            <th class="p-4">Kode</th>
                            <th class="p-4">Nama Barang</th>
                            <th class="p-4">Kategori</th>
                            <th class="p-4">Supplier</th>
                            <th class="p-4 text-center">Stok</th>
                            <th class="p-4">Harga</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in barangs" :key="item.id" class="border-b border-gray-50 hover:bg-gray-50/50">
                            <td class="p-4 font-semibold text-primary">{{ item.kode_barang }}</td>
                            <td class="p-4 font-medium">{{ item.nama_barang }}</td>
                            <td class="p-4 text-gray-500">{{ item.nama_kategori }}</td>
                            <td class="p-4 text-gray-500">{{ item.nama_supplier }}</td>
                            <td class="p-4 text-center font-bold text-emerald-600">{{ item.stok }} <span class="text-xs font-normal">{{ item.satuan }}</span></td>
                            <td class="p-4 text-gray-500">Rp {{ item.harga }}</td>
                            <td class="p-4 text-center space-x-2">
                                <button @click="bukaFormEdit(item)" class="text-blue-500 bg-blue-50 px-3 py-1 rounded">Edit</button>
                                <button @click="hapusData(item.id)" class="text-red-500 bg-red-50 px-3 py-1 rounded">Hapus</button>
                            </td>
                        </tr>
                        <tr v-if="barangs.length === 0">
                            <td colspan="7" class="p-8 text-center text-gray-400">Belum ada data barang.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-if="showModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-xl font-bold">{{ isEdit ? 'Edit Barang' : 'Tambah Barang' }}</h3>
                        <button @click="tutupForm" class="text-gray-400 hover:text-red-500 text-2xl">&times;</button>
                    </div>
                    <form @submit.prevent="simpanData" class="p-6">
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-semibold mb-2">Kode Barang *</label>
                                <input v-model="form.kode_barang" type="text" class="w-full px-4 py-2 border rounded-lg bg-gray-50" :disabled="isEdit" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-2">Nama Barang *</label>
                                <input v-model="form.nama_barang" type="text" class="w-full px-4 py-2 border rounded-lg" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-semibold mb-2">Kategori *</label>
                                <select v-model="form.kategori_id" class="w-full px-4 py-2 border rounded-lg" required>
                                    <option v-for="kat in kategories" :value="kat.id">{{ kat.nama_kategori }}</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-2">Supplier *</label>
                                <select v-model="form.supplier_id" class="w-full px-4 py-2 border rounded-lg" required>
                                    <option v-for="sup in suppliers" :value="sup.id">{{ sup.nama_supplier }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <label class="block text-sm font-semibold mb-2">Satuan (Pcs, Box, dll) *</label>
                                <input v-model="form.satuan" type="text" class="w-full px-4 py-2 border rounded-lg" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-2">Harga Satuan *</label>
                                <input v-model="form.harga" type="number" class="w-full px-4 py-2 border rounded-lg" required>
                            </div>
                        </div>
                        
                        <div class="flex justify-end gap-3">
                            <button type="button" @click="tutupForm" class="px-5 py-2 rounded-lg bg-gray-100">Batal</button>
                            <button type="submit" class="px-5 py-2 rounded-lg text-white bg-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    `,
    setup() {
        const barangs = ref([]);
        const kategories = ref([]);
        const suppliers = ref([]);
        const showModal = ref(false);
        const isEdit = ref(false);
        
        const form = ref({ id: '', kode_barang: '', nama_barang: '', kategori_id: '', supplier_id: '', satuan: '', harga: '' });

        const loadData = async () => {
            const resBarang = await api.get('/barang');
            barangs.value = resBarang.data;
            
            // Tarik data untuk Dropdown
            const resKat = await api.get('/kategori'); kategories.value = resKat.data;
            const resSup = await api.get('/supplier'); suppliers.value = resSup.data;
        };

        const bukaFormTambah = () => { 
            isEdit.value = false; 
            form.value = { id: '', kode_barang: '', nama_barang: '', kategori_id: '', supplier_id: '', satuan: '', harga: '' }; 
            showModal.value = true; 
        };
        const bukaFormEdit = (item) => { 
            isEdit.value = true; 
            form.value = { ...item }; 
            showModal.value = true; 
        };
        const tutupForm = () => { showModal.value = false; };

        const simpanData = async () => {
            try {
                if (isEdit.value) await api.put(`/barang/${form.value.id}`, form.value);
                else await api.post('/barang', form.value);
                tutupForm(); loadData();
            } catch (error) { 
                alert("Gagal menyimpan data! Pastikan Kode Barang unik/belum dipakai."); 
            }
        };

        const hapusData = async (id) => {
            if (confirm('Hapus barang ini?')) { await api.delete(`/barang/${id}`); loadData(); }
        };

        onMounted(loadData);
        return { barangs, kategories, suppliers, showModal, isEdit, form, loadData, bukaFormTambah, bukaFormEdit, tutupForm, simpanData, hapusData };
    }
}