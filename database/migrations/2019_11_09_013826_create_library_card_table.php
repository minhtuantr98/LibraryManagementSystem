<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLibraryCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('library_card', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('reader_id')->unsigned();
            $table->bigInteger('admin_id')->unsigned();
            $table->timestamp('date_create')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('date_end')->nullable();
            $table->timestamps();

            $table->foreign('reader_id')->references('id')->on('readers');
            $table->foreign('admin_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('library_card');
    }
}
