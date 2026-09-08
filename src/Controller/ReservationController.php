<?php

namespace App\Controller;

use App\DTO\CreerReservationDTOBuilder;
use App\Exception\SalleIndisponibleException;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use App\Services\AnnulerReservationService;
use App\Services\CreerReservationService;
use App\Validator\ReservationValidator;
use DateTimeImmutable;

final class ReservationController extends AbstractController
{
    public function __construct(
        private readonly ReservationRepositoryInterface $reservations,
        private readonly SalleRepositoryInterface $salles,
        private readonly ReservationValidator $validator,
        private readonly CreerReservationService $creation,
        private readonly AnnulerReservationService $annulation,
    ) {
    }

    public function index(): string
    {
        return $this->renderView('reservation/index', [
            'title' => 'Réservations',
            'reservations' => $this->reservations->lister(),
        ]);
    }

    public function show(int $id): string
    {
        $reservation = $this->reservations->retrouver($id);
        return $reservation === null
            ? $this->notFound()
            : $this->renderView('reservation/show', ['title' => 'Réservation', 'reservation' => $reservation]);
    }

    public function create(array $old = [], array $errors = []): string
    {
        return $this->renderView('reservation/form', [
            'title' => 'Créer une réservation',
            'action' => '/reservations',
            'salles' => $this->salles->lister(),
            'old' => $old,
            'errors' => $errors,
        ]);
    }

    public function store(array $input): string
    {
        [$data, $errors] = $this->validateInput($input);
        if ($errors !== []) {
            return $this->create($data, $errors);
        }

        try {
            $dto = (new CreerReservationDTOBuilder())
                ->setSalleId($data['salle_id'])
                ->setResponsable($data['responsable'])
                ->setEmail($data['email'])
                ->setMotif($data['motif'])
                ->setDateDebut(new DateTimeImmutable($data['date_debut']))
                ->setDateFin(new DateTimeImmutable($data['date_fin']))
                ->build();
            $reservation = $this->creation->executer($dto);
        } catch (SalleIndisponibleException $exception) {
            return $this->create($data, ['global' => $exception->getMessage()]);
        }

        return $this->redirect('/reservations/' . $reservation->id);
    }

    public function cancel(int $id): string
    {
        try {
            $this->annulation->executer($id);
        } catch (\RuntimeException) {
            return $this->notFound();
        }

        return $this->redirect('/reservations/' . $id);
    }

    private function validateInput(array $input): array
    {
        $data = [
            'salle_id' => filter_var($input['salle_id'] ?? null, FILTER_VALIDATE_INT),
            'responsable' => trim((string) ($input['responsable'] ?? '')),
            'email' => trim((string) ($input['email'] ?? '')),
            'motif' => trim((string) ($input['motif'] ?? '')),
            'date_debut' => $this->normalizeDate($input['date_debut'] ?? ''),
            'date_fin' => $this->normalizeDate($input['date_fin'] ?? ''),
        ];
        $result = $this->validator->validate($data);
        return [$data, $result->isValid() ? [] : $result->errors()];
    }

    private function normalizeDate(mixed $value): string
    {
        $value = trim((string) $value);
        return str_replace('T', ' ', $value) . (strlen($value) === 16 ? ':00' : '');
    }

    private function redirect(string $path): string
    {
        header('Location: ' . $path, true, 303);
        return '';
    }

    private function notFound(): string
    {
        http_response_code(404);
        return $this->renderView('error/404', ['title' => 'Page introuvable']);
    }
}
