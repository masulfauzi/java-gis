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
        Schema::create('pembelian_detail', function (Blueprint $table) {
            $table->string('id', 36)->primary();

            $table->uuid("id_pembelian")->nullable();
            $table->uuid("id_produk")->nullable();
            $table->integer("jumlah")->nullable();
            $table->bigInteger("harga")->nullable();
            $table->bigInteger("diskon_rp")->nullable();
            $table->integer("diskon_persen")->nullable();
            $table->tinyInteger("is_beli")->nullable();
            
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
        Schema::dropIfExists('pembelian_detail');
    }
};
