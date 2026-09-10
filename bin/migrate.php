<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

try {
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->safeLoad();

    $migrationFiles = glob(dirname(__DIR__) . '/database/migration/*.php');
    if ($migrationFiles === false) {
        throw new RuntimeException('Impossible de lire le dossier des migrations.');
    }

    sort($migrationFiles);
    foreach ($migrationFiles as $migrationFile) {
        require $migrationFile;
    }
} catch (\Throwable $exception) {
    fwrite(STDERR, "Erreur pendant les migrations : {$exception->getMessage()}\n");
    exit(1);
}