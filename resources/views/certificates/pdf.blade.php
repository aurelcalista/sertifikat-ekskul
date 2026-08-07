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

        $fs = '36pt';
        if ($name_length > 40) {
            $fs = '22pt';
        } elseif ($name_length > 30) {
            $fs = '26pt';
        } elseif ($name_length > 20) {
            $fs = '30pt';
        }

        $seal_base64 = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDAgMTAwIiB3aWR0aD0iNDgiIGhlaWdodD0iNDgiPgogICAgPGNpcmNsZSBjeD0iNTAiIGN5PSI1MCIgcj0iNDYiIGZpbGw9IiNENEFGMzciIHN0cm9rZT0iI0RBQTUyMCIgc3Ryb2tlLXdpZHRoPSIyIiAvPgogICAgPGNpcmNsZSBjeD0iNTAiIGN5PSI1MCIgcj0iNDIiIGZpbGw9Im5vbmUiIHN0cm9rZT0iI0ZGRkZGRiIgc3Ryb2tlLXdpZHRoPSIxLjUiIHN0cm9rZS1kYXNoYXJyYXk9IjQgMiIgLz4KICAgIDxjaXJjbGUgY3g9IjUwIiBjeT0iNTAiIHI9IjM4IiBmaWxsPSIjREFBNTIwIiAvPgogICAgPHBvbHlnb24gcG9pbnRzPSI1MCwyMCA1OCwzNiA3NiwzOCA2Myw1MSA2Niw2OSA1MCw2MCAzNCw2OSAzNyw1MSAyNCwzOCA0MiwzNiIgZmlsbD0iI0ZGRkZGRiIgLz4KPC9zdmc+';
        $bg_base64 = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMTIyIDc5MyIgd2lkdGg9IjExMjIiIGhlaWdodD0iNzk3Ij4KICAgIDxyZWN0IHg9IjIyIiB5PSIyMiIgd2lkdGg9IjEwNzgiIGhlaWdodD0iNzQ5IiBmaWxsPSJub25lIiBzdHJva2U9IiNENEFGMzciIHN0cm9rZS13aWR0aD0iMi41IiAvPgogICAgPHJlY3QgeD0iMzAiIHk9IjMwIiB3aWR0aD0iMTA2MiIgaGVpZ2h0PSI3MzMiIGZpbGw9Im5vbmUiIHN0cm9rZT0iIzBGMTcyQSIgc3Ryb2tlLXdpZHRoPSIxIiAvPgogICAgPHBvbHlsaW5lIHBvaW50cz0iNDQsMzUgMzUsMzUgMzUsNDQiIGZpbGw9Im5vbmUiIHN0cm9rZT0iI0Q0QUYzNyIgc3Ryb2tlLXdpZHRoPSIyLjUiIC8+CiAgICA8cG9seWxpbmUgcG9pbnRzPSIxMDg3LDQ0IDEwODcsMzUgMTA3OCwzNSIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjRDRBRjM3IiBzdHJva2Utd2lkdGg9IjIuNSIgLz4KICAgIDxwb2x5bGluZSBwb2ludHM9IjM1LDc0OSAzNSw3NTggNDQsNzU4IiBmaWxsPSJub25lIiBzdHJva2U9IiNENEFGMzciIHN0cm9rZS13aWR0aD0iMi41IiAvPgogICAgPHBvbHlsaW5lIHBvaW50cz0iMTA3OCw3NTggMTA4Nyw3NTggMTA4Nyw3NDkiIGZpbGw9Im5vbmUiIHN0cm9rZT0iI0Q0QUYzNyIgc3Ryb2tlLXdpZHRoPSIyLjUiIC8+Cjwvc3ZnPg==';
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
            background-color: #FFFFFF;
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
            padding: 14mm 18mm;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-logo-cell {
            width: 18%;
            vertical-align: middle;
            text-align: left;
        }
        .header-text-cell {
            width: 64%;
            vertical-align: middle;
            text-align: center;
        }
        .header-seal-cell {
            width: 18%;
            vertical-align: middle;
            text-align: right;
        }

        .inst-title {
            font-size: 10.5pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #334155;
            margin: 0;
        }
        .inst-subtitle {
            font-size: 8pt;
            color: #94A3B8;
            letter-spacing: 0.5px;
            margin: 2px 0 0 0;
        }

        .top-ornament {
            text-align: center;
            color: #D4AF37;
            font-size: 10pt;
            letter-spacing: 8px;
            margin-top: 3mm;
        }

        .title-section {
            text-align: center;
            margin-top: 2mm;
        }
        .cert-title {
            font-family: 'Times-Bold', 'Georgia', serif;
            font-size: 38pt;
            font-weight: bold;
            color: #0F172A;
            letter-spacing: 8px;
            margin: 0;
            text-transform: uppercase;
        }
        .cert-subtitle {
            font-size: 11pt;
            font-weight: bold;
            color: #D4AF37;
            letter-spacing: 4px;
            margin: 2px 0 0 0;
            text-transform: uppercase;
        }

        .divider-table {
            width: 50%;
            margin: 3mm auto 2mm auto;
            border-collapse: collapse;
        }
        .divider-line {
            border-bottom: 1pt solid #D4AF37;
            width: 48%;
        }
        .divider-diamond {
            color: #D4AF37;
            font-size: 8pt;
            width: 4%;
            text-align: center;
            padding: 0 4px;
        }

        .given-to {
            font-family: 'Times-Italic', 'Georgia', serif;
            font-style: italic;
            font-size: 12pt;
            color: #64748B;
            margin: 2mm 0 1mm 0;
            text-align: center;
        }
        .recipient-name {
            font-family: 'Times-Bold', 'Georgia', serif;
            font-size: {{ $fs }};
            font-weight: bold;
            color: #1A1A2E;
            margin: 2mm 0;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .name-underline {
            width: 45%;
            height: 1.5pt;
            background-color: #D4AF37;
            margin: 2.5mm auto 2mm auto;
        }

        .description-section {
            text-align: center;
            width: 82%;
            margin: 4mm auto 0 auto;
        }
        .description-text {
            font-size: 11.5pt;
            line-height: 1.55;
            color: #334155;
            margin: 0;
        }
        .highlight-text {
            color: #D4AF37;
            font-weight: bold;
        }

        .footer-wrapper {
            position: absolute;
            bottom: 14mm;
            left: 18mm;
            width: 261mm;
            z-index: 20;
        }
        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }
        .footer-qr-cell {
            width: 50%;
            vertical-align: bottom;
            text-align: left;
        }
        .footer-info-cell {
            width: 50%;
            vertical-align: bottom;
            text-align: right;
        }

        .qr-code-img {
            width: 50px;
            height: 50px;
            border: 1.2pt solid #D4AF37;
            padding: 2px;
            background-color: #FFFFFF;
            display: inline-block;
            vertical-align: bottom;
        }
        .qr-caption {
            font-size: 7pt;
            color: #94A3B8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-block;
            margin-left: 6px;
            vertical-align: bottom;
        }

        .info-label {
            font-size: 7.5pt;
            color: #94A3B8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1px;
        }
        .info-val {
            font-size: 10pt;
            font-weight: bold;
            color: #0F172A;
            margin-bottom: 2px;
        }
    </style>
</head>
<body>

    <div class="certificate-container">

        <!-- Elegant Double Frame SVG Background -->
        <img class="bg-template" src="{{ $bg_base64 }}" alt="Background Frame">

        <div class="content-layer">
            <!-- Header Table -->
            <table class="header-table">
                <tr>
                    <td class="header-logo-cell">
                        @if($logo_data)
                            <img src="{{ $logo_data }}" style="max-height: 48px; width: auto;" alt="Logo">
                        @else
                            <img src="{{ public_path('logos/logo-rakitai.png') }}" style="max-height: 48px; width: auto;" alt="Logo">
                        @endif
                    </td>
                    <td class="header-text-cell">
                        <p class="inst-title">Lembaga Pendidikan Sertifikasi Ekstrakurikuler</p>
                        <p class="inst-subtitle">Sertifikat Resmi Kegiatan Peserta Didik</p>
                    </td>
                    <td class="header-seal-cell">
                        <img src="{{ $seal_base64 }}" style="width: 44px; height: 44px;" alt="Gold Seal">
                    </td>
                </tr>
            </table>

            <!-- Header Bottom Line -->
            <div style="border-bottom: 1pt solid #E8D5A3; margin-top: 3mm; width: 100%;"></div>

            <!-- Decorative Top Ornament -->
            <div class="top-ornament">✦ ✦ ✦</div>

            <!-- Title & Subtitle -->
            <div class="title-section">
                <h1 class="cert-title">SERTIFIKAT</h1>
                <p class="cert-subtitle">{{ strtoupper($certificate->jenis_sertifikat ?? 'SERTIFIKAT PENGHARGAAN') }}</p>
                
                <table class="divider-table">
                    <tr>
                        <td class="divider-line"></td>
                        <td class="divider-diamond">◆</td>
                        <td class="divider-line"></td>
                    </tr>
                </table>
            </div>

            <!-- Recipient Section -->
            <p class="given-to">Dengan bangga diberikan kepada:</p>
            <h2 class="recipient-name">{{ $upper_name }}</h2>
            <div class="name-underline"></div>

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
            <div style="border-top: 1pt solid #E8D5A3; padding-top: 2.5mm; width: 100%;"></div>
            <table class="footer-table">
                <tr>
                    <td class="footer-qr-cell">
                        <img src="{{ $qr_base64 }}" class="qr-code-img" alt="QR Code">
                        <span class="qr-caption">Pindai verifikasi</span>
                    </td>
                    <td class="footer-info-cell">
                        <div class="info-label">Nomor Sertifikat</div>
                        <div class="info-val">{{ $certificate->nomor_sertifikat }}</div>
                        <div class="info-label" style="margin-top: 2px;">Diterbitkan pada</div>
                        <div class="info-val" style="margin-bottom: 0;">{{ $certificate->tanggal->translatedFormat('d F Y') }}</div>
                    </td>
                </tr>
            </table>
        </div>

    </div>

</body>
</html>