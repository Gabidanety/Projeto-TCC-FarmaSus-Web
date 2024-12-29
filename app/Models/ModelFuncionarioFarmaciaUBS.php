<?php
//Tabela da Farmacia

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ModelFuncionarioFarmaciaUBS extends Model
{
    use HasFactory;

    // Defina a conexão para 'mysql2'
    protected $connection = 'mysql2';  // Isso garante que ele use o banco bdfarmaciaubs
    protected $table = 'tbFuncionarioFarmaciaUBS';
    protected $primaryKey = 'idFuncionario';


    protected $fillable = [
        'nomeFuncionario',
        'cpfFuncionario',
        'cargoFuncionario',
        'situacaoFuncionario',
        'dataCadastroFuncionario'
    ];

    public function entradas()
    {
        return $this->hasMany(ModelEntradaMedicamento::class, 'idFuncionario');
    }

    public function estoques()
    {
        return $this->hasMany(ModelEstoqueFarmaciaUBS::class, 'idFuncionario');
    }
}
