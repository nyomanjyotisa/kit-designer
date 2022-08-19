<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id','design'];

    public function customer(){
        return $this->belongsTo('App\Models\Customer', 'customer_id', 'id');
    }
}
