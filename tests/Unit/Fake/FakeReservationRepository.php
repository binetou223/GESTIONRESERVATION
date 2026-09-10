<?php

declare(strict_types=1);

namespace Tests\Unit\Fake;

use App\Model\Reservation;
use App\Repository\ReservationRepositoryInterface;
use DateTimeImmutable;

final class FakeReservationRepository implements ReservationRepositoryInterface
{
    private array $reservations = [];
    private bool $conflit = false;

    public function definirConflit(bool $conflit): void
    {
        $this->conflit = $conflit;
    }

    public function lister(): array
    {
        return $this->reservations;
    }

    public function retrouver(int $id): ?Reservation
    {
        foreach ($this->reservations as $reservation) {
            if ((int) $reservation->id === $id) {
                return $reservation;
            }
        }

        return null;
    }

    public function enregistrer(Reservation $reservation): Reservation
    {
        $reservation->id = count($this->reservations) + 1;
        $this->reservations[] = $reservation;

        return $reservation;
    }

    public function rechercheConflit(
        int $salleId,
        DateTimeImmutable $dateDebut,
        DateTimeImmutable $dateFin
    ): ?Reservation {
        return $this->conflit ? new Reservation() : null;
    }

    public function annuler(Reservation $reservation): Reservation
    {
        $reservation->statut = 'annulée';

        return $reservation;
    }
}
