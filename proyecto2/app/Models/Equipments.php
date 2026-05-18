<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Loan; // Importamos el modelo Loan
use App\Enums\EquipmentStatus;

class Equipments extends Model
{
    use HasFactory;

    /**
     * Forzamos el nombre de la tabla en singular para coincidir exactamente
     * con tu `@Table(name = "equipment")` de Java.
     */
    protected $table = 'equipment';

    protected $fillable = [
        'name',
        'type',
        'description',
        'stock',
        'status',
        'image_filename', // Usamos snake_case por convención de Laravel
    ];

    protected function casts(): array
    {
        return [
            'status' => EquipmentStatus::class,
        ];
    }

    
    /**
     * Relación Uno a Muchos (@OneToMany(mappedBy = "equipment"))
     * Un equipo puede estar en muchos préstamos.
     */
    public function loans()
    {
        return $this->hasMany(Loan::class, 'equipment_id');
    }
}