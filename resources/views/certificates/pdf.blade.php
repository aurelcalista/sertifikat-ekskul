<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat - {{ $certificate->nama_siswa }}</title>
    @php
        $get_local_path = function($path) {
            if ($path && file_exists(storage_path('app/public/' . $path))) {
                return storage_path('app/public/' . $path);
            } elseif ($path && file_exists(public_path($path))) {
                return public_path($path);
            }
            return null;
        };

        $logo_file = $get_local_path($certificate->logo_sekolah);
        if (!$logo_file) {
            $logo_file = public_path('logos/logo-rakitai.png');
        }
        $logo_data = $logo_file ? \App\Models\Certificate::removeWhiteBackground($logo_file) : null;

        $verify_url = route('verify', $certificate->code);
        $qrRaw = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(180)->margin(1)->generate($verify_url);
        $qrCodeSvg = (string) $qrRaw;
        $qrCodeSvg = preg_replace('/^\s*<\?xml[^>]*\?>/i', '', $qrCodeSvg) ?? $qrCodeSvg;
        $qr_base64 = 'data:image/svg+xml;base64,' . base64_encode($qrCodeSvg);

        $upper_name = strtoupper($certificate->nama_siswa);
        $name_length = strlen($upper_name);

        $fs = '38pt';
        if ($name_length > 40) {
            $fs = '24pt';
        } elseif ($name_length > 30) {
            $fs = '28pt';
        } elseif ($name_length > 20) {
            $fs = '33pt';
        }

        $medalSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 130" width="100" height="130">
            <polygon points="42,68 30,130 42,118 50,125" fill="#1A3A7A" />
            <polygon points="58,68 70,130 58,118 50,125" fill="#2563EB" />
            <circle cx="50" cy="50" r="40" fill="#8B4513" stroke="#8B6508" stroke-width="1" />
            <circle cx="50" cy="50" r="37" fill="#FFD700" />
            <circle cx="50" cy="50" r="33" fill="none" stroke="#B8860B" stroke-width="1.5" />
            <circle cx="50" cy="50" r="31" fill="#DAA520" />
            <circle cx="50" cy="50" r="27" fill="none" stroke="#B8860B" stroke-width="0.8" />
            <ellipse cx="40" cy="38" rx="10" ry="7" fill="#FFF8DC" opacity="0.45" />
        </svg>';
        $medal_base64 = 'data:image/svg+xml;base64,' . base64_encode($medalSvg);
    @endphp
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        
        html, body {
            margin: 0;
            padding: 0;
            width: 297mm;
            height: 210mm;
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-color: #FFFFFF;
            color: #1F2A44;
        }

        .certificate-container {
            width: 297mm;
            height: 210mm;
            position: relative;
            background-color: #FCFAF5;
            overflow: hidden;
            box-sizing: border-box;
        }

        .bg-template {
            position: absolute;
            top: 0;
            left: 0;
            width: 297mm;
            height: 210mm;
            z-index: 1;
        }

        .content-layer {
            position: absolute;
            top: 0;
            left: 0;
            width: 297mm;
            height: 210mm;
            z-index: 10;
            box-sizing: border-box;
        }

        .header-section {
            text-align: center;
            padding-top: 14mm;
        }

        .title-section {
            text-align: center;
            margin-top: 3mm;
        }
        .cert-title {
            font-family: 'Times-Bold', 'Georgia', serif;
            font-size: 42pt;
            font-weight: bold;
            color: #1F2A44;
            letter-spacing: 9px;
            margin: 0;
            text-transform: uppercase;
        }
        .cert-subtitle {
            font-size: 15pt;
            font-weight: bold;
            color: #F15A3D;
            letter-spacing: 5px;
            margin: 4px 0 9px 0;
            text-transform: uppercase;
        }
        .cert-pill {
            border: 1.8pt solid #1F2A44;
            border-radius: 16px;
            padding: 4px 24px;
            font-size: 11pt;
            font-weight: bold;
            color: #1F2A44;
            display: inline-block;
        }

        .recipient-section {
            text-align: center;
            margin-top: 7mm;
        }
        .given-to {
            font-size: 13pt;
            color: #334155;
            margin: 0 0 2mm 0;
        }
        .recipient-name {
            font-family: 'Times-Bold', 'Georgia', serif;
            font-size: {{ $fs }};
            font-weight: bold;
            color: #1F2A44;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .description-section {
            text-align: center;
            width: 84%;
            margin: 7mm auto 0 auto;
        }
        .description-text {
            font-size: 14pt;
            line-height: 1.65;
            color: #334155;
            margin: 0;
        }
        .highlight-text {
            color: #F15A3D;
            font-weight: bold;
        }

        .footer-wrapper {
            position: absolute;
            bottom: 12mm;
            left: 20mm;
            width: 257mm;
            z-index: 20;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }
        .footer-qr-cell {
            width: 30%;
            vertical-align: bottom;
            text-align: left;
        }
        .footer-center-cell {
            width: 40%;
            vertical-align: bottom;
            text-align: center;
        }
        .footer-date-cell {
            width: 30%;
            vertical-align: bottom;
            text-align: right;
        }

        .qr-code-img {
            width: 72px;
            height: 72px;
            border: 1.8px solid #CBD5E1;
            padding: 3px;
            border-radius: 8px;
            background-color: #FFFFFF;
            display: inline-block;
        }

        .medal-img {
            width: 82px;
            height: 108px;
            display: inline-block;
        }

        .date-box {
            display: inline-block;
            text-align: right;
        }
        .date-label {
            font-family: 'Times-Italic', 'Georgia', serif;
            font-size: 12.5pt;
            color: #475569;
            font-style: italic;
            margin-bottom: 3px;
            text-align: right;
        }
        .date-value-wrap {
            text-align: right;
            white-space: nowrap;
        }
        .date-dot {
            font-size: 9pt;
            color: #94A3B8;
        }
        .date-text {
            font-size: 13.5pt;
            font-weight: bold;
            color: #0F172A;
            margin: 0 5px;
        }
        .date-line {
            height: 1.8px;
            background-color: #64748B;
            margin-top: 4px;
            width: 100%;
        }
    </style>
</head>
<body>

    <div class="certificate-container">

        <!-- Rakit AI Vector Background Frame -->
        <img class="bg-template" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMTIyIDc5MyIgd2lkdGg9IjExMjIiIGhlaWdodD0iNzkzIj4KICAgIDwhLS0gMS4gVG9wLUxlZnQgVGVjaG5pY2FsIENpcmN1bGFyIExpbmUgUGF0dGVybiAtLT4KICAgIDxnIGZpbGw9Im5vbmUiIHN0cm9rZT0iIzY0NzQ4QiIgc3Ryb2tlLXdpZHRoPSIxLjIiIG9wYWNpdHk9IjAuNjUiPgogICAgICAgIDxjaXJjbGUgY3g9IjAiIGN5PSIwIiByPSIyMzAiIHN0cm9rZS13aWR0aD0iMC43Ii8+CiAgICAgICAgPGNpcmNsZSBjeD0iMCIgY3k9IjAiIHI9IjIxMCIgc3Ryb2tlLWRhc2hhcnJheT0iNCw0Ii8+CiAgICAgICAgPGNpcmNsZSBjeD0iMCIgY3k9IjAiIHI9IjE5MCIgc3Ryb2tlLXdpZHRoPSIxLjIiLz4KICAgICAgICA8Y2lyY2xlIGN4PSIwIiBjeT0iMCIgcj0iMTcwIi8+CiAgICAgICAgPGNpcmNsZSBjeD0iMCIgY3k9IjAiIHI9IjE1MCIgc3Ryb2tlLWRhc2hhcnJheT0iMywzIi8+CiAgICAgICAgPGNpcmNsZSBjeD0iMCIgY3k9IjAiIHI9IjEzMCIgc3Ryb2tlLXdpZHRoPSIxLjUiLz4KICAgICAgICA8Y2lyY2xlIGN4PSIwIiBjeT0iMCIgcj0iMTAwIi8+CiAgICAgICAgPGNpcmNsZSBjeD0iMCIgY3k9IjAiIHI9IjcwIiBzdHJva2Utd2lkdGg9IjAuOCIvPgogICAgICAgIDxsaW5lIHgxPSIwIiB5MT0iMCIgeDI9IjIzMCIgeTI9IjAiIHN0cm9rZS13aWR0aD0iMS4yIi8+CiAgICAgICAgPGxpbmUgeDE9IjAiIHkxPSIwIiB4Mj0iMjEyIiB5Mj0iODgiLz4KICAgICAgICA8bGluZSB4MT0iMCIgeTE9IjAiIHgyPSIxNjIiIHkyPSIxNjIiIHN0cm9rZS13aWR0aD0iMS4yIi8+CiAgICAgICAgPGxpbmUgeDE9IjAiIHkxPSIwIiB4Mj0iODgiIHkyPSIyMTIiLz4KICAgICAgICA8bGluZSB4MT0iMCIgeTE9IjAiIHgyPSIwIiB5Mj0iMjMwIiBzdHJva2Utd2lkdGg9IjEuMiIvPgogICAgICAgIDxjaXJjbGUgY3g9IjIxMiIgY3k9Ijg4IiByPSIzIiBmaWxsPSIjNjQ3NDhCIi8+CiAgICAgICAgPGNpcmNsZSBjeD0iMTYyIiBjeT0iMTYyIiByPSIzIiBmaWxsPSIjNjQ3NDhCIi8+CiAgICAgICAgPGNpcmNsZSBjeD0iODgiIGN5PSIyMTIiIHI9IjMiIGZpbGw9IiM2NDc0OEIiLz4KICAgIDwvZz4KCiAgICA8IS0tIDIuIFRvcC1SaWdodCBPcmFuZ2UgR2VvbWV0cmljIEFuZ3VsYXIgU3BsYXNoIC0tPgogICAgPGcgZmlsbD0iI0YxNUEzRCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoNzcyLCAwKSI+CiAgICAgICAgPHBvbHlnb24gcG9pbnRzPSIxMjAsMCAzNTAsMCAzNTAsMjIwIDI4MCwxODAgMjYwLDI1MCAyMTAsMTcwIDE3MCwyMjAgMTQwLDExMCA4MCwxNDAgMTAwLDUwIiAvPgogICAgICAgIDxwb2x5Z29uIHBvaW50cz0iMjYwLDE5MCAzNTAsMTIwIDM1MCwyNzAgMjkwLDI2MCIgZmlsbD0iI0Q5NDgyQiIvPgogICAgICAgIDxwb2x5Z29uIHBvaW50cz0iMTgwLDIxMCAyNDAsMjkwIDI4MCwyNDAgMjIwLDE4MCIgZmlsbD0iI0ZGNkI0QSIvPgogICAgPC9nPgoKICAgIDwhLS0gMy4gTGVmdCBTaWRlIERpYWdvbmFsIEdyYXkgTGluZXMgLS0+CiAgICA8ZyBzdHJva2U9IiM5NEEzQjgiIHN0cm9rZS13aWR0aD0iMi41IiBzdHJva2UtbGluZWNhcD0icm91bmQiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDEwLCAyNjApIj4KICAgICAgICA8bGluZSB4MT0iNSIgeTE9IjIwIiB4Mj0iNTUiIHkyPSI0NSIgLz4KICAgICAgICA8bGluZSB4MT0iNSIgeTE9IjQwIiB4Mj0iNTUiIHkyPSI2NSIgLz4KICAgICAgICA8bGluZSB4MT0iNSIgeTE9IjYwIiB4Mj0iNTUiIHkyPSI4NSIgLz4KICAgICAgICA8bGluZSB4MT0iNSIgeTE9IjgwIiB4Mj0iNTUiIHkyPSIxMDUiIC8+CiAgICAgICAgPGxpbmUgeDE9IjUiIHkxPSIxMDAiIHgyPSI1NSIgeTI9IjEyNSIgLz4KICAgICAgICA8bGluZSB4MT0iNSIgeTE9IjEyMCIgeDI9IjU1IiB5Mj0iMTQ1IiAvPgogICAgICAgIDxsaW5lIHgxPSI1IiB5MT0iMTQwIiB4Mj0iNTUiIHkyPSIxNjUiIC8+CiAgICAgICAgPGxpbmUgeDE9IjUiIHkxPSIxNjAiIHgyPSI1NSIgeTI9IjE4NSIgLz4KICAgICAgICA8bGluZSB4MT0iNSIgeTE9IjE4MCIgeDI9IjU1IiB5Mj0iMjA1IiAvPgogICAgPC9nPgoKICAgIDwhLS0gNC4gUmlnaHQgU2lkZSBVcHdhcmQgU3RhY2tlZCBDaGV2cm9ucyAtLT4KICAgIDxnIGZpbGw9Im5vbmUiIHN0cm9rZS13aWR0aD0iMi41IiBzdHJva2UtbGluZWpvaW49InJvdW5kIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDEwNTUsIDI2MCkiPgogICAgICAgIDxwb2x5bGluZSBwb2ludHM9IjEwLDM1IDMwLDE1IDUwLDM1IiBzdHJva2U9IiNGMTVBM0QiIC8+CiAgICAgICAgPHBvbHlsaW5lIHBvaW50cz0iMTAsNjUgMzAsNDUgNTAsNjUiIHN0cm9rZT0iI0YxNUEzRCIgLz4KICAgICAgICA8cG9seWxpbmUgcG9pbnRzPSIxMCw5NSAzMCw3NSA1MCw5NSIgc3Ryb2tlPSIjNjQ3NDhCIiAvPgogICAgICAgIDxwb2x5bGluZSBwb2ludHM9IjEwLDEyNSAzMCwxMDUgNTAsMTI1IiBzdHJva2U9IiM2NDc0OEIiIC8+CiAgICAgICAgPHBvbHlsaW5lIHBvaW50cz0iMTAsMTU1IDMwLDEzNSA1MCwxNTUiIHN0cm9rZT0iIzY0NzQ4QiIgLz4KICAgICAgICA8cG9seWxpbmUgcG9pbnRzPSIxMCwxODUgMzAsMTY1IDUwLDE4NSIgc3Ryb2tlPSIjQ0JENUUxIiAvPgogICAgPC9nPgoKICAgIDwhLS0gNS4gQm90dG9tIExlZnQgQ29ybmVyIERpYWdvbmFsIE9yYW5nZSBMaW5lcyAtLT4KICAgIDxnIHN0cm9rZT0iI0YxNUEzRCIgc3Ryb2tlLXdpZHRoPSIyLjUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMCwgNTkzKSI+CiAgICAgICAgPGxpbmUgeDE9IjAiIHkxPSIyMDAiIHgyPSIyMjAiIHkyPSIyMCIgc3Ryb2tlLXdpZHRoPSIzLjUiLz4KICAgICAgICA8bGluZSB4MT0iMCIgeTE9IjE3MCIgeDI9IjE5MCIgeTI9IjEwIiBzdHJva2Utd2lkdGg9IjMiLz4KICAgICAgICA8bGluZSB4MT0iMCIgeTE9IjE0MCIgeDI9IjE2MCIgeTI9IjAiIHN0cm9rZS13aWR0aD0iMi41Ii8+CiAgICAgICAgPGxpbmUgeDE9IjAiIHkxPSIxMTAiIHgyPSIxMzAiIHkyPSIwIiBzdHJva2Utd2lkdGg9IjIiLz4KICAgICAgICA8bGluZSB4MT0iMCIgeTE9IjgwIiB4Mj0iOTAiIHkyPSIwIiBzdHJva2Utd2lkdGg9IjEuNSIvPgogICAgICAgIDxsaW5lIHgxPSIwIiB5MT0iNTAiIHgyPSI1MCIgeTI9IjAiIHN0cm9rZS13aWR0aD0iMSIvPgogICAgPC9nPgoKICAgIDwhLS0gNi4gQm90dG9tIFJpZ2h0IEdlb21ldHJpYyBMLXNoYXBlZCBHcmFpbiBGcmFtZSAtLT4KICAgIDxnIGZpbGw9Im5vbmUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoODcyLCA1NDMpIj4KICAgICAgICA8cGF0aCBkPSJNIDQwLDI0MCBMIDI0MCwyNDAgTCAyNDAsNDAgTSA3MCwyNDAgTCAyNDAsMjQwIEwgMjQwLDcwIiBzdHJva2U9IiMxRTI5M0IiIHN0cm9rZS13aWR0aD0iMiIgLz4KICAgICAgICA8cGF0aCBkPSJNIDEwLDI0MCBMIDI0MCwyNDAgTCAyNDAsMTAiIHN0cm9rZT0iI0YxNUEzRCIgc3Ryb2tlLXdpZHRoPSIyIiAvPgogICAgICAgIDxwYXRoIGQ9Ik0gNTAsMjI1IEwgMjI1LDIyNSBMIDIyNSw1MCIgc3Ryb2tlPSIjRjE1QTNEIiBzdHJva2Utd2lkdGg9IjEuNSIgLz4KICAgICAgICA8cGF0aCBkPSJNIDgwLDIxMCBMIDE2MCwyMTAgTCAxNjAsMTgwIEwgMTgwLDE4MCBMIDE4MCwxNjAgTCAyMTAsMTYwIEwgMjEwLDgwIiBzdHJva2U9IiNGMTVBM0QiIHN0cm9rZS13aWR0aD0iMS44IiAvPgogICAgICAgIDxnIHN0cm9rZT0iI0YxNUEzRCIgc3Ryb2tlLXdpZHRoPSIxLjUiPgogICAgICAgICAgICA8bGluZSB4MT0iMTYwIiB5MT0iMTk1IiB4Mj0iODUiIHkyPSIxOTUiIHN0cm9rZS13aWR0aD0iMiIvPgogICAgICAgICAgICA8cGF0aCBkPSJNIDExNSwxOTUgUSAxMDUsMTg1IDk1LDE5NSBRIDEwNSwyMDUgMTE1LDE5NSBaIiBmaWxsPSIjRjE1QTNEIiBvcGFjaXR5PSIwLjg1Ii8+CiAgICAgICAgICAgIDxwYXRoIGQ9Ik0gMTMwLDE5NSBRIDEyMCwxODUgMTEwLDE5NSBRIDEyMCwyMDUgMTMwLDE5NSBaIiBmaWxsPSIjRjE1QTNEIiBvcGFjaXR5PSIwLjg1Ii8+CiAgICAgICAgICAgIDxwYXRoIGQ9Ik0gMTQ1LDE5NSBRIDEzNSwxODUgMTI1LDE5NSBRIDEzNSwyMDUgMTQ1LDE5NSBaIiBmaWxsPSIjRjE1QTNEIiBvcGFjaXR5PSIwLjg1Ii8+CiAgICAgICAgPC9nPgogICAgICAgIDxnIHN0cm9rZT0iI0YxNUEzRCIgc3Ryb2tlLXdpZHRoPSIxLjUiPgogICAgICAgICAgICA8bGluZSB4MT0iMTk1IiB5MT0iMTYwIiB4Mj0iMTk1IiB5Mj0iODUiIHN0cm9rZS13aWR0aD0iMiIvPgogICAgICAgICAgICA8cGF0aCBkPSJNIDE5NSwxMTUgUSAxODUsMTA1IDE5NSw5NSBRIDIwNSwxMDUgMTk1LDExNSBaIiBmaWxsPSIjRjE1QTNEIiBvcGFjaXR5PSIwLjg1Ii8+CiAgICAgICAgICAgIDxwYXRoIGQ9Ik0gMTk1LDEzMCBRIDE4NSwxMjAgMTk1LDExMCBRIDIwNSwxMjAgMTk1LDEzMCBaIiBmaWxsPSIjRjE1QTNEIiBvcGFjaXR5PSIwLjg1Ii8+CiAgICAgICAgICAgIDxwYXRoIGQ9Ik0gMTk1LDE0NSBRIDE4NSwxMzUgMTk1LDEyNSBRIDIwNSwxMzUgMTk1LDE0NSBaIiBmaWxsPSIjRjE1QTNEIiBvcGFjaXR5PSIwLjg1Ii8+CiAgICAgICAgPC9nPgogICAgPC9nPgo8L3N2Zz4=" alt="Background Vector">

        <div class="content-layer">
            <!-- Header Logo -->
            <div class="header-section">
                @if($logo_data)
                    <img src="{{ $logo_data }}" style="max-height: 58px; width: auto;" alt="Logo">
                @else
                    <img src="{{ public_path('logos/logo-rakitai.png') }}" style="max-height: 58px; width: auto;" alt="Logo">
                @endif
            </div>

            <!-- Title & Subtitle -->
            <div class="title-section">
                <h2 class="cert-title">SERTIFIKAT</h2>
                <p class="cert-subtitle">{{ strtoupper($certificate->jenis_sertifikat ?? 'SERTIFIKAT KEIKUTSERTAAN') }}</p>
                
                <div style="text-align: center; margin-top: 3.5mm;">
                    <span class="cert-pill">Certificat No: {{ $certificate->nomor_sertifikat }}</span>
                </div>
            </div>

            <!-- Recipient Section -->
            <div class="recipient-section">
                <p class="given-to">Diberikan kepada:</p>
                <h3 class="recipient-name">{{ $upper_name }}</h3>
            </div>

            <!-- Description Box -->
            <div class="description-section">
                <p class="description-text">
                    @php
                        $descText = e($certificate->prestasi);
                        $descText = preg_replace('/&quot;(.*?)&quot;/', '<span class="highlight-text">"$1"</span>', $descText);
                    @endphp
                    {!! nl2br($descText) !!}
                </p>
            </div>
        </div>

        <!-- Bottom Footer Wrapper -->
        <div class="footer-wrapper">
            <table class="footer-table">
                <tr>
                    <td class="footer-qr-cell">
                        <img src="{{ $qr_base64 }}" class="qr-code-img" alt="QR Code">
                    </td>
                    <td class="footer-center-cell">
                        <img src="{{ $medal_base64 }}" class="medal-img" alt="Gold Medal">
                    </td>
                    <td class="footer-date-cell">
                        <div class="date-box">
                            <div class="date-label">Diterbitkan pada tanggal</div>
                            <div class="date-value-wrap">
                                <span class="date-dot">&#9679; &#9679;</span>
                                <span class="date-text">{{ $certificate->tanggal->translatedFormat('d F Y') }}</span>
                                <span class="date-dot">&#9679; &#9679;</span>
                            </div>
                            <div class="date-line"></div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

    </div>

</body>
</html>