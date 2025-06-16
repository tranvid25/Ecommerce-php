<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    protected $fillable=[
       'email',
       'phone',
       'name',
       'id_user',
       'price' 
    ];
}
