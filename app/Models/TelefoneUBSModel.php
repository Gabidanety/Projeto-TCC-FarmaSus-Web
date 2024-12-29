<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelefoneUBSModel extends Model
{
    use HasFactory;

    protected $table = 'tbTelefoneUBS';
    protected $connection = 'mysql';

    protected $primaryKey = 'idTelefoneUBS';

    protected $fillable = [
        'numeroTelefoneUBS',
        'numeroTelefoneUBS2',
        'situacaoTelefoneUBS',
        'dataCadastroTelefoneUBS',
    ];

    public $timestamps = false;
}
