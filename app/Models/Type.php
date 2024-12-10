<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    public function subTypes()
    {
        return $this->hasMany(SubType::class,'type_id')->where('status', '1');
    }

    public function parameters()
    {
        return $this->hasMany(DynamicParameter::class,'type_id')->where('status', '1');
    }
}
