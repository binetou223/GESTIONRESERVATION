<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
require_once __DIR__ . '/../../vendor/autoload.php';
$capsule = require_once dirname(__DIR__) . '/../config/database.php';
if (!$capsule->schema()->hasTable('reservation')) {
    $capsule->schema()->create('reservation', function (Blueprint $table) {
        $table->increments('id');
        $table->string('nom_utilisateur');
        $table->string('email_utilisateur');
        $table->string('motif_reservation');
        $table->dateTime('date_debut');
        $table->dateTime('date_fin');
        $table->string('status')->default('confirme');
        $table->foreignId('salle_id')->constrained('salle');
        $table->timestamps();
    });
    echo "Table 'reservation' créée avec succès.";
} else
 {
    echo "La table 'reservation' existe déjà.";
}