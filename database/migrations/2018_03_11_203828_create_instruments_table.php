<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstrumentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('instruments', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('model');
            $table->string('serial_number')->nullable();
            $table->integer('condition')->nullable();
            $table->boolean('to_be_checked')->default(false);
            $table->string('barcode')->nullable();
            $table->text('comment')->nullable();
            $table->uuid('brand_id')->nullable();
            $table->uuid('category_id')->nullable();
            $table->uuid('store_id')->nullable();
            $table->timestamps();

            $table->foreign('brand_id')
                ->references('id')
                ->on('brands')
                ->onDelete('set null');

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('set null');

            $table->foreign('store_id')
                ->references('id')
                ->on('stores')
                ->onDelete('set null');

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('instruments');
    }
}
