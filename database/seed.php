<?php 
require_once dirname(__DIR__)."/vendor/autoload.php";
require_once dirname(__DIR__)."/config/database.php";
use App\Model\Salle;
$salles = [
    [
        'nom' => 'Amphitheatre ',
        'batiment' => 'A',
        'capacite' => 40,
        'type' => 'Conférence',
        'active' => true,
    ],
    [
        'nom' => 'Salle B12',
        'batiment' => 'B',
        'capacite' => 40,
        'type' => 'Cours',
        'active' => true,
    ],
    [
        'nom' => 'Laboratoire Chimie',
        'batiment' => 'C',
        'capacite' => 24,
        'type' => 'Formation',
        'active' => false,
    ],
     [
        'nom' => 'Salle informatique 1',
        'batiment' => 'D',
        'capacite' => 30,
        'type' => 'cours informatique',
        'active' => true,
    ],
    [
        'nom' => 'Salle de réunion ',
        'batiment' => 'E',
        'capacite' => 12,
        'type' => 'Réunion',
        'active' => false,
    ]
];
foreach ($salles as $salleData) {
    Salle::create($salleData);
}