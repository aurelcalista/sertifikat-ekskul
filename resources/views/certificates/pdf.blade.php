<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat - {{ $certificate->nama_siswa }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        
        /* Font embedding for DomPDF using local paths */
        @font-face {
            font-family: 'Great Vibes';
            font-style: normal;
            font-weight: 400;
            src: url('{{ public_path("fonts/GreatVibes-Regular.ttf") }}') format('truetype');
        }
        @font-face {
            font-family: 'Cormorant Garamond';
            font-style: normal;
            font-weight: 400;
            src: url('{{ public_path("fonts/CormorantGaramond-Regular.ttf") }}') format('truetype');
        }
        @font-face {
            font-family: 'Cormorant Garamond';
            font-style: normal;
            font-weight: 700;
            src: url('{{ public_path("fonts/CormorantGaramond-Regular.ttf") }}') format('truetype');
        }
        @font-face {
            font-family: 'Cormorant Garamond';
            font-style: italic;
            font-weight: 400;
            src: url('{{ public_path("fonts/CormorantGaramond-Italic.ttf") }}') format('truetype');
        }
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 400;
            src: url('{{ public_path("fonts/Poppins-Regular.ttf") }}') format('truetype');
        }
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 600;
            src: url('{{ public_path("fonts/Poppins-SemiBold.ttf") }}') format('truetype');
        }

        body {
            font-family: 'Poppins', 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #FCFAF5;
            color: #14213D;
            -webkit-print-color-adjust: exact;
        }

        /* Container Certificate */
        .certificate-container {
            width: 297mm;
            height: 210mm;
            box-sizing: border-box;
            position: relative;
            background-color: #FCFAF5;
            overflow: hidden;
        }

        /* Background Template Image if exists */
        .bg-template {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        /* Content Wrapper */
        .content {
            position: absolute;
            top: 14mm;
            left: 18mm;
            right: 18mm;
            height: 132mm;
            z-index: 10;
        }

        /* Double Gold Borders */
        .border-outer {
            position: absolute;
            top: 6mm;
            left: 6mm;
            right: 6mm;
            bottom: 6mm;
            border: 2.0pt solid #C89B3C;
            z-index: 2;
        }
        .border-inner {
            position: absolute;
            top: 9mm;
            left: 9mm;
            right: 9mm;
            bottom: 9mm;
            border: 0.75pt solid #C89B3C;
            z-index: 2;
        }

        /* Geometric corner pattern positioning */
        .corner-pattern-tl { position: absolute; top: 9.5mm; left: 9.5mm; z-index: 3; }
        .corner-pattern-tr { position: absolute; top: 9.5mm; right: 9.5mm; z-index: 3; transform: rotate(90deg); }
        .corner-pattern-br { position: absolute; bottom: 9.5mm; right: 9.5mm; z-index: 3; transform: rotate(180deg); }
        .corner-pattern-bl { position: absolute; bottom: 9.5mm; left: 9.5mm; z-index: 3; transform: rotate(270deg); }

        /* Header Layout */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2mm;
        }
        .header-logo-cell {
            width: 60px;
            vertical-align: middle;
        }
        .header-text-cell {
            text-align: center;
            vertical-align: middle;
        }
        .header-seal-cell {
            width: 60px;
            vertical-align: middle;
            text-align: right;
        }
        
        .school-name {
            font-family: 'Poppins', sans-serif;
            font-size: 11pt;
            font-weight: 700;
            color: #14213D;
            margin: 0;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }
        .school-sub {
            font-family: 'Poppins', sans-serif;
            font-size: 7.5pt;
            color: #556270;
            margin: 2px 0 0 0;
            letter-spacing: 0.5px;
        }

        /* Title Area */
        .title-box {
            text-align: center;
            margin-top: 4mm;
        }
        .certificate-title {
            font-family: 'Cormorant Garamond', 'Georgia', serif;
            font-size: 34pt;
            font-weight: 700;
            color: #14213D;
            margin: 0;
            letter-spacing: 8px;
            text-transform: uppercase;
        }
        
        .subtitle-container {
            border-top: 0.75pt solid #C89B3C;
            border-bottom: 0.75pt solid #C89B3C;
            padding: 3px 0;
            margin: 5px auto;
            width: 45%;
            text-align: center;
        }
        .certificate-subtitle {
            font-family: 'Poppins', sans-serif;
            font-size: 8.5pt;
            color: #C89B3C;
            font-weight: 600;
            letter-spacing: 4px;
            margin: 0;
            text-transform: uppercase;
        }

        /* Recipient Name Area */
        .recipient-box {
            text-align: center;
            margin-top: 4mm;
            position: relative;
        }
        .given-to-container {
            text-align: center;
            margin-bottom: 3px;
        }
        .given-to {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 11pt;
            color: #556270;
            vertical-align: middle;
        }
        .recipient-name {
            font-family: 'Great Vibes', cursive;
            font-weight: 400;
            color: #14213D;
            margin: 2px 0;
            line-height: 1.1;
        }

        /* Description text */
        .description-box {
            text-align: center;
            max-width: 82%;
            margin: 4mm auto;
        }
        .description-text {
            font-family: 'Poppins', sans-serif;
            font-size: 9.5pt;
            line-height: 1.65;
            color: #334155;
            margin: 0;
        }
        .highlight-text {
            color: #C89B3C;
            font-weight: bold;
        }

        /* Footer Table absolute layout */
        .footer-table {
            position: absolute;
            top: 154mm;
            left: 18mm;
            width: 261mm;
            border-collapse: collapse;
            z-index: 15;
        }
        .footer-qr-cell {
            width: 30%;
            vertical-align: middle;
            text-align: left;
        }
        .footer-center-cell {
            width: 40%;
            vertical-align: middle;
            text-align: center;
        }
        .footer-meta-cell {
            width: 30%;
            vertical-align: middle;
            text-align: right;
        }

        .qr-code-border {
            border: 1px solid #C89B3C;
            padding: 3px;
            background: #ffffff;
            display: inline-block;
            border-radius: 4px;
        }
        .qr-code-img {
            width: 48px;
            height: 48px;
            display: block;
        }
        .qr-help-text {
            font-family: 'Poppins', sans-serif;
            font-size: 6.5pt;
            color: #556270;
            margin-top: 3px;
        }

        .meta-title {
            font-family: 'Poppins', sans-serif;
            font-size: 7.5pt;
            color: #556270;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .meta-val-nomor {
            font-family: 'Poppins', sans-serif;
            font-size: 9.5pt;
            font-weight: bold;
            color: #14213D;
            margin-bottom: 4px;
        }
        .meta-val-tanggal {
            font-family: 'Poppins', sans-serif;
            font-size: 9.5pt;
            font-weight: bold;
            color: #14213D;
        }
    </style>
</head>
<body>

    @php
        // Helper to resolve paths to absolute local paths for DomPDF rendering stability
        $get_local_path = function($path) {
            if ($path && file_exists(storage_path('app/public/' . $path))) {
                return storage_path('app/public/' . $path);
            } elseif ($path && file_exists(public_path($path))) {
                return public_path($path);
            }
            return null;
        };

        // Determine template background image
        $bg_image = null;
        if ($certificate->background_path) {
            $bg_image = $get_local_path($certificate->background_path);
        } elseif ($certificate->template && $certificate->template->background_path) {
            $bg_image = $get_local_path($certificate->template->background_path);
        }

        // Resolve school logo
        $logo_file = $get_local_path($certificate->logo_sekolah);
        $logo_data = $logo_file ? \App\Models\Certificate::removeWhiteBackground($logo_file) : null;

        // Generate verification URL
        $verify_url = route('verify', $certificate->code);

        // Generate SVG base64 QR Code directly inside page rendering
        $qrCodeSvg = QrCode::format('svg')->size(100)->margin(1)->generate($verify_url);
        $qrCodeSvg = str_replace('<?xml version="1.0" encoding="UTF-8"?>', '', $qrCodeSvg);
        $qr_base64 = 'data:image/svg+xml;base64,' . base64_encode($qrCodeSvg);

        // Dynamic Name Casing: Title Case matching mockup
        $title_cased_name = ucwords(strtolower($certificate->nama_siswa));
        $name_length = strlen($title_cased_name);
        $prestasi_len = strlen($certificate->prestasi ?? '');

        // Responsive font-size scaling based on both name length and description density
        $fs = '38pt';
        if ($prestasi_len > 180) {
            if ($name_length > 35) {
                $fs = '20pt';
            } elseif ($name_length > 25) {
                $fs = '24pt';
            } else {
                $fs = '28pt';
            }
        } elseif ($prestasi_len > 120) {
            if ($name_length > 35) {
                $fs = '22pt';
            } elseif ($name_length > 25) {
                $fs = '26pt';
            } else {
                $fs = '30pt';
            }
        } else {
            if ($name_length > 40) {
                $fs = '22pt';
            } elseif ($name_length > 30) {
                $fs = '26pt';
            } elseif ($name_length > 20) {
                $fs = '32pt';
            }
        }

        // Fallback for school name setting if empty/null
        $sekolah_name = \App\Models\Setting::get('sekolah_default');
        if (empty($sekolah_name)) {
            $sekolah_name = 'Lembaga Pendidikan Sertifikasi Ekstrakurikuler';
        }
    @endphp

    <div class="certificate-container">

        <!-- Render Background Template or Elegant Custom Frame -->
        @if($bg_image)
            <img class="bg-template" src="{{ $bg_image }}" alt="Background Template">
        @else
            <!-- Navy Swoop Top-Right -->
            <svg viewBox="0 0 400 300" style="position: absolute; top: 0; right: 0; width: 110mm; height: 82.5mm; z-index: 1;">
                <path d="M 180,0 C 270,10 350,90 400,180 L 400,0 Z" fill="#14213D" />
                <path d="M 180,0 C 270,10 350,90 400,180" fill="none" stroke="#C89B3C" stroke-width="4" />
                <path d="M 160,0 C 250,10 330,90 380,180" fill="none" stroke="#C89B3C" stroke-width="1.5" />
            </svg>

            <!-- Navy Swoop Bottom-Left -->
            <svg viewBox="0 0 400 300" style="position: absolute; bottom: 0; left: 0; width: 110mm; height: 82.5mm; z-index: 1;">
                <path d="M 0,120 C 50,210 130,290 220,300 L 0,300 Z" fill="#14213D" />
                <path d="M 0,120 C 50,210 130,290 220,300" fill="none" stroke="#C89B3C" stroke-width="4" />
                <path d="M 0,100 C 60,190 140,280 240,300" fill="none" stroke="#C89B3C" stroke-width="1.5" />
            </svg>

            <!-- Elegant Frame Borders -->
            <div class="border-outer"></div>
            <div class="border-inner"></div>

            <!-- Geometric Corner Patterns -->
            <div class="corner-pattern-tl">
                <svg width="24" height="24" viewBox="0 0 24 24">
                    <path d="M 0,24 L 0,0 L 24,0 M 4,24 L 4,4 L 24,4 M 8,8 L 16,8 L 16,16 L 8,16" fill="none" stroke="#C89B3C" stroke-width="1" />
                </svg>
            </div>
            <div class="corner-pattern-tr">
                <svg width="24" height="24" viewBox="0 0 24 24">
                    <path d="M 0,24 L 0,0 L 24,0 M 4,24 L 4,4 L 24,4 M 8,8 L 16,8 L 16,16 L 8,16" fill="none" stroke="#C89B3C" stroke-width="1" />
                </svg>
            </div>
            <div class="corner-pattern-br">
                <svg width="24" height="24" viewBox="0 0 24 24">
                    <path d="M 0,24 L 0,0 L 24,0 M 4,24 L 4,4 L 24,4 M 8,8 L 16,8 L 16,16 L 8,16" fill="none" stroke="#C89B3C" stroke-width="1" />
                </svg>
            </div>
            <div class="corner-pattern-bl">
                <svg width="24" height="24" viewBox="0 0 24 24">
                    <path d="M 0,24 L 0,0 L 24,0 M 4,24 L 4,4 L 24,4 M 8,8 L 16,8 L 16,16 L 8,16" fill="none" stroke="#C89B3C" stroke-width="1" />
                </svg>
            </div>
        @endif

        <div class="content">
            <!-- Header section -->
            <table class="header-table">
                <tr>
                    <td class="header-logo-cell">
                        @if($logo_data)
                            <img src="{{ $logo_data }}" style="max-height: 44px; width: auto;" alt="Logo">
                        @else
                            <div style="width: 44px;"></div>
                        @endif
                    </td>
                    <td class="header-text-cell">
                        <h1 class="school-name">{{ $sekolah_name }}</h1>
                        <p class="school-sub">Sertifikat Resmi Kegiatan Peserta Didik</p>
                    </td>
                    <td class="header-seal-cell">
                        <div style="width: 44px; height: 44px; display: inline-block;">
                            <svg width="44" height="44" viewBox="0 0 100 100">
                                <circle cx="50" cy="50" r="45" fill="#C89B3C" />
                                <circle cx="50" cy="50" r="39" fill="#FCFAF5" />
                                <circle cx="50" cy="50" r="34" fill="#C89B3C" />
                                <polygon points="50,22 55,39 73,41 59,53 63,70 50,60 37,70 41,53 27,41 45,39" fill="#14213D" />
                            </svg>
                        </div>
                    </td>
                </tr>
            </table>

            <!-- Decorative horizontal gold divider under the header -->
            <div style="text-align: center; margin-top: 2mm;">
                <svg width="120" height="8" viewBox="0 0 120 8" style="display: inline-block;">
                    <line x1="0" y1="4" x2="52" y2="4" stroke="#C89B3C" stroke-width="0.75" />
                    <polygon points="60,1 63,4 60,7 57,4" fill="#C89B3C" />
                    <line x1="68" y1="4" x2="120" y2="4" stroke="#C89B3C" stroke-width="0.75" />
                </svg>
            </div>

            <!-- Title Section with ornaments above and below -->
            <div class="title-box">
                <!-- Decorative gold ornament above title -->
                <div style="text-align: center; margin-bottom: 1.5mm;">
                    <svg width="40" height="6" viewBox="0 0 80 8" style="display: inline-block;">
                        <line x1="0" y1="4" x2="32" y2="4" stroke="#C89B3C" stroke-width="0.5" />
                        <polygon points="40,2 43,4 40,6 37,4" fill="#C89B3C" />
                        <line x1="48" y1="4" x2="80" y2="4" stroke="#C89B3C" stroke-width="0.5" />
                    </svg>
                </div>
                <h2 class="certificate-title">Sertifikat</h2>
                <div class="subtitle-container">
                    <span class="certificate-subtitle">{{ strtoupper($certificate->jenis_sertifikat) }}</span>
                </div>
                <!-- Decorative gold ornament below title -->
                <div style="text-align: center; margin-top: 1.5mm;">
                    <svg width="40" height="6" viewBox="0 0 80 8" style="display: inline-block;">
                        <line x1="0" y1="4" x2="32" y2="4" stroke="#C89B3C" stroke-width="0.5" />
                        <polygon points="40,2 43,4 40,6 37,4" fill="#C89B3C" />
                        <line x1="48" y1="4" x2="80" y2="4" stroke="#C89B3C" stroke-width="0.5" />
                    </svg>
                </div>
            </div>

            <!-- Recipient Information -->
            <div class="recipient-box">
                <!-- Subtle laurel wreath watermark behind the recipient name -->
                <div style="position: absolute; top: 50%; left: 50%; margin-top: -65px; margin-left: -100px; width: 200px; height: 130px; z-index: -1; opacity: 0.08;">
                    <svg viewBox="0 0 200 130" width="100%" height="100%">
                        <!-- Left branch -->
                        <path d="M 90,110 C 50,100 20,70 20,40 C 20,20 40,10 60,5" fill="none" stroke="#C89B3C" stroke-width="2" />
                        <path d="M 23,60 C 13,55 5,55 -2,60 C 3,63 13,63 23,60 Z" fill="#C89B3C" />
                        <path d="M 21,45 C 11,40 3,40 -4,45 C 1,48 11,48 21,45 Z" fill="#C89B3C" />
                        <path d="M 25,30 C 15,25 7,25 0,30 C 5,33 15,33 25,30 Z" fill="#C89B3C" />
                        <!-- Right branch -->
                        <path d="M 110,110 C 150,100 180,70 180,40 C 180,20 160,10 140,5" fill="none" stroke="#C89B3C" stroke-width="2" />
                        <path d="M 177,60 C 187,55 195,55 202,60 C 197,63 187,63 177,60 Z" fill="#C89B3C" />
                        <path d="M 179,45 C 189,40 197,40 204,45 C 199,48 189,48 179,45 Z" fill="#C89B3C" />
                        <path d="M 175,30 C 185,25 193,25 200,30 C 195,33 185,33 175,30 Z" fill="#C89B3C" />
                    </svg>
                </div>

                <div class="given-to-container">
                    <!-- Symmetrical ornaments flanking header -->
                    <svg width="18" height="10" viewBox="0 0 24 12" style="display: inline-block; vertical-align: middle; margin-right: 6px;">
                        <path d="M 24,6 Q 12,0 0,6 Q 12,12 24,6 M 18,6 Q 12,3 6,6" fill="none" stroke="#C89B3C" stroke-width="1.2" />
                    </svg>
                    <span class="given-to">Dengan bangga diberikan kepada:</span>
                    <svg width="18" height="10" viewBox="0 0 24 12" style="display: inline-block; vertical-align: middle; margin-left: 6px; transform: scaleX(-1);">
                        <path d="M 24,6 Q 12,0 0,6 Q 12,12 24,6 M 18,6 Q 12,3 6,6" fill="none" stroke="#C89B3C" stroke-width="1.2" />
                    </svg>
                </div>
                
                <h3 class="recipient-name" style="font-size: {{ $fs }};">{{ $title_cased_name }}</h3>
                
                <!-- Thin gold divider below the recipient name -->
                <div style="text-align: center; margin-top: 1mm; margin-bottom: 2mm;">
                    <svg width="40" height="8" viewBox="0 0 40 8" style="display: inline-block;">
                        <line x1="0" y1="4" x2="16" y2="4" stroke="#C89B3C" stroke-width="0.75" />
                        <polygon points="20,1 24,4 20,7 16,4" fill="#C89B3C" />
                        <line x1="24" y1="4" x2="40" y2="4" stroke="#C89B3C" stroke-width="0.75" />
                    </svg>
                </div>
            </div>

            <!-- Description Text with highlighted achievement typography -->
            <div class="description-box">
                <p class="description-text">
                    @php
                        // Highlight text within quotes by wrapping with highlight span
                        $desc = e($certificate->prestasi);
                        $desc = preg_replace('/&quot;(.*?)&quot;/', '<span class="highlight-text">"$1"</span>', $desc);
                        $desc = preg_replace('/"(.*?)"/', '<span class="highlight-text">"$1"</span>', $desc);
                    @endphp
                    {!! nl2br($desc) !!}
                </p>
            </div>

            <!-- Symmetrical Olive Branch + Book Badge at Bottom-Center -->
            <div style="text-align: center; margin-top: 2.5mm; z-index: 12; position: relative;">
                <svg width="240" height="40" viewBox="0 0 240 40" style="display: inline-block; vertical-align: middle;">
                    <!-- Left branch -->
                    <path d="M 90,20 Q 50,15 20,25" fill="none" stroke="#C89B3C" stroke-width="1.2" />
                    <path d="M 80,19 C 75,15 70,15 65,17 C 70,20 75,20 80,19 Z" fill="#C89B3C" />
                    <path d="M 65,17 C 60,13 55,13 50,15 C 55,18 60,18 65,17 Z" fill="#C89B3C" />
                    <path d="M 50,15 C 45,11 40,11 35,13 C 40,16 45,16 50,15 Z" fill="#C89B3C" />
                    <path d="M 75,18 C 72,12 67,10 62,12 C 66,16 70,17 75,18 Z" fill="#C89B3C" />
                    <path d="M 60,16 C 57,10 52,8 47,10 C 51,14 55,15 60,16 Z" fill="#C89B3C" />
                    
                    <!-- Right branch -->
                    <path d="M 150,20 Q 190,15 220,25" fill="none" stroke="#C89B3C" stroke-width="1.2" />
                    <path d="M 160,19 C 165,15 170,15 175,17 C 170,20 165,20 160,19 Z" fill="#C89B3C" />
                    <path d="M 175,17 C 180,13 185,13 190,15 C 185,18 180,18 175,17 Z" fill="#C89B3C" />
                    <path d="M 190,15 C 195,11 200,11 205,13 C 200,16 195,16 190,15 Z" fill="#C89B3C" />
                    <path d="M 165,18 C 168,12 173,10 178,12 C 174,16 170,17 165,18 Z" fill="#C89B3C" />
                    <path d="M 180,16 C 183,10 188,8 193,12 C 189,14 185,15 180,16 Z" fill="#C89B3C" />

                    <!-- Central Badge Circle -->
                    <circle cx="120" cy="20" r="14" fill="#FCFAF5" stroke="#C89B3C" stroke-width="1.2" />
                    <circle cx="120" cy="20" r="11" fill="none" stroke="#C89B3C" stroke-width="0.5" />
                    <!-- Book Icon -->
                    <path d="M 119,16 Q 116,18 113,16 L 113,22 Q 116,24 119,22 Z" fill="none" stroke="#14213D" stroke-width="1" />
                    <path d="M 121,16 Q 124,18 127,16 L 127,22 Q 124,24 121,22 Z" fill="none" stroke="#14213D" stroke-width="1" />
                    <line x1="120" y1="16" x2="120" y2="22" stroke="#14213D" stroke-width="1" />
                </svg>
            </div>
        </div>

        <!-- Bottom Section -->
        <table class="footer-table">
            <tr>
                <!-- Left: QR Code and verifikasi text -->
                <td class="footer-qr-cell">
                    <div class="qr-code-border">
                        <img class="qr-code-img" src="{{ $qr_base64 }}" alt="QR Code">
                    </div>
                    <div class="qr-help-text">Scan untuk Verifikasi</div>
                </td>

                <!-- Center: Decorative horizontal gold ornament only (NO signature) -->
                <td class="footer-center-cell">
                    <svg width="120" height="24" viewBox="0 0 120 24" style="display: inline-block;">
                        <path d="M 10,12 C 30,2 40,22 60,12 C 80,2 90,22 110,12" fill="none" stroke="#C89B3C" stroke-width="1" />
                        <circle cx="60" cy="12" r="4" fill="#C89B3C" />
                        <polygon points="60,2 64,8 60,10 56,8" fill="#C89B3C" />
                        <polygon points="60,22 64,16 60,14 56,16" fill="#C89B3C" />
                    </svg>
                </td>

                <!-- Right: Number, Issue Date and meta details -->
                <td class="footer-meta-cell">
                    <div class="meta-title">Nomor Sertifikat</div>
                    <div class="meta-val-nomor">{{ $certificate->nomor_sertifikat }}</div>
                    
                    <!-- Elegant diamond divider line -->
                    <svg width="120" height="8" viewBox="0 0 120 8" style="display: block; margin: 4px 0 4px auto;">
                        <line x1="0" y1="4" x2="52" y2="4" stroke="#C89B3C" stroke-width="0.75" />
                        <polygon points="60,0 64,4 60,8 56,4" fill="#C89B3C" />
                        <line x1="68" y1="4" x2="120" y2="4" stroke="#C89B3C" stroke-width="0.75" />
                    </svg>

                    <div class="meta-title">Diterbitkan pada</div>
                    <div class="meta-val-tanggal">{{ $certificate->tanggal->translatedFormat('d F Y') }}</div>
                </td>
            </tr>
        </table>

    </div>

</body>
</html>
