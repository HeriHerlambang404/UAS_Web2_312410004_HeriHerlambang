import api from '../api.js';
import { ref, onMounted } from 'vue';

export default {
    template: `
        <div class="p-8">
            <header class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Master Supplier</h1>
                    <p class="text-gray-500 mt-1">Kelola data penyuplai barang Anda.</p>
                </div>
                <button @click="bukaFormTambah" class="bg-primary text-white px-5 py-2.5 rounded-lg shadow-md hover:bg-indigo-600 transition flex items-center gap-2 font-medium">
                    <span>+ Tambah Supplier</span>
                </button>
            </header>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider border-b border-gray-100">
                            <th class="p-4 font-semibold">No</th>
                            <th class="p-4 font-semibold">Nama Supplier</th>
                            <th class="p-4 font-semibold">Telepon</th>
                            <th class="p-4 font-semibold">Alamat</th>
                            <th class="p-4 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in suppliers" :key="item.id" class="border-b border-gray-50 hover:bg-gray-50/50">
                            <td class="p-4 text-gray-500">{{ index + 1 }}</td>
                            <td class="p-4 font-medium text-gray-800">{{ item.nama_supplier }}</td>
                            <td class="p-4 text-gray-500">{{ item.telepon }}</td>
                            <td class="p-4 text-gray-500">{{ item.alamat || '-' }}</td>
                            <td class="p-4 text-center space-x-2">
                                <button @click="bukaFormEdit(item)" class="text-blue-500 bg-blue-50 px-3 py-1 rounded">Edit</button>
                                <button @click="hapusData(item.id)" class="text-red-500 bg-red-50 px-3 py-1 rounded">Hapus</button>
                            </td>
                        </tr>
                        <tr v-if="suppliers.length === 0">
                            <td colspan="5" class="p-8 text-center text-gray-400">Belum ada data supplier.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-if="showModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center z-50">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-xl font-bold text-gray-800">{{ isEdit ? 'Edit Supplier' : 'Tambah Supplier' }}</h3>
                        <button @click="tutupForm" class="text-gray-400 hover:text-red-500 text-2xl">&times;</button>
                    </div>
                    <form @submit.prevent="simpanData" class="p-6">
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Supplier *</label>
                            <input v-model="form.nama_supplier" type="text" class="w-full px-4 py-2 border rounded-lg" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Telepon *</label>
                            <input v-model="form.telepon" type="text" class="w-full px-4 py-2 border rounded-lg" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                            <input v-model="form.email" type="email" class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat</label>
                            <textarea v-model="form.alamat" class="w-full px-4 py-2 border rounded-lg" rows="2"></textarea>
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
        const suppliers = ref([]);
        const showModal = ref(false);
        const isEdit = ref(false);
        const form = ref({ id: '', nama_supplier: '', alamat: '', telepon: '', email: '' });

        const loadData = async () => {
            const res = await api.get('/supplier');
            suppliers.value = res.data;
        };

        const bukaFormTambah = () => { isEdit.value = false; form.value = { id: '', nama_supplier: '', alamat: '', telepon: '', email: '' }; showModal.value = true; };
        const bukaFormEdit = (item) => { isEdit.value = true; form.value = { ...item }; showModal.value = true; };
        const tutupForm = () => { showModal.value = false; };

        const simpanData = async () => {
            try {
                if (isEdit.value) await api.put(`/supplier/${form.value.id}`, form.value);
                else await api.post('/supplier', form.value);
                tutupForm(); loadData();
            } catch (error) { alert("Gagal menyimpan data!"); }
        };

        const hapusData = async (id) => {
            if (confirm('Hapus supplier ini?')) { await api.delete(`/supplier/${id}`); loadData(); }
        };

        onMounted(loadData);
        return { suppliers, showModal, isEdit, form, loadData, bukaFormTambah, bukaFormEdit, tutupForm, simpanData, hapusData };
    }
}