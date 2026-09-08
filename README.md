. Quel est le rôle de Composer ?
Composer est le gestionnaire de dépendances de PHP.
Il permet principalement de :
installer les bibliothèques dont ton projet a besoin ;
gérer leurs versions ;
installer automatiquement les dépendances nécessaires à ces bibliothèques ;
générer l'autoloading PSR-4, pour éviter de faire des require_once sur chaque classe.

  Quelle différence existe entre require et require-dev ? 


 Pourquoi faut-il versionner composer.lock ? 

 parce que composer.lock contient les versions exactes des dépendances installées.

 Pourquoi ne versionne-t-on pas vendor/ ? 
 Le dossier vendor/ contient toutes les bibliothèques téléchargées par Composer.
 Il peut devenir très volumineux et contient des fichiers qui sont générés automatiquement.


  Quel rôle joue Capsule\Manager ?
 Pourquoi Eloquent peut-il fonctionner sans Laravel ?
 Où doit se trouver le démarrage de l’ORM ?
 Quelle différence existe entre ORM et SQL écrit à la main ?

## Lancer avec Docker

Pré-requis : Docker et Docker Compose.

```bash
docker compose up --build
```

L'application est ensuite disponible sur http://localhost:8080. Les migrations
sont exécutées automatiquement au démarrage et les données MySQL sont conservées
dans le volume `mysql_data`.

Pour arrêter les conteneurs :

```bash
docker compose down
```

## Publier l'image sur Docker Hub avec GitHub Actions

L'image Docker est publiée automatiquement lors de la création d'un tag GitHub.
Par exemple, le tag GitHub `v1.0.0` produit :

```text
binetou22/gestiondereservation:v1.0.0
```

Dans les paramètres du dépôt GitHub, ajoutez un secret `DOCKERHUB_TOKEN`
contenant un access token Docker Hub du compte `binetou22`. Le dépôt Docker Hub
`binetou22/gestiondereservation` doit exister avant le premier push.

Pour créer et publier une version :

```bash
git tag v1.0.0
git push origin v1.0.0
```

Pour publier les anciens tags, ouvrez le workflow `Publish Docker image` dans
GitHub Actions, cliquez sur `Run workflow`, puis lancez-le manuellement. Tous
les tags GitHub existants seront alors publiés sur Docker Hub.