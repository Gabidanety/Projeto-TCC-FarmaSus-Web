<?php

//Tabela da Farmacia
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelTipoMovimentacao extends Model
{
    use HasFactory;

    protected $table = 'tbTipoMovimentacao';
    protected $primaryKey = 'idTipoMovimentacao';
    protected $connection = 'mysql2';

    public $timestamps = false;

    protected $fillable = [
        'movimentacao',
        'situacaoTipoMovimentacao',
        'dataCadastroTipoMovimentacao',
        'idPrescricao'
    ];

    public function prescricao()
    {
        return $this->belongsTo(ModelPrescricao::class, 'idPrescricao');
    }

    public function estoques()
    {
        return $this->hasMany(ModelEstoqueFarmaciaUBS::class, 'idTipoMovimentacao');
    }
}
