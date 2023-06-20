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
        Schema::create('produk', function (Blueprint $table) {
            $table->string('id', 36)->primary();

            $table->uuid("id_satuan")->nullable();
            $table->uuid("id_golongan")->nullable();
            $table->uuid("id_jenis")->nullable();
            $table->string("nama_produk")->nullable();
            $table->text("deskripsi")->nullable();
            $table->integer("stock")->nullable();
            $table->bigInteger("harga_jual")->nullable();
            $table->bigInteger("harga_beli")->nullable();
            
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
        Schema::dropIfExists('produk');
    }
};
