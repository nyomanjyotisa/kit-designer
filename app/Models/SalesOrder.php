<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class SalesOrder extends Model
{
    protected $fillable = ['salesid','ordernumber','productset','sizes'];
}