<?php
require_once dirname(__DIR__)."/vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
$capsule = require_once dirname(__DIR__) . '/config/database.php';

try {
    $capsule->getConnection()->getPdo();

    echo "Connexion à la base de données réussie !";
} catch (\Throwable $e) {
    echo "Erreur de connexion à la base de données.";
}