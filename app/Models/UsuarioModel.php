<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioModel extends Model
{
    use HasFactory;

    protected $table = 'tbUsuario';
    // Definindo a chave primária, caso não seja 'id'
    protected $primaryKey = 'idUsuario'; // Substitua pelo nome correto da chave primária
    protected $connection = 'mysql'; // Verifique se este é o nome correto da conexão

    protected $fillable = [
        'nomeUsuario',
        'fotoUsuario',
        'cnsUsuario',
        'senhaUsuario',
        'situacaoUsuario', // Corrigido para remover o acento
        'dataCadastroUsuario',
        'emailUsuario',
    ];

    public $timestamps = false; // Mantenha isso se não precisar de timestamps

    public function contatos()
    {
        return $this->hasMany(ContatoModel::class, 'idUsuario'); // 'idUsuario' é a chave estrangeira na tabela de contatos
    }
}