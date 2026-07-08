<div style="font-family: sans-serif; color: #333;">
    <h2 style="color: #d32f2f;">🚨 Notificações</h2>
    <p>Olá, {{ $user->name }}. Uma notificação está próxima de vencer:</p>    
    <p>Placa: {{ $vehicle->vehicle_plate }}</p>
    <p>Marca: {{ $vehicle->brand->brand_name }}</p>
    <p>Modelo: {{ $vehicle->vehicle_model }}</p>
    <p>Descrição: {{ $description }}</p>
    <p>Data de vencimento: {{ $dueDate->format('d/m/Y') }}</p>
</div>