<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLendRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lend_records', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unit');
            $table->string('teacher');
            $table->string('hour');
            $table->date('lend_date');
            $table->text('description');
            $table->string('verification');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lend_records');
    }
}
