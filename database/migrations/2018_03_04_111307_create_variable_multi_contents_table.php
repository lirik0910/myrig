<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVariableMultiContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variable_multi_contents', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->increments('id');

            $table->integer('page_id', false, true)
                ->default(0)
                ->comment('Page ID');
            $table->integer('variable_id', false, true)
                ->default(0)
                ->comment('Variable ID');
            $table->integer('content_id')
                ->nullable('false')
                ->unsigned()
                ->comment('Part ID for variable content on page');
            $table->string('name', 255)
                ->nullable(true)
                ->comment('Name for multiple variable part');
            $table->text('content')
                ->nullable(true)
                ->comment('Variable content');

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
        //
    }
}
