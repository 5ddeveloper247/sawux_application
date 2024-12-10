<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicParameter extends Model
{
    use HasFactory;

    public function subType()
    {
        return $this->belongsTo(SubType::class,'sub_type_id');
    }
    
    public function type()
    {
        return $this->belongsTo(Type::class,'type_id');
    }
}
