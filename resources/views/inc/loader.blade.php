<!-- resources/views/components/loader.blade.php -->
<div class="loader-overlay" id="loaderOverlay">
    <span class="loader"></span>
</div>

<style>
    .loader-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.95);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 99999;
        visibility: visible;
        opacity: 1;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    .loader-overlay.hide {
        visibility: hidden;
        opacity: 0;
    }

    .loader {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border-top: 4px solid #0d6efd;
        border-right: 4px solid transparent;
        animation: rotation 1s linear infinite;
        position: relative;
    }

    .loader::after {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border-bottom: 4px solid #198754;
        border-left: 4px solid transparent;
    }

    @keyframes rotation {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<script>
    window.addEventListener('load', () => {
        const loader = document.getElementById('loaderOverlay');
        if (loader) {
            loader.classList.add('hide');
        }
    });
</script>
