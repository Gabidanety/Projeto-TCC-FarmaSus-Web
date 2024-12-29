<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicamentoModel extends Model
{
    use HasFactory;

    // protected $table = 'tbMedicamento';

    protected $table = 'tbmedicamento'; // Mudando para minúsculas
    
    protected $connection = 'mysql';

    protected $fillable = [
        'nomeMedicamento',
        'nomeGenericoMedicamento',
        'codigoDeBarrasMedicamento',
        'registroAnvisaMedicamento',
        'concentracaoMedicamento',
        'formaFarmaceuticaMedicamento',
        'composicaoMedicamento',
        'fotoMedicamentoOriginal',
        'fotoMedicamentoGenero',
        'idDetentor',
        'idTipoMedicamento',
        'situacaoMedicamento',
        'dataCadastroMedicamento',
    ];

    public $timestamps = false;
    
    protected $primaryKey = 'idMedicamento'; 
    
    public function detentor()
    {
        return $this->belongsTo(DetentorModel::class, 'idDetentor',);
    }

    public function tipoMedicamento()
    {
        return $this->belongsTo(TipoMedicamentoModel::class, 'idTipoMedicamento'); 
    }
}
