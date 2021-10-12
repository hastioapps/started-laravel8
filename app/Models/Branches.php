<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branches extends Model
{
    use HasFactory;

    protected $table = 'branches';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'id', 'code', 'name', 'address', 'email', 'phone', 'manager', 'company_id',
    ];

    public function scopeFilter($query,$search,$qtype)
    {
        if (isset($search) && isset($qtype)){
            return $query->where($qtype, 'LIKE',  $search.'%');
        }
    }
}
