const Artikel = {
    template: `
        <div>
            <div class="section-heading">
                <h2>Manajemen Data Artikel</h2>
                <button id="btn-tambah" @click="tambah">Tambah Data</button>
            </div>

            <div class="modal" v-if="showForm">
                <div class="modal-content">
                    <span class="close" @click="showForm = false">&times;</span>
                    <form id="form-data" @submit.prevent="saveData">
                        <h3>{{ formTitle }}</h3>
                        <div>
                            <input type="text" v-model="formData.judul" placeholder="Judul Artikel" required>
                        </div>
                        <div>
                            <textarea v-model="formData.isi" rows="6" placeholder="Isi Artikel" required></textarea>
                        </div>
                        <div>
                            <select v-model="formData.status">
                                <option v-for="option in statusOptions" :value="option.value">
                                    {{ option.text }}
                                </option>
                            </select>
                        </div>
                        <input type="hidden" v-model="formData.id">
                        <button type="submit" id="btnSimpan">Simpan</button>
                        <button type="button" @click="showForm = false">Batal</button>
                    </form>
                </div>
            </div>

            <p v-if="loading" class="info-msg">Memuat data...</p>
            <p v-if="errorMessage" class="error-msg">{{ errorMessage }}</p>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Judul</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index) in artikel" :key="row.id">
                        <td class="center-text">{{ row.id }}</td>
                        <td>{{ row.judul }}</td>
                        <td>{{ statusText(row.status) }}</td>
                        <td class="center-text">
                            <a href="#" @click.prevent="edit(row)">Edit</a>
                            <a href="#" @click.prevent="hapus(index, row.id)">Hapus</a>
                        </td>
                    </tr>
                    <tr v-if="!loading && artikel.length === 0">
                        <td colspan="4" class="center-text">Belum ada artikel.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    `,
    data() {
        return {
            artikel: [],
            formData: {
                id: null,
                judul: '',
                isi: '',
                status: 0,
            },
            showForm: false,
            formTitle: 'Tambah Data',
            statusOptions: [
                { text: 'Draft', value: 0 },
                { text: 'Publish', value: 1 },
            ],
            loading: false,
            errorMessage: '',
        };
    },
    mounted() {
        this.loadData();
    },
    methods: {
        loadData() {
            this.loading = true;
            this.errorMessage = '';

            axios.get(`${apiUrl}/post`)
                .then((response) => {
                    this.artikel = response.data.artikel;
                })
                .catch(() => {
                    this.errorMessage = 'Gagal memuat data artikel.';
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        tambah() {
            this.showForm = true;
            this.formTitle = 'Tambah Data';
            this.formData = {
                id: null,
                judul: '',
                isi: '',
                status: 0,
            };
        },
        edit(data) {
            this.showForm = true;
            this.formTitle = 'Ubah Data';
            this.formData = {
                id: data.id,
                judul: data.judul,
                isi: data.isi,
                status: Number(data.status),
            };
        },
        hapus(index, id) {
            if (!confirm('Yakin menghapus data?')) {
                return;
            }

            axios.delete(`${apiUrl}/post/${id}`)
                .then(() => {
                    this.artikel.splice(index, 1);
                })
                .catch(() => {
                    this.errorMessage = 'Gagal menghapus artikel.';
                });
        },
        saveData() {
            const request = this.formData.id
                ? axios.put(`${apiUrl}/post/${this.formData.id}`, this.formData)
                : axios.post(`${apiUrl}/post`, this.formData);

            request
                .then(() => {
                    this.loadData();
                    this.showForm = false;
                    this.formData = {
                        id: null,
                        judul: '',
                        isi: '',
                        status: 0,
                    };
                })
                .catch(() => {
                    this.errorMessage = 'Gagal menyimpan artikel.';
                });
        },
        statusText(status) {
            return Number(status) === 1 ? 'Publish' : 'Draft';
        },
    },
};
