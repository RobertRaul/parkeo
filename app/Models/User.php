<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = "usuarios";
    protected $primaryKey = "us_id";
    public $timestamps = false;

    protected $fillable = [
       'us_usuario','us_password','us_rol','us_empid'
    ];

    public function getAuthPassword()
    {
        return $this->us_password;
    }

    public function scopeSearch($query,$val)
    {
        return $query
        ->where('us_usuario','like','%' . $val . '%')
        ->Orwhere('us_password','like','%' . $val . '%')
        ->Orwhere('us_rol','like','%' . $val . '%')
        ->Orwhere('us_empid','like','%' . $val . '%')
        ->join('empleados','emp_id','=','us_empid');
    }
    
    public function Empleados()
    {
        return $this->hasOne(Empleado::class,'emp_id','us_empid');
    }
    
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
