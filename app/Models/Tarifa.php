<?php

namespace App\Models;

use App\Models\Tipo;
use Illuminate\Database\Eloquent\Model;

class Tarifa extends Model
{
    protected $table ="tarifas";
    protected $primaryKey="tar_id";
    public $timestamps = false;

    protected $fillable= ['tar_desc','tar_tiempo','tar_precio','tar_tipoid','tar_estado'];

    public function scopeSearch($query,$value)
    {
        return $query
        ->where('tar_id','like','%'. $value .'%')
        ->orWhere('tar_desc','like','%' . $value . '%')
        ->orWhere('tar_tiempo','like','%' . $value . '%')
        ->orWhere('tip_desc','like','%' . $value . '%')
        ->orWhere('tar_estado','like','%' . $value . '%')
        ->join('tipos','tip_id','=','tar_tipoid');
    }

    public function Tipos()
    {
        return $this->belongsTo(Tipo::class,'tar_tipoid','tip_id');
        // con $this hacemos referencia a esta clase "Tarifa" y belognsTo decimos: pertenece, entonces decimos, Una Tarifa pertenece a una Tipo de Vehiculo
    }

}
