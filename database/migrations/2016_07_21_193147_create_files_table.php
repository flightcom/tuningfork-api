<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('fileable_id')->nullable();
            $table->string('fileable_type')->nullable();
            $table->string('local_filename');
            $table->string('local_path');
            $table->string('entity');
            $table->integer('width')->unsigned()->nullable();
            $table->integer('height')->unsigned()->nullable();
            $table->integer('crop_x')->unsigned()->nullable();
            $table->integer('crop_y')->unsigned()->nullable();
            $table->string('cropped_filename')->nullable();
            $table->string('cropped_path')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('files');
    }
}
