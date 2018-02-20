<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table){
            $table->increments('id');
            $table->integer('parent_id')
                ->unsigned()
                ->nullable()
                ->comment('Parent category ID');
            $table->string('title')
                ->comment('Category title');
            $table->text('description')
                ->comment('Category desc');
            $table->string('icon')
                ->comment('Category icon');
            $table->tinyInteger('active');
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
