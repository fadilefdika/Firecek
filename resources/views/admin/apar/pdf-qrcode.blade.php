<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica', sans-serif; text-align: center; margin: 0; padding: 10px; }
        .qr-wrapper { margin-top: 10px; }
        .unit-name { font-weight: bold; font-size: 18px; margin-bottom: 5px; }
        .detail { font-size: 12px; color: #555; }
    </style>
</head>
<body>
    <div class="unit-name">UNIT #{{ $apar->apar_code ?? $apar->id }}</div>
    
    <div class="qr-wrapper">
        {{-- Gunakan format data:image/svg+xml --}}
        <img src="data:image/svg+xml;base64,{{ $qrcode }}" width="200" height="200">
    </div>

    <div class="detail">
        {{-- {{ $apar->location?->location_name }} <br> --}}
        <strong>scan for more detail</strong>
    </div>
</body>
</html>