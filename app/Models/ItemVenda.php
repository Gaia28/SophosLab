<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemVenda extends Model
{
    protected $table = 'item_vendas';
    protected $fillable = [
        'venda_id', 
        'produto_id',
         'nome_produto',
         'quantidade', 
         'preco_unitario', 
         'subtotal'];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}