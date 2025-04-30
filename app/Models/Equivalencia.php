<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equivalencia extends Model
{
    /** @use HasFactory<\Database\Factories\EquivalenciaFactory> */
    use HasFactory;

    protected $fillable = ['codigo', 'marca', 'producto_id'];

    // Model events to handle automatic generation of codigo_alt
    protected static function booted()
    {
        static::creating(function ($equivalencia) {
            $equivalencia->codigo_alt = str_replace('-', '', $equivalencia->codigo);
        });

        static::updating(function ($equivalencia) {
            if ($equivalencia->isDirty('codigo')) {
                $equivalencia->codigo_alt = str_replace('-', '', $equivalencia->codigo);
            }
        });
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
