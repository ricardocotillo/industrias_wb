<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoModelo extends Model
{
    /** @use HasFactory<\Database\Factories\ProductoModeloFactory> */
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'modelo_id',
        'ano'
    ];
    
    /**
     * Get the associated producto.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
    
    /**
     * Get the associated modelo.
     */
    public function modelo()
    {
        return $this->belongsTo(Modelo::class);
    }
    
    /**
     * Custom string representation (similar to Django's __str__)
     */
    public function __toString()
    {
        // We need to load the relationships to access them in the __toString method
        $this->load(['producto', 'modelo.marca']);
        
        return "{$this->producto->codigo} - {$this->modelo->marca->nombre} - " .
               "{$this->modelo->nombre} - {$this->ano}";
    }
}
