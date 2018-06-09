<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_attributes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->increments('id');

            $table->integer('user_id', false, true)
                ->comment('User ID');

            $table->string('fname', 255)
                ->nullable()
                ->comment('User`s first name');

            $table->string('lname', 255)
                ->nullable()
                ->comment('User`s last name');

            $table->string('phone', 255)
                ->nullable()
                ->comment('Billing phone');

            $table->text('address')
                ->nullable()
                ->comment('Billing address');

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
        Schema::dropIfExists('user_attributes');
    }
}
