<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelMotivoDesativamentoMed extends Model
{
    use HasFactory;

    // Nome da tabela
    protected $table = 'tbMotivoDesativamentoMed';

    protected $connection = 'mysql';

    // Chave primária
    protected $primaryKey = 'idMotivoDesativamentoMed';

    // Desabilita timestamps automáticos (created_at, updated_at), se não forem usados
    public $timestamps = false;

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'idMedicamento',
        'Motivo',
        'dataDesativamento',
    ];

    // Relacionamento com a tabela `tbmedicamentofarmaciaubs`
    public function medicamento()
    {
        return $this->belongsTo(MedicamentoModel::class, 'idMedicamento', 'idMedicamento');
    }
}
