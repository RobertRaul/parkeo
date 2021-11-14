<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Renta extends Model
{
    protected $table ="rentas";
    protected $primaryKey="rent_id";
    public $timestamps=false;

    protected $fillable= ['rent_tarid','rent_vehiculo','rent_client','rent_cajonid','rent_llaves','rent_obser','rent_feching','rent_fechsal','rent_totalhoras','rent_estado','rent_usid'];

    public function Tarifas()
    {
        return $this->belongsTo(Tarifa::class,'rent_tarid','tar_id');
        //Con esto le hemos dicho a laravel que cada Objeto Cajon, tiene relacion uno a mucho con Rentas
        // con this hacemos referencia a esta clase Cajon y con hasMany decimos: pertenece A UNA O MUCHAS RENTAS.
    }

}
