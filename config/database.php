<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();

$capsule->addConnection([
    'driver'=>$_ENV['DB_DRIVER'],
    'host'=>$_ENV['DB_HOST'],
    'port'=>$_ENV['DB_PORT'],
    'database'=>$_ENV['DB_DATABASE'],
    'username'=>$_ENV['DB_USERNAME'],
    'password'=>$_ENV['DB_PASSWORD'],
]);

$capsule->setAsGlobal();

$capsule->bootEloquent();

return $capsule;