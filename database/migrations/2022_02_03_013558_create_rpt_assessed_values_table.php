<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRptAssessedValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rpt_assessed_values', function (Blueprint $table) {
            $table->id();
            $table->string('av_pin')->nullable();
            $table->string('av_year_from')->nullable();
            $table->string('av_year_to')->nullable();
            $table->string('av_value')->nullable();
            $table->string('av_status')->nullable();
            $table->string('av_encoded_by')->nullable();
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
        Schema::dropIfExists('rpt_assessed_values');
    }
}
