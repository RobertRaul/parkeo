<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $table ="vehiculos";
    protected $primaryKey="veh_id";
    public $timestamps=false;

    protected $fillable= ['veh_placa','veh_modelo','veh_marca','veh_color','veh_foto'];

    public function Rentas()
    {
        return $this->hasMany(Renta::class,'rent_client','clie_id');
        //Con esto le hemos dicho a laravel que cada Objeto Vehiulo, tiene relacion uno a mucho con Rentas
        // con this hacemos referencia a esta clase Vehiculo y con hasMany decimos: pertenece A UNA O MUCHAS RENTAS.
    }
}
