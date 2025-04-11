<?php

namespace App\Models\User;

use App\Models\Admin\Blog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'comment',
        'user_id',
        'blog_id',
        'avatar_user',
        'name_user',
        'level',
        'parent_id',
        'time' // Nếu dùng timestamp tự động thì không cần
    ];

    // Nếu dùng timestamps mặc định (khuyên dùng)
    public $timestamps = false; // Thay vì false
    
    // Cast time thành datetime
    protected $casts = [
        'time' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với Blog
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    // Quan hệ với chính nó (reply comments)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
    public function parent(){
        return $this->belongsTo(Comment::class,'parent_id');
    }

    // Tự động set time khi tạo comment
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($comment) {
            $comment->time = Carbon::now();
        });
    }
}
