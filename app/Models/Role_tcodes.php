<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role_tcodes extends Model
{
    use HasFactory;
    protected $table = 'role_tcodes';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id', 'role_id', 'tcode_id',
    ];
}
