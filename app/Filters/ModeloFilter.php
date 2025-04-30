<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ModeloFilter
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

        if ($this->request->filled('modelo_productos__ano')) {
            $this->modeloProductosAnoExact($this->request->input('modelo_productos__ano'));
        }

        if ($this->request->filled('modelo_productos__ano_range')) {
            $range = $this->request->input('modelo_productos__ano_range');
            if (is_array($range) && count($range) === 2) {
                $this->modeloProductosAnoRange($range[0], $range[1]);
            }
        }

        if ($this->request->filled('marca')) {
            $this->marcaExact($this->request->input('marca'));
        }

        if ($this->request->filled('marca__in')) {
            $marcaIds = $this->request->input('marca__in');
            # string to array
            if (is_string($marcaIds)) {
                $marcaIds = explode(',', $marcaIds);
            }
            if (is_array($marcaIds)) {
                $this->marcaIn($marcaIds);
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

    protected function modeloProductosAnoExact(int $ano): void
    {
        $this->builder->whereHas('modeloProductos', function ($query) use ($ano) {
            $query->where('ano', $ano);
        });
    }

    protected function modeloProductosAnoRange(int $min, int $max): void
    {
        $this->builder->whereHas('modeloProductos', function ($query) use ($min, $max) {
            $query->whereBetween('ano', [$min, $max]);
        });
    }

    protected function marcaExact(int $marcaId): void
    {
        $this->builder->where('marca_id', $marcaId);
    }

    protected function marcaIn(array $marcaIds): void
    {
        $this->builder->whereIn('marca_id', $marcaIds);
    }
}