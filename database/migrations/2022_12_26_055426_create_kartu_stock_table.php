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
        Schema::create('kartu_stock', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            
            $table->uuid("id_produk")->nullable();
            $table->uuid("id_apotek")->nullable();
            $table->integer("in")->nullable();
            $table->integer("out")->nullable();
            $table->integer("stock")->nullable();
            $table->text("deskripsi")->nullable();

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
        Schema::dropIfExists('kartu_stock');
    }
};
