<?php

namespace App\Models\Admin;

use App\Models\User;
use App\Models\Admin\Blog; // 👈 Đảm bảo đã import Blog nếu dùng
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Rate extends Model
{
    use HasFactory;

    protected $table = 'rates'; // 👈 Nên khai báo rõ nếu dùng tên bảng số nhiều

    // Cho phép fill các cột này
    protected $fillable = ['rate', 'blog_id', 'user_id'];

    // Laravel sẽ tự xử lý created_at và updated_at
    public $timestamps = true;

    // Quan hệ với bảng blog
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    // Quan hệ với bảng user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Format thời gian tạo đánh giá
    public function getFormattedTimeAttribute()
    {
        return Carbon::parse($this->created_at)->format('d/m/Y H:i');
    }
}
