<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationProductPromocodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('productPromocode', function (Blueprint $table) {
            $table->foreign('product_id')
                ->references('id')
                ->on('product')
                ->onDelete('cascade');
        });

        Schema::table('productPromocode', function (Blueprint $table) {
            $table->foreign('promocode_id')
                ->references('id')
                ->on('promocode')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
