<?php

namespace App\Repository;

use App\Repository\ReservationRepositoryInterface;
use App\Model\Reservation;

final class EloquentReservationRepository implements ReservationRepositoryInterface
{
    public function lister(): array
    {
        return Reservation::all()->all();
    }
    public function retrouver(int $id): ?Reservation
    {
        return Reservation::find($id);
    }
    public function enregistrer(Reservation $reservation): Reservation
    {
        $reservation->save();
        return $reservation;
    }
    public function rechercheConflit(int $salleId, \DateTimeImmutable $datedebut, \DateTimeImmutable $datefin): ?Reservation
    {
        return Reservation::query()
            ->where('salle_id', $salleId)
            ->where('statut', 'confirmée')
            ->where('date_debut', '<', $datefin)
            ->where('date_fin', '>', $datedebut)
            ->first();
    }
    public function annuler(Reservation $reservation): Reservation
    {
        $reservation->statut = 'annulée';
        $reservation->save();
        return $reservation;
    }
}
