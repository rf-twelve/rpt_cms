<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssmtRollAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assmt_roll_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('assmt_roll_td_arp_no')->nullable();
            $table->string('assmt_roll_pin')->nullable();
            $table->string('assmt_roll_lot_blk_no')->nullable();
            $table->text('assmt_roll_owner')->nullable();
            $table->text('assmt_roll_address')->nullable();
            $table->string('assmt_roll_brgy')->nullable();
            $table->string('assmt_roll_municity')->nullable();
            $table->string('assmt_roll_province')->nullable();
            $table->string('assmt_roll_kind')->nullable();
            $table->string('assmt_roll_class')->nullable();
            $table->string('assmt_roll_av')->nullable();
            $table->string('assmt_roll_effective')->nullable();
            $table->string('assmt_roll_td_arp_no_prev')->nullable();
            $table->string('assmt_roll_av_prev')->nullable();
            $table->text('assmt_roll_remarks')->nullable();
            $table->string('encoded_by')->nullable();
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
        Schema::dropIfExists('assmt_roll_accounts');
    }
}
