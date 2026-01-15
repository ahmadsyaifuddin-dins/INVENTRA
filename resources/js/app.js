import './bootstrap';
import Alpine from 'alpinejs';

// Import FontAwesome & SweetAlert (Sudah ada sebelumnya)
import '@fortawesome/fontawesome-free/css/all.css';
import Swal from 'sweetalert2';

window.Alpine = Alpine;
window.Swal = Swal;

Alpine.start();

// --- LOGIKA GLOBAL DELETE CONFIRMATION ---
document.addEventListener('DOMContentLoaded', () => {
    // 1. Tangkap semua body, pasang event listener (Event Delegation)
    document.body.addEventListener('submit', function (e) {
        
        // 2. Cek apakah yang disubmit adalah form dengan class 'delete-form'
        const form = e.target;
        if (form.classList.contains('delete-form')) {
            e.preventDefault(); // Stop submit asli

            // 3. Tampilkan SweetAlert
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48', // Warna Rose-600 (Sesuai tema Sidebar)
                cancelButtonColor: '#64748b',  // Warna Slate-500
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true // Tombol Batal di kiri, Hapus di kanan
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Lanjutkan submit jika user klik Ya
                }
            });
        }
    });
});