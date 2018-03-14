<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('locatable_id')->nullable();
            $table->string('locatable_type')->nullable();
            $table->string('address');
            $table->string('address_more')->nullable();
            $table->string('postalCode');
            $table->string('city');
            $table->string('country');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('locations');
    }
}
