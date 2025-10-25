<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Tambahkan user_id hanya jika belum ada
            if (!Schema::hasColumn('transactions', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('quantity');
            }

            // Tambahkan status hanya jika belum ada
            if (!Schema::hasColumn('transactions', 'status')) {
                $table->string('status')->default('pending')->after('user_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Hapus kolom hanya jika ada
            if (Schema::hasColumn('transactions', 'user_id')) {
                $table->dropColumn('user_id');
            }

            if (Schema::hasColumn('transactions', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
