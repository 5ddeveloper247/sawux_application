<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SidebarMenu extends Model
{
    use HasFactory;
    protected $table='sidebar_menu';
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_sidebar_menu', 'sidebar_menu_id', 'user_id');
    }
}
