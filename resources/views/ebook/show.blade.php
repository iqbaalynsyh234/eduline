<style>
     iframe * {
        user-select: none;
        pointer-events: none;
    }
</style>
<div class="container">
    <h3>{{ $ebook->name }}</h3>
    <iframe src="{{ $filePath }}" width="100%" height="800px" id="pdfIframe" style="border: none;" sandbox="allow-scripts allow-same-origin">
        Your browser does not support PDF viewing. Please <a href="{{ $filePath }}">download the PDF</a> to view it.
    </iframe>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelector('#pdfIframe').oncontextmenu = function (e) {
        e.preventDefault();
    };

    let isTabActive = true;

    window.onblur = function () {
        if (isTabActive) {
            Swal.fire({
                icon: 'warning',
                title: 'Jangan pindah tab!',
                text: 'Anda sedang melihat Ebook.',
                showConfirmButton: false,
                timer: 1500
            });
        }
    };

    window.onfocus = function () {
        isTabActive = true;
    };

    setInterval(function () {
        if (document.hidden) {
            isTabActive = false;
            Swal.fire({
                icon: 'warning',
                title: 'Jangan pindah tab!',
                text: 'Anda sedang melihat Ebook.',
                showConfirmButton: false,
                timer: 1500
            });
        }
    }, 1000);

    document.addEventListener('keydown', function (e) {
        if (
            (e.ctrlKey && e.key === 's') || 
            (e.ctrlKey && e.key === 'p') || 
            (e.ctrlKey && e.shiftKey && e.key === 'i') 
        ) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Aksi Dilarang!',
                text: 'Anda tidak diperbolehkan menyimpan atau mencetak dokumen ini.',
                showConfirmButton: false,
                timer: 1500
            });
        }
    });

    document.querySelector('#pdfIframe').addEventListener('load', function () {
        const iframe = document.querySelector('#pdfIframe').contentWindow.document;
        iframe.body.style.userSelect = 'none'; 
        iframe.body.style.pointerEvents = 'none'; 
    });
</script>
