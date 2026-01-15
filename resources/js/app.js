import './bootstrap';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// 1. FontAwesome
import '@fortawesome/fontawesome-free/css/all.css';

// 2. SweetAlert2
import Swal from 'sweetalert2';
window.Swal = Swal; // Biar bisa dipanggil global via window.Swal