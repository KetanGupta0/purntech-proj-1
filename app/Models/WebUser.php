<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebUser extends Model
{
    use HasFactory;
    protected $table = 'web_users';
    protected $primaryKey = 'usr_id';
}
