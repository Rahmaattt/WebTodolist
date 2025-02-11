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
        Schema::create('task', function (Blueprint $table) {
            $table->bigIncrements('id_task');
            $table->unsignedBigInteger('id_user');
            $table->string('judul_task');
            $table->string('keterangan_task');
            $table->enum('status_task', ['selesai', 'belum_selesai', 'terlambat'])->default('belum_selesai');
            $table->enum('prioritas', ['tinggi', 'sedang', 'rendah'])->default('sedang');
            $table->dateTime('deadline')->nullable();
            $table->timestamps();
            
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task');
    }
};
