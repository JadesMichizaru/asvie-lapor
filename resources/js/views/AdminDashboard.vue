<template>
  <div class="h-screen w-full bg-slate-100 flex font-sans text-slate-800 overflow-hidden relative">

    <!-- Mobile Sidebar Backdrop Overlay -->
    <div
      v-if="isSidebarOpen"
      @click="isSidebarOpen = false"
      class="fixed inset-0 bg-slate-950/60 z-40 md:hidden backdrop-blur-sm transition-opacity"
    ></div>

    <!-- SIDEBAR -->
    <aside
      :class="[
        'w-64 bg-slate-900 text-white flex flex-col shrink-0 h-full fixed md:static z-50 transition-transform duration-300 ease-in-out border-r border-slate-800',
        isSidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'
      ]"
    >
      <div class="h-16 flex items-center justify-between px-6 bg-slate-950 font-black tracking-wider text-lg border-b border-slate-800 shrink-0">
        <div class="flex items-center gap-2.5">
          <div class="w-8 h-8 rounded-xl bg-[#12544F] text-white flex items-center justify-center font-bold text-sm shadow-md">
            A!
          </div>
          <span class="text-white">ASVIELAPOR!</span>
        </div>
        <button @click="isSidebarOpen = false" class="md:hidden text-slate-400 hover:text-white p-1">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <nav class="flex-1 p-4 space-y-1.5 text-xs font-bold overflow-y-auto">
        <button
          @click="switchTab('dashboard')"
          :class="['w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all', currentTab === 'dashboard' ? 'bg-[#12544F] text-white shadow-lg shadow-[#12544F]/30' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white']"
        >
          <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 00-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
          <span class="truncate">Dashboard Utama</span>
        </button>

        <button
          @click="switchTab('siswa')"
          :class="['w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all', currentTab === 'siswa' ? 'bg-[#12544F] text-white shadow-lg shadow-[#12544F]/30' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white']"
        >
          <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
          <span class="truncate">Manajemen Siswa</span>
        </button>

        <button
          @click="switchTab('staff')"
          :class="['w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all', currentTab === 'staff' ? 'bg-[#12544F] text-white shadow-lg shadow-[#12544F]/30' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white']"
        >
          <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
          <span class="truncate">Manajemen Guru & Staff</span>
        </button>

        <button
          @click="switchTab('warga')"
          :class="['w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all', currentTab === 'warga' ? 'bg-[#12544F] text-white shadow-lg shadow-[#12544F]/30' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white']"
        >
          <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
          <span class="truncate">Data Warga Terdaftar</span>
        </button>

        <button
          @click="switchTab('chatbot')"
          :class="['w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all', currentTab === 'chatbot' ? 'bg-[#12544F] text-white shadow-lg shadow-[#12544F]/30' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white']"
        >
          <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
          <span class="truncate">Kelola Chatbot AI</span>
        </button>
      </nav>
    </aside>

    <!-- MAIN WRAPPER -->
    <div class="flex-1 flex flex-col min-w-0 h-full w-full overflow-hidden">

      <!-- TOP NAVBAR -->
      <header class="h-16 bg-white border-b border-slate-200 px-4 md:px-8 flex items-center justify-between shrink-0 z-30">
        <div class="flex items-center gap-3">
          <button
            @click="isSidebarOpen = true"
            class="md:hidden p-2 rounded-xl text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
          </button>
          <h1 class="text-xs md:text-sm font-extrabold uppercase tracking-wider text-slate-800 truncate">
            {{ currentTab === 'dashboard' ? 'Panel Pengawasan Laporan' : currentTab === 'siswa' ? 'Manajemen Data Siswa' : currentTab === 'staff' ? 'Manajemen Guru & Staff' : currentTab === 'warga' ? 'Daftar Akun Warga' : 'Basis Data Respon Chatbot' }}
          </h1>
        </div>

        <div class="flex items-center gap-3 shrink-0">
          <span class="text-[11px] md:text-xs font-bold text-[#12544F] px-3 py-1.5 bg-teal-50 border border-teal-200 rounded-xl">
            Admin Panel
          </span>
        </div>
      </header>

      <!-- SCROLLABLE CONTENT BODY -->
      <main class="flex-1 overflow-y-auto p-4 md:p-8 space-y-6">

        <!-- TAB 1: DASHBOARD UTAMA -->
        <div v-if="currentTab === 'dashboard'" class="space-y-6">
          <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-5">
            <div class="p-4 md:p-5 bg-white rounded-2xl border border-slate-200 shadow-sm">
              <span class="text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-wider block">Total Laporan</span>
              <span class="text-xl md:text-3xl font-black text-slate-800 mt-1 block">{{ stats.total_reports || 0 }}</span>
            </div>
            <div class="p-4 md:p-5 bg-white rounded-2xl border border-slate-200 shadow-sm">
              <span class="text-[10px] md:text-xs font-bold text-amber-600 uppercase tracking-wider block">Menunggu</span>
              <span class="text-xl md:text-3xl font-black text-amber-600 mt-1 block">{{ stats.pending_reports || 0 }}</span>
            </div>
            <div class="p-4 md:p-5 bg-white rounded-2xl border border-slate-200 shadow-sm">
              <span class="text-[10px] md:text-xs font-bold text-blue-600 uppercase tracking-wider block">Diproses</span>
              <span class="text-xl md:text-3xl font-black text-blue-600 mt-1 block">{{ stats.process_reports || 0 }}</span>
            </div>
            <div class="p-4 md:p-5 bg-white rounded-2xl border border-slate-200 shadow-sm">
              <span class="text-[10px] md:text-xs font-bold text-emerald-600 uppercase tracking-wider block">Selesai</span>
              <span class="text-xl md:text-3xl font-black text-emerald-600 mt-1 block">{{ stats.completed_reports || 0 }}</span>
            </div>
          </div>

          <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 md:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 pb-3 border-b border-slate-100">
              <div>
                <h2 class="text-sm md:text-base font-extrabold text-slate-900">Index Laporan Terbaru</h2>
                <p class="text-[11px] text-slate-400 font-medium">Cari laporan berdasarkan judul pengaduan, nama pelapor, NIK, atau NIS.</p>
              </div>

              <div class="flex items-center gap-2">
                <!-- Input Searching -->
                <div class="relative flex-1 sm:w-72">
                  <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                  </svg>
                  <input
                    v-model="searchQuery"
                    type="text"
                    placeholder="Cari nama laporan / NIK / NIS..."
                    class="w-full pl-9 pr-3 py-1.5 bg-slate-50 border border-slate-300 rounded-lg text-xs font-medium outline-none focus:border-[#12544F] focus:bg-white transition-all"
                  />
                </div>

                <button @click="loadAllData" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-bold transition-colors shrink-0">
                  Refresh
                </button>
              </div>
            </div>

            <div class="overflow-x-auto rounded-xl border border-slate-100">
              <table class="w-full text-left border-collapse text-xs min-w-[780px]">
                <thead>
                  <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 font-extrabold uppercase tracking-wider">
                    <th class="py-3 px-4">Judul Pengaduan & Pelapor</th>
                    <th class="py-3 px-4">Lampiran Foto</th>
                    <th class="py-3 px-4">Kategori</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4 text-right">Ubah Status</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                  <tr v-if="filteredReports.length === 0">
                    <td colspan="5" class="py-6 text-center text-slate-400">
                      {{ searchQuery ? 'Tidak ada laporan yang cocok dengan pencarian.' : 'Belum ada laporan masuk.' }}
                    </td>
                  </tr>
                  <tr v-for="r in filteredReports" :key="r.id" class="hover:bg-slate-50/50">
                    <td class="py-3.5 px-4">
                      <p class="font-bold text-slate-900">{{ r.title }}</p>
                      <div class="flex flex-wrap items-center gap-1.5 text-[10px] text-slate-400 mt-0.5">
                        <span class="font-mono">#{{ r.id.substring(0,8) }}</span>
                        <span>• {{ r.location }}</span>
                        <span v-if="!r.is_anonymous && r.user" class="text-slate-600 font-semibold">
                          • Pelapor: {{ r.user.name }}
                          <span v-if="r.user.nik" class="font-mono text-teal-700">(NIK: {{ r.user.nik }})</span>
                          <span v-else-if="r.user.nis" class="font-mono text-indigo-700">(NIS: {{ r.user.nis }})</span>
                        </span>
                        <span v-else-if="r.is_anonymous" class="italic text-slate-400">• Anonim</span>
                      </div>
                    </td>

                    <!-- Kolom Lampiran Foto -->
                    <td class="py-3.5 px-4">
                      <template v-if="getEvidenceUrl(r)">
                        <a
                          v-if="!isVideoFile(getEvidenceUrl(r))"
                          :href="getEvidenceUrl(r)"
                          target="_blank"
                          title="Klik untuk memperbesar foto"
                          class="inline-block group relative"
                        >
                          <img
                            :src="getEvidenceUrl(r)"
                            alt="Lampiran Laporan"
                            class="w-12 h-12 object-cover rounded-lg border border-slate-200 shadow-xs group-hover:scale-105 transition-transform"
                          />
                        </a>
                        <a
                          v-else
                          :href="getEvidenceUrl(r)"
                          target="_blank"
                          class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[11px]"
                        >
                          🎥 Video
                        </a>
                      </template>
                      <span v-else class="text-[11px] text-slate-400 italic">Tidak ada</span>
                    </td>

                    <td class="py-3.5 px-4 capitalize">{{ r.category }}</td>
                    <td class="py-3.5 px-4">
                      <span :class="['px-2.5 py-1 rounded-md text-[10px] font-extrabold capitalize', getStatusBadge(r.status)]">
                        {{ r.status }}
                      </span>
                    </td>
                    <td class="py-3.5 px-4 text-right">
                      <select
                        :value="r.status"
                        @change="updateReportStatus(r.title, $event.target.value)"
                        class="px-2.5 py-1 rounded-lg border border-slate-300 text-xs font-bold bg-white focus:border-[#12544F] outline-none"
                      >
                        <option value="menunggu">Menunggu</option>
                        <option value="diproses">Diproses</option>
                        <option value="selesai">Selesai</option>
                        <option value="ditolak">Ditolak</option>
                      </select>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- TAB 2: MANAJEMEN SISWA -->
        <div v-if="currentTab === 'siswa'" class="space-y-4">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between bg-white p-4 md:p-6 rounded-2xl border border-slate-200 gap-3">
            <div>
              <h2 class="text-sm md:text-base font-extrabold text-slate-900">Daftar Siswa Terdaftar</h2>
              <p class="text-xs text-slate-500 font-medium">Email & Password dibuat otomatis dari nama & NIS.</p>
            </div>
            <button @click="openAddModal('siswa')" class="px-4 py-2.5 bg-[#12544F] hover:bg-teal-800 text-white rounded-xl text-xs font-bold shadow-md transition-all">
              + Tambah Siswa
            </button>
          </div>

          <div class="bg-white rounded-2xl border border-slate-200 p-4 overflow-hidden">
            <div class="overflow-x-auto rounded-xl border border-slate-100">
              <table class="w-full text-left text-xs min-w-[600px]">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-400 font-extrabold uppercase">
                  <tr>
                    <th class="py-3 px-4">Nama Siswa</th>
                    <th class="py-3 px-4">NIS</th>
                    <th class="py-3 px-4">Email</th>
                    <th class="py-3 px-4 text-right">Aksi</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                  <tr v-if="siswaList.length === 0">
                    <td colspan="4" class="py-6 text-center text-slate-400">Belum ada data siswa.</td>
                  </tr>
                  <tr v-for="s in siswaList" :key="s.id">
                    <td class="py-3.5 px-4 font-bold text-slate-900">{{ s.name }}</td>
                    <td class="py-3.5 px-4 font-mono text-slate-600">{{ s.nis || '-' }}</td>
                    <td class="py-3.5 px-4 text-slate-500 font-mono">{{ s.email }}</td>
                    <td class="py-3.5 px-4 text-right">
                      <button @click="deleteUser(s.name)" class="text-rose-600 font-bold hover:underline">Hapus</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- TAB 3: MANAJEMEN GURU & STAFF -->
        <div v-if="currentTab === 'staff'" class="space-y-4">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between bg-white p-4 md:p-6 rounded-2xl border border-slate-200 gap-3">
            <div>
              <h2 class="text-sm md:text-base font-extrabold text-slate-900">Daftar Guru & Staff</h2>
              <p class="text-xs text-slate-500 font-medium">Kelola akun pengurus sistem dan pengaduan.</p>
            </div>
            <button @click="openAddModal('staff')" class="px-4 py-2.5 bg-[#12544F] hover:bg-teal-800 text-white rounded-xl text-xs font-bold shadow-md transition-all">
              + Tambah Pengurus
            </button>
          </div>

          <div class="bg-white rounded-2xl border border-slate-200 p-4 overflow-hidden">
            <div class="overflow-x-auto rounded-xl border border-slate-100">
              <table class="w-full text-left text-xs min-w-[600px]">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-400 font-extrabold uppercase">
                  <tr>
                    <th class="py-3 px-4">Nama Pengurus</th>
                    <th class="py-3 px-4">Email</th>
                    <th class="py-3 px-4">Role</th>
                    <th class="py-3 px-4 text-right">Aksi</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                  <tr v-if="guruStaffList.length === 0">
                    <td colspan="4" class="py-6 text-center text-slate-400">Belum ada pengurus.</td>
                  </tr>
                  <tr v-for="g in guruStaffList" :key="g.id">
                    <td class="py-3.5 px-4 font-bold text-slate-900">{{ g.name }}</td>
                    <td class="py-3.5 px-4 text-slate-500 font-mono">{{ g.email }}</td>
                    <td class="py-3.5 px-4 uppercase font-bold text-[#12544F]">{{ g.roles }}</td>
                    <td class="py-3.5 px-4 text-right">
                      <button @click="deleteUser(g.name)" class="text-rose-600 font-bold hover:underline">Hapus</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- TAB 4: DATA WARGA -->
        <div v-if="currentTab === 'warga'" class="bg-white rounded-2xl border border-slate-200 p-4 md:p-6">
          <h2 class="text-sm md:text-base font-extrabold text-slate-900 mb-4">Daftar Warga Terdaftar</h2>
          <div class="overflow-x-auto rounded-xl border border-slate-100">
            <table class="w-full text-left text-xs min-w-[600px]">
              <thead class="bg-slate-50 border-b border-slate-200 text-slate-400 font-extrabold uppercase">
                <tr>
                  <th class="py-3 px-4">Nama Warga</th>
                  <th class="py-3 px-4">NIK</th>
                  <th class="py-3 px-4">Email</th>
                  <th class="py-3 px-4">Tanggal Bergabung</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100 font-medium">
                <tr v-if="wargaList.length === 0">
                  <td colspan="4" class="py-6 text-center text-slate-400">Belum ada akun warga.</td>
                </tr>
                <tr v-for="w in wargaList" :key="w.id">
                  <td class="py-3.5 px-4 font-bold text-slate-900">{{ w.name }}</td>
                  <td class="py-3.5 px-4 font-mono text-slate-600">{{ w.nik || '-' }}</td>
                  <td class="py-3.5 px-4 text-slate-500 font-mono">{{ w.email }}</td>
                  <td class="py-3.5 px-4 text-slate-400">{{ new Date(w.created_at).toLocaleDateString('id-ID') }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- TAB 5: KELOLA CHATBOT AI -->
        <div v-if="currentTab === 'chatbot'" class="space-y-4">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between bg-white p-4 md:p-6 rounded-2xl border border-slate-200 gap-3">
            <div>
              <h2 class="text-sm md:text-base font-extrabold text-slate-900">Kelola Keyword & Respon Chatbot AI</h2>
              <p class="text-xs text-slate-500 font-medium">Atur kata kunci otomatis yang akan dijawab Asvie Bot.</p>
            </div>
            <button @click="openChatbotModal" class="px-4 py-2.5 bg-[#12544F] hover:bg-teal-800 text-white rounded-xl text-xs font-bold shadow-md transition-all">
              + Tambah Keyword Bot
            </button>
          </div>

          <div class="bg-white rounded-2xl border border-slate-200 p-4 overflow-hidden">
            <div class="overflow-x-auto rounded-xl border border-slate-100">
              <table class="w-full text-left text-xs min-w-[650px]">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-400 font-extrabold uppercase">
                  <tr>
                    <th class="py-3 px-4">Keyword (Pemicu)</th>
                    <th class="py-3 px-4">Respon Bot</th>
                    <th class="py-3 px-4">Pembuat</th>
                    <th class="py-3 px-4 text-right">Aksi</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                  <tr v-if="chatbotList.length === 0">
                    <td colspan="4" class="py-6 text-center text-slate-400">Belum ada respon chatbot.</td>
                  </tr>
                  <tr v-for="c in chatbotList" :key="c.id">
                    <td class="py-3.5 px-4 font-mono font-bold text-[#12544F]">{{ c.keyword }}</td>
                    <td class="py-3.5 px-4 text-slate-700 max-w-xs truncate">{{ c.response }}</td>
                    <td class="py-3.5 px-4 text-slate-500">{{ c.creator?.name || 'Admin' }}</td>
                    <td class="py-3.5 px-4 text-right">
                      <button @click="deleteChatbotKeyword(c.id)" class="text-rose-600 font-bold hover:underline">Hapus</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </main>
    </div>

    <!-- MODAL TAMBAH USER -->
    <div v-if="showAddModal" class="fixed inset-0 z-[60] bg-slate-950/70 backdrop-blur-sm flex items-center justify-center p-4">
      <div class="bg-white rounded-3xl max-w-sm w-full p-6 shadow-2xl relative animate-scale-up">
        <button @click="showAddModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 font-bold text-lg">✕</button>
        <h3 class="text-base font-extrabold text-slate-900 mb-4">
          {{ modalTarget === 'siswa' ? 'Tambah Data Siswa Baru' : 'Tambah Guru / Staff' }}
        </h3>

        <form @submit.prevent="submitAddUser" class="space-y-4 text-xs">
          <div>
            <label class="block font-bold text-slate-700 uppercase mb-1">Nama Lengkap</label>
            <input v-model="userForm.name" type="text" required placeholder="Masukkan nama..." class="w-full px-4 py-3 rounded-xl border border-slate-300 font-medium outline-none focus:border-[#12544F]">
          </div>

          <div v-if="modalTarget === 'siswa'">
            <label class="block font-bold text-slate-700 uppercase mb-1">NIS Siswa</label>
            <input v-model="userForm.nis" type="text" required placeholder="Masukkan NIS siswa" class="w-full px-4 py-3 rounded-xl border border-slate-300 font-medium outline-none focus:border-[#12544F]">
          </div>

          <div v-if="modalTarget === 'staff'">
            <label class="block font-bold text-slate-700 uppercase mb-1">Role / Peran</label>
            <select v-model="userForm.roles" class="w-full px-4 py-3 rounded-xl border border-slate-300 font-medium bg-white outline-none focus:border-[#12544F]">
              <option value="guru">Guru</option>
              <option value="staff">Staff TU</option>
              <option value="admin">Admin</option>
            </select>
          </div>

          <div class="p-3 bg-teal-50 rounded-xl border border-teal-100 text-teal-800 text-[11px] font-medium leading-relaxed">
            Email & Password login akan dibuat otomatis oleh sistem dan ditampilkan setelah disimpan.
          </div>

          <button type="submit" class="w-full py-3.5 bg-[#12544F] hover:bg-teal-800 text-white font-extrabold text-xs rounded-xl shadow-md transition-all">
            Simpan Akun
          </button>
        </form>
      </div>
    </div>

    <!-- MODAL TAMBAH KEYWORD CHATBOT -->
    <div v-if="showChatbotModal" class="fixed inset-0 z-[60] bg-slate-950/70 backdrop-blur-sm flex items-center justify-center p-4">
      <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl relative animate-scale-up">
        <button @click="showChatbotModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 font-bold text-lg">✕</button>
        <h3 class="text-base font-extrabold text-slate-900 mb-4">Tambah Keyword Respon Chatbot</h3>

        <form @submit.prevent="submitChatbot" class="space-y-4 text-xs">
          <div>
            <label class="block font-bold text-slate-700 uppercase mb-1">Keyword (Kata Kunci Pemicu)</label>
            <input v-model="chatbotForm.keyword" type="text" required placeholder="Contoh: pendaftaran, jam masuk, kepala sekolah" class="w-full px-4 py-3 rounded-xl border border-slate-300 font-medium outline-none focus:border-[#12544F]">
          </div>

          <div>
            <label class="block font-bold text-slate-700 uppercase mb-1">Jawaban / Respon Bot</label>
            <textarea v-model="chatbotForm.response" rows="4" required placeholder="Tuliskan jawaban yang akan diberikan oleh Asvie Bot..." class="w-full px-4 py-3 rounded-xl border border-slate-300 font-medium outline-none focus:border-[#12544F] resize-none"></textarea>
          </div>

          <button type="submit" class="w-full py-3.5 bg-[#12544F] hover:bg-teal-800 text-white font-extrabold text-xs rounded-xl shadow-md transition-all">
            Simpan Keyword
          </button>
        </form>
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue'
import Swal from 'sweetalert2'

const currentTab = ref('dashboard')
const isSidebarOpen = ref(false)
const showAddModal = ref(false)
const showChatbotModal = ref(false)
const modalTarget = ref('siswa')
const searchQuery = ref('')

const stats = reactive({})
const reports = ref([])
const allUsers = ref([])
const chatbotList = ref([])

const userForm = reactive({ name: '', roles: 'siswa', nis: '' })
const chatbotForm = reactive({ keyword: '', response: '' })

// Filter pencarian laporan (Nama Laporan / Nama Pelapor / NIK / NIS)
const filteredReports = computed(() => {
  const q = searchQuery.value.trim().toLowerCase()
  if (!q) return reports.value

  return reports.value.filter(r => {
    const title = (r.title || '').toLowerCase()
    const userName = (r.user?.name || '').toLowerCase()
    const nik = (r.user?.nik || '').toLowerCase()
    const nis = (r.user?.nis || '').toLowerCase()

    return title.includes(q) || userName.includes(q) || nik.includes(q) || nis.includes(q)
  })
})

// Helper URL Lampiran Foto / Video
const getEvidenceUrl = (report) => {
  const path = report.evidence_image || report.evidence_file || report.image
  if (!path) return null
  if (path.startsWith('http://') || path.startsWith('https://')) return path
  return `/storage/${path.replace(/^\/?storage\//, '')}`
}

const isVideoFile = (url) => {
  return /\.(mp4|webm|ogg)$/i.test(url)
}

// Filter dynamic user roles
const siswaList = computed(() => allUsers.value.filter(u => u.roles === 'siswa'))
const guruStaffList = computed(() => allUsers.value.filter(u => ['admin', 'guru', 'staff'].includes(u.roles)))
const wargaList = computed(() => allUsers.value.filter(u => !u.roles || u.roles === 'warga' || u.roles === 'user'))

const switchTab = (tab) => {
  currentTab.value = tab
  isSidebarOpen.value = false
}

const getAuthHeaders = () => ({
  'Accept': 'application/json',
  'Content-Type': 'application/json',
  'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
})

const openAddModal = (target) => {
  modalTarget.value = target
  userForm.name = ''
  userForm.nis = ''
  userForm.roles = target === 'siswa' ? 'siswa' : 'guru'
  showAddModal.value = true
}

const openChatbotModal = () => {
  chatbotForm.keyword = ''
  chatbotForm.response = ''
  showChatbotModal.value = true
}

const loadAllData = async () => {
  try {
    const headers = getAuthHeaders()
    const [resStats, resReports, resUsers, resChatbot] = await Promise.all([
      fetch('/api/admin/stats', { headers }),
      fetch('/api/report', { headers }),
      fetch('/api/user', { headers }),
      fetch('/api/admin/chatbot', { headers })
    ])

    if (resStats.ok) {
      const dataStats = await resStats.json()
      if (dataStats.success) Object.assign(stats, dataStats.data)
    }
    if (resReports.ok) {
      const dataReports = await resReports.json()
      if (dataReports.success) reports.value = dataReports.data
    }
    if (resUsers.ok) {
      const dataUsers = await resUsers.json()
      if (dataUsers.success) allUsers.value = dataUsers.data
    }
    if (resChatbot.ok) {
      const dataChatbot = await resChatbot.json()
      if (dataChatbot.success) chatbotList.value = dataChatbot.data
    }
  } catch (e) {
    console.error('Gagal mengambil data:', e)
  }
}

const updateReportStatus = async (title, newStatus) => {
  try {
    const res = await fetch(`/api/report/${encodeURIComponent(title)}`, {
      method: 'PUT',
      headers: getAuthHeaders(),
      body: JSON.stringify({ status: newStatus })
    })
    if (res.ok) {
      Swal.fire({ icon: 'success', title: 'Status Diperbarui', timer: 1000, showConfirmButton: false })
      loadAllData()
    }
  } catch (e) {
    console.error(e)
  }
}

const submitAddUser = async () => {
  try {
    const res = await fetch('/api/admin/staff', {
      method: 'POST',
      headers: getAuthHeaders(),
      body: JSON.stringify(userForm)
    })
    const data = await res.json()

    if (res.ok && data.success) {
      Swal.fire({
        icon: 'success',
        title: 'Akun Berhasil Dibuat!',
        html: `
          <div class="text-left text-xs space-y-2 mt-3 bg-slate-50 p-4 rounded-xl border border-slate-200">
            <p><b>Nama:</b> ${data.data.user.name}</p>
            ${data.data.user.nis ? `<p><b>NIS:</b> ${data.data.user.nis}</p>` : ''}
            <p><b>Role:</b> <span class="uppercase font-bold text-[#12544F]">${data.data.user.roles}</span></p>
            <hr class="border-slate-200 my-1">
            <p><b>Email Sistem:</b> <code class="bg-white px-1.5 py-0.5 rounded border border-slate-200 text-teal-800 font-bold">${data.data.generated_email}</code></p>
            <p><b>Password Login:</b> <code class="bg-white px-1.5 py-0.5 rounded border border-slate-200 text-rose-700 font-bold">${data.data.default_password}</code></p>
          </div>
          <p class="text-[11px] text-slate-500 mt-3">Silakan simpan informasi login di atas untuk diberikan kepada pengguna.</p>
        `,
        confirmButtonColor: '#12544F'
      })

      showAddModal.value = false
      userForm.name = ''
      userForm.nis = ''
      loadAllData()
    } else {
      Swal.fire({ icon: 'error', title: 'Gagal', text: data.message || 'Gagal menambahkan akun.' })
    }
  } catch (e) {
    Swal.fire({ icon: 'error', title: 'Kesalahan Server' })
  }
}

const submitChatbot = async () => {
  try {
    const res = await fetch('/api/admin/chatbot', {
      method: 'POST',
      headers: getAuthHeaders(),
      body: JSON.stringify(chatbotForm)
    })
    const data = await res.json()
    if (res.ok && data.success) {
      Swal.fire({ icon: 'success', title: 'Keyword Chatbot Ditambahkan!', timer: 1500, showConfirmButton: false })
      showChatbotModal.value = false
      loadAllData()
    } else {
      Swal.fire({ icon: 'error', title: 'Gagal', text: data.message })
    }
  } catch (e) {
    Swal.fire({ icon: 'error', title: 'Kesalahan Server' })
  }
}

const deleteChatbotKeyword = async (id) => {
  const confirm = await Swal.fire({
    title: 'Hapus keyword ini?',
    text: 'Chatbot tidak akan dapat menjawab kata kunci ini lagi.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#e11d48',
    confirmButtonText: 'Ya, Hapus'
  })

  if (confirm.isConfirmed) {
    const res = await fetch(`/api/admin/chatbot/${id}`, {
      method: 'DELETE',
      headers: getAuthHeaders()
    })
    if (res.ok) {
      Swal.fire({ icon: 'success', title: 'Keyword Terhapus', timer: 1000, showConfirmButton: false })
      loadAllData()
    }
  }
}

const deleteUser = async (name) => {
  const confirm = await Swal.fire({
    title: 'Hapus pengguna ini?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#e11d48',
    confirmButtonText: 'Hapus'
  })

  if (confirm.isConfirmed) {
    const res = await fetch(`/api/admin/staff/${encodeURIComponent(name)}`, {
      method: 'DELETE',
      headers: getAuthHeaders()
    })
    if (res.ok) {
      Swal.fire({ icon: 'success', title: 'Akun Terhapus', timer: 1000, showConfirmButton: false })
      loadAllData()
    }
  }
}

const getStatusBadge = (status) => {
  switch (status) {
    case 'menunggu': return 'bg-amber-100 text-amber-800'
    case 'diproses': return 'bg-blue-100 text-blue-800'
    case 'selesai': return 'bg-emerald-100 text-emerald-800'
    case 'ditolak': return 'bg-rose-100 text-rose-800'
    default: return 'bg-slate-100 text-slate-800'
  }
}

onMounted(() => {
  loadAllData()
})
</script>
