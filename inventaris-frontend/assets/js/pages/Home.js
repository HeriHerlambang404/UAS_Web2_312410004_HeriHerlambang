export default {
    template: `
        <div class="scroll-smooth">
            <section class="relative h-screen flex flex-col items-center justify-center bg-fixed bg-center bg-cover" style="background-image: url('https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?q=80&w=2070&auto=format&fit=crop');">
                <div class="absolute inset-0 bg-slate-900/70"></div> 
                
                <div class="relative z-10 text-center px-4">
                    <h1 class="text-6xl md:text-8xl font-extrabold mb-4 tracking-tight text-white drop-shadow-xl">
                        Inventaris <span class="text-primary">Pro</span>
                    </h1>
                    <p class="text-xl md:text-2xl text-gray-200 mb-10 max-w-2xl mx-auto drop-shadow-md">
                        Kendalikan pergerakan barang Anda dengan presisi. Cerdas, Cepat, Terintegrasi.
                    </p>
                    
                    <a href="#cerita-1" class="animate-bounce inline-flex items-center justify-center w-14 h-14 bg-white text-primary rounded-full shadow-2xl hover:bg-gray-200 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                    </a>
                </div>
            </section>

            <section id="cerita-1" class="min-h-screen bg-white text-gray-800 py-24 px-6 md:px-12 flex flex-col justify-center">
                <div class="max-w-5xl mx-auto flex flex-col md:flex-row items-center gap-12 md:gap-24">
                    <div class="flex-1 text-right">
                        <h2 class="text-4xl md:text-5xl font-bold text-primary mb-6">Pantau Stok Real-time</h2>
                        <p class="text-xl text-gray-600 leading-relaxed">
                            Tidak ada lagi barang hilang atau salah catat. Setiap transaksi barang masuk dan keluar akan langsung mengkalkulasi stok secara otomatis di dalam sistem Anda.
                        </p>
                    </div>
                    <div class="flex-1 w-full">
                        <div class="h-80 bg-indigo-50 border-4 border-indigo-100 rounded-3xl shadow-lg flex items-center justify-center text-7xl transform hover:scale-105 transition duration-500">
                            📦
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-20">
                    <a href="#cerita-2" class="text-gray-400 hover:text-primary transition">Scroll ke bawah &darr;</a>
                </div>
            </section>

            <section id="cerita-2" class="min-h-screen bg-gray-50 text-gray-800 py-24 px-6 md:px-12 flex flex-col justify-center">
                <div class="max-w-5xl mx-auto flex flex-col md:flex-row-reverse items-center gap-12 md:gap-24">
                    <div class="flex-1 text-left">
                        <h2 class="text-4xl md:text-5xl font-bold text-secondary mb-6">Manajemen Data Terpusat</h2>
                        <p class="text-xl text-gray-600 leading-relaxed">
                            Kelola dari mana barang Anda berasal, dan kelompokkan berdasarkan kategori. Relasi antar data yang kuat membuat pelacakan histori menjadi sangat mudah.
                        </p>
                    </div>
                    <div class="flex-1 w-full">
                        <div class="h-80 bg-emerald-50 border-4 border-emerald-100 rounded-3xl shadow-lg flex items-center justify-center text-7xl transform hover:scale-105 transition duration-500">
                            🏢
                        </div>
                    </div>
                </div>
            </section>

            <section class="h-screen flex items-center justify-center relative bg-fixed bg-center bg-cover" style="background-image: url('https://images.unsplash.com/photo-1553413077-190dd305871c?q=80&w=2070&auto=format&fit=crop');">
                <div class="absolute inset-0 bg-primary/80 mix-blend-multiply"></div>
                <div class="relative z-10 text-center px-4 max-w-3xl">
                    <h2 class="text-5xl md:text-6xl font-bold mb-6 text-white">Siap Mengambil Kendali?</h2>
                    <p class="text-xl md:text-2xl mb-12 text-indigo-100">
                        Sistem ini dilindungi dengan sistem autentikasi Bearer Token. Silakan masuk untuk mengelola inventaris.
                    </p>
                    <router-link to="/login" class="inline-flex items-center gap-3 bg-white text-primary font-bold px-10 py-5 rounded-full shadow-2xl hover:scale-105 hover:bg-gray-100 transition-all duration-300 text-lg">
                        <span>Masuk ke Dashboard</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7 7H3"></path></svg>
                    </router-link>
                </div>
            </section>
        </div>
    `
}