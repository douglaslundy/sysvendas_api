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
        Schema::create('company', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('social', 100);
            $table->string('cnpj_cpj', 18)->unique();
            $table->string('ie', 18)->unique()->nullable();
            $table->string('im', 18)->unique()->nullable();
            $table->decimal('balance', 19,4)->default(0.0000);
            $table->timestamp('validate');
            $table->boolean('active', 1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company');
    }
};
