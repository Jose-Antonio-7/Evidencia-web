<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//Softdeletes agregado
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    //Softdeletes agregado
    use HasFactory, SoftDeletes;
    protected $fillable = ['status','direccion','notas','photo','customer_number'];
}
