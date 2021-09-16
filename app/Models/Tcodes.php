<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tcodes extends Model
{
    use HasFactory;

    protected $table = 'tcodes';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id', 'description','level_tcode','parent','icon','tcode_group_id','access',
    ];
}
