<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cheks', function (Blueprint $table) {
            $table->id();
            $table->string('cpf_cnpj');
            $table->integer('id_client');
            $table->timestamp('date_chek');
            $table->timestamp('date_pay');
            $table->timestamp('date_pai_out');
            $table->string('situation', ['late','' ,'returned', 'paied']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cheks');
    }
};
