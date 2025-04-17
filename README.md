# Test pour HelloCSE

## Installation

Projet utilisant Laravel 11, PHP 8.3 et SqlLite.

Depuis la racine du projet, executer : `composer install`

Puis : `php artisan migrate`

et : `php artisan key:generate`

enfin : `php artisan storage:link`

### Creation de la base de test

Depuis la racine du projet, executer : `touch database/test.sqlite` pour créer la base de test.

Puis executer : `php artisan migrate --env=testing`

### Creation de l'administrateur

Executer : `php artisan db:seed`

## Utilisation

L'administrateur créé a comme information : 
```
Login : test
Mot de passe : hello%cse
```

Pour chaque appel API qui necessite une authentification, il faut passer comme Header `Authorization: Bearer <token>`, le token étant fourni au login.

## Note sur les tests

J'ai préféré faire des tests fonctionnels plutôt qu'unitaires, pour les différents endpoints, afin de couvrir l'ensemble de la logique de l'application.

## Documentation

La documentation de l'API est disponible ici, au format OpenAPI (Swagger) : [/api/documentation](/api/documentation)
