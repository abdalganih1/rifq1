<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.qr_codes') ?: 'رموز QR' }}</title>
    <style>
        @page {
            size: A4;
            margin: 15mm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', 'Tahoma', 'Arial', sans-serif;
            direction: rtl;
            color: #1a1a1a;
        }

        .page {
            width: 100%;
            page-break-after: always;
            display: flex;
            flex-wrap: wrap;
            align-content: flex-start;
            gap: 0;
        }

        .page:last-child {
            page-break-after: auto;
        }

        .qr-card {
            width: 33.33%;
            height: 33.33%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 8mm 4mm;
            border: 0.5px solid #e5e7eb;
            text-align: center;
        }

        .qr-card img {
            width: 55mm;
            height: 55mm;
            object-fit: contain;
            margin-bottom: 4mm;
        }

        .qr-card .serial-number {
            font-size: 11pt;
            font-weight: bold;
            color: #047857;
            margin-bottom: 2mm;
            font-family: 'DejaVu Sans Mono', 'Courier New', monospace;
            direction: ltr;
        }

        .qr-card .scan-url {
            font-size: 7pt;
            color: #9ca3af;
            word-break: break-all;
            direction: ltr;
            max-width: 55mm;
        }

        .header {
            text-align: center;
            margin-bottom: 5mm;
            padding-bottom: 3mm;
            border-bottom: 1px solid #d1d5db;
        }

        .header h1 {
            font-size: 14pt;
            color: #047857;
            font-weight: bold;
        }

        .header .team-name {
            font-size: 10pt;
            color: #6b7280;
            margin-top: 1mm;
        }

        .page-wrapper {
            height: 297mm;
            width: 210mm;
            position: relative;
        }
    </style>
</head>
<body>
    @php
        $chunks = $qrLinks->chunk(9);
    @endphp

    @foreach($chunks as $pageIndex => $chunk)
    <div class="page-wrapper">
        @if($pageIndex === 0)
        <div class="header">
            <h1>{{ __('messages.rifq_system') ?: 'نظام رفق' }} - {{ __('messages.qr_codes') ?: 'رموز QR' }}</h1>
            @if(isset($team))
            <div class="team-name">{{ $team->name }}</div>
            @endif
        </div>
        @endif

        <div class="page">
            @foreach($chunk as $qr)
            <div class="qr-card">
                @if($qr->qr_image_path)
                <img src="{{ public_path('storage/' . $qr->qr_image_path) }}" alt="QR">
                @elseif($qr->qr_image_url)
                <img src="{{ $qr->qr_image_url }}" alt="QR">
                @endif
                <div class="serial-number">{{ $qr->animal?->serial_number ?? $qr->qr_identifier }}</div>
                <div class="scan-url">{{ url('/scan/' . $qr->qr_identifier) }}</div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
</body>
</html>
