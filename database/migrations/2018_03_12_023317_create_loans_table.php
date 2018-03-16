<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->float('deposit_price');
            $table->boolean('deposit_received')->default(false);
            $table->boolean('deposit_returned')->default(false);
            $table->uuid('instrument_id');
            $table->uuid('user_id');
            $table->text('comment');
            $table->string('status');
            $table->datetime('ending_at');
            $table->datetime('ended_at');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('instrument_id')
                ->references('id')
                ->on('instruments')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('loans');
    }
}
