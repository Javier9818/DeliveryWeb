<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
	protected $table = 'personas';
    protected $fillable = ['nombres', 'appaterno', 'apmaterno', 'celular', 'direccion','dni','created_at', 'updated_at'];
}
