<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('pengumpulan_tugas', function (Blueprint $table) {
    $table->id();
    $table->foreignId('tugas_id')->constrained('tugas')->cascadeOnDelete();
    $table->foreignId('siswa_id')->constrained('users')->cascadeOnDelete();
    $table->string('file');
    $table->text('catatan')->nullable();
    $table->enum('status', ['dikirim', 'dinilai', 'revisi'])->default('dikirim');
    $table->integer('nilai')->nullable();
    $table->timestamps();
});

}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumpulan_tugas');
    }
};
