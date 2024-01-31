<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\NivelCargoEnum;

class Cargo extends Model
{
    use HasFactory;

    protected $casts = [
    'nivel' => NivelCargoEnum::class,
    ];

    public $incrementing = false;
    public $timestamps = false;
}
