<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    protected $table = 'companies';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'id', 'name', 'address', 'currency_id', 'email', 'phone', 'npwp', 'npwp_name', 'npwp_address', 'img', 'owner',
    ];
}
