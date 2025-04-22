<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable=[
        'id_user',
        'name',
        'price',
        'category_id',
        'brand_id',
        'status',
        'sale',
        'company',
        'hinhanh',
        'detail'
    ];
    public function user()
{
    return $this->belongsTo(User::class, 'id_user');
}
}
