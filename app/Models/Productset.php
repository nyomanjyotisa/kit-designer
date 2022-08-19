<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Productset extends Model
{
   
    protected $fillable = [
        'product_set','parent_productset_id', 'productset_description','price_aud','price_eur','price_gbp','price_usd','price_nzd','minimum','discountLevel','DisableDiscountLevels','pattern','inherit_sizes'
    ];
}