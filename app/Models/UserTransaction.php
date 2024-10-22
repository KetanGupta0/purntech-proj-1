<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTransaction extends Model
{
    use HasFactory;
    protected $table = 'user_transactions';
    protected $primaryKey = 'tid';

    protected $fillable = [
        'tnx_user_id', 'tnx_id', 'tnx_amt', 'tnx_mode', 'tnx_date', 'tnx_proof'
    ];
}
