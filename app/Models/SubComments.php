<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class SubComments extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner',
        'parent_comment',
        'comment',
    ];


}
