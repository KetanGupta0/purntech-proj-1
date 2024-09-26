<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDescriptionAmount extends Model
{
    use HasFactory;
    protected $table = 'invoice_description_amounts';
    protected $primaryKey = 'ida_id';
}
