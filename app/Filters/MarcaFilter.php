<?php

namespace App\Filters;

use App\Models\Marca;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class MarcaFilter
{
    protected $request;
    protected $builder;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        // Apply filters based on request parameters
        if ($this->request->filled('nombre')) {
            $this->nombreIExact($this->request->input('nombre'));
        }

        if ($this->request->filled('nombre__icontains')) {
            $this->nombreIContains($this->request->input('nombre__icontains'));
        }

        if ($this->request->filled('modelos__modelo_productos__ano__exact')) {
            $this->modelosModeloProductosAnoExact($this->request->input('modelos__modelo_productos__ano__exact'));
        }

        if ($this->request->filled('modelos__modelo_productos__ano__range')) {
            $range = $this->request->input('modelos__modelo_productos__ano__range');
            if (is_array($range) && count($range) === 2) {
                $this->modelosModeloProductosAnoRange($range[0], $range[1]);
            }
        }

        if ($this->request->filled('modelos')) {
            $this->modelosExact($this->request->input('modelos'));
        }

        if ($this->request->filled('modelos__in')) {
            $modeloIds = $this->request->input('modelos__in');
            # string to array
            if (is_string($modeloIds)) {
                $modeloIds = explode(',', $modeloIds);
            }
            if (is_array($modeloIds)) {
                $this->modelosIn($modeloIds);
            }
        }

        return $this->builder;
    }

    // Filter methods

    protected function nombreIExact(string $nombre): void
    {
        $this->builder->where('nombre', 'ilike', $nombre);
    }

    protected function nombreIContains(string $nombre): void
    {
        $this->builder->where('nombre', 'ilike', "%{$nombre}%");
    }

    protected function modelosModeloProductosAnoExact(int $ano): void
    {
        $this->builder->whereHas('modelos.modeloProductos', function ($query) use ($ano) {
            $query->where('ano', $ano);
        });
    }

    protected function modelosModeloProductosAnoRange(int $min, int $max): void
    {
        $this->builder->whereHas('modelos.modeloProductos', function ($query) use ($min, $max) {
            $query->whereBetween('ano', [$min, $max]);
        });
    }

    protected function modelosExact(int $modeloId): void
    {
        $this->builder->whereHas('modelos', function ($query) use ($modeloId) {
            $query->where('id', $modeloId);
        });
    }

    protected function modelosIn(array $modeloIds): void
    {
        $this->builder->whereHas('modelos', function ($query) use ($modeloIds) {
            $query->whereIn('id', $modeloIds);
        });
    }
}