<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Productset_document extends Model
{
   
    protected $fillable = [
        'productset_document_id','productset_id', 'document_name','document_attachment'
    ];
}