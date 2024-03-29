<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = "users";
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'apellido_p', 'apellido_m', 'correo', 'password', 'privilegio',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function getIsRootAttribute()
    {
        return $this->privilegio == 'root';
    }

    public function getIsAdminAttribute()
    {
        return $this->privilegio == 'admin';
    }

    public function getIsProcesosAttribute()
    {
        return $this->privilegio == 'procesos';
    }

    public function getIsEgresosAttribute()
    {
        return $this->privilegio == "egresos";
    }

    public function getIsContabilidadAttribute()
    {
        return $this->privilegio == "contabilidad";
    }    

    public function getIsPsDiamondAttribute()
    {
        return $this->privilegio == "ps_diamond";
    }

    public function getIsPsGoldAttribute()
    {
        return $this->privilegio == "ps_gold";
    }

    public function getIsPsBronzeAttribute()
    {
        return $this->privilegio == "ps_bronze";
    }

    public function getIsClienteAttribute()
    {
        return $this->privilegio == "cliente";
    }    

    public function chats()
    {
        return $this->belongsToMany('App\Models\Chat');
    }

    public function messages()
    {
        return $this->hasMany('App\Models\Message');
    }
    
}