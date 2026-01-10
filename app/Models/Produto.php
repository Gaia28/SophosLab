<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Produto extends Model
{
    protected $fillable = [
        'nome',
        'descricao',
        'custo_mao_de_obra',
        'margem_lucro_percentual',
        'custo_materiais_total',
        'preco_final',
        'estoque_pronto',
    ];

    public function materiais(): BelongsToMany
    {
        return $this->belongsToMany(Material::class, 'produto_material')
                    ->withPivot('quantidade_uso')
                    ->withTimestamps();
    }
}