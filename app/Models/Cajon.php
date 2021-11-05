<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cajon extends Model
{
    protected $table ="cajones";
    protected $primaryKey="caj_id";
    public $timestamps=false;

    protected $fillable= ['caj_desc','caj_estado'];

    public function scopeSearch($query,$value)
    {
        return $query
        ->where('caj_id','like','%'. $value .'%')
        ->orWhere('caj_desc','like','%' . $value . '%')
        ->orWhere('caj_estado','like','%' . $value . '%');
    }


}
