<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $table ="tipos";
    protected $primaryKey="tip_id";
    public $timestamps = false;

    protected $fillable= ['tip_desc','tip_img','tip_estado'];

    public function scopeSearch($query,$value)
    {
        return $query
        ->where('tip_id','like','%'. $value .'%')
        ->orWhere('tip_desc','like','%' . $value . '%')
        ->orWhere('tip_img','like','%' . $value . '%')
        ->orWhere('tip_estado','like','%' . $value . '%');
    }

}
