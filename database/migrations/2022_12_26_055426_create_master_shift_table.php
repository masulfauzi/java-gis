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
        Schema::create('master_shift', function (Blueprint $table) {
            $table->string('id', 36)->primary();

            $table->uuid("id_apotek")->nullable();
            $table->uuid("shift_ke")->nullable();
            $table->uuid("nama_shift")->nullable();
            $table->timestamp("mulai")->nullable();
            $table->timestamp("selesai")->nullable();
            $table->tinyInteger("is_strict")->nullable();
            
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
        Schema::dropIfExists('master_shift');
    }
};
