<?php

namespace App\Controller;

use App\DTO\CreerSalleDTOBuilder;
use App\Repository\SalleRepositoryInterface;
use App\Validator\SalleValidator;

final class SalleController extends AbstractController
{
    public function __construct(
        private readonly SalleRepositoryInterface $salles,
        private readonly SalleValidator $validator,
    ) {
    }

    public function index(): string
    {
        return $this->renderView('salle/index', ['title' => 'Salles', 'salles' => $this->salles->lister()]);
    }

    public function show(int $id): string
    {
        $salle = $this->salles->retrouver($id);
        return $salle === null
            ? $this->notFound()
            : $this->renderView('salle/show', ['title' => $salle->nom, 'salle' => $salle]);
    }

    public function create(array $old = [], array $errors = []): string
    {
        return $this->renderView('salle/form', [
            'title' => 'Créer une salle',
            'action' => '/salles',
            'salle' => null,
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

        $dto = (new CreerSalleDTOBuilder())
            ->setNom($data['nom'])
            ->setBatiment($data['batiment'])
            ->setCapacite($data['capacite'])
            ->setType($data['type'])
            ->setActive($data['active'])
            ->build();

        $this->salles->enregistrer(new \App\Model\Salle([
            'nom' => $dto->nom,
            'batiment' => $dto->batiment,
            'capacite' => $dto->capacite,
            'type' => $dto->type,
            'active' => $dto->active,
        ]));

        return $this->redirect('/salles');
    }

    public function edit(int $id, array $old = [], array $errors = []): string
    {
        $salle = $this->salles->retrouver($id);
        if ($salle === null) {
            return $this->notFound();
        }

        return $this->renderView('salle/form', [
            'title' => 'Modifier une salle',
            'action' => "/salles/{$id}/update",
            'salle' => $salle,
            'old' => $old,
            'errors' => $errors,
        ]);
    }

    public function update(int $id, array $input): string
    {
        $salle = $this->salles->retrouver($id);
        if ($salle === null) {
            return $this->notFound();
        }

        [$data, $errors] = $this->validateInput($input);
        if ($errors !== []) {
            return $this->edit($id, $data, $errors);
        }

        $salle->fill($data);
        $this->salles->enregistrer($salle);
        return $this->redirect("/salles/{$id}");
    }

    private function validateInput(array $input): array
    {
        $data = [
            'nom' => trim((string) ($input['nom'] ?? '')),
            'batiment' => trim((string) ($input['batiment'] ?? '')),
            'capacite' => filter_var($input['capacite'] ?? null, FILTER_VALIDATE_INT),
            'type' => strtolower(trim((string) ($input['type'] ?? ''))),
            'active' => isset($input['active']) && (string) $input['active'] !== '0',
        ];
        $result = $this->validator->validate($data);
        return [$data, $result->isValid() ? [] : $result->errors()];
    }

    private function redirect(string $path): string
    {
        header('Location: ' . $path, true, 303);
        return '';
    }

    public function notFound(): string
    {
        http_response_code(404);
        return $this->renderView('error/404', ['title' => 'Page introuvable']);
    }

    public function methodNotAllowed(): string
    {
        http_response_code(405);
        header('Allow: GET, POST');
        return $this->renderView('error/405', ['title' => 'Méthode non autorisée']);
    }
}
