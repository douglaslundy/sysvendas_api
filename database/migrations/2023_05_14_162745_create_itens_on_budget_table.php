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
        Schema::create('itens_on_budget', function (Blueprint $table) {
            $table->id();
            $table->integer('id_sale');
            $table->integer('id_user');
            $table->integer('id_product');
            $table->bigInteger('qtd')->default(1);
            $table->integer('item_value')->default(0);
            $table->string('obs', 200)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('itens_on_budget');
    }
};
