<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $table = 'locations';
    protected $primaryKey = 'loc_user_id';
    protected $fillable = [
        'loc_user_id','loc_latitude', 'loc_longitude', 'loc_status'
    ];
}
