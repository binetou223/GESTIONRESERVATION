<?php

declare(strict_types=1);

namespace Tests\Unit\Service;

require_once dirname(__DIR__) . '/Fake/FakeSalleRepository.php';
require_once dirname(__DIR__) . '/Fake/FakeReservationRepository.php';

use App\DTO\CreerReservationDTO;
use App\Exception\SalleIndisponibleException;
use App\Model\Reservation;
use App\Model\Salle;
use App\Services\CreerReservationService;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Fake\FakeReservationRepository;
use Tests\Unit\Fake\FakeSalleRepository;

final class CreerReservationServiceTest extends TestCase
{
    private FakeSalleRepository $salleRepository;
    private FakeReservationRepository $reservationRepository;
    private CreerReservationService $service;

    protected function setUp(): void
    {
        $this->salleRepository = new FakeSalleRepository();
        $this->reservationRepository = new FakeReservationRepository();
        $this->service = new CreerReservationService(
            $this->salleRepository,
            $this->reservationRepository,
        );
    }

    public function testReservationValide(): void
    {
        $this->salleRepository->ajouter($this->creerSalleActive());

        $reservation = $this->service->executer($this->creerDto());

        self::assertInstanceOf(Reservation::class, $reservation);
        self::assertCount(1, $this->reservationRepository->lister());
        self::assertSame('confirmée', $reservation->statut);
    }

    public function testSalleInexistante(): void
    {
        $this->expectException(SalleIndisponibleException::class);
        $this->expectExceptionMessage("La salle n'existe pas.");

        $this->service->executer($this->creerDto(salleId: 999));
    }

    public function testSalleInactive(): void
    {
        $this->salleRepository->ajouter($this->creerSalleInactive());

        $this->expectException(SalleIndisponibleException::class);
        $this->expectExceptionMessage('Cette salle ne peut pas être réservée.');

        $this->service->executer($this->creerDto());
    }

    public function testDateFinAvantDateDebut(): void
    {
        $this->salleRepository->ajouter($this->creerSalleActive());

        $this->expectException(SalleIndisponibleException::class);
        $this->expectExceptionMessage('La date de début doit précéder la date de fin.');

        $this->service->executer($this->creerDto(
            debut: '+1 day 14:00',
            fin: '+1 day 10:00',
        ));
    }

    public function testDureeSuperieureAQuatreHeures(): void
    {
        $this->salleRepository->ajouter($this->creerSalleActive());

        $this->expectException(SalleIndisponibleException::class);
        $this->expectExceptionMessage('Une réservation ne peut pas dépasser quatre heures.');

        $this->service->executer($this->creerDto(
            debut: '+1 day 10:00',
            fin: '+1 day 15:00',
        ));
    }

    public function testDatePassee(): void
    {
        $this->salleRepository->ajouter($this->creerSalleActive());

        $this->expectException(SalleIndisponibleException::class);
        $this->expectExceptionMessage('La réservation doit commencer dans le futur.');

        $this->service->executer($this->creerDto(
            debut: '-1 day 10:00',
            fin: '-1 day 12:00',
        ));
    }

    public function testConflitAvecUneReservation(): void
    {
        $this->salleRepository->ajouter($this->creerSalleActive());
        $this->reservationRepository->definirConflit(true);

        $this->expectException(SalleIndisponibleException::class);
        $this->expectExceptionMessage('La salle est indisponible pendant cette période.');

        $this->service->executer($this->creerDto(
            debut: '+1 day 11:00',
            fin: '+1 day 13:00',
        ));
    }

    public function testReservationAdjacenteSansChevauchement(): void
    {
        $this->salleRepository->ajouter($this->creerSalleActive());
        $this->reservationRepository->definirConflit(false);

        $reservation = $this->service->executer($this->creerDto(
            debut: '+1 day 12:00',
            fin: '+1 day 14:00',
        ));

        self::assertInstanceOf(Reservation::class, $reservation);
        self::assertCount(1, $this->reservationRepository->lister());
    }

    private function creerSalleActive(): Salle
    {
        $salle = new Salle();
        $salle->id = 1;
        $salle->nom = 'Salle B12';
        $salle->batiment = 'B';
        $salle->capacite = 40;
        $salle->type = 'cours';
        $salle->active = true;
        return $salle;
    }

    private function creerSalleInactive(): Salle
    {
        $salle = $this->creerSalleActive();
        $salle->active = false;

        return $salle;
    }

    private function creerDto(
        string $debut = '+1 day 10:00',
        string $fin = '+1 day 12:00',
        int $salleId = 1,
    ): CreerReservationDTO {
        return new CreerReservationDTO(
            salle_id: $salleId,
            responsable: 'Mouhamadou',
            email: 'test@example.com',
            motif: 'Réunion',
            date_debut: new DateTimeImmutable($debut),
            date_fin: new DateTimeImmutable($fin),
        );
    }
}
