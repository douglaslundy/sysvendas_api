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
            $table->string('cpf_cnpj_chek', 18);
            $table->integer('check_number');
            $table->integer('id_client');
            $table->timestamp('date_chek');
            $table->timestamp('date_pay')->nullable();
            $table->timestamp('date_pay_out')->nullable();
            $table->enum('situation', ['late','waiting' ,'returned', 'paied']);
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
