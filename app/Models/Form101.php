<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form101 extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'company_id',
        'typeMineral_id',
        'leyMineral',
        'pesoBruto',
        'humedad',
        'pesoNeto',
        'lote',
        'municipio',
        'localidad',
        'codigoAreaMinero',
        'nombreAreaMinero',
        'medioTransporte',
        'origen',
        'final',
        'matricula',
        'nombreConductor',
        'licenciaConducir',
        'nombreEncargadoTrasporte',
        'ciEncargadoTrasporte',
        'register_id',
        'deleted_id',
        'observation'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function typeMineral()
    {
        return $this->belongsTo(TypeMineral::class, 'typeMineral_id');
    }

}
