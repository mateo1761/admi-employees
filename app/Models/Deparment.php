<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Deparment extends Model
{
    use HasFactory;

    protected $table = 'deparments';

    protected $fillable = ['name'];

    //Definir relacion con el modelo Employee

    public function employees(){
        return $this->hasMany(Employee::class, 'deparments_id');
    }
}
