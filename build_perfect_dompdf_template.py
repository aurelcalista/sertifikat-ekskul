import base64

svg_bg = '''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1122 793" width="1122" height="793">
    <!-- Outer Gold Border -->
    <rect x="20" y="20" width="1082" height="753" fill="none" stroke="#D4AF37" stroke-width="2.5" />
    <!-- Inner Dark Border -->
    <rect x="28" y="28" width="1066" height="737" fill="none" stroke="#0F172A" stroke-width="1" />
    
    <!-- Corner Accents -->
    <polyline points="42,33 33,33 33,42" fill="none" stroke="#D4AF37" stroke-width="2.5" />
    <polyline points="1089,42 1089,33 1080,33" fill="none" stroke="#D4AF37" stroke-width="2.5" />
    <polyline points="33,751 33,760 42,760" fill="none" stroke="#D4AF37" stroke-width="2.5" />
    <polyline points="1080,760 1089,760 1089,751" fill="none" stroke="#D4AF37" stroke-width="2.5" />

    <!-- 1. Top-Left Technical Circular Line Pattern -->
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

    <!-- 2. Top-Right Orange Geometric Angular Splash -->
    <g fill="#F15A3D" transform="translate(772, 0)">
        <polygon points="120,0 350,0 350,220 280,180 260,250 210,170 170,220 140,110 80,140 100,50" />
        <polygon points="260,190 350,120 350,270 290,260" fill="#D9482B"/>
        <polygon points="180,210 240,290 280,240 220,180" fill="#FF6B4A"/>
    </g>

    <!-- 3. Left Side Diagonal Gray Lines -->
    <g stroke="#94A3B8" stroke-width="2.5" stroke-linecap="round" transform="translate(10, 260)">
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

    <!-- 4. Right Side Upward Stacked Chevrons -->
    <g fill="none" stroke-width="2.5" stroke-linejoin="round" stroke-linecap="round" transform="translate(1055, 260)">
        <polyline points="10,35 30,15 50,35" stroke="#F15A3D" />
        <polyline points="10,65 30,45 50,65" stroke="#F15A3D" />
        <polyline points="10,95 30,75 50,95" stroke="#64748B" />
        <polyline points="10,125 30,105 50,125" stroke="#64748B" />
        <polyline points="10,155 30,135 50,155" stroke="#64748B" />
        <polyline points="10,185 30,165 50,185" stroke="#CBD5E1" />
    </g>

    <!-- 5. Bottom Left Corner Diagonal Orange Lines -->
    <g stroke="#F15A3D" stroke-width="2.5" stroke-linecap="round" transform="translate(0, 593)">
        <line x1="0" y1="200" x2="220" y2="20" stroke-width="3.5"/>
        <line x1="0" y1="170" x2="190" y2="10" stroke-width="3"/>
        <line x1="0" y1="140" x2="160" y2="0" stroke-width="2.5"/>
        <line x1="0" y1="110" x2="130" y2="0" stroke-width="2"/>
        <line x1="0" y1="80" x2="90" y2="0" stroke-width="1.5"/>
        <line x1="0" y1="50" x2="50" y2="0" stroke-width="1"/>
    </g>

    <!-- 6. Bottom Right Geometric L-shaped Grain Frame -->
    <g fill="none" stroke-linecap="round" stroke-linejoin="round" transform="translate(872, 543)">
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
</svg>'''

bg_b64 = base64.b64encode(svg_bg.encode('utf-8')).decode('utf-8')

pdf_template = f'''<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat - {{{{ $certificate->nama_siswa }}}}</title>
    @php
        $get_local_path = function($path) {{
            if ($path && file_exists(storage_path('app/public/' . $path))) {{
                return storage_path('app/public/' . $path);
            }} elseif ($path && file_exists(public_path($path))) {{
                return public_path($path);
            }}
            return null;
        }};

        $logo_file = $get_local_path($certificate->logo_sekolah);
        if (!$logo_file) {{
            $logo_file = public_path('logos/logo-rakitai.png');
        }}
        $logo_data = $logo_file ? \\App\\Models\\Certificate::removeWhiteBackground($logo_file) : null;

        $verify_url = route('verify', $certificate->code);
        $qrRaw = \\SimpleSoftwareIO\\QrCode\\Facades\\QrCode::format('svg')->size(150)->margin(1)->generate($verify_url);
        $qrCodeSvg = (string) $qrRaw;
        $qrCodeSvg = preg_replace('/^\\s*<\\?xml[^>]*\\?>/i', '', $qrCodeSvg) ?? $qrCodeSvg;
        $qr_base64 = 'data:image/svg+xml;base64,' . base64_encode($qrCodeSvg);

        $upper_name = strtoupper($certificate->nama_siswa);
        $name_length = strlen($upper_name);

        $fs = '25pt';
        if ($name_length > 40) {{
            $fs = '16pt';
        }} elseif ($name_length > 30) {{
            $fs = '19pt';
        }} elseif ($name_length > 20) {{
            $fs = '22pt';
        }}

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
        @page {{
            size: A4 landscape;
            margin: 0;
        }}
        
        html, body {{
            margin: 0;
            padding: 0;
            width: 297mm;
            height: 210mm;
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-color: #FFFFFF;
            color: #1F2A44;
        }}

        .certificate-container {{
            width: 297mm;
            height: 210mm;
            position: relative;
            background-color: #FCFAF5;
            overflow: hidden;
            box-sizing: border-box;
        }}

        .bg-template {{
            position: absolute;
            top: 0;
            left: 0;
            width: 297mm;
            height: 210mm;
            z-index: 1;
        }}

        .content-layer {{
            position: absolute;
            top: 0;
            left: 0;
            width: 297mm;
            height: 210mm;
            z-index: 10;
            box-sizing: border-box;
        }}

        .header-section {{
            text-align: center;
            padding-top: 14mm;
        }}

        .title-section {{
            text-align: center;
            margin-top: 3mm;
        }}
        .cert-title {{
            font-family: 'Times-Bold', 'Georgia', serif;
            font-size: 26pt;
            font-weight: bold;
            color: #1F2A44;
            letter-spacing: 6px;
            margin: 0;
            text-transform: uppercase;
        }}
        .cert-subtitle {{
            font-size: 9.5pt;
            font-weight: bold;
            color: #F15A3D;
            letter-spacing: 3px;
            margin: 2px 0 5px 0;
            text-transform: uppercase;
        }}
        .cert-pill {{
            border: 1.5pt solid #1F2A44;
            border-radius: 12px;
            padding: 2px 16px;
            font-size: 8pt;
            font-weight: bold;
            color: #1F2A44;
            display: inline-block;
        }}

        .recipient-section {{
            text-align: center;
            margin-top: 5mm;
        }}
        .given-to {{
            font-size: 9.5pt;
            color: #334155;
            margin: 0 0 2mm 0;
        }}
        .recipient-name {{
            font-family: 'Times-Bold', 'Georgia', serif;
            font-size: {{{{ $fs }}}};
            font-weight: bold;
            color: #1F2A44;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }}

        .description-section {{
            text-align: center;
            width: 78%;
            margin: 5mm auto 0 auto;
        }}
        .description-text {{
            font-size: 9.5pt;
            line-height: 1.5;
            color: #334155;
            margin: 0;
        }}
        .highlight-text {{
            color: #F15A3D;
            font-weight: bold;
        }}

        .footer-wrapper {{
            position: absolute;
            bottom: 14mm;
            left: 22mm;
            width: 253mm;
            z-index: 20;
        }}

        .footer-table {{
            width: 100%;
            border-collapse: collapse;
        }}
        .footer-qr-cell {{
            width: 30%;
            vertical-align: bottom;
            text-align: left;
        }}
        .footer-center-cell {{
            width: 40%;
            vertical-align: bottom;
            text-align: center;
        }}
        .footer-date-cell {{
            width: 30%;
            vertical-align: bottom;
            text-align: right;
        }}

        .qr-code-img {{
            width: 52px;
            height: 52px;
            border: 1.5px solid #CBD5E1;
            padding: 2px;
            border-radius: 6px;
            background-color: #FFFFFF;
            display: inline-block;
        }}

        .medal-img {{
            width: 58px;
            height: 75px;
            display: inline-block;
        }}

        .date-box {{
            display: inline-block;
            text-align: right;
        }}
        .date-label {{
            font-family: 'Times-Italic', 'Georgia', serif;
            font-size: 10pt;
            color: #475569;
            font-style: italic;
            margin-bottom: 2px;
            text-align: right;
        }}
        .date-value-wrap {{
            text-align: right;
            white-space: nowrap;
        }}
        .date-dot {{
            font-size: 6pt;
            color: #94A3B8;
        }}
        .date-text {{
            font-size: 10pt;
            font-weight: bold;
            color: #0F172A;
            margin: 0 4px;
        }}
        .date-line {{
            height: 1.5px;
            background-color: #64748B;
            margin-top: 3px;
            width: 100%;
        }}
    </style>
</head>
<body>

    <div class="certificate-container">

        <!-- Rakit AI Vector Background Frame with Outer Gold & Dark Borders -->
        <img class="bg-template" src="data:image/svg+xml;base64,{bg_b64}" alt="Background Vector">

        <div class="content-layer">
            <!-- Header Logo -->
            <div class="header-section">
                @if($logo_data)
                    <img src="{{{{ $logo_data }}}}" style="max-height: 44px; width: auto;" alt="Logo">
                @else
                    <img src="{{{{ public_path('logos/logo-rakitai.png') }}}}" style="max-height: 44px; width: auto;" alt="Logo">
                @endif
            </div>

            <!-- Title & Subtitle -->
            <div class="title-section">
                <h2 class="cert-title">SERTIFIKAT</h2>
                <p class="cert-subtitle">{{{{ strtoupper($certificate->jenis_sertifikat ?? 'SERTIFIKAT KEIKUTSERTAAN') }}}}</p>
                
                <div style="text-align: center; margin-top: 2.5mm;">
                    <span class="cert-pill">Certificat No: {{{{ $certificate->nomor_sertifikat }}}}</span>
                </div>
            </div>

            <!-- Recipient Section -->
            <div class="recipient-section">
                <p class="given-to">Diberikan kepada:</p>
                <h3 class="recipient-name">{{{{ $upper_name }}}}</h3>
            </div>

            <!-- Description Box -->
            <div class="description-section">
                <p class="description-text">
                    @php
                        $descText = e($certificate->prestasi);
                        $descText = preg_replace('/&quot;(.*?)&quot;/', '<span class="highlight-text">"$1"</span>', $descText);
                    @endphp
                    {{!! nl2br($descText) !!}}
                </p>
            </div>
        </div>

        <!-- Bottom Footer Wrapper -->
        <div class="footer-wrapper">
            <table class="footer-table">
                <tr>
                    <td class="footer-qr-cell">
                        <img src="{{{{ $qr_base64 }}}}" class="qr-code-img" alt="QR Code">
                    </td>
                    <td class="footer-center-cell">
                        <img src="{{{{ $medal_base64 }}}}" class="medal-img" alt="Gold Medal">
                    </td>
                    <td class="footer-date-cell">
                        <div class="date-box">
                            <div class="date-label">Diterbitkan pada tanggal</div>
                            <div class="date-value-wrap">
                                <span class="date-dot">&#9679; &#9679;</span>
                                <span class="date-text">{{{{ $certificate->tanggal->translatedFormat('d F Y') }}}}</span>
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
'''

with open('resources/views/certificates/pdf.blade.php', 'w', encoding='utf-8') as f:
    f.write(pdf_template)

print("pdf.blade.php generated successfully!")
