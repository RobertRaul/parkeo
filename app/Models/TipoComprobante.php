<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoComprobante extends Model
{
    protected $table ="tipo_comprobante";
    protected $primaryKey="tpc_id";
    public $timestamps=false;

    protected $fillable= ['tpc_desc','tpc_estado'];

    //PARA QUE LAS CONSULTAS DE ELOQUENT NO RECUEPRE 1 SINO 01
    //public $incrementing   = false;

    public function scopeSearch($query,$value)
    {
        return $query
        ->Where('tpc_desc','like','%'. $value .'%')
        ->orWhere('tpc_estado','like','%' . $value . '%');
    }
}
