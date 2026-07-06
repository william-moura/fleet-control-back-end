<div style="font-family: sans-serif; color: #333;">
    <h2 style="color: #d32f2f;">🚨 Alerta de Multas a Vencer</h2>
    <p>Olá, {{ $user->name }}. As seguintes multas vencem em 7 dias:</p>
    
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f5f5f5;">
                <th style="padding: 10px; border: 1px solid #ddd;">Veículo</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Valor</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Vencimento</th>
            </tr>
        </thead>
        <tbody>
            @foreach($multas as $multa)
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $multa->vehicle->vehicle_plate }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">R$ {{ number_format($multa->vehicle_fine_amount, 2, ',', '.') }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ date('d/m/Y', strtotime($multa->vehicle_fine_paid_date)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
</div>