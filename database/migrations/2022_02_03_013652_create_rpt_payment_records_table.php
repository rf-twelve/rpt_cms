<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRptPaymentRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rpt_payment_records', function (Blueprint $table) {
            $table->id();
            $table->string('pay_id')->nullable();
            $table->string('pay_date')->nullable();
            $table->string('pay_fund')->nullable();
            $table->string('pay_type')->nullable();
            $table->string('pay_teller')->nullable();
            $table->string('serial_no')->nullable();
            $table->string('pay_year_from')->nullable();
            $table->string('pay_year_to')->nullable();
            $table->string('pay_quarter_from')->nullable();
            $table->string('pay_quarter_to')->nullable();
            $table->string('pay_basic')->nullable();
            $table->string('pay_sef')->nullable();
            $table->string('pay_penalty')->nullable();
            $table->string('pay_amount_due')->nullable();
            $table->string('pay_cash')->nullable();
            $table->string('pay_change')->nullable();
            $table->string('pay_directory')->nullable();
            $table->string('pay_remarks')->nullable();
            $table->string('pay_status')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('rpt_account_id')->index();
            $table->foreign('rpt_account_id')
                ->references('id')
                ->on('rpt_accounts')
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
        Schema::dropIfExists('rpt_payment_records');
    }
}
