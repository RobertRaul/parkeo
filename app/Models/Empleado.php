<?php

namespace App\Models;

use APP\Models\TipoDocumento;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table ="empleados";
    protected $primaryKey="emp_id";
    public $timestamps=false;

    protected $fillable= ['emp_id','emp_tpdi','emp_numdoc','emp_apellidos','emp_nombres','emp_celular','emp_email','emp_direccion','emp_estado'];

    public function scopeSearch($query,$value)
    {
        return $query
        ->where('emp_id','like','%'. $value .'%')
        ->orWhere('tpdi_desc','like','%' . $value . '%')
        ->orWhere('emp_numdoc','like','%' . $value . '%')
        ->orWhere('emp_apellidos','like','%' . $value . '%')
        ->orWhere('emp_nombres','like','%' . $value . '%')
        ->orWhere('emp_celular','like','%' . $value . '%')
        ->orWhere('emp_email','like','%' . $value . '%')
        ->orWhere('emp_direccion','like','%' . $value . '%')
        ->orWhere('emp_estado','like','%' . $value . '%')
        ->join('tipo_doc_identidad','tpdi_id','=','emp_tpdi');
    }

    public function Tipodocumento()
    {
        return $this->belongsTo(TipoDocumento::class,'emp_tpdi','tpdi_id');
        // con $this hacemos referencia a esta clase "Empleado" y belognsTo decimos: pertenece, entonces decimos, Una Empleado pertenece a una Tipo de documento
    }
}
