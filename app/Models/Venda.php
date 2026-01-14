<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $fillable = ['cliente', 'valor_total', 'data_venda'];
    
    public function itens()
    {
        return $this->hasMany(ItemVenda::class);
    }
}
