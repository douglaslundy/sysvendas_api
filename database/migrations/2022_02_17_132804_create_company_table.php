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
            $table->string('social', 100)->nullable();
            $table->string('cnpj_cpj', 18)->unique()->nullable();
            $table->string('ie', 18)->unique()->nullable();
            $table->string('im', 18)->unique()->nullable();
            $table->decimal('balance', 10, 2)->nullable()->default(0);
            $table->timestamp('validate')->nullable();
            $table->boolean('active')->nullable()->default(1);
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
