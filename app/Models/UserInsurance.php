<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInsurance extends Model
{
    use HasFactory;
    protected $table = 'user_insurances';
    protected $primaryKey = 'uin_id';
    protected $fillable = [
        'uin_policy_number', 'uin_insured_id', 'uin_insured_name', 'uin_nominee', 'uin_sum_assured', 'uin_insurance_premium', 'uin_paid_till', 'uin_balance_amount', 'uin_status'
    ];
}
