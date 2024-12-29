<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueConstraintToTbContato extends Migration
{
    public function up()
    {
        Schema::table('tbContato', function (Blueprint $table) {
            // Supondo que 'mensagemContato' e outra coluna sejam relevantes
            $table->unique(['mensagemContato'], 'unique_mensagem');
        });
    }

    public function down()
    {
        Schema::table('tbContato', function (Blueprint $table) {
            $table->dropUnique('unique_mensagem');
        });
    }
}
