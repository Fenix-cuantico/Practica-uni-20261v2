<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $pdfConfig['title'] ?? 'Documento PDF' }}</title>
    <style>
        body {
            font-family: {{ $pdfConfig['font_family'] ?? 'sans-serif' }};
            font-size: {{ $pdfConfig['font_size'] ?? '12px' }};
            /* Margin adjusts depending on whether header/footer are shown, to avoid overlapping content */
            margin-top: {{ ($pdfConfig['show_header'] ?? false) ? '80px' : '0px' }};
            margin-bottom: {{ ($pdfConfig['show_footer'] ?? false) ? '50px' : '0px' }};
            color: #333;
        }
        
        @page {
            margin: {{ $pdfConfig['margins']['top'] ?? '2cm' }} {{ $pdfConfig['margins']['right'] ?? '2cm' }} {{ $pdfConfig['margins']['bottom'] ?? '2cm' }} {{ $pdfConfig['margins']['left'] ?? '2cm' }};
        }

        /* Header styling */
        @if($pdfConfig['show_header'] ?? false)
        header {
            position: fixed;
            top: -{{ $pdfConfig['margins']['top'] ?? '2cm' }};
            left: 0;
            right: 0;
            height: 60px;
            text-align: center;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header-title {
            font-size: 16px;
            font-weight: bold;
            margin: 5px 0 0 0;
            text-transform: uppercase;
        }
        .header-institution {
            font-size: 14px;
            color: #555;
            margin: 0;
            font-weight: bold;
        }
        @endif

        /* Footer styling */
        @if($pdfConfig['show_footer'] ?? false)
        footer {
            position: fixed;
            bottom: -{{ $pdfConfig['margins']['bottom'] ?? '2cm' }};
            left: 0;
            right: 0;
            height: 30px;
            border-top: 1px solid #ddd;
            padding-top: 5px;
            font-size: 10px;
            color: #777;
        }
        .footer-table {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }
        .footer-table td {
            border: none;
            padding: 0;
        }
        .footer-left {
            text-align: left;
            width: 50%;
        }
        .footer-right {
            text-align: right;
            width: 50%;
        }
        @if($pdfConfig['show_pagination'] ?? false)
        .page-number:before {
            content: "Página " counter(page);
        }
        @endif
        @endif

        /* Background */
        @if($pdfConfig['background_image'] ?? false)
        .background-image {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: {{ $pdfConfig['background_opacity'] ?? '0.1' }};
            z-index: -1000;
            text-align: center;
        }
        .background-image img {
            width: 80%;
            margin-top: 25%;
        }
        @endif

        /* Utility classes */
        .w-100 { width: 100%; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .mb-1 { margin-bottom: 5px; }
        .mb-2 { margin-bottom: 10px; }
        .mb-3 { margin-bottom: 15px; }
        .mt-1 { margin-top: 5px; }
        .mt-2 { margin-top: 10px; }
        .mt-3 { margin-top: 15px; }
        .font-weight-bold { font-weight: bold; }
        
        table.table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table.table th, table.table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: {{ $pdfConfig['font_size'] ?? '12px' }};
        }
        table.table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }
        
        .section-title {
            background-color: #f2f2f2;
            padding: 8px;
            font-weight: bold;
            border-left: 4px solid #0d6efd;
            margin-top: 15px;
            margin-bottom: 10px;
        }
    </style>
    @yield('styles')
</head>
<body>

    @if($pdfConfig['background_image'] ?? false)
        <div class="background-image">
            <img src="{{ $pdfConfig['background_image'] }}" alt="Background">
        </div>
    @endif

    @if($pdfConfig['show_header'] ?? false)
        <header>
            <table style="width: 100%; border: none; border-collapse: collapse;">
                <tr>
                    @if($pdfConfig['logo_path'] ?? false)
                    <td style="width: 20%; text-align: left; vertical-align: middle; border: none;">
                        <img src="{{ $pdfConfig['logo_path'] }}" alt="Logo" style="max-height: 60px;">
                    </td>
                    @endif
                    <td style="{{ ($pdfConfig['logo_path'] ?? false) ? 'width: 80%; text-align: right;' : 'width: 100%; text-align: center;' }} vertical-align: middle; border: none;">
                        <p class="header-institution">{{ $pdfConfig['institution_name'] ?? '' }}</p>
                        <h1 class="header-title">{{ $pdfConfig['title'] ?? '' }}</h1>
                    </td>
                </tr>
            </table>
        </header>
    @endif

    @if($pdfConfig['show_footer'] ?? false)
        <footer>
            <table class="footer-table">
                <tr>
                    <td class="footer-left">
                        {{ $pdfConfig['additional_info'] ?? '' }}
                    </td>
                    <td class="footer-right">
                        @if($pdfConfig['show_pagination'] ?? false)
                            <span class="page-number"></span>
                        @endif
                    </td>
                </tr>
            </table>
        </footer>
    @endif

    <main>
        @yield('content')
    </main>

</body>
</html>
