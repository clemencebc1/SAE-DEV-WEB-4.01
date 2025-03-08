# SAE 4.01 IUTables'O
Groupe : Naima Akhtar *TD1*, Clémence Bocquet *TD2*, Nathan Randriantsoa *TD2*, Ophélie Valin *TD1*

## Introduction
IUTables'O recense des restaurants d'Orléans et les différents avis de leurs clients. 

## Requirements
Afin de pouvoir utiliser l'application IUTables'O, vous devez :
- posséder les installations PHP : [Installation PHP](https://www.php.net/manual/en/install.php)
- installer l'extension PDO pour PHP : [Installation PDO PHP](https://www.php.net/manual/en/pdo.installation.php)
- installer l'extension POSTGRESQL pour la connexion avec Supabase : [Installation POSTGRESQL](https://www.php.net/manual/en/pgsql.installation.php)


En ce qui concerne les tests :  
- installer composer : [Installation Composer](https://getcomposer.org/download/)
- installer PHPUnit via Composer : [Installation PHPUnit](https://phpunit.de/getting-started/phpunit-9.html)

## Lancer le projet
Pour lancer l'application IUTables'O, vous devez :
+ se rendre à la racine du dossier templates/
+ démarrer un serveur PHP ```php -S localhost:8000```


## Lancer les tests
Pour lancer les tests, vous devez : 
- se rendre à la racine du projet
- lancer les tests avec ``` ./vendor/bin/phpunit tests ```
- voir quelles methodes passent ```./vendor/bin/phpunit --testdox tests```
- voir la couverture ```vendor/bin/phpunit --coverage-text --coverage-filter=templates/classes/model```

### Si vous obtenez une erreur
Si une erreur du type ``` Error: Class "classes\model\Departement" not found ``` : 
- vérifier le fichier composer.json, les classes doivent avoir le chemin "templates/classes/"
- recharger l'autoloader avec ```composer dump-autoload```
- lancer avec ```vendor/bin/phpunit --bootstrap vendor/autoload.php tests/```

## Les fonctionnalités implémentées
+ module d'inscription
+ module de connexion
+ module de recherche
+ module de visualisation des caractéristiques d'un restaurants (les meilleurs restaurants, par ordre alphabétique, en fonction des recherches)
+ plusieurs rôles admin/utilisateur
+ ajouter/modifier/supprimer une critique pour un utilisateur connecté
+ accéder à son profil en tant qu'utilisateur connecté (modifier nom, prénom, mot de passe, stats type préféré..)
+ lire les critiques et notes pour un restaurant
+ ajouter/supprimer des restaurants aux favoris pour un utilisateur connecté
+ supprimer des critiques pour un admin
+ Espace provider, téléverser un fichier JSON pour un admin

## Annexe
- les données utilisées proviennent en partie de [https://www.data.gouv.fr/]
