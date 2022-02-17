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
        Schema::create('itens_sale', function (Blueprint $table) {
            $table->id();
            $table->integer('id_sale');
            $table->integer('id_user');
            $table->integer('id_product');
            $table->string('name_product');
            $table->string('bar_code', 50);
            $table->bigInteger('qdt')->default(1);
            $table->decimal('value', 19,2)->default(0.0000);
            $table->string('item_number', 5);
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
