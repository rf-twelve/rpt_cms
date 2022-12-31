<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRptQuarter1sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rpt_quarter1s', function (Blueprint $table) {
            $table->id();
            $table->string('bracket_code')->nullable();
            $table->string('year_from')->nullable();
            $table->string('year_to')->nullable();
            $table->string('label')->nullable();
            $table->string('january')->nullable();
            $table->string('february')->nullable();
            $table->string('march')->nullable();
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
        Schema::dropIfExists('rpt_quarter1s');
    }
}
