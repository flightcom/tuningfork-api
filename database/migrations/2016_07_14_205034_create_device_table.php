<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function($table) {
            $table->uuid('id');
            $table->uuid('user_id');
            $table->string('token');
            $table->string('type');
            $table->string('uuid')->unique();
            $table->boolean('push_notifications_active')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::drop('devices');
    }
}
