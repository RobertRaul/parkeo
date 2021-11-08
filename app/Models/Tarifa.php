<?php

namespace App\Models;

use App\Models\Tipo;
use Illuminate\Database\Eloquent\Model;

class Tarifa extends Model
{
    protected $table ="tarifas";
    protected $primaryKey="tar_id";
    public $timestamps = false;

    protected $fillable= ['tar_desc','tar_tiempo','tar_precio','tar_estado'];

    public function scopeSearch($query,$value)
    {
        return $query
        ->where('tar_id','like','%'. $value .'%')
        ->orWhere('tar_desc','like','%' . $value . '%')
        ->orWhere('tar_tiempo','like','%' . $value . '%')
        ->orWhere('tar_precio','like','%' . $value . '%')
        ->orWhere('tar_estado','like','%' . $value . '%');
    }

    public function Rentas()
    {
        return $this->hasMany(Renta::class,'rent_tarifa','tar_id');
        //Con esto le hemos dicho a laravel que cada Objeto Tarifa, tiene relacion uno a mucho con Rentas
        // con this hacemos referencia a esta clase Tarifa y con hasMany decimos: pertenece A UNA O MUCHAS RENTAS.
    }

}
