<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    
    protected $fillable = [
        'name', 'email', 'password', 'perfil_id' , 'estado_id', 'foto'
    ];

   
    protected $hidden = [
        'password', 'remember_token',
    ];

    //Relación con Perfiles
    public function perfil(){
    	return $this->hasOne('App\Perfil','id','perfil_id');
    }

    //Relación con Estados
    public function estado(){
    	return $this->hasOne('App\Estado','id','estado_id');
    }

    //relacion con Medicos
    public function medico(){
        return $this->belongsTo('App\Medico');
    }

    //buscador de usuarios por nombre
    public function scopeNombres($query,$nombre){
        return $query->where('name','LIKE','%'.$nombre.'%');
    }
    //buscador de usuarios por email
    public function scopeEmail($query,$email){
        return $query->where('email','LIKE','%'.$email.'%');
    }
    //buscador de usuarios por Perfil
    public function scopePerfil($query,$perfil_id){
        return $query->where('perfil_id','LIKE','%'.$perfil_id.'%');
    }
    //buscador de usuarios por Perfil
    public function scopeEstado($query,$estado_id){
        return $query->where('estado_id','LIKE','%'.$estado_id.'%');
    }




}