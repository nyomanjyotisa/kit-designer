<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Sale extends Model
{
    protected $fillable = ['delilvery_date','customerid','attachment','note','source','sale_status','payment_status'];
}