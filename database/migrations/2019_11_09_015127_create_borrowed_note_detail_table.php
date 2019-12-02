<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowedNoteDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrowed_note_detail', function (Blueprint $table) {
            $table->bigInteger('book_detail_id');
            $table->bigInteger('borrowed_note_id')->unsigned();
            $table->double('indemnification_money');
            $table->timestamp('date_pay_real')->nullable();
            $table->timestamps();
            
            $table->primary('book_detail_id', 'borrowed_note_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('borrowed_note_detail');
    }
}
