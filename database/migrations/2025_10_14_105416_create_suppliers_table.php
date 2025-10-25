<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('suppliers')) {
            Schema::create('suppliers', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('contact')->nullable(); // Telepon
                $table->string('contact_email')->nullable(); // Email
                $table->text('address')->nullable(); // Alamat
                $table->enum('status', ['active','inactive'])->default('active'); // Status aktif/nonaktif
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
