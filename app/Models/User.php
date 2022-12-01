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

    public function getIsPsEncargadoAttribute()
    {
        return $this->privilegio == "ps_encargado";
    }

    public function getIsPsAsistenteAttribute()
    {
        return $this->privilegio == "ps_asistente";
    }

    public function getIsClienteAttribute()
    {
        return $this->privilegio == "cliente";
    }

    public function getIsContabilidadAttribute()
    {
        return $this->privilegio == "contabilidad";
    }

    public function getIsEgresosAttribute()
    {
        return $this->privilegio == "egresos";
    }

    public function getIsEstandarAttribute()
    {
        return $this->privilegio == "estandar";
    }

    public function getIsClientePsAsistenteAttribute()
    {
        return $this->privilegio == "cliente_ps_asistente";
    }

    public function getIsClientePsEncargadoAttribute()
    {
        return $this->privilegio == "cliente_ps_encargado";
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