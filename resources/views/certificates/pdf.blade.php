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
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #FCFBF7; /* Soft Canva cream background */
            color: #1E293B; /* Slate dark text */
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
            width: 297mm;
            height: 210mm;
            z-index: 1;
        }

        /* Content Wrapper */
        .content {
            position: absolute;
            top: 22mm;
            left: 28mm;
            width: 241mm; /* 297mm - (28mm * 2) */
            z-index: 10;
            text-align: center;
        }

        /* Elegant Double Border Frame */
        .border-outer {
            position: absolute;
            top: 8mm;
            left: 8mm;
            right: 8mm;
            bottom: 8mm;
            border: 2pt solid #D4AF37; /* Gold outer frame */
            z-index: 5;
            pointer-events: none;
        }
        .border-inner {
            position: absolute;
            top: 10.5mm;
            left: 10.5mm;
            right: 10.5mm;
            bottom: 10.5mm;
            border: 1pt solid #0F172A; /* Thin navy inner frame */
            z-index: 5;
            pointer-events: none;
        }

        /* Small Elegant Corner Brackets */
        .corner-accent-tl {
            position: absolute;
            top: 13mm;
            left: 13mm;
            width: 12mm;
            height: 12mm;
            border-top: 2.5pt solid #D4AF37;
            border-left: 2.5pt solid #D4AF37;
            z-index: 6;
        }
        .corner-accent-tr {
            position: absolute;
            top: 13mm;
            right: 13mm;
            width: 12mm;
            height: 12mm;
            border-top: 2.5pt solid #D4AF37;
            border-right: 2.5pt solid #D4AF37;
            z-index: 6;
        }
        .corner-accent-bl {
            position: absolute;
            bottom: 13mm;
            left: 13mm;
            width: 12mm;
            height: 12mm;
            border-bottom: 2.5pt solid #D4AF37;
            border-left: 2.5pt solid #D4AF37;
            z-index: 6;
        }
        .corner-accent-br {
            position: absolute;
            bottom: 13mm;
            right: 13mm;
            width: 12mm;
            height: 12mm;
            border-bottom: 2.5pt solid #D4AF37;
            border-right: 2.5pt solid #D4AF37;
            z-index: 6;
        }

        /* Gold thin border lines around the certificate page */
        .border-gold-frame {
            position: absolute;
            top: 10mm;
            left: 10mm;
            right: 10mm;
            bottom: 10mm;
            border: 1.5pt solid #D4AF37;
            border-radius: 3pt;
            z-index: 5;
            pointer-events: none;
        }

        /* Header Section */
        .header {
            margin-bottom: 6mm;
            width: 100%;
            display: table;
        }
        .header-logo {
            display: table-cell;
            width: 18%;
            vertical-align: middle;
            text-align: left;
        }
        .header-text {
            display: table-cell;
            width: 64%;
            vertical-align: middle;
            text-align: center;
        }
        .header-medal {
            display: table-cell;
            width: 18%;
            vertical-align: middle;
            text-align: right;
        }

        .school-name {
            font-family: 'Georgia', 'Times New Roman', serif;
            font-size: 18pt;
            font-weight: bold;
            color: #0F172A;
            margin: 0;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        
        .school-sub {
            font-size: 9.5pt;
            color: #64748B;
            margin: 3px 0 0 0;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 600;
        }

        /* Title Area */
        .certificate-title-box {
            margin: 4mm 0 6mm 0;
        }

        .certificate-title {
            font-family: 'Georgia', 'Times New Roman', serif;
            font-size: 34pt;
            font-weight: 700;
            color: #0F172A;
            margin: 0;
            letter-spacing: 4px;
            text-transform: uppercase;
        }

        .certificate-subtitle {
            font-size: 11pt;
            color: #D4AF37;
            margin: 4px 0 0 0;
            letter-spacing: 5px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .recipient-label {
            font-family: 'Georgia', 'Times New Roman', serif;
            font-size: 12pt;
            color: #64748B;
            font-style: italic;
            margin: 4mm 0 2mm 0;
        }
        
        .recipient-name-box {
            margin: 1mm 0 1mm 0;
        }

        .recipient-name {
            font-family: 'Georgia', 'Times New Roman', serif;
            font-size: 32pt;
            font-weight: bold;
            color: #0F172A;
            display: inline-block;
            margin: 0;
            letter-spacing: 1px;
        }

        .gold-divider {
            width: 140mm;
            height: 1.5px;
            background-color: #D4AF37;
            margin: 6px auto;
        }

        .recipient-nis {
            font-size: 11.5pt;
            color: #475569;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-top: 1mm;
        }

        /* Description text */
        .description {
            font-size: 13pt;
            line-height: 1.8;
            color: #334155;
            margin: 6mm auto;
            max-width: 85%;
            font-weight: 400;
        }
        
        .ekskul-name {
            font-weight: bold;
            color: #0F172A;
            font-size: 13.5pt;
        }
        
        .prestasi-name {
            font-weight: bold;
            color: #D4AF37;
            font-size: 13.5pt;
        }

        /* Footer Section */
        .footer-table {
            width: 100%;
            margin-top: 8mm;
            display: table;
        }
        .footer-cell-left {
            display: table-cell;
            width: 32%;
            vertical-align: bottom;
            text-align: left;
        }
        .footer-cell-center {
            display: table-cell;
            width: 36%;
            vertical-align: bottom;
            text-align: center;
            font-size: 8.5pt;
            color: #64748B;
            line-height: 1.5;
        }
        .footer-cell-right {
            display: table-cell;
            width: 32%;
            vertical-align: bottom;
            text-align: right;
            font-size: 9.5pt;
        }

        .qr-code-img {
            border: 1.5pt solid #D4AF37;
            padding: 2.5pt;
            background: #fff;
            width: 22mm;
            height: 22mm;
        }

        .signature-container {
            position: relative;
            height: 15mm;
            margin-bottom: 1.5mm;
        }

        .signature-img {
            max-height: 15mm;
            width: auto;
            display: block;
            margin-left: auto;
        }

        .pembina-title {
            color: #64748B;
            font-size: 9.5pt;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }

        .pembina-name {
            font-family: 'Georgia', 'Times New Roman', serif;
            font-weight: bold;
            color: #0F172A;
            font-size: 12pt;
            margin-top: 4px;
        }

        /* Gold Seal Badge Replica inside CSS */
        .gold-seal-badge {
            width: 16mm;
            height: 16mm;
            background: radial-gradient(circle, #f39c12, #D4AF37);
            border-radius: 50%;
            position: relative;
            display: inline-block;
            box-shadow: 0 3pt 8pt rgba(0,0,0,0.15);
            border: 1.5pt dashed #FFFFFF;
        }

        .gold-seal-inner {
            position: absolute;
            top: 1mm;
            left: 1mm;
            right: 1mm;
            bottom: 1mm;
            border: 0.8pt solid rgba(255,255,255,0.7);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .gold-seal-inner span {
            color: #FFFFFF;
            font-size: 14pt;
            font-weight: bold;
        }
    </style>
</head>
<body>

    @php
        // Helper inline path generator for DomPDF (uses absolute local path for speed and stability)
        $get_local_path = function($path) {
            if ($path && file_exists(storage_path('app/public/' . $path))) {
                return storage_path('app/public/' . $path);
            }
            return null;
        };

        // Determine background template
        $bg_image = null;
        if ($certificate->background_path) {
            $bg_image = $get_local_path($certificate->background_path);
        } elseif ($certificate->template && $certificate->template->background_path) {
            $bg_image = $get_local_path($certificate->template->background_path);
        }

        // Determine logo and signature
        $logo_data = $get_local_path($certificate->logo_sekolah);
        $sig_data = $get_local_path($certificate->tanda_tangan);

        // Generate dynamic QR Code URL accessible by other devices
        $verify_url = route('verify', $certificate->code);
        $host = request()->getHost();
        if ($host === 'localhost' || $host === '127.0.0.1') {
            $localIp = gethostbyname(gethostname());
            if ($localIp && $localIp !== '127.0.0.1' && $localIp !== 'localhost') {
                $port = request()->getPort();
                $verify_url = 'http://' . $localIp . ($port ? ':' . $port : '') . '/verify/' . $certificate->code;
            }
        }

        // Generate QR Code Base64 SVG (runs everywhere, no Imagick required!)
        $qrCodeSvg = QrCode::format('svg')->size(100)->margin(1)->generate($verify_url);
        $qrCodeSvg = str_replace('<?xml version="1.0" encoding="UTF-8"?>', '', $qrCodeSvg);
        $qr_base64 = 'data:image/svg+xml;base64,' . base64_encode($qrCodeSvg);
    @endphp

    <div class="certificate-container">
        
        <!-- Render Background Template Image if active, otherwise render elegant frames -->
        @if($bg_image)
            <img class="bg-template" src="{{ $bg_image }}" alt="Background">
        @else
            <!-- Elegant Double Border Frame -->
            <div class="border-outer"></div>
            <div class="border-inner"></div>

            <!-- Small Elegant Corner Brackets -->
            <div class="corner-accent-tl"></div>
            <div class="corner-accent-tr"></div>
            <div class="corner-accent-bl"></div>
            <div class="corner-accent-br"></div>
        @endif

        <div class="content">
            <!-- Header -->
            <div class="header">
                <div class="header-logo">
                    @if($logo_data)
                        <img src="{{ $logo_data }}" style="max-height: 14mm; width: auto;" alt="Logo Sekolah">
                    @endif
                </div>
                <div class="header-text">
                    <h1 class="school-name">{{ $certificate->sekolah }}</h1>
                    <p class="school-sub">Hasil Penilaian Kegiatan Ekstrakurikuler Mandiri</p>
                </div>
                <div class="header-medal">
                    <!-- Gold Seal Medal Icon on Right -->
                    <div class="gold-seal-badge">
                        <div class="gold-seal-inner">
                            <span>★</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Title Area -->
            <div class="certificate-title-box">
                <h2 class="certificate-title">Sertifikat</h2>
                <p class="certificate-subtitle">{{ $certificate->jenis_sertifikat }}</p>
            </div>

            <p class="recipient-label">Diberikan Kepada:</p>
            <div class="recipient-name-box">
                @php
                    $name_length = strlen($certificate->nama_siswa);
                    $font_size = '32pt';
                    if ($name_length > 30) {
                        $font_size = '20pt';
                    } elseif ($name_length > 20) {
                        $font_size = '26pt';
                    }
                @endphp
                <h3 class="recipient-name" style="font-size: {{ $font_size }};">{{ strtoupper($certificate->nama_siswa) }}</h3>
            </div>
            <div class="gold-divider"></div>
            <p class="recipient-nis">NIS. {{ $certificate->nis }} &nbsp;|&nbsp; KELAS: {{ strtoupper($certificate->kelas) }}</p>

            <!-- Description -->
            <p class="description">
                Telah menyelesaikan dan berpartisipasi aktif dalam kegiatan ekstrakurikuler 
                <span class="ekskul-name">{{ $certificate->ekskul }}</span> dengan pencapaian prestasi luar biasa sebagai 
                <span class="prestasi-name">"{{ $certificate->prestasi ?? 'Anggota/Peserta Aktif' }}"</span> pada tahun pelajaran {{ date('Y') }}.
            </p>

            <!-- Footer Details -->
            <div class="footer-table">
                <!-- QR Code cell -->
                <div class="footer-cell-left">
                    <img class="qr-code-img" src="{{ $qr_base64 }}" alt="QR Code Verifikasi">
                    <div style="font-size: 6.5pt; color: #64748B; margin-top: 4px; letter-spacing: 0.5px; font-weight: 500;">Pindai untuk validasi sertifikat</div>
                </div>

                <!-- Meta Details -->
                <div class="footer-cell-center">
                    <div style="font-weight: bold; color: #0F172A; font-size: 9pt;">No: {{ $certificate->nomor_sertifikat }}</div>
                    <div style="margin-top: 2px;">Kode Verifikasi: <strong style="color: #E74C3C; font-size: 9.5pt;">{{ $certificate->code }}</strong></div>
                    <div style="margin-top: 6px; font-size: 7.5pt; text-transform: uppercase; letter-spacing: 1px;">Diterbitkan pada tanggal:</div>
                    <div style="font-weight: bold; color: #0F172A; font-size: 8.5pt;">{{ $certificate->tanggal->translatedFormat('d F Y') }}</div>
                </div>

                <!-- Signature cell -->
                <div class="footer-cell-right">
                    <div class="pembina-title">{{ $certificate->jabatan_pembina }}</div>
                    <div class="signature-container">
                        @if($sig_data)
                            <img class="signature-img" src="{{ $sig_data }}" alt="Tanda Tangan">
                        @endif
                    </div>
                    <div class="pembina-name">{{ $certificate->nama_pembina }}</div>
                </div>
            </div>

        </div>

    </div>

</body>
</html>
