<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionsLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_logs', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('user_id')->nullable();
            $table->uuid('loggable_id');
            $table->string('loggable_type');
            $table->string('type');
            $table->text('old')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('action_logs');
    }
}
