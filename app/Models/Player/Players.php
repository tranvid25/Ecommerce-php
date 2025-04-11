<?php

namespace App\Models\Player;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Players extends Model
{
    use HasFactory;
    protected $table='players';
    public $timestamps=true;
    protected $fillable=[
        'name','age','nation','position','salary'
    ];
}
