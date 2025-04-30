<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    /** @use HasFactory<\Database\Factories\ModeloFactory> */
    use HasFactory;

    protected $fillable = ['nombre', 'marca_id'];

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'producto_modelos')
            ->withPivot('ano');
    }
}
