<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Designpattern extends Model
{
    protected $fillable = ['product_design_id','parent_product_set','patternName','patternURL','patternweight'];
}