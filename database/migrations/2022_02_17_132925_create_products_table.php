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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('bar_code', 50)->unique();
            $table->integer('id_unity');
            $table->integer('id_category');
            $table->decimal('cost_value', 10, 2)->default(0);
            $table->decimal('sale_value', 10, 2)->default(0);
            $table->decimal('stock', 10, 3)->default(0);
            $table->boolean('active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
