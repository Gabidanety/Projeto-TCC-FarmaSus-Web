<?php

namespace App\Models;

    use Illuminate\Contracts\Auth\Authenticatable;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

    class AdministradorModel extends Model implements Authenticatable
    {
        use HasFactory;
        use AuthenticatableTrait; // Esse trait fornece todos os métodos necessários para a interface Authenticatable.
    
        protected $table = 'tbadministrador'; // Nome da tabela
        protected $connection = 'mysql';
    
        protected $fillable = [
            'fotoAministrador',
            'nomeAdministrador',
            'emailAdministrador',
            'senhaAdministrador',
            'situacaoAdministrador',
            'dataCadastroAdministrador',
        ];
    
        protected $hidden = [
            'senhaAdministrador'
        ];
    
        public $timestamps = false;
    
    
}
