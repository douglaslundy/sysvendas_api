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
        Schema::table('itens_on_sale', function (Blueprint $table) {
            $table->decimal('cost_value', 10, 2)->after('qtd')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('itens_on_sale', function (Blueprint $table) {
            $table->dropColumn('cost_value');
        });
    }
};
