<?php

namespace App\Repositories;

use App\DTOs\CreateKilometerDTO;
use App\Models\Kilometer;
use App\Repositories\Contracts\KilometerRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class KilometerRepository implements KilometerRepositoryInterface
{
    public function __construct(private Kilometer $model){}
    public function storeKilometer(CreateKilometerDTO $dto): Kilometer
    {
        return $this->model->create($dto->toArray());
    }
    public function index(
        ?string $search = null,
        ?string $sort = null,
        ?string $sortDirection = null,
        ?int $page = 1,
        ?int $perPage = 5
    ): LengthAwarePaginator
    {
        $subquery = Kilometer::select('vehicle_id', DB::raw('MAX(kilometers_value) as max_value'))
            ->groupBy('vehicle_id');

        return $this->model->query()
            ->with(['vehicle', 'vehicle.drivers', 'vehicle.fines', 'vehicle.maintenances', 'vehicle.fuelSuppliers'])
            ->joinSub($subquery, 'max_kilometers', function ($join) {
                $join->on('kilometers.vehicle_id', '=', 'max_kilometers.vehicle_id')
                     ->on('kilometers.kilometers_value', '=', 'max_kilometers.max_value');
            })
            ->join('vehicles', 'kilometers.vehicle_id', '=', 'vehicles.id')
            ->when($search, function($query) use ($search){
                return $query->where('kilometers_date', 'like', "%$search%")
                    ->orWhere('kilometers_value', 'like', "%$search%");
            })->when($sort, function($query) use ($sort, $sortDirection){
                return $query->orderBy($sort, $sortDirection);
            })
            ->select([
                'kilometers.id', 
                'kilometers.vehicle_id', 
                'kilometers.kilometers_date', 
                'kilometers.kilometers_notes', 
                'kilometers.kilometers_status', 
                'kilometers.kilometers_value'
            ])
            ->selectRaw('CONCAT(vehicles.vehicle_plate, " - ", vehicles.vehicle_model) as vehicle_name')
            ->orderBy('kilometers_date', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);
    }
}