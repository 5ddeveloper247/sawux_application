<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function sidebarMenus()
    {
        return $this->belongsToMany(SidebarMenu::class, 'user_sidebar_menu', 'user_id', 'sidebar_menu_id');
    }

    public function customersCreated(){
        return $this->hasMany(Customer::class, 'created_by'); 
    }

    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }
    public function auditTrails()
    {
        return $this->hasMany(AuditTrail::class, 'user_id');
    }
}
