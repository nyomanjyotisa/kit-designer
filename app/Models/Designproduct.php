<?php

namespace App\Models; 
use Illuminate\Database\Eloquent\Model;
class Designproduct extends Model
{
    protected $fillable = ['design_pro_name','design_thumbnail','design_tags','design_category','design_product_set_id','design_product_url','design_weight'];
}

