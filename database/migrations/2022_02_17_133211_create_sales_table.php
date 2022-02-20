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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->integer('id_client');
            $table->timestamp('sale_date');
            $table->string('paied', ['yes', 'no']);
            // in_cash = 'a vista'| on_term = 'a prazo'
            $table->string('type_sale', ['in_cash', 'on_term']);
            $table->timestamp('due_date');
            $table->timestamp('pay_date');
            $table->integer('chek')->nullable()->default(0);
            $table->integer('cash')->nullable()->default(0);
            $table->integer('card')->nullable()->default(0);
            $table->integer('total_sale')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
};
