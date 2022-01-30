<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class Pages extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner',
        'visitors',
        'comments_count',
        'desc'
    ];


}
