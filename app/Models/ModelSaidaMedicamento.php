<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ModelMedicamentoFarmaciaUBS;

class ModelSaidaMedicamento extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = 'tbsaidamedicamento';
    protected $primaryKey = 'idSaidaMedicamento'; // Adicione isso
    public $incrementing = true; // Se a chave primária é auto-incrementada
    public $timestamps = false;

    protected $fillable = [
        'dataSaida',
        'quantidade',
        'motivoSaida',
        'situacao',
        'idMedicamento', // Adicione aqui
    ];


   // No ModelSaidaMedicamento
    public function medicamento()
    {
        return $this->belongsTo(ModelMedicamentoFarmaciaUBS::class, 'idMedicamento', 'idMedicamento');
    }

    public function funcionario()
    {
        return $this->belongsTo(ModelFuncionarioFarmaciaUBS::class, 'idFuncionario', 'idFuncionario');
    }

}
