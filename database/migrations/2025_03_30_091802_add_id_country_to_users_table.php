<?php

use App\Models\Admin\Country;
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
        Schema::table('users', function (Blueprint $table) {
            // Bước 1: Thêm cột trước mà chưa có khóa ngoại
            $table->unsignedBigInteger('id_country')->nullable()->after('avatar');
        });
    
        Schema::table('users', function (Blueprint $table) {
            // Bước 2: Sau đó mới thêm khóa ngoại
            $table->foreign('id_country')->references('id')->on('countries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_country']);
            $table->dropColumn('id_country');
        });
    }
};
