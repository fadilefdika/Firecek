<div class="container py-5">
    <div class="text-center">
        <h5 class="mb-3">QR Code untuk APAR</h5>

        <div class="d-inline-block border p-3 bg-white">
            {!! $qr !!}
        </div>

        <p class="mt-3 fw-bold">{{ $apar->brand }} - {{ $apar->type }}</p>

        <a href="#" onclick="window.print()" class="btn btn-primary mt-4">
            <i class="fas fa-print me-1"></i> Cetak QR Code
        </a>
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .container, .container * {
            visibility: visible;
        }
        .container {
            position: absolute;
            top: 0;
            left: 0;
        }
    }
</style>
