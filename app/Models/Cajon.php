<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cajon extends Model
{
    protected $table ="cajones";
    protected $primaryKey="caj_id";
    public $timestamps=false;

    protected $fillable= ['caj_desc','caj_tipoid','caj_estado'];

    public function scopeSearch($query,$value)
    {
        return $query
        ->where('caj_id','like','%'. $value .'%')
        ->orWhere('caj_desc','like','%' . $value . '%')
        ->orWhere('tip_desc','like','%' . $value . '%')
        ->orWhere('caj_estado','like','%' . $value . '%')
        ->join('tipo_vehiculo','tip_id','=','caj_tipoid');
    }

    public function Rentas()
    {
        return $this->hasMany(Renta::class,'rent_cajonid','caj_id');
        //Con esto le hemos dicho a laravel que cada Objeto Cajon, tiene relacion uno a mucho con Rentas
        // con this hacemos referencia a esta clase Cajon y con hasMany decimos: pertenece A UNA O MUCHAS RENTAS.
    }

    public function Tipos()
    {
        return $this->belongsTo(Tipo::class,'caj_tipoid','tip_id');
    }

}
