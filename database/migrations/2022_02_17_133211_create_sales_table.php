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
            $table->decimal('chek', 19,2)->default(0.0000);
            $table->decimal('cash', 19,2)->default(0.0000);
            $table->decimal('card', 19,2)->default(0.0000);
            $table->decimal('total_sale', 19,2)->default(0.0000);
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
