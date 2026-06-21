import api from '../api.js';
import { ref, onMounted } from 'vue';

export default {
    template: `
        <div class="p-8">
            <header class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Master Kategori</h1>
                    <p class="text-gray-500 mt-1">Kelola data kategori barang inventaris.</p>
                </div>
                <button @click="bukaFormTambah" class="bg-primary text-white px-5 py-2.5 rounded-lg shadow-md hover:bg-indigo-600 transition flex items-center gap-2 font-medium">
                    <span>+ Tambah Kategori</span>
                </button>
            </header>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider border-b border-gray-100">
                            <th class="p-4 font-semibold">No</th>
                            <th class="p-4 font-semibold">Nama Kategori</th>
                            <th class="p-4 font-semibold">Deskripsi</th>
                            <th class="p-4 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in kategories" :key="item.id" class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                            <td class="p-4 text-gray-500">{{ index + 1 }}</td>
                            <td class="p-4 font-medium text-gray-800">{{ item.nama_kategori }}</td>
                            <td class="p-4 text-gray-500">{{ item.deskripsi || '-' }}</td>
                            <td class="p-4 text-center space-x-2">
                                <button @click="bukaFormEdit(item)" class="text-blue-500 hover:text-blue-700 bg-blue-50 px-3 py-1 rounded">Edit</button>
                                <button @click="hapusData(item.id)" class="text-red-500 hover:text-red-700 bg-red-50 px-3 py-1 rounded">Hapus</button>
                            </td>
                        </tr>
                        <tr v-if="kategories.length === 0">
                            <td colspan="4" class="p-8 text-center text-gray-400">Belum ada data kategori.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-if="showModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center z-50">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-xl font-bold text-gray-800">{{ isEdit ? 'Edit Kategori' : 'Tambah Kategori' }}</h3>
                        <button @click="tutupForm" class="text-gray-400 hover:text-red-500 text-2xl leading-none">&times;</button>
                    </div>
                    
                    <form @submit.prevent="simpanData" class="p-6">
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                            <input v-model="form.nama_kategori" type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none" required>
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                            <textarea v-model="form.deskripsi" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none" rows="3"></textarea>
                        </div>
                        
                        <div class="flex justify-end gap-3">
                            <button type="button" @click="tutupForm" class="px-5 py-2 rounded-lg text-gray-600 bg-gray-100 hover:bg-gray-200 transition font-medium">Batal</button>
                            <button type="submit" class="px-5 py-2 rounded-lg text-white bg-primary hover:bg-indigo-600 transition font-medium">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    `,
    setup() {
        const kategories = ref([]);
        const showModal = ref(false);
        const isEdit = ref(false);
        const form = ref({ id: '', nama_kategori: '', deskripsi: '' });

        // Fungsi Load Data dari API
        const loadData = async () => {
            try {
                const response = await api.get('/kategori');
                kategories.value = response.data;
            } catch (error) {
                console.error("Gagal memuat data", error);
            }
        };

        // Buka form untuk tambah
        const bukaFormTambah = () => {
            isEdit.value = false;
            form.value = { id: '', nama_kategori: '', deskripsi: '' };
            showModal.value = true;
        };

        // Buka form untuk edit
        const bukaFormEdit = (item) => {
            isEdit.value = true;
            form.value = { ...item }; // Copy data ke form
            showModal.value = true;
        };

        const tutupForm = () => {
            showModal.value = false;
        };

        // Fungsi Simpan (Insert / Update)
        const simpanData = async () => {
            try {
                if (isEdit.value) {
                    await api.put(`/kategori/${form.value.id}`, form.value);
                } else {
                    await api.post('/kategori', form.value);
                }
                tutupForm();
                loadData(); // Refresh tabel
            } catch (error) {
                alert("Gagal menyimpan data!");
                console.error(error);
            }
        };

        // Fungsi Hapus
        const hapusData = async (id) => {
            if (confirm('Yakin ingin menghapus kategori ini?')) {
                try {
                    await api.delete(`/kategori/${id}`);
                    loadData(); // Refresh tabel
                } catch (error) {
                    alert("Gagal menghapus data!");
                }
            }
        };

        // Panggil loadData saat komponen pertama kali dimuat
        onMounted(loadData);

        return { 
            kategories, showModal, isEdit, form, 
            loadData, bukaFormTambah, bukaFormEdit, tutupForm, simpanData, hapusData 
        };
    }
}