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