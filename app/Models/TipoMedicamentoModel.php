<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoMedicamentoModel extends Model
{
    use HasFactory;

    protected $table = 'tbtipoMedicamento';
    protected $connection = 'mysql';
    protected $primaryKey = 'idTipoMedicamento'; // Defina a chave primária correta
    // protected $table = 'tbTipoMovimentacao'; // Nome da tabela

    protected $fillable = [
        'tipoMedicamento',
        'situacaoTipoMedicamento',
        'formaMedicamento',
        'dataCadastroTipoMedicamento',
    ];

    public $timestamps = false;
   
    public function medicamentos()
    {
        return $this->hasMany(MedicamentoModel::class, 'idTipoMedicamento');
    }
}
