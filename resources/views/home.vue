<template>
  <div class="selection:bg-teal-700 selection:text-white flex flex-col min-h-screen font-sans bg-slate-50 text-slate-900">
    <!-- NAVIGATION BAR -->
    <header class="bg-[#12544F] border-b border-white/10 sticky top-0 z-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
          <a href="#" class="flex items-center gap-3 group text-left">
            <div class="w-10 h-10 bg-white text-[#12544F] rounded-lg flex items-center justify-center font-black text-xl shadow-md group-hover:scale-105 transition-transform duration-200">
              <svg class="w-6 h-6 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
              </svg>
            </div>
            <div class="flex flex-col">
              <span class="text-2xl font-black text-white tracking-wider leading-none">ASVIELAPOR!</span>
              <span class="text-[10px] font-semibold text-rose-100 tracking-tight mt-0.5">Layanan Pengaduan Online Masyarakat</span>
            </div>
          </a>

          <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-white/90">
            <a href="#about-section" class="hover:text-white transition-colors">Tentang ASVIELAPOR!</a>
            <a href="#flow-section" class="hover:text-white transition-colors">Alur Pelaporan</a>
            <a href="#stats-section" class="hover:text-white transition-colors">Statistik</a>
            <a href="#faq-section" class="hover:text-white transition-colors">FAQ</a>
          </nav>

          <!-- Status Auth User -->
          <div class="hidden md:flex items-center gap-3">
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
        <a href="#about-section" @click="isMobileMenuOpen = false" class="block py-2 text-sm font-semibold text-white">Tentang ASVIELAPOR!</a>
        <a href="#flow-section" @click="isMobileMenuOpen = false" class="block py-2 text-sm font-semibold text-white">Alur Pelaporan</a>
        <a href="#stats-section" @click="isMobileMenuOpen = false" class="block py-2 text-sm font-semibold text-white">Statistik</a>
        <a href="#faq-section" @click="isMobileMenuOpen = false" class="block py-2 text-sm font-semibold text-white">FAQ</a>

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
      <!-- HERO BANNER SECTION -->
      <section id="about-section" class="bg-[#689D4B] hero-cross-pattern relative text-white pt-14 pb-48 lg:pb-56 overflow-hidden">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8 relative z-10">
          <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-tight mb-5">
            Suara Anda,<br class="hidden sm:inline"> perubahan bagi Sekolah kami.
          </h1>
          <p class="text-base sm:text-lg text-white/90 font-medium max-w-2xl mx-auto leading-relaxed">
            Sampaikan pengaduan Anda terkait pelajar SMK As-Syafiiyah langsung kepada karyawan SMK As-Syafiiyah.
          </p>
        </div>
      </section>

      <!-- FLOATING FORM CONTAINER -->
      <section class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-36 lg:-mt-44 z-20 mb-20">
        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200/80 p-6 sm:p-10">
          <div class="text-center mb-8">
            <span class="text-[11px] font-extrabold uppercase tracking-widest text-[#12544F]">SAMPAIKAN PENGADUAN</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1 tracking-tight">Apa yang ingin Anda laporkan?</h2>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">Sampaikan keluhan dan kejadian secara jelas.</p>
          </div>

          <p class="text-xs text-center text-slate-500 mb-6 font-medium">
            Pastikan pengaduan Anda jelas dan tidak mengandung data sensitif.
            <a href="#flow-section" class="text-[#12544F] font-bold hover:underline">Lihat panduan</a>
          </p>

          <form @submit.prevent="handleFormSubmit" class="space-y-5">
            <div>
              <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul laporan <span class="text-red-600">*</span></label>
              <input v-model="form.title" type="text" required placeholder="Ringkas inti pengaduan Anda" class="w-full px-4 py-3.5 rounded-xl border border-slate-300 text-sm font-medium focus:border-[#12544F] focus:ring-2 focus:ring-[#12544F]/20 outline-none">
            </div>

            <div>
              <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Isi laporan <span class="text-red-600">*</span></label>
              <textarea v-model="form.description" required rows="4" placeholder="Ceritakan kronologi kejadian secara lengkap..." class="w-full px-4 py-3.5 rounded-xl border border-slate-300 text-sm font-medium focus:border-[#12544F] focus:ring-2 focus:ring-[#12544F]/20 outline-none resize-none"></textarea>
            </div>

            <div>
              <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Lokasi Kejadian <span class="text-red-600">*</span></label>
              <input v-model="form.location" type="text" required placeholder="Masukkan lokasi kejadian" class="w-full px-4 py-3.5 rounded-xl border border-slate-300 text-sm font-medium focus:border-[#12544F] focus:ring-2 focus:ring-[#12544F]/20 outline-none">
            </div>

            <div>
              <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kategori laporan <span class="text-red-600">*</span></label>
              <select v-model="form.category" required class="w-full px-4 py-3.5 rounded-xl border border-slate-300 text-sm font-medium focus:border-[#12544F] focus:ring-2 focus:ring-[#12544F]/20 outline-none bg-white">
                <option value="">Pilih kategori laporan</option>
                <option value="merokok">Merokok</option>
                <option value="tawuran">Tawuran</option>
                <option value="merusak_fasilitas">Merusak Fasilitas</option>
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
                  <span>{{ fileName || 'Upload lampiran (Maks 10MB)' }}</span>
                  <input type="file" ref="fileInput" @change="handleFileChange" class="hidden" accept="image/png,image/jpeg,image/jpg,video/mp4">
                </label>
              </div>

              <div class="flex items-center gap-6">
                <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
                  <input v-model="form.is_anonymous" type="checkbox" class="w-4 h-4 rounded text-[#12544F] focus:ring-[#12544F] border-slate-300">
                  Anonim
                </label>
              </div>
            </div>

            <button :disabled="isLoading" type="submit" class="w-full mt-6 py-4 bg-[#12544F] hover:bg-teal-800 text-white font-extrabold rounded-xl shadow-lg shadow-[#12544F]/25 active:scale-[0.99] transition-all flex items-center justify-center gap-2 text-sm sm:text-base disabled:opacity-50">
              <span v-if="isLoading">Mengirim...</span>
              <template v-else>
                Kirim pengaduan
                <svg class="w-4 h-4 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
              </template>
            </button>
          </form>
        </div>
      </section>

      <!-- ALUR LAPORAN -->
      <section id="flow-section" class="py-20 bg-white border-t border-slate-200/80">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="text-center mb-16">
            <span class="text-[11px] font-extrabold uppercase tracking-widest text-[#12544F]">ALUR YANG TRANSPARAN</span>
            <h2 class="text-3xl font-extrabold text-slate-900 mt-1 tracking-tight">Perjalanan laporan Anda</h2>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">Pantau setiap perkembangan laporan dari awal sampai selesai.</p>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-8 relative">
            <div class="hidden lg:block absolute top-6 left-12 right-12 h-0.5 bg-slate-200 z-0"></div>

            <div v-for="(step, index) in steps" :key="index" class="relative z-10 text-center flex flex-col items-center group">
              <div :class="[
                'w-12 h-12 rounded-full flex items-center justify-center font-bold mb-4 relative transition-transform group-hover:scale-110 shadow-lg',
                index === 0 ? 'bg-[#12544F] text-white' : 'bg-white border-2 border-slate-300 text-slate-600'
              ]">
                <span class="text-base font-black">{{ index + 1 }}</span>
              </div>
              <h3 class="font-extrabold text-slate-900 text-sm mb-1">{{ step.title }}</h3>
              <p class="text-xs text-slate-500 font-medium leading-relaxed max-w-[180px]">{{ step.desc }}</p>
            </div>
          </div>
        </div>
      </section>

      <!-- STATISTIK SECTION -->
      <section id="stats-section" class="bg-[#12544F] text-white py-16 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
          <div class="grid lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-5">
              <span class="text-[11px] font-extrabold uppercase tracking-widest text-white/80">DAMPAK NYATA</span>
              <h2 class="text-3xl sm:text-4xl font-black tracking-tight mt-1 mb-3">Dipercaya masyarakat sekolah</h2>
              <p class="text-xs sm:text-sm text-white/90 font-medium leading-relaxed">Satu kanal resmi untuk menghubungkan masyarakat sekolah dengan pengurus dan tim ketertiban.</p>
            </div>

            <div class="lg:col-span-7 grid sm:grid-cols-3 gap-4">
              <div class="bg-white/10 border border-white/20 rounded-2xl p-6 backdrop-blur-sm">
                <div class="text-3xl sm:text-4xl font-black tracking-tight mb-1">{{ stats.pending }}</div>
                <p class="text-xs text-white/80 font-semibold">Menunggu Proses</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- FAQ SECTION -->
      <section id="faq-section" class="py-20 bg-slate-50 border-t border-slate-200/80">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="text-center mb-12">
            <span class="text-[11px] font-extrabold uppercase tracking-widest text-[#12544F]">PERTANYAAN UMUM</span>
            <h2 class="text-3xl font-extrabold text-slate-900 mt-1">Sering Diajukan (FAQ)</h2>
          </div>

          <div class="space-y-4">
            <div v-for="(faq, index) in faqs" :key="index" @click="faq.open = !faq.open" class="bg-white rounded-2xl border border-slate-200 p-5 cursor-pointer">
              <div class="flex items-center justify-between font-bold text-slate-900 text-sm">
                <span>{{ faq.q }}</span>
                <span class="text-[#12544F] font-bold ml-2 text-lg">{{ faq.open ? '−' : '+' }}</span>
              </div>
              <p v-if="faq.open" class="text-xs text-slate-600 mt-3 font-medium leading-relaxed">
                {{ faq.a }}
              </p>
            </div>
          </div>
        </div>
      </section>
    </main>

    <!-- FOOTER -->
    <footer class="bg-slate-950 text-white pt-14 pb-8 border-t border-slate-800">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 font-medium gap-2">
          <p>&copy; 2026 ASVIELAPOR! Hak cipta dilindungi undang-undang.</p>
          <p class="text-slate-400 font-semibold">SMK As-Syafiiyah</p>
        </div>
      </div>
    </footer>

    <!-- AUTH MODAL -->
    <div v-if="showAuthModal" class="fixed inset-0 z-50 bg-slate-950/70 backdrop-blur-sm flex items-center justify-center p-4">
      <div class="bg-white rounded-3xl max-w-sm w-full p-6 sm:p-8 shadow-2xl relative">
        <button @click="showAuthModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 font-bold text-lg">✕</button>
        <div class="text-center mb-6">
          <div class="w-10 h-10 bg-[#12544F] text-white rounded-lg flex items-center justify-center font-black mx-auto mb-3">L!</div>
          <h3 class="text-lg font-extrabold text-slate-900">{{ authMode === 'login' ? 'Masuk ke ASVIELAPOR!' : 'Daftar Akun Baru' }}</h3>
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
import { ref, reactive, onMounted } from 'vue'
import Swal from 'sweetalert2'

const user = ref(null)
const isMobileMenuOpen = ref(false)
const showAuthModal = ref(false)
const authMode = ref('login')
const isLoading = ref(false)
const fileName = ref('')
const fileInput = ref(null)

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

const stats = reactive({
  pending: 0
})

const faqs = reactive([
  { q: 'Bagaimana cara melacak status pengaduan saya?', a: 'Status pengaduan dapat dicek secara berkala pada halaman profil atau list laporan.', open: false },
  { q: 'Apakah identitas saya terjamin kerahasiaannya?', a: 'Ya, Anda dapat mencentang opsi Anonim saat mengisi formulir.', open: false },
  { q: 'Berapa lama laporan ditindaklanjuti?', a: 'Proses verifikasi awal berlangsung maksimal 1x24 jam oleh pihak sekolah.', open: false }
])

const steps = [
  { title: 'Tulis Laporan', desc: 'Laporkan keluhan Anda dengan jelas dan lengkap.' },
  { title: 'Proses Verifikasi', desc: 'Laporan diverifikasi dan diteruskan kepada pengurus berwenang.' },
  { title: 'Tindak Lanjut', desc: 'Petugas terkait menindaklanjuti dan memberi respon fisik / berkas.' },
  { title: 'Beri Tanggapan', desc: 'Anda dapat menanggapi kembali jawaban atau hasil penanganan.' },
  { title: 'Selesai', desc: 'Laporan terus dipantau hingga dinyatakan selesai penuh.' }
]

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
      resetForm()
      await fetchStats()
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
  Swal.fire({
    title: 'Keluar Akun?',
    text: 'Anda harus masuk kembali untuk membuat laporan non-anonim.',
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#12544F',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, Keluar'
  }).then((result) => {
    if (result.isConfirmed) {
      localStorage.removeItem('auth_token')
      localStorage.removeItem('user_data')
      user.value = null

      Swal.fire({
        icon: 'success',
        title: 'Selesai',
        text: 'Anda telah berhasil keluar.',
        timer: 1500,
        showConfirmButton: false
      })
    }
  })
}

const checkStoredUser = () => {
  const storedUser = localStorage.getItem('user_data')
  if (storedUser) {
    try {
      user.value = JSON.parse(storedUser)
    } catch (e) {
      localStorage.removeItem('user_data')
    }
  }
}

const fetchStats = async () => {
  try {
    const token = localStorage.getItem('auth_token')
    const headers = { 'Accept': 'application/json' }
    if (token) headers['Authorization'] = `Bearer ${token}`

    const resPending = await fetch('/api/report/status/menunggu', { headers })
    const dataPending = await resPending.json()
    if (resPending.ok && dataPending.success) {
      stats.pending = dataPending.data.total
    }
  } catch (e) {
    console.error('Gagal mengambil statistik:', e)
  }
}

onMounted(() => {
  checkStoredUser()
  fetchStats()
})
</script>

<style scoped>
.hero-cross-pattern {
  background-image:
    linear-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255, 255, 255, 0.08) 1px, transparent 1px);
  background-size: 32px 32px;
}
</style>
