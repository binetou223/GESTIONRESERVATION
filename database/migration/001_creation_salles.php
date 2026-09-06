<?php
use illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
require_once __DIR__ . '/../../vendor/autoload.php';
$capsule = require_once dirname(__DIR__) . '/../config/database.php';
if (!$capsule->schema()->hasTable('salle')) {
    $capsule->schema()->create('salle', function (Blueprint $table) {
        $table->increments('id');
        $table->string('nom');
        $table->string('batiment');
        $table->integer('capacite');
        $table->string('type');
        $table->boolean('active')->default(true);
        $table->timestamps();
    });
    echo "Table 'salle' créée avec succès.";
} else {
    echo "La table 'salle' existe déjà.";
}