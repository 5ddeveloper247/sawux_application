<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;


    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function users(){
        return $this->hasMany(User::class,'customer_id');
    }
}
