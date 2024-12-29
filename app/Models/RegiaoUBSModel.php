<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegiaoUBSModel extends Model
{
    use HasFactory;

    protected $table = 'tbRegiaoUBS';
    protected $connection = 'mysql';
    protected $primaryKey = 'idRegiaoUBS';

    protected $fillable = [
        'nomeRegiaoUBS',
        'situacaoRegiaoUBS',
        'dataCadastroRegiaoUBS',
    ];

    public $timestamps = false;
}
