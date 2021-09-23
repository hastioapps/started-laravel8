<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id', 'role_name', 'company_id',
    ];

    public function scopeFilter($query,$search,$qtype)
    {
        if (isset($search) && isset($qtype)){
            return $query->where($qtype, 'LIKE',  $search.'%');
        }
    }
}
