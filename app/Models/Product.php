<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Product extends Model
{
   
    protected $fillable = [
        'pro_name', 'pro_author', 'pro_product_set',
    ];
}