const { createApp } = Vue;
const { createRouter, createWebHashHistory } = VueRouter;

const apiUrl = `${window.location.origin}/lab11_ci4/ci4/public`;

axios.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem('userToken');

        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }

        return config;
    },
    (error) => Promise.reject(error)
);

axios.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response && error.response.status === 401) {
            alert('Sesi Anda telah berakhir atau token tidak sah. Silakan login kembali.');
            localStorage.clear();
            window.location.href = '#/login';
            window.location.reload();
        }

        return Promise.reject(error);
    }
);

const routes = [
    { path: '/', component: Home },
    { path: '/login', component: Login },
    {
        path: '/artikel',
        component: Artikel,
        meta: { requiresAuth: true },
    },
    {
        path: '/about',
        component: About,
        meta: { requiresAuth: true },
    },
];

const router = createRouter({
    history: createWebHashHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const isAuthenticated = localStorage.getItem('isLoggedIn') === 'true';

    if (to.matched.some((record) => record.meta.requiresAuth) && !isAuthenticated) {
        alert('Akses Ditolak! Anda harus login terlebih dahulu.');
        next('/login');
        return;
    }

    next();
});

const app = createApp({
    data() {
        return {
            isLoggedIn: false,
        };
    },
    mounted() {
        this.isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';
    },
    methods: {
        logout() {
            if (confirm('Apakah Anda yakin ingin keluar aplikasi?')) {
                localStorage.clear();
                this.isLoggedIn = false;
                this.$router.push('/');
            }
        },
    },
});

app.use(router);
app.mount('#app');
