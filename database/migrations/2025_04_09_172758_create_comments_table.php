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
        Schema::create('comments', function (Blueprint $table) {
            // Cột chính
            $table->id();
            
            // Khóa ngoại
            $table->unsignedBigInteger('blog_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            
            // Nội dung
            $table->text('comment');
            
            // Thông tin user (cache)
            $table->string('avatar_user');
            $table->string('name_user');
            
            // Phân loại
            $table->integer('level')->default(0);
            
            // Timestamp
            $table->timestamp('time')->useCurrent();
            
            // Khóa ngoại
            $table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('comments')->onDelete('cascade');
            
            // Index
            $table->index('blog_id');
            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
};
