<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmaciaUBSModel extends Model
{
    use HasFactory;

    protected $table = 'tbfarmaciaubs';
    protected $primaryKey = 'idFarmaciaUBS'; // Nome da chave primária
    
    // protected $connection = 'mysql';

    protected $fillable = [
        'nomeFarmaciaUBS',
        'emailFarmaciaUBS',
        'senhaFarmaciaUBS',
        'tipoFarmaciaUBS',
        'situacaoFarmaciaUBS',
        'dataCadastroFarmaciaUBS',
    ];

    public $timestamps = false;


    
}
