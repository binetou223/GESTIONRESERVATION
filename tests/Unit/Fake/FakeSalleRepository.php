<?php

declare(strict_types=1);

namespace Tests\Unit\Fake;

use App\Model\Salle;
use App\Repository\SalleRepositoryInterface;

final class FakeSalleRepository implements SalleRepositoryInterface
{
    private array $salles = [];

    public function ajouter(Salle $salle): void
    {
        $this->salles[(int) $salle->id] = $salle;
    }

    public function lister(): array
    {
        return array_values($this->salles);
    }

    public function retrouver(int $id): ?Salle
    {
        return $this->salles[$id] ?? null;
    }

    public function enregistrer(Salle $salle): Salle
    {
        $this->ajouter($salle);

        return $salle;
    }
}
