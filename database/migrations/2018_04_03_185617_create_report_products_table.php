<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('report_id', false, true)
                ->default(0)
                ->comment('Report ID');
            $table->integer('product_id', false, true)
                ->default(0)
                ->comment('Product ID');
            $table->integer('count', false, true)
                ->default(1)
                ->comment('Product count');
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
        Schema::dropIfExists('report_products');
    }
}
