<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    public $timestamps = false;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'accion', 'modelo', 'saved_schedule_id', 'available_class_id',
        'user_id', 'user_nombre', 'user_email', 'user_rol',
        'datos_clase', 'ip_address', 'user_agent', 'created_at',
    ];

    protected function casts(): array
    {
        return [
            'datos_clase' => 'array',
            'created_at'  => 'datetime',
        ];
    }

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function savedSchedule(): BelongsTo { return $this->belongsTo(SavedSchedule::class); }
    public function availableClass(): BelongsTo { return $this->belongsTo(AvailableClass::class); }

    public function scopeCreaciones(Builder $query): Builder { return $query->where('accion', 'created'); }
    public function scopeEliminaciones(Builder $query): Builder { return $query->where('accion', 'deleted'); }
    public function scopeDeUsuario(Builder $query, int $userId): Builder { return $query->where('user_id', $userId); }
    public function scopeDeHorario(Builder $query, int $scheduleId): Builder { return $query->where('saved_schedule_id', $scheduleId); }
    public function scopeDeClase(Builder $query, int $classId): Builder { return $query->where('available_class_id', $classId); }
    public function scopeEntreFechas(Builder $query, string $desde, string $hasta): Builder { return $query->whereBetween('created_at', [$desde, $hasta]); }
    public function scopePorRol(Builder $query, string $rol): Builder { return $query->where('user_rol', $rol); }

    public static function registrarCreacion(int $savedScheduleId, int $availableClassId, array $datosClase = [], array $datosUsuario = [], array $metadatos = []): self
    {
        return self::create([
            'accion'             => 'created',
            'modelo'             => 'ClassSelection',
            'saved_schedule_id'  => $savedScheduleId,
            'available_class_id' => $availableClassId,
            'user_id'            => $datosUsuario['id']     ?? null,
            'user_nombre'        => $datosUsuario['nombre'] ?? null,
            'user_email'         => $datosUsuario['email']  ?? null,
            'user_rol'           => $datosUsuario['rol']    ?? null,
            'datos_clase'        => $datosClase,
            'ip_address'         => $metadatos['ip']         ?? null,
            'user_agent'         => $metadatos['user_agent'] ?? null,
            'created_at'         => now(),
        ]);
    }

    public static function registrarEliminacion(int $savedScheduleId, int $availableClassId, array $datosClase = [], array $datosUsuario = [], array $metadatos = []): self
    {
        return self::create([
            'accion'             => 'deleted',
            'modelo'             => 'ClassSelection',
            'saved_schedule_id'  => $savedScheduleId,
            'available_class_id' => $availableClassId,
            'user_id'            => $datosUsuario['id']     ?? null,
            'user_nombre'        => $datosUsuario['nombre'] ?? null,
            'user_email'         => $datosUsuario['email']  ?? null,
            'user_rol'           => $datosUsuario['rol']    ?? null,
            'datos_clase'        => $datosClase,
            'ip_address'         => $metadatos['ip']         ?? null,
            'user_agent'         => $metadatos['user_agent'] ?? null,
            'created_at'         => now(),
        ]);
    }

    public function getAccionLabelAttribute(): string
    {
        return match ($this->accion) {
            'created' => 'Clase Agregada',
            'deleted' => 'Clase Eliminada',
            default   => 'Acción Desconocida',
        };
    }

    public function getNombreMateriaAttribute(): ?string { return $this->datos_clase['subject']['nombre'] ?? null; }
    public function getNombreDocenteAttribute(): ?string { return $this->datos_clase['teacher']['nombre_completo'] ?? null; }
}