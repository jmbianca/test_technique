# Test pour HelloCSE

## Installation

### Creation de la base de test

Depuis la racine du projet, executer : `touch database/test.sqlite` pour créer la base de test.

Creer un fichier `.env.testing` avec les infos suivantes :
```
DB_CONNECTION=sqlite
DB_DATABASE=database/test.sqlite
```

Puis executer : `php artisan migrate --env=testing`

### Creation de l'administrateur

Executer : `php artisan tinker`

Puis : `\App\Models\Administrateur::factory()->create();`

Puis : `exit`

## Utilisation

L'utilisateur créé a comme information : 
```
Login : test
Mot de passe : hello%cse
```

Pour chaque appel API qui necessite une authentification, il faut passer comme Header `Authorization: Bearer <token>`, le token étant fourni au login.

## Note sur les tests

J'ai préféré faire des tests fonctionnels plutôt qu'unitaires, pour les différents endpoints, afin de couvrir l'ensemble de la logique de l'application.

## Documentation

La documentation de l'API est disponible ici, au format OpenAPI (Swagger) : [/api/documentation](/api/documentation)
