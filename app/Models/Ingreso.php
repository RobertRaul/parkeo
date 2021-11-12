<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $table ="ingresos";
    protected $primaryKey="ing_id";
    public $timestamps=false;

    protected $fillable= ['ing_cajid','ing_rentid','ing_serid','ing_serie', 'ing_numero','ing_fechr','ing_tppago','ing_nref','ing_subtotal','ing_igv','ing_total','ing_estado','ing_motivo','ing_usid'];
}
