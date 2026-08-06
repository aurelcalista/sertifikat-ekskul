pdf_content = '''<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat - {{ $certificate->nama_siswa }}</title>
    <style>
        @page {
            size: a4 landscape;
            margin: 0px;
        }
        
        html, body {
            margin: 0px;
            padding: 0px;
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
            padding-top: 12mm;
        }

        .title-section {
            text-align: center;
            margin-top: 4mm;
        }
        .cert-title {
            font-family: 'Times-Bold', 'Georgia', serif;
            font-size: 36pt;
            font-weight: bold;
            color: #1F2A44;
            letter-spacing: 8px;
            margin: 0;
            text-transform: uppercase;
        }
        .cert-subtitle {
            font-size: 13pt;
            font-weight: bold;
            color: #F15A3D;
            letter-spacing: 5px;
            margin: 4px 0 8px 0;
            text-transform: uppercase;
        }
        .cert-pill {
            border: 1.5pt solid #1F2A44;
            border-radius: 12px;
            padding: 3px 20px;
            font-size: 9.5pt;
            font-weight: bold;
            color: #1F2A44;
            display: inline-block;
        }

        .recipient-section {
            text-align: center;
            margin-top: 6mm;
        }
        .given-to {
            font-size: 11pt;
            color: #475569;
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
            width: 82%;
            margin: 6mm auto 0 auto;
        }
        .description-text {
            font-size: 10.5pt;
            line-height: 1.6;
            color: #334155;
            margin: 0;
        }
        .highlight-text {
            color: #F15A3D;
            font-weight: bold;
        }

        .footer-table {
            position: absolute;
            bottom: 12mm;
            left: 20mm;
            width: 257mm;
            border-collapse: collapse;
            z-index: 20;
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
            width: 56px;
            height: 56px;
            display: inline-block;
            border: 1.5px solid #CBD5E1;
            padding: 3px;
            border-radius: 6px;
            background-color: #FFFFFF;
        }
    </style>
</head>
<body>

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
        $qrCodeSvg = QrCode::format('svg')->size(150)->margin(1)->generate($verify_url);
        $qrCodeSvg = str_replace('<?xml version="1.0" encoding="UTF-8"?>', '', $qrCodeSvg);
        $qr_base64 = 'data:image/svg+xml;base64,' . base64_encode($qrCodeSvg);

        $upper_name = strtoupper($certificate->nama_siswa);
        $name_length = strlen($upper_name);

        $fs = '30pt';
        if ($name_length > 40) {
            $fs = '18pt';
        } elseif ($name_length > 30) {
            $fs = '22pt';
        } elseif ($name_length > 20) {
            $fs = '26pt';
        }
    @endphp

    <div class="certificate-container">

        <!-- 1. Top-Left Technical Circular Line Pattern -->
        <svg viewBox="0 0 250 250" style="position: absolute; top: 0; left: 0; width: 65mm; height: 65mm; z-index: 2;">
            <g fill="none" stroke="#64748B" stroke-width="1.2" opacity="0.65">
                <circle cx="0" cy="0" r="230" stroke-width="0.7"/>
                <circle cx="0" cy="0" r="210" stroke-dasharray="4,4"/>
                <circle cx="0" cy="0" r="190" stroke-width="1.2"/>
                <circle cx="0" cy="0" r="170"/>
                <circle cx="0" cy="0" r="150" stroke-dasharray="3,3"/>
                <circle cx="0" cy="0" r="130" stroke-width="1.5"/>
                <circle cx="0" cy="0" r="100"/>
                <circle cx="0" cy="0" r="70" stroke-width="0.8"/>
                <line x1="0" y1="0" x2="230" y2="0" stroke-width="1.2"/>
                <line x1="0" y1="0" x2="212" y2="88"/>
                <line x1="0" y1="0" x2="162" y2="162" stroke-width="1.2"/>
                <line x1="0" y1="0" x2="88" y2="212"/>
                <line x1="0" y1="0" x2="0" y2="230" stroke-width="1.2"/>
                <circle cx="212" cy="88" r="3" fill="#64748B"/>
                <circle cx="162" cy="162" r="3" fill="#64748B"/>
                <circle cx="88" cy="212" r="3" fill="#64748B"/>
            </g>
        </svg>

        <!-- 2. Top-Right Orange Geometric Angular Splash -->
        <svg viewBox="0 0 350 300" style="position: absolute; top: 0; right: 0; width: 85mm; height: 72mm; z-index: 2;">
            <g fill="#F15A3D">
                <polygon points="120,0 350,0 350,220 280,180 260,250 210,170 170,220 140,110 80,140 100,50" />
                <polygon points="260,190 350,120 350,270 290,260" fill="#D9482B"/>
                <polygon points="180,210 240,290 280,240 220,180" fill="#FF6B4A"/>
            </g>
        </svg>

        <!-- 3. Left Side Diagonal Gray Lines -->
        <svg viewBox="0 0 60 220" style="position: absolute; top: 38%; left: 4mm; width: 9mm; height: 38mm; z-index: 2;">
            <g stroke="#94A3B8" stroke-width="2.5" stroke-linecap="round">
                <line x1="5" y1="20" x2="55" y2="45" />
                <line x1="5" y1="40" x2="55" y2="65" />
                <line x1="5" y1="60" x2="55" y2="85" />
                <line x1="5" y1="80" x2="55" y2="105" />
                <line x1="5" y1="100" x2="55" y2="125" />
                <line x1="5" y1="120" x2="55" y2="145" />
                <line x1="5" y1="140" x2="55" y2="165" />
                <line x1="5" y1="160" x2="55" y2="185" />
                <line x1="5" y1="180" x2="55" y2="205" />
            </g>
        </svg>

        <!-- 4. Right Side Upward Stacked Chevrons -->
        <svg viewBox="0 0 60 200" style="position: absolute; top: 36%; right: 6mm; width: 10mm; height: 40mm; z-index: 2;">
            <g fill="none" stroke-width="2.5" stroke-linejoin="round" stroke-linecap="round">
                <polyline points="10,35 30,15 50,35" stroke="#F15A3D" />
                <polyline points="10,65 30,45 50,65" stroke="#F15A3D" />
                <polyline points="10,95 30,75 50,95" stroke="#64748B" />
                <polyline points="10,125 30,105 50,125" stroke="#64748B" />
                <polyline points="10,155 30,135 50,155" stroke="#64748B" />
                <polyline points="10,185 30,165 50,185" stroke="#CBD5E1" />
            </g>
        </svg>

        <!-- 5. Bottom Left Corner Diagonal Orange Lines -->
        <svg viewBox="0 0 250 200" style="position: absolute; bottom: 0; left: 0; width: 62mm; height: 48mm; z-index: 2;">
            <g stroke="#F15A3D" stroke-width="2.5" stroke-linecap="round">
                <line x1="0" y1="200" x2="220" y2="20" stroke-width="3.5"/>
                <line x1="0" y1="170" x2="190" y2="10" stroke-width="3"/>
                <line x1="0" y1="140" x2="160" y2="0" stroke-width="2.5"/>
                <line x1="0" y1="110" x2="130" y2="0" stroke-width="2"/>
                <line x1="0" y1="80" x2="90" y2="0" stroke-width="1.5"/>
                <line x1="0" y1="50" x2="50" y2="0" stroke-width="1"/>
            </g>
        </svg>

        <!-- 6. Bottom Right Geometric L-shaped Grain Frame -->
        <svg viewBox="0 0 250 250" style="position: absolute; bottom: 0; right: 0; width: 60mm; height: 60mm; z-index: 2;">
            <g fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path d="M 40,240 L 240,240 L 240,40 M 70,240 L 240,240 L 240,70" stroke="#1E293B" stroke-width="2" />
                <path d="M 10,240 L 240,240 L 240,10" stroke="#F15A3D" stroke-width="2" />
                <path d="M 50,225 L 225,225 L 225,50" stroke="#F15A3D" stroke-width="1.5" />
                <path d="M 80,210 L 160,210 L 160,180 L 180,180 L 180,160 L 210,160 L 210,80" stroke="#F15A3D" stroke-width="1.8" />
                <g stroke="#F15A3D" stroke-width="1.5">
                    <line x1="160" y1="195" x2="85" y2="195" stroke-width="2"/>
                    <path d="M 115,195 Q 105,185 95,195 Q 105,205 115,195 Z" fill="#F15A3D" opacity="0.85"/>
                    <path d="M 130,195 Q 120,185 110,195 Q 120,205 130,195 Z" fill="#F15A3D" opacity="0.85"/>
                    <path d="M 145,195 Q 135,185 125,195 Q 135,205 145,195 Z" fill="#F15A3D" opacity="0.85"/>
                </g>
                <g stroke="#F15A3D" stroke-width="1.5">
                    <line x1="195" y1="160" x2="195" y2="85" stroke-width="2"/>
                    <path d="M 195,115 Q 185,105 195,95 Q 205,105 195,115 Z" fill="#F15A3D" opacity="0.85"/>
                    <path d="M 195,130 Q 185,120 195,110 Q 205,120 195,130 Z" fill="#F15A3D" opacity="0.85"/>
                    <path d="M 195,145 Q 185,135 195,125 Q 205,135 195,145 Z" fill="#F15A3D" opacity="0.85"/>
                </g>
            </g>
        </svg>

        <div class="content-layer">
            <!-- Header Logo -->
            <div class="header-section">
                @if($logo_data)
                    <img src="{{ $logo_data }}" style="max-height: 48px; width: auto;" alt="Logo">
                @else
                    <img src="{{ public_path('logos/logo-rakitai.png') }}" style="max-height: 48px; width: auto;" alt="Logo">
                @endif
            </div>

            <!-- Title & Subtitle -->
            <div class="title-section">
                <h2 class="cert-title">SERTIFIKAT</h2>
                <p class="cert-subtitle">{{ strtoupper($certificate->jenis_sertifikat ?? 'SERTIFIKAT KEIKUTSERTAAN') }}</p>
                
                <div style="text-align: center; margin-top: 3mm;">
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

        <!-- Bottom Footer Table -->
        <table class="footer-table">
            <tr>
                <td class="footer-qr-cell">
                    <img src="{{ $qr_base64 }}" class="qr-code-img" alt="QR Code">
                </td>
                <td class="footer-center-cell">
                    <svg viewBox="0 0 100 130" style="width: 62px; height: 80px; display: inline-block;">
                        <polygon points="42,68 30,130 42,118 50,125" fill="#1E3A8A" />
                        <polygon points="58,68 70,130 58,118 50,125" fill="#2563EB" />
                        <circle cx="50" cy="50" r="40" fill="#8B4513" stroke="#8B6508" stroke-width="1" />
                        <circle cx="50" cy="50" r="37" fill="#FFD700" />
                        <circle cx="50" cy="50" r="33" fill="none" stroke="#B8860B" stroke-width="1.5" />
                        <circle cx="50" cy="50" r="31" fill="#DAA520" />
                        <circle cx="50" cy="50" r="27" fill="none" stroke="#B8860B" stroke-width="0.8" />
                        <ellipse cx="40" cy="38" rx="10" ry="7" fill="#FFF8DC" opacity="0.35" />
                    </svg>
                </td>
                <td class="footer-date-cell">
                    <div style="display: inline-block; text-align: right;">
                        <div style="font-family: 'Times-Italic', 'Georgia', serif; font-size: 12pt; color: #475569; font-style: italic; margin-bottom: 3px;">
                            Diterbitkan pada tanggal
                        </div>
                        <div style="display: inline-block; text-align: right;">
                            <span style="font-size: 8pt; color: #94A3B8;">&#9679; &#9679;</span>
                            <span style="font-size: 12pt; font-weight: bold; color: #0F172A; margin: 0 4px;">
                                {{ $certificate->tanggal->translatedFormat('d F Y') }}
                            </span>
                            <span style="font-size: 8pt; color: #94A3B8;">&#9679; &#9679;</span>
                        </div>
                        <div style="height: 1.5px; background-color: #64748B; margin-top: 4px; width: 100%;"></div>
                    </div>
                </td>
            </tr>
        </table>

    </div>

</body>
</html>
'''

with open('resources/views/certificates/pdf.blade.php', 'w', encoding='utf-8') as f:
    f.write(pdf_content)

print("Updated pdf.blade.php with clean font declarations and A4 landscape boundaries")
