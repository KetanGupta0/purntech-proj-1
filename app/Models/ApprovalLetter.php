<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalLetter extends Model
{
    use HasFactory;
    protected $table = 'approval_letters';
    protected $primaryKey = 'apl_id';
}
