<?php

namespace RED\Escuela;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Maestro extends Model
{
    use SoftDeletes;
    
    protected $table = 'Maestro';

    protected $fillable = [
        'codigo',
    	'nombre_maestro',
    	'apellido_maestro', 
    	'fecha_nacimiento',
    	'direccion',
    	'correo',
        'activo',
        'path',
    	'genero_id'];

    protected $dates = ['deleted_at'];

    public function telefonos()
    {
        return $this->hasMany('RED\Escuela\Telefono');
    }

    public function cursos()
    {
        return $this->belongsToMany('RED\Escuela\Curso');
    }

    public function scopeName($query, $name){

        if (trim($name) != "")
        {
            return $query->where(DB::raw("CONCAT(nombre_maestro, ' ' , apellido_maestro) "),"LIKE","%$name%");    
        }
    }

    public function scopeCode($query, $code){

        if (trim($code) != "")
        {
            return $query->where("codigo","LIKE","%$code%");    
        }
    }

    public function setPathAttribute($path)
    {
        if(!(empty($path)))
        {
            $this->attributes['path'] = Carbon::now()->year.Carbon::now()->month.Carbon::now()->day.Carbon::now()->hour.Carbon::now()->minute.Carbon::now()->second.'-maestro-'.$path->getClientOriginalName();
            $name = Carbon::now()->year.Carbon::now()->month.Carbon::now()->day.Carbon::now()->hour.Carbon::now()->minute.Carbon::now()->second.'-maestro-'.$path->getClientOriginalName();
            \Storage::disk('local')->put($name, \File::get($path));
        }
    }
}
