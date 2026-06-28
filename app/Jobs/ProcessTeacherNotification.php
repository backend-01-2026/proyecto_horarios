<?php

namespace App\Jobs;

use App\Models\Teacher;
use App\Notifications\NewScheduleNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class ProcessTeacherNotification implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public int $teacherId;
    public string $tipoNotificacion;
    public array $datos;
    public int $tries = 3;
    public int $timeout = 60;
    public array $backoff = [5, 10, 30];

    public function __construct(int $teacherId, string $tipoNotificacion, array $datos = [])
    {
        $this->teacherId        = $teacherId;
        $this->tipoNotificacion = $tipoNotificacion;
        $this->datos            = $datos;
        $this->onQueue('notifications');
    }

    public function handle(): void
    {
        Log::info('ProcessTeacherNotification: Iniciando', [
            'teacher_id'        => $this->teacherId,
            'tipo_notificacion' => $this->tipoNotificacion,
        ]);

        $teacher = Teacher::find($this->teacherId);

        if (! $teacher) {
            Log::warning('ProcessTeacherNotification: Docente no encontrado', ['teacher_id' => $this->teacherId]);
            return;
        }

        match ($this->tipoNotificacion) {
            'nueva_inscripcion' => $this->enviarNuevaInscripcion($teacher),
            default             => $this->logTipoDesconocido(),
        };

        Log::info('ProcessTeacherNotification: Completado', [
            'teacher_id'        => $this->teacherId,
            'tipo_notificacion' => $this->tipoNotificacion,
        ]);
    }

    private function enviarNuevaInscripcion(Teacher $teacher): void
    {
        $adminEmail = config('mail.admin_address', config('mail.from.address'));

        if ($adminEmail) {
            Notification::route('mail', $adminEmail)
                ->notify(new NewScheduleNotification(array_merge($this->datos, [
                    'docente_nombre' => $teacher->prefijo_academico . ' ' . $teacher->nombre_completo,
                ])));

            Log::info('ProcessTeacherNotification: Notificación enviada al admin', [
                'teacher_id'  => $teacher->id,
                'admin_email' => $adminEmail,
            ]);
        } else {
            Log::warning('ProcessTeacherNotification: No hay email configurado', ['teacher_id' => $teacher->id]);
        }
    }

    private function logTipoDesconocido(): void
    {
        Log::warning('ProcessTeacherNotification: Tipo de notificación desconocido', [
            'tipo_notificacion' => $this->tipoNotificacion,
            'teacher_id'        => $this->teacherId,
        ]);
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('ProcessTeacherNotification: Job fallido definitivamente', [
            'teacher_id'        => $this->teacherId,
            'tipo_notificacion' => $this->tipoNotificacion,
            'datos'             => $this->datos,
            'error'             => $exception->getMessage(),
            'trace'             => $exception->getTraceAsString(),
        ]);
    }

    public function uniqueId(): string
    {
        return "teacher_{$this->teacherId}_{$this->tipoNotificacion}_" .
               ($this->datos['available_class_id'] ?? 'unknown');
    }
}