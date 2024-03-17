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
            $table->integer('id_client')->nullable();
            $table->timestamp('sale_date');
            $table->enum('paied', ['yes', 'no']);
            $table->enum('type_sale', ['in_cash', 'on_term']);
            $table->timestamp('due_date')->nullable();
            $table->timestamp('pay_date')->nullable();
            $table->decimal('check', 10, 2)->nullable()->default(0);
            $table->decimal('cash', 10, 2)->nullable()->default(0);
            $table->decimal('card', 10 , 2)->nullable()->default(0);
            $table->decimal('total_sale', 10, 2)->default(0);
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
