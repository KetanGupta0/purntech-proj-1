<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpRecord extends Model
{
    use HasFactory;
    protected $table = 'otp_records';
    protected $primaryKey = 'otp_id';
}
