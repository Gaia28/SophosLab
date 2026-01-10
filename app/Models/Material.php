<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Material extends Model
{
    protected $fillable = [
        'nome',
        'unidade_medida',
        'preco_pago',
        'quantidade_compra',
        'custo_por_unidade',
        'estoque_atual',
    ];

    public function produtos(): BelongsToMany
    {
        return $this->belongsToMany(Produto::class, 'produto_material')
                    ->withPivot('quantidade_uso')
                    ->withTimestamps();
    }
}