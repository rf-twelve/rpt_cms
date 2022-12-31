<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRptAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rpt_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('rpt_arp_no')->nullable();
            $table->string('rpt_td_no')->nullable();
            $table->string('rpt_pin')->nullable();
            $table->string('rpt_kind')->nullable();
            $table->string('rpt_class')->nullable();
            $table->longText('ro_name')->nullable();
            $table->string('ro_address')->nullable();
            $table->string('ro_date_transfer')->nullable();
            $table->string('lp_lot_blk_no')->nullable();
            $table->string('lp_street')->nullable();
            $table->string('lp_brgy')->nullable();
            $table->string('lp_municity')->nullable();
            $table->string('lp_province')->nullable();
            $table->string('rtdp_av_land')->nullable();
            $table->string('rtdp_av_improve')->nullable();
            $table->string('temp_1957_1966')->nullable();
            $table->string('temp_1967_1973')->nullable();
            $table->string('temp_1974_1979')->nullable();
            $table->string('temp_1980_1984')->nullable();
            $table->string('temp_1985_1993')->nullable();
            $table->string('temp_1994_1996')->nullable();
            $table->string('temp_1997_2002')->nullable();
            $table->string('temp_2003_2019')->nullable();
            $table->string('rtdp_av_old')->nullable();
            $table->string('rtdp_av_new')->nullable();
            $table->string('rtdp_av_total')->nullable();
            $table->string('rtdp_tax_year')->nullable();
            $table->string('rtdp_td_basic')->nullable();
            $table->string('rtdp_td_sef')->nullable();
            $table->string('rtdp_td_penalty')->nullable();
            $table->string('rtdp_td_total')->nullable();
            $table->string('rtdp_tc_basic')->nullable();
            $table->string('rtdp_tc_sef')->nullable();
            $table->string('rtdp_tc_penalty')->nullable();
            $table->string('rtdp_tc_total')->nullable();
            $table->string('rtdp_or_no')->nullable();
            $table->string('rtdp_payment_date')->nullable();
            $table->string('rtdp_payment_covered_year')->nullable();
            $table->string('rtdp_payment_covered_fr')->nullable();
            $table->string('rtdp_payment_covered_to')->nullable();
            $table->string('rtdp_bal_basic')->nullable();
            $table->string('rtdp_bal_sef')->nullable();
            $table->string('rtdp_bal_penalty')->nullable();
            $table->string('rtdp_bal_total')->nullable();
            $table->string('rtdp_remarks')->nullable();
            $table->string('rtdp_directory')->nullable();
            $table->string('rtdp_payment_start')->nullable();
            $table->string('rtdp_status')->nullable();
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
        Schema::dropIfExists('rpt_accounts');
    }
}
