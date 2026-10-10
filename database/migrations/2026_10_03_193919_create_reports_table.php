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
        Schema::create('reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('title',150);
            $table->text('description');
            $table->enum('category', ['merusak fasilitas', 'membuat kegaduhan', 'parkir sembarangan', 'merokok di lingkungan sekolah', 'lainnya']);
            $table->text('location');
            $table->enum('status', ['menunggu', 'diproses', 'ditolak', 'selesai'])->default('menunggu');
            $table->string('evidence_image')->nullable();
            $table->timestamps();

            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
