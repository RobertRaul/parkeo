<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    protected $table ="series";
    protected $primaryKey="ser_id";
    public $timestamps=false;

    protected $fillable= ['ser_tpcomid','ser_serie','ser_numero','ser_estado'];

    
    public function scopeSearch($query,$value)
    {
        return $query
        ->where('ser_id','like','%'. $value .'%')
        ->orWhere('tpc_desc','like','%' . $value . '%')
        ->orWhere('ser_serie','like','%' . $value . '%')
        ->orWhere('ser_numero','like','%' . $value . '%')
        ->orWhere('ser_estado','like','%' . $value . '%')
        ->join('tipo_comprobante','tpc_id','=','ser_tpcomid');
    }

    public function TipoComprobante()
    {
        return $this->belongsTo(TipoComprobante::class,'ser_tpcomid','tpc_id'); 
        // con $this hacemos referencia a esta clase "Serie" y belognsTo decimos: pertenece, entonces decimos, Una SERIE pertenece a una tipo de Comprobante
    }
}
