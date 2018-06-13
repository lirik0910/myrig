<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderDeliveryCollumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_deliveries', function (Blueprint $table) {
        	
            $table->string('office', 255)
                ->nullable(true)
                ->comment('post office');

            $table->string('zendesk', 255)
                ->nullable(true)
                ->comment('Zendesk number');

            $table->string('warranty', 255)
                ->nullable(true)
                ->comment('Customer comment');

            $table->string('passport', 255)
                ->nullable(true)
                ->comment('Passport data');
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
