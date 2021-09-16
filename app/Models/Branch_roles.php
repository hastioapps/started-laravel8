<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch_roles extends Model
{
    use HasFactory;

    protected $table = 'branch_roles';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id', 'user_id', 'branch_id',
    ];
}
