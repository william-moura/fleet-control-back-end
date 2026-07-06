<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório de Consumo</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #1a237e; padding-bottom: 10px; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #1a237e; color: white; padding: 10px; text-align: left; }
        td { padding: 8px; border-bottom: 1px solid #ddd; }
        .zebra tr:nth-child(even) { background-color: #f2f2f2; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>FrotaSync - {{ $title }}</h1>
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