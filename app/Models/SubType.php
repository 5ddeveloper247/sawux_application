<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubType extends Model
{
    use HasFactory;

    public function parameters()
    {
        return $this->hasMany(DynamicParameter::class,'sub_type_id')->where('status', '1');
    }
}
