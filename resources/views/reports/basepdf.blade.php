<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório de Consumo</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #04750e; padding-bottom: 10px; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #04750e; color: white; padding: 10px; text-align: left; }
        td { padding: 8px; border-bottom: 1px solid #ddd; }
        .zebra tr:nth-child(even) { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .header-logo { text-align: left; }
        .header-logo img { width: 200px; height: 150px; }
        .header-logo h1 { font-size: 20px; font-weight: bold; color: #04750e; }
        .header-logo p { font-size: 12px; color: #04750e; }
        .header-logo { text-align: left; }
        .header-logo img { width: 100px; height: 100px; }
        .header-logo h1 { font-size: 20px; font-weight: bold; color: #04750e; }
        .header-logo p { font-size: 12px; color: #04750e; }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-logo">
            @php
    $path = public_path('images/log-final.jpeg');
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $dataLogo = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($dataLogo);
@endphp

<img src="{{ $base64 }}" alt="Realiza Informática">
            
        </div>
        <h1>Realiza Informática - {{ $title }}</h1>
        <p>Período: {{ $startDate }} a {{ $endDate }}</p>
    </div>

    <table class="zebra">
        <thead>
            <tr>
                @foreach($headings as $heading)
                    <th>{{ $heading }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                <tr>
                    @foreach($headings as $key => $heading)
                        <td>{{ $item[$key] }}</td>
                    @endforeach                    
                    
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Gerado em {{ date('d/m/Y H:i') }}
    </div>
</body>
</html>
