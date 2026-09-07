<?php
namespace App\DTO;
use App\Validator\ReservationValidator;
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
    public static function fromArray(array $data): self
    {
        $validator = new ReservationValidator();
        $validationResult = $validator->validate($data);
        if (!$validationResult->isValid()) {
            throw new \InvalidArgumentException('Données de réservation invalides : ' . json_encode($validationResult->getErrors()));
        }
        return new self(
            salle_id: (int) $data['salle_id'],
            responsable: (string) $data['responsable'],
            email: (string) $data['email'],
            motif: (string) $data['motif'],
            date_debut: new \DateTimeImmutable($data['date_debut']),
            date_fin: new \DateTimeImmutable($data['date_fin'])
        );
    }
}
