<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function tcodes($role){
        $data = DB::select("SELECT tcodes.id, tcodes.description, tcodes.level_tcode, tcodes.tcode_group, role_tcodes.role_id as selected FROM tcodes left join role_tcodes on tcodes.id = role_tcodes.tcode_id AND role_tcodes.role_id=?  WHERE tcodes.access = 'Public' order by tcodes.id asc",[$role]);
        return $data;
    }
}
