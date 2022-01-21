<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table ="empresa";
    protected $primaryKey="empr_id";
    public $timestamps=false;

    protected $fillable= ['empr_ruc','empr_razon','empr_email','empr_logo',
    'empr_direcc','empr_telef'];

}
