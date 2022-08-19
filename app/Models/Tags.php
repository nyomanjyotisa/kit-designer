<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Tags extends Model
{
   
    protected $fillable = ['tag_category','name','machine_name'];
}