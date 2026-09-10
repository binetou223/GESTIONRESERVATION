<?php

declare(strict_types=1);

namespace Tests\Integration;

use App\Model\Reservation;
use App\Model\Salle;
use App\Repository\EloquentReservationRepository;
use App\Repository\EloquentSalleRepository;
use DateTimeImmutable;

final class ReservationRepositoryTest extends IntegrationTestCase
{
    private EloquentReservationRepository $repository;
    private EloquentSalleRepository $salleRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new EloquentReservationRepository();
        $this->salleRepository = new EloquentSalleRepository();
    }

    public function testEnregistreEtRetrouveUneReservation(): void
    {
        $salle = $this->createSalle();
        $reservation = $this->repository->enregistrer(new Reservation($this->reservationData($salle->id)));

        self::assertNotNull($reservation->id);
        self::assertSame($reservation->id, $this->repository->retrouver($reservation->id)->id);
    }

    public function testListeLesReservations(): void
    {
        $salle = $this->createSalle();
        $this->repository->enregistrer(new Reservation($this->reservationData($salle->id)));
        $this->repository->enregistrer(new Reservation($this->reservationData($salle->id, '+2 days')));

        self::assertCount(2, $this->repository->lister());
    }

    public function testRechercheUnConflit(): void
    {
        $salle = $this->createSalle();
        $reservation = $this->repository->enregistrer(new Reservation($this->reservationData($salle->id)));

        $conflit = $this->repository->rechercheConflit(
            $salle->id,
            new DateTimeImmutable('+1 day 11:00'),
            new DateTimeImmutable('+1 day 13:00'),
        );

        self::assertSame($reservation->id, $conflit->id);
    }

    public function testNeRetournePasDeConflitPourUneReservationVoisine(): void
    {
        $salle = $this->createSalle();
        $this->repository->enregistrer(new Reservation($this->reservationData($salle->id)));

        self::assertNull($this->repository->rechercheConflit(
            $salle->id,
            new DateTimeImmutable('+1 day 12:00'),
            new DateTimeImmutable('+1 day 14:00'),
        ));
    }

    public function testAnnuleUneReservation(): void
    {
        $salle = $this->createSalle();
        $reservation = $this->repository->enregistrer(new Reservation($this->reservationData($salle->id)));

        $result = $this->repository->annuler($reservation);

        self::assertSame('annulée', $result->statut);
        self::assertSame('annulée', $reservation->fresh()->statut);
    }

    public function testRelationReservationSalle(): void
    {
        $salle = $this->createSalle();
        $reservation = $this->repository->enregistrer(new Reservation($this->reservationData($salle->id)));

        self::assertInstanceOf(Salle::class, $reservation->fresh()->salle);
    }

    private function createSalle(): Salle
    {
        return $this->salleRepository->enregistrer(new Salle([
            'nom' => 'Salle B12',
            'batiment' => 'B',
            'capacite' => 40,
            'type' => 'cours',
            'active' => true,
        ]));
    }

    private function reservationData(int $salleId, string $day = '+1 day'): array
    {
        return [
            'salle_id' => $salleId,
            'responsable' => 'Mouhamadou',
            'email' => 'test@example.com',
            'motif' => 'Réunion',
            'date_debut' => new DateTimeImmutable($day . ' 10:00'),
            'date_fin' => new DateTimeImmutable($day . ' 12:00'),
            'statut' => 'confirmée',
        ];
    }
}