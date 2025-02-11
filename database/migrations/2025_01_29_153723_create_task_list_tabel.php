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
        Schema::create('task_list', function (Blueprint $table) {
            $table->bigIncrements('id_subtask');
            $table->unsignedBigInteger('id_task');
            $table->string('judul_subtask');
            $table->string('keterangan_subtask');
            $table->enum('status_subtask', ['selesai', 'belum_selesai'])->default('belum_selesai');
            $table->timestamps();
            
            $table->foreign('id_task')->references('id_task')->on('task')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_list');
    }
};
