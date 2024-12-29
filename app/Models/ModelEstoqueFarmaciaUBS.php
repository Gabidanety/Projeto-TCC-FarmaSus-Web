<?php
//Tabela da Farmacia

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelEstoqueFarmaciaUBS extends Model
{
    use HasFactory;

    protected $table = 'tbEstoqueFarmaciaUBS';
    protected $primaryKey = 'idEstoque';
    protected $connection = 'mysql2';
    public $timestamps = false;
    protected $fillable = [
        'quantEstoque',
        'dataMovimentacao',
        'idFuncionario',
        'idMedicamento',
        'idTipoMovimentacao',
        'situacaoEstoque',
        'dataCadastroEstoque'
    ];

    public function funcionario()
    {
        return $this->belongsTo(ModelFuncionario::class, 'idFuncionario');
    }

    public function medicamento()
    {
        return $this->belongsTo(ModelMedicamentoFarmaciaUBS::class, 'idMedicamento');
    }

    public function tipoMovimentacao()
    {
        return $this->belongsTo(ModelTipoMovimentacao::class, 'idTipoMovimentacao');
    }
}
