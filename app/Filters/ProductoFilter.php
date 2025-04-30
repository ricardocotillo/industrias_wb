<?php

namespace App\Filters;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductoFilter
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

        // Basic text filters
        $this->applyTextFilter('codigo__icontains', 'codigo');
        $this->applyTextFilter('codigo', 'codigo', true);
        $this->applyTextFilter('codigo_alt__icontains', 'codigo_alt');
        $this->applyTextFilter('codigo_alt', 'codigo_alt', true);
        $this->applyTextFilter('aplicaciones__icontains', 'aplicaciones');
        $this->applyTextFilter('aplicaciones', 'aplicaciones', true);

        // Equivalencias filters
        $this->applyEquivalenciasFilter('equivalencias__codigo__icontains', 'codigo');
        $this->applyEquivalenciasFilter('equivalencias__codigo', 'codigo', true);
        $this->applyEquivalenciasFilter('equivalencias__codigo_alt__icontains', 'codigo_alt');
        $this->applyEquivalenciasFilter('equivalencias__codigo_alt', 'codigo_alt', true);

        // Producto modelos filters
        $this->applyProductoModelosAnoFilter();
        $this->applyProductoModelosModeloFilter();
        $this->applyProductoModelosModeloMarcaFilter();

        // Tipo filters
        $this->applyTipoFilter();

        return $this->builder;
    }

    // Helper methods for applying filters

    protected function applyTextFilter(string $paramName, string $fieldName, bool $exact = false): void
    {
        if ($this->request->filled($paramName)) {
            $value = $this->request->input($paramName);
            if ($exact) {
                $this->builder->whereRaw("LOWER({$fieldName}) LIKE ?", [strtolower($value)]);
            } else {
                $this->builder->whereRaw("LOWER({$fieldName}) LIKE ?", ['%' . strtolower($value) . '%']);
            }
        }
    }

    protected function applyEquivalenciasFilter(string $paramName, string $fieldName, bool $exact = false): void
    {
        if ($this->request->filled($paramName)) {
            $value = $this->request->input($paramName);
            $this->builder->whereHas('equivalencias', function ($query) use ($fieldName, $value, $exact) {
                if ($exact) {
                    $query->whereRaw("LOWER({$fieldName}) LIKE ?", [strtolower($value)]);
                } else {
                    $query->whereRaw("LOWER({$fieldName}) LIKE ?", ['%' . strtolower($value) . '%']);
                }
            });
        }
    }

    protected function applyProductoModelosAnoFilter(): void
    {
        // Exact year filter
        if ($this->request->filled('producto_modelos__ano')) {
            $year = $this->request->input('producto_modelos__ano');
            $this->builder->whereHas('producto_modelos', function ($query) use ($year) {
                $query->where('ano', $year);
            });
        }

        // Range year filter
        if ($this->request->filled('producto_modelos__ano__range')) {
            $range = $this->request->input('producto_modelos__ano__range');
            # string to array
            if (is_string($range)) {
                $range = explode(',', $range);
            }
            if (is_array($range) && count($range) === 2) {
                $min = $range[0];
                $max = $range[1];
                $this->builder->whereHas('producto_modelos', function ($query) use ($min, $max) {
                    $query->whereBetween('ano', [$min, $max]);
                });
            }
        }
    }

    protected function applyProductoModelosModeloFilter(): void
    {
        // Exact modelo filter
        if ($this->request->filled('producto_modelos__modelo')) {
            $modeloId = $this->request->input('producto_modelos__modelo');
            $this->builder->whereHas('producto_modelos', function ($query) use ($modeloId) {
                $query->where('modelo_id', $modeloId);
            });
        }

        // In modelo filter
        if ($this->request->filled('producto_modelos__modelo__in')) {
            $modeloIds = $this->request->input('producto_modelos__modelo__in');
            # string to array
            if (is_string($modeloIds)) {
                $modeloIds = explode(',', $modeloIds);
            }
            if (is_array($modeloIds)) {
                $this->builder->whereHas('producto_modelos', function ($query) use ($modeloIds) {
                    $query->whereIn('modelo_id', $modeloIds);
                });
            }
        }
    }

    protected function applyProductoModelosModeloMarcaFilter(): void
    {
        // Exact marca filter
        if ($this->request->filled('producto_modelos__modelo__marca')) {
            $marcaId = $this->request->input('producto_modelos__modelo__marca');
            $this->builder->whereHas('producto_modelos.modelo', function ($query) use ($marcaId) {
                $query->where('marca_id', $marcaId);
            });
        }

        // In marca filter
        if ($this->request->filled('producto_modelos__modelo__marca__in')) {
            $marcaIds = $this->request->input('producto_modelos__modelo__marca__in');
            # string to array
            if (is_string($marcaIds)) {
                $marcaIds = explode(',', $marcaIds);
            }
            if (is_array($marcaIds)) {
                $this->builder->whereHas('producto_modelos.modelo', function ($query) use ($marcaIds) {
                    $query->whereIn('marca_id', $marcaIds);
                });
            }
        }
    }

    protected function applyTipoFilter(): void
    {
        // Exact tipo filter
        if ($this->request->filled('tipo')) {
            $tipo = $this->request->input('tipo');
            $this->builder->where('tipo', $tipo);
        }

        // In tipo filter
        if ($this->request->filled('tipo__in')) {
            $tipos = $this->request->input('tipo__in');
            # string to array
            if (is_string($tipos)) {
                $tipos = explode(',', $tipos);
            }
            if (is_array($tipos)) {
                $this->builder->whereIn('tipo', $tipos);
            }
        }
    }

    public function getFiltersInRequest(): array
    {
        $filters = [];
        if ($this->request->filled('codigo__icontains')) {
            $filters['codigo__icontains'] = $this->request->input('codigo__icontains');
        }
        if ($this->request->filled('codigo')) {
            $filters['codigo'] = $this->request->input('codigo');
        }
        if ($this->request->filled('codigo_alt__icontains')) {
            $filters['codigo_alt__icontains'] = $this->request->input('codigo_alt__icontains');
        }
        if ($this->request->filled('codigo_alt')) {
            $filters['codigo_alt'] = $this->request->input('codigo_alt');
        }
        if ($this->request->filled('aplicaciones__icontains')) {
            $filters['aplicaciones__icontains'] = $this->request->input('aplicaciones__icontains');
        }
        if ($this->request->filled('aplicaciones')) {
            $filters['aplicaciones'] = $this->request->input('aplicaciones');
        }
        if ($this->request->filled('equivalencias__codigo__icontains')) {
            $filters['equivalencias__codigo__icontains'] = $this->request->input('equivalencias__codigo__icontains');
        }
        if ($this->request->filled('equivalencias__codigo')) {
            $filters['equivalencias__codigo'] = $this->request->input('equivalencias__codigo');
        }
        if ($this->request->filled('equivalencias__codigo_alt__icontains')) {
            $filters['equivalencias__codigo_alt__icontains'] = $this->request->input('equivalencias__codigo_alt__icontains');
        }
        if ($this->request->filled('equivalencias__codigo_alt')) {
            $filters['equivalencias__codigo_alt'] = $this->request->input('equivalencias__codigo_alt');
        }
        if ($this->request->filled('equivalencias__aplicaciones__icontains')) {
            $filters['equivalencias__aplicaciones__icontains'] = $this->request->input('equivalencias__aplicaciones__icontains');
        }
        if ($this->request->filled('equivalencias__aplicaciones')) {
            $filters['equivalencias__aplicaciones'] = $this->request->input('equivalencias__aplicaciones');
        }
        if ($this->request->filled('producto_modelos__ano')) {
            $filters['producto_modelos__ano'] = $this->request->input('producto_modelos__ano');
        }
        if ($this->request->filled('producto_modelos__ano__range')) {
            $filters['producto_modelos__ano__range'] = $this->request->input('producto_modelos__ano__range');
        }
        if ($this->request->filled('producto_modelos__modelo')) {
            $filters['producto_modelos__modelo'] = $this->request->input('producto_modelos__modelo');
        }
        if ($this->request->filled('producto_modelos__modelo__in')) {
            $filters['producto_modelos__modelo__in'] = $this->request->input('producto_modelos__modelo__in');
        }
        if ($this->request->filled('producto_modelos__modelo__marca')) {
            $filters['producto_modelos__modelo__marca'] = $this->request->input('producto_modelos__modelo__marca');
        }
        if ($this->request->filled('producto_modelos__modelo__marca__in')) {
            $filters['producto_modelos__modelo__marca__in'] = $this->request->input('producto_modelos__modelo__marca__in');
        }
        if ($this->request->filled('tipo')) {
            $filters['tipo'] = $this->request->input('tipo');
        }
        if ($this->request->filled('tipo__in')) {
            $filters['tipo__in'] = $this->request->input('tipo__in');
        }
        return $filters;
    }
}