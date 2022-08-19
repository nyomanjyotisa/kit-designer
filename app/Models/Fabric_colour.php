<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Fabric_colour extends Model
{
    protected $fillable = ['name','pms','hex','fabricId'];
}