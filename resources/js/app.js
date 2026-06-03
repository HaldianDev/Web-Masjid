import Alpine from 'alpinejs';
import Swal from 'sweetalert2'; // Import SweetAlert2
import { injectSpeedInsights } from '@vercel/speed-insights';

window.Alpine = Alpine;
window.Swal = Swal; // Make SweetAlert2 globally available if needed

Alpine.start();

// Initialize Vercel Speed Insights
injectSpeedInsights();

// SweetAlert2 for delete confirmation
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('form.confirm-delete').forEach(form => {
        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the default form submission

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit(); // Submit the form if confirmed
                }
            });
        });
    });
});
