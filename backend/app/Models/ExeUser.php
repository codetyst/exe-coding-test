<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExeUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'phone', 'email', 'password', 'username', 'company', 'nationality'
    ];
}
