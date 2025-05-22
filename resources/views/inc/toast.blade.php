@if (session('success') || session('error'  || session('warning')))
@if (session('success'))
<div class="toastbox">
    <div class="toast">
        <i class="bi bi-check2-circle" style="color: green;"></i>
        {{ session('success') }}
    </div>
</div>
@endif
@if (session('error'))
<div class="toastbox">
    <div class="toast">
        <i class="bi bi-x-circle" style="color: red;"></i>
        {{ session('error') }}
    </div>
</div>
@endif
@if (session('warning'))
<div class="toastbox">
    <div class="toast">
        <i class="bi bi-exclamation-triangle" style="color: rgb(239, 191, 101);"></i>
        {{ session('warning') }}
    </div>
</div>
@endif
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toastElements = document.querySelectorAll('.toast');
        toastElements.forEach(toastEl => {
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        });
    });
</script>
