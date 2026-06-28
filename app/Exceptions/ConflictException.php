<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConflictException extends Exception
{
    protected string $tipo;
    protected array $context;

    public function __construct(
        string $tipo,
        string $mensaje,
        array $context = [],
        int $code = 409
    ) {
        parent::__construct($mensaje, $code);
        $this->tipo    = $tipo;
        $this->context = $context;
    }

    public function getTipo(): string { return $this->tipo; }
    public function getContext(): array { return $this->context; }

    public function getTipoLabel(): string
    {
        return match ($this->tipo) {
            'horario_estudiante'     => 'Conflicto de Horario',
            'docente_ocupado'        => 'Docente No Disponible',
            'aula_ocupada'           => 'Aula Ocupada',
            'materia_duplicada'      => 'Materia Duplicada',
            'semestre_inconsistente' => 'Semestre Incorrecto',
            default                  => 'Conflicto Desconocido',
        };
    }

    public function toArray(): array
    {
        return [
            'error'   => true,
            'tipo'    => $this->tipo,
            'label'   => $this->getTipoLabel(),
            'mensaje' => $this->getMessage(),
            'context' => $this->context,
        ];
    }

    public function toJsonResponse(): JsonResponse
    {
        return response()->json($this->toArray(), $this->getCode());
    }

    public function render(Request $request): JsonResponse
    {
        if ($request->expectsJson()) {
            return $this->toJsonResponse();
        }
        return response()->json($this->toArray(), $this->getCode());
    }

    public static function porHorarioEstudiante(string $mensaje, array $context = []): self
    {
        return new self('horario_estudiante', $mensaje, $context);
    }

    public static function porDocenteOcupado(string $mensaje, array $context = []): self
    {
        return new self('docente_ocupado', $mensaje, $context);
    }

    public static function porAulaOcupada(string $mensaje, array $context = []): self
    {
        return new self('aula_ocupada', $mensaje, $context);
    }

    public static function porMateriaDuplicada(string $mensaje, array $context = []): self
    {
        return new self('materia_duplicada', $mensaje, $context);
    }

    public static function porSemestreInconsistente(string $mensaje, array $context = []): self
    {
        return new self('semestre_inconsistente', $mensaje, $context);
    }
}