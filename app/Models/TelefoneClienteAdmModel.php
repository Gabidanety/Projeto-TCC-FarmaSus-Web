<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelefoneClienteAdmModel extends Model
{
    // Define a tabela associada ao model
    protected $table = 'tbTelefoneCliente';

    // Define a chave primária da tabela
    protected $primaryKey = 'idTelefoneCliente';

    // Define os campos que podem ser preenchidos em massa (mass assignment)
    protected $fillable = [
        'numeroTelefoneCliente',
        'situacaoTelefoneCliente',
        'dataCadastroTelefoneCliente',
      
    ];

    // Desativa as colunas de timestamps padrão (created_at, updated_at)
    public $timestamps = false;

    // Definindo o relacionamento com a tabela de clientes
    public function telefone()
    {
        return $this->belongsTo(TelefoneClienteAdmModel::class, 'idTelefoneCliente');
    }
    
}
