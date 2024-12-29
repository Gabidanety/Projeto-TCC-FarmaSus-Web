<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelMotivoDesativadoMedFarma extends Model
{
    use HasFactory;

    // Nome da tabela
    protected $table = 'tbmotivodesativamentoMedFarma';

    // Chave primária
    protected $primaryKey = 'idMotivoDesativamentoMed';
    protected $connection = 'mysql2';

    // Desativar timestamps padrão (created_at, updated_at)
    public $timestamps = false;

    // Campos que podem ser preenchidos via atribuição em massa
    protected $fillable = [
        'idMedicamento',
        'Motivo',
        'dataDesativamento',
    ];

    // Relacionamento com o medicamento
    public function medicamento()
    {
        return $this->belongsTo(ModelMedicamentoFarmaciaUBS::class, 'idMedicamento', 'idMedicamento');
    }
}
