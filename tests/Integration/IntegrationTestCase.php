<?php

declare(strict_types=1);

namespace Tests\Integration;

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use PHPUnit\Framework\TestCase;

abstract class IntegrationTestCase extends TestCase
{
    protected Capsule $capsule;

    protected function setUp(): void
    {
        parent::setUp();

        $this->capsule = new Capsule();
        $this->capsule->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();

        $this->createTables();
    }

    private function createTables(): void
    {
        $schema = $this->capsule->schema();

        $schema->create('salle', static function (Blueprint $table): void {
            $table->increments('id');
            $table->string('nom');
            $table->string('batiment');
            $table->integer('capacite');
            $table->string('type');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        $schema->create('reservation', static function (Blueprint $table): void {
            $table->increments('id');
            $table->unsignedInteger('salle_id');
            $table->string('responsable');
            $table->string('email');
            $table->string('motif');
            $table->dateTime('date_debut');
            $table->dateTime('date_fin');
            $table->string('statut')->default('confirmée');
            $table->timestamps();
            $table->foreign('salle_id')->references('id')->on('salle');
        });
    }
}
