<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Product_colours extends Model
{
   
    protected $fillable = [
        'product_id', 'colour','product_color_image'
    ];
}