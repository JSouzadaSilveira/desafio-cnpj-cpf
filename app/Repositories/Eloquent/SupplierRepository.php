<?php

namespace App\Repositories\Eloquent;

use App\Models\Supplier;
use App\Repositories\Interfaces\SupplierRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SupplierRepository implements SupplierRepositoryInterface
{
    protected $model;

    public function __construct(Supplier $model)
    {
        $this->model = $model;
    }

    public function all(array $filters = [], array $orderBy = []): LengthAwarePaginator
    {
        $query = $this->model->query();

        if (isset($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%")
                  ->orWhere('document', 'like', "%{$filters['search']}%");
            });
        }

        foreach ($orderBy as $column => $direction) {
            $query->orderBy($column, $direction);
        }

        return $query->paginate(10);
    }

    public function find(int $id): ?Supplier
    {
        return $this->model->find($id);
    }

    public function create(array $data): Supplier
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $supplier = $this->find($id);
        if (!$supplier) {
            return false;
        }
        return $supplier->update($data);
    }

    public function delete(int $id): bool
    {
        $supplier = $this->find($id);
        if (!$supplier) {
            return false;
        }
        return $supplier->delete();
    }

    public function findByDocument(string $document): ?Supplier
    {
        return $this->model->where('document', $document)->first();
    }
}
