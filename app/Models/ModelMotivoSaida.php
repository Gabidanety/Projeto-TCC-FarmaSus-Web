<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelMotivoSaida extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $primaryKey = 'idMotivoSaida';
    protected $table = 'tbmotivosaida';

    protected $fillable = ['motivosaida'];

    public $timestamps = false;

    public function saidasMedicamentos()
    {
        return $this->hasMany(ModelSaidaMedicamento::class, 'idMotivoSaida');
    }
}
