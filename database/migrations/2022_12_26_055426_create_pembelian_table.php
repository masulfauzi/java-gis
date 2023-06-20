<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelian', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            
            $table->string("kode")->nullable();
            $table->uuid("id_supplier")->nullable();
            $table->uuid("id_apotek")->nullable();
            $table->uuid("id_shift")->nullable();
            $table->string("no_batch")->nullable();
            $table->date("tanggal")->nullable();
            $table->string("tahap")->nullable();
            $table->date("tanggal_tempo")->nullable();
            $table->bigInteger("diskon_rp")->nullable();
            $table->integer("diskon_persen")->nullable();
            $table->bigInteger("ppn")->nullable();
            $table->bigInteger("total")->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->string('created_by', 36)->nullable();
            $table->string('updated_by', 36)->nullable();
            $table->string('deleted_by', 36)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembelian');
    }
};
