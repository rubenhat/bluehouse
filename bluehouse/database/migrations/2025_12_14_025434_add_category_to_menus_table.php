<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('menus', function (Blueprint $table) {
            // Tambahkan kolom category jika belum ada
            if (!Schema::hasColumn('menus', 'category')) {
                $table->string('category')->default('food')->after('description');
            }

            // Tambahkan kolom lain yang mungkin hilang
            if (!Schema::hasColumn('menus', 'is_available')) {
                $table->boolean('is_available')->default(true)->after('category');
            }

            if (!Schema::hasColumn('menus', 'image')) {
                $table->string('image')->nullable()->after('is_available');
            }
        });
    }

    public function down()
    {
        Schema::table('menus', function (Blueprint $table) {
            if (Schema::hasColumn('menus', 'category')) {
                $table->dropColumn('category');
            }

            if (Schema::hasColumn('menus', 'is_available')) {
                $table->dropColumn('is_available');
            }

            if (Schema::hasColumn('menus', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};
