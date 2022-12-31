<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListBarangaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_barangays', function (Blueprint $table) {
            $table->id();
            $table->string('region_id')->nullable();
            $table->string('province_id')->nullable();
            $table->string('municity_id')->nullable();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('index')->nullable();
            $table->string('urban_rural')->nullable();
            $table->string('population')->nullable();
            $table->integer('is_active')->nullable();
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
        Schema::dropIfExists('list_barangays');
    }
}
