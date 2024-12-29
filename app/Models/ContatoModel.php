<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContatoModel extends Model
{
    use HasFactory;

    protected $table = 'tbContato';  // Verifique se o nome da tabela está correto
    protected $primaryKey = 'idContato'; // Adicione esta linha se a chave primária não for 'id'

    public $timestamps = false; // Corrigido aqui

    // Definir o relacionamento com o UsuarioModel
    public function usuario()
    {
        return $this->belongsTo(UsuarioModel::class, 'idUsuario');
    }
}
