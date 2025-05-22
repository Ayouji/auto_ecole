<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: '{{ session('success') }}',
                timer: 5000,
                timerProgressBar: true,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: '{{ session('error') }}',
                timer: 5000,
                timerProgressBar: true,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
            });
        @endif
    });
</script>
