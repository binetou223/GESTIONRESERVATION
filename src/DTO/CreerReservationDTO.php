<?php

namespace App\DTO;

class CreerReservationDTO
{
    public function __construct(
        public readonly int $salle_id,
        public readonly string $responsable,
        public readonly string $email,
        public readonly string $motif,
        public readonly \DateTimeImmutable $date_debut,
        public readonly \DateTimeImmutable $date_fin
    ) {
    }
}
