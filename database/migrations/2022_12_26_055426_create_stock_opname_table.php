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
        Schema::create('stock_opname', function (Blueprint $table) {
            $table->string('id', 36)->primary();

            $table->uuid("id_apotek")->nullable();
            $table->uuid("id_pegawai")->nullable();
            $table->text("keterangan")->nullable();
            $table->dateTime("mulai")->nullable();
            $table->dateTime("selesai")->nullable();
            $table->string("status")->nullable();
            
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
        Schema::dropIfExists('stock_opname');
    }
};
