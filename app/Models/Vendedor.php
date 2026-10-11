<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendedor extends Model
{
    protected $table = 'vendedores';

    protected $fillable = ['nombre', 'email'];

    public function ventas(): HasMany
    {
        return $this->hasMany(Venta::class);
    }
}
