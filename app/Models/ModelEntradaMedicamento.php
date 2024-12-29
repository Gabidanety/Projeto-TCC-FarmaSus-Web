<?php
//Tabela da Farmacia

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelEntradaMedicamento extends Model
{
    use HasFactory;

    protected $table = 'tbEntradaMedicamento';
    protected $primaryKey = 'idEntradaMedicamento';
    protected $connection = 'mysql2';
    // Se você não quer usar as colunas created_at e updated_at
    public $timestamps = false;

    protected $fillable = [
        'dataEntrada',
        'quantidade',
        'lote',
        'validade',
        'idFuncionario',
        'idMedicamento',
        'idMotivoEntrada',
    ];

    public function funcionario()
    {
        return $this->belongsTo(ModelFuncionarioFarmaciaUBS::class, 'idFuncionario');
    }

    public function medicamento()
    {
        return $this->belongsTo(ModelMedicamentoFarmaciaUBS::class, 'idMedicamento');
    }

    public function motivoEntrada()
    {
        return $this->belongsTo(ModelMotivoEntrada::class, 'idMotivoEntrada');
    }
}
