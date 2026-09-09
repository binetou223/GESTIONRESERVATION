<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
require_once dirname(__DIR__, 2)."/vendor/autoload.php";
$capsule = require_once dirname(__DIR__, 2)."/config/database.php";
if (!$capsule->schema()->hasTable('reservation')) {
    $capsule->schema()->create('reservation', function (Blueprint $table) {
        $table->increments('id');
        $table->string('responsable');
        $table->string('email');
        $table->string('motif');
        $table->dateTime('date_debut');
        $table->dateTime('date_fin');
        $table->string('statut')->default('confirmée');
        $table->unsignedInteger('salle_id');
        $table->foreign('salle_id')->references('id')->on('salle');
        $table->timestamps();
    });
    echo "Table 'reservation' créée avec succès.";
} else
{
    echo "La table 'reservation' existe déjà.";
}