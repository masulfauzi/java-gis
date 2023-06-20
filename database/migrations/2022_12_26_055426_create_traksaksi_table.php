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
        Schema::create('traksaksi', function (Blueprint $table) {
            $table->string('id', 36)->primary();

            $table->uuid("id_pelanggan")->nullable();
            $table->uuid("id_apotek")->nullable();
            $table->uuid("id_shift")->nullable();
            $table->uuid("invoice_no")->nullable();
            $table->text("keterangan")->nullable();
            $table->string("status")->nullable();
            $table->string("kategori")->nullable();
            $table->bigInteger("diskon")->nullable();
            $table->bigInteger("embalase")->nullable();
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
        Schema::dropIfExists('traksaksi');
    }
};
