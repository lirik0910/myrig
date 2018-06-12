<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->increments('id');
            $table->string('name', 255)
                ->nullable(false)
                ->comment('Client name');
            $table->string('email', 255)
                ->nullable(false)
                ->comment('Client email');
            $table->string('phone', 255)
                ->nullable(false)
                ->comment('Client phone');
            $table->boolean('check')
                ->default(0)
                ->comment('Report status');
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
        Schema::dropIfExists('reports');
    }
}
