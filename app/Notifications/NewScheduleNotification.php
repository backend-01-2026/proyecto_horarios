<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewScheduleNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected array $datos;

    public function __construct(array $datos)
    {
        $this->datos = $datos;
        $this->onQueue('notifications');
    }

    public function via(mixed $notifiable): array { return ['mail']; }

    public function toMail(mixed $notifiable): MailMessage
    {
        // CORRECCIÓN: Esta notificación se envía via Notification::route('mail', $adminEmail),
        // por lo que $notifiable es un AnonymousNotifiable — NO un Teacher.
        // Los campos prefijo_academico y nombre_completo siempre quedan null así.
        // Los datos del docente ya vienen en $this->datos['docente_nombre']
        // enviados por ProcessTeacherNotification::enviarNuevaInscripcion().
        $docente = $this->datos['docente_nombre']   ?? 'Docente';
        $materia = $this->datos['materia']           ?? 'Sin especificar';
        $grupo   = $this->datos['grupo']             ?? 'Sin especificar';
        $aula    = $this->datos['aula']              ?? 'Sin especificar';
        $horario = $this->datos['horario']           ?? 'Sin especificar';
        $alumno  = $this->datos['estudiante_nombre'] ?? 'Un estudiante';

        return (new MailMessage)
            ->subject("Nueva inscripción en clase: {$materia}")
            ->greeting("Estimado/a administrador/a,")
            ->line("Le informamos que un estudiante se ha inscrito en la siguiente clase.")
            ->line("**Detalles de la inscripción:**")
            ->line("- **Docente:** {$docente}")
            ->line("- **Materia:** {$materia}")
            ->line("- **Grupo:** {$grupo}")
            ->line("- **Aula:** {$aula}")
            ->line("- **Horario:** {$horario}")
            ->line("- **Estudiante:** {$alumno}")
            ->line("---")
            ->line("Este aviso fue generado automáticamente por el Sistema de Horarios.")
            ->salutation("Atentamente, el equipo del Sistema de Horarios.");
    }

    public function toArray(mixed $notifiable): array
    {
        return [
            'tipo'               => 'nueva_inscripcion',
            'saved_schedule_id'  => $this->datos['saved_schedule_id']  ?? null,
            'available_class_id' => $this->datos['available_class_id'] ?? null,
            'materia'            => $this->datos['materia']            ?? null,
            'grupo'              => $this->datos['grupo']              ?? null,
            'aula'               => $this->datos['aula']               ?? null,
            'horario'            => $this->datos['horario']            ?? null,
            'estudiante_nombre'  => $this->datos['estudiante_nombre']  ?? null,
            'docente_nombre'     => $this->datos['docente_nombre']     ?? null,
        ];
    }

    public function getDatos(): array { return $this->datos; }
}