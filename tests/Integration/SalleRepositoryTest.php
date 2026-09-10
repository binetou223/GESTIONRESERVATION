<?php

declare(strict_types=1);

namespace Tests\Integration;

use App\Model\Salle;
use App\Repository\EloquentSalleRepository;

final class SalleRepositoryTest extends IntegrationTestCase
{
    private EloquentSalleRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new EloquentSalleRepository();
    }

    public function testEnregistreEtRetrouveUneSalle(): void
    {
        $salle = $this->repository->enregistrer($this->salle());

        self::assertNotNull($salle->id);
        self::assertSame('Salle B12', $this->repository->retrouver($salle->id)->nom);
    }

    public function testRetourneNullPourUneSalleInexistante(): void
    {
        self::assertNull($this->repository->retrouver(999));
    }

    public function testListeLesSalles(): void
    {
        $this->repository->enregistrer($this->salle());
        $this->repository->enregistrer($this->salle('Amphithéâtre A'));

        self::assertCount(2, $this->repository->lister());
        self::assertContainsOnlyInstancesOf(Salle::class, $this->repository->lister());
    }

    public function testRelationSalleReservations(): void
    {
        $salle = $this->repository->enregistrer($this->salle());
        $salle->reservations()->create($this->reservationData($salle->id));

        self::assertCount(1, $salle->fresh()->reservations);
    }

    private function salle(string $nom = 'Salle B12'): Salle
    {
        return new Salle([
            'nom' => $nom,
            'batiment' => 'B',
            'capacite' => 40,
            'type' => 'cours',
            'active' => true,
        ]);
    }

    private function reservationData(int $salleId): array
    {
        return [
            'salle_id' => $salleId,
            'responsable' => 'Mouhamadou',
            'email' => 'test@example.com',
            'motif' => 'Réunion',
            'date_debut' => new \DateTimeImmutable('+1 day 10:00'),
            'date_fin' => new \DateTimeImmutable('+1 day 12:00'),
            'statut' => 'confirmée',
        ];
    }
}
