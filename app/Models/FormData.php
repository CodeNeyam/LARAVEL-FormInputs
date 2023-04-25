<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Creating of the modal 
class FormData extends Model
{
    use HasFactory;
    // Make sure to always have this lines of the data you want to submit
    protected $fillable = ["text" , "email", "number", "img" , "select" , "file" , "url" , "checkboxes", "radio", "date"];
}
