<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();

// Chemin vers le certificat CA (requis par Aiven pour la connexion SSL).
// Peut être surchargé via la variable d'environnement DB_SSL_CA si besoin.
$sslCaPath = $_ENV['DB_SSL_CA'] ?? __DIR__ . '/ssl/aiven-ca.pem';

$pdoOptions = [];
if (($_ENV['DB_SSL_ENABLED'] ?? 'true') === 'true' && file_exists($sslCaPath)) {
    $pdoOptions = [
        PDO::MYSQL_ATTR_SSL_CA => $sslCaPath,
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
    ];
}

$capsule->addConnection([
    'driver'=>$_ENV['DB_DRIVER'],
    'host'=>$_ENV['DB_HOST'],
    'port'=>$_ENV['DB_PORT'],
    'database'=>$_ENV['DB_DATABASE'],
    'username'=>$_ENV['DB_USERNAME'],
    'password'=>$_ENV['DB_PASSWORD'],
    'options' => $pdoOptions,
]);

$capsule->setAsGlobal();

$capsule->bootEloquent();

return $capsule;