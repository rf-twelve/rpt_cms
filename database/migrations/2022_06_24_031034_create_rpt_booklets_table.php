<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRptBookletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rpt_booklets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('teller_id');
            $table->string('tellercode');
            $table->string('form_type');
            $table->string('serial_begin_from');
            $table->string('serial_begin_to');
            $table->string('serial_begin_qty');
            $table->string('serial_issued_from');
            $table->string('serial_issued_to');
            $table->string('serial_issued_qty');
            $table->string('serial_end_from');
            $table->string('serial_end_to');
            $table->string('serial_end_qty');
            $table->string('payment_type');
            $table->string('amount');
            $table->string('remarks');
            $table->string('report_id');
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
        Schema::dropIfExists('rpt_booklets');
    }
}
