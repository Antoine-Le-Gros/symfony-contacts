# Symfony Contacts

## Auteurs
Antoine Le Gros

## Installation et configuration

Pour installer le projet, fait un ``git clone https://iut-info.univ-reims.fr/gitlab/le-g0067/symfony-contacts.git`` 
Ensuite, vérifier que composer est installé avec ``composer --version``

## Documentation script

Lancez le serveur symfony :
```shell
composer start
```

Fixe le code PHP avec PHP CS Fixer :
```shell
composer fix:cs
```

Teste le code PHP avec PHP CS Fixer :
```shell
composer test:cs
```

Test la validité du code avec des tests en initialisant une base de données avant de lancer les tests :
```shell
composer test:codeception
```

Test les codes avec PHP CS Fixer et et sa validité avec Codeception :
```shell
composer test
```

Détruit une classe pour en recréer une et y insérer des entités générées aléatoirement
```shell
composer db
```

## Documentation de la configuration de la base de données Contact

Pour configurer la base de données, lancez la commande :
```shell
composer db
```

## Documentation identifiants et mots de passe

Les identifiants pour avoir le role Admin :
- prénom : Tony 
- nom : Stark 
- email : root@example.com

Les identifiants pour avoir le role User :
- prénom : Peter
- nom : Parker
- email : user@example.com
