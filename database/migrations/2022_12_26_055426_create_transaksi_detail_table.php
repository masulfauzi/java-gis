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
        Schema::create('transaksi_detail', function (Blueprint $table) {
            $table->string('id', 36)->primary();

            $table->uuid("id_transaksi")->nullable();
            $table->uuid("id_stok_produk")->nullable();
            $table->bigInteger("harga_satuan")->nullable();
            $table->integer("jumlah")->nullable();
            $table->bigInteger("diskon")->nullable();
            $table->bigInteger("subtotoal")->nullable();
            
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
        Schema::dropIfExists('transaksi_detail');
    }
};
