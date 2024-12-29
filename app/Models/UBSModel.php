<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UBSModel extends Model
{
    use HasFactory;

    protected $table = 'tbUBS';
    protected $connection = 'mysql';

    protected $primaryKey = 'idUBS';

    protected $fillable = [
        'nomeUBS',
        'emailUBS',
        'fotoUBS',
        'cnpjUBS',
        'latitudeUBS',
        'longitudeUBS',
        'cepUBS',
        'logradouroUBS',
        'bairroUBS',
        'estadoUBS',
        'cidadeUBS',
        'numeroUBS',
        'ufUBS',
        'complementoUBS',
        'senhaUBS',
        'situacaoUBS',
        'dataCadastroUBS',
        'idTelefoneUBS',
        'idRegiaoUBS',
    ];
    public function regiao()
    {
        return $this->belongsTo(RegiaoUBSModel::class, 'idRegiaoUBS'); // Use a chave estrangeira correta
    }

    public function telefone()
    {
        return $this->belongsTo(TelefoneUBSModel::class, 'idTelefoneUBS'); // Use a chave estrangeira correta
    }
    public $timestamps = false;

    public function medicamentos()
    {
        return $this->hasMany(ModelMedicamentoFarmaciaUBS::class, 'idUBS');
    }
   
}
