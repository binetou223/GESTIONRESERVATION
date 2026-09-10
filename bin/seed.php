<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

try {
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->safeLoad();

    require dirname(__DIR__) . '/database/seed.php';
    echo "Seed exécuté avec succès.\n";
} catch (\Throwable $exception) {
    fwrite(STDERR, "Erreur pendant le seed : {$exception->getMessage()}\n");
    exit(1);
}