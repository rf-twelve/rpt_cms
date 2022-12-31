<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRptAccountableFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rpt_accountable_forms', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->string('form_name')->nullable();
            $table->string('begin_qty')->nullable();
            $table->string('begin_serial_from')->nullable();
            $table->string('begin_serial_to')->nullable();
            $table->string('issued_qty')->nullable();
            $table->string('issued_serial_from')->nullable();
            $table->string('issued_serial_to')->nullable();
            $table->string('end_qty')->nullable();
            $table->string('end_serial_from')->nullable();
            $table->string('end_serial_to')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rpt_accountable_forms');
    }
}
