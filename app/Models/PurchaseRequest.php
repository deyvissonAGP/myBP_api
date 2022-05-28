<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id', 'status', 'cliente_id', 'produto_id'
    ];
}