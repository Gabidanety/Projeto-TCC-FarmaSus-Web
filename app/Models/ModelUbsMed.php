<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelUbsMed extends Model
{
    use HasFactory;

    // Define a tabela que este model irá manipular
    protected $table = 'tbubsmed';

    // Caso a chave primária seja composta, remova este atributo
    protected $primaryKey = 'id'; 

    // Desabilitar a atribuição em massa para segurança
    protected $guarded = [];

    // Indica que a chave primária não é auto incremento
    public $incrementing = false;

    // Define o tipo de dados para a chave primária
    protected $keyType = 'string';

    // Desabilitar timestamps, caso não tenha os campos created_at e updated_at
    public $timestamps = false;

    // Relacionamento com medicamentos
    public function medicamento()
    {
        return $this->belongsTo(MedicamentoModel::class, 'idMedicamento', 'idMedicamento');
    }

    // Relacionamento com UBS
    public function ubs()
    {
        return $this->belongsTo(UBSModel::class, 'idUBS', 'idUBS');
    }
}
