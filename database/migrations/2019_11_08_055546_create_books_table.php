<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('admin_id')->unsigned();
            $table->string('title', 255);
            $table->string('slug',255);
            $table->integer('number_of_page');
            $table->double('price');
            $table->integer('total');
            $table->string('author');
            $table->string('image');
            $table->string('publishing_company');
            $table->bigInteger('location_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('users');
            $table->foreign('location_id')->references('id')->on('book_location');
            $table->foreign('category_id')->references('id')->on('book_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
