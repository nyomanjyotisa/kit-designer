<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class OrderItem extends Model
{
    protected $fillable = ['orderid','productset_id','sizes','qty'];
}