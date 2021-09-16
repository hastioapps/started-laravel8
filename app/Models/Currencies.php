<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currencies extends Model
{
    use HasFactory;

    protected $table = 'currencies';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id', 'description',
    ];
}
