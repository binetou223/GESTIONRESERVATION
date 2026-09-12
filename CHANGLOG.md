# Changelog

Historique des versions du projet Gestion de réservation.
## [V0.0.0] - 2026-09-05

- Création initiale du projet.
- 
## [V0.1.0] - 2026-09-05

- Installation des dépendances Composer.
- Configuration de l'autoloading PSR-4.
- Ajout de Dotenv, Eloquent, FastRoute et Respect Validation.
  
## [V0.2.0] - 2026-09-06

- Création des migrations des tables `salle` et `reservation`.
- Ajout de la relation entre les réservations et les salles.

## [V0.3.0] - 2026-09-07

- Création des modèles `Salle` et `Reservation`.
- Définition des attributs remplissables et des conversions de types.
- Mise en place de la relation salle/réservations.

## [V0.4.0] - 2026-09-07

- Initialisation des données.
- Ajout du script de seed des salles.


## [V0.5.0] - 2026-09-07

- Mise en place de la validation des données.
- Ajout des validateurs de salles et de réservations.
- Ajout des résultats de validation.



## [V0.6.0] - 2026-09-07

- Création des DTO.
- Ajout des builders pour les salles et les réservations.

## [V0.7.0] - 2026-09-08

- Mise en place de l'accès aux données avec les repositories Eloquent.
- Ajout des interfaces de repositories.
- Ajout des opérations de lecture et d'écriture.

## [V0.8.0] - 2026-09-08

- Implémentation des règles métier.
- Vérification de la disponibilité des salles.
- Gestion des conflits et de l'annulation des réservations.


## [V0.8.1] - 2026-09-08

- Configuration de la publication des images Docker vers Docker Hub.
- Publication automatisée des tags GitHub avec GitHub Actions.

## [V0.9.0] - 2026-09-08

- Mise en place des vues.
- Création des contrôleurs des salles et des réservations.
- Ajout des formulaires et des pages d'erreur

## [V0.10.0] - 2026-09-09

- Mise en place du routeur avec FastRoute.
- Ajout des routes pour les salles et les réservations.


## [V0.10.1] - 2026-09-09

- Adaptation du routeur.
- Ajout de tests du routage.
- Gestion des routes introuvables et des méthodes non autorisées.

## [V0.10.2] - 2026-09-09

- Déplacement de la configuration du routeur hors de `public/index.php`.
- Séparation de la définition des routes et de l'exécution du dispatch.


## [V0.11.0] - 2026-09-09

- Mise en place du conteneur d'injection de dépendances avec PHP-DI.
- Configuration des repositories, validateurs, services, Eloquent et FastRoute.
- Centralisation de la création des dépendances.

## [V0.12.0] - 2026-09-10

- Ajout des tests unitaires des services.
- Ajout des tests de validation.
- Ajout des tests d'intégration avec SQLite en mémoire.
- Ajout de faux repositories pour les tests unitaires.

## [V0.13.0] - Finalisation

- Finalisation de l'injection de dépendances.
- Amélioration de la gestion des erreurs.
- Ajout du démarrage Docker avec migrations automatiques.
- Mise à jour de la documentation et du diagramme de classes.


