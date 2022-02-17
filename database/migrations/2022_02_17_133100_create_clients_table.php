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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 50);
            $table->string('last_name', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('im', 18)->unique()->nullable();
            $table->string('ie', 18)->unique()->nullable();
            $table->string('fantasy_name', 50)->nullable();
            $table->string('obs', 500)->nullable();
            $table->boolean('active')->default(1);
            $table->timestamp('inactive_date')->nullable();
            $table->decimal('debit_balance', 19,4)->default(0.0000);
            $table->decimal('limit', 19,4)->default(0.0000);
            $table->boolean('marked')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
};
