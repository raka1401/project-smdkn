<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('indikator_tujuan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tujuan_id');
            $table->foreign('tujuan_id')->references('id')->on('tujuan')->onDelete('cascade');
            $table->string('nama_indikator');
            $table->string('satuan')->nullable();
            $table->integer('t1')->nullable();
            $table->integer('t2')->nullable();
            $table->integer('t3')->nullable();
            $table->integer('t4')->nullable();
            $table->integer('t5')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indikator_tujuan');
    }
};
