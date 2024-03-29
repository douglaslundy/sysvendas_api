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
        Schema::create('itens_on_sale', function (Blueprint $table) {
            $table->id();
            $table->integer('id_sale');
            $table->integer('id_user');
            $table->integer('id_product');
            $table->decimal('qtd', 10, 2)->default(1);
            $table->decimal('item_value', 10, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('itens_sale');
    }
};
