<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CapacityException extends Exception
{
    protected string $tipo;
    protected int $inscritos;
    protected int $limite;
    protected array $context;

    public function __construct(
        string $tipo,
        string $mensaje,
        int $inscritos = 0,
        int $limite = 0,
        array $context = []
    ) {
        parent::__construct($mensaje, 422);
        $this->tipo      = $tipo;
        $this->inscritos = $inscritos;
        $this->limite    = $limite;
        $this->context   = $context;
    }
    public function getTipo(): string { return $this->tipo; }
    public function getInscritos(): int { return $this->inscritos; }
    public function getLimite(): int { return $this->limite; }
    public function getContext(): array { return $this->context; }

    public function getLugaresDisponibles(): int
    {
        return max(0, $this->limite - $this->inscritos);
    }

    public function getPorcentajeOcupacion(): float
    {
        if ($this->limite === 0) return 100.0;
        return round(($this->inscritos / $this->limite) * 100, 2);
    }

    public function toArray(): array
    {
        return [
            'error'                => true,
            'tipo'                 => $this->tipo,
            'mensaje'              => $this->getMessage(),
            'inscritos'            => $this->inscritos,
            'limite'               => $this->limite,
            'lugares_disponibles'  => $this->getLugaresDisponibles(),
            'porcentaje_ocupacion' => $this->getPorcentajeOcupacion(),
            'context'              => $this->context,
        ];
    }

    public function toJsonResponse(): JsonResponse
    {
        return response()->json($this->toArray(), $this->getCode());
    }

    public function render(Request $request): JsonResponse
    {
        return $this->toJsonResponse();
    }

    public static function aulaLlena(string $codigoAula, int $inscritos, int $limite, array $context = []): self
    {
        return new self(
            tipo: 'aula',
            mensaje: "El aula '{$codigoAula}' ha alcanzado su capacidad máxima ({$inscritos}/{$limite} estudiantes).",
            inscritos: $inscritos,
            limite: $limite,
            context: array_merge(['codigo_aula' => $codigoAula], $context)
        );
    }

    public static function grupoLleno(string $nombreGrupo, int $inscritos, int $limite, array $context = []): self
    {
        return new self(
            tipo: 'grupo',
            mensaje: "El grupo '{$nombreGrupo}' ha alcanzado su límite de inscripciones ({$inscritos}/{$limite}).",
            inscritos: $inscritos,
            limite: $limite,
            context: array_merge(['nombre_grupo' => $nombreGrupo], $context)
        );
    }
}