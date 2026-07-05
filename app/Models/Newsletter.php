<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory;

    protected $table = 'newsletters';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subscribed',
    ];

    protected $casts = [
        'subscribed' => 'boolean',
    ];
}
