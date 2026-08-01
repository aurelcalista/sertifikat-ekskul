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
            background-color: #FCFBF7;
            color: #1E293B;
            -webkit-print-color-adjust: exact;
        }

        /* Container Certificate */
        .certificate-container {
            width: 297mm;
            height: 210mm;
            box-sizing: border-box;
            position: relative;
            background-color: #FCFBF7;
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
            top: 15mm;
            left: 18mm;
            right: 18mm;
            height: 130mm;
            z-index: 10;
        }

        /* Elegant Double Border Frame */
        .border-outer {
            position: absolute;
            top: 6mm;
            left: 6mm;
            right: 6mm;
            bottom: 6mm;
            border: 1.5pt solid #D4AF37;
            z-index: 2;
        }
        .border-inner {
            position: absolute;
            top: 9mm;
            left: 9mm;
            right: 9mm;
            bottom: 9mm;
            border: 0.5pt solid #0F172A;
            z-index: 2;
        }

        /* Small Corner Accents */
        .corner-accent-tl {
            position: absolute;
            top: 11mm;
            left: 11mm;
            width: 10mm;
            height: 10mm;
            border-top: 1.8pt solid #D4AF37;
            border-left: 1.8pt solid #D4AF37;
            z-index: 3;
        }
        .corner-accent-tr {
            position: absolute;
            top: 11mm;
            right: 11mm;
            width: 10mm;
            height: 10mm;
            border-top: 1.8pt solid #D4AF37;
            border-right: 1.8pt solid #D4AF37;
            z-index: 3;
        }
        .corner-accent-bl {
            position: absolute;
            bottom: 11mm;
            left: 11mm;
            width: 10mm;
            height: 10mm;
            border-bottom: 1.8pt solid #D4AF37;
            border-left: 1.8pt solid #D4AF37;
            z-index: 3;
        }
        .corner-accent-br {
            position: absolute;
            bottom: 11mm;
            right: 11mm;
            width: 10mm;
            height: 10mm;
            border-bottom: 1.8pt solid #D4AF37;
            border-right: 1.8pt solid #D4AF37;
            z-index: 3;
        }

        /* Header Table layout */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 1px solid #e8d5a3;
            padding-bottom: 5px;
        }
        .header-logo-cell {
            width: 50px;
            vertical-align: middle;
        }
        .header-text-cell {
            text-align: center;
            vertical-align: middle;
        }
        .header-seal-cell {
            width: 50px;
            text-align: right;
            vertical-align: middle;
        }

        .school-name {
            font-size: 11pt;
            font-weight: bold;
            color: #334155;
            margin: 0;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .school-sub {
            font-size: 7.5pt;
            color: #94A3B8;
            margin: 1px 0 0 0;
            letter-spacing: 0.5px;
        }

        .gold-seal-badge {
            width: 44px;
            height: 44px;
            border: 1.5pt dashed #FFFFFF;
            border-radius: 50%;
            background: #D4AF37;
            display: inline-block;
            text-align: center;
        }
        .gold-seal-inner {
            margin: 2px;
            border: 0.5pt solid rgba(255,255,255,0.7);
            border-radius: 50%;
            height: 38px;
            line-height: 38px;
        }
        .gold-seal-inner span {
            color: #FFFFFF;
            font-size: 11pt;
            font-weight: bold;
        }

        /* Ornament styling */
        .top-ornament {
            text-align: center;
            margin-top: 4px;
            color: #D4AF37;
            font-size: 8pt;
            letter-spacing: 6px;
        }

        /* Title Area */
        .title-box {
            text-align: center;
            margin-bottom: 2px;
        }
        .certificate-title {
            font-family: 'Cormorant Garamond', 'Georgia', serif;
            font-size: 28pt;
            font-weight: 700;
            color: #0F172A;
            margin: 0;
            letter-spacing: 5px;
            text-transform: uppercase;
        }
        .certificate-subtitle {
            font-size: 8.5pt;
            color: #D4AF37;
            font-weight: bold;
            letter-spacing: 4px;
            margin: 1px 0 0 0;
            text-transform: uppercase;
        }

        /* Recipient Name Area */
        .recipient-box {
            text-align: center;
            margin-top: 4px;
        }
        
        .gold-rule-container {
            width: 70%;
            margin: 4px auto;
            text-align: center;
            font-size: 8pt;
            color: #D4AF37;
        }
        .gold-rule-line {
            display: inline-block;
            width: 45%;
            height: 1px;
            background: #D4AF37;
            vertical-align: middle;
        }
        .gold-rule-diamond {
            display: inline-block;
            width: 6px;
            height: 6px;
            background-color: #D4AF37;
            margin: 0 4px;
            vertical-align: middle;
        }

        .given-to {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 10.5pt;
            color: #64748B;
            margin: 0;
        }
        .recipient-name {
            font-family: 'Great Vibes', cursive;
            font-size: 38pt;
            font-weight: 400;
            color: #1a1a2e;
            margin: 1px 0 0 0;
            line-height: 1.1;
        }
        
        .recipient-line {
            width: 60%;
            height: 1.5px;
            background: #D4AF37;
            margin: 4px auto 2px auto;
        }

        .recipient-nis {
            font-size: 9pt;
            letter-spacing: 0.8px;
            color: #475569;
            font-weight: 600;
            margin: 0;
        }

        /* Badges Table */
        .badges-table {
            margin: 4px auto;
            border-collapse: collapse;
        }
        .badge-cell {
            padding: 2px 10px;
        }
        .badge-ekskul {
            background-color: #FAF6E8;
            border: 1px solid #D4AF37;
            border-radius: 20px;
            font-size: 8pt;
            color: #92600a;
            font-weight: 600;
            padding: 3px 12px;
        }
        .badge-nomor {
            background-color: #F1F5F9;
            border: 1px solid #CBD5E1;
            border-radius: 20px;
            font-size: 8pt;
            color: #475569;
            font-weight: 600;
            padding: 3px 12px;
        }

        /* Description text */
        .description-box {
            text-align: center;
            max-width: 85%;
            margin: 4px auto 4px auto;
        }
        .description-text {
            font-size: 10pt;
            line-height: 1.65;
            color: #334155;
            margin: 0;
        }
        .highlight-text {
            color: #0F172A;
            font-weight: bold;
        }
        .predikat-badge {
            background-color: #FAF6E8;
            padding: 1px 6px;
            border-radius: 4px;
            color: #b5860d;
            font-weight: bold;
        }

        .bottom-ornament {
            text-align: center;
            color: #D4AF37;
            font-size: 7pt;
            margin: 2px 0;
        }

        /* Footer Table absolute layout (Placed directly under container for DomPDF reliability) */
        .footer-table {
            position: absolute;
            top: 148mm;
            left: 18mm;
            width: 261mm;
            border-collapse: collapse;
            z-index: 15;
        }
        .footer-qr-cell {
            width: 25%;
            vertical-align: bottom;
            text-align: left;
        }
        .footer-meta-cell {
            width: 45%;
            vertical-align: bottom;
            text-align: center;
        }
        .footer-signature-cell {
            width: 30%;
            vertical-align: bottom;
            text-align: center;
        }

        .qr-code-border {
            border: 1px solid #D4AF37;
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
            font-size: 6.5pt;
            color: #64748B;
            margin-top: 2px;
        }

        .meta-title {
            font-size: 7.5pt;
            color: #94A3B8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .meta-val-nomor {
            font-size: 9.5pt;
            font-weight: bold;
            color: #0F172A;
        }
        .meta-val-tanggal {
            font-size: 9pt;
            font-weight: bold;
            color: #0F172A;
        }
        .meta-code-val {
            font-size: 7pt;
            color: #94A3B8;
            margin-top: 1px;
        }
        .meta-code-val strong {
            color: #E74C3C;
        }

        .sig-jabatan {
            font-size: 7.5pt;
            color: #64748B;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }
        .sig-image-container {
            height: 38px;
            position: relative;
        }
        .sig-image {
            max-height: 36px;
            width: auto;
            mix-blend-mode: multiply;
            display: block;
            margin: 0 auto;
        }
        .sig-divider {
            border-top: 1.5px solid #0F172A;
            margin: 0 10px 2px 10px;
        }
        .sig-pembina {
            font-weight: bold;
            font-size: 9pt;
            color: #0F172A;
            line-height: 1.3;
        }
        .sig-nip {
            font-size: 6.5pt;
            color: #94A3B8;
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

        // Resolve school logo and signee signature
        $logo_file = $get_local_path($certificate->logo_sekolah);
        $logo_data = $logo_file ? \App\Models\Certificate::removeWhiteBackground($logo_file) : null;

        $sig_file = $get_local_path($certificate->tanda_tangan);
        $sig_data = $sig_file ? \App\Models\Certificate::removeWhiteBackground($sig_file) : null;

        // Generate verification URL
        $verify_url = route('verify', $certificate->code);

        // Generate SVG base64 QR Code directly inside page rendering
        $qrCodeSvg = QrCode::format('svg')->size(100)->margin(1)->generate($verify_url);
        $qrCodeSvg = str_replace('<?xml version="1.0" encoding="UTF-8"?>', '', $qrCodeSvg);
        $qr_base64 = 'data:image/svg+xml;base64,' . base64_encode($qrCodeSvg);

        // Dynamic Name Casing: Title Case matching mockup
        $title_cased_name = ucwords(strtolower($certificate->nama_siswa));
        $name_length = strlen($title_cased_name);

        // Responsive font-size scaling matching preview
        $fs = '38pt';
        if ($name_length > 40) {
            $fs = '22pt';
        } elseif ($name_length > 30) {
            $fs = '26pt';
        } elseif ($name_length > 20) {
            $fs = '32pt';
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
            <!-- Elegant Frame Borders -->
            <div class="border-outer"></div>
            <div class="border-inner"></div>

            <!-- Corner Accents -->
            <div class="corner-accent-tl"></div>
            <div class="corner-accent-tr"></div>
            <div class="corner-accent-bl"></div>
            <div class="corner-accent-br"></div>
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
                        <div class="gold-seal-badge">
                            <div class="gold-seal-inner">
                                <span>*</span>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

            <!-- Decorative Ornament -->
            <div class="top-ornament">* * *</div>

            <!-- Title Area -->
            <div class="title-box">
                <h2 class="certificate-title">Sertifikat</h2>
                <p class="certificate-subtitle">{{ strtoupper($certificate->jenis_sertifikat) }}</p>
            </div>

            <!-- Recipient Information -->
            <div class="recipient-box">
                <!-- Thin Gold rule mimicking mockup styling -->
                <div class="gold-rule-container">
                    <span class="gold-rule-line"></span>
                    <span class="gold-rule-diamond"></span>
                    <span class="gold-rule-line"></span>
                </div>

                <p class="given-to">Dengan bangga diberikan kepada:</p>
                <h3 class="recipient-name" style="font-size: {{ $fs }};">{{ $title_cased_name }}</h3>
                <div class="recipient-line"></div>
                <p class="recipient-nis">NIS. {{ $certificate->nis }}</p>
            </div>

            <!-- Badges Row (Ekskul and Number) using inline elements inside a table to prevent CSS wraps -->
            <table class="badges-table">
                <tr>
                    <td class="badge-cell">
                        <span class="badge-ekskul">Ekskul: <span style="color: #0F172A;">{{ $certificate->ekskul }}</span></span>
                    </td>
                    <td class="badge-cell">
                        @php
                            $yr = $certificate->tanggal->format('Y');
                        @endphp
                        <span class="badge-nomor">Periode: <span style="color: #0F172A;">{{ $yr }}/{{ $yr+1 }}</span></span>
                    </td>
                </tr>
            </table>

            <!-- Description Text -->
            <div class="description-box">
                <p class="description-text">
                    Dinyatakan telah mengikuti dan aktif berprestasi dalam kegiatan Ekstrakurikuler 
                    <span class="highlight-text">{{ $certificate->ekskul }}</span> 
                    dengan predikat 
                    <span class="predikat-badge">"{{ $certificate->prestasi ?? 'Anggota/Peserta Aktif' }}"</span> 
                    pada tahun pelajaran <span class="highlight-text">{{ date('Y') }}/{{ date('Y')+1 }}</span>.
                </p>
            </div>

            <!-- Decorative Bottom Ornament -->
            <div class="bottom-ornament">--- * ---</div>
        </div>

        <!-- Footer Details (QR, Signatures, Meta) placed as direct child for exact rendering coordinate -->
        <table class="footer-table">
            <tr>
                <!-- QR Code -->
                <td class="footer-qr-cell">
                    <div class="qr-code-border">
                        <img class="qr-code-img" src="{{ $qr_base64 }}" alt="QR Code">
                    </div>
                    <div class="qr-help-text">Pindai untuk verifikasi</div>
                </td>

                <!-- Meta Details -->
                <td class="footer-meta-cell">
                    <div class="meta-title">Nomor Sertifikat</div>
                    <div class="meta-val-nomor">{{ $certificate->nomor_sertifikat }}</div>
                    <div class="meta-title" style="margin-top: 4px;">Diterbitkan pada</div>
                    <div class="meta-val-tanggal">{{ $certificate->tanggal->translatedFormat('d F Y') }}</div>
                </td>

                <!-- Signature -->
                <td class="footer-signature-cell">
                    <div class="sig-jabatan">{{ $certificate->jabatan_pembina ?? 'Pembina OSIS' }}</div>
                    <div class="sig-image-container">
                        @if($sig_data)
                            <img class="sig-image" src="{{ $sig_data }}" alt="Signature">
                        @endif
                    </div>
                    <div class="sig-divider"></div>
                    <div class="sig-pembina">{{ $certificate->nama_pembina }}</div>
                    <div class="sig-nip">NIP / NIK</div>
                </td>
            </tr>
        </table>

    </div>

</body>
</html>
