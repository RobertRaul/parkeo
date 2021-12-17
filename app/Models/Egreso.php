<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Egreso extends Model
{
    protected $table ="egresos";
    protected $primaryKey="egr_id";
    public $timestamps=false;

    protected $fillable= ['egr_cajid','egr_motivo','egr_total','egr_estado','egr_anulm'];

    public function scopeSearch($query,$value)
    {
        return $query
        ->where('egr_cajid','like','%'. $value .'%')
        ->orWhere('egr_motivo','like','%' . $value . '%')
        ->orWhere('egr_total','like','%' . $value . '%')
        ->orWhere('egr_estado','like','%' . $value . '%')
        ->orWhere('egr_anulm','like','%' . $value . '%');
    }

}
