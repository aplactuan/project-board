<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'change'
    ];

    protected $casts = [
        'change' => 'array'
    ];

    public function subject()
    {
        return $this->morphTo();
    }
}
