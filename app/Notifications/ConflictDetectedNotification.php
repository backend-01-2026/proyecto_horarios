<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ConflictDetectedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected string $tipoConflicto;
    protected string $mensajeConflicto;
    protected array $context;
    protected array $datosHorario;

    public function __construct(string $tipoConflicto, string $mensajeConflicto, array $context = [], array $datosHorario = [])
    {
        $this->tipoConflicto    = $tipoConflicto;
        $this->mensajeConflicto = $mensajeConflicto;
        $this->context          = $context;
        $this->datosHorario     = $datosHorario;
        $this->onQueue('notifications');
    }

    public function via(mixed $notifiable): array { return ['mail']; }

    public function toMail(mixed $notifiable): MailMessage
    {
        $nombre        = $notifiable->name ?? $notifiable->nombre_completo ?? 'Usuario';
        $tipoLabel     = $this->getTipoLabel();
        $horarioNombre = $this->datosHorario['nombre_horario'] ?? 'Tu horario';

        return (new MailMessage)
            ->subject("⚠️ Conflicto de horario detectado: {$tipoLabel}")
            ->greeting("Hola, {$nombre}")
            ->line("Se detectó un conflicto al intentar agregar una clase a **{$horarioNombre}**.")
            ->line("**Tipo de conflicto:** {$tipoLabel}")
            ->line("**Detalle:** {$this->mensajeConflicto}")
            ->line("---")
            ->line("No se realizó ningún cambio en tu horario. Puedes intentar seleccionar otra clase.")
            ->line("Si crees que esto es un error, contacta al administrador del sistema.")
            ->salutation("Atentamente, el Sistema de Horarios.");
    }

    public function toArray(mixed $notifiable): array
    {
        return [
            'tipo'           => 'conflicto_detectado',
            'tipo_conflicto' => $this->tipoConflicto,
            'tipo_label'     => $this->getTipoLabel(),
            'mensaje'        => $this->mensajeConflicto,
            'context'        => $this->context,
            'datos_horario'  => $this->datosHorario,
        ];
    }

    public function getTipoLabel(): string
    {
        return match ($this->tipoConflicto) {
            'horario_estudiante'     => 'Choque de Horarios',
            'docente_ocupado'        => 'Docente No Disponible',
            'aula_ocupada'           => 'Aula Ocupada',
            'materia_duplicada'      => 'Materia Duplicada',
            'semestre_inconsistente' => 'Semestre Incorrecto',
            default                  => 'Conflicto General',
        };
    }

    public function getTipoConflicto(): string { return $this->tipoConflicto; }
    public function getMensajeConflicto(): string { return $this->mensajeConflicto; }
}