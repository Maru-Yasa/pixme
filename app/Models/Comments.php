<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class Comments extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner',
        'comment'
    ];

}
