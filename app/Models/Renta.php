<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Renta extends Model
{
    protected $table ="rentas";
    protected $primaryKey="rent_id";
    public $timestamps=false;

    protected $fillable= ['rent_vehiculo','rent_tarifa','rent_client','rent_cajonid','rent_llaves','rent_obser','rent_feching','rent_fechsal','rent_totalhoras','rent_estado','rent_usid'];

    

}
