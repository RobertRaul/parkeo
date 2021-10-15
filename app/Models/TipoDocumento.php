<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    protected $table ="tipo_doc_identidad";
    protected $primaryKey="tpdi_id";
    public $timestamps=false;

    protected $fillable= ['tpdi_desc','tpdi_estado'];

    //PARA QUE LAS CONSULTAS DE ELOQUENT NO RECUEPRE 1 SINO 01
    public $incrementing = false;

    public function scopeSearch($query,$value)
    {
        return $query
        ->Where('tpdi_desc','like','%'. $value .'%')
        ->orWhere('tpdi_estado','like','%' . $value . '%');
    }
}
