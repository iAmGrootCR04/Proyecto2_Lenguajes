<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\LoanStatus;

class Loan extends Model
{
    use HasFactory;

    // Opcional: Laravel asume que la tabla es 'loans', pero lo hacemos explícito como en tu @Table
    protected $table = 'loans';

    protected $fillable = [
        'request_date',
        'start_date',
        'estimated_end_date',
        'actual_return_date',
        'justification',
        'status',
        'equipment_id',
        'user_id',
    ];

    /**
     * Mapeo de tipos de datos (Casting).
     * Esto convierte automáticamente los strings de la BD a objetos Carbon (el LocalDate de Laravel).
     */
 protected function casts(): array
    {
        return [
            'request_date' => 'date',
            'start_date' => 'date',
            'estimated_end_date' => 'date',
            'actual_return_date' => 'date',
            'status' => LoanStatus::class, // ← Agregamos el casting del Enum aquí
        ];
    }

    /**
     * Relación Muchos a Uno (@ManyToOne) -> Un préstamo pertenece a un Usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación Muchos a Uno (@ManyToOne) -> Un préstamo pertenece a un Equipo
     */
    public function equipment()
    {
        return $this->belongsTo(Equipments::class, 'equipment_id');
    }
}