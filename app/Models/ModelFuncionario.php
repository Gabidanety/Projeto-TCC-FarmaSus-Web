<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelFuncionario extends Model
{
    protected $table = 'tbFuncionarioFarmaciaUBS';

    protected $connection = 'mysql2';

    
    protected $primaryKey = 'idFuncionario'; 
    // Desativa o uso dos timestamps
    public $timestamps = false;

    protected $fillable = [
        'nomeFuncionario',
        'cpfFuncionario',
        'cargoFuncionario',
        'situacaoFuncionario',
        'dataCadastroFuncionario',
    ];
}
