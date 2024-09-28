<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalLetterSetting extends Model
{
    use HasFactory;
    protected $table = 'approval_letter_settings';
    protected $primaryKey = 'als_id';
}
