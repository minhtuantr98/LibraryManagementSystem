<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrowed_note', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('library_card_id')->unsigned();
            $table->timestamp('date_create')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('date_pay')->nullable();
            $table->boolean('is_payed')->default(0);
            $table->integer('total');
            $table->timestamps();

            $table->foreign('library_card_id')->references('id')->on('library_card');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('borrowed_note');
    }
}
