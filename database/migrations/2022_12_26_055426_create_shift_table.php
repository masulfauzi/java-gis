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
        Schema::create('shift', function (Blueprint $table) {
            $table->string('id', 36)->primary();

            $table->uuid("id_master_shift")->nullable();
            $table->uuid("id_pegawai")->nullable();
            $table->date("tanggal")->nullable();
            $table->integer("jumlah_transaksi")->nullable();
            $table->bigInteger("omzet")->nullable();
            $table->bigInteger("uang_fisik")->nullable();
            $table->bigInteger("selisih")->nullable();
            $table->text("catatan")->nullable();
            
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
        Schema::dropIfExists('shift');
    }
};
