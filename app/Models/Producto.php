<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    /** @use HasFactory<\Database\Factories\ProductoFactory> */
    use HasFactory;

    protected $fillable = [
        'codigo', 'linea', 'tipo', 'aplicaciones',
        'diametro_exterior', 'diametro_interior', 'altura',
        'pzs_x_caja', 'valv_antidr', 'valv_by_pass',
        'descripcion', 'empaquetadura', 'destacado', 'promocion'
    ];

    // Model events to handle automatic generation of codigo_alt
    protected static function booted()
    {
        static::creating(function ($producto) {
            $producto->codigo_alt = str_replace('-', '', $producto->codigo);
        });

        static::updating(function ($producto) {
            if ($producto->isDirty('codigo')) {
                $producto->codigo_alt = str_replace('-', '', $producto->codigo);
            }
        });
    }

    public function modelos()
    {
        return $this->belongsToMany(Modelo::class, 'producto_modelo')
            ->withPivot('ano');
    }

    public function equivalencias()
    {
        return $this->hasMany(Equivalencia::class);
    }

    public function producto_modelos()
    {
        return $this->hasMany(ProductoModelo::class);
    }
}
