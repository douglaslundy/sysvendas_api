<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('fantasy_name', 100);
            $table->string('corporate_name', 100);
            $table->string('email', 100)->unique();
            $table->string('cnpj', 18);
            $table->string('ie', 18)->unique()->nullable();
            $table->string('im', 18)->unique()->nullable();
            $table->decimal('balance', 10, 2)->nullable()->default(0);
            $table->string('zip_code', 10)->nullable();
            $table->string('city', 20)->nullable();
            $table->string('street', 50)->nullable();
            $table->string('number', 10)->nullable();
            $table->string('complement', 50)->nullable();
            $table->string('neighborhood', 50)->nullable();
            $table->string('phone', 20)->nullable();
            $table->date('validity_date');
            $table->boolean('active')->default(1);
            $table->string('master_password');
            $table->boolean('marked')->nullable()->default(0);
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
        Schema::dropIfExists('companies');
    }

}
