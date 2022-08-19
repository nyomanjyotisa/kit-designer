<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Order extends Model
{
    protected $fillable = ['firstname','lastname','address','city','postcode','country','emailaddress','mobilephone','workphone','ordernumber'];
}