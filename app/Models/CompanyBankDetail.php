<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyBankDetail extends Model
{
    use HasFactory;
    protected $table = "company_bank_details";
    protected $primaryKey = "cbd_id";
}
