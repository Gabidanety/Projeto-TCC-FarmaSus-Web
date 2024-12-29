<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetentorModel extends Model
{
    use HasFactory;

    protected $table = 'tbdetentor';
    protected $connection = 'mysql';

    protected $fillable = [
        'nomeDetentor',
        'cnpjDetentor',
        'emailDetentor',
        'logradouroDetentor',
        'bairroDetentor',
        'estadoDetentor',
        'cidadeDetentor',
        'numeroDetentor',
        'ufDetentor',
        'cepDetentor',
        'complementoDetentor',
        'situacaoDetentor',
        'dataCadastroDetentor',
    ];

    public $timestamps = false;
    protected $primaryKey = 'idDetentor'; 

    public function medicamentos()
    {
        return $this->hasMany(MedicamentoModel::class, 'idDetentor');
    }
}
