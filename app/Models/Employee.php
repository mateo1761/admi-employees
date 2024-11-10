<?php

namespace App\Models;

use App\Models\Deparment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = ['name', 'email', 'phone', 'deparments_id'];

    // Definir la relación con el modelo Department
    public function department()
    {
        return $this->belongsTo(Deparment::class, 'deparments_id');
    }
}
