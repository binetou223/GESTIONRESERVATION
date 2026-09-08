<?php

namespace App\Repository;

use App\Model\Reservation;

interface ReservationRepositoryInterface
{
    public function lister(): array;
    public function retrouver(int $id): ?Reservation;
    public function enregistrer(Reservation $reservation): Reservation;
    public function rechercheConflit(int $salleId, \DateTimeImmutable $datedebut, \DateTimeImmutable $datefin): ?Reservation;
    public function annuler(Reservation $reservation): Reservation;
}
