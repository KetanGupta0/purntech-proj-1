<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceLogo extends Model
{
    use HasFactory;
    protected $table = 'invoice_logos';
    protected $primaryKey = 'img_id';
    protected $fillable = [
        'img_inv_id',
        'img_inv_no',
        'img_name',
        'img_status',
    ];
}
