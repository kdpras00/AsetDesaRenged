import './bootstrap';
import 'flowbite';
import Swal from 'sweetalert2';

// Make Swal globally available
window.Swal = Swal;

// Global Toast Configuration
window.Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});
