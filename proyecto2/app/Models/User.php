<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Loan; // Asegúrate de importar el modelo Loan

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Los atributos que se pueden asignar de forma masiva (Mass Assignment).
     * Reemplaza a las propiedades de tu constructor en Java.
     */
    protected $fillable = [
        'username',
        'password',
        'email',
        'role',
        'full_name',
    ];

    /**
     * Los atributos que deben ocultarse para la serialización (como arrays o JSON).
     * Esto equivale al @JsonIgnore de tu campo 'password' (y opcionalmente 'loans').
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Mutador automático para encriptar la contraseña.
     * En Laravel, es buena práctica asegurar que el password siempre se guarde con hash.
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Relación Uno a Muchos (@OneToMany(mappedBy = "user"))
     * Un usuario tiene muchos préstamos (Loans).
     */
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}