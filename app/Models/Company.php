<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table='company';

    protected $fillable =[
        'name',
        'siren',
        'siret'
    ];

    public function users(){
        return $this->hasMany(User::class,'company_id');
    }
}
