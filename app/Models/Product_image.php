<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Product_image extends Model
{
   
    protected $fillable = [
        'product_id', 'product_image'
    ];
}