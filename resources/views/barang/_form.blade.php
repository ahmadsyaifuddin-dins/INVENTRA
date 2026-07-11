<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        {{-- KOLOM KODE BARANG DENGAN TOMBOL REFRESH & INFO FORMAT --}}
        <div class="mb-5">
            <label class="block text-sm font-medium text-gray-700 mb-1">Kode Barang (Otomatis) <span
                    class="text-red-500">*</span></label>
            <div class="flex gap-2">
                <input type="text" name="kode_barang" id="kode_barang"
                    value="{{ old('kode_barang', $barang->kode_barang) }}" required readonly
                    class="w-full rounded-md border-gray-300 bg-gray-100 cursor-not-allowed font-mono text-indigo-700 font-bold text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                    placeholder="Pilih Kategori & Sub Kategori">

                {{-- Tombol Generate Ulang (Hanya muncul jika mode Edit data lama) --}}
                @if ($barang->exists)
                    <button type="button" onclick="forceGenerateKode()"
                        class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-2 rounded-md text-sm font-bold shadow transition flex-shrink-0"
                        title="Generate ulang ke format baru">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                @endif
            </div>

            {{-- Info Tambahan (Tombol Refresh) --}}
            @if ($barang->exists)
                <p class="text-[11px] text-amber-600 mt-1 mb-2 font-medium">* Klik ikon <i class="fas fa-sync-alt"></i>
                    untuk mereset kode lama menjadi format baru setelah memilih Sub Kategori.</p>
            @endif

            {{-- KOTAK PENJELASAN FORMAT KODE --}}
            <div
                class="mt-2 p-2.5 bg-indigo-50 rounded-lg border border-indigo-100 text-[11px] text-indigo-800 leading-relaxed">
                <span class="font-bold text-indigo-900 block mb-1"><i class="fas fa-info-circle mr-1"></i> Penjelasan
                    Format Kode:</span>
                Format: <span
                    class="font-mono font-bold bg-white px-1 py-0.5 rounded border">[KATEGORI].[SUB_KATEGORI].[TAHUN].[URUTAN].00</span><br>
                Contoh: <span class="font-mono font-bold bg-white px-1 py-0.5 rounded border">ELK.01.2026.01.00</span>
                berarti:
                <ul class="list-disc pl-4 mt-1 space-y-0.5 text-indigo-700/80">
                    <li><strong class="text-indigo-900">ELK</strong> = Kategori Elektronik</li>
                    <li><strong class="text-indigo-900">01</strong> = Kode Sub Kategori (Misal: Laptop)</li>
                    <li><strong class="text-indigo-900">2026</strong> = Tahun Perolehan</li>
                    <li><strong class="text-indigo-900">01</strong> = Nomor urut barang pada tahun tsb</li>
                    {{-- <li><strong class="text-indigo-900">00</strong> = Status Default (Belum didistribusikan / Di Gudang) --}}
                    </li>
                </ul>
            </div>
        </div>

        <x-forms.input name="nama_barang" label="Nama Barang" :value="$barang->nama_barang" placeholder="Cth: Laptop ASUS ROG"
            required="true" />

        <div class="grid grid-cols-2 gap-4">
            <x-forms.dropdown name="kategori_id" label="Kategori Induk" :options="$kategoris" :selected="$barang->kategori_id"
                placeholder="-- Pilih --" required="true" id="kategori_id" />

            {{-- Dropdown Sub Kategori Baru (AJAX) --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Sub Kategori <span
                        class="text-red-500">*</span></label>
                <select name="sub_kategori_id" id="sub_kategori_id" required
                    class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm shadow-sm">
                    <option value="">-- Pilih Kategori Dulu --</option>
                    {{-- Opsi ini akan diisi otomatis oleh JavaScript fetch --}}
                </select>
            </div>
        </div>

        <x-forms.input name="merek" label="Merek / Brand" :value="$barang->merek" placeholder="Cth: ASUS, Samsung" />
    </div>

    <div class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <x-forms.input name="tahun_perolehan" type="number" label="Tahun Perolehan" :value="$barang->tahun_perolehan ?? date('Y')"
                placeholder="YYYY" required="true" id="tahun_perolehan" />

            <x-forms.input name="satuan" label="Satuan" :value="$barang->satuan" placeholder="Unit/Buah/Set"
                required="true" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <x-forms.input type="date" name="tgl_penyusutan_habis" label="Tgl Penyusutan Habis" :value="$barang->tgl_penyusutan_habis" />
            <x-forms.input type="date" name="tgl_servis_berikutnya" label="Tgl Servis Berikutnya"
                :value="$barang->tgl_servis_berikutnya" />
        </div>
        <p class="text-xs text-gray-500 -mt-2 mb-2 italic">* Kosongkan jika aset tidak memiliki masa penyusutan atau
            tidak butuh servis berkala.</p>

        <x-forms.image-upload name="foto" label="Foto Barang (Opsional)" :value="$barang->foto" />
    </div>
</div>

<div class="flex items-center justify-end mt-6 border-t border-gray-100 pt-4">
    <a href="{{ route('barang.index') }}" class="text-gray-500 hover:text-gray-700 mr-4 text-sm font-medium">Batal</a>
    <button type="submit"
        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-200">
        {{ $barang->exists ? 'Update Data Barang' : 'Simpan Data Barang' }}
    </button>
</div>

{{-- ========================================================= --}}
{{-- SCRIPT AJAX UNTUK SUB KATEGORI & KODE BARANG OTOMATIS --}}
{{-- ========================================================= --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const kategoriSelect = document.getElementById('kategori_id');
        const subKategoriSelect = document.getElementById('sub_kategori_id');
        const tahunInput = document.getElementById('tahun_perolehan');
        const kodeInput = document.getElementById('kode_barang');

        // URL dari rute Laravel
        const urlGetSub = "{{ route('ajax.subKategori') }}";
        const urlGetKode = "{{ route('ajax.generateKodeBarang') }}";

        // Fungsi Global untuk Tombol Refresh Kode (Mode Edit)
        window.forceGenerateKode = function() {
            generateKode(true);
        };

        // Fungsi Load Data Sub Kategori
        function loadSubKategori(kategoriId, selectedSubId = null) {
            if (!kategoriId) {
                subKategoriSelect.innerHTML = '<option value="">-- Pilih Kategori Dulu --</option>';
                kodeInput.value = '';
                return;
            }

            fetch(`${urlGetSub}?kategori_id=${kategoriId}`)
                .then(response => response.json())
                .then(data => {
                    let options = '<option value="">-- Pilih Sub Kategori --</option>';
                    data.forEach(sub => {
                        const isSelected = selectedSubId == sub.id ? 'selected' : '';
                        options +=
                            `<option value="${sub.id}" ${isSelected}>${sub.nama_sub} (${sub.kode_sub})</option>`;
                    });
                    subKategoriSelect.innerHTML = options;

                    // Jika ini load awal dari mode Edit, biarkan. 
                    // Jika ini bukan dari saved data (trigger dari user change), rakit kode.
                    if (selectedSubId && "{{ $barang->exists }}" !== "1") {
                        generateKode();
                    }
                })
                .catch(error => console.error('Error fetching sub kategori:', error));
        }

        // Fungsi Rakit Kode Barang via Backend
        function generateKode(isManual = false) {
            const kategoriId = kategoriSelect.value;
            const subKategoriId = subKategoriSelect.value;
            const tahun = tahunInput.value;

            // PENCEGAHAN: Jika mode EDIT dan BUKAN diklik manual dari tombol, HENTIKAN PROSES!
            if ("{{ $barang->exists }}" == "1" && !isManual) return;

            if (kategoriId && subKategoriId && tahun) {
                kodeInput.value = "Menghitung...";
                fetch(`${urlGetKode}?kategori_id=${kategoriId}&sub_kategori_id=${subKategoriId}&tahun=${tahun}`)
                    .then(response => response.json())
                    .then(data => {
                        kodeInput.value = data.kode;
                    })
                    .catch(error => {
                        console.error('Error fetching kode barang:', error);
                        kodeInput.value = "Gagal Generate Kode";
                    });
            } else {
                if (isManual) alert(
                    "Silakan pilih Kategori, Sub Kategori, dan Tahun Perolehan terlebih dahulu untuk membuat kode baru!"
                );
                if (!isManual) kodeInput.value = '';
            }
        }

        // Event Listener: Jika Kategori Induk diganti
        kategoriSelect.addEventListener('change', function() {
            loadSubKategori(this.value);
            // Kosongkan kode (kecuali mode Edit)
            if ("{{ $barang->exists }}" !== "1") {
                kodeInput.value = '';
            }
        });

        // Event Listener: Jika Sub Kategori diganti
        subKategoriSelect.addEventListener('change', function() {
            generateKode(false);
        });

        // Event Listener: Jika Tahun diketik/diubah
        tahunInput.addEventListener('input', function() {
            generateKode(false);
        });

        // ==========================================
        // INISIALISASI SAAT HALAMAN PERTAMA KALI DIBUKA
        // ==========================================
        const savedKategoriId = "{{ old('kategori_id', $barang->kategori_id) }}";
        const savedSubKategoriId = "{{ old('sub_kategori_id', $barang->sub_kategori_id) }}";

        if (savedKategoriId) {
            loadSubKategori(savedKategoriId, savedSubKategoriId);
        }
    });
</script>
