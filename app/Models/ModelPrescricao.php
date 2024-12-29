<?php
//Tabela da Farmacia

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelPrescricao extends Model
{
    use HasFactory;

    protected $table = 'tbPrescricao';
    protected $primaryKey = 'idPrescricao';
    protected $connection = 'mysql2';
    public $timestamps = false;

    protected $fillable = [
        'dataPrescricao',
        'quantPrescricao',
        'dosagemPrescricao',
        'duracaoRemedio',
        'idMedicamento',
        'situacaoPrescricao',
        'dataCadastroPrescricao'
    ];

    public function medicamento()
    {
        return $this->belongsTo(ModelMedicamentoFarmaciaUBS::class, 'idMedicamento');
    }
}
