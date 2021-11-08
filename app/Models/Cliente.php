<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table ="clientes";
    protected $primaryKey="clie_id";
    public $timestamps=false;

    protected $fillable= ['clie_tpdi','clie_numdoc','clie_nombres','clie_celular','clie_email','clie_estado'];

    public function scopeSearch($query,$value)
    {
        return $query
        ->where('clie_id','like','%'. $value .'%')
        ->where('tpdi_desc','like','%'. $value .'%')
        ->orWhere('clie_numdoc','like','%' . $value . '%')
        ->orWhere('clie_nombres','like','%' . $value . '%')
        ->orWhere('clie_celular','like','%' . $value . '%')
        ->orWhere('clie_email','like','%' . $value . '%')
        ->orWhere('clie_estado','like','%' . $value . '%')
        ->join('tipo_doc_identidad','tpdi_id','=','clie_tpdi');
    }

    public function TipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class,'tpdi_desc','tpdi_id');
        // con $this hacemos referencia a esta clase "Cliente" y belognsTo decimos: pertenece, entonces decimos, Un Cliente pertenece a una Tipo Documento
    }    
    public function Rentas()
    {
        return $this->hasMany(Renta::class,'rent_client','clie_id');
        //Con esto le hemos dicho a laravel que cada Objeto Cliente, tiene relacion uno a mucho con Rentas
        // con this hacemos referencia a esta clase Cliente y con hasMany decimos: pertenece A UNA O MUCHAS RENTAS.
    }
}

