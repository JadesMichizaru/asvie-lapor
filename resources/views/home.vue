<template>
  <div class="selection:bg-teal-700 selection:text-white flex flex-col min-h-screen font-sans bg-slate-50 text-slate-900">
    <!-- NAVIGATION BAR -->
    <header class="bg-[#12544F] border-b border-white/10 sticky top-0 z-50 shadow-md">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
          <a href="#" class="flex items-center gap-3 group text-left">
            <div class="w-10 h-10 bg-white text-[#12544F] rounded-lg flex items-center justify-center font-black text-xl shadow-md group-hover:scale-105 transition-transform duration-200">
              <svg class="w-6 h-6 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
              </svg>
            </div>
            <div class="flex flex-col">
              <span class="text-2xl font-black text-white tracking-wider leading-none">LAPOR!</span>
              <span class="text-[10px] font-semibold text-rose-100 tracking-tight mt-0.5">SMK As-Syafiiyah Jakarta</span>
            </div>
          </a>

          <!-- Page Navigation Tabs -->
          <nav class="hidden md:flex items-center gap-2 bg-teal-900/40 p-1.5 rounded-xl border border-white/10 text-xs font-bold text-white">
            <button @click="activeView = 'form'" :class="['px-4 py-2 rounded-lg transition-all', activeView === 'form' ? 'bg-white text-[#12544F] shadow' : 'hover:bg-white/10']">
              Buat Pengaduan
            </button>
            <button @click="activeView = 'reports'" :class="['px-4 py-2 rounded-lg transition-all', activeView === 'reports' ? 'bg-white text-[#12544F] shadow' : 'hover:bg-white/10']">
              Daftar Laporan
            </button>
            <button @click="activeView = 'stats'" :class="['px-4 py-2 rounded-lg transition-all', activeView === 'stats' ? 'bg-white text-[#12544F] shadow' : 'hover:bg-white/10']">
              Statistik Grafik
            </button>
          </nav>

          <!-- Status Auth User & Notification Button -->
          <div class="hidden md:flex items-center gap-3">
            <button @click="requestNotificationPermission" title="Aktifkan Notifikasi" class="p-2.5 rounded-xl bg-teal-900/60 border border-white/20 text-white hover:bg-teal-800 transition-colors relative">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
              </svg>
              <span v-if="notificationEnabled" class="absolute top-1 right-1 w-2.5 h-2.5 bg-emerald-400 border-2 border-[#12544F] rounded-full"></span>
            </button>

            <template v-if="user">
              <div class="flex items-center gap-3 bg-teal-900/60 border border-white/20 px-4 py-2 rounded-xl">
                <div class="w-8 h-8 rounded-full bg-white/20 text-white flex items-center justify-center font-bold text-sm">
                  {{ user.name ? user.name.charAt(0).toUpperCase() : 'U' }}
                </div>
                <div class="flex flex-col text-left">
                  <span class="text-xs text-rose-100 font-medium">Halo,</span>
                  <span class="text-sm font-bold text-white leading-none">{{ user.name }}</span>
                </div>
                <button @click="handleLogout" class="ml-2 text-xs font-semibold text-rose-200 hover:text-white underline">
                  Keluar
                </button>
              </div>
            </template>
            <template v-else>
              <button @click="openAuthModal('login')" class="px-5 py-2.5 rounded-xl text-sm font-bold text-white border border-white/30 hover:bg-white hover:text-[#12544F] transition-all duration-200">
                Masuk
              </button>
              <button @click="openAuthModal('register')" class="px-5 py-2.5 rounded-xl text-sm font-bold text-[#12544F] bg-white hover:bg-rose-50 transition-all duration-200 shadow-md">
                Daftar
              </button>
            </template>
          </div>

          <button @click="isMobileMenuOpen = !isMobileMenuOpen" class="md:hidden p-2 rounded-lg text-white hover:bg-teal-800 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
          </button>
        </div>
      </div>

      <!-- Mobile Menu -->
      <div v-if="isMobileMenuOpen" class="md:hidden bg-teal-900 border-t border-white/10 px-4 pt-3 pb-6 space-y-3">
        <button @click="activeView = 'form'; isMobileMenuOpen = false" class="block w-full text-left py-2 text-sm font-semibold text-white">Buat Pengaduan</button>
        <button @click="activeView = 'reports'; isMobileMenuOpen = false" class="block w-full text-left py-2 text-sm font-semibold text-white">Daftar Laporan</button>
        <button @click="activeView = 'stats'; isMobileMenuOpen = false" class="block w-full text-left py-2 text-sm font-semibold text-white">Statistik Grafik</button>
        <button @click="requestNotificationPermission" class="block w-full text-left py-2 text-sm font-semibold text-emerald-300">
          {{ notificationEnabled ? 'Notifikasi Aktif' : 'Aktifkan Notifikasi Website' }}
        </button>

        <div class="pt-3 border-t border-white/10">
          <template v-if="user">
            <div class="flex items-center justify-between text-white py-2">
              <span class="text-sm font-bold">Halo, {{ user.name }}</span>
              <button @click="handleLogout" class="text-xs font-bold text-rose-300">Keluar</button>
            </div>
          </template>
          <template v-else>
            <div class="grid grid-cols-2 gap-3">
              <button @click="openAuthModal('login')" class="py-2.5 text-center rounded-xl text-xs font-bold text-white border border-white/30">Masuk</button>
              <button @click="openAuthModal('register')" class="py-2.5 text-center rounded-xl text-xs font-bold text-[#12544F] bg-white">Daftar</button>
            </div>
          </template>
        </div>
      </div>
    </header>

    <main class="flex-1">
      <!-- HERO BANNER -->
      <section class="bg-[#689D4B] hero-cross-pattern relative text-white pt-10 pb-36 overflow-hidden">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8 relative z-10 animate-fade-in">
          <h1 class="text-3xl sm:text-5xl font-black tracking-tight leading-tight mb-3">
            Layanan Aspirasi & Pengaduan
          </h1>
          <p class="text-sm sm:text-base text-white/90 font-medium max-w-2xl mx-auto leading-relaxed">
            Sistem terpadu pelaporan masalah dan pelanggaran di lingkungan SMK As-Syafiiyah Jakarta.
          </p>
        </div>
      </section>

      <!-- VIEW 1: FORM PENGADUAN -->
      <section v-if="activeView === 'form'" class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-24 z-20 mb-20">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200/80 p-6 sm:p-10 animate-slide-up">
          <div class="text-center mb-8">
            <span class="text-[11px] font-extrabold uppercase tracking-widest text-[#12544F]">FORMULIR PENGADUAN</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1 tracking-tight">Sampaikan Kejadian</h2>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">Pastikan pengaduan Anda jelas dan disertai bukti lokasi/foto jika ada.</p>
          </div>

          <form @submit.prevent="handleFormSubmit" class="space-y-5">
            <div>
              <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul laporan <span class="text-red-600">*</span></label>
              <input v-model="form.title" type="text" required placeholder="Ringkas inti pengaduan Anda" class="w-full px-4 py-3.5 rounded-xl border border-slate-300 text-sm font-medium focus:border-[#12544F] focus:ring-2 focus:ring-[#12544F]/20 outline-none transition-all">
            </div>

            <div>
              <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Isi laporan <span class="text-red-600">*</span></label>
              <textarea v-model="form.description" required rows="4" placeholder="Ceritakan kronologi kejadian secara lengkap..." class="w-full px-4 py-3.5 rounded-xl border border-slate-300 text-sm font-medium focus:border-[#12544F] focus:ring-2 focus:ring-[#12544F]/20 outline-none resize-none transition-all"></textarea>
            </div>

            <div>
              <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Lokasi Kejadian <span class="text-red-600">*</span></label>
              <input v-model="form.location" type="text" required placeholder="Contoh: Gedung B Lantai 2 / Area Parkir Depan" class="w-full px-4 py-3.5 rounded-xl border border-slate-300 text-sm font-medium focus:border-[#12544F] focus:ring-2 focus:ring-[#12544F]/20 outline-none transition-all">
            </div>

            <div>
              <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kategori laporan <span class="text-red-600">*</span></label>
              <select v-model="form.category" required class="w-full px-4 py-3.5 rounded-xl border border-slate-300 text-sm font-medium focus:border-[#12544F] focus:ring-2 focus:ring-[#12544F]/20 outline-none bg-white transition-all">
                <option value="">Pilih kategori laporan</option>
                <option value="merokok">Merokok</option>
                <option value="tawuran">Tawuran</option>
                <option value="buang_sampah_sembarangan">Buang Sampah Sembarangan</option>
                <option value="membuat_kegaduhan">Membuat Kegaduhan</option>
                <option value="parkir_sembarangan">Parkir Sembarangan</option>
                <option value="lainnya">Lainnya</option>
              </select>
            </div>

            <div class="pt-2 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
              <div>
                <label class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border-2 border-dashed border-slate-300 hover:border-[#12544F] text-slate-700 hover:text-[#12544F] text-xs font-bold cursor-pointer transition-colors bg-slate-50/50">
                  <svg class="w-4 h-4 text-[#12544F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                  </svg>
                  <span>{{ fileName || 'Upload bukti (Foto/Video Maks 10MB)' }}</span>
                  <input type="file" ref="fileInput" @change="handleFileChange" class="hidden" accept="image/png,image/jpeg,image/jpg,video/mp4">
                </label>
              </div>

              <div class="flex items-center gap-6">
                <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
                  <input v-model="form.is_anonymous" type="checkbox" class="w-4 h-4 rounded text-[#12544F] focus:ring-[#12544F] border-slate-300">
                  Sembunyikan Identitas (Anonim)
                </label>
              </div>
            </div>

            <button :disabled="isLoading" type="submit" class="w-full mt-6 py-4 bg-[#12544F] hover:bg-teal-800 text-white font-extrabold rounded-xl shadow-lg shadow-[#12544F]/25 active:scale-[0.99] transition-all flex items-center justify-center gap-2 text-sm sm:text-base disabled:opacity-50">
              <span v-if="isLoading">Mengirim...</span>
              <template v-else>
                Kirim Pengaduan
                <svg class="w-4 h-4 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
              </template>
            </button>
          </form>
        </div>
      </section>

      <!-- VIEW 2: DAFTAR LAPORAN -->
      <section v-if="activeView === 'reports'" class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 -mt-24 z-20 mb-20">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200/80 p-6 sm:p-8 animate-slide-up">
          <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-200">
            <div>
              <h2 class="text-xl font-extrabold text-slate-900">Daftar Pengaduan Terbaru</h2>
              <p class="text-xs text-slate-500 font-medium mt-0.5">Pantau progres penanganan secara transparan.</p>
            </div>
            <button @click="fetchReports" class="text-xs font-bold text-[#12544F] hover:underline flex items-center gap-1.5">
              <svg class="w-4 h-4 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
              </svg>
              Refresh
            </button>
          </div>

          <div v-if="reportsList.length === 0" class="text-center py-12 text-slate-400 font-medium text-sm">
            Belum ada data laporan yang dikirimkan.
          </div>

          <div v-else class="space-y-4">
            <div v-for="item in reportsList" :key="item.id" class="p-5 rounded-xl border border-slate-200 hover:border-[#12544F]/40 transition-colors bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
              <div class="space-y-1">
                <div class="flex items-center gap-2">
                  <span class="text-xs font-extrabold px-2.5 py-1 rounded-md capitalize" :class="getStatusBadgeClass(item.status)">
                    {{ item.status }}
                  </span>
                  <span class="text-xs text-slate-400 font-semibold">• {{ item.category }}</span>
                </div>
                <h3 class="font-bold text-slate-800 text-sm">{{ item.title }}</h3>
                <p class="text-xs text-slate-600 line-clamp-2">{{ item.description }}</p>
                <div class="flex items-center gap-2 text-[11px] text-slate-400 font-medium pt-1">
                  <span class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ item.location }}
                  </span>
                  <span>| Pelapor: {{ item.is_anonymous ? 'Anonim' : (item.user?.name || 'Warga') }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- VIEW 3: STATISTIK CHART REAL-TIME -->
      <section v-if="activeView === 'stats'" class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 -mt-24 z-20 mb-20">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200/80 p-6 sm:p-8 animate-slide-up">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-200">
            <div>
              <h2 class="text-xl font-extrabold text-slate-900">Statistik Grafik Real-time</h2>
              <p class="text-xs text-slate-500 font-medium mt-0.5">Visualisasi data laporan nyata terakumulasi dari database.</p>
            </div>

            <!-- Filter Range Chart -->
            <div class="flex items-center bg-slate-100 p-1 rounded-xl border border-slate-200 text-xs font-bold">
              <button @click="chartTimeframe = 'daily'; renderChart()" :class="['px-3 py-1.5 rounded-lg transition-all', chartTimeframe === 'daily' ? 'bg-[#12544F] text-white' : 'text-slate-600']">
                Harian
              </button>
              <button @click="chartTimeframe = 'weekly'; renderChart()" :class="['px-3 py-1.5 rounded-lg transition-all', chartTimeframe === 'weekly' ? 'bg-[#12544F] text-white' : 'text-slate-600']">
                Mingguan
              </button>
              <button @click="chartTimeframe = 'monthly'; renderChart()" :class="['px-3 py-1.5 rounded-lg transition-all', chartTimeframe === 'monthly' ? 'bg-[#12544F] text-white' : 'text-slate-600']">
                Bulanan
              </button>
            </div>
          </div>

          <!-- Chart Canvas Container -->
          <div class="relative w-full h-80">
            <canvas id="reportStatsChart"></canvas>
          </div>
        </div>
      </section>
    </main>

    <!-- FOOTER LENGKAP -->
    <footer class="bg-slate-950 text-white pt-16 pb-10 border-t border-slate-800">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-slate-800">

          <!-- Deskripsi Sekolah/Aplikasi -->
          <div class="md:col-span-2 space-y-4">
            <div class="flex items-center gap-3">
              <div class="w-9 h-9 bg-[#12544F] text-white rounded-lg flex items-center justify-center font-black text-lg">
                <svg class="w-5 h-5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
              </div>
              <span class="text-xl font-black tracking-wider text-white">LAPOR! SMK As-Syafiiyah</span>
            </div>
            <p class="text-xs text-slate-400 font-medium leading-relaxed max-w-sm">
              Sistem Pelaporan dan Layanan Pengaduan Resmi SMK As-Syafiiyah Jakarta. Berkomitmen menciptakan lingkungan sekolah yang tertib, transparan, dan responsif terhadap keluhan siswa serta wali murid.
            </p>
          </div>

          <!-- Navigasi Cepat -->
          <div>
            <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-300 mb-4">Navigasi Layanan</h4>
            <ul class="space-y-2.5 text-xs font-semibold text-slate-400">
              <li><button @click="activeView = 'form'" class="hover:text-white transition-colors">Buat Pengaduan</button></li>
              <li><button @click="activeView = 'reports'" class="hover:text-white transition-colors">Daftar Laporan</button></li>
              <li><button @click="activeView = 'stats'" class="hover:text-white transition-colors">Statistik & Grafik</button></li>
            </ul>
          </div>

          <!-- Kontak Sekolah -->
          <div>
            <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-300 mb-4">Kontak & Lokasi</h4>
            <ul class="space-y-2 text-xs font-medium text-slate-400">
              <li class="flex items-center gap-2">
                <svg class="w-4 h-4 stroke-current text-[#12544F]" fill="none" viewBox="0 0 24 24" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Jl. Bukit Duri Selatan No. 29, Kec. Tebet Kota Adm. Jakarta Selatan, Prov. D.K.I. Jakarta Kode Pos: 12840
              </li>
              <li class="flex items-center gap-2">
                <svg class="w-4 h-4 stroke-current text-[#12544F]" fill="none" viewBox="0 0 24 24" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                (021) 8319994
              </li>
              <li class="flex items-center gap-2">
                <svg class="w-4 h-4 stroke-current text-[#12544F]" fill="none" viewBox="0 0 24 24" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                smk.assyafiiyah.jakarta@gmail.com
              </li>
            </ul>
          </div>
        </div>

        <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 font-medium gap-3">
          <p>&copy; 2026 LAPOR! SMK As-Syafiiyah Jakarta. All rights reserved.</p>
          <p class="text-slate-400 font-semibold">Dikembangkan oleh Michizaru Studio</p>
        </div>
      </div>
    </footer>

    <!-- AUTH MODAL -->
    <div v-if="showAuthModal" class="fixed inset-0 z-50 bg-slate-950/70 backdrop-blur-sm flex items-center justify-center p-4">
      <div class="bg-white rounded-3xl max-w-sm w-full p-6 sm:p-8 shadow-2xl relative animate-scale-up">
        <button @click="showAuthModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 font-bold text-lg">✕</button>
        <div class="text-center mb-6">
          <div class="w-10 h-10 bg-[#12544F] text-white rounded-lg flex items-center justify-center font-black mx-auto mb-3">L!</div>
          <h3 class="text-lg font-extrabold text-slate-900">{{ authMode === 'login' ? 'Masuk ke LAPOR!' : 'Daftar Akun Baru' }}</h3>
        </div>

        <form @submit.prevent="handleAuthSubmit" class="space-y-4">
          <div v-if="authMode === 'register'">
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap</label>
            <input v-model="authForm.name" type="text" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-xs font-medium outline-none">
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Email</label>
            <input v-model="authForm.email" type="email" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-xs font-medium outline-none">
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Kata Sandi</label>
            <input v-model="authForm.password" type="password" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-xs font-medium outline-none">
          </div>
          <button type="submit" class="w-full py-3.5 bg-[#12544F] hover:bg-teal-800 text-white font-extrabold text-xs rounded-xl transition-all mt-2">
            {{ authMode === 'login' ? 'Masuk' : 'Daftar' }}
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, watch, nextTick } from 'vue'
import Swal from 'sweetalert2'
import Chart from 'chart.js/auto'

const user = ref(null)
const activeView = ref('form')
const isMobileMenuOpen = ref(false)
const showAuthModal = ref(false)
const authMode = ref('login')
const isLoading = ref(false)
const fileName = ref('')
const fileInput = ref(null)
const notificationEnabled = ref(false)

const chartTimeframe = ref('daily')
let chartInstance = null

const reportsList = ref([])

const form = reactive({
  title: '',
  description: '',
  location: '',
  category: '',
  is_anonymous: false,
  evidence_file: null
})

const authForm = reactive({
  name: '',
  email: '',
  password: ''
})

const requestNotificationPermission = async () => {
  if (!('Notification' in window)) {
    Swal.fire({ icon: 'warning', title: 'Browser Tidak Mendukung', text: 'Browser Anda tidak mendukung notifikasi web.' })
    return
  }

  const permission = await Notification.requestPermission()
  if (permission === 'granted') {
    notificationEnabled.value = true
    new Notification('Notifikasi Diaktifkan!', {
      body: 'Anda akan menerima pemberitahuan setiap ada pembaruan status laporan.',
      icon: '/favicon.ico'
    })
  } else {
    notificationEnabled.value = false
  }
}

const sendBrowserNotification = (title, body) => {
  if (Notification.permission === 'granted') {
    new Notification(title, { body, icon: '/favicon.ico' })
  }
}

const handleFileChange = (e) => {
  const file = e.target.files[0]
  if (file) {
    fileName.value = file.name
    form.evidence_file = file
  }
}

const handleFormSubmit = async () => {
  isLoading.value = true
  try {
    const formData = new FormData()
    formData.append('title', form.title)
    formData.append('description', form.description)
    formData.append('location', form.location)
    formData.append('category', form.category)
    formData.append('is_anonymous', form.is_anonymous ? 1 : 0)
    if (form.evidence_file) {
      formData.append('evidence_file', form.evidence_file)
    }

    const token = localStorage.getItem('auth_token')
    const headers = { 'Accept': 'application/json' }
    if (token) headers['Authorization'] = `Bearer ${token}`

    const response = await fetch('/api/report', {
      method: 'POST',
      headers,
      body: formData
    })

    const resData = await response.json()
    if (response.ok && resData.success) {
      Swal.fire({
        icon: 'success',
        title: 'Pengaduan Terkirim!',
        text: 'Pengaduan Anda berhasil dicatat dan sedang diproses.',
        confirmButtonColor: '#12544F'
      })

      sendBrowserNotification('Laporan Berhasil Dibuat', `Laporan "${form.title}" sedang menunggu proses verifikasi petugas.`)
      resetForm()
      await fetchReports()
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Gagal Mengirim',
        text: resData.message || 'Terjadi kesalahan saat memproses pengaduan.',
        confirmButtonColor: '#12544F'
      })
    }
  } catch (error) {
    Swal.fire({
      icon: 'error',
      title: 'Kesalahan Server',
      text: 'Tidak dapat terhubung ke server backend.',
      confirmButtonColor: '#12544F'
    })
  } finally {
    isLoading.value = false
  }
}

const resetForm = () => {
  form.title = ''
  form.description = ''
  form.location = ''
  form.category = ''
  form.is_anonymous = false
  form.evidence_file = null
  fileName.value = ''
  if (fileInput.value) fileInput.value.value = ''
}

const fetchReports = async () => {
  try {
    const token = localStorage.getItem('auth_token')
    const headers = { 'Accept': 'application/json' }
    if (token) headers['Authorization'] = `Bearer ${token}`

    const res = await fetch('/api/report', { headers })
    const data = await res.json()
    if (res.ok && data.success) {
      reportsList.value = data.data
      if (activeView.value === 'stats') {
        renderChart()
      }
    }
  } catch (e) {
    console.error('Gagal mengambil laporan:', e)
  }
}

const getStatusBadgeClass = (status) => {
  switch (status) {
    case 'menunggu': return 'bg-amber-100 text-amber-800'
    case 'diproses': return 'bg-blue-100 text-blue-800'
    case 'selesai': return 'bg-emerald-100 text-emerald-800'
    case 'ditolak': return 'bg-rose-100 text-rose-800'
    default: return 'bg-slate-100 text-slate-800'
  }
}

// Logic pemrosesan data riil dari backend untuk Chart.js
const processRealChartData = () => {
  const timeframe = chartTimeframe.value
  let labels = []

  if (timeframe === 'daily') {
    labels = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
  } else if (timeframe === 'weekly') {
    labels = ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4']
  } else {
    labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
  }

  const counts = {
    menunggu: new Array(labels.length).fill(0),
    diproses: new Array(labels.length).fill(0),
    selesai: new Array(labels.length).fill(0),
    ditolak: new Array(labels.length).fill(0)
  }

  reportsList.value.forEach((item) => {
    if (!item.created_at) return
    const date = new Date(item.created_at)
    let index = 0

    if (timeframe === 'daily') {
      index = date.getDay()
    } else if (timeframe === 'weekly') {
      const dayOfMonth = date.getDate()
      index = Math.min(Math.floor((dayOfMonth - 1) / 7), 3)
    } else {
      index = date.getMonth()
    }

    const statusKey = item.status ? item.status.toLowerCase() : 'menunggu'
    if (counts[statusKey] !== undefined && index >= 0 && index < labels.length) {
      counts[statusKey][index] += 1
    }
  })

  return { labels, counts }
}

const renderChart = async () => {
  await nextTick()
  const canvas = document.getElementById('reportStatsChart')
  if (!canvas) return

  if (chartInstance) {
    chartInstance.destroy()
  }

  const { labels, counts } = processRealChartData()

  chartInstance = new Chart(canvas, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [
        { label: 'Menunggu', data: counts.menunggu, backgroundColor: '#f59e0b' },
        { label: 'Diproses', data: counts.diproses, backgroundColor: '#3b82f6' },
        { label: 'Selesai', data: counts.selesai, backgroundColor: '#10b981' },
        { label: 'Ditolak', data: counts.ditolak, backgroundColor: '#f43f5e' }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { position: 'top' }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: { stepSize: 1 }
        }
      }
    }
  })
}

watch(activeView, (newView) => {
  if (newView === 'stats') {
    renderChart()
  } else if (newView === 'reports') {
    fetchReports()
  }
})

const openAuthModal = (mode) => {
  authMode.value = mode
  showAuthModal.value = true
}

const handleAuthSubmit = async () => {
  const endpoint = authMode.value === 'login' ? '/api/login' : '/api/register'
  try {
    const response = await fetch(endpoint, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify(authForm)
    })
    const data = await response.json()

    if (response.ok) {
      if (data.token) {
        localStorage.setItem('auth_token', data.token)
      }
      if (data.user) {
        localStorage.setItem('user_data', JSON.stringify(data.user))
        user.value = data.user
      }

      showAuthModal.value = false
      authForm.name = ''
      authForm.email = ''
      authForm.password = ''

      Swal.fire({
        icon: 'success',
        title: authMode.value === 'login' ? 'Berhasil Masuk!' : 'Registrasi Berhasil!',
        text: `Selamat datang kembali, ${data.user?.name || ''}`,
        timer: 2000,
        showConfirmButton: false
      })
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Otentikasi Gagal',
        text: data.message || 'Periksa kembali data yang Anda masukkan.',
        confirmButtonColor: '#12544F'
      })
    }
  } catch (error) {
    Swal.fire({
      icon: 'error',
      title: 'Kesalahan Server',
      text: 'Gagal menghubungkan ke server.',
      confirmButtonColor: '#12544F'
    })
  }
}

const handleLogout = () => {
  localStorage.removeItem('auth_token')
  localStorage.removeItem('user_data')
  user.value = null
  Swal.fire({ icon: 'success', title: 'Selesai', text: 'Anda telah keluar.', timer: 1500, showConfirmButton: false })
}

const checkStoredUser = () => {
  const storedUser = localStorage.getItem('user_data')
  if (storedUser) {
    try { user.value = JSON.parse(storedUser) } catch (e) { localStorage.removeItem('user_data') }
  }
  if ('Notification' in window && Notification.permission === 'granted') {
    notificationEnabled.value = true
  }
}

onMounted(() => {
  checkStoredUser()
  fetchReports()
})
</script>

<style scoped>
.hero-cross-pattern {
  background-image:
    linear-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255, 255, 255, 0.08) 1px, transparent 1px);
  background-size: 32px 32px;
}

@keyframes slideUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

.animate-slide-up {
  animation: slideUp 0.4s ease-out forwards;
}
</style>
