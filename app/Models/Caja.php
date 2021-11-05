<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $table ="cajas";
    protected $primaryKey="caj_id";
    public $timestamps=false;

    protected $fillable= ['caj_minic','caj_feaper','caj_fecierr','caj_st','caj_usid'];

    public function scopeSearch($query,$value)
    {
        return $query
        ->where('caj_id','like','%'. $value .'%')
        ->orWhere('caj_minic','like','%' . $value . '%')
        ->orWhere('caj_feaper','like','%' . $value . '%')
        ->orWhere('caj_fecierr','like','%' . $value . '%')
        ->orWhere('caj_st','like','%' . $value . '%')
        ->orWhere('caj_usid','like','%' . $value . '%');
    }

    public function Usuarios()
    {
        return $this->belongsTo(Usuario::class,'caj_usid','us_id');
        // con $this hacemos referencia a esta clase "Caja" y belognsTo decimos: pertenece, entonces decimos, Una Caja pertenece a un Usuario
    }

}
