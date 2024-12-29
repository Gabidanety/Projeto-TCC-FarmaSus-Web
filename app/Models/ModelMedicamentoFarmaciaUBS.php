<?php
//Tabela da Farmacia

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelMedicamentoFarmaciaUBS extends Model
{
    use HasFactory;

    protected $table = 'tbMedicamentoFarmaciaUBS';
    protected $primaryKey = 'idMedicamento';
    protected $connection = 'mysql2';
    public $timestamps = false;

    protected $fillable = [
        'nomeMedicamento',
        'nomeGenericoMedicamento',
        'codigoDeBarrasMedicamento',
        'validadeMedicamento',
        'loteMedicamento',
        'dosagemMedicamento',
        'formaFarmaceuticaMedicamento',
        'composicaoMedicamento',
        'situacaoMedicamento',
        'dataCadastroMedicamento',
        'idUBS'

    ];
    

    public function medicamento()
{
    return $this->belongsTo(ModelMedicamentoFarmaciaUBS::class, 'idMedicamento', 'idMedicamento');
}

    public function ubs()
    {
        return $this->belongsTo(UBSModel::class, 'idUBS');
    }
}
