# Rapport d'API - Gestion des Sauces

## 1. Création du Contrôleur Sauces pour l'API

Afin de transformer la gestion des Sauces du projet en une API, la première étape a été de créer un nouveau contrôleur spécifique pour l'API. Cela permet de ne pas perdre l'ancienne version du contrôleur.

```php
php artisan make:controller Api/SaucesController
```

Cette commande génère un nouveau contrôleur SaucesController dans un sous-dossier Api, isolant ainsi les fonctionnalités liées à l'API des autres parties du projet.


## 2. Adaptation des Méthodes du Contrôleur

Ensuite, il a été nécessaire d'adapter chaque méthode du contrôleur existant afin de retourner des réponses au format JSON, au lieu d’utiliser des vues.

Par exemple, la méthode show dans le contrôleur initial était définie comme suit :

```php
    public function show($id_sauce)
    {
        $sauce = Sauces::where('id_sauce', $id_sauce)->firstOrFail();
        return view('sauces.show', compact('sauce'));
    }
```

Dans la nouvelle version API, elle a été modifiée pour retourner une réponse JSON, ainsi :

```php
    public function show($id_sauce)
    {
        $sauce = Sauces::find($id_sauce);
        if(!$sauce){
            return response()->json(["message"=> "Sauce inexistante"],404);
        }
        return response()->json($sauce);
    }
```
Ici, en cas de sauce inexistante, une réponse JSON avec un message d’erreur et un code HTTP 404 est renvoyée.
Si la sauce est trouvée, ses informations sont retournées au format JSON.


## 3. Définition des Routes API

Pour exposer les fonctionnalités de notre contrôleur API, il a fallu définir les routes correspondantes. Ces routes sont ajoutées dans le fichier routes/api.php afin de gérer les requêtes API sans interférer avec les routes web classiques.

```php
use App\Http\Controllers\Api\SaucesController;

Route::apiResource('sauces', SaucesController::class);
```
Cette ligne de code permet de créer automatiquement les routes RESTful dont nous avons besoin pour les méthodes index, store, show, update et destroy du contrôleur, facilitant ainsi la gestion des clients via des requêtes HTTP.

## 4. Test de l'API
Une fois les routes mises en place, il est possible de tester directement les requêtes GET dans l'URL de l'application en utilisant un navigateur ou un outil comme Postman. Par exemple, en accédant à l'URL suivante :
http://127.0.0.1:8000/api/sauces/1

La réponse JSON pour un client d'index de base de données 1 trouvé apparait.

Les tests ont également été effectués dans [Postman](https://www.postman.com/), un outil de test d'API, pour valider que le contrôleur renvoie bien les données attendues au format JSON. Cet outil a notammant permis la vérification des requêtes de type POST ou DELETE.
Un affichage de la liste complète des clients après coup permet de vérifier le fonctionnement de ces méthodes.


## Conclusion

L'API pour la gestion des sauces a été mise en place avec succès, permettant d'effectuer des opérations CRUD via des requêtes HTTP. Les tests effectués ont montré que les données des sauces sont correctement renvoyées en format JSON, et les erreurs sont gérées avec des codes de statut HTTP appropriés.
