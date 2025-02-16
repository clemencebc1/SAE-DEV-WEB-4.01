# SAE-DEV-WEB-4.01
Groupe : Naima Akhtar *TD1*, Clémence Bocquet *TD2*, Nathan Randriantsoa *TD2*, Ophélie Valin *TD1*

## Introduction
IUTables'O recense des restaurants et les différents avis de leurs clients.

## Requirements
Pour lancer le projet, vous devez :
- posséder les installations PHP [https://www.php.net/manual/en/install.php]
- installer l'extension PDO pour PHP [https://www.php.net/manual/en/pdo.installation.php]
- installer l'extension POSTGRESQL pour la connexion avec Supabase [https://www.php.net/manual/en/pgsql.installation.php]


En ce qui concerne les tests :  
- installer composer [https://getcomposer.org/download/]
- installer PHPUnit via Composer [https://phpunit.de/getting-started/phpunit-9.html]

## Lancer les tests
Pour lancer les tests, vous devez (après avoir installer les dépendances nécessaires) : 
- se rendre à la racine du projet
- lancer les tests avec ``` ./vendor/bin/phpunit tests ```
- voir quels methodes passent ```./vendor/bin/phpunit --testdox tests```
- voir la couverture ```vendor/bin/phpunit --coverage-text --coverage-filter=templates/classes/model```

### Si vous obtenez une erreur
Si une erreur du type ``` Error: Class "classes\model\Departement" not found ``` : 
- vérifier le fichier composer.json, les classes doivent avoir le chemin "templates/classes/"
- recharger l'autoloader avec ```composer dump-autoload```
- lancer avec ```vendor/bin/phpunit --bootstrap vendor/autoload.php tests/```


## Annexe
- les données utilisées proviennent en partie de [https://www.data.gouv.fr/]
