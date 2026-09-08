<?php
namespace App\DTO;
use App\DTO\CreerReservationDTO;
class CreerReservationDTOBuilder
{
    private int $salle_id;
    private string $responsable;
    private string $email;
    private string $motif;
    private \DateTimeImmutable $date_debut;
    private \DateTimeImmutable $date_fin;

    public function setSalleId(int $salle_id): self
    {
        $this->salle_id = $salle_id;
        return $this;
    }

    public function setResponsable(string $responsable): self
    {
        $this->responsable = $responsable;
        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function setMotif(string $motif): self
    {
        $this->motif = $motif;
        return $this;
    }

    public function setDateDebut(\DateTimeImmutable $date_debut): self
    {
        $this->date_debut = $date_debut;
        return $this;
    }

    public function setDateFin(\DateTimeImmutable $date_fin): self
    {
        $this->date_fin = $date_fin;
        return $this;
    }

    public function build(): CreerReservationDTO
    {
        return new CreerReservationDTO(
            salle_id: $this->salle_id,
            responsable: $this->responsable,
            email: $this->email,
            motif: $this->motif,
            date_debut: $this->date_debut,
            date_fin: $this->date_fin
        );
    }
}