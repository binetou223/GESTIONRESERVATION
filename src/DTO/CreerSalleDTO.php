<?php

namespace App\DTO;
use App\Validator\SalleValidator;

class CreerSalleDTO
{
    public function __construct(
        public readonly string $nom,
        public readonly string $batiment,
        public readonly int $capacite,
        public readonly string $type,
        public readonly bool $active,
    ) {}
    
    public static function fromArray(array $data): self
    {
        $validator = new SalleValidator();
        $validationResult = $validator->validate($data);
        if (!$validationResult->isValid()) {
            throw new \InvalidArgumentException('Données de salle invalides : ' . json_encode($validationResult->errors()));
        }
        return new self(
            nom: (string) $data['nom'],
            batiment: (string) $data['batiment'],
            capacite: (int) $data['capacite'],
            type: (string) $data['type'],
            active: (bool) $data['active']
        );
    }
}
